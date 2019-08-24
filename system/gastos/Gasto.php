<?php 
class Gastos{

	public function __construct(){

	}

	public function AddGasto($data){
	    $db = new dbConn();

	    if($data["gasto"] != NULL and $data["cantidad"] != NULL){
	         $datos = array();
			    $datos["tipo"] = $data["tipo"];
			    $datos["nombre"] = $data["gasto"];
			    $datos["descripcion"] = $data["descripcion"];
			    $datos["cantidad"] = $data["cantidad"];
			    $datos["fecha"] = date("d-m-Y");
			    $datos["fechaF"] = Fechas::Format(date("d-m-Y"));
			    $datos["hora"] = date("H:i:s");
			    $datos["user"] = $_SESSION["user"];
			    $datos["edo"] = 1;
			    $datos["hash"] = Helpers::HashId();
				$datos["time"] = Helpers::TimeId();
			    $datos["td"] = $_SESSION["td"];
			    if ($db->insert("gastos", $datos)) {
			        Alerts::Alerta("success","Agregado Correctamente","Gasto Agregado corectamente!");
			    } else {
			    	Alerts::Alerta("error","Error","Error desconocido, no se agrego el registro!");
			    }
		} else {
			Alerts::Alerta("error","Error","Faltan Datos!");
		}
			$this->VerGastos();

	}




	public function VerGastos(){
	    $db = new dbConn();
	    $fecha = date("d-m-Y");
	        $a = $db->query("SELECT * FROM gastos WHERE fecha = '$fecha' and td = ". $_SESSION["td"] ." order by id desc");
	        	$total=0;
	        	if($a->num_rows > 0){
	        echo ' <h3>Detalle de Gastos</h3>

				<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Tipo</th>
			      <th scope="col">Gasto</th>
			      <th scope="col">Descripci&oacuten</th>
			      <th scope="col">Cantidad</th>
			      <th>Modificar</th>
			    </tr>
			  </thead>
			  <tbody>';
			  $n = 0;
		    foreach ($a as $b) {
		    	$n++;
		    	if($b["edo"] == 1){
				$total = $total + $b["cantidad"];
				$colores='class="text-black"';
				} else {
				$colores='class="text-danger"';	
				} 

		    	echo '<tr '.$colores.'>
		    	  <td>'. $n .'</td>
			      <th scope="row">'. Helpers::Gasto($b["tipo"]) .'</th>
			      <td>'. $b["nombre"] .'</td>
			      <td>'. $b["descripcion"] .'</td>
			      <td>'. Helpers::Dinero($b["cantidad"]) .'</td>
			      <td>';
			      if($b["edo"] == 1){

			      	echo '<a href="?modal=imageup&gasto='. $b["id"] .'">
				      <span class="badge green"><i class="fas fa-image" aria-hidden="true"></i></span>
				      </a>

			      <a id="borrar-gasto" op="111" iden="'. $b["id"] .'">
				      <span class="badge red"><i class="fas fa-trash-alt" aria-hidden="true"></i></span>
				      </a>';
			      }
			      echo '</td>
			    </tr>';
			    
		    }

		    if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5){
		    echo '<tr>
		    	  <th scope="col"></th>
			      <th scope="col"></th>
			      <th scope="col"></th>
			      <th scope="col">Total</th>
			      <th scope="col">'. Helpers::Dinero($total) .'</th>
			      <td></td>
			    </tr>';
			    }
			
			echo '</tbody>
		    </table>';
			}
  			$a->close();
	}

	

		public function BorrarGasto($iden) {
		$db = new dbConn();

			    $cambio = array();
			    $cambio["edo"] = 0;
			    
			    if (Helpers::UpdateId("gastos", $cambio, "id='$iden' and td = ".$_SESSION["td"]."")) {
			        Alerts::Alerta("success","Eliminado","Se ha eliminado el registo correctamente!");
			    } else {
			        Alerts::Alerta("error","Error","No se pudo eliminar!"); 
			    }
					    
		    
		    $this->VerGastos();

   		}






//////// entradas

	public function VerEntradas() {
		$db = new dbConn();
	        $a = $db->query("SELECT * FROM entradas_efectivo WHERE td = ". $_SESSION["td"] ." order by id desc limit 10");
	        	$total=0;
	        	if($a->num_rows > 0){
	        echo ' <h3>Ultimas entradas</h3>

				<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			      <th scope="col">#</th>
			      <th scope="col">Descripci&oacuten</th>
			      <th scope="col">Fecha</th>
			      <th scope="col">Cantidad</th>
			      <th>Eliminar</th>
			    </tr>
			  </thead>
			  <tbody>';
			  $n = 0;
		    foreach ($a as $b) {
		    	$n++;
		    	if($b["edo"] == 1){
				$total = $total + $b["cantidad"];
				$colores='class="text-black"';
				} else {
				$colores='class="text-danger"';	
				} 

		    	echo '<tr '.$colores.'>
		    	  <td>'. $n .'</td>
			      <td>'. $b["descripcion"] .'</td>
			      <td>'. $b["fecha"] .' | '. $b["hora"] .'</td>
			      <td>'. Helpers::Dinero($b["cantidad"]) .'</td>
			      <td>';
			      if($b["edo"] == 1){

			      	echo '<a id="borrar-efectivo" op="113" iden="'. $b["id"] .'">
				      <span class="badge red"><i class="fas fa-trash-alt" aria-hidden="true"></i></span>
				      </a>';
			      }
			      echo '</td>
			    </tr>';
			    
		    }

		    if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5){
		    echo '<tr>
			      <th scope="col"></th>
			      <th scope="col"></th>
			      <th scope="col">Total</th>
			      <th scope="col">'. Helpers::Dinero($total) .'</th>
			      <td></td>
			    </tr>';
			    }
			
			echo '</tbody>
		    </table>';
			}
  			$a->close();

   	}




	public function AddEfectivo($data){
	    $db = new dbConn();

	    if($data["descripcion"] != NULL and $data["cantidad"] != NULL){
	         $datos = array();
			    $datos["descripcion"] = $data["descripcion"];
			    $datos["cantidad"] = $data["cantidad"];
			    $datos["fecha"] = date("d-m-Y");
			    $datos["fechaF"] = Fechas::Format(date("d-m-Y"));
			    $datos["hora"] = date("H:i:s");
			    $datos["user"] = $_SESSION["user"];
			    $datos["edo"] = 1;
			    $datos["hash"] = Helpers::HashId();
				$datos["time"] = Helpers::TimeId();
			    $datos["td"] = $_SESSION["td"];
			    if ($db->insert("entradas_efectivo", $datos)) {
			        Alerts::Alerta("success","Agregado Correctamente","Efectivo Agregado corectamente!");
			    } else {
			    	Alerts::Alerta("error","Error","Error desconocido, no se agrego el registro!");
			    }
		} else {
			Alerts::Alerta("error","Error","Faltan Datos!");
		}
			$this->VerEntradas();

	}


		public function BorrarEfectivo($iden) {
		$db = new dbConn();

			    $cambio = array();
			    $cambio["edo"] = 0;
			    
			    if (Helpers::UpdateId("entradas_efectivo", $cambio, "id='$iden' and td = ".$_SESSION["td"]."")) {
			        Alerts::Alerta("success","Eliminado","Se ha eliminado el registo correctamente!");
			    } else {
			        Alerts::Alerta("error","Error","No se pudo eliminar!"); 
			    }
					    
		    
		    $this->VerEntradas();

   		}






}