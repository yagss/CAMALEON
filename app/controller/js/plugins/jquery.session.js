// JavaScript Document

(function($){
    
    $.fn.session = function(parameters){
    
        this.each(function(){
        
            var parameter = $.extend({
                
                object: $(this),
                container: null,
                login: "",
                logout: null
                
            }, parameters);
            
            var loadLogin = function(){
                
                parameter.container.trigger("clear");
                parameter.container.trigger("load", {url: parameter.login, name: 'Login'});

            };
            
            var sessionShow = function(){
            
                parameter.object.removeClass('icon-enter');
                parameter.object.addClass('icon-user');
                
            };
            
            var sessionHide = function(){
            
                parameter.object.removeClass('icon-user');
                parameter.object.addClass('icon-enter');
                
            };
            
            var sessionAction = function(event, actions){
                
                $.ajax({
                    url: "/app/controller/php/usuario/session.php",
                    type: "POST",
                    contentType: 'application/json',
                    dataType: 'json',
                    data: JSON.stringify(actions.action),
                    success: function(result){
                        
                        actions.functionSuccess(result);
                    
                    },
                    error: function(request, errorType, errorMessage){
                        
                        console.error('Error: ' + errorType + '\nMessage: ' + errorMessage);
                        if(actions.functionError!=null){actions.functionError()}
                        
                    },
                    timeout: 10000,
                    beforeSend: function(){
                        
                        actions.functionBeforeSend();
                        
                    },
                    complete: function(){
                        
                        actions.functionComplete();
                        
                    }
                });
            
            };
            
            var validation = function(event, action){
                
                event.preventDefault();
                
                sessionHide();
            
                var success = function(result){
                
                    if(result.ejecution==false){

                        console.error("Ejecution Validation Error - " + result.error);
                        alert("error", "fa fa-times", "Error en la ejecución de validación.");
                        sessionHide();
                        loadLogin();

                    }else if(result.ejecution==true){

                        if(!(result.result)){

                            console.warn(result.message);
                            sessionHide();
                            loadLogin();

                        }else{

                            console.info(result.message);
                            sessionShow();
                            if(action!=null){action()}

                        }
                
                    }    
                    
                };
                
                var error = function(){
                    
                    sessionHide();
                    loadLogin();
                    
                };
                
                var beforeSend = function(){
                    
                    //parameter.object.show();
                    parameter.object.addClass('icon-spinner9');
                    
                };
                
                var complete = function(){
                    
                    parameter.object.removeClass('icon-spinner9');
                    
                };
                
                sessionAction(event, {
                    action:{validation: true}, 
                    functionSuccess: success, 
                    functionError: error, 
                    functionBeforeSend: beforeSend,
                    functionComplete: complete
                });
            
            };
            
            var logout = function(event, action){
                
                event.preventDefault();
                
                sessionHide();
            
                var success = function(result){
                
                    if(result.ejecution==true){

                        console.info("Ejecution Logout Ok!");
                        alert("info", "fa fa-check", "Sesión de usuario terminada.");
                        sessionHide();
                        
                        if(action!=null){action()}
                        
                        loadLogin();
                        
                
                    }else if(result.ejecution==false){

                        console.error("Ejecution Logout Error - " + result.error);
                        alert("error", "fa fa-times", "Error en la ejecución de cierre de sesión.");
                        
                    }
                    
                };
                
                var beforeSend = function(){
                    
                    parameter.object.addClass('icon-spinner9');
                    
                };
                
                var complete = function(){
                    
                    parameter.object.remove("icon-spinner9");
                    
                };
                
                sessionAction(event, {
                    action:{logout: true}, 
                    functionSuccess: success, 
                    functionError: null, 
                    functionBeforeSend: beforeSend,
                    functionComplete: complete
                });
            
            };
            

            
            parameter.object.on("validation", validation);
            
            parameter.object.on("logout", logout);
        
        });
        
    }
    
}(jQuery));