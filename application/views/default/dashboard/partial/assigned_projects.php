<table class="table">
    <thead>
    <tr>
        <th>Project Name </th>
        <th>Total Amount</th>
    </tr>
    </thead>
    <tbody>
    <?php if(isset($projectsWithTotalInvoice) && $projectsWithTotalInvoice) :
        foreach($projectsWithTotalInvoice as $clientInvoice): ?>
            <tr>
                <td><?php echo $clientInvoice->project_name; ?></td>
                <td><?php echo $clientInvoice->currency_symbol." ".formatAmount($clientInvoice->totalInvoice); ?></td>

            </tr>
        <?php endforeach; ?>
    <?php else: ?>
        <tr>
            <td colspan="3">No Record(s) Found</td>
        </tr>
    <?php endif; ?>
    </tbody>
</table>