<? include("css_pdf_tarifas.php");


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
		$id_subastas_arrglo = ereg_replace("<","≤", $id_subastas_arrglo ); 
		$id_subastas_arrglo = ereg_replace(">","≥", $id_subastas_arrglo ); 		
		
		
		//$id_subastas_arrglo = ereg_replace("<","", $id_subastas_arrglo ); 		

		
		return $id_subastas_arrglo;
}

function arr_caracteres_imprime($valor){

$id_subastas_arrglo = str_replace("-", " - ",$valor); 
		
		return htmlentities($id_subastas_arrglo);
}
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
								
$consecutivo_tiquete="PRE- ".$sql_busca_temporal_pre_fa[5]." - ".$fecha_cre[0]." ".$version;

	$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
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
			
?>


			
<link href="css_pdf_tarifas.php" rel="stylesheet" type="text/css" />

<page backtop="22mm" backbottom="14mm" >
    <page_header><table  class="tabla_sub_lista_resultados_sin_bordes" >
  <tr>
    <td style="width:20%" ><img src="logo_imprime.jpg" alt="Logo" width="179" height="63" /></td>
    <td  style="width:39%"><strong>TIQUETE DE SERVICIO 
      <?=$estado_perefactura_final;?>
      </strong><br />
      <strong>Consecutivo</strong>:
    <?=$consecutivo_tiquete;?>
    <br />
    <strong>Fecha del tiquete</strong>:
    <?=fecha_for_hora($sql_busca_temporal_pre_fa[2]);?></td>
    <td  style="width:41%; text-align:right; vertical-align:top"><strong>
      <?=htmlentities($sql_con[6]).'<br>NIT: '.$sql_con[4];?>
    </strong><br /><br />
    Pagina [[page_cu]]/[[page_nb]]</td>
  </tr>
  <tr>
    <td colspan="3"class="columna_raya_titulo" >&nbsp;</td>
    </tr>
</table>

    </page_header>


<br />

<?
 	$busca_proyectos="select * from $t19 where t6_tarifas_municipios_id = $municipio_pre order by proyecto";
	$sql_q=query_db($busca_proyectos);
	while($l_pro=traer_fila_row($sql_q)){
			$busca_proyecto = traer_fila_row(query_db("select * from $t20 where t6_tarifas_prefactira_id = $id_prefactura and t6_tarifas_proyectos_id = $l_pro[0]"));
			if($busca_proyecto[0]!=""){
			$crea_titulo_columna.='<td width="8%" bgcolor="#9FC2FD" style="height:20px;font-size:22px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC">Cantidad</td>';
			$lista_proyectos.=htmlentities($l_pro[2]).", ";
			}

				}

?>

<table class="tabla_lista_resultados"  >
  <tr>
    <td class="css_colum_titulos">Contrato:</td>
    <td class="css_colum_titulos_resultados"><?=$sql_con[7];?></td>
  </tr>
  <tr>
    <td class="css_colum_titulos" >Objeto del Contrato:</td>
    <td class="css_colum_titulos_resultados"><?=arr_caracteres_imprime($sql_con[9]);?></td>
  </tr>
  <tr>
    <td class="css_colum_titulos" >Rango de fechas del servicio prestado:</td>
    <td class="css_colum_titulos_resultados"><?=$busca_tari_tem[0].' al '.$busca_tari_tem[1];?></td>
  </tr>
   <tr>
    <td class="css_colum_titulos" >El contrato es tipo:</td>
    <td class="css_colum_titulos_resultados"><?  if($sql_busca_temporal_pre_fa[15]==1){ echo 'Marco | orden de trabajo:'.$sql_busca_temporal_pre_fa[16]; } else echo 'Normal'; ?></td>
  </tr> 
  <tr>
    <td class="css_colum_titulos" >Municipio:</td>
    <td class="css_colum_titulos_resultados"><?=htmlentities($municipio_pre_text);?></td>
  </tr>
</table>
<br />

<?

			

 
 $busca_proyectos_tarifas = "select * from v_tarifas_municipio_proyecto_prefactura_v2 where t6_tarifas_prefactira_id = $id_prefactura_general";
 $sql_proyectos_pre=query_db($busca_proyectos_tarifas);
 while($lista_proyectos_pre=traer_fila_row($sql_proyectos_pre)){//while para buscar proyectos de la prefactura e imprimir uno a uno
 $id_lista_trae="";
 ?>
 <table  class="tabla_lista_resultados" >
<tr>
              <td class="columna_titulo_resultados">PROYECTO: <?=htmlentities(strtoupper($lista_proyectos_pre[4]));?></td>
            </tr>
          </table>
 <?

		$categoria_imprime="";		
		  
	 	$busca_categorias = "select distinct categoria from v_tarifas_relacion_tarifas_tarifas_detalle where tarifas_contrato_id = $id_contrato_arr  and t6_tarifas_prefactura_proyectos_id =  $lista_proyectos_pre[0]";
		$sql_cate=query_db($busca_categorias);
		while($lista_categoria=traer_fila_row($sql_cate)){//categoria
			$grupos_imprime="";
			?>
    <table  border="0" class="tabla_sub_lista_resultados_sin_bordes">
        <tr>
          <td class="tabla_sub_lista_resultados_sin_bordes"> <?

     	if(chop($lista_categoria[0])<>""){ 
        $categoria_imprime='<div style="font-size:18px;">Categoria: '.elimina_comillas_2_inv($lista_categoria[0]).'</div>';
            } 

	 	$busca_grupos = "select distinct grupo from v_tarifas_relacion_tarifas_tarifas_detalle where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' and t6_tarifas_prefactura_proyectos_id =  $lista_proyectos_pre[0] ";
		$sqlgrupo=query_db($busca_grupos);
		while($lista_grupos=traer_fila_row($sqlgrupo)){//grupos
		
            if(chop($lista_grupos[0])<>""){ 
		           $grupos_imprime=' <div style="font-size:18px; ">Grupo: '.elimina_comillas_2_inv($lista_grupos[0]).'</div>';
            } 

           $text.=$categoria_imprime.' | '.$grupos_imprime;
          ?>

<table class="tabla_sub_lista_resultados_sin_bordes" border="0" cellspacing="2" cellpadding="2">
   
    <tr>
              <td style="width:33%" class="columna_subtitulo_resultados" >Nombre generico del producto / servicio ..</td>
              <td style="width:17%;" class="columna_subtitulo_resultados" >Valor</td>
              <td style="width:6%"  class="columna_subtitulo_resultados" >Vigencia</td>
			  <td style="width:6%"  class="columna_subtitulo_resultados" >Cant.</td>
              <td style="width:25%;" class="columna_subtitulo_resultados" >Sub total</td>
              <td style="width:12%"  class="columna_subtitulo_resultados" >Cargo Contable</td>
              
		</tr>


<?


 	$busca_detalle = "select * from $v_t_3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' and grupo = '$lista_grupos[0]' and t6_tarifas_estados_tarifas_id in (1,7) and fecha_inicio_vigencia <= '$fecha_final'  order by tarifa_padre, fecha_creacion";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//detalle
		$cantidad="";
		$observa="";
		$sub_total=0;
		$cantidad_item=0;
		$crea_campo_columna="";
 		$cantidad="";
		$observa="";
		$detall_m_no_sel="";

		


	
					 $busca_tarifa_tem="select * from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_lista_id=$lista_detalle[0] and rango_fecha_inicial='$fecha_inicial' and rango_fecha_final='$fecha_final' and t6_tarifas_prefactura_proyectos_id = $lista_proyectos_pre[0]";
					$busca_tari_tem=traer_fila_row(query_db($busca_tarifa_tem));
					if($busca_tari_tem[5]>=0)
						{//si tiene valores
							$cantidad+=$busca_tari_tem[5];
							$cantidad_item=$busca_tari_tem[5];
							$observa=$busca_tari_tem[10];
							$crea_campo_columna.='<td  class="columna_lista_tarifas" style=" text-align:center" >'.$cantidad.'</td>';
						} //si tiene valores

			
		
	if($cantidad_item>0){// si tiene valores
	
//	$sub_total=($cantidad_item*number_format($lista_detalle[9],2,".",""));
	
	$sub_total=(number_format($cantidad_item,5,".","")*number_format($lista_detalle[9],5,".",""));

	
	$total+=$sub_total;

$crea_campo_columna_sin="";	
	
	   $busca_detalle_modi_sin = "select valor, fecha_inicio_vigencia from $v_t_3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$lista_categoria[0]' 
		and grupo = '$lista_grupos[0]' and t6_tarifas_estados_tarifas_id in (1,7) and fecha_inicio_vigencia <= '$fecha_final' and tarifa_padre = $lista_detalle[15] and 
		t6_tarifas_lista_id not in ( select t6_tarifas_lista_id from $t17 where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general  and rango_fecha_inicial='$fecha_inicial' 
		and rango_fecha_final='$fecha_final' and t6_tarifas_prefactura_proyectos_id = $lista_proyectos_pre[0])";
		$sql_no_selecc_mo = query_db($busca_detalle_modi_sin);
		while($lis_modi_no_sell=traer_fila_row($sql_no_selecc_mo))
			$detall_m_no_sel.='  Valor: '.number_format($lis_modi_no_sell[0],2).' fecha de inicio de vigencia '.$lis_modi_no_sell[1]." | ";
		
		if($detall_m_no_sel!="")
			$crea_campo_columna_sin='<tr ><td colspan="6" style="font-size:12px;BORDER-BOTTOM: #CCCCCC 1px double;" ><strong>Esta tarifa presenta  modificaciones en el rango de tiempo seleccionado y no hay sido incluida en el  tiquete de servicios:</strong>  '.$detall_m_no_sel.'</td></tr >';

	$detall_m_no_sel="";		
			
			?> <tr  >
              <td  class="columna_lista_tarifas" style="width:33%" ><?=elimina_comillas_2_inv($lista_detalle[5]);?></td>
              <td  class="columna_lista_tarifas" style=" text-align:right" >$<?=number_format($lista_detalle[9],2).' '.$lista_detalle[18];?></td>
              <td  class="columna_lista_tarifas"  ><?=$lista_detalle[14];?></td>
              <?=$crea_campo_columna;?>
              <td   class="columna_lista_tarifas"  style=" text-align:right">$<?=number_format($sub_total,2).' '.$lista_detalle[18];?></td>
              <td  class="columna_lista_tarifas"  ><?=htmlentities($observa);?></td>
            </tr>
            
            <? echo $crea_campo_columna_sin;
           $busca_observa= "select t6_tarifas_proveedor_prefactura_observaciones_id, detalle from t6_tarifas_proveedor_prefactura_observaciones where t6_tarifas_proveedor_prefactura_id = $id_prefactura_general and t6_tarifas_lista_id = $lista_detalle[0]";
			$bus_ob_ta_r=traer_fila_row(query_db($busca_observa));
			
			if($bus_ob_ta_r[0]>=1){ ?>
	   
	      <tr >
              <td colspan="6" style="font-size:12px;BORDER-BOTTOM: #CCCCCC 1px double; ">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Comentarios a la tarifa: <strong><?=htmlentities($bus_ob_ta_r[1]);?></strong></td>
        </tr>
			<? }
		   } // si tiene valores
		    }//detalle

	?>
		
          </table><br />
<?
		} //grupos

?>

          
          </td>
        </tr>
    </table>

      <?
        } // categoria
		
          ?>
          	 <table class="tabla_sub_lista_resultados_sin_bordes">
			<tr>
              <td  colspan="6" style=" font-size:10px; border-top: 1px dashed #ff9999; border-bottom: 1px dashed #ff9999;  " >FINAL DE TARIFAS PARA EL PROYECTO: <?=htmlentities($lista_proyectos_pre[4]);?></td>
              
			</tr></table><br>
            <?
		

$num_fila++; }//while para buscar proyectos de la prefactura e imprimir uno a uno

?>
</page>
<page pageset="old">


  <table  class="tabla_sub_lista_resultados_sin_bordes">
        <tr>
          <td width="80%" class="css_colum_titulos"><strong>Observaciones del descuento:</strong></td>
          <td width="20%" class="css_colum_titulos_resultados"><?
           if ($busca_descuento[3]!="") echo htmlentities($busca_descuento[3]);
		    else $text_pie.=' Sin comentarios';
			?></td>
        </tr>
      </table>
<br />
<table class="tabla_sub_lista_resultados_sin_bordes">

        <tr>
          <td style="width:80%" class="css_colum_titulos">SUB TOTAL DEL TIQUETE DE SERVICIOS:</td>
          <td style="width:20%" class="css_colum_titulos_resultados">$<?=number_format($total,2);?></td>
        </tr>
        <tr>
          <td class="css_colum_titulos">- DESCUENTO:</td>
          <td class="css_colum_titulos_resultados">$<?=number_format($busca_descuento[2],2);?></td>
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
                      <td class="css_colum_titulos"><? echo $op_a.' ADMINISTRACION('.$aiu_a_p;?>%):</td>
                      <td class="css_colum_titulos_resultados">$<?=number_format($porcentaje_a,2);?></td>
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
                      <td class="css_colum_titulos"><? echo $op_i.' IMPREVISTOS('.$aiu_i_p;?>%):</td>
                      <td class="css_colum_titulos_resultados">$<? echo number_format($porcentaje_i,2);?></td>
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
                      <td class="css_colum_titulos"><? echo $op_u.' UTILIDAD('.$aiu_u_p;?>%):</td>
                      <td class="css_colum_titulos_resultados">$<? echo number_format($porcentaje_u,2);?></td>
                    </tr>
			 
			 <? }				 			 
      

        
        
       ?>
       	<tr>
          <td  class="css_colum_titulos">TOTAL DEL TIQUETE DE SERVICIOS:</td>
          <td class="css_colum_titulos_resultados">$<? echo number_format(($subtotal_menos_descuentos+number_format($total_admini,2,".","")+number_format($total_impr,2,".","")+number_format($total_utilidad,2,".","")),2);?></td>
        </tr>
        
        <tr>
          <td class="titulos_secciones">&nbsp;</td>
          <td class="titulos_secciones">&nbsp;</td>
        </tr>
  </table>	 
	  
	  
	 
	 <br /><br /><br /><br /><br /><br /><br />

        

  <table style="width:50%;" border="0" cellspacing="2" cellpadding="2" align="center">

        <tr>
          <td style="font-size:14px; border-top-color:#C7422F 2px;"><div align="center">Aprobado HOCOL SA.. </div></td>
        </tr>
  </table>
   
  
</page>
  <?
   
        } //si ya selecciono una lista

$texto=$text;
$texto_pie=$text_pie;


?>

