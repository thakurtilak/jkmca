
<body>
<div class="content-wrapper">
    <div class="container-fluid">
<form name="main" method="post" onSubmit="">
    <table width="100%" height="233" class="mainborder1">
        <tr>
            <td width="100%" align="left" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="h_bg">
                    <tr>
                        <td width="7">

                        <td >
                            <img src="<?php echo base_url();?>assets/images/ico_ma.gif" width="14" height="14" align="absmiddle" />&nbsp;Manage WD Sales Person</td>
                        <td width="7">

                    </tr>
                </table>

                <table width="100%" border="0" align="center" class="mainborder" style="padding:0px;" >
                    <tr><td>

                    <tr align="center" valign="middle">
                        <td><div align="center" bgcolor="white"><p align="center" class="response_msg"><font color="#009999" size="2px"></font></p></div></td>
                    </tr>

                    </td></tr>
                    <tr  align="left" valign="middle">
                        <td colspan="2"><div align="center" bgcolor="white">
                                <input type="text" id="user_name" placeholder="Search user">&nbsp;<input type="button" id="search" onclick="getSalesPersonList();" value="Search">

                                <div id="pagedtl"><input type="hidden" id="searchedPage" value="1"></div>
                        </td>
                        <td colspan="2">
                            <label><b>Status</b></label> &nbsp;
                            <select id="status" onchange="getSalesPersonList();">
                                <option value="0">Select Status</option>
                                <option value="A">Active</option>
                                <option value="I">Inactive</option>
                            </select>
                        </td>

                        <td colspan="2">
                            <div style="float:right"><input name="Button" type="button" class="btnSrc" id="Button" value="Add New Sale Person" onclick="getDtlPage('/includes/admin_pages/addwdsalesperson.php?a=a');"/></div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="6" align="left" width="50%" id="userlist" >



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
