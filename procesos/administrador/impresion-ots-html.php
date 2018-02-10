<? 
global $pi2, $pi1, $g1, $g10,$pi8, $g15;


$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));




	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$id_pecc = $sel_item[1];
	$sel_pecc = traer_fila_row(query_db("select $g10.valor from $pi1, $g1, $g10 where $pi1.id_pecc = ".$sel_item[1]." and $g1.us_id = $pi1.id_us_encargado and $g10.id_pecc = $pi1.id_pecc and $g10.estado=1"));
	
	$sel_presupuestos = traer_fila_row(query_db("select t2_presupuesto_id FROM  t2_presupuesto WHERE (t2_item_pecc_id = ".$id_item_pecc.") and permiso_o_adjudica = 1"));
	
	$id_presupuesto = $sel_presupuestos[0];
	
	$sel_contrato_id = traer_fila_row(query_db("select t7_contrato_id from t2_presupuesto_aplica_contrato where t2_presupuesto_id = $id_presupuesto"));	
	
	$sel_datos_contrato = traer_fila_row(query_db("select consecutivo,creacion_sistema, apellido, contratista from t7_contratos_contrato where id = ".$sel_contrato_id[0]));
	
	$sel_datos_ot = traer_fila_row(query_db("select numero_otrosi from t7_contratos_complemento where id_contrato = ".$sel_contrato_id[0]." and id_item_pecc = ".$id_item_pecc));
	
	$sel_nombre_jefe_area = traer_fila_row(query_db("select nombre_administrador from v_seg1 where id_premiso = 9 and id_area = '".$sel_item[5]."'"));
	
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_datos_contrato[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_datos_contrato[0];
					$numero_contrato4 = $sel_datos_contrato[2];
	$numero_contra = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4);
	
	$nombre_archivo = "SGPA - $numero_contra OT No. ".numero_item_pecc($sel_item[16],$sel_item[17],$sel_item[18]);





/**/
$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
	$cont = 0;
  $clase="";
  
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[4];
				$valor_total_cop = $valor_total_cop + $sel_presu[5];
				
				if($sel_presu[1]==2013){
				$trm_aplica = 1780;
				}
				if($sel_presu[1]==2014){
				$trm_aplica = 1900;
				}
				$v_eq_por_uno =$v_eq_por_uno +  ($sel_presu[5] / $trm_aplica) +$sel_presu[4];
				}
				
				
				$valor_total_usd_imprime = $valor_total_usd;
				$valor_total_cop_imprime = $valor_total_cop;
				
				
			$total_equivale_usd_1 = ($valor_total_cop / $sel_pecc[0]) +$valor_total_usd ;
			
			$total_equivale_usd_1 = $v_eq_por_uno;
			
			
$valor_total_usd =0;
$valor_total_cop=0;
/**/

$sel_item_obs = traer_fila_db(query_db("select CAST(destino_ots AS text), CAST(duracion_ots AS text), CAST(objeto_solicitud AS text) from $pi2 where id_item=".$id_item_pecc));	
	
	
	$sele_profecional_fecha = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.fecha from t2_agl_secuencia_solicitud, t2_agl_secuencia_solicitud_aprobacion where  t2_agl_secuencia_solicitud.id_item_pecc = ".$id_item_pecc." and t2_agl_secuencia_solicitud.id_rol = 8 and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud"));
	
	$sele_solicitante_fecha = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.fecha, t2_agl_secuencia_solicitud_aprobacion.id_us from t2_agl_secuencia_solicitud, t2_agl_secuencia_solicitud_aprobacion where  t2_agl_secuencia_solicitud.id_item_pecc = ".$id_item_pecc." and t2_agl_secuencia_solicitud.id_rol = 15 and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud"));

	$rol_gerente_ot_fecha = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.fecha, t2_agl_secuencia_solicitud_aprobacion.id_us from t2_agl_secuencia_solicitud, t2_agl_secuencia_solicitud_aprobacion where  t2_agl_secuencia_solicitud.id_item_pecc = ".$id_item_pecc." and t2_agl_secuencia_solicitud.id_rol = 34 and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud"));
	
	$sele_jefe_area_fecha = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.fecha, t2_agl_secuencia_solicitud_aprobacion.id_us from t2_agl_secuencia_solicitud, t2_agl_secuencia_solicitud_aprobacion where  t2_agl_secuencia_solicitud.id_item_pecc = ".$id_item_pecc." and t2_agl_secuencia_solicitud.id_rol = 9 and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud"));
	
	if($sele_jefe_area_fecha[0]==""){// si es SUPERINTENDENTE
	$sele_jefe_area_fecha = traer_fila_row(query_db("select t2_agl_secuencia_solicitud_aprobacion.fecha, t2_agl_secuencia_solicitud_aprobacion.id_us from t2_agl_secuencia_solicitud, t2_agl_secuencia_solicitud_aprobacion where  t2_agl_secuencia_solicitud.id_item_pecc = ".$id_item_pecc." and t2_agl_secuencia_solicitud.id_rol = 35 and t2_agl_secuencia_solicitud.estado = 1 and t2_agl_secuencia_solicitud. id_secuencia_solicitud = t2_agl_secuencia_solicitud_aprobacion.id_secuencia_solicitud"));
	$nombre_super_o_jefe = "Super Intendente de";
	}else{
		$nombre_super_o_jefe = "Jefe de";
		}
	

/*
	$sel_si_es_administrador_de_ots = traer_fila_row(query_db("select * from v_seg1 where us_id =".$sel_item[3]." and id_premiso = 33"));//verifica si el usuario es administrador de OTS
		if($sel_si_es_administrador_de_ots[0] > 0){
			
			$id_gerente = $rol_gerente_ot_fecha[1];
			$fecha_gerente = "Fecha de Firma en SGPA: <br />".$rol_gerente_ot_fecha[0];
			
		}else{
			$id_gerente = $sele_solicitante_fecha[1];
			$fecha_gerente = "Fecha de Firma en SGPA: <br />".$sele_solicitante_fecha[0];
			}
			
	*/		
			
			
			$id_gerente = $rol_gerente_ot_fecha[1];
			$fecha_gerente = "Fecha de Firma en SGPA: <br />".$rol_gerente_ot_fecha[0];
			
			if($id_gerente == 0 or $id_gerente==""){
				$id_gerente = $sele_solicitante_fecha[1];
				$fecha_gerente = "Fecha de Firma en SGPA: <br />".$sele_solicitante_fecha[0];
				}
			

?>

<style>
body {
	color:#fff;
	font-family: "Trebuchet MS", "Lucida Sans Unicode", "Lucida Grande", "Lucida Sans", Arial, sans-serif, Tahoma,Arial, Helvetica, sans-serif;
	font-size:8px;
	margin-right:50px;

}

.titulo_ppl{
	background:#CCCCCC; 
	color:#FFFFFF;
	font-size:16px
	}
	.titulo_lista{ background:#005395; color:#FFFFFF;
	font-size:16px;
	text-align:center}
	
	.sub_titulo{
		font-size:12px;
		color:#000;

		}
	.datos1{
		font-size:12px;

		}
	.datos{
		font-size:18px;

		}


.tablas{
	border: #033 solid 1px;

	
	}
.letra_griz_tt {	
	color:#999;
	font-size:10px;
}

.borde_tabla{
	BORDER-BOTTOM: #OOO 1px solid; 
	BORDER-TOP: #OOO 1px solid; 
	BORDER-RIGHT: #OOO 1px solid; 	
	BORDER-LEFT: #OOO 1px solid; 
	border-spacing:2px;

	}

</style>

<table style="width: 100%; border: solid 0px #000; alignment-adjust:central">
<tr>
  <td   rowspan="4" style=" width: 30%"><img src="logo_imprime.jpg" alt="" width="179" height="63" /></td>
  <td colspan="2"  class="titulo_ppl" style="width: 70%; text-align:center"><strong>Formato de Orden de Trabajo</strong></td>
  </tr>
<tr>
  <td style="width: 55%;" align="right" class="letra_griz_tt">C&oacute;digo  Documento Referencia:</td>
  <td style="width: 16%;" align="left" class="letra_griz_tt">NO 15-01 F 0</td>
</tr>
<tr>
  <td align="right" class="letra_griz_tt">Fecha de  Aprobaci&oacute;n:</td>
  <td align="left" class="letra_griz_tt">Mayo 31 de 2012</td>
</tr>
<tr>
  <td align="right" class="letra_griz_tt">Ultima Versi&oacute;n:</td>
  <td align="left" class="letra_griz_tt">4</td>
</tr>
<tr>
  <td colspan="3" class="datos" style=" width: 100%; text-align:center"><strong>
    Orden de Trabajo No. <?=numero_item_pecc($sel_item[16],$sel_item[17],$sel_item[18])?>
  </strong></td>
</tr>
<tr>
  <td colspan="3" style=" width: 100%;">

  <table style=" border: solid 1px #ccc; width: 100%" >
    <tr>
      <td style=" width: 33%; text-align:right; border: solid 0px #ccc;" ><strong class="sub_titulo">Equipo:</strong></td>
      <td style=" width: 29%; text-align:left; border: solid 0px #ccc;"><span class="datos1"><? echo saca_nombre_lista("t1_area",$sel_item[5],'nombre_html','t1_area_id');?></span></td>
      <td style=" width: 16%; text-align:right; border: solid 0px #ccc;" ><strong class="sub_titulo">Fecha:</strong></td>
      <td style=" width: 22%; text-align:left; border: solid 0px #ccc;"  ><span class="datos1"><?=$sele_profecional_fecha[0]?></span></td>
      </tr>
    <tr>
      <td align="right"  ><strong  class="sub_titulo">Trabajo a realizarse seg&uacute;n contrato No.:</strong></td>
      <td align="left" ><strong class="datos"><?=$numero_contra ?> </strong></td>
      <td align="right"   ><strong  class="sub_titulo">Cargo:</strong></td>
      <td align="left"   ><span class="datos1">AFES o CECOS para los <br /> que se preste el servicio</span></td>
      </tr>
   
    <tr>
       <td align="right"  ><strong class="sub_titulo">Valor acordado  USD$:</strong></td>
      <td align="left" ><span class="datos1"><?=number_format($valor_total_usd_imprime ,0)?></span></td>
      <td align="right"   ><strong class="sub_titulo">Fecha para cuando<br /> se Requiere:</strong></td>
      <td align="left"   ><span class="datos1"><?=$sel_item[7]?></span></td>
      </tr>
    <tr>
      <td align="right"  ><strong class="sub_titulo">Valor acordado  COP$:</strong></td>
      <td align="left" ><span class="datos1"><?=number_format($valor_total_cop_imprime ,0)?></span></td>
      <td align="right"   >&nbsp;</td>
      <td align="left"   >&nbsp;</td>
      </tr>
    <tr>
      <td align="right"  ><strong class="sub_titulo">Valor acordado equivalente USD$:</strong></td>
      <td align="left" ><span class="datos1"><?=number_format($total_equivale_usd_1 ,0)?></span></td>
      <td align="right"   >&nbsp;</td>
      <td align="left"   >&nbsp;</td>
      </tr>
    <tr>
     <td align="right"  ><strong class="sub_titulo">Duraci&oacute;n Orden de Trabajo:</strong></td>
      <td colspan="3" align="left" ><span class="datos1"><?=$sel_item_obs[1]?></span></td>
      </tr>
    <tr>
      <td align="right"  ><strong  class="sub_titulo">Destino:</strong></td>
      <td colspan="3" align="left" ><span class="datos1"><?=$sel_item_obs[0]?></span></td>
      </tr>
  </table>
    
  <table style="width: 100%" >
    <tr>
      <td style="text-indent: 10mm; border: solid 1px #ccc; width: 100%"><span class="datos1"> <strong>Asignado a:</strong> <? echo saca_nombre_lista("t1_proveedor",$sel_datos_contrato[3],'razon_social','t1_proveedor_id'); ?></span> </td>
    </tr>
  </table>
  <table style="width: 100%" >
    <tr>
      <td style="text-indent: 10mm; border: solid 1px #ccc; width: 100%">
        <?=$sel_item_obs[2]?>&nbsp;
        </td>
      
      </tr>
  </table>
    
  <br>
  <table style="width: 100%; border: solid 1px #CCC; alignment-adjust:central" >
    <tr  class="titulo_lista">
      <td  style="width: 13%">A&ntilde;o</td>
      <td  style="width: 41%">Area</td>
      <td style="width: 22%">Valor USD$</td>
      <td  style="width: 24%">Valor COP$</td>
      </tr>
    <?
   
				
  $sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
	$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[4];
				$valor_total_cop = $valor_total_cop + $sel_presu[5];
				
				if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
  ?>
    <tr class="datos1">
      <td style="width: 13%"><?=$sel_presu[1]?></td>
      <td style="width: 41%"><?=$sel_presu[2]?></td>
      <td style="width: 22%"><?=number_format($sel_presu[4],0)?></td>
      <td style="width: 24%"><?=number_format($sel_presu[5],0)?></td>
      </tr>
    <?
			}
			$total_equivale_usd = ($valor_total_cop / $sel_pecc[0]) +$valor_total_usd ;
  ?>
    <tr>
      <td rowspan="2" align="right">&nbsp;</td>
      <td align="right"  class="titulo_lista">Totales:</td>
      <td class="datos1"><?=number_format($valor_total_usd)?></td>
      <td class="datos1"><?=number_format($valor_total_cop)?></td>
      </tr>
    <tr>
      <td align="right"  class="titulo_lista">Total Equivalentes USD$:</td>
      <td colspan="2" class="datos"><?=number_format($total_equivale_usd)?>
        
        </td>
      </tr>
  </table>
  <?
$sele_cunt_ob = traer_fila_row(query_db("select count(*) from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'ob_ots'"));


$sel_item_ampli = query_db("select id_item_ots_aplica from  t2_presupuesto where  t2_item_pecc_id = ".$id_item_pecc);

while($sel_am = traer_fila_row($sel_item_ampli)){
	
	$sel_item_num_nivel = traer_fila_row(query_db("select id_item, num1,num2,num3 from t2_item_pecc where id_item = ".$sel_am[0]));

if($sel_item_num_nivel[0]<>""){
	$ampl.= "Ampliacion Relacionada: ".numero_item_pecc($sel_item_num_nivel[1],$sel_item_num_nivel[2],$sel_item_num_nivel[3].", Nivel de Aprovacion ".nivel_aprobacion_solicitud($sel_item_num_nivel[0],"adjudicacion")."<br />");;
}
	
	}

?>
  <br />
    
  <table style="width: 100%; border: solid 1px #CCC; alignment-adjust:central">
    <tr>
      <td style="width:100%; text-align:center" class="titulo_lista">Observaciones</td>
      </tr>
      
      <tr class="<?=$clase?>">
      <td align="left" ><?=$ampl?> </td>
    </tr>
    
    <?
$cont = 0;
  $clase="";
  $sele_anexos = query_db("select * from $pi9 where t2_item_pecc_id = '".$id_item_pecc."' and estado = 1 and tipo = 'ob_ots'");
  while($sl_anexos = traer_fila_db($sele_anexos)){
	  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
  ?>
    <tr class="<?=$clase?>">
      <td align="left" ><?=$sl_anexos[4]?></td>
      </tr>
    
    <?
}
  ?>
  </table>
  <?

?>
  <br>
  <?
$sel_datos_comite = traer_fila_row(query_db("select t1.id_comite, num1, num2, num3, fecha from t3_comite_relacion_item as t1, t3_comite as t2 where t1.id_item = $id_item_pecc and t1.estado = 1 and t1.id_comite = t2.id_comite"));

if($sel_datos_comite[0]>0){
	
?>
  <table style="width: 100%; border: solid 1px #CCC; alignment-adjust:central">
    <tr>
      <td  style="width:100%" align="left" class="datos">Aprobado  Comit&eacute; de Contratos <?=numero_item_pecc($sel_datos_comite[1],$sel_datos_comite[2],$sel_datos_comite[3])?> del <?=$sel_datos_comite[4]?>. </td>
      </tr>
  </table>
  <?
}else{
	
	
	}
?>
  <table height="226" style="width: 100%; border: solid 1px #CCC; alignment-adjust:central">
    <tr class="titulo_lista">
      <td colspan="4" align="left"  style="width: 100%">APROBACIONES:</td>
      </tr>
    <tr class="titulo_lista">
      <td  style="width:25%;">Profesional de <br />
        Contrataci&oacute;n</td>
      <td  style="width:25%;" align="center">Gerente
        de la <br />
        Orden de Trabajo</td>
      <td style="width:25%;" align="center"><?=$nombre_super_o_jefe?><br /><? echo saca_nombre_lista($g12,$sel_item[5],'nombre_html','t1_area_id'); ?></td>
      <td style="width:25%;" align="center">Contratista / <br>
        Representante Legal</td>
      </tr>
    <tr>
      <td height="44" class="datos1">Fecha de Firma en SGPA: <br /><?=$sele_profecional_fecha[0]?></td>
      <td height="44" class="datos1"><?=$fecha_gerente?></td>
      <td height="44" class="datos1">Fecha de Firma en SGPA: <br /><?=$sele_jefe_area_fecha[0]?></td>
      <td>&nbsp;</td>
      </tr>
    <tr class="datos">
      <td height="34" class="datos1"><strong class="sub_titulo">Nombre:</strong><br>      &nbsp;<? echo saca_nombre_lista($g1,$sel_item[23],'nombre_administrador','us_id');?></td>
      <td class="datos1"><strong class="sub_titulo">Nombre:<br>
        &nbsp;</strong> <? 
		
		
		
		echo saca_nombre_lista($g1,$id_gerente,'nombre_administrador','us_id'); 
		
		
		?></td>
      <td class="datos1"><strong class="sub_titulo">Nombre:</strong><br>     &nbsp; <? echo saca_nombre_lista($g1,$sele_jefe_area_fecha[1],'nombre_administrador','us_id'); ?></td>
      <td align="left" class="datos1"><strong class="sub_titulo">Nombre :<br />
        <br />
        Cedula:</strong></td>
      </tr>
  </table>
</td></tr>
</table>

<style type="text/css">
<!--

-->
</style>