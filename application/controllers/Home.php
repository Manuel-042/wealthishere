<?php
defined('BASEPATH') or exit('No direct script access allowed');
date_default_timezone_set('Africa/Lagos');

class Home extends CI_Controller
{
    public function __construct()
    {
        parent::__construct();
        $this->load->model('api_model');
        $this->load->library('session');
        $this->load->library('ion_auth');
    }

    public function index()
    {
        $data['title'] = 'Home Page';

        $this->load->view('layout/header', $data);
        $this->load->view('pages/index', $data);
        $this->load->view('layout/footer', $data);
    }

    public function apply($type)
    {
        $data['title'] = $type === 'f4f' ? 'Farmers for the Future Grant' : 'Graduate Agriprineur Program';
        $data['form_data'] = [];
        $data['application_status'] = "";

        $application_status = $this->api_model->application_status($type);

        if ($application_status === 'open') {
            $data['application_status'] = 'open';

            if (!$this->ion_auth->logged_in()) {
                $intended_url = $_SERVER['REQUEST_URI'];
                $base_path = parse_url(base_url(), PHP_URL_PATH);
                $redirect_path = str_replace($base_path, '/', $intended_url);
                $this->session->set_userdata('redirect_after_login', $redirect_path);
                redirect('login');
            }

            $user_id = $this->ion_auth->get_user_id();
            $data['user_email'] = $this->ion_auth->user()->row()->email;
            $current_app = $this->api_model->get_current_application($type);
            $current_app_id = $current_app['id'];

            //$draft = $this->api_model->get_user_draft($user_id, $current_app_id, $type);
            $user_application = $this->api_model->get_applications(null, $type, $user_id);

            log_message('error', 'Draft: ' . var_export($user_application, true));

            $user_application_status = $this->api_model->get_user_application_status($user_id, $current_app_id, $type);

            $data['user_submission_status'] = "";
            $data['user_review_status'] = "";

            $now = date('Y-m-d H:i:s');

            $startsAt = $current_app['starts_at'] ?? null;
            $endsAt = $current_app['ends_at'] ?? null;

            $data['application_start'] = false;

            if ($user_application_status) {
                $data['user_submission_status'] = $user_application_status['submission_status'];
                $data['user_review_status'] = $user_application_status['review_status'];
            }

            if ($startsAt && $endsAt && $now >= $startsAt && $now <= $endsAt) {
                $data['application_start'] = true;
            }

            log_message('error', 'APplication status: ' . $data['application_start']);

            //log_message('error', "Draft: " . var_export($draft, true));

            if (!$current_app_id) {
                log_message('error', 'No current application id');
                $data['current_app_id'] = -1;
            }

            if (!empty($user_application)) {
                $data['current_app_id'] = $current_app_id;
                $data['form_data'] = $user_application[0];
            } else {
                $data['current_app_id'] = $current_app_id;
                $data['form_data'] = [];
            }
        } else {
            $data['application_status'] = "closed";
        }

        $this->load->view('layout/header', $data);
        $this->load->view("pages/{$type}-apply", $data);
        $this->load->view('layout/footer', $data);
    }

    public function support()
    {
        $email = '';
        $phone = '';
        $fullname = '';

        if ($this->ion_auth->logged_in()) {
            $user = $this->ion_auth->user()->row();
            $email = $user->email;
            $phone = $user->phone;
            $fullname = "{$user->first_name} {$user->last_name}";
        };

        $data = [
            'title' => 'Contact us',
            'email' => $email,
            'phone' => $phone,
            'fullname' => $fullname,
        ];

        $support = $this->api_model->support_qna();

        if ($support) {
            $data = array_merge($data, $support);
        }

        $this->load->view('layout/header', $data);
        $this->load->view("pages/contact-us", $data);
        $this->load->view('layout/footer', $data);
    }
}
