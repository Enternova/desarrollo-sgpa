<? header("Content-type: application/octet-stream");header("Content-Disposition: attachment; filename=Reporte detalle contrato marco Total de Ejecuciones.xls"); header("Pragma: no-cache"); header("Expires: 0");	 
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
      <td><strong>VALOR TOTAL DE LAS ORDENES DE TRABAJO Y ORDENES DE PEDIDO CREADAS</strong></td>
    </tr>
  </table>
  </td></tr>
  </table>
  
  
  
  <table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
<tr>
  <td colspan="2" align="center">
    
    
    <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
<?
$selecciona_ots = query_db("select CAST (contratos as text) from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."'  and tipo = 'ots' ".$comple_sql." group by contratos");
	while($sel_ots_cuadr = traer_fila_db($selecciona_ots)){
		
?>
      <tr class="fondo_3">
        <td colspan="10" align="center">Consolidado de Ejecuciones Contrato <?=$sel_ots_cuadr[0]?></td>
        </tr>
      <tr class="fondo_3">
          <td colspan="2" align="center"> Ordenes de Trabajo</td>
          <td width="10%" align="center">Contrato</td>
          <td width="28%" align="center">Contratista</td>
          <td width="3%" align="center">A&ntilde;o</td>
          <td width="17%" align="center">Area / Proyecto</td>
          <td width="7%" align="center">Origen USD</td>
          <td width="9%" align="center">Origen COP</td>
          <td width="8%" align="center">Equivalente <?=$moneda?>$</td>
          <td width="4%" align="center">TRM</td>
    
          </tr>

		  <?
          
         $comple_sql ="";
         $item_para_row_espan="";
            $valor_usd_t_ot=0;
        $valor_cop_t_ot=0;
        $valor_eqi_t_ot=0;
       /* 
		 if($sel_temp[1]=="inicial"){//si es iniicial trae las relaciones en 0
         
         $comple_sql =" and id_item_ots_aplica=0";
         }else{
             $comple_sql =" and id_item_ots_aplica=".$sel_temp[2];
             }
          */
         $comple_filtro_contrato = "and contratos = '".$sel_ots_cuadr[0]."'";
		 //$comple_filtro_contrato = "";
           $cuenta_para_rowspan = traer_fila_row(query_db("select count(*) from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."'  and tipo = 'ots' $comple_filtro_contrato  ".$comple_sql));
           
          $selecciona_valores = query_db("select t1.id_reporte, t1.id_us, t1.tipo, t1.id_item, CAST (t1.contratos as text), t1.ano, t1.campo, t1.usd, t1.cop, t1.id_campo, t1.t2_presupuesto_id, t1.num_item, CAST (t1.contratista as text), t1.id_item_ots_aplica from t2_reporte_marco_temporal as t1, t2_item_pecc as t2 where t1.id_item = t2.id_item and t2.t1_tipo_proceso_id = 8 and t1.id_us= '".$_SESSION["id_us_session"]."'  and t1.tipo = 'ots'  and t1.contratos = '".$sel_ots_cuadr[0]."' ".$comple_sql." order by t1.num_item");
          $es_el_primero = 0;
          
          while($s_valores = traer_fila_db($selecciona_valores)){
			  
              $sel_ot= traer_fila_row(query_db("select de_historico, estado, solicitud_rechazada from t2_item_pecc where id_item = ".$s_valores[3]));
			  $texto_ot = "";
			    if($sel_ot[0]<>""){$texto_ot =  " - Carga Manual";} 
			  //  if($sel_ot[1]<=17 or $sel_ot[1] ==31){ //PARA EL INC-015
            //$texto_ot.=" - En Proceso de Aprobaci&oacute;n";
              //$texto_ot.=" - En Proceso de Aprobaci&oacute;n";
              if($sel_ot[1] >= 21 and $sel_ot[1] < 31){
                $texto_ot.=" - En legalizaci&oacute;n";
              }elseif($sel_ot[1] == 34){
                $texto_ot.=" - Validacion de Carga Manual";
              }elseif($sel_ot[1] == 31){
                $texto_ot.=" - En Preparaci&oacute;n";
              }elseif($sel_ot[1] <=20){//si esta en un estado que aun no se ha aprobado
                 $estado_item_pecc=traer_fila_row(query_db("select nombre from t2_nivel_servicio_actividades where t2_nivel_servicio_actividad_id = ".$sel_ot[1]));
                $texto_ot.=" - ".$estado_item_pecc[0];
              }else{
               // $estado_item_pecc=traer_fila_row(query_db("select distinct estado, nombre from v_peec_historico where estado = ".$sel_ot[1]));
                //print_r($estado_item_pecc);
               // $texto_ot.=" - ".$estado_item_pecc[1];
              }
         // } 
				if($sel_ot[2]==1 and $sel_ot[1] == 32){$texto_ot.="<br /><font color=#FF0000>Solicitud Rechazada</strong></font>";} 

              $cuenta_para_rowspan_num_ot = traer_fila_row(query_db("select count(*) from t2_reporte_marco_temporal where id_item = ".$s_valores[3]." and id_us= '".$_SESSION["id_us_session"]."' and tipo in ('ots')  and contratos = '".$sel_ots_cuadr[0]."'  $comple_sql"));
              
              if($contratos_que_viene==$s_valores[4]){
                    $num_contra_while="<font color=#0000FF>".$s_valores[4]."</font>";
                }else{
                    $num_contra_while=$s_valores[4];
                    }
					
	if($cont_estilo != 1){
	$classe = "filas_resultados";
	$cont_estilo = 1;
	$id_item = $s_valores[3];
	}else{
		if($id_item == $s_valores[3]){
			}else{
				$classe = "";
				$cont_estilo = 2;
			}
		}
          ?>
        <tr class="<?=$classe?>" id="fila_3-<?=$consecutivo?>" >
        <?
        if($es_el_primero == 0){//es para imprimir o no la primera columna que tiene el rowspan
            $es_el_primero =1;
              
        ?>
          
          <?
          }
          $row_num_ot="";
          if($item_para_row_espan<>$s_valores[3]){
              $item_para_row_espan=$s_valores[3];

               $row_num_ot='<td class="'.$classe.'" rowspan="'.$cuenta_para_rowspan_num_ot[0].'" colspan="2">'.$s_valores[11].$texto_ot.' </td>';
               $row_num_ot.='<td class="'.$classe.'"  rowspan="'.$cuenta_para_rowspan_num_ot[0].'">'.$num_contra_while.' </td>';
               $row_num_ot.='<td class="'.$classe.'"  rowspan="'.$cuenta_para_rowspan_num_ot[0].'">'.$s_valores[12].' </td>';
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
        /*    
        $valor_usd_t_ot=$s_valores[7]+$valor_usd_t_ot;
        $valor_cop_t_ot=$valor_cop_t_ot+$s_valores[8];
        $valor_eqi_t_ot=$valor_equivalente+$valor_eqi_t_ot;
          */
          ?>
          
    
    
          <td width="5%" align="center"  class="<?=$classe?>"><?=$s_valores[5]?></td>
          <td width="5%" align="center"  class="<?=$classe?>"><?=$s_valores[6]?> </td>
          <td align="center"  class="<?=$classe?>"><?=$s_valores[7]?></td>
          <td align="center"  class="<?=$classe?>"><?=$s_valores[8]?></td>
          <td align="center"  class="<?=$classe?>" style="mso-number-format:'0';"><?=number_format($valor_equivalente,0,"","")?></td>
          <td align="center"  class="<?=$classe?>"><?=$trm?></td>
    
        </tr>
        <?
          }
      
      
        
     /*
        
        $valor_disponible_sol_usd = $valor_usd_t-$valor_usd_t_ot;
        $valor_disponible_sol_cop = $valor_cop_t-$valor_cop_t_ot;
        $valor_disponible_sol_equi = $valor_eqi_t-$valor_eqi_t_ot;
        
        $tt_usd=$tt_usd+$valor_disponible_sol_usd;
        $tt_cop=$tt_cop+$valor_disponible_sol_cop;
        $tt_equ=$tt_equ+$valor_disponible_sol_equi;
       */
	    ?>
<?
	   //$selecciona_valores = query_db("select * from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."'  and tipo = 'ots' ".$comple_sql);
	  /*
		if($sel_temp[1]=="inicial"){//si es iniicial trae las relaciones en 0
	 
	 $comple_sql =" and id_item_ots_aplica=0";
	 }else{
		 $comple_sql =" and id_item_ots_aplica=".$sel_temp[2];
		 }
*/

      $selecciona_valores = query_db("select  t1.ano, sum(t1.usd), sum(t1.cop) from t2_reporte_marco_temporal as t1, t2_item_pecc as t2 where t1.id_item = t2.id_item and t2.t1_tipo_proceso_id = 8 and t1.id_us= '".$_SESSION["id_us_session"]."' and t1.tipo = 'ots'  and t1.contratos = '".$sel_ots_cuadr[0]."'  ".$comple_sql." group by t1.ano ");
	  $es_el_primero = 0;
	  
	  	$valor_usd=0;
		  $valor_cop=0;
		  $valor_equivalente_ots=0;
		  


	  while($s_valores = traer_fila_db($selecciona_valores)){
	$trm=trm_presupuestal($s_valores[0]);  
	$valor_equivalente = 0;
	
	$valor_usd=$s_valores[1]+$valor_usd;
	$valor_cop = $s_valores[2]+$valor_cop;
	if($moneda == "USD"){
     	$valor_equivalente_ots = ($s_valores[1] + ($s_valores[2]/$trm))	 + $valor_equivalente_ots;
	}
	if($moneda == "COP"){
     	$valor_equivalente_ots = ($s_valores[2] + ($s_valores[1]*$trm)) + $valor_equivalente_ots;
	}
	  
	  }
	  ?>
    <tr  id=""  >
    
    
      

      
		<td colspan="4" align="right" >&nbsp;</td>
<? 
	
	

	 
	
	
	  ?>
      
      
      <td align="center" >&nbsp;</td>
      <td align="center">&nbsp;</td>
      <td align="center" class="fondo_3" ><?=$valor_usd?></td>
      <td align="center" class="fondo_3" ><?=$valor_cop?></td>
      <td align="center" class="fondo_3" style="mso-number-format:'0';"><?=number_format($valor_equivalente_ots,0,"","")?></td>
      <td align="center" ></td>
    </tr>
    
    <?
	}
	?>

    </table></td>
</tr>
<tr>
  <td colspan="2" align="center">&nbsp;</td>
</tr>
<tr>
  <td colspan="2" align="center">
  
  <table width="60%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" align="left">
    <tr class="fondo_3">
      <td colspan="6" align="center">RESUMEN DE EJECUCION</td>
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

     $selecciona_valores = query_db("select  t1.ano, t1.campo, sum(t1.usd), sum(t1.cop) from t2_reporte_marco_temporal as t1, t2_item_pecc as t2 where t1.id_item = t2.id_item and t2.t1_tipo_proceso_id = 8 and t1.id_us= '".$_SESSION["id_us_session"]."' and t1.tipo in ('ots') $comple_sql group by t1.ano, t1.campo order by t1.ano,t1.campo asc");
	  	   $valor_usd=0;
		  $valor_cop=0;
		  $valor_equivalente_ots=0;
		  $eq_usd=0;
	  while($s_valores = traer_fila_db($selecciona_valores)){
		  
	$trm=trm_presupuestal($s_valores[0]);       	 
		  
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
      <td align="center"><?=$s_valores[2]?></td>
      <td align="center"><?=$s_valores[3]?></td>
      <td align="center" style="mso-number-format:'0';"><?=number_format($eq_usd,0,"","")?></td>
      <td align="center"><?=trm_presupuestal($s_valores[0])?></td>
    </tr>
    
    
    <?
		  $valor_usd=$valor_usd + $s_valores[2];
		  $valor_cop= $valor_cop+$s_valores[3];
		  $valor_equivalente_ots=$valor_equivalente_ots + $eq_usd;
	
	  }
	   
	?>
    <tr>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center" class="fondo_3"><?=$valor_usd?></td>
      <td align="center" class="fondo_3"><?=$valor_cop?></td>
      <td align="center" class="fondo_3" style="mso-number-format:'0';"><?=number_format($valor_equivalente_ots,0,"","")?></td>
      <td>&nbsp;</td>
    </tr>
  </table></td>
</tr>
<tr>
  <td width="93%" align="center">&nbsp;</td>
  <td width="7%" align="right"><input type="button" value="Cerrar" class="boton_grabar_cancelar windowPopupClose" onclick='window.parent.document.getElementById(&quot;div_carga_busca_sol&quot;).style.display=&quot;none&quot;' /></td>
</tr>

</table>




</body>
</html>
