<?php 
class Sincronizar{

	public function __construct(){

	}


	public function Sync($fecha){
	    $db = new dbConn();

	    $counter = 0;

		$a = $db->query("SELECT * FROM sync_up WHERE edo = 1 and td = ".$_SESSION["temporal_td"]."");
	    foreach ($a as $b) {

	    	$tabla = $b["tabla"];
	    	//// veo de donde sacare el correlativo
	    	if($this->GetStatus($fecha) >= 10){
	    		$corr = $this->GetInicio($tabla);
	    		$del=TRUE;
	    	} else {
	    		$corr = $this->GetCorrelativo($b["tabla"]);
	    		$del=FALSE;
	    	}

	       $resultado.= "\n # " . $b["tabla"] ." : ". $corr . " : " .$this->GetId($b["tabla"]). "\n\n";


	       if($del == TRUE){
	       $resultado.= 'DELETE FROM '.$tabla.' WHERE fecha = "'.$fecha.'" and td = "' . $_SESSION["temporal_td"] .'"'; $resultado.= ";\n";
	       }
	        // comparar los id
	        if($corr < $this->GetId($b["tabla"])) {

	        	// extraigo los datos de la tabla
	        	    
	        	    
	        	        $s = $db->query("SELECT * FROM ".$b["tabla"]." WHERE id BETWEEN '$corr' and ".$this->GetId($b["tabla"])." and td = ".$_SESSION["temporal_td"]."");
					    foreach ($s as $y) {

				$counter = $counter + 1;
					    	
					    $resultado.= "INSERT INTO ".$b["tabla"]." VALUES(";
					    	// especifico los campos
				        	   $fields = $db->listFields($b["tabla"]);
							    $arrlength = count($fields);
							    for($x = 0; $x < $arrlength; $x++) {
							        $campo = $fields[$x]['name'];

						if($campo == "id") $resultado.= "\"\", ";
						elseif($campo == "td") $resultado.= "\"" .$y["$campo"] . "\"";
						else $resultado.= "\"" . $y["$campo"] . "\", ";

							    }
							$resultado.= "); \n";
					    } $s->close();

	        	   $this->UpdateSync($b["tabla"], $this->GetId($b["tabla"]));

	        	} else {
	        		$resultado.= "#  No actualizable \n\n";
	        	}
	        	

	    } $a->close();

	    // elimino los sync si son mas de 4
	    	if($this->GetStatus($fecha) >= 10){
				$this->DelStatus($fecha);
			} 

		// guardo el arvivo creado
	   		 if($counter > 0){
					    $save =$this->SaveSync($resultado,$fecha,5);
					    if($save != NULL){
					    	return $save;
					    } else {
					    	return NULL;
					    }
			} unset($counter);
	
	} // termina el metodo








	public function GetCorrelativo($tabla){ // ultimo id de la tabla sync
	    $db = new dbConn();

	$a = $db->query("SELECT * FROM sync WHERE tabla = '$tabla' and td = ".$_SESSION["temporal_td"]." order by id desc limit 1");
	    foreach ($a as $b) {

	        return $b["correlativo"]+1;

	    } $a->close();
	}







	public function GetInicio($tabla){ // ultimo id de la tabla sync
	    $db = new dbConn();

	$a = $db->query("SELECT * FROM sync WHERE tabla = '$tabla' and td = ".$_SESSION["temporal_td"]." order by id desc limit 1");
	    foreach ($a as $b) {

	        return $b["inicio"]+1;

	    } $a->close();
	}







	public function GetStatus($fecha){ // cuantas vaces se ha actualizado
	    $db = new dbConn();

			$a = $db->query("SELECT * FROM sync_status WHERE fecha = '$fecha' and tipo = 5 and td = ".$_SESSION["temporal_td"]."");
			return $a->num_rows;
			$a->close();

	}






	public function DelStatus($fecha){ // cuantas vaces se ha actualizado
	    $db = new dbConn();

		$db->delete("sync_status", "WHERE fecha = '$fecha' and tipo = 5 and td = ".$_SESSION["temporal_td"]."");
	}







	
	public function GetId($tabla){ // ultimo id de la tabla a buscar
	    $db = new dbConn();

	$a = $db->query("SELECT * FROM $tabla WHERE td = ".$_SESSION["temporal_td"]." order by id desc limit 1");
	    foreach ($a as $b) {

	        return $b["id"]+1;

	    } $a->close();
	}








	public function UpdateSync($tabla, $correlativo){ // actualizar correlativo de Sync
	    $db = new dbConn();

	        $cambio = array();
		    $cambio["correlativo"] = $correlativo-1;
		    $db->update("sync", $cambio, "WHERE tabla = '$tabla' and td = ".$_SESSION["temporal_td"]."");

	}




// recorrer la tabla sync para saber que datos sincronizar y sacar el correlativo
// obtener el ultimo id de cada tabla
// comparar el ultimo id de cada tabla con el correlativo de sync
// extraer los datos de la tabla si es que existen
// ectualizar los correlativos de cada tabla



	public function SaveSync($resultado,$fecha,$tipox){ // guardo el archivo a sincronizar creado

		   	 	$hora = date("H:i:s");
		   	 	$hash = $fecha."-".$hora ."-" . $_SESSION["temporal_td"];
		   	 	$hash = md5($hash);
		   	 	$hash = $_SESSION["temporal_td"] . "-" . $tipox . "-" . $hash;

		   $handle = fopen($hash . ".sql",'w+');
		   // antes de escribir se le agrega la linea para el registro
		   $resultado.= 'INSERT INTO login_sync VALUES("", "'.$hash.'", "'.$tipox.'", "1",  "'.$fecha.'", "'.$hora.'", "'.$_SESSION["temporal_td"].'");';
		   if(fwrite($handle,$resultado)){
		   	
		   	 $db = new dbConn();

		   	 		    	
	    	    $datos = array();
			    $datos["tipo"] = "5";
			    $datos["creado"] = "1";
			    $datos["subido"] = "0";
			    $datos["ejecutado"] = "0";
			    $datos["fecha"] = $fecha;
			    $datos["hora"] = $hora;
			    $datos["fechaF"] = strtotime($fecha);
			    $datos["hash"] = $hash;
			    $datos["td"] = $_SESSION["temporal_td"];
			    if ($db->insert("sync_status", $datos)) {
			         return $hash;
			    }
	
		   } 
		   fclose($handle);
		 
	}








} // class
 ?>