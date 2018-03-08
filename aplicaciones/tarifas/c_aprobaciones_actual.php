<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));	
$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));
	
	
	$busca_roll_secun = "select * from t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and roll = 'Responsable solicitante' and us_id = ".$_SESSION["id_us_session"];
	$sql_roll_secun=traer_fila_row(query_db($busca_roll_secun));
		
	if($sql_roll_secun[0]>=1){ //si es contrato marco 
	
		$busca_tarifas_apr_secundarios = "select * from v_tarifas_relacion_secndarias_aprobadas where tarifas_contrato_id = $id_contrato_arr and us_id = ".$_SESSION["id_us_session"]." and tipo_aprobacion_copia = 1 and id_tarifa_aprobada IS NULL";
		$sql_aproba_secun = query_db($busca_tarifas_apr_secundarios);
		while($ls_secun = traer_fila_row($sql_aproba_secun))
			$lista_tarifas_secundarias.= ",".$ls_secun[1];
			
			$complemnto_secundarios = " and t6_tarifas_lista_id in (0 $lista_tarifas_secundarias )";
	
	}//si es contrato marco 


	if($sql_con[19]==2){//si es contrato marco solo para gerente
	$busca_roll_secun = "select * from t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and roll = 'Gerente de contrato' and us_id = ".$_SESSION["id_us_session"];
	$sql_roll_secun=traer_fila_row(query_db($busca_roll_secun));
	if($sql_roll_secun[0]>=1){ //si es gerente

		$busca_tarifas_apr_secundarios = "select COUNT(*) as cantidad_apro, t6_tarifas_lista_id from v_tarifas_relacion_secndarias_aprobadas where tarifas_contrato_id = $id_contrato_arr and us_id <> ".$_SESSION["id_us_session"]." and tipo_aprobacion_copia = 1 and id_tarifa_aprobada IS NOT NULL group by t6_tarifas_lista_id ";
		$sql_aproba_secun = query_db($busca_tarifas_apr_secundarios);
		while($ls_secun = traer_fila_row($sql_aproba_secun)){
			if($ls_secun[0]==1)
				$lista_tarifas_secundarias.= ",".$ls_secun[1];
			
			}
			
			$complemnto_secundarios = " and t6_tarifas_lista_id in (0 $lista_tarifas_secundarias )";
	
	
	
	}//si es gerente
}//si es contrato marco solo para gerente


if($sql_con[19]==2){
$nu_apro_esp = 2;
$nu_apro_jefe = 3;
}
else{
$nu_apro_esp = 1;
$nu_apro_jefe = 2;

}
if($sql_roll_secun[0]>=1){ //si es contrato marco 	


$busca_roll_secun = "select * from t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and roll = 'Especialista' and us_id = ".$_SESSION["id_us_session"];
$sql_roll_secun=traer_fila_row(query_db($busca_roll_secun));
if($sql_roll_secun[0]>=1)	{//especialista

		 $busca_tarifas_apr_secundarios = "select COUNT(*) as cantidad_apro, t6_tarifas_lista_id from t6_tarifas_aprobaciones
		 where  us_id <> ".$_SESSION["id_us_session"]."  group by t6_tarifas_lista_id ";
		$sql_aproba_secun = query_db($busca_tarifas_apr_secundarios);
		while($ls_secun = traer_fila_row($sql_aproba_secun)){
			if($ls_secun[0]==$nu_apro_esp)
				$lista_tarifas_secundarias.= ",".$ls_secun[1];
			
			}
			
			$complemnto_secundarios = " and t6_tarifas_lista_id in (0 $lista_tarifas_secundarias )";


}//especialista

$busca_roll_secun = "select * from t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and roll = 'Jefe de area' and us_id = ".$_SESSION["id_us_session"];
$sql_roll_secun=traer_fila_row(query_db($busca_roll_secun));
if($sql_roll_secun[0]>=1)	{//jefe area

		 $busca_tarifas_apr_secundarios = "select COUNT(*) as cantidad_apro, t6_tarifas_lista_id from t6_tarifas_aprobaciones
		 where  us_id <> ".$_SESSION["id_us_session"]."  group by t6_tarifas_lista_id ";
		$sql_aproba_secun = query_db($busca_tarifas_apr_secundarios);
		while($ls_secun = traer_fila_row($sql_aproba_secun)){
			if($ls_secun[0]==$nu_apro_jefe)
				$lista_tarifas_secundarias.= ",".$ls_secun[1];
			
			}
			
			$complemnto_secundarios = " and t6_tarifas_lista_id in (0 $lista_tarifas_secundarias )";


}//jefe area
			
			
			
}//si es contrato marco 	
if( $tipo_modificacion>=1)			
	$comple_filtro = " and tipo_creacion_modifica = $tipo_modificacion ";

if( $detalle_ta_b!="")			
	$comple_filtro.= " and detalle = like '%$detalle_ta_b%' ";
			
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>

      <table width="99%" border="0" cellspacing="0" cellpadding="0">
        <tr>
          <td width="91%" class="titulos_secciones">SECCION:<span class="titulos_resaltado_procesos"> APROBACIONES DE TARIFAS PENDIENTES &gt;&gt; CONTRATO:
            <?=$sql_con[7];?>
          </span></span><br />
          Proveedor: <?=$sql_con[6];?>
          <br />
          Objeto del contrato: 
          <span class="tabla_paginador">
          <?=htmlentities($sql_con[9]);?></span></td>
          <td width="9%" class="titulos_secciones"><input type="button" name="button5" class="boton_volver"  id="button5" value="Volver al menu" onclick="ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','carga_acciones_permitidas')" /></td>
        </tr>
      </table>
      <?
			$busca_categorias = "select count(*) from $t3 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_tarifas_id in (2,3)";
			$id_ingreso=traer_fila_row(query_db($busca_categorias));
			?>
            
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top"> Atenci&oacute;n: <strong>Antes de Aprobar por favor revise con ABASTECIMIENTO el saldo y alcance del contrato, &nbsp;&nbsp;esta modificaci&oacute;n &oacute; inclusi&oacute;n &nbsp;puede requerir Aprobaciones internas</strong><br />
      <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr >
          <td width="1%" ><? if($id_ingreso[0]>=1){ ?> <img src="../imagenes/botones/si_tiene_aprobaciones.gif" alt=" Historico de tarifas de este contrato pendientes de su aprobaci&oacute;n" title=" Historico de tarifas de este contrato pendientes de su aprobaci&oacute;n" /><? } else { ?> <img src="../imagenes/botones/no_tiene_aprobaciones.gif" alt=" Historico de tarifas de este contrato pendientes de su aprobaci&oacute;n" title=" Historico de tarifas de este contrato pendientes de su aprobaci&oacute;n" /><? } ?></td>
          <td width="99%" class="fondo_4"><? if($id_ingreso[0]>=1){ ?> Historico de tarifas de este contrato pendientes de su aprobaci&oacute;n<? } else echo "El contrato NO tiene tarifas pendientes por aprobaci&oacute;n"; ?></td>
        </tr>
    </table>
      <table width="98%" border="0" class="tabla_lista_resultados">
        <tr>
          <td colspan="5" class="fondo_2_sub">Buscador de tarifas</td>
        </tr>
        <tr>
          <td width="14%" align="right"><strong>Categoria:</strong></td>
          <td width="24%"><select name="categoria_existentes" id="categoria_existentes" onchange="ajax_carga('../aplicaciones/tarifas/carga_grupos_existentes.php?id_contrato_arr=<?=$id_contrato_arr;?>&amp;categoria_trae=' + this.value,'grupo__xistente')">
            <option value="no_apli_b" >Categorias existentes</option>
            <?
			 	$busca_categorias = "select distinct categoria from $t3 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_listas_lista_id = $lista_existentes";
					$sql_cate=query_db($busca_categorias);
					while($lista_categoria=traer_fila_row($sql_cate)) {
						if($categoria_existentes==$lista_categoria[0]) $select_c = "selected";
						else $select_c = "";
						
						echo "<option value='".$lista_categoria[0]."' ".$select_c.">".$lista_categoria[0]."</option>";
						
					}

			 ?>
          </select></td>
          <td width="11%" align="right"><strong>Grupo:</strong></td>
          <td width="17%" id="grupo__xistente"><select name="grupo_existentes" class="campos_tarifas" id="grupo_existentes" >
            <option value="no_apli_b">Grupos existentes</option>
            <?
	   	if($categoria_existentes!="no_apli_b"){
				 	$busca_grupos = "select distinct grupo from $t3 where tarifas_contrato_id = $id_contrato_arr and categoria = '".elimina_comillas_2($categoria_existentes)."'";
					$sql_cate=query_db($busca_grupos);
					while($lista_grupo_e=traer_fila_row($sql_cate)){
					if(elimina_comillas_2($grupo_existentes)==elimina_comillas_2($lista_grupo_e[0])) $select_c = "selected";
						else $select_c = "";

						echo "<option value='".$lista_grupo_e[0]."' ".$select_c.">".$lista_grupo_e[0]."</option>";
						
					}
						
		}
			 
			 ?>
          </select></td>
          <td width="34%" id="grupo__xistente">&nbsp;</td>
        </tr>
        <tr>
          <td align="right"><strong>Tipo de modificaci&oacute;n:</strong></td>
          <td><select name="tipo_modificacion" id="tipo_modificacion">
            <option value="0">Seleccione</option>
            <option value="2" <? if($tipo_modificacion==2) echo "selected"; ?>  >Actualizaci&oacute;n</option>
            <option value="3" <? if($tipo_modificacion==3) echo "selected"; ?> >Nuevas</option>
            <option value="4" <? if($tipo_modificacion==4) echo "selected"; ?> >IPC</option>
          
          </select></td>
          <td align="right"><strong>Detalle:</strong></td>
          <td colspan="2"><input type="text" name="detalle_ta_b" id="detalle_ta_b" value="<?=$detalle_ta_b;?>"/></td>
        </tr>
        <tr>
          <td colspan="5" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="5" align="center"><input name="button3" type="button" class="boton_buscar" id="button3" value="      Buscar tarifas      "  onclick="busqueda_paginador_nuevo_tarifas(1,'../aplicaciones/tarifas/c_aprobaciones.php','carga_acciones_permitidas',12)"/></td>
        </tr>
      </table>
      <?
 
 
	 	$busca_categorias = "select distinct categoria from $t3 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_tarifas_id in (2,3) $complemnto_secundarios ";
		$sql_cate=query_db($busca_categorias);
		while($lista_categoria=traer_fila_row($sql_cate)){
	 
	 ?>
      <table width="99%" border="0" cellspacing="2" cellpadding="2">
        <? if(chop($lista_categoria[0])<>""){ ?>
        <tr>
          <td><table width="99%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td class="titulos_secciones"><?=$lista_categoria[0];?></td>
              </tr>
          </table></td>
        </tr>
        <? } ?>
        <tr>
          <td><?
	 	$busca_grupos = "select distinct grupo from $t3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' and t6_tarifas_estados_tarifas_id in (2,3) $complemnto_secundarios ";
		$sqlgrupo=query_db($busca_grupos);
		while($lista_grupos=traer_fila_row($sqlgrupo)){//grupos
	
	 ?>
              <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
                <? if(chop($lista_grupos[0])<>""){ ?>
                <tr >
                  <td colspan="12" class="fondo_4">GRUPO:
                    <?=$lista_grupos[0];?></td>
                </tr>
                <? } ?>
                <tr>
                  <td width="4%" rowspan="2" class="fondo_3">Anexos</td>
                  <td width="25%" rowspan="2" class="fondo_3"><div align="center">Nombre generico del producto / servicio</div></td>
                  <td width="4%" rowspan="2" class="fondo_3"><div align="center">Moneda</div></td>
                  <td width="8%" rowspan="2" class="fondo_3"><div align="center">Valor actual</div></td>
                  <td width="6%" rowspan="2" class="fondo_3"><div align="center">Nuevo valor</div></td>
                  <td width="6%" rowspan="2" class="fondo_3"><div align="center">Inicio vigencia</div></td>
                  <td width="3%" rowspan="2" class="fondo_3">Tipo de modificaci&oacute;n</td>
                  <td width="6%" rowspan="2" class="fondo_3"><div align="center">Aprobaci&oacute;n</div></td>
                  <td width="16%" rowspan="2" class="fondo_3"><div align="center">Observaciones</div></td>
                  <td colspan="2" class="fondo_3"><div align="center">Ultima aprobaci&oacute;n</div></td>
                  <td width="2%" rowspan="2" class="fondo_3"><div align="center">Ver</div>                    <div align="center"></div></td>
                </tr>
                <tr>
                  <td width="10%" class="fondo_3"><div align="center">Usuario</div></td>
                  <td width="10%" class="fondo_3"><div align="center">Fecha</div></td>
                </tr>
                <?
	 	$busca_detalle = "select * from $v_t_3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' and grupo = '$lista_grupos[0]' and t6_tarifas_estados_tarifas_id in (2,3) $complemnto_secundarios $comple_filtro  order by fecha_creacion desc";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//detalle
		
		if($lista_detalle[13]==3){
		 $modificada = "NO";
		 $sql_ap=" t6_tarifas_estados_tarifas_id in (1,4,6)";
	 		$busca_detalle_padre = traer_fila_row(query_db("select valor from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_estados_tarifas_id = 1"));		 
		 }
		else{
		$modificada = "SI";
		$sql_ap=" t6_tarifas_estados_tarifas_id in (1,4,5)";
		}
	

	
		if($lista_detalle[22]==1)
		{ $tipo_modifica="Normal";
			$class_tipo="tarifas_normal";
		}	
		elseif($lista_detalle[22]==2)
		{ 			
		    $tipo_modifica="Actualizada";
			$class_tipo="tarifas_actualiza";
		}	


		elseif($lista_detalle[22]==3)
		{ 			
			$tipo_modifica="Creacion";
			$class_tipo="tarifas_creacion";
		}	
		

		elseif($lista_detalle[22]==4)
		{ 			
			$tipo_modifica="IPC";
			$class_tipo="tarifas_ipc";
		}	
		


	$busca_aprobaciones_permite= traer_fila_row(query_db("select * from t6_tarifas_responsables_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = ".$_SESSION["id_us_session"]."
	 and estado = 1 "));
	 	
		$busca_aprobaciones= traer_fila_row(query_db("select nombre_administrador, fecha_aprobacion, us_id from $v_t_4 where t6_tarifas_lista_id = $lista_detalle[0] and estado_aprobacion = 1 and estado_aprobacion = 1 order by fecha_aprobacion desc"));
			if($busca_aprobaciones_permite[0]>=1) $suma_apertura_botones=1;
			
	 ?>
                <tr class="filas_resultados">
                  <td><img src="../imagenes/botones/b_guardar.gif" width="16" height="16" alt="Comentarios a la tarifa" title="Comentarios a la tarifa" onclick="muestra_div_o('espacio_<?=$lista_detalle[0];?>')" /></td>
                  <td>
                    <div align="center">
                      <?=$lista_detalle[5];?>
                    </div></td>
                  <td class="titulos_resumen_alertas">
                    
                    <div align="center">
                      <?=$lista_detalle[18];?>
                    </div></td>
                  <td class="titulos_resumen_alertas">
                    
                    <div align="center">
                      <?=number_format($busca_detalle_padre[0],2);?>
                    </div></td>
                  <td class="titulos_resumen_alertas">
                    <div align="center">
                      <?=number_format($lista_detalle[9],2);?>
                    </div></td>
                  <td class="titulos_resumen_alertas">
                    <div align="center">
                      <?=$lista_detalle[14];?>
                    </div></td>
                  <td class="titulos_resumen_alertas">
                    <div align="center" class="<?=$class_tipo;?>">
                      <?=$tipo_modifica;?>
                  </div></td>
                  <td class="titulos_resumen_alertas">
                 <? if($busca_aprobaciones_permite[0]>=1){ ?> <select name="aprobacion[<?=$lista_detalle[0];?>]" id="aprobacion"><?=listas($t6,$sql_ap ,0,'nombre', 1);?></select><? } ?></td>
                  <td class="titulos_resumen_alertas">
                    <? if($busca_aprobaciones_permite[0]>=1){ ?> <textarea name="observaciones_<?=$lista_detalle[0];?>" id="textarea" cols="20" rows="2"></textarea><? } ?>
                  </td>
                  <td class="titulos_resumen_alertas"><?=$busca_aprobaciones[0];?></td>
                  <td class="titulos_resumen_alertas"><?=fecha_for_hora($busca_aprobaciones[1]);?></td>
                  <td class="titulos_resumen_alertas"><img src="../imagenes/botones/editar.jpg" alt="Editar tarifa" title="Editar tarifa" width="14" height="15" /></td>
                </tr>

 <tr class="<?=$class;?>" style="display:none" id="espacio_<?=$lista_detalle[0];?>" >
  
              
            	<td colspan="11">
                <?
					$busca_soporte = traer_fila_row(query_db("select * from t6_tarifas_anexos_modifica_tarifas where t6_tarifas_lista_id = $lista_detalle[0]"));
				
				?>
                <table width="100%" border="0">
  <tr>
    <td width="10%">Observaciones:</td>
    <td><?=$busca_soporte[2];?></td>
    <td  width="30%"><input name="button2" type="button" class="boton_eliminar" id="button2" value="Cerrar comentario" onclick="oculta_div_o('espacio_<?=$lista_detalle[0];?>')" /></td>
  </tr>
  <tr>
    <td  width="5%">Anexo cargado:</td>
    <td><a href="javascript:void(0)" onclick="javascript:window.parent.location.href='../aplicaciones/tarifas/proveedor/descarga_anexo_m.php?id_documen=<?=$busca_soporte[0];?>'"><?=$busca_soporte[3];?></a></td>
    <td>&nbsp;</td>
  </tr>
</table>

           </td>
           </tr>                
                <? }//detalle ?>
              </table>
          <br />
              <? }//grupos ?>
          </td>
        </tr>
      </table>
    <? } ?></td>
  </tr>
</table>
<? if( ($id_ingreso[0]>=1) && ($suma_apertura_botones==1) ){ ?>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td></td>
    <td><input name="button2" type="button" class="boton_grabar" id="button2" value="Confirmar estados de aprobaci&oacute;n" onclick="crear_aprobacion()" /></td>
    <td><input name="button" type="button" class="boton_grabar" id="button" value="Aprobar todas"  onclick="crear_aprobacion_todos()"/></td>
    <td><input name="button4" type="button" class="boton_grabar_cancelar" id="button4" value="No aprobar todas"  onclick="crear_recahzo_todos()"/></td>
  </tr>
</table>
<? } ?>

<? if($sql_con[19]==2)
	echo '<input type="hidden" name="contrato_marco_si_no" value = "4">';
else
	echo '<input type="hidden" name="contrato_marco_si_no" value = "3">';

 ?>
</body>
</html>
