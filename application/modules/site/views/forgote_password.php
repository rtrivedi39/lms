<?php $this->load->view('header'); ?>
  <div class="row">
	  <div class="col-md-5 col-md-offset-3">
	  	<div class="panel panel-primary">
		  <div class="panel-heading text-center"><?php echo $this->lang->line('forgot_password_panel'); ?></div>
	     	 <div class="panel-body">
		     <?php 
		    	if(isset($security_question) && $security_question){
		    	//message if error		   
			      if(isset($security_message_error) && $security_message_error){
			          echo '<div class="alert alert-danger">';
			          echo '<a class="close" data-dismiss="alert">×</a>';
			          echo $this->lang->line('security_answer_error_message');
			          echo '</div>';             
			      }			     	
		     	$attributes = array('class' => 'form-signin','id' => 'formSignin', 'Content-Type' => 'application/x-www-form-urlencoded');
			    echo form_open('reset_password', $attributes);
		     	echo '<div class="form-group">';	
			    echo '<label for="security_question_label">'.$this->lang->line('security_question_label').'</label>';			   
			    echo '<p>-> '.$emp_security_ques.'</p>';
			    echo '</div>';  
		     	echo '<div class="form-group">';
		     	$emp_security_answer = array(  
				      'name'        => 'emp_security_answer',
		              'id'          => 'empSecurityAnswer',
		              'value'       => '',		             	              
		              'class'       => 'form-control',
		              'placeholder' => $this->lang->line('security_answer_label'),
		              'value'		=>  isset($emp_security_answer_val) ? $emp_security_answer_val : '',
			      	);			     	
			    echo '<label for="security_answer_label">'.$this->lang->line('security_answer_label').'</label>';
			    echo form_input($emp_security_answer);
			    echo '<input type="hidden" value="'.$emp_id.'" name="emp_id">';
			    echo form_error('emp_security_answer');
			    echo '</div>';
                if($this->session->userdata('countings') > 3){
					$captcha = mt_rand(10000, 99999);
					?>
					<div class="form-group">
						<label> कृपया यह कैपचा को दर्ज करें : <?php echo $captcha; ?></label>
						<input type="hidden" value="<?php echo $captcha; ?>" name="cpachavalue">
					</div>
					<div class="form-group">
						<input type="text" name="capchainput" class="form-control" required> 
					<?php echo form_error('capchainput'); ?>
					</div>
					<?php
				  }
			    echo form_submit('submit', $this->lang->line('security_question_button'), 'class="btn  btn-primary"');
			    echo form_close();  
		      } else {
			     //message if error		   
			      if(isset($message_error) && $message_error){
			          echo '<div class="alert alert-danger">';
			          echo '<a class="close" data-dismiss="alert">×</a>';
			          echo $this->lang->line('forgote_password_error_message');
			          echo '</div>';             
			      }	
			      $attributes = array('class' => 'form-signin','id' => 'formSignin');			           
			      echo form_open('forgote_password', $attributes);		   
			      //input user name 
			      	$emp_forgote_login_id = array(  
				      'name'        => 'emp_forgote_login_id',
		              'id'          => 'empforgoteLoginId',
		              'value'       => '',
		              'maxlength'   => '50',	              
		              'class'       => 'form-control',
		              'placeholder' => $this->lang->line('login_user_id_placeholder'),
		              'value'		=>  isset($emp_forgote_login_id_val) ? $emp_forgote_login_id_val : '',
			      	);	
			      echo '<div class="form-group">';	
			      echo '<label for="emp_login_id">'.$this->lang->line('home_login_id').'</label>';
			      echo form_input($emp_forgote_login_id);
			      echo form_error('emp_forgote_login_id');
			      echo '</div>';   		      		      	          
			      echo form_submit('submit', $this->lang->line('forgot_password_button'), 'class="btn  btn-primary"');
			      echo form_close();
			      echo br();
			      echo anchor('login', $this->lang->line('login_panel'), 'title="'.$this->lang->line('login_panel').'"');
			    } 
			     ?>  
		  </div>
		</div>		
	  </div><!-- md-3 -->	 
    </div><!-- row -->
  
<?php $this->load->view('footer'); ?>