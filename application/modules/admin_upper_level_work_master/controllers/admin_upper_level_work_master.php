<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class admin_upper_level_work_master extends MX_Controller {
     function __construct() {
        parent::__construct();
        $this->load->module('template');
        $this->load->model('admin_upper_level_work_master_model','upper_level_work_master');
        $this->load->language('admin_upper_level_other_work', 'hindi');
   }

 	public function index()
    {
        $data = array();
        $data['title'] = $this->lang->line('emp_other_work_title_label');
        $data['title_tab'] = $this->lang->line('emp_other_work_title_tab'); 
        $data['get_otherwork']=get_list(OTHER_WORK_UPPERLEVEL_MASTER,'other_work_id',null);
        //pre($data['get_section']);
        $data['module_name'] = "admin_upper_level_work_master";
        $data['view_file'] = "admin_upper_level_work_master/index";
        $this->template->index($data);
    }

    public function manage_otherwork($id=null){
        $this->load->helper(array('form', 'url'));
        $data = array();
        $data['title'] = $this->lang->line('emp_other_work_title_label');
        $data['title_tab'] =$this->lang->line('emp_other_work_title_tab');
        $data['page_title'] = $this->lang->line('manage_label_edit');
        $data['is_page_edit']=0;
        $otherwork_master_detail=get_list(OTHER_WORK_UPPERLEVEL_MASTER,null,array('other_work_id'=>$id));
        $data['otherwork_master_detail']=$otherwork_master_detail[0];
        $data['id']=$id;
        $this->form_validation->set_rules('other_work_title_hi',$this->lang->line('label_error_otherwork_hi') , 'trim|required|xss_clean');
        $this->form_validation->set_rules('other_work_title_en',$this->lang->line('label_error_otherwork_en'), 'trim|required|xss_clean');
        //$this->form_validation->set_rules('section_short_name',$this->lang->line('section_short_label'), 'trim|required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if ($this->form_validation->run($this) === TRUE)
        {
            $section_tbl_data=array($this->input->post());
            //pr($section_tbl_data);
            if($id){
                $res=updateData(OTHER_WORK_UPPERLEVEL_MASTER,$section_tbl_data[0],array('other_work_id'=>$id));
                if($res){
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>'.$this->lang->line('update_success_message').'</div>');
                }
            }
            redirect('admin/employee_otherwork');
        }
        //$data['get_section']=get_list(SECTIONS,'section_id',null);
        //pre($data['get_section']);
        $data['view_file'] = "admin_upper_level_work_master";
        $data['module_name'] = "admin_upper_level_work_master";
        $this->template->index($data);

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