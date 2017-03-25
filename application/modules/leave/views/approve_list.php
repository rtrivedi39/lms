<!-- Content Header (Page header) -->
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
    <div class="leave row">
        <div class="col-xs-12">
            <div class="box box-info">              
                <div class="box-body">
                    <?php $this->load->view('leave_header') ?>
                </div>
            </div>
        </div>
    </div>
    <!-- Your Page Content Here -->
    <!-- Small boxes (Stat box) -->
    <div class="leave row" id="print_box">
        <div class="col-xs-12">
            <div class="box box-primary">
              <?php 
                     $attributes_bulkAction = array('class' => 'form-signin', 'id' => 'formbulkAction', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave/leave_approve/bulkAction', $attributes_bulkAction);
                    ?> 
                    <div class="box-header with-border no-print">
                        <h3 class="box-title"><?php echo $title_tab.' <b>['.$total_counts.']</b>'; ?></h3>
						<div class="pull-right tools">
							<button class="btn btn-warning" onclick="goBack()"><?php echo $this->lang->line('Back_button_label'); ?></button>
							<button onclick="printContents('print_box')" type="button" class="btn btn-primary no-print">Print</button>
						</div>
					</div>
					<div class="box-header with-border no-print">
                        <div class="row">
							<div class="col-md-4 pull-left text-left">
							   <?php  echo (!empty($pagermessage) ? $pagermessage : ''); ?><br/>
							   <?php pagination_entries_dropdown($total_counts)  ; ?>
							</div>
							<div class="col-md-8 pull-right text-right">
								<?php echo $pagination; ?>
							</div>
						</div>
					</div>
                    <div class="box-header with-border no-print">
                        <div class="leave row">
                            <div class="col-xs-2">
                                <label for="exampleInputEmail1"><?php echo $this->lang->line('bulk_action'); ?> </label>
                            </div>
                            <div class="col-xs-3">
                                <select name="bultselect"  class="form-control bultselect">
                                    <option value="" > -- <?php echo $this->lang->line('leave_select'); ?>-- </option>
                                    <option value="1"><?php echo $this->lang->line('leave_approve') ?></option>
                                   <?php if($userrole == 3){ ?>
									<option value="2"><?php echo $this->lang->line('leave_deny') ?></option>
								   <?php } ?>
							   </select>
                                <?php echo form_error('bultselect'); ?>
                            </div>
                            <div class="col-xs-3 bulk_action">
                                <button type="submit" class="btn btn-block btn-success btnbulk_action"><?php echo $this->lang->line('bulk_action'); ?></button>
                            </div>
                        </div>
                    </div>
                    <div class="box-body">
                        <?php echo $this->session->flashdata('message'); ?>
                        <table id="" class="table table-bordered table-striped">
                            <thead>
                                <tr>
                                    <th class="no-print"><input type="checkbox" id="selectall"/></th>
									<th><?php echo $this->lang->line('sno_short_label'); ?></th>
                                    <th><?php echo $this->lang->line('id_label'); ?></th>
									<th><?php echo $this->lang->line('leave_emp_name') . ' / ' . $this->lang->line('leave_emp_designation'); ?></th>
                                    <th><?php echo $this->lang->line('leave_reason'); ?></th>
                                    <th><?php echo $this->lang->line('apply_date_label'); ?></th>
                                    <th><?php echo $this->lang->line('leave_type'); ?></th>                                   
                                    <th><?php echo $this->lang->line('leave_start_date'); ?></th>
                                    <th><?php echo $this->lang->line('end_date'); ?></th>
                                    <th><?php echo $this->lang->line('leave_head_quoter'); ?></th>
									<th><?php echo $this->lang->line('leave_days'); ?></th>
                                    <th><?php echo $this->lang->line('leave_status'); ?></th>
								    <th><?php echo $this->lang->line('leave_approve_deny_reason_label'); ?></th>
                                    <th class="no-print"><?php echo $this->lang->line('action_button'); ?></th>
                                </tr>
                            </thead>
                            <tbody>
                            <?php  $i = 1;
                               //pre($details_leave);
                                foreach ($details_leave as $key => $leave) { ?>
									<tr <?php echo ($leave->is_leave_return == 1 ? "class='danger'" : '') ?>>
                                        <td class="no-print"><input type="checkbox" class="case leave_ids" name="leave_ids[]" value="<?php echo $leave->emp_leave_movement_id ?>"/></td>
                                        <td><?php echo $this->uri->segment(4)+$i ; ?></td>
									    <td><?php echo $leave->emp_unique_id ;?></td>
										<td><a href="<?php echo base_url('leave')."/leave_details/".$leave->emp_id ?>" data-original-title="<?php echo $leave->user_title_en.' ' .$leave->emp_full_name ?>"  data-toggle="tooltip"><?php echo $leave->user_title_hi.' '.$leave->emp_full_name_hi . '</a> / ' . $leave->emprole_name_hi; ?> </td>
                                        <td><?php echo $leave->emp_leave_reason ?></td>
                                        <td><?php echo get_date_formate($leave->emp_leave_create_date); ?></td>
                                        <td>
											<a href="<?php echo base_url(); ?>leave/leave_log/<?php echo $leave->emp_leave_movement_id; ?>"><?php echo leaveType($leave->emp_leave_type, true) ?></a> <?php echo ($leave->emp_leave_sub_type != '' ? '('.leaveType($leave->emp_leave_sub_type, true).')' : '' );?><br/><br/>
											<?php if($leave->is_leave_return == 1){ ?>
												<a href="<?php echo base_url(); ?>leave/leave_log/<?php echo $leave->emp_leave_movement_id; ?>" class="btn btn-warning btn-xs">पृच्छा देखें</a>
											<?php } ?>
										</td>
                                        <td><?php
										if($leave->emp_leave_sub_type != '' && $leave->emp_leave_sub_type == 'ld'){
											echo  months(ltrim(get_date_formate($leave->emp_leave_date,'m'),0),true).', '.get_date_formate($leave->emp_leave_date,'Y');
										}else{
											echo get_date_formate($leave->emp_leave_date);
										}?>
										</td>
                                        <td><?php
										if($leave->emp_leave_sub_type != '' && $leave->emp_leave_sub_type == 'ld'){
											echo  months(ltrim(get_date_formate($leave->emp_leave_date,'m'),0),true).', '.get_date_formate($leave->emp_leave_date,'Y');
										}else{
											echo get_date_formate($leave->emp_leave_end_date);
										}?>
										</td>
										<td><?php echo $leave->emp_leave_is_HQ == 1 ? 
                                        $this->lang->line('yes').'('.show_date_hq($leave->emp_leave_HQ_start_date).' - '.show_date_hq($leave->emp_leave_HQ_end_date).' )' : 
                                        $this->lang->line('no'); ?>
                                        <?php if($leave->leave_message != '' && $leave->emp_leave_is_HQ == 1){ ?>
                                            <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="left" title="<?php echo $leave->leave_message; ?>">i</button>
                                        <?php } ?>
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
											<?php if ($leave->emp_leave_forword_date != '' && $leave->emp_leave_forword_date != '') {
												echo get_date_formate($leave->emp_leave_forword_date);
											} ?>
										</label> 
										<?php if($leave->emp_leave_recommend_type != 0){
											echo '<br/>'.setRecomendMessage($leave->emp_leave_recommend_type,$leave->emp_leave_type); ?> 
											<br/><label class="label-primary label">
												<?php echo $leave->emp_leave_recommend_emp_id != 0 ? $leave->recommender_title_hi.' ' .$leave->recommender_name : null; ?>
											</label><br/>
											<label class="label-info label">
												<?php if ($leave->emp_leave_recommend_date != '' && $leave->emp_leave_recommend_date != '') {
													echo get_date_formate($leave->emp_leave_recommend_date);
												} ?>
											</label>
										<?php } ?>
										</td>
										<td>
										 <?php if($leave->emp_leave_deny_reason != ''){  echo $leave->emp_leave_deny_reason;  } ?>
										</td>
                                        <td>
                                            <button type="button" class="btn btn-success btn-block btnapprove" name="btnapprove" data-empid="<?php echo $leave->emp_id; ?>" data-leaveid="<?php echo $leave->emp_leave_movement_id; ?>" data-leaveType="<?php echo $leave->emp_leave_type; ?>" data-toggle="modal" data-target="#approveModal">
												<?php echo ($leave->emp_leave_type == 'ihpl' || $leave->emp_leave_type == 'jr') ? 'अवलोकित' : $this->lang->line('leave_approve') ?>
											</button>
											<?php $confirm_msg = $leave->emp_full_name_hi . '/' . $leave->emprole_name_hi.' का '.get_date_formate($leave->emp_leave_date, 'd.m.Y').' से '.get_date_formate($leave->emp_leave_end_date, 'd.m.Y') .' तक का '.leaveType($leave->emp_leave_type, true); ?>
											<?php if($leave->emp_leave_type != 'ihpl' && $leave->emp_leave_type != 'jr'){ ?>
												<button type="button" class="btn btn-danger btn-block btndeny" name="btndeny" data-empid="<?php echo $leave->emp_id; ?>" data-leaveid="<?php echo $leave->emp_leave_movement_id; ?>"  data-todeny="आप  <?php echo $confirm_msg; ?> पर कार्यवाही करने जा रहे है|" 
												data-leaveType="<?php echo $leave->emp_leave_type; ?>" data-toggle="modal" data-target="#denyModal"><?php echo $this->lang->line('leave_deny') ?></button>
											<?php }  ?> 
											<?php  if(!empty($leave->medical_files)) { ?>
                                              <a href="<?php echo base_url(); ?>leave/attachments/<?php echo $leave->emp_leave_movement_id; ?>"  class="btn btn-info btn-xs btn-block">संलग्न  दस्तावेज</a>
											<?php }  ?> 
											<?php if($leave->emp_leave_type != 'ihpl' || $leave->emp_leave_sub_type == null ) { ?>
											 <button type="button" class="btn btn-warning btn-block btnreturn" 
												 name="btnreturn" 
												 data-leaveid="<?php echo $leave->emp_leave_movement_id; ?>" 
												 data-toggle="modal" data-target="#returnUser"
												 data-toaction="आप  <?php echo $confirm_msg; ?> पर कार्यवाही करने जा रहे है|" 
												 data-typesof="approve"
												 >
												 पृच्छा करे
												 </button>	
											<?php }  ?> 	 
                                        </td>
                                    </tr>
								<?php
								$i++;
								}
								?>
                            </tbody>
							<tfoot>
								<tr><td colspan="14">
									<div class="row no-print">
									<hr class="clearfix">
									 <div class="col-xs-3">
										<select name="bultselect" class="form-control bultselect">
											<option value="" > -- <?php echo $this->lang->line('leave_select'); ?>-- </option>
											<option value="1"><?php echo $this->lang->line('leave_approve') ?></option>
											 <?php if($userrole == 3){ ?>
											<option value="2"><?php echo $this->lang->line('leave_deny') ?></option>
										   <?php } ?>
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
                        </table>
                    </div><!-- /.box-body -->
                </form>
            </div><!-- /.box -->
        </div>
    </div><!-- /.leave -->
    <!-- Main leave -->
</section><!-- /.content -->

<!-- Modal approve -->
<div class="modal fade" id="approveModal" tabindex="-1" role="dialog" aria-labelledby="approveModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line("leave_label"); ?> <?php echo $this->lang->line("leave_approve_button"); ?></h4>
            </div>
             <?php 
                     $attributes_approve = array('class' => 'form-signin', 'id' => 'formapprove', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave/leave_approve/approve', $attributes_approve);
                    ?> 
	
				<div class="modal-body" id="leave_approve_dialog">
					<div class="user_applied_leave">
						<h3><?php echo $this->lang->line("leave_applied_user_label"); ?></h3>
						<table width="100%">
							<tr><th><?php echo $this->lang->line("applicant_name_label"); ?></th><th><?php echo $this->lang->line("leave_type"); ?></th><th><?php echo $this->lang->line("start_date"); ?></th><th><?php echo $this->lang->line("end_date"); ?></th><th><?php echo $this->lang->line("leave_days"); ?></th></tr>
							<tr><td id="name_of_emp"></td><td id="typeleave_of_leave"></td>
							<td id="from_date_leave"></td>
							<td id="to_date_leave"></td>
							<td id="days_leave"></td>
							</tr>
						</table>
					</div>
					<div class="user_leave_taken form-group"></div>
					<div class="user_leave_details form-group"></div>
					<div class="form-group">
						<input type="hidden" name="leaveID" id="leaveIDapprove" class="leaveID" value="">
						<input type="hidden" name="appve_emp_id" id="appve_emp_id" class="appve_emp_id" value="">
						<label><?php echo $this->lang->line("leave_approve_reason_label"); ?></label>
						<textarea name="approve_reson" class="form-control"><?php echo checkUserrole()==1 ? 'यह अवकाश आई. टी. एडमिनिस्ट्रेटर के द्वारा सचिव / प्रमुख सचिव विधि की ओर से स्वीकृत किया गया है| जिसका आदेश क्रमांक   , दिनांक   है|' : 'अवकाश स्वीकृत किया जाता है|' ; ?></textarea>   
					</div>
				</div>
				<div class="modal-footer">
					<div class="pull-left">
						<span class="text-danger">* स्वीकृति हेतु लंबित</span>
					 </div>
					 <div class="pull-right">
						<button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("cancel_leave"); ?></button>
						<button type="submit" class="btn btn-primary" name="btnapprove"><?php echo $this->lang->line("leave_approve_button"); ?></button>
					</div>
				 </div>
             </form>
         </div>
	</div>
</div><!-- Modal deny-->
<div class="modal fade" id="denyModal" tabindex="-1" role="dialog" aria-labelledby="denyModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line("leave_label"); ?> <?php echo $this->lang->line("leave_deny_button"); ?></h4>
            </div>
             <?php 
                     $attributes_deny = array('class' => 'form-signin', 'id' => 'formdeny', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave/leave_approve/deny', $attributes_deny);
                    ?> 	
          
				 <div class="modal-body" id="leave_deny_dialog">
					<p id="todeny"></p>
					<div class="user_leave_taken form-group"></div>
					<div class="user_leave_details form-group"></div>
					<div class="form-group">
						<input type="hidden" name="leaveID" id="leaveIDdeny" class="leaveID" value="">
						<input type="hidden" name="appve_emp_id" id="appve_emp_id" class="appve_emp_id" value="">
						<label><?php echo $this->lang->line("leave_approve_reason_label"); ?></label>
						<textarea name="deny_reson" class="form-control" required=""><?php echo ($userrole == 3 ? $this->lang->line("leave_checked_label") : '');?></textarea>
					</div>
                 </div>
				 <div class="modal-footer">
					<div class="pull-left">
						<span class="text-danger">* स्वीकृति हेतु लंबित</span>
					 </div>
					 <div class="pull-right">
                      <button type="button" class="btn btn-default" data-dismiss="modal"><?php echo $this->lang->line("cancel_leave"); ?></button>
                      <button type="submit" class="btn btn-danger" name="btndeny"><?php echo $this->lang->line("leave_deny_button"); ?></button>
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
                     $attributes_leave_return = array('class' => 'form-signin', 'id' => 'formleave_return', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave/approve_deny/leave_return', $attributes_leave_return);
                    ?> 	
          
                    <div class="modal-body">
                        <p id="todeny"></p>						
						<div class="form-group">
							<label>पृच्छा किससे करना है|</label>
							<select class="form-control" name="returntoemp" id="returntoemp">
								<option value="applier">आवेदक </option>
								<option value="forwarder">अग्रेषितकर्ता </option>
								<option value="forwarder">अनुशंषितकर्ता </option>
							</select>
						</div>
						<div class="form-group">
							<input type="hidden" name="leaveID" id="leavereturnID" class="leaveID" value="">
							<input type="hidden" name="types" id="types" class="types" >
							<label>पृच्छा का कारण</label>
							<textarea name="return_reason" class="form-control" placeholder="आप पृच्छा क्यों कर रहे है, जरुर दर्ज करें|"  required=""></textarea>
						</div>
					</div>
                    <div class="modal-footer">
						<div class="pull-left">
							<span class="text-danger"></span>
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
