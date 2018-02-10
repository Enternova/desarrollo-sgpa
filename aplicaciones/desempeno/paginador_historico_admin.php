<?
//error_reporting(E_ALL);  // LÃ­neas para mostart errores
//ini_set('display_errors', '1');  // LÃ­neas para mostart errores
include("../../librerias/lib/@session.php");
include('../../librerias/php/funciones_html.php');
$footer=carga_paginador_hmtl_solo_body($regis_inicial, $regis_final, $posicion_pagina, $pagina_actual, 4, 'body_historico_procesos');
echo $footer;
?>