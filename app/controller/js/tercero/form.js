// JavaScript Document
/**
* @autor : Juan Camilo Lara y Steven Medina
* @editor : Sublime Text 3
* @metodo : JavaScript con jQuery
* @descripcion : Se realiza la codificacion del formulario tercero con ocultacion y muestra de seccion persona natural y juridica
*/

$(document).ready(function(){
	menu("hide");

	$(".fieldbox.textbox").animateTextbox();
	$(".fieldbox.select").animateSelect();

	autosize($(".fieldbox.textbox").find("field"));

	$(".btnCloseContent").btnCloseContent({content:$("#contenedor")});

	var beforeSend = function(){
        
        $(".cover").addClass("show");
        
    };
    
    var complete = function(){
        
        $(".cover").removeClass("show");
        
    };
    
    var parameters = {url:"/app/controller/php/localizacion.php", next: $("#dep").parent() ,beforeSend: beforeSend, complete: complete};
    $("#pais").parent().select(parameters);
    parameters.next =  $("#cdd").parent();
    $("#dep").parent().select(parameters);
    parameters.next =  null;
    $("#cdd").parent().select(parameters);
    
    $("#pais").trigger("load");

	$(".juridica").hide();

	$("input[name=tipo]").click(function(){
		var textbox = "";

		if ($(this).val() == "natural")
		{
			textbox = $(".juridica").find('.field');
			textbox.val("");
			textbox.trigger("focusout");
			textbox.trigger("normal");
			$(".juridica").fadeOut(function(){
				$(".persona").fadeIn();
			});	
		}
		else
		{
			textbox = $(".persona").find('.field');
			textbox.val("");
			textbox.trigger("focusout");
			textbox.trigger("normal");
			$(".persona").fadeOut(function() {
				$(".juridica").fadeIn();
			});
		}
	});

	
	var reload = function(result, msg)
	{
		if (result) 
		{
			if (msg != "") 
			{
				alert("info","icon-confirmar",msg);
				$("#contenedor").trigger("load", {url: '/app/view/html/tercero/view.html', name: 'View Tercero'});
			}
		}
		else
		{
			if(msg != "")
			{
                alert("error","icon-cerrar",msg);
            }
		}
	}

    var beforeSend_t = function(){
        
        $(".cover").addClass("show");
        $("#tercero").find(".button").prop("disabled", true);
        
    };
    
    var complete_t = function(){
        
        $(".cover").removeClass("show");
        var btn_enable = function(){$("#tercero").find(".button").prop("disabled", false);};
        setTimeout(btn_enable, 5000);
        
    };
    
	$("#tercero").sendForm({operation:reload, beforeSend: beforeSend_t, complete: complete_t});

});