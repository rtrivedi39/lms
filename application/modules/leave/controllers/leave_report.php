<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Leave_report extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->module('template');
        $this->load->language('leave', 'hindi');
        $this->load->language('leave_report', 'hindi');
        $this->load->model("leave_model");
        $this->load->helper('leave_helper');
        authorize();
    }

    public function is_logged_in() {
        if ($this->session->userdata('is_logged_in') === false) {
            redirect("home");
        }
    }

    public function index() {
        no_cache();
        $data = array();

        $data['title'] = $this->lang->line('title');
        $data['page_title'] = $this->lang->line('page_title');
        $data['process'] = false;
        $data['module_name'] = "leave";
        $data['view_file'] = "leave/leave_report";
        $this->template->index($data);
    }

    public function reports() {
        $today = date('Y-m-d');
        $this_month = date('m');
        $maxDays = date('t');
        $this_year = date('Y');
        $leave_sub_type = null;
		
        $btnsearch = $this->input->post('btnsearch');
        if($btnsearch == 'btnsearch_all'){
            $this->form_validation->set_rules('start_date', $this->lang->line('required'), 'required');
            $this->form_validation->set_rules('end_date', $this->lang->line('required'), 'required');
            $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        }

        if ($this->form_validation->run($this) == TRUE || $btnsearch != 'btnsearch_all') {
            $form_input = $this->input->post();
            if($btnsearch == 'btnsearch_all'){
                $start_date = !empty($this->input->post('start_date')) ? $this->input->post('start_date') : date('Y-m-d');
                $end_date = !empty($this->input->post('end_date')) ? $this->input->post('end_date') : date('Y-m-d');
            } else if($btnsearch == 'btnsearch_today'){
                $start_date = $today;
                $end_date = $today;               
            } else if($btnsearch == 'btnsearch_tomorrow'){
                $start_date = date('Y-m-d', strtotime($today.' -1 Days'));
                $end_date = date('Y-m-d', strtotime($today.' -1 Days'));
            } else if($btnsearch == 'btnsearch_thisweek'){
                $week_days = week_start_end_by_date($today);
                $start_date = date('Y-m-d', strtotime($week_days['first_day_of_week']));
                $end_date = date('Y-m-d', strtotime($week_days['last_day_of_week']));
            }else if($btnsearch == 'btnsearch_lastweek'){
                $week_days = week_start_end_by_date(date('Y-m-d', strtotime($today.' -7 Days')));
                $start_date = date('Y-m-d', strtotime($week_days['first_day_of_week']));
                $end_date = date('Y-m-d', strtotime($week_days['last_day_of_week']));
            }else if($btnsearch == 'btnsearch_thismonth'){
                $start_date =   $this_year.'-'.$this_month.'-01';
                $end_date = $this_year.'-'.$this_month.'-'.$maxDays;
            } else if($btnsearch == 'btnsearch_lastmonth'){
                $start_date =   $this_year.'-'.($this_month-1).'-01';
                $end_date = $this_year.'-'.($this_month-1).'-'.$maxDays;
            } else if($btnsearch == 'btnsearch_thisyear'){
                $start_date =   $this_year.'-01-01';
                $end_date = $this_year.'-12-31';
            } else if($btnsearch == 'btnsearch_lastyear'){
                $start_date =   $this_year-1 .'-01-01';
                $end_date = $this_year-1 .'-12-31';
            }
            
            $form_input['start_date'] = date('d-m-Y', strtotime($start_date));
            $form_input['end_date'] = date('d-m-Y', strtotime($end_date));
            
            $userdata = !empty($this->input->post('userid')) ? get_data_from_where(EMPLOYEES, 'emp_id', 'emp_unique_id', $this->input->post('userid')) : '';
            $emp_id = !empty($userdata) ? $userdata['emp_id'] : $this->input->post('userid');
            $leave_type = !empty($this->input->post('leave_type')) ? $this->input->post('leave_type') : '';
            if($leave_type == 'ld'){
				$leave_type = 'cl';
				$leave_sub_type = 'ld';
			}
			$emp_section_id = !empty($this->input->post('emp_section_id')) ? $this->input->post('emp_section_id') : '';
       
            $data['process'] = true;
            $data['form_input'] = $form_input;
            //pre($leave_sub_type);
            $data['leave_reports'] = $this->leave_model->get_reports($start_date, $end_date, $emp_id, $leave_type, $emp_section_id, true ,$leave_sub_type, $this->input->post('leave_status'), $this->input->post('employees_class'));
        } else {
            $data['process'] = false;
        }
		$form_input['userid'] = $this->input->post('userid');
		$form_input['leave_type'] = $this->input->post('leave_type');
		$data['form_input'] = $form_input;
        $data['title'] = $this->lang->line('title');
        $data['page_title'] = $this->lang->line('page_title');
        $data['module_name'] = "leave";
        $data['view_file'] = "leave/leave_report";
        $this->template->index($data);
    }
    
    
    public function show_404() {
        $this->load->view('404');
    }

}
