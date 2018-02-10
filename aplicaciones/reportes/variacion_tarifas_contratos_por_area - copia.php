<? include("../../librerias/lib/@session.php"); 
	include "../../librerias/chart/FusionCharts.php";
	include "../../librerias/chart/Functions.php";	
	
	$fecha_hoy = date("Y-m-d");
	
	$filtro_aplica = "Todos";
	
	$filtro_aplica = "Todos";
	

		
	$_SESSION["comple_filtro"] = " where fecha_inicio_vigencia >= '".$_GET["fecha_inicial"]."' and (fecha_fin_vigencia <= '".$_GET["fecha_hasta"]."' or fecha_fin_vigencia ='0000-00-00' or fecha_fin_vigencia is null)";

	
$_SESSION["fecha_inicial_bus_rep"] = $_GET["fecha_inicial"];
$_SESSION["fecha_hasta_bus_rep"] = $_GET["fecha_hasta"];

	
	?><head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../../librerias/chart/FusionCharts.js"></script>	




<style>

body {
	
	background:#FFFFFF;
}

</style>
</head>


<body>

<table width="100%" border="0" class="tabla_blanca_report_tarifas">

  <tr>
    <td align="center">
    
        <div id="indicador_1" align="center"> Etapas </div>
          
    </td>
  </tr>
  <tr>
    <td align="center"><iframe name="grafica_detalle_area" id="grafica_detalle_area" frameborder="0" width="100%" height="550px"></iframe></td>
  </tr>
  <tr>
    <td align="center"><iframe name="grafica_detalle_tipo_tarifa" id="grafica_detalle_tipo_tarifa" frameborder="0" width="100%" height="550px"></iframe></td>
  </tr>
</table>


</body>
</html>

 <script type="text/javascript">
		   
		   
		   function contratos_exepcion_graf(id_area){
	
	alert("aca se carga los contratos segun el area "+id_area)
	
}
	 function carga_grafica_detalle_area(id_area){
	
	document.getElementById('grafica_detalle_area').src="variacion_tarifas_detalle_area.php?id_area="+id_area
	
}
		   
		   

		   var chart = new FusionCharts("../../librerias/chart/FCF_MSColumn2D.swf", "ChartId", "900", "450");
		   chart.setDataURL("../../librerias/chart/contenidos/reporte_tarifas/indicador1.php");		   
		   chart.render("indicador_1");
		   
		  

		   
		</script>	

