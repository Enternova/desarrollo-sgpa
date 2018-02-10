<? include("../../librerias/lib/@session.php"); 
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	
$link = mysql_connect($host_mys,$usr_mys, $pwd_mys); 
mysql_select_db($dbbase_mys, $link);
	
	
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
  
  <table width="50%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
    <tr>
  <td width="50%" align="right"> Consecutivo:</td>
  <td width="50%"><input type="text" name="consecutivo_bu" id="consecutivo_bu" value="<?=$id_proceso;?>" /></td>
  </tr>
<tr>
  <td align="right">Tipo de Solicitud:</td>
  <td>
    <? 

	$sel_estado = mysql_query("SELECT  * FROM  tp3_area_solicitante where tp3_id	 not in (3)");
					?>
  <select name="tp_solicitud_bu" id="tp_solicitud_bu">
    <option value="0">Seleccione</option>
        
         <?
        	while($sel_est = mysql_fetch_array($sel_estado)){
				?>
				<option value="<?=$sel_est[0]?>"><?=$sel_est[1]?></option>
				<?
				}
		?>
      </select></td>
  </tr>
<tr align="right">
  <td>Estado:</td>
  <td align="left">
  <? 

	$sel_estado = mysql_query("SELECT  * FROM  tp1_estado_proceso where tp1_id not in (1,2,3,6, 9,11,10)");
					?>
                    <select name="estado_bu" id="estado_bu">
        
        <option value="0">Seleccione</option>
        
         <?
        	while($sel_est = mysql_fetch_array($sel_estado)){
				?>
				<option value="<?=$sel_est[0]?>"><?=$sel_est[1]?></option>
				<?
				}
		?>
      </select></td>
  </tr>
<tr>
  <td align="right">Fecha de Apertura:</td>
  <td><input type="text" name="fecha_aper_bu" id="fecha_aper_bu" onclick="calendario_se('i')" value="<?=$sql_e[17];?>"/></td>
  </tr>
<tr>
  <td align="right">Fecha de Cierre:</td>
  <td><input type="text" name="fecja_cierre_bu" id="fecja_cierre_bu" onclick="calendario_se('j')" value="<?=$sql_e[18];?>"/></td>
  </tr>
<tr>
  <td align="right">Profesional de C&amp;C:</td>
  <td>
  <? 

	$sel_profesional = mysql_query("SELECT  us_usuarios.us_id, us_usuarios.nombre_administrador FROM  pro1_proceso, us_usuarios where pro1_proceso.us_id =  us_usuarios.us_id and tipo_usuario in (1,3,4, 10) and us_usuarios.us_id not in (1, 21708, 32) and us_usuarios.pv_principal = 150 GROUP BY  pro1_proceso.us_id order by us_usuarios.nombre_administrador");
					?>
  <select name="profesional_bu" id="profesional_bu">
    <option value="0">Seleccione</option>
        <?
        	while($sel_pro = mysql_fetch_array($sel_profesional)){
				?>
				<option value="<?=$sel_pro[0]?>"><?=$sel_pro[1]?></option>
				<?
				}
		?>
      </select></td>
  </tr>
<tr>
  <td align="right">Detalle del objeto a contratar:</td>
  <td><textarea name="detalle_busca" id="detalle_busca" cols="30" rows="3"><?=$detalle_busca;?></textarea></td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
<tr>
  <td>&nbsp;</td>
  <td>&nbsp;</td>
  </tr>
<tr>
  <td align="center">
        
  <input type="button" name="button5" id="button5" value="Realizar B&uacute;squeda" class="boton_buscar" onclick="ajax_carga('../aplicaciones/pecc/busca_sondeos_urna_lista.php?consecutivo_bu='+document.getElementById('consecutivo_bu').value+'&tp_solicitud_bu='+document.getElementById('tp_solicitud_bu').value+'&estado_bu='+document.getElementById('estado_bu').value+'&fecha_aper_bu='+document.getElementById('fecha_aper_bu').value+'&fecja_cierre_bu='+document.getElementById('fecja_cierre_bu').value+'&profesional_bu='+document.getElementById('profesional_bu').value+'&detalle_busca='+document.getElementById('detalle_busca').value,'carga_lista_contratos_marco12'); " /></td>
  <td align="center">
  
  <input type="button" value="Cancelar" class="boton_grabar_cancelar windowPopupClose" onclick='window.parent.document.getElementById(&quot;div_carga_busca_sol&quot;).style.display=&quot;none&quot;; body.style.overflow = &quot;visible&quot;' /></td>
  </tr>
<tr>
  <td colspan="2" align="center"><div id="carga_lista_contratos_marco12"></div></td>
  </tr>

</table>




</body>
</html>
