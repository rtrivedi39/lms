<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $title; ?>
        <!-- <small>Optional description</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li><a href="<?php echo base_url('joining_report');?>"></a></li>
        <li class="active"><?php echo $title_tab; ?></li>
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
                    <div style="float:left">
						<h3 class="box-title"><?php echo $page_title;?></h3>
					</div>
					<div style="float:right;padding-left: 10px;">
						<?php  if($this->uri->segment(2) != 'add_report') {?>	
							<a href="<?php echo base_url('joining_report');?>/add_report">
								<button class="btn  btn-info"><?php echo $this->lang->line('add_button'); ?></button>
							</a>
						<?php } ?>
						<a href="<?php echo base_url('joining_report');?>">
							<button class="btn  btn-success"><?php echo $this->lang->line('view_own_application_button'); ?></button>
						</a>
						<a href="javascript:history.go(-1)">
							<button class="btn  btn-warning"><?php echo $this->lang->line('Back_button_label'); ?></button>
						</a>
					</div>
                </div><!-- /.box-header -->
                <?php 
                     $attributes_manage_report = array('class' => 'form-signin', 'id' => 'formmanage_report', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('joining_report/manage_report', $attributes_manage_report);
                    ?> 	 
             
                    <div class="col-md-6">
                        <!-- general form elements -->
                        <div class="box box-primary" style="margin-top: 15px;">
                            <!-- form start -->
                            <?php echo $this->session->flashdata('message'); ?>
                            <div class="box-body">
							 <div class="form-group">
								<div class="col-md-12">                           
									<div class='alert alert-info'>
										<div class="row">
											<div class="col-md-12"> 
												<?php echo $this->lang->line('name'); ?> / <?php echo $this->lang->line('post'); ?>  : -  <b><?php echo $current_emp_full_name_hi.' / '.getemployeeRole($current_emp_designation_id) ; ?></b>											</div>
											<div class="col-md-12">
												<?php echo $this->lang->line('id_label'); ?> : -  <b><?php echo $this->session->userdata('emp_unique_id') ; ?></b>
											</div>
										</div>
									</div>
									</div>
								</div> 
								<div class="form-group">
                                    <label for="exampleInputEmail1"> <?php echo $this->lang->line('subject_label'); ?> : - </label>
                                    <p><?php echo $this->lang->line('joining_report_information'); ?></p>
                                </div>
								<div class="form-group col-md-12">
									<label for="exampleInputFile"><?php echo $this->lang->line('joining_report_leave_type'); ?> <span class="text-danger">*</span></label>
									<select class="form-control col-md-6" name="report_leave_type">
									<?php foreach(leaveType(null, true) as $key => $value){ 
									$selcted = ($input_data['report_leave_type'] != '' && $input_data['report_leave_type'] == $key ? 'selected' : '' ); ?>
										<option value="<?php echo $key; ?>" <?php echo $selcted; ?>><?php echo $value; ?></option>
									<?php } ?>
									</select>
									<?php echo form_error('joining_report_leave_type'); ?>
								</div>
								
                                <div class="form-group col-md-6">
									<label for="exampleInputPassword1"><?php echo $this->lang->line('leave_label'); ?> <?php echo $this->lang->line('from_label'); ?><span class="text-danger">*</span></label>
									<input type="text"  data-date-format="dd-mm-yyyy"  data-provide="datepicker" name="report_from_date"  class="form-control datepicker" value="<?php echo ($input_data['report_from_date'] != '' ? $input_data['report_from_date'] : '' );?>">
									<?php echo form_error('report_from_date'); ?>
								</div>
								<div class="form-group col-md-6">
									<label for="exampleInputFile"><?php echo $this->lang->line('leave_label'); ?> <?php echo $this->lang->line('to_label'); ?> था <span class="text-danger">*</span></label>
									<input type="text" data-date-format="dd-mm-yyyy" name="report_to_date" id="end_date" class="form-control datepicker" value="<?php echo ($input_data['report_to_date'] != '' ? $input_data['report_to_date'] : '' );?>">
									<?php echo form_error('report_to_date'); ?>
								</div>
								
								<div class="form-group col-md-12">
									<label for="exampleInputFile"><?php echo $this->lang->line('remark_label'); ?></label>
									<textarea name= "report_remark" class="form-control" style="width:100%; height:150px;" placeholder="<?php echo $this->lang->line('remark_placeholder'); ?>"><?php echo ($input_data['report_remark'] != '' ? $input_data['report_remark'] : '' );?></textarea>
								</div>  
                             </div><!-- /.box-body -->
                        
							<div class="box-footer">
								<button class="btn btn-primary" onclick="return confirm('<?php echo $this->lang->line('confirm_message'); ?>');" type="submit" name="save_report" id="save_report" value="1"><?php echo $this->lang->line('joining_report_submit_button'); ?></button>
						   
							</div>
                       </div><!-- /.box -->
                     </div>
                 </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div><!-- /.row -->
    <!-- Main row -->
</section><!-- /.content -->



    