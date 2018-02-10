<? include("../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("principal.html");



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
    <td width="18%" height="34"><div align="right">Nombre:</div></td>
    <td width="33%"><div align="left">
      <label>
      
      <input name="ap" type="text" id="ap" size="50">
      </label>
    </div></td>
    <td width="20%"><div align="right">Usuario:</div></td>
    <td width="29%"><div align="left">
        <input type="text" name="usuario_pasa"  />
    </div>    </td>
  </tr>
  <tr>
    <td height="35"><div align="right">E-mail:</div></td>
    <td><div align="left">
      <input name="email" type="text" id="email" size="50">
    </div></td>
    <td><div align="right">Tel&eacute;fono:</div></td>
    <td><div align="left">
      <input name="dp" type="text" id="dp" size="50">
    </div></td>
  </tr>
  <tr>
    <td height="33"><div align="right">Perfil:</div></td>
    <td><div align="left">
      <select name="perfil" id="perfil">
		<option value="0">Perfil</option>
		<option value="1"  <? if($busca_proveedor[9]==1) echo "selected";  ?> >Administrador</option>
		<option value="3" <? if($busca_proveedor[9]==3) echo "selected";  ?> >Comprador</option>
		<option value="4" <? if($busca_proveedor[9]==4) echo "selected";  ?> >Auditor</option>                        
                  </select>
    </div></td>
    <td><div align="right">Estado:</div></td>
    <td><div align="left">
      <select name="fp" id="fp">
		<option value="0">Estado</option>
		<option value="1"  <? if($busca_proveedor[6]==1) echo "selected";  ?> >Activo</option>
		<option value="2" <? if($busca_proveedor[6]==2) echo "selected";  ?> >Eliminado</option>

                  </select>
</div></td>
  </tr>
  <tr>
    <td height="35"><div align="right"></div></td>
    <td><div align="left" id="grupo_ciudades"></div></td>
    <td><div align="right">Crear contrase&ntilde;a automatica:</div></td>
    <td><label>
      
      <div align="left">
        <input name="g" type="checkbox" id="g" value="si">
        </label>
    </div></td>
  </tr>
  <tr>
    <td height="35"><div align="right">Cambiar contrase&ntilde;a:</div></td>
    <td><div align="left">
      <label>
      <input type="password" name="conta_1" id="conta_1">
      </label>
    </div>
      <div align="center"></div></td>
    <td><div align="right">Repetir nueva contrase&ntilde;a:</div></td>
    <td><div align="left">
      <input type="password" name="conta_2" id="conta_2">
    </div></td>
  </tr>
  <tr>
    <td height="32" colspan="4"><label>
      <div align="center">
        <input name="button" type="button" class="guardar" id="button" value="Crear usuario" onClick="crear_usuario()">
        <input name="button2" type="button" class="cancelar" id="button2" value="Cancelar creaci&oacute;n" onClick="volver_listado('contenido_aux','contenido_aux_sub')">
      </div>
    </label></td>
  </tr>
</table>
<br>
</fieldset>

<br />
<input type="hidden" name="pv_id" value="<?=$pv_id;?>" />  
  

</p>
</body>
</html>
