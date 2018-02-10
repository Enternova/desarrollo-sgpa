<?php
//error_reporting(E_ALL);  // Líneas para mostart errores
//ini_set('display_errors', '1');  // Líneas para mostart errores
include("../../librerias/lib/@session.php");
$fecha_actual= date('Y-m-d');
$tres_meses = strtotime ( '+3 month' , strtotime ($fecha_actual) );
$tres_meses=date('Y-m-d',$tres_meses);
$key='';  // Una clave de codificacion, debe usarse la misma para encriptar y desencriptar
$arr=array();
//$id_usuario = rtrim(mcrypt_decrypt(MCRYPT_RIJNDAEL_256, md5($key), base64_decode($_POST['cadena']), MCRYPT_MODE_CBC, md5(md5($key))), "\0");
$id_usuario = $cadena;

if($_POST['action']=="gestiona"){
	$fecha_actual= date('Y-m-d');
	$time=date('G:i:s');
	$id_push=$_POST['value'];
	$arr=array("mensaje"=>"si");
	$confirm=query_db("update $valer_3 set estado=2, fecha_cierre='$fecha_actual', hora_cierrre='$time' where id=$id_push");
	if($confirm){
		echo json_encode($arr);
	}
}elseif($_POST['action']=="lee"){
	$fecha_actual= date('Y-m-d');
	$time=date('G:i:s');
	$id_push=$_POST['value'];
	query_db("update $valer_3 set estado=3,fecha_gestion='$fecha_actual', hora_gestion='$time' where id=$id_push");
	$query="select ruta, id_carga from $valer_3 where id_usuario=$id_usuario and id=$id_push";
	$sin_leer_query=traer_fila_row(query_db($query));
	$ruta=$sin_leer_query[0];
	$id=$sin_leer_query[1];
	$ruta=str_replace('<-id->', $id, $ruta);
	//$ruta=trim($ruta, "\r");
	//$ruta=trim($ruta, "\n.");
	$buscar=array(chr(13).chr(10), "\r\n", "\n", "\r");
	$reemplazar=array("", "", "", "");
	$ruta=str_ireplace($buscar,$reemplazar,$ruta);
	echo $ruta;
}else{
	$update=query_db("update ".$valer_3." set estado = 4 where fecha_fin in not null and fecha_fin < '$fecha_actual'");
	/***** para verificar si el estado es  >= 20 ******
	$update_solicitud="select id, id_solicitud, dias from ".$valer_3." where id_solicitud is not null";
	$update_solicitud_query=query_db($update_solicitud);
	while($sql_con = traer_fila_db($update_solicitud_query)){
		$query_solicitud=traer_fila_row(query_db("select estado from t2_item_pecc where id_item=".$sql_con[1]));
		if($query_solicitud[0]>=20){
			$update=query_db("update ".$valer_3." set estado = 4 where id=".$sql_con[0]);
		}
	}*****/
	
	
	
	
$query="select count(*) from $valer_3 where id_usuario=$id_usuario and estado=1 and((fecha_fin between '$fecha_actual' and '$tres_meses') or fecha_fin is null)";

$total_sin_leer=traer_fila_row(query_db($query));
$total_sin=array("total_sin"=>$total_sin_leer[0]);
$arr['total_sin']=$total_sin;
if($total_sin_leer[0]!=0){	
	$query="select id, cast(ruta as text) as ruta, tipo, cast(mensaje as text) as mensaje, estilo_borde, div, ROW_NUMBER() OVER(ORDER BY id asc) as posicion, (select dbo.DiasLaborales(fecha_creacion, '".$fecha_actual."')) as dias from $valer_3 where id_usuario=$id_usuario and estado=1 and((fecha_fin between '$fecha_actual' and '$tres_meses') or fecha_fin is null) ORDER BY id ASC";
	$sin_leer_query=query_db($query);
	$array2=array();
	
	while ($s_actual = traer_fila_db($sin_leer_query)) {
		
		$pasa=$s_actual['mensaje'];
		$pasa=explode("<br>", $pasa);
		$cadena1=substr($pasa[0], 0, 20);
		$cadena2=substr($pasa[1], 0, 20);
		$cadena2=str_replace('&oacute;', 'ó', $cadena2);
		$cadena3=substr($pasa[2], 0, 20);
		$cadena=$cadena1."...<br>".$cadena2."...<br>".$cadena3."...";
		$array2['mensaje'] = utf8_encode($cadena);
		$array2[]=$s_actual;
		
		
	}
	/*$sin_leer_query=traer_fila_row(query_db($query));	
	$sin_leer=array("id_sin"=>$sin_leer_query[0],"ruta_sin"=>$sin_leer_query[1],"tipo_sin"=>$sin_leer_query[2],"mensaje_sin"=>$sin_leer_query[3]);*/
	$arr['pendiente']=$array2;
}else{
	$sin_leer=array("mensaje_sin"=>"no");
	$arr['pendiente']=$sin_leer;
}
$query="select count(*) from $valer_3 where id_usuario=$id_usuario and estado in (1, 2, 3) and((fecha_fin between '$fecha_actual' and '$tres_meses') or fecha_fin is null)";
$total_pendiente=traer_fila_row(query_db($query));
$total_todo=array("total_todo"=>$total_pendiente[0]);
$arr['total_todo']=$total_todo;
if($total_pendiente[0]!=0){
	$query="select id, cast(ruta as text) as ruta, tipo, cast(mensaje as text) as mensaje, estilo_borde, div, ROW_NUMBER() OVER(ORDER BY id asc) as posicion, (select dbo.DiasLaborales(fecha_creacion, '".$fecha_actual."')) as dias, id_solicitud from $valer_3 where id_usuario=$id_usuario and estado in (1, 2, 3) and((fecha_fin between '$fecha_actual' and '$tres_meses') or fecha_fin is null) ORDER BY id ASC";
	$sin_leer_query=query_db($query);
	$array2=array();
	while ($s_actual = traer_fila_db($sin_leer_query)) {
		
		$carga_alerta="SI";
		
		if($s_actual[8] >0 and $s_actual[8] != "" and $s_actual[8] != " "){//si es una alerta de solicitudes
			$query_solicitud=traer_fila_row(query_db("select estado, id_us, id_us_profesional_asignado, id_item from t2_item_pecc where id_item=".$s_actual[8]." and (id_us=".$id_usuario." or id_us_profesional_asignado=".$id_usuario.")"));
			
			if($query_solicitud[3]<=0){//si el usaurio fue cambiado inhabiilita las alertas para el usaurio.
				$carga_alerta="NO";
				$update=query_db("update ".$valer_3." set estado = 4 where id_solicitud=".$s_actual[8]." and id_usuario=".$id_usuario);
			}elseif(($query_solicitud[0]>20 and $query_solicitud[0]!=31) or $query_solicitud[0]==6 or $query_solicitud[0]==14){//si la solicitud ya no esta en un estado de alerta push, inaabilita todas las alertas
				$carga_alerta="NO";
				$update=query_db("update ".$valer_3." set estado = 4 where id_solicitud=".$s_actual[8]);
			}	
			
		}
			
						
		
		
		
		if ($carga_alerta=="SI"){
		$pasa=$s_actual['mensaje'];
		$pasa=explode("<br>", $pasa);
		$cadena1=substr($pasa[0], 0, 20);
		$cadena2=substr($pasa[1], 0, 20);
		$cadena2=str_replace('&oacute;', 'ó', $cadena2);
		$cadena3=substr($pasa[2], 0, 20);
		$cadena=$cadena1."...<br>".$cadena2."...<br>".$cadena3."...";
		$array2['mensaje'] = utf8_encode($cadena);
		$array2[]=$s_actual;
		}
		
	}
	$arr['todo']=$array2;
}else{
	$ms=array("mensaje"=>"no");
	$arr['todo']=$ms;
}
echo json_encode($arr);
}
?>