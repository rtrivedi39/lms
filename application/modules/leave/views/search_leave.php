<?php
 $attributes_add_leave = array('class' => 'form-unis', 'id' => 'formadd_leave', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
echo form_open('leave/add_leave', $attributes_add_leave);
?>  

    <fieldset> 
        <legend>Search :</legend>
        <div class="row col-xs-6">

            <div class="col-xs-3">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('search_leave_type'); ?> </label>
            </div>
            <div class="col-xs-3">
                <?php $leavesearch = array('User ID', 'Name', 'Mobile Number'); ?>
                <select class="form-control" name="search_type" id="search_type"  >
                    <option value="" > -- <?php echo $this->lang->line('leave_select'); ?>-- </option>
                    <?php
                    foreach ($leavesearch as $search) {
                        ?>
                        <option><?php echo $search; ?></option>
                        <?php
                    }
                    ?>

                </select>
            </div>
            <div class="col-xs-3">
                <label for="exampleInputEmail1"><?php echo $this->lang->line('search_value'); ?> </label>
            </div>
            <div class="col-xs-3">
                <input type="text"  name="seach_value" id="seach_value"  class="form-control">
            </div>

        </div><!-- /.box-header -->
        <div class="col-xs-1 bulk_action">
            <button type="submit" class="btn btn-block btn-success">
                <?php echo $this->lang->line('leave_emp_search'); ?>
            </button>
        </div>
        <div class="col-xs-5 pull-right">
            <div class="col-xs-8">
                <a href="<?php echo base_url(); ?>leave/employee_list" class="btn btn-block btn-info" >
                    <?php echo $this->lang->line('view_all_employee'); ?>
                </a>
            </div>
            <div class="col-xs-7">
                <?php if(checkUserrole() == 4 OR checkUserrole() == 11) {?>
                <a href="<?php echo base_url(); ?>leave/approve_deny"  class="btn btn-block btn-warning" >
                    <?php echo $this->lang->line('view_all_pending_approvel'); ?>
                </a>
                <?php } ?>
            </div>
        </div>
    </fieldset>

</form>  

