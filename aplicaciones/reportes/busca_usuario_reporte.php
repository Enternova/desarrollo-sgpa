<?
include("../../librerias/lib/@session.php");
$key=$_POST["key"];
$familia=$_POST["familia"];
$rol=$_POST["rol"];
$usuario=$_POST["usuario"];
$estado=$_POST["estado"];
$comple_sql="";
$comple_sql2="";

if($usuario!="" and $usuario!=" " and $usuario!=NULL){
	$sql_comple.=" AND nombre like '%".$usuario."%'";
	}
if($estado!=0){
	$sql_comple.=" AND estado=".$estado;
}

$_SESSION["tabla_usuario"]="";
$_SESSION["confirma"]="";
$tabla='';


$lista_inci = "select id_us, estado, rol, nombre, area, jefatura, gerente_area, vicepresidente, director, presidente from temporal_reporte_usuarios where id_us_genera=".$_SESSION["id_us_session"]." $sql_comple";
 



//$lista_inci = "select * from reporte_usuarios where  us_id not in (18558, 18089) ".$comple_sql."  order by area, nombre_administrador";
	$tabla="";
		 $sql_ex=query_db($lista_inci);
		while ($lt=traer_fila_row($sql_ex)){
			$nombre_limpio=str_replace(',', ' ', $lt[3]);
			$estado= $lt[1];
			if($estado == 1){$estado = "Activo";}else{$estado = "Inactivo";}
				$tabla.=$estado.'--td--'.$lt[2].'--td--'.$nombre_limpio.'--td--'.$lt[4].'--td--'.$lt[5].'--td--'.$lt[6].'--td--'.$lt[7].'--td--'.$lt[8].'--td--'.$lt[9].'--tr--';
				//echo "-".$sel_rol[0];
					}

			
			
	if($tabla!=""){
		$_SESSION["tabla_usuario"]=$tabla;
		$_SESSION["confirma"]="si";
		$tabla=htmlentities($tabla);
		preg_replace( "/\r\n/", "", $tabla);
		echo json_encode($tabla);
		
	}else{
		$tabla='--td----td----td--No hay datos asociados--td----td----td----td----tr--';
		echo json_encode($tabla);
		//$arr=array("mensaje"=>"no");
	}
	//echo json_encode($arr);
?>