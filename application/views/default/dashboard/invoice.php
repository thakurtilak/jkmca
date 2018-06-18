<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>IMS Invoice</title>
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
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="top"><img src="<?php echo base_url();?>assets/images/logo_wd.png" width="172" height="auto" /></td>
        <td align="right" valign="middle"><strong>TAX INVOICE</strong></td>
      </tr>
      <tr>
        <td align="left" valign="top">&nbsp;</td>
        <td align="right" valign="middle">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="top"><strong><?php echo $cmp_details->company_name;?></strong></td>
        <td align="right" valign="top"><strong><?php echo $invoice_no;?></strong></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="right" valign="top"><strong>Date: <?php echo $display_date;?></strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="top"><strong><?php echo $cmp_details->company_address;?></strong></td>
       <?php
        if ($company_id == 1) {
       ?>
        <td align="right" valign="top"><strong>PAN No. : <?php echo $cmp_details->pan_no;?></strong></td>
        <?php } ?>
      </tr>
      <tr>
        <td><strong>Phone : <?php echo $cmp_details->company_contact;?></strong></td>
        <?php
        if ($company_id == 1) {
       ?>
        <td align="right" valign="top"><strong>GSTIN No. : <?php echo $cmp_details->gst_no;?></strong></td>
        <?php } ?>
      </tr>
      <tr>
        <td><strong>Fax : <?php echo $cmp_details->company_fax;?></strong></td>
        <?php
        if ($company_id == 1) {
       ?>
        <td align="right" valign="top"><strong>SAC CODE : <?php echo $cmp_details->sac_code;?></strong></td>
        <?php } ?>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <?php
        if ($company_id == 1) {
       ?>
        <td align="right" valign="top"><strong>Service Category : <?php echo $service_category;?></strong></td>
        <?php } ?>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="top"><strong>To,</strong></td>
      </tr>
      <tr>
        <td><strong><?php echo $client_name;?></strong></td>
      </tr>
      <tr>
        <td><strong><?php echo wordwrap($client_address, 78, "<br />", TRUE);?></strong></td>
      </tr>
      <?php
      if ($company_id == 1 && $country_id == 101) {
       ?>
      <?php if($city!=''){ ?>
      <tr>

        <td><strong>City : <?php echo $city;?></strong></td>
      </tr>
      <?php } ?>
      <?php if($state!=''){ ?>
      <tr>
       <td><strong>State : <?php echo $state;?></strong></td>
      </tr>
      <?php } ?>
      <?php if($gst_no!=''){ ?>
      <tr>
       <td><strong>GSTIN NO. : <?php echo $gst_no;?></strong></td>
      </tr>
      <?php } ?>
      <?php } ?>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellspacing="0" cellpadding="5">
      <tr>
        <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>SALES<br />
          PERSON/AUTHORITY</strong></td>
        <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>PROJECT/CAMPAIGN TITLE</strong></td>
        <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>PO/RO ORDER</strong></td>
        <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>PO/RO DATED</strong></td>
        <td align="center" valign="middle" bgcolor="#4a51be" style="color:#fff;"><strong>PAYMENT TERMS</strong></td>
      </tr>
      <tr>
        <td align="center" valign="middle"><strong><?php echo $sales_person;?></strong></td>
        <td align="center" valign="middle"><strong><?php echo $project_title;?></strong></td>
        <td align="center" valign="middle"><strong><?php echo $po_no;?></strong></td>
        <td align="center" valign="middle"><strong><?php echo $po_date;?></strong></td>
        <td align="center" valign="middle"><strong><?php echo $paymentTermDuration;?></strong></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><table width="100%" border="1" cellspacing="0" cellpadding="5">
      <tr align="center" valign="middle">
        <td align="left" bgcolor="#4a51be" style="color:#fff;"><strong>S.NO.</strong></td>
        <td align="left" bgcolor="#4a51be" style="color:#fff;"><strong>DESCRIPTION</strong></td>
        <td align="right" bgcolor="#4a51be" style="color:#fff;"><strong>UNIT PRICE</strong></td>
        <td align="right" bgcolor="#4a51be" style="color:#fff;"><strong>TOTAL IN <?php echo $po_curr;?></strong></td>
      </tr>
      <tr>
        <td align="left" valign="middle"><strong>1.</strong></td>
        <td align="left" valign="middle"><strong><?php echo nl2br(wordwrap($invoice_gen_comments, 68, "<br />"));?></strong></td>
        <td align="right" valign="middle"></td>
        <td align="right" valign="middle"><strong><?php echo formatAmount(round($net_amt, 2));?></strong></td>
      </tr>
      <tr>
        <td align="right" colspan="3" valign="middle">TOTAL</td>
        <td align="right" valign="middle"><?php echo $po_curr . ' ' . formatAmount(round($net_amt, 2));?></td>
      </tr>
      <!--<tr>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="center" valign="middle">&nbsp;</td>
        <td align="right" valign="middle">IGST @ 18.00%</td>
        <td align="right" valign="middle">420.00 </td>
      </tr>-->
      <?php
      foreach ($taxdtl as $key => $value) {
       ?>
       <tr>
        <td align="right" colspan="3" valign="middle"><?php echo $value;?> @ <?php echo $tax[$key];?>%</td>
        <td align="right" valign="middle"><?php echo formatAmount($taxamt[$key]);?></td>
      </tr>
      <?php  
      }
      ?>
      <?php
      if ($company_id == 1) { ?>
      <tr>
        <td align="right" colspan="3" valign="middle">Total Tax (%) : <?php echo $total_tax;?>%</td>
        <td align="right" valign="middle"><?php echo formatAmount($total_taxamt);?></td>
      </tr>

      <tr>
        <td align="right" colspan="3" valign="middle"><strong>TOTAL DUE </strong></td>
        <td align="right" valign="middle"><strong style="font-size: 18px;"><?php echo $po_curr.' '.formatAmount($grossamt);?></strong></td>
      </tr>
      <?php } ?>
      <tr>
        <td colspan="4" align="right" valign="middle"><strong><?php echo $cheque_amt;?></strong></td>
        </tr>
    </table></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right"><strong>For <?php echo $cmp_details->company_name;?></strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>
      <table width="100%" border="0" cellspacing="0" cellpadding="5">
        <tr>
          <td><?php echo nl2br($bank_details);?></td>
          <td align="right" valign="bottom"><?php if($approver=='Y'){?><img src="<?php echo base_url(); ?>assets/images/sign.png" width="143" /><?php }?></td>
        </tr>
      </table> 
    </td>
    
    
  </tr>
  <tr>
    <td align="right"><strong>Authorized Signatory   </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="center" valign="middle"><strong><?php echo $cmp_details->invoice_footer_text;?></strong></td>
  </tr>
  <!-- <tr>
    <td align="center" valign="top"><strong>Fax : +91-731-2548555 Web : www.webdunia.net Email : corporate@webdunia.net</strong></td>
  </tr>
  <tr>
    <td align="center" valign="top"><strong>Regd. Office : Webdunia.om (lndia) Pvt. Ltd., 13, Manorama Chamber, 1st Floor, S V Road, Bandra West. 0pp. lndian Bank, Mumbai - 400050</strong></td>
  </tr>
  <tr>
    <td align="center" valign="top"><strong>Tel: +91-22-26401132 CIN NO. U72900MH2000PTC123528</strong></td>
  </tr> -->
  <tr>
    <td align="right" valign="top">&nbsp;</td>
  </tr>
</table>
</body>
</html>
