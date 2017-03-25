<?php $last_month_date = date('d-m-Y',strtotime($last_upload['bio_date'].' -1 month')); ?>
<?php $last_month = date('m',strtotime($last_upload['bio_date'].' -1 month')); ?>
	<div class="box-header">
		<h3 class="box-title">विभाग के शासकीय सेवको का बायो मैट्रिक प्रतिवेदन </h3>
		<div class="pull-right box-tools no-print"> 
			<button onclick="printContents('report_ptrint')" class="btn btn-primary ">Print</button>
			<button class="btn btn-warning" onclick="goBack()">पिछले पेज में वापस जायें</button>
		</div>		  
	</div><!-- /.box-header -->
	
	<?php if( $this->session->userdata('emp_id') == 151 || (in_array(7, explode(',',$current_emp_section_id )) && ($userrole == 11  || $userrole == 8 || $userrole == 7 || $userrole == 1))) {?>		
	<div class="box-header bg-danger"> 
	<h3 class="box-title"> रिपोर्ट अपलोड करें</h3>
		<div class="row">
			<?php if( $this->session->userdata('emp_id') == 151 || $this->session->userdata('emp_id') == 1 ) {?>
				
				<p class="<?php echo !empty($upload_class) ? $upload_class : '' ; ?>"><?php if(!empty($upload_msg)) { echo $upload_msg; } ?></p>
				<?php
				 $attributes = array('class' => 'form-unis', 'id' => 'formnisreport', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                echo form_open('unis_bio_report/upload_report', $attributes);
                ?>
				 

				
					<div class="col-md-2">
						<label>अंतिम आई. डी.</label>
						<p><b><?php echo $last_id['bio_id']; ?></b></p>
						<input type="hidden" name="last_upload_id" value="<?php echo $last_id['bio_id']; ?>"/>
					</div>
					<div class="col-md-2">
						<label>CSV फाइल चुने</label>
						<input type="file" name="upload_file" />
					</div>
					<div class="col-md-1">
						<br/>
						<button type="submit" name="uploadreport"  class="btn btn-primary" value= "uploadreport">Submit</button>
					</div>	
				
				</form>
				<?php } ?>

				<?php if( in_array(7, explode(',',$current_emp_section_id )) && ($userrole == 11  || $userrole == 8 || $userrole == 7 || $userrole == 4 || $userrole == 1)) {?>
				<?php
				 $attributes = array('class' => 'form-unis', 'id' => 'formnisreport', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                echo form_open('unis_bio_report/all_emp_absent_report', $attributes);
                ?>
					<h3 class="box-title">अनुपस्थित और पंच नहीं किये गए खोजे</h3>
						<div class="col-md-2">
							<label>माह  <span class="text-danger">*</span></label>
							 <select class="form-control" name="report_month" id="report_month">
                                <?php $month = months(null, true);
								foreach ($month as $id => $value) { 
									$selected =  ($last_month == $id )  ? 'selected' : null; 
								?>
                                    <option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $value;?></option>
                                <?php }  ?>
                            </select>
						</div>
						<div class="col-md-2">
							<label>वर्ष  <span class="text-danger">*</span></label>
								<select class="form-control" id="report_year" name="report_year">
								<?php $year = date('Y');
								$i = '2015'; while($i <= date('Y')) { ?>
									<option value="<?php echo $i ; ?>" <?php echo $year == $i ? 'selected' : ''; ?>><?php echo $i ;?></option>
								<?php $i++; } ?>
							</select>
						</div>
						<div class="col-md-2">
							<label>पद / वर्ग<span class="text-danger">*</span></label>
							<select class="form-control" name="employees_class">							   
									<option value="">-- वर्ग चुने --</option>
										<?php $employees_class = employees_class(); 
										foreach ($employees_class as $yky => $yval) { ?>
											<option value="<?php echo $yky; ?>" <?php if ($this->input->post('employees_class') == $yky) {echo 'selected';} ?>><?php echo $yval; ?></option>
										<?php } ?>
								</select>

							<?php  $emp_roles = get_list(EMPLOYEEE_ROLE, null, null); ?>
                            <select class="form-control" name="choose_desingation" id="choose_desingation" multiplel ="true">
                          		  <option value="">-- पद चुने --</option>
                                <?php foreach ($emp_roles as $empk => $emprolse) { ?>
                                    <?php 
                                    	if($emprolse['role_id'] != 1 && $emprolse['role_id'] != 2){
                                        if (is_array($emprolse)) { ?>
                                            <option value="<?php echo $emprolse['role_id']; ?>" <?php if (@$form_input['choose_desingation'] == $emprolse['role_id']) 
                                            {
                                                echo 'selected';
                                            } 
                                            else if ($this->input->post('choose_desingation') == $emprolse['role_id']) 
                                            {
                                                echo 'selected';
                                            } ?> ><?php echo $emprolse['emprole_name_hi']; ?>  
                                        <?php } ?>
                                <?php } } ?>
                            </select>                                   
						</div>	
						<div class="col-md-1">
							<br/>
							<button type="submit" name="search_report"  class="btn btn-primary" value= "search_report"><?php echo $this->lang->line('search_button'); ?></button>
						</div>	
					
					</form>
				<?php } ?>
			</div>
		</div>
			
		<br/>
		<?php } ?>
		<div class="box-header bg-info">
				<h3 class="box-title">दिनांक से दिनांक तक कर्मचारी के अनुसार खोजे </h3>	
					<?php
				 $attributes_search_report = array('class' => 'form-unis', 'id' => 'formsearch_report', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                echo form_open('unis_bio_report/search_report', $attributes_search_report);
                ?>		 	
			
					<div class="row">						
						<div class="col-md-2">
							<label>दिनांक से <span class="text-danger">*</span></label>
							<input type="text"  id="report_from_date" class="form-control datepicker" name="report_from_date" placeholder="dd-mm-yyyy" value="<?php echo $this->input->post('report_from_date') != '' ? $this->input->post('report_from_date') : $last_month_date; ?>" required>
						</div>
						<div class="col-md-2">
							<label>दिनांक तक <span class="text-danger">*</span></label>
							<input type="text"  id="report_to_date" class="form-control datepicker" name="report_to_date" placeholder="dd-mm-yyyy" value="<?php echo $this->input->post('report_to_date') != '' ? $this->input->post('report_to_date') : get_date_formate($last_upload['bio_date'],'d-m-Y'); ?>" required>
						</div>
						<?php 
						$section_emps = null;
						if((in_array(7, explode(',',$current_emp_section_id )) && ($userrole == 11 || $userrole == 8 || $userrole == 4 || $userrole == 1 || $userrole == 3)) || ( $this->session->userdata('emp_id') == 151) || ( $this->session->userdata('emp_id') == 166)) { 
						    $sections = get_list(SECTIONS,null,null);    ?>
							<div class="col-md-3">
							<label>चुने<span class="text-danger">*</span></label>
	                            <select name="emp_section_name" class="form-control" id="emp_sections">
								   <option value="">अधिकारी /  अनुभाग  चुने</option>
								   <option value="officers"> अधिकारी  </option>
								   <?php if($this->session->userdata('user_role') < 9 ) { ?>
								   <option value="pa"> निज सहायक/ निज सचिव  </option>
								   <?php } ?>
									<?php  foreach($sections as $values) { ?>
										<option value="<?php echo $values['section_id']; ?>" <?php echo (isset($form_input['emp_section']) && $form_input['emp_section'] == $values['section_id']) ? 'selected' : '';  ?>> <?php echo $values['section_name_hi']; ?> </option>
									<?php }?>
                                   <option value="other"> अन्य </option>
								</select>
                            </div>
	                        <div class="col-md-3">
								<label>चुने<span class="text-danger">*</span></label>
	                            <select name="emp_unique_id" class="form-control" id="employee_list_section">
	                                <option value="">कर्मचारी चुने</option>
	                            </select>
                            </div>
						<?php 
						} else if($userrole < 9) {
						   $section_emps = explode(',',$this->session->userdata('emp_section_id')); 						
						?>					
							<div class="col-md-3">
								 <label>चुने<span class="text-danger">*</span></label>
	                           <select name="emp_section_name" class="form-control" id="emp_sections">
									   <option value="">अधिकारी /  अनुभाग  चुने</option>
									   <option value="officers"> अधिकारी  </option>
									   <?php if($this->session->userdata('user_role') < 9 ) { ?>
									   <option value="pa"> निज सहायक/ निज सचिव  </option>
									   <?php } ?>
										<?php  foreach($section_emps as $values) { ?>
											<option value="<?php echo $values; ?>" <?php echo (isset($form_input['emp_section']) && $form_input['emp_section'] == $values) ? 'selected' : '';  ?>> <?php echo getSection($values); ?> </option>
										<?php }?>
									</select>
	                            </select>
	                        </div>
	                        <div class="col-md-3">
								<label>चुने<span class="text-danger">*</span></label>
	                            <select name="emp_unique_id" class="form-control" id="employee_list_section">
	                                <option value="">कर्मचारी चुने</option>
	                            </select>
	                        </div>
							
						<?php } else { ?>
							<input type="hidden"  id="emp_unique_id" class="form-control" name="emp_unique_id" value="<?php echo  $this->session->userdata('emp_unique_id'); ?>">
						<?php } ?>						
						<div class="col-md-2">
							<br/>
							<button type="submit" name="search_report"  class="btn btn-primary" value= "search_report"><?php echo $this->lang->line('search_button'); ?></button>
						</div>						
					</div>
				</form>
		</div>
			<br/>
		<?php if((in_array(7, explode(',',$current_emp_section_id )) && ($userrole == 11 || $userrole == 8 || $userrole == 4 || $userrole == 1 || $userrole == 3 )) || ( $this->session->userdata('emp_id') == 151) ) {?>
		<div class="box-header bg-warning">					
				<div class="row">
					<div class="col-md-4">
					<h3 class="box-title">दिनांक  से सभी शासकीय  सेवको की रिपोर्ट खोजे </h3>	
						<?php
					 $attributes_search_report_daily = array('class' => 'form-unis', 'id' => 'formsearch_report_daily', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
	                echo form_open('unis_bio_report/search_report_daily', $attributes_search_report_daily);
	                ?>	

						<div class="row">
							<?php $last_day = date('d-m-Y',strtotime($last_upload['bio_date'].' -1 days')); ?>
							
							<div class="col-md-4">
								<label>दिनांक  <span class="text-danger">*</span></label>
								<input type="text"  id="report_date" class="form-control datepicker" name="report_date" placeholder="dd-mm-yyyy" value="<?php echo $this->input->post('report_date') != '' ? $this->input->post('report_date') : get_date_formate($last_day,'d-m-Y'); ?>" required>
							</div>
							<div class="col-md-4">
								<label>प्रकार  <span class="text-danger">*</span></label>
								<select name="report_type" class="form-control">
									<option value="all">All</option>
									<option value="lt">Late Arrived</option>
									<option value="ed">Early Departure </option>
									<option value="b_or">Both(Or) </option>
									<option value="b_and">Both(And) </option>
								</select>
							</div>						
							<div class="col-md-4">
								<br/>
								<button type="submit" name="search_report"  class="btn btn-primary" value= "search_report"><?php echo $this->lang->line('search_button'); ?></button>
							</div>						
						</div>
					</form>
					</div>
					<div class="col-md-8">
						<h3 class="box-title">माह  से सभी शासकीय  सेवको की रिपोर्ट खोजे </h3>
							<?php
					 $attributes_search_report_month = array('class' => 'form-unis', 'id' => 'formsearch_report_month', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
	                echo form_open('unis_bio_report/search_report_month', $attributes_search_report_month);
	                ?>		
						
						<div class="row">
							
							
							<div class="col-md-2">
								<label>माह  <span class="text-danger">*</span></label>
								 <select class="form-control" name="report_month" id="report_month">
                                    <?php $month = months(null, true);
									foreach ($month as $id => $value) { 
										$selected =  ($last_month == $id )  ? 'selected' : null; 
									?>
                                        <option value="<?php echo $id; ?>" <?php echo $selected; ?>><?php echo $value;?></option>
                                    <?php }  ?>
                                </select>
							</div>
							<div class="col-md-2">
								<label>वर्ष  <span class="text-danger">*</span></label>
									<select class="form-control" id="report_year" name="report_year">
									<?php $year = date('Y');
									$i = '2015'; while($i <= date('Y')) { ?>
										<option value="<?php echo $i ; ?>" <?php echo $year == $i ? 'selected' : ''; ?>><?php echo $i ;?></option>
									<?php $i++; } ?>
								</select>
							</div>
							<div class="col-md-2">
								<label>प्रकार  <span class="text-danger">*</span></label>
								<select name="report_type" class="form-control">
									<option value="all" <?php echo (@$this->input->post('report_type') == 'all' ? 'selected' : ''); ?>>All</option>
									<option value="lt" <?php echo (@$this->input->post('report_type') == 'lt' ? 'selected' : ''); ?>>Late Arrived</option>
									<option value="ed" <?php echo (@$this->input->post('report_type') == 'ed' ? 'selected' : ''); ?>>Early Departure </option>
									<option value="b_or" <?php echo (@$this->input->post('report_type') == 'b_or' ? 'selected' : ''); ?>>Both(Or) </option>
									<option value="b_and" <?php echo (@$this->input->post('report_type') == 'b_and' ? 'selected' : ''); ?>>Both(And) </option>
								</select>
							</div>	
							<div class="col-md-2">
								<label>समूह से <span class="text-danger">*</span></label>
								<select name="group_type" class="form-control">
									<option value="date" <?php echo (@$this->input->post('group_type') == 'date' ? 'selected' : ''); ?>>Date</option>							
									<option value="name" <?php echo (@$this->input->post('group_type') == 'name' ? 'selected' : ''); ?>>Name</option>
								</select>
							</div>	
							<div class="col-md-2">
								<label>वर्ण </label>
								<select name="class_wise" class="form-control">
									<option value="">चुने</option>
									<?php foreach(employees_class() as $key => $value){ ?>
										<option value="<?php echo $key; ?>" <?php echo (@$this->input->post('class_wise') == $key ? 'selected' : ''); ?>><?php echo $value; ?></option>
									<?php } ?>
								</select>
							</div>	
							<div class="col-md-2">
								<br/>
								<button type="submit" name="search_report"  class="btn btn-primary" value= "search_report"><?php echo $this->lang->line('search_button'); ?></button>
							</div>						
						</div>
					</form>
					</div>
				</div>
		</div>
	<?php } ?>	