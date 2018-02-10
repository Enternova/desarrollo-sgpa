<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
      <tr >
        <td colspan="6" class="fondo_4">Creaci&oacute;n de tarifas manualmente</td>
        </tr>
      <tr>
        <td colspan="6"><table width="99%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="20%"><div align="right"><strong>Categor&iacute;a:</strong></div></td>
            <td width="52%"><label>
              <input type="text" name="categoria" id="categoria" value="<?=$categoria;?>" />
            </label></td>
            <td width="24%"><select name="categoria_existentes" id="categoria_existentes" onchange="document.principal.categoria.value= this.value; ajax_carga('../aplicaciones/tarifas/carga_grupos_existentes.php?id_contrato_arr=<?=$id_contrato_arr;?>&categoria_trae=' + this.value,'grupo__xistente')"> 
            <option>Categorias existentes</option>
             <?
			 	$busca_categorias = "select distinct categoria from $t3 where tarifas_contrato_id = $id_contrato_arr";
					$sql_cate=query_db($busca_categorias);
					while($lista_categoria=traer_fila_row($sql_cate))
						echo "<option value='".$lista_categoria[0]."'>".$lista_categoria[0]."</option>"
			 
			 ?>
            </select></td>
            <td width="4%"><strong><img src="../imagenes/botones/help.gif" alt="Si esta nueva tarifa debe estar en una categoria existente busquela en listado anterior y seleccionela, NOTA si no existe digitela en el campo de categoria" width="18" height="18" title="Si esta nueva tarifa debe estar en una categoria existente busquela en listado anterior y seleccionela, NOTA si no existe digitela en el campo de categoria" /></strong></td>
          </tr>
          <tr>
            <td><div align="right"><strong>Grupo:</strong></div></td>
            <td><input type="text" name="grupo" id="grupo" value="<?=$grupo;?>" /></td>
            <td id="grupo__xistente"><select name="grupo_existentes" id="grupo_existentes" > 
            <option>Grupos existentes</option>
             
            </select></td>
            <td id="grupo__xistente"><strong><img src="../imagenes/botones/help.gif" alt="Si esta nueva tarifa debe estar en un grupo existente busquela en listado anterior y seleccionela, NOTA si no existe digitela en el campo de grupo" width="18" height="18" title="Si esta nueva tarifa debe estar en un grupo existente busquela en listado anterior y seleccionela, NOTA si no existe digitela en el campo de grupo" /></strong></td>
          </tr>
          <tr>
            <td><div align="right"><strong>Inicio vigencia:</strong></div></td>
            <td><input type="text" name="fecha_vigencia" id="fecha_vigencia" value="<?=$fecha_vigencia;?>" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>          </td>
        </tr>
      <tr>
        <td width="8%" class="fondo_3"><div align="center">Codigo</div></td>
        <td width="53%" class="fondo_3"><div align="center">Nombre generico del producto / servicio</div></td>
        <td width="8%" class="fondo_3"><div align="center">Unidad </div></td>
        <td width="9%" class="fondo_3"><div align="center">Cantidad</div></td>
        <td width="8%" class="fondo_3"><div align="center">Moneda</div></td>
        <td width="14%" class="fondo_3"><div align="center">Valor</div></td>
      </tr>
      <tr>
        <td><label>
          <div align="center">
            <input name="codigo" type="text" id="codigo" size="2" />
            </div>
        </label></td>
        <td><label>
          <div align="center">
            <textarea name="detalle" id="detalle" cols="25" rows="1"></textarea>
            </div>
        </label></td>
        <td><div align="center">
          <input name="unidad" type="text" id="unidad" size="5" />
        </div></td>
        <td class="titulos_resumen_alertas"><div align="center">
          <input name="cantidad" type="text" id="cantidad" size="5" />
        </div></td>
        <td class="titulos_resumen_alertas"><div align="center">
          <select name="moneda" id="moneda">
            <?=listas($g5, " t1_moneda_id >=1",0,'nombre', 1);?>
                    </select>
        </div></td>
        <td class="titulos_resumen_alertas"><div align="center">
          <input name="valor" type="text" id="valor" size="10" />
        </div></td>
      </tr>
      <tr>
        <td colspan="6"><table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="32%">&nbsp;</td>
            <td width="33%"><input name="button2" type="button" class="boton_grabar" id="button2" value="Crear nueva tarifa a este contrato" onclick="crea_lista_tarifa_manual()" /></td>
            <td width="35%"><label></label></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="6"><div align="right"></div></td>
        </tr>

    </table>
      
    <?

	$busca_categorias = "select count(*) from $t3 where tarifas_contrato_id = $id_contrato_arr";
			$id_ingreso=traer_fila_row(query_db($busca_categorias));
			if($id_ingreso[0]>=1){ ?>

<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><img src="../imagenes/botones/chulo.jpg" alt="se refiere a tarifas cargadas en el inicio del contrato" width="23" height="20" titel='se refiere a tarifas cargadas en el inicio del contrato' />Se refiere a tarifas cargadas en el inicio del contrato, <img src="../imagenes/botones/alerta.png" width="16" height="16" title="se refiere a tarifas cargadas posteriormente del inicio del contrato" /> se refiere a tarifas cargadas posteriormente del inicio del contrato</td>
  </tr>
</table>

<? } else { ?>

<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><strong><img src="../imagenes/botones/help.gif" alt="El contrato no tiene tarifas cargadas hasta el momento" width="18" height="18" title="El contrato no tiene tarifas cargadas hasta el momento" /></strong> El contrato no tiene tarifas cargadas hasta el momento</td>
  </tr>
</table>

 <?
 } // si no tiene tarifas
 
	 	$busca_categorias = "select distinct categoria from $t3 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_tarifas_id in (1,2,5)";
		$sql_cate=query_db($busca_categorias);
		while($lista_categoria=traer_fila_row($sql_cate)){
	 
	 ?> 
      
      <table width="99%" border="0" cellspacing="2" cellpadding="2">
     	<? if(chop($lista_categoria[0])<>""){ ?>
        <tr>
          <td>
          
          	<table width="99%" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td class="titulos_secciones"><?=$lista_categoria[0];?></td>
            </tr>
          </table></td>
        </tr>
            <? } ?>        
        
        <tr>
          <td>

     <?
	 	$busca_grupos = "select distinct grupo from $t3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' and t6_tarifas_estados_tarifas_id in (1,2,5)";
		$sqlgrupo=query_db($busca_grupos);
		while($lista_grupos=traer_fila_row($sqlgrupo)){//grupos
	
	 ?> 
          
          <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
           <? if(chop($lista_grupos[0])<>""){ ?>
            <tr >
              <td colspan="12" class="fondo_4">GRUPO: <?=$lista_grupos[0];?></td>
            </tr>
            <? } ?>
            <tr>
              <td width="5%" class="fondo_3">Origen</td>
              <td width="5%" class="fondo_3"><div align="center">Codigo</div></td>
              <td width="35%" class="fondo_3"><div align="center">Nombre generico del producto / servicio</div></td>
              <td width="5%" class="fondo_3"><div align="center">Unidad </div></td>
              <td width="6%" class="fondo_3"><div align="center">Cantidad</div></td>
              <td width="6%" class="fondo_3">Moneda</td>
              <td width="8%" class="fondo_3"><div align="center">Valor</div></td>
              <td width="11%" class="fondo_3">Inicio vigencia</td>
              <td width="7%" class="fondo_3">Modificada</td>
              <td width="8%" class="fondo_3">Aprobaci&oacute;n</td>
              <td colspan="2" class="fondo_3">Ver</td>
            </tr>
            
                 <?
	 	$busca_detalle = "select * from $v_t_3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' and grupo = '$lista_grupos[0]' and t6_tarifas_estados_tarifas_id in (1,2,5) order by fecha_creacion desc";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//detalle
		if($lista_detalle[12]==1) $tipo_creacion='<img src="../imagenes/botones/chulo.jpg" alt="se refiere a tarifas cargadas en el inicio del contrato" width="23" height="20" titel="se refiere a tarifas cargadas en el inicio del contrato" />';
		else $tipo_creacion='<img src="../imagenes/botones/alerta.png" width="16" height="16" title="se refiere a tarifas cargadas posteriormente del inicio del contrato" />';
	

	 	
		$cuenta_tarifas_modificadas=traer_fila_row(query_db("select t6_tarifas_lista_id, nombre_estado_tarifa from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id <> $lista_detalle[15]  order by t6_tarifas_lista_id desc"));
	 	if($cuenta_tarifas_modificadas[0]>=1){//verifica si tienes otras tarifas creadas en esta tarifa
			$cuenta_tarifas_modificadas_nu=traer_fila_row(query_db("select count(*) from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id <> $lista_detalle[15] "));	
			$estado_tarifa = $cuenta_tarifas_modificadas[1];
			$modificada = "SI (".$cuenta_tarifas_modificadas_nu[0].")";
		}
		else
		{//verifica si tienes NO otras tarifas creadas en esta tarifa
			$estado_tarifa = $lista_detalle[16];
			$modificada = "NO";
		}
			
	 ?> 
            
            <tr class="filas_resultados">
              <td><?=$tipo_creacion;?></td>
              <td><?=$lista_detalle[4];?></td>
              <td><?=$lista_detalle[5];?></td>
              <td><div align="center"><?=$lista_detalle[6];?></div></td>
              <td class="titulos_resumen_alertas"><div align="center"><?=$lista_detalle[7];?></div></td>
              <td class="titulos_resumen_alertas"><div align="center"><?=$lista_detalle[18];?></div></td>
              <td class="titulos_resumen_alertas"><div align="center">
                <input name="valor_tarifa_<?=$lista_detalle[0];?>" type="text" id="valor_tarifa_<?=$lista_detalle[0];?>" value="<?=$lista_detalle[9];?>" size="30" />
              </div></td>
              <td class="titulos_resumen_alertas"><input name="vigencia_tarifa_<?=$lista_detalle[0];?>" type="text" id="vigencia_tarifa_<?=$lista_detalle[0];?>" value="<?=$lista_detalle[14];?>" size="30" /></td>
              <td class="titulos_resumen_alertas"><?=$modificada;?></td>
              <td class="titulos_resumen_alertas"><?=$estado_tarifa;?></td>
              <td width="2%" class="titulos_resumen_alertas"><img src="../imagenes/botones/editar.jpg" alt="Editar tarifa" title="Editar tarifa" width="14" height="15" onclick="edita_tarifa('<?=arreglo_pasa_variables($lista_detalle[0]);?>',document.principal.valor_tarifa_<?=$lista_detalle[0];?>)" /></td>
              <td width="2%" class="titulos_resumen_alertas"><img src="../imagenes/botones/b_cancelar.gif" alt="Eliminar tarifa" title="Eliminar tarifa" width="16" height="16" /></td>
            </tr>
           <? }//detalle ?>
          </table>
            <br />
          <? }//grupos ?>
          
          </td>
        </tr>
      </table>

      <? } ?>
      </td></tr></table>
<input type="hidden" name="id_tarifa" />
</body>
</html>
