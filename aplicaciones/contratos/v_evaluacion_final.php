<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	$id_plantilla_arr = elimina_comillas(arreglo_recibe_variables($id_plantilla));
	if($id_plantilla_arr==""){
		$id_plantilla_arr=0;
	}
	
	$plantilla_qu = traer_fila_row(query_db("select * from ".$ev5."  where id =".$id_plantilla_arr));
	
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
    <td colspan="4" align="center" class="fondo_3"> Rango Calificaci&oacute;n</td>
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
	while($lista_poliza_int=traer_fila_row($sql_poliza_int)){
		$peso_grupo = traer_fila_row(query_db("select distinct t8epp.plantilla,t8ep.grupo,t8epp.peso_grupo from ".$ev9." t8epp left join ".$ev4." t8ep on t8epp.pregunta = t8ep.id where t8epp.id_evaluacion = ".$id_plantilla_arr." and t8ep.grupo=".$lista_poliza_int[0]));
		if($peso_grupo[2]!= "" and $peso_grupo[2]!= "0" ){
	?>    
	<tr>
		<td align="center" class="fondo_7"><?=$lista_poliza_int[1];?></td>
		<td width="11%" align="center" class="fondo_7"><input type="hidden" name="puntaje_grupo_<?=$lista_poliza_int[0];?>" id="puntaje_grupo_<?=$lista_poliza_int[0];?>" value="<?=$peso_grupo[2];?>"/>
	  <?=$peso_grupo[2];?> %</td>
	</tr>
    <tr>
		<td colspan="2">
			<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr class="columna_subtitulo_resultados_oscuro">
                <td width="79%">Pregunta</td>
              	<td width="10%" align="center">Peso Pregunta</td>
              	<td width="11%" align="center">Calificaci&oacute;n <img src="../imagenes/botones/help.gif" alt="xx" width="20" height="20" /></td>
              </tr>
             
				<?
				$lista_preguntas = "select t8ep.id,t8ep.grupo,t8ep.tipo_pregunta,t8ep.pregunta,t8ep.estado,t8eg.nombre ,t8epp.adjunto,t8epp.observacion,t8epp.calificacion,t8epp2.peso_pregunta from ".$ev9." t8epp left join ".$ev4." t8ep on t8epp.pregunta = t8ep.id left join ".$ev3." t8eg on t8ep.grupo=t8eg.id left join ".$ev6." t8epp2 on t8epp.plantilla=t8epp2.plantilla and t8epp.pregunta=t8epp2.pregunta where t8epp.id_evaluacion = ".$id_plantilla_arr." and t8ep.grupo=".$lista_poliza_int[0];				$sql_lista_preguntas=query_db($lista_preguntas);
				$ponderado_par = 0;
				while($re_lista_preguntas=traer_fila_row($sql_lista_preguntas)){		
				if($linea_color==0){
						$class_s = "columna_subtitulo_resultados_mas_oscuro";
						$linea_color = 1;
					}else{
						$class_s = "columna_subtitulo_resultados";
						$linea_color = 0;
					}				
					$ponderado = $ponderado+((($re_lista_preguntas[9]*$re_lista_preguntas[8])/100)*$peso_grupo[2])/100;
					$ponderado_par = $ponderado_par+((($re_lista_preguntas[9]*$re_lista_preguntas[8])/100));
				?>    
           		<tr class="<?=$class_s;?>">
                    <td><img src="../imagenes/botones/flecha_a.png" alt="" width="16" height="16" />                      <?=$re_lista_preguntas[3];?></td>
                  <td><?=$re_lista_preguntas[9];?> %</td>
                    <td><?=$re_lista_preguntas[8];?></td>
                    
                </tr>
              	<tr>
              	   <td><?=$re_lista_preguntas[7];?></td>
                  
                    <td colspan="2">
                     <?
              if($re_lista_preguntas[6] != " "){
			  ?>
                <?=saca_nombre_anexo($re_lista_preguntas[9])?>
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$re_lista_preguntas[6]?>&n1=<?=$re_lista_preguntas[0]?>&n3=7&n4=eva" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($re_lista_preguntas[6])?>.gif" width="16" height="16" />
                  </a>
                  <?
			  }
				  ?>
                  
					</td>
           	  </tr>
              
                <?
				}
				?>            
                <tr class="filas_resultados">
		  <td colspan="2" align="right">Total Parcial Grupo <?=$lista_poliza_int[1];?>:</td>
		  <td width="8%" align="right"><input type="text" name="total2_<?=$lista_poliza_int[0];?>" id="total2_<?=$lista_poliza_int[0];?>" value="<?=$ponderado_par;?>" onkeydown='if (event.keyCode &lt; 0 || event.keyCode &gt; 0) event.returnValue = false;' size="6" maxlength="4" style=" border:0px; background:#DBFBDC; color:#000"/></td>
		</tr>
              <tr >
                  <td colspan="2" align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>  
          </table>
        </td>
	</tr>
   <?
	}
    ?>
    <?
	}
    ?>
    <?
    $sel_tbg = traer_fila_row(query_db("select * from ".$ev12." where id_evaluacion =".$id_plantilla_arr));
	if($sel_tbg[0]>0){
		
	?>
	 <tr>
		<td align="center" class="fondo_3">TBG</td>
		<td width="11%" align="center" class="fondo_3"><input type="hidden" name="puntaje_grupo_<?=$lista_poliza_int[0];?>" id="puntaje_grupo_<?=$lista_poliza_int[0];?>" value="<?=$sel_tbg[3];?>"/>
	   <?=$sel_tbg[4];?> %</td>
	</tr>
	 <tr>
	   <td colspan="2"><table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
	     <tr class="columna_subtitulo_resultados_oscuro">
	       <td width="79%">Pregunta</td>
	       <td width="10%" align="center">Peso Pregunta</td>
	       <td width="11%" align="center">Calificaci&oacute;n</td>
         </tr>
	     <?
				$lista_preguntas = "select t8ecp.id,t8ecp.id_evaluacion,t8ecp.plantilla,t8ecp.pregunta,t8ecp.peso_grupo,t8ecp.calificacion,t8ecp.adjunto,t8ecp.observacion,t8ect.id,t8ect.id_tbg,t8ect.pregunta,t8ect.tipo_pregunta,t8ect.estado,t8ety.id,t8ety.tipo_pregunta,t8ety.puntaje,t8ety.texto,t8ety.estado,t8ecp.adjunto,t8ecp.observacion from ".$ev12." t8ecp left join ".$ev11." t8ect on t8ect.id=t8ecp.pregunta left join ".$ev2." t8ety on t8ety.tipo_pregunta = t8ect.tipo_pregunta and t8ety.puntaje=t8ecp.calificacion where id_evaluacion = ".$id_plantilla_arr;
				$sql_lista_preguntas=query_db($lista_preguntas);
				$ponderado_par = 0;
				while($re_lista_preguntas=traer_fila_row($sql_lista_preguntas)){	
				if($linea_color==0){
						$class_s = "columna_subtitulo_resultados_mas_oscuro";
						$linea_color = 1;
					}else{
						$class_s = "columna_subtitulo_resultados";
						$linea_color = 0;
					}			
				
				$ponderado = $ponderado+((($re_lista_preguntas[11]*$re_lista_preguntas[5])/100)*$sel_tbg[4])/100;
				$ponderado_par = $ponderado_par+((($re_lista_preguntas[11]*$re_lista_preguntas[5])/100));	
				?>
	    <tr class="<?=$class_s;?>">
	       <td><img src="../imagenes/botones/flecha_a.png" alt="" width="16" height="16" />	         <?=$re_lista_preguntas[10];?></td>
	       <td><?=$re_lista_preguntas[11];?> %</td>
           <td><?=$re_lista_preguntas[5];?></td>
	      
         </tr>
         	<tr>
              	   <td><?=$re_lista_preguntas[19];?></td>
                  
                    <td colspan="2">
                     <?
              if($re_lista_preguntas[18] != " "){
			  ?>
                <?=saca_nombre_anexo($re_lista_preguntas[18])?>
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$re_lista_preguntas[18]?>&n1=<?=$re_lista_preguntas[0]?>&n3=7&n4=tbg" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($re_lista_preguntas[18])?>.gif" width="16" height="16" />
                  </a>
                  <?
			  }
				  ?>
                    </td>
           	  </tr>
	     <?
				}
				?>
                <tr class="filas_resultados">
		  <td colspan="2" align="right">Total Parcial Grupo <?=$lista_poliza_int[1];?>:</td>
		  <td width="11%" align="right"><input type="text" name="total2_<?=$lista_poliza_int[0];?>" id="total2_<?=$lista_poliza_int[0];?>" value="<?=$ponderado_par;?>" onkeydown='if (event.keyCode &lt; 0 || event.keyCode &gt; 0) event.returnValue = false;' size="6" maxlength="4" style=" border:0px; background:#DBFBDC; color:#000"/></td>
		</tr>
                <tr>
                  <td colspan="2" align="right">&nbsp;</td>
                  <td align="right">&nbsp;</td>
                </tr>
                <tr class="fondo_3">
                  <td colspan="2" align="right">Total Peso Grupos</td>
                  <td align="right"><input type="text" name="total" id="total" value="<?="100"." %";?>" onkeydown='if (event.keyCode &lt; 0 || event.keyCode &gt; 0) event.returnValue = false;' size="6" maxlength="4" style=" border:0px; background:#005395; color:#FFF"  /></td>
                </tr>
         <tr>
                  <td colspan="3" align="right"><hr /></td>
         </tr>
         <tr class="fondo_3">
                  <td colspan="2" align="right">Total Calificaci&oacute;n</td>
                  <td align="right"><input type="text" name="total3" id="total3" value="<?=$ponderado." %";?>" onkeydown='if (event.keyCode &lt; 0 || event.keyCode &gt; 0) event.returnValue = false;' size="6" maxlength="4" style=" border:0px; background:#005395; color:#FFF"/></td>
                </tr>  
       </table></td>
  </tr>
  <?
	}//if tbg
  ?>
</table>
<input name="id_plantilla" type="hidden" value="<?=$id_plantilla;?>" />
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
