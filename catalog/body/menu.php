<ul class="collapsible collapsible-accordion">

<?php if(Helpers::IsAdmin() == TRUE) { ?>
<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-user"></i> Reportes Root<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?syncstatus" class="waves-effect"> Estado Sincronizaci&oacuten</a></li>
<li><a href="?inout" class="waves-effect"> Entradas y Salidas</a></li>
<li><a href="?db_sync" class="waves-effect"> Gestionar Sync DB</a></li>
<li><a href="?actualizacionesup" class="waves-effect"> Ver Sucursales Up</a></li>
<li><a href="?ctc" class="collapsible-header waves-effect arrow-r"> Cambiar Cuenta</a></li>
<li><a href="?user" class="collapsible-header waves-effect arrow-r"><i class="fa fa-user"></i> Usuarios </a></li>


<!-- <li><a href="?propinas" class="waves-effect"> Calcular Propinas</a></li> -->
</ul>
</div>
</li>
<?php } 
else { /// aqui comienza el menu normal 

?>


<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2  or $_SESSION["tipo_cuenta"] == 5) { ?>

<li><a href="?mesashoy" class="collapsible-header waves-effect arrow-r"><i class="fa fa-connectdevelop"></i> Mesas Hoy</a></li>

<?php } ?>





<?php if($_SESSION["tipo_cuenta"] != 4) { 

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>

<li><a href="?corte" class="collapsible-header waves-effect arrow-r"><i class="fa fa-money"></i> Corte Diario</a></li>

<?php } } ?>




<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5) { ?>
<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-pie-chart"></i> Historial<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">
<li><a href="?reportediario" class="waves-effect"> Reporte Diario</a></li>
<li><a href="?diario" class="waves-effect"> Historial Diario</a></li>
<li><a href="?mensual" class="waves-effect"> Historial Mensual</a></li>
<li><a href="?cortes" class="waves-effect"> Historial de Cortes</a></li>
<li><a href="?gastodiario" class="waves-effect"> Gastos Diario</a></li>
<li><a href="?gastomensual" class="waves-effect"> Gastos Mensual</a></li>
<li><a href="?gsemanal" class="waves-effect"> Grafico Semanal</a></li>
<?php if($_SESSION["tipo_cuenta"] == 1) { ?>
<li><a href="?mesasfecha" class="waves-effect"> Mesas Fecha</a></li>
<?php } ?>
<!-- <li><a href="?propinas" class="waves-effect"> Calcular Propinas</a></li> -->
</ul>
</div>
</li>
<?php } ?>






<?php if($_SESSION["tipo_cuenta"] != 4) { 

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>

<li><a href="?gastos" class="collapsible-header waves-effect arrow-r"><i class="fa fa-percent"></i> Gastos y Compras</a></li>

<?php } } ?>




<?php if($_SESSION["tipo_cuenta"] != 4) { 

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-exchange"></i> Facturas<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">
<li><a href="?rtn" class="waves-effect"> Agregar <?php echo $_SESSION['config_nombre_documento']; ?></a></li>
<li><a href="#" class="waves-effect"> Agregar Exonerado</a></li>
<li><a href="?facturasopciones" class="waves-effect"> Opciones</a></li>
<?php if(($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 5) and $_SESSION['config_pais'] == 2) { // para agregar un cai solo en honduras?>
<li><a href="?cai" class="waves-effect"> Nuevo CAI</a></li>
<?php } ?>
<li><a href="?rango" class="waves-effect"> Imprimir Facturas</a></li>

<?php if($_SESSION["tx"] == 1 and ($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 5)){
echo '<li><a href="?contadora" class="waves-effect"> Imprimir Reporte</a></li>';
echo '<li><a href="?eliminar_facturas" class="waves-effect"> Eliminar Facturas</a></li>';	
} ?>
</ul>
</div>
</li>

<?php } } ?>







<?php if($_SESSION["tipo_cuenta"] != 4) { 

if(Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) {
?>
<li><a href="?respaldos" class="collapsible-header waves-effect arrow-r"><i class="fa fa-download"></i> Respaldos </a></li>
<?php } } ?>







<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 5) { ?>
<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-file-text"></i> Productos<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">

<li><a href="?inventario" class="waves-effect">Inventario</a></li>

<?php 
if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
 ?>
<li><a href="?addpro" class="waves-effect">Nuevo Producto</a></li>
<li><a href="?averias" class="waves-effect">Agregar Averias</a></li>
<li><a href="?producto&x=3" class="waves-effect">Gestionar Producto</a></li>
<?php } ?>
</ul>
</div>
</li>
<?php } ?>







<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 5) { 
 
if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
 ?>

<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-cogs"></i> Configuraciones<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">
<li><a href="?iconos" class="waves-effect">Iconos</a></li>
<li><a href="?precios" class="waves-effect">Precios</a></li>
<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5 or $_SESSION["tipo_cuenta"] == 2) { ?>                        
<li><a href="?configuraciones" class="waves-effect">Configuraciones</a></li>
<?php } ?>
<li><a href="?venta_especial" class="waves-effect">Venta Especial</a></li>
<?php if($_SESSION["tipo_cuenta"] == 1) { ?>
<li><a href="?root" class="waves-effect">Configuracion Root</a></li>
<li><a href="?codigos" class="waves-effect">C&oacutedigos de validaci&oacuten</a></li>
<?php } 
if(Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) {
 ?>
<li><a href="?update" class="waves-effect">Actualizar Sistema</a></li>
<?php } ?>
</ul>
</div>
</li>
<?php } } ?>







<li><a href="?user" class="collapsible-header waves-effect arrow-r"><i class="fa fa-user"></i> Usuarios </a></li>






<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 3 or $_SESSION["tipo_cuenta"] == 5) { ?>
<li><a class="collapsible-header waves-effect arrow-r"><i class="fa fa-superpowers"></i> Opciones<i class="fa fa-angle-down rotate-icon"></i></a>
<div class="collapsible-body">
<ul class="list-unstyled">
 
<?php if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 5) { 
?>

<li><a href="?ctc" class="collapsible-header waves-effect arrow-r"><i class="fa fa-user"></i> Cambiar Cuenta</a></li>

<?php } 

if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {

if($_SESSION['root_tipo_sistema'] != 1){ 
 ?>
<li><a id="cambiar-pantalla-inicio" op="26" class="collapsible-header waves-effect arrow-r"><i class="fa fa-television"></i> Cambiar Inicio </a></li>
<?php }

if($_SESSION['config_cambio_tx'] != NULL){ ?>
<li><a id="cambiar-pantalla-inicio" op="27" class="collapsible-header waves-effect arrow-r"><i class="fa fa-refresh"></i> Cambiar Opci&oacuten </a></li>
<?php } ?>
<?php 
if($_SESSION["tipo_cuenta"] == 1 or $_SESSION["tipo_cuenta"] == 2 or $_SESSION["tipo_cuenta"] == 5){

if($_SESSION["muestra_vender"] == NULL) $nf="Mostrar Facturar";
else $nf="Mostrar Panel Inicio";
echo '<li><a id="cambiar-pantalla-inicio" op="27x" class="collapsible-header waves-effect arrow-r"><i class="fa fa-refresh"></i> '.$nf.' </a></li>';

} }
?>
</ul>
</div>
</li>
<?php } ?>






<?php 
if((Helpers::ServerDomain() == FALSE and $_SESSION["root_plataforma"] == 0) or (Helpers::ServerDomain() == TRUE and $_SESSION["root_plataforma"] == 1)) {
 ?>

<li><a href="?tv" class="collapsible-header waves-effect arrow-r"><i class="fa fa-tv"></i> Ver Pantalla </a></li>

<?php }

} // llave del admin ?>


<li><a href="application/includes/logout.php" class="collapsible-header waves-effect arrow-r"><i class="fa fa-power-off"></i> Salir </a></li>


</ul>
</li>