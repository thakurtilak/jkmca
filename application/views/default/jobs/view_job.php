<div class="content-wrapper">
    <div class="content_header">
        <h3 class="pull-left1" style="width: 85%">Job Detail</h3>
        <a href="<?php echo base_url('jobs'); ?>">
            <input name="Cancel" type="button" class="btn-theme btn-event pull-right ml10 mdl-js-button mdl-js-ripple-effect ripple-white" id="cancel" value="Exit">
        </a>
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
        <div id="msg"></div>
        <form action="<?php echo base_url();?>jobs/view_job/<?php echo $jobDetail->id; ?>" method="post" id="view-jobs-form" name="view-jobs-form" enctype="multipart/form-data">
            <div class="row">
                <input type="hidden" name="job_id" id="job_id" value="<?php echo $jobDetail->id; ?>">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $jobDetail->id; ?>">
                <div class="col-sm-12">
                    <div class="box-form">
                        <!--Request Invoice Details -->
                        <div style="width: 100%; display: inline-block">
                        <h3 class="form-box-title pull-left" style="width: 95%">Job Request Details</h3>
                        <a class="pull-right mdl-js-button mdl-js-ripple-effect btn-view action-btn button-print" href="javascript:void(0)" data-target-id="<?php echo $jobDetail->id ?>" title='Print'><i class="fa fa-print" aria-hidden="true"></i></a>
                        </div>
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

                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Amount</span>
                                    <span class="ov_data"><?php echo formatAmount($jobDetail->amount); ?></span>
                                </div>
                            </li>
                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Discount ( if any )</span>
                                    <span class="ov_data"><?php echo formatAmount($jobDetail->discount_price); ?></span>
                                </div>
                            </li>
                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Advanced Amount</span>
                                    <span class="ov_data"><?php echo formatAmount($jobDetail->advanced_amount); ?></span>
                                </div>
                            </li>
                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Remaining Amount</span>
                                    <span class="ov_data"><?php echo formatAmount($jobDetail->remaining_amount); ?></span>
                                </div>
                            </li>
                                <?php if($jobDetail->responsible): ?>
                                    <li style="background: #FFFE00; ">
                                        <div class="order_info_block">
                                            <span class="ov_title">Responsible For Payment</span>
                                            <span class="ov_data"><?php echo $jobDetail->responsible; ?></span>
                                        </div>
                                    </li>
                                <?php endif; ?>
                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Requested By</span>
                                    <span class="ov_data"><?php echo $jobDetail->requestorname; ?></span>
                                </div>
                            </li>
                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Assign TO</span>
                                    <span class="ov_data"><?php echo $staffName; ?></span>
                                </div>
                            </li>

                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Tentative Completion Date</span>
                                    <span class="ov_data"><?php echo date('d-M-Y', strtotime($jobDetail->completion_date)); ?></span>
                                </div>
                            </li>
                        </ul>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="box-form">
                        <h3 class="form-box-title">Client Details</h3>
                        <ul class="order_view_detail">
                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Client ID</span>
                                    <span class="ov_data"><?php echo $jobDetail->clientId;                                       ?></span>
                                </div>
                            </li>
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
                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Client Pan No.</span>
                                    <span class="ov_data"><?php echo $jobDetail->clientPan; ?></span>
                                </div>
                            </li>

                        </ul>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="box-form">
                        <h3 class="form-box-title">Job Card</h3>
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
                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Remark</span>
                                    <span class="ov_data"><?php echo $jobDetail->remark ?></span>
                                </div>
                            </li>
                        </ul>
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
                <div class="col-sm-12 pull-right">
                    <div class="col-sm-3 pull-right">
                        <a href="#DocumentViewModal" data-toggle="modal" data-target-id="<?php echo $jobDetail->client_id."/".$jobDetail->id; ?>" class="pull-right mdl-js-button mdl-js-ripple-effect ripple-white">View Document History</a>
                    </div>
                </div>
                <div class="col-sm-12">
                    <div class="box-form">
                        <h3 class="form-box-title">Job Documents</h3>
                        <div class="ims_datatable table-responsive" style="background: #FFFFFF;">
                            <!-- <h3 class="form-box-title">Client Details </h3>-->
                            <table id="clientList" class="table table-striped table-bordered table-condensed table-hover" cellspacing="0" width="100%">
                                <thead>
                                <tr>
                                    <th width="40%">Document Name</th>
                                    <th>Attached File</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php
                                if(count($jobDocuments)):
                                    foreach ($jobDocuments as $doc): ?>
                                        <tr>
                                            <td><?php echo ($doc->attach_type != 0) ? $doc->documentName : $doc->other_file_name; ?></td>
                                            <td><span class="ov_data"><a href="<?php echo base_url();?><?php echo $doc->attach_file_path; ?>" title="<?php echo $doc->attach_file_name; ?>" target="_blank"><?php echo $doc->attach_file_name; ?></a></span></td>
                                        </tr>
                                    <?php   endforeach;
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
                </div><!--col-sm-12-->

                <?php if(count($jobWorkFiles)): ?>
                    <div class="col-sm-12">
                        <div class="box-form">
                            <h3 class="form-box-title">Work File Documents</h3>
                            <div class="ims_datatable table-responsive" style="background: #FFFFFF;">
                                <!-- <h3 class="form-box-title">Client Details </h3>-->
                                <table id="clientList" class="table table-striped table-bordered table-condensed table-hover" cellspacing="0" width="100%">
                                    <thead>
                                    <tr>
                                        <th width="40%">Document Name</th>
                                        <th>Attached File</th>
                                        <?php if($jobDetail->status =='rejected'): ?>
                                            <th>Action</th>
                                        <?php endif; ?>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    <?php
                                    if(count($jobWorkFiles)):
                                        foreach ($jobWorkFiles as $doc): ?>
                                            <tr>
                                                <td><?php echo $doc->attach_type; ?></td>
                                                <td><span class="ov_data"><a href="<?php echo base_url();?><?php echo $doc->file_path; ?>" title="<?php echo $doc->file_name; ?>" target="_blank"><?php echo $doc->file_name; ?></a></span></td>
                                                <?php if($jobDetail->status =='rejected'):
                                                    $removeLink = "<a class='mdl-js-button mdl-js-ripple-effect btn-view action-btn button-delete' href='#deleteFile' data-toggle='modal' data-target-id='" . $jobDetail->id."/".$doc->id . "' title='Remove'><i class=\"fa fa-trash-o\" aria-hidden=\"true\"></i></a>";
                                                    ?>
                                                    <td><?php echo $removeLink; ?></td>
                                                <?php endif; ?>
                                            </tr>
                                        <?php   endforeach;
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
                    </div><!--col-sm-12-->
                <?php endif; ?>
                <?php if($jobDetail->staff_comment && 0): ?>
                    <div class="col-sm-12">
                        <div class="box-form">
                            <h3 class="form-box-title">Staff's Remark</h3>
                            <div class="theme-form">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <?php echo ($jobDetail->staff_comment) ? $jobDetail->staff_comment :'--'; ?>
                                        </div>
                                    </div><!--col-sm-12-->
                                </div><!--row-->
                            </div><!--theme-form-->
                        </div><!--box-form-->
                    </div><!--col-sm-12-->
                <?php endif; ?>

                <?php if(($isSuperAdmin || ($isStaff && $jobDetail->staff_id == getCurrentUsersId()) || ($isRecieptionist && $jobDetail->staff_id == getCurrentUsersId())) && ($jobDetail->status == 'pending' || $jobDetail->status == 'rejected')) : ?>
                    <div class="col-sm-12">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="box-form client_adress">
                                    <h3 class="form-box-title pull-left" style="width: 95%">Upload File Documents</h3>
                                    <a href="javascript:void(0)" onclick="addMoreAttachment()"  class="pull-right add_more_btn mdl-js-button mdl-js-ripple-effect ripple-white add"><img src="<?php echo base_url() ?>assets/images/plus_bordered.svg"  /></a>
                                    <div class="theme-form job-documents-wrapper">
                                        <div class="row order_attachment_box" id="order_attachment_box_1">
                                            <div class="col-sm-6" id="job_doc_1">
                                                <div class="form-group">
                                                    <label class="ims_form_label">File Type*</label>
                                                    <input name="add_job_doc[]" id="job_doc1" class="ims_form_control attachtype" />

                                                </div>
                                            </div>
                                            <div class="col-sm-6 attach_col attach" id="attachment_1">
                                                <div class="form-group order-attachment-group">
                                                    <label class="ims_form_label">Document*</label>
                                                    <div class="file-upload-wrapper" id="file-upload-wrapper_1">
                                                        <input type="file" name="add_document_name[]" id="document1" class="ims_form_control upload_icon custom-file-upload-hidden" placeholder="Name of Agreement" tabindex="-1" aria-invalid="false" style="position: absolute; left: -9999px;">
                                                        <input style="display: none" type="text" name="file-upload-input[]" id="file-upload-input_1" class="file-upload-input" placeholder="Attachment" readonly>
                                                        <span class="file-upload-span"></span>
                                                        <button type="button" class="file-upload-button file-upload-select" tabindex="-1">
                                                        </button>
                                                    </div>
                                                    <label id="file-upload-input_1-error" class="error" for="file-upload-input_1" style="display: none;width: 88%; float: left;"></label>
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
                        <div class="box-form">
                            <div class="theme-form">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="ims_form_label">Comment</label>
                                            <textarea class="ims_form_control" name="staff_comment" id="staff_comment" placeholder="Comment"><?php echo $jobDetail->staff_comment; ?></textarea>
                                        </div>
                                    </div><!--col-sm-12-->
                                </div><!--row-->
                            </div><!--theme-form-->
                        </div><!--box-form-->
                    </div><!--col-sm-12-->
                <?php endif; ?>
                <div class="col-sm-12">
                    <div class="box-form">
                        <h3 class="form-box-title">Job Status</h3>
                        <div class="theme-form">
                            <div class="row">
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <?php if($jobDetail->status =='approval_pending') {
                                            echo "<h4>Pending for Approval</h4>";
                                        } else {
                                            echo "<h4>".ucwords($jobDetail->status)."</h4>";
                                        } ?>
                                    </div>
                                </div><!--col-sm-12-->
                                <?php if($jobDetail->status =='rejected'): ?>
                                <div class="col-sm-12">
                                    <div class="form-group">
                                        <label class="ims_form_label">Comment</label>
                                        <p><?php echo  $jobDetail->reject_comment; ?></p>
                                    </div>
                                </div><!--col-sm-12-->
                                <?php elseif ($jobDetail->status =='completed'): ?>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="ims_form_label">Comment</label>
                                            <p><?php echo $jobDetail->approval_comment; ?></p>
                                        </div>
                                    </div><!--col-sm-12-->
                                <?php elseif ($jobDetail->status =='approval_pending'): ?>
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="ims_form_label">Comment</label>
                                            <p><?php echo $jobDetail->staff_comment; ?></p>
                                        </div>
                                    </div><!--col-sm-12-->
                                <?php endif; ?>
                            </div><!--row-->
                        </div><!--theme-form-->
                    </div><!--box-form-->
                </div><!--col-sm-12-->
                <?php if ($isSuperAdmin && $jobDetail->status == 'approval_pending'): ?>
                    <div class="col-sm-12">
                        <div class="box-form">
                            <div class="theme-form">
                                <div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
                                            <label class="ims_form_label">Comment</label>
                                            <textarea required class="ims_form_control" name="approval_comment" id="approval_comment" placeholder="Comment"></textarea>
                                        </div>
                                    </div><!--col-sm-12-->
                                </div><!--row-->
                            </div><!--theme-form-->
                        </div><!--box-form-->
                    </div><!--col-sm-12-->
                <?php endif; ?>
                <?php if (($isSuperAdmin && $jobDetail->status == 'completed') || ( $isRecieptionist && ($jobDetail->status == 'completed' || $jobDetail->status =="approval_pending"))): ?>
                    <div class="col-sm-12">
                        <div class="box-form">
                            <h3 class="form-box-title">Payment Status</h3>
                            <div class="theme-form">
                                <div class="row">
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="ims_form_label">Remaining Amount</label>
                                            <?php echo formatAmount($jobDetail->remaining_amount); ?>
                                        </div>
                                    </div><!--col-sm-6-->
                                    <div class="col-sm-4">
                                        <div class="form-group">
                                            <label class="ims_form_label">Is Payment Completed ?</label>
                                            <div class="radio radio-inline">
                                                <input type="radio" id="payment_status1" name="payment_status" value="YES" <?php echo ($jobDetail->remaining_amount <= 0) ? "checked=checked":"" ?> <?php echo ($jobDetail->remaining_amount <= 0) ? "disabled=true":"" ?> >
                                                <label for="payment_status1">YES</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <input type="radio" id="payment_status2" name="payment_status" value="NO" <?php echo ($jobDetail->remaining_amount > 0) ? "checked=checked":"" ?> <?php echo ($jobDetail->remaining_amount <= 0) ? "disabled=true":"" ?>>
                                                <label for="payment_status2">NO</label>
                                            </div>
                                        </div>
                                    </div><!--col-sm-6-->
                                    <?php if($jobDetail->remaining_amount > 0) : ?>
                                    <div class="col-sm-4" id="pay_amount_box">
                                        <div class="form-group">
                                            <label class="ims_form_label">Pay Amount*</label>
                                            <input class="ims_form_control" type="text" name="pay_amount" id="pay_amount" placeholder="Amount">
                                        </div>
                                    </div><!--col-sm-6-->
                                    <?php endif; ?>
                                </div><!--row-->
                            </div><!--theme-form-->
                        </div><!--box-form-->
                    </div><!--col-sm-12-->
                <?php endif; ?>
                <div class="col-sm-12">
                    <?php if($isSuperAdmin && $jobDetail->status =="approval_pending"){ ?>
                        <div class="form-footer">
                            <input type="submit" id="submit2" name="submit2" value="Approve" class="btn-theme ml10 btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">
                            <input type="submit" id="submit3" name="submit3" value="Reject" class="btn-theme btn-red ml10 mdl-js-button mdl-js-ripple-effect ripple-white">
                            <a href="<?php echo base_url('jobs'); ?>">
                            <input name="Cancel" type="button" class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" id="cancel" value="Cancel">
                            </a>
                        </div>
                    <?php } elseif (($jobDetail->status =="pending" || $jobDetail->status =="rejected") && ($isSuperAdmin || ($isRecieptionist && $jobDetail->staff_id == getCurrentUsersId()) || ($isStaff && $jobDetail->staff_id == getCurrentUsersId()))){ ?>
                        <div class="form-footer">
                            <input type="submit" id="submit1" name="submit1" value="Submit" class="btn-theme ml10 btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">
                            <a href="<?php echo base_url('jobs'); ?>">
                            <input name="Cancel" type="button" class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" id="cancel" value="Cancel">
                            </a>
                                <?php if($isSuperAdmin): ?>
                                <div class="pull-right">
                                    <a class='mdl-js-button btn-view button-delete' href='#deleteJobCard' data-toggle='modal' data-target-id='<?php echo $jobDetail->id; ?>' title='Remove'>
                                        <input name="remove" type="button" class="btn-theme btn-event ml10 mdl-js-button mdl-js-ripple-effect ripple-white" id="remove" value="Remove">
                                    </a>
                                </div>
                            <?php endif; ?>
                        </div>
                    <?php } elseif (($isSuperAdmin || $isRecieptionist ) && ($jobDetail->status =="completed" || $jobDetail->status =="approval_pending") && $jobDetail->remaining_amount > 0){ ?>
                        <div class="form-footer">
                            <input type="submit" id="submit4" name="submit4" value="Update Payment Status" class="btn-theme ml10 btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">
                            <a href="<?php echo base_url('jobs'); ?>">
                            <input name="Cancel" type="button" class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" id="cancel" value="Cancel">
                            </a>
                        </div>
                    <?php } ?>
                </div>
            </div><!--row-->
        </form>
    </div><!--inner_bg-->
    <div id="helpText" class="modal helpdiv">
        <div class="modal-dialog modal-md zoomIn animated">
            <div class="modal-content">
                <div class="modal-header btn-pink">
                    <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                    <h4 class="modal-title">Pending Payment Alert</h4>
                </div>
                <div class="modal-body custom_scroll bg-white">
                    <p>&#x20B9;<?php echo formatAmount($jobDetail->remaining_amount); ?> Payment is pending for this job.</p>
                </div><!--modal-body-->
            </div>
        </div>
    </div>

    <!-- Logout Modal-->
    <div class="modal fade" id="deleteFile" tabindex="-1" role="dialog" aria-labelledby="deleteFileLabel" aria-hidden="true">
        <div style="width: 350px;" class="modal-dialog cancel-order-modal zoomIn animated" role="document">
            <div class="modal-content">
                <div class="modal-header ims_modal_header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="deleteFileLabel">Job File Delete Confirmation</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url(); ?>jobs/delete-job-file" method="POST" name="deleteJobFileForm" id="deleteJobFileForm">
                        <div class="form-group">
                            <p>Are you sure want to delete this job file ?</p>
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
    <div class="modal fade" id="deleteJobCard" tabindex="-1" role="dialog" aria-labelledby="deleteJobCardLabel" aria-hidden="true">
        <div style="width: 350px;" class="modal-dialog cancel-order-modal zoomIn animated" role="document">
            <div class="modal-content">
                <div class="modal-header ims_modal_header">
                    <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                    <h4 class="modal-title" id="deleteJobCardLabel">Job Card Delete Confirmation</h4>
                </div>
                <div class="modal-body">
                    <form action="<?php echo base_url(); ?>jobs/delete-job-card" method="POST" name="deleteJobCardForm" id="deleteJobCardForm">
                        <div class="form-group">
                            <p>Are you sure want to delete this Job?</p>
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

    <div id="DocumentViewModal" class="modal">
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
        <?php if(($isSuperAdmin || $isRecieptionist ) && $jobDetail->status =="completed" && $jobDetail->remaining_amount > 0) :  ?>
        $("#helpText").modal('show');
        <?php endif;  ?>
        $attachmentCloneObje = $("#order_attachment_box_1").clone();
        $(document).on("click", ".button-print", function () {
            var id =  $(this).data("target-id");
            var viewUrl = BASEURL + "jobs/job-details/"+id;
            $.ajax({
                type: "GET",
                url: viewUrl,
                data:{type:'print'},
                cache: false,
                success: function (data) {
                    var printContents = data;
                    var originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });
        $(document).on('click', '.file-upload-button', function () {
            $(this).parent().find("input[type='file']").click();
        });

        $(document).on('change', '.custom-file-upload-hidden', function () {
            var fileID = $(this).attr('id');
            var filename = $("#" + fileID).val().split('\\').pop();
            $("#" + fileID).parent().find(".file-upload-input").val(filename);
            $("#" + fileID).parent().find(".file-upload-span").text(filename);
            $("#"+fileID).parent().find(".file-upload-input").blur();
        });

        /*Delete job file Model window*/
        $("#deleteFile").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('target-id');
            var jobFileHref = BASEURL + "jobs/delete-job-file/"+id;
            $("#deleteJobFileForm").prop('action', jobFileHref);

        });

        /*Delete job file Model window*/
        $("#deleteJobCard").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('target-id');
            var jobFileHref = BASEURL + "jobs/delete-job-card/"+id;
            $("#deleteJobCardForm").prop('action', jobFileHref);

        });

        /*Client View Model Window*/
        $("#DocumentViewModal").on("show.bs.modal", function(e) {
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

        $("#DocumentViewModal").on("hide.bs.modal", function() {
            $(".custom_client_scroll").mCustomScrollbar("destroy");
        });

        /*Client side validations*/
        $("#view-jobs-form").validate({
            ignore: ":hidden:not(.file-upload-input)",
            rules: {
                pay_amount: {required: true,number:true},
                'add_job_doc[]' : {required: true},
                'file-upload-input[]': {required: true,extension:"gif|jpg|png|jpeg|pdf|zip|docx|doc|xls|xlsx|eml|msg"}
            },
            messages: {
                pay_amount: {required: "This field is required", number:"The field should contain a numeric value"},
                'add_job_doc[]' : {required: "This field is required "},
                'file-upload-input[]': {required: "This field is required",extension:"Invalid file format"}
            }
        });
        /*Delete single invoice attachment record*/
        $(document).on("click", ".delete_attachment", function() {
            $deleteBox = $(this).parent().parent().parent();
            $deleteBox.remove();
        });
        function addMoreAttachment() {
            //$(".delete_attachment").show();
            //var nextIndex = $(".attachtype").length + 1;
            var LastEl = $(".order_attachment_box").last();
            var lastid = LastEl.attr("id");
            var LastIdParts = lastid.split("order_attachment_box_");
            var lenth = LastIdParts[1];
            var nextIndex = parseInt(lenth) + 1;
            $attachmentCloneObje.attr({id:"order_attachment_box_"+nextIndex});

            if($attachmentCloneObje.find("input[name^='job_doc[']").length > 0) {
                $attachmentCloneObje.find("input[name^='job_doc[']").attr({
                    name: "add_job_doc[]",
                    id: "job_doc" + nextIndex,
                    value: ""
                });
            } else {
                $attachmentCloneObje.find("input[name^='add_job_doc[']").attr({
                    name: "add_job_doc[]",
                    id: "job_doc" + nextIndex,
                    value: ""
                });
            }
            //var nextIndex = $(".file-upload-wrapper").length + 1;
            $attachmentCloneObje.find(".file-upload-wrapper").attr("id","file-upload-wrapper_"+nextIndex);

            if($attachmentCloneObje.find("input[name^='add_document_name[']").length > 0) {
                $attachmentCloneObje.find("input[name^='add_document_name[']").attr({id:"document"+nextIndex,value:""});
                $attachmentCloneObje.find("input[name^='add_document_name[']").attr({name:"add_document_name[]"});
            } else {
                $attachmentCloneObje.find("input[name^='add_document_name[']").attr({id:"document"+nextIndex,value:''});
                $attachmentCloneObje.find("input[name^='add_document_name[']").attr({name:"add_document_name[]"});
            }
            $attachmentCloneObje.find(".file-upload-span").html("");
            $attachmentCloneObje.find("input[name^='file-upload-input[']").attr({name:"file-upload-input[]" ,id:"file-upload-input_"+nextIndex, value:""});
            $attachmentCloneObje.find("label[for^=file-upload-input]").attr({id:"file-upload-input_"+nextIndex+"-error", for:"file-upload-input_"+nextIndex});

            //$attachmentCloneObje.find(".add_more_btn").attr("id", "add_more_btn_' + nextIndex);
            $attachmentCloneObje.find(".delete_record ").attr("id", "delete_record_" + nextIndex);

            //$attachmentCloneObje.find(".add_more_btn").hide();
            $attachmentCloneObje.find(".delete_attachment").show();

            $cloneHtml = $attachmentCloneObje.wrap("<div>").parent().html();
            //$(".add_more_attach_inv").parent().before($cloneHtml);
            $(".job-documents-wrapper").append($cloneHtml);
        }

        function round_decimals(original_number, decimals) {
            var result1 = original_number * Math.pow(10, decimals)
            var result2 = Math.round(result1)
            var result3 = result2 / Math.pow(10, decimals)
            return pad_with_zeros(result3, decimals)
        }

        function printConvertAmt() {
            var conver_amt = document.getElementById("conversion_rate").value;
            var amount = document.getElementById("grossamt").value;
            conver_amt1 = parseFloat(conver_amt);
            amount = parseFloat(amount);
            var convertamount = (conver_amt1 * amount);
            if (conver_amt == "")
                document.getElementById("convert_amount").innerHTML = '';
            else
                document.getElementById("convert_amount").innerHTML = 'Convert Amount&nbsp;&nbsp;' + numberFormat(convertamount);
        }

        function numberFormat(number) {
            //number = number.toFixed(2);
            return number.toLocaleString('en-IN', { minimumFractionDigits: 2, maximumFractionDigits:2 });
            /*return  number.toFixed(2).replace(/./g, function(c, i, a) {
             return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
             });*/
        }
    </script>