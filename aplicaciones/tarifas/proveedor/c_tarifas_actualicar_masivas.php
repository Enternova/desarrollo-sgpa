<? include("../../../librerias/lib/@session.php");  
	verifica_menu("proveedores.html");
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
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td colspan="2" class="titulos_secciones_tarifas">SECCION:<span class="titulos_resaltado_procesos_tarifas"> MODIFICACION DE TARIFAS MASIVAS &gt;&gt; CONTRATO:
      <?=numero_cotnrato_tarifas($id_contrato_arr);?>
    </span></td>
    <td width="13%" ><span class="titulos_secciones"><input type="button" name="button5" class="boton_volver" id="button5" value="Volver al contrato" onclick="ajax_carga('../aplicaciones/tarifas/proveedor/v_contratos.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','contenidos')" /></span></td>
  </tr>
  <tr>
    <td width="25%" valign="top" ><div align="right"><strong><span class="titulos_resaltado_subtitulos_tarifas">Objeto del contrato:</span></strong></div></td>
    <td colspan="2" ><span class="titulos_resaltado_subtitulos_contenidostarifas">
      <?=$sql_con[9]?>
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
        <select name="lista_existentes" id="lista_existentes" class="select_ancho_automatico" onchange="ajax_carga('../aplicaciones/tarifas/proveedor/c_tarifas_actualicar_masivas.php?id_contrato=<?=$id_contrato;?>&lista_existentes=' + this.value,'carga_acciones_permitidas')">
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

 <?=busca_tarifas_aiu($id_contrato_arr,1);?>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top"><br />
      <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="4" class="fondo_2_sub"><strong >Modificar tarifas masivas PASO 1</strong></td>
        </tr>
        <tr>
          <td width="4%" valign="top"><br />
            <img src="../imagenes/botones/crague_masivo.gif" alt="Cargue masivo desde excel" width="32" height="32" longdesc="Cargue masivo desde excel" /></td>
          <td width="42%"><p>Cargue al sistema las tarifas de esta lista masivamente desde archivo excel siguiendo estos pasos:</p>
            <ul>
              <li><a href="javascript:void(0);" onclick="window.parent.location.href='../aplicaciones/tarifas/proveedor/expotar_plantilla_tarifas_actualizacion.php?id_contrato=<?=$id_contrato;?>&amp;lista_existentes=<?=$lista_existentes;?>'">Descargue aqu&iacute; la plantilla</a> </li>
              <li>No elimine o a&ntilde;ada mas columnas de la plantilla</li>
              <li>Guarde la plantilla diligenciada en formato libro de excel 97.</li>
            </ul></td>
          <td width="27%" valign="top">&nbsp;</td>
          <td width="27%" valign="top">&nbsp;</td>
        </tr>
        <? if($sql_con[19]==2){ //si es contrato marco ?>
        <? } ?>
        <? if(busca_tarifas_convenciones($id_contrato_arr,3)==1){ ?>
        <? } else { ?>
        <input type="hidden" name="modi_convencion_<?=$lista_detalle[0];?>2" id="modi_convencion_<?=$lista_detalle[0];?>2" value="2" />
        <? } ?>
      </table>
      <br />
<br />
      <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="4" class="fondo_2_sub"><strong >Modificar tarifas masivas PASO 2</strong></td>
        </tr>
        <tr>
          <td width="4%" valign="top">&nbsp;</td>
          <td width="42%">&nbsp;</td>
          <td width="27%" valign="top">&nbsp;</td>
          <td width="27%" valign="top">&nbsp;</td>
        </tr>
        
        
       <? 

	   $ya_tiene_cargue = traer_fila_row(query_db("select count(*) from t6_tarifas_lista where tarifas_contrato_id = ".$id_contrato_arr." and t6_tarifas_estados_tarifas_id = 10 and tipo_creacion_modifica in (2,5)"));

	   if($ya_tiene_cargue[0]==0){
	   if($sql_con[19]==2){ //si es contrato marco ?>
        <tr>
          <td valign="top"></td>
          <td align="right"><strong>Quien solicita actualizar la tarifa:</strong></td>
          <td valign="top"><select name="aprobacion_secundaria_0" id="aprobacion_secundaria_0" class="campos_tarifas_select">
          <option value="0">Seleccione</option>
          <!-- Pone siemopre de primero el gerente del contrato-->
             	 <option value="<?=$sql_con[14]?>"><? echo saca_nombre_lista($g1,$sql_con[14],'nombre_administrador','us_id');?></option>
             <!-- Pone siemopre de primero el gerente del contrato-->
                    <? $sel_usuarios = query_db("select $g1.us_id, $g1.nombre_administrador from $g1 where  $g1.estado = 1 and $g1.tipo_usuario <> 2 and $g1.email like '%@hocol.com.co%' order by $g1.nombre_administrador"); 
		  while($sel_us = traer_fila_db($sel_usuarios)){
			  $busca_si_es_profesional = traer_fila_row(query_db("select count(*) from tseg5_usuario_permisos where id_usuario = ".$sel_us[0]." and id_permiso in (8,9, 20, 35, 43, 45)"));
			  
			  if($busca_si_es_profesional[0]==0  and ($sel_us[0] <> 17989 and $sel_us[0] <> 23 and $sel_us[0] <> 17 and $sel_us[0] <> 17931 and $sel_us[0] <> 17968 and $sel_us[0] <> 18056 and $sel_us[0] <> 62)){//si no es un profesional de abastecimiento
		  ?>
          <option value="<?=$sel_us[0]?>"><?=$sel_us[1]?></option>
          <?
			  }
		  }
		  ?>
          </select></td>
          <td valign="top">&nbsp;</td>
        </tr>
		
		<? } ?>
         <? if(busca_tarifas_convenciones($id_contrato_arr,3)==1){ ?>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="right"><strong>Modificaci&oacute;n por convencion:</strong></td>
          <td valign="top"><select name="modi_convencion_0" class="campos_tarifas_select" id="modi_convencion_0">
                      <option value="0">Seleccione</option>
                      <option value="1">Si</option>
                      <option value="2">No</option>
          </select></td>
          <td valign="top">&nbsp;</td>
        </tr>
        <? } else { ?>
        <input type="hidden" name="modi_convencion_0" id="modi_convencion_0" value="2" />
        <? } ?>

        <tr>
          <td valign="top">&nbsp;</td>
          <td align="right"><strong>Busque la plantilla diligenciada y guardada:</strong></td>
          <td valign="top"><input type="file" name="carga_tarifas" id="carga_tarifas" /></td>
          <td valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="center" valign="top"><input type="button" name="button" class="boton_grabar" id="button" value="Presione este comando para cargar la plantilla" onclick="carga_tarifas_masivas_actualizacion('')" /></td>
        </tr>
        
        <?
	   }else{
		?>
        
        <tr>
          <td align="center" valign="top">&nbsp;</td>
          <td align="right" valign="top"><input type="button" name="button2" class="boton_buscar" id="button2" value="Ver el cargue previo" onclick="ajax_carga('../aplicaciones/tarifas/proveedor/v_tarifas_actualizar_masiva.php?id_contrato=<?=$id_contrato;?>&amp;lista_existentes=<?=$lista_existentes;?>&amp;tipo_creacion=2','carga_acciones_permitidas')" /></td>
          <td align="center" valign="top"><input type="button" name="button4" class="boton_eliminar" id="button4" value="Descartar / Eliminar el Cargue previo" onclick="elminar_cargue_masivo_previo(2)" /></td>
          <td align="center" valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td align="center" valign="top">&nbsp;</td>
          <td align="right" valign="top">&nbsp;</td>
          <td align="center" valign="top">&nbsp;</td>
          <td align="center" valign="top">&nbsp;</td>
        </tr>
        ´
        <?
	   }
		?>
      </table>
      <br />
      <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="4" class="fondo_2_sub"><strong >Modificar tarifas masivas PASO 3</strong></td>
        </tr>
        <tr>
          <td width="4%" valign="top">&nbsp;</td>
          <td width="42%">&nbsp;</td>
          <td width="27%" valign="top">&nbsp;</td>
          <td width="27%" valign="top">&nbsp;</td>
        </tr>
        <? if($sql_con[19]==2){ //si es contrato marco ?>
        <? } ?>
        <? if(busca_tarifas_convenciones($id_contrato_arr,3)==1){ ?>
        <? } else { ?>
        <input type="hidden" name="modi_convencion_<?=$lista_detalle[0];?>3" id="modi_convencion_<?=$lista_detalle[0];?>3" value="2" />
        <? } ?>
         <?
      if($ya_tiene_cargue[0]>0){//si ya tiene cargue
	  ?>
        <tr>
          <td valign="top">&nbsp;</td>
          <td align="right"><strong>Anexo soporte: (Diferente a la plantilla de cargue) <span class="titulo_calendario_real_mal">Solo anexos en formato .ZIP &oacute; .RAR</span>:</strong></td>
          <td valign="top"><input type="file" name="anexo_soporte_0" id="anexo_soporte_0" /></td>
          <td valign="top">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="4" align="center" valign="top"><input type="button" name="button3" class="boton_grabar" id="button3" value="Presione este comando para confirmar el cargue" onclick="confirma_actualizacion_masiva()" /></td>
        </tr>
        <?
	  }else{
		  ?><tr><td colspan="4" align="center" valign="top" class="titulos_resaltado_procesos_tarifas">PARA PONER EN FIRME LAS TARIFAS Y ENVIARLAS A APROBACIONES DE HOCOL S.A. PRIMERO DEBE SELECCIONAR Y CARGAR UNA PLANTILLA VALIDA</td>
        </tr><?  }//fin si ya tiene cargue
	  ?>
      </table>
<br />
     
 <? } //si ya selecciono una lista ?>

  <input type="hidden" name="id_tarifa" />
<input type="hidden" name="inicio_contrato" value="<?=$sql_con[20];?>" />
<input type="hidden" name="vigencia_contrato" value="<?=$sql_con[21];?>" />
  <input type="hidden" name="tipo_creacion" value="2" />
  <input type="hidden" name="id_lista" value="<?=$lista_existentes;?>">
</body>
</html>
