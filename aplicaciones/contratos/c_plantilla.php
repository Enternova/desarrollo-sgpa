<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
header('Content-Type: text/xml; charset=ISO-8859-1');

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	$id_documento_arr = elimina_comillas(arreglo_recibe_variables($id_documento));
	
	if($id_documento_arr==""){
		$id_documento_arr=0;
	}
	
	$busca_contacto = "select * from $co7 where id = $id_documento_arr";
	$sql_com=traer_fila_row(query_db($busca_contacto));
	
	$busca_contrato_tipo = "select t1_tipo_documento_id from $co1 where id = $id_contrato_arr";
	$sql_tipo=traer_fila_row(query_db($busca_contrato_tipo));
	

	$busca_contrato = "select gerente from $co1 where id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));

	$edita = 0;
	$disabled = "";
	if($sql_con[0]==$_SESSION["id_us_session"]){
		$edita = 1;
	}
	
	if($edita==0){
		$disabled = " disabled='disabled' ";
	}
	//Quitar
	$edita = 1;
	//Quitar

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?
//echo imprime_cabeza_contrato($id_contrato);
if($edita==1){
?>

		<table width="100%" border="0" cellpadding="2" cellspacing="2">
			<tr >
			  <td colspan="4" align="right" valign="top"><span onclick="javascript:document.getElementById('fila_evaluador1').style.display = '';document.getElementById('fila_evaluador2').innerHTML = ''" style="cursor:pointer">Volver</span></td>
		  </tr>
          <?
          if($sql_tipo[0]==2){
		  ?>
			<tr >
			  <td colspan="3" align="right" valign="top">OT Aplica</td>
			  <td valign="top">
             
              <select name="orden_trabajo" id="orden_trabajo">
          <option value="0">Seleccione</option>
          <?
	 $lista_poliza = "select t7c.id,t1t.nombre,t7c.numero_otrosi from $co4 t7c left join $g8 t1t on t7c.tipo_complemento = t1t.id where id_contrato = $id_contrato_arr and t7c.tipo_complemento = 2";
		$sql_poliza=query_db($lista_poliza);
		while($lista_poliza=traer_fila_row($sql_poliza)){			
		?>
          <option value="<?=$lista_poliza[0];?>" <?=$sel;?>>
            <?=$lista_poliza[1];?> <?="No ".$lista_poliza[2];?>
            </option>
          <?
		}
		?>
        </select></td>
	      </tr>
          <?
		  }else{
			 ?>
             <input id="orden_trabajo" name="orden_trabajo" value="0" type="hidden" />
             <? 
			 }
		  ?>
			<tr class="fondo_4">
			  <td colspan="4" valign="top" class="fondo_4">Listado de Criterios</td>
		  </tr>
          <?
          
	$sel_grupo = "select id,nombre,estado from ".$evf5."  where estado = 1 order by nombre";
	$sql_grupo=query_db($sel_grupo);
	while($lista_grupo=traer_fila_row($sql_grupo)){
	?>    
		  
			<tr class="fondo_3">
				<td colspan="2" valign="top"><?=$lista_grupo[1];?></td>
				<td width="2%" valign="top"><img src="../imagenes/botones/help.gif" alt="" width="20" height="20" title="<?=$titulo_img;?>" /></td>
				<td width="16%" valign="top"><input type="text" name="puntaje_grupo_<?=$lista_grupo[0];?>" id="puntaje_grupo_<?=$lista_grupo[0];?>" value="" onchange="valida_cien();suma_cien()" class="porcentaje" /></td>
			</tr>
            <?
            if($lista_grupo[0]!=3){
			?>
			<tr class="columna_subtitulo_resultados_letra_normal">
				<td colspan="2" valign="top" id="carga_plantilla_evaluador">Criterios</td>
				<td valign="top" id="carga_plantilla_evaluador"><img src="../imagenes/botones/help.gif" alt="" width="20" height="20" title="" /></td>
				<td valign="top" id="carga_plantilla_evaluador">Peso Pegrunta</td>
			</tr>
              <?
	$sel_criterio = "select id,id_grupo,nombre,estado from ".$evf1."  where estado = 1 and id_grupo = ".$lista_grupo[0]." order by id";
	$sql_criterio=query_db($sel_criterio);
	while($lista_criterio=traer_fila_row($sql_criterio)){
	?>    
			<tr>
			  <td colspan="2" valign="top" id="carga_plantilla_evaluador2"><?=$lista_criterio[2];?></td>
			  <td valign="top" id="carga_plantilla_evaluador2">&nbsp;</td>
			  <td valign="top" id="carga_plantilla_evaluador2"><input type="input" name="aplica_pregunta_<?=$lista_criterio[0];?>" id="aplica_pregunta_<?=$lista_criterio[0];?>" value="" onblur="valida_cien_int_grupo(<?=$lista_grupo[0];?>,<?=$re_lista_preguntas[0];?>);" class="porcentaje" /></td>
	      </tr>
          
          
          <?
	}
		  ?>
			<tr class="columna_subtitulo_resultados_letra_normal">
			  <td colspan="2" valign="top" id="carga_plantilla_evaluador3">Peso Grupo Parcial</td>
			  <td valign="top" id="carga_plantilla_evaluador3">&nbsp;</td>
			  <td valign="top" id="carga_plantilla_evaluador3"><input type="text" name="total_pre_<?=$lista_criterio[0];?>" id="total_pre_<?=$lista_criterio[0];?>" value="" onkeydown='if (event.keyCode &lt; 0 || event.keyCode &gt; 0) event.returnValue = false;' size="6" maxlength="4" style=" border:0px; background:#DDDDDD;  background-image:url(../imagenes/botones/porcentaje.png); background-repeat:no-repeat;  background-position:right;" /></td>
	      </tr>
          <?
	}
		  ?>
			<tr >
			  <td colspan="4" valign="top">&nbsp;</td>
		  </tr>
			
          
          <?
	}
		  ?>
          <tr class="fondo_3">
				<td colspan="2" valign="top">ANS</td>
				<td width="2%" valign="top"><img src="../imagenes/botones/help.gif" alt="" width="20" height="20" title="<?=$titulo_img;?>" /></td>
				<td width="16%" valign="top"><input type="text" name="puntaje_grupo_<?=$lista_grupo[0];?>" id="puntaje_grupo_<?=$lista_grupo[0];?>" value="" onchange="valida_cien();suma_cien()" class="porcentaje" /></td>
		  </tr>
			<tr class="columna_subtitulo_resultados_letra_normal">
				<td colspan="2" valign="top" id="carga_plantilla_evaluador">Criterios</td>
				<td valign="top" id="carga_plantilla_evaluador"><img src="../imagenes/botones/help.gif" alt="" width="20" height="20" title="" /></td>
				<td valign="top" id="carga_plantilla_evaluador">Peso Pegrunta</td>
			</tr>
            <tr>
			  <td colspan="2" valign="top" id="carga_plantilla_evaluador2"><label for="textfield"></label>
		      <input name="textfield" type="text" id="textfield" value="ANS 1" /></td>
			  <td valign="top" id="carga_plantilla_evaluador2">&nbsp;</td>
			  <td valign="top" id="carga_plantilla_evaluador2"><input type="input" name="aplica_pregunta_<?=$lista_criterio[0];?>" id="aplica_pregunta_<?=$lista_criterio[0];?>" value="50" onblur="valida_cien_int_grupo(<?=$lista_grupo[0];?>,<?=$re_lista_preguntas[0];?>);" class="porcentaje" /></td>
	      </tr>
          <tr >
              <td colspan="2" valign="top" >&nbsp;</td>
              <td valign="top" >&nbsp;</td>
              <td valign="top" ><input type="submit" name="button" id="button" value="Agregar ANS" /></td>
          </tr>
          <tr class="columna_subtitulo_resultados_letra_normal">
			  <td colspan="2" valign="top" id="carga_plantilla_evaluador3">Peso Grupo Parcial</td>
			  <td valign="top" id="carga_plantilla_evaluador3">&nbsp;</td>
			  <td valign="top" id="carga_plantilla_evaluador3"><input type="text" name="total_pre_<?=$lista_criterio[0];?>" id="total_pre_<?=$lista_criterio[0];?>" value="50" onkeydown='if (event.keyCode &lt; 0 || event.keyCode &gt; 0) event.returnValue = false;' size="6" maxlength="4" style=" border:0px; background:#DDDDDD;  background-image:url(../imagenes/botones/porcentaje.png); background-repeat:no-repeat;  background-position:right;" /></td>
	      </tr>
			<tr >
			  <td colspan="4" valign="top">&nbsp;</td>
		  </tr>
			<tr class="fondo_3" >
			  <td colspan="2" valign="top">Peso Total Grupos</td>
			  <td valign="top">&nbsp;</td>
			  <td valign="top"><input type="text" name="total" id="total" value="<?=$total;?>" onkeydown='if (event.keyCode &lt; 0 || event.keyCode &gt; 0) event.returnValue = false;' size="6" maxlength="4" style=" border:0px; background:#005395; color:#FFF;background-image:url(../imagenes/botones/porcentaje.png); background-repeat:no-repeat;  background-position:right;"/></td>
	      </tr>
			<tr  >
			  <td colspan="2" valign="top">&nbsp;</td>
			  <td valign="top">&nbsp;</td>
			  <td valign="top">&nbsp;</td>
		  </tr>
			<tr  >
			  <td width="69%" valign="top">&nbsp;</td>
			  <td colspan="2" valign="top"><input type="submit" name="button3" id="button3" value="Grabar Parcial" /></td>
			  <td valign="top"><input type="submit" name="button2" id="button2" value="Enviar Gerente" /></td>
		  </tr>
			<tr  >
			  <td valign="top">&nbsp;</td>
			  <td colspan="2" valign="top">&nbsp;</td>
			  <td valign="top"><input type="submit" name="button4" id="button4" value="Aprobar" /></td>
		  </tr>
		</table>

<?
}
?>
<input name="id_documento" type="hidden" value="<?=$id_documento;?>" />

</body>
</html>
