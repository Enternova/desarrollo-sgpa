
<?

$text.='<table width="100%" border="0" cellpadding="2" cellspacing="2" >
  <tr>
    <td style="font-size:30px; "><div align="left"><strong>Contrato:</strong> '.$consecutivo_contrato.'</div></td>
  </tr>
  <tr>
    <td style="font-size:30px; "><div align="left"><strong>Objeto del Contrato:</strong> '.arr_caracteres_imprime($objeto_contarto).'</div></td>
  </tr>
  <tr>
    <td style="font-size:30px; "><div align="left"><strong>Rango de fechas del servicio prestado:</strong> '.$fecha_inicial.' al '.$fecha_final.'</div></td>
  </tr>
   <tr>
    <td style="font-size:30px; "><div align="left"><strong>El contrato es tipo:</strong>  '; if($sql_busca_temporal_pre_fa[14]==1){ $text.='Marco | orden de trabajo:'.$sql_busca_temporal_pre_fa[15]; } else $text.='Normal';
	$text.='</div></td>
  </tr> 
  <tr>
    <td style="font-size:30px; "><div align="left"><strong>Municipio: '.$municipio_pre_text.'</strong> </div></td>
  </tr>



</table>
<br />';			


$encamezado_detalle_text.=' <br><table width="100%" border="0" cellspacing="2" cellpadding="2">';
   
            $encamezado_detalle_text.='<tr>
              <td width="33%" bgcolor="#9FC2FD" style="height:20px;font-size:24px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Nombre generico del producto / servicio</div></td>
              <td width="12%" bgcolor="#9FC2FD" style="height:20px;font-size:24px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Valor</div></td>
              <td width="6%" bgcolor="#9FC2FD" style="height:20px;font-size:24px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Vigencia</div></td>
              
			  <td width="4%" bgcolor="#9FC2FD" style="height:20px;font-size:24px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Cant.</div></td>

              <td width="12%" bgcolor="#9FC2FD" style="height:20px;font-size:24px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Sub total</div></td>
              <td width="38%" bgcolor="#9FC2FD" style="height:20px;font-size:24px;BORDER-TOP: #CCCCCC 1px solid;BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#CCCCCC"><div align="center">Cargo Contable</div></td>';
              
			$encamezado_detalle_text.='</tr></table>';


$busca_detalle_tiquete = "select t6_tarifas_lista_id, consecutivo_tarifa, t6_tarifas_proyectos_id, proyecto, categoria, grupo from v_tarifas_imprime_tiquete_detalle where t6_tarifas_proveedor_prefactura_id = $id_prefactura
order by t6_tarifas_proyectos_id, categoria, grupo, consecutivo_tarifa
";
$sql_ex = query_db($busca_detalle_tiquete);

	$proyecto_id = 0;
	$categoria_imprime = "--inicio_categoria--";
	$grupo_imprime = "--inicio_grupo--";
	$segmento_para_detalle = 0;
	while($imprime_detalle = traer_fila_row($sql_ex)){//inicio detalles tiquete
		

		$proyecto_nombre = $imprime_detalle[3];
		
		
		if($proyecto_id!=$imprime_detalle[2] ){//segmento de los proyectos imprime un solo proyecto
		
		/************************imprime los proyectos******************************************/			
		 $text.='<table width="100%" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td style="font-size:34px; border-bottom-color:#C7422F 2px;"><strong>PROYECTO: '.strtoupper($imprime_detalle[3]).'</strong></td>
            </tr>
          </table>';
			$proyecto_id = $imprime_detalle[2]; // esto es para que no vuelva a imrimir el mismo proyecto 
			$segmento_para_detalle=1;
			}//segmento de los proyectos imprime un solo proyecto			
		/************************imprime los proyectos******************************************/	
		else $segmento_para_detalle=0;	
		
		/************************imprime las categoria******************************************/				
		if( ($categoria_imprime!=$imprime_detalle[4] ) && ($grupo_imprime!=$imprime_detalle[5] ) ){//segmento de los proyectos imprime una sola categoria	
		
		 $text.='<table width="100%" border="0" cellspacing="2" cellpadding="2">
            <tr>
              <td>Categoria: '.elimina_comillas_2_inv($imprime_detalle[4]).' | '.$imprime_detalle[5].'</td>
            </tr>
          </table>';
				$categoria_imprime = $imprime_detalle[4];
				$grupo_imprime = $imprime_detalle[5];
				$segmento_para_detalle=1;
		}//segmento de los proyectos imprime una sola categoria
		
		else{
				$categoria_imprime = "--inicio_categoria--";
				$grupo_imprime = "--inicio_grupo--";
				$segmento_para_detalle=0;
			}
		
		/************************imprime las categoria******************************************/					
		
	
		if($segmento_para_detalle==1){
		
			$text.= $encamezado_detalle_text	;
			
		}
		
			
			

		
		
		
		
		
		}//inicio detalles tiquete
