						<?php

class Leave_model extends CI_Model {

    function __construct() {
        parent::__construct();
    }

	// insert new leave of emp
    public function insert_leave($data) {
        $this->db->insert(LEAVE_MOVEMENT, $data);
		return $this->db->insert_id();
    }

	// update leave of emp
    function update_employee($data) {
        $this->db->where('emp_id', $this->session->userdata('emp_id'));
        return $this->db->update(EMPLOYEE_DETAILS, $data);
    }

	// get leave using leave movement id
    public function getLeaves($id = '') {
        $this->db->select('cl_leave,ol_leave,el_leave,hpl_leave');
        if($id == ''){
            $this->db->where('emp_id', $this->session->userdata('emp_id'));
        }else {
            $this->db->where('emp_id', $id);
        }
        $query = $this->db->get(EMPLOYEE_LEAVE);
        $this->db->last_query();
        return $query->row();
    }

	// for get leave details with leave id
	public function get_leaves_details($leave_id) {
        $tbl_leave_movement = LEAVE_MOVEMENT;
		$tbl_employee = EMPLOYEES;
		$tbl_employee_role = EMPLOYEEE_ROLE;
		$tbl_employee_details = EMPLOYEE_DETAILS;
		$tbl_attachment = ATTACHMENTS;

		$select = "lm.*,emprole_name_hi,
			emp.emp_title_hi as user_title_hi,emp.emp_title_en as user_title_en,emp.emp_full_name_hi as user_name, empd.emp_detail_gender as user_gender, emp.designation_id as designation_id,
			empf.emp_title_hi as forworder_title_hi,empf.emp_title_en as forworder_title_en,empf.emp_full_name_hi as forworder_name, empdf.emp_detail_gender as forworder_gender,
			empa.emp_title_hi as approver_title_hi,empa.emp_title_en as approver_title_en,empa.emp_full_name_hi as approver_name, empda.emp_detail_gender as approver_gender,
			empobh.emp_title_hi as onbehalf_title_hi,empobh.emp_title_en as onbehalf_title_en,empobh.emp_full_name_hi as onbehalf_name, empdobh.emp_detail_gender as onbehalf_gender,
			emprt.emp_title_hi as returnemp_title_hi,emprt.emp_title_en as returnemp_title_en,emprt.emp_full_name_hi as returnemp_name, empdrt.emp_detail_gender as returnemp_gender
		";
		$this->db->select($select);
        $this->db->from($tbl_leave_movement.' as lm');
		//$this->db->join($tbl_attachment.' as att', 'lm.emp_leave_movement_id = att.att_movement_id','left');
		$this->db->join($tbl_employee.' as emp', 'lm.emp_id = emp.emp_id');
		$this->db->join($tbl_employee_details.' as empd', 'empd.emp_id = emp.emp_id','left');
		$this->db->join($tbl_employee_role.' as empr',  'empr.role_id = emp.designation_id');
		$this->db->join($tbl_employee.' as empf', 'lm.emp_leave_forword_emp_id = empf.emp_id','left');
		$this->db->join($tbl_employee_details.' as empdf', 'lm.emp_leave_forword_emp_id = empdf.emp_id','left');
		$this->db->join($tbl_employee.' as empa', 'lm.emp_leave_approval_emp_id = empa.emp_id','left');
		$this->db->join($tbl_employee_details.' as empda', 'empda.emp_id = empa.emp_id','left');
		$this->db->join($tbl_employee.' as empobh', 'lm.on_behalf_leave = empobh.emp_id','left');
		$this->db->join($tbl_employee_details.' as empdobh', 'empdobh.emp_id = empobh.emp_id','left');
		$this->db->join($tbl_employee.' as emprt', 'lm.leave_return_to_emp_id = emprt.emp_id','left');
		$this->db->join($tbl_employee_details.' as empdrt', 'empdrt.emp_id = emprt.emp_id','left');

        $this->db->where('lm.emp_leave_movement_id',$leave_id);
        $query = $this->db->get();
        //echo $this->db->last_query() . br(); exit;
        return $rows = $query->row_array();
    }


	//get all leaves details usiing leave type and leave id with perticular status
    public function get_leaves($leave_status = '', $leave_type = '', $id = '',$year = '', $leave_types = null) {
        $tbl_leave_movement = LEAVE_MOVEMENT;
		$tbl_employee = EMPLOYEES;
		$tbl_employee_role = EMPLOYEEE_ROLE;
		$tbl_employee_details = EMPLOYEE_DETAILS;
		$tbl_digital_sign = DIGITAL_SIGNATURE_LEAVE;
		$emp_id = $id == '' ? $this->session->userdata('emp_id') : $id ;
		$select = "lm.*,emprole_name_hi,
			emp.emp_title_hi as user_title_hi,emp.emp_title_en as user_title_en,emp.emp_full_name_hi as user_name, empd.emp_detail_gender as user_gender, emp.designation_id as designation_id,
			empf.emp_title_hi as forworder_title_hi,empf.emp_title_en as forworder_title_en,empf.emp_full_name_hi as forworder_name, empdf.emp_detail_gender as forworder_gender,
			empa.emp_title_hi as approver_title_hi,empa.emp_title_en as approver_title_en,empa.emp_full_name_hi as approver_name, empda.emp_detail_gender as approver_gender,
			empobh.emp_title_hi as onbehalf_title_hi,empobh.emp_title_en as onbehalf_title_en,empobh.emp_full_name_hi as onbehalf_name, empdobh.emp_detail_gender as onbehalf_gender,ds_sign.*
		";
		$this->db->select($select);
        $this->db->from($tbl_leave_movement.' as lm');
        $this->db->join($tbl_digital_sign.' as ds_sign', 'lm.emp_leave_movement_id = ds_sign.ds_leave_mov_id','left');
		$this->db->join($tbl_employee.' as emp', 'lm.emp_id = emp.emp_id');
		$this->db->join($tbl_employee_details.' as empd', 'empd.emp_id = emp.emp_id','left');
		$this->db->join($tbl_employee_role.' as empr',  'empr.role_id = emp.designation_id');		
		$this->db->join($tbl_employee.' as empf', 'lm.emp_leave_forword_emp_id = empf.emp_id','left'); 
		$this->db->join($tbl_employee_details.' as empdf', 'lm.emp_leave_forword_emp_id = empdf.emp_id','left');		
		$this->db->join($tbl_employee.' as empa', 'lm.emp_leave_approval_emp_id = empa.emp_id','left');
		$this->db->join($tbl_employee_details.' as empda', 'empda.emp_id = empa.emp_id','left');
		$this->db->join($tbl_employee.' as empobh', 'lm.on_behalf_leave = empobh.emp_id','left');
		$this->db->join($tbl_employee_details.' as empdobh', 'empdobh.emp_id = empobh.emp_id','left');
        if ($leave_status == 'pending') {
            $equal = "( emp_leave_forword_type = 0 or emp_leave_forword_type = 1 or emp_leave_forword_type = 2 ) and (emp_leave_approval_type = 0)";
            $this->db->where($equal);
        }
        if ($leave_status == 'approve') {
            $equal = "( emp_leave_forword_type = 1 or emp_leave_approval_type = 1)";
            $this->db->where($equal);
        }
        if ($leave_status == 'deny') {
            $equal = "( emp_leave_forword_type = 2 or emp_leave_approval_type = 2)";
            $this->db->where($equal);
        }
        if ($leave_status == 'cancel') {
            $equal = "( emp_leave_forword_type = 3 or emp_leave_approval_type = 3)";
            $this->db->where($equal);
        }
        if ($leave_status == 'approve_deny') {
            $equal = "( emp_leave_forword_type = 1 or emp_leave_approval_type = 1 or emp_leave_forword_type = 2 or emp_leave_approval_type = 2)";
            $this->db->where($equal);
        }
        if ($leave_status == 'leaves_approve_deny_cancel') {
            $equal = "(emp_leave_approval_type = 1 or emp_leave_approval_type = 2 or emp_leave_approval_type = 3 or  emp_leave_forword_type = 3)";
            $this->db->where($equal);
        }
		if ($leave_status == 'return') {
            $equal = "(emp_leave_forword_type = 4  or emp_leave_approval_type = 4)";
            $this->db->where($equal);
        }
        if (!empty($leave_type)) {
        	 if ($leave_type == 'ld') {
            	$this->db->where('emp_leave_sub_type', $leave_type);            	
            }else{
            	$this->db->where('emp_leave_type', $leave_type);
            }

        } 
		if (!empty($year)) {
			$this->db->where("(year(emp_leave_date) = '$year' OR year(emp_leave_end_date) = '$year')");
        }
        if (!empty($leave_types)) {        	
        	if (in_array('ld',$leave_types)) {
            	$this->db->where_in('emp_leave_sub_type', $leave_types);            	
            }else{
            	$this->db->where_in('emp_leave_type', $leave_types);
            }		
        }
        
        $this->db->where('lm.emp_id',$emp_id );      
        $this->db->order_by('emp_leave_date', 'DESC');
        $query = $this->db->get();
       //echo $this->db->last_query() . br();
        return $rows = $query->result();
    }

	// get all el leaves which are applied
    public function getAllELLeaves($leave_status = '') {
        $this->db->select(LEAVE_MOVEMENT . '.emp_id,emp_leave_reason,emp_leave_movement_id,designation_id,emp_full_name,emp_full_name_hi, emp_leave_type,emp_leave_end_date,emp_leave_no_of_days,emp_leave_date,emp_leave_forword_type');
        if ($this->session->userdata('user_role') == 11) {
            $this->db->where('emp_leave_type', 'el');
        }
        if ($leave_status == 'pending') {
            $this->db->where('emp_leave_forword_type', 0);
        }
        $this->db->join(EMPLOYEES, EMPLOYEES . '.emp_id = emp_leave_movement_id', 'left');
        $this->db->from(LEAVE_MOVEMENT);
        $this->db->order_by('emp_leave_create_date', 'DESC');
        $query = $this->db->get();
        $this->db->last_query();
        return $rows = $query->result();
    }

	// get all leaves for pening for approval accroding user role
	public function get_allaproval_lists($leave_type = '', $return_count = false, $login_user = null,$current_emp_section_id = null, $limit = null,$offset = null)
	{

		$userrole = checkUserrole($login_user); // get user role
		if(empty($login_user)){
			$login_user = $this->session->userdata("emp_id");
		}
		if(empty($current_emp_section_id)){
			$current_emp_section_id = $this->session->userdata("emp_section_id");
		}else{
			$current_emp_section_id = implode(',',$current_emp_section_id);
		}

		$last_forwader_emp = array($login_user);
		$get_emp_est_sec = get_section_employee(7,4);
		foreach($get_emp_est_sec as $emp){
			$last_forwader_emp[] = $emp->emp_id;
		}
		if ((in_array(7, explode(',',$current_emp_section_id )) && $userrole == 4) ){ 
			$empids = $this->get_under_forwader_employees($login_user);
			if(!empty($empids)){
				foreach ($empids as $empid) {
					$employee_id[] = $empid->emp_id;
				}
			}
			$employee_ids = implode(',',$employee_id);
		}
		
		$tbl_leave_movement = LEAVE_MOVEMENT;
		$tbl_employee = EMPLOYEES;
		$tbl_employee_role = EMPLOYEEE_ROLE;
		//if($return_count == true){
			//$select = "count(*) as total";
		//} else{
			$select = "lm.*,emprole_name_hi,
				emp.emp_title_hi as user_title_hi,emp.emp_title_en as user_title_en,emp.emp_full_name_hi as emp_full_name_hi,emp.emp_full_name as emp_full_name,emp.emp_unique_id as emp_unique_id,
				empf.emp_title_hi as forworder_title_hi,empf.emp_title_en as forworder_title_en,empf.emp_full_name_hi as forworder_name,empr.emp_title_hi as recommender_title_hi,empr.emp_title_en as recommender_title_en,empr.emp_full_name_hi as recommender_name 
			"; 
		//}	
		
		$this->db->select($select);
		$this->db->from($tbl_leave_movement.' as lm');
        $this->db->join($tbl_employee.' as emp', 'emp.emp_id = lm.emp_id');
		$this->db->join($tbl_employee.' as empf', 'lm.emp_leave_forword_emp_id = empf.emp_id','LEFT');
		$this->db->join($tbl_employee.' as empr', 'lm.emp_leave_recommend_emp_id = empr.emp_id','LEFT');  
        $this->db->join($tbl_employee_role, $tbl_employee_role . '.role_id = emp.designation_id');       
        
		$equal = "((emp_leave_forword_type = 1 or emp_leave_forword_type = 2 ) and emp_leave_approval_type = 0)";
		switch($userrole){
			case 1 :  //for admin
				$this->db->where($equal);
			break;
			case 4 :  // for secretary all el hpl less than 7 and below offcer level
				if ((in_array(7, explode(',',$current_emp_section_id )) && $userrole == 4) ){ //for established sec
					$condition_1 = "(emp_leave_no_of_days < '7'  and emp.designation_id > 16 )";			
					$condition_2 = "(emp_leave_forword_emp_id in ($employee_ids)  and emp_leave_forword_emp_id = $login_user)";	// use for all forwad emp not show in approve list 		
					$this->db->where('('.$equal.' and ('.$condition_1 .' or '.$condition_2 .'))');
					//$this->db->where('emp_leave_forword_emp_id !=', $login_user);
					//$this->db->where_not_in("emp_leave_forword_emp_id" ,$employee_ids);
				}
			break;
			case 3 :  // for PS all el hpl more than 6 for all and all approval for upper officer			
				$this->db->where($equal);
				$this->db->where('emp_leave_approval_type' , 0);
				//$this->db->where('emp_leave_no_of_days >= ' , 7);
				$this->db->where_in("emp_leave_forword_emp_id" ,$last_forwader_emp);

			default:  // for others
					
			break;

		}
		if($leave_type != '') {
           if($leave_type == 'ld'){
			   //$this->db->where('emp_leave_sub_type', 'ld'); 
			   $this->db->where("(emp_leave_type = 'cl' or emp_leave_type = 'lwp')");
		   } else {
			   $this->db->where('emp_leave_type', $leave_type);
		   }
        }
		$this->db->order_by('emp_leave_create_date', 'ASC');
		if(!empty($limit)){
			$this->db->limit($limit, $offset);
		}
        $query = $this->db->get();
        //echo $this->db->last_query();
        $rows['query'] = $query->result();
        $rows['counts'] = $query->num_rows();
		if($return_count == true){
			return $rows['counts'];
		} else{
			return $rows;
		}
	}

	public function get_under_recommender_employees_only($id = '')
	{

		$tbl_level = EMPLOYEE_LEAVE_LEVEL_MASTER;
		$this->db->select('group_concat(level.emp_id) as emps');
        if($id == ''){
            $emp_id = $this->session->userdata('emp_id');
        }else{
            $emp_id = $id;

        }
        $this->db->from(EMPLOYEES);
		$this->db->join($tbl_level. ' as level', 'level.emp_id = ' . EMPLOYEES . '.emp_id');
		$this->db->where('recommender_id', $emp_id);
        $this->db->where('`forwarder_id` != `recommender_id`',null,false);

        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {

			$result = $query->row();
            return $result->emps;
        } else {
            return false;
        }
    }
	// get all leaves for pening for recomender accroding user role
	public function get_recomender_lists($leave_type = '', $return_count = false){	
		$userrole = checkUserrole(); // get user role
		$login_user = $this->session->userdata("emp_id");
		$current_emp_section_id = $this->session->userdata("emp_section_id");	

		$tbl_leave_level = EMPLOYEE_LEAVE_LEVEL_MASTER;
		$tbl_leave_movement = LEAVE_MOVEMENT;
		$tbl_employee = EMPLOYEES;
		$tbl_employee_role = EMPLOYEEE_ROLE;
		
		$select = "lm.*,emprole_name_hi,
			emp.emp_title_hi as user_title_hi,emp.emp_title_en as user_title_en,emp.emp_full_name_hi as emp_full_name_hi,emp.emp_full_name as emp_full_name,emp.emp_unique_id as emp_unique_id,
			empf.emp_title_hi as forworder_title_hi,empf.emp_title_en as forworder_title_en,empf.emp_full_name_hi as forworder_name
		";
		
		$this->db->select($select);
		$this->db->from($tbl_leave_movement.' as lm');
        $this->db->join($tbl_employee.' as emp', 'emp.emp_id = lm.emp_id');
		$this->db->join($tbl_employee.' as empf', 'lm.emp_leave_forword_emp_id = empf.emp_id','LEFT'); 
        $this->db->join($tbl_employee_role, $tbl_employee_role . '.role_id = emp.designation_id');       
        $this->db->join($tbl_leave_level, $tbl_leave_level. '.emp_id = emp.emp_id');
        $this->db->where('recommender_id', $login_user);
        $this->db->where("recommender_id != forwarder_id",null,false); 
		$equal = "((emp_leave_forword_type = 1 or emp_leave_forword_type = 2 ) and emp_leave_approval_type = 0 and emp_leave_recommend_type = 0 )";
		$this->db->where($equal,null,false);
		if($leave_type != '') {
           if($leave_type == 'ld'){
			   //$this->db->where('emp_leave_sub_type', 'ld'); 
			   $this->db->where("(emp_leave_type = 'cl' or emp_leave_type = 'lwp')");
		   } else {
			   $this->db->where('emp_leave_type', $leave_type);
		   }
        }
		$this->db->order_by('emp_leave_create_date', 'ASC');
        $query = $this->db->get();
        //echo $this->db->last_query();
        $rows['query'] = $query->result();
        $rows['counts'] = $query->num_rows();
		if($return_count == true){
			return $rows['counts'];
		} else{
			return $rows;
		}
	}

	// get all leaves for pening for FORWADING accroding user role
	public function get_allforword_lists($leave_type = '', $return_count = false, $lvl = '', $login_user = null, $current_emp_section_id = null,$limit = null,$offset = null)
	{
		$level = '';
		if($this->input->get('lvl') == 'all' || $lvl == 'all'){
			$level = 'all';
		}

		$employee_ids = array(0);
		$userrole = checkUserrole($login_user); // get user role
		if(empty($login_user)){
			$login_user = $this->session->userdata("emp_id");
		}
		if(empty($current_emp_section_id)){
			$current_emp_section_id = $this->session->userdata("emp_section_id");
		}
		$get_emp_est_ps = get_section_employee(7,3);
		foreach($get_emp_est_ps as $emp){
			$get_ps_emp = $emp->emp_id;
		}
		
		//get under employee
		$empids = $this->get_under_forwader_employees($login_user);
        if(!empty($empids)){
			foreach ($empids as $empid) {
				$employee_ids[] = $empid->emp_id;
			}
		}
		
		$tbl_leave_movement = LEAVE_MOVEMENT;
		$tbl_employee = EMPLOYEES;
		$tbl_employee_role = EMPLOYEEE_ROLE;
		
		$select = "lm.*,emprole_name_hi,
			emp.emp_title_hi as user_title_hi,emp.emp_title_en as user_title_en,emp.emp_full_name_hi as emp_full_name_hi,emp.emp_full_name as emp_full_name,emp.emp_unique_id as emp_unique_id,
			empf.emp_title_hi as forworder_title_hi,empf.emp_title_en as forworder_title_en,empf.emp_full_name_hi as forworder_name
		";
		
		$this->db->select($select);
		$this->db->from($tbl_leave_movement.' as lm');
        $this->db->join($tbl_employee.' as emp', 'lm.emp_id = emp.emp_id');
		$this->db->join($tbl_employee.' as empf', 'lm.emp_leave_forword_emp_id = empf.emp_id','LEFT'); 
        $this->db->join($tbl_employee_role, $tbl_employee_role . '.role_id = emp.designation_id');
		
		if($this->input->get('nt') == 'no_appr') {
			$equal = "(emp_leave_forword_type != 0 and emp_leave_forword_type != 4 and emp_leave_approval_type = 2)";
        } else{
			$equal = "(emp_leave_forword_type = 0 and emp_leave_approval_type = 0)";
		}
		switch($userrole){
			case 1 :  //for admin show all lists
				$this->db->where("emp_leave_forword_type != " , 3);
				$this->db->where("emp_leave_approval_type" , 0);
			break;
			case 4 :  // for secretary est show only lower level
				if ((in_array(7, explode(',',$current_emp_section_id )) && $userrole == 4) ){ //for established sec
					$this->db->where("emp_leave_forword_type !=", 3);
					if($level == 'all'){
						$this->db->where("emp_leave_forword_type !=", 0);
						$this->db->where("emp_leave_forword_type !=", 4);
						$this->db->where("emp_leave_forword_emp_id !=", $login_user);
						$this->db->where("emp_leave_forword_emp_id !=", $get_ps_emp);
						$this->db->where("emp_leave_approval_type", 0);
					} else if($this->input->get('nt') == 'no_appr') {
						$this->db->where('emp_leave_approval_type', 2);
					} else{
						$this->db->where("emp_leave_approval_type", 0);						
						$this->db->where("emp_leave_forword_emp_id !=", $login_user);
					}
				} else { 
					$this->db->where($equal); 
				} 
			
			break;
			case 3 :  // for PS show all lists
				$this->db->where($equal);
			default:  // for others show all but according under employes
				$this->db->where($equal);
			break;

		}
		if($leave_type != '') {
           if($leave_type == 'ld'){
			   $this->db->where('emp_leave_sub_type', 'ld');
			   $this->db->where("(emp_leave_type = 'cl' or emp_leave_type = 'lwp')");
		   } else {
			   $this->db->where('emp_leave_type', $leave_type);
		   }
        }
		if($level == ''  && $userrole != 1){	
			//$this->db->where("emp_leave_forword_emp_id !=", $this->session->userdata("emp_id") );		
			$this->db->where_in('emp.emp_id', $employee_ids);
		}
	    $this->db->order_by('emp_leave_create_date', 'ASC');
		if(!empty($limit)){
			$this->db->limit($limit, $offset);
		}
        $query = $this->db->get();
        //echo $this->db->last_query();
		$rows['query'] = $query->result();
        $rows['counts'] = $query->num_rows();
		if($return_count == true){
			return $rows['counts'];
		} else{
			return $rows;
		}
		
	}

	// gewt all leaves accrding type, status, and forward type yes -- no
    public function getAllLeaves($leave_status = '', $leave_type = '', $isforword = true) {
        
		$userrole = checkUserrole();
        $this->db->select('*');		
		$this->db->from(LEAVE_MOVEMENT);
		
        if ($leave_status == 'pending') {
			// forward type pending 
            if($isforword == true) {
                 $this->db->where('emp_leave_forword_type', 0);
            }else {
                $equal = "(emp_leave_forword_type = 1 or emp_leave_forword_type = 2 ) and (emp_leave_approval_type = 0)";
                if ($userrole == 3) {
                    $this->db->where($equal);
                    $this->db->where("(emp_leave_type = 'el' or emp_leave_type = 'hpl')");
                    $this->db->where('emp_leave_no_of_days >=', 7);
                } else {
                    $this->db->where($equal);
                }
            }
        }
        if ($leave_status == 'approve') {
            $this->db->where('emp_leave_forword_type', 1);
        }
        if ($leave_status == 'deny') {
            $this->db->where('emp_leave_forword_type', 2);
        }
        if ($leave_status == '') {
            $this->db->or_where('emp_leave_forword_type', 1);
            $this->db->or_where('emp_leave_forword_type', 2);
        }
        if (!empty($leave_type)) {
            $this->db->where('emp_leave_type', $leave_type);
        }
        $this->db->join(EMPLOYEES, EMPLOYEES . '.emp_id = ' . LEAVE_MOVEMENT . '.emp_id', 'left');
        $this->db->from(LEAVE_MOVEMENT);
        $this->db->order_by('emp_leave_movement_id', 'ASC');
        $query = $this->db->get();
        $this->db->last_query();
        return $rows = $query->result();
    }

	//get user accrding type and value
    public function getUser($search_type = '', $search_value = '') {

        if (!empty($search_type) && !empty($search_value)) {
            $employee_leave = EMPLOYEE_LEAVE;
            $employee = EMPLOYEES;
            $leave_movement = LEAVE_MOVEMENT;
            $this->db->select($employee . '.emp_id,emp_leave_movement_id,emp_unique_id,emp_full_name,emp_full_name_hi, emp_email,emp_mobile_number	,cl_leave,ol_leave,el_leave,hpl_leave,designation_id');
            $this->db->from($employee);
			$this->db->join($employee_leave, $employee_leave . '.emp_id=' . $employee . '.emp_id', 'left');
            $this->db->join($leave_movement, $leave_movement . '.emp_id=' . $employee . '.emp_id', 'left');
			$this->db->join(EMPLOYEEE_ROLE, EMPLOYEEE_ROLE . '.role_id = ' . $employee . '.designation_id');
            if ($search_type == 'User ID') {
                $this->db->where($employee . '.emp_unique_id', $search_value);
            }
            if ($search_type == 'Name') {
                $this->db->like($employee . '.emp_full_name', $search_value);
            }
            if ($search_type == 'Mobile Number') {
                $this->db->where($employee . '.emp_mobile_number', $search_value);
            }
			$this->db->where("emp_status",1);
			$this->db->where("emp_is_retired",0);
			$this->db->where("emp_is_parmanent",1);
			$this->db->where('emp_posting_location', 1);


			$this->db->where('role_leave_level !=', 0);
            $this->db->group_by($employee .'.emp_id');
			$this->db->order_by("role_leave_level", "ASC");
			$this->db->order_by("emp_full_name", "ASC");
            $query = $this->db->get();
           //echo  $this->db->last_query();
            return $rows = $query->result();
        } else {
            return false;
        }
    }

	//update leaves -- Dupp
    public function updateLeave($leave_id, $data) {
        $this->db->where('emp_leave_movement_id', $leave_id);
        return $this->db->update(LEAVE_MOVEMENT, $data);
    }

	//calcel leaves
    public function cancel_leave($id) {
        $this->db->where('emp_leave_movement_id', $id);
        $data = array(
            'emp_leave_forword_type' => '3',
            'leave_status' =>  5,
            'emp_leave_forword_date' => date('Y-m-d h:i:s'),
        );
        return $this->db->update(LEAVE_MOVEMENT, $data);
    }

	//get leaves -- Dupp
    public function getLeave($leave_id) {
        $employee_leave = LEAVE_MOVEMENT;
        $this->db->where('emp_leave_movement_id', $leave_id);
        $query = $this->db->get($employee_leave);
        return $rows = $query->row();
    }

	//get leaves using employee 
    public function getEmployeeLeave() {
		//get under employee
		$employee_ids = array(0);
		$userrole = checkUserrole();
		$current_emp_section_id = $this->session->userdata('emp_section_id');
		$empids = $this->get_under_forwader_employees();
        if(!empty($empids)){
			foreach ($empids as $empid) {
				$employee_ids[] = $empid->emp_id;
			}
		}
        $employee_leave = EMPLOYEE_LEAVE;
        $employee = EMPLOYEES;
		$tbl_employee_role = EMPLOYEEE_ROLE;
		$tbl_employee_details = EMPLOYEE_DETAILS;
		$emp_section = $this->session->userdata("emp_section_id");
        $this->db->select($employee . '.emp_id,emp_unique_id,emp_full_name,emp_email,emp_mobile_number,emp_full_name_hi, cl_leave,ol_leave,el_leave,hpl_leave,pat_leave,mat_leave,child_leave,ot_leave,other_leave,emp_previous_el,designation_id,emp_detail_gender,emprole_name_hi,emp_class');
        $this->db->from($employee);
        $this->db->join($employee_leave, $employee_leave . '.emp_id=' . $employee . '.emp_id','left');
		$this->db->join($tbl_employee_role, $tbl_employee_role . '.role_id = ' . $employee . '.designation_id');
        $this->db->join($tbl_employee_details, $tbl_employee_details . '.emp_id = ' . $employee . '.emp_id');
        $this->db->where('designation_id !=', 1);
        $this->db->where("emp_status",1);
        $this->db->where("emp_is_retired",0);
        $this->db->where("emp_is_parmanent",1);

		$this->db->where('role_leave_level !=', 0);
		$this->db->order_by("role_leave_level", "ASC");
		$this->db->order_by("emp_full_name", "ASC");
		if((in_array(7, explode(',', $current_emp_section_id ))) &&  (in_array($userrole, array(1,3,4,8,11))) || enable_order_gen($this->session->userdata('emp_id')) == true){
		} else{ 
			$this->db->where('emp_posting_location', 1);
			$this->db->where_in($employee . '.emp_id', $employee_ids);
		}
        //$this->db->where('designation_id > ', $this->session->userdata('user_designation'));
        //$this->db->where("FIND_IN_SET($emp_section, `emp_section_id`)");
	    $this->db->order_by("designation_id", "ASC");
		$this->db->order_by("emp_full_name", "ASC");
		$query = $this->db->get();
        //echo $this->db->last_query();
        return $rows = $query->result();
    }

	//get levaes details forward or not
    public function getAllLeavesDetails($isforword = false) {
        $employee_leave_movement = LEAVE_MOVEMENT;
        $employee = EMPLOYEES;
        $this->db->select($employee . '.emp_id,emp_leave_reason,emp_unique_id,emp_leave_movement_id,emp_full_name,emp_full_name_hi, emp_leave_type,emp_leave_no_of_days,emp_leave_forword_emp_id,emp_leave_forword_type,emp_leave_forword_date,designation_id,emp_leave_approval_type,emp_leave_approvel_date,emp_leave_create_date,emp_leave_date,	emp_leave_end_date');
        //$this->db->where('emp_leave_forword_emp_id',$this->session->userdata('emp_id'));
        $crnt_emp_id = 	$this->session->userdata('emp_id');
        $userrole = checkUserrole();
        
        if($isforword && in_array($userrole, array(1, 3, 4))){
           $this->db->where('emp_leave_forword_emp_id', $crnt_emp_id);
        } else {
            if (in_array($userrole, array(5, 6, 7, 8, 11, 14,15,37))) {
                $this->db->where('emp_leave_forword_emp_id', $crnt_emp_id);
            }
            if (in_array($userrole, array(1, 3, 4))) {
                $this->db->where('emp_leave_approval_emp_id', $crnt_emp_id);
            }
        }
        $this->db->from($employee);
        $this->db->where('emp_leave_forword_type !=', 3);
        $this->db->where('emp_leave_approval_type !=', 3);
        $this->db->join($employee_leave_movement, $employee_leave_movement . '.emp_id=' . $employee . '.emp_id');
        $this->db->order_by('emp_leave_date', 'desc');
        $this->db->limit(500);
        $query = $this->db->get();
        $this->db->last_query();
        return $rows = $query->result();
    }
	
//for genertae order
	public function generate_order($date = null, $employees_class = null, $emp_unique_id = null){  		
        $employee_leave_movement = LEAVE_MOVEMENT;
        $employee = EMPLOYEES;
        $employee_details = EMPLOYEE_DETAILS;
		$tbl_employee_role = EMPLOYEEE_ROLE;
		$tbl_digital_sign = DIGITAL_SIGNATURE_LEAVE;
        $select = "lm.*,ds_leave_mov_id,
			emp.emp_id as emp_id, emp.emp_full_name as emp_full_name, emp.emp_full_name_hi as emp_full_name_hi, emp.emp_unique_id as emp_unique_id,emp.designation_id as designation_id,empda.emp_detail_gender as emp_detail_gender,emprole_name_hi,
			empa.emp_full_name_hi as approver_name, empda.emp_detail_gender as approver_gender
		";
        $this->db->select($select);    
       
        $this->db->from($employee_leave_movement. ' as lm');
		$this->db->join($employee.' as emp', 'lm.emp_id = emp.emp_id','left');
        $this->db->join($employee_details.' as empd', 'empd.emp_id= emp.emp_id','left');
		$this->db->join($employee.' as empa', 'lm.emp_leave_approval_emp_id = empa.emp_id','left');
		$this->db->join($employee_details.' as empda', 'empda.emp_id = empa.emp_id','left');
		$this->db->join($tbl_employee_role, $tbl_employee_role . '.role_id = emp.designation_id');
		$this->db->join($tbl_digital_sign,  'lm.emp_leave_movement_id = '.$tbl_digital_sign.'.ds_leave_mov_id','left');
        $this->db->where("(emp_leave_type = 'el' or emp_leave_type = 'hpl')");
        $this->db->where('emp_leave_approval_type',1);
		if($date != null){		
			$this->db->where("date(emp_leave_approvel_date)", $date);
		}
		if($employees_class != null){		
			$this->db->where("empd.emp_class", $employees_class);
		}
		if($emp_unique_id != null){		
			$this->db->where("emp.emp_unique_id", $emp_unique_id);
		}
	    $this->db->order_by('date(emp_leave_approvel_date)', 'DESC');
	    $this->db->order_by('emp_leave_date', 'DESC');
        //$this->db->limit(500);
        $query = $this->db->get();
        //echo  $this->db->last_query();
        return $rows = $query->result();
    }
	
//appplication date wise searching
	public function leave_applications($date = null, $employees_class = null){       
        $employee_leave_movement = LEAVE_MOVEMENT;
        $employee = EMPLOYEES;
		$employee_details = EMPLOYEE_DETAILS;
		$tbl_employee_role = EMPLOYEEE_ROLE;
		 $select = "lm.*,
			emp.emp_id as emp_id, emp.emp_full_name as emp_full_name, emp.emp_full_name_hi as emp_full_name_hi, emp.emp_unique_id as emp_unique_id,emp.designation_id as designation_id,empd.emp_detail_gender as emp_detail_gender,emprole_name_hi
		";
        $this->db->select($select);  
        $this->db->from($employee_leave_movement. ' as lm');
		$this->db->join($employee.' as emp', 'lm.emp_id = emp.emp_id','left');
        $this->db->join($employee_details.' as empd', 'empd.emp_id= emp.emp_id','left');	
		$this->db->join($tbl_employee_role, $tbl_employee_role . '.role_id = emp.designation_id');
        $this->db->where("(emp_leave_type = 'el' or emp_leave_type = 'hpl')");
        $this->db->where('emp_leave_approval_type != ',1);
		if($date != null){		
			$this->db->where("date(emp_leave_create_date)", $date);			
		}
		if($employees_class != null){		
			$this->db->where("empd.emp_class", $employees_class);
		} 
		$this->db->where('emp_leave_forword_type !=', 3);
        $this->db->where('emp_leave_approval_type !=', 3);
	    $this->db->order_by('emp_leave_date', 'DESC');
        //$this->db->limit(500);
        $query = $this->db->get();
       // echo $this->db->last_query();
        return $rows = $query->result();
    }
	
	//get all lists which are  approve by emp
	 public function get_approved_lists($type = null,$limit = 500) {
        $employee_leave_movement = LEAVE_MOVEMENT;
        $employee = EMPLOYEES;
		$employee_details = EMPLOYEE_DETAILS;
		$tbl_employee_role = EMPLOYEEE_ROLE;
		$userrole = checkUserrole();
		$crnt_emp_id = 	$this->session->userdata('emp_id');
	    $emp_section = $this->session->userdata("emp_section_id");
		$select = "lm.*,
			emp.emp_id as emp_id, emp.emp_full_name as emp_full_name, emp.emp_full_name_hi as emp_full_name_hi, emp.emp_unique_id as emp_unique_id,emp.designation_id as designation_id,empda.emp_detail_gender as emp_detail_gender,emprole_name_hi,
			empf.emp_full_name_hi as forworder_name, empdf.emp_detail_gender as forworder_gender,
			empa.emp_full_name_hi as approver_name, empda.emp_detail_gender as approver_gender
		";
        $this->db->select($select);        
        $this->db->from($employee_leave_movement.' as lm');        
        $this->db->join($employee.' as emp', 'lm.emp_id = emp.emp_id');
		$this->db->join($employee_details.' as empd', 'empd.emp_id = emp.emp_id');
		$this->db->join($employee.' as empf', 'lm.emp_leave_forword_emp_id = empf.emp_id'); 
		$this->db->join($employee_details.' as empdf', 'lm.emp_leave_forword_emp_id = empdf.emp_id');		
		$this->db->join($employee.' as empa', 'lm.emp_leave_approval_emp_id = empa.emp_id');
		$this->db->join($employee_details.' as empda', 'empda.emp_id = empa.emp_id');
        $this->db->join($tbl_employee_role, $tbl_employee_role . '.role_id = emp.designation_id');
        if ((in_array(7, explode(',',$emp_section)) && $userrole == 8) || $userrole == 1 ){
           $this->db->where('emp_leave_approval_type', 1);
        } else{
			$this->db->where('emp_leave_approval_emp_id', $crnt_emp_id);
		}
		if($type != null){
			$this->db->where('emp_leave_approval_type',$type);      
        } else {
			$this->db->where('emp_leave_approval_type',1);
		}		
		$this->db->order_by('emp_leave_approvel_date', 'desc');
        $this->db->limit($limit);
        $query = $this->db->get();
        //echo $this->db->last_query();
        return $rows = $query->result();
    }
	
	// forwoard lists 
    public function get_forworded_lists($type = null) {
        $leave_movement = LEAVE_MOVEMENT;
        $employee = EMPLOYEES;
		$employee_details = EMPLOYEE_DETAILS;
		$tbl_employee_role = EMPLOYEEE_ROLE;
        $this->db->select($employee . '.emp_id,emp_full_name,emp_full_name_hi,emp_unique_id,designation_id,emp_detail_gender,emprole_name_hi,'.$leave_movement.'.*');        
        $this->db->from($employee);
        $this->db->join($leave_movement, $leave_movement . '.emp_id=' . $employee . '.emp_id');
        $this->db->join($tbl_employee_role, $tbl_employee_role . '.role_id = ' . $employee . '.designation_id');
		$this->db->join($employee_details, $employee_details . '.emp_id=' . $employee . '.emp_id');
		$this->db->where('emp_leave_forword_emp_id',$this->session->userdata('emp_id'));      
        if($type != null){
			$this->db->where('emp_leave_forword_type',$type);      
        } else {
			$this->db->where('emp_leave_forword_type',1);
		}
		
		$this->db->order_by('emp_leave_forword_date', 'desc');
        $query = $this->db->get();
        //echo  $this->db->last_query();
        return $rows = $query->result();
    }

	//get single emp details
    public function getSingleEmployee($emp_id) {
        $employee = EMPLOYEES;
        $employee_details = EMPLOYEE_DETAILS;
        $this->db->select('emp_unique_id,emp_full_name, emp_full_name_hi,'.$employee.'.emp_id,designation_id,emp_gradpay,emp_houserent');
        $this->db->where($employee.'.emp_id', $emp_id);
        $this->db->from($employee);
		$this->db->join($employee_details, $employee_details . '.emp_id=' . $employee . '.emp_id');
        $query = $this->db->get();
        return $query->row();
    }

	//get all type of reprts using fileds
    function get_reports($start_date, $end_date, $emp_id, $leave_type, $emp_section_id = '', $isdistinct = true, $sub_leave_type = null, $leave_status = null, $emp_class = null) {
       
		$employee_leave_movement = LEAVE_MOVEMENT;
        $employee = EMPLOYEES;
        $employee_details = EMPLOYEE_DETAILS;
        if ($isdistinct) {
            $this->db->select($employee_leave_movement.".emp_id");
        } else {
            $this->db->select('*');
        }
		$this->db->from($employee_leave_movement);
        $this->db->join($employee, $employee_leave_movement . '.emp_id=' . $employee . '.emp_id');
		if (!empty($emp_class)) {
			$this->db->join($employee_details, $employee_leave_movement . '.emp_id=' . $employee_details . '.emp_id');
            $this->db->where('emp_class	', $emp_class);
		}
		$start_date  = get_date_formate($start_date, 'Y-m-d');
		$end_date  = get_date_formate($end_date, 'Y-m-d');
		//$this->db->where("((emp_leave_date BETWEEN  '$start_date' AND '$end_date') or (emp_leave_end_date BETWEEN  '$start_date' AND '$end_date'))",null, FALSE);	
		//$this->db->where("(emp_leave_date BETWEEN  '$start_date' AND '$end_date')",null, FALSE);	
        
       $this->db->where("((emp_leave_date <= '$start_date' and  emp_leave_end_date >= '$start_date') or  (emp_leave_end_date <= '$start_date' and  emp_leave_end_date >='$start_date'))");

        if ($emp_id != '') {
            $this->db->where($employee_leave_movement . '.emp_id', $emp_id);
        }
        if ($leave_type != '') {
            $this->db->where('emp_leave_type', $leave_type);
        }
        if ($emp_section_id != '') {
            $this->db->where_in('emp_section_id', $emp_section_id);
        }
		if ($sub_leave_type != null) {
            $this->db->where('emp_leave_sub_type', $sub_leave_type);
        }
        $this->db->where('emp_is_retired', 0);


        $this->db->where('emp_status', 1);
		 if ($leave_status == 'pending') {
            $equal = "( emp_leave_forword_type = 0 or emp_leave_forword_type = 1 or emp_leave_forword_type = 2 ) and (emp_leave_approval_type = 0)";
            $this->db->where($equal);
        } 
        if ($leave_status == 'approve') {
            $equal = "(emp_leave_approval_type = 1)";
            $this->db->where($equal);
        }
        if ($leave_status == 'deny') {
            $equal = "( emp_leave_forword_type = 2 or emp_leave_approval_type = 2)";
            $this->db->where($equal);
        }
        if ($leave_status == 'cancel') {
            $equal = "( emp_leave_forword_type = 3 or emp_leave_approval_type = 3)";
            $this->db->where($equal);
        }
        if ($leave_status == 'approve_deny') {
            $equal = "( emp_leave_forword_type = 1 or emp_leave_approval_type = 1 or emp_leave_forword_type = 2 or emp_leave_approval_type = 2)";
            $this->db->where($equal);
        }
        if ($leave_status == 'approve_deny_peding') {
             $this->db->where('emp_leave_forword_type !=', 3);
   			 $this->db->where('emp_leave_approval_type !=', 3);
        } 
		if ($isdistinct) {
			$this->db->group_by($employee_leave_movement.'.emp_id');
		}
		$this->db->order_by('emp_leave_date','ASC');
        $this->db->order_by('emp_full_name','ASC');
		$query = $this->db->get();
       // echo $this->db->last_query();
        return $rows = $query->result();
    }

	// get ttotsl levae s
    public function getTotalLeave($emp_id, $leave_type = '') {
        
        $employee_leave = EMPLOYEE_LEAVE;
        if($leave_type == ''){
            $this->db->select('*');
        }else{
            $leave_type = $leave_type == 'hq' || $leave_type == 'ihpl' || $leave_type == 'sl' ? 'other' : $leave_type ;
            $leave = $leave_type.'_leave';
            $this->db->select($leave);
        }
        $this->db->where('emp_id', $emp_id);
        $this->db->from($employee_leave);
        $query = $this->db->get();
        $this->db->last_query();
        $rows = $query->row();
        if($leave_type == ''){
            return $rows;
        }else{
            return $rows->$leave;
        } 
    } 
	
	// get reramiong levaes of emp
    public function get_remaining_leaves($id = '', $leave_type, $type_of_hpl, $isall = false) {
        $leave_movement = LEAVE_MOVEMENT;
        if($isall){
            $this->db->select('*');
        }else{
            $this->db->select('sum(emp_leave_no_of_days) as total');
        }
        if ($id == '') {
            $emp_id = $this->session->userdata('emp_id');
        } else {
            $emp_id = $id;
        }
        $this->db->where('emp_id', $emp_id);
        $leave_type = $leave_type == 'hq' || $leave_type == 'ihpl' || $leave_type == 'sl' || $leave_type == 'jr' || $leave_type == 'lwp' ? 'other' : $leave_type ;
        $this->db->where('emp_leave_type', $leave_type);
        $this->db->where('emp_leave_approval_type = 0 AND emp_leave_forword_type !=3');
        $this->db->from($leave_movement);
        $query = $this->db->get();
        //echo $this->db->last_query();
        $ret = $query->row();
        $total_rem = $this->getTotalLeave($emp_id,$leave_type);
        if($isall){
            return $ret;
        }else{
            if($type_of_hpl == 'hpl'){
                if($type == 'GG') {
                    return ($total_rem - ($ret->total * 2))/2;
                 } else {
                    return ($total_rem - ($ret->total * 2))/4;
                 }
            }else{
                return $total_rem - $ret->total;
            }
        }
    }

	// all under emp
    public function getUnderEmployee($emp_id = '') {
        $hiraarchi_level = EMPLOYEE_HIARARCHI_LEVEL;
		if($emp_id != ''){
			$emp_id = $this->db->where('emp_id', $emp_id);
		} else{
			$emp_id = $this->session->userdata('emp_id');
		}
       
        $query = $this->db->get($hiraarchi_level);
        //echo $this->db->last_query();
        return $rows = $query->result();
    }

	//get all user under emp
	public function getUnderEmployeeUser($emp_id = '') {
        $employee_ids = array();
        $empids = $this->getUnderEmployee($emp_id);
        foreach ($empids as $empid) {
            $employee_ids[] = $empid->under_emp_id;
        }
        if ($employee_ids) {
            $employee_leave = EMPLOYEE_LEAVE;
            $employee = EMPLOYEES;
            $this->db->select($employee . '.emp_id,emp_unique_id,emp_full_name,emp_full_name_hi, emp_email,emp_mobile_number,cl_leave,ol_leave,el_leave,hpl_leave,designation_id');
            $this->db->from($employee);
            $this->db->join($employee_leave, $employee_leave . '.emp_id=' . $employee . '.emp_id', 'left');
            $this->db->join(EMPLOYEEE_ROLE, EMPLOYEEE_ROLE . '.role_id = ' . $employee . '.designation_id');
		    $this->db->where_in($employee_leave . '.emp_id', $employee_ids);
			$this->db->where("emp_status",1);
			$this->db->where("emp_is_retired",0);
			$this->db->where("emp_is_parmanent",1);
			$this->db->where('emp_posting_location', 1);

			$this->db->where('role_leave_level !=', 0);
			$this->db->order_by("role_leave_level", "ASC");
			$this->db->order_by("emp_full_name", "ASC");
            $query = $this->db->get();
            //echo $this->db->last_query();
            return $rows = $query->result();
        } else {
            return false;
        }
    }

	//update leave movement table
    public function updateLeaveMovement($udata, $leave_movement_id) {
        $leave_movement = LEAVE_MOVEMENT;
        $this->db->where('emp_leave_movement_id', $leave_movement_id);
        return $this->db->update($leave_movement, $udata);
    }

	//save leave reamrk
    public function saveLeaveRemark($data) {
        $leave_remark = LEAVE_REMARK;
        return $this->db->insert($leave_remark, $data);
    }

	//get all aplied lists whixch are other emp applied on behalf
    public function get_applied_lists() {
        $leave_movement = LEAVE_MOVEMENT;
        $employee = EMPLOYEES;
        $this->db->select('*');
        $this->db->where('on_behalf_leave',$this->session->userdata('emp_id'));      
        $this->db->where($leave_movement . '.emp_id != ', $this->session->userdata('emp_id') ); 
        $this->db->from($employee);
        $this->db->join($leave_movement, $leave_movement . '.emp_id=' . $employee . '.emp_id');
        $this->db->order_by('emp_leave_create_date', 'desc');
        $query = $this->db->get();
       //echo  $this->db->last_query();
        return $rows = $query->result();
    }

	
    
    //leave check
   /* public function is_leave_exits($emp_id, $date, $leave_type) {
        $date = date('Y-m-d',strtotime($date));
        if ($this->check_leave_date($emp_id, $date)) {
            if ($leave_type == 'hpl' || $leave_type == 'el') {
                $this->check_leave_date_before_after($emp_id, $date);
            } else {
                return false;
            }
        } else {
            return true;
        }
    } */

	//check leave exsists on date on basis same daya or other days 
    public function is_leave_exits($emp_id, $date, $end_date, $leave_type = '', $otherday = false) {
	    $apply_date = strtotime($date);
        $apply_end_date = strtotime($end_date);
        $this->db->select('*');
        $this->db->where('emp_id', $emp_id);
        $this->db->where('emp_leave_forword_type !=', 3);
       /// $this->db->where('emp_leave_sub_type !=', 'ld');
	   $this->db->where('emp_leave_sub_type is null', null, false);
        $this->db->where_in('emp_leave_type', array('cl','ol','el','hpl')); // only this leaves are appply
        $this->db->where('emp_leave_approval_type !=', 3);
        $otherday ? $this->db->where('emp_leave_date !=', date('Y-m-d', $apply_date)) : '' ;
        $this->db->from(LEAVE_MOVEMENT);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {
            //echo $query->num_rows(); exit;
            foreach ($query->result() as $row) {
                $start_date = strtotime($row->emp_leave_date);
                $end_date = strtotime($row->emp_leave_end_date);
                if ($apply_date >= $start_date && $apply_date <= $end_date) {
                    $return = false; 
                }  else {
                    $return = true; 
                }
                /* else if ($apply_end_date >= $start_date) {
                    $return = false;  
                } */
               if($return == false) { return  true; break; } 
            }
        } else {
            return false;
        }
    }
    
	//leave aapplied after date
    public function check_leave_date_after($emp_id, $date, $isel_hpl = false) {
        $apply_date = strtotime($date);
        $this->db->select('*');
        $this->db->where('emp_id', $emp_id);
        if($isel_hpl == true){
            $where = "(emp_leave_type = 'hpl' or emp_leave_type = 'el')";
        } else{
            $where = "((emp_leave_type = 'cl' and (emp_leave_half_type = '' or emp_leave_half_type = 'SH')) or emp_leave_type = 'ol')";
        }
        $this->db->where('emp_leave_forword_type !=', 3);
        $this->db->where('emp_leave_approval_type !=', 3);
        //$this->db->where('emp_leave_sub_type !=', 'ld');
		$this->db->where('emp_leave_sub_type is null', null, false);
        $this->db->where($where);
        $this->db->from(LEAVE_MOVEMENT);
        $query = $this->db->get();
       //echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $start_date = strtotime($row->emp_leave_date.' +1 day');
                $end_date_after = strtotime($row->emp_leave_end_date.' +1 day'); 
                if ($apply_date >= $start_date && $apply_date <= $end_date_after) {
                    $return = true;
                } else {
                    $return =  false;
                }
                if($return == true) { return  true; break; } 
            }
        } else{
           return false;
        }
    }
	
	//leave aapplied before date
    public function check_leave_date_before($emp_id, $date, $isel_hpl = false) {
        
		$apply_date = strtotime($date);
        $this->db->select('*');
        $this->db->where('emp_id', $emp_id);
        if($isel_hpl == true){
            $where = "(emp_leave_type = 'hpl' or emp_leave_type = 'el')";
        } else{
            $where = "((emp_leave_type = 'cl' and (emp_leave_half_type = '' or emp_leave_half_type = 'SH')) or emp_leave_type = 'ol')";
        }
        $this->db->where('emp_leave_forword_type !=', 3);
        $this->db->where('emp_leave_approval_type !=', 3);
        //$this->db->where('emp_leave_sub_type !=', 'ld');
		$this->db->where('emp_leave_sub_type is null', null, false);
        $this->db->where($where);
        $this->db->order_by('emp_leave_date', 'DESC');
        $this->db->from(LEAVE_MOVEMENT);
        $query = $this->db->get();
       //echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {
            foreach ($query->result() as $row) {
                $start_date = strtotime($row->emp_leave_date.' -1 day');             
			    $end_date_after = strtotime($row->emp_leave_end_date); 
                if ($apply_date >= $start_date && $apply_date <= $end_date_after) {
                    $return = true;
                } else {
                    $return =  false;
                }
                if($return == true) { return  true; break; } 
            }
        } else{
           return false;
        }
    }
    
	//before holday leave aaplied or not
    public function is_leave_exits_before_holiday($emp_id, $date, $isel_hpl = false){
        $leave_dates_interval = array();
        if($isel_hpl == false){
            $last_leave = $this->leave_model->get_last_leave($emp_id, '', true);
        }else{
            $last_leave = $this->leave_model->get_last_leave($emp_id);
        }
        if($last_leave !== false) {
            $last_leave_date = $last_leave[0]->last_leave;
            $last_date_after = date('Y-m-d', strtotime($last_leave_date . ' +1 day'));
            $diff = day_difference_dates($last_date_after, $date);
            if($diff < 7){
                for ($i = 1; $i <= $diff; $i++) {
                    $date_counter = date('Y-m-d', strtotime($last_leave_date . ' +' . $i . ' day'));
                    $response = check_holidays($date_counter);
                    if ($response == true) {
                        $leave_dates_interval[] = $date_counter;
                    } else{
                        return false;
                    }
                }
                if(!empty($leave_dates_interval)){
                    return true;
                }else {
                    return false;
                }
            }
            else {
                return false;
            }
        } else {
            return false;
        }
        
    }
    
	//get last applied leave
    public function get_last_leave($emp_id, $leave_id = '', $isother = false){
        $this->db->select('max(emp_leave_end_date) as last_leave');
        $this->db->where('emp_id', $emp_id);
        $this->db->where('emp_leave_forword_type !=', 3);
        $this->db->where('emp_leave_approval_type !=', 3);
		//$this->db->where('emp_leave_sub_type !=', 'ld');
		$this->db->where('emp_leave_sub_type is null', null, false);
        if($leave_id != ''){
            $this->db->where('emp_leave_movement_id !=', $leave_id);
        }
        if($isother == false){
            $where = "(emp_leave_type = 'el' or emp_leave_type = 'hpl')";
        }else{
            $where = "(emp_leave_type = 'cl' or emp_leave_type = 'ol')"; 
        }
        $this->db->where($where);
        $this->db->limit('1');
        $this->db->from(LEAVE_MOVEMENT);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        $rows = $query->result();
        if ($query->num_rows() > 0 && $rows[0]->last_leave != '') {
            return $rows;
        } else {
            return false;
        }
        
    }

	// on date aplied leave 
    public function is_leave_exits_ondate($emp_id, $date, $isreturn = false) {
        $this->db->select('*');
        $this->db->where('emp_id', $emp_id);
        $this->db->where('emp_leave_date', $date);
        $this->db->where('emp_leave_forword_type !=', 3); // 3 for csancel leaves
        $this->db->where('emp_leave_approval_type !=', 3);
		//$this->db->where('emp_leave_sub_type !=', 'ld');
		$this->db->where('emp_leave_sub_type is null', null, false);
        $where = "(emp_leave_type = 'cl' or emp_leave_type = 'ol')";
        $this->db->where($where);
        $this->db->limit('1');
        $this->db->order_by('emp_leave_create_date','desc');
        $this->db->from(LEAVE_MOVEMENT);
        $query = $this->db->get();
        // echo $this->db->last_query(); exit;
        if($isreturn){
            return $query->result();
        }else{
            if ($query->num_rows() > 0) {
                //echo $query->num_rows(); exit;
                 return true;
            } else {
                return false;
            }
        }
    }
    
	//update if el applied on cl-ol and el-hpl apprved 
    public function update_leave_exists($data){
        if($data[0]->emp_leave_approval_type == 1 ){
            $upt_data_appr = array(
               'leave_status' => 5,
               'emp_leave_forword_type' => '3',
               'emp_leave_approval_type' => '3',
               'emp_leave_deny_reason' => 'इस दिनांक को अन्य अवकाश लिया',
            );
            $this->db->where('emp_leave_movement_id', $data[0]->emp_leave_movement_id);
            $this->db->update(LEAVE_MOVEMENT, $upt_data_appr);
            deductLeaveAdd($data[0]->emp_id, $data[0]->emp_leave_type, $data[0]->emp_leave_no_of_days);
        } else {
            $upt_data = array(
                'emp_leave_forword_type' => '3', //cancel leave over el-hpl
                'emp_leave_approval_type' => '3',
                // 'emp_leave_approvel_date' => date('Y-m-d'),
                //'emp_leave_forword_date' => date('Y-m-d'),
                'leave_status' => 5,
                'emp_leave_deny_reason' => 'Cancel and convert',
            );
            $this->db->where('emp_leave_movement_id', $data[0]->emp_leave_movement_id);
            $this->db->update(LEAVE_MOVEMENT, $upt_data);

        }
        return true;
    }
    
    public function adjust_leave($id, $upt_data){
        $this->db->where('emp_leave_movement_id', $id);
        $this->db->update(LEAVE_MOVEMENT, $upt_data);
    }
    
    
    /* leave level employeee model start*/
    public function get_leave_under_employees() {
        $employee_ids = $empids = array(); 
        $empids = $this->get_under_forwader_employees();
        if ($empids) {
			foreach ($empids as $empid) {
				$employee_ids[] = $empid->emp_id;
			}
		}
        if ($employee_ids) {
            $employee_leave = EMPLOYEE_LEAVE;
            $employee = EMPLOYEES;
			$employee_details = EMPLOYEE_DETAILS;
			$tbl_employee_role = EMPLOYEEE_ROLE;		
			$select = "emp.emp_id as emp_id,emp.emp_unique_id as emp_unique_id,emp.emp_full_name as emp_full_name,emp.emp_full_name_hi as emp_full_name_hi, emp.emp_email as emp_email,emp.emp_mobile_number as emp_mobile_number, emp.designation_id as designation_id,
				empl.cl_leave as cl_leave, empl.ol_leave as ol_leave,empl.el_leave as el_leave, empl.hpl_leave as hpl_leave,
				empd.emp_detail_gender as emp_gender, empr.emprole_name_hi  as emp_role_name
			"; 
            $this->db->select($select);
            $this->db->from($employee_leave.' as empl');
            $this->db->join($employee.' as emp','empl.emp_id = emp.emp_id');
			$this->db->join($employee_details.' as empd', 'empd.emp_id = emp.emp_id');
			$this->db->join($tbl_employee_role.' as empr', 'empr.role_id = emp.designation_id');
            $this->db->where_in('emp.emp_id', $employee_ids);
			$this->db->where("emp.emp_status",1);
			$this->db->where("emp.emp_is_retired",0);
			$this->db->where("emp.emp_is_parmanent",1);
			$this->db->where('emp_posting_location', 1);
			
			$this->db->where('role_leave_level !=', 0);
			$this->db->order_by("role_leave_level", "ASC");
			$this->db->order_by("emp_full_name", "ASC");
			$this->db->order_by('emp.emp_full_name_hi', 'ASC');
			$query = $this->db->get();
           // echo $this->db->last_query();
            return $rows = $query->result();
        } else {
            return false;
        }
    }
    
    public function get_under_forwader_employees($id = ''){
        $this->db->select('*');
        if($id == ''){
            $emp_id = $this->session->userdata('emp_id');
        }else{
            $emp_id = $id;
        }
        if($this->session->userdata('user_role') != 1 ){
           $this->db->where('forwarder_id', $emp_id); 
        }
        $this->db->join(EMPLOYEE_LEAVE_LEVEL_MASTER, EMPLOYEE_LEAVE_LEVEL_MASTER . '.emp_id = ' . EMPLOYEES . '.emp_id');
        $this->db->from(EMPLOYEES);
		$this->db->order_by('designation_id', 'ASC');
		$this->db->order_by('emp_full_name_hi', 'ASC');
        $query = $this->db->get();
        //echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    public function get_under_recommender_employees($id = ''){
        $this->db->select('*');
        if($id == ''){
            $emp_id = $this->session->userdata('emp_id');
        }else{
            $emp_id = $id;
        }
        $this->db->where('recommender_id', $emp_id);
        $this->db->join(EMPLOYEE_LEAVE_LEVEL_MASTER, EMPLOYEE_LEAVE_LEVEL_MASTER . '.emp_id = ' . EMPLOYEES . '.emp_id');
        $this->db->from(EMPLOYEES);
		$this->db->order_by('designation_id', 'ASC');
		$this->db->order_by('emp_full_name_hi', 'ASC');
        $query = $this->db->get();
         //echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }
    
    public function get_under_approver_employees($id = ''){
        $this->db->select('*');
        if($id == ''){
            $emp_id = $this->session->userdata('emp_id');
        }else{
            $emp_id = $id;
        }
        $this->db->where('approver_id', $emp_id);
        $this->db->join(EMPLOYEE_LEAVE_LEVEL_MASTER, EMPLOYEE_LEAVE_LEVEL_MASTER . '.emp_id = ' . EMPLOYEES . '.emp_id');
        $this->db->from(EMPLOYEES);
		$this->db->order_by('designation_id', 'ASC');
		$this->db->order_by('emp_full_name_hi', 'ASC');
        $query = $this->db->get();
           //echo $this->db->last_query(); exit;
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    }  

	public function ajax_get_leaves_taken($emp_id, $year, $leave_type, $leave_id){
        $this->db->select('emp_leave_type,emp_leave_no_of_days,emp_leave_date,emp_leave_end_date,emp_leave_reason,emp_leave_approval_type');      
        $this->db->from(LEAVE_MOVEMENT);
		if($leave_id != null){
			$this->db->where('emp_leave_movement_id', $leave_id);
		}
		$this->db->where('emp_id', $emp_id);
		$this->db->where('Year(emp_leave_date)', $year);
		if($leave_type != null){
			$this->db->where('emp_leave_type', $leave_type);
		} else{
			$this->db->where("(emp_leave_type = 'el' or emp_leave_type = 'cl')");
		}
		$this->db->where('emp_leave_approval_type !=', 3);
		$this->db->where('emp_leave_forword_type !=', 3);
		$this->db->order_by('emp_leave_date', 'ASC');
        $query = $this->db->get();
        //echo $this->db->last_query(); exit();
        if ($query->num_rows() > 0) {
            $return = $query->result_array();
        } else {
            $return = false;
        }
		return $return;
    } 
	
	public function leave_attachments($leave_id){
        $this->db->select('*');      
        $this->db->from(ATTACHMENTS);
		$this->db->where('att_movement_id', $leave_id);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit();
        if ($query->num_rows() > 0) {
            $return = $query->result();
        } else {
            $return = false;
        }
		return $return;
    } 

	public function leave_log($leave_id){
        $this->db->select('leave_movement_tip, emp.emp_title_hi as user_title_hi,emp.emp_full_name_hi as emp_full_name_hi ');
        $this->db->from(LEAVE_REMARK.' as rm');
        $this->db->join(LEAVE_MOVEMENT, 'rm.leave_movement_id = ' . LEAVE_MOVEMENT . '.emp_leave_movement_id');
        $this->db->join(EMPLOYEES.' as emp', 'emp.emp_id = rm.leave_update_emp_id');
		$this->db->where('emp_leave_movement_id', $leave_id);
		$this->db->where('is_leave_return', 1);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit();
        if ($query->num_rows() > 0) {
            $return = $query->result();
        } else {
            $return = false;
        }
		return $return;
    }

    public function december_month_cl($emp_id,$year){
        $this->db->select('SUM(`emp_leave_no_of_days`) as total_days');      
        $this->db->from(LEAVE_MOVEMENT);
		$this->db->where('month(`emp_leave_date`)', '12');
		$this->db->where('year(`emp_leave_date`)', $year);
		$this->db->where('emp_leave_approval_type !=', 3);
		$this->db->where('emp_leave_forword_type !=', 3);
		$this->db->where("(emp_leave_type = 'cl' or emp_leave_type = 'ol') ");
		$this->db->where('emp_id', $emp_id);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit();
        if ($query->num_rows() > 0) {
            $result = $query->row();
			$return = $result->total_days;
        } else {
            $return = false;
        }
		return $return;
    } 

	public function leave_deduction_exists($emp_id, $month, $year){
        $this->db->select('emp_leave_movement_id, emp_leave_type');
        $this->db->from(LEAVE_MOVEMENT);
		$this->db->where('month(`emp_leave_date`)', $month);
		$this->db->where('year(`emp_leave_date`)', $year);
		$this->db->where('emp_leave_approval_type !=', 3);
		$this->db->where('emp_leave_forword_type !=', 3);
		$this->db->where("emp_leave_sub_type = 'ld' ");
		$this->db->where('emp_id', $emp_id);
        $query = $this->db->get();
        //echo $this->db->last_query(); exit();
        if ($query->num_rows() > 0) {
           return true;
        } else {
          return false;
        }

    }

}
