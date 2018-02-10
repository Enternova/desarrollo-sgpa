
<style>



body{ margin-bottom:10px; margin-top:50px}

.ancho_logo{ width: 10%; text-align:right; vertical-align:top}
.celdas_encabesado{width: 90%; }
.line_encabezado{width: 100%; border-top:solid 1px #999}
.tabla_principal{width: 100%; border: solid 0px #000; alignment-adjust:central}
.celda_completa_izquierda{ width: 100%; text-align:right}
.celdas_largas{width: 100%; }
.celda_completa_proyectos{ width: 100%; font-size:14px; border-bottom:solid  1px #999;}
.celda_completa_cate_grupo { width: 100%; font-size:12px; }
.celda_detalle_completa{ text-align:center; font-size:12px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#9FC2FD}
.celda_detalle_lista_completa{ font-size:10px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC; text-align:right}

.celda_detalle_lista_completa_detalle{ font-size:10px;BORDER-BOTTOM: #CCCCCC 1px double; background:#CCCCCC; text-align:right;
width: 300px;
float: left;
white-space: pre; /* CSS 2.0 */
white-space: pre-wrap; /* CSS 2.1 */
white-space: pre-line; /* CSS 3.0 */
white-space: -pre-wrap; /* Opera 4-6 */
white-space: -o-pre-wrap; /* Opera 7 */
white-space: -moz-pre-wrap; /* Mozilla */
white-space: -hp-pre-wrap; /* HP */
word-wrap: break-word; /* IE 5+ */
}
.celda_fin_proyecto{ text-align:center; width: 100%; font-size:12px; border-top: 1px dashed #ff9999; border-bottom: 1px dashed #ff9999; }

.celda_tarifa_no_incluida{font-size:11px;BORDER-BOTTOM: #CCCCCC 1px double;}

.celda_resultados_titulos{ width:80%; font-size:14px; border-bottom: solid 1px #C7422F ;}
.celda_resultados_respuesta{ width:20%; font-size:14px; border-bottom: solid 1px #C7422F ;}
.celda_firma{width:100%;font-size:14px; border-top:solid 2px #C7422F ; text-align:center}
.tabla_firma{width: 50%; border: solid 0px #000; alignment-adjust:central}
</style>

<? //include("../../../librerias/lib/@session.php"); 

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
		
		return $id_subastas_arrglo;
}

$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	


	
	
$busca_pre_temporal = "select t6_tarifas_proveedor_prefactura_id, consecutivo_contarto,nit, razon_social, CAST(objeto_contarto AS TEXT), editado, estado_tiquete,id_municipio,  nombre_municipio, consecutio_tiquete, fecha_ini, fecha_fin, fecha_creacion, ediciones, tipo_contrato, orden_trabajo from v_tarifas_tiquete_contarto_mucicipio where t6_tarifas_proveedor_prefactura_id = $id_prefactura";
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
			if($id_prefactura_general>=1){ //si ya selecciono una lista
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
    <td rowspan="3" class="ancho_logo"><img src="../../../logo_cliente_email.png" alt="logo" width="118" height="40" /></td>
    <td class="celdas_encabesado">'.$titulo.'</td>
  </tr>
  <tr>
    <td class="celdas_encabesado">Consecutivo: '.$consecutivo_tiquete.'</td>
  </tr>
  <tr>
    <td class="celdas_encabesado">'."Fecha del tiquete: ".fecha_for_hora($sql_busca_temporal_pre_fa[12]).'</td>
  </tr>
  <tr>
    <td colspan="2"  class="line_encabezado">&nbsp;</td>
  </tr>
</table>';

?>
<table class="tabla_principal">
  <tr>
    <td class="celda_completa_izquierda"><strong><?=$nombre_proveedor;?><br>NIT: <?=$nit_proveedor;?></strong></td>
  </tr>
</table>

<table class="tabla_principal">
  <tr>
    <td class="celdas_largas"><strong>Contrato:</strong><?=$consecutivo_contrato;?></td>
  </tr>
  <tr>
    <td class="celdas_largas"><strong>Objeto del Contrato...:</strong> <?=$objeto_contarto;?></td>
  </tr>
  <tr>
    <td class="celdas_largas"><strong>Rango de fechas del servicio prestado:</strong><?=$fecha_inicial.' al '.$fecha_final;?></td>
  </tr>
   <tr>
    <td class="celdas_largas"><strong>El contrato es tipo:</strong> <?  if($sql_busca_temporal_pre_fa[14]==1){ echo 'Marco | orden de trabajo:'.$sql_busca_temporal_pre_fa[15]; } else echo 'Puntual'; ?>
	</td>
  </tr> 
  <tr>
    <td class="celdas_largas"><strong>Municipio: <?=htmlEntities($municipio_pre_text);?></strong> </td>
  </tr>
</table>
    
  

<br />
<?  



$busca_detalle_tiquete = "select  t6_tarifas_lista_id, consecutivo_tarifa, t6_tarifas_proyectos_id, proyecto, categoria, grupo, detalle, cantidad, valor, nombre_moneda,fecha_inicio_vigencia,tarifa_padre,codigo_proveedor,fecha_fin_vigencia from v_tarifas_imprime_tiquete_detalle where t6_tarifas_proveedor_prefactura_id = $id_prefactura
order by t6_tarifas_proyectos_id, categoria, grupo, consecutivo_tarifa
";
$sql_ex = query_db($busca_detalle_tiquete);

	$proyecto_id = 0;
	$categoria_imprime = "--inicio_categoria--";
	$grupo_imprime = "--inicio_grupo--";
	$segmento_para_detalle = 0;
	$segmento_para_detalle_primera = 0;
	while($imprime_detalle = traer_fila_row($sql_ex)){//inicio detalles tiquete
	$detall_m_no_sel="";

  $busca_detalle_modi_sin = "select valor, fecha_inicio_vigencia from $v_t_3 where tarifas_contrato_id = $id_contrato_arr and categoria = '$imprime_detalle[4]' 
		and grupo = '$imprime_detalle[5]' and t6_tarifas_estados_tarifas_id in (1,7) and fecha_inicio_vigencia <= '$fecha_final' and tarifa_padre = $imprime_detalle[11] and 
		t6_tarifas_lista_id <> $imprime_detalle[0]";
		$sql_no_selecc_mo = query_db($busca_detalle_modi_sin);
		while($lis_modi_no_sell=traer_fila_row($sql_no_selecc_mo))
			$detall_m_no_sel.='<br>Valor: '.decimales_estilo($lis_modi_no_sell[0],2).' fecha de inicio de vigencia '.$lis_modi_no_sell[1]."";

			if($detall_m_no_sel!="")
			$crea_campo_columna_sin='<tr ><td colspan="8"  class="celda_tarifa_no_incluida" ><strong>Señor Gerente de Contrato, la tarifa relacionada en el tiquete ha tenido el siguiente histórico de modificaciones: </strong>'.$detall_m_no_sel.'</td></tr >';

		

		$proyecto_nombre = $imprime_detalle[3];
		
		
		if($proyecto_id!=$imprime_detalle[2] ){//segmento de los proyectos imprime un solo proyecto
		if($segmento_para_detalle_primera>=1){
			echo "</table><br>";
			$segmento_para_detalle_primera=0;
			
			}		
		if($proyecto_id>=1){
          ?>
          	<table class="tabla_principal">
			<tr>
              <td class="celda_fin_proyecto">FINAL DE TARIFAS PARA EL PROYECTO: <?=$imprime_detalle[3];?></td>
              
			</tr></table><br>
		<?
        }
		
		/************************imprime los proyectos******************************************/			
		?>
        	<table class="tabla_principal">
            <tr>
              <td class="celda_completa_proyectos"><strong>PROYECTO: <?=strtoupper($imprime_detalle[3]);?></strong></td>
            </tr>
          </table>
          <?
			$proyecto_id = $imprime_detalle[2]; // esto es para que no vuelva a imrimir el mismo proyecto 
			//$segmento_para_detalle=1;
			}//segmento de los proyectos imprime un solo proyecto			
		/************************imprime los proyectos******************************************/	

		
		/************************imprime las categoria******************************************/				
		$validacion_proy_cat_grupo = $proyecto_id.$imprime_detalle[4].$imprime_detalle[5];
	

		if( $validacion_proy_cat_grupo != $validacion_proy_cat_grupo_existe){//segmento de los proyectos imprime una sola categoria	
		if($segmento_para_detalle_primera>=1){
			echo "</table><br>";
			
			}
	
		 ?>
         	<table class="tabla_principal">
            <tr>
              <td class"celda_completa_cate_grupo">Categoria: <?=elimina_comillas_2_inv($imprime_detalle[4]).' | '.$imprime_detalle[5];?></td>
            </tr>
          </table>
          
          <?
		  		$validacion_proy_cat_grupo_existe = $proyecto_id.$imprime_detalle[4].$imprime_detalle[5];
				$categoria_imprime = $imprime_detalle[4];
				$grupo_imprime = $imprime_detalle[5];
				$segmento_para_detalle=1;
				?>
                <br />
               <table  class="tabla_principal">
               	<tr>
   		            <td style="width:8%" class="celda_detalle_completa">Consecutivo</td>
                    <td style="width:8%" class="celda_detalle_completa"><?=TITULO_5;?></td>
                   <td style="width:14%" class="celda_detalle_completa"><?=TITULO_6;?></td>
                      <td style="width:12%" class="celda_detalle_completa"><?=TITULO_8;?></td>
                      <td style="width:6%"  class="celda_detalle_completa">Vigencia</td>
					  <td style="width:6%"  class="celda_detalle_completa"><?=TITULO_18;?></td>                      
                      <td style="width:4%"  class="celda_detalle_completa">Cant.</td>
                      <td style="width:12%" class="celda_detalle_completa">Sub total</td>
                      <td style="width:14%" class="celda_detalle_completa">Cargo Contable</td>
				</tr>
            
                
                <?
		}//segmento de los proyectos imprime una sola categoria
		
		
		
		/************************imprime las categoria******************************************/					
		
		$sub_total = 0;
		$cantidad_item = 0;
		$cantidad_item= $imprime_detalle[7];
		$sub_total=($cantidad_item*number_format($imprime_detalle[8],5,".",""));
		$total+=$sub_total;
			if($imprime_detalle[13] == '0000-00-00')
			$fecha_fin_vi = '';
		else
			$fecha_fin_vi=$imprime_detalle[13];		
		
	?>
    
     	<tr >
              <td class="celda_detalle_lista_completa" align="center"><?=$imprime_detalle[1];?></td>
              <td class="celda_detalle_lista_completa" align="center"><?=$imprime_detalle[12];?></td>
              <td class="celda_detalle_lista_completa_detalle" align="left"><?=elimina_comillas_2_inv($imprime_detalle[6]);?></td>
              <td class="celda_detalle_lista_completa">$ <?=decimales_estilo($imprime_detalle[8],2).' '.$imprime_detalle[9];?></td>
              <td class="celda_detalle_lista_completa"><?=$imprime_detalle[10];?></td>
              <td class="celda_detalle_lista_completa"><?=$fecha_fin_vi;?></td>
              <td class="celda_detalle_lista_completa"><?=$imprime_detalle[7];?></td>
              <td class="celda_detalle_lista_completa">$ <?=decimales_estilo($sub_total,2).' '.$imprime_detalle[9];?></td>
              <td class="celda_detalle_lista_completa">&nbsp;</td>
            </tr>
            <?=$crea_campo_columna_sin;?>
    
    
    <?

		

			

		
		
		
		
		$segmento_para_detalle_primera++;
		}//inicio detalles tiquete

			echo "</table><br>";//sierra la tabla del ultimo registro
        } //si ya selecciono una lista

			$busca_descuento = traer_fila_row(query_db("select * from t6_tarifas_prefactura_descunetos_proveedor where t6_tarifas_proveedor_prefactura_id = $id_prefactura"));	
			$subtotal_menos_descuentos = ($total-$busca_descuento[2]);	
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
<table  class="tabla_principal">

        <tr>
          <td class="celda_resultados_titulos"><div align="right">SUB TOTAL DEL TIQUETE DE SERVICIOS:</div></td>
          <td class="celda_resultados_respuesta">$ <?=decimales_estilo($total,2);?></td>
        </tr>
        <tr>
          <td class="celda_resultados_titulos"><div align="right">- DESCUENTO:</div></td>
          <td class="celda_resultados_respuesta">$<?=decimales_estilo($busca_descuento[2],2);?></td>
        </tr>
  <tr>
          <td  class="celda_resultados_titulos" align="right">TOTAL DEL TIQUETE DE SERVICIOS:</td>
          <td  class="celda_resultados_respuesta">$<?=decimales_estandar($subtotal_menos_descuentos,2);?></td>
        </tr>
        
         </table>	
         
 <br />
     <p></p>

      <table  class="tabla_firma">

        <tr>
          <td class="celda_firma">Aprobado HOCOL SA</td>
        </tr>
      </table>
