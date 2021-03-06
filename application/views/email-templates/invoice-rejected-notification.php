<tr>
    <td><strong>Hello <?php echo $user; ?>,</strong></td>
</tr>
<tr>
    <td>The Invoice Request with name <strong><?php echo $invoice->project_name; ?></strong> has been rejected by <strong><?php echo $rejectedBy; ?></strong> . The details of the invoice request are as follow as:</td>
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
                <td width="200"><strong>PO/RO Number</strong></td>
                <td>:</td>
                <td><?php echo $invoice->po_no; ?> </td>
            </tr>
            <tr>
                <td width="200"><strong>PO/RO Date</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($invoice, 'po_date') && !empty($invoice->po_date))? date('d-M-Y', strtotime($invoice->po_date)):""; ?> </td>
            </tr>
            <tr>
                <td><strong>PO/RO Detail</strong></td>
                <td>:</td>
                <td><?php echo  $invoice->po_dtl; ?> </td>
            </tr>
            <tr>
                <td width="200"><strong>invoice Amount</strong></td>
                <td>:</td>
                <td><?php echo $invoice->formattedAmount; ?> </td>
            </tr>
            <tr>
                <td width="200"><strong>Comment</strong></td>
                <td>:</td>
                <td><?php echo $comment; ?> </td>
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