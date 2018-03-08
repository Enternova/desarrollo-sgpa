<? session_start();
ob_start();
echo "aqui";
require_once('class.phpmailer.php'); //Incluimos la clase phpmailer

function envia_correos($destino,$asunto,$mensaje_envio,$cabesa)
	{
	global $usuario_correo,$contrasena_correo,$nombre_correo;
$mail = new PHPMailer(true); // Declaramos un nuevo correo, el parametro true significa que mostrara excepciones y errores.

$mail->IsSMTP(); // Se especifica a la clase que se utilizará SMTP


//------------------------------------------------------
  $correo_emisor="rene.sterling@enternova.net";     //Correo a utilizar para autenticarse
					     //Gmail o de GoogleApps
  $nombre_emisor="Rene sterling";               //Nombre de quien envía el correo
  $contrasena="nena1711";          //contraseña de tu cuenta en Gmail
  $correo_destino="sterlingrene@gmail.com";      //Correo de quien recibe
  $nombre_destino="Proveedor";                //Nombre de quien recibe   	
//--------------------------------------------------------
  $mail->SMTPDebug  = 2;                     // Habilita información SMTP (opcional para pruebas)
                                             // 1 = errores y mensajes
                                             // 2 = solo mensajes
  $mail->SMTPAuth   = true;                  // Habilita la autenticación SMTP
  $mail->SMTPSecure = "ssl";                 // Establece el tipo de seguridad SMTP
  $mail->Host       = "smtp.gmail.com";      // Establece Gmail como el servidor SMTP
  $mail->Port       = 465;                   // Establece el puerto del servidor SMTP de Gmail
  $mail->Username   = $correo_emisor;  	     // Usuario Gmail
  $mail->Password   = $contrasena;           // Contraseña Gmail
  //A que dirección se puede responder el correo
  $mail->AddReplyTo($correo_emisor, $nombre_emisor);
  //La direccion a donde mandamos el correo
  $mail->AddAddress($correo_destino, $nombre_destino);
  //De parte de quien es el correo
  $mail->SetFrom($correo_emisor, $nombre_emisor);
  //Asunto del correo
  $mail->Subject = $asunto;
  //Mensaje alternativo en caso que el destinatario no pueda abrir correos HTML
  $mail->AltBody = $asunto;
  //El cuerpo del mensaje, puede ser con etiquetas HTML
  $mail->MsgHTML($mensaje_envio);
  //Archivos adjuntos
  //$mail->AddAttachment('img/logo.jpg');      // Archivos Adjuntos
  
  //Enviamos el correo
  $mail->Send();
  

		//mail($destino,$asunto,$mensaje_envio,$cabesa);
		

	}
	
?>	