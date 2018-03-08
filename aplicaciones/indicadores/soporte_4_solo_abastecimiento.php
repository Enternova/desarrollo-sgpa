<? include("../../librerias/lib/@session.php"); 

header("Content-Type: application/vnd.ms-excel");
header("Expires: 0");
header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
header("content-disposition: attachment;filename=Soporte Consolidado de Solicitudes (Solo Abastecimiento).xls");

?>

<table width="100%" border="1">
  <tr>
    <td width="6%" align="center" bgcolor="#E4E4E4"><pre>N&uacute;mero</pre></td>
    <td width="21%" align="center" bgcolor="#E4E4E4">Objeto de la Solicitud</td>
    <td width="21%" align="center" bgcolor="#E4E4E4">Objeto de la solicitud Adjudicacion</td>
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
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Fecha Estimada de Finalizaci&oacute;n</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Fecha de Finalizaci&oacute;n</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Estado General del Proceso (Teniendo en cuenta unicamente las etapas de abastecimiento)</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Usd Permiso</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Cop Permiso</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Usd Adjudicacion</pre></td>
    <td width="12%" align="center" bgcolor="#E4E4E4"><pre>Cop Adjudicacion</pre></td>
  </tr>
  <?
 // $campos_vista_soporte="*";
  //if($_SESSION["version_2_indi_soporte_2"] == "version_2_indi_soporte_2"){
  
  $campos_vista_soporte = "num1, num2, num3, profesional, fecha_creacion, tipo_proceso, area, congelado, estado_nombre, id_us_profesional_asignado, t1_tipo_proceso_id, t1_area_id, tiempos_estandar, de_historico, estado, nivel_aprobacion, nivel_aprobacion, fecha_reprograma_fin, fecha_finalizacion, estado_atrazado_atiempo_solo_abastecimiento, id_item, t2_nivel_servicio_id, solicitud_rechazada, solicitud_desierta, CAST(objeto_solicitud AS TEXT), CAST(ob_solicitud_adjudica AS TEXT), t1_tipo_contratacion_id, es_modificacion, fecha_en_firme";
  
 // }
  
  

  	$sel_1 = query_db("select $campos_vista_soporte from version_2_indi_estado_procesos_solo_abastecimiento ".$_SESSION["comple_filtro4"]." ");
	
	
	
	
	while($s_1 = traer_fila_db($sel_1)){
		
		$rechazado="";
		$desierto="";
		if($s_1[22]==1){
			$rechazado="SI";
			}
		if($s_1[23]==1){
			$desierto="SI";
			}

		
		$valor_cop_permiso = 0;
		$valor_usd_permiso = 0;
		$valor_cop_ad = 0;
		$valor_usd_ad = 0;
		
		
		
		$sel_valor_permiso = traer_fila_row(query_db("select sum(valor_usd),sum(valor_cop) from t2_presupuesto where t2_item_pecc_id = ".$s_1[20]." and permiso_o_adjudica = 1"));
		$sel_valor_ad = traer_fila_row(query_db("select sum(valor_usd),sum(valor_cop) from t2_presupuesto where t2_item_pecc_id = ".$s_1[20]." and permiso_o_adjudica = 2"));
		
		$valor_cop_permiso = $sel_valor_permiso[1];
		$valor_usd_permiso = $sel_valor_permiso[0];;
		$valor_cop_ad = $sel_valor_ad[1];
		$valor_usd_ad = $sel_valor_ad[0];
		
		
		if($s_1[10]==11 or $s_1[10]==9 or $s_1[10]==10 or $s_1[10]==12){//informativo
		$valor_cop_ad=0;
		$valor_usd_ad=0;
		}
		
		if($s_1[10]==4 or $s_1[10]==5 or $s_1[10]==13 or $s_1[10]==14){//informativo
		$valor_cop_permiso=0;
		$valor_usd_permiso=0;
		}
		
  ?>
  <tr>
    <td><?=numero_item_pecc($s_1[0],$s_1[1],$s_1[2])?></td>
    <td><?=$s_1[24]?></td>
    <td><?=$s_1[25]?></td>
    <td><?=$s_1[3]?></td>
    <td><?=$s_1[5]?> <? if($s_1[27]==1) echo " - Modificaci&oacute;n";?></td>
    <td><?=$s_1[6]?></td>
    <td><? if($s_1[7] == 1) {echo "Congelado";} ?></td>
    <td><?=$s_1[4]?></td>
    <td><?=$s_1[28]?></td>
    <td><? $sel_nivel = traer_fila_row(query_db("select nombre from t2_nivel_aprobacion where id = ".$s_1[15]));
		if($s_1[15]>0){
			echo $sel_nivel[0];
			
		}
		?></td>
    <td><? if($s_1[14]>=20 and $s_1[14]<32) echo "En Legalizacion"; else echo $s_1[8]; ?></td>
    <td><?=$rechazado?></td>
    <td><?=$desierto?></td>
    <td><?=$s_1[17]?></td>
    <td><?=$s_1[18]?></td>
    <td><?=$s_1[19]?></td>
    <td><?=number_format($valor_usd_permiso,0,'','')?></td>
    <td><?=number_format($valor_cop_permiso,0,'','')?></td>
    <td><?=number_format($valor_usd_ad,0,'','')?></td>
    <td><?=number_format($valor_cop_ad,0,'','')?></td>
    <?
    	
	?>
  </tr>
  <?
	}
  ?>
</table>


	</html>