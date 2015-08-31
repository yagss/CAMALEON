$(document).ready(function(){
    
    menu("hide");
    
    $(".fieldbox.textbox").animateTextbox();
    $(".fieldbox.select").animateSelect();
    //$(".fieldbox .radiobutton").animateRadiobutton();
    
    $(".btnCloseContent").btnCloseContent({content:$("#contenedor")});
    
});

