<table class="table">
    <thead>
    <tr>
        <th>Client Name </th>
        <th>Total Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php if(isset($clientWiseMonthlyInvoices) && $clientWiseMonthlyInvoices) :
        foreach($clientWiseMonthlyInvoices as $clientName => $clientInvoice): ?>
            <tr>
                <td><?php echo $clientName; ?></td>
                <td><?php echo "Rs. ". formatAmount($clientInvoice); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No Record(s) Found</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>