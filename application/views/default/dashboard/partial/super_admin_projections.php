<div id="inv_project" style="width: 100%; height: 400px; margin: 0 auto"></div>
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