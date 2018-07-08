<div class="content-wrapper">
    <div class="content_header">
        <h3>View Jobs</h3>
        <div class="add_new_btn text-right">
            <?php if($isSuperAdmin || $isRecieptionist): ?>
                <a href="<?php echo base_url(); ?>jobs/new-job" class="mdl-js-button mdl-js-ripple-effect btn-event" data-upgraded=",MaterialButton,MaterialRipple">Add New Job</a>
            <?php endif; ?>
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
                                <option value="completed">Complete</option>
                                <option value="pending">Pending</option>
                                <option value="approval_pending">Pending For Review</option>
                                <option value="rejected">Rejected</option>
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
                    <?php if($isSuperAdmin || $isRecieptionist): ?>
                        <div class="col-sm-3">
                            <div class="form-group">
                                <select class="ims_form_control" name="payment_status" id="payment_status">
                                    <option value="">Payment Status</option>
                                    <option value="complete">Complete</option>
                                    <option value="pending">Pending</option>
                                </select>
                            </div>
                        </div><!--col-sm-3-->
                    <?php endif; ?>
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
                        <th>Assign To</th>
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
<div class="modal fade" id="uploadJobFile" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog zoomIn animated" role="document">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="cancelModalLabel">Job File Upload </h4>
            </div>
            <div class="modal-body">
                <form enctype="multipart/form-data" action="<?php echo base_url(); ?>jobs/job-file-upload" method="POST" name="jobFileUploadForm" id="jobFileUploadForm">
                    <div class="form-group">
                        <label class="ims_form_label">Job File Upload</label>
                        <div class="custom-file-upload">
                            <!--<input type="hidden" name="agreement_file[]" id="agreement_file_1"
                                   value="">-->
                            <div class="file-upload-wrapper">
                                <input type="file" name="job_file" id="job_file"
                                       class="ims_form_control upload_icon custom-file-upload-hidden valid"
                                       placeholder="Job File Upload*" tabindex="-1"
                                       aria-invalid="false"
                                       style="position: absolute; left: -9999px;">
                                <input type="text" name="file-upload-input"
                                       class="file-upload-input" placeholder="Job File Upload"
                                       readonly>
                                <button type="button"
                                        class="file-upload-button file-upload-select"
                                        tabindex="-1">

                                </button>
                            </div>
                            <label id="file-upload-input-error" class="error"
                                   for="file-upload-input" style="display: none;"></label>
                        </div>
                    </div>
                    <div class="form-footer">
                        <button type="submit" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white">Upload</button>
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
<!--Approve/reject-->
<div class="modal fade" id="approveRejectJob" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog cancel-order-modal zoomIn animated" role="document">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="cancelModalLabel">JOB Approve/Reject</h4>
            </div>
            <div class="modal-body">
                <form action="<?php echo base_url(); ?>jobs/approve-reject" method="POST" name="approveRejectJobForm" id="approveRejectJobForm">
                    <div class="form-group">
                        <label class="control-label">Comment<sup>*</sup></label>
                        <textarea class="ims_form_control" name="comment" id="comment"  rows="3" required placeholder="Comment"></textarea>
                    </div>
                    <div class="form-footer">
                        <button type="submit" value="approved" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white" name="Approve">Approve</button>
                        <button type="submit" value="reject" class="btn-theme btn-pink mdl-js-button mdl-js-ripple-effect ripple-white" name="Reject">Reject</button>
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

        /*File Handling*/
        $(document).on("click", ".file-upload-button", function () {
            $(this).parent().find("input[type='file']").click();
        });
        $(document).on("change", ".custom-file-upload-hidden", function () {
            var fileID = $(this).attr("id");
            var filename = $("#" + fileID).val().split("\\").pop();
            $("#" + fileID).parent().find(".file-upload-input").val(filename);
        });

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
                    d.payment_status = $("#payment_status").val();
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
        $("#work_type, #status_id, #month, #payment_status").on("change", function() {
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

        /*Cancel Order Model window*/
        $("#uploadJobFile").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('target-id');
            var jobFileHref = BASEURL + "jobs/job-file-upload/"+id;
            $("#jobFileUploadForm").prop('action', jobFileHref);

        });

        $("#approveRejectJob").on("show.bs.modal", function(e) {
            var id = $(e.relatedTarget).data('target-id');
            var jobFileHref = BASEURL + "jobs/approve-reject-job/"+id;
            $("#approveRejectJobForm").prop('action', jobFileHref);
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

        $("#jobFileUploadForm").validate({
            ignore: ":hidden:not(.file-upload-input)",
            rules: {
                "file-upload-input": {required: true,extension:"gif|jpg|png|jpeg|pdf|zip|docx|doc|xls|xlsx|eml|msg"},
               },
            messages: {
                "file-upload-input": {required: "This field is required",extension:"Invalid file format"},
            }
        });

    });



</script>