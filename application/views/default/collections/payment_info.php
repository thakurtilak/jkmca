<form action="" method="post" id="pending-invoice" name="pending-invoice" enctype="multipart/form-data">

    <div class="view_order_info">
        <!--Request Invoice Details -->
        <h3 class="form-box-title"> Invoice Request Details</h3>
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
                    <span class="ov_title">Requestor EmailId</span>
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
                    <h4>SalesPerson Details</h4>
                </div>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">SalesPerson Name</span>
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
                    <h4>AccountPerson Details</h4>
                </div>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">AccountPerson Name</span>
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
                    <span class="ov_data"><?php echo $invoiceDetail->invoice_originator_remarks; ?></span>
                </div>
            </li>
        </ul>
        <h3 class="form-box-title"> Invoice Details</h3>
        <ul class="order_view_detail">
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Invoice No</span>
                    <span class="ov_data"><?php echo $invoiceDetail->invoice_no; ?></span>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Invoice Date</span>
                    <span class="ov_data"><?php echo date ( 'd-M-Y', strtotime ($invoiceDetail->invoice_date)); ?></span>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Payment Due Date</span>
                    <span class="ov_data"><?php if(isset($invoiceDetail->payment_due_date) && strtotime($invoiceDetail->payment_due_date) > 0 ){ echo date ( 'd-M-Y', strtotime ($invoiceDetail->payment_due_date));}else{ echo "--";} ?></span>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Payment Net Amt.</span>
                    <span class="ov_data"><?php echo $invoiceDetail->currency_symbol." ".formatAmount($invoiceDetail->invoice_net_amount); ?></span>
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
                    <span class="ov_title">Generated By</span>
                    <span class="ov_data"><?php echo $invoiceDetail->generatedBy; ?></span>
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
                    <span class="ov_title">Category</span>
                    <span class="ov_data"><?php echo $invoiceDetail->category_name; ?></span>
                </div>
            </li>

            <li>
                <div class="order_info_block">
                    <span class="ov_title">Client Agreement</span>
                    <?php if(isset($clientAgreements) && !empty($clientAgreements)): ?>
                        <span class="ov_data attach_list">
                <?php foreach($clientAgreements as $agreement):
                    $originalName = trim(strstr($agreement->agreement_name, '_'), '_');

                    ?>
                    <a href="<?php echo base_url();?>uploads/client_agreements/<?php echo $agreement->client_id.'/'.$agreement->agreement_name; ?>" title="<?php echo $originalName; ?>" target="_blank"><?php echo $originalName; ?></a>
                <?php endforeach; ?>
                </span>
                    <?php else: ?>
                        <span class="ov_data">No Attachment</span>
                    <?php endif; ?>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Attached Invoice</span>
                    <?php if($invoiceDetail->invoice_acceptance_status=='Accept'): ?>
                        <?php if(isset($invoiceAttach) && !empty($invoiceAttach)):
                            ?>
                            <?php foreach($invoiceAttach as $attachment):
                            $originalName = trim(strstr($attachment->attach_file_name, '_'), '_');
                            ?>
                            <?php
                            $urls = explode('uploads',$attachment->attach_file_path);
                            $afterUploadString = rtrim(end($urls), '/\\');
                            $fileURl = "uploads".$afterUploadString."/".$attachment->attach_file_name;
                            ?>
                            <span class="ov_data"><a href="<?php echo base_url();?><?php echo $fileURl; ?>" title="<?php echo $originalName; ?>" target="_blank"><?php echo wordwrap($originalName,30, '<br />', true); ?></a></span>
                        <?php endforeach; ?>


                        <?php else: ?>
                            <span class="ov_data">No Attachment</span>
                        <?php endif; ?>
                    <?php endif; ?>
                </div>
            </li>

            <li class="od_block">
                <div class="order_info_block">
                    <span class="ov_title">Generated Invoice</span>
                    <?php $invoice= getGeneratedInvoiceName($invoiceDetail->invoice_no);

                    ?>
                    <span class="ov_data"><a href="<?php echo base_url();?><?php echo $invoiceDetail->invoice_path; ?>" target="_blank"><?php echo $invoice; ?></a></span>

                </div>
            </li>
            <li class="od_block">
                <div class="order_info_block">
                    <span class="ov_title">Comments</span>
                    <span class="ov_data"><?php $invoice_generator_comments = str_replace ( "\\r\\", "", trim ( $invoiceDetail->invoice_generator_comments ) );
                        $invoice_generator_comments = str_replace ( "\\n", "--", $invoice_generator_comments );
                        $invoice_generator_comments = str_replace ( "\--", "<br>", $invoice_generator_comments );
                        echo wordwrap ( $invoice_generator_comments, 70, "<br>" ); ?></span>
                </div>
            </li>
            <li class="od_block">
                <div class="order_info_block">
                    <span class="ov_title">Approval Comments</span>
                    <span class="ov_data"><?php echo wordwrap ( $invoiceDetail->gen_approval_comment, 50, "<br>" ); ?></span>
                </div>
            </li>
        </ul>

        <h3 class="form-box-title">Payment Details</h3>
       <?php if($invoiceDetail->gen_approval_status !="Accept") { ?>
           <td>
               <h5 class="ov_title" style="color: red">Request Invoice is Pending !!</h5>
           </td>
       <?php } else { ?>
        <ul class="order_view_detail">
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Payment Recieved</span>
                    <td><input name="pymt_recieved" type="radio" id="pymt_recieved" value="Y" checked="checked" disabled="disabled"/>Yes&nbsp;
                        <input name="pymt_recieved" type="radio" id="pymt_recieved" value="N" disabled="disabled"/>No</td>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Payment Type</span>
                    <td><input name="pymt_type" type="radio" id="pymt_type" value="F" checked="checked" disabled="disabled"/>Full&nbsp;<input type="radio" name="pymt_type" id="pymt_type" value="P" disabled="disabled"/>Part</td>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Gross Invoice Amount</span>
                    <span class="ov_data"><?php echo $invoiceDetail->currency_symbol." ".formatAmount($invoiceDetail->invoice_gross_amount); ?></span>
                </div>
            </li>

            <?php if($pymtdtl->payment_recieved_flag !="Y") {?>
                <td>
               <h5 class="ov_title" style="color: red">Payment is not Received.</h5>
           </td>
            <?php }else{?>

                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Amount Recieved</span>
                          <span class="ov_data"><?php echo $invoiceDetail->currency_symbol." ".formatAmount($pymtdtl->invoice_collection_amount); ?></span>
                    </div>
                    <span class="error" id="msg" style="color:red"></span>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Date of Payment</span>
                       <span class="ov_data"> <?php echo date ( 'd-M-Y', strtotime ($pymtdtl->payment_recieved_date)); ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Payment Mode</span>
                        <span class="ov_data">
                            <?php
                            if($pymtdtl->payment_mode =='check') {
                                echo strtoupper('Cheque');
                            } else{
                                echo strtoupper($pymtdtl->payment_mode);
                            }
                            ?>
                        </span>
						<div class="chk_info">
                        <span id="trans_mode">
                        <?php
                        $trans_id = '--';
                        if($pymtdtl->payment_mode=="cash")
                            $trans_id="By Cash.";
                        else if($pymtdtl->payment_mode=="check")
                            $trans_id="Cheque No.";
                        else if($pymtdtl->payment_mode=="draft")
                            $trans_id="Draft No.";
                        else if($pymtdtl->payment_mode=="wire")
                            $trans_id="Payment Id.";

                        echo $trans_id;
                        ?>
                            </span>
                       <span class="">- <?php echo $pymtdtl->transaction_no; ?></span>
						</div>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Amount Balance</span>
                        <span class="ov_data"><?php echo $invoiceDetail->currency_symbol." ".formatAmount($invoiceDetail->invoice_gross_amount); ?></span>

                    </div>
                </li>

                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Collectors Remark on Payment</span>
                        <span class="ov_data"><?php echo $pymtdtl->payment_recieved_remarks; ?></span>
                    </div>
                </li>

            <?php } ?>


       <?php } ?>

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

</script>

<!--pending_invoice_info -->






