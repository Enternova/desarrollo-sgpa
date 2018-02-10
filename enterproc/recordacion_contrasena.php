<? session_start();
   ob_start();
   
   include("librerias/lib/@include.php");
	

if($_POST["act"] == 1)
	{
		
		$verifica_email = comprobar_email($dp);
		if($verifica_email=="0"){
			?>
            	<script>
					alert("Verifique el e-mail")
					window.parent.location.href='index.php';
					
					
				</script>
            <?
			
			}
		
		else{
		
		
		$alfabeto = array("A","B","C","D","E","F", "G","H","I","J","K","L","M","N","P","Q","R","S","T","U","V", "W","X","Y","Z","1","2","3", "4","5","6","7","8","9");
			for($i=0;$i<=8;$i++){
			$generador = rand(0,34);
			$nueva_c.= $alfabeto[$generador];
					}
			$n_contrasena_e=$nueva_c;

			$busca_usuario=traer_fila_row(query_db("select us_id, usuario, nombre_administrador  from $t1 where usuario  = '$dp' and estado = 1"));
			if($busca_usuario[0]>=1){

			$cambia_cali="update $t1 set  contrasena = md5('".$nueva_c."'), contra_temporal = 1   where us_id = $busca_usuario[0]";
		 	$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 3"));
			
			$id_subastas_arrglo = str_replace("---proveedor---",$busca_usuario[2], $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---usuario---', $busca_usuario[1], $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---contrasenar---', $n_contrasena_e, $id_subastas_arrglo);

		 	
		 	$asunto = $busca_correo[1];
			$cabesa = "MIME-Version: 1.0\n";
			$cabesa.= "Content-Type: text/html; charset=iso-8859-1\n";
			$cabesa.= "From: ".$busca_correo[5]." <".$busca_correo[2].">\r\n";
			$cabesa.= "Reply-To: ".$busca_correo[2]."\r\n";
			echo $cabesa.= "Return-Path: <".$busca_correo[2].">\r\n";
			echo $mensaje_envio = $id_subastas_arrglo;
			
			mail($dp,$asunto,$mensaje_envio,$cabesa);

			
		 
	?>
	 	<script>
			alert("El registro se creo con éxito")
			window.parent.location.href='index.php';
		</script>
	<?


	}

	else
		{
	?>
	 	<script>
			alert("El usuario no existe")
			window.parent.location.href='index.php';
		</script>
	<?		
		
		}
		
		}
		
}





?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<title><?=TITULO;?></title>
<link href="css/reloj.css" rel="stylesheet" type="text/css" />

<link href="css/principal.css" rel="stylesheet" type="text/css" />
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

function crea_proveedor(){
		var forma = document.ingreso
		var msg=""
	
	
	if(forma.dp.value==""){
			msg = msg + "Digite el e-mail\n"
			forma.dp.className = "campos_faltantes";		
		}
	
		
		
	
		if(msg!="")
			{
				alert("Verifique el formulario\n" + msg)
				return
				
				}
		else
			{
					forma.submit()
					
				}


	
	}	

</script>
</head>

<body>
<div  id="cubo_fondo">
<?=banner();?>
</div>
<p>&nbsp;</p>
<form name="ingreso" method="post" action="recordacion_contrasena.php">
<table width="1000" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="493" valign="top"><table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
      <tr>
        <td colspan="3" class="titulo_tabla_azul_sin_bordes">Soporte t&eacute;cnico</td>
      </tr>
      <tr>
        <td width="49%">Soporte t&eacute;cnico tel&eacute;fonico:</td>
        <td width="6%">&nbsp;</td>
        <td width="45%"><div align="center">(57 1) 255 0916 </div></td>
      </tr>
      <tr>
        <td>Soporte t&eacute;cnico en linea:</td>
        <td>&nbsp;</td>
        <td><div align="center"><strong>
          <iframe height="36" src="http://www.google.com/talk/service/badge/Show?tk=z01q6amlqmoqml7du5pepm30toi2uhnui32ct2mj9lo3vf9tvqrsk9gekgiclgpkqe925fg2nsealq3rbfdjechcqlb79ladogsmo21qjtnt6dpj7v46vmgvk8jes2ic3sm279c9i0614mo09kvdgc57grqib1s22bn15n9qnfst7bh0i3imr6vqn86vo4pkee9d137912levt1cq60moehi91f70&amp;w=159&amp;h=36" frameborder="0" width="159" allowtransparency="allowTransparency"></iframe>
        </strong></div></td>
      </tr>
    </table></td>
    <td width="493" valign="top"><table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
      <tr>
        <td class="titulo_tabla_azul_sin_bordes">Fecha y hora oficial</td>
      </tr>
      <tr>
        <td class="telefono_contacto"><div class="clock">
            <div id="Date"></div>
          Hora
          <spam id="hours"></spam>
          :
          <spam id="min"></spam>
          :
          <spam id="sec"></spam>
          GMT (-5) <br />
          <br />
        </div></td>
      </tr>
    </table></td>
  </tr>
  <tr>
  	<td colspan="2">
    
<br />
<fieldset style="width:98%">
			<legend>Recordaci&oacute;n de contrase&ntilde;a </legend>
<table width="95%" border="0" cellspacing="4" cellpadding="4" align="center">
  <tr>
    <td colspan="2"></td>
  </tr>
  <tr>
    <td width="20%" height="35">E-mail (Usuario):</td>
    <td width="29%"><div align="left">
      <input name="dp" type="text" id="dp"  value="<?=$busca_proveedor[11];?>" size="50">
    </div></td>
  </tr>
  <tr>
    <td height="32" colspan="2"><label>
      <div align="center">
        <input name="button" type="button" class="guardar" id="button" value="Recordar contrase&ntilde;a" onClick="crea_proveedor()" >
        <input name="button2" type="button" class="cancelar" id="button2" value="Cancelar recordaci&oacute;n" onClick="window.parent.location.href='index.php'">
      </div>
    </label></td>
  </tr>
</table>
<br>
</fieldset>    
    
    
    </td>
    </tr>
</table>

<input type="hidden" name="act" value="1" />

</form>

<p>&nbsp;</p>
<div id="cubo_pie">Enterprise technological innovations s.a.s 2012 - Todos los derechos reservados info@enternova.net</div>


</body>
</html>
