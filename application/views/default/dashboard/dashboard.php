<div class="content-wrapper">
	<div class="row">
    <?php if($this->session->flashdata('error') != '') { ?>
        <div class="alert alert-danger" id="error_mesg"style="margin-top:18px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <?php echo $this->session->flashdata('error'); ?>
        </div>
    <?php } ?>
    <?php if($this->session->flashdata('success') != '') { ?>
        <div class="alert alert-success" id="success_msg" style="margin-top:18px;">
            <a href="#" class="close" data-dismiss="alert" aria-label="close" title="close">×</a>
            <?php echo $this->session->flashdata('success'); ?>
        </div>
    <?php } ?>
	</div>
    <div class="row">
    <div class="col-sm-12">
        <div class="revenue_block">
			<div class="rev_block_flex fadeInLeft animated">
                <div class="rev_box">
                    <div class="rev_chart_icon"><img src="<?php echo base_url(); ?>assets/images/financial_year.svg" width="81" /></div>
                    <div class="rev_info achieve_info">
                        <h3>Financial Year</h3>
                        <h4><?php echo $selectedFinancialYear; ?></h4>
                    </div>
                </div>
            </div><!--rev_block_flex-->
            <div class="rev_block_flex fadeInLeft animated">
                <div class="rev_box">
                    <div class="rev_chart_icon"><img src="<?php echo base_url(); ?>assets/images/rev_icon.svg" width="81" /></div>
                    <div class="rev_info achieve_info">
                        <h3>Achieved</h3>
                        <h4><i class="fa fa-inr" aria-hidden="true"></i> <?php echo formatAmount($totalAchieved); ?></h4>
                    </div>
                </div>
            </div><!--rev_block_flex-->
            <div class="rev_block_flex fadeInRight animated">
                <div class="rev_box">
                    <div class="rev_chart_icon"><img src="<?php echo base_url(); ?>assets/images/rev_icon.svg" width="81" /></div>
                    <div class="rev_info achieve_info">
                        <h3>Projection</h3>
                        <h4><i class="fa fa-inr" aria-hidden="true"></i> <?php echo formatAmount($currentProjection);?></h4>
                    </div>
                </div>
            </div><!--rev_block_flex-->
        </div><!--revenue_block-->
    </div><!--col-sm-12-->
    <div class="col-sm-12">
        <div class="dash_box_block slideInUp animated">
            <div class="dash_box_header">
                <div class="row">
                    <div class="col-sm-6">
                        <h3 class="dash_box_header-title">Actual Invoice v/s Projected Invoice</h3>
                    </div>
                    <div class="col-sm-6 text-right">
                        <h4 class="dash_box_header_date"><span id="ActualProjectedInvoiceText"><?php echo $selectedFinancialYear; ?></span> <img id="ActualProjectedInvoice" src="<?php echo base_url(); ?>assets/images/calendar_icon-dash.svg" width="21"></h4>
                    </div>
                </div>
            </div><!--dash_box_header-->
            <div class="dash_box_body" id="ActualProjectedInvoiceGraph">
                <div id="inv_project" style="width: 100%; height: 400px; margin: 0 auto"></div>
            </div><!--dash_box_body-->
        </div><!--dash_box_block-->
    </div><!--col-sm-12-->
    <div class="col-sm-6">
        <div class="dash_box_block fadeInLeft animated">
            <div class="dash_box_header">
                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="dash_box_header-title">Stream Wise Actual Invoicing</h3>
                    </div>
                    <div class="col-sm-4 text-right">
                        <h4 class="dash_box_header_date"><span id="streamWiseInvoiceText"><?php echo date('M Y', strtotime($currentMonth)); ?></span><a href="javascript:void(0);"><img id="streamWiseInvoice" src="<?php echo base_url(); ?>assets/images/calendar_icon-dash.svg" width="21"></a></h4>
                    </div>
                </div>
            </div><!--dash_box_header-->
            <div class="dash_box_body" id="stream_wise_invoice_graph">
                <div id="actual_invoice" style="min-width: 210px; height: 300px; max-width: 100%;"></div>
            </div><!--dash_box_body-->
        </div><!--dash_box_block-->
        <!--Sales persen Wise-->
        <div class="dash_box_block zoomIn animated">
            <div class="dash_box_header">
                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="dash_box_header-title">Sales Person Wise Invoicing</h3>
                    </div>
                    <div class="col-sm-4 text-right">
                        <h4 class="dash_box_header_date"><span id="salesPersonInvoiceText"><?php echo date('M Y', strtotime($currentMonth)); ?></span> <a href="javascript:void(0);"><img id="salesPersonInvoice" src="<?php echo base_url(); ?>assets/images/calendar_icon-dash.svg" width="21"></a></h4>
                    </div>
                </div>
            </div><!--dash_box_header-->
            <div class="dash_box_body">
                <div class="sales_person_invoice" id="sales_person_invoice_table">
                    <div id="sales_person_invoice" style="min-width: 260px; max-width: 100%; height: 400px; margin: 0 auto"></div>
                    <!--<div class="row">
                        <?php /*if(isset($sPersonWiseTotalInvoicingForMonth) && $sPersonWiseTotalInvoicingForMonth):
                            $colorArray = array('prog_purple', 'prog_blue', 'prog_red', 'prog_yellow', 'prog_green');
                            */?>
                            <?php /*foreach($sPersonWiseTotalInvoicingForMonth as $salesPerson => $invoiceAmt):
                            $amount = formatAmount($invoiceAmt/100000);
                            */?>
                            <div class="col-sm-4">
                                <div class="spi_progress">
                                    <label class="inv_total"><?php /*echo $amount; */?> Lacs</label>
                                    <div class="progress <?php /*echo $colorArray[array_rand($colorArray)]; */?>">
                                        <div class="progress-bar" role="progressbar" style="width: <?php /*echo $amount; */?>%" aria-valuenow="<?php /*echo $amount; */?>" aria-valuemin="0" aria-valuemax="100"></div>
                                    </div>
                                    <label class="inv_sp_name"><?php /*echo $salesPerson; */?></label>
                                </div>
                            </div>
                        <?php /*endforeach; */?>
                        <?php /*endif; */?>
                    </div>-->
                </div><!--sales_person_invoice-->
            </div><!--dash_box_body-->
        </div><!--dash_box_block-->

		
		
        <!--End Sales persen Wise-->
    </div><!--col-sm-6-->
	<div class="col-sm-6">
		<div class="dash_box_block fadeInRight animated">
            <div class="dash_box_header">
                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="dash_box_header-title">Business Manager Wise Invoicing</h3>
                    </div>
                    <div class="col-sm-4 text-right">
                        <h4 class="dash_box_header_date"><span id="businessManagerInvoiceText"><?php echo date('M Y', strtotime($currentMonth)); ?></span><a href="javascript:void(0);"> <img id="businessManagerInvoice" src="<?php echo base_url(); ?>assets/images/calendar_icon-dash.svg" width="21"></a></h4>
                    </div>
                </div>
            </div><!--dash_box_header-->
            <div class="dash_box_body" id="business_manager_table">
                <div id="bussiness_managers" style="min-width: 210px; height: 300px; max-width: 100%;"></div>
            </div><!--dash_box_body-->
        </div><!--dash_box_block-->
		
		
		<!--Client Wise-->
        <div class="dash_box_block zoomIn animated">
            <div class="dash_box_header">
                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="dash_box_header-title">Client Wise Invoicing</h3>
                    </div>
                    <div class="col-sm-4 text-right">
                        <h4 class="dash_box_header_date"><span id="clientWiseInvoiceText"><?php echo date('M Y', strtotime($currentMonth)); ?></span> <a href="javascript:void(0);"><img id="clientWiseInvoice" src="<?php echo base_url(); ?>assets/images/calendar_icon-dash.svg" width="21"></a></h4>
                    </div>
                </div>
            </div><!--dash_box_header-->
            <div class="dash_box_body">
                <div class="client_wise_invoice" id="client_wise_invoice_table">
                    <div id="client_wise_invoice" style="min-width: 260px; max-width: 100%; height: 400px; margin: 0 auto"></div>
                    
                </div><!--client wise invoice-->
            </div><!--dash_box_body-->
        </div><!--dash_box_block-->
		
	</div><!--col-sm-6-->
	<div class="col-sm-12">
		<div class="dash_box_block zoomIn animated">
            <div class="dash_box_header">
                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="dash_box_header-title">Invoices Submitted </h3>
                    </div>
                    <div class="col-sm-4 text-right">
                        <h4 class="dash_box_header_date"><span id="monthtextInvoiceSubmitted"><?php echo date('M Y', strtotime($currentMonth)); ?></span><a href="javascript:void(0);"><img id="InvoiceSubmitted" src="<?php echo base_url(); ?>assets/images/calendar_icon-dash.svg" width="21"></a></h4>
                    </div>
                </div>
            </div><!--dash_box_header-->
            <div class="dash_box_body">
                <div class="table-theme" id="invoice_submitted_table">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Client Name </th>
                            <th>Total Amount</th>
                            <th>Status</th>
                            <th>View</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($currentMonthInvoices) && $currentMonthInvoices) :
                            foreach($currentMonthInvoices as $cmi):
                                if ($cmi->invoice_acceptance_status == 'Pending') {
                                    $status = 'Pending';
                                }else if ($cmi->invoice_acceptance_status == 'Accept') {
                                    $status = 'Invoiced';
                                } else {
                                    $status = 'Rejected';
                                }
                                $actionLink = "<a class=\"mdl-js-button mdl-js-ripple-effect btn-view action-btn\" data-upgraded=\",MaterialButton,MaterialRipple\" href=\"#InvoiceDetailModal\" data-toggle=\"modal\" data-target-id=" . $cmi->invoice_req_id . " title='View'><i class='icon-view1'></i><span class=\"mdl-button__ripple-container\"><span class=\"mdl-ripple\"></span></span></a>";
                                ?>
                                <tr>
                                    <td><?php echo $cmi->client_name; ?></td>
                                    <td><?php echo ($cmi->invoice_net_amount)? $cmi->currency_symbol." ".formatAmount($cmi->invoice_net_amount) :'--'; ?></td>
                                    <td>
                                        <?php echo $status; ?>
                                    </td>
                                    <td>
                                        <?php echo $actionLink; ?>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="4">No Record(s) Found</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div><!--dash_box_body-->
            <div class="more_result text-right">
                <a id="currentMonthInvoicesViewAll" href="<?php echo base_url();?>invoice/raised-invoices/<?php echo date('Y-m-01');?>" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" data-upgraded=",MaterialButton,MaterialRipple">View all<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a>
            </div>
        </div><!--dash_box_block-->
	</div>
    </div><!--row-->
</div><!--content-wrapper-->

<div id="InvoiceDetailModal" class="modal">
    <div class="modal-dialog modal-lg zoomIn animated">
        <div class="modal-content">
            <div class="modal-header ims_modal_header">
                <button type="button" class="close" data-dismiss="modal" aria-hidden="true">&times;</button>
                <h4 class="modal-title">Invoice Detail</h4>
            </div>
            <div class="modal-body view-details custom_scroll">

            </div><!--modal-body-->
            <!--<div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
            </div>-->
        </div>
    </div>
</div>
<?php
//echo "<pre>";
//print_r($monthlyProjections);
//print_r($allMonths);
//die;
?>
<!--Script for Actual Invoice V/s project chart-->
<script type="text/javascript">
    <?php if(isset($monthlyProjections) && $monthlyProjections || isset($monthlyActualAchieved)): ?>
    Highcharts.chart('inv_project', {
        chart: {
            type: 'spline'
        },
        title: {
            text: 'Yearly Actual Invoice V/s project Invoice',
            style: {
                display: 'none'
            }
        },
        subtitle: {
            text: '',
            style: {
                display: 'none'
            }
        },
        xAxis: {
            categories: [<?php if(isset($allMonths)) { foreach($allMonths as $key => $monthData){
                $month = date('M-Y', strtotime($monthData));
                if($key != 0) {
                    echo ", ";
                }
                echo "'$month'";
            } } ?>]
        },
        yAxis: {
            title: {
                text: 'Lacs'
            },
            labels: {
                formatter: function () {
                    return this.value + ' Lacs';
                }
            }
        },
        tooltip: {
            crosshairs: true,
            shared: true
        },
        plotOptions: {
            spline: {
                marker: {
                    radius: 4,
                    lineColor: '#666666',
                    lineWidth: 1
                },
				events: {
					legendItemClick: function () {
					   return false; 
						}
					},
            }
        },
        tooltip: {
            formatter: function() {
                return 'The <b>'+ this.series.name +'</b> is <br /> <b>' + this.y + ' Lacs</b> in <b>' + this.x + ' Month</b>';
            }
            //valueSuffix: ' Days'
        },
        legend: {
            layout: 'horizontal',
            labelFormatter: function () {
                if (this.name.indexOf("Actual") !=-1)
                {
                    temp = this.name + " ( Rs. <?php echo formatAmount($totalAchieved); ?> )";;
                    return temp;
                }
                else if(this.name.indexOf("Projected") !=-1){
                    temp = this.name + " ( Rs. <?php echo formatAmount($totalProjected); ?> )";;
                    return temp;
                } else  {
                    return this.name;
                }

            }
        },
        series: [{
            name: 'Actual Invoice',
            marker: {
                symbol: 'square'
            },
            data: [<?php if(isset($monthlyActualAchieved)) {  $c = 0 ;foreach($monthlyActualAchieved as $key => $monthData){
                //$actualAmt = $monthData->actualInvoice;
                if($c != 0) {
                    echo ", ";
                }
                echo "$monthData";
                $c++;
            }  } ?>],
            color: '#fa5172'
        }, {
            name: 'Projected Invoice',
            marker: {
                symbol: 'square'
            },
            data: [<?php if(isset($monthlyProjections)) { foreach($monthlyProjections as $key => $monthData){
                $projectedAmt = $monthData->total_revenue;
                if($key != 0) {
                    echo ", ";
                }
                echo "$projectedAmt";
            } } /*else { echo "0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00,0.00"; }*/ ?>],
            color: '#4484ff'
        }]
    });
    <?php endif; ?>
</script>

<!--Script for pie chart-->
<script type="text/javascript">
    Highcharts.setOptions({
    colors: ['#ffb508', '#11a0f8', '#f9334b', '#7460ee', '#52c5b9', '#7ace4c']
});
Highcharts.chart('actual_invoice', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Stream Wise Actual Invoice',
        style: {
            display: 'none'
        }
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f} Lacs</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            size:'100%',
            center:['60%', '45%'],
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '11px',
                    fontWeight: '500',
                    textOutline: 0
                },
                format: '<br>{point.percentage:.1f} Lacs',
                distance: -50,
                 filter: {
                    property: 'percentage',
                    operator: '>',
                    value: 4
                }
            },
            showInLegend: true
        }
    },
     legend: {
            enabled: true,
            floating: true,
            verticalAlign: 'xbottom',
            align:'left',
            layout: 'vertical',
            y: $(this).find('#container').height()/4, //chart.height/4
            padding: 0,
            itemMarginTop: 10,
            itemMarginBottom: 10
    },   
    series: [{
        name: 'Invoice',
        colorByPoint: true,
        data: [<?php if(isset($streamWiseTotalInvoiceForMonth)){ foreach($streamWiseTotalInvoiceForMonth as $key => $data){
            $Amt = round($data /100000, 2);
            echo "{name: '$key',y:$Amt},";
        } } ?>],
		point: {
			events: {
				legendItemClick: function () {
					return false; // <== returning false will cancel the default action
				}
			}
		},
    }]
});
</script>
<script type="text/javascript">
$(document).ready(function(){
    var month = new Array();
        month[0] = "Jan";
        month[1] = "Feb";
        month[2] = "Mar";
        month[3] = "Apr";
        month[4] = "May";
        month[5] = "Jun";
        month[6] = "Jul";
        month[7] = "Aug";
        month[8] = "Sep";
        month[9] = "Oct";
        month[10] = "Nov";
        month[11] = "Dec";
    /*ALL Calender Event*/
    var FromEndDate = new Date();

    var ActualProjectedInvoiceCal = $("#ActualProjectedInvoice").datepicker({
        autoclose: true,
        minViewMode: 2,
        format: 'M/YYYY',
        startDate: '-5y',
        endDate: FromEndDate,
    });
    /*Invoice submitted block */
    var InvoiceSubmittedCal = $("#InvoiceSubmitted").datepicker({
        autoclose: true,
        minViewMode: 1,
        format: 'M/YYYY',
        startDate: '-1y',
        endDate: FromEndDate,
    });

    /*Business manager wise invoice block */
    var businessManagerInvoiceCal = $("#businessManagerInvoice").datepicker({
        autoclose: true,
        minViewMode: 1,
        format: 'M/YYYY',
        endDate: FromEndDate,
    });

    /*Sales Person wise invoice block */
    var salesPersonInvoiceCal = $("#salesPersonInvoice").datepicker({
        autoclose: true,
        minViewMode: 1,
        format: 'M/YYYY',
        endDate: FromEndDate,
    });

	 /*Client wise invoice block */
    var clientWiseInvoiceCal = $("#clientWiseInvoice").datepicker({
        autoclose: true,
        minViewMode: 1,
        format: 'M/YYYY',
        endDate: FromEndDate,
    });
    /*stream wise invoice block */
    var streamWiseInvoiceCal = $("#streamWiseInvoice").datepicker({
        autoclose: true,
        minViewMode: 1,
        format: 'M/YYYY',
        endDate: FromEndDate,
    });

    ActualProjectedInvoiceCal.on('changeYear', function(e) {
        var mydate = e.date;
        var year = e.date.getFullYear();
        var selectedYearText = year +"-"+ (year + 1);
        $("#ActualProjectedInvoiceText").text(selectedYearText);
        var selectedMonth =  selectedYearText;
        getActualProjectedInvoice(selectedMonth);
    });

    /*Invoice submitted Block ONCHANGE */
    InvoiceSubmittedCal.on('changeMonth', function(e) {
        var mydate = e.date;
        locale = "en-us";
        //var monthName = mydate.toLocaleString(locale, { month: "short" });
        var monthName = month[mydate.getMonth()];
        var selectedMonthText = monthName +" "+ e.date.getFullYear();
        $("#monthtextInvoiceSubmitted").text(selectedMonthText);
        //var selectedMonth =  mydate.getFullYear()+"-"+(mydate.getMonth() + 1) +"-01";
        var selectedMonth =  mydate.getFullYear()+"-"+('0' + (mydate.getMonth()+1)).slice(-2) +"-01";
        $currenctURL = BASEURL + "invoice/raised-invoices/"+selectedMonth
        $("#currentMonthInvoicesViewAll").attr('href', $currenctURL);
        getInvoiceSubmitted(selectedMonth);
    });

    /*Business manager wise invoice ON change block */
    businessManagerInvoiceCal.on('changeMonth', function(e) {
        var mydate = e.date;
        locale = "en-us";
        //var monthName = mydate.toLocaleString(locale, { month: "short" });
        var monthName = month[mydate.getMonth()];
        var selectedMonthText = monthName +" "+ e.date.getFullYear();
        $("#businessManagerInvoiceText").text(selectedMonthText);
        var selectedMonth =  mydate.getFullYear()+"-"+(mydate.getMonth() + 1) +"-01";
        getbusinessManagerInvoices(selectedMonth);
    });

    /*Sales person wise invoice ON change block */
    salesPersonInvoiceCal.on('changeMonth', function(e) {
        var mydate = e.date;
        locale = "en-us";
        //var monthName = mydate.toLocaleString(locale, { month: "short" });
        var monthName = month[mydate.getMonth()];
        var selectedMonthText = monthName +" "+ e.date.getFullYear();
        $("#salesPersonInvoiceText").text(selectedMonthText);
        var selectedMonth =  mydate.getFullYear()+"-"+(mydate.getMonth() + 1) +"-01";
        getSalesPersonInvoices(selectedMonth);
    });

	  /*Client wise invoice ON change block */
    clientWiseInvoiceCal.on('changeMonth', function(e) {
        var mydate = e.date;
        locale = "en-us";
        //var monthName = mydate.toLocaleString(locale, { month: "short" });
        var monthName = month[mydate.getMonth()];
        var selectedMonthText = monthName +" "+ e.date.getFullYear();
        $("#clientWiseInvoiceText").text(selectedMonthText);
        var selectedMonth =  mydate.getFullYear()+"-"+(mydate.getMonth() + 1) +"-01";
        getClientWiseInvoices(selectedMonth);
    });
	
    /*Stream wise invoice ON change block */
    streamWiseInvoiceCal.on('changeMonth', function(e) {
        var mydate = e.date;
        locale = "en-us";
        //var monthName = mydate.toLocaleString(locale, { month: "short" });
        var monthName = month[mydate.getMonth()];
        var selectedMonthText = monthName +" "+ e.date.getFullYear();
        $("#streamWiseInvoiceText").text(selectedMonthText);
        var selectedMonth =  mydate.getFullYear()+"-"+(mydate.getMonth() + 1) +"-01";
        getStreamWiseInvoices(selectedMonth);
    });

    /*END ALL CALENDER EVENT*/


    $('[data-toggle="popover"]').popover({
        placement : 'top',
        trigger : 'hover'
    });

    $("#InvoiceDetailModal").on("show.bs.modal", function(e) {
        var modal = $(this);
        modal.find('.view-details').html("");
        var id = $(e.relatedTarget).data('target-id');
        var viewUrl = BASEURL + "invoice/invoice-detail/"+id;
        $.ajax({
            type: "GET",
            url: viewUrl,
            cache: false,
            success: function (data) {
                modal.find('.view-details').html(data);
                $(".custom_scroll").mCustomScrollbar();
            },
            error: function(err) {
                console.log(err);
            }
        });
    });

    $("#InvoiceDetailModal").on("hide.bs.modal", function() {
        $(".custom_scroll").mCustomScrollbar("destroy");
    });
});

    function getActualProjectedInvoice(year) {
        $.ajax({
            type: "POST",
            url: BASEURL + "dashboard/getActualProjectedInvoice",
            cache: false,
            data: {year: year},
            beforeSend: function () {
                // setting a timeout
                $('.loader-wrapper').show()
            },
            success: function (response) {
                if(response) {
                    //alert(response);
                    $("#ActualProjectedInvoiceGraph").html(response);
                }
                $('.loader').hide();
            },
            error: function (error) {
                $('.loader').hide();
                alert("There is an error while getting details. Please try again.");
            },
            complete: function () {
                $('.loader-wrapper').hide();
            },
        });
    }
    /*Submitted invoice AJAX*/
    function getInvoiceSubmitted(month) {
        $.ajax({
            type: "POST",
            url: BASEURL + "dashboard/getInvoiceSubmitted",
            cache: false,
            data: {month: month},
            beforeSend: function () {
                // setting a timeout
                $('.loader-wrapper').show()
            },
            success: function (response) {
                if(response) {
                    //alert(response);
                    $("#invoice_submitted_table").html(response);
                }
                $('.loader').hide();
            },
            error: function (error) {
                $('.loader').hide();
                alert("There is an error while getting details. Please try again.");
            },
            complete: function () {
                $('.loader-wrapper').hide();
            },
        });
    }

    /*Business Manager invoice AJAX*/
    function getbusinessManagerInvoices(month) {
        $.ajax({
            type: "POST",
            url: BASEURL + "dashboard/getbusinessManagerInvoices",
            cache: false,
            data: {month: month},
            beforeSend: function () {
                // setting a timeout
                $('.loader-wrapper').show()
            },
            success: function (response) {
                if(response) {
                    //alert(response);
                    $("#business_manager_table").html(response);
                }
                $('.loader').hide();
            },
            error: function (error) {
                $('.loader').hide();
                alert("There is an error while getting details. Please try again.");
            },
            complete: function () {
                $('.loader-wrapper').hide();
            },
        });
    }

    /*Sales Person invoice AJAX*/
    function getSalesPersonInvoices(month) {
        $.ajax({
            type: "POST",
            url: BASEURL + "dashboard/getSalesPersonInvoices",
            cache: false,
            data: {month: month},
            beforeSend: function () {
                // setting a timeout
                $('.loader-wrapper').show()
            },
            success: function (response) {
                if(response) {
                    //alert(response);
                    $("#sales_person_invoice_table").html(response);
                }
                $('.loader').hide();
            },
            error: function (error) {
                $('.loader').hide();
                alert("There is an error while getting details. Please try again.");
            },
            complete: function () {
                $('.loader-wrapper').hide();
            },
        });
    }

	 /*Client Wise invoice AJAX*/
    function getClientWiseInvoices(month) {
        $.ajax({
            type: "POST",
            url: BASEURL + "dashboard/getClientWiseInvoices",
            cache: false,
            data: {month: month},
            beforeSend: function () {
                // setting a timeout
                $('.loader-wrapper').show()
            },
            success: function (response) {
                if(response) {
                    //alert(response);
                    $("#client_wise_invoice_table").html(response);
                }
                $('.loader').hide();
            },
            error: function (error) {
                $('.loader').hide();
                alert("There is an error while getting details. Please try again.");
            },
            complete: function () {
                $('.loader-wrapper').hide();
            },
        });
    }
    /*Stream wise invoice AJAX*/
    function getStreamWiseInvoices(month) {
        $.ajax({
            type: "POST",
            url: BASEURL + "dashboard/getStreamWiseInvoices",
            cache: false,
            data: {month: month},
            beforeSend: function () {
                // setting a timeout
                $('.loader-wrapper').show()
            },
            success: function (response) {
                if(response) {
                    //alert(response);
                    $("#stream_wise_invoice_graph").html(response);
                }
                $('.loader').hide();
            },
            error: function (error) {
                $('.loader').hide();
                alert("There is an error while getting details. Please try again.");
            },
            complete: function () {
                $('.loader-wrapper').hide();
            },
        });
    }
</script>
<!--New Pie chart Business manager Wise Invoice-->
<script>
 Highcharts.setOptions({
    colors: ['#ffb508', '#11a0f8', '#f9334b', '#7460ee', '#52c5b9', '#7ace4c']
});
Highcharts.chart('bussiness_managers', {
    chart: {
        plotBackgroundColor: null,
        plotBorderWidth: null,
        plotShadow: false,
        type: 'pie'
    },
    title: {
        text: 'Stream Wise Actual Invoice',
        style: {
            display: 'none'
        }
    },
    tooltip: {
        pointFormat: '{series.name}: <b>{point.percentage:.1f} Lacs</b>'
    },
    plotOptions: {
        pie: {
            allowPointSelect: true,
            size:'100%',
            center:['60%', '45%'],
            cursor: 'pointer',
            dataLabels: {
                enabled: true,
                style: {
                    fontSize: '11px',
                    fontWeight: '500',
                    textOutline: 0
                },
                format: '<br>{point.percentage:.1f} Lacs',
                distance: -50,
                 filter: {
                    property: 'percentage',
                    operator: '>',
                    value: 4
                }
            },
            showInLegend: true
        }
    },
     legend: {
            enabled: true,
            floating: true,
            verticalAlign: 'xbottom',
            align:'left',
            layout: 'vertical',
            y: $(this).find('#container').height()/4, //chart.height/4
            padding: 0,
            itemMarginTop: 10,
            itemMarginBottom: 10
    },   
    series: [{
        name: 'Invoice',
        colorByPoint: true,
        data: [<?php if(isset($bManagerWiseTotalInvoicingForMonth)){ foreach($bManagerWiseTotalInvoicingForMonth as $key => $data){
            $Amt = round($data /100000, 2);
            echo "{name: '$key',y:$Amt},";
        } } ?>],
		point: {
			events: {
				legendItemClick: function () {
					return false; // <== returning false will cancel the default action
				}
			}
		},
    }]
});

/*Sales Person Wise*/
Highcharts.chart('sales_person_invoice', {
    chart: {
        type: 'bar'
    },
    title: {
        text: 'Chart',
        style: {
            display: 'none'
        },
    },
    subtitle: {
        text: 'invoice',
        style: {
            display: 'none'
        },
    },
    xAxis: {
        categories: [<?php  if($sPersonWiseTotalInvoicingForMonth) { $key = 0; foreach($sPersonWiseTotalInvoicingForMonth as $salesPerson => $invoiceAmt){
            if($key != 0) {
                echo ", ";
            }
            echo "'$salesPerson'";
            $key++;
        }}?>],
        title: {
            text: null
        }
    },
    yAxis: {
        gridLineWidth: 0,
        minorGridLineWidth: 0,
        min: 0,
        title: {
            text: null,
            align: 'high'
        },
        labels: {
            overflow: 'justify'
        },
        minorTickLength: 5
    },
    plotOptions: {
        series: {
            pointWidth: 100
        }
    },
    tooltip: {
        valueSuffix: ' Lacs'
    },
    plotOptions: {
        bar: {
            dataLabels: {
                enabled: true
            }
        }
    },
    legend: {
        enabled: false
    },
    credits: {
        enabled: false
    },
    series: [{
        name: '<?php echo date('M Y', strtotime($currentMonth)); ?>',
        //data: [107, 31, 635, 203, 250]
        data: [<?php  $colorArray = array('#ffb508', '#11a0f8', '#f9334b', '#7ace4c', '#7460ee', '#ffb508', '#11a0f8', '#f9334b', '#7ace4c', '#7460ee', '#ffb508', '#11a0f8', '#f9334b', '#7ace4c', '#7460ee','#ffb508', '#11a0f8', '#f9334b', '#7ace4c', '#7460ee', '#ffb508', '#11a0f8', '#f9334b', '#7ace4c', '#7460ee', '#ffb508', '#11a0f8', '#f9334b', '#7ace4c', '#7460ee','#ffb508', '#11a0f8', '#f9334b', '#7ace4c', '#7460ee', '#ffb508', '#11a0f8', '#f9334b', '#7ace4c', '#7460ee', '#ffb508', '#11a0f8', '#f9334b', '#7ace4c', '#7460ee');  if($sPersonWiseTotalInvoicingForMonth) { $key = 0; foreach($sPersonWiseTotalInvoicingForMonth as $salesPerson => $invoiceAmt){
            if($key != 0) {
                echo ", ";
            }
            echo "{
			x: $key,
			y:". round($invoiceAmt/100000, 2).",
			color: '$colorArray[$key]'
		}";
            $key++;
        }}?>],
        pointWidth: 10,
        dataLabels: {
            enabled: true,
            format: '{point.y:.1f} Lacs',
			style: {
				  color: '#000',
					fontSize: '12'
					//textOutline: '0'
				},
        }
    }]
});

    /*Client wise*/
    Highcharts.chart('client_wise_invoice', {
        chart: {
            type: 'bar'
        },
        title: {
            text: 'Chart',
            style: {
                display: 'none'
            },
        },
        subtitle: {
            text: 'invoice',
            style: {
                display: 'none'
            },
        },
        xAxis: {
            categories: [<?php  if($clientWiseMonthlyInvoicesReport) { $key = 0; foreach($clientWiseMonthlyInvoicesReport as $clients => $invoiceAmt){
                if($key != 0) {
                    echo ", ";
                }
                echo "'$clients'";
                $key++;
            }}?>],
            title: {
                text: null
            }
        },
        yAxis: {
            gridLineWidth: 0,
            minorGridLineWidth: 0,
            min: 0,
            title: {
                text: null,
                align: 'high'
            },
            labels: {
                overflow: 'justify'
            },
            minorTickLength: 5
        },
        plotOptions: {
            series: {
                pointWidth: 100
            }
        },
        tooltip: {
            valueSuffix: ' Lacs'
        },
        plotOptions: {
            bar: {
                dataLabels: {
                    enabled: true
                }
            }
        },
        legend: {
            enabled: false
        },
        credits: {
            enabled: false
        },
        series: [{
            name: '<?php echo date('M Y', strtotime($currentMonth)); ?>',
            //data: [107, 31, 635, 203, 250]
            data: [<?php  $colorArray = array('#ffb508', '#11a0f8', '#f9334b', '#7ace4c', '#7460ee', '#ffb508', '#11a0f8', '#f9334b', '#7ace4c', '#7460ee', '#ffb508', '#11a0f8', '#f9334b', '#7ace4c', '#7460ee','#ffb508', '#11a0f8', '#f9334b', '#7ace4c', '#7460ee', '#ffb508', '#11a0f8', '#f9334b', '#7ace4c', '#7460ee', '#ffb508', '#11a0f8', '#f9334b', '#7ace4c', '#7460ee');  if($clientWiseMonthlyInvoicesReport) { $key = 0; foreach($clientWiseMonthlyInvoicesReport as $clients => $invoiceAmt){
                if($key != 0) {
                    echo ", ";
                }
                echo "{
			x: $key,
			y:". round($invoiceAmt/100000, 2).",
			color: '$colorArray[$key]'
		}";
                $key++;
            }}?>],
            pointWidth: 10,
            dataLabels: {
                enabled: true,
                format: '{point.y:.1f} Lacs'
            }
        }]
    });
</script>