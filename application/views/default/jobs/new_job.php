<div class="content-wrapper">
    <div class="content_header">
        <h3><?php echo "Job Card" ?></h3>
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

        <form name="jobCards" enctype="multipart/form-data" method="post" id="jobCards" action="">
            <div class="row">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box-form">
                                <h3 class="form-box-title pull-left" style="width: 80%">Search Client</h3>
                                <?php if (in_array(SUPERADMINROLEID, $rolesIDArray) || in_array(RECIEPTIONISTROLEID, $rolesIDArray)): ?>
                                    <div class="add_new_btn text-right">
                                        <a href="<?php echo base_url(); ?>clients/add-client" class="mdl-js-button mdl-js-ripple-effect btn-event" data-upgraded=",MaterialButton,MaterialRipple">Add Client</a>
                                    </div>
                                <?php endif; ?>
                                <div class="theme-form">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <!--<label class="ims_form_label">Search Client</label>-->
                                                <input type="text" name="client_search" class="ims_form_control"
                                                       maxlength="25" id="client_search" placeholder="Search" value=""/>

                                            </div>
                                        </div>
                                    </div>
                                    <div class="row" id="clientListTable"></div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box-form">
                                <h3 class="form-box-title">Client Info</h3>
                                <div class="theme-form">
                                    <div class="row">
                                        <!--<div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="ims_form_label">Client*</label>
                                                <select class="ims_form_control" name="client" id="client">
                                                    <option value="">Select client</option>
                                                    <?php /*if($clients) :
                                                        foreach ($clients as $client):
                                                        */?>
                                                        <option value="<?php /*echo $client->client_id; */?>"><?php /*echo $client->name; */?></option>
                                                    <?php /*endforeach; endif; */?>
                                                </select>
                                                <?php /*echo form_error('first_name'); */?>
                                                <label class="error" style="display:none;">Required</label>
                                            </div>
                                        </div>-->
                                        <div class="col-sm-6">
                                            <div class="form-group">
                                                <label class="ims_form_label">Client Code</label>
                                                <input type="text" name="client_code" class="ims_form_control"
                                                       maxlength="12" id="client_code" placeholder="Client Code" value="" readonly="readonly"/>

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
                                <h3 class="form-box-title">Job Card Details</h3>
                                <div class="theme-form">
                                    <div class="row">
                                        <div class="col-sm-6">
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
                                        <div class="col-sm-6 income_tax_work">
                                            <div class="form-group">
                                                <label class="ims_form_label">Assessment Year *</label>
                                                <select class="ims_form_control" name="assessment_year" id="assessment_year">
                                                    <?php
                                                    $year = date("Y") - 4; for ($i = 0; $i <= 3; $i++) {$year++; echo "<option value='$year-".($year+1)."'>$year-".($year+1)."</option>";}
                                                    ?>
                                                </select>
                                                <?php echo form_error('assessment_year'); ?>
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
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box-form client_adress">
                                <h3 class="form-box-title">Job Card</h3>
                                <div class="theme-form">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="ims_form_label">Job Card Upload</label>
                                                <div class="custom-file-upload">
                                                    <!--<input type="hidden" name="agreement_file[]" id="agreement_file_1"
                                                           value="">-->
                                                    <div class="file-upload-wrapper">
                                                        <input type="file" name="job_card" id="job_card"
                                                               class="ims_form_control upload_icon custom-file-upload-hidden valid"
                                                               placeholder="Job Card Upload*" tabindex="-1"
                                                               aria-invalid="false"
                                                               style="position: absolute; left: -9999px;">
                                                        <input type="text" name="file-upload-input"
                                                               class="file-upload-input" placeholder="Job Card Upload"
                                                               readonly>
                                                        <button type="button"
                                                                class="file-upload-button file-upload-select"
                                                                tabindex="-1">

                                                        </button>
                                                    </div>
                                                    <label id="file-upload-input-error" class="error"
                                                           for="file-upload-input" style="display: none;"></label>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div id="clientDocumentSec"></div>
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box-form client_adress">
                                <h3 class="form-box-title pull-left" style="width: 95%">Upload Documents</h3>
                                <a href="javascript:void(0)" onclick="addMoreAttachment()"  class="pull-right add_more_btn mdl-js-button mdl-js-ripple-effect ripple-white add"><img src="<?php echo base_url() ?>assets/images/plus_bordered.svg"  /></a>
                                <div class="theme-form job-documents-wrapper">
                                    <div class="row order_attachment_box" id="order_attachment_box_1">
                                        <div class="col-sm-6" id="job_doc_1">
                                            <div class="form-group">
                                                <label class="ims_form_label">Select Type</label>
                                                <select name="add_job_doc[]" id="job_doc1" class="ims_form_control attachtype">
                                                    <option value="">Select type</option>
                                                    <?php if($documentTypes): ?>
                                                        <?php foreach($documentTypes as $doc): ?>
                                                            <option value="<?php echo $doc->id ?>"><?php echo $doc->name; ?></option>
                                                        <?php endforeach; ?>
                                                    <?php endif; ?>
                                                    <option value="0">Other</option>
                                                </select>
                                                <input placeholder="Document name" type="text" name="add_job_other[]" class="ims_form_control" style="display: none">
                                            </div>
                                        </div>
                                        <div class="col-sm-6 attach_col attach" id="attachment_1">
                                            <div class="form-group order-attachment-group">
                                                <label class="ims_form_label">Document</label>
                                                <div class="file-upload-wrapper" id="file-upload-wrapper_1">
                                                    <input type="file" name="add_document_name[]" id="document1" class="ims_form_control upload_icon custom-file-upload-hidden1" placeholder="Name of Agreement" tabindex="-1" aria-invalid="false" style="position: absolute; left: -9999px;">
                                                    <input style="display: none" type="text" name="file-upload-input[]" id="file-upload-input_1" class="file-upload-input" placeholder="Attachment" readonly>
                                                    <span class="file-upload-span"></span>
                                                    <button type="button" class="file-upload-button file-upload-select" tabindex="-1">
                                                    </button>
                                                </div>
                                                <label style="width:88%;float: left" id="file-upload-input_1-error" class="error" for="file-upload-input_1" style="display: none;"></label>
                                                <a href="javascript:void(0);" class="delete_record delete_attachment" style="display:none"><img src="<?php echo base_url();?>assets/images/delete_icon.svg" /></a>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <!--<div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box-form client_adress">
                                <h3 class="form-box-title">Document Required</h3>
                                <div class="theme-form">
                                    <div class="row">
                                        <?php if($documentTypes): ?>
                                            <?php foreach($documentTypes as $doc): ?>
                                                <div class="col-sm-3">
                                                    <div class="form-group">
                                                        <div class="checkbox checkbox-inline">
                                                            <input type="checkbox" name="documents[]"
                                                                   id="documents_<?php echo $doc->id ?>"
                                                                   value="<?php echo $doc->id ?>">
                                                            <label class="ims_form_label" for="documents_<?php echo $doc->id ?>"> <?php echo $doc->name; ?></label>
                                                        </div>
                                                    </div>
                                                </div>
                                             <?php endforeach; ?>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>-->

                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box-form client_adress">
                                <!--<h3 class="form-box-title">Address Details</h3>-->
                                <div class="theme-form">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">Fee*</label>
                                                <input style="width:90%;" maxlength="10" type="text" name="price"
                                                       class="ims_form_control" id="price"
                                                       placeholder="Fee" value="" readonly/>
                                                <label style="display: none;width: 90%;float: left;" id="price-error" class="error" for="price"></label>
                                                <a id="editPrice" style="vertical-align:bottom;" href="javascript:void(0);"><i class='icon-edit'></i></a>
                                                <?php echo form_error('price'); ?>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">Discount ( if any )</label>
                                                <input maxlength="10" type="text" name="discount_price"
                                                       class="ims_form_control" id="discount_price"
                                                       placeholder="Discount" value=""/>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">Advance Amount</label>
                                                <input maxlength="10" type="text" name="advance_price"
                                                       class="ims_form_control" id="advance_price"
                                                       placeholder="Advance" value=""/>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">Remaining Amount</label>
                                                <input maxlength="10" type="text" name="remaining_amount"
                                                       class="ims_form_control" id="remaining_amount"
                                                       placeholder="Remaining" value="" readonly/>
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
                                        <div class="col-sm-4">
                                            <div class="row1" id="statediv">
                                                <div class="form-group">
                                                    <label class="ims_form_label">Expected Date of Completion*</label>
                                                    <input maxlength="15" type="text" name="completion_date"
                                                           class="ims_form_control date_icon sel_date" id="completion_date"
                                                           placeholder="Completion Date" value=""/>
                                                    <?php echo form_error('completion_date'); ?>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">Responsible For Payment</label>
                                                <select class="ims_form_control" name="payment_responsible" id="payment_responsible">
                                                    <option value="">Select Responsible</option>
                                                    <?php if($managers) :
                                                        foreach ($managers as $user):
                                                            ?>
                                                            <option value="<?php echo $user->client_id; ?>"><?php echo $user->clientName; ?></option>
                                                        <?php endforeach; endif; ?>
                                                </select>
                                                <label class="error" style="display:none;">Required</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label class="ims_form_label">Remark</label>
                                                <textarea class="ims_form_control" name="remark" id="remark"></textarea>
                                            </div>
                                        </div>
                                    </div><!--row-->
                                </div><!--theme-form-->
                            </div><!--col-sm-6-->
                        </div>
                        <div class="col-sm-12">
                            <div class="form-footer">
                                <input type="submit" id="submit" name="submit" onclick="submit" value="<?php echo (isset($clientDetail)) ? "Update":"Create" ?>"
                                       class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white"/>
                                <a href="<?php echo base_url('dashboard');?>"><input name="reset" type="button"
                                                                                   class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white"
                                                                                   id="reset1" value="Cancel"/></a>
                            </div>
                        </div><!--col-sm-12-->
                    </div><!--row-->

                </div><!--col-sm-12-->
            </div><!--row-->
        </form>
    </div><!--content-wrapper-->
    <script src="<?php echo base_url(); ?>assets/js/create-job.js"></script>
<style>
    .income_box {
        border-bottom: 1px solid lightgray;
        margin-top: 15px;
    }
</style>