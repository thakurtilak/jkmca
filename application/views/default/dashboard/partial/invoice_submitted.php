<table class="table">
    <thead>
    <tr>
        <th>Client Name </th>
        <th>Total Amount</th>
        <th>Status</th>
        <th>View</th>
    </tr>
    </thead>
    <tbody>
    <?php if(isset($currentMonthInvoices) && $currentMonthInvoices) :
        foreach($currentMonthInvoices as $cmi):
            if ($cmi->invoice_acceptance_status == 'Pending') {
                $status = 'Pending';
            }else if ($cmi->invoice_acceptance_status == 'Accept') {
                $status = 'Invoiced';
            } else {
                $status = 'Rejected';
            }
            $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" data-upgraded=\",MaterialButton,MaterialRipple\" href=\"#InvoiceDetailModal\" data-toggle=\"modal\" data-target-id=" . $cmi->invoice_req_id . " title='View'><i class='icon-view1'></i><span class=\"mdl-button__ripple-container\"><span class=\"mdl-ripple\"></span></span></a>";

            ?>
            <tr>
                <td><?php echo $cmi->client_name; ?></td>
                <td><?php echo ($cmi->invoice_net_amount)? $cmi->currency_symbol." ".formatAmount($cmi->invoice_net_amount) :'--'; ?></td>
                <td>
                    <?php echo $status; ?>
                </td>
                <td>
                    <?php echo $actionLink; ?>
                </td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No Record(s) Found</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>