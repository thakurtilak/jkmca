<div class="content-wrapper">
    <div class="content_header">
        <h3>Manage Tax</h3>
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
                                <select class="ims_form_control" name="financialYear" id="financialYear">
                                    <option value="">Financial Year</option>
                                    <?php if($financialYears) : foreach($financialYears as $year): ?>
                                        <option <?php echo ($year == $currentYear) ? 'selected':'';?> value="<?php echo $year; ?>"><?php echo $year; ?></option>
                                    <?php endforeach; endif; ?>
                                </select>
                            </div>
                        </div><!--col-sm-3-->
                        <div class="col-sm-9">
                            <div class="form-group text-right">
                                <a href="<?php echo base_url('admin/tax/add'); ?>"  class="mdl-js-button mdl-js-ripple-effect btn-view action-btn">Add New</a>
                            </div>
                        </div><!--col-sm-3-->
                    </div><!--row-->
                </div><!--order_filter-->
                <div class="ims_datatable">
                    <h3 class="form-box-title">Tax List</h3>
                    <table id="tax_list_datatable" class="table" cellspacing="0" width="100%">
                        <thead>
                        <tr>
                            <th>Sn No</th>
                            <th>Tax Name</th>
                            <th>Tax</th>
                            <th>Financial Year</th>
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
            var table = $('#tax_list_datatable').DataTable({
                "bPaginate": false,
                "bInfo":false,
                language: {
                    search: "_INPUT_",
                    searchPlaceholder: "Search..."
                },
                "order": [[ 1, "ASC" ]],
                "columnDefs": [
                    {
                        "targets": [ 0, 3, 4 ],
                        "orderable":false,
                    },
                ],

                "processing": true,
                "serverSide": true,
                "ajax": {
                    "url": BASEURL + "admin/tax",
                    "data": function ( d ) {
                        d.financialYear = $('#financialYear').val();
                        //d.status = $('#status').val();
                    }
                },
                "columns": [
                    {"data":"s_no"},
                    { "data": "tax_detail" },
                    { "data": "tax" },
                    { "data": "financial_year" },
                    { "data": "action"}
                ]

            });
            /*Custom Filter drop down*/
            $("#financialYear").on("change", function() {
                table.draw();
            });
        });
    </script>