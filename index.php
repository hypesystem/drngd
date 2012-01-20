<?php
    if(isset($_GET['v'])):
        header("Location: ".$_GET['v']);
    else:
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <base href="http://drng.dk/" />
        <title>drng</title>
        <link rel="stylesheet" type="text/css" href="style/drngd.css" />
        <script type="text/javascript" src="script/jquery.js"></script>
        <script type="text/javascript" src="script/script.js"></script>
        <script type="text/javascript" src="clip/ZeroClipboard.js"></script>
        <script type="text/javascript">
            ZeroClipboard.setMoviePath( 'clip/ZeroClipboard.swf' );
            var copyLink = new ZeroClipboard.Client();
        </script>
    </head>
    <body>
        <div id="create-link">
            <a style="width:150px;height:92px;vertical-align:middle;text-align:center;background-color:#000;position:absolute;z-index:5555;top:53px;left:360px;background-image:url(http://americancensorship.org/images/stop-censorship-small.png);background-position:center center;background-repeat:no-repeat;" href="http://americancensorship.org"></a>
            <a href="http://drng.dk"><img src="style/logo.png" alt="deranged" title="deranged" /></a>
            <input type="text" name="url" value="http://url" class="inactive" />
            <input type="submit" value="Shorten link" />
        </div>
        <br />
        <div id="output" class="create">
            
        </div>
        <div class="version-box">version 1.0.1.<?php include("version.log"); ?></div>
    </body>
</html>
<?php endif; ?>