<?
	
	include("../../librerias/lib/@include.php");
	//include('../../php/alertas_contratos_llena_push.php');
	//error_reporting(E_ALL);  // L&iacute;neas para mostart errores
	//ini_set('display_errors', '2');  // L&iacute;neas para mostart errores
	$tabla='';
	$fecha_actual= date('Y-m-d');
	$si_es_1=explode("-",$fecha_actual);
	$si_es_15=explode("-",$fecha_actual);
	//$dia_1= date('Y-m-01', strtotime($fecha_actual));
	$un_mes =strtotime ( '+1 month' , strtotime ($fecha_actual) );
	$un_mes=date('Y-m-d', $un_mes);
	$dos_meses = strtotime ( '+2 month' , strtotime ($fecha_actual) );
	$dos_meses=date('Y-m-d',$dos_meses);
	$tres_meses = strtotime ( '+3 month' , strtotime ($fecha_actual) );
	$tres_meses=date('Y-m-d',$tres_meses);
	$cuatro_meses = strtotime ( '+4 month' , strtotime ($fecha_actual) );
	$cuatro_meses=date('Y-m-d',$cuatro_meses);
	$dia_2= date('Y-m-t', strtotime($fecha_actual));
	$id_gerente="";
	$id_profesional="";
	$id="";
	$correos_mes1="";
	$correos_mes2="";
	$correos_mes3="";
	$correos_mes4="";
	$mes=1;
//function busca_contratos($busca_mes, $mes){//INICIO FUNCION
	$id="";
	//global $co1, $g6, $g1, $pi2;
	//echo "select * FROM t7_contratos_contrato where vigencia_mes between '$fecha_actual' and '$un_mes'<br>";
	$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$fecha_actual' and '$un_mes'");
	while($sql_con = traer_fila_db($query)){//PARA BUSCAR LOS ID DE GERENTE Y PROFESIONAL DE CONTRATO
		$pos = strpos($id, "--".$sql_con[9]."??");
		if ($pos !== false) {//si exixte el id
		}else{
			$id.="--".$sql_con[9]."??";
		}
	}
	$un_mes =strtotime ( '+1 day' , strtotime ($un_mes) );
		$un_mes=date('Y-m-d', $un_mes);
	//echo "select * FROM t7_contratos_contrato where vigencia_mes between '$un_mes' and '$dos_meses'<br>";
	$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$un_mes' and '$dos_meses'");
	while($sql_con = traer_fila_db($query)){//PARA BUSCAR LOS ID DE GERENTE Y PROFESIONAL DE CONTRATO
		$pos = strpos($id, "--".$sql_con[9]."??");
		if ($pos !== false) {//si exixte el id
		}else{
			$id.="--".$sql_con[9]."??";
		}
	}
	$dos_meses = strtotime ( '+1 day' , strtotime ($dos_meses) );
		$dos_meses=date('Y-m-d',$dos_meses);
	//echo "select * FROM t7_contratos_contrato where vigencia_mes between '$dos_meses' and '$tres_meses'<br>";
	$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$dos_meses' and '$tres_meses'");
	while($sql_con = traer_fila_db($query)){//PARA BUSCAR LOS ID DE GERENTE Y PROFESIONAL DE CONTRATO
		$pos = strpos($id, "--".$sql_con[9]."??");
		if ($pos !== false) {//si exixte el id
		}else{
			$id.="--".$sql_con[9]."??";
		}
	}
	$tres_meses = strtotime ( '+1 day' , strtotime ($tres_meses) );
		$tres_meses=date('Y-m-d',$tres_meses);
	//echo "select * FROM t7_contratos_contrato where vigencia_mes between '$tres_meses' and '$cuatro_meses'<br>";
	$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$tres_meses' and '$cuatro_meses'");
	while($sql_con = traer_fila_db($query)){//PARA BUSCAR LOS ID DE GERENTE Y PROFESIONAL DE CONTRATO
		$pos = strpos($id, "--".$sql_con[9]."??");
		if ($pos !== false) {//si exixte el id
		}else{
			$id.="--".$sql_con[9]."??";
		}
	}
	$destino=explode('??',	$id);
	$nombre_gerente="";
	$envia=0;
	$total_tablas="";
foreach ($destino as $v) {//PARA BUSCAR TODOS LOS CONTRATOS RELACIONADOS A UN USUARIO
	if($v!="" and $v!='--0'){
		$footer="<br><font font-size='10' face='arial'>Si el servicio / suministro requiere continuidad por favor ingrese al SGPA, solicite un otros&iacute; a contrato puntual o ampliaci&oacute;n a contrato marco, el sistema remitir&aacute; su solicitud al Profesional / Comprador de abastecimiento encargado, recuerde que los tiempos promedio para gestionar una ampliaci&oacute;n a contrato marco u otros&iacute; es de <strong>25 d&iacute;as h&aacute;biles</strong>.<br><br>Recuerde que su aporte es importante en la planeaci&oacute;n para dar cumplimiento a los tiempos del proceso.<br><br><br><strong><-profesional-></strong><br><strong><-firma-></strong></font>";
		//busca_contratos($v);
		$nombres_en_footer="";
		$correos_envia="";
		$mensaje_envio1="";
		$mensaje_envio2="";
		$mensaje_envio3="";
		$mensaje_envio4="";
		$completa_tabla="";
		$muestra_rol="";		
		$id_especialista = 0;
		$fin_tabla='</table></td></tr></table>';
		$v=str_replace('--', '', $v);
		$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $v";
		$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
		$nombre= $sql_sel_usuario[0];
		$email= $sql_sel_usuario[1];
		$nombre_en_tabla='<font font-size="10" face="arial">Buen d&iacute;a <br><br> Se&ntilde;or(a): <strong>'.$nombre.'</strong>, a continuaci&oacute;n el informe de los contratos que se encuentran pr&oacute;ximos a vencer.</font><br><br>';
		//echo "select * FROM t7_contratos_contrato where vigencia_mes like '%$busca_mes%' and (gerente=$v) order by vigencia_mes<br>";
		/*******PARA LOS CONTRATS QUE VENCEN EN UN MES **********/
		$cuenta1=traer_fila_row(query_db("select count(*) FROM t7_contratos_contrato where vigencia_mes between '$fecha_actual' and '$un_mes' and (gerente=$v)"));
		if($cuenta1[0]!=0){
		$cont=0;
		$inicio_tabla1='<table width="100%" align="Center">
	<tr style="background: transparent;">
		<td align="left" style="background: transparent; font-family: arial; font-size: 14pt; color: #F45F53;"><strong>Contratos que vencer&aacute;n en 30 d&iacute;as</strong></td>
	</tr>
	<tr>
		<td style="border: 25px solid #F78A82;">
		<table align="center" cellspacing="0" border="1" bordercolor="black" style="border:10px; solid #F78A82;  border-collapse:collapse; background: #F78A82;">
			<tr style="background: transparent;">
				<td width="15%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Contrato</strong></td>
				<td width="18%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Proveedor</strong></td>
				<td width="25%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Objeto</strong></td>
				<td width="10%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Tipo de Contrato</strong></td>
				<td width="10%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Fecha Fin</strong></td>
				<td width="11%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Encargado en Abastecimiento</strong></td>
				<td width="11%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Gerente de Contrato</strong></td>
			</tr>';
		$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$fecha_actual' and '$un_mes' and (gerente=$v) order by vigencia_mes");
		$prefacio='<br> Los contratos relacionados a Continuaci&oacute;n vencer&aacute;n en <strong>30</strong> d&iacute;as</p>';		
		$cuerpo_tabla1='';
		while($sql_con = traer_fila_db($query)){
			if($cont==0){
				$clase="background: #F2F2F2;";
				$cont=1;
			}else{
				$clase="background: #FFF;";
				$cont=0;
			}
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sql_con[9]";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_generete = $sql_sel_usuario[0];
			$email_generete = $sql_sel_usuario[1];
			$pos = strpos($correos_envia, $email_generete.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$correos_envia.=$email_generete.">?";
			}
			//*FER Seleccion de profesional-comprador para nombre y rol correo informe 30 dias
			$id_especialista.= ",".$sql_con[16];
			/*
			$sql_sel_rol1=traer_fila_row(query_db("select t1.nombre_administrador, t1.email, t3.nombre from t1_us_usuarios as t1, tseg12_relacion_usuario_rol as t2, tseg11_roles_general as t3 where t3.id_rol=t2.id_rol_general and t2.id_usuario=t1.us_id and id_rol_general =13 and t1.us_id = ".$sql_con[16]));

			
			$pos = strpos($muestra_rol, $sql_sel_rol1[2].">?");
			if ($pos !== false) {//si exixte el id
			}else{
				if($muestra_rol!=""){
					$muestra_rol.=$sql_sel_rol1[2].">?";
				}else{
					$muestra_rol.=$sql_sel_rol1[2];
				}
			}
			$sql_sel_rol2=traer_fila_row(query_db("select t1.nombre_administrador, t1.email, t3.nombre from t1_us_usuarios as t1, tseg12_relacion_usuario_rol as t2, tseg11_roles_general as t3 where t3.id_rol=t2.id_rol_general and t2.id_usuario=t1.us_id and id_rol_general =17 and t1.us_id =".$sql_con[16]));
			
			$pos = strpos($muestra_rol, $sql_sel_rol2[2].">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				if($muestra_rol!=""){
					$muestra_rol.=$sql_sel_rol2[2].">?";
				}else{
					$muestra_rol.=$sql_sel_rol2[2];
				}
			}
			*/
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sql_con[16]";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_gestor = $sql_sel_usuario[0];
			$email_gestor = $sql_sel_usuario[1];
			$pos = strpos($correos_envia, $email_gestor.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$correos_envia.=$email_gestor.">?";
			}
			
			/*$pos = strpos($nombres_en_footer, $nombre_gestor.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$nombres_en_footer.=$nombre_gestor.">?";
			}*/
			
			/* ---------------------------------------------- BUSCA EL JEFE DE AREA ---------------------------- */
			$id_jefe_area = busca_jefe_area_contrato_id_contrato_mc($sql_con[0]); // la funcion esta en funciones_general_2015
			/* ---------------------------------------------- FIN BUSCA EL JEFE DE AREA ---------------------------- */
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $id_jefe_area";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_jefe = $sql_sel_usuario[0];
			$email_jefe = $sql_sel_usuario[1];
			$pos = strpos($correos_envia, $email_jefe.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$correos_envia.=$email_jefe.">?";
			}
			//echo $id_jefe_area."-jefe<br>"; 19 10
			$numero_contrato1 = "C";
			$separa_fecha_crea = explode("-",$sql_con[19]);
			$ano_contra = $separa_fecha_crea[0];
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $sql_con[2];
			$numero_contrato4 = $sql_con[43];
			$numero=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sql_con[0]);
			$inicia=$sql_con[10];
			$finaliza=$sql_con[11];
			if($sql_con[34]==1){
				if($sql_con[59]==1){
					$tipo_contrato="ACEPTACION DE OFERTA MERCANTIL";
				}else{
					$tipo_contrato="CONTRATO PUNTUAL";
				}
			}else{
				$tipo_contrato="CONTRATO MARCO";
			}
			$item_contrato=traer_fila_row(query_db("SELECT COUNT(*) FROM $pi2 WHERE contrato_id=$sql_con[0] AND estado NOT IN(32, 31, 33)"));
			$otrosi="N/A";
			if($item_contrato[0]!=0){
				$item_contrato=traer_fila_row(query_db("SELECT num1, num2, num3 FROM $pi2 WHERE contrato_id=$sql_con[0] AND estado NOT IN(32, 31, 33)"));
				$otrosi=numero_item_pecc($item_contrato[0],$item_contrato[1],$item_contrato[2]);
			}
			if($sql_con[34]==2){/*
				$sel=query_db("select distinct gerente from t7_contratos_complemento where id_contrato=$sql_con[0]");
				$correos_ot="";
				$nombres_ot="";
				while($sel_ot = traer_fila_db($sel)){
					$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sel_ot[0]";
					$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
					$nombres_ot.=$sql_sel_usuario[0]."gerente_ot,<br>";
					$correos_ot.=$sql_sel_usuario[1]."gerente_ot,,<br>";
				}*/
				//echo "contrato marco";
			}
			$objeto=traer_fila_row(query_db("select cast(objeto as varchar(max)) from $co1 where id=$sql_con[0]"));
			$sel_pro = "select razon_social from ".$g6." where t1_proveedor_id=".$sql_con[5];
			$sel_pro_q=traer_fila_row(query_db($sel_pro));
			//$otrosi='<td align="center" style="font-family: arial; font-size: 10pt; border: 2px solid #FFF; overflow: hidden;">'.$otrosi.'</td>';
			$cuerpo_tabla1.='<tr style="background: transparent;">
				<td width="15%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$numero.'</td>
				<td width="18%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$sel_pro_q[0].'</td>
				<td width="25%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$objeto[0].'</td>
				<td width="10%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$tipo_contrato.'</td>
				<td width="10%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; color: #F45F53;">'.$finaliza.'</td>
				<td width="11%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$nombre_gestor.'</td>
				<td width="11%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$nombre_generete.'</td>
			</tr>';
		}
			
			$completa_tabla.= $inicio_tabla1.$cuerpo_tabla1.$fin_tabla;
		}
		/*******PARA LOS CONTRATS QUE VENCEN EN DOS MESES **********/
		$cuenta1=traer_fila_row(query_db("select count(*) FROM t7_contratos_contrato where vigencia_mes between '$un_mes' and '$dos_meses' and (gerente=$v)"));
		if($cuenta1[0]!=0){
		$inicio_tabla2='<table  width="100%" align="center">
	<tr style="background: transparent;">
		<td align="left" style="background: transparent; font-family: arial; font-size: 14pt; color: #E9DC67;"><strong>Contratos que vencer&aacute;n en menos de 2 meses</strong></td>
	</tr>
	<tr>
		<td style="border: 25px solid #FBEE78;">
		<table align="center" cellspacing="0" border="1" bordercolor="black" style="border:10px; solid #FBEE78; border-collapse:collapse; background: #FBEE78;">
			<tr style="background: transparent;">
				<td width="15%" align="center" style="background: #E9DC67; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Contrato</strong></td>
				<td width="18%" align="center" style="background: #E9DC67; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Proveedor</strong></td>
				<td width="25%" align="center" style="background: #E9DC67; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Objeto</strong></td>
				<td width="10%" align="center" style="background: #E9DC67; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Tipo de Contrato</strong></td>
				<td width="10%" align="center" style="background: #E9DC67; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Fecha Fin</strong></td>
				<td width="11%" align="center" style="background: #E9DC67; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Encargado en Abastecimiento</strong></td>
				<td width="11%" align="center" style="background: #E9DC67; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Gerente de Contrato</strong></td>
			</tr>';
		$cuerpo_tabla2='';
		$cont=0;
		$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$un_mes' and '$dos_meses' and (gerente=$v) order by vigencia_mes");
		$prefacio='<br> Los contratos relacionados a Continuaci&oacute;n vencer&aacute;n en <strong>2</strong> mes(es)</p>';
		while($sql_con = traer_fila_db($query)){
			if($cont==0){
				$clase="background: #F2F2F2;";
				$cont=1;
			}else{
				$clase="background: #FFF;";
				$cont=0;
			}
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sql_con[9]";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_generete = $sql_sel_usuario[0];
			$email_generete = $sql_sel_usuario[1];
			$pos = strpos($correos_envia, $email_generete.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$correos_envia.=$email_generete.">?";
			}
			//*FER Seleccion de profesional-comprador para nombre y rol correo informe 2 meses			
			$id_especialista.= ",".$sql_con[16];
			/*
			$sql_sel_rol1=traer_fila_row(query_db("select t1.nombre_administrador, t1.email, t3.nombre from t1_us_usuarios as t1, tseg12_relacion_usuario_rol as t2, tseg11_roles_general as t3 where t3.id_rol=t2.id_rol_general and t2.id_usuario=t1.us_id and id_rol_general =13 and t1.us_id = ".$sql_con[16]));

			$pos = strpos($muestra_rol, $sql_sel_rol1[2].">?");
			if ($pos !== false) {//si exixte el id
			}else{
				if($muestra_rol!=""){
					$muestra_rol.=$sql_sel_rol1[2].">?";
				}else{
					$muestra_rol.=$sql_sel_rol1[2];
				}
			}
			$sql_sel_rol2=traer_fila_row(query_db("select t1.nombre_administrador, t1.email, t3.nombre from t1_us_usuarios as t1, tseg12_relacion_usuario_rol as t2, tseg11_roles_general as t3 where t3.id_rol=t2.id_rol_general and t2.id_usuario=t1.us_id and id_rol_general =17 and t1.us_id =".$sql_con[16]));
			$pos = strpos($muestra_rol, $sql_sel_rol2[2].">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				if($muestra_rol!=""){
					$muestra_rol.=$sql_sel_rol2[2].">?";
				}else{
					$muestra_rol.=$sql_sel_rol2[2];
				}
			}
			*/
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sql_con[16]";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_gestor = $sql_sel_usuario[0];
			$email_gestor = $sql_sel_usuario[1];
			$pos = strpos($correos_envia, $email_gestor.">?");
			if ($pos !== false) {//si exixte el id
			}else{
				$correos_envia.=$email_gestor.">?";
			}
			/*
			$pos = strpos($nombres_en_footer, $nombre_gestor.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$nombres_en_footer.=$nombre_gestor.">?";
			}
			*/
			/* ---------------------------------------------- BUSCA EL JEFE DE AREA ---------------------------- */
			$id_jefe_area = busca_jefe_area_contrato_id_contrato_mc($sql_con[0]); // la funcion esta en funciones_general_2015
			/* ---------------------------------------------- FIN BUSCA EL JEFE DE AREA ---------------------------- */
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $id_jefe_area";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_jefe = $sql_sel_usuario[0];
			$email_jefe = $sql_sel_usuario[1];
			$pos = strpos($correos_envia, $email_jefe.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$correos_envia.=$email_jefe.">?";
			}
			//echo $id_jefe_area."-jefe<br>"; 19 10
			$numero_contrato1 = "C";
			$separa_fecha_crea = explode("-",$sql_con[19]);
			$ano_contra = $separa_fecha_crea[0];
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $sql_con[2];
			$numero_contrato4 = $sql_con[43];
			$numero=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sql_con[0]);
			$inicia=$sql_con[10];
			$finaliza=$sql_con[11];
			if($sql_con[34]==1){
				if($sql_con[57]==1){
					$tipo_contrato="ACEPTACION DE OFERTA MERCANTIL";
				}else{
					$tipo_contrato="CONTRATO PUNTUAL";
				}
			}else{
				$tipo_contrato="CONTRATO MARCO";
			}
			$item_contrato=traer_fila_row(query_db("SELECT COUNT(*) FROM $pi2 WHERE contrato_id=$sql_con[0] AND estado NOT IN(32, 31, 33)"));
			$otrosi="N/A";
			if($item_contrato[0]!=0){
				$item_contrato=traer_fila_row(query_db("SELECT num1, num2, num3 FROM $pi2 WHERE contrato_id=$sql_con[0] AND estado NOT IN(32, 31, 33)"));
				$otrosi=numero_item_pecc($item_contrato[0],$item_contrato[1],$item_contrato[2]);
			}
			$objeto=traer_fila_row(query_db("select cast(objeto as varchar(max)) from $co1 where id=$sql_con[0]"));
			$sel_pro = "select razon_social from ".$g6." where t1_proveedor_id=".$sql_con[5];
			$sel_pro_q=traer_fila_row(query_db($sel_pro));
			//$otrosi='<td align="center" style="font-family: arial; font-size: 10pt; border: 2px solid #FFF; overflow: hidden;">'.$otrosi.'</td>';
			$cuerpo_tabla2.='<tr style="background: transparent;">
				<td width="15%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$numero.'</td>
				<td width="18%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$sel_pro_q[0].'</td>
				<td width="25%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$objeto[0].'</td>
				<td width="10%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$tipo_contrato.'</td>
				<td width="10%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; color: #E9DC67;">'.$finaliza.'</td>
				<td width="11%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$nombre_gestor.'</td>
				<td width="11%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$nombre_generete.'</td>
			</tr>';
		}
			$completa_tabla.= $inicio_tabla2.$cuerpo_tabla2.$fin_tabla;
		}
		

		/*******PARA LOS CONTRATS QUE VENCEN EN TRES MESES **********/
		$cuenta1=traer_fila_row(query_db("select count(*) FROM t7_contratos_contrato where vigencia_mes between '$dos_meses' and '$tres_meses' and (gerente=$v)"));
		if($cuenta1[0]!=0){
		$inicio_tabla3='<table  width="100%" align="center">
	<tr style="background: transparent;">
		<td align="left" style="background: transparent; font-family: arial; font-size: 14pt; color: #78C57C;"><strong>Contratos que vencer&aacute;n en menos de 3 meses</strong></td>
	</tr>
	<tr>
		<td style="border: 25px solid #6AC46F;">
		<table align="center" cellspacing="0" border="1" bordercolor="black" style="border:10px; solid #6AC46F; border-collapse:collapse; background: #6AC46F;">
			<tr style="background: transparent;">
				<td width="15%" align="center" style="background: #78C57C; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Contrato</strong></td>
				<td width="18%" align="center" style="background: #78C57C; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Proveedor</strong></td>
				<td width="25%" align="center" style="background: #78C57C; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Objeto</strong></td>
				<td width="10%" align="center" style="background: #78C57C; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Tipo de Contrato</strong></td>
				<td width="10%" align="center" style="background: #78C57C; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Fecha Fin</strong></td>
				<td width="11%" align="center" style="background: #78C57C; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Encargado en Abastecimiento</strong></td>
				<td width="11%" align="center" style="background: #78C57C; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Gerente de Contrato</strong></td>
			</tr>';
		$cuerpo_tabla3='';
		$cont=0;
		$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$dos_meses' and '$tres_meses' and (gerente=$v) order by vigencia_mes");
		$prefacio='<br> Los contratos relacionados a Continuaci&oacute;n vencer&aacute;n en <strong>3</strong> mes(es)</p>';
		while($sql_con = traer_fila_db($query)){
			if($cont==0){
				$clase="background: #F2F2F2;";
				$cont=1;
			}else{
				$clase="background: #FFF;";
				$cont=0;
			}
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sql_con[9]";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_generete = $sql_sel_usuario[0];
			$email_generete = $sql_sel_usuario[1];
			$pos = strpos($correos_envia, $email_generete.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$correos_envia.=$email_generete.">?";
			}
			//*FER Seleccion de profesional-comprador para nombre y rol correo informe 3 meses			
			$id_especialista.= ",".$sql_con[16];
			
			/*$sql_sel_rol1=traer_fila_row(query_db("select t1.nombre_administrador, t1.email, t3.nombre from t1_us_usuarios as t1, tseg12_relacion_usuario_rol as t2, tseg11_roles_general as t3 where t3.id_rol=t2.id_rol_general and t2.id_usuario=t1.us_id and id_rol_general =13 and t1.us_id = ".$sql_con[16]));

			$pos = strpos($muestra_rol, $sql_sel_rol1[2].">?");
			if ($pos !== false) {//si exixte el id
			}else{
				if($muestra_rol!=""){
					$muestra_rol.=$sql_sel_rol1[2].">?";
				}else{
					$muestra_rol.=$sql_sel_rol1[2];
				}
			}
			$sql_sel_rol2=traer_fila_row(query_db("select t1.nombre_administrador, t1.email, t3.nombre from t1_us_usuarios as t1, tseg12_relacion_usuario_rol as t2, tseg11_roles_general as t3 where t3.id_rol=t2.id_rol_general and t2.id_usuario=t1.us_id and id_rol_general =17 and t1.us_id =".$sql_con[16]));
			$pos = strpos($muestra_rol, $sql_sel_rol2[2].">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				if($muestra_rol!=""){
					$muestra_rol.=$sql_sel_rol2[2].">?";
				}else{
					$muestra_rol.=$sql_sel_rol2[2];
				}
			}
			*/
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sql_con[16]";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_gestor = $sql_sel_usuario[0];
			$email_gestor = $sql_sel_usuario[1];
			$pos = strpos($correos_envia, $email_gestor.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$correos_envia.=$email_gestor.">?";
			}
			/*
			$pos = strpos($nombres_en_footer, $nombre_gestor.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$nombres_en_footer.=$nombre_gestor.">?";
			}
			*/
			/* ---------------------------------------------- BUSCA EL JEFE DE AREA ---------------------------- */
			$id_jefe_area = busca_jefe_area_contrato_id_contrato_mc($sql_con[0]); // la funcion esta en funciones_general_2015
			/* ---------------------------------------------- FIN BUSCA EL JEFE DE AREA ---------------------------- */
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $id_jefe_area";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_jefe = $sql_sel_usuario[0];
			$email_jefe = $sql_sel_usuario[1];
			/*$pos = strpos($correos_envia, $email_jefe.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$correos_envia.=$email_jefe.">?";
			}*/
			//echo $id_jefe_area."-jefe<br>"; 19 10
			$numero_contrato1 = "C";
			$separa_fecha_crea = explode("-",$sql_con[19]);
			$ano_contra = $separa_fecha_crea[0];
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $sql_con[2];
			$numero_contrato4 = $sql_con[43];
			$numero=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sql_con[0]);
			$inicia=$sql_con[10];
			$finaliza=$sql_con[11];
			if($sql_con[34]==1){
				if($sql_con[57]==1){
					$tipo_contrato="ACEPTACION DE OFERTA MERCANTIL";
				}else{
					$tipo_contrato="CONTRATO PUNTUAL";
				}
			}else{
				$tipo_contrato="CONTRATO MARCO";
			}
			$item_contrato=traer_fila_row(query_db("SELECT COUNT(*) FROM $pi2 WHERE contrato_id=$sql_con[0] AND estado NOT IN(32, 31, 33)"));
			$otrosi="N/A";
			if($item_contrato[0]!=0){
				$item_contrato=traer_fila_row(query_db("SELECT num1, num2, num3 FROM $pi2 WHERE contrato_id=$sql_con[0] AND estado NOT IN(32, 31, 33)"));
				$otrosi=numero_item_pecc($item_contrato[0],$item_contrato[1],$item_contrato[2]);
			}
			$objeto=traer_fila_row(query_db("select cast(objeto as varchar(max)) from $co1 where id=$sql_con[0]"));
			$sel_pro = "select razon_social from ".$g6." where t1_proveedor_id=".$sql_con[5];
			$sel_pro_q=traer_fila_row(query_db($sel_pro));
			$cuerpo_tabla3.='<tr style="background: transparent;">
				<td width="15%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$numero.'</td>
				<td width="18%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$sel_pro_q[0].'</td>
				<td width="25%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$objeto[0].'</td>
				<td width="10%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$tipo_contrato.'</td>
				<td width="10%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; color: #78C57C;">'.$finaliza.'</td>
				<td width="11%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$nombre_gestor.'</td>
				<td width="11%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$nombre_generete.'</td>
			</tr>';
		}
			$completa_tabla.= $inicio_tabla3.$cuerpo_tabla3.$fin_tabla;
		}

		/*******PARA LOS CONTRATS QUE VENCEN EN CUATRO MESES **********/
		$cuenta1=traer_fila_row(query_db("select count(*) FROM t7_contratos_contrato where vigencia_mes between '$tres_meses' and '$cuatro_meses' and (gerente=$v)"));
		if($cuenta1[0]!=0){
		$inicio_tabla4='<table width="100%" align="center">
	<tr style="background: transparent;">
		<td align="left" style="background: transparent; font-family: arial; font-size: 14pt; color: #78C57C;"><strong>Contratos que vencer&aacute;n en menos de 4 meses</strong></td>
	</tr>
	<tr>
		<td style="border: 25px solid #6AC46F;">
		<table align="center" cellspacing="0" border="1" bordercolor="black" style="border:10px; solid #6AC46F; border-collapse:collapse; background: #6AC46F;">
			<tr style="background: transparent;">
				<td width="15%" align="center" style="background: #78C57C; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Contrato</strong></td>
				<td width="18%" align="center" style="background: #78C57C; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Proveedor</strong></td>
				<td width="25%" align="center" style="background: #78C57C; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Objeto</strong></td>
				<td width="10%" align="center" style="background: #78C57C; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Tipo de Contrato</strong></td>
				<td width="10%" align="center" style="background: #78C57C; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Fecha Fin</strong></td>
				<td width="11%" align="center" style="background: #78C57C; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Encargado en Abastecimiento</strong></td>
				<td width="11%" align="center" style="background: #78C57C; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Gerente de Contrato</strong></td>
			</tr>';
		$cuerpo_tabla4='';
		$cont=0;
		$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$tres_meses' and '$cuatro_meses' and (gerente=$v) order by vigencia_mes");
		$prefacio='<br> Los contratos relacionados a Continuaci&oacute;n vencer&aacute;n en <strong>4</strong> mes(es)</p>';
		while($sql_con = traer_fila_db($query)){
			if($cont==0){
				$clase="background: #F2F2F2;";
				$cont=1;
			}else{
				$clase="background: #FFF;";
				$cont=0;
			}
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sql_con[9]";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_generete = $sql_sel_usuario[0];
			$email_generete = $sql_sel_usuario[1];
			$pos = strpos($correos_envia, $email_generete.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$correos_envia.=$email_generete.">?";
			}
			//*FER Seleccion de profesional-comprador para nombre y rol correo informe 4 meses			
			$id_especialista.= ",".$sql_con[16];
			/*
			$sql_sel_rol1=traer_fila_row(query_db("select t1.nombre_administrador, t1.email, t3.nombre from t1_us_usuarios as t1, tseg12_relacion_usuario_rol as t2, tseg11_roles_general as t3 where t3.id_rol=t2.id_rol_general and t2.id_usuario=t1.us_id and id_rol_general =13 and t1.us_id = ".$sql_con[16]));

			$pos = strpos($muestra_rol, $sql_sel_rol1[2].">?");
			if ($pos !== false) {//si exixte el id
			}else{
				if($muestra_rol!=""){
					$muestra_rol.=$sql_sel_rol1[2].">?";
				}else{
					$muestra_rol.=$sql_sel_rol1[2];
				}
			}
			$sql_sel_rol2=traer_fila_row(query_db("select t1.nombre_administrador, t1.email, t3.nombre from t1_us_usuarios as t1, tseg12_relacion_usuario_rol as t2, tseg11_roles_general as t3 where t3.id_rol=t2.id_rol_general and t2.id_usuario=t1.us_id and id_rol_general =17 and t1.us_id =".$sql_con[16]));
			$pos = strpos($muestra_rol, $sql_sel_rol2[2].">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				if($muestra_rol!=""){
					$muestra_rol.=$sql_sel_rol2[2].">?";
				}else{
					$muestra_rol.=$sql_sel_rol2[2];
				}
			}
			*/
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sql_con[16]";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_gestor = $sql_sel_usuario[0];
			$email_gestor = $sql_sel_usuario[1];
			$pos = strpos($correos_envia, $email_gestor.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$correos_envia.=$email_gestor.">?";
			}
			/*
			$pos = strpos($nombres_en_footer, $nombre_gestor.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$nombres_en_footer.=$nombre_gestor.">?";
			}*/
			
			
			/* ---------------------------------------------- BUSCA EL JEFE DE AREA ---------------------------- */
			$id_jefe_area = busca_jefe_area_contrato_id_contrato_mc($sql_con[0]); // la funcion esta en funciones_general_2015
			/* ---------------------------------------------- FIN BUSCA EL JEFE DE AREA ---------------------------- */
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $id_jefe_area";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_jefe = $sql_sel_usuario[0];
			$email_jefe = $sql_sel_usuario[1];
			/*$pos = strpos($correos_envia, $email_jefe.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$correos_envia.=$email_jefe.">?";
			}*/
			//echo $id_jefe_area."-jefe<br>"; 19 10
			$numero_contrato1 = "C";
			$separa_fecha_crea = explode("-",$sql_con[19]);
			$ano_contra = $separa_fecha_crea[0];
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $sql_con[2];
			$numero_contrato4 = $sql_con[43];
			$numero=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sql_con[0]);
			$inicia=$sql_con[10];
			$finaliza=$sql_con[11];
			if($sql_con[34]==1){
				if($sql_con[57]==1){
					$tipo_contrato="ACEPTACION DE OFERTA MERCANTIL";
				}else{
					$tipo_contrato="CONTRATO PUNTUAL";
				}
			}else{
				$tipo_contrato="CONTRATO MARCO";
			}
			$item_contrato=traer_fila_row(query_db("SELECT COUNT(*) FROM $pi2 WHERE contrato_id=$sql_con[0] AND estado NOT IN(32, 31, 33)"));
			$otrosi="N/A";
			if($item_contrato[0]!=0){
				$item_contrato=traer_fila_row(query_db("SELECT num1, num2, num3 FROM $pi2 WHERE contrato_id=$sql_con[0] AND estado NOT IN(32, 31, 33)"));
				$otrosi=numero_item_pecc($item_contrato[0],$item_contrato[1],$item_contrato[2]);
			}
			$objeto=traer_fila_row(query_db("select cast(objeto as varchar(max)) from $co1 where id=$sql_con[0]"));
			$sel_pro = "select razon_social from ".$g6." where t1_proveedor_id=".$sql_con[5];
			$sel_pro_q=traer_fila_row(query_db($sel_pro));
			$cuerpo_tabla4.='<tr style="background: transparent;">
				<td width="15%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$numero.'</td>
				<td width="18%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$sel_pro_q[0].'</td>
				<td width="25%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$objeto[0].'</td>
				<td width="10%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$tipo_contrato.'</td>
				<td width="10%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; color: #78C57C;">'.$finaliza.'</td>
				<td width="11%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$nombre_gestor.'</td>
				<td width="11%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$nombre_generete.'</td>
			</tr>';
		}
			$completa_tabla.= $inicio_tabla4.$cuerpo_tabla4.$fin_tabla;
		}
		/*if($mensaje_envio1!=""){
			echo "entro 1";
			$completa_tabla=$completa_tabla.$mensaje_envio1;
		}elseif($mensaje_envio2!=""){
			echo "entro 2";
			$completa_tabla=$completa_tabla.$mensaje_envio2;
		}elseif($mensaje_envio3!=""){
			echo "entro 3";
			$completa_tabla=$completa_tabla.$mensaje_envio3;
		}elseif($mensaje_envio4!=""){
			echo "entro 4";
			$completa_tabla=$completa_tabla.$mensaje_envio4;
		}*/
		/*-------------seleccion de nombre y rol para la firma del email --------------------*/
			

			$sql_sel_rol1=query_db("select t1.nombre_administrador, t1.email, t3.nombre from t1_us_usuarios as t1, tseg12_relacion_usuario_rol as t2, tseg11_roles_general as t3 where t3.id_rol=t2.id_rol_general and t2.id_usuario=t1.us_id and id_rol_general in (13, 17) and t1.us_id in (".$id_especialista.") order by id_rol_general");
			$con_sla = 0;
			$nombres_en_footer = "";
			$muestra_rol = "";
			while($sel_rol_nombre_prof = traer_fila_db($sql_sel_rol1)){
				if($con_sla == 0){
					$con_sla = $con_sla +1;//con este ya no entra mas a este if 
					$nombres_en_footer = $sel_rol_nombre_prof[0];
					$muestra_rol = $sel_rol_nombre_prof[2];
					}else{
						$nombres_en_footer.= " / ".$sel_rol_nombre_prof[0];
						$muestra_rol.= " / ".$sel_rol_nombre_prof[2];
						}
				}
			/*-------------seleccion de nombre y rol para la firma del email --------------------*/
		if($completa_tabla!=""){
			$nombres_en_footer=str_replace('>?', ' / ', $nombres_en_footer);
			$footer=str_replace('<-profesional->', $nombres_en_footer, $footer);
			$muestra_rol=str_replace('>?', " / ", $muestra_rol);
			$footer=str_replace('<-firma->', $muestra_rol, $footer);
			$correos_envia=str_replace('>?', ',,', $correos_envia);
			$nombre_en_tabla.=$completa_tabla.$footer;
			echo $nombre_en_tabla." --- correos:  ".$correos_envia."<br><br><br>-----------------------<br><br><br>";
			//echo $nombre_en_tabla;
			//if($si_es_1[2]==01 or $si_es_15[2]==15){//SE ENVÍA EL EMAIL SI ES EL PRIMERO O 15 DE CADA MES
				sent_mail_with_signature($correos_envia,'INFORME DE VENCIMIENTO DE CONTRATOS',$nombre_en_tabla, $email_gestor, $nombre_gestor);
			//}
		}
	}
		//echo $mensaje_envio=$nombre_en_tabla.$mensaje_envio1.$mensaje_envio2.$mensaje_envio3.$mensaje_envio4;
		//$total_tablas.=$nombre_en_tabla."<br><br>";
		
}


include('../../librerias/php/alertas_contratos_llena_push.php');
	//busca_contratos($id_usuario);
	//error_reporting(E_ALL);  // L&iacute;neas para mostart errores
	//ini_set('display_errors', '2');  // L&iacute;neas para mostart errores
	$tabla='';
	$fecha_actual= date('Y-m-d');
	$si_es_1=explode("-",$fecha_actual);
	$si_es_15=explode("-",$fecha_actual);
	//$dia_1= date('Y-m-01', strtotime($fecha_actual));
	$un_mes =strtotime ( '+1 month' , strtotime ($fecha_actual) );
	$un_mes=date('Y-m-d', $un_mes);
	$dias_15 = strtotime ( '+15 days' , strtotime ($fecha_actual) );
	$dias_15=date('Y-m-d',$dias_15);
	$tres_meses = strtotime ( '+3 month' , strtotime ($fecha_actual) );
	$tres_meses=date('Y-m-d',$tres_meses);
	$cuatro_meses = strtotime ( '+4 month' , strtotime ($fecha_actual) );
	$cuatro_meses=date('Y-m-d',$cuatro_meses);
	$dia_2= date('Y-m-t', strtotime($fecha_actual));
	$id_gerente="";
	$id_profesional="";
	$id="";
	$correos_mes1="";
	$correos_mes2="";
	$correos_mes3="";
	$correos_mes4="";
	
	$mes=1;
//function busca_contratos($busca_mes, $mes){//INICIO FUNCION
	$id="";
	//global $co1, $g6, $g1, $pi2;
	//echo "select * FROM t7_contratos_contrato where vigencia_mes='$un_mes'<br>";
	$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes='$un_mes'");
	while($sql_con = traer_fila_db($query)){//PARA BUSCAR LOS ID DE GERENTE Y PROFESIONAL DE CONTRATO
		$pos = strpos($id, "--".$sql_con[9]."??");
		if ($pos !== false) {//si exixte el id
		}else{
			$id.="--".$sql_con[9]."??";
		}
	}
	//echo "select * FROM t7_contratos_contrato where vigencia_mes='$dias_15'<br>";
	$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$fecha_actual' and '$dias_15'");
	while($sql_con = traer_fila_db($query)){//PARA BUSCAR LOS ID DE GERENTE Y PROFESIONAL DE CONTRATO
		$pos = strpos($id, "--".$sql_con[9]."??");
		if ($pos !== false) {//si exixte el id
		}else{
			$id.="--".$sql_con[9]."??";
		}
	}
	$destino=explode('??',	$id);
	$nombre_gerente="";
	$envia=0;
	$total_tablas="";
foreach ($destino as $v) {//PARA BUSCAR TODOS LOS CONTRATOS RELACIONADOS A UN USUARIO
	if($v!="" and $v!='--0'){
		$footer="<br><font font-size='10' face='arial'>Si el servicio / suministro requiere continuidad por favor ingrese al SGPA, solicite un otros&iacute; a contrato puntual o ampliaci&oacute;n a contrato marco, el sistema remitir&aacute; su solicitud al Profesional / Comprador de abastecimiento encargado, recuerde que los tiempos promedio para gestionar una ampliaci&oacute;n a contrato marco u otros&iacute; es de <strong>25 d&iacute;as h&aacute;biles</strong>.<br><br>Recuerde que su aporte es importante en la planeaci&oacute;n para dar cumplimiento a los tiempos del proceso.<br><br><br><strong><-profesional-></strong><br><strong><-firma-></strong></font>";
		
		
		$mensaje_envio1="";
		$mensaje_envio2="";
		$mensaje_envio3="";
		$mensaje_envio4="";
		$completa_tabla="";
		$fin_tabla='</table></td></tr></table>';
		$v=str_replace('--', '', $v);
		busca_contratos($v);
		$time2=date('G');
		$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $v";
		$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
		$nombre= $sql_sel_usuario[0];
		$email= $sql_sel_usuario[1];
		//echo "select * FROM t7_contratos_contrato where vigencia_mes like '%$busca_mes%' and (gerente=$v)<br>"; 
		/*******PARA LOS CONTRATS QUE VENCEN 15 DIAS **********/
		$cuenta1=traer_fila_row(query_db("select count(*) FROM t7_contratos_contrato where vigencia_mes between '$fecha_actual' and '$dias_15' and (gerente=$v)"));
		if($cuenta1[0]!=0){
		$cont=0;
		$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$fecha_actual' and '$dias_15' and (gerente=$v)");
		$prefacio='<br> Los contratos relacionados a Continuaci&oacute;n vencer&aacute;n en <strong>15</strong> d&iacute;as</p>';
		while($sql_con = traer_fila_db($query)){
			$query_dias=traer_fila_row(query_db("select dbo.DiasLaborales('".$fecha_actual."', '".$sql_con[11]."')"));
		$faltan_dias="";
		$faltan_dias_aunto="";
		if($query_dias[0]==1){
			$faltan_dias="en".$query_dias[0]." d&iacute;a";
			$faltan_dias_aunto="EN ".$query_dias[0]." DIA";
		}elseif($query_dias[0]==0){
			$faltan_dias=" hoy";
			$faltan_dias_aunto=" HOY";
		}else{
			$faltan_dias="en".$query_dias[0]." d&iacute;as";
			$faltan_dias_aunto="EN ".$query_dias[0]." DIAS";
		}
		$nombre_en_tabla='<font font-size="10" face="arial">Buen d&iacute;a <br><br> Se&ntilde;or(a): <strong>'.$nombre.'</strong>, a continuaci&oacute;n damos informaci&oacute;n del contrato <strong><-mumero_contrato-> </strong>que se encuentra pr&oacute;ximo a vencer.</font><br><br>';
		$nombres_en_footer="";
		$correos_envia="";
		$muestra_rol="";
		$inicio_tabla1='<table width="100%" align="Center">
	<tr style="background: transparent;">
		<td align="left" style="background: transparent; font-family: arial; font-size: 14pt; color: #F45F53;"><strong>Vencimiento de contrato '.$faltan_dias.'</strong></td>
	</tr>
	<tr>
		<td style="border: 25px solid #F78A82;">
		<table align="center" cellspacing="0" border="1" bordercolor="black" style="border:10px; solid #F78A82; border-collapse:collapse; background: #F78A82;">
			<tr style="background: transparent;">
				<td width="15%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Contrato</strong></td>
				<td width="18%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Proveedor</strong></td>
				<td width="25%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Objeto</strong></td>
				<td width="10%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Tipo de Contrato</strong></td>
				<td width="10%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Fecha Fin</strong></td>
				<td width="11%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Encargado en Abastecimiento</strong></td>
				<td width="11%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Gerente de Contrato</strong></td>
			</tr>';
		$cuerpo_tabla1='';
			if($cont==0){
				$clase="background: #F2F2F2;";
				$cont=1;
			}else{
				$clase="background: #FFF;";
				$cont=0;
			}
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sql_con[9]";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_generete = $sql_sel_usuario[0];
			$email_generete = $sql_sel_usuario[1];
			$pos = strpos($correos_envia, $email_generete.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$correos_envia.=$email_generete.">?";
			}
			$sql_sel_rol1=traer_fila_row(query_db("select t1.nombre_administrador, t1.email, t3.nombre from t1_us_usuarios as t1, tseg12_relacion_usuario_rol as t2, tseg11_roles_general as t3 where t3.id_rol=t2.id_rol_general and t2.id_usuario=t1.us_id and id_rol_general =13 and t1.us_id = ".$sql_con[16]));
			
			$pos = strpos($muestra_rol, $sql_sel_rol1[2].">?");
			if ($pos !== false) {//si exixte el id
			}else{
				if($muestra_rol!=""){
					$muestra_rol.=$sql_sel_rol1[2].">?";
				}else{
					$muestra_rol.=$sql_sel_rol1[2];
				}
			}
			$sql_sel_rol2=traer_fila_row(query_db("select t1.nombre_administrador, t1.email, t3.nombre from t1_us_usuarios as t1, tseg12_relacion_usuario_rol as t2, tseg11_roles_general as t3 where t3.id_rol=t2.id_rol_general and t2.id_usuario=t1.us_id and id_rol_general =17 and t1.us_id =".$sql_con[16]));
			$pos = strpos($muestra_rol, $sql_sel_rol2[2].">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				if($muestra_rol!=""){
					$muestra_rol.=$sql_sel_rol2[2].">?";
				}else{
					$muestra_rol.=$sql_sel_rol2[2];
				}
			}
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sql_con[16]";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_gestor = $sql_sel_usuario[0];
			$email_gestor = $sql_sel_usuario[1];
			$pos = strpos($correos_envia, $email_gestor.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$correos_envia.=$email_gestor.">?";
			}
			$pos = strpos($nombres_en_footer, $nombre_gestor.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$nombres_en_footer.=$nombre_gestor.">?";
			}
			/* ---------------------------------------------- BUSCA EL JEFE DE AREA ---------------------------- */
			$id_jefe_area = busca_jefe_area_contrato_id_contrato_mc($sql_con[0]); // la funcion esta en funciones_general_2015
			/* ---------------------------------------------- FIN BUSCA EL JEFE DE AREA ---------------------------- */
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $id_jefe_area";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_jefe = $sql_sel_usuario[0];
			$email_jefe = $sql_sel_usuario[1];
			$pos = strpos($correos_envia, $email_jefe.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$correos_envia.=$email_jefe.">?";
			}
			//echo $id_jefe_area."-jefe<br>"; 19 10
			$numero_contrato1 = "C";
			$separa_fecha_crea = explode("-",$sql_con[19]);
			$ano_contra = $separa_fecha_crea[0];
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $sql_con[2];
			$numero_contrato4 = $sql_con[43];
			$numero=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sql_con[0]);
			$inicia=$sql_con[10];
			$finaliza=$sql_con[11];
			if($sql_con[34]==1){
				if($sql_con[59]==1){
					$tipo_contrato="ACEPTACION DE OFERTA MERCANTIL";
				}else{
					$tipo_contrato="CONTRATO PUNTUAL";
				}
			}else{
				$tipo_contrato="CONTRATO MARCO";
			}
			$item_contrato=traer_fila_row(query_db("SELECT COUNT(*) FROM $pi2 WHERE contrato_id=$sql_con[0] AND estado NOT IN(32, 31, 33)"));
			$otrosi="N/A";
			if($item_contrato[0]!=0){
				$item_contrato=traer_fila_row(query_db("SELECT num1, num2, num3 FROM $pi2 WHERE contrato_id=$sql_con[0] AND estado NOT IN(32, 31, 33)"));
				$otrosi=numero_item_pecc($item_contrato[0],$item_contrato[1],$item_contrato[2]);
			}
			if($sql_con[34]==2){
				$sel=query_db("select distinct gerente from t7_contratos_complemento where id_contrato=$sql_con[0]");
				$correos_ot="";
				$nombres_ot="";
				while($sel_ot = traer_fila_db($sel)){
					$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sel_ot[0]";
					$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
					$nombres_ot.=$sql_sel_usuario[0];
					$correos_ot.=$sql_sel_usuario[1].",,";
				}
				//echo "contrato marco";
			}
			$objeto=traer_fila_row(query_db("select cast(objeto as varchar(max)) from $co1 where id=$sql_con[0]"));
			$sel_pro = "select razon_social from ".$g6." where t1_proveedor_id=".$sql_con[5];
			$sel_pro_q=traer_fila_row(query_db($sel_pro));
			//$otrosi='<td align="center" style="font-family: arial; font-size: 10pt; border: 2px solid #FFF; overflow: hidden;">'.$otrosi.'</td>';
			$cuerpo_tabla1.='<tr style="background: transparent;">
				<td width="15%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$numero.'</td>
				<td width="18%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$sel_pro_q[0].'</td>
				<td width="25%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$objeto[0].'</td>
				<td width="10%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$tipo_contrato.'</td>
				<td width="10%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; color: #F45F53;">'.$finaliza.'</td>
				<td width="11%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$nombre_gestor.'</td>
				<td width="11%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$nombre_generete.'</td>
			</tr>';
			$completa_tabla= $inicio_tabla1.$cuerpo_tabla1.$fin_tabla;
			$nombres_en_footer=str_replace('>?', ' / ', $nombres_en_footer);
			$footer=str_replace('<-profesional->', $nombres_en_footer, $footer);
			$muestra_rol=str_replace('>?', " / ", $muestra_rol);
			$footer=str_replace('<-firma->', $muestra_rol, $footer);
			$correos_envia=str_replace('>?', ',,', $correos_envia);
			$nombre_en_tabla=str_replace('<-mumero_contrato->', $numero, $nombre_en_tabla);
			$pasa_email=$nombre_en_tabla.$completa_tabla.$footer;
			if($time2==8 or $time2==9){
				//sent_mail_with_signature($correos_envia.$correos_ot,'VENCIMIENTO DEL CONTRATO '.$numero.' '.$faltan_dias_aunto,$pasa_email, $email_gestor, $nombre_gestor);
			}
			
		}
			
		}
		/*******PARA LOS CONTRATS QUE VENCEN EN UN MES **********/
		$cuenta1=traer_fila_row(query_db("select count(*) FROM t7_contratos_contrato where vigencia_mes='$un_mes' and (gerente=$v)"));
		if($cuenta1[0]!=0){
		$cont=0;
		$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes='$un_mes' and (gerente=$v)");
		$prefacio='<br> Los contratos relacionados a Continuaci&oacute;n vencer&aacute;n en <strong>30</strong> d&iacute;as</p>';
		while($sql_con = traer_fila_db($query)){
		
		$nombre_en_tabla='<font font-size="10" face="arial">Buen d&iacute;a <br><br> Se&ntilde;or(a): <strong>'.$nombre.'</strong>, a continuaci&oacute;n damos informaci&oacute;n del contrato <strong><-mumero_contrato-> </strong>que se encuentra pr&oacute;ximo a vencer.</font><br><br>';
		$nombres_en_footer="";
		$correos_envia="";
		$muestra_rol="";
		$inicio_tabla1='<table width="100%" align="Center">
	<tr style="background: transparent;">
		<td align="left" style="background: transparent; font-family: arial; font-size: 14pt; color: #F45F53;"><strong>Vencimiento de contrato en 30 d&iacute;as</strong></td>
	</tr>
	<tr>
		<td style="border: 25px solid #F78A82;">
		<table align="center" cellspacing="0" border="1" bordercolor="black" style="border:10px; solid #F78A82; border-collapse:collapse; background: #F78A82;">
			<tr style="background: transparent;">
				<td width="15%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Contrato</strong></td>
				<td width="18%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Proveedor</strong></td>
				<td width="25%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Objeto</strong></td>
				<td width="10%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Tipo de Contrato</strong></td>
				<td width="10%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Fecha Fin</strong></td>
				<td width="11%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Encargado en Abastecimiento</strong></td>
				<td width="11%" align="center" style="background: #F45F53; font-family: arial; font-size: 12pt; color: #FFF; border: 1px solid #FFF; "><strong>Gerente de Contrato</strong></td>
			</tr>';
		$cuerpo_tabla1='';
			if($cont==0){
				$clase="background: #F2F2F2;";
				$cont=1;
			}else{
				$clase="background: #FFF;";
				$cont=0;
			}
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sql_con[9]";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_generete = $sql_sel_usuario[0];
			$email_generete = $sql_sel_usuario[1];
			$pos = strpos($correos_envia, $email_generete.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$correos_envia.=$email_generete.">?";
			}
			$sql_sel_rol1=traer_fila_row(query_db("select t1.nombre_administrador, t1.email, t3.nombre from t1_us_usuarios as t1, tseg12_relacion_usuario_rol as t2, tseg11_roles_general as t3 where t3.id_rol=t2.id_rol_general and t2.id_usuario=t1.us_id and id_rol_general =13 and t1.us_id = ".$sql_con[16]));
			//*FER envio de correo individual de 30, 15, 14, 13, 12, 11,,,,1
			$pos = strpos($muestra_rol, $sql_sel_rol1[2].">?");
			if ($pos !== false) {//si exixte el id
			}else{
				if($muestra_rol!=""){
					$muestra_rol.=$sql_sel_rol1[2].">?";
				}else{
					$muestra_rol.=$sql_sel_rol1[2];
				}
			}
			$sql_sel_rol2=traer_fila_row(query_db("select t1.nombre_administrador, t1.email, t3.nombre from t1_us_usuarios as t1, tseg12_relacion_usuario_rol as t2, tseg11_roles_general as t3 where t3.id_rol=t2.id_rol_general and t2.id_usuario=t1.us_id and id_rol_general =17 and t1.us_id =".$sql_con[16]));
			$pos = strpos($muestra_rol, $sql_sel_rol2[2].">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				if($muestra_rol!=""){
					$muestra_rol.=$sql_sel_rol2[2].">?";
				}else{
					$muestra_rol.=$sql_sel_rol2[2];
				}
			}
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sql_con[16]";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_gestor = $sql_sel_usuario[0];
			$email_gestor = $sql_sel_usuario[1];
			$pos = strpos($correos_envia, $email_gestor.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$correos_envia.=$email_gestor.">?";
			}
			$pos = strpos($nombres_en_footer, $nombre_gestor.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$nombres_en_footer.=$nombre_gestor.">?";
			}
			/* ---------------------------------------------- BUSCA EL JEFE DE AREA ---------------------------- */
			$id_jefe_area = busca_jefe_area_contrato_id_contrato_mc($sql_con[0]); // la funcion esta en funciones_general_2015
			/* ---------------------------------------------- FIN BUSCA EL JEFE DE AREA ---------------------------- */
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $id_jefe_area";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_jefe = $sql_sel_usuario[0];
			$email_jefe = $sql_sel_usuario[1];
			$pos = strpos($correos_envia, $email_jefe.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$correos_envia.=$email_jefe.">?";
			}
			//echo $id_jefe_area."-jefe<br>"; 19 10
			$numero_contrato1 = "C";
			$separa_fecha_crea = explode("-",$sql_con[19]);
			$ano_contra = $separa_fecha_crea[0];
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $sql_con[2];
			$numero_contrato4 = $sql_con[43];
			$numero=numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3,$numero_contrato4, $sql_con[0]);
			$inicia=$sql_con[10];
			$finaliza=$sql_con[11];
			if($sql_con[34]==1){
				if($sql_con[59]==1){
					$tipo_contrato="ACEPTACION DE OFERTA MERCANTIL";
				}else{
					$tipo_contrato="CONTRATO PUNTUAL";
				}
			}else{
				$tipo_contrato="CONTRATO MARCO";
			}
			$item_contrato=traer_fila_row(query_db("SELECT COUNT(*) FROM $pi2 WHERE contrato_id=$sql_con[0] AND estado NOT IN(32, 31, 33)"));
			$otrosi="N/A";
			if($item_contrato[0]!=0){
				$item_contrato=traer_fila_row(query_db("SELECT num1, num2, num3 FROM $pi2 WHERE contrato_id=$sql_con[0] AND estado NOT IN(32, 31, 33)"));
				$otrosi=numero_item_pecc($item_contrato[0],$item_contrato[1],$item_contrato[2]);
			}
			if($sql_con[34]==2){
				$sel=query_db("select distinct gerente from t7_contratos_complemento where id_contrato=$sql_con[0]");
				$correos_ot="";
				$nombres_ot="";
				while($sel_ot = traer_fila_db($sel)){
					$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sel_ot[0]";
					$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
					$nombres_ot.=$sql_sel_usuario[0];
					$correos_ot.=$sql_sel_usuario[1].",,";
				}
				//echo "contrato marco";
			}
			$objeto=traer_fila_row(query_db("select cast(objeto as varchar(max)) from $co1 where id=$sql_con[0]"));
			$sel_pro = "select razon_social from ".$g6." where t1_proveedor_id=".$sql_con[5];
			$sel_pro_q=traer_fila_row(query_db($sel_pro));
			//$otrosi='<td align="center" style="font-family: arial; font-size: 10pt; border: 2px solid #FFF; overflow: hidden;">'.$otrosi.'</td>';
			$cuerpo_tabla1.='<tr style="background: transparent;">
				<td width="15%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$numero.'</td>
				<td width="18%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$sel_pro_q[0].'</td>
				<td width="25%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$objeto[0].'</td>
				<td width="10%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$tipo_contrato.'</td>
				<td width="10%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; color: #F45F53;">'.$finaliza.'</td>
				<td width="11%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$nombre_gestor.'</td>
				<td width="11%" align="center" style="'.$clase.' font-family: arial; font-size: 10pt; border: 1px solid #FFF; ">'.$nombre_generete.'</td>
			</tr>';
			$completa_tabla= $inicio_tabla1.$cuerpo_tabla1.$fin_tabla;
			$nombres_en_footer=str_replace('>?', ' / ', $nombres_en_footer);
			$footer=str_replace('<-profesional->', $nombres_en_footer, $footer);
			$muestra_rol=str_replace('>?', " / ", $muestra_rol);
			$footer=str_replace('<-firma->', $muestra_rol, $footer);
			$correos_envia=str_replace('>?', ',,', $correos_envia);			
			$nombre_en_tabla=str_replace('<-mumero_contrato->', $numero, $nombre_en_tabla);
			//echo $pasa_email=$nombre_en_tabla.$completa_tabla.$footer;
			
			$pasa_email=$nombre_en_tabla.$completa_tabla.$footer;
			if($time2==8 or $time2==9){
				//sent_mail_with_signature($correos_envia.$correos_ot,'VENCIMIENTO DEL CONTRATO '.$numero.' EN 30 DIAS',$pasa_email, $email_gestor, $nombre_gestor);
			}
			
		}
		}
	}

}
/*//}//FIN FUNCI&oacute;N
	//echo $inicio_tabla1.$cuerpo_tabla1."</tbody></table>";
$mes=1;
*/
?>