<?php include("func.php"); ?>
<?php if(true || verifyLinkKey($_GET['l'])): ?>
<?php
include('mysql_connect.php');
//get link
$get = mysql_query("SELECT * FROM link WHERE id='".intval($_GET['l'],36)."' LIMIT 1") or die(mysql_error());
$get = mysql_fetch_assoc($get);
$get_visits = mysql_query("SELECT * FROM link_visit WHERE link_id = '".intval($_GET['l'])."' ORDER BY timestamp ASC") or die(mysql_error());

$visits_day = 0;
$visits_week = 0;
$visits_month = 0;
$visits_year = 0;
$visits_total = 0;
$user_os = array();
$user_browser = array();
$known_os = array( "windows", "linux", "macintosh", "msie");
$known_browsers = array ( "firefox" , "netscape", "mozilla", "chrome", "konqueror", "opera", "safari" );
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
    $browser;
    $os;
    $words = explode(' ',strtolower($calc['user_agent']));
    foreach($known_os as $this_os) {
        foreach($words as $word) {
            if(!isset($os) && strpos($word,$this_os) !== false) {
                $os = $this_os;
            }
        }
    }
    foreach($known_browsers as $br) {
        foreach($words as $word) {
            if(!isset($browser) && strpos($word,$br) !== false) {
                $browser = $br;
            }
        }
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
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>drng</title>
        <link rel="stylesheet" type="text/css" href="style/drngd.css" />
        <script type="text/javascript" src="script/jquery.js"></script>
        <script type="text/javascript" src="script/script.js"></script>
    </head>
    <body>
        <div id="stats-head">
            <img src="style/logo.png" alt="deranged" title="deranged" />
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
                        <td>Links to:</td>
                        <td><a href="<?php echo $get['href']; ?>" target="_blank"><?php echo $get['href']; ?></a></td>
                        <td rowspan="9" colspan="2">
                            The following are statistics regarding operating system and browser for people visiting this link.<br/>
                            <table>
                            <?php foreach($user_browser as $key => $val): ?>
                                <tr><td><?php echo ucfirst($key); ?>:</td><td><?php echo $val; ?></td></tr>
                            <?php endforeach; ?>
                            </table>
                            <table>
                            <?php foreach($user_os as $key => $val): ?>
                                <tr><td><?php echo ucfirst($key); ?>:</td><td><?php echo $val; ?></td></tr>
                            <?php endforeach; ?>
                            </table>
                        </td>
                    </tr>
                    <tr>
                        <td>Created:</td>
                        <td><?php echo date("j/n Y h:i",strtotime($get['timestamp'])); ?></td>
                    </tr>
                </tbody>
                <thead>
                    <tr>
                        <th colspan="2">Visits/time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2">The statistics show how popular the link is.</td>
                    </tr>
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
        </div>
    </body>
</html>
<?php else: ?>
<?php header("Location: index.php"); ?>
<?php endif; ?>
