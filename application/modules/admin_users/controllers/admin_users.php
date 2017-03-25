<?php
if (!defined('BASEPATH'))
    exit('No direct script access allowed');

class Admin_users extends MX_Controller {

    function __construct() {
        parent::__construct();
        $this->load->helper('cookie');
        $this->load->module('template');
        $this->load->model('admin_users_model', 'admin_user_model');
        $this->load->language('admin_user', 'hindi');
        authorize();
    }

    public function index() {
        $data = array();
        $data['title'] = $this->lang->line('emp_heading');
        $data['title_tab'] = $this->lang->line('emp_sub_heading');
        if($this->session->userdata('user_role')==1){
            $data['get_users'] = get_list(EMPLOYEES, 'role_id', null,'asc');
        }else{
            $data['get_users'] = get_list(EMPLOYEES, 'role_id', array('emp_posting_location'=>1),'asc');
        }
        $data['module_name'] = "admin_users";
        $data['view_file'] = "admin_users/index";
        $this->template->index($data);
		}

    public function manage_user($id = null) {
        $data = array();
        $this->load->helper(array('form', 'url'));
        $data['title'] = $this->lang->line('emp_heading');
        $data['title_tab'] = $this->lang->line('manage_emp_sub_heading');
        if ($id == null) {
            $data['page_title'] = $this->lang->line('emp_add_heading');
            $data['is_page_edit'] = 1;
        } else {
            $data['page_title'] = $this->lang->line('emp_edit_heading');
            ;
            $data['is_page_edit'] = 0;
            $emp_detail = get_list(EMPLOYEES, null, array('emp_id' => $id));
            $data['emp_detail'] = $emp_detail[0];
            $emp_more_detail = get_list(EMPLOYEE_DETAILS, null, array('emp_id' => $emp_detail[0]['emp_id']));
            $data['emp_more_detail'] = $emp_more_detail[0];
        }
        $data['id'] = $id;
        $this->form_validation->set_rules('designation_id', $this->lang->line('emp_designation_id_label'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('emp_role', $this->lang->line('emp_role_id_label'), 'trim|required|xss_clean');
        if ($this->input->post('emp_posting_location')=='1'){
            $this->form_validation->set_rules('emp_section_id', $this->lang->line('emp_section_id_label'), 'required');
        }
        if ($this->input->post('selected_emp_role') != '3' && $this->input->post('selected_emp_role') != '9' && $this->input->post('emp_posting_location')=='1'){
            $this->form_validation->set_rules('supervisor_emp_id', $this->lang->line('emp_supervisor_label'), 'required');
        }
        if (isset($id) && $id != '') {
            $this->form_validation->set_rules('emp_unique_id', $this->lang->line('emp_unique_id_label'), 'trim|xss_clean|callback_check_unique_emp_id');
            $this->form_validation->set_rules('emp_login_id', $this->lang->line('emp_login_id_label'), 'trim|alpha_dash_space|xss_clean|callback_check_unique_emp_loginid');
        } else {
            $this->form_validation->set_rules('emp_unique_id', $this->lang->line('emp_unique_id_label'), 'trim|required|xss_clean|callback_check_unique_emp_id');
            $this->form_validation->set_rules('emp_login_id', $this->lang->line('emp_login_id_label'), 'trim|required|alpha_dash_space|xss_clean|callback_check_unique_emp_loginid');
        }
        $this->form_validation->set_rules('emp_password', $this->lang->line('emp_password_label'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('emp_full_name', $this->lang->line('emp_full_name_label'), 'trim|required|xss_clean');
	$this->form_validation->set_rules('emp_full_name_hi', $this->lang->line('emp_full_name_hi'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('emp_email', $this->lang->line('emp_email_label'), 'trim|required|email|xss_clean|callback_check_unique_emp_email');
        $this->form_validation->set_rules('emp_mobile_number', $this->lang->line('emp_mobile_label'), 'trim|required|numeric|xss_clean');
        $this->form_validation->set_rules('emp_gender', $this->lang->line('emp_gender_label'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('emp_is_retired', $this->lang->line('emp_is_retired_label'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('emp_marital_status', $this->lang->line('emp_detail_martial_status_label'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('emp_detail_address', $this->lang->line('emp_detail_address_label'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('emp_detail_state', $this->lang->line('emp_state_label'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('emp_detail_city', $this->lang->line('emp_city_label'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('emp_detail_security_question', $this->lang->line('emp_security_question_label'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('emp_detail_answer', $this->lang->line('emp_security_answer_label'), 'trim|required|xss_clean');
        
        $this->form_validation->set_rules('cl_leave', $this->lang->line('emp_casual_leave'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('ol_leave', $this->lang->line('emp_optional_leave'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('el_leave', $this->lang->line('emp_earned_leave'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('hpl_leave', $this->lang->line('emp_security_answer_label'), 'trim|required|xss_clean');
        $this->form_validation->set_rules('emp_gradpay', $this->lang->line('emp_half_pay_leave'),'trim|required|xss_clean');
        $this->form_validation->set_rules('emp_houserent', $this->lang->line('emp_house_rent_label'), 'trim|required|xss_clean');
        
        $this->form_validation->set_error_delimiters('<div class="text-danger">', '</div>');
        //pre($this->input->post());
        if ($this->form_validation->run($this) === TRUE) {
            $section_ids = null;
			if(isset($_FILES['service_record_book']) && $_FILES['service_record_book']['error'] == 0){
                $file_upload = uploadalltypeFile('service_record_book' , './uploads/service_book_pdf/' );
            } else {
               $file_upload = '';
            }
	         $employe_tbl_data = array($this->input->post());
            /**/
            if (is_array($this->input->post('emp_section_id'))) {
                $section_ids = implode(',', $this->input->post('emp_section_id'));
            }
            $employee_tbal_array = array(
                'designation_id' => $this->input->post('designation_id'),
                'role_id' => $this->input->post('emp_role'),
                'emp_section_id' => $section_ids,
                'emp_unique_id' => $this->input->post('emp_unique_id'),
                'emp_login_id' => $this->input->post('emp_login_id'),
               'emp_full_name_hi' => $this->input->post('emp_full_name_hi'),
                'emp_full_name' => $this->input->post('emp_full_name'),
                'emp_email' => $this->input->post('emp_email'),
                'emp_mobile_number' => $this->input->post('emp_mobile_number'),
                'emp_is_retired' => $this->input->post('emp_is_retired'),
                'emp_create_date' => date('Y-m-d'),
                'emp_status_message' => 'Added by admin',
				'emp_status' => $this->input->post('emp_status'),     
				'emp_posting_location' => $this->input->post('emp_posting_location'),     
            );
			if(empty($id)){
				 $employee_tbal_array['emp_password'] =  md5($this->input->post('emp_password'));
			}
			else{
				$this->db->select('emp_password');
				$this->db->where('emp_id',$id);
				$query = $this->db->get(EMPLOYEES);
				$result = $query->row_array();
				//echo $this->db->last_query();
				$result['emp_password']; 
				if( $result['emp_password'] != $this->input->post('emp_password'))
				{
				
					$employee_tbal_array['emp_password'] =  md5($this->input->post('emp_password'));
				}					
			}
            $dobtime = strtotime($this->input->post('emp_detail_dob'));
            $employee_detail_tbal_array = array(
                'emp_detail_security_question' => 'what is your employee Id?',
                'emp_detail_answer' => $this->input->post('emp_detail_answer'),
                'emp_detail_gender' => $this->input->post('emp_gender'),
                'emp_detail_dob' => date("Y-m-d", $dobtime),
                'emp_detail_martial_status' => $this->input->post('emp_marital_status'),
                'emp_detail_address' => $this->input->post('emp_detail_address'),
                'emp_detail_city' => $this->input->post('emp_detail_city'),
                'emp_detail_state' => $this->input->post('emp_detail_state'),
                'emp_gradpay' => $this->input->post('emp_gradpay'),
                'emp_houserent' => $this->input->post('emp_houserent'),
                'emp_detail_create_date' => date('Y-m-d'),
				'emp_service_book_file' => $file_upload
            );
            //pr($employee_detail_tbal_array);
            /* Leave Data Array */
            $table_data_leave = array(
                'cl_leave' => $this->input->post('cl_leave'),
                'ol_leave' => $this->input->post('ol_leave'),
                'el_leave' => $this->input->post('el_leave'),
                'hpl_leave' => $this->input->post('hpl_leave'),
                'pat_leave' => $this->input->post('pat_leave'),
                'mat_leave' => $this->input->post('mat_leave'),
                'ot_leave' => $this->input->post('ot_leave'),
            );
            /* EDIT */
            if ($id) 
            {
                delete_data(EMPLOYEE_ALLOTED_SECTION, array('emp_id' => $id)); /* Delete alloted sections */
                $res = updateData(EMPLOYEES, $employee_tbal_array, array('emp_id' => $id));
                $employee_detail_tbal_array = array_merge($employee_detail_tbal_array, array('emp_id' => $id));
                $res_up = updateData(EMPLOYEE_DETAILS, $employee_detail_tbal_array, array('emp_detail_id' => $this->input->post('emp_detail_id')));
                updateData(EMPLOYEES, array('emp_section_id' => $section_ids), array('emp_id' => $id));
                /* Add new allotted section */
                if (is_array($this->input->post('emp_section_id'))) {
                    $section_id_array = $this->input->post('emp_section_id');
                    foreach ($section_id_array as $secval) {
                        $res_data = insertData(array('section_id' => $secval, 'emp_id' => $id, 'role_id' => $this->input->post('emp_role')), EMPLOYEE_ALLOTED_SECTION);
                    }
                }
                /* Employee log */
                if ($res_data) {
                    $message_text = $this->session->userdata('emp_full_name') . '(' . $this->session->userdata('emp_designation') . ') has been changed employee sections.';
                    $emp_log_activity_array = array('emp_section_id' => $section_ids,
                        'emp_id' => $id,
                        'log_prefix_status' => 'Change designation',
                        'log_description' => $message_text);
                    insertData($emp_log_activity_array, EMPLOYEE_ACTIVITY_LOG);
                }
                /* End */

                /* ADD EMP Heirarchy record */
                    if (count($this->input->post('supervisor_emp_id'))>0) {
                        delete_data(EMPLOYEE_HIARARCHI_LEVEL,array('under_emp_id'=>$id));/*Delete old heirarchy record*/
                        $supervisor_emp_id= $this->input->post('supervisor_emp_id');
                    } else {
                        $supervisor_emp_id = $res;
                    }
                    $heirarchy_level= get_designation_level($supervisor_emp_id[0],$roleid=null);
                    foreach($supervisor_emp_id as $supervisor_value){
                      insertData(array('emp_id' => $supervisor_value, 'under_emp_id' => $id, 'hirarchi_emp_level' =>$heirarchy_level), EMPLOYEE_HIARARCHI_LEVEL);  
                    }
                    /*End Heirarchy*/
                    /* Update Employee Leave information */
                    unset($table_data_leave['pat_leave']);
                    unset($table_data_leave['mat_leave']);
                    unset($table_data_leave['ot_leave']);
                    manage_employee_leave($table_data_leave, array('emp_id' => $id), 'update_leave');
                    /* End Employee Leave information */

                    /*Edit Other Work For employee*/
                    if(count($this->input->post('other_work_id'))>0) {
                        $emp_desig_id=$this->input->post('designation_id');
                        $otherwork_emp_id=$this->input->post('other_work_id');
                        $other_work_ids=implode(',',$otherwork_emp_id);
                        updateData(EMPLOYEE_ALLOTED_OTHER_WORK, array('designation_id'=>$emp_desig_id,'section_otherwork_id'=>$other_work_ids), array('emp_id' => $id));
                    }
                    /*End*/
                /* End */
            } else { 
            /* ADD EMPLOYEE */
                $res = insertData_with_lastid($employee_tbal_array, EMPLOYEES);
                $employee_detail_tbal_array = array_merge($employee_detail_tbal_array, array('emp_id' => $res));
                if ($res) {
                    if (is_array($this->input->post('emp_section_id'))) {
                        $section_id_array = $this->input->post('emp_section_id');
                        foreach ($section_id_array as $secval) {
                            insertData(array('section_id' => $secval, 'emp_id' => $res, 'role_id' => $this->input->post('emp_role')), EMPLOYEE_ALLOTED_SECTION);
                        }
                    }
                    insertData($employee_detail_tbal_array, EMPLOYEE_DETAILS);
                    $message_text = $this->session->userdata('emp_full_name') . '(' . $this->session->userdata('emp_designation') . ') has been added employee sections.';
                    insertData(array('emp_section_id' => $section_ids, 'emp_id' => $res, 'log_prefix_status' => 'add employee and designation', 'log_description' => $message_text), EMPLOYEE_ACTIVITY_LOG);

                    /* ADD EMP Heirarchy record */
                    //if ($this->input->post('supervisor_emp_id') && $this->input->post('supervisor_emp_id') != '') {
                    if (count($this->input->post('supervisor_emp_id'))>0) {
                        $supervisor_emp_id= $this->input->post('supervisor_emp_id');
                    } else {
                        $supervisor_emp_id = $res;
                    }
                    $heirarchy_level= get_designation_level($supervisor_emp_id[0],$roleid=null);
                    if($supervisor_emp_id==$res){$heirarchy_level=0;}
                    foreach($supervisor_emp_id as $supervisor_value){
                      insertData(array('emp_id' => $supervisor_value, 'under_emp_id' => $res, 'hirarchi_emp_level' =>$heirarchy_level), EMPLOYEE_HIARARCHI_LEVEL);  
                    }
                    /* End */
                    /* Add Employee Leave information */
                    //comment due to merge and update througth admim end
                    //$table_data_leave = array_merge($table_data_leave, array('emp_id' => $res));
                    //  manage_employee_leave($table_data_leave, null, 'add_leave');
                    /* End Employee Leave information */

                    /*Add Other Work For employee*/
                    if(count($this->input->post('other_work_id'))>0) {
                        $emp_desig_id=$this->input->post('designation_id');
                        $otherwork_emp_id=$this->input->post('other_work_id');
                        $other_work_ids=implode(',',$otherwork_emp_id);
                        insertData(array('emp_id'=>$res,'designation_id' =>$emp_desig_id, 'section_otherwork_id' =>$other_work_ids),EMPLOYEE_ALLOTED_OTHER_WORK);  
                    }
                    /*End*/
                }
            }
            if ($id) {
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('update_success_message') . '</div>');
            } else {
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('success_message') . '</div>');
            }
            redirect('admin/employees');
        }
        $data['view_file'] = "admin_manage_user";
        $data['module_name'] = "admin_users";
        $this->template->index($data);
    }

    function check_unique_emp_id($str) {
        $emp_unique_id1 = $this->input->post('emp_unique_id');
        if ($this->uri->segment(3) != '') {
            $cnt = 1;
            $isusers = get_list(EMPLOYEES, NULL, array('emp_unique_id' => $emp_unique_id1, 'emp_id !=' => $this->uri->segment(3)));
        } else {
            $cnt = 0;
            $isusers = get_list(EMPLOYEES, NULL, array('emp_unique_id' => $emp_unique_id1));
        }
        if ($cnt < count($isusers)) {
            $this->form_validation->set_message('check_unique_emp_id', '<b>' . $emp_unique_id1 . '</b> ' . $this->lang->line('emp_unique_id_allready_exit_message'));
            return false;
        }
    }

    function check_unique_emp_loginid($str) {
        $emp_unique_loginid1 = $this->input->post('emp_login_id');
        if ($this->uri->segment(3) != '') {
            $cnt = 1;
            $is_users = get_list(EMPLOYEES, NULL, array('emp_login_id' => $emp_unique_loginid1, 'emp_id !=' => $this->uri->segment(3)));
        } else {
            $cnt = 0;
            $is_users = get_list(EMPLOYEES, NULL, array('emp_login_id' => $emp_unique_loginid1));
        }
        if ($cnt < count($is_users)) {
            $this->form_validation->set_message('check_unique_emp_loginid', '<b>' . $emp_unique_loginid1 . '</b> ' . $this->lang->line('emp_unique_loginid_allready_exit_message'));
            return false;
        }
    }
    
    function check_unique_emp_email($str) {
        $emp_unique_loginid3 = $this->input->post('emp_email');
        if ($this->uri->segment(3) != '') {
            $cnt = 1;
            $is_users = get_list(EMPLOYEES, NULL, array('emp_email' => $emp_unique_loginid3, 'emp_id !=' => $this->uri->segment(3)));
        } else {
            $cnt = 0;
            $is_users = get_list(EMPLOYEES, NULL, array('emp_email' => $emp_unique_loginid3));
        }
        if ($cnt < count($is_users)) {
            $this->form_validation->set_message('check_unique_emp_email', '<b>' . $emp_unique_loginid3 . '</b> ' . $this->lang->line('emp_unique_email_allready_exit_message'));
            return false;
        }
    }

    function alpha_dash_space($str) {
        //return (! preg_match("/^([-a-z_ ])+$/i", $str)) ? FALSE : TRUE;
        if (!preg_match("/^([-a-z._])+$/i", $str)) {
            $this->form_validation->set_message('alpha_dash_space', $this->lang->line('text_allow_with_space_error'));
            return false;
        }
    }

    public function delete_section($id) {
        if (isset($id) && $id != '') {
            $res = delete_data(SECTIONS, array('emp_id' => $id));
            if ($res) {
                $this->session->set_flashdata('message', '<div class="alert alert-success alert-dismissable hideauto"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><i class="icon fa fa-check"></i>' . $this->lang->line('delete_success_message') . '</div>');
            }
            redirect('admin/sections');
        }
    }

    public function show_404() {
        $this->load->view('404');
    }

    public function get_supervisore_emp() {
        $roleid = $this->input->post('rold_id');
        $data = get_supervisor_list($roleid);
        //pre($data);
        echo json_encode($data);
        exit();
    }

}
