<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    //verifica_menu("procesos.html");

//$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	
	$id_invitacion = $id_invitacion;
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$busca_confirmacion = traer_fila_row(query_db("select * from $t9 where  pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." order by fecha desc"));

?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css">
</head>
<body >
<br>
<fieldset style="width:98%">
			<legend>Opciones de reportes</legend>
            
     <table width="95%" border="0" cellpadding="0" cellspacing="0" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td><div align="center"><img src="../imagenes/botones/ico4.jpg" alt="Reporte 1" ></div></td>
    <td> <div align="left"><a href="#" onClick="popup01('../aplicaciones/evaluacion/c_economico4.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&campo_valos=<?=$busca_campos_1[0];?>&tipo_busq=min', 600, 880, 100, 100, 1, 1)"><strong>Reporte Consolidado de ofertas</strong></a></div></td>
  </tr>
  <tr>
    <td width="84"><div align="center"><img src="../imagenes/botones/ico4.jpg" alt="Reporte 1"></div></td>
    <td width="928">
    
      <div align="left"><a href="#" onClick="popup01('../aplicaciones/evaluacion/c_economico.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&campo_valos=<?=$busca_campos_1[0];?>&tipo_busq=min', 600, 880, 100, 100, 1, 1)"><strong>Reporte de ofertas econ&oacute;micas comparativa entre los oferentes aceptados.</strong></a></div></td>
  </tr>
  <tr>
    <td width="84"><div align="center"><img src="../imagenes/botones/ico4.jpg" alt="Reporte 1"></div></td>
    <td width="928">
    
      <div align="left"><a href="#" onClick="popup01('../aplicaciones/evaluacion/c_economico2.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&campo_valos=<?=$busca_campos_1[0];?>&tipo_busq=min', 600, 880, 100, 100, 1, 1)"><strong>Reporte de mejores ofertas econ&oacute;micas agrupadas por proveedor.</strong></a></div></td>
  </tr>
  <tr>
    <td width="84"><div align="center"><img src="../imagenes/botones/ico4.jpg" alt="Reporte 1" ></div></td>
    <td width="928">
    
      <div align="left"><a href="#" onClick="popup01('../aplicaciones/evaluacion/c_economico3.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&campo_valos=<?=$busca_campos_1[0];?>&tipo_busq=min', 600, 880, 100, 100, 1, 1)"><strong>Reporte de ofertas econ&oacute;micas consolidadas.</strong></a></div></td>
  </tr>  
</table>
            
</fieldset>
            <br>

            <br>
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_pasa;?>">
<input type="hidden" name="id_anexo">
</fieldset>

</body>
</html>
