$(document).ready(function(){


	$('#btn-proadd').click(function(e){ /// para el formulario
	$('#btn-proadd').addClass('disabled');
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=20",
			method: "POST",
			data: $("#form-proadd").serialize(),
			success: function(data){
				// $("#form-proadd").trigger("reset");
				$("#msj").html(data);			
				// window.location.href="?modal=proadd&key=0000";
				setTimeout(BotonEnable, 1000); // para desactivar elboton por un rato
			}
		})
	})
    

    function BotonEnable(){
        $('#btn-proadd').removeClass("disabled");
    }


	$("#form-proadd").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});





$(function() { // activar y desactivar los checked despues de darle clic a servicio
			document.getElementById("servicio").onclick = function(){
    			if (document.getElementById("compuesto").disabled){
    				document.getElementById("compuesto").disabled = false
    			}else{
    				document.getElementById("compuesto").disabled = true
    			}

    			if (document.getElementById("caduca").disabled){
    				document.getElementById("caduca").disabled = false
    			}else{
    				document.getElementById("caduca").disabled = true
    			}

    			if (document.getElementById("dependiente").disabled){
    				document.getElementById("dependiente").disabled = false
    			}else{
    				document.getElementById("dependiente").disabled = true
    			}
    		}

});


// busqueda actualizar
	$("#producto-busqueda").keyup(function(){ /// para la caja de busqueda
		$.ajax({
		type: "POST",
		url: "application/src/routes.php?op=32",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#muestra-busqueda").css("background","#FFF url(images/LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#muestra-busqueda").show();
			$("#muestra-busqueda").html(data);
			$("#producto-busqueda").css("background","#FFF");
		}
		});
	});


	$("body").on("click","#select-p",function(){
		var cod = $(this).attr('cod');
		var descripcion = $(this).attr('descripcion');
		$("#muestra-busqueda").hide();
		window.location.href="?proup&key=" + cod;
	});


// formulario actualizar
	$('#btn-proup').click(function(e){ /// para el formulario
	$('#btn-proup').addClass('disabled');
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=46",
			method: "POST",
			data: $("#form-proup").serialize(),
			success: function(data){
				$("#msj").html(data);			
				setTimeout(BotonEnable, 1000); // para desactivar elboton por un rato
			}
		})
	})
    

    function BotonEnable(){
        $('#btn-proup').removeClass("disabled");
    }


	$("#form-proup").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});










}); // termina query