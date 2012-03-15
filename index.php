<?php
include("sys/func.php");
if(verifyLinkKey($_GET['v'])) {
    $id = intval($_GET['v'],36);
    include('mysql_connect.php');
    mysql_query("INSERT INTO link_visit (link_id,user_agent,ip,timestamp) VALUES ('".$id."','".addslashes($_SERVER['HTTP_USER_AGENT'])."','".addslashes($_SERVER['REMOTE_ADDR'])."','".date("Y-m-d H:i:s")."')") or die(mysql_error());
    $url = mysql_query("SELECT * FROM link WHERE id='".intval($_GET[v],36)."'") or die(mysql_error());
    $url = mysql_fetch_assoc($url) or die(mysql_error());
    if(!isset($url['href']) || $url['href'] == "") $url['href'] = "index.php";
    
    include_once "lib/Pubnub.php";
    $pubnub = new Pubnub("pub-80743985-ff70-4d32-969c-d68b7e92b2d9","sub-9e516238-2685-11e1-b204-671e781827dd");
    $pubnub->publish(array(
        'channel' => trim($_GET['v']),
        'message' => array('ip' => "127.0.0.1", 'browser' => "Firefox", 'os' => "Windows")
    ));
    
    header('Location: '.$url['href']);
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