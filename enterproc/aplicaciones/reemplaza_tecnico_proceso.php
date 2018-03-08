<? include("../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("principal.html");
	$id_invitacion = $id_invitacion_pasa;
	
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));



?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css">
</head>
<body >
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="88%" class="titulos_procesos">CONTACTOS DEL PROCESO<br>
      <strong>Consecutivo del proceso:
        <?=$sql_e[22];?>
      </strong></td>
    <td width="12%"><input name="button6" type="button" class="cancelar" id="button6" value="Volver al proceso" onClick="ajax_carga('../aplicaciones/visualiza_proceso.php?id_p=<?=$id_invitacion_pasa;?>&ruta_ev=<?=$ruta_ev;?>','contenidos')"></td>
  </tr>
</table>
<br>
<br>
<?
if($fecha." ".$hora > $sql_e[18]){//si ya se cerro

if($busca_apertura[0]>=1){
	echo "";	
}

else{

?>
<table width="99%" border="0" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" class="columna_titulo_resultados">Solicitudes antes de apertura</td>
  </tr>
  <tr>
    <td width="24%" align="right" class="columna_subtitulo_resultados">Nuevo responsable t&eacute;cnico:</td>
    <td width="19%"><select name="responsable_tec_nuevo" id="responsable_tec_nuevo">
      <? 
					if($_SESSION["pv_principal"] != 150)
						$traer_tecnicos_compras = " tipo_usuario <> 2 and tipo_usuario <> 10 and estado = 1 and us_id <> ".$_SESSION["id_us_session"]." ";
					elseif($_SESSION["pv_principal"] == 150)
						$traer_tecnicos_compras = " pv_principal = 150 ";
						
					?>
      <?=listas_mayus($t1, $traer_tecnicos_compras,$busca_responsable_t[1],'nombre_administrador', 1);?>
    </select></td>
    <td width="57%"><input type="hidden" name="anexos_s" id="anexos_s" /></td>
  </tr>
  <tr>
    <td align="right" valign="top" class="columna_subtitulo_resultados">Comentarios del cambio:</td>
    <td colspan="2"><textarea name="observacion_cambia_tecnico" id="observacion_cambia_tecnico" cols="45" rows="5"></textarea></td>
  </tr>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td colspan="2"><input name="button" type="button" class="guardar" id="button" value="        Guardar y notificar al responsable t&eacute;cnico" onClick="grabar_evaluacion_tecnico()"></td>
  </tr>
</table>

<? } ?>
<? } //si ya se cerro ?>
<br>
<br>


<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_pasa;?>">
<input type="hidden" name="ocu_re">
<input type="hidden" name="pv_id_b" value="<?=$pv_id_b;?>">
<input type="hidden" name="nombre_proee_t" value="<?=$busca_provee[1];?>">
</body>
</html>
