<!DOCTYPE html>
<html>
    <head>
        <meta charset="utf-8" />
        <!--<base href="http://drng.dk/" />-->
        <title><?php echo $page_title; ?> | drng.dk</title>
        <link rel="stylesheet" type="text/css" href="style/drngd.css" />
    </head>
    <body>
        <div id="bar">
            <div id="bar-content">
                <nav id="bar-menu">
                    <a href=".">Create</a>
                    <a href="!doc/why-use-it">Why use it?</a>
                </nav>
                <div id="version">
                    <a href="http://github.com/hypesystem/drngd" target="_blank">
                        1.1.0.<?php if(file_exists("version.log")) include("version.log"); else echo "null"; ?>
                    </a>
                </div>
            </div>
        </div>
        <div id="output" class="<?php echo isset($page_class) ? $page_class : "doc"; ?>">
            <?php echo $page_content; /*Following is generic content*/ ?>
            <h1>Why use it?</h1>

            <ol>
            <li><p><strong>No redundant features.</strong> drng.dk is free and simple to use. It takes one
            input an has one button. <a href="http://drng.dk">Get started.</a></p></li>
            <li><p><strong>Simple statistics overview.</strong> Quickly grasp who visits your link and in
            what periods of time your link has been the most popular with easy-to-read
            graphs. <a href="http://drng.dk/!stats/1">View example.</a></p></li>
            <li><p><strong>Open API.</strong> The service is accessible through an easy and open API,
            allowing other systems to easily integrate drng.dk and use it to monitor
            link popularity. Additionally the statistics are easily integrated in any
            system. <a href="http://drng.dk/!doc/api-documentation">Read about the API.</a></p></li>

            <li><p><strong>Free and open-source.</strong> In addition to being actively developed, the
            source-code for the project is publicly availible and easy to fork through
            it's home at GitHub.
            <a href="http://github.com/hypesystem/drngd">See the source code.</a></p></li>
            </ol>
            <span class="src-link"><a href="doc/why-use-it.markdown">Get Markdown source (why-use-it.markdown)</a></span>
        </div>
    </body>
</html>