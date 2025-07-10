<?php
defined('BASEPATH') or exit('No direct script access allowed');

class Cron extends CI_Controller
{

    public function __construct()
    {
        parent::__construct();
        $this->load->database();
        $this->load->library('ion_auth');
        $this->load->model('api_model');
    }


    public function deactivate_applications()
    {
        $this->db->trans_begin();

        $select_sql = "SELECT id FROM application_status
                   WHERE status = 'open' AND ends_at < NOW()";

        $select_query = $this->db->query($select_sql);

        if ($select_query === FALSE) {
            $this->db->trans_rollback();
            log_message('error', 'Error executing select query: ' . $this->db->last_query());
            return;
        }

        $application_ids = array_column($select_query->result_array(), 'id');

        if (empty($application_ids)) {
            log_message('error', "No expired applications to deactivate.");
            $this->db->trans_complete();
            return;
        }

        $this->db->where_in('id', $application_ids);
        $this->db->update('application_status', ['status' => 'closed']);

        if ($this->db->affected_rows() <= 0) {
            $this->db->trans_rollback();
            log_message('error', "Failed to deactivate applications.");
            return;
        }

        $this->db->trans_commit();
        log_message('error', "Deactivation complete. Applications deactivated: " . count($application_ids));
    }
}
?>