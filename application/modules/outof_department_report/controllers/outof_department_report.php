<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Outof_department_report extends MX_Controller {
     function __construct() {
        parent::__construct();
        $this->load->module('template');
        $this->load->model('outof_department_report_model');
        $this->load->model('leave/leave_model');
        $this->load->language('outof_department_report','hindi');
    }
	
 	public function index($type = null)
    {  
        $data['title'] = $this->lang->line('report_title');
        $data['title_tab'] = $this->lang->line('report_sub_title');
		$data['type_page'] = 'main';
		if($type == 'all'){
			$data['get_report']= $this->outof_department_report_model->get_outof_department_report(null, null, true);
			$data['all_view'] = true;
		} else {
			$data['get_report']= $this->outof_department_report_model->get_outof_department_report(null, null);
			$data['all_view'] = false;
		}
       
        $data['user_is_forwader'] = $this->outof_department_report_model->get_check_forwader();
        $data['module_name'] = "outof_department_report";
        $data['view_file'] = "outof_department_report/index";
        $this->template->index($data);
    }
	
	public function search_report()
    {  
		$fromdate = get_date_formate($this->input->post('report_from_date'),'Y-m-d');
		$todate = get_date_formate($this->input->post('report_to_date'),'Y-m-d');
		$emp_id = null;
        $data['title'] = $this->lang->line('report_title');
        $data['title_tab'] = $this->lang->line('report_sub_title');
		$data['type_page'] = 'main';
        $data['all_view'] = false;
        $data['user_is_forwader'] = $this->outof_department_report_model->get_check_forwader();
		$data['get_report']= $this->outof_department_report_model->get_report_date_range($fromdate, $todate, $emp_id);
        $data['module_name'] = "outof_department_report";
        $data['view_file'] = "outof_department_report/index";
        $this->template->index($data);
    }
	
	public function approve_deny()
    {  
	    $employee_ids = array();
		$empids = $this->leave_model->get_under_forwader_employees();
        if(!empty($empids)){
			foreach ($empids as $empid) {
				$employee_ids[] = $empid->emp_id;
			}
		}
        $data['title'] = $this->lang->line('report_title');
        $data['title_tab'] = $this->lang->line('report_sub_title');
        $data['type_page'] = 'approve_deny';
        $data['get_report']= $this->outof_department_report_model->get_outof_department_report(null, $employee_ids);
        $data['user_is_forwader'] = $this->outof_department_report_model->get_check_forwader();
		$data['module_name'] = "outof_department_report";
        $data['view_file'] = "outof_department_report/index";
        $this->template->index($data);
    }
	
	public function approve($id){
		$data = array(
			'report_status' => 1,
			'report_approval_emp_id' => $this->session->userdata('emp_id'),
			'report_approval_date' => date('Y-m-d h:i:s'),
		);
		//pr($data);
		$res = updateData(OUT_OF_DEPARTMENT_REPORT, $data, array('report_id' => $id));
		if($res){
			$this->session->set_flashdata('update',$this->lang->line('success_message'));
		}
		 redirect($_SERVER['HTTP_REFERER']);
	}
	
	public function deny(){
		$report_id = $this->input->post('report_id');
		$data = array(
			'report_status' => 2,
			'report_approval_emp_id' => $this->session->userdata('emp_id'),
			'report_approval_date' => date('Y-m-d h:i:s'),
			'report_cancel_date' => date('Y-m-d h:i:s'),
			'report_cancel_reason' => $this->input->post('deny_reson'),
		);
		//pr($data);
		$res = updateData(OUT_OF_DEPARTMENT_REPORT, $data, array('report_id' => $report_id));
		if($res){
			$this->session->set_flashdata('update',$this->lang->line('success_message'));
		}
		 redirect($_SERVER['HTTP_REFERER']);
		
	}
	
	
    public function manage_report($id = null){
		$data = array();

		$data['title'] = $this->lang->line('report_title');
		$data['title_tab'] = $this->lang->line('report_sub_title');    
		$data['page_title'] = $this->lang->line('add_report_title');

		$this->form_validation->set_rules('report_where_go','report_where_go' , 'trim|required');
		$this->form_validation->set_rules('report_aprox_time','report_aprox_time' , 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if ($this->form_validation->run() == TRUE)  {
			$report_when_go_date = get_date_formate($this->input->post('report_when_go_date'),'Y-m-d');
			$report_when_go_hour = $this->input->post('report_when_go_pali') == 'PM' ? $this->input->post('report_when_go_hour') + 12 : $this->input->post('report_when_go_hour');
			$report_when_go_minitues = $this->input->post('report_when_go_minitues');
			$report_when_go = $report_when_go_date.' '.$report_when_go_hour.':'.$report_when_go_minitues.':00 ';
			$report_aprox_come = date('Y-m-d H:i:s',strtotime($report_when_go.' + '.$this->input->post('report_aprox_time').' minute'));
			
			$data = array(
			 'report_where_go' => $this->input->post('report_where_go'),
			 'report_when_go'   => $report_when_go,
			 'report_aprox_time'    => $this->input->post('report_aprox_time'),
			 'report_emp_id'    => $this->session->userdata('emp_id'),
			 'report_aprox_come' => $report_aprox_come,
			);
			//pr($data);
			$res = insertData($data, outof_department_report);
			if($res){
				$this->session->set_flashdata('insert',$this->lang->line('success_message'));
			}

			redirect('outof_department_report');
		}
		$data['input_data'] = $this->input->post();
		$data['view_file'] = "manage_outof_department_report";
		$data['module_name'] = "outof_department_report";
		$data['user_is_forwader'] = $this->outof_department_report_model->get_check_forwader();
		$this->template->index($data);

    }

  
	
	public function delete_report($id) {
        $res = $this->db->delete_report(outof_department_report,$id);
        if($res){
            $this->session->set_flashdata('delete',$this->lang->line('delete_success_message'));
        }
        redirect('outof_department_report');
    }

    function alpha_dash_space($str)
    {
        if(!preg_match("/^([-a-z_ ])+$/i", $str)){
            $this->form_validation->set_message('alpha_dash_space',$this->lang->line('text_allow_with_space_error'));
            return false;
        }
    }
	
	public function show_404() {
         $this->load->view('404');
 	}
}