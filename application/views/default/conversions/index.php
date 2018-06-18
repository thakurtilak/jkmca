<div class="content-wrapper">
    <div class="content_header">
        <h3>Currency Conversions</h3>
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
        <div id="conversionSuccess" class="alert alert-success row" style="margin-top:18px; display: none">
        </div>
        <div class="row mm0">
            <div class="order_filter">
                <div class="row mm0">
                    <div class="col-sm-12"><!--<h3 class="form-box-title">Raised Invoices </h3>--></div>
                    <?php if(count($currentMonthRecords) == 0): ?>
                    <div class="col-sm-3 pull-right" id="addConversionButton">
                        <div class="form-group text-right">
                            <a href="#addModal" data-toggle="modal" class="btn-event" >Add</a>
                        </div>
                    </div>
                    <?php endif; ?>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="ims_form_control" name="month" id="month">
                                <option value="">Report for Month...</option>
                                <option selected="selected" value="<?php echo date('Y-m-01');?>">This Month - <?php echo date('M Y');?></option>
                                <?php
                                $monthcount=date('n');
                                if($monthcount<4)
                                {
                                    $count=1;
                                    for($i=$monthcount;$i>1;$i--){
                                        if($count==1){
                                            ?>
                                            <option value="<?php echo date('Y-m-01',mktime(0, 0, 0, date("m")-$count, date("d"),date("Y")));?>">Previous Month <?php echo date('M Y',mktime(0, 0, 0, date("m")-$count, date("d"),   date("Y")));?> </option>
                                        <?php } else { ?>
                                            <option value="<?php echo date('Y-m-01',mktime(0, 0, 0, date("m")-$count, date("d"),date("Y")));?>"><?php echo date('M Y',mktime(0, 0, 0, date("m")-$count, date("d"),   date("Y")));?> </option>
                                            <?php
                                        } }
                                    for($i=3;$i<12;$i++){
                                        ?>
                                        <option value="<?php echo date('Y-m-01',mktime(0, 0, 0, date("m")+$i, date("d"),date("Y")-1));?>"><?php echo date('M Y',mktime(0, 0, 0, date("m")+$i, date("d"), date("Y")-1));?> </option>
                                        <?php
                                    } } else{
                                    $count=1;
                                    for($i=$monthcount;$i>1;$i--){
                                        if($count==1){
                                            ?>
                                            <option value="<?php echo date('Y-m-01',mktime(0, 0, 0, date("m")-$count, date("d"),date("Y")));?>">Previous Month <?php echo date('M Y',mktime(0, 0, 0, date("m")-$count, date("d"),   date("Y")));?> </option>
                                            <?php
                                        }else{ ?>
                                            <option value="<?php echo date('Y-m-01',mktime(0, 0, 0, date("m")-$count, date("d"),date("Y")));?>"><?php echo date('M Y',mktime(0, 0, 0, date("m")-$count, date("d"),   date("Y")));?> </option>
                                        <?php  }
                                        $count++;}
                                    for($i=3;$i<13;$i++){
                                        print '<option value="'.date('Y-m-01',mktime(0, 0, 0, $i , date("d"),date("Y")-1)).'">'.date('M Y',mktime(0, 0, 0, $i, date("d"), date("Y")-1)).'</option>';
                                    }
                                }
                                ?>

                            </select>
                        </div>
                    </div><!--col-sm-3-->
                </div><!--row-->
            </div><!--order_filter-->
            <div class="ims_datatable">
                <!--<h3 class="form-box-title">Conversion Details </h3>-->
                <table id="conversionTable" class="table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>S. No.</th>
                        <th>Currency</th>
                        <th>Month</th>
                        <th>Conversion Rate</th>
                        <th>Action</th>
                    </tr>
                    </thead>
                    <tbody>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                </table>
            </div><!--ims_datatab-->
        </div><!--row-->
    </div><!--content_box-->
</div>



<!--=============== View Modal ======================-->
<!-- Logout Modal-->
<div class="modal fade" id="addModal" tabindex="-1" role="dialog" aria-labelledby="addModalLabel" aria-hidden="true">
    <div class="modal-dialog zoomIn animated" role="document">
        <div class="modal-content theme-form">
            <div class="modal-header ims_modal_header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="addModalLabel">Conversion Add Form </h4>
            </div>
			<div class="alert alert-danger" id="conversionError" style="display: none"></div>
                <form action="<?php echo base_url(); ?>currency/add" method="POST" name="addConversionForm" id="addConversionForm">
            	<div class="modal-body">
                        <div class="form-group">
                            <label class="ims_form_label">Month</label>
                            <input readonly="readonly" value="<?php echo date('M-Y');?>" placeholder="Month" type="text" class="ims_form_control" name="conversion_month" id="conversion_month"/>
                            <input value="<?php echo date('Y-m-01');?>" type="hidden" class="ims_form_control" name="conversion_month_actual" id="conversion_month_actual"/>
                        </div>
					
						<div class="row">
                        <?php if($allCurrencies) :  ?>
                            <?php foreach($allCurrencies as $currencyItem) :  ?>
                                <?php if($currencyItem->currency_id != 2): ?>
                                    
										<div class="col-sm-4">
											<div class="form-group">
												<label class="ims_form_label"><?php echo $currencyItem->currency_name ?><sup>*</sup></label>
												<input placeholder="<?php echo $currencyItem->currency_symbol ?> Conversion Rate" type="text" class="currency ims_form_control" name="currency[<?php echo $currencyItem->currency_id; ?>]" id="currency_<?php echo $currencyItem->currency_id; ?>"/>
											</div>
										</div>
									
                        <?php endif;  ?>
                            <?php endforeach;  ?>
                        <?php endif;  ?>
                    	</div>
            		</div>
					<div class="modal-footer">
                        <a href="#rateModal" data-toggle="modal"   class="pull-left current_rate">See Current Rates</a>
                        <button id="conversionSubmit" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">Submit</button>
                        <button class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" data-dismiss="modal">Cancel</button>
                    </div>
			</form>
            <!-- <div class="modal-footer">
               <button class="btn btn-secondary" type="button" data-dismiss="modal">NO</button>
                <a id="cancelTargetUrl" class="btn btn-primary" href="<?php /*echo base_url(); */?>orders/cancel-order">YES</a>
            </div>-->
        </div>
    </div>
</div>

<!-- View Modal-->
<div id="editModal" class="modal">
    <div class="modal-dialog modal-sm zoomIn animated">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Conversion Edit Form</h4>
            </div>
            <div class="modal-body edit-details custom_scroll">

            </div><!--modal-body-->
			<div class="modal-footer">
				<button id="conversionEditSubmit" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">Submit</button>
				<button class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" data-dismiss="modal">Cancel</button>
			</div>
        </div>
    </div>
</div>
<!-- View Modal-->
<div id="rateModal" class="modal">
    <div class="modal-dialog modal-sm zoomIn animated">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Current Currency Rates</h4>
            </div>
            <div class="modal-body rate-details" id="rateDetails">

            </div><!--modal-body-->
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
        </div>
    </div>
</div>
<!--=============== End View Modal ======================-->
<script type="text/javascript">
    var $addConversionFormValidator;
    var $editConversionFormValidator;
    var table;
    $(document).ready(function(){

        /*Data table initialization*/
        table = $('#conversionTable').DataTable({
            "bPaginate": false,
            "bInfo" : false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },
            "order": [[ 1, "desc" ]],
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "orderable":false
                },
                {
                    "targets": [ 2 ],
                    "orderable":false
                },
                {
                    "targets": [ 4 ],
                    "orderable":false
                }
            ],

            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": BASEURL + "currency",
                "data": function ( d ) {
                    d.month = $('#month').val();
                    // etc
                }
            },
            "columns": [
                {"data":"sn_no"},
                { "data": "currency_name" },
                { "data": "month" },
                { "data": "conversion_rate" },
                { "data": "actionLink" }
            ]

        });

        /*Custom Filter drop down*/
        $("#month").on("change", function() {
            table.draw();
        });

        $("#addModal").on("show.bs.modal", function(e) {
            var modal = $(this);
            $("#conversionError").text('');
            $("#conversionError").hide();

            $("#conversionSuccess").hide();
            $("#conversionSuccess").text('');
            $addConversionFormValidator.resetForm();
            $("#addConversionForm")[0].reset();
        });

        /*Edit Conversion Window*/
        $("#editModal").on("show.bs.modal", function(e) {
            $("#conversionEditError").text('');
            $("#conversionEditError").hide();

            $("#conversionSuccess").hide();
            $("#conversionSuccess").text('');
            var modal = $(this);
            var id = $(e.relatedTarget).data('target-id');
            var editUrl = BASEURL + "currency/edit/"+id;
            modal.find('.edit-details').html("");
            $('.loader-wrapper').show();
            $.ajax({
                type: "GET",
                url: editUrl,
                cache: false,
                success: function (data) {
                    $('.loader-wrapper').hide();
                    modal.find('.edit-details').html(data);
                    $(".custom_scroll").mCustomScrollbar();

                },
                error: function (err) {
                    $('.loader-wrapper').hide();
                }
            });
        });

        $("#rateModal").on("hidden.bs.modal", function() {
            $('body').addClass('modal-open');
        });

        $.validator.addMethod("greaterThanZero", function(value, element) {
            return this.optional(element) || (parseFloat(value) > 0);
        }, "Amount must be greater than zero");

        $.validator.addClassRules("currency", {
            required: true,
            number:true,
            greaterThanZero:true
        });
        $addConversionFormValidator = $("#addConversionForm").validate({});
        $editConversionFormValidator = $("#editConversionForm").validate({
            rules:{
                conversion:{
                    required: true,
                    number:true,
                    greaterThanZero:true
                }
            },
            messages:{
                conversion:{
                    required: "This field is required",
                    number:"Please enter a valid number"
                }
            }
        });

        /*Conversion Add Form*/
        $("#conversionSubmit").click(function(){
            var isValid = $("#addConversionForm").valid();

            if(isValid) {
                var addUrl = BASEURL + "currency/add";
                var form = $("#addConversionForm");
                //var formData = new FormData(form[0]);
                var formData = form.serialize();
                $.ajax({
                    type: "POST",
                    url: addUrl,
                    cache: false,
                    data:formData,
                    beforeSend: function () {
                        $('.loader-wrapper').show();
                    },
                    success: function (res) {
                        if(res) {
                            res = JSON.parse(res);
                            if(res.success) {
                                $("#conversionError").text('');
                                $("#conversionError").hide();

                                $("#conversionSuccess").show();
                                $("#conversionSuccess").text(res.message);
                                $("#addConversionButton").hide();
                                $('#addModal').modal('hide');
                                table.draw();
                            } else if(res.error) {
                                $("#conversionError").text(res.error);
                                $("#conversionError").show();

                                $("#conversionSuccess").hide();
                                $("#conversionSuccess").text('');
                            } else {
                                $("#conversionError").text("There is an error while adding conversions.");
                                $("#conversionError").show();

                                $("#conversionSuccess").hide();
                                $("#conversionSuccess").text('');
                            }
                        }

                        $('.loader-wrapper').hide();
                    },
                    error: function (err) {
                        $("#conversionError").text("There is an error while adding conversions.");
                        $("#conversionError").show();
                        $('.loader-wrapper').hide();
                    }
                });
            }
            return false;
        });

        /*Call currency conversion API*/
        var viewUrl = BASEURL + "currency/current-rate";
        $.ajax({
            type: "GET",
            url: viewUrl,
            cache: false,
            success: function (data) {
                $('#rateDetails').html(data);
            },
            error: function (err) {
                console.log(err);
            }
        });
    });



</script>