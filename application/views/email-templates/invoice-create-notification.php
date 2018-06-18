
<tr>
    <td><strong>Hello <?php echo $approverName; ?>,</strong></td>
</tr>
<tr>
    <td>New Invoice Request for <strong><?php echo $categoryRecord->category_name; ?></strong> category created by <strong><?php echo $user; ?></strong></strong> for the client <strong><?php echo $clientDetails->client_name; ?></strong> has been originated.</td>
</tr>

<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><table width="800" border="0">
            <tr>
                <td colspan="3" style="font-size:16px;"><span style="color: #4a51be;display:block;"><strong>Invoice Information:</strong></span></td>
            </tr>
			<tr>
				<td colspan="3" style="font-size:16px;"><hr /></td>
			</tr>
            <tr>
                <td width="200"><strong>Requested By</strong></td>
                <td>:</td>
                <td><?php echo $requestBy; ?> </td>
            </tr>

            <!--<tr>
                <td width="200"><strong>Requestor EmailId</strong></td>
                <td>:</td>
                <td><?php /*echo $requestEmail; */?> </td>
            </tr>-->
            <tr>
                <td width="200"><strong>Category Name</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($categoryRecord, 'category_name'))? $categoryRecord->category_name:""; ?> </td>
            </tr>
            <tr>
                <td width="200"><strong>Project Name</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($invoice, 'project_name'))? $invoice->project_name:""; ?> </td>
            </tr>
            <tr>
                <td width="200"><strong>PO Date</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($invoice, 'po_date') && $invoice->po_date)? date('d-M-Y', strtotime($invoice->po_date)):""; ?></td>
            </tr>
            <tr>
                <td><strong>PO Detail</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($invoice, 'po_dtl'))? $invoice->po_dtl:""; ?> </td>
            </tr>
            <tr>
                <td><strong>PO NO </strong></td>
                <td>:</td>
                <td><?php echo (property_exists($invoice, 'po_no'))? $invoice->po_no:""; ?> </td>
            </tr>


            <tr>
                <td width="200"><strong>Amount</strong></td>
                <td>:</td>
                <td><?php echo $formattedAmount; ?>  </td>
            </tr>

            <tr>
                <td><strong>Invoice Description</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($invoice, 'invoice_description'))? $invoice->invoice_description:""; ?> </td>
            </tr>

            <tr>
                <td>&nbsp;</td>

            </tr>
            <tr>
                <td colspan="3" style="font-size:16px;"><span style="color: #4a51be;display:block;"><strong>Client Information:</strong></span></td>
            </tr>
			<tr>
				<td colspan="3" style="font-size:16px;"><hr /></td>
			</tr>
            <tr>
                <td width="200"><strong>Client Name</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($clientDetails, 'client_name'))? $clientDetails->client_name :""; ?> </td>
            </tr>
            <tr>
                <td><strong>Client Address</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($clientDetails, 'address1'))? $clientDetails->address1 :""; ?> </td>
            </tr>
            <tr>
                <td><strong>Sales Person Name </strong></td>
                <td>:</td>
                <td><?php echo (property_exists($salespersonDetails, 'sales_person_name'))? $salespersonDetails->sales_person_name :""; ?> </td>
            </tr>

            <tr>
                <td><strong>Sales Person Contact No.</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($salespersonDetails, 'sales_contact_no'))? $salespersonDetails->sales_contact_no :""; ?></td>
            </tr>
            <tr>
                <td><strong>Sales Person Email</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($salespersonDetails, 'sales_person_email'))? $salespersonDetails->sales_person_email :""; ?></td>
            </tr>
            <?php if($accountpersonDetails): ?>
            <tr>
                <td><strong>Account Person Name </strong></td>
                <td>:</td>
                <td><?php echo (property_exists($accountpersonDetails, 'account_person_name'))? $accountpersonDetails->account_person_name :""; ?></td>
            </tr>

            <tr>
                <td><strong>Account Person Contact No. </strong></td>
                <td>:</td>
                <td><?php echo (property_exists($accountpersonDetails, 'account_contact_no'))? $accountpersonDetails->account_contact_no :""; ?></td>
            </tr>
            <tr>
                <td><strong>Account Person Email</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($accountpersonDetails, 'account_person_email'))? $accountpersonDetails->account_person_email :""; ?></td>
            </tr>
            <?php endif; ?>



        </table></td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>

    <td>For Approval, Please Login to <a href="<?php echo base_url(); ?>"><?php echo base_url(); ?></a> with your corporate login.
    </td>
</tr>
<tr>
    <td>Thanks,</td>
</tr>
<tr>
    <td>IMS Admin</td>
</tr>