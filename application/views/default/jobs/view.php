<div class="view_order_info">
    <!--Request Invoice Details -->
    <!-- <h3 class="form-box-title">Request Invoice Details</h3>-->
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
        <li>
            <div class="order_info_block">
                <span class="ov_title">Client Name</span>
                <span class="ov_data"><?php echo $jobDetail->first_name;
                echo ($jobDetail->middle_name) ? " ".$jobDetail->middle_name :'';
                echo ($jobDetail->last_name) ? " ".$jobDetail->last_name :'';
                ?></span>
            </div>
            </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Client Address</span>
                <span class="ov_data"><?php echo $jobDetail->address; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Client Mobile No.</span>
                <span class="ov_data"><?php echo $jobDetail->mobile_number; ?></span>
            </div>
        </li>
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
    <h3 class="form-box-title">Documents</h3>
    <div class="ims_datatable table-responsive" style="background: #FFFFFF;">
        <!-- <h3 class="form-box-title">Client Details </h3>-->
        <table id="clientList" class="table table-striped table-bordered table-condensed table-hover" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Document Name</th>
                <th>Attached File</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(count($jobDocuments)):
                foreach ($jobDocuments as $doc): ?>
                    <tr>
                        <td><?php echo $doc->documentName; ?></td>
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

    <!--Invoice Details-->
   <?php if($jobDetail->invoice_acceptance_flag == 'Y' || $jobDetail->invoice_acceptance_status=='Accept' && (strtolower($jobDetail->gen_approval_status) == "accept" || empty ($jobDetail->gen_approval_userid))){?>
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
                        <?php if(in_array(ORIGINATERROLEID , $userRole) || in_array(MANAGERROLEID , $userRole) || in_array(SUPERADMINROLEID , $userRole)) :  ?>
                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Invoice No.</span>
                                    <span class="ov_data"><?php echo $jobDetail->invoice_no; ?></span>
                                </div>
                            </li>
                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Invoice Date</span>
                                    <span class="ov_data"><?php echo date('d-M-Y', strtotime($jobDetail->invoice_date)); ?></span>
                                </div>
                            </li>

                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Payment due date</span>
                                    <span class="ov_data"><?php echo (isset($jobDetail->invoice_date) && !empty($jobDetail->invoice_date)) ? date('d-M-Y', strtotime($jobDetail->invoice_date)) :'--'; ?></span>
                                </div>
                            </li>
                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Invoice Net Amount</span>
                                    <span class="ov_data"><?php echo $jobDetail->currency_symbol." ".formatAmount($jobDetail->invoice_net_amount); ?></span>
                                </div>
                            </li>

                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Taxation</span>
                                    <span class="ov_data"><?php echo ($jobDetail->taxation) ? $jobDetail->taxation."%":'--'; ?></span>
                                </div>
                            </li>
                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Gross Amount(with taxation)</span>
                                    <span class="ov_data"><?php echo $jobDetail->currency_symbol." ".formatAmount($jobDetail->invoice_gross_amount); ?></span>
                                </div>
                            </li>
                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Attached Invoice</span>
                                    <?php if($jobDetail->invoice_acceptance_status=='Accept'): ?>
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
                                    <?php $invoice= getGeneratedInvoiceName($jobDetail->invoice_no);

                                    ?>
                                    <span class="ov_data"><a href="<?php echo base_url();?><?php echo $jobDetail->invoice_path; ?>" target="_blank"><?php echo $invoice; ?></a></span>

                                </div>
                            </li>
                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Comments</span>
                    <span class="ov_data"><?php $invoice_generator_comments = str_replace ( "\\r\\", "", trim ( $jobDetail->invoice_generator_comments ) );
                        $invoice_generator_comments = str_replace ( "\\n", "--", $invoice_generator_comments );
                        $invoice_generator_comments = str_replace ( "\--", "<br>", $invoice_generator_comments );
                        echo wordwrap ( $invoice_generator_comments, 70, "<br>" ); ?></span>
                                </div>
                            </li>
                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Approval Comments</span>
                                    <span class="ov_data"><?php echo wordwrap ( $jobDetail->gen_approval_comment, 50, "<br>" ); ?></span>
                                </div>
                            </li>
                        <?php elseif(in_array(GENERATERROLEID , $userRole) || in_array(COLLECTORROLEID , $userRole)) :  ?>
                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Invoice No.</span>
                                    <span class="ov_data"><?php echo $jobDetail->invoice_no; ?></span>
                                </div>
                            </li>
                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Invoice Date</span>
                                    <span class="ov_data"><?php echo date('d-M-Y', strtotime($jobDetail->invoice_date)); ?></span>
                                </div>
                            </li>

                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Payment due date</span>
                                    <span class="ov_data"><?php echo (isset($jobDetail->payment_due_date) && !empty($jobDetail->payment_due_date)) ? date('d-M-Y', strtotime($jobDetail->payment_due_date)) :'--'; ?></span>
                                </div>
                            </li>
                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Invoice Net Amount</span>
                                    <span class="ov_data"><?php echo $jobDetail->currency_symbol." ".formatAmount($jobDetail->invoice_net_amount); ?></span>
                                </div>
                            </li>

                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Requested By</span>
                                    <span class="ov_data"><?php echo $jobDetail->requestorname; ?></span>
                                </div>
                            </li>

                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Generated By</span>
                                    <span class="ov_data"><?php $generator = getUserInfo($jobDetail->generator_user_id); echo ($generator) ? $generator->first_name." ".$generator->last_name : "--"; ?></span>
                                </div>
                            </li>

                            <li>
                                <div class="order_info_block">
                                    <span class="ov_title">Attached Invoice</span>
                                    <?php if($jobDetail->invoice_acceptance_status=='Accept'): ?>

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

                                    <?php if($jobDetail->invoice_acceptance_status=='Accept'): ?>
                                        <?php $invoice= getGeneratedInvoiceName($jobDetail->invoice_no);

                                        ?>
                                        <span class="ov_data"><a href="<?php echo base_url();?><?php echo $jobDetail->invoice_path; ?>" target="_blank"><?php echo $invoice; ?></a></span>
                                    <?php endif;  ?>
                                </div>
                            </li>
                            <li class="od_block">
                                <div class="order_info_block">
                                    <span class="ov_title">Comments</span>
                                    <?php if($jobDetail->invoice_acceptance_status=='Accept'): ?>
                                        <span class="ov_data"><?php $invoice_generator_comments=str_replace("\\r\\","",trim($jobDetail->invoice_generator_comments));
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
                                    <?php if($jobDetail->invoice_acceptance_status =="Accept") { ?>
                                        <span class="ov_data"><?php echo wordwrap($jobDetail->gen_approval_comment,50,"<br>"); ?></span>
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

<?php } ?>
</div><!--view_invoice_info -->