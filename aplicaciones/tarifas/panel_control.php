<? include("../../enterproc/librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("procesos.html");

	$busca_proveedor = traer_fila_row(query_db("select * from $t8 where pv_id = ".$_SESSION["id_proveedor"]));

?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
  
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">ADMINISTRACION DE USUARIOS</td>
  </tr>
</table>
<p>&nbsp;</p>
<fieldset style="width:98%">
			<legend>Informaci&oacute;n General </legend>
<table width="95%" border="0" cellspacing="4" cellpadding="4">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td width="30%" height="34"><div align="right">Identificaci&oacute;n:</div></td>
    <td width="26%"><div align="left"><?=$busca_proveedor[2];?></div></td>
    <td width="22%"><div align="right">Raz&oacute;n social:</div></td>
    <td width="22%"><div align="left"><?=$busca_proveedor[3];?>
    </div>    </td>
  </tr>
  <tr>
    <td height="35"><div align="right">Direcci&oacute;n:</div></td>
    <td><div align="left"><?=$busca_proveedor[4];?></div></td>
    <td><div align="right">* E-mail (Usuario principal):</div></td>
    <td><div align="left"><input type="text" name="usuario_pro" id="usuario_pro" value="<?=$busca_proveedor[5];?>"></div></td>
  </tr>
  <tr>
    <td height="33"><div align="right">* Tel&eacute;fono de Contacto:</div></td>
    <td><div align="left"><input type="text" name="telefono_pro" id="telefono_pro" value="<?=$busca_proveedor[6];?>"></div></td>
    <td><div align="right">T&eacute;lefono Movil:</div></td>
    <td><div align="left"><input type="text" name="movil_pro" id="movil_pro" value="<?=$busca_proveedor[9];?>"></div></td>
  </tr>
  <tr>
    <td height="35"><div align="right">Cambiar contrase&ntilde;a</div></td>
    <td><div align="left">
      <label>
      <input type="password" name="conta_1" id="conta_1">      </label>
    </div>
      <div align="center"></div></td>
    <td><div align="right">Repetir nueva contrase&ntilde;a</div></td>
    <td><div align="left">
      <input type="password" name="conta_2" id="conta_2">
    </div></td>
  </tr>
  <tr>
    <td height="32" colspan="4"><label>
      <div align="center"><input name="button" type="button" class="guardar" id="button" value="Actualizar informaci&oacute;n de contaco y/o contrase&ntilde;a" onClick="cambia_contrasena()"></div>
    </label></td>
  </tr>
</table>
<br>
</fieldset>
<br>
<fieldset style="width:98%">
			<legend>Crear nuevo usuario</legend>
            
            <table width="95%" border="0" cellspacing="4" cellpadding="4">
              <tr>
                <td colspan="4"></td>
              </tr>
              <tr>
                <td width="30%" height="34">Nombre:</td>
                <td width="26%"><div align="left">
                  <input type="text" name="b" id="textfield6">
                </div></td>
                <td width="22%">E-mail:</td>
                <td width="22%"><div align="left">
                  <input type="text" name="d" id="textfield8">
                </div></td>
              </tr>
              <tr>
                <td height="35">Tel&eacute;fono:</td>
                <td><div align="left">
                  <input type="text" name="e" id="textfield9">
                </div></td>
                <td>&nbsp;</td>
                <td><div align="left"></div></td>
              </tr>


              <tr>
                <td height="32" colspan="4"><div align="center"><input name="button2" type="button" class="guardar" id="button2" value="Crear usuario" onClick="crea_sub_usuario_j()">
                  </div>
                  </label></td>
              </tr>
            </table>
            <br>
</fieldset>


<br />
<fieldset style="width:98%">
			<legend>Usuarios creados </legend>

            <br>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr class="administrador_tabla_titulo">
    <td width="18%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
    <td width="39%" class="titulo_tabla_azul_sin_bordes">E-mail</td>
    <td width="28%" class="titulo_tabla_azul_sin_bordes">Tel&eacute;fono</td>
    <td width="15%" class="titulo_tabla_azul_sin_bordes">Acciones</td>
  </tr>
  <?
			$busca_respo = query_db("select * from $t1 where  pv_id = ".$_SESSION["id_proveedor"]." and pv_principal = 1 and estado = 1 ");
			while($lc=traer_fila_row($busca_respo)){

			
		?>
  <tr class="administrador_tabla_generales">
    <td><div align="center">
      <input type="text" name="a1_<?=$lc[0];?>" id="a1_<?=$lc[0];?>" value="<?=$lc[1];?>">
    </div></td>
    <td><div align="center">
      <input type="text" name="b1_<?=$lc[0];?>" id="b1_<?=$lc[0];?>" value="<?=$lc[4];?>">
    </div></td>
    <td><div align="center">
      <input type="text" name="c1_<?=$lc[0];?>" id="c1_<?=$lc[0];?>" value="<?=$lc[5];?>">
    </div></td>
    <td><div align="center">
    <img src="../imagenes/botones/editar_c.png" width="16" height="16" title="Editar usuario" onClick="edita_sub_usuario(<?=$lc[0];?>,document.principal.a1_<?=$lc[0];?>,document.principal.b1_<?=$lc[0];?>,document.principal.c1_<?=$lc[0];?>)">
    
    &nbsp;<img src="../imagenes/botones/chat.png" width="22" height="18" title="Cambiar contraseña" onClick="soli_cam_contra(<?=$lc[0];?>)">&nbsp;&nbsp;<img src="../imagenes/botones/eliminar_c.png" width="16" height="16" title="Eliminar usuario" onClick="elimina_usuario(<?=$lc[0];?>)"></div></td>
  </tr>
  <? } ?>
</table>
<br>
</fieldset>

<br>
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_pasa;?>">
<input type="hidden" name="id_anexo">
<input type="hidden" name="campo_id">
</body>
</html>
