<? header("Content-type: application/octet-stream");header("Content-Disposition: attachment; filename=Reporte detalle contrato marco por solicitud.xls"); header("Pragma: no-cache"); header("Expires: 0");	 
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

</style>
</head>
<body>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
<tr><td>
  <table width="100%" border="0" align="center" bgcolor="#FFFFFF" class="tabla_lista_resultados">
    <tr>
      <td><strong>REPORTE COMPLETO POR SOLICITUD</strong></td>
    </tr>
  </table>
  </td></tr>
  </table>
  
  <table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
<tr>
  <td width="100%" align="center"><table width="100%" border="1" cellpadding="0" cellspacing="0" class="tabla_lista_resultados">
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
  
  $sel_temporal_sql="select num_item,tipo,id_item from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion', 'reclasificacion') $comple_sql group by num_item,tipo,id_item order by id_item asc";
  

  

  $sel_temporal=query_db($sel_temporal_sql);
  $consecutivo=0;
  while($sel_temp = traer_fila_db($sel_temporal)){
	  
	  $sel_item_masivo= traer_fila_row(query_db("select de_historico from t2_item_pecc where id_item = ".$sel_temp[2]));
	  
	  
	  $consecutivo=$consecutivo+1;
	$titulo="";
  $titulo2="";
	
	         $comple_sql =" and id_item_ots_aplica=".$sel_temp[2];
    		 
			 
	  if($sel_temp[1]=="inicial"){	 
	  $comple_sql =" and id_item_ots_aplica=0"; 
	  $titulo = "SOLICITUD INICIAL - ".$sel_temp[0];
	  $titulo2= "<strong>SOLICITUD INICIAL - ".$sel_temp[0]."</strong>";
	  }
	  if($sel_temp[1]=="ampliacion"){	  
	  $titulo = "SOLICITUD DE AMPLIACION - ".$sel_temp[0];
	  $titulo2= "<strong>SOLICITUD DE AMPLIACION - ".$sel_temp[0]."</strong>";
	  }
	  if($sel_temp[1]=="reclasificacion"){	  
	  $titulo = "SOLICITUD DE RECLASIFICACION - ".$sel_temp[0];
	  $titulo2= "<strong>SOLICITUD DE RECLASIFICACION - ".$sel_temp[0]."</strong>";
	  }
	  
	
	  
	 $cuanta_cuantos_registros=traer_fila_row(query_db("select count(*) from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]." and tipo in ('inicial', 'ampliacion', 'reclasificacion')"));
	 
	 
	 $convina_rowspan_columna_1=$cuanta_cuantos_registros[0];////la columna donde estan los numeros de la solucitud
  
  ?>
    <tr class="" id="fila_2-<?=$consecutivo?>" >
      <td colspan="10" align="center" class="estilo_reporte_fondo_verde"><strong >
        <?=$titulo?>
      </strong></td>
    </tr>
    <tr class="fondo_3">
      <td colspan="2" align="center">Numero de la Solicitud</td>
      <td width="10%" align="center">Contrato</td>
      <td width="28%" align="center">Contratista</td>
      <td width="3%" align="center">A&ntilde;o</td>
      <td width="17%" align="center">Area / Proyecto</td>
      <td width="7%" align="center">Origen USD</td>
      <td width="9%" align="center">Origen COP</td>
      <td width="8%" align="center">Equivalente
        <?=$moneda?>
        $</td>
      <td width="4%" align="center">TRM</td>
    </tr>
    <?
      $selecciona_valores = query_db("select  id_reporte, id_us, tipo, id_item, CAST (contratos as text), ano, campo, usd, cop, id_campo, t2_presupuesto_id, num_item, CAST (contratista as text), id_item_ots_aplica from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]." and tipo in ('inicial', 'ampliacion', 'reclasificacion')");
	  $es_el_primero = 0;
	  
	  $valor_usd_t=0;
	$valor_cop_t=0;
	$valor_eqi_t=0;
	  
	  while($s_valores = traer_fila_db($selecciona_valores)){
	  ?>
    <tr id="fila_1-<?=$consecutivo?>" >
      <?
	if($es_el_primero == 0){//es para imprimir o no la primera columna que tiene el rowspan
		$es_el_primero =1;
    ?>
      <td colspan="2" rowspan="<?=$convina_rowspan_columna_1?>" align="center" id="fila_7-<?=$consecutivo?>" ><?=$sel_temp[0]?>
        <?   if($sel_item_masivo[0]<>""){echo "Carga Masiva";} ?></td>
      <?
      if($sel_temp[1]=="inicial2"){//si es iniicial
	  ?>
      <td id="fila_8-<?=$consecutivo?>"  rowspan="<?=$convina_rowspan_columna_1?>" align="center"><?=$s_valores[4]?></td>
      <td id="fila_9-<?=$consecutivo?>" rowspan="<?=$convina_rowspan_columna_1?>" align="center"><?=$s_valores[12]?></td>
      <?
	  }else{
		  ?>
      <td align="center"><?=$s_valores[4]?></td>
      <td align="center"><?=$s_valores[12]?></td>
      <? //si es el primero pero no es inicial debe imprimir la columna de los contratos sin rowspan
		  }
	}else{ if($sel_temp[1]<>"inicial2"){?>
      <td align="center"><?=$s_valores[4]?></td>
      <td align="center"><?=$s_valores[12]?></td>
      <? }}//si no es el primero debe imprimir la columna de los contratos sin rowspan
	
	

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
	
	  ?>
      <td align="center" ><?=$s_valores[5]?></td>
      <td align="center"><?=$s_valores[6]?></td>
      <td width="1%" align="center"><?=$s_valores[7]?></td>
      <td width="1%" align="center" style="mso-number-format:'0';"><?=number_format($s_valores[8],0,"","")?></td>
      <td width="1%" align="center" style="mso-number-format:'0';"><?=number_format($valor_equivalente,0,"","")?></td>
      <td width="1%" align="center"><?=$trm?></td>
    </tr>
    <?
	  }
	?>
    <?
      $selecciona_valores = query_db("select  ano, sum(usd), sum(cop) from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]." and tipo in ('inicial', 'ampliacion', 'reclasificacion') group by ano");
	  $es_el_primero = 0;
	  
	  $valor_usd_t=0;
	$valor_cop_t=0;
	$valor_eqi_t=0;
	  
	  while($s_valores = traer_fila_db($selecciona_valores)){
	  ?>
    <tr class="filas_resultados" id="fila_6-<?=$consecutivo?>" >
      <td colspan="4" align="right" class="">Valor Total de la Solcitud por A&ntilde;o:</td>
      <? 
	
$trm=trm_presupuestal($s_valores[0]);
	
	
	$valor_equivalente = 0;
	if($moneda == "USD"){
        $valor_equivalente_solicitud = $s_valores[1] + ($s_valores[2]/$trm);
	}
	if($moneda == "COP"){
        $valor_equivalente_solicitud = $s_valores[2] + ($s_valores[1]*$trm);
	}
	
	
	  ?>
      <td align="center"><?=$s_valores[0]?></td>
      <td align="center">&nbsp;</td>
      <td align="center"><?=$s_valores[1]?></td>
      <td align="center"><?=$s_valores[2]?></td>
      <td align="center" style="mso-number-format:'0';"><?=number_format($valor_equivalente_solicitud,0,"","")?></td>
      <td align="center"><?=$trm?></td>
    </tr>
    <?
	  }
	  
	  
         //$comple_sql ="";
         $item_para_row_espan="";
            $valor_usd_t_ot=0;
        $valor_cop_t_ot=0;
        $valor_eqi_t_ot=0;
		
	//$selecciona_ots = query_db("select CAST (contratos as text) from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."'  and tipo = 'ots' ".$comple_sql." group by contratos");
	$selecciona_ots = query_db("select CAST (t1.contratos as text) from t2_reporte_marco_temporal as t1, t2_item_pecc as t2 where t1.id_item = t2.id_item and t2.t1_tipo_proceso_id = 8 and t1.id_us= '".$_SESSION["id_us_session"]."'  and t1.tipo = 'ots' ".$comple_sql_ots." group by t1.contratos");
	
	while($sel_ots_cuadr = traer_fila_db($selecciona_ots)){
	
	?>
    <tr class="estilo_reporte_fondo_verde" id="fila_2-<?=$consecutivo?>" >
      <td colspan="10" align="center" class="estilo_reporte_fondo_verde">EJECUCION POR ORDENES DE TRABAJO CONTRATO
        <?=$sel_ots_cuadr[0]?></td>
    </tr>
    <tr class="fondo_3">
      <td colspan="2" align="center"> Ordenes de Trabajo</td>
      <td width="10%" align="center">Contrato</td>
      <td width="28%" align="center">Contratista</td>
      <td width="3%" align="center">A&ntilde;o</td>
      <td width="17%" align="center">Area / Proyecto</td>
      <td width="7%" align="center">Origen USD</td>
      <td width="9%" align="center">Origen COP</td>
      <td width="8%" align="center">Equivalente
        <?=$moneda?>
        $</td>
      <td width="4%" align="center">TRM</td>
    </tr>
    <?
          
          
                  if($_SESSION["id_us_session"] == 32){
		 }

            $cuenta_para_rowspan = traer_fila_row(query_db("select count(*) from t2_reporte_marco_temporal as t1, t2_item_pecc as t2 where t1.id_item = t2.id_item and t2.t1_tipo_proceso_id = 8 and t1.id_us= '".$_SESSION["id_us_session"]."'  and t1.tipo = 'ots'  and t1.contratos like '%".$sel_ots_cuadr[0]."%' ".$comple_sql_ots));

          $selecciona_valores = query_db("select t1.id_reporte, t1.id_us, t1.tipo, t1.id_item, CAST (t1.contratos as text), t1.ano, t1.campo, t1.usd, t1.cop, t1.id_campo, t1.t2_presupuesto_id, t1.num_item, CAST (t1.contratista as text), t1.id_item_ots_aplica from t2_reporte_marco_temporal as t1, t2_item_pecc as t2 where t1.id_item = t2.id_item and t2.t1_tipo_proceso_id = 8 and t1.id_us= '".$_SESSION["id_us_session"]."'  and t1.tipo = 'ots' and t1.contratos like '%".$sel_ots_cuadr[0]."%'  ".$comple_sql_ots." order by t1.num_item");
          
          while($s_valores = traer_fila_db($selecciona_valores)){
			  
              $sel_ot= traer_fila_row(query_db("select de_historico, estado, solicitud_rechazada from t2_item_pecc where id_item = ".$s_valores[3]));
			  $texto_ot = "";
			    if($sel_ot[0]<>""){$texto_ot =  " - Carga Masiva";} 
			    if($sel_ot[1]<=17){$texto_ot.="<br />En Proceso de Aprobaci&oacute;n";} 
				if($sel_ot[2]==1 and $sel_ot[1] == 32){$texto_ot.="<br /><font color=#FF0000>Solicitud Rechazada</strong></font>";} 

              $cuenta_para_rowspan_num_ot = traer_fila_row(query_db("select count(*) from t2_reporte_marco_temporal where id_item = ".$s_valores[3]." and id_us= '".$_SESSION["id_us_session"]."' and tipo in ('ots')  and contratos = '".$sel_ots_cuadr[0]."'  $comple_sql"));
              
              if($contratos_que_viene==$s_valores[4]){
                    $num_contra_while="<font color=#0000FF>".$s_valores[4]."</font>";
                }else{
                    $num_contra_while=$s_valores[4];
                    }
          ?>
    <tr id="fila_3-<?=$consecutivo?>" >
      <?
        if($es_el_primero == 0){//es para imprimir o no la primera columna que tiene el rowspan
            $es_el_primero =1;
              
        ?>
      <?
          }
          $row_num_ot="";
          if($item_para_row_espan<>$s_valores[3]){
              $item_para_row_espan=$s_valores[3];

               $row_num_ot='<td  rowspan="'.$cuenta_para_rowspan_num_ot[0].'" colspan="2">'.$s_valores[11].$texto_ot.' </td>';
               $row_num_ot.='<td  rowspan="'.$cuenta_para_rowspan_num_ot[0].'">'.$num_contra_while.' </td>';
               $row_num_ot.='<td  rowspan="'.$cuenta_para_rowspan_num_ot[0].'">'.$s_valores[12].' </td>';
              }else{
                 //$row_num_ot="<td>".$s_valores[11]."</td>"; 
                  }
              
              echo $row_num_ot;
              
       $trm=trm_presupuestal($s_valores[5]);       
            
        $valor_equivalente = 0;
        if($moneda == "USD"){
        $valor_equivalente = $s_valores[7] + ($s_valores[8]/$trm);
		}
		if($moneda == "COP"){
        $valor_equivalente = $s_valores[8] + ($s_valores[7]*$trm);
		}
            
        $valor_usd_t_ot=$s_valores[7]+$valor_usd_t_ot;
        $valor_cop_t_ot=$valor_cop_t_ot+$s_valores[8];
        $valor_eqi_t_ot=$valor_equivalente+$valor_eqi_t_ot;
          
          ?>
      <td width="5%" align="center"><?=$s_valores[5]?></td>
      <td width="5%" align="center"><?=$s_valores[6]?></td>
      <td align="center"><?=$s_valores[7]?></td>
      <td align="center"><?=$s_valores[8]?></td>
      <td align="center" style="mso-number-format:'0';"><?=number_format($valor_equivalente,0,"","")?></td>
      <td align="center"><?=$trm?></td>
    </tr>
    <?
		  }
          
      
      
        
     
        
        $valor_disponible_sol_usd = $valor_usd_t-$valor_usd_t_ot;
        $valor_disponible_sol_cop = $valor_cop_t-$valor_cop_t_ot;
        $valor_disponible_sol_equi = $valor_eqi_t-$valor_eqi_t_ot;
        
        $tt_usd=$tt_usd+$valor_disponible_sol_usd;
        $tt_cop=$tt_cop+$valor_disponible_sol_cop;
        $tt_equ=$tt_equ+$valor_disponible_sol_equi;
        ?>
    <?
	   //$selecciona_valores = query_db("select * from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."'  and tipo = 'ots' ".$comple_sql);
	  /*
		if($sel_temp[1]=="inicial2"){//si es iniicial trae las relaciones en 0
	 
	 $comple_sql =" and id_item_ots_aplica=0";
	 }else{
		 $comple_sql =" and id_item_ots_aplica=".$sel_temp[2];
		 }*/

      //$selecciona_valores = query_db("select  ano, sum(usd), sum(cop) from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and tipo = 'ots'  and contratos = '".$sel_ots_cuadr[0]."' ".$comple_sql." group by ano");
	  $selecciona_valores = query_db("select  t1.ano, sum(t1.usd), sum(t1.cop) from t2_reporte_marco_temporal as t1, t2_item_pecc as t2 where t1.id_item = t2.id_item and t2.t1_tipo_proceso_id = 8 and t1.id_us= '".$_SESSION["id_us_session"]."' and t1.tipo = 'ots'  and t1.contratos = '".$sel_ots_cuadr[0]."' ".$comple_sql_ots." group by t1.ano");
	  
	  $es_el_primero = 0;
	  
	  $valor_usd_t=0;
	$valor_cop_t=0;
	$valor_eqi_t=0;
	  
	  while($s_valores = traer_fila_db($selecciona_valores)){
	  ?>
    <tr class="filas_resultados" id="fila_5-<?=$consecutivo?>"  >
      <td colspan="4" align="right" class="filas_resultados">Valor Total de las Ordenes de Trabajo por A&ntilde;o:</td>
      <? 
	
	

	   $trm=trm_presupuestal($s_valores[0]);  
	$valor_equivalente = 0;
	if($moneda == "USD"){
     	$valor_equivalente_ots = $s_valores[1] + ($s_valores[2]/$trm);
	}
	if($moneda == "COP"){
     	$valor_equivalente_ots = $s_valores[2] + ($s_valores[1]*$trm);
	}
	
	
	  ?>
      <td align="center" ><?=$s_valores[0]?></td>
      <td align="center">&nbsp;</td>
      <td align="center" ><?=$s_valores[1]?></td>
      <td align="center" ><?=$s_valores[2]?></td>
      <td align="center" style="mso-number-format:'0';"><?=number_format($valor_equivalente_ots,0,"","")?></td>
      <td align="center" ><?=$trm?></td>
    </tr>
    <?
	  }
	}
	?>
    
    <?
  }//fin while principal temporal
	?>
  </table></td>
</tr>

</table>




</body>
</html>
