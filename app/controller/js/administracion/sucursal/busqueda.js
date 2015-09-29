$(document).ready(function(){

	$(".fieldbox.textbox").animateTextbox();
	$(".fieldbox.select").animateSelect();

	autosize($(".fieldbox.textbox").find("field"));

	$("btnCloseContent").btnCloseContent({content:$("contenedor")});

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
                alert("info","icon-checkmark",msg);
                $("#contenedor").trigger("load", {url: '/app/view/html/administracion/sucursal/view.html', name: 'View Sucursal'});
            }
        }
        else
        {
            if(msg != "")
            {
                alert("error","icon-cross",msg);
            }
        }
    };

    var load = function(result, message){
    	var html = '';
    	$.each(result, function(i, item){
            html +='<form class="form buscador" method="post" action="/app/controller/php/administracion/sucursal/sucursal.php" id="formulario' + item.id + '"><div class="subform"><input type="hidden" name="instanciar" value="true"/><input type="hidden" name="id_sucursal" value="'+ item.id +'"/><div class="espacio left"><h2>' + item.nombre + '</h2><p>' + item.ciudad_nombre + '</p></div><div class="espacio right"><a class="link" href="javascript:$().ver(\'#formulario'+ item.id +'\');"><span class="icon-eye"></span></a></div></div></form><br>';
    	});
		$('#sucursales').html(html);
    }

    $.fn.ver = function(param) {
        $(param).sendForm({operation:reload, beforeSend: beforeSend, complete: complete});
        $(param).submit();
    };

    var ready = function() {
        $("#busqueda_sucursal").submit();
    }

    setTimeout(ready,0);

    $("#busqueda_sucursal").sendForm({operation:load, beforeSend: beforeSend, complete: complete});

});  
    


