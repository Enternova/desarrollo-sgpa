<? include("../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("principal.html");
	$id_invitacion = $id_invitacion_pasa;
	
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

$busca_provee = traer_fila_row(query_db("select pv_id, razon_social, nit from $t8 where	pv_id = $pv_id_b"));


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
    <td width="88%" class="titulos_procesos">BITACORA DEL PROCESO<br>
    <strong>Consecutivo del proceso:
    <?=$sql_e[22];?>
    </strong></td>
    <td width="12%"><input name="button6" type="button" class="cancelar" id="button6" value="Volver al proceso" onClick="ajax_carga('../aplicaciones/visualiza_proceso.php?id_p=<?=$id_invitacion_pasa;?>&ruta_ev=<?=$ruta_ev;?>','contenidos')"></td>
  </tr>
</table>
<p><br>
  
</p>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="3" class="columna_titulo_resultados"><strong>OTROS CONTACTOS DEL PROCESO</strong></td>
  </tr>
  <tr>
    <td width="23%" class="columna_titulo_resultados"><div align="center"><strong>Nombre</strong></div></td>
    <td width="23%" class="columna_titulo_resultados"><div align="center"><strong>E-mail</strong></div></td>
    <td width="18%" class="columna_titulo_resultados"><div align="center"><strong>Tel&eacute;fono</strong></div></td>
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
<p>&nbsp; </p>
<br>
<fieldset style="width:98%">
			<legend>Historico de <strong>gestiones</strong></legend>
            <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td width="13%" class="columna_titulo_resultados">Usuario</td>
                <td width="15%" class="columna_titulo_resultados">Fecha</td>
                <td width="54%" class="columna_titulo_resultados">Detalle gesti&oacute;n</td>
                <td width="18%" class="columna_titulo_resultados">Nueva llamada</td>
              </tr>
              
              <?
			  	$sele_car="select pro15_id, nombre_administrador, fecha_hora_gestion, detalle_gestion, proxima_llamada from $v6 where pro1_id = $id_invitacion and pv_id = $pv_id_b order by fecha_hora_gestion desc";
				$sql_ex_c=query_db($sele_car);
				while($ls_c=traer_fila_row($sql_ex_c)){
		if($num_fila_gene%2==0)
				$class_g="campos_blancos_listas";
			else
				$class_g="campos_gris_listas";
				

  ?>
      <tr class="<?=$class_g;?>">
        <td><?=$ls_c[1];?></td>
        <td align="center"><?=fecha_for_hora($ls_c[2]);?></td>
        <td align="center"><?=$ls_c[3];?></td>
        <td><?=fecha_for_hora($ls_c[4]);?></td>
      </tr>
			   
				  <? 
				  
				 $num_fila_gene++; } ?>           
            </table>
</fieldset>            

<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_pasa;?>">
<input type="hidden" name="id_elimina">
<input type="hidden" name="ocu_re">
<input type="hidden" name="pv_id_b" value="<?=$pv_id_b;?>">


</body>
</html>
