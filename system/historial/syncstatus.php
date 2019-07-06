<?php 
defined('BASEPATH') OR exit('No direct script access allowed');

include_once 'application/common/Alerts.php';
include_once 'application/common/Mysqli.php';
include_once 'system/historial/Historial.php';
$db = new dbConn();

	echo '<div id="SyncMonitor">';	
	$historial = new Historial;
	$historial->SyncStatus("sync/db/");
	echo '</div>';

 ?>
