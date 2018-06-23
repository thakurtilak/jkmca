<tr>
    <td><strong>Hello Administrator,</strong></td>
</tr>
<tr>
    <td>The Job Request with JOB ID <strong><?php echo $jobDetail->job_number; ?></strong> has been <?php echo $updatedMode; ?> by <strong><?php echo $staffName; ?></strong> . Now it's pending for review.</td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><table width="800" border="0">
            <tr>
                <td colspan="3" style="font-size:16px;"><span style="color: #4a51be;display:block;"><strong>Job Details:</strong></span></td>
            </tr>
            <tr>
                <td colspan="3" style="font-size:16px;"><hr /></td>
            </tr>
            <tr>
                <td width="200"><strong>JOB ID</strong></td>
                <td>:</td>
                <td><?php echo $jobDetail->job_number; ?> </td>
            </tr>
            <tr>
                <td width="200"><strong>Work Type</strong></td>
                <td>:</td>
                <td><?php echo $jobDetail->work; ?> </td>
            </tr>
            <tr>
                <td width="200"><strong>Created Date</strong></td>
                <td>:</td>
                <td><?php echo (property_exists($jobDetail, 'created_date') && !empty($jobDetail->created_date))? date('d-M-Y', strtotime($jobDetail->created_date)):""; ?>  </td>
            </tr>
            <tr>
                <td width="200"><strong>Client Name</strong></td>
                <td>:</td>
                <td><?php echo $jobDetail->clientName; ?> </td>
            </tr>
            <tr>
                <td width="200"><strong>Client Contact No.</strong></td>
                <td>:</td>
                <td><?php echo $jobDetail->clientContact; ?> </td>
            </tr>
            <tr>
                <td width="200"><strong>Client Address</strong></td>
                <td>:</td>
                <td><?php echo $jobDetail->clientAddress; ?> </td>
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
    <td>JKMCA Admin</td>
</tr>