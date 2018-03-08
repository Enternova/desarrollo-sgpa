<? header("Content-type: application/octet-stream");//indicamos al navegador que se está devolviendo un archivo
header("Content-Disposition: attachment; filename=Reporte de Usuarios.xls");//con esto evitamos que el navegador lo grabe en su caché
header("Pragma: no-cache");
header("Expires: 0");

//include("../../librerias/lib/@include.php");
include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");

   include("../../librerias/php/funciones_general.php");
	

	$estado_us = $_GET["estado"];
	
	$explode = explode("----,",$_GET["usuario_permiso"]);
	$id_usuario = $explode[1];
	
	
	if($id_usuario > 0){
	$sql_comple.=" and us_id = ".$id_usuario;	
		}
	
	if($estado_us==1){
	$sql_comple.= " and estado = 1";
	}
	if($estado_us==2){
	$sql_comple.= " and estado = 2 and contrasena = 'Bloqueado'";
	}
	if($estado_us==3){
	$sql_comple.= " and estado = 2 and contrasena = 'Eliminado'";
	}
	
	$sql_comple.= " and us_id>1";
	
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
    <td width="18%" align="center" bgcolor="#3399CC" class="fondo_3">AREA</td>
    <td width="20%" align="center" bgcolor="#3399CC" class="fondo_3">Gestion Abastecimiento</td>
    <td width="20%" align="center" bgcolor="#3399CC" class="fondo_3">PROFESIONAL DE C&amp;C</td>
    <td width="11%" align="center" bgcolor="#3399CC" class="fondo_3">PROFESIONAL DE C&amp;C SERVICIOS MENORES</td>
    <td width="11%" align="center" bgcolor="#3399CC" class="fondo_3">COMPRADOR CORPORATIVO</td>
    <td width="11%" align="center" bgcolor="#3399CC" class="fondo_3">COMPRADOR PROYECTOS</td>
    <td width="11%" align="center" bgcolor="#3399CC" class="fondo_3">COMPRADOR STOK</td>
    <td width="11%" align="center" bgcolor="#3399CC" class="fondo_3">JEFATURA</td>
    <td width="19%" align="center" bgcolor="#3399CC" class="fondo_3">GERENTE DE AREA</td>
    <td width="19%" align="center" bgcolor="#3399CC" class="fondo_3">VICEPRESIDENTE</td>
    <td width="19%" align="center" bgcolor="#3399CC" class="fondo_3">DIRECTOR</td>
    <td width="19%" align="center" bgcolor="#3399CC" class="fondo_3">EMULADORES</td>
    </tr>
    <?
	$cont = 0;

    $sel_usuarios = query_db("select * from reporte_usuarios where  us_id not in (18558, 18089) ".$sql_comple."  order by area, nombre_administrador");
	while($sel_usu = traer_fila_db($sel_usuarios)){
		
		$estado="Activo";
		
		if($sel_usu[6]==2 and $sel_usu[1]=="Eliminado"){
			$estado="Eliminado";
			}
		if($sel_usu[6]==2 and $sel_usu[1]=="Bloqueado"){
			$estado="Bloqueado";
			}
			
		$sel_si_es_profesional = traer_fila_row(query_db("select * from tseg5_usuario_permisos where id_usuario = ".$sel_usu[0]." and id_permiso = 8"));
		$muestra = "SI";		
		if($sel_si_es_profesional[0]>0 and $sel_usu[8]<>44){
			$muestra = "NO";
			}
			
		$sel_si_es_profesional = traer_fila_row(query_db("select * from tseg5_usuario_permisos where id_usuario = ".$sel_usu[0]." and id_permiso = 44"));
		$muestra = "SI";		
		if($sel_si_es_profesional[0]>0 and $sel_usu[8]<>44){
			$muestra = "NO";
			}
			
		$sel_si_es_almacen = traer_fila_row(query_db("select * from tseg5_usuario_permisos where id_usuario = ".$sel_usu[0]." and id_permiso = 29"));
		if($sel_si_es_almacen[0]>0 and $sel_usu[8]<>39){
			$muestra = "NO";
			}
			
		if($muestra=="SI"){
	?>
  <tr  class="<?=$clase?>">
    <td><?=$estado?></td>
    <td><?
    $sel_roles = query_db("select t2.nombre from tseg12_relacion_usuario_rol as t1, tseg11_roles_general as t2 where t1.id_usuario = ".$sel_usu[0]." and t1.id_rol_general = t2.id_rol");
	while($sel_rol = traer_fila_db($sel_roles)){
		echo "-".$sel_rol[0];
		}
	
	?></td>
    
    <td><?=$sel_usu[1]?></td>
    <td><?
    if($sel_usu[9]==""){ echo "N/A";}else{
	echo $sel_usu[9];}
	?></td>
    <td>
	
	<?
	if($sel_usu[11] != ""){
		
		if($sel_usu[8]== 1 or $sel_usu[8] == 44){
			echo "- DELOITTE, KAREN COLORADO - CORRALES, PATRICIA";
			
	}else{
					
	$sel_per = query_db("select $ts5.id_usuario from $ts5, tseg3_usuario_areas where $ts5.id_usuario = tseg3_usuario_areas.id_usuario and $ts5.id_permiso=44 and tseg3_usuario_areas.id_area = ".$sel_usu[8]);
	while($sel_gesti_ab = traer_Fila_db($sel_per)){
		echo " - ".saca_nombre_lista($g1,$sel_gesti_ab[0],'nombre_administrador','us_id');
		}
    
			}
	
	
	}else{
		echo "";
		}
	?>
    
    </td>
    <td><?=$sel_usu[11]?></td>
    <td><?=$sel_usu[19]?></td>
    <td><?=$sel_usu[12]?></td>
    <td><?=$sel_usu[13]?></td>
    <td><?=$sel_usu[14]?></td>
    <td><?=$sel_usu[15]?></td>
    <td><?=$sel_usu[16]?></td>    
    <td><?=$sel_usu[17]?></td>
    <td><?=$sel_usu[18]?></td>
    <td><?
    $sel_us_emula = query_db("select t2.nombre_administrador from t2_relacion_usuarios_emulan as t1, t1_us_usuarios as t2 where t1.id_us = ".$sel_usu[0]." and t1.id_us_emula = t2.us_id");
	while($sel_emu = traer_fila_db($sel_us_emula)){
		echo "-".$sel_emu[0];
		}
	
	?></td>
  </tr>
  <?
		}//fin si muestra
	}
  ?>
</table>



</body>
</html>
