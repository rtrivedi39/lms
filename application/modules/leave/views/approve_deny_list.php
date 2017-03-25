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
                    <div style="float:left"><h3 class="box-title"><?php echo $title_tab; ?></h3></div>
                </div>

            <div class="box-body">
            <table id="leave_tbl" class="table table-bordered table-striped display">
                <thead>
                    <tr>
                        <th>SNo.</th>
                        <th><?php echo $this->lang->line('leave_emp_name') . '/' . $this->lang->line('leave_emp_designation'); ?></th>
                        <th><?php echo $this->lang->line('leave_reason'); ?></th>
                        <th><?php echo $this->lang->line('leave_days'); ?></th>
                        <th><?php echo $this->lang->line('leave_approve_date'); ?></th>
                        <th><?php echo $this->lang->line('leave_status'); ?></th>
                        <th><?php echo $this->lang->line('leave_action'); ?></th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $i = 1;
                    foreach ($details_leave as $leave) {
                        ?>
                        <tr>
                            <td><?php echo $i; ?></td>
                            <td><?php echo get_employee_gender($leave->emp_id).' '.$leave->emp_full_name_hi . '/' . getemployeeRole($leave->designation_id); ?></td>
                            <td><?php echo $leave->emp_leave_reason ?></td><td><?php echo $leave->emp_leave_no_of_days; ?></td>
                            <td><?php echo get_date_formate($leave->emp_leave_forword_date); ?></td>
                           
                            <?php $userrole = checkUserrole(); ?>

                            <td><?php echo setForwordMessage($leave->emp_leave_forword_type); ?></td>
                            <td>
                                <div class="btn-group">
								<a href="<?php echo base_url(); ?>leave/approve_deny/cancel/<?php echo $leave->emp_leave_movement_id; ?>" class="btn  btn-twitter btn-block<?php
									if ($leave->emp_leave_approval_type == 3 OR $leave->emp_leave_approval_type == 2) {
										echo "disabled";
									}
									$confirm_msg = $leave->emp_full_name_hi . '/' . getemployeeRole($leave->designation_id).' का '.get_date_formate($leave->emp_leave_date, 'd.m.Y').' से '.get_date_formate($leave->emp_leave_end_date, 'd.m.Y') .' तक का '.leaveType($leave->emp_leave_type, true);
									?>" onclick="return confirm('आप  <?php echo $confirm_msg; ?>  रद्द करने जा रहे है| ');"> <?php echo $this->lang->line('leave_employee_cancel'); ?></a>
                                    <a href="<?php echo base_url(); ?>leave/approve_deny/cancel/<?php echo $leave->emp_leave_movement_id; ?>" class="btn  btn-twitter" onclick="return confirm('Are you sure?');"><?php echo $this->lang->line('leave_employee_cancel'); ?></a>

                                </div>
                            </td>

                        </tr>
                        <?php
                        $i++;
                    }
                    ?>
                </tbody>
            </table>


        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div>
</div><!-- /.row -->
<!-- Main row -->
</section><!-- /.content -->


