<?php $clientArray = array();
foreach ($clients as $client) :
    $clientArray[$client->client_id] = $client->client_name;
endforeach;
?>

<?php $currencyArray = array();
foreach ($currencies as $currItem) :
    $currencyArray[$currItem->currency_id] = $currItem->currency_symbol;
endforeach;
?>
<div class="content-wrapper projection_page">
    <div class="inner_bg content_box">

        <div class="row">
            <div class="projection_header">
                <div class="row">
                    <div class="col-sm-3">
                        <div class="side_logo"><a title="" href="<?php echo base_url(); ?>"
                                                  style="display:inline-block;"><img class="img-responsive" width="210"
                                                                                     src="<?php echo base_url(); ?>assets/images/logo_ims.svg"></a>
                        </div>
                    </div>
                    <div class="col-sm-6 text-center">
                        <div class="revenue_block revenue_perojecction">
                            <div class="rev_block_flex fadeInLeft animated">
                                <div class="rev_box">
                                    <div class="rev_chart_icon"><img
                                            src="<?php echo base_url(); ?>assets/images/financial_year.svg" width="104">
                                    </div>
                                    <div class="rev_info achieve_info">
                                        <h3>Financial Year</h3>
                                        <h4><?php echo $selectedFinancialYear; ?></h4>
                                    </div>
                                </div>
                            </div><!--rev_block_flex-->
                        </div>

                    </div><!--col-sm-6-->
                    <div class="col-sm-3 text-right">
                        <form action="" name="financialYearForm" id="financialYearForm" method="post">
                            <div class="pro_currency">
                                <a href="<?php echo base_url(); ?>" class="back_projection"><i class="fa fa-reply"
                                                                                               aria-hidden="true"></i>
                                    Back to Dashboard</a><br />
                                <select class="ims_form_control" name="financialYear" id="financialYear"
                                        onchange="this.form.submit();">
                                    <option value="">Financial Year</option>
                                    <?php if ($financialYears): ?>

                                        <?php foreach ($financialYears as $item) : ?>
                                            <option <?php echo ($item == $selectedFinancialYear) ? "selected" : ''; ?>
                                                value="<?php echo $item; ?>"><?php echo $item; ?></option>
                                        <?php endforeach; ?>
                                    <?php endif; ?>
                                </select>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
            <form action="" name="projectionEditForm" id="projectionEditForm" method="post">
                <div class="ims_table  table-responsive">
                    <!--<h3 class="form-box-title">Projection</h3>-->
                    <table class="table project_table projection_preview" id="fixed_pro_table" cellspacing="0" width="100%">
                        <thead class="header_pro1">
                        <tr>
                            <th colspan="3" width="250">Client / Project</th>
                            <th colspan="12">Month</th>
                            <th width="150">Total</th>
                        </tr>
                        <tr class="header_sub">
                            <td width="250">Client</td>
                            <td width="250">Project</td>
                            <td width="250">Currency</td>
                            <?php foreach ($allMonths as $month) : ?>
                                <td width="150" style="min-width: 150px;"><?php echo date('M-y', strtotime($month)); ?></td>
                            <?php endforeach; ?>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if (isset($projectionData['client']) && count($projectionData['client'])): ?>
                            <?php $monthTotal = array();
                            foreach ($projectionData['client'] as $key => $clientItemId) : ?>
                                <tr class="project_table project_row" id="project_row_1">
                                    <td colspan="1" width="7%">
                                        <div class="add_client client_select">
                                            <?php if ($clientItemId == 0) {
                                                echo "New Client";
                                                ?>
                                                <input type="hidden" name="client[]" value="0"/>
                                                <?php
                                            } elseif ($clientArray) {
                                                echo (isset($clientArray[$clientItemId])) ? $clientArray[$clientItemId] : '--';
                                            } ?>
                                        </div>
                                    </td>
                                    <td colspan="1" width="7%">
                                        <div class="add_client project">
                                            <?php
                                            if (isset($projectionData['projectName'][$key])) {
                                                echo $projectionData['projectName'][$key];
                                            } else {
                                                echo '--';
                                            }
                                            ?>
                                        </div>
                                    </td>
                                    <td colspan="1" width="4%">
                                        <div class="add_client currency">
                                            <?php
                                            if (isset($projectionData['currency'][$key])) {
                                                $currencyId = $projectionData['currency'][$key];
                                                if (isset($currencyArray[$currencyId])) {
                                                    echo $currencyArray[$currencyId];
                                                }
                                            }
                                            $currencySymbol = getCurrencySymbol($currencyId);
                                            ?>
                                        </div>
                                    </td>

                                    <?php $eachTotal = 0;
                                    foreach ($allMonths as $month) :
                                        $m = date('M', strtotime($month));
                                        $amt = "";
                                        if (!isset($monthTotal[$m])) {
                                            $monthTotal[$m] = 0;
                                        }
                                        if (isset($projectionData['revenue'][$m]['amount'][$key]) && !empty($projectionData['revenue'][$m]['amount'][$key])) {
                                            $amt = $projectionData['revenue'][$m]['amount'][$key];
                                            $rate = $projectionData['revenue'][$m]['rate'][$key];
                                            $eachTotal += $amt;
                                            $monthTotal[$m] += $amt * $rate;
                                        }
                                        ?>
                                        <td>
                                            <?php echo ($amt && $amt !='0.00') ? $currencySymbol . " " . formatAmount($amt, 0) : '--'; ?>
                                        </td>
                                    <?php endforeach; ?>
                                    <td class="eachTotal"><?php echo ($eachTotal) ? $currencySymbol . " " . formatAmount($eachTotal,0) : ""; ?></td>

                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="17">No Projection Found(s)</td>
                            </tr>
                        <?php endif; ?>
                        <?php if (isset($projectionData) && !empty($projectionData)) : ?>
                            <tr class="total_sub">
                                <td colspan="3">Total</td>

                                <?php foreach ($allMonths as $month) :
                                    $mt = date('M', strtotime($month));
                                    ?>
                                    <td id="<?php echo date('M', strtotime($month)); ?>"><?php echo (isset($monthTotal[$mt])) ? getCurrencySymbol(2) . " " . formatAmount($monthTotal[$mt], 0) : ""; ?></td>
                                <?php endforeach; ?>
                                <td colspan="2"
                                    id="grandTotal"><?php echo getCurrencySymbol(2) . " " . formatAmount($projectionData['finalTotal'], 0); ?></td>
                            </tr>
                        <?php endif; ?>

                        </tbody>
                    </table>
                    <!--<table class="table project_table header_pro fixed-header" cellspacing="0" width="100%">
                        <thead class="">
                        <tr>
                            <th colspan="2" width="15%">Client / Project</th>
                            <th colspan="12">Month</th>
                            <th width="6%">Total</th>
                        </tr>
                        <tr class="header_sub">
                            <td width="7%">Client</td>
                            <td width="7%">Project</td>
                            <?php foreach ($allMonths as $month) : ?>
                                <td><?php echo date('M-y', strtotime($month)); ?></td>
                            <?php endforeach; ?>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        </thead>
                    </table>-->

                </div><!--ims_datatab-->
                <?php if (isset($projectionData) && !empty($projectionData)) : ?>
                    <div class="fixed_pro_footer">
                        <div class="pro_container">
                            <div class="fy_title fy_tc"></div>
                            <?php if($currentFinancialYear == $selectedFinancialYear) : ?>
                                <div class="fy_btns fy_tc">
                                    <input type="hidden" name="editProjection" id="editProjection" value="1"/>
                                    <button type="submit" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white" >Edit Projections</button>
                                </div>
                            <?php endif; ?>
                            <div class="fy_total fy_tc" id="grandTotalFinal">Financial Year Total
                                <span><?php echo getCurrencySymbol(2) . " " . formatAmount($projectionData['finalTotal'], 0); ?></span>
                            </div>
                            <input type="hidden" name="finalTotal" id="finalTotal"
                                   value="<?php echo $projectionData['finalTotal']; ?>"/>
                        </div>
                    </div>
                <?php endif; ?>
            </form>
        </div><!--row-->
    </div><!--content_box-->
</div>
<script>
	var h =$(window).height();
	var k = 220;
	$('.ims_table').height(h-k);
	
    $('.ims-sidebar,.navbar-ims').hide();
    $('.content-box').css('margin', '0');
    /*$('.header_pro').hide();*/
    $(document).ready(function () {
		$("#fixed_pro_table").tableHeadFixer(); 
        //var s = $(".header_pro");
        //var pos = s.position();
       /* $(window).scroll(function () {
            if ($(this).scrollTop() > 200) {
                $('.fixed-header').fadeIn();
            }
            else {
                $('.fixed-header').fadeOut();
            }
        });*/
    });
</script>