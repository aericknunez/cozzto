<?php  

class Venta{

	public function __construct(){

	}

	public function ComprobarProducto($cod,$mesa,$cliente) {
		$db = new dbConn();

		$a = $db->query("SELECT * FROM ticket_temp WHERE cod = '$cod' and mesa = '$mesa' and cliente = '$cliente' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
		if($a->num_rows == 0){
			return FALSE;
		} else {
			return TRUE;
		}
		$a->close();
	}

	public function CrearMesa($clientes) {
		$db = new dbConn();

	    if ($r = $db->select("mesa", "mesa", "WHERE td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]." order by mesa desc limit 1")) { 
	        $ultimamesa = $r["mesa"];
	    } unset($r);  

			$datos = array();
		    $datos["clientes"] = $clientes;
		    $datos["mesa"] = $ultimamesa + 1;
		    $datos["empleado"] = $_SESSION["nombre"];
		    $datos["fecha"] = date("d-m-Y");
		    $datos["hora"] = date("H:i:s");
		    $datos["estado"] = 1;
		    $datos["tx"] = $_SESSION["tx"];
		    $datos["td"] = $_SESSION["td"];
		    $db->insert("mesa", $datos); 
		
		$_SESSION["mesa"] = $ultimamesa + 1;    
	}


	public function Agregar($cod,$mesa,$cliente,$imp) {
		$db = new dbConn();

		if ($r = $db->select("nombre, precio", "precios", "WHERE cod = '$cod' and td = ".$_SESSION["td"]."")) { 
        $nombre=$r["nombre"];
        $pv=$r["precio"];
    	} unset($r); 

    	$stot=Helpers::STotal($pv, $imp);
    	$im=Helpers::Impuesto($stot, $imp);

		$datos = array();
	    $datos["cod"] = $cod;
	    $datos["cant"] = 1;
	    $datos["producto"] = $nombre;
	    $datos["pv"] = $pv;	    				   
	    $datos["stotal"] = $stot;	    				   
	    $datos["imp"] = $im;
	    $datos["total"] = $stot + $im;;
	    $datos["num_fac"] = 0;
	    $datos["fecha"] = date("d-m-Y");
	    $datos["hora"] = date("H:i:s");
	    $datos["mesa"] = $mesa;
	    $datos["cliente"] = $cliente;
	    $datos["cancela"] = $cliente;
	    $datos["cajero"] = $_SESSION['nombre'];
	    $datos["tipo_pago"] = 1;
	    $datos["user"] = $_SESSION['user'];
	    $datos["gravado"] = 1;
	    $datos["tx"] = $_SESSION['tx'];
	    $datos["fechaF"] = Fechas::Format(date("d-m-Y"));
	    $datos["edo"] = 1;
	    $datos["td"] = $_SESSION["td"];
	    if ($db->insert("ticket_temp", $datos)) {
	        // Agregamos la factura
	    }  else {
	    	echo "Error!!";
	    }

	}



	public function Actualizar($cod,$mesa,$cliente,$imp) {
		$db = new dbConn();

		if ($r = $db->select("cant, pv", "ticket_temp", "WHERE cod = '$cod' and mesa = '$mesa' and cliente = '$cliente' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
        $cantx=$r["cant"];
        $pv=$r["pv"];        
    	} unset($r); 

    	$cant = $cantx + 1;
    	$total = $pv * $cant;

    	$stot=Helpers::STotal($total, $imp);
    	$im=Helpers::Impuesto($stot, $imp);

    	    $cambio = array();
		    $cambio["cant"] = $cant;
		    $cambio["stotal"] = $stot;
		    $cambio["imp"] = $im;
		    $cambio["total"] = $stot + $im;
		    if ($db->update("ticket_temp", $cambio, "WHERE cod = '$cod' and mesa = '$mesa' and cliente = '$cliente' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) {
		        
		    } 


	}


	public function Execute($cod,$mesa,$cliente,$imp) {
		$db = new dbConn();

		if($this->ComprobarProducto($cod,$mesa,$cliente) == FALSE){
			$this->Agregar($cod,$mesa,$cliente,$imp);
		} else {
			$this->Actualizar($cod,$mesa,$cliente,$imp);
		}

	}


///////////////////////////////////////////////////////////
public function OtrasVentas($cod,$mesa,$cliente,$imp,$nombre,$pv) {
		$db = new dbConn();

    	$stot=Helpers::STotal($pv, $imp);
    	$im=Helpers::Impuesto($stot, $imp);

		$datos = array();
	    $datos["cod"] = $cod;
	    $datos["cant"] = 1;
	    $datos["producto"] = $nombre;
	    $datos["pv"] = $pv;	    				   
	    $datos["stotal"] = $stot;	    				   
	    $datos["imp"] = $im;
	    $datos["total"] = $stot + $im;;
	    $datos["num_fac"] = 0;
	    $datos["fecha"] = date("d-m-Y");
	    $datos["hora"] = date("H:i:s");
	    $datos["mesa"] = $mesa;
	    $datos["cliente"] = $cliente;
	    $datos["cancela"] = $cliente;
	    $datos["cajero"] = $_SESSION['nombre'];
	    $datos["tipo_pago"] = 1;
	    $datos["user"] = $_SESSION['user'];
	    $datos["gravado"] = 1;
	    $datos["tx"] = $_SESSION['tx'];
	    $datos["fechaF"] = Fechas::Format(date("d-m-Y"));
	    $datos["edo"] = 1;
	    $datos["td"] = $_SESSION["td"];
	    if ($db->insert("ticket_temp", $datos)) {
	        // Agregamos la factura
	    }

	}


///////////////////////////////////////////////////////////


	public function AgregarOpcion($cod,$opcion,$mesa,$cliente,$identificador) {
		$db = new dbConn();

		if($identificador == NULL){
		$a = $db->query("SELECT max(id) FROM ticket_temp WHERE td = ".$_SESSION["td"]."");
    	foreach ($a as $b) {
        $identificador=$b["max(id)"];
    	} $a->close(); }

    	if($cod == NULL){
    		    if ($r = $db->select("cant", "ticket_temp", "WHERE id = $identificador and mesa=$mesa and cliente=$cliente and td=".$_SESSION["td"]."")) { 
			        $cod=$r["cant"];
			    } unset($r); }
		
		$datos = array();
	    $datos["cod"] = $cod;
	    $datos["identificador"] = $identificador;
	    $datos["opcion"] = $opcion;
	    $datos["mesa"] = $mesa;
	    $datos["cliente"] = $cliente;
	    $datos["td"] = $_SESSION["td"];
	    $db->insert("opciones_ticket", $datos);

	    return $identificador;
	}

	public function BorrarOpcion($cod, $identificador, $activo) {
		$db = new dbConn();
		$a = $db->query("SELECT * FROM opciones_ticket WHERE cod = '$cod' and identificador='$identificador' and td = ".$_SESSION["td"]."");
		if($a->num_rows > 0){

			 if($db->delete("opciones_ticket", "WHERE cod='$cod' and identificador='$identificador' and opcion = $activo and td = ".$_SESSION["td"]." limit 1")){
			 	 Alerts::Alerta("success","Exito!","Opcion Eliminada corectamente!");
			 } else {
			 	 Alerts::Alerta("error","Error!","Ocurrio un error desconocido!");
			 }

		} $a->close();
	    
   	}

   	public function ActualizarOpcion($cod, $identificador, $cambios, $activo){
		$db = new dbConn();
		
		    $cambio = array();
		    $cambio["opcion"] = $cambios;    
		    if ($db->update("opciones_ticket", $cambio, "WHERE cod=$cod and identificador = $identificador and opcion = $activo and td = ".$_SESSION["td"]." limit 1")) 
		    {
		         Alerts::Alerta("success","Exito!","Opcion Cambiada corectamente!"); 
		    } else {
		        Alerts::Alerta("error","Error!","Ocurrio un error desconocido!");
		    }
	    
   	}

	public function VerProductosMesa($mesa){
		$db = new dbConn();
		$a = $db->query("SELECT * FROM ticket_temp WHERE mesa = '$mesa' and tx = ".$_SESSION["tx"]." and td = ". $_SESSION["td"] ."");
		return $a->num_rows; 
		$a->close();
	}



//////////////////////////////////////////////////////////////
	public function VerFactura($mesa) {
		$db = new dbConn();

		if($this->VerProductosMesa($_SESSION["mesa"]) != 0 && !isset($_GET["modal"])) {

		    $a = $db->query("SELECT * FROM ticket_temp WHERE producto != 'Producto-Especial' and mesa = '$mesa' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."  and num_fac= 0");
		    if($a->num_rows == 0){
		    echo '<div align="center"><br><img src="assets/img/logo/'. $_SESSION['config_imagen'] .'" alt="" class="img-fluid hoverable"></div>';
		    } else {
		    	echo '<br><h3>'.$_SESSION['config_cliente'].'</h3>';
		    	echo '<table class="table table-striped table-sm">
					  <thead>
					    <tr>
					      <th scope="col">#</th>
					      <th scope="col">Producto</th>
					      <th scope="col">Precio</th>
					      <th scope="col">Total</th>
					      <th scope="col">
					      <a id="borrar-factura" op="24" mesa="'. $mesa .'">
					      <span class="badge badge-pill pink"><i class="fa fa-trash fa-2x" aria-hidden="true"></i></span>
					      </a>
					      </th>
					    </tr>
					  </thead>
					  <tbody>';

		    	 foreach ($a as $b) {
		    	     echo '<tr>
				      <th scope="row">'. $b["cant"] .'</th>
				      <td>'. $b["producto"] .'</td>
				      <td>'. $b["pv"] .'</td>
				      <td>'. $b["total"] .'</td>
				      <td><a id="borrar-producto" op="23" iden="'. $b["id"] .' mesa="'. $mesa .'">
				      <span class="badge red"><i class="fa fa-minus-circle" aria-hidden="true"></i></span>
				      </a>
				      </td>
				    </tr>';
		    	}
		    	echo '</tbody>
					</table>';

				    $s = $db->query("SELECT sum(total) FROM ticket_temp WHERE mesa = '$mesa' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and num_fac= 0");
				    foreach ($s as $t) {
				        $max=$t["sum(total)"];
				    } $s->close();
				   
				    if($_SESSION["rtn"] != NULL){ echo "RTN:" . $_SESSION["rtn"]; }

				    if($_SESSION["tx"] == 0){
				    		if($_SESSION["noimprimir"] != NULL){
				    		echo '<a id="cambiar-pantalla-inicio" op="87"><h1 class="text-danger">Total: '. Helpers::Format($max) .'</h1></a>';
						    } else {
						    		if($_SESSION['config_propina'] != 0.00){
						    		echo '<p>Subtotal: '.$max.' | Propina '.$_SESSION['config_propina'].'% : '. Helpers::Dinero(Helpers::Propina($max)) .'</p>'; }

						    		echo '<a id="cambiar-pantalla-inicio" op="87"><h1>Total: '. Helpers::Dinero(Helpers::PropinaTotal($max)) .'</h1></a>';
							}
				    } else {
				    			if($_SESSION['config_propina'] != 0.00){
				    		echo '<p>Subtotal: '.$max.' | Propina '.$_SESSION['config_propina'].'% : '.Helpers::Dinero( Helpers::Propina($max)) .'</p>'; }

				    		echo '<h1>Total: '. Helpers::Dinero(Helpers::PropinaTotal($max)) .'</h1>';
				    }
				    	    
				    

				    // <div class="switch">
					//   <label>
					//    || Agregar RTN ||  Off
					//     <input type="checkbox"  id="rtn" name="rtn" >
					//     <span class="lever"></span> On 
					//   </label>
					// </div>
				     echo '<form action="application/src/routes.php?op=21" method="post"  name="form-vender" id="form-vender" >
		        	<input type="text" id="total" name="total" class="form-control mb-1" placeholder="100.00" autofocus>
					<div align="center">';

				

				echo '<button class="white" type="submit" name="btn-vender" id="btn-vender"><img src="assets/img/imagenes/print.png"></button>';
					
					if(!isset($_SESSION['view'])){
					echo '<a href="?modal=modificar&mesa='.$_SESSION["mesa"].'&view=0" class="btn-floating blue"><i class="fa fa-refresh" aria-hidden="true"></i></a>'; }
					else {
						if($_SESSION['config_imprimir_antes'] != NULL){
							echo '<a href="?modal=factura_imprimir&mesa='.$_SESSION["mesa"].'&efectivo=" class="btn-floating blue"><i class="fa fa-print" aria-hidden="true"></i></a>';	
						}
						
					}
					
					echo '</div>
					</form>';


		    } $a->close();
		   

			} elseif(isset($_GET["modal"])) {
				
			} else {

				if($this->VerProductosMesa($_SESSION["mesa"]) == 0){
					echo '<div align="center"><h2><a id="cambiar-pantalla-inicio" op="88">'.$_SESSION["config_cliente"].'</a></h2></div><br>';	
				}

				echo '<div align="center"><img src="assets/img/logo/'. $_SESSION['config_imagen'] .'" alt="" class="img-fluid hoverable"></div>';

				if($this->VerProductosMesa($_SESSION["mesa"]) == 0 and $_SESSION["tx"] == 0){
					echo '<div align="center" class="border border-light"><h2>'. Corte::Porcentaje() .'</h2></div>';
				}

				
			}
				
	}


//////////////////////////////////////////////////////////////
	public function VerFacturaCliente($mesa,$cancela) {
		$db = new dbConn();

		    $a = $db->query("SELECT * FROM ticket_temp WHERE producto != 'Producto-Especial' and mesa = '$mesa' and cancela = '$cancela' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and num_fac= 0");
		    if($a->num_rows == 0){
		    echo '<br><img src="assets/img/logo/'. $_SESSION['config_imagen'] .'" alt="" class="img-fluid hoverable">';
		    } else {
		    	echo '<br><h3>'.$_SESSION['config_cliente'].'</h3>';
		    	echo '<table class="table table-striped table-sm">
					  <thead>
					    <tr>
					      <th scope="col">#</th>
					      <th scope="col">Producto</th>
					      <th scope="col">Precio</th>
					      <th scope="col">Total</th>
					    </tr>
					  </thead>
					  <tbody>';

		    	 foreach ($a as $b) {
		    	     echo '<tr>
				      <th scope="row">'. $b["cant"] .'</th>
				      <td>'. $b["producto"] .'</td>
				      <td>'. $b["pv"] .'</td>
				      <td>'. $b["total"] .'</td>
				    </tr>';
		    	}
		    	echo '</tbody>
					</table>';

				    $s = $db->query("SELECT sum(total) FROM ticket_temp WHERE mesa = '$mesa' and cancela = '$cancela' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and num_fac= 0");
				    foreach ($s as $t) {
				        $max=$t["sum(total)"];
				    } $s->close();

				    if($_SESSION['config_propina'] != 0.00){
						    		echo '<p>Subtotal: '.$max.' | Propina '.$_SESSION['config_propina'].'% : '. Helpers::Dinero(Helpers::Propina($max)) .'</p>'; }

				    echo "<h1>Total: ". Helpers::Dinero(Helpers::PropinaTotal($max)) ."</h1>";

				 //    <div class="switch">
					//   <label>
					//    || Agregar RTN ||  Off
					//     <input type="checkbox"  id="rtn" name="rtn" >
					//     <span class="lever"></span> On 
					//   </label>
					// </div>

				     echo '<form action="application/src/routes.php?op=25" method="post"  name="form-vender" id="form-vender" >
		        	
					<input type="text" id="total" name="total" class="form-control mb-1" placeholder="100.00" autofocus>

					<input type="hidden" id="cancela" name="cancela" value="'.$cancela.'">

					<div align="center">
					   <button class="white" type="submit" name="btn-vender" id="btn-vender"><img src="assets/img/imagenes/print.png"></button>
					</div>
					</form>';

		    } $a->close();
		   

	}



	public function VerProductosFactura($mesa) {
		$db = new dbConn();

		if($_SESSION["mesa"] != NULL) {

		    $a = $db->query("SELECT * FROM ticket_temp WHERE producto != 'Producto-Especial' and mesa = '$mesa' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."  and num_fac= 0");
		    if($a->num_rows == 0){
		    echo '<div align="center"><br><img src="assets/img/logo/'. $_SESSION['config_imagen'] .'" alt="" class="img-fluid hoverable"></div>';
		    } else { 	
		    	echo '<br><table class="table table-striped table-sm">
					  <thead>
					    <tr>
					      <th scope="col">Cliente</th>
					      <th scope="col">Producto</th>
					      <th scope="col">Precio</th>
					      <th scope="col">Total</th>
					      <th scope="col"></th>
					    </tr>
					  </thead>
					  <tbody>';

		    	 foreach ($a as $b) {
		    	 		$i = 1;
		    	 		while($i <= $b["cant"]){
		    	 			echo '<tr>
						      <th scope="row">'. $b["cliente"] .'</th>
						      <td>'. $b["producto"] .'</td>
						      <td>'. $b["pv"] .'</td>
						      <td>'. $b["total"] .'</td>
						      <td><a id="ver-producto" op="56" iden="'. $b["id"] .'" cod="'. $i .'" mesa="'. $mesa .'">
						      <span class="badge red"><i class="fa fa-coffee" aria-hidden="true"></i></span>
						      </a></td>
						    </tr>';
		    	 		$i = $i + 1;
		    	 		}
		    	     
		    	}
		    	echo '</tbody>
					</table>';
			   

		    } $a->close();
		}
	}



/////////////////////////////////////////////////////facturar //

	public function Facturar($mesa,$efectivo) {
		$db = new dbConn();

		/// buscar ultima factura para aplicarla
		$r = $db->select("num_fac", "ticket_num", "WHERE edo = 1 and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." order by num_fac desc limit 1");
			if($r["num_fac"] == 0){ $ultimon = "1"; } 
	       	else {$ultimon = $r["num_fac"] + 1; } unset($r); 
	    // actualizar ticket
	        $cambio = array();
		    $cambio["num_fac"] = $ultimon;
		    if ($db->update("ticket_temp", $cambio, "WHERE td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]." and mesa = $mesa and num_fac = 0")) {
		// agregar ticket num
		    $datos = array();
		    $datos["fecha"] = date("d-m-Y");
		    $datos["hora"] = date("H:i:s");
		    $datos["num_fac"] = $ultimon;
		    $datos["mesa"] = $mesa;
		    $datos["efectivo"] = $efectivo;
		    $datos["edo"] = 1;
		    $datos["tx"] = $_SESSION["tx"];
		    $datos["td"] = $_SESSION["td"];
		    $db->insert("ticket_num", $datos);

	    // actualizar mesa
    	    $cambio = array();
		    $cambio["estado"] = "2";
		    $db->update("mesa", $cambio, "WHERE td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]." and mesa = $mesa"); 

		    unset($_SESSION["mesa"]);

		    if($_SESSION['config_propina'] != 0.00){ ///  prara agregarle la propina
			$this->AgregarPropina($ultimon); }

		    $this->DataCopy($mesa, $ultimon);

		    return TRUE;
		    }
		}



	public function FacturarCliente($mesa,$efectivo,$cancela) {
		$db = new dbConn();

		/// buscar ultima factura para aplicarla
		$r = $db->select("num_fac", "ticket_num", "WHERE edo = 1 and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." order by num_fac desc limit 1");
			if($r["num_fac"] == 0){ $ultimon = "1"; } 
	       	else {$ultimon = $r["num_fac"] + 1; } unset($r); 
	    // actualizar ticket
	        $cambio = array();
		    $cambio["num_fac"] = $ultimon;
		    if ($db->update("ticket_temp", $cambio, "WHERE cancela = $cancela and td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]." and mesa = $mesa and num_fac = 0")) {
		// agregar ticket num
		    $datos = array();
		    $datos["fecha"] = date("d-m-Y");
		    $datos["hora"] = date("H:i:s");
		    $datos["num_fac"] = $ultimon;
		    $datos["mesa"] = $mesa;
		    $datos["efectivo"] = $efectivo;
		    $datos["edo"] = 1;
		    $datos["tx"] = $_SESSION["tx"];
		    $datos["td"] = $_SESSION["td"];
		    $db->insert("ticket_num", $datos);

	    // actualizar mesa
	    $a = $db->query("SELECT * FROM ticket_temp WHERE td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]." and mesa = $mesa and num_fac = 0");
		if($a->num_rows == 0){
			$cambio = array();
		    $cambio["estado"] = "2";
		    $db->update("mesa", $cambio, "WHERE td = ".$_SESSION["td"]." and tx = ".$_SESSION["tx"]." and mesa = $mesa"); 

		    unset($_SESSION["mesa"]);

		}
		$a->close();
		
		if($_SESSION['config_propina'] != 0.00){ ///  prara agregarle la propina
		$this->AgregarPropina($ultimon); }

    	     $this->DataCopy($mesa, $ultimon);
		    return TRUE;
		    }
		}



	public function DataCopy($mesa, $factura){
		$db = new dbConn();
			$a = $db->query("INSERT INTO ticket (cod, cant, producto, pv, stotal, imp, total, num_fac, fecha, hora, mesa, cliente, cancela, cajero, tipo_pago, user, gravado, tx, fechaF, edo, td) 
				SELECT cod, cant, producto, pv, stotal, imp, total, num_fac, fecha, hora, mesa, cliente, cancela, cajero, tipo_pago, user, gravado, tx, fechaF, edo, td 
				FROM ticket_temp WHERE mesa = '$mesa' and num_fac = '$factura'");
			unset($a);

		}	


	public function AgregarPropina($factura){
		$db = new dbConn();
		//obtener total y propina
			
			$ar = $db->query("SELECT sum(total) FROM ticket_temp where num_fac = '$factura' and tx = ".$_SESSION['tx']." and td = ".$_SESSION['td']."");
		    foreach ($ar as $br) {
		     $totalpro = $br["sum(total)"];
		    } $ar->close();	
		    	
		// agregar ticket propina
		    $datos = array();    
		    $datos["num_fac"] = $factura;
		    $datos["propina"] = $_SESSION['config_propina'];
		    $datos["efectivo"] = $totalpro;
		    $datos["total"] = Helpers::Propina($totalpro);
		    $datos["fecha"] = date("d-m-Y");
		    $datos["hora"] = date("H:i:s");
		    $datos["tx"] = $_SESSION["tx"];
		    $datos["td"] = $_SESSION["td"];
		    $db->insert("ticket_propina", $datos);

	}
///////////////////////////////////////////////////////////////////
	public function BorrarProducto($iden,$imp) {
		$db = new dbConn();
		    
		    // obtengo los datos para poder determinar si actualizo o borro
		    if ($r = $db->select("cant, pv, cod", "ticket_temp", "WHERE id = '$iden'")) { 
        	$cantidad = $r["cant"];
        	$pv = $r["pv"];
        	$codigos = $r["cod"];
   			 } unset($r);  

   			 // obtengo datos si tiene opcion activada, si la tiene borro todos los productos
   			 $a = $db->query("SELECT * FROM opciones_ticket WHERE identificador = '$iden' and td = ".$_SESSION["td"]."");
				$comprobacion = $a->num_rows; $a->close();
   			 
   			 if($comprobacion > 0){ // si tiene opciones activado. borro todo
   			 	$db->delete("ticket_temp", "WHERE id='$iden' limit 1");
   			 	$db->delete("opciones_ticket", "WHERE identificador='$iden' and td = ".$_SESSION["td"]."");

   			 } else { // sino borro o actualizo

   			 if($cantidad > 1){
   					$canti = $cantidad - 1;
   			 		$totales = $pv * $canti;
   			 		$stot=Helpers::STotal($totales, $imp);
    				$im=Helpers::Impuesto($stot, $imp);

   			 	    $cambio = array();
				    $cambio["cant"] = $canti;				    
				   	$cambio["pv"] = $pv;
				    $cambio["stotal"] = $stot;
				    $cambio["imp"] = $im;
				    $cambio["total"] =  $stot + $im;
				    $db->update("ticket_temp", $cambio, "WHERE id='$iden' limit 1");
		   			 } else {
		   			 	    $db->delete("ticket_temp", "WHERE id='$iden' limit 1");
		   			 }

		   			 /////////////////////////// borrar si es venta especial
		   			 if($codigos == 8889){ // si es pollo especial
						Especial::BorrarTodo(NULL);
					}
					////////
				}
			// comprueba si aun hay productos en la mesa para eliminar o mantener esta
   		$x = $db->query("SELECT * FROM ticket_temp WHERE mesa = ".$_SESSION["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
			if($x->num_rows == NULL){
				$db->delete("mesa", "WHERE mesa=".$_SESSION["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and estado = 1");
		        unset($_SESSION["mesa"]);
		        echo '<script>
						window.location.href="?"
		        	</script>';
			}
			$x->close();
	 
	} 



	public function BorrarFactura($mesa) {
		$db = new dbConn();
		    
		     if ( $db->delete("ticket_temp", "WHERE mesa='$mesa' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) {
		        
		        $db->delete("mesa", "WHERE mesa='$mesa' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and estado = 1");

		        $db->delete("mesa_nombre", "WHERE mesa='$mesa' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");

		        unset($_SESSION["mesa"]);
		        echo '<script>
						window.location.href="?"
		        	</script>';
	        
		    }

   	}





// termina la clase
 }


?>