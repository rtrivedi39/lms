<?php

class Users_model extends CI_Model {

    /**
     * Validate the login's data with the database
     * @param string $user_id
     * @param string $password
     * @return void
     */
  function validate_user($user_id, $password) {
        if(is_numeric($user_id)){
            $this->db->where('emp_unique_id', $user_id);
        } else {
            $this->db->where('emp_login_id', $user_id);
        }
        $this->db->where('emp_password', $password);
        $query = $this->db->get(EMPLOYEES);
        if ($query->num_rows() == 1) {
            return true;
        }
        $this->db->last_query();
    }

    /**
     * Validate the login's data with the database
     * @param string $user_id    
     * @return void
     */
    function check_valid_user($user_id) {        
         if(is_numeric($user_id)){
            $this->db->where('emp_unique_id', $user_id);
        } else {
            $this->db->where('emp_login_id', $user_id);
        }
        $query = $this->db->get(EMPLOYEES);
        if ($query->num_rows() == 1) {
            return true;
        }
    }

    /**
     * Get user emp_id in the database using user_id
     * @return emp_id - column
     */
    public function get_emp_id_user_id($user_id) {
        $data = '';
        $this->db->where('emp_login_id', $user_id);
        $query = $this->db->get(EMPLOYEES);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = $row['emp_id'];
            }
        }
        return $data;
    }
     /**
     * Get user emp_id in the database using user_id
     * @return emp_id - column
     */
    public function get_emp_id_unique_id($user_id) {
        $data = '';
        $this->db->where('emp_unique_id', $user_id);
        $query = $this->db->get(EMPLOYEES);
        if ($query->num_rows() > 0) {
            foreach ($query->result_array() as $row) {
                $data = $row['emp_id'];
            }
        }
        return $data;
    }

    /**
     * Get user data in the database 
     * @return array - column
     */
    public function get_user_data($id = '', $column_name = '*') {
        $tbl_emp = EMPLOYEES;
        $tbl_emp_detail = EMPLOYEE_DETAILS;
        $tbl_emp_role = EMPLOYEEE_ROLE;
        $this->db->select($column_name);
        $this->db->from($tbl_emp);
        $this->db->join($tbl_emp_detail, "$tbl_emp.emp_id = $tbl_emp_detail.emp_id");
        $this->db->join($tbl_emp_role, "$tbl_emp.role_id = $tbl_emp_role.role_id");
        $emp_id = $id == '' ? $this->session->userdata('emp_id') : $id;
        $this->db->where("$tbl_emp.emp_id", $emp_id);
        $query = $this->db->get();
        if ($query->num_rows() == 1) {
            //print_r($query->result());die;
            return $query->result();
        } else {
            return FALSE;
        }
    }

    /**
     * update password
     * @return boolean - true iff success
     */
    public function update_password($id, $new_pass) {
        $this->db->where('emp_id', $id);
        $data = array(
            'emp_password' => $new_pass,
        );
        $this->db->where('emp_id', $id);
        $this->db->update(EMPLOYEES, $data);
        return true;
    }
    
    public function user_login_log(){
        if ($this->agent->is_browser())
        {
           $agent = $this->agent->browser().' '.$this->agent->version();
        }
        $data = array(
            'emp_id' =>  $this->session->userdata('emp_id'),
            'log_browser' => $agent,
            'log_session_id' =>  $this->session->userdata('session_id'),
            'log_ip_address' => $this->input->ip_address(),
        );
        
         $this->db->insert('employee_login_log', $data);

         $upt_data = array(
            'emp_ip_address' => $this->input->ip_address(),
            'emp_session_id' => $this->session->userdata('session_id'),
            );
         $this->db->where('emp_id', $this->session->userdata('emp_id'));
         $this->db->update(EMPLOYEES, $upt_data);
    }
    
    public function destroy_user_login_log(){
        $upt_data = array(
            'emp_ip_address' => '',
            'emp_session_id' => '',
            );
         $this->db->where('emp_id', $this->session->userdata('emp_id'));
         $this->db->update(EMPLOYEES, $upt_data);
    }

}
