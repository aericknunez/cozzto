<?php
include_once '../common/Helpers.php'; // [Para todo]
include_once '../includes/variables_db.php';
include_once '../common/Mysqli.php';
$db = new dbConn();
include_once '../includes/DataLogin.php';
$seslog = new Login();
$seslog->sec_session_start();





include_once '../common/Alerts.php';
$alert = new Alerts;
$helps = new Helpers;
include_once '../common/Fechas.php';
include_once '../common/Encrypt.php';


// filtros para cuando no hay session abierta
if ($seslog->login_check() != TRUE) {
echo '<script>
	window.location.href="application/includes/logout.php"
</script>';
} 

if($_SESSION["user"] == NULL and $_SESSION["td"] == NULL){
echo '<script>
	window.location.href="application/includes/logout.php"
</script>';
exit();
}
//





/// usuarios

if($_REQUEST["op"]=="0"){ // redirecciona despues de registrar a llenar datos
	include_once '../includes/DataLogin.php';
	$seslog->Register($_POST);

}


if($_REQUEST["op"]=="1"){ // cambia el password
include_once '../../system/user/Usuarios.php';
$usuarios = new Usuarios;
$passw1 = filter_input(INPUT_POST, 'pass1', FILTER_SANITIZE_STRING);
$passw2 = filter_input(INPUT_POST, 'pass2', FILTER_SANITIZE_STRING);
$usuarios->CompararPass($passw1, $passw2); 
}


if($_REQUEST["op"]=="2"){ // terminar usuario
	if($_POST["nombre"] != NULL && $_POST["tipo"] != NULL){
	include_once '../../system/user/Usuarios.php';
	$usuarios = new Usuarios;
	$usuarios->TerminarUsuario(Helpers::Mayusculas($_POST["nombre"]),$_POST["tipo"],sha1($_POST["user"]));	
	} else {
	Alerts::Alerta("error","Error!","Faltan Datos!");	
	}
}



if($_REQUEST["op"]=="3"){ // terminar actualizar
	if($_POST["nombre"] != NULL && $_POST["tipo"] != NULL){
	include_once '../../system/user/Usuarios.php';
	$usuarios = new Usuarios;
	$usuarios->ActualizarUsuario(Helpers::Mayusculas($_POST["nombre"]),$_POST["tipo"],sha1($_POST["user"]));	
	} else {
	Alerts::Alerta("error","Error!","Faltan Datos!");	
	}
}


if($_REQUEST["op"]=="4"){ // cambiar avatar
include_once '../../system/user/Usuarios.php';
	$usuarios = new Usuarios;
	$usuarios->CambiarAvatar($_REQUEST["iden"],$_REQUEST["user"]);
}



if($_REQUEST["op"]=="5"){ // pregunta si elimina el usuario
include_once '../../system/user/Usuarios.php';
$usuarios = new Usuarios;
$alert->EliminarUsuario($_REQUEST["iden"], $_REQUEST["username"]);

}


if($_REQUEST["op"]=="6"){ // elimina el usuario
include_once '../../system/user/Usuarios.php';
$usuarios = new Usuarios;
$usuarios->EliminarUsuario($_REQUEST["iden"], $_REQUEST["username"]);
}



// confiuraciones
if($_REQUEST["op"]=="10"){ // agregar datos de configuracion
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
}

if($_REQUEST["op"]=="11"){  // agregar datos de root
include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;

	include_once '../common/Encrypt.php';
	$configuracion->Root(Encrypt::Encrypt($_POST["expira"],$_SESSION['secret_key']),
		Encrypt::Encrypt(Fechas::Format($_POST["expira"]),$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["ftp_servidor"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["ftp_path"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["ftp_ruta"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["ftp_user"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["ftp_password"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["tipo_sistema"],$_SESSION['secret_key']),
						Encrypt::Encrypt($_POST["plataforma"],$_SESSION['secret_key']));
}


if($_REQUEST["op"]=="12"){ // Subir imagen negocio
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


///////////// modifica las tablas del sync
if($_REQUEST["op"]=="13"){
	include_once '../../system/config_configuraciones/Config.php';
	$configuracion = new Config;
	$configuracion->ModTabla($_POST);
}



//////////// cambios de funcion
if($_REQUEST["op"]=="15"){ /// cambia de rapido a lento

	if($_SESSION["tipo_inicio"] == 1){
		$_SESSION["tipo_inicio"] = 2;
	} else {
		$_SESSION["tipo_inicio"] = 1;
	}
}




/// productos
if($_REQUEST["op"]=="20"){ // agrega primeros datos del producto
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->AddProducto($_POST);
}



if($_REQUEST["op"]=="21"){ // agrega mas productos al inventario
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->IngresarProducto($_POST);
}



if($_REQUEST["op"]=="22"){ // formulario add categoria
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->AddCategoria($_POST);

}

if($_REQUEST["op"]=="23"){ // borrar categoria
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->DelCategoria($_REQUEST["hash"]);
}



if($_REQUEST["op"]=="24"){ // formulario Unidad de medida
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->AddUnidad($_POST);

}

if($_REQUEST["op"]=="25"){ // borrar unidad de medida
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->DelUnidad($_REQUEST["hash"]);
}


if($_REQUEST["op"]=="26"){ // formulario caracteristicas
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->AddCaracteristica($_POST);

}

if($_REQUEST["op"]=="27"){ // borrar caracteristicas
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->DelCaracteristica($_REQUEST["hash"]);
}




if($_REQUEST["op"]=="28"){ // formulario ubicacion
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->AddUbicacion($_POST);

}

if($_REQUEST["op"]=="29"){ // borrar ubicacion
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->DelUbicacion($_REQUEST["hash"]);
}



if($_REQUEST["op"]=="30"){ // agrega los precios de cada producto
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->AddPrecios($_POST);
}

if($_REQUEST["op"]=="31"){ // elimina los precios de cada producto
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->DelPrecios($_REQUEST["hash"], $_REQUEST["producto"]);
}


if($_REQUEST["op"]=="32"){ // busqueda de productos para compuestos
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->CompuestoBusqueda($_POST);
}

if($_REQUEST["op"]=="33"){ // agrega los compuesto
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->AddCompuesto($_POST);
}

if($_REQUEST["op"]=="34"){ // elimina compuesto del producto
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->DelCompuesto($_REQUEST["hash"], $_REQUEST["producto"]);
}


if($_REQUEST["op"]=="35"){ // agrega los dependiente
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->AddDependiente($_POST);
}

if($_REQUEST["op"]=="36"){ // elimina dependiente del producto
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->DelDependiente($_REQUEST["hash"], $_REQUEST["producto"]);
}

//////////etiquetas
if($_REQUEST["op"]=="37"){ // busqueda de productos para compuestos
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->TagsBusqueda($_POST["keyword"]);
}


if($_REQUEST["op"]=="38"){ // agrega nueva tag
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->AddTag($_POST);
}

if($_REQUEST["op"]=="39"){ // elimina tag
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->DelTag($_REQUEST["hash"], $_REQUEST["producto"]);
}

if($_REQUEST["op"]=="40"){ // asigna ubicacion
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->AddUbicacionAsig($_POST);
}

if($_REQUEST["op"]=="41"){ // elimina ubicacion
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->DelUbicacionAsig($_REQUEST["hash"], $_REQUEST["producto"]);
}

if($_REQUEST["op"]=="42"){ // Para select de ubicacion
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->SelectUbicacion();
}



if($_REQUEST["op"]=="43"){ // asigna caracteristica
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->AddCaracteristicaAsig($_POST);
}

if($_REQUEST["op"]=="44"){ // elimina caracteristica
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->DelCaracteristicaAsig($_REQUEST["hash"], $_REQUEST["producto"]);
}

if($_REQUEST["op"]=="45"){ // Para select de caracteristica
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->SelectCaracteristica();
}

/// Actualizar productos
if($_REQUEST["op"]=="46"){ // actualiza el producto
include_once '../../system/producto/ProUpdate.php';
	$productos = new ProUpdate;
	$productos->UpProducto($_POST);
}

/// redireccionar a la url correcta para evitar el logout
if($_REQUEST["op"]=="47"){ 
include_once '../../system/producto/ProUpdate.php';
	$productos = new ProUpdate;
	$productos->UrlNext($_REQUEST["key"], $_REQUEST["step"],$_REQUEST["cad"],$_REQUEST["com"],$_REQUEST["dep"]);
}


/// agrega productos
if($_REQUEST["op"]=="48"){ 
include_once '../../system/producto/ProUpdate.php';
	$productos = new ProUpdate;
	$productos->ProAgrega($_POST);
}

if($_REQUEST["op"]=="49"){ // elimina producto
include_once '../../system/producto/ProUpdate.php';
	$productos = new ProUpdate;
	$productos->DelProAgrega($_REQUEST["hash"], $_REQUEST["producto"]);
}

// busqueda agregar pro
if($_REQUEST["op"]=="50"){ // busqueda de productos para compuestos
include_once '../../system/producto/ProUpdate.php';
	$productos = new ProUpdate;
	$productos->AgregaBusqueda($_POST);
}


/// agrega Averias
if($_REQUEST["op"]=="51"){ 
include_once '../../system/producto/ProUpdate.php';
	$productos = new ProUpdate;
	$productos->AddAveria($_POST);
}

if($_REQUEST["op"]=="52"){ // elimina averias
include_once '../../system/producto/ProUpdate.php';
	$productos = new ProUpdate;
	$productos->DelAveria($_REQUEST["hash"], $_REQUEST["producto"]);
}

if($_REQUEST["op"]=="53"){ // busqueda de productos para compuestos
include_once '../../system/producto/ProUpdate.php';
	$productos = new ProUpdate;
	$productos->AveriaBusqueda($_POST);
}




if($_REQUEST["op"]=="54"){ // ver todos los producto
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->VerTodosProductos($_POST["iden"], $_POST["orden"], $_POST["dir"]);
}

if($_REQUEST["op"]=="55"){ // detalles del producto
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->DetallesProducto($_POST);
}


if($_REQUEST["op"]=="56"){ // Bajas Existancias
include_once '../../system/producto/Productos.php';
	$productos = new Productos;
	$productos->BajasExistencias($_POST["iden"], $_POST["orden"], $_POST["dir"]);
}




/////////////////////// proveedor
if($_REQUEST["op"]=="59"){ // ver detalles del proveedor modal
include_once '../../system/proveedor/Proveedor.php';
	$proveedor = new Proveedores;
	$proveedor->VistaProveedor($_POST);
}

if($_REQUEST["op"]=="60"){ // agregar proveedor
include_once '../../system/proveedor/Proveedor.php';
	$proveedor = new Proveedores;
	$proveedor->AddProveedor($_POST);
}

if($_REQUEST["op"]=="61"){ // elimina proveedor
include_once '../../system/proveedor/Proveedor.php';
	$proveedor = new Proveedores;
	$proveedor->DelProveedor($_REQUEST["hash"]);
}

if($_REQUEST["op"]=="62"){ // elimina proveedor desde liasta completa
include_once '../../system/proveedor/Proveedor.php';
	$proveedor = new Proveedores;
	$proveedor->DelProveedorx($_REQUEST["hash"]);
}

if($_REQUEST["op"]=="63"){ // actualizar proveedor
include_once '../../system/proveedor/Proveedor.php';
	$proveedor = new Proveedores;
	$proveedor->UpProveedor($_POST);
}





/////////////////////// cliente

if($_REQUEST["op"]=="64"){ // agregar cliente
include_once '../../system/cliente/Cliente.php';
	$cliente = new Clientes;
	$cliente->AddCliente($_POST);
}

if($_REQUEST["op"]=="65"){ // elimina cliente
include_once '../../system/cliente/Cliente.php';
	$cliente = new Clientes;
	$cliente->DelCliente($_REQUEST["hash"]);
}

if($_REQUEST["op"]=="66"){ // elimina cliente desde liasta completa
include_once '../../system/cliente/Cliente.php';
	$cliente = new Clientes;
	$cliente->DelClientex($_REQUEST["hash"]);
}

if($_REQUEST["op"]=="67"){ // actualizar cliente
include_once '../../system/cliente/Cliente.php';
	$cliente = new Clientes;
	$cliente->UpCliente($_POST);
}


if($_REQUEST["op"]=="68"){ // ver cliente
include_once '../../system/cliente/Cliente.php';
	$cliente = new Clientes;
	$cliente->VistaCliente($_POST);
}

/// ver Lateral



if($_REQUEST["op"]=="70"){ // busca producto
include_once '../../system/ventas/Laterales.php';
	$lateral = new Laterales;
	$lateral->VerLateral($_SESSION["orden"]);
}

// ventas////////////////////

if($_REQUEST["op"]=="75"){ // busca producto
include_once '../../system/ventas/Productos.php';
	$productos = new Productos;
	$productos->Busqueda($_POST);
}

if($_REQUEST["op"]=="76"){ // temp prodcutos (el producto encontrado despues de la busqueda)
include_once '../../system/ventas/Productos.php';
	$productos = new Productos;
	$productos->TempProducto($_REQUEST);
}



if($_REQUEST["op"]=="80"){ // recibe el formulario para agregar los productos (va a ventas)
include_once '../../system/ventas/VentasL.php';
	$venta = new Ventas();
	$venta->AddVenta($_POST);
}

if($_REQUEST["op"]=="81"){ // borrar venta  de la venta lenta
include_once '../../system/ventas/VentasL.php';
	$venta = new Ventas();
	$venta->DelVenta($_REQUEST["hash"], NULL);
}


if($_REQUEST["op"]=="82"){ // guardar la venta
include_once '../../system/ventas/VentasL.php';
	$venta = new Ventas();
	$venta->GuardarOrden();
}

if($_REQUEST["op"]=="83"){ // select orden
include_once '../../system/ventas/VentasL.php';
	$venta = new Ventas();
	$venta->SelectOrden($_POST["orden"]);
}

if($_REQUEST["op"]=="84"){ // ver producto
include_once '../../system/ventas/VentasL.php';
	$venta = new Ventas();
	$venta->VerProducto();
}



if($_REQUEST["op"]=="85"){ // facturar determinar si es rapido o lento
	if($_SESSION["tipo_inicio"] == 1){
	include_once '../../system/ventas/VentasR.php';
	} else {
	include_once '../../system/ventas/VentasL.php';
	}
	   	if(isset($_SESSION["cliente_c"])){ // agregar el credito
	   		include_once '../../system/ventas/Opciones.php';	
	   	}

	$venta = new Ventas();
	$venta->Facturar($_POST);

}


if($_REQUEST["op"]=="86"){ // cancelar toda la orden
	if($_SESSION["tipo_inicio"] == 1){
	include_once '../../system/ventas/VentasR.php';
	} else {
	include_once '../../system/ventas/VentasL.php';
	}
	$venta = new Ventas();
	$venta->Cancelar();

}


////////////////// para venta rapida

if($_REQUEST["op"]=="90"){ // recibe el formulario para agregar los productos (va a ventas)
include_once '../../system/ventas/VentasR.php';
	$venta = new Ventas();
	$venta->SumaVenta($_POST);
}

// mod cantidad restar
if($_REQUEST["op"]=="91"){ // recibe el formulario para agregar los productos (va a ventas)
include_once '../../system/ventas/VentasR.php';
	$venta = new Ventas();
	$venta->RestaVenta($_POST);
}


if($_REQUEST["op"]=="92"){ // borrar venta  de la venta rapida
include_once '../../system/ventas/VentasR.php';
	$venta = new Ventas();
	$venta->DelVenta($_REQUEST["hash"], NULL);
}

if($_REQUEST["op"]=="93"){ // ver producto
include_once '../../system/ventas/VentasR.php';
	$venta = new Ventas();
	$venta->VerProducto();
}



/// descuento
if($_REQUEST["op"]=="95"){ // aplicar descuento
	$_SESSION["descuento"] = $_POST["descuento"];
include_once '../../system/ventas/Laterales.php';
include_once '../../system/ventas/VentasR.php';
	$venta = new Ventas();
	$venta->AplicarDescuento();
}

if($_REQUEST["op"]=="96"){ // quitar descuento
	unset($_SESSION["descuento"]);
include_once '../../system/ventas/Laterales.php';
include_once '../../system/ventas/VentasR.php';
	$venta = new Ventas();
	$venta->AplicarDescuento();
}


/// credito
if($_REQUEST["op"]=="97"){ 
include_once '../../system/ventas/VentasR.php';
	$venta = new Ventas();
	$venta->ClienteBusqueda($_POST);
}

if($_REQUEST["op"]=="98"){ 
include_once '../../system/ventas/VentasR.php';
	$venta = new Ventas();
	$venta->AgregaCliente($_POST);
}


if($_REQUEST["op"]=="99"){ 
unset($_SESSION["cliente_credito"]);
unset($_SESSION["cliente_c"]);
}


/// agrega documeton a la venta
if($_REQUEST["op"]=="100"){ 
include_once '../../system/ventas/VentasR.php';
	$venta = new Ventas();
	$venta->DocumentoBusqueda($_POST);
}

if($_REQUEST["op"]=="101"){ // add
include_once '../../system/ventas/VentasR.php';
	$venta = new Ventas();
	$venta->AgregaDocumento($_POST);
}

if($_REQUEST["op"]=="102"){  // quitar documneto
unset($_SESSION["factura_cliente"]);
unset($_SESSION["factura_documento"]);
}


if($_REQUEST["op"]=="103"){ // nuevo ducumento
include_once '../../system/cliente/Cliente.php';
	$cliente = new Clientes;
	$cliente->NuevoDocumento($_POST);
}



/// CREDITOS PENDIENTES
if($_REQUEST["op"]=="104"){ 
include_once '../../system/credito/Creditos.php';
	$credito = new Creditos;
	$credito->CreditosPendientes($_POST["iden"], $_POST["orden"], $_POST["dir"]);
}

if($_REQUEST["op"]=="114"){ 
include_once '../../system/credito/Creditos.php';
	$credito = new Creditos;
	$credito->VerCredito($_POST["iden"], $_POST["orden"], $_POST["dir"]);
}

/// credito
if($_REQUEST["op"]=="105"){ // agrega abono
include_once '../../system/credito/Creditos.php';
	$credito = new Creditos;
	$credito->AddAbono($_POST);
}



// total abonos
if($_REQUEST["op"]=="106"){ 
include_once '../../system/credito/Creditos.php';
	$credito = new Creditos;
	echo Helpers::Dinero($credito->TotalAbono($_REQUEST["credito"]));
}

// restante de abonar
if($_REQUEST["op"]=="107"){ 
include_once '../../system/credito/Creditos.php';
	$credito = new Creditos;
	$abonos = $credito->TotalAbono($_REQUEST["credito"]);
	$totales = $credito->ObtenerTotal($_REQUEST["factura"], $_REQUEST["tx"]);

	echo Helpers::Dinero($totales - $abonos);
}

// borrar abono
if($_REQUEST["op"]=="108"){ 
include_once '../../system/credito/Creditos.php';
	$credito = new Creditos;
	$credito->DelAbono($_REQUEST["hash"], $_REQUEST["credito"]);
}

// Lllamar vista credito
if($_REQUEST["op"]=="109"){ 
include_once '../../system/credito/Creditos.php';
	$credito = new Creditos;
	$credito->LlamarVista($_REQUEST["credito"], $_REQUEST["factura"], $_REQUEST["tx"]);
}


///////////////gastos
if($_REQUEST["op"]=="110"){ 
include_once '../../system/gastos/Gasto.php';
	$gastos = new Gastos;
	$gastos->AddGasto($_POST);
}

if($_REQUEST["op"]=="111"){ 
include_once '../../system/gastos/Gasto.php';
	$gastos = new Gastos;
	$gastos->BorrarGasto($_POST["iden"]);

}

if($_REQUEST["op"]=="112"){  // entrada de efectivo
include_once '../../system/gastos/Gasto.php';
	$gastos = new Gastos;
	$gastos->AddEfectivo($_POST);
}


if($_REQUEST["op"]=="113"){ 
include_once '../../system/gastos/Gasto.php';
	$gastos = new Gastos;
	$gastos->BorrarEfectivo($_POST["iden"]);

}



///////////////////////// corte /////////////////

if($_REQUEST["op"]=="115"){ // corte preguntar
	if($_POST["efectivo"] ==  NULL){
		Alerts::Alerta("error","Error!","El Formulario esta vacio");
	} else {
		Alerts::RealizarCorte("ejecuta-corte","116",$_POST["efectivo"]);
	}
}

if($_REQUEST["op"]=="116"){ // ejecuta corte
include_once '../../system/corte/Corte.php';
//include_once '../../system/sync/Sync.php';
$cortes = new Corte;
if($_POST["fecha"] == NULL){ $fecha = date("d-m-Y"); 
} else {
   $fecha = $_POST["fecha"];
}
$cortes->Execute($_POST["efectivo"], $fecha);
}



if($_REQUEST["op"]=="117"){ // ver el contenido
	include_once '../../system/corte/Corte.php';
	//include_once '../../system/sync/Sync.php';
	$cortes = new Corte;
	$cortes->Contenido(date("d-m-Y"));
}


if($_REQUEST["op"]=="118"){ // cancelar corte
	include_once '../../system/corte/Corte.php';
	$cortes = new Corte;
	if($_POST["fecha"] == NULL){ $fecha = date("d-m-Y"); 
	} else {
	   $fecha = $_POST["fecha"];
	}
	$cortes->CancelarCorte($_POST["random"], $fecha);

}




//// historial ///////////////////////////////////////////////
if($_REQUEST["op"]=="125"){ // historial diario
	include_once '../../system/historial/Historial.php';
	$historial = new Historial;
	
	if($_POST["fecha_submit"] == NULL){ $fecha = date("d-m-Y"); 
	} else { $fecha = $_POST["fecha_submit"]; }
	
	$historial->HistorialDiario($fecha);
}



if($_REQUEST["op"]=="126"){ // ventas mensual
	include_once '../../system/historial/Historial.php';
	$historial = new Historial;
		$fecha=$_POST["mes"];
		@$ano=$_POST["ano"];
		$fechax="-$fecha-$ano";

	$historial->HistorialMensual($fechax);
}


// cortes
if($_REQUEST["op"]=="127"){ // historial cortes
	include_once '../../system/historial/Historial.php';
	$historial = new Historial;
	if($_POST["fecha1_submit"]){
		$inicio = $_POST["fecha1_submit"]; $fin=$_POST["fecha2_submit"];
	} else {
		$inicio = date("01-m-Y"); $fin=date("31-m-Y");
	}
	
	$historial->HistorialCortes($inicio, $fin);
}



if($_REQUEST["op"]=="128"){ // gasto diario
	include_once '../../system/historial/Historial.php';
	$historial = new Historial;
	if($_POST["fecha_submit"] == NULL){ $fecha = date("d-m-Y"); } 
	else { 		$fecha = $_POST["fecha_submit"]; }
	
	$historial->HistorialGDiario($fecha);
}



if($_REQUEST["op"]=="129"){ // gastos mensual
	include_once '../../system/historial/Historial.php';
	$historial = new Historial;
		$fecha=$_POST["mes"];
		@$ano=$_POST["ano"];
		$fechax="-$fecha-$ano";

	$historial->HistorialGMensual($fechax);
}


if($_REQUEST["op"]=="130"){ // validar el sistema
$_SESSION["caduca"] = 0;
echo '<script>
	window.location.href="?"
</script>';
}


if($_REQUEST["op"]=="131"){ // validar codigo de sistema
include_once '../common/Encrypt.php';
include_once '../../system/index/Inicio.php';
$inicio = new Inicio;
$inicio->Validar($_POST["fecha_submit"], $_POST["codigo"]);
	
}









/////////
$db->close();
?>