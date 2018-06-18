<div class="content-wrapper">
    <div class="content_header">
        <h3>Collections List</h3>
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
                   <!-- <div class="col-sm-12"><h3 class="form-box-title">Pending collections </h3></div>-->

                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="ims_form_control" name="category_id" id="category_id">
                                <option value="">Select Category</option>
                                <?php foreach($categories as $category) { ?>
                                    <option value="<?php echo $category->id; ?>"><?php echo ucfirst($category->category_name)?></option>
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
                            <select class="ims_form_control" name="payment_status" id="payment_status">
                                <option value="">Payment Status</option>
                                <option value="Y">Received</option>
                                <option value="N">Pending</option>
                            </select>
                        </div>
                    </div><!--col-sm-3-->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="ims_form_control" name="month" id="month">
                                <option value="-1">Report for Month...</option>
                                <option value="<?php echo date('Y-m-01');?>">This Month - <?php echo date('M Y');?></option>
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
            <div class="ims_datatable table-responsive">
                <!-- <h3 class="form-box-title">Collection Details </h3> -->
                <table id="pendingCollections" class="table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th style="width: 5%">S. No.</th>
                        <th>PO Date</th>
                        <th>Invoice No.</th>
                        <th>Invoice Date</th>
                        <th>Client Name</th>
                        <th>Category</th>
                        <th>Payment Status</th>
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
                        <td></td>
                        <td></td>
                    </tr>
                    </tbody>
                    <tfoot>
                    <tr>
                        <th class="text-center total_net_amnt" colspan="8" >Pending Total:- <span id="totalAmt"></span></th>
                    </tr>
                    </tfoot>
                </table>
            </div><!--ims_datatab-->
        </div><!--row-->
    </div><!--content_box-->
</div>



<!--=============== View Modal ======================-->
<!-- View Modal-->
<div id="InvoiceDetailModal" class="modal">
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
    $(document).ready(function(){

        /*Category Change filter*/

        /*Data table initialization*/
        var table = $('#pendingCollections').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },
            "order": [[ 3, "desc" ]],
            "columnDefs": [
                {
                    "targets": [ 0 ],
                    "orderable":false
                },
            ],

            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": BASEURL + "collections",
                "data": function ( d ) {
                    d.category_id = $('#category_id').val();
                    d.payment_status = $('#payment_status').val();
                    d.client_id = $('#client_id').val();
                    d.month = $('#month').val();
                    // etc
                },
                "dataSrc": function ( json ) {
                    $("#totalAmt").html(json.totalAmt);
                    return json.data;
                }
            },
            "columns": [
                {"data":"s_no"},
                { "data": "po_date" },
                { "data": "invoice_no" },
                { "data": "invoice_date" },
                { "data": "client_name"},
                { "data": "category_name"},
                { "data": "payment_status"},
                { "data": "action"},

            ]

        });

        /*Custom Filter drop down*/
        $("#category_id, #client_id, #payment_status, #month").on("change", function() {

            var itemId = $(this).prop('id');
            if(itemId == "category_id") {
                $categoryId = $(this).val();
                updateClient($categoryId);
                $("#client_id").val('');
            }
            table.draw();
        });


        /*View Model Window*/
        $("#InvoiceDetailModal").on("show.bs.modal", function(e) {
            var modal = $(this);
            modal.find('.view-details').html("");
            var id = $(e.relatedTarget).data('target-id');
            var viewUrl = BASEURL + "invoice/invoice-detail/"+id;
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

        $("#InvoiceDetailModal").on("hide.bs.modal", function() {
            $(".custom_scroll").mCustomScrollbar("destroy");
        });

        /*Client View Model Window*/
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

        function updateClient(categoryId) {
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
            //table.draw();
        }

    });



</script>