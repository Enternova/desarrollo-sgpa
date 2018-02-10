<?
include("../../librerias/lib/@session.php");

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
  	<link rel="stylesheet" type="text/css" href="../../librerias/materialize/css/hocolTables.min.css?version=<?=$hora?>">
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
		td, th{
			border-right: 1px solid #ccc !important;
			border-left: 1px solid #ccc !important;
		}
	</style>
	
</head>
<body>

<?
$titulo_columna="";
$titulo1="";
if($_GET["tp_grafica1"]=="area"){
	$titulo1="N&uacute;mero de Contratos por &aacute;rea Usuaria<br> <span style='font-size:14pt'>Rango de Vigencia Desde ".$_SESSION["fecha_inicial_bus_rep"]." - Hasta ".$_SESSION["fecha_hasta_bus_rep"]."</span>";
	$titulo_columna="&Aacute;rea Usuaria";
	}

?>
	

    <div style="width: 98%; margin-left: 1%; box-shadow: 2px 6px 50px 9px; margin-top: 0%; border-radius: 20px; height: 40rem;">
	<div class="titulos_secciones font" style="font-size:16pt !important; font-weight: 900 !important; width: 90%; margin-left: 5%; margin-top: 2%;"><br><h4 style=""><?=$titulo1?></h4></div>
    <table id="data-table-1" class="striped centered" cellspacing="0" style="margin-left: 5%; width: 90%; margin-top: 2%;">
          <thead>
		<tr>
			<th width="52%"><?=$titulo_columna?></th>
			<th width="19%">No. de Contratos sin Excepci&oacute;n</th>
			<th width="19%">No. de Contratos con Excepci&oacute;n</th>
			<th width="10%">Total de Contratos</th>
		</tr>

          </thead>
	<tfoot style="margin-top: -5%;">
		<tr>
			<th colspan="4">
			<div class="input-field col s6 m6 l6 left" id="load-registers">
				&nbsp;
                    		</div>
			<div class="input-field col s6 m4 l4 right" id="pagination">
			<ul class="pagination" id="list-pagination">

			</ul>
			</div>
			</th>
		</tr>
	</tfoot>
	<tbody id="cargatodo">
      <?
      $tr="";
      $sql="select t1_area_id, area from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro"]."  group by t1_area_id, area order by area";
	  $selec_t_pro = query_db($sql);
while($sel_pro = traer_fila_db($selec_t_pro)){
	
	$sql_barra_1 = traer_fila_row(query_db("select count(distinct  id_contrato_tarifas) from v_reporte_general_variacion_tarifas ".$_SESSION["comple_filtro"]." and  t1_area_id = ".$sel_pro[0]." and t6_tarifas_estados_contratos_id <> 6"));
	
	$sql_barra_2 = traer_fila_row(query_db("select count(distinct  id_contrato_tarifas) from v_reporte_general_variacion_tarifas where t1_area_id = ".$sel_pro[0]." and t6_tarifas_estados_contratos_id = 6"));

	$tr.=$sel_pro[1]."--td--".number_format($sql_barra_1[0],0)."--td--".number_format($sql_barra_2[0],0)."--td--".number_format($sql_barra_1[0] + $sql_barra_2[0],0)."--tr--";
	 
}
$tr=preg_replace('/\s+/', ' ', $tr);
	$tr=preg_replace('/\n/', ' ', $tr);
?>
	</tbody>
    </table>
    <div style="height: 50px; margin-top: 1%;"></div>
    </div>
 <script type="text/javascript" src="../../librerias/jquery/jquery2.js?version=<?=$hora?>"></script>
  <script type="text/javascript" src="../../librerias/materialize/js/materialize.js?version=<?=$hora?>"></script>
  <script type="text/javascript" src="../../librerias/materialize/js/hocolTables.min.js?version=<?=$hora?>"></script>
  <script>
    $(document).ready(function(){
      _.orderTableFromHtml('<?=$tr;?>','data-table-1');
    });
  </script>
</body>
</html>
  