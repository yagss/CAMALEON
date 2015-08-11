$(document).ready(menu);

var contador = 1;

function menu(){
	$('.icon-menu').click(function(){
		if (contador == 1) {
			$('.box.menu').animate({
				right:'0'
			});
			contador = 0;
		}  else {
			contador = 1;
			$('.box.menu').animate({
				right:'-100%'
			});
		}
	});

    
};


