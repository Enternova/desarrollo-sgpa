<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	include "../../librerias/chart/FusionCharts.php";
	include "../../librerias/chart/Functions.php";	
	
	$fecha_hoy = date("Y-m-d");
	
$_SESSION["comple_filtro"]="";


	$congelados = $_POST["congelados"];
	$_SESSION["ses_congelados"] = $congelados;	
	$area_usuaria = $_POST["area_usuaria"];
	$id_usuaria="in (";
	$ultimo=count($area_usuaria);
	$ultimo--;
	$id_usuaria_pasa="0";
	for ($i=0;$i<count($area_usuaria);$i++){
		if($i!=$ultimo){
			$id_usuaria.=$area_usuaria[$i].",";
			$id_usuaria_pasa.=$area_usuaria[$i]."_";
		}else{
			$id_usuaria.=$area_usuaria[$i];
			$id_usuaria_pasa.=$area_usuaria[$i];
		}
	}
	$id_usuaria.=")";
	$_SESSION["ses_area_usuaria"] = $id_usuaria;
	$ano = $_POST["ano"];
	$_SESSION["ses_ano"] = $ano;
	$mes_requiere = $_POST["mes_requiere"];
	$_SESSION["mes_requiere"] = $mes_requiere;
	$mes_requiere2 = $_POST["mes_requiere2"];
	$_SESSION["mes_requiere2"] = $mes_requiere2;
	
	$bien_servicio = $_POST["bien_servicio"];
	$_SESSION["bien_servicio"] = $bien_servicio;
	$us_prof = $_POST["us_prof"];
	//$_SESSION["ses_us_prof"] = $us_prof;
	$id="in (";
	$ultimo=count($us_prof);
	$ultimo--;
	$id_prof_pasa="";
	$id_profesional2='0';
	for ($i=0;$i<count($us_prof);$i++){
		if($i!=$ultimo){
			$id.=$us_prof[$i].",";
			$id_profesional2.=$us_prof[$i]."_";
		}else{
			$id.=$us_prof[$i];
			$id_profesional2.=$us_prof[$i];
		}
	}
	$id.=")";
	$_SESSION["ses_us_prof"] = $id;
	$fecha_rep = $_POST["fecha_rep"];
	$_SESSION["fecha_rep"] = $fecha_rep;
	
	$fecha_rep = $_POST["fin_activos"];
	$_SESSION["fin_activos"] = $fecha_rep;
		
	
		$comple_sql=" where t1_tipo_proceso_id <> 8 and de_historico is null and (tiempos_estandar is null or tiempos_estandar =2)";
		
	if($_SESSION["ses_us_prof"] != 'in ()' and $_SESSION["ses_us_prof"] != 'in (0)'){
		$comple_sql.= " and id_us_profesional_asignado ".$_SESSION["ses_us_prof"];
		}
	if($_SESSION["ses_congelados"] == 2){
			$comple_sql.= " and (congelado is null or congelado = 2 or congelado = '')";
			}
	if($_SESSION["bien_servicio"] == 1){
			$comple_sql.= " and (t1_tipo_contratacion_id = 1)";
			}
	if($_SESSION["bien_servicio"] == 2){
			$comple_sql.= " and (t1_tipo_contratacion_id <> 1)";
			}
						
	if($_SESSION["ses_area_usuaria"] != 'in ()' and $_SESSION["ses_area_usuaria"] != 'in (0)'){
			$comple_sql.= " and t1_area_id ".$_SESSION["ses_area_usuaria"];
			}
			
	if($_SESSION["fin_activos"] == 1){
			$comple_sql.= " and estado < 20 ";
			}
	if($_SESSION["fin_activos"] == 2){
			$comple_sql.= " and (estado >= 20 and estado <= 32 and estado <> 31) and (solicitud_rechazada is null or solicitud_rechazada =2 or solicitud_rechazada =0) ";
			}
	if($_SESSION["fin_activos"] == 0){
			$comple_sql.= " and (estado not in (33,31)) ";
			}
			
	//echo $comple_sql;
			
	$ano_req = $_SESSION["ses_ano"];
	
	if($_SESSION["mes_requiere"] <> "0"){
			$ano_req = $_SESSION["ses_ano"]."-".$_SESSION["mes_requiere"];
			$comple_sql_meses =" and fecha_en_firme like '%".$ano_req."%'";
			}else{
				$comple_sql_meses =" and fecha_en_firme like '%".$ano_req."%'";
				}
	
	
	if($_SESSION["mes_requiere2"] <> "0"){
			$ano_req = $_SESSION["ses_ano"]."-".$_SESSION["mes_requiere"]."-01";
			$ano_req2 = $_SESSION["ses_ano"]."-".$_SESSION["mes_requiere2"]."-31";
			
			$comple_sql_meses=" and fecha_en_firme >= '".$ano_req."' and fecha_en_firme  <= '".$ano_req2."'";
			}		
		$comple_sql.=$comple_sql_meses;

		
		
	$decimal = "0";
	
	$fecha_hoy = date("Y-m-d");
	if(($fecha_rep > "2014-09-08" || $fecha_rep < $fecha_hoy) && $fecha_rep != "" && $nosirve == "para nada"){
			
			$comple_sql .= " and fecha = '" . $fecha_rep ."'";
			$version_2_indi_1 = "t_version_2_indi_1";
			$version_2_indi_nivel_aprobacion_max_aprobacion = "t_version_2_indi_nivel_aprobacion_max_aprobacion";
			$version_2_indi_estado_procesos = "t_version_2_indi_estado_procesos";
			$version_2_indi_soporte_1 = "t_version_2_indi_soporte_1";
			$version_2_indi_soporte_2 = "t_version_2_indi_soporte_2";
			$version_2_indi_soporte_3 = "t_version_2_indi_soporte_3";
			
		}else{
		
			$version_2_indi_1 = "version_2_indi_1";
			$version_2_indi_nivel_aprobacion_max_aprobacion = "version_2_indi_nivel_aprobacion_max_aprobacion";
			$version_2_indi_estado_procesos = "version_2_indi_estado_procesos";
			$version_2_indi_soporte_1 = "version_2_indi_soporte_1";
			$version_2_indi_soporte_2 = "version_2_indi_soporte_2";			
			$version_2_indi_soporte_3 = "version_2_indi_soporte_3";
			
			}

			
	$_SESSION["version_2_indi_1"] = $version_2_indi_1;
	$_SESSION["version_2_indi_nivel_aprobacion_max_aprobacion"] = $version_2_indi_nivel_aprobacion_max_aprobacion;
	$_SESSION["version_2_indi_estado_procesos"] = $version_2_indi_estado_procesos;
	$_SESSION["version_2_indi_soporte_1"] = $version_2_indi_soporte_1;
	$_SESSION["version_2_indi_soporte_2"] = $version_2_indi_soporte_2;
	$_SESSION["version_2_indi_soporte_3"] = $version_2_indi_soporte_3;
	$_SESSION["comple_filtro"] = $comple_sql;
	
		
	

	
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
      <td class="fondo_3" bgcolor="">1. N&uacute;mero de Procesos por Tipo de Negociaci&oacute;n - 
        
        
        
        </td>
      </tr>
    <tr>
      <td class="" bgcolor="" align="left"><a href="soporte_1.php" target="_blank"><img src="../../imagenes/mime/xlsx.gif" />Descargar el Soporte de Este Indicador</a></td>
    </tr>
    <tr>
      <td class="" bgcolor="" align="left"><img src="../../imagenes/botones/alerta.png" /> <font color="#005395"><strong>Con un Click en Cualquier Barra Podra Seguir Desendiendo en la Secuencia del Indicador</strong></font></td>
      </tr>
    <tr>
      <td align="center"><?

$strXML = "";
$strXML = "<chart caption=''  numberPrefix='' seriesNameInToolTip='0'  showValues='1' labelDisplay='rotate' slantLabels='0'  formatNumberScale='0'>";
$strXML .= "<set label = '' value ='' color = '' />";


//echo "select tipo_proceso, Count(*),t1_tipo_proceso_id from $version_2_indi_1 ".$_SESSION["comple_filtro"]." group by tipo_proceso,t1_tipo_proceso_id  order by tipo_proceso";
$selec_t_pro = query_db("select tipo_proceso, Count(*),t1_tipo_proceso_id from $version_2_indi_1 ".$_SESSION["comple_filtro"]." group by tipo_proceso,t1_tipo_proceso_id  order by tipo_proceso");
while($sel_pro = traer_fila_db($selec_t_pro)){
$strXML .= "<set label = '".$sel_pro[0]."' value ='".$sel_pro[1]."' color = '006633' link='F-genera_indica_profecinal-indicador_pecc_nivel_aprobacion.php?t1_tipo_proceso_id=".$sel_pro[2]."*".$sel_pro[1]."'/>";	
	$va_total = $sel_pro[1] +$va_total;
	}

$strXML .= "<set label = 'Total' value ='".$va_total."' color = '0033CC' link='F-genera_indica_profecinal-indicador_pecc_nivel_aprobacion.php?t1_tipo_proceso_id=0*$va_total'/>";

$strXML .= "<set label = '' value ='' color = '' />";
$strXML .= "</chart>";
echo renderChart("../../librerias/chart/Column3D.swf", "",$strXML, "indicador25885", 800, 500, false, false);

	?></td>
      </tr>
    </table></td>
</tr>
<tr>
  <td align="center">
  
  <iframe name="genera_indica_profecinal" id="genera_indica_profecinal" frameborder="0" width="100%" height="5200px"></iframe>
  
  </td>
</tr>
</table>
     
       

</body>
</html>

