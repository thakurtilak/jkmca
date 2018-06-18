<div class="view_order_info">
    <!--Request Invoice Details -->
    <!-- <h3 class="form-box-title">Request Invoice Details</h3>-->
    <?php if (! empty ( $invoiceDetail->approval_user_id ) && empty ( $invoiceDetail->approval_status )) {?>
        <div class="alert alert-danger">
            Pending with HOD <?php echo(isset($approverName)) ? $approverName : ""; ?>
        </div>
    <?php } else if (! empty ( $invoiceDetail->approval_user_id) && $invoiceDetail->approval_status == 'reject') {?>
        <div class="alert alert-danger">
            Rejected by HOD <?php echo (isset($approverName)) ? $approverName : ""; ?>
        </div>
    <?php }else if($invoiceDetail->invoice_acceptance_status=='Pending'){?>
        <div class="alert alert-danger">
            Pending with Accounts
        </div>

    <?php }else if( ( $invoiceDetail->invoice_acceptance_status ) == "Accept" && ! empty ( $invoiceDetail->gen_approval_userid ) && $invoiceDetail->gen_approval_status == "") {?>
        <?php
        $genApprover = getUserInfo($invoiceDetail->gen_approval_userid);
        if($genApprover) {
            $by = "by ".$genApprover->first_name. " ". $genApprover->last_name;
        } else {
            $by = '';
        }
        ?>
        <div class="alert alert-danger">
            Pending with Accounts Head
        </div>
    <?php }else if($invoiceDetail->invoice_acceptance_status=='Reject'){ ?>
        <div class="alert alert-danger">
            Rejected <?php echo (isset($generatorName)) ? "by" : " "; ?> <?php echo (isset($generatorName)) ? $generatorName : ""; ?> !!
        </div>
    <?php } else { ?>
        <div class="alert alert-success">
            Invoiced
        </div>
    <?php } ?>
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

    <!--Invoice Details-->


    <!--<h3 class="form-box-title">Invoice Details</h3>-->
    <?php if (! empty ( $invoiceDetail->approval_user_id ) && empty ( $invoiceDetail->approval_status )) {?>
        <td>
            <h5 class="ov_title" style="color: red">Invoice is pending for approval by <?php echo(isset($approverName)) ? $approverName : ""; ?>!!</h5>
        </td>
    <?php } else if (! empty ( $invoiceDetail->approval_user_id) && $invoiceDetail->approval_status == 'reject') {?>
        <td>
            <h5 class="ov_title" style="color: red">Invoice is rejected by <?php echo (isset($approverName)) ? $approverName : ""; ?> !!</h5>
        </td>
        <ul class="order_view_detail">
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Rejection Comment</span>
                    <span class="ov_data"><?php echo $invoiceDetail->approval_comment; ?></span>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Rejection Date</span>
                    <span class="ov_data"> <?php echo date('d-M-Y', strtotime($invoiceDetail->invoice_generate_date)); ?></span>
                </div>
            </li>
        </ul>

    <?php }else if($invoiceDetail->invoice_acceptance_status=='Pending'){?>
        <td>
            <h5 class="ov_title" style="color: red">Invoice is pending at finance department for generate !!</h5>
        </td>

    <?php }else if( ( $invoiceDetail->invoice_acceptance_status ) == "Accept" && ! empty ( $invoiceDetail->gen_approval_userid ) && $invoiceDetail->gen_approval_status == "") {?>
        <?php
        $genApprover = getUserInfo($invoiceDetail->gen_approval_userid);
        if($genApprover) {
            $by = "by ".$genApprover->first_name. " ". $genApprover->last_name;
        } else {
            $by = '';
        }
        ?>
        <td>
            <h5 class="ov_title" style="color: red">Invoice is pending at finance department for approval <?php echo $by; ?></h5>
        </td>
    <?php }else if($invoiceDetail->invoice_acceptance_status=='Reject'){ ?>
        <td>
            <h5 class="ov_title" style="color: red">Invoice is rejected <?php echo (isset($generatorName)) ? "by" : " "; ?> <?php echo (isset($generatorName)) ? $generatorName : ""; ?> !!</h5>
        </td>
        <ul class="order_view_detail">
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Rejection Comment</span>
                    <span class="ov_data"><?php echo $invoiceDetail->invoice_generator_comments; ?></span>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Rejection Date</span>

                    <span class="ov_data"> <?php echo date('d-M-Y', strtotime($invoiceDetail->invoice_generate_date)); ?></span>
                </div>
            </li>
        </ul>


    <?php }else if($invoiceDetail->invoice_acceptance_status=='Accept' && (strtolower($invoiceDetail->gen_approval_status) == "accept"|| empty ($invoiceDetail->gen_approval_userid))){?>
    <div class="panel-group theme-accordian" id="accordion" role="tablist" aria-multiselectable="true">
        <div class="panel panel-default">
            <div class="panel-heading" role="tab" id="headingOne">
                <h4 class="panel-title">
                    <a role="button" data-toggle="collapse" data-parent="#accordion" href="#collapseOne" aria-expanded="false" aria-controls="collapseOne" class="collapsed">
                        Invoice Detail
                    </a>
                </h4>
            </div>
            <div id="collapseOne" class="panel-collapse collapse" role="tabpanel" aria-labelledby="headingOne">
                <div class="panel-body">
                    <ul class="order_view_detail">
                        <?php if( 1 || in_array(ORIGINATERROLEID , $userRole) || in_array(MANAGERROLEID , $userRole) || in_array(SUPERADMINROLEID , $userRole)) :  ?>
                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Invoice No.</span>
                                    <span class="ov_data"><?php echo $invoiceDetail->invoice_no; ?></span>
                                </div>
                            </li>
                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Invoice Date</span>
                                    <span class="ov_data"><?php echo date('d-M-Y', strtotime($invoiceDetail->invoice_date)); ?></span>
                                </div>
                            </li>

                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Payment due date</span>
                                    <span class="ov_data"><?php echo (isset($invoiceDetail->invoice_date) && !empty($invoiceDetail->invoice_date)) ? date('d-M-Y', strtotime($invoiceDetail->invoice_date)) :'--'; ?></span>
                                </div>
                            </li>
                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Invoice Net Amount</span>
                                    <span class="ov_data"><?php echo $invoiceDetail->currency_symbol." ".formatAmount($invoiceDetail->invoice_net_amount); ?></span>
                                </div>
                            </li>

                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Taxation</span>
                                    <span class="ov_data"><?php echo ($invoiceDetail->taxation) ? $invoiceDetail->taxation."%":'--'; ?></span>
                                </div>
                            </li>
                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Gross Amount(with taxation)</span>
                                    <span class="ov_data"><?php echo $invoiceDetail->currency_symbol." ".formatAmount($invoiceDetail->invoice_gross_amount); ?></span>
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
                        <?php elseif( 1 || in_array(GENERATERROLEID , $userRole) || in_array(COLLECTORROLEID , $userRole)) :  ?>
                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Invoice No.</span>
                                    <span class="ov_data"><?php echo $invoiceDetail->invoice_no; ?></span>
                                </div>
                            </li>
                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Invoice Date</span>
                                    <span class="ov_data"><?php echo date('d-M-Y', strtotime($invoiceDetail->invoice_date)); ?></span>
                                </div>
                            </li>

                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Payment due date</span>
                                    <span class="ov_data"><?php echo (isset($invoiceDetail->payment_due_date) && !empty($invoiceDetail->payment_due_date)) ? date('d-M-Y', strtotime($invoiceDetail->payment_due_date)) :'--'; ?></span>
                                </div>
                            </li>
                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Invoice Net Amount</span>
                                    <span class="ov_data"><?php echo $invoiceDetail->currency_symbol." ".formatAmount($invoiceDetail->invoice_net_amount); ?></span>
                                </div>
                            </li>

                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Requested By</span>
                                    <span class="ov_data"><?php echo $invoiceDetail->requestorname; ?></span>
                                </div>
                            </li>

                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Generated BY</span>
                                    <span class="ov_data"><?php $generator = getUserInfo($invoiceDetail->generator_user_id); echo ($generator) ? $generator->first_name." ".$generator->last_name : "--"; ?></span>
                                </div>
                            </li>

                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Client Agreement</span>
                                    <span class="ov_data"><?php echo $invoiceDetail->invoice_no; ?></span>
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
                                    <?php endif;  ?>
                                </div>
                            </li>

                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Generated Invoice</span>

                                    <?php if($invoiceDetail->invoice_acceptance_status=='Accept'): ?>
                                        <?php $invoice= getGeneratedInvoiceName($invoiceDetail->invoice_no);

                                        ?>
                                        <span class="ov_data"><a href="<?php echo base_url();?><?php echo $invoiceDetail->invoice_path; ?>" target="_blank"><?php echo $invoice; ?></a></span>
                                    <?php endif;  ?>
                                </div>
                            </li>
                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Comments</span>
                                    <?php if($invoiceDetail->invoice_acceptance_status=='Accept'): ?>
                                        <span class="ov_data"><?php $invoice_generator_comments=str_replace("\\r\\","",trim($invoiceDetail->invoice_generator_comments));
                                            $invoice_generator_comments=str_replace("\\n","--",$invoice_generator_comments);
                                            $invoice_generator_comments=str_replace("\--","<br>",$invoice_generator_comments);
                                            #$invoice_generator_comments=str_replace("\ ","",$invoice_generator_comments);
                                            echo wordwrap($invoice_generator_comments,80,"<br>"); ?></span>
                                    <?php endif;  ?>
                                </div>
                            </li>
                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Approval Comments</span>
                                    <?php if($invoiceDetail->invoice_acceptance_status =="Accept") { ?>
                                        <span class="ov_data"><?php echo wordwrap($invoiceDetail->gen_approval_comment,50,"<br>"); ?></span>
                                    <?php } ?>

                                </div>
                            </li>
                        <?php endif;  ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
</div><!-- theme-accordian -->

<?php }

if($invoiceDetail->gen_approval_status == 'Accept') :
    if(in_array(GENERATERROLEID , $userRole) || in_array(COLLECTORROLEID , $userRole) || 1) : ?>
        <h3 class="form-box-title">Payment Details</h3>
        <?php if($invoiceDetail->gen_approval_status != 'Accept') { ?>
            <td>
                <h5 class="ov_title" style="color: red">Request Invoice is Pending !!</h5>
            </td>
        <?php } else { ?>
            <table class="table table-bordered table-info table-dark">
                <tr>
                    <td>Payment Recieved</td>
                    <td><input name="pymt_recieved" type="radio" id="pymt_recieved" value="Y" checked="checked" disabled="disabled"/>Yes&nbsp;
                        <input name="pymt_recieved" type="radio" id="pymt_recieved" value="N" disabled="disabled"/>No</td>
                    <td>Payment Type</td>
                    <td><input name="pymt_type" type="radio" id="pymt_type" value="F" checked="checked" disabled="disabled"/>Full&nbsp;<input type="radio" name="pymt_type" id="pymt_type" value="P" disabled="disabled"/>Part</td>
                    <td>Gross Invoice Amount</td>
                    <td><?php echo $invoiceDetail->currency_symbol." ".formatAmount($invoiceDetail->invoice_gross_amount); ?></td>
                </tr>
                <?php if($invoiceDetail->payment_recieved_flag !='Y') { ?>
                    <tr>
                        <td colspan="6" style="color:red">Payment is not Received.</td>
                    </tr>
                <?php } else { ?>
                    <tr>
                        <td>Amount Received</td>
                        <td  colspan="2"><?php echo ($invoiceDetail->invoice_collection_amount)? $invoiceDetail->currency_symbol." ".formatAmount($invoiceDetail->invoice_collection_amount):''; ?></td>
                        <td>Date of Payment</td>
                        <td><?php echo  date('d-M-Y', strtotime($invoiceDetail->payment_recieved_date))?></td>
                        <td>&nbsp;</td>
                    <tr>
                    <tr>
                        <td><span class="boldFonts">Payment Mode</span></td>
                        <td><?php echo strtoupper($invoiceDetail->payment_mode); ?></td>
                        <td>
                            <?php
                            $trans_id ='';
                            if($invoiceDetail->payment_mode=="cash")
                                $trans_id="By Cash.";
                            else if($invoiceDetail->payment_mode=="check")
                                $trans_id="Cheque No.";
                            else if($invoiceDetail->payment_mode=="draft")
                                $trans_id="Draft No.";
                            else if($invoiceDetail->payment_mode=="wire")
                                $trans_id="Payment Id.";

                            echo $trans_id;
                            ?>
                        </td>
                        <td><?php echo $invoiceDetail->transaction_no; ?></td>
                        <td><span class="boldFonts">Amount Balance</span></td>
                        <td><?php echo $invoiceDetail->currency_symbol." ".formatAmount($invoiceDetail->invoice_gross_amount - $invoiceDetail->invoice_collection_amount); ?></td>
                    </tr>
                    <tr>
                        <td>Collectors Remark on Payment</td>
                        <td colspan="5">&nbsp;&nbsp;&nbsp;<?php echo $invoiceDetail->payment_recieved_remarks; ?></td>
                    </tr>
                <?php } ?>
            </table>
        <?php }

    endif;  endif;  ?>
</div><!--view_invoice_info -->