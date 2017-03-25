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
		  <div style="float:left"><h3 class="box-title"><?php echo $title_tab;?></h3></div>
			<div style="float:right">
				<?php if(checkUserrole() != 1){ ?>
				  <a href="<?php echo base_url('joining_report');?>/add_report">
					<button class="btn btn-info"><?php echo $this->lang->line('add_button'); ?> </button>
				  </a>
				<?php } ?>
		
				<a href="javascript:history.go(-1)">
					<button class="btn  btn-warning"><?php echo $this->lang->line('Back_button_label'); ?></button>
				</a>
				<?php if((in_array(7, explode(',',$current_emp_section_id )) && $userrole == 8) || (in_array(7, explode(',',$current_emp_section_id )) && $userrole == 4) ||  $userrole == 1 || $userrole == 3){ ?>
					<?php if($all_view) { ?>
						<a href="<?php echo base_url('joining_report');?>">
							<button class="btn  btn-success"><?php echo $this->lang->line('view_own_application_button'); ?></button>
						</a>
					<?php } else{  ?>
						<a href="<?php echo base_url('joining_report');?>/index/all">
							<button class="btn  btn-success"><?php echo $this->lang->line('view_all_application_button'); ?></button>
						</a>
					<?php } ?>
				<?php } ?>
			</div>
		</div><!-- /.box-header -->
		<?php  if ((in_array(7, explode(',',$current_emp_section_id ))) && ($userrole == 8 || $userrole == 4 || $userrole == 1 || $userrole == 3 || $userrole == 11 ) && ($this->uri->segment(2) != 'approve_deny' )) {?>
			<div class="box-header bg-info">
			<h3 class="box-title">विभाग के शासकीय सेवको की रिपोर्ट देखने के लिए खोजे</h3>
			 <?php 
                     $attributes_search_report = array('class' => 'form-signin', 'id' => 'formsearch_report', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('joining_report/search_report', $attributes_search_report);
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
				<?php if($all_view) { ?>
					<th><?php echo $this->lang->line('id_label'); ?></th>
					<th><?php echo $this->lang->line('empployee_name_label'); ?></th>
				<?php } ?>
				<th><?php echo $this->lang->line('joining_report_date'); ?></th>				
				<th><?php echo $this->lang->line('joining_report_leave_type'); ?></th>				
				<th><?php echo $this->lang->line('leave_label') .' '.$this->lang->line('from_label'); ?>  - <?php echo $this->lang->line('to_label'); ?> था</th>				
				<th><?php echo $this->lang->line('remark_label'); ?></th>				
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
						 <?php if($all_view) { ?>
							<td><?php echo $report['emp_unique_id']; ?></td>
							<td><?php echo $report['emp_full_name_hi']; ?></td>
						  <?php } ?>
						  <td><?php echo get_date_formate($report['report_create_date'],'d.m.Y h:i:s A'); ?></td>
						  <td><?php echo leaveType($report['joining_report_leave_type'], true); ?></td>
						  <td><?php echo get_date_formate($report['report_from_date']).' - '.get_date_formate($report['report_to_date']); ?></td>
						  <td><?php echo $report['report_remark'] != '' ? $report['report_remark'] : '-'; ?></td>
						</tr>
			  <?php $i++; }
			  } ?>
			</tbody>
			<tfoot>
			<tr>
				<td colspan="7">
					<?php //echo $links; ?>
				</td>
			</tr>
			
			</tfoot>
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
</script>
