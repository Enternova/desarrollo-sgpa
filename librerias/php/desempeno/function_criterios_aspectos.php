<?php


$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER



// Crear La función Insertar
 function insertar_criterio($tblname,$nombre_criterio,$puntos_criterio,$estado,$tipo_contrato){
	
	echo $sql="INSERT INTO ".$tblname."(nombre_criterio,puntos_criterio,estado,tipo_contrato)  VALUES('".$nombre_criterio."','".$puntos_criterio."','".$estado."','".$tipo_contrato."')";
	
	$sql_ex=query_db($sql.$trae_id_insrte);
	if($sql_ex>=1){//si se creo

			return 1;

		} //si no se creo
		else{
		
			return 0;
		}
	
	
}
/*

function borrar_criterio_aspecto($tblname,$tblname1,$id_criterio){

	$sql = "UPDATE ".$tblname." SET estado='3' where id_criterio='".$id_criterio."'";
	
	$sql1 = "UPDATE ".$tblname1." SET estado='3' where id_criterio='".$id_criterio."'";
	
	
	return db_query($sql); 
	
	return db_query($sql1); 
}



function edita_criterio($tblname,$nombre_criterio,$puntos_criterio,$id_criterio,$tblname1,$id_aspectos,$nombre_aspectos,$puntos_aspectos,$nombre_descripcion){
	
	$sql = "UPDATE ".$tblname." SET nombre_criterio='".$nombre_criterio."', puntos_criterio='".$puntos_criterio."' where id_criterio='".$id_criterio."'";
	
	
	return db_query($sql); 
	
	
	
	for($i=0; $i<count($nombre_aspectos); $i++) 
{
	 echo$nombre_aspectos[$i];
	 $puntos_aspectos[$i];
	 $nombre_descripcion[$i];
	
	$sql = "UPDATE ".$tblname1." SET nombre_aspectos='".$nombre_aspectos[$i]."', puntos_aspectos='".$puntos_aspectos[$i]."', nombre_descripcion='".$nombre_descripcion[$i]."' where id_aspectos='".$id_aspectos[$i]."'";
	
	$db1=db_query($sql);
   }
			
			
return $db1;
}*/

function mostrar_criterio($tblname,$id_criterio){
	$sql = "Select * from ".$tblname." where id_criterio= ".$id_criterio."";
	$db=query_db($sql);
	while($lt=traer_fila_db($db)){
		$lt[0];
	}

	return $sql;

}

function mostrar_criterio_aspecto($tblname,$tblname1,$id_criterio){
	$sql = "Select ".$tblname.".*,".$tblname1.".* from ".$tblname.",".$tblname1." where ".$tblname.".id_criterio=".$tblname1.".id_criterio and ".$tblname.".id_criterio= ".$id_criterio."";
	$db=query_db($sql);
	while($lt=traer_fila_db($db)){
		$lt[0];
	}
	return $sql;

}





 function insertar_aspecto($tblname,$id_criterio,$nombre_aspectos,$puntos_aspectos,$nombre_descripcion,$estado,$tipo_servicio){
	
	
	$sql="INSERT INTO ".$tblname."(nombre_aspectos,puntos_aspectos,nombre_descripcion,id_criterio,estado,tipo_servicio)  VALUES('".$nombre_aspectos."','".$puntos_aspectos."','".$nombre_descripcion."','".$id_criterio."','".$estado."','".$tipo_servicio."')";
	
	$sql_ex=query_db($sql.$trae_id_insrte);
	if($sql_ex>=1){//si se creo

			return 1;

		} //si no se creo
		else{
		
			return 0;
		}
}







/*








function insertar_estado($tblname,$nombre_estado){
	
	$sql="INSERT INTO ".$tblname."(nombre_estado)  VALUES('".$nombre_estado."')";
	
	return db_query($sql);
}*/
?>
