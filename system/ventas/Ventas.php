<?php 
class Ventas{

	public function __construct() { 
 	} 




   public function AddVenta($datos){
  	$this->Agregar($datos);

  	$this->VerProducto();
   }




	public function Agregar($datos) {
		$db = new dbConn();

		if($_SESSION["orden"] == NULL){
			$this->AddOrden();
		}
	
	$pv = $this->ObtenerPrecio($datos["cod"], $datos["cantidad"]);
	$sumas = $pv * $datos["cantidad"];

    $stot=Helpers::STotal($sumas, $_SESSION['config_imp']);
    $im=Helpers::Impuesto($stot, $_SESSION['config_imp']);

		$datox = array();
	    $datox["cod"] = $datos["cod"];
	    $datox["cant"] = $datos["cantidad"];
	    $datox["producto"] = $this->ObtenerNombre($datos["cod"]);
	    $datox["pv"] = $pv;  				   
	    $datox["stotal"] = $stot;	    				   
	    $datox["imp"] = $im;
	    $datox["total"] = $stot + $im;
	    $datox["num_fac"] = 0;
	    $datox["fecha"] = date("d-m-Y");
	    $datox["hora"] = date("H:i:s");
	    $datox["orden"] = $_SESSION["orden"];
	    $datox["cajero"] = $_SESSION['nombre'];
	    $datox["tipo_pago"] = 1;
	    $datox["user"] = $_SESSION['user'];
	    $datox["tx"] = $_SESSION['tx'];
	    $datox["fechaF"] = Fechas::Format(date("d-m-Y"));
	    $datox["edo"] = 1;
	    $hash = Helpers::HashId();
	    $datox["hash"] = $hash;
		$datox["time"] = Helpers::TimeId();
	    $datox["td"] = $_SESSION["td"];
	    if ($db->insert("ticket", $datox)) {
	       $this->AgregaCaracteristicas($datos, $hash);
	       $this->AgregaUbicacion($datos, $hash);
	       $this->DescuetaProducto($datos["cod"], $datos["cantidad"]);
	    } 

	}


	public function ObtenerNombre($cod){
		$db = new dbConn();

	if ($r = $db->select("descripcion", "producto", "WHERE cod = '$cod' and td = ".$_SESSION["td"]."")){ 
        return $r["descripcion"];
    	} unset($r); 
    }


	public function ObtenerPrecio($cod, $cant){ // obtiene el precio independientemente la cantidad
		$db = new dbConn();
		// cuento si hay varias fechas
	$a = $db->query("SELECT * FROM producto_precio WHERE producto = '$cod' and td = ".$_SESSION["td"]."");
		$precios = $a->num_rows; $a->close();

			if($precios > 1){ // si hay mas de un precio
					
					if ($r = $db->select("precio", "producto_precio", "WHERE cant <= '$cant' and producto = '$cod' and td = ".$_SESSION["td"]." order by cant desc limit 1")) { 
				        $precio = $r["precio"];
				    } unset($r);

			} else { // si solo hay un precio
				   
				    if ($r = $db->select("precio", "producto_precio", "WHERE producto = '$cod' and td = ".$_SESSION["td"]."")) { 
				        $precio = $r["precio"];
				    } unset($r); 	
			}
				return $precio;
	}




	public function ObtenerCantidad($cod) { // obtine cantiad de productos
		$db = new dbConn();

	if ($r = $db->select("cantidad", "producto", "WHERE cod = '$cod' and td = ".$_SESSION["td"]."")){ 
        return $r["cantidad"];
    	} unset($r); 
    }


	public function DescuetaProducto($cod,$cant) { // descuenta los productos
		$db = new dbConn();
		    $cambio = array();
		    $cambio["cantidad"] = $this->ObtenerCantidad($cod) - $cant;
		    Helpers::UpdateId("producto", $cambio, "cod='$cod' and td = ".$_SESSION["td"]."");
    }


	public function AgregaCaracteristicas($datos, $hash){
		$db = new dbConn();
		// cuento el producto tiene varias caracteristicas
		    $a = $db->query("SELECT * FROM caracteristicas_asig WHERE producto =  '".$datos["cod"]."' and td = ".$_SESSION["td"]."");

		    if($a->num_rows > 0){
		    	foreach ($a as $b) { // aqui agregare las caracteristicas que lo requieran
		        	$car = $b["caracteristica"];
		        		if($datos["caracteristica"][$car] != NULL){ // si no esta vacia se inserta
							    
							    $datox = array();
							    $datox["orden"] = $_SESSION["orden"];
							    $datox["producto"] = $datos["cod"];
							    $datox["producto_hash"] = $hash;
							    $datox["descuenta"] = 1;
							    $datox["codigo"] = $b["caracteristica"];
							    $datox["cant"] = $datos["caracteristica"][$car];
							    $datox["hash"] = Helpers::HashId();
							    $datox["time"] = Helpers::TimeId();
							    $datox["tx"] = $_SESSION["tx"];
							    $datox["td"] = $_SESSION["td"];
							    $db->insert("ticket_descuenta", $datox);

	    //// aqui descuento la cantidad de caracteristica
	     if ($r = $db->select("cant", "caracteristicas_asig", "WHERE caracteristica = '".$b["caracteristica"]."' and producto = '".$datos["cod"]."' and td = ".$_SESSION["td"]."")) { 
	        $ccar = $r["cant"];
	    } unset($r); 
	    // descuento
	   $cambio = array();
	   $cambio["cant"] = $ccar - $datos["caracteristica"][$car];
	   Helpers::UpdateId("caracteristicas_asig", $cambio, "caracteristica = '".$b["caracteristica"]."' and producto = '".$datos["cod"]."' and td = ".$_SESSION["td"]."");

		        		}
		    	}
		    } $a->close();

	}



	public function AgregaUbicacion($datos, $hash){  // agrega las ubicaciones
		$db = new dbConn();
		
		if($datos["ubicacion"] != NULL){ // si no esta vacia se inserta				    
			    $datox = array();
			    $datox["orden"] = $_SESSION["orden"];
			    $datox["producto"] = $datos["cod"];
			    $datox["producto_hash"] = $hash;
			    $datox["descuenta"] = 2;
			    $datox["codigo"] = $datos["ubicacion"];
			    $datox["cant"] = $datos["cantidad"];
			    $datox["hash"] = Helpers::HashId();
			    $datox["time"] = Helpers::TimeId();
			    $datox["tx"] = $_SESSION["tx"];
			    $datox["td"] = $_SESSION["td"];
			    $db->insert("ticket_descuenta", $datox);

			//// aqui descuento la cantidad de caracteristica
	     if ($r = $db->select("cant", "ubicacion_asig", "WHERE ubicacion = '".$datos["ubicacion"]."' and producto = '".$datos["cod"]."' and td = ".$_SESSION["td"]."")) { 
	        $cubic = $r["cant"];
	    } unset($r); 
	    // descuento
	   $cambio = array();
	   $cambio["cant"] = $cubic - $datos["cantidad"];
	   Helpers::UpdateId("ubicacion_asig", $cambio, "ubicacion = '".$datos["ubicacion"]."' and producto = '".$datos["cod"]."' and td = ".$_SESSION["td"]."");

		}

	}






	public function AddOrden() { //leva el control del autoincremento de los clientes
		$db = new dbConn();

	    if ($r = $db->select("correlativo", "ticket_orden", "WHERE td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]." order by correlativo desc limit 1")) { 
	        $ultimoorden = $r["correlativo"];
	    } unset($r);  

			$datos = array();
		    $datos["nombre"] = NULL;
		    $datos["correlativo"] = $ultimoorden + 1;
		    $datos["empleado"] = $_SESSION["nombre"];
		    $datos["fecha"] = date("d-m-Y");
		    $datos["hora"] = date("H:i:s");
		    $datos["estado"] = 1;
		    $datos["tx"] = $_SESSION["tx"];
		    $datos["hash"] = Helpers::HashId();
		    $datos["time"] = Helpers::TimeId();
		    $datos["td"] = $_SESSION["td"];
		    $db->insert("ticket_orden", $datos); 
		
		$_SESSION["orden"] = $ultimoorden + 1;    
	}




/////////// mostrar los productos agregados



	public function VerProducto() { //leva el control del autoincremento de los clientes
		$db = new dbConn();
		    
		if($_SESSION["orden"] != NULL){
		    
		    $a = $db->query("SELECT * FROM ticket WHERE orden = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");

		    if($a->num_rows > 0){
		    		echo '<table class="table table-striped table-sm">
					  <thead>
					    <tr>
					      <th scope="col">Cant</th>
					      <th scope="col">Producto</th>
					      <th scope="col">Precio</th>
					      <th scope="col">Subtotal</th>
					      <th scope="col">Impuesto</th>
					      <th scope="col">Total</th>
					      <th scope="col">Borrar</th>
					    </tr>
					  </thead>
					  <tbody>';
		    		foreach ($a as $b) {
		    		   echo '<tr>
						      <th scope="row">'.$b["cant"].'</th>
						      <td>'.$b["producto"].'</td>
						      <td>'.$b["pv"].'</td>
						      <td>'.$b["stotal"].'</td>
						      <td>'.$b["imp"].'</td>
						      <td>'.$b["total"].'</td>
						      <td><a id="borrar-ticket" op="81" hash="'.$b["hash"].'"><i class="fas fa-times-circle red-text fa-lg"></i></a></td>
						    </tr>';
				    }
				    	echo '</tbody>
							</table>';
		    } $a->close();

		} else {
			echo '<div class="text-center">Ingrese un producto</div>';
		}    
	}



//// borrar
	
	public function CuentaProductos($orden){
		$db = new dbConn();

		$a = $db->query("SELECT * FROM ticket WHERE orden = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
		    
		    return $a->num_rows;
		    $a->close();
    }

	
	public function DelOrden($orden){ // elimina el registro de la orden
		$db = new dbConn();

		if(Helpers::DeleteId("ticket_orden", "correlativo = '$orden' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")){
	  			unset($_SESSION["orden"]);
	  		}
    }


   public function DelVenta($hash){
	$db = new dbConn();
   	    
   	    if ($r = $db->select("*", "ticket", "WHERE hash = '$hash' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
	        $cant_t = $r["cant"];
	        $cod = $r["cod"];
	    }  unset($r); 

   	    if ($r = $db->select("*", "producto", "WHERE cod = '$cod' and td = ".$_SESSION["td"]."")) { 
		$cant_p = $r["cantidad"];
		}  unset($r);  
   	// regreso los valores a los productos
   $cambio = array();
   $cambio["cantidad"] = $cant_p + $cant_t;
   Helpers::UpdateId("producto", $cambio, "cod = '$cod' and td = ".$_SESSION["td"]."");
  	// borro el registro de ticket
  	Helpers::DeleteId("ticket", "hash = '$hash' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
  	// regreso los valores de caracteristica y ubicacion
  	$a = $db->query("SELECT * FROM ticket_descuenta WHERE producto_hash = '$hash' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
  	if($a->num_rows > 0){
  			foreach ($a as $b) {
		        if($b["descuenta"] == 1){ // si es caracteristica
        	   	    if ($r = $db->select("*", "caracteristicas_asig", "WHERE producto = '$cod' and caracteristica = '".$b["codigo"]."' and td = ".$_SESSION["td"]."")) { 
					$cant_car = $r["cant"];
					}  unset($r); 

				   $cambio = array();
				   $cambio["cant"] = $cant_car + $b["cant"];
				   Helpers::UpdateId("caracteristicas_asig", $cambio, "producto = '$cod' and caracteristica = '".$b["codigo"]."' and td = ".$_SESSION["td"]."");  
		        }
		        if($b["descuenta"] == 2){
        	   	    if ($r = $db->select("*", "ubicacion_asig", "WHERE producto = '$cod' and ubicacion = '".$b["codigo"]."' and td = ".$_SESSION["td"]."")) { 
					$cant_u = $r["cant"];
					}  unset($r); 

				   $cambio = array();
				   $cambio["cant"] = $cant_u + $b["cant"];
				   Helpers::UpdateId("ubicacion_asig", $cambio, "producto = '$cod' and ubicacion = '".$b["codigo"]."' and td = ".$_SESSION["td"]."");  		        	
		        }
		    }
  	}  $a->close();
  	// borro caracteristica y ubicacion 
  	Helpers::DeleteId("ticket_descuenta", "producto_hash = '$hash' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
  	// compruebo si hay mas productos sino elimino orden
	  	if($this->CuentaProductos($_SESSION["orden"]) == 0){
	  		$this->DelOrden($_SESSION["orden"]);
	  	}

  	$this->VerProducto();
   }





} // Termina la lcase