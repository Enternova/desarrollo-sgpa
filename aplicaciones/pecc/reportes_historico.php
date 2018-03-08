<? include("../../librerias/lib/@session.php"); 
	//verifica_menu("administracion.html");
	//header('Content-Type: text/xml; charset=ISO-8859-1');
	
	$query_comple = "";

	$id_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_pecc"]));
	if($id_pecc == 1){
	$comple_sql_histo =" and id_pecc = $id_pecc ";
			$_SESSION['id_peccs'] = "";
			$_SESSION['paginass'] = "";
			$_SESSION['id_tipo_proceso_peccs'] = "";
			$_SESSION['numero1_peccs'] = "";
			$_SESSION['numero2_peccs'] = "";
			$_SESSION['numero3_peccs'] = "";
			$_SESSION['bus_areas'] = "";
			$_SESSION['bus_text1s'] = "";
			$_SESSION['bus_text2s'] = "";
			$_SESSION['bus_text3s'] = "";
			$_SESSION['bus_text4s'] = "";
			$_SESSION['bus_text5s'] = "";	
			$_SESSION['profesional_cycs'] = "";
			$_SESSION['usuario_permisos'] = "";
			$_SESSION['estado_busrs'] = "";
			$_SESSION['tipo_contratacions'] = "";
			$_SESSION['preparador_bs'] = "";
			$_SESSION['muestra_finalizadoss'] = "";
			$_SESSION['tp_proceso_buscas'] = "";
			$_SESSION['num_solped_buss'] = "";	
	}else{
		$comple_sql_histo =" and id_pecc <> 1 ";
		}
			$_SESSION['id_peccs'] = $_GET["id_pecc"];
		$selec_las_areas_del_usuario = traer_fila_row(query_db("select count(*) from tseg3_usuario_areas where id_usuario = ".$_SESSION["id_us_session"]." and id_area in (1,44) and id_usuario !=53 and estado = 1"));
	
		$areas_in = "0";

		$sel_areas = query_db("select * from $g12 as t1, $ts3 as t2 where t1.t1_area_id = t2.id_area and t2.id_usuario = ".$_SESSION["id_us_session"]."");
	  while($sel_a_usuario = traer_fila_db($sel_areas)){
		  	$areas_in = $areas_in.", ".$sel_a_usuario[0];
		  }
		
		if($selec_las_areas_del_usuario[0]==0){//si no es de abastecimiento

			$sel_si_tiene_permiso_de_consulta_general = traer_fila_row(query_db("select count(*) from v_seg1 where id_premiso = 37 and us_id = ".$_SESSION["id_us_session"].""));	
			if($sel_si_tiene_permiso_de_consulta_general[0] == 0){
			
		$comple_sq_us = " and (id_us = ".$_SESSION["id_us_session"]." or id_us_profesional_asignado = ".$_SESSION["id_us_session"]." or t1_area_id in ($areas_in))";
			}
		}
		
		$sel_us_bodega = traer_fila_row(query_db("select * from v_seg1 where us_id = ".$_SESSION["id_us_session"]." and id_premiso = 29"));
		
		
		
		$numero1_pecc = arreglo_recibe_variables($_GET["numero1_pecc"]);
		$numero2_pecc = arreglo_recibe_variables($_GET["numero2_pecc"]);
		$numero3_pecc = arreglo_recibe_variables($_GET["numero3_pecc"]);
		$tp_proceso_busca = arreglo_recibe_variables($_GET["tp_proceso_busca"]);
		
		$muestra_finalizados = arreglo_recibe_variables($_GET["muestra_finalizados"]);
		$numero3_pecc = $numero3_pecc *1;
		$n_contrato = $n_contrato *1;
		$bus_area = arreglo_recibe_variables($_GET["bus_area"]);
		$bus_text1 = arreglo_recibe_variables($_GET["bus_text1"]);
		$bus_text2 = arreglo_recibe_variables($_GET["bus_text2"]);
		$bus_text3 = arreglo_recibe_variables($_GET["bus_text3"]);
		$bus_text4 = arreglo_recibe_variables($_GET["bus_text4"]);
		$bus_text5 = arreglo_recibe_variables($_GET["bus_text5"]);
		$contra_provee = arreglo_recibe_variables($_GET["contra_provee"]);
		$num_solped_bus=arreglo_recibe_variables($_GET["num_solped_bus"]);
		$tipo_contratacion = arreglo_recibe_variables($_GET["tipo_contratacion"]);
		$origen_pecc = arreglo_recibe_variables($_GET["origen_pecc"]);
		
		
		$completar_filtros = "";

		if($origen_pecc != "0" and $origen_pecc != ""){
			if($origen_pecc==1){
				$completar_filtros.=" and (origen_pecc <> '' or origen_pecc <> '0')";
				}else{
				$completar_filtros.=" and origen_pecc = '".$origen_pecc."'";
				}
			}

		if($numero1_pecc != "0" and $numero1_pecc != ""){
			$completar_filtros.=" and num1 = '".$numero1_pecc."'";
			}
		if($numero2_pecc != "" and $numero2_pecc != 0){
			if($numero2_pecc == 99){
					$completar_filtros.=" and (num2 = '' or num2 = ' ' or num2 is NULL)";		
				}else{
					$completar_filtros.=" and num2 like '%".$numero2_pecc."%'";
				}
			}
		if($numero3_pecc != "" and $numero2_pecc != 99){
			$completar_filtros.=" and num3 = '".$numero3_pecc."'";
			}

		if($num_solped_bus!=""){
			$completar_filtros.=" and num_solped like '%".$num_solped_bus."%'";
			
		}

		
		if($tp_proceso_busca != 0){
			if($tp_proceso_busca==15){
				$completar_filtros.=" and (t1_tipo_proceso_id = ".$tp_proceso_busca." or es_modificacion = 1)";
				}else{
			$completar_filtros.=" and t1_tipo_proceso_id = ".$tp_proceso_busca;
				}
			}
				$areas_in="";
		if($bus_area != 0){
				  if($bus_area == 34){
				  $areas_in = $areas_in.", ".$bus_area.", 24";
			  	  }elseif($bus_area == 35){
				  $areas_in = $areas_in.", ".$bus_area.", 25,20";
				  }elseif($bus_area == 36){
				  $areas_in = $areas_in.", ".$bus_area.", 22,26,32";
				  }elseif($bus_area == 37){
				  $areas_in = $areas_in.", ".$bus_area.", 6";
				  }elseif($bus_area == 38){
				  $areas_in = $areas_in.", ".$bus_area.", 21";
				  }elseif($bus_area == 39){
				  $areas_in = $areas_in.", ".$bus_area.", 12";
				  }elseif($bus_area == 40){
				  $areas_in = $areas_in.", ".$bus_area.", 17";
				  }elseif($bus_area == 41){
				  $areas_in = $areas_in.", ".$bus_area.", 18";
				  }elseif($bus_area == 44){
				  $areas_in = $areas_in.", ".$bus_area.", 1";
				  }elseif($bus_area == 46){
				  $areas_in = $areas_in.", ".$bus_area.", 31";
				  }elseif($bus_area == 47){
				  $areas_in = $areas_in.", ".$bus_area.", 13";
				  }elseif($bus_area == 48){
				  $areas_in = $areas_in.", ".$bus_area.", 7";
				  }elseif($bus_area == 49){
				  $areas_in = $areas_in.", ".$bus_area.", 8";
				  }elseif($bus_area == 50){
				  $areas_in = $areas_in.", ".$bus_area.", 14";
				  }elseif($bus_area == 55){
				  $areas_in = $areas_in.", ".$bus_area.", 5";
				  }elseif($bus_area == 60){
				  $areas_in = $areas_in.", ".$bus_area.", 53";
				  }else{
		  			$areas_in = $areas_in.", ".$bus_area;
					}
					
			$completar_filtros.=" and t1_area_id in (0".$areas_in.")";
			}
			
		
			
		if($bus_text1 != ""){
			$completar_filtros.=" and (alcance like '%".$bus_text1."%' or alcance_adjudica like '%".$bus_text1."%')";
			}
		if($bus_text2 != ""){
			$completar_filtros.=" and (justificacion like '%".$bus_text2."%' or justificacion_adjudica  like '%".$bus_text2."%')";
			}
		if($bus_text3 != ""){
			$completar_filtros.=" and (recomendacion like '%".$bus_text3."%' or recomendacion_adjudica like '%".$bus_text3."%')";
			}
		if($bus_text4 != ""){
			$completar_filtros.=" and (objeto_contrato like '%".$bus_text4."%' or ob_contrato_adjudica like '%".$bus_text4."%')";
			}
		if($bus_text5 != ""){
			$completar_filtros.=" and (objeto_solicitud like '%".$bus_text5."%' or ob_solicitud_adjudica like '%".$bus_text5."%')";
			}
		if($_GET["profesional_cyc"] != 0){
				$completar_filtros.=" and id_us_profesional_asignado =".$_GET["profesional_cyc"];
			}
			
				if($_GET["estado_busr"] != 0){
					if($_GET["estado_busr"] == 22){
						$completar_filtros.=" and estado > 20 and estado < 32 and estado <> 31 "; // en legalizacion
						}else{
							
							if($_GET["estado_busr"] == 34){
						$completar_filtros.=" and congelado = 1 and estado <> 33"; // en legalizacion
						}else{					
							if($_GET["estado_busr"] == 33){
						$completar_filtros.=" and estado = 33 and id_us <> 32 and id_us_profesional_asignado <> 32 ";
							}else{
								$completar_filtros.=" and estado =".$_GET["estado_busr"];
								}
						}
						}
						
						
			}else{
				if($_GET["numero3_pecc"] != "" and $_GET["numero3_pecc"] != "0"){
				$completar_filtros.=""; // 
					}else{
				$completar_filtros.=" and estado <> 33"; // no muestre los eliminados
					}
				}
			
			
					
			if($muestra_finalizados == "1"){
				$completar_filtros.=" and de_historico is not null ";//NO muestra los finalizados
				}
			if($muestra_finalizados == "2"){
				$completar_filtros.=" and de_historico is null ";//NO muestra los finalizados
				}
				
				
			
		if($tipo_contratacion <> 0){
			$completar_filtros.=" and t1_tipo_contratacion_id =".$tipo_contratacion;
			}
		
		if($preparador_b <> 0){
			$completar_filtros.=" and id_us_preparador =".$preparador_b;
			}
			
		$explode = explode("----,",$_GET["usuario_permiso"]);
	$id_usuario = $explode[1];	
		
		if($id_usuario <> ""){
			$completar_filtros.=" and id_us =".$id_usuario;
			}
	
	
	
?>
<style>
.columna_subtitulo_resultados_oscuro{ height:20px;font-size:14px; color:#FFF; 
 BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#666 }
 .tabla_lista_resultados{  margin:1px;
  BORDER-BOTTOM: #cccccc 3px double; BORDER-RIGHT: #cccccc 3px  double; BORDER-TOP: #cccccc 1px solid;  	BORDER-LEFT: #cccccc 1px solid; 
  border-spacing:2px;
  overflow:scroll;
  cursor:pointer;
 }
 .xl65
	{
	mso-style-parent:style0;
	mso-number-format:"\@";
	}
</style>
<style>
.titulo1 {
	font-size:24px;
	color:#135798;
		
}
.titulo2 {
	font-size:16px;
		
}
.titulo3 {
	font-size:20px;
	background-color:#135798;
	color:#FFF;
		
}
</style>
<table width="3000" border="1">

<tr >
  <td colspan="7" rowspan="3" align="center" >&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
  <td colspan="<?=$col;?>" align="left" class="titulo1"><strong>REPORTE SOLICITUDES</strong></td>
</tr>
<tr >
  <td colspan="<?=$col;?>" align="left" ><?=$tipo_contrato_bu?></td>
</tr>
<tr >
  <td colspan="<?=$col;?>" align="center" >&nbsp;</td>
  </tr>
 <tr>
      <td width="5%" rowspan="2" align="center" class="columna_subtitulo_resultados">N&uacute;mero</td>
      <td width="8%" rowspan="2" align="center" class="columna_subtitulo_resultados">Es carga Manual</td>
      <td colspan="4" align="center" class="titulo3">Informacion de PECC</td>
      <td width="8%" rowspan="2" align="center" class="columna_subtitulo_resultados">Fecha para Cuando se Requiere</td>
      <td width="11%" rowspan="2" align="center" class="columna_subtitulo_resultados">Tipo de Proceso</td>
      <td width="13%" rowspan="2" align="center" class="columna_subtitulo_resultados">Comprador / Profesional</td>
      <td width="13%" rowspan="2" align="center" class="columna_subtitulo_resultados">Fecha de Creacion de la Solicitud</td>
      <td width="13%" rowspan="2" align="center" class="columna_subtitulo_resultados">Fecha en la que se Puso en Firme</td>
      <td width="13%" rowspan="2" align="center" class="columna_subtitulo_resultados">Fecha de Aprobacion</td>
      <td width="13%" rowspan="2" align="center" class="columna_subtitulo_resultados">Nivel de Aprobacion</td>
      <td width="13%" rowspan="2" align="center" class="columna_subtitulo_resultados">Contratos Relacionados</td>
      <td width="15%" rowspan="2" align="center" class="columna_subtitulo_resultados">Solicitud Relacionada</td>
      <td width="15%" rowspan="2" align="center" class="columna_subtitulo_resultados">Usuario Solicitante</td>
      <td width="28%" rowspan="2" align="center" class="columna_subtitulo_resultados">Objeto de la Solicitud</td>
      <td width="11%" rowspan="2" align="center" class="columna_subtitulo_resultados">Areas del Usuario</td>
      <td width="11%" rowspan="2" align="center" class="columna_subtitulo_resultados">Gerente de OT</td>
      <td width="11%" rowspan="2" align="center" class="columna_subtitulo_resultados">Areas Gerente OT</td>
      <td width="11%" rowspan="2" align="center" class="columna_subtitulo_resultados">Area Solicitud</td>      
      <td width="11%" rowspan="2" align="center" class="columna_subtitulo_resultados">Estado</td>
      <td width="11%" rowspan="2" align="center" class="columna_subtitulo_resultados">Rol Pendiente para Firmar</td>
      <td width="11%" rowspan="2" align="center" class="columna_subtitulo_resultados">Comentario</td>
    </tr>
 <tr class="titulo3">
   <td width="8%" align="center" class="columna_subtitulo_resultados">Origen PECC</td>
   <td width="8%" align="center" class="columna_subtitulo_resultados">Linea del PECC</td>
   <td width="8%" align="center" class="columna_subtitulo_resultados">Requiere modificacion</td>
   <td width="8%" align="center" class="columna_subtitulo_resultados">Justificacion de la modificacion</td>
 </tr>
    <?php
   $sele_items_historico_codigo = "select id_item, num1, num2, num3, fecha_se_requiere, nombre, CAST(objeto_solicitud AS text), Expr1, t1_tipo_proceso_id, id_pecc, estado, id_us, id_us_profesional_asignado, t1_area_id, t1_tipo_contratacion_id, congelado,id_us_preparador,ROW_NUMBER()Over(order by id_item desc) As RowNum,solicitud_rechazada,solicitud_desierta,id_gerente_ot, de_historico, ob_solicitud_adjudica, fecha_creacion, origen_pecc, pecc_linea, pecc_modificado, pecc_modificado_id_solicitud_aprobacion, pecc_modificado_observacion,id_solicitud_relacionada,es_modificacion, fue_sm from v_peec_historico where estado <> 0  $completar_filtros $comple_sql_histo $comple_sq_us and t1_area_id > 0 group by id_item, num1, num2, num3, fecha_se_requiere, nombre, objeto_solicitud, Expr1, t1_tipo_proceso_id, id_pecc, estado, id_us, id_us_profesional_asignado, t1_area_id,t1_tipo_contratacion_id, congelado,id_us_preparador,solicitud_rechazada,solicitud_desierta,id_gerente_ot, de_historico, ob_solicitud_adjudica, fecha_creacion, origen_pecc, pecc_linea, pecc_modificado, pecc_modificado_id_solicitud_aprobacion, pecc_modificado_observacion,id_solicitud_relacionada,es_modificacion, fue_sm";

if($_SESSION["id_us_session"]==32){
	//echo $sele_items_historico_codigo;
	}




    	$sel_histo_sql = query_db( $sele_items_historico_codigo);

		
		while($sel_para_insert = traer_fila_db($sel_histo_sql)){
			
			
			
			$id_us_genera=$_SESSION["id_us_session"];
			$id_item=$sel_para_insert[0];
			$sel_item = traer_fila_row(query_db("select estado from $pi2 where id_item=".$id_item)); 	#Query de primera instancia para roles pendientes

			$id_tipo_proceso_pecc = 1;
			if($sel_para_insert[8] == 7){
					$id_tipo_proceso_pecc = 2;
				}
			if($sel_para_insert[8] == 8){
					$id_tipo_proceso_pecc = 3;
				}
				$_SESSION['id_tipo_proceso_peccs'] = $id_tipo_proceso_pecc;

			$id_us_solicitante=$sel_para_insert[11]+0;
			$id_us_gerente_ot=$sel_para_insert['id_gerente_ot'];
			$fecha_requiere=$sel_para_insert[4];
			$tipo_proceso=$sel_para_insert[8]+0;
			$contratos_relacionados=contratos_relacionados_solicitud_para_campos($sel_para_insert[0]);
			$usuario_solicitante=$sel_para_insert[11]+0;
			

			
			if($sel_para_insert[22] != ""){
			$objeto_solicitud=$sel_para_insert[22];
			}else{	
			$objeto_solicitud=$sel_para_insert[6];
			}
			
			
			$estado=$sel_para_insert[10];
			$area=$sel_para_insert[13]+0;
			$profecional=$sel_para_insert[12]+0;
			$preparador=$sel_para_insert[16]+0;
			$tipo_solicitud=$sel_para_insert[14]+0;
			$tp_proceso="0";
			if ($sel_para_insert[8] == 8 and $sel_para_insert[14] <> 1) { $nom_tipo_proceso = "Orden de Pedido Contrato Marco/Lista de Precios";}else{
      $nom_tipo_proceso = $sel_para_insert[7];
	  
	  }
	  
$comple_est="";
			$numero_proceso=numero_item_pecc($sel_para_insert[1],$sel_para_insert[2],$sel_para_insert[3]);
			$nom_us_solicitante=traer_nombre_muestra($sel_para_insert[11], $g1,"nombre_administrador","us_id");
			$nom_us_gerente_ot=traer_nombre_muestra($sel_para_insert['id_gerente_ot'], $g1,"nombre_administrador","us_id");
			if($sel_para_insert[10] > 20 and $sel_para_insert[10] < 32 and $sel_para_insert[10] <> 31){
			  $nom_estado = "En legalizaci&oacute;n";
			  }else{
				  if($sel_para_insert[10]==32 and $sel_para_insert[18]==1){
					  $comple_est=" - RECHAZADO";
					  }
				 if($sel_para_insert[10]==32 and $sel_para_insert[19]==1){
					  $comple_est=" - DECLARADO DESIERTO";
					  }
				  $nom_estado = $sel_para_insert[5].$comple_est;
				  
				  }
				  
				  
		if($sel_para_insert[15] == 1){
				
				$sel_ob_cnogelado = traer_fila_row(query_db("select observacion from t2_acciones_admin where id_item = $id_item and accion = 'Congelado' order by id_accion_admin desc"));
				$nom_estado = "Congelado - ".$sel_ob_cnogelado[0];
			}
			
			
		if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		
       $sel_propuestos_real = query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$id_item." and id_rol not in (10,11) group by id_rol, rol,orden order by orden");
		$cont = 0;

$select_minmima_gestion = traer_fila_row(query_db("select MIN(fecha_real) from t2_nivel_servicio_gestiones where id_item=".$sel_para_insert[0]." and estado = 1"));
				  
	?>
    <tr class="<?=$clase?>">
      
      <td><?=$numero_proceso?></td>
      <td align="center"><?
      
	  if($sel_para_insert[21] == "si" ) echo "SI"; else echo "NO";
	  ?></td>
      <td align="center"><? if($sel_para_insert[24]==1 or $sel_para_insert[24]==0) echo "Ninguno"; if($sel_para_insert[24]>1) echo $sel_para_insert[24];?></td>
      <td align="center"><? if($sel_para_insert[25]!="") echo saca_nombre_lista("t1_lineas_pecc",$sel_para_insert[25],'detalle','id');?></td>
      <td align="center"><? if($sel_para_insert[26]==1) echo "SI"; if($sel_para_insert[26]==2) echo "NO";?></td>
      <td align="center"><? if($sel_para_insert[28]!="") echo $sel_para_insert[28];?></td>
      <td align="center"><?=$fecha_requiere?></td>
      <td><? if($sel_para_insert[30]==1 and $sel_para_insert[31]!="SI"){echo "Modificaci&oacute;n";}else {echo $nom_tipo_proceso;}?></td>
      <td><? echo saca_nombre_lista($g1,$sel_para_insert[12],'nombre_administrador','us_id');?></td>
      <td><?=$sel_para_insert[23]?></td>
      <td><?=$select_minmima_gestion[0]?></td>
      <td><?
      $sel_fecha_aprobacion = traer_fila_row(query_db("select max(t2.fecha) from t2_agl_secuencia_solicitud as t1, t2_agl_secuencia_solicitud_aprobacion as t2 where t1.id_secuencia_solicitud = t2.id_secuencia_solicitud and t2.aprobado=1 and t1.estado=1 and t1.id_item_pecc = ".$sel_para_insert[0]));
	  echo $sel_fecha_aprobacion[0];
	  
	  ?></td>
      <td><?
      
	  $aprobacion_nivel =  nivel_aprobacion_solicitud($sel_para_insert[0], "adjudicacion");
	
					$cuantos_caracteres = strlen($aprobacion_nivel);
					$cuantos_caracteres = $cuantos_caracteres - 13;
					$aprobacion_nivel_su = substr($aprobacion_nivel,0,$cuantos_caracteres);
					
					$aprobacion_nivel_expl = explode("-",$aprobacion_nivel);
					$aprobacion_nivel_expl_comite = explode(". ",$aprobacion_nivel);
					//echo "-".$aprobacion_nivel_expl[0]."-";
				//	if($aprobacion_nivel_expl[0] == "Vicepresidente "){
						
						/*if($sel_para_insert[13]==24 or $sel_para_insert[13]==25){
							$aprobacion_nivel = "Vp. Producci&oacute;n y  Operaciones";
							}elseif($sel_para_insert[13]==17 or $sel_para_insert[13]==18){
								$aprobacion_nivel = "V.p. Exploraci&oacute;n y Desarrollo de Negocios";
								}elseif($sel_para_insert[13]==26 or $sel_para_insert[13]==20 or $sel_para_insert[13]==21 or $sel_para_insert[13]==22){
								$aprobacion_nivel = "Vp. T&eacute;cnica";
								}elseif($sel_para_insert[13]==1 or $sel_para_insert[13]==14 or $sel_para_insert[13]==2 or $sel_para_insert[13]==30 or $sel_para_insert[13]==13 or $sel_para_insert[13]==12){
								$aprobacion_nivel = "Vp. Financiera y Administrativa";
								}elseif($sel_para_insert[13]==4 or $sel_para_insert[13]==5 or $sel_para_insert[13]==6 or $sel_para_insert[13]==7 or $sel_para_insert[13]==3 or $sel_para_insert[13]==8 or $sel_para_insert[13]==9 or $sel_para_insert[13]==15 or $sel_para_insert[13]==23 or $sel_para_insert[13]==19){
								$aprobacion_nivel = "Presidente ".$aprobacion_nivel_expl_comite[1];
								}else{
								$aprobacion_nivel = "Vicepresidente ".$aprobacion_nivel_expl_comite[1];
							}
						
						}elseif($aprobacion_nivel_expl[0] == "Comit&eacute; "){
							$aprobacion_nivel = "Comit&eacute; ".$aprobacion_nivel_expl_comite[1];
							}else{*/
							$aprobacion_nivel=$aprobacion_nivel_su;
						//	}
	  
	  echo $aprobacion_nivel;
	  ?></td>
      <td><?=$contratos_relacionados?></td>
      <td><? if($sel_para_insert[29]!="" and $sel_para_insert[29]>0){
		  
		  $sel_item_rel = traer_fila_row(query_db("select num1, num2, num3 from t2_item_pecc where id_item = ".$sel_para_insert[29]));
			 echo numero_item_pecc($sel_item_rel[0],$sel_item_rel[1],$sel_item_rel[2]);
						} ?></td>
      <td><?=$nom_us_solicitante?></td>
      <td><?=$objeto_solicitud?></td>
      <td><?

	  $sel_areas_usuario = query_db("select t3.nombre from t1_us_usuarios as t1, tseg3_usuario_areas as t2, t1_area as t3 where t1.us_id = ".$id_us_solicitante." and t1.us_id = t2.id_usuario and t2.id_Area = t3.t1_Area_id and t3.estado = 1 group by t3.nombre");
	  
	  while($s_ar = traer_fila_db($sel_areas_usuario)){
		  echo $s_ar[0]."-";
		  }
	  
	  ?></td>
      
      <td><?=$nom_us_gerente_ot?></td>
      <td><?
	  $sel_areas_usuario_ot = query_db("select t3.nombre from t1_us_usuarios as t1, tseg3_usuario_areas as t2, t1_area as t3 where t1.us_id = ".$id_us_gerente_ot." and t1.us_id = t2.id_usuario and t2.id_Area = t3.t1_Area_id and t3.estado = 1 group by t3.nombre");
	  
	  while($s_ar_ot = traer_fila_db($sel_areas_usuario_ot)){
		  echo $s_ar_ot[0]."-";
		  }
	  
	  ?></td>
      
      <td>
      <?
	  
	  echo saca_nombre_lista($g12,$area,'nombre','t1_area_id');
	?>  
	  </td>
      <td><?=$nom_estado?></td>
      <td> <?
	  if($sel_item[0] == 7 || $sel_item[0] == 16){
	  $_coma = false;
	  $sel_propuestos_real = query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$id_item." and id_rol not in (10,11) group by id_rol, rol,orden order by orden");
		while($sel_p_real = traer_fila_db($sel_propuestos_real)){
			
			
			$sel_real_us_aprueba = traer_fila_row(query_db("select * from $vpeec15 where id_item_pecc = ".$id_item." and id_rol = ".$sel_p_real[0]." and estado = 1 and us_id = ".$_SESSION["id_us_session"]." order by nombre_administrador"));

			$sel_id_apro_ultima = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = " .(($sel_item[0] == 7) ? "1" : "2") . "and id_item_pecc = ".$id_item));
			
			$sel_ultima_aprobacion = traer_fila_row(query_db("select * from $vpeec16 where id_aprobacion = ".$sel_id_apro_ultima[0]));

			if(!($sel_real_us_aprueba[0]> 0 and $sel_ultima_aprobacion[5] <> 1)){

				if($sel_ultima_aprobacion[5] <> 1 and $sel_ultima_aprobacion[5] <> 2 and $sel_ultima_aprobacion[5] <> 3){

		       		if($_coma){
					
						echo "- ";
						
					}
					echo $sel_p_real[1];
					$_coma = true;
				}
			}
			
			
			}	
		}		
      ?></td>
      <td>
      <?php 
	  //Comentario Eliminado
	  $slqElim = "select observacion from $pi19 where id_item = $id_item and detalle = '6. Eliminar Este Proceso'";
	  $rowElim = traer_fila_db(query_db($slqElim));
	  echo $rowElim[0];
	  ?>
      </td>
    </tr>
    <?
		}
	?>
</table>
<?
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Solicitudes.xls"); 

?>
