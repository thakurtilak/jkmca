<tr>
    <td><strong>Hello Admin,</strong></td>
</tr>
<tr>
    <td><?php echo (isset($edited))?"Client detail has been edited":"New Client has been added"; ?> for <strong><?php echo $category; ?></strong> category by <strong><?php echo $user; ?></strong> ,Client details are as follows:</td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><table width="800" border="0">
            <tr>
                <td colspan="3" style="font-size:16px;"><span style="color: #4a51be;display:block;"><strong>Client Information:</strong></span></td>
            </tr>
			<tr>
				<td colspan="3" style="font-size:16px;"><hr /></td>
			</tr>
            <tr>
                <td width="200"><strong>Client Name</strong></td>
                <td>:</td>
                <td><?php echo $client->client_name; ?> </td>
            </tr>
            <tr>
                <td><strong>Client Address1</strong></td>
                <td>:</td>
                <td><?php echo $client->address1; ?> </td>
            </tr>
            <tr>
                <td><strong>Client Address2 </strong></td>
                <td>:</td>
                <td><?php echo $client->address2; ?> </td>
            </tr>
            <?php if(isset($client->gst_no) && !empty($client->gst_no) ): ?>
            <tr>
                <td><strong>City</strong></td>
                <td>:</td>
                <td><?php echo $client->city; ?> </td>
            </tr>
            <tr>
                <td><strong>Zip Code</strong></td>
                <td>:</td>
                <td><?php echo $client->zip_code; ?> </td>
            </tr>
            <tr>
                <td><strong>GST No</strong></td>
                <td>:</td>
                <td><?php echo $client->gst_no; ?> </td>
            </tr>
            <tr>
                <td><strong>Place of supply</strong></td>
                <td>:</td>
                <td><?php echo $client->place_of_supply; ?> </td>
            </tr>
            <?php endif; ?>
        </table></td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<?php if(isset($client->agreement) && !empty($client->agreement)): ?>

<tr>
    <td><table width="800" border="0">
            <tr>
                <td colspan="3" style="font-size:16px;"><span style="color: #4a51be;display:block;"><strong>Agreement:</strong></span></td>
            </tr>
			<tr>
				<td colspan="3" style="font-size:16px;"><hr /></td>
			</tr>
            <tr>
                <td width="200"><strong>Agreement No.</strong></td>
                <td>:</td>
                <td><?php echo $client->agreement->agreement_no; ?> </td>
            </tr>
            <tr>
                <td><strong>Agreement Date</strong></td>
                <td>:</td>
                <td><?php echo date('d-M-Y', strtotime($client->agreement->agreement_date)); ?> </td>
            </tr>
            <tr>
                <td><strong>Upload Agreement</strong></td>
                <td>:</td>
                <td><?php echo $client->agreement->agreement_name; ?></td>
            </tr>
        </table></td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<?php endif; ?>
<?php if(isset($client->salesManager) && !empty($client->salesManager)): ?>
    <tr>
        <td><table width="800" border="0">
                <tr>
                    <td colspan="3" style="font-size:16px;"><span style="color: #4a51be;display:block;"><strong>Sales Person:</strong></span></td>
                </tr>
				<tr>
					<td colspan="3" style="font-size:16px;"><hr /></td>
				</tr>
                <tr>
                    <td width="200"><strong>Sales Person Name</strong></td>
                    <td>:</td>
                    <td><?php echo $client->salesManager->sales_person_name; ?></td>
                </tr>
                <tr>
                    <td><strong>Contact No.</strong></td>
                    <td>:</td>
                    <td><?php echo $client->salesManager->sales_contact_no; ?></td>
                </tr>
                <tr>
                    <td><strong>Email Id</strong></td>
                    <td>:</td>
                    <td><a href="mailto:<?php echo $client->salesManager->sales_person_email; ?>" target="_blank"><?php echo $client->salesManager->sales_person_email; ?></a></td>
                </tr>
            </table></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>

<?php endif; ?>

<?php if(isset($client->accountManager) && !empty($client->accountManager)): ?>
<tr>
    <td><table width="800" border="0">
            <tr>
                <td colspan="3" style="font-size:16px;"><span style="color: #4a51be;display:block;"><strong>Account:</strong></span></td>
            </tr>
			<tr>
                <td colspan="3" style="font-size:16px;"><hr /></td>
            </tr>
            <tr>
                <td width="200"><strong>Account Manager Name</strong></td>
                <td>:</td>
                <td><?php echo $client->accountManager->account_person_name; ?></td>
            </tr>
            <tr>
                <td><strong>Contact No</strong></td>
                <td>:</td>
                <td><?php echo $client->accountManager->account_contact_no; ?></td>
            </tr>
            <tr>
                <td><strong>Email Id</strong></td>
                <td>:</td>
                <td><a href="mailto:<?php echo $client->accountManager->account_person_email; ?>" target="_blank"><?php echo $client->accountManager->account_person_email; ?></a></td>
            </tr>
        </table></td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<?php endif; ?>
<tr>
    <td>Thanks,</td>
</tr>
<tr>
    <td>IMS Admin</td>
</tr>