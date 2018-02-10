<? 
header("Content-type: application/octet-stream");//indicamos al navegador que se está devolviendo un archivo
header("Content-Disposition: attachment; filename=reporte General.xls");//con esto evitamos que el navegador lo grabe en su caché
header("Pragma: no-cache");
header("Expires: 0");

include("../../librerias/lib/@include.php");
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER



?>
<table width="100%" border="1">
  <tr>
    <td colspan="9" align="center">General</td>
    <td colspan="12" align="center">Permiso</td>
    <td colspan="8" align="center">Adjudicacion</td>
    <td colspan="3" align="center">Documentos</td>
  </tr>
  <tr>
    <td align="center">id solicitud</td>
    <td align="center">Numero solicitud</td>
    <td align="center">Tipo de proceso</td>
    <td align="center">Estado</td>
    <td align="center">Congelado</td>
    <td align="center">Carga Masiva</td>
    <td align="center">Fecha de creacion en el sistema</td>
    <td align="center">Fecha para Cuando se Requiere</td>
    <td align="center">area</td>
    <td align="center">ob solicitud</td>
    <td align="center">ob contrato</td>
    <td align="center">Alcance </td>
    <td align="center">Justificacion Comercial</td>
    <td align="center">Justificacion Tecnica</td>
    <td align="center">Criterios de Evaluacion</td>
    <td align="center">Recomendacion</td>
    <td align="center">proveedores sugeridos</td>
    <td align="center">Gerente Solicutd</td>
    <td align="center">Profesional de C&amp;C</td>
    <td align="center">Valor USD</td>
    <td align="center">valor COP</td>
    <td align="center">Objeto solicitud Adjudicacion</td>
    <td align="center">Objeto contrato adjudicacion</td>
    <td align="center">Alcance Adjudicacion</td>
    <td align="center">Justificacion Comercial adjudicacion</td>
    <td align="center">Justificacion Tecnica adjudicacion</td>
    <td align="center">recomendacion adjudicacion</td>
    <td align="center">valor adjudicacion USD</td>
    <td align="center">valor adjudicacion COP</td>
    <td align="center">Proveedores</td>
    <td align="center">Contratos Relacionados</td>
    <td align="center">Numero Otro SI</td>
  </tr>
  <?
  $sel_repor = query_db("select id_item, num1, num2, num3, tipo_proceso, Estado, area, objeto_solicitud, objeto_contrato, alcance, justificacion, recomendacion, proveedores_sugeridos, gerente_solicitud, Profesional, ob_solicitud_adjudica, ob_contrato_adjudica, alcance_adjudica, justificacion_adjudica, recomendacion_adjudica, consecutivo, fecha_creacion, apellido, numero_otrosi, justificacion_tecnica, justificacion_tecnica_ad, criterios_evaluacion, de_historico, congelado, usd_permiso, cop_permiso, usd_ad, cop_ad, Expr1,estado_id_sol, t1_tipo_proceso_id,fecha_se_requiere from vista_reporte_edwin_3");
  while($sel_r = traer_fila_db($sel_repor)){
	  
	  $numero_consecut = numero_item_pecc($sel_r[1],$sel_r[2],$sel_r[3]);
	  
	  	
	 //$numero_contrato =  numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4);
		
  ?>
  <tr>
    <td><?=$sel_r[0]?></td>
    <td><?=$numero_consecut?></td>
    <td><?=$sel_r[4]?></td>
    <td><?=$sel_r[5]?></td>
    <td><? if($sel_r[28] == 2 or $sel_r[28] == "NULL" or $sel_r[28] == "") echo "NO"; else echo "SI";?></td>
    <td><? if($sel_r[27] == " " or $sel_r[27] == "NULL" or $sel_r[27] == "") echo "NO"; else echo "SI";?></td>
    <td><?=$sel_r[21]?></td>
    <td><?=$sel_r[36]?></td>
    <td><?=$sel_r[6]?></td>
    <td><?=$sel_r[7]?></td>
    <td><?=$sel_r[8]?></td>
    <td><?=$sel_r[9]?></td>
    <td><?=$sel_r[10]?></td>
    <td><?=$sel_r[24]?></td>
    <td><?=$sel_r[26]?></td>
    <td><?=$sel_r[11]?></td>
    <td><?=$sel_r[12]?></td>
    <td><?=$sel_r[13]?></td>
    <td><?=$sel_r[14]?></td>
    <td><?=number_format($sel_r[29],0,'','')?></td>
    <td><?=number_format($sel_r[30],0,'','')?></td>
    <td><?=$sel_r[15]?></td>
    <td><?=$sel_r[16]?></td>
    <td><?=$sel_r[17]?></td>
    <td><?=$sel_r[18]?></td>
    <td><?=$sel_r[25]?></td>
    <td><?=$sel_r[19]?></td>
    <td><?=number_format($sel_r[31],0,'','')?></td>
    <td><?=number_format($sel_r[32],0,'','')?></td>
    <td><?
    $contratista = "";
	$tiene_coma = "";
	$coma_contratista="";
	$tipo_proceso = $sel_r[35];
	$sel_id_contrato_rel = traer_fila_row(query_db("select contrato_id from t2_item_pecc where id_item =".$sel_r[0]));
	
	if($sel_r[34] > 14 and $sel_r[34] != 31){
		$permiso_ad = 2;
		}else{
			$permiso_ad = 1;
			}
	
	if($tipo_proceso == 4 or $tipo_proceso == 5 or $tipo_proceso == 11 or $tipo_proceso == 12){

		$sel_contr = query_db("select t1.consecutivo, t1.creacion_sistema, t1.apellido, t2.razon_social from t7_contratos_contrato as t1, t1_proveedor as t2 where t1.contratista = t2.t1_proveedor_id and t1.id = ".$sel_id_contrato_rel[0]);
			while($sel_apl = traer_fila_db($sel_contr)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					
					echo numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4);
					$contratista=  $sel_apl[3];
			}
		
		}
		
		if(($tipo_proceso == 1 or $tipo_proceso == 2 or $tipo_proceso == 3 or $tipo_proceso == 6) and $permiso_ad ==2){
			
								
					
					$sel_contr_sql = query_db("select t1.consecutivo, t1.creacion_sistema, t1.apellido, t2.razon_social from t7_contratos_contrato as t1, t1_proveedor as t2 where t1.contratista = t2.t1_proveedor_id and t1.id_item = ".$sel_r[0]);
					
						while($sel_contr = traer_fila_db($sel_contr_sql)){
						
							$numero_contrato1 = "C";			
							$separa_fecha_crea = explode("-",$sel_contr[1]);
							$ano_contra = $separa_fecha_crea[0];
							
							$numero_contrato2 = substr($ano_contra,2,2);
							$numero_contrato3 = $sel_contr[0];
							$numero_contrato4 = $sel_contr[2];
						
						if($tiene_coma <> ""){
							echo $tiene_coma;
							$coma_contratista = ", ";
						}else{
							$tiene_coma = ", ";
							}
							
							echo numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4);
							$contratista.=  $coma_contratista.$sel_contr[3];
						}	
							
			
			
		}
		
				
			if($tipo_proceso == 7 or $tipo_proceso == 8){
				
		
				
				$sel_contr_ampl = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista from $pi12 as t1, $co1 as t2, t2_presupuesto as t3 where t1.t7_contrato_id = t2.id and t1.t2_presupuesto_id = t3.t2_presupuesto_id and t3.t2_item_pecc_id = ".$sel_r[0]." group by t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.contratista");
				
			while($sel_apl = traer_fila_db($sel_contr_ampl)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					if($tiene_coma <> ""){
							echo $tiene_coma;
							$coma_contratista = ", ";
						}else{
							$tiene_coma = ", ";
							}
					echo numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4);
					
					$sel_contratisr = traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id = ".$sel_apl[3]));
					$contratista.=  $coma_contratista.$sel_contratisr[0];
			}
				
				
			}
			
	$contratis_permi="";
	
	if(($tipo_proceso == 1 or $tipo_proceso == 2 or $tipo_proceso == 3 or $tipo_proceso == 6) and $permiso_ad ==1){

	$contratistas_permiso = query_db("select t2.razon_social from t2_relacion_proveedor as t1, t1_proveedor as t2 where t1.id_item = ".$sel_r[0]." and t1.id_proveedor = t2.t1_proveedor_id");
	while ($sel_pro_permiso = traer_fila_db($contratistas_permiso)){
	
	$contratis_permi = $sel_pro_permiso[0]." - ".$contratis_permi;
	
	}
	if($contratis_permi == ""){
	$contratis_permi=$sel_r[32];
	}
	}
	?> <?=$contratista?> <?=$contratis_permi?></td>
    <td><?=contratos_relacionados_solicitud_para_campos($sel_r[0])?></td>
    <td><?=$sel_r[33]?></td>
  </tr>
  <?
  $numero_contrato="";
  }
  ?>
</table>

