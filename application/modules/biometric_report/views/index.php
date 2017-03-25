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
			  <a href="<?php echo base_url('biometric_report');?>/add_report">
				<button class="btn btn-block btn-info"><?php echo $this->lang->line('add_button'); ?> </button>
			  </a>
			</div>
			<div style="float:right;margin-right: 10px;">
				<a href="javascript:history.go(-1)">
					<button class="btn btn-block btn-warning"><?php echo $this->lang->line('Back_button_label'); ?></button>
				</a>
			</div>
		</div><!-- /.box-header -->
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
		
		  <table id="" class="table ">
			<thead>
			  <tr>
				<th><?php echo $this->lang->line('sno_label'); ?></th>
				<th><?php echo $this->lang->line('report_name'); ?></th>
				<th><?php echo $this->lang->line('report_month'); ?> / <?php echo $this->lang->line('report_year'); ?></th>
				<th><?php echo $this->lang->line('report_type'); ?></th>
				<th><?php echo $this->lang->line('report_status'); ?></th>
				<th><?php echo $this->lang->line('view_label'); ?></th>
				<th><?php echo $this->lang->line('actions'); ?></th>
			  </tr>
			</thead>
			<tbody>
			<?php 
				if(isset($get_report) && count($get_report) > 0){  
					$i=1; 
					foreach ($get_report as $key => $report) { ?>
						<tr>
						  <td><?php echo $i;?></td>
						  <td><?php echo $report['report_name']; ?></td>
						  <td><?php echo months($report['report_month'],true) .'/'.$report['report_year'] ;?></td>
						  <td><?php echo get_report_type($report['report_type']);?></td>
						  <td><?php if ($report['report_status'] == 1) echo "<label class='label label-success'>Active</label>"; else echo "<label class='label label-danger'>In Active</label>"; ?></td>
						  <td><a href="<?php echo base_url().'uploads/report/'.$report['report_doccument']; ?>" target="_blank"><i class="fa fa-eye"></i>  देखें </a></td>
						  <td>
							  <div class="btn-group">
								<a href="<?php echo base_url('biometric_report');?>/edit_report/<?php echo $report['report_id'];?>" class="btn  btn-twitter">Edit</a>
								<a href="<?php echo base_url('biometric_report');?>/delete_report/<?php echo $report['report_id'];?>" onclick="return is_delete();" class="btn  btn-danger">Delete</a>
							  </div>
							</td>
						</tr>
			  <?php $i++; }
			  }else {?>
				<tr>
					<td>
						No record found
					</td>
				</tr>
			  <?php }?>
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
