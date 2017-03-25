<?php

class Outof_department_report_model extends CI_Model {

 	function __construct() {
        parent::__construct();
    }
	
	public function record_count(){
		 return $this->db->count_all(OUT_OF_DEPARTMENT_REPORT);
	}
	
    public function get_outof_department_report($id = null,  $employee_ids = null, $all = false)
    {
	    $userrole = checkUserrole();
	    $today = date('Y-m-d');
		$tbl_report = OUT_OF_DEPARTMENT_REPORT; 
		$employee  = EMPLOYEES;
        $this->db->select('*');       
		if($employee_ids != null){
			$this->db->where_in(EMPLOYEES . '.emp_id', $employee_ids);
		} else{
			if($id == null){
				$id = $this->session->userdata('emp_id');
			}
			if($all == false){
				$this->db->where("$tbl_report.report_emp_id", $id);			
			}			
		}		
		
        $this->db->from($tbl_report);
        $this->db->join($employee, $tbl_report . '.report_emp_id =' . $employee . '.emp_id');
		$this->db->order_by('report_when_go','DESC');
		
        $query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
        
    }  
	
	public function get_report_date_range($strat_date , $end_date, $emp_id = null)
    {
	    $userrole = checkUserrole();
	    $today = date('Y-m-d');
		$tbl_report = OUT_OF_DEPARTMENT_REPORT; 
		$employee  = EMPLOYEES;
        $this->db->select('*');       
		$this->db->where("date(report_when_go) >= ", $strat_date);		
		$this->db->where("date(report_when_go) <= ", $end_date);	
		if($emp_id != null){
			$this->db->where("$tbl_report.report_emp_id", $emp_id);	
		}		
        $this->db->from($tbl_report);
        $this->db->join($employee, $tbl_report . '.report_emp_id =' . $employee . '.emp_id');
		$this->db->order_by('report_when_go','DESC');
		
        $query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
        
    } 
	
	public function get_check_forwader($id = null)
    {
	    $tbl = EMPLOYEE_LEAVE_LEVEL_MASTER; 
        $this->db->select('*');       
		if($id == null){
			$id = $this->session->userdata('emp_id');
		}
		$this->db->where('forwarder_id', $id);			
        $this->db->from($tbl);
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {
            return true;
        } else{
			return false;
		}
        
    }
	
}

