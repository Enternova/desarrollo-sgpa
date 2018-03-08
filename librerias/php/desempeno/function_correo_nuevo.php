<?php


//CORREO SOLICITUD DEFINIR CRITERIOS CONTRATO PUNTUAL
function mensaje_contrato_puntual_enviosolicitud_definicion_criterio($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_crea_aspectos from vista_t9_contrato_puntual where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_crea_aspectos=$result[5];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_crea_aspectos));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
	$asunto="Pendiente Definir Criterios Técnicos";
	
	$destino1="fodorvonlh22@gmail.com";
	$destino2="jeison.rivera@enternova.net";
	
include "PHPMailer-master/class.phpmailer.php";
include "PHPMailer-master/class.smtp.php";
include "PHPMailer-master/PHPMailerAutoload.php";

					$email_user = "Quinsilverr@gmail.com";
					$email_password = "23140756";
					$the_subject = "Pendiente Definir Criterios Técnicos";
					$address_to = $destino1;
					$from_name = "SGPA Desempeño";
					$phpmailer = new PHPMailer();
					// ---------- datos de la cuenta de Gmail -------------------------------
					$phpmailer->Username = $email_user;
					$phpmailer->Password = $email_password; 
					//-----------------------------------------------------------------------
					// $phpmailer->SMTPDebug = 1;
					$phpmailer->SMTPSecure = 'ssl';
					$phpmailer->Host = "smtp.gmail.com"; // GMail
					$phpmailer->Port = 465;
					$phpmailer->IsSMTP(); // use SMTP
					$phpmailer->SMTPAuth = true;
					$phpmailer->setFrom($phpmailer->Username,$from_name);
					$phpmailer->AddAddress($address_to); // recipients email
					$phpmailer->IsHTML(true);
					$phpmailer->Subject = $the_subject;	

					$body ='<html>
									<body>
										<table>
										<tr><td>Apreciado.</td><td>'.$usuario.'</td></tr>
										</table><br>
										<table>
										<tr>El '.$fecha_inicio_contrato.' , se suscribió con '.$nombre_proveedor.', el contrato N° '.$numero_documento.' para la prestación del servicio ('.$objeto.'),
										el cual es gerenciado por el Sr. '.$nombre_gerente.'.Por favor establezca los criterios con los cuales se evaluará el desempeño del contratista 
										en los servicios que se ejecutarán en el marco del contrato.</tr>
										</table><br>
										Adjuntos:('.$destino.')	
									</body>
								</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
}

//CORREO ENVIO DE CRITERIOS PARA APROBACION
function mensaje_contrato_puntual_enviojefe_aprobacion_criterio($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_jefe from vista_t9_contrato_puntual where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_jefe=$result[5];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_jefe));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
	
	$asunto="Pendiente Aprobación de Criterios Técnicos";
	
	$destino1="fodorvonlh22@gmail.com";
	$destino2="jeison.rivera@enternova.net";
$select_tabla="select nombre_aspectos, puntaje_maximo FROM vista_t9_contrato_puntual where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;

$query=query_db($select_tabla);

include "PHPMailer-master/class.phpmailer.php";
include "PHPMailer-master/class.smtp.php";
include "PHPMailer-master/PHPMailerAutoload.php";

					$email_user = "Quinsilverr@gmail.com";
					$email_password = "23140756";
					$the_subject = "Pendiente Aprobación de Criterios Técnicos";
					$address_to = $destino1;
					$from_name = "SGPA Desempeño";
					$phpmailer = new PHPMailer();
					// ---------- datos de la cuenta de Gmail -------------------------------
					$phpmailer->Username = $email_user;
					$phpmailer->Password = $email_password; 
					//-----------------------------------------------------------------------
					// $phpmailer->SMTPDebug = 1;
					$phpmailer->SMTPSecure = 'ssl';
					$phpmailer->Host = "smtp.gmail.com"; // GMail
					$phpmailer->Port = 465;
					$phpmailer->IsSMTP(); // use SMTP
					$phpmailer->SMTPAuth = true;
					$phpmailer->setFrom($phpmailer->Username,$from_name);
					$phpmailer->AddAddress($address_to); // recipients email
					$phpmailer->IsHTML(true);
					$phpmailer->Subject = $the_subject;	

					$body ='<html>
									<body>
										<table>
										<tr><td>Sr.</td><td>'.$usuario.'</td></tr>
										</table><br>
										<table>
										<tr>El '.$fecha_inicio_contrato.' , se suscribió con '.$nombre_proveedor.', el contrato N° '.$numero_documento.' para la prestación del servicio ('.$objeto.'),
										el cual es gerenciado por el Sr. '.$nombre_gerente.'.Para realizar la evaluación de desempeño del proveedor en el contrato ya mencionado, el Gerente del contrato estableció 
										los criterios a continuación, los cuales requieren su aprobación para realizar la posterior evaluación.</tr>
										</table><br>
										Adjuntos:('.$destino.')	
									<br><br><br>
									
									<table border="1">
									<tr><td >ASPECTOS DEFINIDOS</td><td>PUNTOS</td></tr>';
									
										
										while($lt=traer_fila_db($query)){
											
										$body.='<tr> <td>'.$lt[0].'</td><td>'.$lt[1].'</td> </tr>';
											
											}
											
										$body.='
										</table>
									</body>
								</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
}


//CORREO ENVIO DE CRITERIOS APROBADOS AL PROVEEDOR
function mensaje_contrato_puntual_envioproveedor_criterios_aprobados($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_proveedor from vista_t9_contrato_puntual where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_proveedor=$result[5];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_proveedor));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
	
	$asunto="Criterios Técnicos Aprobados para Evaluarlo";
	
	$destino1="fodorvonlh22@gmail.com";
	$destino2="jeison.rivera@enternova.net";
$select_tabla="select nombre_aspectos, puntaje_maximo FROM vista_t9_contrato_puntual where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;

$query=query_db($select_tabla);

include "PHPMailer-master/class.phpmailer.php";
include "PHPMailer-master/class.smtp.php";
include "PHPMailer-master/PHPMailerAutoload.php";

					$email_user = "Quinsilverr@gmail.com";
					$email_password = "23140756";
					$the_subject = "Criterios Técnicos Aprobados para Evaluarlo";
					$address_to = $destino1;
					$from_name = "SGPA Desempeño";
					$phpmailer = new PHPMailer();
					// ---------- datos de la cuenta de Gmail -------------------------------
					$phpmailer->Username = $email_user;
					$phpmailer->Password = $email_password; 
					//-----------------------------------------------------------------------
					// $phpmailer->SMTPDebug = 1;
					$phpmailer->SMTPSecure = 'ssl';
					$phpmailer->Host = "smtp.gmail.com"; // GMail
					$phpmailer->Port = 465;
					$phpmailer->IsSMTP(); // use SMTP
					$phpmailer->SMTPAuth = true;
					$phpmailer->setFrom($phpmailer->Username,$from_name);
					$phpmailer->AddAddress($address_to); // recipients email
					$phpmailer->IsHTML(true);
					$phpmailer->Subject = $the_subject;	

					$body ='<html>
									<body>
										<table>
										<tr><td>Sr.</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>El '.$fecha_inicio_contrato.' , se suscribió con '.$nombre_proveedor.', el contrato N° '.$numero_documento.', para la prestación del servicio de
										'.$objeto.' Por favor tenga en cuenta que su desempeño en la ejecución de este contrato será evaluado teniendo en cuenta los criterios 
										que se relacionan a continuación. </tr>
										</table><br>
										Adjuntos:('.$destino.')	
									<br><br><br>
									
									<table border="1">
									<tr><td >ASPECTOS DEFINIDOS</td><td>PUNTOS</td></tr>';
									
										
										while($lt=traer_fila_db($query)){
											
										$body.='<tr> <td>'.$lt[0].'</td><td>'.$lt[1].'</td> </tr>';
											
											}
											
										$body.='
										</table>
									</body>
								</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
}


//CORREO SOLICITUD EVALUACION TECNICA CONTRATO PUNTUAL
function mensaje_contrato_puntual_enviosolicitud_evaluacion_tecnica($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_evaluador from vista_t9_contrato_puntual where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_evaluador=$result[5];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_evaluador));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
	$asunto="Pendiente Por Evaluacion Técnicos";
	
	$destino1="fodorvonlh22@gmail.com";
	$destino2="jeison.rivera@enternova.net";
	
include "PHPMailer-master/class.phpmailer.php";
include "PHPMailer-master/class.smtp.php";
include "PHPMailer-master/PHPMailerAutoload.php";

					$email_user = "Quinsilverr@gmail.com";
					$email_password = "23140756";
					$the_subject = "Pendiente Por Evaluacíon ";
					$address_to = $destino1;
					$from_name = "SGPA Desempeño";
					$phpmailer = new PHPMailer();
					// ---------- datos de la cuenta de Gmail -------------------------------
					$phpmailer->Username = $email_user;
					$phpmailer->Password = $email_password; 
					//-----------------------------------------------------------------------
					// $phpmailer->SMTPDebug = 1;
					$phpmailer->SMTPSecure = 'ssl';
					$phpmailer->Host = "smtp.gmail.com"; // GMail
					$phpmailer->Port = 465;
					$phpmailer->IsSMTP(); // use SMTP
					$phpmailer->SMTPAuth = true;
					$phpmailer->setFrom($phpmailer->Username,$from_name);
					$phpmailer->AddAddress($address_to); // recipients email
					$phpmailer->IsHTML(true);
					$phpmailer->Subject = $the_subject;	

					$body ='<html>
									<body>
										<table>
										<tr><td>Apreciado .</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>Durante el periodo comprendido entre el '.$fecha_inicio_contrato.' , se suscribió con  '.$nombre_proveedor.', bajo el contrato N° '.$numero_documento.', 
										para la prestación del servicio de '.$objeto.', Por favor realice la evaluación técnica de desempeño al proveedor teniendo en cuenta 
										los criterios establecidos para evaluar al mismo. </tr>
										</table><br>
										Adjuntos:('.$destino.')	
									</body>
								</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
}




//CORREO SOLICITUD DEFINIR CRITERIOS CONTRATO MARCO
function mensaje_contrato_marco_enviosolicitud_definicion_criterio($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_crea_aspectos from vista_t9_contrato_puntual where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_crea_aspectos=$result[5];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_crea_aspectos));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
	$asunto="Pendiente Definir Criterios Técnicos";
	
	$destino1="fodorvonlh22@gmail.com";
	$destino2="jeison.rivera@enternova.net";
	
include "PHPMailer-master/class.phpmailer.php";
include "PHPMailer-master/class.smtp.php";
include "PHPMailer-master/PHPMailerAutoload.php";

					$email_user = "Quinsilverr@gmail.com";
					$email_password = "23140756";
					$the_subject = "Pendiente Definir Criterios Técnicos";
					$address_to = $destino1;
					$from_name = "SGPA Desempeño";
					$phpmailer = new PHPMailer();
					// ---------- datos de la cuenta de Gmail -------------------------------
					$phpmailer->Username = $email_user;
					$phpmailer->Password = $email_password; 
					//-----------------------------------------------------------------------
					// $phpmailer->SMTPDebug = 1;
					$phpmailer->SMTPSecure = 'ssl';
					$phpmailer->Host = "smtp.gmail.com"; // GMail
					$phpmailer->Port = 465;
					$phpmailer->IsSMTP(); // use SMTP
					$phpmailer->SMTPAuth = true;
					$phpmailer->setFrom($phpmailer->Username,$from_name);
					$phpmailer->AddAddress($address_to); // recipients email
					$phpmailer->IsHTML(true);
					$phpmailer->Subject = $the_subject;	

					$body ='<html>
									<body>
										<table>
										<tr><td>Apreciado.</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>El '.$fecha_inicio_contrato.' , se suscribió con '.$nombre_proveedor.', el contrato N° '.$numero_documento.', para la prestación del servicio de  <br>
										'.$objeto.' Por favor establezca los criterios con los cuales se evaluará el desempeño del contratista en los servicios que se 
										ejecutarán en el marco del contrato.</tr>
										<table><br>
										Adjuntos:('.$destino.')	
									</body>
								</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
}

//CORREO ENVIO DE CRITERIOS PARA APROBACION
function mensaje_contrato_marco_enviojefe_aprobacion_criterio($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_jefe from vista_t9_contrato_puntual where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_jefe=$result[5];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_jefe));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
	
	$asunto="Pendiente Aprobación de Criterios Técnicos";
	
	$destino1="fodorvonlh22@gmail.com";
	$destino2="jeison.rivera@enternova.net";
$select_tabla="select nombre_aspectos, puntaje_maximo FROM vista_t9_contrato_puntual where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;

$query=query_db($select_tabla);

include "PHPMailer-master/class.phpmailer.php";
include "PHPMailer-master/class.smtp.php";
include "PHPMailer-master/PHPMailerAutoload.php";

					$email_user = "Quinsilverr@gmail.com";
					$email_password = "23140756";
					$the_subject = "Pendiente Aprobación de Criterios Técnicos";
					$address_to = $destino1;
					$from_name = "SGPA Desempeño";
					$phpmailer = new PHPMailer();
					// ---------- datos de la cuenta de Gmail -------------------------------
					$phpmailer->Username = $email_user;
					$phpmailer->Password = $email_password; 
					//-----------------------------------------------------------------------
					// $phpmailer->SMTPDebug = 1;
					$phpmailer->SMTPSecure = 'ssl';
					$phpmailer->Host = "smtp.gmail.com"; // GMail
					$phpmailer->Port = 465;
					$phpmailer->IsSMTP(); // use SMTP
					$phpmailer->SMTPAuth = true;
					$phpmailer->setFrom($phpmailer->Username,$from_name);
					$phpmailer->AddAddress($address_to); // recipients email
					$phpmailer->IsHTML(true);
					$phpmailer->Subject = $the_subject;	

					$body ='<html>
									<body>
										<table>
										<tr><td>Sr.</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>El '.$fecha_inicio_contrato.' , se suscribió con '.$nombre_proveedor.', el contrato N° '.$numero_documento.', para la prestación del servicio de  <br>
										'.$objeto.' el cual es gerenciado por el Sr. '.$nombre_gerente.'</tr>
										</table><br>
										Adjuntos:('.$destino.')	
									<br><br><br>
									
									<table border="1">
									<tr><td >ASPECTOS DEFINIDOS</td><td>PUNTOS</td></tr>';
									
										
										while($lt=traer_fila_db($query)){
											
										$body.='<tr> <td>'.$lt[0].'</td><td>'.$lt[1].'</td> </tr>';
											
											}
											
										$body.='
										</table>
									</body>
								</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
}


//CORREO ENVIO DE CRITERIOS APROBADOS AL PROVEEDOR
function mensaje_contrato_marco_envioproveedor_criterios_aprobados($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_proveedor from vista_t9_contrato_puntual where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_proveedor=$result[5];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_proveedor));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
	
	$asunto="Criterios Técnicos Aprobados para Evaluarlo";
	
	$destino1="fodorvonlh22@gmail.com";
	$destino2="jeison.rivera@enternova.net";
$select_tabla="select nombre_aspectos, puntaje_maximo FROM vista_t9_contrato_puntual where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;

$query=query_db($select_tabla);

include "PHPMailer-master/class.phpmailer.php";
include "PHPMailer-master/class.smtp.php";
include "PHPMailer-master/PHPMailerAutoload.php";

					$email_user = "Quinsilverr@gmail.com";
					$email_password = "23140756";
					$the_subject = "Criterios Técnicos Aprobados para Evaluarlo";
					$address_to = $destino1;
					$from_name = "SGPA Desempeño";
					$phpmailer = new PHPMailer();
					// ---------- datos de la cuenta de Gmail -------------------------------
					$phpmailer->Username = $email_user;
					$phpmailer->Password = $email_password; 
					//-----------------------------------------------------------------------
					// $phpmailer->SMTPDebug = 1;
					$phpmailer->SMTPSecure = 'ssl';
					$phpmailer->Host = "smtp.gmail.com"; // GMail
					$phpmailer->Port = 465;
					$phpmailer->IsSMTP(); // use SMTP
					$phpmailer->SMTPAuth = true;
					$phpmailer->setFrom($phpmailer->Username,$from_name);
					$phpmailer->AddAddress($address_to); // recipients email
					$phpmailer->IsHTML(true);
					$phpmailer->Subject = $the_subject;	

					$body ='<html>
									<body>
										<table>
										<tr><td>Sr.</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>El '.$fecha_inicio_contrato.' , se suscribió con '.$nombre_proveedor.', el contrato N° '.$numero_documento.', para la prestación del servicio de  <br>
										'.$objeto.' Por favor tenga en cuenta que su desempeño en la ejecución de este contrato será evaluado teniendo en cuenta los criterios 
										que se relacionan a continuación. </tr>
										<table><br>
										Adjuntos:('.$destino.')	
									<br><br><br>
									
									<table border="1">
									<tr><td >ASPECTOS DEFINIDOS</td><td>PUNTOS</td></tr>';
									
										
										while($lt=traer_fila_db($query)){
											
										$body.='<tr> <td>'.$lt[0].'</td><td>'.$lt[1].'</td> </tr>';
											
											}
											
										$body.='
										</table>
									</body>
								</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
}


//CORREO SOLICITUD EVALUACION TECNICA CONTRATO PUNTUAL
function mensaje_contrato_marco_enviosolicitud_evaluacion_tecnica($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_evaluador from vista_t9_contrato_puntual where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_evaluador=$result[5];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_evaluador));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
	$asunto="Pendiente Por Evaluacion Técnicos";
	
	$destino1="fodorvonlh22@gmail.com";
	$destino2="jeison.rivera@enternova.net";
	
include "PHPMailer-master/class.phpmailer.php";
include "PHPMailer-master/class.smtp.php";
include "PHPMailer-master/PHPMailerAutoload.php";

					$email_user = "Quinsilverr@gmail.com";
					$email_password = "23140756";
					$the_subject = "Pendiente Por Evaluacíon ";
					$address_to = $destino1;
					$from_name = "SGPA Desempeño";
					$phpmailer = new PHPMailer();
					// ---------- datos de la cuenta de Gmail -------------------------------
					$phpmailer->Username = $email_user;
					$phpmailer->Password = $email_password; 
					//-----------------------------------------------------------------------
					// $phpmailer->SMTPDebug = 1;
					$phpmailer->SMTPSecure = 'ssl';
					$phpmailer->Host = "smtp.gmail.com"; // GMail
					$phpmailer->Port = 465;
					$phpmailer->IsSMTP(); // use SMTP
					$phpmailer->SMTPAuth = true;
					$phpmailer->setFrom($phpmailer->Username,$from_name);
					$phpmailer->AddAddress($address_to); // recipients email
					$phpmailer->IsHTML(true);
					$phpmailer->Subject = $the_subject;	

					$body ='<html>
									<body>
										<table>
										<tr><td>Apreciado .</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>Durante el periodo comprendido entre el '.$fecha_inicio_contrato.' , usted solicitó y ejecutó las órdenes de trabajo que 
										se señalan en la tabla a continuación, con el proveedor '.$nombre_proveedor.', bajo el contrato N° '.$numero_documento.', 
										Por favor realice la evaluación de desempeño del proveedor teniendo en cuenta los criterios establecidos para evaluar 
										al mismo. Tenga en cuenta que estos criterios al igual que la evaluación aplicarán para la totalidad de las
										órdenes de trabajo relacionadas.</tr>
										<table><br>
										Adjuntos:('.$destino.')	
									</body>
								</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
}
		
?>