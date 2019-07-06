<?php

class Imagenes{

//	DEFINO EL ARRAY QUE VA A CONTENER LAS EXTENSIONES PERMITIDAS
	var $_extensiones_pe = array( "jpg", "png" );
	
//	FUNCION PARA BUSCAR LA EXTENSION
	private function BuscaExtension( $nombre )	{
		if( trim( $nombre ) != "" )	{
//			DEFINO LA EXTENSION CON UN EXPLODE
			$extension = explode( ".", $nombre );
			$extension = strtolower( end( $extension ) );
//			DEVUELVO LA EXTENSION
			return $extension;
		} else	{
//			DEVUELVO UN FALSE ( BOOLEAN )
			return false;
		}
	}


//	FUNCION PARA CREAR EL NOMBRE
	private function CreaNombre( $nombre, $dir ){
//		SI SE PUEDE SACAR LA EXTENSION SIGO
		if( $extension = $this->BuscaExtension( $nombre ) )	{
			if( substr( $dir, 0, -1 ) != "/" )	$dir = $dir . "/";
			$a = 1;
//			BUCLE PARA BUSCAR UN NOMBE QUE NO SE REPITA
			while( $a )	{
//				EL NUEVO NOMBRE SERA EJ: xañomesdia.extension
				$nuevo_nombre = $dir . $a . date( "Ymd" ) . '.' . $extension;
				if( file_exists( $nuevo_nombre ) )	{
					$a++;
				} else	{
					$a = 0;
				}
			}
//			DEVUELVO EL NOMBRE
			return $nuevo_nombre;
			
		} else	{
//			DEVUELVO FALSE ( BOOLEAN )
			return false;
		}
	}
	
//	FUNCION PARA SUBIR EL ARCHIVO
	public function Subir( $tmp, $name, $dir )	{
//		SI ESTAN DEFINIDOS LOS PARAMETROS DE LA IMAGEN
		if( $tmp && $name && $dir )	{
//			DEFINO EL NUEVO NOMBRE DE LA IMAGEN
			$nombre_nuevo = $this->CreaNombre( $name, $dir );
			if( substr( $dir, strlen( $dir ) - 1, 1 ) != "/" ) $dir = $dir . "/";
			$nombre_fisico = $nombre_nuevo;
			
//			SI SE PUEDE CREAR LA EXTENSION, SIGO
			if( $extension = $this->BuscaExtension( $nombre_nuevo ) )	{
//				SI LA EXTENSION ESTA DENTRO DEL ARRAY DE EXTENSIONES, SIGO
				if( in_array( $extension, $this->_extensiones_pe ) )	{
//					SI SE COPIA LA IMAGEN, DEVUELVO EL NOMBRE FISICO
					if( copy ( $tmp, $nombre_fisico ) )	{
						return $nombre_fisico;
					} else	{
//						SI NO SE PUEDE COPIAR, DEVUELVO FALSE( BOOLEAN )
						return false;
					}
				} else	{
//					SI NO SE ENCONTRO LA EXTENSION DEVUELVO FALSE ( BOOLEAN )
					return false;
				}
			} else	{
//				SI NO SE PUDO CREAR LA EXTENSION DEVUELVO FALSE ( BOOLEAN )
				return false;
			}
		} else	{
//			SI NO SE DEFINIERON LOS PARAMETROS DE LA EXTENSION DEVUELVO FALSE ( BOOLEAN )
			return false;
		}
	}

//	FUNCION QUE RESIZEA
	public function Resize( $name, $tmp_name, $dir, $n_width = 300, $n_height = 300 )	{
//		VERIFICO QUE SUBA EL ARCHIVO		
		if( $nombre_fisico = $this->Subir( $tmp_name, $name, $dir ) )	{
//			VERIFICO QUE ESTEN ESPECIFICADOS LOS PARAMETROS DE LA FUNCION
			if( $name && $tmp_name && $dir && $n_width && $n_height )	{

				$nuevo_nombre = $this->CreaNombre( $name, $dir );
//				DEFINO LA EXTENSION DEL ARCHIVO
				$extension = $this->BuscaExtension( $nuevo_nombre );
//				VERIFICO QUE EL DIR. FINALICE CON UNA BARRA
				if( substr( $dir, 0, -1 ) != "/" )	$dir = $dir . "/";
//				SACO EL ANCHO Y ALTO DE LA IMAGEN
				list( $width, $height ) = getimagesize( $tmp_name );
//				DEFINO EL RADIO DE LA IMAGEN
				$radio = $width/$height;
//				DEFINO EL NUEVO ANCHO Y ALTO DE LA IMAGEN
				if( $n_width / $n_height > $radio )	{
					$n_width = $n_height*$radio;
				} else	{
					$n_height = $n_width/$radio;
				}
				
//				CREA LA IMAGEN
				switch( $extension )	{
					case "jpg":
						$src = imagecreatefromjpeg( $nombre_fisico );
					break;
					case "png":
						$src = imagecreatefrompng( $nombre_fisico );
					break;
				}
				
//				CREO LA IMAGEN EN COLOR REAL
				$nueva_imagen = imagecreatetruecolor( $n_width, $n_height );
//				CREA LA IMAGEN RESIZEADA
				imagecopyresampled( $nueva_imagen, $src, 0, 0, 0, 0, $n_width, $n_height, $width, $height );
//				DEFINO LA IMAGEN

//////////////////////
imagealphablending($nueva_imagen, false); 
imagesavealpha($nueva_imagen, true); // Drawing over 
$trans_layer_overlay = imagecolorallocatealpha($nueva_imagen, 220, 220, 220, 127); 
imagefill($nueva_imagen, 0, 0, $trans_layer_overlay);
//////////////////
///
				switch( $extension )	{
					case "jpg":
						imagejpeg( $nueva_imagen, $nombre_fisico, 99 );
					break;
					case "png":
						imagepng( $nueva_imagen, $nombre_fisico, 9 );
					break;
				}
//				DEVUELVO QUE SUBI
				//return "Imagen subida con exito";
				return $this->EliminaDir($nombre_fisico, $dir);

				
			} else	{
//				DEVUELVO QUE HUBO UN ERROR EN LOS PARAMETROS
				//return "Faltan datos de la imagen";
				return FALSE;
			}
			
		} else	{
//			DEVUELVO QUE NO SE PUDO SUBIR LA IMAGEN. FALLO LA FUNCION $this->subir()
			//return "No se pudo subir la imagen";
			return FALSE;
		}
		
	}

	public function EliminaDir($archivo, $dir){
		return str_replace($dir, "", $archivo);
	}



	
} //  clase






?>