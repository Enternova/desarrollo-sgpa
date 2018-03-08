<?
//error_reporting(E_ALL);  // Líneas para mostart errores
//ini_set('display_errors', '1');  // Líneas para mostart errores
//include("../../librerias/lib/@include.php");
function busca_contratos($id_gerente){//INICIO FUNCION
	global $co1, $g6, $g1, $pi2, $valer_3;
	$tabla='';
	$fecha_actual= date('Y-m-d');
	$time=date('G:i:s');
	//$dia_1= date('Y-m-01', strtotime($fecha_actual));
	$dias_15 = strtotime ( '+15 days' , strtotime ($fecha_actual) );
	$dias_15=date('Y-m-d',$dias_15);
	$un_mes =strtotime ( '+1 month' , strtotime ($fecha_actual) );
	$un_mes=date('Y-m-d', $un_mes);
	$dos_meses = strtotime ( '+2 month' , strtotime ($fecha_actual) );
	$dos_meses=date('Y-m-d',$dos_meses);
	$tres_meses = strtotime ( '+3 month' , strtotime ($fecha_actual) );
	$tres_meses=date('Y-m-d',$tres_meses);
	$cuatro_meses = strtotime ( '+4 month' , strtotime ($fecha_actual) );
	$cuatro_meses=date('Y-m-d',$cuatro_meses);
	$dia_2= date('Y-m-t', strtotime($fecha_actual));
	
	$update_contratos="select id, id_contrato, fecha_fin from ".$valer_3." where id_contrato is not null";
	$update_contratos_query=query_db($update_contratos);
	while($sql_con = traer_fila_db($update_contratos_query)){
		$query_contrato=traer_fila_row(query_db("select vigencia_mes from t7_contratos_contrato where id=".$sql_con[1]));
		if($query_contrato[0]!=$sql_con[2]){
			$update=query_db("update ".$valer_3." set estado = 4 where id=".$sql_con[0]);
		}
	}
	//($comple_sql or especialista=$v)
	$comple_sql="";
	$id="";
	$correos_mes1="";
	$correos_mes2="";
	$correos_mes3="";
	$correos_mes4="";
	$comple_sql.="gerente=".$id_gerente." or especialista=".$id_gerente;
	$id_profesional=0;
	$mes=1;
	$id="";
	$cont_contratos= traer_fila_row(query_db("SELECT count(*) FROM t7_contratos_contrato WHERE vigencia_mes between '$fecha_actual' AND '$tres_meses' AND ($comple_sql)"));
	if($cont_contratos[0]>0){//verifica si tiene algún contrato para recorrero los while
	global $co1, $g6, $g1, $pi2;
		/*******PARA LOS CONTRATS QUE VENCEN EN UN MES **********/
		$cuenta1=traer_fila_row(query_db("select count(*) FROM t7_contratos_contrato where vigencia_mes between '$fecha_actual' and '$un_mes' and ($comple_sql)"));
		if($cuenta1[0]!=0){
			$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$fecha_actual' and '$un_mes' and ($comple_sql) order by vigencia_mes");
			while($sql_con = traer_fila_db($query)){
				$update=query_db("update ".$valer_3." set estado = 4 where id_contrato=".$sql_con[0]." and id_usuario not in(".$sql_con[9].", ".$sql_con[16].")");
				$id_profesional=$sql_con[23];
				$numero_contrato1 = "C";
				$separa_fecha_crea = explode("-",$sql_con[19]);
				$ano_contra = $separa_fecha_crea[0];
				$numero_contrato2 = substr($ano_contra,2,2);
				$numero_contrato3 = $sql_con[2];
				$numero_contrato4 = $sql_con[43];
				$numero=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sql_con[0]);
				$numero2=explode(' ', $numero);
				/**** PARA INSERTAR Y ACTULIZAR AL GERENTE ****/
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$sql_con[9]." and id_contrato = ".$sql_con[0]." and dias = 30"));
				if($res[0]==0){
					$provee=traer_fila_row(query_db("SELECT razon_social FROM pv_proveedores where pv_id=".$sql_con[5]));
					$ruta="ajax_carga(''../aplicaciones/reportes/alertas_contratos.php?id_gerente=<-id->&tipo=1'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_contrato, fecha_fin, dias) values(".$sql_con[9].", 1, '".$ruta."', 1, 'Vencimiento en Menos de 30 Días <br>".$numero."  <br> ".utf8_encode($provee[0])."', 'custom-red-border',".$sql_con[9].", '".$fecha_actual."', '".$time."', ".$sql_con[0].", '".$sql_con[11]."', 30)");
				}
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$sql_con[9]." and id_contrato = ".$sql_con[0]." and dias = 60"));
				if($res[0]!=0){
					$ejecutar=query_db("UPDATE ".$valer_3." SET estado=4 where id_usuario=".$sql_con[9]." and id_contrato = ".$sql_con[0]." and dias = 60");
				}
				/**** PARA INSERTAR Y ACTULIZAR AL ESPECIALISTA ****/
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$sql_con[16]." and id_contrato = ".$sql_con[0]." and dias = 30"));
				if($res[0]==0){
					$provee=traer_fila_row(query_db("SELECT razon_social FROM pv_proveedores where pv_id=".$sql_con[5]));
					$ruta="ajax_carga(''../aplicaciones/reportes/alertas_contratos.php?id_gerente=<-id->&tipo=2'',''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_contrato, fecha_fin, dias) values(".$sql_con[16].", 1, '".$ruta."', 1, 'Vencimiento en Menos de 30 Días <br>".$numero."  <br> ".utf8_encode($provee[0])."', 'custom-red-border',".$sql_con[16].", '".$fecha_actual."', '".$time."', ".$sql_con[0].", '".$sql_con[11]."', 30)");
				}
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$sql_con[16]." and id_contrato = ".$sql_con[0]." and dias = 60"));
				if($res[0]!=0){
					$ejecutar=query_db("UPDATE ".$valer_3." SET estado=4 where id_usuario=".$sql_con[16]." and id_contrato = ".$sql_con[0]." and dias = 60");
				}
			}
		}
		$un_mes =strtotime ( '+1 day' , strtotime ($un_mes) );
		$un_mes=date('Y-m-d', $un_mes);
		/******PARA LOS CONTRATS QUE VENCEN EN DOS MESES *********/
		$cuenta1=traer_fila_row(query_db("select count(*) FROM t7_contratos_contrato where vigencia_mes between '$un_mes' and '$dos_meses' and ($comple_sql)"));
		if($cuenta1[0]!=0){
			$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$un_mes' and '$dos_meses' and ($comple_sql) order by vigencia_mes");
			while($sql_con = traer_fila_db($query)){
				$update=query_db("update ".$valer_3." set estado = 4 where id_contrato=".$sql_con[0]." and id_usuario not in(".$sql_con[9].", ".$sql_con[16].")");
				$id_profesional=$sql_con[23];
				$numero_contrato1 = "C";
				$separa_fecha_crea = explode("-",$sql_con[19]);
				$ano_contra = $separa_fecha_crea[0];
				$numero_contrato2 = substr($ano_contra,2,2);
				$numero_contrato3 = $sql_con[2];
				$numero_contrato4 = $sql_con[43];
				$numero=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sql_con[0]);
				$numero2=explode(' ', $numero);
				/**** PARA INSERTAR Y ACTULIZAR AL GERENTE ****/
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$sql_con[9]." and id_contrato = ".$sql_con[0]." and dias = 60"));
				if($res[0]==0){
					$provee=traer_fila_row(query_db("SELECT razon_social FROM pv_proveedores where pv_id=".$sql_con[5]));
					$ruta="ajax_carga(''../aplicaciones/reportes/alertas_contratos.php?id_gerente=<-id->&tipo=1'', ''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_contrato, fecha_fin, dias) values(".$sql_con[9].", 1, '".$ruta."', 1, 'Vencimiento en Menos de 2 Meses <br>".$numero."  <br> ".utf8_encode($provee[0])."', 'custom-yellow-border',".$sql_con[9].", '".$fecha_actual."', '".$time."', ".$sql_con[0].", '".$sql_con[11]."', 60)");
				}
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$sql_con[9]." and id_contrato = ".$sql_con[0]." and dias = 90"));
				if($res[0]!=0){
					$ejecutar=query_db("UPDATE ".$valer_3." SET estado=4 where id_usuario=".$sql_con[9]." and id_contrato = ".$sql_con[0]." and dias = 90");
				}
				/**** PARA INSERTAR Y ACTULIZAR AL ESPECIALISTA ****/
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$sql_con[16]." and id_contrato = ".$sql_con[0]." and dias = 60"));
				if($res[0]==0){
					$provee=traer_fila_row(query_db("SELECT razon_social FROM pv_proveedores where pv_id=".$sql_con[5]));
					$ruta="ajax_carga(''../aplicaciones/reportes/alertas_contratos.php?id_gerente=<-id->&tipo=2'', ''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_contrato, fecha_fin, dias) values(".$sql_con[16].", 1, '".$ruta."', 1, 'Vencimiento en Menos de 2 Meses <br>".$numero."  <br> ".utf8_encode($provee[0])."', 'custom-yellow-border',".$sql_con[16].", '".$fecha_actual."', '".$time."', ".$sql_con[0].", '".$sql_con[11]."', 60)");
				}
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$sql_con[16]." and id_contrato = ".$sql_con[0]." and dias = 90"));
				if($res[0]!=0){
					$ejecutar=query_db("UPDATE ".$valer_3." SET estado=4 where id_usuario=".$sql_con[16]." and id_contrato = ".$sql_con[0]." and dias = 90");
				}
			}
		}
		/*******PARA LOS CONTRATS QUE VENCEN EN TRES MESES *********/
		$dos_meses = strtotime ( '+1 day' , strtotime ($dos_meses) );
		$dos_meses=date('Y-m-d',$dos_meses);
		$cuenta1=traer_fila_row(query_db("select count(*) FROM t7_contratos_contrato where vigencia_mes between '$dos_meses' and '$tres_meses' and ($comple_sql)"));
		if($cuenta1[0]!=0){
			$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$dos_meses' and '$tres_meses' and ($comple_sql) order by vigencia_mes");
			while($sql_con = traer_fila_db($query)){
				$update=query_db("update ".$valer_3." set estado = 4 where id_contrato=".$sql_con[0]." and id_usuario not in(".$sql_con[9].", ".$sql_con[16].")");
				$id_profesional=$sql_con[23];
				$numero_contrato1 = "C";
				$separa_fecha_crea = explode("-",$sql_con[19]);
				$ano_contra = $separa_fecha_crea[0];
				$numero_contrato2 = substr($ano_contra,2,2);
				$numero_contrato3 = $sql_con[2];
				$numero_contrato4 = $sql_con[43];
				$numero=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sql_con[0]);
				$numero2=explode(' ', $numero);
				/**** PARA INSERTAR Y ACTULIZAR AL GERENTE ****/
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$sql_con[9]." and id_contrato = ".$sql_con[0]." and dias = 90"));
				if($res[0]==0){
					$provee=traer_fila_row(query_db("SELECT razon_social FROM pv_proveedores where pv_id=".$sql_con[5]));
					$ruta="ajax_carga(''../aplicaciones/reportes/alertas_contratos.php?id_gerente=<-id->&tipo=1'', ''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_contrato, fecha_fin, dias) values(".$sql_con[9].", 1, '".$ruta."', 1, 'Vencimiento en Menos de 3 Meses <br>".$numero."  <br> ".utf8_encode($provee[0])."', 'custom-green-border',".$sql_con[9].", '".$fecha_actual."', '".$time."', ".$sql_con[0].", '".$sql_con[11]."', 90)");
				}
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$sql_con[9]." and id_contrato = ".$sql_con[0]." and dias = 120"));
				if($res[0]!=0){
					$ejecutar=query_db("UPDATE ".$valer_3." SET estado=4 where id_usuario=".$sql_con[9]." and id_contrato = ".$sql_con[0]." and dias = 120");
				}
				/**** PARA INSERTAR Y ACTULIZAR AL ESPECIALISTA ****/
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$sql_con[16]." and id_contrato = ".$sql_con[0]." and dias = 90"));
				if($res[0]==0){
					$provee=traer_fila_row(query_db("SELECT razon_social FROM pv_proveedores where pv_id=".$sql_con[5]));
					$ruta="ajax_carga(''../aplicaciones/reportes/alertas_contratos.php?id_gerente=<-id->&tipo=2'', ''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_contrato, fecha_fin, dias) values(".$sql_con[16].", 1, '".$ruta."', 1, 'Vencimiento en Menos de 3 Meses <br>".$numero."  <br> ".utf8_encode($provee[0])."', 'custom-green-border',".$sql_con[16].", '".$fecha_actual."', '".$time."', ".$sql_con[0].", '".$sql_con[11]."', 90)");
				}
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$sql_con[16]." and id_contrato = ".$sql_con[0]." and dias = 120"));
				if($res[0]!=0){
					$ejecutar=query_db("UPDATE ".$valer_3." SET estado=4 where id_usuario=".$sql_con[16]." and id_contrato = ".$sql_con[0]." and dias = 120");
				}
			}
		}
		$tres_meses = strtotime ( '+1 day' , strtotime ($tres_meses) );
		$tres_meses=date('Y-m-d',$tres_meses);
		/*******PARA LOS CONTRATS QUE VENCEN EN CUATRO MESES **********
		$cuenta1=traer_fila_row(query_db("select count(*) FROM t7_contratos_contrato where convert(date, vigencia_mes) between '$tres_meses' and '$cuatro_meses' and ($comple_sql)"));
		if($cuenta1[0]!=0){
			$query=query_db("select * FROM t7_contratos_contrato where convert(date, vigencia_mes) between '$tres_meses' and '$cuatro_meses' and ($comple_sql) order by vigencia_mes");
			$num_contratos="";
			while($sql_con = traer_fila_db($query)){
				$numero_contrato1 = "C";
				$separa_fecha_crea = explode("-",$sql_con[19]);
				$ano_contra = $separa_fecha_crea[0];
				$numero_contrato2 = substr($ano_contra,2,2);
				$numero_contrato3 = $sql_con[2];
				$numero_contrato4 = $sql_con[43];
				$numero=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sql_con[0]);
				$numero2=explode(' ', $numero);
				$res=traer_fila_row(query_db("SELECT count(*) FROM ".$valer_3." where id_usuario=".$id_gerente." and mensaje like '%".$numero2[0]."%' and mensaje like '%Menos de 4 Meses%'"));
				if($res[0]==0){
					$provee=traer_fila_row(query_db("SELECT razon_social FROM pv_proveedores where pv_id=".$sql_con[5]));
					$ruta="ajax_carga(''../aplicaciones/reportes/alertas_contratos.php?id_gerente=<-id->&tipo=1'', ''contenidos'')";
					$isert=query_db("insert into ".$valer_3."(id_usuario, estado, ruta, tipo, mensaje, estilo_borde, id_carga, fecha_creacion, hora_creacion, id_contrato, fecha_fin, dias) values(".$id_gerente.", 1, '".$ruta."', 1, 'Vencimiento en Menos de 4 Meses <br>".$numero." <br> ".$provee[0]."', 'custom-green-border',".$sql_con[9].", '".$fecha_actual."', '".$time."', ".$sql_con[0].", '".$sql_con[11]."',)");
				}
			}
		}*/
	}//FIN verifica si tiene algún contrato para recorrero los while
}
?>