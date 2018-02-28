<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/html; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	//SELECCION DE PERMISO E ITEM
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	
	/*saca contrato si aplica para saber si esta vencido*/
	$alerta_contrato_vencido="";
	if($sel_item[6] == 4 or $sel_item[6] == 5){
		$sel_contrato = traer_fila_row(query_db("select vigencia_mes from t7_contratos_contrato where id=".$sel_item[21]));
		if($sel_contrato[0] < $fecha){
			$alerta_contrato_vencido = "ATENCION: El contrato relacionado se encuentra vencido.";
			}
	}
	if($sel_item[6] == 7 or $sel_item[6] == 8){
		 
		
		$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$sel_item[0]."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id");		
		while($sel_presu = traer_fila_db($sele_presupuesto)){
		$sel_contr = query_db("select t2.vigencia_mes from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]." order by t2.id asc");
			while($sel_apl = traer_fila_db($sel_contr)){
				if($sel_apl[0] < $fecha){
			$alerta_contrato_vencido = "ATENCION: El contrato relacionado se encuentra vencido, por favor contactar al profesional de Abastecimiento.";
			}	
			}
		}
		}
	/*FIN saca contrato si aplica para saber si esta vencido*/

	/*VALIDACION PARA SABER SI HAY VALORES EN LA SOLICITUD*/
	
	$complet_sql_validacion="";
	if($sel_item[6] == 1 or $sel_item[6] == 2 or $sel_item[6] == 6){//licitacion o negociacion directa, al tener permiso y adjudicacion, debe validar los valores de la adjudicacion
		$complet_sql_validacion=" and permiso_o_adjudica = 2";
		}else{
			$complet_sql_validacion=" and permiso_o_adjudica = 1";
			}
	
	
	$sel_si_tiene_presu = traer_fila_row(query_db("select count(*) from t2_presupuesto where t2_item_pecc_id = ".$sel_item[0].$complet_sql_validacion));
if($sel_si_tiene_presu[0]<=0){
	
	$alerta_contrato_vencido ='Para poder poner en firme debe ingresar el presupuesto, SGPA tambi&eacute;n recibe valores en cero (0)';
}
	
	
	/* FIN VALIDACION PARA SABER SI HAY VALORES EN LA SOLICITUD*/


	
				$permite_eliminar_super_intendente="SI";
			$permite_eliminar_gerente_contrato="SI";
			$permite_eliminar_jefe_area="SI";
			$permite_eliminar_vicepresidente="SI";

//	
	$id_pecc = $sel_item[1];
	$sel_pecc = traer_fila_row(query_db("select $g10.valor from $pi1, $g1, $g10 where $pi1.id_pecc = ".$sel_item[1]." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));

	$edicion_datos_generales_permiso = "NO";
	if(verifica_permiso_firmas_adjudicacion($sel_item[14], $sel_item[0]) == "SI"){
			$edicion_datos_generales_permiso = "SI";
		}
		
	if(($sel_item[14] ==31 and $_SESSION["id_us_session"]==$sel_item[3] and $sel_item[6] ==8)){
			$edicion_datos_generales_permiso = "SI";
		}
	
	$sele_tipo_doc_desierto = traer_fila_row(query_db("select t2_item_pecc_id, razon_social, consecutivo, creacion_sistema, ano, nombre, valor_usd, valor_cop, adjunto, tipo_documento, t1_proveedor_id, t2_presupuesto_id, nit, t1_tipo_documento_id, id_contrato, vigencia_mes, t1_campo_id, apellido, Expr1, t1_proveedor_id_2, estado from $vpeec18 where t2_item_pecc_id ='".$id_item_pecc."'"));

/*para calcular las aprobacion*/
	$gerente_solicitante = $sel_item[3];
	if($sel_item[6] == 8){
		$gerente_solicitante = $sel_item[42];
		}	
	/*FIN para calcular las aprobacion*/
						
						
	if($sel_item[6]==11){
				  $nombre_firma_1="Informado";
				  $nombre_firma_2="NO Informado";
				  $nombre_firma_3="Informado";
				  $nombre_firma_4="NO Informado";
				  }elseif($sele_tipo_doc_desierto[13]==4){//si es Declaracion Desierta
					  $nombre_firma_1="Declarar Desierto";
				  	$nombre_firma_2="Devolver al Profesional";
					$nombre_firma_3="Declarado Desierto";
				  	$nombre_firma_4="Devuelto al Profesional";
					  }else{
					$nombre_firma_1="Firmar";
				  	$nombre_firma_2="Devolver al Profesional";
					$nombre_firma_3="Firmado";
				  	$nombre_firma_4="Devuelto al Profesional";
					  }

		//FIN SELECCION DE PERMISO E ITEM


	$sel_si_ya_se_creo = traer_fila_row(query_db("select count(*) from $pi14 where id_item_pecc = ".$id_item_pecc." and por_sistema = 2 and tipo_adj_permiso = 2"));
	
			$solicitud_pecc = "NO";		

			


	if($sel_si_ya_se_creo[0] == 0 and ($edicion_datos_generales_permiso == "SI" or $_SESSION["id_us_session"] == 32)){
		$sele_tipo_doc_desierto = traer_fila_row(query_db("select t2_item_pecc_id, razon_social, consecutivo, creacion_sistema, ano, nombre, valor_usd, valor_cop, adjunto, tipo_documento, t1_proveedor_id, t2_presupuesto_id, nit, t1_tipo_documento_id, id_contrato, vigencia_mes, t1_campo_id, apellido, Expr1, t1_proveedor_id_2, estado from $vpeec18 where t2_item_pecc_id ='".$id_item_pecc."'"));
				$sel_secuencia_solicitud_si_tiene_firmar_permiso = query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 1 and estado = 1 and por_sistema = 2");

		if($sele_tipo_doc_desierto[13]==4 and $sel_secuencia_solicitud_si_tiene_firmar_permiso[0]>0){//si es adjudicacion desierta trae las firmas del permiso
			$dele_pro_sistem = query_db("delete from $pi14 where id_item_pecc =".$id_item_pecc." and tipo_adj_permiso = 2");
					$sel_secuencia_solicitud = query_db("select id_secuencia_solicitud, id_item_pecc, id_rol, orden, estado, por_sistema, tipo_adj_permiso from t2_agl_secuencia_solicitud where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 1 and estado = 1");
				$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
				while($sel_sec = traer_fila_db($sel_secuencia_solicitud)){
					$insert_secuencia = "insert into t2_agl_secuencia_solicitud (id_item_pecc, id_rol, orden, estado, por_sistema, tipo_adj_permiso) values (".$id_item_pecc.", ".$sel_sec[2].", ".$sel_sec[3].", 1, 1, 2)";
					$sql_ex=query_db($insert_secuencia.$trae_id_insrte);
					$id_secu = id_insert($sql_ex);//id del contrato
					
					$sel_usuarios = query_db("select  id_usuario_aprobador, id_secuencia_solicitud, id_usuario, estado, id_usuario_original from t2_agl_secuencia_solicitud_usuario where id_secuencia_solicitud = ".$sel_sec[0]." and estado = 1");
					while($sel_us = traer_fila_db($sel_usuarios)){
					$insert_us = query_db("insert into t2_agl_secuencia_solicitud_usuario (id_secuencia_solicitud, id_usuario, estado, id_usuario_original) values (".$id_secu.", '".$sel_us[2]."', 1, '".$sel_us[4]."')");
						}
					
					}
		}else{
			if($sel_item[56] > 1 and $sel_item[72] == 2 and ($sel_item[6] != 1 and $sel_item[6] != 2) and $sel_item[24] != 1){//si es de pecc y no requiere aprobacion del nivel de aprobacion	
					$solicitud_pecc = "SI";						
					$sel_estado_resultado_pecc = traer_fila_row(query_db("select t2.id from t1_estado_resultado_pecc t1, t2_nivel_servicio_actividades t2 where id_tipo_proceso = ".$sel_item[6]." and t1.id_actividad_resultado = t2.id"));
						configuracion_de_firmas($id_item_pecc, 2,"PECC");
					
					}	else{//si es un proceso normal
						configuracion_de_firmas($id_item_pecc, 2, "");
					}
			
				
		}
		}
		
																	
$activa_firmas_de_adjudicacion = "SI";
	if($sel_item[4] <> 1){
		$no_contratos = ", 30";
		}	
		if($sel_item[39] == "si-ad"){
			  $activa_firmas_de_adjudicacion ="NO";
			  }
  
  $muestra_columnas_encargado="SI";
	if($sel_item[14]>18 ){//si el estado es mayor a firmas en el sistema para el permiso desactivar la columna de encargado
		$muestra_columnas_encargado="NO";
		}
		
		/*------------------ PERMISO PARA SERVICIOS MENORES ---------------------*/
if($sel_item[6]==16 and ($sel_item[14] < 16) and esprofesionalcompras($id_item_pecc)=="SI"){
	$edicion_datos_generales_permiso = "SI";	
	}
/*------------------ PERMISO PARA SERVICIOS MENORES ---------------------*/



if($sel_item[14]==13 and $sel_item[6] == 16 and $sel_item[23] == $_SESSION["id_us_session"]){
$edicion_datos_generales_permiso = "SI";

}

/*------------VALIDACION QUE EL USUARIO SOLICTANTE CORRESPONDA AL AREA DE LA SOLICITUD-----------------*/	

$id_solicitante = $sel_item[5];
if($sel_item[42] !='' and $sel_item[42] !='0' and $sel_item[42] !=' '){
	//$id_solicitante = $sel_item[42];
	}
$sel_si_usaurio_corresponde_area = traer_fila_row(query_db('select count(*) from tseg3_usuario_areas, t1_area where tseg3_usuario_areas.id_area = t1_area.t1_area_id and  tseg3_usuario_areas.id_usuario ='.$sel_item[3].' AND t1_area.t1_area_id = '.$id_solicitante.' and tseg3_usuario_areas.estado =1 and t1_area.estado=1 '));
$alerta_no_carga_firmas ="";
if($sel_si_usaurio_corresponde_area[0]<=0 and $sel_item[14]==14){
	$alerta_no_carga_firmas ='<br /><br /><br /><i class="material-icons md-36 red-text prefix">&#xE15D;</i><font size="+2">No es posible cargar las firmas ni poner en firme la solicitud, debido a que el usuario solicitante no se encuentra asignado al &aacute;rea de la solicitud.</font>';

		$es_profesional_designado="NO";
	$edita_info_ad_sm = "NO";
	$edicion_datos_generales_pecc = "NO";
	$edicion_datos_generales="NO";
	$activa_firmas_de_adjudicacion="NO";
	$edicion_datos_generales_permiso="NO";
	}
		/*------------VALIDACION QUE EL USUARIO SOLICTANTE CORRESPONDA AL AREA DE LA SOLICITUD-----------------*/
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2" valign="top"><?=encabezado_item_pecc($id_item_pecc)?></td>
  </tr>
  <tr>

    <td width="77%" valign="top">
    <?
		echo $alerta_no_carga_firmas;
if($activa_firmas_de_adjudicacion =="SI" ){
?>

    <?
    if($edicion_datos_generales_permiso == "SI"   and $solicitud_pecc != "SI"){
		aprobaciones_por_area($sel_item[5]);	
	
	?>
    
    <br />
<br />

    <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
      <tr>
        <td colspan="2" align="center"  class="fondo_3">Agregar Firma en el Sistema para la Adjudicaci&oacute;n</td>
        </tr>
      
      <tr>
        <td width="51%" align="right">Rol Encargado:</td>
        <td width="49%" align="left"><select name="rol_encarga_permiso" id="rol_encarga_permiso">
          <?=listas($ts2, " estado = 1 and id_modulo = 1 and id_tipo_permiso = 2 and id_premiso in (18,21,16,22,17,34, 23,40,46, 50, 39, 47 ".$no_contratos.")",0 ,'nombre', 3);?>

        </select></td>
        </tr>
      <tr>
        <td align="right">Usuarios Posibles para la Firma:</td>
        <td align="left">
          <input type="text" name="usuario_permiso" id="usuario_permiso" onkeypress="selecciona_lista()"/></td>
        </tr>
      <tr>
        <td align="right">Orden de Secuencia:</td>
        <td align="left"><input type="text" name="orden_permiso" id="orden_permiso" /></td>
      </tr>
      <tr>
        <td colspan="2" align="center"><input type="button" name="button" id="button" value="Agregar Firma en el Sistema para la Adjudicaci&oacute;n" class="boton_grabar" onclick="agrega_aprobacion(2)" /></td>
        </tr>
      
    </table>
<?
	}
  
	?>
    <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
        <tr>
          <td colspan="7" align="center"  class="fondo_3">Lista de Firmas en el Sistema Requeridas para la Adjudicaci&oacute;n</td>
        </tr>
        <tr>
          <td width="15%" rowspan="2" align="center" class="fondo_3">Rol Encargado</td>
         <? if($muestra_columnas_encargado=="SI"){ ?> <td width="12%" rowspan="2" align="center" class="fondo_3">Usuarios Encargados</td><? } ?>
          <?
		  $es_aprobador_indicado_muestra_colmuna = "NO";
			//if(verifica_permiso_firmas_adjudicacion($sel_item[14], $sel_item[0])=="SI"){
				if($sel_item[14] == 0){//nunca va a mostrar esta columna
				$es_aprobador_indicado_muestra_colmuna = "SI";
				}

				
          if($es_aprobador_indicado_muestra_colmuna == "SI"){
		  ?><td width="10%" rowspan="2" align="center" class="fondo_3">Orden de Secuencia</td>
          <?
		  }
		  ?>
          <td colspan="3" align="center" class="fondo_3">Firmas</td>
          <td width="6%" rowspan="2" align="center" class="fondo_3">Acciones</td>
        </tr>
        <tr>
          <td width="22%" align="center" class="fondo_3">Estado Ultima Firma</td>
          <td width="30%" align="center" class="fondo_3">Observaci&oacute;n</td>
          <td width="5%" align="center" class="fondo_3">Adjunto</td>
        </tr>
        <?
			
			
			$sel_si_comite = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$id_item_pecc." and id_rol = 10 and tipo_adj_permiso = 2 and estado = 1"));
			
			$sel_si_vicepresidente = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$id_item_pecc." and id_rol in( 20, 43) and tipo_adj_permiso = 2 and estado = 1"));

$sel_si_gernte_area = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$id_item_pecc." and id_rol in( 9) and tipo_adj_permiso = 2 and estado = 1"));

       $sel_propuestos_real = query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 2 and id_rol not in (10,11) group by id_rol, rol,orden order by orden");
	   
	   $sel_si_tiene_nivel_mas_que_jefetura = traer_fila_row(query_db("select count(*) from t2_agl_secuencia_solicitud where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 2 and estado = 1 and id_rol in (9,20,43,48,10)"));
	   
		while($sel_p_real = traer_fila_db($sel_propuestos_real)){

//if($_SESSION["id_us_session"]!= 32){
			$select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2 and aprobado=1 and id_item_pecc = ".$id_item_pecc));
			$select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and estado= 1 and tipo_adj_permiso = 2"));

			$edita_permiso = "SI";
				if($select_si_tiene_acciones[0] > 0 or ($sel_p_real[0] == 8 or $sel_p_real[0] == 9 or $sel_p_real[0] == 20 or $sel_p_real[0] == 45 or $sel_p_real[0] == 43 or $sel_p_real[0] == 10 or $sel_p_real[0] == 48 or $sel_p_real[0] == 50)){
				$edita_permiso = "NO";
				$secuencia_profesional_permiso = $select_secuencia[0];
				
				if($sel_p_real[0] == 8){
				$secuencia_profesional_real = $select_secuencia[0];
				}
				}
			
			/*del siguiente query se quito  del not in el rol 15, para que pueda firmar el solicitante en caso que no halla registrado la firma.*/
			
			$sel_real_us_aprueba = traer_fila_row(query_db("select  id_secuencia_solicitud, id_item_pecc, id_rol, orden, nombre_administrador, rol, tipo_adj_permiso, id_usuario_aprobador, estado, us_id, id_usuario_original from $vpeec15 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2 and estado = 1 and (us_id in (".$_SESSION["usuarios_con_reemplazo"].") or id_usuario_original in (".$_SESSION["usuarios_con_reemplazo"].")) and id_rol not in (8) order by nombre_administrador"));
				   	

			
			$sel_id_apro_ultima = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2 and id_item_pecc = ".$id_item_pecc));
			
			$sel_ultima_aprobacion = traer_fila_row(query_db("select id_item_pecc, id_secuencia_solicitud, id_aprobacion, id_us, fecha, aprobado, nombre_administrador, id_rol, tipo_adj_permiso, adjunto1, adjunto2, CAST (observacion AS text), estado from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima[0]));


	
			$es_aprobador_indicado_aprueba = "NO";
			if($sel_real_us_aprueba[0]> 0 and $sel_ultima_aprobacion[5] <> 1 and $sel_item[14] == 16){
			$es_aprobador_indicado_aprueba = "SI";
			
					if(permite_firmar_proceso_de_bienes($sel_item[0]) == "SI"){//si es diferente a servicios o si es servicios menores
					

									if($sel_p_real[0]==9 and  ($sel_si_comite[0]==0 and $sel_si_vicepresidente[0]==0)){		// si es jefe de area y no tiene comite	 ni viceprecidente						
										$es_aprobador_indicado_aprueba = "NO";
										}
									
									if($sel_p_real[0]==45 and  ($sel_si_vicepresidente[0]==0 and $sel_si_comite[0]==0 and $sel_si_gernte_area[0]==0)){		// si es superintendente y no tiene comite	 ni viceprecidente	jefe operacional
										$es_aprobador_indicado_aprueba = "NO";
										}
									if(($sel_p_real[0]==20 or $sel_p_real[0]==43) and  $sel_si_comite[0]==0){		// si es vicepresidente y no tiene comite							
										$es_aprobador_indicado_aprueba = "NO";
										}
										
//								 if(faltaprofesionalcompras($sel_item[0])=="SI" or ($sel_p_real[0]==9 or $sel_p_real[0]==35 or $sel_p_real[0]==20)){
								 if(faltaprofesionalcompras($sel_item[0])=="SI"){// si falta la aprobacion del profesional
									 $es_aprobador_indicado_aprueba = "NO";
									 if(esprofesionalcompras($sel_item[0])=="SI"){//si es nanky
										$es_aprobador_indicado_aprueba = "SI";
										}
									
									
								 }
							}//fin si es diferente a servicios
			}
			
			
			
			if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		  
	   $nombre_rol_im = $sel_p_real[1];
	   
			 if($sel_p_real[0] == 8 and ($sel_item[4] == 2 or $sel_item[4] == 3 or $sel_item[4] == 4)){
			  $nombre_rol_im = "Comprador";
			  }
				$sel_si_es_administrador_de_ots = traer_fila_row(query_db("select * from v_seg1 where us_id =".$sel_item[3]." and id_premiso = 33"));//verifica si el usuario es administrador de OTS
  
  if($sel_item[4] <> 1){
		  $nombre_OT_OP = "Orden de Pedido";
		  }else{
			  $nombre_OT_OP = "OT";
			  }
			  
			  
			  if($sel_p_real[0] == 15){
			  $nombre_rol_im = "Gerente del Item";
			  }
			  
			 if($sel_p_real[0] == 15 and $sel_item[6] == 8 and $sel_si_es_administrador_de_ots[0]>0){
			  $nombre_rol_im = "Solicitante de la ".$nombre_OT_OP;
			  }
			  
		  if($sel_p_real[0] == 15 and $sel_item[6] == 8 and $sel_si_es_administrador_de_ots[0]<=0){
			  $nombre_rol_im = "Gerente de la ".$nombre_OT_OP;
			  }
			    
			

		?>
        <tr  class="<?=$clase?>">


          <td align="center"><?
		  
		    if($sel_p_real[0] == 8 and ($sel_item[14] == 6 or $sel_item[14] == 14)){//verifica que sea el profesional para ver si es un validador o doporte de abastecimiento y cambia el nombre del rol solo para impresion en pantalla
			          $sel_si_es_soporte_abas = traer_fila_row(query_db("select count(*) from v_seg1 where id_premiso = 44 and us_id = ".$sel_item[23]));
					  if($sel_si_es_soporte_abas[0]==0){
						  echo $nombre_rol_im;
						  }else{
							  echo "Gestion Abastecimiento";
							  }
					  }else{
			  echo $nombre_rol_im;
		  }
		  ?></td>
          <? if($muestra_columnas_encargado=="SI"){ ?>
          <td align="left">
		  
		  <?
		  
		  if($sel_p_real[0] == 8 and ($sel_item[14] >= 15 and $sel_item[14] <> 31 and $sel_ultima_aprobacion[5] <> 1)){//si coje la firma verifica y la crea
			  $sel_crear_item_ad = traer_fila_row(query_db("select * from t2_nivel_servicio_gestiones where id_item = ".$sel_item[0]." and t2_nivel_servicio_actividad_id = 14 and estado=1"));
			  
			  if($sel_crear_item_ad[0]==""){
			  $sel_crear_item_ad = traer_fila_row(query_db("select * from t2_nivel_servicio_gestiones where id_item = ".$sel_item[0]." and t2_nivel_servicio_actividad_id = 6 and estado=1"));
			  }
			  if($sel_crear_item_ad[0]!= "" and $sel_crear_item_ad[0]!= 0){
				  
				  $insert_firma = query_db("insert into t2_agl_secuencia_solicitud_aprobacion (id_secuencia_solicitud, id_us, fecha, aprobado, observacion) values ('".$select_secuencia[0]."', '".$sel_crear_item_ad[3]."', '".$sel_crear_item_ad[4]."',1,'Declaro que no tengo conflicto de intereses<br />Declaro que he revisado la lista de conflicto de inter&eacute;s suministrada por Cumplimiento en la cual no se registra conflicto de ninguno de los participantes en &eacute;ste proceso.')");
					
									$sel_ultima_aprobacion[4]=$sel_crear_item_ad[4];
									$sel_ultima_aprobacion[5]=1;  
					  
				  }
		  }//si coje la firma verifica y la crea
		  
		  	
		  if($sel_p_real[0] == 15){
			  //echo "*.".traer_nombre_muestra($sel_item[3], $g1,"nombre_administrador","us_id");
			  echo ver_si_tiene_reemplazo($sel_item[3]);
			  }else{
          $sel_real_us = query_db("select  id_secuencia_solicitud, id_item_pecc, id_rol, orden, nombre_administrador, rol, tipo_adj_permiso, id_usuario_aprobador, estado, us_id, id_usuario_original from $vpeec15 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2 and estado = 1 order by nombre_administrador");
		  
				while($sel_re_us = traer_fila_db($sel_real_us)){
					$es_reemplazo="";
					
					
					
					//if(($sel_re_us[10] != "" and $sel_re_us[9] != "") and ($sel_re_us[10] != $sel_re_us[9])){ $es_reemplazo ="<br /><font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista($g1,$sel_re_us[10],'nombre_administrador','us_id')."</strong>";}
					
					//if($_SESSION["id_us_session"]==37){
						if($sel_re_us[10]>0){
							$usuario_imprime =  ver_si_tiene_reemplazo($sel_re_us[10]);
						}else{
							$usuario_imprime =  ver_si_tiene_reemplazo($sel_re_us[9]);
							}
					/*echo $usuario_imprime;
					}*/
					
					if($usuario_imprime <> ""){
					if($edita_permiso == "SI" and $edicion_datos_generales_permiso == "SI"){
					
						
					echo "*.".$usuario_imprime." <img src='../imagenes/botones/eliminada_temporal.gif' width='10' height='10' onclick='elimina_usuario_firma_adjudica(".$sel_re_us[7].",2,".$sel_p_real[0]." )'/><br />";
					
					
					
					
					}else{
						echo "*.".$usuario_imprime." <br />";
						}
					}
						
				}
				
			  }//fin si es el gerente
			    
		  ?>
          
          </td>
       <?
		  }
          if($es_aprobador_indicado_muestra_colmuna == "SI"){
		  ?>
          <td align="center">
          <?
          if($edicion_datos_generales_permiso == "SI" and $edita_permiso == "SI"){
		  ?>
          <input type="text"  name="orden_<?=$sel_p_real[2]?>" id="orden_<?=$sel_p_real[2]?>" value="<?=$sel_p_real[2]?>" onchange="cambia_orden_firmas(<?=$select_secuencia[0]?>,this.value,1)" />
          <?
		  }else{
			  
			  echo $sel_p_real[2];
			  }
		  ?>
          </td>
          <?
		  }
          	
		  ?>
          <td align="left">
		  
          <?

          if($es_aprobador_indicado_aprueba == "SI"){
			  
			  
		  ?>
          <select name="accion_aprueba_<?=$sel_p_real[0]?>" id="accion_aprueba_<?=$sel_p_real[0]?>">
          <option value="1"><?=$nombre_firma_1?></option>
          <option value="2"><?=$nombre_firma_2?></option>
          <option value="3">Rechazado</option>
          </select>
		  <?
		  }else{ 
$es_reemplazo="";
	 $sel_si_reemplazo_aprobacion = traer_fila_row(query_db("select id_usuario, id_usuario_original from t2_agl_secuencia_solicitud_usuario where id_secuencia_solicitud = ".$sel_ultima_aprobacion[1]." and estado = 1 and id_usuario =".$sel_ultima_aprobacion[3]));
			  
			 
			   if(($sel_si_reemplazo_aprobacion[0] != "" and $sel_si_reemplazo_aprobacion[1] != "") and ($sel_si_reemplazo_aprobacion[0] != $sel_si_reemplazo_aprobacion[1])){ 
			   $es_reemplazo ="<br /><font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista($g1,$sel_si_reemplazo_aprobacion[1],'nombre_administrador','us_id')."</strong>";}
			   
			   
		  	if(($sel_item[14] == 15 or $sel_item[14] == 14) and $sel_p_real[0] == 15){
				echo "Pendiente";
			}else if (($sel_item[14] == 6 or $sel_item[14] == 14) and $sel_p_real[0] == 8){
				echo "Pendiente";				
				}else{
		  	if($sel_ultima_aprobacion[5] == 1){
				
				if(($sel_item[6] == 9 or $sel_item[6] == 10) and $sel_p_real[0] == 8 and $sel_item[0] > 5181 ){
					echo "Usuario: ".$sel_ultima_aprobacion[6]." ".$es_reemplazo."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />Estado: Informado";
					}else{
						echo "Usuario: ".$sel_ultima_aprobacion[6]." ".$es_reemplazo."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />Estado: $nombre_firma_3";
						}
					
					
				}
				
			
			   
			   
			if($sel_ultima_aprobacion[5] == 2){
					echo "Usuario: ".$sel_ultima_aprobacion[6]." ".$es_reemplazo."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />$nombre_firma_4";
				}
			if($sel_ultima_aprobacion[5] == 3){
					echo "Usuario: ".$sel_ultima_aprobacion[6]." ".$es_reemplazo."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />Rechazado";
				}
				
			if($sel_ultima_aprobacion[5] <> 1 and $sel_ultima_aprobacion[5] <> 2 and $sel_ultima_aprobacion[5] <> 3){
					echo "Pendiente";
				}
			}
		  }
		  
		  ?></td>
          <td align="center"><?
          if($es_aprobador_indicado_aprueba == "SI"){
		  ?>
          <select name="conflito_intere_<?=$sel_p_real[0]?>" id="conflito_intere_<?=$sel_p_real[0]?>" onchange="valida_conflico_firma(this.value, document.principal.accion_aprueba_<?=$sel_p_real[0]?>)">
          <option value="0">Seleccione si tiene conflicto de intereses</option>
          <option value="1">SI tiene conflicto de intereses</option>
          <option value="2">NO tiene conflicto de intereses</option>
          </select>
          <textarea name="observa_<?=$sel_p_real[0]?>" cols="10" rows="2" id="observa_<?=$sel_p_real[0]?>"></textarea>
    
          <?
		  }else{
		    	if (($sel_item[14] == 6 or $sel_item[14] == 14)){
				}else{
			  		echo nl2br($sel_ultima_aprobacion[11]);
				}
					
			  }
		  ?></td>
          <td align="center"><?
          if($es_aprobador_indicado_aprueba == "SI"){
		  ?>
            <input type="file" name="adjunto_<?=$sel_p_real[0]?>" id="adjunto_<?=$sel_p_real[0]?>" />
            <input type="file" name="adjunto2_<?=$sel_p_real[0]?>" id="adjunto2_<?=$sel_p_real[0]?>" />
            <?
		  }else{
			  	if($sel_ultima_aprobacion[9] != ""){
		  ?>
          
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_ultima_aprobacion[9]?>&n1=<?=$sel_ultima_aprobacion[2]?>&n3=4" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_ultima_aprobacion[9])?>.gif" width="16" height="16" />
                  </a>
          <?
				}
				if($sel_ultima_aprobacion[10] != ""){
		  ?>
          
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_ultima_aprobacion[10]?>&n1=<?=$sel_ultima_aprobacion[2]?>&n3=5" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_ultima_aprobacion[10])?>.gif" width="16" height="16" />
                  </a>
          <?
				}
		  }
		  
		  ?>
          	</td>
          
          <td align="center">
          <?
//		   }//para elimina
          if($es_aprobador_indicado_aprueba == "SI"){
			  ?><input type="button" name="sdfd" value="Firmar" onclick="aprueba_firma_adjudica(<?=$sel_p_real[0]?>,document.principal.accion_aprueba_<?=$sel_p_real[0]?>.value, document.principal.conflito_intere_<?=$sel_p_real[0]?>.value,document.principal.observa_<?=$sel_p_real[0]?>.value, '<?=$alerta_contrato_vencido?>','')" /><?
		  }else{
			  
			  
			  
			  
			 
			
			//aprobacion de otrosi si no es el gerente

			if($sel_item[6] == 4 or $sel_item[6] == 5){				
				$sel_si_es_gerente = traer_fila_row(query_db("select gerente from $co1 where id = ".$sel_item[21]));				
				if($sel_si_es_gerente[0] != $sel_item[3]){	$permite_eliminar_gerente_contrato="NO";}
				}
			
			if($sel_item[6] == 8 ){				
				$sele_presupuesto = traer_fila_row(query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$sel_item[0]."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id"));				
				$sel_contr = query_db("select t1.t7_contrato_id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sele_presupuesto[0]);
				$sel_apl = traer_fila_db($sel_contr);				
				$id_contrato = $sel_apl[0];				
				$sel_si_es_gerente = traer_fila_row(query_db("select gerente from $co1 where id = ".$id_contrato));				
				if($sel_si_es_gerente[0] != $sel_item[42]){	$permite_eliminar_gerente_contrato="NO";}
				}
				
			if($sel_item[6] == 7 ){				
				$sele_presupuesto = traer_fila_row(query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$sel_item[0]."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id"));				
				$sel_contr = query_db("select t1.t7_contrato_id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sele_presupuesto[0]);
				$sel_apl = traer_fila_db($sel_contr);				
				$id_contrato = $sel_apl[0];				
				$sel_si_es_gerente = traer_fila_row(query_db("select gerente from $co1 where id = ".$id_contrato));				
				if($sel_si_es_gerente[0] != $sel_item[3]){$permite_eliminar_gerente_contrato="NO";}
				}
			// FINaprobacion de otrosi si no es el gerente
			/*
			$sele_pro_sistem = query_db("select id_rol_permiso, orden from $vpeec13 where id_item = ".$id_item_pecc.$rol_jefe_no_aplica." group by id_rol_permiso, orden");
			
			while($sel_p_sist = traer_fila_db($sele_pro_sistem)){
				if($sel_p_sist[0]==9){
					$permite_eliminar_jefe_area="NO";
					}
				if($sel_p_sist[0]==20){
					$permite_eliminar_vicepresidente="NO";
					}
			}
			*/
			  
			  
			  
		
			  
			  			  
			  
			$permite_eliminar = "SI";
			
			if($sel_p_real[0]==45){
				$permite_eliminar = "NO";
				}

			if($sel_p_real[0]==23){
				$permite_eliminar = "NO";
				}
				
			if($sel_p_real[0]==9){
				$permite_eliminar = "NO";
				}
			
			if($sel_p_real[0]==20){
				//$permite_eliminar = "NO";
				}
				
			if($sel_p_real[0]==34){
				$permite_eliminar = "NO";
				}
			if($sel_p_real[0]==46){
				$permite_eliminar = "NO";
				}
			if($sel_p_real[0]==15){
				$permite_eliminar = "NO";
				}
			 if($sel_p_real[0]==50){//coordinador de abastecimiento
				$permite_eliminar = "NO";
				}
				
			
				


			 

          if($edita_permiso == "SI" and $edicion_datos_generales_permiso == "SI" and $permite_eliminar == "SI"){
			  
			   if($sel_p_real[0] == 17 and $sel_si_comite[0]>0){	
			  //no permite eliminar el par tecnico
			  ?>
         <!-- <img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" onclick="elimina_firma_completa_adjudica(<?=$select_secuencia[0]?>,1)" />-->
          <?
			  }else{

		  ?>
          <img src="../imagenes/botones/eliminada_temporal.gif" alt="" width="16" height="16" onclick="muestra_alerta_general_solo_texto('elimina_firma_completa_adjudica(<?=$select_secuencia[0]?>,1)', 'Advertencia', 'Esta seguro de Eliminar Todo el Rol Encargado?', '40', '5', '12')" />
          <?
			  }
		  }
		  }
		  
		  ?>
          
          
          </td>
        </tr>
        <?
		
        }
		?>
        <?

       $sel_p_real = traer_fila_db(query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 2 and id_rol = 10 group by id_rol, rol,orden order by orden"));;
			if($sel_p_real[0]>0){
			$select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2 and aprobado=1 and id_item_pecc = ".$id_item_pecc));
			$select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2"));

			$edita_permiso = "SI";
			if($select_si_tiene_acciones[0] > 0 ){
				$edita_permiso = "NO";
				$secuencia_profesional_permiso = $select_secuencia[0];
				}

		?>
        <tr>


          <td align="center"><?=$sel_p_real[1]?></td>
          <? if($muestra_columnas_encargado=="SI"){ ?>
          <td align="left"><?
          $sel_real_us = query_db("select nombre_administrador from $v_seg1 where id_premiso = 10 group by nombre_administrador");
				while($sel_re_us = traer_fila_db($sel_real_us)){
					
					echo "*.".$sel_re_us[0]." <br />";
					
						
				}
		  ?></td>
          <?
		  }
          if($es_aprobador_indicado_muestra_colmuna == "SI"){
		  ?><td align="center">
          
          </td><? } ?>
          <?
          	$sel_id_apro_ultima = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2 and id_item_pecc = ".$id_item_pecc));
			
			$sel_ultima_aprobacion = traer_fila_row(query_db("select * from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima[0]));
		  ?>
          <td align="left"><? 
		  	if($sel_ultima_aprobacion[5] == 1){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />Estado: $nombre_firma_3";
				}
			if($sel_ultima_aprobacion[5] == 2){
					echo "Usuario: ".$sel_ultima_aprobacion[6]."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />$nombre_firma_4";
				}
			if($sel_ultima_aprobacion[5] <> 1 and $sel_ultima_aprobacion[5] <> 2){
					echo "Pendiente";
				}
				
          	$id_comite = traer_fila_row(query_db("select id_comite from t3_comite_relacion_item where id_item = ".$id_item_pecc." and permiso_o_adjudica = 2 order by id_relacion desc"));				
				
		  ?></td>
          
          <? if($id_comite[0] != 0 and $id_comite[0] != ""){?>
          <td align="center" onClick='window.parent.document.getElementById("div_carga_busca_sol").style.display="block";ajax_carga("../aplicaciones/comite/aprobacion.php?id_item_consulta_firma=<?=$id_item_pecc?>&id_comite=<?=$id_comite[0]?>&permiso_o_adjudica=2","div_carga_busca_sol")'><?=nl2br($sel_ultima_aprobacion[11]);?> </td>
          
          <?
		  }else{?> <td></td><? }
		  ?>
          <td align="center">&nbsp;</td>
          
          <td align="center">
          
          </td>
        </tr>
        <?
	}
       $sel_p_real = traer_fila_db(query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$id_item_pecc." and tipo_adj_permiso = 2 and id_rol = 11 group by id_rol, rol,orden order by orden"));
			if($sel_p_real[0]>0){
			$select_si_tiene_acciones = traer_fila_row(query_db("select count(*) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2 and aprobado=1 and id_item_pecc = ".$id_item_pecc));
			$select_secuencia = traer_fila_row(query_db("select * from $pi14 where id_item_pecc = ".$id_item_pecc." and id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2"));



$selecciona_si_es_usuario_de_socios = traer_fila_row(query_db("select count(*) from $vpeec15 where id_item_pecc = ".$id_item_pecc." and id_rol = 11 and tipo_adj_permiso = 2 and estado = 1 and id_secuencia_solicitud = ".$select_secuencia[0]." and us_id in (".$_SESSION["usuarios_con_reemplazo"].")"));

			$es_aprobador_indicado_aprueba = "NO";
			if($selecciona_si_es_usuario_de_socios[0] > 0 and $sel_item[14] == 18){
			$es_aprobador_indicado_aprueba = "SI";
				}


		?>
        <tr class="filas_resultados">


          <td align="center"><?=$sel_p_real[1]?></td>
          <? if($muestra_columnas_encargado=="SI"){ ?>
          <td align="left"><?
           $sel_real_us = query_db("select id_secuencia_solicitud, id_item_pecc, id_rol, orden, nombre_administrador, rol, tipo_adj_permiso, id_usuario_aprobador, estado, us_id, id_usuario_original from $vpeec15 where id_item_pecc = ".$id_item_pecc." and id_rol = 11 and tipo_adj_permiso = 2 and estado = 1 order by nombre_administrador");
		  
				while($sel_re_us = traer_fila_db($sel_real_us)){

						
					if($sel_re_us[10]>0){
							$usuario_imprime =  ver_si_tiene_reemplazo($sel_re_us[10]);
						}else{
							$usuario_imprime =  ver_si_tiene_reemplazo($sel_re_us[9]);
							}
							

					
						
				}
				echo $usuario_imprime;
		  ?></td>
          <?
		  }
          if($es_aprobador_indicado_muestra_colmuna == "SI"){
		  ?>
          <td align="left">
          </td>
          <?
		  }
		  ?>
          <td align="left"> <?
          	$sel_id_apro_ultima = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = 2 and id_item_pecc = ".$id_item_pecc));
			
//			$sel_ultima_aprobacion = traer_fila_row(query_db("select * from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima[0]));
			$sel_ultima_aprobacion = traer_fila_row(query_db( "select id_item_pecc, id_secuencia_solicitud, id_aprobacion, id_us, fecha, aprobado, nombre_administrador, id_rol, tipo_adj_permiso, adjunto1, adjunto2, CAST(observacion AS TEXT),  estado from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima[0]));

		  ?>
		  <?
          if($es_aprobador_indicado_aprueba == "SI"){
		  ?>

          <select name="accion_aprueba_<?=$sel_p_real[0]?>" id="accion_aprueba_<?=$sel_p_real[0]?>">
          <option value="1">Firmar</option>
          <option value="2">Rechazar</option>
          </select>
		  <?
		  
		 
if($sel_item[14] == 18){
	?>
<strong onclick="abrir_ventana('../aplicaciones/comite/pecc/impresion-socios-edicion-item-pecc.php?id_item_pecc=<?=$sel_item[0]?>&id_tipo_proceso_pecc=<?=$id_tipo_proceso_pecc?>&conse_div=<?=$conse_div?>&permiso_o_adjudica=2')" class="titulo_calendario_real_bien"> Exportar presentaci&oacute;n a socios <img src="../imagenes/mime/doc.gif" width="20" height="20"></strong>
		<?
	}
	
		  }else{ 
		  
		  
		   $es_reemplazo="";
			  $sel_si_reemplazo_aprobacion = traer_fila_row(query_db("select id_usuario, id_usuario_original from t2_agl_secuencia_solicitud_usuario where id_secuencia_solicitud = ".$sel_ultima_aprobacion[1]." and estado = 1 and id_usuario =".$sel_ultima_aprobacion[3]));
			  
			  
			  if(($sel_si_reemplazo_aprobacion[0] != "" and $sel_si_reemplazo_aprobacion[1] != "") and ($sel_si_reemplazo_aprobacion[0] != $sel_si_reemplazo_aprobacion[1])){ $es_reemplazo ="<br /><font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista($g1,$sel_si_reemplazo_aprobacion[1],'nombre_administrador','us_id')."</strong>";}
			  
		  	if($sel_ultima_aprobacion[5] == 1){
					echo "Usuario: ".$sel_ultima_aprobacion[6].$es_reemplazo."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />Estado: $nombre_firma_3";
				}
			if($sel_ultima_aprobacion[5] == 2){
					echo "Usuario: ".$sel_ultima_aprobacion[6].$es_reemplazo."<br />Fecha ".$sel_ultima_aprobacion[4]."<br />$nombre_firma_4";
				}
			if($sel_ultima_aprobacion[5] <> 1 and $sel_ultima_aprobacion[5] <> 2){
					echo "Pendiente";
				}
		  }
		  ?></td>
          <td align="center"><?
          if($es_aprobador_indicado_aprueba == "SI"){
		  ?>
          <select name="conflito_intere_<?=$sel_p_real[0]?>" id="conflito_intere_<?=$sel_p_real[0]?>" onchange="valida_conflico_firma(this.value, document.principal.accion_aprueba_<?=$sel_p_real[0]?>)">
          <option value="0">Seleccione si tiene conflicto de intereses</option>
          <option value="1">SI tiene conflicto de intereses</option>
          <option value="2">NO tiene conflicto de intereses</option>
          </select>
          <textarea name="observa_<?=$sel_p_real[0]?>" cols="10" rows="2" id="observa_<?=$sel_p_real[0]?>"></textarea>
    
          <?
		  }else{
			  echo nl2br($sel_ultima_aprobacion[11]);
			  }
		  ?></td>
          
          <td align="center"><?
          if($es_aprobador_indicado_aprueba == "SI"){
		  ?>
            <input type="file" name="adjunto_<?=$sel_p_real[0]?>" id="adjunto_<?=$sel_p_real[0]?>" />
            <input type="file" name="adjunto2_<?=$sel_p_real[0]?>" id="adjunto2_<?=$sel_p_real[0]?>" />
            <?
		  }else{
			  	if($sel_ultima_aprobacion[9] != ""){
		  ?>
          

                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_ultima_aprobacion[9]?>&n1=<?=$sel_ultima_aprobacion[2]?>&n3=4" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_ultima_aprobacion[9])?>.gif" width="16" height="16" />
                  </a>
          <?
				}
				if($sel_ultima_aprobacion[10] != ""){
		  ?>
          

                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_ultima_aprobacion[10]?>&n1=<?=$sel_ultima_aprobacion[2]?>&n3=5" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_ultima_aprobacion[10])?>.gif" width="16" height="16" />
                  </a>
          <?
				}
		  }
		  ?>
          	
          
          </td>
          <td><?
		  
          if($es_aprobador_indicado_aprueba == "SI"){
			  ?><input type="button" name="sdfd" value="Firmar" onclick="aprueba_firma_adjudica(11,document.principal.accion_aprueba_<?=$sel_p_real[0]?>.value,document.principal.conflito_intere_<?=$sel_p_real[0]?>.value,document.principal.observa_<?=$sel_p_real[0]?>.value, '<?=$alerta_contrato_vencido?>')" /><?
		     
		  }
		  ?></td>
        </tr>
        <?
			}
		?>
      </table><?
	
	  ?>
    <br />
    <?
	
}
/*hasta aca va la revision*/
?>
    </td>
    <td width="23%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
  <tr>
    <td valign="top" id="carga_acciones_permitidas2"> <?
	/*
	if ($sel_item[6]==16 and $sel_item[14] <>6){// SI ES SERVICIOS MENORES Y NO ES ESTADO COMPLETAMIENTO NO LE PERMITE FIRMAR POR QUE LA FIRMA LA LLEBA EN OTRA VENTANA
	$edicion_datos_generales_permiso = "NO";	
		}
	*/
	if($edicion_datos_generales_permiso == "SI" ){
	  ?>
      <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
        <tr>
          <td width="13%" align="right"><?
          if ($sel_item[6] == 4 or $sel_item[6] == 5 or $sel_item[6] == 7  or $sel_item[6] == 8 or $sel_item[6] == 9 or $sel_item[6] == 10 or $sel_item[6] == 11 or $sel_item[6] == 12 or $sel_item[6] == 15 or $sel_item[6] == 16){
		  ?>
            Observaci&oacute;n de la Devoluci&oacute;n:
  <?
		  }
		  ?></td>
          <td width="38%"><?
          if ($sel_item[6] == 4 or $sel_item[6] == 5 or $sel_item[6] == 7  or $sel_item[6] == 8 or $sel_item[6] == 9 or $sel_item[6] == 10 or $sel_item[6] == 11 or $sel_item[6] == 12 or $sel_item[6] == 15  or $sel_item[6] == 16){
		  ?>
            <textarea name="observa_atras" rows="5" id="observa_atras"></textarea>
            <?
		  }
		?></td>
          <td width="49%" align="center">
          
          <?
				
	$sel_revision_conflicto = traer_fila_row(query_db("select revision2_conflicto_intereces from t2_item_pecc where id_item =".$id_item_pecc));	
	?><strong onclick="graba_descarga_conflicto2()" style="cursor:pointer"><a href="../archivo_conflicto/conflictos2.xls">Click para Descargar listado de conflicto de empleados Hocol</a></font></strong><?
			
				
        $sel_si_es_soporte_abas = traer_fila_row(query_db("select count(*) from v_seg1 where id_premiso = 44 and us_id = ".$_SESSION["id_us_session"]));	
        if($sel_si_es_soporte_abas[0]==0 and $sel_revision_conflicto[0]==1){
		  ?>

          <select name="conflito_intere_sel" id="conflito_intere_sel"  onChange="valida_conflicto_interes(this.value)">
      <option value="0">Seleccione si tiene conflicto de inter&eacute;s y si ha validado el listado de conflicto de empleados Hocol que participan en &eacute;ste proceso</option>
      <option value="1">SI tiene conflicto de intereses</option>
      <option value="2">Declaro que no tengo conflicto de inter&eacute;s.</option>
    </select>
    <div id="carga_conflicto_interes"></div>
    
    		<?
		}else{
			echo "<strong class='letra-descuentos'><br />Para poder firmar el proceso y enviarlo al siguiente nivel, primero debe descargar y verificar el archivo 'listado de conflicto de empleados Hocol' </strong>";
			}
		
		
		  ?>
          
          </td>
        </tr>
        <tr>
          <td colspan="2" align="center"><?
          if ($sel_item[6] == 4 or $sel_item[6] == 5 or $sel_item[6] == 7  or $sel_item[6] == 8 or $sel_item[6] == 9 or $sel_item[6] == 10 or $sel_item[6] == 11 or $sel_item[6] == 12 or $sel_item[6] == 15  or $sel_item[6] == 16){
		  ?>
            <input type="button" name="button3" id="button3" value="Devolver Esta Solicitud" class="boton_grabar_cancelar" onclick="devolver_item_a_gerente_contrato()" />
          <?
		  }
		  ?></td>
          <td width="49%" align="center">
            <?
         
        if($sel_si_es_soporte_abas[0]==0   and $sel_revision_conflicto[0]==1){
			
		  ?>
          <input type="button" name="button2" id="button2" value="Terminar <? if ($sel_item[6] == 8) echo "El Completamiento"; else echo "la Adjudicaci&oacute;nn"?>" class="boton_grabar" onclick="siguiente_nivel_agl('Esta Seguro de firmar y declarar que no tiene conflicto de intereses?',<?=$secuencia_profesional_real?>, '<?=$alerta_contrato_vencido?>')" />
          <?
		}
		  ?>
          
          </td>
        </tr>
      </table>
      <?
	}
	  ?></td>
    <td valign="top" id="carga_acciones_permitidas2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" id="carga_acciones_permitidas">&nbsp;</td>
  </tr>
</table>

<input type="hidden" name="id_elimian_firma" id="id_elimian_firma" value="" />
<input type="hidden" name="tipo_adj_permiso" id="tipo_adj_permiso" />
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
<input type="hidden" name="id_secuencia" id="id_secuencia" value="" />
<input type="hidden" name="orden_edita_secua" id="orden_edita_secua" value="" />
<input type="hidden" name="id_rol_aprueba" id="id_rol_aprueba" value="" />
<input type="hidden" name="estado_item_peec" id="estado_item_peec" value="<?=$sel_item[14]?>" />
<input type="hidden" name="id_tipo_contratacion" id="id_tipo_contratacion" value="<?=$sel_item[4]?>" />

</body>
</html>
