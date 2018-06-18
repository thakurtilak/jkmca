<div class="content-wrapper">
    <div class="content_header">
        <h3><?php echo (isset($user)? "Edit":"Add"); ?> User</h3>
    </div>
    <div class="inner_bg content_box">
        <div class="row">
            <div class="col-sm-12">
                <?php if($this->session->flashdata('error') != '') { ?>
                    <div class="alert alert-danger" style="margin-top:18px;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        <?php echo $this->session->flashdata('error'); ?>
                    </div>
                <?php } ?>
                <form id="userAddFrom" name="userAddFrom" method="post" action="">
                <div class="box-form">
                    <div class="theme-form">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="form_label">First Name*</label>
                                    <input name="first_name" type="text" class="ims_form_control" id="first_name" value="<?php echo (isset($user)) ? $user->first_name :''; ?>" placeholder="First name" />
                                </div>
                            </div><!--col-sm-3-->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="form_label">Last Name*</label>
                                    <input name="last_name" type="text" class="ims_form_control" id="last_name" value="<?php echo (isset($user)) ? $user->last_name :''; ?>"  placeholder="Last name" />
                                </div>
                            </div><!--col-sm-3-->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="form_label">Email address*</label>
                                    <input name="email_id" type="text" class="ims_form_control" id="email_id" value="<?php echo (isset($user)) ? $user->email :''; ?>" placeholder="Email address" />
                                </div>
                            </div><!--col-sm-3-->
                            <div class="col-sm-3">
                                <div class="form-group ims_multiselect">
                                    <label class="form_label">Assign Role*</label>
                                    <select name="usr_role[]"  multiple title="Select Role" class="selectpicker" id="usr_role">
                                        <?php $UserRoles = array(); if(isset($user)) {
                                            $UserRoles = explode(',', $user->role_id);
                                        } ?>
                                        <?php foreach($roles as $rows) {

                                            ?>
                                            <option value="<?php echo $rows->id?>" <?php echo (isset($user) && in_array( $rows->id , $UserRoles)) ? 'selected=selected' :''; ?>><?php echo ucfirst($rows->role_name)?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div><!--col-sm-3-->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form_label">User Type</label>
                                    <div class="checkbox checkbox-inline">
                                        <input type="checkbox" name="is_manager" id="is_manager" value="1" <?php echo (isset($user) && $user->is_manager == 1) ? 'checked=checked' :''; ?>>
                                        <label for="is_manager"> Manager</label>
                                    </div>
                                    <div class="checkbox checkbox-inline">
                                        <input type="checkbox" id="is_technical_head" name="is_technical_head" value="1" <?php echo (isset($user) && $user->is_technical_head == 1) ? 'checked=checked' :''; ?>>
                                        <label for="is_technical_head"> Technical head</label>
                                    </div>
                                    <div class="checkbox checkbox-inline">
                                        <input type="checkbox" name="is_sales_person" id="is_sales_person" value="1" <?php echo (isset($user) && $user->is_sales_person == 1) ? 'checked=checked' :''; ?>>
                                        <label for="is_sales_person"> Salesperson</label>
                                    </div>
                                </div><!--form-group-->
                            </div><!--col-sm-4-->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form_label">Is Active</label>
                                    <div class="radio radio-inline">
                                        <input type="radio" id="status" name="status" value="A" <?php echo (isset($user) && $user->status == 'A') ? 'checked=checked' :''; ?>>
                                        <label for="status"> YES</label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <input type="radio" id="status1" name="status" value="I" <?php echo (isset($user) && $user->status == 'I') ? 'checked=checked' :''; ?>>
                                        <label for="status1"> NO</label>
                                    </div>
                                </div><!--form-group-->
                            </div><!--col-sm-2-->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form_label">Is Executive</label>
                                    <div class="radio radio-inline">
                                        <input type="radio" id="executive_yes" name="is_approver" value="1" <?php echo (isset($user) && $user->is_approver == '1') ? 'checked=checked' :''; ?>>
                                        <label for="executive_yes"> YES</label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <input type="radio" id="executive_no" name="is_approver" value="0" <?php echo (isset($user) && $user->is_approver != '1') ? 'checked=checked' :''; ?>>
                                        <label for="executive_no"> NO</label>
                                    </div>
                                </div><!--form-group-->
                            </div><!--col-sm-4-->
                            <?php
                                $displayProp = "display:none";
                                if(isset($user) && $user->is_approver) {
                                    $displayProp = "";
                                }
                            ?>
                            <div class="col-sm-4 approver" style="<?php echo $displayProp; ?>">
                                <div class="form-group">
                                    <label class="form_label">Approver</label>
                                    <select name="approver_id" class="ims_form_control" id="approver_id">
                                        <option value="">Select Approver</option>
                                        <?php foreach($managers as $man) { ?>
                                            <option value="<?php echo $man->id?>" <?php echo (isset($user) && $user->approver_user_id == $man->id) ? 'selected=selected' :''; ?>><?php echo ucfirst($man->name)?></option>
                                        <?php } ?>
                                    </select>
                                </div>
                            </div><!--col-sm-4-->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form_label">Permissions</label>
                                    <ul class="checktree mCustomScrollbar">
                                        <?php
                                        foreach($permissions as $category => $permission):
                                        ?>
                                            <li>
                                                <div class="checkbox">
                                                    <input type="checkbox" id="1" class="parentCheckBox" <?php echo (isset($uPermissions) && (isset($uPermissions[$category])) && (count($uPermissions[$category]))) ? 'checked=checked' :''; ?> />
                                                    <label for="1"> <?php echo ucfirst($category); ?></label>
                                                </div>
                                                    <ul class="test">
                                                      <?php  if(is_array($permission)):
                                                        foreach($permission as $perm):
                                                        ?>
                                                        <li>
                                                            <div class="checkbox">
                                                                <input type="checkbox" id="permissions[]" name="permissions[]" class="parentCheckBox" value="<?php echo $perm['permissionID']?>" <?php echo (isset($uPermissions) && (isset($uPermissions[$category])) && in_array($perm['permissionID'], $uPermissions[$category])) ? 'checked=checked' :''; ?> />
                                                                <label for="permissions[]"> <?php echo $perm['permission']?></label>
                                                            </div>
                                                        </li>
                                                       <?php endforeach; ?>
                                                    </ul>
                                                <?php
                                                endif;
                                                ?>
                                            </li>
                                            <?php
                                        endforeach;
                                        ?>
                                    </ul>
                                </div>
                            </div><!--col-sm-12-->
                                
                        </div><!--row-->
                    </div><!--theme-form-->
                </div><!--box-form-->
                <div class="col-sm-12">
                    <div class="form-footer">
                        <input type="submit" name="Submit" id="Submit" value="<?php echo (isset($user)? "Edit User":"Add User"); ?>" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">
                        <input name="reset" type="reset" class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" id="reset" value="Reset">
                    </div>
                </div><!--col-sm-12-->
                </form>
            </div><!--col-sm-12-->
        </div><!--row-->
    </div><!--inner_bg-->
</div><!--content-wrapper-->
<!--=================================== Old ======================================-->
<script type="text/javascript">
$(function(){
    $("ul.checktree").checktree();
});

(function($){
    $.fn.checktree = function(){
        $(':checkbox').on('click', function (event){
            event.stopPropagation();
            var clk_checkbox = $(this);
            var chk_state = clk_checkbox.is(':checked');
            var parent_li = clk_checkbox.closest('li');
            var parent_uls = parent_li.parents('ul');
            
            parent_li.find(':checkbox').prop('checked', chk_state);
            parent_uls.each(function(){
                
                parent_ul = $(this);
                console.log(parent_ul.attr('class'));
                parent_state = (parent_ul.find(':checkbox').length == parent_ul.find(':checked').length); 
                parent_state = false;
                parent_ul.siblings(':checkbox').prop('checked', parent_state);
            });
         });
    };
}(jQuery));
    
    
    
    
/*jQuery(document).ready(
    function() {
        //clicking the parent checkbox should check or uncheck all child checkboxes
        jQuery("input[type='checkbox']").change(function () {
            jQuery(this).siblings('ul')
                .find("input[type='checkbox']")
                .prop('checked', this.checked);
        });


        $("input[name='is_approver']").click(function(){
            var checked = $("input[name='is_approver']:checked").val();
            if(checked == 1){
                $(".approver").show();
            } else {
                $(".approver").hide();
                $("#approver_id").val('');
            }
        });
    }
);*/
$("input[name='is_approver']").click(function(){
    var checked = $("input[name='is_approver']:checked").val();
    if(checked == 1){
        $(".approver").show();
    } else {
        $(".approver").hide();
        $("#approver_id").val('');
    }
});
</script>