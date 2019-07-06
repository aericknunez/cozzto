<?php
date_default_timezone_set('America/El_Salvador');

define("HOST", "localhost"); 			//35.225.56.157 The host you want to connect to. 
define("USER", "superpol_erick"); 			// The database username. 
define("PASSWORD", "caca007125-"); 	// The database password. 
define("DATABASE", "superpol_pizto");  

require_once("/home/superpol/public_html/pizto.com/admin/application/common/Mysqli.php");
$db = new dbConn();



// busca todos los archivos en el directorio
$archivos = glob("/home/superpol/public_html/pizto.com/admin/sync/db/*.sql");  
  foreach($archivos as $data){ 

  	$data = str_replace("/home/superpol/public_html/pizto.com/admin/sync/db/", "", $data);
  	$hash = str_replace(".sql", "", $data);

    $archx = "/home/superpol/public_html/pizto.com/admin/sync/db/" . $data;            

// obtener el td y type del archivo
    $fecha = date("d-m-Y");
  	$numero = strpos($hash, "-"); // extrae caracteres antes de -
	$td = substr($hash,0,$numero); // extrae el td
	$countc = strlen($td); // cuenta el numero de caracteres de td
	$type = substr($hash,$countc+1,1); // el numero de caracteres depues de td -


//td-type-hash


// primero compruebo si es 1 o 5, respaldo o sincronizcion
	if($type == 5){
		// compruebo si ya hay backup tipo 1 del sync del dia y td
		$a = $db->query("SELECT * FROM login_sync WHERE fecha = '$fecha' and tipo = 1 and td = '$td'");
		if($a->num_rows == 0){ // si no hay un respaldo
			if (file_exists($archx)) {
		    $sql = explode(";",file_get_contents($archx));//
			foreach($sql as $query){
			@$db->query($query);
			} @unlink($archx); } 

		} else { // si hay respaldo
		    @unlink($archx);	
		}


	} else {

		// si no es sincronizacion lo ejecuto siempre
			if (file_exists($archx)) {
		    $sql = explode(";",file_get_contents($archx));//
			foreach($sql as $query){
			@$db->query($query);
			} @unlink($archx); } 


	} // termina comprobacion si es sincronizacion o backup




} // termina busqueda de archivos en la carpeta