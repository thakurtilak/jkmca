

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


    <title>Invoice Management System</title>
</head>
<body>
<div class="content-wrapper">
    <div class="container-fluid">
<form id="form1" name="form1" method="post" action="add_currency.php">
    <table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="mainborder">
        <!--  <tr>
              <td height="38" colspan="3" align="center" valign="middle" class="titleBar"><span >View User </span></td>
            </tr>-->
        <tr>
            <td colspan="2" align="left" valign="middle" class="titleBar1"><img src="images/ico_sales_p_details.gif" border="0">Add Currency</td>
        </tr>
        <?php if(isset($_REQUEST['response']) && $_REQUEST['response']!=''){ ?>
            <tr align="center" valign="middle">
                <td><div align="center" bgcolor="white"><p align="center" class="response_msg"><font color="#009999" size="2px"></font></p></div></td>
            </tr>
        <?php }?>
        <tr>
            <td width="17%" align="left" valign="middle" class="row1"><strong>Currency Name</strong></td>
            <td  width="83%" align="left" valign="middle" nowrap="nowrap" class="row1"><input name="currency_name" type="text" class="textbox" id="currency_name"  /></td>
        </tr>
        <tr>
            <td align="left" valign="middle" class="row2"><strong>Currency Symbol</strong></td>
            <td align="left" valign="middle" class="row2"><input name="currency_symbol" type="text" class="textbox" id="currency_symbol"  /></td>
        </tr>
        <tr>
            <td align="left" valign="middle" class="row1"><strong>Currency Status</strong></td>
            <td align="left" valign="middle" class="row1">
                <input type="radio" id="actie" name="currency_status" value="A" checked> &nbsp;Active&nbsp;&nbsp;
                <input type="radio" id="inactive" name="currency_status" value="I"> &nbsp;Inactive&nbsp;
            </td>
        </tr>

        <tr>
            <td align="left" valign="middle">&nbsp;</td>
            <td align="left" valign="middle">
                <input type="submit" name="Submit" id="Submit" value="Edit User" class="btnSrc" />
                <input name="reset" type="reset" class="btnSrc" id="reset" value="Reset" /></td>
        </tr>
        <tr>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
        </tr>
    </table>

</form>
        </div>
    </div>
</body>
</html>
