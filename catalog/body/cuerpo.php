<!-- <div class="container"> -->
<div class="row">
		
	<div class="col-xs-8 col-sm-9 col-md-9">
	<?php 
	include_once 'application/src/redirect.php';
	?>
	</div>

<!-- d-none d-md-block || para desaparecer en pantalla pequena -->
	<div id="lateral" class="col-xs-4 col-sm-3 col-md-3">
	<?php 
		if(Helpers::IsAdmin() == TRUE) {
			include_once 'system/admon/lateral.php';
		} else {
			include_once 'system/ventas/lateral.php';	
		}	
	 ?>
	</div>

</div>
<!-- </div> -->