<?php
$late_arrive = LATE_ARRIVE;
$erly_dept = ERLY_DEPT;
?>	
	<?php if($get_report){  
					$line_sep = '---------------------------------------------------------------------------'; ?>
					<div id="bio_report_block">
					<h2 class="text-center">Law Department</h2>
					<h4 class="text-center">Monthly Performance from <?php echo get_date_formate($this->input->post('report_from_date'),'d/m/Y'); ?> To <?php echo get_date_formate($this->input->post('report_to_date'),'d/m/Y'); ?></h4>
					<p class="text-center"><?php echo $line_sep; ?></p>
					<p class="text-center">Unique id : - <b><?php echo $get_report['bio_user_id']; ?></b> 
					Name :- <b><?php echo ($get_report['emp_full_name'] == null ? $get_report['bio_user_name'] : $get_report['emp_title_en'].' '.$get_report['emp_full_name']); ?></b></p>
					<p class="text-center"> Run Date & Time : <b><?php echo date('d/m/Y H:i'); ?></b> </p>
					<p class="text-center"><?php echo $line_sep; ?></p>
					<table width="100%" id="bio_table">
					<thead>
					  <tr>
						<th><?php echo $this->lang->line('sno_label'); ?></th>				
						<th>Date</th>				
						<th>Days</th>				
						<th>Shift In</th>
						<th>Shift Out</th>				
						<th>Status</th>				
						<th>Remark</th>				
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
								$time_in = $this->unis_bio_report_model->get_intime($crnt,$this->input->post('emp_unique_id'));
								$time_out = $this->unis_bio_report_model->get_outime($crnt,$this->input->post('emp_unique_id'))	;						
								$in_time = get_datetime_formate($time_in,'h:i:s A');
								$out_time = get_datetime_formate($time_out ,'h:i:s A');
								$final_out = $time_in == $time_out ? '-' :  $out_time;
								
								$holiday = check_holidays(get_date_formate($crnt,'Y-m-d'));
								$class = "";
								$status = "";
								if($holiday == true){
									$class = "bg-danger";
									$sts =( holidays_name($crnt) == false ? get_date_formate($crnt,'D') : holidays_name($crnt));
									$status = 'Weekly off'.' ('.$sts.')';
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
								<td <?php echo ($time_in > $late_arrive) ? 'class="bg-danger"' : ''; ?>><?php echo ($time_in == '-' ? '-' :  $in_time); ?></td>
								<td <?php echo ($final_out == '-' || $erly_dept > $time_out) ? 'class="bg-danger"' : ''; ?>><?php echo $final_out; ?></td>
								<td><?php echo $status; ?></td>
								<td><?php  if($time_in > $late_arrive && $holiday == false){ echo 'LT ['.calculate_hrs($time_in,$late_arrive).']' ;} ?></td>
								  
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
				</div>
		<?php } ?>