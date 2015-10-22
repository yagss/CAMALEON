// JavaScript Document
/**
* @autor : Juan Camilo y Steven Medina
* @editor : Sublime Text 3
* @metodo : JavaScript con jQuery
* @descripcion : Se realiza la codificacion del formulario tercero con ocultacion y muestra de seccion persona natural y juridica
*/

$(document).ready(function(){
    
    menu("hide");

    $(".fieldbox.textbox").animateTextbox();
    $(".fieldbox.select").animateSelect();

    autosize($(".fieldbox.textbox").find("field"));

    $(".link").link({container: $("#contenedor")});
    
    $(".btnCloseContent").btnCloseContent({content:$("#contenedor")});
    
    $("#contenedor").trigger("closePrev", "Form Tercero");
    $("#contenedor").trigger("closePrev", "Delete Tercero");
    
    var beforeSend = function()
    {
        $(".cover").addClass("show");
    };
    
    var complete = function()
    {
        $(".cover").removeClass("show");
    };
    
    var loadSelect = function(pais, dep, cdd) {
        var parameters = {url:"/app/controller/php/localizacion.php",
        value: pais, next: $("#dep").parent(), beforeSend: beforeSend, complete: complete};
        $("#pais").parent().select(parameters);
        parameters.next =  $("#cdd").parent();
        parameters.value = dep;
        $("#dep").parent().select(parameters);
        parameters.next =  null;
        parameters.value = cdd;
        $("#cdd").parent().select(parameters);
        
        $("#pais").trigger("load");
        $("#pais").trigger("change");
    }

    var load = function(result, message, data)
    { 
        if(data.tipo == "NATURAL"){
            $(".juridica").hide(function(){
                $(".persona").show();
            }); 

            $("#persona").attr('checked', 'checked');
            $("select[name=regimen]").val(data.regimen);
            if(data.gc){
                $("#si").attr('checked', 'checked');
            }
            else{
                $("#no").attr('checked', 'checked');
            }

            $("input[name=nombre]").val(data.nombre);
            $("input[name=apellido]").val(data.apellido);
            $("select[name=tipo_documento]").val(data.tipo_documento)
            $("input[name=numero_documento]").val(data.numero_documento);
            loadSelect(data.idPais, data.idDepartamento, data.idCiudad);
            $("input[name=direccion]").val(data.direccion);
            $("input[name=telefono]").val(data.telefono);
        }
        else if(data.tipo == "JURIDICA"){
            $(".persona").hide(function() {
                $(".juridica").show();
            });
            $("#juridica").attr('checked', 'checked');
            $("select[name=regimen]").val(data.regimen);
            if(data.gc){
                $("#si").attr('checked', 'checked');
            }
            else{
                $("#no").attr('checked', 'checked');
            }

            $("input[name=nit]").val(data.nit);
            $("input[name=razon_social]").val(data.razon_social);
            $("select[name=naturaleza]").val(data.naturaleza);
            $("input[name=fecha]").val(data.fechaconst);
            loadSelect(data.idPais, data.idDepartamento, data.idCiudad);
            $("input[name=direccion]").val(data.direccion);
            $("input[name=telefono]").val(data.telefono);

        }

        $(".fieldbox.textbox").find(".field").trigger("focusout");
        $(".fieldbox.select").find("select").trigger("selection");
        autosize($(".fieldbox.textbox").find(".field"));
    };

    var ready = function()
    {
        $("#tercero").loadForm({operation: load, beforeSend: beforeSend, complete: complete});
    };

    
    setTimeout(ready, 0);

    //Desde estas lineas de codigo es el envio de datos

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