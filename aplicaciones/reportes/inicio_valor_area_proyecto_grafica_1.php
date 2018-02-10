<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	include "../../librerias/chart/FusionCharts.php";
	include "../../librerias/chart/Functions.php";	
	
	$fecha_hoy = date("Y-m-d");
	
if($_POST["eq_moneda"] == 1){
	$moneda = "USD";
	$campo_suma = "saldo_eq_usd";
	$numberPrefix='US$';
	}
if($_POST["eq_moneda"] == 2){
	$moneda = "COP";
	$campo_suma = "saldo_eq_cop";
	$numberPrefix='COP$';
	}

$id_usuario_reporte = 18463;

		$numero1_pecc = arreglo_recibe_variables($_POST["numero1_pecc"]);
		$numero2_pecc = arreglo_recibe_variables($_POST["numero2_pecc"]);
		$numero3_pecc = arreglo_recibe_variables($_POST["numero3_pecc"]);
		$n_contrato_ano = arreglo_recibe_variables($_POST["n_contrato_ano"]);
		$n_contrato = arreglo_recibe_variables($_POST["n_contrato"]);		
		$numero3_pecc = $numero3_pecc *1;
		$n_contrato = $n_contrato *1;
		
		$comple_sql = " and (estado >= 20 and estado <=32 and estado <> 31)";
		
		if($numero1_pecc != 0){
			$comple_sql.=" and num1 like '%".$numero1_pecc."%'";
			}
		if($numero2_pecc != 0){
			$comple_sql.=" and num2 like '%".$numero2_pecc."%'";
			}
		if($numero3_pecc != 0){
			$comple_sql.=" and num3 = '".$numero3_pecc."'";
			}
			
		if($_POST["ano_valores"] != 0){
			$n_contrato_ano=$_POST["ano_valores"];
						if($n_contrato_ano == 9) $n_contrato_ano = '2009';
						if($n_contrato_ano == 10) $n_contrato_ano = '2010';
						if($n_contrato_ano == 11) $n_contrato_ano = '2011';
						if($n_contrato_ano == 12) $n_contrato_ano = '2012';
						if($n_contrato_ano == 13) $n_contrato_ano = '2013';
						if($n_contrato_ano == 14) $n_contrato_ano = '2014';
						if($n_contrato_ano == 15) $n_contrato_ano = '2015';
						if($n_contrato_ano == 16) $n_contrato_ano = '2016';
						if($n_contrato_ano == 17) $n_contrato_ano = '2017';
						if($n_contrato_ano == 18) $n_contrato_ano = '2018';
						if($n_contrato_ano == 19) $n_contrato_ano = '2019';
						if($n_contrato_ano == 20) $n_contrato_ano = '2020';
			$comple_sql.=" and ano = '".$n_contrato_ano."'";
			}
		if($_POST["campo"] != 0){
			$comple_sql.=" and id_campo = '".$_POST["campo"]."'";
			}
			
		/*
				if($n_contrato != ""){
			$comple_sql.=" and t3.consecutivo = '".$n_contrato."'";
			}
			
					if($n_contrato_ano != ""){
						
						if($n_contrato_ano == 9) $n_contrato_ano = '2009';
						if($n_contrato_ano == 10) $n_contrato_ano = '2010';
						if($n_contrato_ano == 11) $n_contrato_ano = '2011';
						if($n_contrato_ano == 12) $n_contrato_ano = '2012';
						if($n_contrato_ano == 13) $n_contrato_ano = '2013';
						if($n_contrato_ano == 14) $n_contrato_ano = '2014';
						if($n_contrato_ano == 15) $n_contrato_ano = '2015';
						if($n_contrato_ano == 16) $n_contrato_ano = '2016';
						if($n_contrato_ano == 17) $n_contrato_ano = '2017';
						if($n_contrato_ano == 18) $n_contrato_ano = '2018';
						if($n_contrato_ano == 19) $n_contrato_ano = '2019';
						if($n_contrato_ano == 20) $n_contrato_ano = '2020';
			$comple_sql.=" and t3.creacion_sistema like '%".$n_contrato_ano."%'";
			}
			
			*/
  
		?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../../librerias/chart/FusionCharts.js"></script>	
</head>

<body>

<table width="100%" border="0" class="tabla_lista_resultados">
<tr>
  <td align="center"><table width="100%" border="0" class="tabla_blanca">
    <tr>
      <td bgcolor=""><a href="inicio_valor_area_proyecto_soporte1.php?numero1_pecc=<?=$_POST["numero1_pecc"]?>&amp;eq_moneda=<?=$_POST["eq_moneda"]?>&amp;numero2_pecc=<?=$_POST["numero2_pecc"]?>&amp;numero3_pecc=<?=$_POST["numero3_pecc"]?>&amp;n_contrato_ano=<?=$_POST["n_contrato_ano"]?>&amp;n_contrato=<?=$_POST["n_contrato"]?>&ano_valores=<?=$_POST["ano_valores"]?>&campo=<?=$_POST["campo"]?>" target="_blank"><img src="../../imagenes/mime/xlsx.gif" alt="" />Descargar el Soporte de Este Indicador</a></td>
    </tr>
    <?
    if($_POST["ano_valores"] == 0 or ($_POST["campo"] != 0 and $_POST["ano_valores"] != 0)){
	?>
    <tr>
      <td class="fondo_3" bgcolor="">1. Valor Total de los Contratos por A&ntilde;o</td>
      </tr>
    <tr>
      <td class="" bgcolor="" align="Center">
      
      <?
		


 $sql_sel_valores = "select  ano, sum(".$campo_suma.") from indicador_valor_area_proyecto where id_us= '".$id_usuario_reporte."' ".$comple_sql." and tipo in ('inicial', 'ampliacion', 'reclasificacion') group by ano order by ano";
$strXML = "";
$strXML = "<chart caption='' numberPrefix='".$numberPrefix."' decimalPrecision='0' formatNumberScale='3'  numberPrefix='' seriesNameInToolTip='0'  showValues='0' labelDisplay='rotate' slantLabels='2'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";

$selec_t_pro = query_db($sql_sel_valores);
while($sel_pro = traer_fila_db($selec_t_pro)){
$strXML .= "<set label = '".$sel_pro[0]."' value ='".$sel_pro[1]."' color = '006633' />";	
	$va_total = $sel_pro[1] +$va_total;
	}

$strXML .= "<set label = 'Total' value ='".$va_total."' color = '0033CC' />";

$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicadoranos", 800, 400, false, false);
		
	?>
      </td>
    </tr>
    <?
	}
	if($_POST["campo"] == 0 or ($_POST["campo"] != 0 and $_POST["ano_valores"] != 0)){
	?>
    <tr>
      <td class="fondo_3" bgcolor="">2. Valor Total de los Contratos por &Aacute;rea/Proyecto</td>
    </tr>
    <tr>
      <td class="" bgcolor="" align="center"><?
		
$va_total=0;

$sql_sel_valores = "select  campo, sum(".$campo_suma.") from indicador_valor_area_proyecto where id_us= '".$id_usuario_reporte."' ".$comple_sql." and tipo in ('inicial', 'ampliacion', 'reclasificacion') group by campo";
$strXML = "";
$strXML = "<chart caption='' numberPrefix='".$numberPrefix."' decimalPrecision='0' formatNumberScale='3'  numberPrefix='' seriesNameInToolTip='0'  showValues='0' labelDisplay='rotate' slantLabels='2'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";

$selec_t_pro = query_db($sql_sel_valores);
while($sel_pro = traer_fila_db($selec_t_pro)){
$strXML .= "<set label = '".$sel_pro[0]."' value ='".$sel_pro[1]."' color = '006633' />";	
	$va_total = $sel_pro[1] +$va_total;
	}

$strXML .= "<set label = 'Total' value ='".$va_total."' color = '0033CC' />";

$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador25885", 800, 500, false, false);

	?></td>
      </tr>
      <?
	}
	  ?>
    <tr>
      <td align="center">&nbsp;</td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      </tr>
    </table></td>
</tr>
<tr>
  <td align="center">
  
  <iframe name="genera_indica_1" id="genera_indica_1" frameborder="0" width="100%" height="5200px"></iframe>
  
  </td>
</tr>
</table>
     
       

</body>
</html>

