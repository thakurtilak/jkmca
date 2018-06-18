<?php
if($currencies):
 $currencArray = array();
 foreach($currencies as $currency) :
    $currencArray[$currency->currency_id] = $currency->currency_name;
 endforeach;
endif;
?>
<div class="content-wrapper projection_page">
    <div class="inner_bg content_box">
        <form action="" name="projectionForm" id="projectionForm" method="post">
            <input type="hidden" name="isFinalStep" value="1" />
            <div class="row">
                <div class="projection_header">
                    <div class="row">
                        <div class="col-sm-3">
                            <div class="side_logo"><a title="" href="<?php echo base_url(); ?>" style="display:inline-block;"><img class="img-responsive" width="210" src="<?php echo base_url(); ?>assets/images/logo_ims.svg"></a></div>
                        </div>
                        <div class="col-sm-6 text-center">
                            <div class="revenue_block revenue_perojecction">
                                <div class="rev_block_flex fadeInLeft animated">
                                    <div class="rev_box">
                                        <div class="rev_chart_icon"><img  src="<?php echo base_url(); ?>assets/images/financial_year.svg" width="104"></div>
                                        <div class="rev_info achieve_info">
                                            <h3>Financial Year</h3>
                                            <h4><?php echo $currentFinancialYear; ?></h4>
                                        </div>
                                    </div>
                                </div><!--rev_block_flex-->
                            </div>

                        </div><!--col-sm-6-->
                        <div class="col-sm-3 text-right">

                            <div class="pro_currency">
                                <a href="#" class="back_projection" data-toggle="modal" data-target="#leaveModal"><i class="fa fa-reply" aria-hidden="true"></i>  Back to Dashboard</a>
                                <!-- <input type="hidden" name="currency" value="<?php /*echo $projectionData['currency'];*/?>"/>
                                <select disabled="disabled" class="ims_form_control" name="currency" id="currency" onchange="updateGrandTotal();">
                                    <option value="">Currency*</option>
                                    <?php /*if($currencies): */?>
                                        <?php /*foreach($currencies as $currency) : */?>
                                            <option <?php /*echo ($currency->currency_id == $projectionData['currency']) ? "selected":''; */?> value="<?php /*echo $currency->currency_id; */?>"><?php /*echo $currency->currency_name; */?></option>
                                        <?php /*endforeach; */?>
                                    <?php /*endif; */?>
                                </select>-->

                            </div>
                        </div>
                    </div>
                </div>
                <div class="ims_table table-responsive">
                    <!--<h3 class="form-box-title">Projection</h3>-->
                    <table class="table project_table projection_preview" id="fixed_pro_table" cellspacing="0" width="100%">
                        <thead class="header_pro">
                        <tr >
                            <th colspan="3"  width="250">Client / Project
                                <span class="pull-right">
                                <a class="btn-csv" href="<?php echo base_url('projections'); ?>/downloads" title="Download as a CSV"><i class="icon-csv"></i></a>
                                </span>
                            </th>
                            <th colspan="12">Month</th>
                            <th width="150">Total</th>
                        </tr>
                        <tr class="header_sub">
                            <td width="250">Client</td>
                            <td width="250">Project</td>
                            <td width="30">Currency</td>
                            <?php foreach($allMonths as $month) : ?>
                                <td width="150" style="min-width: 150px;"><?php echo date('M-y', strtotime($month)); ?></td>
                            <?php endforeach; ?>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($projectionData['client']) && count($projectionData['client'])): ?>
                            <?php $monthTotal = array(); foreach($projectionData['client'] as $key => $clientItemId) : ?>
                                <tr class="project_table project_row" id="project_row_1">
                                    <td colspan="1"  width="250">
                                        <div class="add_client client_select">
                                            <?php if($clientItemId == 0) {
                                                echo "New Client";
                                                ?>
                                                <input type="hidden" name="client[]" value="0" />
                                                <?php
                                            } elseif($clients){ ?>
                                                <?php foreach($clients as $client) :
                                                    if($client->client_id == $clientItemId) {
                                                        echo $client->client_name;
                                                        ?>
                                                        <input type="hidden" name="client[]" value="<?php echo $client->client_id;?>" />
                                                        <?php
                                                    }
                                                endforeach; ?>
                                            <?php } ?>
                                        </div>
                                    </td>
                                    <td colspan="1"  width="250">
                                        <div class="add_client project">
                                           <?php
                                           if(isset($projectionData['projectName'][$key])) {
                                               echo $projectionData['projectName'][$key];
                                           }
                                           if(isset($projectionData['project'][$key])) {
                                               ?>
                                               <input type="hidden" name="project[]" value="<?php echo $projectionData['project'][$key];?>" />
                                               <?php
                                           }
                                           ?>
                                        </div>
                                    </td>

                                    <td colspan="1"  width="30">
                                        <div class="add_client currency">
                                            <?php
                                            if(isset($projectionData['currency'][$key])) {
                                                $cId = $projectionData['currency'][$key];
                                                if(isset($currencArray[$cId])) {
                                                    echo $currencArray[$cId];
                                                }
                                            }
                                            if(isset($projectionData['currency'][$key])) {
                                                ?>
                                                <input type="hidden" name="currency[]" value="<?php echo $projectionData['currency'][$key];?>" />
                                                <?php
                                            }
                                            $currencySymbol = getCurrencySymbol($cId);
                                            ?>
                                        </div>
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

                                            $monthTotal[$m] += getCurrencyConvertedAmount($cId, $amt);
                                        }
                                        ?>
                                        <td ><input type="hidden" name="revenue[<?php echo date('M', strtotime($month)).'][]'; ?>" onkeypress="return isNumberKey(event)" onchange="calculateProjection(this);" class="ims_form_control revenue_amt" placeholder="Revenue" data-month="<?php echo date('M', strtotime($month)); ?>" value="<?php echo $amt; ?>" /><?php echo ($amt) ? $currencySymbol." ".formatAmount($amt, 0) : "--";?></td>
                                    <?php endforeach;  $eachTotal = formatAmount($eachTotal, 0); ?>
                                    <td class="eachTotal"><?php echo ($eachTotal) ? $currencySymbol." ".$eachTotal : "";?></td>

                                </tr>
                            <?php endforeach; ?>
                        <?php endif; ?>

                        <!--<tr>
                            <td colspan="16">
                                <div class="text-right add_row">
                                    <a onclick="addMoreProject();" href="javascript:void(0)" class="add_more_btn mdl-js-button mdl-js-ripple-effect ripple-white" ><img src="<?php /*echo base_url(); */?>assets/images/plus_bordered.svg"> <span class="add_span">Add New</span></a>
                                </div>
                            </td>
                        </tr>-->
                        <tr class="total_sub">
                            <td colspan="3">Total</td>

                            <?php foreach($allMonths as $month) :
                                $mt = date('M', strtotime($month));
                                ?>
                                <td id="<?php echo date('M', strtotime($month)); ?>"><?php echo (isset($monthTotal[$mt])) ? getCurrencySymbol(2)." ".formatAmount($monthTotal[$mt], 0) : "";  ?></td>
                            <?php endforeach; ?>
                            <td colspan="2" id="grandTotal"><?php echo (isset($projectionData['finalTotal']) && $projectionData['finalTotal']) ? getCurrencySymbol(2)." ".formatAmount($projectionData['finalTotal'], 0) :"";?></td>
                        </tr>

                        </tbody>
                    </table>
					
					<!--<table class="table project_table header_pro fixed-header" cellspacing="0" width="100%">
                        <thead class="">
                        <tr >
                            <th colspan="2" width="15%">Client / Project</th>
                            <th colspan="12">Month</th>
                            <th width="6%">Total</th>
                        </tr>
                        <tr class="header_sub">
                            <td width="7%">Client</td>
                            <td width="7%">Project</td>
                            <?php foreach($allMonths as $month) : ?>
                                <td><?php echo date('M-y', strtotime($month)); ?></td>
                            <?php endforeach; ?>
                            <td colspan="2">&nbsp;</td>
                        </tr>
                        </thead>
					</table>-->
					
                </div><!--ims_datatab-->
                <div class="fixed_pro_footer">
                    <div class="pro_container">
                        <div class="fy_title fy_tc"></div>
                        <div class="fy_btns fy_tc">
                            <button type="submit" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white" >Submit Projection</button>
                            <a href="<?php echo base_url();?>projections"><button type="button" class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white">Edit</button></a>
                        </div>
                        <div class="fy_total fy_tc" id="grandTotalFinal">Financial Year Total <span><?php echo (isset($projectionData['finalTotal']) && $projectionData['finalTotal']) ? getCurrencySymbol(2)." ".formatAmount($projectionData['finalTotal'], 0):"";?></span></div>
                        <input type="hidden" name="finalTotal" id="finalTotal" value="<?php echo $projectionData['finalTotal'];?>"/>
                    </div>
                </div>
            </div><!--row-->
        </form>
    </div><!--content_box-->
</div>
<div class="modal fade" id="leaveModal" tabindex="-1" role="dialog" aria-labelledby="leaveModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button class="close" type="button" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">×</span>
                </button>
				<h4 class="modal-title" id="leaveModalLabel">Want to Leave?</h4>
                
            </div>
            <div class="modal-body">Your current projection would be lost..</div>
            <div class="modal-footer">
				<div class="form-footer">
					<a class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white d-inblock" href="<?php echo base_url(); ?>dashboard" style="display:  inline-block;vertical-align: top;">Yes</a>
					<button class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" type="button" data-dismiss="modal">Cancel</button>
				</div>
            </div>
        </div>
    </div>
</div>
<script>
	var h =$(window).height();
	var k = 220;
	$('.ims_table').height(h-k);
	
	
    $('.ims-sidebar,.navbar-ims').hide();
    $('.content-box').css('margin','0');
	/*$('.header_pro').hide();*/
    $(document).ready(function() {
		$("#fixed_pro_table").tableHeadFixer(); 
        //var s = $(".header_pro");
		//var pos = s.position();
		/*$(window).scroll(function() {
			if ($(this).scrollTop()>200)
			 {
				$('.fixed-header').fadeIn();
			 }
			else
			 {
			  $('.fixed-header').fadeOut();
			 }
		});*/
    });
</script>