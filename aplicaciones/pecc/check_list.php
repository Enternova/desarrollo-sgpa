<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_proveedor_edita = elimina_comillas(arreglo_recibe_variables($_GET["id_proveedor_edita"]));
	
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$sel_proveedor_edita = traer_fila_row(query_db("select * from $g6 where t1_proveedor_id = $id_proveedor_edita"));
	$sel_proveedor_email_edita = traer_fila_row(query_db("select * from $g20 where t1_proveedor_id = $id_proveedor_edita"));
	
	$sel_prove_sugerido = traer_fila_row(query_db("select proveedores_sugeridos,estado from $pi2 where id_item = ".$id_item_pecc));
	
	$sel_pecc = traer_fila_row(query_db("select $g10.valor from $pi1, $g1, $g10 where $pi1.id_pecc = ".$sel_item[1]." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));
	
	$edicion_datos_generales = "NO";
	if(verifica_permiso_pecc($sel_prove_sugerido[1], $id_item_pecc) == "SI" and ($sel_item[14] < 14 or $sel_item[14] == 31)){
			$edicion_datos_generales = "SI";
		}
		
		$sel_usu_emulan = traer_fila_row(query_db("select * from t2_relacion_usuarios_emulan where id_us = ".$_SESSION["id_us_session"]." and id_us_emula=".$sel_item[3]));	
		
		if($sel_usu_emulan[0]>0 and ($sel_item[14] == 31)){
			$edicion_datos_generales = "SI";
		}
		
		
		
		
		$es_profesional_designado = verifica_usuario_indicado(8,$id_item_pecc);
		/*echo "ID del proceso: ".$sel_item[0]."<br />";
	echo "ID Nivel de Servicio: ".$sel_item[2]."<br />";
	echo "ID Estado del Proceso: ".$sel_item[14]."<br />";
	echo "Es el Profesional designado: ".$es_profesional_designado."<br />";
	echo "Tiene Permiso de Edicion ".$edicion_datos_generales."<br />";
	*/
	
	if(esprofesionalcompras($id_item_pecc)=="SI" and $sel_item[14]==7){
	 $edicion_datos_generales = "SI";
	 }
	 
	 /*------------------ PERMISO PARA SERVICIOS MENORES ---------------------*/
if($sel_item[6]==16 and ($sel_item[14] < 16) and $sel_item[23] == $_SESSION["id_us_session"]){
	$edicion_datos_generales = "SI";	
	}
/*------------------ PERMISO PARA SERVICIOS MENORES ---------------------*/
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2" valign="top"><?=encabezado_item_pecc($id_item_pecc)?></td>
  </tr>
  <tr>
    <td width="77%" valign="top"><table width="100%" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
      <col width="439" />
      <col width="40" span="6" />
      <tr  class="fondo_3">
        <td width="422" rowspan="3" align="center">Actividad</td>
        <td colspan="6" rowspan="2" align="center">Estrategia/Modificación</td>
      </tr>
      <tr  class="fondo_3"> </tr>
      <tr  class="fondo_3">
        <td width="83" align="center">Solicitante</td>
        <td width="213" align="center">Profesional de    Abastecimiento/Compras</td>
        <td width="149" align="center">GERENTE DE    EQUIPO/JEFE DE EQUIPO</td>
        <td width="50" align="center">HSSE</td>
        <td width="55" align="center">LEGAL</td>
        <td width="61" align="center">FINANZAS</td>
      </tr>
      <tr>
        <td dir="ltr" width="422">Subir la solicitud en SGPA </td>
        <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" width="23" height="20" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr class="filas_resultados">
        <td dir="ltr" width="422">Anexo de especificaciones técnicas del bien o servicio a    contratar</td>
        <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" alt="" width="23" height="20" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td dir="ltr" width="422">Registrar línea de presupuesto aprobada por el activo o la    Gerencia/Vicepresidencia respectiva (Capex &amp; Opex)</td>
        <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" width="23" height="20" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
      </tr>
      <tr class="filas_resultados">
        <td dir="ltr" width="422">Definir solicitante y Par técnico  que participará en el proceso y en la    evaluación</td>
        <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" width="23" height="20" /></td>
        <td align="center">&nbsp;</td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" width="16" height="16" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td dir="ltr" width="422">Proponer Gerente de Contrato </td>
        <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" alt="chulo" width="23" height="20" /></td>
        <td align="center">&nbsp;</td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr class="filas_resultados">
        <td dir="ltr" width="422">Detallar objeto de la solicitud</td>
        <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" alt="chulo" width="23" height="20" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td dir="ltr" width="422">Definir alcance: área de ejecución, servicios incluidos en    el objeto del contrato, tiempo requerido para la prestación del servicio.</td>
        <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" alt="chulo" width="23" height="20" /></td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr class="filas_resultados">
        <td dir="ltr" width="422">Sugerir proveedores/contratistas</td>
        <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" alt="chulo" width="23" height="20" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td dir="ltr" width="422">Detallar    la justificación técnica</td>
        <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" alt="chulo" width="23" height="20" /></td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr class="filas_resultados">
        <td dir="ltr" width="422">El    estimado se debe valorar en la moneda de pago:<br />
          a) Si hay anticipo y el % del anticipo<br />
          b) Forma de pago<br />
          c) Si aplica Gastos Reembolsables y el % de Administración</td>
        <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" alt="chulo" width="23" height="20" /></td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td dir="ltr" width="422">Especificar el valor de la solicitud incluyendo:<br />
          a) Año<br />
          b) Proyecto<br />
          c) Valor en COP y/o USD<br />
          d) Anexar documento de precios x cantidades (PxQ)</td>
        <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" alt="chulo" width="23" height="20" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr class="filas_resultados">
        <td dir="ltr" width="422">Definir y diligenciar de manera objetiva , completa y    trazable cada uno de los objetivos<br />
          a) Oportunidad<br />
          b) Calidad<br />
          c) Costo beneficio</td>
        <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" alt="chulo" width="23" height="20" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td dir="ltr" width="422">Anexar Criterios de calificación técnicos detallando: <br />
          a) Peso de cada uno de los criterios<br />
          b) Detalle de como asignará la califición en cada criterio a evaluar    ejemplo: rangos, requisitos mínimos requeridos, otros<br />
          c) Puntaje mínimo requerido  en cada    uno de los criterios</td>
        <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" alt="chulo" width="23" height="20" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr class="filas_resultados">
        <td dir="ltr" width="422">Asignar el punto mínimo requerido con el cual pasan las    ofertas técnicas.</td>
        <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" alt="chulo" width="23" height="20" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td dir="ltr" width="422">Revisar y complementar el objeto de la solicitud</td>
        <td align="center">&nbsp;</td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr class="filas_resultados">
        <td dir="ltr" width="422">Definir el objeto del contrato</td>
        <td align="center">&nbsp;</td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td dir="ltr" width="422">Revisar y Completar el alcance del contrato/solicitud</td>
        <td align="center">&nbsp;</td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr class="filas_resultados">
        <td dir="ltr" width="422">Retar los criterios técnicos</td>
        <td align="center">&nbsp;</td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td dir="ltr" width="422">Incluir Criterios de calificación económica y criterios de    desempate; en lo posible se aplicará pasa - no pasa técnico con un minimo    definido y se adjudicará a la mejor oferta económica de las que pasen. <br />
          Los casos que no puedan manejarse bajo éste modelo, se revisarán y    acordarán entre el usuario y Profesional de Contratación y se debe dejar la    justificación el campo de criterios económicos</td>
        <td align="center">&nbsp;</td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr class="filas_resultados">
        <td dir="ltr" width="422">Confirmar Lista final de invitados    mediante:  PRECALIFICACION - Definir criterios para precalificar a los proponentes</td>
        <td align="center">&nbsp;</td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td dir="ltr" width="422">Definir criterio de ranqueo para cuando el    número de compañías que pasen sea mayor     (ej: decidir por aspecto Financiero se seleccionarán las que tengan    mayor puntaje, decidir por experiencia, mayor número de proyectos o años,    otros).<br />
          Los criterios actuales de precalificación son: Legal, HSSE, Financiero,    Capacidad de contratación y experiencia.      El legal, Financiero y HSSE están definidos previamente por la áreas    dueñas de estos procesos y no son modificables, la capacidad de contratación    y experiencia se acuerdan entre el Solicitante y Abastecimiento de acuerdo    con lo requerido para cada contratación</td>
        <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" alt="chulo" width="23" height="20" /></td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr class="filas_resultados">
        <td dir="ltr" width="422">Definir número máximo de invitados (únicamente cuando    aplique) </td>
        <td align="center">&nbsp;</td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td dir="ltr" width="422">Definir Numero de Rondas  </td>
        <td align="center">&nbsp;</td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td dir="ltr" width="422">Retar y complementar los objetivos del proceso    enfocados al proceso en particular<br />
          a) Oportunidad<br />
          b) Calidad<br />
          c) Costo beneficio<br />
          d) Optimizar transferencia de riesgos<br />
          e) Trazabilidad<br />
          f) Transpoarencia<br />
          g) Sostenibilidad</td>
        <td align="center">&nbsp;</td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr class="filas_resultados">
        <td dir="ltr" width="422">Detallar los antecedentes<br />
          Proceso nuevos<br />
          a) Si el servicios se viene prestando con que compañía<br />
          b) Si el servicio es nuevo e incluye nueva tecnologia<br />
          c) Cuando se finaliza el contrato actual<br />
          d) Cuáles son los hitos del nuevo proceso<br />
          e) Detallar todos los eventos y modficaciones que surtieron durante el    proceso o el contrato<br />
          Si es para ampliar contrato en valor y vigencia    detallar:<br />
          a) Como arranco el contrato (Si fue Licitación o Negociación Directa o    Sondeo, aprobaciones)<br />
          b) Valor inicial del contrato<br />
          c) Vigencia inicial (Fecha de Inicio y Fecha Final de cuando se    adjudicó)<br />
          d) Detallar cada uno de los otrosis (vigencia, aprobaciones, valores, el    objeto, el alcance, el gerente del contrato, el proyecto)<br />
          e) Detallar la ejecución vs el presupuesto (s) solicitados <br />
          f) Saldos por proyecto si el contrato va a pasar a Marco <br />
          g) Mencionar si las tarifas aplicadas presentan descuentos pactados    contractualmente, en caso contario indicar resultados del Sondeo</td>
        <td align="center">&nbsp;</td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td dir="ltr" width="422">Subir ofertas recibidas y Tarifas de Documento    Contractual </td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr class="filas_resultados">
        <td dir="ltr" width="422">Subir el detalle y resumen de Evaluación Técnica y    Económica</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td dir="ltr" width="422">Definición de Tipo de Contrato a Suscribirse (Normal,    Marco, Oferta Mercantil, o Pedido)</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr class="filas_resultados">
        <td dir="ltr" width="422">No de Contratos a Adjudicar</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td dir="ltr" width="422">Validar que no tiene ningún impedimento para participar    durante el proceso de acuerdo la Norma de Etica y Cumplimiento de la    compañía </td>
        <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" alt="chulo" width="23" height="20" /></td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
      </tr>
      <tr class="filas_resultados">
        <td dir="ltr" width="422">Validar que el solicitante, los niveles de aprobación y el    comité evaluador registrado en la solicitud,     no tiene conflicto registrado en la base de datos enviada por el    Oficial de Etica y Cumplimiento </td>
        <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" alt="chulo" width="23" height="20" /></td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
      </tr>
      <tr>
        <td dir="ltr" width="422">Revisar en cada una de las etapas del proceso haya una    adecuada Segregación de Funciones </td>
        <td align="center">&nbsp;</td>
        <td align="center"><img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" /></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
    </table></td>
    <td width="23%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
  <tr>
    <td colspan="2" valign="top" id="carga_acciones_permitidas">&nbsp;</td>
  </tr>
</table>
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
<input type="hidden" name="id_proveedor_edita" id="id_proveedor_edita" value="<?=$id_proveedor_edita?>" />
<input type="hidden" name="id_elim_proveedor" id="id_elim_proveedor" />
<input type="hidden" name="estado_actual_del_proceso" id="estado_actual_del_proceso" value="<?=$sel_item[14]?>" />
<input type="hidden" name="id_proveedor_a_relacionar" id="id_proveedor_a_relacionar" />
</body>
</html>
