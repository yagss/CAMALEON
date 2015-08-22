// JavaScript Document

$(document).ready(function(){
                    
    $("#contenedor").contentManagement({cover: $(".cover")});
    
    $("#session").session({container: $("#contenedor"), login: '/app/view/html/usuario/login.html'});

    var action = function(){

        $("#contenedor").trigger("load", {url: '/app/view/html/home.html', name: 'Home'});

    };

    $("#session").trigger("validation", action);
    
    var session_validation = function(){$("#session").trigger("validation", null);};
    
    //setInterval(session_validation, 10000);

});