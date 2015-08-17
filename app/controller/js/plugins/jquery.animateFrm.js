// JavaScript Document

(function($){
    
    $.fn.animateTextbox = function(parameters){
    
        this.each(function(){
        
            var parameter = $.extend({
                textbox: $(this)
            }, parameters);
            
            var focus = function(){
                
                parameter.textbox.find(".field").focus();
                
                focusin();
                
            };
            
            var focusin = function(){
                
                var textbox = parameter.textbox.find(".field");
                
                textbox.addClass("active");
                
                if(textbox.val()!=""){
                    textbox.parent().find("label").removeClass("hastext");
                    textbox.parent().find("label").addClass("active");
                    
                }else{
                    if(!(textbox.parent().find("label").hasClass("focusin"))){
                        textbox.parent().find("label").addClass("focusin");
                    }
                }
                
            };
            
            var focusout = function(){
                
                var textbox = parameter.textbox.find(".field");
                
                textbox.removeClass("active");
                
                textbox.parent().find("label").removeClass("focusin");
                textbox.parent().find("label").removeClass("active");
                
                if(textbox.val()!=""){
                    textbox.parent().find("label").addClass("hastext");
                }else{
                    textbox.parent().find("label").removeClass("hastext");
                }
                
            };
            
            parameter.textbox.find("label").on("click", focus);
            
            parameter.textbox.find(".field").on("focusin", focusin);
            parameter.textbox.find(".field").on("focusout", focusout);
            
        });
        
    }
    
    
    
}(jQuery));