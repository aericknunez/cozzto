<?php
include_once '../application/common/Helpers.php'; // [Para todo]
include_once '../application/includes/variables_db.php';
include_once '../application/includes/db_connect.php';
include_once '../application/includes/functions.php';
sec_session_start();
include_once '../application/common/Fechas.php';
include_once '../application/common/Mysqli.php';
$db = new dbConn();

$fecha = date("d-m-Y");

// busco el numero de local


    if ($r = $db->select("td", "config_root", "WHERE id = 1")) { 
        $_SESSION["temporal_td"] = $r["td"];
    } unset($r);  


///////////////////////busco si hay que crear archivos de configuracion (2)
    if ($ra = $db->select("actualizar", "alter_opciones", "WHERE td = ".$_SESSION["temporal_td"]."")) { 
        $configuracion = $ra["actualizar"];
    } unset($ra); 

if($configuracion == 1){ // si es igual a 1 hay que crear actualizacion

$conf = $db->query("SELECT * FROM sync_status WHERE tipo = 2 and ejecutado = 0 and td = ".$_SESSION["temporal_td"]."");
    foreach ($conf as $confi) {

	        $sync = $confi["hash"];
	    	$fichero = $sync . ".sql";

		    $db->delete("sync_status", "WHERE hash='$sync'");	    	
			if (file_exists($fichero)){ 
			@unlink($fichero); }

    } $conf->close();

/////////// RESPALDAR ////////

include_once '../system/sync/Upload.php';
$sincro =  new Upload;
$sync = $sincro->Sync($fecha,2);

if($sync != NULL){
	if(SubirFtp($sync) == TRUE){
		$cambio = array();
		$cambio["subido"] = 1;
    	$cambio["ejecutado"] = 1;
		if($db->update("sync_status", $cambio, "WHERE hash = '$sync' and td = ".$_SESSION["temporal_td"]."")){
		 @unlink($sync . ".sql");	
		}
	}

} // termina respaldar

	$cambio = array();
	$cambio["actualizar"] = 0;
	$db->update("alter_opciones", $cambio, "WHERE td = ".$_SESSION["temporal_td"]."");
} /// termina actualizacion


////////////////////






/////////// antes de sincronizar, mete los datos a la bd
$archx = $_SESSION["temporal_td"] . ".sql";

if (file_exists($archx)) {
    $sql = explode(";",file_get_contents($archx));//
	foreach($sql as $query){
	@$db->query($query);
	}
	@unlink($archx);
}



////////// verifico que aun no se haya echo corte y respaldo

$vc = $db->query("SELECT * FROM sync_status WHERE tipo = 1 and fecha = '$fecha' and td = ".$_SESSION["temporal_td"]."");
if($vc->num_rows > 0){ // verifico si ya se subio, sino lo subo

// busca todos los respaldo no subidos y los sube
    $as = $db->query("SELECT * FROM sync_status WHERE tipo = 1 and tipo = 2 and ejecutado = 0 and td = ".$_SESSION["temporal_td"]."");
    foreach ($as as $bs) {

	        $sync = $bs["hash"];
	    	$fichero = $sync . ".sql";

			if (file_exists($fichero)){ 

					if(SubirFtp($bs["hash"]) == TRUE){
					$cambio = array();
					$cambio["subido"] = 1;
			    	$cambio["ejecutado"] = 1;
					if($db->update("sync_status", $cambio, "WHERE hash = '$sync' and td = ".$_SESSION["temporal_td"]."")){
					 @unlink($sync . ".sql");	
					}
				}

			}

    } $as->close();

} else{



// busca todos los respaldo no subidos y los sube
    $aw = $db->query("SELECT * FROM sync_status WHERE ejecutado = 0 and td = ".$_SESSION["temporal_td"]."");
    foreach ($aw as $bw) {

    	$sync = $bw["hash"];
    	$fichero = $sync . ".sql";

			if (file_exists($fichero)){ 

					if(SubirFtp($bw["hash"]) == TRUE){
					$cambio = array();
					$cambio["subido"] = 1;
			    	$cambio["ejecutado"] = 1;
					if($db->update("sync_status", $cambio, "WHERE hash = '$sync' and td = ".$_SESSION["temporal_td"]."")){
					 @unlink($sync . ".sql");	
					}
				}

			}
  
    } 
    unset($sync); 
    $aw->close();

/////////// SINCRONIZAR ////////

include_once '../system/sync/Sincronizar.php';
$sincro =  new Sincronizar;
$sync = $sincro->Sync($fecha);

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




}
$vc->close();
unset($_SESSION["temporal_td"]);


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