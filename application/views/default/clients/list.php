<div class="content-wrapper">
    <div class="content_header">
        <h3>Client List</h3>
        <?php if($isSuperAdmin || $isRecieptionist): ?>
         <div class="add_new_btn text-right">
                           <a href="<?php echo base_url(); ?>clients/add-client" class="mdl-js-button mdl-js-ripple-effect btn-event" data-upgraded=",MaterialButton,MaterialRipple">Add Client</a>
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
                    <!--<div class="col-sm-12"><h3 class="form-box-title">View Orders </h3></div>-->
					<!--col-sm-6-->
                    <!--<div class="col-sm-3">
                        <div class="form-group">
                            <select class="ims_form_control" name="category_id" id="category_id">
                                <option value="">Select Category</option>
                                <?php /*foreach($categories as $rows) { */?>
                                    <option value="<?php /*echo $rows->id; */?>"><?php /*echo ucfirst($rows->category_name)*/?></option>
                                <?php /*} */?>
                            </select>
                        </div>
                    </div>--><!--col-sm-3-->

                    <!--<div class="col-sm-3">
                        <div class="form-group">
                            <select class="ims_form_control" name="status_id" id="status_id">
                                <option value="">Select Status</option>
                                <option value="1">Enable</option>
                                <option value="0">Disable</option>
                            </select>
                        </div>
                    </div>--><!--col-sm-3-->

                   
                </div><!--row-->
            </div><!--order_filter-->
            <div class="ims_datatable table-responsive">
               <!-- <h3 class="form-box-title">Client Details </h3>-->
                <table id="clientList" class="table" cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th width="5%">Code</th>
                        <th width="15%">Name</th>
                        <th>Father Name</th>
                        <th>PAN</th>
                        <th>Aadhar NO.</th>
                        <th>Mobile NO.</th>
                        <th width="95px">Action</th>
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
         table = $("#clientList").DataTable({
            // "bInfo": false,
            language: {
                search: "_INPUT_",
                searchPlaceholder: "Search...",
                "zeroRecords": "No Records to display."

            },
            "order": [[ 1, "ASC" ]],
            "columnDefs": [
                {
                    "targets": 0,
                    "searchable": false,
                    "orderable": false,
                },
                {
                    "targets": [ 3 ],
                    "orderable":false
                },
                {
                    "targets": [ 6 ],
                    "orderable":false
                }
            ],
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": BASEURL + "clients",
                "data": function ( d ) {

                }

            },
            "columns": [
                { "data": "client_id" },
                { "data": "client_name" },
                { "data": "father_name" },
                { "data": "pan_no" },
                { "data": "aadhar_no" },
                { "data": "mobile" },
                { "data": "action"},
            ]
      });



        /*Custom Filter drop down*/
        $("#category_id, #status_id").on("change", function() {
            table.draw();
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

    });
</script>