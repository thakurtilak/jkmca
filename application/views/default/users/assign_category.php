<div class="content-wrapper">
    <div class="content_header">
        <h3>Category Assignment</h3>
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
                <?php if($this->session->flashdata('success') != '') { ?>
                    <div class="alert alert-success" style="margin-top:18px;">
                        <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                        <?php echo $this->session->flashdata('success'); ?>
                    </div>
                <?php } ?>
                <form id="menuAddFrom" name="menuAddFrom" method="post" action="">
                    <div class="box-form">
                        <div class="theme-form">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form_label">Select Generator*</label>
                                        <select name="user_id" class="ims_form_control" id="user_id">
                                            <option value="">Select User</option>
                                            <?php
                                            if($allUsers):
                                                foreach($allUsers as $user) : ?>
                                                    <option value="<?php echo $user->id; ?>" <?php echo (isset($selectedUser) && $selectedUser == $user->id) ? 'selected=selected' :''; ?>><?php echo ucfirst($user->name)?></option>
                                                <?php endforeach;endif; ?>
                                        </select>
                                    </div>
                                </div><!--col-sm-3-->
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <h5 class="form-box-subtitle">Assign Category</h5>
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <label class="form_label">Available Category</label>
                                                <div class="menu-items mCustomScrollbar">
                                                    <select name="sourceParentCategory[]"  class="textbox ParentMenus" id="sourceParentCategory" multiple="multiple">
                                                        <?php
                                                        if($categories):
                                                            foreach($categories as $cat) :
                                                                if(!in_array($cat->id, $selectedCategories)):
                                                                    ?>
                                                                    <option class="ui-state-highlight" value="<?php echo $cat->id; ?>" selected="selected"><?php echo ucfirst($cat->category_name)?></option>
                                                                <?php endif; endforeach;endif; ?>
                                                    </select>
                                                </div>
                                            </div><!--col-sm-4-->
                                            <div class="col-sm-4">
                                                <label class="form_label">Selected Category</label>
                                                <div class="menu-items">
                                                    <select name="targetParentCategory[]"  class="ParentMenus  " id="targetParentCategory" multiple="multiple">
                                                        <?php
                                                        if($categories):
                                                            foreach($categories as $cat) :
                                                                if(in_array($cat->id, $selectedCategories)):
                                                                    ?>
                                                                    <option class="ui-state-highlight" value="<?php echo $cat->id; ?>" selected="selected"><?php echo ucfirst($cat->category_name)?></option>
                                                                <?php endif; endforeach;endif; ?>
                                                    </select>
                                                </div>
                                            </div><!--col-sm-4-->
                                        </div><!--row-->
                                    </div><!--form-group-->
                                </div><!--col-sm-12-->

                            </div><!--row-->
                        </div><!--theme-form-->
                    </div><!--box-form-->
                    <div class="col-sm-12">
                        <div class="form-footer">
                            <input type="submit" type="submit" name="Submit" id="Submit" value="Assign Category" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">
                            <input name="reset" type="reset" class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" id="reset" value="Reset">
                        </div>
                    </div><!--col-sm-12-->
                </form>
            </div><!--col-sm-12-->
        </div><!--row-->
    </div><!--inner_bg-->
</div><!--content-wrapper-->
<script type="text/javascript">
    jQuery(document).ready(
        function() {
            $( "#sourceParentCategory, #targetParentCategory" ).sortable({
                connectWith: ".ParentMenus",
                cancel: "a,button,input,textarea"
            }).disableSelection();

            $("#user_id").change(function(){
                var selectedRoleId = $(this).val();
                window.location = BASEURL + 'admin/users/assign-category/'+selectedRoleId;
            });
        }
    );
</script>
<style>
    .menu-items select {
        width: 100%;
        min-height: 410px;
    }
</style>