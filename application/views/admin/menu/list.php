<div class="content-wrapper">
    <div class="content_header">
        <h3>Manage Menu</h3>
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
                <div class="alert alert-info" style="margin-top:18px;">
                    <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
                    <?php echo $this->session->flashdata('success'); ?>
                </div>
            <?php } ?>
            <div class="col-sm-12 pad0">
                <div class="form-group text-right">
                    <a href="<?php base_url(); ?>menu/add" class="add_more_btn mdl-js-button mdl-js-ripple-effect ripple-white">Add New</a>
                </div>
            </div><!--col-sm-3-->
            <form name="main" method="post" onSubmit="">
            <div class="ims_datatable">
                <h3 class="form-box-title">Users List</h3>
                <table id="menu_list" class="table" cellspacing="0" width="100%">
                    <thead>
                        <tr>
                            <th>Menu Name</th>
                            <th>Menu URL</th>
                            <th>Menu Type</th>
                            <th>Is Active</th>
                            <th width="15%">Action</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        foreach ($menuList as $row)
                        {
                            ?><tr>
                            <td><?php echo $row->display_name;?></td>
                            <td><?php echo $row->redirect_url;?></td>
                            <td><?php echo $row->menu_type;?></td>
                            <td><?php echo ($row->is_active == 'Y')? 'Yes':'No';?></td>
                            <td><a href="<?php echo site_url('admin/menu/edit/'.$row->menu_id); ?>"  class="mdl-js-button mdl-js-ripple-effect btn-view action-btn">Edit</a></td>
                            </tr>
                        <?php }
                        ?>
                    </tbody>
                </table>
            </div><!--ims_datatable-->
            </form>
        </div><!--row-->
    </div><!--inner_bg-->  
<script>
$(document).ready(function(){
    $('#menu_list').DataTable();
});            
</script>