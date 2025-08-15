<?php
defined('BASEPATH') or exit('No direct script access allowed');
defined('BASEPATH') or exit('No direct script access allowed');
require_once FCPATH . 'vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

/**
 *  @property CI_DB_query_builder db
 */
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

    public function send_email()
    {
        $lock_file = APPPATH . 'cache/email_cron.lock';

        // Prevent duplicate cron jobs
        if (file_exists($lock_file)) {
            $last_modified = filemtime($lock_file);
            if (time() - $last_modified < 300) {
                log_message('error', 'Email cron is already running. Exiting.');
                return;
            }
        }

        // Create lock
        file_put_contents($lock_file, time());

        // Auto-cleanup lock file no matter what happens
        register_shutdown_function(function () use ($lock_file) {
            if (file_exists($lock_file)) {
                unlink($lock_file);
            }
        });

        // Fetch 20 pending or retryable emails
        $emails = $this->db->where("(status = 'pending' OR (status = 'failed' AND attempts < 3))")
            ->order_by('id', 'asc')
            ->limit(20)
            ->get('email_queue2')
            ->result();

        if (empty($emails)) {
            log_message('error', 'No pending emails to send.');
            return;
        }

        foreach ($emails as $email) {
            $mailer = new PHPMailer(true);
            try {

                $data = json_decode($email->dynamic_data, true);
                $body = $this->load->view('auth/email/' . $email->template_file, $data, true);

                // Set up mailer (You can switch to SendGrid or SES here)
                $mailer->isSMTP();
                $mailer->Host = 'smtp.ionos.com';
                $mailer->SMTPAuth = true;
                $mailer->Username = 'batnfadmin@batnf.net';
                $mailer->Password = $_ENV['SMTP_PASSWORD'];
                $mailer->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
                $mailer->Port = 587;

                $mailer->CharSet = 'UTF-8';

                $mailer->setFrom('batnfadmin@batnf.net', 'BATNF');
                $mailer->addAddress($email->recipient);
                $mailer->isHTML(true);
                $mailer->Subject = $email->subject;
                $mailer->Body = $body;

                $mailer->send();

                $this->db->where('id', $email->id)->update('email_queue2', [
                    'status' => 'sent',
                    'sent_at' => date('Y-m-d H:i:s')
                ]);

                log_message('error', "Email sent to {$email->recipient}: ");
            } catch (Exception $e) {
                log_message('error', "Email send failed to {$email->recipient}: " . $mailer->ErrorInfo);
                $this->db->where('id', $email->id)->update('email_queue2', [
                    'status' => 'failed',
                    'last_error' => $mailer->ErrorInfo,
                    'attempts' => $email->attempts + 1,
                    'last_attempted' => date('Y-m-d H:i:s')
                ]);
            }

            // Optional: Pause to avoid spam detection
            sleep(1);
        }
    }
}
?>