<?php

class Joining_report_model extends CI_Model {

 	function __construct() {
        parent::__construct();
    }
	
	public function record_count(){
		 return $this->db->count_all(JOINING_REPORT);
	}
	
    public function get_joining_report($id = null, $all = false, $limit = null, $start = null)
    {
        $tbl_report = JOINING_REPORT; 
		$employee  = EMPLOYEES;
        $this->db->select('*');
        if($id == null){
			$id = $this->session->userdata('emp_id');
        } 	
		if($all == false){
			$this->db->where("$tbl_report.report_emp_id", $id);			
		}
        $this->db->from($tbl_report);
        $this->db->join($employee, $tbl_report . '.report_emp_id =' . $employee . '.emp_id');
		$this->db->order_by('report_create_date','DESC');
		if($limit != null && $start != null){
			$this->db->limit($limit, $start);
		}
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
        
    }
	
	public function get_report_date_range($strat_date , $end_date, $emp_id = null)
    {
	    $tbl_report = JOINING_REPORT; 
		$employee  = EMPLOYEES;
        $this->db->select('*');    
		$this->db->where("date(report_create_date) >= ", $strat_date);		
		$this->db->where("date(report_create_date) <= ", $end_date);	
		if($emp_id != null){
			$this->db->where("$tbl_report.report_emp_id", $emp_id);	
		}		
        $this->db->from($tbl_report);
        $this->db->join($employee, $tbl_report . '.report_emp_id =' . $employee . '.emp_id');
		$this->db->order_by('report_create_date','DESC');
		
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
        
        
    } 
	
}

