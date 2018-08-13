<div class="content-wrapper">
    <div class="content_header">
        <h3><?php echo "Edit Job Card" ?></h3>
        <a href="<?php echo base_url('jobs'); ?>">
        <input name="Cancel" type="button" class="btn-theme btn-event pull-right ml10 mdl-js-button mdl-js-ripple-effect ripple-white" id="cancel" value="Exit">
        </a>
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
                <input type="hidden" name="job_id" id="job_id" value="<?php echo $jobDetail->id; ?>">
                <div class="col-sm-12">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="box-form">
                                <h3 class="form-box-title">Job Card Info</h3>
                                <div class="theme-form">
                                    <div class="row">
                                        <div class="col-sm-12">
                                        <ul class="order_view_detail">
                                            <li>
                                                <div class="order_info_block">
                                                    <span class="ov_title">Job ID</span>
                                                    <span class="ov_data"><?php echo $jobDetail->job_number; ?></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="order_info_block">
                                                    <span class="ov_title">Work Type</span>
                                                    <span class="ov_data"><?php echo $jobDetail->work; ?></span>
                                                </div>
                                            </li>
                                            <li>
                                                <div class="order_info_block">
                                                    <span class="ov_title">Created Date</span>
                                                    <span class="ov_data"><?php echo date('d-M-Y', strtotime($jobDetail->created_date)); ?></span>
                                                </div>
                                            </li>
                                        </ul>
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
                                <h3 class="form-box-title">Client Info</h3>
                                <div class="theme-form">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <ul class="order_view_detail">
                                                <li>
                                                    <div class="order_info_block">
                                                        <span class="ov_title">Client Name</span>
                                                        <span class="ov_data"><?php echo $jobDetail->clientName;                                       ?></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="order_info_block">
                                                        <span class="ov_title">Firm Name</span>
                                                        <span class="ov_data"><?php echo ($jobDetail->firm_name)? $jobDetail->firm_name: '--';                                       ?></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="order_info_block">
                                                        <span class="ov_title">Client Address</span>
                                                        <span class="ov_data"><?php echo $jobDetail->clientAddress; ?></span>
                                                    </div>
                                                </li>
                                                <li>
                                                    <div class="order_info_block">
                                                        <span class="ov_title">Client Mobile No.</span>
                                                        <span class="ov_data"><?php echo $jobDetail->clientContact; ?></span>
                                                    </div>
                                                </li>
                                            </ul>
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
                            <div class="box-form client_adress">
                                <h3 class="form-box-title">Job Card</h3>
                                <div class="theme-form">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <ul class="order_view_detail">
                                                <li>
                                                    <div class="order_info_block">
                                                        <span class="ov_title">Attached Job Card</span>
                                                        <?php if(isset($jobCard) && !empty($jobCard)): ?>
                                                            <?php
                                                            $fileURl = $jobCard->file_path;
                                                            ?>
                                                            <span class="ov_data"><a href="<?php echo base_url();?><?php echo $fileURl; ?>" title="<?php echo $jobCard->file_name; ?>" target="_blank"><?php echo $jobCard->file_name; ?></a></span>
                                                        <?php else: ?>
                                                            <span class="ov_data">No Attachment</span>
                                                        <?php endif; ?>
                                                    </div>
                                                </li>
                                            </ul>
                                        </div>
                                        <div class="col-sm-12">
                                            <div class="form-group">
                                                <label class="ims_form_label">Job Card Upload ( <span style="color: red;">Upload new job card will automatically replace old one </span> )</label>
                                                <div class="custom-file-upload">
                                                    <!--<input type="hidden" name="agreement_file[]" id="agreement_file_1"
                                                           value="">-->
                                                    <div class="file-upload-wrapper">
                                                        <input type="file" name="job_card" id="job_card"
                                                               class="ims_form_control upload_icon custom-file-upload-hidden valid"
                                                               placeholder="Job Card Upload*" tabindex="-1"
                                                               aria-invalid="false"
                                                               style="position: absolute; left: -9999px;">
                                                        <input type="text" name="file-upload-input1"
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
                    <div class="box-form">
                        <h3 class="form-box-title">Job Documents</h3>
                        <div class="ims_datatable table-responsive" style="background: #FFFFFF;">
                            <!-- <h3 class="form-box-title">Client Details </h3>-->
                            <table id="clientList" class="table table-striped table-bordered table-condensed table-hover" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th width="25%">Document Name</th>
                                    <th>Attached File</th>
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(count($jobDocuments)):
                                    foreach ($jobDocuments as $doc): ?>
                                        <tr>
                                            <td><?php echo ($doc->attach_type != 0) ? $doc->documentName : $doc->other_file_name; ?></td>
                                            <td><span class="ov_data"><a href="<?php echo base_url();?><?php echo $doc->attach_file_path; ?>" title="<?php echo $doc->attach_file_name; ?>" target="_blank"><?php echo $doc->attach_file_name; ?></a></span></td>
                                            <?php
                                            $removeLink = "<span class=\"ov_data\"><a class='mdl-js-button mdl-js-ripple-effect btn-view action-btn button-delete' href='#deleteFile' data-toggle='modal' data-target-id='" . $jobDetail->id."/".$doc->attach_id . "' title='Remove'><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></a></span>";
                                            ?>
                                            <td><?php echo $removeLink; ?></td>
                                        </tr>
                                    <?php   endforeach;
                                else: ?>
                                    <tr>
                                        <td colspan="3">No Document found</td>
                                    </tr>
                                <?php endif;
                                ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div><!--col-sm-12-->
                <div class="col-sm-12 pull-right">
                    <div class="col-sm-3 pull-right">
                        <a href="#DocumentViewModalEdit" data-toggle="modal" data-target-id="<?php echo $jobDetail->client_id."/".$jobDetail->id; ?>" class="pull-right mdl-js-button mdl-js-ripple-effect ripple-white">View Document History</a>
                    </div>
                </div>
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
                                                       placeholder="Fee" value="<?php echo $jobDetail->amount; ?>" readonly/>
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
                                                       placeholder="Discount" value="<?php echo $jobDetail->discount_price; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">Advance Amount</label>
                                                <input maxlength="10" type="text" name="advance_price"
                                                       class="ims_form_control" id="advance_price"
                                                       placeholder="Advance" value="<?php echo $jobDetail->advanced_amount; ?>"/>
                                            </div>
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="form-group">
                                                <label class="ims_form_label">Remaining Amount</label>
                                                <input maxlength="10" type="text" name="remaining_amount"
                                                       class="ims_form_control" id="remaining_amount"
                                                       placeholder="Remaining" value="<?php echo $jobDetail->remaining_amount; ?>" readonly/>
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
                                                            <option <?php echo ($user->id == $jobDetail->staff_id) ? 'selected=selected':''; ?> value="<?php echo $user->id; ?>"><?php echo $user->name; ?></option>
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
                                                           placeholder="Completion Date" value="<?php echo date('d-M-Y', strtotime($jobDetail->completion_date)); ?>"/>
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
                                                            <option <?php echo ($user->client_id == $jobDetail->payment_responsible) ?"selected='selected'":"";?> value="<?php echo $user->client_id; ?>"><?php echo $user->clientName; ?></option>
                                                        <?php endforeach; endif; ?>
                                                </select>
                                                <label class="error" style="display:none;">Required</label>
                                            </div>
                                        </div>
                                        <div class="col-sm-8">
                                            <div class="form-group">
                                                <label class="ims_form_label">Remark</label>
                                                <textarea class="ims_form_control" name="remark" id="remark"><?php echo $jobDetail->remark; ?></textarea>
                                            </div>
                                        </div>
                                    </div><!--row-->
                                </div><!--theme-form-->
                            </div><!--col-sm-6-->
                        </div>
                        <div class="col-sm-12">
                            <div class="form-footer">
                                <input type="submit" id="submit" name="submit" onclick="submit" value="<?php echo (isset($jobDetail)) ? "Update":"Create" ?>"
                                       class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white"/>
                                <a href="<?php echo base_url('/jobs');?>"><input name="reset" type="button"
                                                                                     class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white"
                                                                                     id="reset1" value="Cancel"/></a>
                            </div>
                        </div><!--col-sm-12-->
                    </div><!--row-->

                </div><!--col-sm-12-->
            </div><!--row-->
        </form>
    </div><!--content-wrapper-->
    <!-- Logout Modal-->
    <div class="modal fade" id="deleteFile" tabindex="-1" role="dialog" aria-labelledby="deleteFileLabel" aria-hidden="true">
        <div style="width: 350px;" class="modal-dialog cancel-order-modal zoomIn animated" role="document">
            <div class="modal-content">
                <div class="modal-header ims_modal_header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="deleteFileLabel">Job Document Delete Confirmation</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url(); ?>jobs/delete-job-docuemnt" method="POST" name="deleteJobFileForm" id="deleteJobFileForm">
                        <div class="form-group">
                            <p>Are you sure want to delete this job document?</p>
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

    <div id="DocumentViewModalEdit" class="modal">
        <div class="modal-dialog zoomIn animated">
            <div class="modal-content">
                <div class="modal-header ims_modal_header">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Document List</h4>
                </div>
                <div class="modal-body view-details custom_client_scroll">
                </div>
                <!--<div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                </div>-->
            </div>
        </div>
    </div>
    <script>
        $(document).ready(function () {
            /*Delete job file Model window*/
            $("#deleteFile").on("show.bs.modal", function(e) {
                var id = $(e.relatedTarget).data('target-id');
                var jobFileHref = BASEURL + "jobs/delete-job-document/"+id;
                $("#deleteJobFileForm").prop('action', jobFileHref);

            });

            /*Client View Model Window*/
            $("#DocumentViewModalEdit").on("show.bs.modal", function(e) {
                var modal = $(this);
                modal.find(".view-details").html("");
                var clientId = $(e.relatedTarget).data('target-id');
                if(clientId){
                    var viewUrl = BASEURL + "jobs/document-history/"+clientId;
                    $.ajax({
                        type: "GET",
                        url: viewUrl,
                        cache: false,
                        success: function (data) {
                            modal.find(".view-details").html(data);
                            $(".custom_client_scroll").mCustomScrollbar();
                        },
                        error: function(err) {
                            console.log(err);
                        }
                    });
                } else {
                    modal.find(".view-details").html("Please Select client");
                }

            });

            $("#DocumentViewModalEdit").on("hide.bs.modal", function() {
                $(".custom_client_scroll").mCustomScrollbar("destroy");
            });
        });
    </script>
    <script src="<?php echo base_url(); ?>assets/js/create-job.js"></script>
    <style>
        .income_box {
            border-bottom: 1px solid lightgray;
            margin-top: 15px;
        }
    </style>