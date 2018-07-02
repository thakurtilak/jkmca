<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>JKMCA | Forgot Password</title>
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
                <h3>Forgot Password</h3>
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

                $attributes = array('name'=>'forgotPassword','class' => 'login', 'id' => 'forgotPassword');
                echo form_open('login/forgot-password', $attributes);
                ?>
                <!--<form method="post" action="<?php /*echo base_url();*/?>login/authenticate">-->

                <div class="log_field_group">
                    <div class="log_inline_input">
                        <span class="field_icon"><img class="svg" src="<?php echo base_url();?>assets/images/username_icon.svg" /></span>
                        <input required type="text" placeholder="Email" id="email" name="email" />
                    </div>
                    <label id="email-error" class="error" for="email" style="display: none">email can't be empty</label>
                </div>
                <div class="log_field_group log_submit" style="text-align: center">
                    <button class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white" type="submit">Login</button>
                    <button onclick="window.location='<?php echo base_url('login');?>'" class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" type="button">Cancel</button>
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
    <script>
        $(document).ready(function () {
            $.validator.addMethod("isValidEmail", function (value, element) {
                if (value == '') {
                    return true;
                }
                var expr = /^([\w-\.]+)@((\[[0-9]{1,3}\.[0-9]{1,3}\.[0-9]{1,3}\.)|(([\w-]+\.)+))([a-zA-Z]{2,4}|[0-9]{1,3})(\]?)$/;
                if (!expr.test(value)) {
                    return false;
                }
                return true;
            }, "Invalid Email Address");
            $("#forgotPassword").validate({
                rules:{
                    email:{
                        required:true,
                        isValidEmail:true
                    }
                },
                messages:{
                    email:{
                        required: "Email can't be empty"
                    }
                }
            });
        });
    </script>
</body>
</html>