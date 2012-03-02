API Documentation
=================

[create-link]: http://api.drng.dk/create-link.php "create-link API call"
[get-stats]: http://api.drng.dk/get-stats.php "get-stats API call"

`NOTE: To use jQuery for remote API calls, you may need to create some kind
of work-around as most browsers block remote calls per default. `

There are currently only two availible API calls: [**create-link**][create-link]
and [**get-stats**][get-stats]. They are called by accessing
[http://api.drng.dk/create-link.php][create-link] and
[http://api.drng.dk/get-stats.php][get-stats], respectively.

Any drng.dk API call takes its arguments in GET and returns a JSON object, that
can easily be interpreted with jQuery, cURL or the likes. The first (and only
constant) element of the object is the "success" boolean. This indicates whether
your request was succesful or not.

If it was *not* successful (`success == false`), there will be an `error`-element
as well, detailing what went wrong. Hence, you should always check for the
success of a call as a first thing.

With cURL (PHP) an erroneous call would be like the following (although it's not
far off):

    <?php
    $query = "?url=google.com";
    $ch = curl_init();

    curl_setopt($ch, CURLOPT_URL, 'http://api.drng.dk/create-link.php'.$query);
    
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
    curl_setopt($ch, CURLOPT_TIMEOUT, '3');
    
    $content = trim(curl_exec($ch));
    curl_close($ch);
    
    $arr = json_decode($content,true);
    if(!$arr['success'])
        echo 'Failure! '.$arr['error'];
    ?>

The problem with the above (which should always print the error), is that it
makes a create-link API call with an invalid URL: URLs must always be prefixed
with either http://, https://, ftp:// or www.

An example of a faulty call with jQuery could be:

    <script type="text/javascript">
    $.getJSON("http://api.drng.dk/get-stats.php", {url: "http://drng.dk/qz"}, function(data) {
        if(!data.success) alert(data.error);
        else alert("#WINNING");
    });
    </script>

This would result in a popup-box with an error-message telling you "Invalid link
id given". Why? Because get-stats.php does not take an URL, it takes **only**
the id.

create-link
-----------

The create-link call takes *one* argument: `url`. The call is really quite
straight-forward.

It returns an object containing a `link` (full short link) and an `id` (id of
link, the last part of short link, used to find stats etc.). The id is the most
important part to save, the link is merely there for convenience. The full
object could look something like this:

    {
        "success": true,
        "id": "4g",
        "link": "http:\/\/drng.dk\/4g"
    }

A correct call with jQuery could look something like this:

    <script type="text/javascript">
    $.getJSON("http://api.drng.dk/create-link.php", {url: "http://deranged.dk"}, function(data) {
        if(data.success)
            alert("Your link has been succesfully created!\n"+
                "Your short link is: "+data.link);
        else
            alert("Oops! Something went wrong with the link creation!\n"+
                data.error);
    });
    </script>

This prints a message and the short link generated if it was succesful.
Otherwise, it will print an error message, passed on directly from the API.

get-stats
---------

The get-stats call takes *one* argument: `id`. This is the id provided when
creating a link (see above).

It returns an object containing quite some information - all the information
that is relevant about the link, actually.

An example object could look like the following:

    {
        "success": true,
        "link": "http:\/\/drng.dk\/4g",
        "created_at": 1330211075,
        "original_url": "http:\/\/google.com",
        "visits_day": 3,
        "visits_week": 3,
        "visits_month": 3,
        "visits_year": 3,
        "visits": [
            ["2012-02-26",3]
        ]
        "browsers": [
            ["Firefox",3]
        ]
        "os": [
            ["Windows",3]
        ]
    }

Following is each part of the object explained:

 * **success**: Whether the request was a success or not.
 * **link**: The full link for which statistics are shown.
 * **created_at**: The time of creation of this link in UNIX timestamp format
   (seconds)
 * **original_url**: Where the link leads to. The URL it is supposed to redirect
   to.
 * **visits_day**: Visits in the last 24 hours (convenience)
 * **visits_week**: Visits in the last 7*24 hours = 7 days (convenience)
 * **visits_month**: Visits in the last 31*24 hours = 31 days (convenience)
 * **visits_year**: Visits in the last 365*24 hours = 365 days (convenience)
 * **visits**: Contains an array of arrays with data. `visits[i][0]` contains
   date of visit as a string in format "YYYY-MM-DD". `visits[i][1]` contains the
   amount of visitors on that date. In this way, only days with visitors are
   shown.
 * **browsers**: Contains an array of arrays with data. `browsers[i][0]`
   contians the name of a browser, `browsers[i][1]` contains the amount of
   visitors using that browser.
 * **os**: Contains an array of arrays with data. `os[i][0]` contains the name
   of an operating system, `os[i][1]` contains the amount of visitors using that
   os.

Using this knowledge, an easy, naive implementation of some statistics with
jQuery can be obtained as in the following example:

    <script type="text/javascript">
    $.getJSON("http://api.drng.dk/get-stats.php", {id: 1}, function(data) {
        if(data.success) {
            var c = new Date();
            c.setTime(data.created_at * 1000);   //javascript uses ms timestamps
            var date = c.getDate()+'-'+(c.getMonth() + 1)+'-'+c.getYear();

            var html =
                'Original link: <a href="'+data.original_url+'">'+data.original_url+'</a>'+
                '<br/>Visits in the last 24 hours: '+data.visits_day+
                '<br/>Visits since creation ('+date+'): '+data.visits_total;

            $("body").append(html);
        }
    });
    </script>

>Naive implementation showing downloads cURL

>Advanced implementation showing more data using jQuery