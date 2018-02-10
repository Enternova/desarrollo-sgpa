<? include("../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	//verifica_menu("procesos.html");

 $id_invitacion = elimina_comillas(arreglo_recibe_variables($pasa));

	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));
	 

	
?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
<div id="carga_evaluacion">
  <table width="100%" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td class="titulos_procesos">SECCION: OBSERVADOR DE PROCESOS DE CONTRATACION</td>
    </tr>
  </table>
  <BR>
  <table width="99%" border="0" cellpadding="4" cellspacing="4">
    <tr>
      <td width="30%" height="26"><div align="left"><span class="titulos_tabla_detalle">Consecutivo del proceso:</span>
            <?=$sql_e[22];?>
      </div></td>
      <td width="22%"><span class="titulos_tabla_detalle">Tipo de proceso: </span>
          <?=listas_sin_select($tp2,$sql_e[2],1);?>      </td>
    </tr>
    <tr>
      <td height="26" colspan="2"><div align="justify"><span class="titulos_tabla_detalle">Detalle y cantidad del objeto a contratar:</span>
            <?=$sql_e[12];?>
      </div></td>
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
      <td width="17%"><input name="button7" type="button" class="cancelar" id="button7" value="Volver  al hist&oacute;rico" onClick="ajax_carga('../aplicaciones/historico_procesos.php','contenidos')"></td>
    </tr>
  </table>
  <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td colspan="9" class="columna_titulo_resultados"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18"> Resumen de acciones y ofertas enviadas por el proveedor.</td>
              </tr>
              <tr>
                <td width="48%" class="columna_subtitulo_resultados">Nombre</td>
                <td width="7%" class="columna_subtitulo_resultados">Visualiza proceso</td>
                <td width="10%" class="columna_subtitulo_resultados">Confirma participaci&oacute;n</td>
                <td width="7%" class="columna_subtitulo_resultados">Ofertas t&eacute;cnicas</td>
                <td width="9%" class="columna_subtitulo_resultados">Ofertas comerciales</td>
                <td width="12%" class="columna_subtitulo_resultados">Ofertas ec&oacute;nomicas</td>
                <td width="12%" class="columna_subtitulo_resultados">Cartelera y notificaciones pendientes de lectura</td>
                <td width="12%" class="columna_subtitulo_resultados">Documentos pendientes de descarga</td>
                <td width="7%" class="columna_subtitulo_resultados">&nbsp;</td>
              </tr>
              
              <?
			  
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id");
				while($lp = traer_fila_row($busca_provee)){
			
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
			$documentos_faltantes = 0;
			$busca_ingresos = traer_fila_row(query_db("select * from $t36 where pro1_id = $id_invitacion and pv_id = ".$lp[0]));
			$busca_confirmacion = traer_fila_row(query_db("select confirmacion  from v_confirmacion where pro1_id = $id_invitacion and pv_id = $lp[0] order by pro4_id desc"));
			$busca_ofertas_tecnicas=traer_fila_row(query_db("select if(count(*)>=1,'Si', 'No') from $v10 where pro1_id = $id_invitacion and pv_id = $lp[0] and termino = 2  "));
			$busca_ofertas_comercial=traer_fila_row(query_db("select if(count(*)>=1,'Si', 'No') from $v10 where pro1_id = $id_invitacion and pv_id = $lp[0] and termino = 1  "));
			$busca_ofertas_economica=traer_fila_row(query_db("select if(count(*)>=1,'Si', 'No') from $v11 where in_id  = $id_invitacion and pv_id = $lp[0] and w_valor != ''  "));
			$busca_comuniocados_faltantes = traer_fila_row(query_db("select count(*) from $t29 where pro1_id = $id_invitacion and pv_id = $lp[0] and tp13_id  in (1,2,3,4) and estado = 1 and quien_ingresa != 'Proveedor'"));
			$busca_docuemntos_anexos=traer_fila_row(query_db("select count(*) from $t6 where pro1_id = $id_invitacion"));
			$busca_docuemntos_descagados=traer_fila_row(query_db("select count(distinct detalle) from $v5 where pro1_id = $id_invitacion and auditor_categoria_id = 3 and pv_id = $lp[0]"));
			$documentos_faltantes = ($busca_docuemntos_anexos[0]-$busca_docuemntos_descagados[0]);
							
			if($busca_confirmacion[0]=='')	$estado_conf="N / C";
			else $estado_conf=$busca_confirmacion[0];
  ?>
  <tr class="<?=$class;?>">
  
                <td><?=$lp[2];?></td>
                <td><?=$busca_ingresos[4];?></td>
                <td><div align="center"><?=$estado_conf;?></div></td>
                <td><div align="center"><?=$busca_ofertas_tecnicas[0];?></div></td>
                <td><div align="center"><?=$busca_ofertas_comercial[0];?></div></td>
                <td><div align="center"><?=$busca_ofertas_economica[0];?></div></td>
                <td><div align="center"><?=$busca_comuniocados_faltantes[0];?></div></td>
                <td><div align="center"><?=$documentos_faltantes;?> de <?=$busca_docuemntos_anexos[0];?></div></td>
                <td><div align="center">
                  <input name="button3" type="button" class="buscar_ajustado" id="button3" onClick="ajax_carga('../aplicaciones/resumen_proceso_obsevador_detalle.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lp[0];?>','carga_evaluacion')" value="Ver" />
    </div></td>
  </tr>
              <? $num_fila++;
			  
			  } ?>
  </table>
  
</div>
</body>
</html>
