<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");	
	header('Content-Type: text/xml; charset=ISO-8859-1');
?>
<?
if($_GET["tipo"]==1){
$cont_grupo = $_GET["cont_grupo"];

?>
<table width="100%">
                  <tr>
                    <td width="89%"><input type="text" name="pregunta_<?=$numero_actual?>" id="pregunta_<?=$numero_actual?>" /></td>
                  <td width="11%">
                  <input type="text" name="tipo_pregunta_<?=$numero_actual;?>" id="tipo_pregunta_<?=$numero_actual;?>" value=""/>
</td>
                  </tr>
                  <input type="hidden" name="p_r_item_1_<?=$cont_grupo;?>_<?=$numero_actual?>_<?=$ano_eje;?>" value="0" />
                  </table>
<div id="div_pregunta_<?=$numero_siguiente?>"></div>

<?
}
?>

<?
if($_GET["tipo"]==2){
?>
	<table width="100%">
		<tr>
			<td width="47%" align="right"><font size="-2">Acta Socios:</font></td>
			<td width="17%" align="center"><select name="aplica_acta" id="aplica_acta">
			  <option value="1">SI</option>
			  <option value="2">NO</option>
	        </select></td>
			<td width="8%" align="center"><input type="checkbox" name="acta_socios" id="acta_socios"  value="1"/></td>
			<td width="28%">&nbsp;</td>
		</tr>
		<tr>
			<td align="right"><font size="-2">Recibido P&oacute;lizas</font>:</td>
			<td align="center">&nbsp;</td>
			<td align="center"><input type="checkbox" name="recibido_poliza" id="recibido_poliza"  value="1"/></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
			<td align="right"><font size="-2">Camara y Comercio</font>:</td>
			<td align="center">&nbsp;</td>
			<td align="center"><input type="checkbox" name="camara_comercio" id="camara_comercio" value="1"/></td>
			<td>&nbsp;</td>
		</tr>
		<tr>
		  <td align="right"><font size="-2">Recibo de Polizas</font>:</td>
		  <td align="center">&nbsp;</td>
		  <td align="center"><input type="checkbox" name="recibo_poliza" id="recibo_poliza" value="1" /></td>
		  <td>&nbsp;</td>
	  </tr>
		<tr>
		  <td align="right">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td align="center">&nbsp;</td>
		  <td>&nbsp;</td>
	  </tr>
	</table>

<?
}
?>