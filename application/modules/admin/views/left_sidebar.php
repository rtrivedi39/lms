<!-- Left side column. contains the logo and sidebar -->
<aside class="main-sidebar hidden-print">
    <!-- sidebar: style can be found in sidebar.less -->
    <section class="sidebar">
        <!-- Sidebar user panel (optional) -->
        <div class="user-panel">
            <div class="pull-left image">
                <?php if (!empty($current_emp_emp_image)) { ?>
                    <img src="<?php echo USR_IMG_PATH ?><?php echo $current_emp_emp_image; ?>" class="img-circle" alt="User Image" />
                    <?php
                } else {
                    ?>
                    <img src="<?php echo ADMIN_THEME_PATH; ?>dist/img/avatar5.png" class="img-circle" alt="User Image" />
                <?php } ?>
            </div>
            <div class="pull-left info">
                <p><?php echo $this->session->userdata('emp_full_name_hi'); ?></p>
                <!-- Status -->
                <a href="#"><i class="fa fa-circle text-success"></i><?php echo getemployeeRole($current_emp_designation_id); ?></a><br/>
                <a href="#">भूमिका:- <?php echo getemployeeRole($current_emp_role_id); ?></a>
            </div>
        </div>     
        <!-- Sidebar Menu -->
        <?php if($is_emp_first_login == 1){ ?>
        <ul class="sidebar-menu">
			<br/>
            <li class="header bg-red"><span class="pull-left">मेनू</span> <span id="counter" class="pull-right"></span></li>
              <!-- Optionally, you can add icons to the links -->
              <li class="">
				<a href="http://10.115.254.213/" data-original-title="File" data-toggle="tooltip"><i class="fa fa-file"></i> <span> फाइल पोर्टल </span></a>
               </li>
			  <li <?php if ($this->uri->segment(1) == 'dashboard') { echo 'class="active"'; } ?>>
				<a href="<?php echo base_url('dashboard'); ?>" data-original-title="Dashboard" data-toggle="tooltip"><i class="fa fa-dashboard"></i> <span> <?php echo $this->lang->line('dashboard_menu'); ?> </span></a>
              </li>
               <li class="googlevoic">
					<a href="http://10.115.254.213/draft/voic_input" target="_blank" ><i class="fa fa-volume-up"></i> <span>हिंदी /इंग्लिश बोलें</span></a>										
			   </li>
			  <li <?php if ($this->uri->segment(1) == 'site_map') { echo 'class="active"'; } ?>>
				<a href="<?php echo base_url('site_map'); ?>" data-original-title="Dashboard" data-toggle="tooltip"><i class="fa fa-sitemap"></i> <span> <?php echo $this->lang->line('site_map_menu'); ?> </span></a>
              </li>
			  
			  <li class="treeview active">
					<a href="#"><i class='fa fa-sitemap'></i> <span>अवकाश</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">						
						<li <?php if ($this->uri->segment(2) == 'add_leave') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url('leave'); ?>/add_leave" data-original-title="Apply Leave" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('apply_leave'); ?></span></a>
						</li>  
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == '') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url('leave'); ?>/" data-original-title="View Leaves" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('view_leave'); ?> </span></a>
						</li>
						<?php if (in_array($userrole,array(1,3,4,5,6,7,8,11,12,14,15,37,13,25)) || $current_emp_id == '251') { ?> 
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'employee_search') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url(); ?>leave/employee_search" data-original-title="Apply leave for employee" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span>  
							<?php echo $this->lang->line('leave_employee') ; ?> <?php echo (in_array(7, explode(',',$current_emp_section_id )) && $userrole == 8) ?  '/'.$this->lang->line('leave_employee_deduction') : ''; ?></span></a> 
						</li>
						<?php } ?>
						<li <?php if ($this->uri->segment(1) == 'joining_report' && $this->uri->segment(2) == 'add_report') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url(); ?>joining_report/add_report" data-original-title="Application for Joining report" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('joining_report_application_menu'); ?> </span></a>
						</li>
						<li <?php if ($this->uri->segment(1) == 'outof_department_report' && $this->uri->segment(2) == 'add_report') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url(); ?>outof_department_report/add_report" data-original-title="Out of department notification" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('outof_dept_application_menu'); ?> </span></a>
						</li>
						
					</ul>
				</li>
				<?php if(in_array($userrole,array(1,3,4,5,6,7,8,11,12,14,15,37))){ ?>
				<li class="treeview">
					<a href="#"><i class='fa fa-sitemap'></i> <span><?php echo 'अवकाश पर कार्यवाही'; //$this->lang->line('leave_action_on_employee'); ?></span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<?php if((in_array(7, explode(',', $current_emp_section_id ))) &&  (in_array($userrole, array(1,3,4)))){ ?>
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'leave_approve') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url(); ?>leave/leave_approve" data-original-title="Approve Leaves" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('approve_leave_manue'); ?></span> <span class="badge"><?php echo $aproval_count; ?></span></a>
						</li>
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'approve_list') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url(); ?>leave/approve_list" data-original-title="Cancel approved leaves" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span>  
							<?php echo $this->lang->line('action_taken_approve_list') ; ?></span></a> 
						</li>
						<?php } ?>
						<?php if(get_under_recommender_employees_list()){ ?>
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'leave_recomend') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url(); ?>leave/leave_recomend" data-original-title="Recomend Leaves" data-toggle="tooltip"> <i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('leave_emp_recomend_manue'); ?></span> <span class="badge"><?php echo $recomend_count; ?></span></a> 
						</li> 
						<?php } ?>
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'leave_forward') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url(); ?>leave/leave_forward" data-original-title="Forward Leaves" data-toggle="tooltip"> <i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('leave_emp_forword_manue'); ?></span> <span class="badge"><?php echo $forword_count; ?></span></a> 
						</li> 
						<?php if((in_array(7, explode(',', $current_emp_section_id ))) &&  (in_array($userrole, array(4)))){ ?>
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'leave_forward') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url(); ?>leave/leave_forward?lvl=all" data-original-title="Forward leaves of employees" data-toggle="tooltip"> <i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('leave_emp_forword_manue'); ?> सभी कर्मचारी</span></a>
						</li>
						<?php } ?>
						
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'approve_deny_so') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url(); ?>leave/approve_deny_so" data-original-title="Cancel forwarded leaves" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span>  
							<?php echo $this->lang->line('action_taken_forwadred_list') ; ?></span></a> 
						</li>
					
						<?php  if ((in_array(7, explode(',',$current_emp_section_id )) && $userrole == 8) || $userrole == 1 ){?>
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'approve_list') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url('leave'); ?>/approve_list" data-original-title="Modification in approved leave" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('approved_leave_modify'); ?></span></a>
						</li>
						
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'employee_list') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url('leave'); ?>/employee_list" data-original-title="Update employee leave balance" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('employee_leave_change_menu'); ?></span></a>
						</li>
						
						<?php } ?>
						<li <?php if ($this->uri->segment(1) == 'outof_department_report' && $this->uri->segment(2) == 'add_report') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url(); ?>outof_department_report/approve_deny" data-original-title="Out of department notification" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('outof_dept_menu'); ?> </span></a>
						</li>
					</ul>
				</li> 
				<?php  if ((in_array(7, explode(',',$current_emp_section_id )) && $userrole == 8) ){?>
				<li> <?php $count_efiles = json_decode(modules::run('oder_sing/ajax_count_inbox', true),true);?>
                    <a href="<?php echo base_url(); ?>oder_sing/sign_order" data-original-title="Sign" data-toggle="tooltip"><i class="fa fa-edit text-aqua"></i> <span>फ़ाइल पर हस्ताक्षर जोड़ें  </span><span class="label label-primary pull-right" id="total_eworking"><?php if(isset($count_efiles) && !empty($count_efiles)){echo $count_efiles[0][0];}else{ echo 0;}?></span></a> 
                </li>
				<?php } ?>
				<?php } ?>
				<li class="treeview">
					<a href="#"><i class='fa fa-sitemap'></i> <span><?php echo $this->lang->line('leaves').' '.$this->lang->line('reports_label'); ?></span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == '') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url('leave'); ?>/" data-original-title="View Leaves" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('view_leave'); ?> </span></a>
						</li>
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'leave_today') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url('leave'); ?>/leave_today" data-original-title="On leave today" data-toggle="tooltip"> <i class='fa fa-external-link'></i> <span> <?php echo $this->lang->line('leave_today_button'); ?></span></a>
						</li>
						<li <?php if ($this->uri->segment(1) == 'joining_report' && $this->uri->segment(2) == '') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url(); ?>joining_report" data-original-title="Joining report" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('joining_report_menu'); ?> </span></a>
						</li>
						<li <?php if ($this->uri->segment(1) == 'outof_department_report' && $this->uri->segment(2) == '') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url(); ?>outof_department_report" data-original-title="Out of department notification report" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('outof_dept_menu'); ?> </span></a>
						</li>
						<?php if (in_array($userrole,array(1,3,4,5,6,7,8,11,12,14,15,37,13,25))) { ?>
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'leave_report') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url('leave'); ?>/leave_report" data-original-title="Leave Reports" data-toggle="tooltip"> <i class='fa fa-external-link'></i> <span> <?php echo $this->lang->line('leave_report'); ?></span></a>
						</li>
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'employee_list') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url('leave'); ?>/employee_list" data-original-title="Employee leave List" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('view_all_employee'); ?></span></a>
						</li>
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'under_employees') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url('leave'); ?>/under_employees" data-original-title="All Employee list" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span> <?php echo $this->lang->line('under_employee_lists_menu'); ?></span></a>
						</li>
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'approve_deny_so') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url(); ?>leave/approve_deny_so" data-original-title="Forwarded leave report" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span>  
							<?php echo $this->lang->line('action_taken_forwadred_list_report') ; ?></span></a> 
						</li>
						<?php } ?>
						<?php if (in_array($userrole, array(1,3,4,5)) ){?>
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'department_structure') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url('admin');?>/department_structure" data-original-title="Department Structure" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('department_structure'); ?></span></a>
						</li> 
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'user_activity') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url(); ?>user_activity" data-original-title="User Activity" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span>  <?php echo $this->lang->line('user_activity_menu'); ?></span></i></a>
						</li> 
						<?php } ?>
						<?php  if ((in_array(7, explode(',',$current_emp_section_id )) && $userrole == 8) || $userrole == 1 || $userrole == 11 ){?>
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'leave_levels') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url('admin'); ?>/leave_levels" data-original-title="User leave level" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('leave_level_manage_master'); ?></span></a>
						</li>						
						<?php } ?>
						<?php if(enable_order_gen($current_emp_id) == true || ((in_array(7, explode(',', $current_emp_section_id ))) &&  (in_array($userrole, array(1,3,4,8,11))))) { ?>
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'employee_list') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url('leave'); ?>/employee_list" data-original-title="Update employee leave balance" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('employee_leave_change_menu'); ?></span></a>
						</li> 
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'approve_list') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url(); ?>leave/approve_list" data-original-title="Approved leave report" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span>  
							<?php echo $this->lang->line('action_taken_approve_list_report') ; ?></span></a> 
						</li>
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'leave_order') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url('leave'); ?>/leave_order/0" data-original-title="Leave Order" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('order_list_menu'); ?></span></a>
						</li>
						<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == 'applications') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url('leave'); ?>/applications/0" data-original-title="Leave Application" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('application_lists_menu'); ?></span></a>
						</li>
						<?php } ?>						
						<li <?php if ($this->uri->segment(1) == 'unis_bio_report' && $this->uri->segment(2) == '') { echo 'class="active"'; } ?>>
							<a href="<?php echo base_url(); ?>unis_bio_report" data-original-title="Bio-Metric Report" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span> <?php echo $this->lang->line('biometric_report_menu'); ?></span></a>
						</li>						
					</ul>
				</li>
           
           <?php   	/*if ($userrole == 1) {  ?>
		   	<li class="header bg-aqua">एडमिन</li>
				<li <?php if ($this->uri->segment(2) == 'employees') { echo 'class="active"';}?>>
					<a href="<?php echo base_url('admin'); ?>/employees"><i class="fa fa-users"></i> <span>  <span><?php echo $this->lang->line('employee_list_menu'); ?></span></a>
				</li> 
				
				<li class="treeview">
					<a href="#"><i class='fa fa-sitemap'></i> <span>Masters</span> <i class="fa fa-angle-left pull-right"></i></a>
					<ul class="treeview-menu">
						<li><a href="<?php echo base_url('admin'); ?>/department"><?php echo $this->lang->line('department_manue'); ?></a></li>
						<li><a href="<?php echo base_url('admin'); ?>/district"><?php echo $this->lang->line('district_manue'); ?></a></li>
						<li><a href="<?php echo base_url('admin'); ?>/employeerole"><?php echo $this->lang->line('employee_role_manue'); ?></a></li>
						<li><a href="<?php echo base_url('admin'); ?>/sections"><?php echo $this->lang->line('sections_role_manue'); ?></a></li>
						<li><a href="<?php echo base_url('admin'); ?>/unit"><?php echo $this->lang->line('unit_level_manue'); ?></a></li>
						<li><a href="<?php echo base_url('admin'); ?>/employee_otherwork"><?php echo $this->lang->line('emp_other_work_title_manu'); ?></a></li>
						<li><a href="<?php echo base_url('admin'); ?>/notesheet_master_menu"><?php echo $this->lang->line('notesheet_title_type_manu'); ?></a></li>
						<li><a href="<?php echo base_url('admin'); ?>/notesheets"><?php echo $this->lang->line('notesheet_title_manu'); ?></a></li>
						<li><a href="<?php echo base_url('admin'); ?>/department_posts"><?php echo $this->lang->line('department_post_master_menu_list'); ?></a></li>
						<li><a href="<?php echo base_url('admin'); ?>/leave_levels"><?php echo $this->lang->line('leave_level_manage_master'); ?></a></li>
					</ul>
				</li>
				<li <?php if ($this->uri->segment(2) == 'notice') { echo 'class="active"';}?>>
					<a href="<?php echo base_url('admin'); ?>/notice" data-original-title="Notice" data-toggle="tooltip"><i class="fa fa-calendar-o"></i> <span> <?php echo $this->lang->line('notice_menu'); ?> </span></a>
				 </li>
				 					 
			 } */?>
           
        </ul><!-- /.sidebar-menu -->
        <?php } ?>
		
		
    </section>
    <!-- /.sidebar -->
</aside>