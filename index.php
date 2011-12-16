<?php
    if(isset($_GET['v'])):
        header("Location: v.php?v=".$_GET['v']);
    else:
?>
<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>drng</title>
        <link rel="stylesheet" type="text/css" href="style/drngd.css" />
        <script type="text/javascript" src="script/jquery.js"></script>
        <script type="text/javascript" src="script/script.js"></script>
    </head>
    <body>
        <div id="create-link">
            <img src="style/logo.png" alt="deranged" title="deranged" />
            <input type="text" name="url" value="http://url" class="inactive" />
            <input type="submit" value="Shorten link" />
        </div>
        <br />
        <div id="output" class="create">
            
        </div>
    </body>
</html>
<?php endif; ?>