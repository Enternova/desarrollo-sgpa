<? include("../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	//verifica_menu("procesos.html");

 $id_invitacion = elimina_comillas(arreglo_recibe_variables($pasa));

	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));


//filtros
if($filtro_ip!=0)
$complemnto_filtro.=" and ip = '$filtro_ip' ";
if($filtro_usuario!=0)
$complemnto_filtro.=" and pv_id = $filtro_usuario ";
if( ($filtro_categoria!=1) && ($filtro_categoria!="") )
$complemnto_filtro.=" and modulo = '$filtro_categoria' ";	



//paguinacion
$numero_pagi = 30;
if ($pag=="")
	$pag = 1;
else
	$pag = $pag;

$paginador = (($pag-1)*$numero_pagi);


	  $li_n_c=traer_fila_row(query_db("select count(*) from v_ingresos_al_proceso where pro1_id =  $id_invitacion $complemnto_filtro	 "));
		  $total_r = $li_n_c[0];
		  $pagina = ceil($total_r /$numero_pagi);

if($pag==($pagina))
	$proxima = $pag;
else
	$proxima = $pag +1;
	
if($pag==1)
	$anterior = $pag;
else
	$anterior = $pag -1;
	
?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">SECCION: OBSERVADOR DE PROCESOS DE CONTRATACION</td>
  </tr>
</table>
<BR>

<table width="900" border="0" cellpadding="4" cellspacing="4">
  <tr>
    <td width="30%" height="26"><div align="left"><span class="titulos_tabla_detalle">Consecutivo del proceso:</span><?=$sql_e[22];?></div></td>
    <td width="22%"><span class="titulos_tabla_detalle">Tipo de proceso:
      </span><?=listas_sin_select($tp2,$sql_e[2],1);?>    </td>
  </tr>
  <tr>
    <td height="26" colspan="2"><div align="justify"><span class="titulos_tabla_detalle">Detalle y cantidad del objeto a contratar:</span><?=$sql_e[12];?></div></td>
  </tr>
</table>
<table width="98%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="8" class="titulos_evaluacion">Auditoria ingresos al  proceso
      <div align="left"></div></td>
  </tr>
  <tr>
    <td width="21%" class="titulos_evaluacion">&nbsp;</td>
    <td width="21%" class="titulos_evaluacion"><input name="button" type="button" class="buscar" id="button" value="Resumen del proceso" onClick="ajax_carga('../aplicaciones/resumen_proceso_obsevador.php?pasa=<?=$pasa;?>','contenidos')"></td>
    <td width="21%" class="titulos_evaluacion"><input name="button5" type="button" class="buscar" id="button5" value="Auditoria del proceso" onClick="ajax_carga('../aplicaciones/auditoria_proceso_historico.php?pasa=<?=$pasa;?>','contenidos')"></td>
    <td width="21%" class="titulos_evaluacion"><div align="right">
      <input name="button4" type="button" class="buscar" id="button4" value="Aclaraciones / notificaciones" onClick="ajax_carga('../aplicaciones/auditoria_aclaraciones.php?pasa=<?=$pasa;?>','contenidos')">
    </div></td>
    <td width="21%" class="titulos_evaluacion"><input name="button6" type="button" class="buscar" id="button6" value="E-mail enviados" onClick="ajax_carga('../aplicaciones/auditoria_email_enviados.php?pasa=<?=$pasa;?>','contenidos')"></td>
    <td width="20%" class="titulos_evaluacion"><div align="right">
      <input name="button2" type="button" class="buscar" id="button2" value="Bit&aacute;cora del proceso" onClick="ajax_carga('../aplicaciones/auditoria_bitacora_historico.php?pasa=<?=$pasa;?>','contenidos')">
    </div></td>
    <td width="17%"><span class="titulos_evaluacion">
      <input name="button8" type="button" class="buscar" id="button8" value="Ingresos al  proceso" onClick="ajax_carga('../aplicaciones/auditoria_proceso_ingresos.php?pasa=<?=$pasa;?>','contenidos')">
    </span></td>
    <td width="17%"><input name="button" type="button" class="cancelar" id="button" value="Volver  al hist&oacute;rico" onClick="ajax_carga('../aplicaciones/historico_procesos.php','contenidos')"></td>
  </tr>
</table>
<br>
<table width="98%" border="0">
  <tr>
    <td class="titulos_procesos">REPORTE DE ACLARACIONES FINALES</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/auditoria_aclaraciones.php?pasa=<?=$pasa;?>','contenidos')">Ver cartelera de aclaraciones</a> | <a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/auditoria_comunicados.php?pasa=<?=$pasa;?>','contenidos')">Ver comunicados generales</a></td>
  </tr>
</table>
<div id="carga_resultados_principales">
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td width="29%" class="columna_titulo_resultados">Asunto</td>
    <td width="15%" class="columna_titulo_resultados">Envio</td>
    <td width="27%" class="columna_titulo_resultados">Enviado a</td>
    <td width="11%" class="columna_titulo_resultados">Fecha limite</td>
    <td width="4%" class="columna_titulo_resultados">Leido</td>
    <td width="4%" class="columna_titulo_resultados">Resp.</td>
    <td width="10%" class="columna_titulo_resultados">&nbsp;</td>
  </tr>
  <?
			  	$sele_car="select pro16_id, objeto, fecha_solicitud, razon_social, fecha_limite_respuesta, if(leida=1,'No', 'Si') from $v7 where pro1_id = $id_invitacion order by pv_id, fecha_solicitud desc";
				$sql_ex_c=query_db($sele_car);
				while($ls_c=traer_fila_row($sql_ex_c)){
		if($num_fila_gene%2==0)
				$class_g="campos_blancos_listas";
			else
				$class_g="campos_gris_listas";
				
				$cuenta_respuestas = traer_fila_row(query_db("select count(*) from $t28 where pro16_id = $ls_c[0]"));
  ?>
  <tr class="<?=$class_g;?>">
    <td><?=nl2br($ls_c[1]);?></td>
    <td><div align="left">
      <?=fecha_for_hora($ls_c[2]);?>
    </div></td>
    <td><div align="left">
      <?=$ls_c[3];?>
    </div></td>
    <td><div align="left">
      <?=fecha_for_hora($ls_c[4]);?>
    </div></td>
    <td><div align="left">
      <?=$ls_c[5];?>
    </div></td>
    <td><div align="left">
      <?=number_format($cuenta_respuestas[0],0);?>
    </div></td>
    <td><input name="button7" type="button" class="buscar" id="button7" onClick="ajax_carga('../aplicaciones/auditoria_respuesta_aclaraciones_finales.php?id_pregunta=<?=$ls_c[0];?>&id_invitacion_pasa=<?=$pasa;?>','carga_resultados_principales')" value="Ver Respuestas"></td>
  </tr>
  <tr>
    <td colspan="7" id="div_for_<?=$ls_c[0];?>" style="display:none">&nbsp;</td>
  </tr>
  <? 
				  
				 $num_fila_gene++; } ?>
</table>
</div>
<input type="hidden" name="pasa" value="<?=arreglo_pasa_variables($id_invitacion);?>">
<input type="hidden" name="ocu_re">
</body>
</html>
