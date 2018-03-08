<? include("../../librerias/lib/@include.php");
//include("../../librerias/lib/@session.php");







      
/*
	//$dropta = query_db("drop table alertas_email");
	$crea_tempo = "CREATE TABLE alertas_email (id_proceso int, destino varchar(5000),modulo varchar(50), consecutivo varchar(50), detalle varchar(500), fecha_recibido varchar(10), numero_modulo int, id_us_alerta int)";
	$sql_te = query_db($crea_tempo);
*/

	//alertas item
	$trucate = query_db("truncate table alertas_email");
$usuarios_alertas = ",57";


$usuarios_alestras1 = query_db("select us_id from v_alertas_pecc_firmas group by us_id");
	while($sel_item2 = traer_fila_db($usuarios_alestras1)){
		$usuarios_alertas.= ",".$sel_item2[0];
	}
$usuarios_alestras = query_db("select id_us from $valer_1 where id_pecc = 1 and estado < 21 and id_us not in (0".$usuarios_alertas.")  group by id_us");
	while($sel_item = traer_fila_db($usuarios_alestras)){
		$usuarios_alertas.= ",".$sel_item[0];
	}
$usuarios_alestras = query_db("select id_us_profesional_asignado from $valer_1 where id_pecc = 1 and estado < 21 and id_us_profesional_asignado not in (0".$usuarios_alertas.") group by id_us_profesional_asignado");
	while($sel_item = traer_fila_db($usuarios_alestras)){
		$usuarios_alertas.= ",".$sel_item[0];
	}
	
$usuarios_alestras = query_db("select us_id from v_seg1 where us_id not in (0".$usuarios_alertas.") and id_premiso in (26,12, 8, 27, 32) group by us_id");
	while($sel_item = traer_fila_db($usuarios_alestras)){
		$usuarios_alertas.= ",".$sel_item[0];
	}

	
	
	
	$usuarios_alertas = explode (",",$usuarios_alertas);
	
	for ($i = 1; $i<count($usuarios_alertas); $i++){
			


	$id_us_alerta = $usuarios_alertas[$i];
	
	
	if($_SESSION["id_us_session"] == 18591){
	
	$comple_sql_almace=" and t1_area_id in (17,24)";
	}
	
	
	
	$sele_pecc_item = query_db("select * from $valer_1 where id_pecc = 1 and estado < 21 $comple_sql_almace");
	while($sel_item = traer_fila_db($sele_pecc_item)){
			$numero = numero_item_pecc($sel_item[1],$sel_item[2],$sel_item[3]);
			$modulo_aplica = "MODULO SOLICITUDES";
			$link_aplica_modulo = "pecc/edicion-item-pecc";
		$id_tipo_proceso_pecc = 1;
		$es_encargado = "NO";
			if($sel_item[10] == 7){
					$id_tipo_proceso_pecc = 2;
				}
			if($sel_item[10] == 8){
					$id_tipo_proceso_pecc = 3;
				}
		
		
		//BODEGA
		if($sel_item[11] == 10){
		$sel_us_bodega = traer_fila_row(query_db("select * from v_seg1 where us_id = ".$id_us_alerta." and id_premiso = 29"));
			if($sel_us_bodega[0]>0){
				$es_encargado = "SI";
			}
		}
						
						//FIN BODEGA
						
				
		if($sel_item[11] == 1){
				if($sel_item[13] == $id_us_alerta){
					$es_encargado = "SI";
					}
		}
		if($sel_item[11] == 2){
				if($sel_item[14] == $id_us_alerta){
					$es_encargado = "SI";
					}
		}
		if($sel_item[11] == 3){
	
	
	if($sel_item[9] ==7 ){
		$permiso_asdj =1;
		}
	if($sel_item[9] ==16 ){
		$permiso_asdj =2;
		}
		
			$rol_no_aplica="";
			if($id_us_alerta == "18041" and $sel_item[18]<>1){
			$rol_no_aplica = ",9,35";
			
			}



		$sel_aprobadores_de_firmas = traer_fila_row(query_db("select count(*) from $valer_2 where id_item_pecc = ".$sel_item[0]." and id_usuario = ".$id_us_alerta." and indicador_si_esta_aprobado is null and tipo_adj_permiso = ".$permiso_asdj." and id_rol not in (10,11 ".$rol_no_aplica.")"));
				if($sel_aprobadores_de_firmas[0] > 0){
					$es_encargado = "SI";
					}
		}
		if($sel_item[11] == 4){

			$sel_rol_comite = traer_fila_row(query_db("select count(*) from $v_seg1 where id_modulo = 1 and id_premiso = 10 and	us_id=".$id_us_alerta));
				if($sel_rol_comite[0] > 0){
					$es_encargado = "SI";
					$modulo_aplica = "MODULO COMITE";
					
					//$select_item_en_comites = query_db("select * from v_comite_item_ultimo_estado_pendiente where id_item = ".$sel_item[0]);
					
					}
					
					
		}
		
		if($sel_item[11] == 5){//SOCIOS
		
	if($sel_item[9] == 9 ){
		$permiso_asdj =1;
		}
	if($sel_item[9] == 18 ){
		$permiso_asdj =2;
		}
		
		
			$sel_aprobadores_de_firmas = traer_fila_row(query_db("select count(*) from $valer_2 where id_item_pecc = ".$sel_item[0]." and id_usuario = ".$id_us_alerta." and indicador_si_esta_aprobado is null and tipo_adj_permiso = ".$permiso_asdj." and id_rol = 11"));
				if($sel_aprobadores_de_firmas[0] > 0){
					$es_encargado = "SI";
					}
		}
		
		
		if($sel_item[11] == 11){//estado elaboracion de contrato
				
				
		if($sel_item[16] == 8){//si es OT en elaboracion de contrato
			if($id_us_alerta == 18245 and $sel_item[13] == 18245){// si es tatiana
			$es_encargado = "SI";				
			}
			
			if($id_us_alerta == 57 and $sel_item[13] <> 18245){// si es amparo

			$es_encargado = "SI";				
			}
			
			}else{// si es elaboracion de contrato de cualquier otro tipo de solicitud
				$sel_us_elaboracion_contra = traer_fila_row(query_db("select * from v_seg1 where us_id = ".$id_us_alerta." and id_premiso = 32"));
					if($sel_us_elaboracion_contra[0]>0){
					$es_encargado = "SI";
					}		
				}
			
		
					
					
					
					
		}
		
		
		
		
		
		$contras_solic = "";
		if($sel_item[9] ==20 ){
		$modulo_aplica = "MODULO CONTRATOS";
		$sele_contras_elab = query_db("select consecutivo,creacion_sistema,apellido from t7_contratos_contrato where id_item = ".$sel_item[0]);
					
					while($sel_cont = traer_fila_db($sele_contras_elab)){
						
							$numero_contrato1 = "C";			
							$separa_fecha_crea = explode("-",$sel_cont[1]);
							$ano_contra = $separa_fecha_crea[0];					
							$numero_contrato2 = substr($ano_contra,2,2);
							$numero_contrato3 = $sel_cont[0];
							$numero_contrato4 = $sel_cont[2];
							$contras_solic = $contras_solic." - ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4);

						}
				if($contras_solic == ""){		//si es orden de trabajo o ampliacion y la solicitud estado 20	
				$sele_presupuesto = traer_fila_row(query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$sel_item[0]."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id"));
				
				$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sele_presupuesto[0]);
			while($sel_apl = traer_fila_db($sel_contr)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
				$contras_solic = $contras_solic." - ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4);
				
			}
				}
			
	if($sel_item["contrato_id"] != "" and $sel_item["contrato_id"] > 0 and $contras_solic == ""){	//si es otro si y la solicitud estado 20
		$sele_contras_elab_otro_si = traer_fila_row(query_db("select consecutivo,creacion_sistema,apellido from t7_contratos_contrato where id = ".$sel_item["contrato_id"]));
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sele_contras_elab_otro_si[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sele_contras_elab_otro_si[0];
					$numero_contrato4 = $sele_contras_elab_otro_si[2];
					$contras_solic = $contras_solic." - ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4);
	}
		
		}
		
				if($es_encargado == "SI"){
			$inserta_datos = query_db("insert into alertas_email (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) values (".$sel_item[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_item[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','".$modulo_aplica."','".$numero."','Sección: ".$sel_item[6].". Tarea: ".$sel_item[7].$contras_solic."', '".$sel_item[4]."',2,'$id_us_alerta')");
				}
				
		}	
		//VERIFICA DEVUELTOS Y ESTADO EN PREPARACION 31
				
				$sel_usu_emulan = query_db("select * from t2_relacion_usuarios_emulan where id_us = ".$id_us_alerta);
				$cuantos = 0;
				while($us_emunlados = traer_fila_db($sel_usu_emulan)){
						$strin_emulado = $strin_emulado.$us_emunlados[2].",";
						$cuantos = 1;
					}
					
					if($cuantos == 1){
						$id_us_alerta = $strin_emulado."0";
						}else{
								$id_us_alerta = $id_us_alerta;
							}
				$sel_item_en_preparacion_devuelto = query_db("select id_item, num1,num2,num3 from $pi2 where num1 <> '' and id_us in (".$id_us_alerta.") and estado = 31");
				while($sel_devueltos_31 = traer_fila_row($sel_item_en_preparacion_devuelto)){
					$numero = numero_item_pecc($sel_devueltos_31[1],$sel_devueltos_31[2],$sel_devueltos_31[3]);
					$inserta_datos = query_db("insert into alertas_email (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) values (".$sel_devueltos_31[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_devueltos_31[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','MODULO SOLICITUDES','".$numero."','Sección: Solicitud de Permiso. Tarea: Ajustar por Devolución', '2012-01-01',2,'$id_us_alerta')");
					}
						
					$sel_item_en_preparacion_preparacion = query_db("select id_item, num1,num2,num3 from $pi2 where (num1 is null or num1 = '') and id_us in (".$id_us_alerta.") and estado = 31");
				while($sel_devueltos_31 = traer_fila_row($sel_item_en_preparacion_preparacion)){
					
					
					
					$inserta_datos = query_db("insert into alertas_email (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) values (".$sel_devueltos_31[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_devueltos_31[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','MODULO SOLICITUDES','','Sección: Solicitud de Permiso. Tarea: En Preparación', '2012-01-01',2,'$id_us_alerta')");
					}
					
				//Fin VERIFICA DEVUELTOS Y ESTADO EN PREPARACION 31
				
				
				
	//Fin Alertas item
	

	// comite
	$sel_comites_activos = query_db("select id_comite, id_item, num1,num2,num3, fecha from v_alertas_comite where id_us = ".$id_us_alerta." group by id_comite, id_item, num1,num2,num3, fecha  ");
	while($comit_pendientes = traer_fila_db($sel_comites_activos)){
		
		$numero_comite = numero_item_pecc($comit_pendientes[2],$comit_pendientes[3],$comit_pendientes[4]);
		
		$inserta_datos = query_db("insert into alertas_email (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) values (	".$comit_pendientes[0].",'../aplicaciones/comite/aprobacion.php?id_comite=".$comit_pendientes[0]."','MODULO COMITE','".$numero_comite."','Tiene Solicitudes pendientes por aprobacion', '".$comit_pendientes[5]."',3,'$id_us_alerta')");
		
		}
	//fin comite
	
	//ratificacion presidente
	
	if($id_us_alerta == $presidente){
		$sel_comites = query_db("select id_comite, num1,num2,num3, fecha from t3_comite where presidente <> 1 and estado = 1");
		
		while($sel_com = traer_fila_db($sel_comites)){
			$numero_comite = numero_item_pecc($sel_com[1],$sel_com[2],$sel_com[3]);
			$inserta_datos = query_db("insert into alertas_email (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) values (	".$sel_com[0].",'../aplicaciones/comite/aprobacion.php?id_comite=".$sel_com[0]."','MODULO COMITE','".$numero_comite."','Este Comit&eacute; esta Pendiente por Verificar', '".$sel_com[4]."',3,'$id_us_alerta')");
			}
	}
	//FIN ratificacion presidente
	
	//urna virtual
	$link = mysql_connect($host_mys,$usr_mys, $pwd_mys);
	mysql_select_db($dbbase_mys, $link);
	
	 $query_usr = "select pro1_proceso.pro1_id, tp2_tipo_proceso.nombre, tp6_tipo_objetos.nombre, tp5_tipo_contrato.nombre, pro1_proceso.fecha_apertura, pro1_proceso.fecha_cierre, us_usuarios.nombre_administrador, pro1_proceso.consecutivo, pro1_proceso.detalle_objeto , tp1_estado_proceso.nombre estado_procesos , pro1_proceso.us_id, pro1_proceso.cuantia,pro1_proceso.tp7_tipo_moneda,pro1_proceso.us_id_contacto 
	from tp2_tipo_proceso, tp6_tipo_objetos, tp5_tipo_contrato, us_usuarios, pro1_proceso, tp1_estado_proceso 
	where tp2_tipo_proceso.tp2_id = pro1_proceso.tp2_id 
	and tp6_tipo_objetos.tp6_id = pro1_proceso.tp6_id 
	and tp5_tipo_contrato.tp5_id = pro1_proceso.tp5_id 
	and us_usuarios.us_id = pro1_proceso.us_id_contacto 
	and tp1_estado_proceso.tp1_id = pro1_proceso.tp1_id 
	and pro1_proceso.tp1_id not in (5, 7, 8) order by pro1_proceso.pro1_id desc ";
	
	 $sql_ex = mysql_query($query_usr);
                while($ls=mysql_fetch_row($sql_ex)){
$muestra_proceso = 0;
 				if($ls[10]==$id_us_alerta){//SI ES EL DUEÑO DEL PROCESO
                    $muestra_proceso=1;
                    } //SI ES EL DUEÑO DEL PROCESO
            
                if($ls[13]==$id_us_alerta){//SI ES EL DUEÑO DEL PROCESO
                    $muestra_proceso=1;
                    } //SI ES EL DUEÑO DEL PROCESO
            				
			if($muestra_proceso==1){ //si se debe mostrar
			$inserta_datos = query_db("insert into alertas_email (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) 
			values (	".$ls[0].",'carga_urna(".$ls[0].")','MODULO URNA VIRTUAL','".$ls[7]."','Estado del proceso: $ls[9] fecha de cierre $ls[5]', '".$ls[5]."',4,'$id_us_alerta')");
				
				}//si se debe mostrar
				
				}
				
				mysql_close();
	
	// urna virtual
	
	//inicio contratos
	$arr_estado = 'null';
	
	$sel_permisos = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$id_us_alerta." and id_permiso=26";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));
	if($sql_sel_permisos[0]>0){
		$arr_estado = $arr_estado.",".$est_abastecimiento.",".$est_sap.",".$est_revision.",".$est_firma_hocol.",".$est_firma_contratista.",".$est_gerente_contrato.",".$est_legalizacion.",".$est_poliza;
	}
	
	$sel_permisos = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$id_us_alerta." and id_permiso=12";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));
	if($sql_sel_permisos[0]>0){
		$arr_estado = $arr_estado.",".$est_poliza;
	}
	
	$lista_contrato = "select * from $co1 where (analista_deloitte <> 1 or analista_deloitte IS NULL) and estado <> $est_finalizado and estado in ($arr_estado)";
	$sql_contrato=query_db($lista_contrato);
	while($lista_contrato=traer_fila_row($sql_contrato)){
			$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
			$separa_fecha_crea = explode("-",$lista_contrato[19]);//fecha_creacion
			$ano_contra = $separa_fecha_crea[0];					
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $lista_contrato[2];//consecutivo
			$numero_contrato4 = $lista_contrato[43];//apellido
			
		
			$inserta_datos = query_db("insert into alertas_email (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) 			values (	".$lista_contrato[0].",'../aplicaciones/contratos/menu_contrato.php?id=".arreglo_pasa_variables($lista_contrato[0])."','CONTRATOS','".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4)."','Estado del proceso:".estado_contrato_retu(arreglo_pasa_variables($lista_contrato[0]),$co1)."', '',5,'$id_us_alerta')");
	}
	/* inicio modificaciones con estado individual
	$lista_contrato = "select t7c.id,t7c.id_contrato,t1t.nombre from $co4 t7c left join t1_tipo_complemento t1t on t7c.tipo_complemento=t1t.id where t7c.estado <> $est_finalizado and t7c.estado in ($arr_estado)";
	$sql_contrato=query_db($lista_contrato);
	while($lista_contrato=traer_fila_row($sql_contrato)){
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo) 
			values (	".$lista_contrato[1].",'../aplicaciones/contratos/menu_contrato.php?id=".arreglo_pasa_variables($lista_contrato[1])."','CONTRATOS','".consecutivo_bl($lista_contrato[1])."','Estado del proceso:".$lista_contrato[2]." ".estado_contrato_retu(arreglo_pasa_variables($lista_contrato[0]),$co4)."', '',5)");
	}
	 fin modificaciones con estado individual*/
	 $lista_contrato = "select t7c.id_contrato,t1t.nombre,t7co.creacion_sistema,t7co.consecutivo,t7co.apellido from $co4 t7c left join t1_tipo_complemento t1t on t7c.tipo_complemento=t1t.id left join t7_contratos_contrato t7co on t7c.id_contrato=t7co.id where (congelado <> 1 or congelado IS NULL) and t7c.estado <> $est_finalizado and t7c.estado in ($arr_estado) group by t7c.id_contrato,t1t.nombre,t7co.creacion_sistema,t7co.consecutivo,t7co.apellido";
	$sql_contrato=query_db($lista_contrato);
	while($lista_contrato=traer_fila_row($sql_contrato)){
			$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
			$separa_fecha_crea = explode("-",$lista_contrato[2]);//fecha_creacion
			$ano_contra = $separa_fecha_crea[0];					
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $lista_contrato[3];//consecutivo
			$numero_contrato4 = $lista_contrato[4];//apellido
						
			$inserta_datos = query_db("insert into alertas_email (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_us_alerta) 
			values (	".$lista_contrato[0].",'../aplicaciones/contratos/menu_contrato.php?id=".arreglo_pasa_variables($lista_contrato[0])."','CONTRATOS','".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4)."','Estado del proceso:".$lista_contrato[1]." Pendiente Modificaciones', '',5,'$id_us_alerta')");
	}
	//fin contratos
	
	

	}// fin FOR que selecciona los usuarios con alertas

 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Expires" content="0" />
 <meta http-equiv="Pragma" content="no-cache" />
<title><?=TITULO;?></title>





</head>

<body >

<div id="cargando_pecc"  style="display:none"><table width="100%" height="1000" align="center" border="0"><tr><td align="center" valign="middle"><img src="../imagenes/botones/cargando2.gif" width="320" height="250" /></td></table></div>

<?
$hasta_donde = count($usuarios_alertas);
//$hasta_donde = 2;//comentrarisr este


for ($i = 1; $i<$hasta_donde; $i++){
	$us_aletr = $usuarios_alertas[$i];
	//$us_aletr = 17977;//comentariar este
	
	$conte_tex="";
	 $busca_si_tiene = traer_fila_row(query_db("select count(*) from alertas_email where id_us_alerta = '".$us_aletr."'  $complemento "));
	if($busca_si_tiene[0]>0){
	
	$sel_us = traer_fila_row(query_db("select * from t1_us_usuarios where us_id = ".$us_aletr));

$conte_tex = '
Cordial Saludo, '.$sel_us[1].'.<br><br> 
Ud,  tiene tareas por completar en la Herramienta de Abastecimiento SGPA, por favor ingrese desde el escritorio de su PC  o a trav&eacute;s de www.abastecimiento.hocol.com.co; a continuaci&oacute;n resumen de Tareas por completar: 


<table width="100%" border="0" cellpadding="2" cellspacing="2" style=" margin:10px;
  BORDER-BOTTOM: #cccccc 3px double; BORDER-RIGHT: #cccccc 3px  double; BORDER-TOP: #cccccc 1px solid;  	BORDER-LEFT: #cccccc 1px solid; 
  border-spacing:2px;
  overflow:scroll;">
  <tr>
    <td width="20%" style=" height:20px;font-size:14px;  
 BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#DDDDDD"><div align="center">Modulo</div></td>
    <td width="15%" style=" height:20px;font-size:14px;  
 BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#DDDDDD"><div align="center">Consecutivo</div></td>
    <td width="58%" style=" height:20px;font-size:14px;  
 BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#DDDDDD"><div align="center">Descripci&oacute;n</div></td>
  </tr>';



 $busca_item = "
select id_proceso,destino,modulo,consecutivo,detalle, ROW_NUMBER() OVER(ORDER BY numero_modulo) AS rownum,numero_modulo from alertas_email where id_proceso >=1  and id_us_alerta = '".$us_aletr."'  $complemento   order by numero_modulo asc, modulo desc";	  


	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){
		
$conte_tex.= '<tr style="background:#DBFBDC">
    <td style="background:#DBFBDC">'.$ls_mr[2].'</td>
    <td style="background:#DBFBDC">'.$ls_mr[3].'</td>
    <td style="background:#DBFBDC">'.htmlentities($ls_mr[4]).'</td>
  </tr>';
  
   } 
 $conte_tex.='</table>';
/*
//Envio_email
$correo_destino=$sel_us[4];
//$correo_destino="abastecimiento@hcl.com.co";
$asunto_msn="SGPA Notificaciones $fecha";
$cuerpo =$conte_tex;
echo $correo_destino;
echo $cuerpo;
$mail = new PHPMailer();
$mail->IsSMTP(); 
$mail->SMTPAuth = false; 
$mail->SMTPSecure = "";
$mail->Port       = 25; 
$mail->Username = $correo_autentica_phpmailer; 
$mail->Password = $contrasena_autentica_phpmailer; 
$mail->Host = $servidor_phpmailer;
$mail->From = $correo_from_phpmiler;
$mail->FromName = $nombre_from_phpmiler;


$mail->Subject = $asunto_msn;
$mail->AddAddress($correo_destino,$nombre);
//$mail->AddAddress("ferney.sterling@enternova.net","Nombre 02");
//$mail->AddCC("ferney.sterling@enternova.net");
$mail->AddBCC("sgpa-notificaciones@enternova.net");//copia oculta
//$mail->AddBCC($correo_dvrnet2);//copia oculta
//$mail->AddAttachment("images/foto.jpg", "foto.jpg");
//$mail->AddAttachment("files/demo.zip", "demo.zip");
$mail->Body = $cuerpo;
$mail->AltBody = "SGPA Informaciones";
$mail->Send();
// FIN Envio_email

*/


	}
}//for
?>
</body>
</html>