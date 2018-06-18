<tr>
    <td><strong>Hello,</strong></td>
</tr>
<tr>
    <td>New order request has been created by <strong><?php echo $requestBy; ?></strong>. The details of the order request are as follow as:</td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><table width="800" border="0">
            <tr>
                <td colspan="3" style="font-size:16px;"><span style="color: #4a51be;display:block"><strong>Order Details:</strong></span></td>
            </tr>
			<tr>
				<td colspan="3" style="font-size:16px;"><hr /></td>
			</tr>
            <tr>
                <td width="200"><strong>Category Name</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($order, 'category_name'))? $order->category_name:""; ?></td>
            </tr>
            <tr>
                <td width="200"><strong>Project Name</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($order, 'project_name'))? $order->project_name:""; ?></td>
            </tr>
            <tr>
                <td width="200"><strong>Order Id</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($order, 'order_unique_id'))? $order->order_unique_id:""; ?></td>
            </tr>
            <tr>
                <td width="200"><strong>PO/RO Number</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($order, 'po_no'))? $order->po_no:""; ?></td>
            </tr>
            <tr>
                <td width="200"><strong>PO/RO Date</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($order, 'po_date') && !empty($order->po_date))? date('d-M-Y', strtotime($order->po_date)):""; ?> </td>
            </tr>
            <tr>
                <td width="200"><strong>Order Amount</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($order, 'formattedOrderAmount'))? $order->formattedOrderAmount:""; ?> </td>
            </tr>
            <?php if(isset( $order->po_dtl) && !empty( $order->po_dtl) ): ?>
            <tr>
                <td width="200"><strong>Invoice Description</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($order, 'po_dtl'))? $order->po_dtl:""; ?> </td>
            </tr>
            <?php endif; ?>
            <tr>
                <td width="200"><strong>Remarks</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($order, 'invoice_originator_remarks'))? $order->invoice_originator_remarks:""; ?> </td>
            </tr>

        </table></td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>

    <tr>
        <td><table width="800" border="0">
                <tr>
                    <td colspan="3" style="font-size:16px;"><span style="color: #4a51be;display:block;"><strong>Client Details:</strong></span></td>
                </tr>
				<tr>
					<td colspan="3" style="font-size:16px;"><hr /></td>
				</tr>
                <tr>
                    <td width="200"><strong>Client Name</strong></td>
                    <td>:</td>
                    <td><?php echo (property_exists($order, 'client_name'))? $order->client_name:""; ?> </td>
                </tr>
                <tr>
                    <td><strong>Client Address1</strong></td>
                    <td>:</td>
                    <td><?php echo (property_exists($order, 'address1'))? $order->address1:""; ?> </td>
                </tr>
                <tr>
                    <td><strong>Client Address2 </strong></td>
                    <td>:</td>
                    <td><?php echo (property_exists($order, 'address2'))? $order->address2:""; ?> </td>
                </tr>
                <tr>
                    <td><strong>Sales Person Name</strong></td>
                    <td>:</td>
                    <td><?php echo (property_exists($order, 'sales_person_name'))? $order->sales_person_name:""; ?> </td>
                </tr>
                <tr>
                    <td><strong>Sales Person Contact No.</strong></td>
                    <td>:</td>
                    <td><?php echo (property_exists($order, 'sales_contact_no'))? $order->sales_contact_no:""; ?></td>
                </tr>
                <tr>
                    <td><strong>Sales Person Email</strong></td>
                    <td>:</td>
                    <td><?php echo (property_exists($order, 'sales_person_email'))? $order->sales_person_email:""; ?> </td>
                </tr>

                <?php if(property_exists($order, 'account_person_name') && property_exists($order, 'account_contact_no') && property_exists($order, 'account_person_email')): ?>
                    <tr>
                        <td><strong>Account Person Name</strong></td>
                        <td>:</td>
                        <td><?php echo $order->account_person_name; ?> </td>
                    </tr>
                    <tr>
                        <td><strong>Account Person Contact No.</strong></td>
                        <td>:</td>
                        <td><?php echo $order->account_contact_no; ?> </td>
                    </tr>
                    <tr>
                        <td><strong>Account Person Email</strong></td>
                        <td>:</td>
                        <td><?php echo $order->account_person_email; ?> </td>
                    </tr>
                <?php endif; ?>
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