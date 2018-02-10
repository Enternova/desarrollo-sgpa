<? include("../../lib/@session.php"); ?>

<graph caption='' PYAxisName='Numero de Dias' SYAxisName=''
 numberPrefix='' showvalues='0'  numDivLines='4' formatNumberScale='0' decimalPrecision='0'
anchorSides='10' anchorRadius='3' anchorBorderColor='009900' rotateNames='1' yaxisminvalue='0' yaxismaxvalue='1000'  baseFontSize="10" showAlternateHGridColor='1' AlternateHGridColor='FFDECE' divLineColor='cccccc'>
<categories>
<category name='12 meses antes' /> 
<category name='11 meses antes' /> 
<category name='10 meses antes' /> 
<category name='9 meses antes' /> 
<category name='8 meses antes' /> 
<category name='7 meses antes' /> 
<category name='6 meses antes' /> 
<category name='5 meses antes' /> 
<category name='4 meses antes' /> 
<category name='3 meses antes' /> 
<category name='2 meses antes' /> 
<category name='1 mes antes' /> 
<category name='Mes Estimado' />
<category name='1 mes despues' />  
<category name='2 meses despues' />  
<category name='3 meses despues' />  
<category name='4 meses despues' />  
<category name='5 meses despues' />  
<category name='6 meses despues' />  
<category name='7 meses despues' />  
<category name='8 meses despues' />  
<category name='9 meses despues' />  
<category name='10 meses despues' />  
<category name='11 meses despues' />  
<category name='12 meses despues' />  
</categories>

<?

	$sele_ind_9 = query_db("select fecha_se_requiere, fecha_finaliza_real from $vin_2 where id_pecc <> 1");
	while($sel_in = traer_fila_db($sele_ind_9)){
		$cuantos_meses_diferencia = $sel_in[0];
		}
	
	

?>
<dataset seriesName='Mes Estimado de Inicio' color='EA1000' showValues='0' >
<set value='' />
<set value='' />
<set value='' />
<set value='' />
<set value='' />
<set value='' />
<set value='' />
<set value='' />
<set value='' />
<set value='' />
<set value='' />
<set value='' />
<set value='50' />
<set value='' />
<set value='' />
<set value='' />
<set value='' />
<set value='' />
<set value='' />
<set value='' />
<set value='' />
<set value='' />
<set value='' />
<set value='' />
<set value='' />
</dataset>

<dataset seriesName='No. de Procesos Iniciados' color='000000' showValues='0' parentYAxis='S' >
<set value='0' />
<set value='0' />
<set value='0' />
<set value='0' />
<set value='0' />
<set value='0' />
<set value='0' />
<set value='0' />
<set value='0' />
<set value='0' />
<set value='0' />
<set value='20' />
<set value='10' />
<set value='5' />
<set value='0' />
<set value='0' />
<set value='0' />
<set value='0' />
<set value='0' />
<set value='0' />
<set value='0' />
<set value='0' />
<set value='0' />
<set value='0' />
<set value='0' />
</dataset>
</graph>