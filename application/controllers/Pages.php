<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Pages extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->library('session');
        $this->load->library('ion_auth');
    }

    public function view($page = 'index') // fallback to 'index'
    {
        if (!file_exists(APPPATH . 'views/pages/' . $page . '.php')) {
            show_404(); // show 404 if the view doesn't exist
        }

        $data['title'] = ucfirst(str_replace('-', ' ', $page)); // Optional

        $this->load->view('layout/header', $data);
        $this->load->view("pages/{$page}", $data);
        $this->load->view('layout/footer', $data);
    }
}
