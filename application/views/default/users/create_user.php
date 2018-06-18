<div class="content-wrapper">
    <div class="content_header">
        <h3><?php echo (isset($user)? "Edit":"Add"); ?> User</h3>
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

        <form id="userAddFrom" name="userAddFrom" method="post" action="">
            <?php
            if(isset($user) && !empty($user)) :
                ?>
                <input type="hidden" id="user_id" name="user_id" value="<?php echo $user->id; ?>"/>
            <?php endif; ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box-form">
                                <h3 class="form-box-title">User Info</h3>
                                <div class="theme-form">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">First Name*</label>
                                                <input type="text" name="first_name" class="ims_form_control"
                                                       maxlength="50" id="first_name" placeholder="First Name" value="<?php echo (isset($user)) ? $user->first_name:"" ?>"/>
                                                <?php echo form_error('first_name'); ?>
                                                <label class="error" style="display:none;">Required</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">Last Name*</label>
                                                <input type="text" name="last_name" class="ims_form_control"
                                                       maxlength="50" id="last_name" placeholder="Last Name" value="<?php echo (isset($user)) ? $user->last_name:"" ?>"/>
                                                <?php echo form_error('last_name'); ?>
                                                <label class="error" style="display:none;">Required</label>
                                            </div>
                                        </div>

                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">Email address*</label>
                                                <input name="email_id" type="text" class="ims_form_control" id="email_id" value="<?php echo (isset($user)) ? $user->email :''; ?>" placeholder="Email address" />
                                                <?php echo form_error('email_id'); ?>
                                            </div>
                                        </div><!--col-sm-3-->
                                    </div>
                                </div>

                                <div class="theme-form">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group ims_multiselect">
                                                <label class="ims_form_label">Assign Role*</label>
                                                <select name="user_role" title="Select Role" class="selectpicker" id="user_role">
                                                    <!--<option value="">Select Role</option>-->
                                                    <?php $UserRoles = array(); if(isset($user)) {
                                                        $UserRoles = explode(',', $user->role_id);
                                                    } ?>
                                                    <?php foreach($roles as $rows) {

                                                        ?>
                                                        <option value="<?php echo $rows->id?>" <?php echo (isset($user) && in_array( $rows->id , $UserRoles)) ? 'selected=selected' :''; ?>><?php echo ucfirst($rows->role_name)?></option>
                                                    <?php } ?>
                                                </select>
                                                <?php echo form_error('user_role'); ?>
                                                <label id="user_role-error" class="error" for="user_role"></label>
                                            </div>
                                        </div><!--col-sm-3-->
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label class="ims_form_label">Is Active*</label>
                                                <div class="radio radio-inline">
                                                    <input type="radio" id="status" name="status" value="A" <?php echo (isset($user) && $user->status == 'A') ? 'checked=checked' :''; ?>>
                                                    <label for="status"> YES</label>
                                                </div>
                                                <div class="radio radio-inline">
                                                    <input type="radio" id="status1" name="status" value="I" <?php echo (isset($user) && $user->status == 'I') ? 'checked=checked' :''; ?>>
                                                    <label for="status1"> NO</label>
                                                </div>
                                                <?php echo form_error('status'); ?>
                                                <label id="status-error" class="error" for="status"></label>
                                            </div><!--form-group-->
                                        </div><!--col-sm-2-->
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="form-footer">
                        <input type="submit" id="submit" name="submit" onclick="submit" value="<?php echo (isset($user)) ? "Update":"Create" ?>"
                               class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white"/>
                        <a href="<?php echo base_url('users');?>"><input name="reset" type="button"
                                                                           class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white"
                                                                           id="reset1" value="Cancel"/></a>
                    </div>
                </div><!--col-sm-12-->
            </div><!--row-->
        </form>
    </div><!--content-wrapper-->
<script>

    var FromEndDate = new Date();
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
        /*
         *  Client side validations for add client
         * @purpose - Validations for add client.
         * @Date - 17/01/2018
         * @author - NJ
         */
        $("#userAddFrom").validate({
            rules: {
                first_name: {required: true},
                last_name: {required: true},
                email_id: {required: true, isValidEmail: true},
                user_role: {required: true},
                status: {required: true},
            },
            messages: {
                first_name: {required: "This field is required"},
                last_name: {required: "This field is required"},
                user_role: {required: "This field is required"},
                email_id: {required: "This field is required",isValidEmail: "Please enter a valid email address"},
                status: {required: "This field is required"}
            }
        });

    });
</script>