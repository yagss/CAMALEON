// JavaScript DOcument

$(document).ready(function(){

    $('.submenu').children('a').click(function(){
        $(this).parent().children('.children').slideToggle();
    });

});

