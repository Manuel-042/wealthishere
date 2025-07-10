<?php
defined('BASEPATH') or exit('No direct script access allowed');


class Api_model extends CI_Model
{

	public function __construct()
	{
		parent::__construct();
	}

	public function save_application($data, $type)
	{
		try {
			$this->db->trans_start();

			// Insert team lead
			$this->db->insert("{$type}_applications", $data['application']);
			if ($this->db->affected_rows() <= 0) {
				log_message('error', "Database Error: Failed to insert {$type} application: " . json_encode($this->db->error()));
				$this->db->trans_rollback();
				return false;
			}

			$application_id = $this->db->insert_id();
			$main_application_id = $data['application']['application_id'];

			if ($type === 'gap') {
				if (isset($data['team_lead']['certificatePath'])) {
					$certificate_id = $this->new_certificate($data['team_lead']['certificatePath'], $application_id, $main_application_id);
	
					if ($certificate_id) {
						$data['team_lead']['certificate_id'] = $certificate_id;
					}
				}
			}

			if (isset($data['team_lead']['certificatePath'])) {
				unset($data['team_lead']['certificatePath']);
			}

			$data['team_lead']['application_id'] = $application_id;
			$data['team_lead']['main_application_id'] = $main_application_id;

			$teamLeadData = array_merge(
				$data['team_lead'],
				['team_members_count' => !empty($data['team_members']) ? count($data['team_members']) : 0]
			);

			$this->db->insert("{$type}_team_leads", $teamLeadData);
			if ($this->db->affected_rows() <= 0) {
				log_message('error', "Database Error: Failed to insert {$type} team_lead " . $application_id . ': ' . json_encode($this->db->error()));
				$this->db->trans_rollback();
				return false;
			}

			$data['business']['application_id'] = $application_id;
			$data['business']['main_application_id'] = $main_application_id;

			// Insert business
			$this->db->insert("{$type}_businesses", $data['business']);
			if ($this->db->affected_rows() <= 0) {
				log_message('error', "Database Error: Failed to insert {$type} business " . $application_id . ': ' . json_encode($this->db->error()));
				$this->db->trans_rollback();
				return false;
			}

			// Insert team members if any
			if (!empty($data['team_members'])) {
				foreach ($data['team_members'] as &$member) {
					$member['application_id'] = $application_id;
					$member['main_application_id'] = $main_application_id;
				}

				$this->db->insert_batch("{$type}_team_members", $data['team_members']);
			}

			$this->db->trans_complete();

			return true;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			log_message('error', "Database Error: Exception while saving {$type} application: " . $e->getMessage());
			return false;
		}
	}

	public function update_application($data, $type)
	{
		try {
			$this->db->trans_start();

			$main_application_id = $data['application']['application_id'];

			$this->db->select('id');
			$this->db->where('application_id', $main_application_id);
			$application_id = $this->db->get("{$type}_applications")->row()->id;

			// Update Application record
			$this->db->where(['id' => $application_id]);
			$this->db->update("{$type}_applications", $data['application']);

			if ($this->db->affected_rows() < 0) {
				log_message('error', "Database Error: Failed to update {$type} application: " . json_encode($this->db->error()));
				$this->db->trans_rollback();
				return false;
			}

			// Handle certificate for GAP applications
			if ($type === 'gap' && !empty($data['team_lead']['certificatePath'])) {
				$exisiting_file = $this->existing_certificate($data);

				$certificate_id = "";

				if ($exisiting_file) {
					$certificate_id = $this->update_certificate($data['team_lead']['certificatePath'], $application_id, $main_application_id);
				} else {
					$certificate_id = $this->new_certificate($data['team_lead']['certificatePath'], $application_id, $main_application_id);
				}

				if ($certificate_id) {
					$data['team_lead']['certificate_id'] = $certificate_id;
				}
			}

			unset($data['team_lead']['certificatePath']);

			// Update Team lead section
			$teamLeadData = array_merge(
				$data['team_lead'],
				['team_members_count' => !empty($data['team_members']) ? count($data['team_members']) : 0]
			);

			$this->db->where(['application_id' => $application_id]);
			$this->db->update("{$type}_team_leads", $teamLeadData);

			if ($this->db->affected_rows() < 0) {
				log_message('error', "Database Error: Failed to update {$type} team_lead: " . json_encode($this->db->error()));
				$this->db->trans_rollback();
				return false;
			}

			// Update business
			$this->db->where(['application_id' => $application_id]);
			$this->db->update("{$type}_businesses", $data['business']);

			if ($this->db->affected_rows() < 0) {
				log_message('error', "Database Error: Failed to update {$type} business: " . json_encode($this->db->error()));
				$this->db->trans_rollback();
				return false;
			}

			// Update team members if any
			if (!empty($data['team_members'])) {
				$this->db->where(['application_id' => $application_id]);
				$this->db->delete("{$type}_team_members");

				foreach ($data['team_members'] as &$member) {
					$member['application_id'] = $application_id;
					$member['main_application_id'] = $main_application_id;
				}

				$this->db->insert_batch("{$type}_team_members", $data['team_members']);
			}

			$this->db->trans_complete();

			if ($this->db->trans_status() === false) {
				log_message('error', "Transaction failed while updating {$type} application");
				return false;
			}

			return true;

		} catch (Exception $e) {
			$this->db->trans_rollback();
			log_message('error', "Database Error: Exception while updating {$type} application: " . $e->getMessage());
			return false;
		}
	}

	public function new_certificate($certificate_path, $application_id, $main_application_id)
	{
		try {
			$this->db->insert('gap_certificates', ['filePath' => $certificate_path, 'application_id' => $application_id, 'main_application_id' => $main_application_id]);

			if ($this->db->affected_rows() <= 0) {
				log_message('error', "Database Error: Failed to insert certificate path: " . json_encode($this->db->error()));
				return false;
			}

			$insert_id = $this->db->insert_id();

			return $insert_id;
		} catch (Exception $e) {
			log_message('error', 'An error occured while creating certificate record: ' . $e->getMessage());
			return false;
		}
	}

	public function update_certificate($certificate_path, $application_id, $main_application_id)
	{
		try {
			$this->db->where(['application_id' => $application_id, 'main_application_id' => $main_application_id]);
			$this->db->update('gap_certificates', ['filePath' => $certificate_path]);

			if ($this->db->affected_rows() <= 0) {
				log_message('error', "Database Error: Failed to insert certificate path: " . json_encode($this->db->error()));
				return false;
			}

			$this->db->select('id');
			$this->db->where(['application_id' => $application_id, 'main_application_id' => $main_application_id]);
			$update_id = $this->db->get("gap_certificates")->row()->id;

			return $update_id;
		} catch (Exception $e) {
			log_message('error', 'An error occured while creating certificate record: ' . $e->getMessage());
			return false;
		}
	}

	private function excelDateToDateTime($excelDate)
	{
		if (empty($excelDate) || !is_numeric($excelDate)) {
			return '';
		}

		$excelDate = (float) $excelDate;
		$unixTimestamp = ($excelDate - 25569) * 86400;

		if ($unixTimestamp < 0) {
			return '';
		}

		return gmdate("Y-m-d H:i:s", $unixTimestamp);
	}

	public function save_previous_applications($data)
	{
		try {
			$this->db->trans_start();

			// Insert team lead
			$this->db->insert('f4f_applications', [
				'user_id' => "",
				'submission_status' => 'draft',
				'review_status' => 'reviewed',
				'created_at' => $this->excelDateToDateTime($data['application']["created_at"]),
				'updated_at' => $this->excelDateToDateTime($data['application']["created_at"]),
			]);
			if ($this->db->affected_rows() <= 0) {
				log_message('error', 'F4F: Failed to insert f4f application: ' . json_encode($this->db->error()));
				$this->db->trans_rollback();
				return false;
			}

			$application_id = $this->db->insert_id();
			$data['team_lead']['application_id'] = $application_id;

			$teamLeadData = array_merge(
				$data['team_lead'],
				[
					'created_at' => $this->excelDateToDateTime($data['application']["created_at"]),
					'date_of_birth' => $this->excelDateToDateTime($data['team_lead']["date_of_birth"]),
					'team_members_count' => isset($data['team_lead']['team_members_count']) ? (int) $data['team_lead']['team_members_count'] : 0
				]
			);

			$this->db->insert('f4f_team_leads', $teamLeadData);
			if ($this->db->affected_rows() <= 0) {
				log_message('error', 'F4F: Failed to insert team_lead ' . $application_id . ': ' . json_encode($this->db->error()));
				$this->db->trans_rollback();
				return false;
			}

			$data['business']['application_id'] = $application_id;

			$businessData = array_merge(
				$data['business'],
				['created_at' => $this->excelDateToDateTime($data['application']["created_at"]), 'business_start_date' => $this->excelDateToDateTime($data['business']["business_start_date"])]
			);

			// Insert business
			$this->db->insert('f4f_businesses', $businessData);
			if ($this->db->affected_rows() <= 0) {
				log_message('error', 'F4F: Failed to insert business ' . $application_id . ': ' . json_encode($this->db->error()));
				$this->db->trans_rollback();
				return false;
			}

			// Insert team members if any
			if (!empty($data['team_members'])) {
				foreach ($data['team_members'] as &$member) {
					$member['application_id'] = $application_id;
					$member['created_at'] = $this->excelDateToDateTime($data['application']["created_at"]);
				}

				$this->db->insert_batch('f4f_team_members', $data['team_members']);
			}

			$this->db->trans_complete();

			return true;
		} catch (Exception $e) {
			$this->db->trans_rollback();
			log_message('error', 'F4F: Exception while saving application: ' . $e->getMessage());
			return false;
		}
	}

	public function get_current_application($type)
	{
		try {
			$query = $this->db
				->where('application_key', $type)
				->where('status', 'open')
				->order_by('created_at', 'DESC')
				->limit(1)
				->get('application_status');

			$application = $query->row_array();

			if ($application) {
				return $application;
			} else {
				return false;
			}
		} catch (Exception $e) {
			log_message('error', 'Error while getting current application ' . $e->getMessage());
			return false;
		}
	}

	public function get_applications($id, $type)
	{

		try {
			$select = "a.*, atl.*, aB.*, 
                a.id as app_id,
                atm.fullname AS member_fullname,
                atm.email AS member_email,
                atm.gender AS member_gender,
                atm.phone AS member_phone,
                atm.location AS member_location,
                atm.status AS member_status,
                atm.education_qualification AS member_education_qualification,
                atm.higher_institution AS member_higher_institution,
                atm.course_of_study AS member_course_of_study,
                atm.business_role AS member_business_role,
                atm.qualification AS member_qualification";

			if ($type === 'f4f') {
				$select .= ", atm.nysc_state_code AS member_nysc_state_code";
			}

			if ($type === 'gap') {
				$select .= ", c.filePath";
			}

			$this->db->select($select);
			$this->db->from("{$type}_applications a");
			$this->db->join("{$type}_team_leads atl", "atl.application_id = a.id", "left");
			$this->db->join("{$type}_businesses aB", "aB.application_id = a.id", "left");
			$this->db->join("{$type}_team_members atm", "atm.application_id = a.id", "left");

			if ($type === "gap") {
				$this->db->join("{$type}_certificates c", "c.id = atl.certificate_id", "left");
			}

			if (!is_null($id)) {
				$this->db->where("a.id", $id);
			}

			$query = $this->db->get();

			if ($this->db->error()['code'] !== 0) {
				log_message('error', "Database Error: " . json_encode($this->db->error()));
				return false;
			}

			if ($query->num_rows() === 0) {
				log_message('debug', "No Application found");
				return [];
			}

			$rawResults = $query->result_array();

			// Group by application ID and collect team_members
			$grouped = [];

			foreach ($rawResults as $row) {
				$appId = $row['app_id'];
				if (!isset($grouped[$appId])) {
					$cleanRow = $row;
					unset(
						$cleanRow['member_fullname'],
						$cleanRow['member_email'],
						$cleanRow['member_gender'],
						$cleanRow['member_phone'],
						$cleanRow['member_location'],
						$cleanRow['member_status'],
						$cleanRow['member_education_qualification'],
						$cleanRow['member_higher_institution'],
						$cleanRow['member_course_of_study'],
						$cleanRow['member_business_role'],
						$cleanRow['member_qualification']
					);
					$cleanRow['team_members'] = [];
					$grouped[$appId] = $cleanRow;
				}

				$member = [
					'fullname' => $row['member_fullname'],
					'email' => $row['member_email'],
					'gender' => $row['member_gender'],
					'phone' => $row['member_phone'],
					'location' => $row['member_location'],
					'status' => $row['member_status'],
					'education_qualification' => $row['member_education_qualification'],
					'higher_institution' => $row['member_higher_institution'],
					'course_of_study' => $row['member_course_of_study'],
					'business_role' => $row['member_business_role'],
					'qualification' => $row['member_qualification'],
				];

				if ($type === 'f4f') {
					$member['nysc_state_code'] = $row['member_nysc_state_code'];
				}

				if (!empty($row['member_email'])) {
					$grouped[$appId]['team_members'][] = $member;
				}
			}

			return array_values($grouped);

		} catch (Exception $e) {
			log_message('error', 'An error occured while getting applications ' . $e->getMessage());
			return false;
		}
	}

	public function get_user_draft($id, $current_app_id, $type)
	{
		try {
			$query = $this->db->get_where("{$type}_applications", ['user_id' => $id, 'application_id' => $current_app_id]);

			if ($this->db->error()['code'] !== 0) {
				log_message('error', "Database Error: " . json_encode($this->db->error()));
				return false;
			}

			if ($query->num_rows() > 0) {
				$result = $query->row_array();

				if ($result['submission_status'] === 'draft') {
					$formData = $this->get_applications($result['id'], $type);
					return $formData;
				} else {
					return [];
				}
			} else {
				log_message('error', "Unexpected error in fetching applications");
				return false;
			}
		} catch (Exception $e) {
			log_message('error', 'An error occured while getting draft: ' . $e->getMessage());
			return false;
		}
	}

	public function submit_email_newsletter($email)
	{
		$email = strtolower(trim($email));

		$exists = $this->db
			->where('email', $email)
			->get('newsletter')
			->num_rows();

		if ($exists > 0) {
			return -1;
		}

		$inserted = $this->db->insert('newsletter', ['email' => $email]);

		if (!$inserted || $this->db->affected_rows() <= 0) {
			log_message('error', 'Newsletter insert failed: ' . json_encode($this->db->error()));
			return false;
		}

		return true;
	}

	public function get_user_application_status($id, $current_app_id, $type)
	{
		try {
			$query = $this->db->get_where("{$type}_applications", ['user_id' => $id, 'application_id' => $current_app_id]);
			if ($this->db->error()['code'] !== 0) {
				log_message('error', "Database Error: " . json_encode($this->db->error()));
				return false;
			}
			if ($query->num_rows() > 0) {
				$result = $query->row_array();
				return $result;
			} else {
				log_message('error', "Unexpected error in fetching applications");
				return false;
			}
		} catch (Exception $e) {
			log_message('error', 'An error occured while getting draft: ' . $e->getMessage());
			return false;
		}
	}


	public function application_status($type)
	{
		try {
			$query = $this->db
				->where('application_key', $type)
				->order_by('created_at', 'DESC')
				->limit(1)
				->get('application_status');

			$application = $query->row();

			if ($application) {
				$current_time = date('Y-m-d H:i:s');

				if (
					$application->status === 'open' &&
					$application->ends_at > $current_time
				) {
					return 'open';
				}
			}

			return 'closed';

		} catch (Exception $e) {
			log_message('error', 'An error occurred while getting application status: ' . $e->getMessage());
			return false;
		}
	}

	public function existing_application($data, $id, $type)
	{
		try {
			$query = $this->db->get_where("{$type}_applications", ['user_id' => $id, 'application_id' => $data['application']['application_id']]);

			if ($this->db->error()['code'] !== 0) {
				log_message('error', "Database Error: " . json_encode($this->db->error()));
				return false;
			}

			if ($query->num_rows() > 0) {
				log_message('error', 'Existing Application exist');
				return true;
			} else {
				log_message('error', 'Existing Application Does Not Exist | New Application');
				return false;
			}

		} catch (Exception $e) {
			log_message('error', 'An error occurred while checking for existing certificate: ' . $e->getMessage());
			return false;
		}
	}
	public function existing_certificate($data)
	{
		try {
			$query = $this->db->get_where("gap_certificates", ['main_application_id' => $data['application']['application_id']]);

			if ($this->db->error()['code'] !== 0) {
				log_message('error', "Database Error: " . json_encode($this->db->error()));
				return false;
			}

			if ($query->num_rows() > 0) {
				log_message('error', 'Existing Certificate exist');
				return true;
			} else {
				log_message('error', 'Existing Certificate Does Not Exist | New Certificate');
				return false;
			}

		} catch (Exception $e) {
			log_message('error', 'An error occurred while checking for exisitng certficiate: ' . $e->getMessage());
			return false;
		}
	}

	public function get_application_end_date($app_id)
	{
		try {
			$query = $this->db
				->where('id', $app_id)
				->get('application_status');

			$application = $query->row();

			if ($application) {
				return $application->ends_at;
			} else {
				return false;
			}

		} catch (Exception $e) {
			log_message('error', 'An error occurred while getting application end date: ' . $e->getMessage());
			return false;
		}
	}

}