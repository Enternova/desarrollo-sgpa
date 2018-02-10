<? include("../../librerias/lib/@session.php");

$comple_alert = "";


$_SESSION["usuarios_array"] = "";
	$_SESSION["usuarios_con_reemplazo"] = "";
	$usuarios_con_reemplazo="";
	$usuarios_array="";
	
	 $usuarios_con_reemplazo = $_SESSION["id_us_session"];
	 $usuarios_array= array($_SESSION["id_us_session"]);

if($_GET["filtro_modulo"] <> "" and $_GET["filtro_modulo"] <> "0" ){
		$comple_alert = $comple_alert." and modulo = '".$_GET["filtro_modulo"]."'";
	}
if($_GET["filtro_consecutivo"] <> "" and $_GET["filtro_consecutivo"] <> "0" ){
		$comple_alert = $comple_alert." and consecutivo like '%".$_GET["filtro_consecutivo"]."%'";
	}
if($_GET["filtro_usuario"] <> "" and $_GET["filtro_usuario"] <> "0" ){
		$comple_alert = $comple_alert." and id_usuario = '".$_GET["filtro_usuario"]."'";
	}
if($_GET["filtro_descripcion"] <> "" and $_GET["filtro_descripcion"] <> "0" ){
		$comple_alert = $comple_alert." and detalle = '".$_GET["filtro_descripcion"]."'";
	}
	
if($_GET["fecha_aprobacion"] <> ""){
		$comple_alert = $comple_alert." and fecha_aprobacion = '".$_GET["fecha_aprobacion"]."'";
	}
	
if($_GET["incluir_cargar_masivas"] == "Se inhactiva este filtro" or $_GET["incluir_cargar_masivas"] == 2){
		$comple_alert = $comple_alert." and nivel_aprobacion != 'N/A - N/A -'";
		$_GET["incluir_cargar_masivas"] = 2;
	}
	
if($_GET["filtro_profesional"] != ""){
		$comple_alert = $comple_alert." and profesionalcyc = '".$_GET["filtro_profesional"]."'";
	}


	
if($_GET["filtro_nivel"] <> "0" and $_GET["filtro_nivel"] <> "" ){
	$filtro_res_tilde = str_replace("é", "&eacute;", $_GET["filtro_nivel"]);
	$filtro_res_tilde = str_replace("á", "&aacute;", $filtro_res_tilde);
	$filtro_res_tilde = str_replace("í", "&iacute;", $filtro_res_tilde);
	$filtro_res_tilde = str_replace("ó", "&oacute;", $filtro_res_tilde);
	$filtro_res_tilde = str_replace("ú", "&uacute;", $filtro_res_tilde);
	
		$comple_alert = $comple_alert." and nivel_aprobacion like '%".$filtro_res_tilde."%'";
	}
	

	      
	
	$crea_tempo = "CREATE TABLE #alertas (id_proceso int, destino varchar(5000),modulo varchar(50), consecutivo varchar(50), detalle varchar(500), fecha_recibido varchar(10), numero_modulo int, id_usuario int, nivel_aprobacion varchar(1000), fecha_aprobacion varchar(10), profesionalcyc varchar(1000))";
	$sql_te = query_db($crea_tempo);


	//alertas item


if($_SESSION["id_us_session"] == 18591){
	
	$comple_sql_almace=" and t1_area_id in (17,24,21)";
	}

	$sele_pecc_item = query_db("select  id_item, num1, num2, num3, fecha_cuando_se_agendo, descrip1, descrip2, descrip3, id_pecc, estado, congelado, t2_nivel_servicio_encargado_id, nombre, id_us,id_us_profesional_asignado, contrato_id, t1_tipo_proceso_id, t1_area_id, t1_tipo_contratacion_id from v_alertas_pecc_item where id_pecc = 1 and estado < 21 and (congelado is null or congelado !=1) $comple_sql_almace");
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
		
		
		
		
				
		
		
		if($sel_item[11] == 11){//estado elaboracion de contrato
				
				
		if($sel_item[16] == 8){//si es OT en elaboracion de contrato
			if($_SESSION["id_us_session"] == 18245 and $sel_item[13] == 18245){// si es tatiana
			$es_encargado = "SI";				
			}
			
			if($_SESSION["id_us_session"] == 57 and $sel_item[13] <> 18245){// si es amparo

			$es_encargado = "SI";				
			}
			
			}else{// si es elaboracion de contrato de cualquier otro tipo de solicitud
				$sel_us_elaboracion_contra = traer_fila_row(query_db("select us_id, usuario, id_modulo, modulo, id_premiso, permiso, id_tipo_permiso, tipo_permiso, id_area, nombre_administrador
 from v_seg1 where us_id = ".$_SESSION["id_us_session"]." and id_premiso = 32"));
					if($sel_us_elaboracion_contra[0]>0){
					$es_encargado = "SI";
					}		
				}
			
		
					
					
					
					
		}
		
		$contras_solic = "";
		$aprobacion_nivel="";
		if($sel_item[9] ==20 ){
		$modulo_aplica = "MODULO CONTRATOS";
		$sele_contras_elab = query_db("select consecutivo,creacion_sistema,apellido, id from t7_contratos_contrato where id_item = ".$sel_item[0]);
					
					while($sel_cont = traer_fila_db($sele_contras_elab)){
						
							$numero_contrato1 = "C";			
							$separa_fecha_crea = explode("-",$sel_cont[1]);
							$ano_contra = $separa_fecha_crea[0];					
							$numero_contrato2 = substr($ano_contra,2,2);
							$numero_contrato3 = $sel_cont[0];
							$numero_contrato4 = $sel_cont[2];
							$contras_solic = $contras_solic." - ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_cont[3]);

						}
				if($contras_solic == ""){		//si es orden de trabajo o ampliacion y la solicitud estado 20	
				$sele_presupuesto = traer_fila_row(query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$sel_item[0]."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id"));
				
				$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sele_presupuesto[0]);
			while($sel_apl = traer_fila_db($sel_contr)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					$contras_solic = $contras_solic." - ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_apl[3]);
				
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
					$contras_solic = $contras_solic." - ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_item["contrato_id"]);
	}
	
	$aprobacion_nivel =  nivel_aprobacion_solicitud($sel_item[0], "adjudicacion");
	
					$cuantos_caracteres = strlen($aprobacion_nivel);
					$cuantos_caracteres = $cuantos_caracteres - 13;
					$aprobacion_nivel_su = substr($aprobacion_nivel,0,$cuantos_caracteres);
					
					$aprobacion_nivel_expl = explode("-",$aprobacion_nivel);
					$aprobacion_nivel_expl_comite = explode(". ",$aprobacion_nivel);
					//echo "-".$aprobacion_nivel_expl[0]."-";
					if($aprobacion_nivel_expl[0] == "Vicepresidente "){
						
						if($sel_item[17]==24 or $sel_item[17]==25){
							$aprobacion_nivel = "Vp. Producci&oacute;n y  Operaciones";
							}elseif($sel_item[17]==17 or $sel_item[17]==18){
								$aprobacion_nivel = "V.p. Exploraci&oacute;n y Desarrollo de Negocios";
								}elseif($sel_item[17]==26 or $sel_item[17]==20 or $sel_item[17]==21 or $sel_item[17]==22){
								$aprobacion_nivel = "Vp. T&eacute;cnica";
								}elseif($sel_item[17]==1 or $sel_item[17]==14 or $sel_item[17]==2 or $sel_item[17]==30 or $sel_item[17]==13 or $sel_item[17]==12){
								$aprobacion_nivel = "Vp. Financiera y Administrativa";
								}elseif($sel_item[17]==4 or $sel_item[17]==5 or $sel_item[17]==6 or $sel_item[17]==7 or $sel_item[17]==3 or $sel_item[17]==8 or $sel_item[17]==9 or $sel_item[17]==15 or $sel_item[17]==23 or $sel_item[17]==19){
								$aprobacion_nivel = "Presidente";
								}else{
								$aprobacion_nivel = "Vicepresidente";
							}
						
						}elseif($aprobacion_nivel_expl[0] == "Comit&eacute; "){
							$aprobacion_nivel = "Comit&eacute; ".$aprobacion_nivel_expl_comite[1];
							}else{
							$aprobacion_nivel=$aprobacion_nivel_su;
							}
		
		}

				
				if($es_encargado == "SI"){
					
					$sel_fecha_aprobacion = traer_fila_row(query_db("select max(t2.fecha) from t2_agl_secuencia_solicitud as t1, t2_agl_secuencia_solicitud_aprobacion as t2 where t1.id_secuencia_solicitud = t2.id_secuencia_solicitud and t2.aprobado=1 and t1.estado=1 and t1.id_item_pecc = ".$sel_item[0]));
	
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion,fecha_aprobacion, profesionalcyc) values (".$sel_item[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_item[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','".$modulo_aplica."','".$numero."','Sección: ".$sel_item[6].". Tarea: ".$sel_item[7].$contras_solic."', '".$sel_item[4]."',2, '".$sel_item[13]."','".$aprobacion_nivel."','".$sel_fecha_aprobacion[0]."', '".saca_nombre_lista($g1,$sel_item[14],'nombre_administrador','us_id')."')");
				}
				
		}	
		//VERIFICA DEVUELTOS Y ESTADO EN PREPARACION 31
				
				$sel_usu_emulan = query_db("select  id, id_us, id_us_emula from t2_relacion_usuarios_emulan where id_us = ".$_SESSION["id_us_session"]);
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
				$sel_item_en_preparacion_devuelto = query_db("select id_item, num1,num2,num3, t1_tipo_proceso_id,id_us, id_us_profesional_asignado from $pi2 where num1 <> '' and id_us in (".$id_us_alerta.") and estado = 31 and (congelado <> 1 or congelado is null)");
				while($sel_devueltos_31 = traer_fila_row($sel_item_en_preparacion_devuelto)){
					
					$numero = numero_item_pecc($sel_devueltos_31[1],$sel_devueltos_31[2],$sel_devueltos_31[3]);
					
					if($sel_devueltos_31[4] == 7){

					$id_tipo_proceso_pecc = 2;
				}
			if($sel_devueltos_31[4] == 8){
					$id_tipo_proceso_pecc = 3;
				}

						
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion,fecha_aprobacion, profesionalcyc) values (".$sel_devueltos_31[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_devueltos_31[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','MODULO SOLICITUDES','".$numero."','Sección: Solicitud de Permiso. Tarea: Ajustar por Devolución', '2012-01-01',2, '".$sel_devueltos_31[5]."','','','".saca_nombre_lista($g1,$sel_devueltos_31[6],'nombre_administrador','us_id')."')");
					}

					$sel_item_en_preparacion_preparacion = query_db("select id_item, num1,num2,num3, t1_tipo_proceso_id,id_us,id_us_profesional_asignado from $pi2 where (num1 is null or num1 = '') and id_us in (".$id_us_alerta.") and estado = 31 and (congelado <> 1 or congelado is null)");
				while($sel_devueltos_31 = traer_fila_row($sel_item_en_preparacion_preparacion)){
					
					if($sel_devueltos_31[4] == 7){

					$id_tipo_proceso_pecc = 2;
				}
			if($sel_devueltos_31[4] == 8){
					$id_tipo_proceso_pecc = 3;
				}
				
				
					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion,fecha_aprobacion , profesionalcyc) values (".$sel_devueltos_31[0].",'../aplicaciones/".$link_aplica_modulo.".php?id_item_pecc=".$sel_devueltos_31[0]."&id_tipo_proceso_pecc=".$id_tipo_proceso_pecc."','MODULO SOLICITUDES','','Sección: Solicitud de Permiso. Tarea: En Preparación', '2012-01-01',2, '".$sel_devueltos_31[5]."','','','".saca_nombre_lista($g1,$sel_devueltos_31[6],'nombre_administrador','us_id')."')");
					}
					
				//Fin VERIFICA DEVUELTOS Y ESTADO EN PREPARACION 31
				
				//estado de informativo de procesos OTs
$sel_si_es = traer_fila_row(query_db("select  us_id, usuario, id_modulo, modulo, id_premiso, permiso, id_tipo_permiso, tipo_permiso, id_area, nombre_administrador from v_seg1 where us_id =".$_SESSION["id_us_session"]." and id_premiso = 38")); // verifica si tiene el permiso necesario

 if($sel_si_es[0] > 0 or $_SESSION["id_us_session"]==69){//si es admin OTs le imprime las solicitudes de OT que se encuentran en firmas

	 $sel_items_firmas_ots = query_db("select id_item, num1,num2,num3, id_gerente_ot, profesionalcyc from t2_item_pecc where estado = 16 and t1_tipo_proceso_id = 8 and (congelado = 2 or congelado is null) and t1_tipo_contratacion_id = 1");
	 
	 while($ots_sel = traer_fila_db($sel_items_firmas_ots)){
		 $numero = numero_item_pecc($ots_sel[1],$ots_sel[2],$ots_sel[3]);

					$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion,fecha_aprobacion, profesionalcyc) values (".$ots_sel[0].",'../aplicaciones/pecc/edicion-item-pecc.php?id_item_pecc=".$ots_sel[0]."&id_tipo_proceso_pecc=3','MODULO SOLICITUDES','".$numero."',' Tarea: Verificar Firmas en el sistema', '2012-01-01',2, '".$ots_sel[4]."','','','".saca_nombre_lista($g1,$ots_sel[5],'nombre_administrador','us_id')."')");
		 
		 
		 }
	 }




//estado de informativo de procesos OTs
				
	//Fin Alertas item
	
	
	
	
	
	//$inserta_datos = query_db("insert into #alertas (id_proceso,destion,modulo,consecutivo,detalle) values (	1,2,'MODULO TARIFAS','C-2012-001','Tiene tarifas pendientes de aprobación')");

//crear_en_e_procurement(2);


$usuario_elaboracion_contrato = traer_fila_row(query_db("select us_id  from v_seg1 where us_id=".$_SESSION["id_us_session"]. " and id_premiso=32"));
			  if($usuario_elaboracion_contrato[0]>0){// rol de tatiana
					 $muestra_columnas_nivel_aprobacion = "SI";
			 
			 }
			 
	$sel_per = "select * from tseg12_relacion_usuario_rol where id_usuario=".$_SESSION["id_us_session"]." and id_rol_general=11";
	$sql_sel_per=traer_fila_row(query_db($sel_per));
	if($sql_sel_per[0]>0){//si es el rol soporte descentralizado
	$complet = " and (f_ini_recibido_ini_proceso = ' ' or f_ini_recibido_ini_proceso = '' or f_ini_recibido_ini_proceso is null) ";
	//	$complet_2 = " and t7c.gerente in (".$contratos_por_usario.")";	
	$detalle_pendiente = "Elaboración de documento pendiente por devolución";
	}		 
			 
 if($detalle_pendiente <> ""){
	$lista_contrato = "select $co1.id,$co1.creacion_sistema,$co1.consecutivo, $co1.apellido, t2.f_ini_firma_rep_legal, t2.f_fin_firma_rep_legal, t2.f_fin_entrega_doc_contrac, t2.f_fin_elabora_pedido, t2.f_fin_aproba_sap  from $co1, v_contratos_alertas_comite as t2 where t7_contratos_contrato.id = t2.id and (analista_deloitte <> 1 or analista_deloitte IS NULL) and $co1.estado < 10 and (t2.f_fin_elaboracion is not null and t2.f_fin_elaboracion <> '' and t2.f_fin_elaboracion <> ' ' ) ".$complet;


	$sql_contrato=query_db($lista_contrato);
	while($lista_contrato=traer_fila_row($sql_contrato)){
			$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
			$separa_fecha_crea = explode("-",$lista_contrato[1]);//fecha_creacion
			$ano_contra = $separa_fecha_crea[0];					
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $lista_contrato[2];//consecutivo
			$numero_contrato4 = $lista_contrato[3];//apellido
			$detalle_pendiente_comple="";


			
			$inserta_datos = query_db("insert into #alertas (id_proceso,destino,modulo,consecutivo,detalle,fecha_recibido,numero_modulo,id_usuario,nivel_aprobacion,fecha_aprobacion, profesionalcyc) 
			values (	".$lista_contrato[0].",'../aplicaciones/contratos/menu_contrato.php?id=".arreglo_pasa_variables($lista_contrato[0])."&da=1','CONTRATOS','".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $lista_contrato[0])."','".$detalle_pendiente."', '',5,0,0,'',0)");
	}
	
	}//si tiene pendientes de legalizacion
			 
			 
			 
			 
 ?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<meta http-equiv="Expires" content="0" />
 <meta http-equiv="Pragma" content="no-cache" />
<title><?=TITULO;?></title>







<?
	if($_GET["paginas"] > 0){
		$pagina = $_GET["paginas"];
		}else{
			$pagina = 1;
			}
		$registros_pagina=30;		
		$regis_final = $pagina * $registros_pagina;		
		$regis_inicial = ($pagina - 1) * $registros_pagina;
		
		

$sql_cuenta = traer_fila_row(query_db("select count(*) from #alertas where id_proceso >=1  $comple_alert "));
$cunatas_paginas = ($sql_cuenta[0] / $registros_pagina) +1;


?>






</head>

<body >


  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
          <td width="2%" class="esquina_s_iz">&nbsp;</td>
          <td width="95%" class="linea_sup">&nbsp;</td>
          <td width="3%"  class="esquina_s_der">&nbsp;</td>
        </tr>
        <tr>
          <td class="linea_iz">&nbsp;</td>
          <td id="contenidos" align="left"><table width="100%" border="0"  cellspacing="2" cellpadding="2">
            <tr class="titulos_secciones">
              <td class="titulos_secciones">SECCION: ALERTAS GENERALES DE LOS MODULOS</td>
            </tr>
          </table>
            <br />
            <?

?>
 <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td colspan="9" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
                  <tr>
                    <td width="39%"><div align="left">Tareas pendientes encontradas:
                      <?=$sql_cuenta[0];?>

                    </div></td>
                    <td width="39%" align="right"><table width="100%" border="0">
                      <tr>
                        <td width="84%" align="right">Paginas:</td>
                        <td width="16%"><select name="paginas" id="paginas" onchange="ajax_carga('../procesos/administrador/alertas_elaboracion.php?paginas='+this.value+'&filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value+'&fecha_aprobacion='+document.principal.fecha_aprobacion.value+'&incluir_cargar_masivas='+document.principal.incluir_cargar_masivas.value+'&filtro_profesional='+document.principal.filtro_profesional.value,'carga_alertas')">
                          <?
      	for($i = 1; $i <= $cunatas_paginas ; $i++){
	  ?>
                          <option value="<?=$i?>" <? if($pagina == $i) echo 'selected="selected"';?> >
                            <?=$i?>
                          </option>
                          <? }?>
                        </select></td>
                      </tr>
                    </table></td>
                  </tr>
                </table></td>
              </tr><input type="hidden" name="incluir_cargar_masivas" id="incluir_cargar_masivas" value="" />
              <?
              /*
			  ?>
              <tr>
                <td colspan="3" align="right" class="columna_subtitulo_resultados">Incluir o no las cargas masivas:</td>
                <td colspan="6" align="left" class="columna_subtitulo_resultados"><select name="incluir_cargar_masivas" id="incluir_cargar_masivas" onchange="ajax_carga('../procesos/administrador/alertas_elaboracion.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value+'&fecha_aprobacion='+document.principal.fecha_aprobacion.value+'&incluir_cargar_masivas='+document.principal.incluir_cargar_masivas.value+'&filtro_profesional='+document.principal.filtro_profesional.value,'carga_alertas')">
                  <option value="2" <? if($_GET["incluir_cargar_masivas"] == 2) echo 'selected="selected"';?>>Filtro: No, Incluir las Cargas Masivas</option>
                  <option value="1" <? if($_GET["incluir_cargar_masivas"] == 1) echo 'selected="selected"';?>>Filtro: Si, Incluir las Cargas Masivas</option>
                </select></td>
              </tr>
			  <?
			  */
			  ?>
              <tr>
                <td width="10%" class="columna_subtitulo_resultados"><div align="center">Modulo</div></td>
                <td colspan="2" class="columna_subtitulo_resultados"><div align="center">Consecutivo</div></td>
               <?
               if($muestra_columnas_nivel_aprobacion == "SI"){
			   ?>
                <td width="11%" align="center" class="columna_subtitulo_resultados">Nivel de Aprobaci&oacute;n</td>
                <?
			   }
				?>
                <td width="13%" align="center" class="columna_subtitulo_resultados">Usuario Solicitante</td>
                <td width="10%" align="center" class="columna_subtitulo_resultados">Profesional de CYC</td>
                <td width="25%" class="columna_subtitulo_resultados"><div align="center">Descripci&oacute;n</div></td>
                <td width="11%" class="columna_subtitulo_resultados" align="center">Fecha de Aprobaci&oacute;n</td>
                <td width="5%" class="columna_subtitulo_resultados"><div align="center">Ingresar</div></td>
              </tr>
              <tr class="filas_resultados">
                <td class="filas_resultados"><select name="filtro_modulo" id="filtro_modulo" onchange="ajax_carga('../procesos/administrador/alertas_elaboracion.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value+'&fecha_aprobacion='+document.principal.fecha_aprobacion.value+'&incluir_cargar_masivas='+document.principal.incluir_cargar_masivas.value+'&filtro_profesional='+document.principal.filtro_profesional.value,'carga_alertas')">
                  <option value="0">Filtro: Todos</option>
                  <?
    $busca_item = query_db("select modulo from #alertas where id_proceso >=1 $comple_alert group by modulo");
	while($sel_filtro = traer_fila_row($busca_item)){
		?>
                  <option value="<?=$sel_filtro[0]?>" <? if($_GET["filtro_modulo"] == $sel_filtro[0]) echo 'selected="selected"';?>>
                    <?=$sel_filtro[0]?>
                  </option>
                  <?
		}
	?>
                </select></td>
                <td width="10%" class="filas_resultados"><input type="text" name="filtro_consecutivo" id="filtro_consecutivo" value="<?=$_GET["filtro_consecutivo"]?>"  /></td>
                <td width="5%" class="filas_resultados"><img src="../imagenes/botones/busqueda.gif" style="cursor:pointer" onclick="ajax_carga('../procesos/administrador/alertas_elaboracion.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value+'&fecha_aprobacion='+document.principal.fecha_aprobacion.value+'&incluir_cargar_masivas='+document.principal.incluir_cargar_masivas.value+'&filtro_profesional='+document.principal.filtro_profesional.value,'carga_alertas');" /></td>
                <?
               if($muestra_columnas_nivel_aprobacion == "SI"){
			   ?><td class="filas_resultados"><select name="filtro_nivel" id="filtro_nivel" onchange="ajax_carga('../procesos/administrador/alertas_elaboracion.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value+'&fecha_aprobacion='+document.principal.fecha_aprobacion.value+'&incluir_cargar_masivas='+document.principal.incluir_cargar_masivas.value+'&filtro_profesional='+document.principal.filtro_profesional.value,'carga_alertas')"><option value="0">Filtro: Todos</option>
               
               <?
                $busca_item = query_db("select nivel_aprobacion from #alertas where id_proceso >=1 and nivel_aprobacion != '' $comple_alert group by nivel_aprobacion");	
				while($sel_niveles = traer_fila_row($busca_item)){
					
					
					?><option value="<?=$sel_niveles[0]?>" <? if($_GET["filtro_nivel"] == $sel_niveles[0]) echo 'selected="selected"';?> ><?=$sel_niveles[0]?></option><?
					}
			   ?>
               
               
               </select></td><? }else{
				   ?><input type="hidden" name="filtro_nivel" id="filtro_nivel" /><?
				   }?>
                <td class="filas_resultados"><select name="filtro_usuario" id="filtro_usuario" onchange="ajax_carga('../procesos/administrador/alertas_elaboracion.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value+'&fecha_aprobacion='+document.principal.fecha_aprobacion.value+'&incluir_cargar_masivas='+document.principal.incluir_cargar_masivas.value+'&filtro_profesional='+document.principal.filtro_profesional.value,'carga_alertas')">
                  <option value="0">Filtro: Todos</option>
                  <?
    $busca_item = query_db("select id_usuario from #alertas where id_proceso >=1 $comple_alert  group by id_usuario");
	while($sel_filtro = traer_fila_row($busca_item)){
		?>
                  <option value="<?=$sel_filtro[0]?>" <? if($_GET["filtro_usuario"] == $sel_filtro[0]) echo 'selected="selected"';?>>
                    <?=traer_nombre_muestra($sel_filtro[0], $g1,"nombre_administrador","us_id")?>
                  </option>
                  <?
		}
	?>
                </select></td>
                <td class="filas_resultados">
                
                <select name="filtro_profesional" id="filtro_profesional" onchange="ajax_carga('../procesos/administrador/alertas_elaboracion.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value+'&fecha_aprobacion='+document.principal.fecha_aprobacion.value+'&incluir_cargar_masivas='+document.principal.incluir_cargar_masivas.value+'&filtro_profesional='+document.principal.filtro_profesional.value,'carga_alertas')">
                  <option value="">Filtro: Todos</option>
                  <?
    $busca_item = query_db("select profesionalcyc from #alertas where id_proceso >=1 $comple_alert group by profesionalcyc");
	while($sel_filtro = traer_fila_row($busca_item)){
		?>
                  <option value="<?=$sel_filtro[0]?>" <? if($_GET["filtro_profesional"] == $sel_filtro[0]) echo 'selected="selected"';?>>
                    <?=$sel_filtro[0]?>
                  </option>
                  <?
		}
	?>
                </select>
                
                </td>
                <td class="filas_resultados"><select name="filtro_descripcion" id="filtro_descripcion" onchange="ajax_carga('../procesos/administrador/alertas_elaboracion.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value+'&fecha_aprobacion='+document.principal.fecha_aprobacion.value+'&incluir_cargar_masivas='+document.principal.incluir_cargar_masivas.value+'&filtro_profesional='+document.principal.filtro_profesional.value,'carga_alertas')">
                  <option value="0">Filtro: Todos</option>
                  <?
    $busca_item = query_db("select detalle from #alertas where id_proceso >=1 $comple_alert group by detalle");
	while($sel_filtro = traer_fila_row($busca_item)){
		?>
                  <option value="<?=$sel_filtro[0]?>" <? if($_GET["filtro_descripcion"] == $sel_filtro[0]) echo 'selected="selected"';?>>
                    <?=$sel_filtro[0]?>
                  </option>
                  <?
		}
	?>
                </select></td>
                <td class="titulos_resumen_alertas"><input name="fecha_aprobacion" type="text" id="fecha_aprobacion" size="5" value="<?=$_GET["fecha_aprobacion"]?>"  onmousedown="calendario_sin_hora('fecha_aprobacion')" onchange="ajax_carga('../procesos/administrador/alertas_elaboracion.php?filtro_descripcion='+document.principal.filtro_descripcion.value+'&filtro_usuario='+document.principal.filtro_usuario.value+'&filtro_consecutivo='+document.principal.filtro_consecutivo.value+'&filtro_modulo='+document.principal.filtro_modulo.value+'&filtro_nivel='+document.principal.filtro_nivel.value+'&fecha_aprobacion='+document.principal.fecha_aprobacion.value+'&incluir_cargar_masivas='+document.principal.incluir_cargar_masivas.value+'&filtro_profesional='+document.principal.filtro_profesional.value,'carga_alertas')"  /></td>
                <td class="titulos_resumen_alertas">&nbsp;</td>
              </tr>
              <?


	



 $busca_item = "select * from (
select id_proceso,destino,modulo,consecutivo,detalle, ROW_NUMBER() OVER(ORDER BY numero_modulo) AS rownum,numero_modulo,id_usuario,nivel_aprobacion, fecha_aprobacion, profesionalcyc from #alertas where id_proceso >=1  $comple_alert  ) as sub where rownum > $regis_inicial and rownum <= $regis_final 
order by numero_modulo asc, modulo desc";	  



	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){
		$usuario_solicita ="";
		$link =$ls_mr[1];
		
		if($ls_mr[2] == "MODULO SOLICITUDES" or $ls_mr[2] == "MODULO PECC" or  $ls_mr[2] == "MODULO COMITE"){
			$link='ajax_carga("'.$ls_mr[1].'","contenidos")';
			
			$usuario_solicita = traer_nombre_muestra($ls_mr[7], $g1,"nombre_administrador","us_id");
						
			}
		if($ls_mr[2] == "MODULO CONTRATOS"){//para los que son elaboracion de contratos
			$link='ajax_carga("'.$ls_mr[1].'","contenidos")';
			$usuario_solicita = traer_nombre_muestra($ls_mr[7], $g1,"nombre_administrador","us_id");
			}
			
			
			
		if($ls_mr[2] == "CONTRATOS"){
			$link='taer_menu("'.$ls_mr[1].'","contenido_menu")';
			}
			
				if($ls_mr[2] == "TARIFAS"){
			$link='taer_menu("'.$ls_mr[1].'","contenido_menu");ajax_carga("../aplicaciones/tarifas/c_aprobaciones.php?id_contrato='.$ls_mr[0].'","carga_acciones_permitidas")';
			}

if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }

?>

       
              <tr class="<?=$clase?>">
                <td ><?=$ls_mr[2];?></td>
                <td colspan="2" ><?=$ls_mr[3];?></td>
                <?
               if($muestra_columnas_nivel_aprobacion == "SI"){
			   ?><td ><?=$ls_mr[8]?></td><?
			   }
			   ?>
                <td class=""><? echo $usuario_solicita;?></td>
                <td class=""><?=$ls_mr[10]?></td>
                <td class=""><?=htmlentities($ls_mr[4]);?></td>
                <td class=""><?=$ls_mr[9]?></td>
                <td class=""><div align="center"> <img src="../imagenes/botones/editar.jpg" alt="" width="14" height="15" onclick='<?=$link;?>' /></div></td>
              </tr>
              <? } ?>
              <tr>
                <td colspan="9" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
                  <tr>
                    <td width="78%"><div align="left">Tareas pendientes:
                      <?=$sql_cuenta[0];?>
                    </div></td>
                  </tr>
                </table></td>
              </tr>
            </table></td>
          <td class="linea_der">&nbsp;</td>
        </tr>
        <tr>
          <td  class="esquina_i_iz">&nbsp;</td>
          <td  class="linea_infe">&nbsp;</td>
          <td   class="esquina_i_der">&nbsp;</td>
        </tr>
      </table>

</body>
</html>
