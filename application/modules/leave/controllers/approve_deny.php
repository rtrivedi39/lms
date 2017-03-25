<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Approve_deny extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('template');
        $this->load->language('leave', 'hindi');
        $this->load->language('leave_approve', 'hindi');
        $this->load->model("leave_model");
        $this->load->helper('leave_helper');
        //isAdminAuthorize();
    }

    public function is_logged_in() {
        if ($this->session->userdata('is_logged_in') === false) {
            redirect("home");
        }
    }

    public function index() {
        no_cache();
        $data = array();
        $data['title'] = $this->lang->line('approve_leave_list_manue');
        $data['title_tab'] = $this->lang->line('title');
        $data['details_leave'] = $this->leave_model->getAllLeavesDetails();
        $data['under_employee'] = $this->leave_model->getUnderEmployee();
        $data['module_name'] = "leave";
        $data['view_file'] = "leave/approve_deny_list";
        $this->template->index($data);
    }

	//cancel aplied leave
    public function cancel($leave_id = '') {
        $leave = $this->leave_model->getLeave($leave_id);
        $emp_id = $leave->emp_id;
        $type = $leave->emp_leave_type;
        $days = $leave->emp_leave_no_of_days;
        $approval_type = $leave->emp_leave_approval_type;
		if($approval_type == '1'){
			deductLeaveAdd($emp_id, $type, $days);
		}
        $data = array(
            'emp_leave_approval_emp_id' => $this->session->userdata('emp_id'),
            'emp_leave_approval_type' => '3',
            'emp_leave_approvel_date' => date('Y-m-d h:i:s'),
            'leave_status' =>  8,
			'on_behalf_leave' =>  $this->session->userdata('emp_id') ,
        );

        $response = $this->leave_model->updateLeave($leave_id, $data);
        if ($response) {
			$emp_t = getemployeeName($this->session->userdata('emp_id'),true);
			$emp_for = getemployeeName($emp_id, true);
			$leave_remark = $emp_t." के द्वारा ".$emp_for." का ".leaveType($type, true)." निरस्त किया गया|";
			// set log of cancel leave
			$mobile = get_est_so_number();
			if($mobile){
				if($leave->emp_leave_sub_type == 'ld'){
					$leave_remark_sms = $emp_t.", प्रशासकीय अधिकारी  के द्वारा ".$emp_for." का ".leaveType('ld', true)." निरस्त किया गया|";
				}else{
					$leave_remark_sms = $emp_t.", प्रशासकीय अधिकारी के द्वारा ".$emp_for." दि ".get_date_formate($leave->emp_leave_date)." से ".get_date_formate($leave->emp_leave_end_date)." तक का ".leaveType($type, true)." निरस्त किया गया|";
				}
				//pr($leave_remark_sms);
				send_sms( $mobile,$leave_remark_sms, true); // for unicode
				//send_sms( $mobile,$leave_remark_sms); // for normal
			}
			set_leave_log($leave_id,$this->session->userdata('emp_id'), $leave_remark);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
	
	//return aplied leave
    public function leave_return() {
		$leave_id = $this->input->post('leaveID');
		$types = $this->input->post('types');
		$returntoemp = empty($this->input->post('returntoemp')) ? null : $this->input->post('returntoemp');
		$return_reason = $this->input->post('return_reason');
        $leave = $this->leave_model->getLeave($leave_id);
        $emp_id = $leave->emp_id;
        $type = $leave->emp_leave_type;
        $days = $leave->emp_leave_no_of_days; 
		$empdetails = empdetails($emp_id);
		
		if($types == 'approve'){
			$typeby = ' अग्रेषित ';
			if($returntoemp == 'forwarder'){
				$data = array(
					'emp_leave_forword_emp_id' => 0,
					'emp_leave_forword_type' => 0,
					'emp_leave_forword_date' => null,
					'emp_leave_approval_emp_id' => 0,
					'emp_leave_approval_type' => 0,
					'emp_leave_approvel_date' => null,
					'leave_status' =>  11,
					'emp_leave_deny_reason' =>  $return_reason,
					'is_leave_return' =>  1,
					'leave_return_to_emp_id' =>  $this->session->userdata('emp_id'),
				);
			}else if($returntoemp == 'applier'){			
				$data = array(
					'emp_leave_forword_type' => 4,
					'emp_leave_forword_date' => date('Y-m-d h:i:s'),
					'emp_leave_approval_emp_id' => 0,
					'emp_leave_approval_type' => 0,
					'emp_leave_approvel_date' => null,
					'leave_status' =>  11,
					'emp_leave_deny_reason' =>  $return_reason,
					'is_leave_return' =>  1,
					'leave_return_to_emp_id' =>  $this->session->userdata('emp_id'),
				);
			}
			
		} else if($types == 'forward'){
			 $typeby = ' आवेदित ';
			 $data = array(
				'emp_leave_forword_emp_id' => $this->session->userdata('emp_id'),
				'emp_leave_forword_type' => 4,
				'emp_leave_forword_date' => date('Y-m-d h:i:s'),
				'leave_status' =>  11,
				'emp_leave_deny_reason' =>  $return_reason,
				'is_leave_return' =>  1,
				'leave_return_to_emp_id' =>  $this->session->userdata('emp_id'),
			);
		}		
       
        $response = $this->leave_model->updateLeave($leave_id, $data);
        if ($response) {
			$msg = "आपके  ".$typeby." ".strtoupper($leave->emp_leave_type)." ".get_date_formate($leave->emp_leave_date,'d.m')." से ".get_date_formate($leave->emp_leave_end_date,'d.m')." तक पर पृच्छा की गयी";				
			send_sms($empdetails[0]['emp_mobile_number'] ,$msg, true);
			$leave_remark = getemployeeName($this->session->userdata('emp_id'),true)." के द्वारा ".getemployeeName($emp_id, true)." के    ".leaveType($type, true)."  पर  पृच्छा की गयी|";
			// set log of cancel leave
			set_leave_log($leave_id,$this->session->userdata('emp_id'), $leave_remark, $return_reason);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }
	
	//return aplied leave
    public function leave_return_answer() {
		$leave_id = $this->input->post('leaveID');
		$types = $this->input->post('types');
		$return_reason = $this->input->post('return_reason');
        $leave = $this->leave_model->getLeave($leave_id);
        $type = $leave->emp_leave_type;
		if($types == 'approve'){
			$data = array(
				'emp_leave_approval_type' => 0,
				'leave_status' =>  4,
				'emp_leave_deny_reason' =>  $return_reason,
			);
		} else if($types == 'forward'){
			 $data = array(
				'emp_leave_forword_type' => 0,
				'leave_status' =>  2,
				'emp_leave_deny_reason' =>  $return_reason,
			);
		}	
		       
        $response = $this->leave_model->updateLeave($leave_id, $data);
		
		if (!empty($_FILES['document']['name'])){
				$path = './uploads/medical_files/';
				$tmpFilePath = $_FILES['document']['tmp_name'];
				//Setup our new file path
				$file_name = uniqid().'_'. md5($_FILES['document']['name']).'.pdf';
				$file_type = $this->input->post('document_name');			
				$newFilePath = $path.$file_name;

				//Upload the file into the temp dir
				if(move_uploaded_file($tmpFilePath, $newFilePath)) {
					 $attachment = array(
						'att_movement_id' => $leave_id,
						'att_name' => $file_name,
						'att_by_emp_id' => $this->session->userdata('emp_id'),
						'att_type' => empty($file_type) ? 'दस्तावेज' : $file_type,
						);
					 insertData($attachment,ATTACHMENTS);
					 $this->leave_model->updateLeave($leave_id, array('medical_files' => 1));
				} else{
					echo 'errror';
				}
		  }
			 
        if ($response) {
			$type = empty($file_type) ? "दस्तावेज" : $file_type;
			$attch = (!empty($_FILES['document']['name'])) ? 'और  <a href="'.base_url().'uploads/medical_files/'.$file_name.'"  class="text-info" target="_blank">'.$type.'</a> जोड़ा गया|' : null;
			$leave_remark = getemployeeName($this->session->userdata('emp_id'),true)." के द्वारा ".leaveType($type, true)." पर पृच्छा का जवाब दिया |";
			// set log of cancel leave
			set_leave_log($leave_id,$this->session->userdata('emp_id'), $leave_remark, $return_reason." ".$attch);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
            redirect($_SERVER['HTTP_REFERER']);
        }
    }

    public function show_404() {
        $this->load->view('404');
    }

}
