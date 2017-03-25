<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $title; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><?php echo $title; ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Your Page Content Here -->
    <!-- Small boxes (Stat box) -->

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
					<div class="pull-left">
						<h3 class="box-title"><?php echo $title_tab; ?></h3>
						<select class=""  name="approve_list" id="approve_list" onchange="getForwordedList(this.value); ">
							<option value=""><?php echo $this->lang->line('leave_select'); ?></option>
							<option value="1"><?php echo $this->lang->line('leave_forworeded_option'); ?></option>
							<option value="2"><?php echo $this->lang->line('leave_not_forworeded_option'); ?></option>
							<option value="3"><?php echo $this->lang->line('leave_cancel'); ?></option>
						</select>
					</div>
                    <div class="form-group pull-right box-tools" >
						<button class="btn btn-warning" onclick="goBack()">पिछले पेज में वापस जायें</button>
                    </div>
                </div>
				
            <div class="box-body">
            <table id="leave_tbl" class="table table-bordered table-striped display">
                <thead>
                    <tr>
						<th><?php echo $this->lang->line('sno_label'); ?></th>
						<th><?php echo $this->lang->line('id_label'); ?></th>
                        <th><?php echo $this->lang->line('leave_emp_name') . '/' . $this->lang->line('leave_emp_designation'); ?></th>
                        <th><?php echo $this->lang->line('leave_type'); ?></th>
                        <th><?php echo $this->lang->line('leave_reason'); ?></th>
                        <th><?php echo $this->lang->line('leave_days'); ?></th>
                        <th><?php echo $this->lang->line('when_date'); ?></th>
                        <th><?php echo $this->lang->line('leave_approve_date'); ?></th>
                        <th><?php echo $this->lang->line('leave_status'); ?></th>
                        <th><?php echo $this->lang->line('leave_action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                   
                    <?php
                        $i = 1;
                            //pr($forworded_lists);
                            foreach ($forworded_lists as $key => $leave) { ?>
							<tr>
								<td><?php echo $i; ?></td>
								<td><?php echo $leave->emp_unique_id; ?></td>
								<td><a href="<?php echo base_url('leave')."/leave_details/".$leave->emp_id ?>" data-original-title="<?php echo get_employee_gender($leave->emp_detail_gender,false,false).' ' .$leave->emp_full_name ?>"  data-toggle="tooltip"><?php echo get_employee_gender($leave->emp_detail_gender,true,false).' ' .$leave->emp_full_name_hi  . '</a>/' . $leave->emprole_name_hi; ?></td>
								<td><a href="<?php echo base_url(); ?>leave/leave_log/<?php echo $leave->emp_leave_movement_id; ?>"><?php echo leaveType($leave->emp_leave_type, true) ?></a> <?php echo ($leave->emp_leave_sub_type != '' ? '('.leaveType($leave->emp_leave_sub_type, true).')' : '' );?></td>
								<td><?php echo $leave->emp_leave_reason ?></td><td><?php echo $leave->emp_leave_no_of_days; ?></td>
								<td><?php echo ($leave->emp_leave_date != '1970-01-01') ? get_date_formate($leave->emp_leave_date,'d.m.y') : '-' ?>
									to <?php echo ($leave->emp_leave_end_date != '1970-01-01') ? get_date_formate($leave->emp_leave_end_date,'d.m.Y') : '-' ?>
								  <?php  if($leave->sickness_date != $leave->emp_leave_date){
									echo strtotime($leave->sickness_date) ?
									'<span type="button" class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Sickness Certificate date '.get_date_formate($leave->sickness_date, 'd.m.Y').' and EL from '.get_date_formate($leave->emp_leave_date,'d.m.Y').' to '.date('d.m.Y',strtotime($leave->sickness_date.'-1 Day')).'">i</span>' :
									'' ; } ?>
								</td>
								<td><?php echo get_date_formate($leave->emp_leave_forword_date); ?></td>
								<?php $userrole = checkUserrole(); ?>

								<td><?php echo setForwordMessage($leave->emp_leave_forword_type); ?></td>
								<td>
									<?php if (($leave->emp_leave_forword_type != 0) ) { ?>
										<div class="btn-group  ">

										<a href="<?php echo base_url(); ?>leave/approve_deny/cancel/<?php echo $leave->emp_leave_movement_id; ?>" class="btn  btn-twitter btn-block <?php
										 if (($leave->emp_leave_approval_type != 0)|| ($leave->emp_leave_forword_type == 2)|| ($leave->emp_leave_forword_type == 3)) {
											echo "disabled";
										}
										$confirm_msg = get_employee_gender($leave->emp_detail_gender,true,false) .' '.$leave->emp_full_name_hi . '/' . $leave->emprole_name_hi.' का '.get_date_formate($leave->emp_leave_date, 'd.m.Y').' से '.get_date_formate($leave->emp_leave_end_date, 'd.m.Y') .' तक का '.leaveType($leave->emp_leave_type, true);
										?>" onclick="return confirm('आप  <?php echo $confirm_msg; ?>  रद्द करने जा रहे है| ');"> <?php echo $this->lang->line('leave_employee_cancel'); ?></a>

										</div>

									<?php } /*else { ?>
										<div class="btn-group  ">

											<a href="<?php echo base_url(); ?>leave/approve_deny_so/cancel/<?php echo $leave->emp_leave_movement_id; ?>" class="btn  btn-twitter <?php
											   if ($leave->emp_leave_approval_type != 0) {
												   echo "disabled";
											   }
											   ?> " onclick="return confirm('Are you sure?');"><?php echo $this->lang->line('leave_employee_cancel') ?></a>

										</div>
									<?php } */ ?>

								</td>

							</tr>
							<?php
                          
                            $i++;
                        } ?>
                </tbody>
            </table>


        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div>
</div><!-- /.row -->
<!-- Main row -->
</section><!-- /.content -->


<script type="text/javascript">
    function getForwordedList(str) {
        window.location = "<?php echo base_url(); ?>leave/approve_deny_so?type=" + str;
    }
</script>