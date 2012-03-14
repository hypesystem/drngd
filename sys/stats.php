<?php
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, 'http://api.drng.dk/get-stats.php?id='.$_GET['l']);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, '3');
    
    $content = trim(curl_exec($ch));
    curl_close($ch);
    
    $arr = json_decode($content, true);

    $scripts = array("lib/jquery.js","lib/highcharts.js","script/stats.js");
    $page_content = '<div class="top"><table><tr>
                        <th>Original link:</th>
                        <td id="original_link"><a href="'.$arr['original_url'].'" target="_blank">'.$arr['original_url'].'</td>
                    </tr><tr>
                        <th>Created at:</th>
                        <td id="created_at">'.date("j-m-Y H:i",$arr['created_at']).'</td>
                    </tr></table>
                    </div>
                    <div id="visits-graph" class="graph">&hellip;</div>
                    <div class="graph-row">
                        <div id="os-graph" class="graph">&hellip;</div>
                        <div id="browser-graph" class="graph">&hellip;</div>
                    </div>
                    <script type="text/javascript">$(document).ready(function(){buildCharts("'.$_GET['l'].'");});</script>';
    $page_title = 'Stats: '.$_GET['l'].'';
?>