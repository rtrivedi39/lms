<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Approve_deny_so extends MX_Controller {

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
        $data['title'] = $this->lang->line('action_taken_forwadred_list');
        $data['title_tab'] = $this->lang->line('action_taken_forwadred_list');
        if ($this->input->get('type')) {
            $type = $this->input->get('type');
            $data['forworded_lists'] = $this->leave_model->get_forworded_lists($type);
        } else {
			$data['forworded_lists'] = $this->leave_model->get_forworded_lists();
		}
        $data['module_name'] = "leave";
        $data['view_file'] = "leave/approve_deny_list_so";
        $this->template->index($data);
    }

    public function cancel($leave_id = '') {
        $leave = $this->leave_model->getLeave($leave_id);        
        $data = array(
            'emp_leave_approval_emp_id' => $this->session->userdata('emp_id'),
            'emp_leave_approval_type' => '3',
            'emp_leave_forword_type' => '3',
            'emp_leave_approvel_date' => date('Y-m-d h:i:s'),
            'leave_status' =>  6,
        );

        $response = $this->leave_model->updateLeave($leave_id, $data);
        if ($response) {
			$leave_remark = getemployeeName($this->session->userdata('emp_id'))." के द्वारा अवकाश निरस्त किया गया|";
			set_leave_log($leave_id,$this->session->userdata('emp_id'), $leave_remark);
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
            redirect('leave/approve_deny_so');
        }
    }

    public function show_404() {
        $this->load->view('404');
    }

}
