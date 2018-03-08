<? session_start();
ob_start();
echo "aqui";
include('PHPMailer_v2.0.0/class.phpmailer.php'); 
function envia_correos($destino,$asunto,$mensaje_envio,$cabesa){

/*
$correo_autentica_phpmailer = "procurement@petrominerales.com";
$contrasena_autentica_phpmailer = "B0g0t4*-";
$servidor_phpmailer ="pclexch01.petrominerales.com";
$correo_from_phpmiler = "procurement@petrominerales.com";
$nombre_from_phpmiler = "Eprocurement, petrominerales";	
*/
	
$correo_autentica_phpmailer = "sterlingrene@gmail.com";
$contrasena_autentica_phpmailer = "nena1711";
$servidor_phpmailer ="smtp.gmail.com";
$correo_from_phpmiler = "sterlingrene@gmail.com";
$nombre_from_phpmiler = "Rene sterling";	
//$mail->Mailer = “smtp”;
		$mail = new PHPMailer();
		$mail->IsSMTP(); 
		
		$mail->SMTPAuth = True; 
		$mail->SMTPSecure = "ssl";
		$mail->Port       = 465; 
		$mail->SMTPDebug  = 1;
		$mail->Username = $correo_autentica_phpmailer; 
		$mail->Password = $contrasena_autentica_phpmailer; 
		$mail->Host = $servidor_phpmailer;
		$mail->From = $correo_from_phpmiler;
		$mail->FromName = $nombre_from_phpmiler;
		
		
		$mail->Subject = $asunto_msn;
		$mail->AddAddress($correo_destino,$nombre);
		
		//$mail->AddAttachment($ruta_ar, $nombre_archi);
		$mail->Body = $cuerpo;
		$mail->AltBody = "Notificaciones";
		$mail->Send();	
	
	
	
	}

envia_correos("rene.sterling@enternova.net","hola","hola",$cabesa);

echo envia_correos("rene.sterling@parservicios.com","hola","hola",$cabesa);

/*
			$subject = "Mail de aclaraciones";
			$headers = "MIME-Version: 1.0\n";
			$headers.= "Content-Type: text/html; charset=iso-8859-1\n";
			$headers.= "From: procurement@petrominerales.com\r\n";
			$headers.= "Reply-To: procurement@petrominerales.com\r\n";
			$headers.= "Return-Path: <procurement@petrominerales.com>\r\n";

			echo $contenid.= $contenido;

		
			//mail("sterlingrene@gmail.com",$subject,$contenid,$headers);		
			//mail("rene.sterling@enternova.net",$subject,$contenid,$headers);
*/			

echo "aqui fin";
	
?>	