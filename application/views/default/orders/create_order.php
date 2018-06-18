<div class="content-wrapper">
        <div class="content_header">
            <h3>Create Order</h3>
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
        <form action="" method="post" id="createOrder" name="createOrder" enctype="multipart/form-data">
        <div class="row">
            <div class="col-sm-12">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="box-form" id="orderData">
                            <h3 class="form-box-title">Order Info</h3>
                            <div class="theme-form">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Select Category*</label>
                                            <select class="ims_form_control" name="category_id" id="category_id" onchange="this.options.selectedIndex;" >
                                                <option value="">Select category*</option>
                                                <?php foreach($categories as $rows) { ?>
                                                    <option value="<?php echo $rows->id?>"><?php echo ucfirst($rows->category_name)?></option>
                                                <?php } ?>
                                            </select>
                                            <?php echo form_error('category_id'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group inline_info">
											<label class="ims_form_label">Client Name</label>
                                            <select class="ims_form_control" name="client" id="client">
                                                <option value="">Client name*</option>
                                            </select>
                                            <a href="javascript:void(0)" onclick="addMoreClient();" class="add_more_btn pull-right mdl-js-button mdl-js-ripple-effect ripple-white"><img src="<?php echo base_url() ?>assets/images/plus_bordered.svg"  /></a>
                                            <?php echo form_error('client'); ?>
                                        </div>
                                        </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Project Type*</label>
                                            <select class="ims_form_control" name="project_type" id="project_type">
                                                <option value="">Project type*</option>
                                                <option value="FB">Fixed Bid</option>
                                                <option value="TNM">Time and Material</option>
                                            </select>
                                            <?php echo form_error('project_type'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Order Type*</label>
                                            <select class="ims_form_control" name="order_type" id="order_type">
                                                <option value="">Order type*</option>
                                                <option value="N">New</option>
                                                <option value="E">Existing</option>
                                            </select>
                                            <?php echo form_error('order_type'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Project Name*</label>
                                            <input maxlength="50" name="project_name" type="text" class="ims_form_control" id="project_name" placeholder="Project name*" />
                                            <select class="ims_form_control" name="order_id" id="order_id" style="display:none; ">
                                                <option value="">Project name*</option>
                                            </select>
                                            <?php echo form_error('project_name'); ?>
                                            <?php echo form_error('order_id'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-9">
                                        <div class="form-group">
											<label class="ims_form_label">Project Description</label>
                                            <textarea maxlength="250" class="ims_form_control" name="project_description" id="project_description" placeholder="Project description*" rows="5"></textarea>
                                            <?php echo form_error('project_description'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Webdunia Sales Persom*</label>
                                            <select class="ims_form_control" name="wd_sales_id" id="wd_sales_id">
                                                <option value="">Webdunia Sales person*</option>
                                                <?php foreach($wdsalesperson as $rows) { ?>
                                                    <option value="<?php echo $rows->id?>"><?php echo ucfirst($rows->name)?></option>
                                                <?php } ?>
                                            </select>
                                            <?php echo form_error('wd_sales_id'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Webdunia Tech Head*</label>
                                            <select class="ims_form_control" name="wd_tech_head_id" id="wd_tech_head_id">
                                                <option value="">Webdunia Tech head*</option>
                                                <?php foreach($wdtechnicalhead as $rows) { ?>
                                                    <option value="<?php echo $rows->id?>"><?php echo ucfirst($rows->name)?></option>
                                                <?php } ?>
                                            </select>
                                            <?php echo form_error('wd_tech_head_id'); ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 efforts_unit" style="display:none;">
                                        <div class="form-group">
											<label class="ims_form_label">Unit</label>
                                            <select id="efforts_unit" name="efforts_unit" class="ims_form_control">
                                                <option value="">Unit</option>
                                                <option value="H">Hours</option>
                                                <option value="D">PD's</option>
                                                <option value="M">PM's</option>
                                            </select>
                                            <?php echo form_error('efforts_unit'); ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Start Date*</label>
                                              <input type="text" name="start_date" id="start_date" class="agreement_date ims_form_control date_icon sel_date" readonly  placeholder="Start date*" />
                                            <?php echo form_error('start_date'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 end_date">
                                        <div class="form-group">
											<label class="ims_form_label">End Date*</label>
                                            <input type="text" name="end_date" id="end_date" class="agreement_date ims_form_control date_icon sel_date" readonly  placeholder="End date*" />
                                            <?php echo form_error('end_date'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 unit_rate" style="display: none;">
                                        <div class="form-group">
											<label class="ims_form_label">Unit rate</label>
                                               <input maxlength="10" name="unit_rate" type="text" class="ims_form_control" id="unit_rate" placeholder="Unit rate" maxlength="10" >
                                            <?php echo form_error('unit_rate'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3 hourCurncy"  style="display: none;">
                                        <div class="form-group">
											<label class="ims_form_label">Currency</label>
                                            <select class="ims_form_control order-currency" name="hourCurncy" id="hourCurncy" placeholder="Currency">
                                                <option value="">Currency</option>
                                                <?php foreach($currencyname as $rows) { ?>
                                                    <option value="<?php echo $rows->currency_id?>"><?php echo ucfirst($rows->currency_name)?></option>
                                                <?php } ?>
                                            </select>
                                            <?php echo form_error('hourCurncy'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Total Efforts*</label>
                                               <input  maxlength="10" type="text" name="total_efforts" id="total_efforts" class="ims_form_control"  placeholder="Total efforts*" />
                                            <?php echo form_error('total_efforts'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Unit*</label>
                                            <select class="ims_form_control order-currency" name="effort_unit" id="effort_unit">
                                                <option value="">Unit*</option>
                                                <option value="H">Hours</option>
                                                <option value="D">PD's</option>
                                                <option value="M">PM's</option>
                                            </select>
                                            <?php echo form_error('effort_unit'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Order Amount*</label>
                                            <input maxlength="10" type="text" name="order_amount" id="order_amount" class="ims_form_control"  placeholder="Order amount*" />
                                            <?php echo form_error('order_amount'); ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Currency*</label>
                                            <select class="ims_form_control order-currency" name="order_curncy" id="order_curncy">
                                                <option value="">Currency*</option>
                                                <?php foreach($currencyname as $rows) { ?>
                                                    <option value="<?php echo $rows->currency_id?>"><?php echo ucfirst($rows->currency_name)?></option>
                                                <?php } ?>
                                            </select>
                                            <?php echo form_error('order_curncy'); ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-3 tnmDuration" style="display:none;">
                                        <div class="form-group">
											<label class="ims_form_label">Duration</label>
                                            <input maxlength="2" name="duration" type="text" class="ims_form_control"  id="duration" placeholder="Duration" maxlength="10" />
                                            <?php echo form_error('duration'); ?>
                                        </div>
                                    </div>
                                </div><!--row-->
                            </div><!--theme-form-->
                        </div><!--box-theme-->
                    </div><!--col-sm-12-->
                    <div class="col-sm-12" id="invoicebox" style="display: none">
                        <div class="box-form" id="inv">
                            <h3 class="form-box-title">Invoice Schedule <a href="javascript:void(0)" onclick="addMoreInvoiceSchedule()" class="add_more_btn pull-right mdl-js-button mdl-js-ripple-effect ripple-white"><img src="<?php echo base_url() ?>assets/images/plus_bordered.svg"  /></a> </h3>
                            <div class="rowtheme-form invoice_schedule_box" id="invoiceScheduleBox">
                                <div class="row invoiceRow" id="invoice_schedule_row_1">
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Start Date</label>
                                            <input type="text" name="add_invoice_startdate[]" id="invoice_startdate_1" class="invoice_schedule_date ims_form_control date_icon sel_date" readonly  placeholder="Start date" />
                                            <?php echo form_error('add_invoice_startdate[]'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-2">
                                        <div class="form-group">
											<label class="ims_form_label">Amount</label>
                                            <input maxlength="10" type="text" name="add_invoice_amount[]" id="invoice_amount_1" class="ims_form_control invoiceAmount" placeholder="Amount" />
                                            <?php echo form_error('add_invoice_amount[]'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Comment</label>
                                            <input maxlength="150" type="text" name="add_invoice_comment[]" id="invoice_comment_1" class="ims_form_control" placeholder="Comment" />
                                        </div>
                                    </div>
                                    <div class="col-sm-4">
                                        <div class="form-group">
											<label class="ims_form_label">Status</label>
                                            <div class="radio radio-inline">
                                                <input type="radio" id="invoice_status_c_1" value="C" name="invoice_status_1" checked="">
                                                <label for="invoice_status_c_1"> Confirmed</label>
                                            </div>
                                            <div class="radio radio-inline">
                                                <input type="radio" id="invoice_status_t_1" value="T" name="invoice_status_1" checked="">
                                                <label for="invoice_status_t_1"> Tentative </label>
                                            </div>
											<div class="del_add_row">
												<a href="javascript:void(0);" class="pad0 delete_record delete_schedule_invoice"><img src="<?php echo base_url();?>assets/images/delete_icon.svg" /></a>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                                <!--row-->
                                <div>
                                    <input type="hidden" name="invoice_schedules" id="invoice_schedules" value="1">
                                </div>
                            </div><!--theme-form-->
                            <div id="totalinv"><strong>Total Invoice Amount : <span id="totalInvoiceAmount"></span></strong></div>

                        </div><!--box-theme-->
                    </div><!--col-sm-12-->
                    <div class="col-sm-12">
                        <div class="box-form">
                            <h3 class="form-box-title">Project Contact Detail</h3>
                            <div class="theme-form">
                                <div class="row sales_person_row" id="sales_person_row_1">
                                    <div class="col-sm-6">
                                        <h3 class="form-box-subtitle">Manager's Details</h3>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
													<label class="ims_form_label">Name*</label>
                                                    <select class="ims_form_control" name="sales_contact_person" id="sales_contact_person">
                                                        <option value="">Name*</option>
                                                    </select>
                                                    <?php echo form_error('sales_contact_person'); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
													<label class="ims_form_label">Contact Number*</label>
                                                    <input maxlength="50" type="text" class="ims_form_control" name="sales_contact_no" id="sales_contact_no" readonly="readonly" placeholder="Contact number*">
                                                    <?php echo form_error('sales_contact_no'); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
													<label class="ims_form_label">Email*</label>
                                                    <input maxlength="150" type="text" class="ims_form_control" name="sales_email_id" id="sales_email_id" readonly="readonly" placeholder="Email*">
                                                    <?php echo form_error('sales_email_id'); ?>
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
													<label class="ims_form_label">Address*</label>
                                                    <textarea maxlength="250" class="ims_form_control" rows="5" name="client_address" id="client_address" readonly="readonly" placeholder="Address*"></textarea>
                                                    <?php echo form_error('client_address'); ?>
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--col-sm-6-->
                                    <div class="col-sm-6">
                                        <h3 class="form-box-subtitle">Client's Accounts Details</h3>
                                        <div class="row">
                                            <div class="col-sm-6">
                                                <div class="form-group">
													<label class="ims_form_label">Name</label>
                                                    <select class="ims_form_control" name="account_contact_person" id="account_contact_person">
                                                        <option value="">Name</option>
                                                    </select>           
                                                </div>
                                            </div>
                                            <div class="col-sm-6">
                                                <div class="form-group">
													<label class="ims_form_label">Contact number</label>
                                                    <input maxlength="50" type="text" class="ims_form_control" name="account_contact_no" id="account_contact_no" readonly="readonly" placeholder="Contact number">
                                                </div>
                                            </div>
                                            <div class="col-sm-12">
                                                <div class="form-group">
													<label class="ims_form_label">Email</label>
                                                    <input maxlength="150" type="text" class="ims_form_control" name="account_email_id" id="account_email_id" readonly="readonly" placeholder="Email">
                                                </div>
                                            </div>
                                        </div>
                                    </div><!--col-sm-6-->
                                </div><!--row-->
                            </div><!--theme-form-->
                        </div><!--box-theme-->
                    </div><!--col-sm-12-->
                    <div class="col-sm-12">
                        <div class="box-form">
                            <h3 class="form-box-title">PO/RO Details</h3>
                            <div class="theme-form">
                                <div class="row">
                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">PO/RO Number*</label>
                                            <input maxlength="50" type="text" class="ims_form_control" name="po_no" id="po_no"  placeholder="PO/RO number*">
                                            <?php echo form_error('po_no'); ?>
                                        </div>
                                    </div>
									<div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">PO/RO Date*</label>
                                            <input type="text" name="po_date" id="po_date"  class="agreement_date ims_form_control date_icon sel_date" readonly  placeholder="PO/RO date*" />
                                            <?php echo form_error('po_date'); ?>
                                        </div>
                                    </div>

                                    <div class="col-sm-4">
                                        <div class="form-group">
											<label class="ims_form_label">PO/RO Details*</label>
                                            <textarea maxlength="150" class="ims_form_control" rows="3" name="po_dtl" id="po_dtl" placeholder="PO/RO details*"></textarea>
                                            <?php echo form_error('po_dtl'); ?>
                                        </div>
                                    </div>
                                    <div class="col-sm-2 text-right">
                                        <div class="form-group">
											<label class="ims_form_label"></label>
                                           <div class="checkbox">
                                                <input type="checkbox" id="no_po" value="option1" name="no_po" onclick="setPoDetails();" />
                                                <label for="inlineRadio3"> No PO</label>
                                            </div>
                                        </div>
                                    </div>
									<div class="clearfix"></div>


                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Client Agreements</label>
                                            <div class="ims_multiselect">
                                                <span id="noAttachment"></span>
                                                <select title="Client agreements" class=" selectpicker" id="client_agreement" name="client_agreement[]"  multiple="multiple" >
                                                 </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-sm-3">
                                        <div class="form-group">
											<label class="ims_form_label">Payment Term*</label>
                                            <select class="ims_form_control" name="payment_term" id="payment_term">
                                                <option value="">Payment term*</option>
                                                <?php foreach($paymentterm as $rows) { ?>
                                                <option value="<?php echo $rows->id?>"><?php echo ucfirst($rows->name)?></option>
                                                <?php } ?>

                                            </select>
                                            <?php echo form_error('payment_term'); ?>
                                        </div>
                                    </div>

                                    
                                    <div class="col-sm-12 order_attachment_box" id="order_attachment_box_1">
										<div class="row">
											<div class="col-sm-6 invoice_doc_wrapper" id="invoice_doc_1">
											 <div class="form-group">
												 <label class="ims_form_label">Select Type</label>
												 <select name="add_invoice_doc[]" id="invoice_doc1" class="ims_form_control attachtype">
													 <option value="">Select type</option>
													 <option value="opf">Order Processing Form</option>
													 <option value="ro">Release/Work Order</option>
													 <option value="agreement">Agreement</option>
													 <option value="eml">Email file</option>
													 <option value="client_report">Client Report</option>
													 <option value="wrk_smry">Work Summary</option>
													 <option value="others">Others</option>
												 </select>
												 </div>
											</div>
											<div class="col-sm-6 attach_col attach invoice_attachment_wrapper" id="attachment_1">
                                            <div class="form-group order-attachment-group">
												<label class="ims_form_label">Name of Agreement*</label>
                                                <div class="file-upload-wrapper" id="file-upload-wrapper_1">
                                                    <input type="file" name="add_agreement_name[]" id="attachment1" class="ims_form_control upload_icon custom-file-upload-hidden" placeholder="Name of agreement*" tabindex="-1" aria-invalid="false" style="position: absolute; left: -9999px;">
                                                    <input style="display: none" type="text" name="file-upload-input[]" id="file-upload-input-hidden_1" class="file-upload-input" placeholder="Attachment" readonly>
                                                    <span class="file-upload-span"></span>
                                                    <button type="button" class="file-upload-button file-upload-select" tabindex="-1">
                                                    </button>
                                                </div>
                                                <label id="file-upload-input_1-error" class="error" for="file-upload-input_1" style="display: none;"></label>
                                                <a href="javascript:void(0);" class="delete_record delete_attachment"><img src="<?php echo base_url();?>assets/images/delete_icon.svg" /></a>
												<a href="javascript:void(0)" onclick="addMoreAttachment()"  class="add_more_btn mdl-js-button mdl-js-ripple-effect ripple-white"><img src="<?php echo base_url() ?>assets/images/plus_bordered.svg"  /></a>
                                            </div>
                                        </div>
										</div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group add-more-wrapper">
                                            
                                        </div>
                                    </div>

                                    <div class="clearfix"></div>

                                    <div class="col-sm-12">
                                        <div class="form-group">
											<label class="ims_form_label">Remark*</label>
                                            <textarea maxlength="150" class="ims_form_control" rows="5" name="invoice_org_remarks" id="invoice_org_remarks" placeholder="Remark*"></textarea>
                                            <?php echo form_error('invoice_org_remarks'); ?>
                                        </div>
                                    </div>

                                </div><!--row-->
                            </div><!--theme-form-->
                        </div><!--box-theme-->
                    </div><!--col-sm-12-->
                    <div class="col-sm-12">
                        <div class="form-footer">
                            <input type="submit" name="submit" id="submit" value="Create" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">
                            <input type="reset" name="reset" id="resetCreateOrder" value="Reset" class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white">
                        </div>
                    </div><!--col-sm-12-->
                </div><!--row-->

            </div><!--col-sm-12-->
        </div><!--row-->
        </form>
    </div>
</div><!--content-wrapper-->
<!-- View Modal-->
<div id="addClientModal" class="modal">
    <div class="modal-dialog modal-lg zoomIn animated">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Add Client</h4>
            </div>
            <div class="modal-body view-details1 custom_scroll bg-white pt-0 pb-0">

            </div><!--modal-body-->
        </div>
    </div>
</div>
<script src="<?php echo base_url();?>assets/js/create-order.js"></script>
<script>


    function addMoreClient() {
        $('#addClientModal').modal('show');
    }


    $("#addClientModal").on("show.bs.modal", function(e) {
        var modal = $(this);
        modal.find('.view-details1').html("");
        var id = $('#category_id').val();

        var viewUrl = BASEURL + "clients/add-newclient";
        $.ajax({
            type: "POST",
            url: viewUrl,
            dataType:'json',
            data:{category_id:id,type:'order'},
            cache: false,
            success: function (data) {
                modal.find('.view-details1').html(data.viewHtml);
                $(".custom_client_scroll").mCustomScrollbar();
            },
            error: function(err) {
                console.log(err);
            }
        });
    });


</script>