<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("procesos.html");


$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);

	$lista_licitaciones = "select * from $t5 where pro1_id = $id_invitacion";
	$linvi=traer_fila_row(query_db($lista_licitaciones));
	
	 	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$inserta_visualizacion = query_db("insert into in_ingreso_sistema (us_id, fecha_ingreso, ultima_conexion, ip, session, modulo, pro1_id, pv_id) 
	values ( ".$_SESSION["id_us_session"].", '$fecha $hora','', '".$_SERVER['REMOTE_ADDR']."', '','Modulo de criterios técnicos',$id_invitacion,".$_SESSION["id_proveedor"].")");


?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css">
</head>
<body >
  
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">LISTA DE T&Eacute;RMINOS TECNICOS REQUERIDOS</td>
  </tr>
</table>



<table width="98%" border="0" align="center" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
  <tr>
    <td></td>
    <td></td>
  </tr>
  <tr>
    <td colspan="2" class="columna_titulo_resultados"><strong>Informaci&oacute;n General del Proceso  | Consecutivo del proceso
      <?=$sql_e[22];?>
    </strong></td>
  </tr>
  <tr>
    <td class="columna_subtitulo_resultados"><div align="right"><strong>Estado del proceso:</strong></div></td>
    <td class="texto_paginador_proveedor"><?=listas_sin_select($tp1,$sql_e[1],1);?></td>
  </tr>
  <tr>
    <td width="21%" class="columna_subtitulo_resultados"><div align="right"><strong> Tipo de proceso:</strong></div></td>
    <td width="79%" class="filas_resultados"><strong class="filas_resultados" >
      <?=listas_sin_select($tp2,$sql_e[2],1);?>
    </strong></td>
  </tr>
  <tr>
    <td class="columna_subtitulo_resultados"><div align="right"><strong>Tipo de solicitud:</strong></div></td>
    <td ><strong>
      <?=listas_sin_select($tp3, $sql_e[3], 1);?>
    </strong></td>
  </tr>
  <tr>
    <td class="columna_subtitulo_resultados"><div align="right"><strong>Persona de contacto:</strong></div></td>
    <td class="filas_resultados"><?=listas_sin_select($t1, $sql_e[15], 1);?></td>
  </tr>
  <tr>
    <td class="columna_subtitulo_resultados"><div align="right"><strong>
      <?=$lenguaje_0;?>
      :</strong></div></td>
    <td ><strong>
      <?=$sql_e[12];?>
    </strong></td>
  </tr>
</table>
<br>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td width="302" class="titulo_tabla_azul_sin_bordes"><strong>Grupo</strong></td>
    <td width="513" class="titulo_tabla_azul_sin_bordes"><strong>Criterio</strong></td>
    <td width="48" class="titulo_tabla_azul_sin_bordes"><strong>Ofertas</strong></td>
    <td width="97" class="titulo_tabla_azul_sin_bordes"><div align="center"><strong>Acciones</strong></div></td>
  </tr>
  <?
  $grupo_terminos = query_db("select distinct $t89.rel9_detalle,$t89.rel9_id from $t89, $t90, $t91
	 where $t91.in_id = $id_invitacion and $t90.rel10_id  = $t91.rel10_id and $t89.rel9_id = $t90.rel9_id and $t89.rel9_aspecto=2");
	 while($l_grupo=traer_fila_row($grupo_terminos)){  
  ?>
  <tr>
    <td class="tabla_sin_borde_fondo_gris"><?=$l_grupo[0];?></td>
    <td class="tabla_sin_borde_fondo_gris">&nbsp;</td>
    <td class="tabla_sin_borde_fondo_gris">&nbsp;</td>
    <td class="tabla_sin_borde_fondo_gris">&nbsp;</td>
  </tr>
  <?
	//---------------------------------------------------------------------------------------------------------------
  $grupo_criterio = query_db("select $t90.rel10_detalle,$t91.evaluador1_id from $t89, $t90, $t91
	 where $t91.in_id = $id_invitacion and $t90.rel10_id  = $t91.rel10_id and $t89.rel9_id = $t90.rel9_id and $t90.rel9_id = $l_grupo[1]");
	 while($l_criterio=traer_fila_row($grupo_criterio)){  

	  $cuenta_archivos = traer_fila_row(query_db("select count(*) from ".$t96." where evaluador1_id = $l_criterio[1] 
	  and pv_id = ".$_SESSION["id_proveedor"]." and evaluador6_nombre !=''"));

	  $cuenta_observa = traer_fila_row(query_db("select count(*) from ".$t96." where evaluador1_id = $l_criterio[1] 
	  and pv_id = ".$_SESSION["id_proveedor"]." and evaluador6_observaciones !=''"));
		
		$si_no = ($cuenta_archivos[0]+$cuenta_observa[0]);
		  
	  if($si_no>=1)
	  	$ima_archivo='<img src="../imagenes/botones/icono_aceptar.gif" alt="El criterio tiene por lo menos un archivo" />';
	 else
	 	$ima_archivo='<img src="../imagenes/botones/icono_X.gif" alt="El criterio NO tiene archivos" />';


//---------------------------------------------------------------------------------------------------------------
  ?>
  <tr  onmouseover="this.className=&quot;tabla_menu_relover&quot;;" onMouseOut="this.className=&quot;&quot;;">
    <td>&nbsp;</td>
    <td><?=$l_criterio[0];?></td>
    <td align="center"><?=$ima_archivo;?></td>
    <td align="center"><input name="button7" type="button" class="buscar" id="button7" value="Anexar Oferta" onClick="ajax_carga('oferta_invitacion_tecnica_<?=$id_invitacion_pasa;?>_<?=arreglo_pasa_variables($l_criterio[1]);?>_2.php','contenidos')"/></td>
  </tr>
  <? } // busca crirerios?>
  <? } ?>
</table>
<br>
<table width="98%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td><div align="center">
      <input name="button" type="button" class='cancelar' id="button" onClick="ajax_carga('detalle_invitacion_<?=$id_invitacion_pasa;?>.php','contenidos')" value="Volver a la informaci&oacute;n de la invitaci&oacute;n">
    </div>      <div align="center"></div></td>
  </tr>
</table>
<br>
<label></label>
<br>
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
<input type="hidden" name="us_cliente_pasa"  value="<?=$linvi[1];?>">
<input type="hidden" name="id_anexo">
</body>
</html>
