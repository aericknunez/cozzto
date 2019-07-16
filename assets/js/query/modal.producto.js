$(document).ready(function(){


		$('.datepicker').pickadate({
		  weekdaysShort: ['Do', 'Lu', 'Ma', 'Mi', 'Ju', 'Vi', 'Sa'],
		  weekdaysFull: ['Domingo', 'Lunes', 'Martes', 'Miercoles', 'Jueves', 'Viernes', 'Sabado'],
		  monthsFull: ['Enero', 'Febrero', 'Marzo', 'Abril', 'Mayo', 'Junio', 'Julio', 'Agosto', 'Septiembre', 'Octubre',
		  'Noviembre', 'Diciembre'],
		  monthsShort: ['Ene', 'Feb', 'Mar', 'Abr', 'May', 'Jun', 'Jul', 'Ago', 'Sep', 'Oct',
		  'Nov', 'Dic'],
		  showMonthsShort: true,
		  formatSubmit: 'dd-mm-yyyy',
		  close: 'Cancel'
		})


	$('#btn-preciocosto').click(function(e){ /// para el formulario
	$('#btn-preciocosto').addClass('disabled');
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=21",
			method: "POST",
			data: $("#form-preciocosto").serialize(),
			success: function(data){
				// $("#form-proadd").trigger("reset");
				$("#msj").html(data);			
				setTimeout(BotonEnable, 1000); // para desactivar elboton por un rato
			}
		})
	})
    

    function BotonEnable(){
        $('#btn-preciocosto').removeClass("disabled");
    }


	$("#form-preciocosto").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});





	$('#btn-precios').click(function(e){ /// para el formulario
	$('#btn-precios').addClass('disabled');
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=30",
			method: "POST",
			data: $("#form-precios").serialize(),
			success: function(data){
				$("#form-precios").trigger("reset");
				$("#muestraprecios").html(data);			
				setTimeout(BotonEnable, 1000); // para desactivar elboton por un rato
			}
		})
	})
    

    function BotonEnable(){
        $('#btn-precios').removeClass("disabled");
    }


	$("#form-precios").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});


// borrar un precio de producto
	$("body").on("click","#delprecio",function(){
		var op = $(this).attr('op');
		var iden = $(this).attr('iden');
		var producto = $(this).attr('producto');
	    $.post("application/src/routes.php", {op:op, iden:iden, producto:producto}, function(data){
		$("#muestraprecios").html(data);
	   	 });
	});



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
		$("#producto-busqueda").val(descripcion);
		$("#producto-codigo").val(cod);
		$("#muestra-busqueda").hide();
	});



	$('#btn-compuesto').click(function(e){ /// para el formulario
	$('#btn-compuesto').addClass('disabled');
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=33",
			method: "POST",
			data: $("#form-compuesto").serialize(),
			success: function(data){
				$("#form-compuesto").trigger("reset");
				$("#muestraproductos").html(data);			
				setTimeout(BotonEnable, 1000); // para desactivar elboton por un rato
			}
		})
	})
    

    function BotonEnable(){
        $('#btn-compuesto').removeClass("disabled");
    }


	$("#form-compuesto").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});


// borrar producto compuesto
	$("body").on("click","#delcompuesto",function(){
		var op = $(this).attr('op');
		var iden = $(this).attr('iden');
		var producto = $(this).attr('producto');
	    $.post("application/src/routes.php", {op:op, iden:iden, producto:producto}, function(data){
		$("#muestraproductos").html(data);
	   	 });
	});



	$('#btn-dependiente').click(function(e){ /// para el formulario
	$('#btn-dependiente').addClass('disabled');
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=35",
			method: "POST",
			data: $("#form-dependiente").serialize(),
			success: function(data){
				$("#form-dependiente").trigger("reset");
				$("#muestradependiente").html(data);			
				setTimeout(BotonEnable, 1000); // para desactivar elboton por un rato
			}
		})
	})
    

    function BotonEnable(){
        $('#btn-dependiente').removeClass("disabled");
    }


	$("#form-dependiente").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});


// borrar producto dependiente
	$("body").on("click","#deldependiente",function(){
		var op = $(this).attr('op');
		var iden = $(this).attr('iden');
		var producto = $(this).attr('producto');
	    $.post("application/src/routes.php", {op:op, iden:iden, producto:producto}, function(data){
		$("#muestradependiente").html(data);
	   	 });
	});















////////////////////////////////////////////etiquetas

	$("#etiquetas").keyup(function(){ /// para la caja de busqueda
		$.ajax({
		type: "POST",
		url: "application/src/routes.php?op=37",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#muestra-busqueda").css("background","#FFF url(assets/img/LoaderIcon.gif) no-repeat 165px");
		},
		success: function(data){
			$("#muestra-busqueda").show();
			$("#muestra-busqueda").html(data);
			$("#etiquetas").css("background","#FFF");
		}
		});
	});


	$("body").on("click","#select-tag",function(){
		var tag = $(this).attr('tag');
		$("#etiquetas").val(tag);
		$("#muestra-busqueda").hide();
	});



	$('#btn-etiqueta').click(function(e){ /// para el formulario
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=38",
			method: "POST",
			data: $("#form-etiqueta").serialize(),
			success: function(data){
				$("#form-etiqueta").trigger("reset");
				$("#muestraetiqueta").html(data);			
			}
		})
	})
    



	$("#form-etiqueta").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});



	$("body").on("click","#deltag",function(){
		var op = $(this).attr('op');
		var iden = $(this).attr('iden');
		var producto = $(this).attr('producto');
	    $.post("application/src/routes.php", {op:op, iden:iden, producto:producto}, function(data){
		$("#muestraetiqueta").html(data);
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
				$("#select-ubicacion").load('application/src/routes.php?op=42');			
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
	var iden = $(this).attr('iden');
	    $.post("application/src/routes.php", {op:op, iden:iden}, function(data){
		$("#destinoubicacion").html(data);
		$("#select-ubicacion").load('application/src/routes.php?op=42');
	   	 });
	});

// asignar opciones a producto

	$('#btn-ubicacionasig').click(function(e){ /// para el formulario
	$('#btn-ubicacionasig').addClass('disabled');
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=40",
			method: "POST",
			data: $("#form-ubicacionasig").serialize(),
			success: function(data){
				$("#form-ubicacionasig").trigger("reset");
				$("#muestraubicacionasig").html(data);			
				setTimeout(BotonEnable, 1000); // para desactivar elboton por un rato
			}
		})
	})
    

    function BotonEnable(){
        $('#btn-ubicacionasig').removeClass("disabled");
    }


	$("#form-ubicacionasig").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});

	$("body").on("click","#delubicacionasig",function(){
		var op = $(this).attr('op');
		var iden = $(this).attr('iden');
		var producto = $(this).attr('producto');
	    $.post("application/src/routes.php", {op:op, iden:iden, producto:producto}, function(data){
		$("#muestraubicacionasig").html(data);
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
				$("#select-caracteristica").load('application/src/routes.php?op=45');		
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
	var iden = $(this).attr('iden');
	    $.post("application/src/routes.php", {op:op, iden:iden}, function(data){
		$("#destinocaracteristica").html(data);
		$("#select-caracteristica").load('application/src/routes.php?op=45');
	   	 });
	});


// asignar caracteristicass a producto

	$('#btn-caracteristicasasig').click(function(e){ /// para el formulario
	$('#btn-caracteristicasasig').addClass('disabled');
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=43",
			method: "POST",
			data: $("#form-caracteristicasasig").serialize(),
			success: function(data){
				$("#form-caracteristicasasig").trigger("reset");
				$("#muestracaracteristicaasig").html(data);			
				setTimeout(BotonEnable, 1000); // para desactivar elboton por un rato
			}
		})
	})
    

    function BotonEnable(){
        $('#btn-caracteristicasasig').removeClass("disabled");
    }


	$("#form-caracteristicasasig").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});

	$("body").on("click","#delcaracteristicaasig",function(){
		var op = $(this).attr('op');
		var iden = $(this).attr('iden');
		var producto = $(this).attr('producto');
	    $.post("application/src/routes.php", {op:op, iden:iden, producto:producto}, function(data){
		$("#muestracaracteristicaasig").html(data);
	   	 });
	});








}); // termina query