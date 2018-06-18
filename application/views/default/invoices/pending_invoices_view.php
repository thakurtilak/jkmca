

<form action="" method="post" id="pending-invoice" name="pending-invoice" enctype="multipart/form-data">

<div class="view_order_info">
           <!--Request Invoice Details -->
    <!--<h3 class="form-box-title"> Invoice Request Details</h3>-->
        <ul class="order_view_detail">
        <li>
            <div class="order_info_block">
                <span class="ov_title">PO Number</span>
                <span class="ov_data"><?php echo $invoiceDetail->po_no; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title"> PO Detail</span>
                <span class="ov_data"><?php echo $invoiceDetail->po_dtl; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Net Invoice Amount</span>
                <span class="ov_data"><?php echo $invoiceDetail->currency_symbol." ".formatAmount($invoiceDetail->invoice_net_amount); ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Invoice Category</span>
                <span class="ov_data"><?php echo $invoiceDetail->category_name; ?></span>
            </div>
        </li>
        <li class="od_block">
            <div class="order_info_block">
                <span class="ov_title">Requested By</span>
                <span class="ov_data"><?php echo $invoiceDetail->requestorname; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Requestor Email Id</span>
                <span class="ov_data"><?php echo $invoiceDetail->email; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Client Name</span>
                <span class="ov_data"><?php echo $invoiceDetail->client_name; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Client Address</span>
                <span class="ov_data"><?php echo $invoiceDetail->address; ?></span>
            </div>
        </li>

        <?php if(isset($salesPerson)  && is_object($salesPerson)): ?>
            <div class="od_block title_sub">
                <h4>Sales Person Details</h4>
            </div>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Name</span>
                    <span class="ov_data"><?php echo $salesPerson->sales_person_name; ?></span>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Contact Number</span>
                    <span class="ov_data"><?php echo $salesPerson->sales_contact_no; ?></span>
                </div>
            </li>
            <li class="od_block">
                <div class="order_info_block">
                    <span class="ov_title">Email Id</span>
                    <span class="ov_data"><?php echo $salesPerson->sales_person_email; ?></span>
                </div>
            </li>
        <?php endif; ?>
        <?php if(isset($accountPerson)  && is_object($accountPerson)): ?>
            <div class="od_block title_sub">
                <h4>Account Person Details</h4>
            </div>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Name</span>
                    <span class="ov_data"><?php echo $accountPerson->account_person_name; ?></span>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Contact Number</span>
                    <span class="ov_data"><?php echo $accountPerson->account_contact_no; ?></span>
                </div>
            </li>
            <li class="od_block">
                <div class="order_info_block">
                    <span class="ov_title">Email Id</span>
                    <span class="ov_data"><?php echo $accountPerson->account_person_email; ?></span>
                </div>
            </li>
        <?php endif; ?>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Attached PO</span>
                <?php if(isset($invoiceAttachments) && !empty($invoiceAttachments)): ?>
                    <?php foreach($invoiceAttachments as $attachment):
                        $originalName = trim(strstr($attachment->attach_file_name, '_'), '_');
                        $fileNameArray = explode('_', $attachment->attach_file_name);
                        if(count($fileNameArray) > 1) {
                            if(!is_numeric(current($fileNameArray))) {
                                $originalName = $attachment->attach_file_name;
                            }
                        } else {
                            $originalName = $attachment->attach_file_name;
                        }
                        if($attachment->attach_type == 'opf') {
                            $attachmentType = "Order Processing Form";
                        } elseif($attachment->attach_type == 'ro') {
                            $attachmentType = "Release/Work Order";
                        }elseif($attachment->attach_type == 'agreement') {
                            $attachmentType = "Agreement";
                        }elseif($attachment->attach_type == 'eml') {
                            $attachmentType = "Email file";
                        }elseif($attachment->attach_type == 'client_report') {
                            $attachmentType = "Client Report";
                        }elseif($attachment->attach_type == 'wrk_smry') {
                            $attachmentType = "Work Summary";
                        } else {
                            $attachmentType = "Others";
                        }

                        ?>
                        <?php
                        $urls = explode('uploads',$attachment->attach_file_path);
                        $afterUploadString = rtrim(end($urls), '/\\');
                        $fileURl = "uploads".$afterUploadString."/".$attachment->attach_file_name;
                        ?>
                        <span class="ov_data"><a href="<?php echo base_url();?><?php echo $fileURl; ?>" title="<?php echo $originalName; ?>" target="_blank"><?php echo $originalName; ?></a> <strong>Type : </strong><?php echo $attachmentType; ?></span>
                    <?php endforeach; ?>
                <?php else: ?>
                    <span class="ov_data">No Attachment</span>
                <?php endif; ?>
            </div>
        </li>


        <li>
            <div class="order_info_block">
                <span class="ov_title">Requestor Comments</span>
                <span class="ov_data"></span>
            </div>
        </li>
    </ul>
                  <!--Invoice Approval -->

    <h3 class="form-box-title">Invoice Approval</h3>
    <ul class="order_view_detail">
        <li>
            <div class="order_info_block">
                <span class="ov_title">Comments</span>
                <textarea name="comments" rows="3" cols="100" id="comments" class="ims_form_control"></textarea>
                <div class="error alert alert-danger" id="error_msg" style="color:red;display: none"></div>
                <div class="succes alert alert-success" id="success_msg" style="color: #0b2e13;display: none"></div>

            </div>
        </li>
    </ul>
    <div class="modal-footer">

            <input type="button" id="accept" name="accept" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white" value="Accept" onClick="invoice_acceptance('accept',<?php echo $invoiceDetail->invoice_req_id; ?>);">
            <input type="button" id="reject" name="reject" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white" value="Reject" onClick="invoice_acceptance('reject',<?php echo $invoiceDetail->invoice_req_id; ?>);">

    </div>
   </div>
    </form>

                   <!-- Script Code -->

        <script>
            /*
             *  invoice_acceptance
             * @purpose - To Accept or Reject Invoice By Approver.
             * @Date - 23/02/2018
             * @author - NJ
             */
        function invoice_acceptance(approved_status, invoice_req_id) {
            $("#error_msg").html("");
            $("#success_msg").html("");
            $("#error_msg").hide();
            $("#success_msg").hide();
           var Id = invoice_req_id;
            var status = approved_status;
            var approval_comment = $('#comments').val();
            if (approval_comment != "") {

                $.ajax({
                    type: "POST",
                    url: BASEURL + "invoice/invoiceAcceptance",
                    data: {Id: Id, status: status, comment:approval_comment},
                    cache: false,
                    beforeSend: function() {
                        // setting a timeout
                        $('.loader-wrapper').show()
                    },
                    success: function (res) {
                        $('.loader-wrapper').hide();
                        var data = JSON.parse(res);
                        if(data.isSuccess == '1') {
                            $("#success_msg").show();
                            $("#success_msg").html(data.message);
                            if (typeof table !== 'undefined') {
                                table.draw();
                                setTimeout(function(){
                                    $('#ViewModal').modal('hide');
                                }, 2000);
                            } else {
                                setTimeout(function(){
                                    window.location.href=BASEURL+"dashboard";
                                }, 2000);
                            }
                        } else if(data.isError == '1') {
                            $("#error_msg").show();
                            $("#success_msg").hide();
                            $("#error_msg").html(data.message);
                        }
                    },
                    error: function (xhr, status, error) {
                        $('.loader-wrapper').hide();
                        var err = eval("(" + xhr.responseText + ")");
                        $("#error_msg").html(err.Message);
                    }
                });
            }
            else {
                $("#error_msg").show();
                $("#error_msg").html("Please enter Comment before Approve or Reject.");
            }
        }
        </script>

<!--pending_invoice_info -->






