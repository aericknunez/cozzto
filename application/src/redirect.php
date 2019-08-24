<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($_SESSION["caduca"] != 0) include_once 'system/index/noacceso.php';

elseif(isset($_GET["modal"])) include_once 'system/modal/modal.php';

elseif(isset($_GET["user"])) include_once 'system/user/user.php';

elseif(isset($_GET["configuraciones"])) include_once 'system/config_configuraciones/configuraciones.php';

elseif(isset($_GET["root"])) include_once 'system/config_configuraciones/root.php';
elseif(isset($_GET["tablas"])) include_once 'system/config_configuraciones/tablas.php';

// producto
elseif(isset($_GET["proadd"])) include_once 'system/producto/proadd.php'; // agregar
elseif(isset($_GET["proopciones"])) include_once 'system/producto/proopciones.php'; //opciones
elseif(isset($_GET["productos"])) include_once 'system/producto/producto.php'; //todos los productos
elseif(isset($_GET["proup"])) include_once 'system/producto/proup.php'; // actualizar
elseif(isset($_GET["proagregar"])) include_once 'system/producto/proagregar.php'; // agregar producto
elseif(isset($_GET["proaverias"])) include_once 'system/producto/proaverias.php'; // agregar averias

// proveedores
elseif(isset($_GET["proveedoradd"])) include_once 'system/proveedor/proveedores.php'; // agregar proveedores
elseif(isset($_GET["proveedorver"])) include_once 'system/proveedor/proveedorver.php'; // proveedores


// clientes
elseif(isset($_GET["clienteadd"])) include_once 'system/cliente/clientes.php'; // agregar cliente
elseif(isset($_GET["clientever"])) include_once 'system/cliente/clientever.php'; // ver clientes

// creditos
elseif(isset($_GET["creditos"])) include_once 'system/credito/creditosver.php'; // ver todos los creditos


// Gastos y compras
elseif(isset($_GET["gastos"])) include_once 'system/gastos/gastos.php'; 
elseif(isset($_GET["entradas"])) include_once 'system/gastos/entradas.php'; 






else{
include_once 'system/index/index.php';
}
	
?>