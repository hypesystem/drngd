$(document).ready(function(){

    $("#create-link img").hover(function() {
        $(this).attr('src','style/logo_glow.png');
    },function() {
        $(this).attr('src','style/logo.png');
    });
    $("#stats-head img").hover(function() {
        $(this).attr('src','style/logo_glow.png');
    },function() {
        $(this).attr('src','style/logo.png');
    });
    
    $("input[name=url]").keypress(function(event) {
       if(event.which == 13) {
           $("input[type=submit]").click();
       }
    });
    
    $("input[name=url]").click(function() {
        if($(this).attr("value") == "http://url") $(this).attr("value",'');
        $(this).removeClass("inactive");
    });
    
    $("input[type=submit]").click(function() {
        $(this).attr("disabled",true);
        $("#output").hide();
        $.getJSON("create-link.php", { url: $("input[name=url]").attr('value') }, function(createData) {
            if(createData.success) {
                $("#output").html(
                    '<span class="green">Success!</span> Your short link is: <a href="'+createData.link.link+'" target="_blank">drng.dk/'+createData.link.id+'</a> (<a href="#" id="copy-link">click here to copy</a>)<br />'+
                    'To track and view statistics for your link, see <a href="http://drng.dk/!stats/'+createData.link.id+'">drng.dk/!stats/'+createData.link.id+'</a>'+
                    '<script type="text/javascript">copyLink.setText("http://drng.dk/'+createData.link.id+'"); copyLink.glue("copy-link");</script>'
                );
            }
            else {
                $("#output").html('<span class="red">Failure!</span> '+createData.error);
            }
        });
        $("input[name=url]").attr("value","http://url");
        $("input[name=url]").addClass("inactive");
        $("#output").fadeIn("slow");
        $(this).delay("slow").removeAttr("disabled");
    });
    
});