<?
include("../../librerias/lib/@session.php");
$key=$_POST["key"];
$familia=$_POST["familia"];
$rol=$_POST["rol"];
$usuario=$_POST["usuario"];
$estado=$_POST["estado"];
$comple_sql="";
$comple_sql2="";
if($familia=="estado" and $key!=0){
	$comple_sql.=" and ".$familia." =".$key;
}elseif($familia=="estado" and $key==0){
	$comple_sql.=" and ".$familia." not like (".$key.")";
}else{
	$comple_sql.=" and ".$familia." like '%".$key."%'";
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
	$lista_inci = "select nombre_administrador, estado, nombre_rol, id_rol, us_id from v_roles_des099 where  us_id not in (18558, 18089) ".$comple_sql." group by nombre_administrador, estado, nombre_rol, id_rol, us_id order by nombre_administrador";
		 $sql_ex=query_db($lista_inci);
		while ($lt=traer_fila_row($sql_ex)){
			$estado="";
			if($lt[1]==1){
				$estado="Activo";
			}else{
				$estado="Inactivo";
			}
			$tabla.=$estado.'--td--'.$lt[2].'--td--'.$lt[0].'--func--alert("aqui")'.'--url--../aplicaciones/reportes/busca_roles_reporte_modal.php?number2='.$lt[4].'--tr--';
		}
	if($_SESSION["tabla_usuario"]!=$tabla){
		$_SESSION["tabla_usuario"]=$tabla;
		$_SESSION["confirma"]="si";
		$tabla=htmlentities($tabla);
		//preg_replace( "/\r\n/", "", $tabla);
		echo json_encode($tabla);
	}else{
		$tabla='--td--No hay datos asociados--td----tr--';
		echo json_encode($tabla);
		//$arr=array("mensaje"=>"no");
	}
	//echo json_encode($arr);
?>