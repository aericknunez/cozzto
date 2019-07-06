<?php
include_once '../application/common/Helpers.php'; // [Para todo]
include_once '../application/includes/variables_db.php';
include_once '../application/includes/db_connect.php';
include_once '../application/includes/functions.php';
sec_session_start();
include_once '../application/common/Fechas.php';
include_once '../application/common/Mysqli.php';
$db = new dbConn();

// busco el numero de local

    if ($r = $db->select("td", "config_root", "WHERE id = 1")) { 
        $_SESSION["temporal_td"] = $r["td"];
    } unset($r);  



if($_REQUEST["fecha"] == NULL){
	$fecha = date("d-m-Y");
} else {
	$fecha = $_REQUEST["fecha"];
}

//////// si hay un respaldo y hay que eliminarlo
if($_REQUEST["delete"] == 1){
$db->delete("sync_status", "WHERE tipo = 1 and fecha= '$fecha' and td =".$_SESSION["temporal_td"]."");	
}

// 1 = tablas diarias , 2 = tablas estaticas, 3 ambas
if($_REQUEST["type"] == NULL){
	$type = 1;
} else {
	$type = $_REQUEST["type"];
}


// debo eliminar todos los archivos que no se subieron pero que no sean respaldo
    $as = $db->query("SELECT * FROM sync_status WHERE tipo = 5 and ejecutado = 0 and td = ".$_SESSION["temporal_td"]."");
    foreach ($as as $bs) {

	        $sync = $bs["hash"];
	    	$fichero = $sync . ".sql";

			if (file_exists($fichero)){ 
					$db->delete("sync_status", "WHERE hash= '$sync' and td =".$_SESSION["temporal_td"]."");
					@unlink($fichero);
			}

    } $as->close();



/////////// RESPALDAR ////////

include_once '../system/sync/Upload.php';
$sincro =  new Upload;
$sync = $sincro->Sync($fecha,$type);

if($sync != NULL){
	if(SubirFtp($sync) == TRUE){
		$cambio = array();
		$cambio["subido"] = 1;
    	$cambio["ejecutado"] = 1;
		if($db->update("sync_status", $cambio, "WHERE hash = '$sync' and td = ".$_SESSION["temporal_td"]."")){
		 @unlink($sync . ".sql");	
		}
	}
 

} 
unset($_SESSION["temporal_td"]);


if($fecha == date("d-m-Y") and $type == 1){
echo '<script>
window.location.href="?corte"
</script>';
} else {
echo '<script>
window.location.href="?respaldos"
</script>';
}



function SubirFtp($sync){
	include_once '../system/sync/Ftp.php';
		$subir =  new Ftp;
		if($subir->Servidor("ftp.pizto.com",
						"erick@pizto.com",
						"caca007125-",
						$sync . ".sql",
						"/admin/sync/db/",
						"C:/AppServ/www/pizto/sync/". $sync .".sql") == TRUE){
						return TRUE;
		} else {
			return FALSE;
		}
}