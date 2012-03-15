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

        $os_table = '<table class="data">';
        foreach($arr['os'] as $os) $os_table .= '<tr><td>'.$os[0].'</td><td class="num">'.$os[1].'</td></tr>';
        $os_table .= '</table>';

        $browser_table = '<table class="data">';
        foreach($arr['browsers'] as $browser) $browser_table .= '<tr><td>'.$browser[0].'</td><td class="num">'.$browser[1].'</td></tr>';
        $browser_table .= '</table>';

        $page_content = '<div class="top"><table><tr>
                            <th>Original link:</th>
                            <td id="original_link"><a href="'.$arr['original_url'].'" target="_blank">'.$arr['original_url'].'</td>
                        </tr><tr>
                            <th>Created at:</th>
                            <td id="created_at">'.date("j-m-Y H:i",$arr['created_at']).'</td>
                        </tr><tr>
                            <th>Total visits:</th>
                            <td id="total_visits">'.$arr['visits_total'].'</td>
                        </tr></table>
                        </div>
                        <div id="visits-graph" class="graph"><table class="data">
                            <tr><td>Visits last day:</td><td class="num">'.$arr['visits_day'].'</td></tr>
                            <tr><td>Visits last week:</td><td class="num">'.$arr['visits_week'].'</td></tr>
                            <tr><td>Visits last month:</td><td class="num">'.$arr['visits_month'].'</td></tr>
                            <tr><td>Visits last year:</td><td class="num">'.$arr['visits_year'].'</td></tr>
                        </table></div>
                        <div class="graph-row">
                            <div id="os-graph" class="graph">'.$os_table.'</div>
                            <div id="browser-graph" class="graph">'.$browser_table.'</div>
                        </div>
                        <script type="text/javascript">$(document).ready(function(){buildCharts("'.$_GET['l'].'");});</script>';
    }
    else $page_content .= ' '.(isset($arr['error']) ? $arr['error'] : "Could not connect to server.").'.';
    
    $page_title = 'Stats: '.$_GET['l'].'';
?>