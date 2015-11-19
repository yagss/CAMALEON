$(document).ready(function(){
    menu("hide");

    $(".fieldbox.textbox").animateTextbox();
    $(".fieldbox.select").animateSelect();

    autosize($(".fieldbox.textbox").find("field"));

    $(".btnCloseContent").btnCloseContent({content:$("#contenedor")});
    
    $(".link").link({container: $("#contenedor")});
    
    $("#contenedor").trigger("closePrev", "Form Tercero");

    var beforeSend = function(){
        
        $(".cover").addClass("show");
        
    };
    
    var complete = function(){
        
        $(".cover").removeClass("show");
        
    };
    
    var parameters = {url:"/app/controller/php/administracion/contabilidad/transaccion/tipodoc_contable.php", beforeSend: beforeSend, complete: complete};
    $("#tipodoc").parent().select(parameters);
    
    $("#tipodoc").trigger("load");
    
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
        var movimientos = data.movimientos;
        $('#tipodoc').val(data.tipodoc);
        $('#fecha').val(data.fecha);
        $('#descripcion').val(data.descripcion);
        if (movimientos.length >0) {
            $.each(movimientos, function (i,item) {
                
            });
        };
        autosize($(".field.text").find(".field"));
    };
    
    var ready = function()
    {
        $("#transaccion").loadForm({operation: load, beforeSend: beforeSend, complete: complete});
    };
    
    setTimeout(ready, 0);
});