<? include("../../librerias/lib/@include.php");
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
/*
$delete = query_db("truncate table t2_archivos_sap");
$delete = query_db("truncate table t2_archivos_sap_solped");
$delete = query_db("truncate table t2_archivos_sap_pedido");















*/


$cuantos=1;
//$dir="ftp/otro";//Local

/*-----------------*****************CONEXION CON ARCHIVOS FISICOS DE SAP*************************______________________________________*/
$dir="../../archivos_sap/";//servidor AVIOR
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
	if($archivo_explo_hora_ext[1]=="csv"){
	$fecha_job=$archivo_explo[2];
	$hora_job=$archivo_explo_hora_ext[0];
	$numero=$archivo_explo[1];
	if($archivo_explo[0] == "S"){
				$tipo_permiso_adj = 1;// es el permiso	
				$nombre_tipo="Solped";
		}
	if($archivo_explo[0] == "P"){
				$tipo_permiso_adj = 2;// es Adjudicacion
				$nombre_tipo="Pedido";
		}
		echo $archivo_explo[0];
		if($archivo_explo[0] == "E"){
				$nombre_tipo="Entrega";
		}
	echo " numero ".$numero." Tipo ".$nombre_tipo."<br />";
	if($tipo_permiso_adj <> 0){
		$sle_id = traer_fila_row(query_db("select id from t2_archivos_sap where numero = '".$numero."'"));
		$delete_numero_anteriores = query_db("delete from t2_archivos_sap where id = '".$sle_id[0]."'");
		$delete_solped = query_db("delete from t2_archivos_sap_solped where  id_archivo_sap = '".$sle_id[0]."'");
		$delete_pedido = query_db("delete from t2_archivos_sap_pedido where  id_archivo_sap = '".$sle_id[0]."'");
		$insert_archivo=" insert into t2_archivos_sap (numero, tipo, permiso_adj, nombre_archivo, fecha_job, hora_job) values ('".$numero."','".$nombre_tipo."', '".$tipo_permiso_adj."','".$archivo_completo."', '".$fecha_job."','".$hora_job."')";
	
	$sql_ex=query_db($insert_archivo.$trae_id_insrte);
	$id_archivo = id_insert($sql_ex);//

	
	
if($id_archivo <> 0){
	$fp = fopen ( $dir."/".$archivo_completo , "r" ); 
$fila=0;

while (( $data = fgetcsv ( $fp , 2048, ";",'"' )) !== false ) { // Mientras hay líneas que leer...
$estring_insert="";
$i = 0; 
if($fila>0){//si es mayor al titulo
$num_item=0;
foreach($data as $row) {

echo "Campo $i: $row fila $fila<br>\n"; // Muestra todos los campos de la fila actual 

if($tipo_permiso_adj ==1 and $i==23){
		$num_item = $row;
	}
if($tipo_permiso_adj ==2 and $i==20){
		$num_item = $row;
	}
	
	
if($i==3){
		$ind_libe=$row;
	}

	
if($i>0){
	$comma= ",";
	}else{
		$comma="";
		}	
$estring_insert = $estring_insert.$comma." '".$row."'";
$i++ ;

}
$insert_into="";

$explode_num_item = explode("-",$num_item);
$ano_item = $explode_num_item[0][1].$explode_num_item[0][2];
$consecutivo_item = $explode_num_item[1] * 1;

// ver el correo del lunes 14/04/2014 9:35 - para mirar los indicadores de liberacion

$accion = "N/A";

if($ind_libe=="X" or $ind_libe=="P"){
		$accion = "Liberar";
	}
elseif($ind_libe=="2" or $ind_libe=="A"){
		$accion = "Aprobar";
		}
	else{
			$accion = "N/A";
		
			}
	
	$sel_id_item = traer_fila_row(query_db("select id_item from t2_item_pecc where num2='".$ano_item."' and num3='".$consecutivo_item."'"));
		
if($sel_id_item[0]<=0){
	$accion = "N/A";
	}
		
//echo "select id_item from t2_item_pecc where num2='".$ano_item."' and num3='".$consecutivo_item."-".$i."'<br />";
	


if($sel_id_item[0]>0 and $consecutivo_item >0){

	$uda_archivo = query_db("update t2_archivos_sap set id_item='".$sel_id_item[0]."',num_item='".$num_item."',accion='".$accion."' where id = $id_archivo");
	
	
	if($tipo_permiso_adj ==1){
	$insert_into = "insert into t2_archivos_sap_solped (s_pedido, usuario, nombre_completo, ind_liberacion, fecha, hora, transaccion, ind_cambio, s_pedido_2, posicion, clase_doc, g_compras, texto, n_material, centro, almacen, gerente, g_articulo, cantidad, u_medida, fecha_s, organiz, v_total, mat_proveedor, den_grupo, moneda,id_archivo_sap) values (".$estring_insert.",$id_archivo)";
	
	}
if($tipo_permiso_adj ==2){
	$insert_into="insert into t2_archivos_sap_pedido (doc_compra, usuario, nombre_completo, ind_liberacion, fecha, hora, trans, ind_cambio, f_entrega, doc_compra2, f_compra, proveedor, posicion, cantidad, u_medida, n_material, texto, v_bruto, nombre_proveedor, nit, mat_proveedor, moneda,id_archivo_sap) values (".$estring_insert.",$id_archivo)";
	}
	
$insert_into_sq = query_db($insert_into);
	
	
}else{
	$delte = query_db("delete from t2_archivos_sap where id = ".$sle_id[0]);
	
	if($tipo_permiso_adj ==1){
	$delte = query_db("delete from t2_archivos_sap_solped where id_archivo_sap = ".$sle_id[0]);
	}
	if($tipo_permiso_adj ==2){
		$delte = query_db("delete from t2_archivos_sap_pedido where id_archivo_sap = ".$sle_id[0]);
	}
	}





}
$fila++;
echo "<br /><br />\n\n";

} //fin recorre archivo
}//si tiene definido permiso
fclose ( $fp ); 
	
	
	
	}//fin si es solped o pedido
	
	if($nombre_tipo=="Entrega"){
		
		$insert_archivo = "insert into t2_archivo_sap_entregas (nombre_archivo) values ('".$archivo_completo."')";
		$sql_ex1=query_db($insert_archivo.$trae_id_insrte);
		$id_archivo_e = id_insert($sql_ex1);//id archivo
		if($id_archivo_e <> 0){
	$fp = fopen ( $dir."/".$archivo_completo , "r" ); 
$fila=0;

while (( $data = fgetcsv ( $fp , 2048, ";",'"' )) !== false ) { // Mientras hay líneas que leer...
$estring_insert="";
$i = 0; 
echo "sadsad".$fila;
if($fila>0){//si es mayor al titulo
$num_item=0;
foreach($data as $row) {

echo "Campo $i: $row fila $fila<br>\n"; // Muestra todos los campos de la fila actual 

if($i==9){
		$num_proce = $row;
	}
	
	if($i>0){
	$comma= ",";
	}else{
		$comma="";
		}	
$estring_insert = $estring_insert.$comma." '".$row."'";


$i++ ;

}
	$insert_into = "insert into t2_archivo_sap_entregas_detalle (d_material, f_documento, n_material, centro, almacen, pos_compra, cantidad, indicador_entrega, clase_movimiento, n_pedido, moneda, fecha_rec_mat, id_archivo_entrega) values (".$estring_insert.",$id_archivo_e)";
	
	echo $insert_into."<br /><br /><br /><br />";

$insert_into_sq = query_db($insert_into);
	
	
}
$fila++;
echo "<br /><br />\n\n";
}


} //fin recorre archivo

fclose ( $fp ); 
		
	
		}
	
	//if($cuantos==5){exit;}
  $cuantos=$cuantos+1;
  
//  $copiar = copy($dir."/".$archivo_completo, "E:/sgpa_files/SAP/".$archivo_completo);

}elseif($archivo_explo_pdf[1]=="pdf"){
	$insert = query_db("insert into t2_archivo_sap_pdf (nombre_archivo, numero_proceso) values ('".$archivo_completo."', '".$archivo_explo[0]."')");
	$copiar = copy($dir."/".$archivo_completo, "E:/sgpa_files/attfiles/SAP/PDF/".$archivo_completo);
	}
else{
	//$copiar = copy($dir."/".$archivo_completo, "E:/sgpa_files/SAP/OTROS/".$archivo_completo);
	}
	
	  $elimina = unlink($dir."/".$archivo_completo);
	  
  echo "<br />
<br />
";


//lo pasa a otra carpeta


}//fin while
  
closedir($directorio); 

//actualiza el item en la entrega


$sel_entreg = query_db("select t1.id, t2.n_pedido, t2.indicador_entrega from t2_archivo_sap_entregas as t1, t2_archivo_sap_entregas_detalle as t2 where t1.id = t2.id_archivo_entrega and t1.id_item is null and t2.n_pedido <> ''");

while($s_pdf_sin_item=traer_fila_db($sel_entreg)){
	
	$tipo_entrega = "Parcial";
	if($s_pdf_sin_item[2]== 'X'){
		$tipo_entrega = "Total";
		}
	$sel_item_de_sap = traer_fila_row(query_db("select id_item from t2_archivos_sap where numero = '".$s_pdf_sin_item[1]."'"));
	$update = query_db("update t2_archivo_sap_entregas set id_item = ".$sel_item_de_sap[0].", tipo_entrega='".$tipo_entrega."' where id=".$s_pdf_sin_item[0]);
}

//actualiza el item en la entrega

//actualiza los PDF id de item

$sel_pdf_sin_item = query_db("select id, numero_proceso from t2_archivo_sap_pdf where id_item is null");
while($s_pdf_sin_item=traer_fila_db($sel_pdf_sin_item)){
	$sel_item_de_sap = traer_fila_row(query_db("select id_item from t2_archivos_sap where numero = '".$s_pdf_sin_item[1]."'"));
	$update = query_db("update t2_archivo_sap_pdf set id_item = ".$sel_item_de_sap[0]." where id=".$s_pdf_sin_item[0]);
	
	}

//actualiza los PDF id de item

/*-----------------*****************CONEXION CON ARCHIVOS FISICOS DE SAP*************************______________________________________*/

$sql_ap = "select id_item, estado, tipo, accion, num_item, informacion_cargada, num3, fecha_job, indi_liberacion,t1_tipo_proceso_id, usuario from vista_pendientes_SAP where indi_liberacion in ('A', '2') AND USUARIO LIKE '%E%'  group by estado, tipo, accion, num_item, informacion_cargada, num3, fecha_job, indi_liberacion,id_item,t1_tipo_proceso_id, usuario";


$sele_item_aprobados = query_db($sql_ap);

while($sel_ap = traer_fila_db($sele_item_aprobados)){
	
	echo "<br /><br /> id: $sel_ap[0] numero: ".$sel_ap[4]." --";
	//echo "<br /><br />".$sel_ap[4];
	$tipo_adj_permiso=0;
	if($sel_ap[2]=="Solped"){$tipo_adj_permiso=1;}
	if($sel_ap[2]=="Pedido" or $sel_ap[9] == 8){$tipo_adj_permiso=2;}// or $sel_ap[9] == 8 quiere decir que si es OT el tipo de la firma es adjudicacion
	$sel_secu = query_db("select * from t2_agl_secuencia_solicitud where id_item_pecc = ".$sel_ap[0]." and id_rol in (9,20,35, 45, 43) and estado = 1 and tipo_adj_permiso=".$tipo_adj_permiso);
	while($sel_s = traer_fila_db($sel_secu)){
		
		$sel_secu_si_jefe_area = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$sel_ap[0]." and id_rol in (9) and estado = 1 and tipo_adj_permiso=".$tipo_adj_permiso));		
		$sel_secu_si_viceprecidente = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$sel_ap[0]." and id_rol in (20) and estado = 1 and tipo_adj_permiso=".$tipo_adj_permiso));	
		$sel_secu_si_director = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$sel_ap[0]." and id_rol in (43) and estado = 1 and tipo_adj_permiso=".$tipo_adj_permiso));		
		$entra_accion = "NO";		
		if(($sel_s[2] == 20 or $sel_s[2] == 43)){$entra_accion = "SI";} // si es el vicepresindente o director entra de una por que es el ultimo aprobador
		if($sel_s[2] == 9 and $sel_secu_si_viceprecidente[0]==0 and $sel_secu_si_director[0]==0){$entra_accion = "SI";}// si es jefe de area y no tiene vicepresidente entra
		if(($sel_s[2] == 35 or $sel_s[2] == 45) and $sel_secu_si_viceprecidente[0]==0 and $sel_secu_si_jefe_area[0]==0 and $sel_secu_si_director[0]==0){$entra_accion = "SI";}//si es superintendente y no tienen jefe ni vicepresidente 		
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
						
					$sel_id_usaurio_aprobacion = traer_fila_row(query_db("select us_id from t1_us_usuarios where codigo_sap = '".$sel_ap[10]."'"));
					
					
						$insert_aprobacion = "insert into $pi16 (id_secuencia_solicitud, id_us,fecha, aprobado,observacion) values (".$sel_secuencia[0].",".$sel_id_usaurio_aprobacion[0].", '$fecha', ".$accion_aprueba.",'".$observa."')";
						$sql_ex=query_db($insert_aprobacion.$trae_id_insrte);
						$id_ingreso_firma_adj = id_insert($sql_ex);
						
						if($id_ingreso_firma_adj >0 and $id_ingreso_firma_adj != "" ){//si creo la firma siga el proceso
						
											
	$hora_log = date("G:i:s");
							
							if($accion_aprueba == 1){
							$insert = "insert into tseg8_log (id_tipo_log, id_tipo_log_sub_ventana, id_proceso, estado_actual_proceso, estado_resultado, id_us, fecha, hora_seg) values (15, 41,$id_item_pecc, 16, 32, ".$sel_id_usaurio_aprobacion[0].", '".$fecha."', '".$hora_log."')";
	
		$sql_ex=query_db($insert.$trae_id_insrte);
	  $id_log = id_insert($sql_ex);
	  
	  $insert = query_db("insert into tseg9_log_detalle (id_log, campo_imprime, detalle, tabla_id, orden) values ($id_log, 'Usuario que Firmo', '$sel_id_usaurio_aprobacion[0]', 't1_us_usuarios', 1)");
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

									if($sel_item[16]== "B" and ($estado_item == 0 or $estado_item == '')){
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
			if($tipo_adj_permiso==1 and $sel_ap[1] == 7){
				/**1111111111111111111111111111111111111111111111111111111111111111111111*/
				echo "Ingresa la firma del permiso";
	$id_item_pecc = $sel_ap[0];
	$id_rol_aprueba = $sel_s[2];
	$accion_aprueba = 1;
	$observa = "Aprobado en SAP";
	

	$sel_secuencia = traer_fila_row(query_db("select * from $pi14 where id_rol=".$id_rol_aprueba." and id_item_pecc=".$id_item_pecc." and tipo_adj_permiso =1 and estado = 1"));

	$sel_id_usaurio_aprobacion = traer_fila_row(query_db("select us_id from t1_us_usuarios where codigo_sap = '".$sel_ap[10]."'"));
	$insert_aprobacion = "insert into $pi16 (id_secuencia_solicitud, id_us,fecha, aprobado,observacion) values (".$sel_secuencia[0].",".$sel_id_usaurio_aprobacion[0].", '$fecha', ".$accion_aprueba.",'".$observa."')";
//$insert = "insert into $pi16 (id_secuencia_solicitud, id_us,fecha, aprobado,observacion) values (".$sel_secuencia[0].",".$sel_usuario_que_firma[2].", '$fecha', ".$accion_aprueba.",'".$observa."')";
	$sql_ex=query_db($insert_aprobacion.$trae_id_insrte);
	$id_ingreso_firma_adj = id_insert($sql_ex);
	
	if($id_ingreso_firma_adj >0 and $id_ingreso_firma_adj != "" ){//si creo la firma siga el proceso
	
	
	
	

		if($accion_aprueba == 1){
			
				$hora_log = date("G:i:s");
							
							
				
				
				$insert = "insert into tseg8_log (id_tipo_log, id_tipo_log_sub_ventana, id_proceso, estado_actual_proceso, estado_resultado, id_us, fecha, hora_seg) values (6, 34,$id_item_pecc, 7, 7, ".$sel_id_usaurio_aprobacion[0].", '".$fecha."', '".$hora_log."')";
	
		$sql_ex=query_db($insert.$trae_id_insrte);
	  $id_log = id_insert($sql_ex);
	  
	  $insert = query_db("insert into tseg9_log_detalle (id_log, campo_imprime, detalle, tabla_id, orden) values ($id_log, 'Usuario que Firmo', '$sel_id_usaurio_aprobacion[0]', 't1_us_usuarios', 1)");
	  $insert = query_db("insert into tseg9_log_detalle (id_log, campo_imprime, detalle, tabla_id, orden) values ($id_log, '$Observacion', '$observa ', '', 2)");
	  
	  
	  
	  
				
			$sel_todas_las_secuencias = query_db("select * from $pi14 where id_item_pecc =".$id_item_pecc." and tipo_adj_permiso = 1 and id_rol not in (8,15, 10, 11)  and estado =1");
			$acabo_firmas="SI";
		while($sel_sucun = traer_fila_db($sel_todas_las_secuencias)){
			$sele_aprobar = traer_fila_row(query_db("select count(*) from $pi16 where id_secuencia_solicitud = ".$sel_sucun[0]." and aprobado = 1"));
			if($sele_aprobar[0] == 0){
				$acabo_firmas="NO";
				echo $acabo_firmas;
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
				
		$select_usu = query_db("insert into $pi17 (id_item, t2_nivel_servicio_actividad_id, id_usua, fecha_real, dias, estado,observacion, hora) values ($id_item_pecc, 7, ".$sel_id_usaurio_aprobacion[0].", '".$fecha."', $dias,1,'$observa','$hora_log')");
		
				$sel_estado = traer_fila_row(query_db("select min(actividad_estado_id) from $vpeec3 where id_item=".$id_item_pecc." and actividad_estado_id > 7"));
				$estado_item = $sel_estado[0];
				

				
				if($estado_item==10){
					$estado_item=11;
							$select_usu = query_db("insert into $pi17 (id_item, t2_nivel_servicio_actividad_id, id_usua, fecha_real, dias, estado,observacion, hora) values ($id_item_pecc, 10, 18463, '".$fecha."', 0,1,'Gestion Automatica por el Sistema','$hora_log')");

					}
		
		echo "update $pi2 set estado=".$estado_item." where id_item=".$id_item_pecc;
				$upda_item = query_db("update $pi2 set estado=".$estado_item." where id_item=".$id_item_pecc);
				
		}
				
		}
		
	
}else{//si crea la firma sigue con el proceso
						echo "<strong><font color='#FF0000' > No creo la firma por que el usuario no coincide - $insert_aprobacion</font></strong>";
						$alerta = "No cerrar pantalla";
						}
				/*1111111111111111111111111111111111111111111111111111111111111111111111111111111111111*/
				
				
				}
	}//si entra segun el rol y que no tenga los otros
		}
	
	
	
	}


?>
<script>
function CloseWin(){
window.open('','_parent','');
window.close(); 
}
CloseWin()
</script>