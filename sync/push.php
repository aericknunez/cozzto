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


/////////// RESPALDAR ////////

include_once '../system/sync/Push.php';
$pushed =  new Push;
$sync = $pushed->Execute();

if($sync != NULL){
	if(SubirFtp($sync) == TRUE){
		@unlink($sync . ".sql");
	}
} 

unset($_SESSION["temporal_td"]);





function SubirFtp($sync){
	include_once '../system/sync/Ftp.php';
		$subir =  new Ftp;
		if($subir->Servidor("ftp.pizto.com",
						"erick@pizto.com",
						"caca007125-",
						$sync,
						"/admin/sync/database/",
						"C:/AppServ/www/pizto/sync/". $sync .".sql") == TRUE){
						return TRUE;
		} else {
			return FALSE;
		}
}