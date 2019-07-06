<?php
include_once '../common/Helpers.php';
include_once 'variables_db.php';
include_once 'db_connect.php';
include_once 'functions.php';
sec_session_start();

include_once '../common/Mysqli.php';
$db = new dbConn();
include_once '../common/Fechas.php';
include_once '../../system/index/Inicio.php';

if($_SESSION["mesa"] != NULL){ // para eliminar la masa que viene de index
 include_once '../../system/ventas/Venta.php'; 
    if(Venta::VerProductosMesa($_SESSION["mesa"]) == NULL){
      $db->delete("mesa", "WHERE estado = 1 and mesa = ". $_SESSION["mesa"] ." and tx = ". $_SESSION["tx"] ." and td = " . $_SESSION["td"]);
      unset ($_SESSION["mesa"]);
    }
} // termina mesa

$redirect = $_SESSION['td'];

	if(Helpers::ServerDomain() == TRUE and $_SESSION['tipo_cuenta'] != 1){
	@Inicio::RegisterInOut(2); // registra la salida
	}
	
// Unset all session values 
$_SESSION = array();

// get session parameters 
$params = session_get_cookie_params();

// Delete the actual cookie. 
setcookie(session_name(),'', time() - 42000, $params["path"], $params["domain"], $params["secure"], $params["httponly"]);

// Destroy session 
session_destroy();
if($redirect == 3 and Helpers::ServerDomain() == TRUE){
header("Location: https://superpollo.net");
} else {
header("Location: ../../");
}
	
exit();