<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("administracion.html");



?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
  
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_secciones">ADMINISTRACION DE USUARIOS</td>
  </tr>
</table>
<p>&nbsp;</p>

<table width="95%" border="0" cellpadding="4" cellspacing="4" class="tabla_lista_resultados">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td width="18%" height="34"><div align="right">Nombre:</div></td>
    <td width="33%"><div align="left">
      <input name="nombre_administrador" type="text" id="nombre_administrador" size="50">
    </div></td>
    <td width="20%"><div align="right">Usuario:</div></td>
    <td width="29%"><div align="left">
        <input type="text" name="usuario_pasa"  />
    </div></td>
  </tr>
  <tr>
    <td height="35"><div align="right">E-mail:</div></td>
    <td><div align="left">
      <input name="email" type="text" id="email" size="50">
    </div></td>
    <td><div align="right">Tel&eacute;fono:</div></td>
    <td><div align="left">
      <input name="telefono" type="text" id="telefono" size="50">
    </div></td>
  </tr>
  <tr>
    <td height="33"><div align="right">Perfil:</div></td>
    <td><div align="left">
      <select name="perfil" id="perfil">
		<option value="0">Perfil</option>
		<option value="3" selected="selected">Usuario Normal con Perfiles Definidos por Roles </option>
		<option value="1">Administrador Apertura Urna Virtual </option>
		<option value="4">Auditor Urna Virtual</option>                        
                  </select>
    </div></td>
    <td><div align="right">Estado:</div></td>
    <td><div align="left">
      <select name="estado" id="estado">
		<option value="1">Activo</option>
                  </select>
</div></td>
  </tr>
  <tr>
    <td height="35"><div align="right"></div></td>
    <td><div align="left" id="grupo_ciudades"></div></td>
    <td><div align="right">Crear contrase&ntilde;a automatica:</div></td>
    <td><label>
      
      <div align="left">
        <input name="contra_autom" type="checkbox" id="contra_autom" value="si">
    </label>    </div></td>
  </tr>
  <tr>
    <td height="35"><div align="right">Cambiar contrase&ntilde;a:</div></td>
    <td><div align="left">
      <label>
      <input type="password" name="conta_1" id="conta_1">      </label>
    </div>
      <div align="center"></div></td>
    <td><div align="right">Repetir nueva contrase&ntilde;a:</div></td>
    <td><div align="left">
      <input type="password" name="conta_2" id="conta_2">
    </div></td>
  </tr>
  <tr>
    <td height="32" align="right">Fecha de Vigencia:</td>
    <td height="32"><input type="text" name="fecha_vigencia" id="fecha_vigencia" onmousedown="calendario_sin_hora('fecha_vigencia')"/></td>
    <td height="32">&nbsp;</td>
    <td height="32">&nbsp;</td>
  </tr>
  <tr>
    <td height="32" colspan="4"><label>
      <div align="center">
        <input name="button" type="button" class="boton_grabar" id="button" value="Crear usuario" onClick="crear_usuario()">
        <input name="button2" type="button" class="boton_volver" id="button2" value="Cancelar creaci&oacute;n" onClick="javascript:ajax_carga('../aplicaciones/administracion/admin_usuario.php','contenidos')">      </div>
    </label></td>
  </tr>
</table>
<br>


<br />
<input type="hidden" name="pv_id" value="<?=$pv_id;?>" />  
  

</p>
</body>
</html>
