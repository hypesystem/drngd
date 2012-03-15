<?php
$page_content = "";
if(isset($_GET['n'])) {
    
    $markdown_src = "doc/".trim($_GET['n']).".markdown";
    if(file_exists($markdown_src)) {
        
        $scripts = array();
        $stylesheets = array();
        
        include_once "lib/markdown.php";
        $file = fopen($markdown_src, "r");
        $page_content = Markdown(fread($file, filesize($markdown_src)));
        
        if(strpos($page_content,"<code>") > 0) {
            $stylesheets[] = "lib/ir_black.min.css";
            $scripts[] = "lib/highlight.min.js";
            $page_content .= '<script type="text/javascript">hljs.tabReplace = "    "; hljs.initHighlightingOnLoad();</script><div class="src-link"><a href="doc/'.trim($_GET['n']).'.markdown" target="_blank">[Source: '.trim($_GET['n']).'.markdown]</a></div>';
        }
        $page_title = ucwords(str_replace("-"," ",trim($_GET['n'])));
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