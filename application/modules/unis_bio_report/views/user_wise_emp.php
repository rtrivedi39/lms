	<?php $line_sep = '---------------------------------------------------------------------------'; ?>
	<h2 class="text-center">Law Department</h2>
		<h4 class="text-center">Month : - <b><?php  echo months($form_input['report_month']).', '.$form_input['report_year']; ?></b> </h4>
		<p class="text-center"><?php echo $line_sep; ?></p>
	<?php 	
	$emp_ids_unique = '';
	foreach($all_employees_list as $emp){
		$emp_ids_unique[] = $emp['emp_unique_id'];
		$last_day = date("t", strtotime('1-'.$this->input->post('report_month').'-'.$this->input->post('report_year')));
		$begin = new DateTime( get_date_formate('1-'.$this->input->post('report_month').'-'.$this->input->post('report_year'),'Y-m-d') );
		$end_date = date('Y-m-d', strtotime($last_day.'-'.$this->input->post('report_month').'-'.$this->input->post('report_year')));
 		?>		
		<div style="display:none;" id="display_block_<?php echo $emp['emp_unique_id'] ?>" >
		<div id="bio_report_block">		
		<p class="text-center">Unique id : - <b><?php echo $emp['emp_unique_id']; ?></b> 
		Name :- <b><?php echo $emp['emp_title_en'].' '.$emp['emp_full_name']; ?></b></p>
		<p class="text-center"> Run Date & Time : <b><?php echo date('d/m/Y H:i'); ?></b> </p>
		<p class="text-center"><?php echo $line_sep; ?></p> 
		<table width="100%" id="bio_table"> 
			<thead>
			  <tr>
				<th><?php echo $this->lang->line('sno_label'); ?></th>				
				<th>Date</th>				
				<th>Days</th>		
			  </tr>
			</thead>
			<tbody>
				<?php 	
				$j = 1;
				$end = new DateTime($end_date);

				$interval = DateInterval::createFromDateString('1 day');
				$period = new DatePeriod($begin, $interval, $end);									
				foreach ( $period as $dt ){
					$crnt = $dt->format("Ymd");
					$time_in = $this->unis_bio_report_model->get_intime($crnt,$emp['emp_unique_id']);
					$time_out = $this->unis_bio_report_model->get_outime($crnt,$emp['emp_unique_id'])	;						
					if($time_in == '-' && $time_out == '-'){
						$holiday = check_holidays(get_date_formate($crnt,'Y-m-d'));
						if($holiday == false){							
							$class = "bg-warning";
							$leave = check_leave($crnt,$emp['emp_id']);								
							if($leave == false ){ ?>
								<tr class="<?php echo $class;?>">
									<td><?php echo $j;?></td>						
									<td><?php echo get_date_formate($crnt,'d.m.Y'); ?></td>
									<td><?php echo get_date_formate($crnt,'D'); ?></td>
								</tr>
							<?php						
							$j++; 
							}
						}
					} 
				}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td colspan="7">
						<p class="text-center"><?php echo $line_sep; ?></p>
						<p class="text-center">Total :   <b><?php echo $total = $j - 1; ?></b> </p>
						<p class="text-center"><?php echo $line_sep; ?></p>
						<p id="display_total_<?php echo $emp['emp_unique_id'] ?>" data-total="<?php echo $total;?>"></p>
					</td>
				</tr>					
			</tfoot>
		</table>
		</div>
	</div>
	<?php
	} 
	?>

	<script src="<?php echo ADMIN_THEME_PATH; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
	<script type="text/javascript">
        
    $(document).ready(function () {
		<?php foreach($emp_ids_unique as $ids){ ?>
			var total_abs = $('#display_total_<?php echo $ids ?>').data('total');			
			if(parseInt(total_abs) > 0){
			   $('#display_block_<?php echo $ids; ?>').show();
			}   
		<?php  } ?>
 	});
    </script>