<?php  if ( ! defined('BASEPATH')) exit('No direct script access allowed');
/*
| -------------------------------------------------------------------------
| URI ROUTING
| -------------------------------------------------------------------------
| This file lets you re-map URI requests to specific controller functions.
|
| Typically there is a one-to-one relationship between a URL string
| and its corresponding controller class/method. The segments in a
| URL normally follow this pattern:
|
|	example.com/class/method/id/
|
| In some instances, however, you may want to remap this relationship
| so that a different class/function is called than the one
| corresponding to the URL.
|
| Please see the user guide for complete details:
|
|	http://codeigniter.com/user_guide/general/routing.html
|
| -------------------------------------------------------------------------
| RESERVED ROUTES
| -------------------------------------------------------------------------
|
| There area two reserved routes:
|
|	$route['default_controller'] = 'welcome';
|
| This route indicates which controller class should be loaded if the
| URI contains no data. In the above example, the "welcome" class
| would be loaded.
|
|	$route['404_override'] = 'errors/page_missing';
|
| This route will tell the Router what URI segments to use if those provided
| in the URL cannot be matched to a valid route.
|
*/
/* common front page */
$route['default_controller'] = "site/home";
$route['home'] = "site/home";
$route['login'] = "site/home/login_user";
$route['logout'] = "site/home/logout";
$route['forgote_password'] = "site/home/forgote_password";
$route['reset_password'] = "site/home/reset_password";
$route['password_change'] = "site/home/reset_forgote_password";
$route['admin/dashboard'] = "admin/Admin_dashboard";
$route['dashboard'] = "dashboard/common_dashboard";
/*End*/


// $route['admin/sections'] = "admin/admin_sections";
$route[ADMIN_URL.'/sections'] = "admin_sections_master";
$route[ADMIN_URL.'/add_section'] = "admin_sections_master/manage_section";
$route[ADMIN_URL.'/edit_section/(:any)'] = "admin_sections_master/manage_section/$1";
$route[ADMIN_URL.'/delete_section/(:any)']  = "admin_sections_master/delete_section/$1";

// $route['admin/section/add_section/(:any)']  = "admin/admin_sections/manage_section/$1";


$route['admin/changepassword'] = "admin/admin_dashboard/editpassword";
$route['admin/profile'] = "admin/admin_dashboard/profile";
/*Unite Master */
$route['admin/unit'] = "admin/admin_unit";
$route['admin/manage_unit/(:any)']  = "admin/admin_unit/manage_unit/$1";
$route['admin/add_unit']  = "admin/admin_unit/manage_unit";
$route['admin/delete_unit/(:any)']  = "admin/admin_unit/delete_unit/$1";

/*Admin District*/
$route['admin/district'] = "admin/admin_district";
$route['admin/manage_district/(:any)'] = "admin/admin_district/manage_district/$1";
$route['admin/add_district']  = "admin/admin_district/manage_district";
$route['admin/district_delete/(:any)']  = "admin/admin_district/district_delete/$1";
/*End*/

/*Admin User */
$route[ADMIN_URL.'/employees'] = "admin_users";
$route[ADMIN_URL.'/add_employee'] = "admin_users/manage_user";
$route[ADMIN_URL.'/edit_employee/(:any)'] = "admin_users/manage_user/$1";

/*Admin Employee Role*/
$route[ADMIN_URL.'/employeerole'] = "admin_employeerole_master";
$route[ADMIN_URL.'/add_employeerole'] = "admin_employeerole_master/manage_employeerole";
$route[ADMIN_URL.'/edit_employeerole/(:any)'] = "admin_employeerole_master/manage_employeerole/$1";
/*End*/

/*Admin Department*/
$route['admin/department'] = "admin/admin_department";
$route['admin/manage_department/(:any)'] = "admin/admin_department/manage_department/$1";
$route['admin/add_department']  = "admin/admin_department/manage_department";
/*End*/


//RP
$route['add_file'] = "manage_file/files/index";
//$route['dashboard/show_file'] = "view_file/crviewfile";
$route['show_file/(:any)'] = "view_file/crviewfile/$1";
$route['dashboard/add_file'] = "manage_file/files/manage_files";
$route['dashboard/edit_file/(:any)'] = "manage_file/files_edit/index/$1";
//$route['dashboard/editFile/(:any)'] = "manage_file/files_edit/update_files/$1";
//$route['dashboard/receive_edit/(:any)'] = "manage_file/files_edit/receivebycr/$1";
/*End*/

/*Admin Notice*/
$route[ADMIN_URL.'/notice'] = "admin_notice_master";
$route[ADMIN_URL.'/add_notice'] = "admin_notice_master/manage_notice";
$route[ADMIN_URL.'/delete_notice/(:any)'] = "admin_notice_master/notice_delete/$1";
$route[ADMIN_URL.'/edit_notice/(:any)'] = "admin_notice_master/manage_notice/$1";
/*End*/

/*View files*/
$route['return_file'] = "view_file/crviewfile";
$route['File/work/(:any)'] = "view_file/senttoda_action/$1";
$route['view_file/Data'] = "view_file/dealing_file/notesheet_files";
/*End*/

/*Dealing assistance*/
$route['dashboard/dealing/(:any)'] = "manage_file/dealing_manage_files/index/$1";
$route['dashboard/save_dealing/(:any)'] = "manage_file/dealing_manage_files/manage_files/$1";
/*End*/

/* leave */
$route['leave/cancel/(:any)'] = "leave/cancel_leave/$1";
$route['leave/print/(:any)'] = "leave/print_leave/$1";
$route['leave/employee_list'] = "leave/leave_approve/getEmployeeLeave";
$route['leave/employee_search'] = "leave/leave_approve/employeeLeave";
$route['leave/approve_list'] = "leave/approve_deny_secretary";
$route['leave/leave_details/(:any)'] = "leave/leave_details/index/$1";
$route['leave/leave_order/(:any)'] = "leave/leave_details/leave_order/$1";
$route['leave/digital_sign_leave_order'] = "leave/leave_details/digital_sign_order";
$route['leave/genrate_order/(:any)'] = "leave/leave_details/genrate_order/$1";
$route['leave/applications/(:any)'] = "leave/leave_details/leave_applications/$1";
$route['leave/attachments/(:any)'] = "leave/leave_details/leave_attachments/$1";
$route['leave/update_attachments'] = "leave/leave_details/update_leave_attachments";
$route['leave/under_employees/(:any)'] = "leave/leave/under_employees/$1";
$route['leave_details_search/(:any)'] = "leave/leave_details/leave_details_search/$1";

/*Code Bij 01/08/2015*/
$route[ADMIN_URL.'/department_posts'] = "admin_department_post_master";
$route[ADMIN_URL.'/edit_post/(:any)'] = "admin_department_post_master/manage_post/$1";

$route[ADMIN_URL.'/employee_otherwork'] = "admin_upper_level_work_master";
$route[ADMIN_URL.'/edit_otherwork/(:any)'] = "admin_upper_level_work_master/manage_otherwork/$1";

$route[ADMIN_URL.'/notesheets'] = "admin_notesheet_master";
$route[ADMIN_URL.'/edit_notesheet/(:any)'] = "admin_notesheet_master/manage_notesheet/$1";
$route[ADMIN_URL.'/add_notesheet'] = "admin_notesheet_master/manage_notesheet";

$route[ADMIN_URL.'/notesheet_master_menu'] = "admin_notesheet_type_master";
$route[ADMIN_URL.'/edit_notesheet_master_menu/(:any)'] = "admin_notesheet_type_master/manage_notesheet_mastmenu/$1";
$route[ADMIN_URL.'/add_notesheet_master_menu'] = "admin_notesheet_type_master/manage_notesheet_mastmenu";

$route['first_reset_password'] = "reset_password";
/*End of Code Bij 01/08/2015*/

$route['attached/file_doc/(:any)'] = "view_file/dealing_file/notesheet_files/$1";
$route['Attached/Doc_File/(:any)'] = "view_file/dealing_file/notesheet_files/$1";
/* home footer links */
$route['faq'] = "site/home/faq";
$route['privacy_policy'] = "site/home/privacy_policy";
$route['departmental_setup'] = "site/home/departmental_setup";
$route['faq'] = "site/home/faq";
/*end*/
$route['moniter/files'] = "view_file/file_moniter";
$route['user_activity'] = "user_activity/activity";
$route['activity_details/(:any)'] = "user_activity/activity/activity_details/$1";

/*Admin leave level master*/
$route['admin/leave_levels'] = "admin/leave_levels";
$route['admin/add_leave_levels']  = "admin/leave_levels/manage_leave_levels";
$route['admin/manage_leave_levels/(:any)'] = "admin/leave_levels/manage_leave_levels/$1";
$route['admin/delete_level_lists/(:any)'] = "admin/leave_levels/delete_level_lists/$1";
/*Adde by bij 05 11 2015*/
$route['officer/auto_login'] = "site/home/auto_login_user";

//for report
$route['biometric_report/add_report']  = "biometric_report/manage_report/";
$route['biometric_report/edit_report/(:any)'] = "biometric_report/manage_report/$1";
$route['biometric_report/delete_report/(:any)'] = "biometric_report/delete_report/$1";

//joiing report
$route['joining_report/add_report']  = "joining_report/manage_report/";
$route['joining_report/edit_report/(:any)'] = "joining_report/manage_report/$1";
$route['joining_report/delete_report/(:any)'] = "joining_report/delete_report/$1";

/*End*/

//out of dept report
$route['outof_department_report/add_report']  = "outof_department_report/manage_report/";
$route['outof_department_report/edit_report/(:any)'] = "outof_department_report/manage_report/$1";
$route['outof_department_report/delete_report/(:any)'] = "outof_department_report/delete_report/$1";

/*End*/
$route['site_map']  = "dashboard/common_dashboard/site_map";
$route['site_map/(:any)']  = "dashboard/common_dashboard/site_map/$1";
/* End of file routes.php */
/* Location: ./application/config/routes.php */