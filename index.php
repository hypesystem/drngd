<?php
include("func.php");
if(verifyLinkKey($_GET['v'])) {
    $id = intval($_GET['v'],36);
    include('mysql_connect.php');
    mysql_query("INSERT INTO link_visit (link_id,user_agent,ip,timestamp) VALUES ('".$id."','".addslashes($_SERVER['HTTP_USER_AGENT'])."','".addslashes($_SERVER['REMOTE_ADDR'])."','".date("Y-m-d H:i:s")."')") or die(mysql_error());
    $url = mysql_query("SELECT * FROM link WHERE id='".intval($_GET[v],36)."'") or die(mysql_error());
    $url = mysql_fetch_assoc($url) or die(mysql_error());
    if(!isset($url['href']) || $url['href'] == "") $url['href'] = "index.php";
    header('Location: '.$url['href']);
}
else {
?>
<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8" />
    <base href="http://drng.dk/" />
    <title>drng</title>
    <link rel="stylesheet" type="text/css" href="style/drngd.css" />
    <script type="text/javascript" src="script/jquery.js"></script>
    <script type="text/javascript" src="script/create.js"></script>
    <script type="text/javascript" src="clip/ZeroClipboard.js"></script>
    <script type="text/javascript">
        ZeroClipboard.setMoviePath( 'clip/ZeroClipboard.swf' );
        var copyLink = new ZeroClipboard.Client();
    </script>
</head>
<body>
    <div id="create-link">
        <a href="http://drng.dk"><img src="style/logo.png" alt="deranged" title="deranged" /></a>
        <input type="text" name="url" value="http://url" class="inactive" />
        <input type="submit" value="Shorten link" />
    </div>
    <br />
    <div id="output" class="create">

    </div>
    <div class="version-box">version 1.1.0.<?php include("version.log"); ?></div>
</body>
</html>
<?php } ?>