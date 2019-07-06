<?php 
class Gasto{

	public function __construct(){

	}

	public function AddGasto($gasto,$tipo,$descripcion,$cantidad){
	    $db = new dbConn();

	         $datos = array();
			    $datos["tipo"] = $tipo;
			    $datos["nombre"] = $gasto;
			    $datos["descripcion"] = $descripcion;
			    $datos["cantidad"] = $cantidad;
			    $datos["fecha"] = date("d-m-Y");
			    $datos["fechaF"] = Fechas::Format(date("d-m-Y"));
			    $datos["hora"] = date("H:i:s");
			    $datos["user"] = $_SESSION["user"];
			    $datos["edo"] = 1;
			    $datos["td"] = $_SESSION["td"];
			    if ($db->insert("gastos", $datos)) {
			        Alerts::Alerta("success","Agregado Correctamente","Gasto Agregado corectamente!");
			    } else {
			    	Alerts::Alerta("danger","Error","Error desconocido, no se agrego el registro!");
			    }
			    $this->VerGastos();
	
	}



	public function VerGastos(){
	    $db = new dbConn();
	    $fecha = date("d-m-Y");
	        $a = $db->query("SELECT * FROM gastos WHERE fecha = '$fecha' and td = ". $_SESSION["td"] ." order by id desc");
	        	$total=0;
	        	if($a->num_rows > 0){
	        echo ' <h3>Detalle</h3>

				<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			      <th scope="col">Tipo</th>
			      <th scope="col">Gasto</th>
			      <th scope="col">Descripci&oacuten</th>
			      <th scope="col">Cantidad</th>
			      <th>Modificar</th>
			    </tr>
			  </thead>
			  <tbody>';
		    foreach ($a as $b) {

		    	if($b["edo"] == 1){
				$total = $total + $b["cantidad"];
				$colores='class="text-black"';
				} else {
				$colores='class="text-danger"';	
				} 

		    	echo '<tr '.$colores.'>
			      <th scope="row">'. Helpers::Gasto($b["tipo"]) .'</th>
			      <td>'. $b["nombre"] .'</td>
			      <td>'. $b["descripcion"] .'</td>
			      <td>'. Helpers::Dinero($b["cantidad"]) .'</td>
			      <td>';
			      if($b["edo"] == 1){

			      	echo '<a href="?modal=imageup&gasto='. $b["id"] .'">
				      <span class="badge green"><i class="fa fa-photo" aria-hidden="true"></i></span>
				      </a>

			      <a id="borrar-gasto" op="29" iden="'. $b["id"] .'">
				      <span class="badge red"><i class="fa fa-trash" aria-hidden="true"></i></span>
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
			echo "El numero de registros es: ". $a->num_rows . "<br>";
			}
  			$a->close();
	}

	

		public function BorrarGasto($iden) {
		$db = new dbConn();

			    $cambio = array();
			    $cambio["edo"] = 0;
			    if ($db->update("gastos", $cambio, "WHERE id='$iden' and td = ".$_SESSION["td"]."")) {
			        Alerts::Alerta("warning","Gasto Eliminado","Se ha eliminado el registo correctamente!");
			    } else {
			        Alerts::Alerta("info","Error","No se ha eliminado el registo correctamente!"); 
			    }
					    
		    
		    $this->VerGastos();

   		}




}