<?php
if(!isset($_GET['false']))
    setcookie("force-pc",true);
else
    setcookie("force-pc",false);
header('Location: .');
?>