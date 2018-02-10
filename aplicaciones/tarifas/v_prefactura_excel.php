<?
  header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
	header("Content-type: application/force-download");

	header("Content-Disposition: attachment; filename=Reporte de tarifas.xls"); 
	header("Content-Transfer-Encoding: binary");

include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");

function elimina_comillas_2_inv($valor){
		$id_subastas_arrglo = str_replace("'", "", $valor );
		$id_subastas_arrglo = str_replace('"', "", $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('/', "", $id_subastas_arrglo);
		$id_subastas_arrglo = str_replace('*', "", $id_subastas_arrglo);
		
		$id_subastas_arrglo = ereg_replace( "&aacute;", "á",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&Aacute;",  "Á",$id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&eacute;","é",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&Eacute;","É",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&iacute;","í",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace( "&Iacute;","Í",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("&oacute;", "ó",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("&Oacute;", "Ó",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("&uacute;", "ú",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("&Uacute;","Ú",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("&ntilde;","ñ",  $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("&Ntilde;","Ñ", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace("<","=", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace(">","=", $id_subastas_arrglo ); 		
		
		
		//$id_subastas_arrglo = ereg_replace("<","", $id_subastas_arrglo ); 		

		
		return $id_subastas_arrglo;
}

function arr_caracteres_imprime($valor){

$id_subastas_arrglo = str_replace("-", " - ",$valor); 
		
		return $id_subastas_arrglo;
}

$id_contrato_arr = elimina_comillas($id_contrato);

$busca_pre_temporal = "select t6_tarifas_proveedor_prefactura_id, consecutivo_contarto,nit, razon_social, objeto_contarto, editado, estado_tiquete,id_municipio,  nombre_municipio, consecutio_tiquete, fecha_ini, fecha_fin, fecha_creacion, ediciones, tipo_contrato, orden_trabajo from v_tarifas_tiquete_contarto_mucicipio where t6_tarifas_proveedor_prefactura_id = $id_prefactura";
$sql_busca_temporal_pre_fa=traer_fila_row(query_db($busca_pre_temporal));



	if($sql_busca_temporal_pre_fa[5]==2) $estado_perefactura_final="EDITADO";
	elseif($sql_busca_temporal_pre_fa[6]==2) $estado_perefactura_final = " BORRADOR ";
	elseif($sql_busca_temporal_pre_fa[6]==1) $estado_perefactura_final = " FIRME ";	

			if($sql_busca_temporal_pre_fa[13]>=1)
				$version = " V ".$sql_busca_temporal_pre_fa[13];
			else
								$version = "";
								
				$fecha_cre= explode("-",$sql_busca_temporal_pre_fa[12]);
				$consecutivo_tiquete="PRE- ".$sql_busca_temporal_pre_fa[9]." - ".$fecha_cre[0]." ".$version;

$titulo = "TIQUETE DE SERVICIO ".$estado_perefactura_final;





			
			$id_prefactura_general=$sql_busca_temporal_pre_fa[0];
			
			$consecutivo_factura=$sql_busca_temporal_pre_fa[9];
			$municipio_pre=$sql_busca_temporal_pre_fa[7];
			$municipio_pre_text = $sql_busca_temporal_pre_fa[8];  
			$fecha_inicial=$sql_busca_temporal_pre_fa[10];
			$fecha_final=$sql_busca_temporal_pre_fa[11];
			$nit_proveedor = $sql_busca_temporal_pre_fa[2];
			$nombre_proveedor = $sql_busca_temporal_pre_fa[3];
			$consecutivo_contrato = $sql_busca_temporal_pre_fa[1];
			$objeto_contarto = $sql_busca_temporal_pre_fa[4];


$encabezado_header='
<table class="tabla_principal">
    
  <tr>
    <td class="celdas_encabesado">Consecutivo: '.$consecutivo_tiquete.'</td>
  </tr>
  <tr>
    <td class="celdas_encabesado">Fecha del tiquete:'.fecha_for_hora($sql_busca_temporal_pre_fa[12]).'</td>
  </tr>
  <tr>
    <td colspan="2"  class="line_encabezado">&nbsp;</td>
  </tr>
</table>';
		
		
?>


<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<style>
.titulo1 {
	font-size:20px;
	color:#135798;
		
}
.titulo2 {
	font-size:16px;
		
}
.titulo3 {
	font-size:20px;
	background-color:#135798;
	color:#FFF;
		
}


</style>
</head>

<body>
<table border=1  width="100%" >                	
  <tr>
    <td height="107" colspan="3" align="center" valign="middle">&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
    <td colspan="8" align="left"><div class="titulo1"><strong><br />REPORTE DE TIQUETE DE SERVICIO</strong></div><br />Consecutivo: <?=$consecutivo_tiquete;?><br/>Fecha del tiquete:<?=fecha_for_hora($sql_busca_temporal_pre_fa[12]);?><br />Contrato:<?=$consecutivo_contrato;?><br /><strong>Objeto del Contrato:</strong><?=arr_caracteres_imprime($objeto_contarto);?><br /><strong>Rango de fechas del servicio prestado:</strong><?=$fecha_inicial.' al '.$fecha_final;?><br />El contrato es tipo:</strong> <?  if($sql_busca_temporal_pre_fa[14]==1){ echo 'Marco | orden de trabajo:'.$sql_busca_temporal_pre_fa[15]; } else echo 'Normal'; ?>    </td>
  </tr>

<tr >
  <td width="7%" align="center" class="titulo3"><strong>Numero de tiquete</strong></td>
  <td width="7%" align="center" class="titulo3"><strong>Proyecto</strong></td>
	<td width="16%" align="center" class="titulo3"><strong>
	  <?=TITULO_5;?>
	</strong></td>
	<td width="8%" align="center"class="titulo3" ><strong>
	  <?=TITULO_2;?>
	</strong></td>
	<td width="12%" align="center" class="titulo3"><strong>
	  <?=TITULO_CONSECUTIVO;?>
	</strong></td>
											  
    <td width="27%" align="center" class="titulo3"><div align="center"><strong>
      <?=TITULO_6;?>
    </strong></div></td>
    <td width="5%" align="center" class="titulo3"><div align="center"><strong>
      <?=TITULO_8;?>
    </strong></div></td>
    <td width="8%" align="center"  class="titulo3"><strong>
      <?=TITULO_9;?>
    </strong></td>
    <td width="8%" align="center"  class="titulo3"><strong>
      <?=TITULO_18;?>
    </strong></td>
    <td width="7%" align="center"  class="titulo3"><strong>Cantidad</strong></td>
    <td width="4%" align="center"  class="titulo3"><strong>Sub total</strong></td>

											</tr>

<?
	$busca_detalle_tiquete = "select t6_tarifas_lista_id, consecutivo_tarifa, t6_tarifas_proyectos_id, proyecto, categoria, grupo, detalle, cantidad, valor, nombre_moneda,fecha_inicio_vigencia,tarifa_padre, codigo_proveedor,fecha_fin_vigencia from v_tarifas_imprime_tiquete_detalle where t6_tarifas_proveedor_prefactura_id = $id_prefactura order by t6_tarifas_proyectos_id, categoria, grupo, consecutivo_tarifa";
	$sql_ex = query_db($busca_detalle_tiquete);

	$proyecto_id = 0;
	$categoria_imprime = "--inicio_categoria--";
	$grupo_imprime = "--inicio_grupo--";
	$segmento_para_detalle = 0;
	$segmento_para_detalle_primera = 0;
	while($imprime_detalle = traer_fila_row($sql_ex)){//inicio detalles tiquete
	$detall_m_no_sel="";
	
	
		
		$sub_total = 0;
		$cantidad_item = 0;
		$cantidad_item= $imprime_detalle[7];
		$sub_total=($cantidad_item*number_format($imprime_detalle[8],5,".",""));
		$total+=$sub_total;
	


		$valor_unido=0;
		$valor_arr = explode(".",$imprime_detalle[8]);
		$unidades =$valor_arr[0];
		$decimales =  $valor_arr[1];
		$valor_unido = $unidades.$formato_numeros_miles.$decimales;	
		
		$valor_unido_2=0;
		$valor_arr_2 = explode(".",$imprime_detalle[7]);
		$unidades_2 =$valor_arr_2[0];
		$decimales_2 =  $valor_arr_2[1];
		$valor_unido_2 = $unidades_2.$formato_numeros_miles.$decimales_2;			
	
		$valor_unido_3=0;
		$valor_arr_3 = explode(".",$sub_total);
		$unidades_3 =$valor_arr_3[0];
		$decimales_3 =  $valor_arr_3[1];
		$valor_unido_3 = $unidades_3.$formato_numeros_miles.$decimales_3;	
	
				if($imprime_detalle[13] == '0000-00-00')
			$fecha_fin_vi = '';
		else
			$fecha_fin_vi=$imprime_detalle[13];		
	
	?>
    
    <tr >
  <td width="7%" align="center"><?=$consecutivo_tiquete;?></td>
  <td width="7%" align="center"><?=strtoupper($imprime_detalle[3]);?></td>
	<td width="16%" align="center"><?=$imprime_detalle[12];?></td>
	<td width="8%" align="center"><strong><?=elimina_comillas_2_inv($imprime_detalle[4]).' | '.$imprime_detalle[5];?></strong></td>
	<td width="12%" align="center"><?=$imprime_detalle[1];?></td>
											  
    <td width="27%" align="center"><?=elimina_comillas_2_inv($imprime_detalle[6]);?></td>
    <td width="5%" align="center" style="<?=$stilo_excel;?>" ><div align="center"><?=$valor_unido;?></div></td>
    <td width="8%" align="center"><strong><?=$imprime_detalle[10];?></strong></td>
    <td width="8%" align="center"><?=$fecha_fin_vi;?></td>
    <td width="7%" align="center" style="<?=$stilo_excel;?>" ><?=$valor_unido_2;?></td>
    <td width="4%" align="center" style="<?=$stilo_excel;?>" ><?=$valor_unido_3;?></td>

											</tr>


    
    <?
	
	}


			$busca_descuento = traer_fila_row(query_db("select * from t6_tarifas_prefactura_descunetos_proveedor where t6_tarifas_proveedor_prefactura_id = $id_prefactura"));	
			$subtotal_menos_descuentos = ($total-$busca_descuento[2]);	
			
		$valor_unido_4=0;
		$valor_arr_4 = explode(".",$total);
		$unidades_4 =$valor_arr_4[0];
		$decimales_4 =  $valor_arr_4[1];
		$valor_unido_4 = $unidades_4.$formato_numeros_miles.$decimales_4;	
		
		$valor_unido_5=0;
		$valor_arr_5 = explode(".",$busca_descuento[2]);
		$unidades_5 =$valor_arr_5[0];
		$decimales_5 =  $valor_arr_5[1];
		$valor_unido_5 = $unidades_5.$formato_numeros_miles.$decimales_5;			
		$valida_des = number_format($valor_unido_5,5);
		if($valida_des>0)
			$valor_unido_5 = $valor_unido_5;
		else
			$valor_unido_5= 0;
				

		$valor_unido_6=0;
		$valor_arr_6 = explode(".",$subtotal_menos_descuentos);
		$unidades_6 =$valor_arr_6[0];
		$decimales_6 =  $valor_arr_6[1];
		$valor_unido_6 = $unidades_6.$formato_numeros_miles.$decimales_6;			


	?>

    <tr >
      <td colspan="10" align="right">&nbsp;</td>
      <td align="center"   style="<?=$stilo_excel;?>">&nbsp;</td>
    </tr>
    <tr >
      <td colspan="10" align="right">SUB TOTAL DEL TIQUETE DE SERVICIOS:</td>
      <td align="center"   style="<?=$stilo_excel;?>"><?=$valor_unido_4;?></td>
    </tr>
    <tr >
      <td colspan="10" align="right">- DESCUENTO:</td>
      <td align="center"   style="<?=$stilo_excel;?>"><?=$valor_unido_5;?></td>
  </tr>
    <tr >
      <td colspan="10" align="right"><span class="celda_resultados_titulos">TOTAL DEL TIQUETE DE SERVICIOS:</span></td>
      <td align="center"   style="<?=$stilo_excel;?>"><?=$valor_unido_6;?></td>
  </tr>
							
</table> 
<?

			
?>

<table  class="tabla_principal">
        <tr>
          <td  class="celdas_largas"><strong>Observaciones del descuento:</strong>
		 
         <?
		   if ($busca_descuento[3]!="") echo $busca_descuento[3];
		    else echo ' Sin comentarios';
			?>
		  </td>
        </tr>
</table>
									  
</body>
</html>