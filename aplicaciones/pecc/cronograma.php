<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	
	$selec_pecc = traer_fila_row(query_db("select id_pecc from $pi2 where id_item = $id_item_pecc"));
	if($selec_pecc[0] == 1){
			$comple_sql = " and aplica_item = 1";
		}else{
			$comple_sql = " and aplica_pecc = 1";
			}
			
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	/** PARA EL DES002-18 **/
	$fecha_creacion=$sel_item[22];
	$fecha_creacion=explode('-',$fecha_creacion);
	if($fecha_creacion[0]>=2017){
		$count_ano=traer_fila_row(query_db("SELECT COUNT(*) FROM v_pecc_estado_actividad_v2 WHERE ano=".$fecha_creacion[0]));
		if($count_ano[0]==0){
			$ano=traer_fila_row(query_db("SELECT MAX(ano) FROM v_pecc_estado_actividad_v2"));
			$comple_sql.=" and ano=".$ano[0];
		}else{
			$comple_sql.=" and ano=".$fecha_creacion[0];
		}
		$vpeec_aplica="v_pecc_estado_actividad_v2";
	}else{
		$vpeec_aplica=$vpeec3;
	}
	/** FIN PARA EL DES002-18 **/
	$tipo_para_funcion="";
	$id_para_funcion="";
	$muestra_legalizacion ="NO";
	
	if($sel_item[14]>20){
		$sel_si_complementos = traer_fila_row(query_db("select id from t7_contratos_complemento where id_item_pecc = ".$id_item_pecc." and estado <> 50"));
		$sel_si_contrato = traer_fila_row(query_db("select id from t7_contratos_contrato where id_item = ".$id_item_pecc." and estado <> 50"));
		
		if($sel_si_complementos[0]>0){
			$tipo_para_funcion="Modificacion";
			$id_para_funcion=$sel_si_complementos[0];
			}
		if($sel_si_contrato[0]>0){
			$tipo_para_funcion="contrato";
			$id_para_funcion=$sel_si_contrato[0];
			}
		if($id_para_funcion > 0){
		$muestra_legalizacion ="SI";
		}
		
	}
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
    <td width="77%" valign="top"><table width="100%" border="0">
      <tr class="fondo_3">
        <td width="2%" align="center">No.</td>
        <td width="62%" align="center">Actividad</td>
        <td width="4%" align="center">Dias Ideales</td>
        <td width="4%" align="center">Fecha_Ideal</td>
        <td width="8%" align="center">Fecha Reprogramada</td>
        <td width="4%" align="center">Fecha_Real</td>
        <td width="4%" align="center">Dias Reales</td>
        <td width="6%" align="center">Dias Congelado</td>
        <td width="6%" align="center">Dias Retrasados</td>
      </tr>
      <?
	  $selec_tiempo_proceso = traer_fila_row(query_db("select sum(tiempo),fecha_se_requiere from $vpeec_aplica where id_item =".$id_item_pecc."".$comple_sql." group by fecha_se_requiere"));
	$tiempo_proceso=number_format($selec_tiempo_proceso[0],0);
	$fecha_requiere = $selec_tiempo_proceso[1];
	$fecha_empiesa = restar_fechas($fecha_requiere, $tiempo_proceso);
	



	 	  $sel_actividades_resumen = query_db("select actividad_estado,tiempo,fecha_se_requiere,fecha_real,tiempo_para_actividad,actividad_estado_id,dias_reales, estado,encargado from $vpeec_aplica where id_item =".$id_item_pecc."  ".$comple_sql." and actividad_estado_id <= 21 order by actividad_estado_id");
	$cont = 0;
  	$clase="";
  	$numero_acti = 1;
	$dias_ideales_total =0;
	$primera_actividad = 0;
      while($ac_resum = traer_fila_db($sel_actividades_resumen)){
		  $dias_reales =$ac_resum[6];
		  
		  if($fecha_reprograma != ""){
					$fecha_reprograma = sumar_fechas($fecha_reprograma, $ac_resum[1]);
					}

		  if($primera_actividad == 0){
			  	$primera_actividad = $ac_resum[5];
				$fecha_ideal = $fecha_empiesa;
				if($ac_resum[3] != ""){
					$dias_reales =0;
					$fecha_reprograma = $ac_resum[3];
				}
			  }else{
				 $fecha_ideal = restar_fechas($ac_resum[2], $ac_resum[4]);
				  }
		  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		  $dias_ideales_total = $dias_ideales_total + $ac_resum[1];
		  
		  if($ac_resum[3] <= $fecha_ideal){
				$clase_real ="titulo_calendario_real_bien";
				}else{
					$clase_real ="titulo_calendario_real_mal";
					}
		 if($dias_reales <= $ac_resum[1]){
				$clase_real_dias ="titulo_calendario_real_bien";
				}else{
					$clase_real_dias ="titulo_calendario_real_mal";
					}
		  
		  //congelado
		   $sel_congelado = "SELECT min(fecha) FROM           t2_acciones_admin WHERE (id_item = ".$id_item_pecc." and fecha >= '".$fecha_real_anterior."' and fecha <= '".$ac_resum[3]."' and detalle ='5. Cambiar el Estado del Proceso' and accion = 'Congelado')";
		   
			$sel_reactiva = "SELECT Max(fecha) FROM           t2_acciones_admin WHERE (id_item = ".$id_item_pecc." and fecha >= '".$fecha_real_anterior."' and fecha <= '".$ac_resum[3]."' and detalle ='5. Cambiar el Estado del Proceso' and accion = 'Activo')";
			
			
			if($_SESSION["id_us_session"]==32){
			//	echo "<br />".$sel_congelado;
				//echo "<br />".$sel_reactiva;
				}
				
				
		$fecha_congelado = traer_fila_row(query_db($sel_congelado));	
		$fecha_reactivo = traer_fila_row(query_db($sel_reactiva));
		
		if($fecha_congelado[0]!="" and $fecha_reactivo[0]!="" and $fecha_congelado[0] <$fecha_reactivo[0]){
		$dias_congelado = dias_habiles_entre_fechas($fecha_congelado[0],$fecha_reactivo[0]);
		}else{
			$dias_congelado = 0;
		}
					
				
	if ($ac_resum[7] <> 2){
		  $dias_retrazados="";
		  
		  $resta_dias_retraza=$dias_reales-$ac_resum[1]-$dias_congelado;
		  
		  if($resta_dias_retraza>0){
			  $dias_retrazados=$resta_dias_retraza;
			  }
		  
	  ?>
      <tr class="<?=$clase?>">
        <td align="center"><?=$numero_acti;?></td>
        <td><?=$ac_resum[0].", <strong>Encargado:</strong> <strong  style='font-size:10px'><font color='#005395'>".$ac_resum[8]."</font></strong>"?></td>
        <td align="center" class=""><?=number_format($ac_resum[1],0)?></td>
        <td align="center"><?=$fecha_ideal?></td>
        <td align="center" ><strong><?=$fecha_reprograma?></strong></td>
        <td align="center" class="<?=$clase_real?>">
          <?=$ac_resum[3]?>
        </td>
        <td align="center" class="<?=$clase_real_dias?>"><?=$dias_reales?></td>
        <td align="center" class="<?=$clase_real_dias?>">
		  
       <?
		  
		echo $dias_congelado;
		
		$fecha_real_anterior=$ac_resum[3];
			?>
       </td>
        <td align="center" class="<?=$clase_real_dias?>"><?=$dias_retrazados?></td>
      </tr>
      
      <?
	  $numero_acti = $numero_acti+1;
	  
	  $tt_valor_di_re = $dias_reales + $tt_valor_di_re;
	}
      }
	  $fecha_fin_ideal = $fecha_ideal;
	  

	  ?>
     <? 
	  if($muestra_legalizacion == "SI"){
		  ?>
      <tr>
        <td align="center"><?=$numero_acti?></td>
        <td align="left">Legalizaci&oacute;n del Documento Contractual</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td width="0%" align="center">&nbsp;</td>
      </tr>
       <?
	  tiempos_para_solicitudes($tipo_para_funcion, $id_para_funcion, 2); 
	  }?>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="center" >
        </td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <tr>
        <td align="center">&nbsp;</td>
        <td align="right" class="titulos_resumen_alertas"><strong>TOTAL</strong> 
        <? if($_SESSION["id_us_session"]=="no aplica"){?>
        <input type="button" name="sdsd" value="agrega apertura urna" onclick="agrega_gestion_urna_apertura()" /><br /><input type="button" name="sdsd" value="agrega tecnico" onclick="agrega_gestion_urna_tecnico()" /><br />
          <input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
          <?
		}
		  ?>
          
          </td>
        <td align="center"><strong><?=number_format($dias_ideales_total,0)?></strong></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center"><strong>
          <?=number_format($tt_valor_di_re,0)?>
        </strong></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <?
      if($sel_item[4]<>1){
		  
		  $sel_fecha_entrega = traer_fila_row(query_db("select t2.f_entrega from t2_archivos_sap as t1, t2_archivos_sap_pedido as t2 where t1.id_item = $id_item_pecc and  t1.id = t2.id_archivo_sap and t1.tipo='Pedido' and t1.accion ='Aprobar' order by t1.id desc"));		  
		  $fecha_propuesta_entrega = $sel_fecha_entrega[0];
		  if($fecha_propuesta_entrega <> ""){
			  $fecha_pro = $fecha_propuesta_entrega[0].$fecha_propuesta_entrega[1].$fecha_propuesta_entrega[2].$fecha_propuesta_entrega[3]."-".$fecha_propuesta_entrega[4].$fecha_propuesta_entrega[5]."-".$fecha_propuesta_entrega[6].$fecha_propuesta_entrega[7];
			  }
			

		$sel_fecha_real = traer_fila_row(query_db("select t2.fecha_rec_mat from t2_archivo_sap_entregas as t1, t2_archivo_sap_entregas_detalle as t2 where  t1.id_item = $id_item_pecc and t1.id = t2. id_archivo_entrega and t1.tipo_entrega='Total' order by t1.id desc"));		  
		  $fecha_real_entrega = explode(".",$sel_fecha_real[0]);
		  if($fecha_real_entrega <> ""){
			  $fecha_real_en = $fecha_real_entrega[2]."-".$fecha_real_entrega[1]."-".$fecha_real_entrega[0];
			  }
			  
		
		  
	  ?>
      <tr>
        <td align="center" class="filas_resultados">&nbsp;</td>
        <td align="left" class="filas_resultados"><strong>Fecha de Entrega</strong></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center" class="filas_resultados"><strong><?=$fecha_pro?></strong></td>
        <td align="center" class="filas_resultados"><strong><?=$fecha_real_en?></strong></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
      </tr>
      <?
	  }
	  ?>
      
    </table>
    </td>
    <td width="23%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
  <tr>
    <td valign="top">&nbsp;</td>
    <td valign="top">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" valign="top" id=""><?
	
	
	exit;
if($id_item_pecc <= 379 or ($id_item_pecc >= 520 and $id_item_pecc <= 559 )){
	exit;
	}	

	
	
	$consecutivo=0;
	$consecutivo_real=0;
	$num_actividad=$primera_actividad;
	$num_actividad_real=$primera_actividad;
	$fecha_inicio_queda = $fecha_empiesa;
	$selec_primera_gestion = traer_fila_row(query_db("select top 1 fecha_real from $vpeec_aplica where id_item =".$id_item_pecc."".$comple_sql." and fecha_real is not null group by fecha_real order by fecha_real asc"));
	
	$fecha_inicio_queda_real = $selec_primera_gestion[0];
	$monthNames = Array("Enero", "Febrero", "Marzo", "Abril", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre");
	
	
	 //VERIFICA PRIEMERA FECHA Y CUANTOS MESES PARA EL CALENDARIO


	if($fecha_inicio_queda_real<$fecha_inicio_queda){
		$fecha_inicio_ecplode = $fecha_inicio_queda_real;
		
		}else{
			$fecha_inicio_ecplode = $fecha_inicio_queda;
			
			}
			

	$ex_fe_calenda = explode("-",$fecha_inicio_ecplode);
	$fecha_empiesa_calendario = $ex_fe_calenda[0]."-".$ex_fe_calenda[1]."-01";
	
	
	// FIN VERIFICA PRIEMERA FECHA Y CUANTOS MESES PARA EL CALENDARIO
	
	
	 //VERIFICA ULTIMA FECHA Y CUANTOS MESES PARA EL CALENDARIO
	  $selec_ultima_fecha_real = traer_fila_row(query_db("select max(fecha_real) from $vpeec_aplica where id_item =".$id_item_pecc."".$comple_sql.""));
	  
	 if($selec_ultima_fecha_real[0] > $fecha_fin_ideal){
		 $fecha_termina_calendario = $selec_ultima_fecha_real[0];

		 }else{
			  $fecha_termina_calendario = $fecha_fin_ideal;
			 }
	// FIN VERIFICA ULTIMA FECHA Y CUANTOS MESES PARA EL CALENDARIO
		// CALCULA MESES PARA EL CALEMDARIO		
		//defino fecha 1 
			$ex_fe_1_ini = explode("-",$fecha_empiesa_calendario);
			$ano1 = $ex_fe_1_ini[0]; 
			$mes1 = $ex_fe_1_ini[1]; 
			$dia1 = $ex_fe_1_ini[2]; 

		//defino fecha 2 
			$ex_fe_2_fin = explode("-",$fecha_termina_calendario);
			$ano2 = $ex_fe_2_fin[0]; 
			$mes2 = $ex_fe_2_fin[1]; 
			$dia2 = $ex_fe_2_fin[2]; 

		//calculo timestam de las dos fechas 
		$timestamp1 = mktime(0,0,0,$mes1,$dia1,$ano1); 
		$timestamp2 = mktime(0,0,0,$mes2,$dia2,$ano2); 


		 $cuantos_segundos = $timestamp1 - $timestamp2;	
		 $cuantos_dias = $cuantos_segundos / (60 * 60 * 24);
		 $cuantos_dias = abs($cuantos_dias); 
		 $cuantos_dias = floor($cuantos_dias); 
		 $cuantos_meses = $cuantos_dias / 30;
		 $cuantos_meses = abs($cuantos_meses); 
		 $cuantos_meses = floor($cuantos_meses); 
		// echo "Fecha Final: ".$fecha_termina_calendario." - Fecha Inicial: ".$fecha_empiesa_calendario." Dias: ".$cuantos_dias." Cuantos Meses: ".$cuantos_meses;
		 	
		//FIN CALCULA MASES
	
	for($messi = 0; $messi <= $cuantos_meses; $messi++){
    
	$explode_fecha = explode("-",$fecha_empiesa_calendario);
$cMonth = $explode_fecha[1];
$cYear = $explode_fecha[0]; 
$timestamp = mktime(0,0,0,$cMonth,1,$cYear);
$maxday = date("t",$timestamp);
$thismonth = getdate ($timestamp);
$startday = $thismonth['wday'];

$fecha_empiesa_calendario = date("Y-m-d", strtotime("$fecha_empiesa_calendario +1 month"));
?>
<table width="100%" class="tabla_lista_resultados" align="center">
    <tr>
    <td align="center">
    	<table width="100%" border="0" cellpadding="2" cellspacing="2">
        	<tr align="center"><td colspan="7" class="fondo_3"><strong><?php echo $monthNames[$cMonth-1].' '.$cYear; ?></strong></td>
            </tr>
            <tr>
            <td width="5%" align="center" class="fondo_desactiva_calendario"><strong>Dom.</strong></td>
            <td width="18%" align="center" class="fondo_titulu_calendario"><strong>Lunes</strong></td>
            <td width="18%" align="center" class="fondo_titulu_calendario"><strong>Martes</strong></td>
            <td width="18%" align="center" class="fondo_titulu_calendario"><strong>Miercoles</strong></td>
            <td width="18%" align="center" class="fondo_titulu_calendario"><strong>Jueves</strong></td>
            <td width="18%" align="center" class="fondo_titulu_calendario"><strong>Viernes</strong></td>
            <td width="5%" align="center"  class="fondo_desactiva_calendario"><strong>Sab.</strong></td></tr>

<? 
	
	
	for ($i=0; $i<($maxday+$startday); $i++) { 
			$fecha_actua = date("Y-m-d", strtotime($cYear."-".$cMonth."-".($i - $startday + 1)));   
		if(($i % 7) == 0 ) { echo "<tr>";  }  
		if($i < $startday) {
				echo "<td></td>"; 
				}else {
					$dia_habil = accion_fecha($cYear,$cMonth,($i - $startday + 1));
					if($dia_habil == "NA" ){ 
						$stilo = "fondo_desactiva_calendario";
						}else{
							$stilo = "fondo_activa_calendario";
							}
						?>
					<td  height='70px' class='<?=$stilo?>' valign="top">
                    	<table width="100%" border="0">
                          <tr>
                            <td align='right' valign='top'><?=($i - $startday + 1);?></td>
                          </tr>
                          <tr>
                            <td class="texto_calendario" align="left" valign="top"><?
           		//BUSCA_FECHA_IDEAL

		   $selec_actividad = query_db("select actividad_estado_id,actividad_estado,detalle, tiempo_para_actividad from $vpeec_aplica where id_item =".$id_item_pecc."".$comple_sql." and actividad_estado_id >= $num_actividad order by actividad_estado_id asc");
		   
		   while($sel_actividad = traer_fila_db($selec_actividad)){
			if($fecha_inicio_queda == $fecha_actua){
				$consecutivo = $consecutivo+1;
				echo  "<strong><span title='".$sel_actividad[2]."' class='titulo_calendario_ideal' > * ".$consecutivo.". ".$sel_actividad[1]."</span></strong><br />";	
				$sele_siguiente_fecha = traer_fila_row(query_db("select top 1 tiempo_para_actividad,actividad_estado_id from $vpeec_aplica where id_item =".$id_item_pecc."".$comple_sql." and actividad_estado_id > ".$sel_actividad[0]." order by actividad_estado_id asc"));
				$fecha_inicio_queda = restar_fechas($fecha_requiere, number_format($sele_siguiente_fecha[0],0));
				$num_actividad = $sele_siguiente_fecha[1];
				}					
			}
				//FIN BUSCA FECHA IDEAL
				
				//BUSCA REAL
				
		   $selec_actividad_real = query_db("select actividad_estado_id,actividad_estado,detalle, tiempo_para_actividad,fecha_real,nom_us_gestiona from $vpeec_aplica where id_item =".$id_item_pecc."".$comple_sql." and actividad_estado_id >= $num_actividad_real order by actividad_estado_id asc");
		  
		   while($sel_actividad_real = traer_fila_db($selec_actividad_real)){
			if($fecha_inicio_queda_real == $fecha_actua){
				$consecutivo_real = $consecutivo_real+1;
				
				$fecha_ideal_actividad = restar_fechas($fecha_requiere, number_format($sel_actividad_real[3],0));
				if($sel_actividad_real[4] <= $fecha_ideal_actividad){
				$clase_real ="titulo_calendario_real_bien";
				}else{
					$clase_real ="titulo_calendario_real_mal";
					}
				
				echo  "<span title='".$sel_actividad_real[2]."; Usuario: ".$sel_actividad_real[5]."' class='".$clase_real."' > * ".$consecutivo_real.". ".$sel_actividad_real[1]."</span><br />";	
				
								
				$sele_siguiente_fecha = traer_fila_row(query_db("select top 1 tiempo_para_actividad,actividad_estado_id,fecha_real from $vpeec_aplica where id_item =".$id_item_pecc."".$comple_sql." and actividad_estado_id > ".$sel_actividad_real[0]." order by actividad_estado_id asc"));

						$fecha_inicio_queda_real = $sele_siguiente_fecha[2];

				
				
						$num_actividad_real = $sele_siguiente_fecha[1];

				}					
			}
				//FIN BUSCA FECHA REAL
			   
							?></td>
                          </tr>
                        </table>
</td>
                    <?
				}
		if(($i % 7) == 6 ){ 
			echo "</tr>";
			}
		}
		?>
    </table></td></tr></table>
    <?
	}
	?>
    </td>
  </tr>
</table>
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />


</body>
</html>
