<?php 
class Inicio{

	public function __construct(){

	}




	public function CreaCodigos($fecha){
		$db = new dbConn();

		echo '<div class="row d-flex justify-content-center text-center text-danger p-4">
			  <div class="col-sm-4 border border-light">
				'.Encrypt::Encrypt(Fechas::Format($fecha),$_SESSION['secret_key']).'
			  </div>
			</div>';
	}


	public function RegisterInOut($edo){
		$db = new dbConn();
		    $datos = array();
		    $datos["user"] = $_SESSION['user'];
		    $datos["nombre"] = $_SESSION['nombre'];
		    $datos["accion"] = $edo;
		    $datos["ip"] = Helpers::GetIp();
		    $datos["navegador"] = $_SERVER["HTTP_USER_AGENT"];
		    $datos["fecha"] = date("d-m-Y");
		    $datos["fechaF"] = Fechas::Format(date("d-m-Y"));
		    $datos["hora"] = date("H:i:s");
		    $datos["td"] = $_SESSION["td"];
		    $db->insert("login_inout", $datos); 		
	}


	public function Validar($fecha,$codigo){
		$db = new dbConn();

		$codigo = str_replace(' ', '', $codigo); // elimina espacios

		if(Fechas::Format($fecha) == Encrypt::Decrypt($codigo,$_SESSION['secret_key'])){
			
			    $cambio = array();
			    $cambio["expira"] = Encrypt::Encrypt($fecha,$_SESSION['secret_key']);
			    $cambio["expiracion"] = $codigo;
			    if ($db->update("config_root", $cambio, "WHERE td = ".$_SESSION["td"]."")) {
			        
			        Alerts::Alerta("success","Cambios realizados","Ha introducido su codigo correctamente");
			    } else {
			    	Alerts::Alerta("warning","Ocurrio algo","Ha ocurrido un inconveniente, introduzca su codigo nuevamente");
			    }

			
		} else {
			Alerts::Alerta("danger","Error","Los codigos introducidos no son correctos, asegurese de tener codigos validos");
		}
		
		$this->Caduca();
		$this->NoAcceso();
		$this->Formulario();
	}



	public function Caduca(){ // ver si esta caducado el sistema
        $db = new dbConn();
        $r = $db->select("*", "config_root", "where td = ".$_SESSION['td']."");
        $encrypt = new Encrypt;
        $fechas = new Fechas;


            if($_SESSION['tipo_cuenta'] != 1){

                $key1 = $encrypt->Decrypt($r["expira"],$_SESSION['secret_key']);
                $key2 = $encrypt->Decrypt($r["expiracion"],$_SESSION['secret_key']);
                $key1 = $fechas->Format($key1);


                    if($key1 == $key2){ // si son iguales verifico que no esten vencidas
                            $ahora = $fechas->Format(date("d-m-Y"));

                            if($ahora < $key1){ // esta bien // CADUCA 0 = bien, 1 = 5 dias, 2 = paso
                                $_SESSION["caduca"] = 0;
                            } if($ahora > $key1 - 432000 and $ahora <= $key1){ // entre los 5
                                $_SESSION["caduca"] = 1;
                            } if($ahora > $key1 and $ahora <= $key1 + 432000){ // 
                                $_SESSION["caduca"] = 2;
                            }if($ahora > $key1 + 432000){ // se paso
                                $_SESSION["caduca"] = 3;
                            } 

                        } else { // de una vez las declaro invalidas
                            $_SESSION["caduca"] = 3;
                        }
            
            } else {
                $_SESSION["caduca"] = 0;
            }  

            unset($r);  
       }






	public function Formulario(){
		echo '<div class="row d-flex justify-content-center text-center">
				  <div class="col-sm-4">
				<h3>C&oacutedigo de validaci&oacuten</h3>	

				<form class="text-center border border-light p-2" method="post" id="form-validar" name="form-validar">
				    <input placeholder="Seleccione una fecha" type="text" id="fecha" name="fecha" class="form-control datepicker my-2">
				    <label for="fecha">Fecha a buscar</label>
				    <input type="text" id="codigo" name="codigo" class="form-control mb-1" placeholder="Codigo">
				    <button class="btn btn-success" type="submit" id="btn-validar" name="btn-validar">Validar</button>
				</form>

				  </div>
				</div>';
	}


	public function FormularioCodigos(){
		echo '<div class="row d-flex justify-content-center text-center">
				  <div class="col-sm-4">
				<h3>Crear C&oacutedigos</h3>	

				<form class="text-center border border-light p-2" method="post" id="form-codigo" name="form-codigo">
				    <input placeholder="Seleccione una fecha" type="text" id="fecha" name="fecha" class="form-control datepicker my-2">
				    <label for="fecha">Fecha a buscar</label>
				    <br>
				    <button class="btn btn-success" type="submit" id="btn-codigo" name="btn-codigo">Crear Codigo</button>
				</form>

				  </div>
				</div>';
	}


	public function NoAcceso(){
		$db = new dbConn();

		$r = $db->select("*", "config_root", "where td = ".$_SESSION['td']."");

if($_SESSION["caduca"] == 0){
	echo Alerts::Mensaje("Su cuenta esta desbloqueada y activa hasta el " . Encrypt::Decrypt($r["expira"],$_SESSION['secret_key']),"success",'<a href="?" class="btn btn-info waves-effect waves-light">Continuar...</a>',NUll);
}
if($_SESSION["caduca"] == 1){
	echo Alerts::Mensaje("Su cuenta esta a punto de expirar, caduca el " . Encrypt::Decrypt($r["expira"],$_SESSION['secret_key']),"danger",'<a id="habilitar" op="126" class="btn btn-info waves-effect waves-light">Continuar Usandolo</a>','<a href="application/includes/logout.php" class="btn btn-danger waves-effect waves-light">Salir del Sistema</a>');
}
if($_SESSION["caduca"] == 2){
	echo Alerts::Mensaje("Su cuenta ha expirado desde " . Encrypt::Decrypt($r["expira"],$_SESSION['secret_key']) . " Es Necesario que ingrese un codigo de activacion v&aacutelido para poder siguir usando el sistema o &eacuteste ser&aacute bloqueado. Ultima fecha para ingresar un c&oacutedigo es: ". Fechas::DiaSuma(Encrypt::Decrypt($r["expira"],$_SESSION['secret_key']), 5).". Cualquier duda contacte al administrador.","danger",'<a id="habilitar" op="126" class="btn btn-info waves-effect waves-light">Continuar Usandolo</a>','<a href="application/includes/logout.php" class="btn btn-danger waves-effect waves-light">Salir del Sistema</a>');
}
if($_SESSION["caduca"] == 3){
	echo Alerts::Mensaje("Su cuenta ha sido Bloqueada desde " . Encrypt::Decrypt($r["expira"],$_SESSION['secret_key']) . ". Para poder seguir usando el sistema debe ingresar un nuevo c&oacutedigo de activaci&oacuten v&aacutelido.","danger",'<a href="application/includes/logout.php" class="btn btn-danger waves-effect waves-light">Salir del Sistema</a>',NUll);
}

 unset($r); 

	}












////////////

	public function Ventas(){
		$db = new dbConn();

		$mes=date("m");
		@$ano=date("Y");
		$fecha="-$mes-$ano";

		$ap = $db->query("SELECT sum(total) FROM ticket_propina where fecha like '%$fecha' and td = ".$_SESSION['td']."");
		    foreach ($ap as $bp) { 
		    	$prop = $bp["sum(total)"];

		    } $ap->close();


	    $a = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$_SESSION["td"]." and fecha like '%$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(total)"];
		    } $a->close();
		    return $total + $prop;
	}

	public function Gastos(){
		$db = new dbConn();

		$mes=date("m");
		@$ano=date("Y");
		$fecha="-$mes-$ano";

	    $a = $db->query("SELECT sum(cantidad) FROM gastos WHERE edo = 1 and tipo !=5 and td = ".$_SESSION["td"]." and fecha like '%$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(cantidad)"];
		    } $a->close();
		    return $total;
	}

	public function Efectivo(){
		$db = new dbConn();

    if ($r = $db->select("efectivo,fecha", "corte_diario", "WHERE td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { 
        $efectivo = $r["efectivo"];
        $fecha = $r["fecha"];
    } unset($r);  

    	if($fecha == date("d-m-Y")){
    		$total = $efectivo;
		    return $total;	
		} else {
			$total = $efectivo + Corte::VentaHoy(date("d-m-Y")) - Corte::GastoHoy(date("d-m-Y")) + Corte::PropinaHoy(date("d-m-Y"));
		    return $total;
		}

	   		
	}


	public function Remesas(){
		$db = new dbConn();

		$mes=date("m");
		@$ano=date("Y");
		$fecha="-$mes-$ano";

	    $a = $db->query("SELECT sum(cantidad) FROM gastos WHERE edo = 1 and tipo = 3 and td = ".$_SESSION["td"]." and fecha like '%$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(cantidad)"];
		    } $a->close();
		    return $total;
	}


	public function Cheques(){
		$db = new dbConn();

		$mes=date("m");
		@$ano=date("Y");
		$fecha="-$mes-$ano";

	    $a = $db->query("SELECT sum(cantidad) FROM gastos WHERE tipo = 5 and td = ".$_SESSION["td"]." and fecha like '%$fecha'");
		    foreach ($a as $b) {
		     $total=$b["sum(cantidad)"];
		    } $a->close();
		    return $total;
	}



	public function LastUpdate(){
		$db = new dbConn();

		    if ($r = $db->select("*", "login_sync", "WHERE td = ".$_SESSION["td"]." and edo = 1 order by id desc")) {
		    	if($r["fecha"] !=NULL){
		    		return $r["fecha"] . " | " . $r["hora"];
		    	} else {
		    		return "Corte";
		    	}
		        
		    } unset($r);  

	}


	public function Diferencia(){

	   		$total = Inicio::Remesas() - Inicio::Cheques();
		    return $total;
	}


	public function Clave(){
			$numero = sha1(Fechas::Format(date("d-m-Y")));
			$num = substr("$numero", 0, 6);
			 return $num;
	}


		public function SiCorte(){
			if(Corte::UltimaFecha() == date("d-m-Y")){
				return 'Diferencia corte:<h1>' . Helpers::Dinero(Corte::GetDiferencia(date("d-m-Y"))) . '</h1>';
			} else {
				return '<p class="black-text display-4">Sin Corte</p>';
			}
	}


	public function Root(){

		echo '<div class="card-deck">
			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Clave: '.$_SESSION['config_cliente'].'</h4>
			            <p class="black-text display-3">'.Inicio::Clave().'</p>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title red-text">'.Inicio::LastUpdate().'</h4>
			            '.Inicio::SiCorte().'
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Datos Hoy</h4>
			            <h2 class="black-text">Venta: '. Helpers::Dinero(Corte::VentaHoy(date("d-m-Y"))) .'<br>Gastos: '. Helpers::Dinero(Corte::GastoHoy(date("d-m-Y"))) .'</h2>
			        </div>
			    </div>
			    <!--/.Panel-->

			</div>';

			echo '<hr>';

		 echo '<div class="card-deck">
			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Total de venta</h4>
			            <h1 class="black-text">'. Helpers::Dinero(Inicio::Ventas()) .'</h1>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Gastos</h4>
			            <h1 class="black-text">'. Helpers::Dinero(Inicio::Gastos()) .'</h1>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Efectivo</h4>
			            <h1 class="black-text">'. Helpers::Dinero(Inicio::Efectivo()) .'</h1>
			        </div>
			    </div>
			    <!--/.Panel-->

			</div>';


			echo '<hr>';
			// para la segunda parte
				 echo '<div class="card-deck">
			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Remesas</h4>
			            <h1 class="black-text">'. Helpers::Dinero(Inicio::Remesas()) .'</h1>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Cheques</h4>
			            <h1 class="black-text">'. Helpers::Dinero(Inicio::Cheques()) .'</h1>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Diferencia</h4>
			            <h1 class="black-text">'. Helpers::Dinero(Inicio::Diferencia()) .'</h1>
			        </div>
			    </div>
			    <!--/.Panel-->

			</div>';

			echo '<hr>';
		
	}











		public function Admin(){
		 echo '<div class="card-deck">
			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Total Tx</h4>
			            <h1 class="black-text">'. Helpers::Dinero(Corte::TotalTx(date("d-m-Y"))) .'</h1>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			            <h4 class="card-title">Total no Tx</h4>
			            <h1 class="black-text">'. Helpers::Dinero(Corte::TotalNoTx(date("d-m-Y"))) .'</h1>
			        </div>
			    </div>
			    <!--/.Panel-->

			    <!--Panel-->
			    <div class="card">
			        <div class="card-body">
			        	<h4 class="card-title">Clientes</h4>
			            <h1 class="black-text">'.Helpers::Entero(Corte::ClientesHoy(date("d-m-Y"))).'</h1>
			        </div>
			    </div>
			    <!--/.Panel-->

			</div>';

		}











} // clase