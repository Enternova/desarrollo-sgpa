<?
//error_reporting(E_ALL);  // LÃ­neas para mostart errores
//ini_set('display_errors', '1');  // LÃ­neas para mostart errores
include("../../librerias/lib/@session.php");
include('../../librerias/php/funciones_html.php');
$comple_sql="WHERE id_proveedor not in(0)";//" WHERE (id_evaluador=".$_SESSION["id_us_session"]." or id_crea_aspectos= ".$_SESSION["id_us_session"]." or id_jefe=".$_SESSION["id_us_session"].")";
	$comple_sql2=$comple_sql;
	$val_input="";
	$val_select="";
	$comple_sql.=" AND  id_proveedor=".elimina_comillas(arreglo_recibe_variables($_SESSION["id_us_proveedor"]));
	if($_GET["caracter2"] and $_GET["caracter2"]!="" and $_GET["caracter2"]!=" "){
			$val_input=$_GET["caracter2"];
			$comple_sql.=" AND periodo_evaluacion LIKE '%".$_GET["caracter2"]."%'" ;
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
	$sql_rows="select periodo_evaluacion, id_proveedor from (select ROW_NUMBER()Over(order by periodo_evaluacion ASC) AS RowNum, periodo_evaluacion, id_proveedor from dbo.historico_desempeno_resultados() ".$comple_sql." group by periodo_evaluacion, id_proveedor) as resultado_paginado WHERE RowNum BETWEEN ".$regis_inicial." AND ".$regis_final;
	$sql_rows_total="SELECT count(*) FROM (select ROW_NUMBER()Over(order by periodo_evaluacion ASC) AS RowNum, periodo_evaluacion, id_proveedor from dbo.historico_desempeno_resultados() ".$comple_sql." group by periodo_evaluacion, id_proveedor) as resultado_paginado";
	$total_registros=traer_fila_row(query_db($sql_rows_total));
	$registros_por_pagina1=$total_registros[0]/10;
	if(is_int($registros_por_pagina1)){
		$registros_por_pagina=array();
		//echo "es entero ".$registros_por_pagina;
		$registros_por_pagina[0]=$registros_por_pagina1;
	}else{

		$registros_por_pagina=strval ( $registros_por_pagina1 );
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
	$inicio_tabla='';
	$funcion1='muestra_historico_resultados_periodo|&#xE417;| |color: #229BFF; cursor: pointer !important; background: trasparent;|&apos;'.$_SESSION["id_us_proveedor"].'&apos;|Ver';
	$campos=carga_tabla_hmtl_solo_body_resultados($funcion1, '', '', $sql_rows, 0, 'body_periodo_resultados', '&#xE838;');
	$footer=carga_paginador_hmtl_solo_body($regis_inicial, $regis_final, $total_registros[0], $posicion_pagina, $pagina, 8, 'foot_periodo_resultados', $registros_por_pagina[0], 'paginador_periodo_resultados');
	$tabla=preg_replace('/\s+/', ' ', $campos.$footer);
	$tabla=preg_replace('/\n/', ' ', $tabla);
?>

<?=$tabla?>