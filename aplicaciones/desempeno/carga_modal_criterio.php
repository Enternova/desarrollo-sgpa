<?
include("../../librerias/lib/@session.php");
include('../../librerias/php/funciones_html.php');
$id_criterio=elimina_comillas(arreglo_recibe_variables($_GET["id_criterio"]));
carga_modal_criterio('MODIFICAR CRITERIO', 'edita_criterio_admin(&apos;'.$_GET["id_criterio"].'&apos;)', '', $id_criterio);
?>