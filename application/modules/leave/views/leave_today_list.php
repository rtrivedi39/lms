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
    <div class="row">
        <div class="col-xs-12">
            <div class="box box-primary">               
                <div class="box-header with-border">
                    <h3 class="box-title"><?php echo $this->lang->line('leave_on_today'); ?></h3>                 
					<div class="pull-right tools">
						<button class="btn btn-warning" onclick="goBack()"><?php echo $this->lang->line('Back_button_label'); ?></button>
					</div>
				</div>

                <div class="box-body">
                    <table id="" class="table table-bordered"> 
                        <thead>
                        <tr>
                            <th><?php echo $this->lang->line('sno'); ?>#</th>
                            <th><?php echo $this->lang->line('uid'); ?></th>
                            <th><?php echo $this->lang->line('leave_emp_name'); ?></th>
                            <th><?php echo $this->lang->line('leave_designation'); ?></th>
                            <th><?php echo $this->lang->line('start_date'); ?> </th>
                            <th><?php echo $this->lang->line('end_date'); ?> </th>
                            <th><?php echo $this->lang->line('leave_type'); ?> </th>
                            <th><?php echo $this->lang->line('leave_reason'); ?></th>
                            <th><?php echo $this->lang->line('leave_days'); ?></th>
                            <th><?php echo $this->lang->line('leave_half_type_on'); ?> </th>
                            <th><?php echo $this->lang->line('who_onbehalf') ?></th>
                            <th><?php echo $this->lang->line('status') ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(user_leave_today()){
                            $i = 1;
                            foreach(user_leave_today() as $row){ ?>
                                 <tr class="bg-<?php
                                    switch ($row->emp_leave_type) {
                                        case 'cl':
                                            echo "info"; break;                                     
                                        case 'ol':
                                            echo "success"; break;
                                        case 'el':
                                            echo "warning"; break;
                                        case 'hpl':
                                            echo "danger"; break;
                                        default:
                                            echo "transparent"; break;
                                    }
                                    ?>">
                                    <?php 
                                echo "<td>".$i."</td>";
                                echo "<td>".$row->emp_unique_id."</td>";
                                echo "<td><a href=".base_url('leave')."/leave_details/".$row->emp_id .">".get_employee_gender($row->emp_id).' '.$row->emp_full_name_hi."</a></td>";
                                echo "<td>".getemployeeRole($row->designation_id)."</td>";
                                echo "<td>".get_date_formate($row->emp_leave_date)."</td>";
                                echo "<td>".get_date_formate($row->emp_leave_end_date)."</td>"; ?>
                                <td><a href="<?php echo base_url(); ?>leave/leave_log/<?php echo $row->emp_leave_movement_id; ?>"><?php echo!empty($row->emp_leave_type) ? leaveType($row->emp_leave_type, true) : '-' ?></a>
                                	<?php if($row->is_leave_return == 1){ ?>
										<a href="<?php echo base_url(); ?>leave/leave_log/<?php echo $row->emp_leave_movement_id; ?>" class="btn btn-warning btn-xs">पृच्छा देखें</a>
									<?php } ?>
                                </td>
                                <?php 
                                echo "<td>".$row->emp_leave_reason."</td>";
                                echo "<td>".$row->emp_leave_no_of_days."</td>";
                                echo "<td>".(!empty($row->emp_leave_half_type) ? ($row->emp_leave_half_type == 'FH' ? $this->lang->line('first_half') : $this->lang->line('second_half')) : '-') ."</td>"; ?>
                                <td> <?php echo  !empty($row->on_behalf_leave) ? $row->on_behalf_leave != $row->emp_id ? getemployeeName($row->on_behalf_leave,true) : $this->lang->line('self') : '-' ; ?></td>
                                <td> <?php /* <label class="label label-info"><?php echo leave_status(true, $row->leave_status); ?></label> */ ?>
                                    <?php 
                                        if ($row->emp_leave_approval_type == 0) {
                                            if ($row->emp_leave_forword_type == 0) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_status_pending') . '</label>';
                                            } else if (($row->emp_leave_forword_type == 1) OR ( $row->emp_leave_forword_type == 2)) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_status_on_approval') . '</label>';
                                            } else if ($row->emp_leave_forword_type == 3) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_cancel') . '</label>';
                                            } else if ($row->emp_leave_approval_type == 4 || $row->emp_leave_forword_type == 4) {
											$return_user = $row->leave_return_to_emp_id;
											echo  '<label class="label label-info">पृच्छा</label>'.' '.getemployeeName($return_user, true);	
											}                                      
                                        } else if ($row->emp_leave_approval_type != 0) {
                                            if ($row->emp_leave_approval_type == 1) {
                                            	echo $status =  ($row->emp_leave_type == 'ihpl') ? '<label class="label label-success">अवलोकित</label>' : '<label class="label label-success">'.$this->lang->line('leave_status_approve').'</label>';
                                            } else if ($row->emp_leave_approval_type == 2) {
                                                echo '<label class="label label-danger">' . $this->lang->line('leave_status_deny') . '</label>';
                                            } else if ($row->emp_leave_approval_type == 3) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_cancel') . '</label>';
                                            }else if ($row->emp_leave_approval_type == 4 || $row->emp_leave_forword_type == 4) {
											$return_user = $row->leave_return_to_emp_id;
											echo  '<label class="label label-info">पृच्छा</label>'.' '.getemployeeName($return_user, true);	
											} 
                                        }  
                                        ?> </td> 
                               <?php  echo "</tr>";
                           $i++; }
                        } else {
                            echo "<tr>";
                            echo "<td colspan='5'>".$this->lang->line('no_leave_on_today')."</td>";
                            echo "</tr>";
                        } ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body --> 
                <div class="box-footer">
                     <div class="no-print">
                        <button onclick="print_content()" class="btn btn-primary">Print this page</button>
                        <button onclick="Download()" class="btn btn-primary">Download page</button><br/>
                    </div>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
    <!-- /.row --><!-- Main row -->
</section><!-- /.content -->  