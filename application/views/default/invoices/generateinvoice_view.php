<div class="view_order_info">
    <!--Request Invoice Details -->
    <!--<h3 class="form-box-title">Request Invoice Details</h3>-->

    <input type="hidden" name="country" id="country" value="<?php if (isset($country)&& !empty($country)) {echo $country->country_name;} ?>">
    <input type="hidden" name="state" id="state" value="<?php if (isset($state) && !empty($state)) {echo $state->state_name;} ?>">
    <input type="hidden" name="city" id="city" value="<?php if(isset($invoiceDetail->city)&& !empty($invoiceDetail->city)){echo $invoiceDetail->city;}  ?>">
    <input type="hidden" name="gst_no" id="gst_no" value="<?php if (isset($invoiceDetail->gst_no) && !empty($invoiceDetail->gst_no)) { echo $invoiceDetail->gst_no;} ?>">
    <input type="hidden" name="place_of_supply" id="place_of_supply" value="<?php if (isset($invoiceDetail->place_of_supply) && !empty($invoiceDetail->place_of_supply)) { echo $invoiceDetail->place_of_supply; }?>">


    <input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $invoiceDetail->invoice_req_id; ?>">
    <input type="hidden" name="user_id" id="user_id" value="<?php echo $invoiceDetail->id; ?>">
    <input type="hidden" name="requestor_email" id="requestor_email" value="<?php echo $invoiceDetail->email; ?>">
    <input type="hidden" name="requestor_name" id="requestor_name" value="<?php echo $invoiceDetail->requestorname; ?>">
    <input type="hidden" name="client_name" id="client_name" value="<?php echo $invoiceDetail->client_name; ?>">
    <?php if($invoiceDetail->salesperson_id=="" && $invoiceDetail->account_id=""){ ?>
        <input type="hidden" name="client_addr" id="client_addr"
               value="<?php echo $invoiceDetail->address; ?>">
    <?php } else { ?>
        <input type="hidden" name="client_addr" id="client_addr"
               value="<?php echo $invoiceDetail->sales_person_address; ?>">
    <?php } ?>
    <input type="hidden" name="po_amt" id="po_amt"
           value="<?php echo $invoiceDetail->currency_name." ".$invoiceDetail->invoice_net_amount; ?>">
    <input type="hidden" name="po_curr" id="po_curr" value="<?php echo $invoiceDetail->currency_name; ?>">
    <input type="hidden" name="po_dtl" id="po_dtl" value="<?php echo $invoiceDetail->po_dtl; ?>">
    <input type="hidden" name="category_id" id="category_id" value="<?php echo $invoiceDetail->category_name; ?>">
    <ul class="order_view_detail">
        <li>
            <div class="order_info_block">
                <span class="ov_title">PO/RO No.</span>
                <span class="ov_data"><?php echo $invoiceDetail->po_no; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title"> Invoice Description</span>
                <span class="ov_data"><?php echo $invoiceDetail->invoice_description; ?></span>
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
                <span class="ov_data"><?php echo $requestUser->first_name . " " . $requestUser->last_name; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Requestor Email Id</span>
                <span class="ov_data"><?php echo $requestUser->email; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Approved By</span>
                <span class="ov_data"><?php echo $invoiceDetail->approvername; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Approved Date</span>
                <span class="ov_data"> <?php echo date('d-M-Y', strtotime($invoiceDetail->approval_date)); ?></span>
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

        <?php if(($invoiceDetail->category_id == '1' || $invoiceDetail->category_id== '7')&&(isset($invoiceDetail->actual_delivered) || isset($invoiceDetail->delivered_required))){

            ?>

                <?php if(isset($invoiceDetail->delivered_required)){?>
                    <li class="od_block">
                        <div class="order_info_block">
                            <span class="ov_title">Delivered Required</span>
                            <span class="ov_data"><?php echo $invoiceDetail->delivered_required." ".$unit->unit_name; ?></span>
                        </div>
                    </li>
                <?php }?>
                <?php if(isset($invoiceDetail->actual_delivered) && (!isset($invoiceDetail->delivered_required))){?>
                <li class="od_block">
                    <div class="order_info_block">
                        <span class="ov_title">Actual Delivered</span>
                        <span class="ov_data"><?php echo $invoiceDetail->actual_delivered." ".$unit->unit_name ; ?></span>
                    </div>
                    </li>
                <?php }else if(isset($invoiceDetail->actual_delivered) && isset($invoiceDetail->delivered_required)){ ?>
                <li class="od_block">
                    <div class="order_info_block">
                        <span class="ov_title">Actual Delivered</span>
                        <span class="ov_data"><?php echo $invoiceDetail->actual_delivered." ".$unit->unit_name ; ?></span>
                    </div>
                    </li>

                <?php } else {?>
                    <div></div>
                <?php }?>

        <?php }?>



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
                <span class="ov_title">Requester Comments</span>
                <span class="ov_data"><?php echo $invoiceDetail->invoice_originator_remarks; ?></span>
            </div>
        </li>

        <li>
            <div class="order_info_block">
                <span class="ov_title">Project Title</span>
                <span class="ov_data"><?php echo $invoiceDetail->project_name; ?></span>
            </div>
        </li>

        <li>
            <div class="order_info_block">
                <span class="ov_title">PO/RO Date</span>

                <span class="ov_data"><?php echo ($invoiceDetail->po_date !='')? date('d-M-Y', strtotime($invoiceDetail->po_date)):'--'; ?></span>
            </div>
        </li>
    </ul>















