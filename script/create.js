$(document).ready(function(){
    
    ZeroClipboard.setMoviePath( 'lib/zeroclipboard/ZeroClipboard.swf' );
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
                    '<span class="green">Success!</span> Your short link is: <a href="'+createData.link+'" target="_blank">drng.dk/'+createData.id+'</a> (<a href="#" id="copy-link">click here to copy</a>)<br />'+
                    'To track and view statistics for your link, see <a href="http://drng.dk/!stats/'+createData.id+'">drng.dk/!stats/'+createData.id+'</a>'
                );
                copyLink.setText('http://drng.dk/'+createData.id);
                copyLink.glue("copy-link");
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