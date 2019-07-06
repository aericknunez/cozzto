$(document).ready(function()
{

// db_sync
	$("body").on("click","#ejecuta-db-sync",function(){
	var op = $(this).attr('op');
	var td = $(this).attr('td');
	var hash = $(this).attr('hash');
    	$.post("application/src/routes.php", {op:op, td:td, hash:hash}, 
    	function(htmlexterno){
		$("#contenido").html(htmlexterno);
   	 	});
	});


	$('#btn-new-hash').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=203",
			method: "POST",
			data: $("#form-new-hash").serialize(),
			success: function(data){
				$("#contenido").html(data);
				$("#form-new-hash").trigger("reset");
			}
		})
	})
$("#form-new-hash").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});







});