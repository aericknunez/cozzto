$(document).ready(function()
{



//// monitorear los respaldos
    function ActualizarSistema(){
        $.ajax({
            type: "POST",
            url: "application/src/routes.php?op=164",
            success: function(data) {
            	$('#mostrar').html(data);
            }
        });
    }

//SyncMonitor();
ActualizarSistema()
///
	$("body").on("click","#actualizar",function(){
	$("#mostrar").hide();
	MuestraLoader();
	var op = $(this).attr('op');
	var iden = $(this).attr('iden');
    	$.post("application/src/routes.php", {op:op}, 
    	function(data){
    	$("#mostrar").show();
		$("#mostrar").html(data);
		EscondeLoader();
   	 	});
	});


// quita el loader
	EscondeLoader();
	function EscondeLoader(){
		$("#loaderx").hide();
	}

// muestra loader
	function MuestraLoader(){
		$("#loaderx").show();
	}






});