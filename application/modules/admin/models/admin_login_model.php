<?php

class Admin_login_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
        $this->load->library('email');
    }

    public function logged_in() {
        log_message('info', 'Model_users logged_in method called successfully');
        $this->db->select('*');
        $this->db->from(EMPLOYEES);
        $this->db->where('emp_login_id', $this->input->post('username'));
        $this->db->where('emp_password', md5($this->input->post('password')));
        $this->db->where('emp_status', 1);
        $query = $this->db->get();

        if ($query->num_rows() > 0) {
            return $query->row_array();
        } else {
            return $query->row_array();
        }
    }

    //get the email template from database 
    public function get_email_template($condition = FALSE) {
        $this->db->select('*');
        $this->db->from('tbl_email_templates');
        if ($condition) {
            $this->db->where($condition);
        }
        $this->db->order_by('id', 'DESC');
        $query = $this->db->get();
        $data = $query->result_array();
        if ($query->num_rows) {
            return $data;
        }return FALSE;
    }

    public function change_pwd($newpssword) {

        $data['emp_password'] = md5($newpssword);
        $this->db->where('emp_id', $this->session->userdata('admin_id'));
        return $this->db->update(EMPLOYEES, $data);
    }

    public function getUserdata() {

        $this->db->select('emp_id,emp_full_name,emp_full_name_hi,emp_email,emp_mobile_number,emp_image');
        if ($this->session->userdata('admin_id')) {
            $this->db->where('emp_id', $this->session->userdata('admin_id'));
        }
        if ($this->session->userdata('emp_id')) {
            $this->db->where('emp_id', $this->session->userdata('emp_id'));
        }
        $this->db->from(EMPLOYEES);
        $query = $this->db->get();
        $rows = $query->result();

        if (isset($rows)) {
            return $rows;
        } else {
            return false;
        }
    }

    /**
      this function will update admin details
      @param $edit_id
      @return boolean value if success or failer
     */
    public function updateProfile($data, $edit_id) {
        $this->db->where('emp_id', $edit_id);
        return $this->db->update(EMPLOYEES, $data);
    }

    public function match_oldpwd($oldpssword) {
        $query = $this->db->get_where(EMPLOYEES, array(
            'emp_password' => $oldpssword,
            'emp_id' => $this->session->userdata('admin_id')
        ));
        return $query->num_rows();
    }

    public function get_user_service_profile() {
        $this->db->select('*');
        if ($this->session->userdata('admin_id')) {
            $this->db->where('emp_id', $this->session->userdata('admin_id'));
        }
        if ($this->session->userdata('emp_id')) {
            $this->db->where('emp_id', $this->session->userdata('emp_id'));
        }
        $this->db->from(EMPLOYEE_SERVICE_RECORD);
        $query = $this->db->get();
        $rows = $query->result();

        if (isset($rows)) {
            return $rows;
        } else {
            return false;
        }
    }

}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */
?>
