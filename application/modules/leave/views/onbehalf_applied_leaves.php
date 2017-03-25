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
                    <h3 class="box-title"></h3>                 
                </div>

                <div class="box-body">
                    <table id="dataTable" class="table table-bordered table-striped"> 
                        <thead
                        <tr>
                            <th><?php echo $this->lang->line('sno'); ?>#</th>
                            <th><?php echo $this->lang->line('uid'); ?></th>
                            <th><?php echo $this->lang->line('leave_emp_name'); ?></th>
                            <th><?php echo $this->lang->line('leave_designation'); ?></th>
                            <th><?php echo $this->lang->line('start_date'); ?></th>
                            <th><?php echo $this->lang->line('end_date'); ?></th>
                            <th><?php echo $this->lang->line('leave_type'); ?></th>
                            <th><?php echo $this->lang->line('leave_days'); ?></th>
                            <th><?php echo $this->lang->line('leave_half_type_on'); ?></th>
                            <th><?php echo $this->lang->line('leave_reason'); ?></th>
                            <th><?php echo $this->lang->line('leave_of_way'); ?></th>
                            <th><?php echo $this->lang->line('leave_of_message'); ?></th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if($applied_list){
                            $i = 1;
                            foreach($applied_list as $row){
                                
                                echo "<tr>";
                                echo "<td>".$i."</td>";
                                echo "<td>".$row->emp_unique_id."</td>";
                                echo "<td>".get_employee_gender($row->emp_id).' '.$row->emp_full_name_hi."</td>";
                                echo "<td>".getemployeeRole($row->designation_id)."</td>";
                                echo "<td>".get_date_formate($row->emp_leave_date)."</td>";
                                echo "<td>".get_date_formate($row->emp_leave_end_date)."</td>";
                                echo "<td>".leaveType($row->emp_leave_type, true)."</td>";
                                echo "<td>".$row->emp_leave_no_of_days."</td>";
                                echo "<td>".$row->emp_leave_half_type."</td>";
                                echo "<td>".$row->emp_leave_reason."</td>";
                                echo "<td>".$row->leave_apply."</td>";
                                echo "<td>".$row->leave_message."</td>";
                                echo "</tr>";
                           $i++; }
                        } else {
                            echo "<tr>";
                            echo "<td colspan='5'>".$this->lang->line('no_record_found')."</td>";
                            echo "</tr>";
                        } ?>
                        </tbody>
                    </table>
                </div><!-- /.box-body --> 
                <div class="box-footer">
                     <div class="no-print">
                        <button onclick="print_content()" class="btn btn-primary">Print this page</button>
                    </div>
                </div>
            </div><!-- /.box -->
        </div>
    </div>
    <!-- /.row --><!-- Main row -->
</section><!-- /.content -->  