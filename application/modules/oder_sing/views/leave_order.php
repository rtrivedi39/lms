<?php
$emp_details= get_list(EMPLOYEES,null,array('emp_id'=>$this->session->userdata("emp_id")));
?>
<section class="content-header">
    <h1>
        <?php echo $title; ?>

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
			<div class="box box-warning">              
                <div class="box-body">
			
				</div>
			</div>	
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-inbox"></i><h3 class="box-title"><?php echo $title_tab; ?> </h3>
					
                <div class="pull-right box-tools"> 
				
                            <button disabled id="sign_button"  type="button" class="btn btn-primary no-print sign_button">हस्ताक्षर करें </button>
					        <a href="<?php echo base_url();?>oder_sing/sign_order/singorder" class="btn btn-primary no-print ">
					       हस्ताक्षर किये हुए आदेश
					        </a>
					        <button onclick="printContents('divname')" class="btn btn-primary "><?php echo $this->lang->line('print'); ?></button>
					<button class="btn btn-warning" onclick="goBack()"><?php echo $this->lang->line('go_back_opage'); ?></button>
				</div>
				
				
			</div><!-- /.box-header -->
				

                <div class="box-body">
                <?php
                     $attributes_applications = array('class' => 'no-print', 'id' => 'multi_sign_frm', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "application/json");
                    echo form_open('e_filelist/add_multi_signature', $attributes_applications);
                    ?>  
                    <table class="table table-bordered table-striped dataTable">
                        <thead>
						<tr>
                            <th style="width: 10px">#</th> 
							
                            <th>ID</th>                           
                            <th>Name</th>                           
                            <th><?php echo $this->lang->line('leave_type') ?></th>     
							                       
                            <th><?php echo $this->lang->line('leave_start_date') ?></th>
                            <th><?php echo $this->lang->line('end_date') ?></th>
                         
                            <th><?php echo $this->lang->line('leave_reason') ?></th>
                         <!--   <th><?php echo $this->lang->line('leave_status') ?></th> -->
                            <th><?php echo $this->lang->line('action_date'); ?></th>
                            <th><?php echo $this->lang->line('appication_date'); ?></th>
                            <th><?php echo "हस्ताक्षर हेतु आदेश"; ?></th>  
                            <th class="no-print"><?php echo $this->lang->line('print') ?></th>
                        </tr>
						</thead> 
						<tbody>
                        <?php  
							$r = 1;						
                      // pr($leave_order_lists);
                        if (isset($leave_order_lists)) {
						
                            foreach ($leave_order_lists as $row) {	
							 if($row->ds_is_signature == 0){						
                                ?>
                                <tr>
                                    <td><?php echo $r; ?>
									  <input type="checkbox" class="slct_file" id="<?php echo $row->ds_leave_mov_id; ?>" name="ck_file_id[<?php echo $r;?>]" value="<?php echo $row->ds_leave_mov_id; ?>"/>
                                       
									</td>
									<td><?php echo $row->emp_unique_id; ?></td>
									<td><?php echo $row->emp_title_hi.' ' .$row->emp_full_name_hi; ?></td>
									<td> <a href="<?php echo base_url(); ?>leave/leave_log/<?php echo $row->emp_leave_movement_id; ?>"><?php echo!empty($row->emp_leave_type) ? leaveType($row->emp_leave_type, true) : '-' ?></a></td>
                                    
                                  <td><?php echo ($row->emp_leave_date != '1970-01-01') ? get_date_formate($row->emp_leave_date) : '-' ?> </td>
                                    <td><?php echo ($row->emp_leave_end_date != '1970-01-01') ? get_date_formate($row->emp_leave_end_date) : '-' ?> </td>
                                    <td><?php echo!empty($row->emp_leave_reason) ? $row->emp_leave_reason : '-' ?></td>   <td><?php if ($row->emp_leave_forword_type == 1 && $row->emp_leave_approval_type == 0) {
											echo get_date_formate($row->emp_leave_forword_date);
										} else if($row->emp_leave_forword_type == 1 && $row->emp_leave_approval_type == 1 ){
											echo get_date_formate($row->emp_leave_approvel_date);
										} ?>
									 </td>
                                 <td><?php echo get_date_formate($row->emp_leave_create_date); ?></td>
                                                                 
                                  
                                  <td>
                                         <a target="_blank" title="<?php echo word_limiter(strip_tags(base64_decode($row->ds_content_final)), 200); ?>" href="<?php echo base_url(); ?>leave/leave/print_order/<?php echo $row->emp_leave_movement_id; ?>/1/1"> देखे </a>
                                    </td>
                                 
                                     <td class="no-print">
									 <?php 
									 if($row->ds_is_signature == 1){
									 
									 if ($row->emp_leave_approval_type == 1 && ($row->emp_leave_type == 'el' || $row->emp_leave_type == 'hpl') ) { ?>
                                           <a href="<?php echo base_url(); ?>leave/leave/print_order/<?php echo $row->emp_leave_movement_id; ?>/<?php echo $row->ds_leave_mov_id == null ? '' : true ;?>/<?php echo $row->ds_leave_mov_id == null ? '' : true ;?>" class="btn btn-<?php echo $row->leave_order_number != null ? 'success' : 'primary' ;?>"><span class="fa fa-print"></span> 
											<?php if(enable_order_gen($current_emp_id) == true || ((in_array(7, explode(',', $current_emp_section_id ))) &&  (in_array($userrole, array(8))) )) { ?>
											<?php echo $row->ds_leave_mov_id == null ? 'देखें एवं सुरक्षित करें' : 'print' ;?>
											<?php }  else {
												echo $row->ds_leave_mov_id == null ? 'print  ' : 'print' ;
											}?>
											</a>
                                        <?php   } ?>
                                      <?php if($row->medical_files !=  '') { ?>
                                            <a href="<?php echo base_url(); ?>uploads/medical_files/<?php echo $row->medical_files; ?>" target="_blank">Certificate</a>
                                        <?php }} ?>
								
									<input type="hidden" name="file_mark_sec_id7" value="7" />
    <input type="hidden" name="file_status[<?php echo $r;?>]" value="e" />
	  <input type="hidden" name="file_param1[<?php echo $r;?>]" value="<?php echo urlencode($row->ds_content_final);?>" />
      <input type="hidden" name="file_param2[<?php echo $r;?>]" value="<?php echo $row->ds_leave_mov_id; ?>" /> <!--Movent id -->
	  <input type="hidden" name="file_param3[<?php echo $r;?>]" value="6"/><!--emp level-->
       <input type="hidden" name="up_down" value="leave"/><!--  leave for insertt in leave table-->
    <input type="hidden" name="file_param4[<?php echo $r;?>]" value="<?php echo $row->ds_signature_emp_id;?>" /><!--emp login id-->
		<input type="hidden" name="file_draft_id[<?php echo $r;?>]" value="<?php echo $row->ds_leave_mov_id; ?>" id="file_draft_id<?php echo $row->ds_leave_mov_id; ?>"/>										   

                                     </td>
                                </tr>
                                <?php
                                $r++;
                               
                            }}
                        } else {
                            ?><tr>  <td colspan="3"><?php echo $this->lang->line('no_record_found'); ?></td></tr><?php }
                        ?>
														
						</tbody>
                    </table><input type="hidden" value="0" id="total_slct_count"/>				
				<input type="hidden" value="0" id="total_nu_radio_selected"/>
		
				
				<div class="pull-right" style="margin: 10px;">
				
                            <button disabled id="sign_button"  type="button" class="btn btn-primary no-print sign_button">हस्ताक्षर करें </button>
				
				</div>
                </div><!-- /.box-body -->
                <div class="box-footer">                 
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
   
</section><!-- /.content -->

