<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_notice_master extends MX_Controller {
     function __construct() {
        parent::__construct();
        $this->load->module('template');
        $this->load->model('admin_notice_master_model');
        $this->load->language('admin_notice','hindi');
    }
 	public function index()
    {
        $data = array();
        $data['title'] = $this->lang->line('notice_heading');
        $data['title_tab'] = $this->lang->line('notice_sub_heading');
       // $data['get_notice']=get_list(NOTICE_BOARD,'notice_id',null);
        $data['get_notice']= $this->admin_notice_master_model->fetchnoticebyid();
       //pr($data['get_notice']);
        $data['module_name'] = "admin_notice_master";
        $data['view_file'] = "admin_notice_master/index";
        $this->template->index($data);
    }
    public function manage_notice($id=null){
        $data = array();
        $data['title'] = "All Notices";
        $data['title_tab'] = "Notices";
        $data['get_notice_type']=get_list(NOTICE_BOARD_TYPE,'notice_id',null);
        $data['get_notice_section']=get_list(SECTIONS,'section_id',null);
        if($id==null){
        $data['page_title'] = "Add Notice";
        $data['is_page_edit']=1;
        }else{
        $data['page_title'] = "Edit Notice";
        $data['is_page_edit']=0;
        $notice1_detail = $this->admin_notice_master_model->fetchnoticebyid($id);
        $data['notice1_detail']=$notice1_detail[0];
        }
      $data['id']=$id;

      $this->form_validation->set_rules('notice_subject','notice_subject' , 'trim|required|xss_clean');
      $this->form_validation->set_rules('edit_textarea1','edit_textarea1' , 'trim|required|xss_clean');
      $this->form_validation->set_rules('notice_type_id','notice_type_id' , 'trim|required');
      $this->form_validation->set_rules('notice_from_date','notice_from_date' , 'trim|required');
      $this->form_validation->set_rules('notice_to_date','notice_to_date' , 'trim|required');
     if ($this->input->post('notice_type_id') == '2')
       {
     $this->form_validation->set_rules('notice_section','notice_section' , 'trim|required');
       }

      $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');

      if ($this->form_validation->run($this) === TRUE)
     {
        //pr('hello');
      $data = array(
             'notice_type_id'     => $this->input->post('notice_type_id'),
             'notice_subject'     => $this->input->post('notice_subject'),
             'notice_description' => $this->input->post('edit_textarea1'),
             'notice_remark'      => $this->input->post('notice_remark'),
             'notice_from_date'   => $this->input->post('notice_from_date'),
             'notice_to_date'     => $this->input->post('notice_to_date'),
             'notice_is_active'   => $this->input->post('notice_status'),
         );
         if ($this->input->post('notice_type_id') == '2')
         {
          $data['notice_section_id'] = $this->input->post('notice_section');
         }
         else
         {
             $data['notice_section_id'] = '';
         }
         if($_FILES['notice_attachment']){
             // pr($_FILES['notice_attachment']);
             $image_name = uploadalltypeFile('notice_attachment' , './uploads/notice/' );
             $data['notice_attachment'] =  $image_name;
         }
       //  pr($data);
         if($id){
            $res=updateData(NOTICE_BOARD,$data,array('notice_id'=>$id));
                if($res){
                 //  $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>raginee</div>');
                     $this->session->set_flashdata('update',$this->lang->line('update_success_message'));
                        }
            }else{
              echo  $res =insertData($data,NOTICE_BOARD);
            if($res){
                    $this->session->set_flashdata('insert',$this->lang->line('success_message'));
                    }
            }
           redirect('admin/notice');
      }
        $data['input_data'] = $this->input->post();
        $data['view_file'] = "admin_manage_notice";
        $data['module_name'] = "admin_notice_master";
        $this->template->index($data);

      }

    public function notice_delete($id)
    {
      //  pr($id);
        $data1 = array('notice_trash'=>'1');
        $this->db->where('notice_id',$id);
        $res = $this->db->update(NOTICE_BOARD,$data1);
        if($res){
            $this->session->set_flashdata('delete',$this->lang->line('delete_success_message'));
        }
        redirect('admin/notice');
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