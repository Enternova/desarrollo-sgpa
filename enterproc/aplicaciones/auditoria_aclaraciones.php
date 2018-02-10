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
    <td class="titulos_procesos">REPORTE DE CARTELERA DE ACLARACIONES</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/auditoria_comunicados.php?pasa=<?=$pasa;?>','contenidos')">Ver comunicados generales</a> | <a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/auditoria_aclaraciones_finales.php?pasa=<?=$pasa;?>','contenidos')">Ver aclaraciones finales</a></td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr class="columna_titulo_resultados">
    <td width="23%">Solicitante</td>
    <td width="10%">Fecha de pregunta</td>
    <td width="44%">Pregunta</td>
    <td width="6%">Tipo</td>
    <td width="8%">Anexo</td>
    <td width="9%">Admin</td>
  </tr>
  <?
			  	$sele_car="select * from $t15 where pro1_id = $id_invitacion and tipo_aclaracio  = 1  order by fecha_pregunta desc";
				$sql_ex_c=query_db($sele_car);
				while($ls_c=traer_fila_row($sql_ex_c)){
		if($num_fila_gene%2==0)
				$class_g="campos_blancos_listas";
			else
				$class_g="campos_gris_listas";
				
				if($ls_c[7]==2) $solicitante = "HOCOL SA";
				else{
					$pv_id_pr_p = explode("|",$ls_c[2]);
					$busca_proveedor = traer_fila_row(query_db("select pv_id, razon_social from pv_proveedores where pv_id = $pv_id_pr_p[0]"));
					$solicitante= $busca_proveedor[1];
				}

				if($ls_c[10]==1) { $tipo_soli = "Economico";  }
				elseif($ls_c[10]==2) $tipo_soli = "Tecnico";
				elseif($ls_c[10]==3) $tipo_soli = "Lista de precios";				
				elseif($ls_c[10]==4) $tipo_soli = "Todas";								
				$ext="";
				$ext=extencion_archivos($ls_c[11]);

  ?>
  <tr class="<?=$class_g;?>">
    <td><?=$solicitante;?></td>
    <td><div align="center">
      <?=fecha_for_hora($ls_c[3]);?>
    </div></td>
    <td><div align="left">
      <?=$ls_c[4];?></td>
    <td><?=$tipo_soli;?></td>
    <td><? if($ext!=""){ ?>
      <img src="../imagenes/mime/<?=$ext;?>.gif" onClick="window.parent.location.href='../librerias/php/descarga_documentos_cartelera_pregunta.php?n1=<?=$ls_c[0];?>&n2=<?=$ls_c[11];?>'" >
      <? } ?></td>
    <td><input name="button7" type="button" class="buscar" id="button7" onClick="ver_respuestas('div_for_<?=$ls_c[0];?>')" value="Respuestas"></td>
  </tr>
  <tr>
    <td colspan="6" id="div_for_<?=$ls_c[0];?>" style="display:none"><table width="95%" border="0" align="right" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
      <tr class="<?=$class;?>">
        <td>&nbsp;</td>
        <td class="columna_subtitulo_resultados"><strong>Fecha de envio</strong></td>
        <td class="columna_subtitulo_resultados"><strong>Detalle del comunicado / pregunta</strong></td>
        <td class="columna_subtitulo_resultados"><strong>Anexo</strong></td>
      </tr>
      <?
			  	$sele_car_foro="select pro8_id ,pro7_id,tipo_preg_respuesta ,us_id ,pv_id ,fecha_foro ,foro ,publica,if(publica=0,'Privada','Publica'),anexo  from $t16 where pro7_id = $ls_c[0]  order by fecha_foro  desc";
				$sql_ex_c_foro=query_db($sele_car_foro);
				while($ls_c_f=traer_fila_row($sql_ex_c_foro)){
				
				
		
								
									
				if($ls_c_f[4]==0) { $imagen = "respuesta_f.png"; $solicitante_foro = "GTEC"; }
				else  {$imagen =  "pregunta_f.png"; 
									
					$busca_proveedor = traer_fila_row(query_db("select pv_id, razon_social from pv_proveedores where pv_id = $ls_c_f[4]"));
					$solicitante_foro= $busca_proveedor[1];

				 }
				
		if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
				
				$ext="";
				$ext=extencion_archivos($ls_c_f[9]);

  ?>
      <tr class="<?=$class;?>">
        <td width="4%"><div align="right"><img src="../imagenes/botones/<?=$imagen;?>" width="24" height="24"></div></td>
        <td width="18%"><div align="center">
          <?=fecha_for_hora($ls_c_f[5]);?>
        </div></td>
        <td width="79%"><div align="left">
          <?=$ls_c_f[6];?>
        </div></td>
        <td width="1%"><? if($ext!=""){ ?>
          <img src="../imagenes/mime/<?=$ext;?>.gif" onClick="window.parent.location.href='../librerias/php/descarga_documentos_cartelera.php?n1=<?=$ls_c_f[0];?>&n2=<?=$ls_c_f[9];?>'" >
          <? } ?></td>
      </tr>
      <? $num_fila++;} ?>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td><div align="center">&nbsp;
          <input name="button7" type="button" class="cancelar" id="button9" value="Cerrar respuestas" onClick="oculat_respuestas('div_for_<?=$ls_c[0];?>')">
          </div></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
  </tr>
  <? 
				  
				 $num_fila_gene++; } ?>
</table>
<input type="hidden" name="pasa" value="<?=arreglo_pasa_variables($id_invitacion);?>">
<input type="hidden" name="ocu_re">
</body>
</html>
