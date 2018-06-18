<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>Projection</title>
<link href="https://fonts.googleapis.com/css?family=Open+Sans" rel="stylesheet">
<style>
.table_bordered{border-spacing:0;border-collapse:collapse;}
.table_bordered tr td{border:1px solid #ddd;}
</style>
</head>
<body style="font-family: 'Open Sans', sans-serif;font-size:14px;line-height:20px;">
<?php $clientArray = array(); foreach($clients as $client) :
$clientArray[$client->client_id] = $client->client_name;
endforeach;
?>

<?php $currencyArray = array(); foreach($currencies as $currItem) :
$currencyArray[$currItem->currency_id] = $currItem->currency_symbol;
endforeach;
?>
<table width="800" border="0" align="center" cellpadding="5" cellspacing="0">
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td align="left" valign="middle"><img src="<?php echo base_url();?>assets/images/logo_ims.svg" width="250" /></td>
        <td align="left" valign="middle">&nbsp;</td>
        <td width="80" align="left" valign="middle"><img src="<?php echo base_url();?>assets/images/financial_year.svg" height="65" /></td>
        <td align="left" valign="middle"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
          <tr>
            <td align="center" valign="top" style="font-size:22px;line-height:30px;font-weight:600;">Financial Year</td>
          </tr>
          <tr>
            <td align="center" valign="top" style="font-size:18x;line-height:30px;font-weight:600;"><?php echo $currentFinancialYear; ?></td>
          </tr>
        </table></td>
        <td align="left" valign="middle">&nbsp;</td>
        <td width="80" align="left" valign="middle"><img src="<?php echo base_url();?>assets/images/rev_icon.svg" height="65" /></td>
        <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="center" valign="top" style="font-size:22px;line-height:30px;font-weight:600;">Projection</td>
          </tr>
          <tr>
            <td align="center" valign="top" style="font-size:18px;line-height:30px;font-weight:600;"><?php echo  $currencyArray[2]; ?> <?php echo formatAmount($projectionData['finalTotal'], 0);?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top"><table class="table_bordered" width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td colspan="3" align="left" valign="top" bgcolor="#5259ca" style="color:#fff;font-size:16px;font-weight:600;">Client / Project</td>
        <td colspan="12" align="left" valign="top" bgcolor="#5259ca" style="color:#fff;font-size:16px;font-weight:600;">Month</td>
        <td align="left" valign="top" bgcolor="#5259ca" style="color:#fff;font-size:16px;font-weight:600;">Total</td>
      </tr>
      <tr>
        <td align="left" valign="top" bgcolor="#cccef1" style="font-size:15px;font-weight:600;">Client</td>
        <td align="left" valign="top" bgcolor="#cccef1" style="font-size:15px;font-weight:600;">Project</td>
          <td align="left" valign="top" bgcolor="#cccef1" style="font-size:15px;font-weight:600;">Currency</td>
        <?php foreach($allMonths as $month) : ?>
            <td align="left" valign="top" bgcolor="#cccef1" style="font-size:15px;font-weight:600;"><?php echo date('M-y', strtotime($month)); ?></td>
        <?php endforeach; ?>
        <td align="left" valign="top" bgcolor="#cccef1" style="font-size:15px;font-weight:600;">&nbsp;</td>
      </tr>
      <?php if(isset($projectionData['client']) && count($projectionData['client'])): ?>
      <?php $monthTotal = array(); foreach($projectionData['client'] as $key => $clientItemId) : ?>
      <tr>
        <td align="left" valign="top" bgcolor="#fff">
            <?php if($clientItemId == 0) {
                echo "New Client";
                ?>
                <input type="hidden" name="client[]" value="0" />
                <?php
            } elseif($clientArray){
                echo (isset($clientArray[$clientItemId]))? $clientArray[$clientItemId] : '--';
            } ?>
        </td>
        <td align="left" valign="top" bgcolor="#fff">
           <?php
           if(isset($projectionData['projectName'][$key])) {
               echo $projectionData['projectName'][$key];
           }
           ?>
        </td>
          <td align="left" valign="top" bgcolor="#fff">
              <?php
              if(isset($projectionData['currency'][$key])) {
                  $currencyId = $projectionData['currency'][$key];
                  echo (isset($currencyArray[$currencyId])) ? $currencyArray[$currencyId] : "--";
              }
              ?>
          </td>
        <?php $eachTotal = 0; foreach($allMonths as $month) :
        $m = date('M', strtotime($month));
        $amt = "";
        if(!isset($monthTotal[$m])) {
            $monthTotal[$m] = 0;
        }
        if(isset($projectionData['revenue'][$m][$key]) && !empty($projectionData['revenue'][$m][$key])) {
            $amt = $projectionData['revenue'][$m][$key];
            $eachTotal += $amt;
            $monthTotal[$m] += getCurrencyConvertedAmount($currencyId, $amt);
        }
        ?>
        <td align="left" valign="top" bgcolor="#fff">
        	<?php echo ($amt) ? $currencyArray[$currencyId]." ".formatAmount($amt, 0) : '--'; ?>
        </td>
        <?php endforeach; ?>
        <td align="left" valign="top" bgcolor="#fff"><?php echo ($eachTotal) ? $currencyArray[$currencyId]." ".formatAmount($eachTotal, 0) : "";?></td>
      </tr>
      <?php endforeach; ?>
      <?php endif; ?>
      <tr>
        <td colspan="3" align="left" valign="top" bgcolor="#CCCEF1" style="font-size:15px;font-weight:600;">Total</td>
        <?php foreach($allMonths as $month) :
            $mt = date('M', strtotime($month));
            ?>
            <td align="left" valign="top" bgcolor="#CCCEF1" style="font-size:15px;font-weight:600;" id="<?php echo date('M', strtotime($month)); ?>">
                <?php echo (isset($monthTotal[$mt])) ? $currencyArray[2]." ".formatAmount($monthTotal[$mt], 0) : "";  ?></td>
        <?php endforeach; ?>
        <td align="left" valign="top" bgcolor="#CCCEF1" style="font-size:15px;font-weight:600;" id="grandTotal"><?php echo $currencyArray[2]; ?> <?php echo formatAmount($projectionData['finalTotal'], 0);?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" bgcolor="#232325"><table width="100%" border="0" cellspacing="0" cellpadding="5">
      <tr>
        <td align="left" valign="top" style="font-size:22px;color:#fff;font-weight:600">Financial Year Total</td>
        <td align="right" valign="top" style="font-size:22px;color:#fff;font-weight:600">
            <?php echo $currencyArray[2]; ?>  <?php echo formatAmount($projectionData['finalTotal'], 0);?>
        </td>
      </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
