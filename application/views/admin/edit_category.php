
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />


    <title>Invoice Management System</title>
</head>
<body>
<div class="content-wrapper">
    <div class="container-fluid">
<form id="form1" name="form1" method="post" action="edit_category.php">
    <table width="100%" border="0" align="center" cellpadding="4" cellspacing="1" class="mainborder">
        <!--  <tr>
              <td height="38" colspan="3" align="center" valign="middle" class="titleBar"><span >View User </span></td>
            </tr>-->
        <tr>
            <td colspan="2" align="left" valign="middle" class="titleBar1"><img src="images/ico_sales_p_details.gif" border="0">Edit User</td>
        </tr>

        <tr>
            <td align="left" valign="middle" class="row2"><strong>Category Name</strong></td>
            <td align="left" valign="middle" class="row2"><input name="cat_name" type="text" class="textbox" id="usr_name" value=""</td>
        </tr>
        <tr>
            <td align="left" valign="middle" class="row1"><strong>Order Enabled</strong></td>
            <td align="left" valign="middle" class="row1"><select name="status" class="textbox" id="status">

                </select></td>
        </tr>
        <tr>
            <td align="left" valign="middle">&nbsp;</td>
            <td align="left" valign="middle">
                <input type="hidden" name="cat_id" id="cat_id" value="<?php echo $categoryDtl['category_id'];?>">
                <input type="submit" name="Submit" id="Submit" value="Edit Category" class="btnSrc" />
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
