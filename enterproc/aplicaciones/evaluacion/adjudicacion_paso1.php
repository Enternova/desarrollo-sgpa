<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    //verifica_menu("procesos.html");

//$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	
	$id_invitacion = $id_invitacion;
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$busca_confirmacion = traer_fila_row(query_db("select * from $t9 where  pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." order by fecha desc"));

$estado_proceso =  $sql_e[1];

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
      <input name="button2" type="button" class="cancelar" id="button2" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion.php?id_invitacion=<?=$id_invitacion;?>','contenidos')">
    </div></td>
  </tr>
  <tr>
    <td ><strong>Consecutivo:</strong>      <span class="texto_paginador_proveedor">
      <?=$sql_e[22];?></span></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td ><strong>Objeto:</strong>      <?=$sql_e[12];?></td>
    <td>&nbsp;</td>
  </tr>
</table>
</p>


<table width="99%" border="0" cellpadding="1" cellspacing="1" class="tabla_lista_resultados">
              
              <tr>
                <td width="34%" class="columna_titulo_resultados"><div align="center"><strong>Nombre proveedor</strong></div></td>
                <td width="13%" class="columna_titulo_resultados"><strong>Contable SGPA</strong></td>
                <td width="13%" class="columna_titulo_resultados"><strong>Cargo Contable</strong></td>
                <td width="13%" class="columna_titulo_resultados"><div align="center"><strong>Contato, OP, OS</strong></div></td>
                <td width="13%" class="columna_titulo_resultados"><div align="center"><strong>Fecha de entrega</strong></div></td>
                <td width="14%" class="columna_titulo_resultados"><div align="center"><strong>Contacto</strong></div></td>
                     <? if ($estado_proceso==5){ ?>
                <td width="14%" align="center" class="columna_titulo_resultados"><strong>Numero aprobaci&oacute;n</strong></td>
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
    <td><?=$lp[2];?><input type="hidden" name="nombre_provee_<?=$lp[0];?>" id="nombre_provee_<?=$lp[0];?>" value="<?=$lp[2];?>"></td>
    <td><?
	$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
	$sel_sql = mssql_select_db($dbbase_sql,$link_sql);
	$busca_cargo_contable = "select cargo_contable from t2_presupuesto where t2_item_pecc_id  = $sql_e[7] and permiso_o_adjudica = 1";
	$sql_cargo_contable = mssql_query($busca_cargo_contable);
	
	?>
      <select name="select" id="select" onChange="document.principal.cargo_contable_<?=$lp[0];?>.value = this.value">
        <option value="Sin cargo">Seleccione</option>
        <?
	  	while($lista_cargos = mssql_fetch_row($sql_cargo_contable)){
		echo "<option value='".$lista_cargos[0]."'>".$lista_cargos[0]."</option>";	
		}
	  ?>
    </select></td>
	<td><input type="text" name="cargo_contable_<?=$lp[0];?>" id="cargo_contable_<?=$lp[0];?>"></td>
                <td><input type="text" name="documento_<?=$lp[0];?>" id="documento_<?=$lp[0];?>"></td>
                <td><input type="text" name="fecha_entrega_<?=$lp[0];?>" id="fecha_entrega_<?=$lp[0];?>" readonly onMouseDown="calendario_sin_hora('fecha_entrega_<?=$lp[0];?>')"></td>
                <td><input type="text" name="contacto_<?=$lp[0];?>" id="contacto_<?=$lp[0];?>"></td>
                     <? if ($estado_proceso==5){ ?>
    <td><input type="text" name="numeroaprob_<?=$lp[0];?>" id="numeroaprob_<?=$lp[0];?>"></td>
                
                    <? } else echo '<input type="hidden" name="numeroaprob_'.$lp[0].'" id="numeroaprob_'.$lp[0].'" value="&nbsp;">'; ?>
                <td align="center"><input type="button" name="button" class="guardar" id="button" value="Adjudicar" onClick="crea_adju_provee(<?=$lp[0];?>)"></td>
<input type="hidden" name="pro25_id_<?=$lp[0];?>" id="pro25_id_<?=$lp[0];?>" value="1">  </tr>
              <? $num_fila++;} ?>
</table>


<p>&nbsp;</p>
<table width="99%" border="0" cellpadding="1" cellspacing="1" class="tabla_lista_resultados">
  <tr>
    <td colspan="6" class="columna_subtitulo_resultados"><strong>Proveedores seleccionados para adjudicaci&oacute;n</strong></td>
  </tr>
  <tr>
    <td width="34%" class="columna_titulo_resultados"><div align="center"><strong>Nombre proveedor</strong></div></td>
                <? if ($estado_proceso==5){ ?>
    <td width="10%" align="center" class="columna_titulo_resultados"><strong>Numero aprobaci&oacute;n</strong></td>
    <? } ?>
    
    <td width="14%" class="columna_titulo_resultados"><strong>Cargo Contable</strong></td>
    <td width="14%" class="columna_titulo_resultados"><strong>Contato, OP, OS</strong></td>
    <td width="13%" class="columna_titulo_resultados"><div align="center"><strong>Fecha de entrega</strong></div></td>
    <td width="18%" class="columna_titulo_resultados"><div align="center"><strong>Contacto</strong></div></td>
    <td width="7%" class="columna_titulo_resultados"><div align="center"><strong>Admin</strong></div></td>
  </tr>
  <?

	

			  	$busca_provee = query_db("select pro27_id, pro1_id, pv_id, razon_social,documento,fecha_entrega,contacto,pro25_id, estado,cargo_contable,nuemro_aprobacion from $v13 where pro1_id =  $id_invitacion and estado = 1 order by razon_social ");
				while($lp = traer_fila_row($busca_provee)){
			  
				
				
  ?>
  <tr class="<?=$class;?>">
    <td><?=$lp[3];?><input type="hidden" name="nombre_provee_<?=$lp[2];?>" id="nombre_provee_<?=$lp[2];?>" value="<?=$lp[3];?>"></td>
  <? if ($estado_proceso==5){ ?>
    <td><?=$lp[9];?></td>
    <? } ?>    
    			<td><input type="text" name="cargo_contable_<?=$lp[2];?>" id="cargo_contable_<?=$lp[2];?>" value="<?=$lp[9];?>"></td>
                <td><input type="text" name="documento_<?=$lp[2];?>" id="documento_<?=$lp[2];?>" value="<?=$lp[4];?>"></td>
                <td><input type="text" name="fecha_entrega_<?=$lp[2];?>" id="fecha_entrega_<?=$lp[2];?>" value="<?=$lp[5];?>" onMouseDown="calendario_sin_hora('fecha_entrega_<?=$lp[2];?>')"></td>
                <td><input type="text" name="contacto_<?=$lp[2];?>" id="contacto_<?=$lp[2];?>" value="<?=$lp[6];?>"></td>
                <td align="center"><img src="../imagenes/botones/editar_c.png"  title="Editar datos de adjudicación" alt="Editar datos de adjudicaci&oacute;n" width="16" height="16" longdesc="Editar datos de adjudicación" onClick="edita_adju_provee(<?=$lp[2];?>)"> 
                 <img src="../imagenes/botones/b_cancelar.gif" alt="Descincular proveedor adjudicado" title="Descincular proveedor adjudicado" width="16" height="16" longdesc="Descincular proveedor adjudicado" onClick="elimina_adju_provee(<?=$lp[2];?>)"></td>
<input type="hidden" name="pro25_id_<?=$lp[2];?>" id="pro25_id_<?=$lp[2];?>" value="1">  </tr>
  </tr>
  <? $num_fila++;} ?>
</table>
<p><br>
  <input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
  <input type="hidden" name="pv_id">
  
  <input type="hidden" name="id_anexo"></p>
</body>
</html>
