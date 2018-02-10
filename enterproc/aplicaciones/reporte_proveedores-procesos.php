<?  include("../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	//verifica_menu("procesos.html");
	$pv_id_pasa = arreglo_recibe_variables($pv_id_pasa);
	$pv_id_pasa = elimina_comillas($pv_id_pasa);
?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>
<body >
<?
	$busca_procesos = "select $t5.pro1_id, $tp2.nombre, $tp6.nombre, $tp5.nombre, $t5.fecha_apertura, $t5.fecha_cierre, $t1.nombre_administrador, $t5.consecutivo  
	 from $tp2, $tp6, $tp5, $t1, $t5, $t8 where 
	$tp2.tp2_id = $t5.tp2_id and
	$tp6.tp6_id = $t5.tp6_id and
	$tp5.tp5_id = $t5.tp5_id and
	$t1.us_id = $t5.us_id_contacto and
	$t8.pv_id = $pv_id_pasa";
	
	
  	$busca_procesos = "select $t5.pro1_id, $tp2.nombre, $tp6.nombre, $tp5.nombre, $t5.fecha_apertura, $t5.fecha_cierre, $t1.nombre_administrador, $t5.consecutivo  
	 from $tp2, $tp6, $tp5, $t1, $t5, $t7 where 
	$tp2.tp2_id = $t5.tp2_id and
	$tp6.tp6_id = $t5.tp6_id and
	$tp5.tp5_id = $t5.tp5_id and
	$t1.us_id = $t5.us_id_contacto and
	$t7.pro1_id = $t5.pro1_id and
	
	$t7.pv_id = ".$pv_id_pasa;	

?>

<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td colspan="7" class="titulo_tabla_azul_sin_bordes">reporte de procesos invitados</td>
  </tr>
  <tr>
    <td width="10%" class="tabla_sin_borde_fondo_gris"><div align="center">Consecutivo</div></td>
    <td width="17%" class="tabla_sin_borde_fondo_gris"><div align="center">Tipo de proceso</div></td>
    <td width="19%" class="tabla_sin_borde_fondo_gris"><div align="center">Objeto a Contratar</div></td>
    <td width="13%" class="tabla_sin_borde_fondo_gris"><div align="center">Apertura</div></td>
    <td width="17%" class="tabla_sin_borde_fondo_gris"><div align="center">Cierre</div></td>
    <td width="12%" class="tabla_sin_borde_fondo_gris"><div align="center">Responsable</div></td>
    <td width="12%" class="tabla_sin_borde_fondo_gris"><div align="center">Aceptaci&oacute;n</div></td>
  </tr>
<?  
	$sql_ex = query_db($busca_procesos);
	while($ls=traer_fila_row($sql_ex)){
	
	
	$busca_confirmacion_participacion = traer_fila_row(query_db("select pro4_id, if(confirmacion=1,'Si', 'No') from $t9 where pv_id = $pv_id_pasa and pro1_id = $ls[0]  and estado = 1 and confirmacion  = 1 "));				
	if($busca_confirmacion_participacion[0]>=1)
		$confir= $busca_confirmacion_participacion[1];
	else
		$confir="Sin confirmar";

		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
  ?>
  <tr class="<?=$class;?>">
    <td><?=$ls[7];?></td>
    <td><?=$ls[1];?></td>
    <td><?=$ls[2];?></td>
    <td><?=fecha_for_hora($ls[4]);?></td>
    <td><?=fecha_for_hora($ls[5]);?></td>
    <td><?=$ls[6];?></td>
    <td><?=$confir;?></td>
  </tr>
  <? $num_fila++; } ?>
</table>

<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><label>
        <div align="center"></div>
    </label>    <div align="center">
      <input type="button" name="button2" id="button2" value="Cerrar reporte" onClick="close_va()">
    </div></td>
  </tr>
</table>
</body>
</html>
