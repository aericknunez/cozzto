$(document).ready(function()
{
	$('#btn-config').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=10",
			method: "POST",
			data: $("#form-config").serialize(),
			success: function(data){
				$("#ventana").html(data);
				window.location.href="?configuraciones";
			}
		})
	})
$("#form-config").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});

	$('#btn-root').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=11",
			method: "POST",
			data: $("#form-root").serialize(),
			success: function(data){
				$("#ventana").html(data);
				window.location.href="?root";
			}
		})
	})
$("#form-root").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});



	$("body").on("click","#tablemod",function(){ // borrar categoria
	var op = $(this).attr('op');
	var tabla = $(this).attr('tabla');
	var accion = $(this).attr('accion');
	    $.post("application/src/routes.php", {op:op, tabla:tabla, accion:accion}, function(data){
		$("#contenido").html(data);
	   	 });
	});




});
