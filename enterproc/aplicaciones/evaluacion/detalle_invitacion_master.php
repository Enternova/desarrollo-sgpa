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
    <td><div align="right"><strong>Origen de la solicitud:</strong></div></td>
    <td><div align="left">
      <?=listas_sin_select($tp4,$sql_e[4],1);?>
    </div></td>
  </tr>
  <tr>
    <td width="20%"><div align="right"><strong>Tipo de proceso:</strong></div></td>
    <td width="29%"><div align="left">
      <label>
        <?=listas_sin_select($tp2,$sql_e[2],1);?>
        </label>
    </div></td>
    <td width="17%"><div align="right"><strong>Tipo de contrato:</strong></div></td>
    <td width="34%"><div align="left">
      <?=listas_sin_select($tp5,$sql_e[5],1);?>
    </div></td>
  </tr>
  <tr>
    <td ><div align="right"><strong>Objeto a contratar:</strong></div></td>
    <td colspan="3"><div align="left">
      <?=listas_sin_select($tp6,$sql_e[11],1);?>
    </div></td>
  </tr>
  <tr>
    <td ><div align="right"><strong>Cuant&iacute;a a contratar:</strong></div></td>
    <td><div align="left">
      <?=listas_sin_select($tp7,$sql_e[13],1);?>
      $
      <?=number_format($sql_e[14],0);?>
    </div></td>
    <td><div align="right"><strong>TRM del proceso:</strong></div></td>
    <td><div align="left">
      <?=valida_fecha_vacia($sql_e[42]);?>
    </div></td>
  </tr>
  <tr>
    <td ><div align="right"></div></td>
    <td><div align="left"></div></td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td ><div align="right"><strong>Detalle del objeto a contratar:</strong></div></td>
    <td colspan="3"><div align="left">
      <?=$sql_e[12];?>
    </div></td>
  </tr>
</table>
<br>
<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td><label>
        <div align="center">
          <input name="button5" type="button" class="guardar" id="button5" value="Ver / enviar aclaraciones finales del proceso" onClick="ajax_carga('../aplicaciones/evaluacion/cartelera_aclaraciones_finales.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','carga_resultados_principales')">
        </div>
      </label></td>
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
    <td  colspan="4" class="columna_titulo_resultados">EVALUACION DE REQUERIMIENTOS  SOLICITADOS EN EL PROCESO</td>
    </tr>
  <tr>
    <td width="238" class="columna_subtitulo_resultados">Requerimientos</td>
    <td width="190" class="columna_subtitulo_resultados">Usuario de apertura</td>
    <td width="306" class="columna_subtitulo_resultados">Fecha apertura</td>
    <td width="136" class="columna_subtitulo_resultados">Ingresar</td>
    </tr>
 <? if( ($abre_juridco==1) || ($permiso_total==1) ){ ?>
  <tr>
    <td><div align="right"><strong>Evaluaci&oacute;n  jur&iacute;dica</strong></div></td>
    <td><?=detalle_aspecto(1,"nombre_administrador");?></td>
    <td><?=detalle_aspecto(1,"fecha_apertura");?></td>
    <td>      <input name="button" type="button" class="buscar_ajustado" id="button" value="Ver documentos" onClick="ajax_carga('../aplicaciones/evaluacion/apertura_evaluacion_juridica.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','carga_resultados_principales')">
    </td>
    </tr>
  <? } if( ($abre_tecnico==1) || ($permiso_total==1) ){ ?>
  <tr class="campos_gris_listas">
    <td ><div align="right"><strong>Evaluaci&oacute;n t&eacute;cnica</strong></div></td>
    <td><?=detalle_aspecto(2,"nombre_administrador");?></td>
    <td><?=detalle_aspecto(2,"fecha_apertura");?></td>
    <td ><input name="button2" type="button" class="buscar_ajustado" id="button2" value="Ver ofertas" onClick="ajax_carga('../aplicaciones/evaluacion/apertura_evaluacion_tecnica.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','carga_resultados_principales')"></td>
    </tr>
 <? } if( ($abre_economico==1) || ($permiso_total==1) ){ ?>    
  <tr>
    <td><div align="right"><strong>Evaluaci&oacute;n econ&oacute;mica</strong></div></td>
    <td><?=detalle_aspecto(3,"nombre_administrador");?></td>
    <td><?=detalle_aspecto(3,"fecha_apertura");?></td>
    <td><input name="button9" type="button" class="buscar_ajustado" id="button9" value="Ver ofertas" onClick="ajax_carga('../aplicaciones/evaluacion/apertura_evaluacion_economica.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','carga_resultados_principales')"></td>
    </tr>
     <? }  ?>    

</table>
<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td><label>
        <div align="center">
          <input name="button6" type="button" class="guardar" id="button6" value="Ver / enviar aclaraciones finales del proceso" onClick="ajax_carga('../aplicaciones/evaluacion/apertura_evaluacion_economica.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','cartelera_aclaraciones_finales')">
        </div>
      </label></td>
  </tr>
</table>
<br>
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
 	$busca_confirmacion = query_db("select * from v_confirmacion where pro1_id = $id_invitacion order by nit, fecha desc");
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
<table width="900" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td width="22"><img src="../imagenes/botones/abre.png" alt="Acta" width="22" height="22"></td>
    <td width="673"><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/evaluacion/detalle_acta_grantierra.php?id_invitacion=<?=$id_invitacion;?>&campo_valos=<?=$campo_valos;?>','contenidos')">Generar y ver acta de apertura</a></td>
    <td width="181">&nbsp;</td>
  </tr>
  <tr>
    <td><img src="../imagenes/botones/abre.png" alt="Adudicaci&oacute;n" width="22" height="22"></td>
    <td width="673"><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/evaluacion/auditoria_proceso.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','carga_resultados_principales')">Detalle de auditoria del proceso</a></td>
    <td>&nbsp;</td>
  </tr>
<?
if($_SESSION["tipo_usuario"]!=4) {
?>  
  <?  if($permiso_total==1){ ?>    

  <tr>
    <td><img src="../imagenes/botones/abre.png" alt="Adudicaci&oacute;n" width="22" height="22"></td>
    <td><a href="javascript:void(0)" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion.php?id_invitacion=<?=$id_invitacion;?>&campo_valos=<?=$campo_valos;?>','carga_resultados_principales')">Cierre del proceso</a></td>
    <td>&nbsp;</td>
  </tr>

<? }  ?>  
  <? } ?>
</table>
<p>&nbsp;</p>
<table width="900" border="0" cellspacing="2" cellpadding="2">
<?

if($_SESSION["tipo_usuario"]==4) {
?> 
  <tr>
    <td><img src="../../imagenes/botones/help.gif" alt="Ayuda" longdesc="Ayuda" title="Ayuda">&nbsp;AYUDA: Para que el proceso sea visible al comprador siga estas instrucciones:</p>
      <ul>
        <li>Genere el acta de apertura.</li>
        <li>El  sistema le mostrara el comando para confirmar la apertura del proceso presi&oacute;nelo.</li>
        <li>Cuando  el sistema le notifique que el proceso se abri&oacute; con &eacute;xito, el comprador podr&aacute;  visualizar las ofertas.</li>
      </ul></td>
  </tr>
  <? } ?>
  <tr>
    <td><div align="center">
	  <?
        if($_SESSION["tipo_usuario"]==4) {

		$buscar_datos_ap = traer_fila_row(query_db("select * from pro12_apertura_proceso where pro1_id = $id_invitacion"));	 
		if( ($buscar_datos_ap[7]!="") && ($buscar_datos_ap[8]=="0") ){ ?>
        <input name="button4" type="button" class="guardar" id="button4" value="Confirmar apertura de proceso " onClick="apertura_proceso_auditor()"> 
       <? } elseif( ($buscar_datos_ap[7]=="") && ($buscar_datos_ap[8]!="1") ) echo  "El proceso requiere acta de apertura"; 
		   else  echo "El proceso ya esta abierto"; 
		  }//si es el auditor
		  ?>
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
