<?
date_default_timezone_set('America/Bogota'); //Se define la zona horaria
require_once('class.phpmailer.php'); //Incluimos la clase phpmailer

$mail = new PHPMailer(true); // Declaramos un nuevo correo, el parametro true significa que mostrara excepciones y errores.

$mail->IsSMTP(); // Se especifica a la clase que se utilizará SMTP


//------------------------------------------------------
  $correo_emisor="rene.sterling@enternova.net";     //Correo a utilizar para autenticarse
  $nombre_emisor="Soporte Compras KEY ENERGY SERVICES";               //Nombre de quien envía el correo
  $contrasena="nena1711";          //contraseña de tu cuenta en Gmail
  $correo_destino="rene.sterling@parservicios.com";      //Correo de quien recibe
  $nombre_destino="Proveedor";                //Nombre de quien recibe   	
//--------------------------------------------------------
 $mail->SMTPDebug  = 2;                     // Habilita información SMTP (opcional para pruebas)
  $mail->SMTPAuth   = true;                  // Habilita la autenticación SMTP
  $mail->SMTPSecure = "ssl";                 // Establece el tipo de seguridad SMTP
  $mail->Host       = "smtp.gmail.com";      // Establece Gmail como el servidor SMTP
  $mail->Port       = 465;                   // Establece el puerto del servidor SMTP de Gmail
  $mail->Username   = $correo_emisor;  	     // Usuario Gmail
  $mail->Password   = $contrasena;           // Contraseña Gmail
  $mail->AddReplyTo($correo_emisor, $nombre_emisor);
  $mail->AddAddress($correo_destino, $nombre_destino);
  $mail->SetFrom($correo_emisor, $nombre_emisor);
  $mail->Subject ="Prueba key";
  $mail->AltBody = "Prueba key";
  $mail->MsgHTML("Prueba key");
  //$mail->Send();
  echo "<div style='text-align:center'>Mensaje enviado. Que chivo va vos!!</div>";
 
  
  echo "si";	



?>	
