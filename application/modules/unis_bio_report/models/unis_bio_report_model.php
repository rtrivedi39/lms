<?php

class Unis_bio_report_model extends CI_Model {

 	function __construct() {
        parent::__construct();
        $this->not_in_users = array(-1,1,2,3,4,12,123,1234,12345,1111,121,178,25,256,28,32,3253,33,3333,3523,3551,3562,3565,45,4525,4526,4534,4541,485,4908,5,533,56,58,6,61,6124,62143,646,6562,6833,85422,962,9999,555555555,632421437,851018617,100000001,111,328963,9302,8,876,929,5555,1234567);
    }
	
	public function record_count(){
		 return $this->db->count_all(UNIS_BIO_REPORT);
	}
	
    public function get_report_date_range($strat_date , $end_date, $emp_id, $join = 'left')
    {
        $tbl_report = UNIS_BIO_REPORT; 
        $tbl_emp = EMPLOYEES; 
        $this->db->select('emp_id,emp_title_en,emp_full_name,bio_date,bio_time,bio_terminal,bio_user_id,bio_user_name,bio_user_unique_id');
        $this->db->from($tbl_report);
	    $this->db->join($tbl_emp, $tbl_emp . '.emp_unique_id=' . $tbl_report . '.bio_user_id', $join);
		$this->db->where('bio_user_id',$emp_id);
		$this->db->where("bio_date >= ", $strat_date);		
		$this->db->where("bio_date <= ", $end_date);	
		$this->db->group_by('bio_date');
		$this->db->order_by('bio_id','ASC');
        $query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
            return $query->row_array();
        }
        return false;
        
    }
	
	public function get_outime($date,$emp_id){
		$tbl_report = UNIS_BIO_REPORT; 
        $this->db->select('bio_date,bio_time');
        $this->db->from($tbl_report);
		$this->db->where("bio_date", $date);
		$this->db->where('bio_user_id',$emp_id);		
		$this->db->order_by('bio_id','DESC');
		//$this->db->limit(1,1);
        $query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
             $res = $query->row_array();
			 $return =  $res['bio_time'];
        } else {
			$return = '-';
		}
		return $return;		
	} 
	
	public function get_late_days($unique_id,$month,$year){
		$hdays = holidays($year);
		$holidays = array_values($hdays);
		$late_arrive = LATE_ARRIVE;
		$tbl_report = UNIS_BIO_REPORT;
        $this->db->select('min(bio_time) as in_time, max(bio_time) as out_time');
        $this->db->from($tbl_report);
		$this->db->where('bio_user_id',$unique_id);
		$this->db->where("MONTH(bio_date)", $month);
		$this->db->where("YEAR(bio_date)", $year);
		$this->db->where_not_in("bio_date", $holidays);
		$this->db->group_by('bio_date');
		$this->db->order_by('bio_id','DESC');
		$this->db->having('in_time >',$late_arrive);
		//$this->db->limit(1,1);
        $query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
             $res = $query->result();
			 $return =  $query->num_rows();
        } else {
			$return = 0;
		}
		return $return;
	}

	public function get_report_date($_date = null, $type, $month = null, $year = null, $group_type = null, $class_wise = null)
    {
		$late_arrive = LATE_ARRIVE;
		$erly_dept = ERLY_DEPT;
		if(!empty($_date)){
			$_date = get_date_formate($_date,'Y-m-d');
		}
        $tbl_report = UNIS_BIO_REPORT; 
        $tbl_emp = EMPLOYEES; 
		$tbl_emp_det = EMPLOYEE_DETAILS; 
        $tbl_date = 'ft_dates'; 
        $this->db->select($tbl_emp.'.emp_id,emp_title_en,emp_title_hi,emp_full_name,emp_full_name_hi,dates,min(bio_time) as in_time,max(bio_time) as out_time,bio_terminal,bio_user_id,bio_user_name,bio_user_unique_id');
		$this->db->from($tbl_report);
	    $this->db->join($tbl_emp, $tbl_emp . '.emp_unique_id=' . $tbl_report . '.bio_user_id', 'left');
	    $this->db->join($tbl_emp_det, $tbl_emp_det . '.emp_id=' . $tbl_emp . '.emp_id', 'left');
	    $this->db->join($tbl_date, $tbl_report . '.bio_date='.$tbl_date . '.dates', 'left');
	  	$this->db->where_not_in('bio_user_id',$this->not_in_users);
	  	if(!empty($_date)){
			$this->db->where("DATE(dates)", $_date);
			$this->db->group_by('bio_user_id');
		}
		if(!empty($month)){
			$this->db->where("MONTH(dates)", $month);
		}
		if(!empty($year)){
			$this->db->where("YEAR(dates)", $year);
		}
		if(!empty($class_wise)){
			$this->db->where("emp_class", $class_wise);
		}
		if(!empty($month) && !empty($year)){
			$this->db->group_by('bio_user_id'); 
			$this->db->group_by('dates');
			
		}
		if(!empty($group_type)){
			if($group_type == 'name'){
				$this->db->group_by('bio_user_id'); 
				$this->db->order_by('bio_user_id','ASC'); 
				$this->db->order_by('dates','ASC');
			}
			if($group_type == 'date'){
				$this->db->group_by('dates');
				$this->db->order_by('dates','ASC');
				$this->db->order_by('bio_user_id','ASC'); 
			}
		}
		$this->db->order_by('in_time','DESC');
		$this->db->order_by('out_time','ASC');
		if($type == 'lt'){
			$this->db->having('in_time >',$late_arrive);
		}
		if($type == 'ed'){
			$this->db->having('out_time <',$erly_dept); 
		}
		if($type == 'b_and'){
			$this->db->having('in_time >',$late_arrive);
			$this->db->having('out_time <',$erly_dept);
		}
		if($type == 'b_or'){
			$this->db->having("in_time > '$late_arrive' or out_time < '$erly_dept'");
		}
        $query = $this->db->get();
		//echo $this->db->last_query(); 
		if ($query->num_rows() > 0) {
            return $query->result();
        }
        return false;
        
    }
	
	public function get_intime($date,$emp_id){
		$tbl_report = UNIS_BIO_REPORT; 
        $this->db->select('bio_date,bio_time');
        $this->db->from($tbl_report);
		$this->db->where("bio_date", $date);
		$this->db->where('bio_user_id',$emp_id);		
		$this->db->order_by('bio_id','ASC');
		//$this->db->limit(1,1);
        $query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
             $res = $query->row_array();
			 $return =  $res['bio_time'];
        } else {
			$return = '-';
		}
		return $return;		
	}
	
	public function upload_file($files){
		$correction_ids = array(
			'510106844' => '51016844',
			'51016861' => '51010861',
			'51010930' => '51010903',
			'151010876' => '51010876',
			'10014' => '51020135',
			'10017' => '51020134',
			'10016' => '51020133',
		);
		$tbl_report = UNIS_BIO_REPORT; 
		$last_data = $this->get_last_upload_date();		
		foreach($files as $file){
			if(strtotime($last_data['bio_date']) > strtotime($file['bio_date']) &&  strtotime($last_data['bio_time']) > strtotime($file['bio_time'])){
				pr('This csv already uploaded please check and upload!');
				$return =  false;
			} else{
				insertData($file,$tbl_report);
				$return =  true;
			}
		}
		foreach($correction_ids as $unis => $original){
			$query = "update ft_$tbl_report set bio_user_id = $original where bio_user_id = $unis";
			$this->db->query($query); 
		}		
		$query1 = "update ft_unis_bio_report set bio_time = concat('0',bio_time) where length(bio_time) < 6"; 
		$this->db->query($query1); 
		return $return;  
	}
	
	public function get_bio_users(){
		$tbl_report = UNIS_BIO_REPORT; 
        $this->db->select('bio_user_id');
        $this->db->from($tbl_report);
		$this->db->where_not_in('bio_user_id',$this->not_in_users);
		$this->db->group_by('bio_user_id');	
        $query = $this->db->get();
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
             return $query->result();			 
        }			
	}
	public function get_last_upload_date(){
		$tbl_report = UNIS_BIO_REPORT; 
        $this->db->select('bio_date,bio_time');
        $this->db->from($tbl_report);
		$this->db->order_by('bio_id','desc');
        $query = $this->db->get(); 
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
             return $query->row_array();			 
        }			
	}
	
	public function get_last_id(){
		$tbl_report = UNIS_BIO_REPORT; 
        $this->db->select_max('bio_id');
        $this->db->from($tbl_report);
		$this->db->order_by('bio_id','desc');	
        $query = $this->db->get(); 
		//echo $this->db->last_query();
		if ($query->num_rows() > 0) {
             return $query->row_array();			 
        }		
	}

	public function all_employees()
    {
        $tbl_report = UNIS_BIO_REPORT; 
        $tbl_emp = EMPLOYEES; 
        $tbl_emp_detail = EMPLOYEE_DETAILS;       
        $this->db->select("$tbl_emp.emp_id, emp_unique_id,emp_title_en, emp_title_hi, emp_full_name, emp_full_name_hi");
		$this->db->from($tbl_emp);
	    $this->db->join($tbl_report, $tbl_emp . '.emp_unique_id=' . $tbl_report . '.bio_user_id');
	    $this->db->join($tbl_emp_detail, $tbl_emp . '.emp_id=' . $tbl_emp_detail . '.emp_id');
	  	$this->db->where('emp_is_parmanent',1);
	  	$this->db->where('emp_status',1); 
	  	$this->db->where('emp_is_retired',0); 
	  	$this->db->where('emp_posting_location',1);	 
	  	if($this->input->post('choose_desingation') != ''){
	  		$this->db->where_in('designation_id',array($this->input->post('choose_desingation'))); 
	  	}
	  	if($this->input->post('employees_class') != ''){
	 	 	$this->db->where($tbl_emp_detail.'.emp_class',$this->input->post('employees_class')); 
	  	}
		$this->db->where('bio_date <=',date('Y-m-d'));
	  	//$this->db->where_in('emp_id',array(125,101,97,98,150,87,85,111,201,182,188,223)); 
	  	$this->db->group_by($tbl_emp.'.emp_id');
	  	$this->db->order_by($tbl_emp.'.designation_id');
	  	
        $query = $this->db->get();
		//echo $this->db->last_query();  exit;
		if ($query->num_rows() > 0) {
            return $query->result_array();
        }
        return false;
        
    }
	
}

