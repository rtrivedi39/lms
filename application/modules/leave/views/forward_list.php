<!-- Content Header (Page header) -->
<?php 
 $get_emp_est_sec = get_section_employee(7,4);
 $emp_est_sec = $get_emp_est_sec[0]->emp_id;
	
?>
<section class="content-header">
    <h1>
        <?php echo $title; ?>
		<?php 
		if($this->input->get('type') != ''){
			echo '['.leaveType($this->input->get('type'),true).']';
		}
		?>
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
            <div class="box box-info">
                <div class="box-header">
                    <h3 class="box-title"><?php //echo $title_tab_header;           ?></h3>
                </div>
                <div class="box-body">
                    <?php $this->load->view('leave_header') ?>
                </div>
            </div>
        </div>
    </div>

    <div class="row" id="print_box">
        <div class="col-xs-12">
            <div class="box box-primary">
             <?php 
            		 $attributes_bulkAction = array('class' => 'form-signin', 'id' => 'leaveleave_bulkAction', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave/leave_forward/bulkAction', $attributes_bulkAction);
                    ?>              
              
                    <div class="box-header with-border">
                        <h3 class="box-title"><?php echo $title_tab.' <b>['.$details_count.']</b>'; ?></h3>                 
						<div class="pull-right tools">
							<button class="btn btn-warning" onclick="goBack()"><?php echo $this->lang->line('Back_button_label'); ?></button>
							<button onclick="printContents('print_box')" type="button" class="btn btn-primary no-print">Print</button>
						</div>
					</div>
                    <div class="box-header with-border no-print">
                        <div class="row">
							<div class="col-md-4 pull-left text-left">
							   <?php  echo (!empty($pagermessage) ? $pagermessage : ''); ?><br/>
							   <?php  pagination_entries_dropdown($total_counts) ; ?>
							</div>
							<div class="col-md-8 pull-right text-right">
								<?php echo $pagination; ?>
							</div>
						</div>
					</div>
                    <div class="box-header no-print">
                        <div class="row">
                            <div class="col-xs-2">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('bulk_action'); ?> </label>
                            </div>
                            <div class="col-xs-3">
                                <select name="bultselect"  class="form-control bultselect">
                                    <option value="" > -- <?php echo $this->lang->line('leave_select'); ?>-- </option>
                                    <option value="1"><?php echo $this->lang->line('leave_session') ?></option>
                                </select>
                                <?php echo form_error('bultselect'); ?>
                            </div>
                            <div class="col-xs-3 bulk_action">
                                <button type="submit" class="btn btn-block btn-success btnbulk_action" id="btnbulk_action"><?php echo $this->lang->line('bulk_action'); ?></button>
                            </div>
							<div class="pull-right">
								<?php if($current_emp_role_id != 1) { ?>
								<div class="col-xs-5 margin">
									<a href="?nt=no_appr" class="btn btn-danger">अस्वीकृत अवकाश</a> 
								</div>
								<?php } ?>
								<?php if($current_emp_role_id == 4 && $emp_est_sec == $current_emp_id && $this->input->get('lvl') == ''){ ?>
								<div class="col-xs-5 margin">
									<a href="?lvl=all" class="btn btn-info">सभी कर्मचारी</a> 
								</div>	
								<?php } else if($this->input->get('lvl') != '' && $this->input->get('lvl') == 'all'){ ?>
									<div class="col-xs-5 margin">
									<a href="<?php base_url(); ?>leave_forward" class="btn btn-info">Direct reporting</a>
								</div>	
								<?php } ?>
							</div>
                        </div>
                    </div>
                    <div class="box-body">
                        <?php echo $this->session->flashdata('message'); ?>
                        <table id="" class="table table-bordered table-striped">
                            <thead>
                                <tr>
									<?php if($this->session->userdata('user_role') < 8) { ?>
                                    <th class="no-print"><input type="checkbox" id="selectall"  />
                                    </th>
                                    <?php  }?> 
                                    <th><?php echo $this->lang->line('sno_short_label'); ?></th>
                                    <th><?php echo $this->lang->line('id_label'); ?></th>
                                    <th><?php echo $this->lang->line('leave_emp_name') . ' / ' . $this->lang->line('leave_emp_designation'); ?></th>
                                    <th><?php echo $this->lang->line('leave_reason'); ?></th>
                                    <th><?php echo $this->lang->line('apply_date_label'); ?></th>                                 
                                    <th><?php echo $this->lang->line('leave_type'); ?> से <?php echo $this->lang->line('leave_start_date'); ?></th>
                                    <th><?php echo $this->lang->line('end_date'); ?></th>
									<th><?php echo $this->lang->line('for_EL_with_headquarter_permission'); ?></th>
									<th><?php echo $this->lang->line('leave_days'); ?></th>
									<th><?php echo $this->lang->line('leave_status'); ?></th>
									<th><?php echo $this->lang->line('leave_approve_deny_reason_label'); ?></th>
                                    <th class="no-print"><?php echo $this->lang->line('action_button'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php
                                $i = 1;                               
								foreach ($details_leave as $leave) { ?>	
									<tr <?php echo ($leave->is_leave_return == 1 ? "class='danger'" : '') ?>>
										<?php if($this->session->userdata('user_role') < 8) {  ?>
										<td class="no-print">
											<input type="checkbox" class="case leave_ids" name="leave_ids[]" value="<?php echo $leave->emp_leave_movement_id ?>"/>
										</td>
										<?php } ?>
										<td><?php echo $this->uri->segment(4)+$i ; ?></td>
										<td><?php echo $leave->emp_unique_id ;?></td>
										<td><a href="<?php echo base_url('leave')."/leave_details/".$leave->emp_id ?>" data-original-title="<?php echo $leave->user_title_en.' ' .$leave->emp_full_name ?>"  data-toggle="tooltip"><?php echo $leave->user_title_hi.' ' .$leave->emp_full_name_hi  . '</a> / ' . $leave->emprole_name_hi; ?></td>
										<td><?php echo $leave->emp_leave_reason; ?>
											 <br/>
											<?php if($leave->leave_message != '' && $leave->emp_leave_is_HQ == 1){ ?>
											<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="left" title="<?php echo $leave->leave_message; ?>">i</button>
										<?php } ?>
										</td>
										<td><?php echo get_date_formate($leave->emp_leave_create_date); ?></td>
										<td>
											<a href="<?php echo base_url(); ?>leave/leave_log/<?php echo $leave->emp_leave_movement_id; ?>"><?php echo leaveType($leave->emp_leave_type, true) ?></a> <?php echo ($leave->emp_leave_sub_type != '' ? '('.leaveType($leave->emp_leave_sub_type, true).')' : '' );?><br/><br/>
											<?php if($leave->is_leave_return == 1){ ?>
												<a href="<?php echo base_url(); ?>leave/leave_log/<?php echo $leave->emp_leave_movement_id; ?>" class="btn btn-warning btn-xs">पृच्छा देखें</a>
											<?php } ?>
										</td>
										<td>
										<?php
										if($leave->emp_leave_sub_type != '' && $leave->emp_leave_sub_type == 'ld'){
											echo  months(ltrim(get_date_formate($leave->emp_leave_date,'m'),0),true).', '.get_date_formate($leave->emp_leave_date,'Y');
										}else{
											echo get_date_formate($leave->emp_leave_date); ?> <br/> से <br/>
											<?php echo get_date_formate($leave->emp_leave_end_date);
										}?>
										</td>
									   <td><?php echo $leave->emp_leave_is_HQ == 1 ? 
										$this->lang->line('yes').'('.show_date_hq($leave->emp_leave_HQ_start_date).' - '.show_date_hq($leave->emp_leave_HQ_end_date).' )' : 
										$this->lang->line('no'); ?>
										
										</td>
										<td><?php echo $leave->emp_leave_no_of_days; 
										if (!empty($leave->emp_leave_half_type)) { ?>
											<span data-toggle="tooltip" class="btn btn-info" data-original-title="<?php echo $leave->emp_leave_half_type == 'FH' ? $this->lang->line('first_half') : $this->lang->line('second_half'); ?>">i</span>
										<?php } ?>
										</td>
										 <td><?php echo setForwordMessage($leave->emp_leave_forword_type,$leave->emp_leave_type); ?> <br/>
										<label class="label-waring label">
											<?php echo $leave->emp_leave_forword_emp_id != 0 ? $leave->forworder_title_hi.' ' .$leave->forworder_name : $leave->user_title_hi.' ' .$leave->emp_full_name_hi; ?>
										</label> <br/>
										<label class="label-info label">
											<?php  if ($leave->emp_leave_forword_date != null ) {
												echo get_date_formate($leave->emp_leave_forword_date);
											} ?>
										</label> 
										</td>
										<td>
											<?php if($leave->emp_leave_deny_reason != ''){  echo $leave->emp_leave_deny_reason;  } ?>
										</td>
										<td class="no-print">
											<?php $confirm_msg = $leave->user_title_hi .' '.$leave->emp_full_name_hi . '/' . $leave->emprole_name_hi.' का '.get_date_formate($leave->emp_leave_date, 'd.m.Y').' से '.get_date_formate($leave->emp_leave_end_date, 'd.m.Y') .' तक का '.leaveType($leave->emp_leave_type, true); ?>
											<?php  if ($leave->emp_leave_approval_type != 2) { ?>
													<button type="button" class="btn btn-warning btn-block btnforapprove" 
													 name="btnforapprove" data-work_allote="<?php echo ($leave->emp_onleave_work_allot != null ? $leave->emp_onleave_work_allot : ''); ?>"
													 data-leaveid="<?php echo $leave->emp_leave_movement_id; ?>" 
													 data-toggle="modal" data-target="#approveModal" data-empid="<?php echo $leave->emp_id; ?>" data-toaprove="आप  <?php echo $confirm_msg; ?> पर कार्यवाही करने जा रहे है|" >
													 <?php echo ($leave->emp_leave_type == 'ihpl' )  ? 'अवलोकित' :  $this->lang->line('leave_session'); ?>
													 </button>
											<?php } ?>
											<?php  if ($leave->emp_leave_approval_type == 2) { ?>
												 <button type="button" class="btn btn-warning btn-block btnresend" 
												 name="btndeny" 
												 data-leaveid="<?php echo $leave->emp_leave_movement_id; ?>" 
												 data-toggle="modal" data-target="#resendModel" onclick="return confirm('आप  <?php echo $confirm_msg; ?>  बदलने  जा रहे है| ');">
												 पुनः अग्रेषित करे
												 </button>											
											<?php } if($leave->emp_leave_type != 'ihpl') {?>
												<button type="button" class="btn btn-danger btndeny btn-block" name="btndeny" data-empid="<?php echo $leave->emp_id; ?>" data-leaveid="<?php echo $leave->emp_leave_movement_id; ?>" data-todeny="आप  <?php echo $confirm_msg; ?> पर कार्यवाही करने जा रहे है|"  
												data-toggle="modal" data-target="#denyModal"><?php echo $this->lang->line('leave_may_not_session') ?></button>
											<?php } if(!empty($leave->medical_files)) { ?>
                                              <a href="<?php echo base_url(); ?>leave/attachments/<?php echo $leave->emp_leave_movement_id; ?>"  class="btn btn-info btn-xs btn-block">संलग्न  दस्तावेज</a>
											<?php }  ?> 
											<?php if($leave->emp_leave_type != 'ihpl' ) { ?>
												<button type="button" class="btn btn-primary btn-block btnreturn" 
												 name="btnreturn" 
												 data-leaveid="<?php echo $leave->emp_leave_movement_id; ?>" 
												 data-toggle="modal" data-target="#returnUser"
												 data-toaction="आप  <?php echo $confirm_msg; ?> पर कार्यवाही करने जा रहे है|" 
												  data-typesof="forward"
												 >
												पृच्छा करे
											</button>	
											<?php }  ?> 
										</td>
									</tr>
									<?php  $i++; } ?>
                            </tbody>
                        </table>
						<tfoot>
						<tr>
						<td>
							<div class="row no-print">
								<hr class="clearfix">
								<div class="col-xs-3">
									<select name="bultselect"   class="form-control bultselect">
										<option value="" > -- <?php echo $this->lang->line('leave_select'); ?>-- </option>
										<option value="1"><?php echo $this->lang->line('leave_session') ?></option>
									</select>
									<?php echo form_error('bultselect'); ?>
								</div>
								<div class="col-xs-3 bulk_action">
									<button type="submit" class="btn btn-block btn-success btnbulk_action"><?php echo $this->lang->line('bulk_action'); ?></button>
								</div>
								<div class="col-xs-3 pull-right">
									<span class="text-danger bg-danger">पृच्छा किये गए अवकाश</span>
								</div>
						
                            </div>
							<hr class="clearfix">
							<div class="row no-print">
								<div class="col-md-4 pull-left text-left">
								   <?php  echo (!empty($pagermessage) ? $pagermessage : ''); ?>
								</div>
								<div class="col-md-8 pull-right text-right">
									<?php echo $pagination; ?>
								</div>
							</div>
							</td>
							</tr>
						</tfoot>
                    </div><!-- /.box-body -->
                </form>
            </div><!-- /.box -->
        </div>
    </div>
    <!-- /.row --><!-- Main row -->
</section><!-- /.content -->

<!-- Modal -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="denyModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('leave_session'); ?></h4>
            </div>
            <div class="modal-body">
              <?php 
                     $attributes_forword_leave = array('class' => 'form-signin', 'id' => 'aer', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave/leave_forward/forword_leave', $attributes_forword_leave);
                    ?>  
           
                    <div class="modal-body">
						<p id="toaprove"></p>
						<div class="user_leave_taken form-group"></div>
						<div class="user_leave_details form-group"></div>
                        <input type="hidden" name="leaveID" id="leaveID" value="">
						<input type="hidden" name="appve_emp_id" id="appve_emp_id" class="appve_emp_id" value="">
						<div class="form-group onleave_work_allot_box">
							<label for="exampleInputFile">शासकीय सेवक का नाम, जो इनके अवकाश पर होने पर कार्य करेगा| <span class="text-danger">*</span></label>
							<input type="text"  name="onleave_work_allot" id="onleave_work_allot"  class="form-control" value="<?php echo $this->session->userdata('user_role') < 8 ? '--' : '' ;?>" placeholder="कृपया नाम और पद  जरुर दर्ज करे"  <?php echo $this->session->userdata('user_role') < 8 ? '' : 'required'; ?>>
							<?php echo form_error('onleave_work_allot'); ?>
							<p class="help-block">यदि अवकाश के दिन आवेदन किया जाये तो <a id="onholyday" title="Click me" data-msg="शासकीय अवकाश पर होने पर लागू नहीं">शासकीय अवकाश पर होने पर लागू नहीं</a> दर्ज करे| </p>
							<label>कोई रिमार्क जोड़े (<?php echo $this->session->userdata('user_role') > 7 ? ' अनुभाग अधिकारी की टीप आवश्यक है |' : 'अगर जरुरी हो तो ' ;?> )  <span class="text-danger">*</span></label>
							<textarea name="any_remark" class="form-control" placeholder="" <?php echo $this->session->userdata('user_role') < 8 ? '' : 'required'; ?>></textarea>
						</div> 
                    </div>
                    <div class="modal-footer">
						<div class="pull-left">
							<span class="text-danger">* स्वीकृति हेतु लंबित</span>
						</div>
						<div class="pull-right">
							<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("cancel_leave"); ?></button>
							<button type="submit" class="btn btn-primary " name="btndeny" onclick="return confirm('कार्यवाही करे');"><?php echo $this->lang->line('leave_session'); ?></button>
						</div>
                    </div>
                </form>
            </div>      
        </div>
    </div>
</div>

<!-- Modal -->
<div class="modal fade" id="denyModal" tabindex="-1" role="dialog" aria-labelledby="denyModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">अवकाश निरस्त का कारण </h4>
            </div>
            <div class="modal-body">
              <?php 
                     $attributes_forword_leave = array('class' => 'form-signin', 'id' => 'aer', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave/leave_forward/deny', $attributes_forword_leave);
                    ?>  
                <!--<form action="<?php //echo base_url(); ?>leave/leave_forward/deny" accept-charset="UTF-8" role="form" class="form-signin" method="post" id="aer">-->
                    <div class="modal-body">
                        <p id="todeny"></p>
						<div class="user_leave_taken form-group"></div>
						<div class="user_leave_details form-group"></div>
						<div class="form-group">
							<input type="hidden" name="leaveID" id="leaveID" class="leaveID" value="">
							<input type="hidden" name="appve_emp_id" id="appve_emp_id" class="appve_emp_id" value="">
							<label><?php echo $this->lang->line('leave_reason'); ?></label>
							<textarea name="deny_reson" class="form-control" required=""></textarea>
						</div>
					</div>
                    <div class="modal-footer">
						<div class="pull-left">
							<span class="text-danger">* स्वीकृति हेतु लंबित</span>
						</div>
						<div class="pull-right">
							<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("cancel_leave"); ?></button>
							<button type="submit" class="btn btn-danger" name="btndeny"><?php echo $this->lang->line("leave_not_forworeded_option"); ?></button>
						</div>
                    </div>
                </form>
            </div>      
        </div>
    </div>
</div>

<div class="modal fade" id="resendModel" tabindex="-1" role="dialog" aria-labelledby="denyModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">अवकाश पुनः अग्रेषित </h4>
            </div>
              <?php 
                     $attributes_resend = array('class' => 'form-signin', 'id' => 'aer', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave/leave_forward/resend', $attributes_resend);
                    ?>  
        
				 <div class="modal-body">
						<div class="user_leaveails form-group"></div>
						<div class="form-group">
							<input type="hidden" name="leaveID" id="resendleaveid" class="leaveID" value="">
							<input type="hidden" name="appve_emp_id" id="appve_emp_id" class="appve_emp_id" value="">
							<label>अवकाश पुनः अग्रेषित  का कारण</label>
							<textarea name="resend_reson" class="form-control" required=""></textarea>
						</div> 
					</div> 
                    <div class="modal-footer">
						<div class="pull-left">
							<span class="text-danger">* स्वीकृति हेतु लंबित</span>
						</div>
						<div class="pull-right">
							<button type="button" class="btn btn-default" data-dismiss="modal">रद्द</button>
							<button type="submit" class="btn btn-primary" name="btndeny">पुनः भेजे</button>
						</div>
                    </div>
             </form>
        </div>
    </div>
</div>

<div class="modal fade" id="returnUser" tabindex="-1" role="dialog" aria-labelledby="returnUser">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">अवकाश पर पृच्छा </h4>
            </div>
            <div class="modal-body">
              <?php 
                     $attributes_leave_return = array('class' => 'form-signin', 'id' => 'aer', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave/approve_deny/leave_return', $attributes_leave_return);
                    ?>  
             
                    <div class="modal-body">
                        <p id="toaction"></p>						
						<div class="form-group">
							<input type="hidden" name="leaveID" id="leavereturnID" class="leaveID" value="">
							<input type="hidden" name="types" id="types" class="types">
							<label>पृच्छा का कारण</label>
							<textarea name="return_reason" class="form-control" placeholder="आप पृच्छा क्यों कर रहे है, जरुर दर्ज करें|" required=""></textarea>
						</div>
					</div>
                    <div class="modal-footer">
						<div class="pull-left">
							<span class="text-info">यह अवकाश आवेदक के पास जायेगा|</span>
						</div>
						<div class="pull-right">
							<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("cancel_leave"); ?></button>
							<button type="submit" class="btn btn-warning" name="btnreturn">Submit</button>
						</div>
                    </div>
                </form>
            </div>      
        </div>
    </div>
</div>

<script type="text/javascript">
    function is_delete() {
        var res = confirm('<?php echo $this->lang->line("delete_confirm_message"); ?>');
        if (res === false) {
            return false;
        }
    }
</script>
