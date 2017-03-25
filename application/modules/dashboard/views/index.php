<?php  $today = date('Y-m-d'); ?>
<section class="content-header">
    <h1>
        <?php echo $this->lang->line('title') ?>
    </h1>
</section>

<!-- Main content -->
<section class="content">
	<div class="row">
		<?php if((in_array(7, explode(',', $current_emp_section_id ))) &&  (in_array($current_emp_role_id, array(1,3,4)))) { ?>
			<a href="<?php echo base_url(); ?>leave/leave_approve">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="small-box bg-green">
						<div class="inner">
							<h3><?php echo $aproval_count;  ?></h3>
							<p><?php echo $this->lang->line('leave_label').' '.$this->lang->line('leave_approval_label'); ?></p>
						</div>
						<div class="icon">
							<i class="fa fa-users"></i>
						</div>
					</div>
				</div>
			</a>		
		<?php }

		 if(get_under_recommender_employees_list()){ ?>
			<a href="<?php echo base_url(); ?>leave/leave_recomend">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="small-box bg-blue">
						<div class="inner">
							<h3><?php echo $recomend_count;  ?></h3>
							<p><?php echo $this->lang->line('leave_emp_recomend_manue'); ?></p>
						</div>
						<div class="icon">
							<i class="fa fa-users"></i>
						</div>
					</div>
				</div>
			</a>
		<?php } 

		  if(in_array($current_emp_role_id,array(1,3,4,5,6,7,8,11,12,14,15,37))){ ?>
			<a href="<?php echo base_url(); ?>leave/leave_forward">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="small-box bg-yellow">
						<div class="inner">
							<h3><?php echo $forword_count; ?></h3>
							<p><?php echo $this->lang->line('leave_forward_label'); ?></p>
						</div>
						<div class="icon">
							<i class="fa fa-users"></i>
						</div>
					</div>
				</div>
			</a>
	<?php if((in_array(7, explode(',', $current_emp_section_id ))) &&  (in_array($current_emp_role_id, array(4)))) { ?>
			<a href="<?php echo base_url('leave'); ?>/leave_forward?lvl=all">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="small-box bg-red">
						<div class="inner">
							<h3><?php echo $forword_count_all; ?></h3>
							<p><?php echo $this->lang->line('leave_forward_label'); ?> सभी कर्मचारी</p>
						</div>
						<div class="icon">
							<i class="fa fa-users"></i>
						</div>
					</div>
				</div>
			</a>
			
		<?php } else { ?>
			<a href="<?php echo base_url('site_map'); ?>/leave_action">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="small-box bg-red">
						<div class="inner">
							<h3><?php echo $this->lang->line('leave_label'); ?></h3>
							<p><?php echo $this->lang->line('leave_action_on_employee'); ?></p>
						</div>
						<div class="icon">
							<i class="fa fa-users"></i>
						</div>
					</div>
				</div>
			</a>

		<?php } ?>
		
		<?php } ?>
		<?php if(!in_array($current_emp_role_id, array(1,3,4))) { ?>
			<a href="<?php echo base_url('site_map'); ?>/leaves">
				<div class="col-md-3 col-sm-6 col-xs-12">
					<div class="small-box bg-aqua">
						<div class="inner">
							<h3><?php echo $this->lang->line('appication_label'); ?></h3>
							<p><?php echo $this->lang->line('leave_apply_label'); ?></p>
						</div>
						<div class="icon">
							<i class="fa fa-users"></i>
						</div>
					</div>
				</div>
			</a>
		<?php } ?>
		<a href="<?php echo base_url('site_map'); ?>/leave_report">
			<div class="col-md-3 col-sm-6 col-xs-12">
				<div class="small-box bg-green">
					<div class="inner">
						<h3><?php echo $this->lang->line('reports_label'); ?></h3>
						<p><?php echo $this->lang->line('leave_report_view_label'); ?></p>
					</div>
					<div class="icon">
						<i class="fa fa-file-text-o"></i>
					</div>
				</div>
			</div>
		</a>		
	</div>
	<div class="row">
		<div class="col-md-12">
		 <!-- TO DO List -->
			<div class="box box-primary collapsed-box box-solid">
				<div class="box-header">
				  <i class="ion ion-clipboard"></i>
				  <h3 class="box-title"><?php echo $this->lang->line('today_activity_label'); ?></h3>
				  <div class="box-tools pull-right">
						<button data-widget="collapse" class="btn btn-box-tool"><i class="fa fa-plus"></i></button>
				  </div>
				</div><!-- /.box-header -->
				<div class="box-body">
					<ul class="todo-list">
						<?php $user_todo = get_list(LEAVE_MOVEMENT,
						'emp_leave_create_date',
						"(date(emp_leave_create_date) = '$today' or date(emp_leave_forword_date) = '$today' or date(emp_leave_approvel_date) = '$today' )
						and (emp_id = '$current_emp_id' or emp_leave_forword_emp_id = '$current_emp_id' or emp_leave_approval_emp_id = '$current_emp_id')",
						'DESC');
						$message = ''; $time = $today;
						foreach($user_todo as $key => $todo) {
							//pre($todo['emp_leave_create_date']);
							$leave_type = leaveType($todo['emp_leave_type'], true);
							$leave_from = get_date_formate($todo['emp_leave_date']);
							$leave_to = get_date_formate($todo['emp_leave_end_date']);
							$leave_days = $todo['emp_leave_no_of_days'];
							?>
						<li>
							<?php
							if(date('Y-m-d', strtotime($todo['emp_leave_create_date'])) == $today && $todo['emp_id'] == $current_emp_id){
								$message = 'आपके द्वारा दिनांक <b>'.$leave_from.'</b> से <b>'.$leave_to.'</b> तक <b>'.$leave_days.'</b> दिन का <b>'. $leave_type .'</b> का आवेदन किया गया|' ;
								$time = get_datetime_formate($todo['emp_leave_create_date']);
							} else if(date('Y-m-d', strtotime($todo['emp_leave_forword_date'])) == $today && $todo['emp_leave_forword_emp_id'] == $current_emp_id){
								$message = 'आपके द्वारा दिनांक <b>'.$leave_from.'</b> से <b>'.$leave_to.'</b> तक <b>'.$leave_days.'</b> दिन का <b>'. $leave_type .'</b> <a href="'.base_url('leave')."/leave_details/".$todo['emp_id'] .'">'.getemployeeName($todo['emp_id'], true).'</a>  के आवेदन पर कार्यवाही की|' ;
								$time = get_datetime_formate($todo['emp_leave_forword_date']);
							} else if(date('Y-m-d', strtotime($todo['emp_leave_approvel_date'])) == $today && $todo['emp_leave_approval_emp_id'] == $current_emp_id){
								$message = 'आपके द्वारा दिनांक <b>'.$leave_from.'</b> से <b>'.$leave_to.'</b> तक <b>'.$leave_days.'</b> दिन का <b>'. $leave_type .'</b> <a href="'.base_url('leave')."/leave_details/".$todo['emp_id'] .'">'.getemployeeName($todo['emp_id'], true).'</a>   के आवेदन पर कार्यवाही की|' ;
								$time = get_datetime_formate($todo['emp_leave_approvel_date']);
							} if(date('Y-m-d', strtotime($todo['emp_leave_create_date'])) == $today && $todo['on_behalf_leave'] == $current_emp_id && $todo['emp_leave_forword_emp_id']== $todo['on_behalf_leave']){
								$message = 'आपके द्वारा दिनांक <b>'.$leave_from.'</b> से <b>'.$leave_to.'</b> तक <b>'.$leave_days.'</b> दिन का <b>'. $leave_type .'</b> <a href="'.base_url('leave')."/leave_details/".$todo['emp_id'] .'">'.getemployeeName($todo['emp_id'], true).'</a>  का आवेदन  किया गया|' ;
								$time = get_datetime_formate($todo['emp_leave_create_date']);
							}
							?>
							  <!-- todo text -->
							  <span class="text"><?php echo $message ;?></span>
							  <!-- Emphasis label -->
							  <small class="label label-info"><i class="fa fa-clock-o"></i> <?php echo  $time;  ?></small>
						</li>
					<?php } ?>
					</ul>
				</div><!-- /.box-body -->
				<div class="box-footer clearfix no-border">
				</div>
			</div><!-- /.box -->
		</div>
<?php /*
		<div class="col-md-12">
		 <!-- TO DO List -->
			<div class="box box-primary">
				<div class="box-header">
					<i class="ion ion-clipboard"></i>
					<h3 class="box-title"><?php echo $this->lang->line('biometric_report_menu'); ?></h3>
					<div class="box-tools pull-right">

					</div>
				</div><!-- /.box-header -->
				<div class="box-body">
				<?php echo $this->session->flashdata('message_report'); ?>
					<div class="row">
					<form role="form" target="_blank" method="post" enctype="multipart/form-data" action="<?php echo base_url()?>biometric_report/view_report">
						<div class="col-md-3">
							<div class="form-group">
								<label for="exampleInputFile"><?php echo $this->lang->line('type_label'); ?> <span class="text-danger">*</span></label>
								<select class="form-control" name="report_type" id="report_type">
									<?php $get_report_type = get_report_type();
									foreach ($get_report_type as $id => $value) {
										$selected = (@$input_data['report_type'] != '' && $input_data['report_type'] == $id)  ? 'selected' : '';
										?>
										<option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $value;?></option>
									<?php }  ?>
								</select>
								<?php echo form_error('report_type');?>
							</div>
                         </div>
						<div class="col-md-3">
							<div class="form-group">
								<label for="exampleInputFile"><?php echo $this->lang->line('month_label'); ?> <span class="text-danger">*</span></label>
								<select class="form-control" name="report_month" id="report_month">
									<?php $month = months(null, true);
									foreach ($month as $id => $value) {
										$crnt_mnth = date('m') == 1 ? 1 : date('m') - 1;
										if($input_data['report_month'] != '' && ($input_data['report_month'] == $id) ){
											$selected = 'selected';
										} else if($crnt_mnth == $id){
											$selected = 'selected';
										} else {
											$selected = '';
										}
									?>
										<option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $value;?></option>
									<?php }  ?>
								</select>
							</div>
						</div>
						<div class="col-md-3">
							<div class="form-group" id="">
								<label for="exampleInputFile"><?php echo $this->lang->line('year_label'); ?>  <span class="text-danger">*</span></label>
								<select name="report_year" class="form-control"  id="report_year">
									<?php $i = '2015';
									while($i <= date('Y')) {
										if($input_data['report_year'] != '' && ($input_data['report_year'] == $i) ){
											$selected = 'selected';
										} else if(date('Y') == $i){
											$selected = 'selected';
										} else {
											$selected = '';
										}
									?>
										<option value="<?php echo $i ; ?>" <?php echo $selected; ?>><?php echo $i ;?></option>
									<?php $i++; } ?>
								</select>
							</div>
						</div>
						<div class="col-md-3">
								<br/>
                                <button class="btn btn-primary" type="submit" name="view_report" id="view_report" value="1"><?php echo $this->lang->line('submit_botton'); ?></button>
						</div>
					</form>
					</div><!-- /.row -->
				</div><!-- /.box-body -->
			</div><!-- /.box -->
		</div> */ ?>
	</div><!-- /.row -->
</section><!-- /.content -->





