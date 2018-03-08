<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';
	
	$id_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$num_ale= rand(0,99);
	$num_ale.= rand(0,99);
	$aleatorio = $fecha.$num_ale.$hora;
	
	$tiene_rol_profesional = verifica_usuario_si_tiene_el_permiso(8);
	
$sel_usu_emulan = traer_fila_row(query_db("select * from t2_relacion_usuarios_emulan where id_us = ".$_SESSION["id_us_session"]));	
	$titulo4="Gesti&oacute;n de Entorno";
      $ayuda4="Foco en el desarrollo regional sostenible, alineando intereses de largo plazo. Vinculaci&oacute;n del entorno en los resultados. Operaci&oacute;n sana, limpia, segura y transparente.";
      
      $titulo5="Trazabilidad";// no tiene cambio
      $ayuda5="A que nivel voy a ir de acuerdo a la Norma de Actos y Transacciones.";
      
      $titulo6="Transparencia";// no tiene cambio
      $ayuda6="Como se aseguro que se tienen todas las alternativas en el mercado (variedad de proponentes)";
      
      $titulo7="Agilidad";
      $ayuda7="Procesos simplificados y estandarizados. Personal integral y m&oacute;vil, seg&uacute;n los requerimientos del negocio. Oportunidad en adquisici&oacute;n de B&S.";
	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>
<?


		$sel_pecc = traer_fila_row(query_db("select $pi1.id_pecc,$pi1.ano,$pi1.objeto,$g1.nombre_administrador, $g10.valor, $pi1.nombre, $g10.id_trm from $pi1, $g1, $g10 where $pi1.id_pecc = ".$id_pecc." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));
?>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="7"  class="titulos_secciones">Informaci&oacute;n General de la Solicitud</td>
  </tr>
</table>
<table width="99%" border="0" cellpadding="2" cellspacing="2">
  <tr >
      <td width="33%" align="right">
Tipo de Contrataci&oacute;n:</td>
      <td>Contrataci&oacute;n de Servicios</td>
    <td width="37%" rowspan="5" valign="top"><table width="99%" border="0" cellpadding="2" cellspacing="2">
        <tr>
          <td height="25" align="left" class="titulos_resumen_alertas"><?=$sel_pecc[2]?></td>
        </tr>
        <?
if($id_pecc != 1){
?>
        <tr>
          <td align="left">Encargado del PECC:
          <?=$sel_pecc[3]?></td>
        </tr>
        <tr class="titulos_resumen_alertas">
          <td align="left">A&ntilde;o: <?=$sel_pecc[1]?></td>
        </tr>
        <?
}
		?>
        <tr class="titulos_resumen_alertas">
          <td align="left">TRM:
          <? // number_format(trm_presupuestal($sel_pecc[1]))?> 2.950</td>
        </tr>
    </table></td>
  </tr>
  
  <tr >
    <td colspan="2" align="center"><div id="alerta_no_gerente"></div></td>
  </tr>
  
  <?
  if($sel_usu_emulan[0]>0){
  ?>
  
  <tr >
    <td align="right">Preparador:</td>
    <td><?=$_SESSION["us_nombre_session"]?></td>
  </tr>
  <?
  }
  ?>
  <tr >
      <td align="right">Gerente del ITEM:</td>
      <td>
      <div id="carga_gerente_contrato">
      <?
	  if($sel_usu_emulan[0]>0){
		  ?>
		  <select name="gerente_contra" id="gerente_contra">
          <option value="0">Seleccione el Gerente</option>
          <?
          $sel_usu_emula = query_db("select t1.us_id,t1.nombre_administrador from t1_us_usuarios as t1, t2_relacion_usuarios_emulan as t2 where t2.id_us_emula = t1.us_id and t2.id_us = ".$_SESSION["id_us_session"]." group by t1.us_id,t1.nombre_administrador");
		  while($sel_us_emu = traer_fila_row($sel_usu_emula)){
		  ?>
          <option value="<?=$sel_us_emu[0]?>"><?=$sel_us_emu[1]?></option>
          <?
		  }
		  ?>
          </select>
		  <?
	  }else{
       echo $_SESSION["us_nombre_session"]?><input type="hidden" name="gerente_contra" id="gerente_contra" value="<?=$_SESSION["id_us_session"]?>" /><?
	  }
	  ?>
      </div>
      </td>
  </tr>
  <tr>
    <td align="right">Tipo de Proceso<img src="../imagenes/botones/help.gif" alt="Indicar el tipo de proceso que utilizara para la solicitud." title="Indicar el tipo de proceso que utilizara para la solicitud." width="20" height="20" /></td>
    <td>
      
      <select name="tipo_proceso" id="tipo_proceso" onchange="valida_tipo_proceso(this.value)">
        <?
			$quita_pone_adjudica_directo = "6,";
            if($tiene_rol_profesional == "SI"){
				$quita_pone_adjudica_directo = "";
				}
			?>
       <?=listas($g13, " estado = 1 and t1_tipo_proceso_id not in (".$quita_pone_adjudica_directo."7,8, 16)",0 ,'nombre', 1);?>
      </select>
</td>
  </tr>
  
  <tr>
    <td align="right">Contrato Relacionado:</td>
    <td colspan="2"><div id="contra_otro_si"></div></td>
  </tr>
  <tr>
    <td align="right">Solicitud Relacionada:</td>
    <td colspan="2"><div id="informativo_solicitud"></div></td>
  </tr>
 <tr>
    <td align="right">Seleccione si Desea que Este Otros&iacute; Convierta el Contrato a Marco <img src="../imagenes/botones/aler-interro.gif" height="15"/> <img src="../imagenes/botones/help.gif" alt="Si selecciona que si, debera incluir el valor disponible para crear OTs" width="20" height="20"  title="Si selecciona que si, debera incluir el valor disponible para crear OTs"/></td>
    <td><div id="contra_otro_si_convierte_marco"></div></td>
    <td>&nbsp;</td>
  </tr>
  <tr>
    <td align="right">&Aacute;rea Usuaria<img src="../imagenes/botones/help.gif" alt="Seleccionar área para este proceso." width="20" height="20"  title="Seleccionar área para este proceso."/></td>
    <td>
    <div id="area_usuaria_div">
    <select name="area_usuaria" id="area_usuaria">
      <option value="0">Seleccione</option>
      <?
	  
	  $verifica_permiso = traer_fila_row(query_db("select count(*) from $v_seg1 where id_premiso = 8 and us_id =".$_SESSION["id_us_session"]));
if($verifica_permiso[0]>0){
	echo listas($g12, " estado = 1",0 ,'nombre', 1);
}else{
	  
      $sel_areas = query_db("select * from $g12 as t1, $ts3 as t2 where t1.t1_area_id = t2.id_area and t2.id_usuario = ".$_SESSION["id_us_session"]." and t1.estado = 1");
	  while($sel_a_usuario = traer_fila_db($sel_areas)){
	  ?>
      <option value="<?=$sel_a_usuario[0]?>"><?=$sel_a_usuario[1]?></option>
      <?
      }
	  
}
	  ?>
		</select></div></td>
    <td width="37%" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Fecha en la que se Requiere el Servicio<img src="../imagenes/botones/help.gif" alt="Seleccionar la fecha estimada en la cual requiere la solicitud." title="Seleccionar la fecha estimada en la cual requiere la solicitud." width="20" height="20" /></td>
    <td><input name="fecha" type="text" id="fecha" onmousedown="calendario_sin_hora('fecha')" size="5" readonly="readonly" onchange="valida_fecha_ideal(this)"/></td>
    <td width="37%" valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Proceso Especial o Anticipo, Requiere Aprobaci&oacute;n Extra del Comit&eacute;<img src="../imagenes/botones/help.gif" alt="Seleccione 'SI' si desea que este item vaya al comit&eacute;" title="Seleccione 'SI' si desea que este item vaya al comit&eacute;" width="20" height="20" /></td>
    <td colspan="2"><select name="req_comite" id="req_comite">
      <option value="2" >NO</option>
      <option value="1" >SI</option>
    </select></td>
  </tr>
 
  <tr id="us_par_tecnico" style="display:none">
    <td align="right">Par T&eacute;cnico <img src="../imagenes/botones/help.gif" alt="Ac&aacute; debe ingresar el nombre del profesional que apoyar&aacute; la evaluación t&eacute;cnica del proceso, Este requisito aplica para los procesos que requieren aprobaci&oacute;n de comit&eacute;." title="Acá debe ingresar el nombre del profesional que apoyará la evaluación técnica del proceso, Este requisito aplica para los procesos que requieren aprobación de comité." width="20" height="20" /></td>
    <td colspan="2"><input type="text" name="partecnico_bus_us" id="partecnico_bus_us" onkeypress="selecciona_lista()"/></td>
  </tr>
  <tr id="us_geren_contrato" style="display:none">
    <td align="right">Gerente de Contrato <img src="../imagenes/botones/help.gif" alt="Ac&aacute; debe ingresar el nombre del profesional que administrar&aacute; el contrato." title="Ac&aacute; debe ingresar el nombre del profesional que administrar&aacute; el contrato." width="20" height="20" /></td>
    <td colspan="2"><input type="text" name="gerente_contrato_bus_us" id="gerente_contrato_bus_us" onkeypress="selecciona_lista()"/></td>
  </tr>
  

  <tr id="mustra_objeto_solicitud">
    <td align="right" >Objeto de la Solicitud<img src="../imagenes/botones/help.gif" alt="Ingresar la actividad o servicio que se desea realizar a través del contrato." title="Ingresar la actividad o servicio que se desea realizar a través del contrato.
" width="20" height="20" /></td>
    <td colspan="2"><textarea name="objeto_solicitud" id="objeto_solicitud" cols="25" rows="2"></textarea></td>
  </tr>
  
  
  <tr id="muetra_objeto_contrato">
    <td align="right">Objeto del Contrato<img src="../imagenes/botones/help.gif" alt="Describir el objeto conciso del contrato." width="20" height="20" title="Describir el objeto conciso del contrato." /></td>
    <td colspan="2"><textarea name="objeto_contrato" id="objeto_contrato" cols="25" rows="2"></textarea></td>
  </tr>
  <tr id="muestra_alcance">
    <td align="right">Alcance<img src="../imagenes/botones/help.gif" alt="Ingresar un alcance detallado donde se indique el Área o áreas en las cuales se utilizará el contrato." title="Ingresar un alcance detallado donde se indique el Área o áreas en las cuales se utilizará el contrato." width="20" height="20" /></td>
    <td colspan="2"><textarea name="alcance" id="alcance" cols="25" rows="2"></textarea></td>
  </tr>
  <tr id="muestra_proveedores_sugeridos">
    <td align="right">Proveedores Sugeridos<img src="../imagenes/botones/help.gif" alt="Sugerir proveedores que puedan suplir la necesidad planteada." title="Sugerir proveedores que puedan suplir la necesidad planteada." width="20" height="20" /></td>
    <td colspan="2"><textarea name="proveedores_sugeridos" id="proveedores_sugeridos" cols="25" rows="2"></textarea></td>
  </tr>
  <tr id="muestra_justificacion_tecnica">
    <td align="right">Justificaci&oacute;n T&eacute;cnica<strong><img src="../imagenes/botones/help.gif" alt="Estrategia: Prueba de la necesidad.  Adjudicaci&oacute;n: Raz&oacute;n por la cual se soporta la solicitud desde el punto de vista t&eacute;cnico
" title="Estrategia: Prueba de la necesidad.  Adjudicaci&oacute;n: Raz&oacute;n por la cual se soporta la solicitud desde el punto de vista t&eacute;cnico
"  width="20" height="20" /></strong></td>
    <td colspan="2"><textarea name="justificacion2" id="justificacion2" cols="25" rows="4"></textarea>
    <input type="hidden" name="justificacion" id="justificacion" /></td>
  </tr>
  <tr id="muestra_criterios_evaluacion">
    <td align="right">Criterios de Evaluaci&oacute;n<img src="../imagenes/botones/help.gif" alt="Valoraci&oacute;n T&eacute;cnico - Econ&oacute;mico
" title="Valoraci&oacute;n T&eacute;cnico - Econ&oacute;mico
" width="20" height="20" /></td>
    <td colspan="2"><textarea name="criterios_evaluacion" id="criterios_evaluacion" cols="25" rows="4"></textarea></td>
  </tr>
  <tr id="muestra_recomendacion">
    <td align="right">Recomendaci&oacute;n<img src="../imagenes/botones/help.gif" alt="Recomendación sugerida para satisfacer la necesidad del solicitante." width="20" height="20" title="Recomendación sugerida para satisfacer la necesidad del solicitante." /></td>
    <td colspan="2"><textarea name="recomendacion" id="recomendacion" cols="25" rows="4"></textarea></td>
  </tr>
  

  <tr>
    <td colspan="3" align="right">
    <div id="carga_objetivos_proceso">
    <table width="80%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF"   class="tabla_lista_resultados">
      <tr>
        <td align="center"  class="fondo_3">Lineamientos Operador de Bajo Costo + R+S</td>
        <td align="center" class="fondo_3">Descripci&oacute;n</td>
      </tr>
      <?
      $edicion_datos="SI";
	  ?>
      <tr id="muestra_oportunidad">
        <td width="31%" align="right" >Bajo Costo <img src="../imagenes/botones/help.gif" alt="Est&aacute;ndares acordes a las necesidades del negocio que aseguren rentabilidad y excelencia operacional. Actividades justo lo necesario -fitforpurpose. Proceso de abastecimiento que obtiene el mayor valor posible del mercado." width="20" height="20" title="Est&aacute;ndares acordes a las necesidades del negocio que aseguren rentabilidad y excelencia operacional. Actividades justo lo necesario -fitforpurpose. Proceso de abastecimiento que obtiene el mayor valor posible del mercado." /></td>
        <td width="69%" align="left"><? if($edicion_datos=="SI") { ?>
          <textarea name="campos1" id="campos1"><?=$p_oportunidad?></textarea>
          <? } else {echo $p_oportunidad; }?></td>
      </tr>
      <tr id="muestra_calidad">
        <td align="right">Capacidad T&eacute;cnica <img src="../imagenes/botones/help.gif" alt="Competencias integrales y aplicaci&oacute;n de tecnolog&iacute;as conectadas con el negocio y fortalecidas a trav&eacute;s de alianzas estrat&eacute;gicas. Informaci&oacute;n como recurso" width="20" height="20" title="Competencias integrales y aplicaci&oacute;n de tecnolog&iacute;as conectadas con el negocio y fortalecidas a trav&eacute;s de alianzas estrat&eacute;gicas. Informaci&oacute;n como recurso" /></td>
        <td align="left"><? if($edicion_datos=="SI") { ?>
          <textarea name="campos3" id="campos3"><?=$p_calidad?></textarea>
          <? } else echo $p_calidad; ?></td>
      </tr>
      <tr>
            <td align="right"><?=$titulo4?>  <img src="../imagenes/botones/help.gif" alt="<?=$ayuda4?>" width="20" height="20" title="<?=$ayuda4?>" /></td>
            <td align="left"><? if($edicion_datos=="SI") { ?>
              <textarea name="campos4" id="campos4"><?=$p_optimizar?></textarea>
              <? } else echo $p_optimizar; ?></td>
          </tr>
          <tr>
            <td align="right"> <?=$titulo7?> <img src="../imagenes/botones/help.gif" alt="<?=$ayuda7?>" width="20" height="20" title="<?=$ayuda7?>" /></td>
            <td align="left"><? if($edicion_datos=="SI") { ?>
              <textarea name="campos7" id="campos7"><?=$p_sostenibilidad?></textarea>
              <? } else echo $p_sostenibilidad; ?></td>
          </tr>
    </table>
    </div>
    </td>
  </tr>
    <tr>
    <td colspan="3" align="right">
    <div id="carga_datos_contrato"></div>
    
    <table width="100%" border="0" align="center" id="tabla_presupuestos_boton"  class="tabla_lista_resultados">
      <tr>
        <td colspan="5" align="center"  class="fondo_3"><div id="titulo_valores">Valor de la Solicitud <img src="../imagenes/botones/help.gif" alt="Ingresar el monto estimado por año y área, requerido para la solicitud." title="Ingresar el monto estimado por año y área, requerido para la solicitud." width="20" height="20" /></div></td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"></td>
        <td align="left"><strong class='letra-descuentos'>El valor debe ser incluido &uacute;nicamente en la moneda de pago</strong> <img src='../imagenes/botones/aler-interro.gif' width='5'/></td>
        <td width="12%" rowspan="3"><input name="button5" type="button" class="boton_grabar"   value="Grabar" onclick="graba_presupuesto_nuevo()" /></td>
      </tr>
      <tr>
        <td width="23%"><input type="hidden" name="aplica_contrato" id="aplica_contrato" value="0" />
          
          <select name="ano" id="ano">
            <option value="0">A&Ntilde;O</option>
             <?=anos_presupuesto();?>
          </select>
          </td>
        <td width="21%"><select name="campo" id="campo">
          <option>&Aacute;rea</option>
          <?=listas_sin_seleccione($g15, " estado = 1 ",0 ,'nombre', 2);?>
        </select></td>
        <td width="13%" align="right">Valor USD$:</td>
        <td width="31%"><input name="valor_usd" type="text" id="valor_usd" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
        </tr>
      <tr>
        <td align="right">Adjunto:<?=$_SESSION["alerta_de_archivos"]?></td>
        <td><div id="resetea_presus"><input name="adj_presupuesto" type="file" size="5" /></div></td>
        <td align="right">Valor COP$:</td>
        <td><input name="valor_cop" type="text" id="valor_cop" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
      </tr>
      
    </table>
    
    
    <div id="carga_presupuesto"><input type="hidden" name="valor_total_js_valida" id="valor_total_js_valida" value="0" /></div>
    
    <div id="carga_presupuesto_dispo" style="display:none">
    
    
    <table width="100%" border="0" align="center" id="tabla_presupuestos_boton"  class="tabla_lista_resultados">
      <tr>
        <td colspan="5" align="center"  class="fondo_3">Distribuci&oacute;n Saldos Actuales del Contrato</td>
      </tr>
      <tr>
        <td width="16%"><input type="hidden" name="aplica_contrato2" id="aplica_contrato2" value="0" />
          
          <select name="ano2" id="ano2">
            <option value="0">A&Ntilde;O</option>
            <option value="2013">2013</option>
            <option value="2014">2014</option>
            <option value="2015">2015</option>
             <option value="2016">2016</option>
             <option value="2017">2017</option>
              <option value="2018">2018</option>
               <option value="2019">2019</option>
                <option value="2020">2020</option>
          </select>
          </td>
        <td width="23%"><select name="campo2" id="campo2">
          <option>&Aacute;rea</option>
          <?=listas_sin_seleccione($g15, " estado = 1 ",0 ,'nombre', 2);?>
        </select></td>
        <td width="18%" align="right">Valor USD$:</td>
        <td width="31%"><input name="valor_usd2" type="text" id="valor_usd2" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
        <td width="12%" rowspan="2"><input name="button2" type="button" class="boton_grabar"   value="Grabar" onclick="graba_presupuesto_nuevo_2()" /></td>
      </tr>
      <tr>
        <td align="right">Adjunto:</td>
        <td><div id="resetea_presus2"><input name="adj_presupuesto2" type="file" size="5" /></div></td>
        <td align="right">Valor COP$:</td>
        <td><input name="valor_cop2" type="text" id="valor_cop2" size="5" onkeyup="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
      </tr>
    </table>
    
    
    <div id="carga_presupuesto2"><input type="hidden" name="valor_total_js_valida2" id="valor_total_js_valida2" value="0" /></div>
    
    </div>
      </td>
  </tr>
  <tr>
    <td align="right">&nbsp;</td>
    <td>&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="3" align="right">
    
    <table width="100%" border="0" align="center" class="tabla_lista_resultados" id="muestra_anexos">
      <tr>
        <td colspan="2" align="center" class="fondo_3">Agregar Anexos <img src="../imagenes/botones/help.gif" alt="Adjuntar archivos o documentos requeridos para soportar o informar en esta solicitud (Para cargar varios documentos, comprimirlos en una carpeta y cargar la carpeta comprimida)" width="20" height="20" /></td>
        <td width="54%" valign="top"></td>
      </tr>
      <tr>
        <td align="right">Categor&iacute;a del Anexo</td>
        <td align="left"><select name="ct_anexo" id="ct_anexo">
          <option value="0">Seleccione</option>
          <?
          $categorias_anexos = query_db("select * from t1_categoria_anexos as t1 where estado = 1 and t1_tipo_proceso in  (0) ");
		  while($ct_anexo = traer_fila_db($categorias_anexos)){
		  ?>
          <option value="<?=$ct_anexo[0]?>" >
            <?=$ct_anexo[1]?>
            </option>
          <?
		  }
		  ?>
        </select></td>
        <td width="54%" rowspan="4" valign="top"><div id="carga_anexos"></div></td>
      </tr>
      <tr>
        <td width="21%" align="right">Detalle del Anexo:</td>
        <td width="25%" align="left"><textarea name="anexo" cols="25" id="anexo"></textarea></td>
        </tr>
      <tr>
        <td align="right">Seleccionar Archivo Adjunto:<?=$_SESSION["alerta_de_archivos"]?></td>
        <td align="left"><div id="resetea_anexos"><input name="adj_anexo" type="file" id="adj_anexo" size="5" /></div></td>
        </tr>
      <tr>
        <td align="right">&nbsp;</td>
        <td align="center"><input name="button6" type="button" class="boton_grabar" id="button6" value="Agregar Anexo" onclick="graba_anexo(8)" /></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td></td>
        <td width="54%" valign="top">&nbsp;</td>
        </tr>
      
    </table>
    
    </td>
  </tr>
  <tr style="display:none">
    <td colspan="3" align="right"><table width="100%" border="0" align="center" class="tabla_lista_resultados">
      <tr>
        <td colspan="2" align="center" class="fondo_3">Agregar Antecentes <img src="../imagenes/botones/help.gif" alt="Ingresar los antecedentes de la solicitud (Para cargar varios documentos, comprimirlos en una carpeta y cargar la carpeta comprimida)" title="Ingresar los antecedentes de la solicitud (Para cargar varios documentos, comprimirlos en una carpeta y cargar la carpeta comprimida)" width="20" height="20" /></td>
        <td width="54%">&nbsp;</td>
      </tr>
      <tr>
        <td width="21%" align="right">Detalle del Antecedente:</td>
        <td width="25%" align="left"><textarea name="ancedente" cols="25" rows="5" id="ancedente"></textarea></td>
        <td rowspan="4" valign="top"></td>
      </tr>
      <tr>
        <td align="right">Seleccionar Archivo Adjunto:<?=$_SESSION["alerta_de_archivos"]?></td>
        <td align="left"><div id="resetea_antecedente"><input name="adj_antecedente" type="file" id="adj_antecedente" size="5" /></div></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td align="center"><input name="button3" type="button" class="boton_grabar" id="button3" value="Agregar Antecedente"  onclick="graba_anexo(9)"/></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        </tr>
      <tr>
        <td colspan="3"><div id="carga_antecedentes"></div><div id="carga_antecedentes_otro_si"></div></td>
        </tr>
     
    </table></td>
  </tr>
  
  
  <?
  if($sel_usu_emulan[0] > 0){
	   $testos = "Temporalmente - Debera ponerse en contacto con el gerente del contrato para ponerlo en firme";
	  }else{
		  $testos = "Temporalmente";
		  }
		  
	
	

  ?>
  
  <tr>
    <td colspan="2" align="right"><input name="button" type="button" class="boton_grabar" id="button" value="Grabar este proceso en <?=$sel_pecc[5]?> - <?=$testos ?>" onclick="valida_graba_item(1)" /></td>
    <td>
    
    <div id="boton_poner_firme">
    <?
    if($tiene_rol_profesional == "no mostrar nunca para activar poner solo 'NO'" and $sel_usu_emulan[0] == 0){
		
		
	?>
 
    <select name="conflito_intere_sel" id="conflito_intere_sel">
      <option value="0">Seleccione si tiene conflicto de intereses</option>
      <option value="1">SI tiene conflicto de intereses</option>
      <option value="2">NO tiene conflicto de intereses</option>
    </select>
    <input name="button4" type="button" class="boton_grabar" id="button4" value="Grabar este proceso en <?=$sel_pecc[5]?> y poner en firme" onclick="valida_graba_item(2)"/>
    <?
	}
	?>
    </div>
    </td>
  </tr>
</table>

<?

?>
<input type="hidden" name="req_crear_otro_si" id="req_crear_otro_si" value="0"/>
<input type="hidden" name="aleatorio" id="aleatorio" value="<?=$aleatorio?>" />
<input type="hidden" name="id_pecc" id="id_pecc" value="<?=$id_pecc?>" />
<input type="hidden" name="tipo_anexo" id="tipo_anexo" />
<input type="hidden" name="tipo_graba" id="tipo_graba" />
<input type="hidden" name="id_trm_aplica" id="id_trm_aplica" value="<?=$sel_pecc[6]?>" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="0" />
<input type="hidden" name="id_presupuesto_elimina" id="id_presupuesto_elimina" value="" />
<input type="hidden" name="id_anexo_elimina" id="id_anexo_elimina" value="" />
<input type="hidden" name="id_contrato_otro_si" id="id_contrato_otro_si" value="" />
<input type="hidden" name="id_tipo_contratacion" id="id_tipo_contratacion" value="1" />
<input type="hidden" name="usuario_permiso" id="usuario_permiso" value="<?=$_SESSION["id_us_session"]?>"/>
<input type="hidden" name="solicitud_que_carga" id="solicitud_que_carga" />

</body>
</html>
