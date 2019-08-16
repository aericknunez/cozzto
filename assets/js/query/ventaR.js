$(document).ready(function(){




    $("body").on("click","#borrar-ticket",function(){
        var op = $(this).attr('op');
		var hash = $(this).attr('hash');
        var dataString = 'op='+op+'&hash='+hash;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#ver").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#ver").html(data); // lo que regresa de la busquea 
                $("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
            }
        });
    });                 



    $("body").on("click","#guardar",function(){
        var op = $(this).attr('op');
		var orden = $(this).attr('orden');
        var dataString = 'op='+op+'&orden='+orden;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#ver").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#ver").html(data); // lo que regresa de la busquea 
                $("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
            }
        });
    });                 




    $("body").on("click","#select-orden",function(){
        var op = $(this).attr('op');
		var orden = $(this).attr('orden');
        var dataString = 'op='+op+'&orden='+orden;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            beforeSend: function () {
               $("#ver").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            },
            success: function(data) {            
                $("#ver").load('application/src/routes.php?op=84'); // ver productos de la orden 
                $("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
            }
        });
    });                 








//// actualiza el lateral cada x segundos
    function GetLateral(){
        $.ajax({
            type: "POST",
            url: "application/src/routes.php?op=70",
            success: function(data) {
            	$('#lateral').html(data);
            }
        });
    }


setInterval(GetLateral, 3000);
///



///////////////////// para venta rapida

	$('#btn-busquedaR').click(function(e){ /// para el formulario
		e.preventDefault();
		$.ajax({
			url: "application/src/routes.php?op=90",
			method: "POST",
			data: $("#form-busquedaR").serialize(),
		// beforeSend: function(){
		// 	$("#ver").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
  //           },
		success: function(data){
			$("#ver").html(data);
			$("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
			$("#form-busquedaR").trigger("reset");
		}
		});
	})




    $("body").on("click","#modcant",function(){
        var op = $(this).attr('op');
		var cod = $(this).attr('cod');
        var dataString = 'op='+op+'&cod='+cod;

        $.ajax({
            type: "POST",
            url: "application/src/routes.php",
            data: dataString,
            // beforeSend: function () {
            //    $("#ver").html('<div class="row justify-content-md-center" ><img src="assets/img/load.gif" alt=""></div>');
            // },
            success: function(data) {            
                $("#ver").load('application/src/routes.php?op=93'); // ver productos de la orden 
                $("#lateral").load('application/src/routes.php?op=70'); // caraga el lateral
            }
        });
    });                 










}); // termina query