<? include("../../librerias/lib/@include.php");
?>
<table width="100%" border="1">
  <tr>
    <td>Contrato para comparar</td>
    <td>Año</td>
    <td>Valor USD Inicial</td>
    <td>Valor USD Otrosíes</td>
    <td>Valor COP Inicial</td>
    <td>Valor COP Otrosíes</td>
    <td>TRM</td>
    <td>Valor Total USD</td>
    <td>Valor Total COP</td>
    <td>Id contrato</td>
  </tr>
 <?
 
 $sel_contratos_puntuales = query_db("select id, consecutivo, creacion_sistema, apellido from t7_contratos_contrato where t1_tipo_documento_id = 1 and id IN (17, 20, 21, 78, 95, 108, 123, 127, 356, 153, 164, 180, 187, 213, 224, 548, 405, 516, 778, 821, 841, 847, 848, 852, 858, 866, 948, 955, 964, 972, 979,991, 992, 995, 1000, 1001, 1003, 1006, 1007, 1008, 1013, 1015, 1019, 1023, 1026, 1032, 1065, 1078, 1079, 1084, 1088, 1089, 1097, 1098, 1103, 1108, 1109,1113, 1114, 1115, 1130, 1135, 1154, 1156, 1160, 1162, 1164, 1165, 1166, 1169, 1170, 1192, 1193, 1200, 1204, 1205, 1206, 1208, 1209, 1210, 1211, 1215,1218, 1232, 1236, 1247, 1250, 1258, 1259, 1260, 1274, 1275, 1278, 1279, 1281, 1286, 1286, 1287, 1288, 1290, 1298, 1300, 1303, 1305, 1311, 1312, 1313,1317, 1320, 1323, 1325, 1326, 1328, 1334, 1335, 1336, 1342, 1343, 1344, 1345, 1346, 1347, 1349, 1350, 1353, 1354, 1356, 1357, 1358, 1359, 1360, 1364,1365, 1370, 1371, 1373, 1375, 1376, 1377, 1381, 1382, 1384, 1387, 1390, 1393, 1395, 1396, 1397, 1398, 1417, 1418, 1436, 6, 178, 541, 766, 880, 884, 894,941, 958, 1005, 1023, 1080, 1092, 1161, 1168, 1217, 1241, 1242, 1256, 1311, 1317, 1349, 1375, 1393, 1396, 1398, 1418, 1436, 369)");
 while($sel_contratos = traer_fila_db($sel_contratos_puntuales)){
 
 					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_contratos[2]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					
					$numero_contrato3 = $sel_contratos[1];
					$numero_contrato4 = $sel_contratos[3];
					
					$numero_contrato = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_contratos[0]);
					
					$numero_contrato_compara = str_replace(" ","",$numero_contrato);
					$numero_contrato_compara = str_replace("-","",$numero_contrato_compara);
					$numero_contrato_compara = str_replace("Servicios","",$numero_contrato_compara);
					$numero_contrato_compara = str_replace("Bienes","",$numero_contrato_compara);
					
		$sel_sum_valor_inicial_2013 = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from reporte_juan_david where id = ".$sel_contratos[0]." and ano = 2013"));
		$sel_sum_valor_otrosies_2013 = traer_fila_row(query_db("select sum(valor_usd_ots), sum(valor_cop_ots) from reporte_juan_david_otrosi where id_contrato = ".$sel_contratos[0]." and ano = 2013 AND (congelado IS NULL OR congelado = 2) AND (solicitud_rechazada IS NULL OR solicitud_rechazada = 0 OR solicitud_rechazada = 2)"));
				
		$sel_sum_valor_inicial_2014 = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from reporte_juan_david where id = ".$sel_contratos[0]." and ano = 2014"));
		$sel_sum_valor_otrosies_2014 = traer_fila_row(query_db("select sum(valor_usd_ots), sum(valor_cop_ots) from reporte_juan_david_otrosi where id_contrato = ".$sel_contratos[0]." and ano = 2014 AND (congelado IS NULL OR congelado = 2) AND (solicitud_rechazada IS NULL OR solicitud_rechazada = 0 OR solicitud_rechazada = 2)"));
		
		$sel_sum_valor_inicial_2015 = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from reporte_juan_david where id = ".$sel_contratos[0]." and ano = 2015"));
		$sel_sum_valor_otrosies_2015 = traer_fila_row(query_db("select sum(valor_usd_ots), sum(valor_cop_ots) from reporte_juan_david_otrosi where id_contrato = ".$sel_contratos[0]." and ano = 2015 AND (congelado IS NULL OR congelado = 2) AND (solicitud_rechazada IS NULL OR solicitud_rechazada = 0 OR solicitud_rechazada = 2)"));
		
		$sel_sum_valor_inicial_2016 = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from reporte_juan_david where id = ".$sel_contratos[0]." and ano = 2016"));
		$sel_sum_valor_otrosies_2016 = traer_fila_row(query_db("select sum(valor_usd_ots), sum(valor_cop_ots) from reporte_juan_david_otrosi where id_contrato = ".$sel_contratos[0]." and ano = 2016 AND (congelado IS NULL OR congelado = 2) AND (solicitud_rechazada IS NULL OR solicitud_rechazada = 0 OR solicitud_rechazada = 2)"));
		
		$sel_sum_valor_inicial_2017 = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from reporte_juan_david where id = ".$sel_contratos[0]." and ano = 2017"));
		$sel_sum_valor_otrosies_2017 = traer_fila_row(query_db("select sum(valor_usd_ots), sum(valor_cop_ots) from reporte_juan_david_otrosi where id_contrato = ".$sel_contratos[0]." and ano = 2017 AND (congelado IS NULL OR congelado = 2) AND (solicitud_rechazada IS NULL OR solicitud_rechazada = 0 OR solicitud_rechazada = 2)"));
		
		$sel_sum_valor_inicial_2018 = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from reporte_juan_david where id = ".$sel_contratos[0]." and ano = 2018"));
		$sel_sum_valor_otrosies_2018 = traer_fila_row(query_db("select sum(valor_usd_ots), sum(valor_cop_ots) from reporte_juan_david_otrosi where id_contrato = ".$sel_contratos[0]." and ano = 2018 AND (congelado IS NULL OR congelado = 2) AND (solicitud_rechazada IS NULL OR solicitud_rechazada = 0 OR solicitud_rechazada = 2)"));
		
		$sel_sum_valor_inicial_2019 = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from reporte_juan_david where id = ".$sel_contratos[0]." and ano = 2019"));
		$sel_sum_valor_otrosies_2019 = traer_fila_row(query_db("select sum(valor_usd_ots), sum(valor_cop_ots) from reporte_juan_david_otrosi where id_contrato = ".$sel_contratos[0]." and ano = 2019 AND (congelado IS NULL OR congelado = 2) AND (solicitud_rechazada IS NULL OR solicitud_rechazada = 0 OR solicitud_rechazada = 2)"));
		
		$sel_sum_valor_inicial_2020 = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from reporte_juan_david where id = ".$sel_contratos[0]." and ano = 2020"));
		$sel_sum_valor_otrosies_2020 = traer_fila_row(query_db("select sum(valor_usd_ots), sum(valor_cop_ots) from reporte_juan_david_otrosi where id_contrato = ".$sel_contratos[0]." and ano = 2020 AND (congelado IS NULL OR congelado = 2) AND (solicitud_rechazada IS NULL OR solicitud_rechazada = 0 OR solicitud_rechazada = 2)"));
		
		$sel_sum_valor_inicial_2021 = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop) from reporte_juan_david where id = ".$sel_contratos[0]." and ano = 2021"));
		$sel_sum_valor_otrosies_2021 = traer_fila_row(query_db("select sum(valor_usd_ots), sum(valor_cop_ots) from reporte_juan_david_otrosi where id_contrato = ".$sel_contratos[0]." and ano = 2021 AND (congelado IS NULL OR congelado = 2) AND (solicitud_rechazada IS NULL OR solicitud_rechazada = 0 OR solicitud_rechazada = 2)"));
 
 ?>
 <tr>
    <td><?=$numero_contrato_compara?></td>
    <td>2013</td>
    <td><?=number_format($sel_sum_valor_inicial_2013[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2013[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_inicial_2013[1],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2013[1],0,"","")?></td>
    <td>1780</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?=$sel_contratos[0];?></td>
  </tr>
  
 <tr>
    <td><?=$numero_contrato_compara?></td>
    <td>2014</td>
    <td><?=number_format($sel_sum_valor_inicial_2014[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2014[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_inicial_2014[1],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2014[1],0,"","")?></td>
    <td>1900</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?=$sel_contratos[0];?></td>
  </tr>
  
  <tr>
    <td><?=$numero_contrato_compara?></td>
    <td>2015</td>
    <td><?=number_format($sel_sum_valor_inicial_2015[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2015[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_inicial_2015[1],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2015[1],0,"","")?></td>
    <td>2300</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?=$sel_contratos[0];?></td>
  </tr>
  
  <tr>
    <td><?=$numero_contrato_compara?></td>
    <td>2016</td>
    <td><?=number_format($sel_sum_valor_inicial_2016[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2016[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_inicial_2016[1],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2016[1],0,"","")?></td>
    <td>3000</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?=$sel_contratos[0];?></td>
  </tr>
  
  <tr>
    <td><?=$numero_contrato_compara?></td>
    <td>2017</td>
    <td><?=number_format($sel_sum_valor_inicial_2017[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2017[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_inicial_2017[1],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2017[1],0,"","")?></td>
    <td>3000</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?=$sel_contratos[0];?></td>
  </tr>
  
  <tr>
    <td><?=$numero_contrato_compara?></td>
    <td>2018</td>
    <td><?=number_format($sel_sum_valor_inicial_2018[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2018[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_inicial_2018[1],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2018[1],0,"","")?></td>
    <td>3000</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?=$sel_contratos[0];?></td>
  </tr>
  
  <tr>
    <td><?=$numero_contrato_compara?></td>
    <td>2019</td>
    <td><?=number_format($sel_sum_valor_inicial_2019[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2019[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_inicial_2019[1],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2019[1],0,"","")?></td>
    <td>3000</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?=$sel_contratos[0];?></td>
  </tr>
  
  <tr>
    <td><?=$numero_contrato_compara?></td>
    <td>2020</td>
    <td><?=number_format($sel_sum_valor_inicial_2020[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2020[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_inicial_2020[1],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2020[1],0,"","")?></td>
    <td>3000</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?=$sel_contratos[0];?></td>
  </tr>
  
  <tr>
    <td><?=$numero_contrato_compara?></td>
    <td>2021</td>
    <td><?=number_format($sel_sum_valor_inicial_2021[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2021[0],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_inicial_2021[1],0,"","")?></td>
    <td><?=number_format($sel_sum_valor_otrosies_2021[1],0,"","")?></td>
    <td>3000</td>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td><?=$sel_contratos[0];?></td>
  </tr>
  <?
 }
  ?>
</table>
