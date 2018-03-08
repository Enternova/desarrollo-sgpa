<? include("../../librerias/lib/@include.php");
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER

$cuantos=1;
//$dir="ftp/otro";//Local
$dir="../../archivo_sap_ser_menor/";//Local

/*-----------------*****************CONEXION CON ARCHIVOS FISICOS DE SAP*************************______________________________________*/
//$dir="../../archivos_sap/";//servidor AVIOR
//$dir="../../archivo_sap_prueba/";//servidor AVIOR

$directorio=opendir($dir); 
while ($archivo = readdir($directorio)){
	//echo $archivo;
	$archivo_completo=$archivo; 
	$archivo_explo = explode("_",$archivo_completo);
	$archivo_explo_hora_ext = explode(".",$archivo_explo[3]);
	$archivo_explo_pdf = explode(".",$archivo_completo);
	$tipo_permiso_adj = 0;// es Adjudicacion
	$nombre_tipo="N/A";
	$id_archivo=0;
	$ind_libe="";
	//echo $archivo_completo."-sads11";
	if($archivo_explo_hora_ext[1]=="txt"){
	$fecha_job=$archivo_explo[2];
	$hora_job=$archivo_explo_hora_ext[0];
	$numero=$archivo_explo[1];
	if($archivo_explo[0] == "MS"){
				$tipo_permiso_adj = 2;// es el permiso	
				$nombre_tipo="Servicio Menor";
		}
		echo $archivo_explo[0];

	if($tipo_permiso_adj <> 0){

	$fp = fopen ( $dir."/".$archivo_completo , "r" ); 
$fila=0;

while (( $data = fgetcsv ( $fp , 1000, ";",'"' )) !== false ) { // Mientras hay líneas que leer...
$estring_insert="";
$i = 0; 
if($fila>0){//si es mayor al titulo
$num_item=0;
foreach($data as $row) {

echo "<br /><br /><br /><br /><strong>Nombre del Archivo:</strong> $archivo_completo <br /> Documento de Compra: ";
echo $doc_compra = $row[0].$row[1].$row[2].$row[3].$row[4].$row[5].$row[6].$row[7].$row[8].$row[9];
echo "<br />Fecha del documento: ";
echo $fecha_doc = $row[10].$row[11].$row[12].$row[13].$row[14].$row[15].$row[16].$row[17].$row[18].$row[19];
echo "<br />cla_doc: ";
echo $cla_doc = $row[20].$row[21].$row[22].$row[23];
echo "<br />nit_proveedor: ";
echo $nit_proveedor = $row[24].$row[25].$row[26].$row[27].$row[28].$row[29].$row[30].$row[31].$row[32].$row[33].$row[34].$row[35].$row[36].$row[37].$row[38].$row[39];

$nit_proveedor = str_replace(" ","",$nit_proveedor);
$nit_proveedor = str_replace(".","",$nit_proveedor);
$nit_proveedor = str_replace(",","",$nit_proveedor);
$nit_proveedor = str_replace("-","",$nit_proveedor);

echo "<br />nombre_proveedor: ";
echo $nombre_proveedor = $row[40].$row[41].$row[42].$row[43].$row[44].$row[45].$row[46].$row[47].$row[48].$row[49].$row[50].$row[51].$row[52].$row[53].$row[54].$row[55].$row[56].$row[57].$row[58].$row[59].$row[60].$row[61].$row[62].$row[63].$row[64].$row[65].$row[66].$row[67].$row[68].$row[69].$row[70].$row[71].$row[72].$row[73].$row[74];
echo "<br />descripcion_pedido: ";
echo $descripcion_pedido = $row[75].$row[76].$row[77].$row[78].$row[79].$row[80].$row[81].$row[82].$row[83].$row[84].$row[85].$row[86].$row[87].$row[88].$row[89].$row[90].$row[91].$row[92].$row[93].$row[94].$row[95].$row[96].$row[97].$row[98].$row[99].$row[100].$row[101].$row[102].$row[103].$row[104].$row[105].$row[106].$row[107].$row[108].$row[109].$row[110].$row[111].$row[112].$row[113].$row[114].$row[115].$row[116].$row[117].$row[118].$row[119].$row[120].$row[121].$row[122].$row[123].$row[124].$row[125].$row[126].$row[127].$row[128].$row[129].$row[130].$row[131].$row[132].$row[133].$row[134].$row[135].$row[136].$row[137].$row[138].$row[139].$row[140].$row[141].$row[142].$row[143].$row[144].$row[145].$row[146].$row[147].$row[148].$row[149].$row[150].$row[151].$row[152].$row[153].$row[154].$row[155].$row[156].$row[157].$row[158].$row[159].$row[160].$row[161].$row[162].$row[163].$row[164].$row[165].$row[166].$row[167].$row[168].$row[169].$row[170].$row[171].$row[172].$row[173].$row[174].$row[175].$row[176].$row[177].$row[178].$row[179].$row[180].$row[181].$row[182].$row[183].$row[184].$row[185].$row[186].$row[187].$row[188].$row[189].$row[190].$row[191].$row[192].$row[193].$row[194].$row[195].$row[196].$row[197].$row[198].$row[199].$row[200].$row[201].$row[202].$row[203].$row[204].$row[205].$row[206].$row[207].$row[208].$row[209].$row[210].$row[211].$row[212].$row[213].$row[214].$row[215].$row[216].$row[217].$row[218].$row[219].$row[220].$row[221].$row[222].$row[223].$row[224].$row[225].$row[226].$row[227].$row[228].$row[229].$row[230].$row[231].$row[232].$row[233].$row[234].$row[235].$row[236].$row[237].$row[238].$row[239].$row[240].$row[241].$row[242].$row[243].$row[244].$row[245].$row[246].$row[247].$row[248].$row[249].$row[250].$row[251].$row[252].$row[253].$row[254].$row[255].$row[256].$row[257].$row[258].$row[259].$row[260].$row[261].$row[262].$row[263].$row[264].$row[265].$row[266].$row[267].$row[268].$row[269].$row[270].$row[271].$row[272].$row[273].$row[274].$row[275].$row[276].$row[277].$row[278].$row[279].$row[280].$row[281].$row[282].$row[283].$row[284].$row[285].$row[286].$row[287].$row[288].$row[289].$row[290].$row[291].$row[292].$row[293].$row[294].$row[295].$row[296].$row[297].$row[298].$row[299].$row[300].$row[301].$row[302].$row[303].$row[304].$row[305].$row[306].$row[307].$row[308].$row[309].$row[310].$row[311].$row[312].$row[313].$row[314].$row[315].$row[316].$row[317].$row[318].$row[319].$row[320].$row[321].$row[322].$row[323].$row[324].$row[325].$row[326].$row[327].$row[328].$row[329];
echo "<br />gte_contrato: ";
echo $gte_contrato = $row[330].$row[331].$row[332].$row[333].$row[334].$row[335].$row[336].$row[337].$row[338].$row[339].$row[340].$row[341].$row[342].$row[343].$row[344].$row[345].$row[346].$row[347].$row[348].$row[349].$row[350].$row[351].$row[352].$row[353].$row[354].$row[355].$row[356].$row[357].$row[358].$row[359].$row[360].$row[361].$row[362].$row[363].$row[364].$row[365].$row[366].$row[367].$row[368].$row[369].$row[370].$row[371].$row[372].$row[373].$row[374].$row[375].$row[376].$row[377].$row[378].$row[379].$row[380].$row[381].$row[382].$row[383].$row[384].$row[385].$row[386].$row[387].$row[388].$row[389].$row[390].$row[391].$row[392].$row[393].$row[394].$row[395].$row[396].$row[397].$row[398].$row[299].$row[400].$row[401].$row[402].$row[403].$row[404].$row[405].$row[406].$row[407].$row[408].$row[409];
echo "<br />grupo_compra: ";
echo $grupo_compra = $row[410].$row[411].$row[412].$row[413].$row[414].$row[415].$row[416].$row[417].$row[418].$row[419].$row[420].$row[421].$row[422].$row[423].$row[424].$row[425].$row[426].$row[427];
echo "<br />org_compras: ";
echo $org_compras = $row[428].$row[429].$row[430].$row[431];
echo "<br />monped: ";
echo $monped = $row[432].$row[433].$row[434].$row[435].$row[436];
echo "<br />monto_pedido: ";
echo $monto_pedido = $row[437].$row[438].$row[439].$row[440].$row[441].$row[442].$row[443].$row[444].$row[445].$row[446].$row[447].$row[448].$row[449].$row[450].$row[451].$row[452].$row[453].$row[454];
echo "<br />valor_usd: ";
echo $valor_usd =    $row[455].$row[456].$row[457].$row[458].$row[459].$row[460].$row[461].$row[462].$row[463].$row[464].$row[465].$row[466].$row[467].$row[468].$row[469].$row[470].$row[471].$row[472];
echo "<br />trm_pedido: ";
echo $trm_pedido =   $row[473].$row[474].$row[475].$row[476].$row[477].$row[478].$row[479].$row[480].$row[481].$row[482].$row[483].$row[484].$row[485].$row[486].$row[487].$row[488].$row[489].$row[490];

$valor_usd = str_replace(",",".",$valor_usd);
$monto_pedido = str_replace(",",".",$monto_pedido);
$trm_pedido = str_replace(",",".",$trm_pedido);


echo "<br />mat_proveedor: ";
echo $mat_proveedor = $row[491].$row[492].$row[493].$row[494].$row[495].$row[496].$row[497].$row[498].$row[499].$row[500].$row[501].$row[502].$row[503].$row[504].$row[505].$row[506].$row[507].$row[508].$row[509].$row[510].$row[511].$row[512].$row[513].$row[514].$row[515].$row[516].$row[517].$row[518].$row[519].$row[520].$row[521].$row[522].$row[523].$row[524].$row[525];
echo "<br />usu_creador: ";
echo $usu_creador =  $row[526].$row[527].$row[528].$row[529].$row[530].$row[531].$row[532].$row[533].$row[534].$row[535].$row[536].$row[537];
echo "<br />nombre_us_creador: ";
echo $nombre_us_creador = $row[538].$row[539].$row[540].$row[541].$row[542].$row[543].$row[544].$row[545].$row[546].$row[547].$row[548].$row[549].$row[550].$row[551].$row[552].$row[553].$row[554].$row[555].$row[556].$row[557].$row[558].$row[559].$row[560].$row[561].$row[562].$row[563].$row[564].$row[565].$row[566].$row[567].$row[568].$row[569].$row[570].$row[571].$row[572].$row[573].$row[574].$row[575].$row[576].$row[577].$row[578].$row[579].$row[580].$row[581].$row[582].$row[583].$row[584].$row[585].$row[586].$row[587].$row[588].$row[589].$row[590].$row[591].$row[592].$row[593].$row[594].$row[595].$row[596].$row[597].$row[598].$row[599].$row[600].$row[601].$row[602].$row[603].$row[604].$row[605].$row[606].$row[607].$row[608].$row[609].$row[610].$row[611].$row[612].$row[613].$row[614].$row[615].$row[616].$row[617];
echo "<br />ind_liberacion: ";
echo $ind_liberacion = $row[618];
echo "<br />usu_aprobador: ";
echo $usu_aprobador = $row[619].$row[620].$row[621].$row[622].$row[623].$row[624].$row[625].$row[626].$row[627].$row[628].$row[629].$row[630];
echo "<br />nombre_usu_aprobador: ";
echo $nombre_usu_aprobador = $row[631].$row[632].$row[633].$row[634].$row[635].$row[636].$row[637].$row[638].$row[639].$row[640].$row[641].$row[642];
$i++ ;
}// acava de rrecorrer las columnas para este caso es solo una

if($cla_doc == "MNSS" and $ind_liberacion == "A"){// si cumple con los parametros inhabi9lita los anteriores y carga el nuevo
	$update = query_db("update t2_servicios_menores_sap set estado = 2 where doc_compra = ".$doc_compra);
	
	/*Busca el id del nit*/
	$sel_proveedor = traer_fila_row(query_db("select * from t1_proveedor where nit = '".$nit_proveedor."'"));
	/*FIN Busca el id del nit*/
	
	/*busca id item*/
	$explode_num_item = explode("-",$mat_proveedor);
	$ano_item = $explode_num_item[0][1].$explode_num_item[0][2];
	$consecutivo_item = $explode_num_item[1] * 1;
	$sel_id_item = traer_fila_row(query_db("select id_item from t2_item_pecc where num2='".$ano_item."' and num3='".$consecutivo_item."'"));
	if($sel_id_item[0] == ""){ 
		$id_item = 0;
		}else{
		$id_item = $sel_id_item[0];	
			}
	/* fin busca id item*/
	$insert = query_db("insert into t2_servicios_menores_sap (id_proveedor, id_item, nombre_archivo, doc_compra, fecha_doc, cla_doc, nit_proveedor, nombre_proveedor, descripcion_pedido, gte_contrato, grupo_compra, org_compras, monped, monto_pedido, valor_usd, trm_pedido, mat_proveedor, usu_creador, nombre_us_creador, ind_liberacion, usu_aprobador, nombre_usu_aprobador, estado) values (".$sel_proveedor[0].", ".$id_item.", '".$archivo_completo."' , '".$doc_compra."' , '".$fecha_doc."' , '".$cla_doc."' , '".$nit_proveedor."' , '".$nombre_proveedor."' , '".$descripcion_pedido."' , '".$gte_contrato."' , '".$grupo_compra."' , '".$org_compras."' , '".$monped."' , '".$monto_pedido."' , '".$valor_usd."' , '".$trm_pedido."' , '".$mat_proveedor."' , '".$usu_creador."' , '".$nombre_us_creador."' , '".$ind_liberacion."' , '".$usu_aprobador."' , '".$nombre_usu_aprobador."' , 1)");
	
	}

}
$fila++;
echo "<br /><br />\n\n";

} //fin recorre archivo

fclose ( $fp ); 
		
	}//fin si es SERVICOS MENORES

}// fin si es tipo de archivo texto	
  echo "<br />
<br />
";


	if($archivo_explo[0] == "TRM"){// SI ES DE LA trm
echo "<br /><br /><br /><br /><strong>Nombre del Archivo:</strong> $dir $archivo_completo <br />";
	$fp = fopen ( $dir."/".$archivo_completo , "r" ); 
$fila=0;

while (( $data = fgetcsv ( $fp , 1000, ";",'"' )) !== false ) { // Mientras hay líneas que leer...
$estring_insert="";
$i = 0; 

$entra_a_modificar = "NO";

foreach($data as $row) {

echo "Campo $i: $row fila $fila<br>\n"; // Muestra todos los campos de la fila actual 


if($row == "M"){
	$entra_a_modificar = "SI";
	}


if($i==1){
	$fecha_trm = $row;
}	
if($i==4){
	$valor_cop_trm = $row;
}	




$i++ ;

}

	if($entra_a_modificar == "SI"){
		
	$valor_cop_trm_explo = explode(",",$valor_cop_trm);
	$valor_cop_trm = $valor_cop_trm_explo[0].".".$valor_cop_trm_explo[1];
	$fecha_trm_explo = explode(".",$fecha_trm);
	$fecha_trm = $fecha_trm_explo[2]."-".$fecha_trm_explo[1]."-".$fecha_trm_explo[0];
	
	$insert_into = "insert into t1_trm_diaria (valor_trm_cop, fecha) values ('".$valor_cop_trm."','".$fecha_trm."')";	
	echo $insert_into."<br /><br /><br /><br />";
$insert_into_sq = query_db($insert_into);
	}

	
$fila++;
echo "<br /><br />\n\n";

} //fin recorre archivo

fclose ( $fp ); 
		
	}//fin si es TRM

}//fin while
  
closedir($directorio); 


/* -------------- ------------------ ------------------------- --------------Actualiza firmas -------------- ---------------- -------------------------- ------------------ ---------------*/
//id_item, estado, tipo, accion, num_item, informacion_cargada, num3, fecha_job, indi_liberacion,t1_tipo_proceso_id, usuario
$sql_ap = "select * from vista_pendientes_SAP_serv_menor";


$sele_item_aprobados = query_db($sql_ap);

while($sel_ap = traer_fila_db($sele_item_aprobados)){
	
	echo "<br /><br /> id: $sel_ap[0] numero: ".$sel_ap[6]." --";
	$tipo_adj_permiso = 2;// se quema en codigo por que para este tipo de proceso MnSS siempre es tipo de permiso o adjudicacion = 2
	$sel_secu = query_db("select * from t2_agl_secuencia_solicitud where id_item_pecc = ".$sel_ap[0]." and id_rol in (9,20,35, 45) and estado = 1 and tipo_adj_permiso=".$tipo_adj_permiso);
	while($sel_s = traer_fila_db($sel_secu)){
		
		$sel_secu_si_jefe_area = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$sel_ap[0]." and id_rol in (9) and estado = 1 and tipo_adj_permiso=".$tipo_adj_permiso));		
		$sel_secu_si_viceprecidente = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$sel_ap[0]." and id_rol in (20) and estado = 1 and tipo_adj_permiso=".$tipo_adj_permiso));		
		$entra_accion = "NO";		
		if($sel_s[2] == 20){$entra_accion = "SI";} // si es el vicepresindente entra de una por que es el ultimo aprobador
		if($sel_s[2] == 9 and $sel_secu_si_viceprecidente[0]==0){$entra_accion = "SI";}// si es jefe de area y no tiene vicepresidente entra
		if(($sel_s[2] == 35 or $sel_s[2] == 45) and $sel_secu_si_viceprecidente[0]==0 and $sel_secu_si_jefe_area[0]==0){$entra_accion = "SI";}//si es superintendente y no tienen jefe ni vicepresidente 		
		$sel_si_ya_tiene_aprobacion = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud_aprobacion where id_secuencia_solicitud = "&$sel_s[0]&" and aprobado = 1"));
		if($entra_accion == "SI" and $sel_si_ya_tiene_aprobacion[0]==0){//este if es para que entre solo una ves al rol definido
		
		
			$sel_usuario_que_firma = traer_fila_row(query_db("select * from t2_agl_secuencia_solicitud_usuario where id_secuencia_solicitud = ".$sel_s[0]));
			$sel_aprobacion = traer_fila_row(query_db("select * from t2_agl_secuencia_solicitud_aprobacion where id_secuencia_solicitud = ".$sel_s[0]." and aprobado = 1"));
			
			if($tipo_adj_permiso==2 and $sel_ap[1] == 16 ){
			if($sel_aprobacion[0]>0){// si ya esta aprobado finalice el proceso
//					$upda_item = query_db("update $pi2 set estado=32 where id_item=".$sel_ap[0]);
					echo "Verificar por que tiene la firma de sap y esta en firmas";
				}else{//crea la firma
					/**************************************************************************************************/
					echo "Ingresa la firma de la adjudicacion";
						$id_item_pecc = $sel_ap[0];
						$id_rol_aprueba = $sel_s[2];		
						$accion_aprueba = 1;
						$observa = "Aprobado en SAP";
						
					$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
						$sel_secuencia = traer_fila_row(query_db("select * from $pi14 where id_rol=".$id_rol_aprueba." and id_item_pecc=".$id_item_pecc." and tipo_adj_permiso =2 and estado = 1"));
						
									
					
						$insert_aprobacion = "insert into $pi16 (id_secuencia_solicitud, id_us,fecha, aprobado,observacion) values (".$sel_secuencia[0].",".$sel_ap[3].", '$fecha', ".$accion_aprueba.",'".$observa."')";
						$sql_ex=query_db($insert_aprobacion.$trae_id_insrte);
						$id_ingreso_firma_adj = id_insert($sql_ex);
						
						if($id_ingreso_firma_adj >0 and $id_ingreso_firma_adj != "" ){//si creo la firma siga el proceso
						
											
	$hora_log = date("G:i:s");
							
							if($accion_aprueba == 1){
							$insert = "insert into tseg8_log (id_tipo_log, id_tipo_log_sub_ventana, id_proceso, estado_actual_proceso, estado_resultado, id_us, fecha, hora_seg) values (15, 41,$id_item_pecc, 16, 32, ".$sel_ap[3].", '".$fecha."', '".$hora_log."')";
	
		$sql_ex=query_db($insert.$trae_id_insrte);
	  $id_log = id_insert($sql_ex);
	  
	  $insert = query_db("insert into tseg9_log_detalle (id_log, campo_imprime, detalle, tabla_id, orden) values ($id_log, 'Usuario que Firmo', '$sel_ap[3]', 't1_us_usuarios', 1)");
	  $insert = query_db("insert into tseg9_log_detalle (id_log, campo_imprime, detalle, tabla_id, orden) values ($id_log, '$Observacion', '$observa ', '', 2)");
	  

					
								$sel_todas_las_secuencias = query_db("select * from $pi14 where id_item_pecc =".$id_item_pecc." and tipo_adj_permiso = 2 and id_rol not in (8,15, 10, 11)  and estado =1");
								$acabo_firmas="SI";
							while($sel_sucun = traer_fila_db($sel_todas_las_secuencias)){
								$sele_aprobar = traer_fila_row(query_db("select count(*) from $pi16 where id_secuencia_solicitud = ".$sel_sucun[0]." and aprobado = 1"));
								if($sele_aprobar[0] == 0){
									$acabo_firmas="NO";
									}
							}
					
							if($acabo_firmas=="SI"){
								
							
							
				$sel_gestiones_max = traer_fila_row(query_db("select max(t2_gestion) from $pi17 where id_item = $id_item_pecc and estado = 1"));
			if($sel_gestiones_max[0] != ""){
			$sel_gestiones = traer_fila_row(query_db("select fecha_real from $pi17 where t2_gestion = ".$sel_gestiones_max[0]));			
			$fecha_ini = $sel_gestiones[0];
			$fecha_fin = $fecha;
			$dias = dias_habiles_entre_fechas($fecha_ini,$fecha_fin);
			}else{
				$dias = 0;
				}
				
				echo "<br /><br />";
				
							$select_usu = query_db("insert into $pi17 (id_item, t2_nivel_servicio_actividad_id, id_usua, fecha_real, dias, estado,observacion, hora) values ($id_item_pecc, 16, ".$sel_usuario_que_firma[2].", '".$fecha."', $dias,1,'$observa','$hora_log')");
							
								

				$sel_estado_adj = traer_fila_row(query_db("select min(actividad_estado_id) from $vpeec3 where id_item=".$id_item_pecc." and actividad_estado_id > 16"));
				$estado_item = $sel_estado_adj[0];

									if($estado_item == 0 or $estado_item == ''){
											$estado_item = 32;
										}
									

								$upda_item = query_db("update $pi2 set estado=".$estado_item." where id_item=".$id_item_pecc);
									
									
									
									
									
									
									
										
							}
									
							}
						}else{//si crea la firma sigue con el proceso
						echo "<strong><font color='#FF0000' > No creo la firma por que el usuario no coincide - $insert_aprobacion</font></strong>";
						$alerta = "No cerrar pantalla";
						}
					}//fin crea la firma
			}//si es adjudicacion

	}//si entra segun el rol y que no tenga los otros
		}
	
	
	
	}
/* ------------------- ------------------ ---------------------- --------------------------- ---------fin actualiza firmas ----------------- -------------------- --------------- -*/
?>

