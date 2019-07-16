$(document).ready(function(){


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
		$("#muestra-busqueda").hide();
		window.location.href="?proup=&key=" + cod;
	});





}); // termina query