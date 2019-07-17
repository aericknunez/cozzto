$(document).ready(function(){

	$('#btn-addcliente').click(function(e){ /// para el formulario
	$('#btn-addcliente').addClass('disabled');
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=64",
			method: "POST",
			data: $("#form-addcliente").serialize(),
			success: function(data){
				$("#form-addcliente").trigger("reset");
				$("#destinocliente").html(data);			
				setTimeout(BotonEnable, 1000); // para desactivar elboton por un rato
			}
		})
	})
    

    function BotonEnable(){
        $('#btn-addcliente').removeClass("disabled");
    }


	$("#form-addcliente").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});



	$("body").on("click","#delcliente",function(){ // borrar categoria
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
	    $.post("application/src/routes.php", {op:op, iden:iden}, function(data){
		$("#destinocliente").html(data);
	   	 });
	});


////////////////
	$('#btn-editcliente').click(function(e){ /// actualizar proveedor
	$('#btn-editcliente').addClass('disabled');
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=67",
			method: "POST",
			data: $("#form-editcliente").serialize(),
			success: function(data){
				$("#form-editcliente").trigger("reset");
				$("#destinocliente").html(data);			
				setTimeout(BotonEnable, 1000); // para desactivar elboton por un rato
			}
		})
	})
    

    function BotonEnable(){
        $('#btn-editcliente').removeClass("disabled");
    }


	$("#form-editcliente").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});



}); // termina query