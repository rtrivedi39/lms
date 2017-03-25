<?php
$ol_update = get_settings('ol_update');
$cl_update = get_settings('cl_update');
$el_update = get_settings('el_update');
$hpl_update = get_settings('hpl_update');
$ol_update_date = get_datetime_formate($ol_update['set_datetime'],'d-m-Y');
$cl_update_date = get_datetime_formate($cl_update['set_datetime'],'d-m-Y');
$el_update_date = get_datetime_formate($el_update['set_datetime'],'d-m-Y');
$hpl_update_date = get_datetime_formate($hpl_update['set_datetime'],'d-m-Y');
?>
<div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-aqua">
                <div class="inner">
                  <a class="small-box-footer leave_font_dashboard" href="<?php echo base_url(); ?>leave/add_leave?type=cl"><h3><?php echo isset($leaves->cl_leave) ? $leaves->cl_leave : ''; ?></h3></a>
                  <a class="small-box-footer leave_font_dashboard" href="<?php echo base_url(); ?>leave/add_leave?type=cl"><p><?php echo $this->lang->line('reaming_cl'); ?></p></a>
                </div> 
                <sapn href="#" class="small-box-footer">Last Update <i class="fa fa-arrow-circle-right"> <?php echo $cl_update_date; ?></i></span> 
                
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-green">
                <div class="inner">
                    <a class="small-box-footer leave_font_dashboard" href="<?php echo base_url(); ?>leave/add_leave?type=ol"><h3><?php echo isset($leaves->ol_leave) ? $leaves->ol_leave : ''; ?></h3></a>
                    <a class="small-box-footer leave_font_dashboard" href="<?php echo base_url(); ?>leave/add_leave?type=ol"><p><?php echo $this->lang->line('reaming_ol'); ?></p></a>
                </div>  
                <sapn href="#" class="small-box-footer">Last Update <i class="fa fa-arrow-circle-right"> <?php echo $cl_update_date; ?></i></span> 
            </div>
        </div><!-- ./col -->
        <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-yellow">
                <div class="inner">
                    <a class="small-box-footer leave_font_dashboard" href="<?php echo base_url(); ?>leave/add_leave?type=el"><h3><?php echo isset($leaves->el_leave) ? calculate_el($leaves->el_leave) : ''; ?></h3></a>
                    <a class="small-box-footer leave_font_dashboard" href="<?php echo base_url(); ?>leave/add_leave?type=el"><p><?php echo $this->lang->line('reaming_el'); ?></p></a>
                </div>      
                <sapn href="#" class="small-box-footer">Last Update <i class="fa fa-arrow-circle-right"> <?php echo $ol_update_date; ?></i></span> 
            </div>
        </div><!-- ./col -->
		 <div class="col-lg-3 col-xs-6">
            <!-- small box -->
            <div class="small-box bg-red">
                <div class="inner">
                    <a class="small-box-footer leave_font_dashboard" href="<?php echo base_url(); ?>leave/add_leave?type=hpl"><h3><?php echo isset($leaves->el_leave) ? $leaves->hpl_leave.' ('.calculate_hpl($leaves->hpl_leave) .')' : ''; ?></h3></a>
                    <a class="small-box-footer leave_font_dashboard" href="<?php echo base_url(); ?>leave/add_leave?type=hpl"><p><?php echo $this->lang->line('reaming_hpl'); ?> (<?php echo $this->lang->line('reaming_commuted'); ?>)</p></a>
                </div> 
                <sapn href="#" class="small-box-footer">Last Update <i class="fa fa-arrow-circle-right"> <?php echo $hpl_update_date; ?></i></span> 
            </div>
        </div><!-- ./col -->