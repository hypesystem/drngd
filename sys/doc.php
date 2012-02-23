<?php
$page_content = "";
if(isset($_GET['n'])) {
    $markdown_src = "doc/".trim($_GET['n']).".markdown";
    if(file_exists($markdown_src)) {
        include_once "lib/markdown.php";
        $file = fopen($markdown_src, "r");
        $html = Markdown(fread($file, filesize($markdown_src)));
        $page_content = $html.'<div class="src-link"><a href="doc/'.trim($_GET['n']).'.markdown" target="_blank">[Source: '.trim($_GET['n']).'.markdown]</a></div>';
        $page_title = 'doc: '.trim($_GET['n']);
    }
    else {
        $page_content = '<span class="red">Failure!</span> No doc corresponding to name "'.trim($_GET['n']).'" found';
        $page_title = 'Error: doc not found';
    }
}
else {
    $page_content = '<span class="red">Failure!</span> No doc name provided';
    $page_title = 'Error: no doc name provided';
}
?>