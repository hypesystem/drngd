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

?>
