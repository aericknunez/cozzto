$(document).ready(function(){

// busqueda actualizar
	$("#producto-busqueda").keyup(function(){ /// para la caja de busqueda
		$.ajax({
		type: "POST",
		url: "application/src/routes.php?op=75",
		data:'keyword='+$(this).val(),
		beforeSend: function(){
			$("#muestra-busqueda").css("background","#FFF url(assets/img/LoaderIcon.gif) no-repeat 520px");
		},
		success: function(data){
			$("#muestra-busqueda").show();
			$("#muestra-busqueda").html(data);
			$("#producto-busqueda").css("background","#FFF");
		}
		});
	});


	// $("body").on("click","#select-p",function(){
	// 	var cod = $(this).attr('cod');
	// 	var descripcion = $(this).attr('descripcion');
	// 	$("#muestra-busqueda").hide();
	// 	$("#temp-productos").load('application/src/routes.php?op=76&key=' + cod);
	// });



	$("body").on("click","#select-p",function(){
	Mostrar();
	var cod = $(this).attr('cod');
	var descripcion = $(this).attr('descripcion');
    	$.post("application/src/routes.php?op=76", {cod:cod, descripcion:descripcion}, 
    	function(data){
    		$("#muestra-busqueda").hide();
    		$("#temp-productos").html(data); // lo que regresa de la busquea 
		    $("#btn-addform").show();
		    $("#producto-busqueda").trigger("reset"); // no funciona
   	 	});
	});



	$('#btn-addform').click(function(e){ /// agregar un producto 
	Esconder();
	e.preventDefault();
	$.ajax({
			url: "application/src/routes.php?op=80",
			method: "POST",
			data: $("#form-addform").serialize(),
			success: function(data){
				$("#form-addform").trigger("reset");
				$("#ver").html(data);						
			}
		})
	});
    


	$("#form-addform").keypress(function(e) {//Para deshabilitar el uso de la tecla "Enter"
	if (e.which == 13) {
	return false;
	}
	});


function Mostrar(){
	$("#btn-addform").show();
	$("#temp-productos").show();
}

function Esconder(){
	$("#btn-addform").hide();
	$("#temp-productos").hide();
}

Esconder();




	$("body").on("click","#borrar-ticket",function(){
	var op = $(this).attr('op');
	var hash = $(this).attr('hash');
    	$.post("application/src/routes.php", {op:op, hash:hash}, 
    	function(data){
    		$("#ver").html(data); // lo que regresa de la busquea 
   	 	});
	});






}); // termina query