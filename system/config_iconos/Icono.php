<?php 
class Icono{
	
	public function __construct(){

	}

	public function AddProducto($nombre,$imagen,$popup,$precio,$opcion){
		$db = new dbConn();
		$cod=$this->GetCodigoProducto();
		// insertodatos en producto
			$datos = array();
		    $datos["cod"] = $cod;
		    $datos["nombre"] = $nombre;
		    $datos["categoria"] = $popup;
		    $datos["cantidad"] = 0;
		    $datos["gravado"] = "1";
		    $datos["fecha_registro"] = date('d-m-Y');
		    $datos["td"] = $_SESSION['td'];

		    $db->insert("producto", $datos);

		//inserto datos en precios
		$datos = array();
		    $datos["cod"] = $cod;
		    $datos["nombre"] = $nombre;
		    $datos["cat"] = $popup;
		    $datos["precio"] = $precio;
		    $datos["td"] = $_SESSION['td'];

		    $db->insert("precios", $datos);

		// inserto en la tabla de imagenes
		$datos = array();
		    $datos["img_name"] = $imagen;
		    $datos["img_order"] = $this->GetImagenNum();
		    $datos["popup"] =$popup;
		    $datos["cod"] = $cod;
		    $datos["edo"] = "1";
		    $datos["td"] = $_SESSION['td'];

		    $db->insert("images", $datos);

		// si el producto viene con opciones las insertamos
		if($_REQUEST["opcion"] != 0){
		$datos = array();
		    $datos["producto"] = $cod;
		    $datos["opcion"] = $opcion;
		    $datos["td"] = $_SESSION['td'];

		    $db->insert("opciones_asig", $datos);
		}


		$db->close();

		if($_SESSION["opcionesx"] != NULL){ unset($_SESSION["opcionesx"]); } // borra la variable que creo en iconosselect
	}
	


	public function AddCategoria($nombre,$imagen){
    	$db = new dbConn();
    	$cat=$this->GetCategoria();
    	$datos = array();
	    $datos["cod"] = $cat;
	    $datos["categoria"] = $nombre;
	    $datos["td"] = $_SESSION['td'];

	    $db->insert("categorias", $datos);

	// inserto en la tabla de imagenes
	$datos = array();
	    $datos["img_name"] = $imagen;
	    $datos["img_order"] =  $this->GetImagenNum();
	    $datos["popup"] = 0;
	    $datos["cod"] = $cat;
	    $datos["edo"] = "1";
	    $datos["td"] = $_SESSION['td'];

	    $db->insert("images", $datos);

	$db->close();

	if($_SESSION["opcionesx"] != NULL){ unset($_SESSION["opcionesx"]); } // borra la variable que creo en iconosselect
   }


	public function ModProducto($cod,$nombre,$popup,$imagen){
    	$db = new dbConn();

		$cambio = array();
		    $cambio["nombre"] = $nombre;
		    $cambio["categoria"] = $popup;
		    $db->update("producto", $cambio, "WHERE cod='$cod' and td = ".$_SESSION["td"]."");

		$cambio = array();
		    $cambio["nombre"] = $nombre;
		    $cambio["cat"] = $_REQUEST["popup"];
		    $db->update("precios", $cambio, "WHERE cod='$cod' and td = ".$_SESSION["td"]."");

		$cambio = array();
		    $cambio["img_name"] = $imagen;
		    $cambio["popup"] = $popup;
		    $db->update("images", $cambio, "WHERE cod='$cod' and td = ".$_SESSION["td"]."");

		$db->close();

		if($_SESSION["opcionesx"] != NULL){ unset($_SESSION["opcionesx"]); } // borra la variable que creo en iconosselect

    	}   



	public function ModCategoria($cod,$nombre,$imagen){
    	$db = new dbConn();

		$cambio = array();
		    $cambio["categoria"] = $nombre;
		    $db->update("categorias", $cambio, "WHERE cod='$cod' and td = ".$_SESSION["td"]."");

		$cambio = array();
		    $cambio["img_name"] = $imagen;
		    $db->update("images", $cambio, "WHERE cod='$cod' and td = ".$_SESSION["td"]."");

		$db->close();

		if($_SESSION["opcionesx"] != NULL){ unset($_SESSION["opcionesx"]); } // borra la variable que creo en iconosselect

    	}




	public function DelProducto($cod){
    	$db = new dbConn();

		$db->delete("producto", "WHERE cod='$cod' and td = ".$_SESSION["td"]."");
		$db->delete("precios", "WHERE cod='$cod' and td = ".$_SESSION["td"]."");
		$db->delete("images", "WHERE cod='$cod' and td = ".$_SESSION["td"]."");
		// para despues que este comida empleado
		// $db->delete("comida_empleado_ico", "WHERE cod='".$_REQUEST["cod"]."'")

		$db->close();
    	}

	public function DelCategoria($cod){
    	$db = new dbConn();
			$db->delete("popup", "WHERE cod='$cod' and td = ".$_SESSION["td"]."");
			$db->delete("images", "WHERE cod='$cod' and td = ".$_SESSION["td"]."");

			$cambio = array();
			    $cambio["popup"] = "0";
			    $db->update("images", $cambio, "WHERE popup='$cod' and td = ".$_SESSION["td"]."");

			$db->close();
    	}


   public function GetCategoria(){
   	$db = new dbConn();
   	// para obtener el ultimo codigo
	$ac = $db->query("SELECT max(cod) FROM categorias WHERE td = ".$_SESSION["td"]."");
	    foreach ($ac as $bc) {
	      $ultimocod=$bc["max(cod)"]+1;
	      if($ultimocod == 1) return 9901;
	      else return $bc["max(cod)"]+1;
	    }
	    $ac->close();
	   }

	public function GetImagenNum(){
   	$db = new dbConn();
   	// para obtener el ultimo codigo
		$a = $db->query("SELECT max(img_order) FROM images WHERE td = ".$_SESSION["td"]."");
	    foreach ($a as $b) {
	        return $b["max(img_order)"]+1;
	    }
	    $a->close();
	   
	   }


	public function GetCodigoProducto(){
   	$db = new dbConn();
   	// para obtener el ultimo codigo
		$ac = $db->query("SELECT max(cod) FROM producto WHERE td = ".$_SESSION["td"]."");
    	foreach ($ac as $bc) {
      $ultimocod=$bc["max(cod)"]+1;
      if($ultimocod == 1) return 1001;
      else return $bc["max(cod)"]+1;
    	}  $ac->close();
	   
	}

	public function GetUltimaOpcion(){
   	$db = new dbConn();
   	// para obtener numero de opcion
		$ac = $db->query("SELECT max(cod) FROM opciones WHERE td = ".$_SESSION["td"]."");
    	foreach ($ac as $bc) {
	      $ultimocod=$bc["max(cod)"]+1;
	      if($ultimocod == 1) return 1;
	      else return $bc["max(cod)"]+1;
    	}  $ac->close();
	   
	}

	
	public function GetUltimaOpcionName(){
   	$db = new dbConn();
   	// para obtener numero de opcion
		$ac = $db->query("SELECT max(cod) FROM opciones_name WHERE td = ".$_SESSION["td"]."");
	    foreach ($ac as $bc) {
	    	$opultima=$bc["max(cod)"]+1;
	    	if($opultima == 1) return 101;
	    	else return $bc["max(cod)"]+1;
	    }   $ac->close();
	   
	}


	public function AddOpcion($nombre){
   	$db = new dbConn();
	   	$datos = array();
	    $datos["nombre"] = $nombre;
	    $datos["cod"] = $this->GetUltimaOpcion();
	    $datos["td"] = $_SESSION['td'];
	    $db->insert("opciones", $datos);

	    $this->VerOpciones();
	}


	public function AddOpcionName($cod,$nombre,$imagen){
   	$db = new dbConn();
   	$codi=$this->GetUltimaOpcionName();
	   	$datos = array();
	    $datos["nombre"] = $nombre;
	    $datos["cod"] =	$codi;
	    $datos["opcion"] = $cod;
	    $datos["td"] = $_SESSION['td'];

	    $db->insert("opciones_name", $datos);

	    // inserto en la tabla de imagenes
		$datos = array();
		    $datos["img_name"] = $imagen;
		    $datos["img_order"] = $this->GetImagenNum();
		    $datos["popup"] = $cod;
		    $datos["cod"] =	$codi;
		    $datos["edo"] = "1";
		    $datos["td"] = $_SESSION['td'];

		    $db->insert("images", $datos);

		$this->VerOpcionesName($cod);

		if($_SESSION["opcionesx"] != NULL){ unset($_SESSION["opcionesx"]); } // borra la variable que creo en iconosselect
	}


	public function VerOpciones(){
   	$db = new dbConn();
	   	$a = $db->query("SELECT * FROM opciones WHERE td = ".$_SESSION["td"]."");
          echo '<div class="table-responsive-sm">
            <table class="table">
              <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Mod</th>
            <th scope="col">Eli</th>
          </tr>
        </thead>
        <tbody>'; $n=0;
    foreach ($a as $b) {
    			$n=$n+1;
      echo '<tr>
      <th scope="row">'.$n.'</th>
      <td>'.$b["nombre"].'</td>
      <td><a href="?modal=addopciones&cod='.$b["cod"].'" class="btn-floating btn-sm green"><i class="fa fa-edit"></i></a></td>
      <td><a id="delopciones" op="12" cod="'.$b["cod"].'" class="btn-floating btn-sm red"><i class="fa fa-trash"></i></a></td>
      </tr>';
    }
    echo '</tbody>
            </table>
          </div>';

    echo "El numero de registros es: ". $a->num_rows . "<br>";
    $a->close();

	}

	public function VerOpcionesName($cod){
   	$db = new dbConn();
	   	$a = $db->query("SELECT * FROM opciones_name where opcion='$cod' and td = ".$_SESSION["td"]."");
          echo '<div class="table-responsive-sm">
            <table class="table">
              <thead>
          <tr>
            <th scope="col">#</th>
            <th scope="col">Nombre</th>
            <th scope="col">Eli</th>
          </tr>
        </thead>
        <tbody>'; $n=0;
    foreach ($a as $b) {
    			$n=$n+1;
      echo '<tr>
      <th scope="row">'.$n.'</th>
      <td>'.$b["nombre"].'</td>
      <td><a id="delopciones" op="13" cod="'.$b["cod"].'" class="btn-floating btn-sm red"><i class="fa fa-trash"></i></a></td>
      </tr>';
    }
    echo '</tbody>
            </table>
          </div>';

    echo "El numero de registros es: ". $a->num_rows . "<br>";
    $a->close();

	}



	public function DelOpciones($cod){
    	$db = new dbConn();
			$db->delete("opciones", "WHERE cod='$cod' and td = ".$_SESSION["td"]."");
			$db->delete("opciones_name", "WHERE opcion='$cod' and td = ".$_SESSION["td"]."");
			$db->delete("opciones_asig", "WHERE opcion='$cod' and td = ".$_SESSION["td"]."");
			$db->close();
			$this->VerOpciones();
    	}


	public function DelOpcionesName($cod){
    	$db = new dbConn();
			$db->delete("opciones_name", "WHERE cod='$cod' and td = ".$_SESSION["td"]."");
			$db->delete("opciones_asig", "WHERE opcion='$cod' and td = ".$_SESSION["td"]."");
			$db->close();
			$this->VerOpcionesName();
    	}



///////////////////////////////////// reordenar ////////////
///
	public function GetReordenar($popup){
    	$db = new dbConn();

    	$a = $db->query("SELECT * FROM images WHERE popup = '$popup' and td = ".$_SESSION["td"]." ORDER BY img_order ASC");
	    foreach ($a as $b) {
	    
		if ($r = $db->select("nombre", "producto", "WHERE cod = ".$b["cod"]." and td = ".$_SESSION["td"]."")) { $producto = $r["nombre"];  } unset($r);
	        
	        if($producto == NULL) $producto = "Categoria";
	        echo '<li id="image_li_'.$b["id"].'"><a href="javascript:void(0);" style="float:none;"><em>'.$producto.'</em><img src="'.$b["img_name"].'" alt="image" class="img-fluid img-responsive wow fadeIn" /></a></li>';
	    
	    } $a->close();
			
    }

	public function UpdateReordenar($id_array){
    	$db = new dbConn();

    	$count = 1;
		foreach ($id_array as $id){
			
			$cambio = array();
		    $cambio["img_order"] = $count;
		    $db->update("images", $cambio, "WHERE id='$id' and td = ".$_SESSION["td"]."");

			$count ++;	
		} $a->close();
		return TRUE;

	} 
			

   	
   	public function MostrarIconos($categoria, $opciones){
   		$db = new dbConn();
    	
    	if($categoria != NULL){
    		$a = $db->query("SELECT * FROM login_imagenes WHERE categoria = $categoria");
    	} else {
    		$a = $db->query("SELECT * FROM login_imagenes");
    	}	    
	    foreach ($a as $b) {
	        echo '<li><a ' . $opciones .' imagen="assets/img/ico/' . $b["imagen"] .'"><img src="assets/img/ico/' . $b["imagen"] .'" alt="image" class="img-fluid img-responsive wow fadeIn" /></a></li>';
	    } $a->close();
   	}





} /// termina clase
?>