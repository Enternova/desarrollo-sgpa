<? include("../../librerias/lib/@session.php"); 
	include "../../librerias/chart/FusionCharts.php";
	include "../../librerias/chart/Functions.php";	
	error_reporting(E_ALL);  // Líneas para mostart errores
	ini_set('display_errors', '1');  // Líneas para mostart errores

$_SESSION["comple_filtro"]="";
$_SESSION["comple_filtro_exepcion"]="";
	$fecha_hoy = date("Y-m-d");
	
	$filtro_aplica = "Todos";
	
	$filtro_aplica = "Todos";

$sql_completa_query="";
	
$titulo_filtro_fechas ="";
$titulo_filtro_contrato="";
$titulo_filtro_proveedor="";
$titulo_filtro_gerente="";
$titulo_filtro_area="";
$sql_completa_query_fechas="";
	
$_SESSION["abre_grafica1"] = "SI";//Area
$_SESSION["abre_grafica3"] = "NO";//Gernte
$_SESSION["abre_grafica2"] = "NO";//proveedor
			
	if($_GET["ids_areas_sel"] != ""){
		$area_usuaria_bus_rep = " and t1_area_id in (0 ".$_GET["ids_areas_sel"].")";
		$cuantas_areas=0;
		$sel_Areas_filtro = query_db("select nombre from t1_area where t1_area_id >0  ".$area_usuaria_bus_rep);
		while($sel_area_fil = traer_fila_db($sel_Areas_filtro)){
			$cuantas_areas=$cuantas_areas+1;
			
			$titulo_filtro_area.=" ".$sel_area_fil[0].", ";
			
		}
		if($cuantas_areas<=3 and $cuantas_areas>0){
		$_SESSION["abre_grafica3"] = "SI";//Gernte
		}
		$titulo_filtro_area =  "<br> <span style='font-size:14pt'>&nbsp;&#9679;Area(s) ".$titulo_filtro_area."</span>";
	}else{
		$area_usuaria_bus_rep = "";
		
	}
	
	
	
	

	
	if(($_GET["gerente"]!="" and $_GET["gerente"]!=" " and $_GET["gerente"]!=0)){
		$sql_completa_query.=" and id_gerente =".$_GET["gerente"];
		$titulo_filtro_gerente= "<br> <span style='font-size:14pt'>&nbsp;&#9679;Gerente de Contrato ".saca_nombre_lista($g1,$_GET["gerente"],'nombre_administrador','us_id',0)."</span>";
		$_SESSION["abre_grafica3"] = "SI";//Gernte
		$_SESSION["abre_grafica2"] = "SI";//proveedor
		}
		
	if(($_GET["contratista"]!="" and $_GET["contratista"]!=" " and $_GET["contratista"]!=0)){
		$sql_completa_query.=" and t1_proveedor_id =".$_GET["contratista"];
		$titulo_filtro_proveedor= "<br> <span style='font-size:14pt'>&nbsp;&#9679;Proveedor ".saca_nombre_lista("t1_proveedor",$_GET["contratista"],'razon_social','t1_proveedor_id',0)."</span>";
		$_SESSION["abre_grafica3"] = "SI";//Gernte
		$_SESSION["abre_grafica2"] = "SI";//proveedor
		}
	
	if($_GET["contrato"]!="" and $_GET["contrato"]!=" "){
		//echo "entro <br>";
		$_SESSION["contrato_busca_rep"]=$_GET["contrato"];
		$sql_completa_query.=" and contrato like '%".$_GET["contrato"]."%'";
		$titulo_filtro_contrato= "<br> <span style='font-size:14pt'>&nbsp;&#9679;Contrato ".$_GET["contrato"]."</span>";
		$_SESSION["abre_grafica3"] = "SI";//Gernte
		$_SESSION["abre_grafica2"] = "SI";//proveedor
		}
		
			
if($_GET["fecha_hasta"] != "" and $_GET["fecha_inicial"]!=""){
	$sql_completa_query_fechas =" and fecha_inicio_vigencia <= '".$_GET["fecha_hasta"]."' and (fecha_fin_vigencia >= '".$_GET["fecha_inicial"]."' or fecha_fin_vigencia ='0000-00-00' or fecha_fin_vigencia is null)";
	
	 $titulo_filtro_fechas= "<br> <span style='font-size:14pt'>Rango de Vigencia Desde ".$_GET["fecha_inicial"]." - Hasta ".$_GET["fecha_hasta"]."</span>";
	
}
	$_SESSION["comple_filtro"] = " where estado_contrato not in (1,50, 49) and t6_tarifas_estados_tarifas_id in (1,7)  ".$area_usuaria_bus_rep.$sql_completa_query.$sql_completa_query_fechas;
	
	 $_SESSION["comple_filtro_exepcion"] = " where estado_contrato not in (50) ".$area_usuaria_bus_rep.$sql_completa_query;
	
	

	


$_SESSION["titulo_sub1_area"]="";
$_SESSION["titulo_sub1_gerente"]="";
$_SESSION["titulo_sub1_proveedor"]="";
	
$_SESSION["fecha_inicial_bus_rep"] = $_GET["fecha_inicial"];
$_SESSION["fecha_hasta_bus_rep"] = $_GET["fecha_hasta"];

	//echo $_SESSION["comple_filtro"];



/*titulos filtros*/


$_SESSION["titulo_filtro1"] = "";
$_SESSION["titulo_filtro1"] = $titulo_filtro_fechas.$titulo_filtro_contrato.$titulo_filtro_gerente.$titulo_filtro_proveedor.$titulo_filtro_area;

$_SESSION["titulo_filtro3"] = "";
$_SESSION["titulo_filtro3"] = $titulo_filtro_fechas.$titulo_filtro_contrato.$titulo_filtro_gerente.$titulo_filtro_proveedor.$titulo_filtro_area;

$_SESSION["titulo_filtro2"] = "";
$_SESSION["titulo_filtro2"] = $titulo_filtro_fechas.$titulo_filtro_contrato.$titulo_filtro_gerente.$titulo_filtro_proveedor.$titulo_filtro_area;
/*Fin Titulos Filtros*/




	?>
<!DOCTYPE html>
<html lang="en">
<head>
	<script>
	function oculta_cargando1(){
		window.parent.document.getElementById("cargando_pecc").style.display = "none"
		//window.parent.oculta_cargando();
	}
	function muestra_cargando1(){
		window.parent.document.getElementById("cargando_pecc").style.display = "block"
		//window.parent.oculta_cargando();
	}
		
	
		
	function abre_ventana_excel(grafica,columna, tipo){//ferney aqui va la funcion de abrir la ventana
			grafica=grafica.replace(/^\s+|\s+$/g, "")//se quitan los espacios para que no halla problemas para pasarlos por post
			grafica=grafica.replace(/ /g, "")//se quitan los espacios para que no halla problemas para pasarlos por post
			columna=columna.replace(/^\s+|\s+$/g, "")//se quitan los espacios para que no halla problemas para pasarlos por post
			columna=columna.replace(/ /g, "")//se quitan los espacios para que no halla problemas para pasarlos por post
			//alert(grafica+"---"+columna)
			var id_grafica = '';
					
				
					id_grafica = tipo+'---'+grafica+'---'+columna					
			
				
				
			var imprime = "";
		
		//var confi = confirm("Esta aca");
		
		//if(confi){
			abrir_ventana_excel_2(id_grafica)
		//}
						
			//window.parent.muestra_alerta_general_solo_texto("abrir_ventana_excel(-comillas-"+id_grafica+"-comillas-)", "Descargar Detalle", "Esta opción descarga el detalle de esta gráfica a Excel, desea continuar?"+imprime, 40, 5, 12)
			
			
		}
		
		function abrir_ventana_excel_2(grafica) {
			var opciones="toolbar=no, location=no, directories=no, status=no, menubar=no, scrollbars=yes, resizable=yes, width=800, height=365, top=85, left=140";
			window.open("../../../../aplicaciones/reportes/reporte_variaciones_global_excel.php?tp_grafica="+grafica,"",opciones);
			
	}
</script>
</head>
<body>
<iframe src="inicio_reporte_validacion_tarifas_global.php" id="iframe" frameborder="0" style="display: block; width: 100%; height: 12900px; border: none;"></iframe>
</body>
</html>

