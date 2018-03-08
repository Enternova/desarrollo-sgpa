<? include("../../librerias/lib/@session.php"); 

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Soporte Detallado de Solicitudes (Solo Abastecimiento).xls");

?>

<table width="100%" border="1">
  <tr>
    <td colspan="16" align="center" bgcolor="#E4E4E4">&nbsp;</td>
    <td colspan="7" align="center" bgcolor="#3399FF"><pre>Gestiones</pre></td>
  </tr>
  <tr>
    <td width="6%" align="center" bgcolor="#E4E4E4"><pre>N&uacute;mero</pre></td>
    <td width="21%" align="center" bgcolor="#E4E4E4"><pre>Profesional Asignado</pre></td>
    <td width="14%" align="center" bgcolor="#E4E4E4"><pre>Tipo del Proceso</pre></td>
    <td width="4%" align="center" bgcolor="#E4E4E4"><pre>Area</pre></td>
    <td width="19%" align="center" bgcolor="#E4E4E4"><pre>Congelado</pre></td>
    <td width="18%" align="center" bgcolor="#E4E4E4"><pre>Fecha de Creaci&oacute;n</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Fecha en la que se puso en firme</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Nivel de Aprobaci&oacute;n</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Estado Actual</pre></td>
    <td align="center" bgcolor="#E4E4E4"><pre>Rechazado</pre></td>
    <td align="center" bgcolor="#E4E4E4"><pre>Declarado Desierto</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Primera Fecha Reprogramada</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Fecha Estimada de Finalizaci&oacute;n</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Fecha de Finalizaci&oacute;n</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Estado General del Proceso</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Campos Relacionados</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Etapa</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Encargado</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Usuario que Ejecuta la Acci&oacute;n</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>D&Iacute;as Estimados</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>D&iacute;as Reales</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Dias Congelado</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>D&iacute;as de Retraso</pre></td>
  </tr>
  <?
	$actividados_no_muesstra = "";
  
	/** PARA EL DES002-18 **/
	$ano=$_SESSION["ses_ano"];
	if($ano>=2017){
		$count_ano=traer_fila_row(query_db("SELECT COUNT(*) FROM version_2_indi_soporte_3_solo_abastecimiento_v2 WHERE ano=".$ano));
		if($count_ano[0]==0){
			$ano=traer_fila_row(query_db("SELECT MAX(ano) FROM version_2_indi_soporte_3_solo_abastecimiento_v2"));
			$actividados_no_muesstra.=" and ano=".$ano[0];
		}else{
			$actividados_no_muesstra.=" and ano=".$ano;
		}
		$vpeec_aplica="version_2_indi_soporte_3_solo_abastecimiento_v2";
	}else{
		$vpeec_aplica="version_2_indi_soporte_3_solo_abastecimiento";
	}
	/** PARA EL DES002-18 **/
  	$sel_1 = query_db("select * from ".$vpeec_aplica." ".$_SESSION["comple_filtro4"]." ".$actividados_no_muesstra."    and t2_nivel_servicio_actividad_id IN (4,5,6,11,12,13,14) order by id_item, t2_nivel_servicio_actividad_id asc");
	
	
	
	
	
	while($s_1 = traer_fila_db($sel_1)){
		
		$rechazado="";
		$desierto="";
		if($s_1[26]==1){
			$rechazado="SI";
			}
		if($s_1[27]==1){
			$desierto="SI";
			}
			
		
		$profesional_gestion=$s_1[3];
		
			if($s_1[28]==2 and $s_1[9] <> 0){
	$sele_gestion_profesional = traer_fila_row(query_db("select * from t2_nivel_servicio_gestiones where id_item=".$s_1[20]." and t2_nivel_servicio_actividad_id = ".$s_1[23]."  and estado=1"));
			
			if($s_1[9]<>$sele_gestion_profesional[3]){
					$sele_nom_pro = traer_fila_row(query_db("select nombre_administrador from t1_us_usuarios where us_id=".$sele_gestion_profesional[3]));
					$profesional_gestion=$sele_nom_pro[0];
				}
	
			}
			
			$s_primera_fecha = traer_fila_row(query_db("select fecha_real from t2_nivel_servicio_gestiones where id_item=".$s_1[20]." and t2_nivel_servicio_actividad_id = 1  and estado=1"));
	
	
			$s_usuario_gestion = traer_fila_row(query_db("select t1_us_usuarios.nombre_administrador from t2_nivel_servicio_gestiones, t1_us_usuarios where t2_nivel_servicio_gestiones.id_item=".$s_1[20]." and t2_nivel_servicio_gestiones.t2_nivel_servicio_actividad_id = ".$s_1[23]."  and t2_nivel_servicio_gestiones.estado=1 and t1_us_usuarios.us_id = t2_nivel_servicio_gestiones.id_usua"));
			
			if($s_1[23] <> 7 and $s_1[23] <> 16){
				$usu_gestiona = $s_usuario_gestion[0];
				}else{
					$usu_gestiona = "";
					}
			$sel_campos_relacionados = query_db("select distinct t2.nombre from t2_presupuesto as t1, t1_campo as t2 where t1.t2_item_pecc_id = ".$s_1[20]." and t1.t1_campo_id = t2.t1_campo_id");
			
			$campos_rela="";
			while($sel_campos = traer_fila_db($sel_campos_relacionados)){
				
				if($campos_rela==""){
					$campos_rela = $sel_campos[0];
					}else{
						$campos_rela = $sel_campos[0].",".$campos_rela;
						}
				
				
				}
  ?>
  <tr>
    <td><?=numero_item_pecc($s_1[0],$s_1[1],$s_1[2])?></td>
    <td><?=$profesional_gestion?></td>
    <td><?=$s_1[5]?> <? if($s_1[31]==1) echo " - Modificaci&oacute;n";?></td>
    <td><?=$s_1[6]?></td>
    <td><? if($s_1[7] == 1) {echo "Congelado";} ?></td>
    <td><?=$s_1[4]?></td>
    <td><?=$s_1[32]?></td>
    <td><?=$s_1[15]?></td>
    <td><? if($s_1[14]>=20 and $s_1[14]<32) echo "En Legalizacion"; else echo $s_1[8]; ?></td>
    <td><?=$rechazado?></td>
    <td><?=$desierto?></td>
    <td><?=$s_primera_fecha[0]?></td>
    <td><?=$s_1[17]?></td>
    <td><?=$s_1[18]?></td>
    <td><?=$s_1[19]?></td>
    <td><?=$campos_rela?></td>
    <td><?=$s_1[21]?></td>
    <td><?=$s_1[22]?></td>
    <td><?=$usu_gestiona?></td>
    <td><?=number_format($s_1[24],0)?></td>
    <td><? if($s_1[25]==100000) echo ""; else echo $s_1[25];?></td>
    <td><? if($s_1[25]!=100000) echo $s_1[30];?></td>
    <td><?
    if($s_1[25]!=100000){
	$disas_atrazados = ($s_1[25]-$s_1[30])-$s_1[24];
	if($disas_atrazados <0){
		echo 0;
		}else{
			echo $disas_atrazados;
			}
	}
	?></td>
    <?
				
	?>
  </tr>
  <?
  
  
  if($s_1[23]==7 or $s_1[23]==16){//valida se firmas en el sistema para agregar las filas de los roles

if($s_1[23]==7){
		$permiso_adjudica=1;
}
if($s_1[23]==16){
		$permiso_adjudica=2;
}

				$sel_propuestos_real = query_db("select id_rol, rol,orden from $vpeec15 where id_item_pecc = ".$s_1[20]." and tipo_adj_permiso = $permiso_adjudica and id_rol not in (10,11, 8, 15) group by id_rol, rol,orden order by orden");
		$cont = 0;
		while($sel_p_real = traer_fila_db($sel_propuestos_real)){
			
			$sel_id_apro_ultima = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = ".$sel_p_real[0]." and tipo_adj_permiso = $permiso_adjudica and id_item_pecc = ".$s_1[20]));
			
			$sel_ultima_aprobacion = traer_fila_row(query_db("select * from v_peec_agl_real_aprobacion where id_aprobacion = ".$sel_id_apro_ultima[0]));
			
			
			$sel_id_apro_profesional = traer_fila_row(query_db("select max(id_aprobacion) from $vpeec16 where id_rol = 8 and tipo_adj_permiso = $permiso_adjudica and id_item_pecc = ".$s_1[20]));
			
			$sel_ultima_aprobacion_profesional = traer_fila_row(query_db("select * from $vpeec16 where id_aprobacion = ".$sel_id_apro_profesional[0]));
			
			$fecha_aprobacion_rol=$sel_ultima_aprobacion[4];
			$fecha_aprobacion_profesional=$sel_ultima_aprobacion_profesional[4];
			
			
			if($fecha_aprobacion_profesional<>"" and $fecha_aprobacion_rol <> "" and $fecha_aprobacion_profesional<=$fecha_aprobacion_rol){
			$dias_rol=dias_habiles_entre_fechas($fecha_aprobacion_profesional,$fecha_aprobacion_rol);
			}
			
			$s_primera_fecha = traer_fila_row(query_db("select fecha_real from t2_nivel_servicio_gestiones where id_item=".$s_1[20]." and t2_nivel_servicio_actividad_id = 1 and estado=1"));
			?>
			<tr>
    <td><?=numero_item_pecc($s_1[0],$s_1[1],$s_1[2])?></td>
    <td><?=$profesional_gestion?></td>
    <td><?=$s_1[5]?></td>
    <td><?=$s_1[6]?></td>
    <td><? if($s_1[7] == 1) {echo "Congelado";} ?></td>
    <td><?=$s_1[4]?></td>
    <td><?=$s_1[32]?></td>
    <td><?=$s_1[15]?></td>
    <td><?=$s_1[8]?></td>
    <td><?=$rechazado?></td>
    <td><?=$desierto?></td>
    <td><?=$s_primera_fecha[0]?></td>
    <td><?=$s_1[17]?></td>
    <td><?=$s_1[18]?></td>
    <td><?=$s_1[19]?></td>
    <td><?=$campos_rela?></td>
    <td><?=$s_1[21]?></td>
    <td style="background-color:#9FF"><?=$sel_p_real[1]?></td>
    <td><?=$sel_ultima_aprobacion[6];?></td>
    <td></td>
    <td style="background-color:#9FF"><? if($dias_rol>$s_1[25]) { echo $s_1[25];}else{ echo $dias_rol;}?></td>
    <td></td>
    <td></td>
    <?
				
	?>
  </tr>
			<?
			
		}
				
				}//si la actividad es firmas en el ssistema
  
  
	}
  ?>
</table>


	</html>