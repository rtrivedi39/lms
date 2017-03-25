<?php

class User_activity_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

    function get_activity_list($id = '') {
        $user_login_log = EMPLOYEE_LOGIN_LOG;
        $employee = EMPLOYEES;
        $role = EMPLOYEEE_ROLE;
        $login_log_table = $this->db->dbprefix(EMPLOYEE_LOGIN_LOG);
        $count = $id == '' ? "COUNT($login_log_table.emp_id) as total," : '';
        $this->db->select($count . "$login_log_table.emp_id, emp_unique_id, emp_full_name,emp_full_name_hi, $employee.designation_id, log_browser,log_ip_address, log_create_date,emprole_name_hi");
        $this->db->from($employee);
        $this->db->join($user_login_log, $user_login_log . '.emp_id =' . $employee . '.emp_id');
        $this->db->join($role, $role . '.role_id =' . $employee . '.designation_id');
        if ($id == '') {
            $this->db->group_by($user_login_log . '.emp_id ');
            $this->db->order_by('total', 'desc');
        } else {
            $this->db->where($user_login_log . '.emp_id', $id);
            $this->db->order_by('log_create_date', 'desc');
        }
        $query = $this->db->get();
        // echo $this->db->last_query();
        return $rows = $query->result();
    }
    
    function get_activity_list_not_login(){
        $user_login_log = EMPLOYEE_LOGIN_LOG;
        $employee = EMPLOYEES;
		$role = EMPLOYEEE_ROLE;
        $this->db->select("distinct(emp_unique_id), emp_full_name,emp_full_name_hi, $employee.designation_id, emprole_name_hi");
        $this->db->from($employee);
        $this->db->join($user_login_log, $user_login_log . '.emp_id =' . $employee . '.emp_id','left');
        $this->db->join($role, $role . '.role_id =' . $employee . '.designation_id');
		$this->db->where($user_login_log . '.emp_id IS NULL');
        $this->db->where($role.".role_id !=", 1);
        $this->db->where("emp_status", 1);
        $this->db->where("emp_is_retired", 0);
        $this->db->order_by($role.'.role_id', 'ASC');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $rows = $query->result();
    }

    function get_activity_list_today() {
        $today = date('Y-m-d');
        $login_log_table = $this->db->dbprefix(EMPLOYEE_LOGIN_LOG);
        $where = "DATE_FORMAT(`log_create_date`, '%y-%m-%d') = DATE_FORMAT('$today', '%y-%m-%d') ";
        $user_login_log = EMPLOYEE_LOGIN_LOG;
		$role = EMPLOYEEE_ROLE;
        $employee = EMPLOYEES;
        $this->db->select("DISTINCT($login_log_table.emp_id), emp_unique_id, emp_full_name,emp_full_name_hi, $employee.designation_id, log_browser,log_ip_address, log_create_date,emprole_name_hi");
        $this->db->from($employee);
        $this->db->join($user_login_log, $user_login_log . '.emp_id =' . $employee . '.emp_id');
        $this->db->join($role, $role . '.role_id =' . $employee . '.designation_id');
		$this->db->where($where);
        $this->db->where($role.".role_id !=", 1);
        //$this->db->order_by('emp_full_name', 'asc');
        $this->db->order_by('log_create_date', 'desc');
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $rows = $query->result();
    }

}
