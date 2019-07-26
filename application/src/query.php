<?php
defined('BASEPATH') OR exit('No direct script access allowed');

$numero = rand(1,9999999999);
//$numero = 1;

if(isset($_GET["modal"])) { 
echo '
	<script>
		$(document).ready(function()
		{
		  $("#' . $_GET["modal"] . '").modal("show");
		});
	</script>
	';

	if($_GET["modal"] == "register_success"){
	echo '<script type="text/javascript" src="assets/js/query/user.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "avatar"){
	echo '<script type="text/javascript" src="assets/js/query/user.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "conf_config"){
	echo '<script type="text/javascript" src="assets/js/query/conf_config.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "conf_root"){
	echo '<script type="text/javascript" src="assets/js/query/conf_config.js?v='.$numero.'"></script>';
	}
	if($_GET["modal"] == "img_negocio"){
	echo '<script type="text/javascript" src="assets/js/query/img_negocio.js?v='.$numero.'"></script>';
	}

	/// producto
	if($_GET["modal"] == "proadd"){
	echo '<script type="text/javascript" src="assets/js/query/modal.producto.js?v='.$numero.'"></script>';
	}

	/// proveedor
	if($_GET["modal"] == "editproveedor"){
	echo '<script type="text/javascript" src="assets/js/query/proveedor.js?v='.$numero.'"></script>';
	}
	/// Cliente
	if($_GET["modal"] == "editcliente"){
	echo '<script type="text/javascript" src="assets/js/query/cliente.js?v='.$numero.'"></script>';
	}

} // termina modal

//config
elseif(isset($_GET["tablas"])) {
echo '<script type="text/javascript" src="assets/js/query/conf_config.js?v='.$numero.'"></script>';
} 


elseif(isset($_GET["user"])) {
echo '<script type="text/javascript" src="assets/js/query/user.js?v='.$numero.'"></script>';
} 

/// producto
elseif(isset($_GET["proadd"])) {
echo '<script type="text/javascript" src="assets/js/query/producto.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["proopciones"])) {
echo '<script type="text/javascript" src="assets/js/query/proopciones.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["proup"])) {
echo '<script type="text/javascript" src="assets/js/query/producto.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["proagregar"])) {
echo '<script type="text/javascript" src="assets/js/query/producto.js?v='.$numero.'"></script>';
}
elseif(isset($_GET["proaverias"])) {
echo '<script type="text/javascript" src="assets/js/query/producto.js?v='.$numero.'"></script>';
} 


//////////////// proveedor
elseif(isset($_GET["proveedoradd"])) {
echo '<script type="text/javascript" src="assets/js/query/proveedor.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["proveedorver"])) {
echo '
<script type="text/javascript" src="assets/js/addons/datatables.min.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/proveedordatatable.js?v='.$numero.'"></script>';
} 

//////////////// cliente
elseif(isset($_GET["clienteadd"])) {
echo '<script type="text/javascript" src="assets/js/query/cliente.js?v='.$numero.'"></script>';
} 
elseif(isset($_GET["clientever"])) {
echo '
<script type="text/javascript" src="assets/js/addons/datatables.min.js?v='.$numero.'"></script>
<script type="text/javascript" src="assets/js/query/clientedatatable.js?v='.$numero.'"></script>';
} 


else{
/// lo que llevara index
//echo '<script type="text/javascript" src="assets/js/query/ventas.js?v='.$numero.'"></script>';

	if($venta == TRUE){ // si es en venta
	echo '<script type="text/javascript" src="assets/js/query/venta.js?v='.$numero.'"></script>';
	}

}
	
?>

<!-- <script>
$("body").on("click","#cambiar",function(){
        var op = $(this).attr('op');
        $.post("application/src/routes.php", {op:op}, 
        function(htmlexterno){
            window.location.href="?";
        });
    });	

// preloader
    $(window).on("load", function () {
        $('#mdb-preloader').fadeOut('fast');
    });

</script> -->
