<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    //verifica_menu("procesos.html");

//$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	
	
	 $busca_procesos = "select * from $t5 where cd_id_entrega_documentos = $id_item_pecc";
	$sql_e=traer_fila_row(query_db($busca_procesos));
$id_invitacion = $sql_e[0];
	$busca_confirmacion = traer_fila_row(query_db("select * from $t9 where  pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." order by fecha desc"));

?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css">
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
</style>
</head>
<body >
<div id="detalle_item_evaluacion">





<table width="98%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="88%" class="titulos_resaltado_procesos_tarifas">RESUMEN DE ADJUDICACION DESDE EL MODULO URNA VIRTUAL</td>
    <td width="12%" align="right">
      <input name="button2" type="button" class="boton_volver" id="button2" value="Volver  al ITEM" onClick="ajax_carga('../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&aplica_log=no','contenidos')">
    </td>
  </tr>
</table>
<BR>
<br>

<div id="carga_resultados_principales">

<?
	$mustera_expor=0;
	$busca_provee_ad = traer_fila_row(query_db("select count(*) from $v13 where pro1_id =  $id_invitacion and estado = 1 order by razon_social "));
	if($busca_provee_ad[0]>=1){//si exiten adjudicados
	$mustera_expor=1;
?>
<br>
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="8" class="columna_subtitulo_resultados"><strong>Proveedores adjudicados</strong></td>
  </tr>
  <tr>
    <td width="3%" class="columna_titulo_resultados">&nbsp;</td>
    <td class="columna_titulo_resultados"><div align="center"><strong>Proveedor </strong></div>      <div align="center"></div>      <div align="center"></div></td>
    <td class="columna_titulo_resultados"><strong>Fecha env&iacute;o</strong></td>
    <td class="columna_titulo_resultados"><strong><? if($sql_e[3]==1) echo "Documento"; else echo "Adjudicaci&oacute;n"; ?></strong></td>
    <td class="columna_titulo_resultados"><strong>Aceptaci&oacute;n</strong></td>
    <td width="10%" class="columna_titulo_resultados"><div align="center"><strong>Comentarios</strong></div></td>
    <td class="columna_titulo_resultados"><div align="center"><strong>Visualizaci&oacute;n</strong></div></td>
    <td width="4%" class="columna_titulo_resultados"><div align="center"><strong>Ver </strong></div></td>
  </tr>
  <tr>
    <td class="columna_titulo_resultados"><div align="center"><img src="../imagenes/botones/help.gif" alt="Indica si ya se envi&oacute; o no la notificaci&oacute;n al proveedor" width="18" height="18" title="Indica si ya se envi&oacute; o no la notificaci&oacute;"></div></td>
    <td width="36%" class="columna_titulo_resultados"><div align="center">&nbsp;</div></td>
    <td width="14%" class="columna_titulo_resultados"><img src="../imagenes/botones/help.gif" alt="Se refiere al n&uacute;mero de comentarios enviados por el proveedor o por HOCOL" width="18" height="18" title="Se refiere al n&uacute;mero de comentarios enviados por el proveedor o por HOCOL"></td>
    <td width="9%" class="columna_titulo_resultados"><div align="center">&nbsp;</div></td>
    <td width="8%" class="columna_titulo_resultados"><div align="center">&nbsp;</div></td>
    <td class="columna_titulo_resultados"><div align="center"><img src="../imagenes/botones/help.gif" alt="Se refiere al n&uacute;mero de comentarios enviados por el proveedor o por HOCOL" width="18" height="18" title="Se refiere al n&uacute;mero de comentarios enviados por el proveedor o por HOCOL"></div></td>
    <td width="16%" class="columna_titulo_resultados"><div align="center"><img src="../imagenes/botones/help.gif" alt="Se refiere a la &uacute;ltima vez que el proveedor ingreso y vio la carta de aceptaci&oacute;n de t&eacute;rminos" width="18" height="18" title="Se refiere a la &uacute;ltima vez que el proveedor ingreso y vio la carta de aceptaci&oacute;n de t&eacute;rminos"></div></td>
    <td class="columna_titulo_resultados">&nbsp;</td>
  </tr>
  <?

	


			  	$busca_provee = query_db("select pro27_id, pro1_id, pv_id, razon_social,documento,fecha_entrega,contacto,pro25_id, estado, acepta_terminos,fecha_envio from $v13 where pro1_id =  $id_invitacion and estado = 1 order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){
				$icono_enviado_a="";
				$estado_acep="";
				 $buscar_notificaciones_a = "select * from $t46 where pro1_id = $id_invitacion and tipo_adj_no_adj  = 1 and pv_id = $lp[2] and pro27_id = $lp[0]";
			  	$sql_ex_adjudicados=traer_fila_row(query_db($buscar_notificaciones_a));

					$visualizacion = traer_fila_row(query_db("select fecha_lectura from $t47 where pro30_id = $sql_ex_adjudicados[0] order by fecha_lectura"));
			  
				if($sql_ex_adjudicados[7]==1)//si ya fue notificado y requiere	
					$icono_enviado_a ='<img src="../imagenes/botones/icono_aceptar.gif" alt="Se notifico al proveedor" width="18" height="18" title="Se notifico al proveedor">';
				if($sql_ex_adjudicados[7]=="")//si ya fue notificado y requiere	
					$icono_enviado_a =' <img src="../imagenes/botones/icono_X.gif" alt="Pendiente de notificacion" width="18" height="18" title="Pendiente de notificacion">';
				
				if($lp[9]==0) $estado_acep="Pendiente";
				elseif($lp[9]==1) $estado_acep="Si acepta";
				elseif($lp[9]==2) $estado_acep="No acepta";		
				
				$busca_hi_com = traer_fila_row(query_db("select count(*) from $vt16 where pro27_id = $lp[0]"));		
				
				         if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";
				
  ?>
  <tr class="<?=$class;?>">
    <td><?=$icono_enviado_a;?></td>
    <td><?=$lp[3];?></td>
    <td><?=fecha_for_hora($lp[10]);?></td>
    <td><?=$lp[4];?></td>
    <td>
      <div align="left">
        <?=$estado_acep;?>
      </div></td>
    <td>
      <div align="center">
      <?=$busca_hi_com[0];?></div></td>
    <td><div align="center">
      <?=fecha_for_hora($visualizacion[0]);?>
    </div></td>
    <td align="center"><img src="../imagenes/botones/editar_c.png"  title="Ver informaci&oacute;n detallada" alt="Ver informaci&oacute;n detallada" width="16" height="16" longdesc="Ver informaci&oacute;n detallada" onClick="ajax_carga('../enterproc/aplicaciones/evaluacion/adjudicacion_paso6_sgpa.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lp[2];?>&id_notificacion=<?=$sql_ex_adjudicados[0];?>&pro27_id=<?=$lp[0];?>&id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&aplica_log=no','contenidos')"></td>
  </tr>
  <? $num_fila++;} ?>
</table>
<? } // si existen adjudicados?>
<br>

<?

		  $busca_provee_adju = query_db("select pv_id from $v13 where pro1_id =  $id_invitacion and estado = 1 ");
				while($lp_a = traer_fila_row($busca_provee_adju))
					$not_in .=",".$lp_a[0];
			
	
			  	$busca_provee_noad = traer_fila_row(query_db("select count(*) from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 2 and notificado <> 3  order by razon_social "));
if($busca_provee_noad[0]>=1){//si exiten no adjudicados			
$mustera_expor=1;
?>
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="6" class="columna_subtitulo_resultados"><strong>Proveedores NO adjudicados y con Env&iacute;o de notificaci&oacute;n</strong></td>
  </tr>
  <tr>
    <td width="3%" class="columna_titulo_resultados">&nbsp;</td>
    <td width="25%" class="columna_titulo_resultados"><strong>Nombre proveedor</strong></td>
    <td width="32%" class="columna_titulo_resultados"><div align="left"><strong>Comentarios</strong></div></td>
    <td width="17%" class="columna_titulo_resultados"><strong>Fecha Env&iacute;o</strong></td>
    <td width="20%" class="columna_titulo_resultados"><strong>Visualizaci&oacute;n</strong></td>
    <td width="3%" class="columna_titulo_resultados"><strong>Ver</strong></td>
  </tr>
  <?
			
			$num_fila=1;
	
			  	$busca_provee = query_db("select pro30_id, pv_id, razon_social, fecha_envio,observacion_admin from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 2 and notificado <> 3  order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){
				$icono_enviado="";
				 
					$icono_enviado ='<img src="../imagenes/botones/icono_aceptar.gif" alt="Se notifico al proveedor" width="18" height="18" title="Se notifico al proveedor">';
					$visualizacion = traer_fila_row(query_db("select fecha_lectura from $t47 where pro30_id = $lp[0] order by fecha_lectura"));

     if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";
			  ?>
    <tr class="<?=$class;?>">
    <td><?=$icono_enviado;?></td>
    <td><?=$lp[2];?></td>
    <td><?=$lp[4];?></td>
    <td><?=fecha_for_hora($lp[3]);?></td>
    <td><div align="center">
      <?=fecha_for_hora($visualizacion[0]);?>
    </div></td>
    <td><img src="../imagenes/botones/editar_c.png"  title="Ver informaci&oacute;n detallada" alt="Ver informaci&oacute;n detallada" width="16" height="16" longdesc="Ver informaci&oacute;n detallada" onClick="ajax_carga('../enterproc/aplicaciones/evaluacion/adjudicacion_paso7_sgpa.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lp[1];?>&id_notificacion=<?=$lp[0];?>&id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&aplica_log=no','contenidos')">    </td>
  </tr>
  <? $num_fila++;} ?>
</table>
<? } //si exiten no adjudicados ?>
<br>

<? 

$busca_provee_noad_sin_en = traer_fila_row(query_db("select count(*) from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 2 and notificado = 3  order by razon_social "));
				
if($busca_provee_noad_sin_en[0]>=1){//si no exiten sin envios		
$mustera_expor=1;		
?>				
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" class="columna_subtitulo_resultados"><strong>Proveedores NO adjudicados y sin env&iacute;o de notificaci&oacute;n</strong></td>
  </tr>
  <tr>
    <td width="3%" class="columna_titulo_resultados">&nbsp;</td>
    <td width="41%" class="columna_titulo_resultados"><div align="left"><strong>Nombre proveedor</strong></div></td>
    <td width="53%" class="columna_titulo_resultados"><strong>Comentario del no envio</strong></td>
  </tr>
  <?
	
$num_fila=1;
	
			  	$busca_provee = query_db("select pro30_id, pv_id, razon_social, fecha_envio,observacion_admin from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 2 and notificado = 3  order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){
				$icono_enviado="";
				 
					$icono_enviado ='<img src="../imagenes/botones/icono_X.gif" alt="No requiere notificacion al proveedor" width="18" height="18" title="No requiere notificacion al proveedor">';
					$visualizacion = traer_fila_row(query_db("select fecha_lectura from $t47 where pro30_id = $lp[0] order by fecha_lectura"));

     if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";
			  ?>
  <tr class="<?=$class;?>">
    <td><?=$icono_enviado;?></td>
    <td><?=$lp[2];?></td>
    <td><?=$lp[4];?></td>
  </tr>
  <? $num_fila++;} ?>
</table>
<? } //si no exiten sin envios ?>
<br>

<?

		  $busca_provee_adju = query_db("select pv_id from $v13 where pro1_id =  $id_invitacion and estado = 1 ");
				while($lp_a = traer_fila_row($busca_provee_adju))
					$not_in .=",".$lp_a[0];
			
	
			  	$busca_provee_noad = traer_fila_row(query_db("select count(*) from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 4 and notificado <> 3  order by razon_social "));
if($busca_provee_noad[0]>=1){//si exiten no adjudicados	
$mustera_expor=1;		

?>
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="6" class="columna_subtitulo_resultados">
      <?=listas_sin_select($tp1,$sql_e[1],1);?>
    </td>
  </tr>
  <tr>
    <td width="3%" class="columna_titulo_resultados">&nbsp;</td>
    <td width="25%" class="columna_titulo_resultados"><strong>Nombre proveedor</strong></td>
    <td width="32%" class="columna_titulo_resultados"><div align="left"><strong>Comentarios</strong></div></td>
    <td width="17%" class="columna_titulo_resultados"><strong>Fecha env&iacute;o</strong></td>
    <td width="20%" class="columna_titulo_resultados"><strong>Visualizaci&oacute;n</strong></td>
    <td width="3%" class="columna_titulo_resultados"><strong>Ver</strong></td>
  </tr>
  <?
			
			$num_fila=1;
	
			  	$busca_provee = query_db("select pro30_id, pv_id, razon_social, fecha_envio,observacion_admin from $vt15 where
				pro1_id = $id_invitacion and pv_id not in (0 $not_in) and tipo_adj_no_adj = 4 and notificado <> 3  order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){
				$icono_enviado="";
				 
					$icono_enviado ='<img src="../imagenes/botones/icono_aceptar.gif" alt="Se notifico al proveedor" width="18" height="18" title="Se notifico al proveedor">';
					$visualizacion = traer_fila_row(query_db("select fecha_lectura from $t47 where pro30_id = $lp[0] order by fecha_lectura"));

     if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";
			  ?>
    <tr class="<?=$class;?>">
    <td><?=$icono_enviado;?></td>
    <td><?=$lp[2];?></td>
    <td><?=$lp[4];?></td>
    <td><?=fecha_for_hora($lp[3]);?></td>
    <td><div align="center">
      <?=fecha_for_hora($visualizacion[0]);?>
    </div></td>
    <td><img src="../imagenes/botones/editar_c.png"  title="Ver informaci&oacute;n detallada" alt="Ver informaci&oacute;n detallada" width="16" height="16" longdesc="Ver informaci&oacute;n detallada" onClick="ajax_carga('../enterproc/aplicaciones/evaluacion/adjudicacion_paso7_otros_estados_sgpa.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lp[1];?>&id_notificacion=<?=$lp[0];?>&id_item_pecc=<?=$id_item_pecc?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&aplica_log=no','contenidos')">    </td>
  </tr>
  <? $num_fila++;} ?>
</table>
<p>
  <? } //si exiten otros estados ?>
</p>

<? if($mustera_expor==1){ ?>
<table width="98%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="center"><input name="button6" type="button" class="boton_grabar_parcial" id="button6" value="Exportar acta" onClick="window.open('../enterproc/librerias/tcpdf/examples/exporta_adjudicacion.php?id_invitacion=<?=$id_invitacion;?>&campo_valos=3')"></div></td>
  </tr>
</table>
<? } ?>

<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_pasa;?>">
<input type="hidden" name="id_invitacion_pasa" value="<?=arreglo_pasa_variables($id_invitacion);?>">

<input type="hidden" name="id_anexo">
</body>
</html>
