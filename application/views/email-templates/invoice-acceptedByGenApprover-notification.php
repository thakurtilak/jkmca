<tr>
    <td><strong>Hello <?php echo $user; ?>,</strong></td>
</tr>
<tr>
    <td>The Invoice Request with name <strong><?php echo $invoice->project_name; ?></strong> has been <?php echo $updatedMode; ?> by <strong><?php echo $acceptedBy; ?></strong> . The details of the invoice request are as follow as:</td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><table width="800" border="0">
            <tr>
                <td colspan="3" style="font-size:16px;"><span style="color: #4a51be;display:block;"><strong>Invoice Details:</strong></span></td>
            </tr>
			<tr>
				<td colspan="3" style="font-size:16px;"><hr /></td>
			</tr>
            <tr>
                <td width="200"><strong>Requested By</strong></td>
                <td>:</td>
                <td><?php echo $invoice->requestorname; ?> </td>
            </tr>
           <!-- <tr>
                <td width="200"><strong>Requestor EmailID</strong></td>
                <td>:</td>
                <td><?php /*echo $invoice->email; */?> </td>
            </tr>-->
            <tr>
                <td width="200"><strong>Category Name</strong></td>
                <td>:</td>
                <td><?php echo $invoice->category_name; ?> </td>
            </tr>
            <tr>
                <td width="200"><strong>Client Name</strong></td>
                <td>:</td>
                <td><?php echo $invoice->client_name; ?> </td>
            </tr>

            <tr>
                <td width="200"><strong>Activity Name</strong></td>
                <td>:</td>
                <td><?php echo $invoice->project_name; ?> </td>
            </tr>
            <tr>
                <td width="200"><strong>PO/RO Number</strong></td>
                <td>:</td>
                <td><?php echo $invoice->po_no; ?> </td>
            </tr>
            <tr>
                <td width="200"><strong>PO Date</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($invoice, 'po_date') && !empty($invoice->po_date))? date('d-M-Y', strtotime($invoice->po_date)):""; ?>  </td>
            </tr>
            <tr>
                <td width="200"><strong>PO Details</strong></td>
                <td>:</td>
                <td><?php echo $invoice->po_dtl; ?> </td>
            </tr>
            <tr>
                <td width="200"><strong>Invoice Amount</strong></td>
                <td>:</td>
                <td><?php echo $invoice->formattedAmount; ?> </td>
            </tr>
            <tr>
                <td width="200"><strong>Invoice Date</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($invoice, 'invoice_date') && !empty($invoice->invoice_date))? date('d-M-Y', strtotime($invoice->invoice_date)):""; ?></td>
            </tr>
            <tr>
                <td width="200"><strong>Payment Due Date</strong></td>
                <td>:</td>
                <td> <?php echo (property_exists($invoice, 'payment_due_date') && !empty($invoice->payment_due_date))? date('d-M-Y', strtotime($invoice->payment_due_date)):""; ?></td>
            </tr>

            <tr>
                <td><strong>Comments</strong></td>
                <td>:</td>
                <td><?php echo $comments; ?> </td>
            </tr>
            <tr>
                <td width="200"><strong>Approver Comments</strong></td>
                <td>:</td>
                <td><?php echo $approvalcomments; ?> </td>
            </tr>
        </table></td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>Thanks,</td>
</tr>
<tr>
    <td>IMS Admin</td>
</tr>