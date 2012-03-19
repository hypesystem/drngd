<?php
    $page_content = 'No link could be found to display stats for.';

    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, 'http://api.drng.dk/get-stats.php?id='.$_GET['l']);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, '3');
    
    $content = trim(curl_exec($ch));
    curl_close($ch);
    
    $arr = json_decode($content, true);
    
    if($arr['success']) {
        $scripts = array("lib/jquery.js","lib/highcharts.js","script/stats.js");

        $os_table = '<table><tr><th colspan="2">Operating systems</th></tr>';
        foreach($arr['os'] as $os) $os_table .= '<tr><td>'.$os[0].'</td><td class="num">'.$os[1].'</td></tr>';
        $os_table .= '</table>';

        $browser_table = '<table><tr><th colspan="2">Browsers</th></tr>';
        foreach($arr['browsers'] as $browser) $browser_table .= '<tr><td>'.$browser[0].'</td><td class="num">'.$browser[1].'</td></tr>';
        $browser_table .= '</table>';

        $page_content = '<div class="top"><table><tr>
                            <th>Original link:</th>
                            <td id="original_link"><a href="'.$arr['link'].'" title="'.$arr['original_url'].'" target="_blank">'.(strlen($arr['original_url']) > 30 ? substr($arr['original_url'],0,28)."&hellip;" : $arr['original_url']).'</a></td>
                        </tr><tr>
                            <th>Created at:</th>
                            <td id="created_at">'.date("j-m-Y H:i",$arr['created_at']).'</td>
                        </tr><tr>
                            <th>Total visits:</th>
                            <td id="total_visits">'.$arr['visits_total'].'</td>
                        </tr></table>
                        </div>
                        <div class="dataset" id="visits-dataset">
                            <div id="visits-graph" class="graph"></div>
                            <div class="data"><table><tr><th colspan="2">Visits over time</th></tr>
                                <tr><td>Visits last day:</td><td class="num">'.$arr['visits_day'].'</td></tr>
                                <tr><td>Visits last week:</td><td class="num">'.$arr['visits_week'].'</td></tr>
                                <tr><td>Visits last month:</td><td class="num">'.$arr['visits_month'].'</td></tr>
                                <tr><td>Visits last year:</td><td class="num">'.$arr['visits_year'].'</td></tr>
                            </table></div>
                        </div>
                        <div class="dataset" id="os-dataset">
                            <div id="os-graph" class="graph"></div>
                            <div class="data">'.$os_table.'</div>
                        </div>
                        <div class="dataset" id="browser-dataset">
                            <div id="browser-graph" class="graph"></div>
                            <div class="data">'.$browser_table.'</div>
                        </div>
                        <script type="text/javascript">$(document).ready(function(){buildCharts("'.$_GET['l'].'");});</script>
                        <div pub-key="pub-80743985-ff70-4d32-969c-d68b7e92b2d9" sub-key="sub-9e516238-2685-11e1-b204-671e781827dd" ssl="off" origin="pubsub.pubnub.com" id="pubnub"></div>
                        <script type="text/javascript" src="http://cdn.pubnub.com/pubnub-3.1.min.js"></script>
                        <script type="text/javascript">
                        (function(){
                            PUBNUB.subscribe({
                                channel : "'.trim($_GET['l']).'",
                                restore : false,
                                callback : function(message) {
                                    visitsChart.series[0].data[visitsChart.series[0].data.length - 1].y++;
                                    visitsChart.redraw();
                                    $("#total_visits").text(parseInt($("#total_visits").text()) + 1);
                                    $("#visits-dataset table .num").each(function() {
                                        $(this).text(parseInt($(this).text()) + 1);
                                    });
                                    
                                    var browserAdded = false;
                                    for(var z = 0; z < browserChart.series[0].data.length; z++) {
                                        if(browserChart.series[0].data[z].name == message.browser) {
                                            browserChart.series[0].data[z].y++;
                                            browserChart.render();
                                            browserAdded = true;
                                        }
                                    }
                                    if(!browserAdded) browserChart.series[0].addPoint({name: message.browser, y: 1},true);
                                    
                                    var osAdded = false;
                                    for(var z = 0; z < osChart.series[0].data.length; z++) {
                                        if(osChart.series[0].data[z].name == message.os) {
                                            osChart.series[0].data[z].y++;
                                            osChart.render();
                                            osAdded = true;
                                        }
                                    }
                                    if(!osAdded) osChart.series[0].addPoint({name: message.os, y: 1},true);
                                    
                                    //add to data tables
                                    var browserDataAdded = false;
                                    $("#browser-dataset table td:not(.num)").each(function() {
                                        if($(this).text() == message.browser) {
                                            var val = parseInt($(this).parent().find(".num").text()) + 1;
                                            $(this).parent().find(".num").text(val);
                                            var element = $(this).parent().prev();
                                            if(parseInt(element.find(".num").text()) < val) {
                                                while(val > parseInt(element.find(".num").text())) {
                                                    element = element.prev();
                                                }
                                                var this_html = $(this).parent().html();
                                                element.after("<tr>"+this_html+"</tr>");
                                                $(this).parent().remove();
                                            }
                                            browserDataAdded = true;
                                            return false;
                                        }
                                    });
                                    if(!browserDataAdded) {
                                        $("#browser-dataset tbody").html($("#browser-dataset tbody").html()+\'<tr><td>\'+message.browser+\'</td><td class="num">1</td></tr>\');
                                    }
                                    
                                    var osDataAdded = false;
                                    $("#os-dataset table td:not(.num)").each(function() {
                                        if($(this).text() == message.os) {
                                            var val = parseInt($(this).parent().find(".num").text()) + 1;
                                            $(this).parent().find(".num").text(val);
                                            var element = $(this).parent().prev();
                                            if(parseInt(element.find(".num").text()) < val) {
                                                while(val > parseInt(element.find(".num").text())) {
                                                    element = element.prev();
                                                }
                                                var this_html = $(this).parent().html();
                                                element.after("<tr>"+this_html+"</tr>");
                                                $(this).parent().remove();
                                            }
                                            osDataAdded = true;
                                            return false;
                                        }
                                    });
                                    if(!osDataAdded) {
                                        $("#os-dataset tbody").html($("#os-dataset tbody").html()+\'<tr><td>\'+message.os+\'</td><td class="num">1</td></tr>\');
                                    }
                                }
                            });
                        })();
                        </script>';
    }
    else $page_content .= ' '.(isset($arr['error']) ? $arr['error'] : "Could not connect to server.").'.';
    
    $page_title = 'Stats: '.$_GET['l'].'';
?>
