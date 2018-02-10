<? include("../../librerias/lib/@session.php"); 
	//verifica_menu("administracion.html");
	//header('Content-Type: text/xml; charset=ISO-8859-1');

	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));

	?>
    
    <style>
.columna_subtitulo_resultados_oscuro{ height:20px;font-size:14px; color:#FFF; 
 BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#666 }
 .tabla_lista_resultados{  margin:1px;
  BORDER-BOTTOM: #cccccc 3px double; BORDER-RIGHT: #cccccc 3px  double; BORDER-TOP: #cccccc 1px solid;  	BORDER-LEFT: #cccccc 1px solid; 
  border-spacing:2px;
  overflow:scroll;
  cursor:pointer;
 }
 .xl65
	{
	mso-style-parent:style0;
	mso-number-format:"\@";
	}
</style>
<style>
.titulo1 {
	font-size:24px;
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
    
    
<table width="100%" border="1" align="center"  class="tabla_lista_resultados">
<tr >
  <td colspan="2" rowspan="3" align="center" >&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
  <td colspan="9" align="left" class="titulo1"><strong>REPORTE VALOR ADJUDICACION</strong></td>
</tr>
  <tr>
    <td colspan="11"><div id="carga_edita_presupuesto"></div></td>
  </tr>
  <tr>
    <td colspan="11"></td>
  </tr>
  <tr>
    <td colspan="11" align="center"  class="columna_subtitulo_resultados_oscuro">Valor de la Adjudicaci&oacute;n</td>
  </tr>
  <tr class="columna_subtitulo_resultados_oscuro">
   
    <td width="14%" align="center" class="fondo_3">Contratista</td>
    <td width="6%" align="center" class="fondo_3">No. Contrato</td>
    <td width="7%" align="center" class="fondo_3">Complemento</td>
    <td width="7%" align="center" class="fondo_3">Tipo de Documento</td>
  
    <td width="6%" align="center" class="fondo_3">A&ntilde;o</td>
    <td width="8%" align="center" class="fondo_3">Vigencia en Meses</td>
    <td width="18%" align="center" class="fondo_3">&Aacute;rea/Proyecto</td>
    <td width="9%" align="center" class="fondo_3">Valor USD$</td>
    <td width="9%" align="center" class="fondo_3">Valor COP$</td>
    <td width="9%" align="center" class="fondo_3">Ver Adjunto</td>
    <td width="14%" align="center" class="fondo_3">Acciones</td>
  </tr>
  <?	
  $sele_presupuesto = query_db("select t2_item_pecc_id,razon_social,consecutivo,creacion_sistema,ano,nombre,sum(valor_usd),sum(valor_cop),adjunto,tipo_documento,t1_proveedor_id,t2_presupuesto_id,nit,t1_tipo_documento_id,id_contrato,vigencia_mes,t1_campo_id,Expr1 from $vpeec18 where t2_item_pecc_id ='".$id_item_pecc."' group by t2_item_pecc_id,razon_social,consecutivo,creacion_sistema,ano,nombre,adjunto,tipo_documento,t1_proveedor_id,t2_presupuesto_id,nit,t1_tipo_documento_id,id_contrato,vigencia_mes,t1_campo_id,Expr1");
  
  
  
 
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
	$cont = 0;
  	$clase="";
	while($sel_presu = traer_fila_db($sele_presupuesto)){
		
		
		$valor_total_usd = $valor_total_usd + ($sel_presu[6]);
		$valor_total_cop = $valor_total_cop + ($sel_presu[7]);
		
		if($cont == 0){
			$clase= "filas_resultados";
			$cont = 1;
		  }else{
			$clase= "";
			$cont = 0;
		  }
				
		?>
  <tr class="<?=$clase?>">
    
    <td align="center"><?=$sel_presu[1]?></td>
    <td align="center"><?
				if($sel_presu[2] != ""){
    			    $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_presu[3]);
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_presu[2];
					$numero_contrato4 = $sel_presu[17];
					echo numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $sel_presu[14]);
				}else{
					echo "Sin Crear";
					}
		?></td>
    <td align="center"><?=str_replace(".","",$sel_presu[17])?></td>
    <td align="center"><?=$sel_presu[9]?></td>
    
    <td align="center"><?=$sel_presu[4]?></td>
    <td align="center"><?=$sel_presu[15]?></td>
    <td align="center"><?=$sel_presu[5]?></td>
    <td align="center" ><?=$sel_presu[6]?></td>
    <td align="center"><?=$sel_presu[7]?></td>
    <td align="center">
	<? if($sel_presu[8] != " " and $sel_presu[8] != "NULL" and $sel_presu[8] != "" ){?>
	<?=saca_nombre_anexo($sel_presu[8])?>
                  <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sel_presu[8]?>&n1=<?=$sel_presu[11]?>&n3=3" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sel_presu[8])?>.gif" width="16" height="16" />
                  </a>
                  <?
	}
				  ?>
            </td>
    <td align="center">
    <?
    if ($edicion_datos_generales == "SI"){
	?>
    <img src="../imagenes/botones/eliminada_temporal.gif" width="16" height="16" alt="Elimiar" title="Eliminar" onclick="eliminar_presupuesto_adjudica(<?=$sel_presu[11]?>)" />
    <?
	}
	?>
    </td>
  </tr>
  <?
			}
			$total_equivale_usd = ($valor_total_cop / $trm_actual) +$valor_total_usd ;
		?>
</table>
<table width="100%" border="1" align="center"  class="tabla_lista_resultados">
        <tr class="columna_subtitulo_resultados_oscuro">
          <td width="23%" align="right">Total Equivalente USD$:</td>
          <td width="13%" align="left"><?=$total_equivale_usd?></td>
          <td width="13%" align="right">Total USD$:</td>
          <td width="5%" align="left"><?=$valor_total_usd?></td>
          <td width="14%" align="right">Total COP$:</td>
          <td width="32%" align="left"><?=$valor_total_cop?></td>
        </tr>
</table>




<table width="100%" border="0">
	<tr>
    	<td colspan="2" align="right"></td>
    </tr>
	<tr>
    	<td width="50%" valign="top">
        	<table width="100%" border="1" class="tabla_lista_resultados">
                <tr class="columna_subtitulo_resultados_oscuro">
                    <td colspan="4" align="center"  class="fondo_3" style="height:30px"> Agrupaci&oacute;n de valores por A&#327;O y Proveedor</td>
                <tr>
                <tr class="columna_subtitulo_resultados_oscuro">
                    <td align="center"  class="fondo_3" width="40%">Proveedor</td>
                    <td align="center"  class="fondo_3" width="30%">A&#328;o</td>
                    <td align="center"  class="fondo_3">Total USD</td>
                    <td align="center"  class="fondo_3">Total COP</td>
                </tr>
                <?php $group_presupuesto_ano = query_db("select razon_social,ano,sum(valor_usd) as valor_usd,sum(valor_cop) as valor_cop from $vpeec18 where t2_item_pecc_id = $id_item_pecc group by razon_social,ano");
                while($rowGPA = traer_fila_db($group_presupuesto_ano)){
                
                    ?>  
              <tr>
              		<td><?= $rowGPA['razon_social']?></td>
                    <td align="center"><?= $rowGPA['ano']?></td>
                    <td align="center"><?= $rowGPA['valor_usd']?></td>
                    <td align="center"><?= $rowGPA['valor_cop']?></td>
                </tr>
                <?php }?>
            </table>
        </td>
        <td width="50%" valign="top">
        	<table width="100%" border="1" class="tabla_lista_resultados">
                <tr class="columna_subtitulo_resultados_oscuro">
                    <td colspan="4" align="center"  class="fondo_3" style="height:30px"> Agrupaci&oacute;n por Area/Proyecto y Proveedor</td>
                <tr>
                <tr class="columna_subtitulo_resultados_oscuro">
                    <td align="center"  class="fondo_3" width="40%">Proveedor</td>
                    <td align="center"  class="fondo_3" width="30%">Area/Proyecto</td>
                    <td align="center"  class="fondo_3">Total USD</td>
                    <td align="center"  class="fondo_3">Total COP</td>
                </tr>
                <?php 
                $group_presupuesto_area = query_db("select razon_social,nombre,sum(valor_usd) as valor_usd,sum(valor_cop) as valor_cop from $vpeec18 where t2_item_pecc_id = $id_item_pecc group by razon_social,nombre");
                while($rowGPA = traer_fila_db($group_presupuesto_area)){
                
                    ?>
              <tr>
              		<td><?= $rowGPA['razon_social']?></td>
                    <td><?= $rowGPA['nombre']?></td>
                    <td align="center"><?= $rowGPA['valor_usd']?></td>
                    <td align="center"><?= $rowGPA['valor_cop']?></td>
                </tr>
                <?php }?>
            </table>
        </td>
    </tr>
    <tr>
    	<td colspan="2" align="right"></td>
    </tr>
</table>   
	
<?
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Contratos.xls"); 

?>
