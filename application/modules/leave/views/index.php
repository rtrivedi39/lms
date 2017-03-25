<?php $year = $this->input->get('year') != '' ? $this->input->get('year') : date('Y');
 ?>
<section class="content-header">
    <h1>
        <?php echo $title ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Leave Dashboard</li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Small boxes (Start box) -->
    <div class="row">
        <?php $this->load->view('leave_dashboard')?>
    </div><!-- /.row -->
    <div class="row" id="divname1">
        <div class="col-md-12">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-inbox"></i><h3 class="box-title"><?php echo $this->lang->line('current_leave_status'); ?></h3>
                <div class="pull-right no-print"> 
						<button class="btn btn-warning" onclick="goBack()">पिछले पेज में वापस जायें</button>				
                        <button onclick="printContents('divname1')" class="btn btn-primary no-print">Print</button>                           
                    </div>
				</div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th><?php echo $this->lang->line('leave_type') ?></th>                           
                            <th><?php echo $this->lang->line('leave_start_date') ?></th>
                            <th><?php echo $this->lang->line('end_date') ?></th>  
                            <th><?php echo $this->lang->line('leave_days') ?></th>
                            <th><?php echo $this->lang->line('leave_reason') ?></th>
                            <th><?php echo $this->lang->line('headqurter_permosion') ?></th>
                            <th><?php echo $this->lang->line('half_day_status') ?></th>
                            <th><?php echo $this->lang->line('leave_status') ?></th>
                            <th><?php echo $this->lang->line('action_label') ?></th>
                            <th><?php echo $this->lang->line('print') ?></th>
                        </tr>
                        <?php
                        $r = 1;
                        $total_pen = array(
                            'cl' => 0,
                            'ol' => 0,
                            'el' => 0,
                            'hpl' => 0,                          
                        );
                        //pr($leaves_pending);
                        if (isset($leaves_pending)) {
                            foreach ($leaves_pending as $leave_det) {
                               ?>
                                <tr class="bg-<?php
                                    switch ($leave_det->emp_leave_type) {
                                        case 'cl':
                                            echo "info";                                       
                                                $total_pen['cl'] = ($leave_det->emp_leave_approval_type !=  1 && $leave_det->emp_leave_approval_type !=  3 && $leave_det->emp_leave_forword_type != 3) ? $leave_det->emp_leave_no_of_days + $total_pen['cl'] : $total_pen['cl'] ;
                                            break;
                                        case 'ol':
                                            echo "success";
                                            $total_pen['ol'] = ($leave_det->emp_leave_approval_type !=  1 && $leave_det->emp_leave_approval_type !=  3 && $leave_det->emp_leave_forword_type != 3) ? $leave_det->emp_leave_no_of_days + $total_pen['ol'] : $total_pen['ol'] ;                                       
                                            break;
                                        case 'el':
                                            echo "warning";
                                            $total_pen['el'] = ($leave_det->emp_leave_approval_type !=  1 && $leave_det->emp_leave_approval_type !=  3 && $leave_det->emp_leave_forword_type != 3) ? $leave_det->emp_leave_no_of_days + $total_pen['el'] : $total_pen['el'] ;                                        
                                            break;
                                        case 'hpl':
                                            echo "danger";
                                            $total_pen['hpl'] = ($leave_det->emp_leave_approval_type !=  1 && $leave_det->emp_leave_approval_type !=  3 && $leave_det->emp_leave_forword_type != 3) ? ($leave_det->emp_leave_no_of_days * 2)+ $total_pen['hpl'] : $total_pen['hpl'] ;                                           
                                            break;
                                        default:
                                            echo "transparent";
                                            break;
                                    }
                                    ?>">
                                    <td><?php echo $r; ?>.</td>
                                    <td><a href="<?php echo base_url(); ?>leave/leave_log/<?php echo $leave_det->emp_leave_movement_id; ?>"><?php echo!empty($leave_det->emp_leave_type) ? leaveType($leave_det->emp_leave_type, true) : '-' ?></a>
									<?php echo ($leave_det->emp_leave_sub_type != '' ? '('.leaveType($leave_det->emp_leave_sub_type, true).') <br/> <a href="'.base_url().'unis_bio_report">रिपोर्ट देखें</a>' : '' );?>
									</td>
                                    <td><?php
										if($leave_det->emp_leave_sub_type != '' && $leave_det->emp_leave_sub_type == 'ld'){
											echo  months(ltrim(get_date_formate($leave_det->emp_leave_date,'m'),0),true).', '.get_date_formate($leave_det->emp_leave_date,'Y');
										}else{
											echo ($leave_det->emp_leave_date != '1970-01-01') ? get_date_formate($leave_det->emp_leave_date) :  ' - ';
										} ?>
									</td>
                                    <td><?php
										if($leave_det->emp_leave_sub_type != '' && $leave_det->emp_leave_sub_type == 'ld'){
											echo  months(ltrim(get_date_formate($leave_det->emp_leave_date,'m'),0),true).', '.get_date_formate($leave_det->emp_leave_date,'Y');
										}else{
											echo ($leave_det->emp_leave_end_date != '1970-01-01') ? get_date_formate($leave_det->emp_leave_end_date) : ' - ';
										}
									?>
										<?php if($leave_det->sickness_date != $leave_det->emp_leave_date && $leave_det->sickness_date != '0000-00-00'){
                                         echo strtotime($leave_det->sickness_date) ? 
                                        '<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Sickness Certificate date '.get_date_formate($leave_det->sickness_date, 'd.m.Y').' and EL from '.get_date_formate($leave_det->emp_leave_date,'d.m.Y').' to '.date('d.m.Y',strtotime($leave_det->sickness_date.'-1 Day')).'">i</button>' : 
                                        '';  } ?>
									</td>
                                    <td><?php echo!empty($leave_det->emp_leave_no_of_days) ? 
                                            $leave_det->emp_leave_type == 'hpl' ? ($leave_det->emp_leave_no_of_days * 2) .' ('.$leave_det->emp_leave_no_of_days.')' : $leave_det->emp_leave_no_of_days : 
                                            '-' ?>
									</td>
                                    <td><?php echo!empty($leave_det->emp_leave_reason) ? $leave_det->emp_leave_reason : '-' ?></td>
                                    <td><?php echo $leave_det->emp_leave_is_HQ == 1 ? 
                                        $this->lang->line('yes').' ('.show_date_hq($leave_det->emp_leave_HQ_start_date).' - '.show_date_hq($leave_det->emp_leave_HQ_end_date).' )' :
                                        $this->lang->line('no'); ?>
                                        <?php if($leave_det->leave_message != '' && $leave_det->emp_leave_is_HQ == 1){ ?>
                                            <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="left" title="<?php echo $leave_det->leave_message; ?>">i</button>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo!empty($leave_det->emp_leave_half_type) ? $leave_det->emp_leave_half_type == 'FH' ? $this->lang->line('first_half') : $this->lang->line('second_half') : '-' ?></td>
                                    <td> <?php /* <label class="label label-info"><?php echo leave_status(true, $leave_det->leave_status); ?></label> */ ?>
                                    <?php 
                                        if ($leave_det->emp_leave_approval_type == 0) {
                                            if ($leave_det->emp_leave_forword_type == 0) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_status_pending') . '</label>';
                                            } else if (($leave_det->emp_leave_forword_type == 1) OR ( $leave_det->emp_leave_forword_type == 2)) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_status_on_approval') . '</label>';
                                            }
                                        } 
                                        ?> 
									</td>                                   
                                    <td>
                                        <?php if ($leave_det->emp_leave_forword_type == 0 && $leave_det->is_leave_return == 0) { ?>
                                            <a href="<?php echo base_url(); ?>leave/cancel/<?php echo $leave_det->emp_leave_movement_id; ?>" class="text-danger" onClick="return confirm('<?php echo 'क्या आप '.$leave_det->emp_leave_no_of_days.' दिन का '.leaveType($leave_det->emp_leave_type, true).' रद्द करना चाहते है|'; ?>');"><span class="fa fa-close"></span> <?php echo $this->lang->line('cancel_leave') ?></a>
                                        <?php } else if ($leave_det->emp_leave_forword_type == 1) { ?>
                                            <label class="label label-info"><?php echo  get_employee_gender($leave_det->forworder_gender, true, false).' ' .$leave_det->forworder_name; ?></label><br/>
                                            <label class="label label-success"><?php echo $this->lang->line('leave_forworeded_option'); ?></label><br/>
                                        <?php } else if ($leave_det->emp_leave_forword_type == 2) { ?>
                                            <label class="label label-info"><?php echo get_employee_gender($leave_det->forworder_gender, true, false).' ' .$leave_det->forworder_name; ?></label><br/>
                                            <label class="label label-danger"><?php echo $this->lang->line('leave_not_forworeded_option'); ?></label><br/>
                                        <?php } ?>
										<label class="label-info label">
											<?php  if ($leave_det->emp_leave_forword_date != '' && $leave_det->emp_leave_forword_date != '0000-00-00 00:00:00') {
												echo get_date_formate($leave_det->emp_leave_forword_date);
											} ?>
										</label> 
                                    </td>
                                    <td>
										<?php  if(empty($leave_det->emp_leave_sub_type) && $leave_det->emp_leave_sub_type != 'ld') { ?>
											<a href="<?php echo base_url(); ?>leave/print/<?php echo $leave_det->emp_leave_movement_id; ?>" class="btn btn-primary btn-block"><span class="fa fa-print"></span> <?php echo $this->lang->line('print_button') ?></a>
										<?php } if(!empty($leave_det->medical_files)) { ?>
										  <a href="<?php echo base_url(); ?>leave/attachments/<?php echo $leave_det->emp_leave_movement_id; ?>"  class="btn btn-info btn-xs btn-block">संलग्न  दस्तावेज</a>
										<?php }  ?> 
                                    </td>
                                </tr>
                                <?php
                                $r++;
                            }
                        } else {
                            ?><tr>  <td colspan="3"><?php echo $this->lang->line('no_record_found'); ?></td></tr><?php }
                        ?>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
	<?php
	if (!empty($leaves_return)) { ?>
	<div class="row" id="divname2">
        <div class="col-md-12">
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-inbox"></i><h3 class="box-title">पृच्छा किया हुआ अवकाश</h3>
                <div class="pull-right no-print"> 
                        <button onclick="printContents('divname2')" class="btn btn-primary no-print btn-block">Print</button>                           
                    </div>
				</div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th><?php echo $this->lang->line('leave_type') ?></th>                           
                            <th><?php echo $this->lang->line('leave_start_date') ?></th>
                            <th><?php echo $this->lang->line('end_date') ?></th>  
                            <th><?php echo $this->lang->line('leave_days') ?></th>
                            <th><?php echo $this->lang->line('leave_reason') ?></th>
                            <th>अधिकारी का नाम जिसने पृच्छा की है</th>
                            <th>पृच्छा का कारण</th>
                            <th>कार्यवाही</th>
                        </tr>
                        <?php
                        $r = 1;
                         
                        //pr($leaves_pending);
                       
                            foreach ($leaves_return as $leave_det) {
								if($leave_det->is_leave_return == 1){
                               ?>
                                <tr class="danger">
                                    <td><?php echo $r; ?>.</td>
                                    <td><a href="<?php echo base_url(); ?>leave/leave_log/<?php echo $leave_det->emp_leave_movement_id; ?>"><?php echo!empty($leave_det->emp_leave_type) ? leaveType($leave_det->emp_leave_type, true) : '-' ?></a></td>
                                    <td>
										<?php if($leave_det->emp_leave_sub_type != '' && $leave_det->emp_leave_sub_type == 'ld'){
											echo  months(ltrim(get_date_formate($leave_det->emp_leave_date,'m'),0),true).', '.get_date_formate($leave_det->emp_leave_date,'Y');
										}else{
											echo ($leave_det->emp_leave_date != '1970-01-01') ? get_date_formate($leave_det->emp_leave_date) : '-';
										}
									?> </td>
                                    <td><?php
										if($leave_det->emp_leave_sub_type != '' && $leave_det->emp_leave_sub_type == 'ld'){
											echo  months(ltrim(get_date_formate($leave_det->emp_leave_date,'m'),0),true).', '.get_date_formate($leave_det->emp_leave_date,'Y');
										}else{
											echo ($leave_det->emp_leave_end_date != '1970-01-01') ? get_date_formate($leave_det->emp_leave_end_date) : '-';
										}
										?>
										<?php if($leave_det->sickness_date != $leave_det->emp_leave_date && $leave_det->sickness_date != '0000-00-00'){
                                         echo strtotime($leave_det->sickness_date) ? 
                                        '<button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Sickness Certificate date '.get_date_formate($leave_det->sickness_date, 'd.m.Y').' and EL from '.get_date_formate($leave_det->emp_leave_date,'d.m.Y').' to '.date('d.m.Y',strtotime($leave_det->sickness_date.'-1 Day')).'">i</button>' : 
                                        '';  } ?>
									</td>
                                    <td><?php echo!empty($leave_det->emp_leave_no_of_days) ? 
                                            $leave_det->emp_leave_type == 'hpl' ? ($leave_det->emp_leave_no_of_days * 2) .' ('.$leave_det->emp_leave_no_of_days.')' : $leave_det->emp_leave_no_of_days : 
                                            '-' ?>
									</td>
                                    <td><?php echo!empty($leave_det->emp_leave_reason) ? $leave_det->emp_leave_reason : '-' ?></td>
                                    <td> 
                                    <?php 
                                        if ($leave_det->emp_leave_approval_type == 4 || $leave_det->emp_leave_forword_type == 4) {
											$return_user = $leave_det->leave_return_to_emp_id;
											echo getemployeeName($return_user, true);	
                                        } 
                                      ?> 
									</td>                                   
                                    <td>
                                      <?php 
                                        if (!empty($leave_det->emp_leave_deny_reason )) {
											echo $leave_det->emp_leave_deny_reason;	
                                        } 
                                      ?> 
                                    </td>
                                    <td>
                                      <button type="button" class="btn btn-warning btn-block btnreturn" 
										 name="btnreturn" 
										 data-leaveid="<?php echo $leave_det->emp_leave_movement_id; ?>" 
										 data-toggle="modal" data-target="#returnUser" 
										 data-typesof="<?php if ($leave_det->emp_leave_approval_type == 4) { echo 'approve';} else if($leave_det->emp_leave_forword_type == 4) { echo 'forward'; } ?>"
										 data-toaction="आप पृच्छा का उत्तर दे रहे है"
										 >
										 पृच्छा का उत्तर दें
									  </button>	
                                    </td>
                                </tr>
                                <?php
                                $r++;
                            }
						}
                        ?>
                    </table>
                </div><!-- /.box-body -->
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
	<?php } ?>
	
    <div class="row" id="divname">
        <div class="col-md-12">
            <div class="box box-success">
                <div class="box-header">
                    <i class="fa fa-inbox"></i><h3 class="box-title"><?php echo $this->lang->line('total_leaves'); ?> (<?php echo $year ; ?>)</h3>
                    <div class="pull-right no-print">                       
                        <button onclick="printContents('divname')" class="btn btn-primary no-print btn-block">Print</button>                           
                    </div>
					<div class="row">
						<div class="col-md-4">
							<select class="form-control pull-right" id="year_select">
							<?php $i = '2015'; while($i <= date('Y')+1) { ?>
								<option value="<?php echo $i ; ?>" <?php echo $year == $i ? 'selected' : ''; ?>><?php echo $i ;?></option>
							<?php $i++; } ?>
						</select>
						</div>
					</div>
                </div><!-- /.box-header -->
                <div class="box-body no-padding">
                    <table class="table">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th><?php echo $this->lang->line('leave_type') ?></th>                           
                            <th><?php echo $this->lang->line('when_date') ?></th>
                            <th><?php echo $this->lang->line('leave_days') ?></th>
                            <th><?php echo $this->lang->line('leave_reason') ?></th>
                            <th><?php echo $this->lang->line('headqurter_permosion') ?></th>
                            <th><?php echo $this->lang->line('half_day_status') ?></th>
							<th>आवेदन दिनांक</th>
							<th><?php echo $this->lang->line('onbehalf') ?></th>
                            <th><?php echo $this->lang->line('leave_status') ?></th>							
                            <th>कार्यवाही दिनांक</th>                            
                            <th>अवकाश स्वीकृत/ अस्वीकृत कारण</th>						
                            <th class="no-print"><?php echo $this->lang->line('order') ?></th>
                        </tr>
                        <?php
                        $r = 1;
                        $total_app = array(                           
                            'cl_app' => 0,
                            'ol_app' => 0,
                            'el_app' => 0,
                            'hpl_app' => 0,
                            'cl_can' => 0,
                            'ol_can' => 0,
                            'el_can' => 0,
                            'hpl_can' => 0,
                            'cl_rej' => 0,
                            'ol_rej' => 0,
                            'el_rej' => 0,
                            'hpl_rej' => 0,
                        );
                        if (isset($leaves_approve_deny_cancel)) {
                            foreach ($leaves_approve_deny_cancel as $details) {
                                ?>
                                <tr class="bg-<?php
                                    switch ($details->emp_leave_type) {
                                        case 'cl':
                                            echo "info";
                                           // if($this->input->post('leave_type') != 'cl') {
                                       
                                                $total_app['cl_app'] = $details->emp_leave_approval_type ==  1 ? $details->emp_leave_no_of_days + $total_app['cl_app'] : $total_app['cl_app'] ;
                                                $total_app['cl_rej'] = $details->emp_leave_approval_type ==  2 ? $details->emp_leave_no_of_days + $total_app['cl_rej'] : $total_app['cl_rej'] ;
                                                $total_app['cl_can'] = ($details->emp_leave_approval_type ==  3 || $details->emp_leave_forword_type == 3)? $details->emp_leave_no_of_days + $total_app['cl_can'] : $total_app['cl_can'] ;
                                           // } else{
                                              //  $total_app['cl'] = $total_app['cl_app'] = $total_app['cl_rej'] = $total_app['cl_can'] = '-';
                                           // }
                                            break;
                                        case 'ol':
                                            echo "success";
                                         
                                            $total_app['ol_app'] = $details->emp_leave_approval_type ==  1 ? $details->emp_leave_no_of_days + $total_app['ol_app'] : $total_app['ol_app'] ;
                                            $total_app['ol_rej'] = $details->emp_leave_approval_type ==  2 ? $details->emp_leave_no_of_days + $total_app['ol_rej'] : $total_app['ol_rej'] ;
                                            $total_app['ol_can'] = ($details->emp_leave_approval_type ==  3 || $details->emp_leave_forword_type == 3)? $details->emp_leave_no_of_days + $total_app['ol_can'] : $total_app['ol_can'] ;
                                            break;
                                        case 'el':
                                            echo "warning";
                                        
                                            $total_app['el_app'] = $details->emp_leave_approval_type ==  1 ? $details->emp_leave_no_of_days + $total_app['el_app'] : $total_app['el_app'] ;
                                            $total_app['el_rej'] = $details->emp_leave_approval_type ==  2 ? $details->emp_leave_no_of_days + $total_app['el_rej'] : $total_app['el_rej'] ;
                                            $total_app['el_can'] = ($details->emp_leave_approval_type ==  3 || $details->emp_leave_forword_type == 3)? $details->emp_leave_no_of_days + $total_app['el_can'] : $total_app['el_can'] ;
                                            break;
                                        case 'hpl':
                                            echo "danger";
                                            
                                            $total_app['hpl_app'] = $details->emp_leave_approval_type ==  1 ? ($details->emp_leave_no_of_days * 2) + $total_app['hpl_app'] : $total_app['hpl_app'] ;
                                            $total_app['hpl_rej'] = $details->emp_leave_approval_type ==  2 ? ($details->emp_leave_no_of_days * 2) + $total_app['hpl_rej'] : $total_app['hpl_rej'] ;
                                            $total_app['hpl_can'] = ($details->emp_leave_approval_type ==  3 || $details->emp_leave_forword_type == 3)? ($details->emp_leave_no_of_days * 2) + $total_app['hpl_can'] : $total_app['hpl_can'] ;
                                            break;
                                        default:
                                            echo "transparent";
                                            break;
                                    }
                                    ?>">
                                    <td><?php echo $r; ?>.</td>
                                    <td><a href="<?php echo base_url(); ?>leave/leave_log/<?php echo $details->emp_leave_movement_id; ?>"><?php echo!empty($details->emp_leave_type) ? leaveType($details->emp_leave_type, true) : '-' ?></a>
										<?php echo ($details->emp_leave_sub_type != '' ? '('.leaveType($details->emp_leave_sub_type, true).') <br/> <a href="'. base_url().'unis_bio_report">रिपोर्ट देखें</a>' : '' );?>
									</td>
                                    <td>
										<?php
										if($details->emp_leave_sub_type != '' && $details->emp_leave_sub_type == 'ld'){
											echo  months(ltrim(get_date_formate($details->emp_leave_date,'m'),0),true).', '.get_date_formate($details->emp_leave_date,'Y');
										}else{
											echo ($details->emp_leave_date != '1970-01-01') ? get_date_formate($details->emp_leave_date,'d.m.y') : '-';
											?>  से <?php
											echo ($details->emp_leave_end_date != '1970-01-01') ? get_date_formate($details->emp_leave_end_date,'d.m.Y') : '-';
										} ?>
                                      <?php  if($details->sickness_date != $details->emp_leave_date && $details->sickness_date != '0000-00-00'){
                                        echo strtotime($details->sickness_date) ? 
                                        '<span type="button" class="btn btn-info" data-toggle="tooltip" data-placement="left" title="Sickness Certificate date '.get_date_formate($details->sickness_date, 'd.m.Y').' and EL from '.get_date_formate($details->emp_leave_date,'d.m.Y').' to '.date('d.m.Y',strtotime($details->sickness_date.'-1 Day')).'">i</span>' : 
                                        '' ; } ?>
                                    </td>
                                    <td><?php echo!empty($details->emp_leave_no_of_days) ? 
                                            $details->emp_leave_type == 'hpl' ? ($details->emp_leave_no_of_days * 2) .' ('.$details->emp_leave_no_of_days.')' : $details->emp_leave_no_of_days : 
                                            '-' ?>
                                        <?php   if($details->sickness_date != $details->emp_leave_date && $details->emp_leave_type == 'hpl'){ 
                                                $diff =  day_difference_dates($details->sickness_date, $details->emp_leave_end_date) + 1; 
                                                 if(strtotime($details->sickness_date) != '') {
                                                    echo  " [Adjust in ".($diff * 2).'('.$diff.") days]" ;
                                                    //$total['hpl'] = $details->emp_leave_approval_type ==  1 ? ($diff * 2) + $total['hpl'] : $total['hpl'];
                                                 }
                                             } else {
                                                  //$total['hpl'] = $details->emp_leave_approval_type ==  1 ? ($details->emp_leave_no_of_days * 2) + $total['hpl'] : $total['hpl'];
                                             }
                                        ?>
                                    </td>
                                    <td><?php echo!empty($details->emp_leave_reason) ? $details->emp_leave_reason : '-' ?></td>
                                    <td><?php echo $details->emp_leave_is_HQ == 1 ? 
                                        $this->lang->line('yes').'('.show_date_hq($details->emp_leave_HQ_start_date).'-'.show_date_hq($details->emp_leave_HQ_end_date).')' : 
                                        $this->lang->line('no'); ?>
                                     <?php if($details->leave_message != '' && $details->emp_leave_is_HQ == 1){ ?>
                                            <button type="button" class="btn btn-info no-print" data-toggle="tooltip" data-placement="left" title="<?php echo $details->leave_message; ?>">i</button>
                                        <?php } ?>
                                    </td>  
                                    <td><?php echo!empty($details->emp_leave_half_type) ? $details->emp_leave_half_type == 'FH' ? $this->lang->line('first_half') : $this->lang->line('second_half') : '-' ?></td>
									<td><?php echo get_date_formate($details->emp_leave_create_date); ?></td>
                                    <td>
										<?php if($details->emp_leave_sub_type != '' && $details->emp_leave_sub_type == 'ld'){
											echo 'प्रशासकीय अधिकारी द्वारा';
										 } else{
											echo !empty($details->on_behalf_leave) ? $details->on_behalf_leave != $this->session->userdata('emp_id') ? get_employee_gender($details->onbehalf_gender, true, false).' ' .$details->onbehalf_name : $this->lang->line('self') : '-' ?>
										<?php } ?>
									</td>
                                    <td><?php
                                        if (!empty($details->emp_leave_forword_type)) {
                                            if ($details->emp_leave_approval_type == 1) {
                                                $status =  ($details->emp_leave_type == 'ihpl') ? 'अवलोकित' : $this->lang->line('leave_status_approve'); 
                                                echo '<label class="label label-success">' . $status . '</label>';
                                            }
                                            if ($details->emp_leave_approval_type == 2) {
                                                echo '<label class="label label-danger">' . $this->lang->line('leave_status_deny') . '</label>';
                                            }
                                            if ($details->emp_leave_approval_type == 3 || $details->emp_leave_forword_type == 3) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_cancel') . '</label>';
                                            }
											if($details->emp_leave_approval_type != 0 && $details->emp_leave_approval_emp_id != 0){
												$emp_mame = get_employee_gender($details->approver_gender, true, false).' ' .$details->approver_name;
											} else if($details->emp_leave_forword_type != 0 && $details->emp_leave_forword_emp_id != 0){
												$emp_mame = get_employee_gender($details->forworder_gender, true, false).' ' .$details->forworder_name;
											} else{
												$emp_mame = 'स्वयं';
											}
											echo '<br/><label class="label label-info">' . $emp_mame. '</label>';
                                        }
                                        ?>
									</td>
                                    <td><?php if ($details->emp_leave_forword_type != 0 && $details->emp_leave_approval_type == 0 ) {
											echo get_date_formate($details->emp_leave_forword_date);
										} else if($details->emp_leave_forword_type != 0 && ($details->emp_leave_approval_type != 0  )){
											echo get_date_formate($details->emp_leave_approvel_date);
										} ?>
									</td>
                                    <td><?php echo!empty($details->emp_leave_deny_reason) ? $details->emp_leave_deny_reason : '-' ?></td>
                                    <td class="no-print">
                                        <?php if ($details->emp_leave_approval_type == 1 && ($details->emp_leave_type == 'el' || $details->emp_leave_type == 'hpl') && $details->leave_order_number != null) {  
                                         if($details->ds_is_signature == 1){ ?>       
                                           <a href="<?php echo base_url(); ?>oder_sing/print_order/<?php echo $details->emp_leave_movement_id; ?>/<?php echo $details->ds_leave_mov_id == null ? '' : true ;?>/<?php echo $details->ds_leave_mov_id == null ? '' : true ;?>" class="btn btn-<?php echo $details->leave_order_number != null ? 'success' : 'primary' ;?> btn-block" ><span class="fa fa-print"></span> हस्ताक्षर आदेश
                                            </a>
                                      <?php } else {?>
                                            <a href="<?php echo base_url(); ?>leave/leave/print_order/<?php echo $details->emp_leave_movement_id; ?>" class="btn btn-primary btn-block"><span class="fa fa-print"></span> <?php echo $this->lang->line('print_button') ?></a>
                                        <?php   } ?>
                                        <?php   } ?>
                                       <?php  if(!empty($details->medical_files)) { ?>
										  <a href="<?php echo base_url(); ?>leave/attachments/<?php echo $details->emp_leave_movement_id; ?>"  class="btn btn-info btn-xs btn-block">संलग्न  दस्तावेज</a>
										<?php }  ?> 
                                    </td>
                                </tr>
                                <?php
                                $r++;
                            }
                        } else {
                            ?><tr>  <td colspan="3"><?php echo $this->lang->line('no_record_found'); ?></td></tr><?php }
                        ?>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer"> 
                    <h4><?php echo $this->lang->line('total_leaves'); ?> (दिन में )</h4>
                    <table class="table">
                            <tr>
                                <th colspan="5" class="bg-info text-center"><?php echo leaveType('cl', true); ?></th>
                                <th colspan="5" class="bg-success text-center"><?php echo leaveType('ol', true); ?></th>
                                <th colspan="5" class="bg-warning text-center"><?php echo leaveType('el', true); ?></th>
                                <th colspan="5" class="bg-danger text-center"><?php echo leaveType('hpl', true); ?></th>
                            </tr>
                            <tr>  <td class="bg-info">स्वीकृत</td> <td class="bg-info">लंबित</td><td class="bg-info">अस्वीकृत</td>  <td class="bg-info">रद्द</td> <td class="bg-info"> बाकी</td> 
                            <td class="bg-success">स्वीकृत</td>  <td class="bg-success">लंबित</td><td class="bg-success">अस्वीकृत</td>  <td class="bg-success">रद्द</td> <td class="bg-success">बाकी</td>
                             <td class="bg-warning">स्वीकृत</td>  <td class="bg-warning">लंबित</td><td class="bg-warning">अस्वीकृत</td>  <td class="bg-warning">रद्द</td> <td class="bg-warning">बाकी</td>
                               <td class="bg-danger">स्वीकृत</td> <td class="bg-danger">लंबित</td><td class="bg-danger">अस्वीकृत</td>  <td class="bg-danger">रद्द</td> <td class="bg-danger">बाकी</td></tr>
                            <tr>
                            <?php $total = array_merge($total_pen,$total_app); ?>
                                 <td class="bg-info"> <?php echo $total['cl_app']; ?></td> <td class="bg-info"><?php echo $total['cl']; ?> </td>
                                 <td class="bg-info"><?php echo $total['cl_rej']; ?></td> <td class="bg-info"><?php echo $total['cl_can']; ?></td> <td class="bg-info"> <b><?php echo $leaves->cl_leave; ?></b></td>
                                <td class="bg-success"><?php echo $total['ol_app']; ?></td> <td class="bg-success"><?php echo $total['ol']; ?> </td> 
                                 <td class="bg-success"><?php echo $total['ol_rej']; ?></td>  <td class="bg-success"><?php echo $total['ol_can']; ?></td class="bg-success"><td class="bg-success"> <b><?php echo $leaves->ol_leave; ?></b></td>
                              <td class="bg-warning"><?php echo $total['el_app']; ?></td>     <td class="bg-warning"><?php echo $total['el']; ?> </td>
                                <td class="bg-warning"><?php echo $total['el_rej']; ?></td>  <td class="bg-warning"><?php echo $total['el_can']; ?></td><td class="bg-warning"> <b><?php echo calculate_el($leaves->el_leave); ?></b></td>
                                <td class="bg-danger"> <?php echo $total['hpl_app'].' ('.  calculate_hpl($total['hpl_app']).')'; ?></td>   <td class="bg-danger"><?php echo $total['hpl'].' ('.  calculate_hpl($total['hpl']).')'; ?> </td>
                                <td class="bg-danger"><?php echo $total['hpl_rej'].' ('.  calculate_hpl($total['hpl_rej']).')'; ?></td> <td class="bg-danger"><?php echo $total['hpl_can'].' ('.  calculate_hpl($total['hpl_can']).')'; ?></td>  <td class="bg-danger"> <b><?php echo $leaves->hpl_leave.' ('.  calculate_hpl($leaves->hpl_leave).')'; ?></b></td>
                            </tr> 
                        </table>
                </div>
            </div><!-- /.box -->
            <div class="alert alert-warning no-print">
                <?php echo $this->lang->line('rule_not_changes_message'); ?>
            </div>
        </div><!-- /.col -->
    </div><!-- /.row -->
</section><!-- /.content -->

<div class="modal fade" id="returnUser" tabindex="-1" role="dialog" aria-labelledby="returnUser">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">अवकाश पर पृच्छा </h4>
            </div>
            <div class="modal-body">
            <?php
                     $attributes_leave_return_answer = array('class' => 'form-signin', 'id' => 'leaveleave_return_answer', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave/approve_deny/leave_return_answer', $attributes_leave_return_answer);
                    ?> 
             
                    <div class="modal-body">
                        <p id="toaction"></p>
						<div class="user_leave_taken form-group"></div>
						<div class="user_leave_details form-group"></div>
						<div class="form-group">
							<input type="hidden" name="leaveID" id="leavereturnID" class="leaveID" value="">
							<input type="hidden" name="types" id="types" class="types" value="forward">
							<label>पृच्छा का उत्तर</label>
							<textarea name="return_reason" class="form-control" required=""></textarea>
						</div>
						<div class="form-group">
							<label>दस्तावेज का नाम</label>
							<input type="text" name="document_name" id="document_name"  class="form-control" value="दस्तावेज">
						</div>
						<div class="form-group">   
						 <label>दस्तावेज जोड़े</label>						
						  <input type="file" name="document" id="document" accept=".pdf"  class="form-control" value="">
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