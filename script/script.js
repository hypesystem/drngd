$(document).ready(function(){
    
    //make fade ind
    $("#create-link img").hover(function() {
        $(this).attr('src','style/logo_glow.png');
    },function() {
        $(this).attr('src','style/logo.png');
    });
    
    $("input.inactive").click(function() {
        $(this).attr("value",'');
        $(this).removeClass("inactive");
    });
    
    $("input[type=submit]").click(function() {
        $("#output").load("create-link.php?url="+$("input[name=url]").attr('value'));
    });
    
});