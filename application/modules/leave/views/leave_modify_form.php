
<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $title; ?>
      <!-- <small>Optional description</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><?php echo $page_title; ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Your Page Content Here -->
    <!-- Small boxes (Stat box) -->
    <div class="row">
        <div class="col-xs-6">
            <div class="box box-primary">
                <div class="box-header">
                    <h3 class="box-title"><?php echo $page_title; ?></h3>
                </div><!-- /.box-header -->
                <?php echo $this->session->flashdata('message'); //pre($this->input->post()); //pre($emp_detail); pre($emp_more_detail);?>
                 <?php
                 $attributes_modifyleave = array('class' => 'form-unis', 'id' => 'formmodifyleave', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                echo form_open('leave/modifyleave', $attributes_modifyleave);
                ?>  
             
                    <div class="box-body">
                        <div class="form-group">
                            <div class="col-md-12">                           
                                <?php if (isset($user_det->emp_full_name_hi)) { ?>

                                    <div class="col-md-6 no-margin no-padding"> 
                                        <label for="exampleInputEmail1" ><?php echo $this->lang->line('leave_emp_name') . '/' . $this->lang->line('leave_emp_designation'); ?> : </label>
                                    </div>
                                    <div class="col-md-6 ">
                                        <?php
                                        echo isset($user_det->emp_full_name_hi) ? get_employee_gender($user_det->emp_id).' '.$user_det->emp_full_name_hi : '';
                                        echo ' / ' . getemployeeRole($user_det->designation_id);
                                        ?>
                                    </div>

                                <?php } ?>
                            </div>
                        </div> 
                        <hr class="clearfix"/>
                        <div class="form-group col-md-6" >
                            <label for="exampleInputEmail1"><?php echo $this->lang->line('leave_type'); ?> : </label>
                            <?php
                            //pre($leave_details);
                            if (isset($leave_details->emp_leave_type)) {
                                echo leaveType($leave_details->emp_leave_type, true);
                            }
                            ?>
                        </div>
                        <div class="form-group col-md-6 " >

                            <label for="exampleInputEmail1"><?php echo $this->lang->line('leave_reason'); ?> : </label>
                            <?php
                            if (isset($leave_details->emp_leave_reason)) {
                                echo $leave_details->emp_leave_reason;
                            }
                            ?>
                        </div>


                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <?php
                            if (isset($leave_details->emp_leave_no_of_days)) {
                                $days = $leave_details->emp_leave_no_of_days;
                                $start_date = $leave_details->emp_leave_date;
                                ?>
                                <div class="form-group">
                                    <div class="radio ">
                                        <label>
                                            <input type="checkbox" name="leave_days[]" id="optionsRadios1" value="<?php echo date('d-m-Y', strtotime($start_date)); ?>" checked="">
                                            <?php echo date('d-m-Y', strtotime($start_date)); ?>
                                        </label>
                                    </div>
                                </div>
                                <?php
                                for ($h = 1; $h < $days; $h++) {
                                    ?>
                                    <div class="form-group">
                                        <div class="radio ">
                                            <label>
                                                <input type="checkbox" name="leave_days[]" id="optionsRadios1" value="<?php echo date('d-m-Y', strtotime('+' . $h . ' day', strtotime($start_date))); ?>" checked="">
                                                <?php echo date('d-m-Y', strtotime('+' . $h . ' day', strtotime($start_date))); ?>
                                            </label>
                                        </div>
                                    </div>
                                <?php } ?>
                            <?php } ?>
                        </div> 
                        <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $this->uri->segment(3); ?>">

                        <div class="clearfix"></div>



                    </div> <!-- body-->		

                    <input type="hidden" name="leave_movement_id" id="leave_movement_id" value="<?php echo isset($leave_details->emp_leave_movement_id) ? $leave_details->emp_leave_movement_id : ''; ?>">
                    <div class="box-footer">
                        <?php if (isset($leave_details->emp_leave_movement_id)) {
                            ?>
                            <input class="btn btn-primary" type="submit" name="modify_date" value="<?php echo $this->lang->line('modify_botton'); ?>" >
                        <?php } else {
                            ?>
                            <input class="btn btn-primary" type="submit" name="save_leave" value="<?php echo $this->lang->line('submit_botton'); ?>" >

                        <?php } ?>
                    </div>

                </form>
            </div><!-- /.box -->
        </div><!-- /.col6 -->

        <?php //$this->load->view('leave_dashboard') ?>
    </div><!-- /.row -->
</section><!-- /.content -->
