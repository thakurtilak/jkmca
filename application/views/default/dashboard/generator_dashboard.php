<div class="content-wrapper">
   <!-- <div class="content_header">
        <h3>Dashboard</h3>
    </div>-->
	<div class="row">
    <?php if($this->session->flashdata('error') != '') { ?>
        <div class="alert alert-danger" id="error_mesg"style="margin-top:18px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php } ?>
    <?php if($this->session->flashdata('success') != '') { ?>
        <div class="alert alert-success" id="success_msg" style="margin-top:18px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php } ?>
	</div>
    <?php if(isset($financialYearPendingInvoices)): ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="revenue_block">
                <div class="rev_block_flex fadeInLeft animated">
                    <div class="rev_box">
                        <div class="rev_chart_icon"><img src="<?php echo base_url(); ?>assets/images/financial_year.svg" width="81" /></div>
                        <div class="rev_info achieve_info">
                            <h3>Financial Year</h3>
                            <h4><?php echo $selectedFinancialYear; ?></h4>
                        </div>
                    </div>
                </div><!--rev_block_flex-->
                <div class="rev_block_flex fadeInLeft animated">
                    <div class="rev_box">
                        <div class="rev_chart_icon"><img src="<?php echo base_url(); ?>assets/images/rev_icon.svg" width="81" /></div>
                        <div class="rev_info achieve_info">
                            <h3>Pending Payment Amount</h3>
                            <h4><i class="fa fa-inr" aria-hidden="true"></i> <?php echo formatAmount($financialYearPendingInvoices); ?></h4>
                        </div>
                    </div>
                </div><!--rev_block_flex-->
            </div><!--revenue_block-->
        </div><!--col-sm-12-->
    </div>
    <?php endif; ?>
     <?php if(isset($pendingInvoices)): ?>
         <div class="row">
             <div class="col-sm-12">
                 <div class="dash_box_block fadeInLeft animated">
                     <div class="dash_box_header">
                         <div class="row">
                             <div class="col-sm-8">
                                 <h3 class="dash_box_header-title">Pending Invoices for Approval</h3>
                             </div>
                             <div class="more_result text-right">
                                 <a href="<?php echo base_url(); ?>dashboard/pending" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" data-upgraded=",MaterialButton,MaterialRipple">View all<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a>
                             </div>
                         </div>
                     </div><!--dash_box_header-->
                     <div class="dash_box_body">
                         <div class="table-theme table-responsive">
                             <table class="table">
                                 <thead>
                                 <tr>
                                     <th>Generate Date</th>
                                     <th>Generated By</th>
                                     <th>Category</th>
                                     <th>Client Name</th>
                                     <th>Invoice Number</th>
                                     <th>Amount</th>
                                     <th style="min-width:100px">Action</th>
                                 </tr>
                                 </thead>
                                 <tbody>
                                 <?php if(count($pendingInvoices)):
                                     foreach($pendingInvoices as $invoice): ?>
                                         <tr>
                                             <td><?php echo date('d-M-Y', strtotime($invoice->invoice_generate_date)); ?></td>
                                             <td><?php echo $invoice->generatedBy; ?></td>
                                             <td><?php echo $invoice->category_name; ?></td>
                                             <td><?php echo $invoice->client_name; ?></td>
                                             <td><?php echo $invoice->invoice_no; ?></td>
                                             <td><?php echo $invoice->currency_symbol . ' ' . formatAmount($invoice->invoice_net_amount); ?></td>
                                             <td><a class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" href="#InvoiceDetailModal" data-toggle="modal" data-target-id="<?php echo $invoice->invoice_req_id; ?>" title="View"><i class='icon-view1'></i></a>
                                                <a class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" inv-id="<?php echo $invoice->invoice_req_id;?>" href='<?php echo base_url(); ?>invoice/invoice-approval/<?php echo $invoice->invoice_req_id; ?>' title="Generate invoice"><i class='icon-generate_invoice'></i></a></td>
                                         </tr>
                                     <?php endforeach; else: ?>
                                     <tr>
                                         <td colspan="7">No pending invoices</td>
                                     </tr>
                                 <?php endif; ?>
                                 </tbody>
                             </table>
                         </div>
                     </div><!--dash_box_body-->
                 </div><!--dash_box_block-->
             </div><!--col-sm-12-->
         </div>
    <?php endif; ?>
    <div class="row">
    <div class="col-sm-12">
        <div class="dash_box_block fadeInLeft animated">
            <div class="dash_box_header">
                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="dash_box_header-title">Raised Invoices</h3>
                    </div>
                    <div class="more_result text-right">
                        <a href="<?php echo base_url(); ?>collections" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" data-upgraded=",MaterialButton,MaterialRipple">View all<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a>
                    </div>
                </div>
            </div><!--dash_box_header-->
            <div class="dash_box_body">
                <div class="table-theme">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Request Date</th>
                            <th>Invoice No.</th>
                            <th>Invoice Date</th>
                            <th>Requested By</th>
                            <th>Client Name</th>
                            <th>Net Amt</th>
                            <!--<th>Status</th>-->
                            <th>View</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($raisedInvoices) && count($raisedInvoices)):
                            foreach($raisedInvoices as $invoice):
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
                                    <td><?php echo $invoice->invoice_no; ?></td>
                                    <td><?php echo date('d-M-Y', strtotime($invoice->invoice_date)) ?></td>
                                    <td><?php echo $invoice->requestBy; ?></td>
                                    <td><?php echo $invoice->client_name; ?></td>
                                    <td><?php echo $invoice->currency_symbol . ' ' . formatAmount($invoice->invoice_net_amount); ?></td>
                                   <!-- <td><?php /*echo $actionLink; */?></td>-->
                                    <td><a class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" href="#InvoiceDetailModal" data-toggle="modal" data-target-id="<?php echo $invoice->invoice_req_id; ?>" title="View"><i class='icon-view1'></i></a></td>
                                </tr>
                            <?php endforeach; else: ?>
                            <tr>
                                <td colspan="8">No Raised invoices</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div><!--dash_box_body-->
        </div><!--dash_box_block-->
    </div><!--col-sm-12-->
    </div>
    <div class="row">
        <div class="col-sm-12">
            <div class="dash_box_block fadeInRight animated">
                <div class="dash_box_header">
                    <div class="row">
                        <div class="col-sm-8">
                            <h3 class="dash_box_header-title">Due Collections <span class="ims_tooltip" data-toggle="tooltip" data-placement="right" title="List of latest 10 Invoices those approved by Account department but payment not received"><i class="fa fa-info-circle"></i></span></h3>
                        </div>
                        <div class="more_result text-right">
                            <a href="<?php echo base_url(); ?>collections" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" data-upgraded=",MaterialButton,MaterialRipple">View all<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a>
                        </div>
                    </div>
                </div><!--dash_box_header-->
                <div class="dash_box_body">
                    <div class="table-theme">
                        <table class="table">
                            <thead>
                            <tr>
                                <th>PO No.</th>
                                <th>PO Date</th>
                                <th>Invoice No.</th>
                                <th>Invoice Date</th>
                                <th>Payment Due Date</th>
                                <th>Client Name</th>
                                <th>Net Amt</th>
                                <!--<th>Payment Status</th>-->
                                <th>View</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php if(isset($dueCollections) && count($dueCollections)):
                                foreach($dueCollections as $invoice):
                                    /*if ($invoice->invoice_acceptance_status == 'Pending') {
                                        $actionLink = "Not Invoiced";
                                    }else if ($invoice->invoice_acceptance_status == 'Accept') {
                                        $actionLink = "Invoiced";
                                    } else {
                                        $actionLink = "Rejected";
                                    }*/
                                    if($invoice->payment_recieved_flag == 'Y') {
                                        $paymentStatus = "Payment Received";
                                    } else {
                                        $paymentStatus = "Pending";
                                    }
                                    ?>
                                    <tr>
                                        <td><?php echo $invoice->po_no; ?></td>
                                        <td><?php echo date('d-M-Y', strtotime($invoice->po_date)) ?></td>
                                        <td><?php echo $invoice->invoice_no; ?></td>
                                        <td><?php echo date('d-M-Y', strtotime($invoice->invoice_date)) ?></td>
                                        <td><?php echo date('d-M-Y', strtotime($invoice->payment_due_date)) ?></td>
                                        <td><?php echo $invoice->client_name; ?></td>
                                        <td><?php echo $invoice->currency_symbol . ' ' . formatAmount($invoice->invoice_net_amount); ?></td>
                                        <!--<td><?php /*echo $paymentStatus */?></td>-->
                                        <td><a class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" href="#InvoiceDetailModal" data-toggle="modal" data-target-id="<?php echo $invoice->invoice_req_id; ?>" title="View"><i class='icon-view1'></i></a></td>
                                    </tr>
                                <?php endforeach; else: ?>
                                <tr>
                                    <td colspan="9">No pending collections</td>
                                </tr>
                            <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div><!--dash_box_body-->
            </div><!--dash_box_block-->
        </div><!--col-sm-12-->
    </div><!--row-->
</div><!--content-wrapper-->

<!-- View Modal-->
<div id="InvoiceDetailModal" class="modal">
    <div class="modal-dialog modal-lg zoomIn animated">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Invoice Detail</h4>
            </div>
            <div class="modal-body view-details custom_scroll">

            </div><!--modal-body-->
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function(){
        $("#InvoiceDetailModal").on("show.bs.modal", function(e) {
            var modal = $(this);
            modal.find('.view-details').html("");
            var id = $(e.relatedTarget).data('target-id');
            var viewUrl = BASEURL + "invoice/invoice-detail/"+id;
            $.ajax({
                type: "GET",
                url: viewUrl,
                cache: false,
                success: function (data) {
                    modal.find('.view-details').html(data);
                    $(".custom_scroll").mCustomScrollbar();
                },
                error: function(err) {
                    console.log(err);
                }
            });
        });

        $("#InvoiceDetailModal").on("hide.bs.modal", function() {
            $(".custom_scroll").mCustomScrollbar("destroy");
        });

    });
</script>