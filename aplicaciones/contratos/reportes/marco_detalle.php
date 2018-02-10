<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
?>
<style>
.columna_subtitulo_resultados_oscuro{ height:20px;font-size:14px; color:#FFF; 
 BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#666 }
 .columna_subtitulo_resultados_mas_oscuro{ height:20px;font-size:14px;  
 BORDER-BOTTOM: #CCCCCC 1px solid; BORDER-RIGHT: #CCCCCC 1px solid; BORDER-LEFT: #CCCCCC 1px solid; background:#999;color:#FFF }
 	.fondo_4{ background:#FFFFD2; color:#000000;padding:2px 2px 2px 10px;border: 1px solid #C6E6FF;	mso-style-parent:style0;
	mso-number-format:"\@";	}	
.xl65
	{
	mso-style-parent:style0;
	mso-number-format:"\@";
	}
</style>
<?
$id_item_pecc = elimina_comillas(arreglo_recibe_variables($id_item_pecc_env));
?>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
<?
  	if($xls!=1){
  	?>
<tr>
  <td colspan="10">
   <A href="javascript:document.location.target='_blank';document.location.href='../aplicaciones/contratos/reportes/marco_detalle.php?xls=1&id_item_pecc_env=<?=$id_item_pecc;?>'">Exportar a Excel</A>
  </td>
</tr>
<?
	}
?>

<?
  	if($xls==1){
  	?>
<tr >
  <td class="columna_subtitulo_resultados_oscuro">N&uacute;mero Solicitud</td>
  <td class="columna_subtitulo_resultados_oscuro">Monto USD</td>
  <td class="columna_subtitulo_resultados_oscuro">Monto COP</td>
  <td class="columna_subtitulo_resultados_oscuro">Monto EQUI</td>
  <td class="columna_subtitulo_resultados_oscuro">Comprometido USD</td>
  <td class="columna_subtitulo_resultados_oscuro">Comprometido COP</td>
  <td class="columna_subtitulo_resultados_oscuro">Comprometido EQUI</td>
  <td class="columna_subtitulo_resultados_oscuro">Saldo USD</td>
  <td class="columna_subtitulo_resultados_oscuro">Saldo COP</td>
  <td class="columna_subtitulo_resultados_oscuro">Saldo EQUI</td>
</tr>
<?
	$busca_solicitud_marco = "select distinct(id_item) from $co1 where t1_tipo_documento_id = 2 and id_item = $id_item_pecc";
	$sql_busca_solicitud_marco=query_db($busca_solicitud_marco);
	while($lista_busca_solicitud_marco=traer_fila_row($sql_busca_solicitud_marco)){
	
		$id_item_pecc = $lista_busca_solicitud_marco[0];
		?>
		<?
       $sele_items_historico = "select num1,num2,num3 from $pi2 where id_item=".$id_item_pecc;
        $sql_sele_items_historico=traer_fila_row(query_db($sele_items_historico));
        
        $sel_valor_inicial = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real_inicio where id_item =".$id_item_pecc." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");
        $eq_total=0;
        $usd_total=0;
        $cop_total=0;
        while($sel_inio = traer_fila_db($sel_valor_inicial)){
            $eq = $sel_inio[0] + ($sel_inio[1] / $sel_inio[2]);
            $usd_total = $sel_inio[0]+$usd_total;
            $cop_total = $sel_inio[1]+$cop_total;
            $eq_total = $eq+$eq_total;
        }
        
        $ampliacion = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real where id_item_peec_aplica =".$id_item_pecc." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");
        $eq_total_amp_esp=0;
        $usd_total_amp_esp=0;
        $cop_total_amp_cop=0;
        while($sel_ampl = traer_fila_db($ampliacion)){
            $eq_ampli_espe = $sel_ampl[0] + ($sel_ampl[1] / $sel_ampl[2]);
            $sel_si_esta_compartido = traer_fila_row(query_db("select count(*) from  v_peec_amplia_real where t2_presupuesto_id = ".$sel_ampl[6]));
            if($sel_si_esta_compartido[0] == 1){//presupuesto especifica
                $usd_total_amp_esp = $sel_ampl[0]+$usd_total_amp_esp;
                $cop_total_amp_cop = $sel_ampl[1]+$cop_total_amp_cop;
                $eq_total_amp_esp = $eq_ampli_espe+$eq_total_amp_esp;
                $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido from $co1 where id = ".$sel_ampl[5]));
                $numero_contrato1 = "C";
    
                $separa_fecha_crea = explode("-",$sel_contrato[0]);
                $ano_contra = $separa_fecha_crea[0];
                $numero_contrato2 = substr($ano_contra,2,2);
                $numero_contrato3 = $sel_contrato[1];
                $numero_contrato4 = $sel_contrato[2];
            }//si es AMPLAICION ESPECIFICA
        }//FIN WHILE AMPLIACIONES
        
    
        $ampliacion = query_db("select t2_presupuesto_id, count(*) from v_peec_amplia_real where id_item_peec_aplica =".$id_item_pecc." group by t2_presupuesto_id");
        $eq_total_amp_esp_no=0;
        $usd_total_amp_esp_no=0;
        $cop_total_amp_cop_no=0;
            while($sel_ampl_no_espe = traer_fila_db($ampliacion)){
                if($sel_ampl_no_espe[1] > 1){//presupuesto comprtido
                    $sel_ampl = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real where id_item_peec_aplica =".$id_item_pecc." and t2_presupuesto_id = ".$sel_ampl_no_espe[0]." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id"));
                    $eq_ampli_espe_no = $sel_ampl[0] + ($sel_ampl[1] / $sel_ampl[2]);
                        
                    
                    $usd_total_amp_esp_no = $sel_ampl[0]+$usd_total_amp_esp_no;
                    $cop_total_amp_cop_no = $sel_ampl[1]+$cop_total_amp_cop_no;
                    $eq_total_amp_esp_no = $eq_ampli_espe+$eq_total_amp_esp_no;
                    $num_conta_imp="";
    
                    $sel_contras = query_db("select t7_contrato_id from v_peec_amplia_real where id_item_peec_aplica =".$id_item_pecc." and t2_presupuesto_id = ".$sel_ampl_no_espe[0]." group by t7_contrato_id");
                    while($sel_contr = traer_fila_db($sel_contras)){
                     $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido from $co1 where id = ".$sel_contr[0]));
                        $numero_contrato1 = "C";			
                        $separa_fecha_crea = explode("-",$sel_contrato[0]);
                        $ano_contra = $separa_fecha_crea[0];
                        
                        $numero_contrato2 = substr($ano_contra,2,2);
                        $numero_contrato3 = $sel_contrato[1];
                        $numero_contrato4 = $sel_contrato[2];
                        $num_conta_imp = $num_conta_imp."".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4)."<br />";
                    }
                }//si es AMPLAICION NO ESPECIFICA
            }//FIN WHILE AMPLIACIONES
        
        //Inicio OT
        $eq_total_ot=0;
        $usd_total_ot=0;
        $cop_total_ot=0;
        $sel_orden = query_db("select id_item from v_peec_valor_ot_real where id_item_peec_aplica =".$id_item_pecc." group by id_item");
            while($or_ot_arupa = traer_fila_db($sel_orden)){
                
                    
                    
                    $or_ot = traer_fila_row(query_db("select id_item_peec_aplica, trm, valor_usd, valor_cop, t1_campo_id, ano, t7_contrato_id from v_peec_valor_ot_real where id_item_peec_aplica =".$id_item_pecc." and id_item = ".$or_ot_arupa[0]));
                    
                    
                    $eq_ot = $or_ot[2] + ($or_ot[3] / $or_ot[1]);				
                    $usd_total_ot = $or_ot[2]+$usd_total_ot;
                    $cop_total_ot = $or_ot[3]+$cop_total_ot;
                    $eq_total_ot = $eq_ot+$eq_total_ot;
                    
                    $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido from $co1 where id = ".$or_ot[6]));
                     $numero_contrato1 = "C";
                
                        $separa_fecha_crea = explode("-",$sel_contrato[0]);
                        $ano_contra = $separa_fecha_crea[0];
                        
                        $numero_contrato2 = substr($ano_contra,2,2);
                        $numero_contrato3 = $sel_contrato[1];
                        $numero_contrato4 = $sel_contrato[2];
     
      }
        //FIN OT
?>
 
  <tr>
  <td class="xl65"><?=numero_item_pecc($sql_sele_items_historico[0],$sql_sele_items_historico[1],$sql_sele_items_historico[2])?></td>
  <td class="xl65"><?=number_format(($usd_total+$usd_total_amp_esp+$usd_total_amp_esp_no),0)?></td>
  <td class="xl65"><?=number_format(($cop_total+$cop_total_amp_cop+$cop_total_amp_cop_no),0)?></td>
  <td class="xl65"><?=number_format(($eq_total+$eq_total_amp_esp+$eq_total_amp_esp_no),0)?></td>
  <td class="xl65"><?=number_format($usd_total_ot, 0)?></td>
  <td class="xl65"><?=number_format($cop_total_ot, 0)?></td>
  <td class="xl65"><?=number_format($eq_total_ot, 0)?></td>
  <td class="xl65"><?=number_format(($usd_total+$usd_total_amp_esp+$usd_total_amp_esp_no)-$usd_total_ot, 0)?></td>
  <td class="xl65"><?=number_format(($cop_total+$cop_total_amp_cop+$cop_total_amp_cop_no)-$cop_total_ot, 0)?></td>
  <td class="xl65"><?=number_format(($eq_total+$eq_total_amp_esp+$eq_total_amp_esp_no)-$eq_total_ot, 0)?></td>
</tr>
 <tr>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
  </tr>
<?
	}
}
?>
<tr>
    <td colspan="10" class="columna_subtitulo_resultados_oscuro">Aprobaci&oacute;n Ordenes de Trabajo</td>
  </tr>
  <tr >
    <td class="columna_subtitulo_resultados_mas_oscuro">Contrato</td>
    <td class="columna_subtitulo_resultados_mas_oscuro">A&ntilde;o</td>
    <td colspan="2" class="columna_subtitulo_resultados_mas_oscuro">Area</td>
    <td colspan="2" class="columna_subtitulo_resultados_mas_oscuro">USD</td>
    <td colspan="2" class="columna_subtitulo_resultados_mas_oscuro">COP</td>
    <td colspan="2" class="columna_subtitulo_resultados_mas_oscuro">EQUI USD</td>
  </tr>
  <?
  
  	$eq_total_ot=0;
	$usd_total_ot=0;
	$cop_total_ot=0;
	$sel_orden = query_db("select id_item from v_peec_valor_ot_real where id_item_peec_aplica =".$id_item_pecc." group by id_item");
	
		while($or_ot_arupa = traer_fila_db($sel_orden)){
			
			    
				
				$or_ot = traer_fila_row(query_db("select id_item_peec_aplica, trm, valor_usd, valor_cop, t1_campo_id, ano, t7_contrato_id from v_peec_valor_ot_real where id_item_peec_aplica =".$id_item_pecc." and id_item = ".$or_ot_arupa[0]));
				
				
				$eq_ot = $or_ot[2] + ($or_ot[3] / $or_ot[1]);				
				$usd_total_ot = $or_ot[2]+$usd_total_ot;
				$cop_total_ot = $or_ot[3]+$cop_total_ot;
				$eq_total_ot = $eq_ot+$eq_total_ot;
				
				$sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido from $co1 where id = ".$or_ot[6]));
			 	 $numero_contrato1 = "C";
			
					$separa_fecha_crea = explode("-",$sel_contrato[0]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contrato[1];
					$numero_contrato4 = $sel_contrato[2];
  ?>
  <tr>
   <td><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4)?></td>
    <td><?=$or_ot[5]?></td>
    <td colspan="2"><?=saca_nombre_lista($g15,$or_ot[4],'nombre','t1_campo_id')?></td>
    <td colspan="2" class="xl65"><?=number_format($or_ot[2], 0)?></td>
    <td colspan="2" class="xl65"><?=number_format($or_ot[3], 0)?></td>
    <td colspan="2" class="xl65"><?=number_format($eq_ot, 0)?></td>
  </tr>
  <?
  }
  ?>
   <tr >
    <td colspan="4" align="center" class="fondo_4"><strong>Sub Total:</strong></td>
    <td colspan="2" class="fondo_4" ><strong>
      <?=number_format($usd_total_ot, 0)?>
    </strong></td>
    <td colspan="2" class="fondo_4" ><strong>
      <?=number_format($cop_total_ot, 0)?>
    </strong></td>
    <td colspan="2" class="fondo_4" ><strong>
      <?=number_format($eq_total_ot, 0)?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr >
    <td colspan="10" class="columna_subtitulo_resultados_oscuro">Aprobaci&oacute;n Adjudicacion inicial</td>
  </tr>
  <tr >
    <td width="23%" class="columna_subtitulo_resultados_mas_oscuro">Contrato</td>
    <td width="9%" class="columna_subtitulo_resultados_mas_oscuro">A&ntilde;o</td>
    <td width="17%" colspan="2" class="columna_subtitulo_resultados_mas_oscuro">Area</td>
    <td width="15%" colspan="2" class="columna_subtitulo_resultados_mas_oscuro">USD</td>
    <td width="17%" colspan="2" class="columna_subtitulo_resultados_mas_oscuro">COP</td>
    <td width="19%" colspan="2" class="columna_subtitulo_resultados_mas_oscuro">EQUI USD</td>
  </tr>
  <?

  
  $sel_valor_inicial = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real_inicio where id_item =".$id_item_pecc." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");
	$eq_total=0;
	$usd_total=0;
	$cop_total=0;
	while($sel_inio = traer_fila_db($sel_valor_inicial)){
			$eq = $sel_inio[0] + ($sel_inio[1] / $sel_inio[2]);
			$usd_total = $sel_inio[0]+$usd_total;
			$cop_total = $sel_inio[1]+$cop_total;
			$eq_total = $eq+$eq_total;
			 $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido from $co1 where id = ".$sel_inio[5]));
			  $numero_contrato1 = "C";
			
					$separa_fecha_crea = explode("-",$sel_contrato[0]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contrato[1];
					$numero_contrato4 = $sel_contrato[2];
  ?>
  <tr>
    <td><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4)?></td>
    <td><?=$sel_inio[3]?></td>
    <td colspan="2"><?=saca_nombre_lista($g15,$sel_inio[4],'nombre','t1_campo_id')?></td>
    <td colspan="2" class="xl65"><?=number_format($sel_inio[0], 0)?></td>
    <td colspan="2" class="xl65"><?=number_format($sel_inio[1], 0)?></td>
    <td colspan="2" class="xl65"><?=number_format($eq, 0)?></td>
  </tr>
  <?
	}
  ?>
  <tr >
    <td colspan="4" align="center" class="fondo_4"><strong>Sub Total:</strong></td>
    <td colspan="2" class="fondo_4" ><strong>
      <?=number_format($usd_total, 0)?>
    </strong></td>
    <td colspan="2" class="fondo_4" ><strong>
      <?=number_format($cop_total, 0)?>
    </strong></td>
    <td colspan="2" class="fondo_4" ><strong>
      <?=number_format($eq_total, 0)?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="10" class="columna_subtitulo_resultados_oscuro">Aprobaci&oacute;n Ampliaciones especificas</td>
  </tr>
  <tr >
    <td class="columna_subtitulo_resultados_mas_oscuro">Contrato</td>
    <td class="columna_subtitulo_resultados_mas_oscuro">A&ntilde;o</td>
    <td colspan="2" class="columna_subtitulo_resultados_mas_oscuro">Area</td>
    <td colspan="2" class="columna_subtitulo_resultados_mas_oscuro">USD</td>
    <td colspan="2" class="columna_subtitulo_resultados_mas_oscuro">COP</td>
    <td colspan="2" class="columna_subtitulo_resultados_mas_oscuro">EQUI USD</td>
  </tr>
  <?
  $ampliacion = query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real where id_item_peec_aplica =".$id_item_pecc." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id");
	$eq_total_amp_esp=0;
	$usd_total_amp_esp=0;
	$cop_total_amp_cop=0;
		  while($sel_ampl = traer_fila_db($ampliacion)){
			  $eq_ampli_espe = $sel_ampl[0] + ($sel_ampl[1] / $sel_ampl[2]);
			  		$sel_si_esta_compartido = traer_fila_row(query_db("select count(*) from  v_peec_amplia_real where t2_presupuesto_id = ".$sel_ampl[6]));
				if($sel_si_esta_compartido[0] == 1){//presupuesto especifica
				$usd_total_amp_esp = $sel_ampl[0]+$usd_total_amp_esp;
				$cop_total_amp_cop = $sel_ampl[1]+$cop_total_amp_cop;
				$eq_total_amp_esp = $eq_ampli_espe+$eq_total_amp_esp;
				 $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido from $co1 where id = ".$sel_ampl[5]));
			 	 $numero_contrato1 = "C";
			
					$separa_fecha_crea = explode("-",$sel_contrato[0]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contrato[1];
					$numero_contrato4 = $sel_contrato[2];
  ?>
  <tr>
    <td><?=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4)?></td>
    <td><?=$sel_ampl[3]?></td>
    <td colspan="2"><?=saca_nombre_lista($g15,$sel_ampl[4],'nombre','t1_campo_id')?></td>
    <td colspan="2" class="xl65"><?=number_format($sel_ampl[0], 0)?></td>
    <td colspan="2" class="xl65"><?=number_format($sel_ampl[1], 0)?></td>
    <td colspan="2" class="xl65"><?=number_format($eq_ampli_espe, 0)?></td>
  </tr>
  <?
	}//si es AMPLAICION ESPECIFICA
		  }//FIN WHILE AMPLIACIONES
  ?>
  <tr>
    <td colspan="4" align="center" class="fondo_4"><strong>Sub Total:</strong></td>
    <td colspan="2" class="fondo_4" ><strong>
      <?=number_format($usd_total_amp_esp, 0)?>
    </strong></td>
    <td colspan="2" class="fondo_4" ><strong>
      <?=number_format($cop_total_amp_cop, 0)?>
    </strong></td>
    <td colspan="2" class="fondo_4" ><strong>
      <?=number_format($eq_total_amp_esp, 0)?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="10" class="columna_subtitulo_resultados_oscuro">Aprobaci&oacute;n Ampliaciones Compartidas</td>
  </tr>
  <tr >
    <td class="columna_subtitulo_resultados_mas_oscuro">Contrato</td>
    <td class="columna_subtitulo_resultados_mas_oscuro">A&ntilde;o</td>
    <td colspan="2" class="columna_subtitulo_resultados_mas_oscuro">Area</td>
    <td colspan="2" class="columna_subtitulo_resultados_mas_oscuro">USD</td>
    <td colspan="2" class="columna_subtitulo_resultados_mas_oscuro">COP</td>
    <td colspan="2" class="columna_subtitulo_resultados_mas_oscuro">EQUI USD</td>
  </tr>
  <?
  $ampliacion = query_db("select t2_presupuesto_id, count(*) from v_peec_amplia_real where id_item_peec_aplica =".$id_item_pecc." group by t2_presupuesto_id");
	$eq_total_amp_esp_no=0;
	$usd_total_amp_esp_no=0;
	$cop_total_amp_cop_no=0;
		  while($sel_ampl_no_espe = traer_fila_db($ampliacion)){
			  if($sel_ampl_no_espe[1] > 1){//presupuesto comprtido
			  
			  $sel_ampl = traer_fila_row(query_db("select sum(valor_usd), sum(valor_cop), trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id from v_peec_amplia_real where id_item_peec_aplica =".$id_item_pecc." and t2_presupuesto_id = ".$sel_ampl_no_espe[0]." group by trm, ano, t1_campo_id, t7_contrato_id, t2_presupuesto_id"));
			  
			  
			  $eq_ampli_espe_no = $sel_ampl[0] + ($sel_ampl[1] / $sel_ampl[2]);
			  		
				
				$usd_total_amp_esp_no = $sel_ampl[0]+$usd_total_amp_esp_no;
				$cop_total_amp_cop_no = $sel_ampl[1]+$cop_total_amp_cop_no;
				$eq_total_amp_esp_no = $eq_ampli_espe+$eq_total_amp_esp_no;
				$num_conta_imp="";

				$sel_contras = query_db("select t7_contrato_id from v_peec_amplia_real where id_item_peec_aplica =".$id_item_pecc." and t2_presupuesto_id = ".$sel_ampl_no_espe[0]." group by t7_contrato_id");
				
				while($sel_contr = traer_fila_db($sel_contras)){
				 $sel_contrato = traer_fila_row(query_db("select creacion_sistema, consecutivo, apellido from $co1 where id = ".$sel_contr[0]));
		 		    $numero_contrato1 = "C";			
					$separa_fecha_crea = explode("-",$sel_contrato[0]);
					$ano_contra = $separa_fecha_crea[0];
					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_contrato[1];
					$numero_contrato4 = $sel_contrato[2];
					$num_conta_imp = $num_conta_imp."".numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4)."<br />";
				}
			
			
			if($linea_color == 0){
				$class_s = "";
				$linea_color = 1;
			}else{
				$class_s = "columna_subtitulo_resultados_letra_normal";
				$linea_color = 0;
			}	
  ?>
  <tr class="<?=$class_s;?>">
    <td><?=$num_conta_imp?></td>
    <td><?=$sel_ampl[3]?></td>
    <td colspan="2"><?=saca_nombre_lista($g15,$sel_ampl[4],'nombre','t1_campo_id')?></td>
    <td colspan="2" class="xl65"><?=number_format($sel_ampl[0], 0)?></td>
    <td colspan="2" class="xl65"><?=number_format($sel_ampl[1], 0)?></td>
    <td colspan="2" class="xl65"><?=number_format($eq_ampli_espe_no, 0)?></td>
  </tr>
  <?
	}//si es AMPLAICION NO ESPECIFICA
		  }//FIN WHILE AMPLIACIONES
  ?>
  <tr >
    <td colspan="4" align="center" class="fondo_4"><strong>Sub Total:</strong></td>
    <td colspan="2" class="fondo_4"><strong>
      <?=number_format($usd_total_amp_esp_no, 0)?>
    </strong></td>
    <td colspan="2" class="fondo_4"><strong>
      <?=number_format($cop_total_amp_cop_no, 0)?>
    </strong></td>
    <td colspan="2" class="fondo_4"><strong>
      <?=number_format($eq_total_amp_esp_no, 0)?>
    </strong></td>
  </tr>
  <tr>
    <td>&nbsp;</td>
    <td>&nbsp;</td>
    <td colspan="2" align="right">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
    <td colspan="2">&nbsp;</td>
  </tr>
  
</table>
<?
if($xls==1){
header('Content-type: application/vnd.ms-excel');
header("Content-Disposition: attachment; filename=Contrato Marco.xls"); 
}
?>