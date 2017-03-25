<?php

if (!defined('BASEPATH'))
    exit('No direct script access allowed');


function no_cache() {
    header('Cache-Control: no-store, no-cache, must-revalidate');
    header('Cache-Control: post-check=0, pre-check=0', false);
    header('Pragma: no-cache');
}

/**
 * @ Function Name      : pr
 * @ Function Params    : $data {mixed}, $kill {boolean}
 * @ Function Purpose   : formatted display of value of varaible
 * @ Function Returns   : foramtted string
 */
function pr($data, $kill = true) {
    $str = "";
    if ($data != '') {
        $str .= str_repeat("=", 25) . " " . ucfirst(gettype($data)) . " " . str_repeat("=", 25);
        $str .= "<pre>";
        if (is_array($data)) {
            $str .= print_r($data, true);
        }
        if (is_object($data)) {
            $str .= print_r($data, true);
        }
        if (is_string($data)) {
            $str .= print_r($data, true);
        }
        $str .= "</pre>";
    } else {
        $str .= str_repeat("=", 22) . " Empty Data " . str_repeat("=", 22);
    }

    if ($kill) {
        die($str .= str_repeat("=", 55));
    }
    echo $str;
}

/**
 * @ Function Name      : pre
 * @ Function Params    : $data {mixed}, $kill {boolean}
 * @ Function Purpose   : formatted display of value of varaible
 * @ Function Returns   : foramtted string
 */
function pre($data, $kill = true) {
    $str = "";
    if ($data != '') {
        $str .= str_repeat("=", 25) . " " . ucfirst(gettype($data)) . " " . str_repeat("=", 25);
        $str .= "<pre>";
        if (is_array($data)) {
            $str .= print_r($data, true);
        }
        if (is_object($data)) {
            $str .= print_r($data, true);
        }
        if (is_string($data)) {
            $str .= print_r($data, true);
        }
        $str .= "</pre>";
    } else {
        $str .= str_repeat("=", 22) . " Empty Data " . str_repeat("=", 22);
    }

    if ($kill) {
        echo $str .= str_repeat("=", 55);
    } else {
        echo $str;
    }
}

/**
 *
 * @param type $filename
 * @return type 
 */
if (!function_exists('current_file_name')) {

    function current_file_name($filename = '') {
        return basename(str_replace('\\', '/', $filename), ".php");

        // $ext = pathinfo($filename, PATHINFO_EXTENSION);
        // $path = preg_replace('/\.' . preg_quote($ext, '/') . '$/', '', $filename);
        // $array = explode('\\', $path);
        // $len = count($array) - 1;
        // return $array[$len];
    }

}

/**
 *
 * @param type $filename
 * @return type 
 */
if (!function_exists('current_file_dir')) {

    function current_file_dir($filename = '') {
        return basename(dirname(str_replace('\\', '/', $filename))) . '/';

        // $ext = pathinfo($filename, PATHINFO_EXTENSION);
        // $path = preg_replace('/\.' . preg_quote($ext, '/') . '$/', '', $filename);
        // $array = explode('\\', $path);
        // $len = count($array) - 2;
        // if ($array[$len] != 'view') {
        // return $array[$len] . '/';
        // }
        // return;
    }

}

if (!function_exists('objectToArray')) {

    function objectToArray($obj) {
        print_r($obj);
        echo is_object($obj);
        if (is_object($obj)) {
            // Gets the properties of the given object
            // with get_object_vars function
            $obj = get_object_vars($obj);
        }
    }

}

function all_month() {
    return $all_month = array('01' => 'Jan', '02' => 'Feb', '03' => 'Mar', '04' => 'Apr', '05' => 'May', '06' => 'Jun', '07' => 'Jul', '08' => 'Aug', '09' => 'Sep', '10' => 'Oct', '11' => 'Nov', '12' => 'Dec');
}

function is_date($str) {
    try {
        $dt = new DateTime(trim($str));
    } catch (Exception $e) {
        return false;
    }
    $month = $dt->format('m');
    $day = $dt->format('d');
    $year = $dt->format('Y');
    if (checkdate($month, $day, $year)) {
        return true;
    } else {
        return false;
    }
}

function str_rand($length = 8, $seeds = 'alphanum') {
    // Possible seeds
    $seedings['alpha'] = 'abcdefghijklmnopqrstuvwqyz';
    $seedings['numeric'] = '0123456789';
    $seedings['alphanum'] = 'abcdefghijklmnopqrstuvwqyz0123456789';
    $seedings['hexidec'] = '0123456789abcdef';

    // Choose seed
    if (isset($seedings[$seeds])) {
        $seeds = $seedings[$seeds];
    }

    // Seed generator
    list($usec, $sec) = explode(' ', microtime());
    $seed = (float) $sec + ((float) $usec * 100000);
    mt_srand($seed);

    // Generate
    $str = '';
    $seeds_count = strlen($seeds);

    for ($i = 0; $length > $i; $i++) {
        $str .= $seeds{mt_rand(0, $seeds_count - 1)};
    }

    return strtoupper($str);
}

/**
 * Method to authorise exess
 */
function authorize() {
    $ci = & get_instance();
    //pre($ci->session->all_userdata());
    $id = $ci->session->userdata("emp_id");
    if ($id == "") {
        $ci->session->set_flashdata("inner_message", "<div class='alert alert-info'>Please login first to access internal pages.</div>");
        redirect("/");
    }
}

function isAdminAuthorize() {
    $ci = & get_instance();
    $id = $ci->session->userdata("admin_logged_in");
    if ($id == "") {
        $ci->session->set_flashdata("message", '<div class="alert alert-danger alert-dismissable"><button aria-hidden="true" data-dismiss="alert" class="close" type="button">×</button><strong>' . $ci->lang->line('input_warning_label') . '</strong><br><p>' . $ci->lang->line('without_login_message') . '</p></div>');
        redirect("/");
    }
}

function checkusremail($str, $role) {
    $ci = & get_instance();
    $result = $ci->db->get_where(EMPLOYEES, array('emp_email' => $str, 'emp_status' => 1, 'role_id' => $role));
    return $result->row_array();
}

function check_userlogin_password($loginname, $pwd, $role) {
    $ci = & get_instance();
    $result = $ci->db->get_where(EMPLOYEES, array('emp_login_id' => $loginname, 'emp_password' => md5($pwd), 'emp_status' => 1, 'role_id' => $role));
    $rows = $result->row_array();
    return $rows;
}

/* Update all user Password */

function update_user_password($userid) {
    $ci = & get_instance();
    $result = $ci->db->get_where(EMPLOYEES, array('emp_login_id' => $loginname, 'emp_password' => md5($pwd), 'emp_status' => 1, 'role_id' => $role));
    $rows = $result->row_array();
    return $rows;
}

//update the any data with common function    
function updateData($table_name, $table_data, $condition) {
    $CI = & get_instance();
    $CI->db->where($condition);
    $check = $CI->db->update($table_name, $table_data);
    return $check;
}

function insertData($tableData, $tableName) {
    $CI = & get_instance();
    $row = $CI->db->insert($tableName, $tableData);
    return $row;
}

function insertData_with_lastid($tableData, $tableName) {
    $CI = & get_instance();
    $row = $CI->db->insert($tableName, $tableData);
    return $CI->db->insert_id();
}

/**
 * @ Function Name      : get_list
 * @ Function Params    : $data {mixed}, $kill {boolean}
 * @ Function Purpose   : formatted display of value of varaible
 * @ Function Returns   : foramtted string
 */
function get_list($table_name, $orderby, $condition, $order_by = 'DESC') {
    $CI = & get_instance();
    if (!empty($condition)) {
        $CI->db->where($condition);
    }
    if (!empty($orderby)) {
        $CI->db->order_by($orderby, $order_by);
    }
    $CI->db->from($table_name);
    $query = $CI->db->get();
    $data = $query->result_array();
    return $data;
}

function delete_data($table_name, $condition) {
    $CI = &get_instance();
    $CI->db->where($condition);
    $res = $CI->db->delete($table_name);
    return $res;
}

function get_total_numbers_of($task, $id, $others) {
    $CI = &get_instance();
    if ($task == 'employee' && $id == '') {
        $employees_list_array = get_list(EMPLOYEES, null, array('emp_is_retired' => 0, 'emp_status' => 1));
        if ($others == 'counter') {
            return count($employees_list_array);
        } else {
            return $employees_list_array;
        }
    } else if ($task == 'files' && $id == '') {
        $file_list_array = get_list(FILES, null, null);
        if ($others == 'counter') {
            return count($file_list_array);
        } else {
            return $file_list_array;
        }
    }
}

function gender_array() {
    return array('m' => 'पुरुष', 'f' => 'महिला');
}

function yesno_array() {
     return $array = array('1' => 'हाँ', '0' => 'नहीं');
}

function marital_status_array() {
    return $array = array('1' => 'अविवाहित', '2' => 'विवाहित');
}

/* End */

/* End */

// upload image 
function uploadFile() {
    $CI = & get_instance();
    $config = array(
        'upload_path' => './uploads/employee/',
        'allowed_types' => 'gif|jpg|png',
        // 'max_size'      => '100',
        //'max_width'     => '1024',
        //'max_height'    => '768',
        'encrypt_name' => true,
    );

    $CI->load->library('upload', $config);

    if (!$CI->upload->do_upload()) {
        $error = array('error' => $CI->upload->display_errors());
        // $this->load->view('upload_form', $error);
    } else {
        $upload_data = $CI->upload->data();
        $data_ary = array(
            'title' => $upload_data['client_name'],
            'file' => $upload_data['file_name'],
            'width' => $upload_data['image_width'],
            'height' => $upload_data['image_height'],
            'type' => $upload_data['image_type'],
            'size' => $upload_data['file_size'],
            'date' => time(),
        );
        return $upload_data['file_name'];
    }
}

function checkUserrole($emp_id = null) {
	 $CI = & get_instance();
	 if(!empty($emp_id)){
		$CI->db->where(EMPLOYEES.'.emp_id', $emp_id);
		$CI->db->join(EMPLOYEES, EMPLOYEES . ".role_id = " . EMPLOYEEE_ROLE . ".role_id");
		$CI->db->from(EMPLOYEEE_ROLE);
		$query =  $CI->db->get();
		$row = $query->row();
		return $row->role_id;
	}else{
    	return $CI->session->userdata('user_role');
	}
}

function getEmployeeSection() {
    $CI = & get_instance();
    $CI->db->where('emp_id', emp_session_id());
    $query = $CI->db->get(EMPLOYEES);
    $row = $query->row();
    return isset($row->emp_section_id) ? $row->emp_section_id : '';
}

function getNoticeBoardInformation($setion_id = '') {
    $CI = & get_instance();
    $notice_board = NOTICE_BOARD;
	$role = checkUserrole();
    //$CI->db->select('notice_id,notice_subject,notice_description,notice_attachment,   notice_remark,notice_created_date,notice_from_date,notice_to_date,notice_is_active');
   // if ($role != 1) {
   //     $CI->db->where('emp_id', emp_session_id());
   //     $CI->db->or_where('notice_section_id', $setion_id);
   // }
   // $CI->db->from($notice_board);
   // $query = $CI->db->get();
   // $rows = $query->result();
    //$CI->db->last_query();
   // return $rows;
}

function getState($state_id) {
    $CI = & get_instance();
    $CI->db->select('state_name');
    $CI->db->from(STATES);
	$CI->db->order_by("state_name", "ASC");
    $query = $CI->db->get();
    $row = $query->row();
    return $row->state_name;
}

function getCity($city_id) {
    $CI = & get_instance();
    $CI->db->select('city_name');
    $CI->db->from(CITY);
	$CI->db->order_by("city_name", "ASC");
    $query = $CI->db->get();
    $row = $query->row();
    return $row->city_name;
}

function checkEmployeeRetired($value) {
    if ($value == 0) {
        return "NO";
    } else {
        return "YES";
    }
}

function getSection($sectionid) {
    $CI = & get_instance();
    $CI->db->select('section_name_hi,section_name_en');
    $CI->db->where('section_id', $sectionid);
    $CI->db->from(SECTIONS);
    $query = $CI->db->get();
    $row = $query->row();
    return $row->section_name_hi." (".$row->section_name_en.")";

}

function getSectionData($sectionid) {	
    $CI = & get_instance();
    $CI->db->select('section_name_hi,section_name_en');
	if(is_array($sectionid)){
		$CI->db->where_in('section_id', $sectionid);
	} else {		
		$CI->db->where('section_id', $sectionid);
	}
    $CI->db->from(SECTIONS);
    $query = $CI->db->get();
    $row = $query->result();
   // return $row->section_name_hi." (".$row->section_name_en.")";
    return $row;

}
/**
 * @ Function Name      : getemployeeName
 * @ Function Params    : $emp_id {int}, $ishindi {boolean}
 * @ Function Purpose   : Get employee name and join with gender
 * @ Function Returns   : foramtted string
 */
function getemployeeName($emp_id, $ishindi = false) {
    $CI = & get_instance();
	$tbl1 = EMPLOYEES;
    $CI->db->select('emp_full_name, emp_full_name_hi,emp_title_hi,emp_title_en');
    $CI->db->from($tbl1);
    $CI->db->where($tbl1.'.emp_id', $emp_id);
    $query = $CI->db->get();
    $row = $query->row();
		if($ishindi == true){
			$title_hi = $row->emp_title_hi;	
		}else {
			$title = $row->emp_title_en;	
		}				
	
	if($ishindi == true){
		return $title_hi.' '.$row->emp_full_name_hi;
	} else {
		return $title.' '.$row->emp_full_name;
	}    
}

function get_employee_gender($emp_id, $ishindi = true, $isquery = true) {   
		if($isquery == true){
			$CI = & get_instance();
			$CI->db->select('emp_detail_gender');
			$CI->db->where('emp_id',$emp_id );
			$CI->db->from(EMPLOYEE_DETAILS);
			$query = $CI->db->get();
			$row = $query->row();   
			// echo $CI->db->last_query();
			$gender =  $row->emp_detail_gender;
		} else {
			$gender = $emp_id;
		}
		if($gender == 'm'){
			if($ishindi == true){
				return 'श्री';	
			}else {
				return 'Sh.';

			}
		}
		if($gender == 'f'){
			if($ishindi == true){
				return 'सुश्री';
			}else {
				return 'Sushri';
			}

		} else {
			return '';
		}
    
}

function getDepartmentName($department_id) {
    $CI = & get_instance();
    $CI->db->select('dept_name_hi,dept_name_en');
    $CI->db->from(DEPARTMENTS);
    $CI->db->where('dept_id', $department_id);
	$CI->db->order_by("dept_name_hi", "ASC");
    $query = $CI->db->get();
    $row = $query->row();
    return $row->dept_name_en;
}

// upload image
function uploadalltypeFile($filename, $path) {
    $CI = & get_instance();
    $config = array(
        'upload_path' => $path,
        'allowed_types' => 'gif|jpg|png|pdf',
        // 'max_size'      => '100',
        //'max_width'     => '1024',
        //'max_height'    => '768',
        'encrypt_name' => true,
    );

    $CI->load->library('upload', $config);

    if (!$CI->upload->do_upload($filename)) {
        $error = array('error' => $CI->upload->display_errors());
        // $this->load->view('upload_form', $error);
    } else {
        $upload_data = $CI->upload->data();
        $data_ary = array(
            'title' => $upload_data['client_name'],
            'file' => $filename,
            'width' => $upload_data['image_width'],
            'height' => $upload_data['image_height'],
            'type' => $upload_data['image_type'],
            'size' => $upload_data['file_size'],
            'date' => time(),
        );
        return $upload_data['file_name'];
    }
}

function get_department_post_master($roleid) {
    $CI = & get_instance();
    $CI->db->from(EMPLOYEE_MASTER_NUMBER_POST);
    if ($roleid == '') {
        $query = $CI->db->get();
        return $row = $query->result_array();
    } else {
        $CI->db->where('role_id', $roleid);
        $query = $CI->db->get();
        $row = $query->row_array();
        if (!empty($row) && $row != '') {
            return @$row['endm_designation_numbers'];
        } else {
            return null;
        }
    }
}

function get_added_designation_of_emp($byroldid, $task = "") {
    $CI = & get_instance();
    $CI->db->from(EMPLOYEES);
    $CI->db->where('role_id', $byroldid);
    $query = $CI->db->get();
    $rows = $query->result_array();
    return count($rows);
}

function get_employe_role_designatio($byroldid = '', $task = "") {
    $nerArray = '';
    $added_emp = 0;
    $CI = & get_instance();
    $CI->db->from(EMPLOYEEE_ROLE);
    $query = $CI->db->get();
    $emp_roles_array = $query->result_array();
    //pr($emp_roles_array);
    foreach ($emp_roles_array as $rolkey => $roles) {
        $added_emp = get_added_designation_of_emp($roles['role_id'], "");
        //echo '<br/>rolid:'.$roles['role_id'].'<br/>';
        $endm_designation_numbers = get_department_post_master($roles['role_id'], "");
        //echo $added_emp.'=='.$endm_designation_numbers.'<br/>';
        if (isset($endm_designation_numbers) && $endm_designation_numbers != '') {
            if ($added_emp == $endm_designation_numbers) {
                $emp_roles_array[$rolkey] = '';
            }
        }
    }
    return $emp_roles_array;
}

/* Code added by Bij */
/* Show all alloted section according to employee and table wise. */

function get_alloted_sections_list($empid, $task) {
    $CI = & get_instance();
    $CI->db->select('emp_section_id');
    //echo $empid;
    $CI->db->where('emp_id', $empid);
    if ($task == 'EMPLOYEE_ALLOTED_SECTION_TBL') {
        $CI->db->from(EMPLOYEE_ALLOTED_SECTION);
        $query = $CI->db->get();
        return $rows = $query->result_array();
    } else {
        $CI->db->from(EMPLOYEES);
        $query = $CI->db->get();
        return $rows = $query->row_array();
    }
}

function get_supervisor_list($id, $task = '') {
    $ci = & get_instance();
    if ($task == '' && $id != '') {
        $role_level_aray = $ci->db->query("SELECT emprole_level,role_id FROM ft_" . EMPLOYEEE_ROLE . " where role_id=" . $id)->row_array();
        // $ci->db->last_query();
        //pr($role_level_aray);
        $emp_level_id = $role_level_aray['emprole_level'];
        $supervisor_role_id = ($role_level_aray['role_id']);
        /* Get limit value */
        if ($supervisor_role_id == 11 || $supervisor_role_id == 14 || $supervisor_role_id == 15 || $supervisor_role_id == 8)  { /* Sr. Accountan officer */
            $designation_limit = 50;
            $emp_level_id = 11;
            $where_or = ' and emprolmast.emprole_level !=6';
        } else if ($supervisor_role_id == 9 || $supervisor_role_id == 22 || $supervisor_role_id == 23 || $supervisor_role_id == 24 || $supervisor_role_id == 17 || $supervisor_role_id == 19 || $supervisor_role_id == 20) { /* Grad-I,II,III,Data Entry oprator and CR */
            $emp_level_id = 6;
            $designation_limit = 20;
            $where_or = '';
        } else if($supervisor_role_id == 21 ||$supervisor_role_id == 32 ){ /* For library  */
            $emp_level_id = 11;
            $designation_limit = 3;
            $where_or = '';
        } else if($supervisor_role_id == 12 ){ /* For staff officer  */
            $emp_level_id = 1;
            $designation_limit = 1;
            $where_or = '';
        } else if($supervisor_role_id == 13 || $supervisor_role_id == 25  || $supervisor_role_id == 18 || $supervisor_role_id == 37){ /* For  personal assistant and personal secretary, ACC  */
            $emp_level_id = 8;
            $designation_limit = 30;
            $where_or = '';
         } else if($supervisor_role_id == 28 ||$supervisor_role_id == 29 ||$supervisor_role_id == 30 ||$supervisor_role_id == 35 ||$supervisor_role_id == 36  ||$supervisor_role_id == 34 ){ /* For poen, daftari , driver, class IV  */
            $emp_level_id = 12;
            $designation_limit = 100;
            $where_or = '';
        } else {
            $sql_qry = "SELECT * FROM ft_" . EMPLOYEES . " where role_id = $supervisor_role_id";
            $designation_limit_aray = $ci->db->query($sql_qry)->result_array();
            $designation_limit = count($designation_limit_aray);
            $where_or = '';
        }
        if ($supervisor_role_id == 9 || $supervisor_role_id == 22 || $supervisor_role_id == 23 || $supervisor_role_id == 24 || $supervisor_role_id == 17 || $supervisor_role_id == 19 ||  $supervisor_role_id == 20) { //*Grad-I,II,III,Data Entry oprator and CR*/
            $sql = "SELECT emprolmast.emprole_name_hi, emprole_name_en,emp.emp_id, emp.role_id,emp.emp_full_name, emp.emp_email, emp.emp_section_id FROM `ft_emprole_master` as emprolmast inner join ft_employee as emp on emp.role_id=emprolmast.role_id $where_or where emprolmast.emprole_level !=0 and emprolmast.emprole_level<=$emp_level_id order by emprolmast.role_id desc LIMIT 0,$designation_limit";
        } else if($supervisor_role_id == 21 ||$supervisor_role_id == 32){
            $sql = "SELECT emprolmast.emprole_name_hi, emprole_name_en,emp.emp_id, emp.role_id,emp.emp_full_name, emp.emp_email, emp.emp_section_id FROM `ft_emprole_master` as emprolmast inner join ft_employee as emp on emp.role_id=emprolmast.role_id $where_or where emprolmast.emprole_level !=0 and emprolmast.emprole_level=$emp_level_id order by emprolmast.role_id desc LIMIT 0,$designation_limit";
        } else if($supervisor_role_id == 12){
            $sql = "SELECT emprolmast.emprole_name_hi, emprole_name_en,emp.emp_id, emp.role_id,emp.emp_full_name, emp.emp_email, emp.emp_section_id FROM `ft_emprole_master` as emprolmast inner join ft_employee as emp on emp.role_id=emprolmast.role_id $where_or where emprolmast.emprole_level !=0 and emprolmast.emprole_level='1' order by emprolmast.role_id desc LIMIT 0,$designation_limit";
        } else {
           $sql = "SELECT emprolmast.emprole_name_hi, emprole_name_en,emp.emp_id, emp.role_id,emp.emp_full_name, emp.emp_email, emp.emp_section_id FROM `ft_emprole_master` as emprolmast inner join ft_employee as emp on emp.role_id=emprolmast.role_id $where_or where emprolmast.emprole_level !=0 and emprolmast.emprole_level<$emp_level_id order by emprolmast.role_id desc LIMIT 0,$designation_limit";
        }
        return $ci->db->query($sql)->result_array();
    } else if ($task == 'get_supervisor_detail' && $id != '') {
        $role_level_aray = $ci->db->query("SELECT emprole_level,role_id FROM ft_" . EMPLOYEEE_ROLE . " where role_id=" . $id)->row_array();
        $emp_level_id = $role_level_aray['emprole_level'];
        $supervisor_role_id = ($role_level_aray['role_id']);
        /* Get limit value */
        if ($supervisor_role_id == 11 || $supervisor_role_id == 14 || $supervisor_role_id == 15 || $supervisor_role_id == 8) { /* Sr. Accountan officer */
            $designation_limit = 50;
            $emp_level_id = 11;
            $where_or = ' and emprolmast.emprole_level';
        } else if ($supervisor_role_id == 9 || $supervisor_role_id == 22 || $supervisor_role_id == 23 || $supervisor_role_id == 24 || $supervisor_role_id == 17 || $supervisor_role_id == 19  || $supervisor_role_id == 20) { /* Grad-I,II,III,Data Entry oprator and CR */
            $emp_level_id = 6;
            $designation_limit = 20;
            $where_or = '';
            //$where_or= ' and emprolmast.emprole_level <6';
        } else if($supervisor_role_id == 21 ||$supervisor_role_id == 32 ){ /* For library  */
            $emp_level_id = 11;
            $designation_limit = 3;
            $where_or = '';
        } else if($supervisor_role_id == 28 ||$supervisor_role_id == 29 ||$supervisor_role_id == 30 ||$supervisor_role_id == 35 ||$supervisor_role_id == 36 ||$supervisor_role_id == 34 ){ /* For poen, daftari , class IV  */
            $emp_level_id = 12;
            $designation_limit = 100;
            $where_or = '';
        } else if($supervisor_role_id == 12 ){ /* For staff officer  */
            $emp_level_id = 1;
            $designation_limit = 1;
            $where_or = '';
        } else if($supervisor_role_id == 13 || $supervisor_role_id == 25 || $supervisor_role_id == 18 || $supervisor_role_id == 37 ){ /* For  personal assistant and persnal secretary , ACC */
            $emp_level_id = 8;
            $designation_limit = 30;
            $where_or = '';
        } else if($supervisor_role_id == 10){ /* dfdsf, ACC */
			$emp_level_id = 8;
            $designation_limit = 30;
            $where_or = '';
        } else {
            $sql_qry = "SELECT * FROM ft_" . EMPLOYEES . " where role_id=$supervisor_role_id";
            $designation_limit_aray = $ci->db->query($sql_qry)->result_array();
            $designation_limit = count($designation_limit_aray);
            $where_or = '';
        }
        if ($supervisor_role_id == 9 || $supervisor_role_id == 22 || $supervisor_role_id == 23 || $supervisor_role_id == 24 || $supervisor_role_id == 17 || $supervisor_role_id == 19 ||  $supervisor_role_id == 20) { /* Grad-I,II,III,Data Entry oprator and CR */
            $sql_12 = "SELECT emprolmast.emprole_name_hi, emprole_name_en,emp.emp_id, emp.role_id,emp.emp_full_name, emp.emp_email, emp.emp_section_id FROM `ft_emprole_master` as emprolmast inner join ft_employee as emp on emp.role_id=emprolmast.role_id $where_or where emprolmast.emprole_level !=0 and emprolmast.emprole_level<=$emp_level_id order by emprolmast.role_id desc LIMIT 0,$designation_limit";
        } else if($supervisor_role_id == 21 ||$supervisor_role_id == 32){
            $sql_12 = "SELECT emprolmast.emprole_name_hi, emprole_name_en,emp.emp_id, emp.role_id,emp.emp_full_name, emp.emp_email, emp.emp_section_id FROM `ft_emprole_master` as emprolmast inner join ft_employee as emp on emp.role_id=emprolmast.role_id $where_or where emprolmast.emprole_level !=0 and emprolmast.emprole_level=$emp_level_id order by emprolmast.role_id desc LIMIT 0,$designation_limit";
         } else if($supervisor_role_id == 12){
            $sql_12 = "SELECT emprolmast.emprole_name_hi, emprole_name_en,emp.emp_id, emp.role_id,emp.emp_full_name, emp.emp_email, emp.emp_section_id FROM `ft_emprole_master` as emprolmast inner join ft_employee as emp on emp.role_id=emprolmast.role_id $where_or where emprolmast.emprole_level !=0 and emprolmast.emprole_level='1' order by emprolmast.role_id desc LIMIT 0,$designation_limit";
        } else if($supervisor_role_id == 10){
            $sql_12 = "SELECT emprolmast.emprole_name_hi, emprole_name_en,emp.emp_id, emp.role_id,emp.emp_full_name, emp.emp_email, emp.emp_section_id FROM `ft_emprole_master` as emprolmast inner join ft_employee as emp on emp.role_id=emprolmast.role_id $where_or where emprolmast.emprole_level !=0 and emprolmast.emprole_level='20' order by emprolmast.role_id desc LIMIT 0,$designation_limit";
        } else {
            $sql_12 = "SELECT emprolmast.emprole_name_hi, emprole_name_en,emp.emp_id, emp.role_id,emp.emp_full_name, emp.emp_email, emp.emp_section_id FROM `ft_emprole_master` as emprolmast inner join ft_employee as emp on emp.role_id=emprolmast.role_id $where_or where emprolmast.emprole_level !=0 and emprolmast.emprole_level<$emp_level_id order by emprolmast.role_id desc LIMIT 0,$designation_limit";
        }
        return $ci->db->query($sql_12)->result_array();
    } else if ($task == 'get_supervisor_detail_byId' && $id != '') {
        $sql50 = "SELECT emp_id as supervisorId from ft_employee_hirarchi where under_emp_id=$id";
        $res_array = $ci->db->query($sql50)->result_array();
        foreach ($res_array as $skey => $sval) {
            $supervisor_array[] = $sval['supervisorId'];
        }
        return $supervisor_array;
    }
}

function manage_employee_leave($table_data_leave, $empid_condition, $task) {
    $ci = & get_instance();
    if ($empid_condition == '' && $task == 'add_leave') {
        insertData($table_data_leave, EMPLOYEE_LEAVE);
    } else if ($task == 'update_leave') {
        updateData(EMPLOYEE_LEAVE, $table_data_leave, $empid_condition);
    } else if ($task == 'emp_leave_detail') {
        $emp_leave_detail = get_list(EMPLOYEE_LEAVE, NULL, $empid_condition);
        if (count($emp_leave_detail) > 0) {
            return $emp_leave_detail[0];
        } else {
            return null;
        }
    }
}

function getuserbyrole($sectionid, $roleid) {
    $CI = & get_instance();
    if(isset($sectionid) && isset($roleid)) {
        $where = "FIND_IN_SET('" . $sectionid . "', emp_section_id)";
        $CI->db->where($where);
    $CI->db->where('role_id', $roleid);
    $CI->db->from(EMPLOYEES);
	$CI->db->order_by("designation_id", "ASC");
    $CI->db->order_by("emp_full_name_hi", "ASC");
    $query = $CI->db->get();
    $data = $query->result_array();
    return $data;
    }
}

function getusersection($userid) {
    $CI = & get_instance();
    $CI->db->select('emp_section_id');
    $CI->db->where('emp_id', $userid);
    $CI->db->from(EMPLOYEES);
    $query = $CI->db->get();
    $row = $query->row();
    return $row->emp_section_id;
}


/* Coded added bij 29/07/2015 */

function get_designation_level($empid = null, $roleid = null) {
    /* key refer by employee_role_master table */
    /* 60 means all of Asst. Grade I,II,III,Dataentry opratore etc. */
    /* 50 means */
    $employee_detail = get_list(EMPLOYEES, null, array('emp_id' => $empid));
    $designation_level = array('3' => '1', '4' => '2', '5' => '3', '6' => '4', '7' => '5', '11' => '5', '8' => '6', '14' => '6', '12' => '6', '33' => '6');
    if (array_key_exists($employee_detail[0]['role_id'], $designation_level)) {
        return $designation_level[$employee_detail[0]['role_id']];
    } else {
        return 60;
    }
}

function employee_grad_pay() {
    return array('y' => 'हाँ', 'n' => 'नहीं', 'rule' => 'सरकारी रूल्स के आधार पर');
}

/* RP */

function empdetails($emp_id) {
    $CI = & get_instance();
    $CI->db->select('*');
    $CI->db->where('emp_id', $emp_id);
    $CI->db->from(EMPLOYEES);
    $query = $CI->db->get();
    $data = $query->result_array();
    return $data;
}

function getunitid($roleid) {
    $CI = & get_instance();
    $CI->db->where('role_id', $roleid);
    $CI->db->from(UNIT_LEVEL);
    $query = $CI->db->get();
    $row = $query->row();
    return $row->unit_id;
}

function getemployeeRole($role_id) {
    $CI = & get_instance();
    $CI->db->where('role_id', $role_id);
    $query = $CI->db->get(EMPLOYEEE_ROLE);
    $row = $query->row();
    return $row->emprole_name_hi;
}

function get_employee_role($emp_id) {
    $CI = & get_instance();
    $CI->db->where(EMPLOYEES.'.emp_id', $emp_id);
    $CI->db->join(EMPLOYEES, EMPLOYEES . ".role_id = " . EMPLOYEEE_ROLE . ".role_id");
    $CI->db->from(EMPLOYEEE_ROLE);
    $query =  $CI->db->get();
    $row = $query->row();
    return $row->emprole_name_hi;
}


function get_user_details($id = '', $column_name = '*') {
    $CI = & get_instance();
    $tbl_emp = EMPLOYEES;
    $tbl_emp_detail = EMPLOYEE_DETAILS;
    $tbl_emp_role = EMPLOYEEE_ROLE;
    $CI->db->select($column_name);
    $CI->db->from($tbl_emp);
    $CI->db->join($tbl_emp_detail, "$tbl_emp.emp_id = $tbl_emp_detail.emp_id");
    $CI->db->join($tbl_emp_role, "$tbl_emp.designation_id = $tbl_emp_role.role_id");
    $emp_id = $id == '' ? emp_session_id() : $id;
    $CI->db->where("$tbl_emp.emp_id", $emp_id);
    $query = $CI->db->get();
    if ($query->num_rows() == 1) {
        //print_r($query->result());die;
        return $query->result();
    } else {
        return FALSE;
    }
}
function get_data_from_where($table_name, $column, $where_key, $where_value) {
    $ci = & get_instance();
    $ci->db->select($column);
    $result = $ci->db->get_where($table_name, array($where_key => $where_value));
    $rows = $result->row_array();
    $ci->db->last_query();
    return $rows;
}

function get_date_formate($date, $formate = 'd.m.Y') {    $date = strtotime($date);
    return date($formate, $date);
}

function get_datetime_formate($date, $formate = 'd.m.Y h:i A') {
    $date = strtotime($date);
    return date($formate, $date);
}

/* Code added by bij 31072015 */

	function get_emp_sections($sectionids) {
		$ci = & get_instance();
		$sql_query = "SELECT group_concat(section_name_hi SEPARATOR ',<br/><br/>') as section_hi, group_concat(section_name_en) as section_en FROM `ft_sections_master` WHERE `section_id` IN ($sectionids)";
		$results = $ci->db->query($sql_query)->result_array();
		if (count($results) > 0) {
			return $results[0];
		} else {
			return null;
		}
	}

	function get_emp_other_work_alloted($empid) {
		$ci = & get_instance();
		if (isset($empid) && $empid != '') {
			$sql_query = "select section_otherwork_id from ft_" . EMPLOYEE_ALLOTED_OTHER_WORK . " where emp_id=$empid";
			$results = $ci->db->query($sql_query)->result_array();
			if (count($results) > 0) {
				return $other_worke_alloted_array = explode(',', $results[0]['section_otherwork_id']);
			} else {
				return null;
			}
		}
	}
/* end */

/*06/08/2015*/
	function get_secuirty_question(){
		return $sec_qt= array(
			'1'=>'आपकी पसंदीदा गाड़ी का नाम क्या है?',
			'2'=>'आपका उपनाम क्या है?',
			'3'=>'आपके पसंदीदा पालतू जानवर का नाम क्या है?',
			'4'=>'आपके पसंदीदा नाटक का नाम क्या है?',
			'5'=>'आपकी पसंदीदा फिल्म का नाम क्या है?',
			'6'=>'आपके पसंदीदा शहर का नाम क्या है?',
			'7'=>'आपकी पसंदीदा किताब का नाम क्या है?',
			'8'=>'आपका पसंदीदा खेल का नाम क्या है?',
			'9'=>'आपका पसंदीदा रंग कौनसा  है?',
			'10'=>'आप खाली समय में क्या करना पसंद करते है?',
		);
	}
	function viewDashboardRole($emp_role = '')
	{
		
		$role = array(1,2,3,4,5,6,7,8,9,10,17,22,24);
		if(in_array($emp_role , $role))
		{
			return TRUE;
		}
		else{
			return FALSE;
		}
	}
	function get_user_log($emp_id = ''){
		$CI = & get_instance();
		$CI->db->select('*');
		if(empty($emp_id)) { 
			$CI->db->where('emp_id', emp_session_id());
		} else {
			$CI->db->where('emp_id', $emp_id);  
		} 
		$query = $CI->db->get('employee_login_log');
		$result = $query->row_array();
		//$CI->db->last_query();
		return $result;
	}
	/*End*/
	
	function get_employees_brthdays($idToday = ''){
        $CI = & get_instance();	
		$today = date('Y-m-d');
        if($idToday == 'yes'){
            $where = "DATE_FORMAT(`emp_detail_dob`, '%m-%d') = DATE_FORMAT('$today', '%m-%d')";
        } else {
            $date = week_start_end_by_date($today);
            $last_day_of_week = $date['last_day_of_week'];
            $where = "DATE_FORMAT(`emp_detail_dob`, '%m-%d') >= DATE_FORMAT('$today', '%m-%d') and DATE_FORMAT(`emp_detail_dob`, '%m-%d') <= DATE_FORMAT('$last_day_of_week', '%m-%d')";
        }
		$query = "SELECT `ft_employee`.`emp_id`, `emp_full_name_hi`, `designation_id`, `emp_detail_dob`,emp_detail_gender,
		DATE_FORMAT(`emp_detail_dob`, '%d') as dob_date, DATE_FORMAT(`emp_detail_dob`, '%m') as dob_month
		FROM (`ft_employee_details`) 
		JOIN `ft_employee` ON `ft_employee`.`emp_id` = `ft_employee_details`.`emp_id` 
		JOIN `ft_emprole_master` ON `ft_emprole_master`.`role_id` = `ft_employee`.`designation_id`
		WHERE `emp_status` = '1' AND `emp_is_retired` = '0'  and `emp_posting_location` = '1'
		AND $where
		ORDER BY dob_month ASC, `dob_date` ASC, role_leave_level ASC, emp_full_name ASC";
		$query= $CI->db->query($query);
        return $query->result();	  
    }
	
    function get_employees_retirements($idToday = ''){
        $CI = & get_instance();
        $CI->db->select('*'); 
        $today = date('Y-m-d');
        $where = "DATE_FORMAT(`emp_detail_retirement_date`, '%y-%m') = DATE_FORMAT('$today', '%y-%m')";
        $CI->db->where($where);

        $CI->db->from(EMPLOYEE_DETAILS);
        $CI->db->join(EMPLOYEES, EMPLOYEES . '.emp_id = ' . EMPLOYEE_DETAILS . '.emp_id');
		$CI->db->join(EMPLOYEEE_ROLE, EMPLOYEEE_ROLE . '.role_id = ' . EMPLOYEES . '.designation_id');
        $CI->db->order_by("emp_detail_retirement_date", "ASC");
		$CI->db->order_by("role_leave_level", "ASC");
		$CI->db->order_by("emp_full_name", "ASC");   		
        $query = $CI->db->get();
       // echo $CI->db->last_query();
        return $rows = $query->result();
        
    }

    function week_start_end_by_date($date, $format = 'Y-m-d') {
        if (is_numeric($date) AND strlen($date) == 10) {
            $time = $date;
        }else{
            $time = strtotime($date);
        }
        
        $week['week'] = date('W', $time);
        $week['year'] = date('o', $time);
        $week['year_week']           = date('oW', $time);
        $first_day_of_week_timestamp = strtotime($week['year']."W".str_pad($week['week'],2,"0",STR_PAD_LEFT));
        $week['first_day_of_week']   = date($format, $first_day_of_week_timestamp);
        $week['first_day_of_week_timestamp'] = $first_day_of_week_timestamp;
        $last_day_of_week_timestamp = strtotime($week['first_day_of_week']. " +6 days");
        $week['last_day_of_week']   = date($format, $last_day_of_week_timestamp);
        $week['last_day_of_week_timestamp']  = $last_day_of_week_timestamp;
        
        return $week;
    }

    function get_emplyee_role_id($emp_id){
        $ci = & get_instance();
        $ci->db->select('role_id');
        $result = $ci->db->get_where(EMPLOYEES, array('emp_id'=>$emp_id ));
        $rows = $result->row_array();
        $ci->db->last_query();
        return $rows['role_id'];
    }

    function get_role_class($id){
        switch($id){
            case 3:
            return 'bg-success';
            break; 
            case 4:
            return 'bg-warning';
            break;
            case 5:
            return 'bg-info';
            break; 
            case 6:
            return 'bg-danger';
            break; 
            case 7:
            return 'bg-primary';
            break;  
            case 8:
            return 'bg-yellow';
            break; 
            case 14:
            return 'bg-yellow';
            break; 
            case 11:
            return 'bg-primary';
            break; 
            case 15:
            return 'bg-green';
            break; 
            case 25:
            return 'bg-aqua';
            break; 
            case 13:
            return 'bg-aqua';
            break; 
            default:
            return 'bg-default';
            break;          
        }
    }

    function get_weeks($ishindi = false){
        $weeks_en = array(
            1 => 'Sunday',
            2 => 'Monday',
            3 => 'Tuesday',
            4 => 'Wednesday',
            5 => 'Thursday',
            6 => 'Friday',
            7 => 'Saturday',
        );
        
        $weeks_hi = array(
            1 => 'रविवार',
            2 => 'सोमवार',
            3 => 'मंगलवार',
            4 => 'बुधवार',
            5 => 'गुरुवार',
            6 => 'शुक्रवार',
            7 => 'शनिवार',
        );
        
        if($ishindi){
            return $weeks_hi;
        } else {
           return $weeks_en; 
        }
    }
    function day_difference_dates($datetime1, $datetime2){
        $datetime1 = strtotime($datetime1);
        $datetime2 = strtotime($datetime2);
        $datediff = $datetime2 - $datetime1;
        $number = floor($datediff/(60*60*24));
        return $number;
    }
    
    function get_user_supervisor($emp_id = ''){
        $CI = & get_instance();
        $emp_id = $emp_id == '' ? $CI->session->userdata('emp_id') : $emp_id ;
        $hiraarchi_level = EMPLOYEE_HIARARCHI_LEVEL;
        $employee = EMPLOYEES;
        $CI->db->select($employee . '.emp_id,emp_unique_id,emp_full_name,emp_full_name_hi,role_id,emp_image');
        $CI->db->from($employee);
        $CI->db->join($hiraarchi_level, $employee . '.emp_id=' . $hiraarchi_level . '.emp_id');
        $CI->db->where('under_emp_id', $emp_id);
        $query = $CI->db->get();
        //echo $CI->db->last_query();
        return $rows = $query->result();
    }
    
    function get_leave_supervisor($emp_id = ''){
        $CI = & get_instance();
        $emp_id = $emp_id == '' ? $CI->session->userdata('emp_id') : $emp_id ;
        $leave_level_master = EMPLOYEE_LEAVE_LEVEL_MASTER;
        $employee = EMPLOYEES;
        $CI->db->select($employee . '.emp_id,emp_unique_id,emp_full_name,emp_full_name_hi,role_id,emp_image');
        $CI->db->from($employee);
        $CI->db->join($leave_level_master, $employee . '.emp_id=' . $leave_level_master . '.emp_id');
        $CI->db->where('forwarder_id', $emp_id);
        $query = $CI->db->get();
        //echo $CI->db->last_query();
        return $rows = $query->result();
    }
	
	function months($month = null, $hindi = false) {
		$months_en = array(
			1 => "January",
			2 => "February",
			3 => "March",
			4 => "April",
			5 => "May",
			6 => "June",
			7 => "July",
			8 => "August",
			9 => "September",
			10 => "October",
			11 => "November",
			12 => "December"
		);
		
		$months_hi = array(
			1 => "जनवरी",
			2 => "फ़रवरी",
			3 => "मार्च",
			4 => "अप्रैल",
			5 => "मई",
			6 => "जून",
			7 => "जुलाई",
			8 => "अगस्त",
			9 => "सितम्बर",
			10 => "अक्टूबर",
			11 => "नवम्बर",
			12 => "दिसम्बर"
		);
		if($hindi == false){
			if (array_key_exists($month, $months_en)) {
				return $months_en[$month];
			} else {
				return $months_en;
			}		
		} else{
			if (array_key_exists($month, $months_hi)) {
				return $months_hi[$month];
			} else {
				return $months_hi;
			}	
		}		
	}

	/*Code start 19 08 2015 Bijendra*/
		function get_emp_role($empid,$other=null){
			$emp_role = empdetails($empid);
			$officerList= get_list('ft_'.UNIT_LEVEL,null,array('role_id'=>$emp_role[0]['role_id']));
			return $officerList[0]['unit_id'];
		}
	/*End Code start 19 08 2015*/

function check_pa_is_any_permission($task='',$paempid=''){
		
		$CI = & get_instance();
		$permission_list_update=array();
		$supervisorId_list='';
		$supervisorId='';
		$logged_id_empid =  $CI->session->userdata('emp_id');
		/*Get PA Upper officer ID*/
		$supervisorId_list= get_list(EMPLOYEE_HIARARCHI_LEVEL,null,array('under_emp_id'=>$logged_id_empid));
		//pr($supervisorId_list);
		/*Get PA Permission List*/
		if(count($supervisorId_list)>0){
			$supervisorId = @$supervisorId_list[0]['emp_id'];
			$permission_list= get_list(EMPLOYEE_PERMISSION_ALLOTED,null,array('emp_id_assign_to'=>$logged_id_empid, 'emp_id_assign_by'=>$supervisorId));
			//pre($supervisorId_list);
			//pre($permission_list);
			foreach($permission_list as $ky=>$val){
				$permission_list_update[$val['epa_module_name']]['add']=$val['epa_add'];
				$permission_list_update[$val['epa_module_name']]['edit']=$val['epa_edit'];
				$permission_list_update[$val['epa_module_name']]['view']=$val['epa_view'];
				$permission_list_update[$val['epa_module_name']]['received']=$val['epa_recieved'];
			}
		}
		return $permission_list_update;
		//
	}
    

    function emp_session_id()
    {
        $CI = & get_instance();
		$role = checkUserrole();
		if(in_array($role,array(25,12))){ 
			$permission_array_list= check_pa_is_any_permission($task='',$paempid='');
			//pr($permission_array_list);
		}
		
        $rrt =  $CI->session->userdata('emp_id');
        return $rrt;
    }
	/*End 22/08/2015 GET officer PA List*/

	function get_section_employee($section_id, $role_id = ''){
        $CI = & get_instance();
        $employee = EMPLOYEES;
        $CI->db->select("$employee.emp_id, emp_full_name, emp_full_name_hi");
        $CI->db->from($employee);
		$CI->db->join(EMPLOYEEE_ROLE, EMPLOYEEE_ROLE . '.role_id = ' . $employee . '.designation_id');
        $CI->db->where("FIND_IN_SET($section_id,emp_section_id) !=", 0);
         if($role_id != ''){
            $CI->db->where($employee.'.role_id', $role_id);
        }
        $CI->db->where('emp_posting_location', 1);
        $CI->db->where('emp_status', 1);
        $CI->db->where('emp_is_parmanent', 1);
        $CI->db->where('emp_is_retired', 0);
		$CI->db->order_by("role_leave_level", "ASC");
		$CI->db->order_by("emp_full_name", "ASC");
        $query = $CI->db->get();
        //echo $CI->db->last_query();
		if($query->num_rows() > 1 && $role_id == 3 ){ // if PS role return more than one row
			pr("get_section_employee() common helper return more than 1 rows for PS role");
		}else{
			return $rows = $query->result();
		}
    }
    
    function holidays_2015(){
        $sat_2 = '2nd Saturday';
        $sat_3 = '3rd Saturday';
        $sun = 'Sunday';
        $holidays = array(
           'Saturday' => '2015-01-04', '2015-01-10', '2015-01-11', '2015-01-17', '2015-01-18', '2015-01-25', '2015-01-26',
           '2015-02-01', '2015-02-03', '2015-02-08', '2015-02-14', '2015-02-15', '2015-02-17', '2015-02-21', '2015-02-22',
           '2015-03-01', '2015-03-06', '2015-03-01', '2015-03-08', '2015-03-14', '2015-03-15', '2015-03-21', '2015-03-22', '2015-03-28', '2015-03-29',
           '2015-04-02', '2015-04-03', '2015-04-05', '2015-04-11', '2015-04-12', '2015-04-14', '2015-04-18', '2015-04-19', '2015-04-21', '2015-04-26',
           '2015-05-03', '2015-05-04', '2015-05-09', '2015-05-10', '2015-05-16', '2015-05-17', '2015-05-24', '2015-05-31',
           '2015-06-07', '2015-06-13', '2015-06-14', '2015-06-20', '2015-06-21', '2015-06-28', 
           '2015-07-05', '2015-07-11', '2015-07-12', '2015-07-18', '2015-07-19', '2015-07-26',
           '2015-08-02', '2015-08-08', '2015-08-09', '2015-08-15', '2015-08-16', '2015-08-23', '2015-08-29', '2015-08-30',
           'Janmashtami' => '2015-09-05', '2015-09-06', '2015-09-12', '2015-09-13', 'Anant chaturdashi' => '2015-09-17', '2015-09-19', '2015-09-20', 'Eid' => '2015-09-25', '2015-09-27',
           '2015-10-02', '2015-10-04', '2015-10-10', '2015-10-11', '2015-10-17', '2015-10-18', '2015-10-22', '2015-10-24', '2015-10-25', '2015-10-27',
           '2015-11-01', '2015-11-08', 'Deepavali' => '2015-11-11', 'Padawa' => '2015-11-12', '2015-11-14', '2015-11-15', '2015-11-21', '2015-11-22', 'Guru Nanank Jayanti' => '2015-11-25', '2015-11-29',
           '2015-12-03', '2015-12-06', '2015-12-12', '2015-12-13', '2015-12-19', '2015-12-20', '2015-12-24', '2015-12-25', '2015-12-27',
        );
        return $holidays; 
    }

	function holidays_2016(){     
        $holidays = array(
             '2016-01-03', '2016-01-09', '2016-01-10', '2016-01-16', '2016-01-17', '2016-01-24', '2016-01-26', '2016-01-31',
           '2016-02-07', '2016-02-13','2016-02-14', '2016-02-20', '2016-02-21', '2016-02-22', '2016-02-28',
           '2016-03-06', '2016-03-07', '2016-03-12','2016-03-13', '2016-03-19','2016-03-20', '2016-03-23', '2016-03-25', '2016-03-27','2016-03-28',
           '2016-04-03', '2016-04-08', '2016-04-09', '2016-04-10', '2016-04-14', '2016-04-15', 
           '2016-04-16', '2016-04-17', '2016-04-19', '2016-04-24',
           '2016-05-01', '2016-05-08', '2016-05-09','2016-05-14', '2016-05-15', '2016-05-21', '2016-05-22', '2016-05-29', 
           '2016-06-05', '2016-06-11', '2016-06-12', '2016-06-18', '2016-06-19', '2016-06-26',  
           '2016-07-03', 'ईद-उल-फितर' => '2016-07-07', '2016-07-09', '2016-07-10', '2016-07-16', '2016-07-17', '2016-07-24','2016-07-31',
           '2016-08-07', '2016-08-13', '2016-08-14', 'स्वत्रंता दिवस' => '2016-08-15', 'रक्षाबंधन' => '2016-08-18', '2016-08-20', '2016-08-21', 'जन्माष्टमी' => '2016-08-25', '2016-08-28', 
           '2016-09-04', '2016-09-05', '2016-09-10', '2016-09-11', '2016-09-13', '2016-09-17', '2016-09-18', '2016-09-25', 
           '2016-10-02', '2016-10-08', '2016-10-09', '2016-10-11', '2016-10-12', '2016-10-15', '2016-10-16', '2016-10-23', '2016-10-30','दीपावली' => '2016-10-31', 
           '2016-11-06', '2016-11-12', '2016-11-13', '2016-11-14', '2016-11-19', '2016-11-20', '2016-11-27', 
           '2016-12-03','2016-12-04', '2016-12-10', '2016-12-11', 'EID' => '2016-12-12', '2016-12-17', '2016-12-18', '2016-12-25', 
        
		);
        return $holidays; 
    }

    function holidays_2017(){     
        $holidays = array(
           '2017-01-01', 'जयंती' => '2017-01-05', '2017-01-08',  '2017-01-14','2017-01-15',  '2017-01-21', '2017-01-22', 'गणतंत्र दिवस' =>'2017-01-26', '2017-01-29', 
           '2017-02-05', 'रविदास जयंती' => '2017-02-10', '2017-02-11', '2017-02-12', '2017-02-18', '2017-02-19', 'महा शिव रात्रि' => '2017-02-24','2017-02-26',
           '2017-03-05', '2017-03-11','2017-03-12', 'होली' => '2017-03-13', 'रंग पंचमी' => '2017-03-17', '2017-03-18', '2017-03-19', '2017-03-26',
           '2017-04-02', '2017-04-05', '2017-04-08', '2017-04-09', '2017-04-14','2017-04-15', '2017-04-16', '2017-04-23', '2017-04-29', '2017-04-30',
           '2017-05-07', '2017-05-10', '2017-05-13', '2017-05-14', '2017-05-20', '2017-05-21', '2017-05-28',
            '2017-06-04', '2017-06-10', '2017-06-11', '2017-06-17', '2017-06-18', '2017-06-25', '2017-06-26',
        );
        return $holidays;  
    }
    
    function holidays($year){    
		
	   $_2015 = array(
           'Saturday' => '2015-01-04', '2015-01-10', '2015-01-11', '2015-01-17', '2015-01-18', '2015-01-25', '2015-01-26',
           '2015-02-01', '2015-02-03', '2015-02-08', '2015-02-13', '2015-02-14', '2015-02-15', '2015-02-17', '2015-02-21', '2015-02-22',
           '2015-03-01', '2015-03-06', '2015-03-01', '2015-03-08', '2015-03-12', '2015-03-14', '2015-03-15', '2015-03-21', '2015-03-22', '2015-03-28', '2015-03-29',
           '2015-04-02', '2015-04-03', '2015-04-05', '2015-04-11', '2015-04-12', '2015-04-14', '2015-04-18', '2015-04-19', '2015-04-21', '2015-04-26',
           '2015-05-03', '2015-05-04', '2015-05-09', '2015-05-10', '2015-05-16', '2015-05-17', '2015-05-24', '2015-05-31',
           '2015-06-07', '2015-06-13', '2015-06-14', '2015-06-20', '2015-06-21', '2015-06-28', 
           '2015-07-05', '2015-07-11', '2015-07-12', '2015-07-18', '2015-07-19', '2015-07-26',
           '2015-08-02', '2015-08-08', '2015-08-09', '2015-08-15', '2015-08-16', '2015-08-23', '2015-08-29', '2015-08-30',
           'Janmashtami' => '2015-09-05', '2015-09-06', '2015-09-12', '2015-09-13', 'Anant chaturdashi' => '2015-09-17', '2015-09-19', '2015-09-20', 'Eid' => '2015-09-25', '2015-09-27',
           '2015-10-02', '2015-10-04', '2015-10-10', '2015-10-11', '2015-10-17', '2015-10-18', '2015-10-22', '2015-10-24', '2015-10-25', '2015-10-27',
           '2015-11-01', '2015-11-08', 'Deepavali' => '2015-11-11', 'Padawa' => '2015-11-12', '2015-11-14', '2015-11-15', '2015-11-21', '2015-11-22', 'Guru Nanank Jayanti' => '2015-11-25', '2015-11-29',
           '2015-12-03', '2015-12-06', '2015-12-12', '2015-12-13', '2015-12-19', '2015-12-20', '2015-12-24', '2015-12-25', '2015-12-27',
        );
		
		$_2016 = array(
             '2016-01-03', '2016-01-09', '2016-01-10', '2016-01-16', '2016-01-17', '2016-01-24', '2016-01-26', '2016-01-31',
           '2016-02-07', '2016-02-13','2016-02-14', '2016-02-20', '2016-02-21', '2016-02-22', '2016-02-28',
           '2016-03-06', '2016-03-07', '2016-03-12','2016-03-13', '2016-03-19','2016-03-20', '2016-03-23', '2016-03-25', '2016-03-27','2016-03-28',
           '2016-04-03', '2016-04-08', '2016-04-09', '2016-04-10', '2016-04-14', '2016-04-15', 
           '2016-04-16', '2016-04-17', '2016-04-19', '2016-04-24',
           '2016-05-01', '2016-05-08', '2016-05-09','2016-05-14', '2016-05-15', '2016-05-21', '2016-05-22', '2016-05-29', 
           '2016-06-05', '2016-06-11', '2016-06-12', '2016-06-18', '2016-06-19', '2016-06-26',  
           '2016-07-03', 'ईद-उल-फितर' => '2016-07-07', '2016-07-09', '2016-07-10', '2016-07-16', '2016-07-17', '2016-07-24','2016-07-31',
           '2016-08-07', '2016-08-13', '2016-08-14', 'स्वत्रंता दिवस' => '2016-08-15', 'रक्षाबंधन' => '2016-08-18', '2016-08-20', '2016-08-21', 'जन्माष्टमी' => '2016-08-25', '2016-08-28', 
           '2016-09-04', '2016-09-05', '2016-09-10', '2016-09-11', '2016-09-13', '2016-09-17', '2016-09-18', '2016-09-25', 
           '2016-10-02', '2016-10-08', '2016-10-09', '2016-10-11', '2016-10-12', '2016-10-15', '2016-10-16', '2016-10-23', '2016-10-30','दीपावली' => '2016-10-31', 
           '2016-11-06', '2016-11-12', '2016-11-13', '2016-11-14', '2016-11-19', '2016-11-20', '2016-11-27', 
           '2016-12-03','2016-12-04', '2016-12-10', '2016-12-11', 'EID' => '2016-12-12', '2016-12-17', '2016-12-18', '2016-12-25', 
		);

        $_2017 = array(
           '2017-01-01', 'जयंती' => '2017-01-05', '2017-01-08',  '2017-01-14','2017-01-15',  '2017-01-21', '2017-01-22', 'गणतंत्र दिवस' =>'2017-01-26', '2017-01-29', 
          '2017-02-05', 'रविदास जयंती' => '2017-02-10', '2017-02-11', '2017-02-12', '2017-02-18', '2017-02-19', 'महा शिव रात्रि' => '2017-02-24','2017-02-26',
           '2017-03-05', '2017-03-11','2017-03-12', 'होली' => '2017-03-13', 'रंग पंचमी' => '2017-03-17', '2017-03-18', '2017-03-19', '2017-03-26',
            '2017-04-02', '2017-04-05', '2017-04-08', '2017-04-09', '2017-04-14','2017-04-15', '2017-04-16', '2017-04-23', '2017-04-29', '2017-04-30',
           '2017-05-07', '2017-05-10', '2017-05-13', '2017-05-14', '2017-05-20', '2017-05-21', '2017-05-28',
            '2017-06-04', '2017-06-10', '2017-06-11', '2017-06-17', '2017-06-18', '2017-06-25', '2017-06-26',
        );
		
		if($year == '2015'){
			return $_2015;
		} else if($year == '2016'){
			return $_2016;
		}else if($year == '2017'){
            return $_2017;
        }
    
	
	}	
    
    function check_holidays($date){		
		$year = get_date_formate($date,'Y');		
        $on_date =  date('Y-m-d', strtotime($date));
		$holiday_year = holidays($year);
		//pre($holiday_year);
        if(in_array($on_date, $holiday_year)) {
           //echo 'yes'.$on_date ; exit;
            return true;
        } else {
            //echo 'no'.$on_date ; exit;
            return false;
        }
        
    }
    
    function holidays_name($date){
		$year = get_date_formate($date,'Y');		
        $on_date =  date('Y-m-d', strtotime($date));
		$holiday_year = holidays($year);
		//pre($date);
        if(in_array($on_date, $holiday_year)) {
           $key = array_search($on_date, $holiday_year);
		   if(!is_numeric($key)){			   
            return $key;
		   } else {
			   return false;
		   }
        } 
    }
	
	/* Send sms -Rohit */
	 function post_to_url($url, $data) {
           $fields = '';
           foreach($data as $key => $value) { 
              $fields .= $key . '=' . $value . '&'; 
           }
           rtrim($fields, '&');

           $post = curl_init();

           curl_setopt($post, CURLOPT_URL, $url);
           curl_setopt($post, CURLOPT_POST, count($data));
           curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
           curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);

           echo $result = curl_exec($post);

           curl_close($post);
    }
    
	// for unicode message use in leave spprove controller
	function post_to_url_unicode($url, $data) {
        $fields = '';
        foreach($data as $key => $value) {
           $fields .= $key . '=' . urlencode($value) . '&';  
        }
		rtrim($fields, '&');
      
        $post = curl_init();
        curl_setopt($post, CURLOPT_URL, $url);
        curl_setopt($post, CURLOPT_POST, count($data));
        curl_setopt($post, CURLOPT_POSTFIELDS, $fields);
        curl_setopt($post, CURLOPT_HTTPHEADER, array("Content-Type: application/x-www-form-urlencoded")); 
        curl_setopt($post, CURLOPT_HTTPHEADER, array("Content-length:" . strlen($fields) )); 
        curl_setopt($post, CURLOPT_HTTPHEADER, array("User-Agent: Mozilla/4.0 (compatible; MSIE 5.0; Windows 98; DigExt)")); 
        curl_setopt($post, CURLOPT_RETURNTRANSFER, 1);
		echo $result = curl_exec($post);
		curl_close($post);
    }
	
	function ordutf8($string, &$offset){
		$code=ord(substr($string, $offset,1)); 
		if ($code >= 128)   //Please reomve -- symbol for this line                        
		{        //otherwise 0xxxxxxx
			if ($code < 224) $bytesnumber = 2;                //110xxxxx
			else if ($code < 240) $bytesnumber = 3;        //1110xxxx
			else if ($code < 248) $bytesnumber = 4;    //11110xxx
			$codetemp = $code - 192 - ($bytesnumber > 2 ? 32 : 0) - ($bytesnumber > 3 ? 16 : 0);
			for ($i = 2; $i <= $bytesnumber; $i++) {
					 $offset ++;
					 $code2 = ord(substr($string, $offset, 1)) - 128;        //10xxxxxx
					 $codetemp = $codetemp*64 + $code2;
						}
				$code = $codetemp;
		
			}
	   return $code;
	}
		
	function send_sms($mobile_numbers, $content , $unicode = false) {
		
		$finalmessage = $content;
		if($unicode == true) {
			header('Content-Type: text/html; charset=UTF-8');
			$message = $content;
			$finalmessage = "";
			$sss = "";			
		  
			for($i=0;$i<mb_strlen($message,"UTF-8");$i++) {
				$sss=mb_substr($message,$i,1,"utf-8");
				$a=0; 
				$abc="&#" .ordutf8($sss,$a).";";
				$finalmessage.=$abc; 
			} 
					
		}

        $data = array(
           "username" => "DITMP-MPLSWD",         // type your assigned username here(for example:                  "username" => "CDACMUMBAI")
 
           "password" => "lladbho#123",	         //type your password
		   
           "senderid" => "MPLAWD",	             //type your senderID

           "smsservicetype" => $unicode == true ? 'unicodemsg' :  'bulkmsg',         //*Note*  for single sms enter  ”singlemsg” , for bulk   		enter “bulkmsg”

           "bulkmobno" => $mobile_numbers,			//enter the mobile numbers separated by commas, in case of bulk sms otherwise leave it blank

           "content"  => urldecode($finalmessage)	             //type the message.
            
        );

		$url = "http://msdgweb.mgov.gov.in/esms/sendsmsrequest";
		if($unicode == true){
			//$ret = post_to_url_unicode($url, $data);
		 } else {
			//$ret = post_to_url($url, $data);
		 }
		if($ret) { 
			echo  'Mesdsage send successfully!';
		}
    }
	
	
	//provide setting output 
	function get_settings($key){
		$CI = & get_instance();
		$CI->db->select("set_value,set_datetime");
        $CI->db->from(SETTINGS);
        $CI->db->where("set_key",$key);        
        $query = $CI->db->get();
		//echo $CI->db->last_query();
		if($query->num_rows() > 0){
			return $query->row_array();
		} else{
			return false;
		}
	}
	
	function add_settings($key, $value){
		$CI = & get_instance();
		$data = array(
			'set_key' => $key,
			'set_value' => $value,
		);
		if(get_settings($key)) {
			$res = insertData($data, SETTINGS);
		} else {
			$res = false;
		}
		if($res){
			return true;
		} else{
			return false;
		}
	}
	
	//provide setting output 
	function update_settings($key, $new_value){
		$CI = & get_instance();		
		$data = array(
			'set_key' => $key,
			'set_value' => $new_value,
		);
		$res = updateData(SETTINGS, $data, array('set_key' => $key));
		return $res;
			
	}
	
	function employees_class($type = null){
		$list = array(
			1 => 'Class - I',
			2 => 'Class - II',
			3 => 'Class - III',
			4 => 'Class - IV',
			5 => 'Officer'
		);
		if (array_key_exists($type, $list)) {
			return $list[$type];
		} else {
			return $list;
		}
	}
	function get_report_type($type = null){
		$list = array(
			'n' => 'उपस्थिति रिपोर्ट',
			'l' => 'उपस्थिति विलम्ब रिपोर्ट'
		);
		if (array_key_exists($type, $list)) {
			return $list[$type];
		} else {
			return $list;
		}
	}
	
	function get_status($type, $creater_id, $approval_id){
		$label = '<label class="label label-';
		if($type == 0){
			$label .=  'primary">आवेदन दर्ज ';
		}elseif($type == 1){
			$label .= 'success">आवेदन स्वीकृत ';
		}elseif($type == 2){
			if($creater_id == $approval_id){
				$label .= 'warning">आवेदन रद्द ';
			} else{
				$label .= 'danger">आवेदन अस्वीकृत ';
			}
		} else{
			$label .= 'warning">आवेदन स्थिति गलत ';
		}
		$label .= '</label>';
		return $label;
		
	}
	
	function leave_deduction_sms($type, $days, $month){
		$leave_type = leaveType($type,true);
		$month_name = months($month,true);
		if($days == 1 && ($type == 'cl' || $type == 'el' )){
			return "कार्यालय में विलम्ब से आने के कारण ".$month_name." माह का ".$days." दिन  का ".$leave_type." काटा गया| विलम्ब रिपोर्ट देखें|";
		} else if($days > 1 && ($type == 'cl' || $type == 'el' )){
			return "कार्यालय में विलम्ब से आने के कारण ".$month_name." माह का ".$days." दिन  का ".$leave_type." काटे गऐ| विलम्ब रिपोर्ट देखें|";
		}else if($type == 'lwp'){
			return "कार्यालय में विलम्ब से आने के कारण ".$month_name." माह का ".$days." दिन  का ".$leave_type." किया गया| विलम्ब रिपोर्ट देखें|";		
		}
	}
	
	
	function get_load_log($aaa) {
    
        $CI = & get_instance();
        
        $bbb1 = memory_get_usage();
        
        $bbb1 = $bbb1 / 1000000;
        
        $bbb1mb="MB";
        
        $bbb1 = round($bbb1,2);
        
        $aaa1 = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
        
        $aaa = round($aaa1, 2);
        
        $sessionemp = $CI->session->userdata['emp_id'];
        
        $path = '/opt/rh/httpd24/root/var/www/html/ftms_live/LOG_DATA/'; //APPPATH.'/../LOG_DATA/';
        
        $date22 = date('Y_m_d').'.';
            
        $filename = $path.'logger_url_'.$date22.'txt';
        
        $file = fopen($filename,'a');
        
        $emp_name = $CI->session->userdata['emp_full_name_hi'];
        
        $ipaddresss = gethostbyname(gethostbyaddr($_SERVER['REMOTE_ADDR']));
        
        $writecontent = 'TIME-'.date('H_i_s')." >>> ".'IP-'.$ipaddresss." >>> ".'EMP_ID-'.$sessionemp.' >>> URL-'.current_url().' >>> LOAD_TIME-'.$aaa.' >>> MEMORY-'.$bbb1.$bbb1mb.' >>> NAME-'.$emp_name.PHP_EOL;
        
        if(current_url()!=base_url()."e_filelist/ajax_count_inbox")
        {
        fwrite($file,$writecontent);
        }
        
        fclose($file); 
                
    }

	function get_emp_role_levele(){
		$CI = & get_instance();
		
		$role_id= get_employee_role(emp_session_id(), $id = true);
		$CI->db->select('role_id,unit_id,emprole_level,emprole_name_hi');
		$CI->db->where('role_id', $role_id);
		$query = $CI->db->get(EMPLOYEEE_ROLE);
		return $roles = $query->row_array();
	}
	
	function get_est_so_number(){
		/*$CI = & get_instance();
		$CI->db->select('emp_mobile_number');
		$CI->db->where('role_id', 8); // for so
		$CI->db->where("FIND_IN_SET('7',`emp_section_id`)", false, null); // only est
		$query = $CI->db->get(EMPLOYEES);
		$result  = $query->row();
		//echo $CI->db->last_query();
		return $result->emp_mobile_number;*/
        return '7746099770'; 
		
	}
	
	function verify_digital_sinature($log_id,$draft_content = null){
		//echo '<br/>d log id- '.$log_id;

		$ci = & get_instance();
		//$ci->db->select('ds_emp_name,ds_signed_data,ds_public_key,ds_isverfied,ds_create_datetime');
		$ci->db->from('ft_leave_digital_signature');	

		if($draft_content != null){
			$ci->db->where('ds_affter_signing_content', $draft_content);
		}
		$ci->db->where('ds_leave_mov_id', $log_id);
		$ci->db->order_by('ds_id','DESC');
		$ci->db->limit(1);
		$query = $ci->db->get();

		if($query->num_rows() > 0){
		  $result = $query->row_array();
		
			$signing_content =$result['ds_signing_content'];
			//pre($result);
			$signData = urlencode($signing_content);
			$publicKey = urlencode($result['ds_public_key']);
			$digitalSignature = urlencode($result['ds_signature_key']);
			$url = "http://10.115.254.213:8080/data_signing/verifySignData?signData=$signData&publicKey=$publicKey&digitalSignature=$digitalSignature";
			$ch = curl_init();
			curl_setopt($ch, CURLOPT_URL, $url);
			curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
			curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true );
			// This is what solved the issue (Accepting gzip encoding)
			curl_setopt($ch, CURLOPT_ENCODING, "gzip,deflate");     
			$response = curl_exec($ch);
			curl_close($ch);
			//pre($response);
			$show_data = '<b>'.$result['ds_emp_name'].'</b> <br/> <span style="font-size:12px;">'.get_datetime_formate($result['ds_signature_date']).'</span>';
			$show_data_title = ''.$result['ds_emp_name'].' on '.get_datetime_formate($result['ds_signature_date']);
			if($response == '"success"'){
						//$return  = '<img src="'.base_url().'images/verify_sign.png" height="25px" width="30px" title="Signed by: '.$show_data.'"> <div style="font-size:10px">Digitally Signed By</div>' ;
						$return  = '<img src="'.base_url().'images/verify_sign.png" height="25px" width="30px" title="Signed by: '.$show_data_title.'"> <div style="font-size:12px; margin:0px; text-align: center">Digitally Signed By <br/><span style="font-size:14px">'.$show_data.'</span></div>' ;
					
					} else { 
						$return  = '<img src="'.base_url().'images/cross_signed.jpg" height="25px" width="30px" title="Error: Data wrong or tempered">' ;
					}
			
			
			
			return $return;
		} else {
			return false;
		}
	
	}
	function pagination_entries_dropdown($total_counts){
		$CI = & get_instance();
		$i= INITIAL_ENTRIES_PAGINATION;
		$max = MAX_ENTRIES_PAGINATION;
		if($max > $total_counts){
			$max = ceil($total_counts / 10) * 10;
		}
		$data = '<div class="">';
		$data .= '<label>Show ';
		$data .= '<select class="input-sm" id="session_pagination_entries">';
		while($i <= $max) {
			if($CI->session->userdata('per_page_entry') == $i){
				$selected =  'selected' ;
			}else{
				$selected = null;
			}
			$data .= '<option value="'.$i.'" '.$selected.'>'.$i.'</option>';
			$i = $i + INTERVAL_ENTRIES_PAGINATION;
		}
		$data .= '</select>';
		$data .=  ' entries</label>';
	    $data .= '</div>';
		echo $data;
	}
	function get_log_data($aaa) {	    
	    $CI = & get_instance();
	    
	    $bbb1 = memory_get_usage();
	    
	    $bbb1 = $bbb1 / 1000000;
	    
	    $bbb1mb="MB";
	    
	    $bbb1 = round($bbb1,2);
	    
	    $aaa1 = microtime(true) - $_SERVER["REQUEST_TIME_FLOAT"];
	    
	    $aaa = round($aaa1, 2);
	    
	    $sessionemp = $CI->session->userdata['emp_id'];
	    
	    $path = 'LOG_DATA/';
	    
	    $date22 = date('Y_m_d').'.';
	        
	    $filename = $path.'logger_url_'.$date22.'txt';
	    
	    $file = fopen($filename,'a');
	    
	    $emp_name = $CI->session->userdata['emp_full_name_hi'];
	    
	    $ipaddresss = gethostbyname(gethostbyaddr($_SERVER['REMOTE_ADDR']));
	    
	    $writecontent = 'TIME-'.date('H_i_s')." >>> ".'IP-'.$ipaddresss." >>> ".'EMP_ID-'.$sessionemp.' >>> URL-'.current_url().' >>> LOAD_TIME-'.$aaa.' >>> MEMORY-'.$bbb1.$bbb1mb.' >>> NAME-'.$emp_name.PHP_EOL;
	    
	    fwrite($file,$writecontent);
	    
	    fclose($file); 
	           
	}
		