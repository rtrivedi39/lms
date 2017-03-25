<?php

class Rest_api_model extends CI_Model {

 	function __construct() {
        parent::__construct();
    }
	public function get_allemployee(){
		$this->db->select('emp_id,role_id,designation_id,emp_unique_id,emp_password,emp_full_name,emp_full_name_hi,emp_email,emp_mobile_number,emp_image,emp_is_retired,emp_status');
		$query = $this->db->get(EMPLOYEES);
		return $query->result();
	}
	public function check_login($unique_id,$password,$role)
	{
		
		if(is_numeric($unique_id)){
            $this->db->where('emp_unique_id', $unique_id);
        } else {
            $this->db->where('emp_login_id', $unique_id);
        }
        $this->db->where('emp_password', $password);
        $query = $this->db->get(EMPLOYEES);
        if ($query->num_rows() == 1) {
            return true;
        }
	}
}

