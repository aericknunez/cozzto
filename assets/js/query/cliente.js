$(document).ready(function(){

	$('#btn-addcliente').click(function(e){ /// para el formulario
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=64",
			method: "POST",
			data: $("#form-addcliente").serialize(),
			success: function(data){
				$("#form-addcliente").trigger("reset");
				$("#destinocliente").html(data);			

			}
		})
	})
    


	$("#form-addcliente").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});



	$("body").on("click","#delcliente",function(){ // borrar categoria
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	    $.post("application/src/routes.php", {op:op, hash:hash}, function(data){
		$("#destinocliente").html(data);
	   	 });
	});


////////////////
	$('#btn-editcliente').click(function(e){ /// actualizar proveedor
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=67",
			method: "POST",
			data: $("#form-editcliente").serialize(),
			success: function(data){
				$("#form-editcliente").trigger("reset");
				$("#destinocliente").html(data);			
			}
		})
	})
    



	$("#form-editcliente").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});



}); // termina query