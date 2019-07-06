<?php 
class Mesa{

	public function __construct(){

	}

	public function Sumar(){
	    $_SESSION["nclientes"] = $_SESSION["nclientes"] + 1;
	    echo $_SESSION["nclientes"];
	}


	public function Restar(){
	    if($_SESSION["nclientes"] > 1){
	    $_SESSION["nclientes"] = $_SESSION["nclientes"] - 1;	
	    }
	    echo $_SESSION["nclientes"];
	}


		public function AddCliente($mesa) {
		$db = new dbConn();

		    if ($r = $db->select("clientes", "mesa", "WHERE mesa = ". $mesa ." and tx = ".$_SESSION["tx"]." and td = ". $_SESSION["td"] ."")) { 
		        $clientes = $r["clientes"] + 1;
		    }unset($r);  

			$cambio = array();
		    $cambio["clientes"] = $clientes;
		    if ($db->update("mesa", $cambio, "WHERE mesa='$mesa' and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) {
		        Alerts::Alerta("success","Exito!","Cliente Agregado corectamente!");
		    }
	}


	public function VerClientes($mesa){
			$db = new dbConn();

			if ($r = $db->select("clientes", "mesa", "WHERE mesa = ".$mesa." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."")) { 
			        $clientes= $r["clientes"];} unset($r);

			echo '<div class="row justify-content-center">';
			for ($x = 1; $x <= $clientes; $x++) {

				if($_SESSION['clientselect'] == $x){
					echo '<a id="cambiar-cliente" op="45" select="0">
					<figure class="figure">
			    	<img src="assets/img/imagenes/cliente_select.png" class="figure-img img-fluid z-depth-2 rounded-circle"  alt="hoverable" >
			    <figcaption class="figure-caption text-center">Cliente '.$x.'</figcaption>
				</figure>
				</a>  &nbsp &nbsp &nbsp';
				} else {
					echo '<a id="cambiar-cliente" op="45" select="'. $x .'">
					<figure class="figure">
			    	<img src="assets/img/imagenes/cliente.png" class="figure-img img-fluid z-depth-2 rounded-circle"  alt="hoverable" >
			    <figcaption class="figure-caption text-center">Cliente '.$x.'</figcaption>
				</figure>
				</a>  &nbsp &nbsp &nbsp';
				}
			
			     }
			echo '</div>';
	}	



	public function VerIconos($mesa){
			$db = new dbConn();
			if($_SESSION['clientselect'] != null){
			include_once '../iconos/iconos_'.$_SESSION["td"].'.php';
			} else {
			echo '<div class="row justify-content-md-center">
					<img src="assets/img/imagenes/meseros.jpg" class="figure-img img-fluid"  alt="hoverable" >
				</div>'; 
			    
			echo '<div class="row justify-content-md-center">';
			$a = $db->query("SELECT * FROM ticket_temp WHERE mesa = ". $mesa ." and tx = ".$_SESSION["tx"]." and td = ". $_SESSION["td"] ."");
			$productos = $a->num_rows; $a->close();
			
			if($productos == 0){
			echo '<a id="borrar-factura" op="24" mesa="'.$mesa.'" class="btn btn-danger">Eliminar Mesa</a>';
			}
			echo '<a data-toggle="modal" data-target="#NuevoCliente" data-backdrop="false" class="btn btn-indigo">Agregar Cliente</a>';

			echo '<a href="?modal=nombremesa&mesa='.$mesa.'" class="btn btn-cyan">Agregar Nombre</a>';

			if($productos > 0){
			echo '<a href="?modal=modificar&mesa='.$mesa.'&view=1" class="btn btn-brown">Modificar Opciones</a>';

			if ($r = $db->select("clientes", "mesa", "WHERE mesa = ".$mesa." and td = ".$_SESSION["td"]."")) { 
			    if($r["clientes"] > 1) echo '<a href="?modal=dividir&mesa='.$mesa.'" class="btn btn-cyan">Dividir Cuentas</a>';
			    } unset($r);
			}
			
			echo '</div>';
			}

	}


/////////////////////////////////////////////// dividir cuenta
	public function ClientSelect($mesa){
			$db = new dbConn();

		$d = $db->selectGroup("cliente, cancela", "ticket_temp", "where mesa = ". $mesa ." and cancela = cliente and tx = ".$_SESSION["tx"]." and num_fac= 0 GROUP BY cliente");
        while($r = $d->fetch_assoc() ) {
        	if($_SESSION["client-asign"] == $r["cliente"]) $imagen = "cliente_select.png";
        	else $imagen = "cliente.png";

        	    $a = $db->query("SELECT sum(total) FROM ticket_temp WHERE mesa=$mesa and cancela=".$r["cliente"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
    			foreach ($a as $b) { $total=$b["sum(total)"]; } $a->close();

	     	 echo '<a id="select-cliente" op="52" cliente="'.$r["cliente"].'">
	        <figure class="figure">
	        <img src="assets/img/imagenes/'.$imagen.'" class="figure-img img-fluid z-depth-2 rounded-circle"  alt="hoverable" >
	        <figcaption class="figure-caption text-center">Cliente '.$r["cliente"].' <br>'.Helpers::Dinero($total).'</figcaption>
	        </figure>
	        </a>';
	         }
	}


	public function AsignClient($mesa){
			$db = new dbConn();

		if ($r = $db->select("clientes", "mesa", "WHERE mesa = ". $mesa. " and tx = ".$_SESSION["tx"]." and td = " . $_SESSION["td"] . "")) { 
            $clientes = $r["clientes"];
        } unset($r); 

        for ($x = 1; $x <= $clientes; $x++) {
        	$a = $db->query("SELECT sum(total) FROM ticket_temp WHERE mesa=$mesa and cancela=".$x." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]."");
    			foreach ($a as $b) { $total=$b["sum(total)"]; } $a->close();

          echo '<a id="asign-cliente" op="53" mesa="'. $mesa .'" cliente="'.$x.'">
        <figure class="figure">
        <img src="assets/img/imagenes/cliente.png" class="figure-img img-fluid z-depth-2 rounded-circle"  alt="hoverable" >
        <figcaption class="figure-caption text-center">Cliente '.$x.'<br>'.Helpers::Dinero($total).'</figcaption>
        </figure>
        </a>';
         }

	}



	public function DividirCuenta($mesa,$cliente,$cancela){
			$db = new dbConn();

			    $cambio = array();
			    $cambio["cancela"] = $cancela;
			    if ($db->update("ticket_temp", $cambio, "WHERE mesa=$mesa and cliente = $cliente and tx = ".$_SESSION["tx"]." and td=". $_SESSION["td"]."")) {
			       Alerts::Alerta("success","Exito!","Cuenta transferida corectamente!");
			       unset($_SESSION['client-asign']);
			    } else {
			    	Alerts::Alerta("warning","Error!","Ha sucedido un error!");
			    }			
	}




	public function ClienteFactura($mesa){
			$db = new dbConn();

		if ($r = $db->select("clientes", "mesa", "WHERE mesa = ". $mesa. " and tx = ".$_SESSION["tx"]." and td = " . $_SESSION["td"] . "")) { 
            $clientes = $r["clientes"];
        } unset($r); 

        for ($x = 1; $x <= $clientes; $x++) {
        	$a = $db->query("SELECT sum(total) FROM ticket_temp WHERE mesa=$mesa and cancela=".$x." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and num_fac= 0");
    			foreach ($a as $b) { $total=$b["sum(total)"]; } $a->close();
    			if($total > 0){
    				echo '<a id="cliente-facturar" op="55" mesa="'. $mesa.'" cliente="'.$x.'">
		        <figure class="figure">
		        <img src="assets/img/imagenes/cliente.png" class="figure-img img-fluid z-depth-2 rounded-circle"  alt="hoverable" >
		        <figcaption class="figure-caption text-center">Cliente '.$x.'<br>'.Helpers::Dinero($total).'</figcaption>
		        </figure>
		        </a>';

    			}
          
         }

	}



	public function OpcionesActivas($mesa,$identificador,$codigo){
			$db = new dbConn();

		$a = $db->query("SELECT * FROM opciones_ticket WHERE identificador = $identificador and mesa=$mesa and cod = $codigo and td = ".$_SESSION["td"]."");
    		if($a->num_rows){
    			 if ($r = $db->select("producto", "ticket_temp", "WHERE id = $identificador and td = " . $_SESSION["td"] . "")) { 
		        $producto = $r["producto"]; } unset($r);

    			echo '<table class="table table-sm">
					  <thead>
					    <tr>
					      <th colspan="4">'.$producto.'</th>
					    </tr>
					  </thead>
					  <tbody>';
    		foreach ($a as $b) {
		    if ($r = $db->select("nombre, opcion", "opciones_name", "WHERE cod = ". $b["opcion"] ." and td = " . $_SESSION["td"] . "")) { 
		        $nombre = $r["nombre"]; $opcion = $r["opcion"]; } unset($r);
    			echo '<tr>
				      <th scope="row">'. $nombre .'</th>
				      <td>'. $b["cliente"] .'</td>
				      <td>
				      <a id="modificar-opcion" op="57" iden="'. $identificador .'" cod="'. $codigo .'" opcion="'. $opcion .'" activo="'. $b["opcion"] .'" mesa="'. $mesa .'">
				      <span class="badge green"><i class="fa fa-edit" aria-hidden="true"></i> MODIFICAR</span></a>
				      </td>
				      <td>
				      <a id="borrar-opcion" op="58" iden="'. $identificador .'" cod="'. $codigo .'" mesa="'. $mesa .'" activo="'. $b["opcion"] .'">
				      <span class="badge red"><i class="fa fa-remove" aria-hidden="true"></i> ELIMINAR</span></a>
				      </td>
				    </tr>';

    		} // foreach
    		echo '</tbody>
				</table>';
    		} else {
    			echo "Aun no hay opciones agregadas a este producto <br />"; 
    		
    		} $a->close();

    		    if ($r = $db->select("cliente", "ticket_temp", "WHERE id = $identificador and td = ".$_SESSION["td"]."")) { 
			        $cliente = $r["cliente"];
			    } unset($r);  

			echo '<a id="agregar-opcion" op="59" iden="'. $identificador .'" cod="'. $codigo .'" mesa="'. $mesa .'" cliente="'. $cliente .'">
				      <span class="badge blue"><i class="fa fa-plus" aria-hidden="true"> AGREGAR OPCION</i></span>
				      </a>';

	}


	public function OpcionesModificar($mesa,$cod,$identificador,$opcion,$activo){
			$db = new dbConn();

		$a = $db->query("SELECT * FROM opciones_name WHERE opcion = ".$opcion." and td = ".$_SESSION["td"]."");
    		
    		if($a->num_rows){
    			echo '<table class="table table-sm">
					  <thead>
					    <tr>
					      <th>Opci&oacute</th>
					      <th>Acci&oacuten</th>
					    </tr>
					  </thead>
					  <tbody>';
    		foreach ($a as $b) {
    			if($activo == $b["cod"]) { 
    				$accion=1; $color = "red"; $fa="fa-remove"; $act="Eliminar";
    			} else { 
    				$accion=2; $color = "green"; $fa="fa-edit"; $act="Modificar"; 
    			}
    			echo '<tr>
				      <td>'. $b["nombre"] .'</td>
				      <td>
				      <a id="ejecutar-modificar-opcion" op="60" iden="'. $identificador .'" cod="'. $cod .'" opcion="'. $accion .'" mesa="'. $mesa .'" cambio="'. $b["cod"] .'" activo="'. $activo .'">
				      <span class="badge '.$color.'"><i class="fa '.$fa.'" aria-hidden="true">  '.$act.'</i></span></a>
				      </td>
				    </tr>';

    		} // foreach
    		echo '</tbody>
				</table>';
    		} $a->close();
	}



public function ListarOpciones($cod,$identificador,$cliente){
			$db = new dbConn();

		$a = $db->query("SELECT * FROM opciones WHERE td = ".$_SESSION["td"]."");
    		
    		if($a->num_rows){
    			echo '<table class="table table-sm">
					  <thead>
					    <tr>
					      <th>Opci&oacute</th>
					      <th>Ver</th>
					    </tr>
					  </thead>
					  <tbody>';
    		foreach ($a as $b) {
    			echo '<tr>
				      <td>'. $b["nombre"] .'</td>
				      <td>
				      <a id="ver-sub-opcion" op="61" iden="'. $identificador .'" cod="'. $cod .'" opcion="'. $b["cod"] .'" mesa="'. $_SESSION["mesa"] .'" cliente="'. $cliente .'">
				      <span class="badge green"><i class="fa fa-eye" aria-hidden="true"> VER OPCIONES</i></span></a>
				      </td>
				    </tr>';

    		} // foreach
    		echo '</tbody>
				</table>';
    		} $a->close();
	}


	public function VerSubOpciones($mesa,$cod,$identificador,$opcion,$cliente){
			$db = new dbConn();

		$a = $db->query("SELECT * FROM opciones_name WHERE opcion = ".$opcion." and td = ".$_SESSION["td"]."");
    		
    		if($a->num_rows){
    			echo '<table class="table table-sm">
					  <thead>
					    <tr>
					      <th>Opci&oacute</th>
					      <th>Acci&oacuten</th>
					    </tr>
					  </thead>
					  <tbody>';
    		foreach ($a as $b) {
    			echo '<tr>
				      <td>'. $b["nombre"] .'</td>
				      <td>
				      <a id="ejecutar-agregar-opcion" op="62" cod="'. $cod .'" opcion="'. $b["cod"].'" mesa="'. $mesa .'" cliente="'. $cliente .'" iden="'. $identificador .'"  >
				      <span class="badge green"><i class="fa fa-eye" aria-hidden="true"> AGREGAR OPCION</i></span></a>
				      </td>
				    </tr>';

    		} // foreach
    		echo '</tbody>
				</table>';
    		} $a->close();
	}




	public function VerificaOpcionesActivas($mesa,$identificador,$codigo){ // es el que elimina o agrega el 1 o 0 al panel para que se muestre o no opciones
			$db = new dbConn();

		$a = $db->query("SELECT * FROM opciones_ticket WHERE identificador = $identificador and mesa=$mesa and cod = $codigo and td = ".$_SESSION["td"]."");
    		if($a->num_rows == 0){

    			$cambio = array();
				$cambio["opciones"] = 0;
				$db->update("control_cocina", $cambio, "WHERE mesa = '$mesa' and identificador = '$identificador' and cod = '$codigo' and td = ".$_SESSION["td"]."");
    			 
    		} else {

    			$cambio = array();
				$cambio["opciones"] = 1;
				$db->update("control_cocina", $cambio, "WHERE mesa = '$mesa' and identificador = '$identificador' and cod = '$codigo' and td = ".$_SESSION["td"]."");
    		}

	}



} // clase
  		