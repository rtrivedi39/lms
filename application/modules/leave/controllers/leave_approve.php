<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Leave_approve extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('template');
        $this->load->language('leave', 'hindi');
        $this->load->language('leave_approve', 'hindi');
        $this->load->model("leave_model");
        $this->load->helper('leave_helper');
		$this->load->library('pagination');
    }

    public function is_logged_in() {
        if ($this->session->userdata('is_logged_in') === false) {
            redirect("home");
        }
    }

    public function index($offset = 0){

        no_cache();
        $data = array();
        $data['title'] = $this->lang->line('approve_leave_manue');
        $data['title_tab'] = $this->lang->line('title');
		$config['base_url'] = base_url().'leave/leave_approve/index/';
		$config["per_page"] = PER_PAGE_VALUE;
		$offset = ($this->uri->segment(4) != '' ? $this->uri->segment(4) : 0);
		$config['uri_segment'] = 4;

        if ($this->input->get('type')) {
            $type = $this->input->get('type');
			$total = $this->leave_model->get_allaproval_lists($type,true);
            $details_leave = $this->leave_model->get_allaproval_lists($type,false,null,null,$config["per_page"],$offset);
			$data['details_leave'] = $details_leave['query'];
			$data['details_count'] = $details_leave['counts'];
        } else {
			$total = $this->leave_model->get_allaproval_lists(null,true);
			$details_leave = $this->leave_model->get_allaproval_lists(null,false,null,null,$config["per_page"],$offset);
			$data['details_leave'] = $details_leave['query'];
			$data['details_count'] = $details_leave['counts'];
		}

		$config["total_rows"] = $total;
		$this->pagination->initialize($config);
		$data['pagination'] = $this->pagination->create_links();
		if(!empty($this->pagination->create_links())){
			$data['pagermessage'] = 'Showing <b>'.((($this->pagination->cur_page-1)*$this->pagination->per_page)+1).'</b> to <b>'.($this->pagination->cur_page*$this->pagination->per_page).'</b> of <b>'.$this->pagination->total_rows.'</b>';
		}

		$data['total_counts'] = $total;
        $data['module_name'] = "leave";
        $data['view_file'] = "leave/approve_list";
        $this->template->index($data);
    }

    public function leave_el() {
        no_cache();
        $data = array();
        $data['title'] = $this->lang->line('approve_leave_manue');
        $data['title_tab'] = $this->lang->line('title');
        $data['details_leave'] = $this->leave_model->getAllELLeaves('pending');
        $data['module_name'] = "leave";
        $data['view_file'] = "leave/approve_list_el";
        $this->template->index($data);
    }

    public function approve($leave_id = '', $isreturn = false, $reason = null) {
		$leave_id = $this->input->post('leaveID') != '' ? $this->input->post('leaveID') : $leave_id;
		$approve_reson = $this->input->post('approve_reson') != '' ? $this->input->post('approve_reson') : '';
        $leave = $this->leave_model->getLeave($leave_id);
        $emp_id = $leave->emp_id;
        $type = $leave->emp_leave_type;
        $days = $leave->emp_leave_no_of_days;
        $headquoter_type = $leave->type_of_headquoter;
        $sickness_date = $leave->sickness_date;
        $date = $leave->emp_leave_date;
        if(( $type == 'hpl' || $type == 'el') && $this->leave_model->is_leave_exits_ondate($emp_id, $date)){
            $leave_data =  $this->leave_model->is_leave_exits_ondate($emp_id, $date, true);
            // pr($leave_data);
            $response =  $this->leave_model->update_leave_exists($leave_data);
            if(($date == $sickness_date && $type == 'hpl') || $type == 'el'){
                deductLeave($emp_id, $type, $days, $headquoter_type, $leave);
                $type_name = leaveType($type, true);
                $update_data = array(
                    'emp_leave_deny_reason' => $approve_reson."(यह अवकाश $type_name में परिवर्तन किया गया)",
                );
                $this->leave_model->updateLeave($leave_id, $update_data); 
                $this->update_holidays_leaves($date,$date,$emp_id,$type,$headquoter_type,$leave_id,$leave );
            }else if(($date != $sickness_date && $type == 'hpl')){
                $this->update_holidays_leaves($date,$date,$emp_id,$type,$headquoter_type,$leave_id,$leave );
                $this->calculation_sickness($date,$sickness_date,$emp_id,$type,$headquoter_type,$leave_id,$leave );
                deductLeave($emp_id, $type, $days, $headquoter_type, $leave);
            }
        }else if(($type == 'hpl' || $type == 'el') && !$this->leave_model->is_leave_exits_ondate($emp_id, $date)){
            if(($date == $sickness_date && $type == 'hpl') || $type == 'el'){
                $this->update_holidays_leaves($date,$date,$emp_id,$type,$headquoter_type,$leave_id,$leave );
                deductLeave($emp_id, $type, $days, $headquoter_type, $leave);
            }else if(($date != $sickness_date && $type == 'hpl')){
               $this->update_holidays_leaves($date,$date,$emp_id,$type,$headquoter_type,$leave_id,$leave );
               $this->calculation_sickness($date,$sickness_date,$emp_id,$type,$headquoter_type,$leave_id,$leave );
               deductLeave($emp_id, $type, $days, $headquoter_type, $leave);
            } 
        } else{	
          deductLeave($emp_id, $type, $days, $headquoter_type, $leave);
        } 

		$last_order_number = last_order_number(); // autometicx genrate
        $data = array(
            'emp_leave_approval_emp_id' => $this->session->userdata('emp_id'),
            'emp_leave_approval_type' => '1',
            'emp_leave_approvel_date' => date('Y-m-d h:i:s'),
            'leave_status' =>  9,
			'emp_leave_deny_reason' => $approve_reson,
			'leave_order_number' => $last_order_number + 1,
        );

       $response = $this->leave_model->updateLeave($leave_id, $data);
	   if ($response) {
			$empdetails = empdetails($emp_id);
			//$type = $type == 'ihpl' ? 'leave information' : $type;
			$leave_sub_type = $leave->emp_leave_sub_type;
			if($leave_sub_type == 'ld'){
				$month = ltrim(get_date_formate($leave->emp_leave_date,'m'),0);
				$month_name = months($month,true);
				$msg = leave_deduction_sms($type,$days);
				//$msg = 'कार्यालय में विलम्ब से आने के कारण '.$month_name.' माह में अवकाश कटोत्रा किया गया| विलम्ब रिपोर्ट देखें|';
			} else {
				 $msg = "आपका ".leaveType($type,true)." दि. ". get_date_formate($date,'d/m/y')." से ".get_date_formate($leave->emp_leave_end_date,'d/m/y')." तक स्वीकृत किया गया";
				//$msg = "Your ".strtoupper($type)." from ".get_date_formate($date,'d/m/Y')." to ".get_date_formate($leave->emp_leave_end_date,'d/m/Y').", $days day(s) has been approved.";
			}
			
			//$result = send_sms('9425424554' ,$msg, true);
			if($empdetails[0]['emp_mobile_number'] != '' && $empdetails[0]['emp_mobile_number'] != 0 && $type != 'ihpl' && $type != 'jr' ){
				send_sms($empdetails[0]['emp_mobile_number'] ,$msg, true); // for unicode
				//send_sms($empdetails[0]['emp_mobile_number'] ,$msg); // for normal
			}
			set_leave_log($leave_id,$this->session->userdata('emp_id'),' अवकाश स्वीकृत किया गया', $approve_reson);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
	   }
       if($isreturn){
           return true;
       }else {
		   redirect($_SERVER['HTTP_REFERER']);
           //redirect('leave/leave_approve');
       }
    }
    
    public function update_holidays_leaves($ondate, $sickness_date, $emp_id, $type, $headquoter_type, $leave_id, $leave) {
        $leave_dates_interval = array();
        $last_leave = $this->leave_model->get_last_leave($emp_id, $leave_id);
        if($last_leave !== false) {
            $last_leave_date = $last_leave[0]->last_leave;
            $last_date_after = date('Y-m-d', strtotime($last_leave_date . ' +1 day'));
            $diff = day_difference_dates($last_date_after, $ondate);
            if($diff < 7){
                for ($i = 1; $i <= $diff; $i++) {
                    $date_counter = date('Y-m-d', strtotime($last_leave_date . ' +' . $i . ' day'));
                    $response = check_holidays($date_counter);
                    if ($response == true) {
                        $leave_dates_interval[] = $date_counter;
                    } else{
                        return;
                    }
                }
                //pr($leave_dates_interval);
                if(!empty($leave_dates_interval)) {
                    $count_days = count($leave_dates_interval);
                    deductLeave($emp_id, 'el', $count_days, $headquoter_type, $leave);
                    $el_data = array(
                        'emp_id' => $emp_id,
                        'emp_leave_type' => 'el',
                        'emp_leave_no_of_days' => $count_days,
                        'emp_leave_date' => date('Y-m-d', strtotime($last_leave_date . '+1 Days')),
                        'emp_leave_end_date' => date('Y-m-d', strtotime($sickness_date . '-1 Days')),
                        'emp_leave_is_HQ' => 2,
                        'emp_leave_half_type' => '',
                        'emp_leave_address' => '',
                        'on_behalf_leave' => $emp_id,
                        'leave_apply' => '',
                        'emp_leave_reason' => $leave->emp_leave_reason,
                        'type_of_headquoter' => '',
                        'emp_leave_forword_emp_id' => $this->session->userdata('emp_id'),
                        'emp_leave_forword_type' => '1',
                        'emp_leave_forword_date' => date('Y-m-d'),
                        'emp_leave_approval_emp_id' => $this->session->userdata('emp_id'),
                        'emp_leave_approval_type' => '1',
                        'emp_leave_approvel_date' => date('Y-m-d h:i:s'),
                        'leave_status' => 9,
                        'emp_leave_deny_reason' => 'El deduction for Holidays between Leaves',
                    );
                    
                    $this->leave_model->insert_leave($el_data);
                }
            }
        } else {
            //exit;
        }
    }

    public function calculation_sickness($date,$sickness_date,$emp_id,$type,$headquoter_type,$leave_id,$leave ){
        $diff =  day_difference_dates($date, $sickness_date); 
        $days = $days - $diff;
        deductLeave($emp_id, $type, $days, $headquoter_type, $leave);

        $update_data = array(
            'emp_leave_deny_reason' => 'Deduction from Sickness date',
        );
        $this->leave_model->updateLeave($leave_id, $update_data); 

        deductLeave($emp_id, 'el', $diff, $headquoter_type, $leave);

        $el_data = array(
            'emp_id' => $emp_id,
            'emp_leave_type' => 'el',
            'emp_leave_no_of_days' => $diff,
            'emp_leave_date' => $date,
            'emp_leave_end_date' => date('Y-m-d',strtotime($sickness_date.'-1 Days')),
            'emp_leave_is_HQ' => 2,
            'emp_leave_half_type' => '',
            'emp_leave_address' => '',
            'on_behalf_leave' => $emp_id,
            'leave_apply' => '',
            'emp_leave_reason' => $leave->emp_leave_reason,
            'type_of_headquoter' => '',
            'emp_leave_forword_emp_id' => $this->session->userdata('emp_id'),
            'emp_leave_forword_type' => '1',
            'emp_leave_forword_date' => date('Y-m-d'),
            'emp_leave_approval_emp_id' => $this->session->userdata('emp_id'),
            'emp_leave_approval_type' => '1',
            'emp_leave_approvel_date' => date('Y-m-d h:i:s'),
            'leave_status' =>  9,
            'emp_leave_deny_reason' => 'Converted to EL',

        );
        $this->leave_model->insert_leave($el_data);
    }
    
    function deny($id = null, $redirect = false) {
		$userrole = checkUserrole();
        $leave_id = ($id == null ? $this->input->post('leaveID') : $id) ;
        $deny_reson = ($id == null ? $this->input->post('deny_reson') : ($userrole == 3 ? 'अवलोकित अस्वीकृत' : '')) ;
		$leave = $this->leave_model->getLeave($leave_id);
        $emp_id = $leave->emp_id;
        $data = array(
            'emp_leave_approval_emp_id' => $this->session->userdata('emp_id'),
            'emp_leave_approval_type' => '2',
            'emp_leave_approvel_date' => date('Y-m-d H:i:s'),
            'emp_leave_deny_reason' => $deny_reson,
            'leave_status' =>  10,
        );
	
        $response = $this->leave_model->updateLeave($leave_id, $data);
        if ($response) {
			$empdetails = empdetails($emp_id);
			$days = $leave->emp_leave_no_of_days;
			$leave_sub_type = $leave->emp_leave_sub_type;
			//$msg = "आपका ".leaveType($leave->emp_leave_type,true)." दि. ". get_date_formate($leave->emp_leave_date,'d/m/y')." से ".get_date_formate($leave->emp_leave_end_date,'d/m/y')." तक अस्वीकृत किया गया";
			$msg = "Your ".strtoupper($leave->emp_leave_type)." from ".get_date_formate($leave->emp_leave_date,'d/m/Y')." to ".get_date_formate($leave->emp_leave_end_date,'d/m/Y').", $days day(s) is not sanctioned, please do not proceed. Contact Establishment or check your leave account.";				
		
			//pr($empdetails[0]['emp_mobile_number']);
			//send_sms('9425424554' ,$msg, true); 			
			//send_sms($empdetails[0]['emp_mobile_number'] ,$msg, true);
			send_sms($empdetails[0]['emp_mobile_number'] ,$msg);
			
            set_leave_log($leave_id, $this->session->userdata('emp_id'), 'अवकाश अस्वीकृत किया गया ', $deny_reson);
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
            if($redirect == true){
				 return true;
			}else {
				 redirect($_SERVER['HTTP_REFERER']);
				//redirect('leave/leave_forward');
			}
		}
    }

    public function bulkAction() {
        $leave_ids = $this->input->post('leave_ids');
        $this->form_validation->set_rules('bultselect', 'कृपया चयन करें', 'required');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        if ($this->form_validation->run($this) === TRUE) {
			$bultselect = $this->input->post('bultselect');			
			if($bultselect == 1){
				foreach ($leave_ids as $leaveid) {
					$response = $this->approve($leaveid, true);
				}
			} else if($bultselect == 2){
				foreach ($leave_ids as $leaveid) {
					$response = $this->deny($leaveid, true);
				}
			}
			
            if ($response) {
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
                 redirect($_SERVER['HTTP_REFERER']);
				//redirect('leave/leave_forward');
            }
        } else {
            $this->index();
        }
    }

    public function getEmployeeLeave() {
        $data['title'] = $this->lang->line('view_all_employee');
        $data['title_tab'] = $this->lang->line('view_all_employee');
        $data['details_leave'] = $this->leave_model->getEmployeeLeave();
        $data['module_name'] = "leave";
        $data['view_file'] = "leave/leave_employee";
        $this->template->index($data);
    } 
	
	public function ajax_get_leaves_taken() {  // used in admin/footer.php #348				
		$leave_type = $this->input->post('leave_type') != '' ? $this->input->post('leave_type') : null;	
		$emp_id = $this->input->post('emp_id') != '' ? $this->input->post('emp_id') : '';	
		$year = $this->input->post('year') != '' ? $this->input->post('year') : date('Y-m-d');	
		$leave_id = $this->input->post('leave_id') != '' ? $this->input->post('leave_id') : null;	
		$data =  $this->leave_model->ajax_get_leaves_taken($emp_id, $year, $leave_type, $leave_id);
        echo json_encode($data);
        exit();
    }

	public function get_userdetails() {
		$emp_id = $this->input->post('emp_id');
		$data = get_list(EMPLOYEE_LEAVE ,null, array('emp_id' => $emp_id));
        echo json_encode($data);
        exit();
    }

    public function employeeLeave() {
        $data['title'] = $this->lang->line('leave_employee');
        $data['title_tab'] = $this->lang->line('leave_serach_employee');
        if (isset($_POST['search_type']) && isset($_POST['seach_value'])) {
            $data['userleaves_list'] = $this->leave_model->getUser(
                $this->input->post('search_type'), $this->input->post('seach_value')
            );
        } else {
            $data['under_employees'] = $this->leave_model->get_leave_under_employees();
        }
        $data['module_name'] = "leave";
        $data['view_file'] = "leave/employee_search_leave";
        $this->template->index($data);
    }

    public function show_404() {
        $this->load->view('404');
    }

}
