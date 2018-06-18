<div class="view_order_info">
            <!--Order Details -->
    <!--<h3 class="form-box-title">Order Details</h3>-->
    <ul class="order_view_detail">
        <li>
            <div class="order_info_block">
                <span class="ov_title">Order ID</span>
                <span class="ov_data"><?php echo $orderDetail->order_unique_id; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Order Category</span>
                <span class="ov_data"><?php echo $orderDetail->category_name; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Project Type</span>
                <span class="ov_data"><?php echo ($orderDetail->project_type =='FB') ? "Fixed Bid": "Time and Material"; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Project Name</span>
                <span class="ov_data"><?php echo $orderDetail->project_name; ?></span>
            </div>
        </li>
        <li class="od_block">
            <div class="order_info_block">
                <span class="ov_title">Project Description</span>
                <span class="ov_data"><?php echo $orderDetail->project_description; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">WD Sales Person Name</span>
                <span class="ov_data"><?php echo $orderDetail->wd_sales_person; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">WD Tech Head</span>
                <span class="ov_data"><?php echo $orderDetail->wd_head_person; ?></span>
            </div>
        </li>
        <?php if($orderDetail->project_type =="TNM" ): ?>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Unit</span>
                <?php if($orderDetail->efforts_unit == 'D')
                {
                    $efforts_unit = "PD's ";
                } else if($orderDetail->efforts_unit == 'M')
                {
                    $efforts_unit ="PM's ";
                } else
                {
                    $efforts_unit = "Hours ";
                } ?>
                <span class="ov_data"><?php echo $efforts_unit; ?></span>
            </div>
        </li>
        <?php endif; ?>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Start Date</span>
                <span class="ov_data"><?php echo date('d-M-Y', strtotime($orderDetail->start_date)); ?></span>
            </div>
        </li>
        <?php if($orderDetail->project_type =="FB"): ?>
        <li>
            <div class="order_info_block">
                <span class="ov_title">End Date</span>
                <span class="ov_data"><?php echo date('d-M-Y', strtotime($orderDetail->end_date)); ?></span>
            </div>
        </li>
        <?php else: ?>

            <li>
                <div class="order_info_block">
                    <span class="ov_title">Hourly Rate</span>
                    <span class="ov_data"><?php echo $orderDetail->hour_currency." ".$orderDetail->hourly_rate; ?></span>
                </div>
            </li>

        <?php endif; ?>
        <?php if($orderDetail->project_type =="FB"): ?>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Total Efforts</span>
                <span class="ov_data"><?php echo $orderDetail->total_efforts. ' ' .  $orderDetail->efforts_unit; ?></span>
            </div>
        </li>
        <?php endif; ?>
        <?php if($orderDetail->project_type =="TNM"): ?>
        <li>
            <div class="order_info_block">
                <?php
                if($orderDetail->efforts_unit == 'D')
                {
                    $consumption="Daily";
                } else if($orderDetail->efforts_unit == 'M')
                {
                    $consumption="Monthly";
                } else
                {
                    $consumption="Hourly";
                }
                ?>
                <span class="ov_title"><?php echo $consumption; ?> Consumption</span>

                <span class="ov_data"><?php echo $orderDetail->total_efforts. ' ' .  $efforts_unit; ?></span>
            </div>
        </li>
        <?php endif; ?>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Order Amount</span>
                <span class="ov_data"><?php echo $orderDetail->currency_symbol. ' ' . formatAmount($orderDetail->order_amount); ?></span>
            </div>
        </li>
    </ul>
    <?php if(($orderDetail->project_type =="FB") || (($orderDetail->project_type =="TNM") &&($orderDetail->efforts_unit =='M') )) : ?>
    <?php if(isset($orderSchedules) && count($orderSchedules)): ?>
            <h3 class="form-box-title">Invoice Schedule</h3>
    <ul class="order_view_detail inv_schedule">
       <?php
            $invoiceTotalAmount = 0;
            foreach($orderSchedules as $schedule):
                $invoiceTotalAmount += $schedule->invoice_amount;
            ?>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Date</span>
                <span class="ov_data"><?php echo date('d-M-Y', strtotime($schedule->invoice_date)); ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Amount</span>
                <span class="ov_data"><?php echo formatAmount($schedule->invoice_amount); ?></span>
            </div>
        </li>
        <li class="od_block">
            <div class="order_info_block">
                <span class="ov_title">Comment</span>
                <span class="ov_data"><?php echo $schedule->invoice_comment; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Invoice for schedule</span>
                <span class="ov_data"><?php echo ($schedule->status=='T')? "Tentative" : "Confirmed"; ?></span>
            </div>
        </li>
            <?php endforeach; ?>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Total Invoice Amount</span>
                <span class="ov_data"><?php echo $orderDetail->currency_symbol. ' ' . formatAmount($invoiceTotalAmount); ?></span>
            </div>
        </li>

    </ul>
        <?php endif; ?>
    <?php endif; ?>
    <h3 class="form-box-title">Project Contact Details</h3>
    <ul class="order_view_detail">
        <li class="od_block">
            <div class="order_info_block">
                <span class="ov_title">Client Name</span>
                <span class="ov_data"><?php echo $orderDetail->client_name; ?></span>
            </div>
        </li>
        <li class="od_block">
            <div class="order_info_block">
                <span class="ov_title">Postal Address</span>
                <span class="ov_data"><?php echo $orderDetail->address1." ".$orderDetail->address2; ?></span>
            </div>
        </li>
        <?php if(isset($salesPerson)  && is_object($salesPerson)): ?>
        <div class="od_block title_sub">
            <h4>Manager's Details</h4>
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
            <h4>Client's Accounts Details</h4>
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
    </ul>
    <h3 class="form-box-title">Invoice Description</h3>
    <ul class="order_view_detail">
        <li>
            <div class="order_info_block">
                <span class="ov_title">PO/RO Number</span>
                <span class="ov_data"><?php echo $orderDetail->po_no; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">No PO</span>
                <span class="ov_data"><?php echo ($orderDetail->no_po == 1)?"YES" :"NO" ?></span>
            </div>
        </li>
        <li class="full_block">
            <div class="order_info_block">
                <span class="ov_title">Client Agreement</span>
                <?php if(isset($clientAgreements) && !empty($clientAgreements)): ?>
                <span class="ov_data attach_list">    
                <?php foreach($clientAgreements as $agreement):
                            $originalName = trim(strstr($agreement->agreement_name, '_'), '_');
                            $fileNameArray = explode('_', $agreement->attach_file_name);
                            if(count($fileNameArray) > 1) {
                                if(!is_numeric(current($fileNameArray))) {
                                    $originalName = $agreement->attach_file_name;
                                }
                            } else {
                                $originalName = $agreement->attach_file_name;
                            }
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
                <span class="ov_title">PO Date</span>
                <span class="ov_data"><?php echo ($orderDetail->no_po != 1 && $orderDetail->po_date !='')? date('d-M-Y', strtotime($orderDetail->po_date)):'--'; ?></span>
            </div>
        </li>
        <li class="od_block">
            <div class="order_info_block">
                <span class="ov_title">PO Details</span>
                <span class="ov_data"><?php echo $orderDetail->po_dtl; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Payment Term</span>
                <span class="ov_data"><?php echo $orderDetail->name; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Attachment</span>
                <?php if(isset($orderAttachments) && !empty($orderAttachments)): ?>
                    <?php foreach($orderAttachments as $attachment):
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
        <li class="od_block">
            <div class="order_info_block">
                <span class="ov_title">Remark</span>
                <span class="ov_data"><?php echo $orderDetail->invoice_originator_remarks; ?></span>
            </div>
        </li>
    </ul>
</div><!--view_Order_info -->