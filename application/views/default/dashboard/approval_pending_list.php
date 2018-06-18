<div class="content-wrapper">
    <div class="content_header">
        <h3>Pending Invoice For Approval</h3>
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
        <div class="row">
            <div class="order_filter">
                <!--<div class="row">
                    <div class="col-sm-12"><h3 class="form-box-title">Pending Invoice For Approval</h3></div>
                </div>--><!--col-sm-3-->
            </div><!--row-->
            </div><!--order_filter-->
            <div class="ims_datatable table-responsive">
                <!--<h3 class="form-box-title">Invoice Details </h3>-->
                <table id="pending_invoices_list" class="table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Request Date</th>
                        <th>Requestor Name</th>
                        <th>Client Name</th>
                        <th>Project Name</th>
                        <th>Net Amount</th>
                        <th>PO. Number</th>
                        <th width="15%">Action</th>
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
                    </tr>
                    </tbody>
                    <!--<tfoot>
                    <tr>
                        <th colspan="3" style="text-align:right">Total:</th>
                        <th colspan="4"></th>
                    </tr>
                    </tfoot>-->
                </table>
            </div><!--ims_datatab-->
        </div><!--row-->
    </div><!--content_box-->
</div>

<!--=============== View Modal ======================-->
<!-- View Modal-->
<div id="ViewModal" class="modal">
    <div class="modal-dialog modal-lg zoomIn animated">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Invoice Detail</h4>
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
         table = $('#pending_invoices_list').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },
            "order": [[ 0, "desc" ]],
           "columnDefs": [
                {
                    "targets": [ 6 ],
                    "orderable":false
                },
               {
                   "targets": [ 5 ],
                   "visible":false
               },


            ],
            "processing": true,
            "serverSide": true,
           "ajax": {
                "url": BASEURL + "dashboard/approve-pending",

            },

            "columns": [
                { "data": "request_date" },
                { "data": "requestor_name" },
                { "data": "client_name" },
                { "data": "project_name" },
                { "data": "invoice_amount"},
                { "data": "po_no" },
                { "data": "invoice_status"},
            ],



            "footerCallback": function ( row, data, start, end, display ) {
                var api = this.api(), data;

                // Remove the formatting to get integer data for summation

                var sumRs =0;
                var sumRsTotal = function (i){
                    if(typeof i == 'string' )
                    i = i.replace(/[\Rs,]/g, '')*1 ;
                    return sumRs = sumRs+i;
                }

                var dollarTotal =0;
                var sumDollarTotal = function (i){
                    if(typeof i == 'string' )
                        i = i.replace(/[\$,]/g, '')*1 ;
                    return dollarTotal = dollarTotal+i;
                }

                total = api
                    .column( 3 )
                    .data()
                    .reduce( function (a, b) {
                        if(b.includes('$')){
                            sumDollarTotal(b);
                        }
                        if(b.includes('Rs')){
                            sumRsTotal(b);
                        }
                        if(dollarTotal!=0&&sumRs!=0) {
                            return "$ " + dollarTotal + "+ Rs. " + sumRs;
                        }
                        if(dollarTotal=='0')
                        {
                            return "Rs. "+sumRs;
                        }
                        if(sumRs=='0')
                        {
                            return "$ "+dollarTotal;
                        }
                    }, 0 );

                // Total over this page

                var sumRs =0;
                var sumRsTotal1 = function (i){
                    if(typeof i == 'string' )
                        i = i.replace(/[\Rs,]/g, '')*1 ;
                    return sumRs = sumRs+i;
                }
                var dollarTotal =0;

                var sumDollarTotal1 = function (i){
                    if(typeof i == 'string' )
                        i = i.replace(/[\$,]/g, '')*1 ;

                    return dollarTotal = dollarTotal+i;

                }

                    pageTotal = api
                        .column(3, {page: 'current'})
                        .data()
                        .reduce(function (a, b) {
                            if (b.includes('$')) {
                                sumDollarTotal1(b);
                            }
                            if (b.includes('Rs')) {
                                sumRsTotal1(b);
                            }
                            if(dollarTotal!=0&&sumRs!=0) {
                                return "$ " + dollarTotal + "+ Rs. " + sumRs;
                            }
                            if(dollarTotal=='0')
                            {
                                return "Rs. "+sumRs;
                            }
                            if(sumRs=='0')
                            {
                                return "$ "+dollarTotal;
                            }

                        }, 0);



                // Update footer
                $( api.column( 3 ).footer() ).html(
                    ''+pageTotal+' ( '+ total +' total)'
                );
            }
        });


        /*Custom Filter drop down*/
        $("#client_id, #status_id, #type_id").on("change", function() {
            table.draw();
        });

        $("#ViewModal").on("show.bs.modal", function(e) {
            var modal = $(this);
            modal.find('.view-details').html("");
            var id = $(e.relatedTarget).data('target-id');
            //var viewUrl = BASEURL + "invoice/pending_invoice_detail/"+id;
            var viewUrl = BASEURL + "invoice/invoice-detail/"+id;
            $.ajax({
                type: "GET",
                url: viewUrl,
                cache: false,
                data:{type:"pendingInvoice"},
                success: function (data) {
                    modal.find('.view-details').html(data);
                    $(".custom_scroll").mCustomScrollbar();
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });


        $("#pendinginvoicesModal").on("hide.bs.modal", function() {
            $(".custom_scroll").mCustomScrollbar("destroy");
        });


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