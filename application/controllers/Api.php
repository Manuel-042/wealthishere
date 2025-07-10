<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('ion_auth');
        $this->load->model('api_model');
        $this->load->helper(['respond_helper', 'email_helper']);

        if ($this->uri->segment(1) !== 'api') {
            $this->is_loggedin();
        }
    }

    private function is_loggedin()
    {
        if (!$this->ion_auth->logged_in() || !$this->ion_auth->is_admin()) {
            redirect('login');
        }
    }

    /// WEALTH IS HERE APIS
    public function f4f_applications($status = "completed")
    {
        if ($this->input->method() !== 'post') {
            $this->output
                ->set_status_header(405)
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'Method Not Allowed']));
            return;
        }

        $object = json_decode(file_get_contents('php://input'), true);

        if (!$object || !is_array($object)) {
            return respond(400, 'Invalid JSON payload', "error");
        }

        // Map inputs
        $data = $object;

        $user = $this->ion_auth->user()->row();

        $existing_application = $this->api_model->existing_application($data, $user->id, 'f4f');

        if ($status === 'completed') {
            // Validate Team Lead Info
            $requiredTeamLeadFields = [
                'firstname',
                'lastname',
                'email',
                'phone',
                'gender',
                'date_of_birth',
                'posted_to',
                'education_qualification',
                'higher_institution',
                'is_first_business',
                'referred_by',
                'has_team_members',
                'attended_incubation',
                'nysc_batch',
                'nysc_state_code',
                'nysc_cds_day',
                'nysc_callup_number'
            ];

            $requiredFieldsCheck = $this->validateRequiredFields($data['team_lead'], $requiredTeamLeadFields);

            if (!$requiredFieldsCheck['status']) {
                return respond(400, 'Invalid input data. Ensure all required fields for Team Lead are filled.', 'error', $requiredFieldsCheck['errors']);
            }

            $requiredTeamLeadCheck = $this->validateTeamLead($data['team_lead']);

            if (!$requiredTeamLeadCheck['status']) {
                return respond(400, $requiredTeamLeadCheck['errorMsg'], 'error', );
            }

            // Validate Business Info
            $requiredBusinessFields = ['business_name', 'business_location', 'is_business_registered', 'business_start_date', 'business_stage', 'has_received_funding', 'has_partners', 'has_liabilities', 'problem_to_solve', 'business_solution', 'business_offerings', 'target_market', 'monetization_strategy', 'market_validation', 'business_competitors', 'business_uniqueness', 'competitive_advantage', 'business_motivation', 'business_vision', 'founder_strength', 'business_goals', 'business_challenges', 'business_support', 'self_involvement_lifespan'];

            $requiredFieldsCheck = $this->validateRequiredFields($data['business'], $requiredBusinessFields);

            if (!$requiredFieldsCheck['status']) {
                return respond(400, 'Invalid business info. Required fields missing.', 'error', $requiredFieldsCheck['errors']);
            }

            $businessCheck = $this->validateBusiness($data['business']);

            if (!$businessCheck['status']) {
                return respond(400, $businessCheck['errorMsg'], 'error', );
            }

            // Validate Team Members
            if (!$this->validateTeamMembers($data['team_members'])) {
                return respond(400, 'Team members info invalid or exceeds maximum allowed (3).', 'error', );
            }

            $data['application']['submission_status'] = 'completed';
        } else {
            $data['application']['submission_status'] = 'draft';
        }

        $data['application']['user_id'] = $user->id;

        $response = $existing_application ? $this->api_model->update_application($data, "f4f") : $this->api_model->save_application($data, "f4f");

        if (!$response) {
            log_message('error', 'Failed saving application: ' . json_encode($data));
            return respond(500, 'An error occurred while saving the application. Please try again or contact support.', 'error');
        }

        $application_end_date = $this->api_model->get_application_end_date($data['application']['application_id']);

        if (!$application_end_date) {
            log_message('error', 'An Error occured while fetching application end date');
            respond(500, 'An error occurred while saving the application. Please try again or contact support.', 'error');
        }

        $user_email = $user->email;
        $full_name = "{$user->last_name} {$user->first_name}";

        if ($status === 'completed') {
            $email_response = send_custom_email(
                $user_email,                                                    // recipient
                'You Did It! Your Application for Farmers for the Future is Complete ✅',                   // subject
                'auth/email/application_received',        // view
                ['full_name' => $full_name, 'application_end_date' => $application_end_date, 'type' => 'f4f']                                // view data
            );

            if ($email_response['status'] !== 200) {
                log_message('error', $response['debug']);
                return respond(200, 'Application submitted succesfully, but an error occured while sending email to user. Please contact support.', 'error');
            }
        } else {
            $email_response = send_custom_email(
                $user_email,                                                                           // recipient
                'Your Farmers for the Future Application is Still in Progress – Don’t Miss Out!',                   // subject
                'auth/email/application_draft_received',        // view
                ['full_name' => $full_name, 'application_end_date' => $application_end_date, 'type' => 'f4f']                                // view data
            );

            if ($email_response['status'] !== 200) {
                log_message('error', $response['debug']);
                return respond(200, 'Application submitted succesfully, but an error occured while sending email to user. Please contact support.');
            }
        }

        return respond(200, 'Application received successfully.');
    }


    public function gap_applications($status = 'completed')
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->output
                ->set_status_header(405)
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'Method Not Allowed']));
            return;
        }

        $payload = json_decode($_POST['payload'], true);

        if (!$payload || !is_array($payload)) {
            return respond(400, 'Invalid JSON payload');
        }

        $user = $this->ion_auth->user()->row();

        $existing_application = $this->api_model->existing_application($payload, $user->id, 'gap');

        log_message('error', 'Existing application' . $existing_application);

        if (isset($_FILES['image'])) {
            $config['upload_path'] = './uploads/certificates/';
            $config['allowed_types'] = 'jpg|jpeg|png|webp|pdf';
            $config['max_size'] = 2048;
            $config['encrypt_name'] = TRUE;

            $this->load->library('upload', $config);
            $this->upload->initialize($config);

            if (!$this->upload->do_upload('image')) {
                $error = $this->upload->display_errors();
                log_message('error', json_encode($error, true));
                return respond(400, $error, 'error');
            } else {
                $data = $this->upload->data();
                $certificate = 'uploads/certificates/' . $data['file_name'];
                $payload['team_lead']['certificatePath'] = $certificate;
            }
        }


        if ($status === 'completed') {
            // Validate Team Lead Info
            $requiredTeamLeadFields = [
                'firstname',
                'lastname',
                'email',
                'phone',
                'gender',
                'date_of_birth',
                'education_qualification',
                'higher_institution',
                'course_of_study',
                'faculty',
                'department',
                'graduation_year',
                'business_role',
                'is_first_business',
                'referred_by',
                'attended_incubation',
                'has_team_members',
            ];

            $requiredFieldsCheck = $this->validateRequiredFields($payload['team_lead'], $requiredTeamLeadFields);

            if (!$requiredFieldsCheck['status']) {
                return respond(400, 'Invalid input data. Ensure all required fields for Team Lead are filled.', 'error', $requiredFieldsCheck['errors']);
            }

            $requiredTeamLeadCheck = $this->validateTeamLead($payload['team_lead']);

            if (!$requiredTeamLeadCheck['status']) {
                return respond(400, $requiredTeamLeadCheck['errorMsg'], 'error');
            }

            // Validate Business Info
            $requiredBusinessFields = [
                'business_name',
                'business_location',
                'agriculture_field',
                'is_business_registered',
                'business_start_date',
                'business_stage',
                'business_achievements',
                'has_received_funding',
                'has_partners',
                'has_liabilities',
                'problem_to_solve',
                'business_solution',
                'business_offerings',
                'target_market',
                'monetization_strategy',
                'market_validation',
                'business_competitors',
                'business_uniqueness',
                'competitive_advantage',
                'business_motivation',
                'business_vision',
                'founder_strength',
                'business_goals',
                'business_challenges',
                'business_support',
                'self_involvement_lifespan'
            ];

            $requiredFieldsCheck = $this->validateRequiredFields($payload['business'], $requiredBusinessFields);

            if (!$requiredFieldsCheck['status']) {
                return respond(400, 'Invalid business info. Required fields missing.', 'error', $requiredFieldsCheck['errors']);
            }

            $businessCheck = $this->validateBusiness($payload['business']);

            if (!$businessCheck['status']) {
                return respond(400, $businessCheck['errorMsg'], 'error');
            }

            // Validate Team Members
            if (!$this->validateTeamMembers($payload['team_members'])) {
                return respond(400, 'Team members info invalid or exceeds maximum allowed (3).', 'error');
            }

            $data['application']['submission_status'] = 'completed';
        } else {
            $data['application']['submission_status'] = 'draft';
        }

        // All Valid — Save logic would go here
        //log_message('info', 'GAP Application received successfully: ' . var_export($payload, true));

        $payload['application']['user_id'] = $user->id;

        $response = $existing_application ? $this->api_model->update_application($payload, "gap") : $this->api_model->save_application($payload, "gap");

        if (!$response) {
            log_message('error', 'An error occurred while saving the application');
            return respond(500, 'An error occurred while saving the application. Please try again or contact support.', 'error');
        }

        $application_end_date = $this->api_model->get_application_end_date($payload['application']['application_id']);

        if (!$application_end_date) {
            log_message('error', 'An Error occured while fetching application end date');
            respond(500, 'An error occurred while saving the application. Please try again or contact support.', 'error');
        }

        $user_email = $user->email;
        $full_name = "{$user->last_name} {$user->first_name}";

        if ($status === 'completed') {
            $email_response = send_custom_email(
                $user_email,                                                                           // recipient
                'You Did It! Your Application for Graduate Agripreneur Program is Complete ✅',                   // subject
                'auth/email/application_received',        // view
                ['full_name' => $full_name, 'application_end_date' => $application_end_date, 'type' => 'gap']                                // view data
            );

            if ($email_response['status'] !== 200) {
                log_message('error', $response['debug']);
                return respond(200, 'Application submitted succesfully, but an error occured while sending email to user. Please contact support.');
            }
        } else {
            $email_response = send_custom_email(
                $user_email,                                                                           // recipient
                'Your Graduate Agripreneur Program Application is Still in Progress – Don’t Miss Out!',                   // subject
                'auth/email/application_draft_received',        // view
                ['full_name' => $full_name, 'application_end_date' => $application_end_date, 'type' => 'gap']                                // view data
            );

            if ($email_response['status'] !== 200) {
                log_message('error', $response['debug']);
                return respond(200, 'Application submitted succesfully, but an error occured while sending email to user. Please contact support.');
            }
        }

        return respond(200, 'Application received successfully.');
    }

    private function validateRequiredFields($data, $requiredFields)
    {
        $errors = [];

        foreach ($requiredFields as $field) {
            if (empty($data[$field])) {
                $errors[] = $field;
            }
        }

        $status = empty($errors);

        return ['status' => $status, 'errors' => $errors];
    }


    private function validateTeamLead($data)
    {
        $errorMsg = '';

        // Validate email
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
            $errorMsg = 'Email should be a valid email address';
            return ['status' => false, 'errorMsg' => $errorMsg];
        }

        // Validate phone number
        if (!preg_match('/^\+?[0-9]{10,15}$/', $data['phone'])) {
            $errorMsg = 'Phone number should contain only numbers and be 10-15 digits long';
            return ['status' => false, 'errorMsg' => $errorMsg];
        }

        // Optional social links validation
        $urls = ['facebook_url', 'linkedIn_url'];
        foreach ($urls as $link) {
            if (!empty($data[$link]) && !filter_var($data[$link], FILTER_VALIDATE_URL)) {
                $errorMsg = ucfirst(str_replace('_', ' ', $link)) . ' must be a valid URL';
                return ['status' => false, 'errorMsg' => $errorMsg];
            }
        }

        return ['status' => true, 'errorMsg' => $errorMsg];
    }

    private function validateBusiness($data)
    {
        $errorMsg = '';

        if (!empty($data['business_website']) && !filter_var($data['business_website'], FILTER_VALIDATE_URL)) {
            $errorMsg = 'Business website should be a vaid URL';
            return ['status' => false, 'errorMsg' => $errorMsg];
        }

        return ['status' => true, 'errorMsg' => $errorMsg];
    }

    private function validateTeamMembers($team_members)
    {
        if (empty($team_members))
            return true;
        if (count($team_members) > 3)
            return false;

        foreach ($team_members as $member) {
            if (!empty($member['email']) && !filter_var($member['email'], FILTER_VALIDATE_EMAIL)) {
                return false;
            }
            if (!empty($member['phone']) && !preg_match('/^\+?[0-9]{10,15}$/', $member['phone'])) {
                return false;
            }
        }

        return true;
    }

    public function previous_applications()
    {
        if ($this->input->method() !== 'post') {
            $this->output
                ->set_status_header(405)
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'Method Not Allowed']));
            return;
        }

        $object = json_decode(file_get_contents('php://input'), true);

        if (!$object || !is_array($object)) {
            return respond(400, 'Invalid JSON payload');
        }

        $success = 0;
        $failed = 0;
        $errors = [];

        foreach ($object as $index => $appData) {
            if (!isset($appData['application']) || !isset($appData['team_lead']) || !isset($appData['business'])) {
                $failed++;
                $errors[] = "Missing application/team_lead/business in entry index $index";
                continue;
            }

            $response = $this->api_model->save_previous_applications($appData);

            if (!$response) {
                $failed++;
                $errors[] = "Failed to save application at index $index";
            } else {
                $success++;
            }
        }

        return respond(200, "Processed $success applications, $failed failed.", 'message', $errors);
    }

    public function newsletter()
    {
        if ($this->input->method() !== 'post') {
            $this->output
                ->set_status_header(405)
                ->set_content_type('application/json')
                ->set_output(json_encode(['error' => 'Method Not Allowed']));
            return;
        }

        $body = file_get_contents('php://input');
        $object = json_decode($body, true);

        $email = trim($object['email']);

        $response = $this->api_model->submit_email_newsletter($email);

        if ($response === -1) {
            respond(400, 'This email is already registered for our newsletter', 'error');
        } else if ($response) {
            respond(200, 'You have successfully registered for our newsletter');
        } else {
            respond(500, 'An Error occured during registration, Please try again or contact support', "error");
        }

    }

    public function contact_us()
    {
        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            // Get form data
            $input = json_decode(file_get_contents("php://input"), true);

            if (!$input) {
                respond(400, 'Invalid input data', 'error');
                exit;
            }

            // Sanitize and extract values
            $fullName = htmlspecialchars($input['fullName'] ?? '');
            $email = htmlspecialchars($input['email'] ?? '');
            $phone = htmlspecialchars($input['phone'] ?? '');
            $message = htmlspecialchars($input['message'] ?? '');

            // Validate email
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                respond(400, 'Invalid Email', 'error');
                exit;
            }

            // Email configuration
            $to = $this->config->item('contact_email', 'ion_auth');
            $subject = "New Contact Form Submission from " . $fullName;


            $email_response = send_custom_email($to, $subject, 'auth/email/contact_us', ['fullName' => $fullName, 'email' => $email, 'phone' => $phone, 'message' => $message]);

            // Send email
            if ($email_response['status'] == 200) {
                respond(200, 'Email sent succesfully');
            } else {
                respond(500, 'Failed to send email', 'error');
            }
        } else {
            respond(405, 'Method not allowed', 'error');
        }
    }
}