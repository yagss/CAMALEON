// JavaScript Document

(function($){
    
    $.fn.rowdespl = function(parameters){
    
        this.each(function(){
        
            var parameter = $.extend({
                
                object: $(this)
                
            }, parameters);
            
            var desplegar = function(){
                
                var data = [{'name':'Disponible'},{'name':'Caja'}];
            
                var listItems = $.map(data, function(item, index){
                
                    var tbody = $('<tbody></tbody>');
                    tbody.addClass('contentrow');
                    tbody.append('<tr></tr>');
                    tbody.find('tr').append('<td></td>');
                    tbody.find('td').addClass('celd');
                    tbody.find('td').append(item.name);

                    tbody.rowdespl();
                    
                    return tbody;
                
                }); 
                
                parameter.object.append(listItems);
                
            
            }; 
            
            parameter.object.find(".celd").on("click", desplegar);
        
        });
        
    }
    
}(jQuery));

$(document).ready(function(){
    /*$(".despl").click(function(){
        var activo= '<tbody><tbody><tr><td class="despl disponible">Disponible</td></tr></tbody><tr><td class="grupos">Inversiones</td></tr><tr><td class="grupos">Deudores</td></tr><tr><td class="grupos">Inventarios</td></tr></tbody><script>$(".despl").click(function()<script/>';
        var disponible= '<tr><td class="cuentas">Caja</td></tr><tr><td class="cuentas">bancos</td></tr><tr><td class="cuentas">Remesas de tránsito</td></tr><tr><td class="cuentas">Cuentas de ahorro</td></tr>';
        if($(this).hasClass('activo')){
            $(this).parent().parent().append(activo);
        }else if ($(this).hasClass('disponible')){
            $(this).parent().parent().append(disponible);
        }
        if ($(this).find("span").hasClass("icon-plus")){
            $(this).find("span").removeClass("icon-plus");
            $(this).find("span").addClass("icon-minus");
        }else if ($(this).find("span").hasClass("icon-minus")){
            $(this).find("span").removeClass("icon-minus");
            $(this).find("span").addClass("icon-plus");}
    });
    
    
      $(".despl").click(function(){
        var pasivo= '<tbody><tbody><tr><td class="despl obligaciones">Obligaciones financieras</td></tr></tbody><tr><td class="grupos">Proveedores</td></tr><tr><td class="grupos">Cuentas por pagar</td></tr><tr><td class="grupos">Impuestos, gravámenes y tasas</td></tr></tbody>';
        var obligaciones= '<tr><td class="cuentas">Bancos nacionales</td></tr><tr><td class="cuentas">Bancos del exterior</td></tr><tr><td class="cuentas">Corporaciones financieras</td></tr><tr><td class="cuentas">Compañias de financiamiento comercial </td></tr>';
        if($(this).hasClass('pasivo')){
            $(this).parent().parent().append(pasivo);
        }else if ($(this).hasClass('obligaciones')){
            $(this).parent().parent().append(obligaciones);
        }
        
    });*/
    
    $('.contentrow').rowdespl();
    
    $('.celd').click(function(){
        $('.descripcion').fadeToggle(100);
    });
       
});

