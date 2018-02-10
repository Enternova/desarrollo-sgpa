<? header("Content-type: application/octet-stream");header("Content-Disposition: attachment; filename=Reporte detalle contrato marco - Total de Aprobaciones.xls"); header("Pragma: no-cache"); header("Expires: 0");	 
include("../../librerias/lib/@session.php"); 

if($eq_moneda == 1){
	$moneda = "USD";
	}
if($eq_moneda == 2){
	$moneda = "COP";
	}
	
$sel_contratos_que_viene = traer_fila_row(query_db("select consecutivo,creacion_sistema,apellido from $co1 where id = ".$_GET["id_contrato"]." "));

$contratos_que_viene=numero_item_pecc_contrato_antes_formato("C",$sel_contratos_que_viene[1],$sel_contratos_que_viene[0],$sel_contratos_que_viene[2], $_GET["id_contrato"]);

		
	
	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
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
.tabla_lista_resultados{  
	margin:1px;
  BORDER-BOTTOM: #cccccc 3px double; 
  BORDER-RIGHT: #cccccc 3px  double; 
  BORDER-TOP: #cccccc 1px solid;  	
  BORDER-LEFT: #cccccc 1px solid; 
  border-spacing:2px;
  overflow:scroll;
  
 }
 
 .estilo_reporte_fondo_verde{
	color:#FFF;
	background-color:#093;
	font-weight: bold;
	
	BORDER-BOTTOM: #F00 0px solid; 
	BORDER-RIGHT: #F00 0px solid; 
	BORDER-TOP: #F00 0px solid;  
	BORDER-LEFT: #F00 0px solid; 
	
	
	}
.fondo_3{ background:#005395; color:#FFFFFF;}

.tabla_paginador{ font-size:14px; color:#666666} 

.filas_resultados_reporte_saldos1{
	 BORDER-BOTTOM: #cccccc 1px double; BORDER-RIGHT: #cccccc 0px  double; BORDER-TOP: #cccccc 1px solid;  	BORDER-LEFT: #cccccc 0px solid; 
	}
.filas_resultados_reporte_saldos2{
	 BORDER-BOTTOM: #cccccc 1px double; BORDER-RIGHT: #cccccc 0px  double; BORDER-TOP: #cccccc 0px solid;  	BORDER-LEFT: #cccccc 0px solid; 
	}
	

.filas_resultados_blanco{ background:#FFFFFF} 
.filas_resultados{ background:#DBFBDC} 

.estilo_reporte_fondo_verde{
	color:#FFF;
	background-color:#093;
	font-weight: bold;
	
	BORDER-BOTTOM: #F00 0px solid; 
	BORDER-RIGHT: #F00 0px solid; 
	BORDER-TOP: #F00 0px solid;  
	BORDER-LEFT: #F00 0px solid; 
	
	
	}
</style>

<body>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
<tr><td>
  <table width="100%" border="0" align="center" bgcolor="#FFFFFF" class="tabla_lista_resultados">
    <tr>
      <td><strong>DETALLE DE LAS APROBACIONES Y RECLASIFICACIONES</strong></td>
    </tr>
  </table>
  </td></tr>
  </table>
  
  
  
  <table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
<tr>
  <td width="100%" align="center">
    
    
    <table width="100%" border="1" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
      
      <?
  
  if($_GET["id_solicitud"]<>0){
	  $comple_sql = " and id_item=".$_GET["id_solicitud"];
	  }
  
  $cuantos_solicitudes="select num_item,tipo,id_item from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion', 'reclasificacion') $comple_sql group by num_item,tipo,id_item order by id_item asc";
  

  

  $sel_cuantos=query_db($cuantos_solicitudes);
  $cuantos =0;
  while($sel_temp = traer_fila_db($sel_cuantos)){
	   $cuantos =$cuantos+1;
  }
  
  $sel_temporal_sql="select num_item,tipo,t2_reporte_marco_temporal.id_item from t2_reporte_marco_temporal, t2_item_pecc as t2 where t2.id_item =t2_reporte_marco_temporal.id_item and t2_reporte_marco_temporal.id_us = '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion', 'reclasificacion')  and t2.estado >= 20 and t2.estado <= 32 and t2.estado <> 31 group by num_item,tipo,t2_reporte_marco_temporal.id_item order by id_item asc";


  ?>
      <tr class="fondo_3">
        <td colspan="2" align="center">Numero de la Solicitud</td>
        <td width="11%" align="center">Contrato</td>
        <td width="24%" align="center">Contratista</td>
        <td width="3%" align="center">A&ntilde;o</td>
        <td width="16%" align="center">Area / Proyecto</td>
        <td width="8%" align="center">Origen USD</td>
        <td width="8%" align="center">Origen COP</td>
        <td width="8%" align="center">Equivalente <?=$moneda?>$</td>
        <td width="4%" align="center">TRM</td>
        
        </tr>
      
      
      <?

  $sel_temporal=query_db($sel_temporal_sql);
  $consecutivo=0;
  
  $valor_cop_total_liz =0;
  $valor_usd_total_liz =0;
  $valor_equ_total_liz =0;
  
  while($sel_temp = traer_fila_db($sel_temporal)){
	  
	  $sel_item_masivo= traer_fila_row(query_db("select de_historico, t1_tipo_proceso_id from t2_item_pecc where id_item = ".$sel_temp[2]));
	  
	  
	  $consecutivo=$consecutivo+1;
	$titulo="";
  $titulo2="";
	
	  if($sel_temp[1]=="inicial"){	  
	  $titulo = "SOLICITUD INICIAL - ".$sel_temp[0];
	  $titulo2= "<strong>SOLICITUD INICIAL - ".$sel_temp[0]."</strong>";
	

	  }
	  if($sel_temp[1]=="ampliacion"){	  
	  $titulo = "SOLICITUD DE AMPLIACION - ".$sel_temp[0];
	  $titulo2= "<strong>SOLICITUD DE AMPLIACION - ".$sel_temp[0]."</strong>";
	  }
	  
	 $cuanta_cuantos_registros=traer_fila_row(query_db("select count(*) from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]." and tipo in ('inicial', 'ampliacion', 'reclasificacion')"));
	 
	 
	 $convina_rowspan_columna_1=$cuanta_cuantos_registros[0];////la columna donde estan los numeros de la solucitud
  

      $selecciona_valores = query_db("select  id_reporte, id_us, tipo, id_item, CAST (contratos as text), ano, campo, usd, cop, id_campo, t2_presupuesto_id, num_item, CAST (contratista as text), id_item_ots_aplica from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]." and tipo in ('inicial', 'ampliacion', 'reclasificacion')");
	  $es_el_primero = 0;
	  
	  $valor_usd_t=0;
	$valor_cop_t=0;
	$valor_eqi_t=0;
	  if($cont_estilo != 1){
	$classe2 = "filas_resultados";
	$cont_estilo = 1;
	}else{
		$classe2 = "";
		$cont_estilo = 2;
		}
	  while($s_valores = traer_fila_db($selecciona_valores)){
		  
		  
	  ?>
      <tr id="fila_1-<?=$consecutivo?>" class="<?=$classe2?>" >
        
        <?
	if($es_el_primero == 0){//es para imprimir o no la primera columna que tiene el rowspan
		$es_el_primero =1;
    ?>
        <td colspan="2" rowspan="<?=$convina_rowspan_columna_1?>" align="center" id="fila_7-<?=$consecutivo?>" class="<?=$classe2?>"><?=$sel_temp[0]?>
          <?   if($sel_item_masivo[0]<>""){echo "Carga Masiva";}
		  if($sel_item_masivo[1]==12){echo "Reclasificacion";} ?>
          </td>
        <?
      if($sel_temp[1]=="inicial2"){//si es iniicial
	  ?>
        <td id="fila_8-<?=$consecutivo?>"  rowspan="<?=$convina_rowspan_columna_1?>" align="center" class="<?=$classe2?>"><?=$s_valores[4]?></td>
        <td id="fila_9-<?=$consecutivo?>" rowspan="<?=$convina_rowspan_columna_1?>" align="center" class="<?=$classe2?>"><?=$s_valores[12]?></td>
        <?
	  }else{
		  ?><td align="center" class="<?=$classe2?>" ><?=$s_valores[4]?></td><td align="center" class="<?=$classe2?>"><?=$s_valores[12]?></td><? //si es el primero pero no es inicial debe imprimir la columna de los contratos sin rowspan
		  }
	}else{ if($sel_temp[1]<>"inicial2"){?><td align="center" class="<?=$classe2?>"><?=$s_valores[4]?></td><td class="<?=$classe2?>" align="center"><?=$s_valores[12]?></td><? }}//si no es el primero debe imprimir la columna de los contratos sin rowspan
	
	
		$trm=trm_presupuestal($s_valores[5]);
	
	$valor_equivalente = 0;
	if($moneda == "USD"){
	$valor_equivalente = $s_valores[7] + ($s_valores[8]/$trm);
	}
	if($moneda == "COP"){
	$valor_equivalente = $s_valores[8] + ($s_valores[7]*$trm);
	}
	
	$valor_usd_t=$s_valores[7]+$valor_usd_t;
	$valor_cop_t=$valor_cop_t+$s_valores[8];
	$valor_eqi_t=$valor_equivalente+$valor_eqi_t;
	
	
  $valor_cop_total_liz = $valor_cop_total_liz + $s_valores[8];
  $valor_usd_total_liz = $valor_usd_total_liz + $s_valores[7];
  $valor_equ_total_liz = $valor_equ_total_liz + $valor_equivalente;
	
	  ?>
        
        
        
        
        <td align="center"><?=$s_valores[5]?></td>
        <td align="center"><?=$s_valores[6]?></td>
        <td width="2%" align="center"><?=number_format($s_valores[7],0,"","")?></td>
        <td width="2%" align="center"><?=number_format($s_valores[8],0,"","")?></td>
        <td width="2%" align="center"  style="mso-number-format:'0';"><?=number_format($valor_equivalente,0,"","")?></td>
        <td width="2%" align="center"><?=number_format($trm,0,"","")?></td>
        </tr>
      
      
      <?
	  }
	?>
      
      
      
      
      
      
      <?
  }//fin while principal temporal
  
 /*SE COMENTAREA LA FILA DEL TOTAL
	?>
      <tr >
        <td colspan="2" align="center"  >&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td  align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center">&nbsp;</td>
        <td align="center" class="fondo_3"><?=number_format($valor_usd_total_liz)?></td>
        <td align="center" class="fondo_3"><?=number_format($valor_cop_total_liz)?></td>
        <td align="center" class="fondo_3"><?=number_format($valor_equ_total_liz)?></td>
        <td align="center"></td>
        
        </tr>
		<? */?>
    </table></td>
</tr>
<tr>
  <td align="center">&nbsp;</td>
</tr>
<?
$saber_si_tiene_reclasificaciones = traer_fila_row(query_db("select count(*) from t2_reporte_marco_temporal as t1, t2_item_pecc as t2 where t1.id_item = t2.id_item and t2.t1_tipo_proceso_id = 12 and t1.id_us= '".$_SESSION["id_us_session"]."' and t1.tipo in ('ots') "));

if($saber_si_tiene_reclasificaciones[0]==0){
?>
<tr>
  <td align="center"><table width="60%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" align="left">
    <tr class="fondo_3">
      <td colspan="6" align="center">RESUMEN DE APROBACIONES</td>
      </tr>
    <tr class="fondo_3">
      <td width="7%" align="center">A&ntilde;o</td>
      <td width="25%" align="center">Area / Proyecto</td>
      <td width="19%" align="center">Origen USD</td>
      <td width="19%" align="center">Origen COP</td>
      <td width="22%" align="center">Equivalente <?=$moneda?>$</td>
      <td width="8%" align="center">TRM</td>
    </tr>
    <?
	 $sql_consolidado = "select  ano, campo, sum(usd), sum(cop) from t2_reporte_marco_temporal, t2_item_pecc as t2 where t2.id_item = t2_reporte_marco_temporal.id_item and t2.estado <> 33 and t2_reporte_marco_temporal.id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion', 'reclasificacion') $comple_sql group by ano, campo order by ano,campo asc";
     $selecciona_valores = query_db($sql_consolidado);
	  	  
	  while($s_valores = traer_fila_db($selecciona_valores)){
		  
		  $trm = trm_presupuestal($s_valores[0]);
		  
if($moneda == "USD"){
		$eq_usd = $s_valores[2] + ($s_valores[3]/$trm);	
}
if($moneda == "COP"){
		$eq_usd = $s_valores[3] + ($s_valores[2]*$trm);	
}
		if($cont_estilo != 1){
	$classe = "filas_resultados";
	$cont_estilo = 1;
	}else{
		$classe = "";
		$cont_estilo = 2;
		}
?>
    <tr class="<?=$classe?>">
      <td align="center"><?=$s_valores[0]?></td>
      <td align="center"><?=$s_valores[1]?></td>
      <td align="center"><?=number_format($s_valores[2])?></td>
      <td align="center"><?=number_format($s_valores[3])?></td>
      <td align="center" style="mso-number-format:'0';"><?=number_format($eq_usd,0,"","")?></td>
      <td align="center"><?=number_format(trm_presupuestal($s_valores[0]))?></td>
    </tr>
    
    
    <?
	  }
	?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center" class="fondo_3"><?=number_format($valor_usd_total_liz)?></td>
      <td align="center" class="fondo_3"><?=number_format($valor_cop_total_liz)?></td>
      <td align="center" class="fondo_3" style="mso-number-format:'0';"><?=number_format($valor_equ_total_liz,0,"","")?></td>
      <td>&nbsp;</td>
    </tr>
  </table></td>
</tr>
<?
}
if($saber_si_tiene_reclasificaciones[0]>0){
?>
<tr>
  <td align="center"><table width="100%" border="0" align="center" bgcolor="#FFFFFF" class="tabla_lista_resultados">
    <tr>
      <td><strong>VALOR TOTAL APROBACIONES MENOS LAS RECLASIFICACIONES</strong></td>
    </tr>
  </table></td>
</tr>
<tr>
  <td align="center"><table width="90%" border="1" align="left" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
    <?
  
  if($_GET["id_solicitud"]<>0){
	  $comple_sql = " and id_item=".$_GET["id_solicitud"];
	  }
  
  $cuantos_solicitudes="select num_item,tipo,id_item from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion', 'reclasificacion') $comple_sql group by num_item,tipo,id_item order by id_item asc";
  

  

  $sel_cuantos=query_db($cuantos_solicitudes);
  $cuantos =0;
  while($sel_temp = traer_fila_db($sel_cuantos)){
	   $cuantos =$cuantos+1;
  }
  
  $sel_temporal_sql="select num_item,tipo,t2_reporte_marco_temporal_menos_reclasificaciones.id_item from t2_reporte_marco_temporal_menos_reclasificaciones, t2_item_pecc as t2 where t2.id_item =t2_reporte_marco_temporal_menos_reclasificaciones.id_item and t2_reporte_marco_temporal_menos_reclasificaciones.id_us = '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion', 'reclasificacion') and t2.estado >= 20 and t2.estado <= 32 and t2.estado <> 31 group by num_item,tipo,t2_reporte_marco_temporal_menos_reclasificaciones.id_item order by id_item asc";


  ?>
    <tr class="fondo_3">
      <td colspan="2" align="center">Numero de la Solicitud</td>
      <td width="12%" align="center">Contrato</td>
      <td width="26%" align="center">Contratista</td>
      <td width="5%" align="center">A&ntilde;o</td>
      <td width="18%" align="center">Area / Proyecto</td>

      <td width="9%" align="center" class="estilo_reporte_fondo_verde">Equivalente
        <?=$moneda?>
        $</td>
      <td width="8%" align="center">TRM</td>
    </tr>
    <?

  $sel_temporal=query_db($sel_temporal_sql);
  $consecutivo=0;
  
  $valor_cop_total_liz =0;
  $valor_usd_total_liz =0;
  $valor_equ_total_liz =0;
  $cont_estilo = 2;
  $valor_equivalente_total_recla=0;
  while($sel_temp = traer_fila_db($sel_temporal)){
	  
	  $sel_item_masivo= traer_fila_row(query_db("select de_historico, t1_tipo_proceso_id from t2_item_pecc where id_item = ".$sel_temp[2]));
	  
	  
	  $consecutivo=$consecutivo+1;
	$titulo="";
  $titulo2="";
	
	  if($sel_temp[1]=="inicial"){	  
	  $titulo = "SOLICITUD INICIAL - ".$sel_temp[0];
	  $titulo2= "<strong>SOLICITUD INICIAL - ".$sel_temp[0]."</strong>";
	

	  }
	  if($sel_temp[1]=="ampliacion"){	  
	  $titulo = "SOLICITUD DE AMPLIACION - ".$sel_temp[0];
	  $titulo2= "<strong>SOLICITUD DE AMPLIACION - ".$sel_temp[0]."</strong>";
	  }
	  
	 $cuanta_cuantos_registros=traer_fila_row(query_db("select count(*) from t2_reporte_marco_temporal_menos_reclasificaciones where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]." and tipo in ('inicial', 'ampliacion', 'reclasificacion')"));
	 
	 
	 $convina_rowspan_columna_1=$cuanta_cuantos_registros[0];////la columna donde estan los numeros de la solucitud
  

      $selecciona_valores = query_db("select  id_reporte, id_us, tipo, id_item, CAST (contratos as text), ano, campo, usd, cop, id_campo, t2_presupuesto_id, num_item, CAST (contratista as text), id_item_ots_aplica, saldo_eq_usd, saldo_eq_cop from t2_reporte_marco_temporal_menos_reclasificaciones where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]." and tipo in ('inicial', 'ampliacion', 'reclasificacion')");
	  $es_el_primero = 0;
	  
	  $valor_usd_t=0;
	$valor_cop_t=0;
	$valor_eqi_t=0;
	
	  if($cont_estilo != 1){
	$classe2 = "filas_resultados";
	$cont_estilo = 1;
	}else{
		$classe2 = "";
		$cont_estilo = 2;
		}
		
	  while($s_valores = traer_fila_db($selecciona_valores)){
		  
		  
	  ?>
    <tr id="fila_1-<?=$consecutivo?>2" class="<?=$classe2?>" >
      <?
	if($es_el_primero == 0){//es para imprimir o no la primera columna que tiene el rowspan
		$es_el_primero =1;
    ?>
      <td colspan="2" rowspan="<?=$convina_rowspan_columna_1?>" align="center" id="fila_7-<?=$consecutivo?>2" class="<?=$classe2?>"><?=$sel_temp[0]?>
        <?   if($sel_item_masivo[0]<>""){echo "Carga Masiva";}
		  if($sel_item_masivo[1]==12){echo "Reclasificacion";} ?></td>
      <?
      if($sel_temp[1]=="inicial2"){//si es iniicial
	  ?>
      <td id="fila_8-<?=$consecutivo?>2"  rowspan="<?=$convina_rowspan_columna_1?>" align="center" class="<?=$classe2?>"><?=$s_valores[4]?></td>
      <td id="fila_9-<?=$consecutivo?>2" rowspan="<?=$convina_rowspan_columna_1?>" align="center" class="<?=$classe2?>"><?=$s_valores[12]?></td>
      <?
	  }else{
		  ?>
      <td align="center" class="<?=$classe2?>"><?=$s_valores[4]?></td>
      <td align="center" class="<?=$classe2?>"><?=$s_valores[12]?></td>
      <? //si es el primero pero no es inicial debe imprimir la columna de los contratos sin rowspan
		  }
	}else{ if($sel_temp[1]<>"inicial2"){?>
      <td align="center" class="<?=$classe2?>"><?=$s_valores[4]?></td>
      <td class="<?=$classe2?>" align="center"><?=$s_valores[12]?></td>
      <? }}//si no es el primero debe imprimir la columna de los contratos sin rowspan
	
	
		$trm=trm_presupuestal($s_valores[5]);
	
	if($moneda == "USD"){
	$valor_equivalente = $s_valores[14];
	}
	if($moneda == "COP"){
	$valor_equivalente = $s_valores[15];
	}
	$valor_equivalente_total_recla = $valor_equivalente_total_recla + $valor_equivalente;
	
	  ?>
      <td width="4%" align="center"><?=$s_valores[5]?></td>
      <td width="4%" align="center"><?=$s_valores[6]?></td>
   
      <td width="2%" align="center" style="mso-number-format:'0';"><?=number_format($valor_equivalente,0,"","")?></td>
      <td width="2%" align="center"><?=number_format($trm,0,"","")?></td>
    </tr>
    
    <?
	  }
	?>
    
    <?
  }//fin while principal temporal
  
  ?>
  <tr >
  
   
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td >&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center" class="estilo_reporte_fondo_verde" style="mso-number-format:'0';" ><?=number_format($valor_equivalente_total_recla,0,"","")?></td>
      <td align="center">&nbsp;</td>
    </tr>
  </table></td>
</tr>
<tr>
  <td align="center">&nbsp;</td>
</tr>
<tr>
  <td align="center"><table width="100%" border="0" align="center" bgcolor="#FFFFFF" class="tabla_lista_resultados">
    <tr>
      <td><strong>CONSOLIDADO DEL VALOR TOTAL DE APROBACIONES MENOS LAS RECLASIFICACIONES</strong></td>
    </tr>
  </table></td>
</tr>
<tr>
  <td align="center">
  <table width="60%" border="1" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" align="left">
    <tr class="fondo_3">
      <td width="24%" align="center">A&ntilde;o</td>
      <td width="33%" align="center">Area / Proyecto</td>
      <td width="17%" align="center">TRM</td>
      <td width="26%" align="center" class="estilo_reporte_fondo_verde">RESUMEN DE APROBACIONES<br />
        Equivalente
        <?=$moneda?>
        $</td>
    </tr>
    <?
	 $sql_consolidado = "select  ano, campo, sum(usd), sum(cop), id_campo from t2_reporte_marco_temporal, t2_item_pecc as t2 where t2.id_item = t2_reporte_marco_temporal.id_item and t2.estado >= 20 and t2.estado <= 32 and t2.estado <> 31 and t2_reporte_marco_temporal.id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion', 'reclasificacion') $comple_sql group by ano, campo, id_campo order by ano,campo asc";
     $selecciona_valores = query_db($sql_consolidado);
	  	
$total_final = 0;
	  while($s_valores = traer_fila_db($selecciona_valores)){
		  
		  $trm = trm_presupuestal($s_valores[0]);
		  
if($moneda == "USD"){
		$eq_usd = $s_valores[2] + ($s_valores[3]/$trm);	
}
if($moneda == "COP"){
		$eq_usd = $s_valores[3] + ($s_valores[2]*$trm);	
}
		if($cont_estilo != 1){
	$classe = "filas_resultados";
	$cont_estilo = 1;
	}else{
		$classe = "";
		$cont_estilo = 2;
		}
		
		
		//echo "select  t1.ano, t1.campo, sum(t1.usd), sum(t1.cop) from t2_reporte_marco_temporal_menos_reclasificaciones as t1, t2_item_pecc as t2 where t1.id_item = t2.id_item and t2.t1_tipo_proceso_id = 12 and t1.id_us= '".$_SESSION["id_us_session"]."' and t1.tipo in ('ots') and id_campo = ".$s_valores[4]." and ano = ".$s_valores[0]." $comple_sql group by t1.ano, t1.campo order by t1.ano,t1.campo asc<br /><br />";
		
		
		 $selecciona_valores_reclasificaciones = traer_fila_row(query_db("select  t1.ano, t1.campo, sum(t1.usd), sum(t1.cop) from t2_reporte_marco_temporal as t1, t2_item_pecc as t2 where t1.id_item = t2.id_item and t2.t1_tipo_proceso_id = 12  and t2.estado >= 20 and t2.estado <= 32 and t2.estado <> 31 and t1.id_us= '".$_SESSION["id_us_session"]."' and t1.tipo in ('ots') and id_campo = ".$s_valores[4]." and ano = ".$s_valores[0]." $comple_sql group by t1.ano, t1.campo order by t1.ano,t1.campo asc"));
		 
		 if($moneda == "USD"){
		$eq_usd_reclasifica = $selecciona_valores_reclasificaciones[2] + ($selecciona_valores_reclasificaciones[3]/$trm);	
			}
			if($moneda == "COP"){
		$eq_usd_reclasifica = $selecciona_valores_reclasificaciones[3] + ($selecciona_valores_reclasificaciones[2]*$trm);	
		}
		
?>
    <tr class="<?=$classe?>">
      <td align="center"><?=$s_valores[0]?></td>
      <td align="center"><?=$s_valores[1]?></td>
      <td align="center"><?=number_format(trm_presupuestal($s_valores[0]),0,"","")?></td>
      <td align="center" style="mso-number-format:'0';"><?=number_format($eq_usd - $eq_usd_reclasifica,0,"","")?></td>
    </tr>
    <?
	$total_final = $total_final + ($eq_usd - $eq_usd_reclasifica);
	  }
	?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center" class="estilo_reporte_fondo_verde" style="mso-number-format:'0';"><?=number_format($total_final,0,"","")?></td>
    </tr>
  </table>
</td>
</tr>
<?
}
?>

</table>




</body>
</html>
