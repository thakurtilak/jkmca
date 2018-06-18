<div class="content-wrapper">
    <div class="content_header">
        <h3>Order List</h3>
            <div class="add_new_btn text-right">
                           <a href="<?php echo base_url()?>orders/create-order" class="mdl-js-button mdl-js-ripple-effect btn-event" data-upgraded=",MaterialButton,MaterialRipple">Add Order</a>
                       </div>
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
        <div class="row mm0">
            <div class="order_filter">
                <div class="row mm0">
                    <!--<div class="col-sm-12"><h3 class="form-box-title">View Orders </h3></div>-->
					
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="ims_form_control" name="category_id" id="category_id">
                                <option value="">Select Category</option>
                                <?php foreach($categories as $rows) { ?>
                                    <option value="<?php echo $rows->id; ?>"><?php echo ucfirst($rows->category_name)?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div><!--col-sm-3-->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="ims_form_control" name="client_id" id="client_id">
                                <option value="">Select Client</option>
                                <?php foreach($clients as $clientDetail) { ?>
                                    <option value="<?php echo $clientDetail->client_id; ?>"><?php echo ucfirst($clientDetail->client_name)?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div><!--col-sm-3-->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="ims_form_control" name="status_id" id="status_id">
                                <option value="">Select Status</option>
                                <option value="Y">Cancelled</option>
                                <option value="N">Not Cancelled</option>
                            </select>
                        </div>
                    </div><!--col-sm-3-->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="ims_form_control" name="type_id" id="type_id">
                                <option value="">Assigned/Created</option>
                                <option value="1">Assign to me</option>
                                <option value="2">Created to me</option>
                            </select>
                        </div>
                    </div><!--col-sm-3-->
					
                </div><!--row-->
            </div><!--order_filter-->
            <div class="ims_datatable table-responsive">
              <!--  <h3 class="form-box-title">Order Details </h3>-->
                <table id="order_list" class="table" cellspacing="0" width="100%">
                    <thead>
                        <tr>

                            <th>Order ID</th>
                            <th>Client Name</th>
                            <th>Category</th>
                            <th>Project Name</th>
                            <th style="width:70px;">Start Date</th>
                            <th style="width:70px;">End Date</th>
                            <th>Total Efforts</th>
                            <th>Order Amount</th>
                            <th>Created Date</th>
                            <th width="100px">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td></td>
                            <td></td>
                            <td></td>
                            <td></td>
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
<div class="modal fade" id="cancelModal" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog cancel-order-modal zoomIn animated" role="document">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="cancelModalLabel">Order Cancel Form </h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url(); ?>orders/cancel-order" method="POST" name="orderCancelForm" id="orderCancelForm">
                    <div class="form-group">
                        <label class="control-label">Cancellation Reason<sup>*</sup></label>
                        <textarea class="ims_form_control" name="cancellation_reason" id="cancellation_reason"  rows="3" required></textarea>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">Cancel Order</button>
                        <button class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" data-dismiss="modal">No</button>
                    </div>
                </form>
            </div>
            <!-- <div class="modal-footer">
               <button class="btn btn-secondary" type="button" data-dismiss="modal">NO</button>
                <a id="cancelTargetUrl" class="btn btn-primary" href="<?php /*echo base_url(); */?>orders/cancel-order">YES</a>
            </div>-->
        </div>
    </div>
</div>

<!-- View Modal-->
<div id="viewModal" class="modal">
    <div class="modal-dialog modal-lg zoomIn animated">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Order Detail</h4>
            </div>
            <div class="modal-body view-details custom_scroll">

            </div><!--modal-body-->
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
        </div>
    </div>
</div>

<!-- View client Modal-->
<div id="ClientViewModal" class="modal">
    <div class="modal-dialog modal-lg zoomIn animated">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Client Information</h4>
            </div>
            <div class="modal-body view-details custom_client_scroll">
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
        </div>
    </div>
</div>
<!--=============== End View Modal ======================-->
<script type="text/javascript">
    $(document).ready(function(){

        /*Data table initialization*/
        var table = $('#order_list').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },
            "order": [[ 8, "desc" ]],
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "orderable":false,
                    "visible" : false
                },
                {
                    "targets": [ 4,5 ],
                    "visible" : false
                },
                {
                    "targets": [ 6 ],
                    "orderable":false
                },
                {
                    "targets": [ 9 ],
                    "orderable":false
                },
                {
                    "targets": [ 8 ],
                    "visible": false
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": BASEURL + "orders",
                "data": function ( d ) {
                    d.category_id = $('#category_id').val();
                    d.client_id = $('#client_id').val();
                    d.status_id = $('#status_id').val();
                    d.type_id = $('#type_id').val();
                    // etc
                }
            },
            "columns": [
                { "data": "order_id" },
                { "data": "client_name" },
                { "data": "category_name" },
                { "data": "project_name" },
                { "data": "start_date" },
                { "data": "end_date" },
                { "data": "total_efforts"},
                { "data": "order_amount"},
                { "data": "order_date"},
                { "data": "action"},
            ]
        });

        /*Category Change filter*/
        $("#category_id").on("change", function() {
            var categoryId = $(this).val();
            $.ajax({
                type: "POST",
                url: BASEURL + "orders/getClientByCategory",
                data: {cat_id: categoryId},
                beforeSend: function () {
                    // setting a timeout
                    $('.loader-wrapper').show()
                },
                success: function (data) {
                    $("#client_id").html('');
                    $("#client_id").html(data);
                },
                error: function (error) {
                    $('.loader').hide();
                    alert("There is an error while getting clients. Please try again.");
                },
                complete: function () {
                    $('.loader-wrapper').hide();
                },
            });
            table.draw();
        });

        /*Custom Filter drop down*/
        $("#client_id, #status_id, #type_id").on("change", function() {
            table.draw();
        });


        /*Cancel Order Model window*/
        $("#cancelModal").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('target-id');
            var cancelHref = BASEURL + "orders/cancel-order/"+id;
            $("#orderCancelForm").prop('action', cancelHref);

        });

        /* View Model window*/

        $("#viewModal").on("show.bs.modal", function(e) {
            var modal = $(this);
            modal.find('.view-details').html("");
            var id = $(e.relatedTarget).data('target-id');
            var viewUrl = BASEURL + "orders/view-order/"+id;
            $.ajax({
                type: "GET",
                url: viewUrl,
                cache: false,
                success: function (data) {
                    modal.find('.view-details').html(data);
                    $(".custom_scroll").mCustomScrollbar();
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $("#viewModal").on("hide.bs.modal", function() {
            $(".custom_scroll").mCustomScrollbar("destroy");
        });

        /*Client View Model window*/
        $("#ClientViewModal").on("show.bs.modal", function(e) {
            var modal = $(this);
            modal.find('.view-details').html("");
            var id = $(e.relatedTarget).data('target-id');
            var viewUrl = BASEURL + "clients/view-client/"+id;
            $.ajax({
                type: "GET",
                url: viewUrl,
                cache: false,
                success: function (data) {
                    modal.find('.view-details').html(data);
                    $(".custom_client_scroll").mCustomScrollbar();
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $("#ClientViewModal").on("hide.bs.modal", function() {
            $(".custom_client_scroll").mCustomScrollbar("destroy");
        });

        $("#orderCancelForm").validate({
            rules: {
                cancellation_reason:{
                    required:true
                }
            },
            messages:{
                cancellation_reason:{
                    required:"This field is required"
                }
            }
        });

    });
</script>