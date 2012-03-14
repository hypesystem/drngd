<?php
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, 'http://api.drng.dk/get-stats.php?id='.$_GET['l']);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, '3');
    
    $content = trim(curl_exec($ch));
    curl_close($ch);
    
    $arr = json_decode($content, true);

    $scripts = array("lib/jquery.js","lib/highcharts.js","script/stats.js");
    
    $os_table = '<table>';
    foreach($arr['os'] as $os) $os_table .= '<tr><td>'.$os[0].'</td><td>'.$os[1].'</td></tr>';
    $os_table .= '</table>';
    
    $browser_table = '<table>';
    foreach($arr['browsers'] as $browser) $browser_table .= '<tr><td>'.$browser[0].'</td><td>'.$browser[1].'</td></tr>';
    $browser_table .= '</table>';
    
    $page_content = '<div class="top"><table><tr>
                        <th>Original link:</th>
                        <td id="original_link"><a href="'.$arr['original_url'].'" target="_blank">'.$arr['original_url'].'</td>
                    </tr><tr>
                        <th>Created at:</th>
                        <td id="created_at">'.date("j-m-Y H:i",$arr['created_at']).'</td>
                    </tr></table>
                    </div>
                    <div id="visits-graph" class="graph"><table>
                        <tr><td>Visits last day:</td><td>'.$arr['visits_day'].'</td></tr>
                        <tr><td>Visits last week:</td><td>'.$arr['visits_week'].'</td></tr>
                        <tr><td>Visits last month:</td><td>'.$arr['visits_month'].'</td></tr>
                        <tr><td>Visits last year:</td><td>'.$arr['visits_year'].'</td></tr>
                        <tr><td>Visits total:</td><td>'.$arr['visits_total'].'</td></tr>
                    </table></div>
                    <div class="graph-row">
                        <div id="os-graph" class="graph">'.$os_table.'</div>
                        <div id="browser-graph" class="graph">'.$browser_table.'</div>
                    </div>
                    <script type="text/javascript">$(document).ready(function(){buildCharts("'.$_GET['l'].'");});</script>';
    $page_title = 'Stats: '.$_GET['l'].'';
?>