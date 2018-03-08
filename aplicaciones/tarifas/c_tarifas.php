<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/html; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';			

					

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));	
		if($sql_con[11]==2) $java_script="edita_tarifa_parcial";
	else $java_script="edita_tarifa";
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="2" class="titulos_secciones_tarifas">SECCION:<span class="titulos_resaltado_procesos_tarifas"> CREACION DE TARIFAS &gt;&gt; CONTRATO:
          <?=numero_cotnrato_tarifas($id_contrato_arr);?>
    </span></td>
    <td width="16%" ><input type="button" name="button3" class="boton_volver"  id="button3" value="Volver al contrato" onclick="ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','carga_acciones_permitidas')" /></td>
  </tr>
  <tr>
    <td width="25%" ><div align="right"><strong><span class="titulos_resaltado_subtitulos_tarifas">Proveedor:</span></strong></div></td>
    <td colspan="2" ><span class="titulos_resaltado_subtitulos_contenidostarifas">
      <?=$sql_con[6];?>
    </span></td>
  </tr>
  <tr>
    <td valign="top" ><div align="right"><strong><span class="titulos_resaltado_subtitulos_tarifas">Objeto del contrato:</span></strong></div></td>
    <td colspan="2" ><span class="titulos_resaltado_subtitulos_contenidostarifas">
      <?=$sql_con[9];?>
    </span></td>
  </tr>
</table>
<br />
<table width="99%" border="0" align="center" cellpadding="0" cellspacing="0">
  <tr>
    <td colspan="3" valign="top" class="fondo_2_sub">Seleccione una lista de este contrato</td>
  </tr>

  <tr>
    <td  valign="top">&nbsp;</td>
    <td colspan="2" valign="top" >&nbsp;</td>
  </tr>
    <?
if($lista_existentes==""){//si no  selecciono una lista

$selec_lista = traer_fila_row(query_db("select * from $t12 where tarifas_contrato_id = $id_contrato_arr"));
$lista_existentes = $selec_lista[0];
}//si no  selecciono una lista  
  
  ?>
  <tr>
    <td width="5%" height="22" valign="top" class="fondo_6"><img src="../imagenes/botones/nuevo_descriptor.gif" alt="Nuevo descriptor" width="32" height="32" /></td>
    <td colspan="2" valign="top" class="fondo_6" ><div align="left">SELECCIONE UNA LISTA:
        <select name="lista_existentes" id="lista_existentes" class="select_ancho_automatico" onchange="ajax_carga('../aplicaciones/tarifas/c_tarifas.php?id_contrato=<?=$id_contrato;?>&amp;lista_existentes=' + this.value,'carga_acciones_permitidas')">
          <?=listas($t12, " tarifas_contrato_id = $id_contrato_arr",$lista_existentes,'nombre', 2);?>
          </select>
    </div></td>
  </tr>
  <tr>
    <td valign="top"><div align="right"></div></td>
    <td width="2%" valign="top"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /></td>
    <td width="93%" valign="top"><div align="justify"><strong>Seleccione la lista a la que desea configurar descriptores o modificar las propiedades de la misma.</strong></div></td>
  </tr>  
</table>

<br />
<?

if($lista_existentes>=1){//si ya selecciono una lista
$buscar_lista = traer_fila_row(query_db("select * from $t12 where t6_tarifas_listas_lista_id = $lista_existentes"));

?>

<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="fondo_5"><strong>Usted ha seleccionado la lista:<?=$buscar_lista[2];?></strong></td>
  </tr>
</table>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top"><table width="98%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
      <tr >
        <td colspan="6" class="fondo_2_sub">Creaci&oacute;n de tarifas manualmente</td>
      </tr>
      <tr>
        <td colspan="6"><table width="99%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="20%"><div align="right"><strong><?=TITULO_2;?>:</strong></div></td>
            <td width="52%"><label>
              <input type="text" name="categoria" id="categoria" value="<?=$categoria;?>" />
            </label></td>
            <td width="24%"><select name="categoria_existentes" id="categoria_existentes" onchange="document.principal.categoria.value= this.value; ajax_carga('../aplicaciones/tarifas/carga_grupos_existentes.php?id_contrato_arr=<?=$id_contrato_arr;?>&categoria_trae=' + this.value,'grupo__xistente')"> 
            <option>Categorias existentes</option>
             <?
			 	$busca_categorias = "select distinct categoria from $t3 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_listas_lista_id = $lista_existentes";
					$sql_cate=query_db($busca_categorias);
					while($lista_categoria=traer_fila_row($sql_cate))
						echo "<option value='".$lista_categoria[0]."'>".$lista_categoria[0]."</option>"
			 
			 ?>
            </select></td>
            <td width="4%"><strong><img src="../imagenes/botones/help.gif" alt="Si esta nueva tarifa debe estar en una categoria existente busquela en listado anterior y seleccionela, NOTA si no existe digitela en el campo de categoria" width="18" height="18" title="Si esta nueva tarifa debe estar en una categoria existente busquela en listado anterior y seleccionela, NOTA si no existe digitela en el campo de categoria" /></strong></td>
          </tr>
          <tr>
            <td><div align="right"><strong><?=TITULO_3;?>:</strong></div></td>
            <td><input type="text" name="grupo" id="grupo" value="<?=$grupo;?>" /></td>
            <td id="grupo__xistente"><select name="grupo_existentes" id="grupo_existentes" > 
            <option>Grupos existentes</option>
             
            </select></td>
            <td id="grupo__xistente"><strong><img src="../imagenes/botones/help.gif" alt="Si esta nueva tarifa debe estar en un grupo existente busquela en listado anterior y seleccionela, NOTA si no existe digitela en el campo de grupo" width="18" height="18" title="Si esta nueva tarifa debe estar en un grupo existente busquela en listado anterior y seleccionela, NOTA si no existe digitela en el campo de grupo" /></strong></td>
          </tr>
          <tr>
            <td><div align="right"><strong><?=TITULO_9;?>:</strong></div></td>
            <td><input type="text" name="fecha_vigencia_creacion" id="fecha_vigencia_creacion" value="<?=$fecha_vigencia;?>" onmousedown="calendario_sin_hora('fecha_vigencia_creacion')"  /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div align="right"><strong>
              <?=TITULO_18;?>
              :</strong></div></td>
            <td><input type="text" name="fecha_vigencia_creacion_final" id="fecha_vigencia_creacion_final" value="<?=$fecha_vigencia_creacion_final;?>" onmousedown="calendario_sin_hora('fecha_vigencia_creacion_final')"  /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>          </td>
        </tr>
     <tr>
     <td align="center">
    
      <table  border="0" align="center">
            
		  <td style="vertical-align:top" width="1%">
                    <table width="506" border=0 cellpadding="2"  cellspacing="2" id="encabezado2">
                        <tr><td width="188"  class="fondo_3"><?=TITULO_5;?></td><td width="304"  class="fondo_3"><?=TITULO_6;?></td></tr>
                        <tr><td><input name="codigo_creacion" type="text" id="codigo_creacion" size="2"  /></td>
                      <td><textarea name="detalle_creacion" id="detalle_creacion" cols="25" rows="1" class="textarea_tarifas_300"></textarea></td></tr>
                    </table>
            </td>

                <td style="vertical-align:top">
<?

	$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
	while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
	$titulos_atributos.="<th  class='fondo_3'>".valida_espacio_lista($lista_atr[4])."</th>";
	$ayuda_campo_editar.='<td><input name="detalle_campo_descriptor['.$lista_atr[0].']" type="text" id="nombre_nuevo_atributo" class="campos_tarifas" /></td>';
	$cuenta_atribu++;
	} //lista atributos

?>  
                
                <div style="overflow:auto; overflow-y:hidden; width:520px; padding:0"	>
                <table width="394" border=0 align="left" cellpadding="2" cellspacing="2" bgcolor=white id="datos2">
					<tr >
                    	<th  class="fondo_3" width="80px"><?=TITULO_4;?></th>
                        
                        <th class="fondo_3" width="100px"><?=TITULO_7;?></th>
                        <th class="fondo_3" width="100px"><?=TITULO_8;?></th>
                        <?=$titulos_atributos;?>
                     </tr>
					<tr>
                    <td> <input name="cantidad_creacion" type="hidden" id="cantidad_creacion" size="5"value="0"  /><input name="unidad_creacion" type="text" id="unidad_creacion" size="5" /></td>
                 
                    <td> <select name="moneda_creacion" id="moneda_creacion" ><?=listas($g5, " t1_moneda_id >=1",0,'nombre', 1);?>
                    </select></td><td><input name="valor_creacion" type="text" id="valor_creacion" size="10" onkeyup='checkDecimals_2(this.name, this.value,this)' onpaste="return false;"/></td>
					<?=$ayuda_campo_editar;?>
                   </tr>                 
     
</table>

</div>

</td>

</table>     
     
     </td>

	</tr>


  
      <tr>
        <td colspan="6"><table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="32%">&nbsp;</td>
            <td width="33%"><input name="button2" type="button" class="boton_grabar" id="button2" value="Crear nueva tarifa a este contrato" onclick="crea_lista_tarifa_manual()" /></td>
            <td width="35%"></td>
          </tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="6"><div align="right"></div></td>
        </tr>

    </table>
      
      <p><br />
  <br />
        <br />
  <input type="hidden" name="id_tarifa" />
  <input type="hidden" name="id_lista" value="<?=$lista_existentes;?>">
  <input type="hidden" name="id_nombre_edita">
        
        <?

  
 	
      } //si ya selecciono una lista ?>

</body>
</html>
