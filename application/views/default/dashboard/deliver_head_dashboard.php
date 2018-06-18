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
    <div class="row mm0">
        <div class="col-sm-12 mp0">
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
                            <h4><i class="fa fa-inr" aria-hidden="true"></i> <?php echo formatAmount($totalProjected);?></h4>
                        </div>
                    </div>
                </div><!--rev_block_flex-->
            </div><!--revenue_block-->
        </div><!--col-sm-12-->
    <?php if(isset($approvalPendingInvoices)): ?>
        <div class="row">
            <div class="col-sm-12">
                <div class="dash_box_block fadeInLeft animated">
                    <div class="dash_box_header">
                        <div class="row">
                            <div class="col-sm-8">
                                <h3 class="dash_box_header-title">Pending Invoices for Approval</h3>
                            </div>
                            <div class="more_result text-right">
                                <a href="<?php echo base_url(); ?>dashboard/approve-pending" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" data-upgraded=",MaterialButton,MaterialRipple">View all<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a>
                            </div>
                        </div>
                    </div><!--dash_box_header-->
                    <div class="dash_box_body">
                        <div class="table-theme table-responsive">
                            <table class="table">
                                <thead>
                                <tr>
                                    <th>Request Date</th>
                                    <th>Requestor Name</th>
                                    <th>Client Name</th>
                                    <th>Activity Name</th>
                                    <th>Net Amount</th>
                                    <!--<th>PO Number</th>-->
                                    <th>Action</th>
                                </tr>
                                </thead>
                                <tbody>
                                <?php if(count($approvalPendingInvoices)):
                                    foreach($approvalPendingInvoices as $invoice): ?>
                                        <tr>
                                            <td><?php echo date('d-M-Y', strtotime($invoice->invoice_originate_date)); ?></td>
                                            <td><?php echo $invoice->requestorName; ?></td>
                                            <td><?php echo $invoice->client_name; ?></td>
                                            <td><?php echo $invoice->project_name; ?></td>
                                            <td><?php echo $invoice->currency_symbol . ' ' . formatAmount($invoice->invoice_net_amount); ?></td>
                                           <!-- <td><?php /*echo $invoice->po_no; */?></td>-->
                                            <td>
                                                <a class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" href="#PendingInvoiceDetailModal" data-toggle="modal" data-target-id="<?php echo $invoice->invoice_req_id; ?>" title="View"><i class='icon-view1'></i></a>
                                            </td>
                                        </tr>
                                    <?php endforeach; else: ?>
                                    <tr>
                                        <td colspan="7">No pending invoices</td>
                                    </tr>
                                <?php endif; ?>
                                </tbody>
                            </table>
                        </div>
                    </div><!--dash_box_body-->
                </div><!--dash_box_block-->
            </div><!--col-sm-12-->
        </div>
    <?php endif; ?>
    <?php if(isset($monthlyProjections) && $monthlyProjections || isset($monthlyActualAchieved)): ?>
    <div class="row">
        <div class="col-sm-12">
            <div class="dash_box_block fadeInUp animated">
                <div class="dash_box_header">
                    <div class="row">
                        <div class="col-sm-6">
                            <h3 class="dash_box_header-title">Actual Invoice v/s Projected Invoice</h3>
                        </div>
                        <div class="col-sm-6 text-right">
                            <h4 class="dash_box_header_date"><span id="ActualProjectedInvoiceText"><?php echo $currentFinancialYear; ?></span> <img id="ActualProjectedInvoice" src="<?php echo base_url();?>assets/images/calendar_icon-dash.svg" width="21"></h4>
                        </div>
                    </div>
                </div><!--dash_box_header-->
                <div class="dash_box_body" id="ActualProjectedInvoiceGraph">
                    <div id="inv_project" style="width: 100%; height: 400px; margin: 0 auto"></div>
                </div><!--dash_box_body-->
            </div><!--dash_box_block-->
        </div><!--col-sm-12-->
    </div>
    <?php endif; ?>
    <div class="row">
    <div class="col-sm-6">
        <div class="dash_box_block fadeInLeft animated">
            <div class="dash_box_header">
                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="dash_box_header-title">Current Month Invoices</h3>
                    </div>
                    <div class="col-sm-4 text-right">
                        <h4 class="dash_box_header_date"><span id="currentMonthInvoicesText"><?php echo date('M Y', strtotime($currentMonth)); ?></span><a href="javascript:void(0);"><img id="currentMonthInvoices" src="<?php echo base_url(); ?>assets/images/calendar_icon-dash.svg" width="21"></a></h4>
                    </div>
                </div>
            </div><!--dash_box_header-->
            <div class="dash_box_body">
                <div class="table-theme" id="currentMonthInvoicesTable">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Client Name </th>
                                <th>Invoice No.</th>
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
                                        <td><?php echo ($cmi->invoice_no)? $cmi->invoice_no :'--'; ?></td>
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
				<div class="more_result text-right">
					<a id="currentMonthInvoicesViewAll" href="<?php echo base_url();?>invoice/raised-invoices/<?php echo date('Y-m-01');?>" class="mdl-js-button mdl-js-ripple-effect btn-view action-btn" data-upgraded=",MaterialButton,MaterialRipple">View all<span class="mdl-button__ripple-container"><span class="mdl-ripple"></span></span></a>
				</div>
            </div><!--dash_box_body-->
        </div><!--dash_box_block-->
        <div class="dash_box_block fadeInRight animated">
            <div class="dash_box_header">
                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="dash_box_header-title">Project Wise Invoicing</h3>
                    </div>
                    <div class="col-sm-4 text-right">
                        <h4 class="dash_box_header_date"><span id="assignedProjectsText"><?php echo $currentFinancialYear; ?></span><a href="javascript:void(0);"><img id="assignedProjects" src="<?php echo base_url(); ?>assets/images/calendar_icon-dash.svg" width="21"></a></h4>
                    </div>
                </div>
            </div><!--dash_box_header-->
            <div class="dash_box_body">
                <div class="table-theme" id="assignedProjectsTable">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Project Name </th>
                            <th>Total Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($projectsWithTotalInvoice) && $projectsWithTotalInvoice) :
                            foreach($projectsWithTotalInvoice as $clientInvoice): ?>
                                <tr>
                                    <td><?php echo $clientInvoice->project_name; ?></td>
                                    <td><?php echo $clientInvoice->currency_symbol." ".formatAmount($clientInvoice->totalInvoice); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No Record(s) Found</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div><!--dash_box_body-->
        </div><!--dash_box_block-->

    </div><!--col-sm-6-->
    <div class="col-sm-6">
        <div class="dash_box_block fadeInRight animated">
            <div class="dash_box_header">
                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="dash_box_header-title">Client Wise Invoicing</h3>
                    </div>
                    <div class="col-sm-4 text-right">
                        <h4 class="dash_box_header_date"><span id="clientsWithTotalInvoiceText"><?php echo date('M Y', strtotime($currentMonth)); ?></span><a href="javascript:void(0);"><img id="clientsWithTotalInvoice" src="<?php echo base_url(); ?>assets/images/calendar_icon-dash.svg" width="21"></a></h4>
                    </div>
                </div>
            </div><!--dash_box_header-->
            <div class="dash_box_body">
                <div class="table-theme" id="clientsWithTotalInvoiceTable">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Client Name </th>
                            <th>Total Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($clientWiseMonthlyInvoices) && $clientWiseMonthlyInvoices) :
                            foreach($clientWiseMonthlyInvoices as $clientName => $clientInvoice): ?>
                                <tr>
                                    <td><?php echo $clientName; ?></td>
                                    <td><?php echo "Rs. ". formatAmount($clientInvoice); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No Record(s) Found</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div><!--dash_box_body-->
        </div><!--dash_box_block-->
        <div class="dash_box_block fadeInRight animated">
            <div class="dash_box_header">
                <div class="row">
                    <div class="col-sm-8">
                        <h3 class="dash_box_header-title">Sales Person Wise Invoicing</h3>
                    </div>
                    <div class="col-sm-4 text-right">
                        <h4 class="dash_box_header_date"><span id="salesPersonWithTotalInvoiceText"><?php echo date('M Y', strtotime($currentMonth)); ?></span><a href="javascript:void(0);"><img id="salesPersonWithTotalInvoice" src="<?php echo base_url(); ?>assets/images/calendar_icon-dash.svg" width="21"></a></h4>
                    </div>
                </div>
            </div><!--dash_box_header-->
            <div class="dash_box_body">
                <div class="table-theme" id="salesPersonWithTotalInvoiceTable">
                    <table class="table">
                        <thead>
                        <tr>
                            <th>Name </th>
                            <th>Total Amount</th>
                        </tr>
                        </thead>
                        <tbody>
                        <?php if(isset($sPersonWiseTotalInvoicingForMonth) && $sPersonWiseTotalInvoicingForMonth) :
                            foreach($sPersonWiseTotalInvoicingForMonth as $name => $totalInvoice): ?>
                                <tr>
                                    <td><?php echo $name; ?></td>
                                    <td><?php echo "Rs. ". formatAmount($totalInvoice); ?></td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="3">No Record(s) Found</td>
                            </tr>
                        <?php endif; ?>
                        </tbody>
                    </table>
                </div>
            </div><!--dash_box_body-->
        </div><!--dash_box_block-->
    </div><!--col-sm-6-->


    </div><!--row-->
</div><!--content-wrapper-->

<!-- View Modal-->
<div id="PendingInvoiceDetailModal" class="modal">
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

<script type="text/javascript">
    $(document).ready(function(){

        /*ALL Calender Event*/
        var FromEndDate = new Date();

        var ActualProjectedInvoiceCal = $("#ActualProjectedInvoice").datepicker({
            autoclose: true,
            minViewMode: 2,
            format: 'M/YYYY',
            startDate: '-5y',
            endDate: FromEndDate,
        });
        /*Current Month invoice block */
        var currentMonthInvoicesCal = $("#currentMonthInvoices").datepicker({
            autoclose: true,
            minViewMode: 1,
            format: 'M/YYYY',
            startDate: '-1y',
            endDate: FromEndDate,
        });


        /*Assigned Projects block */
        var assignedProjectsCal = $("#assignedProjects").datepicker({
            autoclose: true,
            minViewMode: 2,
            format: 'M/YYYY',
            startDate: '-5y',
            endDate: FromEndDate,
        });

        /*Client with total invoice*/
        var clientsWithTotalInvoiceCal = $("#clientsWithTotalInvoice").datepicker({
            autoclose: true,
            minViewMode: 1,
            format: 'M/YYYY',
            startDate: '-1y',
            endDate: FromEndDate,
        });

        /*Sales person with total invoice*/
        var salesPersonWithTotalInvoiceCal = $("#salesPersonWithTotalInvoice").datepicker({
            autoclose: true,
            minViewMode: 1,
            format: 'M/YYYY',
            startDate: '-1y',
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

        /*Current Month invoice block ONCHANGE */
        currentMonthInvoicesCal.on('changeMonth', function(e) {
            var mydate = e.date;
            locale = "en-us";
            var monthName = mydate.toLocaleString(locale, { month: "short" });
            var selectedMonthText = monthName +" "+ e.date.getFullYear();
            $("#currentMonthInvoicesText").text(selectedMonthText);
            var selectedMonth =  mydate.getFullYear()+"-"+('0' + (mydate.getMonth()+1)).slice(-2) +"-01";
            $currenctURL = BASEURL + "invoice/raised-invoices/"+selectedMonth
            $("#currentMonthInvoicesViewAll").attr('href', $currenctURL);

            getCurrentMonthInvoices(selectedMonth);
        });

        assignedProjectsCal.on('changeYear', function(e) {
            var mydate = e.date;
            var year = e.date.getFullYear();
            var selectedYearText = year +"-"+ (year + 1);
            $("#assignedProjectsText").text(selectedYearText);
            var selectedMonth =  selectedYearText;
            getAssignedProjects(selectedMonth);
        });

        /*Client with total invoice ONCHANGE */
        clientsWithTotalInvoiceCal.on('changeMonth', function(e) {
            var mydate = e.date;
            locale = "en-us";
            var monthName = mydate.toLocaleString(locale, { month: "short" });
            var selectedMonthText = monthName +" "+ e.date.getFullYear();
            $("#clientsWithTotalInvoiceText").text(selectedMonthText);
            var selectedMonth =  mydate.getFullYear()+"-"+('0' + (mydate.getMonth()+1)).slice(-2) +"-01";
            getClientsWithTotalInvoice(selectedMonth);
        });

        /*Sales person wise total invoice block ONCHANGE */
        salesPersonWithTotalInvoiceCal.on('changeMonth', function(e) {
            var mydate = e.date;
            locale = "en-us";
            var monthName = mydate.toLocaleString(locale, { month: "short" });
            var selectedMonthText = monthName +" "+ e.date.getFullYear();
            $("#salesPersonWithTotalInvoiceText").text(selectedMonthText);
            var selectedMonth =  mydate.getFullYear()+"-"+('0' + (mydate.getMonth()+1)).slice(-2) +"-01";
            getSalesPersonWithTotalInvoice(selectedMonth);
        });

        $("#PendingInvoiceDetailModal").on("show.bs.modal", function(e) {
            var modal = $(this);
            modal.find('.view-details').html("");
            var id = $(e.relatedTarget).data('target-id');
            var viewUrl = BASEURL + "invoice/invoice-detail/"+id;
            $.ajax({
                type: "GET",
                url: viewUrl,
                data:{type:"pendingInvoice"},
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

        $("#PendingInvoiceDetailModal").on("hide.bs.modal", function() {
            $(".custom_scroll").mCustomScrollbar("destroy");
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
</script>



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
        } } ?>],
        color: '#4484ff'
    }]
});
    <?php endif; ?>

    function getActualProjectedInvoice(year) {
        $.ajax({
            type: "POST",
            url: BASEURL + "dashboard/getDeliveryHeadActualProjectedInvoice",
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

    /*Current Month wise invoice AJAX*/
    function getCurrentMonthInvoices(month) {
        $.ajax({
            type: "POST",
            url: BASEURL + "dashboard/getCurrentMonthInvoices",
            cache: false,
            data: {month: month},
            beforeSend: function () {
                // setting a timeout
                $('.loader-wrapper').show()
            },
            success: function (response) {
                if(response) {
                    //alert(response);
                    $("#currentMonthInvoicesTable").html(response);
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


    /*Client wise invoice AJAX*/
    function getClientsWithTotalInvoice(month) {
        $.ajax({
            type: "POST",
            url: BASEURL + "dashboard/getClientsWithTotalInvoice",
            cache: false,
            data: {month: month},
            beforeSend: function () {
                // setting a timeout
                $('.loader-wrapper').show()
            },
            success: function (response) {
                if(response) {
                    //alert(response);
                    $("#clientsWithTotalInvoiceTable").html(response);
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

    getSalesPersonWithTotalInvoice
    /*Sales person wise total invoice AJAX*/
    function getSalesPersonWithTotalInvoice(month) {
        $.ajax({
            type: "POST",
            url: BASEURL + "dashboard/getSalesPersonWithTotalInvoice",
            cache: false,
            data: {month: month},
            beforeSend: function () {
                // setting a timeout
                $('.loader-wrapper').show()
            },
            success: function (response) {
                if(response) {
                    //alert(response);
                    $("#salesPersonWithTotalInvoiceTable").html(response);
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

    /*Assigned Projects invoice AJAX*/
    function getAssignedProjects(year) {
        $.ajax({
            type: "POST",
            url: BASEURL + "dashboard/getAssignedProjects",
            cache: false,
            data: {year: year},
            beforeSend: function () {
                // setting a timeout
                $('.loader-wrapper').show()
            },
            success: function (response) {
                if(response) {
                    //alert(response);
                    $("#assignedProjectsTable").html(response);
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