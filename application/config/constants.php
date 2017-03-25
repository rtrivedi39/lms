<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');

/*
|--------------------------------------------------------------------------
| File and Directory Modes
|--------------------------------------------------------------------------
|
| These prefs are used when checking and setting modes when working
| with the file system.  The defaults are fine on servers with proper
| security, but you may wish (or even need) to change the values in
| certain environments (Apache running a separate process for each
| user, PHP under CGI with Apache suEXEC, etc.).  Octal values should
| always be used to set the mode correctly.
|
*/
define('FILE_READ_MODE', 0644);
define('FILE_WRITE_MODE', 0666);
define('DIR_READ_MODE', 0755);
define('DIR_WRITE_MODE', 0777);

/*
|--------------------------------------------------------------------------
| File Stream Modes
|--------------------------------------------------------------------------
|
| These modes are used when working with fopen()/popen()
|
*/

define('FOPEN_READ',							'rb');
define('FOPEN_READ_WRITE',						'r+b');
define('FOPEN_WRITE_CREATE_DESTRUCTIVE',		'wb'); // truncates existing file data, use with care
define('FOPEN_READ_WRITE_CREATE_DESTRUCTIVE',	'w+b'); // truncates existing file data, use with care
define('FOPEN_WRITE_CREATE',					'ab');
define('FOPEN_READ_WRITE_CREATE',				'a+b');
define('FOPEN_WRITE_CREATE_STRICT',				'xb');
define('FOPEN_READ_WRITE_CREATE_STRICT',		'x+b');

define('SITE_NAME','FTAMS');
define('HTTP_PATH', (isset($_SERVER['HTTPS']) ? "https://" : "http://") .
  $_SERVER['SERVER_NAME'] . preg_replace('@/+$@', '', dirname($_SERVER['SCRIPT_NAME'])) . '/');
define('ADMIN_THEME_PATH', HTTP_PATH.'themes/admin/');
define('UPLOADS/', HTTP_PATH.'uploads/');
define('USR_IMG_PATH', HTTP_PATH.'uploads/employee/');
define('FRONTEND_DATE_VIEW_FORMAT',"d/m/Y");
define('ADMIN_DATE_VIEW_FORMAT',"d/m/Y");

define('NOTESHEET_ABS_PATH',FCPATH.APPPATH.'modules/admin_notesheet_master/views/');
/* End of file constants.php */
/* Location: ./application/config/constants.php */


define('PER_PAGE_VALUE_APP',5); // plese also change in app PER_PAGE_VALUE constant value

define('ADMIN_URL','admin');
define('EDITOR_URL',HTTP_PATH.'themes/admin/plugins/editor/');
define('SITE_STATUS','staging');
//define('DIGITALLY_SINGED_NOTE',' डिजिटल हस्ताक्षरित');
define('DIGITALLY_SINGED_NOTE','Digitally Signed');

define('LATE_ARRIVE',104500); 
define('ERLY_DEPT',173000);

define('MAX_ENTRIES_PAGINATION',100);
define('INTERVAL_ENTRIES_PAGINATION',10);
define('INITIAL_ENTRIES_PAGINATION',10);
/*Tables*/

/*Constant tables */
define('EMPLOYEES','employee');
define('DEPARTMENTS','department_master');
define('DISTRICT','district_master');
define('EMPLOYEE_DETAILS','employee_details');
define('EMPLOYEEE_ROLE','emprole_master');
define('FILES','files');
define('FILES_SECTION','files_section');
define('FILES_DISPATCH','file_dispatch');
define('FILES_LINKED','file_linked');
define('FILES_LOG','file_logs');
define('FILES_MOVEMENT_LEVEL','file_movement_level_master');
define('MESSAGE','messages');
define('MESSAGE_REPLY','messages_reply');
define('NOTICE_BOARD','notice_board');
define('SECTIONS','sections_master');
define('SETTINGS','settings');
define('UNIT_LEVEL','unit_level_master');
//define('STATES','state');
define('CITY','city');
define('NOTICE_BOARD_TYPE','notice_type_master');
define('EMPLOYEE_ALLOTED_SECTION','employee_alloted_sections');
define('EMPLOYEE_MASTER_NUMBER_POST','employee_number_of_designations_master');
define('EMPLOYEE_ACTIVITY_LOG','employee_activity_logs');
define('EMPLOYEE_HIARARCHI_LEVEL','employee_hirarchi');

define('REMARK_MASTER','remark_master');
define('FILES_MOVEMENT','file_movements');

define('OTHER_WORK_UPPERLEVEL_MASTER','other_work_upperlevels_master');
define('EMPLOYEE_ALLOTED_OTHER_WORK','employee_alloted_other_work');
define('NOTESHEET_MASTER','notesheet_master');
define('NOTESHEET_MASTER_MENU','notesheet_menu_master');
define('FILE_NOTESHEET_HEADER_MASTER','file_headnotesheet_master');
define('LEAVE_REMARK','leave_log');
define('EMPLOYEE_LOGIN_LOG','employee_login_log');
define('EMPLOYEE_PERMISSION_ALLOTED','employee_permission_alloted');
define('STATE_MASTER','ft_state_master');
define('FILES_OTHER_FEILDS','ft_files_other_feilds');
define('EMPLOYEE_SERVICE_RECORD','emp_service_record');

define('HEADS_MASTER','head_master');
define('COUNSELLER_MEMBERS','advocate_master');
define('ADVOCATE_MASTER','advocate_master');
define('ADVOCATE_SERVICE_RECORD','advocate_service_record');
define('STATES','state_master');
define('DISTICT_MASTER','district_master');
define('DIVISION_MASTER','division_master');
define('EST_CATEGORY_MASTER','est_master_category');
define('EST_WORK_ALLOTE','est_work_alloted');
define('COMPLAINTS','est_complaints');
define('EST_META','est_meta');
define('ADVOCATE_POSTING','advocate_posting_master');
define('TAHSIL_MASTER','tahsil_master');
define('REPORTS','reports');
define('SUGGESTION','suggestion');
define('FILE_SCAN','ft_file_scan');
define('DRAFT','file_draft');
define('DRAFT_LOG','draft_log');
define('SCAN_FILE_TYPE','scan_file_types');
define('SUB_FILE_TYPE','sub_section_file_type');
define('EMPLOYEE_VEHILE','employee_vehicle_details');

//lesasve
define('LEAVE_MOVEMENT','emp_leave_movement');
define('EMPLOYEE_LEAVE_LEVEL_MASTER','leave_level_master');
define('BIOMETRIC_REPORT','leave_report_biometric');
define('JOINING_REPORT','leave_joining_report');
define('OUT_OF_DEPARTMENT_REPORT','outof_department_report');
define('EMPLOYEE_LEAVE','employee_leave');
define('DIGITAL_SIGNATURE_LEAVE','ft_leave_digital_signature');
define('UNIS_BIO_REPORT','unis_bio_report'); 
define('ATTACHMENTS','attachments'); 

/*End Tables*/
/* End of file constants.php */
/* Location: ./application/config/constants.php */



