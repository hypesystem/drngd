<?php
    $output = '';
    
    if(isset($_POST['url'])) {
        $ch = curl_init();
        
        curl_setopt($ch, CURLOPT_URL, 'http://api.drng.dk/create-link.php?url='.trim($_POST['url']));
        
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, '3');
        
        $content = trim(curl_exec($ch));
        curl_close($ch);
        
        $arr = json_decode($content, true);
        
        if($arr['success']) {
            $output = ' <span class="green">Success!</span> Your short link is: <a href="'.$arr['link'].'" target="_blank">drng.dk/'.$arr['id'].'</a><br />
                        To track and view statistics for your link, see <a href="http://drng.dk/!stats/'.$arr['id'].'">drng.dk/!stats/'.$arr['id'].'</a>';
        }
        else {
            $output = ' <span class="red">Failure!</span> '.$arr['error'].'.';
        }
    }
    
    $scripts = array("lib/jquery.js","lib/zeroclipboard/ZeroClipboard.js","script/create.js");
    $page_content = '   <form method="post" action=".">
                            <input type="text" name="url" value="http://url" class="inactive" id="url-input" />
                            <input type="submit" value="Shorten link" id="url-submit" />
                        </form>
                        <div id="output">'.$output.'</div>';
    $page_title = 'Shorten link';
?>