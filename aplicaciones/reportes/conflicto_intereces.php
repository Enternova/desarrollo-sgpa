<? include("../../librerias/lib/@session.php"); 
	//header('Content-Type: text/xml; charset=ISO-8859-1');
	
?>
<style>
.columna_subtitulo_resultados_oscuro{ height:20px;font-size:14px; color:#FFF; 
 BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#666 }
 .tabla_lista_resultados{  margin:1px;
  BORDER-BOTTOM: #cccccc 3px double; BORDER-RIGHT: #cccccc 3px  double; BORDER-TOP: #cccccc 1px solid;  	BORDER-LEFT: #cccccc 1px solid; 
  border-spacing:2px;
  overflow:scroll;
  cursor:pointer;
 }
 .xl65
	{
	mso-style-parent:style0;
	mso-number-format:"\@";
	}

.titulo1 {
	font-size:24px;
	color:#135798;
		
}
.titulo2 {
	font-size:16px;
		
}
.titulo3 {
	font-size:20px;
	background-color:#135798;
	color:#FFF;
		
}
</style>

<table width="100%" border="1">
<tr >
  <td colspan="2" rowspan="3" align="center" >&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
  <td colspan="5" align="left" class="titulo1"><strong>REPORTE CONFLICTO DE INTERECES</strong></td>
</tr>
<tr >
  <td colspan="5" align="left" ><?=$tipo_contrato_bu?></td>
</tr>
<tr >
  <td colspan="5" align="center" >&nbsp;</td>
  </tr>
<tr >
	<td width="10%" align="center" class="columna_subtitulo_resultados_oscuro">N&uacute;mero Solicitud</td>
	<td width="17%" align="center" class="columna_subtitulo_resultados_oscuro">Usuario que reporto el conflicto</td>
	<td width="13%" align="center" class="columna_subtitulo_resultados_oscuro">Rol del usuario que reporto</td>
	<td width="10%" align="center" class="columna_subtitulo_resultados_oscuro">Fecha del reporte</td>
	<td width="14%" align="center" class="columna_subtitulo_resultados_oscuro">Observacion</td>
	<td width="21%" align="center" class="columna_subtitulo_resultados_oscuro">Estado de la solicitud cuando se reporto el conflicto</td>
	<td width="15%" align="center" class="columna_subtitulo_resultados_oscuro">Estado de la solicitud actual</td>

</tr>
<?
	$busca_reportes = "select id_item, num1, num2, num3, usuario_conflicto, rol_conflicto, estado_conflicto, estado_actual, CAST(ob_devolicion AS text), fecha from vista_conflicto_intereces";
					   
	$sql_re = query_db($busca_reportes);
	
	while($ls_re=traer_fila_row($sql_re)){
			
		?>
		<tr>

		  <td align="left"><?= numero_item_pecc($ls_re[1],$ls_re[2],$ls_re[3]);?></td>
		  <td align="left"><?=$ls_re[4]?></td>
		  <td align="left"><?=$ls_re[5]?></td>
		  <td align="left"><?=$ls_re[9]?></td>
		  <td align="left"><?=$ls_re[8]?></td>
		  <td align="left"><?=$ls_re[6]?></td>
    	  <td align="left"><?=$ls_re[7]?></td>
			
		</tr>
 <?       
	}
	?>
</table>
<?

header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Conflicto de intereces.xls"); 

?>