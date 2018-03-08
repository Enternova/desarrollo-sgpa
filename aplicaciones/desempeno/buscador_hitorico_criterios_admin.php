<?
//error_reporting(E_ALL);  // LÃ­neas para mostart errores
//ini_set('display_errors', '1');  // LÃ­neas para mostart errores
include("../../librerias/lib/@session.php");
include('../../librerias/php/funciones_html.php');
$comple_sql="";//" AND (id_evaluador=".$_SESSION["id_us_session"]." or id_crea_aspectos= ".$_SESSION["id_us_session"].")";
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
$sql_rows="select tipo_contrato, nombre_criterio, puntos_criterio, id_criterio from (select ROW_NUMBER()Over(order by id_criterio ASC) As RowNum, case when (tipo_contrato=1) then 'Servicio Menor' when (tipo_contrato=2) then 'Contrato Puntual' else 'Contrato Marco' end as tipo_contrato, nombre_criterio, puntos_criterio, id_criterio from t9_criterio where estado=1) as resultado_paginado WHERE RowNum BETWEEN ".$regis_inicial." AND ".$regis_final;
$sql_rows_total="SELECT count(*) FROM (select ROW_NUMBER()Over(order by id_criterio ASC) As RowNum, case when (tipo_contrato=1) then 'Servicio Menor' when (tipo_contrato=2) then 'Contrato Puntual' else 'Contrato Marco' end as tipo_contrato, nombre_criterio, puntos_criterio, id_criterio from t9_criterio where estado=1) as resultado_paginado";
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
$funcion1='muestra_modal_editar_criterio_admin|&#xE254;| |color: #229BFF; cursor: pointer !important; background: trasparent;| |Editar';
		$funcion2='elimina_criterio_admin|&#xE92B;| |color: #FF0000; cursor: pointer !important; background: trasparent;|&apos;&apos;|Eliminar';
	//$select = "Select * from t9_criterio";
	//crear_tabla_criterio('Criterios', $select, 'left', 'MODIFICAR', 'abrir_modal', 'background: #229BFF;')

$campos=carga_tabla_hmtl_solo_body($funcion1, $funcion2, '', $sql_rows, 3, 'body_historico_criterios_admin');
$footer=carga_paginador_hmtl_solo_body($regis_inicial, $regis_final, $total_registros[0], $posicion_pagina, $pagina, 4, 'foot_historico_criterios_admin', $registros_por_pagina[0], 'paginador_tabla_criterios_historico');
//'<td colspan="5">'.$sql_rows.'</td>'.
$tabla=preg_replace('/\s+/', ' ', $campos.$footer);
$tabla=preg_replace('/\n/', ' ', $tabla);
?>

<?=$tabla?>