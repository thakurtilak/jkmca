<table class="table">
    <thead>
    <tr>
        <th>Name </th>
        <th>Total Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php if(isset($sPersonWiseTotalInvoicingForMonth) && $sPersonWiseTotalInvoicingForMonth) :
        foreach($sPersonWiseTotalInvoicingForMonth as $name => $totalInvoice): ?>
            <tr>
                <td><?php echo $name; ?></td>
                <td><?php echo "Rs. ". formatAmount($totalInvoice); ?></td>
            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No Record(s) Found</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>