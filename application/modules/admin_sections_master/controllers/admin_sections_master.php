<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_sections_master extends MX_Controller {
     function __construct() {
        parent::__construct();
        $this->load->module('template');
        $this->load->model('admin_sections_master_model','section_model');
   }

 	public function index()
    {
        $data = array();
        $data['title'] = $this->lang->line('sections_role_manue');
        $data['title_tab'] = $this->lang->line('all_section_label'); 
        $data['get_section']=get_list(SECTIONS,'section_id',null);
        //pre($data['get_section']);
        $data['module_name'] = "admin_sections_master";
        $data['view_file'] = "admin_sections_master/index";
        $this->template->index($data);
    }

    public function manage_section($id=null){
        $this->load->helper(array('form', 'url'));
        $data = array();
        $data['title'] = $this->lang->line('sections_role_manue');
        $data['title_tab'] =$this->lang->line('sections_role_manue');
        if($id==null){
            $data['page_title'] = $this->lang->line('add_section');
            $data['is_page_edit']=1;

        }else{
            $data['page_title'] = $this->lang->line('edit_section');
            $data['is_page_edit']=0;
            $section_master_detail=get_list(SECTIONS,null,array('section_id'=>$id));
            $data['section_master_detail']=$section_master_detail[0];
        }
        $data['id']=$id;
        $this->form_validation->set_rules('section_name_hi',$this->lang->line('add_section_with_hi') , 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_name_en',$this->lang->line('add_section_with_en'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('section_short_name',$this->lang->line('section_short_label'), 'trim|required|xss_clean');
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

        if ($this->form_validation->run($this) === TRUE)
        {
            $section_tbl_data=array($this->input->post());
            if($id){
                $res=updateData(SECTIONS,$section_tbl_data[0],array('section_id'=>$id));
                if($res){
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>'.$this->lang->line('update_success_message').'</div>');
                }
            }else{
                //pr($section_tbl_data);
                $res =insertData($section_tbl_data[0],SECTIONS);
                if($res){
                    $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>'.$this->lang->line('success_message').'</div>');
                }
            }
            redirect('admin/sections');
        }
        //$data['get_section']=get_list(SECTIONS,'section_id',null);
        //pre($data['get_section']);
        $data['view_file'] = "admin_manage_sections";
        $data['module_name'] = "admin_sections_master";
        $this->template->index($data);

    }

    function alpha_dash_space($str)
    {
        if(!preg_match("/^([-a-z_ ])+$/i", $str)){
            $this->form_validation->set_message('alpha_dash_space',$this->lang->line('text_allow_with_space_error'));
            return false;
        }
    } 
    public function delete_section($id){
        if(isset($id) && $id!='' ){
            $res =delete_data(SECTIONS,array('section_id'=>$id));
            if($res){
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>'.$this->lang->line('delete_success_message').'</div>');
            }
            redirect('admin/sections');
        }
    }
    public function show_404() {
         $this->load->view('404');
 	}
}