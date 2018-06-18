<div class="content-wrapper">
    <div class="content_header">
        <h3>Invoice Generator Form</h3>
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
        <div id="msg"></div>
		</div>
        <form action="" method="post" id="generate-invoice" name="generate-invoice" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box-form">
                        <h3 class="form-box-title">Invoice Request Details</h3>

                        <input type="hidden" name="country" id="country" value="<?php echo (isset($country) && $country) ? $country->country_name : ''; ?>">
                        <input type="hidden" name="country_id" id="country_id" value="<?php echo $invoiceDetail->country; ?>">
                        <input type="hidden" name="state" id="state" value="<?php echo isset($state->state_name)?$state->state_name:""; ?>">
                        <input type="hidden" name="city" id="city" value="<?php echo $invoiceDetail->city; ?>">
                        <input type="hidden" name="gst_no" id="gst_no" value="<?php echo $invoiceDetail->gst_no; ?>">
                        <input type="hidden" name="place_of_supply" id="place_of_supply" value="<?php echo $invoiceDetail->place_of_supply; ?>">


                        <input type="hidden" name="invoice_id" id="invoice_id" value="<?php echo $invoiceDetail->invoice_req_id; ?>">
                        <input type="hidden" name="user_id" id="user_id" value="<?php echo $invoiceDetail->id; ?>">
                        <input type="hidden" name="requestor_email" id="requestor_email" value="<?php echo $invoiceDetail->email; ?>">
                        <input type="hidden" name="requestor_name" id="requestor_name" value="<?php echo $invoiceDetail->requestorname; ?>">
                        <input type="hidden" name="client_name" id="client_name" value="<?php echo $invoiceDetail->client_name; ?>">
                        <?php if($invoiceDetail->salesperson_id==""){ ?>
                            <input type="hidden" name="client_addr" id="client_addr"
                                   value="<?php echo $invoiceDetail->address; ?>">
                        <?php } else { ?>
                            <input type="hidden" name="client_addr" id="client_addr"
                                   value="<?php echo $invoiceDetail->address; ?>"><!--$invoiceDetail->sales_person_address -->
                        <?php } ?>
                        <input type="hidden" name="po_amt" id="po_amt"
                               value="<?php echo $invoiceDetail->currency_name." ".$invoiceDetail->invoice_net_amount; ?>">
                        <input type="hidden" name="net_amt" id="net_amt" value="<?php echo $invoiceDetail->invoice_net_amount; ?>">
                        <input type="hidden" name="po_curr" id="po_curr" value="<?php echo $invoiceDetail->currency_symbol; ?>">
                        <input type="hidden" name="po_dtl" id="po_dtl" value="<?php echo $invoiceDetail->po_dtl; ?>">
                        <input type="hidden" name="category_id" id="category_id" value="<?php echo $invoiceDetail->category_id; ?>">
                        <div class="invoice_req_info">
                            <ul class="edit_form_list">
                                <li>
                                    <h3>PO/RO Number</h3>
                                    <span><?php echo $invoiceDetail->po_no; ?></span>
                                </li>
                                <li>
                                    <h3>Invoice Description</h3>
                                    <span><?php echo $invoiceDetail->po_dtl; ?></span>
                                </li>
                                <li>
                                    <h3>Net Invoice Amount </h3>
                                    <span><?php echo $invoiceDetail->currency_symbol." ".formatAmount($invoiceDetail->invoice_net_amount); ?></span>
                                </li>
                                <li>
                                    <h3>Invoice Category</h3>
                                    <span><?php echo $invoiceDetail->category_name; ?></span>
                                </li>
                                <li>
                                    <h3>Requested By</h3>
                                    <span><?php echo $invoiceDetail->requestorname; ?></span>
                                </li>
                                <li>
                                    <h3>Requested Date</h3>

                                    <span><?php echo date('d-M-Y', strtotime($invoiceDetail->invoice_originate_date)); ?></span>
                                </li>
                                <li>
                                    <h3>Approved By</h3>
                                    <span class="ov_data"><?php echo $invoiceDetail->approvername; ?></span>
                                </li>
                                <li>
                                    <h3>Approved Date</h3>
                                    <span> <?php echo ($invoiceDetail->approval_date) ? date('d-M-Y', strtotime($invoiceDetail->approval_date)) : ''; ?></span>
                                </li>
                                <li>
                                    <h3>Client</h3>
                                    <span><?php echo $invoiceDetail->client_name; ?></span>
                                </li>
                                <li>
                                    <h3>Client Address</h3>
                                    <span><?php echo $invoiceDetail->address; ?></span>
                                </li>
                                <?php if(isset($salesPerson)  && is_object($salesPerson)): ?>
                                    <li>
										<h3>SalesPerson Name</h3>
										<span ><?php echo $salesPerson->sales_person_name; ?></span>
                                    </li>
                                    <li>
										<h3>Contact Number</h3>
										<span><?php echo $salesPerson->sales_contact_no; ?></span>
                                    </li>
                                    <li>
										<h3>Email Id</h3>
										<span><?php echo $salesPerson->sales_person_email; ?></span>
                                    </li>
                                <?php endif; ?>
                                <?php if(isset($accountPerson)  && is_object($accountPerson)): ?>
                                    <li>
										<h3>AccountPerson Name</h3>
										<span><?php echo $accountPerson->account_person_name; ?></span>
                                    </li>
                                    <li>
										<h3>Contact Number</h3>
										<span><?php echo $accountPerson->account_contact_no; ?></span>
                                    </li>
                                    <li>
										<h3>Email Id</h3>
										<span><?php echo $accountPerson->account_person_email; ?></span>
                                    </li>
                                <?php endif; ?>


                                <?php if(($invoiceDetail->category_id == '1' || $invoiceDetail->category_id== '7')&&(isset($invoiceDetail->actual_delivered) || isset($invoiceDetail->delivered_required))){

                                    ?>

                                    <?php if(isset($invoiceDetail->delivered_required)){?>
                                        <li>
											<h3>Delivered Required</h3>
											<span class="ov_data"><?php echo $invoiceDetail->delivered_required." ".$unit->unit_name; ?></span>
                                        </li>
                                    <?php }?>
                                    <?php if(isset($invoiceDetail->actual_delivered) && (!isset($invoiceDetail->delivered_required))){?>
                                        <li>
											<h3>Actual Delivered</h3>
											<span><?php echo $invoiceDetail->actual_delivered." ".$unit->unit_name ; ?></span>
                                        </li>
                                    <?php }else if(isset($invoiceDetail->actual_delivered) && isset($invoiceDetail->delivered_required)){ ?>
                                        <li>
											<h3>Actual Delivered</h3>
											<span><?php echo $invoiceDetail->actual_delivered." ".$unit->unit_name ; ?></span>
                                        </li>

                                    <?php } else {?>
                                        <div></div>
                                    <?php }?>

                                <?php }?>
                                
                                <li>
                                    <h3>Requestor Comments</h3>
                                    <span class="ov_data"><?php echo $invoiceDetail->invoice_originator_remarks; ?></span>
                                </li>
                                <li>
                                    <h3>Project Title</h3>
                                    <span class="ov_data"><?php echo $invoiceDetail->project_name; ?></span>
                                </li>
                                <li>
                                    <h3>PO/RO Date</h3>
                                    <span class="ov_data"><?php echo ($invoiceDetail->po_date !='')? date('d-M-Y', strtotime($invoiceDetail->po_date)):'--'; ?></span>
                                </li>
								<li>
                                        <h3>Attached PO</h3>
									<span>
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
										<div class="attach_list_box"><a href="<?php echo base_url();?><?php echo $fileURl; ?>" title="<?php echo $originalName; ?>" target="_blank"><?php echo $originalName; ?></a> <strong>Type : </strong><?php echo $attachmentType; ?></div>
                                            <?php endforeach; ?>
										</span>
                                        <?php else: ?>
                                            <span class="ov_data">No Attachment</span>
                                        <?php endif; ?>
                                </li>

                            </ul>
                        </div><!--div-->
                    </div><!--box-form-->
                </div><!--col-sm-12-->
                <div class="col-sm-12">
                    <div class="box-form">
                        <h3 class="form-box-title">Edit Invoice Request Details</h3>
                        <div class="theme-form">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Sales Person Authority</label>
                                            <?php
                                            if ($invoiceDetail->invoice_acceptance_status== "Accept") {
                                                ?>
                                                <select class="ims_form_control" name="wd_sales_id" id="wd_sales_id" disabled >
                                                <option value="" >Sales Person Authority*</option>
                                                <?php foreach($wdsalesperson as $rows) { ?>
                                                    <?php  if($invoiceDetail->salespersonid == $rows->id) {?>

                                                        <option selected value="<?php echo $rows->id; ?>"><?php echo ucfirst($rows->name)?></option>
                                                    <?php } else{?>
                                                        <option value="<?php echo $rows->id?>"><?php echo ucfirst($rows->name)?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                                </select><?php } ?>
                                        </div><!--form-group-->
                                    </div><!--col-sm-3-->
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Project Title</label>
                                            <?php if($invoiceDetail->invoice_acceptance_status=="Accept"){ ?>
                                           <input type="text" class="ims_form_control" id="project_title" name="project_title" value="<?php echo $invoiceDetail->project_name; ?>" readonly="readonly"/>
                                            <?php } ?>
                                        </div><!--form-group-->
                                    </div><!--col-sm-3-->
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">PO/RO Number</label>
                                            <?php if($invoiceDetail->invoice_acceptance_status=="Accept"){ ?>
                                           

                                                <input type="text" class="ims_form_control"  name="po_no" id="po_no" value="<?php echo $invoiceDetail->po_no; ?>" readonly="readonly"/>

                                     <?php }?>
                                        </div><!--form-group-->
                                    </div><!--col-sm-3-->
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">PO/RO Date</label>
                                            <?php if($invoiceDetail->invoice_acceptance_status=="Accept"){ ?>
                                          
                                                    <input type="text" name="po_date" id="po_date"  value="<?php echo ($invoiceDetail->po_date !='')? date('d-M-Y', strtotime($invoiceDetail->po_date)):'--'; ?>" class="agreement_date ims_form_control date_icon sel_date"   placeholder="PO/RO Date*" readonly="readonly" />

                                                <?php } ?>
                                        </div><!--form-group-->
                                    </div><!--col-sm-3-->
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Payment Term</label>
                                            <?php if($invoiceDetail->invoice_acceptance_status=="Accept"){ ?>
                                              <select class="ims_form_control" name="payment_term" id="payment_term" type="hidden" disabled>
                                                            <option value="">Payment Term</option>
                                                            <?php foreach($paymentterm as $rows) { ?>
                                                                <?php if($invoiceDetail->payment_term == $rows->id){?>}
                                                                    <option selected value="<?php echo $rows->id?>"><?php echo ucfirst($rows->name)?></option>
                                                                <?php } else{?>
                                                                    <option value="<?php echo $rows->id?>"><?php echo ucfirst($rows->name)?></option>
                                                                <?php } ?>

                                                            <?php } ?>
                                                        </select>
                                            <?php } ?>
                                        </div><!--form-group-->
                                    </div><!--col-sm-3-->
                            </div><!--row-->
                        </div><!--theme-form-->
                    </div><!--box-form-->
                </div><!--col-sm-12-->
				<div class="col-sm-12"><h3 class="form-box-title col-sm-12">Invoice Details</h3></div>
                <div class="col-sm-5">
                    <div class="box-form">
						
                        <div class="theme-form">
                            <div class="row">
                                <div class="col-sm-12">
									<label class="ims_form_label">Invoice Number</label>
                                    <div class="form-group">
                                       
                                       <?php

                                        if ($invoiceDetail->invoice_acceptance_status =="Accept") {
                                  
                                            ?>

                                                <?php
                                                foreach ( $companylist as $cmp ) {
                                                    $cmp_name = (strlen ( $cmp->company_name ) > 15) ? substr ( $cmp->company_name, 0, 13 ) : $cmp->company_name;

                                                    $checked = ($cmp->company_id == $invoiceDetail->company_id) ? 'checked="checked" disabled="disabled"' : 'disabled="disabled"';
                                                    ?>
                                                       <div class="radio-inline radio">

                                                        <input type='radio' name='cmp'
                                                           value='<?php echo $cmp->company_id.'^##^'.$cmp->include_tax;?>'
                                                           id="cmp_<?php echo $cmp->company_id;?>"
                                                           onclick="generateInvoiceByCompany('approver',<?php echo $cmp->company_id;?>);"
                                                           title="<?php echo $cmp->company_name;?>"
                                                        <?php echo $checked;?> >
                                                        <label for="cmp_<?php echo $cmp->company_id;?>"><?php echo $cmp_name;?></label>
                                                        

                                                    </div>
                                                    <?php
                                                }

                                                ?>
                                       <input type="hidden" name="invoice_cmp_id" id="invoice_cmp_id"
                                                     value="<?php echo $invoiceDetail->company_id;?>">

                                           <?php
                                        }
                                        ?>
                                      <div id="company_invoice">
										<?php
										echo '<input name="invoice_num" type="text" class="ims_form_control" id="invoice_num"  value="' . $invoiceDetail->invoice_no . '" readonly="readonly"/>';
										?>
										</div>
                                        
                                            <?php
                                            $cat_array = array (
                                                "ADV",
                                                "EADV",
                                                "LOC",
                                                "ELOC",
                                                "MED",
                                                "EMED",
                                                "TEC",
                                                "ETEC"
                                            );
                                            ?>
                                           <div id="webdunia_com" style="display: none;">
											<?php
											if ($invoiceDetail->company_id == 1) {
												$date = date ( 'd' );
												$mon = date ( 'n' );
												$curr_full_year = date ( 'Y' );
												$pre_full_year = date ( 'Y' ) - 1;
												$curr_short_year = date ( 'y' );
												$next_short_year = date ( 'y' ) + 1;
												if ($invoiceDetail->invoice_acceptance_status == "Accept") {
													$invoice_no = (explode ( "/", $invoiceDetail->invoice_no ));

													if ($mon < $financial_year_start_month) {
														echo '<input name="invoice_no" type="text" class="ims_form_control" id="invoice_no" style="width:auto" size="20" maxlength="50" value="' . $invoice_no [0] . '"/>/<select name="invoice_cat_abr" class="ims_form_control" id="invoice_cat_abr" style="width:auto">';
														foreach ( $cat_array as $cat ) {
															if ($cat == $invoice_no [1])
																echo '<option value="' . $cat . '" selected="selected">' . $cat . '</option>';
															else
																echo '<option value="' . $cat . '">' . $cat . '</option>';
														}
														echo '</select>/<select name="invoice_year" id="invoice_year" class="ims_form_control" style="width:auto"><option value="' . $pre_full_year . '-' . $curr_short_year . '" selected="selected">' . $pre_full_year . '-' . $curr_short_year . '</option><option value="' . ($pre_full_year - 1) . '-' . ($curr_short_year - 1) . '" >' . ($pre_full_year - 1) . '-' . ($curr_short_year - 1) . '</option></select>';
													} else {
														/*if ($mon == 3 && $date <= 10) {
                                                            echo '<input name="invoice_no" type="text" class="textbox" id="invoice_no" style="width:auto" size="20" maxlength="50" value="' . $invoice_no [0] . '"/>/<select name="invoice_cat_abr" id="invoice_cat_abr" style="width:auto">';
                                                            foreach ( $cat_array as $cat ) {
                                                                if ($cat == $invoice_no [1])
                                                                    echo '<option value="' . $cat . '" selected="selected">' . $cat . '</option>';
                                                                else
                                                                    echo '<option value="' . $cat . '">' . $cat . '</option>';
                                                            }
                                                            echo '</select>/<select name="invoice_year" id="invoice_year" style="width:auto"><option value="' . $pre_full_year . '-' . $curr_short_year . '" selected="selected">' . $pre_full_year . '-' . $curr_short_year . '</option><option value="' . ($pre_full_year - 1) . '-' . ($curr_short_year - 1) . '" >' . ($pre_full_year - 1) . '-' . ($curr_short_year - 1) . '</option></select>';
                                                        } else*/ {
															echo '<input name="invoice_no" type="text" class="ims_form_control" id="invoice_no" style="width:auto" size="20" maxlength="50" value="' . $invoice_no [0] . '"/>/<select name="invoice_cat_abr" class="ims_form_control" id="invoice_cat_abr" style="width:auto">';
															foreach ( $cat_array as $cat ) {
																if ($cat == $invoice_no [1])
																	echo '<option value="' . $cat . '" selected="selected">' . $cat . '</option>';
																else
																	echo '<option value="' . $cat . '">' . $cat . '</option>';
															}
															echo '</select>/<select name="invoice_year" class="ims_form_control" id="invoice_year" style="width:auto"><option value="' . $curr_full_year . '-' . $next_short_year . '" selected="selected">' . $curr_full_year . '-' . $next_short_year . '</option><option value="' . ($curr_full_year - 1) . '-' . ($next_short_year - 1) . '" >' . ($curr_full_year - 1) . '-' . ($next_short_year - 1) . '</option></select>';
														}
													}
												} else {
													// echo '<input name="invoice_no" type="text" class="textbox" id="invoice_no" maxlength="20"/>';
													if ($mon < $financial_year_start_month) {
														echo '<input name="invoice_no" type="text" class="ims_form_control" id="invoice_no" style="width:auto" size="20" maxlength="50" />/<select name="invoice_cat_abr" class="ims_form_control" id="invoice_cat_abr" style="width:auto">';
														foreach ( $cat_array as $cat ) {
															echo '<option value="' . $cat . '">' . $cat . '</option>';
														}
														echo '</select>/<select name="invoice_year" class="ims_form_control" id="invoice_year" style="width:auto"><option value="' . $pre_full_year . '-' . $curr_short_year . '" selected="selected">' . $pre_full_year . '-' . $curr_short_year . '</option><option value="' . ($pre_full_year - 1) . '-' . ($curr_short_year - 1) . '" >' . ($pre_full_year - 1) . '-' . ($curr_short_year - 1) . '</option></select>';
													} else {
														/*if ($mon == 3 && $date <= 10) {
                                                            echo '<input name="invoice_no" type="text" class="textbox" id="invoice_no" style="width:auto" size="20" maxlength="50" />/<select name="invoice_cat_abr" id="invoice_cat_abr" style="width:auto">';
                                                            foreach ( $cat_array as $cat ) {
                                                                echo '<option value="' . $cat . '">' . $cat . '</option>';
                                                            }
                                                            echo '</select>/<select name="invoice_year" id="invoice_year" style="width:auto"><option value="' . $pre_full_year . '-' . $curr_short_year . '" selected="selected">' . $pre_full_year . '-' . $curr_short_year . '</option><option value="' . ($pre_full_year - 1) . '-' . ($curr_short_year - 1) . '" >' . ($pre_full_year - 1) . '-' . ($curr_short_year -1 ) . '</option></select>';
                                                        } else*/ {
															echo '<input name="invoice_no" type="text" class="ims_form_control" id="invoice_no" style="width:auto" size="20" maxlength="50" />/<select name="invoice_cat_abr" class="ims_form_control" id="invoice_cat_abr" style="width:auto">';
															foreach ( $cat_array as $cat ) {
																echo '<option value="' . $cat . '">' . $cat . '</option>';
															}
															echo '</select>/<select name="invoice_year" id="invoice_year" class="ims_form_control" style="width:auto"><option value="' . $curr_full_year . '-' . $next_short_year . '" selected="selected">' . $curr_full_year . '-' . $next_short_year . '</option><option value="' . ($curr_full_year - 1) . '-' . ($next_short_year - 1) . '" >' . ($curr_full_year - 1) . '-' . ($next_short_year - 1) . '</option></select>';
														}
													}
												}
											} else {
												$date = date ( 'd' );
												$mon = date ( 'n' );
												$curr_full_year = date ( 'Y' );
												$pre_full_year = date ( 'Y' ) - 1;
												$curr_short_year = date ( 'y' );
												$next_short_year = date ( 'y' ) + 1;

												if ($mon < $financial_year_start_month) {
													echo '<input name="invoice_no" type="text" class="ims_form_control" id="invoice_no" style="width:auto" size="20" maxlength="50" />/<select name="invoice_cat_abr" class="ims_form_control" id="invoice_cat_abr" style="width:auto">';
													foreach ( $cat_array as $cat ) {
														echo '<option value="' . $cat . '">' . $cat . '</option>';
													}
													echo '</select>/<select name="invoice_year" id="invoice_year" class="ims_form_control" style="width:auto"><option value="' . $pre_full_year . '-' . $curr_short_year . '" selected="selected">' . $pre_full_year . '-' . $curr_short_year . '</option><option value="' . ($pre_full_year - 1) . '-' . ($curr_short_year - 1). '" >' . ($pre_full_year - 1) . '-' . ($curr_short_year - 1) . '</option></select>';
												} else {
													/*if ($mon == 3 && $date <= 10) {
                                                        echo '<input name="invoice_no" type="text" class="textbox" id="invoice_no" style="width:auto" size="20" maxlength="50" />/<select name="invoice_cat_abr" id="invoice_cat_abr" style="width:auto">';
                                                        foreach ( $cat_array as $cat ) {
                                                            echo '<option value="' . $cat . '">' . $cat . '</option>';
                                                        }
                                                        echo '</select>/<select name="invoice_year" id="invoice_year" style="width:auto"><option value="' . $pre_full_year . '-' . $curr_short_year . '" selected="selected">' . $pre_full_year . '-' . $curr_short_year . '</option><option value="' . ($pre_full_year - 1) . '-' . ($curr_short_year - 1) . '" >' . ($pre_full_year -1)  . '-' . ($curr_short_year - 1) . '</option></select>';
                                                    } else*/ {
														echo '<input name="invoice_no" type="text" class="ims_form_control" id="invoice_no" style="width:auto" size="20" maxlength="50" />/<select name="invoice_cat_abr" id="invoice_cat_abr" style="width:auto">';
														foreach ( $cat_array as $cat ) {
															echo '<option value="' . $cat . '">' . $cat . '</option>';
														}
														echo '</select>/<select name="invoice_year" class="ims_form_control" id="invoice_year" style="width:auto"><option value="' . $curr_full_year . '-' . $next_short_year . '" selected="selected">' . $curr_full_year . '-' . $next_short_year . '</option><option value="' . ($curr_full_year - 1) . '-' . ($next_short_year - 1) . '" >' . ($curr_full_year - 1) . '-' . ($next_short_year - 1) . '</option></select>';
													}
												}
											}

											?>
										</div>
                                            <div id="webdunia_inc" style="display: none;">
                                            <?php
                                            $cat_array1 = array (
                                                "IADV",
                                                "ILOC",
                                                "IMED",
                                                "ITEC"
                                            );
                                            if ($invoiceDetail->company_id == 2) {
                                                $date = date ( 'd' );
                                                $mon = date ( 'm' );
                                                $curr_full_year = date ( 'Y' );
                                                if($mon == 1 && $date < 10){
                                                    $curr_full_year = $curr_full_year - 1;
                                                }
                                                if ($invoiceDetail->invoice_acceptance_status == "Accept") {
                                                    $invoice_no = (explode ( "/", $invoiceDetail->invoice_no));
                                                    echo '<select name="invoice_year1" id="invoice_year1" class="ims_form_control" style="width:auto"><option value="' . $curr_full_year . '" selected="selected">' . $curr_full_year . '</option><option value="' . ($curr_full_year - 1) . '" >' . ($curr_full_year - 1) . '</option></select>/<select name="invoice_cat_abr1" class="ims_form_control" id="invoice_cat_abr1" style="width:50px"><option value="' . $invoice_no [1] . '" selected="selected">' . $invoice_no [1] . '</option></select>/<select name="invoice_cat_abr2" class="ims_form_control" id="invoice_cat_abr2" style="width:auto">';
                                                    foreach ( $cat_array1 as $cat1 ) {
                                                        if($cat1 == $invoice_no [2]){
                                                            echo '<option value="' . $cat1 . '" selected="selected">' . $cat1 . '</option>';
                                                        }else{
                                                            echo '<option value="' . $cat1 . '">' . $cat1 . '</option>';
                                                        }
                                                    }
                                                    echo '</select><input name="invoice_no1" type="text" class="ims_form_control" id="invoice_no1" style="width:auto" size="20" maxlength="50" value="' . $invoice_no [3] . '"/>';
                                                } else {
                                                    echo '<select name="invoice_year1" id="invoice_year1" class="ims_form_control" style="width:auto"><option value="' . $curr_full_year . '" selected="selected">' . $curr_full_year . '</option><option value="' . ($curr_full_year - 1) . '" >' . ($curr_full_year - 1) . '</option></select>/<select name="invoice_cat_abr1" class="ims_form_control" id="invoice_cat_abr1" style="width:50px"><option value="WI">WI</option></select>/<select name="invoice_cat_abr2" class="ims_form_control" id="invoice_cat_abr2" style="width:auto">';
                                                    foreach ( $cat_array1 as $cat1 ) {
                                                        if($cat1 == $invoice_no [2]){
                                                            echo '<option value="' . $cat1 . '" selected="selected">' . $cat1 . '</option>';
                                                        }else{
                                                            echo '<option value="' . $cat1 . '">' . $cat1 . '</option>';
                                                        }
                                                    }
                                                    echo '</select><input name="invoice_no1" type="text" class="ims_form_control" id="invoice_no1" style="width:auto" size="20" maxlength="50" />';
                                                }
                                            } else {
                                                $date = date ( 'd' );
                                                $mon = date ( 'm' );
                                                $curr_full_year = date ( 'Y' );
                                                if($mon == 1 && $date < 11){
                                                    $curr_full_year = $curr_full_year - 1;
                                                }
                                                echo '<select name="invoice_year1" id="invoice_year1"  class="ims_form_control" style="width:auto"><option value="' . $curr_full_year . '" selected="selected">' . $curr_full_year . '</option><option value="' . ($curr_full_year - 1) . '" >' . ($curr_full_year - 1) . '</option></select>/<select name="invoice_cat_abr1" id="invoice_cat_abr1" class="ims_form_control" style="width:50px"><option value="WI">WI</option></select>/<select name="invoice_cat_abr2" class="ims_form_control" id="invoice_cat_abr2" style="width:auto">';
                                                foreach ( $cat_array1 as $cat1 ) {
                                                    echo '<option value="' . $cat1 . '">' . $cat1 . '</option>';
                                                }
                                                echo '</select><input name="invoice_no1" type="text" class="ims_form_control" id="invoice_no1" style="width:auto" size="20" maxlength="50" />';
                                            }

                                            ?></div>
                                       </div><!--form-group-->
                                </div><!--col-sm-12-->
                            </div><!--row-->
                        </div><!--theme-form-->
                    </div><!--box-form-->
                </div><!--col-sm-4--> 
                <div class="col-sm-4">
                    <div class="box-form">
                        <div class="theme-form">
                            <div class="row">
                                <div class="col-sm-12">
									<label class="ims_form_label">Invoice Date<sup>*</sup></label>
                                    <div class="form-group">
                                        <?php
                                            if ($invoiceDetail->invoice_acceptance_status== "Accept") {
                                                ?>
                                            <input type="text" name="invoice_date" id="invoice_date" value="<?php echo ($invoiceDetail->invoice_date) ? date('d-M-Y', strtotime($invoiceDetail->invoice_date)) : date('d-M-Y'); ?>" class="agreement_date ims_form_control date_icon sel_date"/>

                                        <?php } ?>
                                    </div><!--form-group-->
                                </div><!--col-sm-12-->
                            </div><!--row-->
                        </div><!--theme-form-->
                    </div><!--box-form-->
                </div><!--col-sm-4-->
                <div class="col-sm-3">
                    <div class="box-form">
                        <div class="theme-form">
                            <div class="row">
                                <div class="col-sm-12">
									<label class="ims_form_label">Payment Due Date<sup>*</sup></label>
                                    <div class="form-group">
                                        <?php
                                          if ($invoiceDetail->invoice_acceptance_status== "Accept") {  ?>
                                  <input type="text" name="payment_due_date" id="payment_due_date"  value="<?php echo ($invoiceDetail->payment_due_date) ? date('d-M-Y', strtotime($invoiceDetail->payment_due_date)) : date('d-M-Y') ?>" class="agreement_date ims_form_control date_icon sel_date" value="<?php echo date('d-M-Y') ?>"/>

                                        <?php } ?>
                                    </div><!--form-group-->
                                </div><!--col-sm-12-->
                            </div><!--row-->
                        </div><!--theme-form-->
                    </div><!--box-form-->
                </div><!--col-sm-4-->
                <div class="col-sm-12">
                    <div class="box-form">
                        <div class="theme-form">
                            <div class="row">
                                <div class="col-sm-12">
                                    <!-- <div style="float:right">Invoice Net Amount : &nbsp; &nbsp;<?php echo $invoiceDetail->currency_symbol." ". $invoiceDetail->invoice_net_amount ?></div> -->
                                    <table class="table table-bordered table-inv_detail"  id="service_taxdtl">
                                        <?php
                                        
                                             $tax_row = tax_column_appr ( $invoiceDetail->invoice_req_id, $invoiceDetail->currency_symbol, $invoiceDetail->invoice_net_amount, $invoiceDetail->invoice_gross_amount, $invoiceDetail->company_id );
                                            echo $tax_row;
                                         ?>
                                    </table>

                      <div class="inv_net_amnt" id="convert_amount"><?php
                          if($invoiceDetail->conversion_rate != '0.00') {
                              echo "Convert Amount&nbsp;&nbsp;".formatAmount(round(($invoiceDetail->conversion_rate*$invoiceDetail->invoice_gross_amount),2));
                          }
                          ?></div>

                                </div><!--col-sm-12-->
                            </div><!--row-->
                        </div><!--theme-form-->
                    </div><!--box-form-->
                </div><!--col-sm-12-->
                <div class="col-sm-12">
                    <div class="box-form">
                        <div class="theme-form">
                                <div class="row">
                                    <?php if($invoiceDetail->invoice_currency !='2'){ ?>
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Amount Conversion rate</label>
                                                        <input name="conversion_rate" type="text"
                                                               class="ims_form_control" id="conversion_rate" maxlength="10"  placeholder="Amount Conversion rate"
                                                               onKeyUp="echoConvertAmt();"
                                                               value="<?php echo  ($invoiceDetail->conversion_rate != '0.00') ? $invoiceDetail->conversion_rate :''; ?>" />

                                        </div><!--form-group-->
                                    </div><!--col-sm-3-->
                                    <?php } ?>


                                       <!--<div class="col-sm-3">
                                        <div class="form-group order-attachment-group">
                                             <label class="ims_form_label">Attached Invoice</label>
                                        <?php if ($invoiceDetail ->invoice_acceptance_status == "Accept") ?>
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
                                                <span class="ov_data"><a href="<?php echo base_url();?><?php echo $fileURl; ?>" title="<?php echo $originalName; ?>" target="_blank"><?php echo $originalName ; ?></a></span>
                                            <?php endforeach; ?>


                                          <?php else: ?>
                                            <span class="ov_data">No Attachment</span>
                                        <?php endif; ?>
                                           
                                        </div>
                                    </div>-->


                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Generated Invoice</label>
                                            <?php if($invoiceDetail->invoice_acceptance_status=='Accept'): ?>
                                            <?php $invoice= getGeneratedInvoiceName($invoiceDetail->invoice_no);

                                            ?>
                                                <div class="ims_form_control lh_45 gen_inv_list"><a href="<?php echo base_url();?><?php echo $invoiceDetail->invoice_path; ?>" target="_blank"><?php echo $invoice; ?></a></div>
                                            <?php endif;  ?>
                                           
                                        </div><!--form-group-->
                                    </div><!--col-sm-3-->


                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Service Category</label>
                                           <?php
                                            if ($invoiceDetail->invoice_acceptance_status== "Accept") {
                                                ?>
                                                <select class="ims_form_control" name="service_category" id="service_category" >
                                                <option value="" >Service Category*</option>
                                                <?php foreach($servicesubcategories as $rows) { ?>
                                                    <?php  if($invoiceDetail->service_category == $rows->id) {?>

                                                        <option selected value="<?php echo $rows->id; ?>"><?php echo ucfirst($rows->category_name)?></option>
                                                    <?php } else{?>
                                                        <option value="<?php echo $rows->id?>"><?php echo ucfirst($rows->category_name)?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                                </select><?php } ?>


                                        </div><!--form-group-->
                                    </div><!--col-sm-3-->
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Select Currency for Bank Detail</label>
                                               <?php
                                            if ($invoiceDetail->invoice_acceptance_status== "Accept") {
                                                ?>
                                                <select class="ims_form_control" name="currency" id="currency" >
                                                <option value="" >Select Currency for Bank Detail</option>
                                                <?php foreach($companyBankDetails as $rows) { ?>
                                                    <?php  if($invoiceDetail->currncytype == $rows->id) {?>

                                                        <option selected value="<?php echo $rows->id; ?>"><?php echo ucfirst($rows->currency)?></option>
                                                    <?php } else{?>
                                                        <option value="<?php echo $rows->id?>"><?php echo ucfirst($rows->currency)?></option>
                                                    <?php } ?>
                                                <?php } ?>
                                                </select><?php } ?>


                                        </div><!--form-group-->
                                    </div><!--col-sm-3-->
									<div class="col-sm-12">
                                        <div class="form-group order-attachment-group">
											<label class="ims_form_label">Attached Invoice</label>
                                        <?php if ($invoiceDetail ->invoice_acceptance_status == "Accept") ?>
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
                                                <span class="attach-list_inline"><a href="<?php echo base_url();?><?php echo $fileURl; ?>" title="<?php echo $originalName; ?>" target="_blank"><?php echo wordwrap($originalName,30, '<br />', true); ?></a></span>
                                            <?php endforeach; ?>


                                          <?php else: ?>
                                            <span class="attach-list_inline">No Attachment</span>
                                        <?php endif; ?>
                                           
                                        </div><!--form-group-->
                                    </div><!--col-sm-3-->
									<div class="clearfix"></div>
                                    <div class="col-sm-7">
                                        <div class="form-group">
											<label class="ims_form_label">Comments</label>
                                            <?php
                                            if ($invoiceDetail->invoice_acceptance_status == "Accept") { ?>
                                                <textarea class="ims_form_control"  name="invoice_gen_comments" placeholder="Comments*"  id="invoice_gen_comments" cols="100" rows="5"><?php echo $invoiceDetail->invoice_generator_comments; ?></textarea>
                                           
                                          <?php   }  ?>
                                          
                                      </div>
                                        </div>
                                    <div class="col-sm-5">
                                        <div class="form-group">
											<label class="ims_form_label">WD Bank Account Detail</label>
                                            <textarea class="ims_form_control" cols="50" rows="5" name="bank_details" placeholder="WD Bank Account Detail"  id="bank_details"><?php echo strip_tags($invoiceDetail->bank_detail); ?></textarea>
                                        </div><!--form-group-->
                                    </div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
											<label class="ims_form_label">Approval Comments</label>
                                            <?php if($invoiceDetail->invoice_acceptance_status == "Accept"){ ?>
                                           

                                                <textarea class="ims_form_control" rows="5" cols='100' name="approval_comments" placeholder="Approval Comments*" value="<?php echo $invoiceDetail->gen_approval_comment ?>" id="approval_comments"></textarea>
                                            <?php } ?>
                                              <span class="error" id="error_msg" style="color:red"></span>

                                        </div><!--form-group-->
                                    </div><!--col-sm-6-->
                                  <!--col-sm-12-->
                            </div><!--row-->
                        </div><!--theme-form-->

<div id = "rejectChoices" style="display: none;">

    <div class="radio-inline radio">
                                        <?php
                                        echo '<input type="radio" name="rejectTo" id="originatorReject" value="Originator">   
                                        <label for="originatorReject">Reject To Requestor</label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<input type="radio" name="rejectTo"  id ="generatorReject" value="Generator">   <label for="generatorReject">Reject To Generator </label><br>';
                                        ?>
               </div>
                    </div>
                       
                 </div><!--box-form-->
                </div><!--col-sm-12-->
				<div class="col-sm-12">
					<div class="form-footer">
						<input type="submit" id="submit3" name="submit3" value="Accept Invoice"  class="btn-theme ml10 btn-submit mdl-js-button mdl-js-ripple-effect ripple-white" />
						<input
						type="button" name="submit5" class="btn-theme ml10 btn-submit mdl-js-button mdl-js-ripple-effect ripple-white" id="submit5"
						value="Preview"    disabled="disabled" />
						<!--<input type="checkbox" id="edit" value="edit" name="edit" onClick="enable_form();">
						<label for="inlineRadio3"> Update Invoice</label>-->
						<div class="checkbox mlr_10 checkbox-inline">
							<input type="checkbox" id="edit" value="edit" name="edit" onClick="enable_form();">
							<label for="edit"> Update Invoice</label>
						</div>
						
						<input type="button" id="submit4" name="submit4" value="Reject Invoice" class="btn-theme btn-red ml10 mdl-js-button mdl-js-ripple-effect ripple-white" onClick="return reject_submit()" />
					</div>
				</div>
         </div><!--row-->
        </form>
    </div><!--inner_bg-->

    <script>
        var FromEndDate = new Date();
        var POCAl = $("#po_date").datepicker({format: "dd-M-yyyy", autoclose: true, startDate: '-1y',endDate: FromEndDate}).on('show.bs.modal', function(event) {
            // prevent datepicker from firing bootstrap modal "show.bs.modal"
            event.stopPropagation();
        }).on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });
        $("#po_date").datepicker('remove');

        $("#invoice_date").datepicker({format: "dd-M-yyyy", autoclose: true, startDate: '-1y',endDate: '+1m'}).on('show.bs.modal', function(event) {
            // prevent datepicker from firing bootstrap modal "show.bs.modal"
            event.stopPropagation();
        }).on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });

        $("#payment_due_date").datepicker({format: "dd-M-yyyy", autoclose: true, startDate: '-1m',endDate: '+6m'}).on('show.bs.modal', function(event) {
            // prevent datepicker from firing bootstrap modal "show.bs.modal"
            event.stopPropagation();
        }).on('changeDate', function (ev) {
            $(this).datepicker('hide');
        });


        $(document).on('click', '.file-upload-button', function () {
            $(this).parent().find("input[type='file']").click();
        });

        $(document).on('change', '.custom-file-upload-hidden', function () {
            var fileID = $(this).attr('id');
            var filename = $("#" + fileID).val().split('\\').pop();
            $("#" + fileID).parent().find(".file-upload-input").val(filename);
            $("#"+fileID).parent().find(".file-upload-input").blur();
        });

        /*Client side validations*/
        $("#generate-invoice").validate({

            rules: {
                project_title: {required: true},
                po_no: {required: true},
                invoice_no : {required: true},
                invoice_no1 : {required: true},
                invoice_date: {required: true},
                payment_due_date: {required: true},
                invoice_gen_comments: {required: true},
                approval_comments: {required: true},
                service_category: {required: true},
                //currency:{required: true},
                //bank_details:{required: true},
                conversion_rate: {number:true},
                payment_term: {required:true}
            },
            messages: {

                project_title: {required: "This field is required "},
                po_no: {required: "This field is required"},
                invoice_no : {required: "This field is required"},
                invoice_no1 : {required: "This field is required"},
                invoice_date: {required: "This field is required"},
                payment_due_date: "This field is required",
                invoice_gen_comments: {required: "This field is required"},
                approval_comments: {required: "This field is required"},
                service_category: {required: "This field is required"},
                //currency:{required: "This field is required"},
                //bank_details:{required: "This field is required"},
                conversion_rate: {number:"The field should contain a numeric value"},
                payment_term: {required:"This field is required"}

            },
            submitHandler: function(form) {

            var disabled = false;

            if ($('input[name="edit"]:checked').length>0) {

                $('.loader-wrapper').show()
               $.post( BASEURL+"invoice/approve_invoice", $("#generate-invoice").serialize(),function(data){
                  data = $.parseJSON(data);

                    if(data.error == 0){
                        window.location.href=BASEURL+"dashboard";
                    }else{
                        $('.loader-wrapper').hide();
                        $("#msg").html('<div class="alert alert-danger" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+data.message+'</div>');
                        window.setTimeout(function() {
                        $(".alert").fadeTo(5000, 0).slideUp(5000, function(){
                        $(this).remove(); 
                        });
                        $('html, body').animate({
                         scrollTop: $("#msg").offset().top
                        },1);
                        }, 2000);
                    } 

                });
           }
           else{
               //alert($("#wd_sales_id").val());
               var wd_sales_id = $("#wd_sales_id").val();
               var cmp_id = $('input[name=cmp]:checked').val();
               var project_title = $('#project_title').val();
               var payment_term = $('#payment_term').val();
                $('.loader-wrapper').show()
               $.post( BASEURL+"invoice/approve_invoice", $("#generate-invoice").serialize()+"&wd_sales_id="+wd_sales_id+"&cmp="+cmp_id+"&project_title="+project_title+"&payment_term="+payment_term,function(data){
                  data = $.parseJSON(data);

                    if(data.error == 0){
                        window.location.href=BASEURL+"dashboard";
                    }else{
                        $('.loader-wrapper').hide();
                        $("#msg").html('<div class="alert alert-danger" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+data.message+'</div>');
                        window.setTimeout(function() {
                        $(".alert").fadeTo(500, 0).slideUp(500, function(){
                        $(this).remove(); 
                        });
                        $('html, body').animate({
                         scrollTop: $("#msg").offset().top
                        },1);
                        }, 2000);
                    }

                });
           }

                //$(form).ajaxSubmit();
            }
        });


        $(document).on('click',"#submit5",function(){

            if($("#generate-invoice").valid()){
                $.ajax({
                type: "POST",
                url: BASEURL+"invoice/previewInvoice",
                data: $("#generate-invoice").serialize()+"&approver=Y",
                dataType:'json',
                success: function (response) {
                    if(response.error){
                    $("#msg").html('<div class="alert alert-danger" style="margin-top:18px;"><a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>'+data.message+'</div>');
                    } else{
                    window.open(response.path, '_blank');
                    }
                },
                error: function (error) {
                    console.log(error);
                    return;
                },
            });
            }
        

        });


        //$.post( BASEURL+"invoice/approve_invoice", $("#generate-invoice").serialize());

        /*
         *  getBankDetailsByCuurencyId
         * @purpose - To get  Bankdetails according to currency selected..
         * @Date - 23/02/2018
         * @author - NJ
         */
        $("#currency").on('change',function(){
            var currencyId = $(this).val();
            var company = $("input:radio[name='cmp']:checked").val();
            company = company.split("^##^");
            if(currencyId =='') {
                return;
            }
            $.ajax({
                type: "POST",
                url: BASEURL+"invoice/getBankDetailsById",
                dataType: 'json',
                data: {currencyId:currencyId,company_id:company[0]},
                beforeSend: function() {
                    // setting a timeout
                    $('.loader-wrapper').show()
                },
                success: function (response) {
                    if(response != 0) {
                        populateBankDetails(response);
                    }
                },
                error: function (error) {
                    alert("There is an error while getting record. Please try again");
                    return;
                },
                complete: function() {
                    $('.loader-wrapper').hide();
                },
            });

        });

        /*
         * Reset Button
         * @purpose - To reset form.
         * @Date - 23/02/2018
         * @author - NJ
         */

        function reset_form() {
            $("#invoice_no").disabled = false;
            $("#invoice_date").disabled = false;
            $("#payment_due_date").disabled = false;
            $("#invoice_no").value = "";
            $("#invoice_no1").value = "";
            $("#invoice_date").value = "";
            $("#payment_due_date").value = "";
            $("#attachment1").value = "";
            $('#service_category').selectedIndex = "--Service Category--";
            $("#invoice_gen_comments").value = ""
            $("#currency").selectedIndex = "Currency";
            $("#bank_details").html("");
            return false;
        }
        /*
         * generateInvoiceByCompany
         * @purpose - To show/hide div's based on company.
         * @Date - 23/02/2018
         * @author - NJ
         */
        function generateInvoiceByCompany(status, cmp_id) {

            if (cmp_id == 1) {
                $("#webdunia_inc").slideUp("fast");
                $("#webdunia_com").slideDown("fast");
            } else if (cmp_id == 2) {
                $("#webdunia_com").slideUp("fast");
                $("#webdunia_inc").slideDown("fast");
            }
            if (status == "approver") {
                var status = 'invoiceapprover';
                $("#company_invoice").slideUp("fast");
            } else {
                var status = 'invoicegenerator';
            }
            var invoice_id = $("#invoice_id").val();

            var dataString = 'invoice_id=' + invoice_id + '&getcurrency=Y&company_id=' + cmp_id + '&status=' + status;
            $.ajax({
                type : "POST",
                url: BASEURL+"invoice/getBankDetailsByCurrency",
                data : dataString,
                cache : false,
                beforeSend : function() {

                },
                success : function(str) {
                   // alert(str);
                    $('#currency').html(str);
                    $("#bank_details").val('');
                    $("#currency").trigger("change");//wanna repopulate bank details
                   // getBankDtl($("#currency").val());
                }
            });

            var dataString = 'invoice_id=' + invoice_id + '&company_id=' + cmp_id + '&status=' + status;
            $.ajax({

                type : "POST",
                url: BASEURL+"invoice/service_taxdtl",
                data : dataString,
                cache : false,
                beforeSend : function() {

                },
                success : function(str) {
                    $('#service_taxdtl').html(str);
                    if ($("#edit").length > 0 && $("#edit").prop("checked")) {
                        if($("#invoice_cmp_id").val() == cmp_id){
                            enable_form();
                        }
                    }
                }
            });
        }


function taxcalculation_appr(count, include_status, net_amt, curr) {
    if (include_status == 'N') {
        var taxcount = document.getElementById("taxcount").value;
        taxcount = (taxcount - 1);

        var tax = "tax" + count;
        var value = document.getElementById(tax).value;
        var amount = net_amt * (value / 100);
        amount = (Math.round(amount * 100) / 100);
        var display_amt = "display_amt" + count;
        document.getElementById(display_amt).innerHTML = curr + " " + amount;
        var taxamt = "taxamt" + count;
        document.getElementById(taxamt).value = amount;
        var total_includetax = 0;
        for (var i = (count + 1); i <= (taxcount - 1); i++) {
            var tax = "tax" + i;
            var val = document.getElementById(tax).value;
            total_includetax = (parseFloat(total_includetax) + parseFloat(val));
            var amount = net_amt * (value * val / 10000);
            amount = (Math.round(amount * 100) / 100);

            var display_amt = "display_amt" + i;
            document.getElementById(display_amt).innerHTML = curr + " " + amount;
            var taxamt = "taxamt" + i;
            document.getElementById(taxamt).value = amount;
        }

        var total_tax = "tax" + taxcount;
        value2 = (parseInt(value) + ((parseInt(value) * parseInt(total_includetax)) / 100));
        document.getElementById(total_tax).value = value2;

        var total_taxamt = "taxamt" + taxcount;
        value3 = (parseFloat(net_amt) * (parseFloat(value2) / 100));
        value3 = (Math.round(value3 * 100) / 100);
        document.getElementById(total_taxamt).value = value3;

        var display_taxamt = "display_amt" + taxcount;
        value3 = (Math.round(value3 * 100) / 100);
        document.getElementById(display_taxamt).innerHTML = curr + " " + value3;

        var grossamt = document.getElementById("grossamt").value;
        value4 = (parseFloat(net_amt) + value3);
        document.getElementById("grossamt").value = value4;

        var display_grossamt = document.getElementById("display_grossamt");
        value4 = (Math.round(value4 * 100) / 100);
        display_grossamt.innerHTML = curr + " " + value4;
    } else {
        var taxcount = document.getElementById("taxcount").value;
        taxcount = (taxcount - 1);
        if (count != taxcount) {
            var service_tax = document.getElementById("tax1").value;

            var tax = "tax" + count;
            var value = document.getElementById(tax).value;
            var amount = parseFloat(net_amt) * ((parseFloat(service_tax) * parseFloat(value)) / 10000);
            amount = (Math.round(amount * 100) / 100);

            var display_amt = "display_amt" + count;
            document.getElementById(display_amt).innerHTML = curr + " " + amount;
            var taxamt = "taxamt" + count;
            document.getElementById(taxamt).value = amount;

            var total_tax = "tax" + taxcount;
            var total_tax = document.getElementById(total_tax).value;
            var value2 = 0;
            if (count == (taxcount - 1)) {
                for (var i = count; i >= (taxcount - 2); i--) {
                    var tax = "tax" + i;
                    var val = document.getElementById(tax).value;
                    value2 = value2 + (parseInt(service_tax) * (parseInt(val) / 100));
                }
            } else {
                for (var i = count; i <= (taxcount - 1); i++) {
                    var tax = "tax" + i;
                    var val = document.getElementById(tax).value;
                    value2 = value2 + (parseInt(service_tax) * (parseInt(val) / 100));
                }
            }
            var total_tax = "tax" + taxcount;
            value2 = (parseFloat(service_tax) + parseFloat(value2));
            document.getElementById(total_tax).value = value2;

            var total_taxamt = "taxamt" + taxcount;
            value3 = (parseFloat(net_amt) * (parseFloat(value2) / 100));
            document.getElementById(total_taxamt).value = value3;

            var display_taxamt = "display_amt" + taxcount;
            value3 = (Math.round(value3 * 100) / 100);
            document.getElementById(display_taxamt).innerHTML = curr + " " + value3;

            var grossamt = document.getElementById("grossamt").value;
            value4 = (parseFloat(net_amt) + value3);
            document.getElementById("grossamt").value = value4;

            var display_grossamt = document.getElementById("display_grossamt");
            value4 = (Math.round(value4 * 100) / 100);
            display_grossamt.innerHTML = curr + " " + value4;
        }
    }
}


        function enable_form() {
            if ($("#edit").prop("checked")) {

                $('input[name="cmp"][type="radio"]').each(function () {
                    $(this).prop("disabled", false);
                });
                $("#update_invoice").show();
                $("#generate_invoice").hide();
                $("#wd_sales_id").prop("disabled", false);
                $("#project_title").prop("readonly",false);

                $("#po_no").prop("readonly",false);
                $("#company_invoice").slideUp("fast");
                $("#po_date").prop("readonly",false);

                var POCAl = $("#po_date").datepicker({format: "dd-M-yyyy", autoclose: true, startDate: '-1y',endDate: FromEndDate}).on('show.bs.modal', function(event) {
                    // prevent datepicker from firing bootstrap modal "show.bs.modal"
                    event.stopPropagation();
                }).on('changeDate', function (ev) {
                    $(this).datepicker('hide');
                });
                $("#payment_term").prop("disabled", false);
                $("#invoice_date").prop("readonly",false);
                $("#pymt_due_date").prop("readonly",false);
                $("#invoice_gen_comments").prop("readonly",false);
                $("#changeedit").show();
                $("#submit3").val('');
                $("#submit3").val("Update Invoice & Approve");
                $("#submit5").prop("disabled", false);
                $("#submit5").prop("disabled", false);


                var company = $("input:radio[name='cmp']:checked").val();
                company = company.split("^##^");
                var company_id = company[0];
                var include_tax = company[1];

                if (company_id == 1) {
                    $("#webdunia_inc").slideUp("fast");
                    $("#webdunia_com").slideDown("fast");
                } else if (company_id == 2) {
                    $("#webdunia_com").slideUp("fast");
                    $("#webdunia_inc").slideDown("fast");
                }

                var taxcount = $("#taxcount").val();

                var display_netamt = $("#display_netamt").html();
                var display_netamt1 = display_netamt.split(" ");
                var curr = display_netamt1[0];
                var net_amt = display_netamt1[1];

                for (var i = 1; i < taxcount; i++) {
                    var includestatus = "#includestatus" + i;
                    var taxdtl = "#taxdtl" + i;
                    var hiddentax = "#hiddentax" + i;
                    var tax="#tax"+i;

                    var value1 = $(includestatus).val();
                    var value2 = $(taxdtl).val();
                    var value3 = $(hiddentax).val();

                    var display_tax = "#display_tax" + i;
                    $(tax).remove();
                    console.log(value2);
                    if (value1 == 'N' || value1 == '') {
                        $(display_tax).html(value2 + ' : &nbsp;<input name="tax' + i + '" type="text" size="5" id="tax' + i + '" maxlength="6" onKeyPress="return numeralsOnly(event)" onkeyup="taxcalculation_appr(' + i + ',\'' + value1 + '\',' + net_amt + ',\'' + curr + '\')" value="' + value3 + '" />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;');
                    } else {
                        $(display_tax).html(value2 + ' : &nbsp;<input name="tax' + i + '" type="text" size="5" id="tax' + i + '" maxlength="6" onKeyPress="return numeralsOnly(event)" onkeyup="taxcalculation_appr(' + i + ',\'' + value1 + '\',' + net_amt + ',\'' + curr + '\')" value="' + value3 + '" />&nbsp;of ST&nbsp;');
                    }
                }
            } else {
                 var invoice_id = $("#invoice_id").val();
                 $.ajax({
                    type: "POST",
                    url: BASEURL+"invoice/getInvoiceDetailsById",
                    data: {invoice_id: invoice_id},
                    dataType: 'json',
                     success: function (res) {
                                //console.log(res);
                                $("#wd_sales_id").val(res.salespersonid);
                                $("#payment_term").val(res.payment_term);
                                $("#project_title").val(res.project_name);
                                $("#po_no").val(res.po_no);
                                var cmp = $("#invoice_cmp_id").val();
                                $("#cmp_"+cmp).prop("checked",true).trigger("click");;
                                $('input[name="cmp"][type="radio"]').each(function () {
                                    $(this).prop("disabled", true);
                                });
                                $("#generate_invoice").show();
                                $("#update_invoice").hide();
                                $("#wd_sales_id").prop("disabled", true);
                                $("#project_title").prop("readonly",true);
                                $("#po_no").prop("readonly",true);
                                 $("#po_date").datepicker('remove');
                                $("#webdunia_inc").slideUp("fast");
                                $("#webdunia_com").slideUp("fast");
                                $("#company_invoice").slideDown("fast");
                                $("#po_date").prop("readonly",true);
                                $("#payment_term").prop("disabled", true);
                                $("#invoice_date").prop("readonly",true);
                                $("#pymt_due_date").prop("readonly",true);
                                $("#invoice_gen_comments").prop("readonly",true);
                                $("#changeedit").hide();
                                $("#submit3").val("");
                                $("#submit3").val("Accept Invoice");
                                $("#submit5").prop("disabled", true);

                                var tax_currncy = $("#tax_currency").val();
                                var grossamt_org = $("#grossamt_org").val();

                                var taxcount = $("#taxcount").val();
                                for (var i = 1; i < taxcount; i++) {
                                    var includestatus = "#includestatus" + i;
                                    var taxdtl = "#taxdtl" + i;
                                    var hiddentax = "#hiddentax" + i;
                                    var taxamt = "#taxamt"+i
                                    var org_taxamt = "#org_taxamt"+i;
                                    var display_amt = "#display_amt"+i;

                                    var value1 = $(includestatus).val();
                                    var value2 = $(taxdtl).val();
                                    var value3 = $(hiddentax).val();
                                    var value4 = $(taxamt).val();
                                    var value5 = $(org_taxamt).val();
                                    console.log(value3);
                                    console.log($(taxamt).val());

                                    var display_tax = "#display_tax" + i;
                                    if (value1 == 'N' || value1 == '') {
                                        $(display_tax).html(value2 + ' : &nbsp;' + value3);
                                    } else {
                                        $(display_tax).html(value2 + ' : &nbsp;' + value3 + '&nbsp;of ST&nbsp;');
                                    }
                                    $(display_tax).append('<input name="tax' + i + '" type="hidden" id="tax' + i + '" value="' + value3 + '" />');
                                    $(taxamt).val(value5);
                                    $(display_amt).html(tax_currncy+" "+value5);


                                }
                                 $("#grossamt").val(grossamt_org);
                                 $("#display_grossamt").html(tax_currncy+" "+grossamt_org);
                                },
                    error: function (error) {
                                    alert("error");
                                    return;
                                }
                    
                                
                });
                
            }
            return false;
        }

        /*
         * reject_submit
         * @purpose - To reject Invoice.
         * @Date - 23/02/2018
         * @author - NJ
         */
        function reject_submit() {

              if($("#rejectChoices").is(":hidden")){
                    $("#rejectChoices").show();
                    $('input[name=rejectTo]').attr('checked',false);
                    return false;
                }
                else if ($("#approval_comments").val() == "") {
              $("#error_msg").html("Please enter Rejection Remarks in the Approval Comments section !!");

                   $("#approval_comments").focus();
                    return false;
                }
                else if(!$("input[name='rejectTo']:checked").val()){
                    alert("Please select whom you want to reject the invoice!!");
                    $("#originatorReject").focus();
                    return false;
                }
             else {
                bootbox.confirm({
                    title: "Reject Invoice?",
                    message: "Are you want to reject the Invoice?",
                    buttons: {
                        cancel: {
                            label: '<i class="fa fa-times"></i> Cancel'
                        },
                        confirm: {
                            label: '<i class="fa fa-check"></i> Confirm'
                        }

                    },
                    callback: function (result) {
                        if (result==true) {
                            var generatorcomment = $('#invoice_gen_comments').val();
                            var approvalcomment= $('#approval_comments').val();
                            var category= $("#category_id").val();
                            var rejectTo = $("input[name='rejectTo']:checked"). val();
                            $.ajax({
                                type: "POST",
                                url: BASEURL+"invoice/approvarReject",
                                data: {Id: <?php echo $invoiceDetail->invoice_req_id; ?>, comment:generatorcomment,Approvalcomment:approvalcomment,RejectTo:rejectTo,Category:category},
                                beforeSend: function() {
                                    $('.loader-wrapper').show()
                                },
                                success: function (res) {
                                    $('.loader-wrapper').hide();
                                    if(res) {
                                        var data = JSON.parse(res);
                                        if(data.success == '1') {
                                            window.location.href = BASEURL+"dashboard";
                                            $("#success_msg").html(data.message);
                                        } else if(data.success == '0') {
                                            //$("#error_msg").html("There is an error while rejecting invoice.");
                                            window.location.href = BASEURL+"dashboard";
                                        }
                                    } else {
                                        window.location.href = BASEURL+"dashboard";
                                        //$("#error_msg").html("There is an error while rejecting invoice.");
                                    }

                                },
                                error: function (error) {
                                    alert("error");
                                    return;
                                },
                                complete: function() {
                                    $('.loader-wrapper').hide();
                                },
                            });
                        }
                    }
                });

            }
        }
        /*
         * populateBankDetails
         * @purpose - populate BankDetails based on currency.
         * @Date - 23/02/2018
         * @author - NJ
         */
        function populateBankDetails(response) {
            if(response.bankDetails.length > 0) {
                var bankDetailsOptions = response.bankDetails[0].bank_details;
                console.log(bankDetailsOptions);
                $("#bank_details").val('');
                $("#bank_details").val(bankDetailsOptions);
            }
        }

        function taxcalculation_gen(count, include_status, net_amt, curr) {
            if (include_status == 'N') {
                var taxcount = document.getElementById("taxcount").value;
                taxcount = (taxcount - 1);

                var tax = "tax" + count;
                var value = document.getElementById(tax).value;
                var amount = net_amt * (value / 100);
                amount = (Math.round(amount * 100) / 100);
                var display_amt = "display_amt" + count;
                document.getElementById(display_amt).innerHTML = curr + " " + amount;
                var taxamt = "taxamt" + count;
                document.getElementById(taxamt).value = amount;
                var total_includetax = 0;
                for (var i = (count + 1); i <= taxcount; i++) {
                    var tax = "tax" + i;
                    var val = document.getElementById(tax).value;
                    total_includetax = (parseFloat(total_includetax) + parseFloat(val));
                    var amount = net_amt * (value * val / 10000);
                    amount = (Math.round(amount * 100) / 100);

                    var display_amt = "display_amt" + i;
                    document.getElementById(display_amt).innerHTML = curr + " " + amount;
                    var taxamt = "taxamt" + i;
                    document.getElementById(taxamt).value = amount;
                }
                var service_tax = document.getElementById("service_tax").value;
                if (service_tax > value) {
                    value1 = (service_tax - value);
                    service_tax = (parseInt(service_tax) - parseInt(value1));
                    document.getElementById("service_tax").value = service_tax;
                } else {
                    value1 = (value - service_tax);
                    service_tax = (parseInt(service_tax) + parseInt(value1));
                    document.getElementById("service_tax").value = service_tax;
                }

                var include_tax = document.getElementById("include_tax").value;
                include_tax = total_includetax;
                var total_tax = document.getElementById("total_tax").value;
                value2 = (parseInt(service_tax) + ((parseInt(service_tax) * parseInt(include_tax)) / 100));
                document.getElementById("total_tax").value = value2;


                var total_taxamt = document.getElementById("total_taxamt").value;
                value3 = (parseFloat(net_amt) * (parseFloat(value2) / 100));
                value3 = (Math.round(value3 * 100) / 100);
                document.getElementById("total_taxamt").value = value3;

                var display_taxamt = document.getElementById("display_taxamt");
                value3 = (Math.round(value3 * 100) / 100);
                display_taxamt.innerHTML = curr + " " + value3;


                var grossamt = document.getElementById("grossamt").value;
                value4 = (parseFloat(net_amt) + value3);
                document.getElementById("grossamt").value = value4;

                var display_grossamt = document.getElementById("display_grossamt");
                value4 = (Math.round(value4 * 100) / 100);
                display_grossamt.innerHTML = curr + " " + value4;

            } else {
                var taxcount = document.getElementById("taxcount").value;
                taxcount = (taxcount - 1);
                var service_tax = document.getElementById("service_tax").value;

                var tax = "tax" + count;
                var value = document.getElementById(tax).value;
                var amount = parseFloat(net_amt) * ((parseFloat(service_tax) * parseFloat(value)) / 10000);
                amount = (Math.round(amount * 100) / 100);

                var display_amt = "display_amt" + count;
                document.getElementById(display_amt).innerHTML = curr + " " + amount;
                var taxamt = "taxamt" + count;
                document.getElementById(taxamt).value = amount;

                var total_tax = document.getElementById("total_tax").value;
                var value2 = 0;
                if (count == taxcount) {
                    for (var i = count; i >= (taxcount - 1); i--) {
                        var tax = "tax" + i;
                        var val = document.getElementById(tax).value;
                        value2 = value2 + (parseInt(service_tax) * (parseInt(val) / 100));
                    }
                } else {
                    for (var i = count; i <= taxcount; i++) {
                        var tax = "tax" + i;
                        var val = document.getElementById(tax).value;
                        value2 = value2 + (parseInt(service_tax) * (parseInt(val) / 100));
                    }
                }
                value2 = (parseFloat(service_tax) + parseFloat(value2));
                document.getElementById("total_tax").value = value2;

                var total_taxamt = document.getElementById("total_taxamt").value;
                value3 = (parseFloat(net_amt) * (parseFloat(value2) / 100));
                document.getElementById("total_taxamt").value = value3;

                var display_taxamt = document.getElementById("display_taxamt");
                value3 = (Math.round(value3 * 100) / 100);
                display_taxamt.innerHTML = curr + " " + value3;

                var grossamt = document.getElementById("grossamt").value;
                value4 = (parseFloat(net_amt) + value3);
                document.getElementById("grossamt").value = value4;

                var display_grossamt = document.getElementById("display_grossamt");
                value4 = (Math.round(value4 * 100) / 100);
                display_grossamt.innerHTML = curr + " " + value4;
            }
        }

        function pad_with_zeros(rounded_value, decimal_places) {

            // Convert the number to a string
            var value_string = rounded_value.toString()

            // Locate the decimal point
            var decimal_location = value_string.indexOf(".")

            // Is there a decimal point?
            if (decimal_location == -1) {

                // If no, then all decimal places will be padded with 0s
                decimal_part_length = 0

                // If decimal_places is greater than zero, tack on a decimal point
                value_string += decimal_places > 0 ? "." : ""
            } else {

                // If yes, then only the extra decimal places will be padded with 0s
                decimal_part_length = value_string.length - decimal_location - 1
            }

            // Calculate the number of decimal places that need to be padded with 0s
            var pad_total = decimal_places - decimal_part_length

            if (pad_total > 0) {

                // Pad the string with 0s
                for (var counter = 1; counter <= pad_total; counter++)
                    value_string += "0"
            }
            return value_string
        }



        function round_decimals(original_number, decimals) {
            var result1 = original_number * Math.pow(10, decimals)
            var result2 = Math.round(result1)
            var result3 = result2 / Math.pow(10, decimals)
            return pad_with_zeros(result3, decimals)
        }

        function echoConvertAmt() {
            var conver_amt = document.getElementById("conversion_rate").value;
            var amount = document.getElementById("grossamt").value;
            conver_amt1 = parseFloat(conver_amt);
            amount = parseFloat(amount);
            var convertamount = (conver_amt1 * amount);
            if (conver_amt == "")
                document.getElementById("convert_amount").innerHTML = '';
            else
                document.getElementById("convert_amount").innerHTML = 'Convert Amount&nbsp;&nbsp;' + round_decimals(convertamount, 2);
        }

        function numeralsOnly(evt) {
            evt = (evt) ? evt : event;
            var charCode = (evt.charCode) ? evt.charCode : ((evt.keyCode) ? evt.keyCode : ((evt.which) ? evt.which : 0));
            if (charCode > 31 && (charCode < 46 || charCode > 57 || charCode == 47)) {
                alert("Only numerals allowed in the field.");
                return false;
            }
            return true;
        }

        function taxcalculation_appr(count, include_status, net_amt, curr) {
            if (include_status == 'N') {
                var taxcount = document.getElementById("taxcount").value;
                taxcount = (taxcount - 1);

                var tax = "tax" + count;
                var value = document.getElementById(tax).value;
                var amount = net_amt * (value / 100);
                amount = (Math.round(amount * 100) / 100);
                var display_amt = "display_amt" + count;
                document.getElementById(display_amt).innerHTML = curr + " " + amount;
                var taxamt = "taxamt" + count;
                document.getElementById(taxamt).value = amount;
                var total_includetax = 0;
                for (var i = (count + 1); i <= (taxcount - 1); i++) {
                    var tax = "tax" + i;
                    var val = document.getElementById(tax).value;
                    total_includetax = (parseFloat(total_includetax) + parseFloat(val));
                    var amount = net_amt * (value * val / 10000);
                    amount = (Math.round(amount * 100) / 100);

                    var display_amt = "display_amt" + i;
                    document.getElementById(display_amt).innerHTML = curr + " " + amount;
                    var taxamt = "taxamt" + i;
                    document.getElementById(taxamt).value = amount;
                }

                var total_tax = "tax" + taxcount;
                value2 = (parseInt(value) + ((parseInt(value) * parseInt(total_includetax)) / 100));
                document.getElementById(total_tax).value = value2;

                var total_taxamt = "taxamt" + taxcount;
                value3 = (parseFloat(net_amt) * (parseFloat(value2) / 100));
                value3 = (Math.round(value3 * 100) / 100);
                document.getElementById(total_taxamt).value = value3;

                var display_taxamt = "display_amt" + taxcount;
                value3 = (Math.round(value3 * 100) / 100);
                document.getElementById(display_taxamt).innerHTML = curr + " " + value3;

                var grossamt = document.getElementById("grossamt").value;
                value4 = (parseFloat(net_amt) + value3);
                document.getElementById("grossamt").value = value4;

                var display_grossamt = document.getElementById("display_grossamt");
                value4 = (Math.round(value4 * 100) / 100);
                display_grossamt.innerHTML = curr + " " + value4;
            } else {
                var taxcount = document.getElementById("taxcount").value;
                taxcount = (taxcount - 1);
                if (count != taxcount) {
                    var service_tax = document.getElementById("tax1").value;

                    var tax = "tax" + count;
                    var value = document.getElementById(tax).value;
                    var amount = parseFloat(net_amt) * ((parseFloat(service_tax) * parseFloat(value)) / 10000);
                    amount = (Math.round(amount * 100) / 100);

                    var display_amt = "display_amt" + count;
                    document.getElementById(display_amt).innerHTML = curr + " " + amount;
                    var taxamt = "taxamt" + count;
                    document.getElementById(taxamt).value = amount;

                    var total_tax = "tax" + taxcount;
                    var total_tax = document.getElementById(total_tax).value;
                    var value2 = 0;
                    if (count == (taxcount - 1)) {
                        for (var i = count; i >= (taxcount - 2); i--) {
                            var tax = "tax" + i;
                            var val = document.getElementById(tax).value;
                            value2 = value2 + (parseInt(service_tax) * (parseInt(val) / 100));
                        }
                    } else {
                        for (var i = count; i <= (taxcount - 1); i++) {
                            var tax = "tax" + i;
                            var val = document.getElementById(tax).value;
                            value2 = value2 + (parseInt(service_tax) * (parseInt(val) / 100));
                        }
                    }
                    var total_tax = "tax" + taxcount;
                    value2 = (parseFloat(service_tax) + parseFloat(value2));
                    document.getElementById(total_tax).value = value2;

                    var total_taxamt = "taxamt" + taxcount;
                    value3 = (parseFloat(net_amt) * (parseFloat(value2) / 100));
                    document.getElementById(total_taxamt).value = value3;

                    var display_taxamt = "display_amt" + taxcount;
                    value3 = (Math.round(value3 * 100) / 100);
                    document.getElementById(display_taxamt).innerHTML = curr + " " + value3;

                    var grossamt = document.getElementById("grossamt").value;
                    value4 = (parseFloat(net_amt) + value3);
                    document.getElementById("grossamt").value = value4;

                    var display_grossamt = document.getElementById("display_grossamt");
                    value4 = (Math.round(value4 * 100) / 100);
                    display_grossamt.innerHTML = curr + " " + value4;
                }
            }
        }
</script>