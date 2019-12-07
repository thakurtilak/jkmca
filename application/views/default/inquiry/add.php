<div class="content-wrapper">
    <div class="content_header">
        <h3><?php echo "New Inquiry" ?></h3>
    </div>
    <div class="inner_bg content_box">
        <div class="row">
            <?php if ($this->session->flashdata('error') != '') { ?>
                <div class="alert alert-danger" style="margin-top:18px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <?php echo $this->session->flashdata('error'); ?>
                </div>
            <?php } ?>
            <?php if ($this->session->flashdata('success') != '') { ?>
                <div class="alert alert-success" style="margin-top:18px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>
        </div>

        <form name="tempJobCard" enctype="multipart/form-data" method="post" id="tempJobCard" action="">
            <div class="row">
                <div class="col-sm-12" id="PAN_work" style="">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box-form">
                                <h3 class="form-box-title">Applicant information</h3>
                                <div class="theme-form">
                                    <div class="row">
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
                                                <label class="ims_form_label">PAN No.*</label>
                                                <input maxlength="15" type="text" name="pan_no" id="pan_no"
                                                    class="ims_form_control" placeholder="PAN NO."
                                                    value=""/>
                                                <?php echo form_error('pan_no'); ?>
                                                <label class="error" style="display:none;">Required</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">Mobile NO.*</label>
                                                <input type="text" name="mobile_number" class="ims_form_control"
                                                    maxlength="15" id="mobile_number" placeholder="Mobile NO."
                                                    value=""/>
                                                <?php echo form_error('mobile_number'); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="ims_form_label">First Name*</label>
                                                <input type="text" name="first_name" class="ims_form_control"
                                                    maxlength="50" id="first_name" placeholder="First Name"
                                                    value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->first_name : "" ?>"/>
                                                <?php echo form_error('first_name'); ?>
                                                <label class="error" style="display:none;">Required</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="ims_form_label">Last Name</label>
                                                <input type="text" name="last_name" class="ims_form_control"
                                                    maxlength="50" id="last_name" placeholder="Last Name"
                                                    value="<?php echo (isset($clientRecord->client_id)) ? $clientRecord->last_name : "" ?>"/>
                                                <?php echo form_error('last_name'); ?>
                                                <label class="error" style="display:none;">Required</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="ims_form_label">Fathers's First Name*</label>
                                                <input type="text" name="father_first_name" class="ims_form_control"
                                                    maxlength="50" id="father_first_name" placeholder="Father First Name"
                                                    value=""/>
                                                <?php echo form_error('father_first_name'); ?>
                                                <label class="error" style="display:none;">Required</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="ims_form_label">Father's Last Name</label>
                                                <input type="text" name="father_last_name" class="ims_form_control"
                                                    maxlength="50" id="father_last_name" placeholder="Last Name"
                                                    value=""/>
                                                <?php echo form_error('father_last_name'); ?>
                                                <label class="error" style="display:none;">Required</label>
                                            </div>
                                        </div>
                                        <input type="hidden" name="client_id" id="client_id"/>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box-form">
                                <h3 class="form-box-title">Job Card Details</h3>
                                <div class="theme-form">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">Work Type*</label>
                                                <select class="ims_form_control" name="work_type" id="work_type">
                                                    <option value="">Select Work Type</option>
                                                    <?php if($workTypes) :
                                                        foreach ($workTypes as $wType):
                                                            ?>
                                                            <option value="<?php echo $wType->id; ?>"><?php echo $wType->work; ?></option>
                                                        <?php endforeach; endif; ?>
                                                </select>
                                                <?php echo form_error('work_type'); ?>
                                                <label class="error" style="display:none;">Required</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">Assign To *</label>
                                                <select class="ims_form_control" name="staff" id="staff">
                                                    <option value="">Select User</option>
                                                    <?php if($staff) :
                                                        foreach ($staff as $user):
                                                            ?>
                                                            <option value="<?php echo $user->id; ?>"><?php echo $user->name; ?></option>
                                                        <?php endforeach; endif; ?>
                                                </select>
                                                <?php echo form_error('staff'); ?>
                                                <label class="error" style="display:none;">Required</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="formFields"></div>
                <div class="col-sm-12">
                    <div class="form-footer">
                        <input type="submit" id="submit" name="submit" onclick="submit" value="<?php echo (isset($clientDetail)) ? "Update":"Create" ?>"
                                class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white"/>
                        <a href="<?php echo base_url('dashboard');?>">
                        <input name="reset" type="button" class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white"
                                                                            id="reset1" value="Cancel"/></a>
                    </div>
                </div><!--col-sm-12-->
            </div><!--row-->
        </form>
    </div><!--content-wrapper-->
    <script src="<?php echo base_url(); ?>assets/js/create-inquiry.js"></script>
<style>
    .income_box {
        border-bottom: 1px solid lightgray;
        margin-top: 15px;
    }
</style>