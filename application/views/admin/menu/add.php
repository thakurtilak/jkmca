<div class="content-wrapper">
    <div class="content_header">
        <h3><?php echo (isset($menu)? "Edit":"Add"); ?> Menu</h3>
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
                <form id="menuAddFrom" name="menuAddFrom" method="post" action="">
                <div class="box-form">
                    <div class="theme-form">
                        <div class="row">
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="form_label">Menu Name*</label>
                                    <input name="menu_name" type="text" class="ims_form_control" id="menu_name" value="<?php echo (isset($menu)) ? $menu->menu_name :''; ?>" placeholder="Menu Name*" />
                                </div>
                            </div><!--col-sm-3-->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="form_label">Menu Display Name*</label>
                                    <input name="display_name" type="text" class="ims_form_control" id="display_name" value="<?php echo (isset($menu)) ? $menu->display_name :''; ?>" placeholder="Menu Display Name*" />
                                </div>
                            </div><!--col-sm-3-->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="form_label">Menu Description*</label>
                                    <input name="menu_description" type="text" class="ims_form_control" id="menu_description" value="<?php echo (isset($menu)) ? $menu->menu_description :''; ?>" placeholder="Menu Description*" />
                                </div>
                            </div><!--col-sm-3-->
                            <div class="col-sm-3">
                                <div class="form-group">
                                    <label class="form_label">Redirect URL*</label>
                                    <input name="redirect_url" type="text" class="ims_form_control" id="redirect_url" value="<?php echo (isset($menu)) ? $menu->redirect_url :''; ?>" placeholder="Redirect URL*" /><span class="help_text">(Add "NA" if it is Parent menu)</span>
                                </div>
                            </div><!--col-sm-3-->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form_label">Menu Type</label>
                                    <div class="radio radio-inline">
                                        <input type="radio" id="menu_type_p" name="menu_type" value="Parent" <?php echo (isset($menu) && $menu->menu_type == 'Parent') ? 'checked=checked' :''; ?>>
                                        <label for="menu_type_p"> Parent</label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <input type="radio" id="menu_type_c" name="menu_type" value="Child" <?php echo (isset($menu) && $menu->menu_type == 'Child') ? 'checked=checked' :''; ?>>
                                        <label for="menu_type_c"> Child</label>
                                    </div>
                                </div>
                            </div><!--col-sm-3-->
                            <?php
                            $displayProp = "display:none";
                            if(isset($menu) && $menu->menu_type == 'Child') {
                                $displayProp = "";
                            }
                            ?>
                            <div class="col-sm-3 parent-menu-row" style="<?php echo $displayProp; ?>" class="parent-menu-row">
                                <div class="form-group">
                                    <label class="form_label">Parent Menu</label>
                                    <select name="parent_id" class="ims_form_control" id="parent_id">
                                        <option value="">Select Parent</option>
                                        <?php
                                        if($parentMenus):
                                        foreach($parentMenus as $man) : ?>
                                            <option value="<?php echo $man->menu_id; ?>" <?php echo (isset($menu) && $menu->parent_id == $man->menu_id) ? 'selected=selected' :''; ?>><?php echo ucfirst($man->display_name)?></option>
                                        <?php endforeach;endif; ?>
                                    </select>
                                </div>
                            </div><!--col-sm-3-->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form_label">Display Menu</label>
                                    <div class="radio radio-inline">
                                        <input type="radio" id="is_display_y" name="is_display" value="Y" <?php echo (isset($menu) && $menu->is_display == 'Y') ? 'checked=checked' :''; ?>>
                                        <label for="is_display_y"> Yes</label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <input type="radio" id="is_display_n" name="is_display" value="N" <?php echo (isset($menu) && $menu->is_display == 'N') ? 'checked=checked' :''; ?>>
                                        <label for="is_display_n"> No</label>
                                    </div>
                                </div>
                            </div><!--col-sm-3-->
                            <div class="col-sm-12">
                                <div class="form-group">
                                    <label class="form_label">Is Active</label>
                                    <div class="radio radio-inline">
                                        <input type="radio" id="is_active_y" name="is_active" value="Y" <?php echo (isset($menu) && $menu->is_active == 'Y') ? 'checked=checked' :''; ?>>
                                        <label for="is_active_y"> Yes</label>
                                    </div>
                                    <div class="radio radio-inline">
                                        <input type="radio" id="is_active_n" name="is_active" value="N" <?php echo (isset($menu) && $menu->is_active == 'N') ? 'checked=checked' :''; ?>>
                                        <label for="is_active_n"> No</label>
                                    </div>
                                </div>
                            </div><!--col-sm-3-->
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

            $("input[name='menu_type']").click(function(){
                var checked = $("input[name='menu_type']:checked").val();
                if(checked == 'Child'){
                    $(".parent-menu-row").show();
                } else {
                    $(".parent-menu-row").hide();
                    $("#parent_id").val('0');
                }
            });
        }
    );
</script>