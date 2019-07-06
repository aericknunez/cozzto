<?
include_once '../common/Helpers.php';
include_once 'variables_db.php';
include_once 'db_connect.php';
include_once 'functions.php';
sec_session_start();
include_once '../common/Encrypt.php';
include_once '../common/Mysqli.php';
include_once '../common/Alerts.php';
include_once '../common/Fechas.php';
include_once '../../system/corte/Corte.php';
include_once '../../system/sync/Sync.php';
include_once '../../system/index/Inicio.php';
include_once '../../system/config_configuraciones/Config.php';

if($_SESSION['username'] == NULL){
header("location: logout.php");
exit();
}

if (login_check($mysqli) == true) {

$user=sha1($_SESSION['username']);

	function UserInicio($user){
        $db = new dbConn();
            if ($r = $db->select("*", "login_userdata", "WHERE user = '$user' limit 1")) { 
            $_SESSION['nombre'] = $r["nombre"];
            $_SESSION['tipo_cuenta'] = $r["tipo"];
            $_SESSION['tkn'] = $r["tkn"];
            $_SESSION['avatar'] = $r["avatar"];
            $_SESSION['user'] = $user;
            $_SESSION['td'] = $r["td"];
            $_SESSION['secret_key'] = md5($r["td"]);

            } unset($r);
// antes de seguir debo revisar si exixten datos en el sistema de este usuario
// si no hay datos, debo redirigirlo a la pantalla de config para que los llene
// de igual manera si estan incompletos y el sistema no puede continuar, debe llenarlos
            VerificaUso();
            BuscaDatosSistema();

/// continua con el login normal
        
        $configuracion = new Config;
        $configuracion->CrearVariables(); // creo el resto de variables del sistema


        // Aqui revisare si quedo la ultima mesa sin productos (se elimino los sql para meterlos)
            VerificaMesa();
        //////////////
        $inicia = new Inicio;
        $inicia->CompruebaIconos("../iconos/", NULL); // creo iconos si no exite el archivo
               
       $inicia->Caduca(); // revisa si ha caducado
       BuscaRespaldo(); // revisa sy hay respaldos imcompletos

	       if(Helpers::ServerDomain() == TRUE and $_SESSION['tipo_cuenta'] != 1){ // registro entrada en web
	       	@$inicia->RegisterInOut(1);
	       }   
       }



    function BuscaRespaldo(){
        
        $sync = new Sync;
        $corte = new Corte;        
        $fechas = new Fechas;

        $dia=5;
        for ($x = 1; $x <= $dia; $x++) {
                $dias = $fechas->DiaResta(date("d-m-Y"),$x);
             // sin no hay corte, no hay respaldo y si hay datos  
             if($sync->BuscaRespaldo($dias) == 0 and $corte->BuscaCorte($dias) == 0 and $sync->VerificarDatos($dias) == "Si"){
                header("location: ../../?respaldos&msj");
             } else {
                header("location: ../../");
             }
         }   
        

    }

    function BuscaDatosSistema(){
        $db = new dbConn();

            if ($r = $db->select("*", "config_master", "WHERE td = " . $_SESSION['td'])) { 
                if($r["cliente"] == NULL or $r["moneda"] == NULL){
                        $_SESSION['nodatainicial'] = md5($_SESSION['td']); // es para los que no llena datos 
                      header("location: ../../?modal=conf_config&inicio");
                       exit();
                }  
            } unset($r); 
    }

    function VerificaUso(){
        $db = new dbConn();

            $a = $db->query("SELECT * FROM images WHERE td = " . $_SESSION['td']);
            if($a->num_rows == 0){
               $_SESSION['sinuso'] = TRUE; 
            }
            $a->close();

    }


    function VerificaMesa(){
        $db = new dbConn();

            if ($r = $db->select("estado, mesa", "mesa", "where td = ".$_SESSION["td"]." order by id DESC LIMIT 1")) { 
                $estado=$r["estado"]; $mesa=$r["mesa"]; } unset($r); 
        
        if($estado == 1){
            include_once '../../system/ventas/Venta.php'; 
                if(Venta::VerProductosMesa($_SESSION["mesa"]) == NULL){
                  $db->delete("mesa", "WHERE estado = 1 and mesa = '$mesa' and tx = ". $_SESSION["tx"] ." and td = " . $_SESSION["td"]);
                }
        }
    }



UserInicio($user);

}
?>