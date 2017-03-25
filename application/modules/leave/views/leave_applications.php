<?php
$emp_details= get_list(EMPLOYEES,null,array('emp_id'=>$this->session->userdata("emp_id")));
?>
<section class="content-header">
    <h1>
        <?php echo $title; ?>

    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Leave Details</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Start box) -->
  
    <div class="row" id="divname">
        <div class="col-md-12">
            <?php echo $this->session->flashdata('message'); ?>
			<div class="box box-warning">

                <div class="box-body">
                  <?php
                     $attributes_applications = array('class' => 'form-leave', 'id' => 'leaveapplications', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave/applications/date', $attributes_applications);
                    ?>  
				
						<div class="row">							
							<div class="col-md-3">
								<label><?php echo $this->lang->line('application_date'); ?></label>
								<input type="text"  id="emp_detail_dob" class="form-control" name="app_date" placeholder="dd-mm-yyyy" value="<?php echo $this->input->post('app_date') != '' ? $this->input->post('app_date') : ''; ?>" required>
							</div>
							<div class="col-md-3">		
								<label><?php echo $this->lang->line('employee_class'); ?></label>
								<select class="form-control" name="employees_class">
									<option value=""><?php echo $this->lang->line('select'); ?></option>
										<?php $employees_class = employees_class(); 
										foreach ($employees_class as $yky => $yval) { ?>
											<option value="<?php echo $yky; ?>" <?php if ($this->input->post('employees_class') == $yky) {echo 'selected';} ?>><?php echo $yval; ?></option>
										<?php } ?>
								</select>
							</div>							
							<div class="col-md-3">
								<label></label>
								<button type="submit" name=""  class="btn btn-warning" value= ""><?php echo $this->lang->line('search'); ?></button>
							</div>
							<div class="col-md-3 pull-right">
								<label></label>
								<a href="<?php echo base_url().'leave/applications/1' ; ?>"  class="btn btn-success"><?php echo $this->lang->line('all_pending_application'); ?></a>
							</div>
						</div>
					</form>
				</div>
			</div>				
				
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-inbox"></i><h3 class="box-title"><?php echo $title_tab; ?> </h3>
					
                <div class="pull-right box-tools"> 
					<button onclick="printContents('divname')" class="btn btn-primary "><?php echo $this->lang->line('print'); ?></button>
					<button class="btn btn-warning" onclick="goBack()"><?php echo $this->lang->line('go_back_opage'); ?></button>
				</div>
				
				
			</div><!-- /.box-header -->
				

                <div class="box-body">
                    <table class="table table-bordered table-striped dataTable">
                        <thead>
						<tr>
                            <th style="width: 10px">#</th>
                            <th>ID</th>                           
                            <th>Name</th>                           
                            <th><?php echo $this->lang->line('leave_type') ?></th>                           
                            <th><?php echo $this->lang->line('leave_start_date') ?> से</th>
                            <th><?php echo $this->lang->line('end_date') ?></th>  
                            <th><?php echo $this->lang->line('leave_days') ?></th>
                            <th><?php echo $this->lang->line('leave_reason') ?></th>
                            <th><?php echo $this->lang->line('leave_status') ?></th>
                            <th>कार्यवाही दिनांक</th>
                            <th>आवेदन दिनांक</th>
                            <th class="no-print"><?php echo $this->lang->line('print') ?></th>
                        </tr>
						</thead>
						<tbody>
                        <?php  
							$r = 1;						
                        //pr($leave_order_lists);
                        if (isset($leave_order_lists)) {
                            foreach ($leave_order_lists as $row) {								
                                ?>
                                <tr>
                                    <td><?php echo $r; ?></td>
                                    <td><?php echo $row->emp_unique_id; ?></td>
									<td><a href="<?php echo base_url('leave')."/leave_details/".$row->emp_id ?>" data-original-title="<?php echo get_employee_gender($row->emp_detail_gender, false, false).' ' .$row->emp_full_name ?>"  data-toggle="tooltip"><?php echo get_employee_gender($row->emp_detail_gender, true, false).' ' .$row->emp_full_name_hi  . '</a>/' . $row->emprole_name_hi; ?></td>
									<td><a href="<?php echo base_url(); ?>leave/leave_log/<?php echo $row->emp_leave_movement_id; ?>"><?php echo!empty($row->emp_leave_type) ? leaveType($row->emp_leave_type, true) : '-' ?></a></td>                              
									<td><?php echo ($row->emp_leave_date != '1970-01-01') ? get_date_formate($row->emp_leave_date) : '-' ?> </td>
                                    <td><?php echo ($row->emp_leave_end_date != '1970-01-01') ? get_date_formate($row->emp_leave_end_date) : '-' ?> </td>
                                    <td><?php echo!empty($row->emp_leave_no_of_days) ? 
                                            $row->emp_leave_type == 'hpl' ? ($row->emp_leave_no_of_days * 2) .' ('.$row->emp_leave_no_of_days.')' : $row->emp_leave_no_of_days : 
                                            '-' ?></td>
                                    <td><?php echo!empty($row->emp_leave_reason) ? $row->emp_leave_reason : '-' ?></td>
                                    <td> <?php /* <label class="label label-info"><?php echo leave_status(true, $row->leave_status); ?></label> */ ?>
                                    <?php 
                                        if ($row->emp_leave_approval_type == 0) {
                                            if ($row->emp_leave_forword_type == 0) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_status_pending') . '</label>';
                                            } else if (($row->emp_leave_forword_type == 1) OR ( $row->emp_leave_forword_type == 2)) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_status_on_approval') . '</label>';
                                            } else if ($row->emp_leave_forword_type == 3) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_cancel') . '</label>';
                                            }
                                        } else if ($row->emp_leave_approval_type != 0) {
                                            if ($row->emp_leave_approval_type == 1) {
                                                echo '<label class="label label-success">' . $this->lang->line('leave_status_approve') . '</label>';
                                            } else if ($row->emp_leave_approval_type == 2) {
                                                echo '<label class="label label-danger">' . $this->lang->line('leave_status_deny') . '</label>';
                                            } else if ($row->emp_leave_approval_type == 3) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_cancel') . '</label>';
                                            }
                                        }
                                        ?> </td>                                  
                                  
                                     <td><?php if ($row->emp_leave_forword_type == 1 && $row->emp_leave_approval_type == 0) {
											echo get_date_formate($row->emp_leave_forword_date);
										} else if($row->emp_leave_forword_type == 1 && $row->emp_leave_approval_type == 1 ){
											echo get_date_formate($row->emp_leave_approvel_date);
										} ?>
									 </td>
                                     <td><?php echo get_date_formate($row->emp_leave_create_date); ?></td>
                                     <td class="no-print">
                                        <a href="<?php echo base_url(); ?>leave/print/<?php echo $row->emp_leave_movement_id; ?>" class="btn btn-primary"><span class="fa fa-print"></span> <?php echo $this->lang->line('print_button') ?></a>
                                      <?php if($row->medical_files !=  '') { ?>
                                            <a href="<?php echo base_url(); ?>uploads/medical_files/<?php echo $row->medical_files; ?>" target="_blank">Certificate</a>
                                        <?php } ?>
                                     </td>
                                </tr>
                                <?php
                                $r++;
                               
                            }
                        } else {
                            ?><tr>  <td colspan="3"><?php echo $this->lang->line('no_record_found'); ?></td></tr><?php }
                        ?>
						</tbody>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer">                 
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
   
</section><!-- /.content -->
