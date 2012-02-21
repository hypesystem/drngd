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
                    
                    if(statsData.success) {
                    
                        //visits data generation
                        var startDate = new Date();
                        startDate.setTime(statsData.created_at * 1000);
                        var endDate = new Date();
                        
                        function reformatDate(dateString) {
                            dArr = dateString.split("-");
                            var newDate = new Date();
                            newDate.setMonth(dArr[1].valueOf() - 1, dArr[2]);
                            newDate.setYear(dArr[0]);
                            return newDate;
                        }
                        
                        var visitsData = new Array();
                        var days = (endDate.getTime() - startDate.getTime()) / 86400000;
                        for(var i = 0; i < days; i++) visitsData.push(0);
                        for(var i = 0; i < statsData.visits.length; i++) {
                            var thisDate = reformatDate(statsData.visits[i][0]);
                            var day = Math.floor((thisDate.getTime() - startDate.getTime()) / 86400000);
                            visitsData[day] = statsData.visits[i][1];
                        }
                        
                        //set standard information
                        $("#original_link").html('<a href="'+statsData.link+'" target="_blank">'+statsData.original_url+'</a>');
                        $("#created_at").html(startDate.getDate()+"-"+(startDate.getMonth() + 1)+"-"+startDate.getFullYear());


                        //make browser pie 
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

                        //make os pie
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

                        //make visitors overview
                        visitsChart = new Highcharts.Chart({
                            chart: {
                                renderTo: 'visits-graph',
                                zoomType: 'x',
                                backgroundColor: "#1a1a1a"
                            },
                            title: {
                                text: 'Visits over time'
                            },
                            subtitle: {
                                text: 'Click and drag to zoom in'
                            },
                            xAxis: {
                                type: 'datetime',
                                maxZoom: 14*24*3600000, //seven days
                                title: {
                                    text: null
                                }
                            },
                            yAxis: {
                                title: {
                                    text: 'Visits'
                                },
                                min: 0,
                                startOnTick: false,
                                showFirstLabel: true
                            },
                            tooltip: {
                                shared: true
                            },
                            legend: {
                                enabled: false
                            },
                            plotOptions: {
                                area: {
                                    marker: {
                                        enabled: false,
                                        states: {
                                            hover: {
                                                enabled: true,
                                                radius: 5
                                            }
                                        }
                                    },
                                    shadow: false
                                }
                            },
                            series: [{
                                    type: 'area',
                                    name: 'Visits',
                                    pointInterval: 24*3600*1000, //one day
                                    pointStart: Date.UTC(startDate.getFullYear(),startDate.getMonth(),startDate.getDate()),
                                    data: visitsData
                            }]
                        });
                    }
                    else {
                        $("#output").html('<span class="red">Error fetching data!</span> '+statsData.error+'.');
                        $("#output").css('text-align','center');
                    }
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
        <div class="version-box">version 1.1.0.<?php include("version.log"); ?></div>
    </body>
</html>