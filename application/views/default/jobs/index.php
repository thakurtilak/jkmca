<div class="content-wrapper">
    <div class="content_header">
        <h3>View Jobs</h3>
        <div class="add_new_btn text-right">
            <a href="<?php echo base_url(); ?>jobs/new-job" class="mdl-js-button mdl-js-ripple-effect btn-event" data-upgraded=",MaterialButton,MaterialRipple">Add New Job</a>
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
                    <div class="col-sm-12"><!--<h3 class="form-box-title">Raised Invoices </h3>--></div>

                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="ims_form_control" name="work_type" id="work_type">
                                <option value="">Select Work Type</option>
                                <?php foreach($workTypes as $work) { ?>
                                    <option value="<?php echo $work->id; ?>"><?php echo $work->work?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div><!--col-sm-3-->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="ims_form_control" name="status_id" id="status_id">
                                <option value="">Job Status</option>
                                <option value="Accept">Complete</option>
                                <option value="Pending">Pending</option>
                                <!--<option value="Reject">Rejected</option>-->
                            </select>
                        </div>
                    </div><!--col-sm-3-->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="ims_form_control" name="month" id="month">
                                <option value="-1">Job for Month...</option>
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
                <!-- <h3 class="form-box-title">Invoice Details </h3> -->
                <table id="raisedJobs" class="table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>JobID</th>
                        <th>Work Type</th>
                        <th>Client Name</th>
                        <th>Staff Name</th>
                        <th>Request Date</th>
                        <th>Status</th>
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
<div id="InvoiceDetailModal" class="modal">
    <div class="modal-dialog modal-lg zoomIn animated">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Job Information</h4>
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
        <?php
        if(isset($selectedMonth) && $selectedMonth) { ?>
            var selMonth = "<?php echo $selectedMonth; ?>";
            $("#month").val(selMonth);
       <?php }
        ?>
        /*Data table initialization*/
        var table = $('#raisedJobs').DataTable({
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },
            "order": [[ 4, "desc" ]],
            "columnDefs": [
                {
                    "targets": [ 6 ],
                    "orderable":false
                }
            ],

            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": BASEURL + "jobs",
                "data": function ( d ) {
                    d.status_id = $('#status_id').val();
                    d.work_type = $('#work_type').val();
                    <?php
                    if(isset($selectedMonth) && $selectedMonth) { ?>
                        if($('#month').val() =='-1') {
                            d.month = '<?php echo $selectedMonth; ?>';
                        } else {
                            d.month = $('#month').val();
                        }
                    <?php } else { ?>
                    d.month = $('#month').val();
                   <?php  }
                    ?>
                    // etc
                }
            },
           "columns": [
               {"data":"jobID"},
                { "data": "workName" },
                { "data": "clientName" },
                { "data": "staff_name" },
                { "data": "request_date"},
                { "data": "status"},
                { "data": "action"}
            ]
        });

        /*Custom Filter drop down*/
        $("#work_type, #status_id, #month").on("change", function() {
            table.draw();
        });


        /*View Model Window*/
        $("#InvoiceDetailModal").on("show.bs.modal", function(e) {
            var modal = $(this);
            modal.find('.view-details').html("");
            var id = $(e.relatedTarget).data('target-id');
            var viewUrl = BASEURL + "jobs/job-details/"+id;
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

        $(document).on("click", ".button-print", function () {
            var id =  $(this).data("target-id");
            var viewUrl = BASEURL + "jobs/job-details/"+id;
            $.ajax({
                type: "GET",
                url: viewUrl,
                data:{type:'print'},
                cache: false,
                success: function (data) {
                    var printContents = data;
                    var originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;
                    window.print();
                    document.body.innerHTML = originalContents;
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

    });



</script>