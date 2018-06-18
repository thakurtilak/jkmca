<?php
$address = '';
if (isset($clientRecord->client_id)) {
    $address = $clientRecord->address1 . " " . $clientRecord->address2;
    $address .= ", " . $clientRecord->city . " " . $clientRecord->zip_code;
}

?>
<?php if ($type == '1'): ?>
    <div class="col-sm-12" id="PAN_work" style="">
        <div class="row">
            <div class="col-sm-12">
                <div class="box-form">
                    <h3 class="form-box-title">Applicant information</h3>
                    <div class="theme-form">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">First Name*</label>
                                    <input type="text" name="first_name" class="ims_form_control"
                                           maxlength="50" id="first_name" placeholder="First Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->first_name : "" ?>"/>
                                    <?php echo form_error('first_name'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Middle Name</label>
                                    <input type="text" name="middle_name" class="ims_form_control"
                                           maxlength="50" id="middle_name" placeholder="Middle Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->middle_name : "" ?>"/>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Last Name</label>
                                    <input type="text" name="last_name" class="ims_form_control"
                                           maxlength="50" id="last_name" placeholder="Last Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->last_name : "" ?>"/>
                                    <?php echo form_error('last_name'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Date Of Birth*</label>
                                    <input maxlength="15" type="text" name="dob" id="dob"
                                           class="ims_form_control date_icon sel_date" readonly placeholder="DOB"
                                           value="<?php echo (isset($clientRecord->client_id) && $clientRecord->dob) ? date('d-M-Y', strtotime($clientRecord->dob)) : "" ?>"/>
                                    <?php echo form_error('dob'); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Mobile NO.*</label>
                                    <input type="text" name="mobile_number" class="ims_form_control"
                                           maxlength="15" id="mobile_number" placeholder="Mobile NO."
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->mobile : "" ?>"/>
                                    <?php echo form_error('mobile_number'); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Aadhar Card NO.*</label>
                                    <input class="ims_form_control" type="text" name="aadhar_no" id="aadhar_no"
                                           placeholder="Aadhar Card NO."
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->aadhar_number : ''; ?>">
                                    <?php echo form_error('aadhar_no'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Address</label>
                                    <textarea class="ims_form_control" name="address" id="address"
                                              placeholder="Address"><?php echo $address; ?></textarea>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php if ($type == '2'): ?>
    <div class="col-sm-12 income_tax_work1" id="income_tax_work" style="">
        <div class="row">
            <div class="col-sm-12">
                <div class="box-form">
                    <h3 class="form-box-title">Basic Details</h3>
                    <div class="theme-form">
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">First Name*</label>
                                    <input type="text" name="first_name" class="ims_form_control"
                                           maxlength="50" id="first_name" placeholder="First Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->first_name : "" ?>"/>
                                    <?php echo form_error('first_name'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Middle Name</label>
                                    <input type="text" name="middle_name" class="ims_form_control"
                                           maxlength="50" id="middle_name" placeholder="Middle Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->middle_name : "" ?>"/>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Last Name</label>
                                    <input type="text" name="last_name" class="ims_form_control"
                                           maxlength="50" id="last_name" placeholder="Last Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->last_name : "" ?>"/>
                                    <?php echo form_error('last_name'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Father First Name*</label>
                                    <input type="text" name="father_first_name" class="ims_form_control"
                                           maxlength="50" id="father_first_name" placeholder="First Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->father_first_name : "" ?>"/>
                                    <?php echo form_error('father_first_name'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Father Middle Name</label>
                                    <input type="text" name="father_middle_name" class="ims_form_control"
                                           maxlength="50" id="father_middle_name" placeholder="Middle Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->father_middle_name : "" ?>"/>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Father Last Name</label>
                                    <input type="text" name="father_last_name" class="ims_form_control"
                                           maxlength="50" id="father_last_name" placeholder="Last Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->father_last_name : "" ?>"/>
                                    <?php echo form_error('father_last_name'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Mobile No*</label>
                                    <input class="ims_form_control" type="text" name="mobile_number" id="mobile_number"
                                           placeholder="Mobile No"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->mobile : ''; ?>">
                                    <?php echo form_error('mobile_number'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">PAN NO.*</label>
                                    <input class="ims_form_control" type="text" name="pan_no" id="pan_no"
                                           placeholder="PAN NO"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->pan_no : ''; ?>">
                                    <?php echo form_error('pan_no'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">DOB*</label>
                                    <input class="ims_form_control date_icon sel_date" type="text" name="dob" id="dob"
                                           placeholder="DOB"
                                           value="<?php echo (isset($clientRecord->client_id)) ? date('d-M-Y', strtotime($clientRecord->dob)) : ''; ?>">
                                    <?php echo form_error('dob'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Aadhar Card NO.*</label>
                                    <input class="ims_form_control" type="text" name="aadhar_no" id="aadhar_no"
                                           placeholder="Aadhar Card NO."
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->aadhar_number : ''; ?>">
                                    <?php echo form_error('aadhar_no'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>

                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="ims_form_label">ITR Address</label>
                                    <textarea class="ims_form_control" name="address" id="address"
                                              placeholder="Address"><?php echo $address; ?></textarea>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Bank Account Details*</label>
                                    <input class="ims_form_control" type="text" name="bank_account_1"
                                           id="bank_account_1" placeholder="Account NO.">
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label"></label>
                                    <input class="ims_form_control" type="text" name="bank_account_2"
                                           id="bank_account_2" placeholder="Account NO.">
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label"></label>
                                    <input class="ims_form_control" type="text" name="bank_account_2"
                                           id="bank_account_2" placeholder="Account NO.">
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 income_tax_work1" style="display: none;">
        <div class="row">
            <div class="col-sm-12">
                <div class="box-form">
                    <h3 class="form-box-title pull-left" style="width: 95%">Source Of Income</h3>
                    <a href="javascript:void(0)" onclick="addMoreIncome();" style="" id="add_more_income"
                       class="add_more_btn pull-right mdl-js-button mdl-js-ripple-effect ripple-white"><img
                                src="<?php echo base_url() ?>assets/images/plus_bordered.svg"/></a>
                    <div class="theme-form">
                        <div class="row income_box" id="income_box_1">
                            <div class="col-sm-3 income-fields">
                                <div class="form-group">
                                    <label class="ims_form_label">Source</label>
                                    <select class="ims_form_control source_of_income" name="source_of_income[]"
                                            id="source_of_income_1">
                                        <option value="">Select Income</option>
                                        <option value="salary">Salary</option>
                                        <option value="HP">House Property</option>
                                        <option value="BI">Business Income</option>
                                        <option value="CG">Capital Gain</option>
                                        <option value="Other">Other Source</option>
                                        <option value="Agriculture">Agriculture</option>
                                    </select>

                                    <?php echo form_error('source_of_income'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <div class="col-sm-12 income_tax_work1" style="display: none;">
        <div class="row">
            <div class="col-sm-12">
                <div class="box-form">
                    <h3 class="form-box-title pull-left" style="width: 95%">Deduction</h3>
                    <!--<a href="javascript:void(0)" onclick="addMoreIncome();" style="" id="add_more_income" class="add_more_btn pull-right mdl-js-button mdl-js-ripple-effect ripple-white"><img src="<?php /*echo base_url() */ ?>assets/images/plus_bordered.svg"  /></a>-->
                    <div class="theme-form">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Insurance</label>
                                    <input class="ims_form_control" type="text" name="insurance" id="insurance"
                                           placeholder="Insurance">
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Rent</label>
                                    <input class="ims_form_control" type="text" name="rent" id="rent"
                                           placeholder="Rent">
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Fees</label>
                                    <input class="ims_form_control" type="text" name="fees" id="fees"
                                           placeholder="Fees">
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">House Loan Inst</label>
                                    <input class="ims_form_control" type="text" name="house_loan_inst"
                                           id="house_loan_inst" placeholder="House Loan Inst">
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Other</label>
                                    <input class="ims_form_control" type="text" name="other_1" id="other_1"
                                           placeholder="Other 1">
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label"></label>
                                    <input class="ims_form_control" type="text" name="other_2" id="other_2"
                                           placeholder="Other 2">
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>


<?php if ($type == '3'): ?>
    <div class="col-sm-12" id="gst_return" style="">
        <div class="row">
            <div class="col-sm-12">
                <div class="box-form">
                    <h3 class="form-box-title">GST Return Details</h3>
                    <div class="theme-form">
                        <div class="row">

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Name*</label>
                                    <input class="ims_form_control" type="text" name="client_name" id="client_name"
                                           placeholder="Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->first_name . ' ' . $clientRecord->middle_name . ' ' . $clientRecord->last_name : ''; ?>">
                                    <?php echo form_error('client_name'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Mobile No*</label>
                                    <input class="ims_form_control" type="text" name="mobile_number" id="mobile_number"
                                           placeholder="Mobile No"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->mobile : ''; ?>">
                                    <?php echo form_error('mobile_number'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">PAN NO.*</label>
                                    <input class="ims_form_control" type="text" name="pan_no" id="pan_no"
                                           placeholder="PAN NO"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->pan_no : ''; ?>">
                                    <?php echo form_error('pan_no'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <!--<div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">DOB*</label>
                                    <input class="ims_form_control date_icon sel_date" type="text" name="dob" id="dob" placeholder="DOB" value="<?php /*echo (isset($clientRecord->client_id)) ? date('d-M-Y', strtotime($clientRecord->dob)) :''; */ ?>">
                                    <?php /*echo form_error('dob'); */ ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>-->
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Aadhar Card NO.*</label>
                                    <input class="ims_form_control" type="text" name="aadhar_no" id="aadhar_no"
                                           placeholder="Aadhar Card NO."
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->aadhar_number : ''; ?>">
                                    <?php echo form_error('aadhar_no'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Firm name*</label>
                                    <input class="ims_form_control" type="text" name="firm_name" id="firm_name"
                                           placeholder="First Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->aadhar_number : ''; ?>">
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">GST NO.*</label>
                                    <input class="ims_form_control" type="text" name="gst_no" id="gst_no"
                                           placeholder="GST NO."
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->gst_no : ''; ?>">
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">GST Form*</label>
                                    <select name="gst_form" id="gst_form" class="ims_form_control">
                                        <option value="">Select Form</option>
                                        <option value="GSTR-1">GSTR-1</option>
                                        <option value="GSTR-2">GSTR-2</option>
                                        <option value="GSTR-3">GSTR-3</option>
                                        <option value="GSTR-3B">GSTR-3B</option>
                                        <option value="GSTR-4">GSTR-4</option>
                                        <option value="GSTR-5">GSTR-5</option>
                                        <option value="GSTR-5A">GSTR-5A</option>
                                        <option value="GSTR-6">GSTR-6</option>
                                    </select>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Month*</label>
                                    <select name="gst_month" id="gst_month" class="ims_form_control">
                                        <option value="">Select Month</option>
                                        <?php
                                        for ($i = 1; $i <= 12; ++$i) {
                                            $time = strtotime(date('Y-' . $i . '-01'));
                                            $value = date('m', $time);
                                            $label = date('F', $time);
                                            printf('<option value="%s">%s</option>', $value, $label);
                                        }
                                        ?>
                                    </select>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Taxable Turnover*</label>
                                    <input class="ims_form_control" type="text" name="taxable_turnover"
                                           id="taxable_turnover" placeholder="Taxable Turnover">
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Exempted Turnover*</label>
                                    <input class="ims_form_control" type="text" name="exempted_turnover"
                                           id="exempted_turnover" placeholder="Exempted Turnover">
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Non GST Turnover*</label>
                                    <input class="ims_form_control" type="text" name="non_gst_turnover"
                                           id="non_gst_turnover" placeholder="Non GST Turnover">
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Tax*</label>
                                    <input class="ims_form_control" type="text" name="tax" id="tax" placeholder="Tax">
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Late Fees</label>
                                    <input class="ims_form_control" type="text" name="late_fees" id="late_fees"
                                           placeholder="Late Fees">
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>

<?php /*GST REG*/ if ($type == '4'): ?>
    <div class="col-sm-12" id="gst_reg_work" style="">
        <div class="row">
            <div class="col-sm-12">
                <div class="box-form">
                    <h3 class="form-box-title">Applicant information</h3>
                    <div class="theme-form">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Legal Business Name(As mentioned in PAN)*</label>
                                    <input type="text" name="first_name" class="ims_form_control"
                                           maxlength="50" id="business_name" placeholder="Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->first_name.' '.$clientRecord->middle_name.' '.$clientRecord->last_name : "" ?>"/>
                                    <?php echo form_error('business_name'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">PAN NO.*</label>
                                    <input type="text" name="pan_no" class="ims_form_control"
                                           maxlength="50" id="pan_no" placeholder="PAN NO."
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->pan_no : "" ?>"/>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Aadhar Card NO.*</label>
                                    <input class="ims_form_control" type="text" name="aadhar_no" id="aadhar_no"
                                           placeholder="Aadhar Card NO."
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->aadhar_number : ''; ?>">
                                    <?php echo form_error('aadhar_no'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Mobile NO.*</label>
                                    <input type="text" name="mobile_number" class="ims_form_control"
                                           maxlength="15" id="mobile_number" placeholder="Mobile NO."
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->mobile : "" ?>"/>
                                    <?php echo form_error('mobile_number'); ?>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="ims_form_label">Shop Address*</label>
                                    <textarea class="ims_form_control" name="address" id="address"
                                              placeholder="Address"><?php echo $address; ?></textarea>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($type == '5'): ?>
    <div class="col-sm-12" id="gumasta_work" style="">
        <div class="row">
            <div class="col-sm-12">
                <div class="box-form">
                    <h3 class="form-box-title">Applicant information</h3>
                    <div class="theme-form">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">First Name*</label>
                                    <input type="text" name="first_name" class="ims_form_control"
                                           maxlength="50" id="first_name" placeholder="First Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->first_name : "" ?>"/>
                                    <?php echo form_error('first_name'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Middle Name</label>
                                    <input type="text" name="middle_name" class="ims_form_control"
                                           maxlength="50" id="middle_name" placeholder="Middle Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->middle_name : "" ?>"/>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Last Name</label>
                                    <input type="text" name="last_name" class="ims_form_control"
                                           maxlength="50" id="last_name" placeholder="Last Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->last_name : "" ?>"/>
                                    <?php echo form_error('last_name'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>

                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Aadhar Card NO.*</label>
                                    <input class="ims_form_control" type="text" name="aadhar_no" id="aadhar_no"
                                           placeholder="Aadhar Card NO."
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->aadhar_number : ''; ?>">
                                    <?php echo form_error('aadhar_no'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Voter Id.</label>
                                    <input class="ims_form_control" type="text" name="voter_id" id="voter_id"
                                           placeholder="Voter Id."
                                           value="">
                                    <?php echo form_error('aadhar_no'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Mobile NO.*</label>
                                    <input type="text" name="mobile_number" class="ims_form_control"
                                           maxlength="15" id="mobile_number" placeholder="Mobile NO."
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->mobile : "" ?>"/>
                                    <?php echo form_error('mobile_number'); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Address</label>
                                    <textarea class="ims_form_control" name="address" id="address"
                                              placeholder="Address"><?php echo $address; ?></textarea>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($type == '7'): ?>
    <div class="col-sm-12" id="firm_reg_work" style="">
        <div class="row">
            <div class="col-sm-12">
                <div class="box-form">
                    <h3 class="form-box-title">Firm information</h3>
                    <div class="theme-form">
                        <div class="row">
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">First Name*</label>
                                    <input type="text" name="first_name" class="ims_form_control"
                                           maxlength="50" id="first_name" placeholder="First Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->first_name : "" ?>"/>
                                    <?php echo form_error('first_name'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Middle Name</label>
                                    <input type="text" name="middle_name" class="ims_form_control"
                                           maxlength="50" id="middle_name" placeholder="Middle Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->middle_name : "" ?>"/>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Last Name</label>
                                    <input type="text" name="last_name" class="ims_form_control"
                                           maxlength="50" id="last_name" placeholder="Last Name"
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->last_name : "" ?>"/>
                                    <?php echo form_error('last_name'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">PAN NO.*</label>
                                    <input type="text" name="pan_no" class="ims_form_control"
                                           maxlength="50" id="pan_no" placeholder="PAN NO."
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->pan_no : "" ?>"/>

                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Aadhar Card NO.*</label>
                                    <input class="ims_form_control" type="text" name="aadhar_no" id="aadhar_no"
                                           placeholder="Aadhar Card NO."
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->aadhar_number : ''; ?>">
                                    <?php echo form_error('aadhar_no'); ?>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Mobile NO.*</label>
                                    <input type="text" name="mobile_number" class="ims_form_control"
                                           maxlength="15" id="mobile_number" placeholder="Mobile NO."
                                           value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->mobile : "" ?>"/>
                                    <?php echo form_error('mobile_number'); ?>
                                </div>
                            </div>
                            <div class="col-sm-4">
                                <div class="form-group">
                                    <label class="ims_form_label">Firm name.*</label>
                                    <input type="text" name="firm_name" class="ims_form_control"
                                           maxlength="15" id="firm_name" placeholder="Firm name"
                                           value=""/>
                                    <?php echo form_error('firm_name'); ?>
                                </div>
                            </div>
                            <div class="col-sm-8">
                                <div class="form-group">
                                    <label class="ims_form_label">Firm Address</label>
                                    <textarea class="ims_form_control" name="address" id="address"
                                              placeholder="Address"><?php echo $address; ?></textarea>
                                    <label class="error" style="display:none;">Required</label>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
<?php endif; ?>
<?php if ($type == 'Other'): ?>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Amount of income</label>
            <input class="ims_form_control" type="text" name="income_amount" id="income_amount"
                   placeholder="Amount of income">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Bank Inst.</label>
            <input class="ims_form_control" type="text" name="bank_inst" id="bank_inst" placeholder="Bank Inst.">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">FD</label>
            <input class="ims_form_control" type="text" name="fd" id="fd" placeholder="FD">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Agent Income</label>
            <input class="ims_form_control" type="text" name="agent_income" id="agent_income"
                   placeholder="Agent Income">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
<?php endif; ?>

<?php if ($type == 'Agriculture'): ?>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Amount of income</label>
            <input class="ims_form_control" type="text" name="income_amount" id="income_amount"
                   placeholder="Amount of income">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
    <div class="col-sm-3">
        <div class="form-group">
            <label class="ims_form_label">Land Acre</label>
            <input class="ims_form_control" type="text" name="land_acre" id="land_acre" placeholder="Land Acre">
            <label class="error" style="display:none;">Required</label>
        </div>
    </div>
<?php endif; ?>