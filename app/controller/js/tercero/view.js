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

    $("btnCloseContent").btnCloseContent({content:$("contenedor")});
    
    $(".link").link({container: $("#contenedor")});
    
    $("#contenedor").trigger("closePrev", "Form Tercero");
    
    var beforeSend = function()
    {
        $(".cover").addClass("show");
    };
    
    var complete = function()
    {
        $(".cover").removeClass("show");
    };
    
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
            $("select[name=ciudad]").html('<option value="' + data.idCiudad + '">' + data.nomCiudad + '</option>');
            $("select[name=departamento]").html('<option value="' + data.idDepartamento + '">' + data.nomDepartamento + '</option>');
            $("select[name=pais]").html('<option value="' + data.idPais + '">' + data.nomPais + '</option>');
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
            $("select[name=ciudad]").html('<option value="' + data.idCiudad + '">' + data.nomCiudad + '</option>');
            $("select[name=departamento]").html('<option value="' + data.idDepartamento + '">' + data.nomDepartamento + '</option>');
            $("select[name=pais]").html('<option value="' + data.idPais + '">' + data.nomPais + '</option>');
            $("input[name=direccion]").val(data.direccion);
            $("input[name=telefono]").val(data.telefono);

        }  
        autosize($(".fieldbox.textbox").find(".field"));
    };
    
    var ready = function()
    {
        $("#tercero").loadForm({operation: load, beforeSend: beforeSend, complete: complete});
    };
    
    setTimeout(ready, 0);
    
});