<!DOCTYPE html>
<html>
  <head>
    <meta charset="UTF-8">
    <title>Online Dating | Log in</title>
    <meta content='width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no' name='viewport'>
    <!-- Bootstrap 3.3.4 -->
    <link href="<?php echo ADMIN_THEME_PATH; ?>bootstrap/css/bootstrap.min.css" rel="stylesheet" type="text/css" />
    <!-- Font Awesome Icons -->
    <link href="https://maxcdn.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css" rel="stylesheet" type="text/css" />
    <!-- Theme style -->
    <link href="<?php echo ADMIN_THEME_PATH; ?>dist/css/AdminLTE.min.css" rel="stylesheet" type="text/css" />
    <!-- iCheck -->
    <link href="<?php echo ADMIN_THEME_PATH; ?>plugins/iCheck/square/blue.css" rel="stylesheet" type="text/css" />
    <!-- HTML5 Shim and Respond.js IE8 support of HTML5 elements and media queries -->
    <!-- WARNING: Respond.js doesn't work if you view the page via file:// -->
    <!--[if lt IE 9]>
        <script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
        <script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
    <![endif]-->
     <script type="text/javascript">
            setTimeout(function() {
                $('.hideauto').fadeOut('fast');
            }, 8000);
            var HTTP_PATH = "<?php echo HTTP_PATH; ?>";
            var SITE_NAME = "<?php echo SITE_NAME; ?>";
        </script>
  </head>
  <body class="login-page">
    <div class="login-box">
      <div class="login-logo">
        <a href="<?php echo base_url();?>admin"><b>Admin</b> <?php echo SITE_NAME;?></a>
      </div><!-- /.login-logo -->
      <div class="login-box-body">
        <?php echo $this->session->flashdata('message'); ?>
        <p class="login-box-msg"><?php echo $this->lang->line('admin_message_front');?></p>
        <form action="<?php echo base_url();?>admin" method="post" id="login-form">
          <?php if (validation_errors() != "") {?>
              <div class="alert alert-danger alert-dismissable">
                  <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
                  <strong><?php echo $this->lang->line('input_warning_label');?></strong><br>
                  <?php echo validation_errors(); ?>
              </div>
          <?php }?>
          <div class="form-group has-feedback">
            <!-- <input type="email" class="form-control" placeholder="Email"/> -->
            <input type="text"  name="username" id="username" class="form-control" placeholder="<?php echo $this->lang->line('admin_login_id');?>" >
            <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
          </div>
          <div class="form-group has-feedback">
            <input type="password" name="password" id="password" required class="form-control" placeholder="<?php echo $this->lang->line('admin_password');?>">
            <span class="glyphicon glyphicon-lock form-control-feedback"></span>
          </div>
          <div class="row">
            <div class="col-xs-8">    
                 <a href="javascript:void(0);" onclick="forgotpassword();"><?php echo $this->lang->line('admin_forgot_password');?></a><br>               
            </div><!-- /.col -->
            <div class="col-xs-4">
              <button type="submit" class="btn btn-primary btn-block btn-flat"><?php echo $this->lang->line('admin_sign_in');?></button>
            </div><!-- /.col -->
          </div>
        </form>
        <form  id="forgot-form" style="display:none;" action="<?php echo base_url();?>admin/forgote_password" method="post">
                <div class="form-group has-feedback">
                  <input type="text" name="email" id="email" class="form-control" placeholder="<?php echo $this->lang->line('employee_email');?>" >
                  <span class="glyphicon glyphicon-envelope form-control-feedback"></span>
                </div>
                <!-- <input type="email" name="email" required id="email"  class="form-control" placeholder="Email address" ><br> -->
                <div id="forgot-msg"></div>
                <div class="row">
                  <div class="col-xs-7">    
                       <a href="javascript:void(0);" onclick="login();"><?php echo $this->lang->line('login_existing_user');?></a><br>               
                  </div><!-- /.col -->
                  <div class="col-xs-5">
                    <button type="submit" class="btn btn-primary btn-block btn-flat" onclick="return valForgot();" name="forgotpassword" type="submit"><?php echo $this->lang->line('forgot_password_button');?></button>
                  </div><!-- /.col -->
                </div>
               <!--  <label >
                    <a href="javascript:void(0);" onclick="login();" >Login existing user ?</a>
                </label><br>
                <button class="btn btn-primary btn-block btn-flat" onclick="return valForgot();" name="forgotpassword" type="submit">Send password</button> -->
            </form>
      </div><!-- /.login-box-body -->
    </div><!-- /.login-box -->
    <!-- jQuery 2.1.4 -->
    <script src="<?php echo ADMIN_THEME_PATH; ?>plugins/jQuery/jQuery-2.1.4.min.js"></script>
    <!-- Bootstrap 3.3.2 JS -->
    <script src="<?php echo ADMIN_THEME_PATH; ?>bootstrap/js/bootstrap.min.js" type="text/javascript"></script>
    <!-- iCheck -->
    <script src="<?php echo ADMIN_THEME_PATH; ?>plugins/iCheck/icheck.min.js" type="text/javascript"></script>
    <!--<script src="<?php echo ADMIN_THEME_PATH; ?>common_js/common.js"></script>-->
    <script src="<?php echo ADMIN_THEME_PATH; ?>common_js/login.js"></script>
    <script>
      $(function () {
        $('input').iCheck({
          checkboxClass: 'icheckbox_square-blue',
          radioClass: 'iradio_square-blue',
          increaseArea: '20%' // optional
        });
      });
    </script>
  </body>
</html>