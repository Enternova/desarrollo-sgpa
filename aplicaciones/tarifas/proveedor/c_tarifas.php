<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
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
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="91%" class="titulos_secciones">SECCION:<span class="titulos_resaltado_procesos"> CONTRATO:
       <?=numero_cotnrato_tarifas($id_contrato_arr);?>     
    </span></span>&gt;&gt;  CREACION DE TARIFAS </td>
    <td width="9%" class="titulos_secciones"><input type="button" name="button5" class="boton_volver" id="button5" value="Volver al detalle del contrato" onclick="ajax_carga('../aplicaciones/tarifas/proveedor/v_contratos.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','contenidos')" /></td>
  </tr>
</table>

<br />
<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
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
        <select name="lista_existentes" id="lista_existentes" class="select_ancho_automatico" onchange="ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas.php?id_contrato=<?=$id_contrato;?>&amp;lista_existentes=' + this.value,'carga_acciones_permitidas')">
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

$factor_b_c = 50;
	$factor_b = 50;
	if($pagina<=1){//si no tiene pagina seleccionada
		$inicio = 0;
		
		}
	else{
		
		 $inicio= (($pagina-1)*$factor_b);
		$factor_b =( $factor_b * ($pagina-1)) + $factor_b;
		}

$where_general = " tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_estados_tarifas_id in (8) and t6_tarifas_listas_lista_id = $lista_existentes". $bus_tarifa_c;

  $sql_cuenta2 = "select  count(*) from  $v_t_3 where $where_general";
	 $sql_cuenta=traer_fila_row(query_db($sql_cuenta2));
	 $lista_pagina = ceil( ( $sql_cuenta[0] / $factor_b_c ) );	
?>

   <? 
	 echo busca_tarifas_aiu($id_contrato_arr,1);
	 ?> 
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
      <tr >
        <td colspan="6" class="fondo_2_sub">Creaci&oacute;n de tarifas manualmente</td>
      </tr>
      <tr>
        <td colspan="6"><table width="99%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="26%"><div align="right"><strong>Categoria<br />
              </strong>(Este campo es obligatorio).  Hace alusi&oacute;n al Proyecto (VSM,VIM, LLANOS) o Pozo (La Hocha, La Ca&ntilde;ada, Ocelote), si las tarifas aplican para el territorio nacional colocar &quot;Corporativo&quot;<strong>:</strong></div></td>
            <td width="46%"><label>
              <input type="text" name="categoria" id="categoria" value="<?=$categoria;?>" />
            </label></td>
            <td width="24%">
            
            <input type="hidden" name="categoria_existentes" id="categoria_existentes" value="" /></td>
            <td width="4%"><strong></strong></td>
          </tr>
          <tr>
            <td><div align="right"><strong>Grupo <br />
              </strong>Este campo es obligatorio siempre y cuando las tarifas tengan una divisi&oacute;n dentro de ellas y de &eacute;stas se generen diferentes tipos de servicios, actividades o subgrupos (ej.: n&oacute;mina, tesorer&iacute;a, clase de aceite, ej.: Terpel, Lumax).<strong> :</strong></div></td>
            <td><input type="text" name="grupo" id="grupo" value="<?=$grupo;?>" /></td>
            <td id="grupo__xistente"><input type="hidden" name="grupo_existentes" id="grupo_existentes" value="" /></td>
            <td id="grupo__xistente"><strong></strong></td>
          </tr>
          <tr>
            <td><div align="right">Inicio Vigencia (Fecha en la cual empieza a regir la  nueva tarifa<strong>):</strong></div></td>
            <td><input type="text" name="fecha_vigencia" id="fecha_vigencia" value="<?=$fecha_vigencia;?>" onmousedown="calendario_sin_hora('fecha_vigencia')"  readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
          <tr>
            <td><div align="right">Fin Vigencia (Fecha de caducidad diferente a la finalizaci&oacute;n del contrato, NO obligatorio<strong>):</strong></div></td>
            <td><input type="text" name="fecha_vigencia_fin" id="fecha_vigencia_fin" value="<?=$fecha_vigencia_fin;?>" onmousedown="calendario_sin_hora('fecha_vigencia_fin')"  readonly="readonly" /></td>
            <td>&nbsp;</td>
            <td>&nbsp;</td>
          </tr>
        </table>          </td>
        </tr>
     <tr>
     <td align="center">
    
      <table  border="0" align="center">
            
		  <td style="vertical-align:top" width="1%">
                    <table width="600" border=0 cellpadding="2"  cellspacing="2" id="encabezado2">
                        <tr><td align="center"  class="fondo_3"><strong><?=TITULO_5;?> </strong><br />
                          <?=TITULO_5b;?></td><td align="center"  class="fondo_3"><strong><?=TITULO_6;?> </strong><br />
                      (Este campo es obligatorio).  Tipo de servicio que se est&aacute; prestando.</td></tr>
                        <tr><td><input name="codigo" type="text" id="codigo" size="2"  /></td><td><textarea name="detalle" id="detalle" cols="20" rows="1" class="textarea_tarifas_300"></textarea></td></tr>
              </table>            </td>

                <td style="vertical-align:top" align="left">
<?

	$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
	while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
	$titulos_atributos.="<th  class='fondo_3'>".valida_espacio_lista($lista_atr[4])."</th>";
	$ayuda_campo_editar.='<td><input name="detalle_campo_descriptor['.$lista_atr[0].']" type="text" id="nombre_nuevo_atributo" size="10" /></td>';
	
	} //lista atributos

?>  
                
                <div style="overflow:auto; overflow-y:hidden; width:580px; padding:0; text-align:left" 	>
                <table border=0 align="left" cellpadding="2" cellspacing="2" bgcolor=white id="datos2">
					<tr >
                    	<th width="277" align="center"  class="fondo_3"><strong><?=TITULO_4;?></strong><br />
                   	    (Este campo es obligatorio).<br />
                   	    Medida utilizada para medir el servicio (ej.: km, gal&oacute;n, d&iacute;a, mes, etc.) m&aacute;ximo 50 caracteres</th>
                        <th width="119" class="fondo_3"><strong><div align="center"><?=TITULO_7;?></div></strong></th>
                        <th width="164" class="fondo_3"><strong><div align="center"><?=TITULO_8;?></div></strong></th>
                        <?=$titulos_atributos;?>
                    </tr>
					<tr>
                    <td> <input name="unidad" type="text" id="unidad" size="5" /></td>
                    <td> <select name="moneda" id="moneda"><?=listas($g5, " t1_moneda_id >=1",0,'nombre', 1);?></select></td>
                    <td><input name="valor" type="text" id="valor" size="10" onkeyup='checkDecimals_2(this.name, this.value,this)' onpaste="return false;"/></td>
					<?=$ayuda_campo_editar;?>
                    <input name="cantidad" type="hidden" id="cantidad" size="5" value="0" />
                   </tr>                 
</table>
</div></td>

</table>     
      <table width="70%" border="0" align="left">
        <? if($sql_con[19]==2){ //si es contrato marco ?>
        <tr>
          <td><div align="right"><strong>Quien solicita crear la tarifa:</strong></div></td>
          <td width="50%" align="left"><? if($lista_detalle[13]!=3){//si esta pendiente de aprobacion{ ?>
              <select name="aprobacion_secundaria_0" id="aprobacion_secundaria_0" class="campos_tarifas_select">
              <option value="0">Seleccione</option>
             <!-- Pone siemopre de primero el gerente del contrato-->
             	 <option value="<?=$sql_con[14]?>"><? echo saca_nombre_lista($g1,$sql_con[14],'nombre_administrador','us_id');?></option>
             <!-- Pone siemopre de primero el gerente del contrato-->
              
                 <? $sel_usuarios = query_db("select $g1.us_id, $g1.nombre_administrador from $g1 where  $g1.estado = 1 and $g1.tipo_usuario <> 2 and $g1.email like '%@hocol.com.co%' order by $g1.nombre_administrador"); 
		  while($sel_us = traer_fila_db($sel_usuarios)){
			  $busca_si_es_profesional = traer_fila_row(query_db("select count(*) from tseg5_usuario_permisos where id_usuario = ".$sel_us[0]." and id_permiso in (8,9, 20, 35, 43, 45)"));
			  
			  if($busca_si_es_profesional[0]==0 and ($sel_us[0] <> 17989 and $sel_us[0] <> 23 and $sel_us[0] <> 17 and $sel_us[0] <> 17931 and $sel_us[0] <> 17968 and $sel_us[0] <> 18056 and $sel_us[0] <> 62) ){//si no es un profesional de abastecimiento
		  ?>
          <option value="<?=$sel_us[0]?>"><?=$sel_us[1]?></option>
          <?
			  }
		  }
		  ?>
              </select>
              <? } //si esta pendiente de aprobacion{ ?>          </td>
        </tr>
        <tr>
          <td><p align="right"><strong>Desea informarle a alguien adicional la creaci&oacute;n de la  tarifa:</strong></p></td>
          <td align="left"><? if($lista_detalle[13]!=3){//si esta pendiente de aprobacion{ ?>
              <select name="copia_0" id="copia_0" class="campos_tarifas_select" onchange="ajax_carga('../aplicaciones/tarifas/proveedor/lista_usuarios_copia.php?act_cc=' + this.value + '&amp;id_tarifa_pasa=0','carga_usuario_copia_<?=$lista_detalle[0];?>')">
                <option value="0">Seleccione</option>
                <option value="1">Si</option>
                <option value="2">No</option>
              </select>
              <? } //si esta pendiente de aprobacion{ ?>          </td>
        </tr>
        <tr>
          <td></td>
          <td id="carga_usuario_copia_<?=$lista_detalle[0];?>"></td>
        </tr>
        <? } //si es contrato marco ?>

        <tr>
          <td><div align="right"><strong>La tarifa aplica descuento:</strong></div></td>
          <td><select name="descuento_uni_0" id="descuento_uni_<?=$lista_detalle[0];?>">
                      <option value="0">Seleccione</option>
                      <option value="1">Si</option>
                      <option value="2">No</option>
                    </select></td>
        </tr>
        <tr>
          <td width="50%"><div align="right">
            <ol>
              <ol>
                <li>Observaciones  (Con base en la tarifa que se est&aacute; cargando)<strong>:</strong></li>
              </ol>
            </ol>
          </div></td>
          <td><? if($lista_detalle[13]!=3){//si esta pendiente de aprobacion ?>
              <textarea name="observa_soporte_0" cols="10" rows="5" class="campos_tarifas" id="observa_soporte_0"><?=$busca_soporte[2];?></textarea>
              <? } //si esta pendiente de aprobacion
						else{ echo 	$busca_soporte[2];				} ?>          </td>
        </tr>
       
        <tr>
          <td width="50%" ><div align="right"><strong>Anexo soporte: <span class="titulo_calendario_real_mal">Solo anexos en formato .ZIP &oacute; .RAR</span></strong></div></td>
          <td><input type="file" name="anexo_soporte_0" id="fileField2" /></td>
        </tr>
      </table></td>
	</tr>


  
      <tr>
        <td colspan="6"><table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="32%">&nbsp;</td>
            <td width="33%"><input name="button2" type="button" class="boton_grabar" id="button2" value="Crear y confirmar nueva tarifa" onclick="crea_lista_tarifa_manual('')" /></td>
            <td width="35%"><label></label></td>
          </tr>
        </table></td>
      </tr>

    </table>

      <br />
      <?

	$busca_categorias = "select count(*) from $t3 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_listas_lista_id = $lista_existentes  and t6_tarifas_estados_tarifas_id in (8,9)";
			$id_ingreso=traer_fila_row(query_db($busca_categorias));
			if($id_ingreso[0]>=1){ ?>

      <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="2" class="fondo_2_sub" valign="top">Confirmar creaci&oacute;n de tarifas</td>
        </tr>
        <tr>
          <td width="4%"><img src="../imagenes/botones/envia_confirmacion.gif" alt="Enviar confirmacion" width="32" height="32" /></td>
          <td width="96%"><span class="fondo_5">ATENCION:</span> <strong>Solo si ya esta seguro de haber terminado la creaci&oacute;n de todas las nuevas tarifas presione el siguiente bot&oacute;n &quot;Confirmar creaci&oacute;n de tarifas&quot;, esta acci&oacute;n notificara a HOCOL SA sobre la creaci&oacute;n y porcederan con la validaci&oacute;n y aprobaci&oacute;n; Si no ha terminado no  ejecute el boton siga creando el sistema guardara las creaciones incluso si sale del sistema.</strong></td>
        </tr>
        <tr>
          <td colspan="2"><div align="left"><input type="button" name="button" class="boton_email" id="button" value="Confirmar creaci&oacute;n de tarifas" onclick="confirma_actualizacion_crea()" /> 
            <span class="letra-descuentos"><strong>Recuerde revisar el saldo del contrato con HOCOL, esta modificaci&oacute;n&nbsp; &oacute; inclusi&oacute;n de tarifas puede requerir Aprobaciones internas.</strong></span></div></td>
        </tr>
      </table>
      <br />
      <br />
 <?
 } // si no tiene tarifas
 
      
      
      } //si ya selecciono una lista ?>
<input type="hidden" name="id_tarifa" />
<input type="hidden" name="inicio_contrato" value="<?=$sql_con[20];?>" />
<input type="hidden" name="vigencia_contrato" value="<?=$sql_con[21];?>" />
<input type="hidden" name="id_lista" value="<?=$lista_existentes;?>">
<input type="hidden" name="ruta_devuelve" value="c_tarifas" />
</body>
</html>
