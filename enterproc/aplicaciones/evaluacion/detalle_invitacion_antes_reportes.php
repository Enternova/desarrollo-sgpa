<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    //verifica_menu("procesos.html");

//$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	
	$id_invitacion = $id_p;
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

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





<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">SECCION: APERTURA Y EVALUACION DE PROCESOS DE CONTRATACION</td>
  </tr>
</table>
<BR>
<table width="900" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td ><div align="right"><strong>Consecutivo del proceso:</strong></div></td>
    <td><?=$sql_e[22];?></td>
    <td width="17%"><div align="right"><strong>Tipo de soicitud:</strong></div></td>
    <td width="34%"><div align="left">
      <?=listas_sin_select($tp3,$sql_e[3],1);?>
    </div></td>
  </tr>
  <tr>
    <td width="20%"><div align="right"><strong>Tipo de proceso:</strong></div></td>
    <td width="29%"><div align="left">
      <label>
        <?=listas_sin_select($tp2,$sql_e[2],1);?>
        </label>
    </div></td>
    <td colspan="2"><div align="center"><input name="button5" type="button" class="buscar" id="button5" value="Ver informaci&oacute;n completa del proceso" onClick="ajax_carga('../aplicaciones/visualiza_proceso.php?id_p=<?=$id_p;?>&ruta_ev=1','contenidos')"></div>
    <div align="left"></div></td>
  </tr>
  <tr>
    <td ><div align="right"><strong>
      <?=$lenguaje_0;?>
    :</strong></div></td>
    <td colspan="3"><div align="left">
      <?=$sql_e[12];?>
    </div></td>
  </tr>
</table>
<br>

<div id="carga_resultados_principales">
<?
	function detalle_aspecto($aspecto,$campo){
	global $id_invitacion,$v4;
	$busca_detalle_apertura = traer_fila_row(query_db("select pro1_id, $campo from $v4 where pro1_id = $id_invitacion and aspecto = $aspecto"));
	if($busca_detalle_apertura[0]>=1)
	return $busca_detalle_apertura[1];
	else
	return "Sin apertura";
}




$busca_invitaciones = query_db("select pro1_id, tipo from $t11 where us_id = ".$_SESSION["id_us_session"]." and pro1_id = $id_invitacion");	
while($busca_perimos=traer_fila_row($busca_invitaciones)){
	if($busca_perimos[1]==2) $abre_juridco=1;
	if($busca_perimos[1]==3) $abre_tecnico=1;
	if($busca_perimos[1]==4) $abre_economico=1;
	if($busca_perimos[1]==1) $abre_juridico=1;		
	
	}
	
if($sql_e[15]==$_SESSION["id_us_session"]) $permiso_total=1;
if ($_SESSION["tipo_usuario"]==1) $permiso_total=1;
if($_SESSION["tipo_usuario"]==4) $permiso_total=1;


?>

<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td  colspan="4" class="columna_titulo_resultados">APERTURA DE REQUERIMIENTOS  SOLICITADOS EN EL PROCESO</td>
    </tr>
  <tr>
    <td width="238" class="columna_subtitulo_resultados">Requerimientos</td>
    <td width="190" class="columna_subtitulo_resultados">Usuario de apertura</td>
    <td width="306" class="columna_subtitulo_resultados">Fecha apertura</td>
    <td width="136" class="columna_subtitulo_resultados">Ingresar</td>
    </tr>
 <? if( ($abre_juridco==1) || ($permiso_total==1) ){ ?>
  <? } if( ($abre_tecnico==1) || ($permiso_total==1) ){ ?>
  <tr class="campos_gris_listas">
    <td ><div align="right"><strong>Apertura t&eacute;cnica</strong></div></td>
    <td><?=detalle_aspecto(2,"nombre_administrador");?></td>
    <td><?=detalle_aspecto(2,"fecha_apertura");?></td>
    <td ><input name="button2" type="button" class="buscar_ajustado" id="button2" value="Ver ofertas" onClick="ajax_carga('../aplicaciones/evaluacion/apertura_evaluacion_tecnica.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','carga_resultados_principales')"></td>
    </tr>
  <tr>
    <td><div align="right"><strong>Apertura comercial </strong></div></td>
    <td><?=detalle_aspecto(1,"nombre_administrador");?></td>
    <td><?=detalle_aspecto(1,"fecha_apertura");?></td>
    <td><input name="button" type="button" class="buscar_ajustado" id="button" value="Ver documentos" onClick="ajax_carga('../aplicaciones/evaluacion/apertura_evaluacion_juridica.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','carga_resultados_principales')"> </td>
  </tr>
 <? } if( ($abre_economico==1) || ($permiso_total==1) ){ ?>    
  <tr class="filas_resultados">
    <td class="campos_gris_listas"><div align="right"><strong>Apertura lista de precios</strong></div></td>
    <td class="campos_gris_listas"><?=detalle_aspecto(3,"nombre_administrador");?></td>
    <td class="campos_gris_listas"><?=detalle_aspecto(3,"fecha_apertura");?></td>
    <td class="campos_gris_listas"><input name="button9" type="button" class="buscar_ajustado" id="button9" value="Ver ofertas" onClick="ajax_carga('../aplicaciones/evaluacion/apertura_evaluacion_economica.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','carga_resultados_principales')"></td>
    </tr>
     <? }  ?>    
</table>
<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td><label>
      <div align="center">
        <input name="button4" type="button" class="guardar" id="button4" value="Ver / enviar aclaraciones finales del proceso" onClick="ajax_carga('../aplicaciones/evaluacion/cartelera_aclaraciones_finales.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','carga_resultados_principales')">
        </div>
    </label></td>
  </tr>
</table>
<?
	$mustera_expor=0;
	$busca_provee_ad = traer_fila_row(query_db("select count(*) from $v13 where pro1_id =  $id_invitacion and estado = 1 order by razon_social "));
	if($busca_provee_ad[0]>=1){//si exiten adjudicados
	$mustera_expor=1;
?>
<br>
<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
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
    <td align="center"><img src="../imagenes/botones/editar_c.png"  title="Ver informaci&oacute;n detallada" alt="Ver informaci&oacute;n detallada" width="16" height="16" longdesc="Ver informaci&oacute;n detallada" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso6.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lp[2];?>&id_notificacion=<?=$sql_ex_adjudicados[0];?>&pro27_id=<?=$lp[0];?>','contenidos')"></td>
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
<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
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
    <td><img src="../imagenes/botones/editar_c.png"  title="Ver informaci&oacute;n detallada" alt="Ver informaci&oacute;n detallada" width="16" height="16" longdesc="Ver informaci&oacute;n detallada" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso7.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lp[1];?>&id_notificacion=<?=$lp[0];?>','contenidos')">    </td>
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
<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
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
<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
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
    <td><img src="../imagenes/botones/editar_c.png"  title="Ver informaci&oacute;n detallada" alt="Ver informaci&oacute;n detallada" width="16" height="16" longdesc="Ver informaci&oacute;n detallada" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso7_otros_estados.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lp[1];?>&id_notificacion=<?=$lp[0];?>','contenidos')">    </td>
  </tr>
  <? $num_fila++;} ?>
</table>
<p>
  <? } //si exiten otros estados ?>
  </p>

<? if($mustera_expor==1){ ?>
<table width="98%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="center"><input name="button6" type="button" class="guardar" id="button6" value="Exportar acta" onClick="window.open('../librerias/tcpdf/examples/exporta_adjudicacion.php?id_invitacion=<?=$id_invitacion;?>&campo_valos=3')"></div></td>
  </tr>
</table>
<? } ?>
<p>&nbsp;</p>
<p><br>
</p>
<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td  colspan="5" class="columna_titulo_resultados">HISTORICO DE CONFIRMACION DE PARTICIPACION EN EL PROCESO</td>
  </tr>
  <tr>
    <td width="139" class="columna_subtitulo_resultados">NIT</td>
    <td width="178" class="columna_subtitulo_resultados">proveedor</td>
    <td width="85" class="columna_subtitulo_resultados">Confirmaci&oacute;n</td>
    <td width="132" class="columna_subtitulo_resultados">Fecha</td>
    <td width="330" class="columna_subtitulo_resultados">Justificaci&oacute;n</td>
  </tr>
  <?

 	$busca_confirmacion = query_db("select * from v_confirmacion where pro1_id = $id_invitacion order by razon_social, fecha desc");
	while($b_c=traer_fila_row($busca_confirmacion)){
	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
 
 ?>
<tr class="<?=$class;?>">
    <td><?=$b_c[8];?></td>
    <td><?=$b_c[9];?></td>
    <td><?=$b_c[2];?></td>
    <td><?=fecha_for_hora($b_c[3]);?></td>
    <td><?=$b_c[4];?></td>
  </tr>
  <? $num_fila++;  }  ?>
</table>

<br>

<?

	$abre_ju = detalle_aspecto(1,"nombre_administrador");
	$abre_tec = detalle_aspecto(2,"nombre_administrador");
	$abre_lista = detalle_aspecto(3,"nombre_administrador");		

	if($abre_ju!="Sin apertura")
		$abre_acta=1;
	elseif($abre_tec!="Sin apertura")
		$abre_acta=1;
	elseif($abre_lista!="Sin apertura")
		$abre_acta=1;
	else
		$abre_acta=0;


?>
<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <? if($abre_acta==1){ ?>
  <tr>
    <td width="22"><img src="../imagenes/botones/abre.png" alt="Acta" width="22" height="22"></td>
    <td width="673"><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/evaluacion/detalle_acta_grantierra.php?id_invitacion=<?=$id_invitacion;?>&campo_valos=<?=$campo_valos;?>','contenidos')">Generar y ver acta de apertura</a></td>
    <td width="181">&nbsp;</td>
  </tr>
  <? } ?>
  <tr>
    <td width="22"><img src="../imagenes/botones/abre.png" alt="Adudicaci&oacute;n" width="22" height="22"></td>
    <td width="673"><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/evaluacion/auditoria_proceso.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','carga_resultados_principales')">Detalle de auditoria del proceso</a></td>
    <td>&nbsp;</td>
  </tr>

  <tr>
    <td><img src="../imagenes/botones/abre.png" alt="Adudicaci&oacute;n" width="22" height="22"></td>
<? if($sql_e[3]==1){ 
	if( ($sql_e[1]!=7) && ($sql_e[1]!=8) ) {// si no es decierto o otra ronda
	?>
    <td><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion.php?id_invitacion=<?=$id_invitacion;?>&campo_valos=<?=$campo_valos;?>','carga_resultados_principales')">Cierre del proceso</a></td>
<?
} // si no es decierto o otra ronda
 } else { 
	
	if( ($sql_e[1]==4) || ($sql_e[1]==11) ){
?>
    <td><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_servicios.php?id_invitacion=<?=$id_invitacion;?>&campo_valos=<?=$campo_valos;?>','contenidos')">Cierre del proceso</a></td>
<? } 
}?>
    <td>&nbsp;</td>
  </tr>


</table>
<p>&nbsp;</p>
<table width="900" border="0" cellspacing="2" cellpadding="2">


  <tr>
    <td><div align="center">
      <input name="button3" type="button" class="cancelar" id="button3" value="Volver  al hist&oacute;rico" onClick="ajax_carga('../aplicaciones/historico_procesos.php','contenidos')">
          
    </div></td>
  </tr>
</table>

</div>

<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_pasa;?>">
<input type="hidden" name="id_invitacion_pasa" value="<?=arreglo_pasa_variables($id_invitacion);?>">

<input type="hidden" name="id_anexo">
</body>
</html>
