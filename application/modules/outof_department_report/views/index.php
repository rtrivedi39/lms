<!-- Content Header (Page header) -->
<section class="content-header">
  <h1>
	<?php echo $title; ?>
  </h1>
  <ol class="breadcrumb">
	<li><a href="<?php echo base_url();?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
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
		  <div style="float:left"><h3 class="box-title">
			<?php echo $title_tab; 
			if($this->uri->segment(2) == 'approve_deny') {
				echo ' ('.$this->lang->line('approve_deny_button_label').')';
			}?>
		  </h3></div>
			<div style="float:right">			
			<a href="<?php echo base_url('outof_department_report');?>/add_report">
				<button class="btn btn-block btn-info"><?php echo $this->lang->line('add_button'); ?> </button>
			  </a>
			</div>
			<div style="float:right;margin-right: 10px;">
				<a href="javascript:history.go(-1)">
					<button class="btn btn-warning"><?php echo $this->lang->line('Back_button_label'); ?></button>
				</a>
				<?php if($user_is_forwader ){
					if($this->uri->segment(2) == 'approve_deny') {?>	
						<a href="<?php echo base_url(); ?>outof_department_report">
							<button class="btn btn-success"><?php echo $this->lang->line('view_own_application_button'); ?></button>
						</a>
					<?php } else{  ?>
						<a href="<?php echo base_url(); ?>outof_department_report/approve_deny">
							<button class="btn btn-success"><?php echo $this->lang->line('approve_deny_button_label'); ?></button>
						</a>
					<?php }?>
				<?php }?>					
			</div>
		</div><!-- /.box-header -->
		<?php  if ((in_array(7, explode(',',$current_emp_section_id ))) && ($userrole == 8 || $userrole == 4 || $userrole == 1 || $userrole == 3 || $userrole == 11 ) && ($this->uri->segment(2) != 'approve_deny' )) {?>
			<div class="box-header bg-info">
			<h3 class="box-title">विभाग के शासकीय सेवको की रिपोर्ट देखने के लिए खोजे</h3>
			 <?php 
                 $attributes_search_report = array('class' => 'form-signin', 'id' => 'formsearch_report', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                echo form_open('outof_department_report/search_report', $attributes_search_report);
                ?>  
					<div class="row">
						<div class="col-md-3">
							<label><?php echo $this->lang->line('report_from_date'); ?> <span class="text-danger">*</span></label>
							<input type="text"  id="report_from_date" class="form-control datepicker" name="report_from_date" placeholder="dd-mm-yyyy" value="<?php echo $this->input->post('report_from_date') != '' ? $this->input->post('report_from_date') : date('d-m-Y'); ?>" required>
						</div>
						<div class="col-md-3">
							<label><?php echo $this->lang->line('report_to_date'); ?> <span class="text-danger">*</span></label>
							<input type="text"  id="report_to_date" class="form-control datepicker" name="report_to_date" placeholder="dd-mm-yyyy" value="<?php echo $this->input->post('report_to_date') != '' ? $this->input->post('report_to_date') : date('d-m-Y'); ?>" required>
						</div>
						<?php /*<div class="col-md-3">
							<label><?php echo $this->lang->line('emp_unique_id'); ?></label>
							<input type="text"  id="emp_unique_id" class="form-control" name="emp_unique_id" placeholder="<?php echo $this->lang->line('emp_unique_id'); ?>" value="<?php echo $this->input->post('emp_unique_id') != '' ? $this->input->post('emp_unique_id') : ''; ?>">
						</div>	*/ ?>											
						<div class="col-md-3">
							<br/>
							<button type="submit" name=""  class="btn btn-primary" value= ""><?php echo $this->lang->line('search_button'); ?></button>
						</div>						
					</div>
				</form>
			</div>
		<?php } ?>
		 <div class="box-body">
		 <?php if($this->session->flashdata('update') || $this->session->flashdata('insert') || $this->session->flashdata('delete') ){ ?>  <div class="alert alert-success alert-dismissable hideauto">
			  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
			  <strong>
				  <?php  echo $this->session->flashdata('update');
				  echo $this->session->flashdata('delete');
				  echo $this->session->flashdata('insert'); ?>
			  </strong><br>
		  </div>
		  <?php }?>
		
		  <table id="example1" class="table ">
			<thead>
			  <tr>
				<th><?php echo $this->lang->line('sno_label'); ?></th>
				<th><?php echo $this->lang->line('id_label'); ?></th>
				<th><?php echo $this->lang->line('empployee_name_label'); ?></th>
				<th><?php echo $this->lang->line('report_where_go'); ?></th>				
				<th><?php echo $this->lang->line('report_when_go'); ?></th>				
				<th><?php echo $this->lang->line('report_aprox_time'); ?></th>				
				<th><?php echo $this->lang->line('report_status'); ?></th>				
				<th><?php echo $this->lang->line('report_create_at'); ?></th>				
				<th><?php echo $this->lang->line('report_cancel_reason'); ?></th>				
				<th><?php echo $this->lang->line('report_cancel_date'); ?></th>				
				<th><?php echo $this->lang->line('report_approval_emp_id').'-'.$this->lang->line('report_approval_date'); ?></th>				
			  	<th><?php echo $this->lang->line('report_action_label'); ?></th>	
			  </tr>
			</thead>
			<tbody>
			<?php 
				if($get_report){  
					$i=1; 
					foreach ($get_report as $key => $report) {							
					?>
						<tr>
						  <td><?php echo $i;?></td>
						  <td><?php echo $report['emp_unique_id']; ?></td>
						  <td><?php echo $report['emp_full_name_hi']; ?></td>
						  <td><?php echo $report['report_where_go']; ?></td>
						  <td><?php echo get_date_formate($report['report_when_go'],'d.m.Y h:i:s A'); ?></td>
						  <td><?php echo $report['report_aprox_time']; ?> मिनट</td>
						  <td><?php echo get_status($report['report_status'],$report['report_emp_id'], $report['report_approval_emp_id'] ); ?></td>
						  <td><?php echo get_date_formate($report['report_create_at'],'d.m.Y h:i:s A'); ?></td>
						  <td><?php echo $report['report_cancel_reason'] != '' ? $report['report_cancel_reason'] : '-'; ?></td>
						  <td><?php echo $report['report_cancel_date'] != '' ? get_date_formate($report['report_cancel_date']) : '-'; ?></td>
						  <td><?php echo $report['report_status'] != 0 ? getemployeeName($report['report_approval_emp_id'], true).'<br/>'.get_date_formate($report['report_approval_date']) : '-'; ?></td>
						  <td>
							<?php if($type_page == 'main' && $report['report_status'] == 0){ ?>
								<button type="button" class="btn btn-warning btn-block report_deny"  name="report_deny" 
								 onclick="report_deny('आप आवेदन रद्द करने जा रहे है?', <?php echo $report['report_id']; ?>)"> रद्द </button>
							<?php } else if($type_page == 'approve_deny' && $report['report_status'] == 0) { ?>
								<a href="<?php echo base_url(); ?>outof_department_report/approve/<?php echo$report['report_id']; ?>" class="btn  btn-twitter btn-block" onclick="return confirm('आप <?php echo $report['emp_full_name_hi']; ?> का आवेदन स्वीकृत करने जा रहे है?');">स्वीकृत करें</a>
								<button type="button" class="btn btn-warning btn-block report_deny"  name="report_deny" 
								onclick="report_deny('आप <?php echo $report['emp_full_name_hi']; ?> का आवेदन अस्वीकृत करने जा रहे है?', <?php echo $report['report_id']; ?>);"> अस्वीकृत  करें</button>
							<?php } else if($type_page == 'approve_deny' && $report['report_status'] == 1){ ?>
								<button type="button" class="btn btn-warning btn-block report_deny"  name="report_deny" 
								 onclick="report_deny('आप आवेदन रद्द करने जा रहे है?', <?php echo $report['report_id']; ?>)"> रद्द </button>
							<?php } else if($type_page == 'approve_deny' && $report['report_status'] == 2){ ?>
								
							<?php } ?>
						  </td>
						</tr>
			  <?php $i++; } 
				}  ?>
			</tbody>
			
		</table>
	  </div><!-- /.box-body -->
	</div><!-- /.box -->
	</div>
  </div><!-- /.row -->
  <!-- Main row -->
</section><!-- /.content -->

<script type="text/javascript">
  function is_delete(){
	var res = confirm('<?php echo $this->lang->line("delete_confirm_message"); ?>');
	if(res===false){
	  return false;
	}
  }
  
 function report_deny(msg, report_id){
	var retn = confirm(msg);
	if(retn == true){
		$('#reportId').val(report_id);
		$('#report_deny').modal('toggle');
	}
  }
</script>
<!-- Modal -->
<div class="modal fade" id="report_deny" tabindex="-1" role="dialog" aria-labelledby="denyModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel">आवेदन <?php echo $this->lang->line('report_cancel_reason'); ?> </h4>
            </div>
            <div class="modal-body">
             <?php 
                 $attributes_deny = array('class' => 'form-signin', 'id' => 'formdeny', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                echo form_open('outof_department_report/deny', $attributes_deny);
                ?>                
                    <div class="modal-body">
                        <input type="hidden" name="report_id" id="reportId" value="">
                        <label><?php echo $this->lang->line('report_cancel_reason'); ?></label>
                        <textarea name="deny_reson" class="form-control" required=""></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">रद्द</button>
                        <button type="submit" class="btn btn-primary" name="btndeny">अस्वीकृत  / रद्द करें</button>
                    </div>
                </form>
            </div>      
        </div>
    </div>
</div>

