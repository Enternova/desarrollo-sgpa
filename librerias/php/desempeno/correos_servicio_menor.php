<?php
include('../../PHPMailer_v2.0.0/class.phpmailer.php'); 


//CORREO ENVIO DE CRITERIOS PARA APROBACION
function envia_aprobacion_aspecto_menor($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct periodo_evaluacion,nombre_proveedor,numero_documento,convert(varchar(max), objeto),id_crea_aspectos,id_jefe,id_gerente,id_proveedor from vista_t9_servicio_menor where id_evaluacion=".$id_evaluacion));
			 
			$periodo_evaluacion=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$id_crea_aspectos = $result[4];
			$id_jefe=$result[5];
			$id_gerente=$result[6];
			$id_proveedor=$result[7];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_jefe));
			
	$usuario=$result1[0];
	$destino=$result1[1];

$result6=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_crea_aspectos));
			
	$solicitante=$result6[0];
	$destino0=$result6[1];
	
	
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
			
	$usuario4=$result9[0];
	$destino4=$result9[1];

	$asunto="PENDIENTE APROBACION DE CRITERIOS SERVICIO MENOR";
	
	$destino1='josef.fovor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";
	
	
$select_tabla1="select numero_documento, convert(varchar(max), objeto) as objeto, '$'+convert(varchar(20), valor_cop)+'COP $'+convert(varchar(20), valor_usd)+'USD' AS valor, fecha_inicio_ot, fecha_fin_ot, id_gerente, id_proveedor   from vista_t9_servicio_menor_correo WHERE id_gerente='".$id_gerente."' AND id_proveedor='".$id_proveedor."' AND CONVERT(DATE, fecha_inicio_ot) BETWEEN '2017-10-01' AND '2018-04-01'";

$query1=query_db($select_tabla1);	


$select_tabla="select nombre_aspectos, puntaje_maximo FROM vista_t9_servicio_menor where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;

$query=query_db($select_tabla);


					$mensaje_envio ='<html>
									<body>
										<table >
										<tr><td>Sr(a).</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>Durante el periodo comprendido entre el '.$periodo_evaluacion.' , Sr(a). '.$solicitante.', solicit&oacute; y ejecut&oacute; los servicios menores <br>
										que se se&ntilde;alan en la tabla a continuaci&oacute;n, con el proveedor '.$nombre_proveedor.'</tr>
										</table>
										<br>
										<table border="1" >
										<tr bgcolor="#1F497D"><td><font color="ffffff">N de Servicio Menor</td><td><font color="ffffff">Objeto</td><td><font color="ffffff">Valor</td><td><font color="ffffff">Fecha Fin</td>  </tr>';
											
										while($lt1=traer_fila_db($query1)){
											
										$mensaje_envio.='<tr> <td>'.$lt1[0].'</td><td>'.$lt1[1].'</td><td>'.$lt1[2].'</td><td>'.$lt1[4].'</td> </tr>';
											
											}
											
										$mensaje_envio.='
										
										</table>									
									<br><br><br>
										<br>
										<table>
										<tr>Para realizar evaluaci&oacute;n del desempe&ntilde;o del contratista en los ya mencionados servicios, el solicitante estableci&oacute; los criterios a continuaci&oacute;n, los cuales requieren su aprobaci&oacute;n para proceder a evaluar. Tenga en cuenta que estos criterios al igual que la evaluaci&oacute;n aplicar&aacute;n para la totalidad de los servicios menores relacionados.</tr>
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
										<br>Adjuntos:(Jefe:'.$destino.',Gestor:'.$destino4.')	
									</body>
								</html>';
sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}



//CORREO ENVIO DE CRITERIOS APROBADOS AL PROVEEDOR
function envio_aprobacion_aspecto_proveedor_menor($id_evaluacion) {
	
	
	$result=traer_fila_row(query_db("select distinct periodo_evaluacion,nombre_proveedor,numero_documento,convert(varchar(max), objeto),id_crea_aspectos,id_jefe,id_gerente,id_proveedor from vista_t9_servicio_menor where id_evaluacion=".$id_evaluacion));
			 
			$periodo_evaluacion=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$id_crea_aspectos = $result[4];
			$id_jefe=$result[5];
			$id_gerente=$result[6];
			$id_proveedor=$result[7];
			
$result1=traer_fila_row(query_db("select t1.razon_social, t2.email from t1_proveedor as t1, t1_us_usuarios as t2 where t1.t1_proveedor_id=t2.pv_id and t1.t1_proveedor_id=".$id_proveedor." and t2.estado=1"));
			
	$usuario=$result1[0];
	$destino=$result1[1];

$result6=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_crea_aspectos));
			
	$solicitante=$result6[0];
	$destino0=$result6[1];
	
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
			
	$usuario4=$result9[0];
	$destino4=$result9[1];

	$asunto="CRITERIOS APROBADOS PARA EVALUACION SERVICIO MENOR";
	
	$destino1='josef.fovor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";
	
$select_tabla1="select numero_documento, convert(varchar(max), objeto) as objeto, '$'+convert(varchar(20), valor_cop)+'COP $'+convert(varchar(20), valor_usd)+'USD' AS valor, fecha_inicio_ot, fecha_fin_ot, id_gerente, id_proveedor   from vista_t9_servicio_menor_correo WHERE id_gerente='".$id_gerente."' AND id_proveedor='".$id_proveedor."' AND CONVERT(DATE, fecha_inicio_ot) BETWEEN '2017-10-01' AND '2018-04-01'";

$query1=query_db($select_tabla1);	


$select_tabla="select nombre_aspectos, puntaje_maximo FROM vista_t9_servicio_menor where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;

$query=query_db($select_tabla);


					$mensaje_envio ='<html>
									<body>
										<table >
										<tr><td>Sr(a).</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table >
										<tr>Durante el periodo comprendido entre el '.$periodo_evaluacion.' , usted ejecut&oacute; para HOCOL S.A, los servicios menores 
										que se se&ntilde;alan en la tabla a continuaci&oacute;n, los cuales fueron solicitados por el Sr(a). '.$solicitante.'.</tr>
										</table>
										<br>
										<table border="1">
										<tr bgcolor="#1F497D"><td ><font color="ffffff">N de Servicion Menor</td><td><font color="ffffff">Objeto</td><td><font color="ffffff">Valor</td><td><font color="ffffff">Fecha Fin</td>  </tr>';
											
										while($lt1=traer_fila_db($query1)){
											
										$mensaje_envio.='<tr> <td>'.$lt1[0].'</td><td>'.$lt1[1].'</td><td>'.$lt1[2].'</td><td>'.$lt1[4].'</td> </tr>';
											
											}
											
										$mensaje_envio.='
										
										</table>									
									<br><br>
									<table >
										<tr>A continuaci&oacute;n se muestran los criterios con los cuales ser&aacute; evaluado su desempe&ntilde;o en los servicios antes mencionados.</tr>
										</table>
										<br><br>
									<table border="1">
									<tr bgcolor="#1F497D"><td><font color="ffffff">ASPECTOS DEFINIDOS</td><td><font color="ffffff">PUNTOS</td></tr>';
									
										$total=0;	
										while($lt=traer_fila_db($query)){
											$total=$total+$lt[1];
										$mensaje_envio.='<tr> <td>'.$lt[0].'</td><td>'.$lt[1].'</td> </tr>';
											
											}
											
										$mensaje_envio.='<tr bgcolor="#1F497D"> <td><font color="ffffff">TOTAL</td><td><font color="ffffff">'.$total.'</td> </tr>
										</table>
										<br>Adjuntos:(Proveedor:'.$destino.',Gestor:'.$destino4.')	
									</body>
								</html>';
sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}

//CORREO APROBACION DE EVALUACION TECNICA
function envia_aprobacion_evaluacion_menor($id_evaluacion) {
	
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
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_jefe));
			
	$usuario=$result1[0];
	$destino=$result1[1];

$result6=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_evaluador));
			
	$solicitante=$result6[0];
	$destino0=$result6[1];
	
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
			
	$usuario4=$result9[0];
	$destino4=$result9[1];

	$asunto="PENDIENTE APROBACION DE EVALUACION TECNICA SERVICIO MENOR";
	
	$destino1='josef.fovor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";
	
	
$select_tabla1="select numero_documento, convert(varchar(max), objeto) as objeto, '$'+convert(varchar(20), valor_cop)+'COP $'+convert(varchar(20), valor_usd)+'USD' AS valor, fecha_inicio_ot, fecha_fin_ot, id_gerente, id_proveedor   from vista_t9_servicio_menor_correo WHERE id_gerente='".$id_gerente."' AND id_proveedor='".$id_proveedor."' AND CONVERT(DATE, fecha_inicio_ot) BETWEEN '2017-10-01' AND '2018-04-01'";

$query1=query_db($select_tabla1);	

$select_tabla="select nombre_aspectos, puntaje_maximo FROM vista_t9_servicio_menor where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;

$query=query_db($select_tabla);

$select_tabla2="select t1.observacion_general,t2.nombre_clasificacion from t9_agregar_evaluacion t1 inner join t9_clasificacion t2 on t1.id_clasificacion=t2.id_clasificacion where t1.id_agregar_criterio=".$id_evaluacion;

$query2=query_db($select_tabla2);

					$mensaje_envio ='<html>
									<body>
										<table>
										<tr><td>Sr(a).</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table >
										<tr>Durante el periodo comprendido entre el '.$periodo_evaluacion.' , el Sr(a). '.$solicitante.', solicit&oacute; y ejecut&oacute; 
										los servicios menores que se se&ntilde;alan en la tabla a continuaci&oacute;n con el proveedor, '.$nombre_proveedor.'  </tr>
										</table>
										<br>
										<table border="1">
										<tr bgcolor="#1F497D"><td><font color="ffffff">N de Servicion Menor</td><td><font color="ffffff">Objeto</td><td><font color="ffffff">Valor</td><td><font color="ffffff">Fecha  </td>  </tr>';
											
										while($lt1=traer_fila_db($query1)){
											
										$mensaje_envio.='<tr> <td>'.$lt1[0].'</td><td>'.$lt1[1].'</td><td>'.$lt1[2].'</td><td>'.$lt1[4].'</td> </tr>';
											
											}
											
										$mensaje_envio.='
										

										</table>	<br>								
										<table >	
											<tr>
												<td>A continuaci&oacute;n se remite el resultado de la evaluaci&oacute;n de desempe&ntilde;o del contratista en la ejecuci&oacute;n de los mismos, 
													la cual requiere de su aprobaci&oacute;n para quedar "en firme" y ser enviada al proveedor para su conocimiento. </td>
											</tr>
										</table><br>

											<table border="1">
									<tr bgcolor="#1F497D"><td ><font color="ffffff">ASPECTOS DEFINIDOS</td><td><font color="ffffff">PUNTOS</td></tr>';
									
										$total=0;	
										while($lt=traer_fila_db($query)){
											$total=$total+$lt[1];
										$mensaje_envio.='<tr> <td>'.$lt[0].'</td><td>'.$lt[1].'</td> </tr>';
											
											}
											
										$mensaje_envio.='<tr bgcolor="#1F497D"> <td><font color="ffffff">TOTAL</td><td><font color="ffffff">'.$total.'</td> </tr>
										<tr></tr>
									<tr bgcolor="#1F497D"><td ><font color="ffffff">OBSERVACION GENERAL</td><td><font color="ffffff">CLASIFICACION</td></tr>';
									
										
										while($lt2=traer_fila_db($query2)){
											
										$mensaje_envio.='<tr> <td>'.$lt2[0].'</td><td>'.$lt2[1].'</td> </tr>';
											
											}
											
										$mensaje_envio.='
										</table>
										<br>Adjuntos:(Jefe:'.$destino.',Gestor:'.$destino4.')	
									
									
									</body>
								</html>';
sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}	


//CORREO PROVEEDOR DE EVALUACION TECNICA
function envia_aprobacion_proveedor_evaluacion_menor($id_evaluacion) {
	
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
			
$result1=traer_fila_row(query_db("select t1.razon_social, t2.email from t1_proveedor as t1, t1_us_usuarios as t2 where t1.t1_proveedor_id=t2.pv_id and t1.t1_proveedor_id=".$id_proveedor." and t2.estado=1"));
			
	$usuario=$result1[0];
	$destino=$result1[1];

$result6=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_evaluador));
			
	$solicitante=$result6[0];
	$destino0=$result6[1];
	
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
			
	$usuario4=$result9[0];
	$destino4=$result9[1];

	$asunto="RESULTADOS DE EVALUACION TECNICA SERVICIO MENOR";
	
	$destino1='josef.fovor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";
	
	
$select_tabla1="select numero_documento, convert(varchar(max), objeto) as objeto, '$'+convert(varchar(20), valor_cop)+'COP $'+convert(varchar(20), valor_usd)+'USD' AS valor, fecha_inicio_ot, fecha_fin_ot, id_gerente, id_proveedor   from vista_t9_servicio_menor_correo WHERE id_gerente='".$id_gerente."' AND id_proveedor='".$id_proveedor."' AND CONVERT(DATE, fecha_inicio_ot) BETWEEN '2017-10-01' AND '2018-04-01'";

$query1=query_db($select_tabla1);	

$select_tabla="select nombre_aspectos, puntaje_maximo FROM vista_t9_servicio_menor where estado_aspecto='1' and id_evaluacion=".$id_evaluacion;

$query=query_db($select_tabla);

$select_tabla2="select t1.observacion_general,t2.nombre_clasificacion from t9_agregar_evaluacion t1 inner join t9_clasificacion t2 on t1.id_clasificacion=t2.id_clasificacion where t1.id_agregar_criterio=".$id_evaluacion;

$query2=query_db($select_tabla2);

					$mensaje_envio ='<html>
									<body>
										<table >
										<tr><td>Sr(a).</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table >
										<tr>Durante el periodo comprendido entre el '.$periodo_evaluacion.' , usted ejecut&oacute; para HOCOL S.A, los servicios menores
										que se se&ntilde;alan en la tabla a continuaci&oacute;n, los cuales fueron solicitados por el Sr '.$solicitante.'  </tr>
										</table>
										<br>
										<table border="1">
										<tr bgcolor="#1F497D"><td><font color="ffffff">N de Servicion Menor</td><td><font color="ffffff">Objeto</td><td><font color="ffffff">Valor</td><td><font color="ffffff">Fecha  </td>  </tr>';
											
										while($lt1=traer_fila_db($query1)){
											
										$mensaje_envio.='<tr> <td>'.$lt1[0].'</td><td>'.$lt1[1].'</td><td>'.$lt1[2].'</td><td>'.$lt1[4].'</td> </tr>';
											
											}
											
										$mensaje_envio.='
										

										</table>	<br>								
										<table>	
											<tr >
												<td>A continuaci&oacute;n se remite el resultado de la evaluaci&oacute;n de su desempe&ntilde;o en la ejecuci&oacute;n de los mismos.  </td>
											</tr>
										</table><br>

											<table border="1">
									<tr bgcolor="#1F497D"><td ><font color="ffffff">ASPECTOS DEFINIDOS</td><td><font color="ffffff">PUNTOS</td></tr>';
									
										$total=0;
										while($lt=traer_fila_db($query)){
											$total=$total+$lt[1];
										$mensaje_envio.='<tr> <td>'.$lt[0].'</td><td>'.$lt[1].'</td> </tr>';
											
											}
											
										$mensaje_envio.='<tr bgcolor="#1F497D"> <td><font color="ffffff">TOTAL</td><td><font color="ffffff">'.$total.'</td> </tr>
										<tr></tr>
									<tr bgcolor="#1F497D"><td ><font color="ffffff">OBSERVACION GENERAL</td><td><font color="ffffff">CLASIFICACION</td></tr>';
									
										
										while($lt2=traer_fila_db($query2)){
											
										$mensaje_envio.='<tr> <td>'.$lt2[0].'</td><td>'.$lt2[1].'</td> </tr>';
											
											}
											
										$mensaje_envio.='
										</table>
									<br>Adjuntos:(Proveedor:'.$destino.',Gestor:'.$destino4.')	
									
									</body>
								</html>';
 sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}






?>