<?
	
	include("../../librerias/lib/@include.php");
	//include('../../php/alertas_contratos_llena_push.php');
	//error_reporting(E_ALL);  // L&iacute;neas para mostart errores
	//ini_set('display_errors', '2');  // L&iacute;neas para mostart errores
	$tabla='';
	$fecha_actual= date('Y-m-d');
	$dia_mes_actual=date('m-d');
	$si_es_1=explode("-",$fecha_actual);
	$si_es_15=explode("-",$fecha_actual);
	//$dia_1= date('Y-m-01', strtotime($fecha_actual));
	$un_mes =strtotime ( '-1 month' , strtotime ($fecha_actual) );
	$un_mes=date('Y-m-d', $un_mes);
	$quince_dias =strtotime ( '-15 days' , strtotime ($fecha_actual) );
	$quince_dias=date('Y-m-d', $quince_dias);
	$dos_meses = strtotime ( '+2 month' , strtotime ($fecha_actual) );
	$dos_meses=date('Y-m-d',$dos_meses);
	$tres_meses = strtotime ( '+3 month' , strtotime ($fecha_actual) );
	$tres_meses=date('Y-m-d',$tres_meses);
	$cuatro_meses = strtotime ( '+4 month' , strtotime ($fecha_actual) );
	$cuatro_meses=date('Y-m-d',$cuatro_meses);
	$dia_2= date('Y-m-t', strtotime($fecha_actual));
	$query=query_db("SELECT nombre_administrador, email FROM t1_us_usuarios WHERE us_id=17968");
	$gestor = traer_fila_row($query);
	$query="select * from v_tarifas_ipc_anual where ipc_administracion = 1 and estado = 1 and fecha_fin>='$fecha_actual'";
	$sql_query=query_db($query);
	while($sql_con = traer_fila_db($sql_query)){//PARA BUSCAR LOS CONTRATOS QUE APLIQUEN IPC DENTRO DEL RANGO ESTIMADO
		$carta='<p style="font-size: 10pt !important; font-family: arial;">Se&ntilde;ores:<br>
	Gerente de Contrato: <--gerente-->.<br>Contratista: <--proveedor-->.<br><br>
	La anualidad de su contrato <strong><--contrato--></strong>, cuyo objeto es: <--objeto-->, "se cumple <--tiempo-->", por lo cual recuerde, realizar a sus tarifas el incremento por IPC  correspondiente, ingresando a la plataforma SGPA por la opci&oacute;n indicada para este fin.<br><br>
	Cordialmente.<br><br>
	<strong><--gerente-->.</strong><br>
	Gerente de Contrato.
	<br><br>
	<strong><--gestor-->.</strong><br>
	Gestor de Abastecimiento.</p>';
		$objeto=$sql_con[15];
		$numero_contrato1 = "C";
		$separa_fecha_crea = explode("-",$sql_con[4]);
		$ano_contra = $separa_fecha_crea[0];
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $sql_con[3];
		$numero_contrato4 = $sql_con[5];
		$numero=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sql_con[0]);
		//echo $numero."<br>";
		$un_mes =strtotime ( '-1 month' , strtotime ($sql_con[1]) );
		$un_mes=date('Y-m-d', $un_mes);
		//echo $un_mes."<br>";
		$quince_dias =strtotime ( '-15 days' , strtotime ($sql_con[1]) );
		$quince_dias=date('Y-m-d', $quince_dias);
		//echo $quince_dias."<br>";
		$hoy=explode('-', $sql_con[1]);
		$quince_dias=explode('-', $quince_dias);
		$un_mes=explode('-', $un_mes);
		//echo $sql_con[1]."<br><br>";
		//echo $dia_mes_actual."-----".$hoy[1]."-".$hoy[2]."hoy <br>";
		if($dia_mes_actual==$hoy[1]."-".$hoy[2]){
			$carta=str_replace('<--proveedor-->', $sql_con[7], $carta);
			$carta=str_replace('<--contrato-->', $numero, $carta);
			$carta=str_replace('<--tiempo-->', "en <strong>hoy</strong> ".$sql_con[1], $carta);
			$carta=str_replace('<--objeto-->', $objeto, $carta);
			$carta=str_replace('<--gerente-->', $sql_con[8], $carta);
			$carta=str_replace('<--gestor-->', $gestor[0], $carta);
			$correos_envia=str_replace('&#64;', '@', $sql_con[6]).",,".str_replace('&#64;', '@', $sql_con[9]).",,".str_replace('&#64;', '@', $gestor[1]);
			//$carta.="<br>este correo se enviar&aacute; a: ".$correos_envia;
			sent_mail_with_signature($correos_envia,'INCREMENTO DE IPC POR CUMPLIMIENTO DE ANUALIDAD DEL CONTRATO '.$numero, $carta, $sql_con[9], $sql_con[8]);
			echo $carta;
		}
		//echo $dia_mes_actual."-----".$quince_dias[1]."-".$quince_dias[2]."quince dias <br>";
		if($dia_mes_actual==$quince_dias[1]."-".$quince_dias[2]){
			$carta=str_replace('<--proveedor-->', $sql_con[7], $carta);
			$carta=str_replace('<--contrato-->', $numero, $carta);
			$carta=str_replace('<--tiempo-->', "en <strong>15 d&iacute;as</strong> ".$sql_con[1], $carta);
			$carta=str_replace('<--objeto-->', $objeto, $carta);
			$carta=str_replace('<--gerente-->', $sql_con[8], $carta);
			$carta=str_replace('<--gestor-->', $gestor[0], $carta);
			$correos_envia=str_replace('&#64;', '@', $sql_con[6]).",,".str_replace('&#64;', '@', $sql_con[9]).",,".str_replace('&#64;', '@', $gestor[1]);
			//$carta.="<br><br>este correo se enviar&aacute; a: ".$correos_envia;
			sent_mail_with_signature($correos_envia,'INCREMENTO DE IPC POR CUMPLIMIENTO DE ANUALIDAD DEL CONTRATO '.$numero, $carta, $sql_con[9], $sql_con[8]);
			echo $carta;
		}
		//echo $dia_mes_actual."-----".$un_mes[1]."-".$un_mes[2]."un mes <br><br>";
		if($dia_mes_actual==$un_mes[1]."-".$un_mes[2]){
			$carta=str_replace('<--proveedor-->', $sql_con[7], $carta);
			$carta=str_replace('<--contrato-->', $numero, $carta);
			$carta=str_replace('<--tiempo-->', "en <strong>1 mes</strong> ".$sql_con[1], $carta);
			$carta=str_replace('<--objeto-->', $objeto, $carta);
			$carta=str_replace('<--gerente-->', $sql_con[8], $carta);
			$carta=str_replace('<--gestor-->', $gestor[0], $carta);
			$correos_envia=str_replace('&#64;', '@', $sql_con[6]).",,".str_replace('&#64;', '@', $sql_con[9]).",,".str_replace('&#64;', '@', $gestor[1]);
			//$carta.="<br><br>este correo se enviar&aacute; a: ".$correos_envia;
			sent_mail_with_signature($correos_envia,'INCREMENTO DE IPC POR CUMPLIMIENTO DE ANUALIDAD DEL CONTRATO '.$numero, $carta, $sql_con[9], $sql_con[8]);
			echo $carta;
		}
		//echo "fecha de inicio: ".$sql_con[1]." quince dias antes: ".$quince_dias."<br>";
	}
?>