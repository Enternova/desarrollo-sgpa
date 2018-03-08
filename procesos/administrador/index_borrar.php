<? include("../../librerias/lib/@session.php");

	       $numero_get = valida_get();
		   $numer = numero_ingresos_get();
	
	$crea_tempo = "CREATE TABLE #alertas (id_proceso int, destino varchar(5000),modulo varchar(50), consecutivo varchar(50), detalle varchar(500), fecha_recibido varchar(10), numero_modulo int)";
	$sql_te = query_db($crea_tempo);

//crea_ots(3)	;

	
	/*alertas PECC
	$sele_pecc_item = query_db("select * from $valer_1 where id_pecc <> 1");
	while($sel_item = traer_fila_db($sele_pecc_item)){
			$numero = numero_item_pecc($sel_item[1],$sel_item[2],$sel_item[3]);
			$id_tipo_proceso_pecc = 1;
			if($sel_item[10] == 7){
					$id_tipo_proceso_pecc = 2;
				}
			if($sel_item[10] == 8){
					$id_tipo_proceso_pecc = 3;
				}
				if($sel_item[11] == 1){
				if($sel_item[13] == $_SESSION["id_us_session"]){
					$es_encargado = "SI";
					}
		}
		if($sel_item[11] == 2){
				if($sel_item[14] == $_SESSION["id_us_session"]){
					$es_encargado = "SI";
					}
		}
		if($sel_item[11] == 3){

			$sel_aprobadores_de_firmas = traer_fila_row(query_db("select count(*) from $valer_2 where id_item_pecc = ".$sel_item[0]." and id_usuario = ".$_SESSION["id_us_session"]." and indicador_si_esta_aprobado is null"));
				if($sel_aprobadores_de_firmas[0] > 0){
					$es_encargado = "SI";
					}
		}
		if($sel_item[11] == 4){

			$sel_rol_comite = traer_fila_row(query_db("select count(*) from $v_seg1 where id_modulo = 1 and id_premiso = 10 and	us_id=".$_SESSION["id_us_session"]));
				if($sel_rol_comite[0] > 0){
					$es_encargado = "SI";
					}
		}
		if($sel_item[11] == 5){

			$sel_rol_comite = traer_fila_row(query_db("select count(*) from $v_seg1 where id_modulo = 1 and id_premiso = 11 and	us_id=".$_SESSION["id_us_session"]));
				if($sel_rol_comite[0] > 0){
					$es_encargado = "SI";
					}
		}
		
				
				if($es_encargado == "SI"){
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo) values (	".$sel_item[0].",'../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$sel_item[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','MODULO PECC','".$numero."','".$sel_item[5].$sel_item[6].$sel_item[7]."', '".$sel_item[4]."',1)");
				}
		}	
	*/
	//Fin Alertas PECC
	//alertas item

	$sele_pecc_item = query_db("select * from v_alertas_pecc_item where id_pecc = 1 and estado < 21");
	while($sel_item = traer_fila_db($sele_pecc_item)){
			$numero = numero_item_pecc($sel_item[1],$sel_item[2],$sel_item[3]);
			$modulo_aplica = "MODULO SOLICITUDES";
			$link_aplica_modulo = "pecc/edicion-item-pecc";
		$id_tipo_proceso_pecc = 1;
		$es_encargado = "NO";

			if($sel_item[15] == 7){

					$id_tipo_proceso_pecc = 2;
				}
			if($sel_item[15] == 8){
					$id_tipo_proceso_pecc = 3;
				}

						//BODEGA
		if($sel_item[11] == 10){
		$sel_us_bodega = traer_fila_row(query_db("select * from v_seg1 where us_id = ".$_SESSION["id_us_session"]." and id_premiso = 29"));
		if($sel_us_bodega[0]>0){
			$es_encargado = "SI";
		}
		}
						
						//FIN BODEGA
		if($sel_item[11] == 1){
				if($sel_item[13] == $_SESSION["id_us_session"]){
					$es_encargado = "SI";
					}
		}
		if($sel_item[11] == 2){
				if($sel_item[14] == $_SESSION["id_us_session"]){
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
		$sel_aprobadores_de_firmas = traer_fila_row(query_db("select count(*) from $valer_2 where id_item_pecc = ".$sel_item[0]." and id_usuario = ".$_SESSION["id_us_session"]." and indicador_si_esta_aprobado is null and tipo_adj_permiso = ".$permiso_asdj." and id_rol not in (10,11)"));
				if($sel_aprobadores_de_firmas[0] > 0){
					$es_encargado = "SI";
					}
		}
		if($sel_item[11] == 4){

			$sel_rol_comite = traer_fila_row(query_db("select count(*) from $v_seg1 where id_modulo = 1 and id_premiso = 10 and	us_id=".$_SESSION["id_us_session"]));
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
		

			$sel_aprobadores_de_firmas = traer_fila_row(query_db("select count(*) from $valer_2 where id_item_pecc = ".$sel_item[0]." and id_usuario = ".$_SESSION["id_us_session"]." and indicador_si_esta_aprobado is null and tipo_adj_permiso = ".$permiso_asdj." and id_rol = 11"));
				if($sel_aprobadores_de_firmas[0] > 0){
					$es_encargado = "SI";
					}
		}
		
		if($sel_item[11] == 11){
				$sel_us_elaboracion_contra = traer_fila_row(query_db("select * from v_seg1 where us_id = ".$_SESSION["id_us_session"]." and id_premiso = 32"));
		if($sel_us_elaboracion_contra[0]>0){
					$es_encargado = "SI";
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
					
	
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo) values (".$sel_item[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_item[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','".$modulo_aplica."','".$numero."','Sección: ".$sel_item[6].". Tarea: ".$sel_item[7].$contras_solic."', '".$sel_item[4]."',2)");
				}
				
		}	
		//VERIFICA DEVUELTOS Y ESTADO EN PREPARACION 31
				
				$sel_usu_emulan = query_db("select * from t2_relacion_usuarios_emulan where id_us = ".$_SESSION["id_us_session"]);
				$cuantos = 0;
				while($us_emunlados = traer_fila_db($sel_usu_emulan)){
						$strin_emulado = $strin_emulado.$us_emunlados[2].",";
						$cuantos = 1;
					}
					
					if($cuantos == 1){
						$id_us_alerta = $strin_emulado."0";
						}else{
								$id_us_alerta = $_SESSION["id_us_session"];
							}
				$sel_item_en_preparacion_devuelto = query_db("select id_item, num1,num2,num3, t1_tipo_proceso_id from $pi2 where num1 <> '' and id_us in (".$id_us_alerta.") and estado = 31");
				while($sel_devueltos_31 = traer_fila_row($sel_item_en_preparacion_devuelto)){
					
					$numero = numero_item_pecc($sel_devueltos_31[1],$sel_devueltos_31[2],$sel_devueltos_31[3]);
					
					if($sel_devueltos_31[4] == 7){

					$id_tipo_proceso_pecc = 2;
				}
			if($sel_devueltos_31[4] == 8){
					$id_tipo_proceso_pecc = 3;
				}

						
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo) values (".$sel_devueltos_31[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_devueltos_31[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','MODULO SOLICITUDES','".$numero."','Sección: Solicitud de Permiso. Tarea: Ajustar por Devolución', '2012-01-01',2)");
					}

					$sel_item_en_preparacion_preparacion = query_db("select id_item, num1,num2,num3, t1_tipo_proceso_id from $pi2 where (num1 is null or num1 = '') and id_us in (".$id_us_alerta.") and estado = 31");
				while($sel_devueltos_31 = traer_fila_row($sel_item_en_preparacion_preparacion)){
					
					if($sel_devueltos_31[4] == 7){

					$id_tipo_proceso_pecc = 2;
				}
			if($sel_devueltos_31[4] == 8){
					$id_tipo_proceso_pecc = 3;
				}
				
				
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo) values (".$sel_devueltos_31[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_devueltos_31[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','MODULO SOLICITUDES','','Sección: Solicitud de Permiso. Tarea: En Preparación', '2012-01-01',2)");
					}
					
				//Fin VERIFICA DEVUELTOS Y ESTADO EN PREPARACION 31
				
				
				
	//Fin Alertas item
	
	
	// comite
	$sel_comites_activos = query_db("select id_comite, id_item, num1,num2,num3, fecha from v_alertas_comite where id_us = ".$_SESSION["id_us_session"]." group by id_comite, id_item, num1,num2,num3, fecha  ");
	while($comit_pendientes = traer_fila_db($sel_comites_activos)){
		$numero_comite = numero_item_pecc($comit_pendientes[2],$comit_pendientes[3],$comit_pendientes[4]);
		$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo) values (	".$comit_pendientes[0].",'../aplicaciones/comite/aprobacion.php?id_comite=".$comit_pendientes[0]."','MODULO COMITE','".$numero_comite."','Tiene Solicitudes pendientes por aprobacion', '".$comit_pendientes[5]."',3)");
		
		}
	//fin comite
	
	//ratificacion presidente
	
	if($_SESSION["id_us_session"] == $presidente){
		$sel_comites = query_db("select id_comite, num1,num2,num3, fecha from t3_comite where presidente <> 1 and estado = 1");
		
		while($sel_com = traer_fila_db($sel_comites)){
			$numero_comite = numero_item_pecc($sel_com[1],$sel_com[2],$sel_com[3]);
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo) values (	".$sel_com[0].",'../aplicaciones/comite/aprobacion.php?id_comite=".$sel_com[0]."','MODULO COMITE','".$numero_comite."','Este Comit&eacute; esta Pendiente por Verificar', '".$sel_com[4]."',3)");
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
 				if($ls[10]==$_SESSION["id_us_session"]){//SI ES EL DUEÑO DEL PROCESO
                    $muestra_proceso=1;
                    } //SI ES EL DUEÑO DEL PROCESO
            
                if($ls[13]==$_SESSION["id_us_session"]){//SI ES EL DUEÑO DEL PROCESO
                    $muestra_proceso=1;
                    } //SI ES EL DUEÑO DEL PROCESO
            				
			if($muestra_proceso==1){ //si se debe mostrar
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo) 
			values (	".$ls[0].",'carga_urna(".$ls[0].")','MODULO URNA VIRTUAL','".$ls[7]."','Estado del proceso: $ls[9] fecha de cierre $ls[5]', '".$ls[5]."',4)");
				
				}//si se debe mostrar
				
				}
				
				mysql_close();
	
	// urna virtual
	//inicio contratos
	$arr_estado = 'null';
	
	$sel_permisos = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$_SESSION["id_us_session"]." and id_permiso=26";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));
	if($sql_sel_permisos[0]>0){
		$arr_estado = $arr_estado.",".$est_abastecimiento.",".$est_sap.",".$est_revision.",".$est_firma_hocol.",".$est_firma_contratista.",".$est_gerente_contrato.",".$est_legalizacion.",".$est_poliza;
	}
	
	$sel_permisos = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$_SESSION["id_us_session"]." and id_permiso=12";
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
			
			
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo) 
			values (	".$lista_contrato[0].",'../aplicaciones/contratos/menu_contrato.php?id=".arreglo_pasa_variables($lista_contrato[0])."','CONTRATOS','".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4)."','Estado del proceso:".estado_contrato_retu(arreglo_pasa_variables($lista_contrato[0]),$co1)."', '',5)");
	}
	/* inicio modificaciones con estado individual
	$lista_contrato = "select t7c.id,t7c.id_contrato,t1t.nombre from $co4 t7c left join t1_tipo_complemento t1t on t7c.tipo_complemento=t1t.id where t7c.estado <> $est_finalizado and t7c.estado in ($arr_estado)";
	$sql_contrato=query_db($lista_contrato);
	while($lista_contrato=traer_fila_row($sql_contrato)){
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo) 
			values (	".$lista_contrato[1].",'../aplicaciones/contratos/menu_contrato.php?id=".arreglo_pasa_variables($lista_contrato[1])."','CONTRATOS','".consecutivo_bl($lista_contrato[1])."','Estado del proceso:".$lista_contrato[2]." ".estado_contrato_retu(arreglo_pasa_variables($lista_contrato[0]),$co4)."', '',5)");
	}
	 fin modificaciones con estado individual*/
	 $lista_contrato = "select t7c.id_contrato,t1t.nombre,t7co.creacion_sistema,t7co.consecutivo,t7co.apellido from $co4 t7c left join t1_tipo_complemento t1t on t7c.tipo_complemento=t1t.id left join t7_contratos_contrato t7co on t7c.id_contrato=t7co.id where t7c.estado <> $est_finalizado and t7c.estado in ($arr_estado) group by t7c.id_contrato,t1t.nombre,t7co.creacion_sistema,t7co.consecutivo,t7co.apellido";
	$sql_contrato=query_db($lista_contrato);
	while($lista_contrato=traer_fila_row($sql_contrato)){
			$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
			$separa_fecha_crea = explode("-",$lista_contrato[2]);//fecha_creacion
			$ano_contra = $separa_fecha_crea[0];					
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $lista_contrato[3];//consecutivo
			$numero_contrato4 = $lista_contrato[4];//apellido
			
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo) 
			values (	".$lista_contrato[0].",'../aplicaciones/contratos/menu_contrato.php?id=".arreglo_pasa_variables($lista_contrato[0])."','CONTRATOS','".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4)."','Estado del proceso:".$lista_contrato[1]." Pendiente Modificaciones', '',5)");
	}
	//fin contratos
	
	//$inserta_datos = query_db("insert into #alertas (id_proceso,destion,modulo,consecutivo,detalle) values (	1,2,'MODULO TARIFAS','C-2012-001','Tiene tarifas pendientes de aprobación')");

//crear_en_e_procurement(2);


 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Expires" content="0" />
 <meta http-equiv="Pragma" content="no-cache" />
<title><?=TITULO;?></title>

<script type="text/javascript" src="../librerias/ajax/ajax_01.js"></script>
<script type="text/javascript" src="../librerias/js/puntos.js"></script>
<script type="text/javascript" src="../librerias/js/procesos_generales.js"></script>
<script type="text/javascript" src="../librerias/js/tarifas_admin.js"></script>
<script type="text/javascript" src="../librerias/js/contratos_admin.js"></script>
<script type="text/javascript" src="../librerias/js/pecc-item_admin.js" charset="utf-8"></script>
<script type="text/javascript" src="../librerias/js/comite_admin.js" charset="utf-8"></script>
<script type="text/javascript" src="../librerias/js/indicador_admin.js" charset="utf-8"></script>

<script type="text/javascript" src="../librerias/jquery/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../librerias/jquery/jquery-ui-1.8.13.custom.min.js"></script>

<script type='text/javascript' src='../librerias/jquery/autocomplete/lib/jquery.ajaxQueue.js' charset='iso-8859-1'></script>
<script type='text/javascript' src='../librerias/jquery/autocomplete/lib/thickbox-compressed.js' charset='iso-8859-1'></script>
<script type='text/javascript' src='../librerias/jquery/autocomplete/jquery.autocomplete.js' charset='iso-8859-1'></script>
<link rel="stylesheet" type="text/css" href="../librerias/jquery/autocomplete/jquery.autocomplete.css" />
<link rel="stylesheet" type="text/css" href="../librerias/jquery/autocomplete/lib/thickbox.css" />

<script type="text/javascript" src="../librerias/jquery/calendario/jquery-ui-timepicker-addon.js"></script>



<link rel="stylesheet" type="text/css" href="../librerias/jquery/calendario/jquery-ui-1.8.13.custom.css" />



</style>

<script type="text/javascript">
function modal_lanza(){
$(function() {
$('a[rel*=leanModal222]').leanModal({ top : 200 });
});
}


</script>




<script>



if(history.forward(1)){
// history.replace(history.forward(1));
alert("aqui")
 }
 

/*funcion para seleccionar lista*/
function selecciona_lista_general_irre(id,ruta)
{

$().ready(function() {

function log(event, data, formatted) {
		$("<li>").html( !data ? "No match!" : "Selected: " + formatted).appendTo("#result");
	}

	function formatItem(row) {
		return row[0] + " (<strong>id: " + row[1] + "</strong>)";
	}
	function formatResult(row) {
		return row[0].replace(/(<.+?>)/gi, '');
	}
	


	$("#" + id).autocomplete(ruta, {
		
		width: 660,
		selectFirst: true,
		max: 1000,
		scroll: true,
		scrollHeight: 300,
		autoFill: false	,
		multiple: true,
		mustMatch: true,
		matchContains: true
	
	});
	
	

	
});
}

 function selecciona_lista(campo_seleccio) {

        $().ready(function() {

            function log(event, data, formatted) {
                $("<li>").html(!data ? "No match!" : "Selected: " + formatted).appendTo("#result");
            }

            function formatItem(row) {
                return row[0] + " (<strong>id: " + row[1] + "</strong>)";
            }
            function formatResult(row) {
                return row[0].replace(/(<.+?>)/gi, '');
            }


	/*nombre y ajax del campo a buscar*/	
            $("#categoria_busca").autocomplete("../librerias/php/tarifas_autocompleta_categorias.php", {

                width: 660,
                selectFirst: true,
                max: 1000,
                scroll: true,
                scrollHeight: 300,
                autoFill: false,
                multiple: true,
                mustMatch: true,
                matchContains: true

            });
			
	/*nombre y ajax del campo a buscar*/
	/*cargar_PROVEEDORES EN GENERAL*/	
            $("#proveedores_busca").autocomplete("../librerias/php/proveedores_general.php", {

                width: 660,
                selectFirst: true,
                max: 1000,
                scroll: true,
                scrollHeight: 300,
                autoFill: false,
                multiple: true,
                mustMatch: true,
                matchContains: true

            });
			
	/*cargar_PROVEEDORES EN GENERAL*/
	/*cargar_usuarios_general*/	
            $("#usuario_permiso").autocomplete("../librerias/php/usuarios_general.php", {

                width: 660,
                selectFirst: true,
                max: 1000,
                scroll: true,
                scrollHeight: 300,
                autoFill: false,
                multiple: true,
                mustMatch: true,
                matchContains: true

            });
			
	/*cargar_usuarios_general*/
	
	/*CARGAR CONTRATOS NORMALES NO MARCOS*/	
            $("#contratos_normales").autocomplete("../librerias/php/contratos_normales_no_marco.php", {

                width: 660,
                selectFirst: true,
                max: 1000,
                scroll: true,
                scrollHeight: 300,
                autoFill: false,
                multiple: true,
                mustMatch: true,
                matchContains: true

            });
			
	/*FIN CARGAR CONTRATOS NORMALES NO MARCOS*/
	
	/*nombre y ajax del campo a buscar*/	
            $("#tarifas_busca_contratos").autocomplete("../librerias/php/tarifas_autocompleta_contratos.php", {

                width: 660,
                selectFirst: true,
                max: 1000,
                scroll: true,
                scrollHeight: 300,
                autoFill: false,
                multiple: true,
                mustMatch: true,
                matchContains: true

            });
	/*nombre y ajax del campo a buscar*/	

	/*nombre y ajax del campo a buscar tarifas maestras*/	
            $("#" + campo_seleccio).autocomplete("../librerias/php/tarifas_autocompleta_tarifas_maestras.php", {

                width: 660,
                selectFirst: true,
                max: 1000,
                scroll: true,
                scrollHeight: 300,
                autoFill: false,
                multiple: true,
                mustMatch: true,
                matchContains: true

            });
	/*nombre y ajax del campo a buscar*/		
	
	   });


	   
	}
			


/*funcion para seleccionar lista poner el id del campo*/	

/*funcion para calendario*/
	function calendario_se(obje){
			$(function(){
				$('#' + obje).datetimepicker({
					numberOfMonths: 1,
					dateFormat: 'yy-mm-dd',
					timeFormat: 'hh:mm:ss'


				});
			});
}	

	function calendario_sin_hora(obje){
			$(function(){
				$('#' + obje).datepicker({
					numberOfMonths: 1,
					dateFormat: 'yy-mm-dd'

				});
			});
}		
/*funcion para calendario*/
function mueve(){
alert(document.datos2.scrollLeft)
}

function abrir_ventana(pagina) {

 var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=800, height=365, top=85, left=140";
 window.open(pagina,"",opciones);
 }

</script>

<link href="../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body >

<div id="cargando_pecc"  style="display:none"><table width="100%" height="1000" align="center" border="0"><tr><td align="center" valign="middle"><img src="../imagenes/botones/cargando2.gif" width="320" height="250" /></td></table></div>

<?=banner();?>
<form name="principal" method="post" enctype="multipart/form-data">


<table width="100%" border="0" cellspacing="2" cellpadding="2">

  <tr>
    <td width="1" valign="top" id="contenido_menu">
      <table width="187" border="0" cellspacing="2" cellpadding="2">
    <tr>
        <td width="28" class="fondo_1" align="center"><div align="center">0</div></td>
        <td colspan="2" align="center" class="fondo_2" onClick="window.parent.location.href='administracion.html'"><div align="left">Menu SGPA</div></td>
        </tr>
    <tr>
      <td class="fondo_1" align="center">1</td>
      <td colspan="2" align="center" class="fondo_2" onClick="taer_menu('menu-pecc.html','contenido_menu')"><div align="left">Modulo PECC</div></td>
    </tr>
    <tr>
      <td class="fondo_1" align="center">2</td>
      <td colspan="2" align="center" class="fondo_2" onClick="taer_menu('menu-item.html','contenido_menu')"><div align="left">Modulo SOLICITUDES</div></td>
    </tr>
    <tr>
      <td class="fondo_1" align="center">3</td>
      <td colspan="2" align="center" class="fondo_2" onClick="taer_menu('menu-comite.html','contenido_menu')"><div align="left">Modulo COMITE</div></td>
    </tr>
    <tr>
      <td class="fondo_1" align="center">4</td>
      <td colspan="2" align="center" class="fondo_2" onClick="window.parent.location.href='../enterproc/administracion-general/principal.html'"><div align="left">Modulo URNA VIRTUAL</div></td>
    </tr>
    <tr>
      <td class="fondo_1" align="center">5</td>
      <td colspan="2" align="center" class="fondo_2" onClick="taer_menu('menu-contratos.html','contenido_menu')"><div align="left">Modulo CONTRATOS</div></td>
    </tr>
    <tr>
      <td class="fondo_1" align="center">6</td>
      <td colspan="2" align="center" class="fondo_2" onClick="taer_menu('menu-tarifas.html','contenido_menu')"><div align="left">Modulo TARIFAS</div></td>
    </tr>
      
        <tr>
          <td class="fondo_1" align="center">7</td>
          <td class="fondo_2" onClick="taer_menu('menu-indicador.html','contenido_menu')">Modulo INDICADORES</td>
        </tr>
        
        <tr>
          <td width="17%" class="fondo_1" align="center">8</td>
          <td width="83%" class="fondo_2" onClick="ajax_carga('administracion-usuario.html','contenidos')">Admin. usuarios</td>
        </tr>
<!--
        <tr>
          <td class="fondo_1"><div align="center">9</div></td>
          <td class="fondo_2">Admin. proveedores</td>
        </tr>
    -->    
        <tr>
          <td class="fondo_1"><div align="center">9</div></td>
          <td class="fondo_2" onClick="ajax_carga('modulo-historico-tarifas.php','div_contenidos_carga')">Admin. maestras</td>
        </tr>
        

        <tr>
          <td class="fondo_1"><div align="center"></div></td>
          <td class="fondo_2" onClick="window.parent.location.href='../'">Salida Segura</td>
        </tr>
    </table></td>
    <td width="100%" valign="top" >
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
            <td width="2%" class="esquina_s_iz">&nbsp;</td>
            <td width="95%" class="linea_sup">&nbsp;</td>
            <td width="3%"  class="esquina_s_der">&nbsp;</td>
          </tr>
          <tr>
            <td class="linea_iz">&nbsp;</td>
            <td id="contenidos" align="left">
            
            
            
<table width="100%" border="0"  cellspacing="2" cellpadding="2">
  <tr class="titulos_secciones">
    <td class="titulos_secciones">SECCION: ALERTAS GENERALES DE LOS MODULOS</td>
  </tr>
</table>
<br />
<?
/*ERREGLO PAGINADOR*/
	
	$factor_b_c = 300;
	$factor_b = 300;
	if($pagina<=1){//si no tiene pagina seleccionada
		$inicio = 0;
		
		}
	else{
		
		 $inicio= (($pagina-1)*$factor_b);
		$factor_b =( $factor_b * ($pagina-1)) + $factor_b;
		}

 	 $sql_cuenta2 = "select  count(*) from #alertas where id_proceso >=1 $complemento ";
	 $sql_cuenta=traer_fila_row(query_db($sql_cuenta2));
	 $lista_pagina = ceil( ( $sql_cuenta[0] / $factor_b_c ) );
	
/*ERREGLO PAGINADOR*/	
?>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="4" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%"><div align="left">Tareas pendientes: <?=$sql_cuenta[0];?></div></td>
        <td width="7%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=($pagina-1);?>,'../aplicaciones/tarifas/modulo-historico-contratos.php','contenidos')">Anterior</a></div></td>
        <td width="8%"><label>
          <select name="pagina" onChange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/tarifas/modulo-historico-contratos.php','contenidos')">
            <? 
		  for($i=1;$i<=$lista_pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pagina) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </label></td>
        <td width="7%"><a href="javascript:busqueda_paginador_nuevo(<?=($pagina+2);?>,'../aplicaciones/tarifas/modulo-historico-contratos.php','contenidos')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="20%" class="columna_subtitulo_resultados"><div align="center">Modulo</div></td>
    <td width="15%" class="columna_subtitulo_resultados"><div align="center">Consecutivo</div></td>
    <td width="58%" class="columna_subtitulo_resultados"><div align="center">Descripci&oacute;n</div></td>
    <td width="7%" class="columna_subtitulo_resultados"><div align="center">Ingresar</div></td>
  </tr>
  
<?




 $busca_item = "select * from (
select id_proceso,destino,modulo,consecutivo,detalle, ROW_NUMBER() OVER(ORDER BY numero_modulo) AS rownum,numero_modulo from #alertas where id_proceso >=1   $complemento   ) as sub where rownum > $inicio and rownum <= $factor_b 
order by numero_modulo asc, modulo desc";	  

	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){
		
		$link =$ls_mr[1];
		
		if($ls_mr[2] == "MODULO SOLICITUDES" or $ls_mr[2] == "MODULO PECC" or  $ls_mr[2] == "MODULO COMITE"){
			$link='ajax_carga("'.$ls_mr[1].'","contenidos")';
			}
		if($ls_mr[2] == "MODULO CONTRATOS"){//para los que son elaboracion de contratos
			$link='ajax_carga("'.$ls_mr[1].'","contenidos")';
			}
			
			
			
		if($ls_mr[2] == "CONTRATOS"){
			$link='taer_menu("'.$ls_mr[1].'","contenido_menu")';
			}

?>  
  
  <tr class="filas_resultados">
    <td class="filas_resultados"><?=$ls_mr[2];?></td>
    <td class="filas_resultados"><?=$ls_mr[3];?></td>
    <td class="filas_resultados"><?=htmlentities($ls_mr[4]);?></td>
    <td class="titulos_resumen_alertas"><div align="center">
    <img src="../imagenes/botones/editar.jpg" width="14" height="15" onclick='<?=$link;?>' /></div></td>
  </tr>
  
  <? } ?>
  
  <tr>
    <td colspan="4" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%"><div align="left">Tareas pendientes:
          <?=$sql_cuenta[0];?></div></td>
        <td width="7%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
        <td width="8%"><label>
          <select name="pagij2" onChange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
            <? 
		  for($i=1;$i<=10;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
          </select>
        </label></td>
        <td width="7%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/historico_procesos.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
      </tr>
    </table></td>
  </tr>
</table>            
            
            
            
            
            </td>
            <td class="linea_der">&nbsp;</td>
          </tr>
          <tr>
            <td  class="esquina_i_iz">&nbsp;</td>
            <td  class="linea_infe">&nbsp;</td>
            <td   class="esquina_i_der">&nbsp;</td>
          </tr>
        </table>
  
    </td>
  </tr>
  <tr>
    <td colspan="2">
    



    
    </td>
  </tr>
</table>

<div  class="fondo_cabecera">
      <table width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td><img src="../imagenes/coorporativo/logo final-01.png" width="133" height="36" /></td>
          <td class="letra_azul_pequena">Si tiene problemas con la funcionabilidad del sistema por favor comun&iacute;quese al PBX (57 1 548 1726),
Dise&ntilde;ado y Desarrollado por Enterprise Technological Innovation S.A.S. Bogot&aacute; 2011.</td>
        </tr>
      </table>
</div>
<input type="hidden" name="accion" />
<input type="hidden" name="id_procurement_alerta" />
</form>

<iframe name="grp" frameborder="1" height="0" width="0"></iframe>

<?

//adjudicacion de solicitud si se pega
/*
$id_item_pecc = "537";
$sel2 = query_db("select aprobado, num3,id_item from $pi2 where id_item in (".$id_item_pecc.")");
while($sel = traer_fila_db($sel2)){
	if($id_item_pecc != "" and $sel[0] == 2){
		crea_contratos_si_no_funciona($sel[2]);//contratos normales
		//crea_contratos_marco($sel[2]);//contratos marco
		echo "Ya creo los contratos sol N°. ".$sel[1]."<br />";
	}else{
		echo " No Creo Nada";
		}
}
*/
// FIN adjudicacion de solicitud si se pega




//acciona comite si se pega 


/*
$id_comite = 8;
$fecha_comite_pegado = "2013-06-05";
$selec_comite = traer_fila_row(query_db("select * from $c1 where id_comite =".$id_comite));
$sele_item_pendientes_sql = query_db("select * from $vcomite2 where id_comite =".$id_comite." and estado = 1");//SELEECIONE TODAS LAS SOLICITUDES DEL COMITE
			while($s_pen = traer_fila_db($sele_item_pendientes_sql)){
				$id_item_aproba = $s_pen[0];
				$sele_items = traer_fila_row(query_db("select * from $pi2 where id_item = ".$id_item_aproba));
				$estado_actividad_actual = $sele_items[14];
				$permiso_ad = 1;
				if($estado_actividad_actual == 17){
						$permiso_ad = 2;
					}
				
				$select_aprobacion = traer_fila_row(query_db("select count(*) from $c4 where id_comite=".$id_comite." and id_item = ".$id_item_aproba." and (aprobacion = 1 or aprobacion = 4)"));//CUENTE LAS APROBACIONES
				
				$cuantas_aprobaciones = 10;
				if($selec_comite[11] == "virtual"){
					$cuantas_aprobaciones = 3;
					}
				if($selec_comite[11] == "presencial"){
					$cuantas_aprobaciones = 0;
					}
					
				$select_rechazadas = traer_fila_row(query_db("select count(*) from $c4 where id_comite=".$id_comite." and id_item = ".$id_item_aproba." and aprobacion = 2"));//CUENTE LAS Rechazadas
					
				//echo $select_aprobacion[0]." - ".$cuantas_aprobaciones." - ".$select_rechazadas[0]."<br />";
					
				if($select_aprobacion[0]>$cuantas_aprobaciones and $select_rechazadas[0] == 0){//SI ES APROBADO
				echo $id_item_aproba;
				agrega_gestion_pecc($id_item_aproba, $estado_actividad_actual, $fecha_comite_pegado, 0);
				$sel_estado = traer_fila_row(query_db("select min(actividad_estado_id) from $vpeec3 where id_item=".$id_item_aproba." and actividad_estado_id > ".$estado_actividad_actual));
				echo $estado_item."<br />";
				$estado_item = $sel_estado[0];
				$estado_firma = 1;
				if($estado_item < 10 and $sele_items[6] <> 7 and $sele_items[6] <> 8){//SI ES EL PERMISO
				crea_antecedente_auto($id_item_aproba, "aprueba_permiso", "");
				echo "apriba ".$id_item_aproba;
				}
				}else{//SI NO ES APROBADO
				if($pendiente == "NO"){
				$estado_firma = 2;
				echo "rechaza ".$id_item_aproba;
				agrega_gestion_pecc_atras($id_item_aproba, $estado_actividad_actual, $fecha_comite_pegado, 0);
				$sel_estado = traer_fila_row(query_db("select max(actividad_estado_id) from $vpeec3 where id_item=".$id_item_aproba." and actividad_estado_id < ".$estado_actividad_actual." and (t2_nivel_servicio_encargado_id = 2)"));
				$estado_item = $sel_estado[0];
				//cambia_pendiente otras aprobaciones
				$sel_todas_las_secuencias = query_db("select * from $pi14 where id_item_pecc =".$id_item_aproba." and tipo_adj_permiso =$permiso_ad and id_rol not in (15,10)");
				
		while($sel_sucun = traer_fila_db($sel_todas_las_secuencias)){
			$update_aprobas = query_db("update $pi16 set aprobado = 3 where id_secuencia_solicitud = ".$sel_sucun[0]);
		}	
		//fin cambia aprobaciones
		$upda_2 = query_db("update $c2 set estado = 4 where id_comite =".$id_comite." and id_item=".$id_item_aproba."");
				
				}else{
					$estado_item = $estado_actividad_actual;
					}
				}
				
				
				
				if($estado_item == 19){//SI YA PASO A SOLICITUD PAR, ENTONCS YA TERMINO
				
					$sel_que_aplica_procurement_contras = traer_fila_row(query_db("select esta_en_e_procurement,t1_tipo_proceso_id from $pi2 where id_item=".$id_item_aproba));
					
					if($sel_que_aplica_procurement_contras[1] == 1 or $sel_que_aplica_procurement_contras[1] == 2 or $sel_que_aplica_procurement_contras[1] == 3 or $sel_si_aplica_procurement[1] == 6){//SI APLICA EN Contratos
					$es_marco = verifica_solicitud_marcos($id_item_aproba);
					if($es_marco == "NO"){
						crea_contratos($id_item_aproba);
					}else{
						crea_contratos_marco($id_item_aproba);
						}
						
						}
					
					if($sel_que_aplica_procurement_contras[0] == 1){//SI APLICA EN EPROCUREMENT
//						crear_en_e_procurement($id_item_aproba);//FUNCION PARA CREARLO EN EPROCUREMENT
						}
					
					if($sel_que_aplica_procurement_contras[1] == 4 or $sel_que_aplica_procurement_contras[1] == 5){//SI ES OTRO SI
						crea_otro_si($id_item_aproba);

						}
					if($sel_que_aplica_procurement_contras[1] == 8){//SI ES OT
						crea_ots($id_item_aproba);
						}
					if($sel_que_aplica_procurement_contras[1] == 7){//SI ES ampliacion
						crea_ampliacion($id_item_aproba);
						}
						
						$upda_item = query_db("update $pi2 set estado=20 where id_item=".$id_item_aproba);
					
		}	//SI YA PASO A SOLICITUD PAR, ENTONCS YA TERMINO
		if($estado_item != 19){
		$upda_item = query_db("update $pi2 set estado=".$estado_item." where id_item=".$id_item_aproba);
		}
				//pone accion en firmas en el sistema
				$sel_secuencia = traer_fila_row(query_db("select * from $pi14 where id_rol=10 and id_item_pecc=".$id_item_aproba." and tipo_adj_permiso =$permiso_ad"));
				
	$insert = query_db("insert into $pi16 (id_secuencia_solicitud, id_us,fecha, aprobado,observacion) values (".$sel_secuencia[0].",".$selec_comite[1].", '$fecha_comite_pegado', $estado_firma,'Ver Firmas en el Comit&eacute; No. ".numero_item_pecc($selec_comite[6],$selec_comite[7],$selec_comite[8])."')");
				//fin pone accion en firmas en el sistema
			}
	*/		
			//FIN acciona comite si se pega 
			
			
			
			
			
			
			
			
			
			/*
			$sel_complementos = query_db("select id, id_item_pecc from t7_contratos_complemento");
			while($sel_comples = traer_fila_db($sel_complementos)){
					$sel_item = traer_fila_row(query_db("select * from t2_item_pecc where id_item =  ".$sel_comples[1]));
					$actualiza = query_db("update t7_contratos_complemento set gerente = ".$sel_item[3]." where id = ".$sel_comples[0]);
				}
			*/
				
				

			
?>


</body>
</html>
