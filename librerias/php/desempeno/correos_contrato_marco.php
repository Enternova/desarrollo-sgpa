<?php
include('../../PHPMailer_v2.0.0/class.phpmailer.php'); 


//CORREO ENVIO DE CRITERIOS PARA APROBACION
function envia_aprobacion_aspecto_marco($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_jefe from vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_jefe=$result[5];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_jefe));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
	$usuario4=$result9[0];
	$destino4=$result9[1];
	
	$asunto="PENDIENTE APROBACION DE CRITERIOS CONTRATO MARCO";
	
	$destino1='josef.fovor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";
	
$select_tabla="select nombre_aspectos, puntaje_maximo FROM vista_t9_contrato_marco where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;

$query=query_db($select_tabla);

					$mensaje_envio ='<html>
									<body>
										<table>
										<tr><td>Sr(a).</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>El '.$fecha_inicio_contrato.' , se suscribi&oacute; con '.$nombre_proveedor.', el contrato '.$numero_documento.', para la prestaci&oacute;n del servicio de  <br>
										'.$objeto.' el cual es gerenciado por el Sr(a). '.$nombre_gerente.'</tr>
										</table>	
									<br><br><br>
									
									<table border="1">
									<tr bgcolor="#1F497D"><td ><font color="ffffff">ASPECTOS DEFINIDOS</td><td><font color="ffffff">PUNTOS</td></tr>';
									
										$total=0;
										while($lt=traer_fila_db($query)){
											$total=$total+$lt[1];
										$mensaje_envio.='<tr> <td>'.$lt[0].'</td><td>'.$lt[1].'</td> </tr>';
											
											}
											
										$mensaje_envio.='<tr bgcolor="#1F497D"> <td><font color="ffffff">TOTAL</td><td><font color="ffffff">'.$total.'</td> </tr>
										</table>
										<br>
										Adjuntos:(Jefe:'.$destino.',Gestor:'.$destino4.')
									</body>
								</html>';
 sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}



//CORREO ENVIO DE CRITERIOS APROBADOS AL PROVEEDOR
function envio_aprobacion_aspecto_proveedor_marco($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_proveedor from vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_proveedor=$result[5];
			
$result1=traer_fila_row(query_db("select t1.razon_social, t2.email from t1_proveedor as t1, t1_us_usuarios as t2 where t1.t1_proveedor_id=t2.pv_id and t1.t1_proveedor_id=".$id_proveedor." and t2.estado=1"));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
	$usuario4=$result9[0];
	$destino4=$result9[1];
	
	$asunto="CRITERIOS APROBADOS PARA EVALUACION CONTRATO MARCO";
	
	$destino1='josef.fovor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";
	
$select_tabla="select nombre_aspectos, puntaje_maximo FROM vista_t9_contrato_marco where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;

$query=query_db($select_tabla);

					$mensaje_envio ='<html>
									<body>
										<table>
										<tr><td>Sr(a).</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>El '.$fecha_inicio_contrato.' , se suscribi&oacute; con '.$nombre_proveedor.', el contrato '.$numero_documento.', para la prestaci&oacute;n del servicio de  <br>
										'.$objeto.' Por favor tenga en cuenta que su desempe&ntilde;o en la ejecuci&oacute;n de este contrato ser&aacute; evaluado teniendo en cuenta los criterios 
										que se relacionan a continuaci&oacute;n. </tr>
										<table>
									<br><br><br>
									
									<table border="1">
									<tr bgcolor="#1F497D"><td ><font color="ffffff">ASPECTOS DEFINIDOS</td><td><font color="ffffff">PUNTOS</td></tr>';
									
										
										$total=0;
										while($lt=traer_fila_db($query)){
											$total=$total+$lt[1];
										$mensaje_envio.='<tr> <td>'.$lt[0].'</td><td>'.$lt[1].'</td> </tr>';
											
											}
											
										$mensaje_envio.='<tr bgcolor="#1F497D"> <td><font color="ffffff">TOTAL</td><td><font color="ffffff">'.$total.'</td> </tr>
										</table>
										<br>
										Adjuntos:(Proveedor:'.$destino.',Gestor:'.$destino4.')	
									</body>
								</html>';
sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}



//CORREO ENVIO DE EVALUACION
function envia_aprobacion_evaluacion_marco($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_crea_aspectos,id_evaluador,id_jefe from vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_crea_aspectos=$result[5];
			$id_evaluador=$result[6];
			$id_jefe=$result[7];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_jefe));
			
	$usuario=$result1[0];
	$destino=$result1[1];

	
$result3=traer_fila_row(query_db("select t1.observacion_general,t2.nombre_clasificacion from t9_agregar_evaluacion t1 inner join t9_clasificacion t2 on t1.id_clasificacion=t2.id_clasificacion where t1.id_agregar_criterio=".$id_evaluacion));
			
	$observacion_general=$result3[0];
	$nombre_clasificacion=$result3[1];

$result4=traer_fila_row(query_db("select sum(puntaje_obtenido) as total FROM t9_agregar_aspecto where id_estado=1 and id_agregar_criterio=".$id_evaluacion));
			
	$total=$result4[0];
	
	
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
										<tr><td>Apreciado.</td><td>'.$usuario.'</td></tr>
										</table><br>
										<table>
										<tr>Se ha realizado evaluaci&oacute;n del contrato N '.$numero_documento.' , suscrito con el proveedor '.$nombre_proveedor.',para el servicio de ('.$objeto.'),
										el cual es gerenciado por el Sr(a). '.$nombre_gerente.'.Se requiere su aprobaci&oacute;n de la evaluaci&oacute;n para que la misma sea enviada para informaci&oacute;n del proveedor. </tr>
										</table>
										<br>
										<table border="1">
										<tr bgcolor="#1F497D">
										<td><font color="ffffff">OBSERVACION</td><td><font color="ffffff">CLASIFICACION</td><td><font color="ffffff">PUNTAJE</td>
										</tr>
										<tr>
										<td>'.$observacion_general.'</td><td>'.$nombre_clasificacion.'</td><td>'.$total.'</td>
										</tr>
										</table>
										<br>
										Adjuntos:(Jefe:'.$destino.',Gestor:'.$destino4.')	
									</body>
								</html>';
sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}



//CORREO SOLICITUD ENVIO APROBACION PROVEEDOR
function envia_aprobacion_proveedor_evaluacion_marco($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_crea_aspectos,id_evaluador,id_jefe,id_proveedor from vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_crea_aspectos=$result[5];
			$id_evaluador=$result[6];
			$id_jefe=$result[7];
			$id_proveedor=$result[8];
			
$result1=traer_fila_row(query_db("select t1.razon_social, t2.email from t1_proveedor as t1, t1_us_usuarios as t2 where t1.t1_proveedor_id=t2.pv_id and t1.t1_proveedor_id=".$id_proveedor." and t2.estado=1"));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
	
$result3=traer_fila_row(query_db("select t1.observacion_general,t2.nombre_clasificacion from t9_agregar_evaluacion t1 inner join t9_clasificacion t2 on t1.id_clasificacion=t2.id_clasificacion where t1.id_agregar_criterio=".$id_evaluacion));
			
	$observacion_general=$result3[0];
	$nombre_clasificacion=$result3[1];

$result4=traer_fila_row(query_db("select sum(puntaje_obtenido) as total FROM t9_agregar_aspecto where id_estado=1 and id_agregar_criterio=".$id_evaluacion));
			
	$total=$result4[0];
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
	$usuario4=$result9[0];
	$destino4=$result9[1];
	
	$asunto="RESULTADOS DE EVALUACION TECNICA CONTRATO MARCO";
	
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
										<table>
										<tr>Se ha realizado evaluaci&oacute;n del contrato N° '.$numero_documento.' , suscrito con el proveedor '.$nombre_proveedor.',para el servicio de ('.$objeto.').
										A continuaci&oacute;n se encuentra el resultado de su desempe&ntilde;o en la ejecuci&oacute;n del servicio. </tr>
										</table>
										<br>
										<table border="1">
										<tr bgcolor="#1F497D">
										<td><font color="ffffff">OBSERVACION</td><td><font color="ffffff">CLASIFICACION</td><td><font color="ffffff">PUNTAJE</td>
										</tr>
										<tr>
										<td>'.$observacion_general.'</td><td>'.$nombre_clasificacion.'</td><td>'.$total.'</td>
										</tr>
										</table><br> 
										Adjuntos:(Proveedor:'.$destino.',Gestor:'.$destino4.')	
									</body>
								</html>';
 sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}


//CORREO ENVIO DE EVALUACION
function envia_aprobacion_evaluacion_marco_hse($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_crea_aspectos,id_evaluador,id_jefe from vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_crea_aspectos=$result[5];
			$id_evaluador=$result[6];
			$id_jefe=$result[7];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_jefe));
			
	$usuario=$result1[0];
	$destino=$result1[1];

	
$result3=traer_fila_row(query_db("select t1.observacion_general,t2.nombre_clasificacion from t9_agregar_evaluacion t1 inner join t9_clasificacion t2 on t1.id_clasificacion=t2.id_clasificacion where t1.id_agregar_criterio=".$id_evaluacion));
			
	$observacion_general=$result3[0];
	$nombre_clasificacion=$result3[1];

$result4=traer_fila_row(query_db("select sum(puntaje_obtenido) as total FROM t9_agregar_aspecto where id_estado=1 and id_agregar_criterio=".$id_evaluacion));
			
	$total=$result4[0];

	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
			
	$usuario4=$result9[0];
	$destino4=$result9[1];	
		
	$asunto="PENDIENTE APROBACION DE EVALUACION HSSE CONTRATO MARCO";
	
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
										<tr>Se ha realizado evaluaci&oacute;n del contrato N '.$numero_documento.' , suscrito con el proveedor '.$nombre_proveedor.',para el servicio de ('.$objeto.'),
										el cual es gerenciado por el Sr(a). '.$nombre_gerente.'.Se requiere su aprobaci&oacute;n de la evaluaci&oacute;n para que la misma sea enviada para informaci&oacute;n del proveedor. </tr>
										</table>
										<br>
										<table border="1">
										<tr bgcolor="#1F497D">
										<td><font color="ffffff">OBSERVACION</td><td><font color="ffffff">CLASIFICACION</td><td><font color="ffffff">PUNTAJE</td>
										</tr>
										<tr>
										<td>'.$observacion_general.'</td><td>'.$nombre_clasificacion.'</td><td>'.$total.'</td>
										</tr>
										</table>
										<br>
										Adjuntos:(Jefe:'.$destino.',Gestor:'.$destino4.')	
									</body>
								</html>';
 sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}




//CORREO ENVIO DE EVALUACION
function envia_aprobacion_evaluacion_marco_adm($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_crea_aspectos,id_evaluador,id_jefe from vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_crea_aspectos=$result[5];
			$id_evaluador=$result[6];
			$id_jefe=$result[7];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_jefe));
			
	$usuario=$result1[0];
	$destino=$result1[1];

	
$result3=traer_fila_row(query_db("select t1.observacion_general,t2.nombre_clasificacion from t9_agregar_evaluacion t1 inner join t9_clasificacion t2 on t1.id_clasificacion=t2.id_clasificacion where t1.id_agregar_criterio=".$id_evaluacion));
			
	$observacion_general=$result3[0];
	$nombre_clasificacion=$result3[1];

$result4=traer_fila_row(query_db("select sum(puntaje_obtenido) as total FROM t9_agregar_aspecto where id_estado=1 and id_agregar_criterio=".$id_evaluacion));
			
	$total=$result4[0];

	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
			
	$usuario4=$result9[0];
	$destino4=$result9[1];	
		
	$asunto="PENDIENTE APROBACION DE EVALUACION ADMINISTRATIVA CONTRATO MARCO";
	
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
										<tr>Se ha realizado evaluaci&oacute;n del contrato N '.$numero_documento.' , suscrito con el proveedor '.$nombre_proveedor.',para el servicio de ('.$objeto.'),
										el cual es gerenciado por el Sr(a). '.$nombre_gerente.'.Se requiere su aprobaci&oacute;n de la evaluaci&oacute;n para que la misma sea enviada para informaci&oacute;n del proveedor. </tr>
										</table>
										<br>
										<table border="1">
										<tr bgcolor="#1F497D">
										<td><font color="ffffff">OBSERVACION</td><td><font color="ffffff">CLASIFICACION</td><td><font color="ffffff">PUNTAJE</td>
										</tr>
										<tr>
										<td>'.$observacion_general.'</td><td>'.$nombre_clasificacion.'</td><td>'.$total.'</td>
										</tr>
										</table>
										<br>
										Adjuntos:(Jefe:'.$destino.',Gestor:'.$destino4.')	
									</body>
								</html>';
 sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}


//CORREO SOLICITUD ENVIO APROBACION PROVEEDOR
function envia_aprobacion_proveedor_evaluacion_hsse_marco($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_crea_aspectos,id_evaluador,id_jefe,id_proveedor from vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_crea_aspectos=$result[5];
			$id_evaluador=$result[6];
			$id_jefe=$result[7];
			$id_proveedor=$result[8];
			
$result1=traer_fila_row(query_db("select t1.razon_social, t2.email from t1_proveedor as t1, t1_us_usuarios as t2 where t1.t1_proveedor_id=t2.pv_id and t1.t1_proveedor_id=".$id_proveedor." and t2.estado=1"));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
	
$result3=traer_fila_row(query_db("select t1.observacion_general,t2.nombre_clasificacion from t9_agregar_evaluacion t1 inner join t9_clasificacion t2 on t1.id_clasificacion=t2.id_clasificacion where t1.id_agregar_criterio=".$id_evaluacion));
			
	$observacion_general=$result3[0];
	$nombre_clasificacion=$result3[1];

$result4=traer_fila_row(query_db("select sum(puntaje_obtenido) as total FROM t9_agregar_aspecto where id_estado=1 and id_agregar_criterio=".$id_evaluacion));
			
	$total=$result4[0];
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
	$usuario4=$result9[0];
	$destino4=$result9[1];
	
	$asunto="RESULTADOS DE EVALUACION HSSE CONTRATO MARCO";
	
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
										<table>
										<tr>Se ha realizado evaluaci&oacute;n del contrato N° '.$numero_documento.' , suscrito con el proveedor '.$nombre_proveedor.',para el servicio de ('.$objeto.').
										A continuaci&oacute;n se encuentra el resultado de su desempe&ntilde;o en la ejecuci&oacute;n del servicio. </tr>
										</table><br> 
										Adjuntos:('.$destino.')	
										<br>
										<table>
										<tr bgcolor="#1F497D">
										<td><font color="ffffff">OBSERVACION</td><td><font color="ffffff">CLASIFICACION</td><td><font color="ffffff">PUNTAJE</td>
										</tr>
										<tr>
										<td>'.$observacion_general.'/td><td>'.$nombre_clasificacion.'</td><td>'.$total.'</td>
										</tr>
										</table>
									</body>
								</html>';
sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}



//CORREO SOLICITUD ENVIO APROBACION PROVEEDOR
function envia_aprobacion_proveedor_evaluacion_adm_marco($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio_contrato,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_crea_aspectos,id_evaluador,id_jefe,id_proveedor from vista_t9_contrato_marco where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_crea_aspectos=$result[5];
			$id_evaluador=$result[6];
			$id_jefe=$result[7];
			$id_proveedor=$result[8];
			
$result1=traer_fila_row(query_db("select t1.razon_social, t2.email from t1_proveedor as t1, t1_us_usuarios as t2 where t1.t1_proveedor_id=t2.pv_id and t1.t1_proveedor_id=".$id_proveedor." and t2.estado=1"));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
	
$result3=traer_fila_row(query_db("select t1.observacion_general,t2.nombre_clasificacion from t9_agregar_evaluacion t1 inner join t9_clasificacion t2 on t1.id_clasificacion=t2.id_clasificacion where t1.id_agregar_criterio=".$id_evaluacion));
			
	$observacion_general=$result3[0];
	$nombre_clasificacion=$result3[1];

$result4=traer_fila_row(query_db("select sum(puntaje_obtenido) as total FROM t9_agregar_aspecto where id_estado=1 and id_agregar_criterio=".$id_evaluacion));
			
	$total=$result4[0];
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
	$usuario4=$result9[0];
	$destino4=$result9[1];
	
	$asunto="RESULTADOS DE EVALUACION ADMINISTRATIVA CONTRATO MARCO";
	
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
										<table>
										<tr>Se ha realizado evaluaci&oacute;n del contrato N° '.$numero_documento.' , suscrito con el proveedor '.$nombre_proveedor.',para el servicio de ('.$objeto.').
										A continuaci&oacute;n se encuentra el resultado de su desempe&ntilde;o en la ejecuci&oacute;n del servicio. </tr>
										</table><br> 
										Adjuntos:('.$destino.')	
										<br>
										<table>
										<tr bgcolor="#1F497D">
										<td><font color="ffffff">OBSERVACION</td><td><font color="ffffff">CLASIFICACION</td><td><font color="ffffff">PUNTAJE</td>
										</tr>
										<tr>
										<td>'.$observacion_general.'/td><td>'.$nombre_clasificacion.'</td><td>'.$total.'</td>
										</tr>
										</table>
									</body>
								</html>';
 sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}

?>