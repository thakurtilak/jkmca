<div class="content-wrapper">
    <div class="content_header">
        <h3>Menu Assignment</h3>
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
                    <div class="alert alert-info" style="margin-top:18px;">
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
                                    <label class="form_label">Select Role*</label>
                                    <select name="role_id" class="ims_form_control" id="role_id">
                                        <option value="">Select User Role</option>
                                        <?php
                                        if($allRoles):
                                            foreach($allRoles as $roleItem) : ?>
                                                <option value="<?php echo $roleItem->id; ?>" <?php echo (isset($selectedRole) && $selectedRole->id == $roleItem->id) ? 'selected=selected' :''; ?>><?php echo ucfirst($roleItem->role_name)?></option>
                                            <?php endforeach;endif; ?>
                                    </select>
                                </div>
                            </div><!--col-sm-3-->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <h5 class="form-box-subtitle">Assign Primary Menus</h5>
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <label class="form_label">Available Menu</label>
                                            <div class="menu-items mCustomScrollbar">
                                                <select name="sourceParentMenus[]"  class="textbox ParentMenus" id="sourceParentMenus" multiple="multiple">
                                                    <?php
                                                    if($allParentMenus):
                                                        foreach($allParentMenus as $menuItem) :
                                                            if(!in_array($menuItem->menu_id, $selectedRoleMenus)):
                                                            ?>
                                                          <option class="ui-state-highlight" value="<?php echo $menuItem->menu_id; ?>" selected="selected"><?php echo ucfirst($menuItem->display_name)?></option>
                                                        <?php endif; endforeach;endif; ?>
                                                </select>
                                            </div>
                                        </div><!--col-sm-4-->
                                        <div class="col-sm-4">
                                            <label class="form_label">Selected Menu</label>
                                            <div class="menu-items">
                                                <select name="targetParentMenus[]"  class="ParentMenus  " id="targetParentMenus" multiple="multiple">
                                                    <?php
                                                    if($allParentMenus):
                                                        foreach($allParentMenus as $menuItem) :
                                                            if(in_array($menuItem->menu_id, $selectedRoleMenus)):
                                                            ?>
                                                            <option class="ui-state-highlight" value="<?php echo $menuItem->menu_id; ?>" selected="selected"><?php echo ucfirst($menuItem->display_name)?></option>
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
                        <input type="submit" type="submit" name="Submit" id="Submit" value="<?php echo (isset($menu)? "Edit Menu":"Add Menu"); ?>" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">
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
            $( "#sourceParentMenus, #targetParentMenus" ).sortable({
                connectWith: ".ParentMenus",
                cancel: "a,button,input,textarea"
            }).disableSelection();

            $("#role_id").change(function(){
                var selectedRoleId = $(this).val();
                window.location = BASEURL + 'admin/menu/menu-assignment/'+selectedRoleId;
            });
        }
    );
</script>