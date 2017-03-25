<?php
$late_arrive = LATE_ARRIVE;
$erly_dept = ERLY_DEPT;
?>	
		<?php if($get_report){  
					$line_sep = '---------------------------------------------------------------------------'; ?>
					<div id="bio_report_block">
					<h2 class="text-center">Law Department</h2>
					<p class="text-center"><?php echo $line_sep; ?></p>
					<p class="text-center"><?php  if($this->input->post('report_type')){
							if($this->input->post('report_type') == 'lt'){
								echo 'Late Arrived report';
							}else if($this->input->post('report_type') == 'ed'){
								echo 'Early Departure report';
							}else if($this->input->post('report_type') == 'b_or'){
								echo 'Late Arrived or Early Departure report';
							}else if($this->input->post('report_type') == 'b_and'){
								echo 'Late Arrived  and Early Departure report';
							} else{
								echo 'Day wise employees Report';
							}
						} ?></p>
					<p class="text-center">Date : - <b><?php echo get_date_formate($get_report[0]->dates,'d/m/Y'); ?></b> </p>
					<p class="text-center"> Run Date & Time : <b><?php echo date('d/m/Y H:i'); ?></b> </p>
					<p class="text-center"><?php echo $line_sep; ?></p>
					<table width="100%" id="bio_table">
					<thead>
					  <tr>
						<th>S.No.</th>				
						<th>Unique id</th>				
						<th>Name</th>				
						<th>Shift In</th>
						<th>Shift Out</th>				
						<th>Status</th>				
						<th>Machine</th>				
						<th>Working Hrs.</th>				
					  </tr>
					</thead>
					<tbody>
						<?php			
							$i=1;								
							foreach ( $get_report as $report ){
								$crnt = $report->dates;
								$time_in = $report->in_time;
								$time_out = $report->out_time;
								$in_time = get_datetime_formate($report->in_time,'h:i:s A');
								$out_time = get_datetime_formate($report->out_time ,'h:i:s A');
								$final_out = $time_in == $time_out ? '-' :  $out_time;
								$holiday = check_holidays(get_date_formate($crnt,'Y-m-d'));
								$worning_hrs = $final_out != '-' ? calculate_hrs($final_out,$time_in) : '-';
								
								$class = "";
								$status = "";
								if($holiday == true){
									$class = "bg-danger";
									$sts =( holidays_name($crnt) == false ? get_date_formate($crnt,'D') : holidays_name($crnt));
									$status = 'Weekly off'.' ('.$sts.')';
								} else if($time_in > $late_arrive && $erly_dept > $time_out){
									$class = "bg-warning";
									$status = 'LT + ED';								
								}else if($holiday == false && ($time_in > $late_arrive || $erly_dept > $time_out )){
									$class = "bg-warning";
									$leave = check_leave($crnt,$report->emp_id); 
									if($time_in > $late_arrive && empty($leave) ){
										$class = "bg-warning";
										$status = 'LT ['.calculate_hrs($time_in,$late_arrive).']';								
									} else if($erly_dept > $time_out && empty($leave)){
										$class = "bg-warning";
										$status = 'ED ';								
									} else{
										$status =  $leave;
									}								
								}else  {
									$class = "bg-success";
									$status = 'P';
								}
							?>
							<tr class="<?php echo $class;?>">
								<td><?php echo $i;?></td>						
								<td><?php echo $report->bio_user_id; ?></td>
								<td><?php echo ($report->emp_full_name == null ? $report->bio_user_name : $report->emp_title_en.' '.$report->emp_full_name); ?></td>
								<td <?php echo ($time_in > $late_arrive) ? 'class="bg-danger"' : ''; ?>><?php echo ($time_in == '-' ? '-' :  $in_time); ?></td>
								<td <?php echo ($final_out == '-' || $erly_dept > $time_out) ? 'class="bg-danger"' : ''; ?>><?php echo $final_out ; ?></td>
								<td><?php echo $status; ?></td>
								<td><?php echo $report->bio_terminal; ?></td>
								<td><?php echo $worning_hrs; ?></td>
							</tr>	
						<?php 						
						$i++; 
						} ?>
				
					</tbody>			
				</table>
				</div>
		<?php } ?>