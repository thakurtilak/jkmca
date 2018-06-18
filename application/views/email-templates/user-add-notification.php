<tr>
    <td><strong>Dear <?php echo $user->full_name; ?>,</strong></td>
</tr>
<tr>
    <td>Congratulation, You are the part of JKM Associates</td>
</tr>
<tr>
    <td>Please find below login details.</td>
</tr>

<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td><table width="800" border="0">
            <tr>
                <td colspan="3" style="font-size:16px;"><span style="color: #4a51be;display:block;"><strong>Login Details:</strong></span></td>
            </tr>
            <tr>
                <td colspan="3" style="font-size:16px;"><hr /></td>
            </tr>
            <tr>
                <td width="200"><strong>User Name</strong></td>
                <td>:</td>
                <td><?php echo $user->email; ?> </td>
            </tr>
            <tr>
                <td><strong>Password</strong></td>
                <td>:</td>
                <td><?php echo $password; ?> </td>
            </tr>
        </table></td>
</tr>
<tr>
    <td>&nbsp;</td>
</tr>
<tr>
    <td>Please Login to <a href="<?php echo base_url('login'); ?>"><?php echo base_url(); ?></a> with your corporate login.
    </td>
</tr>
<tr>
    <td>Thanks,</td>
</tr>
<tr>
    <td>JMKCA Admin</td>
</tr>