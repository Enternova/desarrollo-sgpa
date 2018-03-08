<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("proveedores.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));
	
$busca_pre_temporal = "select * from $t16 where t6_tarifas_proveedor_prefactura_id = $id_prefactura";
$sql_busca_temporal_pre_fa=traer_fila_row(query_db($busca_pre_temporal));

$busca_aiu = traer_fila_row(query_db("select * from t6_tarifas_prefactura_aiu where t6_tarifas_proveedor_prefactura_id = $id_prefactura"));

$aiu_a=$busca_aiu[2];
$aiu_a_p=$busca_aiu[3];
$aiu_i=$busca_aiu[4];
$aiu_i_p=$busca_aiu[5];
$aiu_u=$busca_aiu[6];
$aiu_u_p=$busca_aiu[7];
	
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

<?


$buscar_lista = traer_fila_row(query_db("select * from $t12 where t6_tarifas_listas_lista_id = $lista_existentes"));

			
			$id_prefactura_general=$sql_busca_temporal_pre_fa[0];
			if($id_prefactura_general>=1){ //si ya selecciono una lista
			$consecutivo_factura=$sql_busca_temporal_pre_fa[5];
			$municipio_pre=$sql_busca_temporal_pre_fa[6];
				$busca_municipio=traer_fila_row(query_db("select * from $t18 where t6_tarifas_municipios_id = $municipio_pre"));
			$municipio_pre_text = $busca_municipio[2];  
			$proyecto_pre=$sql_busca_temporal_pre_fa[7];
			 $busca_tarifa_tem="select rango_fecha_inicial, rango_fecha_final from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general order by t6_tarifas_proveedor_prefactura_detalle_id desc";
			$busca_tari_tem=traer_fila_row(query_db($busca_tarifa_tem));
			
			$busca_descuento = traer_fila_row(query_db("select * from $t21ta where t6_tarifas_proveedor_prefactura_id = $id_prefactura"));
			
			if(($busca_tari_tem[0]!="") && ($nueva_busqueda!=5) ){//si tiene tarifasa detalle
			$fecha_inicial=$busca_tari_tem[0];
			$fecha_final=$busca_tari_tem[1];
			}//si tiene tarifasa detalle

		
	  	$busca_proyectos="select * from $t19 where t6_tarifas_municipios_id = $municipio_pre order by proyecto";
	$sql_q=query_db($busca_proyectos);
	while($l_pro=traer_fila_row($sql_q)){
			$busca_proyecto = traer_fila_row(query_db("select * from $t20 where t6_tarifas_prefactira_id = $id_prefactura and t6_tarifas_proyectos_id = $l_pro[0]"));
			if($busca_proyecto[0]!=""){
			$crea_titulo_columna.="<td class='fondo_3' width='5%'>Cantidad</td>";
			$lista_proyectos.=$l_pro[2].", ";
			}

				}		


?>

<br />

<br />
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="4" class="fondo_2_sub">Datos basicos del tiquete de servicio</td>
  </tr>
  <tr>
    <td><div align="right"><strong>Consecutivo del tiquete de servicio:</strong></div></td>
    <td width="23%">PRE - <?=$id_prefactura_general;?></td>
    <td width="22%">&nbsp;</td>
    <td width="25%">&nbsp;</td>
  </tr>
  <tr>
    <td width="30%"><div align="right"><strong>Municipio:</strong></div></td>
    <td colspan="3"><?=$municipio_pre_text;?>      <div align="right"></div></td>
  </tr>
  <tr>
    <td><div align="right"><strong>Proyecto:</strong></div></td>
    <td colspan="3"><?=$lista_proyectos;?></td>
  </tr>
</table>
<br />

<?
 




 		 $busca_tarifa_tem_filtrar=query_db("select t6_tarifas_lista_id from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general  ");
			while($filtra_ca=traer_fila_row($busca_tarifa_tem_filtrar))
				$id_lista_trae.=$filtra_ca[0].",";
 
	$busca_categorias = "select distinct categoria from $t3 where tarifas_contrato_id = $id_contrato_arr and t6_tarifas_estados_tarifas_id in (1) and  t6_tarifas_lista_id in ($id_lista_trae 0) ";
		$sql_cate=query_db($busca_categorias);
		while($lista_categoria=traer_fila_row($sql_cate)){
	 
	 ?> 
      
      <table width="100%" border="0" cellspacing="2" cellpadding="2">
     	<? if(chop($lista_categoria[0])<>""){ ?>
        <tr>
          <td>
          
          	<table width="99%" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td class="titulos_secciones"><?=$lista_categoria[0];?></td>
            </tr>
          </table></td>
        </tr>
            <? } ?>        
        
        <tr>
          <td>

     <?
	 	$busca_grupos = "select distinct grupo from $t3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' and t6_tarifas_estados_tarifas_id in (1) and  t6_tarifas_lista_id in ($id_lista_trae 0) ";
		$sqlgrupo=query_db($busca_grupos);
		while($lista_grupos=traer_fila_row($sqlgrupo)){//grupos



	
	 ?> 
          
          <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
           <? if(chop($lista_grupos[0])<>""){ ?>
            <tr >
              <td colspan="6" class="fondo_4">GRUPO: <?=$lista_grupos[0];?></td>
            </tr>
            <? } ?>
            <tr>
              <td width="32%" class="fondo_3"><div align="center">Nombre generico del producto / servicio</div></td>
              <td width="5%" class="fondo_3"><div align="center">Unidad </div></td>
              <td width="12%" class="fondo_3"><div align="center">Valor</div></td>
              <td width="9%" class="fondo_3"><div align="center">Inicio vigencia</div></td>
              <?=$crea_titulo_columna;?>
              <td width="13%" class="fondo_3"><div align="center">Sub total</div></td>
            </tr>
            
                 <?
	 	$busca_detalle = "select * from $v_t_3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' and grupo = '$lista_grupos[0]' and t6_tarifas_estados_tarifas_id in (1) and fecha_inicio_vigencia <= '$fecha_final'  order by fecha_creacion desc";
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
		
					
		
			$crea_campo_columna.="<td >".$cantidad."</td>";
			}
			}
			
		
	if($cantidad_item>=1){// si tiene valores
	
	$sub_total=($cantidad_item*$lista_detalle[9]);
	$total+=$sub_total;
	 ?> 
            
            <tr class="filas_resultados">
              <td><?=$lista_detalle[5];?></td>
              <td><div align="center"><?=$lista_detalle[6];?></div></td>
              <td class="titulos_resumen_alertas"><div align="right">$ <?=number_format($lista_detalle[9],0);?> 
                <?=$lista_detalle[18];?>
              </div></td>
              <td class="titulos_resumen_alertas"><?=$lista_detalle[14];?></td>
              <?=$crea_campo_columna;?>
              <td class="titulos_resumen_alertas">$ <?=number_format($sub_total,0);?> <?=$lista_detalle[18];?></td>
            </tr>
           <?
		   } // si tiene valores
		    }//detalle ?>

                 <?
		$busca_detalle = "select * from $v_t_3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' and grupo = '$lista_grupos[0]' and t6_tarifas_estados_tarifas_id in (7) and fecha_fin_vigencia >= '$fecha_inicial'  order by fecha_creacion desc";
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
		
					
		
			$crea_campo_columna.="<td >".$cantidad."</td>";
			}
			}
			
		
	if($cantidad_item>=1){// si tiene valores
	
	$sub_total=($cantidad_item*$lista_detalle[9]);
	$total+=$sub_total;
	 ?> 
            
            <tr class="filas_resultados">
              <td><?=$lista_detalle[5];?></td>
              <td><div align="center"><?=$lista_detalle[6];?></div></td>
              <td class="titulos_resumen_alertas"><div align="right">$ <?=number_format($lista_detalle[9],2);?> 
                <?=$lista_detalle[18];?>
              </div></td>
              <td class="titulos_resumen_alertas"><?=$lista_detalle[14];?></td>
              <?=$crea_campo_columna;?>
              <td class="titulos_resumen_alertas">$ <?=number_format($sub_total,0);?> <?=$lista_detalle[18];?></td>
             
            </tr>
           <? 
		   } // si tiene valores
		   }//detalle ?>           
          </table>
            <br />
          <? }//grupos ?>
          
          </td>
        </tr>
      </table>

      <p>
        <? } ?>

      <table width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td><span class="titulos_secciones">Observaciones del descuento: </span>            <? if ($busca_descuento[3]!="") echo $busca_descuento[3]; else echo "Sin comentarios"; ?></td>
        </tr>
      </table>
      <br />
      <br />
<table width="100%" border="0" cellspacing="2" cellpadding="2">

        <tr>
          <td width="96%" align="right" class="titulos_secciones">SUB TOTAL DEL TIQUETE DE SERVICIOS:</td>
          <td width="4%" align="right" class="titulos_secciones">$<?=number_format($total,0);?></td>
        </tr>
        <tr>
          <td class="titulos_secciones" align="right">- DESCUENTO:</td>
          <td align="right" class="titulos_secciones">$<?=number_format($busca_descuento[2],0);?></td>
        </tr>
	        <?
			$subtotal_menos_descuentos = ($total-$busca_descuento[2]);
			
			 if( ($aiu_a==1) || ($aiu_a==2) ) {
			 
			 if($aiu_a==1) $op_a= "+";
			 if($aiu_a==2) $op_a= "-";
			 
			 $porcentaje_a = ($subtotal_menos_descuentos*$aiu_a_p)/100; 
			 $total_admini = $op_a.$porcentaje_a;
			 ?>
                     <tr>
                      <td class="titulos_secciones" align="right"><?=$op_a;?> ADMINISTRACION(<?=$aiu_a_p;?>%):</td>
                      <td align="right" class="titulos_secciones">$<?=number_format($porcentaje_a,0);?></td>
                    </tr>
             <?
			 
			 }
			 
		 if( ($aiu_i==1) || ($aiu_i==2) ) {
			 
			 if($aiu_i==1) $op_i= "+";
			 if($aiu_i==2) $op_i= "-";
			 
			 $porcentaje_i = ($subtotal_menos_descuentos*$aiu_i_p)/100; 
			 $total_impr = $op_i.$porcentaje_i;
			 ?>
                     <tr>
                      <td class="titulos_secciones" align="right"><?=$op_i;?> IMPREVISTOS(<?=$aiu_i_p;?>%):</td>
                      <td align="right" class="titulos_secciones">$<?=number_format($porcentaje_i,0);?></td>
                    </tr>
             <?
			 
			 }
			 
		 if( ($aiu_u==1) || ($aiu_u==2) ) {
			 
			 if($aiu_u==1) $op_u= "+";
			 if($aiu_u==2) $op_u= "-";
			 
			 $porcentaje_u = ($subtotal_menos_descuentos*$aiu_u_p)/100; 
			 $total_utilidad = $op_u.$porcentaje_u;
			 ?>
                     <tr>
                      <td class="titulos_secciones" align="right"><?=$op_u;?> UTILIDAD(<?=$aiu_u_p;?>%):</td>
                      <td align="right" class="titulos_secciones">$<?=number_format($porcentaje_u,0);?></td>
                    </tr>
             <?
			 
			 }				 			 
?> 
        

        
        
        <tr>
          <td class="titulos_secciones" align="right">TOTAL DEL TIQUETE DE SERVICIOS:</td>
          <td align="right" class="titulos_secciones">$<?=number_format(($subtotal_menos_descuentos+$total_admini+$total_impr+$total_utilidad),0);?></td>
        </tr>
        
        <tr>
          <td class="titulos_secciones">&nbsp;</td>
          <td class="titulos_secciones">&nbsp;</td>
        </tr>
      </table>
<p>
          <? } //si ya selecciono una lista ?>
</p>
        <p>&nbsp;</p>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
<? if($sql_busca_temporal_pre_fa[4]==1){ ?>
            <td><div align="center"><input name="button" type="button" class="boton_email" id="button" value="Exportar tiquete de servicio en firme a PDF" onclick="window.open('../enterproc/librerias/tcpdf/examples/exporta_prefactura_en_firme.php?id_contrato=<?=$id_contrato;?>&id_prefactura=<?=$id_prefactura;?>')" /></div></td>
<? } elseif($sql_busca_temporal_pre_fa[4]==2){ ?>           
            <td><div align="center"><input name="button" type="button" class="boton_email" id="button" value="Exportar tiquete de servicio en borrador" onclick="window.open('../enterproc/librerias/tcpdf/examples/exporta_prefactura.php?id_contrato=<?=$id_contrato;?>&id_prefactura=<?=$id_prefactura;?>')" /></div></td>
<? } ?>            
          </tr>
        </table>
</body>
</html>
