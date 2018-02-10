<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("principal.html");
	$id_invitacion = $id_invitacion;
	
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

$busca_provee = traer_fila_row(query_db("select pv_id, razon_social, nit,email,telefono from $t8 where	pv_id = $pv_id_b"));


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
    <td width="85%" class="titulos_procesos">PROCESOS DE CONTRATACION: 
    <?=$sql_e[22];?></td>
    <td width="15%"><input name="button3" type="button" class="cancelar" id="button3" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_paso3_sm.php?id_invitacion=<?=$id_invitacion;?>','contenidos')">
    sm</td>
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
<br>


            <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
              <tr>
                <td width="28%"><div align="right"><strong>Contacto para este proceso:</strong></div></td>
                <td width="72%"><label>
                  <input type="text" name="nombre_contacto" id="nombre_contacto">
                </label></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Email contacto para este proceso: </strong></div></td>
                <td><input type="text" name="email_contacto" id="email_contacto"></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Tel&eacute;fono de contacto para este proceso:</strong></div></td>
                <td><input type="text" name="telefono_contacto" id="telefono_contacto"></td>
              </tr>
              <tr>
                <td colspan="2">      
                  <div align="center">
                  <input name="button" type="button" class="guardar" id="button" value="Nuevo contacto" onClick="crea_nuevo_contacto_adj()">                  </div></td>
              </tr>
            </table>


<br>
<fieldset style="width:98%">
			<legend>Historico de <strong>contactos</strong></legend>
            <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td width="30%" class="columna_titulo_resultados">Nombre</td>
                <td width="28%" class="columna_titulo_resultados">E-mail</td>
                <td width="21%" class="columna_titulo_resultados">Tel&eacute;fono</td>
                <td width="15%" class="columna_titulo_resultados">Enviar notificaci&oacute;n</td>
                <td width="6%" class="columna_titulo_resultados">Eliminar</td>
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
  ?>
      <tr class="<?=$class_g;?>">
        <td><?=$ls_c[2];?></td>
        <td align="center"><?=$ls_c[3];?></td>
        <td align="center"><?=$ls_c[4];?></td>
        <td><input type="checkbox" <?=$che_a;?> value="1" name="rel_conta_<?=$ls_c[0];?>" onClick="crea_elimina(this.checked,<?=$ls_c[0];?>)"></input></td>
        <td><div align="center"><img src="../imagenes/botones/b_cancelar.gif" alt="Eliminar contacto" width="16" height="16" title="Eliminar contacto" onClick="elimina_contacto_todo_adj(<?=$ls_c[0];?>)"></div></td>
      </tr>
			   
				  <? 
				  
				 $num_fila_gene++; } ?>           
            </table>
</fieldset>            

<p>&nbsp;</p>
<p>
  <input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
  <input type="hidden" name="id_elimina">
  <input type="hidden" name="ocu_re">
  <input type="hidden" name="pv_id_b" value="<?=$pv_id_b;?>">
</p>
</body>
</html>
