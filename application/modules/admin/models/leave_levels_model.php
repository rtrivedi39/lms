<?php

class Leave_levels_model extends CI_Model {

    function __construct() {
        parent::__construct();
        $this->load->database();
        $this->load->library('session');
    }

    public function get_level_lists() {
        $this->db->select('*');
        $this->db->from(EMPLOYEES);
        $this->db->join(EMPLOYEE_LEAVE_LEVEL_MASTER, EMPLOYEE_LEAVE_LEVEL_MASTER . '.emp_id = ' . EMPLOYEES . '.emp_id');
		$this->db->join(EMPLOYEEE_ROLE, EMPLOYEEE_ROLE . '.role_id = ' . EMPLOYEES . '.designation_id');
		$this->db->where(EMPLOYEES . '.emp_is_retired', 0);
        $this->db->where(EMPLOYEES . '.emp_status', 1);
        $this->db->where(EMPLOYEES . '.emp_is_parmanent', 1);
		$this->db->where(EMPLOYEES . '.role_id !=', 1);
		$this->db->where(EMPLOYEES . '.emp_posting_location', 1);
        $this->db->order_by("role_leave_level", "ASC");
		$this->db->order_by("emp_full_name", "ASC");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    public function get_single_level($id) {
        $query = $this->db->get_where(EMPLOYEE_LEAVE_LEVEL_MASTER, array(
            'hirarchi_id' => $id,
                )
        );
        //echo $query = $this->db->get();
        return $query->row_array();
    }
    
    public function get_all_employee($isall = false) {
        $this->db->select(EMPLOYEES.'.emp_id,'.EMPLOYEES . '.role_id,emp_full_name,emp_full_name_hi');
        $this->db->from(EMPLOYEES);
        $this->db->join(EMPLOYEE_LEAVE_LEVEL_MASTER, EMPLOYEE_LEAVE_LEVEL_MASTER . '.emp_id = ' . EMPLOYEES . '.emp_id', 'left outer');
		$this->db->join(EMPLOYEEE_ROLE, EMPLOYEEE_ROLE . '.role_id = ' . EMPLOYEES . '.designation_id');
	    $this->db->where(EMPLOYEES . '.emp_is_retired', 0);
        $this->db->where(EMPLOYEES . '.emp_status', 1);
		$this->db->where(EMPLOYEES . '.emp_is_parmanent', 1);
		$this->db->where(EMPLOYEES . '.role_id !=', 1);
		$this->db->where(EMPLOYEES . '.emp_posting_location', 1);
		$this->db->order_by("role_leave_level", "ASC");
		$this->db->order_by("emp_full_name", "ASC");
        if($isall == false){
            $this->db->where(EMPLOYEE_LEAVE_LEVEL_MASTER . '.emp_id IS NULL');
        }
        $query = $this->db->get();
       // echo $this->db->last_query(); 
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    public function get_forwarder() {
        $this->db->select('*');
        $this->db->from(EMPLOYEES);
		$this->db->join(EMPLOYEEE_ROLE, EMPLOYEEE_ROLE . '.role_id = ' . EMPLOYEES . '.designation_id');
        $this->db->where("(ft_".EMPLOYEES . ".role_id < 16 or ft_".EMPLOYEES . ".role_id = 37)");
		$this->db->where(EMPLOYEES . '.emp_is_retired', 0);
        $this->db->where(EMPLOYEES . '.emp_status', 1);
		$this->db->where(EMPLOYEES . '.emp_is_parmanent', 1);
		$this->db->where(EMPLOYEES . '.role_id !=', 1);
		$this->db->where(EMPLOYEES . '.role_id !=', 9);
		$this->db->where(EMPLOYEES . '.emp_posting_location', 1);
		$this->db->order_by("role_leave_level", "ASC");
		$this->db->order_by("emp_full_name", "ASC");
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
     public function get_recommender() {
        $this->db->select('*');
        $this->db->from(EMPLOYEES);
		$this->db->join(EMPLOYEEE_ROLE, EMPLOYEEE_ROLE . '.role_id = ' . EMPLOYEES . '.designation_id');        $this->db->where('ft_'.EMPLOYEES . '.role_id <', 15);
		$this->db->where(EMPLOYEES . '.emp_is_retired', 0);
        $this->db->where(EMPLOYEES . '.emp_status', 1);
		$this->db->where(EMPLOYEES . '.emp_is_parmanent', 1);
		$this->db->where(EMPLOYEES . '.role_id !=', 1);
		$this->db->where(EMPLOYEES . '.role_id !=', 9);
		$this->db->where(EMPLOYEES . '.emp_posting_location', 1);
		$this->db->order_by("role_leave_level", "ASC");
		$this->db->order_by("emp_full_name", "ASC");
        $query = $this->db->get();
        //echo $this->db->last_query(); 
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    public function get_approver() {
        $this->db->select('*');
        $this->db->from(EMPLOYEES);
        $this->db->where('role_id <', 5);
		$this->db->where(EMPLOYEES . '.emp_is_retired', 0);
        $this->db->where(EMPLOYEES . '.emp_status', 1);
		$this->db->where(EMPLOYEES . '.emp_is_parmanent', 1);
		$this->db->where(EMPLOYEES . '.role_id !=', 1);
		$this->db->where(EMPLOYEES . '.emp_posting_location', 1);
		$this->db->order_by('designation_id','ASC');
        $query = $this->db->get();
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }

    /**
     * created by sulbha shrivastava
     * @ Function Name      : getUnitData
     * @ Function Params    : $data {mixed}, $kill {boolean}
     * @ Function Purpose   : get single unit value
     * @ Function Returns   : single record
     */

    public function  add_leave_level($data){
        return $this->db->insert(EMPLOYEE_LEAVE_LEVEL_MASTER, $data);
    }
    
    public function  update_leave_level($data, $id){
        $this->db->where('hirarchi_id', $id);
        return $this->db->update(EMPLOYEE_LEAVE_LEVEL_MASTER, $data);
    }

    public function delete_level_level($delete_id = '') {
        $this->db->where('hirarchi_id', $delete_id);
        return $this->db->delete(EMPLOYEE_LEAVE_LEVEL_MASTER);
    }

}

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

