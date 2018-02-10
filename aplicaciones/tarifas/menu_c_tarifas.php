<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/html; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
 $busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));	


	
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
    <td colspan="2" class="titulos_secciones_tarifas">SECCION:<span class="titulos_resaltado_procesos_tarifas"> CONFIGURACION DE LISTAS &gt;&gt; CONTRATO:
      <?=numero_cotnrato_tarifas($id_contrato_arr);?>
    </span></td>
    <td width="13%" ><span class="titulos_secciones"><input type="button" name="button8" class="boton_volver"  id="button8" value="Volver al contrato" onclick="ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','carga_acciones_permitidas')" /></span></td>
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
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td width="4%" valign="top"><img src="../imagenes/botones/nueva_lista.gif" alt="Nueva lista"  title="Nueva lista" width="32" height="32" longdesc="Nueva lista" /></td>
    <td width="38%" height="22" valign="top"><input type="text" name="nueva_lista_lista" id="nueva_lista_lista" /></td>
    <td width="11%" valign="top"><input name="button" type="button" class="boton_grabar" id="button" value="Crear lista" onclick="crear_lista_tarifas_lista()" /></td>
    <td valign="top">&nbsp;</td>
    <td valign="top"><img src="../imagenes/botones/nuevo_descriptor.gif" alt="Nuevo descriptor" width="32" height="32" /></td>
    <td valign="top">
      <select name="lista_existentes" id="lista_existentes" onchange="ajax_carga('../aplicaciones/tarifas/menu_c_tarifas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=' + this.value,'carga_acciones_permitidas')">
      <?=listas($t12, " tarifas_contrato_id = $id_contrato_arr",$lista_existentes,'nombre', 2);?>
      </select>    </td>
  </tr>
  <tr>
    <td width="4%" valign="top"><div align="right"><img src="../imagenes/botones/help.gif" width="18" height="18" /></div></td>
    <td height="22" colspan="2" valign="top"> <div align="justify">Puede crear diferentes listas para clasificar las tarifas, digite el nombre de la lista y luego presione el bot&oacute;n Crear lista.</div></td>
    <td width="5%" valign="top">&nbsp;</td>
    <td width="4%" valign="top"><div align="right"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18" /></div></td>
    <td width="38%" valign="top"><div align="justify">Seleccione la lista a la que desea configurar descriptores o modificar las propiedades de la misma.</div></td>
  </tr>
  </table>

<?

if($lista_existentes>=1){//si ya selecciono una lista
$buscar_lista = traer_fila_row(query_db("select * from $t12 where t6_tarifas_listas_lista_id = $lista_existentes"));

?>

<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_secciones">Operaciones con la lista:<?=$buscar_lista[2];?></td>
  </tr>
</table>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" class="fondo_4">Solo modificar nombre de la lista</td>
  </tr>
  <tr>
    <td width="20%"><div align="right"><strong>Nuevo nombre de la lista:</strong></div></td>
    <td width="59%"><input type="text" name="modifica_nomre" id="modifica_nomre" value="<?=$buscar_lista[2];?>" /></td>
    <td width="21%"><input type="button" name="button3" class="boton_edicion" id="button3" value="Modificar nombre de la lista" onclick="modificar_lista_tarifas_lista()" /></td>
  </tr>
</table>
<br />
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="4" class="fondo_4">Copiar lista y descriptores al mismo contrato o a otro contrato</td>
  </tr>
  <tr>
    <td width="20%"><div align="right"><strong><img src="../imagenes/botones/help.gif" alt="Si desea copiar la lista es necesario que digite un nuevo nombre de lista" width="18" height="18" title="Si desea copiar la lista es necesario que digite un nuevo nombre de lista" /> Re nombrar  la  lista:</strong></div></td>
    <td colspan="2"><input type="text" name="nuevo_nombre_lista_re" id="nuevo_nombre_lista_re" /></td>
    <td width="19%" rowspan="2"><input type="button" name="button4" class="boton_edicion" id="button4" value="Realizar copia de la lista" onclick="copiar_descritores_tarifas()" /></td>
  </tr>
  <tr>
    <td><div align="right">Destino de la lista:</div></td>
    <td width="25%"><select name="destino_lista" id="destino_lista">
      <option value="1" selected="selected">En el mismo contrato</option>
      <option value="2">Otro contrato existente</option>
    </select>    </td>
    <td width="36%">Buscar contrato:<input type="text" name="tarifas_busca_contratos" class="campos_tarifas" id="tarifas_busca_contratos" onkeypress="selecciona_lista()"  /></td>
  </tr>
</table>
<p>&nbsp;</p>
<? if($sql_con[11]!=3){ ?>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="fondo_4">Vaciar tarifas de esta lista</td>
  </tr>
  <tr>
    <td><p><strong>ATENCI&Oacute;N: Si elige esta opci&oacute;n se eliminaran todas las  tarifas y descriptores creados en esta lista.</strong></p></td>
    <td width="21%"><input type="button" name="button6" class="boton_edicion" id="button6" value="Vaciar lista" onclick="vaciar_lista_tarifas_lista()" /></td>
  </tr>
</table>
<br />
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="2" class="fondo_4">Eliminar esta lista</td>
  </tr>
  <tr>
    <td><p>ATENCI&Oacute;N: Si elige esta opci&oacute;n se eliminaran la lista y todas  las tarifas y descriptores creados en esta.</p></td>
    <td width="21%"><input type="button" name="button7" class="boton_edicion" id="button7" value="Eliminar lista" onclick="eliminar_lista_tarifas_lista()" /></td>
  </tr>
</table>
<? } // permite eliminar si no esta en firme ?>
<p>&nbsp;</p>
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_secciones">Administraci&oacute;n de los descriptores de la lista:<?=$buscar_lista[2];?></td>
  </tr>
</table>
<table  border="0" align="center">
            
		  <td style="vertical-align:top" width="1%">
                    <table border=0  cellspacing="2" cellpadding="2" id="encabezado2">
                        <tr>
                        	<td  class="fondo_3">Codigo</td>
                            <td  class="fondo_3">Nombre generico del producto / servicio</td>
                        </tr>
                        <tr>
                            <td><input name="codigo" type="text" id="codigo" size="2" readonly="readonly" /></td>
                            <td><textarea name="detalle" id="detalle" cols="25" rows="1" class="textarea_tarifas_300"></textarea></td>
                        </tr>
                    </table>
            </td>

                <td style="vertical-align:top">

<?

	$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
	while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
	$titulos_atributos.="<th colspan='2' class='fondo_3'>".valida_espacio_lista($lista_atr[4])."</th>";
	$ayuda_campo_editar.='<td><img src="../imagenes/botones/help.gif" alt="Si desea modificar el titulo del descriptor, modifiquelo en el siguiente campo y presione el botón modificar si requiere eliminarlo presione el botón eliminar " width="18" height="18" title="Si desea modificar el titulo del descriptor, modifiquelo en el siguiente campo y presione el botón modificar si requiere eliminarlo presione el botón eliminar" /></td>
                        <td><input name="nombre_nuevo_atributo_edita_'.$lista_atr[0].'" type="text"  size="10" value="'.$lista_atr[4].'" /></td>';
    $ayuda_tipo_editar.='<td><img src="../imagenes/botones/help.gif" alt="Si desea modificar el tipo de descriptor, seleccione el tipo de campo Ej: si usted desea que solo digiten valores numericos seleccione la opción numerico" longdesc="Si desea modificar el tipo de descriptor, seleccione el tipo de campo Ej: si usted desea que solo digiten valores numericos seleccione la opción numerico" width="18" height="18" title="Si desea modificar el tipo de descriptor, seleccione el tipo de campo Ej: si usted desea que solo digiten valores numericos seleccione la opción numerico" /></td>
                        <td><select name="tipo_descriptor_edita_'.$lista_atr[0].'" id="tipo_descriptor">'.listas($g16, " t1_tipo_campo_digitacion_id >=1",$lista_atr[3],'nombre', 1).'</select>                        </td>';
	$modifica_editar.='<td>&nbsp;</td><td><input name="button2" type="button" value="Modificar" id="button2" class="boton_edicion" onclick="modificar_atributo_lista('.$lista_atr[0].')"></td>';
	$modifica_eliminar.='<td>&nbsp;</td><td><input name="button2" type="button" value="Eliminar&nbsp;&nbsp;" id="button2" class="boton_eliminar" onclick="elimina_descriptor_tarifas('.$lista_atr[0].')"></td>';
	
	} //lista atributos

?>                
                
            <div style="overflow:auto; overflow-y:hidden; width:600px; padding:0"	>
                <table border=0 cellspacing="2" cellpadding="2" id="datos2" bgcolor=white>
					<tr >
                    	<th  class="fondo_3">Unidad</th>
                        <th class="fondo_3">Cantidad</th>
                        <th class="fondo_3">Moneda</th>
                        <th class="fondo_3">Valor</th>
                        <?=$titulos_atributos;?>
                        <th colspan="2" class="fondo_4">Nuevo_descriptor</th>
                   </tr>
					<tr>
                    	<td> <input name="unidad" type="text" id="unidad" size="5" /></td>
                        <td><input name="cantidad" type="text" id="cantidad" size="5" /></td>
                        <td> <select name="moneda" id="moneda"><?=listas($g5, " t1_moneda_id >=1",0,'nombre', 1);?></select></td>
                        <td><input name="valor" type="text" id="valor" size="10" /></td>
                        <?=$ayuda_campo_editar;?>
                        <td><img src="../imagenes/botones/help.gif" alt="Digite el nombre del atributo complemento de la lista" width="18" height="18" title="Digite el nombre del atributo complemento de la lista" /></td>
                        <td><input name="tipo_descriptor" type="hidden" id="tipo_descriptor" size="10" value="1" /><input name="nombre_nuevo_atributo" type="text" id="nombre_nuevo_atributo" size="10" /></td>
                   </tr>   
					                             
<tr>
                    	<td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
                        <td>&nbsp;</td>
						<?=$modifica_editar;?>
                        <td>&nbsp;</td>
                        <td><input name="button2" type="button" value="Crear descriptor" id="button2" class="boton_grabar" onclick="crear_atributo_lista()"></td>
                   </tr>
					<tr>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
                      <?=$modifica_eliminar;?>
					  <td>&nbsp;</td>
					  <td>&nbsp;</td>
				  </tr>                                    
			</table>

		</div>

</td>

</table>
<? }//si ya selecciono una lista ?>

<input type="hidden" name="id_lista" value="<?=$lista_existentes;?>">
<input type="hidden" name="id_descriptor" >
<input type="hidden" name="modifica_nomre_compara" id="modifica_nomre_compara" value="<?=$buscar_lista[2];?>" />
</body>
</html>
