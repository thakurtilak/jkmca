<div class="view_order_info">
    <div class="box-form">
        <div class="theme-form">
            <h3 class="form-box-title">Client Details</h3>
            <ul class="order_view_detail">
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">First Name</span>
                        <span class="ov_data"><?php echo $clientInfo->first_name; ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Middle Name</span>
                        <span class="ov_data"><?php echo $clientInfo->middle_name; ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Last Name</span>
                        <span class="ov_data"><?php echo $clientInfo->last_name; ?></span>
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
                        <span class="ov_data"><?php echo $clientInfo->father_first_name; ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Middle Name</span>
                        <span class="ov_data"><?php echo $clientInfo->father_middle_name; ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Last Name</span>
                        <span class="ov_data"><?php echo $clientInfo->father_last_name; ?></span>
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
                        <span class="ov_data"><?php echo $clientInfo->mobile; ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Email</span>
                        <span class="ov_data"><?php echo $clientInfo->email; ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">DOB</span>
                        <span class="ov_data"><?php echo ($clientInfo->dob) ? date('d-M-Y', strtotime($clientInfo->dob)):'--'; ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">PAN NO.</span>
                        <span class="ov_data"><?php echo $clientInfo->pan_no; ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Aadhar NO.</span>
                        <span class="ov_data"><?php echo $clientInfo->aadhar_number; ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">GSTIN NO.</span>
                        <span class="ov_data"><?php echo $clientInfo->gst_no; ?></span>
                    </div>
                </li>
            </ul>
        </div>
    </div>

    <div class="box-form">
        <div class="theme-form">
            <h3 class="form-box-title">Address Details</h3>
            <ul class="order_view_detail">
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Address 1</span>
                        <span class="ov_data"><?php echo $clientInfo->address1; ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Address 2</span>
                        <span class="ov_data"><?php echo $clientInfo->address2; ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">City</span>
                        <span class="ov_data"><?php echo $clientInfo->city; ?></span>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Zip Code</span>
                        <span class="ov_data"><?php echo $clientInfo->zip_code; ?></span>
                    </div>
                </li>

            </ul>
        </div>
    </div>
    <div class="box-form">
        <div class="theme-form">
            <h3 class="form-box-title">Documents</h3>
            <div class="ims_datatable table-responsive" style="background: #FFFFFF;">
                <!-- <h3 class="form-box-title">Client Details </h3>-->
                <table id="clientList" class="table table-striped table-bordered table-condensed table-hover"
                       cellspacing="0" width="100%">
                    <thead>
                    <tr>
                        <th>Document Name</th>
                        <th>Attached File</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php
                    if (count($clientDocuments)):
                        foreach ($clientDocuments as $doc): ?>
                            <tr>
                                <td><?php echo ($doc->attach_type != 0) ? $doc->documentName : $doc->other_file_name; ?></td>
                                <td><span class="ov_data"><a
                                                href="<?php echo base_url(); ?><?php echo $doc->attach_file_path; ?>"
                                                title="<?php echo $doc->attach_file_name; ?>"
                                                target="_blank"><?php echo $doc->attach_file_name; ?></a></span></td>
                            </tr>
                        <?php endforeach;
                    else: ?>
                        <tr>
                            <td colspan="2">No Document found</td>
                        </tr>
                    <?php endif;
                    ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>

</div><!--view_order_info -->