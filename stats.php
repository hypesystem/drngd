<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <!--<base href="http://drng.dk/" />-->
        <title>drng</title>
        <link rel="stylesheet" type="text/css" href="style/drngd.css" />
        <script type="text/javascript" src="script/jquery.js"></script>
        <script type="text/javascript" src="script/highcharts.js"></script>
        <script type="text/javascript">
            var browserChart, osChart, visitsChart;
            $(document).ready(function() {
                $.getJSON("get-stats.php", {id: "<?php echo $_GET['l']; ?>"}, function(statsData) {
                    
                    $("#original_link").html('<a href="'+statsData.link+'" target="_blank">'+statsData.original_url+'</a>');
                    $("#created_at").html(statsData.created_at);
                    
                    browserChart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'browser-graph',
                            backgroundColor: '#1a1a1a'
                        },
                        title: {
                            text: 'Browsers used by visitors'
                        },
                        tooltip: {
                            formatter: function() { return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(1) +'% ('+ this.y +')'; }
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    color: '#FFFFFF',
                                    connectorColor: '#AAAAAA',
                                    formatter: function() {
                                        return this.point.name;
                                    }
                                }
                            }
                        },
                        series: [{
                            type: 'pie',
                            name: 'Browser share',
                            data: statsData.browsers
                        }]
                    });

                    osChart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'os-graph',
                            backgroundColor: '#1a1a1a'
                        },
                        title: {
                            text: 'Operating systems used by visitors'
                        },
                        tooltip: {
                            formatter: function() { return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(1) +'% ('+ this.y +')'; }
                        },
                        plotOptions: {
                            pie: {
                                allowPointSelect: true,
                                cursor: 'pointer',
                                dataLabels: {
                                    enabled: true,
                                    color: '#FFFFFF',
                                    connectorColor: '#AAAAAA',
                                    formatter: function() {
                                        return this.point.name;
                                    }
                                }
                            }
                        },
                        series: [{
                            type: 'pie',
                            name: 'OS share',
                            data: statsData.os
                        }]
                    });

                    visitsChart = new Highcharts.Chart({
                        chart: {
                            renderTo: 'visits-graph',
                            defaultSeriesType: 'line',
                            backgroundColor: '#1a1a1a'
                        },
                        title: {
                            text: 'Visitors over time'
                        },
                        xAxis: {
                            categories: statsData.visits
                        },
                        yAxis: {
                            title: {
                                text: 'Visitors'
                            },
                            plotLines: [{
                                    value: 0,
                                    width: 1,
                                    color: '#444444'
                            }]
                        },
                        legend: {
                            enabled: false
                        },
                        tooltip: {
                            formatter: function() {
                                return this.x +': <b>'+ this.y +' visitors</b>';
                            }
                        },
                        series: [{
                                data: statsData.visits
                        }]
                    });
                });
            });
        </script>
    </head>
    <body>
        <div id="stats-head">
            <a href="http://drng.dk"><img src="style/logo.png" alt="deranged" title="deranged" /></a>
            <p>Statistics for <a href="http://drng.dk/<?php echo $_GET['l']; ?>" target="_blank">drng.dk/<?php echo $_GET['l']; ?></a></p>
        </div>
        <br />
        <div id="output" class="stats">
            <div class="top">
                <table>
                    <tr>
                        <th>Original link:</th>
                        <td id="original_link"></td>
                    </tr>
                    <tr>
                        <th>Created at:</th>
                        <td id="created_at"></td>
                    </tr>
                </table>
            </div>
            <div id="visits-graph" class="graph"></div>
            <div class="graph-row">
                <div id="os-graph" class="graph"></div>
                <div id="browser-graph" class="graph"></div>
            </div>
        </div>
        <div class="version-box">version 1.0.1.<?php include("version.log"); ?></div>
    </body>
</html>