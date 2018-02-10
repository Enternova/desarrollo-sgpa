<? include("../../librerias/lib/@session.php"); 
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	

	
$sel_contratos_que_viene = traer_fila_row(query_db("select consecutivo,creacion_sistema,apellido from $co1 where id = ".$_GET["id_contrato"]." "));

$contratos_que_viene=numero_item_pecc_contrato_antes_formato("C",$sel_contratos_que_viene[1],$sel_contratos_que_viene[0],$sel_contratos_que_viene[2]);

		
	$sel_item= traer_fila_row(query_db("select id_item from t7_contratos_contrato where id=".$_GET["id_contrato"]));
		
	$id_solicitud=$sel_item[0];
	
	$delete = query_db("delete from t2_reporte_marco_temporal where id_us=".$_SESSION["id_us_session"]);
	
	
	/*Inicial*/
	$numero_solicitud="";
	
	$sel_valor_inicial_sq = "select t2_presupuesto_id, ano,campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3 from vista_reporte_saldos_marco_2_crea_inicial where id_item = $id_solicitud group by t2_presupuesto_id, ano, campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3";
	

	$sel_valor_inicial = query_db($sel_valor_inicial_sq);
	while($v_ini = traer_fila_db($sel_valor_inicial)){//se selecciona el valor ingresado en la creacion de los contratos pero sin los contratos
		$contratos="";
		$contratista="";
		if($numero_solicitud==""){//como es un solo numero se llena la variable una ves para no cargar el sistema
		$numero_solicitud=numero_item_pecc($v_ini[6], $v_ini[7], $v_ini[8]);
		}
		
		$sel_contratos = query_db("select consecutivo,creacion_sistema,apellido,contratista from vista_reporte_saldos_marco_2_crea_inicial where id_item = $id_solicitud group by consecutivo, creacion_sistema, apellido, contratista");
		$cont = 0;
		while($s_contras = traer_fila_db($sel_contratos)){//se seleccionan los contratos creados en la creacion
		
		
		if($contratos_que_viene==numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2])){
				$num_contra_while="<font color=#0000FF>".numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2])."</font>";
			}else{
				$num_contra_while=numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2]);
				}
			
		 if($cont == 0){
		  	$clase= "";
			$cont = 1;
		  }else{
		  	$clase= "class=filas_resultados";
			$cont = 0;
		  }
		
				if($contratos==""){
				$contratos.="<span >".$num_contra_while."</span>";
				$contratista.="<span >".substr($s_contras[3],0,47)."</span>";
				}else{
					$contratos.=",<br /><span $clase>".$num_contra_while."</span>";
					$contratista.=",<br /><span $clase>".substr($s_contras[3],0,47)."</span>";
					}
		}
		
		
		
		$insert = query_db("insert into t2_reporte_marco_temporal (id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo,t2_presupuesto_id,num_item,contratista) values (".$_SESSION["id_us_session"].", 'inicial', $id_solicitud, '$contratos','".$v_ini[1]."','".$v_ini[2]."','".$v_ini[4]."','".$v_ini[5]."','".$v_ini[3]."','".$v_ini[0]."','".$numero_solicitud."','".$contratista."')");
		
		}
	/*Inicial*/
	
	
	/*Ampliaciones*/
	$numero_solicitud="";
	$sel_valor_inicial_sq = "select t2_presupuesto_id, ano,campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item from vista_reporte_saldos_marco_3_ampliaciones where id_item_peec_aplica = $id_solicitud group by t2_presupuesto_id, ano, campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item";
	
	$sel_valor_inicial = query_db($sel_valor_inicial_sq);
	while($v_ini = traer_fila_db($sel_valor_inicial)){//se selecciona el valor ingresado en la ampliacion
		$contratos="";
		$contratista="";

		$numero_solicitud=numero_item_pecc($v_ini[6], $v_ini[7], $v_ini[8]);

		
	
		
		$sel_contratos = query_db("select consecutivo,creacion_sistema,apellido,contratista from vista_reporte_saldos_marco_3_ampliaciones where t2_presupuesto_id = ".$v_ini[0]." group by consecutivo, creacion_sistema, apellido, contratista");
		$cont = 0;
		while($s_contras = traer_fila_db($sel_contratos)){//se seleccionan los contratos relacionados por presupuesto
		
		if($contratos_que_viene==numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2])){
				$num_contra_while="<font color=#0000FF>".numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2])."</font>";
			}else{
				$num_contra_while=numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2]);
				}
				
				
				if($cont == 0){
		  	$clase= "class=filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
				
				if($contratos==""){
				$contratos.="<span >".$num_contra_while."</span>";
				$contratista.="<span >".$s_contras[3]."</span>";
				}else{
					$contratos.=",<br /><span >".$num_contra_while."</span>";
					$contratista.=",<br /><span >".$s_contras[3]."</span>";
					}
		}
		
		
		
		$insert = query_db("insert into t2_reporte_marco_temporal (id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo,t2_presupuesto_id,num_item,contratista) values (".$_SESSION["id_us_session"].", 'ampliacion', ".$v_ini[9].", '$contratos','".$v_ini[1]."','".$v_ini[2]."','".$v_ini[4]."','".$v_ini[5]."','".$v_ini[3]."','".$v_ini[0]."','".$numero_solicitud."','".$contratista."')");
		
		}
	
	
	/*Ampliaciones*/
	
	
	/*OTS*/
	$numero_solicitud="";
	$sel_valor_inicial_sq = "select t2_presupuesto_id, ano,campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item,id_item_ots_aplica from vista_reporte_saldos_marco_4_ots where id_item_peec_aplica = $id_solicitud group by t2_presupuesto_id, ano, campo,t1_campo_id,valor_usd,valor_cop, num1, num2, num3, id_item,id_item_ots_aplica";
	
	$sel_valor_inicial = query_db($sel_valor_inicial_sq);
	while($v_ini = traer_fila_db($sel_valor_inicial)){//se selecciona el valor ingresado en la ampliacion
		$contratos="";
		$contratista="";

		$numero_solicitud=numero_item_pecc($v_ini[6], $v_ini[7], $v_ini[8]);

		
	
		
		$sel_contratos = query_db("select consecutivo,creacion_sistema,apellido,contratista from vista_reporte_saldos_marco_4_ots where t2_presupuesto_id = ".$v_ini[0]." group by consecutivo, creacion_sistema, apellido, contratista");
		while($s_contras = traer_fila_db($sel_contratos)){//se seleccionan los contratos relacionados por presupuesto
				if($contratos==""){
				$contratos.=numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2]);
				$contratista.=substr($s_contras[3], 0, 47);
				}else{
					$contratos.=",<br />".numero_item_pecc_contrato_antes_formato("C",$s_contras[1],$s_contras[0],$s_contras[2]);
					$contratista.=",<br />".substr($s_contras[3],0,47);
					}
		}
		
		
		
		$insert = query_db("insert into t2_reporte_marco_temporal (id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo,t2_presupuesto_id,num_item,contratista,id_item_ots_aplica) values (".$_SESSION["id_us_session"].", 'ots', ".$v_ini[9].", '$contratos','".$v_ini[1]."','".$v_ini[2]."','".$v_ini[4]."','".$v_ini[5]."','".$v_ini[3]."','".$v_ini[0]."','".$numero_solicitud."','".$contratista."','".$v_ini[10]."')");
		
		}
	
	
	/*OTS*/
	
	
	
	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />

<body>


  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
<tr>
  <td width="93%" align="center">&nbsp;</td>
  <td width="7%" align="right"><input type="button" value="Cerrar" class="boton_grabar_cancelar windowPopupClose" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="none"' /></td>
</tr>
<tr>
  <td colspan="2" align="center">&nbsp;</td>
</tr>
<tr>
  <td colspan="2" align="center">
  
  
  <table width="100%" border="1" cellpadding="0" cellspacing="0" class="tabla_lista_resultados">
  
  <?
  
  $cuantos_solicitudes="select num_item,tipo,id_item from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion') group by num_item,tipo,id_item order by id_item asc";
  

  

  $sel_cuantos=query_db($cuantos_solicitudes);
  $cuantos =0;
  while($sel_temp = traer_fila_db($sel_cuantos)){
	   $cuantos =$cuantos+1;
  }
  
  $sel_temporal_sql="select num_item,tipo,id_item from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and tipo in ('inicial', 'ampliacion') group by num_item,tipo,id_item order by id_item asc";
  

  

  $sel_temporal=query_db($sel_temporal_sql);
  $consecutivo=0;
  while($sel_temp = traer_fila_db($sel_temporal)){
	  
	  $sel_item_masivo= traer_fila_row(query_db("select de_historico from t2_item_pecc where id_item = ".$sel_temp[2]));
	  
	  
	  $consecutivo=$consecutivo+1;
	$titulo="";
  $titulo2="";
	
	  if($sel_temp[1]=="inicial"){	  
	  $titulo = "Solicitud Inicial - ".$sel_temp[0];
	  $titulo2= "<strong>SOLICITUD INICIAL - ".$sel_temp[0]."</strong>";
	  }
	  if($sel_temp[1]=="ampliacion"){	  
	  $titulo = "Ampliaci&oacute;n - ".$sel_temp[0];
	  $titulo2= "<strong>SOLICITUD AMPLIACION - ".$sel_temp[0]."</strong>";
	  }
	  
	 $cuanta_cuantos_registros=traer_fila_row(query_db("select count(*) from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]));
	 
	 
	 $convina_rowspan_columna_1=$cuanta_cuantos_registros[0];////la columna donde estan los numeros de la solucitud
  
  ?>
    <tr class="fondo_3">
      <td colspan="2" width="18%" align="center"><strong onclick="expande_reporte(<?=$consecutivo?>,<?=$cuantos?>)"><?=$titulo?> </strong></td>
      <td width="5%" align="center">Contrato</td>
      <td width="29%" align="center">Contratista</td>
      <td width="3%" align="center">A&ntilde;o</td>
      <td width="17%" align="center">Area / Proyecto</td>
      <td width="7%" align="center">USD</td>
      <td width="9%" align="center">COP</td>
      <td width="8%" align="center">Equivalente USD</td>
      <td width="4%" align="center">TRM</td>

      </tr>
      
      
      <?
      $selecciona_valores = query_db("select  id_reporte, id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo, t2_presupuesto_id, num_item, CAST (contratista as text), id_item_ots_aplica from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]);
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
      <?
      if($sel_item_masivo[0]<>""){echo "Carga Masiva";}
	  ?>
      </td>
      <?
      if($sel_temp[1]=="inicial"){//si es iniicial
	  ?>
      <td id="fila_8-<?=$consecutivo?>"  rowspan="<?=$convina_rowspan_columna_1?>" align="center"><?=$s_valores[4]?></td>
      <td id="fila_9-<?=$consecutivo?>" rowspan="<?=$convina_rowspan_columna_1?>" align="center"><?=$s_valores[12]?></td>
      <?
	  }else{
		  ?><td align="center"><?=$s_valores[4]?></td><td align="center"><?=$s_valores[12]?></td><? //si es el primero pero no es inicial debe imprimir la columna de los contratos sin rowspan
		  }
	}else{ if($sel_temp[1]<>"inicial"){?><td align="center"><?=$s_valores[4]?></td><td><?=$s_valores[12]?></td><? }}//si no es el primero debe imprimir la columna de los contratos sin rowspan
	
	
	if($s_valores[5]==2013){
	$trm=1780;
	}else{
		$trm=1900;
		}
	
	$valor_equivalente = 0;
	
	$valor_equivalente = $s_valores[7] + ($s_valores[8]/$trm);
	
	$valor_usd_t=$s_valores[7]+$valor_usd_t;
	$valor_cop_t=$valor_cop_t+$s_valores[8];
	$valor_eqi_t=$valor_equivalente+$valor_eqi_t;
	
	  ?>
      
      

      
      <td align="center"><?=$s_valores[5]?></td>
      <td align="center"><?=$s_valores[6]?></td>
      <td align="center"><?=number_format($s_valores[7],0)?></td>
      <td align="center"><?=number_format($s_valores[8],0)?></td>
      <td align="center"><?=number_format($valor_equivalente,2)?></td>
      <td align="center"><?=number_format($trm,0)?></td>
    </tr>
    
    <?
	  }
	?>
    
    
     <?
      $selecciona_valores = query_db("select  ano, sum(usd), sum(cop) from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]." group by ano");
	  $es_el_primero = 0;
	  
	  $valor_usd_t=0;
	$valor_cop_t=0;
	$valor_eqi_t=0;
	  
	  while($s_valores = traer_fila_db($selecciona_valores)){
	  ?>
    <tr class="estilo_reporte_fondo_griz" id="fila_6-<?=$consecutivo?>" >
    
    
      

      
		<td colspan="4" align="right" class="">Valor Total de la Solcitud por A&ntilde;o:</td>
<? 
	
	
	if($s_valores[0]==2013){
	$trm=1780;
	}else{
		$trm=1900;
		}
	
	$valor_equivalente = 0;
	
	$valor_equivalente = $s_valores[1] + ($s_valores[2]/$trm);
	
	
	
	  ?>
      
      

      
      <td align="center"><?=$s_valores[0]?></td>
      <td align="center">&nbsp;</td>
      <td align="center"><?=number_format($s_valores[1],0)?></td>
      <td align="center"><?=number_format($s_valores[2],0)?></td>
      <td align="center"><?=number_format($valor_equivalente,2)?></td>
      <td align="center"><?=number_format($trm,0)?></td>
    </tr>
    
    <?
	  }
	?>
    
    
    
    <tr>
      <td colspan="11" height="1" class="estilo_reporte_fondo_amarillo"></td>
      </tr>
      <tr class="estilo_reporte_fondo_amarillo" id="fila_2-<?=$consecutivo?>" >
    
    
      

      
	<td colspan="10" align="center" class="estilo_reporte_fondo_amarillo">Ejecuci&oacute;n por Ordenes de Trabajo</td>
    </tr>
      
      <?
	  
	 $comple_sql ="";
	 $item_para_row_espan="";
	 	$valor_usd_t_ot=0;
	$valor_cop_t_ot=0;
	$valor_eqi_t_ot=0;
	 if($sel_temp[1]=="inicial"){//si es iniicial trae las relaciones en 0
	 
	 $comple_sql =" and id_item_ots_aplica=0";
	 }else{
		 $comple_sql =" and id_item_ots_aplica=".$sel_temp[2];
		 }
	  
	 
	   $cuenta_para_rowspan = traer_fila_row(query_db("select count(*) from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."'  and tipo = 'ots' ".$comple_sql));
	   
      $selecciona_valores = query_db("select * from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."'  and tipo = 'ots' ".$comple_sql);
	  $es_el_primero = 0;
	  
	  while($s_valores = traer_fila_db($selecciona_valores)){
		  
		  
		  $cuenta_para_rowspan_num_ot = traer_fila_row(query_db("select count(*) from t2_reporte_marco_temporal where id_item = ".$s_valores[3]));
		  
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
      <td  rowspan="<?=$cuenta_para_rowspan[0]?>" align="center" class="estilo_reporte_fondo_amarillo">Ordenes de Trabajo</td>
      <?
	  }
	  $row_num_ot="";
	  if($item_para_row_espan<>$s_valores[3]){
		  $item_para_row_espan=$s_valores[3];
		   $row_num_ot='<td  rowspan="'.$cuenta_para_rowspan_num_ot[0].'">OT - '.$s_valores[11].' </td>';
		   $row_num_ot.='<td  rowspan="'.$cuenta_para_rowspan_num_ot[0].'">'.$num_contra_while.' </td>';
		   $row_num_ot.='<td  rowspan="'.$cuenta_para_rowspan_num_ot[0].'">'.$s_valores[12].' </td>';
		  }else{
			 //$row_num_ot="<td>".$s_valores[11]."</td>"; 
			  }
		  
		  echo $row_num_ot;
		  
		  
		  if($s_valores[5]==2013){
	$trm=1780;
	}else{
		$trm=1900;
		}
	
	$valor_equivalente = 0;
	
	$valor_equivalente = $s_valores[7] + ($s_valores[8]/$trm);
	
		
	$valor_usd_t_ot=$s_valores[7]+$valor_usd_t_ot;
	$valor_cop_t_ot=$valor_cop_t_ot+$s_valores[8];
	$valor_eqi_t_ot=$valor_equivalente+$valor_eqi_t_ot;
	  
	  ?>
      


      <td ><?=$s_valores[5]?></td>
      <td><?=$s_valores[6]?></td>
      <td><?=number_format($s_valores[7],0)?></td>
      <td><?=number_format($s_valores[8],0)?></td>
      <td><?=number_format($valor_equivalente,2)?></td>
      <td><?=number_format($trm,0)?></td>

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
    
    
    <tr>
      <td colspan="11" height="1" class="estilo_reporte_fondo_amarillo"></td>
      </tr>
      
       <?
	   //$selecciona_valores = query_db("select * from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."'  and tipo = 'ots' ".$comple_sql);
	  
		if($sel_temp[1]=="inicial"){//si es iniicial trae las relaciones en 0
	 
	 $comple_sql =" and id_item_ots_aplica=0";
	 }else{
		 $comple_sql =" and id_item_ots_aplica=".$sel_temp[2];
		 }

      $selecciona_valores = query_db("select  ano, sum(usd), sum(cop) from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and tipo = 'ots' ".$comple_sql." group by ano");
	  $es_el_primero = 0;
	  
	  $valor_usd_t=0;
	$valor_cop_t=0;
	$valor_eqi_t=0;
	  
	  while($s_valores = traer_fila_db($selecciona_valores)){
	  ?>
    <tr class="estilo_reporte_fondo_amarillo" id="fila_5-<?=$consecutivo?>"  >
    
    
      

      
		<td colspan="4" align="right" class="estilo_reporte_fondo_amarillo">Valor Total de las Ordenes de Trabajo por A&ntilde;o:</td>
<? 
	
	
	if($s_valores[0]==2013){
	$trm=1780;
	}else{
		$trm=1900;
		}
	
	$valor_equivalente = 0;
	
	$valor_equivalente = $s_valores[1] + ($s_valores[2]/$trm);
	
	
	
	  ?>
      
      

      
      <td align="center" class="estilo_reporte_fondo_amarillo"><?=$s_valores[0]?></td>
      <td align="center" class="estilo_reporte_fondo_amarillo">&nbsp;</td>
      <td align="center" class="estilo_reporte_fondo_amarillo"><?=number_format($s_valores[1],0)?></td>
      <td align="center" class="estilo_reporte_fondo_amarillo"><?=number_format($s_valores[2],0)?></td>
      <td align="center" class="estilo_reporte_fondo_amarillo"><?=number_format($valor_equivalente,2)?></td>
      <td align="center" class="estilo_reporte_fondo_amarillo"><?=number_format($trm,0)?></td>
    </tr>
    
    <?
	  }
	?>
      
      
      
      <tr>
      <td colspan="11" height="1" class="estilo_reporte_fondo_rojo"></td>
      </tr>
      
    
    
    <?
      $selecciona_valores = query_db("select  id_reporte, id_us, tipo, id_item, contratos, ano, campo, usd, cop, id_campo, t2_presupuesto_id, num_item, CAST (contratista as text), id_item_ots_aplica from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and id_item = ".$sel_temp[2]);
	  $es_el_primero = 0;
	  
	  $valor_usd_t=0;
	$valor_cop_t=0;
	$valor_eqi_t=0;
	  
	  while($s_valores = traer_fila_db($selecciona_valores)){
	  ?>
    <tr id="fila_4-<?=$consecutivo?>" >
    
    <?
	if($es_el_primero == 0){//es para imprimir o no la primera columna que tiene el rowspan
		$es_el_primero =1;
    ?>
      <td colspan="2" class="estilo_reporte_fondo_rojo" rowspan="<?=$convina_rowspan_columna_1?>" align="center">SALDO DISPONIBLE PARA CREAR ORDENES DE TRABAJO A LA SOLICITUD <?=$sel_temp[0]?></td>
      <?
      if($sel_temp[1]=="inicial"){//si es iniicial
	  ?>
      <td rowspan="<?=$convina_rowspan_columna_1?>" align="center"><?=$s_valores[4]?></td>
      <td rowspan="<?=$convina_rowspan_columna_1?>" align="center"><?=$s_valores[12]?></td>
      <?
	  }else{
		  ?><td align="center"><?=$s_valores[4]?></td><td align="center"><?=$s_valores[12]?></td><? //si es el primero pero no es inicial debe imprimir la columna de los contratos sin rowspan
		  }
	}else{ if($sel_temp[1]<>"inicial"){?><td align="center"><?=$s_valores[4]?></td><td><?=$s_valores[12]?></td><? }}//si no es el primero debe imprimir la columna de los contratos sin rowspan
	
	
	if($s_valores[5]==2013){
	$trm=1780;
	}else{
		$trm=1900;
		}
	
	$valor_equivalente = 0;
	
	
	if($sel_temp[1]=="inicial"){//si es iniicial trae las relaciones en 0
	 
	 $comple_sql =" and id_item_ots_aplica=0";
	 }else{
		 $comple_sql =" and id_item_ots_aplica=".$sel_temp[2];
		 }

$query="select  sum(usd), sum(cop) from t2_reporte_marco_temporal where id_us= '".$_SESSION["id_us_session"]."' and tipo = 'ots' and ano =  '".$s_valores[5]."' and id_campo = '".$s_valores[9]."'".$comple_sql." ";

      $selecciona_valores_ots = traer_fila_row(query_db($query));
	  
	
	$saldo_val_us = 0;
	$saldo_val_cop = 0;
	
	
	$saldo_val_us = $s_valores[7]-$selecciona_valores_ots[0];
	$saldo_val_cop = $s_valores[8]-$selecciona_valores_ots[1];
	
	$valor_equivalente = $saldo_val_us + ($saldo_val_cop/$trm);
	

	  ?>
      
      

      
      <td align="center"><?=$s_valores[5]?></td>
      <td align="center"><?=$s_valores[6]?></td>
      <td align="center"><?=number_format($saldo_val_us,0)?></td>
      <td align="center"><?=number_format($saldo_val_cop,0)?></td>
      <td align="center"><?=number_format($valor_equivalente,2)?></td>
      <td align="center"><?=number_format($trm,0)?></td>
    </tr>
    
    <?
	  }
	?>  
    
    
    
    <tr>
      <td colspan="11" height="1" class="estilo_reporte_fondo_rojo"></td>
      </tr>
    <?
  }//fin while principal temporal
	?>
    
  </table></td>
</tr>
<tr>
  <td colspan="2" align="center">&nbsp;</td>
</tr>
<tr>
  <td align="center">&nbsp;</td>
  <td align="right"><input type="button" value="Cerrar" class="boton_grabar_cancelar windowPopupClose" onclick='window.parent.document.getElementById(&quot;div_carga_busca_sol&quot;).style.display=&quot;none&quot;' /></td>
</tr>

</table>




</body>
</html>
