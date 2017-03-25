<?php

if (!defined('BASEPATH'))
    exit
            ('No direct script access allowed');

class Leave_forward extends MX_Controller {

    function __construct() {
        parent::__construct(); 
        $this->load->module('template');
        $this->load->language('leave', 'hindi');
        $this->load->language('leave_forward', 'hindi');
        $this->load->model("leave_model");
        $this->load->helper('leave_helper');
		$this->load->library('pagination');
        //isAdminAuthorize();
    }

    public function is_logged_in() {
        if ($this->session->userdata('is_logged_in') === false) {
            redirect("home");
        }
    }

    public function index($offset = 0) {

        no_cache();
        $data = array();
        $data['title'] = $this->lang->line('forward_leave_manue');
        $data['title_tab'] = $this->lang->line('title');
		$config['uri_segment'] = 4;
		$config["per_page"] = PER_PAGE_VALUE;

		if($this->input->get('lvl') == 'all' || $lvl == 'all'){
			$config['page_query_string'] = true;
			$config['base_url'] = base_url().'leave/leave_forward/index/?lvl=all';
			$offset = ($this->input->get('per_page') != '' ? $this->input->get('per_page')  : '');
		}else{
			$config['base_url'] = base_url().'leave/leave_forward/index/';
			$offset = ($this->uri->segment(4) != '' ? $this->uri->segment(4): 0);
		}


        if ($this->input->get('type')) {
            $type = $this->input->get('type');
			$total = $this->leave_model->get_allforword_lists($type,true);
            $details_leave = $this->leave_model->get_allforword_lists($type,false,null,null,null,$config["per_page"],$offset);
			$data['details_leave'] = $details_leave['query'];
			$data['details_count'] = $details_leave['counts'];
        } else{
			$total = $this->leave_model->get_allforword_lists(null,true);
			$details_leave = $this->leave_model->get_allforword_lists(null, false,null,null,null,$config["per_page"],$offset);
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
        $data['view_file'] = "leave/forward_list";
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

	  public function forword_leave($leave_id = '') {
		$leave_id = $this->input->post('leaveID') != '' ? $this->input->post('leaveID') : $leave_id;
		$person_name = $this->input->post('onleave_work_allot') != '' ? $this->input->post('onleave_work_allot') : '';
		$any_remark = $this->input->post('any_remark') != '' ? $this->input->post('any_remark') : '';

        $leave = $this->leave_model->getLeave($leave_id);
        $emp_id = $leave->emp_id;
        $type = $leave->emp_leave_type;
        $days = $leave->emp_leave_no_of_days;
        $is_leave_return = $leave->is_leave_return;
        //deductLeave($emp_id , $type ,$days );

        $data = array(
            'emp_leave_forword_emp_id' => $this->session->userdata('emp_id'),
            'emp_leave_forword_type' => '1',
            'emp_leave_forword_date' => date('Y-m-d H:i:s'),
			'emp_onleave_work_allot' => $person_name,
			'emp_leave_deny_reason' => $any_remark,
        );
        $response = $this->leave_model->updateLeave($leave_id, $data);
        if ($response) {
			if($is_leave_return == 1){				
				set_leave_log($leave_id,$this->session->userdata('emp_id'), 'पृच्छा', $any_remark);
			}else{
				$remark = empty($any_remark) ? null : ' और रिमार्क '.$any_remark.' जोड़ा गया |';
				$teep = $person_name != null ? 'अवकाश काल मे आपका  कार्य '. $person_name. ' के द्वारा किया जायेगा| '.$remark  : null ;
				set_leave_log($leave_id, $this->session->userdata('emp_id'),' अवकाश अग्रेषित  किया गया ', $teep);
			}
			$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
			redirect($_SERVER['HTTP_REFERER']);
            //redirect('leave/leave_forward');
        }
    }

	// not in usede may be
    public function approve($leave_id = null) {
		$leave = $this->leave_model->getLeave($leave_id);
        $emp_id = $leave->emp_id;
        $type = $leave->emp_leave_type;
        $days = $leave->emp_leave_no_of_days;
        deductLeave($emp_id, $type, $days);

        $data = array(
            'emp_leave_approval_emp_id' => $this->session->userdata('emp_id'),
            'emp_leave_approval_type' => '1',
            'emp_leave_approvel_date' => date('Y-m-d h:i:s'),
            'leave_status' =>  4,


        );
		//pr($data);
        $response = $this->leave_model->updateLeave($leave_id, $data);
        if ($response) {
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
			redirect($_SERVER['HTTP_REFERER']);
			//redirect('leave/leave_forward');
        }
    }

	function resend() {

        $leave_id = $this->input->post('leaveID');
		$leave = $this->leave_model->getLeave($leave_id);
        $app_reson = $leave->emp_leave_deny_reason;
        $app_emp = $leave->emp_leave_approval_emp_id;
        $app_date = $leave->emp_leave_approvel_date;
		//$app_tip = getemployeeName($app_emp, true).' के द्वारा दिनांक '.get_date_formate($app_date).' को अवकाश अनुमोदित कर  ' . $app_reson.' लिखी गयी टिप';

        $data = array(
			'emp_leave_forword_emp_id' => $this->session->userdata('emp_id'),
			'emp_leave_forword_type' => '1',
			'emp_leave_forword_date' => date('Y-m-d H:i:s'),
			'leave_status' =>  4,
			'emp_leave_deny_reason' => $this->input->post('resend_reson'),
			'emp_leave_approval_emp_id' => '0',
            'emp_leave_approval_type' => '0',
            'emp_leave_approvel_date' => '0000-00-00',
		);
		//pr($app_tip);
        $response = $this->leave_model->updateLeave($leave_id, $data);
		set_leave_log($leave->emp_leave_movement_id, $this->session->userdata('emp_id'), 'अस्वीकृत अवकाश पुनः अग्रेषित किया गया ',$this->input->post('resend_reson'));
		$this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
		redirect($_SERVER['HTTP_REFERER']);
		//redirect('leave/leave_forward');
    }

    public function forword_not_leave($leave_id) {

        $data = array(
            'emp_leave_forword_emp_id' => $this->session->userdata('emp_id'),
            'emp_leave_forword_type' => '2',
            'emp_leave_forword_date' => date('Y-m-d h:i:s'),
            'leave_status' =>  4,
        );

        $response = $this->leave_model->updateLeave($leave_id, $data);
        if ($response) {
			set_leave_log($leave_id,$this->session->userdata('emp_id'), 'अवकाश अग्रेषित योग्य नहीं किया गया');
            $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
             redirect($_SERVER['HTTP_REFERER']);
			//redirect('leave/leave_forward');
        }
    }

    function deny() {
        $leave_id = $this->input->post('leaveID');
        $data = array(
            'emp_leave_forword_emp_id' => $this->session->userdata('emp_id'),
            'emp_leave_forword_type' => '2',
            'emp_leave_forword_date' => date('Y-m-d H:i:s'),
            'emp_leave_deny_reason' => $this->input->post('deny_reson'),
           // 'leave_status' =>  8,
        );

        $response = $this->leave_model->updateLeave($leave_id, $data);
        if ($response) {
			set_leave_log($leave_id,$this->session->userdata('emp_id'),' अवकाश अग्रेषित योग्य नहीं किया गया ',$this->input->post('deny_reson'));
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
            foreach ($leave_ids as $leaveid) {
                $data = array(
                    'emp_leave_forword_emp_id' => $this->session->userdata('emp_id'),
                    'emp_leave_forword_type' => $this->input->post('bultselect'),
                    'emp_leave_forword_date' => date('Y-m-d H:i:s'),
                    'leave_status' =>  4,
                );
                $response = $this->leave_model->updateLeave($leaveid, $data);
				set_leave_log($leaveid,$this->session->userdata('emp_id'),' अवकाश अग्रेषित  किया गया ');
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



    public function employeeLeave() {
        $data['title'] = $this->lang->line('leave_employee');
        $data['title_tab'] = $this->lang->line('leave_serach_employee');
        if (isset($_POST['search_type'])) {
            $data['userleaves_list'] = $this->leave_model->getUser(
                $this->input->post('search_type'), $this->input->post('seach_value')
            );
        }

        $data['module_name'] = "leave";
        $data['view_file'] = "leave/employee_search_leave"

        ;
        $this->template->index($data);
    }

    public function show_404() {
        $this->load->view('404');
    }

}
