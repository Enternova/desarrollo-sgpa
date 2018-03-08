<? include("../../librerias/lib/@session.php"); 

	
	$id_proveedor = elimina_comillas(arreglo_recibe_variables($_GET["id_proveedor"]));	
	
	$Sel_proverdor = traer_fila_row(query_db("select * from t1_proveedor where t1_proveedor_id=".$id_proveedor));
	?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>
<p>&nbsp;</p>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="7"  class="titulos_secciones" align="center">Reporte de servicios menores del proveedor <br><?=$Sel_proverdor[3]?></td>
  </tr>
</table>
<br>
<table width="100%" border="0">
  <tr>
    <td width="50%" valign="top"><table width="90%" border="0" align="center" class="tabla_lista_resultados">
      <tr>
        <td colspan="5" align="center" class="fondo_3">Lista de Servicios Menores de Proveedor desde
          <?
            
			$fecha = date('Y-m-d');
			$nuevafecha = strtotime ( '-1 year' , strtotime ( $fecha ) ) ;
			$nuevafecha = date ( 'Y-m-d' , $nuevafecha );
			echo $nuevafecha;
			  ?></td>
      </tr>
      <tr class="fondo_3">
        <td width="16%" align="center">N&deg; Documento</td>
        <td width="14%" align="center">Fecha Documento</td>
        <td width="40%" align="center">Descripcion</td>
        <td width="18%" align="center">Monto USD $</td>
        <td width="12%" align="center">N&deg; SGPA</td>
      </tr>
      <?
	  
	  $fecha_menos_un_ano = strtotime ( '-1 year' , strtotime ( $fecha ) ) ; 
$fecha_menos_un_ano = date ( 'Y-m-j' , $fecha_menos_un_ano ); 


            $sel_ser_m = query_db("select doc_compra, fecha_doc, descripcion_pedido,  valor_usd, mat_proveedor from t2_servicios_menores_sap where id_proveedor = ".$id_proveedor." and estado =1 and Convert(char, fecha_doc, 103) >= Convert(char, '".$fecha_menos_un_ano."', 103)");
			while($s_s_m = traer_fila_db($sel_ser_m)){
				
			
			if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
			?>
      <tr  class="<?=$clase?>">
        <td align="center"><?=$s_s_m[0]?></td>
        <td><?=$s_s_m[1]?></td>
        <td><?=$s_s_m[2]?></td>
        <td><? echo number_format($s_s_m[3],2); $total_serv_men = $s_s_m[3] + $total_serv_men ?></td>
        <td><?=$s_s_m[4]?></td>
      </tr>
      <?
			}
			?>
      <tr>
        <td align="center">&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right" class="fondo_3">Total</td>
        <td class="fondo_3"><?=number_format($total_serv_men,2);?></td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="50%" rowspan="2" valign="top"><table width="90%" border="0" align="center" class="tabla_lista_resultados">
      <tr>
        <td colspan="6" align="center" class="fondo_3">Contratos del Proveedor</td>
      </tr>
      <tr class="fondo_3">
        <td width="19%" align="center">N&deg;Contrato</td>
        <td width="44%" align="center">Objeto</td>
        <td width="20%" align="center">Gerente del Contrato</td>
        <td width="20%" align="center">Fecha de Finalizaci&oacute;n</td>
        <td width="20%" align="center">Monto USD</td>
        <td width="17%" align="center">Monto COP</td>
      </tr>
      <?
            $sel_contra = query_db("select creacion_sistema, consecutivo, apellido, objeto, monto_usd, monto_cop, gerente, vigencia_mes, id  from t7_contratos_contrato where contratista = ".$id_proveedor." and estado not in (0) order by vigencia_mes desc");
			while($s_co = traer_fila_db($sel_contra)){
				
				$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
				$separa_fecha_crea = explode("-",$s_co[0]);//fecha_creacion
				$ano_contra = $separa_fecha_crea[0];					
				$numero_contrato2 = substr($ano_contra,2,2);
				$numero_contrato3 = $s_co[1];//consecutivo
				$numero_contrato4 = $s_co[2];//apellido
		
		 if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		
			?>
      <tr class="<?=$clase?>">
        <td align="center"><? echo numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $s_co[8]); ?></td>
        <td><?=$s_co[3]?></td>
        <td align="center"><? echo saca_nombre_lista($g1,$s_co[6],'nombre_administrador','us_id');?></td>
        <td align="center"><?=$s_co[7]?></td>
        <td align="center"><?=number_format($s_co[4], 0)?></td>
        <td align="center"><?=number_format($s_co[5], 0)?></td>
      </tr>
      <?
            }
			?>
    </table></td>
  </tr>
  <tr>
    <td valign="top"><table width="90%" border="0" align="center" class="tabla_lista_resultados">
      <tr>
        <td colspan="6" align="center" class="fondo_3">Servicios Menores se encuentran en SGPA sin aprobaci&oacute;n</td>
        </tr>
      <tr class="fondo_3">
        <td width="19%" align="center">N&deg; Solicitud</td>
        <td width="44%" align="center">Objeto Solicitud</td>
        <td width="20%" align="center">Solicitante</td>
        <td width="20%" align="center">Estado</td>
        <td width="20%" align="center">Monto USD</td>
        <td width="17%" align="center">Monto COP</td>
        </tr>
      <?
	 
            $sel_contra = query_db("select distinct  t1.id_item, t1.num1, t1.num2, t1.num3, t1.id_us, t1.objeto_solicitud, t1.estado  from t2_item_pecc as t1, t2_relacion_proveedor as t2 where t1.id_item = t2.id_item and t2.id_proveedor = ".$id_proveedor." and t2.estado = 1 and (t1.estado < =20 or t1.estado = 31) and t1.t1_tipo_proceso_id=16 and t1.id_item <> '".$_GET["id_item_pecc_actual"]."' order by t1.id_item desc");
			while($s_co = traer_fila_db($sel_contra)){
				
				$sele_presu = traer_fila_row(query_db("select sum(valor_usd),  sum(valor_cop) from t2_presupuesto where t2_item_pecc_id =  ".$s_co[0]." and permiso_o_adjudica = 1"));

					
		 if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		
		$total_usd = $total_usd + $sele_presu[0];
		$total_cop = $total_cop + $sele_presu[1];
			?>
      <tr class="<?=$clase?>">
        <td align="center"><? echo numero_item_pecc($s_co[1],$s_co[2],$s_co[3]); ?></td>
        <td><?=$s_co[5]?></td>
        <td align="center"><? echo saca_nombre_lista($g1,$s_co[4],'nombre_administrador','us_id');?></td>
        <td align="center"><? echo saca_nombre_lista("t2_nivel_servicio_actividades",$s_co[6],'nombre','t2_nivel_servicio_actividad_id');?></td>
        <td align="center"><?=number_format($sele_presu[0], 0)?></td>
        <td align="center"><?=number_format($sele_presu[1], 0)?></td>
        </tr>
      
      <?
            }
			?>
      <tr class="<?=$clase?>">
        <td align="center">&nbsp;</td>
        <td   class="fondo_3"colspan="3"><div align="right">Total</div></td>
        <td align="center"  class="fondo_3"><?=number_format($total_usd, 0)?></td>
        <td align="center"  class="fondo_3"><?=number_format($total_cop, 0)?></td>
        </tr>
    </table></td>
  </tr>
</table>
</body>
</html>
