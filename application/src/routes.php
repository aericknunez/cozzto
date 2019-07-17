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
	window.location.href="../includes/logout.php"
</script>';
exit();
}
//





/// usuarios

if($_REQUEST["op"]=="0"){ // redirecciona despues de registrar a llenar datos
echo '<script>
    window.location.href="../../?modal=register_success&user=' . $_REQUEST["user"] . '";
</script>';
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
	Helpers::ActivaActualizar();
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
	Helpers::ActivaActualizar();
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



/////////////////////// proveedor

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

if($_REQUEST["op"]=="64"){ // agregar proveedor
include_once '../../system/cliente/Cliente.php';
	$cliente = new Clientes;
	$cliente->AddCliente($_POST);
}

if($_REQUEST["op"]=="65"){ // elimina proveedor
include_once '../../system/cliente/Cliente.php';
	$cliente = new Clientes;
	$cliente->DelCliente($_REQUEST["hash"]);
}

if($_REQUEST["op"]=="66"){ // elimina proveedor desde liasta completa
include_once '../../system/cliente/Cliente.php';
	$cliente = new Clientes;
	$cliente->DelClientex($_REQUEST["hash"]);
}

if($_REQUEST["op"]=="67"){ // actualizar proveedor
include_once '../../system/cliente/Cliente.php';
	$cliente = new Clientes;
	$cliente->UpCliente($_POST);
}














/////////
$db->close();
?>