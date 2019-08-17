<?php 
class Ventas{

	public function __construct() { 
 	} 






   public function SumaVenta($datos){ // Rapida

  		if($this->ObtenerCantidad($datos["cod"]) > 0){
  			if($_SESSION["orden"] == NULL){ $this->AddOrden(); }
  			
  			/// aqui determino si agrego o actualizo
  			$product = $this->ObtenerCantidadTicket($datos["cod"]);
  			if($datos["cantidad"] == NULL) $datos["cantidad"] = 1;
  			if($product > 0){
  				$datos["cantidad"] = $product + $datos["cantidad"];
  				$this->Actualiza($datos, null); // null es resta
  			} else {
  				$this->Agregar($datos);
  			}
  		} else {
  			 Alerts::Alerta("error","Error!","No se encontro el producto!");
  		}
  	$this->VerProducto();
   }



   public function RestaVenta($datos){ // Rapida

  		if($this->ObtenerCantidad($datos["cod"]) >= 0){
  			if($_SESSION["orden"] == NULL){ $this->AddOrden(); }
  			
  			/// aqui determino si agrego o actualizo
  			$product = $this->ObtenerCantidadTicket($datos["cod"]);
  			if($datos["cantidad"] == NULL) $datos["cantidad"] = 1;
  			
  			if($product > 1){
  				$datos["cantidad"] = $product - $datos["cantidad"];
  				$this->Actualiza($datos, 1); // uno suma
  			} 
  		} else {
  			 Alerts::Alerta("error","Error!","No se encontro el producto!");
  		}
  	$this->VerProducto();
   }



	public function Agregar($datos) { // agrega el producto
		$db = new dbConn();

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
	    $db->insert("ticket", $datox);

	}




	public function Actualiza($datos,$func) { // agrega el producto suma de uno n uno
		$db = new dbConn();

	$pv = $this->ObtenerPrecio($datos["cod"], $datos["cantidad"]);
	$sumas = $pv * $datos["cantidad"];

    $stot=Helpers::STotal($sumas, $_SESSION['config_imp']);
    $im=Helpers::Impuesto($stot, $_SESSION['config_imp']);

	    $cambio = array();
	    $cambio["cant"] = $datos["cantidad"];
	    $cambio["pv"] = $pv;
	    $cambio["stotal"] = $stot;
	    $cambio["imp"] = $im;
	    $cambio["total"] = $stot + $im;
	    Helpers::UpdateId("ticket", $cambio, "cod='".$datos["cod"]."' and orden = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");

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


	public function ObtenerCantidadTicket($cod) { // obtine cantiad de productos
		$db = new dbConn();

	if ($r = $db->select("cant", "ticket", "WHERE cod = '$cod' and orden = ".$_SESSION["orden"]." and tx =  ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")){ 
        return $r["cant"];
    	} unset($r); 
    }




	public function AddOrden() { //leva el control del autoincremento de los clientes
		$db = new dbConn();

	    if ($r = $db->select("correlativo", "ticket_orden", "WHERE td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]." order by correlativo desc limit 1")) { 
	        $ultimoorden = $r["correlativo"];
	    } unset($r);  

	    	if($ultimoorden == NULL){ $ultimoorden = 0; }
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
					      <th scope="col">Total</th>';
					    
					    if($_SESSION["tipo_inicio"] == 1){
					    	echo '<th scope="col">OP</th>';
					    }
					    echo '<th scope="col">Borrar</th>
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
			    			<td><a id="modcant" op="91" cod="'.$b["cod"].'"><i class="fas fa-minus-circle red-text fa-lg"></i></a>  <a id="modcant" op="90" cod="'.$b["cod"].'"><i class="fas fa-plus-circle green-text fa-lg"></i></a></td>
			    			<td><a id="borrar-ticket" op="92" hash="'.$b["hash"].'"><i class="fas fa-times-circle red-text fa-lg"></i></a></td>
					</tr>';
				    }
				    	echo '</tbody>
							</table>';
		    } $a->close();

		    $this->Sonar();
		} else {
			echo '<div class="text-center">Ingrese un producto</div>
			<div align="center"><a data-toggle="modal" data-target="#ModalBusqueda" class="btn-floating btn-primary"><i class="fas fa-search"></i></a></div>';
		}    
	}



//// borrar
	
	public function CuentaProductos($orden){ // productde  de la tabla ticket
		$db = new dbConn();

		$a = $db->query("SELECT * FROM ticket WHERE orden = '$orden' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
		    
		    return $a->num_rows;
		    $a->close();
    }


	public function DelOrden($orden){ // elimina el registro de la orden
		$db = new dbConn();

		Helpers::DeleteId("ticket_orden", "correlativo = '$orden' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
		$_SESSION["orden"] = NULL;
		unset($_SESSION["orden"]);
    }


   public function DelVenta($hash){
	$db = new dbConn();

  	// borro el registro de ticket
  	Helpers::DeleteId("ticket", "hash = '$hash' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
  	// compruebo si hay mas productos sino elimino orden
	  	
	  	if($this->CuentaProductos($_SESSION["orden"]) == 0){
	  		$this->DelOrden($_SESSION["orden"]);
	  	}

  	$this->VerProducto();
   }












//////////////// factura

	public function AddTicketNum($efectivo) { //leva el control del autoincremento de los clientes
		$db = new dbConn();

	    if ($r = $db->select("num_fac", "ticket_num", "WHERE td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]." order by num_fac desc limit 1")) { 
	        $ultimoorden = $r["num_fac"];
	    } unset($r);  

			$datos = array();
		    $datos["fecha"] = date("d-m-Y");
		    $datos["hora"] = date("H:i:s");
		    $datos["num_fac"] = $ultimoorden + 1;
		    $datos["orden"] = $_SESSION["orden"];
		    $datos["efectivo"] = $efectivo;
		    $datos["edo"] = 1;
		    $datos["tx"] = $_SESSION["tx"];
		    $datos["hash"] = Helpers::HashId();
		    $datos["time"] = Helpers::TimeId();
		    $datos["td"] = $_SESSION["td"];
		    $db->insert("ticket_num", $datos); 
		
 		return $ultimoorden + 1;
	}


	public function DescontarProducto($factura) { // Descuenta los productods del inventario segun factura
		$db = new dbConn();

	    $a = $db->query("SELECT * FROM ticket WHERE num_fac = '$factura' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
	    foreach ($a as $b) {

	    	if ($r = $db->select("*", "producto", "WHERE cod = '".$b["cod"]."' and td = ".$_SESSION["td"]."")) { 
				$cant_p = $r["cantidad"];
				}  unset($r);  
		   	// regreso los valores a los productos
		   $cambio = array();
		   $cambio["cantidad"] = $cant_p - $b["cant"];
		   Helpers::UpdateId("producto", $cambio, "cod = '".$b["cod"]."' and td = ".$_SESSION["td"]."");

	    } $a->close();	

	}



   public function Facturar($datos){
  		$db = new dbConn();

  		$factura = $this->AddTicketNum($datos["efectivo"]);
 
	    $cambio = array();
	   	$cambio["num_fac"] = $factura;
	   	$cambio["tipo_pago"] = 1;
	   	Helpers::UpdateId("ticket", $cambio, "orden = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");  

	   	$cambios = array();
	   	$cambios["estado"] = 2;
	   	Helpers::UpdateId("ticket_orden", $cambios, "correlativo = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");  

	   	$this->DescontarProducto($factura);
	   	$this->FacturaResult($factura, $datos["efectivo"]);

	   	unset($_SESSION["orden"]);
   }





   public function FacturaResult($factura, $efectivo){
  		$db = new dbConn();

    $a = $db->query("SELECT sum(stotal), sum(imp), sum(total) FROM ticket WHERE num_fac = '$factura' and orden = ".$_SESSION["orden"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
		    foreach ($a as $b) {
		     $stotal=$b["sum(stotal)"]; $imp=$b["sum(imp)"]; $total=$b["sum(total)"];
		    } $a->close();

if($efectivo == NULL){
	$efectivo = $total;
}

$cambio = $efectivo - $total;
echo '<p class="text-center">Sub Total: '. Helpers::Dinero($stotal) .' ||  Impuestos: '. Helpers::Dinero($imp) . '</p>';

echo '<p class="text-center font-weight-bold">TOTAL:</p>';
echo '<div class="display-4 text-center font-weight-bold">'. Helpers::Dinero($total) .'</div> <hr>';

echo '<p class="text-center font-weight-bold">EFECTIVO:</p>';
echo '<div class="display-4 text-center font-weight-bold">'. Helpers::Dinero($efectivo) .'</div> <hr>';

echo '<p class="text-center font-weight-bold">CAMBIO:</p>'; 
echo '<div class="display-4 text-center font-weight-bold">'. Helpers::Dinero($cambio) . '</div>'; 


   }


	public function Sonar(){
		echo '<audio id="audioplayer" autoplay=true>
				  <source src="assets/sound/bleep.mp3" type="audio/mpeg">
				  <source src="assets/sound/bleep.ogg" type="audio/ogg">
				</audio>';
	}






} // Termina la lcase