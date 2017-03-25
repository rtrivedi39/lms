<!-- Content Header (Page header) -->
<style>
	#leave_tbl td, #leave_tbl th{
		padding:4px;
	}
</style>
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

    <div class="row" id="emp_list">
        <div class="col-xs-12">
            <div class="box box-info">
			<?php echo $this->session->flashdata('message'); ?>
                <div class="box-header">
                    <h3 class="box-title"><?php echo $title_tab; ?></h3>
					<div class="pull-right box-tools no-print">
						<button class="btn btn-warning" onclick="goBack()">पिछले पेज में वापस जायें</button>
						<button class="btn btn-primary no-print" onclick="printContents('emp_list')">Print</button>
					</div>
                </div>
				
                <div class="box-body">
                    <table id="leave_tbl" class="table table-bordered table-striped display">
                        <thead>
                            <tr>
                                <th width='5px'>SNo.</th>
                                <th width="10%"><?php echo $this->lang->line('emp_unique_id'); ?></th>
                                <th width='10%'><?php echo $this->lang->line('leave_emp_name'); ?> / <?php echo $this->lang->line('leave_emp_designation'); ?></th>
                                <!--<<th><?php //echo $this->lang->line('emp_mobile_no'); ?></th>-->
                                <!--<th  width="10%"><?php //echo $this->lang->line('leave_emp_email'); ?></th>-->
                                <th><?php echo $this->lang->line('casual_leave'); ?></th>
                                <th><?php echo $this->lang->line('optional_leave'); ?></th>
                                <th><?php echo $this->lang->line('earned_leave'); ?></th>
                                <th><?php echo $this->lang->line('half_pay_leave'); ?></th>
								<th><?php echo $this->lang->line('paternity_leave'); ?></th>
								<th><?php echo $this->lang->line('maternity_leave'); ?></th>
								<th><?php echo $this->lang->line('child_care_leave'); ?></th>
								<th><?php echo $this->lang->line('official_tour'); ?></th>
								<th><?php echo $this->lang->line('other_leave'); ?></th>
								<th><?php echo $this->lang->line('emp_previous_el'); ?></th>
                                <th width="10%" class="no-print"><?php echo $this->lang->line('view'); ?></th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $i = 1;
							$userrole = checkUserrole();
							$crnt_emp_id = 	$this->session->userdata('emp_id');
							$emp_section = getusersection($crnt_emp_id);
                            foreach ($details_leave as $key => $leave) {
                                ?>
                                <tr>
                                    <td><?php echo $i; ?></td>
                                    <td><?php echo $leave->emp_unique_id; ?></td>
                                    <td><a href="<?php echo base_url('leave')."/leave_details/".$leave->emp_id ?>" data-original-title="<?php echo get_employee_gender($leave->emp_detail_gender,false,false).' ' .$leave->emp_full_name ?>"  data-toggle="tooltip"><?php echo get_employee_gender($leave->emp_detail_gender,true,false).' '.$leave->emp_full_name_hi . '</a>'; ?> / <?php echo $leave->emprole_name_hi; ?></td>

                                    <!--<<td><?php //echo $leave->emp_mobile_number; ?></td>-->
                                    <!--<td><?php //echo $leave->emp_email; ?></td>-->

                                    <td><?php echo $leave->cl_leave; ?></td>
                                    <td><?php echo $leave->ol_leave; ?></td>
                                    <td><?php echo calculate_el($leave->el_leave); ?></td>
                                    <td><?php echo $leave->hpl_leave.' ('.calculate_hpl($leave->hpl_leave).')'; ?></td>
									<td><?php echo $leave->pat_leave; ?></td>
                                    <td><?php echo $leave->mat_leave; ?></td>
                                    <td><?php echo $leave->child_leave; ?></td>
                                    <td><?php echo $leave->ot_leave; ?></td>
                                    <td><?php echo $leave->other_leave; ?></td>
                                    <td><?php echo $leave->emp_previous_el; ?></td>
								  <td class="no-print">
										<a href="<?php echo base_url(); ?>leave/leave_details/<?php echo $leave->emp_id ?>" class="btn btn-primary btn-sm btn-block"><?php echo $this->lang->line('view'); ?></a>
										<?php if ((in_array(7, explode(',',$emp_section)) && $userrole == 8) || $userrole == 1 || ($leave->emp_class == 5 || $leave->emp_class == 2 && $current_emp_id == 136)  || ($leave->emp_class == 3 && $current_emp_id == 46) || ($leave->emp_class == 4 && $current_emp_id == 166)){ ?>
											<a href="<?php echo base_url(); ?>leave/leave/manage_leave/<?php echo $leave->emp_id ?>" class="btn btn-warning btn-sm btn-block"><?php echo $this->lang->line('edit'); ?></a>
										<?php }  ?>
									</td>
                                </tr>
                                <?php $i++;
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


