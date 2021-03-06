<div id="actual_invoice" style="min-width: 210px; height: 300px; max-width: 100%;"></div>
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
                        fontSize: '14px',
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
            data: [<?php foreach($streamWiseTotalInvoiceForMonth as $key => $data){
                $Amt = round($data /100000, 2);
                echo "{name: '$key',y:$Amt},";
            } ?>]
        }]
    });
</script>