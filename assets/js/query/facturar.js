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


	$("#search-box-rtn").keyup(function(){ /// para la caja de busqueda
			$.ajax({
			type: "POST",
			url: "application/src/routes.php?op=132",
			data:'keyword='+$(this).val(),
			beforeSend: function(){
				$("#search-box-rtn").css("background","#FFF url(assets/img/LoaderIcon.gif) no-repeat 165px");
			},
			success: function(data){
				$("#resultado").show();
				$("#resultado").html(data);
				$("#search-box-rtn").css("background","#FFF");
			}
			});
		});
		function selectProducto(val) {
		$("#search-box-rtn").val(val);
		$("#resultado").hide();
	}




	$("body").on("click","#ver-rtn",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op, iden:iden}, 
    	function(htmlexterno){
		$("#resultado").html(htmlexterno);
   	 	});
	});


	$("body").on("click","#quitar-rtn",function(){ // quita
	var op = $(this).attr('op');
    	$.post("application/src/routes.php", {op:op}, 
    	function(htmlexterno){
		$("#resultado").html(htmlexterno);
   	 	});
	});


	$("body").on("click","#eliminarx",function(){ // pregunta elimanar
	var op = $(this).attr('op');
	var idx = $(this).attr('idx');
	var opx = $(this).attr('opx');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op,idx:idx,opx:opx,iden:iden}, 
    	function(htmlexterno){
		$("#resultado").html(htmlexterno);
   	 	});
	});

	$("body").on("click","#eliminar",function(){ // elimina
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op,iden:iden}, 
    	function(htmlexterno){
		$("#resultado").html(htmlexterno);
   	 	});
	});

	$('#btn-rtn').click(function(e){ /// para el formulario agregar rtn
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=135",
			method: "POST",
			data: $("#form-rtn").serialize(),
			success: function(data){
				$("#resultado").html(data);
				$("#form-rtn").trigger("reset");
			}
		})
	})
$("#form-rtn").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});




	$('#btn-cai').click(function(e){ /// para el formulario agregar rtn
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=138",
			method: "POST",
			data: $("#form-cai").serialize(),
			success: function(data){
				$("#resultado").html(data);
				$("#form-cai").trigger("reset");
			}
		})
	})
$("#form-cai").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});




	$('#btn-factura').click(function(e){ /// para el formulario agregar rtn
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=140",
			method: "POST",
			data: $("#form-factura").serialize(),
			success: function(data){
				$("#facturas").html(data);
				$("#form-factura").trigger("reset");
			}
		})
	})
$("#form-factura").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});



	$('#btn-impresora').click(function(e){ /// para el formulario agregar rtn
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=141",
			method: "POST",
			data: $("#form-impresora").serialize(),
			success: function(data){
				$("#impresoras").html(data);
				$("#form-impresora").trigger("reset");
			}
		})
	})
$("#form-impresora").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});




	$('#btn-usuarios').click(function(e){ /// para el formulario agregar rtn
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=142",
			method: "POST",
			data: $("#form-usuarios").serialize(),
			success: function(data){
				$("#usuarios").html(data);
				$("#form-usuarios").trigger("reset");
			}
		})
	})
$("#form-usuarios").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});





	$("body").on("click","#eliminarf",function(){ // elimina
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op,iden:iden}, 
    	function(htmlexterno){
		$("#facturas").html(htmlexterno);
   	 	});
	});



	$("body").on("click","#eliminari",function(){ // elimina
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op,iden:iden}, 
    	function(htmlexterno){
		$("#impresoras").html(htmlexterno);
   	 	});
	});

		$("body").on("click","#eliminaru",function(){ // elimina
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op,iden:iden}, 
    	function(htmlexterno){
		$("#usuarios").html(htmlexterno);
   	 	});
	});







//////////////// eliminar la factura
	$("body").on("click","#eliminar-factura",function(){
	var op = $(this).attr('op');
	var num_fac = $(this).attr('num_fac');
	var mesa = $(this).attr('mesa');
    	$.post("application/src/routes.php", {op:op, num_fac:num_fac, mesa:mesa}, 
    	function(htmlexterno){
		$("#resultado").html(htmlexterno);
   	 	});
	});







});