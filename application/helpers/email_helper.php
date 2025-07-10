<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if (!function_exists('send_custom_email')) {
    function send_custom_email($to, $subject, $view, $data = [], $from = 'batnfadmin@batnf.net')
    {
        $CI =& get_instance();
        $CI->load->library('email');

        // Set config (optional, can also use config/email.php)
        $CI->email->set_newline("\r\n");
        $CI->email->set_crlf("\r\n");
        $CI->email->from($from);
        $CI->email->to($to);
        $CI->email->subject($subject);

        // Load HTML email body from view
        $body = $CI->load->view($view, $data, TRUE);
        $CI->email->message($body);
        $CI->email->validate = true;

        if ($CI->email->send()) {
            return [
                'status' => 200,
                'message' => 'Email sent successfully'
            ];
        } else {
            return [
                'status' => 500,
                'error' => 'Email failed to send',
                'debug'  => $CI->email->print_debugger(['headers'])
            ];
        }
    }
}
