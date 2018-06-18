<div class="content-wrapper">
    <div class="content_header">
        <h3><?php echo (isset($currency)? "Edit":"Add"); ?> Currency</h3>
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
                <form id="currencyAddFrom" name="currencyAddFrom" method="post" action="">
                    <div class="box-form">
                        <div class="theme-form">
                            <div class="row">
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form_label">Currency Name*</label>
                                        <input name="currency_name" type="text" class="ims_form_control" id="currency_name" value="<?php echo (isset($currency)) ? $currency->currency_name :''; ?>" placeholder="Currency Name" />
                                        <?php echo form_error('currency_name'); ?>
                                    </div>
                                </div><!--col-sm-3-->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form_label">Currency Symbol*</label>
                                        <input name="currency_symbol" type="text" class="ims_form_control" id="currency_symbol" value="<?php echo (isset($currency)) ? $currency->currency_symbol :''; ?>"  placeholder="Currency Symbol" />
                                        <?php echo form_error('currency_symbol'); ?>
                                    </div>
                                </div><!--col-sm-3-->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form_label">Is Active</label>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="currency_status" name="currency_status" value="1" <?php echo (isset($currency) && $currency->currency_status == '1') ? 'checked=checked' :''; ?>>
                                            <label for="status"> YES</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="currency_status1" name="currency_status" value="0" <?php echo (isset($currency) && $currency->currency_status == '0') ? 'checked=checked' :''; ?>>
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
                            <input type="submit" name="Submit" id="Submit" value="<?php echo (isset($currency)? "Edit Currency":"Add Currency"); ?>" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">
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
       $("#currencyAddFrom").validate({
           rules:{
               currency_name:{
                   required:true
               },
               currency_symbol:{
                   required:true
               },
               currency_status:{
                   required:true
               }
           },
           messages:{
               currency_name:{
                   required:"This field is required"
               },
               currency_symbol:{
                   required:"This field is required"
               },
               currency_status:{
                   required:"This field is required"
               }
           }
       });
    });
</script>