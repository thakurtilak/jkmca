<div class="view_order_info">
    <!--<h3 class="form-box-title">Client Details</h3>-->
    <ul class="order_view_detail">
        <li>
            <div class="order_info_block">
                <span class="ov_title">Client Name</span>
                <span class="ov_data"><?php echo $clientInfo->client_name; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Address Line 1</span>
                <span class="ov_data"><?php echo $clientInfo->address1; ?></span>
            </div>
        </li>
        <li>
            <div class="order_info_block">
                <span class="ov_title">Address Line 2</span>
                <span class="ov_data"><?php echo $clientInfo->address2; ?></span>
            </div>
        </li>
    </ul>
    <h3 class="form-box-title">Project Manager Details</h3>
    <ul class="order_view_detail">
        <?php if(isset($salesPersons)  && count($salesPersons)):
            foreach($salesPersons as $salesPerson):
            ?>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Name</span>
                    <span class="ov_data"><?php echo $salesPerson->sales_person_name; ?></span>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Contact Number</span>
                    <span class="ov_data"><?php echo $salesPerson->sales_contact_no; ?></span>
                </div>
            </li>
            <li class="od_block">
                <div class="order_info_block">
                    <span class="ov_title">Email Id</span>
                    <span class="ov_data"><?php echo $salesPerson->sales_person_email; ?></span>
                </div>
            </li>
        <?php endforeach; endif; ?>

    </ul>

    <?php if(isset($accountPersons)  && count($accountPersons)): ?>
        <h3 class="form-box-title">Account Person details</h3>
   <?php foreach($accountPersons as $accountPerson):
    ?>
    <ul class="order_view_detail">

            <li>
                <div class="order_info_block">
                    <span class="ov_title">Name</span>
                    <span class="ov_data"><?php echo $accountPerson->account_person_name; ?></span>
                </div>
            </li>
            <li>
                <div class="order_info_block">
                    <span class="ov_title">Contact Number</span>
                    <span class="ov_data"><?php echo $accountPerson->account_contact_no; ?></span>
                </div>
            </li>
            <li class="od_block">
                <div class="order_info_block">
                    <span class="ov_title">Email Id</span>
                    <span class="ov_data"><?php echo $accountPerson->account_person_email; ?></span>
                </div>
            </li>

    </ul>
    <?php endforeach; endif; ?>

    <?php if(isset($clientAgreements)  && count($clientAgreements)): ?>
    <h3 class="form-box-title">Agreement details</h3>
    <ul class="order_view_detail">

          <?php  foreach($clientAgreements as $agreement):
                ?>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Name</span>
                        <?php if(isset($clientAgreements) && !empty($clientAgreements)):

                    $originalName = trim(strstr($agreement->agreement_name, '_'), '_');
                    ?>
                            <a href="<?php echo base_url();?>uploads/client_agreements/<?php echo $agreement->client_id.'/'.$agreement->agreement_name; ?>" title="<?php echo $originalName; ?>" target="_blank"><?php echo $originalName; ?></a>

                        <?php else: ?>
                            <span class="ov_data">No Attachment</span>
                        <?php endif; ?>
                    </div>
                </li>
                <li>
                    <div class="order_info_block">
                        <span class="ov_title">Number</span>
                        <span class="ov_data"><?php echo $agreement->agreement_no; ?></span>
                    </div>
                </li>
                <li class="od_block">
                    <div class="order_info_block">
                        <span class="ov_title">Date</span>
                        <span class="ov_data"><?php echo $agreement->agreement_date; ?></span>
                    </div>
                </li>
          <?php endforeach;?>
    </ul>
        <?php endif; ?>

</div><!--view_order_info -->