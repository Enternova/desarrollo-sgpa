<? session_start();
   ob_start();
   
   include("librerias/lib/@include.php");
	
	if ((US_INGRESO!="") && (PW_INGRESO!="")){//si estan llenas la credenciales
		include(SUE_PATH."valida_ingreso_admin.php");
	}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<link rel='shortcut icon' href='<?=URL_COMPETA;?>/favicon.ico' />
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<title><?=TITULO;?></title>


<link href="css/principal.css" rel="stylesheet" type="text/css" />
<link href="css/reloj.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="librerias/ajax/ajax_01.js"></script>
<script type="text/javascript" src="librerias/jquery/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="librerias/jquery/jquery-ui-1.8.13.custom.min.js"></script>

<script type="text/javascript">
$(document).ready(function() {
// Create two variable with the names of the months and days in an array
var monthNames = [ "Enero", "Febrero", "Marzo", "April", "Mayo", "Junio", "Julio", "Agosto", "Septiembre", "Octubre", "Noviembre", "Diciembre" ]; 
var dayNames= ["Domingo","Lunes","Martes","Miercoles","Jueves","Viernes","Sabado"]

// Create a newDate() object
var newDate = new Date();
// Extract the current date from Date object
newDate.setDate(newDate.getDate());
// Output the day, date, month and year   
$('#Date').html(dayNames[newDate.getDay()] + " " + newDate.getDate() + ' ' + monthNames[newDate.getMonth()] + ' ' + newDate.getFullYear());

setInterval( function() {
	// Create a newDate() object and extract the seconds of the current time on the visitor's
	var seconds = new Date().getSeconds();
	// Add a leading zero to seconds value
	$("#sec").html(( seconds < 10 ? "0" : "" ) + seconds);
	},1000);
	
setInterval( function() {
	// Create a newDate() object and extract the minutes of the current time on the visitor's
	var minutes = new Date().getMinutes();
	// Add a leading zero to the minutes value
	$("#min").html(( minutes < 10 ? "0" : "" ) + minutes);
    },1000);
	
setInterval( function() {
	// Create a newDate() object and extract the hours of the current time on the visitor's
	var hours = new Date().getHours();
	// Add a leading zero to the hours value
	$("#hours").html(( hours < 10 ? "0" : "" ) + hours);
    }, 1000);	
});
</script>
</head>

<body>
<div  class="fondo_cabecera">
<?=banner_afuera();?>
</div>
<p>&nbsp;</p>
<form name="ingreso" method="post">
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="493" valign="top"><table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
      <tr>
        <td colspan="3" class="titulo_tabla_azul_sin_bordes">Soporte t&eacute;cnico</td>
      </tr>
      <tr>
        <td width="49%">Soporte t&eacute;cnico tel&eacute;fonico.:</td>
        <td width="6%">&nbsp;</td>
        <td width="45%"><div align="center">(57 1) 255 0916 </div></td>
      </tr>
      <tr>
        <td>Soporte t&eacute;cnico en linea:</td>
        <td>&nbsp;</td>
        <td><div align="center"><strong><IFRAME height=36 src="http://www.google.com/talk/service/badge/Show?tk=z01q6amlqmoqml7du5pepm30toi2uhnui32ct2mj9lo3vf9tvqrsk9gekgiclgpkqe925fg2nsealq3rbfdjechcqlb79ladogsmo21qjtnt6dpj7v46vmgvk8jes2ic3sm279c9i0614mo09kvdgc57grqib1s22bn15n9qnfst7bh0i3imr6vqn86vo4pkee9d137912levt1cq60moehi91f70&amp;w=159&amp;h=36" frameBorder=0 width=159 allowTransparency></IFRAME>

        
        </strong></div></td>
      </tr>
    </table>
      <br />
      <table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
      <tr>
        <td colspan="2" class="titulo_tabla_azul_sin_bordes">Ingreso al sistema</td>
        </tr>
      <tr>
        <td colspan="2"><?=$erro;?></td>
        </tr>
      <tr>
        <td width="33%"><div align="right">Nombre de usuario:</div></td>
        <td width="67%"><label>
          <div align="left">
            <input type="text" name="us_ingreso" id="us_ingreso" value="<?=$usuario_aterior;?>"  />
            </div>
        </label></td>
      </tr>
      <tr>
        <td><div align="right">Contrase&ntilde;a:</div></td>
        <td><label>
          <div align="left">
            <input type="password" name="pw_ingreso" id="pw_ingreso" value="<?=$contra_aterior;?>" />
            </div>
        </label></td>
      </tr>
      <? if($muestra_campo=="si"){ ?>
      <tr>
        <td><div align="right">Nueva Contrase&ntilde;a:</div></td>
        <td><div align="left">
          <input type="password" name="cambio_c" id="cambio_c"  />
        </div></td>
      </tr>
      <? } ?>
      
      <tr>
        <td><label>
          <div align="right"></div>
        </label></td>
        <td><div align="center">Acepto las politica, condiciones y terminos de uso.
          <input name="acepto_terminos" type="checkbox" class="re_eco" id="acepto_terminos" value="1" checked="checked" />
          <br />
          Ver politicas, condiciones y terminos</div></td>
      </tr>
      <tr>
        <td colspan="2"><label>
          <div align="center">
            <input name="button" type="submit" class="guardar" id="button" value="Ingresar al sistema" />
            </div>
        </label></td>
        </tr>
      <tr>
        <td colspan="2"><div align="center"><a href="recordacion_contrasena.php">Olvid&oacute; la contrase&ntilde;a</a></div></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
      <br /></td>
    <td width="493" valign="top"><table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
      <tr>
        <td class="titulo_tabla_azul_sin_bordes">Fecha y hora oficial</td>
      </tr>
      <tr>
        <td class="telefono_contacto">
        <div id="reloj_general">
        <?=fecha_for_hora($fecha." ".$hora);?>
        </div>
        
        </td>
      </tr>
    </table>
      <br />
      <table width="95%" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td width="91%"><ul><li><a href="registro_proveedores.php">Registre su empresa</a></li></ul>          </td>
      </tr>
      <tr>
        <td></td>
      </tr>
    </table>
      <br /></td>
  </tr>
</table>

<script>
function cambia_fecha_srev(i)
		{

				ajax_carga_02('muestra-reloj_general.html','reloj_general');
			i++;
			y=i	
			setTimeout("cambia_fecha_srev(y)",1000);		
		}
		
cambia_fecha_srev(1)
</script>
</form>

<p>&nbsp;</p>
<div id="cubo_pie">Subastas &amp; Comercio  2012 - Todos los derechos reservados info@subastasycomercio.com</div>


</body>
</html>
