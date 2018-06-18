<div class="content-wrapper">
    <div class="content_header">
        <h3>Generate Invoices</h3>
    </div>
    <div class="inner_bg content_box">
		<div class="row">
        <?php if($this->session->flashdata('error') != '') { ?>
            <div class="alert alert-danger" id="error_mesg"style="margin-top:18px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                <?php echo $this->session->flashdata('error'); ?>
            </div>
        <?php } ?>
        <?php if($this->session->flashdata('success') != '') { ?>
            <div class="alert alert-success" id="success_msg" style="margin-top:18px;">
                <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                <?php echo $this->session->flashdata('success'); ?>
            </div>
        <?php } ?>
		</div>
        <?php
        if(isset($currentMonthConversion) && count($currentMonthConversion) < 1) { ?>
                <div class="alert alert-danger" id="error_mesg"style="margin-top:18px;">
                    Please add Currency Conversion for <strong><?php echo date('M-Y', strtotime($currentMonth)); ?></strong> before generate invoice.
                </div>
        <?php }
        ?>
        <div class="row mm0">
            <div class="order_filter">
            </div><!--order_filter-->
            <div class="ims_datatable table-responsive">
              <!--  <h3 class="form-box-title">Pending Invoice Request </h3>-->
                <table id="generateInvoices" class="table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Requested Date</th>
                        <th>Requested By </th>
                        <th>Category</th>
                        <th>Client Name</th>
                        <th>PO Number </th>
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
    <div class="modal-dialog zoomIn animated" role="document">
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
                        <textarea class="ims_form_control" name="cancellation_reason" id="cancellation_reason" placeholder="Cancellation Reason*" rows="3" required></textarea>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">Cancel Order</button>
                        <button class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" data-dismiss="modal">NO</button>
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
<div id="ViewModal" class="modal">
    <div class="modal-dialog modal-lg zoomIn animated">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Invoice Information</h4>
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
    var table;
    $(document).ready(function(){

        /*Data table initialization*/
        table = $('#generateInvoices').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },
            "order": [[ 0, "desc" ]],
            "columnDefs": [
                {
                    "targets": [ 5 ],
                    "orderable":false
                },


            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": BASEURL + "invoice/generates",
            },
            "columns": [
                {"data":"request_date"},
                { "data": "requested_by" },
                { "data": "category" },
                { "data": "Client_name" },
                { "data": "po_no" },
                { "data": "action"},
            ]

        });

        /*Custom Filter drop down*/
        $("#client_id, #status_id, #month").on("change", function() {
            table.draw();
        });


        /*View Modal Window*/
        $("#ViewModal").on("show.bs.modal", function(e) {
            var modal = $(this);
            modal.find('.view-details').html("");
            var id = $(e.relatedTarget).data('target-id');
            var viewUrl = BASEURL + "invoice/invoice-detail/"+id;
            $.ajax({
                type: "GET",
                url: viewUrl,
                cache: false,
                data:{type:"generateInvoice"},
                success: function (data) {
                    modal.find('.view-details').html(data);
                    $(".custom_scroll").mCustomScrollbar();
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $("#ViewModal").on("hide.bs.modal", function() {
            $(".custom_scroll").mCustomScrollbar("destroy");
        });

        /*Client View Modal Window*/
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

    });



</script>