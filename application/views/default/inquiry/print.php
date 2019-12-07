<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html moznomarginboxes mozdisallowselectionprint xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>JKMCA Job Card</title>
    <link href="https://fonts.googleapis.com/css?family=Roboto:400,500,700" rel="stylesheet">
    <style>
        table {
            border-spacing: 0;
            border-collapse: collapse;
            border-color: #282828;
        }
    </style>
    <style type="text/css" media="print">
    /*@page 
    {
        size: auto;   
        margin: 15mm;  
    }*/
    @media print {
        @page { margin: 20mm; }
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
            </table>
        </td>
    </tr>
    <tr>
        <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="center" valign="middle" style="font-size:20px"><u>Job Card</u></td>
                </tr>
            </table></td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" valign="top"><strong>Temp Ref No.</strong> &nbsp;&nbsp;&nbsp; <?php echo $jobDetail->ref_no; ?></td>
                    <td align="Right" valign="top"><strong>Date</strong>   &nbsp;&nbsp;&nbsp;&nbsp;<strong><?php echo date('d-M-Y', strtotime($jobDetail->created_at)); ?> </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" valign="top"><strong>Name</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $jobDetail->first_name." ".$jobDetail->last_name; ?></td>
                    <td align="Right" valign="top"><strong>Work Type</strong>&nbsp;&nbsp;&nbsp;&nbsp;<?php echo $workType ?> </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" valign="top"><strong>Father's Name</strong>&nbsp; <?php echo $jobDetail->fathers_first_name." ".$jobDetail->fathers_last_name; ?></td>
                    
                    <td align="Right" valign="top"><strong>Staff Name</strong> &nbsp;&nbsp;&nbsp;&nbsp;<?php echo $staffName; ?></td>
                
                </tr>
            </table>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" valign="top"><strong>Mobile No.</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $jobDetail->mobile; ?></td>
                    <td align="Right" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" valign="top"><strong>PAN No.</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $jobDetail->pan_no; ?></td>
                    <td align="Right" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" valign="top"><strong>Aadhar No.</strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <?php echo $jobDetail->aadhar_no; ?></td>
                    <td align="Right" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" valign="top"><strong>Firm Name</strong> &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; ............................</td>
                    <td align="Right" valign="top"><strong>Manager Name</strong>&nbsp;&nbsp;&nbsp;&nbsp;...............................</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <table width="100%" border="1" cellspacing="0" cellpadding="5">
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>&nbsp;Work Description</td>
                                <td align="Right" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                            <tr style="height:300px"><td>&nbsp;</td></tr>
                        </table>
                    </td>
                </tr>
                <tr>
                    <td>
                        <table width="100%" border="0" cellspacing="0" cellpadding="0">
                            <tr>
                                <td>&nbsp;Document's Enclosed</td>
                                <td align="Right" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                            </tr>
                            <tr style="height:80px"><td>&nbsp;</td></tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" valign="top"><strong>Payment</strong>&nbsp;&nbsp;&nbsp;
                    ..........................
                    </td>
                    <td align="Right" valign="top"><strong>Expected Completion Date</strong>&nbsp;
                    ..........................
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" valign="top"><strong>Advanced</strong>&nbsp;
                    ..........................
                    </td>
                    <td align="Right" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" valign="top"><strong>Balance</strong>&nbsp;&nbsp;&nbsp;&nbsp;
                    ..........................
                    </td>
                    <td align="Right" valign="top">&nbsp;&nbsp;&nbsp;&nbsp;</td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
    <tr><td>&nbsp;</td></tr>
    <tr>
        <td>
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
                <tr>
                    <td align="left" valign="top"><strong>Sign. Client</strong>&nbsp;
                    ...............................
                    </td>
                    <td align="Right" valign="top"><strong>Sign. Staff</strong>&nbsp;&nbsp;&nbsp;
                    ...............................
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr><td>&nbsp;</td></tr>
</table>
</body>
</html>
