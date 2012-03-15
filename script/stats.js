var browserChart, osChart, visitsChart;
function buildCharts(link_id) {
    $(".graph").css("display","inline-block");
    $.getJSON("api/get-stats.php", {id: link_id}, function(statsData) {
        if(statsData.success) {

            //visits data generation
            var createdDate = new Date();
            createdDate.setTime(statsData.created_at * 1000);
            var startDate = new Date();
            startDate.setTime(createdDate.getTime() - (createdDate.getTime() % 86400000));
            var endDate = new Date();
            endDate.setTime(endDate.getTime() - (endDate.getTime() % 86400000));

            function reformatDate(dateString) {
                dArr = dateString.split("-");
                var newDate = new Date();
                newDate.setMonth(dArr[1].valueOf() - 1, dArr[2]);
                newDate.setYear(dArr[0]);
                return newDate;
            }

            var visitsData = new Array();
            var days = 1 + ((endDate.getTime() - startDate.getTime()) / 86400000);
            for(var i = 0; i < days; i++) visitsData.push(0);
            for(var i = 0; i < statsData.visits.length; i++) {
                var thisDate = reformatDate(statsData.visits[i][0]);
                var day = Math.floor((thisDate.getTime() - startDate.getTime()) / 86400000);
                visitsData[day] = statsData.visits[i][1];
            }

            var pie_tt = {formatter: function() {return '<b>'+ this.point.name +'</b>: '+ this.percentage.toFixed(1) +'% ('+ this.y +')';}}
            var pie_plot = {pie: {allowPointSelect: true, cursor: 'pointer',
                                dataLabels: {enabled: true, color: '#FFFFFF', connectorColor: '#999',
                                    formatter: function() {return this.point.name;}
                                }
                            }
                        }
            
            //make browser pie 
            browserChart = new Highcharts.Chart({
                chart: {
                    renderTo: 'browser-graph',
                    backgroundColor: '#1a1a1a'
                },
                title: {
                    text: 'Browsers used by visitors'
                },
                tooltip: pie_tt,
                plotOptions: pie_plot,
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
                tooltip: pie_tt,
                plotOptions: pie_plot,
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
}

$(document).ready(function() {
    var visits_data_html = $('#visits-dataset .data').html();
    var browser_data_html = $('#browser-dataset .data').html();
    var os_data_html = $('#os-dataset .data').html();
    
    $('#visits-dataset .data, #browser-dataset .data, #os-dataset .data').text("see data").css("font-size","12px").css("cursor","pointer").css("text-decoration","underline");
    
    $('#visits-dataset .data, #browser-dataset .data, #os-dataset .data').click(function() {
        if($(this).text() == "see data") {
            $(this).slideUp("fast");
            $(this).css("font-size","16px").css("text-decoration","none");
            switch($(this).parent().attr("id")) {
                case("visits-dataset"):
                    $(this).html(visits_data_html);
                    break;
                case("os-dataset"):
                    $(this).html(os_data_html);
                    break;
                case("browser-dataset"):
                    $(this).html(browser_data_html);
                    break;
            }
        }
        else {
            $(this).slideUp("fast").text("see data").css("font-size","12px").css("cursor","pointer").css("text-decoration","underline");
        }
        $(this).slideDown("fast");
    });
});