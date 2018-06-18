
<div class="row">
    <div class="col-sm-12">
        <div class="alert alert-danger" id="courierError" style="display: none"></div>
    </div>
</div>
<form name="courierForm" method="post" id="courierForm">
    <div class="row">
        <div class="col-sm-12">
            <div class="row">
                <div class="col-sm-12">
                    <div class="box-form1">
                        <div class="theme-form">
                            
                                <input type="hidden" id="invoice_id" name="invoice_id" value="<?php echo (isset($invoiceDetail))? $invoiceDetail->invoice_req_id: ""; ?>">
                                <?php if(!isset($courierInfo)): ?>
								<div class="row">
                                    <div class="col-sm-12">
                                        <div class="form-group">
											<label class="ims_form_label">To</label>
                                            <input type="text" name="shipment_to" class="ims_form_control" maxlength="100" id="shipment_to" placeholder="To*" value="<?php echo (isset($invoiceDetail)) ? $invoiceDetail->sales_person_name :""; ?>"/>
                                            <?php echo form_error('shipment_to'); ?>
                                            <label class="error" style="display:none;">Required</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-12">
                                        <div class="form-group">
											<label class="ims_form_label">Address</label>
                                            <textarea name="shipment_address" class="ims_form_control" maxlength="255" id="shipment_address" placeholder="Address*"><?php echo (isset($invoiceDetail)) ? $invoiceDetail->address :""; ?></textarea>
                                            <?php echo form_error('shipment_address'); ?>
                                            <label class="error" style="display:none;">Required</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
											<label class="ims_form_label">Courier Date</label>
                                            <input readonly type="text" name="courier_date" class="ims_form_control date_icon sel_date" id="courier_date" placeholder="Courier Date*"/>
                                            <?php echo form_error('courier_date'); ?>
                                            <label class="error" style="display:none;">Required</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
											<label class="ims_form_label">Shipment No.</label>
                                            <input type="text" name="shipment_no" class="ims_form_control" maxlength="50" id="shipment_no" placeholder="Shipment No*"/>
                                            <?php echo form_error('shipment_no'); ?>
                                            <label class="error" style="display:none;">Required</label>
                                        </div>
                                    </div>
									
                                    <div class="col-sm-6">
                                        <div class="form-group">
											<label class="ims_form_label">Courier Company</label>
                                            <input type="text" name="courier_company" class="ims_form_control" maxlength="100" id="courier_company" placeholder="Courier Company*"/>
                                            <?php echo form_error('courier_company'); ?>
                                            <label class="error" style="display:none;">Required</label>
                                        </div>
                                    </div>
									
                                    <div class="col-sm-6">
                                        <div class="form-group">
											<label class="ims_form_label">Select status</label>
                                            <select class="ims_form_control" name="status" id="status">
                                                <option value="">Select status*</option>
                                                <option value="Sent">Sent</option>
                                                <option value="Delivered">Delivered</option>
                                            </select>
                                            <?php echo form_error('status'); ?>
                                            <label class="error" style="display:none;">Required</label>
                                        </div>
                                    </div>
                                    <div class="col-sm-6">
                                        <div class="form-group">
											<label class="ims_form_label">Shipment From Name</label>
                                            <input type="text" name="shipment_from" class="ims_form_control" maxlength="100" id="shipment_from" placeholder="Shipment From Name*"/>
                                            <?php echo form_error('shipment_from'); ?>
                                            <label class="error" style="display:none;">Required</label>
                                        </div>
                                    </div>
									
								</div><!--row-->
                                <?php else: ?>
									<ul class="order_view_detail">
										<li>
											<div class="order_info_block">
												<span class="ov_title">TO</span>
												<span class="ov_data"><?php echo $courierInfo->shipment_to; ?></span>
											</div>
										</li>
										<li>
											<div class="order_info_block">
												<span class="ov_title">Address</span>
												<span class="ov_data"><?php echo $courierInfo->shipment_address; ?></span>
											</div>
										</li>
										<li>
											<div class="order_info_block">
												<span class="ov_title">Courier Date</span>
												<span class="ov_data"><?php echo ($courierInfo->courier_date) ? date('d-M-Y', strtotime($courierInfo->courier_date)) :'--'; ?></span>
											</div>
										</li>
										<li>
											<div class="order_info_block">
												<span class="ov_title">Shipment No</span>
												<span class="ov_data"><?php echo $courierInfo->shipment_no; ?></span>
											</div>
										</li>
										<li>
											<div class="order_info_block">
												<span class="ov_title">Courier Company</span>
												<span class="ov_data"><?php echo $courierInfo->courier_company; ?></span>
											</div>
										</li>
										<li>
											<div class="order_info_block">
												<span class="ov_title">Status</span>
												<span class="ov_data"><?php echo $courierInfo->status; ?></span>
											</div>
										</li>
										<li>
											<div class="order_info_block">
												<span class="ov_title">Shipment From</span>
												<span class="ov_data"><?php echo $courierInfo->shipment_from; ?></span>
											</div>
										</li>
										<li>
											<div class="order_info_block">
												<span class="ov_title">Added On</span>
												<span class="ov_data"><?php echo date('d-M-Y', strtotime($courierInfo->created_date)); ?></span>
											</div>
										</li>
									</ul>
                                <?php endif; ?>
                            
                        </div><!--theme-form-->
                    </div><!--box-theme-->
                </div><!--col-sm-12-->
                <?php if(!isset($courierInfo)): ?>
                    <div class="col-sm-12">
                        <div class="modal-footer">
                            <input type="button" id="submit1" name="submit1"  onClick="submit_client()"   value="Create" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white"/>
                            <input name="reset"  type="reset" onClick="reset_form();" class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" id="reset" value="Reset"/>
                        </div>
                    </div><!--col-sm-12-->
                <?php endif; ?>
            </div><!--row-->

        </div><!--col-sm-12-->
    </div><!--row-->
</form>
<script>
    $(document).ready(function(){
        $courier_date = $("#courier_date").datepicker({format: "d-M-yyyy",autoclose: true});
        $courier_date.datepicker().on('show.bs.modal', function(event) {
            // prevent datepicker from firing bootstrap modal "show.bs.modal"
            event.stopPropagation();
        });

        $.validator.addMethod("alpha", function(value, element) {
            return this.optional(element) || value == value.match(/^[a-zA-Z\s]+$/);
        });

        $courierFormValidator = $("#courierForm").validate({
            rules: {
                shipment_to: {required: true},
                shipment_address: {required: true},
                courier_date: {required: true},
                shipment_no: {required: true},
                courier_company: {required: true},
                status: {required: true},
                shipment_from: {required: true, alpha:true}
            },
            messages: {
                shipment_to: {required: "This field is required"},
                shipment_address: {required: "This field is required"},
                courier_date: {required: "This field is required"},
                shipment_no: {required: "This field is required"},
                courier_company: {required: "This field is required"},
                status: {required: "This field is required"},
                shipment_from: {required: "This field is required", alpha:'Invalid inputs value'}
            }
        });
    });
    function reset_form() {

        $("label.error, span.error").text('');
        return false;
    }

    function submit_client() {
        var form = $("#courierForm");
        if (!form.valid()) { // Not Valid
            return false;
        }
        $invoice_id = $("#invoice_id").val();
        if($invoice_id =='') {
            alert("There is an error. Please try again letter!");
            return;
        }
        $shipment_to = $("#shipment_to").val();
        $shipment_address = $("#shipment_address").val();
        $courier_date = $("#courier_date").val();
        $shipment_no = $("#shipment_no").val();
        $courier_company = $("#courier_company").val();
        $status = $("#status").val();
        $shipment_from = $("#shipment_from").val();
        var formData = {
            invoice_id: $invoice_id,
            shipment_to: $shipment_to,
            shipment_address: $shipment_address,
            courier_date: $courier_date,
            shipment_no: $shipment_no,
            courier_company:$courier_company,
            status: $status,
            shipment_from: $shipment_from
        };
        //console.log(JSON.stringify(formData));
        $.ajax({
            type: "POST",
            url: BASEURL + "invoice-delivery/add-courier-info",
            data: formData,
            beforeSend: function () {
                $('.loader-wrapper').show()
            },
            success: function (res) {
                $('.loader-wrapper').hide();
                if(res) {
                    res = JSON.parse(res);
                    if(res.success) {
                        $('#courierDetailsModal').modal('hide');
                        table.draw();
                    } else  {
                        $("#courierError").show();
                        $("#courierError").text(res.message);
                    }
                } else {
                    $("#courierError").show();
                    $("#courierError").text("There is an error while request. Please try again");
                }
            },
            error: function (error) {
                $("#courierError").show();
                $("#courierError").text("There is an error while request. Please try again");
            },
            complete: function () {
                $('.loader-wrapper').hide();
            },
        });
    }
</script>
