$(document).ready(function(){

	$('#btn-abono').click(function(e){ /// agregar un producto 
	e.preventDefault();

	var credito = $("#credito").val();
	var factura = $("#factura").val();
	var tx = $("#tx").val();
	
	$.ajax({
			url: "application/src/routes.php?op=105",
			method: "POST",
			data: $("#form-abono").serialize(),
			beforeSend: function () {
				$('#btn-abono').html('<span class="spinner-border spinner-border-sm mr-2" role="status" aria-hidden="true"></span>Loading...').addClass('disabled');
	           // $("#contenido").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
			success: function(data){
				$('#btn-abono').html('Agregar Abono').removeClass('disabled');	      
				$("#form-abono").trigger("reset");
				$("#contenido").html(data);	
				$("#data-abonos").load('application/src/routes.php?op=106&credito='+credito);
				$("#data-total").load('application/src/routes.php?op=107&credito='+credito+'&factura='+factura+'&tx='+tx);				
			}
		})
	});
    




    $("body").on("click","#delabono",function(){
        var op = $(this).attr('op');
		var hash = $(this).attr('hash');
		var credito = $(this).attr('credito');
		var factura = $(this).attr('factura');
		var tx = $(this).attr('tx');
        var dataString = 'op='+op+'&hash='+hash+'&credito='+credito;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#contenido").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#contenido").html(data); // lo que regresa de la busquea 
                $("#data-abonos").load('application/src/routes.php?op=106&credito='+credito);
				$("#data-total").load('application/src/routes.php?op=107&credito='+credito+'&factura='+factura+'&tx='+tx);				
            }
        });
    });                 













}); // termina query