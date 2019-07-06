<?php
include_once 'application/common/Helpers.php'; // [Para todo]
include_once 'application/includes/variables_db.php';
include_once 'application/includes/db_connect.php';
include_once 'application/includes/functions.php';
sec_session_start();
include_once 'application/includes/register.inc.php'; // [para registrar]


if (login_check($mysqli) == true) {
    include_once 'catalog/index.php';
} else {
	
	if(isset($_REQUEST["change"])){
		if($_SESSION["inicio"] == NULL){
			$_SESSION["inicio"] = 1;
		} else {
			unset($_SESSION["inicio"]);
		}
	 header("location: ./");
	}
    //include_once 'catalog/login.php';
    	if(Helpers::ServerDomain() == FALSE){
		  		if($_SESSION["inicio"] == NULL){
					include_once 'catalog/login_user.php';
				} else {
					include_once 'catalog/login.php';
				}
		} else {
			include_once 'catalog/login.php';
		}   

}
?>