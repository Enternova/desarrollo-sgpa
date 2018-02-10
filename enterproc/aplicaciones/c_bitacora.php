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
    <td class="titulos_procesos">PROCESOS DE CONTRATACION</td>
  </tr>
</table>

<fieldset style="width:98%">
			<legend>Informaci&oacute;n General del Proceso</legend>
<table width="95%" border="0" cellspacing="4" cellpadding="4">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td width="30%" height="26"><strong>Consecutivo del proceso:</strong></td>
    <td width="26%"><div align="left"><?=$sql_e[22];?></div></td>
    <td width="22%"><strong>Tipo de proceso:</strong></td>
    <td width="22%"><div align="left"><?=listas_sin_select($tp2,$sql_e[2],1);?>
    </div>    </td>
  </tr>
  <tr>
    <td height="26"><strong>Detalle y cantidad del objeto a contratar:</strong></td>
    <td colspan="3"><div align="left">
      <?=$sql_e[12];?>
      </textarea>
    </div></td>
  </tr>
</table>
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><label>
      <input name="button6" type="button" class="cancelar" id="button6" value="Volver al proceso" onClick="ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_invitacion_pasa;?>','contenidos')">
    </label></td>
  </tr>
</table>
<br>
</fieldset>

<br><br>

<? readfile('http://www.parservicios.com/parservi/ficha_tecnica_gt_2.php?ref=principal.html&pv_nit='.$busca_provee[2]);

$busca_contacto_principal=traer_fila_row(query_db("select * from $t30 where pro1_id =$id_invitacion and pv_id =$pv_id_b order by pro19_id desc "));

 ?>

<br>


            <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
              <tr>
                <td><div align="right"><strong>Contacto principal:</strong></div></td>
                <td>Nombre:<?=$busca_contacto_principal[3];?><br>
                  E-mail:<?=$busca_contacto_principal[4];?><br>
                  Tel&eacute;fono:<?=$busca_contacto_principal[5];?></td>
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
                <td><div align="right"><strong>Efectividad:</strong></div></td>
                <td><select name="efectividad_bita" id="efectividad_bita">
                  <?=listas($tp14, " tp14_id  >=1 ",2,'nombre', 1);?>
                                </select></td>
              </tr>
              <tr>
                <td><div align="right"><strong>Contacto para este proceso:</strong></div></td>
                <td><label>
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
                <td><div align="right"><strong>Chequear alertas pendientes:</strong></div></td>
                <td>
                
			  <table width="99%" border="0" cellspacing="2" cellpadding="2">
      
                 <?  
              
                $busca_procesos = "select pro18_id, pro1_id, nombre, detalle_proceso, fecha_generacion, consecutivo, razon_social,pv_id
                 from $v8 where pro1_id = $id_invitacion_pasa and pv_id = $pv_id_b and estado = 1	";
                $sql_ex = query_db($busca_procesos);
                while($ls=traer_fila_row($sql_ex)){ ?>
				<tr>
               	  <td width="10%"><input name='alerta_pendientes[<?=$ls[0];?>]' type='checkbox' class="campos" value='2'>           	      </td>
                    <td width="99%"><?=$ls[2];?></td>
                </tr>
		   
		   	<? }
            
              ?>
              </table>               </td>
              </tr>
              <tr>
                <td><div align="right"></div></td>
                <td>&nbsp;</td>
              </tr>
              <tr>
                <td colspan="2">      
                  <div align="center">
                    <input name="button" type="button" class="guardar" id="button" value="Grabar gesti&oacute;n" onClick="crea_bitacora()">
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
