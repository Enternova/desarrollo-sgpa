<?
//error_reporting(E_ALL);  // Líneas para mostart errores
//ini_set('display_errors', '1');  // Líneas para mostart errores
include("../../librerias/lib/@session.php");
include('../../librerias/php/funciones_html.php');
//echo $_SESSION["id_us_session"];
$onload="";
if($_GET["function1"]){
	$onload.=$_GET["function1"]."();";
}
if($_GET["function2"]){//funcion para obtener las variables de las funciones que vienen del iframe
	if($_GET["function2"]=="muestra_historico_gestion" or $_GET["function2"]=="definicion_criterio_evaluacion" or $_GET["function2"]=="aprobacion_criterio_evaluacion"){
		$onload.=$_GET["function2"]."('".$_GET["function3"]."');";
	}else{
		$onload.=$_GET["function2"]."();";
	}
}
if($_GET["function2"]!="muestra_historico_gestion" and $_GET["function2"]!="definicion_criterio_evaluacion" and $_GET["function2"]!="aprobacion_criterio_evaluacion"){
	if($_GET["function3"]){
		$onload.=$_GET["function3"]."();";
	}
}
if($_GET["function4"]){
	if($_GET["function4"]=="muestra_modal_configurar_aspecto"){
		$onload.="setTimeout(function(){ ".$_GET["function4"]."('".$_GET["function3"]."');}, 500);";
	}else{
		$onload.=$_GET["function4"]."();";
	}
}



if($onload==""){
	$onload="muestra_historico_desempeno()";
}
//echo $onload;

?>

<!DOCTYPE html>
<html lang="es">
<head>
	<title>Document</title>
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="X-UA-Compatible" content="IE=10">
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
	<link rel="stylesheet" type="text/css" href="../../librerias/materialize/css/hocolTables.min.css?version=<?=$hora?>">
	<link rel="stylesheet" type="text/css" href="../../css/desempeno/style_desempeno.css?version<?=$version_js?>=<?=$version_js?>">
	<script type="text/javascript" src="../../librerias/jquery/jquery-3.2.1.min.js?version<?=$version_js?>=<?=$version_js?>"></script>
	<script type="text/javascript" src="../../librerias/chart/chrat-loader.js"></script>
	<script type="text/javascript" src="../../librerias/js/desempeno/desempeno_admin_v1.js?version<?=$version_js?>=<?=$version_js?>"></script>
	<script>
		function abrir_ventana(pagina) {
			var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=800, height=365, top=85, left=140";
			window.open(pagina,"",opciones);
		}
	/**** PARA LA GRAFICA DEL PROVEEDOR ****/
	google.charts.load('current', {packages: ['corechart', 'bar']});
	function grafica_proveedor(punt1, punt2){
		var pasa=punt1;
			google.charts.setOnLoadCallback(grafica);
		function grafica(pasa){
			$.post('grafica_proveedor_resultado.php', {punt1: punt1, punt2:punt2}, function(data5) {//se pasa por post la variable para esperar la respuesta con los datos para armar la otra gráfica
				//console.log(data5)
				var data2 = new google.visualization.DataTable();
				data2.addColumn('string', 'EVALUACION');
				data2.addColumn('number', 'PUNTOS');
				var campos=data5.split("-col-")
				for(var i=0; i<(campos.length); i++){
					if(punt2==1){//si es de contratos
						if(campos[i]=="" || campos[i]==" " || campos[i]==null){
							campos[i]=0;
						}
						if(i==0){
							data2.addRow(["TECNICA", parseFloat(campos[i])]);
						}else if(i==1){
							data2.addRow(["HSSE", parseFloat(campos[i])]);
						}else if(i==2){
							data2.addRow(["ADMINISTRATIVA", parseFloat(campos[i])]);
						}else if(i==3){
							data2.addRow(["TOTAL", parseFloat(campos[i])]);
						}
					}else if(punt2==2){//si es de servicios menores
						if(campos[i]=="" || campos[i]==" " || campos[i]==null){
							campos[i]=0;
						}
						if(i==0){
							data2.addRow(["TECNICA", parseFloat(campos[i])]);
						}else if(i==1){
							data2.addRow(["TOTAL", parseFloat(campos[i])]);
						}
					}
				}
				  var options = {
				colors: ['#739DC8', '#9DBAD8'],
				'width':'10%',
								'height':'60%',
								'left':0,
								bar:{
							groupWidth: "25%"
				},
								'title': 'GRAFICA DE CALIFICACION GENERAL',//se le da el título a la gráfica
				hAxis : { 
							textStyle : {
								fontSize: 10
							}

				},
				'chartArea': {'width': '80%', 'height': '75%'},//el espacio que ocupa la grafica dentro del div
				legend: { position: 'top', textStyle: {fontSize: 10}},//para ubicar los titulos al lado de arriba
				annotations: {
					alwaysOutside: true
				}
				  };
				var chart = new google.visualization.ColumnChart(document.getElementById('grafica_resultado'));
				google.visualization.events.addListener(chart, 'onmouseover', uselessHandler2);
				google.visualization.events.addListener(chart, 'onmouseout', uselessHandler3);
				chart.draw(data2, options);
				function uselessHandler2() {
				$('#grafica_resultado').css('cursor','pointer')
				}  
				function uselessHandler3() {
				$('#grafica_resultado').css('cursor','default')
				}
			});
			
		}
	}
	</script>
	<style>
		body, input, label, table, tr, td, th, #icono_retorna {
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

<body onLoad="<?=$onload?>">
<div id="desempeno">
	<nav class="nav-extended" style="background: #229BFF !important;">
		<ul class="tabs tabs-transparent">
			<li class="tab"><a onclick="muestra_historico_desempeno();">Historico</a></li>
			<li class="tab"><a onclick="muestra_resultado_desempeno();">Resultados</a></li>
			<?
			if($_SESSION["id_us_session"]==17){//sólo si es irma fernandez
			?>
			<li class="tab"><a onclick="muestra_admin_desempeno();">Admin. Criterios</a></li>
			<?
			}
			?>
			<li class="tab" id="icono_retorna"></li>
		</ul>
		
	</nav>
	<div class="container_principal" id="div_historico">
		<div id="carga_admin_pendientes">  
		</div>
		<div id="carga_historico_desempeno">  
		</div>
		<div id="carga_admin_aspectos">  
		</div>
		<div id="carga_aprobacion_criterio_aspectos">
		</div>
		<div id="carga_evaluacion">  
		</div>
		<div id="carga_aprobacion_evaluacion">  
		</div>	
		<div id="carga_modal_configurar_aspecto"></div>
	</div>
	<div class="container_principal" id="div_resultados">
		<div id="cargar_resultados_admin"></div>
		<div id="cargar_resultados_proveedor"></div>
		<div id="cargar_resultados_proveedor_periodo"></div>
		<div id="cargar_detalle_proveedor_periodo"></div>
		<div id="modal_comentario_periodo"></div>
	</div>
	<div class="container_principal" id="div_admin">
		<!-- Modal Structure -->
		<div id="modal1" class="modal" style="z-index: 999;">
			<div class="modal-content">
			<h4>Modal Header</h4>
			<p>A bunch of text</p>
			</div>
			<div class="modal-footer">
			<a onclick="$('#modal1').hide();" class="modal-action modal-close waves-effect waves-green btn-flat ">Agree</a>
			</div>
		</div>
		
		<div class="titulos_secciones" ><h5 id="titlulo_administracion" style="font-size:18pt !important; font-weight: 900 !important;">ADMINISTRACION DE CRITERIOS</h5></div>
		<div class="" style="background: #181818; height: 2px;"></div>
		<div class="row"></div>
		<div class="row">
		<?
			//boton_sin_icono_accion('left', 'CRITERIOS', "carga_criterio_admin()", 'background: #229BFF;', 's12 m6 l3'); //SE QUEDA DESHABLILITAADO POR SUGERENCIA DE MARIA COOCK
			
		?> 
	  	<?
		  	boton_sin_icono_accion('left', 'ASPECTOS', "carga_aspecto_admin()", 'background: #229BFF;', 's12 m6 l3');
		?>
		
		</div>
		
		
		<div id="carga_criterio_admin"></div>
		
		<div id="carga_aspecto_admin"></div>
		<div id="carga_modal"></div>
	</div>
	
</div>
	<div id="cargando"></div>
	<script type="text/javascript" src="../../librerias/materialize/js/materialize.min.js?version<?=$version_js?>=<?=$version_js?>"></script>
	<script type="text/javascript" src="../../librerias/ajax/ajax_02_material_v1.js?version<?=$version_js?>=<?=$version_js?>"></script>
	<script>
		$(document).ready(function() {
			//$('.modal-trigger').leanModal();
			$('.tooltipped').tooltip({delay: 50});
			$('.modal').modal();
		});
	</script>
</body>
</html>