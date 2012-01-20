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
    
    $("input[name=url]").click(function() {
        if($(this).attr("value") == "http://url") $(this).attr("value",'');
        $(this).removeClass("inactive");
    });
    
    $("input[type=submit]").click(function() {
        $(this).attr("disabled",true);
        $("#output").hide();
        $("#output").load("create-link.php?url="+$("input[name=url]").attr('value'));
        $("input[name=url]").attr("value","http://url");
        $("input[name=url]").addClass("inactive");
        $("#output").fadeIn("slow");
        $(this).delay("slow").removeAttr("disabled");
    });
    
});