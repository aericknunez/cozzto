$(document).ready(function(){

	$('#btn-addproveedor').click(function(e){ /// para el formulario
	$('#btn-addproveedor').addClass('disabled');
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=60",
			method: "POST",
			data: $("#form-addproveedor").serialize(),
			success: function(data){
				$("#form-addproveedor").trigger("reset");
				$("#destinoproveedor").html(data);			
				setTimeout(BotonEnable, 1000); // para desactivar elboton por un rato
			}
		})
	})
    

    function BotonEnable(){
        $('#btn-addproveedor').removeClass("disabled");
    }


	$("#form-addproveedor").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});



	$("body").on("click","#delproveedor",function(){ // borrar categoria
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	    $.post("application/src/routes.php", {op:op, hash:hash}, function(data){
		$("#destinoproveedor").html(data);
	   	 });
	});


////////////////
	$('#btn-editproveedor').click(function(e){ /// actualizar proveedor
	$('#btn-editproveedor').addClass('disabled');
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=63",
			method: "POST",
			data: $("#form-editproveedor").serialize(),
			success: function(data){
				$("#form-editproveedor").trigger("reset");
				$("#destinoproveedor").html(data);			
				setTimeout(BotonEnable, 1000); // para desactivar elboton por un rato
			}
		})
	})
    

    function BotonEnable(){
        $('#btn-editproveedor').removeClass("disabled");
    }


	$("#form-editproveedor").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});



}); // termina query