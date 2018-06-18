
<body>
<form name="main" method="post" onSubmit="">
    <table width="100%" height="233" class="mainborder1">
        <tr>
            <td width="100%" align="left" valign="top">
                <table width="100%" border="0" cellspacing="0" cellpadding="0" class="h_bg">
                    <tr>
                        <td width="7">
                            <img src="<?php echo base_url();?>assets/images/h_left.jpg" width="7" height="25" /></td>
                        <td >
                            <img src="<?php echo base_url();?>assets/images/ico_ma.gif" width="14" height="14" align="absmiddle" />&nbsp;Manage IMS Clients</td>
                        <td width="7">
                            <img src="<?php echo base_url();?>assets/images/h_right.jpg" width="7" height="25" /></td>
                    </tr>
                </table>

                <table width="100%" border="0" align="center" class="mainborder" style="padding:0px;" >
                    <tr><td>

                    <tr  align="center" valign="middle">
                        <td colspan="5" align="center"><div align="center" bgcolor="white"><p align="center" class="response_msg"><font color="#009999" size="2px"></font></p></div></td>
                    </tr>

                    </td></tr>
                    <tr  align="left" valign="middle">
                        <!--  <td colspan="2"><div align="center" bgcolor="white">
              <label><b>User Role</b></label> &nbsp;

             </td>-->
                        <td colspan="2"><div align="center" bgcolor="white">
                                <label><b>Category</b></label> &nbsp;

                        </td>
                        <td colspan="2"><div align="center" bgcolor="white">
                                <label><b>Status</b></label> &nbsp;
                                <select id="status" onchange="getClientList();">
                                    <option value="0">Select Status</option>
                                    <option value="A">Active</option>
                                    <option value="I">Inactive</option>
                                </select>
                        </td>
                        <td colspan="2"><div align="center" bgcolor="white">
                                <input type="text" id="user_name" placeholder="Search client">&nbsp;<input type="button" id="search" onclick="getClientList();" value="Search">
                                <div id="pagedtl"><input type="hidden" id="searchedPage" value="1"></div>
                        </td>
                    </tr>

                    <tr>
                        <td colspan="6" align="left" width="50%" id="userlist">


                        </td>
                    </tr>
                </table>

            </td>
        </tr>

    </table>

</form>
</body>