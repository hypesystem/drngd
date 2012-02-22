<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <title>drng</title>
        <link rel="stylesheet" type="text/css" href="style/drngd.css" />
    </head>
    <body>
        <div id="output" class="doc">
<?php
if(isset($_GET['n'])) {
    $markdown_src = "doc/".trim($_GET['n']).".markdown";
    if(file_exists($markdown_src)) {
        include_once "markdown/markdown.php";
        $file = fopen($markdown_src, "r");
        $html = Markdown(fread($file, filesize($markdown_src)));
        echo $html.'<span class="src-link"><a href="doc/'.trim($_GET['n']).'.markdown" target="_blank">[Source: '.trim($_GET['n']).'.markdown]</a></span>';
    }
    else {
        echo '<span class="red">Failure!</span> No doc corresponding to name "'.trim($_GET['n']).'" found';
    }
}
else {
    echo '<span class="red">Failure!</span> No doc name provided';
}
?>
        </div>
    </body>
</html>