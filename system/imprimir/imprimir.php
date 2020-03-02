<?php
include_once '../../application/common/Helpers.php'; // [Para todo]
include_once '../../application/includes/variables_db.php';
include_once '../../application/common/Mysqli.php';
include_once '../../application/includes/DataLogin.php';
$db = new dbConn();
$seslog = new Login();
$seslog->sec_session_start();


if ($seslog->login_check() == TRUE) {

include_once '../../application/common/Fechas.php';
include_once '../../application/common/Alerts.php';
include_once '../../application/common/Dinero.php';

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta http-equiv="x-ua-compatible" content="ie=edge">
    <title>Sistema de Control</title>


   <!--  <link rel="stylesheet" href="assets/css/font-awesome.css"> -->
    <link rel="stylesheet" href="../../assets/css/font-awesome-582.css">
    <link href="../../assets/css/bootstrap.min.css" rel="stylesheet">
    <link href="../../assets/css/mdb.min.css" rel="stylesheet">


  <style>
    /* cuando vayamos a imprimir ... */
    @media print{
      /* indicamos el salto de pagina */
      .saltoDePagina{
        display:block;
        page-break-before:always;
      }
    }
  </style>

  
</head>

<body class="hidden-sn navy-blue-skin">
    
<!-- preloader -->

<div id="mdb-preloader" class="flex-center">
    <div class="preloader-wrapper big active crazy">
        <div class="spinner-layer spinner-blue-only">
          <div class="circle-clipper left">
            <div class="circle"></div>
          </div>
          <div class="gap-patch">
            <div class="circle"></div>
          </div>
          <div class="circle-clipper right">
            <div class="circle"></div>
          </div>
        </div>
      </div>
</div>

<!-- preloader -->


<main>

<div class="container-fluid">

<div class="d-flex justify-content-between"><a class="btn btn-success" onclick="printDiv('areaImprimir')"><i class="fa fa-print mr-1"></i> IMPRIMIR</a>

<a href="<?= $dir ?>" class="btn btn-danger">Regresar</a> </div>

<div id="areaImprimir">


<?php  // Inicia area imprimir
include_once 'opciones.php';
?>

</div>

<a class="btn btn-success" onclick="printDiv('areaImprimir')"><i class="fa fa-print mr-1"></i> IMPRIMIR</a>

<a href="<?= $dir ?>" class="btn btn-danger">Regresar</a>
</div>
</main>


    <script type="text/javascript" src="../../assets/js/jquery-3.4.1.min.js"></script>

    <script type="text/javascript" src="../../assets/js/popper.min.js"></script>

    <script type="text/javascript" src="../../assets/js/bootstrap.min.js"></script>

    <script type="text/javascript" src="../../assets/js/mdb.min.js"></script>
    <script>
        // SideNav Initialization
        $(".button-collapse").sideNav();
        
        new WOW().init();
       </script>
    
    <!-- carga el query correcto -->
<script>
	

// preloader
    $(window).on("load", function () {
        $('#mdb-preloader').fadeOut('fast');
    });



  $("body").on("click","#regresar",function(){ // imorimir
    window.location.href="<?= $dir; ?>";
  });


function printDiv(nombreDiv) {
     var contenido= document.getElementById(nombreDiv).innerHTML;
     var contenidoOriginal= document.body.innerHTML;

     document.body.innerHTML = contenido;

     window.print();

     document.body.innerHTML = contenidoOriginal;

     window.location.href="<?= $dir; ?>";
}







</script>
 


    

</body>
</html>
<?php 
} else {
    
header("location: ../../");
}
/////////
$db->close();
?>