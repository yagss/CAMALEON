// JavaScript Document

$(document).ready(function(){

    $(".fieldbox").animateTextbox();
    
    $(".icon-enter").click(function(){
        $("#login").fadeToggle('slow','swing');
    });
    
    menu("hide");
    
    // result action
    var reload = function(result, msg){
        
        if(result){
            
            //if(msg != ""){alert(msg)}
            document.location.href='/';
            
        }else{
            
            alert("error","fa fa-times",msg);
            
        }
        
    };
    
    // form send
    var beforeSend = function(){
        
        $(".cover").addClass("show");
        $("#login").find(".button").prop("disabled", true);
        
    };
    
    var complete = function(){
        
        $(".cover").removeClass("show");
        var btn_enable = function(){$("#login").find(".button").prop("disabled", false);};
        setTimeout(btn_enable, 5000);
        
    };
    
	$("#login").sendForm({operation:reload, beforeSend: beforeSend, complete: complete});

});