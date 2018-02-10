<? session_start();
   ob_start();

$verifica_https = $_SERVER['HTTPS'];
if($verifica_https=="off"){
$pagina = "https://www.abastecimiento.hocol.com.co/sgpa/recordacion_contrasena.php";
header("Location: $pagina"); 
}
   
   include("librerias/lib/@include.php");
	

if($_POST["act"] == 1)
	{
		
		$verifica_email = comprobar_email($dp);
		if($verifica_email=="0"){
			?>
            	<script>
					alert("Verifique el e-mail")
					
				</script>
            <?
			exit();
			}
		
		
		
		 $cambia_cali="insert into  $t8 (cd_id, nit, razon_social, direccion, email,telefono,estado, celular) values (
		 $ciuadad, '$ap', '$bp', '$cp','$dp', '$ep', 3, '$g' )";
		 $sql_ex = query_db($cambia_cali);
	 	 $id_proveedor=id_insert();
		 
		 $cifra_c=md5($conta_1);
		 
	 $inserta_us = "insert into $t1 (nombre_administrador, usuario , contrasena , email , telefono ,estado ,accesos_fallidos,
fecha_cambio_contrasena,tipo_usuario, pv_id,pv_principal,contra_temporal)
	values ('$bp', '$dp', '$cifra_c', '$dp', '$ep',3,0,'$fecha $hora', 2, ".$id_proveedor." ,0,0)";
	$sql_e=query_db($inserta_us);



		
		 
		 	$busca_correo = traer_fila_row(query_db("select * from $tp12 where tp12_id = 2"));
			
			$id_subastas_arrglo = str_replace("---proveedor---",$bp, $busca_correo[4] );
			$id_subastas_arrglo = str_replace('---usuario---', $dp, $id_subastas_arrglo);
			$id_subastas_arrglo = str_replace('---contrasenar---', $conta_1, $id_subastas_arrglo);

		 	
		 	$asunto = $busca_correo[1];
			$cabesa = "MIME-Version: 1.0\n";
			$cabesa.= "Content-Type: text/html; charset=iso-8859-1\n";
			$cabesa.= "From: ".$busca_correo[5]." <".$busca_correo[2].">\r\n";
			$cabesa.= "Reply-To: ".$busca_correo[2]."\r\n";
			$cabesa.= "Return-Path: <".$busca_correo[2].">\r\n";
			$mensaje_envio = $id_subastas_arrglo;
			
			mail($dp,$asunto,$mensaje_envio,$cabesa);

			
		 
	?>
	 	<script>
			alert("El registro se creo con éxito")
			window.parent.location.href='index.php';
		</script>
	<?

		
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
	
	if(forma.ap.value==""){
			msg = msg + "Digite la identificación\n"
			forma.ap.className = "campos_faltantes";		
		}


	if(forma.bp.value==""){
			msg = msg + "Digite la razón social\n"
			forma.bp.className = "campos_faltantes";		
		}

	if(forma.cp.value==""){
			msg = msg + "Digite la dirección\n"
			forma.cp.className = "campos_faltantes";		
		}
	if(forma.dp.value==""){
			msg = msg + "Digite el e-mail\n"
			forma.dp.className = "campos_faltantes";		
		}
	if(forma.ep.value==""){
			msg = msg + "Digite el teléfono\n"
			forma.ep.className = "campos_faltantes";		
		}
	if(forma.pais.value=="0"){
			msg = msg + "Seleccione el país\n"
			forma.pais.className = "select_faltantes";		
		}
	if(forma.depart.value=="0"){
			msg = msg + "Seleccione el departamento\n"
			forma.depart.className = "select_faltantes";		
		}	
		

	if(forma.ciuadad.value=="0"){
			msg = msg + "Seleccione la ciudad\n"
			forma.ciuadad.className = "select_faltantes";		
		}
	
			if(forma.conta_2.value==""){
			msg = msg + "Digite la confirmación de la contraseña\n"
			forma.conta_2.className = "campos_faltantes";		
								}
			
			if(forma.conta_2.value!=forma.conta_1.value){
			msg = msg + "La confirmación de la contraseña no coincide\n"
			forma.conta_2.className = "campos_faltantes";		
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
<form name="ingreso" method="post" action="registro_proveedores.php">
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
			<legend>Registro de su empresa </legend>
<table width="95%" border="0" cellspacing="4" cellpadding="4" align="center">
  <tr>
    <td colspan="4"></td>
  </tr>
  <tr>
    <td width="18%" height="34">Identificaci&oacute;n:</td>
    <td width="33%"><div align="left">
      <label>
      
      <input name="ap" type="text" id="ap" value="<?=$busca_proveedor[1];?>" size="50">
      </label>
    </div></td>
    <td width="20%">Raz&oacute;n social:</td>
    <td width="29%"><div align="left">
        <input name="bp" type="text" id="bp" value="<?=$busca_proveedor[2];?>" size="50">
    </div>    </td>
  </tr>
  <tr>
    <td height="35">Direcci&oacute;n:</td>
    <td><div align="left">
      <input name="cp" type="text" id="cp"  value="<?=$busca_proveedor[3];?>" size="50">
    </div></td>
    <td>E-mail (Usuario):</td>
    <td><div align="left">
      <input name="dp" type="text" id="dp"  value="<?=$busca_proveedor[11];?>" size="50">
    </div></td>
  </tr>
  <tr>
    <td height="33">Tel&eacute;fono:</td>
    <td><div align="left">
      <input name="ep" type="text" id="ep" value="<?=$busca_proveedor[10];?>" size="50">
    </div></td>
    <td>Tel&eacute;fono movil:</td>
    <td><div align="left">
      <input name="g" type="text" id="g"  value="<?=$busca_proveedor[11];?>" size="50" />
    </div></td>
  </tr>
  <tr>
    <td height="35">Pa&iacute;s</td>
    <td><div align="left">
      <select name="pais" id="pais" onChange="ajax_carga('llena_ciudades.php?depar=1&var=' + this.value ,'div_dp')">
        <?=listas($t2,1,$busca_proveedor[4],'ps_nombre',1);?>
      </select>
    </div></td>
    <td>Departamento / Estado</td>
    <td><div align="left" id="div_dp">
      <select name="depart" id="depart" >
        <option value="0">Seleccione</option>
        
      </select>
    </div></td>
  </tr>
  <tr>
    <td height="35">Ciudad</td>
    <td><div align="left" id="grupo_ciudades">
      <select name="ciuadad" id="ciuadad">
        <option value="0">Seleccione</option>
        
      </select>
    </div></td>
    <td>&nbsp;</td>
    <td><label>
      
      <div align="left"></label>
    </div></td>
  </tr>
  <tr>
    <td height="35">Contrase&ntilde;a</td>
    <td><div align="left">
      <label>
      <input type="password" name="conta_1" id="conta_1">
      </label>
    </div>
      <div align="center"></div></td>
    <td>Repetir contrase&ntilde;a</td>
    <td><div align="left">
      <input type="password" name="conta_2" id="conta_2">
    </div></td>
  </tr>
  <tr>
    <td height="32" colspan="4"><label>
      <div align="center">
        <input name="button" type="button" class="guardar" id="button" value="Crear registro" onClick="crea_proveedor()" >&nbsp;
        <input name="button2" type="button"class="cancelar" id="button2" value="Cancelar registro" onClick="window.location.href='index.php'">
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
