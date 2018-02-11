<? session_start();
   ob_start();

   
//$verifica_https = $_SERVER['HTTPS'];
		

   include("librerias/lib/@include.php");
    $numero_get = valida_get();
    $numer = numero_ingresos_get();
     	  
   $verifica_url_local = $_SERVER["REQUEST_URI"];
	$sitio = explode("/",$verifica_url_local);
	if($sitio[1] == "sgpa_local"){
		if($verifica_https == "on"){// Le pone la S si es externo
//			$pagina = "http://abastecimiento.hocol.com.co/sgpa_local/";
	//		header("Location: $pagina"); 
		}
		include(SUE_PATH."valida_ingreso_local.php");	
		
	}else{  //si no es en local
	
		 	
	if ((US_INGRESO!="") && (PW_INGRESO!="")){//si estan llenas la credenciales
		/*
		if($verifica_https != "on"){// Le pone la S si es externo
			$pagina = "https://www.abastecimiento.hocol.com.co";
			header("Location: $pagina"); 
		}
		*/
	
		include(SUE_PATH."valida_ingreso_admin.php");
		
		}
		
	}

	$sitio_erro_local = explode("/",$HTTP_REFERER);
	if($sitio_erro_local[3] == "sgpa_local"){
		$erro = "<span class='texto_paginador_proveedor'>Error de ingreso automatico, su usuario no se encuentra registrado, ingrese su usuario y contraseña </span>";
		}
		
if($soporte==1)
	{
		date_default_timezone_set('America/Bogota'); //Se define la zona horaria
		//require_once('enterproc/librerias/php/class.phpmailer.php'); //Incluimos la clase phpmailer
		
		
		$error_soporte="";
		$razon_social=elimina_comillas_2($_POST["razon_social"]);
		$contacto=elimina_comillas_2($_POST["nombre_solicita"]);
		$telefono=elimina_comillas_2($_POST["telefono"]);
		$email=elimina_comillas_2($_POST["email"]);
		$ciuadad=elimina_comillas_5($_POST["ciuadad"]);
		$mensaje=elimina_comillas_2($_POST["mensaje"]);
			
			if($razon_social==""){ $error_soporte="Digite: Nombre / Raz&oacute;n social"; }
			elseif($tp17_id=="0"){ $error_soporte="Seleccione el tipo de soporte requerido"; }
			elseif($contacto==""){ $error_soporte="Digite: el nombre de la persona de contacto"; }
			elseif($telefono==""){ $error_soporte="Digite: el tel&eacute;fono de la persona de contacto"; }
			elseif($email==""){ $error_soporte="Digite: el e-mail"; }
			elseif($ciuadad=="0"){ $error_soporte="Seleccione una ciudad"; }
			//elseif(comprobar_email($email)==0) { $error_soporte="El e-mail es incorrecto"; }
			elseif($mensaje=="") { $error_soporte="Digite: Mensaje de soporte"; }			
			
			else{
				
				$inserta_soporte ="insert into help_solicitudes (razon_social, nombre_solicita, telefono, cd_id, email, mensaje, tp17_id, fecha, ip, resuelto) values ('$razon_social','$contacto','$telefono',$ciuadad,'$email','$mensaje',$tp17_id,'$fecha $hora','".$_SERVER['REMOTE_ADDR']."',1)";
				$sql_ex =  query_db($inserta_soporte);
				
				$error_soporte="El mensaje se envi&oacute;, en breve un ingeniero se contactara con  usted";
				
				
	$headers = "MIME-Version: 1.0\n";
	$headers.= "Content-Type: text/html; charset=\"ISO-8859-1\"\n";
	$headers.= "From: abastecimiento@hcl.com.co \r\n";
	$headers.="X-Mailer: PHP/". phpversion()."\n";
	$headers.= "Reply-To: abastecimiento@hcl.com.co \r\n";
	$headers.= "Return-Path: <abastecimiento@hcl.com.co>\r\n";
	$asunto="Nuevo soporte tecnico HOCOL SA";
	$mensaje_envio="Por favor ingrese al sistema de HOCOL SA y revise las solicitudes de soporte";
	$envio_email_confirma =  mail("mesa-ayuda@enternova.net",$asunto,$mensaje_envio,$headers);

					
				
		$razon_social="";
		$nombre_solicita="";
		$telefono="";
		$email="";
		$ciuadad="";
		$depart="";
		$pais="";
		$tp17_id="";
		$mensaje="";

				
				}
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
<!-- prueba de git josef -->
<div  class="">
<?=banner_afuera();?>
</div>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
    <td width="493" valign="top">
    <form name="ingreso" method="post" enctype="multipart/form-data">
      <br />
      <table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
        <tr>
          <td class="titulo_tabla_azul_sin_bordes">Soporte t&eacute;cnico para la Urna Virtual</td>
          </tr>
        <tr>
          <td width="43%" align="center" class="telefono_contacto"><div align="center"> (57) 316 526 3021 - (57 1) 381 6521 Opci&oacute;n 1<br />
            E-mail
          : mesa-ayuda@enternova.net</div></td>
          </tr>
        </table>
      <br />
      <br />
      <table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
        <tr>
          <td class="titulo_tabla_azul_sin_bordes">Soporte T&eacute;cnico para Tarifas y SGPA</td>
        </tr>
        <tr>
          <td width="43%" align="center" class="telefono_contacto"><div align="center">Front Desk (57 1) 488 4000 Ext 4444 - prueba55</div></td>
        </tr>
      </table>
      <br />
      <table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
      <tr>
        <td colspan="2" class="titulo_tabla_azul_sin_bordes">Ingreso al Sistema <?=$texto_modulo_pruebas?></td>
        </tr>
      <tr>
        <td colspan="2" ><font color="#FF0000" size="+1"><strong><?=$erro;?></strong></font></td>
        </tr>
      <tr>
        <td width="33%"><div align="right">Nombre de usuario:</div></td>
        <td width="67%">
          <div align="left">
            <input type="text" name="us_ingreso" id="us_ingreso" value="<?=$usuario_aterior;?>"  />
            </div>
        </td>
      </tr>
      <tr>
        <td><div align="right">Contrase&ntilde;a:</div></td>
        <td>
          <div align="left">
            <input type="password" name="pw_ingreso" id="pw_ingreso" value="<?=$contra_aterior;?>" />
            </div>
        </td>
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
        <td>
          <div align="right"></div>
        </td>
        <td><div align="center">Acepto las pol&iacute;ticas, condiciones y t&eacute;rminos de uso.
            <input name="acepto_terminos" type="checkbox" class="re_eco" id="acepto_terminos" value="1" checked="checked" />
          <br /><a href="terminos-condiciones.php">Ver pol&iacute;ticas, condiciones y t&eacute;rminos</a></div></td>
      </tr>
      <tr>
        <td colspan="2">
          <div align="center">
            <input name="button" type="submit" class="guardar" id="button" value="Ingresar al sistema" />
            </div>
        <input name="fecha_sistema" type="hidden" id="fecha_sistema" size="5" readonly="readonly" value="<?=date("Y-m-d")?>"/></td>
        </tr>
      <tr>
        <td colspan="2"><div align="center"><a href="recordacion_contrasena.php">Olvid&oacute; la contrase&ntilde;a</a></div></td>
        </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table>
    </form>
      <br />
      <table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
        <tr>
          <td class="titulo_tabla_azul_sin_bordes">Fecha y hora oficial</td>
        </tr>
        <tr>
          <td class="telefono_contacto"><div id="reloj_general">
            <?=fecha_for_hora($fecha." ".$hora);?>
          </div></td>
        </tr>
      </table></td>
    <td width="493" valign="top">
    <form name="soporte" method="post" enctype="multipart/form-data">
      <br />
      <table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
        <tr>
          <td width="43%" align="center" class="telefono_contacto">Solicite Soporte T&eacute;cnico por Mensaje
            <div align="center"></div></td>
        </tr>
      </table>
      <br />
      <br />
    <table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
      <tr>
          <td colspan="2" class="titulo_tabla_azul_sin_bordes">Solicitud de soporte t&eacute;cnico por mensaje</td>
          </tr>
        <tr>
          <td colspan="2" >Por favor complete el siguiente formulario y lo contactaremos en el menor tiempo posible.</br>
            <span class="texto_paginador_proveedor">
            <?=$error_soporte;?></span></td>
          </tr>
        <tr>
          <td align="right" id="razon_social_id2" >Tipo de soporte:</td>
          <td ><select name="tp17_id" id="tp17_id" >
            <?=listas("t1_categoria_help"," tipo = 1 ",$tp17_id,'nombre',1);?>
          </select></td>
        </tr>
        <tr>
          <td width="35%" align="right" id="razon_social_id" ><div >Nombre / Raz&oacute;n social:</div></td>
          <td width="65%" >
            <input type="text" name="razon_social" id="razon_social" value="<?=$razon_social;?>" />
          </td>
        </tr>
        <tr>
          <td align="right" >Persona de contacto:</td>
          <td ><input type="text" name="nombre_solicita" id="nombre_solicita"  value="<?=$nombre_solicita;?>"/></td>
        </tr>
        <tr>
          <td align="right" >Tel&eacute;fono de contacto:</td>
          <td ><input type="text" name="telefono" id="telefono"  value="<?=$telefono;?>"/></td>
        </tr>
        <tr>
          <td align="right" >E-mail de contacto:</td>
          <td ><input type="text" name="email" id="email"  value="<?=$email;?>"/></td>
        </tr>
        <tr>
          <td align="right" >Pa&iacute;s:</td>
          <td >
           
          <select name="pais" id="pais" onchange="ajax_carga_02('llena_ciudades.php?depar=1&amp;var=' + this.value ,'div_dp')">
           <?=listas("ps_pais"," ps_estado>=1 ",$pais,'ps_nombre',1);?>
          </select></td>
        </tr>
        <tr>
          <td align="right" >Departamento / Estado:</td>
          <td ><div align="left" id="div_dp">
      <select name="depart" id="depart" >
        <option value="0">Seleccione</option>
          <?
		$sele_maes = query_db("select * from dp_departamento where ps_id   = $pais  order by dp_nombre "); 
		while($lm=traer_fila_row($sele_maes)) {	
		if($lm[0]==$depart){
				$slecciona = "selected";
			}else{
				$slecciona = "";
			}
		
		?>
       <option value="<?=$lm[0];?>" <?=$slecciona;?>><?=$lm[2];?></option>
                <? } ?>
      </select>
    </div></td>
        </tr>
        <tr>
          <td align="right" >Ciudad:</td>
          <td ><div align="left" id="grupo_ciudades">
      <select name="ciuadad" id="ciuadad">
        <option value="0">Seleccione</option>

		   <?
		$sele_maes = query_db("select * from cd_ciudad where dp_id   = $depart  order by cd_nombre "); 
		while($lm=traer_fila_row($sele_maes)) {	
				if($lm[0]==$ciuadad){
				$slecciona = "selected";
			}else{
				$slecciona = "";
			}
		?>
       <option value="<?=$lm[0];?>"  <?=$slecciona;?>><?=$lm[2];?></option>
                <? } ?>        
        
      </select>
    </div></td>
        </tr>
        <tr>
          <td align="right" >Detalle de la solicitud:</td>
          <td >&nbsp;</td>
        </tr>
        <tr>
          <td colspan="2" >
            <textarea name="mensaje" id="mensaje" cols="45" rows="5"><?=$mensaje;?></textarea>
         </td>
          </tr>
        <tr>
          <td colspan="2" align="center" >
            <input name="button2" type="submit" class="guardar" id="button2" value="Enviar solicitud de soporte" />
            </td>
        </tr>
      </table>
      <input type="hidden" name="soporte" value="1" />
      </form>
      </td>
  </tr>
</table>


<!--prueba de git --> <!--prueba de git --> <!--prueba de git --> <!--prueba de git --> <!--prueba de git --> <!--prueba de git --> <!--prueba de git --> <!--prueba de git --> 
<!--prueba de git --> 
<!--prueba de git --> 

<p>&nbsp;</p>
<div id="cubo_pie">Enternova  2013 - Todos los derechos reservados info@enternova.net - ******</div>

<!-- prueba de git josef -->
</body>
</html>
