$(document).ready(function(){

	$('#btn-facturar').click(function(e){ /// agregar un producto 
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=85",
			method: "POST",
			data: $("#form-facturar").serialize(),
			beforeSend: function () {
				$("#formularios").hide();
               $("#resultado").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
			success: function(data){
				$("#form-facturar").trigger("reset");
				$("#formularios").hide();
				$("#resultado").html(data);					
			}
		})
	});
    


}); // termina query