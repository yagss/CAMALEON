
$(document).ready(function(){
    $(".fieldbox").animateTextbox();
    $(".icon-enter").click(function(){
        $(".login").fadeToggle('slow','swing');
    });
});