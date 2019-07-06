<?php 
class Corte{

	public function __construct() { 
     } 


	public function EjecutarCorte($efectivo,$fecha){
		$db = new dbConn();

	if($this->UltimaFecha() == date("d-m-Y")){
		Alerts::Alerta("error","Error!","Ya existe un corte el dia de hoy");
	} else {
	// busco caja chica del ultimo corte
	// 
		if ($r = $db->select("efectivo", "corte_diario", "where edo = 1 and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { 
	        $caja_chica=$r["efectivo"];
	    } unset($r);

 		// eliminar el los datos de ticket_temp
		   	    $db->query("TRUNCATE ticket_temp");
		   	    $this->EliminarMesasActivas($fecha);
		   	    
    	// inserto los datos del corte de ahora
    		$datos = array();
		    $datos["fecha"] = $fecha;
		    $datos["fecha_format"] = Fechas::Format($fecha);
		    $datos["hora"] = date("H:i:s");
		    $datos["mesas"] = $this->MesasHoy($fecha);
		    $datos["clientes"] = $this->ClientesHoy($fecha);
		    $datos["efectivo"] = $efectivo;
		    $datos["propina"] = $this->PropinaHoy($fecha);
		    $datos["tx"] = $this->TotalTx($fecha);
		    $datos["no_tx"] = $this->TotalNoTx($fecha);
		    $datos["total"] = $this->VentaHoy($fecha);
		    $datos["gastos"] = $this->GastoHoy($fecha);
		    $datos["diferencia"] = $this->DiferenciaDinero($caja_chica, $efectivo, $fecha);
		    $datos["user"] = $_SESSION["user"];
		    $datos["edo"] = 1;
		    $datos["td"] = $_SESSION["td"];

		   if($db->insert("corte_diario", $datos)){
		   //	Alerts::Alerta("success","Exito!","Se ha ejecutado el corte correctamente!");
		   	$this->CalcularGastoProductos($fecha);

		   	  	if(Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0){
			   		echo '<script>
						window.location.href="?modal=respaldar"
					</script>';
			   	}
		   	
		   }

		  
		}// de la comprobacion de fechas
	}



	public function BuscaCorte($fecha){
		$db = new dbConn();
	    	$a = $db->query("SELECT * FROM corte_diario WHERE fecha = '$fecha' and edo = 1 and td = ".$_SESSION["td"]."");
			return $a->num_rows;
			$a->close();
	}



	public function UltimaFecha(){
		$db = new dbConn();
	    if ($r = $db->select("fecha", "corte_diario", "where edo = 1 and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { 
	        $fechaultima=$r["fecha"];
	    } 
	    unset($r); 
		return $fechaultima;
	}

	public function GetEfectivo($fecha){ //para reporte nada mas
		$db = new dbConn();
	    if ($r = $db->select("efectivo", "corte_diario", "where fecha = '$fecha' and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { 
	        $efectivo=$r["efectivo"];
	    } 
	    unset($r); 
		return $efectivo;
	}

	public function GetDiferencia($fecha){ //para reporte nada mas
		$db = new dbConn();
	    if ($r = $db->select("diferencia", "corte_diario", "where fecha = '$fecha' and td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { 
	        $diferencia=$r["diferencia"];
	    } 
	    unset($r); 
		return $diferencia;
	}
////////////////////////////

	public function MesasHoy($fecha){
		$db = new dbConn();
	    	$a = $db->query("SELECT * FROM mesa WHERE td = ".$_SESSION["td"]." and fecha = '$fecha'"); $total = $a->num_rows; $a->close();
		return $total;
	}


//////////// 

	public function MesasAbiertas($fecha){
		$db = new dbConn();
	    	$abi = $db->query("SELECT * FROM mesa WHERE estado = 1 and td = ".$_SESSION["td"]." and fecha = '$fecha'"); 
	    	$total = $abi->num_rows; $abi->close();
		
		if($total > 0){
			Alerts::Mensaje("Aun hay mesas sin cancelar, estas pueden afectar el total. No olvide cancelarlas. Si continua con el corte todos los datos de las mesas creadas y no canceladas se eliminaran","danger",NULL,NULL);
		}
	}

	public function EliminarMesasActivas($fecha){
		$db = new dbConn();
	    	    
	    	    $db->delete("mesa", "WHERE estado = 1 and fecha = '$fecha' and td = " . $_SESSION["td"]);

		}
//////////


	public function ClientesHoy($fecha){
		$db = new dbConn();
	        $a = $db->query("SELECT sum(clientes) FROM mesa WHERE td = ".$_SESSION["td"]." and fecha = '$fecha'");
		    foreach ($a as $b) {
		        $clientes=$b["sum(clientes)"];
		    } $a->close();
		    return  $clientes;

	}


	public function VentaHoy($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$_SESSION["td"]." and fecha = '$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total;
	}


	public function PropinaHoy($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket_propina WHERE td = ".$_SESSION["td"]." and fecha = '$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total;
	}


	public function TotalTx($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$_SESSION["td"]." and fecha = '$fecha' and tx = 1");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total;
	}

	public function TotalNoTx($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$_SESSION["td"]." and fecha = '$fecha' and tx = 0");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total;
	}


public function Porcentaje(){
	$db = new dbConn();

	$cant_g = Corte::TotalTx(date("d-m-Y"));
	$cant_e = Corte::TotalNoTx(date("d-m-Y"));

	$topor=$cant_g+$cant_e;
	$por1=$cant_g*100;
	@$por1=$por1/$topor;

	$por2=$cant_e*100;
	@$por2=$por2/$topor;
	$por1=number_format($por1,0,'.','.');
	$por2=number_format($por2,0,'.','.');

	return "$por1/$por2";

}


	public function GastoHoy($fecha){
		$db = new dbConn();
	    $a = $db->query("SELECT sum(cantidad) FROM gastos WHERE edo = 1 and tipo != 5 and td = ".$_SESSION["td"]." and fecha = '$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(cantidad)"];
		    } $a->close();
		    return $total;
	}



	public function DiferenciaDinero($caja_chica, $efectivo, $fecha){
		/// conversiones para el dinero
				$total_cc = $this->VentaHoy($fecha)+$caja_chica+$this->PropinaHoy($fecha); //total ventas  mas caja chica de ayer
				$total_debido = $total_cc-$this->GastoHoy($fecha); //dinero que deberia haber ()
				$diferencia = $efectivo - $total_debido;
				return $diferencia;
	}



public function CancelarCorte($ramdom,$fecha){

	$numero = sha1(Fechas::Format(date("d-m-Y")));
	$num = substr("$numero", 0, 6);

		if($ramdom == $num){

			$db = new dbConn();

				$cambio = array();
			    $cambio["edo"] = "2";
			    if ($db->update("corte_diario", $cambio, "WHERE fecha_format=" . Fechas::Format($fecha))) {
			    	// borra el sincronizado si existe
			    	    $as = $db->query("SELECT * FROM sync_status WHERE tipo = 1 and fecha = '$fecha' and ejecutado = 0 and td = ".$_SESSION["td"]."");
						    foreach ($as as $bs) {

							        $sync = $bs["hash"];
							    	$fichero = "../../sync/" . $sync . ".sql";

									if (file_exists($fichero)){ 
											$db->delete("sync_status", "WHERE hash= '$sync' and td =".$_SESSION["td"]."");
											@unlink($fichero);
									}

						    } $as->close();

			    	$db->delete("sync_status", "WHERE tipo = 1 and fechaF =" . Fechas::Format($fecha));
			    	////////////// lo del sync
			        $this->RevertirCalcularGastoProductos($fecha);
					Alerts::Alerta("success","Exito!","Corte Anulado Correctamente");
			    } else {
			Alerts::Alerta("error","Error!","Codigo Invalido!!");
			}
		}

	}







////////////////////////////////// contenido //////////////////////////
	public function Contenido($fecha){
		if(Corte::UltimaFecha() == $fecha){
				$this->Content($fecha);
			} else {
				$this->Form();
			}
	}
	




	public function Content($fecha){
		$sync = new Sync;

		echo '<div id="respaldo">';
		$sync->RespaldoStatus($fecha);	
		echo '</div>';	

		 echo '<div class="card-deck">
			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Efectivo</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($this->GetEfectivo($fecha)) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Total de venta</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($this->VentaHoy($fecha)) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Diferencia</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($this->GetDiferencia($fecha)) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Gastos</h4>
			            <p class="black-text display-4">' . Helpers::Dinero($this->GastoHoy($fecha)) . '</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			</div>

			<button type="button" class="btn btn-danger" data-toggle="modal" data-target="#modalConfirmDelete">Eliminar Corte</button>';
		
	}

	public function Form(){
	echo '<p>Aun no se ha realizado el corte de este dia. <br />Ingrese la cantidad de su efectivo para poder continuar
		</p>
		<br />
		<form id="form-corte" name="form-corte">
		 
		 <div class="form-group row justify-content-center align-items-center">
		  <div class="col-xs-2">
		    <label for="ex1">Efectivo</label>
		    <input name="efectivo" type="number" id="efectivo" size="8" maxlength="8" class="form-control" placeholder="0.00" step="any" required autofocus />
		  </div>
		</div>
		<input type="image" src="assets/img/imagenes/print.png"  id="btn-corte" name="btn-corte" >
		</form>';
				
	}

///////////////////////////////////////// descuentos 

	public function CalcularGastoProductos($fecha){
		$db = new dbConn();
		// paso 1 recorro todos los productos vendidos ahora
		$a = $db->query("SELECT cod, cant FROM ticket WHERE fecha = '$fecha' and edo=1 and td = ".$_SESSION["td"]."");
	    foreach ($a as $b) {
	    	//  paso 2corroborar las guarniciones que lleva cada uno
	    	$ax = $db->query("SELECT dependiente FROM pro_asignado WHERE cod = ".$b["cod"]." and td = ".$_SESSION["td"]."");
	   		 foreach ($ax as $bx) {
	   		 		//  paso 3 ver cantidad de guarnicion
	   		 	if ($r = $db->select("cantidad, producto", "pro_dependiente", "WHERE iden = ".$bx["dependiente"]." and td = ".$_SESSION["td"]."")) { 
	   		 		// paso 4 // actualizar el registro
	   		 			 
	   		 			if ($x = $db->select("cantidad", "pro_bruto", "WHERE iden=".$r["producto"]." and td = ".$_SESSION["td"]."")) { 
	   		 			 	// resto la cantidad encontrada menos la cantidad ocupada
        				$cantidadx=$b["cant"] * $r["cantidad"]; 
	   		 			
		   		 		$cambio = array();
					    $cambio["cantidad"] = $x["cantidad"] - $cantidadx;
					    $db->update("pro_bruto", $cambio, "WHERE iden=".$r["producto"]." and td = ".$_SESSION["td"]."");
					    }
        				unset($x); 
					    // Termina paso 4
    			} unset($r); // termina paso 3
	    	} $ax->close(); // termina paso 2
	    	// /// /// /// //
	    } $a->close(); // termina paso 1
// agregar a registro que se calculo
    	$datos = array();
	    $datos["fecha"] = date("d-m-Y");
	    $datos["hora"] = date("H:i:s");
	    $datos["td"] = $_SESSION["td"];
	    $db->insert("pro_registro_up", $datos); 
	}




	public function RevertirCalcularGastoProductos($fecha){
		$db = new dbConn();
		// paso 1 recorro todos los productos vendidos ahora
		$a = $db->query("SELECT cod, cant FROM ticket WHERE fecha = '$fecha'  and edo=1 and td = ".$_SESSION["td"]."");
	    foreach ($a as $b) {
	    	//  paso 2corroborar las guarniciones que lleva cada uno
	    	$ax = $db->query("SELECT dependiente FROM pro_asignado WHERE cod = ".$b["cod"]." and td = ".$_SESSION["td"]."");
	   		 foreach ($ax as $bx) {
	   		 		//  paso 3 ver cantidad de guarnicion
	   		 	if ($r = $db->select("cantidad, producto", "pro_dependiente", "WHERE iden = ".$bx["dependiente"]." and td = ".$_SESSION["td"]."")) { 
	   		 		// paso 4 // actualizar el registro
	   		 			 if ($x = $db->select("cantidad", "pro_bruto", "WHERE iden =".$r["producto"]." and td = ".$_SESSION["td"]."")) { 
	   		 			 	// resto la cantidad encontrada menos la cantidad ocupada
        				$cantidadx=$b["cant"] * $r["cantidad"]; 
	   		 			
		   		 		$cambio = array();
					    $cambio["cantidad"] = $x["cantidad"] + $cantidadx;
					    $db->update("pro_bruto", $cambio, "WHERE iden=".$r["producto"]." and td = ".$_SESSION["td"]."");
					    }
        				unset($x); 
	   		 		// Termina paso 4
    			} unset($r); // termina paso 3
	    	} $ax->close(); // termina paso 2
	    	// /// /// /// //
	    } $a->close(); // termina paso 1
// Elimino el registro de que se hizo la reversion
	$db->delete("pro_registro_up", "WHERE fecha = '$fecha' and td = ".$_SESSION["td"]."");
	}





} // fin de la clase

 ?>