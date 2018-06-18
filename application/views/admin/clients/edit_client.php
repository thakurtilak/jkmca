<div class="content-wrapper">
        <div class="content_header">
            <h3>Edit Client</h3>
        </div>
    <div class="inner_bg content_box">
		<div class="row">
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
		</div>
        <form action="<?php echo base_url('admin/clients'); ?>/edit-client/<?php echo $clientId; ?>" method="post" id="client_edit" name="client_edit" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box-form">
                            <h3 class="form-box-title">Info</h3>
                            <div class="theme-form">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
											<label class="ims_form_label">Category</label>
                                            <select disabled="disabled" class="ims_form_control" name="category_id" id="category_id">
                                                <option value="">Select Category*</option>
                                                <?php foreach($categories as $rows) { ?>
                                                    <option <?php echo ($rows->id == $clientDetail->category_id)? "selected":""; ?> value="<?php echo $rows->id?>"><?php echo ucfirst($rows->category_name)?></option>
                                                <?php } ?>
                                            </select>
                                            <input type="hidden" name="category_id" value="<?php echo $clientDetail->category_id; ?>">
                                            <label for="category_id" class="error" style="display:none;"></label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
											<label class="ims_form_label">Client</label>
                                            <select disabled="disabled" class="ims_form_control" name="client" id="client">
                                                <option value="<?php echo $clientId; ?>"><?php echo $clientDetail->client_name;?></option>
                                            </select>
                                            <input type="hidden" name="edit_client_id" value="<?php echo $clientId; ?>">
                                            <label for="client" class="error" style="display:none;"></label>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--theme-form-->
                        </div><!--box-theme-->
                    </div><!--col-sm-12-->
                    <div class="col-sm-12">
                        <div class="box-form">
                            <h3 class="form-box-title">Address</h3>
                            <div class="theme-form">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Address Line 1</label>
                                            <input maxlength="250" type="text" name="address1" id="address1" class="ims_form_control" placeholder="Address Line 1*" />
                                            <?php echo form_error('address1'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Address Line 2</label>
                                            <input maxlength="150" type="text" name="address2" id="address2" class="ims_form_control" placeholder="Address Line 2" />
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Country</label>
                                            <select class="ims_form_control" id="country" name="country">
                                                <option value="">Select Country*</option>
                                                <?php foreach($country as $rows) { ?>
                                                    <option value="<?php echo $rows->id?>"><?php echo ucfirst($rows->country_name)?></option>
                                                <?php } ?>
                                            </select>
                                            <?php echo form_error('country'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 client-extra-details" style="display: none">
                                        <div class="form-group">
											<label class="ims_form_label">State</label>
                                            <select class="ims_form_control" name="state" id="state">
                                                <option value="">Select State*</option>
                                                <?php foreach($state as $rows) { ?>
                                                    <option value="<?php echo $rows->id?>"><?php echo ucfirst($rows->state_name)?></option>
                                                <?php } ?>
                                            </select>
                                            <?php echo form_error('state'); ?>
                                        </div>
                                    </div>
                                </div><!--row-->

                                <div class="row client-extra-details" style="display: none">
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">City</label>
                                            <input maxlength="20" type="text" name="city" id="city" class="ims_form_control" placeholder="City*" />
                                            <?php echo form_error('city'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Zip Code</label>
                                            <input maxlength="6" type="text" name="zip_code" id="zip_code" class="ims_form_control" placeholder="Zip Code*" />
                                            <?php echo form_error('zip_code'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">GSTIN No.</label>
                                            <input maxlength="15" type="text" name="gst_no" id="gst_no" class="ims_form_control" placeholder="GSTIN No.*" />
                                            <?php echo form_error('gst_no'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Place of Supply</label>
                                            <input maxlength="20" type="text" name="place_of_supply" id="place_of_supply" class="ims_form_control" placeholder="Place of Supply*" />
                                            <?php echo form_error('place_of_supply'); ?>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--theme-form-->
                        </div><!--box-theme-->
                    </div><!--col-sm-12-->
                    <div class="col-sm-12">
                        <div class="box-form">
                            <h3 class="form-box-title">Manager Detail<a href="javascript:void(0)" onclick="addMoreSalesPerson()" class="add_more_btn pull-right mdl-js-button mdl-js-ripple-effect ripple-white"><img src="<?php echo base_url() ?>assets/images/plus_bordered.svg"  /></a></h3>
                            <div class="theme-form sales_person_box">
                                <div class="row sales_person_row" id="sales_person_row_1">
                                    <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
													<label class="ims_form_label">Manager name</label>
                                                    <input maxlength="50" type="text" name="sales_person_name[]" id="sales_person_name_1" class="ims_form_control sales_person_required" placeholder="Name" />
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
													<label class="ims_form_label">Contact Number</label>
                                                    <input maxlength="50" type="text" name="sales_contact_no[]" id="sales_contact_no_1" class="ims_form_control sales_person_required" placeholder="Contact Number" />
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group email">
													<label class="ims_form_label">Email</label>
                                                    <input maxlength="150" type="text" name="sales_person_email[]" id="sales_person_email_1" class="ims_form_control sales_person_required emailaddress" placeholder="Email" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
											<label class="ims_form_label"></label>
                                            <a href="javascript:void(0);" class="delete_record delete_sales_person"><img src="<?php echo base_url();?>assets/images/delete_icon.svg" /></a>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--theme-form-->
                        </div><!--box-theme-->
                    </div><!--col-sm-12-->
                    <div class="col-sm-12">
                        <div class="box-form">
                            <h3 class="form-box-title">Account Person<a href="javascript:void(0)" onclick="addMoreAccountPerson()" class="add_more_btn pull-right mdl-js-button mdl-js-ripple-effect ripple-white"><img src="<?php echo base_url() ?>assets/images/plus_bordered.svg"  /></a></h3>
                            <div class="theme-form account_person_box">
                                <div class="row account_person_row" id="account_person_row_1">
                                    <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
													<label class="ims_form_label">Account Person Name</label>
                                                    <input maxlength="50" type="text" name="account_person_name[]" id="account_person_name_1" class="ims_form_control account_person_required" placeholder="Name" />
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
													<label class="ims_form_label">Contact Number</label>
                                                    <input maxlength="50" type="text" name="account_contact_no[]" id="account_contact_no_1" class="ims_form_control account_person_required" placeholder="Contact number" />
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
													<label class="ims_form_label">Email</label>
                                                    <input maxlength="150" type="text" name="account_person_email[]" id="account_person_email_1" class="ims_form_control account_person_required emailaddress" placeholder="Email" />
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
											<label class="ims_form_label"></label>
                                            <a href="javascript:void(0);" class="delete_record delete_account_person"><img src="<?php echo base_url();?>assets/images/delete_icon.svg" /></a>
                                        </div>
                                    </div>

                                </div><!--row-->
                            </div><!--theme-form-->
                        </div><!--box-theme-->
                    </div><!--col-sm-12-->

                    <div class="col-sm-12">
                        <div class="box-form">
                            <h3 class="form-box-title">Agreement Details
                                <a href="javascript:void(0)" onclick="addMoreAgreement()" class="add_more_btn pull-right mdl-js-button mdl-js-ripple-effect ripple-white"><img src="<?php echo base_url() ?>assets/images/plus_bordered.svg"  /></a>
                            </h3>
                            <div class="theme-form agreement_box">
                                <div class="row agreement_row" id="agreement_row_1">
                                    <div class="col-sm-11">
                                        <div class="row">
                                            <div class="col-sm-4">
                                                <div class="form-group">
													<label class="ims_form_label">Agreement No.</label>
                                                    <input maxlength="32" type="text" name="agreement_no[]" id="agreement_no_1" class="ims_form_control" placeholder="Agreement no." />
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
													<label class="ims_form_label">Agreement Date</label>
                                                    <input type="text" name="agreement_date[]" id="agreement_date_1" class="agreement_date ims_form_control date_icon sel_date" readonly  placeholder="Agreement date" />
                                                </div>
                                            </div>
                                            <div class="col-sm-4">
                                                <div class="form-group">
													<label class="ims_form_label">Agreement Upload</label>
                                                    <!--<div class="custom-file-upload">
                                                        <input type="hidden" name="agreement_file[]" id="agreement_file_1"/>
                                                        <input type="file" name="agreement_name[]" id="agreement_name_1"  class="ims_form_control upload_icon" placeholder="Agreement Upload*" />
                                                    </div>-->
                                                    <div class="custom-file-upload">
                                                        <input type="hidden" name="agreement_file[]" id="agreement_file_1" value="">
                                                        <div class="file-upload-wrapper">
                                                            <input type="file" name="agreement_name[]" id="agreement_name_1" class="ims_form_control upload_icon custom-file-upload-hidden valid" placeholder="Agreement Upload*" tabindex="-1" aria-invalid="false" style="position: absolute; left: -9999px;">
                                                            <input type="text" name="file-upload-input[]" id="file-upload-input_1" readonly="readonly" class="file-upload-input" placeholder="Agreement upload">
                                                            <button type="button" class="file-upload-button file-upload-select" tabindex="-1">

                                                            </button>
                                                        </div>
                                                        <label id="file-upload-input_1-error" class="error" for="file-upload-input" style="display: none;"></label>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-sm-1">
                                        <div class="form-group">
											<label class="ims_form_label"></label>
                                            <a href="javascript:void(0)" class="delete_record delete_agreement"><img src="<?php echo base_url();?>assets/images/delete_icon.svg" /></a>
                                        </div>
                                    </div>

                                </div><!--row-->

                            </div><!--theme-form-->
                        </div><!--box-theme-->
                    </div><!--col-sm-6-->
                    <div class="col-sm-12">
                        <div class="form-footer">
                            <input type="submit" id="Update" name="Update" value="Update" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white"/>
                            <input name="reset"  type="button" class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" id="reset" value="Reset"/>
                        </div>
                    </div><!--col-sm-12-->
                </div><!--row-->

            </div><!--col-sm-12-->
        </div><!--row-->
        </form>
        <!--Delete Confirm box-->
        <div class="modal fade" id="confirm" tabindex="-1" role="dialog" aria-labelledby="confirmModalLabel" aria-hidden="true">
            <div class="modal-dialog" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                            <span aria-hidden="true">×</span>
                        </button>
                    </div>
                    <div class="modal-body"> Are you sure want to delete ?</div>
                    <div class="modal-footer">
                        <button type="button" data-dismiss="modal" class="btn btn-primary" id="delete">Delete</button>
                        <button type="button" data-dismiss="modal" class="btn">Cancel</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div><!--content-wrapper-->
<script src="<?php echo base_url();?>assets/admin/client-edit.js"></script>
<script>
    var $clientId = "<?php echo $clientId; ?>";

</script>