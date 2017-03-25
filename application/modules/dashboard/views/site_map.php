<section class="content-header">
    <h1>
        <?php echo $title; ?>
    </h1>
	<ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i><?php echo $this->lang->line('dashboard_menu') ?></a></li>
        <li class="active"><?php echo $title_tab; ?></li>
    </ol>
</section>

<!-- Main content -->
<section class="content" id="site_map_page">
	<!-- /dashoboard - map -->
    <div class="row">
		<div class="col-md-12">
			<div class="box box-primary box-solid" id="dashboard">
				<div class="box-header with-border">
				  <h3 class="box-title"><?php echo $this->lang->line('dashboard_menu') ?></h3>
				  <div class="box-tools pull-right">
					<button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
				  </div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body">
					<a href="<?php echo base_url(); ?>dashboard" data-original-title="Dashboard" data-toggle="tooltip"><i class="fa fa-external-link"></i>  <span><?php echo $this->lang->line('dashboard_menu') ?></span></a>
				</div><!-- /.box-body -->
			</div>
		</div>
	</div><!-- /.row -->
	<?php if ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'leaves' ){ ?>
	<!-- /leave - map -->
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary box-solid" id="leaves">
				<div class="box-header with-border">
				  <h3 class="box-title"><?php echo $this->lang->line('appication_label') ?></h3>
				  <div class="box-tools pull-right">
					<button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
				  </div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row">
						<div class="col-md-3">
							<a href="<?php echo base_url('leave'); ?>/add_leave" data-original-title="Apply Leave" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('apply_leave'); ?></span></a>
						</div>
						<?php if (in_array($userrole,array(1,3,4,5,6,7,8,11,12,14,15,37,13,25))) { ?>
						<div class="col-md-3">
							<a href="<?php echo base_url(); ?>leave/employee_search" data-original-title="Apply leave for employee" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span>  
							<?php echo $this->lang->line('leave_employee') ; ?> <?php echo (in_array(7, explode(',',$current_emp_section_id )) && $userrole == 8) ?  '/'.$this->lang->line('leave_employee_deduction') : ''; ?></span></a> 
						</div>
						<?php } ?>
						<div class="col-md-3">
							<a href="<?php echo base_url(); ?>joining_report/add_report" data-original-title="Application for Joining report" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('joining_report_application_menu'); ?> </span></a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo base_url(); ?>outof_department_report/add_report" data-original-title="Out of department notification" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('outof_dept_application_menu'); ?> </span></a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo base_url('leave'); ?>/" data-original-title="View Leaves" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('view_leave'); ?> </span></a>
						</div>
					</div>
				</div><!-- /.box-body -->
			</div>
		</div>
	</div><!-- /.row -->
	<?php } ?>
	<?php if (($this->uri->segment(2) == '' || $this->uri->segment(2) == 'leave_action' ) && (in_array($userrole,array(1,3,4,5,6,7,8,11,12,14,15,37)))){ ?>
	<!-- /leave - map -->
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary box-solid" id="leave_action">
				<div class="box-header with-border">
				  <h3 class="box-title"><?php echo $this->lang->line('leave_action_on_employee') ?></h3>
				  <div class="box-tools pull-right">
					<button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
				  </div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row">
						<?php if((in_array(7, explode(',', $current_emp_section_id ))) &&  (in_array($userrole, array(1,3,4)))){ ?>
						<div class="col-md-3">
							<a href="<?php echo base_url(); ?>leave/leave_approve" data-original-title="Approve Leaves" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('approve_leave_manue'); ?></span> <span class="badge"><?php echo $aproval_count; ?></span></a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo base_url(); ?>leave/approve_list" data-original-title="Cancel approved leaves" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span>  
							<?php echo $this->lang->line('action_taken_approve_list') ; ?></span></a> 
						</div>
						<?php } ?>
						<?php if(get_under_recommender_employees_list()){ ?>
						<div class="col-md-3">						
							<a href="<?php echo base_url(); ?>leave/leave_recomend" data-original-title="Recomend Leaves" data-toggle="tooltip"> <i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('leave_emp_recomend_manue'); ?></span> <span class="badge"><?php echo $recomend_count; ?></span></a> 
						</div> 
						<?php } ?>
						<div class="col-md-3">
							<a href="<?php echo base_url(); ?>leave/leave_forward" data-original-title="Forward Leaves" data-toggle="tooltip"> <i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('leave_emp_forword_manue'); ?></span> <span class="badge"><?php echo $forword_count; ?></span></a> 
						</div>
						<?php if((in_array(7, explode(',', $current_emp_section_id ))) &&  (in_array($userrole, array(4)))){ ?>
						<div class="col-md-3">
							<a href="<?php echo base_url(); ?>leave/leave_forward?lvl=all" data-original-title="Forward leaves all employees" data-toggle="tooltip"> <i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('leave_emp_forword_manue'); ?> सभी कर्मचारी</span></a> 
						</div>
						<?php } ?>					
						<div class="col-md-3">
							<a href="<?php echo base_url(); ?>leave/approve_deny_so" data-original-title="Cancel forwarded leaves" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span>  
							<?php echo $this->lang->line('action_taken_forwadred_list') ; ?></span></a> 
						</div>
					
						<?php  if ((in_array(7, explode(',',$current_emp_section_id )) && $userrole == 8) || $userrole == 1 ){?>
						<div class="col-md-3">
							<a href="<?php echo base_url('leave'); ?>/approve_list" data-original-title="Modification in approved leave" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('approved_leave_modify'); ?></span></a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo base_url('leave'); ?>/employee_list" data-original-title="Update employee leave balance" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('employee_leave_change_menu'); ?></span></a>
						</div>
						<?php } ?>
						<div class="col-md-3">
							<a href="<?php echo base_url(); ?>outof_department_report/approve_deny" data-original-title="Out of department notification" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('outof_dept_menu'); ?> </span></a>
						</div>
					</div>
				</div><!-- /.box-body -->
			</div>
		</div>
	</div><!-- /.row -->
	<?php } ?>	
	<?php if ($this->uri->segment(2) == '' || $this->uri->segment(2) == 'leave_report' ){ ?>
	<!-- /leave report - map -->
	<div class="row">
		<div class="col-md-12">
			<div class="box box-primary box-solid" id="leave_report">
				<div class="box-header with-border">
				  <h3 class="box-title"><?php echo $this->lang->line('leaves').' '.$this->lang->line('reports_label'); ?></h3>
				  <div class="box-tools pull-right">
					<button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-minus"></i></button>
				  </div><!-- /.box-tools -->
				</div><!-- /.box-header -->
				<div class="box-body">
					<div class="row">
						<div class="col-md-3">
							<a href="<?php echo base_url('leave'); ?>/" data-original-title="View Leaves" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('view_leave'); ?> </span></a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo base_url('leave'); ?>/leave_today" data-original-title="On leave today" data-toggle="tooltip"> <i class='fa fa-external-link'></i> <span> <?php echo $this->lang->line('leave_today_button'); ?></span></a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo base_url(); ?>joining_report" data-original-title="Joining report" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('joining_report_menu'); ?> </span></a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo base_url(); ?>outof_department_report" data-original-title="Out of department notification report" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('outof_dept_menu'); ?> </span></a>
						</div>
						<?php if (in_array($userrole,array(1,3,4,5,6,7,8,11,12,14,15,37,13,25))) { ?>
						<div class="col-md-3">
							<a href="<?php echo base_url('leave'); ?>/leave_report" data-original-title="Leave Reports" data-toggle="tooltip"> <i class='fa fa-external-link'></i> <span> <?php echo $this->lang->line('leave_report'); ?></span></a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo base_url('leave'); ?>/employee_list" data-original-title="Employee leave List" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span><?php echo $this->lang->line('view_all_employee'); ?></span></a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo base_url('leave'); ?>/under_employees" data-original-title="All Employee list" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span> <?php echo $this->lang->line('under_employee_lists_menu'); ?></span></a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo base_url(); ?>leave/approve_deny_so" data-original-title="Forwarded leave report" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span>  
							<?php echo $this->lang->line('action_taken_forwadred_list_report') ; ?></span></a> 
						</div>
						<?php } ?>
						<?php if (in_array($userrole, array(1,3,4,5)) ){?>
						<div class="col-md-3">
							<a href="<?php echo base_url('admin');?>/department_structure" data-original-title="Department Structure" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('department_structure'); ?></span></a>
						</div> 
						<div class="col-md-3">
							<a href="<?php echo base_url(); ?>user_activity" data-original-title="User Activity" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span>  <?php echo $this->lang->line('user_activity_menu'); ?></span></i></a>
						</div> 
						<?php } ?>
						<?php  if ((in_array(7, explode(',',$current_emp_section_id )) && $userrole == 8) || $userrole == 1 || $userrole == 11 ){?>
						<div class="col-md-3">
							<a href="<?php echo base_url('admin'); ?>/leave_levels" data-original-title="User leave level" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('leave_level_manage_master'); ?></span></a>
						</div>						
						<?php } ?>
						<?php if(enable_order_gen($current_emp_id) == true || ((in_array(7, explode(',', $current_emp_section_id ))) &&  (in_array($userrole, array(1,3,4,8,11))))) { ?>
						<div class="col-md-3">
							<a href="<?php echo base_url(); ?>leave/approve_list" data-original-title="Approved leave report" data-toggle="tooltip"><i class='fa fa-external-link'></i> <span>  
							<?php echo $this->lang->line('action_taken_approve_list_report') ; ?></span></a> 
						</div>
						<div class="col-md-3">
							<a href="<?php echo base_url('leave'); ?>/leave_order/0" data-original-title="Leave Order" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('order_list_menu'); ?></span></a>
						</div>
						<div class="col-md-3">
							<a href="<?php echo base_url('leave'); ?>/applications/0" data-original-title="Leave Application" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span><?php echo $this->lang->line('application_lists_menu'); ?></span></a>
						</div>
						<?php } ?>
						<?php if ((in_array(7, explode(',', $current_emp_section_id ))) &&  (in_array($userrole, array(1,3,4,8,11)))) {?>
						<div class="col-md-3">
							<a href="<?php echo base_url(); ?>unis_bio_report" data-original-title="Bio-Metric Report" data-toggle="tooltip"><i class="fa fa-external-link"></i> <span> <?php echo $this->lang->line('biometric_report_menu'); ?></span></a>
						</div>
						<?php } ?>
					</div>
				</div><!-- /.box-body -->
			</div>
		</div>
	</div><!-- /.row -->
	<?php } ?>
</section><!-- /.content -->





