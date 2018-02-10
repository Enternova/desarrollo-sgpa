<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	
	
	$query_comple = $_GET["query_comple"];
	$permisos = $_GET["permisos"];
	$complet = $_GET["complet"];
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
<table width="100%" border="1" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr >
  <td colspan="2" rowspan="3" align="center" >&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
  <td colspan="<?=$col;?>" align="left" class="titulo1"><strong>REPORTE CONTRATOS</strong></td>
</tr>
<tr >
  <td colspan="<?=$col;?>" align="left"><?=$tipo_contrato_bu?></td>
</tr>
<tr >
  <td colspan="<?=$col;?>" align="left"><?=$tipo_contrato_bu?></td>
</tr>
  <tr>
    <td width="8%" class="columna_subtitulo_resultados"><div align="center">Contrato</div></td>
    <td width="9%" class="columna_subtitulo_resultados"><div align="center">Estado</div></td>
    <td width="43%" class="columna_subtitulo_resultados"><div align="center">Descripci&oacute;n</div></td>
    <td width="25%" class="columna_subtitulo_resultados"><div align="center">Proveedor / Contratista</div></td>
    <td width="12%" class="columna_subtitulo_resultados"><div align="center">Fecha Creaci&oacute;n</div></td>
    <td width="12%" class="columna_subtitulo_resultados"><div align="center">Acciones Administrativas</div></td>
  </tr>
  <?
	$lista_contrato = "select * from $co1 where estado >= 1".$query_comple.$permisos.$complet."";

	$sql_contrato=query_db($lista_contrato);
	while($lista_contrato=traer_fila_row($sql_contrato)){
	
		$sel_pro = "select * from ".$g6." where t1_proveedor_id=".$lista_contrato[5];
		$sel_pro_q=traer_fila_row(query_db($sel_pro));

		
	?>
  <tr class="filas_resultados">
  <td>
    <?
    	$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$lista_contrato[19]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $lista_contrato[2];//consecutivo
		$numero_contrato4 = $lista_contrato[43];//apellido
		//echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$id_contrato_ajus = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $lista_contrato[0]);
		echo $id_contrato_ajus;
		
	?>
    </td>
    <td ><?=saca_nombre_lista("t7_contratos_estado",$lista_contrato[27],'nombre','id');?> <? if ($lista_contrato[42] == 1) echo "Congelado";?></td>
    <td><?=$lista_contrato[3];?></td>
    <td><?=$sel_pro_q[3];?></td>
    <td><?=$lista_contrato[19];?></td>
    <td>
    	<table border="1">
        <?php
        // $busAdmin = "select detalle,observacion,fecha from t7_acciones_admin where id_contrato = $lista_contrato[0] order by id desc, detalle asc ";
		// Opcional por si si se requiere mostrar todas las acciones administrativas
		// Se dejara por ahora solo mostrar las acciones de eliminar y unicamente la observacion
		// Asegurarse antes de eliminar los comentarios, pues esta funcionalidad servira posiblemente para mas adelante.
		$busAdmin = "select top(1) observacion from t7_acciones_admin where id_contrato = $lista_contrato[0] and detalle = '1. Eliminar Contrato' order by id desc ";
		$sql_busAdmin=query_db($busAdmin);
		while($rowAdmin = traer_fila_db($sql_busAdmin)){
		?>
        	<tr>
            	<!--<td><?php //echo $rowAdmin['detalle']?></td>-->
                <td><?= $rowAdmin['observacion']?></td>
                <!--<td><?php //echo $rowAdmin['fecha']?></td>-->
            </tr>
            <?php }?>
        </table>
    </td>
  </tr>
  <?
	}
	?>
</table>

</body>
</html>

<?
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Contratos $fecha.xls"); 

?>
