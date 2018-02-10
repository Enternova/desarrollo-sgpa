<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("principal.html");
	$id_invitacion = $id_invitacion_pasa;
	
	$busca_procesos = "select help_id, fecha, resuelto, nombre, razon_social, nombre_solicita,  cd_nombre, dp_nombre, ps_nombre, telefono, email, CAST(mensaje AS text),  ip
                 from v_help_principal where  help_id = $id_soporte_pasa";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	if($sql_e[2]==1) $estado_soporte = "Activo";
	else $estado_soporte = "Cerrado";


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
    <td class="titulos_procesos">DETALLE SOPORTE TECNICO</td>
  </tr>
</table>

  <table width="95%" border="0" cellspacing="2" cellpadding="2">
    <tr>
    <td align="right"><label>
      <input name="button6" type="button" class="cancelar" id="button6" value="Volver al proceso" onClick="ajax_carga('../aplicaciones/soporte_texto.php','contenidos')">
    </label></td>
  </tr>
</table>
<br>




            <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
              <tr>
                <td align="right"><strong>Fecha de envio:</strong></td>
                <td><?=$sql_e[1];?></td>
              </tr>
              <tr>
                <td align="right"><strong>Estado de la solicitud:</strong></td>
                <td><?=$estado_soporte;?></td>
              </tr>
              <tr>
                <td align="right"><strong>Tipo de solicitud:</strong></td>
                <td><?=$sql_e[3];?></td>
              </tr>
              <tr>
                <td align="right"><div align="right"><strong>Raz&oacute;n social:</strong></div></td>
                <td><?=$sql_e[4];?></td>
              </tr>
              <tr>
                <td align="right"><strong>Contacto:</strong></td>
                <td><?=$sql_e[5];?></td>
              </tr>
              <tr>
                <td align="right"><strong>Ubicaci&oacute;n geografica:</strong></td>
                <td><?=$sql_e[6];?>, <?=$sql_e[7];?>, <?=$sql_e[8];?></td>
              </tr>
              <tr>
                <td align="right"><strong>Tel&eacute;fono del contacto:</strong></td>
                <td><?=$sql_e[9];?></td>
              </tr>
              <tr>
                <td align="right"><strong>E-mail del contacto:</strong></td>
                <td><?=$sql_e[10];?></td>
              </tr>
              <tr>
                <td align="right"><strong>Mensaje:</strong></td>
                <td><?=$sql_e[11];?></td>
              </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td width="28%"><div align="right"><strong>Gesti&oacute;n:</strong></div></td>
                <td width="72%"><div align="left">
                  
                  <textarea name="pregunta_general" id="pregunta_general" cols="100" rows="5"></textarea>
                  
                </div>              </td>
              </tr>
              <tr>
                <td><div align="right"><strong>Fecha proxima llamada:</strong></div></td>
                <td><input name="h_m_r" type="text" class="f_fechas" id="h_m_r"  onmousedown="calendario_se('h_m_r')" /></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Estado del soporte:</strong></div></td>
                <td><select name="efectividad_bita" id="efectividad_bita">
                  <option value="1" selected>Activo</option>
                  <option value="2">Cerrado</option>
                                </select></td>
              </tr>
              <tr>
                <td colspan="2">      
                  <div align="center">
                    <input name="button" type="button" class="guardar" id="button" value="Grabar gesti&oacute;n" onClick="crea_soporte()">
                  </div></td>
              </tr>
            </table>


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
			  	$sele_car="select nombre_administrador, fecha, detallle, proxima_llamada from v_help_respuesta where help_id = $id_soporte_pasa order by fecha_respuesta desc";
				$sql_ex_c=query_db($sele_car);
				while($ls_c=traer_fila_row($sql_ex_c)){
		if($num_fila_gene%2==0)
				$class_g="campos_blancos_listas";
			else
				$class_g="campos_gris_listas";
				

  ?>
      <tr class="<?=$class_g;?>">
        <td><?=$ls_c[0];?></td>
        <td align="center"><?=fecha_for_hora($ls_c[1]);?></td>
        <td align="center"><?=$ls_c[2];?></td>
        <td><?=fecha_for_hora($ls_c[3]);?></td>
      </tr>
			   
				  <? 
				  
				 $num_fila_gene++; } ?>           
            </table>
</fieldset>            

<input type="hidden" name="id_soporte" value="<?=$sql_e[0];?>">
<input type="hidden" name="pv_id_b" value="<?=$pv_id_b;?>">


</body>
</html>
