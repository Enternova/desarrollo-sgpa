<? include("../../librerias/lib/@session.php"); 
	include "../../librerias/chart/FusionCharts.php";
	include "../../librerias/chart/Functions.php";	
	

	$fecha_hoy = date("Y-m-d");
	
	$filtro_aplica = "Todos";
	
	$filtro_aplica = "Todos";
	
				//tp_tarifa = 1 // Contractuales
			   //tp_tarifa = 2 // Modificaciones
			   //tp_tarifa = 3 // nuevas
			   //tp_tarifa = 0 // todas
			   
			   //tarifas_usadas = 1 // solo tarifas usadas
			   //tarifas_usadas = 0 // todas

	$_SESSION["tp_tarifa_bus_rep"] = $_GET["tp_tarifa"];
	$_SESSION["tarifas_usadas"] = $_GET["tarifas_usadas"];

	
	if($_SESSION["tarifas_usadas"] == 1){
		$sql_completa = " and tarifa_usada>0";
	}
	if($_SESSION["tp_tarifa_bus_rep"] > 0){
		$sql_completa.= " and tipo_creacion_modifica =  ".$_SESSION["tp_tarifa_bus_rep"];
	}

	$_SESSION["comple_filtro3"] = $_SESSION["comple_filtro2"].$sql_completa ;



//	$sel_area = traer_fila_Row()

	
	?><head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" src="../../librerias/chart/FusionCharts.js"></script>	




<style>

body {
	
	background:#FFFFFF;
}

</style>
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Roboto:100" rel="stylesheet">
<script type="text/javascript" src="../librerias/materialize/js/materialize.js"></script>
<style>
	.div-text {
		width: 90%;
		margin-left: 5%;
		height: auto;
	}
	.div-custom-red2{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #E0766B;
	}
	.div-custom-yellow2{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #FFBE5E;
	}
	.div-custom-green2{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #6AC46F;
	}
	.font{
		font-family: 'roboto';
	}
	.f14{
		font-size: 12pt;
	}
	.f12{
		font-size: 9pt;
		font-weight: 900 !important;
	}
	.f10{
		font-size: 8pt;
		color: #000;
	}
	.table-custom{
		width: 98%;
		margin-left: 1%;
		border-collapse:collapse;
	}
	.th-custom{
		/*-webkit-box-shadow: 0 9px 4px #777;
		-moz-box-shadow: 0 9px 4px #777;
		box-shadow: 0 9px 4px #777;*/
		background: transparent;
		color: #FFF;		
		font-weight: 900;
	}
	.td-title-red{
		background: #FE5151;
		color: #FFF;
	}
	.td-title-yellow{
		background: #FEC007;
		color: #FFF;
	}
	.td-title-green{
		background: #4BAE4F;
		color: #FFF;
	}
	.custom-red2{
		color: #FF3333;
	}
	.custom-yellow2{
		color: #E2B700;
	}
	.custom-green2{
		color: #009900;
	}
	.border{
		border: 2px solid #FFF;
	}
	.transparent{
		background: transparent;
	}
</style>
</head>


<body>

<table width="100%" border="0" class="tabla_blanca_report_tarifas">

  <tr>
    <td align="left"><div class="titulos_secciones font" style="font-size:16pt !important; font-weight: 900 !important;">Detalle de tarifas del &aacute;rea <?=saca_nombre_lista($g12,$_SESSION["id_area_bus_rep"],'nombre','t1_area_id')?>, en el rango de vigencia <?=$_SESSION["fecha_inicial_bus_rep"]?> y hasta <?=$_SESSION["fecha_hasta_bus_rep"]?></div></td>
  </tr>
  <tr>
    <td align="center">
    
        <div id="indicador_1" align="center"> Etapas </div>
          
    </td>
  </tr>
  <tr>
    <td align="center"><iframe name="" id="" frameborder="0" width="100%" height="0"></iframe></td>
  </tr>
</table>


</body>
</html>

 <script type="text/javascript">
		   
		   
		   function carga_grafica_lista_tarifas(id_area){
	
		window.parent.document.getElementById('grafica_detalle_tipo_tarifa').src="variacion_tarifas_detalle_area.php?id_area="+id_area
	
}
		   
	   

		   var chart = new FusionCharts("../../librerias/chart/FCF_MSColumn2D.swf", "ChartId", "900", "450");
		   chart.setDataURL("../../librerias/chart/contenidos/reporte_tarifas/indicador2.php");		   
		   chart.render("indicador_1");
		   
		  

		   
		</script>	

