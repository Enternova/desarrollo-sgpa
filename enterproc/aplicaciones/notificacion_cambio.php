<?  include("../librerias/lib/@session.php");

?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

</head>
<body >
<form name="notifica" method="post">
<table width="80%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td><table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
        <tr>
          <td width="30%"><div align="right">Usuario:</div></td>
          <td width="70%"><label>
            <input type="text" name="textfield" id="textfield">
          </label></td>
        </tr>
        <tr>
          <td><div align="right">Contrase&ntilde;a:</div></td>
          <td><div align="left">
            <input type="text" name="textfield2" id="textfield2">
           
          </div></td>
        </tr>
      </table>
      <br>
      <table width="98%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="52%">
            <div align="center">
              <input type="button" name="button" id="button" value="Ingresar" onClick="modifica_proceso_notificado(1)">              

            </div></td>
          <td width="48%"><div align="center">
            <input type="button" name="button2" id="button2" value="Cancelar" onClick="close_va()">
          </div></td>
        </tr>
      </table></td>
  </tr>
</table>
<p>&nbsp;</p>
</form>
</body>
</html>
