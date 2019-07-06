$(document).ready(function()
{

	$('#btn-gastos').click(function(e){ /// para el formulario
		$('#btn-gastos').addClass('disabled');
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=28",
			method: "POST",
			data: $("#form-gastos").serialize(),
			success: function(data){
				$("#form-gastos").trigger("reset");
				$("#gastos").html(data);			
				setTimeout(BotonEnable, 2000); // para desactivar elboton por un rato
		
			}
		})
	})
    

    function BotonEnable(){
        $('#btn-gastos').removeClass("disabled");
    }


$("#form-gastos").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
if (e.which == 13) {
return false;
}
});



	$("body").on("click","#borrar-gasto",function(){
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op, iden:iden}, 
    	function(htmlexterno){
		$("#gastos").html(htmlexterno);
   	 	});
	});





});