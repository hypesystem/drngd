<?php
include("func.php");
if(verifyLinkKey($_GET['id'])) {
    include('mysql_connect.php');
    //get link
    $get = mysql_query("SELECT * FROM link WHERE id='".intval($_GET['id'],36)."' LIMIT 1") or die(mysql_error());
    $get = mysql_fetch_assoc($get);
    $get_visits = mysql_query("SELECT * FROM link_visit WHERE link_id = '".intval($_GET['id'],36)."' ORDER BY timestamp ASC") or die(mysql_error());
    
    $visits = array();
    $visits_day = 0;
    $visits_week = 0;
    $visits_month = 0;
    $visits_year = 0;
    $visits_total = 0;
    $user_os = array();
    $user_os[] = array();
    $user_browser = array();
    $user_browser[] = array();
    $data_os = array();
    $data_browser = array();
    $data_visits = array();
    $known_os = array(
        "windows" => "Windows",
        "linux" => "Linux",
        "macintosh" => "Mac",
        " " => "Other"
    );
    $known_browsers = array(
        "msie" => "Internet Explorer",
        "firefox" => "Firefox",
        "netscape" => "Netscape",
        "chrome" => "Chrome",
        "konqueror" => "Konqueror",
        "opera" => "Opera",
        "safari" => "Safari",
        "mozilla" => "Mozilla",
        " " => "Other"
    );
    $browser;
    $os;
    while($calc = mysql_fetch_assoc($get_visits)) {
        //visit statistics
        $visits_total++;
        $time = time() - strtotime($calc['timestamp']);
        $tmp_date = date('Y-m-d',strtotime($calc['timestamp']));
        if(!isset($visits[$tmp_date])) $visits[$tmp_date] = 1;
        else $visits[$tmp_date]++;
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
        
        foreach($known_os as $key => $name) {
            if(preg_match("@".$key."@",strtolower($calc['user_agent']))) { $os = $key; break; }
        }
        foreach($known_browsers as $key => $name) {
            if(preg_match("@".$key."@",strtolower($calc['user_agent']))) { $browser = $key; break; }
        }

        if(!isset($user_browser[$browser])) {
            $user_browser[$browser][0] = $known_browsers[$browser];
            $user_browser[$browser][1] = 1;
        }
        else $user_browser[$browser][1]++;

        if(!isset($user_os[$os])) {
            $user_os[$os][0] = $known_os[$os];
            $user_os[$os][1] = 1;
        }
        else $user_os[$os][1]++;
    }
    
    function compare_amount($a, $b) { return $a[1] < $b[1]; }
    usort($user_os,compare_amount);
    usort($user_browser,compare_amount);
    
    foreach($user_browser as $k => $b) {
        if($b[0] != null) $data_browser[] = $b;
    }

    foreach($user_os as $k => $o) {
        if($o[0] != null) $data_os[] = $o;
    }
    
    foreach($visits as $k => $v) {
        $data_visits[] = array($k,$v);
    }
    
    echo json_encode(array('success' => true, 'link' => 'http://drng.dk/'.$_GET['id'], 'created_at' => date("j. M Y h:i",strtotime($get['timestamp'])), 'original_url' => $get['href'], 'visits_day' => $visits_day, 'visits_week' => $visits_week, 'visits_month' => $visits_month, 'visits_year' => $visits_year, 'visits_total' => $visits_total, 'visits' => $data_visits, 'browsers' => $data_browser, 'os' => $data_os));
}
else {
    echo json_encode(array('success' => false, 'error' => 'Invalid link id given'));
}
?>