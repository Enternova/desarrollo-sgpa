<? include("../../librerias/lib/@session.php");

$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));

 $busca_contrato = "select  id, id_item, consecutivo, objeto, nit, contratista, contacto_principal, email1, telefono1, gerente, fecha_inicio, vigencia_mes, aplica_acta_inicio, 
                         representante_legal, email2, telefono2, especialista, monto_usd, monto_cop, creacion_sistema, recibido_abastecimiento, sap, revision_legal, firma_hocol, 
                         firma_contratista, revision_poliza, legalizacion_final, estado, sap_e, revision_legal_e, firma_hocol_e, firma_contratista_e, revision_poliza_e, legalizacion_final_e, 
                         t1_tipo_documento_id, acta_socios, recibido_poliza, camara_comercio, ok_fecha, sel_representante, legalizacion_final_par, legalizacion_final_par_e, 
                         analista_deloitte, apellido, aplica_acta, recibo_poliza, fecha_informativa, fecha_informativa_e, recibido_abastecimiento_e, area_ejecucion, obs_congelado, 
                         aplica_portales, destino, aseguramiento_admin, tipo_bien_servicio, aplica_garantia, porcentaje, en_que_momento, informe_hse, oferta_mercantil, garantia_seguro, 
                         gerente_por_aseguramiento

 from $co1 where id = $id_contrato_arr";
 


	$sql_con=traer_fila_row(query_db($busca_contrato));	

$numero_contrato1 = "C";			
$separa_fecha_crea = explode("-",$sql_con[19]);
$ano_contra = $separa_fecha_crea[0];					
$numero_contrato2 = substr($ano_contra,2,2);
$numero_contrato3 = $sql_con[2];
$numero_contrato4 = $sql_con[43];

$num_impri = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sql_con[0]);
	

$sub_var_usd = 0;
  $sub_var_cop = 0;
  
		   $rowSR = traer_fila_db(query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado, $pi2.fecha_creacion, $pi2.id_item from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where $pi2.id_item =".$sql_con[1].""));
				

					$sel_valores = traer_fila_row(query_db("select SUM(t1.valor_usd), SUM(t1.valor_cop) from t2_presupuesto as t1, t2_presupuesto_aplica_contrato as t2 where t1.t2_item_pecc_id = ".$rowSR[7]." and t1.t2_presupuesto_id = t2.t2_presupuesto_id and t2.t7_contrato_id = ".$id_contrato_arr."  and t1.permiso_o_adjudica = 2 and t1.al_valor_inicial_para_marco is null"));
					  $sub_var_usd = $sub_var_usd + $sel_valores[0];
  					$sub_var_cop = $sub_var_cop + $sel_valores[1];
		
	?>


<head>
<title>Documento sin t&iacute;tulo</title>


<style>
@charset "utf-8";
body {
	color:#676767;
	font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif, Tahoma,Arial, Helvetica, sans-serif;
	font-size:12px;
	margin-top: 2px;
	background:#F8F8F8;
}

.titulo_principal{
	font-size:16px;
	border: 1px solid #000000;
	background-color:#FFF;
	color:#999;
	}
.titulo_principal_2{
	font-size:16px;
	background-color:#999;
	color:#FFF;
	}
.titulo_principal_3{
	font-size:12px;
	background-color:#999;
	color:#FFF;
	}
.tabla_principal{
	background-color:#FFF;
	border: 1px solid #000000;
	}

.titulo_datos_contrato{
	font-size:10px;
	border: 1px solid #000000;
	}
.tabla_datos_contrato{
	background-color:#FFF;
	}
.fondo_3{ background:#005395; color:#FFFFFF;}
.fondo_5{ background:#6C3; color:#FFFFFF;}


</style>

<body>

<p>&nbsp;</p>
<table width="80%" border="0" align="center">
  <tr>
  <td>&nbsp;</td>
    <td colspan="7" align="center" class="titulo_principal"><strong>REPORTE DE ANTECEDENTES DE CONTRATO</strong></td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td colspan="7" align="right">&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td colspan="7" align="right" class="tabla_datos_contrato"><table width="100%" border="1" cellpadding="0" cellspacing="0">
      <tr class="titulo_datos_contrato">
        <td width="11%" align="right"><strong>Contrato: </strong></td>
        <td width="89%" align="left"><? if($sql_con[34] != 2){ echo $num_impri;}else{ $sel_contras_marco = query_db("select consecutivo, creacion_sistema, apellido, id from t7_contratos_contrato where id_item = ".$sql_con[1]." and estado <> 50");}
		while($sel_cont_mar = traer_fila_db($sel_contras_marco)){
			$numero_contrato1 = "C";			
$separa_fecha_crea = explode("-",$sel_cont_mar[1]);
$ano_contra = $separa_fecha_crea[0];					
$numero_contrato2 = substr($ano_contra,2,2);
$numero_contrato3 = $sel_cont_mar[0];
$numero_contrato4 = $sel_cont_mar[2];

echo " ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_cont_mar[3]);
	
			}
		?></td>
        </tr>
      <tr class="titulo_datos_contrato">
        <td align="right"><strong>Tipo Contrato:</strong></td>
        <td align="left"><?
         if($sql_con[34]==1){
		 	
			if($sql_con[57]==1){
				echo "ACEPTACION DE OFERTA MERCANTIL";
			}else{
				echo "CONTRATO PUNTUAL";
				}

		 }else{
			echo "CONTRATO MARCO";
		 }
		 ?></td>
        </tr>
        <?
//  if($sql_con[34] != 2){
  ?>
      <tr class="titulo_datos_contrato">
        <td align="right"><strong>Objeto del Contrato:</strong></td>
        <td align="left"><?=$sql_con[3]?></td>
        </tr>
      <tr class="titulo_datos_contrato">
        <td align="right"><strong>Fecha Inicio del Contrato:</strong></td>
        <td align="left"><?=$sql_con[10]?></td>
        </tr>
      <tr class="titulo_datos_contrato">
        <td align="right"><strong>Fecha Fin del Contrato:</strong></td>
        <td align="left"><?=$sql_con[11]?></td>
        </tr>
       <?
 // }
	   ?>
    </table></td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td colspan="7" class="tabla_principal"><table width="100%" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="7" align="center" class="titulo_principal_2"><strong>Solicitudes aprobadas en el SGPA</strong></td>
      </tr>
      <tr>
        <td width="11%" align="center" class="fondo_3">N&uacute;mero Solicitud</td>
        <td width="18%" align="center" class="fondo_3">Tipo proceso</td>
        <td width="19%" align="center" class="fondo_3">Tipo Otros&iacute;</td>
        <td width="11%" align="center" class="fondo_3">N&uacute;mero</td>
        <td width="11%" align="center" class="fondo_3">Valor USD</td>
        <td width="13%" align="center" class="fondo_3">Valor COP</td>
        <td width="17%" align="center" class="fondo_3">Estado</td>
      </tr>
      <tr>
        <td align="center"><? $numero_genero_contratos = numero_item_pecc($rowSR['num1'],$rowSR['num2'],$rowSR['num3']); echo $numero_genero_contratos;?></td>
        <td align="center"><?= $rowSR['nombre']?></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center" style="mso-number-format:'0';"><?=number_format($sel_valores[0],0,"","")?></td>
    	<td align="center" style="mso-number-format:'0';"><?=number_format($sel_valores[1],0,"","")?></td>
        <td align="center"><? echo traer_nombre_muestra($rowSR['estado'], "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");?></td>
      </tr>
      <?
      /*solcitiudes aprobadas*/
		   $sel_relacionada = query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado, $pi2.fecha_creacion, $pi2.id_item from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where  $pi2.t1_tipo_proceso_id in (5,7) and $pi2.estado >=20 and $pi2.estado <=32 and $pi2.estado <> 31 and (id_solicitud_relacionada in (".$sql_con[1]." ".$sol_relaciona.") or contrato_id=".$id_contrato_arr." or id_item_peec_aplica in (".$sql_con[1]."))   order by fecha_creacion asc");
				while ($rowSR = traer_fila_db($sel_relacionada)){
					$sel_valores = traer_fila_row(query_db("select SUM(valor_usd), SUM(valor_cop) from t2_presupuesto where t2_item_pecc_id = ".$rowSR[7]." and permiso_o_adjudica = 1 and al_valor_inicial_para_marco is null"));
					
					$sel_datos_modificacion = traer_fila_row(query_db("select t2.nombre, t1.numero_otrosi from t7_contratos_complemento t1, t1_tipo_otro_si t2 where t1.id_item_pecc = ".$rowSR[7]." and t1.tipo_otrosi = t2.id order by t1.id desc"));
					$sub_var_usd = $sub_var_usd + $sel_valores[0];
  					$sub_var_cop = $sub_var_cop + $sel_valores[1];
					?>
   <tr>
        <td align="center"><?=numero_item_pecc($rowSR['num1'],$rowSR['num2'],$rowSR['num3']);?></td>
        <td align="center"><?= $rowSR['nombre']?></td>
        <td align="center"><?=$sel_datos_modificacion[0]?></td>
        <td align="center"><?=$sel_datos_modificacion[1]?></td>
        <td align="center" style="mso-number-format:'0';"><?=number_format($sel_valores[0],0,"","")?></td>
    	<td align="center" style="mso-number-format:'0';"><?=number_format($sel_valores[1],0,"","")?></td>
        <td align="center"><? echo traer_nombre_muestra($rowSR['estado'], "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");?></td>
      </tr>
      <?
				}
  /*solcitiudes aprobadas FIN*/
	  ?>
      <?
  $sel_lista_modificaoin = query_db("select * from v_contrato_lista_modificaciones where id_contrato = ".$id_contrato_arr." and id_item_pecc is null order by id desc");
   while($sel_mod = traer_fila_db( $sel_lista_modificaoin)){
	   
	   if($sel_mod[16] > 0){
		   $sol_relaciona.=",".$sel_mod[16]; 
		   }
		   
		   $sub_var_usd = $sub_var_usd + $sel_mod[18];
  		$sub_var_cop = $sub_var_cop + $sel_mod[19];
?>

  <tr>
     <td align="center">-</td>
     <td align="center"><?=$sel_mod[2]?></td>
     <td align="center"><?=$sel_mod[3]?></td>
     <td align="center"><?=$sel_mod[4]?></td>
     <td align="center" style="mso-number-format:'0';"><?=number_format($sel_mod[18],0,"","")?></td>
     <td align="center" style="mso-number-format:'0';"><?=number_format($sel_mod[19],0,"","")?></td>
     <td align="center">Carga Manual - <?=$sel_mod[9]?></td>
   </tr>
  <?
   }
   
   
  ?>
   
  
     
      <tr>
        <td colspan="2">&nbsp;</td>
        <td colspan="2" align="right" class="fondo_5"><strong>Sub Total:</strong></td>
       <td align="center" class="fondo_5" style="mso-number-format:'0';"><?=number_format($sub_var_usd,0,"","")?></td>
    <td align="center" class="fondo_5" style="mso-number-format:'0';"><?=number_format($sub_var_cop,0,"","")?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="7" align="center" class="titulo_principal_3"><strong>Reclasificaciones</strong></td>
        </tr>
        <? 
  

		   $sel_relacionada = query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado, $pi2.fecha_creacion, $pi2.id_item from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where  $pi2.t1_tipo_proceso_id in (12) and (id_solicitud_relacionada in (".$sql_con[1]." ".$sol_relaciona.") or contrato_id=".$id_contrato_arr." or id_item_peec_aplica in (".$sql_con[1]."))  and $pi2.estado >=20 and $pi2.estado <=32 and $pi2.estado <> 31  order by fecha_creacion desc");
				while ($rowSR = traer_fila_db($sel_relacionada)){
					$sel_valores = traer_fila_row(query_db("select SUM(valor_usd), SUM(valor_cop) from t2_presupuesto where t2_item_pecc_id = ".$rowSR[7]." and permiso_o_adjudica = 1 and al_valor_inicial_para_marco is null"));
					?>
   <tr>
        <td align="center"><?=numero_item_pecc($rowSR['num1'],$rowSR['num2'],$rowSR['num3']);?></td>
        <td colspan="3"><?=$rowSR['objeto_solicitud']?></td>
         <td align="center" style="mso-number-format:'0';"><?=number_format($sel_valores[0],0,"","")?></td>
    	<td align="center" style="mso-number-format:'0';"><?=number_format($sel_valores[1],0,"","")?></td>
        <td align="center"><? echo traer_nombre_muestra($rowSR['estado'], "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");?></td>
      </tr>
   
  <?php }
				?>
                
     
   <tr>
        <td colspan="7" align="center" class="titulo_principal_3"><strong>Informativos</strong></td>
        </tr>
        <? 
  

		   $sel_relacionada = query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado, $pi2.fecha_creacion, $pi2.id_item from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where  $pi2.t1_tipo_proceso_id in (11) and (id_solicitud_relacionada in (".$sql_con[1]." ".$sol_relaciona.") or contrato_id=".$id_contrato_arr." or id_item_peec_aplica in (".$sql_con[1]."))  and $pi2.estado >=20 and $pi2.estado <=32 and $pi2.estado <> 31 order by fecha_creacion desc");
				while ($rowSR = traer_fila_db($sel_relacionada)){
					$sel_valores = traer_fila_row(query_db("select SUM(valor_usd), SUM(valor_cop) from t2_presupuesto where t2_item_pecc_id = ".$rowSR[7]." and permiso_o_adjudica = 1 and al_valor_inicial_para_marco is null"));
					?>
   <tr>
        <td align="center"><?=numero_item_pecc($rowSR['num1'],$rowSR['num2'],$rowSR['num3']);?></td>
        <td colspan="3"><?=$rowSR['objeto_solicitud']?></td>
         <td align="center" style="mso-number-format:'0';"><?=number_format($sel_valores[0],0,"","")?></td>
    	<td align="center" style="mso-number-format:'0';"><?=number_format($sel_valores[1],0,"","")?></td>
        <td align="center"><? echo traer_nombre_muestra($rowSR['estado'], "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");?></td>
      </tr>
   
  <?php }
				?>
    </table></td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
  </tr>
  <?
  if($sql_con[34] == 2 and $yano_aplica == "Ya no aplica esta tabla"){
  ?>
  <tr>
    <td>&nbsp;</td>
    <td colspan="7"  class="tabla_principal"><table width="100%" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="7" align="center" class="titulo_principal_2"><strong>Ordenes de Trabajo (Servicios) / Ordenes de Pedido Contrato Marco (Bienes)</strong></td>
      </tr>
      <tr>
        <td width="11%" align="center" class="fondo_3">N&uacute;mero Aprobaci&oacute;n</td>
        <td width="18%" align="center" class="fondo_3">Tipo proceso</td>
        <td width="19%" align="center" class="fondo_3">Contrato</td>
        <td width="11%" align="center" class="fondo_3">N&uacute;mero</td>
        <td width="11%" align="center" class="fondo_3">Valor USD</td>
        <td width="13%" align="center" class="fondo_3">Valor COP</td>
        <td width="17%" align="center" class="fondo_3">Estado</td>
      </tr>
      <?
	  $sub_var_usd = 0;
  $sub_var_cop = 0;

      /*solcitiudes aprobadas*/
	  		   $sel_relacionada = query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado, $pi2.fecha_creacion, $pi2.id_item from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where  $pi2.t1_tipo_proceso_id in (8) and ($pi2.estado <> 33) and id_item_peec_aplica in (".$sql_con[1].")   order by fecha_creacion desc");
				while ($rowSR = traer_fila_db($sel_relacionada)){
					$sel_valores = traer_fila_row(query_db("select SUM(valor_usd), SUM(valor_cop) from t2_presupuesto where t2_item_pecc_id = ".$rowSR[7]." and permiso_o_adjudica = 1 and al_valor_inicial_para_marco is null"));
					$num_impri="";
					$sel_contrato_ot = query_db("SELECT dbo.t7_contratos_contrato.consecutivo, dbo.t7_contratos_contrato.creacion_sistema, dbo.t7_contratos_contrato.apellido,  dbo.t7_contratos_contrato.id FROM            dbo.t2_item_pecc INNER JOIN                    dbo.t7_contratos_contrato INNER JOIN dbo.t2_presupuesto_aplica_contrato ON dbo.t7_contratos_contrato.id = dbo.t2_presupuesto_aplica_contrato.t7_contrato_id INNER JOIN dbo.t2_presupuesto ON dbo.t2_presupuesto_aplica_contrato.t2_presupuesto_id = dbo.t2_presupuesto.t2_presupuesto_id ON  dbo.t2_item_pecc.id_item = dbo.t2_presupuesto.t2_item_pecc_id WHERE        (dbo.t2_item_pecc.id_item = ".$rowSR[7].") group by dbo.t7_contratos_contrato.consecutivo, dbo.t7_contratos_contrato.creacion_sistema, dbo.t7_contratos_contrato.apellido,  dbo.t7_contratos_contrato.id");
					while($sel_co = traer_fila_db($sel_contrato_ot)){
					$numero_contrato1 = "C";			
$separa_fecha_crea = explode("-",$sel_co[1]);
$ano_contra = $separa_fecha_crea[0];					
$numero_contrato2 = substr($ano_contra,2,2);
$numero_contrato3 = $sel_co[0];
$numero_contrato4 = $sel_co[2];
$num_impri.=" ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_co[3]);
					}
$num_apoba="";
					$sel_solicitud_aprobacion = query_db("SELECT dbo.t2_presupuesto.t2_item_pecc_id, dbo.t2_presupuesto.id_item_ots_aplica, dbo.t2_item_pecc.num1, dbo.t2_item_pecc.num2, dbo.t2_item_pecc.num3 FROM dbo.t2_item_pecc INNER JOIN dbo.t2_presupuesto ON dbo.t2_item_pecc.id_item = dbo.t2_presupuesto.id_item_ots_aplica WHERE (dbo.t2_presupuesto.t2_item_pecc_id = ".$rowSR[7].") group by dbo.t2_presupuesto.t2_item_pecc_id, dbo.t2_presupuesto.id_item_ots_aplica, dbo.t2_item_pecc.num1, dbo.t2_item_pecc.num2, dbo.t2_item_pecc.num3");
					while($sel_apro = traer_fila_db($sel_solicitud_aprobacion)){
						$num_apoba.= " ".numero_item_pecc($sel_apro[2],$sel_apro[3],$sel_apro[4]);
					}
						
					$sub_var_usd = $sub_var_usd + $sel_valores[0];
  					$sub_var_cop = $sub_var_cop + $sel_valores[1];
					?>
      <tr>
        <td align="center"><? if($num_apoba == "" or $num_apoba == " ") echo $numero_genero_contratos; else echo $num_apoba;?></td>
        <td align="center"><? if($rowSR['num1'] =="B") echo "Orden de Pedido Contrato Marco"; else echo $rowSR['nombre'];?></td>
        <td align="center"><?=$num_impri?></td>
        <td align="center"><?=numero_item_pecc($rowSR['num1'],$rowSR['num2'],$rowSR['num3']);?></td>
        <td align="center" style="mso-number-format:'0';"><?=number_format($sel_valores[0],0,"","")?></td>
        <td align="center" style="mso-number-format:'0';"><?=number_format($sel_valores[1],0,"","")?></td>
        <td align="center"><? echo traer_nombre_muestra($rowSR['estado'], "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");?></td>
      </tr>
      <?
				}
  /*solcitiudes aprobadas FIN*/
	  ?>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td colspan="2" align="right" class="fondo_5"><strong>Sub Total:</strong></td>
        <td align="center" class="fondo_5" style="mso-number-format:'0';"><?=number_format($sub_var_usd,0,"","")?></td>
        <td align="center" class="fondo_5" style="mso-number-format:'0';"><?=number_format($sub_var_cop,0,"","")?></td>
        <td>&nbsp;</td>
      </tr>
      <? 
  

		   $sel_relacionada = query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado, $pi2.fecha_creacion, $pi2.id_item from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where  $pi2.t1_tipo_proceso_id in (12) and (id_solicitud_relacionada in (".$sql_con[1]." ".$sol_relaciona.") or contrato_id=".$id_contrato_arr." or id_item_peec_aplica in (".$sql_con[1]."))  and ($pi2.estado < 20)  order by fecha_creacion desc");
				while ($rowSR = traer_fila_db($sel_relacionada)){
					$sel_valores = traer_fila_row(query_db("select SUM(valor_usd), SUM(valor_cop) from t2_presupuesto where t2_item_pecc_id = ".$rowSR[7]." and permiso_o_adjudica = 1 and al_valor_inicial_para_marco is null"));
					?>
      <?php }
				?>
      <? 
  

		   $sel_relacionada = query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado, $pi2.fecha_creacion, $pi2.id_item from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where  $pi2.t1_tipo_proceso_id in (11) and (id_solicitud_relacionada in (".$sql_con[1]." ".$sol_relaciona.") or contrato_id=".$id_contrato_arr." or id_item_peec_aplica in (".$sql_con[1]."))  and ($pi2.estado < 20) order by fecha_creacion desc");
				while ($rowSR = traer_fila_db($sel_relacionada)){
					$sel_valores = traer_fila_row(query_db("select SUM(valor_usd), SUM(valor_cop) from t2_presupuesto where t2_item_pecc_id = ".$rowSR[7]." and permiso_o_adjudica = 1 and al_valor_inicial_para_marco is null"));
					?>
      <?php }
				?>
    </table></td>
  </tr>
  <?
  }
  ?>
  <tr>
  <td>&nbsp;</td>
    <td colspan="7">&nbsp;</td>
  </tr>
  <tr>
  <td>&nbsp;</td>
    <td colspan="7"  class="tabla_principal"><table width="100%" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="7" align="center" class="titulo_principal_2"><strong>Solicitudes en Aprobaci&oacute;n en el SGPA</strong></td>
      </tr>
      <tr>
        <td width="11%" align="center" class="fondo_3">N&uacute;mero Solicitud</td>
        <td width="18%" align="center" class="fondo_3">Tipo proceso</td>
        <td width="19%" align="center" class="fondo_3">Tipo Otros&iacute;</td>
        <td width="11%" align="center" class="fondo_3">N&uacute;mero</td>
        <td width="11%" align="center" class="fondo_3">Valor USD</td>
        <td width="13%" align="center" class="fondo_3">Valor COP</td>
        <td width="17%" align="center" class="fondo_3">Estado</td>
      </tr>
      
      <?
	  $sub_var_usd = 0;
  $sub_var_cop = 0;

      /*solcitiudes aprobadas*/
		   $sel_relacionada = query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado, $pi2.fecha_creacion, $pi2.id_item from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where  $pi2.t1_tipo_proceso_id in (5,7) and ($pi2.estado < 20) and (id_solicitud_relacionada in (".$sql_con[1]." ".$sol_relaciona.") or contrato_id=".$id_contrato_arr." or id_item_peec_aplica in (".$sql_con[1]."))   order by fecha_creacion desc");
				while ($rowSR = traer_fila_db($sel_relacionada)){
					$sel_valores = traer_fila_row(query_db("select SUM(valor_usd), SUM(valor_cop) from t2_presupuesto where t2_item_pecc_id = ".$rowSR[7]." and permiso_o_adjudica = 1 and al_valor_inicial_para_marco is null"));
					
					$sel_datos_modificacion = traer_fila_row(query_db("select t2.nombre, t1.numero_otrosi from t7_contratos_complemento t1, t1_tipo_otro_si t2 where t1.id_item_pecc = ".$rowSR[7]." and t1.tipo_otrosi = t2.id order by t1.id desc"));
					$sub_var_usd = $sub_var_usd + $sel_valores[0];
  					$sub_var_cop = $sub_var_cop + $sel_valores[1];
					?>
      <tr>
        <td align="center"><?=numero_item_pecc($rowSR['num1'],$rowSR['num2'],$rowSR['num3']);?></td>
        <td align="center"><?= $rowSR['nombre']?></td>
        <td align="center"><?=$sel_datos_modificacion[0]?></td>
        <td align="center"><?=$sel_datos_modificacion[1]?></td>
        <td align="center" style="mso-number-format:'0';"><?=number_format($sel_valores[0],0,"","")?></td>
        <td align="center" style="mso-number-format:'0';"><?=number_format($sel_valores[1],0,"","")?></td>
        <td align="center"><? echo traer_nombre_muestra($rowSR['estado'], "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");?></td>
      </tr>
      <?
				}
  /*solcitiudes aprobadas FIN*/
	  ?>
   
      <tr>
        <td colspan="2">&nbsp;</td>
        <td colspan="2" align="right" class="fondo_5"><strong>Sub Total:</strong></td>
        <td align="center" class="fondo_5" style="mso-number-format:'0';"><?=number_format($sub_var_usd,0,"","")?></td>
        <td align="center" class="fondo_5" style="mso-number-format:'0';"><?=number_format($sub_var_cop,0,"","")?></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="7" align="center" class="titulo_principal_3"><strong>Reclasificaciones</strong></td>
      </tr>
      <? 
  

		   $sel_relacionada = query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado, $pi2.fecha_creacion, $pi2.id_item from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where  $pi2.t1_tipo_proceso_id in (12) and (id_solicitud_relacionada in (".$sql_con[1]." ".$sol_relaciona.") or contrato_id=".$id_contrato_arr." or id_item_peec_aplica in (".$sql_con[1]."))  and ($pi2.estado < 20)  order by fecha_creacion desc");
				while ($rowSR = traer_fila_db($sel_relacionada)){
					$sel_valores = traer_fila_row(query_db("select SUM(valor_usd), SUM(valor_cop) from t2_presupuesto where t2_item_pecc_id = ".$rowSR[7]." and permiso_o_adjudica = 1 and al_valor_inicial_para_marco is null"));
					?>
      <tr>
        <td align="center"><?=numero_item_pecc($rowSR['num1'],$rowSR['num2'],$rowSR['num3']);?></td>
        <td colspan="3"><?=$rowSR['objeto_solicitud']?></td>
        <td align="center" style="mso-number-format:'0';"><?=number_format($sel_valores[0],0,"","")?></td>
        <td align="center" style="mso-number-format:'0';"><?=number_format($sel_valores[1],0,"","")?></td>
        <td align="center"><? echo traer_nombre_muestra($rowSR['estado'], "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");?></td>
      </tr>
      <?php }
				?>
      <tr>
        <td colspan="7" align="center" class="titulo_principal_3"><strong>Informativos</strong></td>
      </tr>
      <? 
  

		   $sel_relacionada = query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado, $pi2.fecha_creacion, $pi2.id_item from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where  $pi2.t1_tipo_proceso_id in (11) and (id_solicitud_relacionada in (".$sql_con[1]." ".$sol_relaciona.") or contrato_id=".$id_contrato_arr." or id_item_peec_aplica in (".$sql_con[1]."))  and ($pi2.estado < 20) order by fecha_creacion desc");
				while ($rowSR = traer_fila_db($sel_relacionada)){
					$sel_valores = traer_fila_row(query_db("select SUM(valor_usd), SUM(valor_cop) from t2_presupuesto where t2_item_pecc_id = ".$rowSR[7]." and permiso_o_adjudica = 1 and al_valor_inicial_para_marco is null"));
					?>
      <tr>
        <td align="center"><?=numero_item_pecc($rowSR['num1'],$rowSR['num2'],$rowSR['num3']);?></td>
        <td colspan="3"><?=$rowSR['objeto_solicitud']?></td>
        <td align="center" style="mso-number-format:'0';"><?=number_format($sel_valores[0],0,"","")?></td>
        <td align="center" style="mso-number-format:'0';"><?=number_format($sel_valores[1],0,"","")?></td>
        <td align="center"><? echo traer_nombre_muestra($rowSR['estado'], "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");?></td>
      </tr>
      <?php }
				?>
    </table></td>
  </tr>
  <tr>
    <td width="4%">&nbsp;</td>
    <td width="21%">&nbsp;</td>
    <td width="11%">&nbsp;</td>
    <td width="11%">&nbsp;</td>
    <td width="15%">&nbsp;</td>
    <td width="12%">&nbsp;</td>
    <td width="26%">&nbsp;</td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6">
    <? if($_SESSION["id_us_session"] == 32){
		
		
				   $rowSR = traer_fila_db(query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado, $pi2.fecha_creacion, $pi2.id_item from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where $pi2.id_item =".$sql_con[1].""));
				

					

		?>
    <table width="100%" border="1" cellpadding="0" cellspacing="0">
      <tr>
        <td colspan="8" align="center" class="titulo_principal_2"><strong>Valores de las Solicitudes aprobadas en el SGPA</strong></td>
      </tr>
      <tr>
        <td width="11%" align="center" class="fondo_3">N&uacute;mero Solicitud</td>
        <td width="18%" align="center" class="fondo_3">Tipo proceso</td>
        <td width="19%" align="center" class="fondo_3">Tipo Otros&iacute;</td>
        <td width="11%" align="center" class="fondo_3">N&uacute;mero</td>
        <td width="5%" align="center" class="fondo_3">&Aacute;rea / Proyecto</td>
        <td width="6%" align="center" class="fondo_3">Valor USD</td>
        <td width="13%" align="center" class="fondo_3">Valor COP</td>
        <td width="17%" align="center" class="fondo_3">Estado</td>
      </tr>
      <tr>
        <td align="center"><? $numero_genero_contratos = numero_item_pecc($rowSR['num1'],$rowSR['num2'],$rowSR['num3']); echo $numero_genero_contratos;?></td>
        <td align="center"><?= $rowSR['nombre']?></td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td colspan="3" align="center" style="mso-number-format:'0';">
        <table width="100%" border="1">
        
        <?
		

        $sel_valores = query_db("select SUM(t1.valor_usd), SUM(t1.valor_cop), t3.nombre from t2_presupuesto as t1, t2_presupuesto_aplica_contrato as t2, t1_campo as t3 where t1.t2_item_pecc_id = ".$rowSR[7]." and t1.t1_campo_id = t3.t1_campo_id and t1.t2_presupuesto_id = t2.t2_presupuesto_id and t2.t7_contrato_id = ".$id_contrato_arr."  and t1.permiso_o_adjudica = 2 and t1.al_valor_inicial_para_marco is null group by t3.nombre");
					
					while($sel_v = traer_fila_db($sel_valores)){
					  $sub_var_usd = $sub_var_usd + $sel_v[0];
  					$sub_var_cop = $sub_var_cop + $sel_v[1];
		?>
          <tr>
            <td><?=$sel_v[2]?></td>
            <td><?=number_format($sel_v[0],0,"","")?></td>
            <td><?=number_format($sel_v[1],0,"","")?></td>
          </tr>
          <?
					}
		  ?>
        </table>
        
        </td>
        <td align="center"><? echo traer_nombre_muestra($rowSR['estado'], "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");?></td>
      </tr>
      <?
      /*solcitiudes aprobadas*/
		   $sel_relacionada = query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado, $pi2.fecha_creacion, $pi2.id_item from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where  $pi2.t1_tipo_proceso_id in (5,7) and $pi2.estado >=20 and $pi2.estado <=32 and $pi2.estado <> 31 and (id_solicitud_relacionada in (".$sql_con[1]." ".$sol_relaciona.") or contrato_id=".$id_contrato_arr." or id_item_peec_aplica in (".$sql_con[1]."))   order by fecha_creacion asc");
				while ($rowSR = traer_fila_db($sel_relacionada)){
					$sel_valores = traer_fila_row(query_db("select SUM(valor_usd), SUM(valor_cop) from t2_presupuesto where t2_item_pecc_id = ".$rowSR[7]." and permiso_o_adjudica = 1 and al_valor_inicial_para_marco is null"));
					
					$sel_datos_modificacion = traer_fila_row(query_db("select t2.nombre, t1.numero_otrosi from t7_contratos_complemento t1, t1_tipo_otro_si t2 where t1.id_item_pecc = ".$rowSR[7]." and t1.tipo_otrosi = t2.id order by t1.id desc"));
					$sub_var_usd = $sub_var_usd + $sel_valores[0];
  					$sub_var_cop = $sub_var_cop + $sel_valores[1];
					?>
      <tr>
        <td align="center"><?=numero_item_pecc($rowSR['num1'],$rowSR['num2'],$rowSR['num3']);?></td>
        <td align="center"><?= $rowSR['nombre']?></td>
        <td align="center"><?=$sel_datos_modificacion[0]?></td>
        <td align="center"><?=$sel_datos_modificacion[1]?></td>
        <td colspan="3" align="center" style="mso-number-format:'0';"><table width="100%" border="1">
          <?
		

        $sel_valores = query_db("select SUM(t1.valor_usd), SUM(t1.valor_cop), t3.nombre from t2_presupuesto as t1, t2_presupuesto_aplica_contrato as t2, t1_campo as t3 where t2_item_pecc_id = ".$rowSR[7]." and al_valor_inicial_para_marco is null and t1.t1_campo_id = t3.t1_campo_id and t1.t2_presupuesto_id = t2.t2_presupuesto_id  and t1.al_valor_inicial_para_marco is null group by t3.nombre");
					
					while($sel_v = traer_fila_db($sel_valores)){
					  $sub_var_usd = $sub_var_usd + $sel_v[0];
  					$sub_var_cop = $sub_var_cop + $sel_v[1];
		?>
          <tr>
            <td><?=$sel_v[2]?></td>
            <td><?=number_format($sel_v[0],0,"","")?></td>
            <td><?=number_format($sel_v[1],0,"","")?></td>
          </tr>
          <?
					}
		  ?>
        </table></td>
        <td align="center"><? echo traer_nombre_muestra($rowSR['estado'], "t2_nivel_servicio_actividades","nombre","t2_nivel_servicio_actividad_id");?></td>
      </tr>
      <?
				}
  /*solcitiudes aprobadas FIN*/
	  ?>
      <?
  $sel_lista_modificaoin = query_db("select * from v_contrato_lista_modificaciones where id_contrato = ".$id_contrato_arr." and id_item_pecc is null order by id desc");
   while($sel_mod = traer_fila_db( $sel_lista_modificaoin)){
	   
	   if($sel_mod[16] > 0){
		   $sol_relaciona.=",".$sel_mod[16]; 
		   }
		   
		   $sub_var_usd = $sub_var_usd + $sel_mod[18];
  		$sub_var_cop = $sub_var_cop + $sel_mod[19];
?>
      <tr>
        <td align="center">-</td>
        <td align="center"><?=$sel_mod[2]?></td>
        <td align="center"><?=$sel_mod[3]?></td>
        <td align="center"><?=$sel_mod[4]?></td>
        <td align="center" style="mso-number-format:'0';">&nbsp;</td>
        <td align="center" style="mso-number-format:'0';"><?=number_format($sel_mod[18],0,"","")?></td>
        <td align="center" style="mso-number-format:'0';"><?=number_format($sel_mod[19],0,"","")?></td>
        <td align="center">Carga Manual -
          <?=$sel_mod[9]?></td>
      </tr>
      <?
   }
   
   
  ?>
      <tr>
        <td colspan="2">&nbsp;</td>
        <td colspan="3" align="right" class="fondo_5"><strong>Sub Total:</strong></td>
        <td align="center" class="fondo_5" style="mso-number-format:'0';"><span class="fondo_5" style="mso-number-format:'0';">
          <?=number_format($sub_var_usd,0,"","")?>
        </span></td>
        <td align="center" class="fondo_5" style="mso-number-format:'0';"><?=number_format($sub_var_cop,0,"","")?></td>
        <td>&nbsp;</td>
      </tr>
      <? 
  

		   $sel_relacionada = query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado, $pi2.fecha_creacion, $pi2.id_item from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where  $pi2.t1_tipo_proceso_id in (12) and (id_solicitud_relacionada in (".$sql_con[1]." ".$sol_relaciona.") or contrato_id=".$id_contrato_arr." or id_item_peec_aplica in (".$sql_con[1]."))  and $pi2.estado >=20 and $pi2.estado <=32 and $pi2.estado <> 31  order by fecha_creacion desc");
				while ($rowSR = traer_fila_db($sel_relacionada)){
					$sel_valores = traer_fila_row(query_db("select SUM(valor_usd), SUM(valor_cop) from t2_presupuesto where t2_item_pecc_id = ".$rowSR[7]." and permiso_o_adjudica = 1 and al_valor_inicial_para_marco is null"));
					?>
      <?php }
				?>
      <? 
  

		   $sel_relacionada = query_db("select num1,num2,num3,objeto_solicitud,nombre, $pi2.estado, $pi2.fecha_creacion, $pi2.id_item from $pi2 inner join $g13 on $g13.t1_tipo_proceso_id = $pi2.t1_tipo_proceso_id where  $pi2.t1_tipo_proceso_id in (11) and (id_solicitud_relacionada in (".$sql_con[1]." ".$sol_relaciona.") or contrato_id=".$id_contrato_arr." or id_item_peec_aplica in (".$sql_con[1]."))  and $pi2.estado >=20 and $pi2.estado <=32 and $pi2.estado <> 31 order by fecha_creacion desc");
				while ($rowSR = traer_fila_db($sel_relacionada)){
					$sel_valores = traer_fila_row(query_db("select SUM(valor_usd), SUM(valor_cop) from t2_presupuesto where t2_item_pecc_id = ".$rowSR[7]." and permiso_o_adjudica = 1 and al_valor_inicial_para_marco is null"));
					?>
      <?php }
				?>
    </table>
    <?
    }
	?>
    
    </td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td colspan="6">&nbsp;</td>
  </tr>
</table>
<br>
<br>
<br>
<br>
<br>

</body>
</html>
<?
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Reporte Movimientos de Contratos ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_cont_mar[3]).".xls"); 

?>