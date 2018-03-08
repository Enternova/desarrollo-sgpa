<? 


	$subject = "p hocol";
	$headers = "MIME-Version: 1.0\n";
	$headers.= "Content-Type: text/html; charset=\"utf-8\"\n";
	$headers.= "From:abastecimiento@hocol.com.co\r\n";
	$headers.="X-Mailer: PHP/". phpversion()."\n";
	$headers.= "Reply-To: abastecimiento@hocol.com.co \r\n";
	$headers.= "Return-Path: <abastecimiento@hocol.com.co>\r\n";
		
	//echo mail("rene.sterling@enternova.net", $subject, "hocol prueba", $headers);





date_default_timezone_set('America/Bogota'); //Se define la zona horaria
require_once('class.phpmailer.php'); //Incluimos la clase phpmailer


/*
Usuario:             Abastecimiento
 
Contraseña:       Ab4$t3c1m13nt0 (Cotraseña nunca caduca)
 
Mailbox:            Notificaciones, Abastecimiento
 
Correo:              abastecimiento@hocol.com.co
*/


function envia_correos($destino,$asunto,$mensaje_envio,$cabesa)
	{
   $mail = new PHPMailer(true); // Declaramos un nuevo correo, el parametro true significa que mostrara excepciones y errores.

$mail->IsSMTP(); // Se especifica a la clase que se utilizará SMTP


//------------------------------------------------------
  $correo_emisor="abastecimiento@hocol.com.co";     //Correo a utilizar para autenticarse
					     //Gmail o de GoogleApps
  $nombre_emisor="Notificaciones, Abastecimiento";               //Nombre de quien envía el correo
  $contrasena='Ab4$t3c1m13nt0';          //contraseña de tu cuenta en Gmail
  $correo_destino=$destino;      //Correo de quien recibe
  $nombre_destino="Proveedor";                //Nombre de quien recibe   	
//--------------------------------------------------------
  $mail->SMTPDebug  = 2;                     // Habilita información SMTP (opcional para pruebas)
                                             // 1 = errores y mensajes
                                             // 2 = solo mensajes
  $mail->SMTPAuth   = false;                  // Habilita la autenticación SMTP
  //$mail->SMTPSecure = "ssl";                 // Establece el tipo de seguridad SMTP
  $mail->Host       = "192.168.100.30";      // Establece Gmail como el servidor SMTP
  $mail->Port       = 25;                   // Establece el puerto del servidor SMTP de Gmail
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
  $mail->ConfirmReadingTo = "rene.sterling@parservicios.com";
  $mail->SMTPDebug = true;
  //Enviamos el correo
 if($mail->Send()){ // Envía el correo.
        $result .= "<b class='green'>El correo fue enviado correctamente.</b>".$destino;
        echo $result;
    }else{
        error_log($mail->ErrorInfo, 0);
        $result .= "<b class='red'>Hubo un inconveniente.</b><br />".$mail->ErrorInfo."Por favor, inténtalo más tarde.<br /><br />Recuerde que puede ponerse en contacto con nosotros por teléfono o directamente por correo electrónico.<br />Perdonen por las molestias causadas.";
        echo $result;
    }

  


	}


envia_correos("rene.sterling@parservicios.com","prueba hocol confirma","prueba hocol","5");


?>