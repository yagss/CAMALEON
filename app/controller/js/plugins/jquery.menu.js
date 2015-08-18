// JavaScript Document

(function($){
    
    $.fn.menu = function(parameters){
    
        this.each(function(){
        
            var parameter = $.extend({
                object: $(this),
                btn_menu : null,
                content: null
            }, parameters);
            
            var btnMenuShow = function(){
                
                parameter.btn_menu.show();
                parameter.btn_menu.append('<i class="fa fa-ellipsis-v"></i>');
                
            };
            
            var btnMenuHide = function(){
                
                parameter.btn_menu.hide();
                parameter.btn_menu.find(".fa-ellipsis-v").remove();
                
            };
            
            var open_close = function(){
                
                if(!(parameter.object.hasClass("open_menu"))){
                    parameter.object.addClass("open_menu");
                    parameter.btn_menu.addClass("active");
                }else{
                    close();
                }
                
            };
            
            var close = function (){
                
                if(parameter.object.hasClass("open_menu")){
                    parameter.object.removeClass("open_menu");
                    parameter.btn_menu.removeClass("active");
                }
                
            };
            
            var loadMenu = function(event){
                
                event.preventDefault();
                
                if(parameter.object.data("name")!=""){
                    
                    btnMenuHide();
                    
                    parameter.object.empty();
                
                    $.ajax({
                        url: "/app/controller/php/menu.php",
                        type: "POST",
                        contentType: 'application/json',
                        dataType: 'json',
                        data: JSON.stringify({showMenu: true, name: parameter.object.data("name")}),
                        success: function(result){

                            if(result.ejecution){

                                parameter.object.prepend(result.result);
                                btnMenuShow();
                                console.info( parameter.object.data("name") + " - Menu Loaded!");

                                $("a").link({container:$(".subbody"), afterAction: close});

                            }else{

                                btnMenuHide();
                                console.warn( "No se encontro el menu a cargar!" );

                            }

                        },
                        error: function(request, errorType, errorMessage){

                            console.error('Error: ' + errorType +  '<br> whit message: ' + errorMessage);
                            btnMenuHide();

                        },
                        timeout: 10000,
                        beforeSend: function(){

                            parameter.btn_menu.show();
                            parameter.btn_menu.append('<i class="fa fa-refresh fa-spin"></i>');

                        },
                        complete:function(){

                            parameter.btn_menu.find(".fa-refresh").remove();

                        }
                    });
                
                }
                
            };
            
            parameter.object.on("loadMenu", loadMenu);
            
            parameter.object.on("btnMenuShow", btnMenuShow);
            parameter.object.on("btnMenuHide", btnMenuHide);
            
            parameter.btn_menu.on("click", open_close);
            
            parameter.content.on("click", close);
            
            parameter.object.find("a").on("click", close);
            
            parameter.object.trigger("loadMenu");
            
        });
        
    }
    
}(jQuery));