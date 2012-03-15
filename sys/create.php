<?php
    $scripts = array("lib/jquery.js","lib/zeroclipboard/ZeroClipboard.js","script/create.js");
    $page_content = '   <form method="post" action=".">
                            <input type="text" name="url" value="http://url" class="inactive" id="url-input" />
                            <input type="submit" value="Shorten link" id="url-submit" />
                        </form>
                        <div id="output"></div>';
    $page_title = 'Shorten link';
?>