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
			<h3 class="box-title">Bio metric report</h3>
			<div class="pull-right box-tools no-print"> 
				<button onclick="printContents('report_ptrint')" class="btn btn-primary ">Print</button>
				<button class="btn btn-warning" onclick="goBack()">पिछले पेज में वापस जायें</button>
			</div>		  
		</div><!-- /.box-header -->		
		 <div class="box-body" id="report_ptrint">		
		  <?php 
		   $line_sep = '---------------------------------------------------------------------------'; 
		  $no = 1;
		  if($search_report){		 
			foreach($emp_unique_ids as $row){
			$get_report = $this->unis_bio_report_model->get_report_date_range($fromdate, $todate, $row->bio_user_id);
				//pre($get_report);
				if(!empty($get_report)){ ?>
					<h2 class="text-center"><?php echo $no; ?>) Law Department</h2>
					<h4 class="text-center">Monthly Performance from <?php echo get_date_formate($this->input->post('report_from_date'),'d/m/Y'); ?> To <?php echo get_date_formate($this->input->post('report_to_date'),'d/m/Y'); ?></h4>
					<p class="text-center"><?php echo $line_sep; ?></p>
					<p class="text-center">Unique id : - <b><?php echo $get_report['bio_user_id']; ?></b> 
					Name :- <b><?php echo ($get_report['emp_full_name'] == null ? $get_report['bio_user_name'] : $get_report['emp_title_en'].' '.$get_report['emp_full_name']); ?></b></p>
					<p class="text-center"> Run Date & Time : <b><?php echo date('d/m/Y H:i'); ?></b> </p>
					<p class="text-center"><?php echo $line_sep; ?></p>
					<table width="100%" style="margin-bottom:20px;">
					<thead>
					  <tr>
						<th><?php echo $this->lang->line('sno_label'); ?></th>				
						<th>Date</th>				
						<th>Days</th>				
						<th>Shift In</th>
						<th>Shift Out</th>				
						<th>Status</th>				
					  </tr>
					</thead>
					<tbody>
						<?php 
						$total_present = 0;
						$total_holiday = 0;
						$total_leave   = 0;
						$i = 1; 	
						
						$begin = new DateTime( get_date_formate($this->input->post('report_from_date'),'Y-m-d') );
						$end_date = date('Y-m-d', strtotime($this->input->post('report_to_date').' +1 day'));
						$end = new DateTime($end_date);

						$interval = DateInterval::createFromDateString('1 day');
						$period = new DatePeriod($begin, $interval, $end);					
							foreach ( $period as $dt ){
								$crnt = $dt->format("Ymd");
								$time_in = $this->unis_bio_report_model->get_intime($crnt,$row->bio_user_id);
								$time_out = $this->unis_bio_report_model->get_outime($crnt,$row->bio_user_id)	;						
								
								$in_time = get_datetime_formate($time_in,'h:i:s A');
								$out_time = get_datetime_formate($time_out ,'h:i:s A');
								
								$holiday = check_holidays(get_date_formate($crnt,'Y-m-d'));
								$class = "";
								$status = "";
								if($holiday == true){
									$class = "bg-danger";
									$sts =( holidays_name($crnt) == false ? get_date_formate($crnt,'D') : holidays_name($crnt));
									$status = 'WO'.' ('.$sts.')';
									$total_holiday =  $total_holiday + 1;
								} else if($holiday == false && $time_in == '-' && $time_out == '-'){
									$class = "bg-warning";
									$leave = check_leave($crnt,$get_report['emp_id']);								
									$status = $leave == false ? 'A' : $leave;								
									$total_leave =  $total_leave + 1;
								} else {
									$class = "bg-success";
									$status = 'P';
									$total_present =  $total_present + 1;
								}
							?>
							<tr class="<?php echo $class;?>">
								<td><?php echo $i;?></td>						
								<td><?php echo get_date_formate($crnt,'d.m.Y'); ?></td>
								<td><?php echo get_date_formate($crnt,'D'); ?></td>
								<td><?php echo ($time_in == '-' ? '-' :  $in_time); ?></td>
								<td><?php echo ($time_in == $time_out ? '-' :  $out_time); ?></td>
								<td><?php echo $status; ?></td>
								
							</tr>	
						<?php 						
						$i++; 
						} ?>
				
					</tbody>
					<tfoot>
					<tr>
						<td colspan="7">
							<p class="text-center"><?php echo $line_sep; ?></p>
							<p class="text-center">Present :   <b><?php echo $total_present; ?></b> </p>  
							<p class="text-center">Holiday :   <b><?php echo $total_holiday  ; ?></b> </p>  
							<p class="text-center">Leave & Absent :  <b><?php echo $total_leave ; ?></b> </p>  
							<p class="text-center"><?php echo $line_sep; ?></p>
							<p class="text-center">Total :     <b><?php echo $i - 1; ?></b> </p>
							<p class="text-center"><?php echo $line_sep; ?></p>
						</td>
					</tr>					
					</tfoot>
				</table>
		<?php }?> 
			 <p class="text-center"><?php echo $line_sep.$line_sep.$line_sep; ?></p>
			<?php $no++; } 
		   } ?>
		 
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
