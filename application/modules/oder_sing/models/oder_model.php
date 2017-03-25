<?php
class Oder_model extends CI_Model {
    function __construct() {
        parent::__construct();		
		
    }
	public function count_geteFiles($section_id=null,$moveup_down=null,$section_id_search=null,$pgmode)
    {
		$sub_type = '';
		if($this->input->get('sstype') != '') {
			$sub_type = $this->input->get('sstype');
        }
		$login_emp_id = emp_session_id();		
		//$emp_role_lvl= get_emp_role_levele();      
		//echo $emp_role_lvl['emprole_level'];
		
		//$cr_emp_ids_array =  explode(',',$cr_emp_str);
		$query =   $this->db->query("select count(ds_id) as u_empid from ft_leave_digital_signature where ds_is_signature = 0 and  ds_signature_emp_id = ".$login_emp_id);
        $rr =  $query->row_array();
		$rt =  explode(',',$rr['u_empid']);
        pre($rt);
        
		return $rt;
    }
    public function geteFiles($section_id,$moveup_down,$section_id_search='',$pgmode,$limit,$page)
    {
		$sub_type = '';
		if($this->input->get('sstype') != '') {
			$sub_type = $this->input->get('sstype');
        }
		$login_emp_id = emp_session_id();		
		$emp_role_lvl= get_emp_role_levele();      
		//echo $emp_role_lvl['emprole_level'];
		$cr_emp_str = get_emp_by_role(9,$section_id = null);
		$cr_emp_ids_array =  explode(',',$cr_emp_str);
		$query =   $this->db->query("select group_concat(under_emp_id SEPARATOR ',') as u_empid from ft_employee_hirarchi where emp_id = ".$login_emp_id);
        $rr =  $query->row_array();
		$rt =  explode(',',$rr['u_empid']);
        //pre($rt);
        $tbl_files = FILES;
		$tbl4 = DEPARTMENTS;
        $tbl5 = DISTRICT;
		$draft=DRAFT;
        $this->db->select(FILES .'.*,'.$draft.'.*,dept_name_hi,district_name_hi');
		$this->db->join($tbl4, "$tbl4.dept_id = $tbl_files.file_department_id", 'left');
        $this->db->join($tbl5, "$tbl5.district_id = $tbl_files.file_district_id",'left');		
        $this->db->join($draft, "$tbl_files.file_id= $draft.draft_file_id and draft_type='n' ",'left');		
		if(!empty($section_id_search)){
			$this->db->where_in('file_mark_section_id', $section_id_search);
		}else if(isset($section_id) && $section_id != null) {
            $this->db->where_in('file_mark_section_id', $section_id);
        }else if($pgmode=='inbox'){ /*INBOX*/
			if($emp_role_lvl['emprole_level']==6 ){ /*For SO, incharge*/					
					//if($emp_role_lvl['role_id']==37){
						//$this->db->or_where('file_hardcopy_status','working');						
					//}else{
						$this->db->where('final_draft_id IS NOT NULL', null, false);							
					//}	
			}else if($emp_role_lvl['emprole_level']==13){ //For DA	
					//echo 'dd';
					$this->db->or_where('file_hardcopy_status','working');
					$this->db->where('final_draft_id IS NULL', null, false);							
			}else if($emp_role_lvl['emprole_level']==7){ //For ???? ???????	
					if(isset($_GET['section_id']) && $_GET['section_id']!=''){
						if(ctype_digit($_GET['section_id'])){
							$e_section_id=$_GET['section_id'];
						}else{ $e_section_id=0;} 
						$this->db->where_in('file_mark_section_id', $e_section_id);
					}
					$this->db->where('final_draft_id IS NOT NULL', null, false);
			}else if($emp_role_lvl['emprole_level']==5){ //For ??? ????	
					if(isset($_GET['section_id']) && $_GET['section_id']!=''){
						if(ctype_digit($_GET['section_id'])){
							$e_section_id=$_GET['section_id'];
						}else{ $e_section_id=0;} 
						$this->db->where_in('file_mark_section_id', $e_section_id);
					}
					$this->db->where('final_draft_id IS NOT NULL', null, false);
			}else if($emp_role_lvl['emprole_level']==4){ //For ?? ????	
			if(isset($_GET['section_id']) && $_GET['section_id']!=''){
						if(ctype_digit($_GET['section_id'])){
							$e_section_id=$_GET['section_id'];
						}else{ $e_section_id=0;} 
						$this->db->where_in('file_mark_section_id', $e_section_id);
					}
					$this->db->where('final_draft_id IS NOT NULL', null, false);
			}else if($emp_role_lvl['emprole_level']==3){ //For ???????? ????	
					if(isset($_GET['section_id']) && $_GET['section_id']!=''){
						if(ctype_digit($_GET['section_id'])){
							$e_section_id=$_GET['section_id'];
						}else{ $e_section_id=0;} 
						$this->db->where_in('file_mark_section_id', $e_section_id);
					}
					$this->db->where('final_draft_id IS NOT NULL', null, false);
			}else if($emp_role_lvl['emprole_level']==2){ //For ????	
					if(isset($_GET['section_id']) && $_GET['section_id']!=''){
						if(ctype_digit($_GET['section_id'])){
							$e_section_id=$_GET['section_id'];
						}else{ $e_section_id=0;} 
						$this->db->where_in('file_mark_section_id', $e_section_id);
					}
					//echo 'welcome';
					$this->db->where('final_draft_id IS NOT NULL', null, false);
			}else if($emp_role_lvl['emprole_level']==1){ //For ??????  ????	
					if(isset($_GET['section_id']) && $_GET['section_id']!=''){
						if(ctype_digit($_GET['section_id'])){
							$e_section_id=$_GET['section_id'];
						}else{ $e_section_id=0;} 
						$this->db->where_in('file_mark_section_id', $e_section_id);
					}
					$this->db->where('final_draft_id IS NOT NULL', null, false);
			}else{
					$this->db->where('file_hardcopy_status','received');
					
			}			 			
			$this->db->where('file_received_emp_id',$login_emp_id);				
		}else if($pgmode=='sent'){ /*SEND*/
			 $this->db->where('file_hardcopy_status','not');			 
			 $this->db->where('file_sender_emp_id',$login_emp_id);
		}else if($pgmode=='return'){ /*Return files*/
				if($emp_role_lvl['emprole_level']==13){					
					$this->db->where('final_draft_id IS NOT NULL', null, false);	
				}if($emp_role_lvl['emprole_level']==6 ){ /*For SO, incharge*/					
					$this->db->where('final_draft_id IS NOT NULL', null, false);							
				}if($emp_role_lvl['emprole_level']==7){ /*For LEKHA ADHIKARI*/					
					$this->db->where('final_draft_id IS NOT NULL', null, false);							
					$this->db->where('file_status !=','p');							
				}
				if($emp_role_lvl['emprole_level']>=1 && $emp_role_lvl['emprole_level']<=5){ /*For Secratory, incharge*/		
					$this->db->where('final_draft_id IS NOT NULL', null, false);							
					$this->db->where('file_status !=','p');							
				}				
				$this->db->where('file_received_emp_id',$login_emp_id);	
		}else{ /*Working*/				
             if($emp_role_lvl['emprole_level']==6){
				$this->db->where('file_hardcopy_status','received');
				$this->db->where('final_draft_id IS NOT NULL', null, false);
			 }else{				
				$this->db->where('final_draft_id IS NOT NULL', null, false);
			 }
			$this->db->where('draft_reciever_id',$login_emp_id);	
			$this->db->where('draft_sender_id',$login_emp_id);	
			$this->db->where('final_draft_id IS NOT NULL', null, false);	
			$this->db->where('file_received_emp_id',$login_emp_id);
			$where_draft_status = "(draft_status = 2 OR draft_status = 3)";
			$this->db->where($where_draft_status);				
        }
        $this->db->where('file_hardcopy_status !=','close');
		if($sub_type != ''){
			$this->db->where('section_file_categoty',$sub_type);
		}	
		if(isset($_GET['searchby']) && $_GET['searchby']!=''){
			$searchval=$_GET['searchby'];
			$sql_emp="SELECT emp_id,emp_full_name FROM ft_employee WHERE MATCH(emp_full_name_hi) AGAINST('".$searchval."')";
			$emp_row_details= get_row($sql_emp);			
			if(isset($emp_row_details['emp_id']) && $emp_row_details['emp_id']!=''){				
				$searchval = $emp_row_details['emp_id'];
				$this->db->where('ft_files.file_sender_emp_id',$searchval);
			}else{
				$wheres= "( FIND_IN_SET('".$searchval."',ft_files.file_all_section_no) OR ft_files.file_all_section_no like '%".$searchval."%' OR ft_files.file_subject like '%".$searchval."%'  OR ft_files.file_uo_or_letter_no like '%".$searchval."%' OR ft_files.file_uo_or_letter_date = DATE_FORMAT('".$searchval."', '%Y-%m-%d'))";
				$this->db->where($wheres);
			}   
		}	
		$this->db->group_by('file_id');
		$this->db->order_by('file_update_date','asc'); 
		$this->db->limit($limit,$page);	
		$query = $this->db->get($tbl_files);
		//echo $this->db->last_query();
		return $query->result();
    }
	public function count_geteFiles_working($p1,$p2,$p3,$working){
		$login_emp_id = emp_session_id();		
		$emp_role_lvl= get_emp_role_levele();      
		//echo $emp_role_lvl['emprole_level'];
		$cr_emp_str = get_emp_by_role(9,$section_id = null);
		$cr_emp_ids_array =  explode(',',$cr_emp_str);
		$query =   $this->db->query("select group_concat(ds_id) as u_empid from ft_leave_digital_signature where ds_is_signature =1 and ds_signature_emp_id = ".$login_emp_id);
        $rr =  $query->row_array();
		return $rr;
	 }
	 
	 public function new_geteFiles_working($p1,$p2,$p3,$working,$limit,$page){
		$login_emp_id = emp_session_id();		
		$emp_role_lvl= get_emp_role_levele();      
		//echo $emp_role_lvl['emprole_level'];
		$cr_emp_str = get_emp_by_role(9,$section_id = null);
		$cr_emp_ids_array =  explode(',',$cr_emp_str);
		$query =   $this->db->query("select group_concat(under_emp_id SEPARATOR ',') as u_empid from ft_employee_hirarchi where emp_id = ".$login_emp_id);
        $rr =  $query->row_array();
		$rt =  explode(',',$rr['u_empid']);
        //pre($rt);
        $tbl_files = FILES;
		$tbl4 = DEPARTMENTS;
        $tbl5 = DISTRICT;
		$draft=DRAFT;
        $this->db->select(FILES .'.*,'.$draft.'.*,dept_name_hi,district_name_hi');
		$this->db->join($tbl4, "$tbl4.dept_id = $tbl_files.file_department_id", 'left');
        $this->db->join($tbl5, "$tbl5.district_id = $tbl_files.file_district_id",'left');		
        $this->db->join($draft, "$tbl_files.file_id= $draft.draft_file_id and draft_type='n' ",'left');					
		if($emp_role_lvl['emprole_level']==6){
			$this->db->where('file_hardcopy_status','received');
			$this->db->where('final_draft_id IS NOT NULL', null, false);
		 }else{				
			$this->db->where('final_draft_id IS NOT NULL', null, false);
		 }
		if(isset($_GET['searchby']) && $_GET['searchby']!=''){
			$searchval=$_GET['searchby'];
			$wheres= "(FIND_IN_SET('".$searchval."',ft_files.file_all_section_no) OR ft_files.file_all_section_no like '%".$searchval."%' OR ft_files.file_subject like '%".$searchval."%'  OR ft_files.file_uo_or_letter_no like '%".$searchval."%' OR ft_files.file_uo_or_letter_date = DATE_FORMAT('".$searchval."', '%Y-%m-%d'))";
			$this->db->where($wheres);
		}	
		$this->db->where('draft_reciever_id',$login_emp_id);	
		$this->db->where('draft_sender_id',$login_emp_id);	
		$this->db->where('final_draft_id IS NOT NULL', null, false);	
		$this->db->where('file_received_emp_id',$login_emp_id);
		$where_draft_status = "(draft_status = 2 OR draft_status = 3)";
		$this->db->where($where_draft_status);			
        $this->db->where('file_hardcopy_status !=','close');	
		if($this->uri->segment(2)=='efile_sign'){
			$this->db->where('file_hardcopy_status !=','not');	
		}
		$this->db->group_by('file_id');
		$this->db->order_by('file_update_date','ASC');
		$this->db->limit($limit,$page);	
		$query = $this->db->get($tbl_files);
		return $query->result();	 
	}
	public function geteFiles_working(){
		$login_emp_id = emp_session_id();		
		$emp_role_lvl= get_emp_role_levele();      
		//echo $emp_role_lvl['emprole_level'];
		$cr_emp_str = get_emp_by_role(9,$section_id = null);
		$cr_emp_ids_array =  explode(',',$cr_emp_str);
		$query =   $this->db->query("select group_concat(under_emp_id SEPARATOR ',') as u_empid from ft_employee_hirarchi where emp_id = ".$login_emp_id);
        $rr =  $query->row_array();
		$rt =  explode(',',$rr['u_empid']);
        //pre($rt);
        $tbl_files = FILES;
		$tbl4 = DEPARTMENTS;
        $tbl5 = DISTRICT;
		$draft=DRAFT;
        $this->db->select(FILES .'.*,'.$draft.'.*,dept_name_hi,district_name_hi');
		$this->db->join($tbl4, "$tbl4.dept_id = $tbl_files.file_department_id", 'left');
        $this->db->join($tbl5, "$tbl5.district_id = $tbl_files.file_district_id",'left');		
        $this->db->join($draft, "$tbl_files.file_id= $draft.draft_file_id and draft_type='n' ",'left');					
		if($emp_role_lvl['emprole_level']==6){
			$this->db->where('file_hardcopy_status','received');
			$this->db->where('final_draft_id IS NOT NULL', null, false);
		 }else{				
			$this->db->where('final_draft_id IS NOT NULL', null, false);
		 }
		if(isset($_GET['searchby']) && $_GET['searchby']!=''){
			$searchval=$_GET['searchby'];
			$sql_emp="SELECT emp_id,emp_full_name FROM ft_employee WHERE MATCH(emp_full_name_hi) AGAINST('".$searchval."')";
			$emp_row_details= get_row($sql_emp);			
			if(isset($emp_row_details['emp_id']) && $emp_row_details['emp_id']!=''){				
				$searchval = $emp_row_details['emp_id'];
				$this->db->where('ft_files.file_sender_emp_id',$searchval);
			}else{
				$wheres= "(FIND_IN_SET('".$searchval."',ft_files.file_all_section_no) OR ft_files.file_all_section_no like '%".$searchval."%' OR ft_files.file_subject like '%".$searchval."%'  OR ft_files.file_uo_or_letter_no like '%".$searchval."%' OR ft_files.file_uo_or_letter_date = DATE_FORMAT('".$searchval."', '%Y-%m-%d'))";
				$this->db->where($wheres);
			}
		}	
		$this->db->where('draft_reciever_id',$login_emp_id);	
		$this->db->where('draft_sender_id',$login_emp_id);	
		$this->db->where('final_draft_id IS NOT NULL', null, false);	
		$this->db->where('file_received_emp_id',$login_emp_id);
		$where_draft_status = "(draft_status = 2 OR draft_status = 3)";
		$this->db->where($where_draft_status);			
        $this->db->where('file_hardcopy_status !=','close');	
		if($this->uri->segment(2)=='efile_sign'){
			$this->db->where('file_hardcopy_status !=','not');	
		}
		$this->db->group_by('file_id');
		$this->db->order_by('file_update_date','ASC');
		//$this->db->limit(5);
		$query = $this->db->get($tbl_files);
		//echo $this->db->last_query();
		return $query->result();	 	
	 }
	public function getesingleFiles($section_id=null,$file_id)
    {	
		$login_emp_id = emp_session_id();
		$emp_role_lvl= get_emp_role_levele();        
		$query =   $this->db->query("select group_concat(under_emp_id SEPARATOR ',') as u_empid from ft_employee_hirarchi where emp_id = ".$login_emp_id);
        $rr =  $query->row_array();
		$rt =  explode(',',$rr['u_empid']);
        //pre($rt);
        $tbl_files = FILES;
		$tbl4 = DEPARTMENTS;
        $tbl5 = DISTRICT;
        $this->db->select(FILES .'.*,dept_name_hi,district_name_hi');
		$this->db->join($tbl4, "$tbl4.dept_id = $tbl_files.file_department_id", 'left');
        $this->db->join($tbl5, "$tbl5.district_id = $tbl_files.file_district_id",'left');
		$this->db->where(array('file_id'=>$file_id,'file_hardcopy_status !='=>'close'));
		$query = $this->db->get($tbl_files);
		return $query->result();
    }
    public function sent_efile($limit,$page){
		$login_emp_id = emp_session_id();
        $CI = & get_instance();		
		$subQuery = ("SELECT distinct (draft_file_id) FROM `ft_file_draft` WHERE `draft_id` in (SELECT DISTINCT(draft_log_draft_id) FROM `ft_draft_log` where draft_log_creater= ".$login_emp_id . ")");      
		
		$CI->db->select('*')->from(FILES)->where("file_id IN ($subQuery) and final_draft_id!='' ", NULL, FALSE);
		if(isset($_GET['searchby']) && $_GET['searchby']!=''){
			$searchval=$_GET['searchby'];
			$sql_emp="SELECT emp_id,emp_full_name FROM ft_employee WHERE MATCH(emp_full_name_hi) AGAINST('".$searchval."')";
			$emp_row_details= get_row($sql_emp);			
			if(isset($emp_row_details['emp_id']) && $emp_row_details['emp_id']!=''){				
				$searchval = $emp_row_details['emp_id'];
				$this->db->where('ft_files.file_received_emp_id',$searchval);
			}else{
				$wheres= "(FIND_IN_SET('".$searchval."',ft_files.file_all_section_no) OR ft_files.file_all_section_no like '%".$searchval."%' OR ft_files.file_subject like '%".$searchval."%'  OR ft_files.file_uo_or_letter_no like '%".$searchval."%' OR ft_files.file_uo_or_letter_date = DATE_FORMAT('".$searchval."', '%Y-%m-%d'))";
				$CI->db->where($wheres);
			}
		}
		$CI->db->order_by("file_update_date", 'desc');
		$this->db->limit($limit,$page);	
        $query = $CI->db->get();
        return    $query->result();
    }
	public function count_sent_efile(){
		$login_emp_id = emp_session_id();
        $CI = & get_instance();		
        $subQuery = ("SELECT distinct(draft_file_id) FROM `ft_file_draft` WHERE `draft_id` in (SELECT DISTINCT(draft_log_draft_id) FROM `ft_draft_log` where draft_log_creater= ".$login_emp_id . ")");
		if(isset($_GET['searchby']) && $_GET['searchby']!=''){
			$searchval=$_GET['searchby'];
			$sql_emp="SELECT emp_id,emp_full_name FROM ft_employee WHERE MATCH(emp_full_name_hi) AGAINST('".$searchval."')";
			$emp_row_details= get_row($sql_emp);			
			if(isset($emp_row_details['emp_id']) && $emp_row_details['emp_id']!=''){				
				$searchval = $emp_row_details['emp_id'];
				$this->db->where('ft_files.file_received_emp_id',$searchval);
			}else{
				$wheres= "(FIND_IN_SET('".$searchval."',ft_files.file_all_section_no) OR ft_files.file_all_section_no like '%".$searchval."%' OR ft_files.file_subject like '%".$searchval."%'  OR ft_files.file_uo_or_letter_no like '%".$searchval."%' OR ft_files.file_uo_or_letter_date = DATE_FORMAT('".$searchval."', '%Y-%m-%d'))";
				$CI->db->where($wheres);
			}
		}
		$CI->db->select('COUNT(DISTINCT(file_id)) as totalfiles')->from(FILES)->where("file_id IN ($subQuery) and final_draft_id!='' ", NULL, FALSE);		
		$CI->db->order_by("file_update_date", 'desc');
        $query = $CI->db->get();
        return $query->row_array();
    }
	public function get_not_recieved_files($file_selected_file_ids){
		$tbl_files = "ft_files";
		$query =   $this->db->query("select group_concat(file_id SEPARATOR ',') as not_recived_file_id from $tbl_files where file_id in (".$file_selected_file_ids.") and file_hardcopy_status!='received' and file_hardcopy_status!='working'");
        $rr =  $query->row_array();
		//echo $this->db->last_query();		
		return $rr['not_recived_file_id'];		
	}
	
	 public function count_inbox(){
        $login_emp_id = emp_session_id();
        $tbl1 = DRAFT;
        $tbl2 = FILES;
        $this->db->select('COUNT(DISTINCT(a.draft_file_id)) as inbox');
        $this->db->from($tbl1." as a");
        $this->db->join($tbl2." as b"," b.file_id = a.draft_file_id", 'inner');
        $where = "b.file_received_emp_id ='".$login_emp_id."' AND b.final_draft_id IS NOT NULL AND b.final_draft_id != '' AND b.file_hardcopy_status != 'close'";
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function count_wip(){
        $login_emp_id = emp_session_id();
        $tbl1 = DRAFT;
        $tbl2 = FILES;
        $this->db->select('COUNT(DISTINCT(a.draft_file_id)) as wipefile');
        $this->db->from($tbl1." as a");
        $this->db->join($tbl2." as b"," b.file_id = a.draft_file_id", 'inner');
        $where = "a.draft_reciever_id = '".$login_emp_id."' AND a.draft_sender_id = '".$login_emp_id."' AND (a.draft_status = 2 OR a.draft_status = 3) and b.final_draft_id IS NOT NULL AND b.final_draft_id != '' AND b.file_hardcopy_status != 'close'";
        $this->db->where($where);
        $query = $this->db->get();
        return $query->row_array();
    }

    public function count_sent(){
        $login_emp_id = emp_session_id();
        $query3 = "SELECT COUNT(distinct(draft_file_id)) as sent_efile FROM `ft_file_draft` WHERE `draft_id` in (SELECT DISTINCT(draft_log_draft_id) FROM `ft_draft_log` where draft_log_creater= ".$login_emp_id.")";
        $query =  $this->db->query($query3);
        return $query->row_array();
    }
	public function ordering()
	{
	
	$login_emp_id = emp_session_id();
        $tbl1 = DIGITAL_SIGNATURE_LEAVE;
        $tbl2 = FILES; 
		$query3 = "SELECT * FROM `ft_leave_digital_signature` join ft_emp_leave_movement on ft_emp_leave_movement.emp_leave_movement_id = ft_leave_digital_signature.ds_leave_mov_id JOIN ft_employee on ft_employee.emp_id = ft_emp_leave_movement.emp_id";
		
        $query =  $this->db->query($query3);

        return $query->result();
       
	}
	// get leave using leave movement id
    public function getLeaves($id = '') {
        //$this->db->select('cl_leave,ol_leave,el_leave,hpl_leave');
  
            $this->db->where('ds_leave_mov_id', $id);
       
        $query = $this->db->get(DIGITAL_SIGNATURE_LEAVE);
      // echo $this->db->last_query();
        return $query->row();
    }


	
}

