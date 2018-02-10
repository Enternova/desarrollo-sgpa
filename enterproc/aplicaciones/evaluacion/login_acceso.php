<?  include("../../librerias/lib/@session.php");

?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">

<link href="../../css/principal.css" rel="stylesheet" type="text/css">
</head>
<body >

<table width="80%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td><table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
        <tr>
          <td colspan="2"><?=$erro;?></td>
          </tr>
        <tr>
          <td width="30%"><div align="right">Usuario:</div></td>
          <td width="70%">
            <div align="left">
              <input type="text" name="us_ingreso" id="us_ingreso" value="<?=$usuario_cambia;?>">
              <input type="hidden" name="id_p" id="id_p" value="<?=$id_p;?>">
              <input type="hidden" name="cambi" id="cambi" value="<?=$cambi;?>"> 
                            </div>
          </td>
        </tr>
        <tr>
          <td><div align="right">Contrase&ntilde;a:</div></td>
          <td><div align="left">
            <input type="password" name="pw_ingreso" id="pw_ingreso" value="<?=$contra_cambi;?>">
           
          </div></td>
        </tr>
      <? if($cambi==1) { ?>
        <tr>
          <td><div align="right">Nueva Contrase&ntilde;a:</div></td>
          <td><input type="password" name="pw_ingreso_nueva" id="pw_ingreso_nueva"></td>
        </tr>
        <? } ?>
      </table>
      <br>
      <table width="98%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="52%">
            <div align="center">
              <input name="button" type="button" class="guardar" id="button" onClick="ingreso_evaluador_login()" value="Ingresar">              

            </div></td>
          <td width="48%"><div align="center">
            <input name="button2" type="button" class="cancelar" id="button2" onClick="cerrar_proveedores_lista()" value="Cancelar">
          </div></td>
        </tr>
      </table></td>
  </tr>
</table>
<p>&nbsp;</p>

</body>
</html>
