<?php 
		

//MENSAJE PARA SERVICIO MENOR
function mensaje_jefe_solicitante_servicio_menor_envio_aprobacion_criterios($usuario,$periodo,$solicitante,$proveedor,$id_agrega_aspectos){
								
					$consulta1="".$id_agrega_aspectos;

					$query=query_db($consulta1); 


					$email_user = "";
					$email_password = "";
					$the_subject = "";
					$address_to = "";
					$from_name = "o";
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

					$body = '<html>
									<body>
										<table>
										<tr><td>Sr.</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>Durante el periodo comprendido entre el '.$periodo.' , Sr. '.$solicitante.', solicitó y ejecutó los servicios menores <br>
										que se señalan en la tabla a continuación, con el proveedor '.$proveedor.'</tr>
										<table>
										<br>
										<table>
										<tr> <td>N° de Item</td><td>N° de Servicion Menor</td><td>Objeto</td><td>Valor</td><td>Fecha Fin</td>  </tr>';
											
										while($lt=traer_fila_db($query)){
											
										$body.='<tr> <td>'.$lt[0].'</td><td>'.$lt[1].'</td><td>'.$lt[2].'</td><td>'.$lt[3].'</td><td>'.$lt[4].'</td> </tr>';
											
											}
											
										$body.='
										
										<table>
									</body>
							</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
								
			
		}
		
		
function mensaje_proveedor_servicio_menor_aprobacion_criterios($usuario,$periodo,$solicitante,$proveedor,$id_agrega_aspectos){
								
					$consulta1="".$id_agrega_aspectos;

					$query=query_db($consulta1); 
					
					$consulta2="".$id_agrega_aspectos;
					$query2=query_db($consulta2); 


					$email_user = "";
					$email_password = "";
					$the_subject = "";
					$address_to = "";
					$from_name = "o";
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

					$body = '<html>
									<body>
										<table>
										<tr><td>Sr.</td><td>'.$proveedor.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>Durante el periodo comprendido entre el  '.$periodo.' , usted ejecutó para HOCOL S.A, los servicios menores 
										que se señalan en la tabla a continuación, los cuales fueron solicitados por el Sr. '.$solicitante.'</tr>
										</table>
										<br>
										<table>
										<tr> <td>N° de Item</td><td>N° de Servicio Menor</td><td>Objeto</td><td>Valor</td><td>Fecha Fin</td>  </tr>';
											
										while($lt=traer_fila_db($query)){
											
										$body.='<tr> <td>'.$lt[0].'</td><td>'.$lt[1].'</td><td>'.$lt[2].'</td><td>'.$lt[3].'</td><td>'.$lt[4].'</td> </tr>';
											
											}
											
										$body.='
												<br>
										<tr><td>A continuación se muestran los criterios con los cuales será evaluado su desempeño en los servicios antes mencionados.</td></tr>
										</table><br><br>
										
										<table>
										<tr> <td>Criterios</td><td>Puntos</td><td>Aspectos Evaluados</td><td>Servicio Menor</td><td>Descripci&oacute;n</td>  </tr>';
										
											while($lt1=traer_fila_db($query2)){
											
										$body.='<tr> <td>'.$lt1[0].'</td><td>'.$lt1[1].'</td><td>'.$lt1[2].'</td><td>'.$lt1[3].'</td><td>'.$lt1[4].'</td> </tr>';
											
											}

										$body.='
										
										</table>
									</body>
							</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
								
			
		}
		
		
function mensaje_jefe_solicitante_servicio_menor_solicitud_evaluacion($usuario,$periodo,$solicitante,$proveedor,$id_agrega_aspectos){
								
					$consulta1="".$id_agrega_aspectos;

					$query=query_db($consulta1); 
					
					$consulta2="".$id_agrega_aspectos;
					$query2=query_db($consulta2); 


					$email_user = "";
					$email_password = "";
					$the_subject = "";
					$address_to = "";
					$from_name = "o";
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

					$body = '<html>
									<body>
										<table>
										<tr><td>Apreciado.</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>Durante el periodo comprendido entre el   '.$periodo.' , usted solicitó y ejecutó los servicios menores que se señalan 
										en la tabla a continuación, con el proveedor  '.$proveedor.'Por favor realice la evaluación de desempeño del contratista con 
										base en los criterios establecidos. Tenga en cuenta que estos criterios al igual que la evaluación aplicarán para la totalidad 
										de los servicios menores relacionados.</tr>
										</table>
										<br>
										<table>
										<tr> <td>N° de Item</td><td>N° de Servicio Menor</td><td>Objeto</td><td>Valor</td><td>Fecha Fin</td>  </tr>';
											
										while($lt=traer_fila_db($query)){
											
										$body.='<tr> <td>'.$lt[0].'</td><td>'.$lt[1].'</td><td>'.$lt[2].'</td><td>'.$lt[3].'</td><td>'.$lt[4].'</td> </tr>';
											
											}
											
										$body.='
										
										</table>
									</body>
							</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
								
			
		}
		
		
		
				
function mensaje_jefe_solicitante_servicio_menor_aprobacion_evaluacion($usuario,$periodo,$solicitante,$proveedor,$id_agrega_aspectos){
								
					$consulta1="".$id_agrega_aspectos;

					$query=query_db($consulta1); 
					
					$consulta2="".$id_agrega_aspectos;
					$query2=query_db($consulta2); 


					$email_user = "";
					$email_password = "";
					$the_subject = "";
					$address_to = "";
					$from_name = "o";
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

					$body = '<html>
									<body>
										<table>
										<tr><td>Sr.</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>Durante el periodo comprendido entre el   '.$periodo.' , el Sr. '.$solicitante.',  solicitó y ejecutó los servicios menores 
										que se señalan en la tabla a continuación con el proveedor  '.$proveedor.'.</tr>
										</table>
										<br>
										<table>
										<tr> <td>N° de Item</td><td>N° de Servicio Menor</td><td>Objeto</td><td>Valor</td><td>Fecha Fin</td>  </tr>';
											
										while($lt=traer_fila_db($query)){
											
										$body.='<tr> <td>'.$lt[0].'</td><td>'.$lt[1].'</td><td>'.$lt[2].'</td><td>'.$lt[3].'</td><td>'.$lt[4].'</td> </tr>';
											
											}
											
										$body.='
												<br>
										<tr><td>A continuación se remite el resultado de la evaluación de desempeño del contratista en la ejecución de los mismos, 
										la cual requiere de su aprobación para quedar "en firme" y ser enviada al proveedor para su conocimiento. </td></tr>
										</table><br><br>
										
										<table>
										<tr> <td>Criterios</td><td>Puntos</td><td>Aspectos Evaluados</td><td>Servicio Menor</td><td>Clasificaci&oacute;n</td><td>Observaciones</td>  </tr>';
										
											while($lt1=traer_fila_db($query2)){
											
										$body.='<tr> <td>'.$lt1[0].'</td><td>'.$lt1[1].'</td><td>'.$lt1[2].'</td><td>'.$lt1[3].'</td><td>'.$lt1[4].'</td><td>'.$lt1[5].'</td> </tr>';
											
											}

										$body.='
										
										</table>
									</body>
							</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
								
			
		}

		
		
function mensaje_jefe_solicitante_servicio_menor_envio_proveedor_evaluacion($usuario,$periodo,$solicitante,$proveedor,$id_agrega_aspectos){
								
					$consulta1="".$id_agrega_aspectos;

					$query=query_db($consulta1); 
					
					$consulta2="".$id_agrega_aspectos;
					$query2=query_db($consulta2); 


					$email_user = "";
					$email_password = "";
					$the_subject = "";
					$address_to = "";
					$from_name = "o";
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

					$body = '<html>
									<body>
										<table>
										<tr><td>Sr.</td><td>'.$proveedor.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>Durante el periodo comprendido entre el   '.$periodo.' , usted ejecutó para HOCOL S.A, los servicios menores
										que se señalan en la tabla a continuación, los cuales fueron solicitados por el Sr. '.$solicitante.'.</tr>
										</table>
										<br>
										<table>
										<tr> <td>N° de Item</td><td>N° de Servicio Menor</td><td>Objeto</td><td>Valor</td><td>Fecha Fin</td>  </tr>';
											
										while($lt=traer_fila_db($query)){
											
										$body.='<tr> <td>'.$lt[0].'</td><td>'.$lt[1].'</td><td>'.$lt[2].'</td><td>'.$lt[3].'</td><td>'.$lt[4].'</td> </tr>';
											
											}
											
										$body.='
												<br>
										<tr><td>A continuación se remite el resultado de la evaluación de su desempeño en la ejecución de los mismos. </td></tr>
										</table><br><br>
										
										<table>
										<tr> <td>Criterios</td><td>Puntos</td><td>Aspectos Evaluados</td><td>Servicio Menor</td><td>Clasificaci&oacute;n</td><td>Observaciones</td>  </tr>';
										
											while($lt1=traer_fila_db($query2)){
											
										$body.='<tr> <td>'.$lt1[0].'</td><td>'.$lt1[1].'</td><td>'.$lt1[2].'</td><td>'.$lt1[3].'</td><td>'.$lt1[4].'</td><td>'.$lt1[5].'</td> </tr>';
											
											}

										$body.='
										
										</table>
									</body>
							</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
								
			
		}

		// MENSAJES PARA CONTRATOS MARCO
		
		
		
		function mensaje_jefe_solicitante_contrato_marco_establecer_criterios($usuario,$periodo,$solicitante,$proveedor,$id_agrega_aspectos){
								
					$consulta1="".$id_agrega_aspectos;

					$query=query_db($consulta1); 


					$email_user = "";
					$email_password = "";
					$the_subject = "";
					$address_to = "";
					$from_name = "o";
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

					$body = '<html>
									<body>
										<table>
										<tr><td>Apreciado.</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>El '.$fecha_inicio.' , se suscribió con '.$proveedor_nombre.', el contrato N° '.$numero_contrato.', para la prestación del servicio de  <br>
										'.$servicio.' Por favor establezca los criterios con los cuales se evaluará el desempeño del contratista en los servicios que se 
										ejecutarán en el marco del contrato.</tr>
										<table>
										
									</body>
							</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
								
			
		}
		
		
function mensaje_jefe_solicitante_contrato_marco_envio_aprobacion_criterios($usuario,$periodo,$solicitante,$proveedor,$id_agrega_aspectos){
								
					$consulta1="".$id_agrega_aspectos;

					$query=query_db($consulta1); 


					$email_user = "";
					$email_password = "";
					$the_subject = "";
					$address_to = "";
					$from_name = "o";
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

					$body = '<html>
									<body>
										<table>
										<tr><td>Sr.</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>El '.$fecha_inicio.' , se suscribió con '.$proveedor_nombre.', el contrato N° '.$numero_contrato.', para la prestación del servicio de  <br>
										'.$servicio.' el cual es gerenciado por el Sr. '.$gerente_contrato.'</tr>
										</table>
										<table>
										<tr> <td>N° de Item</td><td>N° de Servicio Menor</td><td>Objeto</td><td>Valor</td><td>Fecha Fin</td>  </tr>';
											
										while($lt=traer_fila_db($query)){
											
										$body.='<tr> <td>'.$lt[0].'</td><td>'.$lt[1].'</td><td>'.$lt[2].'</td><td>'.$lt[3].'</td><td>'.$lt[4].'</td> </tr>';
											
											}
											
										$body.='
												<br>
										<tr><td>Para realizar la evaluación de desempeño del proveedor en el contrato ya mencionado, el Gerente del 
										contrato estableció los criterios a continuación, los cuales requieren su aprobación para realizar la posterior evaluación.</td></tr>
										</table><br><br>
										
										<table>
										<tr> <td>Criterios</td><td>Puntos</td><td>Aspectos Evaluados</td><td>'.$tipo_servicio.'</td><td>Clasificaci&oacute;n</td><td>Observaciones</td>  </tr>';
										
											while($lt1=traer_fila_db($query2)){
											
										$body.='<tr> <td>'.$lt1[0].'</td><td>'.$lt1[1].'</td><td>'.$lt1[2].'</td><td>'.$lt1[3].'</td><td>'.$lt1[4].'</td><td>'.$lt1[5].'</td> </tr>';
											
											}

										$body.='
										
									</body>
							</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
								
			
		}
		
		
function mensaje_jefe_solicitante_contrato_marco_establecer_envio_proveedor($usuario,$periodo,$solicitante,$proveedor,$id_agrega_aspectos){
								
					$consulta1="".$id_agrega_aspectos;

					$query=query_db($consulta1); 


					$email_user = "";
					$email_password = "";
					$the_subject = "";
					$address_to = "";
					$from_name = "o";
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

					$body = '<html>
									<body>
										<table>
										<tr><td>Sr.</td><td>'.$proveedor.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>El '.$fecha_inicio.' , se suscribió con '.$proveedor_nombre.', el contrato N° '.$numero_contrato.', para la prestación del servicio de  <br>
										'.$servicio.' Por favor tenga en cuenta que su desempeño en la ejecución de este contrato será evaluado teniendo en cuenta los criterios 
										que se relacionan a continuación. </tr>
										<table>
										
									</body>
							</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
								
			
		}
		
		
		
function mensaje_jefe_solicitante_contrato_marco_solicitud_evaluacion($usuario,$periodo,$solicitante,$proveedor,$id_agrega_aspectos){
								
					$consulta1="".$id_agrega_aspectos;

					$query=query_db($consulta1); 


					$email_user = "";
					$email_password = "";
					$the_subject = "";
					$address_to = "";
					$from_name = "o";
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

					$body = '<html>
									<body>
										<table>
										<tr><td>Apreciado .</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>Durante el periodo comprendido entre el '.$periodo.' , usted solicitó y ejecutó las órdenes de trabajo que 
										se señalan en la tabla a continuación, con el proveedor '.$proveedor.', bajo el contrato N° '.$numero_contrato.', 
										Por favor realice la evaluación de desempeño del proveedor teniendo en cuenta los criterios establecidos para evaluar 
										al mismo. Tenga en cuenta que estos criterios al igual que la evaluación aplicarán para la totalidad de las
										órdenes de trabajo relacionadas.</tr>
										<table>
										<br>
										<table>
										<tr> <td>N° de Item</td><td>N° de Orden de Trabajo</td><td>Objeto</td><td>Valor</td><td>Fecha Fin</td>  </tr>';
											
										while($lt=traer_fila_db($query)){
											
										$body.='<tr> <td>'.$lt[0].'</td><td>'.$lt[1].'</td><td>'.$lt[2].'</td><td>'.$lt[3].'</td><td>'.$lt[4].'</td> </tr>';
											
											}
											
										$body.='
										
										<table>
									</body>
							</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
								
			
		}
		

function mensaje_jefe_solicitante_contrato_marco_aprobacion_evaluacion_proveedor($usuario,$periodo,$solicitante,$proveedor,$id_agrega_aspectos){
								
					$consulta1="".$id_agrega_aspectos;

					$query=query_db($consulta1); 


					$email_user = "";
					$email_password = "";
					$the_subject = "";
					$address_to = "";
					$from_name = "o";
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

					$body = '<html>
									<body>
										<table>
										<tr><td>Sr.</td><td>'.$proveedor.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>El '.$fecha_inicio.' , se suscribió con '.$proveedor_nombre.', el contrato N° '.$numero_contrato.', para la prestación del servicio de  <br>
										'.$servicio.' A continuación se encuentra el resultado de su desempeño anual en la ejecución del servicio. </tr>
										
										</table>
										
									</body>
							</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
								
			
		}
		
		
		//MENSAJE PARA CONTRATO PUNTUAL
		
		
		
		function mensaje_jefe_solicitante_contrato_puntual_establecer_criterios($usuario,$periodo,$solicitante,$proveedor,$id_agrega_aspectos){
								
					$consulta1="".$id_agrega_aspectos;

					$query=query_db($consulta1); 


					$email_user = "";
					$email_password = "";
					$the_subject = "";
					$address_to = "";
					$from_name = "o";
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

					$body = '<html>
									<body>
										<table>
										<tr><td>Apreciado.</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>El '.$fecha_inicio.' , se suscribió con '.$proveedor_nombre.', el contrato N° '.$numero_contrato.', para la prestación del servicio de  <br>
										'.$servicio.' Por favor establezca los criterios con los cuales se evaluará el desempeño del contratista en los servicios que se ejecutarán 
										en el marco del contrato.</tr>
										<table>
										
									</body>
							</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
								
			
		}
		
		
		function mensaje_jefe_solicitante_contrato_puntual_envio_aprobacion_criterios($usuario,$periodo,$solicitante,$proveedor,$id_agrega_aspectos){
								
					$consulta1="".$id_agrega_aspectos;

					$query=query_db($consulta1); 


					$email_user = "";
					$email_password = "";
					$the_subject = "";
					$address_to = "";
					$from_name = "o";
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

					$body = '<html>
									<body>
										<table>
										<tr><td>Sr.</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>El '.$fecha_inicio.' , se suscribió con '.$proveedor_nombre.', el contrato N° '.$numero_contrato.', para la prestación del servicio de  <br>
										'.$servicio.' el cual es gerenciado por el Sr. '.$gerente_contrato.'</tr>
										</table>
										
										<table>
										<tr> <td>Criterios</td><td>Puntos</td><td>Aspectos Evaluados</td><td>'.$tipo_servicio.'</td><td>Descripci&oacute;n</td> </tr>';
										
											while($lt1=traer_fila_db($query2)){
											
										$body.='<tr> <td>'.$lt1[0].'</td><td>'.$lt1[1].'</td><td>'.$lt1[2].'</td><td>'.$lt1[3].'</td><td>'.$lt1[4].'</td> </tr>';
											
											}

										$body.='
										
									</body>
							</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
								
			
		}
		
		
		function mensaje_jefe_solicitante_contrato_puntual_establecer_envio_proveedor($usuario,$periodo,$solicitante,$proveedor,$id_agrega_aspectos){
								
					$consulta1="".$id_agrega_aspectos;

					$query=query_db($consulta1); 


					$email_user = "";
					$email_password = "";
					$the_subject = "";
					$address_to = "";
					$from_name = "o";
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

					$body = '<html>
									<body>
										<table>
										<tr><td>Sr.</td><td>'.$proveedor.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>El '.$fecha_inicio.' , se suscribió con '.$proveedor_nombre.', el contrato N° '.$numero_contrato.', para la prestación del servicio de  <br>
										'.$servicio.' Por favor tenga en cuenta que su desempeño en la ejecución de este contrato será evaluado teniendo en cuenta los criterios 
										que se relacionan a continuación. </tr>
										<table>
										
									</body>
							</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
								
			
		}
		
		
				
function mensaje_jefe_solicitante_contrato_puntual_solicitud_evaluacion($usuario,$periodo,$solicitante,$proveedor,$id_agrega_aspectos){
								
					$consulta1="".$id_agrega_aspectos;

					$query=query_db($consulta1); 


					$email_user = "";
					$email_password = "";
					$the_subject = "";
					$address_to = "";
					$from_name = "o";
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

					$body = '<html>
									<body>
										<table>
										<tr><td>Apreciado .</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>Durante el periodo comprendido entre el '.$periodo.' , se suscribió con  '.$nombre_proveedor.', bajo el contrato N° '.$numero_contrato.', 
										para la prestación del servicio de '.$servicio.', Por favor realice la evaluación técnica de desempeño al proveedor teniendo en cuenta 
										los criterios establecidos para evaluar al mismo. </tr>
										</table>
										
									</body>
							</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
								
			
		}
		
		
		
//MENSAJE PARA HSE
		
function mensaje_jefe_solicitante_solicitud_evaluacion_hse($usuario,$periodo,$solicitante,$proveedor,$id_agrega_aspectos){
								
					$consulta1="".$id_agrega_aspectos;

					$query=query_db($consulta1); 


					$email_user = "";
					$email_password = "";
					$the_subject = "";
					$address_to = "";
					$from_name = "o";
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

					$body = '<html>
									<body>
										<table>
										<tr><td>Sr.</td><td>'.$coordinador.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>El '.$fecha_inicio.' , se suscribió con '.$proveedor_nombre.', el contrato N° '.$numero_contrato.', para la prestación del servicio de  <br>
										'.$servicio.' Por favor realice la evaluación de desempeño de HSSE al proveedor teniendo en cuenta los criterios establecidos para evaluar al mismo. 
										Tenga en cuenta que estos criterios al igual que la evaluación aplicarán para la totalidad de contratos y órdenes de trabajo contratados con el proveedor. </tr>
										<table>
										
									</body>
							</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
								
			
		}
		
		
//MENSAJE PARA ADMINISTRATIVO
function mensaje_jefe_solicitante_solicitud_evaluacion_adm($usuario,$periodo,$solicitante,$proveedor,$id_agrega_aspectos){
								
					$consulta1="".$id_agrega_aspectos;

					$query=query_db($consulta1); 


					$email_user = "";
					$email_password = "";
					$the_subject = "";
					$address_to = "";
					$from_name = "o";
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

					$body = '<html>
									<body>
										<table>
										<tr><td>Sr.</td><td>'.$coordinador.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>El '.$fecha_inicio.' , se suscribió con '.$proveedor_nombre.', el contrato N° '.$numero_contrato.', para la prestación del servicio de  <br>
										'.$servicio.' Por favor realice la evaluación de desempeño de Aseguramiento Administrativo al proveedor teniendo en cuenta los criterios 
										establecidos para evaluar al mismo. Tenga en cuenta que estos criterios al igual que la evaluación aplicarán para la totalidad de las órdenes 
										de trabajo, contratos y servicios menores contratados con el proveedor. </tr>
										<table>
										
									</body>
							</html>';
					$phpmailer->Body = $body;

					$phpmailer->Send();
								
			
		}

?>






<?php



	
?>