<? include("../../lib/@session.php"); 

$sele_tiempo_ideal = traer_fila_row(query_db("select tiempo_del_nivel from $vin_3 where t1_tipo_contratacion_id = 1 and t1_tipo_proceso_id= ".$_SESSION["ses_tipo_proceso"]." and aprobacion_socios = ".$_SESSION["ses_socios"]." and aprobacion_comite = ".$_SESSION["ses_comite_add"]." and aplica_sondeo = ".$_SESSION["ses_sondeo"]." and monto_minimo < ".$_SESSION["ses_montos"]." and monto_maximo >= ".$_SESSION["ses_montos"].""));

	

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
	
     <set value='90' />
	  <set value='90' /> 
      <set value='90' /> 
	  <set value='90' /> 
      <set value='90' /> 
	  <set value='90' /> 
      <set value='90' /> 
	  <set value='90' /> 
      <set value='90' /> 
	  <set value='90' /> 
      <set value='90' /> 
	  <set value='90' /> 
      <set value='90' /> 
	<set value='90' /> 
	</dataset>
    
<dataset seriesName='Dias Real Promedio' color='0033FF' anchorBorderColor='0033FF' anchorBgColor='FFFFFF'>
	<set value='' />
          <set value='50' /> 
          <set value='55' /> 
          <set value='83' /> 
          <set value='78' /> 
          <set value='101' /> 
          <set value='59' /> 
          <set value='53' /> 
          <set value='67' /> 
          <set value='73' /> 
          <set value='72' /> 
          <set value='56' /> 
          <set value='65' /> 
	  <set value='' />
      
</dataset>

<dataset seriesName='Dias Real mas Bajo' color='006600' anchorBorderColor='006600' anchorBgColor='FFFFFF'>
	<set value='' />
		<set value='20' /> 
          <set value='15' /> 
          <set value='13' /> 
          <set value='18' /> 
          <set value='21' /> 
          <set value='19' /> 
          <set value='13' /> 
          <set value='7' /> 
          <set value='3' /> 
          <set value='12' /> 
          <set value='16' /> 
          <set value='15' /> 
	  <set value='' />
</dataset>

<dataset seriesName='Dias Real mas Alto' color='FF0000' anchorBorderColor='FF0000' anchorBgColor='FFFFFF'>
	<set value='' />
	<set value='50' /> 
          <set value='85' /> 
          <set value='123' /> 
          <set value='98' /> 
          <set value='153' /> 
          <set value='89' /> 
          <set value='93' /> 
          <set value='87' /> 
          <set value='103' /> 
          <set value='122' /> 
          <set value='86' /> 
          <set value='85' /> 
	  <set value='' />
</dataset>

</graph>
