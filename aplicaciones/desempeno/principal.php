<?
include("../../librerias/lib/@session.php");
$onload="";
if($_GET["function1"]){
	$onload.="?function1=".$_GET["function1"];
}
if($_GET["function2"]){
	$onload.="&function2=".$_GET["function2"];
}
if($_GET["function3"]){
	$onload.="&function3=".$_GET["function3"];
}
if($_GET["function4"]){
	$onload.="&function4=".$_GET["function4"];
}

?>
<iframe id="iframe_desempeno_admin" src="../aplicaciones/desempeno/inicio_principal.php<?=$onload?>" id="iframe" frameborder="0" style="display: block; width: 100%; height: 2900px; border: none;"></iframe>