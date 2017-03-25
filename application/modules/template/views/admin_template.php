<?php //echo Modules::run('admin_header'); ?>
<?php $this->load->view('admin/admin_header'); ?>
<?php $this->load->view('admin/left_sidebar'); ?>
<!-- Content Wrapper. Contains page content -->
<div class="content-wrapper">
    <?php //$this->load->view($module_name.'/'.$view_file); ?>
    <?php $this->load->view($view_file); ?>
</div><!-- /.content-wrapper -->
<?php //echo Modules::run('admin_footer'); ?>
<?php $this->load->view('admin/admin_footer'); ?>