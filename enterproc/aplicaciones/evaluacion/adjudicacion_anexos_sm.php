<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    //verifica_menu("procesos.html");

//$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	
	$id_invitacion = $id_invitacion;
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));


	$busca_relacion = traer_fila_row(query_db("select * from $t43 where pro1_id = $id_invitacion and pv_id = $pv_id and estado = 1"));
?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css">
</head>


<body>
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="84%" class="titulos_evaluacion"><div align="left">PASO 3:Configure la carta de adjudicaci&oacute;n y los anexos por cada proveedor seleccionado</div></td>
    <td width="16%"><input name="button2" type="button" class="cancelar" id="button2" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso3_sm.php?id_invitacion=<?=$id_invitacion;?>','contenidos')">sm</td>
  </tr>
  <tr>
    <td ><strong>Consecutivo:</strong> <span class="texto_paginador_proveedor">
      <?=$sql_e[22];?>
    </span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td ><strong>Objeto:</strong>
        <?=$sql_e[12];?></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" class="titulos_procesos">&nbsp;</td>
  </tr>
  <tr>
    <td width="35%"><div align="right"><strong>Anexar documento soporte:</strong></div></td>
    <td width="44%"><input type="file" name="arc_soporte" id="arc_soporte" /></td>
    <td width="21%"><input type="button" name="button3" class="guardar" id="button3" value="Grabar documento soporte" onClick="graba_archivo_soporte_adj_proveedor()" /></td>
  </tr>
</table>

<br />
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td width="5%" class="titulo_tabla_azul_sin_bordes">Anexo</td>
    <td width="45%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
    <td width="30%" class="titulo_tabla_azul_sin_bordes">Fecha cargue</td>
    <td width="9%" class="titulo_tabla_azul_sin_bordes">Descargar</td>
    <td width="11%" class="titulo_tabla_azul_sin_bordes">Eliminar</td>
  </tr>
  <?
			  	$busca_provee = query_db("select * from $t37 where
				pro1_id =  $id_invitacion and pv_id = $pv_id and pro27_id = $busca_relacion[0]");
				while($lp = traer_fila_row($busca_provee)){
			    $ext=extencion_archivos($lp[3]);
			  
					  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
  ?>
  <tr class="<?=$class;?>">
    <td><img src="../imagenes/mime/<?=$ext;?>.gif"></td>
    <td><?=$lp[3];?></td>
    <td><?=fecha_for_hora($lp[4]);?></td>
    <td><div align="center"><img src="../imagenes/botones/editar_c.png" width="16" height="16" alt="descargar documento" title="descargar documento" onClick="window.parent.location.href='../librerias/php/descarga_documentos_adjudicacion_provedor.php?n1=<?=$lp[0];?>&n2=<?=$lp[3];?>'" /></div></td>
    <td><div align="center"><img src="../imagenes/botones/b_cancelar.gif" title="Eliminar Documento de la invitaci&oacute;n" onClick="elimina_archivo_soporte_adj_proveedor(<?=$lp[0];?>)"/></div></td>
  </tr>
  <? $num_fila++;} ?>
</table>
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
<input type="hidden" name="pv_id" value="<?=$pv_id;?>">
<input type="hidden" name="pro27_id" value="<?=$busca_relacion[0];?>">
<input type="hidden" name="id_anexo" >
</body>
</html>
