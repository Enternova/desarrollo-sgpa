<? include("../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("principal.html");
	$id_invitacion = $id_invitacion_pasa;
	
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

$busca_provee = traer_fila_row(query_db("select pv_id, razon_social, nit,email,telefono from $t8 where	pv_id = $pv_id_b"));
$busca_apertura=traer_fila_row(query_db("select * from pro12_apertura_proceso where pro1_id = $id_invitacion and estado = 1"));

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

<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="13%"><div align="right"><strong>Proveedor:</strong></div></td>
    <td width="87%"><?=$busca_provee[1];?></td>
  </tr>
  <tr>
    <td><div align="right"><strong>E-mail (Usuario):</strong></div></td>
    <td><?=$busca_provee[3];?></td>
  </tr>
  <tr>
    <td><div align="right"><strong>Tel&eacute;fono:</strong></div></td>
    <td><?=$busca_provee[4];?></td>
  </tr>
</table>
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
    <td width="14%" align="right" class="columna_subtitulo_resultados">Fecha de cierre:</td>
    <td width="29%"><input name="fecha_cierre_extratiempo" type="text" class="f_fechas" id="fecha_cierre_extratiempo" onMouseDown="calendario_se('fecha_cierre_extratiempo')" /></td>
    <td width="57%"><input type="hidden" name="anexos_s" id="anexos_s" /></td>
  </tr>
  <tr>
    <td align="right" valign="top" class="columna_subtitulo_resultados">Comentarios de la autorizaci&oacute;n de la solicitud:</td>
    <td colspan="2"><textarea name="observaciones_extratiempo" id="observaciones_extratiempo" cols="45" rows="5"></textarea></td>
  </tr>
  <tr>
    <td align="right" valign="top">&nbsp;</td>
    <td colspan="2"><input name="button" type="button" class="guardar" id="button" value="        Guadar solicitud antes de apertura" onClick="crea_extratiempo()"></td>
  </tr>
</table>

<? } ?>
<table width="99%" border="0" class="tabla_lista_resultados">
  <tr class="columna_titulo_resultados">
    <td colspan="4">Historico de solicitudes antes de apertura</td>
  </tr>
  <tr class="columna_titulo_resultados">
    <td width="12%">Creacion</td>
    <td width="14%">Usuario</td>
    <td width="14%">Fecha cierre ampliacion</td>
    <td width="60%">Comentarios</td>
  </tr>
  <?
  	 $sele_etx = "select fecha_creacion, nombre_administrador, fecha_cierre, anexo, obeservaciones from v_urna_extratiempo where pro1_id = $id_invitacion and pv_id = $pv_id_b order by estado_extratiempo ";
	$sql_ex_extra = query_db($sele_etx);
	while($lis_ext = traer_fila_row($sql_ex_extra)){
  
  ?>
  
  <tr>
    <td><?=$lis_ext[0];?></td>
    <td><?=$lis_ext[1];?></td>
    <td><?=$lis_ext[2];?></td>
    <td><?=$lis_ext[4];?></td>
  </tr>
  
  <? } ?>
</table>

<? } //si ya se cerro ?>
<br>
<br>
<fieldset style="width:98%">
			<legend>Historico de <strong>contactos</strong></legend>
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td width="25%" class="columna_titulo_resultados"><div align="center"><strong>Nombre</strong></div></td>
                <td width="48%" class="columna_titulo_resultados"><div align="center"><strong>E-mail</strong></div></td>
                <td width="27%" class="columna_titulo_resultados"><div align="center"><strong>Tel&eacute;fono</strong></div></td>
              </tr>
              
              <?
			  	$sele_car="select * from pv_contactos where  pv_id = $pv_id_b and estado = 1 ";
				$sql_ex_c=query_db($sele_car);
				while($ls_c=traer_fila_row($sql_ex_c)){
		if($num_fila_gene%2==0)
				$class_g="campos_blancos_listas";
			else
				$class_g="campos_gris_listas";
				
				$busca_relacion = traer_fila_row(query_db("select * from pro33_relacion_contactos_procesos where pro1_id = $id_invitacion and pv_contactos_id = $ls_c[0] "));
				if($busca_relacion[0]>=1) $che_a = "checked";
				else $che_a = "";
				
				if($busca_relacion[3]==2) $che_p = "checked";
				else $che_p = "";
  ?>
      <tr class="<?=$class_g;?>">
        <td><?=$ls_c[2];?></td>
        <td align="center"><?=$ls_c[3];?></td>
        <td align="center"><?=$ls_c[4];?></td>
        </tr>
			   
				  <? 
				  
				 $num_fila_gene++; } ?>           
            </table>
</fieldset>  

<br>
              <?
			  
			  if($sql_e[31]==1){
			 
  ?>
 <? 
				  
				  } ?>  
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_pasa;?>">
<input type="hidden" name="ocu_re">
<input type="hidden" name="pv_id_b" value="<?=$pv_id_b;?>">
<input type="hidden" name="nombre_proee_t" value="<?=$busca_provee[1];?>">



</body>
</html>
