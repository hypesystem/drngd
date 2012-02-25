API Documentation
=================

There are currently only two availible API calls: **create-link** and 
**get-stats**. They are called by accessing http://api.drng.dk/create-link.php
and http://api.drng.dk/get-stats.php, respectively.

An API call takes its arguments in GET and returns a JSON object, that can
easily be interpreted with jQuery, cURL or the likes. The first (and only
constant) element of the object is the "success" boolean. This indicates whether
your request was succesful or not.

If it was *not* successful, (success == true), there will be an "error"-element
as well, detailing what went wrong. Hence, you should always check for the
success of a call as a first thing.

> Example of wrong call jQuery
> Example of wrong call cURL

create-link
-----------

The create-link call takes *one* argument: "url". The call is really quite
straight-forward.

It returns an object containing a "link" (full short link) and an "id" (id of
link, the last part of short link, used to find stats etc.). The id is the most
important part to save, the link is merely there for convenience. The full
object could look something like this:

    {
        "success": true,                //the call was succesful
        "id": "4g",                     //your id is 4g
        "link": "http:\/\/drng.dk\/4g"  //your short link in full
    }

> Correct call using jQuery

get-stats
---------

The get-stats call takes *one* argument: "id". This is the id provided when
creating a link (see above).

It returns an object containing quite some information - all the information
that is relevant about the link, actually.

An example object could look like the following (each line commented):

    {
        "success": true,                        //your call was succesful
        "link": "http:\/\/drng.dk\/4g",         //short link in full
        "created_at": 1330211075,               //time of creation UNIX timestamp (seconds)
        "original_url": "http:\/\/google.com",  //url link leads to
        "visits_day": 3,                        //visis last 24h
        "visits_week": 3,                       //visits last 7*24h
        "visits_month": 3,                      //visits last 31*24h
        "visits_year": 3,                       //visits last 365*24h
        "visits": [                             //array of all visits data
            ["2012-02-26",3]                    //[0]: Date in string; [1]: Visitors on day
        ]
        "browsers": [                           //array of browsers used
            ["Firefox",3]                       //[0]: Name of browser; [1]: Visitors using
        ]
        "os": [                                 //array of operating systems used
            ["Windows",3]                       //[0]: Name of OS; [1] Visitors using
        ]
    }

>Naive (visits_xx) implementation showing simple stats using jQuery
>Naive implementation showing downloads cURL
>Advanced implementation showing more data using jQuery