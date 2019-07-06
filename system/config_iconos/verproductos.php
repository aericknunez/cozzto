<a href="?modal=addproducto" class="btn btn-primary">Agregar Producto</a>
<a href="?modal=reordenar&popup=0" class="btn btn-secondary">Reordenar Iconos</a>
<a id="crear-iconos" op="92" class="btn btn-success">Crear Iconos</a>
<div id="ventana"></div>
<div class="row text-center portfolio"> 
   <ul class="gallery">

<?php 
$a = $db->query("Select * from images where popup='0' and td = ".$_SESSION["td"]." order by img_order asc");
    foreach ($a as $b) {
		$img=$b['img_name'];
		$cod=$b["cod"];
		$pop=$b["popup"];

    	if($cod <= 9900)
{
if ($r = $db->select("nombre,cat", "precios", "where cod='$cod' and td = ".$_SESSION["td"]."")) { 
    $nombres=$r["nombre"]; $cat=$r["cat"];
    }

echo "<li><a href='?modal=modproducto&cod=$cod&name=$nombres&img=$img&cat=$cat&pop=$cod'><em>$nombres</em><img src='$img' alt='image' class='img-fluid img-responsive wow fadeIn' /></a></li>";


}
else
{
if ($r = $db->select("categoria", "categorias", "where cod='$cod' and td = ".$_SESSION["td"]."")) { 
    $nombres=$r["categoria"]; 
    }

echo "<li><a href='?modal=modprocate&cod=".$cod."&name=" . $nombres . "&img=". $img ."'><em>$nombres</em><img src='$img' alt='image' class='img-fluid img-responsive wow fadeIn' /></a></li>";
}

    }
    $a->close();

 ?>

  <br>
   </ul> 
</div>
