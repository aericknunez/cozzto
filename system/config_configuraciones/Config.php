<?php 
class Config{

	public function __construct() { 
     } 


	public function Configuraciones($sistema,$cliente,$slogan,$propietario,$telefono,$direccion,$email,$pais,$giro,$nit,$imp,$propina,$nombre_impuesto,$nombre_documento,$moneda,$moneda_simbolo,$tipo_inicio,$skin,$inicio_tx,$otras_ventas,$venta_especial,$imprimir_antes,$cambio_tx){
		$db = new dbConn();

		$cambio = array();
	    $cambio["sistema"] = $sistema;
	    $cambio["cliente"] = $cliente;
	    $cambio["slogan"] = $slogan;
	    $cambio["propietario"] = $propietario;
	    $cambio["telefono"] = $telefono;
	    $cambio["direccion"] = $direccion;
	    $cambio["email"] = $email;
	    $cambio["pais"] = $pais;
	    $cambio["giro"] = $giro;
	    $cambio["nit"] = $nit;
	    $cambio["imp"] = $imp;
	    $cambio["propina"] = $propina;
	    $cambio["nombre_impuesto"] = $nombre_impuesto;
	    $cambio["nombre_documento"] = $nombre_documento;
	    $cambio["moneda"] = $moneda;
	    $cambio["moneda_simbolo"] = $moneda_simbolo;
	    $cambio["tipo_inicio"] = $tipo_inicio;
	    $cambio["skin"] = $skin;
	    $cambio["inicio_tx"] = $inicio_tx;
	    $cambio["otras_ventas"] = $otras_ventas;
	    $cambio["venta_especial"] = $venta_especial;
	    $cambio["imprimir_antes"] = $imprimir_antes;
	    $cambio["cambio_tx"] = $cambio_tx;
	    if ($db->update("config_master", $cambio, "WHERE td = ".$_SESSION["td"]."")) {
	    	$this->CrearVariables();
	        Alerts::Alerta("success","Echo!","Registros actualizados correctamente");
	    } else {
	       Alerts::Alerta("error","Error!","Ocurrio un error desconocido!");   
	    }

	
	}



	public function Root($expira,$expiracion,$pantallas,$ftp_servidor,$ftp_path,$ftp_ruta,$ftp_user,$ftp_password,$tipo_sistema,$plataforma){
		$db = new dbConn();

		$cambio = array();
	    $cambio["expira"] = $expira;
	    $cambio["expiracion"] = $expiracion;
	    $cambio["pantallas"] = $pantallas;
	    $cambio["ftp_servidor"] = $ftp_servidor;
	    $cambio["ftp_path"] = $ftp_path;
	    $cambio["ftp_ruta"] = $ftp_ruta;
	    $cambio["ftp_user"] = $ftp_user;
	    $cambio["ftp_password"] = $ftp_password;
	    $cambio["tipo_sistema"] = $tipo_sistema;
	    $cambio["plataforma"] = $plataforma;
	    if ($db->update("config_root", $cambio, "WHERE td = ".$_SESSION["td"]."")) {
	    	$this->CrearVariables();
	        Alerts::Alerta("success","Echo!","Registros actualizados correctamente");
	    } else {
	       Alerts::Alerta("error","Error!","Ocurrio un error desconocido!");   
	    }

	
	}
	


	public function CrearIconos($url, $msj){
		$db = new dbConn();
//ESTE ARCHIVO CREA ICONOS CADA VES QUE ES NECESARIO AL INICIO DE SESION
// CONSULTA TODOS LOS ICONOS Y LOS GUARDA EN UN ARCHIVO LLAMADO iconos.php 
$countico = $db->query("SELECT * FROM images WHERE td = ".$_SESSION["td"]."");
if($countico->num_rows > 0){ // si hay iconos prosigo. sino voy hasta el final



$return.= "<div class=\"row text-center portfolio\"> 
   <ul class=\"gallery\"> \n\n";

 $a = $db->query("Select * from images where popup='0' and td = ".$_SESSION["td"]." order by img_order asc");
    foreach ($a as $b) {
    	$img=$b['img_name'];
		  $cod=$b["cod"];

// antes que todo verifico si tiene panel o pantalla activado el producto
if ($r = $db->select("panel", "control_panel_mostrar", "WHERE producto = '$cod' and td = ".$_SESSION["td"]."")) { $panel = $r["panel"]; } unset($r); 
//
       if($cod <= 9900){

 $x = $db->select("nombre, cat", "precios", "WHERE cod='$cod' and td = ".$_SESSION["td"].""); 
        
////////////// aqui compruebo si tiene una opcion activada
$d = $db->selectGroup("*", "opciones_asig", "where producto='$cod' and td = ".$_SESSION["td"]."");
    if ($d->num_rows > 0) {
        while($r = $d->fetch_assoc() ) { // aqui van los que tienen opcion activada

$return.= '<li><a href="';
$return.= '?modal=opciones';
$return.= '&op='.$r["opcion"].'&cod=';
$return.= $cod;

$return.= '&mesa='; 
$return.= '<? '; 
$return.= 'echo ';
$return.= '$_SESSION["mesa"]'; 
$return.= ' ?>'; 

$return.= '&cliente=';
$return.= '<? '; 
$return.= 'echo ';
$return.= '$_SESSION["clientselect"]'; 
$return.= ' ?>'; 

$return.= '&panel=';
$return.= $panel; 

$return.= '&view=';  
$return.= '<? '; 
$return.= 'echo ';
$return.= '$_SESSION["view"]'; 
$return.= ' ?>'; 

$return.= '"><em>';
$return.= $x['nombre'];
$return.= '</em><img src="';
$return.= $b['img_name'];
$return.= '" alt="image" class="img-fluid img-responsive wow fadeIn" /></a></li>';
$return.= "\n";

        }
    } else { // aqui van los que no tienenopcion activada
        
$return.= '<li><em>'; $return.= $x['nombre']; $return.= '</em>';
$return.= '<input type='; $return.= '"'; $return.= 'image'; $return.= '" ';
$return.= 'id='; $return.= '"'; $return.= 'venta'; $return.= '" ';
$return.= 'op='; $return.= '"'; $return.= '20'; $return.= '" ';
$return.= 'cod='; $return.= '"'; $return.= $b["cod"]; $return.= '" ';

$return.= 'mesa='; $return.= '"'; 
$return.= '<? '; 
$return.= 'echo ';
$return.= '$_SESSION["mesa"]'; 
$return.= ' ?>'; 
$return.= '" ';

$return.= 'cliente='; $return.= '"'; 
$return.= '<? '; 
$return.= 'echo ';
$return.= '$_SESSION["clientselect"]'; 
$return.= ' ?>'; 
$return.= '" ';

$return.= 'panel='; $return.= '"'; 
$return.= $panel; 
$return.= '" ';

$return.= 'view='; $return.= '"'; 
$return.= '<? '; 
$return.= 'echo ';
$return.= '$_SESSION["view"]'; 
$return.= ' ?>'; 
$return.= '" ';

$return.= 'src='; $return.= '"'; $return.= $b['img_name']; $return.= '" ';
$return.= 'alt='; $return.= '"'; $return.= 'image'; $return.= '"';
$return.= ' class='; $return.= '"'; $return.= 'img-fluid img-responsive wow fadeIn';
$return.= '" />';
$return.= '</li>'; $return.= "\n";

   } 

    $d->close(); //termina opcion activada



 
}
else{
$x = $db->select("categoria", "categorias", "WHERE cod='$cod' and td = ".$_SESSION["td"]."");

 
$return.= '<li><a data-target='; $return.= '"'; 
$return.= '#a'; $return.= $b["cod"]; 
$return.= '"';
$return.= ' data-toggle='; $return.= '"'; $return.= 'modal'; 
$return.= '"';
$return.= '><em>'; $return.= $x['categoria']; $return.= '</em>';
$return.= '<img src='; $return.= '"'; $return.= $b['img_name']; $return.= '" ';
$return.= 'alt='; $return.= '"'; $return.= 'image'; $return.= '"';
$return.= ' class='; $return.= '"'; $return.= 'img-fluid img-responsive wow fadeIn'; $return.= '" />'; 
$return.= '</a></li>';
$return.= "\n";
 
}
unset($x);
unset($panel);

    } // aqui termina el as del inicio ///////////////////
    $a->close();

$return.= " \n \n";


if($_SESSION['config_otras_ventas'] == 1){
$return.= '<li><a href="?modal=otras_ventas&mesa=<? echo $_SESSION["mesa"]; ?>&cliente=<? echo $_SESSION["clientselect"] ?>&view=<? echo $_SESSION["view"]; ?>"><em>Otras Ventas</em><img src="assets/img/ico/dfs.png" alt="image" class="img-fluid img-responsive wow fadeIn" /></a></li>';
$return.= " \n \n";	
}

if($_SESSION['config_venta_especial'] == 1){
$return.= '<li><a href="?modal=venta_especial&mesa=<? echo $_SESSION["mesa"]; ?>&cliente=<? echo $_SESSION["clientselect"] ?>&view=<? echo $_SESSION["view"]; ?>"><em>Venta Especial</em><img src="assets/img/ico/as.png" alt="image" class="img-fluid img-responsive wow fadeIn" /></a></li>';	
}


$return.= " </ul> \n </div> \n \n";





////////////////////// para los popup  ///////////////////////////////

		
/////////////////  
$a = $db->query("Select * from categorias WHERE td = ".$_SESSION["td"]." order by id asc");
    foreach ($a as $b) {
    	$name=$b['categoria'];
		  $cod=$b["cod"];


$ar = $db->query("SELECT * FROM producto WHERE categoria = '".$b["cod"]."' and td = ".$_SESSION["td"]."");
$numerom=$ar->num_rows;
$ar->close();

if($numerom > 24) $large="modal-fluid";
if($numerom < 25 and $numerom > 12) $large="modal-lg";
if($numerom < 13 and $numerom > 6) $large="modal-md";
if($numerom < 7 and $numerom > 0) $large="modal-sm";

$return.= '<!-- POPUP CON EL CODIGO '; $return.= $b["cod"]; $return.= ' ';  $return.= $b["categoria"]; $return.= " --> \n \n \n";

$return.= '<div class="modal" id="a';
$return.= $b["cod"];
$return.= '" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
  <div class="modal-dialog '; $return.= $large; $return.='" role="document">
    <div class="modal-content">
      <div class="modal-header">
        <h5 class="modal-title" id="exampleModalLabel">'; $return.= $b["categoria"]; $return.= '</h5>
        <button type="button" class="close" data-dismiss="modal" aria-label="Cerrar">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <div class="modal-body">';

$return.= "\n <div class=\"row text-center portfolio\"> 
   <ul class=\"gallery\"> \n\n";
   
////////////////////////////////
 $a = $db->query("Select * from images where popup='$cod' and td = ".$_SESSION["td"]." order by img_order asc");
    foreach ($a as $b) {
    	$img=$b['img_name'];
		  $cod=$b["cod"];
      // antes que todo verifico si tiene panel o pantalla activado el producto
      if ($r = $db->select("panel", "control_panel_mostrar", "WHERE producto = '$cod' and td = ".$_SESSION["td"]."")) { $panel = $r["panel"]; } unset($r); 
      //

       if($cod <= 9900){

      $x = $db->select("nombre, cat", "precios", "WHERE cod='$cod' and td = ".$_SESSION["td"].""); 


////////////// aqui compruebo si tiene una opcion activada
$d = $db->selectGroup("*", "opciones_asig", "where producto='$cod' and td = ".$_SESSION["td"]."");
    if ($d->num_rows > 0) {
        while($r = $d->fetch_assoc() ) { // aqui van los que tienen opcion activada
$return.= '<li><a href="';
$return.= '?modal=opciones';
$return.= '&op='.$r["opcion"].'&cod=';
$return.= $cod;

$return.= '&mesa='; 
$return.= '<? '; 
$return.= 'echo ';
$return.= '$_SESSION["mesa"]'; 
$return.= ' ?>'; 

$return.= '&cliente=';
$return.= '<? '; 
$return.= 'echo ';
$return.= '$_SESSION["clientselect"]'; 
$return.= ' ?>'; 

$return.= '&panel=';
$return.= $panel; 

$return.= '&view=';  
$return.= '<? '; 
$return.= 'echo ';
$return.= '$_SESSION["view"]'; 
$return.= ' ?>'; 


$return.= '"><em>';
$return.= $x['nombre'];
$return.= '</em><img src="';
$return.= $b['img_name'];
$return.= '" alt="image" class="img-fluid img-responsive wow fadeIn" /></a></li>';


        }
    } else { // aqui van los que no tienenopcion activada
        
$return.= '<li><em>'; $return.= $x['nombre']; $return.= '</em>';
$return.= '<input type='; $return.= '"'; $return.= 'image'; $return.= '" ';
$return.= 'id='; $return.= '"'; $return.= 'venta'; $return.= '" ';
$return.= 'op='; $return.= '"'; $return.= '20'; $return.= '" ';
$return.= 'cod='; $return.= '"'; $return.= $b["cod"]; $return.= '" ';

$return.= 'mesa='; $return.= '"'; 
$return.= '<? '; 
$return.= 'echo ';
$return.= '$_SESSION["mesa"]'; 
$return.= ' ?>'; 
$return.= '" ';

$return.= 'cliente='; $return.= '"'; 
$return.= '<? '; 
$return.= 'echo ';
$return.= '$_SESSION["clientselect"]'; 
$return.= ' ?>'; 
$return.= '" ';

$return.= 'panel='; $return.= '"'; 
$return.= $panel; 
$return.= '" ';

$return.= 'view='; $return.= '"'; 
$return.= '<? '; 
$return.= 'echo ';
$return.= '$_SESSION["view"]'; 
$return.= ' ?>'; 
$return.= '" ';


$return.= 'src='; $return.= '"'; $return.= $b['img_name']; $return.= '" ';
$return.= 'alt='; $return.= '"'; $return.= 'image'; $return.= '"';
$return.= ' class='; $return.= '"'; $return.= 'img-fluid img-responsive wow fadeIn';
$return.= '" />';
$return.= '</li>'; $return.= "\n";

    } 
    
    $d->close(); //termina opcion activada


} 
unset($panel);
}

///////////////////////////////////////////////	
	$return.= "\n  
</ul> 
 </div> ";

  

 $return.= "</div>
      <div class=\"modal-footer\">
        <button type=\"button\" class=\"btn btn-primary btn-rounded\" data-dismiss=\"modal\">Cerrar</button>
      </div>
    </div>
  </div>
</div>";   
		

} 
// aqui termina el as del inocio del pop up
    $a->close();


    ///
//save
   if($handle = fopen($url . "iconos_".$_SESSION["td"].".php",'w+')){

   		if($msj != NULL){
   			$alert = new Alerts;
    		$alert->Alerta("success","Echo!","Iconos creados correctamente");
   		}
   	
   }
   fwrite($handle,$return);
   fclose($handle);
	


} else { /// termina si hay iconos 
	//save
$return.= '<? '; 
$return.= 'Alerts::Mensaje("No hay iconos que mostrar, por favor ingrese sus productos para poder realizar sus ventas","danger","<a href=\"?iconos\" class=\"btn btn-success\">CREAR ICONOS</a>","<a href=\"https://pizto.com/help#iconos\" class=\"btn btn-primary\" target=\"_blank\"><i class=\"fa fa-info-circle \"></i> VER COMO HACERLO </a>");'; 
$return.= ' ?>'; 

   if($handle = fopen($url . "iconos_".$_SESSION["td"].".php",'w+')){

   		if($msj != NULL){
   			$alert = new Alerts;
    		$alert->Alerta("success","Echo!","Aun no hay iconos para crear");
   		}
   	
   }
   fwrite($handle,$return);
   fclose($handle);

} $countico->close(); // cierro si no hay iconos



} // fin de la funcion



	public function CrearVariables(){
		$db = new dbConn();
		$encrypt = new Encrypt;

		if ($r = $db->select("*", "config_master", "WHERE td = ".$_SESSION['td']."")) { 

			$_SESSION['config_sistema'] = $r["sistema"];
			$_SESSION['config_cliente'] = $r["cliente"];
			$_SESSION['config_slogan'] = $r["slogan"];
			$_SESSION['config_propietario'] = $r["propietario"];
			$_SESSION['config_telefono'] = $r["telefono"];
			$_SESSION['config_giro'] = $r["giro"];
			$_SESSION['config_nit'] = $r["nit"];
			$_SESSION['config_imp'] = $r["imp"];
			$_SESSION['config_propina'] = $r["propina"];
			$_SESSION['config_direccion'] = $r["direccion"];
			$_SESSION['config_email'] = $r["email"];
			$_SESSION['config_imagen'] = $r["imagen"];
			$_SESSION['config_logo'] = $r["logo"];
			$_SESSION['config_skin'] = $r["skin"];
			$_SESSION['tipo_inicio'] = $r["tipo_inicio"];

			$_SESSION['config_pais'] = $r["pais"];
			$_SESSION['config_moneda'] = $r["moneda"];
			$_SESSION['config_moneda_simbolo'] = $r["moneda_simbolo"];
			$_SESSION['config_nombre_impuesto'] = $r["nombre_impuesto"];
			$_SESSION['config_nombre_documento'] = $r["nombre_documento"];
			$_SESSION['tx'] = $r["inicio_tx"];
			$_SESSION['config_otras_ventas'] = $r["otras_ventas"];
			$_SESSION['config_venta_especial'] = $r["venta_especial"];
			
			$_SESSION['config_imprimir_antes'] = $r["imprimir_antes"];
			$_SESSION['config_cambio_tx'] = $r["cambio_tx"];

			if($_SESSION['config_skin'] == NULL) $_SESSION['config_skin'] = "mdb-skin";
			// white-skin , mdb-skin , grey-skin , pink-skin ,  light-blue-skin , black-skin  cyan-skin, navy-blue-skin

			// fixed-sn , hidden-sn
			} unset($r);

			    // para root pero sin descifrar
			if ($root = $db->select("*", "config_root", "WHERE td = ".$_SESSION['td']."")) {

			$_SESSION['root_expira'] = $root["expira"];
			$_SESSION['root_expiracion'] = $root["expiracion"];
			$_SESSION['root_tipo_sistema'] = $root["tipo_sistema"];
			$_SESSION['root_plataforma'] = $root["plataforma"];
     
			} unset($root);
			$_SESSION['root_tipo_sistema'] = $encrypt->Decrypt(
  			$_SESSION['root_tipo_sistema'],$_SESSION['secret_key']);

			$_SESSION['root_plataforma'] = $encrypt->Decrypt(
			$_SESSION['root_plataforma'],$_SESSION['secret_key']);

	}



	public function AddSucursal($user,$td){
		$db = new dbConn();

		    $datos = array();
		    $datos["user"] = $user;
		    $datos["sucursal"] = $td;
		    if ($db->insert("login_sucursales", $datos)) {
		    Alerts::Alerta("success","Agregado Correctamente","Usuario agregado correctamente a la sucursal");
		    } else {
		    Alerts::Alerta("danger","Error","Ocurrio un error inesperado");
		    }
		$this->CuentasSucursal($_SESSION['user']);
	}


	public function CuentasSucursal($user){
		$db = new dbConn();
	
	if($_SESSION["tipo_cuenta"] == 1 and $_SESSION["td"] != 0){ 
	 $a = $db->query("SELECT * FROM login_sucursales order by user desc");
	} else {
		$a = $db->query("SELECT * FROM login_sucursales WHERE user = '$user'");
	}

	if($a->num_rows > 0){
	 echo '<table class="table table-sm table-striped">
			  <thead>
			    <tr>
			    <th scope="col">Usuario</th>
			      <th scope="col">Nombre del Sistema</th>
			      <th scope="col">Pais</th>
			      <th scope="col">Corte</th>
			      <th scope="col">Venta Hoy</th>
			      <th scope="col">Ultima Actualizacion</th>
			      <th scope="col">Cambiar</th>
			    </tr>
			  </thead>
			  <tbody>';
	    foreach ($a as $b) {  
		    $r = $db->select("cliente, pais", "config_master", "WHERE td = ".$b["sucursal"]."");

		    // ultima actualizacion
	    		if ($rx = $db->select("*", "login_sync", "WHERE td = ".$b["sucursal"]." and edo = 1 order by id desc")) {
		    		$update = $rx["fecha"] . " | " . $rx["hora"];		        
		    	} unset($rx);

		    	// total venta por sucursal
		    	$fechax = date("d-m-Y");
		    $ax = $db->query("SELECT sum(total) FROM ticket WHERE edo = 1 and td = ".$b["sucursal"]." and fecha = '$fechax'");
		    foreach ($ax as $bx) {
		     $totalventa=$bx["sum(total)"]; } $ax->close();  

		     // busco si hubo corte
		     if ($ra = $db->select("fecha", "corte_diario", "where edo = 1 and td = ".$b["sucursal"]." order by id DESC LIMIT 1")) { $fechaultima=$ra["fecha"]; } unset($ra); 
		     if($fechaultima == date("d-m-Y")) $corte = "Realizado";
		     else $corte = "Sin corte";


	    	$userx = $b["user"];
	    	$x = $db->select("nombre", "login_userdata", "WHERE user = '$userx'");
		    echo '<tr>
		    	  <th scope="col">'.$x["nombre"].'</th>
			      <th scope="col">'.$r["cliente"].'</th>
			      <th scope="col">'.Helpers::Pais($r["pais"]).'</th>			      
			      <th scope="col">'. $corte .'</th>
			      <th scope="col">'. $r["moneda_simbolo"] . $totalventa .'</th>
			      <th scope="col">'.$update.'</th>
			      <th scope="col">';
				if($b["sucursal"] == $_SESSION['td']){
					echo '<a id="predeterminar" op="131" iden="'.$b["sucursal"].'" class="btn-sm">Predeterminar  <i class="fa fa-play red-text"></i></a>';
				} else {
					echo '<a id="irlocal" op="129" iden="'.$b["sucursal"].'" class="btn-sm">Seleccionar  <i class="fa fa-play blue-text"></i></a>';
				}
			echo '</th>
			    </tr>';
		unset($r);
		unset($x);
	    } 
	    echo '</tbody>
		    </table>';
		} else {
			echo '<h1 class="text-danger text-center">No tiene mas sucursales vinculados a su cuenta</h1>';
		}
		$a->close();

	}





	public function DefineSucursal($user,$td){
		$db = new dbConn();

		    $cambio = array();
		    $cambio["td"] = $td;
		    if ($db->update("login_userdata", $cambio, "WHERE user = '$user'")) {
			    
		   		$_SESSION['td'] = $td;
		      	$_SESSION['secret_key'] = md5($_SESSION['td']);
			  	$this->CrearVariables();
			  	echo '<script>
				window.location.href="?"
				</script>';

			    } 

		     
	}





} // fin de la clase

 ?>