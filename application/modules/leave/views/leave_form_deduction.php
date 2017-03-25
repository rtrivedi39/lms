<?php 	$user_det = $this->leave_model->getSingleEmployee($leaves_emp);
$crnt_mnth = date('m') == 1 ? 1 : date('m')- 1;
?>

<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $title; ?>
      <!-- <small>Optional description</small> -->
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><?php echo $title_tab; ?></li>
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
                    <h3 class="box-title"><?php echo $title_tab; ?></h3>
					<div class="pull-right box-tools no-print">
					<button class="btn btn-warning" onclick="goBack()">पिछले पेज में वापस जायें</button>
					</div>
                </div><!-- /.box-header -->
                <?php echo $this->session->flashdata('message'); //pre($this->input->post()); //pre($emp_detail); pre($emp_more_detail);?>
                  <?php
                     $attributes_modifyleave = array('class' => 'form-leave', 'id' => 'leaveForm', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave/addleave', $attributes_modifyleave);
                    ?>               
                    <div class="box-body leave_deduction">
                        <div class="form-group">
                            <div class="col-md-12">                           
                                <?php if (isset($user_det->emp_full_name_hi)) { ?>
                                    <div class='alert alert-info'>
                                        <div class="row">
                                            <div class="col-md-6"> 
                                                <label for="exampleInputEmail1" ><?php echo $this->lang->line('leave_emp_name') . '/' . $this->lang->line('leave_emp_designation'); ?> </label>
                                            </div>
                                            <div class="col-md-6 ">
                                                <b> <?php
                                                    $emnployee_detail =  isset($user_det->emp_full_name_hi) ?
														get_employee_gender($user_det->emp_id).' '.$user_det->emp_full_name_hi . ' / ' . getemployeeRole($user_det->designation_id) : '';
														echo $emnployee_detail;
                                                    ?>
												</b>
                                            </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                        </div> 
						<div class="form-group text-center">
							<?php if($leave_rem <= 0) { ?>	
								<label class="label label-warning ">अवकाश खाते में आकस्मिक अवकाश नहीं होने से इसे अर्जित या अवैतनिक अवकाश में जोड़ सकते है |<label>
							<?php } ?>
						</div>
						
						<div class="form-group col-md-4 " id="">
                            <label for="prakar">प्रकार  <span class="text-danger">*</span></label>
                           <select name="leave_type" class="form-control"  id="leave_type">
								<option value="cl">आकस्मिक अवकाश</option>
								<option value="el">अर्जित अवकाश</option>
							</select>
                        </div>

						<div class="form-group col-md-4 " id="">
                            <label for="exampleInputFile">माह  <span class="text-danger">*</span></label>
                           <select name="month_leave" class="form-control"  id="month_leave" required>
                           <option value="" >Select month</option>
						   <?php   foreach(months(null, true) as $key => $month){							   
                               $selcted = '';
							   $selcted =  $key == $crnt_mnth ? 'selected' : '';
								echo '<option value="'.$key.'" '.$selcted.'>'.$month.'</option>';
							}							
							?>
							</select>
                        </div>
						
						<div class="form-group col-md-4 " id="">
                            <label for="exampleInputFile">वर्ष <span class="text-danger">*</span></label>
							<select name="year_leave" class="form-control"  id="year_leave">
								<?php $i = '2015';
								while($i <= date('Y')) { 
									$selcted =  $i == date('Y') ? 'selected' : '';
								?>
									<option value="<?php echo $i ; ?>" <?php echo $selcted; ?>><?php echo $i ;?></option>
								<?php $i++; } ?>
							</select>
                        </div>
						
						<hr class="clearfix"/>
						<div class="form-group col-md-6">
                            <label for="exampleInputFile"> <a href="<?php echo base_url();?>unis_bio_report" target="_blank">बायो-मेट्रिक की रिपोर्ट </a> के अनुसार कितने दिन विलम्ब से कार्यालय मे उपस्थित हुए <span class="text-danger">*</span></label>
							<input type="text" name="days_late" class="form-control" id="days_late"  value="<?php echo $this->input->post('days_late') != '' ? $this->input->post('days_late') : '' ?>" required>		
                        </div>
						<div class="form-group col-md-6">
                            <label for="exampleInputFile"> विलम्ब से दिन कटोत्रा <span class="text-danger">*</span></label>
							<input type="text" name="days" id="days"  class="form-control" value="<?php echo $this->input->post('days') != '' ? $this->input->post('days') : '' ?>" readonly required>
                        </div>
						
						<input type="hidden" name="leave_sub_type"  value="ld">
						<input type="hidden" name="leaveemp_unique_id" id="leaveemp_unique_id"  value="<?php echo $user_det->emp_unique_id ; ?>">
						<input name="start_date" type="hidden" id="start_date" value="<?php echo '1-'.$crnt_mnth.'-'.date('Y'); ?>">	
						<input name="end_date" type="hidden" id="end_date" value="<?php echo '30-'.$crnt_mnth.'-'.date('Y'); ?>">	
						<input name="headquoter" type="hidden" id="headquoter" value="2">	
						
                        <div class="clearfix"></div>
                        <div class="form-group col-md-12">
                            <label for="exampleInputFile"><?php echo $this->lang->line('leave_reason'); ?> <span class="text-danger">*</span></label>
                            <textarea class="form-control" name="leave_reason_ddl" id="leave_reason_ddl" rows="3" placeholder="आप अवकाश क्यों कटोत्रा कर रहे है कृपया जरुर दर्ज करे|" required><?php echo $this->lang->line('leave_deduction_place_holder') ; ?> 
							<?php echo $this->input->post('leave_reason_ddl') != '' ? $this->input->post('leave_reason_ddl') : '' ?>
							</textarea>
                        </div> 
						
                        <input type="hidden" name="emp_id" id="emp_id" value="<?php echo $leaves_emp; ?>">
                        <input type="hidden" name="on_behalf_id" id="on_behalf_id" value="<?php echo $this->session->userdata('emp_id'); ?>">

                        <div class="clearfix"></div>                      
                    	
						<div class="form-group col-md-12">
							<label>
								<input type="checkbox" name="confirm" id="confirm_chk" required><?php echo $this->lang->line('confimation_fields_message'); ?> <span class="text-danger">*</span>
							</label> 
						</div>
						
						<div class="form-group col-md-12 onleave_work_allot_box">
							<input type="hidden"  name="onleave_work_allot" id="onleave_work_allot"  class="form-control" value="अवकाश  पर लागू नहीं" >
							<?php echo form_error('onleave_work_allot'); ?>
						</div>
						
						<div class="box-footer">
							<button class="btn btn-primary" type="submit" onclick="return confirm('क्या आप <?php echo $emnployee_detail; ?> का अवकाश दर्ज करना चाहते है|');"  id="leaveFormSubmit"><?php echo $this->lang->line('submit_botton'); ?></button>
							<a href="<?php echo base_url(); ?>leave/employee_search" class="btn btn-info btn-sm pull-right" >नया जोड़े</a>
							<br/><br/><p class="text-danger"><b>* <?php echo $this->lang->line('conpulsary_fileds_meesage'); ?></b></p>
						</div>
					</form>
				</div><!-- /.box -->
            <div class="alert alert-warning">
                <?php echo $this->lang->line('rule_not_changes_message'); ?>
            </div>
         </div><!-- /box -->      
        </div><!-- /.col6 -->      
        <div class="col-xs-6">
            
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title"><?php   echo $this->lang->line('calender_time'); ?></h3>
                </div>
                <div class="box-body">
                    
                    <!--calender start-->
                    <?php
                    /* Set the default timezone */
                    date_default_timezone_set("America/Montreal");
                    /* Set the date */
                    $date = strtotime(date("Y-m-d"));
                    $day = date('d', $date);
                    $month = date('m', $date);
                    $year = date('Y', $date);
                    $firstDay = mktime(0, 0, 0, $month, 1, $year);
                    $title = strftime('%B', $firstDay);
                    $dayOfWeek = date('D', $firstDay);
                    $daysInMonth = cal_days_in_month(0, $month, $year);
                    /* Get the name of the week days */
                    $timestamp = strtotime('next Sunday');
                    $weekDays = array();
                    for ($i = 0; $i < 7; $i++) {
                        $weekDays[] = strftime('%a', $timestamp);
                        $timestamp = strtotime('+1 day', $timestamp);
                    }
                    $blank = date('w', strtotime("{$year}-{$month}-01"));
                    ?>
                    <div align="center"><?php echo $title ?> <?php echo $year ?></div>
                    <table class='table table-bordered' style="table-layout: fixed;"> <tr class="text-center">
                            <?php foreach ($weekDays as $key => $weekDay) : ?>
                                <td style="padding: 2px;background-color: #dcdeed"><?php echo $weekDay ?></td>
                            <?php endforeach ?>
                        </tr>
                        <tr class="text-center">
                            <?php for ($i = 0; $i < $blank; $i++): ?>
                                <td style="padding: 6px"></td>
                            <?php endfor; ?>
                            <?php for ($i = 1; $i <= $daysInMonth; $i++): ?>
                                <?php $i = strlen($i) == 1 ? '0'.$i : $i ;
                                       $on_date = $year.'-'.$month.'-'.$i;
                                if ($day == $i): ?>
                                    <td style="padding:6px; background: #337ab7; color: #ffffff">
                                        <strong><?php echo $i ?></strong>
                                    </td>
                                <?php elseif(in_array($on_date, holidays(date('Y')))): ?>
                                    <td style="padding:6px; background: red; color: #ffffff" title="<?php echo holidays_name($on_date); ?>">
                                        <strong><?php echo $i ?></strong>
                                    </td>
                                <?php  else: ?>
                                    <td style="padding: 6px"><?php echo $i ?></td>
                                <?php endif; ?>
                                <?php if (($i + $blank) % 7 == 0): ?>
                                </tr><tr class="text-center">
                                <?php endif; ?>
                            <?php endfor; ?>
                            <?php for ($i = 0; ($i + $blank + $daysInMonth) % 7 != 0; $i++): ?>
                                <td style="padding: 6px"></td>
                            <?php endfor; ?>
                        </tr>
                    </table>
                    <!--calender start-->
                </div>
            </div>
        </div>   
    </div><!-- /.row -->
</section><!-- /.content -->
<?php //pr($user_details->emp_houserent); ?>