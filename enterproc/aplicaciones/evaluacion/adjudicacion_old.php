<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    //verifica_menu("procesos.html");

//$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	
	$id_invitacion = $id_invitacion;
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

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
    <td width="83%" class="titulos_evaluacion">CIERRE DEL PROCESO</td>
    <td width="17%"><div align="left">
      <input name="button2" type="button" class="cancelar" id="button2" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/detalle_invitacion.php?id_p=<?=$id_invitacion;?>','contenidos')">
    </div></td>
  </tr>
</table>
</p>
<br>
<br>
<br>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" class="titulos_procesos">NO ADJUDICAR EL PROCESO DE INVITACION</td>
  </tr>
  <tr>
    <td width="67%">Desde aqu&iacute; usted podra declarar el proceso anulado, cancelado, decierto o duplicar el proceso para otra ronda.</td>
    <td width="19%"><select name="b" id="b">
      <?=listas($tp1, " tp1_id not in(1,2,3,4,9,5) ",$sql_e[4],'nombre', 1);?>
    </select></td>
    <td width="14%"><input type="button" name="button" class="guardar" id="button" value="Grabar" onclick="adjudicacion()" ></td>
  </tr>
</table>
<br>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" class="titulos_procesos">ADJUDICAR EL PROCESO DE INVITACION</td>
  </tr>
  <tr>
    <td colspan="3" class="columna_titulo_resultados">Desde aqu&iacute; ustede podra adjudicar el proceso a uno o varios proveedores siga los siguientes pasos:</td>
  </tr>
  <tr>
    <td width="2%">1:</td>
    <td width="85%">Seleccione los proveedores adjudicados.</td>
    <td width="13%"><input onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso1.php?id_invitacion=<?=$id_invitacion;?>','contenidos')" type="button" name="button3" class="buscar_ajustado" id="button3" value="Ingresar al paso 1"></td>
  </tr>
  <tr>
    <td class="filas_resultados">2:</td>
    <td class="filas_resultados">Seleccione el lugar de entrega y la platilla de correos de notificaci&oacute;n a los usuarios de HOCOL S.A.</td>
    <td class="filas_resultados"><input onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso2.php?id_invitacion=<?=$id_invitacion;?>','contenidos')" type="button" name="button4" class="buscar_ajustado" id="button4" value="Ingresar al paso 2"></td>
  </tr>
  <tr>
    <td>3.</td>
    <td>Configure la carta de adjudicaci&oacute;n y los anexos por cada proveedor seleccionado</td>
    <td><input type="button" name="button5" class="buscar_ajustado" id="button5" value="Ingresar al paso 3" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso3.php?id_invitacion=<?=$id_invitacion;?>','contenidos')"></td>
  </tr>
  <tr>
    <td class="filas_resultados">4.</td>
    <td class="filas_resultados">Confirmar adjudicaci&oacute;n y enviar notificaci&oacute;n a proveedores y usuarios de HOCOL S.A.</td>
    <td class="filas_resultados"><input type="button" name="button6" class="buscar_ajustado" id="button6" value="Ingresar al paso 4" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso4.php?id_invitacion=<?=$id_invitacion;?>','contenidos')"></td>
  </tr>
</table>
<br />


<fieldset style="width:98%">
<div id="carga_evaluacion"></div>
</fieldset>

<br>
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
<input type="hidden" name="id_invitacion_pasa" value="<?=$id_invitacion;?>">

<input type="hidden" name="id_anexo">
</body>
</html>
