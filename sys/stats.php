<?php
    $scripts = array("lib/jquery.js","lib/highcharts.js","script/stats.js");
    $page_content = '<div class="top"><table><tr>
                        <th>Original link:</th>
                        <td id="original_link"></td>
                    </tr><tr>
                        <th>Created at:</th>
                        <td id="created_at"></td>
                    </tr></table>
                    </div>
                    <div id="visits-graph" class="graph"></div>
                    <div class="graph-row">
                        <div id="os-graph" class="graph"></div>
                        <div id="browser-graph" class="graph"></div>
                    </div>
                    <script type="text/javascript">$(document).ready(function(){buildCharts('.$_GET['l'].');});</script>';
    $page_title = 'Stats: '.$_GET['l'].'';
?>