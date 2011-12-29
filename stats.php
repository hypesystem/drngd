<?php include("func.php"); ?>
<?php if(verifyLinkKey($_GET['l'])): ?>
<?php
include('mysql_connect.php');
//get link
$get = mysql_query("SELECT * FROM link WHERE id='".intval($_GET['l'],36)."' LIMIT 1") or die(mysql_error());
$get = mysql_fetch_assoc($get);
$get_visits = mysql_query("SELECT * FROM link_visit WHERE link_id = '".intval($_GET['l'],36)."' ORDER BY timestamp ASC") or die(mysql_error());

$visits_day = 0;
$visits_week = 0;
$visits_month = 0;
$visits_year = 0;
$visits_total = 0;
$user_os = array();
$user_browser = array();
$known_os = array(
    "Windows" => "windows",
    "Linux" => "linux",
    "Mac" => "macintosh",
    "Other" => ""
    );
$known_browsers = array (
    "Internet Explorer" => "msie",
    "Firefox" => "firefox",
    "Netscape" => "netscape",
    "Chrome" => "chrome",
    "Konqueror" => "konqueror",
    "Opera" => "opera",
    "Safari" => "safari",
    "Mozilla" => "mozilla",
    "Other" => ""
    );
$browser;
$os;
while($calc = mysql_fetch_assoc($get_visits)) {
    //visit statistics
    $visits_total++;
    $time = time() - strtotime($calc['timestamp']);
    if($time < 31536000) {
        $visits_year++;
        if($time < 2592000) {
            $visits_month++;
            if($time < 604800) {
                $visits_week++;
                if($time < 86400) {
                    $visits_day++;
                }
            }
        }
    }
    
    //user agent statistics
    unset($browser);
    unset($os);
    $words = explode(' ',strtolower($calc['user_agent']));
    foreach($known_os as $key => $this_os) {
        foreach($words as $word) {
            if(!isset($os) && strpos($word,$this_os) !== false) {
                $os = $key;
            }
        }
    }
    foreach($known_browsers as $key => $br) {
        foreach($words as $word) {
            if(!isset($browser) && strpos($word,$br) !== false) {
                $browser = $key;
            }
        };
    }
    if(!isset($browser)) {
        if(!isset($user_browser["other"])) $user_browser["other"] = 1;
        else $user_browser["other"]++;
    }
    else {
        if(!isset($user_browser[$browser])) $user_browser[$browser] = 1;
        else $user_browser[$browser]++;
    }
    if(!isset($os)) {
        if(!isset($user_os["other"])) $user_os["other"] = 1;
        else $user_os["other"]++;
    }
    else {
        if(!isset($user_os[$os])) $user_os[$os] = 1;
        else $user_os[$os]++;
    }
}
arsort($user_os);
arsort($user_browser);
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>drng</title>
        <link rel="stylesheet" type="text/css" href="http://drng.dk/style/drngd.css" />
        <script type="text/javascript" src="http://drng.dk/script/jquery.js"></script>
        <script type="text/javascript" src="http://drng.dk/script/script.js"></script>
    </head>
    <body>
        <div id="stats-head">
            <a href="http://drng.dk"><img src="http://drng.dk/style/logo.png" alt="deranged" title="deranged" /></a>
            <p>Statistics for <a href="http://drng.dk/<?php echo $_GET['l']; ?>" target="_blank">drng.dk/<?php echo $_GET['l']; ?></a></p>
        </div>
        <br />
        <div id="output" class="stats">
            <table>
                <thead>
                    <tr>
                        <th colspan="2">General information</th>
                        <th colspan="2">Browser and OS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2">
                            This section contains general information about the link.
                            <table class="data" id="info-data">
                                <thead>
                                    <tr>
                                        <th colspan="2">Link information</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td class="key">Created on:</td>
                                        <td class="value"><?php echo date("j/n Y h:i",strtotime($get['timestamp'])); ?></td>
                                    </tr>
                                    <tr>
                                        <td class="key">Links to:</td>
                                        <td class="value"><a href="<?php echo $get['href']; ?>" target="_blank"><?php echo $get['href']; ?></a></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                        <td colspan="2">
                            The following are statistics regarding operating system and browser for people visiting this link.<br/>
                            <table class="data" id="browser-data">
                                <thead>
                                    <tr>
                                        <th colspan="2">Browser</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($user_browser as $key => $val): ?>
                                    <tr>
                                        <td class="key"><?php echo $key; ?>:</td>
                                        <td class="value"><?php echo number_format(100 * $val / $visits_total,1); ?>% (<?php echo $val; ?>)</td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                            <table class="data" id="os-data">
                                <thead>
                                    <tr>
                                        <th colspan="2">Operating System</th>
                                    </tr>
                                </thead>
                                <tbody>
                                <?php foreach($user_os as $key => $val): ?>
                                    <tr>
                                        <td class="key"><?php echo $key; ?>:</td>
                                        <td class="value"><?php echo (100 * $val / $visits_total); ?>% (<?php echo $val; ?>)</td>
                                    </tr>
                                <?php endforeach; ?>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            <table>
                <thead>
                    <tr>
                        <th colspan="2">Visits/time</th>
                        <td colspan="2"></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2">The statistics show how popular the link is.
                            <table class="data" id="visits-data">
                                <thead>
                                    <tr>
                                        <th colspan="2">Visits</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <tr>
                                        <td>Last day:</td>
                                        <td><?php echo $visits_day; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Last week:</td>
                                        <td><?php echo $visits_week; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Last month:</td>
                                        <td><?php echo $visits_month; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Last year:</td>
                                        <td><?php echo $visits_year; ?></td>
                                    </tr>
                                    <tr>
                                        <td>Total visits:</td>
                                        <td><?php echo $visits_total; ?></td>
                                    </tr>
                                </tbody>
                            </table>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>
        <div class="version-box">version 1.0.0.<?php include("version.log"); ?></div>
    </body>
</html>
<?php else: ?>
<?php header("Location: index.php"); ?>
<?php endif; ?>
