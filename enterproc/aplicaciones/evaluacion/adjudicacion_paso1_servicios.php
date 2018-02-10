<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    //verifica_menu("procesos.html");

//$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	
	$id_invitacion = $id_invitacion;
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));
$estado_proceso =  $sql_e[1];

	$busca_confirmacion = traer_fila_row(query_db("select * from $t9 where  pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." order by fecha desc"));

if($requeire_filtro_proveedores_tecnico_aceptados=="Si"){ //si requierre filtro 
$busca_proveedores_apectados = query_db("select * from $t13 where proc1_id = $id_invitacion");
while($lista_prove_apcet=traer_fila_row($busca_proveedores_apectados))
	{
		if($sql_e[20]<=$lista_prove_apcet[5])
			$pv_id_acep_tecnico.=",".$lista_prove_apcet[2];
	
	}
	
	 $filtro_provee_aceptados_tec = "and $t7.pv_id  in (0 ".$pv_id_acep_tecnico.")";
	
	} // si requierre filtro 


?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css">
</head>
<body >
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="83%" class="titulos_evaluacion">PASO 1: Seleccione los proveedores adjudicados.</td>
    <td width="17%"><div align="left">
      <input name="button2" type="button" class="cancelar" id="button2" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_servicios.php?id_invitacion=<?=$id_invitacion;?>','contenidos')">
    </div></td>
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
</table>
</p>


<table width="99%" border="0" cellpadding="1" cellspacing="1" class="tabla_lista_resultados">
              
              <tr>
                <td width="47%" class="columna_titulo_resultados"><div align="center"><strong>Nombre proveedor</strong></div></td>
                <td width="18%" class="columna_titulo_resultados"><strong>Tipo de adjudicaci&oacute;n (Total, Parcial)</strong></td>
                <? if ($estado_proceso==5){ ?>
                <td width="24%" align="center" class="columna_titulo_resultados"><strong>Numero aprobaci&oacute;n</strong></td>
                <? } ?>
                <td width="11%" class="columna_titulo_resultados"><div align="center"><strong>Adjudicar</strong></div></td>
              </tr>
           
              <?
			  $busca_provee_adju = query_db("select pv_id from $v13 where pro1_id =  $id_invitacion and estado = 1 ");
				while($lp_a = traer_fila_row($busca_provee_adju))
					$not_in .=",".$lp_a[0];

	
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id and $t7.pv_id not in (0 $not_in) $filtro_provee_aceptados_tec  order by $t8.razon_social ");
				while($lp = traer_fila_row($busca_provee)){
			  
				
  ?>

  <tr class="<?=$class;?>">
    <td><?=$lp[2];?><input type="hidden" name="nombre_provee_<?=$lp[0];?>" id="nombre_provee_<?=$lp[0];?>" value="<?=$lp[2];?>">
    
    <input type="hidden" name="fecha_entrega_<?=$lp[0];?>" id="fecha_entrega_<?=$lp[0];?>" value="n/a">
    <input type="hidden" name="contacto_<?=$lp[0];?>" id="contacto_<?=$lp[0];?>" value="N/A">
    <input type="hidden" name="pro25_id_<?=$lp[0];?>" id="pro25_id_<?=$lp[0];?>" value="5000">
    </td>
    <td>      
      <select name="documento_<?=$lp[0];?>" class="campos" id="documento_<?=$lp[0];?>">
      <option value="0">Seleccione</option>
      <option value="Total">Total</option>
      <option value="Parcial">Parcial</option>
    </select></td>
     <? if ($estado_proceso==5){ ?>
    <td><input type="text" name="numeroaprob_<?=$lp[0];?>" id="numeroaprob_<?=$lp[0];?>"></td>
    <? } else echo '<input type="hidden" name="numeroaprob_'.$lp[0].'" id="numeroaprob_'.$lp[0].'" value="&nbsp;">'; ?>
    <td align="center"><input type="button" name="button" class="guardar" id="button" value="Adjudicar" onClick="crea_adju_provee_servicios(<?=$lp[0];?>)"></td>
  </tr>
              <? $num_fila++;} ?>
</table>


<p>&nbsp;</p>
<table width="99%" border="0" cellpadding="1" cellspacing="1" class="tabla_lista_resultados">
  <tr>
    <td colspan="5" class="columna_subtitulo_resultados"><strong>Proveedores seleccionados para adjudicaci&oacute;n</strong></td>
  </tr>
  <tr>
    <td width="59%" align="center" class="columna_titulo_resultados"><div align="center"><strong>Nombre proveedor</strong></div></td>
                <? if ($estado_proceso==5){ ?>
    <td width="19%" align="center" class="columna_titulo_resultados"><strong>Numero aprobaci&oacute;n</strong></td>
    <? } ?>
    <td width="8%" align="center" class="columna_titulo_resultados"><strong>Adjudicaci&oacute;n</strong></td>
    <td width="7%" align="center" class="columna_titulo_resultados"><strong>Ver carta</strong></td>
    <td width="7%" class="columna_titulo_resultados"><div align="center"><strong>Eliminar</strong></div></td>
  </tr>
  <?


	
			  	$busca_provee = query_db("select pro27_id, pro1_id, pv_id, razon_social,documento,fecha_entrega,contacto,pro25_id, estado,nuemro_aprobacion from $v13 where pro1_id =  $id_invitacion and estado = 1 order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){
			  
				
				
  ?>
  <tr class="<?=$class;?>">
    <td><?=$lp[3];?><input type="hidden" name="nombre_provee_<?=$lp[2];?>" id="nombre_provee_<?=$lp[2];?>" value="<?=$lp[3];?>"></td>
  <? if ($estado_proceso==5){ ?>
    <td><?=$lp[9];?></td>
    <? } ?>
    <td><strong>
      <?=$lp[4];?>
    </strong></td>
    <td><input type="button" name="button3" class="buscar_ajustado" id="button3" value="Editar" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_carta_terminos_servicios.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lp[2];?>','contenidos')"></td>
    <td align="center"><img src="../imagenes/botones/b_cancelar.gif" alt="Descincular proveedor adjudicado" title="Descincular proveedor adjudicado" width="16" height="16" longdesc="Descincular proveedor adjudicado" onClick="elimina_adju_provee_servicios(<?=$lp[2];?>)"></td>
  </tr>
  <tr></tr>
  <td>      
  <? $num_fila++;} ?>
</table>
<p><br>
  <input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
  <input type="hidden" name="pv_id">
  
<input type="hidden" name="id_anexo"></p>
</body>
</html>
