<div class="content-wrapper">
    <div class="content_header">
        <h3>Change Password</h3>
    </div>
    <div class="inner_bg content_box">
        <div class="row">
            <?php if ($this->session->flashdata('error') != '') { ?>
                <div class="alert alert-danger" style="margin-top:18px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php } ?>
            <?php if ($this->session->flashdata('success') != '') { ?>
                <div class="alert alert-success" style="margin-top:18px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>
        </div>
        <form name="changePasswordForm" method="post" id="changePasswordForm" action="">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">

                        <div class="col-sm-6">
                            <div class="box-form">
                                <div class="theme-form">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="ims_form_label">Current Password</label>
                                                <input type="password" name="current_password" id="current_password" class="ims_form_control"
                                                       maxlength="25" placeholder="Current Password" value=""/>
                                            </div>
                                            <?php echo form_error('current_password'); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="ims_form_label">New Password</label>
                                                <input type="password" name="new_password" id="new_password" class="ims_form_control"
                                                       maxlength="25" placeholder="New Password" value=""/>
                                            </div>
                                            <?php echo form_error('new_password'); ?>
                                        </div>
                                    </div>
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="ims_form_label">Confirm Password</label>
                                                <input type="password" name="confirm_password" id="confirm_password" class="ims_form_control"
                                                       maxlength="25" placeholder="Confirm Password" value=""/>
                                            </div>
                                            <?php echo form_error('confirm_password'); ?>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="form-footer" style="text-align: center">
                        <input type="submit" id="submit" name="submit" value="Submit"
                               class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white"/>
                        <a href="<?php echo base_url('dashboard');?>"><input name="reset" type="button"
                                                                             class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white"
                                                                             id="reset1" value="Cancel"/></a>
                    </div>
                </div><!--col-sm-12-->
            </div><!--row-->
        </form>
    </div><!--content-wrapper-->
    <script>
        $(document).ready(function () {
            $("#changePasswordForm").validate({
                rules: {
                    current_password: {required: true, minlength: 6},
                    new_password: {required: true, minlength: 6},
                    confirm_password: {required: true, minlength: 6,equalTo: "#new_password"}
                },
                messages: {
                    current_password: {required: "This field is required"},
                    new_password: {required: "This field is required"},
                    confirm_password: {required: "This field is required",equalTo:"Confirm password must be same as new password"}
                }
            });
        });
    </script>
    <style>
        .income_box {
            border-bottom: 1px solid lightgray;
            margin-top: 15px;
        }
    </style>