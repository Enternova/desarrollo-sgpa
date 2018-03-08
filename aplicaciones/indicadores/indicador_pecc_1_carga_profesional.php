<? include("../../librerias/lib/@session.php"); 
$fecha_hoy = date("Y-m-d");
/*
header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Reporte de Carga de Procesos por Profesional ".$fecha_hoy.".xls");
	*/
	
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
	$comple_meses_mysql=""; //$ano
	$_SESSION["ses_ano"] = $ano;
	$mes_requiere = $_POST["mes_requiere"];
	$_SESSION["mes_requiere"] = $mes_requiere;
	$mes_requiere2 = $_POST["mes_requiere2"];
	$_SESSION["mes_requiere2"] = $mes_requiere2;
	
	$bien_servicio = $_POST["bien_servicio"];
	$_SESSION["bien_servicio"] = $bien_servicio;
	$us_prof = $_POST["us_prof"];
	//$_SESSION["ses_us_prof"] = $us_prof;
	$id_profesional2='0';
	$id="in (";
	$ultimo=count($us_prof);
	$ultimo--;
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
		
	
		$comple_sql=" where de_historico is null and (tiempos_estandar is null or tiempos_estandar =2)";

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
			$comple_meses_mysql.=" and t1_area_id ".$_SESSION["ses_area_usuaria"];
			$comple_sql.= " and t1_area_id ".$_SESSION["ses_area_usuaria"];
	}
			
			
$comple_sql.= " and fecha_en_firme != '' and fecha_en_firme is not null and (estado < 20) and id_us_profesional_asignado >0 ";
			
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
<script type="text/javascript" src="../../librerias/ajax/ajax_01.js"></script>
<style type="text/css" media="screen">
	.filas_sin_resultados td{
		border: 2px solid #DBFBDC !important;
	}
</style>
</head>

<body>

<table width="100%" border="0" class="tabla_lista_resultados">
<tr>
  <td align="center"><table width="100%" border="0" class="tabla_blanca">
    <tr>
      <td class="" bgcolor="" align="right"><A href="javascript:document.location.target='_blank';document.location.href='../../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle_excel.php?id_profesional=<?=$id_profesional2?>&fecha_filtra=<?=$_SESSION['ses_ano'];?>&tp_proceso=0&tp_contratacion=0&t1_area_id=0&consulta_sondeo=<?=$_POST['consulta_sondeo'];?>'">Generar Reporte en EXCEL <img src="../../imagenes/mime/xlsx.gif"  /></A></td>
    </tr>
    <tr>
      <td class="" bgcolor="" align="left">
        <table width="100%" border="0">
        <tr class="fondo_3">
          <td width="30%" align="center">Profesional de C&amp;C</td>
          <td width="9%" align="center">Tipo</td>
          <td width="16%" align="center">Tipo de Proceso</td>
          <td width="3%" align="center">Enero</td>
          <td width="4%" align="center">Febrero</td>
          <td width="3%" align="center">Marzo</td>
          <td width="2%" align="center">Abril</td>
          <td width="3%" align="center">Mayo</td>
          <td width="3%" align="center">Junio</td>
          <td width="2%" align="center">Julio</td>
          <td width="3%" align="center">Agosto</td>
          <td width="5%" align="center">Septiembre</td>
          <td width="4%" align="center">Octubre</td>
          <td width="5%" align="center">Noviembre</td>
          <td width="5%" align="center">Diciembre</td>
          <td width="3%" align="center">Total</td>
          </tr>
        <?
		$id_profesional =0;
		//echo "select id_us_profesional_asignado, profesional, num1, tipo_proceso, t1_tipo_proceso_id from version_2_indi_1 ".$_SESSION["comple_filtro"]." group by id_us_profesional_asignado, profesional, num1, tipo_proceso, t1_tipo_proceso_id order by profesional ";
			//echo $comple_meses_mysql;
 $sel_sql = query_db("select id_us_profesional_asignado, profesional, num1, tipo_proceso, t1_tipo_proceso_id from version_2_indi_1 ".$_SESSION["comple_filtro"]." group by id_us_profesional_asignado, profesional, num1, tipo_proceso, t1_tipo_proceso_id order by profesional ");
 global $host_mys,$usr_mys, $pwd_mys, $dbbase_mys;
 $link = mysql_connect($host_mys,$usr_mys, $pwd_mys); 
 mysql_select_db($dbbase_mys, $link);
	$bandera_profesional=0;
 $bandera_urna=0;
 $cont=0;
 while($se_pro = traer_fila_db($sel_sql)){//INICIO DEL WHILE
 	if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
	 $muestra_sub_total = "NO";
	 if($id_profesional == 0 or $id_profesional <> $se_pro[0]){
		 
			$muestra_sub_total = "SI";
			if($id_profesional == 0){ $muestra_sub_total = "NO";}
			
			if($muestra_sub_total == "SI"){//muetsra sub total
				

				echo ' <tr>
          <td  class="fondo_3_borde_superior" colspan="3"></td>
		  
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_1.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes1.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_2.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes2.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_3.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes3.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_4.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes4.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_5.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes5.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_6.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes6.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_7.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes7.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_8.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes8.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_9.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes9.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_10.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes10.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_11.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes11.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_12.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes12.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional.'</td>
        </tr>
		 <tr>
          <td colspan="2">&nbsp;</td>
          <td  align="right">&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
        </tr>';
		$total_profesional_mes1 =  0;
			$total_profesional_mes2 =  0;
			$total_profesional_mes3 =  0;
			$total_profesional_mes4 =  0;
			$total_profesional_mes5 =  0;
			$total_profesional_mes6 =  0;
			$total_profesional_mes7 =  0;
			$total_profesional_mes8 =  0;
			$total_profesional_mes9 =  0;
			$total_profesional_mes10 =  0;
			$total_profesional_mes11 = 0;
			$total_profesional_mes12 =  0;
			$total_profesional = 0;
			}
			$id_profesional=$se_pro[0];
			
		}

	 $sel_cantidad_1 = traer_fila_row(query_db("select count(*)  from version_2_indi_1 ".$_SESSION["comple_filtro"]." and id_us_profesional_asignado = ".$se_pro[0]." and num1 = '".$se_pro[2]."' and t1_tipo_proceso_id = '".$se_pro[4]."' and DATEPART(m,fecha_en_firme) = 1  "));
	 
	 $sel_cantidad_2 = traer_fila_row(query_db("select count(*)  from version_2_indi_1 ".$_SESSION["comple_filtro"]." and id_us_profesional_asignado = ".$se_pro[0]." and num1 = '".$se_pro[2]."' and t1_tipo_proceso_id = '".$se_pro[4]."' and DATEPART(m,fecha_en_firme) = 2  "));
	 
	 $sel_cantidad_3 = traer_fila_row(query_db("select count(*)   from version_2_indi_1 ".$_SESSION["comple_filtro"]." and id_us_profesional_asignado = ".$se_pro[0]." and num1 = '".$se_pro[2]."' and t1_tipo_proceso_id = '".$se_pro[4]."' and DATEPART(m,fecha_en_firme) = 3  "));
	 
	 $sel_cantidad_4 = traer_fila_row(query_db("select count(*)  from version_2_indi_1 ".$_SESSION["comple_filtro"]." and id_us_profesional_asignado = ".$se_pro[0]." and num1 = '".$se_pro[2]."' and t1_tipo_proceso_id = '".$se_pro[4]."' and DATEPART(m,fecha_en_firme) = 4  "));
	 
	 $sel_cantidad_5 = traer_fila_row(query_db("select count(*) from version_2_indi_1 ".$_SESSION["comple_filtro"]." and id_us_profesional_asignado = ".$se_pro[0]." and num1 = '".$se_pro[2]."' and t1_tipo_proceso_id = '".$se_pro[4]."' and DATEPART(m,fecha_en_firme) = 5  "));
	 
	 $sel_cantidad_6 = traer_fila_row(query_db("select count(*) from version_2_indi_1 ".$_SESSION["comple_filtro"]." and id_us_profesional_asignado = ".$se_pro[0]." and num1 = '".$se_pro[2]."' and t1_tipo_proceso_id = '".$se_pro[4]."' and DATEPART(m,fecha_en_firme) = 6  "));
	 
	 $sel_cantidad_7 = traer_fila_row(query_db("select count(*) from version_2_indi_1 ".$_SESSION["comple_filtro"]." and id_us_profesional_asignado = ".$se_pro[0]." and num1 = '".$se_pro[2]."' and t1_tipo_proceso_id = '".$se_pro[4]."' and DATEPART(m,fecha_en_firme) = 7  "));
	 
	 $sel_cantidad_8 = traer_fila_row(query_db("select count(*)  from version_2_indi_1 ".$_SESSION["comple_filtro"]." and id_us_profesional_asignado = ".$se_pro[0]." and num1 = '".$se_pro[2]."' and t1_tipo_proceso_id = '".$se_pro[4]."' and DATEPART(m,fecha_en_firme) = 8  "));
	 
	 $sel_cantidad_9 = traer_fila_row(query_db("select count(*)  from version_2_indi_1 ".$_SESSION["comple_filtro"]." and id_us_profesional_asignado = ".$se_pro[0]." and num1 = '".$se_pro[2]."' and t1_tipo_proceso_id = '".$se_pro[4]."' and DATEPART(m,fecha_en_firme) = 9  "));
	 
	 $sel_cantidad_10 = traer_fila_row(query_db("select count(*)  from version_2_indi_1 ".$_SESSION["comple_filtro"]." and id_us_profesional_asignado = ".$se_pro[0]." and num1 = '".$se_pro[2]."' and t1_tipo_proceso_id = '".$se_pro[4]."' and DATEPART(m,fecha_en_firme) = 10  "));
	 
	 $sel_cantidad_11 = traer_fila_row(query_db("select count(*)  from version_2_indi_1 ".$_SESSION["comple_filtro"]." and id_us_profesional_asignado = ".$se_pro[0]." and num1 = '".$se_pro[2]."' and t1_tipo_proceso_id = '".$se_pro[4]."' and DATEPART(m,fecha_en_firme) = 11  "));
	 
	 $sel_cantidad_12 = traer_fila_row(query_db("select count(*) from version_2_indi_1 ".$_SESSION["comple_filtro"]." and id_us_profesional_asignado = ".$se_pro[0]." and num1 = '".$se_pro[2]."' and t1_tipo_proceso_id = '".$se_pro[4]."' and DATEPART(m,fecha_en_firme) = 12  "));

$totel_profesional_tipo_proceso = $sel_cantidad_1[0]+$sel_cantidad_2[0]+$sel_cantidad_3[0]+$sel_cantidad_4[0]+$sel_cantidad_5[0]+$sel_cantidad_6[0]+$sel_cantidad_7[0]+$sel_cantidad_8[0]+$sel_cantidad_9[0]+$sel_cantidad_10[0]+$sel_cantidad_11[0]+$sel_cantidad_12[0];



$total_profesional_mes1 =  $total_profesional_mes1 + $sel_cantidad_1[0];
$total_profesional_mes2 =  $total_profesional_mes2 + $sel_cantidad_2[0];
$total_profesional_mes3 =  $total_profesional_mes3 + $sel_cantidad_3[0];
$total_profesional_mes4 =  $total_profesional_mes4 + $sel_cantidad_4[0];
$total_profesional_mes5 =  $total_profesional_mes5 + $sel_cantidad_5[0];
$total_profesional_mes6 =  $total_profesional_mes6 + $sel_cantidad_6[0];
$total_profesional_mes7 =  $total_profesional_mes7 + $sel_cantidad_7[0];
$total_profesional_mes8 =  $total_profesional_mes8 + $sel_cantidad_8[0];
$total_profesional_mes9 =  $total_profesional_mes9 + $sel_cantidad_9[0];
$total_profesional_mes10 =  $total_profesional_mes10 + $sel_cantidad_10[0];
$total_profesional_mes11 =  $total_profesional_mes11 + $sel_cantidad_11[0];
$total_profesional_mes12 =  $total_profesional_mes12 + $sel_cantidad_12[0];

$link_total_profesional_mes_1 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-01&tp_proceso=0&tp_contratacion=0&consulta_sondeo=".$_POST['consulta_sondeo'];
$link_total_profesional_mes_2 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-02&tp_proceso=0&tp_contratacion=0&consulta_sondeo=".$_POST['consulta_sondeo'];
$link_total_profesional_mes_3 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-03&tp_proceso=0&tp_contratacion=0&consulta_sondeo=".$_POST['consulta_sondeo'];
$link_total_profesional_mes_4 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-04&tp_proceso=0&tp_contratacion=0&consulta_sondeo=".$_POST['consulta_sondeo'];
$link_total_profesional_mes_5 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-05&tp_proceso=0&tp_contratacion=0&consulta_sondeo=".$_POST['consulta_sondeo'];
$link_total_profesional_mes_6 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-06&tp_proceso=0&tp_contratacion=0&consulta_sondeo=".$_POST['consulta_sondeo'];
$link_total_profesional_mes_7 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-07&tp_proceso=0&tp_contratacion=0&consulta_sondeo=".$_POST['consulta_sondeo'];
$link_total_profesional_mes_8 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-08&tp_proceso=0&tp_contratacion=0&consulta_sondeo=".$_POST['consulta_sondeo'];
$link_total_profesional_mes_9 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-09&tp_proceso=0&tp_contratacion=0&consulta_sondeo=".$_POST['consulta_sondeo'];
$link_total_profesional_mes_10 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-10&tp_proceso=0&tp_contratacion=0&consulta_sondeo=".$_POST['consulta_sondeo'];
$link_total_profesional_mes_11 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-11&tp_proceso=0&tp_contratacion=0&consulta_sondeo=".$_POST['consulta_sondeo'];
$link_total_profesional_mes_12 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-12&tp_proceso=0&tp_contratacion=0&consulta_sondeo=".$_POST['consulta_sondeo'];
$link_total_profesional = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."&tp_proceso=0&tp_contratacion=0&consulta_sondeo=".$_POST['consulta_sondeo'];
		


$total_profesional = $total_profesional_mes1+$total_profesional_mes2+$total_profesional_mes3+$total_profesional_mes4+$total_profesional_mes5+$total_profesional_mes6+$total_profesional_mes7+$total_profesional_mes8+$total_profesional_mes9+$total_profesional_mes10+$total_profesional_mes11+$total_profesional_mes12;




$total_general_mes1 =  $total_general_mes1 + $sel_cantidad_1[0];
$total_general_mes2 =  $total_general_mes2 + $sel_cantidad_2[0];
$total_general_mes3 =  $total_general_mes3 + $sel_cantidad_3[0];
$total_general_mes4 =  $total_general_mes4 + $sel_cantidad_4[0];
$total_general_mes5 =  $total_general_mes5 + $sel_cantidad_5[0];
$total_general_mes6 =  $total_general_mes6 + $sel_cantidad_6[0];
$total_general_mes7 =  $total_general_mes7 + $sel_cantidad_7[0];
$total_general_mes8 =  $total_general_mes8 + $sel_cantidad_8[0];
$total_general_mes9 =  $total_general_mes9 + $sel_cantidad_9[0];
$total_general_mes10 =  $total_general_mes10 + $sel_cantidad_10[0];
$total_general_mes11 =  $total_general_mes11 + $sel_cantidad_11[0];
$total_general_mes12 =  $total_general_mes12 + $sel_cantidad_12[0];
$total_general = $totel_profesional_tipo_proceso + $total_general;


		  
		  $link_mes_1 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-01&tp_proceso=".$se_pro[4]."&tp_contratacion=".$se_pro[2];
		  $link_mes_2 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-02&tp_proceso=".$se_pro[4]."&tp_contratacion=".$se_pro[2];
		  $link_mes_3 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-03&tp_proceso=".$se_pro[4]."&tp_contratacion=".$se_pro[2];
		  $link_mes_4 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-04&tp_proceso=".$se_pro[4]."&tp_contratacion=".$se_pro[2];
		  $link_mes_5 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-05&tp_proceso=".$se_pro[4]."&tp_contratacion=".$se_pro[2];
		  $link_mes_6 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-06&tp_proceso=".$se_pro[4]."&tp_contratacion=".$se_pro[2];
		  $link_mes_7 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-07&tp_proceso=".$se_pro[4]."&tp_contratacion=".$se_pro[2];
		  $link_mes_8 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-08&tp_proceso=".$se_pro[4]."&tp_contratacion=".$se_pro[2];
		  $link_mes_9 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-09&tp_proceso=".$se_pro[4]."&tp_contratacion=".$se_pro[2];
		  $link_mes_10 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-10&tp_proceso=".$se_pro[4]."&tp_contratacion=".$se_pro[2];
		  $link_mes_11 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-11&tp_proceso=".$se_pro[4]."&tp_contratacion=".$se_pro[2];
		  $link_mes_12 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-12&tp_proceso=".$se_pro[4]."&tp_contratacion=".$se_pro[2];	  
		  $link_mes_total = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."&tp_proceso=".$se_pro[4]."&tp_contratacion=".$se_pro[2];
	?>
        <tr class="<?=$clase?>">
          <td><?=$se_pro[1]?></td>
          <td><? if($se_pro[2] == "S") echo "Servicios";
		  if($se_pro[2] == "B") echo "Bienes";
		  if($se_pro[2] == "SM") echo "Servicios";?></td>
          <td><?=$se_pro[3]?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_1?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_1[0]>0) echo $sel_cantidad_1[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_2?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_2[0]>0) echo $sel_cantidad_2[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_3?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_3[0]>0) echo $sel_cantidad_3[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_4?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_4[0]>0) echo $sel_cantidad_4[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_5?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_5[0]>0) echo $sel_cantidad_5[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_6?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_6[0]>0) echo $sel_cantidad_6[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_7?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_7[0]>0) echo $sel_cantidad_7[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_8?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_8[0]>0) echo $sel_cantidad_8[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_9?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_9[0]>0) echo $sel_cantidad_9[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_10?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_10[0]>0) echo $sel_cantidad_10[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_11?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_11[0]>0) echo $sel_cantidad_11[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_12?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_12[0]>0) echo $sel_cantidad_12[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_total?>","div_carga_busca_sol")' style="cursor:pointer"><?=$totel_profesional_tipo_proceso?></td>
          </tr>
        
        <?
	if($_POST['consulta_sondeo']==1){//si se consulta el sondeo
	if($bandera_urna==0){//bandera de la urna
		
	$bandera_urna=1; $bandera_profesional=$se_pro[0];
 /*************** ANTES DEL SUB TOTAL SE HACE LA CONSULTA A LA URNA **************/
	 //PARA BUSCAR EN LA URNA VIRTUAL
	 $query_tecnico = mysql_query("SELECT COUNT(*) FROM pro1_proceso WHERE tp1_id in (4, 9, 11) and tp2_id=30 and month(fecha_creacion) = 01 and us_id_contacto=".$se_pro[0]." and year(fecha_creacion)=".$ano.$comple_meses_mysql);
	 $sel_cantidad_1=mysql_fetch_row($query_tecnico);
	 
	  //PARA BUSCAR EN LA URNA VIRTUAL
	 $query_tecnico = mysql_query("SELECT COUNT(*) FROM pro1_proceso WHERE tp1_id in (4, 9, 11) and tp2_id=30 and month(fecha_creacion) = 02 and us_id_contacto=".$se_pro[0]." and year(fecha_creacion)=".$ano.$comple_meses_mysql);
	 $sel_cantidad_2=mysql_fetch_row($query_tecnico);
	 
	 //PARA BUSCAR EN LA URNA VIRTUAL
	 $query_tecnico = mysql_query("SELECT COUNT(*) FROM pro1_proceso WHERE tp1_id in (4, 9, 11) and tp2_id=30 and month(fecha_creacion) = 03 and us_id_contacto=".$se_pro[0]." and year(fecha_creacion)=".$ano.$comple_meses_mysql);
	 $sel_cantidad_3=mysql_fetch_row($query_tecnico);
	 
	 //PARA BUSCAR EN LA URNA VIRTUAL
	 $query_tecnico = mysql_query("SELECT COUNT(*) FROM pro1_proceso WHERE tp1_id in (4, 9, 11) and tp2_id=30 and month(fecha_creacion) = 04 and us_id_contacto=".$se_pro[0]." and year(fecha_creacion)=".$ano.$comple_meses_mysql);
	 $sel_cantidad_4=mysql_fetch_row($query_tecnico);
	 
	 //PARA BUSCAR EN LA URNA VIRTUAL
	 $query_tecnico = mysql_query("SELECT COUNT(*) FROM pro1_proceso WHERE tp1_id in (4, 9, 11) and tp2_id=30 and month(fecha_creacion) = 05 and us_id_contacto=".$se_pro[0]." and year(fecha_creacion)=".$ano.$comple_meses_mysql);
	 $sel_cantidad_5=mysql_fetch_row($query_tecnico);
	 
	 //PARA BUSCAR EN LA URNA VIRTUAL
	 $query_tecnico = mysql_query("SELECT COUNT(*) FROM pro1_proceso WHERE tp1_id in (4, 9, 11) and tp2_id=30 and month(fecha_creacion) = 06 and us_id_contacto=".$se_pro[0]." and year(fecha_creacion)=".$ano.$comple_meses_mysql);
	 $sel_cantidad_6=mysql_fetch_row($query_tecnico);
	 
	 //PARA BUSCAR EN LA URNA VIRTUAL
	 $query_tecnico = mysql_query("SELECT COUNT(*) FROM pro1_proceso WHERE tp1_id in (4, 9, 11) and tp2_id=30 and month(fecha_creacion) = 07 and us_id_contacto=".$se_pro[0]." and year(fecha_creacion)=".$ano.$comple_meses_mysql);
	 $sel_cantidad_7=mysql_fetch_row($query_tecnico);
	 
	 //PARA BUSCAR EN LA URNA VIRTUAL
	 $query_tecnico = mysql_query("SELECT COUNT(*) FROM pro1_proceso WHERE tp1_id in (4, 9, 11) and tp2_id=30 and month(fecha_creacion) = 08 and us_id_contacto=".$se_pro[0]." and year(fecha_creacion)=".$ano.$comple_meses_mysql);
	 $sel_cantidad_8=mysql_fetch_row($query_tecnico);
	 
	 //PARA BUSCAR EN LA URNA VIRTUAL
	 $query_tecnico = mysql_query("SELECT COUNT(*) FROM pro1_proceso WHERE tp1_id in (4, 9, 11) and tp2_id=30 and month(fecha_creacion) = 09 and us_id_contacto=".$se_pro[0]." and year(fecha_creacion)=".$ano.$comple_meses_mysql);
	 $sel_cantidad_9=mysql_fetch_row($query_tecnico);
	 
	 //PARA BUSCAR EN LA URNA VIRTUAL
	 $query_tecnico = mysql_query("SELECT COUNT(*) FROM pro1_proceso WHERE tp1_id in (4, 9, 11) and tp2_id=30 and month(fecha_creacion) = 10 and us_id_contacto=".$se_pro[0]." and year(fecha_creacion)=".$ano.$comple_meses_mysql);
	 $sel_cantidad_10=mysql_fetch_row($query_tecnico);
	 
	 //PARA BUSCAR EN LA URNA VIRTUAL
	 $query_tecnico = mysql_query("SELECT COUNT(*) FROM pro1_proceso WHERE tp1_id in (4, 9, 11) and tp2_id=30 and month(fecha_creacion) = 11 and us_id_contacto=".$se_pro[0]." and year(fecha_creacion)=".$ano.$comple_meses_mysql);
	 $sel_cantidad_11=mysql_fetch_row($query_tecnico);
	 
	 //PARA BUSCAR EN LA URNA VIRTUAL
	 $query_tecnico = mysql_query("SELECT COUNT(*) FROM pro1_proceso WHERE tp1_id in (4, 9, 11) and tp2_id=30 and month(fecha_creacion) = 12 and us_id_contacto=".$se_pro[0]." and year(fecha_creacion)=".$ano.$comple_meses_mysql);
	 $sel_cantidad_12=mysql_fetch_row($query_tecnico);
$totel_profesional_tipo_proceso=0;
$totel_profesional_tipo_proceso = $sel_cantidad_1[0]+$sel_cantidad_2[0]+$sel_cantidad_3[0]+$sel_cantidad_4[0]+$sel_cantidad_5[0]+$sel_cantidad_6[0]+$sel_cantidad_7[0]+$sel_cantidad_8[0]+$sel_cantidad_9[0]+$sel_cantidad_10[0]+$sel_cantidad_11[0]+$sel_cantidad_12[0];



$total_profesional_mes1 =  $total_profesional_mes1 + $sel_cantidad_1[0];
$total_profesional_mes2 =  $total_profesional_mes2 + $sel_cantidad_2[0];
$total_profesional_mes3 =  $total_profesional_mes3 + $sel_cantidad_3[0];
$total_profesional_mes4 =  $total_profesional_mes4 + $sel_cantidad_4[0];
$total_profesional_mes5 =  $total_profesional_mes5 + $sel_cantidad_5[0];
$total_profesional_mes6 =  $total_profesional_mes6 + $sel_cantidad_6[0];
$total_profesional_mes7 =  $total_profesional_mes7 + $sel_cantidad_7[0];
$total_profesional_mes8 =  $total_profesional_mes8 + $sel_cantidad_8[0];
$total_profesional_mes9 =  $total_profesional_mes9 + $sel_cantidad_9[0];
$total_profesional_mes10 =  $total_profesional_mes10 + $sel_cantidad_10[0];
$total_profesional_mes11 =  $total_profesional_mes11 + $sel_cantidad_11[0];
$total_profesional_mes12 =  $total_profesional_mes12 + $sel_cantidad_12[0];
		


$total_profesional = $total_profesional_mes1+$total_profesional_mes2+$total_profesional_mes3+$total_profesional_mes4+$total_profesional_mes5+$total_profesional_mes6+$total_profesional_mes7+$total_profesional_mes8+$total_profesional_mes9+$total_profesional_mes10+$total_profesional_mes11+$total_profesional_mes12;




$total_general_mes1 =  $total_general_mes1 + $sel_cantidad_1[0];
$total_general_mes2 =  $total_general_mes2 + $sel_cantidad_2[0];
$total_general_mes3 =  $total_general_mes3 + $sel_cantidad_3[0];
$total_general_mes4 =  $total_general_mes4 + $sel_cantidad_4[0];
$total_general_mes5 =  $total_general_mes5 + $sel_cantidad_5[0];
$total_general_mes6 =  $total_general_mes6 + $sel_cantidad_6[0];
$total_general_mes7 =  $total_general_mes7 + $sel_cantidad_7[0];
$total_general_mes8 =  $total_general_mes8 + $sel_cantidad_8[0];
$total_general_mes9 =  $total_general_mes9 + $sel_cantidad_9[0];
$total_general_mes10 =  $total_general_mes10 + $sel_cantidad_10[0];
$total_general_mes11 =  $total_general_mes11 + $sel_cantidad_11[0];
$total_general_mes12 =  $total_general_mes12 + $sel_cantidad_12[0];
$total_general = $totel_profesional_tipo_proceso + $total_general;


		  
		  $link_mes_1 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-01&tp_proceso=sondeo&tp_contratacion=0";
		  $link_mes_2 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-02&tp_proceso=sondeo&tp_contratacion=0";
		  $link_mes_3 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-03&tp_proceso=sondeo&tp_contratacion=0";
		  $link_mes_4 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-04&tp_proceso=sondeo&tp_contratacion=0";
		  $link_mes_5 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-05&tp_proceso=sondeo&tp_contratacion=0";
		  $link_mes_6 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-06&tp_proceso=sondeo&tp_contratacion=0";
		  $link_mes_7 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-07&tp_proceso=sondeo&tp_contratacion=0";
		  $link_mes_8 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-08&tp_proceso=sondeo&tp_contratacion=0";
		  $link_mes_9 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-09&tp_proceso=sondeo&tp_contratacion=0";
		  $link_mes_10 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-10&tp_proceso=sondeo&tp_contratacion=".$se_pro[2];
		  $link_mes_11 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-11&tp_proceso=sondeo&tp_contratacion=0";
		  $link_mes_12 = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."-12&tp_proceso=sondeo&tp_contratacion=".$se_pro[2];	  
		  $link_mes_total = "?id_profesional=".$se_pro[0]."&fecha_filtra=".$_SESSION["ses_ano"]."&tp_proceso=sondeo&tp_contratacion=0";
		if($totel_profesional_tipo_proceso!=0){//$comple_meses_mysql
			if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
	?>
        <tr class="<?=$clase?>">
          <td><?=$se_pro[1]?></td>
          <td></td>
          <td>Sondeo de Mercado</td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_1?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_1[0]>0) echo $sel_cantidad_1[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_2?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_2[0]>0) echo $sel_cantidad_2[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_3?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_3[0]>0) echo $sel_cantidad_3[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_4?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_4[0]>0) echo $sel_cantidad_4[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_5?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_5[0]>0) echo $sel_cantidad_5[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_6?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_6[0]>0) echo $sel_cantidad_6[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_7?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_7[0]>0) echo $sel_cantidad_7[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_8?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_8[0]>0) echo $sel_cantidad_8[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_9?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_9[0]>0) echo $sel_cantidad_9[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_10?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_10[0]>0) echo $sel_cantidad_10[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_11?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_11[0]>0) echo $sel_cantidad_11[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_12?>","div_carga_busca_sol")' style="cursor:pointer"><? if($sel_cantidad_12[0]>0) echo $sel_cantidad_12[0];?></td>
          <td align="center" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php<?=$link_mes_total?>","div_carga_busca_sol")' style="cursor:pointer"><?=$totel_profesional_tipo_proceso?></td>
          </tr>
        <?
		}
/*************** ANTES DEL SUB TOTAL SE HACE LA CONSULTA A LA URNA **************/       
	}else{
		if($bandera_profesional!=$se_pro[0]){
			$bandera_urna=0;
		}
	}

	}//fin si se consulta el sondeo
 }//FIN DEL WHILE
 //imprime el sub total del ultimo profesiaonl
echo ' <tr>
          <td  class="fondo_3_borde_superior" colspan="3"></td>
		  
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_1.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes1.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_2.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes2.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_3.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes3.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_4.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes4.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_5.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes5.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_6.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes6.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_7.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes7.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_8.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes8.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_9.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes9.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_10.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes10.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_11.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes11.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional_mes_12.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional_mes12.'</td>
          <td class="fondo_3" align="center" onclick=window.parent.document.getElementById("div_carga_busca_sol").style.display="block";window.parent.ajax_carga("../aplicaciones/indicadores/indicador_pecc_1_carga_profesional_detalle.php'.$link_total_profesional.'","div_carga_busca_sol") style="cursor:pointer">'.$total_profesional.'</td>
        </tr>';
			
/*PARA TRAER DESDE MYSQL 
	 echo "<br><br>SELECT * FROM pro1_proceso WHERE tp1_id in (4, 9, 11) and tp2_id=30  and ".$comple_meses_mysql;
	 $query_tecnico = mysql_query("SELECT * FROM pro1_proceso WHERE tp1_id in (4, 9, 11) and tp2_id=30 us_id_contacto=");
	 $busca_tecnico=mysql_fetch_row($query_tecnico);*/
		?>
        <tr>
          <td></td>
          <td colspan="2">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
          <td align="center">&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
          <td class="fondo_3" align="right"><strong>Total General&nbsp;&nbsp;</strong></td>
          <td align="center" class="fondo_3"><?=$total_general_mes1?></td>
          <td align="center" class="fondo_3"><?=$total_general_mes2?></td>
          <td align="center" class="fondo_3"><?=$total_general_mes3?></td>
          <td align="center" class="fondo_3"><?=$total_general_mes4?></td>
          <td align="center" class="fondo_3"><?=$total_general_mes5?></td>
          <td align="center" class="fondo_3"><?=$total_general_mes6?></td>
          <td align="center" class="fondo_3"><?=$total_general_mes7?></td>
          <td align="center" class="fondo_3"><?=$total_general_mes8?></td>
          <td align="center" class="fondo_3"><?=$total_general_mes9?></td>
          <td align="center" class="fondo_3"><?=$total_general_mes10?></td>
          <td align="center" class="fondo_3"><?=$total_general_mes11?></td>
          <td align="center" class="fondo_3"><?=$total_general_mes12?></td>
          <td align="center" class="fondo_3"><?=$total_general?></td>
          </tr>
        <tr>
          <td colspan="2">&nbsp;</td>
          <td  align="right">&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
          <td align="center" >&nbsp;</td>
        </tr>
        </table></td>
    </tr>
    <tr>
      <td align="center">&nbsp;</td>
      </tr>
    </table></td>
</tr>
<tr>
  <td align="center">&nbsp;</td>
</tr>
</table>
     
      

</body>
</html>

