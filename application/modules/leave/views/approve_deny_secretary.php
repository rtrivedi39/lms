<?php $userrole = checkUserrole(); ?>
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
            <div class="box box-warning">
                 <?php echo $this->session->flashdata('message'); ?>
                <div class="box-header">
					<div class="pull-left">
						<h3 class="box-title"><?php echo $title_tab; ?></h3> 
						<select class="" name="approve_list" id="approve_list" onchange="getapprovaLisat(this.value); ">
							<option value=""><?php echo $this->lang->line('leave_select'); ?></option>
							<option value="1"><?php echo $this->lang->line('leave_status_approve'); ?></option>
							<option value="2"><?php echo $this->lang->line('leave_status_deny'); ?></option>
							<option value="3"><?php echo $this->lang->line('leave_cancel'); ?></option>
						</select>
					</div>
					<div class="pull-right box-tools">
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
                                <th><?php echo $this->lang->line('when_date'); ?> से कब तक</th>
								<th><?php echo $this->lang->line('leave_days'); ?></th>
								<th><?php echo $this->lang->line('leave_type'); ?></th>
                                <th><?php echo $this->lang->line('leave_reason'); ?></th>
                                <th><?php echo $this->lang->line('apply_date_label'); ?></th>                                
                                <th><?php echo $this->lang->line('leave_forworad_status'); ?> /
                                <?php echo $this->lang->line('leave_forworad_name'); ?>/ 
                                <?php echo $this->lang->line('leave_forworad_date'); ?></th>
                                <th><?php echo $this->lang->line('leave_status'); ?> /
                                <?php echo $this->lang->line('leave_approve_date'); ?></th>
                                <th><?php echo $this->lang->line('leave_action'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php  $i = 1;                  
                                foreach ($details_leave as $key => $leave) { ?>
                                    <tr>
                                        <td><?php echo $i; ?>.</td>
                                        <td><?php echo $leave->emp_unique_id ?></td>
                                        <td><span data-original-title="<?php echo get_employee_gender($leave->emp_detail_gender, false, false).' ' .$leave->emp_full_name ?>"  data-toggle="tooltip"><a href="<?php echo base_url('leave')."/leave_details/".$leave->emp_id ?>"><?php echo get_employee_gender($leave->emp_detail_gender,true,false).' ' .$leave->emp_full_name_hi; ?></a>/ <?php echo $leave->emprole_name_hi; ?></span></td>
                                        <td><?php echo get_date_formate($leave->emp_leave_date, 'd.m.Y'); ?> to <?php echo get_date_formate($leave->emp_leave_end_date, 'd.m.Y'); ?></td>
                                        <td><?php echo $leave->emp_leave_no_of_days; ?></td>
										<td><a href="<?php echo base_url(); ?>leave/leave_log/<?php echo $leave->emp_leave_movement_id; ?>"><?php echo leaveType($leave->emp_leave_type, true) ?></a> <?php echo ($leave->emp_leave_sub_type != '' ? '('.leaveType($leave->emp_leave_sub_type, true).')' : '' );?></td>
										<td><?php echo $leave->emp_leave_reason ?></td>
										<td><?php echo get_date_formate($leave->emp_leave_create_date); ?></td>
                                        <td><?php echo setForwordMessage($leave->emp_leave_forword_type); ?><br/>
                                        <label class="label label-info"><?php echo $leave->emp_leave_forword_emp_id != 0 ? get_employee_gender($leave->forworder_gender, true, false) .' '.$leave->forworder_name : 'n/a';  ?></label><br/>
                                        <label class="label label-warning"><?php echo $leave->emp_leave_forword_date != null ? get_date_formate($leave->emp_leave_forword_date) : 'n/a'; ?></label></td>
                                        <td><?php echo setApproveMessage($leave->emp_leave_approval_type) ?><br/>
										<?php  if ((in_array(7, explode(',',$current_emp_section_id )) && $userrole == 8) || $userrole == 1 ){?>
											<label class="label label-info"><?php echo $leave->emp_leave_approval_emp_id != 0 ? $leave->approver_name : 'n/a';  ?></label><br/>
										<?php } ?>
										<label class="label label-warning"><?php echo get_date_formate($leave->emp_leave_approvel_date); ?></label>
										</td>
                                        <td>
											<a href="<?php echo base_url(); ?>leave/approve_deny/cancel/<?php echo $leave->emp_leave_movement_id; ?>" class="btn  btn-danger btn-block <?php
												if ($leave->emp_leave_approval_type == 3 OR $leave->emp_leave_approval_type == 2) {
													echo "disabled";
												}
												$confirm_msg =  get_employee_gender($leave->emp_detail_gender, true, false) .' '.$leave->emp_full_name_hi . '/' . $leave->emprole_name_hi.' का '.get_date_formate($leave->emp_leave_date, 'd.m.Y').' से '.get_date_formate($leave->emp_leave_end_date, 'd.m.Y') .' तक का '.leaveType($leave->emp_leave_type, true);
												?>" onclick="return confirm('आप  <?php echo $confirm_msg; ?>  रद्द करने जा रहे है| ');"> <?php echo $this->lang->line('leave_employee_cancel') ?>
											</a>
											<a href="<?php echo base_url(); ?>leave/modify_leave/<?php echo $leave->emp_leave_movement_id; ?>" class="btn btn-warning btn-block <?php
											   if (($leave->emp_leave_approval_type == 3) || ($leave->emp_leave_approval_type == 2)) {
												   echo "disabled";
											   }
												?>" onclick="return confirm('आप  <?php echo $confirm_msg; ?>  बदलने  जा रहे है| ');">
												<?php echo $this->lang->line('leave_employee_modify') ?>
											</a>
										</td>
                                    </tr>
				<?php $i++; } ?>
                        </tbody>
                    </table>


                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div>
    </div><!-- /.row -->
    <!-- Main row -->
</section><!-- /.content -->
<script type="text/javascript">
    function getapprovaLisat(str) {
        window.location = "<?php echo base_url(); ?>leave/approve_list?type=" + str;
    }
</script>

