<?php 
	
	include("../../lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    
?>

<?php
/**  variable que recibe para verificar el que condicional ingresa  **/
$boton= $_POST['boton'];



/**  registrar criterio  **/
if ($boton==='registrar_criterio') {
		
		$nombre_criterio=$_POST['nombre_criterio'];
		$puntos_criterio=$_POST['puntos_criterio'];
		
			$insertar_criterio="INSERT INTO criterio VALUES(0,'".$nombre_criterio."','".$puntos_criterio."','1')";
			
			$insertar_crite=sqlsrv_prepare($insertar_criterio);
			
		if(sqlsrv_execute($insertar_crite)){
			  echo"Se Han Agregado Un Nuevo Criterio";
		}else{
			  echo"No Se Agrego Su Criterio";
		}		
	}

/**  modificar criterio  **/	
if ($boton==='modificar_criterio') {
	
		$id_criterio=$_POST['id_criterio'];
		$nombre_criterio=$_POST['nombre_criterio'];
		$puntos_criterio=$_POST['puntos_criterio'];
		
			$actualiza_criterio=" UPDATE criterio SET nombre_criterio='".$nombre_criterio."' , puntos_criterio='".$puntos_criterio."' WHERE id_criterio='".$id_criterio."'";
			
			$actualiza_crite=sqlsrv_prepare($actualiza_criterio);
		
		if(sqlsrv_execute($actualiza_crite)){
			  echo"Se Han Actualizado Su Criterio";
		}else{
			  echo"No Se Actualizado Su Criterio";
		}	
	}
	
/**  eliminar criterio  **/
if ($boton==='eliminar_criterio') {
	
		$id_criterio=$_POST['id_criterio'];
		
			$eliminar_criterio=" UPDATE criterio SET estado='3' WHERE id_criterio='".$id_criterio."'";
			
			$eliminar_crite=sqlsrv_prepare($eliminar_criterio);
		
		if(sqlsrv_execute($eliminar_crite)){
			  echo"Se Han Eliminado Su Criterio";
		}else{
			  echo"No Se Eliminado Su Criterio";
		}	
	}

/**  buscar criterio  **/

if ($boton==='buscar_criterio') {
	
		$valor=$_POST['valor'];
		
			$listar_criterio="SELECT * FROM criterio WHERE nombre_criterio like '%".$valor."%'";
			$this->conexion->conexion->set_charset('8859-1');
			$resultados=$this->conexion->conexion->query($sql);
			$arreglo = array();
			while ($re=$resultados->fetch_array(MYSQL_NUM)) {
				$arreglo[]=$re;
			}
			return $arreglo;
			
			echo json_encode($arreglo);
			
			$this->conexion->cerrar();
		
	}	
	
/**  registrar aspectos  **/	
	if ($boton==='registrar_aspectos') {
		
		$id_criterio=$_POST['id_criterio'];
		$nombre_aspectos=$_POST['nombre_aspectos'];
		$puntos_aspectos=$_POST['puntos_aspectos'];
		$nombre_descripcion=$_POST['nombre_descripcion'];
		
		for($i = 0; $i < count($nombre_aspectos); $i++){
	
			 $nombre_aspectos[$i];
			 $puntos_aspectos[$i];
			 $nombre_descripcion[$i];
			
			$insertar_aspectos="INSERT INTO aspectos_criterio VALUES(0,'".$nombre_aspectos[$i]."','".$puntos_aspectos[$i]."','".$nombre_descripcion[$i]."','$id_criterio','1')";
			
			$insertar_aspect=sqlsrv_prepare($insertar_aspectos);
			
			}
		
		if(sqlsrv_execute($insertar_aspect)){
			  echo"Se Han Agregado Nuevos Aspectos";
		}else{
			  echo"No Se Agregaron Sus Aspectos";
		}	
	}
	
/**  modificar aspectos  **/	
	if ($boton==='modificar_aspectos') {
	
		$id_aspectos=$_POST['id_aspectos'];
		$nombre_aspectos=$_POST['nombre_aspectos'];
		$puntos_aspectos=$_POST['puntos_aspectos'];
		$nombre_descripcion=$_POST['nombre_descripcion'];
		
		for($i = 0; $i < count($id_aspectos); $i++){
		
			 $id_aspectos[$i];
			 $nombre_aspectos[$i];
			 $puntos_aspectos[$i];
			 $nombre_descripcion[$i];
			
			$actualiza_aspectos="UPDATE aspectos_criterio SET nombre_aspectos='".$nombre_aspectos[$i]."',puntos_aspectos='".$puntos_aspectos[$i]."',nombre_descripcion='".$nombre_descripcion[$i]."' WHERE id_aspectos='".$id_aspectos[$i]."'";
			
			$actualiza_aspect=sqlsrv_prepare($actualiza_aspectos);
			
			}
			
		if(sqlsrv_execute($actualiza_aspect)){
			  echo"Se Han Actualizado Sus Aspectos";
		}else{
			  echo"No Se Actualizaron Sus Aspectos";
		}		
	}
	
/**  eliminar aspectos  **/	
if ($boton==='eliminar_aspectos') {
	
		$id_aspectos=$_POST['id_aspectos'];	
		
		for($i = 0; $i < count($id_aspectos); $i++){
	
	     	$id_aspectos[$i];
			
			$eliminar_aspectos="UPDATE aspectos_criterio SET estado='3' WHERE id_aspectos='".$id_aspectos[$i]."'";
			
			$eliminar_aspect=sqlsrv_prepare($eliminar_aspectos);
		
			}
			
		if(sqlsrv_execute($eliminar_aspect)){
			  echo"Se Han Eliminado Sus Aspectos";
		}else{
			  echo"No Se Eliminado Sus Aspectos";
		}		
	}
	
/**  registrar estados  **/
if ($boton==='registrar_estados') {
		
		$nombre_estados=$_POST['nombre_estados'];
		
			$insertar_estados="INSERT INTO estado VALUES(0,'".$nombre_estados."')";
			
			$insertar_estad=sqlsrv_prepare($insertar_estados);
			
		if(sqlsrv_execute($insertar_estad)){
			  echo"Se Han Agregado Un Nuevo Estado";
		}else{
			  echo"No Se Agrego Su Estado";
		}		
	}	
	
	
	
	
?>