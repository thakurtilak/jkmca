<div class="view_order_info">
    <!--Request Invoice Details -->
    <h3 class="form-box-title"> User Details</h3>
    <ul class="order_view_detail">
        <li>
            <div class="order_info_block">
                <span class="ov_title">Name</span>
                <span class="ov_data"><?php echo $generatorInfo->name; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Email Id</span>
                <span class="ov_data"><?php echo $generatorInfo->email; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Role</span>
                <span class="ov_data"><?php echo $rolename->role_name; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Role Status</span>
                <span class="ov_data"><?php echo $generatorInfo->status; ?></span>
            </div>
        </li>
    </ul>