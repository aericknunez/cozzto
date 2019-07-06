<?php 
class Upload{

	public function __construct(){

	}


	public function  Sync($fecha,$tipox){ // verifica si se actualiza todo o solo hoy
	    $db = new dbConn();

	    if($this->CompruebaSync($fecha) == 0) {

		  $a = $db->query("SELECT * FROM sync_up WHERE td = ".$_SESSION["temporal_td"]."");
		    foreach ($a as $b) {

		       $resultado.= "\n # " . $b["tabla"] ." \n\n";

		       
		       if($tipox == 1 and $b["edo"] == 1){
		       		$resultado.=$this->ExtraerFecha($b["tabla"],$fecha);
		       }
		       if($tipox == 2 and $b["edo"] == 0){
		       		$resultado.=$this->ExtraerTodo($b["tabla"]);
		       }
		       if($tipox == 3){
		       		if($b["edo"] == 0){ // si hay que actualizar todo
		       			$resultado.=$this->ExtraerTodo($b["tabla"]);
			       } else { // si ahy que actualizar solo lo de hoy
			       		$resultado.=$this->ExtraerFecha($b["tabla"],$fecha);
			       }
		       }
		       // if($b["edo"] == 0){ // si hay que actualizar todo
		       // 		$resultado.=$this->ExtraerTodo($b["tabla"]);
		       // } else { // si ahy que actualizar solo lo de hoy
		       // 		$resultado.=$this->ExtraerFecha($b["tabla"],$fecha);
		       // }
		        
		    } $a->close();
	    
		    $save = $this->SaveSync($resultado,$fecha,$tipox);
		    if($save != NULL){

	///////////// aqui actualizo los correlativos//////
		$ax = $db->query("SELECT * FROM sync WHERE td = ".$_SESSION["temporal_td"]."");
	    foreach ($ax as $bx) {

	        // comparar los id
	        if($this->GetCorrelativo($bx["tabla"]) <= $this->GetId($bx["tabla"])) {
	        	   
	        	$this->UpdateSync($bx["tabla"], $this->GetId($bx["tabla"]));

	      }
	    } $ax->close();
////////////////	
	    		$this->DelStatus($fecha);
		    	return $save;
			    } else {
			    	return NULL;
			    }	  		  		  

		  } 
	}


	public function ExtraerTodo($tabla){ // Extrae datos de toda la tabla
	    $db = new dbConn();

	    $resultado.= 'DELETE FROM '.$tabla.' WHERE td = "' . $_SESSION["temporal_td"] .'"'; $resultado.= ";\n";
	

	    $s = $db->query("SELECT * FROM $tabla WHERE td = ".$_SESSION["temporal_td"]."");
			foreach ($s as $y) {

	    $resultado.= "INSERT INTO $tabla VALUES(";
	    	// especifico los campos
        	   $fields = $db->listFields($tabla);
			    $arrlength = count($fields);
			    for($x = 0; $x < $arrlength; $x++) {
			        $campo = $fields[$x]['name'];

		if($campo == "id") $resultado.= "\"\", ";
		elseif($campo == "td") $resultado.= "\"" .$y["$campo"] . "\"";
		else $resultado.= "\"" . $y["$campo"] . "\", ";

			    }
			$resultado.= "); \n";
	    } $s->close();

	 return $resultado;
	}





	public function ExtraerFecha($tabla,$fecha){ // Extrae datos segun fecha
	    $db = new dbConn();
	    
	    $resultado.= 'DELETE FROM '.$tabla.' WHERE fecha = "'.$fecha.'" and td = "' . $_SESSION["temporal_td"] .'"'; $resultado.= ";\n";

	    $s = $db->query("SELECT * FROM $tabla WHERE fecha = '$fecha' and td = ".$_SESSION["temporal_td"]."");
			foreach ($s as $y){ 
	    $resultado.= "INSERT INTO $tabla VALUES(";
	    	// especifico los campos
        	   $fields = $db->listFields($tabla);
			    $arrlength = count($fields);
			    for($x = 0; $x < $arrlength; $x++) {
			        $campo = $fields[$x]['name'];

		if($campo == "id") $resultado.= "\"\", ";
		elseif($campo == "td") $resultado.= "\"" .$y["$campo"] . "\"";
		else $resultado.= "\"" . $y["$campo"] . "\", ";

			    }
			$resultado.= "); \n";
	    } $s->close();

	 return $resultado;
	}



	public function SaveSync($resultado,$fecha,$tipox){ // guardo el archivo a sincronizar creado

		   	 	$hora = date("H:i:s");
		   	 	$hash = $fecha."-".$hora ."-" . $_SESSION["temporal_td"];
		   	 	$hash = md5($hash);
		   	 	$hash = $_SESSION["temporal_td"] . "-" . $tipox . "-" . $hash;

		   $handle = fopen($hash . ".sql",'w+');
		   $resultado.= 'INSERT INTO login_sync VALUES("", "'.$hash.'", "'.$tipox.'", "1",  "'.$fecha.'", "'.$hora.'", "'.$_SESSION["temporal_td"].'");';
		   if(fwrite($handle,$resultado)){
		   	 	 $db = new dbConn();
	    	
	    	    $datos = array();
			    $datos["tipo"] = $tipox;
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
		   unset($resultado);
		   fclose($handle);
		 
	}





	public function  CompruebaSync($fecha){ // verifica si se actualiza todo o solo hoy
	    $db = new dbConn();

	    $a = $db->query("SELECT * FROM sync_status WHERE tipo = 1 and fecha = '$fecha' and td = ".$_SESSION["temporal_td"]."");
			return $a->num_rows;
			$a->close();

	}



// revisar si se debe subir todo o no
	// si se sube todo
	// recolectar todos los datos de la tabla
	// crear un truncate para borrar la tabla y un insert de todos los datos
	// insertar los datos recolectados
// si no se sube todo
	// recolectar los datos de acuerdo a la fecha actual
	// borrar todos los datos existentes de la fecha actual
	// insertar los datos recolectados




	public function GetCorrelativo($tabla){ // ultimo id de la tabla sync
	    $db = new dbConn();

	$a = $db->query("SELECT * FROM sync WHERE tabla = '$tabla' and td = ".$_SESSION["temporal_td"]." order by id desc limit 1");
	    foreach ($a as $b) {

	        return $b["correlativo"]+1;

	    } $a->close();
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

	    	$corr = $correlativo - 1;

	        $cambio = array();
		    $cambio["correlativo"] = $corr;
		    $cambio["inicio"] = $corr;
		    $db->update("sync", $cambio, "WHERE tabla = '$tabla' and td = ".$_SESSION["temporal_td"]."");

	}

	public function DelStatus($fecha){ // cuantas vaces se ha actualizado
	    $db = new dbConn();

		$db->delete("sync_status", "WHERE fecha = '$fecha' and tipo = 5 and td = ".$_SESSION["temporal_td"]."");
	}





} // class

?>