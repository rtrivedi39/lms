<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class leave extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('template');
        $this->load->language('leave', 'hindi');
        $this->load->language('leave_approve', 'hindi');        
        $this->load->model("leave_model");	
        $this->load->helper('leave_helper');
        authorize();
    }
	
	//check user logged in or not 
    public function is_logged_in() {
        if ($this->session->userdata('is_logged_in') === false) {
            redirect("home");
        }
    }

	// show all leaves 
	public function index() {
        no_cache();
        $data = array();
		if($this->input->get('year') != ''){
			$year = $this->input->get('year');
		} else {
			$year = date('Y');
		}
        $data['title'] = $this->lang->line('view_leave');
        $data['page_title'] = $this->lang->line('view_leave');
        $data['leaves'] = $this->leave_model->getLeaves();
        $data['leaves_pending'] = $this->leave_model->get_leaves('pending');
        $data['leaves_return'] = $this->leave_model->get_leaves('return');
        $data['leaves_approve_deny_cancel'] = $this->leave_model->get_leaves('leaves_approve_deny_cancel','','',$year );
        //$data['leaves_all'] = $this->leave_model->get_leaves();
        $data['module_name'] = "leave";
        $data['view_file'] = "leave/index";
        $this->template->index($data);
    }

	// add leave of other employee
    public function add_leave($id = null) {

        $data['title'] = $this->lang->line('apply_leave_title');
        $data['page_title'] = $this->lang->line('page_title');
        $data['leaves'] = $this->leave_model->getLeaves();
        if (!empty($id)) {
            $data['user_det'] = $this->leave_model->getSingleEmployee($id);
        }

        $data['module_name'] = "leave";
        $data['view_file'] = "leave/leave_form";
        $this->template->index($data);
    }

	// department chechk
    function check_other_department($dept_id, $dept_name) {
        if ($dept_id == 'other') {
            $this->form_validation->set_message('check_other_department', $this->lang->line('file_other_dept_error'));
            return false;
        } else {
            return true;
        }
    }

   // add new leave which are logged in 
    public function addleave($id = '') {
        $error = $file_name  = $file_type = '';
		
		$path = './uploads/medical_files/';
		// Count # of uploaded files in array
		$upload_data = count(array_filter($_FILES['medical_file']['name']));
		// leave type medical or type mg send certificate error
        
		
	/*	if( $this->input->post('leave_type') == 'hpl' && $this->input->post('head_quoter_type') == 'MG' ){
            $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $error['error'] . '</div>');
            redirect($_SERVER['HTTP_REFERER']);
			//redirect("leave/add_leave/");
        } */ //commented by RP date : 2-11-2016
		
		if($this->session->userdata('emp_id') != 39){ // this is only for previous year leave deduction
			$prevoi_year = date('Y') - 1 ;
		$apply_year = date('Y',strtotime($this->input->post('start_date')));
		if( $apply_year == $prevoi_year && ( $this->input->post('leave_type') == 'cl' || $this->input->post('leave_type') == 'ol')) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>आप वर्ष '. $prevoi_year .'  में इस  अवकाश का आवेदन नहीं  कर सकते|</div>');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}

		
		$emp_id_exits = $this->input->post('emp_id') != '' ? $this->input->post('emp_id') : $this->session->userdata('emp_id');
		
		if(date('m',strtotime($this->input->post('start_date'))) == '12'  && $this->input->post('leave_type') == 'cl'){
            if($this->input->post('days') > 2){
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>आप इस माह में दो से अधिक आकस्मिक अवकाश आवेदन नहीं कर सकते|</div>');
				redirect($_SERVER['HTTP_REFERER']);
			}
			$applied_cl = $this->leave_model->december_month_cl($emp_id_exits, date('Y',strtotime($this->input->post('start_date'))));
			$total_cls = $applied_cl + $this->input->post('days');
			if($total_cls > 2 ){
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>आप इस माह में दो से अधिक आकस्मिक अवकाश आवेदन नहीं कर सकते|</div>');
				redirect($_SERVER['HTTP_REFERER']);
			}
			//redirect("leave/add_leave/");
        }         
       // if other emp id set get user details   
        if (!empty($id)) {
            $data['user_det'] = $this->leave_model->getSingleEmployee($id);
        }
        $data['title'] = $this->lang->line('apply_leave');
        $data['page_title'] = $this->lang->line('page_title');
        $data['leave_type'] = $this->input->post('leave_type');
        $this->form_validation->set_rules('days', $this->lang->line('required'), 'required');
       // $this->form_validation->set_rules('onleave_work_allot', $this->lang->line('required'), 'required');
        // if leave type hq dates validaion 
		if(!empty($this->input->post('leave_type')) && ($this->input->post('leave_type')!='hq')){
            $this->form_validation->set_rules('start_date', $this->lang->line('required'), 'required');
            $this->form_validation->set_rules('end_date', $this->lang->line('required'), 'required');
	    }
		 // if leave type hq fileds validaion 
        if (!empty($this->input->post('leave_type')) && ($this->input->post('leave_type') == 'el') && empty($this->input->post('leave_sub_type'))) {
            $this->form_validation->set_rules('pay_grade_pay', $this->lang->line('required'), 'required');
            $this->form_validation->set_rules('emp_houserent', $this->lang->line('required'), 'required');
        }
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

	   if(empty($this->input->post('leave_sub_type'))){	
	   		if($this->input->post('leave_type') == 'cl' || $this->input->post('leave_type') == 'ol'){
	   			if($this->is_onlevave_holidays($this->input->post('start_date'), $this->input->post('leave_type'))){
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('leave_not_appliedon_holidays') . '</div>');
					redirect($_SERVER['HTTP_REFERER']);
				   //redirect("leave/add_leave/" . $this->input->post('emp_id'));
				}
	   		}
			// used for check leave el and hpl and after holiday el apply
			$intrval_leaves = $this->leave_model->is_leave_exits_before_holiday($emp_id_exits ,$this->input->post('start_date'), true);
			if($intrval_leaves == true && ($this->input->post('leave_type') == 'el' || $this->input->post('leave_type') == 'hpl')){
				//check holidays on applied date
				if($this->is_onlevave_holidays($this->input->post('start_date'), $this->input->post('leave_type'))){
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('leave_not_appliedon_holidays') . '</div>');
					redirect($_SERVER['HTTP_REFERER']);
				   //redirect("leave/add_leave/" . $this->input->post('emp_id'));
				}
			}
        
			
			// rules for el and hpl type
			if($this->input->post('leave_type') == 'el' || $this->input->post('leave_type') == 'hpl'){
				// check leave type exists or not
				if( $this->leave_model->is_leave_exits($emp_id_exits ,$this->input->post('start_date'),$this->input->post('end_date'),$this->input->post('leave_type'), true )){
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('leave_notification_message_error') . '</div>');
					redirect($_SERVER['HTTP_REFERER']);
					//redirect("leave/add_leave/" . $this->input->post('emp_id'));
				}
				// check leave after date  (Can't apply el-hpl continues to cl-ol)
				if( $this->leave_model->check_leave_date_after($emp_id_exits ,$this->input->post('start_date') )){
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('leave_notification_next_prev_message_error') . '</div>');
					redirect($_SERVER['HTTP_REFERER']);
					//redirect("leave/add_leave/" . $this->input->post('emp_id'));
				} 
				// check leave after date  (Can't apply el-hpl continues to cl-ol)
				if( $this->leave_model->check_leave_date_before($emp_id_exits ,$this->input->post('end_date') )){
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>आप आकस्मिक या ऐच्छिक के पहले इस अवकाश का आवेदन नहीं कर सकते|</div>');
					redirect($_SERVER['HTTP_REFERER']);
					//redirect("leave/add_leave/" . $this->input->post('emp_id'));
				} 
				//check leave exists before holiday 
				if( $this->leave_model->is_leave_exits_before_holiday($emp_id_exits ,$this->input->post('start_date'))){
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('leave_notification_next_prev_message_error') . '</div>');
					redirect($_SERVER['HTTP_REFERER']);
					//redirect("leave/add_leave/" . $this->input->post('emp_id'));
				}
				if($intrval_leaves){
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>अवकाश के पहले आवेदन किया गया था अतः अवकाश के बाद पुनः आवेदन अवकाश दिनों को  करना जरुरी है|</div>');
					redirect($_SERVER['HTTP_REFERER']);
					//redirect("leave/add_leave/" . $this->input->post('emp_id'));
				}
			// rules for cl and ol leaves
			} else if($this->input->post('leave_type') == 'cl' || $this->input->post('leave_type') == 'ol'){
				// check leave type exists or not
				if( $this->leave_model->is_leave_exits($emp_id_exits ,$this->input->post('start_date'), $this->input->post('end_date'), $this->input->post('leave_type') )){
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('leave_notification_message_error') . '</div>');
					redirect($_SERVER['HTTP_REFERER']);
					//redirect("leave/add_leave/" . $this->input->post('emp_id'));
				}
				// check leave after date  (Can't apply cl-ol continues to el-hpl)
				if( $this->leave_model->check_leave_date_after($emp_id_exits ,$this->input->post('start_date'), true )){
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('leave_notification_next_prev_message_error_ol_cl') . '</div>');
					redirect($_SERVER['HTTP_REFERER']);
					//redirect("leave/add_leave/" . $this->input->post('emp_id'));
				} 
				// check leave after date  (Can't apply cl-ol continues to el-hpl)
				if( $this->leave_model->check_leave_date_before($emp_id_exits ,$this->input->post('end_date'), true )){
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>आप अर्जित या मेडिकल के पहले इस अवकाश का आवेदन नहीं कर सकते|</div>');
					redirect($_SERVER['HTTP_REFERER']);
					//redirect("leave/add_leave/" . $this->input->post('emp_id'));
				} 
				//check leave exists before holiday 
				if( $this->leave_model->is_leave_exits_before_holiday($emp_id_exits ,$this->input->post('start_date'),true )){
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('leave_notification_next_prev_message_error_ol_cl') . '</div>');
					redirect($_SERVER['HTTP_REFERER']);
					//redirect("leave/add_leave/" . $this->input->post('emp_id'));
				}
			// rules for ot and hq leaves  
			} else if($this->input->post('leave_type') == 'ot' || $this->input->post('leave_type') == 'hq'){
				//check leave exists on date
				 if( $this->leave_model->is_leave_exits($emp_id_exits ,$this->input->post('start_date'),$this->input->post('end_date'),$this->input->post('leave_type'), true )){
					$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('leave_notification_message_error') . '</div>');
					redirect($_SERVER['HTTP_REFERER']);
					//redirect("leave/add_leave/" . $this->input->post('emp_id'));
				}
			}
		}

		if(!empty($this->input->post('leave_sub_type')) && $this->input->post('leave_sub_type') == 'ld'){
			$apply_month = date('m',strtotime($this->input->post('start_date')));
			$apply_year = date('Y',strtotime($this->input->post('start_date')));
			$crnt_month = date('m') ;
			$crnt_year = date('Y') ;


			if( $this->leave_model->leave_deduction_exists($emp_id_exits, $apply_month , $apply_year )){
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>आप इस माह में इस कर्मचारी का अवकाश कटोत्रा कर चुके है|</div>');
				redirect($_SERVER['HTTP_REFERER']);
			}

			$leave_rem = $this->leave_model->get_remaining_leaves($emp_id_exits,$this->input->post('leave_type'),'GG');
			if ($leave_rem < $this->input->post('days')) {
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('leave_balance_low_message') . '</div>');
				redirect($_SERVER['HTTP_REFERER']);
			}

			if($apply_year > $crnt_year){
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>आप इस वर्ष का अवकाश कटोत्रा नहीं कर सकते|</div>');
				redirect($_SERVER['HTTP_REFERER']);
			}

			if($apply_month >= $crnt_month){
				$this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>आप इस माह का अवकाश कटोत्रा नहीं कर सकते|</div>');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}


        if ($this->form_validation->run($this) == TRUE) {
			$whos_emp = !empty($this->input->post('emp_id')) ? $this->input->post('emp_id') : $this->session->userdata('emp_id');
            $_leave_type = $this->input->post('leave_type') == 'sl' ? $this->input->post('leave_type_sl') : $this->input->post('leave_type') ; 
            // if 'hq','ihpl','sl','jr','lwp' set other_leave column for leave deduction
			$leave_type = in_array($_leave_type, array('hq','ihpl','sl','jr','lwp')) ? 'other' : $_leave_type ; 
			// $leave_type = $this->input->post('leave_type');
            $column_name = $leave_type . '_leave';
			// if other employee leave apply
			
			// headquetertype and time
			$hd_start_date = get_date_formate($this->input->post('hd_start_date'),'Y-m-d');
			$hd_start_date_hour = $this->input->post('hd_start_date_pali') == 'PM' ? $this->input->post('hd_start_date_hour') + 12 : $this->input->post('hd_start_date_hour');
			$hd_start_date_minitues = $this->input->post('hd_start_date_minitues');
			$hd_start_date_hour  = $hd_start_date_hour == 24 ? 00 : $hd_start_date_hour ;
			$final_hd_start_date = $hd_start_date.' '.$hd_start_date_hour.':'.$hd_start_date_minitues.':00 ';
			
			$hd_end_date = get_date_formate($this->input->post('hd_end_date'),'Y-m-d');
			$hd_end_date_hour = $this->input->post('hd_end_date_pali') == 'PM' ? $this->input->post('hd_end_date_hour') + 12 : $this->input->post('hd_end_date_hour');
			$hd_end_date_minitues = $this->input->post('hd_end_date_minitues');
			$hd_end_date_hour  = $hd_end_date_hour == 24 ? 00 : $hd_end_date_hour ;
			$final_hd_end_date = $hd_end_date.' '.$hd_end_date_hour.':'.$hd_end_date_minitues.':00 ';
			
            if (!empty($this->input->post('emp_id'))) {				
				// get remaning leave which are applied and approve or not approve both
                $leave_rem = $this->leave_model->get_remaining_leaves($this->input->post('emp_id'),$this->input->post('leave_type'),$this->input->post('head_quoter_type'));
                // if remaining leave less than leaves set message
				if ($leave_rem < $this->input->post('days')) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('leave_balance_low_message') . '</div>');
					redirect($_SERVER['HTTP_REFERER']);
				    //redirect("leave/add_leave/" . $this->input->post('emp_id'));
                } else {
                    $data_date = array();
					if($this->input->post('leave_type') == 'cl' || $this->input->post('leave_type') == 'ol' || $this->input->post('leave_type') == 'el' || $this->input->post('leave_type') == 'hpl'){
						$leave_remaining = get_leave_balance($whos_emp, $this->input->post('leave_type'));
					} else {
						$leave_remaining = 0;
					}
                    $data_all = array(
                        'emp_id' => !empty($this->input->post('emp_id')) ? $this->input->post('emp_id') : $this->session->userdata('emp_id'),
                        'emp_leave_type' => $_leave_type,
                        'emp_leave_no_of_days' => $this->input->post('days'),
                        'emp_leave_date' => date('Y-m-d', strtotime($this->input->post('start_date'))),
                        'emp_leave_end_date' => date('Y-m-d', strtotime($this->input->post('end_date'))),
                        'emp_leave_is_HQ' => $this->input->post('headquoter'),
                        'emp_leave_half_type' => $this->input->post('half_type') != '' ?$this->input->post('half_type') : null,
                        'emp_leave_address' => $this->input->post('address') != '' ? $this->input->post('address') : null, 
                        'on_behalf_leave' => $this->input->post('on_behalf_id'),
                        'leave_apply' => $this->input->post('leave_way') != '' ?  $this->input->post('leave_way') : null,
                        'leave_message' => !empty($this->input->post('hq_time')) ? $this->input->post('hq_time') : $this->input->post('leave_message'),
                        'type_of_headquoter' => !empty($this->input->post('head_quoter_type')) ? $this->input->post('head_quoter_type') : '',
                        'medical_files' => $upload_data ,
                        'emp_leave_HQ_start_date' => $this->input->post('headquoter') == 1 ? $final_hd_start_date : null,
                        'emp_leave_HQ_end_date' => $this->input->post('headquoter') == 1 ? $final_hd_end_date : null,
                        'sickness_date' => !empty($this->input->post('sickness_date')) ? date('Y-m-d', strtotime($this->input->post('sickness_date'))) : null,
						'leave_remaining' => $leave_remaining,
						'emp_leave_sub_type' => $this->input->post('leave_sub_type') != null ? $this->input->post('leave_sub_type') : null,
                    );
                   
					//if employee role upper offer SO or SO direct forwoard
                    if(get_emplyee_role_id($this->session->userdata('emp_id')) <= 15){
                       $data_date = array(
                            'emp_leave_forword_emp_id' => $this->session->userdata('emp_id'),
                            'emp_leave_forword_type' => '1',
                            'emp_leave_forword_date' => date('Y-m-d'),
                            'leave_status' =>  4,
                        );
                    } 
                    
                    $data = array_merge($data_date, $data_all);

                    if (!empty($_FILES['medical_file'])) {
                        $filename = $_FILES['medical_file']['name'];
                        $path = './uploads/medical_files/';
                        uploadalltypeFile($filename, $path);
                    }

                    if ($this->input->post('leave_reason_ddl') != $this->lang->line('leave_reason_other')) {
                        $msg_ld = '';
						
						$data['emp_leave_reason'] = $this->input->post('leave_reason_ddl').''.$msg_ld;
                    } else {
                        $data['emp_leave_reason'] = $this->input->post('reason');
                    }
                }
			
			// if own leave apply
            } else {				
               $_leave_type = $this->input->post('leave_type') == 'sl' ? $this->input->post('leave_type_sl') : $this->input->post('leave_type') ; 
               $leave_type = in_array($_leave_type, array('hq','ihpl','sl','jr','lwp')) ? 'other' : $_leave_type ;
               //$leave_type = $this->input->post('leave_type');
                $leave_rem = $this->leave_model->get_remaining_leaves('',$this->input->post('leave_type'),$this->input->post('head_quoter_type'));
				$leave_details = $leave_type . '_leave';
                if ($leave_rem < $this->input->post('days')) {
                    $this->session->set_flashdata('message', '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('leave_balance_low_message') . '</div>');
                    redirect('leave/addleave');
                } else {
                    $data_date = array();
					if($this->input->post('leave_type') == 'cl' || $this->input->post('leave_type') == 'ol' || $this->input->post('leave_type') == 'el' || $this->input->post('leave_type') == 'hpl'){
						$leave_remaining = get_leave_balance($whos_emp, $this->input->post('leave_type'));
					} else {
						$leave_remaining = 0;
					}
                    $data_all = array(
                        'emp_id' => !empty($this->input->post('emp_id')) ? $this->input->post('emp_id') : $this->session->userdata('emp_id'),
                        'emp_leave_type' => $_leave_type,
                        'emp_leave_no_of_days' => $this->input->post('days'),
                        'emp_leave_is_HQ' => $this->input->post('headquoter'),
                        'emp_leave_half_type' => $this->input->post('half_type') != '' ?$this->input->post('half_type') : null,
                        'emp_leave_address' => $this->input->post('address') != '' ? $this->input->post('address') : null,
                        'leave_apply' => $this->input->post('leave_way') != '' ? $this->input->post('leave_way') : null,
                        'leave_message' => !empty($this->input->post('hq_time')) ? $this->input->post('hq_time') : $this->input->post('leave_message'),
                        'on_behalf_leave' => $this->input->post('on_behalf_id'),
                        'medical_files' => $upload_data ,
                        'emp_leave_HQ_start_date' => $this->input->post('headquoter') == 1 ? $final_hd_start_date : null,
                        'emp_leave_HQ_end_date' => $this->input->post('headquoter') == 1 ? $final_hd_end_date : null,
                        'sickness_date' => !empty($this->input->post('sickness_date')) ? 
                            date('Y-m-d', strtotime($this->input->post('sickness_date'))) :
                           // $this->input->post('leave_type') == 'hpl' ? 
                           // date('Y-m-d', strtotime($this->input->post('start_date'))) :
                             null ,
                        'leave_status' =>  2,
						'leave_remaining' => $leave_remaining,
						'emp_leave_sub_type' => $this->input->post('leave_sub_type') != null ? $this->input->post('leave_sub_type') : null,
                    );
                    
                    if($this->input->post('leave_type') == 'hq'){
                       $data_date = array(
                            'emp_leave_date' => date('Y-m-d', strtotime($this->input->post('hd_start_date'))),
                            'emp_leave_end_date' => date('Y-m-d', strtotime($this->input->post('hd_end_date'))),
                        );
                    } else {
                        $data_date = array(
                            'emp_leave_date' => date('Y-m-d', strtotime($this->input->post('start_date'))),
                            'emp_leave_end_date' => date('Y-m-d', strtotime($this->input->post('end_date'))),
                        );
                    }

                    $data = array_merge($data_date, $data_all);
                       // pr($data);
                    if ($this->input->post('leave_reason_ddl') != $this->lang->line('leave_reason_other')) {
                        $data['emp_leave_reason'] = $this->input->post('leave_reason_ddl');
                    } else {
                        $data['emp_leave_reason'] = $this->input->post('reason');
                    }
                }
            }
			
			if(!empty($this->input->post('leave_sub_type'))){
				$data['emp_leave_approval_emp_id'] = $this->session->userdata('emp_id');
				$data['emp_leave_approval_type'] = '1';
				$data['emp_leave_approvel_date'] = date('Y-m-d');
				$data['leave_status'] =  9;
			}
			// pr( $data );
            $response = $this->leave_model->insert_leave($data);
			 
			if(!empty($this->input->post('leave_sub_type'))){
				$empdetails = empdetails($emp_id_exits);
				$leave = $this->leave_model->getLeave($response);
				$type = $this->input->post('leave_type');
				$days = $this->input->post('days');
				$headquoter_type = 'GG';
				deductLeave($emp_id_exits, $type, $days, $headquoter_type, $leave);
				$msg = leave_deduction_sms($this->input->post('leave_type'),$this->input->post('days'),$this->input->post('month_leave'));
				if($empdetails[0]['emp_mobile_number'] != '' && $empdetails[0]['emp_mobile_number'] != 0  ){
					send_sms($empdetails[0]['emp_mobile_number'] ,$msg, true); // for normal
					//send_sms('9826672099' ,$msg, true); // for normal
				}
			}
			 
			if (!empty($this->input->post('pay_grade_pay')) && !empty($this->input->post('emp_houserent'))) {
                $upt_data = array(
                    'emp_gradpay' => $this->input->post('pay_grade_pay'),
                    'emp_houserent' => $this->input->post('emp_houserent'),
                );
                $this->leave_model->update_employee($upt_data);
            }
           if ($response) {
				// Loop through each file
				$all_files = array_filter($_FILES['medical_file']['name']);
				$all_files_tmp = array_filter($_FILES['medical_file']['tmp_name']);
				$all_files = array_values($all_files);
				$all_files_tmp = array_values($all_files_tmp);
				for($i = 0;  $i < $upload_data; $i++) {	
				  if (!empty($all_files[$i])){					 
					$tmpFilePath = $all_files_tmp[$i];				
					//Setup our new file path
					$file_name = uniqid().'_'. md5($all_files[$i]).'.pdf';
					$file_type = $this->input->post('medical_file_name');			
					$newFilePath = $path.$file_name;			
					//Upload the file into the temp dir
					if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					   $attachment = array(
						'att_movement_id' => $response,
						'att_name' => $file_name,
						'att_by_emp_id' => $this->session->userdata('emp_id'),
						'att_type' => empty($file_type[$i]) ? 'दस्तावेज' : $file_type[$i],
					 );
					 insertData($attachment,ATTACHMENTS);

					} 
				  }
				}
				
				$leave_prakar = leaveType($this->input->post('leave_type'), true);
				$leave_remark = $this->input->post('days') .' दिन का '.$leave_prakar.' अवकाश का आवेदन किया गया';
				set_leave_log($response ,$this->session->userdata('emp_id'), $leave_remark);
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('success_message') . '</div>');
                if($this->input->post('leave_sub_type') == 'ld'){
					redirect('leave/employee_search');
				}else{
					redirect('leave');
				}
            }
        }
        $data['leaves'] = $this->leave_model->getLeaves();
        $data['module_name'] = "leave";
        $data['view_file'] = "leave/leave_form";      
        $this->template->index($data);
    }

	// check leave on holiday
    function is_onlevave_holidays($date, $leave_type){
		
        if(in_array($leave_type, array('cl','ol','el','hpl'))) {
            $date = date('Y-m-d', strtotime($date));
            return check_holidays($date);
        }
		
    }
	
    
	// cancel applied leave
    function cancel_leave($leave_id) {
        if ($leave_id != '') {
			$leave = $this->leave_model->getLeave($leave_id);
			$emp_id = $leave->emp_id;
            $type = $leave->emp_leave_type;
            $response = $this->leave_model->cancel_leave($leave_id);
            if ($response) {
				$leave_remark = getemployeeName($this->session->userdata('emp_id'),true)." के द्वारा ".getemployeeName($emp_id, true)." का   ".leaveType($type, true)." निरस्त किया गया|";
				// set log of cancel leave
				set_leave_log($leave_id, $this->session->userdata('emp_id'), $leave_remark);
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
            }
        }
		redirect($_SERVER['HTTP_REFERER']);
    }

    // cancel applied leave
    function cancel_with_msg($leave_id) {
    
        if ($leave_id != '') {
			$leave = $this->leave_model->getLeave($leave_id);
			$emp_id = $leave->emp_id;
            $type = $leave->emp_leave_type;
            $empdetails = empdetails($emp_id);
            	//pr($empdetails); 
            $response = $this->leave_model->cancel_leave($leave_id);
            if ($response) {
            	
				$leave_remark = "अवकाश निरस्त किया गया है| कृपया कार्यालय में अनिवार्य रूप से उपस्थित होवें|";
				if($empdetails[0]['emp_mobile_number'] != '' && $empdetails[0]['emp_mobile_number'] != 0  ){
					//send_sms($empdetails[0]['emp_mobile_number'] ,$msg, true); // for unicode
					send_sms($empdetails[0]['emp_mobile_number'] ,$leave_remark,true); // for normal
					//send_sms('9826416953', $leave_remark, true); // for normal
				}
				// set log of cancel leave
				set_leave_log($leave_id, $this->session->userdata('emp_id'), $leave_remark);
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
            }
        }
		redirect($_SERVER['HTTP_REFERER']);
    }

	// print leave according to leave
    function print_leave($id) {
        if ($id != '') {
            $leave_details = $this->leave_model->getLeave($id);
            if (!empty($leave_details)) {
                if ($leave_details->emp_leave_type == 'el') {
                    $file_name = 'el_form';
                } else if ($leave_details->emp_leave_type == 'child') {
                    $file_name = 'cc_form';
                } else {
                    $file_name = 'all_form';
                }
            }
            $data['module_name'] = "leave";
            $data['view_file'] = "leave/print_leave/" . $file_name;
            $data['leave_details'] = $leave_details;
            $data['title'] = $this->lang->line('print');
            $this->template->index($data);
        } else {

            $this->index();
        }
    }
	
	//print el hpl order after approve
    function print_order($id, $saved = false) {
        if ($id != '') {
            $leave_details = $this->leave_model->getLeave($id);
            if (!empty($leave_details)) {
              $file_name = 'order';
            }
            $data['module_name'] = "leave";
            $data['view_file'] = "leave/print_leave/" . $file_name;
            $data['leave_details'] = $leave_details;
			$data['is_saved'] = $saved;
            $data['title'] = $this->lang->line('print');
            $this->template->index($data);
        } else {
            $this->index();
        }
    }
	
	function signature_data() {
       $movement_id = $this->input->post('movement_id');
       $content_final = $this->input->post('content_final');
       $signature_emp_id = $this->input->post('signature_emp_id');
       $is_signature = $this->input->post('is_signature');
	   
	   $data = array(
			'ds_leave_mov_id' => $movement_id,
			'ds_content_final' => $content_final,
			'ds_signature_emp_id' => $signature_emp_id,
			'ds_is_signature' => $is_signature,
	   );
	  
		$response = $this->db->insert('ft_leave_digital_signature', $data);
		if ($response) {
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>आदेश दर्ज किया गया</div>');
				redirect('leave/leave_order/0');
            }
		
    }
    
	// get total no of leaves which are applied or approve  
    public function getEmpRemainLeave($emp_id = '') {
        if (!empty($emp_id)) {
            return $this->leave_model->getTotalLeave($emp_id);
        } else {
            return $this->leave_model->getTotalLeave($this->session->userdata('emp_id'));
        }
    }

	//get total employees which are leavs on today
    function leave_today() {
        $data['module_name'] = "leave";
        $data['view_file'] = "leave/leave_today_list";
        $data['leave_today_list'] = user_leave_today(); //  helper
        $data['title'] = $this->lang->line('leave_on_today');
        $this->template->index($data);
    }

	// get total leaves of perticular employee
    public function getleave($leave_id = '') {
        return $this->leave_model->getLeave($leave_id);
    }

	// modify applied leave  - show all leaves leave id wise
    public function modify_leave($leave_id) {
        $leave_details = $this->getleave($leave_id); //get leaves of emp
        $data['leave_details'] = $leave_details;
        $data['title'] = $this->lang->line('leave_modify_title_menue');
        $data['page_title'] = $this->lang->line('leave_modify_title');
        $data['leaves'] = $this->leave_model->getLeaves();
        if (!empty($leave_details->emp_id)) {
            $data['user_det'] = $this->leave_model->getSingleEmployee($leave_details->emp_id);
        }
        $data['module_name'] = "leave";
        $data['view_file'] = "leave/leave_modify_form";
        $this->template->index($data);
    }

	// modify applied leave
    public function modifyleave() {
        $leave_movement_id = $this->input->post('leave_movement_id');
        $leave_days = $this->input->post('leave_days');
        $leave_data = $this->leave_model->getLeave($leave_movement_id);
        
        $leave_pre_days = $leave_data->emp_leave_no_of_days;
        $leave_type = $leave_data->emp_leave_type;
		$emp_id = $leave_data->emp_id;
		$total_days = $leave_data->emp_leave_no_of_days;
		
        
        $first_date = reset($leave_days);
        $last_date = end($leave_days);
        $days =  count($leave_days);
        $days_diff = $leave_pre_days - $days;
        
        $udata = array(
            'emp_leave_date' => date('Y-m-d', strtotime($first_date)),
            'emp_leave_end_date' => date('Y-m-d', strtotime($last_date)),
            'emp_leave_no_of_days' => $days,
            'emp_leave_deny_reason' => "$days_diff दिन कम किये गए",
        );
        
        deductLeaveAdd($leave_data->emp_id, $leave_type, $days_diff);
        $this->leave_model->updateLeaveMovement($udata, $leave_movement_id);
        
		$leave_remark = getemployeeName($this->session->userdata('emp_id'))." के द्वारा ".getemployeeName($emp_id)."  के  ".leaveType($leave_type, true)." में संशोधन किया गया और $total_days दिन में से $days_diff दिन कम किये गए";
	    set_leave_log($leave_movement_id,$this->session->userdata('emp_id'), $leave_remark);
        $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' .
        $this->lang->line('leave_notification_message') . '</div>');
        redirect($_SERVER['HTTP_REFERER']);
    }

	// on behalf of other emp aply leave
    function onbehalf_applied(){
        $data['module_name'] = "leave";
        $data['view_file'] = "leave/onbehalf_applied_leaves";
        $data['applied_list'] = $this->leave_model->get_applied_lists();
        $data['title'] = $this->lang->line('list_of_applied_leave');
        $this->template->index($data);
    }
	
	//update leave balance of employee - shoe view of leave balance
	function manage_leave($id){
		$data['title'] = $this->lang->line('leave_manage_title');
        $data['title_tab'] = $this->lang->line('leave_manage_title_tab');
        $data['module_name'] = "leave";
        $data['id'] = $id;
        $data['leave_balance'] = get_list(EMPLOYEE_LEAVE, null, array('emp_id' => $id));
        $data['emp_details'] = get_list(EMPLOYEE_DETAILS, null, array('emp_id' => $id));
        $data['view_file'] = "leave/manage_leave_balance";
        $this->template->index($data);
	}
	
	//update leave balance of employee
	function update_leave_balance(){
		$emp_id = $this->input->post('emp_id');
		$this->form_validation->set_rules('cl_leave', $this->lang->line('required'), 'required|max_length[13]');
		$this->form_validation->set_rules('ol_leave', $this->lang->line('required'), 'required|max_length[3]');
		$this->form_validation->set_rules('el_leave', $this->lang->line('required'), 'required');
		$this->form_validation->set_rules('hpl_leave', $this->lang->line('required'), 'required');
		$this->form_validation->set_rules('joining_date', $this->lang->line('required'), 'required');
		$this->form_validation->set_rules('emp_class', $this->lang->line('required'), 'required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
		if ($this->form_validation->run($this) == TRUE) {
			$data = array(
				'cl_leave' => $this->input->post('cl_leave'),
				'ol_leave' => $this->input->post('ol_leave'),
				'el_leave' => $this->input->post('el_leave'),
				'hpl_leave' => $this->input->post('hpl_leave'),
			);
			
			$emp_details = array(
				'emp_class' => $this->input->post('emp_class'),
				'emp_joining_date' => get_date_formate($this->input->post('joining_date'),'Y-m-d'),
			);
			
			$res = updateData(EMPLOYEE_LEAVE, $data, array('emp_id' => $emp_id));
			$res = updateData(EMPLOYEE_DETAILS, $emp_details, array('emp_id' => $emp_id));
			if($res){
				$leave_remark = getemployeeName($this->session->userdata('emp_id'),true)." के द्वारा ".getemployeeName($emp_id, true)."  के अवकाश में संशोधन किया गया |";
				set_leave_log('',$this->session->userdata('emp_id'), $leave_remark);
				$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>अवकाश में संशोधन किया गया</div>');
				redirect($_SERVER['HTTP_REFERER']);
			}
		}
		$this->manage_leave($emp_id);
	}
    
	// get al under employees
	public function under_employees(){
		$data['title'] = $this->lang->line('under_employee_title');
        $data['title_tab'] = $this->lang->line('under_employee_title_tab');
		$data['under_employee_lists'] = $this->leave_model->getUnderEmployeeUser(2);
        $data['module_name'] = "leave";       
        $data['view_file'] = "leave/under_employee_lists";
        $this->template->index($data);
	}
	

	public function leave_log($id){
		$outdata =  get_list(LEAVE_REMARK, 'leave_created_date', array('leave_movement_id' => $id), 'DESC');
		$data['title'] = 'अवकाश';
        $data['title_tab'] = 'अवकाश';
		$data['get_log'] = $outdata;
        $data['module_name'] = "leave";
        $data['view_file'] = "leave/leave_log";
        $this->template->index($data);
	}
	
	public function add_leave_deduction($emp_id){
		$data['title'] = $this->lang->line('leave_deduction');
        $data['title_tab'] = $this->lang->line('leave_deduction');
		$data['leaves_emp'] = $emp_id;
		$data['leave_rem'] = $this->leave_model->get_remaining_leaves($emp_id,'cl','GG');
        $data['module_name'] = "leave";
        $data['view_file'] = "leave/leave_form_deduction";
        $this->template->index($data);
	}

	public function session_per_page_entry(){
		$per_page = $this->input->post('per_page_entry');
        $this->session->set_userdata('per_page_entry',$per_page);
        echo 'success';
        exit;
    }
	
    public function show_404() {
        $this->load->view('404');
    }

}
