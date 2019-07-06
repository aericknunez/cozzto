<?php 
defined('BASEPATH') OR exit('No direct script access allowed');
include_once 'application/common/Mysqli.php';
$db = new dbConn();

include_once 'application/common/Fechas.php';

include_once 'system/admon/Admin.php';
$admin = new Admin;

?>
        <div class="card">

            <!--Card content-->
            <div class="card-body">

                <canvas id="myChart"></canvas>

            </div>

        </div>


