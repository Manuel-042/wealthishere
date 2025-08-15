<?php
defined('BASEPATH') or exit('No direct script access allowed');

/**
 * @property CI_URI uri
 * @property CI_Input input
 * @property CI_Output output
 * @property CI_Config config
 * @property CI_Loader load
 * @property CI_Upload upload
 * @property CI_DB_query_builder db
 * @property CI_Session session
 * @property Ion_auth ion_auth
 * @property Api_model api_model
 * @property CI_DB db
 * @property CI_Form_validation $form_validation
 */
class Api extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('ion_auth');
        $this->load->library('form_validation');
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

        // Check if application is ongoing
        $is_application_ongoing_response = $this->api_model->is_application_ongoing($data['application']['application_id'], 'f4f');

        log_message('error', 'is application ongoing: ' . $is_application_ongoing_response);

        if (!$is_application_ongoing_response) {
            log_message('error', 'This application has ended');
            return respond(400, 'This application has ended', "error");
        }

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
                return respond(400, $requiredTeamLeadCheck['errorMsg'], 'error');
            }

            // Validate Business Info
            $requiredBusinessFields = ['business_name', 'business_location', 'is_business_registered', 'business_start_date', 'business_stage', 'has_received_funding', 'has_partners', 'has_liabilities', 'problem_to_solve', 'business_solution', 'business_offerings', 'target_market', 'monetization_strategy', 'market_validation', 'business_competitors', 'business_uniqueness', 'competitive_advantage', 'business_motivation', 'business_vision', 'founder_strength', 'business_goals', 'business_challenges', 'business_support', 'self_involvement_lifespan'];

            $requiredFieldsCheck = $this->validateRequiredFields($data['business'], $requiredBusinessFields);

            if (!$requiredFieldsCheck['status']) {
                return respond(400, 'Invalid business info. Required fields missing.', 'error', $requiredFieldsCheck['errors']);
            }

            $businessCheck = $this->validateBusiness($data['business']);

            if (!$businessCheck['status']) {
                return respond(400, $businessCheck['errorMsg'], 'error');
            }

            // Validate Team Members
            if (!$this->validateTeamMembers($data['team_members'])) {
                return respond(400, 'Team members info invalid or exceeds maximum allowed (3).', 'error');
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

        // Check if application is ongoing
        $is_application_ongoing_response = $this->api_model->is_application_ongoing($payload['application']['application_id'], 'gap');

        if (!$is_application_ongoing_response) {
            return respond(400, 'This application has ended', "error");
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

        if ($response === "EMAIL_ALREADY_REGISTERED") {
            respond(400, 'This email is already registered for our newsletter', 'error');
        } else if ($response) {
            respond(200, 'You have successfully registered for our newsletter');
        } else {
            respond(500, 'An Error occured during registration, Please try again or contact support', "error");
        }
    }

    public function contact_us()
    {
        $this->form_validation->set_rules('fullName', 'Full Name', 'required');
        $this->form_validation->set_rules('email', 'Email', 'required');
        $this->form_validation->set_rules('phone', 'Phone', 'required|regex_match[/^(\+?[1-9]\d{0,3})?[0-9]{7,15}$/]', array('regex_match' => 'Please enter a valid phone number'));
        $this->form_validation->set_rules('category', 'Category', 'required');
        // $this->form_validation->set_rules('question', 'Question', 'required');

        if ($this->form_validation->run() == FALSE) {
            // log_message('error', 'Validation errors: ' . var_export($this->form_validation->error_array(), true));
            $this->session->set_flashdata('validation_errors', $this->form_validation->error_array());
            $this->session->set_flashdata('old_input', $this->input->post());
            redirect('contact-us');
        } else {
            $fullName       = $this->input->post('fullName', true) ?? null;
            $email          = $this->input->post('email', true) ?? null;
            $phone          = $this->input->post('phone', true) ?? null;
            $questionAnswer = $this->input->post('question', true) ?? null;
            $questionVal    = $this->input->post('selected_question', true) ?? null;
            $customMessage  = $this->input->post('message', true) ?? null;
            $category_id    = $this->input->post('category', true) ?? null;
            $questionID    = $this->input->post('question_id', true); 
            
            $question_id = (!empty($questionID)) ? $questionID : NULL;

            // log_message("error", "category id: {$category_id}, question id: {$question_id}");

            $isOthers = $category_id == '6';
            $responseMessage = $isOthers ? "Others" : $questionAnswer;
            $question = $isOthers ? $customMessage : $questionVal;

            $support_log = [
                'name' => $fullName,
                'email' => $email,
                'category_id' => $category_id,
                'question_id' => $question_id,
                'custom_message' => $customMessage
            ];

            $log = $this->api_model->log_support($support_log);

            if (!$log) {
                $this->session->set_flashdata('error', 'An Error occured while logging support');
                $this->session->set_flashdata('old_input', $this->input->post());
                redirect('contact-us');
            }

            $user_id = $this->ion_auth->get_user_id() ?? 0;

            $email_data = [
                'fullname' => $fullName,
                'phone' => $phone,
                'question' => $question,
                'answer' => $responseMessage
            ];

            log_message('error', 'Email Data: ' . var_export($email_data, true));

            $subject = 'Thank You for Contacting the YEEP Team!';

            $data2 = [
                'user_id' => $user_id,
                'recipient' => $email,
                'subject' => $subject,
                'template_file' => 'support_email.php',
                'dynamic_data' => json_encode($email_data),
                'status' => 'pending',
                'created_at' => date('Y-m-d H:i:s'),
            ];

            // save to DB queue, etc.
            $response = $this->api_model->queue_support_email($data2);

            if (!$response) {
                $this->session->set_flashdata('error', 'An error occured while queing support email');
                $this->session->set_flashdata('old_input', $this->input->post());
                redirect('contact-us');
            }

            if ($isOthers) {
                $subject2 = 'New Contact Form Submission!';
                $email_data2 = ['fullName' => $fullName, 'email' => $email, 'phone' => $phone, 'message' => $customMessage];
                $to = $this->config->item('contact_email', 'ion_auth');

                $data3 = [
                    'user_id' => $user_id,
                    'recipient' => $to,
                    'subject' => $subject2,
                    'template_file' => 'contact_us.php',
                    'dynamic_data' => json_encode($email_data2),
                    'status' => 'pending',
                    'created_at' => date('Y-m-d H:i:s'),
                ];

                // save to DB queue, etc.
                $response2 = $this->api_model->queue_support_email($data3);

                if (!$response2) {
                    $this->session->set_flashdata('error', 'An error occured while queing support email');
                    $this->session->set_flashdata('old_input', $this->input->post());
                    redirect('contact-us');
                }
            }

            $this->session->set_flashdata("success", "Your message has been sent successfully. Keep an eye on your email, we'll be in touch soon.");
            redirect('contact-us');
        }
    }

    public function resend()
    {
        $data['title'] = 'Resend Activation Email';

        $this->load->view('layout/header', $data);
        $this->load->view('pages/resend', $data);
        $this->load->view('layout/footer');
    }


    public function resend_activation_mail()
    {
        $offset = (int) $this->input->get('offset');
        $limit = (int) $this->input->get('limit') ?: 100;

        $result = $this->api_model->resend_activation_email_batch($offset, $limit);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function send_custom_email()
    {
        $offset = (int) $this->input->get('offset');
        $limit = (int) $this->input->get('limit') ?: 100;

        $result = $this->api_model->send_custom_email($offset, $limit);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function send_custom_confirm_email()
    {
        $offset = (int) $this->input->get('offset');
        $limit = (int) $this->input->get('limit') ?: 100;

        $result = $this->api_model->send_custom_confirm_email($offset, $limit);

        $this->output
            ->set_content_type('application/json')
            ->set_output(json_encode($result));
    }

    public function f4f_application($user_id)
    {
        $data['title'] = 'Farmers For The Future - Applications';

        $result = $this->api_model->get_applications(null, 'f4f', $user_id);

        if (!$result) {
            $data['application'] = [];
        } else {
            $data['application'] = $result[0];

            log_message('error', 'Application: ' . var_export($data['application'], true));

            $is_application_ongoing_response = $this->api_model->is_application_ongoing($data['application']['main_application_id'], 'f4f');

            if (!$is_application_ongoing_response) {
                $data['is_ongoing'] = false;
            } else {
                $data['is_ongoing'] = $is_application_ongoing_response;
            }
        }

        $this->load->view('layout/header', $data);
        $this->load->view('pages/f4f-application', $data);
        $this->load->view('layout/footer');
    }
    public function gap_application($user_id = null)
    {
        $data['title'] = 'Graduate Agripreneur Program - Applications';

        $result = $this->api_model->get_applications(null, 'gap', $user_id);

        if (!$result) {
            $data['application'] = [];
        } else {
            $data['application'] = $result[0];
        }

        $this->load->view('layout/header', $data);
        $this->load->view('pages/gap-application', $data);
        $this->load->view('layout/footer');
    }

    public function support_questions()
    {
        $category_id = $this->input->get('category_id');
        $questions = $this->api_model->get_by_category($category_id);
        return respond(200, $questions, 'message');
    }
}
