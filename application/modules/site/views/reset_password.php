<?php $this->load->view('header'); ?>
<div class="row">
    <div class="col-md-5 col-md-offset-3">
        <div class="panel panel-primary">
            <div class="panel-heading text-center"><?php echo $this->lang->line('reset_password_panel'); ?></div>
            <div class="panel-body">
                <?php
                //message if error		   
                if (isset($message_error) && $message_error) {
                    echo '<div class="alert alert-danger">';
                    echo '<a class="close" data-dismiss="alert">×</a>';
                    echo $this->lang->line('reset_password_error_message');
                    echo '</div>';
                }
				$attributes = array('class' => 'form-signin', 'id' => 'formSignin', 'Content-Type' => 'application/x-www-form-urlencoded');                echo form_open('password_change', $attributes);
                //input user name 
                $emp_password = array(
                    'name' => 'emp_password',
                    'id' => 'emPassword',
                    'value' => '',
                    'maxlength' => '50',
                    'class' => 'form-control',
                    'value' => '',
                );
                echo '<div class="form-group">';
                echo '<label for="emp_password">' . $this->lang->line('reset_password_label') . '</label>';
                echo form_password($emp_password);
                echo form_error('emp_password');
                echo '</div>';
                //input user name 
                $emp_new_password = array(
                    'name' => 'emp_new_password',
                    'id' => 'emnewPassword',
                    'value' => '',
                    'maxlength' => '50',
                    'class' => 'form-control',
                    'value' => '',
                );
                echo '<div class="form-group">';
                echo '<label for="emp_new_password">' . $this->lang->line('reset_new_password_label') . '</label>';
                echo form_password($emp_new_password);
                echo form_error('emp_new_password');
                echo '</div>';
                echo '<input type="hidden" value="' . $emp_id . '" name="emp_id">';
                echo form_submit('submit', $this->lang->line('reset_password_button'), 'class="btn  btn-primary"');
                echo form_close();
                echo br();
                echo anchor('login', $this->lang->line('login_panel'), 'title="' . $this->lang->line('login_panel') . '"');
                ?>  
            </div>
        </div>		
    </div><!-- md-3 -->	 
</div><!-- row -->

<?php $this->load->view('footer'); ?>