<div class="content-wrapper">
    <div class="content_header">
        <h3>Inquiry List</h3>
        <?php if($isSuperAdmin || $isRecieptionist): ?>
         <div class="add_new_btn text-right">
                           <a href="<?php echo base_url(); ?>inquiry/new" class="mdl-js-button mdl-js-ripple-effect btn-event" data-upgraded=",MaterialButton,MaterialRipple">Add New Inquiry</a>
         </div>
        <?php endif; ?>
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
        <div class="">
            <div class="order_filter">
                <div class="row">
                    <div class="col-sm-12 pull-right" style="text-align: right; font-size: 25px;">
                        <a href="javascript:void(0)" id="exportAllInquiry" style="font-size: 25px;" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" title="Export Excel"><i class="fa fa-file-excel-o" aria-hidden="true"></i></a>
                    </div>
                </div>
            </div><!--order_filter-->
            <div class="ims_datatable table-responsive">
               <!-- <h3 class="form-box-title">Client Details </h3>-->
                <table id="inquiryList" class="table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th width="5%">Ref No.</th>
                        <th width="15%">Name</th>
                        <th>Father Name</th>
                        <th>PAN</th>
                        <th>Aadhar NO.</th>
                        <th>Mobile NO.</th>
                        <th>Status</th>
                        <th>Inquiry Date</th>
                        <th width="140px">Action</th>
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
<!-- View client Modal-->
<div id="ClientViewModal" class="modal">
    <div class="modal-dialog modal-lg zoomIn animated">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Inquiry Information</h4>
            </div>
            <div class="modal-body view-details custom_client_scroll">
            </div>
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
        </div>
    </div>
</div>
<!--Approve/reject-->
<div class="modal fade" id="cancelInquiryModel" tabindex="-1" role="dialog" aria-labelledby="cancelModalLabel" aria-hidden="true">
    <div class="modal-dialog cancel-order-modal zoomIn animated" role="document">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="cancelModalLabel">Cancel Inquiry</h4>
            </div>
            <div class="modal-body cancel_form">

            </div>
            <!-- <div class="modal-footer">
               <button class="btn btn-secondary" type="button" data-dismiss="modal">NO</button>
                <a id="cancelTargetUrl" class="btn btn-primary" href="<?php /*echo base_url(); */?>orders/cancel-order">YES</a>
            </div>-->
        </div>
    </div>
</div>

<!--Delete -->
<div class="modal fade" id="deleteInquiryModel" tabindex="-1" role="dialog" aria-labelledby="deleteModalLabel" aria-hidden="true">
    <div class="modal-dialog cancel-order-modal zoomIn animated" role="document">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
                <h4 class="modal-title" id="deleteModalLabel">Delete Inquiry</h4>
            </div>
            <div class="modal-body cancel_form" style="text-align:center; margin-bottom:10px;">
            <div class="alert alert-danger" id="errorMessageDel" style="display: none;"></div>
            <input type="hidden" name="refIdDel" id="refIdDel" value="">
             Are you sure to delete Job Inquiry <b><span id="InqRef"></span></b>?
            </div>
            <div class="form-footer" style="text-align:center; margin-bottom:10px;">
                <button id="deleteButton" type="button" value="DELETE" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white" name="Update">DELETE</button>
                <button class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" data-dismiss="modal">No</button>
            </div>
        </div>
    </div>
</div>
<!-- View Modal-->
<!--=============== End View Modal ======================-->
<script type="text/javascript">
    var table;
    $(document).ready(function(){

        /*Data table initialization*/
         table = $("#inquiryList").DataTable({
            // "bInfo": false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search...",
                "zeroRecords": "No Records to display."

            },
            "order": [[ 7, "DESC" ]],
            "columnDefs": [
                {
                    "targets": 2,
                    "visible": false,
                    //"orderable": false,
                },
                {
                    "targets": [0,3,4,5,8 ],
                    "orderable":false
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": BASEURL + "inquiry",
                "data": function ( d ) {

                }

            },
            "columns": [
                { "data": "ref_no" },
                { "data": "client_name" },
                { "data": "father_name" },
                { "data": "pan_no" },
                { "data": "aadhar_no" },
                { "data": "mobile" }, 
                { "data": "status"},
                { "data": "inquiry_date"},
                { "data": "action"},
            ]
      });



        /*Custom Filter drop down*/
        $("#category_id, #status_id").on("change", function() {
            table.draw();
        });

        /* View Model window*/

        /*Client View Model window*/
        $("#ClientViewModal").on("show.bs.modal", function(e) {
            var modal = $(this);
            modal.find('.view-details').html("");
            var id = $(e.relatedTarget).data('target-id');
            var viewUrl = BASEURL + "inquiry/view/"+id;
            $.ajax({
                type: "GET",
                url: viewUrl,
                cache: false,
                data:{type:'view'},
                success: function (data) {
                    modal.find('.view-details').html(data);
                    $(".custom_client_scroll").mCustomScrollbar();
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $("#cancelInquiryModel").on("show.bs.modal", function(e) {
            var modal = $(this);
            modal.find('.cancel_form').html("");
            var id = $(e.relatedTarget).data('target-id');
            var viewUrl = BASEURL + "inquiry/cancel-form/"+id;
            $.ajax({
                type: "GET",
                url: viewUrl,
                cache: false,
                success: function (data) {
                    modal.find('.cancel_form').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });


        $("#deleteInquiryModel").on("show.bs.modal", function(e) {
            $("#errorMessageDel").text('').hide();
            var modal = $(this);
            //modal.find('.cancel_form').html("");
            var refId = $(e.relatedTarget).data('target-id');
            $("#InqRef").html(refId);
            $("#refIdDel").val(refId);
            
        });

        $("#ClientViewModal").on("hide.bs.modal", function() {
            $(".custom_client_scroll").mCustomScrollbar("destroy");
        });

        $(document).on("click", ".button-print", function () {
            var id =  $(this).data("target-id");
            var viewUrl = BASEURL + "inquiry/view/"+id;
            $.ajax({
                type: "GET",
                url: viewUrl,
                data:{type:'print'},
                cache: false,
                success: function (data) {
                    var printContents = data;
                    var originalContents = document.body.innerHTML;
                    document.body.innerHTML = printContents;
                    document.title = 'JKMCA';
                    window.print();
                    document.body.innerHTML = originalContents;
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $(document).on("click", "#deleteButton", function () {
            var refId = $("#refIdDel").val();
            console.log(refId);
            var SubmitURL = BASEURL + "inquiry/delete/"+refId;
            $.ajax({
                type: "POST",
                url: SubmitURL,
                cache: false,
                success: function (data) {
                    var response = $.parseJSON(data);
                    if(response.success) {
                        $("#deleteInquiryModel").modal('hide');
                        table.draw();
                    } else {
                        $("#errorMessageDel").show().text("There is an error while delete Inquiry.");
                    }
                    //modal.find('.payment_form').html(data);
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $("#exportAllInquiry").click(function () {
            var searchKey = $('input[type=search]').val();
            $url = BASEURL +"inquiry/download-all?searchKey="+searchKey;
            window.location = $url;
        });
        
    });
</script>