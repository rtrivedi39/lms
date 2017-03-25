<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Dashboard extends MX_Controller {
    
     function __construct() {
        parent::__construct();     
        $this->load->module('template');
        $this->load->model('cr_model');
        $this->lang->load("navigation","hindi");
        $this->load->module('common_dashboard');
        $this->load->model('dashboard/common_dashboard_model','dashboard_model');
        $this->load->language('common_dashboard','hindi');
        $this->load->helper('leave_helper');
        //$this->load->controller('template/template','admin_template');
        authorize();
    }
    public function is_logged_in()
    {
        if ($this->session->userdata('is_logged_in') === false)
        {
            redirect("home");
        }
    }
    public function index()
    {
        no_cache();        
        $this->is_logged_in();
        $data = $this->index1();
        {     
            $role = $this->session->userdata('user_role');
            $dashboard = 'employee/dashboard_';
            $sidebar = 'employee/left_sidebar_';
            switch($role){
                case '1':
                    redirect('admin/dashboard');
                break;
                case '2':
                    redirect('admin/dashboard');
                break;
                case '3':
                    $data['view_file'] = $dashboard."ps";
                    $data['view_left_sidebar'] =  $sidebar."ps";
                break;
                case '4':
                    $data['view_file'] = $dashboard."sl";
                break;
                case '5':
                    $data['view_file'] = $dashboard."as";
                break;
                case '6':
                    $data['view_file'] = $dashboard."ds";
                break;
                case '7':
                    $data['view_file'] = $dashboard."us";
                break;
                case '8':                  
                    $data['view_left_sidebar'] =  $sidebar."so";                    
                    $data['view_file'] = $dashboard."so";
                   
                break;
                case '9':
                    $data['view_file'] = $dashboard."cr";
                    $data['view_left_sidebar'] = $sidebar."cr";
                break;
                default:
                    redirect('home');
                break;

            }      

            $data['module_name'] = "employee";
            $this->template->index($data);
        }
    }

    public function index1()
    {
       
        $data = array();

        $data['title']          = $this->lang->line('title');
        $data['title_tab']      = $this->lang->line('emprole_all_unit_list');
      
        
        $data['total_file'] = $this->dashboard_model->getTotalFile();
        $data['dispetch_file'] = $this->dashboard_model->getDispatchFile();
        $data['pending_file'] = $this->dashboard_model->getpendingFile();
        
        $data['pending_files'] = $this->dashboard_model->getPendingfilesDetails();
        $setion_id = getEmployeeSection();
        $data['notice_boards']  = getNoticeBoardInformation($setion_id);
        return $data;        
       // $data['module_name']    = "dashboard";
       // $data['view_file']      = "dashboard/index";
       // $this->template->index($data);
    }
   
 
    public function show_404() {
         $this->load->view('404');
     }

      /** This function will chnage login user password
        $param 
        return boolean data if success or failer
     */
    public function change_pwd()
    {
        $this->form_validation->set_rules('old_password', 'Old Password', 'required');
        $this->form_validation->set_rules('new_password', 'New Password', 'required');
        $this->form_validation->set_rules('con_password', 'Confirm Password', 'required');
         if ($this->form_validation->run($this) === TRUE)
        {
            $oldpssword = md5($this->input->post('old_password'));
            $match = $this->admin_login_model->match_oldpwd($oldpssword);
            if($match > 0){
                 $responce = $this->admin_login_model->change_pwd($newpssword);
                if($responce)
                {
                    $this->session->set_flashdata('update','Your password updated successfully..!!');
                    redirect('employee/changepassword');

                }

            }else
            {

                $this->session->set_flashdata('error','Old password not match..!!');
                redirect('employee/changepassword');
            }
        }
     }

    public function profile()
    {
        $data = array();
       $data['userdata'] = $this->admin_login_model->getUserdata();
        $data['view_file'] = "profile";
        $data['module_name'] = "employee";
        $this->template->index($data);  
      
    }

    public function editpassword()
    {
        $data = array();
        $data['userdata'] = $this->admin_login_model->getUserdata();
        $data['view_file'] = "change_pwd";
        $data['module_name'] = "change_pwd";
        $this->template->index($data);  
      
    }

    public function updateProfile()
    {

        if($this->input->post('edit_id')){
            
           
              $data = array(
                    'emp_full_name'         => $this->input->post('emp_name') ,
                    'emp_email'             => $this->input->post('email') ,
                    'emp_mobile_number'     => $this->input->post('mobile') ,
                 );
            if($_FILES['userfile']['name']){

                    $image_name = uploadFile(); 
                    $data['emp_image'] =  $image_name;

            }
            print_r($data);
            $edit_id = $this->input->post('edit_id');
            $response = $this->admin_login_model->updateProfile($data , $edit_id);
            if($response){
                $this->session->set_flashdata('update',"Account details updated successfully..!!");
                redirect('admin/profile');
            }

        }
      
    }
    function upload() {
        $this->load->view('upload_file', array('error' => ' ' ));
    }
     function do_upload() {
        print_r($_FILES);die;
        $config = array(
            'upload_path'   => './uploads/',
            'allowed_types' => 'gif|jpg|png',
            'max_size'      => '100',
            'max_width'     => '1024',
            'max_height'    => '768',
            'encrypt_name'  => true,
        );

        $this->load->library('upload', $config);

        if (!$this->upload->do_upload()) {
            $error = array('error' => $this->upload->display_errors());
            $this->load->view('upload_file', $error);
        } else {
            $upload_data = $this->upload->data();
            print_r($upload_data);die;
            $data_ary = array(
                'title'     => $upload_data['client_name'],
                'file'      => $upload_data['file_name'],
                'width'     => $upload_data['image_width'],
                'height'    => $upload_data['image_height'],
                'type'      => $upload_data['image_type'],
                'size'      => $upload_data['file_size'],
                'date'      => time(),
            );

            //$this->load->database();
           // $this->db->insert('upload', $data_ary);

            //$data = array('upload_data' => $upload_data);
           // $this->load->view('upload_success', $data);
        }
    }
}