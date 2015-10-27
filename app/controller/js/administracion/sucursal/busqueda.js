$(document).ready(function(){

	$(".fieldbox.textbox").animateTextbox();

	autosize($(".fieldbox.textbox").find("field"));

	$(".btnCloseContent").btnCloseContent({content:$("#contenedor")});
    
    $('.result').empty();

    var beforeSend = function(){
        
        $(".cover").addClass("show");
        
    };
    
    var complete = function(){
        
        $(".cover").removeClass("show");
        
    };

    var reload = function(result, msg)
    {
        if (result) 
        {
            if (msg != "") 
            {
                alert("info","icon-confirmar",msg);
                $("#contenedor").trigger("load", {url: '/app/view/html/administracion/sucursal/view.html', name: 'View Sucursal'});
            }
        }
        else
        {
            if(msg != "")
            {
                alert("error","icon-cerrar",msg);
            }
        }
    };

    var load = function(result, message){
        
        if(result.length>0){
            
            $('.result').empty();
        
            $.each(result, function(i, item){

                var frm = $('<form class="infobox sucursal" method="post" action="/app/controller/php/administracion/sucursal/sucursal.php"></form>');
                frm.append('<input name="instanciar" type="hidden" value="true"/>');
                frm.append('<input type="hidden" name="id_sucursal" value="' + item.id + '"/>');
                var subform = $('<div class="subform"></div>');
                subform.append('<div class="espacio left"><h2>' + item.nombre + '</h2><p>' + item.ciudad_nombre + '</p></div>');
                subform.append('<div class="espacio right"><a class="link" href="#"><i class="icon-ver"></i></a></div>');
                frm.append(subform);

                frm.sendForm({operation:reload, beforeSend: beforeSend, complete: complete});

                frm.find(".link").click(function(){frm.submit();});

                $('.result').append(frm);
            });
            
            alert("info","icon-confirmar",message);
            
        }else{
            
            alert("error","icon-cerrar",message);
            
        }
		
    };

    $("#sucursal").sendForm({operation:load, beforeSend: beforeSend, complete: complete});

});  
