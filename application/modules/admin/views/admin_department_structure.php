<!-- Content Header (Page header) -->
        <section class="content-header">
          <h1>
            <?php echo $title; ?>
            <!--<small>Optional description</small>-->
          </h1>
          <ol class="breadcrumb">
            <li><a href="#"><i class="fa fa-dashboard"></i>Dashboard</a></li>
            <li class="active"><?php echo $this->lang->line('title'); ?></li>
          </ol>
        </section>
        <!-- Main content -->
        <section class="content">
          <!-- Your Page Content Here -->
          <!-- Small boxes (Stat box) -->
          <div class="row">
            <div class="col-xs-9">
            
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title"><?php echo $this->lang->line('title_tab'); ?></h3>
					<div class="pull-right tools">
						<button class="btn btn-warning" onclick="goBack()"><?php echo $this->lang->line('Back_button_label'); ?></button>
					</div>
				</div><!-- /.box-header -->
                 <!-- form start -->
                <form role="form" method="post" action="<?php echo site_url(); ?>admin/admin_department/addUpdatedepartment<?php if(isset($dpid)){ echo '/'.$dpid;} ?>">
                    <div class="box-body">
                         <div class="tree well">
                            <ul>
                                <li>
                                    <span class="bg-success"><i class="icon-folder-open" ></i> <?php $details_ps = getuserbyrole(1,3); echo get_employee_gender('m', true, false).' '.$details_ps[0]['emp_full_name_hi'];?>/<?php echo getemployeeRole(3); ?></span> 
                                <?php if(!empty($this->depart_struct->get_departmental_structure($details_ps[0]['emp_id']))){
                                    echo " <ul>";
                                    foreach($this->depart_struct->get_departmental_structure($details_ps[0]['emp_id']) as $row){ ?>
                                        <li>
                                            <span class="<?php echo get_role_class($row->designation_id); ?>"><i class="icon-minus-sign"></i><?php echo get_employee_gender($row->emp_detail_gender, true, false).' '.$row->emp_full_name_hi; ?> / <?php echo getemployeeRole($row->designation_id); ?></span>
                                             <?php if(!empty($this->depart_struct->get_departmental_structure($row->emp_id))){ ?>
                                                  <ul>
                                                   <?php  foreach($this->depart_struct->get_departmental_structure($row->emp_id) as $row1){ ?>
                                                        <li>
                                                            <span class="<?php echo get_role_class($row1->designation_id); ?>"><i class="icon-minus-sign"></i><?php echo get_employee_gender($row1->emp_detail_gender, true, false).' '.$row1->emp_full_name_hi; ?> / <?php echo getemployeeRole($row1->designation_id); ?></span>
                                                             <?php if(!empty($this->depart_struct->get_departmental_structure($row1->emp_id))){ ?>
                                                                    <ul>
                                                                        <?php  foreach($this->depart_struct->get_departmental_structure($row1->emp_id) as $row2){ ?>
                                                                             <li>
                                                                                 <span class="<?php echo get_role_class($row2->designation_id); ?>"><i class="icon-minus-sign"></i><?php echo get_employee_gender($row2->emp_detail_gender, true, false).' '.$row2->emp_full_name_hi; ?> / <?php echo getemployeeRole($row2->designation_id); ?></span>
                                                                                  <?php if(!empty($this->depart_struct->get_departmental_structure($row2->emp_id))){ ?>
                                                                                        <ul>
                                                                                            <?php  foreach($this->depart_struct->get_departmental_structure($row2->emp_id) as $row3){ ?>
                                                                                                 <li>
                                                                                                     <span class="<?php echo get_role_class($row3->designation_id); ?>"><i class="icon-minus-sign"></i><?php echo get_employee_gender($row3->emp_detail_gender, true, false).' '.$row3->emp_full_name_hi; ?> / <?php echo getemployeeRole($row3->designation_id); ?></span>
                                                                                                      <?php if(!empty($this->depart_struct->get_departmental_structure($row3->emp_id))){ ?>
                                                                                                             <ul>
                                                                                                                <?php  foreach($this->depart_struct->get_departmental_structure($row3->emp_id) as $row4){ ?>
                                                                                                                     <li>
                                                                                                                         <span class="<?php echo get_role_class($row4->designation_id); ?>"><i class="icon-minus-sign"></i><?php echo get_employee_gender($row4->emp_detail_gender, true, false).' '.$row4->emp_full_name_hi; ?> / <?php echo getemployeeRole($row4->designation_id); ?></span>
                                                                                                                          <?php if(!empty($this->depart_struct->get_departmental_structure($row4->emp_id))){ ?>
                                                                                                                              <ul>
                                                                                                                                <?php  foreach($this->depart_struct->get_departmental_structure($row4->emp_id) as $row5){ ?>
                                                                                                                                     <li>
                                                                                                                                         <span class="<?php echo get_role_class($row5->designation_id); ?>"><i class="icon-leaf"></i><?php echo get_employee_gender($row5->emp_detail_gender, true, false).' '.$row5->emp_full_name_hi; ?> / <?php echo getemployeeRole($row5->designation_id); ?></span>
                                                                                                                                          <?php if(!empty($this->depart_struct->get_departmental_structure($row5->emp_id))){ ?>
                                                                                                                                                   <?php //pre($this->depart_struct->get_departmental_structure($row5->emp_id)) ; ?>
                                                                                                                                          <?php } ?>
                                                                                                                                     </li>
                                                                                                                                 <?php } ?>
                                                                                                                            </ul>
                                                                                                                          <?php } ?>
                                                                                                                     </li>
                                                                                                                 <?php } ?>
                                                                                                            </ul>
                                                                                                      <?php } ?>
                                                                                                 </li>
                                                                                             <?php } ?>
                                                                                        </ul>
                                                                                  <?php } ?>
                                                                             </li>
                                                                         <?php } ?>
                                                                    </ul> 
                                                             <?php } ?>
                                                        </li>
                                                    <?php } ?>
                                                   </ul>
                                             <?php } ?>
                                        </li>
                                    <?php }
                                    echo " </ul>";
                                } else {
                                    echo $this->lang->line('No_structure');
                                }
                                ?>
                                </li>
                            </ul>
                         </div>

                    </div><!-- /.box-body -->

                  <div class="box-footer">
                  </div>
                </form>
              </div><!-- /.box -->
             </div>
          
            <div class="col-xs-3">
              <!-- general form elements -->
              <div class="box box-primary">
                <div class="box-header">
                  <h3 class="box-title"><?php echo $this->lang->line('instructions'); ?></h3>
                </div><!-- /.box-header -->
                 <!-- form start -->
                    <div class="box-body">
                        <div class="bg-success"> <span class="bg-success" style="padding:0px;"></span> <label> 1. <?php echo getemployeeRole(3); ?></label> </div><br/>
                        <div class="bg-warning">2. <?php echo getemployeeRole(4); ?> </div><br/>
                        <div class="bg-info">3. <?php echo getemployeeRole(5); ?></div><br/>
                        <div class="bg-danger">4. <?php echo getemployeeRole(6); ?></div><br/>
                        <div class="bg-primary">5. <?php echo getemployeeRole(7); ?>/  <?php echo getemployeeRole(11); ?></div><br/>
                        <div class="bg-yellow">6. <?php echo getemployeeRole(8); ?>/ <?php echo getemployeeRole(14); ?></div><br/>
                        <div class="bg-green">7.<?php echo getemployeeRole(15); ?></div><br/>
                        <div class="bg-aqua">8. <?php echo getemployeeRole(25); ?>/ <?php echo getemployeeRole(13); ?></div><br/>
                        <div class="bg-default">9. Others</div><br/>
                    </div>
              </div>
            </div>
          </div><!-- /.row -->
          <!-- Main row -->
        </section><!-- /.content -->
    