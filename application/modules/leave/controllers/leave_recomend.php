<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Leave_recomend extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('template');
        $this->load->language('leave', 'hindi');
        $this->load->language('leave_approve', 'hindi');
        $this->load->model("leave_model");
        $this->load->helper('leave_helper');
    }

    public function is_logged_in() {
        if ($this->session->userdata('is_logged_in') === false) {
            redirect("home");
        }
    }

    public function index() {

        no_cache();
        $data = array();
        $data['title'] = $this->lang->line('leave_emp_recomend_manue');
        $data['title_tab'] = $this->lang->line('title');

        if ($this->input->get('type')) {
            $type = $this->input->get('type');
            $details_leave = $this->leave_model->get_recomender_lists($type);
			$data['details_leave'] = $details_leave['query'];
			$data['details_count'] = $details_leave['counts'];
        } else {
			$details_leave = $this->leave_model->get_recomender_lists();
			$data['details_leave'] = $details_leave['query'];
			$data['details_count'] = $details_leave['counts'];
		}

        $data['module_name'] = "leave";
        $data['view_file'] = "leave/recomend_list";
        $this->template->index($data);
    }

   
    public function recomend($leave_id = '', $isreturn = false) {		
		$leave_id = $this->input->post('leaveID') != '' ? $this->input->post('leaveID') : $leave_id;
		$any_remark = $this->input->post('approve_reson') != '' ? $this->input->post('approve_reson') : '';      
        $leave = $this->leave_model->getLeave($leave_id);   
        $emp_id = $leave->emp_id;
        $type = $leave->emp_leave_type;
        $days = $leave->emp_leave_no_of_days;
        $is_leave_return = $leave->is_leave_return;       

        $data = array(
            'emp_leave_recommend_emp_id' => $this->session->userdata('emp_id'),
            'emp_leave_recommend_type' => '1',
            'emp_leave_recommend_date' => date('Y-m-d H:i:s'),            
            'emp_leave_deny_reason' => $any_remark,
        );
        $response = $this->leave_model->updateLeave($leave_id, $data);
        if ($response) {
            if($is_leave_return == 1){              
                set_leave_log($leave_id,$this->session->userdata('emp_id'), 'पृच्छा', $any_remark);
            }else{
                $remark = empty($any_remark) ? null : ' और रिमार्क '.$any_remark.' जोड़ा गया |';               
                set_leave_log($leave_id, $this->session->userdata('emp_id'),' अवकाश अनुशंषित  किया गया ', $remark);
            }
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
            redirect($_SERVER['HTTP_REFERER']);
            //redirect('leave/leave_forward');
        }
    }
    
    function deny_recomend() {
        $leave_id = $this->input->post('leaveID');
        $any_remark = $this->input->post('deny_reson') != '' ? $this->input->post('deny_reson') : '';
        $data = array(
            'emp_leave_recommend_emp_id' => $this->session->userdata('emp_id'),
            'emp_leave_recommend_type' => '2',
            'emp_leave_recommend_date' => date('Y-m-d H:i:s'),            
            'emp_leave_deny_reason' => $any_remark,
        );

        $response = $this->leave_model->updateLeave($leave_id, $data);
        if ($response) {
            set_leave_log($leave_id,$this->session->userdata('emp_id'),' अवकाश अनुशंषित योग्य नहीं किया गया ',$this->input->post('deny_reson'));
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
            redirect($_SERVER['HTTP_REFERER']);
            //redirect('leave/leave_forward');
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
                    $data = array(
                        'emp_leave_recommend_emp_id' => $this->session->userdata('emp_id'),
                        'emp_leave_recommend_type' => $this->input->post('bultselect'),
                        'emp_leave_recommend_date' => date('Y-m-d H:i:s'),                        
                    );
                    $response = $this->leave_model->updateLeave($leaveid, $data);
                    set_leave_log($leaveid,$this->session->userdata('emp_id'),' अवकाश अनुशंषित  किया गया ');
                }
			} else if($bultselect == 2){
				foreach ($leave_ids as $leaveid) {
                    $data = array(
                        'emp_leave_recommend_emp_id' => $this->session->userdata('emp_id'),
                        'emp_leave_recommend_type' => '2',
                        'emp_leave_recommend_date' => date('Y-m-d H:i:s'),                         
                    );
                    $response = $this->leave_model->updateLeave($leaveid, $data);
                    set_leave_log($leaveid,$this->session->userdata('emp_id'),' अवकाश अनुशंषित योग्य नहीं  किया गया ');
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

    
    

    public function show_404() {
        $this->load->view('404');
    }

}
