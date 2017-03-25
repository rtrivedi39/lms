<!-- Content Header (Page header) -->
<section class="content-header">
    <h1>
        <?php echo $title; ?>
    </h1>
    <ol class="breadcrumb">
        <li><a href="<?php echo base_url('dashboard'); ?>"><i class="fa fa-dashboard"></i> Dashboard</a></li>
        <li class="active"><?php echo $title; ?></li>
    </ol>
</section>
<!-- Main content -->
<section class="content">
    <!-- Your Page Content Here -->
    <!-- Small boxes (Stat box) -->

    <div class="row">
        <div class="col-xs-12">
            <div class="box">
                <div class="box-header">
                    <div style="float:left"><h3 class="box-title"><?php echo $title_tab; ?></h3></div>
                </div>

            </div>

            <div class="row">
                <?php $this->load->view('leave_header') ?>
            </div>
               <?php 
                     $attributes_bulkAction = array('class' => 'form-signin', 'id' => 'bulkAction', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave/leave_approve/bulkAction', $attributes_bulkAction);
                    ?> 
                <div class="row">
                    <div class="col-xs-1">
                        <label for="exampleInputEmail1"><?php echo $this->lang->line('bulk_action'); ?> </label>
                    </div>
                    <div class="col-xs-2">
                        <select name="bultselect" id="bultselect"  class="form-control">
                            <option value="" > -- <?php echo $this->lang->line('leave_select'); ?>-- </option>
                            <option value="1"><?php echo $this->lang->line('leave_approve') ?></option>
                            <option value="2"><?php echo $this->lang->line('leave_deny') ?></option>
                        </select>
                    </div>
                    <div class="col-xs-2 bulk_action">
                        <button type="submit" class="btn btn-block btn-success"><?php echo $this->lang->line('bulk_action'); ?></button>
                    </div>


                </div>
                <?php echo $this->session->flashdata('message'); ?>
                <table id="example1" class="table table-bordered table-striped">
                    <thead>
                        <tr>
                            <th width='5%'><input type="checkbox" id="selectall"/></th>
                            <th width='25%'><?php echo $this->lang->line('leave_emp_name') . '/' . $this->lang->line('leave_emp_designation_'); ?></th>
                            <th width="15%"><?php echo $this->lang->line('leave_reason'); ?></th>
                            <th width="15%"><?php echo $this->lang->line('leave_type'); ?></th>
                            <th width="10%"><?php echo $this->lang->line('leave_days'); ?></th>
                            <th width="15%"><?php echo $this->lang->line('leave_start_date'); ?></th>
                            <th width="15%"><?php echo $this->lang->line('end_date'); ?></th>


                            <th>Actions</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $i = 1;
                        foreach ($details_leave as $key => $leave) {
                            ?>
                            <tr>
                                <td><input type="checkbox" class="case" name="leave_ids[]" value="<?php echo $leave->emp_leave_movement_id ?>"/></td>
                                <td><?php echo $leave->emp_full_name . '/' . getemployeeRole($leave->designation_id); ?></td>
                                <td><?php echo $leave->emp_leave_reason ?></td>
                                <td><?php echo leaveType($leave->emp_leave_type) ?></td>
                                <td><?php echo $leave->emp_leave_no_of_days; ?></td>
                                <td><?php echo get_date_formate($leave->emp_leave_date); ?></td>
                                <td><?php echo get_date_formate($leave->emp_leave_end_date); ?></td>

                                <td>
                                    <div class="btn-group">
                                        <a href="<?php echo base_url(); ?>leave/leave_approve/accept/<?php echo $leave->emp_leave_movement_id; ?>" class="btn  btn-twitter"><?php echo $this->lang->line('leave_approve') ?></a>
                                        <button type="button" class="btn btn-danger btndeny" name="btndeny" data-leaveid="<?php echo $leave->emp_leave_movement_id; ?>" data-toggle="modal" data-target="#denyModal"><?php echo $this->lang->line('leave_deny') ?></button>
                                    </div>
                                </td>
                            </tr>
                            <?php
                            $i++;
                        }
                        ?>
                    </tbody>
                </table>
            </form>

        </div><!-- /.box-body -->
    </div><!-- /.box -->
</div>
</div><!-- /.row -->
<!-- Main row -->
</section><!-- /.content -->

<!-- Modal -->
<div class="modal fade" id="denyModal" tabindex="-1" role="dialog" aria-labelledby="denyModal">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title" id="myModalLabel"><?php echo $this->lang->line('leave_deny_reson'); ?></h4>
            </div>
            <div class="modal-body">
            <?php 
                     $attributes_deny = array('class' => 'form-signin', 'id' => 'deny', 'Content-Type' => 'application/x-www-form-urlencoded', 'enctype' => "multipart/form-data");
                    echo form_open('leave/leave_approve/deny', $attributes_deny);
                    ?> 
                    <div class="modal-body">
                        <input type="hidden" name="leaveID" id="leaveID" value="">
                        <label><?php echo $this->lang->line('leave_reason'); ?></label>
                        <textarea name="deny_reson" class="form-control" required=""></textarea>
                    </div>
                    <div class="modal-footer">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="submit" class="btn btn-primary" name="btndeny">Save changes</button>
                    </div>
                </form>
            </div>      
        </div>
    </div>
</div>
<script type="text/javascript">
    function is_delete() {
        var res = confirm('<?php echo $this->lang->line("delete_confirm_message"); ?>');
        if (res === false) {
            return false;
        }
    }

</script>
