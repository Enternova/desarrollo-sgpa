<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		


$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	
$busca_pre_temporal = "select * from $t16 where t6_tarifas_proveedor_prefactura_id = $id_prefactura";

$sql_busca_temporal_pre_fa=traer_fila_row(query_db($busca_pre_temporal));

	if($sql_busca_temporal_pre_fa[14]==2) $estado_perefactura_final="EDITADO";
	elseif($sql_busca_temporal_pre_fa[4]==2) $estado_perefactura_final = " BORRADOR ";
	elseif($sql_busca_temporal_pre_fa[4]==1) $estado_perefactura_final = " FIRME ";	

			if($sql_busca_temporal_pre_fa[13]>=1)
				$version = " V ".$sql_busca_temporal_pre_fa[13];
			else
								$version = "";
								
	$fecha_cre= explode("-",$sql_busca_temporal_pre_fa[2]);
	
	
$consecutivo_tiquete="PRE-".$sql_busca_temporal_pre_fa[5]."- ".$fecha_cre[0]." ".$version;

	$busca_contrato = "select tarifas_contrato_id, t1_moneda_id, nombre, t1_proveedor_id, nit, digito_verificacion, razon_social, consecutivo, valor, objeto_contarto, estado_proveedor, estado_contrato, nombre_estado_contarto, id_contrato, gerente, objeto, especialista, monto_usd, monto_cop, t1_tipo_documento_id, fecha_inicio, vigencia_mes, id_item from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));

$busca_aiu = traer_fila_row(query_db("select * from t6_tarifas_prefactura_aiu where t6_tarifas_proveedor_prefactura_id = $id_prefactura"));

$aiu_a=$busca_aiu[2];
$aiu_a_p=$busca_aiu[3];
$aiu_i=$busca_aiu[4];
$aiu_i_p=$busca_aiu[5];
$aiu_u=$busca_aiu[6];
$aiu_u_p=$busca_aiu[7];



			
			$id_prefactura_general=$sql_busca_temporal_pre_fa[0];
			if($id_prefactura_general>=1){ //si ya selecciono una lista
			$consecutivo_factura=$sql_busca_temporal_pre_fa[5];
			$municipio_pre=$sql_busca_temporal_pre_fa[6];
			$proyecto_pre=$sql_busca_temporal_pre_fa[7];
			$busca_municipio=traer_fila_row(query_db("select * from $t18 where t6_tarifas_municipios_id = $municipio_pre"));
			$municipio_pre_text = $busca_municipio[2];  
			 $busca_tarifa_tem="select rango_fecha_inicial, rango_fecha_final from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general order by t6_tarifas_proveedor_prefactura_detalle_id desc";
			$busca_tari_tem=traer_fila_row(query_db($busca_tarifa_tem));

			$busca_descuento = traer_fila_row(query_db("select * from $t21ta where t6_tarifas_proveedor_prefactura_id = $id_prefactura"));
			
			if(($busca_tari_tem[0]!="") && ($nueva_busqueda!=5) ){//si tiene tarifasa detalle
			$fecha_inicial=$busca_tari_tem[0];
			$fecha_final=$busca_tari_tem[1];
			}//si tiene tarifasa detalle
			
			
$text='';

 	$busca_proyectos="select * from $t19 where t6_tarifas_municipios_id = $municipio_pre order by proyecto";
	$sql_q=query_db($busca_proyectos);
	while($l_pro=traer_fila_row($sql_q)){
			$busca_proyecto = traer_fila_row(query_db("select * from $t20 where t6_tarifas_prefactira_id = $id_prefactura and t6_tarifas_proyectos_id = $l_pro[0]"));
			if($busca_proyecto[0]!=""){
			$crea_titulo_columna.='<td width="8%" bgcolor="#9FC2FD" style="height:20px;font-size:22px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC">Cantidad</td>';
			$lista_proyectos.=$l_pro[2].", ";
			}

				}

$conse_con = "Consecutivo del tiquete de servicio: ".$consecutivo_tiquete;
$estado_con = "Estado del tiquete de servicio: ".$estado_perefactura_final;

$text.='<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" >
  <tr>
    <td><div align="left"><strong>Contrato:</strong> '.$sql_con[7].'</div></td>
  </tr>
  <tr>
    <td class="letra-descuentos"><div align="left"><strong> '.$conse_con.'</strong></div></td>
  </tr>

  <tr>
    <td class="letra-descuentos"><div align="left"><strong> '.$estado_con.'</strong></div></td>
  </tr> 
    <tr>
    <td class="letra-descuentos"><div align="left"><strong> '.busca_tarifas_aiu($id_contrato_arr,2).'</strong></div></td>
  </tr> 
  <tr>
    <td  class="letra-descuentos"><div align="left"><strong>Rango de fechas del servicio prestado: '.$busca_tari_tem[0].' al '.$busca_tari_tem[1].'</strong></div></td>
  </tr>  
  <tr>
    <td "><div align="left"><strong>Objeto del Contrato:</strong> '.htmlentities($sql_con[9]).'</div></td>
  </tr>
  <tr>
    <td  "><div align="left"><strong>Municipio:</strong> '.htmlentities($municipio_pre_text).'</div></td>
  </tr>
  <tr>
    <td  "><div align="left"><strong>Proyecto:</strong>'.htmlentities($lista_proyectos).'</div></td>
  </tr>


</table>
<br />';			

 
 $busca_proyectos_tarifas = "select t6_tarifas_prefactura_proyectos_id, t6_tarifas_municipios_id, municipo, t6_tarifas_municipios_proyectos_id, proyecto, t6_tarifas_prefactira_id, total from v_tarifas_municipio_proyecto_prefactura_v2 where t6_tarifas_prefactira_id = $id_prefactura_general";
 $sql_proyectos_pre=query_db($busca_proyectos_tarifas);
 while($lista_proyectos_pre=traer_fila_row($sql_proyectos_pre)){//while para buscar proyectos de la prefactura e imprimir uno a uno
 
 $text.='<table width="98%" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td >PROYECTO: '.htmlentities(strtoupper($lista_proyectos_pre[4])).'</td>
            </tr>
          </table>';
//echo "select t6_tarifas_lista_id from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_prefactura_proyectos_id = ".$lista_proyectos_pre[0] ;
	 $busca_tarifa_tem_filtrar=query_db("select t6_tarifas_lista_id from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_prefactura_proyectos_id = ".$lista_proyectos_pre[0] );
			while($filtra_ca=traer_fila_row($busca_tarifa_tem_filtrar))
				$id_lista_trae.=$filtra_ca[0].",";

	 	$busca_categorias = "select distinct categoria from v_tarifas_relacion_tarifas_tarifas_detalle where tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_prefactura_proyectos_id =  $lista_proyectos_pre[0]";
		$sql_cate=query_db($busca_categorias);
		while($lista_categoria=traer_fila_row($sql_cate)){
			$categoria_imprime="";

   $text.='  <table width="98%" border="0" cellspacing="4" cellpadding="4">';
     	if(chop($lista_categoria[0])<>""){ 
        $categoria_imprime='<spam >Categoria: '.$lista_categoria[0].'</spam>';
            } 
        
       
        $text.='<tr>
          <td>';

	 	$busca_grupos = "select distinct grupo from v_tarifas_relacion_tarifas_tarifas_detalle where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' and t6_tarifas_prefactura_proyectos_id =  $lista_proyectos_pre[0] ";
		$sqlgrupo=query_db($busca_grupos);
		while($lista_grupos=traer_fila_row($sqlgrupo)){//grupos
		$grupos_imprime="";
$crea_campo_columna_sin="";
            if(chop($lista_grupos[0])<>""){ 
		           $grupos_imprime=' <spam ">Grupo: '.$lista_grupos[0].'</spam>';
            } 

           $text.=$categoria_imprime.' | '.$grupos_imprime;
          
			$text.=' <br><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_lista_resultados">';
   
            $text.='<tr class="fondo_3">
 			  <td width="3%">'.TITULO_CONSECUTIVO.'</td>
              <td width="33%" ><div align="center">Nombre generico del producto / servicio</div></td>
              <td width="12%" ><div align="center">Valor</div></td>
              <td width="6%" ><div align="center">Vigencia</div></td>
              
			  <td width="4%" ><div align="center">Cant.</div></td>

              <td width="12%" ><div align="center">Sub total</div></td>
              ';
              
			$text.='</tr>';
            

	 	$busca_detalle = "select t6_tarifas_lista_id, tarifas_contrato_id, categoria, grupo, codigo_proveedor, detalle, unidad_medida, cantidad, t1_moneda_id, valor, us_id, fecha_creacion, tipo_creacion, t6_tarifas_estados_tarifas_id, fecha_inicio_vigencia, tarifa_padre, nombre_estado_tarifa, descripcion, moneda, fecha_fin_vigencia, t6_tarifas_listas_lista_id, nombre, tipo_creacion_modifica, us_aprobacion_actual, creada_luego_firme,consecutivo_tarifa from $v_t_3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' and grupo = '$lista_grupos[0]' and t6_tarifas_estados_tarifas_id in (1,7) and fecha_inicio_vigencia <= '$fecha_final' order by tarifa_padre, fecha_creacion";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//detalle
		if($lista_detalle[12]==1) $tipo_creacion='<img src="../imagenes/botones/chulo.jpg" alt="se refiere a tarifas cargadas en el inicio del contrato" width="23" height="20" titel="se refiere a tarifas cargadas en el inicio del contrato" />';
		else $tipo_creacion='<img src="../imagenes/botones/alerta.png" width="16" height="16" title="se refiere a tarifas cargadas posteriormente del inicio del contrato" />';

		$cantidad="";
		$observa="";
		$sub_total=0;
	
	


	
	
$cantidad_item=0;
	
		$crea_campo_columna="";
		

				$class=" bgcolor=\"#CCCCCC\" ";

		
  //	$busca_proyectos="select * from $t19 where t6_tarifas_municipios_id = $municipio_pre order by proyecto";
//	$sql_q=query_db($busca_proyectos);
//	while($l_pro=traer_fila_row($sql_q)){
	//		$busca_proyecto = traer_fila_row(query_db("select * from $t20 where t6_tarifas_prefactira_id = $id_prefactura and t6_tarifas_proyectos_id = $l_pro[0]"));
		//	if($busca_proyecto[0]!=""){ $chequeado="checked";
	 		$cantidad="";
			$observa="";
			$detall_m_no_sel="";
	
					 $busca_tarifa_tem="select * from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_lista_id=$lista_detalle[0] and rango_fecha_inicial='$fecha_inicial' and rango_fecha_final='$fecha_final' and t6_tarifas_prefactura_proyectos_id = $lista_proyectos_pre[0]";
					$busca_tari_tem=traer_fila_row(query_db($busca_tarifa_tem));
					if($busca_tari_tem[5]>=0){//si tiene valores
							$cantidad+=$busca_tari_tem[5];
							$cantidad_item=$busca_tari_tem[5];
							$observa=$busca_tari_tem[10];
//cast(					
		
			$crea_campo_columna.='<td  '.$class.' >'.$cantidad.'</td>';
			

			
			} //si tiene valores
			//}
			
		
	if($cantidad_item>0){// si tiene valores
	
	$sub_total=($cantidad_item*number_format($lista_detalle[9],$cantidad_decimales,".",""));
	
	$total+=$sub_total;
	
	   $busca_detalle_modi_sin = "select valor, fecha_inicio_vigencia from $v_t_3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' 
		and grupo = '$lista_grupos[0]' and t6_tarifas_estados_tarifas_id in (1,7) and fecha_inicio_vigencia <= '$fecha_final' and tarifa_padre = $lista_detalle[15] and 
		t6_tarifas_lista_id not in ( select t6_tarifas_lista_id from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general  and rango_fecha_inicial='$fecha_inicial' 
		and rango_fecha_final='$fecha_final' and t6_tarifas_prefactura_proyectos_id = $lista_proyectos_pre[0])";
		
$crea_campo_columna_sin="";		
		$sql_no_selecc_mo = query_db($busca_detalle_modi_sin);
		while($lis_modi_no_sell=traer_fila_row($sql_no_selecc_mo))
			$detall_m_no_sel.=" <spam class='letra-descuentos' > Valor: ".decimales_estilo($lis_modi_no_sell[0],2)." fecha de inicio de vigencia ".$lis_modi_no_sell[1]."</spam> | ";
		
	if($detall_m_no_sel!="")
			$crea_campo_columna_sin='<tr ><td colspan="6" ><strong>Esta tarifa presenta  modificaciones en el rango de tiempo seleccionado y no hay sido incluida en el  tiquete de servicios:</strong></br> '.$detall_m_no_sel.'</td></tr >';

$detall_m_no_sel="";
	    
     $text.='  <tr >
		  	  <td '.$class.' >'.$lista_detalle[25].'</td>
              <td '.$class.' >'.$lista_detalle[5].'</td>
              <td  '.$class.' ><div align="right">$ '.decimales_estilo($lista_detalle[9],2).' '.$lista_detalle[18].'</div></td>
              <td  '.$class.' >'.$lista_detalle[14].'</td>';
              $text.=$crea_campo_columna;
              $text.='<td  '.$class.'  align="right">$ '.decimales_estilo($sub_total,2).' '.$lista_detalle[18].'</td>
            </tr>'.$crea_campo_columna_sin;



  $busca_observa= "select t6_tarifas_proveedor_prefactura_observaciones_id, detalle from t6_tarifas_proveedor_prefactura_observaciones where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_lista_id = $lista_detalle[0]";
			$bus_ob_ta_r=traer_fila_row(query_db($busca_observa));
			
			if($bus_ob_ta_r[0]>=1){
	   
	     $text.='  <tr >
              <td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Comentarios a la tarifa: <strong>'.htmlentities($bus_ob_ta_r[1]).'</strong></td>
            </tr>';
			}           
		   } // si tiene valores
		    }//detalle

	$num_fila++;} //while para buscar proyectos de la prefactura e imprimir uno a uno			
	
            $text.='<BR><tr>
              <td  colspan="6" style="  border-top: 1px dashed #ff9999; border-bottom: 1px dashed #ff9999; " align="CENTER">FINAL DE TARIFAS PARA EL PROYECTO: '.htmlentities(strtoupper($lista_proyectos_pre[4])).'</td>
              
			</tr>';

			
		 $busca_detalle = "select t6_tarifas_lista_id, tarifas_contrato_id, categoria, grupo, codigo_proveedor, detalle, unidad_medida, cantidad, t1_moneda_id, valor, us_id, fecha_creacion, tipo_creacion, t6_tarifas_estados_tarifas_id, fecha_inicio_vigencia, tarifa_padre, nombre_estado_tarifa, descripcion, moneda, fecha_fin_vigencia, t6_tarifas_listas_lista_id, nombre, tipo_creacion_modifica, us_aprobacion_actual, creada_luego_firme from $v_t_3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' and grupo = '$lista_grupos[0]' and t6_tarifas_estados_tarifas_id in (7) and fecha_fin_vigencia >= '$fecha_inicial'  order by fecha_creacion desc";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//detalle
		if($lista_detalle[12]==1) $tipo_creacion='<img src="../imagenes/botones/chulo.jpg" alt="se refiere a tarifas cargadas en el inicio del contrato" width="23" height="20" titel="se refiere a tarifas cargadas en el inicio del contrato" />';
		else $tipo_creacion='<img src="../imagenes/botones/alerta.png" width="16" height="16" title="se refiere a tarifas cargadas posteriormente del inicio del contrato" />';
	 		$cantidad="";
		$observa="";
		$sub_total=0;
	
	
		$cantidad_item=0;
	
		$crea_campo_columna="";
	

		
  	$busca_proyectos="select * from $t19 where t6_tarifas_municipios_id = $municipio_pre order by proyecto";
	$sql_q=query_db($busca_proyectos);
	while($l_pro=traer_fila_row($sql_q)){
			$busca_proyecto = traer_fila_row(query_db("select * from $t20 where t6_tarifas_prefactira_id = $id_prefactura and t6_tarifas_proyectos_id = $l_pro[0]"));
			if($busca_proyecto[0]!=""){ $chequeado="checked";
	 		$cantidad="";
			$observa="";
	
					 $busca_tarifa_tem="select * from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_lista_id=$lista_detalle[0] and rango_fecha_inicial='$fecha_inicial' and rango_fecha_final='$fecha_final' and t6_tarifas_prefactura_proyectos_id = $busca_proyecto[0]";
					$busca_tari_tem=traer_fila_row(query_db($busca_tarifa_tem));
					$cantidad+=$busca_tari_tem[5];
					$cantidad_item+=$busca_tari_tem[5];
					$observa=$busca_tari_tem[10];
		
					
		
			$crea_campo_columna.='<td  '.$class.' >'.$cantidad.'</td>';
			}
			}
			
		
	if($cantidad_item>=0){// si tiene valores
	
	$sub_total=($cantidad_item*$lista_detalle[9]);
	
	$total+=$sub_total;
	

	    
     $text.='  <tr >
              <td '.$class.' style="font-size:20px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.htmlentities($lista_detalle[5]).'</td>
              <td  '.$class.' style="font-size:20px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC"><div align="right">$ '.decimales_estilo($lista_detalle[9],2).' '.$lista_detalle[18].'</div></td>
              <td  '.$class.' style="font-size:20px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC">'.$lista_detalle[14].'</td>';
              $text.=$crea_campo_columna;
              $text.='<td  '.$class.' style="font-size:20px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC" align="right">$ '.decimales_estilo($sub_total,2).' '.$lista_detalle[18].'</td>
            </tr>';
           $num_fila++;
		   } // si tiene valores
		    }//detalle
          $text.='</table>
            <br />';
           }//grupos 
          
          $text.='</td>
        </tr>
      </table>

      ';
        } 

     $text.=' <table width="98%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td class="titulos_secciones" "><strong>Observaciones del descuento:</strong> ';
		   if ($busca_descuento[3]!="") $text.= htmlentities($busca_descuento[3]);
		    else $text.=' Sin comentarios';
			$text.='</td>
        </tr>
      </table>';

     

$text.='<table width="100%" border="0" cellspacing="2" cellpadding="2">

        <tr>
          <td width="80%" class="titulos_secciones"><div align="right">SUB TOTAL DEL TIQUETE DE SERVICIOS:</div></td>
          <td align="right" width="20%" class="titulos_secciones">$'.decimales_estilo($total,2).'</td>
        </tr>
        <tr>
          <td class="titulos_secciones"><div align="right">- DESCUENTO:</div></td>
          <td align="right" class="titulos_secciones">$'.decimales_estilo($busca_descuento[2],2).'</td>
        </tr>';
	        
			$subtotal_menos_descuentos = ($total-$busca_descuento[2]);
			
			 if( ($aiu_a==1) || ($aiu_a==2) ) {
			 
			 if($aiu_a==1) $op_a= "+";
			 if($aiu_a==2) $op_a= "-";
			 
			 $porcentaje_a = ($subtotal_menos_descuentos*$aiu_a_p)/100; 
			 $total_admini = $op_a.$porcentaje_a;
			
                     $text.='<tr>
                      <td class="titulos_secciones"><div align="right">'.$op_a.' ADMINISTRACION('.$aiu_a_p.'%):</div></td>
                      <td align="right" class="titulos_secciones">$'.decimales_estilo($porcentaje_a,2).'</td>
                    </tr>';
			 }
			 
		 if( ($aiu_i==1) || ($aiu_i==2) ) {
			 
			 if($aiu_i==1) $op_i= "+";
			 if($aiu_i==2) $op_i= "-";
			 
			 $porcentaje_i = ($subtotal_menos_descuentos*$aiu_i_p)/100; 
			 $total_impr = $op_i.$porcentaje_i;
			  $text.='<tr>
                      <td class="titulos_secciones"><div align="right">'.$op_i.' IMPREVISTOS('.$aiu_i_p.'%):</div></td>
                      <td align="right" class="titulos_secciones">$'.decimales_estilo($porcentaje_i,2).'</td>
                    </tr>';

			 
			 }
			 
		 if( ($aiu_u==1) || ($aiu_u==2) ) {
			 
			 if($aiu_u==1) $op_u= "+";
			 if($aiu_u==2) $op_u= "-";
			 
			 $porcentaje_u = ($subtotal_menos_descuentos*$aiu_u_p)/100; 
			 $total_utilidad = $op_u.$porcentaje_u;
			  $text.='<tr>
                      <td class="titulos_secciones"><div align="right">'.$op_u.' UTILIDAD('.$aiu_u_p.'%):</div></td>
                      <td align="right" class="titulos_secciones">$'.decimales_estilo($porcentaje_u,2).'</td>
                    </tr>';
			 
			 }				 			 
      

        
        
        $text.='<tr>
          <td  class="titulos_secciones" align="right">TOTAL DEL TIQUETE DE SERVICIOS:</td>
          <td align="right" class="titulos_secciones">$'.decimales_estilo(($subtotal_menos_descuentos+$total_admini+$total_impr+$total_utilidad),2).'</td>
        </tr>
        
        <tr>
          <td class="titulos_secciones">&nbsp;</td>
          <td class="titulos_secciones">&nbsp;</td>
        </tr>
      </table>	 ';
	  
	  
	 
	 

        $text.=' </p></p></p></p></p>';

    
        } //si ya selecciono una lista
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="91%" class="titulos_secciones">SECCION:<span class="titulos_resaltado_procesos"> CONTRATO:
      <?=$sql_con[7];?>
    </span></span>&gt;&gt;  VISTA PREVIA DE TIQUETE DE SERVICIO</td>
    <td width="9%" class="titulos_secciones">
<? 
if ($sql_busca_temporal_pre_fa[4]==1){ ?>
    <input type="button" name="button5" class="boton_volver" id="button5" value="Volver al historico" onclick="ajax_carga('../aplicaciones/tarifas/proveedor/h_prefactura.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas')" />
<? } else { ?>
    <input type="button" name="button6" class="boton_volver" id="button6" value="Volver al tiquete de servicio" onclick="ajax_carga('../aplicaciones/tarifas/proveedor/e_prefactura.php?id_contrato=<?=$id_contrato;?>&id_prefactura=<?=$id_prefactura;?>','carga_acciones_permitidas');" /></td>
<? } ?>
  </tr>
</table>

<br />
 <?=busca_tarifas_aiu($id_contrato_arr,2);?>
<?
	echo $text;
?>
</p>
<p>&nbsp;</p>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
<? 

if($sql_busca_temporal_pre_fa[4]==1  and $sql_busca_temporal_pre_fa[14]==1){ ?>
            <td width="30%"><div align="center"><input name="button" type="button" class="boton_email" id="button" value="Exportar tiquete de servicio en firme a PDF" onclick="window.open('../enterproc/librerias/tcpdf/examples/exporta_prefactura.php?id_contrato=<?=$id_contrato;?>&id_prefactura=<?=$id_prefactura;?>')" /> 
            </div></td>
            <td width="33%"><input name="button2" type="button" class="boton_edicion" id="button2" value="        Editar tiquete de servicio    " onclick="edita_pre_en_firme(<?=$sql_busca_temporal_pre_fa[0];?>)" /></td>


<? }  

 if($sql_busca_temporal_pre_fa[4] == 1 and $sql_busca_temporal_pre_fa[14]==2){  echo '<div align="center" class="letra-descuentos">"ESTE TIQUETE NO SE PUEDE IMPRIMIR EN PDF PORQUE FUE EDITADO, POR LO TANTO YA NO ES VALIDO." </div>'; } ?>
          </tr>
        </table>

  <input type="hidden" name="pre_edita" id="pre_edita" />
  <input type="hidden" name="t6_tarifas_reembolables_datos_detalle_id" id="t6_tarifas_reembolables_datos_detalle_id" />
  <input type="hidden" name="id_contrato" value="<?=$id_contrato;?>" />
  
          
</body>
</html>
