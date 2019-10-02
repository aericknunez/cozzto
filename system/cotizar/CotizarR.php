<?php 
class Cotizar{

	public function __construct() { 
 	} 



   public function SumaVenta($datos){ // Rapida

  		if($this->ObtenerCantidad($datos["cod"]) > 0){
  			if($_SESSION["cotizacion"] == NULL){ $this->AddOrden(); }
  			
  			/// aqui determino si agrego o actualizo
  			if($datos["cantidad"] == NULL or $datos["cantidad"] == 0) $datos["cantidad"] = 1;
  			$product = $this->ObtenerCantidadTicket($datos["cod"]);
  			if($datos["cantidad"] == 1){
	  			$datos["cantidad"] = $product + 1;
  			}


  			if($product > 0){  				
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
  			if($_SESSION["cotizacion"] == NULL){ $this->AddOrden(); }
  			
  			/// aqui determino si agrego o actualizo
	  		if($datos["cantidad"] == NULL or $datos["cantidad"] == 0) $datos["cantidad"] = 1;
	  		$product = $this->ObtenerCantidadTicket($datos["cod"]);
  			if($datos["cantidad"] == 1){
	  			$datos["cantidad"] = $product - 1;
  			}
  			
  			if($product > 1){  				
  				$this->Actualiza($datos, 1); // uno suma
  			} 
  		} else {
  			 Alerts::Alerta("error","Error!","No se encontro el producto!");
  		}
  	$this->VerProducto();
   }



	public function AplicarDescuento() { //Aplica el descuento a los productos
		$db = new dbConn();
				    
		    $a = $db->query("SELECT * FROM cotizaciones WHERE cotizacion = '".$_SESSION["cotizacion"]."' and td = ".$_SESSION["td"]."");

		    if($a->num_rows > 0){
		    	foreach ($a as $b) {
		    		$datos["cantidad"] = $b["cant"];
		    		$datos["cod"] = $b["cod"];
		    		$this->Actualiza($datos, 1);
		    	}
		    } $a->close();

		    if($_SESSION['descuento_cot'] != NULL){
		 $lateral = new Laterales(); 
   		 $precio = $lateral->ObtenerTotal($_SESSION["cotizacion"]);
		  $texto = 'El total en esta venta es de: ' . $precio;
		  Alerts::Mensajex($texto,"success",$boton,$boton2);



		  $texto = 'Esta venta posee un descuento de : ' . $_SESSION['descuento_cot']. " %";
		  Alerts::Mensajex($texto,"danger",'<a id="quitar-descuento" op="156" class="btn btn-danger btn-rounded">Quitar Descuento</a>',$boton2);
		} else {
			$lateral = new Laterales();
			    $precio = $lateral->ObtenerTotal($_SESSION["cotizacion"]);
			  $texto = 'El total en esta venta sin descuento es de: ' . $precio;
			  Alerts::Mensajex($texto,"success",$boton,$boton2);
			} 

	}




	public function Agregar($datos) { // agrega el producto
		$db = new dbConn();

	$pv = $this->ObtenerPrecio($datos["cod"], $datos["cantidad"]);
	$sumas = $pv * $datos["cantidad"];

	if($_SESSION['descuento_cot'] != NULL){
		$sumas = Helpers::DescuentoTotalCot($sumas);
		$pv = Helpers::DescuentoTotalCot($pv);
	}

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
	    $datox["cotizacion"] = $_SESSION["cotizacion"];
	    $datox["user"] = $_SESSION['user'];
	    $datox["edo"] = 1;
	    $hash = Helpers::HashId();
	    $datox["hash"] = $hash;
		$datox["time"] = Helpers::TimeId();
	    $datox["td"] = $_SESSION["td"];
	    $db->insert("cotizaciones", $datox);

	}




	public function Actualiza($datos,$func) { // agrega el producto suma de uno n uno
		$db = new dbConn();

	$pv = $this->ObtenerPrecio($datos["cod"], $datos["cantidad"]);
	$sumas = $pv * $datos["cantidad"];

	if($_SESSION['descuento_cot'] != NULL){
		$sumas = Helpers::DescuentoTotalCot($sumas);
		$pv = Helpers::DescuentoTotalCot($pv);
	}

    $stot=Helpers::STotal($sumas, $_SESSION['config_imp']);
    $im=Helpers::Impuesto($stot, $_SESSION['config_imp']);

	    $cambio = array();
	    $cambio["cant"] = $datos["cantidad"];
	    $cambio["pv"] = $pv;
	    $cambio["stotal"] = $stot;
	    $cambio["imp"] = $im;
	    $cambio["total"] = $stot + $im;
	    Helpers::UpdateId("cotizaciones", $cambio, "cod='".$datos["cod"]."' and cotizacion = ".$_SESSION["cotizacion"]." and td = ".$_SESSION["td"]."");

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

	if ($r = $db->select("cant", "cotizaciones", "WHERE cod = '$cod' and cotizacion = ".$_SESSION["cotizacion"]." and td = ".$_SESSION["td"]."")){ 
        return $r["cant"];
    	} unset($r); 
    }




	public function AddOrden() { //leva el control del autoincremento de las cotizaciones
		$db = new dbConn();

	    if ($r = $db->select("correlativo", "cotizaciones_data", "WHERE td = ".$_SESSION["td"]." order by correlativo desc limit 1")) { 
	        $ultimoorden = $r["correlativo"];
	    } unset($r);  

	    	if($ultimoorden == NULL){ $ultimoorden = 0; }
			$datos = array();
		    $datos["cliente"] = $_SESSION["cliente_c"];
		    $datos["correlativo"] = $ultimoorden + 1;
		    $datos["fecha"] = date("d-m-Y");
		    $datos["hora"] = date("H:i:s");
		    $datos["fechaF"] = Fechas::Format(date("d-m-Y"));
		    $datos["edo"] = 1;
		    $datos["hash"] = Helpers::HashId();
		    $datos["time"] = Helpers::TimeId();
		    $datos["td"] = $_SESSION["td"];
		    $db->insert("cotizaciones_data", $datos); 
		
		$_SESSION["cotizacion"] = $ultimoorden + 1;    
	}




/////////// mostrar los productos agregados



	public function VerProducto() { //leva el control del autoincremento de los clientes
		$db = new dbConn();
		    
		if($_SESSION["cotizacion"] != NULL){
		    
		    $a = $db->query("SELECT * FROM cotizaciones WHERE cotizacion = ".$_SESSION["cotizacion"]." and td = ".$_SESSION["td"]."");

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
					      <th scope="col">OP</th><th scope="col">Borrar</th>
					    </tr>
					  </thead>
					  <tbody>';
		    		foreach ($a as $b) {
		    		   echo '<tr>
						      <th scope="row"><a href="?modal=cantidadc&cant='.$b["cant"].'&cod='.$b["cod"].'">'.$b["cant"].'</a></th>
						      <td>'.$b["producto"].'</td>
						      <td>'.$b["pv"].'</td>
						      <td>'.$b["stotal"].'</td>
						      <td>'.$b["imp"].'</td>
						      <td>'.$b["total"].'</td>
			    			<td><a id="modcant" op="151" cod="'.$b["cod"].'"><i class="fas fa-minus-circle red-text fa-lg"></i></a>  <a id="modcant" op="150" cod="'.$b["cod"].'"><i class="fas fa-plus-circle green-text fa-lg"></i></a></td>
			    			<td><a id="borrar-ticket" op="152" hash="'.$b["hash"].'"><i class="fas fa-times-circle red-text fa-lg"></i></a></td>
					</tr>';
				    }
				    	echo '</tbody>
							</table>';
		    } $a->close();

		    $this->Sonar();
		} 
		  
	}



//// borrar
	
	public function CuentaProductos($orden){ // productde  de la tabla ticket
		$db = new dbConn();

		$a = $db->query("SELECT * FROM cotizaciones WHERE cotizacion = '$orden' and td = ".$_SESSION["td"]."");
		    
		    return $a->num_rows;
		    $a->close();
    }


	public function DelOrden($cotizacion){ // elimina el registro de la orden
		$db = new dbConn();

		Helpers::DeleteId("cotizaciones_data", "correlativo = '$cotizacion' and td = ".$_SESSION["td"]."");
		
		if(isset($_SESSION["cotizacion"])) unset($_SESSION["cotizacion"]);
		if(isset($_SESSION["descuento_cot"])) unset($_SESSION["descuento_cot"]);

		if(isset($_SESSION["cliente_cot"])) unset($_SESSION["cliente_cot"]);
		if(isset($_SESSION["cliente_nombre"])) unset($_SESSION["cliente_credito"]);		
		echo '<script>
			window.location.href="?cotizar"
		</script>';

    }


   public function DelVenta($hash, $ver){
	$db = new dbConn();

  	// borro el registro de ticket
  	Helpers::DeleteId("cotizaciones", "hash = '$hash' and td = ".$_SESSION["td"]."");
  	// compruebo si hay mas productos sino elimino orden
	  	
	  	if($this->CuentaProductos($_SESSION["cotizacion"]) == 0){
	  		$this->DelOrden($_SESSION["cotizacion"]);
	  	}

	  	if($ver == NULL){
	  		$this->VerProducto();
	  	}
	  	if($ver == 1 and $this->CuentaProductos($_SESSION["cotizacion"]) == 0){
	  		$this->VerProducto();
	  	}
   }



   	public function Cancelar() { //cancela toda la orden
		$db = new dbConn();

			$can = $db->query("SELECT * FROM cotizaciones WHERE cotizacion = ".$_SESSION["cotizacion"]." and td = ".$_SESSION["td"]."");
		    
		    foreach ($can as $cancel) {
		    	$hash = $cancel["hash"];	    
		    	$this->DelVenta($hash, 1);
		    }

		    if($can->num_rows == 0){
		    	$this->DelOrden($_SESSION["cotizacion"]);
		    }
		 
		 $can->close();

		
		echo '<script>
			window.location.href="?cotizar"
		</script>';	
	}







	public function Sonar(){
		echo '<audio id="audioplayer" autoplay=true>
				  <source src="assets/sound/bleep.mp3" type="audio/mpeg">
				  <source src="assets/sound/bleep.ogg" type="audio/ogg">
				</audio>';
	}



///////////////////// agregar credito

  public function ClienteBusqueda($dato){ // Busqueda para cliente
    $db = new dbConn();

          $a = $db->query("SELECT * FROM clientes WHERE nombre like '%".$dato["keyword"]."%' or documento like '%".$dato["keyword"]."%' and td = ".$_SESSION["td"]." limit 10");
           if($a->num_rows > 0){
            echo '<table class="table table-sm table-hover">';
    foreach ($a as $b) {
               echo '<tr>
                      <td scope="row"><a id="select-c" hash="'. $b["hash"] .'" nombre="'. $b["nombre"] .'">'. $b["nombre"] .'   ||   '. $b["documento"].'</a></td>
                    </tr>'; 
    }  $a->close();

        echo '
        </table>';
          } else {
            echo "El criterio de busqueda no corresponde a un cliente";
          }
  }


  public function AgregaCliente($dato){ // Busqueda para cliente
    $db = new dbConn();

       	$_SESSION["cliente_cot"] = $dato["hash"]; // asigna el credito
		$_SESSION["cliente_nombre"] = $dato["nombre"];

		$this->AddOrden();

		echo '<script>
			window.location.href="?cotizar"
		</script>';
  }





	public function GuardarCotizacion() { //guarda la cotizacion
		$db = new dbConn();


			$can = $db->query("SELECT * FROM cotizaciones WHERE cotizacion = ".$_SESSION["cotizacion"]." and td = ".$_SESSION["td"]."");
		    
		    if($can->num_rows > 0){
		    	
		    			$cambios = array();
					   	$cambios["edo"] = 2;
					   	Helpers::UpdateId("cotizaciones_data", $cambios, "correlativo = ".$_SESSION["cotizacion"]." and td = ".$_SESSION["td"].""); 

						unset($_SESSION["cotizacion"]);

		    } else {
		    	$this->DelOrden($_SESSION["cotizacion"]);
		    }
		 
		 $can->close();

		echo '<script>
			window.location.href="?cotizar"
		</script>';
	}
	

	public function SelectCotizacion($cotizacion) { //Seleccioa cotizacion
		$db = new dbConn();

		$cambios = array();
	   	$cambios["edo"] = 1;
	   	Helpers::UpdateId("cotizaciones_data", $cambios, "correlativo = '$cotizacion' and td = ".$_SESSION["td"].""); 

		$_SESSION["cotizacion"] = $orden;
	}









} // Termina la lcase