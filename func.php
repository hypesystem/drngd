<?php

function verifyLinkKey($key) {
    if(!isset($key) || $key == "" || !preg_match("/^[0-9a-z]+/",$key)) return false;
    include("mysql_connect.php");
    $key = intval(trim(strtolower($key)), 36);
    $get = mysql_query("SELECT * FROM link WHERE id='{$key}' LIMIT 1") or die(mysql_error());
    $get = mysql_fetch_assoc($get) or die(mysql_error());
    if(isset($get['href'])) return true;
    return false;
}

/**
 * Bash script to save commit # hashtag to version.log:
 * git describe --all --long | tr "-" " " | awk '{ print $3 }' > version.log
 */

?>
