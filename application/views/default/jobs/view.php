<div class="view_order_info">
    <!--Request Invoice Details -->
    <!-- <h3 class="form-box-title">Request Invoice Details</h3>-->
    <ul class="order_view_detail">
        <li>
            <div class="order_info_block">
                <span class="ov_title">Job ID</span>
                <span class="ov_data"><?php echo $jobDetail->job_number; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Work Type</span>
                <span class="ov_data"><?php echo $jobDetail->work; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Created Date</span>
                <span class="ov_data"><?php echo date('d-M-Y', strtotime($jobDetail->created_date)); ?></span>
            </div>
        </li>

        <li>
            <div class="order_info_block">
                <span class="ov_title">Amount</span>
                <span class="ov_data"><?php echo formatAmount($jobDetail->amount); ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Advanced Amount</span>
                <span class="ov_data"><?php echo formatAmount($jobDetail->advanced_amount); ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Remaining Amount</span>
                <span class="ov_data"><?php echo formatAmount($jobDetail->remaining_amount); ?></span>
            </div>
        </li>

        <li class="od_block">
            <div class="order_info_block">
                <span class="ov_title">Requested By</span>
                <span class="ov_data"><?php echo $jobDetail->requestorname; ?></span>
            </div>
        </li>
        <li class="od_block">
            <div class="order_info_block">
                <span class="ov_title">Assign TO</span>
                <span class="ov_data"><?php echo $staffName; ?></span>
            </div>
        </li>

        <li class="od_block">
            <div class="order_info_block">
                <span class="ov_title">Tentative Completion Date</span>
                <span class="ov_data"><?php echo date('d-M-Y', strtotime($jobDetail->completion_date)); ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Client Name</span>
                <span class="ov_data"><?php echo $jobDetail->first_name;
                echo ($jobDetail->middle_name) ? " ".$jobDetail->middle_name :'';
                echo ($jobDetail->last_name) ? " ".$jobDetail->last_name :'';
                ?></span>
            </div>
            </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Client Address</span>
                <span class="ov_data"><?php echo $jobDetail->address; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Client Mobile No.</span>
                <span class="ov_data"><?php echo $jobDetail->mobile_number; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Attached Job Card</span>
                <?php if(isset($jobCard) && !empty($jobCard)): ?>
                       <?php
                        $fileURl = $jobCard->file_path;
                        ?>
                        <span class="ov_data"><a href="<?php echo base_url();?><?php echo $fileURl; ?>" title="<?php echo $jobCard->file_name; ?>" target="_blank"><?php echo $jobCard->file_name; ?></a></span>
                <?php else: ?>
                    <span class="ov_data">No Attachment</span>
                <?php endif; ?>
            </div>
        </li>
        <li>
        <div class="order_info_block">
            <span class="ov_title">Remark</span>
            <span class="ov_data"><?php echo $jobDetail->remark ?></span>
        </div>
        </li>
    </ul>
    <h3 class="form-box-title">Documents</h3>
    <div class="ims_datatable table-responsive" style="background: #FFFFFF;">
        <!-- <h3 class="form-box-title">Client Details </h3>-->
        <table id="clientList" class="table table-striped table-bordered table-condensed table-hover" cellspacing="0" width="100%">
            <thead>
            <tr>
                <th>Document Name</th>
                <th>Attached File</th>
            </tr>
            </thead>
            <tbody>
            <?php
            if(count($jobDocuments)):
                foreach ($jobDocuments as $doc): ?>
                    <tr>
                        <td><?php echo ($doc->attach_type != 0) ? $doc->documentName : $doc->other_file_name; ?></td>
                        <td><span class="ov_data"><a href="<?php echo base_url();?><?php echo $doc->attach_file_path; ?>" title="<?php echo $doc->attach_file_name; ?>" target="_blank"><?php echo $doc->attach_file_name; ?></a></span></td>
                    </tr>
                <?php   endforeach;
            else: ?>
                <tr>
                    <td colspan="2">No Document found</td>
                </tr>
             <?php endif;
            ?>
            </tbody>
        </table>
    </div>
</div><!--view_invoice_info -->