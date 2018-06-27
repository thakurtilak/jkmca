<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JKMCA | Login</title>
    <link href="<?php echo base_url();?>assets/vendor/bootstrap/css/bootstrap.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/vendor/material/css/material.min.css" rel="stylesheet">
    <link href="<?php echo base_url();?>assets/css/style.css" rel="stylesheet">
</head>
<body class="login_body">
<div class="login_page">
    <div class="login_box">

        <div class="login_r_block">
          <div class="login_block">
            <div class="lg_ims"><img class="svg" src="<?php echo base_url();?>assets/images/logo_2.png" /></div>
              <h3>Sign In</h3>
            <?php if($this->session->flashdata('error') != '') { ?>
                <div class="alert alert-danger" style="margin-top:18px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php }
            if($this->session->flashdata('success') != '') { ?>
                <div class="alert alert-success" style="margin-top:18px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php }

            $attributes = array('name'=>'login','class' => 'login', 'id' => 'login');
            echo form_open('login/authenticate', $attributes);
            ?>
            <!--<form method="post" action="<?php /*echo base_url();*/?>login/authenticate">-->
                
                <div class="log_field_group">
                    <div class="log_inline_input">
                        <span class="field_icon"><img class="svg" src="<?php echo base_url();?>assets/images/username_icon.svg" /></span>
                        <input type="text" placeholder="Username" id="username" name="username" />
                    </div>
                    <label id="username-error" class="error" for="username" style="display: none">Username can't be empty</label>
                </div>
                <div class="log_field_group">
                    <div class="log_inline_input">
                        <span class="field_icon"><img class="svg" src="<?php echo base_url();?>assets/images/password_icon.png" /></span>
                        <input type="password" placeholder="Password" id="password" name="password" />
                    </div>
                    <label id="password-error" class="error" for="password" style="display: none">Password can't be empty</label>
                </div>

                <div class="log_field_group log_submit">
                    <button class="btn-login mdl-js-button mdl-button--raised mdl-js-ripple-effect" type="submit">Login</button>
                </div>
            <?php echo form_close(); ?>
        </div><!--login_r_block-->
    </div><!--login_page-->
</div><!--login_page-->
    <script src="<?php echo base_url();?>assets/vendor/jquery/js/jquery.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/jquery/js/jquery.validate.js"></script>

    <script src="<?php echo base_url();?>assets/vendor/placeholdem/js/placeholdem.min.js"></script>
    <script src="<?php echo base_url();?>assets/vendor/material/js/material.min.js"></script>
<script src="<?php echo base_url();?>assets/js/custom_script.js"></script>
<script src="<?php echo base_url();?>assets/js/login.js"></script>
</body>
</html>



































