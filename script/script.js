$(document).ready(function(){
    
    //make fade ind
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
    
    $("input.inactive").click(function() {
        $(this).attr("value",'');
        $(this).removeClass("inactive");
    });
    
    $("input[type=submit]").click(function() {
        $("#output").hide();
        $("#output").load("create-link.php?url="+$("input[name=url]").attr('value'));
        $("#output").fadeIn("slow");
    });
    
});