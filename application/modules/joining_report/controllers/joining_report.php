<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Joining_report extends MX_Controller {
     function __construct() {
        parent::__construct();
        $this->load->module('template');
        $this->load->model('joining_report_model');
        $this->load->language('joining_report','hindi');
		$this->load->library("pagination");
    }
	
 	public function index($type = null)
    {  
		$data = array();
		// $config = array();
        // $config["base_url"] = base_url() . "joining_report/index";
        // $config["total_rows"] = $this->joining_report_model->record_count();
        // $config["per_page"] = 2;
        // $config["uri_segment"] = 3;
		// $choice = $config["total_rows"] / $config["per_page"];
		// $config["num_links"] = round($choice);				
		// $config["first_url"] = base_url() . "joining_report/index/1";				
	
        // $this->pagination->initialize($config);
		// $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		// $data["links"] = $this->pagination->create_links();
      
        $data['title'] = $this->lang->line('report_title');
        $data['title_tab'] = $this->lang->line('report_sub_title');
		if($type == 'all'){
			$data['get_report']= $this->joining_report_model->get_joining_report(null, true);
			$data['all_view'] = true;
		} else{
			$data['get_report']= $this->joining_report_model->get_joining_report(null, false);
			$data['all_view'] = false;
		}
        $data['module_name'] = "joining_report";
        $data['view_file'] = "joining_report/index";
        $this->template->index($data);
    }
	
    public function manage_report($id = null){
		$data = array();

		$data['title'] = $this->lang->line('report_title');
		$data['title_tab'] = $this->lang->line('report_sub_title');    
		$data['page_title'] = $this->lang->line('add_report_title');

		$this->form_validation->set_rules('report_from_date','report_from_date' , 'trim|required');
		$this->form_validation->set_rules('report_to_date','report_to_date' , 'trim|required');
		$this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

		if ($this->form_validation->run() == TRUE)  {
			$data = array(
			 'report_from_date' => get_date_formate($this->input->post('report_from_date'),'Y-m-d'),
			 'report_to_date'   => get_date_formate($this->input->post('report_to_date'),'Y-m-d'),
			 'report_emp_id'    => $this->session->userdata('emp_id'),
			 'report_remark'    => $this->input->post('report_remark') != '' ? $this->input->post('report_remark') : null ,
			 'joining_report_leave_type'    =>  $this->input->post('report_leave_type') ,
			);
		//pr($data);
			$res = insertData($data, JOINING_REPORT);
			if($res){
				$this->session->set_flashdata('insert',$this->lang->line('success_message'));
			}

			redirect('joining_report');
		}
		$data['input_data'] = $this->input->post();
		$data['view_file'] = "manage_joining_report";
		$data['module_name'] = "joining_report";
		$this->template->index($data);

    }

	public function search_report()
    {  
		$fromdate = get_date_formate($this->input->post('report_from_date'),'Y-m-d');
		$todate = get_date_formate($this->input->post('report_to_date'),'Y-m-d');
		$emp_id = null;
		$data['all_view'] = true;
        $data['title'] = $this->lang->line('report_title');
        $data['title_tab'] = $this->lang->line('report_sub_title');
		$data['get_report']= $this->joining_report_model->get_report_date_range($fromdate, $todate, $emp_id);
        $data['module_name'] = "joining_report";
        $data['view_file'] = "joining_report/index";
        $this->template->index($data);
    }
  
	
	public function delete_report($id) {
        $res = $this->db->delete_report(joining_report,$id);
        if($res){
            $this->session->set_flashdata('delete',$this->lang->line('delete_success_message'));
        }
        redirect('joining_report');
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