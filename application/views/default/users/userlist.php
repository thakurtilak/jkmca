<div class="content-wrapper">
    <div class="content_header">
        <h3>Users List</h3>
        <div class="add_new_btn text-right">
            <a href="<?php echo base_url(); ?>users/add" class="mdl-js-button mdl-js-ripple-effect btn-event" data-upgraded=",MaterialButton,MaterialRipple">Add User</a>
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
            <form name="main" method="post" onSubmit="">
            <div class="order_filter">
                <div class="row">
                    <div class="col-sm-12"><h3 class="form-box-title">Filter user By</h3></div>
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="ims_form_control" name="role_id" id="role_id">
                                <option value="">Select User Role</option>
                                <?php
                                if(isset($roles) && $roles){
                                    foreach($roles as $role) { ?>
                                        <option value="<?php echo $role->id; ?>"><?php echo $role->role_name; ?></option>
                                  <?php  }
                                }
                                ?>
                            </select>
                        </div>
                    </div><!--col-sm-3-->
                    <div class="col-sm-3">
                        <div class="form-group">
                            <select class="ims_form_control" id="status">
                                <option value="">Select Status</option>
                                <option value="A">Active</option>
                                <option value="I">Inactive</option>
                            </select>
                        </div>
                    </div><!--col-sm-3-->
                    
                </div><!--row-->
            </div><!--order_filter-->
            <div class="ims_datatable">
                <!--<h3 class="form-box-title">Users List</h3>-->
                <table id="users_list_datatable" class="table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Sn No</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Email</th>
                            <th>Role</th>
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
    //$('#users_list').DataTable();
    /*Data table initialization*/
    var table = $('#users_list_datatable').DataTable({
        language: {
            search: "_INPUT_",
            searchPlaceholder: "Search..."
        },
        "order": [[ 1, "desc" ]],
        "columnDefs": [
            {
                "targets": [ 0, 6 ],
                "orderable":false,
            },
        ],

        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": BASEURL + "users",
            "data": function ( d ) {
                d.role_id = $('#role_id').val();
                d.status = $('#status').val();
            }
        },
        "columns": [
            {"data":"s_no"},
            { "data": "first_name" },
            { "data": "last_name" },
            { "data": "email" },
            { "data": "role_name"},
            { "data": "status"},
            { "data": "action"}
        ]

    });

    /*Custom Filter drop down*/
    $("#role_id, #status").on("change", function() {
        table.draw();
    });
});            
</script>