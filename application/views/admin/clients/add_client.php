<div class="content-wrapper">
    <div class="content_header">
        <h3>Add Client</h3>
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

    <form name="mp_add_client_frm" enctype="multipart/form-data" method="post" id="mp_add_client_frm" action="">


    <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="box-form">
                            <h3 class="form-box-title">Client Info</h3>
                            <div class="theme-form">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input type="text" name="client_name" class="ims_form_control" maxlength="50" id="client_name" placeholder="Client name*"/>
                                            <?php echo form_error('client_name'); ?>
                                            <label class="error" style="display:none;">Required</label>
                                        </div>

                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <select class="ims_form_control" name="category_id" id="category_id">
                                                <option value="">Select category*</option>
                                                <?php foreach($categories as $rows) { ?>
                                                    <option value="<?php echo $rows->id?>"><?php echo ucfirst($rows->category_name)?></option>
                                                <?php } ?>
                                            </select>
                                            <?php echo form_error('category_id'); ?>
                                            <label class="error" style="display:none;">Required</label>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--theme-form-->
                        </div><!--box-theme-->
                    </div><!--col-sm-12-->
                    <div class="col-sm-6">
                        <div class="box-form">
                            <h3 class="form-box-title">Manager Detail</h3>
                            <div class="theme-form">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input maxlength="50" type="text" name="sales_person_name" class="ims_form_control" id="sales_person_name"  placeholder="Name" />
                                            <?php echo form_error('sales_person_name'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input maxlength="50" type="text" name="sales_contact_no"  id="sales_contact_no" class="ims_form_control"  placeholder="Contact number"/>
                                            <?php echo form_error('sales_contact_no'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input maxlength="150" type="text" name="sales_person_email" id="sales_person_email" class="ims_form_control"  placeholder="Email" />
                                            <?php echo form_error('sales_person_email'); ?>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--theme-form-->
                        </div><!--box-theme-->
                    </div><!--col-sm-6-->
                    <div class="col-sm-6">
                        <div class="box-form">
                            <h3 class="form-box-title">Account Person Detail</h3>
                            <div class="theme-form">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input maxlength="50" type="text" name="account_person_name" class="ims_form_control" id="account_person_name"  placeholder="Name" />

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input maxlength="50" type="text" name="account_contact_no" class="ims_form_control" id="account_contact_no"  placeholder="Contact number" />

                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <input maxlength="150" type="text" name="account_person_email" class="ims_form_control" id="account_person_email"  placeholder="Email" />
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--theme-form-->
                        </div><!--box-theme-->
                    </div><!--col-sm-6-->
                    <div class="col-sm-6">
                        <div class="box-form client_adress">
                            <h3 class="form-box-title">Client Address</h3>
                            <div class="theme-form">
                                <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input maxlength="255" type="text" name="address1" class="ims_form_control" id="address1"  placeholder="Address line 1*" />
                                            <?php echo form_error('address1'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input maxlength="150" type="text" name="address2" id="address2" class="ims_form_control"  placeholder="Address line 2" />
                                    	</div>
                                    </div>
									<div class="clearfix"></div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <select class="ims_form_control" name="country" id="country">
                                                <option value="">Country*</option>
                                                <?php foreach($country as $rows) { ?>
                                                    <option value="<?php echo $rows->id?>"><?php echo ucfirst($rows->country_name)?></option>
                                                <?php } ?>

                                            </select>
                                            <?php echo form_error('country'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="row1 row-hide indian-row" id="statediv">

                                            <select class="ims_form_control" name="state" id="state">
                                                <option value="">State*</option>
                                                <?php foreach($state as $rows) { ?>
                                                    <option value="<?php echo $rows->id?>"><?php echo ucfirst($rows->state_name)?></option>
                                                <?php } ?>
                                            </select>
                                            <?php echo form_error('state'); ?>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--theme-form-->

                            <div class="theme-form">
                                <div class="row1 row-hide indian-row" id="citydiv">
                                    <div class="row">
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input maxlength="20" type="text" name="city" class="ims_form_control"  id="city" placeholder="City*" />
                                            <?php echo form_error('city'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input maxlength="20" type="text" name="place_of_supply"  id="place_of_supply" class="ims_form_control" placeholder="Place of supply*" />
                                            <?php echo form_error('place_of_supply'); ?>
                                        </div>
                                    </div>
                                        </div>
                                    </div>

                                <div class="row1 row-hide indian-row" id="gstdiv">
                                    <div class="row">

                                    <div class="col-sm-6">
                                        <div class="form-group">
                                            <input maxlength="15" type="text" name="gst_no" class="ims_form_control" id="gst_no" placeholder="GSTIN No.*" />
                                            <?php echo form_error('gst_no'); ?>

                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">

                                            <input maxlength="6" type="text" name="zip_code" class="ims_form_control" id="zip_code" placeholder="Zip Code*" />
                                            <?php echo form_error('zip_code'); ?>
                                        </div>
                                    </div>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--theme-form-->


                        </div><!--col-sm-6-->
                    <div class="col-sm-12">
                        <div class="box-form">
                            <h3 class="form-box-title">Agreement Details</h3>
                            <div class="theme-form">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input maxlength="32" type="text" name="agreement_no" class="ims_form_control" id="agreement_no"  placeholder="Agreement no." />

                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <input type="text" name="agreement_date" id="agreement_date" class="ims_form_control date_icon sel_date" readonly  placeholder="Agreement date"/>

                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">

                                            <div class="custom-file-upload">
                                                <input type="hidden" name="agreement_file[]" id="agreement_file_1" value="">

                                                <div class="file-upload-wrapper">
                                                    <input type="file" name="agreement_name" id="agreement_name" class="ims_form_control upload_icon custom-file-upload-hidden valid" placeholder="Agreement Upload*" tabindex="-1" aria-invalid="false" style="position: absolute; left: -9999px;">
                                                    <input type="text" name="file-upload-input"  class="file-upload-input" placeholder="Agreement upload" readonly>
                                                    <button type="button" class="file-upload-button file-upload-select" tabindex="-1">

                                                    </button>
                                                </div>
                                                <label id="file-upload-input-error" class="error" for="file-upload-input" style="display: none;"></label>
                                            </div>
                                        </div>
                                    </div>
                                </div><!--row-->

                            </div><!--theme-form-->
                        </div><!--box-theme-->
                    </div><!--col-sm-6-->
                    <div class="col-sm-12">
                        <div class="form-footer">
                            <input type="submit" id="submit" name="submit" onclick="submit"  value="Create" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white"/>
                            <input name="reset"  type="reset" class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" id="reset" value="Reset"/>
                        </div>
                    </div><!--col-sm-12-->
                </div><!--row-->

            </div><!--col-sm-12-->
        </div><!--row-->
</form>
 </div><!--content-wrapper-->
<script src="<?php echo base_url();?>assets/js/client.js"></script>
 <style>
     .indian-row {
         display:none;
     }
 </style>
