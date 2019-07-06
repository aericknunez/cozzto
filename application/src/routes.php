<?php
include_once '../common/Helpers.php';
include_once '../includes/variables_db.php';
include_once '../includes/db_connect.php';
include_once '../includes/functions.php';
sec_session_start();


include_once '../common/Alerts.php';
$alert = new Alerts;
$helps = new Helpers;
include_once '../common/Fechas.php';
include_once '../common/Encrypt.php';
include_once '../common/Mysqli.php';
$db = new dbConn();

// filtros para cuando no hay session abierta
if($_SESSION["user"] == NULL and $_SESSION["td"] == NULL){
echo '<script>
	window.location.href="application/includes/logout.php"
</script>';
exit();
}
//
if($_REQUEST["op"]=="0"){ // terminar usuario
	if($_POST["nombre"] != NULL && $_POST["tipo"] != NULL){
	include_once '../../system/user/Usuarios.php';
	$usuarios = new Usuarios;
	$usuarios->TerminarUsuario(Helpers::Mayusculas($_POST["nombre"]),$_POST["tipo"],sha1($_POST["user"]));	
	} else {
	Alerts::Alerta("error","Error!","Faltan Datos!");	
	}
}

if($_REQUEST["op"]=="0x"){ // terminar actualizar
	if($_POST["nombre"] != NULL && $_POST["tipo"] != NULL){
	include_once '../../system/user/Usuarios.php';
	$usuarios = new Usuarios;
	$usuarios->ActualizarUsuario(Helpers::Mayusculas($_POST["nombre"]),$_POST["tipo"],sha1($_POST["user"]));	
	} else {
	Alerts::Alerta("error","Error!","Faltan Datos!");	
	}
}

if($_REQUEST["op"]=="0y"){ // cambiar avatar
include_once '../../system/user/Usuarios.php';
	$usuarios = new Usuarios;
	$usuarios->CambiarAvatar($_REQUEST["iden"],$_REQUEST["user"]);
}


if($_REQUEST["op"]=="0z"){ // redirecciona despues de registrar a llenar datos
echo '<script>
    window.location.href="../../?modal=register_success&user=' . $_REQUEST["user"] . '";
</script>';
}

/// usuarios
if($_REQUEST["op"]=="1"){
include_once '../../system/user/Usuarios.php';
$usuarios = new Usuarios;
$passw1 = filter_input(INPUT_POST, 'pass1', FILTER_SANITIZE_STRING);
$passw2 = filter_input(INPUT_POST, 'pass2', FILTER_SANITIZE_STRING);
$usuarios->CompararPass($passw1, $passw2); 
//Alerts::Alerta("success","Agregado Correctamente","No se puede hacer la accion solicitada, consulte el manual");
}


if($_REQUEST["op"]=="2"){
include_once '../../system/user/Usuarios.php';
$usuarios = new Usuarios;
$alert->EliminarUsuario($_REQUEST["iden"], $_REQUEST["username"]);
}

if($_REQUEST["op"]=="3"){
include_once '../../system/user/Usuarios.php';
$usuarios = new Usuarios;
$usuarios->EliminarUsuario($_REQUEST["iden"], $_REQUEST["username"]);
}

//////////iconos
if($_REQUEST["op"]=="4"){
include_once '../../system/config_iconos/Icono.php';
$iconos = new Icono;
$iconos->AddCategoria($_REQUEST["nombre"], $_REQUEST["imagen"]);

include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;
	$configuracion->CrearIconos("../iconos/", 1);
	
	Helpers::ActivaActualizar();
}

if($_REQUEST["op"]=="5"){
include_once '../../system/config_iconos/Icono.php';
$iconos = new Icono;
$iconos->AddProducto($_REQUEST["nombre"],$_REQUEST["imagen"],$_REQUEST["popup"],$_REQUEST["preci"],$_REQUEST["opcion"]);

include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;
	$configuracion->CrearIconos("../iconos/", 1);
	
	Helpers::ActivaActualizar();
}


if($_REQUEST["op"]=="6"){
include_once '../../system/config_iconos/Icono.php';
$iconos = new Icono;
$iconos->ModProducto($_REQUEST["cod"],$_REQUEST["nombre"],$_REQUEST["popup"],$_REQUEST["imagen"]);

include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;
	$configuracion->CrearIconos("../iconos/", 1);
	
	Helpers::ActivaActualizar();
}


if($_REQUEST["op"]=="7"){
include_once '../../system/config_iconos/Icono.php';
$iconos = new Icono;
$iconos->ModCategoria($_REQUEST["cod"],$_REQUEST["nombre"],$_REQUEST["imagen"]);

include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;
	$configuracion->CrearIconos("../iconos/", 1);
	
	Helpers::ActivaActualizar();
}


if($_REQUEST["op"]=="8"){
include_once '../../system/config_iconos/Icono.php';
$iconos = new Icono;
$iconos->DelProducto($_REQUEST["cod"]);

include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;
	$configuracion->CrearIconos("../iconos/", 1);
	
	Helpers::ActivaActualizar();
}


if($_REQUEST["op"]=="9"){
include_once '../../system/config_iconos/Icono.php';
$iconos = new Icono;
$iconos->DelCategoria($_REQUEST["cod"]);

include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;
	$configuracion->CrearIconos("../iconos/", 1);
	
	Helpers::ActivaActualizar();
}


if($_REQUEST["op"]=="10"){
	include_once '../../system/config_iconos/Icono.php';
	$iconos = new Icono;
if($_REQUEST["nombre"] != NULL){
	$iconos->AddOpcion($_REQUEST["nombre"]);
	} else {
		Alerts::Alerta("error","Error!","La opcion esta vacia!");
		$iconos->VerOpciones();
	}

include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;
	$configuracion->CrearIconos("../iconos/", 1);
	
	Helpers::ActivaActualizar();
}



if($_REQUEST["op"]=="11"){
include_once '../../system/config_iconos/Icono.php';
$iconos = new Icono;
$iconos->AddOpcionName($_REQUEST["cod"],$_REQUEST["nombre"],$_REQUEST["imagen"]);

include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;
	$configuracion->CrearIconos("../iconos/", 1);
	
	Helpers::ActivaActualizar();
}


if($_REQUEST["op"]=="12"){
include_once '../../system/config_iconos/Icono.php';
$iconos = new Icono;
$iconos->DelOpciones($_REQUEST["cod"]);

include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;
	$configuracion->CrearIconos("../iconos/", 1);
	
	Helpers::ActivaActualizar();
}


if($_REQUEST["op"]=="13"){
include_once '../../system/config_iconos/Icono.php';
$iconos = new Icono;
$iconos->DelOpcionesName($_REQUEST["cod"]);

include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;
	$configuracion->CrearIconos("../iconos/", 1);
	
	Helpers::ActivaActualizar();
} 



if($_REQUEST["op"]=="14"){
include_once '../../system/config_iconos/Icono.php';
$iconos = new Icono;

$idArray = explode(",",$_POST['ids']);
//update images order
$iconos->UpdateReordenar($idArray);
} 


 // termina iconos////

/////////////////////// comienza las ventas

if($_REQUEST["op"]=="20"){ //venta normal


		include_once '../../system/ventas/Venta.php';
		$ventas = new Venta;
		if($_REQUEST["cliente"] == NULL) { $clientes = 1; }
		else { $clientes = $_REQUEST["cliente"]; } 
			
			if($_SESSION["mesa"] == NULL){
			$ventas->CrearMesa($clientes); }

		$ventas->Execute($_REQUEST["cod"], $_SESSION["mesa"], $clientes, $_SESSION['config_imp']);

		if($_REQUEST["opcion"] != NULL){
		$identificador = $ventas->AgregarOpcion(NULL,$_REQUEST["opcion"],$_SESSION["mesa"],$clientes,NULL);	
		} 

		// para pantallas
		include_once '../../system/tv/Pantallas.php';
		$pantalla = new Pantallas;
		if($_REQUEST["opcion"] != NULL){ $option = "1"; } else { $option = "0";}
		if($_REQUEST["panel"] != NULL and $_REQUEST["panel"] != 0){
		$pantalla->AgregarControl($identificador, $_SESSION["mesa"],$clientes,$option,$_REQUEST["panel"]);
		}
		$pantalla->Cambia(1);

} 


if($_REQUEST["op"]=="20x"){ //Otras Ventas
include_once '../../system/ventas/Venta.php';
$ventas = new Venta;
if($_REQUEST["cliente"] == NULL) { $clientes = 1; }
else { $clientes = $_REQUEST["cliente"]; } 
	if($_SESSION["mesa"] == NULL){
	$ventas->CrearMesa($clientes);
	}
$ventas->OtrasVentas(8888, 
	$_SESSION["mesa"], 
	$clientes, $_SESSION['config_imp'],
	$_POST["producto"],
	$_POST["cantidad"]);

if($_POST["view"] == 1) { header("location: ../../?view&mesa=".$_SESSION["mesa"].""); }
else { header("location: ../../?");}

}


if($_REQUEST["op"]=="20y"){ //Venta Especial
include_once '../../system/ventas/Venta.php';
$ventas = new Venta;

include_once '../../system/ventas/Especial.php';
$especial = new Especial;
if($_REQUEST["cliente"] == NULL) { $clientes = 1; }
else { $clientes = $_REQUEST["cliente"]; } 
	if($_SESSION["mesa"] == NULL){
	$ventas->CrearMesa($clientes);
	}
$especial->VentaEspecial($_REQUEST["cod"], 
						$_SESSION["mesa"], 
						$clientes, $_SESSION['config_imp']);

}

if($_REQUEST["op"]=="20z"){ // MUESTRA EL LATERAL (venta especial)
		include_once '../../system/ventas/Especial.php';
		$ventas = new Especial;
		$ventas->VerProductos($_SESSION["mesa"]);
} 


if($_REQUEST["op"]=="20w"){ // BORRAR ESPECIAL 
		include_once '../../system/ventas/Especial.php';
		$ventas = new Especial;
		$ventas->BorrarEspecial($_REQUEST["iden"]);
} 

if($_REQUEST["op"]=="20v"){ // BORRAR TODO  venta especial
		include_once '../../system/ventas/Especial.php';
		$ventas = new Especial;
		$ventas->BorrarTodo($_REQUEST["url"]);
} 

if($_REQUEST["op"]=="20u"){ // agrega detalle especial
include_once '../../system/ventas/Venta.php';
$ventas = new Venta;
if($_REQUEST["cliente"] == NULL) { $clientes = 1; }
else { $clientes = $_REQUEST["cliente"]; } 
	if($_SESSION["mesa"] == NULL){
	$ventas->CrearMesa($clientes);
	}
$ventas->OtrasVentas(8889, 
	$_SESSION["mesa"], 
	$clientes, $_SESSION['config_imp'],
	$_POST["producto"],
	$_POST["cantidad"]);

if($_POST["view"] == 1) { header("location: ../../?view&mesa=".$_SESSION["mesa"].""); }
else { header("location: ../../?");}
}

if($_REQUEST["op"]=="21"){ // cobra la venta
include_once '../../system/ventas/Venta.php';
$ventas = new Venta;
$mesa = $_SESSION["mesa"];
$ventas->Facturar($_SESSION["mesa"],$_POST["total"]);
header("location: ../../?modal=factura&mesa=$mesa&efectivo=".$_POST["total"]."");
} 

if($_REQUEST["op"]=="22"){ // MUESTRA EL LATERAL (FACTURA)
		include_once '../../system/ventas/Venta.php';
		include_once '../../system/corte/Corte.php';
		$ventas = new Venta;
		$ventas->VerFactura($_SESSION["mesa"]);
} 


if($_REQUEST["op"]=="23"){ // borrar producto
include_once '../../system/ventas/Venta.php';
include_once '../../system/ventas/Especial.php';
$ventas = new Venta;
$ventas->BorrarProducto($_REQUEST["iden"],$_SESSION['config_imp']);


include_once '../../system/tv/Pantallas.php';
	$pantalla = new Pantallas;
	$pantalla->EliminaProducto($_REQUEST["iden"]);
	$pantalla->Cambia(1);
} 


if($_REQUEST["op"]=="24"){ // borrar factura
include_once '../../system/ventas/Venta.php';
$ventas = new Venta;
$ventas->BorrarFactura($_REQUEST["mesa"]);

include_once '../../system/tv/Pantallas.php';
	$pantalla = new Pantallas;
	$pantalla->EliminaControl($_REQUEST["mesa"]);
	$pantalla->Cambia(1);
} 


if($_REQUEST["op"]=="25"){ // cobra la venta
include_once '../../system/ventas/Venta.php';
$ventas = new Venta;
$mesa = $_SESSION["mesa"];
$ventas->FacturarCliente($_SESSION["mesa"],$_POST["total"],$_POST["cancela"]);
header("location: ../../?modal=factura&mesa=$mesa&efectivo=".$_POST["total"]."&cancela=".$_POST["cancela"]."");
}




//////////
if($_REQUEST["op"]=="26"){ // cambiar tipo de pantalla de inicio mesa o rapida
	include_once '../../system/ventas/Venta.php';
	$venta = new Venta;

	if($_SESSION["mesa"] == NULL){
			if($_SESSION["tipo_inicio"] == 1) $_SESSION["tipo_inicio"] = 2;
			else $_SESSION["tipo_inicio"] = 1;
		
	} else {

		if($venta->VerProductosMesa($_SESSION["mesa"]) == 0){
			$db->delete("mesa", "WHERE mesa=".$_SESSION["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and estado = 1");
			unset($_SESSION["mesa"]);
			if($_SESSION["tipo_inicio"] == 1) $_SESSION["tipo_inicio"] = 2;
			else $_SESSION["tipo_inicio"] = 1;
		}
	}
} // termina op



if($_REQUEST["op"]=="27"){ // cambiar tx
	include_once '../../system/ventas/Venta.php';
	$venta = new Venta;
	if($_SESSION["mesa"] == NULL){
			if($_SESSION["tx"] == 1) { $_SESSION["tx"] = 0; } 
			else { $_SESSION["tx"] = 1; }
	} else {
		
		if($venta->VerProductosMesa($_SESSION["mesa"]) == 0){
			$db->delete("mesa", "WHERE mesa=".$_SESSION["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and estado = 1");
			unset($_SESSION["mesa"]);
			if($_SESSION["tx"] == 1) { $_SESSION["tx"] = 0; } 
			else { $_SESSION["tx"] = 1; }
		}
	}
} // termina op
 


if($_REQUEST["op"]=="27x"){ // cambiar panel
	include_once '../../system/ventas/Venta.php';
	$venta = new Venta;
	if($_SESSION["mesa"] == NULL){
		if($_SESSION["muestra_vender"] == 1) { unset($_SESSION["muestra_vender"]); }
		else {
			$_SESSION["muestra_vender"] = 1;
		} 
		
	} else {
				if($venta->VerProductosMesa($_SESSION["mesa"]) == 0){
				$db->delete("mesa", "WHERE mesa=".$_SESSION["mesa"]." and tx = ".$_SESSION["tx"]." and td = ".$_SESSION["td"]." and estado = 1");
				unset($_SESSION["mesa"]);
					if($_SESSION["muestra_vender"] == 1) { unset($_SESSION["muestra_vender"]); }
					else {
						$_SESSION["muestra_vender"] = 1;
					} 
				}
	}	


}
////////////////////////////////////////////////////

if($_REQUEST["op"]=="28"){ // Agregar gasto
	include_once '../../system/gastos/Gasto.php';
	$gastos = new Gasto;
	if($_POST["gasto"] == NULL and $_POST["cantidad"] == NULL){
	Alerts::Alerta("error","Error!","Hay datos importantes vacios!");
	$gastos->VerGastos();
	} else{
	$gastos->AddGasto($_POST["gasto"],$_POST["tipo"],$_POST["descripcion"],$_POST["cantidad"]);
	}
} 



if($_REQUEST["op"]=="29"){ // Borrar gasto
	include_once '../../system/gastos/Gasto.php';
	$gastos = new Gasto;
	$gastos->BorrarGasto($_REQUEST["iden"]);
} 


///////////////////////////////// productos
if($_REQUEST["op"]=="30"){ // Agregar Unidad
	include_once '../../system/productos/Producto.php';
	$productos = new Producto;
	$productos->AddUnidad($_POST["nombre"],$_POST["abreviacion"]);
	
	Helpers::ActivaActualizar();
} 


if($_REQUEST["op"]=="31"){ // Borrar gasto
	include_once '../../system/productos/Producto.php';
	$productos = new Producto;
	$productos->BorrarUnidad($_POST["iden"]);
	
	Helpers::ActivaActualizar();
} 


if($_REQUEST["op"]=="32"){ // Agregar Porciones
	include_once '../../system/productos/Producto.php';
	$productos = new Producto;
	$productos->AddPorciones($_POST["nombre"],$_POST["producto"],$_POST["cantidad"]);
	
	Helpers::ActivaActualizar();
} 



if($_REQUEST["op"]=="33"){ // Borrar porcion
	include_once '../../system/productos/Producto.php';
	$productos = new Producto;
	$productos->BorrarPorcion($_POST["iden"]);
	
	Helpers::ActivaActualizar();
} 



if($_REQUEST["op"]=="34"){ // agrega materia prima
	include_once '../../system/productos/Producto.php';
	$productos = new Producto;
	$productos->AddMateria($_POST["nombre"],$_POST["cantidad"],$_POST["unidad"]);
	
	Helpers::ActivaActualizar();
}


if($_REQUEST["op"]=="35"){ // Borrar gasto
	include_once '../../system/productos/Producto.php';
	$productos = new Producto;
	$productos->BorrarMateria($_POST["iden"]);
	
	Helpers::ActivaActualizar();
}


if($_REQUEST["op"]=="36"){ // Agregar Porciones a un producto
	if(isset($_POST["producto"])){
		include_once '../../system/productos/Producto.php';
		$productos = new Producto;
		$productos->AddPorcionProducto($_POST["iden"],$_POST["producto"]);
	}
	
	Helpers::ActivaActualizar();
} 
 

if($_REQUEST["op"]=="37"){ // Agregar Porciones a un producto
include_once '../../system/productos/Producto.php';
$productos = new Producto;
$productos->BorrarPorcionProducto($_POST["iden"],$_POST["cod"]);
	
	Helpers::ActivaActualizar();
} 


if($_REQUEST["op"]=="38"){ // mostrar productos paginados
include_once '../../system/productos/Producto.php';
$productos = new Producto;
$productos->VerPlatillos($_POST["iden"]);
} 


if($_REQUEST["op"]=="39"){ // mostrar productos paginados
include_once '../../system/productos/Producto.php';
$productos = new Producto;
$productos->VerMateria($_POST["iden"]);
}


if($_REQUEST["op"]=="39.3"){ // mostrar productos paginados
include_once '../../system/productos/Producto.php';
$productos = new Producto;
$productos->VerPorciones($_POST["iden"]);
}


if($_REQUEST["op"]=="39.1"){ // mostrar productos paginados
include_once '../../system/productos/Producto.php';
$productos = new Producto;
$productos->VerUnidad($_POST["iden"]);
} 


if($_REQUEST["op"]=="39.2"){ // cambiar pantalla
include_once '../../system/productos/Producto.php';
$productos = new Producto;
$productos->CambiarPantalla($_REQUEST["cod"],$_REQUEST["iden"]);
$productos->VerPlatillos($_REQUEST["pagina"]);

include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;
	$configuracion->CrearIconos("../iconos/", 1);
} 




/////////////////////////////////// mesa
if($_REQUEST["op"]=="40"){ // sumar numero de clientes
include_once '../../system/mesas/Mesa.php';
$mesas = new Mesa;
$mesas->Sumar();
}


if($_REQUEST["op"]=="41"){ // Agrega uno mas a la mesa
include_once '../../system/mesas/Mesa.php';
$mesas = new Mesa;
$mesas->Restar();
} 


if($_REQUEST["op"]=="42"){ // activar mesa
include_once '../../system/ventas/Venta.php';
$ventas = new Venta;
$ventas->CrearMesa($_SESSION["nclientes"]);
$mesa=$_SESSION["mesa"];
unset($_SESSION["mesa"], $_SESSION["nclientes"]);
header("location: ../../?view&mesa=".$mesa."");
} 


if($_REQUEST["op"]=="43"){ // 
unset($_SESSION["nclientes"]);
header("location: ../../?");
} 


if($_REQUEST["op"]=="44"){ // nuevo cliente en mesa
include_once '../../system/mesas/Mesa.php';
$mesas = new Mesa;
$mesas->AddCliente($_REQUEST["mesa"]);
} 


if($_REQUEST["op"]=="45"){ // cambiar cliente

		if($_REQUEST["select"] != 0) { 
			$_SESSION['clientselect'] = $_REQUEST["select"];
		} else {
			unset($_SESSION['clientselect']);
		}
}


if($_REQUEST["op"]=="46"){ // cargar clientes
include_once '../../system/mesas/Mesa.php';
$mesas = new Mesa;
$mesas->VerClientes($_SESSION['mesa']);
} 


if($_REQUEST["op"]=="47"){ // cargar iconos
include_once '../../system/mesas/Mesa.php';
$mesas = new Mesa;
$mesas->VerIconos($_SESSION['mesa']);
}  



///////////////////////////////////////////// cuentas

if($_REQUEST["op"]=="50"){ // clientes
include_once '../../system/mesas/Mesa.php';
$mesas = new Mesa;
$mesas->ClientSelect($_SESSION['mesa']);
}  


if($_REQUEST["op"]=="51"){ // clientes a pasar cuenta
include_once '../../system/mesas/Mesa.php';
$mesas = new Mesa;
$mesas->AsignClient($_SESSION['mesa']);
}  


if($_REQUEST["op"]=="52"){ // seleccionar cliente
		if($_SESSION['client-asign'] == $_REQUEST["cliente"]) { 
			unset($_SESSION['client-asign']);
		} else {
			$_SESSION['client-asign'] = $_REQUEST["cliente"];			
		}
}


if($_REQUEST["op"]=="53"){ // seleccionar cliente
	if($_SESSION['client-asign'] != NULL){
include_once '../../system/mesas/Mesa.php';
$mesas = new Mesa;
$mesas->DividirCuenta($_SESSION['mesa'],$_SESSION['client-asign'],$_REQUEST["cliente"]);
	} else {
		Alerts::Alerta("error","Error!","Seleccione el cliente del que va a transferir!");
	}

}


if($_REQUEST["op"]=="54"){ // mostrar cliente a facturar
include_once '../../system/mesas/Mesa.php';
$mesas = new Mesa;
$mesas->ClienteFactura($_SESSION['mesa']); 
}


if($_REQUEST["op"]=="55"){ // mostrar cliente a facturar
		include_once '../../system/ventas/Venta.php';
		$ventas = new Venta;
		$ventas->VerFacturaCliente($_REQUEST["mesa"],$_REQUEST["cliente"]);
}





/////////////////////////////////////////////////////
if($_REQUEST["op"]=="56"){ // modificar opciones
include_once '../../system/mesas/Mesa.php';
$mesas = new Mesa;
$mesas->OpcionesActivas($_REQUEST["mesa"],$_REQUEST["iden"],$_REQUEST["cod"]); 

include_once '../../system/tv/Pantallas.php';
	$pantalla = new Pantallas;
	$pantalla->Cambia(1);
}


if($_REQUEST["op"]=="57"){ // modificar opciones
	include_once '../../system/mesas/Mesa.php';
	$mesas = new Mesa;
	$mesas->OpcionesModificar(
		$_REQUEST["mesa"],
		$_REQUEST["cod"],
		$_REQUEST["iden"],
		$_REQUEST["opcion"],
		$_REQUEST["activo"]);  

include_once '../../system/tv/Pantallas.php';
	$pantalla = new Pantallas;
	$pantalla->Cambia(1);
}


if($_REQUEST["op"]=="58"){ // eliminar opciones
	include_once '../../system/ventas/Venta.php';
	$ventas = new Venta;
	$ventas->BorrarOpcion($_REQUEST["cod"], $_REQUEST["iden"], $_REQUEST["activo"]);

	include_once '../../system/mesas/Mesa.php';
	$mesas = new Mesa;
	$mesas->OpcionesActivas($_REQUEST["mesa"],$_REQUEST["iden"],$_REQUEST["cod"]); 
	$mesas->VerificaOpcionesActivas($_REQUEST["mesa"],$_REQUEST["iden"],$_REQUEST["cod"]);

include_once '../../system/tv/Pantallas.php';
	$pantalla = new Pantallas;
	$pantalla->Cambia(1);
}



if($_REQUEST["op"]=="59"){ // agregar opciones (listar opciones para agregar)
	include_once '../../system/mesas/Mesa.php';
	$mesas = new Mesa;
	$mesas->ListarOpciones($_REQUEST["cod"], $_REQUEST["iden"], $_REQUEST["cliente"]);
}



if($_REQUEST["op"]=="60"){ // cambiar o eliminar
include_once '../../system/ventas/Venta.php';
$ventas = new Venta;
	
	if($_REQUEST["opcion"] == 1){ // eliminar
		$ventas->BorrarOpcion($_REQUEST["cod"], $_REQUEST["iden"], $_REQUEST["activo"]);
	} else { //modificar
		$ventas->ActualizarOpcion($_REQUEST["cod"], $_REQUEST["iden"], $_REQUEST["cambio"], $_REQUEST["activo"]);
	}
include_once '../../system/mesas/Mesa.php';
$mesas = new Mesa;
$mesas->OpcionesActivas($_REQUEST["mesa"],$_REQUEST["iden"],$_REQUEST["cod"]);

include_once '../../system/tv/Pantallas.php';
	$pantalla = new Pantallas;
	$pantalla->Cambia(1);
}

if($_REQUEST["op"]=="61"){ // muestra las sub opciones para aplicarlas
include_once '../../system/mesas/Mesa.php';
$mesas = new Mesa;
$mesas->VerSubOpciones(
	$_REQUEST["mesa"],
	$_REQUEST["cod"],
	$_REQUEST["iden"],
	$_REQUEST["opcion"],
	$_REQUEST["cliente"]);
}



if($_REQUEST["op"]=="62"){ // agrega la opcion
	include_once '../../system/ventas/Venta.php';
	$ventas = new Venta;
	$ventas->AgregarOpcion(
		$_REQUEST["cod"],
		$_REQUEST["opcion"],
		$_REQUEST["mesa"],
		$_REQUEST["cliente"],
		$_REQUEST["iden"]);
/// veo las mesas despues de agregar
Alerts::Alerta("success","Exito!","Opcion agregada corectamente!");
include_once '../../system/mesas/Mesa.php';
$mesas = new Mesa;
$mesas->OpcionesActivas($_REQUEST["mesa"],$_REQUEST["iden"],$_REQUEST["cod"]);
$mesas->VerificaOpcionesActivas($_REQUEST["mesa"],$_REQUEST["iden"],$_REQUEST["cod"]);

include_once '../../system/tv/Pantallas.php';
	$pantalla = new Pantallas;
	$pantalla->Cambia(1);
}



///////////////////////// corte /////////////////

if($_REQUEST["op"]=="65"){ // corte preguntar
	if($_POST["efectivo"] ==  NULL){
		Alerts::Alerta("error","Error!","El Formulario esta vacio");
	} else {
		Alerts::RealizarCorte("ejecuta-corte","66",$_POST["efectivo"]);
	}
}

if($_REQUEST["op"]=="66"){ // ejecuta corte
include_once '../../system/corte/Corte.php';
include_once '../../system/sync/Sync.php';
$cortes = new Corte;
if($_POST["fecha"] == NULL){ $fecha = date("d-m-Y"); 
} else {
   $fecha = $_POST["fecha"];
}
$cortes->EjecutarCorte($_POST["efectivo"], $fecha);
}



if($_REQUEST["op"]=="67"){ // ver el contenido
	include_once '../../system/corte/Corte.php';
	include_once '../../system/sync/Sync.php';
	$cortes = new Corte;
	$cortes->Contenido(date("d-m-Y"));
}


if($_REQUEST["op"]=="68"){ // cancelar corte
	include_once '../../system/corte/Corte.php';
	$cortes = new Corte;
	if($_POST["fecha"] == NULL){ $fecha = date("d-m-Y"); 
	} else {
	   $fecha = $_POST["fecha"];
	}
	$cortes->CancelarCorte($_POST["random"], $fecha);
}


if($_REQUEST["op"]=="70"){ // historial diario
	include_once '../../system/historial/Historial.php';
	$historial = new Historial;
	if($_POST["fecha_submit"] == NULL){ 
		$fecha = date("d-m-Y"); 
	} else { 
		$fecha = $_POST["fecha_submit"];
	}
	$historial->HistorialDiario($fecha);
}


if($_REQUEST["op"]=="71"){ // historial mensual
	include_once '../../system/historial/Historial.php';
	$historial = new Historial;
		$fecha=$_POST["mes"];
		@$ano=$_POST["ano"];
		$fechax="-$fecha-$ano";

	$historial->HistorialMensual($fechax);
}


if($_REQUEST["op"]=="72"){ // historial cortes
	include_once '../../system/historial/Historial.php';
	$historial = new Historial;
	if($_POST["fecha1_submit"]){
		$inicio = $_POST["fecha1_submit"]; $fin=$_POST["fecha2_submit"];
	} else {
		$inicio = date("01-m-Y"); $fin=date("31-m-Y");
	}
	$historial->HistorialCortes($inicio, $fin);

}


///////
if($_REQUEST["op"]=="73"){ // historial diario
	include_once '../../system/historial/Historial.php';
	$historial = new Historial;
	if($_POST["fecha_submit"] == NULL){ 
		$fecha = date("d-m-Y"); 
	} else { 
		$fecha = $_POST["fecha_submit"];
	}
	$historial->HistorialGDiario($fecha);
}


if($_REQUEST["op"]=="74"){ // historial mensual
	include_once '../../system/historial/Historial.php';
	$historial = new Historial;
		$fecha=$_POST["mes"];
		@$ano=$_POST["ano"];
		$fechax="-$fecha-$ano";

	$historial->HistorialGMensual($fechax);
}


if($_REQUEST["op"]=="75"){ // mesas fecha
	include_once '../../system/mesashoy/Mesas.php';
	$mesas = new Mesas;
	
	if($_POST["fecha_submit"] == NULL){ 
		$fecha = date("d-m-Y"); 
	} else { 
		$fecha = $_POST["fecha_submit"];
	}
	$mesas->VerMesas($fecha,2);
}

if($_REQUEST["op"]=="76"){ // historial In Out
	include_once '../../system/historial/Historial.php';
	$historial = new Historial;
	if($_POST["fecha_submit"] == NULL){ 
		$fecha = date("d-m-Y"); 
	} else { 
		$fecha = $_POST["fecha_submit"];
	}
	$historial->InOut($fecha);
}




if($_REQUEST["op"]=="80"){ // search -> Eliminar Orden tx =0
Alerts::AlertaCambios("eliminar-orden","81",$_REQUEST["iden"],"Esta seguro que desea eliminar esta orden? El cambio no se puede revertir");
}

if($_REQUEST["op"]=="81"){ // search -> Eliminar Orden tx =0
	include_once '../../system/search/Busqueda.php';
	$search = new Busqueda;
	$search->BorrarOrden($_REQUEST["iden"]); // el iden es el numero de factura
}


if($_REQUEST["op"]=="82"){ // search -> Eliminar Orden tx =0
Alerts::AlertaCambios("cancelar-factura","83",$_REQUEST["iden"],"Esta seguro que desea eliminar esta Factura? El cambio no se puede revertir");
}

if($_REQUEST["op"]=="83"){ // search -> Eliminar Factura tx =1
	include_once '../../system/search/Busqueda.php';
	$search = new Busqueda;
	$search->CancelarFactura($_REQUEST["iden"]); // el iden es el numero de factura
}


if($_REQUEST["op"]=="84"){ // search -> Eliminar Orden tx =0
Alerts::AlertaCambios("pasar-factura","85",$_REQUEST["iden"],"Esta seguro que desea Pasar a factura esta orden? El cambio no se puede revertir");
}

if($_REQUEST["op"]=="85"){ // search -> Eliminar Factura tx =1
	include_once '../../system/search/Busqueda.php';
	$search = new Busqueda;
	$search->CambiarFactura($_REQUEST["iden"]); // el iden es el numero de factura
}



if($_REQUEST["op"]=="86"){ // imprimir factura
    $user = $_SESSION["user"];
    $tipo = $_REQUEST["tipo"];

    $a = $db->query("SELECT * FROM facturar_users WHERE tipo = '$tipo' and user = '$user' and td = ".$_SESSION["td"]."");
    foreach ($a as $b) {

    $clase = $b["clase"];
    
	    if($_REQUEST["tipo"] == 1){ // para ticket
	    include_once '../../system/facturar/Ticket.php';
	    $imprimir = new Ticket; 
	        $imprimir->$clase(2,$_REQUEST["iden"],$_REQUEST["efectivo"],$b["impresora"],$_REQUEST["mesa"],$b["ticket"]);
	    Alerts::Alerta("success","Imprimiendo","Imprimiendo Factura");
	    }

	    if($_REQUEST["tipo"] == 2 and $_SESSION["tx"] == 1){ // para factura
	    include_once '../../system/facturar/Factura.php';
	    $imprimir = new Factura;  // la mesa aqui es solo si es op 3 en el 1er para
	        $imprimir->$clase(2,$_REQUEST["iden"],$_REQUEST["efectivo"],$b["impresora"],$_REQUEST["mesa"],$b["ticket"]);
	    Alerts::Alerta("success","Imprimiendo","Imprimiendo Factura");
	    }

	}


}



if($_REQUEST["op"]=="87"){ // para no facturar
	if($_SESSION["mesa"] != NULL){
			if($_SESSION["noimprimir"] == 1) unset($_SESSION["noimprimir"]);
			else $_SESSION["noimprimir"] = 1;
		
	} else {
	Alerts::Alerta("error","Error!","No debe haber ninguna mesa activa para continuar!");
	}
}


if($_REQUEST["op"]=="88"){ // Abrir Caja

	$user = $_SESSION["user"];
	if ($r = $db->select("impresora", "facturar_users", 
		"WHERE tipo = 1 and user = '$user' and td = ".$_SESSION["td"]."")) { 
		$impresora = $r["impresora"];
	} unset($r);  

		include_once '../../system/facturar/Ticket.php';
		$imprimir = new Ticket; 
		$imprimir->AbrirCaja($impresora);//(tipo,numero,cambio,impresor,mesa)	
}


if($_REQUEST["op"]=="89"){ // Reporte Diario

	$user = $_SESSION["user"];
	if ($r = $db->select("ticket, impresora", "facturar_users", 
		"WHERE tipo = 2 and user = '$user' and td = ".$_SESSION["td"]."")) { 
		$impresora = $r["impresora"]; $ticket = $r["ticket"];
	} unset($r);  

		include_once '../../system/facturar/Factura.php';
		$imprimir = new Factura; 
		$imprimir->ReporteDiario($_REQUEST["iden"],$impresora,$ticket);	
		Alerts::Alerta("success","Imprimiendo","Imprimiendo Factura");
}




/////////////////configuracion
if($_REQUEST["op"]=="90"){ 
	include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;

	if($_POST["pais"] == 1){
		$moneda = "Dolares"; $simbolo = "$"; $imp = "IVA"; $doc = "NIT";
	}if($_POST["pais"] == 2){
		$moneda = "Lempiras"; $simbolo = "L"; $imp = "ISV"; $doc = "RTN";
	}if($_POST["pais"] == 3){
		$moneda = "Quetzales"; $simbolo = "Q"; $imp = "IVA"; $doc = "NIT";
	}

	$configuracion->Configuraciones($_POST["sistema"],
									$_POST["cliente"],
									$_POST["slogan"],
									$_POST["propietario"],
									$_POST["telefono"],
									$_POST["direccion"],
									$_POST["email"],
									$_POST["pais"],
									$_POST["giro"],
									$_POST["nit"],
									$_POST["imp"],
									$_POST["propina"],
									$imp,
									$doc,
									$moneda,
									$simbolo,
									$_POST["tipo_inicio"],
									$_POST["skin"],
									$_POST["inicio_tx"],
									$_POST["otras_ventas"],
									$_POST["venta_especial"],
									$_POST["imprimir_antes"],
									$_POST["cambio_tx"]);
	Helpers::ActivaActualizar();
}

if($_REQUEST["op"]=="91"){ 
include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;

	include_once '../common/Encrypt.php';
	$configuracion->Root(Encrypt::Encrypt($_POST["expira"],$_SESSION['secret_key']),
		Encrypt::Encrypt(Fechas::Format($_POST["expira"]),$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["pantallas"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["ftp_servidor"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["ftp_path"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["ftp_ruta"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["ftp_user"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["ftp_password"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["tipo_sistema"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["plataforma"],$_SESSION['secret_key']));
	Helpers::ActivaActualizar();
}


if($_REQUEST["op"]=="92"){  // crear iconos para venta
include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;
	$configuracion->CrearIconos("../iconos/", 1);
}


if($_REQUEST["op"]=="95"){ 
include_once '../../system/tv/Pantallas.php';
	$pantalla = new Pantallas;
	$pantalla->Comprueba();
}

if($_REQUEST["op"]=="96"){  // muestra el panel
include_once '../../system/tv/Pantallas.php';
	$pantalla = new Pantallas;
	$pantalla->Panel();
	$pantalla->Cambia(0);
}

if($_REQUEST["op"]=="97"){ // mostrar lateral
include_once '../../system/tv/Pantallas.php';
	$pantalla = new Pantallas;
	$pantalla->MostarLateral();
}

if($_REQUEST["op"]=="98"){ // pasar producto a sacado
include_once '../../system/tv/Pantallas.php';
	$pantalla = new Pantallas;
	$pantalla->PasarProducto($_REQUEST["iden"],$_REQUEST["cod"],$_REQUEST["identificador"]);
	$pantalla->Panel();
	$pantalla->Cambia(1);
}

if($_REQUEST["op"]=="99"){ // cambiar pantalla panel
include_once '../../system/tv/Pantallas.php';
	$pantalla = new Pantallas;
	$pantalla->CambiarPanel($_REQUEST["iden"]);
	$pantalla->Panel();
}


if($_REQUEST["op"]=="100"){ // mostrar productos paginados products venta especial
include_once '../../system/config_especial/Config.php';
$configuracion = new Config;
$configuracion->VerProductosEspecial($_REQUEST["iden"]);
} 


if($_REQUEST["op"]=="101"){ // mostrar productos paginados products venta especial
include_once '../../system/config_especial/Config.php';
$configuracion = new Config;
$configuracion->CambiarEspecial($_REQUEST["cod"]);
$configuracion->VerProductosEspecial($_REQUEST["iden"]);
} 


if($_REQUEST["op"]=="102"){ // cambia para mostrarlo en el reporte
include_once '../../system/config_especial/Config.php';
$configuracion = new Config;
$configuracion->CambiarReporte($_REQUEST["cod"]);
$configuracion->VerProductosEspecial($_REQUEST["iden"]);
} 


if($_REQUEST["op"]=="110"){ // agregar producto averias
include_once '../../system/productos/Product.php';
$producto = new Product;
$producto->AgregarAveria($_POST["producto"],$_POST["cantidad"],$_POST["comentarios"]);
	
	Helpers::ActivaActualizar();
} 


if($_REQUEST["op"]=="111"){ // borrar averias
include_once '../../system/productos/Product.php';
$producto = new Product;
$producto->EliminarAveria($_REQUEST["iden"]);
	
	Helpers::ActivaActualizar();
} 

if($_REQUEST["op"]=="112"){ // paginador averias
include_once '../../system/productos/Product.php';
$producto = new Product;
$producto->VerAverias($_REQUEST["iden"]);
} 


if($_REQUEST["op"]=="115"){ // agregar producto nuevo
include_once '../../system/productos/Product.php';
$producto = new Product;
$producto->AgregarProducto($_POST["producto"],$_POST["cantidad"],$_POST["comentarios"]);
	
	Helpers::ActivaActualizar();
} 

if($_REQUEST["op"]=="116"){ // borrar averias
include_once '../../system/productos/Product.php';
$producto = new Product;
$producto->EliminarProducto($_REQUEST["iden"]);
	
	Helpers::ActivaActualizar();
} 

if($_REQUEST["op"]=="117"){ // paginador averias
include_once '../../system/productos/Product.php';
$producto = new Product;
$producto->VerProducto($_REQUEST["iden"]);
}

if($_REQUEST["op"]=="120"){ // subir imagen
include_once '../../system/upimages/Upimages.php';
$Up = new Upimages;
$Up->Subir(
		$_FILES['archivo']['tmp_name'], 
		$_FILES['archivo']['name'],
		$_FILES['archivo']['type'],
		$_FILES['archivo']['size'],
		$_POST["gasto"],
		$_POST["descripcion"]);
	
	Helpers::ActivaActualizar();
}

if($_REQUEST["op"]=="121"){ // mostrar imagen factura
include_once '../../system/upimages/Upimages.php';
$Up = new Upimages;
$Up->VerImagen($_REQUEST["iden"]);

}

if($_REQUEST["op"]=="124"){ // comprueba es estado de cada respaldo
include_once '../../system/historial/Historial.php';
	$historial = new Historial;
	$historial->SyncStatus("../../sync/db/");
}


if($_REQUEST["op"]=="125"){ // comprueba se se ha desarrollado respaldo
include_once '../../system/sync/Sync.php';
$sync = new Sync;
$sync->RespaldoStatus(date("d-m-Y"));
}


if($_REQUEST["op"]=="126"){ // validar el sistema
$_SESSION["caduca"] = 0;
echo '<script>
	window.location.href="?"
</script>';
}


if($_REQUEST["op"]=="127"){ // validar codigo de sistema
include_once '../common/Encrypt.php';
include_once '../../system/index/Inicio.php';
$inicio = new Inicio;
$inicio->Validar($_POST["fecha_submit"], $_POST["codigo"]);
	
	Helpers::ActivaActualizar();
}




if($_REQUEST["op"]=="128"){ // validar cuentas
include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;
	$configuracion->AddSucursal($_POST["user"],$_POST["sistema"]);
}


if($_REQUEST["op"]=="129"){ // cambiar local
include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config; 
  	$_SESSION['td'] = $_POST["iden"];

  $_SESSION['secret_key'] = md5($_SESSION['td']);
  $configuracion->CrearVariables();
  echo '<script>
	window.location.href="?"
	</script>';
}


if($_REQUEST["op"]=="130"){ // crear codigos
include_once '../common/Encrypt.php';
include_once '../../system/index/Inicio.php';
$inicio = new Inicio;
$inicio->CreaCodigos($_POST["fecha_submit"]);
}


if($_REQUEST["op"]=="131"){ // cambiar local predeterminado
include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config; 
	$configuracion->DefineSucursal($_SESSION["user"],$_REQUEST["iden"]);
}


if($_REQUEST["op"]=="132"){ // buscar RTN
include_once '../../system/facturar/Facturar.php';
	$facturar = new Facturar; 
	$facturar->BuscarRtn($_POST["keyword"]);
}


if($_REQUEST["op"]=="133"){ // ver RTN
include_once '../../system/facturar/Facturar.php';
	$facturar = new Facturar; 
	$facturar->VerRtn($_REQUEST["iden"]);
}

if($_REQUEST["op"]=="134"){ // ver RTN
include_once '../../system/facturar/Facturar.php';
	$facturar = new Facturar; 
	$facturar->QuitarRtn();
}

if($_REQUEST["op"]=="135"){ // ver RTN
include_once '../../system/facturar/Facturar.php';
	$facturar = new Facturar; 
	$facturar->AgregarRtn($_POST["cliente"],$_POST["rtn"]);
}

if($_REQUEST["op"]=="136"){ // vpregunta eliminar una cosa
$alert->Eliminar($_REQUEST["idx"],$_REQUEST["opx"],$_REQUEST["iden"],"rtn");
}


if($_REQUEST["op"]=="137"){ // eliminar RTN
include_once '../../system/facturar/Facturar.php';
	$facturar = new Facturar; 
	$facturar->EliminarRtn($_REQUEST["iden"]);
}


if($_REQUEST["op"]=="138"){ // eliminar RTN
include_once '../../system/facturar/Facturar.php';
	$facturar = new Facturar; 
	$facturar->AgregarCai($_POST["inicial"],$_POST["final"],$_POST["fechalimite_submit"],$_POST["cai"]);
	
	Helpers::ActivaActualizar();

}


if($_REQUEST["op"]=="139"){ // eliminar RTN
include_once '../../system/facturar/Facturar.php';
	$facturar = new Facturar; 
	$facturar->EliminarCai($_REQUEST["iden"]);
	
	Helpers::ActivaActualizar();
}


if($_REQUEST["op"]=="140"){ // agregar factura
include_once '../../system/facturar/Facturar.php';
	$facturar = new Facturar; 
	$facturar->AgregarFactura($_POST["nombre"],
							$_POST["imagen"],
							$_POST["tipo"],
							$_POST["txt1"],
							$_POST["txt2"],
							$_POST["txt3"],
							$_POST["txt4"],
							$_POST["n1"],
							$_POST["n2"],
							$_POST["n3"],
							$_POST["n4"]);
	
	Helpers::ActivaActualizar();

}


if($_REQUEST["op"]=="141"){ // agragar impresora
include_once '../../system/facturar/Facturar.php';
	$facturar = new Facturar; 
	$facturar->AgregarImpresora($_POST["impresora"],$_POST["comentarios"]);
	
	Helpers::ActivaActualizar();
}


if($_REQUEST["op"]=="142"){ // agragarUsuarios
include_once '../../system/facturar/Facturar.php';
	$facturar = new Facturar; 
	$facturar->AgregarUsuarios($_POST["tipo"],$_POST["ticket"],$_POST["impresora"],$_POST["clase"]);
	
	Helpers::ActivaActualizar();
}


//// eliminar factura (ticket)
if($_REQUEST["op"]=="143"){ 
include_once '../../system/facturar/Facturar.php';
	$facturar = new Facturar; 
	$facturar->EliminarFact($_REQUEST["iden"]);
	
	Helpers::ActivaActualizar();
}
/// eliminar impresora
if($_REQUEST["op"]=="144"){ 
include_once '../../system/facturar/Facturar.php';
	$facturar = new Facturar; 
	$facturar->EliminarPrint($_REQUEST["iden"]);
	
	Helpers::ActivaActualizar();
}
/// Usuarios
if($_REQUEST["op"]=="145"){ 
include_once '../../system/facturar/Facturar.php';
	$facturar = new Facturar; 
	$facturar->EliminarUser($_REQUEST["iden"]);
	
	Helpers::ActivaActualizar();
}






if($_REQUEST["op"]=="150"){ // Imprimir Ticket
// busco que facura voy a ocupar
$user = $_SESSION["user"];
	if ($r = $db->select("impresora, clase", "facturar_users", 
		"WHERE tipo = ". $_REQUEST["tipo"] ." and user = '$user' and td = ".$_SESSION["td"]."")) {
		$impresora = $r["impresora"]; $clase = $r["clase"]; 
	} unset($r);  

	if($_REQUEST['tipo'] == 1){ // para ticket
		include_once '../../system/facturar/Ticket.php';
		$imprimir = new Ticket; 
		$imprimir->$clase(3,1,NULL,$impresora,6);//(tipo,numero,cambio,impresor,mesa)
	} // el tipo es 1 =  mesa, 2 = factura, 3 = cancela
		if($_REQUEST['tipo'] == 2){ // para factura
		include_once '../../system/facturar/Factura.php';
		$imprimir = new Factura;  // la mesa aqui es solo si es op 3 en el 1er para
		$imprimir->$clase(2,47,NULL,$impresora,null);//(tipo,numero,cambio,imp)
	}

} /// imprimir ticket










if($_REQUEST["op"]=="160"){ // agragarUsuarios
include_once '../../system/reportes/Reporte.php';
include_once '../../system/historial/Historial.php';
	$reporte = new Reporte; 
	if($_POST["fecha_submit"] == NULL){ 
		$fecha = date("d-m-Y"); 
	} else { 
		$fecha = $_POST["fecha_submit"];
	}
	$reporte->Contenido($fecha);
}



if($_REQUEST["op"]=="161"){ // ImprimirRanfo
$user = $_SESSION["user"];

if($_SESSION["tx"] == 1){
	
	if($_REQUEST["inicio"] >= $_REQUEST["final"]){
		Alerts::Alerta("error","Error!","El numero inicial de factura debe ser menor a el numero final!");
	} else {
		
		if ($r = $db->select("ticket, impresora, clase", "facturar_users", 
			"WHERE tipo = 2 and user = '$user' and td = ".$_SESSION["td"]."")) {
			$impresora = $r["impresora"]; $clase = $r["clase"]; $ticket = $r["ticket"]; 
		} unset($r);  


			include_once '../../system/facturar/Factura.php';
			$imprimir = new Factura;  // la mesa aqui es solo si es op 3 en el 1er para

		$counter = 0;

		for ($x = $_REQUEST["inicio"]; $x <= $_REQUEST["final"]; $x++) {
			$counter = $counter + 1;
			$imprimir->$clase(2,$x,NULL,$impresora,NULL,$ticket);
			//(tipo,numero,efectivo,impresora,(mesa), (tiket o factura))
		}

	$texto = "<br>Se estan imprimiendo las facturas desde la factura ".$_REQUEST["inicio"]." hasta la factura ".$_REQUEST["final"]." con un total de facturas de " . $counter . ". Por favor espere hasta que se hayan impreso todas las facturas.";
	Alerts::Mensaje($texto,"warning",NULL,NULL);
  }

	} else {
		Alerts::Alerta("error","Error!","Debe estar facturando para usar esta función!");
	}

} 





if($_REQUEST["op"]=="162"){ // Imprimir contadora
	include_once '../../system/reportes/Reporte.php';
	include_once '../../system/historial/Historial.php';

	if($_POST["mes"] != NULL and $_POST["ano"] != NULL){
		$mes = $_POST["mes"];
		$ano = $_POST["ano"]; 	
	} else {
		$mes = date("m");
		$ano = date("Y");	
	}	

	$reporte = new Reporte; 
	$reporte->Contadora($mes, $ano);
}




if($_REQUEST["op"]=="163"){ // Subir Avatar
		
	if($_FILES['archivo']['name'] != NULL){

		require_once '../common/Imagenes.php';
		$resizer = new Imagenes();
		$n_width = ( $_POST['ancho'] <= 0 ) ? 700 : $_POST['ancho'];
		$n_height = ( $_POST['alto'] <= 0 ) ? 700 : $_POST['alto'];

		$imagen = $resizer->Resize( $_FILES['archivo']['name'], $_FILES['archivo']['tmp_name'], "../../assets/img/logo", $n_width, $n_height);
		if($imagen != FALSE){
			include_once '../../system/upimages/Upimages.php';
			$Up = new Upimages;
			$Up->SaveImgNegocio($imagen);
			echo '<img src="assets/img/logo/'.$imagen.'" alt="">';
		}
	}

}



if($_REQUEST["op"]=="164"){ // comparar las versiones del sistema
	include_once '../../system/sync/Sync.php';
	$synchro = new Sync; 
	$synchro->ComparaVersiones();
}	


if($_REQUEST["op"]=="165"){ // actualizar sistema
	include_once '../../system/sync/Sync.php';
	$synchro = new Sync; 
	exec('C:\Windows\System32\cmd.exe /c START C:\AppServ\www\pizto\download.bat');
	$cambio = array();
    $cambio["up_fecha"] = date("d-m-Y");
    $cambio["up_hora"] = date("H:i:s");
    $db->update("alter_opciones", $cambio, "WHERE td = ".$_SESSION["td"]."");
	$synchro->ComparaVersiones();
}


if($_REQUEST["op"]=="166"){ // actualizar el archivo de control
	include_once '../../system/sync/Sync.php';
	$synchro = new Sync; 
	$synchro->ModificaArchivoSync();
	$synchro->ComparaVersiones();
}


if($_REQUEST["op"]=="167"){ // dar seguimiento a materia prima
	include_once '../../system/productos/Producto.php';
	$productos = new Producto;
	$productos-> SeguirMateria($_REQUEST["cod"], $_REQUEST["iden"]);
	
	Helpers::ActivaActualizar();
}



if($_REQUEST["op"]=="168"){ // borrar factura completa
include_once '../../system/facturar/Facturar.php';
	$facturar = new Facturar; 
	$facturar->BorrarFactura($_REQUEST["mesa"], $_REQUEST["num_fac"]);

include_once '../../system/tv/Pantallas.php';
	$pantalla = new Pantallas;
	$pantalla->EliminaControl($_REQUEST["mesa"]);
	$pantalla->Cambia(1);
} 










/// comienza admin 200
/// 
/// 
if($_REQUEST["op"]=="200"){ // agrega un usuario a sync
include_once '../../system/admon/Admin.php';
	$admin = new Admin; 
	$admin->AddClienteSync($_REQUEST["hash"],$_REQUEST["td"]);
} 


if($_REQUEST["op"]=="201"){ // elimina un usuario a sync
include_once '../../system/admon/Admin.php';
	$admin = new Admin; 
	$admin->DelClienteSync($_REQUEST["hash"],$_REQUEST["td"]);
} 


if($_REQUEST["op"]=="202"){ // elimina un usuario a sync
include_once '../../system/admon/Admin.php';
	$admin = new Admin; 
	$admin->DelHash($_REQUEST["hash"]);
} 


if($_REQUEST["op"]=="203"){ // agregar neuevo hash
include_once '../../system/admon/Admin.php';
	$admin = new Admin; 
	$admin->NewHash($_POST["hash"]);
} 














/////////
$db->close();
?>