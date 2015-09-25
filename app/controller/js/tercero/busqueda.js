$(document).ready(function(){

	$(".fieldbox.textbox").animateTextbox();
	$(".fieldbox.select").animateSelect();

	autosize($(".fieldbox.textbox").find("field"));

	$("btnCloseContent").btnCloseContent({content:$("contenedor")});

	$('.natural').fadeIn();
    $('.juridica').fadeIn();
    $("#std_todos").attr('checked', 'checked');

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
                $("#contenedor").trigger("load", {url: '/app/view/html/tercero/view.html', name: 'View Tercero'});
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
        
    	$('#tercero_registros').empty();
        
    	$.each(result, function(i, item){
    		if(item.hasOwnProperty('nit'))
    		{
                var frm = $('<form class="form buscador juridica" id="' + item.nit + '" method="post" action="/app/controller/php/tercero/tercero.php"></form>');
                frm.append('<input name="instanciar" type="hidden" value="true"/>');
                frm.append('<input type="hidden" name="nit" value="' + item.nit + '"/>');
                frm.append('<input type="hidden" name="tipo" value="' + item.tipo + '"/>');
                var subform = $('<div class="subform"></div>');
                subform.append('<div class="espacio left"><h2>' + item.razon_social + '</h2><p>' + item.nit + '</p></div>');
                subform.append('<div class="espacio right"><a class="link" href="javascript:$().ver(\'#' + item.nit + '\');"><span class="icon-eye"></span></a></div>');
                frm.append(subform);
    		}
    		else if(item.hasOwnProperty('numdoc'))
    		{
                var frm = $('<form class="form buscador natural" id="' + item.numdoc + '" method="post" action="/app/controller/php/tercero/tercero.php"></form>');
                frm.append('<input name="instanciar" type="hidden" value="true"/>');
                frm.append('<input type="hidden" name="numero_documento" value="' + item.numdoc + '"/>');
                frm.append('<input type="hidden" name="tipo" value="' + item.tipo + '"/>');
                var subform = $('<div class="subform"></div>');
                subform.append('<div class="espacio left"><h2>' + item.nombre + ' ' + item.apellido + '</h2><p>' + item.numdoc + '</p></div>');
                subform.append('<div class="espacio right"><a class="link" href="javascript:$().ver(\'#' + item.numdoc + '\');"><span class="icon-eye"></span></a></div>');
                frm.append(subform);
    		}
            $('#tercero_registros').append(frm);
    	});
        
		
    }

    

    $('input[name=tipo_b]').click(function(){
        if($(this).val() == 'natural'){
            $('.juridica').fadeOut(function(){
                $('.natural').fadeIn();
            });

        }
        else if($(this).val() == 'juridica'){
            $('.natural').fadeOut(function(){
                $('.juridica').fadeIn();
            });
        }
        else
        {
            $('.natural').fadeIn();
            $('.juridica').fadeIn();
        }
    });

/*    $('input[name=subcuenta]').keypress(function(e){
        if((e.which == 13)){
            $('#buscar').click();
            e.preventDefault();
        }
            
    });*/

    $.fn.ver = function(param) {
        $(param).sendForm({operation:reload, beforeSend: beforeSend, complete: complete});
        $(param).submit();
    };

   	$(".filtrar").find("a").click(function(){
        $(".option").slideToggle();
    });

    var ready = function() {
        $("#busqueda_tercero").submit();
    }

    setTimeout(ready,0);

    $("#busqueda_tercero").sendForm({operation:load, beforeSend: beforeSend, complete: complete});

});  
    


