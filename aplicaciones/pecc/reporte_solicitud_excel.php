<? include("../../librerias/lib/@session.php"); 
	//verifica_menu("administracion.html");
	//header('Content-Type: text/xml; charset=ISO-8859-1');

	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_item_pecc_marco = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc_marco"]));
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
    
<?
$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$id_item_pecc_marco =$sel_item[26];
	$sel_item_marco = traer_fila_row(query_db("select * from $pi2 where id_item='".$id_item_pecc_marco."'"));
	$id_tipo_proceso_pecc = $sel_item[20];
	
	if($sel_item[49]==1){
		$titilo="Distribuci&oacute;n del Valor para Agregar al Disponible para Crear OTs";
		$titilo2="Lista del Disponible para Agregar al Contrato";
	}else{
	   $titilo="Seleccione el Valor - Desde aqu&iacute; podr&aacute; distribuir los valores de la solicitud en varios proyectos";
	   $titilo2="Lista de Valores de esta Solictud";
	}
	

$sele_presupuesto = query_db("select $pi8.t2_presupuesto_id,$pi8.ano, $g15.nombre, $pi8.adjunto,$pi8.valor_usd,$pi8.valor_cop, $pi8.destino_final, $pi8.id_item_ots_aplica, $pi8.cargo_contable from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and $pi8.al_valor_inicial_para_marco is null");
	$valor_total_usd = 0;
	$valor_total_cop = 0;
	$total_equivale_usd = 0 ;
	
	
	
?>
<table width="100%" border="1" align="center">
<tr >
  <td colspan="2" rowspan="3" align="center" >&nbsp;&nbsp;<img src="https://www.abastecimiento.hocol.com.co/sgpa/imagenes/coorporativo/logo-cliente.png" alt="" /></td>
  <td colspan="8" align="left" class="titulo1"><strong>REPORTE VALOR DE LA SOLICITUD PARA EL PERMISO</strong></td>
</tr>
  <tr>
    <td ></td>
  </tr>
  <tr>
    <td ></td>
  </tr>
  <tr>
    <td colspan="10" align="center"  class="columna_subtitulo_resultados_oscuro"><?=$titilo2?></td>
  </tr>
  <tr class="columna_subtitulo_resultados_oscuro">
    <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
		?>
    <td width="13%" align="center" class="fondo_3">Contrato(s) Marco</td>
    <?
			}
		  ?>
    <td width="13%" align="center" class="fondo_3">A&ntilde;o</td>
    <td width="16%" align="center" class="fondo_3">&Aacute;rea/Proyecto</td>
    
    <?
    if ($sel_item[4]<>1){
	?>
    <td width="16%" align="center" class="fondo_3">Destino</td>
    <td width="16%" align="center" class="fondo_3">Cago Contable</td>
    <?
	}
	?>
    <td width="16%" align="center" class="fondo_3">Valor USD$</td>
    <td width="16%" align="center" class="fondo_3">Valor COP$</td>
    <td width="15%" align="center" class="fondo_3">Ver Adjunto</td>
    <?
      if($id_tipo_proceso_pecc ==3){
	  ?><td width="11%" align="center" class="fondo_3">Solicitud a la Cual Aplica la OT</td><? }?>
    
  </tr>
  <?
		$cont = 0;
  $clase="";
        	while($sel_presu = traer_fila_db($sele_presupuesto)){
				$valor_total_usd = $valor_total_usd + $sel_presu[4];
				$valor_total_cop = $valor_total_cop + $sel_presu[5];
				
				
				if($sel_presu[7] == 0){
					$num_sol_aplica = "A la solicitud que genero los contratos ".numero_item_pecc($sel_item_marco[16],$sel_item_marco[17],$sel_item_marco[18]);
					}else{
							$sel_sol_aplica_ot = traer_fila_row(query_db("select id_item, num1, num2, num3 from t2_item_pecc where id_item = ".$sel_presu[7].""));		
							$num_sol_aplica = numero_item_pecc($sel_sol_aplica_ot[1],$sel_sol_aplica_ot[2],$sel_sol_aplica_ot[3]);
						}
						
						
				if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		?>
  <tr class="<?=$clase?>">
    <?
        	if($id_tipo_proceso_pecc == 2 or $id_tipo_proceso_pecc == 3){
		?>
    <td align="center"><?
          	$sel_contr = query_db("select t2.consecutivo, t2.creacion_sistema, t2.apellido, t2.id from $pi12 as t1, $co1 as t2 where t1.t7_contrato_id = t2.id and t2_presupuesto_id =".$sel_presu[0]);
			while($sel_apl = traer_fila_db($sel_contr)){
					$numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_apl[1]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_apl[0];
					$numero_contrato4 = $sel_apl[2];
					echo "* ".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sel_apl[3])."<br />";
			}
		  ?></td>
    <?
			}
		  ?>
    <td align="center"><?=$sel_presu[1]?></td>
    <td align="center"><?=$sel_presu[2]?></td>
    
     <?
    if ($sel_item[4]<>1){
	?>
    <td align="center" ><?=$sel_presu[6]?></td>
    <td align="center" ><?=$sel_presu[8]?></td>
    <?
	}
	?>
    <td align="center" ><?=number_format($sel_presu[4],0)?></td>
    <td align="center"><?=number_format($sel_presu[5],0)?></td>
    <td align="center"> <? if($sel_presu[3] != " "){?><?=saca_nombre_anexo($sel_presu[3])?><? }?></td>
   <?
      if($id_tipo_proceso_pecc ==3){
	  ?> <td align="center"><?=$num_sol_aplica?></td><? }?>
    
  </tr>
  <?
			}

			$total_equivale_usd = ($valor_total_cop / $sel_pecc[0]) +$valor_total_usd ;
		?>
</table>
<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
        <tr class="columna_subtitulo_resultados_oscuro">
          <td width="23%" align="right">Total Equivalente USD$:</td>
          <td width="13%" align="left"><?=number_format($total_equivale_usd)?></td>
          <td width="13%" align="right">Total USD$:</td>
          <td width="5%" align="left"><?=number_format($valor_total_usd)?></td>
          <td width="14%" align="right">Total COP$:</td>
          <td width="32%" align="left"><?=number_format($valor_total_cop)?></td>
        </tr>
</table>

<table width="100%">
	<tr>
    	<td colspan="2" align="right"></td>
    </tr>
	<tr>
    	<td width="50%" valign="top">
        	<table width="100%" border="1" class="tabla_lista_resultados">
                <tr class="columna_subtitulo_resultados_oscuro">
                    <td colspan="3" align="center"  class="fondo_3" style="height:30px"> Agrupaci&oacute;n de valores por AÑO</td>
                <tr>
                <tr class="columna_subtitulo_resultados_oscuro">
                    <td align="center"  class="fondo_3" width="40%">Año</td>
                    <td align="center"  class="fondo_3">Total USD</td>
                    <td align="center"  class="fondo_3">Total COP</td>
                </tr>
                <?php $group_presupuesto_ano = query_db("select $pi8.ano,sum($pi8.valor_usd) as valor_usd,sum($pi8.valor_cop) as valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and $pi8.al_valor_inicial_para_marco is null group by $pi8.ano");
                $cont = 0;
                while($rowGPA = traer_fila_db($group_presupuesto_ano)){
                if($cont == 0){
                    $clase= "filas_resultados";
                    $cont = 1;
                }else{
                    $clase= "";
                    $cont = 0;
                }
                    ?>
              <tr class="<?=$clase?>">
                    <td><?= $rowGPA['ano']?></td>
                    <td align="center"><?= number_format($rowGPA['valor_usd'])?></td>
                    <td align="center"><?= number_format($rowGPA['valor_cop'])?></td>
                </tr>
                <?php }?>
            </table>
        </td>
        <td width="50%" valign="top">
        	<table width="100%" border="1" class="tabla_lista_resultados">
                <tr class="columna_subtitulo_resultados_oscuro">
                    <td colspan="3" align="center"  class="fondo_3" style="height:30px"> Agrupaci&oacute;n por Area/Proyecto</td>
                <tr>
                <tr class="columna_subtitulo_resultados_oscuro">
                    <td align="center"  class="fondo_3" width="40%">Area/Proyecto</td>

                    <td align="center"  class="fondo_3">Total USD</td>
                    <td align="center"  class="fondo_3">Total COP</td>
                </tr>
                <?php 
                $group_presupuesto_area = query_db("select $g15.nombre,sum($pi8.valor_usd) as valor_usd,sum($pi8.valor_cop) as valor_cop from $pi8, $g15 where $pi8.t2_item_pecc_id ='".$id_item_pecc."' and $pi8.permiso_o_adjudica = 1 and $g15.t1_campo_id = $pi8.t1_campo_id and $pi8.al_valor_inicial_para_marco is null group by $g15.nombre");
                $cont = 0;
                while($rowGPA = traer_fila_db($group_presupuesto_area)){
                if($cont == 0){
                    $clase= "filas_resultados";
                    $cont = 1;
                }else{
                    $clase= "";
                    $cont = 0;
                }
                    ?>
              <tr class="<?=$clase?>">
                    <td><?= $rowGPA['nombre']?></td>
                    <td align="center"><?= number_format($rowGPA['valor_usd'])?></td>
                    <td align="center"><?= number_format($rowGPA['valor_cop'])?></td>
                </tr>
                <?php }?>
            </table>
        </td>
    </tr>
</table>	

    

	
<?
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Contratos.xls"); 

?>
