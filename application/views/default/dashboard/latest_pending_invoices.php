<div class="row">
<div class="col-sm-12">
    <div class="dash_box_block fadeInLeft animated">
        <div class="dash_box_header">
            <div class="row">
                <div class="col-sm-8">
                    <h3 class="dash_box_header-title">Pending Invoices <span class="ims_tooltip" data-toggle="tooltip" data-placement="right" title="List of latest 10 Invoices those not approved by Account department"><i class="fa fa-info-circle"></i></span></h3>
                </div>
                <div class="more_result text-right">
                    <a href="<?php echo base_url();?>invoice/raised-invoices" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" data-upgraded=",MaterialButton,MaterialRipple">View all<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a>
                </div>
            </div>
        </div><!--dash_box_header-->
        <div class="dash_box_body">
            <div class="table-theme table-responsive">
                <table class="table">
                    <thead>
                    <tr>
                        <th>Request Date</th>
                        <th>Client Name</th>
                        <th>Activity Name</th>
                        <th>Net Amt</th><!--
                        <th>Status</th>-->
                        <th>View</th>
                    </tr>
                    </thead>
                    <tbody>
                    <?php if(count($data)):
                        foreach($data as $invoice):
                            if ($invoice->invoice_acceptance_status == 'Pending') {
                                $actionLink = "Not Invoiced";
                            }else if ($invoice->invoice_acceptance_status == 'Accept') {
                                $actionLink = "Invoiced";
                            } else {
                                $actionLink = "Rejected";
                            }
                        ?>
                        <tr>
                            <td><?php echo date('d-M-Y', strtotime($invoice->invoice_originate_date)) ?></td>
                            <td><?php echo $invoice->client_name; ?></td>
                            <td><?php echo $invoice->project_name; ?></td>
                            <td><?php echo $invoice->currency_symbol . ' ' . formatAmount($invoice->invoice_net_amount); ?></td>
                            <!--<td><?php /*echo $actionLink; */?></td>-->
                            <td><a class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" href="#InvoiceDetailModal" data-toggle="modal" data-target-id="<?php echo $invoice->invoice_req_id; ?>" title="View"><i class='icon-view1'></i></a></td>
                        </tr>
                    <?php endforeach; else: ?>
                    <tr>
                        <td colspan="5">No Pending invoices</td>
                    </tr>
                    <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div><!--dash_box_body-->
    </div><!--dash_box_block-->
</div><!--col-sm-12-->
</div><!--row-->