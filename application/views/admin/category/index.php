<div class="content-wrapper">
    <div class="content_header">
        <h3>Manage Category</h3>
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
            <form name="main" method="post" onSubmit="">
                <div class="order_filter">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="form-group">
                                <select class="ims_form_control" name="type" id="type">
                                    <option value="">Select Category Type </option>
                                    <option selected value="1">Main Category</option>
                                    <option value="2">Sub Category</option>
                                    <option value="3">Order Category</option>
                                    <option value="4">Service Category</option>
                                </select>
                            </div>
                        </div><!--col-sm-3-->
                        <div class="col-sm-9">
                            <div class="form-group text-right">
                                <a href="<?php echo base_url('admin/category/add'); ?>"  class="mdl-js-button mdl-js-ripple-effect btn-view action-btn">Add New</a>
                            </div>
                        </div><!--col-sm-3-->
                    </div><!--row-->
                </div><!--order_filter-->
                <div class="ims_datatable">
                    <h3 class="form-box-title">Category List</h3>
                    <table id="category_list_datatable" class="table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Sn No</th>
                            <th>Category Name</th>
                            <th>Is Service Category</th>
                            <th>Is Order Category</th>
                            <th>Is Active</th>
                            <th width="10%">Action</th>
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
                </div><!--ims_datatable-->
            </form>
        </div><!--row-->
    </div><!--inner_bg-->
    <script>
        $(document).ready(function(){
            /*Data table initialization*/
            var table = $('#category_list_datatable').DataTable({
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search..."
                },
                "order": [[ 1, "ASC" ]],
                "columnDefs": [
                    {
                        "targets": [ 0, 5 ],
                        "orderable":false,
                    },
                ],

                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": BASEURL + "admin/category",
                    "data": function ( d ) {
                        d.type = $('#type').val();
                        //d.status = $('#status').val();
                    }
                },
                "columns": [
                    {"data":"s_no"},
                    { "data": "category_name" },
                    { "data": "is_service_category" },
                    { "data": "is_order_category" },
                    { "data": "status" },
                    { "data": "action"}
                ]

            });
            /*Custom Filter drop down*/
            $("#type, #status").on("change", function() {
                table.draw();
            });
        });
    </script>