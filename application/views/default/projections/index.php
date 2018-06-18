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
		<?php
		if(isset($currencyRates) && count($currencyRates) < 1 && !isset($projectionData)) { ?>
			<div class="alert alert-danger" id="error_mesg"style="margin-top:18px;">
				Currency Conversion rate for <strong><?php echo date('M-Y'); ?></strong> not added yet, You can not add projection. Please contact to account team.
			</div>
		<?php }
		?>
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
										<h4><?php echo $selectedFinancialYear; ?></h4>
									</div>
								</div>
							</div><!--rev_block_flex-->

							<!--<div class="rev_block_flex fadeInRight animated">
								<div class="rev_box">
									<div class="rev_chart_icon"><img src="<?php  echo base_url(); ?>assets/images/rev_icon.svg" width="104"></div>
									<div class="rev_info proj_info">
										<h3>Projection</h3>
										<h4 class="generatedAmt_top" id="topGrandTotal"><i class="fa fa-inr" aria-hidden="true"></i>0</h4>
									</div>
								</div>
							</div>--><!--rev_block_flex-->
						</div>

					</div><!--col-sm-6-->
					<div class="col-sm-3 text-right">
						<form action="" name="financialYearForm" id="financialYearForm" method="post">
							<div class="pro_currency">
								<a href="#" class="back_projection" data-toggle="modal" data-target="#leaveModal"><i class="fa fa-reply" aria-hidden="true"></i>  Back to Dashboard</a>&nbsp;|&nbsp;<a href="#"  class="back_projection" data-toggle="modal" data-target="#helpText">Help</a><br />
								<select class="ims_form_control" name="financialYear" id="financialYear" onchange="this.form.submit();">
									<option value="">Financial Year</option>
									<?php if($financialYears): ?>
										<?php foreach($financialYears as $item) : ?>
											<option <?php echo ($item == $selectedFinancialYear) ? "selected":''; ?> value="<?php echo $item; ?>"><?php echo $item; ?></option>
										<?php endforeach; ?>
									<?php endif; ?>
								</select>
							</div>
						</form>
					</div>
				</div>
			</div>
			<form action="" name="projectionForm" id="projectionForm" method="post">
			<div class="ims_table table-responsive">
				<!--<h3 class="form-box-title">Projection</h3>-->
				<table id="projectionTable" class="table project_table" cellspacing="0" width="100%">
					<thead class="header_pro">
					<tr >
						<th colspan="2" width="250">Client / Project <?php if(isset($currencyRates) && count($currencyRates) > 1) : ?>
						    <span class="pull-right">
						    <a href="#" class="add_more_btn" data-toggle="modal" data-target="#questionModal"><img src="<?php echo base_url(); ?>assets/images/help-w_bordered.png"></a>
							<a onclick="addMoreProject();" href="javascript:void(0)" class="add_more_btn mdl-js-button mdl-js-ripple-effect ripple-white" ><img src="<?php echo base_url(); ?>assets/images/plus-w_bordered.png"></a>
							<?php endif; ?>
                           </span>
							</th>
						<th colspan="12">Month</th>
						<th width="150">Total</th>
					</tr>
					<tr class="header_sub">
						<td colspan="2"  width="250">&nbsp;</td>
						<?php foreach($allMonths as $month) : ?>
							<td width="150px"><?php echo date('M-y', strtotime($month)); ?></td>
						<?php endforeach; ?>
						<td colspan="2" width="150">
						<!-- 	<?php if(isset($currencyRates) && count($currencyRates) > 1) : ?>
							<a onclick="addMoreProject();" href="javascript:void(0)" class="add_more_btn mdl-js-button mdl-js-ripple-effect ripple-white" ><img src="<?php echo base_url(); ?>assets/images/plus_bordered.svg"></a>
							<?php endif; ?> -->
						</td>
					</tr>
					</thead>
					<tbody>
					<?php if(isset($projectionData) && isset($projectionData['client']) && count($projectionData['client'])): ?>
					<?php $monthTotal = array();
						foreach($projectionData['client'] as $key => $clientItemId) : ?>
							<tr class="project_table project_row" id="project_row_<?php echo $key+1; ?>">
								<td colspan="2" width="250">
									<div class="add_client client_select">
										<select class="ims_form_control client" name="client[]">
											<option value="">Select Client</option>
											<option <?php echo ( $clientItemId == 0) ? "selected=selected":""; ?> value="0">New Client</option>
											<?php if($clients): ?>
												<?php foreach($clients as $client) : ?>
													<option <?php echo ( $clientItemId == $client->client_id) ? "selected":""; ?> value="<?php echo $client->client_id; ?>"><?php echo $client->client_name; ?></option>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>
									</div>
									<div class="add_client project">
										<select class="ims_form_control" name="project[]" >
											<option value="">Select Project</option>
											<option <?php echo (isset($projectionData['project'][$key]) && $projectionData['project'][$key] == 0)? "selected":"";?>  value="0">New Project</option>
											<?php if(isset($projectionData['project'][$key]) && $projectionData['project'][$key] != 0):  ?>
											   <?php if(isset($projectionData['projectList'][$key])):
													$pLists = $projectionData['projectList'][$key];
													$prjectId = $projectionData['project'][$key];
													?>
													<?php foreach($pLists as $pItem) : ?>
														<option <?php echo ( $prjectId == $pItem->order_id) ? "selected":""; ?> value="<?php echo $pItem->order_id; ?>"><?php echo $pItem->project_name; ?></option>
													<?php endforeach; ?>
												<?php endif; ?>
											<?php endif; ?>
										</select>
									</div>
									<div class="add_client currency">
										<select class="ims_form_control" name="currency[]" onchange="calculateAll(this);">
											<option value="">Currency*</option>
											<?php if($currencies): ?>
											<?php	if(isset($projectionData['currency'][$key])) {
													$currencyId = $projectionData['currency'][$key];
												    }
													$currencySymbol = getCurrencySymbol($currencyId);
												?>
												<?php foreach($currencies as $currency) : ?>
													<option <?php echo ( $currencyId == $currency->currency_id) ? "selected=selected":""; ?> value="<?php echo $currency->currency_id; ?>"><?php echo $currency->currency_name; ?></option>
												<?php endforeach; ?>
											<?php endif; ?>
										</select>
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

										$monthTotal[$m] += getCurrencyConvertedAmount($currencyId, $amt);
									}
									?>
									<td width="120"><input value="<?php echo $amt; ?>" maxlength="12" type="text" name="revenue[<?php echo date('M', strtotime($month)).'][]'; ?>" onkeypress="return isNumberKey(event)" onchange="calculateProjection(this);" class="ims_form_control revenue_amt" placeholder="Revenue" data-month="<?php echo date('M', strtotime($month)); ?>" /></td>
								<?php endforeach;  $eachTotal = formatAmount($eachTotal, 0);  ?>
								<td class="eachTotal"  width="120"><span class='ptotal'><?php echo ($eachTotal) ? $currencySymbol." ".$eachTotal : "";?></span><a style="<?php echo ($key == 0) ? "display:none;": "" ?>" href='javascript:void(0);' class='delete_row'><img src='<?php echo base_url();?>assets/images/delete_icon.svg'></a></td>
							</tr>
					<?php endforeach;
					else : ?>
					<?php if(isset($currencyRates) && count($currencyRates) > 0): ?>
					<tr class="project_table project_row" id="project_row_1">
						<td colspan="2" width="250">
							<div class="add_client client_select">
								<select class="ims_form_control client" name="client[]">
									<option value="">Select Client</option>
									<option value="0">New Client</option>
									<?php if($clients): ?>
									<?php foreach($clients as $client) : ?>
									<option value="<?php echo $client->client_id; ?>"><?php echo $client->client_name; ?></option>
									<?php endforeach; ?>
									<?php endif; ?>
								</select>
							</div>
							<div class="add_client project">
								<select class="ims_form_control" name="project[]" >
									<option value="">Select Project</option>
									<option value="0">New Project</option>
								</select>
							</div>
							<div class="add_client currency">
								<select class="ims_form_control" name="currency[]" onchange="calculateAll(this);">
									<option value="">Currency*</option>
									<?php if($currencies): ?>
										<?php foreach($currencies as $currency) : ?>
											<option value="<?php echo $currency->currency_id; ?>"><?php echo $currency->currency_name; ?></option>
										<?php endforeach; ?>
									<?php endif; ?>
								</select>
							</div>
						</td>

						<?php foreach($allMonths as $month) : ?>
							<td width="120"><input maxlength="12" type="text" name="revenue[<?php echo date('M', strtotime($month)).'][]'; ?>" onkeypress="return isNumberKey(event)" onchange="calculateProjection(this);" class="ims_form_control revenue_amt" placeholder="Revenue" data-month="<?php echo date('M', strtotime($month)); ?>" /></td>
						<?php endforeach; ?>
						<td class="eachTotal"  width="120"><a style="display:none;" href='javascript:void(0);' class='delete_row'><img src='<?php echo base_url();?>assets/images/delete_icon.svg'></a></td>
					</tr>
						<?php endif; ?> <!-- For currency rate -->
					<?php endif; ?>
					<tr class="total_sub">
						<td colspan="2">Total</td>

						<?php foreach($allMonths as $month) :
							$mt = date('M', strtotime($month));
							?>
							<td class="generatedAmt" id="<?php echo date('M', strtotime($month)); ?>"><?php echo (isset($monthTotal[$mt])) ? getCurrencySymbol(2)." ".formatAmount($monthTotal[$mt], 0) : "";  ?></td>
						<?php endforeach; ?>
						<td class="generatedAmt" colspan="2" id="grandTotal" style="min-width: 112px;"><?php echo (isset($projectionData['finalTotal']) && $projectionData['finalTotal']) ? getCurrencySymbol(2)." ".formatAmount($projectionData['finalTotal'], 0) :"";?></td>
					</tr>

					</tbody>
				</table>
			</div><!--ims_datatab-->
				<?php if(isset($currencyRates) && count($currencyRates) > 0): ?>
					<div class="fixed_pro_footer">
						<div class="pro_container">
							<div class="fy_title fy_tc"></div>
							<div class="fy_btns fy_tc">
								<button type="submit" class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white" >Submit</button>
								<button id="resetProjection" type="reset" class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white">Reset</button>
							</div>
							<div class="fy_total fy_tc" >Financial Year Total <span id="grandTotalFinal" class="generatedAmt"><?php echo (isset($projectionData['finalTotal']) && $projectionData['finalTotal']) ? getCurrencySymbol(2)." ".formatAmount($projectionData['finalTotal'], 0) :"";?></span></div>
							<input type="hidden" name="finalTotal" id="finalTotal" value="<?php echo (isset($projectionData) && isset($projectionData['finalTotal'])) ? $projectionData['finalTotal'] : "";?>"/>
						</div>
					</div>
				<?php endif; ?> <!-- For currency rate -->
			</form>
		</div><!--row-->

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
				<a class="btn-theme btn-submit mdl-js-button mdl-js-ripple-effect ripple-white d-inblock" href="<?php echo base_url(); ?>dashboard">Yes</a>
				<button class="btn-theme btn-reset ml10 mdl-js-button mdl-js-ripple-effect ripple-white" type="button" data-dismiss="modal">Cancel</button>
				
			</div>
		</div>
	</div>
</div>

<div id="helpText" class="modal helpdiv">
    <div class="modal-dialog modal-md zoomIn animated">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Instructions</h4>
            </div>
            <div class="modal-body custom_scroll bg-white">
            <ul>
            <li>Welcome to projection screen of Invoice Management System</li>
            <li>Select the client name from the dropdown list available at the left side</li>
            <li>Select the respective project name of the previously selected client</li>
            <li>Select the projection currency type</li>
            <li>For prospective clients, choose “New Client” and “New Project” </li>
            <li>Enter the projection amount in selected currency type for the current month of given financial year</li>
            <li>To add a new entry, click on the ‘+’ icon provided at the right hand side</li>
            <li>Once all the entries have been filled, the monthly and yearly total will get displayed at the respective positions</li>
            <li>User can reset the complete form by clicking on the reset button available at the bottom</li>
            <li>Clicking on the submit button from current screen displays a preview of the submitted entries</li>
            <li>On preview page, clicking on the cancel button brings back the user to previous page in editable mode</li>
            <li>Clicking on the final submit button submits the projection details permanently</li> 
            <li>Once the data is submitted, it will not be editable.</li>  
            </ul>

            </div><!--modal-body-->
            
        </div>
    </div>
</div>

<div id="questionModal" class="modal helpdiv">
    <div class="modal-dialog modal-md zoomIn animated">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Help</h4>
            </div>
            <div class="modal-body custom_scroll bg-white">
            <ul>
            <li>For prospective clients, choose “New Client” and “New Project” </li>
            <li>To Add Client/Project click on  “+” </li>
            </ul>

            </div><!--modal-body-->
            
        </div>
    </div>
</div>
<script>
	
	var h =$(window).height();
	var k = 220;
	$('.ims_table').height(h-k);
	
	$currencyRates = '<?php echo json_encode($currencyRates); ?>';
	$currencyRates = JSON.parse($currencyRates);
	$('.ims-sidebar,.navbar-ims').hide();
	$('.content-box').css('margin','0');
	$('table').on('scroll', function () {
		$("table > *").width($("table").width() + $("table").scrollLeft());
	});
	
	
	//$('.header_pro').hide();
	var projectCloneObje;
	$(document).ready(function() {

		<?php if(!isset($projectionData)) :  ?>
		$("#helpText").modal('show');
		<?php endif;  ?>

		$("#projectionTable").tableHeadFixer(); 
		
		/*DHARMENDRA*/
		projectCloneObje = $("#project_row_1").clone();

		$("#resetProjection").click(function(){
			$(".generatedAmt").text("");
			$("#finalTotal").val("");
			$(".ptotal").remove();
			//$(".generatedAmt_top").html('<i class="fa fa-inr" aria-hidden="true"></i> 0');
			$(document).find("select[name='client[]'] option").removeAttr("selected");
			$(document).find("select[name='currency[]'] option").removeAttr("selected");
			$(document).find("select[name='project[]'] option").removeAttr("selected");
			$(document).find("select[name='project[]'] option").not(':eq(0)').remove();
			var defaultOption = '<option value="">Select Project*</option>';
			$(document).find("select[name='project[]']").not(':eq(0)').html(defaultOption);

			//$(document).find("select[name='project[]'] option").not(':eq(0), :selected').remove();
			$(document).find("input").each(function () {
				$(this).attr('value', '');
				//$(this).prop('value', '');
			});
		});

		$(document).on('change','.client', function () {
			var clientId = $(this).val();
			$this = this;
			$.ajax({
				type: "POST",
				url: BASEURL + "projections/getProjectByClient",
				data: {clientId: clientId},
				beforeSend: function () {
					// setting a timeout
					$('.loader-wrapper').show()
				},
				success: function (response) {
					$($this).parent().parent().find('div.project select').html(response);
					if(clientId == '0') {
						$($this).parent().parent().find('div.project select').val(0);
					}
				},
				error: function (error) {
					$('.loader').hide();
					alert("There is an error while getting details. Please try again.");
				},
				complete: function () {
					$('.loader-wrapper').hide();
				},
			});
		});

		/*Delete Row*/
		$(document).on('click', '.delete_row', function(){
			$(this).parent().parent().remove();
			calculateAll();
			//updateGrandTotal();
		});

		$("#projectionForm").submit(function(){
			$finalTotal = $("#finalTotal").val();
			if($finalTotal =='' || $finalTotal == 0) {
				alert('Please add your projection first');
				return false;
			}

			var formValidate = true;
			var currentItem = null;
			$("select[name='client[]']").each(function(){
				var clnt = $(this).val();
				if(clnt =='') {
					formValidate = false;
					currentItem = this;
				}
			});
			if(!formValidate) {
				alert('Please select client');
				$(currentItem).focus();
				return false;
			}

			$("select[name='project[]']").each(function(){
				var prjct = $(this).val();
				if(prjct =='') {
					formValidate = false;
					currentItem = this;
				}
			});

			if(!formValidate) {
				alert('Please select project');
				$(currentItem).focus();
				return false;
			}

			$("select[name='currency[]']").each(function(){
				var curr = $(this).val();
				if(curr =='') {
					formValidate = false;
					currentItem = this;
				}
			});

			if(!formValidate) {
				alert('Please select currency');
				$(currentItem).focus();
				return false;
			}
			return formValidate;
		});
	});

	function addMoreProject() {

		var LastEl = $(".project_row").last();
		var lastid = LastEl.attr('id');
		var LastIdParts = lastid.split("project_row_");
		var lenth = LastIdParts[1];
		var nextIndex = parseInt(lenth) + 1;
		projectCloneObje.attr('id','project_row_'+nextIndex);
		var deleteText = "<a href='javascript:void(0);' class='delete_row'><img src='<?php echo base_url();?>assets/images/delete_icon.svg'></a>";
		projectCloneObje.each(function () {
			$(this).find("select[name='client[]']").val("");
			$(this).find("select[name='project[]']").val("");
			$(this).find("select[name='currency[]']").val("");

			$(this).find("select[name='client[]'] option").removeAttr("selected");
			$(this).find("select[name='currency[]'] option").removeAttr("selected");
			$(this).find("select[name='project[]'] option").not(':eq(0), :selected').remove();
			$(this).find("input").each(function () {
				$(this).attr('value', '');
				//$(this).prop('value', '');
			});
			$(this).find(".eachTotal").html(deleteText);
		});
		$cloneHtml = projectCloneObje.wrap('<div>').parent().html();
		//$(".project_table").append($cloneHtml);
		$( "#project_row_"+lenth ).after( $cloneHtml );
		$('#project_row_'+nextIndex).find(":input[type='text']:first").focus();
	}

	function calculateProjection($this) {
		var amount = $($this).val();
		if (amount != '') {
			if (!validate($this)) {
				$($this).val("");
				return false;
			}
		}
		$month = $($this).data("month");
		$parentRow = $($this).parent().parent();
		$rowTotal = 0;
		$monthTotal = 0;
		$parentRow.find(".revenue_amt").each(function(){
			var eachAmt = $(this).val();
			if(eachAmt) {
				$rowTotal = $rowTotal + parseFloat(eachAmt);
			}
		});
		var rowCurr = $parentRow.find("div.currency select").val();
		$formatedRowTotal = getFormatedAmount($rowTotal, rowCurr);
		if($parentRow.attr('id') != 'project_row_1'){
			var deleteText = "<span class='ptotal'>"+$formatedRowTotal+"</span><a href='javascript:void(0);' class='delete_row'><img src='<?php echo base_url();?>assets/images/delete_icon.svg'></a>";
		} else  {
			var deleteText = "<span class='ptotal'>"+$formatedRowTotal+"</span>";
		}
		$parentRow.find(".eachTotal").html(deleteText);

		calculateMonthTotal($month);
		updateGrandTotal();

	}

	function calculateMonthTotal($month){
		$monthTotal = 0;
		//calculate Each month Total
		$(document).find("input[name='revenue["+$month+"][]']").each(function(){
			var monthAmt = $(this).val();
			$parentRow = $(this).parent().parent();
			if(monthAmt) {
				var curr =	$parentRow.find("div.currency select").val();
				 monthAmt = monthAmt * parseFloat($currencyRates[curr]);
				$monthTotal = $monthTotal + parseFloat(monthAmt);
			}

		});
		//$monthTotal = numberFormat($monthTotal);
		$monthTotal = getFormatedAmount($monthTotal, 2); //Bcoz wanna all sum in indian RS
		$("#"+$month).html($monthTotal);
	}

	function updateGrandTotal() {
		var grandTotal = 0;

		//Calculate Grand Total
		$(".revenue_amt").each(function(){
			var eachAmt = $(this).val();
			$parentRow = $(this).parent().parent();
			var curr =	$parentRow.find("div.currency select").val();
			if(eachAmt) {
				eachAmt = eachAmt * parseFloat($currencyRates[curr]);
				grandTotal = grandTotal + parseFloat(eachAmt);
			}
		});

		$("#finalTotal").val(grandTotal);

		$text = getFormatedAmount(grandTotal, 2);

		$("#grandTotal").html($text);
		$("#topGrandTotal").html($text);
		$("#grandTotalFinal").html($text);
	}

	function calculateAll($currSelf) {
		if($currSelf != undefined) {
			$cItemParent = $($currSelf).parent().parent();
			if($cItemParent) {
				var SclientId = $($cItemParent).find("div.client_select select").val();
				var SprojectId = $($cItemParent).find("div.project select").val();
				if(SclientId =='' || SprojectId == '') {
					return;
				}
			}
		}

		$("#projectionTable .project_row").each(function(){
			var $rowTotal = 0;
			var curr =	$(this).find("div.currency select").val();
			$(this).find(".revenue_amt").each(function(){
				var eachAmt = $(this).val();
				if(eachAmt) {
					$rowTotal = $rowTotal + parseFloat(eachAmt);
				}
			});
			if($rowTotal > 0){
				$formatedRowTotal = getFormatedAmount($rowTotal, curr);
				if($(this).attr('id') != 'project_row_1'){
					var deleteText = "<span class='ptotal'>"+$formatedRowTotal+"</span><a href='javascript:void(0);' class='delete_row'><img src='<?php echo base_url();?>assets/images/delete_icon.svg'></a>";
				} else  {
					var deleteText = "<span class='ptotal'>"+$formatedRowTotal+"</span>";
				}
				$(this).find(".eachTotal").html(deleteText);
			}

		});
		/*$($cItemParent).find(".revenue_amt").each(function(){
				$(this).trigger("change");
		});*/
		$(".revenue_amt").trigger("change");
		updateGrandTotal();
	}

	function isNumberKey(evt)
	{
		var charCode = (evt.which) ? evt.which : evt.keyCode;
		if (charCode != 46 && charCode > 31
			&& (charCode < 48 || charCode > 57))
			return false;

		return true;
	}

	function validate($this){
		/*$currency = $("#currency").val();
		if($currency == '') {
			alert("Please select currency first");
			return false;
		}*/
		$parentRow = $($this).parent().parent();
		$clientId = $parentRow.find(".client_select select").val();
		$projectId = $parentRow.find(".project select").val();
		$currency = $parentRow.find(".currency select").val();
		if($clientId ==='') {
			alert("Please select client first");
			return false;
		}
		if($projectId ==='') {
			alert("Please select project");
			return false;
		}
		if($currency == '') {
			alert("Please select currency first");
			return false;
		}
		return true;
	}

	function getFormatedAmount(grandTotal, $currency) {
		var currencyClass = '';
		if($currency == '1') {
			currencyClass = 'fa fa-dollar';
		} else if($currency == '2') {
			currencyClass = 'fa fa-inr';
		}else if($currency == '3') {
			currencyClass = 'fa fa-dollar';
		}else if($currency == '4') {
			currencyClass = 'fa fa-dollar';
		}else if($currency == '5') {
			currencyClass = 'fa fa-dollar';
		}else if($currency == '6') {
			currencyClass = 'fa fa-euro';
		}else if($currency == '7') {
			currencyClass = 'fa fa-gbp';
		}
		grandTotal = numberFormat(grandTotal);
		$text = "<i class='"+currencyClass+"'></i> "+grandTotal;
		return $text;
	}

	function numberFormat(number) {
		//number = number.toFixed(2);
		//alert(number);
		return number.toLocaleString('en-IN', { minimumFractionDigits: 0, maximumFractionDigits:0 });
		/*return  number.toFixed(2).replace(/./g, function(c, i, a) {
				return i > 0 && c !== "." && (a.length - i) % 3 === 0 ? "," + c : c;
		});*/
	}

</script>