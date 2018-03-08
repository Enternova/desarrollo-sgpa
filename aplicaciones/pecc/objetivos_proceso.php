<? include("../../librerias/lib/@session.php"); 
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	
	
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	
	$edicion_datos = "NO";
	
	if($_GET["permiso_ad_ob_proceso"]==2 and ($sel_item[6]==4 or $sel_item[6]==5 or $sel_item[6]==13 or $sel_item[6]==14 or $sel_item[6]==7 or $sel_item[6]==8 or $sel_item[6]==9 or $sel_item[6]==10 or $sel_item[6]==11 or $sel_item[6]==12)){
				$_GET["permiso_ad_ob_proceso"]=1;
			}

		echo $_GET["permiso_ad_ob_proceso"];
		if($_GET["permiso_ad_ob_proceso"]==1){	
			$permiso_adj=1;
			
			$campos_consulta="CAST(p_oportunidad as TEXT), CAST(p_costo AS TEXT), CAST(p_calidad AS TEXT), CAST(p_optimizar AS TEXT), CAST(p_trazabilidad AS TEXT), CAST(p_transparencia AS TEXT), CAST(p_sostenibilidad AS TEXT)";
			if($sel_item[14]==6 and $sel_item[23]==$_SESSION["id_us_session"]){
			$edicion_datos = "SI";	
			}
			}
		if($_GET["permiso_ad_ob_proceso"]==2){			
			$permiso_adj=2;			
			$campos_consulta="CAST(a_oportunidad AS TEXT), CAST(a_costo AS TEXT), CAST(a_calidad AS TEXT), CAST(a_optimizar AS TEXT), CAST(a_trazabilidad AS TEXT), CAST(a_transparencia AS TEXT), CAST(a_sostenibilidad AS TEXT)";
			if($sel_item[14]==14 and $sel_item[23]==$_SESSION["id_us_session"]){
			$edicion_datos = "SI";	
			}
			}
		

		
	
	$busvca_tex = traer_fila_row(query_db("select $campos_consulta from t2_objetivos_proceso where id_item = ".$id_item_pecc));
	
			$p_oportunidad=$busvca_tex[0];
			$p_costo=$busvca_tex[1];
			$p_calidad=$busvca_tex[2];
			$p_optimizar=$busvca_tex[3];
			$p_trazabilidad=$busvca_tex[4];
			$p_transparencia=$busvca_tex[5];
			$p_sostenibilidad=$busvca_tex[6];
	
	
	if(esprofesionalcompras($id_item_pecc)=="SI" and $sel_item[14]==16){
	 $edicion_datos="SI";
	 }
	 
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>


<body>


  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <table width="50%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF"   class="tabla_lista_resultados">
<tr>
  <td colspan="2" align="center"   class="fondo_3">Objetivos del Proceso</td>
  </tr>
<tr>
  <td align="center"  class="fondo_3">Objetivo </td>
  <td align="center" class="fondo_3">Descripci&oacute;n</td>
  </tr>
<tr>
  <td width="28%" align="right">Oportunidad:</td>
  <td width="36%" align="left"><? if($edicion_datos=="SI") { ?> <textarea name="campos1" id="campos1"><?=$p_oportunidad?></textarea><? } else {echo $p_oportunidad; }?></td>
  </tr>
<tr>
  <td align="right">Costo-Beneficio:</td>
  <td align="left"><? if($edicion_datos=="SI") { ?><textarea name="campos2" id="campos2"><?=$p_costo?></textarea><? } else echo $p_costo; ?></td>
  </tr>
<tr>
  <td align="right">Calidad:</td>
  <td align="left"><? if($edicion_datos=="SI") { ?><textarea name="campos3" id="campos3"><?=$p_calidad?></textarea><? } else echo $p_calidad; ?></td>
  </tr>
<tr>
  <td align="right">Optimizar Transferencia Riesgos:</td>
  <td align="left"><? if($edicion_datos=="SI") { ?><textarea name="campos4" id="campos4"><?=$p_optimizar?></textarea><? } else echo $p_optimizar; ?></td>
  </tr>
<tr>
  <td align="right">Trazabilidad:</td>
  <td align="left"><? if($edicion_datos=="SI") { ?><textarea name="campos5" id="campos5"><?=$p_trazabilidad?></textarea><? } else echo $p_trazabilidad; ?></td>
  </tr>
<tr>
  <td align="right">Transparencia:</td>
  <td align="left"><? if($edicion_datos=="SI") { ?><textarea name="campos6" id="campos6"><?=$p_transparencia?></textarea><? } else echo $p_transparencia; ?></td>
  </tr>
<tr>
  <td align="right">Sostenibilidad:</td>
  <td align="left"><? if($edicion_datos=="SI") { ?><textarea name="campos7" id="campos7"><?=$p_sostenibilidad?></textarea><? } else echo $p_sostenibilidad; ?></td>
  </tr>
<tr>
  <td align="right"><input type="button" value="  <?  if($edicion_datos=="SI"){ echo "Cancelar";} else { echo "Cerrar"; } ?>" class="boton_grabar_cancelar windowPopupClose" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="none"' /></td>
  <td align="right">
  <?
  if($edicion_datos=="SI"){
  ?>
  <input type="button" value="Grabar los Objetivos" class="boton_grabar" onclick='graba_objetivos_proceso()' /></td>
  <?
  }
  ?>
  </tr>

</table>



<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
</body>
</html>
