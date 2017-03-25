<?php $userrole = checkUserrole();
 if($userrole == 3) {?>
<div class="row"><div class="col-xs-2 pull-right">
	<button type="submit" class="btn btn-block btn-success"   onclick="closeWin()">Back</button>
</div></div><br/>
 <?php } ?>
<div class="row no-print">
    <div class="col-xs-3">
        <select class="form-control" name="leave_list" id="leave_list" <?PHP echo set_value('leave_type')?> onchange="getleavetype(this.value);" >
            <option value="" > -- <?php echo $this->lang->line('leave_select'); ?>-- </option>
            <option value="all" <?php if($this->input->get('type') == '' || $this->input->get('type') == 'all'){ echo 'selected'; }  ?> > <?php echo $this->lang->line('all_leavs'); ?> </option>
            <option value="cl" <?php if($this->input->get('type') == 'cl'){ echo 'selected'; }  ?> ><?php echo $this->lang->line('casual_leave'); ?></option>
            <option value="ol" <?php if($this->input->get('type') == 'ol'){ echo 'selected'; }  ?> ><?php echo $this->lang->line('optional_leave'); ?></option>
            <option value="el" <?php if($this->input->get('type') == 'el'){ echo 'selected'; }  ?>>	<?php echo $this->lang->line('earned_leave'); ?></option>
            <option value="hpl" <?php if($this->input->get('type') == 'hpl'){ echo 'selected'; }  ?>><?php echo $this->lang->line('half_pay_leave'); ?></option>
            <option value="hq" <?php if($this->input->get('type') == 'hq'){ echo 'selected'; }  ?>><?php echo $this->lang->line('headquarter_leave'); ?></option>
            <option value="ot" <?php if($this->input->get('type') == 'ot'){ echo 'selected'; }  ?>><?php echo $this->lang->line('official_tour'); ?></option>
            <option value="ihpl" <?php if($this->input->get('type') == 'ihpl'){ echo 'selected'; }  ?>><?php echo $this->lang->line('inform_to_leave'); ?></option>
            <option value="lwp" <?php if($this->input->get('type') == 'lwp'){ echo 'selected'; }  ?>><?php echo $this->lang->line('leave_without_pay'); ?></option>
            <option value="ld" <?php if($this->input->get('type') == 'ld'){ echo 'selected'; }  ?>><?php echo $this->lang->line('leave_deduction'); ?></option>
        </select>
    </div>
    <div class="col-xs-3">
        <a href="<?php echo base_url(); ?>leave/employee_list" class="btn btn-block btn-info" ><?php echo $this->lang->line('view_all_employee'); ?></a>
    </div>
    <div class="col-xs-3">
        <?php if(in_array($userrole, array(1,3,4)) && $this->uri->segment(2) == 'leave_approve' ){?>
            <a href="<?php echo base_url(); ?>leave/approve_list"  class="btn btn-block btn-warning" ><?php echo $this->lang->line('action_taken_approve_list'); ?></a>
        <?php } if(in_array($userrole, array(1,3,4,5,6,7,8,11,12,14,15,37)) && $this->uri->segment(2) == 'leave_forward'   ){?>
            <a href="<?php echo base_url(); ?>leave/approve_deny_so"  class="btn btn-block btn-warning" ><?php echo $this->lang->line('action_taken_forwadred_list'); ?></a>
        <?php } ?>
    </div>
    <div class="col-xs-3">
        <a href="<?php echo base_url(); ?>leave/leave_today"  class="btn btn-block btn-info" ><?php echo $this->lang->line('leave_today_button'); ?></a>
    </div>
</div>
<script type="text/javascript">
function getleavetype(str){
    if(str == 'all'){
		window.location = "<?php echo base_url(uri_string()); ?>";
	} else {       
        <?php if(in_array($userrole,array(1,3,4,5,6,7,8,11,14,15,37))  ){
			if($this->input->get('lvl') && $this->input->get('lvl') == 'all'){ ?>
				window.location = "<?php echo base_url(uri_string()); ?>?type="+str+"&lvl=all";
			<?php } else {?>
				window.location = "<?php echo base_url(uri_string()); ?>?type="+str;
        <?php } }?>
    }
}
</script>