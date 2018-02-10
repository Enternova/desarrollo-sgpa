<?
//error_reporting(E_ALL);  // LÃ­neas para mostart errores
//ini_set('display_errors', '1');  // LÃ­neas para mostart errores
include("../../librerias/lib/@session.php");
include('../../librerias/php/funciones_html.php');
$id_criterio_evaluacion=elimina_comillas(arreglo_recibe_variables($_GET["id_criterio"]));
$query="select tipo_documento FROM dbo.historico_desempeno() where id_evaluacion=".$id_criterio_evaluacion;
$tipo_documento=traer_fila_row(query_db($query));
carga_modal_configurar_aspecto('CONFIGURAR ASPECTOS', 'nuevo_aspecto_evaluacion(&apos;'.$_GET["id_criterio"].'&apos;)', '', $id_criterio_evaluacion, $tipo_documento[0]);
?>