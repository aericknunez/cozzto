<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Fechas.php';
include_once 'application/common/Mysqli.php';
include_once 'system/index/Inicio.php';
include_once 'system/corte/Corte.php';
include_once 'system/ventas/Venta.php';
$db = new dbConn();

unset($_SESSION['client-asign']);	
unset($_SESSION['clientselect']);
unset($_SESSION['view']);

if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5) {
		
if($_SESSION["muestra_vender"] == NULL){
	// aqui va el panel de control
	Inicio::Root();
	Inicio::Admin();

} else {

	if(Corte::UltimaFecha() == date("d-m-Y")){
		Alerts::CorteEcho("ventas");
	} else {
		// aqui para cobrar
				if($_SESSION["tipo_inicio"] == 1){
					//aqui generamos la nueva mesa si no hay creada
					if($_SESSION["mesa"] == NULL){
					$ventas = new Venta;
					$ventas->CrearMesa(1); }

				include_once 'application/iconos/iconos_'.$_SESSION["td"].'.php';
				} else {
				include_once 'system/mesas/mesas.php';
				}
	}
			
}
	










} elseif ($_SESSION["tipo_cuenta"] == 2) {
		
	if($_SESSION["muestra_vender"] == NULL){
		
		// aqui va el panel de control
		Inicio::Admin();

	} else {

		// verificamos primero el tipo cuenta
		if(Corte::UltimaFecha() == date("d-m-Y")){
			Alerts::CorteEcho("ventas");
		} else {
			// aqui para cobrar
			if($_SESSION["tipo_inicio"] == 1){
				//aqui generamos la nueva mesa si no hay creada
					if($_SESSION["mesa"] == NULL){
					$ventas = new Venta;
					$ventas->CrearMesa(1); }
			include_once 'application/iconos/iconos_'.$_SESSION["td"].'.php';
			} else {
			include_once 'system/mesas/mesas.php';
			}
		}			
			
	} // muestra vender


}  elseif ($_SESSION["tipo_cuenta"] == 4) {
	echo '<script>
	window.location.href="?tv"
	</script>';
} else {
			// verificamos primero el tipo cuenta
	if(Corte::UltimaFecha() == date("d-m-Y")){
		Alerts::CorteEcho("ventas");
		} else {
			// aqui para cobrar
			if($_SESSION["tipo_inicio"] == 1){
				//aqui generamos la nueva mesa si no hay creada
					if($_SESSION["mesa"] == NULL){
					$ventas = new Venta;
					$ventas->CrearMesa(1); }
			include_once 'application/iconos/iconos_'.$_SESSION["td"].'.php';
			} else {
			include_once 'system/mesas/mesas.php';
			}
		}
		
}





	
echo '<div id="ventana"></div>';
?>