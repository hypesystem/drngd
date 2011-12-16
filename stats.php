<?php if(isset($_GET['l'])): ?>
<?php
include('mysql_connect.php');
//get link
$get = mysql_query("SELECT * FROM link WHERE id='".intval($_GET['l'],36)."' LIMIT 1") or die(mysql_error());
$get = mysql_fetch_assoc($get);
$get_visits = mysql_query("SELECT * FROM link_visit WHERE link_id = '".intval($_GET['l'])."' ORDER BY timestamp ASC") or die(mysql_error());
while($calc = mysql_fetch_assoc($get_visits)) {
    echo 'lawl';
}
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
        <div id="stats-head">
            <img src="style/logo.png" alt="deranged" title="deranged" />
            <p>Statistics for <a href="http://drng.dk/<?php echo $_GET['l']; ?>" target="_blank">drng.dk/<?php echo $_GET['l']; ?></a></p>
        </div>
        <br />
        <div id="output" class="stats">
            <table>
                <thead>
                    <tr>
                        <th colspan="2">General information</th>
                        <th colspan="2">Browser and OS</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>Links to:</td>
                        <td><a href="<?php echo $get['href']; ?>" target="_blank"><?php echo $get['href']; ?></a></td>
                        <td rowspan="4" colspan="2">
                            The following are statistics regarding operating system and browser for people visiting this link.
                        </td>
                    </tr>
                    <tr>
                        <td>Created:</td>
                        <td><?php echo date("j/n Y h:i",strtotime($get['timestamp'])); ?></td>
                    </tr>
                </tbody>
                <thead>
                    <tr>
                        <th colspan="2">Visits/time</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td colspan="2">The statistics show how popular the link is.</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </body>
</html>
<?php else: ?>

<?php endif; ?>
