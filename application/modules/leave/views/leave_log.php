<section class="content-header">
    <h1>
        <?php echo $title; ?>

    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url(); ?>dashboard"><i class="fa fa-dashboard"></i>Dashboard</a></li>
        <li class="active">Leave Details</li>
    </ol>
</section>

<!-- Main content -->
<section class="content">
    <!-- Small boxes (Start box) -->
  
    <div class="row" id="divname">
        <div class="col-md-12"> 
            <div class="box box-info">
                <div class="box-header">
                    <i class="fa fa-inbox"></i>
					<h3 class="box-title"><?php echo $title_tab; ?> 
                    </h3>
					
                <div class="pull-right box-tools"> 
					<button onclick="printContents('divname')" class="btn btn-primary ">Print</button>
					<button class="btn btn-warning" onclick="goBack()">पिछले पेज में वापस जायें</button>
				</div>				
			</div><!-- /.box-header -->
				

                <div class="box-body no-padding">
                    <table class="table">
                        <tr>
                            <th style="width: 10px">#</th>
                            <th>किसके द्वारा</th>                           
                            <th>अवकाश पर क्या कार्यवाही की गयी</th>
                            <th>टीप</th>
							<?php if(checkUserrole() == 1){  ?>
								<th>ip address</th>
								<th>Browser</th>
							<?php } ?>
                            <th>कार्यवाही कब की गयी</th>
                         
                        </tr>
                        <?php
                        $r = 1;                                  
                        //pr($leaves_pending);
                        if (isset($get_log)) {
                            foreach ($get_log as $row => $value) {
                                ?>
                                <tr>
                                    <td><?php echo $r; ?>.</td>
                                    <td><?php echo getemployeeName($value['leave_update_emp_id'], true); ?></td>
                                    <td><?php echo $value['leave_remark']; ?></td>
                                    <td><?php echo $value['leave_movement_tip'] != '' ? $value['leave_movement_tip'] : '-'; ?></td>
									<?php if(checkUserrole() == 1){  ?>
										<td><?php echo $value['leave_ip_address']; ?></td>
										<td><?php echo $value['leave_browser_id']; ?></td>
									<?php } ?>
                                    <td><?php echo get_date_formate($value['leave_created_date'], 'd/m/Y h:i:s A'); ?></td>
                              </tr>
						<?php $r++;} } ?>
                    </table>
                </div><!-- /.box-body -->
                <div class="box-footer">
                  
                </div>
            </div><!-- /.box -->
        </div><!-- /.col -->
    </div><!-- /.row -->
   
</section><!-- /.content -->
