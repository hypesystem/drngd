<?php
if(isset($_GET['n'])) {
    $markdown_src = "doc/".trim($_GET['n']).".markdown";
    if(file_exists($markdown_src)) {
        include_once "markdown/markdown.php";
        $file = fopen($markdown_src, "r");
        $html = Markdown(fread($file, filesize($markdown_src)));
        echo $html.'<span class="src-link">View Markdown source ('.trim($_GET['n']).'.markdown)</span>';
    }
    else {
        echo '<span class="red">Failure!</span> No doc corresponding to name "'.trim($_GET['n']).'" found';
    }
}
else {
    echo '<span class="red">Filure!</span> No doc name provided';
}
?>