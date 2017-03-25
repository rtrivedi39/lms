<?php

class Biometric_report_model extends CI_Model {

 	function __construct() {
        parent::__construct();
    }
	
	public function record_count(){
		 return $this->db->count_all(BIOMETRIC_REPORT);
	}
	
    public function get_biometric_report($id = null, $status = null, $limit = null, $start = null)
    {
		
        $tbl_report = BIOMETRIC_REPORT;    
        $this->db->select('*');
        $this->db->from($tbl_report);
        if($id != null){
			$this->db->where("$tbl_report.report_id", $id);
        }
		if($status != null){
			$this->db->where("$tbl_report.report_status", $status);
        }
		
		$this->db->order_by('report_year','DESC');
		$this->db->order_by('report_month','DESC');
		if($limit != null && $start != null){
			$this->db->limit($limit, $start);
		}
        $query = $this->db->get();
		
		if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
        
    }
	
}

