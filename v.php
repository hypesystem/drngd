<?php
if(isset($_GET['v']) && intval($_GET['v'],36) > 0) {
    $id = intval($_GET['v'],36);
    include('mysql_connect.php');
    $url = mysql_query("SELECT * FROM link WHERE id='$_GET[v]'");
    $url = mysql_fetch_assoc($url);
    mysql_query("INSERT INTO link_visit (link_id,user_agent,ip,timestamp) VALUES ('".$id."','".addslashes($_SERVER['HTTP_USER_AGENT'])."','".addslashes($_SERVER['REMOTE_ADDR'])."','".date("Y-m-d H:i:s")."')") or die(mysql_error());
    if(!isset($url['href']) || $url['href'] == "") $url['href'] = "index.php";
    header('Location: '.$url['href']);
}
else {
    header('Location: index.php');
}
?>
