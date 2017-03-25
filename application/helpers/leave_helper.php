<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

/**
 * @ Function Name      : pr
 * @ Function Params    : $data {mixed}, $kill {boolean}
 * @ Function Purpose   : formatted display of value of varaible
 * @ Function Returns   : foramtted string
 */
function getleavestatus($status) {
    if ($status == 0) {
        echo "<div class='pending'>Pending</div>";
    }
    if ($status == 2) {
        echo "<div class='deny'>Deny</div>";
    } else if ($status == 1) {
        echo "<div class='approve'>Approve</div>";
    }
}

function calculate_el($el) {
    $els = $el;
    if ($el > 240) {
        $rem = $el - 240;
        $els = "240 + " . $rem;
    }
    return $els;
}

function calculate_hpl($hpl) {
    $hpl = $hpl / 2;
    return $hpl;
}

function leaveType($leave_type, $ishindi = false) {
    $type_leave_en = array(
        'cl' => 'Casual Leave',
        'ol' => 'Optional leave',
        'el' => 'Earned leave',
        'hpl' => 'Half pay/ Commuted leave',
        'ot' => 'Official tour',
        'hq' => 'headquarter leave',
        'ihpl' => 'Leave infomation',
        'sl' => 'Special Leave',
        'comm' => 'Commuted Leave',
        'mat' => 'Maternity  Leave',
        'pat' => 'Paternity Leave',
        'child' => 'Child care Leave',
        'el_ic' => 'Leave Encashment',
		'lwp' => 'Leave Without pay',
        'ld' => 'Leave Deduction',
    );
    $type_leave_hi = array(
        'cl' => 'आकस्मिक अवकाश',
        'ol' => 'ऐच्छिक अवकाश',
        'el' => 'अर्जित अवकाश',
        'hpl' => 'अर्धवेतन/ लघुकृत अवकाश',
        'ot' => 'शासकीय  प्रवास',
        'hq' => 'मुख्यालय छोड़ना',
        'ihpl' => 'अवकाश की सूचना',
        'sl' => 'विशेष अवकाश',
        'comm' => 'लघुकृत अवकाश',
        'mat' => 'प्रसूति अवकाश',
        'pat' => 'पितृत्व अवकाश',
        'child' => 'बच्चे की देखभाल पर अवकाश',
		'el_ic' => 'अवकाश नगदीकरण',
        'lwp' => 'अवैतनिक अवकाश',
		'ld' => 'अवकाश कटोत्रा',
    );
    if ($ishindi == true) {
		if($leave_type == null){
			return $type_leave_hi;
		} else{
			if (array_key_exists($leave_type, $type_leave_hi)) {
				return $type_leave_hi[$leave_type];
			}
		}

    } else {
		if($leave_type == null){
			return $type_leave_en;
		} else{
			if (array_key_exists($leave_type, $type_leave_en)) {
				return $type_leave_en[$leave_type];
			}
		}

    }
}

// created by sulbha 28/7/2015 *** update by rohit
function deductLeave($emp_id = '', $type = '', $days = '', $headquoter_type = '', $leave = null) {

    $CI = & get_instance();
    $CI->db->where('emp_id', $emp_id);
    $query = $CI->db->get(EMPLOYEE_LEAVE);
    $row = $query->row();
    // echo $CI->db->last_query();
    $year = date('Y');
    $year_leave = get_date_formate($leave->emp_leave_date,'Y');
   
    if ($type == 'cl' &&  $year_leave == $year) {
        $cl_leave = $row->cl_leave;
        $total_leave = $cl_leave - $days;
        $data['cl_leave'] = $total_leave;
    }else{
        $data['cl_leave'] = $row->cl_leave;
    }
    if ($type == 'ol' && $year_leave == $year) {
        $ol_leave = $row->ol_leave;
        $total_leave = $ol_leave - $days;
        $data['ol_leave'] = $total_leave;
    }else{
         $data['ol_leave'] = $row->ol_leave;
    }
	
    if ($type == 'el' || $type == 'el_ic') {	
		if($leave != null){
			$year_crnt = (int)date('Y');
			$month_crnt = (int)date('m');
			$year_leave = (int)date('Y',strtotime($leave->emp_leave_date));
			$month_leave = (int)date('m',strtotime($leave->emp_leave_date));
			$day_leave = (int)date('d',strtotime($leave->emp_leave_date));
			$year_leave_end = (int)date('Y',strtotime($leave->emp_leave_end_date));
			$month_leave_end = (int)date('m',strtotime($leave->emp_leave_end_date));
			$day_leave_end = (int)date('d',strtotime($leave->emp_leave_end_date));
			
			$el_leave = (int)$row->el_leave;
			$el_leave_prv = (int)$row->emp_previous_el;
			
			$d_leave  = cal_days_in_month(CAL_GREGORIAN,$month_leave,$year_leave);
			$d_leave_end  = cal_days_in_month(CAL_GREGORIAN,$month_leave_end,$year_leave_end);
			
			
			if($month_crnt > 0 && $month_crnt < 7){
				$sub_mnth = 1;
			} else {
				$sub_mnth = 2;
			}
			if($month_leave > 0 && $month_leave < 7){
				$sub_mnth_leave = 1;
			} else {
				$sub_mnth_leave = 2;
			}
			if($month_leave_end > 0 && $month_leave_end < 7){
				$sub_mnth_leave_end = 1;
			} else {
				$sub_mnth_leave_end = 2;
			}
						
			if($el_leave_prv != 0){				
				if($year_leave == $year_leave_end){					
					if($year_crnt == $year_leave){
						if($sub_mnth_leave == $sub_mnth_leave_end){						
							if( $sub_mnth == $sub_mnth_leave){						
								$total_leave = $el_leave - $days;
								$data['el_leave'] = $total_leave;
							} else{						
								if($el_leave_prv > $days){
									$total_leave = $el_leave_prv - $days;
									$data['emp_previous_el'] = $total_leave;
								} else {
									$rem_el_ded = $days - $el_leave_prv;
									$data['el_leave'] = $el_leave - $rem_el_ded;
									$data['emp_previous_el'] = 0;
								}							
							}
						} else{ // leave month and end leave month not equal							
							$rem_days_pre = ($d_leave - $day_leave) + 1;
							$rem_days = $days - $rem_days_pre;							
							$total_leave = $el_leave - $rem_days;
							$data['el_leave'] = $total_leave;
							
							if($el_leave_prv > $rem_days_pre){
								$data['emp_previous_el'] = $el_leave_prv - $rem_days_pre;
							} else {
								$rem_el_ded = $rem_days_pre - $el_leave_prv;
								$data['el_leave'] = $el_leave - $rem_el_ded;
								$data['emp_previous_el'] = 0;
							}	
						}
					} else { // CURRNT YEAR AND PREVOUS YAR NOT EQUAL
						if($el_leave_prv > $days){
							$total_leave = $el_leave_prv - $days;
							$data['emp_previous_el'] = $total_leave;
						} else {
							$rem_el_ded = $days - $el_leave_prv;
							$data['el_leave'] = $el_leave - $rem_el_ded;
							$data['emp_previous_el'] = 0;
						}							
					}
				} else { //leave year and  end year not equal
					$rem_days_pre = ($d_leave - $day_leave) + 1;
					$rem_days = $days - $rem_days_pre;
					$total_leave = $el_leave - $rem_days;
					$data['el_leave'] = $total_leave;
					if($el_leave_prv > $rem_days_pre){
						$data['emp_previous_el'] = $el_leave_prv - $rem_days_pre;
					} else {
						$rem_el_ded = $rem_days_pre - $el_leave_prv;
						$data['el_leave'] = $el_leave - $rem_el_ded;
						$data['emp_previous_el'] = 0;
					}
				}
			} else{ // prevous balance zero

				$total_leave = $el_leave - $days;
				$data['el_leave'] = $total_leave;
			}
		} else{//$leave != null 
			pr('leave not send');
		}		
    } // el block end
	

    if ($type == 'hpl') {
        if ($headquoter_type == 'GG') {
            $hpl_leave_day = $days * 2;
        }
        if ($headquoter_type == 'MG') {
            $hpl_leave_day = $days * 2;
        }
        $hpl_leave = $row->hpl_leave;
        $total_leave = $hpl_leave - $hpl_leave_day;
        $data['hpl_leave'] = $total_leave;
    }
    if ($type == 'ot') {
        $ot_leave = $row->ot_leave;
        $total_leave = $ot_leave + $days;
        $data['ot_leave'] = $total_leave;
    }
    if ($type == 'mat') {
        $mat_leave = $row->mat_leave;
        $total_leave = $mat_leave - $days;
        $data['mat_leave'] = $total_leave;
    }
    if ($type == 'pat') {
        $pat_leave = $row->pat_leave;
        $total_leave = $pat_leave - $days;
        $data['pat_leave'] = $total_leave;
    }
    if ($type == 'child') {
        $child_leave = $row->child_leave;
        $total_leave = $child_leave - $days;
        $data['child_leave'] = $total_leave;
    }
    if ($type == 'hq' || $type == 'ihpl' || $type == 'sl'||  $type == 'jr' || $type == 'lwp') {
        $other_leave = $row->other_leave;
        $total_leave = $other_leave + $days;
        $data['other_leave'] = $total_leave;
    }
	
    $CI->db->where('emp_id', $emp_id);
    $CI->db->update(EMPLOYEE_LEAVE, $data);
    // echo $CI->db->last_query();
}

function deductLeaveAdd($emp_id = '', $type = '', $days = '') {
    $CI = & get_instance();
    $CI->db->where('emp_id', $emp_id);
    $query = $CI->db->get(EMPLOYEE_LEAVE);
    $row = $query->row();
    //echo $CI->db->last_query();

    if ($type == 'cl') {
        $cl_leave = $row->cl_leave;
        $total_leave = $cl_leave + $days;
		if($total_leave > 13){
			$total_leave = 13;
		}
        $data['cl_leave'] = $total_leave;
    }
    if ($type == 'ol') {
        $ol_leave = $row->ol_leave;
        $total_leave = $ol_leave + $days;
		if($total_leave > 3){
			$total_leave = 3;
		}
        $data['ol_leave'] = $total_leave;
    }
    if ($type == 'el' || $type == 'el_ic') {
        $el_leave = $row->el_leave;
        $total_leave = $el_leave + $days;
		if($total_leave > 255){
			$total_leave = 255;
		}
        $data['el_leave'] = $total_leave;
    }
    if ($type == 'hpl') {
        $hpl_leave = $row->hpl_leave;
        $days = $days * 2;
        $total_leave = $hpl_leave + $days;

        $data['hpl_leave'] = $total_leave;
    }
    if ($type == 'ot') {
        $ot_leave = $row->ot_leave;
        $total_leave = $ot_leave - $days;

        $data['ot_leave'] = $total_leave;
    }
    if ($type == 'mat') {
        $mat_leave = $row->mat_leave;
        $total_leave = $mat_leave + $days;
        $data['mat_leave'] = $total_leave;
    }
    if ($type == 'pat') {
        $pat_leave = $row->pat_leave;
        $total_leave = $pat_leave + $days;
        $data['pat_leave'] = $total_leave;
    }
    if ($type == 'child') {
        $child_leave = $row->child_leave;
        $total_leave = $child_leave + $days;
        $data['child_leave'] = $total_leave;
    }
    if ($type == 'hq' || $type == 'ihpl' || $type == 'sl' || $type == 'jr' || $type == 'lwp') {
        $other_leave = $row->other_leave;
        $total_leave = $other_leave - $days;
        $data['other_leave'] = $total_leave;
    }
    $CI->db->where('emp_id', $emp_id);
    return $CI->db->update(EMPLOYEE_LEAVE, $data);
}

function user_leave_today($emp_id = '', $leave_type = '') {
    $CI = & get_instance();
    $CI->db->select('*');
    $today = date('Y-m-d');
    $CI->db->where('emp_leave_date <=', $today);
    $CI->db->where('emp_leave_end_date >=', $today);
    //$CI->db->where("((emp_leave_date BETWEEN  '$today' AND '$today') or (emp_leave_end_date BETWEEN  '$today' AND '$today'))",null, FALSE);
    $CI->db->where('emp_leave_forword_type !=', 3);
    $CI->db->where('emp_leave_approval_type !=', 3);
    $CI->db->where('emp_leave_approval_type !=', 2);
    $CI->db->where('emp_leave_type !=', 'el_ic');
	$CI->db->where('emp_leave_sub_type is NULL', NULL, FALSE);
    if ($emp_id != '') {
        $CI->db->where('emp_id', $emp_id);
    }
    if ($leave_type != '') {
        $CI->db->where('emp_leave_type', $leave_type);
    }
    $CI->db->where(EMPLOYEES . '.role_id !=', 1);
	$CI->db->where("emp_status",1);
	$CI->db->where("emp_is_retired",0);
	$CI->db->where("emp_is_parmanent",1);
	$CI->db->where('emp_posting_location', 1);
    $CI->db->from(LEAVE_MOVEMENT);
    $CI->db->join(EMPLOYEES, EMPLOYEES . '.emp_id = ' . LEAVE_MOVEMENT . '.emp_id');
    $CI->db->join(EMPLOYEE_DETAILS, EMPLOYEES . '.emp_id = ' . EMPLOYEE_DETAILS . '.emp_id');

    $CI->db->join(EMPLOYEEE_ROLE, EMPLOYEEE_ROLE . '.role_id = ' . EMPLOYEES . '.designation_id');
    //$CI->db->order_by("role_id", "ASC");
    $CI->db->order_by("role_leave_level", "ASC");
    $CI->db->order_by("emp_full_name", "ASC");
    $CI->db->group_by(EMPLOYEES.".emp_id");
    $query = $CI->db->get();
  // echo $CI->db->last_query();
    return $rows = $query->result();
}

function get_leave_balance($emp_id, $leave_type) {
    $ci = & get_instance();
    $ci->db->select($leave_type . '_leave');
    $result = $ci->db->get_where(EMPLOYEE_LEAVE, array('emp_id' => $emp_id));
    $rows = $result->row_array();
    $ci->db->last_query();
    return $rows[$leave_type . '_leave'];
}

function setForwordMessage($status_id, $type = null) {
    $CI = & get_instance();
    if ($status_id == 1) {
        if($type == 'ihpl'){
             return "<label class='label label label-success'>अवलोकनार्थ</label>";
        }else{
         return "<label class='label label label-success '>" . $CI->lang->line('leave_session') . "</label>";
        }       
    }
    if ($status_id == 2) {
        return "<label class='label label-danger'>" . $CI->lang->line('leave_may_not_session') . "</label>";
    }
    if ($status_id == 3) {
        return "<label class='label label-info'>" . $CI->lang->line('leave_cancel_status') . "</label>";
    }
}

function setRecomendMessage($status_id, $type = null) {
    $CI = & get_instance();
    if ($status_id == 1) {
        if($type == 'ihpl'){
            return "<label class='label label label-success'>अवलोकनार्थ</label>";
        } else {
            return "<label class='label label label-success'>" . $CI->lang->line('recomend_action_label') . "</label>";
        }

    }
    if ($status_id == 2) {
        return "<label class='label label-danger'>" . $CI->lang->line('recomend_deny_action_label') . "</label>";
    }
    if ($status_id == 3) {
        return "<label class='label label-info'>" . $CI->lang->line('leave_cancel_status') . "</label>";
    }
}

function setApproveMessage($status_id, $type = null) {
    $CI = & get_instance();
    if ($status_id == 1) {
         return "<label class='label label label-success '>" . $CI->lang->line('emp_leave_approve') . "</label>";
    }
    if ($status_id == 2) {
        return "<label class='label label-danger'>" . $CI->lang->line('emp_leave_deny') . "</label>";
    }
    if ($status_id == 3) {
        return "<label class='label label-info'>" . $CI->lang->line('leave_cancel_status') . "</label>";
    }
}

function leaveReason() {
    $CI = & get_instance();
    $leave_reason = array(
        1 => $CI->lang->line('leave_reason_family_reason'),
        2 => $CI->lang->line('leave_reason_own_illness'),
        3 => $CI->lang->line('leave_reason_relative_illness'),
        4 => $CI->lang->line('leave_reason_for_exam'),
        5 => $CI->lang->line('leave_reason_work_in_relation'),
        6 => $CI->lang->line('leave_reason_religious_tour'),
        7 => $CI->lang->line('leave_reason_religious_work'),
        8 => $CI->lang->line('leave_reason_tourism'),
		10 => $CI->lang->line('leeave_reason_death_some_one'),
        9 => $CI->lang->line('leave_reason_other'),
    );
    return $leave_reason;
}

function leave_level_name($isHindi = false, $id = '') {
    $level_en = array(
        1 => 'Outdoor',
        2 => 'Section',
        3 => 'Officers',
        4 => 'Other',
    );
    $level_hi = array(
        1 => 'Outdoor',
        2 => 'Section',
        3 => 'Officers',
        4 => 'Other',
    );
    if ($isHindi) {
        if ($id != '') {
            if (array_key_exists($id, $level_hi)) {
                $return = $level_hi[$id];
            }
        } else {
            $return = $level_hi;
        }
    } else {
        if ($id != '') {
            if (array_key_exists($id, $level_en)) {
                $return = $level_en[$id];
            }
        } else {
            $return = $level_en;
        }
    }

    return $return;
}

function leave_status($isHindi = false, $id = '') {
    $status_en = array(
        1 => 'Initial',
        2 => 'Forwarder',
        3 => 'Recommender',
        4 => 'Approver',
        5 => 'Self cancel',
        6 => 'Forwarder cancel',
        7 => 'Recommender cancel',
        8 => 'Approver cancel',
        9 => 'Approved',
        10 => 'Deny',
        11 => 'Return',
    );
    $status_hi = array(
        1 => 'आवेदन दर्ज किया ',
        2 => 'अग्रेषित अधिकारी के पास',
        3 => 'अनुशंषित अधिकारी के पास',
        4 => 'अनुमोदित अधिकारी के पास',
        5 => 'स्वयं द्वारा रद्द',
        6 => 'अग्रेषित अधिकारी द्वारा रद्द',
        7 => 'अनुशंषित अधिकारी द्वारा रद्द',
        8 => 'अनुमोदित अधिकारी द्वारा रद्द',
        9 => 'स्विकृत',
        10 => 'अस्विकृत',
        11 => 'पृच्छा',
    );
    if ($isHindi) {
        if ($id != '') {
            if (array_key_exists($id, $status_hi)) {
                $return = $status_hi[$id];
            }
        } else {
            $return = $status_hi;
        }
    } else {
        if ($id != '') {
            if (array_key_exists($id, $status_en)) {
                $return = $status_en[$id];
            }
        } else {
            $return = $status_en;
        }
    }
    return $return;
}

function set_leave_log($movment_id, $emp_id, $remark, $movement_tip = null){
	$data = array(
		'leave_movement_id' => $movment_id != '' ? $movment_id : 0,
		'leave_update_emp_id' => $emp_id,
		'leave_remark' => $remark,
		'leave_movement_tip' => $movement_tip,
		'leave_ip_address' => gethostbyname(gethostbyaddr($_SERVER['REMOTE_ADDR'])),
        'leave_browser_id' => $_SERVER['HTTP_USER_AGENT'],
	);
	insertData($data, LEAVE_REMARK);
}

function get_leave_log($where){
	$ci = & get_instance();
    $ci->db->select('*');
	$ci->db->where($where);
	$ci->db->from(LEAVE_REMARK);
    $result = $ci->db->get();
    $rows = $result->result();
    $ci->db->last_query();
	return $rows;
}

function get_log($id){
	$ci = & get_instance();
    $ci->db->select('*');
	$ci->db->where('leave_movement_id', $id);
	$ci->db->from('ft_leave_log');
    $query = $ci->db->get();
	$rows = $query->result();
	//echo $ci->db->last_query();
	if($query->num_rows() > 0){
		return $rows;
	} else{		
		return false;
	}
   
}

//for ebable order gernertation button
function enable_order_gen($emp_id){
	if(in_array($emp_id, array(46,136,166))){
		return true;
	} else{
		return false;
	}
}

function last_order_number(){
	$CI = & get_instance();
    $CI->db->select_max('leave_order_number');
	$CI->db->where('YEAR(emp_leave_approvel_date)',date('Y'));
    $query = $CI->db->get(LEAVE_MOVEMENT, 1);
    $result = $query->row_array();
    $CI->db->last_query();
    return $result['leave_order_number'];
}

 function check_leave($date, $emp_id){
    $CI = & get_instance();
	$date = get_date_formate($date,'Y-m-d');
    $CI->db->select('emp_leave_date,emp_leave_end_date,emp_leave_type');	
	$CI->db->from(LEAVE_MOVEMENT);
	$CI->db->where('emp_id',$emp_id);
	$CI->db->where("'$date' BETWEEN  emp_leave_date AND emp_leave_end_date",null, FALSE);	
	$CI->db->where('emp_leave_forword_type !=', 3);
    $CI->db->where('emp_leave_approval_type !=', 3);
    $CI->db->where('emp_leave_sub_type is null', null, false);
    $CI->db->order_by('emp_leave_create_date','DESC');
    $query = $CI->db->get(); 
    $result = $query->row_array();
    //echo $CI->db->last_query();
	if ($query->num_rows() > 0) {
		return leaveType($result['emp_leave_type']);
	} else {		
		return false;
	}
	

} 
	function calculate_hrs($out, $in){
		$timestamp1 = strtotime($in);
		$timestamp2 = strtotime($out);
		$seconds = $timestamp2 - $timestamp1;
		$minutes = ($seconds / 60) % 60;
		$hours = floor($seconds / (60 * 60));
	    $hour = "<b>".$hours. "</b> hr(s) and <b>".$minutes.'</b> min(s)';
		return $hour;
	}

    function get_bio_report($date, $type) {
        $CI = & get_instance();
        $CI->load->model('unis_bio_report/unis_bio_report_model','bio_report');
        $bio_data = $CI->bio_report->get_report_date($date,$type);
        //pr( $bio_data);
        return $bio_data;
    }

    function show_date_hq($datetime){  
        if(!empty($datetime)){
            $get_time = get_date_formate($datetime,'hi');
            if($get_time != '1200'){
                return get_date_formate($datetime,'d.m.Y h:i A');
            } else{
                return get_date_formate($datetime,'d.m.Y');
            }
        }
        
    }

    function get_under_recommender_employees_list($id = ''){
        $CI = & get_instance();
        $tbl_leave_level = EMPLOYEE_LEAVE_LEVEL_MASTER;
        $tbl_emp =  EMPLOYEES;
        $tbl_emp_role =  EMPLOYEEE_ROLE;
        $CI->db->select($tbl_emp.'.emp_id as under_emp');
        if($id == ''){
            $emp_id = $CI->session->userdata('emp_id');
        }else{
            $emp_id = $id;
        }
        $CI->db->from($tbl_emp);
        $CI->db->join($tbl_leave_level, $tbl_leave_level. '.emp_id = ' . $tbl_emp. '.emp_id');
		$CI->db->join($tbl_emp_role, $tbl_emp_role . '.role_id = ' . $tbl_emp . '.designation_id');
        $CI->db->where('recommender_id', $emp_id);
        $CI->db->where("recommender_id != forwarder_id", null, false);       
		$CI->db->order_by("role_leave_level", "ASC");
        $CI->db->order_by('emp_full_name', 'ASC');
        $query = $CI->db->get();
        //echo $CI->db->last_query(); exit; 
        if ($query->num_rows() > 0) {
            return $query->result();
        } else {
            return false;
        }
    } 