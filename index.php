<?php
include("sys/func.php");
if(verifyLinkKey($_GET['v'])) {
    $id = intval($_GET['v'],36);
    include('mysql_connect.php');
    mysql_query("INSERT INTO link_visit (link_id,user_agent,ip,timestamp) VALUES ('".$id."','".addslashes($_SERVER['HTTP_USER_AGENT'])."','".addslashes($_SERVER['REMOTE_ADDR'])."','".date("Y-m-d H:i:s")."')") or die(mysql_error());
    $url = mysql_query("SELECT * FROM link WHERE id='".intval($_GET[v],36)."'") or die(mysql_error());
    $url = mysql_fetch_assoc($url) or die(mysql_error());
    if(!isset($url['href']) || $url['href'] == "") $url['href'] = "index.php";
    header('Location: '.$url['href']);
}
else if(isset($_GET['v'])) {
    header("Location: !e404");
}
else {
    if(!isset($_GET['s'])) $_GET['s'] = 'create';
    if(file_exists("sys/".trim($_GET['s']).".php")) include_once "sys/".trim($_GET['s']).".php";
    else {
        $page_content = '<span class="red">Failure!</span> Module requested does not exist ('.trim($_GET['s'].')');
        $page_title = 'Error: Module not found';
    }
    include_once "style/layout.php";
} ?>