<?php

class Common_dashboard_model extends CI_Model {

 	function __construct() {
        parent::__construct();
    }
	
	public function getTotalFile()
	{
		$this->db->where( 'file_received_emp_id', $this->session->userdata('emp_id'));
		$this->db->order_by('file_id','desc');
		//$this->db->where( 'file_received_emp_id', $this->session->userdata('emp_id'));
		$this->db->limit(5);
		$query = $this->db->get(FILES);
		$rows = $query->result();
		$this->db->last_query();
		return $rows;
	}
	
	public function getDispatchFile()
	{
		$file_tbl = FILES;
		$file_dispetch_tbl = FILES_DISPATCH;
		$this->db->select($file_tbl.'.file_id,'.$file_tbl.'.file_received_emp_id');
		$this->db->where( 'emp_id', $this->session->userdata('emp_id'));
		$this->db->join($file_tbl , $file_tbl.'.file_id ='.$file_dispetch_tbl.'.file_id','left');
		$query = $this->db->get($file_dispetch_tbl);
		$rows = $query->result();
		$this->db->last_query();
		return $rows;
	}
	
	/*public function getpendingFile()
	{
		$totalfile = $this->getTotalFile();
		$dispatchFile = $this->getDispatchFile();
		$pendingFile = sizeof($totalfile) - sizeof($dispatchFile);
		return $pendingFile;
		
	}
	
	
	public function getPendingfilesDetails()
	{
		$file_ids = array();
		$pending_files = $this->getDispatchFile();
		foreach($pending_files as $file )
		{
			$file_ids[] = $file->file_id;
		}
		$total_files = $this->getTotalFile();
		$file_tbl = FILES;
		foreach($total_files as $files){
			if(!in_array($files->file_id ,$file_ids )){
				
				$this->db->where('file_id',$files->file_id);
				$query_file = $this->db->get($file_tbl);
				$this->db->last_query();
				$data[] = $query_file->row();
			}
		}
		return isset($data)?$data:''; 
	}
	public function getNoticeBoardInformation($setion_id = '')
	{
		$notice_board = NOTICE_BOARD;
		$this->db->select('notice_subject,notice_description,notice_attachment,	notice_remark,notice_created_date,notice_from_date,notice_to_date,notice_is_active');
		$this->db->where( 'emp_id', $this->session->userdata('emp_id'));
		$this->db->or_where( 'notice_section_id', $setion_id);
		$this->db->from($notice_board);
		$query = $this->db->get();
		$rows = $query->result();
		$this->db->last_query();
		return $rows;
	}*/
}

