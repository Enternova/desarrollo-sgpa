<?
//error_reporting(E_ALL);  // LÃ­neas para mostart errores
//ini_set('display_errors', '1');  // LÃ­neas para mostart errores
include("../../librerias/lib/@session.php");
include('../../librerias/php/funciones_html.php');
$id_criterio=elimina_comillas(arreglo_recibe_variables($_GET["id_criterio"]));
carga_modal_aspecto('MODIFICAR ASPECTO', 'edita_aspecto_admin(&apos;'.$_GET["id_criterio"].'&apos;)', '', $id_criterio);
?>