$(document).ready(function(){
    
    ZeroClipboard.setMoviePath( 'clip/ZeroClipboard.swf' );
    var copyLink = new ZeroClipboard.Client();
    
    $("#url-input").keypress(function(event) {
       if(event.which == 13) {
           $("#url-submit").click();
       }
    });
    
    $("#url-input").click(function() {
        if($(this).attr("value") == "http://url") $(this).attr("value",'');
        $(this).removeClass("inactive");
    });
    
    $("#url-submit").click(function() {
        $(this).attr("disabled",true);
        $("#output").hide();
        $.getJSON("api/create-link.php", {url: $("#url-input").attr('value')}, function(createData) {
            if(createData.success) {
                $("#output").html(
                    '<span class="green">Success!</span> Your short link is: <a href="'+createData.link.link+'" target="_blank">drng.dk/'+createData.link.id+'</a> (<a href="#" id="copy-link">click here to copy</a>)<br />'+
                    'To track and view statistics for your link, see <a href="http://drng.dk/!stats/'+createData.link.id+'">drng.dk/!stats/'+createData.link.id+'</a>'+
                    '<script type="text/javascript">copyLink.setText("http://drng.dk/'+createData.link.id+'"); copyLink.glue("copy-link");</script><br /><br />'
                );
            }
            else {
                $("#output").html('<span class="red">Failure!</span> '+createData.error);
            }
        });
        $("#url-input").attr("value","http://url");
        $("#url-input").addClass("inactive");
        $("#output").fadeIn("slow");
        $(this).delay("slow").removeAttr("disabled");
    });
    
});