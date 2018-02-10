<? include("../../lib/@session.php"); 

$sele_tiempo_ideal = traer_fila_row(query_db("select tiempo_del_nivel from $vin_5 where t1_tipo_contratacion_id = 1 and t1_tipo_proceso_id= ".$_SESSION["ses_tipo_proceso"]." and aprobacion_socios = ".$_SESSION["ses_socios"]." and aprobacion_comite = ".$_SESSION["ses_comite_add"]." and aplica_sondeo = ".$_SESSION["ses_sondeo"]." and monto_minimo < ".$_SESSION["ses_montos"]." and monto_maximo >= ".$_SESSION["ses_montos"].""));

	

?><graph caption='' subcaption='' hovercapbg='' hovercapborder='cccccc' formatNumberScale='0' decimalPrecision='0' showvalues='0' numdivlines='10' numVdivlines='0' yaxisminvalue='' yaxismaxvalue=''  rotateNames='1' yAxisName='Numero de Dias' xAxisName='Mes de Finalizacion' baseFontSize="12">
<categories >
		<category name='' />
		<category name='Enero' /> 
      <category name='Febrero' /> 
	  <category name='Marzo' /> 
	  <category name='Abril' /> 
	  <category name='Mayo' /> 
	  <category name='Junio' /> 
	  <category name='Julio' /> 
	  <category name='Agosto' /> 
	  <category name='Septiembre' /> 
	  <category name='Octubre' /> 
	  <category name='Nobiembre' /> 
	  <category name='Diciembre' /> 
	  <category name='' />

</categories>
<dataset seriesName='Dias Ideal' color='000000' anchorBorderColor='000000' anchorBgColor='000000'>
	
    <?
    	
		
		
	?>
    <set value='<?=$sele_tiempo_ideal[0]?>' />
	  <set value='<?=$sele_tiempo_ideal[0]?>' /> 
      <set value='<?=$sele_tiempo_ideal[0]?>' /> 
	  <set value='<?=$sele_tiempo_ideal[0]?>' /> 
      <set value='<?=$sele_tiempo_ideal[0]?>' /> 
	  <set value='<?=$sele_tiempo_ideal[0]?>' /> 
      <set value='<?=$sele_tiempo_ideal[0]?>' /> 
	  <set value='<?=$sele_tiempo_ideal[0]?>' /> 
      <set value='<?=$sele_tiempo_ideal[0]?>' /> 
	  <set value='<?=$sele_tiempo_ideal[0]?>' /> 
      <set value='<?=$sele_tiempo_ideal[0]?>' /> 
	  <set value='<?=$sele_tiempo_ideal[0]?>' /> 
      <set value='<?=$sele_tiempo_ideal[0]?>' /> 
	<set value='<?=$sele_tiempo_ideal[0]?>' /> 
	</dataset>
    
<?

	$cuantos_por_enero = 0;
	$cuantos_por_febrero = 0;
	$cuantos_por_marzo = 0;
	$cuantos_por_abril = 0;
	$cuantos_por_mayo = 0;
	$cuantos_por_junio = 0;
	$cuantos_por_julio = 0;
	$cuantos_por_agosto = 0;
	$cuantos_por_sep = 0;
	$cuantos_por_oct = 0;
	$cuantos_por_nov = 0;
	$cuantos_por_dic = 0;
	
	$mas_bajo_por_enero = "";
	$mas_bajo_por_febrero = "";
	$mas_bajo_por_marzo = "";
	$mas_bajo_por_abril = "";
	$mas_bajo_por_mayo = "";
	$mas_bajo_por_junio = "";
	$mas_bajo_por_julio = "";
	$mas_bajo_por_agosto = "";
	$mas_bajo_por_sep = "";
	$mas_bajo_por_oct = "";
	$mas_bajo_por_nov = "";
	$mas_bajo_por_dic = "";
	
	$mas_alto_por_enero = 0;
	$mas_alto_por_febrero = 0;
	$mas_alto_por_marzo = 0;
	$mas_alto_por_abril = 0;
	$mas_alto_por_mayo = 0;
	$mas_alto_por_junio = 0;
	$mas_alto_por_julio = 0;
	$mas_alto_por_agosto = 0;
	$mas_alto_por_sep = 0;
	$mas_alto_por_oct = 0;
	$mas_alto_por_nov = 0;
	$mas_alto_por_dic = 0;
	
	$total_por_enero = 0;
	$total_por_febrero = 0;
	$total_por_marzo = 0;
	$total_por_abril = 0;
	$total_por_mayo = 0;
	$total_por_junio = 0;
	$total_por_julio = 0;
	$total_por_agosto = 0;
	$total_por_sep = 0;
	$total_por_oct = 0;
	$total_por_nov = 0;
	$total_por_dic = 0;
	
		
	$sel_tiempo_real = query_db("select * from $vin_6 where id_pecc = 1 and estado = 32 ".$_SESSION["comple_filtro"]);
	while($t_real = traer_fila_db($sel_tiempo_real)){
		$explo_defha_real = explode("-",$t_real[2]);
		$ano_mes_compara = $explo_defha_real[0]."-".$explo_defha_real[1];
		//enero
		if($_SESSION["ses_ano"]."-"."01" == $ano_mes_compara){
			$cuantos_por_enero = $cuantos_por_enero+1;//numero de procesos			
			$total_por_enero = $total_por_enero +$t_real[0];//dias totales gastados			
			if($mas_bajo_por_enero == ""){//tiempo mas bajo
			$mas_bajo_por_enero = $t_real[0];
			}else{
					if($t_real[0] < $mas_bajo_por_enero){
						$mas_bajo_por_enero = $t_real[0];
						}
				}//FIN tiempo mas bajo
				
				if($mas_alto_por_enero == ""){//tiempo mas alto
			$mas_alto_por_enero = $t_real[0];
			}else{
					if($t_real[0] > $mas_alto_por_enero){
						$mas_bajo_por_enero = $t_real[0];
						}
				}//FIN tiempo mas alto
			
			}
			//fin enero
			
			if($_SESSION["ses_ano"]."-"."02" == $ano_mes_compara){//febrero
			$cuantos_por_febrero = $cuantos_por_febrero+1;//numero de procesos			
			$total_por_febrero = $total_por_febrero +$t_real[0];//dias totales gastados
			
			if($mas_bajo_por_febrero == ""){
			$mas_bajo_por_febrero = $t_real[0];//tiempo mas bajo
			}else{
					if($t_real[0] < $mas_bajo_por_febrero){
						$mas_bajo_por_febrero = $t_real[0];//tiempo mas bajo
						}
				}
			if($mas_alto_por_febrero == ""){//tiempo mas alto
			$mas_alto_por_febrero = $t_real[0];
			}else{
					if($t_real[0] > $mas_alto_por_febrero){
						$mas_alto_por_febrero = $t_real[0];
						}
				}//FIN tiempo mas alto			
			}
			//fin febrero
			
			//marzo
		if($_SESSION["ses_ano"]."-"."03" == $ano_mes_compara){
			$cuantos_por_marzo = $cuantos_por_marzo+1;//numero de procesos			
			$total_por_marzo = $total_por_marzo +$t_real[0];//dias totales gastados			
			if($mas_bajo_por_marzo == ""){//tiempo mas bajo
			$mas_bajo_por_marzo = $t_real[0];
			}else{
					if($t_real[0] < $mas_bajo_por_marzo){
						$mas_bajo_por_marzo = $t_real[0];
						}
				}//FIN tiempo mas bajo
				
				if($mas_alto_por_marzo == ""){//tiempo mas alto
			$mas_alto_por_marzo = $t_real[0];
			}else{
					if($t_real[0] > $mas_alto_por_marzo){
						$mas_bajo_por_marzo = $t_real[0];
						}
				}//FIN tiempo mas alto
			
			}
			//fin marzo
			
			//abril
		if($_SESSION["ses_ano"]."-"."04" == $ano_mes_compara){
			$cuantos_por_abril = $cuantos_por_abril+1;//numero de procesos			
			$total_por_abril = $total_por_abril +$t_real[0];//dias totales gastados			
			if($mas_bajo_por_abril == ""){//tiempo mas bajo
			$mas_bajo_por_abril = $t_real[0];
			}else{
					if($t_real[0] < $mas_bajo_por_abril){
						$mas_bajo_por_abril = $t_real[0];
						}
				}//FIN tiempo mas bajo
				
				if($mas_alto_por_abril == ""){//tiempo mas alto
			$mas_alto_por_abril = $t_real[0];
			}else{
					if($t_real[0] > $mas_alto_por_abril){
						$mas_bajo_por_abril = $t_real[0];
						}
				}//FIN tiempo mas alto
			
			}
			//fin abril
			
			//mayo
		if($_SESSION["ses_ano"]."-"."05" == $ano_mes_compara){
			$cuantos_por_mayo = $cuantos_por_mayo+1;//numero de procesos			
			$total_por_mayo = $total_por_mayo +$t_real[0];//dias totales gastados			
			if($mas_bajo_por_mayo == ""){//tiempo mas bajo
			$mas_bajo_por_mayo = $t_real[0];
			}else{
					if($t_real[0] < $mas_bajo_por_mayo){
						$mas_bajo_por_mayo = $t_real[0];
						}
				}//FIN tiempo mas bajo
				
				if($mas_alto_por_mayo == ""){//tiempo mas alto
			$mas_alto_por_mayo = $t_real[0];
			}else{
					if($t_real[0] > $mas_alto_por_mayo){
						$mas_bajo_por_mayo = $t_real[0];
						}
				}//FIN tiempo mas alto
			
			}
			//fin mayo
			
			//junio
		if($_SESSION["ses_ano"]."-"."06" == $ano_mes_compara){
			$cuantos_por_junio = $cuantos_por_junio+1;//numero de procesos			
			$total_por_junio = $total_por_junio +$t_real[0];//dias totales gastados			
			if($mas_bajo_por_junio == ""){//tiempo mas bajo
			$mas_bajo_por_junio = $t_real[0];
			}else{
					if($t_real[0] < $mas_bajo_por_junio){
						$mas_bajo_por_junio = $t_real[0];
						}
				}//FIN tiempo mas bajo
				
				if($mas_alto_por_junio == ""){//tiempo mas alto
			$mas_alto_por_junio = $t_real[0];
			}else{
					if($t_real[0] > $mas_alto_por_junio){
						$mas_bajo_por_junio = $t_real[0];
						}
				}//FIN tiempo mas alto
			
			}
			//fin junio
			
			//julio
		if($_SESSION["ses_ano"]."-"."07" == $ano_mes_compara){
			$cuantos_por_julio = $cuantos_por_julio+1;//numero de procesos			
			$total_por_julio = $total_por_julio +$t_real[0];//dias totales gastados			
			if($mas_bajo_por_julio == ""){//tiempo mas bajo
			$mas_bajo_por_julio = $t_real[0];
			}else{
					if($t_real[0] < $mas_bajo_por_julio){
						$mas_bajo_por_julio = $t_real[0];
						}
				}//FIN tiempo mas bajo
				
				if($mas_alto_por_julio == ""){//tiempo mas alto
			$mas_alto_por_julio = $t_real[0];
			}else{
					if($t_real[0] > $mas_alto_por_julio){
						$mas_bajo_por_julio = $t_real[0];
						}
				}//FIN tiempo mas alto
			
			}
			//fin julio
			
			//agosto
		if($_SESSION["ses_ano"]."-"."08" == $ano_mes_compara){
			$cuantos_por_agosto = $cuantos_por_agosto+1;//numero de procesos			
			$total_por_agosto = $total_por_agosto +$t_real[0];//dias totales gastados			
			if($mas_bajo_por_agosto == ""){//tiempo mas bajo
			$mas_bajo_por_agosto = $t_real[0];
			}else{
					if($t_real[0] < $mas_bajo_por_agosto){
						$mas_bajo_por_agosto = $t_real[0];
						}
				}//FIN tiempo mas bajo
				
				if($mas_alto_por_agosto == ""){//tiempo mas alto
			$mas_alto_por_agosto = $t_real[0];
			}else{
					if($t_real[0] > $mas_alto_por_agosto){
						$mas_bajo_por_agosto = $t_real[0];
						}
				}//FIN tiempo mas alto
			
			}
			//fin agosto
			
			//sep
		if($_SESSION["ses_ano"]."-"."09" == $ano_mes_compara){
			$cuantos_por_sep = $cuantos_por_sep+1;//numero de procesos			
			$total_por_sep = $total_por_sep +$t_real[0];//dias totales gastados			
			if($mas_bajo_por_sep == ""){//tiempo mas bajo
			$mas_bajo_por_sep = $t_real[0];
			}else{
					if($t_real[0] < $mas_bajo_por_sep){
						$mas_bajo_por_sep = $t_real[0];
						}
				}//FIN tiempo mas bajo
				
				if($mas_alto_por_sep == ""){//tiempo mas alto
			$mas_alto_por_sep = $t_real[0];
			}else{
					if($t_real[0] > $mas_alto_por_sep){
						$mas_bajo_por_sep = $t_real[0];
						}
				}//FIN tiempo mas alto
			
			}
			//fin sep
			
			//oct
		if($_SESSION["ses_ano"]."-"."10" == $ano_mes_compara){
			$cuantos_por_oct = $cuantos_por_oct+1;//numero de procesos			
			$total_por_oct = $total_por_oct +$t_real[0];//dias totales gastados			
			if($mas_bajo_por_oct == ""){//tiempo mas bajo
			$mas_bajo_por_oct = $t_real[0];
			}else{
					if($t_real[0] < $mas_bajo_por_oct){
						$mas_bajo_por_oct = $t_real[0];
						}
				}//FIN tiempo mas bajo
				
				if($mas_alto_por_oct == ""){//tiempo mas alto
			$mas_alto_por_oct = $t_real[0];
			}else{
					if($t_real[0] > $mas_alto_por_oct){
						$mas_bajo_por_oct = $t_real[0];
						}
				}//FIN tiempo mas alto
			
			}
			//fin oct
			
			//nov
		if($_SESSION["ses_ano"]."-"."11" == $ano_mes_compara){
			$cuantos_por_nov = $cuantos_por_nov+1;//numero de procesos			
			$total_por_nov = $total_por_nov +$t_real[0];//dias totales gastados			
			if($mas_bajo_por_nov == ""){//tiempo mas bajo
			$mas_bajo_por_nov = $t_real[0];
			}else{
					if($t_real[0] < $mas_bajo_por_nov){
						$mas_bajo_por_nov = $t_real[0];
						}
				}//FIN tiempo mas bajo
				
				if($mas_alto_por_nov == ""){//tiempo mas alto
			$mas_alto_por_nov = $t_real[0];
			}else{
					if($t_real[0] > $mas_alto_por_nov){
						$mas_bajo_por_nov = $t_real[0];
						}
				}//FIN tiempo mas alto
			
			}
			//fin nov
			
			//dic
		if($_SESSION["ses_ano"]."-"."12" == $ano_mes_compara){
			$cuantos_por_dic = $cuantos_por_dic+1;//numero de procesos			
			$total_por_dic = $total_por_dic +$t_real[0];//dias totales gastados			
			if($mas_bajo_por_dic == ""){//tiempo mas bajo
			$mas_bajo_por_dic = $t_real[0];
			}else{
					if($t_real[0] < $mas_bajo_por_dic){
						$mas_bajo_por_dic = $t_real[0];
						}
				}//FIN tiempo mas bajo
				
				if($mas_alto_por_dic == ""){//tiempo mas alto
			$mas_alto_por_dic = $t_real[0];
			}else{
					if($t_real[0] > $mas_alto_por_dic){
						$mas_bajo_por_dic = $t_real[0];
						}
				}//FIN tiempo mas alto
			
			}
			//fin dic
			
			
		}// fin while
		
	if($mas_bajo_por_enero == ""){$mas_bajo_por_enero=0;};
	if($mas_bajo_por_febrero == ""){$mas_bajo_por_febrero=0;};
	if($mas_bajo_por_marzo == ""){$mas_bajo_por_marzo=0;};
	if($mas_bajo_por_abril == ""){$mas_bajo_por_abril=0;};
	if($mas_bajo_por_mayo == ""){$mas_bajo_por_mayo=0;};
	if($mas_bajo_por_junio == ""){$mas_bajo_por_junio=0;};
	if($mas_bajo_por_julio == ""){$mas_bajo_por_julio=0;};
	if($mas_bajo_por_agosto == ""){$mas_bajo_por_agosto=0;};
	if($mas_bajo_por_sep == ""){$mas_bajo_por_sep=0;};
	if($mas_bajo_por_oct == ""){$mas_bajo_por_oct=0;};
	if($mas_bajo_por_nov == ""){$mas_bajo_por_nov=0;};
	if($mas_bajo_por_dic == ""){$mas_bajo_por_dic=0;};
	
?>
<dataset seriesName='Dias Real Promedio' color='0033FF' anchorBorderColor='0033FF' anchorBgColor='FFFFFF'>
	<set value='' />
	  <set value='<?=$total_por_enero/$cuantos_por_enero+0?>' /> 
      <set value='<?=$total_por_febrero/$cuantos_por_febrero+0?>' /> 
	  <set value='<?=$total_por_marzo/$cuantos_por_marzo+0?>' /> 
      <set value='<?=$total_por_abril/$cuantos_por_abril+0?>' /> 
	  <set value='<?=$total_por_mayo/$cuantos_por_mayo+0?>' /> 
      <set value='<?=$total_por_junio/$cuantos_por_junio+0?>' /> 
	  <set value='<?=$total_por_julio/$cuantos_por_julio+0?>' /> 
      <set value='<?=$total_por_agosto/$cuantos_por_agosto+0?>' /> 
	  <set value='<?=$total_por_sep/$cuantos_por_sep+0?>' /> 
      <set value='<?=$total_por_oct/$cuantos_por_oct+0?>' /> 
	  <set value='<?=$total_por_nov/$cuantos_por_nov+0?>' /> 
      <set value='<?=$total_por_dic/$cuantos_por_dic+0?>' />
	  <set value='' />
      
</dataset>

<dataset seriesName='Dias Real mas Bajo' color='006600' anchorBorderColor='006600' anchorBgColor='FFFFFF'>
	<set value='' />
	<set value='<?=$mas_bajo_por_enero?>' /> 
      <set value='<?=$mas_bajo_por_febrero?>' /> 
	  <set value='<?=$mas_bajo_por_marzo?>' /> 
      <set value='<?=$mas_bajo_por_abril?>' /> 
	  <set value='<?=$mas_bajo_por_mayo?>' /> 
      <set value='<?=$mas_bajo_por_junio?>' /> 
	  <set value='<?=$mas_bajo_por_julio?>' /> 
      <set value='<?=$mas_bajo_por_agosto?>' /> 
	  <set value='<?=$mas_bajo_por_sep?>' /> 
      <set value='<?=$mas_bajo_por_oct?>' /> 
	  <set value='<?=$mas_bajo_por_nov?>' /> 
      <set value='<?=$mas_bajo_por_dic?>' /> 
	  <set value='' />
</dataset>

<dataset seriesName='Dias Real mas Alto' color='FF0000' anchorBorderColor='FF0000' anchorBgColor='FFFFFF'>
	<set value='' />
	 <set value='<?=$mas_alto_por_enero?>' /> 
      <set value='<?=$mas_alto_por_febrero?>' /> 
	  <set value='<?=$mas_alto_por_marzo?>' /> 
      <set value='<?=$mas_alto_por_abril?>' /> 
	  <set value='<?=$mas_alto_por_mayo?>' /> 
      <set value='<?=$mas_alto_por_junio?>' /> 
	  <set value='<?=$mas_alto_por_julio?>' /> 
      <set value='<?=$mas_alto_por_agosto?>' /> 
	  <set value='<?=$mas_alto_por_sep?>' /> 
      <set value='<?=$mas_alto_por_oct?>' /> 
	  <set value='<?=$mas_alto_por_nov?>' /> 
      <set value='<?=$mas_alto_por_dic?>' />
	  <set value='' />
</dataset>

</graph>
