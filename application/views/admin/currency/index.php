<div class="content-wrapper">
    <div class="content_header">
        <h3>Manage Currency</h3>
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
                        <div class="col-sm-12">
                            <div class="form-group text-right">
                                <a href="<?php echo base_url('admin/currency/add'); ?>"  class="mdl-js-button mdl-js-ripple-effect btn-view action-btn">Add New</a>
                            </div>
                        </div><!--col-sm-3-->
                    </div><!--row-->
                </div><!--order_filter-->
                <div class="ims_datatable">
                    <h3 class="form-box-title">Currency List</h3>
                    <table id="currency_list_datatable" class="table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Sn No</th>
                            <th>Currency Name</th>
                            <th>Currency Symbol</th>
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
            var table = $('#currency_list_datatable').DataTable({
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search..."
                },
                "order": [[ 1, "desc" ]],
                "columnDefs": [
                    {
                        "targets": [ 0, 4 ],
                        "orderable":false,
                    },
                ],

                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": BASEURL + "admin/currency"
                },
                "columns": [
                    {"data":"s_no"},
                    { "data": "currency_name" },
                    { "data": "currency_symbol" },
                    { "data": "currency_status" },
                    { "data": "action"}
                ]

            });
        });
    </script>