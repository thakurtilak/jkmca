<div id="client_wise_invoice" style="min-width: 310px; max-width: 800px; height: 400px; margin: 0 auto"></div>
<script>
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