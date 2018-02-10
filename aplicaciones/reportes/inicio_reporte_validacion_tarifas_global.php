<?
include("../../librerias/lib/@session.php");
$ids=explode(",", $_SESSION["id_cantidad_areas"]);

//echo sizeof($ids)." el tamaño es este <br>";
//echo $_SESSION["id_cantidad_areas"]." ESTE ES EL AREA";
//echo $_SESSION["id_cantidad_gerente"]." ESTE ES EL GERENTE";
?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="X-UA-Compatible" content="IE=9">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Roboto:100" rel="stylesheet">
	<?  $u_agent = $_SERVER['HTTP_USER_AGENT'];//detectar navegador para incluir los estilos correspondientes
   //echo $u_agent;

	$nombre_ie_css = "chips-ms12";

	
    if(preg_match('/MSIE/i',$u_agent) || preg_match('/\Trident\b/',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { ?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/<?=$nombre_ie_css?>.css?version=<?=$hora?>" />  
    <?}elseif(preg_match('/\bEdge\b/',$u_agent)) 
    { ?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/<?=$nombre_ie_css?>.css?version=<?=$hora?>" />  
    <?}elseif(preg_match('/Firefox/i',$u_agent))
    {?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/chips-moz.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/chips-webkit.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Safari/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/chips-safari.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Opera/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/chips-opera.css?version=<?=$hora?>" />  
    <? } 
    else  { 
		?>
         <link rel="stylesheet" type="text/css" href="../../css/chips/chips-webkit.css?version=<?=$hora?>" /> 
    <?
    }
	
?>	
	<link rel="stylesheet" type="text/css" href="../../librerias/materialize/css/materialize.css?version=<?=$hora?>">
	<style>
		body, input, label, table, tr, td, th {
		      font-family: 'Roboto' !important;
		      font-weight: 900;
		}
		.label_for{
		      font-family: 'Roboto' !important;
		      font-weight: 900;
		}
		th, input, label{
		      font-size: 14pt !important;
		      font-family: 'Roboto' !important;
		      font-weight: 900;
		}
		.po_tabla_principal{
			
			border-radius: 10px 10px 10px 10px !important;
		-moz-border-radius: 10px 10px 10px 10px !important;
		-webkit-border-radius: 10px 10px 10px 10px !important;
		border: 0px solid #cccccc !important;
			
			-webkit-box-shadow: 10px 10px 23px -13px rgba(0,0,0,0.75) !important;
		-moz-box-shadow: 10px 10px 23px -13px rgba(0,0,0,0.75) !important;
		box-shadow: 10px 10px 23px -13px rgba(0,0,0,0.75) !important;
			
			border: 1px solid #CCCCCC !important;
			
		}
		.container{
		    text-align:center
		}
		.izquierda{
			display:inline-block;
		    float: left;
		    background:blue
		}
		.derecha{
		    float: right;
		    background:red
		}
		.center{
		    background:green;
		}
	</style>
	
</head>
<body onload="muestra_area();">
	
	<nav class="nav-extended" style="background: #229BFF !important;">
		<ul class="tabs tabs-transparent">
			<li class="tab"><a onclick="muestra_area();"><i class="material-icons left">&#xE01D;</i>Area</a></li>
			<li class="tab"><a onclick="muestra_gerente();"><i class="material-icons left">&#xE01D;</i>Gerente</a></li>
			<li class="tab"><a onclick="muestra_proveedor();"><i class="material-icons left">&#xE01D;</i>Proveedor</a></li>
		</ul>
	</nav>
	<iframe id="iframe_area" src="../../librerias/chart/contenidos/reporte_tarifas/indicador1_google_charts.php" frameborder="0" style="display: none; width: 100%; height: 2600px; border: none;"></iframe>
	<?

		if($_SESSION["abre_grafica3"] == "SI"){//si abre la grafica de gerentes
	?>
	<iframe id="iframe_gerente" src="../../librerias/chart/contenidos/reporte_tarifas/indicador3_google_charts.php?muestra=si" frameborder="0" style="display: none; width: 100%; height: 4000px; border: none;"></iframe>
	<?
		}else{ ?>
	<iframe id="iframe_gerente" src="../../librerias/chart/contenidos/reporte_tarifas/indicador3_google_charts.php?muestra=no" frameborder="0" style="display: none; width: 100%; height: 4000px; border: none;"></iframe>

	<?	}
	?>
	<?
		if($_SESSION["abre_grafica2"] == "SI"){//si abre la graafica de proveedores
	?>
	<iframe id="iframe_proveedor" src="../../librerias/chart/contenidos/reporte_tarifas/indicador2_google_charts.php?muestra=si" frameborder="0" style="display: none; width: 100%; height: 5400px; border: none;"></iframe>
	<?
		}else{ ?>
	<iframe id="iframe_proveedor" src="../../librerias/chart/contenidos/reporte_tarifas/indicador2_google_charts.php?muestra=no" frameborder="0" style="display: none; width: 100%; height: 2600px; border: none;"></iframe>

	<?	}
	?>	
	<script type="text/javascript" src="../../librerias/jquery/jquery2.js?version<?=$version_js?>=<?=$version_js?>"></script>
	<script type="text/javascript" src="../../librerias/ajax/ajax_01.js?version<?=$version_js?>=<?=$version_js?>"></script>
	<script type="text/javascript" src="../../librerias/materialize/js/materialize.min.js?version<?=$version_js?>=<?=$version_js?>"></script>
	<script type="text/javascript" src="../../librerias/materialize/js/pickdate_custom.js?version<?=$version_js?>=<?=$version_js?>"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		   // $('.modal').modal();
		   // $('select').material_select();
		});

		/******
		Unidades de Medida YA
		Grupo de Compras YA
		Retenci&oacute;n de Garant&iacute;as YA
		Centro Log&iacute;stico YA
		Grupo de Articulos
		Indicador de Presupuesto
		Cat&aacute;logo de Servicios
		******/
        function muestra_gerente(){
        	$('#iframe_gerente').css('display', 'block');
        	//document.getElementById('iframe_gerente').contentWindow.location.reload(true);
        	$('#iframe_proveedor').css('display', 'none');
        	$('#iframe_area').css('display', 'none');
        }
        function muestra_proveedor(){
        	$('#iframe_proveedor').css('display', 'block');
        	//document.getElementById('iframe_gerente').contentWindow.location.reload(true);
        	$('#iframe_gerente').css('display', 'none');
        	$('#iframe_area').css('display', 'none');
        }
        function muestra_area(){
        	$('#iframe_area').css('display', 'block');
        	//document.getElementById('iframe_gerente').contentWindow.location.reload(true);
        	$('#iframe_gerente').css('display', 'none');
        	$('#iframe_proveedor').css('display', 'none');
			
        }
        function oculta_carga(){
        	window.parent.oculta_cargando1()
        	//window.parent.document.getElementById("cargando_pecc").style.display = "none"
        }
         function muestra_carga(){
        	window.parent.muestra_cargando1()
        	//window.parent.document.getElementById("cargando_pecc").style.display = "none"
        }
		
		
    </script>
</body>
</html>
  