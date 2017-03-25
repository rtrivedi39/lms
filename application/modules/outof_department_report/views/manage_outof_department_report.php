<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $title; ?>
        <!-- <small>Optional description</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('admin'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
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
						   <a href="<?php echo base_url('outof_department_report');?>/add_report">
								<button class="btn  btn-info"><?php echo $this->lang->line('add_button'); ?></button>
							</a>
						<?php } ?>
						<a href="javascript:history.go(-1)">
							<button class="btn  btn-warning"><?php echo $this->lang->line('Back_button_label'); ?></button>
						</a>
						<?php if($user_is_forwader ){  ?>
							<a href="<?php echo base_url(); ?>outof_department_report">
								<button class="btn btn-success"><?php echo $this->lang->line('view_own_application_button'); ?></button>
							</a>
							<a href="<?php echo base_url(); ?>outof_department_report/approve_deny">
								<button class="btn btn-success"><?php echo $this->lang->line('approve_deny_button_label'); ?></button>
							</a>
						<?php } ?>
                    </div>
                </div><!-- /.box-header -->
                 <?php 
                 $attributes_manage_report = array('class' => 'form-signin', 'id' => 'formmanage_report', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                echo form_open('outof_department_report/manage_report', $attributes_manage_report);
                ?>   
            
                    <div class="col-md-8">
                        <!-- general form elements -->
                        <div class="box box-primary" style="margin-top: 15px;">
                            <!-- form start -->
                            <?php echo $this->session->flashdata('message'); ?>
                            <div class="box-body">
                                <div class="form-group col-md-12">
									<label for="report_where_go"><?php echo $this->lang->line('report_where_go'); ?><span class="text-danger">*</span></label>
									<input type="text" name="report_where_go" placeholder="उदाहरण :- वित्त मंत्री के पास बजट की फाइल पर हस्ताक्षर हेतु" class="form-control" value="<?php echo ($input_data['report_where_go'] != '' ? $input_data['report_where_go']  : '' ); ?>" required>
									<?php echo form_error('report_where_go'); ?>
								</div>
								<div class="form-group col-md-12">
									<label for="report_when_go"><?php echo $this->lang->line('report_when_go'); ?> <span class="text-danger">*</span></label>
									<div class="row">
										<div class="col-md-3">
											<input type="text" data-date-format="dd-mm-yyyy" name="report_when_go_date"  id="report_when_go" placeholder="dd/mm/YYY" value="<?php echo ($input_data['report_when_go_date'] != '' ? $input_data['report_when_go_date']  :  date('d-m-Y') ); ?> " class="form-control datepicker">
										</div>
										<div class="col-md-3">
											<select name="report_when_go_hour" class="form-control" required>
												<option value="">--<?php echo $this->lang->line('report_where_go_time_select'); ?>--</option>
												<?php  for($i=1; $i <= 12; $i++){ 													
												$selected = ($input_data['report_when_go_hour'] != '' && $input_data['report_when_go_hour'] == $i ? 'selected' : '' );?>
													<option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
												<?php } ?>
											</select>
										</div>
										<div class="col-md-3">
											<select name="report_when_go_minitues" class="form-control" required>
												<option value="">--<?php echo $this->lang->line('report_where_go_minute_select'); ?>--</option>
												<?php  $i = 00; while( $i <= 55){
													$selected = ($input_data['report_when_go_minitues'] != '' && $input_data['report_when_go_minitues'] == $i ? 'selected' : '' ); ?>													
													<option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?></option>
												<?php $i = $i+5; } ?>
											</select>
										</div>
										<div class="col-md-3">
											<select name="report_when_go_pali" class="form-control" required>
												<option value="">-<?php echo $this->lang->line('report_where_go_plali_select'); ?>-</option>
												<option value="AM" <?php echo ($input_data['report_when_go_pali'] != '' && $input_data['report_when_go_pali'] == 'AM' ? 'selected' : '' ); ?>><?php echo $this->lang->line('am_label'); ?></option>
												<option value="PM" <?php echo ($input_data['report_when_go_pali'] != '' && $input_data['report_when_go_pali'] == 'PM' ? 'selected' : '' ); ?>><?php echo $this->lang->line('pm_label'); ?></option>
											</select>
										</div>
									</div>
									<p class="help-block">उदाहरण :- <?php echo date('d-m-Y'); ?> , 4 बजकर, 30 मिनट, पूर्वाहन  या अपराह्न</p>
									<?php echo form_error('report_when_go'); ?>
								</div>
								
								<div class="form-group col-md-6">
									<label for="report_aprox_time"><?php echo $this->lang->line('report_aprox_time'); ?></label>
									<select name="report_aprox_time" class="form-control" required>
										<?php $i = 15; while( $i <= 150){
										 $selected = ($input_data['report_aprox_time'] != '' && $input_data['report_aprox_time'] == $i ? 'selected' : '' ); ?>
										<option value="<?php echo $i; ?>" <?php echo $selected; ?>><?php echo $i; ?> मिनट</option>
										<?php $i = $i+15; } ?>
									</select>
									<p class="help-block">उदाहरण :- 15 मिनट ..</p>
								</div>  
                             </div><!-- /.box-body -->
                        
							<div class="box-footer">
								<button class="btn btn-primary" onclick="return confirm('<?php echo $this->lang->line('confirm_message'); ?>');" type="submit" name="save_report" id="save_report" value="1"><?php echo $this->lang->line('submit_button'); ?></button>
						   
							</div>
                       </div><!-- /.box -->
                     </div>
                 </form>
            </div><!-- /.box-body -->
        </div><!-- /.box -->
    </div>
    <!-- Main row -->
</section><!-- /.content -->



    