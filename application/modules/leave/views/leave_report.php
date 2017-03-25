<style type="text/css" media="print">
  @page { size: landscape; }
</style>
<section class="content-header">
    <h1> <?php echo $title ?></h1>
    <ol class="breadcrumb">
         <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active">Leave</li>
    </ol>
</section>
<div class="pad margin no-print">
    <div class="box box-info">
        <div class="box-header">
            <h3><?php echo $this->lang->line('filter_title'); ?></h3>
			<div class="pull-right box-tools"> 
				<button class="btn btn-warning" onclick="goBack()">पिछले पेज में वापस जायें</button>
			</div>
        </div>
        <div class="box-body">
            <?php
                 $attributes_reports = array('class' => 'form-unis', 'id' => 'formleave_report', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                echo form_open('leave/leave_report/reports', $attributes_reports);
                ?>  
                <div class="row">
                    <div class="col-md-2">
                        <label><?php echo $this->lang->line('from'); ?> <span class="text-danger">*</span></label>
                        <input type="text" name="start_date" id="start_date" class="form-control" placeholder="dd-mm-yyyy" value="<?php echo isset($form_input['start_date']) ? $form_input['start_date'] : ''; ?>">
                        <?php echo form_error('start_date'); ?>
                    </div>
                    <div class="col-md-2">
                        <label><?php echo $this->lang->line('to'); ?> <span class="text-danger">*</span></label>
                        <input type="text" name="end_date" id="end_date" class="form-control" placeholder="dd-mm-yyyy" value="<?php echo isset($form_input['end_date']) ? $form_input['end_date'] : ''; ?>">
                        <?php echo form_error('end_date'); ?>
                    </div>
                    <div class="col-md-2">
                        <label><?php echo $this->lang->line('user_id'); ?></label>
                        <input type="text" class="form-control" name="userid" id="userid" value="<?php echo isset($form_input['userid']) ? $form_input['userid'] : ''; ?>">
                        <?php echo form_error('userid'); ?>
                    </div>
					<div class="col-md-2">		
						<label>वर्ग</label>
						<select class="form-control" name="employees_class">
							<option value=""> -- चुने --</option>
								<?php $employees_class = employees_class(); 
								foreach ($employees_class as $yky => $yval) { ?>
									<option value="<?php echo $yky; ?>" <?php if ($this->input->post('employees_class') == $yky) {echo 'selected';} ?>><?php echo $yval; ?></option>
								<?php } ?>
						</select>
					</div>	
                    <div class="col-md-2">
                        <label><?php echo $this->lang->line('leave_type'); ?></label>
                        <select class="form-control" name="leave_type" id="leave_type">
                            <option value="" > -- <?php echo $this->lang->line('leave_select'); ?>-- </option>
                            <option value="cl" <?php echo (isset($form_input['leave_type']) && $form_input['leave_type'] == 'cl') ? 'selected' : ''; ?>><?php echo $this->lang->line('casual_leave'); ?></option>
                            <option value="ol" <?php echo (isset($form_input['leave_type']) && $form_input['leave_type'] == 'ol') ? 'selected' : ''; ?>><?php echo $this->lang->line('optional_leave'); ?></option>
                            <option value="el" <?php echo (isset($form_input['leave_type']) && $form_input['leave_type'] == 'el') ? 'selected' : ''; ?>><?php echo $this->lang->line('earned_leave'); ?></option>
                            <option value="hpl"<?php echo (isset($form_input['leave_type']) && $form_input['leave_type'] == 'hpl') ? 'selected' : ''; ?>><?php echo $this->lang->line('half_pay_leave'); ?></option>
                            <option value="ot" <?php echo (isset($form_input['leave_type']) && $form_input['leave_type'] == 'ot') ? 'selected' : ''; ?>><?php echo $this->lang->line('official_tour'); ?></option>
                            <option value="lwp" <?php echo (isset($form_input['leave_type']) && $form_input['leave_type'] == 'lwp') ? 'selected' : ''; ?>><?php echo $this->lang->line('leave_without_pay'); ?></option>
                            <option value="ld" <?php echo (isset($form_input['leave_type']) && $form_input['leave_type'] == 'ld') ? 'selected' : ''; ?>><?php echo $this->lang->line('leave_deduction'); ?></option>
                        </select>
                        <?php echo form_error('leave_type'); ?>
                    </div>
					<div class="col-md-2">
                        <label> प्रकार</label>
						<select name="leave_status" class="form-control">
							<option value="">सभी </option>
							<option value="approve" <?php echo (isset($form_input['leave_status']) && $form_input['leave_status'] == 'approve') ? 'selected' : ''; ?>>स्वीकृत </option> 
							<option value="pending" <?php echo (isset($form_input['leave_status']) && $form_input['leave_status'] == 'pending') ? 'selected' : ''; ?>>लंबित</option>
							<option value="deny" <?php echo (isset($form_input['leave_status']) && $form_input['leave_status'] == 'deny') ? 'selected' : ''; ?>>अस्वीकृत</option>
							<option value="cancel" <?php echo (isset($form_input['leave_status']) && $form_input['leave_status'] == 'cancel') ? 'selected' : ''; ?>>रद्द</option>
							<option value="approve_deny" <?php echo (isset($form_input['leave_status']) && $form_input['leave_status'] == 'approve_deny') ? 'selected' : ''; ?>>स्वीकृत या अस्वीकृत </option>
                            <option value="approve_deny_peding" <?php echo (isset($form_input['leave_status']) && $form_input['leave_status'] == 'approve_deny_peding') ? 'selected' : ''; ?>>स्वीकृत + अस्वीकृत + लंबित</option>
						</select>
                    </div>
                </div>
                <br/>
               
                <br/>
                <div class="row">
                    <div class="col-md-12">
                        <a class="btn btn-primary" role="button" data-toggle="collapse" href="#advanceSearch" aria-expanded="false" aria-controls="collapseExample">
                            Advance search
                          </a>                        
                          <div class="collapse" id="advanceSearch">
                            <div class="well">
                                <label>Select section</label>
								<?php $section_list = get_list(SECTIONS, null, null); //pre($section_list);  ?>
								<div class="form-group">
									<?php $ln = 1;
									foreach ($section_list as $seck => $sections) { ?>
											<div style="padding:10px; display: inline-block;" title="<?php echo $sections['section_name_en']; ?>">
												<input type="checkbox"  class="minimal" name="emp_section_id[]" value="<?php echo $sections['section_id']; ?>" />
												<?php echo $sections['section_name_hi']; ?>(<?php echo $sections['section_short_name']; ?>)
											</div> 
										<?php $ln++;
									} ?>  
								</div>
                            </div>
                          </div>
                    </div>
                </div>
                <br/>
                 <div class="row">
                    <div class="col-md-3">
                        <button type="submit" name="btnsearch" value="btnsearch_all" class="btn btn-primary" ><?php echo $this->lang->line('button_search'); ?> </button>
                    </div>
                </div>
                <hr class="clearfix"/>
                  <div class="row">
                    <div class="col-md-12">
                        <button type="submit" name="btnsearch"  value="btnsearch_today" class="btn btn-primary">Today</button>
                        <button type="submit" name="btnsearch"  value="btnsearch_tomorrow" class="btn btn-primary">Yesterday</button>
                        <button type="submit" name="btnsearch"  value="btnsearch_thisweek" class="btn btn-info">This Week</button>
                        <button type="submit" name="btnsearch"  value="btnsearch_lastweek" class="btn btn-info">Last Week</button>
                        <button type="submit" name="btnsearch"  value="btnsearch_thismonth" class="btn btn-warning" >This Month</button>
                        <button type="submit" name="btnsearch"  value="btnsearch_lastmonth" class="btn btn-warning">Last Month</button>
                        <button type="submit" name="btnsearch"  value="btnsearch_thisyear" class="btn btn-success">This Year</button>
                        <button type="submit" name="btnsearch"  value="btnsearch_lastyear" class="btn btn-success">Last Year</button>
                    </div>
                </div> 
            </form>
        </div>
    </div>
</div>	
<!-- Main content -->
<?php if ($process) { ?>
    <section class="content">
        <div class="row">
            <div class="col-md-12">
                <?php echo $this->session->flashdata('message'); ?>
                <div class="box box-info" id="divname">
                    <div class="box-header">
                        <i class="fa fa-inbox"></i><h3 class="box-title"><?php echo $this->lang->line('view_report'); ?></h3>
						 <div class="pull-right box-tools no-print"> 
							<button onclick="printContents('divname')" class="btn btn-primary ">Print</button>
							<button class="btn btn-warning" onclick="goBack()">पिछले पेज में वापस जायें</button>
						</div>
					</div><!-- /.box-header -->
					<div class="box-header bg-info">
						<p><?php echo isset($form_input['start_date']) ? 'दिनांक '.$form_input['start_date'] : ''; ?>
							<?php echo isset($form_input['end_date']) ? 'से दिनांक '.$form_input['end_date'].' तक' : ''; ?>
							<?php echo $form_input['leave_type'] != '' ? ' '.leaveType($form_input['leave_type'],true) : ''; ?> की रिपोर्ट|
						</p>
					</div><!-- /.box-header -->
                    <div class="box-body">                       
                        <table width="100%" class="table table-striped table-hover">
                            <thead>
                                <tr>
                                    <th><?php echo $this->lang->line('sno'); ?></th>
                                    <th>कर्मचारी की जानकारी</th>
                                    <th><?php echo $this->lang->line('leaves'); ?> <p class="bg-info">(अवकाश रिपोर्ट <?php echo isset($form_input['start_date']) ? 'दिनांक '.$form_input['start_date'] : ''; ?>
                        <?php echo isset($form_input['end_date']) ? 'से दिनांक '.$form_input['end_date'].' तक' : ''; ?>)</p> 
						<!--p class="bg-warning">Leave Remaining shows total leaves</p>--></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $sn = 1; 
								$leave_sub_type = null;
                                 $total = array(
                                    'cl' => 0,
                                    'ol' => 0,
                                    'el' => 0,
                                    'hpl' => 0,
                                );
                                if ($leave_reports) {
                                    foreach ($leave_reports as $row) {
                                        $user_details = get_user_details($row->emp_id); ?>
                                        <tr>
                                            <td><?php echo $sn; ?></td>
                                            <td>
                                                <?php echo $this->lang->line('unique_id'); ?> :- <b><?php echo $user_details[0]->emp_unique_id; ?></b><br/>
                                                <?php echo $this->lang->line('name'); ?> :- <b><a href="<?php echo base_url('leave')."/leave_details/".$user_details[0]->emp_id ?>" data-original-title="<?php echo get_employee_gender($user_details[0]->emp_id, false).' ' .$user_details[0]->emp_full_name ?>"  data-toggle="tooltip"><?php echo get_employee_gender($user_details[0]->emp_id, true).' ' .$user_details[0]->emp_full_name_hi; ?></a></b><br/>
                                                <?php echo $this->lang->line('post'); ?> :- <b><?php echo $user_details[0]->emprole_name_hi; ?></b><br/>
                                                <?php echo $this->lang->line('mobile_no'); ?> :- <b><?php echo $user_details[0]->emp_mobile_number; ?></b><br/>
                                                <?php echo $this->lang->line('email'); ?> :- <b><?php echo $user_details[0]->emp_email; ?></b><br/>
                                            </td>
                                            <td> 
                                                <table width="100%">
                                                    <tr class="text-center danger">
                                                        <th>अवकाश की प्रकृति</th>
                                                        <th>दिन</th>
                                                        <th>दिनांक से - दिनांक तक</th>
                                                        <th>कारण</th>
                                                        <th>स्थिति</th>
                                                        <th>आवेदन दिनांक</th>
                                                        <th>कार्यवाही </th>
                                                    </tr> 
                                                    <?php
													
													if($form_input['leave_type'] == 'ld'){
														$form_input['leave_type'] = 'cl';
														$leave_sub_type = 'ld';
													}
													//pre($leave_sub_type);
                                                    $resultas = $this->leave_model->get_reports($form_input['start_date'], $form_input['end_date'], $row->emp_id, $form_input['leave_type'], '',false, $leave_sub_type, $this->input->post('leave_status'));
                                                    if ($resultas != '') {
                                                        $total = array(
                                                            'cl' => 0,
                                                            'ol' => 0,
                                                            'el' => 0,
                                                            'hpl' => 0,
                                                        );
                                                        foreach ($resultas as $rowas) { 
                                                            
                                                            switch ($rowas->emp_leave_type) {
                                                                case 'cl':
                                                                    $total['cl'] = $rowas->emp_leave_approval_type ==  1 ? $rowas->emp_leave_no_of_days + $total['cl'] : $total['cl'] ;
                                                                    break;
                                                                case 'ol':
                                                                    $total['ol'] = $rowas->emp_leave_approval_type ==  1 ? $rowas->emp_leave_no_of_days + $total['ol'] : $total['ol'] ;
                                                                    break;
                                                                case 'el':
                                                                    $total['el'] = $rowas->emp_leave_approval_type ==  1 ? $rowas->emp_leave_no_of_days + $total['el'] : $total['el'] ;
                                                                    break;
                                                                case 'hpl':
                                                                    $total['hpl'] = $rowas->emp_leave_approval_type ==  1 ? ($rowas->emp_leave_no_of_days * 2 )+ $total['hpl'] : $total['hpl'] ;
                                                                    break;
                                                                default:
                                                                    break;
                                                            }
                                                            ?>                
                                                            <tr>
                                                                <td><a href="<?php echo base_url(); ?>leave/leave_log/<?php echo $rowas->emp_leave_movement_id; ?>"><?php echo leaveType($rowas->emp_leave_type,true); ?> </a>
																<br/><?php echo ($rowas->emp_leave_sub_type != '' ? '('.leaveType($rowas->emp_leave_sub_type, true).')' : '' );?></td>
                                                                <td><?php echo $rowas->emp_leave_no_of_days; ?></td>
                                                                <td><?php echo get_date_formate($rowas->emp_leave_date) .' - '.get_date_formate($rowas->emp_leave_end_date); ?></td>
                                                                <td><?php echo $rowas->emp_leave_reason; ?></td>
                                                                <td>
                                                                    <?php if($rowas->emp_leave_approval_type == 1) {
																		echo 'स्वीकृत';
																	} else if($rowas->emp_leave_approval_type == 3 || $rowas->emp_leave_forword_type == 3){
																		echo 'रद्द'; 
																	} else if($rowas->emp_leave_approval_type == 3 || $rowas->emp_leave_forword_type == 3){
																		echo 'रद्द';
																	} else if($rowas->emp_leave_approval_type == 0 && $rowas->emp_leave_forword_type != 3) {
																		echo 'अनिर्णीत'; 
																	} else if($rowas->emp_leave_approval_type == 2) {
																		echo 'अस्वीकृत';
																	}?>
                                                                </td>
                                                                <td>
                                                                <?php echo get_date_formate($rowas->emp_leave_create_date); ?>
                                                                </td>
                                                                 <td> <?php /* <label class="label label-info"><?php echo leave_status(true, $row->leave_status); ?></label> */ ?>
                                    <?php 
                                        if ($rowas->emp_leave_approval_type == 0) {
                                            if ($rowas->emp_leave_forword_type == 0) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_status_pending') . '</label>';
                                            } else if (($rowas->emp_leave_forword_type == 1) OR ( $rowas->emp_leave_forword_type == 2)) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_status_on_approval') . '</label>';
                                            } else if ($rowas->emp_leave_forword_type == 3) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_cancel') . '</label>';
                                            }
                                        } else if ($rowas->emp_leave_approval_type != 0) {
                                            if ($rowas->emp_leave_approval_type == 1) {
                                              echo $status =  ($rowas->emp_leave_type == 'ihpl') ? '<label class="label label-success">अवलोकित</label>' : '<label class="label label-success">'.$this->lang->line('leave_status_approve').'</label>';
                                            } else if ($rowas->emp_leave_approval_type == 2) {
                                                echo '<label class="label label-danger">' . $this->lang->line('leave_status_deny') . '</label>';
                                            } else if ($rowas->emp_leave_approval_type == 3) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_cancel') . '</label>';
                                            }
                                        }
                                        ?> </td> 
                                                            </tr>  
                                                        <?php  } ?> 
                                                    <?php } ?>
                                                </table>
                                               <?php /* <table width="100%">
                                                        <?php $leaves = $this->leave_model->getLeaves($row->emp_id); ?>
                                                        <tr class="text-center">
                                                           <th colspan="2"><?php echo leaveType('cl'); ?></th>
                                                           <th colspan="2"><?php echo leaveType('ol'); ?></th>
                                                           <th colspan="2"><?php echo leaveType('el'); ?></th>
                                                           <th colspan="2"><?php echo leaveType('hpl'); ?></th>
                                                        </tr>
                                                        <tr class="text-center"> <td class="bg-info">Leave taken</td><td class="bg-warning">Remaining</td><td class="bg-info">Leave taken</td><td class="bg-warning">Remaining</td><td class="bg-info">Leave taken</td><td class="bg-warning">Remaining</td><td class="bg-info">Leave taken</td><td class="bg-warning">Remaining</td></tr>
                                                        <tr class="text-center">
                                                           <td class="bg-info"><?php echo $total['cl']; ?> </td> <td class="bg-warning"> <?php echo $leaves->cl_leave; ?></td>
                                                           <td class="bg-info"><?php echo $total['ol']; ?> </td> <td class="bg-warning"> <?php echo $leaves->ol_leave; ?></td>
                                                           <td class="bg-info"><?php echo $total['el']; ?> </td> <td class="bg-warning"> <?php echo calculate_el($leaves->el_leave); ?></td>
                                                           <td class="bg-info"><?php echo $total['hpl']; ?> </td> <td class="bg-warning"> <?php echo $leaves->hpl_leave .' ('.calculate_hpl($leaves->hpl_leave).')'; ?></td>
                                                        </tr>
                                                </table>*/ ?>
                                            </td>                       
                                        </tr>		         
                                        <?php
                                        $sn++;
                                    }
                                    ?> 
                                    <?php
                                } else {
                                    echo "No record found!";
                                }
                                ?>
                            </tbody>
                        </table>
                    </div><!-- /.box-body -->
                </div><!-- /.box -->
            </div><!-- /.col -->
        </div><!-- /.row -->
    </section><!-- /.content -->
<?php } ?>

