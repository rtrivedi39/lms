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
            <li class="header bg-red"><span class="pull-left">मेनू </span> <span id="counter" class="pull-right"></span></li>
              <!-- Optionally, you can add icons to the links -->
              <li <?php if ($this->uri->segment(1) == 'dashboard') { echo 'class="active"'; } ?>>
				<a href="<?php echo base_url('dashboard'); ?>" data-original-title="Dashboard" data-toggle="tooltip"><i class="fa fa-dashboard"></i> <span> <?php echo $this->lang->line('dashboard_menu'); ?> </span></a>
              </li>
			  <li <?php if ($this->uri->segment(1) == 'site_map') { echo 'class="active"'; } ?>>
				<a href="<?php echo base_url('site_map'); ?>" data-original-title="Dashboard" data-toggle="tooltip"><i class="fa fa-sitemap"></i> <span> <?php echo $this->lang->line('site_map_menu'); ?> </span></a>
              </li>
			  
			  <li class="header bg-aqua">अवकाश</li>	
				<li <?php if ($this->uri->segment(1) == 'site_map' && $this->uri->segment(2) == 'leaves' ){ echo 'class="active"';  } ?>>
					<a href="<?php echo base_url('site_map'); ?>/leaves" data-original-title="Leave " data-toggle="tooltip"><i class='fa fa-link'></i> <span> <?php echo $this->lang->line('appication_label'); ?></span></a>
				</li>
				<li <?php if ($this->uri->segment(2) == 'add_leave') { echo 'class="active"'; } ?>>
					<a href="<?php echo base_url('leave'); ?>/add_leave" data-original-title="Apply Leave" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('apply_leave'); ?></span></a>
				</li>  
				<li <?php if ($this->uri->segment(1) == 'leave' && $this->uri->segment(2) == '') { echo 'class="active"'; } ?>>
					<a href="<?php echo base_url('leave'); ?>/" data-original-title="View Leaves" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('view_leave'); ?> </span></a>
				</li>  
				<?php if(in_array($userrole,array(1,3,4,5,6,7,8,11,12,14,15,37))){ ?>
				<li <?php if ($this->uri->segment(1) == 'site_map' && $this->uri->segment(2) == 'leave_action' ){ echo 'class="active"';  } ?>>
					<a href="<?php echo base_url('site_map'); ?>/leave_action" data-original-title="Leave Forward / Apporve" data-toggle="tooltip"><i class='fa fa-link'></i> <span> <?php echo $this->lang->line('leave_action_on_employee'); ?></span></a>
				</li>
				<?php } ?>
				<li <?php if ($this->uri->segment(1) == 'site_map' && $this->uri->segment(2) == 'leave_report' ){ echo 'class="active"';  } ?> >
					<a href="<?php echo base_url('site_map'); ?>/leave_report" data-original-title="Leave report" data-toggle="tooltip"><i class='fa fa-link'></i> <span> <?php echo $this->lang->line('leaves').' '.$this->lang->line('reports_label'); ?> </span></a>
				</li>
				
				
            <?php /* if (in_array($userrole,array(13,25))) { ?>
                 <li <?php if ($this->uri->segment(2) == 'employee_search') { echo 'class="active"'; } ?>>
                    <a href="<?php echo base_url(); ?>leave/employee_search" data-original-title="Employee Leave apply/ Leave Deduction" data-toggle="tooltip"><i class='fa fa-link'></i> <span>  <?php echo $this->lang->line('leave_employee'); ?></span></a> 
                 </li>
            <?php } ?> 
			<?php if((in_array(7, explode(',', $current_emp_section_id ))) &&  (in_array($userrole, array(1,3,4)))){ ?>
                <li <?php if ($this->uri->segment(2) == 'leave_approve') { echo 'class="active"'; } ?>>
                    <a href="<?php echo base_url(); ?>leave/leave_approve" data-original-title="Leave Approve" data-toggle="tooltip"><i class='fa fa-link'></i> <span>  <?php echo $this->lang->line('approve_leave_manue'); ?></span> <span class="label pull-right bg-red"><?php echo $aproval_count; ?></span></a>
                </li>
            <?php } ?>			
            <?php if (in_array($userrole,array(1,3,4,5,6,7,8,11,12,14,15,37))) { ?>
                <li <?php if ($this->uri->segment(2) == 'leave_forward') { echo 'class="active"'; } ?>>
                    <a href="<?php echo base_url(); ?>leave/leave_forward" data-original-title="Leave Forward" data-toggle="tooltip"> <i class='fa fa-link'></i> <span>  <?php echo $this->lang->line('leave_emp_forword_manue'); ?></span> <span class="label pull-right bg-red"><?php echo $forword_count; ?></span></a> 
                </li>
				<li <?php if ($this->uri->segment(2) == 'employee_search') { echo 'class="active"'; } ?>>
                    <a href="<?php echo base_url(); ?>leave/employee_search" data-original-title="Employee Leave apply/ Leave Deduction" data-toggle="tooltip"><i class='fa fa-link'></i> <span>  <?php echo $this->lang->line('leave_employee'); ?></span></a> 
                <li class="header bg-aqua">रिपोर्ट</li>	
				<li <?php if ($this->uri->segment(2) == 'leave_report') { echo 'class="active"'; } ?>>
                    <a href="<?php echo base_url('leave'); ?>/leave_report" data-original-title="Leave Reports" data-toggle="tooltip"> <i class='fa fa-link'></i> <span> <?php echo $this->lang->line('leave_report'); ?></span></a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'leave_today') { echo 'class="active"'; } ?>>
                    <a href="<?php echo base_url('leave'); ?>/leave_today" data-original-title="Leave on today" data-toggle="tooltip"> <i class='fa fa-link'></i> <span> <?php echo $this->lang->line('leave_today_button'); ?></span></a>
                </li>
                <li <?php if (($this->uri->segment(2) == 'employee_list')  OR ($this->uri->segment(2) == 'leave_details')) { echo 'class="active"'; } ?>>
                    <a href="<?php echo base_url('leave'); ?>/employee_list" data-original-title="Employee leave List" data-toggle="tooltip"><i class='fa fa-link'></i> <span><?php echo $this->lang->line('view_all_employee'); ?></span></a>
                </li>
				
            <?php } ?>
            <?php if ($userrole == 11) { ?>
                <li <?php if ($this->uri->segment(2) == 'leave_forward') { echo 'class="active"'; } ?>>
                    <a href="<?php echo base_url(); ?>leave/leave_forward" data-original-title="Leave Recommend" data-toggle="tooltip"><i class='fa fa-link'></i> <span>  <?php echo $this->lang->line('recommend_leave_manue'); ?></span></a>
                </li>
            <?php } ?>
           
            <?php if (in_array($userrole, array(1,3,4,5)) ){?>
                <li <?php if ($this->uri->segment(1) == 'user_activity' OR $this->uri->segment(1) == 'activity_details') { echo 'class="active"'; } ?>>
                    <a href="<?php echo base_url(); ?>user_activity" data-original-title="User Activity" data-toggle="tooltip"><i class='fa fa-link'></i> <span>  <?php echo $this->lang->line('user_activity_menu'); ?></span></i></a>
                </li>
                <li <?php if ($this->uri->segment(2) == 'department_structure') { echo 'class="active"'; } ?>>
                    <a href="<?php echo base_url('admin');?>/department_structure" data-original-title="Department Structure" data-toggle="tooltip"><i class="fa fa-tree"></i> <span><?php echo $this->lang->line('department_structure'); ?></span></a>
                </li>
            <?php } ?>
			<?php  if ((in_array(7, explode(',',$current_emp_section_id )) && $userrole == 8) || $userrole == 1 || $userrole == 11 ){?>
                <li <?php if ($this->uri->segment(2) == 'leave_levels') { echo 'class="active"'; } ?>>
					<a href="<?php echo base_url('admin'); ?>/leave_levels" data-original-title="User leave level" data-toggle="tooltip"><i class="fa fa-link"></i> <span><?php echo $this->lang->line('leave_level_manage_master'); ?></span></a>
				</li>
				<li <?php if ($this->uri->segment(2) == 'approve_list') { echo 'class="active"'; } ?>>
					<a href="<?php echo base_url('leave'); ?>/approve_list" data-original-title="Approved leave Modify" data-toggle="tooltip"><i class="fa fa-link"></i> <span><?php echo $this->lang->line('approved_leave_modify'); ?></span></a>
				</li>
				<li <?php if ($this->uri->segment(2) == 'under_employees') { echo 'class="active"'; } ?>>
					<a href="<?php echo base_url('leave'); ?>/under_employees" data-original-title="All Employee list" data-toggle="tooltip"><i class="fa fa-link"></i> <span> <?php echo $this->lang->line('under_employee_lists_menu'); ?></span></a>
				</li>
				<li <?php if ($this->uri->segment(2) == 'leave_order') { echo 'class="active"'; } ?>>
					<a href="<?php echo base_url('leave'); ?>/leave_order/0" data-original-title="Leave Order" data-toggle="tooltip"><i class="fa fa-link"></i> <span><?php echo $this->lang->line('order_list_menu'); ?></span></a>
				</li>
				<li <?php if ($this->uri->segment(2) == 'applications') { echo 'class="active"'; } ?>>
					<a href="<?php echo base_url('leave'); ?>/applications/0" data-original-title="Leave Application" data-toggle="tooltip"><i class="fa fa-link"></i> <span><?php echo $this->lang->line('application_lists_menu'); ?></span></a>
				</li>
            <?php }  ?>
			  <li <?php if ($this->uri->segment(1) == 'biometric_report') { echo 'class="active"';}?>>
				<a href="<?php echo base_url(); ?>biometric_report" data-original-title="Bio-Metric Report" data-toggle="tooltip"><i class="fa fa-file-o"></i> <span> <?php echo $this->lang->line('biometric_report_menu'); ?></span></a>
			  </li>	
			  <li <?php if ($this->uri->segment(1) == 'joining_report') { echo 'class="active"';}?>>
				<a href="<?php echo base_url(); ?>joining_report" data-original-title="Joining report" data-toggle="tooltip"><i class="fa fa-file-o"></i> <span><?php echo $this->lang->line('joining_report_menu'); ?> </span></a>
			  </li>	 
			  <li <?php if ($this->uri->segment(1) == 'outof_department_report') { echo 'class="active"';}?>>
				<a href="<?php echo base_url(); ?>outof_department_report" data-original-title="Out of Department report" data-toggle="tooltip"><i class="fa fa-file-o"></i> <span><?php echo $this->lang->line('outof_dept_menu'); ?> </span></a>
			  </li>	
			<?php if(enable_order_gen($current_emp_id) == true) { ?>
				<li <?php if ($this->uri->segment(2) == 'leave_order') { echo 'class="active"'; } ?>>
					<a href="<?php echo base_url('leave'); ?>/leave_order/0" data-original-title="Leave Order" data-toggle="tooltip"><i class="fa fa-link"></i> <span><?php echo $this->lang->line('order_list_menu'); ?></span></a>
				</li>
				<li <?php if ($this->uri->segment(2) == 'applications') { echo 'class="active"'; } ?>>
					<a href="<?php echo base_url('leave'); ?>/applications/0" data-original-title="Leave Application" data-toggle="tooltip"><i class="fa fa-link"></i> <span><?php echo $this->lang->line('application_lists_menu'); ?></span></a>
				</li>
			<?php } */?>
           <?php if ($userrole == 1) {  ?>
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
			<?php } ?>
           
        </ul><!-- /.sidebar-menu -->
        <?php } ?>
		
		
    </section>
    <!-- /.sidebar -->
</aside>