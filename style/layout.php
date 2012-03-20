<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0' name='viewport' />
        <link rel="shortcut icon" type="image/png" href="style/imgs/fav.png" />
        <base href="http://test.drng.dk/" />
        <title><?php echo $page_title; ?> | drng.dk</title>
        <link rel="stylesheet" <?php if(!isset($_COOKIE['force-pc']) || !$_COOKIE['force-pc']) echo 'media="Screen and (min-device-width: 720px)"'; ?> type="text/css" href="style/drngd.css" />
        <?php if(!isset($_COOKIE['force-pc']) || !$_COOKIE['force-pc']) echo '<link rel="stylesheet" media="handheld, only screen and (max-device-width: 719px)" type="text/css" href="style/mobile.css" />'; ?>
        <?php foreach($stylesheets as $s): ?>
            <link rel="stylesheet" type="text/css" href="<?php echo $s; ?>"></script>
        <?php endforeach; ?>
        <?php foreach($scripts as $s): ?>
            <script type="text/javascript" src="<?php echo $s; ?>"></script>
        <?php endforeach; ?>
    </head>
    <body>
        <div id="bar">
            <div id="bar-content">
                <nav id="bar-menu">
                    <a href=".">+New</a>
                    <a href="!doc/why-use-it">About</a>
                    <a href="!doc/api-documentation">API</a>
                </nav>
                <div id="version">
                    <a href="http://github.com/hypesystem/drngd" target="_blank">
                        1.2.4.<?php if(file_exists("sys/version.log")) include("sys/version.log"); else echo "null"; ?>
                    </a>
                </div>
            </div>
        </div>
        <div id="container" class="<?php echo trim($_GET['s']); ?>">
            <?php echo $page_content; ?>
        </div>
        <div id="pc-version-link"><a href="!force-pc">Go to the PC version of the website.</a></div>
    </body>
</html>