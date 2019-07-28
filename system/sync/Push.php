<?php 
class Push{

	public function __construct(){

	}


	public function Execute(){
		
		if($this->VerificarCorteHoy(date("d-m-Y")) != TRUE){
			$_SESSION["now"] =  $this->Now();
			$_SESSION["last_update"] =  $this->LastUpdate();	

			$archivo.= $this->CreateDeleteIds($_SESSION["last_update"], $_SESSION["now"]);
			$archivo.= $this->CreateUploads($_SESSION["last_update"], $_SESSION["now"]);

			return $this->SaveSync($archivo);
			$this->BorroSession();
		}


	}

/// verificar corte
	public function VerificarCorteHoy($fecha){
	    $db = new dbConn();

		$a = $db->query("SELECT * FROM corte_diario 
			WHERE fecha = '$fecha' and td = ".$_SESSION["temporal_td"]."");
		if($a->num_rows > 0){
			return TRUE;
		} else {
			return FALSE;
		} $a->close();

	}
/// crear una fecha de NOW

	public function Now(){
		return Helpers::TimeId();
	}


	public function LastUpdate(){
	    $db = new dbConn();
	    if ($r = $db->select("final", "sync_up", "WHERE creado = 1 and td = ".$_SESSION["temporal_td"]." order by final desc")) { 
	        return $r["final"];
	    } unset($r);  
	}
///  obtengo los registros a borrar y actulizar de ///  sync_tables_updates // y le doy la orden de borrar esos registros

	public function CreateDeleteIds($inicio, $final){
	    $db = new dbConn();

	    $a = $db->query("SELECT * FROM sync_tables_updates WHERE time BETWEEN '$inicio' AND '$final' and td = ".$_SESSION["temporal_td"]."");
	    foreach ($a as $b) { /// aqui creo los primero delete si es que existen
	        
	        $archivo.= 'DELETE FROM '.$b["tabla"].' WHERE hash = "'.$b["hash"].'" and td = "' . $_SESSION["temporal_td"] .'"'; $archivo.= ";\n";

	    } $a->close();

	    return $archivo;
	}

///  recorro todas las tablas en busca de cuales registros se van a crear sync_tabla
///  estos se hace obteniendo el ultimo update hasta now

	public function CreateUploads($inicio, $final){
	    $db = new dbConn();

	    $a = $db->query("SELECT * FROM sync_tabla WHERE edo = 1 and td = ".$_SESSION["temporal_td"]."");
	    foreach ($a as $b) { /// aqui recorro una por una las tablas con obteniendo registros
	
	    	$tabla = $b["tabla"];
	//////////////////////        
		    $s = $db->query("SELECT * FROM $tabla WHERE time BETWEEN '$inicio' AND '$final' and td = ".$_SESSION["temporal_td"]."");
				foreach ($s as $y){ 
		    $archivo.= "INSERT INTO $tabla VALUES(";
		    	// especifico los campos
	        	   $fields = $db->listFields($tabla);
				    $arrlength = count($fields);
				    for($x = 0; $x < $arrlength; $x++) {
				        $campo = $fields[$x]['name'];

			if($campo == "id") $archivo.= "\"\", ";
			elseif($campo == "td") $archivo.= "\"" .$y["$campo"] . "\"";
			else $archivo.= "\"" . $y["$campo"] . "\", ";

				    }
				$archivo.= "); \n";
		    } $s->close();
/////////////////////////////////
	    } $a->close();

	    return $archivo;
	}

// Huardo los resultados
	public function SaveSync($archivo){ // guardo el archivo a sincronizar creado
		$db = new dbConn();

		   	 	$hora = date("H:i:s");
		   	 	$fecha = date("d-m-Y");
		   	 	$hash = $fecha."-".$hora ."-" . $_SESSION["temporal_td"];
		   	 	$hash = md5($hash);
		   	 	$hash = $_SESSION["temporal_td"] . "-" . $hash;

		   $handle = fopen($hash . ".sql",'w+');
		   // antes de escribir se le agrega la linea para el registro
		   $h = Helpers::HashId();
		   $t = Helpers::TimeId();
		   
		if($archivo != NULL){
		   $archivo.= 'INSERT INTO sync_up_cloud VALUES("", "1", "1", "1",  "'.$fecha.'", "'.$hora.'", "'.strtotime($fecha).'", "'.$hash.'", "'.$_SESSION["last_update"].'", "'.$_SESSION["now"].'", "'.$h.'", "'.$t.'", "' . $_SESSION["temporal_td"] .'");';
		   if(fwrite($handle,$archivo)){
		   	
		   	 		   	 		    	
	    	    $datos = array();
			    $datos["creado"] = "1";
			    $datos["subido"] = "0";
			    $datos["ejecutado"] = "0";
			    $datos["fecha"] = $fecha;
			    $datos["hora"] = $hora;
			    $datos["fechaF"] = strtotime($fecha);
			    $datos["comprobacion"] = $hash;
			    $datos["inicio"] = $_SESSION["last_update"];
			    $datos["final"] = $_SESSION["now"];
			    $datos["hash"] = $h;
			    $datos["time"] = $t;
			    $datos["td"] = $_SESSION["temporal_td"];
			    if ($db->insert("sync_up", $datos)) {
			         return $hash;
			    }
	
		   }
		} // termina comprobacion de archivo null
		   fclose($handle);
		 
	}



	public function BorroSession(){ // borro las variables de sessio
		unset($_SESSION["last_update"]);
		unset($_SESSION["now"]);
	}


} // class
 ?>