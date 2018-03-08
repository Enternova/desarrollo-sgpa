<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	$id_plantilla_arr = elimina_comillas(arreglo_recibe_variables($id_plantilla));
	if($id_plantilla_arr==""){
		$id_plantilla_arr=0;
	}
	
	$plantilla_qu = traer_fila_row(query_db("select * from ".$ev5."  where id =".$id_plantilla_arr));
	$id_plantilla_arr = $id_evaluacion;
	
	$requiere_edicion = elimina_comillas($_GET["requiere_edicion"]);
	if($requiere_edicion=="SI"){
		$explo_puntaje = explode(",",$puntaje_final);
		$id_plantilla_arr = $id_plantilla_editada;
	}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />

</head>

<body>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
<tr>
  <td colspan="4" align="center" class="fondo_4"><strong>FORMATO DE CALIFICACI&Oacute;N</strong></td>
</tr>
<tr>
	<td colspan="4" align="center" class="fondo_3">Rango Calificaci&oacute;n <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
  </tr>
<tr>
  <td width="2%">90</td>
  <td width="2%" align="center">-</td>
  <td width="2%">100</td>
  <td width="94%">Excelente</td>
</tr>
<tr>
  <td>80</td>
  <td align="center">-</td>
  <td>89</td>
  <td>Bueno</td>
</tr>
<tr>
  <td>60</td>
  <td align="center">-</td>
  <td>79</td>
  <td>Regular</td>
</tr>
<tr>
  <td>0</td>
  <td align="center">-</td>
  <td>59</td>
  <td>Malo</td>
</tr>
</table>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
	
	
	<?
	$lista_poliza_int = "select * from ".$ev3."  where estado = 1 order by id";
	$sql_poliza_int=query_db($lista_poliza_int);
	$cont_int=0;
	$array_enviar = "";
	while($lista_poliza_int=traer_fila_row($sql_poliza_int)){
		$peso_grupo = traer_fila_row(query_db("select distinct t8epp.plantilla,t8ep.grupo,t8epp.peso_grupo from ".$ev6." t8epp left join ".$ev4." t8ep on t8epp.pregunta = t8ep.id where t8epp.plantilla = ".$id_plantilla_arr." and t8ep.grupo=".$lista_poliza_int[0]));
			if($requiere_edicion=="SI"){
				$puntaje_grupo = $explo_puntaje[$cont_int];
			}else{
				$puntaje_grupo = $peso_grupo[2];
			}

	if($puntaje_grupo!= "" and $puntaje_grupo!= "0" ){
		?>    
		<tr>
			<td width="79%" align="center" class="fondo_7"><?=$lista_poliza_int[1];?> <span class="fondo_3"> <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></span></td>
			<td colspan="2" align="center" class="fondo_7">
			
			<input type="hidden" name="puntaje_grupo_<?=$lista_poliza_int[0];?>" id="puntaje_grupo_<?=$lista_poliza_int[0];?>" value="<?=$puntaje_grupo;?>"/>
		  <?=$puntaje_grupo;?> % <span class="fondo_3"><img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></span></td>
					<?
					if($lista_poliza_int[0]!=5){
					$total = $total + $peso_grupo[2];
					}
			?>
	
  </tr>
		<tr>
			<td colspan="3">
				<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
				  <tr class="columna_subtitulo_resultados_oscuro">
					<td width="80%">Pregunta</td>
					<td width="10%" align="center">Peso Pregunta <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
					<td width="10%" align="center">Calificaci&oacute;n <br />
				    0 - 100 <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
				  </tr>
				 
					<?
					$lista_preguntas = "select t8ep.*,t8eg.nombre ,t8et.nombre,t8et.id as tipo_pregunta,t8epp.peso_pregunta from ".$ev6." t8epp left join ".$ev4." t8ep on t8epp.pregunta = t8ep.id left join ".$ev3." t8eg on t8ep.grupo=t8eg.id left join ".$ev1." t8et on t8ep.tipo_pregunta=t8et.id where t8epp.peso_pregunta<>0 and t8epp.plantilla = ".$id_plantilla_arr." and t8ep.grupo=".$lista_poliza_int[0];
					$sql_lista_preguntas=query_db($lista_preguntas);
					while($re_lista_preguntas=traer_fila_row($sql_lista_preguntas)){						
						if($linea_color==0){
							$class_s = "columna_subtitulo_resultados_mas_oscuro";
							$linea_color = 1;
						}else{
							$class_s = "columna_subtitulo_resultados";
							$linea_color = 0;
						}
						if($array_enviar!=""){
							$coma = "|";
						}
						$array_enviar= $array_enviar.$coma.$lista_poliza_int[0].";".$re_lista_preguntas[0];
					?>    
					<tr class="<?=$class_s;?>">
						<td><img src="../imagenes/botones/flecha_a.png" width="16" height="16" />                      <?=$re_lista_preguntas[3];?></td>
					  <td><?=$re_lista_preguntas[8];?> % </td>
						<td>
					   <input type="hidden" name="aplica_pregunta[]" id="aplica_pregunta[]" value="<?=$re_lista_preguntas[0];?>" />
                       <input type="text" name="calificacion_<?=$re_lista_preguntas[0];?>" id="calificacion_<?=$re_lista_preguntas[0];?>"  value="" onchange="calcular_valor()"/>
                       <input type="hidden" name="peso_pregunta_<?=$re_lista_preguntas[0];?>" id="peso_pregunta_<?=$re_lista_preguntas[0];?>"  value="<?=$re_lista_preguntas[8];?>" />
                       
						
					  </td>
						
					</tr>
					<tr class="<?=$class_s;?>">
					  <td align="left" valign="top"><textarea name="observacion_<?=$re_lista_preguntas[0];?>" id="observacion_<?=$re_lista_preguntas[0];?>" cols="10" rows="3"></textarea></td>
					  <td colspan="2" align="left" valign="top"><label for="fileField"></label>
					  <input type="file" name="adjunto_<?=$re_lista_preguntas[0];?>" id="adjunto_<?=$re_lista_preguntas[0];?>" /></td>
				  </tr>
					<?
					}
					?> 
                    <input type="hidden" name="arr_pregunta_grupo_<?=$lista_poliza_int[0];?>" id="arr_pregunta_grupo_<?=$lista_poliza_int[0];?>" value="<?=$arr_pregunta_grupo;?>"/>             
			  </table>
			</td>
			
		</tr>
		
		
		
		<tr class="filas_resultados">
		  <td colspan="2" align="right">Total Calificaci&oacute;n Grupo <?=$lista_poliza_int[1];?>:</td>
		  <td width="10%" align="right"><input type="text" name="total2_<?=$lista_poliza_int[0];?>" id="total2_<?=$lista_poliza_int[0];?>" value="0" onkeydown='if (event.keyCode &lt; 0 || event.keyCode &gt; 0) event.returnValue = false;' size="6" maxlength="4" style=" border:0px; background:#DBFBDC; color:#000"/></td>
		</tr>
        <tr >
		  <td colspan="3" align="right">&nbsp;</td>
  </tr>
		<?

		}
				$cont_int = $cont_int+1;
		?>
   	<?
	}
	?>
    <?
    if($requiere_edicion=="SI"){
	?>
    
    <tr>
		<td align="center" class="fondo_7">TBG <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
		<td colspan="2" align="center" class="fondo_7"> <input type="hidden" name="puntaje_grupo_tbg" id="puntaje_grupo_tbg" value="<?=$explo_puntaje[$cont_int];?>"/>
	  <?=$explo_puntaje[$cont_int];?> % <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
        <?
        $peso_tbg_env = $explo_puntaje[$cont_int];
                $total = $total + $peso_tbg_env;

		?>
        
	</tr>
	 <tr>
	   <td colspan="3" align="right">
       	<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr class="columna_subtitulo_resultados_oscuro">
                  <td align="left">Pregunta</td>
                  <td align="center">Peso Pregunta <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
                <td align="center">Calificaci&oacute;n <br />
                0 - 100 <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
          </tr>
             
				<?
			
				$tb_aplica = traer_fila_row(query_db("select * from ".$ev10." where id_creador=".$_SESSION["id_us_session"]." and id_contrato = ".$id_contrato_arr." and id = (select max(id) from ".$ev10." where id_contrato = ".$id_contrato_arr.")"));
				
				$lista_preguntas = "select t8epp.id,t8epp.id_tbg,t8epp.pregunta,t8epp.tipo_pregunta,t8epp.estado,t8et.nombre from ".$ev11." t8epp left join ".$ev1." t8et on t8epp.tipo_pregunta=t8et.id where t8epp.id_tbg=".$tb_aplica[0];
				$sql_lista_preguntas=query_db($lista_preguntas);
				while($re_lista_preguntas=traer_fila_row($sql_lista_preguntas)){						
				if($linea_color==0){
						$class_s = "columna_subtitulo_resultados_mas_oscuro";
						$linea_color = 1;
					}else{
						$class_s = "columna_subtitulo_resultados";
						$linea_color = 0;
					}
					if($array_enviar_tbg!=""){
						$coma = "|";
					}
					$array_enviar= $array_enviar.$coma."0".";".$re_lista_preguntas[0];
				?>    
              	<tr class="<?=$class_s;?>">				
                    <td width="79%" align="left"><img src="../imagenes/botones/flecha_a.png" alt="" width="16" height="16" />                      <?=$re_lista_preguntas[2];?></td>
                      <input type="hidden" name="peso_pregunta_tbg_<?=$re_lista_preguntas[0];?>" id="peso_pregunta_tbg_<?=$re_lista_preguntas[0];?>"  value="<?=$re_lista_preguntas[3];?>" />
                  <td width="10%"><?=$re_lista_preguntas[3];?> % </td>
                    <td width="11%">
                   <input type="hidden" name="aplica_pregunta_tbg[]" id="aplica_pregunta_tbg[]" value="<?=$re_lista_preguntas[0];?>" />
                    <input type="text" name="calificacion_tbg_<?=$re_lista_preguntas[0];?>" id="calificacion_tbg_<?=$re_lista_preguntas[0];?>" value="" onchange="calcular_valor()"/>
                   
                  </td>
                    
          </tr>
              	<tr class="<?=$class_s;?>">
              	  <td align="left" valign="top"><textarea name="observacion_tbg_<?=$re_lista_preguntas[0];?>" id="observacion_tbg_<?=$re_lista_preguntas[0];?>" cols="10" rows="3"></textarea></td>
              	  <td colspan="2" align="left" valign="top"><label for="fileField3"></label>
              	    <input type="file" name="adjunto_tbg_<?=$re_lista_preguntas[0];?>" id="adjunto_tbg_<?=$re_lista_preguntas[0];?>" /></td>
       	  </tr>
          
                <?
				}
				?>    
                <tr class="filas_resultados">
		  <td colspan="2" align="right">Total Calificaci&oacute;n Grupo
<?=$lista_poliza_int[1];?>:</td>
		  <td width="10%" align="right"><input type="text" name="total2_0" id="total2_0" value="0" onkeydown='if (event.keyCode &lt; 0 || event.keyCode &gt; 0) event.returnValue = false;' size="6" maxlength="4" style=" border:0px; background:#DBFBDC; color:#000"/></td>
		</tr>
          <tr >
		  <td colspan="3" align="right">&nbsp;</td>
  </tr>
         </table>
       </td>
  </tr>
  <?
	}//if si requiere edicion
  ?>
  
	<tr>
	   <td colspan="2"   align="right" class="fondo_3">Total Peso Grupos <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
      <td  align="right" class="fondo_3"><input type="text" name="total" id="total" value="<?=$total." %";?>" onkeydown='if (event.keyCode < 0 || event.keyCode > 0) event.returnValue = false;' size="6" maxlength="4" style=" border:0px; background:#005395; color:#FFF"  /></td>
  </tr>
   <tr >
      <td colspan="3"  align="right" ><hr></td>
  </tr>
   <tr class="filas_resultados">
      <td colspan="2"  align="right" class="fondo_3">Total Calificaci&oacute;n <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
     <td  align="right" class="fondo_3"><input type="text" name="total3" id="total3" value="<?=$total3;?>" onkeydown='if (event.keyCode &lt; 0 || event.keyCode &gt; 0) event.returnValue = false;' size="6" maxlength="4" style=" border:0px; background:#005395; color:#FFF"/></td>
  </tr>
	 <tr>
      <td colspan="3" align="right">
      <?
    if($requiere_edicion=="SI"){
	?>
	<input name="button2" type="button" class="boton_grabar" id="button2" value="Volver a Edici&oacute;n Plantilla" onclick="cargar_formulario_evaluador('<?=$id_plantilla_arr;?>','1','<?=arreglo_pasa_variables($id_contrato_arr);?>','<?=$peso_tbg_env;?>')"/>
  <?
	}
  ?>
           <input name="button2" type="button" class="boton_grabar" id="button2" value="Grabar Evaluaci&oacute;n" onclick="graba_plantilla_fin(<?=$id_plantilla_arr;?>)"/>
      </td>
  </tr>
</table>
<input name="id_plantilla" type="hidden" value="<?=$id_plantilla_arr;?>" />
<input name="array_enviar" type="hidden" value="<?=$array_enviar;?>"/>

<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><br />
  <br />
</p>
</body>
</html>
