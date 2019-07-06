<?php
defined('BASEPATH') OR exit('No direct script access allowed');

if($_SESSION["caduca"] != 0) include_once 'system/index/noacceso.php';

elseif(isset($_GET["modal"])) include_once 'system/modal/modal.php';

elseif(isset($_GET["user"])) include_once 'system/user/user.php';

elseif(isset($_GET["upimages"])) include_once 'system/upimages/upimages.php';

elseif(isset($_GET["iconos"])) include_once 'system/config_iconos/iconos.php';

elseif(isset($_GET["precios"])) include_once 'system/config_precios/precios.php';

elseif(isset($_GET["configuraciones"])) include_once 'system/config_configuraciones/configuraciones.php';

elseif(isset($_GET["venta_especial"])) include_once 'system/config_especial/venta_especial.php';

elseif(isset($_GET["root"]) and $_SESSION['tipo_cuenta'] == "1") include_once 'system/config_configuraciones/root.php';

elseif(isset($_GET["gastos"])) include_once 'system/gastos/gastos.php';

elseif(isset($_GET["producto"])) include_once 'system/productos/productos.php';

elseif(isset($_GET["inventario"])) include_once 'system/productos/inventario.php';

elseif(isset($_GET["averias"])) include_once 'system/productos/averias.php';

elseif(isset($_GET["addpro"])) include_once 'system/productos/agregar.php';

elseif(isset($_GET["view"])) include_once 'system/mesas/view.php';

elseif(isset($_GET["corte"])) include_once 'system/corte/cortes.php';

elseif(isset($_GET["diario"])) include_once 'system/historial/diario.php';

elseif(isset($_GET["mensual"])) include_once 'system/historial/mensual.php';

elseif(isset($_GET["gsemanal"])) include_once 'system/historial/Gsemanal.php';

elseif(isset($_GET["gastodiario"])) include_once 'system/historial/gasto_diario.php';

elseif(isset($_GET["gastomensual"])) include_once 'system/historial/gasto_mensual.php';

elseif(isset($_GET["inout"])) include_once 'system/historial/inout.php';

elseif(isset($_GET["cortes"])) include_once 'system/historial/cortes.php';

elseif(isset($_GET["mesasfecha"])) include_once 'system/historial/mesasfecha.php';

elseif(isset($_GET["mesashoy"])) include_once 'system/mesashoy/mesashoy.php';

elseif(isset($_GET["search"])) include_once 'system/search/search.php';

elseif(isset($_GET["tv"])) include_once 'system/tv/tv.php';

elseif(isset($_GET["respaldos"])) include_once 'system/sync/respaldos.php';

elseif(isset($_GET["noacceso"])) include_once 'system/index/noacceso.php';

elseif(isset($_GET["codigos"])) include_once 'system/index/codigos.php';

elseif(isset($_GET["rtn"])) include_once 'system/facturar/rtn.php';

elseif(isset($_GET["cai"])) include_once 'system/facturar/cai.php';

elseif(isset($_GET["eliminar_facturas"])) include_once 'system/facturar/eliminar_facturas.php';

elseif(isset($_GET["facturasopciones"])) include_once 'system/facturar/opciones.php';

elseif(isset($_GET["reportediario"])) include_once 'system/reportes/reporteespecial.php';

elseif(isset($_GET["rango"])) include_once 'system/reportes/rango.php';

elseif(isset($_GET["contadora"])) include_once 'system/reportes/contadora.php';

elseif(isset($_GET["update"])) include_once 'system/sync/actualizaciones.php';

elseif(isset($_GET["ctc"])) include_once 'system/config_configuraciones/cambio_tipo_cuenta.php';

elseif($_SESSION['sinuso'] != NULL) include_once 'system/index/mensajes.php';


// admin
elseif(isset($_GET["syncstatus"])) include_once 'system/historial/syncstatus.php';
elseif(isset($_GET["db_sync"])) include_once 'system/admon/db_user.php';
elseif(isset($_GET["synclist"])) include_once 'system/admon/listar_sync.php';
elseif(isset($_GET["actualizacionesup"])) include_once 'system/admon/actualizaciones_activas.php';
elseif(Helpers::IsAdmin() == TRUE) include_once 'system/admon/inicio.php';

else{
include_once 'system/index/index.php';
}
	
?>