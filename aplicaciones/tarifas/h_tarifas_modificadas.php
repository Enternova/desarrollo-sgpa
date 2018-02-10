<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));	
$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>

							<table width="80%" border=0 align="right" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" >                	
								
				  <tr>
				    <th width="14%" class="fondo_6"><?=TITULO_CONSECUTIVO;?></th>
				    <th width="14%" class="fondo_6"><?=TITULO_12;?></th>
				    <th width="29%" class="fondo_6">Quien la Creo</th>
											<th width="12%" class="fondo_6"><div align="center"><?=TITULO_8;?></div></th>
											<th width="11%" class="fondo_6">Fecha de Creacion</th>
							    <th width="9%" class="fondo_6"><?=TITULO_9;?></th>
							    <th width="11%" class="fondo_6">Concepto</th>
							    <th width="14%" class="fondo_6">Fecha aprobaci&oacute;n</th>
									</tr>
<? 
 
 $nobre_categori_impri="";

	 	$busca_categorias = "";
		$nombre_gupo_imprime="";


	 	   // $busca_detalle = "select *  from $v_t_3 where tarifas_contrato_id = $id_contrato_arr  and tarifa_padre = $id_tarifa_padre and t6_tarifas_lista_id <> $id_tarifa_ac and t6_tarifas_estados_tarifas_id  in (1,7) order by t6_tarifas_lista_id desc";
$busca_detalle = "select *  from $v_t_3 where tarifas_contrato_id = $id_contrato_arr  and tarifa_padre = $id_tarifa_padre and t6_tarifas_estados_tarifas_id  in (1,7) order by t6_tarifas_lista_id desc";
			$sql_detalle=query_db($busca_detalle);
			while($lista_detalle=traer_fila_row($sql_detalle)){//todas las tarifas
		
if($lista_detalle[22]==1)
		{ $tipo_modifica="Original";
			$class_tipo="tarifas_normal";
		}	
		elseif($lista_detalle[22]==2)
		{ 			
		    $tipo_modifica="Actualizada";
			$class_tipo="tarifas_actualiza";
		}	


		elseif($lista_detalle[22]==3)
		{ 			
			$tipo_modifica="Creacion";
			$class_tipo="tarifas_creacion";
		}	
		

		elseif($lista_detalle[22]==4)
		{ 			
			$tipo_modifica="IPC";
			$class_tipo="tarifas_ipc";
		}	
		
	
				
$busca_aprobación_final = "SELECT fecha_aprobacion FROM t6_tarifas_aprobaciones where t6_tarifas_lista_id = $lista_detalle[0] ORDER BY t6_tarifas_aprobaciones_id DESC ";
$sql_aproba_fi = traer_fila_row(query_db($busca_aprobación_final));
						
			
	
           if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";
	 	
		$cuenta_tarifas_modificadas=traer_fila_row(query_db("select t6_tarifas_lista_id, nombre_estado_tarifa from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id <> $lista_detalle[15]  order by t6_tarifas_lista_id desc"));
	 	if($cuenta_tarifas_modificadas[0]>=1){//verifica si tienes otras tarifas creadas en esta tarifa
			$cuenta_tarifas_modificadas_nu=traer_fila_row(query_db("select count(*) from $v_t_3 where tarifa_padre = $lista_detalle[15] and t6_tarifas_lista_id <> $lista_detalle[15] "));	
			$estado_tarifa = $cuenta_tarifas_modificadas[1];
			$modificada = "SI (".$cuenta_tarifas_modificadas_nu[0].")";
		}
		else
		{//verifica si tienes NO otras tarifas creadas en esta tarifa
			$estado_tarifa = $lista_detalle[16];
			$modificada = "NO";
		}
		

	$ayuda_campo_editar="";
	$busca_atributos=query_db("select * from $t13 where t6_tarifas_listas_lista_id = $lista_existentes and estado = 1");
	while($lista_atr=traer_fila_row($busca_atributos)){//lista atributos
	$busca_valores = traer_fila_row(query_db("select * from $t14 where t6_tarifas_lista_id = $lista_detalle[0] and t6_tarifas_atributos_id = $lista_atr[0]"));
	$ayuda_campo_editar.='<td >'.$busca_valores[3].'</td>';
	
	} //lista atributos									
		
		
 ?> 

            <tr class="<?=$class;?>" >
              <td class="titulos_resumen_alertas"><div align="<?=alinea_CONSECUTIVO;?>"><?=$lista_detalle[28];?></div></td>
              <td class="titulos_resumen_alertas"><?
              if($id_tarifa_ac == $lista_detalle[0]) echo "Activa Actualmente"; else echo "Inactiva";
			  ?></td>
              <td class="titulos_resumen_alertas"><? echo traer_nombre_muestra($lista_detalle[10], $g1,"nombre_administrador","us_id")?></td>
              <td height="30" class="titulos_resumen_alertas"><div align="center"><?=decimales_estandar($lista_detalle[9],2);?>
              </div></td>
              <td class="titulos_resumen_alertas"><?=$lista_detalle[11];?></td>
              
              <td class="titulos_resumen_alertas"><?=$lista_detalle[14];?></td>
               <td class="titulos_resumen_alertas">
                    <div align="center" class="<?=$class_tipo;?>"><?=$tipo_modifica;?></div></td>
              <td class="titulos_resumen_alertas"><div align="center"><? echo $sql_aproba_fi[0];?></div></td>
            </tr>
            
            
	
           <? $num_fila++; 							
							
							
							
							
							
							
							
							
							
							
							
							
							
							$nombre_gupo_imprime=$lista_detalle[3];
							
							
							if($nombre_gupo_imprime!=$lista_detalle[3]){//si ya imprimio el grupo cierra tabla
							
							?> 
            
           </table> 
<p>
					    <?
							
							}//si ya imprimio el grupo cierra tabla
							
		
		}//todas las tarifas
 
 
 
     ?>
									  
<table width="100%">
     <tr  >
              <td width="88%" height="30" class="titulos_resumen_alertas">&nbsp;</td>
              <td width="12%" class="titulos_resumen_alertas">
              <input type="button" name="button2" class="boton_volver" id="button2" value="Cerrar atributos" onclick=" ajax_carga('../aplicaciones/tarifas/pagina_blanco.php','lisat_detalle_modificaciones_<?=$_GET["id_tarifa_ac"];?>')" />
              </td>
            </tr>
    </table>								  
</p>
		


</body>
</html>
