<?php
    $scripts = array("lib/jquery.js","lib/highcharts.js","script/stats.js");
    $page_content = '<div class="top"><table><tr>
                        <th>Original link:</th>
                        <td id="original_link">&hellip;</td>
                    </tr><tr>
                        <th>Created at:</th>
                        <td id="created_at">&hellip;</td>
                    </tr></table>
                    </div>
                    <div id="visits-graph" class="graph">&hellip;</div>
                    <div class="graph-row">
                        <div id="os-graph" class="graph">&hellip;</div>
                        <div id="browser-graph" class="graph">&hellip;</div>
                    </div>
                    <script type="text/javascript">$(document).ready(function(){buildCharts("'.$_GET['l'].'");});</script>
                    <div pub-key="pub-80743985-ff70-4d32-969c-d68b7e92b2d9" sub-key="sub-9e516238-2685-11e1-b204-671e781827dd" ssl="off" origin="pubsub.pubnub.com" id="pubnub"></div>
                    <script src="http://cdn.pubnub.com/pubnub-3.1.min.js"></script>
                    <script>(function(){
                        PUBNUB.subscribe({
                            channel    : "'.trim($_GET['l']).'",
                            restore    : false,
                            callback   : function(message) {
                                var data_val = visitsChart.series[0].data[visitsChart.series[0].data.length - 1].y;
                                visitsChart.series[0].data[visitsChart.series[0].data.length - 1].update({y: data_val + 1});
                            }
                        });
                    })();</script>';
    $page_title = 'Stats: '.$_GET['l'].'';
?>