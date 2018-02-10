<?
//error_reporting(E_ALL);  // LÃ­neas para mostart errores
//ini_set('display_errors', '1');  // LÃ­neas para mostart errores
include("../../librerias/lib/@session.php");
include('../../librerias/php/funciones_html.php');
$comple_sql="";//" AND (id_evaluador=".$_SESSION["id_us_session"]." or id_crea_aspectos= ".$_SESSION["id_us_session"].")";
$val_input="";
$val_select="";
if($_GET["caracter1"] and $_GET["caracter1"]!="" and $_GET["caracter1"]!=" "){
		$val_select=$_GET["caracter"];
		$comple_sql.=" AND  id_estado_criterio=".elimina_comillas(arreglo_recibe_variables($_GET["caracter"]));
}
if($_GET["caracter2"] and $_GET["caracter2"]!="" and $_GET["caracter2"]!=" "){
		$val_input=$_GET["caracter"];
		$comple_sql.=" AND nombre_proveedor LIKE '%".$_GET["caracter"]."%'" ;
}
$pagina=0;
$posicion_pagina=0;
$val_actual=0;
if($_GET["pagina"]){
	$pagina = $_GET["pagina"];
	$posicion_pagina=$_GET["posicion"];
	$val_actual=$_GET["val_actual"];
}else{
	$pagina = 1;	
	$posicion_pagina=1;
	$val_actual=1;
}
$registros_pagina=10;
$regis_final = $pagina * $registros_pagina;		
$regis_inicial = (($pagina - 1) * $registros_pagina)+1;
$pagina_actual=$pagina;
$pagina_hasta=$pagina+5;
$id_criterio_evaluacion=elimina_comillas(arreglo_recibe_variables($_GET["id_criterio"]));
echo $sql_rows="SELECT estado_evaluacion, nombre_proveedor, numero_documento, periodo_evaluacion, id_evaluacion FROM (SELECT ROW_NUMBER()Over(order by id_evaluacion desc) As RowNum, id_evaluacion, id_estado_criterio, estado_evaluacion, nombre_proveedor, numero_documento, periodo_evaluacion, id_evaluador, id_crea_aspectos, tipo_documento FROM dbo.historico_desempeno()) as resultado_paginado WHERE RowNum BETWEEN ".$regis_inicial." AND ".$regis_final.$comple_sql;
$sql_rows_total="SELECT count(*) FROM (SELECT ROW_NUMBER()Over(order by id_evaluacion desc) As RowNum, id_evaluacion, id_estado_criterio, estado_evaluacion, nombre_proveedor, numero_documento, periodo_evaluacion, id_evaluador, id_crea_aspectos, tipo_documento FROM dbo.historico_desempeno()) as resultado_paginado";
$total_registros=traer_fila_row(query_db($sql_rows_total));
$registros_por_pagina=$total_registros[0]/10;
if(is_int($registros_por_pagina)){
	
	//echo "es entero ".$registros_por_pagina;
}else{
	
	$registros_por_pagina=strval ( $registros_por_pagina );
	$registros_por_pagina=explode('.',$registros_por_pagina);
	$registros_por_pagina[0]=$registros_por_pagina[0]+1;
	//echo "no es entero ".$registros_por_pagina[0];
}
//echo $total_registros[0];
$cuantos_registros_sql = query_db($sql_rows_total);
		  while($s = traer_fila_db($cuantos_registros_sql)){
			  $cuantos_registros = 1 +$cuantos_registros;
			  }
		  
	  $cunatas_paginas = ($cuantos_registros / $registros_pagina) +1;

$footer=carga_paginador_hmtl_solo_body($regis_inicial, $regis_final, $total_registros[0], $posicion_pagina, $pagina, 5, 'foot_historico_procesos', $registros_por_pagina[0]);
?>

<?=$footer;?>