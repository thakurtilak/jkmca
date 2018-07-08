<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>JKMCA JOb Card</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
    <style>
        table {
            border-spacing: 0;
            border-collapse: collapse;
            border-color: #282828;
        }
    </style>
</head>

<body style="font-family: 'Roboto', sans-serif;font-size:14px;">
<table width="800" border="0" align="center" cellpadding="0" cellspacing="0">
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" valign="top"><img src="<?php echo base_url();?>assets/default/img/logo_2.png" width="172" height="auto" /></td>
                </tr>
            </table></td>
    </tr>
    <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" valign="middle"><u>Job Confirmation Receipt</u></td>
                </tr>
            </table></td>
    </tr>
    <tr>
        <td><strong>Job Card Details</strong></td>
    </tr>
    <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="5">
                <tr>
                    <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>JOB ID</strong></td>
                    <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><?php echo $jobDetail->job_number; ?></td>
                    <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>JOB TYPE</strong></td>
                    <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><?php echo $jobDetail->work; ?></td>
                    <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>CREATED DATE</strong></td>
                    <td align="center" valign="middle"><?php echo date('d-M-Y', strtotime($jobDetail->created_date)); ?></td>
                </tr>
                <tr>
                    <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>CREATED BY</strong></td>
                    <td align="center" valign="middle"><?php echo $jobDetail->requestorname; ?></td>
                    <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>ASSIGN TO</strong></td>
                    <td align="center" valign="middle"><?php echo $staffName; ?></td>
                    <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>COMPLETION DATE</strong></td>
                    <td align="center" valign="middle"><?php echo date('d-M-Y', strtotime($jobDetail->completion_date)) ?></td>
                </tr>
            </table></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><strong>Fee Detail</strong></td>
    </tr>
    <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="5">
                <tr>
                    <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>AMOUNT</strong></td>
                    <td align="center" valign="middle"><?php echo formatAmount($jobDetail->amount); ?></td>
                    <?php if($jobDetail->discount_price > 0): ?>
                        <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>DISCOUNT</strong></td>
                        <td align="center" valign="middle"><?php echo formatAmount($jobDetail->discount_price); ?></td>
                    <?php endif; ?>
                    <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>ADVANCED AMOUNT</strong></td>
                    <td align="center" valign="middle"><?php echo formatAmount($jobDetail->advanced_amount); ?></td>
                    <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>REMAINING AMOUNT</strong></td>
                    <td align="center" valign="middle"><?php echo formatAmount($jobDetail->remaining_amount); ?></td>
                </tr>
            </table></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><strong>Client Details</strong></td>
    </tr>
    <tr>
        <td><table width="100%" border="1" cellspacing="0" cellpadding="5">
                <tr>
                    <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>CLIENT NAME</strong></td>
                    <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>CONTACT NO.</strong></td>
                    <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>ADDRESS</strong></td>
                </tr>
                <tr>
                    <td align="center" valign="middle"><?php echo $jobDetail->clientName ?></td>
                    <td align="center" valign="middle"><?php echo $jobDetail->clientContact; ?></td>
                    <td align="center" valign="middle"><?php echo $jobDetail->clientAddress ?></td>
                </tr>
            </table></td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="right" valign="top">JKM Associates & Charted Accountant</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td align="center" valign="top" style="font-size: 12px;">This is a computer generated receipt and contains all the requisite details regarding the job . This does not contain manual signature.</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td align="center" valign="top" style="font-size: 12px; width: 400px;">Seminary Road Ashta 466116, MP (India). Tel : + 91-7560-123456 Mob : + 91-9584314454</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
</table>
</body>
</html>
