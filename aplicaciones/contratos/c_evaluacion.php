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
	
	<td width="86%"></tr>
	<tr class="fondo_4">
		<td colspan="3" >Listado de Preguntas</td>
  	</tr>
	<?
	$cont_grupo_int=0;
	$array_grupo = "";
	
	$lista_poliza_int = "select * from ".$ev3."  where estado = 1 order by id";
	$sql_poliza_int=query_db($lista_poliza_int);
	while($lista_poliza_int=traer_fila_row($sql_poliza_int)){
		
		$peso_grupo = traer_fila_row(query_db("select distinct t8epp.plantilla,t8ep.grupo,t8epp.peso_grupo from ".$ev6." t8epp left join ".$ev4." t8ep on t8epp.pregunta = t8ep.id where t8epp.plantilla = ".$id_plantilla_arr." and t8ep.grupo=".$lista_poliza_int[0]));
		if($lista_poliza_int[0]!=5){
			$total = $total + $peso_grupo[2];
			if($array_grupo!=""){
				$coma = ",";
			}
			$array_grupo= $array_grupo.$coma.$lista_poliza_int[0];
			$cont_grupo_int = $cont_grupo_int+1;
			
			$titulo_img = "Corresponde al peso del grupo ".$lista_poliza_int[1]." de preguntas sobre el total de la evaluaci&oacute;n, esto por si no edita TBG, si edita TBG lo anterior, mas al sumar con los otros grupos en total peso grupos debe dar 100%, en la sumatoria no tener en cuenta el grupo de valor agregado";
		}else{
			$titulo_img = "Corresponde al peso del grupo ".$lista_poliza_int[1]." este grupo de preguntas es solo si el evaluador quiere dar un reconocimiento especial por su desempe&ntilde;o";
		}
		$array_grupo_todos= $array_grupo_todos.$coma.$lista_poliza_int[0];
	?>    
	<tr>
		<td class="fondo_3"><?=$lista_poliza_int[1];?></td>
		<td width="3%" class="fondo_3"><img src="../imagenes/botones/help.gif" title="<?=$titulo_img;?>" width="20" height="20" /></td>
		<td width="11%" class="fondo_3"><input type="text" name="puntaje_grupo_<?=$lista_poliza_int[0];?>" id="puntaje_grupo_<?=$lista_poliza_int[0];?>" value="<?=$peso_grupo[2];?>" onchange="valida_cien();suma_cien()" class="porcentaje" /></td>
        <?
                
		?>
	</tr>
    <tr>
		<td colspan="3">
			<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr class="columna_subtitulo_resultados">
                <td width="87%">Pregunta</td>
              	<td width="13%" align="center"><img src="../imagenes/botones/help.gif" title="Corresponde al peso de cada pregunta sobre el grupo de preguntas. esto por si no edita TBG, si edita TBG lo anterior, m&aacute;s al sumar con las otras preguntas en peso de grupo parcial debe dar 100%" width="20" height="20" /> Peso Pregunta</td>
              </tr>
             
				<?
				$lista_preguntas = "select t8ep.id,t8ep.grupo,t8ep.tipo_pregunta,t8ep.pregunta,t8ep.estado,t8eg.nombre  from ".$ev4." t8ep left join ".$ev3." t8eg on t8ep.grupo=t8eg.id  where  t8ep.grupo = ".$lista_poliza_int[0]." order by t8ep.pregunta ";
				$sql_lista_preguntas=query_db($lista_preguntas);
				$arr_pregunta_grupo = "";
				$coma="";
				$suma_pregunta_grupo = 0;
				while($re_lista_preguntas=traer_fila_row($sql_lista_preguntas)){
						$aplica_histo = traer_fila_row(query_db("select * from ".$ev6."  where plantilla =".$id_plantilla_arr." and pregunta =".$re_lista_preguntas[0]));
						$peso_pregunta  = 0;
						if($aplica_histo[0]!="" and $aplica_histo[4] <> ""){
							$peso_pregunta = $aplica_histo[4];							
						}
						
						if($arr_pregunta_grupo<>""){
							$coma=",";
						}
							$arr_pregunta_grupo = $arr_pregunta_grupo.$coma.$re_lista_preguntas[0];
							$suma_pregunta_grupo = $suma_pregunta_grupo+$peso_pregunta;
				?>    
              	<tr>
                    <td><?=$re_lista_preguntas[3];?></td>
                    <td><input type="input" name="aplica_pregunta_<?=$re_lista_preguntas[0];?>" id="aplica_pregunta_<?=$re_lista_preguntas[0];?>" value="<?=$peso_pregunta;?>" onblur="valida_cien_int_grupo(<?=$lista_poliza_int[0];?>,<?=$re_lista_preguntas[0];?>);" class="porcentaje" /></td>
                </tr>
              	
                <?
				}
				?>              
              <tr  class="columna_subtitulo_resultados">
              	  <td>Peso Grupo Parcial</td>
              	  <td>
              	    <input type="text" name="total_pre_<?=$lista_poliza_int[0];?>" id="total_pre_<?=$lista_poliza_int[0];?>" value="<?=$suma_pregunta_grupo;?>" onkeydown='if (event.keyCode &lt; 0 || event.keyCode &gt; 0) event.returnValue = false;' size="6" maxlength="4" style=" border:0px; background:#DDDDDD;  background-image:url(../imagenes/botones/porcentaje.png); background-repeat:no-repeat;  background-position:right;" />
           	    </td>
           	  </tr>
              <input type="hidden" name="arr_pregunta_grupo_<?=$lista_poliza_int[0];?>" id="arr_pregunta_grupo_<?=$lista_poliza_int[0];?>" value="<?=$arr_pregunta_grupo;?>"/>
          </table>
        </td>
	</tr>
   
    <?
	}
    ?>
	<tr>
		<td class="fondo_3">TBG</td>
		<td class="fondo_3"><img src="../imagenes/botones/help.gif" title="" width="20" height="20" /></td>
		<td width="11%" class="fondo_3"><input type="text" name="puntaje_grupo_tbg" id="puntaje_grupo_tbg" value="<?=$peso_tbg_env;?>" onchange="valida_cien();suma_cien()" class="porcentaje" /></td>
         <?
                $total = $total + $peso_tbg_env;
		?>
	</tr>
	 <tr>
	   <td colspan="3" align="right">
       <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr class="columna_subtitulo_resultados">
                <td width="87%" align="left">Pregunta <img src="../imagenes/botones/help.gif" title="" width="20" height="20" /></td>
              	<td width="13%" align="center"><img src="../imagenes/botones/help.gif" title="" width="20" height="20" /> Peso Pregunta</td>
              </tr>
              	<tr>
              	  <td colspan="2" align="left">
                  <?

				$tb_aplica = traer_fila_row(query_db("select * from ".$ev10." where id_creador=".$_SESSION["id_us_session"]." and id_contrato = ".$id_contrato_arr." and id = (select max(id) from ".$ev10." where id_contrato = ".$id_contrato_arr.")"));
				if($tb_aplica>=1){
					$suma_pregunta_grupo = 0;
					$cont=0;
					$lista_preguntas = "select t8epp.id,t8epp.id_tbg,t8epp.pregunta,t8epp.tipo_pregunta,t8epp.estado,t8et.nombre from ".$ev11." t8epp left join ".$ev1." t8et on t8epp.tipo_pregunta=t8et.id where t8epp.id_tbg=".$tb_aplica[0];
					$sql_lista_preguntas=query_db($lista_preguntas);
					while($re_lista_preguntas=traer_fila_row($sql_lista_preguntas)){	
					$suma_pregunta_grupo = $suma_pregunta_grupo+$re_lista_preguntas[3];
					$cont=$cont+1;				
					?>    
					 <table width="100%">
						  <tr>
							<td width="89%"><input type="text" name="pregunta_<?=$cont;?>" id="pregunta_<?=$cont;?>" value="<?=$re_lista_preguntas[2];;?>"/></td>
							  <td width="11%">
                              <input type="text" name="tipo_pregunta_<?=$cont;?>" id="tipo_pregunta_<?=$cont;?>" value="<?=$re_lista_preguntas[3];?>" class="porcentaje" onblur="valida_cien_int_grupo(0,'<?=$cont;?>');"/>
                            </td>
						  </tr>
					  </table>
					<?
					
					}
					?>            
					<?
				}else{//if if($tb_aplica>=1){
				?>
                  <?
				  $cont=1;
                  ?>
                  <table width="100%">
                      <tr>
                        <td width="89%"><input type="text" name="pregunta_<?=$cont;?>" id="pregunta_<?=$cont;?>"/></td>
                          <td width="11%">
                           <input type="text" name="tipo_pregunta_<?=$cont;?>" id="tipo_pregunta_<?=$cont;?>" value="<?=$pregunta_qu[2];?>" class="porcentaje" onblur="valida_cien_int_grupo(0,'<?=$cont;?>');"/>
                        </td>
                      </tr>
                  </table>
                <?
				}
				?>  
                  <input name="con_pregunta" type="hidden" value="<?=$cont;?>" />
                  <?
                  $cont2=$cont+1;
				  ?>
                  <div id="div_pregunta_<?=$cont2;?>"></div>
                  </td>
   	     </tr>
              	<tr>
              	  <td align="left"><input name="agre_1" type="button" class="boton_grabar" id="c_<?=$cont2;?>" value="Agregar Pregunta" onclick="agrega_pregunta(this.id,1,this,1);"/></td>
              	  <td>&nbsp;</td>
   	     </tr>
          <tr  class="columna_subtitulo_resultados">
              	  <td align="left">Peso Grupo Parcial</td>
              	  <td>
              	   <input type="text" name="total_pre_<?=$lista_poliza_int[0];?>" id="total_pre_<?=$lista_poliza_int[0];?>" value="<?=$suma_pregunta_grupo;?>" onkeydown='if (event.keyCode &lt; 0 || event.keyCode &gt; 0) event.returnValue = false;' size="6" maxlength="4" style=" border:0px; background:#DDDDDD;background-image:url(../imagenes/botones/porcentaje.png); background-repeat:no-repeat;  background-position:right;"/>
       	    </td>
   	     </tr>
         </table>
       </td>
  </tr>
   
    <tr>
	   <td colspan="2"  align="left" class="fondo_3">Total Peso Grupos <img src="../imagenes/botones/help.gif" title="" width="20" height="20" /></td>
	   <td  align="right" class="fondo_3"><input type="text" name="total" id="total" value="<?=$total;?>" onkeydown='if (event.keyCode < 0 || event.keyCode > 0) event.returnValue = false;' size="6" maxlength="4" style=" border:0px; background:#005395; color:#FFF;background-image:url(../imagenes/botones/porcentaje.png); background-repeat:no-repeat;  background-position:right;"/></td>
  </tr>
	 <tr>
      <td colspan="3" align="right">
           <input name="graba_tbg_b" type="button" class="boton_grabar" id="graba_tbg_b" value="Grabar Plantilla y Continuar con la Evaluacion" onclick="graba_tbg(<?=$id_plantilla_arr;?>)"/>
      </td>
  </tr>
</table>
<input name="id_plantilla" type="hidden" value="<?=$id_plantilla;?>" />
<input name="cont_grupo_int" type="hidden" value="<?=$cont_grupo_int;?>"/>
<input name="array_grupo_env" type="hidden" value="<?=$array_grupo;?>"/>
<input name="array_grupo_todos_env" type="hidden" value="<?=$array_grupo_todos;?>"/>
<input name="puntaje_final" type="hidden" value=""/>
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
