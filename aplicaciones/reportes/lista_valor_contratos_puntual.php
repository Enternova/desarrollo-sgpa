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
		$sq_comple.=" and especialista = ".$_GET["profesional_cyc"];
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
    <td width="7%" rowspan="2" align="center" class="fondo_3">Aprobaci&oacute;n SGPA</td>
    <td width="7%" rowspan="2" align="center" class="fondo_3">N&uacute;mero del Contrato</td>
    <td width="10%" rowspan="2" align="center" class="fondo_3">Contratista</td>
    <td width="10%" rowspan="2" align="center" class="fondo_3">Gerente de Contrato</td>
    <td width="9%" rowspan="2" align="center" class="fondo_3">Profesional de C&amp;C</td>
    <td width="17%" rowspan="2" align="center" class="fondo_3">Gestor de Abastecimiento</td>
    <td colspan="2" align="center" class="fondo_3">Aprobaciones en el SGPA</td>
    <td colspan="2" align="center" class="fondo_3">Valor en el M&oacute;dulo de Contratos</td>
  </tr>
  <tr  >
    <td width="10%" align="center" class="fondo_3">USD</td>
    <td width="10%" align="center" class="fondo_3">COP</td>
    <td width="9%" align="center" class="fondo_3">USD</td>
    <td width="11%" align="center" class="fondo_3">COP</td>
  </tr>
  <?

$cont = 0;
 $query_reporte = "select num1, num2, num3, consecutivo, creacion_sistema, apellido, id, razon_social, gerente_contrato, profesional, gerente, case when(usd_otrosi is null) then SUM(valor_usd) else SUM(valor_usd + usd_otrosi) end as usd, case when(cop_otrosi is null) then SUM(valor_cop) else SUM(valor_cop + cop_otrosi) end as cop, manual_usd_en_contrato, manual_cop_en_contrato from v_reporte_valor_contrato_puntual where id > 0 ".$comple_sql.$sq_comple." group by num1, num2, num3, consecutivo, creacion_sistema, apellido, id, razon_social, gerente_contrato, profesional, gerente, manual_usd_en_contrato, manual_cop_en_contrato, usd_otrosi, cop_otrosi order by id desc";
 /*if($_SESSION["id_us_session"]==32){
 	echo $query_reporte;
 }*/
	$sel_contratos_marco = query_db($query_reporte);

		while($sel_contra = traer_fila_db($sel_contratos_marco)){
			
			/*SACA QUIEN ES GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
$sel_quien_es_gestor = traer_fila_row(query_db("select gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$sel_contra[10]));
/*SACA QUIEN ES GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
			
			$sel_valor_final = traer_fila_row(query_db("select SUM(valor_usd), SUM(valor_cop) from v_validacion_final_contrato_puntual where id_contrato=".$sel_contra[6]));

	$id_item_pecc = $sel_contra[0];
	$id_contrato = $sel_contra[1];



		  
					  $numero_contrato1 = "C";
					$separa_fecha_crea = explode("-",$sel_contra[4]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contra[3];
					$numero_contrato4 = $sel_contra[5];
					
					
		if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
			
	?>
  <tr style="cursor:pointer" class="<?=$clase?>">
    
    
    <td align="center" class="<?=$clase?>"><?=numero_item_pecc($sel_contra[0],$sel_contra[1],$sel_contra[2])?></td>
    
    <td align="center" class="<?=$clase?>"><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_contra[1])?>
    </td>
    <td align="center" class="<?=$clase?>"><?=$sel_contra[7]?></td>
    <td align="center" class="<?=$clase?>"><?=$sel_contra[8]?></td>
    <td align="center" class="<?=$clase?>"><?=$sel_contra[9]?></td>
    <td align="center" class="<?=$clase?>"><?=traer_nombre_muestra($sel_quien_es_gestor[0], $g1,"nombre_administrador","us_id")?></td>
    
    <td align="center" class="<?=$clase?>"><?=number_format($sel_valor_final[0],0)?></td>
    <td align="center" class="<?=$clase?>"><?=number_format($sel_valor_final[1],0)?></td>
    <td align="center" class="<?=$clase?>"><?=number_format($sel_contra[13],0)?></td>
    <td align="center" class="<?=$clase?>"><?=number_format($sel_contra[14],0)?></td>
  </tr>
  <?
		 
	}			
   ?>
</table>
<table width="100%" border="1">
  <tr>
    <td width="0" height="0" align="center"><input type="button" name="xx" value="Exportar reporte a Excel" class="boton_buscar"  onclick="window.ifra_re.location.href='../aplicaciones/reportes/lista_valor_contratos_puntual_excel.php?numero1_pecc='+document.getElementById('numero1_pecc').value+'&numero2_pecc='+document.getElementById('numero2_pecc').value+'&numero3_pecc='+document.getElementById('numero3_pecc').value+'&n_contrato_ano='+document.getElementById('n_contrato_ano').value+'&n_contrato='+document.getElementById('n_contrato').value+'&id_us_session_get=<?=$_SESSION["id_us_session"]?>&usuario_permiso='+document.getElementById('usuario_permiso').value+'&profesional_cyc='+document.getElementById('profesional_cyc').value+'&bus_area='+document.getElementById('bus_area').value+'&proveedores_busca='+document.getElementById('proveedores_busca').value+'&vigentes_finalizados='+document.getElementById('vigentes_finalizados').value"/></td>
  </tr>
</table>
<iframe id="ifra_re" name="ifra_re" width="100%" height="500" frameborder="0" scrolling="auto"></iframe>
</body>
</html>
