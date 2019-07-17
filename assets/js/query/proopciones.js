$(document).ready(function(){

/// categorias
	$('#btn-addcategoria').click(function(e){ /// para agregar categoria
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=22",
			method: "POST",
			data: $("#form-addcategoria").serialize(),
			success: function(data){
				$("#form-addcategoria").trigger("reset");
				$("#destinocategoria").html(data);			
			}
		})
	})
    

	$("#form-addcategoria").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});

	$("body").on("click","#delcategoria",function(){ // borrar categoria
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	    $.post("application/src/routes.php", {op:op, hash:hash}, function(data){
		$("#destinocategoria").html(data);
	   	 });
	});






/// Unidades de medida
	$('#btn-addunidad').click(function(e){ /// para agregar categoria
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=24",
			method: "POST",
			data: $("#form-addunidad").serialize(),
			success: function(data){
				$("#form-addunidad").trigger("reset");
				$("#destinounidad").html(data);			
			}
		})
	})
    

	$("#form-addunidad").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});

	$("body").on("click","#delunidad",function(){ // borrar categoria
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	    $.post("application/src/routes.php", {op:op, hash:hash}, function(data){
		$("#destinounidad").html(data);
	   	 });
	});





/// Caracteristicas
	$('#btn-addcarateristica').click(function(e){ /// para agregar categoria
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=26",
			method: "POST",
			data: $("#form-addcarateristica").serialize(),
			success: function(data){
				$("#form-addcarateristica").trigger("reset");
				$("#destinocaracteristica").html(data);			
			}
		})
	})
    

	$("#form-addcarateristica").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});

	$("body").on("click","#delcaracteristica",function(){ // borrar categoria
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	    $.post("application/src/routes.php", {op:op, hash:hash}, function(data){
		$("#destinocaracteristica").html(data);
	   	 });
	});







/// ubicacion
	$('#btn-addubicacion').click(function(e){ /// para agregar ubicacion
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=28",
			method: "POST",
			data: $("#form-addubicacion").serialize(),
			success: function(data){
				$("#form-addubicacion").trigger("reset");
				$("#destinoubicacion").html(data);			
			}
		})
	})
    

	$("#form-addubicacion").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});

	$("body").on("click","#delubicacion",function(){ // borrar ubicacion
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
	    $.post("application/src/routes.php", {op:op, hash:hash}, function(data){
		$("#destinoubicacion").html(data);
	   	 });
	});








}); // termina query