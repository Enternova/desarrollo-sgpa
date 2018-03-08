<? include("../../librerias/lib/@session.php");
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	
	
	
	$explode = explode("----,",$_GET["usuario_permiso"]);
	$id_usuario = $explode[1];
	$explode2 = explode("----,",$_GET["proveedores_busca"]);
	$contratista = $explode2[1];
	
	
	
	if($id_usuario > 0){
		$sq_comple.=" and gerente = ".$id_usuario;
		}
	if($contratista > 0){
		$sq_comple.=" and id_contratista = ".$contratista;
		}
		

	if($_GET["vigentes_finalizados"]== 1){
		$sq_comple.=" and vigencia_mes >= '".date("Y-m-d")."'";
		}
	if($_GET["vigentes_finalizados"]== 2){
		$sq_comple.=" and vigencia_mes < '".date("Y-m-d")."'";
		}
	if($_GET["bus_area"] > 0){
		$sq_comple.=" and t1_area_id = ".$_GET["bus_area"];
		}
	if($_GET["profesional_cyc"] > 0){
		$sq_comple.=" and id_us_profesional_asignado = ".$_GET["profesional_cyc"];
		}
	

		$id_us_session_get = $_GET["id_us_session_get"];
		
		$numero1_pecc = arreglo_recibe_variables($_GET["numero1_pecc"]);
		$numero2_pecc = arreglo_recibe_variables($_GET["numero2_pecc"]);
		$numero3_pecc = arreglo_recibe_variables($_GET["numero3_pecc"]);
		$n_contrato_ano = arreglo_recibe_variables($_GET["n_contrato_ano"]);
		$n_contrato = arreglo_recibe_variables($_GET["n_contrato"]);		
		$numero3_pecc = $numero3_pecc *1;
		$n_contrato = $n_contrato *1;
		
		$comple_sql = "";
		
		if($numero1_pecc != 0){
			$comple_sql.=" and num1 like '%".$numero1_pecc."%'";
			}
		if($numero2_pecc != 0){
			$comple_sql.=" and num2 like '%".$numero2_pecc."%'";
			}
		if($numero3_pecc != 0){
			$comple_sql.=" and num3 = '".$numero3_pecc."'";
			}
			
		
				if($n_contrato != ""){
			$comple_sql.=" and consecutivo = '".$n_contrato."'";
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
			$comple_sql.=" and creacion_sistema like '%".$n_contrato_ano."%'";
			}
			
		
	?>


<head>
<title>Documento sin t&iacute;tulo</title>


<style type="text/css">
.titulo1 {	font-size:24px;
	color:#135798;
}
.titulo2 {	font-size:16px;
}
.titulo3 {
	font-size:20px;
	background-color:#135798;
	color:#FFF;
		
}

</style>

<body>
<table width="100%" border="0" class="tabla_lista_resultados">
  <tr  >
    <td width="15%" align="center" class="fondo_3">Aprobacion SGPA</td>
    <td width="15%" align="center" class="fondo_3">Numero del Contrato</td>
    <td width="17%" align="center" class="fondo_3">Contratista</td>
    <td width="21%" align="center" class="fondo_3">Gerente de la Solicitud</td>
    <td width="16%" align="center" class="fondo_3">Gerente del Contrato</td>
    <td width="16%" align="center" class="fondo_3">&Aacute;rea</td>
  </tr>
  <?

$cont = 0;
$query_reporte = "select * from vista_reporte_movimiento_contratos where id_item > 0 ".$comple_sql.$sq_comple." order by id_item desc";
	$sel_contratos_marco = query_db($query_reporte);

		while($sel_contra = traer_fila_db($sel_contratos_marco)){
			
			
	$id_item_pecc = $sel_contra[0];
	$id_contrato = $sel_contra[1];



		  
					  $numero_contrato1 = "C";
					$separa_fecha_crea = explode("-",$sel_contra[7]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contra[6];
					$numero_contrato4 = $sel_contra[8];
					
					
		if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
			
	?>
  <tr style="cursor:pointer" class="<?=$clase?> " onClick="window.ifra_re.location.href='../aplicaciones/reportes/reporte_movimiento_contratos_excel.php?id_contrato=<?=$sel_contra[1]?>'">
    
    
    <td align="center" class="<?=$clase?>"><?=numero_item_pecc($sel_contra[2],$sel_contra[3],$sel_contra[4])?></td>
    
    <td align="center" class="<?=$clase?>"><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contra[1])?>
    </td>
    <td align="center" class="<?=$clase?>"><?=$sel_contra[12]?></td>
    <td align="center" class="<?=$clase?>"><?=$sel_contra[10]?></td>
    <td align="center" class="<?=$clase?>"><?=$sel_contra[11]?></td>
    <td align="center" class="<?=$clase?>"><?=$sel_contra[13]?></td>
  </tr>
  <?
		 
	}			
   ?>
</table>
<iframe id="ifra_re" name="ifra_re" width="100%" height="500" frameborder="0" scrolling="auto"></iframe>
</body>
</html>
