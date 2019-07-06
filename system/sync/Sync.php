<?php 
class Sync{

	public function __construct(){

	}



	public function ListaRespaldos(){
		//
		$dia=10;
		echo '<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			      <th scope="col">No</th>
			      <th scope="col">Fecha</th>
			      <th scope="col">Estado</th>
			      <th scope="col">Datos</th>
			    </tr>
			  </thead>
			  <tbody>';
		    for ($x = 1; $x <= $dia; $x++) {
		    	$dias = Fechas::DiaResta(date("d-m-Y"),$x);
		    	
		    	echo '<tr>
		    	  <td>'. $x .'</td>
			      <td>'. $dias .'</td>
			      <td>';
			      if($this->VerificarDatos($dias) == "No"){
			      	echo "Sin Datos";
			      } else {
			      if($this->BuscaRespaldo($dias) == 1){ $this-> UrlRespaldo($dias, TRUE); 
					} else { $this-> UrlRespaldo($dias, FALSE); }
				  }	
			      echo '</td>
			      <td>'. $this->VerificarDatos($dias) .'</td>
			      </tr>';		    	
		    }	


		    echo '</tbody>
		    </table>';

	}



	public function ListaCortes(){
		//
		$dia=10;
		echo '<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			      <th scope="col">No</th>
			      <th scope="col">Fecha</th>
			      <th scope="col">Estado</th>
			      <th scope="col">Datos</th>
			    </tr>
			  </thead>
			  <tbody>';
		    for ($x = 1; $x <= $dia; $x++) {
		    	$dias = Fechas::DiaResta(date("d-m-Y"),$x);
		    	
		    	echo '<tr>
		    	  <td scope="row">'. $x .'</td>
			      <td scope="row">'. $dias .'</td>
			      <td>';
			      if($this->VerificarDatos($dias) == "No"){
			      	echo "Sin Datos";
			      } else {
			      if(Corte::BuscaCorte($dias) == 1){ $this-> UrlCorte($dias, TRUE); 
					} else { $this-> UrlCorte($dias, FALSE); }
				  }
			      echo '</td>
			      <td>'. $this->VerificarDatos($dias) .'</td>
			      </tr>';		    	
		    }	


		    echo '</tbody>
		    </table>';

	}


	public function UrlRespaldo($fecha, $url){
		if($url == FALSE){
			echo '<a href="?modal=respaldar&fecha='.$fecha.'&type=1" class="btn btn-danger waves-effect waves-light">
			    Sin Respaldo
			</a>';
		} else {
			echo '<a class="btn btn-success waves-effect waves-light">
			    Existe Respaldo
			</a>';
		}
		echo '<a href="?modal=respaldar&fecha='.$fecha.'&type=1&delete=1"><span class="badge badge-pill pink"><i class="fa fa-upload" aria-hidden="true"></i></span></a>';
	}


	public function UrlCorte($fecha, $url){
		if($url == FALSE){
			echo '<a href="?modal=newcut&fecha='.$fecha.'" class="btn btn-danger waves-effect waves-light">
			    Hacer Corte
			</a>';
		} else {
			echo '<a class="btn btn-success waves-effect waves-light">
			    Existe Corte
			</a>';
		}
	}



	public function BuscaRespaldo($fecha){
		$db = new dbConn();
	    	$a = $db->query("SELECT * FROM sync_status WHERE fecha = '$fecha' and creado = 1 and ejecutado = 1 and td = ".$_SESSION["td"]."");
			return $a->num_rows;
			$a->close();
	}


	public function VerificarDatos($fecha){
		$db = new dbConn();
	    	$a = $db->query("SELECT * FROM ticket WHERE fecha = '$fecha' and td = ".$_SESSION["td"]."");
			if($a->num_rows > 0){ return "Si";} else { return "No";}
			$a->close();
	}

///////////// para revisar los respaldos


	public function GetStatus($fecha){ // revisar si se ha revisado respaldo
	    $db = new dbConn();

			$a = $db->query("SELECT * FROM sync_status WHERE fecha = '$fecha' and tipo = 1 and td = ".$_SESSION["td"]."");
			return $a->num_rows;
			$a->close();

	}


	public function RevisarRespaldo($fecha){ // revisar si se ha revisado respaldo
	    $db = new dbConn();

		if ($r = $db->select("*", "sync_status", "WHERE fecha = '$fecha' and tipo = 1 and td = ".$_SESSION["td"]."")) { 
	       $creado = $r["creado"]; $subido = $r["subido"]; $ejecutado = $r["ejecutado"];
	    } unset($r);  
	    if($creado == 1 and $subido == 0 and $ejecutado == 0){
	    	return 1;
	    }
	    if($creado == 1 and $subido == 1 and $ejecutado == 0){
	    	return 2;
	    }
	    if($creado == 1 and $subido == 1 and $ejecutado == 1){
	    	return 3;
	    }

	}

	public function RespaldoStatus($fecha){

			if($this->GetStatus($fecha) >= 1){
					if($this->RevisarRespaldo($fecha) == 1){
						Alerts::RealizarRespaldo("Respaldo realizado pero aun no ha subido a la Web. Este proceso se har&aacute automaticamente");
					}
					if($this->RevisarRespaldo($fecha) == 2){
						Alerts::RealizarRespaldo("Respaldo subido exitosamente.  Esperando a ser sincronizado...");
					}
					if($this->RevisarRespaldo($fecha) == 3){
						Alerts::RealizadoRespaldo("Respaldo realizado correctamente");
					}
			} else {
				Alerts::Mensaje("Aun no se ha realizado un respaldo","danger",'<a href="http://localhost/pizto/?modal=respaldar&delete=1"  class="btn btn-danger waves-effect waves-light">Intentar Nuevamente</a>',$boton2);
			}
	}


	public function ComparaVersiones(){
				$remoto = "https://www.pizto.com/admin/sync/datesync.txt";
				$file = fopen($remoto, "r");
				if ($file) { 
				    $line = fgets($file);
				    fclose($file);
				} else {
					Alerts::Mensaje("Error en el archivo remoto","danger",NULL,NULL);
				}

				$local = "../../sync/datesync.txt";
				$file2 = fopen($local, "r");
				if ($file2) {    
				    $line2 = fgets($file2);
				    fclose($file2);
				} else {
					Alerts::Mensaje("Error en el archivo local","danger",NULL,NULL);
				}
				if($line != NULL and $line2 != NULL){
					if($line == $line2){
					    Alerts::Mensaje("El sistema esta actualizado!","success",NULL,NULL);
					} else {
						Alerts::Mensaje("Su sistema no se encuentra actualizado. Es necesario actualizar el sistema para corregir errores de seguridad, obtener las ultimas novedades y mejor rendimiento","danger",'<a id="actualizar" op="165" class="btn btn-danger">Actualizar Ahora</a>',NULL);
					}
				} else {
					Alerts::Mensaje("Ocurrio un error al comparar","danger",NULL,NULL);
				}
	}


	public function ModificaArchivoSync(){
		$hash = date("d-m-Y-H:i:s");
		$hash = md5($hash);
		$local = "../../sync/datesync.txt";
				$file2 = fopen($local, "w+");
				if ($file2) {    
				   fwrite($file2, $hash); 
				   fclose($file2);
				}
	}








} // class

?>