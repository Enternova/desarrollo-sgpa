<? include("../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	//verifica_menu("procesos.html");

 $id_invitacion = elimina_comillas(arreglo_recibe_variables($pasa));

	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));


//filtros
if($filtro_ip!=0)
$complemnto_filtro.=" and sub_proceso = $filtro_ip ";
if($filtro_usuario!=0)
$complemnto_filtro.=" and us_id = $filtro_usuario ";
if($filtro_categoria!=0)
$complemnto_filtro.=" and auditor_categoria_id = $filtro_categoria ";	



//paguinacion
$numero_pagi = 30;
if ($pag=="")
	$pag = 1;
else
	$pag = $pag;

$paginador = (($pag-1)*$numero_pagi);


	  $li_n_c=traer_fila_row(query_db("select count(*) from $v5 where pro1_id =  $id_invitacion $complemnto_filtro	 "));
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
    <td width="17%"><input name="button7" type="button" class="cancelar" id="button7" value="Volver  al hist&oacute;rico" onClick="ajax_carga('../aplicaciones/historico_procesos.php','contenidos')"></td>
  </tr>
</table>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td colspan="5" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
                  <tr>
                    <td width="77%"><div align="left"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18"> Se muestra en detalle cualquier acci&oacute;n realizada a este proceso.</div></td>
                    <td width="6%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/auditoria_proceso_historico.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
                    <td width="10%"><label>
                      <select name="pagij" onChange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/auditoria_proceso_historico.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
                        <? 
		  for($i=1;$i<=$pagina;$i++){
		   ?>
                        <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
                          <?=$i;?>
                        </option>
                        <? } ?>
                      </select>
                    </label></td>
                    <td width="7%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/auditoria_proceso_historico.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
                  </tr>
                </table>                </td>
              </tr>
              <tr>
                <td width="18%" class="columna_subtitulo_resultados">Accion</td>
                <td width="17%" class="columna_subtitulo_resultados">Nombre usuario</td>
                <td width="15%" class="columna_subtitulo_resultados">Fecha</td>
                <td width="38%" class="columna_subtitulo_resultados">Comentarios</td>
                <td width="12%" class="columna_subtitulo_resultados">IP de conexion</td>
              </tr>
              <tr>
                <td class="columna_subtitulo_resultados">
                  <select name="filtro_categoria" id="filtro_categoria" onChange="busqueda_paginador_nuevo(1,'../aplicaciones/auditoria_proceso_historico.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
                  <option value="0">Filtro</option>
                    <?
			  	
			  	$busca_provee = query_db("select distinct auditor_categoria_id, nombre from $v5 where pro1_id =  $id_invitacion ");
				while($lp = traer_fila_row($busca_provee)){ 
				if($lp[0]==$filtro_categoria) $selecciona = "selected";
				else  $selecciona = "";		

													
				
				?>
                <option value="<?=$lp[0];?>" <?=$selecciona;?>><?=$lp[1];?></option>
				
				<?
					}
				?>
                  </select>                </td>
                <td class="columna_subtitulo_resultados">
                <select name="filtro_usuario" id="filtro_usuario" onChange="busqueda_paginador_nuevo(1,'../aplicaciones/auditoria_proceso_historico.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
                  <option value="0">Filtro</option>
                    <?
			  	
			  	$busca_provee = query_db("select distinct us_id, nombre_administrador from $v5 where pro1_id =  $id_invitacion ");
				while($lp = traer_fila_row($busca_provee)){ 
				if($lp[0]==$filtro_usuario) $selecciona = "selected";
				else  $selecciona = "";				
				

				
				?>
                <option value="<?=$lp[0];?>" <?=$selecciona;?>><?=$lp[1];?></option>
				
				<?
					}
				?>
                  </select>                </td>
                <td class="columna_subtitulo_resultados">&nbsp;</td>
                <td class="columna_subtitulo_resultados">&nbsp;</td>
                <td class="columna_subtitulo_resultados"> 
                <select name="filtro_ip" id="filtro_ip" onChange="busqueda_paginador_nuevo(1,'../aplicaciones/auditoria_proceso_historico.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
                  <option value="0">Filtro</option>
                    <?
			  	
			  	$busca_provee = query_db("select distinct sub_proceso from $v5 where pro1_id =  $id_invitacion ");
				while($lp = traer_fila_row($busca_provee)){ 
				if($lp[0]==$filtro_ip) $selecciona = "selected";
				else  $selecciona = "";		
				
		
				
				?>
                <option value="<?=$lp[0];?>" <?=$selecciona;?>><?=$lp[0];?></option>
				
				<?
					}
				?>
                  </select></td>
              </tr>
              
              <?
			  	
			  	$busca_provee = query_db("select * from $v5 where pro1_id =  $id_invitacion $complemnto_filtro order by fecha_hora desc limit $paginador,$numero_pagi ");
				while($lp = traer_fila_row($busca_provee)){
				  
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";

	if( ($lp[0]==37) || ($lp[0]==38) )
		$comple=$lp[9];
	else $comple="";
				
  ?>
  <tr class="<?=$class;?>">
  
                <td><?=$lp[1];?></td>
                <td><?=$lp[5];?></td>
                <td><?=$lp[8];?></td>
                <td><?=$lp[9];?></td>
                <td><?=$lp[10];?></td>
  </tr>
              <? $num_fila++;
			 
			  } ?>
  </table>

<input type="hidden" name="pasa" value="<?=arreglo_pasa_variables($id_invitacion);?>">
</body>
</html>
