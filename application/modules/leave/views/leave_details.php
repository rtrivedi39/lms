<?php
$emp_details= get_list(EMPLOYEES,null,array('emp_id'=>$this->session->userdata("emp_id")));
$year = $this->input->post('year_select') != '' ? $this->input->post('year_select') : date('Y');
?>
<section class="content-header">
    <h1>
        <?php echo $title.'('.$year.')'; ?>

    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Leave Details</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Start box) -->
  
    <div class="row" id="divname">
        <div class="col-md-12">
            <?php echo $this->session->flashdata('message'); ?>
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-inbox"></i><h3 class="box-title"><?php echo $title_tab; ?> 
                    <b> (<?php echo getemployeeName($id,true) //."/ ". getemployeeRole($id); ?>)</b>  <?php echo $year; ?></h3><br/>
					
                <div class="pull-right box-tools no-print">
					<button onclick="printContents('divname')" class="btn btn-primary ">Print</button>
					<button class="btn btn-warning" onclick="goBack()">पिछले पेज में वापस जायें</button>
				</div>
				<hr class="clearfix">
                 <?php
                     $attributes_leave_details_search = array('class' => 'form-leave', 'id' => 'leaveleave_details_search', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave_details_search/'.$id, $attributes_leave_details_search);
                    ?>  
				<!--<form action="<?php //echo base_url(); ?>leave_details_search/<?php //echo $id; ?>" method="post">-->
				<div class="row no-print">
					<div class="col-md-2">
						<select class="form-control pull-right" id="year_select_" name="year_select">
							<?php 
							$i = '2015'; while($i <= date('Y')+1) { ?>
								<option value="<?php echo $i ; ?>" <?php echo $year == $i ? 'selected' : ''; ?>><?php echo $i ;?></option>
							<?php $i++; } ?>
						</select>
					</div>
					<div class="col-md-8">
						<?php foreach(leaveType(null,true) as $key => $value){ ?>
							<label><input type="checkbox" value="<?php echo $key; ?>" name="leave_type[]"> <?php echo $value; ?></label>
						<?php } ?>
					</div>
					<div class="col-md-2">
						<button type="submit" name="" class="btn btn-primary">Search</button>
					</div>
				</div>
				</form>
				
			</div><!-- /.box-header -->
				

                <div class="box-body no-padding">
                    <table class="table">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th><?php echo $this->lang->line('leave_type') ?></th>                           
                            <th><?php echo $this->lang->line('leave_start_date') ?> 
                            <?php echo $this->lang->line('end_date') ?></th>  
                            <th><?php echo $this->lang->line('leave_days') ?></th>
                            <th><?php echo $this->lang->line('leave_reason') ?></th>
                            <th><?php echo $this->lang->line('headqurter_permosion') ?></th>
                            <th><?php echo $this->lang->line('half_day_status') ?></th>
                            <th><?php echo $this->lang->line('leave_status') ?></th>
                            <th><?php echo $this->lang->line('actions') ?></th>
                            <th>कार्यवाही दिनांक</th>
                            <th><?php echo $this->lang->line('onbehalf') ?></th>
                            <th>आवेदन दिनांक</th>
                             <th>अवकाश स्वीकृत/ अस्वीकृत कारण</th>  
                            <th class="no-print"><?php echo $this->lang->line('print') ?></th>
                        </tr>
                        <?php
                        $r = 1;
                        $total = array(
                            'cl' => 0,
                            'ol' => 0,
                            'el' => 0,
                            'hpl' => 0,
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
                        //pr($leaves_pending);
                        if (isset($leave_detail_lists)) {
                            foreach ($leave_detail_lists as $row) {
                                ?>
                                <tr class="bg-<?php
                                    switch ($row->emp_leave_type) {
                                        case 'cl':
                                            echo "info";
                                           // if($this->input->post('leave_type') != 'cl') {
                                                $total['cl'] = ($row->emp_leave_approval_type !=  1 && $row->emp_leave_approval_type !=  3 && $row->emp_leave_forword_type != 3) ? $row->emp_leave_no_of_days + $total['cl'] : $total['cl'] ;
                                                $total['cl_app'] = $row->emp_leave_approval_type ==  1 ? $row->emp_leave_no_of_days + $total['cl_app'] : $total['cl_app'] ;
                                                $total['cl_rej'] = $row->emp_leave_approval_type ==  2 ? $row->emp_leave_no_of_days + $total['cl_rej'] : $total['cl_rej'] ;
                                                $total['cl_can'] = ($row->emp_leave_approval_type ==  3 || $row->emp_leave_forword_type == 3)? $row->emp_leave_no_of_days + $total['cl_can'] : $total['cl_can'] ;
                                           // } else{
                                              //  $total['cl'] = $total['cl_app'] = $total['cl_rej'] = $total['cl_can'] = '-';
                                           // }
                                            break;
                                        case 'ol':
                                            echo "success";
                                            $total['ol'] = ($row->emp_leave_approval_type !=  1 && $row->emp_leave_approval_type !=  3 && $row->emp_leave_forword_type != 3) ? $row->emp_leave_no_of_days + $total['ol'] : $total['ol'] ;
                                            $total['ol_app'] = $row->emp_leave_approval_type ==  1 ? $row->emp_leave_no_of_days + $total['ol_app'] : $total['ol_app'] ;
                                            $total['ol_rej'] = $row->emp_leave_approval_type ==  2 ? $row->emp_leave_no_of_days + $total['ol_rej'] : $total['ol_rej'] ;
                                            $total['ol_can'] = ($row->emp_leave_approval_type ==  3 || $row->emp_leave_forword_type == 3)? $row->emp_leave_no_of_days + $total['ol_can'] : $total['ol_can'] ;
                                            break;
                                        case 'el':
                                            echo "warning";
                                            $total['el'] = ($row->emp_leave_approval_type !=  1 && $row->emp_leave_approval_type !=  3 && $row->emp_leave_forword_type != 3) ? $row->emp_leave_no_of_days + $total['el'] : $total['el'] ;
                                            $total['el_app'] = $row->emp_leave_approval_type ==  1 ? $row->emp_leave_no_of_days + $total['el_app'] : $total['el_app'] ;
                                            $total['el_rej'] = $row->emp_leave_approval_type ==  2 ? $row->emp_leave_no_of_days + $total['el_rej'] : $total['el_rej'] ;
                                            $total['el_can'] = ($row->emp_leave_approval_type ==  3 || $row->emp_leave_forword_type == 3)? $row->emp_leave_no_of_days + $total['el_can'] : $total['el_can'] ;
                                            break;
                                        case 'hpl':
                                            echo "danger";
                                            $total['hpl'] = ($row->emp_leave_approval_type !=  1 && $row->emp_leave_approval_type !=  3 && $row->emp_leave_forword_type != 3) ? ($row->emp_leave_no_of_days * 2)+ $total['hpl'] : $total['hpl'] ;
                                            $total['hpl_app'] = $row->emp_leave_approval_type ==  1 ? ($row->emp_leave_no_of_days * 2) + $total['hpl_app'] : $total['hpl_app'] ;
                                            $total['hpl_rej'] = $row->emp_leave_approval_type ==  2 ? ($row->emp_leave_no_of_days * 2) + $total['hpl_rej'] : $total['hpl_rej'] ;
                                            $total['hpl_can'] = ($row->emp_leave_approval_type ==  3 || $row->emp_leave_forword_type == 3)? ($row->emp_leave_no_of_days * 2) + $total['hpl_can'] : $total['hpl_can'] ;
                                            break;
                                        default:
                                            echo "transparent";
                                            break;
                                    }
                                    ?>">
                                    <td><?php echo $r; ?>.</td>
									<td><a href="<?php echo base_url(); ?>leave/leave_log/<?php echo $row->emp_leave_movement_id; ?>"><?php echo!empty($row->emp_leave_type) ? leaveType($row->emp_leave_type, true) : '-' ?></a>
                                       <?php echo ($row->emp_leave_sub_type != '' ? '('.leaveType($row->emp_leave_sub_type, true).')' : '' );?>
									   <?php if($row->is_leave_return == 1){ ?>
                                        <a href="<?php echo base_url(); ?>leave/leave_log/<?php echo $row->emp_leave_movement_id; ?>" class="btn btn-warning btn-xs">पृच्छा देखें</a>
                                    <?php } ?>
                                    </td>
                                    <td>
										<?php
										if($row->emp_leave_sub_type != '' && $row->emp_leave_sub_type == 'ld'){
											echo  months(ltrim(get_date_formate($row->emp_leave_date,'m'),0),true).', '.get_date_formate($row->emp_leave_date,'Y');
										}else{
											echo ($row->emp_leave_date != '1970-01-01') ? get_date_formate($row->emp_leave_date,'d.m.y') : '-';
											?>  से <?php
											echo ($row->emp_leave_end_date != '1970-01-01') ? get_date_formate($row->emp_leave_end_date,'d.m.Y') : '-';
										} ?>
									</td>
                                 
                                    <td><?php echo!empty($row->emp_leave_no_of_days) ? 
                                            $row->emp_leave_type == 'hpl' ? ($row->emp_leave_no_of_days * 2) .' ('.$row->emp_leave_no_of_days.')' : $row->emp_leave_no_of_days : 
                                            '-' ?>
                                        <?php   if($row->sickness_date != $row->emp_leave_date && $row->emp_leave_type == 'hpl'){ 
                                                $diff =  day_difference_dates($row->sickness_date, $row->emp_leave_end_date) + 1; 
                                                 if(strtotime($row->sickness_date) != '') {
                                                    echo  " [Adjust in ".($diff * 2).'('.$diff.") days] due to sickness date ".get_date_formate($row->sickness_date) ;
                                                    //$total['hpl'] = $row->emp_leave_approval_type ==  1 ? ($diff * 2) + $total['hpl'] : $total['hpl'];
                                                 }
                                             } else {
                                                  //$total['hpl'] = $row->emp_leave_approval_type ==  1 ? ($row->emp_leave_no_of_days * 2) + $total['hpl'] : $total['hpl'];
                                             }
                                        ?>
                                    </td>       
                                    <td><?php echo!empty($row->emp_leave_reason) ? $row->emp_leave_reason : '-' ?></td>
                                    <td><?php echo $row->emp_leave_is_HQ == 1 ? 
                                        $this->lang->line('yes').'('.show_date_hq($row->emp_leave_HQ_start_date).' - '.show_date_hq($row->emp_leave_HQ_end_date).')' : 
                                        $this->lang->line('no'); ?>
                                    <?php if($row->leave_message != '' && $row->emp_leave_is_HQ == 1){ ?>
                                            <button type="button" class="btn btn-info" data-toggle="tooltip" data-placement="left" title="<?php echo $row->leave_message; ?>">i</button>
                                        <?php } ?>
                                    </td>
                                    <td><?php echo!empty($row->emp_leave_half_type) ? $row->emp_leave_half_type == 'FH' ? $this->lang->line('first_half') : $this->lang->line('second_half') : '-' ?></td>
                                  <td> <?php /* <label class="label label-info"><?php echo leave_status(true, $row->leave_status); ?></label> */ ?>
                                    <?php 
                                        if ($row->emp_leave_approval_type == 0) {
                                            if ($row->emp_leave_forword_type == 0) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_status_pending') . '</label>';
                                            } else if (($row->emp_leave_forword_type == 1) OR ( $row->emp_leave_forword_type == 2)) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_status_on_approval') . '</label>';
                                            } else if ($row->emp_leave_forword_type == 3) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_cancel') . '</label>';
                                            }
                                        } else if ($row->emp_leave_approval_type != 0) {
                                            if ($row->emp_leave_approval_type == 1) {
                                              echo $status =  ($row->emp_leave_type == 'ihpl') ? '<label class="label label-success">अवलोकित</label>' : '<label class="label label-success">'.$this->lang->line('leave_status_approve').'</label>';
                                            } else if ($row->emp_leave_approval_type == 2) {
                                                echo '<label class="label label-danger">' . $this->lang->line('leave_status_deny') . '</label>';
                                            } else if ($row->emp_leave_approval_type == 3) {
                                                echo '<label class="label label-warning">' . $this->lang->line('leave_cancel') . '</label>';
                                            }
                                        }
                                        ?> </td>                                  
                                         <td>
                                        <?php if ($row->emp_leave_approval_type == 0) {
                                            if ($row->emp_leave_forword_type == 0) { ?>
                                                <a href="<?php echo base_url(); ?>leave/cancel/<?php echo $row->emp_leave_movement_id; ?>" class="text-danger" onClick="return confirm('<?php echo 'क्या आप '.$row->emp_leave_no_of_days.' दिन का '.leaveType($row->emp_leave_type, true).' रद्द करना चाहते है|'; ?>');"><span class="fa fa-close"></span> <?php echo $this->lang->line('cancel_leave') ?></a>
                                                <?php } else if ($row->emp_leave_forword_type == 1) { ?>
                                                    <label class="label label-info"><?php echo get_employee_gender($row->forworder_gender, true, false).' ' .$row->forworder_name;; ?></label>
                                                    
                                                <?php } else if ($row->emp_leave_forword_type == 2) { ?>
                                                    <label class="label label-info"><?php echo get_employee_gender($row->forworder_gender, true, false).' ' .$row->forworder_name;; ?></label>
                                                   
                                                 <?php }  else if ($row->emp_leave_forword_type == 3) { ?>
                                                     <label class="label label-info"><?php echo ($row->forworder_name != '' ? get_employee_gender($row->forworder_gender, true, false).' ' .$row->forworder_name : 'स्वयं'); ?></label>
                                                   
                                                <?php } 
                                        }  else if ($row->emp_leave_approval_type != 0){
                                            if ($row->emp_leave_approval_type == 1) { ?>
                                                <label class="label label-info"><?php echo get_employee_gender($row->approver_gender, true, false).' ' .$row->approver_name; ?></label>
                                                
                                           <?php  } else if ($row->emp_leave_approval_type == 2) { ?>
                                                <label class="label label-info"><?php echo get_employee_gender($row->approver_gender, true, false).' ' .$row->approver_name; ?></label>
                                             
                                           <?php  } else if ($row->emp_leave_approval_type == 3) { ?>
                                                <label class="label label-info"><?php echo get_employee_gender($row->approver_gender, true, false).' ' .$row->approver_name; ?></label>
                                              
                                           <?php  } 
                                        } ?>
                                    </td>
                                    <td><?php if ($row->emp_leave_approval_type != 0) {
											echo get_date_formate($row->emp_leave_approvel_date);
										} else if($row->emp_leave_forword_type != 0 && $row->emp_leave_approval_type == 0) {
											echo get_date_formate($row->emp_leave_forword_date);
										} else{
											echo get_date_formate($row->emp_leave_create_date);
										}?>
									</td>
                                    <td>
										<?php if($row->emp_leave_sub_type != '' && $row->emp_leave_sub_type == 'ld'){
											echo 'प्रशासकीय अधिकारी द्वारा';
										 } else{
											echo !empty($row->on_behalf_leave) ? $row->on_behalf_leave != $this->session->userdata('emp_id') ? get_employee_gender($row->onbehalf_gender, true, false).' ' .$row->onbehalf_name  : $this->lang->line('self') : '-' ?>
										<?php } ?>
									</td>
                                    <td><?php echo get_date_formate($row->emp_leave_create_date); ?></td>
                                     <td><?php echo!empty($row->emp_leave_deny_reason) ? $row->emp_leave_deny_reason : '-' ?></td>
                                    <td class="no-print">
									<div class="btn-group ">
										<a href="<?php echo base_url(); ?>leave/print/<?php echo $row->emp_leave_movement_id; ?>" class="btn btn-primary btn-block"><span class="fa fa-print"></span> <?php echo $this->lang->line('print_button') ?></a>
										<?php //if (($row->emp_leave_approval_type != 3) || ($row->emp_leave_approval_type != 2) || ($row->emp_leave_forword_type != 3) || ($row->emp_leave_forword_type != 2)){
										if ((in_array(7, explode(',',$emp_details[0]['emp_section_id'])) && checkUserrole() == 8) || checkUserrole() == 1){?>
											<?php if($row->ds_is_signature != 1 ){ ?>
												<a href="<?php echo base_url(); ?>leave/approve_deny/cancel/<?php echo $row->emp_leave_movement_id; ?>" class="btn  btn-twitter btn-block <?php
												if ($row->emp_leave_approval_type == 3 OR $row->emp_leave_approval_type == 2 or $row->emp_leave_forword_type == 3 OR $row->emp_leave_forword_type == 2) {
													echo "disabled";
												}
												$confirm_msg = $row->user_name . '/' . $row->emprole_name_hi.' का '.get_date_formate($row->emp_leave_date, 'd.m.Y').' से '.get_date_formate($row->emp_leave_end_date, 'd.m.Y') .' तक का '.leaveType($row->emp_leave_type, true);
												?>" onclick="return confirm('आप  <?php echo $confirm_msg; ?>  रद्द करने जा रहे है| ');"> रद्द</a>

												<a href="<?php echo base_url(); ?>leave/modify_leave/<?php echo $row->emp_leave_movement_id; ?>" class="btn btn-twitter btn-block
												<?php if ($row->emp_leave_approval_type == 3 OR $row->emp_leave_approval_type == 2 or $row->emp_leave_forword_type == 3 OR $row->emp_leave_forword_type == 2) {
													echo "disabled";
												} ?>" onclick="return confirm('आप  <?php echo $confirm_msg; ?>  बदलने  जा रहे है| ');">बदले</a>
											<?php } ?>
										<?php } ?>
										 <?php if ($row->emp_leave_approval_type == 1 && ($row->emp_leave_type == 'el' || $row->emp_leave_type == 'hpl') && $row->leave_order_number != null && ($userrole == 1 || $userrole == 8) && (in_array(7, explode(',',$emp_details[0]['emp_section_id'])))) {
                                            if($row->ds_is_signature == 1){?>       
                                           <a href="<?php echo base_url(); ?>oder_sing/print_order/<?php echo $row->emp_leave_movement_id; ?>/<?php echo $row->ds_leave_mov_id == null ? '' : true ;?>/<?php echo $row->ds_leave_mov_id == null ? '' : true ;?>" class="btn btn-<?php echo $row->leave_order_number != null ? 'success' : 'primary' ;?> btn-block" ><span class="fa fa-print"></span> हस्ताक्षर आदेश
                                            </a>
                                      <?php } else {?>
                                            <a href="<?php echo base_url(); ?>leave/leave/print_order/<?php echo $row->emp_leave_movement_id; ?>" class="btn btn-primary btn-block"><span class="fa fa-print"></span> <?php echo $this->lang->line('print_button') ?> आदेश</a>
                                        <?php   } ?>
										<?php }  ?>
									 </div>
                                     <?php  if(!empty($row->medical_files)) { ?>
										  <a href="<?php echo base_url(); ?>leave/attachments/<?php echo $row->emp_leave_movement_id; ?>"  class="btn btn-info btn-xs btn-block">संलग्न  दस्तावेज</a>
										<?php }  ?> 
                                        <?php if($userrole == 1){ ?>
                                            <a href="<?php echo base_url(); ?>leave/leave/cancel_with_msg/<?php echo $row->emp_leave_movement_id; ?>" class="btn btn-primary btn-block" <?php if ($row->emp_leave_approval_type == 3 OR $row->emp_leave_approval_type == 2 or $row->emp_leave_forword_type == 3 OR $row->emp_leave_forword_type == 2) {
                                                echo "disabled"; 
                                            } ?>><span class="fa fa-print"></span>  Cancel with MSG</a>
                                        <?php } ?>
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
                    <div class="col-md-12">                         
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
                    <div class="col-md-6">
                        
                    </div>
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
   
</section><!-- /.content -->
