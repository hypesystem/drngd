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
            if(!isset($user_browser["Other"])) $user_browser["Other"] = 1;
            else $user_browser["Other"]++;
        }
        else {
            if(!isset($user_browser[$browser])) $user_browser[$browser] = 1;
            else $user_browser[$browser]++;
        }
        if(!isset($os)) {
            if(!isset($user_os["Other"])) $user_os["Other"] = 1;
            else $user_os["Other"]++;
        }
        else {
            if(!isset($user_os[$os])) $user_os[$os] = 1;
            else $user_os[$os]++;
        }
    }
    arsort($user_os);
    arsort($user_browser);
    echo json_encode(array('success' => true, 'link' => 'http://drng.dk/'.$_GET['id'], 'created_at' => date("j. M Y h:i",strtotime($get['timestamp'])), 'original_url' => $get['href'], 'visits_day' => $visits_day, 'visits_week' => $visits_week, 'visits_month' => $visits_month, 'visits_year' => $visits_year, 'visits_total' => $visits_total, 'visits' => $visits, 'browsers' => $user_browser, 'os' => $user_os));
}
else {
    echo json_encode(array('success' => false, 'error' => 'Invalid link id given'));
}
?>