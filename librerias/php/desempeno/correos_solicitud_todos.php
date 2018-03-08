<?php

 include("../../lib/@session.php");
//CORREO SOLICITUD DEFINIR CRITERIOS SERVICIO MENOR
function definir_aspecto_menor($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct periodo_evaluacion,nombre_proveedor,numero_documento,convert(varchar(max), objeto),nombre_gerente,id_crea_aspectos,id_proveedor,id_documento from vista_t9_servicio_menor where id_evaluacion=".$id_evaluacion));
			 
			$periodo_evaluacion=$result[0];
			$nombre_proveedor=$result[1];
			$numero_documento=$result[2];
			$objeto=$result[3];
			$nombre_gerente = $result[4];
			$id_crea_aspectos=$result[5];
			$id_proveedor=$result[6];
			$id_documento=$result[7];
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_crea_aspectos));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
			
	$usuario4=$result9[0];
	$destino4=$result9[1];

	$asunto="PENDIENTE DEFINIR CRITERIOS SERVICIO MENOR";
	$destino1=$destino.',,'.$destino4.",,";
	//$destino1='josef.fodor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";
	
	
	$anno=date('Y');
	$mes=date('m');
	$dia=date('d');
		if($mes<7){
			
			$periodo=$anno."-01-01 / ".$anno."-06-30";
			$fecha_ini=$anno."-01-01";
			$fecha_fi=$anno."-06-30";
		}
		if($mes>6){
			
			$periodo=$anno."-07-01 / ".$anno."-12-31";
			$fecha_ini=$anno."-07-01";
			$fecha_fi=$anno."-12-31";
		}

	
	
$select_tabla1="select numero_documento, convert(varchar(max), objeto) as objeto, '$'+convert(varchar(20), valor_cop)+'COP $'+convert(varchar(20), valor_usd)+'USD' AS valor, fecha_inicio_ot, fecha_fin_ot, id_gerente, id_proveedor,valor_cop,valor_usd   from vista_t9_servicio_menor_correo WHERE id_gerente='".$id_crea_aspectos."' AND id_proveedor='".$id_proveedor."' AND id_documento='".$id_documento."' AND CONVERT(DATE, fecha_inicio_ot) BETWEEN '".$fecha_ini."' AND '".$fecha_fi."' and fecha_inicio_ot is not NULL and fecha_fin_ot is not NULL";

$query1=query_db($select_tabla1);

					$mensaje_envio ='<html>
									<body>
										<table >
										<tr><td>Apreciado.</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>Durante el periodo comprendido entre el '.$periodo.', usted solicit&oacute; y ejecut&oacute; los servicios menores,
										con el proveedor. '.$nombre_proveedor.', Por favor establezca los criterios para 
										evaluar al contratista. Tenga en cuenta que estos criterios al igual que la evaluaci&oacute;n aplicar&aacute;n para la totalidad de los 
										servicios menores relacionados. </tr>
										</table >
										
										<table border="1">
										<tr bgcolor="#1F497D"><td><font color="ffffff">N de Servicion Menor</td><td><font color="ffffff">Objeto</td><td><font color="ffffff">Valor</td><td><font color="ffffff">Fecha Fin</td>  </tr>';
										$mensaje_envio2="";		
										while($lt1=traer_fila_db($query1)){
											
										$mensaje_envio2.='<tr> <td>'.$lt1[0].'</td><td>'.$lt1[1].'</td><td>$'.number_format($lt1[7]).'COP - $'.number_format($lt1[8],2,",",".").'USD </td><td>'.$lt1[4].'</td> </tr>';
											
											}
											
										$mensaje_envio.=$mensaje_envio2.'
										
										</table>

										
									</body>
								</html>';
sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}



//CORREO SOLICITUD EVALUACION TECNICA SERVICIO MENOR
function solicitud_evaluacion_menor($id_evaluacion,$fecha_inicio,$fecha_fin) {
	
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
	$destino1=$destino.',,'.$destino4.",,";
	//$destino1='josef.fodor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";
	
	$anno=date('Y');
	$mes=date('m');
	$dia=date('d');
		if($mes<7){
			
			$periodo=$anno."-01-01 / ".$anno."-06-30";
			$fecha_ini=$anno."-01-01";
			$fecha_fi=$anno."-06-30";
		}
		if($mes>6){
			
			$periodo=$anno."-07-01 / ".$anno."-12-31";
			$fecha_ini=$anno."-07-01";
			$fecha_fi=$anno."-12-31";
		}

	
$select_tabla1="select numero_documento, convert(varchar(max), objeto) as objeto, '$'+convert(varchar(20), valor_cop)+'COP $'+convert(varchar(20), valor_usd)+'USD' AS valor, fecha_inicio_ot, fecha_fin_ot, id_gerente, id_proveedor,valor_cop,valor_usd   from vista_t9_servicio_menor_correo WHERE id_gerente='".$id_gerente."' AND id_proveedor='".$id_proveedor."' AND CONVERT(DATE, fecha_inicio_ot) BETWEEN '".$fecha_ini."' AND '".$fecha_fi."' and fecha_inicio_ot is not NULL and fecha_fin_ot is not NULL";

$query1=query_db($select_tabla1);	

					$mensaje_envio ='<html>
									<body>
										<table >
										<tr><td>Sr(a).</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table >
										<tr>Durante el periodo comprendido entre el '.$periodo.' , usted solicit&oacute; y ejecut&oacute; los servicios menores 
										que se se&ntilde;alan en la tabla a continuaci&oacute;n, con el proveedor. '.$nombre_proveedor.', Por favor realice la evaluaci&oacute;n 
										de desempe&ntilde;o del contratista con base en los criterios establecidos. Tenga en cuenta que estos criterios al igual que 
										la evaluaci&oacute;n aplicar&aacute;n para la totalidad de los servicios menores relacionados. </tr>
										</table>
										<br>
										<table border="1">
										<tr bgcolor="#1F497D"><td><font color="ffffff">N de Servicion Menor</td><td><font color="ffffff">Objeto</td><td><font color="ffffff">Valor</td><td><font color="ffffff">Fecha Fin</td>  </tr>';
										$mensaje_envio2="";		
										while($lt1=traer_fila_db($query1)){
											
										$mensaje_envio2.='<tr> <td>'.$lt1[0].'</td><td>'.$lt1[1].'</td><td>$'.number_format($lt1[7]).'COP - $'.$lt1[2].'USD </td><td>'.$lt1[4].'</td> </tr>';
											
											}
											
										$mensaje_envio.=$mensaje_envio2.'
										
										</table>
											
								
									</body>
								</html>';
 
  $valida_fecha=traer_fila_row(query_db("select fecha_solicitud from t9_criterios_evaluacion where id_agregar_criterio=".$id_evaluacion));


if($valida_fecha[0]>$fecha_ini and $valida_fecha[0]<$fecha_fi){

sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);

}
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
	$destino1=$destino.',,'.$destino4.",,";
	//$destino1='josef.fodor@enternova.net,,';
	//$destino1='josef.fodor@enternova.net,,jeison.rivera@enternova.net';
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
										<tr>El '.$fecha_inicio_contrato.' ,se suscribi&oacute; con '.$nombre_proveedor.', el contrato '.$numero_documento.' para la prestaci&oacute;n del servicio ('.$objeto.'),
										el cual es gerenciado por el Sr(a). '.$nombre_gerente.'.Por favor establezca los criterios con los cuales se evaluar&aacute; el desempe&ntilde;o del contratista 
										en los servicios que se ejecutar&aacute;n en el marco del contrato.</tr>
										</table>	
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
	$destino1=$destino.',,'.$destino4.",,";
	//$destino1='josef.fodor@enternova.net,,';
	//$destino1='josef.fodor@enternova.net,,jeison.rivera@enternova.net';
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
										<tr>El '.$fecha_inicio_contrato.' ,se suscribi&oacute; con '.$nombre_proveedor.', el contrato N '.$numero_documento.' para la prestaci&oacute;n del servicio ('.$objeto.'),
										el cual es gerenciado por el Sr(a). '.$nombre_gerente.'.Por favor realice la evaluaci&oacute;n t&eacute;cnica de desempe&ntilde;o al proveedor teniendo en cuenta los criterios
										establecidos para evaluar al mismo. </tr>
										</table>	
									</body>
								</html>';


$valida_fecha=traer_fila_row(query_db("select fecha_solicitud from t9_criterios_evaluacion where id_agregar_criterio=".$id_evaluacion));

$fecha = date('Y-m-d');
$nuevafecha = strtotime ( '-1 year' , strtotime ( $fecha ) ) ;
$fecha_valida_act = date ( 'Y-m-d' , $nuevafecha );

if($valida_fecha[0]==$fecha_valida_act){

sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);

}
}



//CORREO SOLICITUD EVALUACION HSSE
function evaluacion_puntual_hsse($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio,razon_social,id_evaluador,id_documento,nombre_gerente_contrato from vista_t9_contratos_definicion_criterios2 where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$id_evaluador=$result[2];
			$documento=$result[3];
			$nombre_gerente_contrato=$result[4];
			
$result23=traer_fila_row(query_db("select numero_documento from vista_t9_contratos_definicion_criterios where id_contrato =".$documento));			
			$numero_documento=$result23[0];
			
			
$result2213=traer_fila_row(query_db("select convert(varchar(max), objeto) from t7_contratos_contrato where id =".$documento));			
			$objeto=$result2213[0];
			
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_evaluador));
			
	$usuario=$result1[0];
	$destino=$result1[1];

	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
	$usuario4=$result9[0];
	$destino4=$result9[1];

	$asunto="SOLICITUD DE EVALUACION HSSE PROVEEDOR CONTRATO PUNTUAL";
	$destino1=$destino.',,'.$destino4.",,";
	//$destino1='josef.fodor@enternova.net,,';
	//$destino1='josef.fodor@enternova.net,,jeison.rivera@enternova.net';
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
										<tr>El '.$fecha_inicio_contrato.' ,se suscribi&oacute; con '.$nombre_proveedor.', el contrato '.$numero_documento.' para la prestaci&oacute;n del servicio ('.$objeto.'),
										el cual es gerenciado por el Sr(a). '.$nombre_gerente_contrato.'.Por favor realice la evaluaci&oacute;n de desempe&ntilde;o de HSSE al proveedor teniendo en
										cuenta los criterios establecidos para evaluar al mismo. Tenga en cuenta que estos criterios al igual que la evaluaci&oacute;n aplicar&aacute;n
										para la totalidad de las &oacute;rdenes de trabajo y contratos con dicho proveedor.</tr>
										</table>
									</body>
								</html>';
	 sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}



//CORREO SOLICITUD EVALUACION ADM
function evaluacion_puntual_adm($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio,razon_social,id_evaluador,id_documento,nombre_gerente_contrato from vista_t9_contratos_definicion_criterios2 where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$id_evaluador=$result[2];
			$documento=$result[3];
			$nombre_gerente_contrato=$result[4];
			
$result23=traer_fila_row(query_db("select numero_documento from vista_t9_contratos_definicion_criterios where id_contrato =".$documento));			
			$numero_documento=$result23[0];
			
			
$result2213=traer_fila_row(query_db("select convert(varchar(max), objeto) from t7_contratos_contrato where id =".$documento));			
			$objeto=$result2213[0];
			
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_evaluador));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
	$usuario4=$result9[0];
	$destino4=$result9[1];
	
	$asunto="SOLICITUD DE EVALUACION ADMINISTRATIVA PROVEEDOR CONTRATO PUNTUAL";
	$destino1=$destino.',,'.$destino4.",,";
	//$destino1='josef.fodor@enternova.net,,';
	//$destino1='josef.fodor@enternova.net,,jeison.rivera@enternova.net';
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
										<tr>El '.$fecha_inicio_contrato.' ,se suscribi&oacute; con '.$nombre_proveedor.', el contrato '.$numero_documento.' para la prestaci&oacute;n del servicio ('.$objeto.'),
										el cual es gerenciado por el Sr(a). '.$nombre_gerente_contrato.'.Por favor realice la evaluaci&oacute;n de desempe&ntilde;o de Aseguramiento Administrativo al 
										proveedor teniendo en cuenta los criterios establecidos para evaluar al mismo. Tenga en cuenta que estos criterios al igual que la 
										evaluaci&oacute;n aplicar&aacute;n para la totalidad de las &oacute;rdenes de trabajo y contratos contratados con el proveedor.</tr>
										</table>	
									</body>
								</html>';
	 sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}


//CORREO SOLICITUD DEFINIR CRITERIOS CONTRATO MARCO
function definir_aspecto_marco($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio,razon_social,id_crea_aspectos,id_documento from vista_t9_contratos_definicion_criterios2 where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$id_crea_aspectos=$result[2];
			$documento=$result[3];
			
$result23=traer_fila_row(query_db("select numero_documento from vista_t9_contratos_definicion_criterios where id_contrato =".$documento));			
			$numero_documento=$result23[0];
			
			
$result2213=traer_fila_row(query_db("select convert(varchar(max), objeto) from t7_contratos_contrato where id =".$documento));			
			$objeto=$result2213[0];
			
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_crea_aspectos));
			
	$usuario=$result1[0];
	$destino=$result1[1];

$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
	$usuario4=$result9[0];
	$destino4=$result9[1];
	
	$asunto="PENDIENTE DEFINIR CRITERIOS CONTRATO MARCO";
	$destino1=$destino.',,'.$destino4.",,";
	//$destino1='josef.fodor@enternova.net,,';
	//$destino1='josef.fodor@enternova.net,,jeison.rivera@enternova.net';
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
										<tr>El '.$fecha_inicio_contrato.' ,se suscribi&oacute; con '.$nombre_proveedor.', el contrato '.$numero_documento.', para la prestaci&oacute;n del servicio de  <br>
										'.$objeto.' Por favor establezca los criterios con los cuales se evaluar&aacute; el desempe&ntilde;o del contratista en los servicios que se 
										ejecutar&aacute;n en el marco del contrato.</tr>
										<table>	
									</body>
								</html>';
	 sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}


//CORREO SOLICITUD EVALUACION PROVEEDOR
function solicitud_evaluacion_marco($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio,razon_social,id_crea_aspectos,id_documento from vista_t9_contratos_definicion_criterios2 where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$id_crea_aspectos=$result[2];
			$documento=$result[3];
			
$result23=traer_fila_row(query_db("select numero_documento from vista_t9_contratos_definicion_criterios where id_contrato =".$documento));			
			$numero_documento=$result23[0];
			
			
$result2213=traer_fila_row(query_db("select convert(varchar(max), objeto) from t7_contratos_contrato where id =".$documento));			
			$objeto=$result2213[0];
			
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_crea_aspectos));
			
	$usuario=$result1[0];
	$destino=$result1[1];
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
	$usuario4=$result9[0];
	$destino4=$result9[1];
	
	$asunto="SOLICITUD DE EVALUACION TECNICA CONTRATO MARCO";
	$destino1=$destino.',,'.$destino4.",,";
	//$destino1='josef.fodor@enternova.net,,';
	//$destino1='josef.fodor@enternova.net,,jeison.rivera@enternova.net';
	//$destino2="jeison.rivera@enternova.net";
	//$destino3="camila.castaneda@hocol.com.co";
	$emisor="abastecimiento@hcl.com.co";
	$nombre_emisor="ABASTECIMIENTO";
	
	$anno=date('Y');
	$mes=date('m');
	$dia=date('d');
		if($mes<7){
			
			$periodo=$anno."-01-01 / ".$anno."-06-30";
			$fecha_ini=$anno."-01-01";
			$fecha_fi=$anno."-06-30";
		}
		if($mes>6){
			
			$periodo=$anno."-07-01 / ".$anno."-12-31";
			$fecha_ini=$anno."-07-01";
			$fecha_fi=$anno."-12-31";
		}


$select_tabla1="select id_gerente_ot,id_proveedor,numero_otrosi from vista_t9_ordenes_de_trabajo_evaluacion where numero_documento='".$numero_documento."' and CONVERT(DATE, fecha_inicio_ot) BETWEEN '".$fecha_ini."' AND '".$fecha_fi."' and fecha_inicio_ot is not NULL and fecha_fin_ot is not NULL";

$query1=query_db($select_tabla1);	

					$mensaje_envio ='<html>
									<body>
										<table>
										<tr><td>Apreciado .</td><td>'.$usuario.'</td></tr>
										
										</table>
										<br>
										<table>
										<tr>Durante el periodo comprendido entre el '.$periodo.' , usted solicit&oacute; y ejecut&oacute; las &oacute;rdenes de trabajo que 
										se se&ntilde;alan en la tabla a continuaci&oacute;n, con el proveedor '.$nombre_proveedor.', bajo el contrato N '.$numero_documento.', 
										Por favor realice la evaluaci&oacute;n de desempe&ntilde;o del proveedor teniendo en cuenta los criterios establecidos para evaluar 
										al mismo. Tenga en cuenta que estos criterios al igual que la evaluaci&oacute;n aplicar&aacute;n para la totalidad de las
										&oacute;rdenes de trabajo relacionadas.</tr>
										<table>	
										<br>
										
										
										<table border="1">
										<tr bgcolor="#1F497D"><td><font color="ffffff">N de Orden de Trabajo</td><td><font color="ffffff">Objeto</td><td><font color="ffffff">Valor Usd</td><td><font color="ffffff">Valor Cop</td>  </tr>';
						$mensaje_envio2="";	
										while($lt1=traer_fila_db($query1)){
											
											$busca_ot=traer_fila_row(query_db("select numero_otrosi,objeto_ot,valor_usd_ot,valor_cop_ot from vista_t9_ordenes_de_trabajo_evaluacion where numero_otrosi='".$lt1[2]."' and  fecha_inicio_ot is not NULL AND fecha_fin_ot is not NULL and id_gerente_ot='".$lt1[0]."' AND id_proveedor='".$lt1[1]."'"));
											
										$mensaje_envio2.='<tr> <td>'.$busca_ot[0].'</td><td>'.$busca_ot[1].'</td><td>'.number_format($busca_ot[2],2,",",".").'</td><td>'.number_format($busca_ot[3]).'</td> </tr>';
											
											}
											
										$mensaje_envio.=$mensaje_envio2.'
										
										</table>
										
										
										
										
									</body>
								</html>';

 $valida_fecha=traer_fila_row(query_db("select fecha_solicitud from t9_criterios_evaluacion where id_agregar_criterio=".$id_evaluacion));


if($valida_fecha[0]>$fecha_ini and $valida_fecha[0]<$fecha_fi){

sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);

}
}



//CORREO SOLICITUD EVALUACION HSSE
function evaluacion_marco_hsse($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio,razon_social,id_evaluador,id_documento,nombre_gerente_contrato from vista_t9_contratos_definicion_criterios2 where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$id_evaluador=$result[2];
			$documento=$result[3];
			$nombre_gerente=$result[4];
			
$result23=traer_fila_row(query_db("select numero_documento from vista_t9_contratos_definicion_criterios where id_contrato =".$documento));			
			$numero_documento=$result23[0];
			
			
$result2213=traer_fila_row(query_db("select convert(varchar(max), objeto) from t7_contratos_contrato where id =".$documento));			
			$objeto=$result2213[0];
			
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_evaluador));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
	$usuario4=$result9[0];
	$destino4=$result9[1];
	
	$asunto="SOLICITUD DE EVALUACION HSSE PROVEEDOR CONTRATO MARCO";
	$destino1=$destino.',,'.$destino4.",,";
	//$destino1='josef.fodor@enternova.net,,';
	//$destino1='josef.fodor@enternova.net,,jeison.rivera@enternova.net';
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
										<tr>El '.$fecha_inicio_contrato.' ,se suscribi&oacute; con '.$nombre_proveedor.', el contrato '.$numero_documento.' para la prestaci&oacute;n del servicio ('.$objeto.'),
										el cual es gerenciado por el Sr(a). '.$nombre_gerente.'.Por favor realice la evaluaci&oacute;n de desempe&ntilde;o de HSSE al proveedor teniendo en
										cuenta los criterios establecidos para evaluar al mismo. Tenga en cuenta que estos criterios al igual que la evaluaci&oacute;n aplicar&aacute;n
										para la totalidad de las &oacute;rdenes de trabajo y contratos con dicho proveedor.</tr>
										</table>
									</body>
								</html>';
sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}



//CORREO SOLICITUD EVALUACION ADM
function evaluacion_marco_adm($id_evaluacion) {
	
$result=traer_fila_row(query_db("select distinct fecha_inicio,razon_social,id_evaluador,id_documento,nombre_gerente_contrato from vista_t9_contratos_definicion_criterios2 where id_evaluacion=".$id_evaluacion));
			 
			$fecha_inicio_contrato=$result[0];
			$nombre_proveedor=$result[1];
			$id_evaluador=$result[2];
			$documento=$result[3];
			$nombre_gerente=$result[4];
			
$result23=traer_fila_row(query_db("select numero_documento from vista_t9_contratos_definicion_criterios where id_contrato =".$documento));			
			$numero_documento=$result23[0];
			
			
$result2213=traer_fila_row(query_db("select convert(varchar(max), objeto) from t7_contratos_contrato where id =".$documento));			
			$objeto=$result2213[0];
			
			
$result1=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id=".$id_evaluador));
			
	$usuario=$result1[0];
	$destino=$result1[1];
	
$result9=traer_fila_row(query_db("select nombre_administrador,email from t1_us_usuarios where us_id='17'"));
	$usuario4=$result9[0];
	$destino4=$result9[1];
	
	$asunto="SOLICITUD DE EVALUACION ADMINISTRATIVA PROVEEDOR CONTRATO MARCO";
	$destino1=$destino.',,'.$destino4.",,";
	//$destino1='josef.fodor@enternova.net,,';
	//$destino1='josef.fodor@enternova.net,,jeison.rivera@enternova.net';
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
										<tr>El '.$fecha_inicio_contrato.' ,se suscribi&oacute; con '.$nombre_proveedor.', el contrato '.$numero_documento.' para la prestaci&oacute;n del servicio ('.$objeto.'),
										el cual es gerenciado por el Sr(a). '.$nombre_gerente.'.Por favor realice la evaluaci&oacute;n de desempe&ntilde;o de Aseguramiento Administrativo al 
										proveedor teniendo en cuenta los criterios establecidos para evaluar al mismo. Tenga en cuenta que estos criterios al igual que la 
										evaluaci&oacute;n aplicar&aacute;n para la totalidad de las &oacute;rdenes de trabajo, contratos contratados con el proveedor.</tr>
										</table>
									</body>
								</html>';
 sent_mail_with_signature($destino1,$asunto,$mensaje_envio,$emisor,$nombre_emisor);
}



?>