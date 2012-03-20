<?php

function verifyLinkKey($key) {
    if(!isset($key) || $key == "" || !preg_match("/^[0-9a-z]+/",$key)) return false;
    include_once "sys/mysql_connect.php";
    include_once "../sys/mysql_connect.php";
    $key = intval(trim(strtolower($key)), 36);
    $get = mysql_query("SELECT * FROM link WHERE id='{$key}' LIMIT 1") or die(mysql_error());
    if(mysql_num_rows($get) != false && mysql_num_rows($get) > 0) {
        $get = mysql_fetch_assoc($get) or die(mysql_error());
        if(isset($get['href'])) return true;
    }
    return false;
}

function getBrowserFromUserAgent($userAgent) {
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
    foreach($known_browsers as $key => $name) {
        if(preg_match("@".$key."@",strtolower($userAgent))) { return $name; }
    }
    return "Other";
}

function getOSFromUserAgent($userAgent) {
    $known_os = array(
        "windows" => "Windows",
        "linux" => "Linux",
        "macintosh" => "Mac",
        " " => "Other"
    );
    foreach($known_os as $key => $name) {
        if(preg_match("@".$key."@",strtolower($userAgent))) { return $name; }
    }
    return "Other";
}

?>
