<?     header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");
//	header("Content-type: $tipo");
	header("Content-Disposition: attachment; filename=Reporte de tiquetes.xls"); 
	header("Content-Transfer-Encoding: binary");



//include("../../librerias/lib/@include.php");
include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");

   include("../../librerias/php/funciones_general.php");

 function dias_transcurridos($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}
	   
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style>
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
</head>

<body>
<table width="100%" border="1">
  <tr>
    <td height="107" colspan="2" align="center" valign="middle">&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
    <td colspan="5" align="left" class="titulo1"><strong>REPORTE DE CONTRATOS CON TARIFAS PENDIENTES DE APROBACION</strong></td>
  </tr>
 
<tr>
    <td width="6%" align="center" class="columna_subtitulo_resultados">Contrato</td>
    <td width="31%" align="center" class="columna_subtitulo_resultados">Proveedor</td>
    <td width="21%" align="center" class="columna_subtitulo_resultados"><div align="center">Fecha de envio</div></td>
    <td width="16%" align="center" class="columna_subtitulo_resultados">Usuario responsable</td>
    <td width="16%" align="center" class="columna_subtitulo_resultados">Rol</td>
    <td width="10%" align="center" class="columna_subtitulo_resultados">Diferencia dias de aprobaci&oacute;n</td>
    </tr>
  <?
$busca_item = "
select distinct tarifas_contrato_id,id_contrato, consecutivo, us_id, roll, fecha, Expr1, nombre_administrador from v_tarifas_responsable_aprobacion ORDER BY  fecha desc";	  

	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){
	
	
				



			     if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";
		
$interval=0;
		$interval= dias_transcurridos($ls_mr[5],$fecha);
		
							
						?>
		
 
   <tr class="<?=$class;?>">
    <td ><?=$ls_mr[2];?></td>
    <td ><?=$ls_mr[7];?></td>
    <td ><?=$ls_mr[5];?></td>
    <td ><?=$ls_mr[6];?></td>
    <td ><?=$ls_mr[4];?></td>
    <td ><?=$interval;?></td>
    </tr>
  
  <? $num_fila++;} ?>
</table>
</body>
</html>