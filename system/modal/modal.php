<style>
    body { 
        background-color: black; /* La página de fondo será negra */
        color: 000; 
    	}
</style>
<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($_REQUEST["modal"]=="registrar") include_once 'system/modal/modal/registrar.php';

if($_REQUEST["modal"]=="register_success") include_once 'system/modal/modal/register_success.php';

if($_REQUEST["modal"]=="avatar") include_once 'system/modal/modal/avatar.php';

if($_REQUEST["modal"]=="conf_config") include_once 'system/modal/modal/conf_config.php';

if($_REQUEST["modal"]=="conf_root") include_once 'system/modal/modal/conf_root.php';

if($_REQUEST["modal"]=="img_negocio") include_once 'system/modal/modal/imagen_negocio.php';

if($_REQUEST["modal"]=="editproveedor") include_once 'system/modal/modal/editar-proveedor.php';

if($_REQUEST["modal"]=="editcliente") include_once 'system/modal/modal/editar-cliente.php';

// facturar
if($_REQUEST["modal"]=="facturar") include_once 'system/modal/modal/facturar.php';


// producto
if($_REQUEST["modal"]=="proadd") include_once 'system/modal/modal/proadd.php';



// venta
if($_REQUEST["modal"]=="cantidad") include_once 'system/modal/modal/cantidad.php';

if($_REQUEST["modal"]=="descuento") include_once 'system/modal/modal/descuento.php';

if($_REQUEST["modal"]=="credito") include_once 'system/modal/modal/credito.php';

if($_REQUEST["modal"]=="dfactura") include_once 'system/modal/modal/dfactura.php';

if($_REQUEST["modal"]=="oventas") include_once 'system/modal/modal/oventas.php';
