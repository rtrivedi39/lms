<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Leave_update extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->language('leave_approve', 'hindi');
        $this->load->model("leave_model");
        $this->load->helper('leave_helper');
        //isAdminAuthorize();
    }

    public function index(){
		$year = date('Y');
		$month = date('m');
		$day = date('d');
		$today = date('d-m-Y');

		if($month > 0 && $month < 7){
			$sub = 1;
		} else {
			$sub = 2;
		}
		
		$add_cl = 13;
		$add_ol = 3;
		$add_el = 15;
		$add_hpl = 20;
		
		$ol_update = get_settings('ol_update');
		$cl_update = get_settings('cl_update');
		$el_update = get_settings('el_update');
		$hpl_update = get_settings('hpl_update');
		$ol_array = explode(',',$ol_update['set_value']);
		$cl_array = explode(',',$cl_update['set_value']);
		$el_array = explode(',',$el_update['set_value']);
		$hpl_last_update = $hpl_update['set_datetime'];
		$hpl_last_update_date = date('d-m-Y',strtotime($hpl_last_update));
		
		if(!in_array($year, $ol_array)){
			$oldtable = "ft_employee_leave_".($year - 1);
			$qry = $this->db->query("CREATE TABLE $oldtable LIKE ft_employee_leave ");
			$qry = $this->db->query("INSERT INTO ".$oldtable." SELECT * FROM ft_employee_leave");
		}
		
		if(!in_array($year, $ol_array)){
			$qry = $this->db->query("UPDATE `ft_employee_leave` SET `ol_leave` ='$add_ol', `ot_leave` ='100', `other_leave` ='100'");
			update_settings('ol_update', $ol_update['set_value'].','.$year);
		}
		if(!in_array($year, $cl_array)){
			$qry = $this->db->query("UPDATE `ft_employee_leave` SET `cl_leave` ='$add_cl', `ot_leave` ='100', `other_leave` ='100'");
			update_settings('cl_update', $cl_update['set_value'].','.$year);
		}
		if(!in_array($year.'-'.$sub, $el_array)){
			$qry1 = $this->db->query("SELECT * FROM `ft_employee_leave`");
			$result = $qry1->result_array();
			$rem_el = 0;
			foreach($result as $row){
				if($row['el_leave'] > 240){
					$rem_el = $row['el_leave'] - 240;
					$el = 255;
				} else {
					$el = $row['el_leave'] + $add_el; 
				}
				$emp = $row['emp_id'];
				$this->db->query("UPDATE `ft_employee_leave` SET `el_leave` = '$el' WHERE emp_id = '$emp'");
				if($rem_el != 0){
					$this->db->query("UPDATE `ft_employee_leave` SET `emp_previous_el` = '$rem_el' WHERE emp_id = '$emp'");
				}
			}
			
			update_settings('el_update', $el_update['set_value'].','.$year.'-'.$sub);
		}
		if(strtotime($hpl_last_update_date) < strtotime($today)){
			$todays = date('Y-m-d',strtotime($today));
			$last_update = date('Y-m-d',strtotime($hpl_last_update));
			$query = "SELECT  e.emp_id ,d.emp_joining_date FROM `ft_employee_details` as d join ft_employee as e on e.emp_id = d.emp_id WHERE DATE_FORMAT(`emp_joining_date`, '%m-%d') <= DATE_FORMAT('$todays', '%m-%d') and DATE_FORMAT(`emp_joining_date`, '%m-%d') > DATE_FORMAT('$last_update', '%m-%d') and e.emp_is_retired = 0";
			$qry1 = $this->db->query($query);
			$result = $qry1->result_array();			
			foreach($result as $row){
				$emp = $row['emp_id'];
				echo $emp.' -> '.$row['emp_joining_date'].'<br/>'; 
				$qry_leave = $this->db->query("SELECT hpl_leave FROM `ft_employee_leave` WHERE emp_id = '$emp'");
				$result_leave = $qry_leave->row_array();
				$hpl_new = $result_leave['hpl_leave']  + $add_hpl;
				$this->db->query("UPDATE `ft_employee_leave` SET `hpl_leave` = '$hpl_new' WHERE emp_id = '$emp'");
			}
			update_settings('hpl_update', $today);
		}
	}
	
    public function show_404() {
        $this->load->view('404');
    }

}
