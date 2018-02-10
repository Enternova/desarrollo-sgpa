<?php


//CORREO SOLICITUD DEFINIR CRITERIOS SERVICIO MENOR
function definir_aspecto_menor($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct periodo_evaluacion,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_crea_aspectos from vista_t9_servicio_menor where id_evaluacion=".$id_evaluacion));
			 
			$periodo_evaluacion=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_crea_aspectos=$result[5];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_crea_aspectos));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
			
	$usuario4=$result9[0];
	$destino4=$result9[1];
	
	
	$asunto="PENDIENTE DEFINIR CRITERIOS SERVICIO MENOR";
	
	$destino1='josef.fovor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";

					$mensaje_envio ='<html>
									<body>
										<table >
										<tr><td>Apreciado.</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>Durante el periodo comprendido entre el '.$periodo_evaluacion.', usted solicit&oacute; y ejecut&oacute; los servicios menores,
										con el proveedor. '.$nombre_proveedor.', Por favor establezca los criterios para 
										evaluar al contratista. Tenga en cuenta que estos criterios al igual que la evaluaci&oacute;n aplicar&aacute;n para la totalidad de los 
										servicios menores relacionados. </tr>
										</table ><br>
										Adjuntos:(Solicitante:'.$destino.',Gestor:'.$destino4.')	
									</body>
								</html>';
sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}



//CORREO SOLICITUD EVALUACION TECNICA SERVICIO MENOR
function solicitud_evaluacion_menor($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct periodo_evaluacion,nombre_proveedor,numero_documento,convert(varchar(max), objeto),id_crea_aspectos,id_jefe,id_gerente,id_proveedor,id_evaluador from vista_t9_servicio_menor where id_evaluacion=".$id_evaluacion));
			 
			$periodo_evaluacion=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$id_crea_aspectos = $result[4];
			$id_jefe=$result[5];
			$id_gerente=$result[6];
			$id_proveedor=$result[7];
			$id_evaluador=$result[8];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_evaluador));
			
	$usuario=$result1[0];
	$destino=$result1[1];

$result6=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_crea_aspectos));
			
	$solicitante=$result6[0];
	$destino0=$result6[1];
	
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
			
	$usuario4=$result9[0];
	$destino4=$result9[1];

	$asunto="SOLICITUD DE EVALUACION TECNICA SERVICIO MENOR";
	
	$destino1='josef.fovor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";
	
	
$select_tabla1="select numero_documento, convert(varchar(max), objeto) as objeto, '$'+convert(varchar(20), valor_cop)+'COP $'+convert(varchar(20), valor_usd)+'USD' AS valor, fecha_inicio_ot, fecha_fin_ot, id_gerente, id_proveedor   from vista_t9_servicio_menor_correo WHERE id_gerente='".$id_gerente."' AND id_proveedor='".$id_proveedor."' AND CONVERT(DATE, fecha_inicio_ot) BETWEEN '2017-10-01' AND '2018-04-01'";

$query1=query_db($select_tabla1);	

					$mensaje_envio ='<html>
									<body>
										<table >
										<tr><td>Sr(a).</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table >
										<tr>Durante el periodo comprendido entre el '.$periodo_evaluacion.' , usted solicit&oacute; y ejecut&oacute; los servicios menores 
										que se se&ntilde;alan en la tabla a continuaci&oacute;n, con el proveedor. '.$nombre_proveedor.', Por favor realice la evaluaci&oacute;n 
										de desempe&ntilde;o del contratista con base en los criterios establecidos. Tenga en cuenta que estos criterios al igual que 
										la evaluaci&oacute;n aplicar&aacute;n para la totalidad de los servicios menores relacionados. </tr>
										</table>
										<br>
										<table border="1">
										<tr bgcolor="#1F497D"><td><font color="ffffff">N de Servicion Menor</td><td><font color="ffffff">Objeto</td><td><font color="ffffff">Valor</td><td><font color="ffffff">Fecha Fin</td>  </tr>';
											
										while($lt1=traer_fila_db($query1)){
											
										$mensaje_envio.='<tr> <td>'.$lt1[0].'</td><td>'.$lt1[1].'</td><td>'.$lt1[2].'</td><td>'.$lt1[4].'</td> </tr>';
											
											}
											
										$mensaje_envio.='
										
										</table>
											<br>Adjuntos:(Solicitante'.$destino.',Gestor:'.$destino4.')	
								
									</body>
								</html>';
 sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}	



//CORREO SOLICITUD DEFINIR CRITERIOS CONTRATO PUNTUAL
function define_aspecto_puntual($id_evaluacion) {
	
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
	
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
			
	$usuario4=$result9[0];
	$destino4=$result9[1];
	
	$asunto="PENDIENTE DEFINIR CRITERIOS CONTRATO PUNTUAL";
	
	$destino1='josef.fovor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";

					$mensaje_envio ='<html>
									<body>
										<table >
										<tr><td>Apreciado.</td><td>'.$usuario.'</td></tr>
										</table><br>
										<table >
										<tr>El '.$fecha_inicio_contrato.' , se suscribi&oacute; con '.$nombre_proveedor.', el contrato '.$numero_documento.' para la prestaci&oacute;n del servicio ('.$objeto.'),
										el cual es gerenciado por el Sr(a). '.$nombre_gerente.'.Por favor establezca los criterios con los cuales se evaluar&aacute; el desempe&ntilde;o del contratista 
										en los servicios que se ejecutar&aacute;n en el marco del contrato.</tr>
										</table><br>
										Adjuntos:(Gerente:'.$destino.',Gestor:'.$destino4.')	
									</body>
								</html>';
sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}


//CORREO SOLICITUD EVALUAR PROVEEDOR
function solicitud_evaluacion_puntual($id_evaluacion){
	
	
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_crea_aspectos,id_evaluador from vista_t9_contrato_puntual where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_crea_aspectos=$result[5];
			$id_evaluador=$result[6];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_evaluador));
			
	$usuario=$result1[0];
	$destino=$result1[1];

	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
			
	$usuario4=$result9[0];
	$destino4=$result9[1];

	$asunto="SOLICITUD DE EVALUACION TECNICA CONTRATO PUNTUAL";
	
	$destino1='josef.fovor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";

					$mensaje_envio ='<html>
									<body>
										<table>
										<tr><td>Apreciado.</td><td>'.$usuario.'</td></tr>
										</table><br>
										<table >
										<tr>El '.$fecha_inicio_contrato.' , se suscribi&oacute; con '.$nombre_proveedor.', el contrato N '.$numero_documento.' para la prestaci&oacute;n del servicio ('.$objeto.'),
										el cual es gerenciado por el Sr(a). '.$nombre_gerente.'.Por favor realice la evaluaci&oacute;n t&eacute;cnica de desempe&ntilde;o al proveedor teniendo en cuenta los criterios
										establecidos para evaluar al mismo. </tr>
										</table><br>
										Adjuntos:(Gerente:'.$destino.',Gestor:'.$destino4.')	
									</body>
								</html>';
sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}



//CORREO SOLICITUD EVALUACION HSSE
function evaluacion_puntual_hsse($id_evaluacion) {
	
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
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
	$usuario4=$result9[0];
	$destino4=$result9[1];

	$asunto="PENDIENTE EVALUACION HSSE PROVEEDOR CONTRATO PUNTUAL";
	
	$destino1='josef.fovor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";
	
					$mensaje_envio ='<html>
									<body>
										<table >
										<tr><td>Sr(a).</td><td>'.$usuario.'</td></tr>
										</table><br>
										<table >
										<tr>El '.$fecha_inicio_contrato.' , se suscribi&oacute; con '.$nombre_proveedor.', el contrato '.$numero_documento.' para la prestaci&oacute;n del servicio ('.$objeto.'),
										el cual es gerenciado por el Sr(a). '.$nombre_gerente.'.Por favor realice la evaluaci&oacute;n de desempe&ntilde;o de HSSE al proveedor teniendo en
										cuenta los criterios establecidos para evaluar al mismo. Tenga en cuenta que estos criterios al igual que la evaluaci&oacute;n aplicar&aacute;n
										para la totalidad de las &oacute;rdenes de trabajo, contratos con dicho proveedor.</tr>
										</table><br>
										Adjuntos:(Coordinador:'.$destino.',Gestor:'.$destino4.')
									</body>
								</html>';
	 sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}



//CORREO SOLICITUD EVALUACION ADM
function evaluacion_puntual_adm($id_evaluacion) {
	
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
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
	$usuario4=$result9[0];
	$destino4=$result9[1];
	
	$asunto="PENDIENTE EVALUACION ADMINISTRATIVA PROVEEDOR CONTRATO PUNTUAL";
	
	$destino1='josef.fovor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";
	
					$mensaje_envio ='<html>
									<body>
										<table >
										<tr><td>Sr(a).</td><td>'.$usuario.'</td></tr>
										</table><br>
										<table >
										<tr>El '.$fecha_inicio_contrato.' , se suscribi&oacute; con '.$nombre_proveedor.', el contrato '.$numero_documento.' para la prestaci&oacute;n del servicio ('.$objeto.'),
										el cual es gerenciado por el Sr(a). '.$nombre_gerente.'.Por favor realice la evaluaci&oacute;n de desempe&ntilde;o de Aseguramiento Administrativo al 
										proveedor teniendo en cuenta los criterios establecidos para evaluar al mismo. Tenga en cuenta que estos criterios al igual que la 
										evaluaci&oacute;n aplicar&aacute;n para la totalidad de las &oacute;rdenes de trabajo, contratos y servicios menores contratados con el proveedor.</tr>
										</table><br>
										Adjuntos:(Coordinador:'.$destino.',Gestor:'.$destino4.')	
									</body>
								</html>';
	 sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}


//CORREO SOLICITUD DEFINIR CRITERIOS CONTRATO MARCO
function definir_aspecto_marco($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_crea_aspectos from vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_crea_aspectos=$result[5];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_crea_aspectos));
			
	$usuario=$result1[0];
	$destino=$result1[1];

$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
	$usuario4=$result9[0];
	$destino4=$result9[1];
	
	$asunto="PENDIENTE DEFINIR CRITERIOS CONTRATO MARCO";
	
	$destino1='josef.fovor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";

					$mensaje_envio ='<html>
									<body>
										<table>
										<tr><td>Apreciado.</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>El '.$fecha_inicio_contrato.' , se suscribi&oacute; con '.$nombre_proveedor.', el contrato '.$numero_documento.', para la prestaci&oacute;n del servicio de  <br>
										'.$objeto.' Por favor establezca los criterios con los cuales se evaluar&aacute; el desempe&ntilde;o del contratista en los servicios que se 
										ejecutar&aacute;n en el marco del contrato.</tr>
										<table><br>
										Adjuntos:(Gerente:'.$destino.',Gestor:'.$destino4.')	
									</body>
								</html>';
	 sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}


//CORREO SOLICITUD EVALUACION PROVEEDOR
function solicitud_evaluacion_marco($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_evaluador from vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_evaluador=$result[5];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_evaluador));
			
	$usuario=$result1[0];
	$destino=$result1[1];

$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
	$usuario4=$result9[0];
	$destino4=$result9[1];
	
	$asunto="PENDIENTE APROBACION DE EVALUACION TECNICA CONTRATO MARCO";
	
	$destino1='josef.fovor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";

					$mensaje_envio ='<html>
									<body>
										<table>
										<tr><td>Apreciado .</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>Durante el periodo comprendido entre el '.$fecha_inicio_contrato.' , usted solicit&oacute; y ejecut&oacute; las &oacute;rdenes de trabajo que 
										se se&ntilde;alan en la tabla a continuaci&oacute;n, con el proveedor '.$nombre_proveedor.', bajo el contrato N '.$numero_documento.', 
										Por favor realice la evaluaci&oacute;n de desempe&ntilde;o del proveedor teniendo en cuenta los criterios establecidos para evaluar 
										al mismo. Tenga en cuenta que estos criterios al igual que la evaluaci&oacute;n aplicar&aacute;n para la totalidad de las
										&oacute;rdenes de trabajo relacionadas.</tr>
										<table><br>
										Adjuntos:(Solicitante:'.$destino.',Gestor:'.$destino4.')	
									</body>
								</html>';
 sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}



//CORREO SOLICITUD EVALUACION HSSE
function evaluacion_marco_hsse($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_evaluador from vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_evaluador=$result[5];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_evaluador));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
	$usuario4=$result9[0];
	$destino4=$result9[1];
	
	$asunto="PENDIENTE EVALUACION HSSE PROVEEDOR CONTRATO MARCO";
	
	$destino1='josef.fovor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";
	
					$mensaje_envio ='<html>
									<body>
										<table>
										<tr><td>Sr(a).</td><td>'.$usuario.'</td></tr>
										</table><br>
										<table>
										<tr>El '.$fecha_inicio_contrato.' , se suscribi&oacute; con '.$nombre_proveedor.', el contrato '.$numero_documento.' para la prestaci&oacute;n del servicio ('.$objeto.'),
										el cual es gerenciado por el Sr(a). '.$nombre_gerente.'.Por favor realice la evaluaci&oacute;n de desempe&ntilde;o de HSSE al proveedor teniendo en
										cuenta los criterios establecidos para evaluar al mismo. Tenga en cuenta que estos criterios al igual que la evaluaci&oacute;n aplicar&aacute;n
										para la totalidad de las &oacute;rdenes de trabajo, contratos con dicho proveedor.</tr>
										</table><br>
										Adjuntos:('.$destino.')	
									</body>
								</html>';
sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}



//CORREO SOLICITUD EVALUACION ADM
function evaluacion_marco_adm($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_evaluador from vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_evaluador=$result[5];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_evaluador));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
	$usuario4=$result9[0];
	$destino4=$result9[1];
	
	$asunto="PENDIENTE EVALUACION ADMINISTRATIVA PROVEEDOR CONTRATO MARCO";
	
	$destino1='josef.fovor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";

					$mensaje_envio ='<html>
									<body>
										<table>
										<tr><td>Sr(a).</td><td>'.$usuario.'</td></tr>
										</table><br>
										<table>
										<tr>El '.$fecha_inicio_contrato.' , se suscribi&oacute; con '.$nombre_proveedor.', el contrato '.$numero_documento.' para la prestaci&oacute;n del servicio ('.$objeto.'),
										el cual es gerenciado por el Sr(a). '.$nombre_gerente.'.Por favor realice la evaluaci&oacute;n de desempe&ntilde;o de Aseguramiento Administrativo al 
										proveedor teniendo en cuenta los criterios establecidos para evaluar al mismo. Tenga en cuenta que estos criterios al igual que la 
										evaluaci&oacute;n aplicar&aacute;n para la totalidad de las &oacute;rdenes de trabajo, contratos contratados con el proveedor.</tr>
										</table><br>
										Adjuntos:('.$destino.')	
									</body>
								</html>';
 sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}



?>