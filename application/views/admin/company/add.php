<div class="content-wrapper">
    <div class="content_header">
        <h3><?php echo (isset($company)? "Edit":"Add"); ?> Company</h3>
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
                <form id="companyAddFrom" name="companyAddFrom" method="post" action="">
                    <div class="box-form">
                        <div class="theme-form">
                            <div class="row">
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form_label">Company Name*</label>
                                        <input name="company_name" type="text" class="ims_form_control" id="company_name" value="<?php echo (isset($company)) ? $company->company_name :''; ?>" placeholder="Company Name" />
                                        <?php echo form_error('company_name'); ?>
                                    </div>
                                </div><!--col-sm-3-->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form_label">Company Short Code*</label>
                                        <input name="company_short_code" type="text" class="ims_form_control" id="company_short_code" value="<?php echo (isset($company)) ? $company->company_short_code :''; ?>" placeholder="Company Short Code" />
                                        <?php echo form_error('company_short_code'); ?>
                                    </div>
                                </div><!--col-sm-3-->
                                <div class="col-sm-6">
                                    <div class="form-group">
                                        <label class="form_label">Company Address*</label>
                                        <textarea name="company_address" id="company_address" class="ims_form_control" placeholder="Company Address"><?php echo (isset($company)) ? $company->company_address :''; ?></textarea>
                                        <?php echo form_error('company_address'); ?>
                                    </div>
                                </div><!--col-sm-3-->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form_label">Company Contact*</label>
                                        <input name="company_contact" type="text" class="ims_form_control" id="company_contact" value="<?php echo (isset($company)) ? $company->company_contact :''; ?>"  placeholder="Company Contact" />
                                        <?php echo form_error('company_contact'); ?>
                                    </div>
                                </div><!--col-sm-3-->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form_label">Company Fax</label>
                                        <input name="company_fax" type="text" class="ims_form_control" id="company_fax" value="<?php echo (isset($company)) ? $company->company_fax :''; ?>"  placeholder="Company Fax" />
                                        <?php echo form_error('company_fax'); ?>
                                    </div>
                                </div><!--col-sm-3-->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form_label">Company PAN</label>
                                        <input name="pan_no" type="text" class="ims_form_control" id="pan_no" value="<?php echo (isset($company)) ? $company->pan_no :''; ?>"  placeholder="Company PAN" />
                                        <?php echo form_error('pan_no'); ?>
                                    </div>
                                </div><!--col-sm-3-->
                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form_label">Company GSTIN</label>
                                        <input name="gst_no" type="text" class="ims_form_control" id="gst_no" value="<?php echo (isset($company)) ? $company->gst_no :''; ?>"  placeholder="Company GSTIN" />
                                        <?php echo form_error('gst_no'); ?>
                                    </div>
                                </div><!--col-sm-3-->

                                <div class="col-sm-3">
                                    <div class="form-group">
                                        <label class="form_label">Company SAC Code</label>
                                        <input name="sac_code" type="text" class="ims_form_control" id="sac_code" value="<?php echo (isset($company)) ? $company->sac_code :''; ?>"  placeholder="Company SAC" />
                                        <?php echo form_error('sac_code'); ?>
                                    </div>
                                </div><!--col-sm-3-->

                                <div class="col-sm-9">
                                    <div class="form-group">
                                        <label class="form_label">Invoice Footer Text</label>
                                        <!--<input name="invoice_footer_text" type="text" class="ims_form_control" id="invoice_footer_text" value="<?php /*echo (isset($company)) ? $company->invoice_footer_text :''; */?>"  placeholder="Invoice Footer Text" />-->
                                        <textarea rows="4" name="invoice_footer_text" id="invoice_footer_text" class="ims_form_control" placeholder="Invoice Footer Text"><?php echo (isset($company)) ? $company->invoice_footer_text :''; ?></textarea>
                                        <?php echo form_error('invoice_footer_text'); ?>
                                    </div>
                                </div><!--col-sm-3-->
                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form_label">Is Default</label>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="is_default" name="is_default" value="Y" <?php echo (isset($company) && $company->is_default == 'Y') ? 'checked=checked' :''; ?>>
                                            <label for="is_default"> YES</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="is_default1" name="is_default" value="N" <?php echo (isset($company) && $company->is_default == 'N') ? 'checked=checked' :''; ?>>
                                            <label for="is_default1"> NO</label>
                                        </div>
                                        <?php echo form_error('is_active'); ?>
                                    </div><!--form-group-->
                                </div><!--col-sm-12-->

                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form_label">Include Tax</label>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="include_tax" name="include_tax" value="Y" <?php echo (isset($company) && $company->include_tax == 'Y') ? 'checked=checked' :''; ?>>
                                            <label for="include_tax"> YES</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="include_tax1" name="include_tax" value="N" <?php echo (isset($company) && $company->include_tax == 'N') ? 'checked=checked' :''; ?>>
                                            <label for="include_tax1"> NO</label>
                                        </div>
                                        <?php echo form_error('include_tax'); ?>
                                    </div><!--form-group-->
                                </div><!--col-sm-12-->


                                <div class="col-sm-4">
                                    <div class="form-group">
                                        <label class="form_label">Is Active</label>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="is_active" name="is_active" value="Y" <?php echo (isset($company) && $company->is_active == 'Y') ? 'checked=checked' :''; ?>>
                                            <label for="is_active"> YES</label>
                                        </div>
                                        <div class="radio radio-inline">
                                            <input type="radio" id="is_active1" name="is_active" value="N" <?php echo (isset($company) && $company->is_active == 'N') ? 'checked=checked' :''; ?>>
                                            <label for="is_active1"> NO</label>
                                        </div>
                                        <?php echo form_error('is_active'); ?>
                                    </div><!--form-group-->
                                </div><!--col-sm-12-->
                            </div><!--row-->
                        </div><!--theme-form-->
                    </div><!--box-form-->
                    <div class="col-sm-12">
                        <div class="form-footer">
                            <input type="submit" name="Submit" id="Submit" value="<?php echo (isset($company)? "Edit Company":"Add Company"); ?>" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">
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
       $("#companyAddFrom").validate({
           rules:{
               company_name:{
                   required:true
               },
               company_short_code:{
                   required:true
               },
               company_address:{
                   required:true
               },
               company_contact:{
                   required:true
               },
               is_default:{
                   required:true
               },
               include_tax:{
                   required:true
               },
               is_active:{
                   required:true
               }
           },
           messages:{
               company_name:{
                   required:"This field is required"
               },
               company_short_code:{
                   required:"This field is required"
               },
               company_address:{
                   required:"This field is required"
               },
               company_contact:{
                   required:"This field is required"
               },
               is_default:{
                   required:"This field is required"
               },
               include_tax:{
                   required:"This field is required"
               },
               is_active:{
                   required:"This field is required"
               }
           }
       });
    });
</script>