<?php
if(!isset($_GET['url']) || $_GET['url'] == "" || $_GET['url'] == "http://url") {
    echo json_encode(array('success' => false, 'error' => 'No url supplied'));
}
else {
    $match;
    if(preg_match('#^(ftp|http|https)\:\/\/[aA-zZ0-9.-]+\.[aA-zZ]+#',$_GET['url'])) {
        $match = $_GET['url'];
    }
    else if(preg_match("#^www\.[aA-zZ0-9.-]+\.[aA-zZ]+#",$_GET['url'])) {
        $match = "http://".$_GET['url'];
    }
    else {
        echo json_encode(array('success' => false, 'error' => 'Url supplied is invalid. Most likely missing prefix (http:// or www.)'));
    }
    
    if(isset($match)) {
        include_once '../sys/mysql_connect.php';
        mysql_query("INSERT INTO link (href,timestamp) VALUES ('".addslashes($match)."','".date("Y-m-d H:i:s")."')") or die(mysql_error());
        $get = mysql_query("SELECT * FROM link WHERE href='".addslashes($match)."' ORDER BY id DESC") or die(mysql_error());
        $get = mysql_fetch_assoc($get);
        echo json_encode(array('success' => true, 'id' => base_convert($get['id'],10,36),'link' => 'http://drng.dk/'.base_convert($get['id'],10,36)));
    }
}
?>
