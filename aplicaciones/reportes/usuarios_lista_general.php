<? header("Content-type: application/octet-stream");//indicamos al navegador que se está devolviendo un archivo
header("Content-Disposition: attachment; filename=Reporte de Usuarios.xls");//con esto evitamos que el navegador lo grabe en su caché
header("Pragma: no-cache");
header("Expires: 0");

//include("../../librerias/lib/@include.php");
include("../../librerias/lib/@session.php"); 
	

$usuario=$_GET["usuario_permiso"];
$estado=$_GET["estado"];
$comple_sql="";
$comple_sql2="";

if($usuario!="" and $usuario!=" " and $usuario!=NULL){
	$sql_comple.=" AND nombre like '%".$usuario."%'";
	}
if($estado!=0){
	$sql_comple.=" AND estado=".$estado;
}
	
	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>


</head>

<body>

   <br />
  <table width="100%" border="1" class="tabla_lista_resultados">
  <tr>
    <td width="17%" align="center" bgcolor="#3399CC" class="fondo_3">ESTADO</td>
    <td width="17%" align="center" bgcolor="#3399CC" class="fondo_3">ROL</td>
    <td width="15%" align="center" bgcolor="#3399CC" class="fondo_3">NOMBRE</td>
    <td width="18%" align="center" bgcolor="#3399CC" class="fondo_3">EMAIL</td>
    <td width="18%" align="center" bgcolor="#3399CC" class="fondo_3">CREACION </td>
    <td width="18%" align="center" bgcolor="#3399CC" class="fondo_3">INACTIVACION</td>
    <td width="18%" align="center" bgcolor="#3399CC" class="fondo_3">AREA</td>
    <td width="20%" align="center" bgcolor="#3399CC" class="fondo_3">SOPORTE DESCENTRALIZADO</td>
    <td width="20%" align="center" bgcolor="#3399CC" class="fondo_3">GESTOR ABASTECIMIENTO</td>
    <td width="20%" align="center" bgcolor="#3399CC" class="fondo_3">PROFESIONAL DE C&amp;C</td>
    <td width="11%" align="center" bgcolor="#3399CC" class="fondo_3">COMPRADOR</td>
    <td width="11%" align="center" bgcolor="#3399CC" class="fondo_3">JEFATURA</td>
    <td width="19%" align="center" bgcolor="#3399CC" class="fondo_3">GERENTE DE AREA</td>
    <td width="19%" align="center" bgcolor="#3399CC" class="fondo_3">VICEPRESIDENTE</td>
    <td width="19%" align="center" bgcolor="#3399CC" class="fondo_3">DIRECTOR</td>
    <td width="19%" align="center" bgcolor="#3399CC" class="fondo_3">PRESIDENTE</td>
    <td width="19%" align="center" bgcolor="#3399CC" class="fondo_3">EMULADORES</td>
    </tr>
    <?
	$cont = 0;
	
    $sel_usuarios = query_db("select id, id_us, estado, rol, nombre, email, creacion, inactivacion, area, soporte_desc, gestor_abas, profesional_cyc, comprador, jefatura, gerente_area, vicepresidente, director, presidente, CAST(emuladores AS TEXT), id_rol, id_us_genera from temporal_reporte_usuarios where  id_us not in (18558, 18089) ".$sql_comple." and id_us_genera=".$_SESSION["id_us_session"]."  order by area, nombre");
	while($sel_usu = traer_fila_db($sel_usuarios)){
		
		if($sel_usu[2]==1){
			$estado="Activo";
			}else{
				$estado="Inactivo";
				}
		
			
		
	?>
  <tr  class="<?=$clase?>">
    <td><?=$estado?></td>
    <td><?=$sel_usu[3];?></td>
    
    <td><?=$sel_usu[4]?></td>
    <td><?=$sel_usu[5]?></td>
    <td><?=$sel_usu[6]?></td>
    <td><?=$sel_usu[7]?>
    </td>
    <td><?
    if($sel_usu[8]==""){ echo "N/A";}else{echo $sel_usu[8];}
	?></td>
    <td><?=$sel_usu[9];?></td>
    <td><?=$sel_usu[10];?>
    </td>
    <td><?=$sel_usu[11]?></td>
    <td><?=$sel_usu[12]?></td>
    <td><?=$sel_usu[13]?></td>
    <td><?=$sel_usu[14]?></td>    
    <td><?=$sel_usu[15]?></td>
    <td><?=$sel_usu[16]?></td>
    <td><?=$sel_usu[17]?></td>
    <td><?=$sel_usu[18]?></td>
  </tr>
  <?
		
	}
  ?>
</table>



</body>
</html>
