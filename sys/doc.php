<?php
$page_content = "";
if(isset($_GET['n'])) {
    $markdown_src = "doc/".trim($_GET['n']).".markdown";
    if(file_exists($markdown_src)) {
        $scripts = array("http://yandex.st/highlightjs/6.1/highlight.min.js");
        $stylesheets = array("http://yandex.st/highlightjs/6.1/styles/ir_black.min.css");
        include_once "lib/markdown.php";
        $file = fopen($markdown_src, "r");
        $html = Markdown(fread($file, filesize($markdown_src)));
        $page_content = $html.'<script type="text/javascript">hljs.tabReplace = "    "; hljs.initHighlightingOnLoad();</script><div class="src-link"><a href="doc/'.trim($_GET['n']).'.markdown" target="_blank">[Source: '.trim($_GET['n']).'.markdown]</a></div>';
        $page_title = trim($_GET['n']);
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