<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_department_post_master extends MX_Controller {
     function __construct() {
        parent::__construct();
        $this->load->module('template');
        $this->load->model('admin_departmentpost_master_model','departmentpost_master');
        $this->load->language('admin_department_post', 'hindi');
   }

 	public function index()
    {
        $data = array();
        $data['title'] = $this->lang->line('department_post_title_manue');
        $data['title_tab'] = $this->lang->line('department_post_title_tab'); 
        $data['get_posts']=get_list(EMPLOYEE_MASTER_NUMBER_POST,'endm_id',null);
        //pre($data['get_section']);
        $data['module_name'] = "admin_department_post_master";
        $data['view_file'] = "admin_department_post_master/index";
        $this->template->index($data);
    }

    public function manage_post($id=null){
        $this->load->helper(array('form', 'url'));
        $data = array();
        $data['title'] = $this->lang->line('department_posts_label');
        $data['title_tab'] =$this->lang->line('manage_label_edit');
        $data['page_title'] = $this->lang->line('manage_label_edit1');
        $data['is_page_edit']=0;
        $posts_master_detail=get_list(EMPLOYEE_MASTER_NUMBER_POST,null,array('endm_id'=>$id));
        $data['department_post_master']=$posts_master_detail[0];
        $data['id']=$id;
        $this->form_validation->set_rules('endm_designation',$this->lang->line('add_section_with_hi') , 'trim|required|xss_clean');
        $this->form_validation->set_rules('endm_designation_numbers',$this->lang->line('add_section_with_en'), 'trim|required|xss_clean');
        //$this->form_validation->set_rules('section_short_name',$this->lang->line('section_short_label'), 'trim|required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if ($this->form_validation->run($this) === TRUE)
        {
            $section_tbl_data=array($this->input->post());
            //pr($section_tbl_data);
            if($id){
                $res=updateData(EMPLOYEE_MASTER_NUMBER_POST,$section_tbl_data[0],array('endm_id'=>$id));
                if($res){
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>'.$this->lang->line('update_success_message').'</div>');
                }
            }
            redirect('admin/department_posts');
        }
        //$data['get_section']=get_list(SECTIONS,'section_id',null);
        //pre($data['get_section']);
        $data['view_file'] = "admin_manage_department_post";
        $data['module_name'] = "admin_department_post_master";
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