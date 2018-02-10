<?
include("../../librerias/lib/@session.php");
$key=$_POST["key"];
$familia=$_POST["familia"];
$rol=$_POST["rol"];
$usuario=$_POST["usuario"];
$comple_sql="";
$comple_sql2="";
if($familia=="estado" and $key!=0){
	$comple_sql=" and ".$familia." =".$key;
}elseif($familia=="estado" and $key==0){
	$comple_sql=" and ".$familia." not like (".$key.")";
}else{
	$comple_sql=" and ".$familia." like '%".$key."%'";
}
if($rol!="" AND $rol!=" " AND $rol!=NULL){
	$comple_sql.=" AND nombre_rol like '%".$rol."%'";
}
if($usuario!="" AND $usuario!=" " AND $usuario!=NULL){
	$comple_sql.=" AND nombre_administrador like '%".$usuario."%'";
}
if($estado!=0){
	$comple_sql.=" AND estado=".$estado;
}
$_SESSION["tabla_usuario"]="";
$_SESSION["confirma"]="";
$tabla='';
	$lista_inci = "select  nombre_rol, id_rol from v_roles_des099 where  us_id not in (18558, 18089) ".$comple_sql." group by nombre_rol, id_rol order by nombre_rol";
		 $sql_ex=query_db($lista_inci);
		while ($lt=traer_fila_row($sql_ex)){
			//para ver si tiene acceso al modulo de solicitudes
			$cont_solicitudes=traer_fila_row(query_db("SELECT COUNT(*) FROM v_roles_des099 WHERE  us_id NOT IN (18558, 18089) ".$comple_sql." AND id_rol=".$lt[1]." AND id_permisos_modulo=1"));
			if($cont_solicitudes[0]>0){
				$acceso_solicitues="SI";
			}else{
				$acceso_solicitues="";
			}
			//para ver si tiene acceso al modulo de urna virtual
			$cont_urna=traer_fila_row(query_db("SELECT COUNT(*) FROM v_roles_des099 WHERE  us_id NOT IN (18558, 18089) ".$comple_sql." AND id_rol=".$lt[1]." AND id_permisos_modulo=19"));
			if($cont_urna[0]>0){
				$acceso_urna="SI";
			}else{
				$acceso_urna="";
			}
			//para ver si tiene acceso al modulo de contratos
			$cont_contratos=traer_fila_row(query_db("SELECT COUNT(*) FROM v_roles_des099 WHERE  us_id NOT IN (18558, 18089) ".$comple_sql." AND id_rol=".$lt[1]." AND id_permisos_modulo=30"));
			if($cont_contratos[0]>0){
				$acceso_contratos="SI";
			}else{
				$acceso_contratos="";
			}
			//para ver si tiene acceso al modulo de comité
			$cont_comite=traer_fila_row(query_db("SELECT COUNT(*) FROM v_roles_des099 WHERE  us_id NOT IN (18558, 18089) ".$comple_sql." AND id_rol=".$lt[1]." AND id_permisos_modulo=40"));
			if($cont_comite[0]>0){
				$acceso_comite="SI";
			}else{
				$acceso_comite="";
			}
			//para ver si tiene acceso al modulo de tarifas
			$cont_tarifas=traer_fila_row(query_db("SELECT COUNT(*) FROM v_roles_des099 WHERE  us_id NOT IN (18558, 18089) ".$comple_sql." AND id_rol=".$lt[1]." AND id_permisos_modulo=46"));
			if($cont_tarifas[0]>0){
				$acceso_tarifas="SI";
			}else{
				$acceso_tarifas="";
			}
			//para ver si tiene acceso al modulo de reportes
			$cont_reportes=traer_fila_row(query_db("SELECT COUNT(*) FROM v_roles_des099 WHERE  us_id NOT IN (18558, 18089) ".$comple_sql." AND id_rol=".$lt[1]." AND id_permisos_modulo=60"));
			if($cont_reportes[0]>0){
				$acceso_reportes="SI";
			}else{
				$acceso_reportes="";
			}
			$tabla.=$lt[0]."--td--".$acceso_solicitues."--td--".$acceso_urna."--td--".$acceso_contratos."--td--".$acceso_comite."--td--".$acceso_tarifas."--td--".$acceso_reportes.'--func--alert("aqui")'.'--url--../aplicaciones/reportes/busca_roles_reporte_modal.php?number='.$lt[1].'--tr--';
		}
	if($_SESSION["tabla_usuario"]!=$tabla){
		$_SESSION["tabla_usuario"]=$tabla;
		$_SESSION["confirma"]="si";
		$tabla=htmlentities($tabla);
		//preg_replace( "/\r\n/", "", $tabla);
		echo json_encode($tabla);
	}else{
		$tabla="--td--"."--td--"."--td--"."No hay datos asociados"."--td--"."--td--"."--tr--";
		echo json_encode($tabla);
		//$arr=array("mensaje"=>"no");
	}
	//echo json_encode($arr);
?>