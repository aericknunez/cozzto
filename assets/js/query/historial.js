$(document).ready(function()
{

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


	$('#btn-diario').click(function(e){ /// para el formulario
		$("#form-diario").hide();
		MuestraLoader();
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=70",
			method: "POST",
			data: $("#form-diario").serialize(),
			success: function(data){
				$("#contenido").html(data);
				$("#form-diario").trigger("reset");
				$("#form-diario").show();
				EscondeLoader();
			}
		})
	})
	
	


	$('#btn-mensual').click(function(e){ /// para el formulario
		$("#form-mensual").hide();
		MuestraLoader();
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=71",
			method: "POST",
			data: $("#form-mensual").serialize(),
			success: function(data){
				$("#contenido").html(data);
				$("#form-mensual").trigger("reset");
				$("#form-mensual").show();
				EscondeLoader();
			}
		})
	})



	$('#btn-cortes').click(function(e){ /// para el formulario
		$("#form-cortes").hide();
		MuestraLoader();
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=72",
			method: "POST",
			data: $("#form-cortes").serialize(),
			success: function(data){
				$("#contenido").html(data);
				$("#form-cortes").trigger("reset");
				$("#form-cortes").show();
				EscondeLoader();
			}
		})
	})



/////////////////////////////////
	$('#btn-gdiario').click(function(e){ /// para el formulario
		$("#form-gdiario").hide();
		MuestraLoader();
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=73",
			method: "POST",
			data: $("#form-gdiario").serialize(),
			success: function(data){
				$("#contenido").html(data);
				$("#form-gdiario").trigger("reset");
				$("#form-gdiario").show();
				EscondeLoader();
			}
		})
	})
	
	


	$('#btn-gmensual').click(function(e){ /// para el formulario
		$("#form-gmensual").hide();
		MuestraLoader();
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=74",
			method: "POST",
			data: $("#form-gmensual").serialize(),
			success: function(data){
				$("#contenido").html(data);
				$("#form-gmensual").trigger("reset");
				$("#form-gmensual").show();
				EscondeLoader();
			}
		})
	})




	$('#btn-fechas').click(function(e){ /// para el formulario
		$("#form-fechas").hide();
		MuestraLoader();
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=75",
			method: "POST",
			data: $("#form-fechas").serialize(),
			success: function(data){
				$("#contenido").html(data);
				$("#form-fechas").trigger("reset");
				$("#form-fechas").show();
				EscondeLoader();
			}
		})
	})


	$('#btn-inout').click(function(e){ /// para el formulario
		$("#form-inout").hide();
		MuestraLoader();
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=76",
			method: "POST",
			data: $("#form-inout").serialize(),
			success: function(data){
				$("#contenido").html(data);
				$("#form-inout").trigger("reset");
				$("#form-inout").show();
				EscondeLoader();
			}
		})
	})
	



// quita el loader
	EscondeLoader();
	function EscondeLoader(){
		$("#loaderx").hide();
	}

// muestra loader
	function MuestraLoader(){
		$("#loaderx").show();
	}






});