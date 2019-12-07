<div class="view_order_info">
    <div class="box-form">
        <div class="theme-form">
            <h3 class="form-box-title">Info</h3>
            <ul class="order_view_detail">
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Inquiry Code</span>
                        <span class="ov_data"><?php echo $inquiryDetail->ref_no; ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Inquiry Date</span>
                        <span class="ov_data"><?php echo date('d-M-Y', strtotime($inquiryDetail->created_at)); ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Inquiry Status</span>
                        <span class="ov_data"><?php echo $inquiryDetail->status; ?></span>
                    </div>
                </li>
            </ul>
            <?php if($inquiryDetail->status =='CANCELLED'): ?>
                <ul class="order_view_detail">
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Cancel Reason</span>
                        <span class="ov_data"><?php echo $inquiryDetail->cancel_reason; ?></span>
                    </div>
                </li>    
            </ul>
            <?php endif; ?>
        </div>
    </div>
    <div class="box-form">
        <div class="theme-form">
            <h3 class="form-box-title">Client Details</h3>
            <ul class="order_view_detail">
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">First Name</span>
                        <span class="ov_data"><?php echo $inquiryDetail->first_name; ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Last Name</span>
                        <span class="ov_data"><?php echo $inquiryDetail->last_name; ?></span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-form">
        <div class="theme-form">
            <h3 class="form-box-title">Father's Details</h3>
            <ul class="order_view_detail">
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">First Name</span>
                        <span class="ov_data"><?php echo $inquiryDetail->fathers_first_name; ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Last Name</span>
                        <span class="ov_data"><?php echo $inquiryDetail->fathers_last_name; ?></span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
    <div class="box-form">
        <div class="theme-form">
            <h3 class="form-box-title">Personal Details</h3>
            <ul class="order_view_detail">
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Mobile NO.</span>
                        <span class="ov_data"><?php echo $inquiryDetail->mobile; ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">PAN NO.</span>
                        <span class="ov_data"><?php echo $inquiryDetail->pan_no; ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Aadhar NO.</span>
                        <span class="ov_data"><?php echo $inquiryDetail->aadhar_no; ?></span>
                    </div>
                </li>
            </ul>
        </div>
    </div>
</div><!--view_order_info -->