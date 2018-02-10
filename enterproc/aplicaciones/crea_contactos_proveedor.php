<? error_reporting("E_ERROR");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
$id_invitacion_pasa = $id_invitacion_pasa;
?>
<input name="button6" type="button" class="cancelar" id="button6" value="Volver al proceso" onClick="ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_invitacion_pasa;?>','contenidos')">
<?
readfile('http://www.parservicios.com/parservi/ficha_tecnica_gt_busca_1.php?id_invitacion_pasa='.$id_invitacion_pasa.'&ref=principal.html&nit='.$nit.'&email='.$email.'&nombre='.$nombre);

?>
<input type="hidden" name="id_invitacion_pasa" value="<?=$id_invitacion_pasa;?>">