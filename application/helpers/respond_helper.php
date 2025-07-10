<?php
defined('BASEPATH') or exit('No direct script access allowed');

function respond($status_code, $message, $type = 'message', $extra_data = [])
{
    $CI =& get_instance();

    if (!is_array($extra_data)) {
        $extra_data = ['extra_info' => $extra_data]; 
    }

    $response_key = ($type === 'error') ? 'error' : 'message';

    $CI->output
        ->set_status_header($status_code)
        ->set_content_type('application/json')
        ->set_output(json_encode(array_merge([$response_key => $message], $extra_data)));
}