<?
//error_reporting(E_ALL);  // Líneas para mostart errores
//ini_set('display_errors', '1');  // Líneas para mostart errores
include("../../librerias/lib/@session.php");
include('../../librerias/php/funciones_html.php');
$id_proveedor=arreglo_recibe_variables($_GET["p1"]);
$id_evaluador=arreglo_recibe_variables($_GET["p2"]);
$periodo=arreglo_recibe_variables($_GET["p3"]);
$id_proveedor."----".$id_evaluador."----".$periodo;
$sel_res=traer_fila_row(query_db("SELECT id_evaluacion, tipo_documento from dbo.historico_desempeno_resultados() where fecha_periodo_evaluado < '".$periodo."' and id_crea_aspectos=".$id_evaluador." and id_proveedor=".$id_proveedor));


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
	<link rel="stylesheet" type="text/css" href="../../css/desempeno/style_desempeno.css?version=2">
	<script type="text/javascript" src="../../librerias/jquery/jquery-3.2.1.min.js?version<?=$version_js?>=<?=$version_js?>"></script>
	<script type="text/javascript" src="../../librerias/chart/chrat-loader.js"></script>
	<script type="text/javascript" src="../../librerias/js/desempeno/desempeno_admin.js?version=39"></script>
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

<body>
<?
	if($sel_res[0]=="" or $sel_res[0]==" " or $sel_res[0]==NULL){//si el proveedor no tiene evaluaciones previas
	}else{//si el proveedor ya tiene evaluaciones hechas
		if($sel_res[1]==1){
			$select_tabla="select  nombre_aspectos, puntaje_maximo, id_evaluacion FROM vista_t9_servicio_menor where estado_aspecto='1' and fecha_periodo_evaluado < '".$periodo."' and id_crea_aspectos=".$id_evaluador." and id_criterio in(1,2,3) and id_proveedor=".$id_proveedor;
		}
		if($sel_res[1]==2){
			$select_tabla="select  nombre_aspectos, puntaje_maximo, id_evaluacion FROM vista_t9_contrato_puntual where estado_aspecto='1' and fecha_periodo_evaluado < '".$periodo."' and id_crea_aspectos=".$id_evaluador." and id_criterio in(1,2,3) and id_proveedor=".$id_proveedor;
		}
		if($sel_res[1]==3){
			$select_tabla="select  nombre_aspectos, puntaje_maximo, id_evaluacion FROM vista_t9_contrato_marco where estado_aspecto='1' and fecha_periodo_evaluado < '".$periodo."' and id_crea_aspectos=".$id_evaluador." and id_criterio in(1,2,3) and id_proveedor=".$id_proveedor;
		}
?>
<table id="carga_periodo_resultado" class="striped centered" cellspacing="0" width="100%">
  	<thead>
	  <tr>
		  <th width="70%">
		  	Aspectos
		  </th>
		  <th width="30%" style="font-size:18pt !important; font-weight: 900 !important;">
			Puntuaci&oacute;n M&aacute;xima
		  </th>
	  </tr>
	</thead>
	<tbody id="body_periodo_resultados">
	<?
		$bandera=false;
		$id_proceso=0;
		$id_pasa_variable=0;
		$db=query_db($select_tabla);
		while($lt=traer_fila_db($db) and $bandera==false){
			if($id_proceso==0){
				$id_proceso=$lt[2];
			}
			if($id_proceso==$lt[2]){
				$id_pasa_variable=$id_proceso;
				$total_tecnica=$total_tecnica+$lt[1];
				echo "<tr><td>".$lt[0]."</td><td>".$lt[1]."</td></tr>";
			}else{
				$bandera=true;
			}	
		}
	?>
	</tbody>
</table>
<?
	}
?>
	<script type="text/javascript" src="../../librerias/materialize/js/materialize.min.js?version=72"></script>
	<script type="text/javascript" src="../../librerias/ajax/ajax_02_material.js?version=83"></script>
	<script>
		$(document).ready(function() {
			//$('.modal-trigger').leanModal();
			$('.tooltipped').tooltip({delay: 50});
			$('.modal').modal();
		});
	</script>
</body>
</html>