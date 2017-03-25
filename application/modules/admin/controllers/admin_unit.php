<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Admin_unit extends MX_Controller {
    
     function __construct() {
        parent::__construct();
        $this->load->library('form_validation');
        $this->load->helper('cookie');
        $this->load->model('admin_unit_model');
        $this->load->module('template');
        $this->load->language('unit','hindi' );
        //$this->load->controller('template/template','admin_template');
    }
    public function isLoggedIn()
    {
        if ($this->session->userdata('admin_logged_in') === TRUE)
        {
            redirect("admin_dashboard");
        }
    }
    /**
    * created by sulbha shrivastava
    * @ Function Name      : index
    * @ Function Purpose   : display unit list 
    * @ Function Returns   : 
    */
    public function index()
    {
        $data = array();
        $data['title']            = $this->lang->line('title');
        $data['title_tab']      = $this->lang->line('unit_all_unit_list');
        $data['get_unit']       = get_list(UNIT_LEVEL,'unit_id',null);
        $data['view_file']      = "admin_unit";
        $data['module_name']    = "admin_unit";
        $this->template->index($data);
    }
    /**
    * created by sulbha shrivastava
    * @ Function Name      : manage_unit
    * @ Function Params    : $data {mixed}, $kill {boolean}
    * @ Function Purpose   : display add and edit unit form 
    * @ Function Returns   : edit data 
    */
    public function manage_unit($id = ''){
        $data = array();
        $data['title']          = $this->lang->line('title');
        $data['title_tab']      = $this->lang->line('unit_all_unit_list');
        $data['get_unit']       = get_list(UNIT_LEVEL,'unit_id',null);
        $data['uid']=$id;
        $data['view_file'] = "admin_manage_unit";
        $data['module_name'] = "admin_unit";
        $data['unitdata'] = $this->admin_unit_model->getUnitData($id);
        $this->template->index($data);

    }

    /**
    * created by sulbha shrivastava
    * @ Function Name      : addUpdateUnit
    * @ Function Params    : $data {mixed}, $kill {boolean}
    * @ Function Purpose   : add and update unit value
    * @ Function Returns   : insert id
    */
    public function addUpdateUnit()
    {
        $edit_id=null;
        if($this->input->post('edit_id') && $this->input->post('edit_id')!='')
        {
           $this->form_validation->set_rules('unit_name',$this->lang->line('unit_name_required'), 'required');
            $this->form_validation->set_rules('unit_level_name',$this->lang->line('unit_level_name_required'), 'required');
            $this->form_validation->set_rules('unit_code', $this->lang->line('unit_code_required'), 'required|numeric');
            $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
           if ($this->form_validation->run($this) === TRUE)
             {
                    $edit_id = $this->input->post('edit_id');
                    $data =array(
                            'unit_name'         => $this->input->post('unit_name'),
                            'unit_level_name'   => $this->input->post('unit_level_name'),
                            'unit_code'         => $this->input->post('unit_code'),

                        );
                   $response = $this->admin_unit_model->updateUnit($data , $edit_id);
                   if($response)
                   {
                        $this->session->set_flashdata('update',$this->lang->line('unit_update_message'));
                        redirect('admin/unit');

                   }
            }
            else
            {
                $data = array();
                $data['title']= $this->lang->line('title');
                $data['title_tab'] = $this->lang->line('unit_all_unit_list');
                $data['view_file'] = "admin_manage_unit";
                $data['module_name'] = "admin_unit";
                $data['unitdata'] = $this->admin_unit_model->getUnitData($edit_id);
                $this->template->index($data);

             }

        }
        else
        {
            $this->form_validation->set_rules('unit_name',$this->lang->line('unit_name_required'), 'required');
            $this->form_validation->set_rules('unit_level_name',$this->lang->line('unit_level_name_required'), 'required');
            $this->form_validation->set_rules('unit_code', $this->lang->line('unit_code_required'), 'required|numeric');
            $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
            if ($this->form_validation->run($this) === TRUE)
            {
                $table_name =array(
                    'unit_name'         => $this->input->post('unit_name'),
                    'unit_level_name'   => $this->input->post('unit_level_name'),
                    'unit_code'         => $this->input->post('unit_code'),
                    'unit_create_date'  => date('Y-m-d H:i:s'),

                );
                $response = insertData($table_name,UNIT_LEVEL);
                if($response)
               {
                    $this->session->set_flashdata('insert',$this->lang->line('unit_insert_message'));
                    redirect('admin/unit');
               }
            }
            else
            {
                $data = array();
                $data['title']          = $this->lang->line('title');
                $data['title_tab']      = $this->lang->line('unit_all_unit_list');
                $data['view_file'] = "admin_manage_unit";
                $data['module_name'] = "admin_unit";
                $this->template->index($data);

             }
        }

    }

    /**
    * created by sulbha shrivastava
    * @ Function Name      : delete_unit
    * @ Function Params    : $data {mixed}, $kill {boolean}
    * @ Function Purpose   : add and update unit value
    * @ Function Returns   : insert id
    */
    public function delete_unit( $delete_id = '')
    {
        $response = $this->admin_unit_model->delete_unit( $delete_id );
        if ($response)
         {
                $this->session->set_flashdata('delete',$this->lang->line('unit_delete_message'));
                redirect('admin/unit');

          
        }
    }
    
    public function show_404() {
         $this->load->view('404');
     }
}