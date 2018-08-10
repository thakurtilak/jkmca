<div class="content-wrapper">
    <div class="content_header">
        <h3>Payment Laser</h3>
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
                    <div class="col-sm-4">
                        <div class="form-group1">
                            <label class="form_label pull-left">Laser For</label>
                            <div class="pull-right">
                                <div class="radio radio-inline">
                                    <input type="radio" id="laser_for_client" name="laser_for" value="1">
                                    <label for="laser_for_client"> Client</label>
                                </div>
                                <div class="radio radio-inline">
                                    <input type="radio" id="laser_for_manager" name="laser_for" value="0">
                                    <label for="laser_for_manager"> Manager/Responsible</label>
                                </div>
                            </div>
                        </div><!--form-group-->
                    </div>
                    <div class="col-sm-4" >
                        <div class="form-group">
                            <select class="ims_form_control" name="client" id="client">
                                <option value="">Select User</option>
                            </select>
                        </div>
                    </div><!--col-sm-3-->
                    <div class="col-sm-4">
                        <div class="form-group">
                            <select class="ims_form_control" name="work_type" id="work_type">
                                <option value="">Select Work Type</option>
                                <?php foreach($workTypes as $work) { ?>
                                    <option value="<?php echo $work->id; ?>"><?php echo $work->work?></option>
                                <?php } ?>
                            </select>
                        </div>
                    </div><!--col-sm-3-->

                    <div class="col-sm-12 pull-right" style="text-align: right; font-size: 25px;">
                            <a href="javascript:void(0)" id="exportPaymentLaser" style="font-size: 25px; display: none;" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" title="Export Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                    </div><!--col-sm-3-->
                    <!--<div class="col-sm-3">
                        <div class="form-group">
                            <select class="ims_form_control" name="month" id="month">
                                <option value="-1">Job for Month...</option>
                                <option value="<?php /*echo date('Y-m-01');*/?>">This Month - <?php /*echo date('M Y');*/?></option>
                                <?php
/*                                $monthcount=date('n');
                                if($monthcount<4)
                                {
                                    $count=1;
                                    for($i=$monthcount;$i>1;$i--){
                                        if($count==1){
                                            */?>
                                            <option value="<?php /*echo date('Y-m-01',mktime(0, 0, 0, date("m")-$count, date("d"),date("Y")));*/?>">Previous Month <?php /*echo date('M Y',mktime(0, 0, 0, date("m")-$count, date("d"),   date("Y")));*/?> </option>
                                        <?php /*} else { */?>
                                            <option value="<?php /*echo date('Y-m-01',mktime(0, 0, 0, date("m")-$count, date("d"),date("Y")));*/?>"><?php /*echo date('M Y',mktime(0, 0, 0, date("m")-$count, date("d"),   date("Y")));*/?> </option>
                                            <?php
/*                                        } }
                                    for($i=3;$i<12;$i++){
                                        */?>
                                        <option value="<?php /*echo date('Y-m-01',mktime(0, 0, 0, date("m")+$i, date("d"),date("Y")-1));*/?>"><?php /*echo date('M Y',mktime(0, 0, 0, date("m")+$i, date("d"), date("Y")-1));*/?> </option>
                                        <?php
/*                                    } } else{
                                    $count=1;
                                    for($i=$monthcount;$i>1;$i--){
                                        if($count==1){
                                            */?>
                                            <option value="<?php /*echo date('Y-m-01',mktime(0, 0, 0, date("m")-$count, date("d"),date("Y")));*/?>">Previous Month <?php /*echo date('M Y',mktime(0, 0, 0, date("m")-$count, date("d"),   date("Y")));*/?> </option>
                                            <?php
/*                                        }else{ */?>
                                            <option value="<?php /*echo date('Y-m-01',mktime(0, 0, 0, date("m")-$count, date("d"),date("Y")));*/?>"><?php /*echo date('M Y',mktime(0, 0, 0, date("m")-$count, date("d"),   date("Y")));*/?> </option>
                                        <?php /* }
                                        $count++;}
                                    for($i=3;$i<13;$i++){
                                        print '<option value="'.date('Y-m-01',mktime(0, 0, 0, $i , date("d"),date("Y")-1)).'">'.date('M Y',mktime(0, 0, 0, $i, date("d"), date("Y")-1)).'</option>';
                                    }
                                }
                                */?>

                            </select>
                        </div>
                    </div>--><!--col-sm-3-->
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
                        <th>Request Date</th>
                        <th>Remaining Amount</th>
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
<!--Approve/reject-->
<div class="modal fade" id="paymentModel" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog cancel-order-modal zoomIn animated" role="document">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="cancelModalLabel">JOB Payment</h4>
            </div>
            <div class="modal-body payment_form">

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
    var table = null;
    $(document).ready(function(){
        <?php
        if(isset($selectedMonth) && $selectedMonth) { ?>
            var selMonth = "<?php echo $selectedMonth; ?>";
            $("#month").val(selMonth);
       <?php }
        ?>

        /*Data table initialization*/
        table = $('#raisedJobs').DataTable({
            "pageLength": 25,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search..."
            },
            "order": [[ 3, "desc" ]],
            "columnDefs": [
                {
                    "targets": [ 5 ],
                    "orderable":false
                }
            ],

            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": BASEURL + "payment",
                "data": function ( d ) {
                    d.laserFor = $("input[name='laser_for']:checked").val();
                    d.client = $('#client').val();
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
                }
            },
           "columns": [
               {"data":"jobID"},
                { "data": "workName" },
                { "data": "clientName" },
                { "data": "request_date"},
                { "data": "remaining_amount"},
                { "data": "action"}
            ]
        });

        /*function myCallbackFunction (updatedCell, updatedRow, oldValue) {
            console.log("The new value for the cell is: " + updatedCell.data());
            console.log("The values for each cell in that row are: " + updatedRow.data());
        }*/

        /*table.MakeCellsEditable({
            "onUpdate": myCallbackFunction
        });*/

        /*Custom Filter drop down*/
        $("#laser_for_client,#laser_for_manager, #client, #work_type").on("change", function() {
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

        $("#paymentModel").on("show.bs.modal", function(e) {
            var modal = $(this);
            modal.find('.payment_form').html("");
            var id = $(e.relatedTarget).data('target-id');
            var viewUrl = BASEURL + "payment/payment-form/"+id;
            $.ajax({
                type: "GET",
                url: viewUrl,
                cache: false,
                success: function (data) {
                    modal.find('.payment_form').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $("#ClientViewModal").on("hide.bs.modal", function() {
            $(".custom_client_scroll").mCustomScrollbar("destroy");
        });

        $("input[name='laser_for']").change(function () {
            var laserFor = $("input[name='laser_for']:checked").val();
            var viewUrl = BASEURL + "payment/get-laser-for";
            $.ajax({
                type: "POST",
                url: viewUrl,
                cache: false,
                data: {laserFor:laserFor},
                success: function (data) {
                    $("#client").html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $("#exportPaymentLaser").click(function () {
            var Client = $("#client").val();
            if ($('input[name=laser_for]:checked').length > 0 && Client !='') {
                var laserFor = $("input[name='laser_for']:checked").val();
                var client = $('#client').val();
                var work_type = $('#work_type').val();
                var searchKey = $('input[type=search]').val();
                $url = BASEURL +"payment/download-excel?laserFor="+laserFor+"&client="+client+"&work_type="+work_type+"&searchKey="+searchKey;
                window.location = $url;
            } else {
                alert('Please Filter Payment laser before export');
            }
        });

    });



</script>