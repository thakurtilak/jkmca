<html>
<body>
<div class="content-wrapper">
    <div class="container-fluid">
<form method="post" enctype="multipart/form-data" name="main">
    <table width="100%" class="mainborder1">
        <tr>
            <td  align="left" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="h_bg">
                    <tr class="titleBar">
                        <td colspan="7"><img src="<?php echo base_url();?>assets/images/ico_campaign_b_details.gif" /> Search Invoice</td>
                    </tr>
                    <tr><td>

                    </td></tr>
                    <tr class="row1">
                        <td width="3%"  align="left" valign="middle" ><span class="boldFonts"><font color="black">Invoice Number</font></span></td>
                        <td width="20%"  align="left" nowrap="nowrap" class="row1"><input type="text" name="srch_invoice_no" id="srch_invoice_no" style="width:100px" onkeypress="return runScript_new(event)"/>&nbsp; &nbsp; <input name="srch_invoice_btn" size="6" type="button" class="btnSrc" id="srch_invoice_btn" value="Search" onClick="invoicesearchAdmin('','','','','','');"/>
                            <div id="pagedtl"><input type="hidden" id="searchedPage" value="1"></div></td>
                    </tr>
                </table>
                <table width="100%"  border="0" align="center" class="mainborder" style="padding:0px;" >

                    <tr>
                        <td >&nbsp;</td>
                    </tr>

                    <tr>
                        <td>
                            <table width="100%" border="0" align="center" class="mainborder" style="padding:0px;" >

                                <tr>
                                    <td colspan="6" align="left" width="100%" ><div id="invoice_search">

                                        </div>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                </table>

</form>
        </div>
    </div>

</body>
</html>
