<? include("../../librerias/lib/@include.php");
$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER

//adjudicacion de solicitud si se pega


$sel2 = query_db("update  $pi2 set estado = 14 where id_item = 1218");


?>
