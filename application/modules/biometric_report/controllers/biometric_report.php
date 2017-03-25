<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Biometric_report extends MX_Controller {
     function __construct() {
        parent::__construct();
        $this->load->module('template');
        $this->load->model('biometric_report_model');
        $this->load->language('biometric_report','hindi');
		$this->load->library("pagination");
    }
	
 	public function index()
    {  
		$data = array();
		// $config = array();
        // $config["base_url"] = base_url() . "biometric_report/index";
        // $config["total_rows"] = $this->biometric_report_model->record_count();
        // $config["per_page"] = 2;
        // $config["uri_segment"] = 3;
		// $choice = $config["total_rows"] / $config["per_page"];
		// $config["num_links"] = round($choice);				
		// $config["first_url"] = base_url() . "biometric_report/index/1";				
	
        // $this->pagination->initialize($config);
		// $page = ($this->uri->segment(3)) ? $this->uri->segment(3) : 0;
		// $data["links"] = $this->pagination->create_links();
      
        $data['title'] = $this->lang->line('report_title');
        $data['title_tab'] = $this->lang->line('report_sub_title');
        $data['get_report']= $this->biometric_report_model->get_biometric_report(null, null);
        $data['module_name'] = "biometric_report";
        $data['view_file'] = "biometric_report/index";
        $this->template->index($data);
    }
	
    public function manage_report($id = null){
        $data = array();
		
        $data['title'] = $this->lang->line('report_title');
        $data['title_tab'] = $this->lang->line('report_sub_title');    
        if($id == null){
			$data['page_title'] = $this->lang->line('add_report_title');
			$data['is_page_edit'] = 1;
        }else{
			$data['page_title'] = $this->lang->line('edit_report_title');
			$data['is_page_edit'] = 0;
			$report_detail = $this->biometric_report_model->get_biometric_report($id, null);
			$data['report_detail'] = $report_detail[0];
        }
	
      $data['id'] = $id;

      $this->form_validation->set_rules('report_name','report_name' , 'trim|required|xss_clean');
      $this->form_validation->set_rules('report_description','report_description' , 'trim|required|xss_clean');
      $this->form_validation->set_rules('report_type','report_type' , 'trim|required');
      $this->form_validation->set_rules('report_month','report_month' , 'trim|required');
      $this->form_validation->set_rules('report_year','report_year' , 'trim|required');
	  $this->form_validation->set_rules('report_status','report_status' , 'trim|required');
	  //$this->form_validation->set_rules('report_doccument','report_doccument' , 'trim|required');
      $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

      if ($this->form_validation->run() == TRUE)  {
		 $data = array(
             'report_type'     => $this->input->post('report_type'),
             'report_name'     => $this->input->post('report_name'),
             'report_description' => $this->input->post('report_description'),
             'report_month'   => $this->input->post('report_month'),
             'report_year'     => $this->input->post('report_year'),
             'report_status'   => $this->input->post('report_status'),
             'report_upload_emp_id'   => $this->session->userdata('emp_id'),
         );
       
         if($_FILES['report_doccument']['name'] != ''){             
             $image_name = uploadalltypeFile('report_doccument' , './uploads/report/' );
             $data['report_doccument'] =  $image_name;
         } else if($_FILES['report_doccument']['name'] == null && $id != null){
			 $data['report_doccument'] =  $this->input->post('report_doccument_select');
		 }
		
        
         if($id){
            $res = updateData(BIOMETRIC_REPORT, $data,array('report_id' => $id));
                if($res){
                     $this->session->set_flashdata('update',$this->lang->line('update_success_message'));
                  }
            }else{
				echo  $res = insertData($data, BIOMETRIC_REPORT);
				if($res){
                  $this->session->set_flashdata('insert',$this->lang->line('success_message'));
               }
            }
           redirect('biometric_report');
      }
		$data['input_data'] = $this->input->post();
		$data['view_file'] = "manage_biometric_report";
		$data['module_name'] = "biometric_report";
		$this->template->index($data);

    }

    public function view_report() {
		 $data = array(
             'report_type'    => $this->input->post('report_type'),
             'report_month'   => $this->input->post('report_month'),
             'report_year'    => $this->input->post('report_year'),
             'report_status'  => 1,
         );
		
		$data_list = get_list(BIOMETRIC_REPORT, null , $data);		
		
		if(!empty($data_list)){
			$document = $data_list[0]['report_doccument'];
			redirect(base_url().'uploads/report/'.$document);
			
		} else{
			 $data['input_data'] = $this->input->post();
			 $this->session->set_flashdata('message_report', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>No record found !</div>');
             redirect($_SERVER['HTTP_REFERER']);
		}
    }	
	
	public function delete_report($id) {
        $res = $this->db->delete_report(BIOMETRIC_REPORT,$id);
        if($res){
            $this->session->set_flashdata('delete',$this->lang->line('delete_success_message'));
        }
        redirect('biometric_report');
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