<?php
    $page_title = "Error ".trim($_GET['e']);
    $page_content = '<h1>Error '.trim($_GET['e']).' - ';
    
    switch(trim($_GET['e'])) {
        case("400"):
            $page_content .= 'Bad Request</h1><p>The request could not be understood by the server due to malformed syntax. You SHOULD NOT repeat the request without modifications.</p>';
            break;
        case("403"):
            $page_content .= 'Forbidden</h1><p>The server understood the request, but is refusing to fulfill it.</p>';
            break;
        case("404"):
            $page_content .= 'Not Found</h1><p>The server has not found anything matching the Request-URI. No indication is given of whether the condition is temporary or permanent.</p>';
            break;
        case("408"):
            $page_content .= 'Request Timeout</h1><p>The procedure was not completed within the timelimit set.</p>';
            break;
        case("500"):
            $page_content .= 'Internal Server Error</h1><p>The server encountered an unexpected condition which prevented it from fulfilling the request.</p>';
            break;
        case("503"):
            $page_content .= 'Service Unavailible</h1><p>The server is currently unable to handle the request due to a temporary overloading of the server.</p>';
            break;
        default:
            $page_content .= 'Unknown Error</h1><p>An unknown error has occured.</p>';
            break;
    }
?>
