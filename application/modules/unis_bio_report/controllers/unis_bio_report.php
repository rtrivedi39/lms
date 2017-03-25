<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');
class Unis_bio_report extends MX_Controller {
     function __construct() {
        parent::__construct();
        $this->load->module('template');
        $this->load->model('unis_bio_report_model');
		$this->load->library("pagination");
		$this->not_in_users = array(-1,1,2,3,4,12,123,1234,12345,1111,121,178,25,256,28,32,3253,33,3333,3523,3551,3562,3565,45,4525,4526,4534,4541,485,4908,5,533,56,58,6,61,6124,62143,646,6562,6833,85422,962,9999,555555555,632421437,851018617,100000001,111,328963,9302,8,876,929,5555,1234567);
    }
	
 	public function index($type = null)
    {  
		$data = array();      
        $data['title'] = 'Bio metric report';
        $data['title_tab'] = 'Bio metric report';	
        $data['search_report'] = false;		
        $data['day_wise_report'] = false;	
        $data['month_wise_report'] = false;	
        $data['all_emp_absent_report'] = false;	
        $data['module_name'] = "unis_bio_report";
        $data['view_file'] = "unis_bio_report/index";
        $data['last_upload']= $this->unis_bio_report_model->get_last_upload_date();
		$data['last_id']= $this->unis_bio_report_model->get_last_id();
		$data['form_input'] = $this->input->post();
        $this->template->index($data);
    }
	
   	public function all_emp_absent_report($type = null)
    {  
		$data = array();      
        $data['title'] = 'Bio metric report';
        $data['title_tab'] = 'Bio metric report';	
        $data['search_report'] = false;		
        $data['day_wise_report'] = false;	
        $data['month_wise_report'] = false;	
        $data['all_emp_absent_report'] = true;	
        $data['module_name'] = "unis_bio_report";
        $data['view_file'] = "unis_bio_report/index";
        $data['last_upload']= $this->unis_bio_report_model->get_last_upload_date();
		$data['last_id']= $this->unis_bio_report_model->get_last_id();
		$data['all_employees_list']= $this->unis_bio_report_model->all_employees();
		$data['form_input'] = $this->input->post();
        $this->template->index($data);
    }
	

	public function search_report()
    {  
		$data['title'] = 'Bio metric report';
        $data['title_tab'] = 'Bio metric report';	
		$fromdate = get_date_formate($this->input->post('report_from_date'),'Ymd');
		$todate = get_date_formate($this->input->post('report_to_date'),'Ymd');		
		$data['last_upload']= $this->unis_bio_report_model->get_last_upload_date();
		$data['last_id']= $this->unis_bio_report_model->get_last_id();
		$data['search_report'] = true;
		$data['day_wise_report'] = false;	
		$data['month_wise_report'] = false;	
		 $data['all_emp_absent_report'] = false;	
		if($this->input->post('search_report') == 'search_report'){
			$emp_unique_id = $this->input->post('emp_unique_id');
			$data['get_report']= $this->unis_bio_report_model->get_report_date_range($fromdate, $todate, $emp_unique_id);
			$data['module_name'] = "unis_bio_report";
			$data['view_file'] = "unis_bio_report/index";
		} else if($this->input->post('search_report') == 'search_report_all'){
			$data['fromdate'] =  $fromdate ;
			$data['todate'] = $todate ;
			$data['emp_unique_ids'] =  $this->unis_bio_report_model->get_bio_users();
			$data['module_name'] = "unis_bio_report";
			$data['view_file'] = "unis_bio_report/all_report";
		} else{
			
		}
		$data['form_input'] = $this->input->post();
        $this->template->index($data);
    }	
	
	public function search_report_daily()
    {  
		$data['title'] = 'Bio metric report';
        $data['title_tab'] = 'Bio metric report';	
		$_date = get_date_formate($this->input->post('report_date'),'Ymd');		
		$type = $this->input->post('report_type');		
		$data['last_upload']= $this->unis_bio_report_model->get_last_upload_date();
		$data['last_id']= $this->unis_bio_report_model->get_last_id();
		$data['day_wise_report'] = true;	
		$data['month_wise_report'] = false;	
		$data['search_report'] = false;	
		 $data['all_emp_absent_report'] = false;		
		$data['get_report']= $this->unis_bio_report_model->get_report_date($_date,$type);
		$data['module_name'] = "unis_bio_report";
		$data['view_file'] = "unis_bio_report/index";
		$data['form_input'] = $this->input->post();
        $this->template->index($data);
    }	

    public function search_report_month()
    {  
		$data['title'] = 'Bio metric report';
        $data['title_tab'] = 'Bio metric report';	
		$month = $this->input->post('report_month');	
		$year = $this->input->post('report_year');		
		$type = $this->input->post('report_type');		
		$group_type = $this->input->post('group_type');	
		$class_wise = $this->input->post('class_wise');	
		$data['last_upload']= $this->unis_bio_report_model->get_last_upload_date();
		$data['last_id']= $this->unis_bio_report_model->get_last_id();
		$data['day_wise_report'] = false;
		$data['month_wise_report'] = true;		
		$data['search_report'] = false;		
		 $data['all_emp_absent_report'] = false;	
		$data['get_report']= $this->unis_bio_report_model->get_report_date(null,$type,$month, $year,$group_type,$class_wise);
		$data['module_name'] = "unis_bio_report";
		$data['view_file'] = "unis_bio_report/index";
		$data['form_input'] = $this->input->post();
        $this->template->index($data);
    }	

    function alpha_dash_space($str)
    {
        if(!preg_match("/^([-a-z_ ])+$/i", $str)){
            $this->form_validation->set_message('alpha_dash_space',$this->lang->line('text_allow_with_space_error'));
            return false;
        }
    }
    
    function ajax_get_list(){
		$section_id = $this->input->post('section_id');
		$emp_role = $this->session->userdata('user_designation');		
		$tbl_emp = EMPLOYEES;
		$tbl_report = UNIS_BIO_REPORT;
		$tbl_role = ft_emprole_master;
		if($section_id == 'other'){
	        $this->db->select('bio_user_name as emp_full_name_hi,bio_user_id as  emp_unique_id');
	        $this->db->from($tbl_report);
		    $this->db->join($tbl_emp, $tbl_emp . '.emp_unique_id =' . $tbl_report . '.bio_user_id','LEFT');
		    $this->db->join($tbl_role, $tbl_role . '.role_id =' . $tbl_emp . '.role_id','LEFT');
			$this->db->where_not_in('bio_user_id',$this->not_in_users);
			$this->db->where('emp_unique_id',null,false);		
			$this->db->order_by('bio_user_id','ASC');
			$this->db->group_by('bio_user_id');
			$query = $this->db->get();
        } else{
            $this->db->select($tbl_emp.'.emp_id,emp_unique_id,designation_id,emp_full_name,emp_full_name_hi,emprole_name_hi,emp_title_hi,emp_title_en');
			$this->db->join('ft_emprole_master', $tbl_emp.'.designation_id = ft_emprole_master.role_id');
			if($section_id=='officers'){
				$this->db->where("(ft_employee.role_id >= $emp_role AND ft_employee.role_id < 8  AND ft_employee.role_id !=1 AND emp_status ='1' AND emp_is_retired = '0' AND emp_posting_location ='1') or (ft_employee.role_id='11')");
			}else if($section_id == 'pa'){
				$this->db->where("(ft_employee.role_id in (12,13,25,27) AND emp_status ='1' AND emp_is_retired = '0' AND emp_posting_location ='1')");
			}else{
				//if($emp_role<=6){
					$this->db->where("FIND_IN_SET('$section_id',`emp_section_id`) AND  `ft_employee`.role_id >= 8 AND emp_status ='1' AND `ft_employee`.role_id!='11' AND emp_is_retired = '0' AND emp_posting_location ='1'");
				//}else{ 
					//$this->db->where("FIND_IN_SET('$section_id',`emp_section_id`) AND  `ft_employee`.role_id > $emp_role AND emp_status ='1' AND `ft_employee`.role_id!='11' AND emp_is_retired = '0' AND emp_posting_location ='1'");
				//}
			}
			$this->db->order_by($tbl_role.'.emprole_level','asc');
			$this->db->order_by($tbl_emp.'.emp_full_name_hi','desc');
	        $query = $this->db->get($tbl_emp);
        }
       //echo   $this->db->last_query();
        $emplyees =  $query->result_array();       
        echo json_encode($emplyees);
        exit();
	}
	
	public function upload_report()
    {  
		$data['title'] = 'Bio metric report';
        $data['title_tab'] = 'Bio metric report';
		$data['upload_msg'] = null;
		$row = 0;
		$target_file = $_FILES["upload_file"]["tmp_name"];
		$FileType = pathinfo($_FILES["upload_file"]["name"],PATHINFO_EXTENSION);
		if($FileType != "csv" ) {
			$data['upload_msg'] =  "Sorry, only csv files are allowed.";
			$data['upload_class'] =  "bg-danger";
		}
		if ($_FILES["upload_file"]["error"] > 0) {
            $data['upload_msg'] =  "Error Code: " . $_FILES["upload_file"]["error"] ;
			$data['upload_class'] =  "bg-danger";

        }
		if(empty($data['upload_msg'])){
			 if(($handle = fopen($target_file, 'r')) !== FALSE) {
				// necessary if a large csv file
				set_time_limit(0);

				while(($u_data = fgetcsv($handle, 1000, ',')) !== FALSE) {
					// number of fields in the csv
					$col_count = count($u_data);

					// get the values from the csv
					$csv[$row]['bio_id'] = null;
					$csv[$row]['bio_date'] = $u_data[0];
					$csv[$row]['bio_time'] = $u_data[1];
					$csv[$row]['bio_terminal'] = $u_data[2];
					$csv[$row]['bio_user_id'] = $u_data[3];
					$csv[$row]['bio_user_name'] = $u_data[4];
					$csv[$row]['bio_user_unique_id'] = $u_data[5];
					$csv[$row]['bio_office'] = $u_data[6];
					$csv[$row]['bio_post'] = $u_data[7];
					$csv[$row]['bio_card'] = $u_data[8];
					$csv[$row]['bio_user_type'] = $u_data[9];
					$csv[$row]['bio_user_mode'] = $u_data[10];
					$csv[$row]['bio_matching'] = $u_data[11];
					$csv[$row]['bio_result'] = $u_data[12];
					$csv[$row]['bio_picture'] = $u_data[13];
					$csv[$row]['bio_device'] = $u_data[14];
					$csv[$row]['bio_over_count'] = $u_data[15];
					$csv[$row]['bio_property'] = $u_data[16];
					$csv[$row]['bio_job_code'] = $u_data[17];
					$csv[$row]['bio_etc'] = $u_data[18];
					$csv[$row]['bio_trans'] = $u_data[19];
					$csv[$row]['bio_nrv1'] = $u_data[20];
					$csv[$row]['bio_nrv2'] = $u_data[21];
					$csv[$row]['bio_nrv3'] = $u_data[22];
					$csv[$row]['bio_nrv4'] = $u_data[23];

					// inc the row
					$row++;
				}
				fclose($handle);
			}
			if($row > 0){
				$response = $this->unis_bio_report_model->upload_file($csv);
				if($response == true){
					$data['upload_msg'] =  'File upload successfully!';
					$data['upload_class'] =  "bg-success";
				}else{
					$data['upload_msg'] =  $response;
					$data['upload_class'] =  "bg-danger";
				}
			}
		}
		
		$data['last_upload']= $this->unis_bio_report_model->get_last_upload_date();
		$data['last_id']= $this->unis_bio_report_model->get_last_id();
		
		$data['day_wise_report'] = false;	
		$data['search_report'] = false;		
		$data['month_wise_report'] = false;	
		 $data['all_emp_absent_report'] = false;	
		$data['module_name'] = "unis_bio_report";
		$data['view_file'] = "unis_bio_report/index";
		$data['form_input'] = $this->input->post();
        $this->template->index($data);
    }

	public function ajax_get_late_days(){
		$unique_id = $this->input->post('unique_id');
		$month = $this->input->post('month');
		$year = $this->input->post('year');
		$days = $this->unis_bio_report_model->get_late_days($unique_id,$month,$year);
		$data['days'] = $days;
		echo json_encode($data);
		exit;
    }
	
	public function show_404() {
         $this->load->view('404');
 	}
}