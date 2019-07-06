$(document).ready(function()
{

	$("body").on("click","#deluser",function(){
	var op = $(this).attr('op');
	var username = $(this).attr('username');
	var iden = $(this).attr('iden');
    $.post("application/src/routes.php", {op:op, iden:iden, username:username}, function(htmlexterno){
	$("#userinfo").html(htmlexterno);
   	 });

	});


	$('#btn-pass-usuarios').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=1",
			method: "POST",
			data: $("#form-pass-usuarios").serialize(),
			success: function(data){
				$("#caja_user").html(data);
				$("#form-pass-usuarios").trigger("reset");
			}
		})
	})
   
	
	$('#btn-user').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=0",
			method: "POST",
			data: $("#form-user").serialize(),
			success: function(data){
				$("#caja_user").html(data);
				$("#form-user").hide();
				$("#form-user").trigger("reset");
			}
		})
	})
$("#form-user").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});



	$('#btn-actualizar').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=0x",
			method: "POST",
			data: $("#form-actualizar").serialize(),
			success: function(data){
				$("#caja_user").html(data);
				//$("#form-actualizar").trigger("reset");
			}
		})
	})
$("#form-actualizar").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});




// cambiar avatar
	$("body").on("click","#cambiar-avatar",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
	var user = $(this).attr('user');
    $.post("application/src/routes.php", {op:op, iden:iden, user:user}, function(data){
	$("#avatar-select").html(data);
   	 });

	});


});