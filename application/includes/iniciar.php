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


        $configuracion = new Config;
        $configuracion->CrearVariables(); // creo el resto de variables del sistema


        header("location: ../../");
    }

UserInicio($user);

}
?>