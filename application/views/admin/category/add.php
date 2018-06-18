<div class="content-wrapper">
    <div class="content_header">
        <h3><?php echo (isset($category)? "Edit":"Add"); ?> Category</h3>
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
                <form id="categoryAddFrom" name="categoryAddFrom" method="post" action="">
                    <div class="box-form">
                        <div class="theme-form">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form_label">Category Name*</label>
                                        <input name="category_name" type="text" class="ims_form_control" id="category_name" value="<?php echo (isset($category)) ? $category->category_name :''; ?>" placeholder="Category Name" />
                                        <?php echo form_error('category_name'); ?>
                                    </div>
                                </div><!--col-sm-3-->

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form_label">Is Service Category*</label>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="is_service_category" name="is_service_category" value="1" <?php echo (isset($category) && $category->is_service_category == '1') ? 'checked=checked' :''; ?>>
                                            <label for="is_service_category"> YES</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="is_service_category1" name="is_service_category" value="0" <?php echo (isset($category) && $category->is_service_category == '0') ? 'checked=checked' :''; ?>>
                                            <label for="is_service_category1">NO</label>
                                        </div>
                                        <?php echo form_error('is_service_category'); ?>
                                    </div><!--form-group-->
                                </div><!--col-sm-12-->
                                <?php
                                $displayProp = "";
                                if(isset($category) && $category->is_service_category) {
                                    $displayProp = "display:none";
                                }
                                ?>
                                <div class="col-sm-4 order_category_div" style="<?php echo $displayProp; ?>">
                                    <div class="form-group">
                                        <label class="form_label">Is Order Category*</label>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="is_order_category" name="is_order_category" value="1" <?php echo (isset($category) && $category->is_order_category == '1') ? 'checked=checked' :''; ?>>
                                            <label for="is_order_category"> YES</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="is_order_category1" name="is_order_category" value="0" <?php echo (isset($category) && $category->is_order_category == '0') ? 'checked=checked' :''; ?>>
                                            <label for="is_order_category1">NO</label>
                                        </div>
                                        <?php echo form_error('is_order_category'); ?>
                                    </div><!--form-group-->
                                </div><!--col-sm-12-->

                                <div class="col-sm-12 main_category" style="<?php echo $displayProp; ?>" >
                                    <div class="form-group">
                                        <label class="form_label">Is Main Category*</label>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="parent_category" name="parent_category" value="1" <?php echo (isset($category) && $category->parent_id == '0') ? 'checked=checked' :''; ?>>
                                            <label for="parent_category"> YES</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="parent_category1" name="parent_category" value="0" <?php echo (isset($category) && $category->parent_id != '0') ? 'checked=checked' :''; ?>>
                                            <label for="parent_category1">NO</label>
                                        </div>
                                        <?php echo form_error('parent_category'); ?>
                                    </div><!--form-group-->
                                </div><!--col-sm-12-->
                                <?php
                                $displayProp = "display:none";
                                if(isset($category) && $category->parent_id) {
                                    $displayProp = "";
                                }
                                ?>
                                <div class="col-sm-4 parentCategory" style="<?php echo $displayProp; ?>">
                                    <div class="form-group">
                                        <label class="form_label">Parent Category*</label>
                                        <select name="parent_id" class="ims_form_control" id="parent_id">
                                            <option value="">Select Parent Category</option>
                                            <?php if(isset($parentCategory)) { foreach($parentCategory as $cate) { ?>
                                                <option value="<?php echo $cate->id ?>" <?php echo (isset($category) && $category->parent_id == $cate->id) ? 'selected=selected' :''; ?>><?php echo ucfirst($cate->category_name)?></option>
                                            <?php } } ?>
                                        </select>
                                    </div>
                                </div><!--col-sm-4-->
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="form_label">Is Active*</label>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="status" name="status" value="1" <?php echo (isset($category) && $category->status == '1') ? 'checked=checked' :''; ?>>
                                            <label for="status"> YES</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="status1" name="status" value="0" <?php echo (isset($category) && $category->status == '0') ? 'checked=checked' :''; ?>>
                                            <label for="status1"> NO</label>
                                        </div>
                                        <?php echo form_error('currency_status'); ?>
                                    </div><!--form-group-->
                                </div><!--col-sm-12-->
                            </div><!--row-->
                        </div><!--theme-form-->
                    </div><!--box-form-->
                    <div class="col-sm-12">
                        <div class="form-footer">
                            <input type="submit" name="Submit" id="Submit" value="<?php echo (isset($currency)? "Edit Category":"Add Category"); ?>" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">
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
    $(document).ready(function(){
        $("#categoryAddFrom").validate({
            rules:{
                category_name:{
                    required:true
                },
                is_service_category:{
                    required:true
                },
                is_order_category:{
                    required:true
                },
                parent_category:{
                    required:true
                },
                parent_id:{
                    required:true
                },
                status:{
                    required:true
                },
            },
            messages:{
                category_name:{
                    required:"This field is required"
                },
                is_service_category:{
                    required:"This field is required"
                },
                is_order_category:{
                    required:"This field is required"
                },
                parent_category:{
                    required:"This field is required"
                },
                parent_id:{
                    required:"This field is required"
                },
                status:{
                    required:"This field is required"
                }
            }
        });

        $("input[name='parent_category']").click(function(){
            var checked = $("input[name='parent_category']:checked").val();
            if(checked == 1){
                $(".parentCategory").hide();
                $("#parent_id").val('');
            } else {
                $(".parentCategory").show();
            }
        });

        $("input[name='is_service_category']").click(function(){
            var checked = $("input[name='is_service_category']:checked").val();
            if(checked == 1){
                $(".parentCategory").hide();
                $("#parent_id").val('');

                $(".main_category").hide();
                $("input[name='parent_category']:checked").prop('checked', false);

                $(".order_category_div").hide();
                $("input[name='is_order_category']:checked").prop('checked', false);
            } else {
                $(".main_category").show();
                $(".order_category_div").show();
            }
        });

    });
</script>