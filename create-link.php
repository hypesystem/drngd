<?php
if(!isset($_GET['url']) || $_GET['url'] == "" || $_GET['url'] == "http://url") {
    echo '<span class="red">Error!</span> No url passed.';
}
else {
    $match;
    if(preg_match('#http\:\/\/[aA-zZ0-9\.]+#',$_GET['url'])) {
        $match = $_GET['url'];
    }
    else if(preg_match("#www\.[aA-zZ0-9\.]+#",$_GET['url'])) {
        $match = "http://".$_GET['url'];
    }
    else {
        echo '<span class="red">Error!</span> Entered address is not valid url.';
    }
    
    if(isset($match)) {
        include('mysql_connect.php');
        mysql_query("INSERT INTO link (href,timestamp) VALUES ('".addslashes($match)."','".date("Y-m-d H:i:s")."')") or die(mysql_error());
        $get = mysql_query("SELECT * FROM link WHERE href='".addslashes($_GET['url'])."' ORDER BY id DESC") or die(mysql_error());
        $get = mysql_fetch_assoc($get);
        echo '<span class="green">Success!</span> Your short link is: <a href="http://drng.dk/'.base_convert($get['id'],10,36).'" target="_blank">drng.dk/'.base_convert($get['id'],10,36).'</a><br />';
        echo 'To track and view statistics for your link, see <a href="http://drng.dk/stats.php?l='.base_convert($get['id'],10,36).'">http://drng.dk/stats.php?l='.base_convert($get['id'],10,36).'</a>';
    }
}
?>
