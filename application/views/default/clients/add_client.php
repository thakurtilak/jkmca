<div class="content-wrapper">
    <div class="content_header">
        <h3><?php echo (isset($clientDetail)) ? "Edit Client" : "Add Client" ?></h3>
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

        <form name="mp_add_client_frm" enctype="multipart/form-data" method="post" id="mp_add_client_frm" action="">
            <?php
            if (isset($clientDetail) && !empty($clientDetail)) :
                ?>
                <input type="hidden" id="client_id" name="client_id" value="<?php echo $clientDetail->client_id; ?>"/>
            <?php endif; ?>
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box-form">
                                <h3 class="form-box-title">Client Info</h3>
                                <div class="theme-form">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">First Name*</label>
                                                <input type="text" name="first_name" class="ims_form_control"
                                                       maxlength="50" id="first_name" placeholder="First Name"
                                                       value="<?php echo (isset($clientDetail)) ? $clientDetail->first_name : "" ?>"/>
                                                <?php echo form_error('first_name'); ?>
                                                <label class="error" style="display:none;">Required</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">Middle Name</label>
                                                <input type="text" name="middle_name" class="ims_form_control"
                                                       maxlength="50" id="middle_name" placeholder="Middle Name"
                                                       value="<?php echo (isset($clientDetail)) ? $clientDetail->middle_name : "" ?>"/>

                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">Last Name</label>
                                                <input type="text" name="last_name" class="ims_form_control"
                                                       maxlength="50" id="last_name" placeholder="Last Name"
                                                       value="<?php echo (isset($clientDetail)) ? $clientDetail->last_name : "" ?>"/>
                                                <?php echo form_error('last_name'); ?>
                                                <label class="error" style="display:none;">Required</label>
                                            </div>
                                        </div>
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
                                <h3 class="form-box-title">Father's Info</h3>
                                <div class="theme-form">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">First Name</label>
                                                <input type="text" name="father_first_name" class="ims_form_control"
                                                       maxlength="50" id="father_first_name" placeholder="First Name"
                                                       value="<?php echo (isset($clientDetail)) ? $clientDetail->father_first_name : "" ?>"/>
                                                <?php echo form_error('father_first_name'); ?>
                                                <label class="error" style="display:none;">Required</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">Middle Name</label>
                                                <input type="text" name="father_middle_name" class="ims_form_control"
                                                       maxlength="50" id="father_middle_name"
                                                       placeholder="Middle Name"
                                                       value="<?php echo (isset($clientDetail)) ? $clientDetail->father_middle_name : "" ?>"/>

                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">Last Name</label>
                                                <input type="text" name="father_last_name" class="ims_form_control"
                                                       maxlength="50" id="father_last_name" placeholder="Last Name"
                                                       value="<?php echo (isset($clientDetail)) ? $clientDetail->father_last_name : "" ?>"/>
                                                <?php echo form_error('father_last_name'); ?>
                                                <label class="error" style="display:none;">Required</label>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-6">
                            <div class="box-form">
                                <!--<h3 class="form-box-title">Client Info</h3>-->
                                <div class="theme-form">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="ims_form_label">Mobile NO.*</label>
                                                <input type="text" name="mobile_number" class="ims_form_control"
                                                       maxlength="15" id="mobile_number" placeholder="Mobile NO."
                                                       value="<?php echo (isset($clientDetail)) ? $clientDetail->mobile : "" ?>"/>
                                                <?php echo form_error('mobile_number'); ?>
                                            </div>

                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="ims_form_label">Email</label>
                                                <input type="text" name="email" class="ims_form_control" maxlength="150"
                                                       id="email" placeholder="Email"
                                                       value="<?php echo (isset($clientDetail)) ? $clientDetail->email : "" ?>"/>
                                            </div>
                                        </div>
                                    </div><!--row-->
                                </div><!--theme-form-->
                            </div><!--box-theme-->
                        </div><!--col-sm-12-->
                        <div class="col-sm-6">
                            <div class="box-form">
                                <!--<h3 class="form-box-title">Manager Detail</h3>-->
                                <div class="theme-form">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="ims_form_label">PAN NO.</label>
                                                <input maxlength="15" type="text" name="pan_no" class="ims_form_control"
                                                       id="pan_no" placeholder="PAN"
                                                       value="<?php echo (isset($clientDetail)) ? $clientDetail->pan_no : "" ?>"/>
                                                <?php echo form_error('pan_no'); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="ims_form_label">Aadhar NO.</label>
                                                <input maxlength="20" type="text" name="aadhar_no" id="aadhar_no"
                                                       class="ims_form_control" placeholder="Aadhar NO."
                                                       value="<?php echo (isset($clientDetail)) ? $clientDetail->aadhar_number : "" ?>"/>
                                                <?php echo form_error('aadhar_no'); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="ims_form_label">GSTIN NO.</label>
                                                <input maxlength="15" type="text" name="gst_no" class="ims_form_control"
                                                       id="gst_no" placeholder="GSTIN NO."
                                                       value="<?php echo (isset($clientDetail)) ? $clientDetail->gst_no : "" ?>"/>
                                                <?php echo form_error('gst_no'); ?>

                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="ims_form_label">Date Of Birth</label>
                                                <input maxlength="15" type="text" name="dob" id="dob"
                                                       class="ims_form_control date_icon sel_date" placeholder="DOB"
                                                       value="<?php echo (isset($clientDetail) && $clientDetail->dob) ? date('d-M-Y', strtotime($clientDetail->dob)) : "" ?>"/>
                                                <?php echo form_error('dob'); ?>
                                            </div>
                                        </div>

                                    </div><!--row-->
                                </div><!--theme-form-->
                            </div><!--box-theme-->
                        </div><!--col-sm-6-->
                        <div class="col-sm-12">
                            <div class="box-form client_adress">
                                <h3 class="form-box-title">Address Details</h3>
                                <div class="theme-form">
                                    <div class="row">
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="ims_form_label">Address Line 1*</label>
                                                <input maxlength="255" type="text" name="address1"
                                                       class="ims_form_control" id="address1"
                                                       placeholder="Address line 1"
                                                       value="<?php echo (isset($clientDetail)) ? $clientDetail->address1 : "" ?>"/>
                                                <?php echo form_error('address1'); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="ims_form_label">Address Line 2</label>
                                                <input maxlength="255" type="text" name="address2" id="address2"
                                                       class="ims_form_control" placeholder="Address line 2"
                                                       value="<?php echo (isset($clientDetail)) ? $clientDetail->address2 : "" ?>"/>
                                            </div>
                                        </div>
                                        <div class="clearfix"></div>
                                        <div class="col-sm-4">
                                            <div class="row1" id="statediv">
                                                <div class="form-group">
                                                    <label class="ims_form_label">State*</label>
                                                    <select class="ims_form_control" name="state" id="state">
                                                        <option value="">Select State</option>
                                                        <?php foreach ($state as $rows) { ?>
                                                            <option <?php echo (isset($clientDetail) && $clientDetail->state == $rows->id) ? "selected" : '14'; ?>
                                                                    value="<?php echo $rows->id ?>"><?php echo ucfirst($rows->state_name) ?></option>
                                                        <?php } ?>
                                                    </select>
                                                    <?php echo form_error('state'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">City*</label>
                                                <input maxlength="50" type="text" name="city" class="ims_form_control"
                                                       id="city" placeholder="City"
                                                       value="<?php echo (isset($clientDetail)) ? $clientDetail->city : "" ?>"/>
                                                <?php echo form_error('city'); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">Zip Code*</label>
                                                <input maxlength="6" type="text" name="zip_code"
                                                       class="ims_form_control" id="zip_code" placeholder="Zip Code"
                                                       value="<?php echo (isset($clientDetail)) ? $clientDetail->zip_code : "" ?>"/>
                                                <?php echo form_error('zip_code'); ?>
                                            </div>
                                        </div>
                                    </div><!--row-->
                                </div><!--theme-form-->
                            </div><!--col-sm-6-->
                        </div>
                        <?php if (isset($clientDocuments) && count($clientDocuments)): ?>
                            <div class="col-sm-12">
                                <div class="box-form client_adress">
                                    <h3 class="form-box-title">Client Documents</h3>
                                    <div class="theme-form">
                                        <div class="row">
                                            <div class="col-sm-12">
                                                <div class="ims_datatable table-responsive"
                                                     style="background: #FFFFFF;">
                                                    <!-- <h3 class="form-box-title">Client Details </h3>-->
                                                    <table id="clientList"
                                                           class="table table-striped table-bordered table-condensed table-hover"
                                                           cellspacing="0" width="100%">
                                                        <thead>
                                                        <tr>
                                                            <th width="40%">Document Name</th>
                                                            <th>Attached File</th>
                                                            <th>Action</th>
                                                        </tr>
                                                        </thead>
                                                        <tbody>
                                                        <?php
                                                        if (count($clientDocuments)):
                                                            foreach ($clientDocuments as $doc): ?>
                                                                <tr>
                                                                    <td><?php echo ($doc->attach_type != 0) ? $doc->documentName : $doc->other_file_name; ?></td>
                                                                    <td><span class="ov_data"><a
                                                                                    href="<?php echo base_url(); ?><?php echo $doc->attach_file_path; ?>"
                                                                                    title="<?php echo $doc->attach_file_name; ?>"
                                                                                    target="_blank"><?php echo $doc->attach_file_name; ?></a></span>
                                                                    </td>
                                                                    <?php
                                                                    $removeLink = "<a class='mdl-js-button mdl-js-ripple-effect btn-view action-btn button-delete' href='#deleteFile' data-toggle='modal' data-target-id='" . $clientDetail->client_id . "/" . $doc->attach_id . "' title='Remove'><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></a>";
                                                                    ?>
                                                                    <td><?php echo $removeLink; ?></td>
                                                                </tr>
                                                            <?php endforeach;
                                                        else: ?>
                                                            <tr>
                                                                <td colspan="2">No Document found</td>
                                                            </tr>
                                                        <?php endif;
                                                        ?>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        <?php endif; ?>
                        <div class="col-sm-12">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="box-form client_adress">
                                        <h3 class="form-box-title pull-left" style="width: 95%">Upload Client
                                            Documents</h3>
                                        <a href="javascript:void(0)" onclick="addMoreAttachment()"
                                           class="pull-right add_more_btn mdl-js-button mdl-js-ripple-effect ripple-white add"><img
                                                    src="<?php echo base_url() ?>assets/images/plus_bordered.svg"/></a>
                                        <div class="theme-form job-documents-wrapper">
                                            <div class="row order_attachment_box" id="order_attachment_box_1">
                                                <div class="col-sm-6" id="job_doc_1">
                                                    <div class="form-group">
                                                        <label class="ims_form_label">Select Type</label>
                                                        <select name="add_job_doc[]" id="job_doc1"
                                                                class="ims_form_control attachtype">
                                                            <option value="">Select type</option>
                                                            <?php if ($documentTypes): ?>
                                                                <?php foreach ($documentTypes as $doc): ?>
                                                                    <option value="<?php echo $doc->id ?>"><?php echo $doc->name; ?></option>
                                                                <?php endforeach; ?>
                                                            <?php endif; ?>
                                                            <option value="0">Other</option>
                                                        </select>
                                                        <input placeholder="Document name" type="text"
                                                               name="add_job_other[]" class="ims_form_control"
                                                               style="display: none">
                                                    </div>
                                                </div>
                                                <div class="col-sm-6 attach_col attach" id="attachment_1">
                                                    <div class="form-group order-attachment-group">
                                                        <label class="ims_form_label">Document</label>
                                                        <div class="file-upload-wrapper" id="file-upload-wrapper_1">
                                                            <input type="file" name="add_document_name[]" id="document1"
                                                                   class="ims_form_control upload_icon custom-file-upload-hidden"
                                                                   placeholder="Name of Agreement" tabindex="-1"
                                                                   aria-invalid="false"
                                                                   style="position: absolute; left: -9999px;">
                                                            <input style="display: none" type="text"
                                                                   name="file-upload-input[]" id="file-upload-input_1"
                                                                   class="file-upload-input" placeholder="Attachment"
                                                                   readonly>
                                                            <span class="file-upload-span"></span>
                                                            <button type="button"
                                                                    class="file-upload-button file-upload-select"
                                                                    tabindex="-1">
                                                            </button>
                                                        </div>
                                                        <label style="width:88%;float: left"
                                                               id="file-upload-input_1-error" class="error"
                                                               for="file-upload-input_1" style="display: none;"></label>
                                                        <a href="javascript:void(0);"
                                                           class="delete_record delete_attachment" style="display:none"><img
                                                                    src="<?php echo base_url(); ?>assets/images/delete_icon.svg"/></a>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <div class="col-sm-12">
                            <div class="form-footer">
                                <input type="submit" id="submit" name="submit" onclick="submit"
                                       value="<?php echo (isset($clientDetail)) ? "Update" : "Create" ?>"
                                       class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white"/>
                                <a href="<?php echo base_url('clients'); ?>"><input name="reset" type="button"
                                                                                    class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white"
                                                                                    id="reset1" value="Cancel"/></a>
                            </div>
                        </div><!--col-sm-12-->
                    </div><!--row-->

                </div><!--col-sm-12-->
            </div><!--row-->
        </form>
    </div><!--content-wrapper-->
    <div class="modal fade" id="deleteFile" tabindex="-1" role="dialog" aria-labelledby="deleteFileLabel" aria-hidden="true">
        <div style="width: 350px;" class="modal-dialog cancel-order-modal zoomIn animated" role="document">
            <div class="modal-content">
                <div class="modal-header ims_modal_header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="deleteFileLabel">Client Document Delete Confirmation</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url(); ?>clients/delete-file" method="POST" name="deleteJobFileForm" id="deleteJobFileForm">
                        <div class="form-group">
                            <p>Are you sure want to delete this file ?</p>
                        </div>
                        <div class="form-footer1">
                            <button type="submit" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">YES</button>
                            <button class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" data-dismiss="modal">NO</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
    <script src="<?php echo base_url(); ?>assets/js/client.js"></script>
    <style>
        .indian-row {
            display: none;
        }
    </style>
