<?
include("../../librerias/lib/@include.php");
	
	$tabla='';
	$fecha_actual= date('Y-m-d');
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
	//($comple_sql or especialista=$v)
	$comple_sql="";
	$id="";
	$correos_mes1="";
	$correos_mes2="";
	$correos_mes3="";
	$correos_mes4="";
	$nombre_gestor_value="";
	$nombre_administrador_value="";
	$ruta="";
	$nombre_en_tabla="";
	
	if($_GET['id_gerente']){
		$ruta.="id_gerente=".$_GET['id_gerente'];
		$comple_sql.="gerente=".$_GET['id_gerente'];
		$sel_usuario = "select nombre_administrador, email from $g1 where us_id = ".$_GET['id_gerente'];
		$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
		$sel_usuario = "select nombre_administrador, email from $g1 where us_id =  ".$_GET['id_gerente'];
		$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
		$nombre_administrador_value = $sql_sel_usuario[0]."----,".$_GET['id_gerente']."----,";
	}else{
		$ruta.="id_gerente=0";
	}
	if($_GET['id_profesional']){
		$id_profesional=$_GET['id_profesional'];
		if($comple_sql==""){
			$ruta.="&id_profesional=".$_GET['id_profesional'];
			$comple_sql.= "especialista= ".$_GET['id_profesional'];
		}else{
			$ruta.="&id_profesional=".$_GET['id_profesional'];
			$comple_sql.=" and especialista= ".$_GET['id_profesional'];
		}
		$sel_usuario = "select nombre_administrador, email from $g1 where us_id =  ".$_GET['id_profesional'];
		$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
		$nombre_gestor_value = $sql_sel_usuario[0]."----,".$_GET['id_profesional']."----,";
	}else{
		$ruta.="&id_profesional=0";
	}
	if($_GET['tipo']){//entra en este condicional cuado viene de notificaciones push
		if($_GET['tipo']==1){//si viene desde las alertas push tipo 1= gerenete
			$ruta="id_gerente=".$_GET['id_gerente']."&id_profesional=0";
			$comple_sql="gerente=".$_GET['id_gerente'];
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id =  ".$_GET['id_gerente'];
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_administrador_value = $sql_sel_usuario[0]."----,".$_GET['id_gerente']."----,";
			$nombre_gestor_value = "";
		}elseif($_GET['tipo']==2){//si viene desde las alertas push tipo 2= profesional
			$ruta="id_gerente=0&id_profesional=".$_GET['id_gerente'];
			$comple_sql="especialista= ".$_GET['id_gerente'];
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id =  ".$_GET['id_gerente'];
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_gestor_value = $sql_sel_usuario[0]."----,".$_GET['id_gerente']."----,";
			$nombre_administrador_value = "";
		}
	}
	if($id_profesional!="" or $id_gerente!=""){//REALIZA EL PROCESO DE BUSQUEDA SI TIENE ALGÚNO DE LOS DOS ID'S
	$nombre_en_tabla='<div class="div-text"><p style="font-family: roboto !important; font-size: 12pt !important; font-weight: 900 !important;">A continuaci&oacute;n el informe de los contratos que se encuentran pr&oacute;ximos a vencer, si el servicio / suministro requiere continuidad por favor ingrese al SGPA y solicite un otros&iacute; a contrato puntual o ampliaci&oacute;n a contrato marco, el sistema remitir&aacute; su solicitud al Profesional / Comprador de abastecimiento encargado.<br><br></p></div>';
	$mes=1;
//function busca_contratos($busca_mes, $mes){//INICIO FUNCION
	$id="";
	//global $co1, $g6, $g1, $pi2;
	
		$nombres_en_footer="";
		$correos_envia="";
		$mensaje_envio1="";
		$mensaje_envio2="";
		$mensaje_envio3="";
		$mensaje_envio4="";
		$fin_tabla='</table></td></tr></table>';
		$v=str_replace('--', '', $v);
		//echo "select * FROM t7_contratos_contrato where vigencia_mes like '%$busca_mes%' and ($comple_sql) order by vigencia_mes <br>"; 
		/*******PARA LOS CONTRATS QUE VENCEN EN UN MES **********/
		$cuenta1=traer_fila_row(query_db("select count(*) FROM t7_contratos_contrato where vigencia_mes between '$fecha_actual' and '$un_mes' and ($comple_sql)"));
		if($cuenta1[0]!=0){
		$inicio_tabla1='';
		$cuerpo_tabla1='';
		$cont=0;
		$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$fecha_actual' and '$un_mes' and ($comple_sql) order by vigencia_mes");
		$prefacio='<br> Los contratos relacionados a Continuaci&oacute;n vencer&aacute;n en <strong>1</strong> mes(es)</p>';
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
			$id_jefe_area = busca_jefe_area_contrato($sql_con[0]); // la funcion esta en funciones_general_2015
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
			$objeto=traer_fila_row(query_db("select cast(objeto as varchar(max)) from $co1 where id=$sql_con[0]"));
			$sel_pro = "select razon_social from ".$g6." where t1_proveedor_id=".$sql_con[5];
			$sel_pro_q=traer_fila_row(query_db($sel_pro));
			//$otrosi='<td align="center" style="font-family: arial; font-size: 10pt; border: 2px solid #FFF; overflow: hidden;">'.$otrosi.'</td>';
			$cuerpo_tabla1.='<tr style="background: transparent;">
				<td width="15%" align="center" class="font f12 border" style="'.$clase.'  ">'.$numero.'</td>
				<td width="18%" align="center" class="font f12 border" style="'.$clase.'  ">'.$sel_pro_q[0].'</td>
				<td width="25%" align="center" class="font f12 border" style="'.$clase.'  ">'.$objeto[0].'</td>
				<td width="10%" align="center" class="font f12 border" style="'.$clase.'  ">'.$tipo_contrato.'</td>
				<td width="10%" align="center" class="font f12 border custom-red2" style="'.$clase.' ">'.$finaliza.'</td>
				<td width="12%" align="center" class="font f12 border" style="'.$clase.'  ">'.$nombre_gestor.'</td>
<td width="12%" align="center" class="font f12 border" style="'.$clase.'  ">'.$nombre_generete.'</td>
			</tr>';
		}
		$mensaje_envio1=$cuerpo_tabla1;
		}
		$un_mes =strtotime ( '+1 day' , strtotime ($un_mes) );
		$un_mes=date('Y-m-d', $un_mes);
		/*******PARA LOS CONTRATS QUE VENCEN EN DOS MESES **********/
		$cuenta1=traer_fila_row(query_db("select count(*) FROM t7_contratos_contrato where vigencia_mes between '$un_mes' and '$dos_meses' and ($comple_sql)"));
		if($cuenta1[0]!=0){
		$inicio_tabla2='';
		$cuerpo_tabla2='';
		$cont=0;
		$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$un_mes' and '$dos_meses' and ($comple_sql) order by vigencia_mes");
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
			$id_jefe_area = busca_jefe_area_contrato($sql_con[0]); // la funcion esta en funciones_general_2015
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
				<td width="15%" align="center" class="font f12 border" style="'.$clase.'  ">'.$numero.'</td>
				<td width="18%" align="center" class="font f12 border" style="'.$clase.'  ">'.$sel_pro_q[0].'</td>
				<td width="25%" align="center" class="font f12 border" style="'.$clase.'  ">'.$objeto[0].'</td>
				<td width="10%" align="center" class="font f12 border" style="'.$clase.'  ">'.$tipo_contrato.'</td>
				<td width="10%" align="center" class="font f12 border custom-yellow2" style="'.$clase.' ">'.$finaliza.'</td>
				<td width="12%" align="center" class="font f12 border" style="'.$clase.'  ">'.$nombre_gestor.'</td>
<td width="12%" align="center" class="font f12 border" style="'.$clase.'  ">'.$nombre_generete.'</td>
			</tr>';
		}
		$mensaje_envio2.=$cuerpo_tabla2;
		}
		//sent_mail_with_signature('rrrjassson@gmail.com,,',$nombre.' - Vencimiento de contratos en '.$mes,$mensaje_envio, $email_gestor, $nombre_gestor);	
		$dos_meses = strtotime ( '+1 day' , strtotime ($dos_meses) );
		$dos_meses=date('Y-m-d',$dos_meses);
		/*******PARA LOS CONTRATS QUE VENCEN EN TRES MESES **********/
		$cuenta1=traer_fila_row(query_db("select count(*) FROM t7_contratos_contrato where vigencia_mes between '$dos_meses' and '$tres_meses' and ($comple_sql)"));
		if($cuenta1[0]!=0){
		$inicio_tabla3='';
		$cuerpo_tabla3='';
		$cont=0;
		$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$dos_meses' and '$tres_meses' and ($comple_sql) order by vigencia_mes");
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
			$id_jefe_area = busca_jefe_area_contrato($sql_con[0]); // la funcion esta en funciones_general_2015
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
				<td width="15%" align="center" class="font f12 border" style="'.$clase.'  ">'.$numero.'</td>
				<td width="18%" align="center" class="font f12 border" style="'.$clase.'  ">'.$sel_pro_q[0].'</td>
				<td width="25%" align="center" class="font f12 border" style="'.$clase.'  ">'.$objeto[0].'</td>
				<td width="10%" align="center" class="font f12 border" style="'.$clase.'  ">'.$tipo_contrato.'</td>
				<td width="10%" align="center" class="font f12 border custom-green2" style="'.$clase.' ">'.$finaliza.'</td>
				<td width="12%" align="center" class="font f12 border" style="'.$clase.'  ">'.$nombre_gestor.'</td>
<td width="12%" align="center" class="font f12 border" style="'.$clase.'  ">'.$nombre_generete.'</td>
			</tr>';
		}
			$mensaje_envio3.=$cuerpo_tabla3;
		}

		$tres_meses = strtotime ( '+1 day' , strtotime ($tres_meses) );
		$tres_meses=date('Y-m-d',$tres_meses);
		/*******PARA LOS CONTRATS QUE VENCEN EN CUATRO MESES **********/
		$cuenta1=traer_fila_row(query_db("select count(*) FROM t7_contratos_contrato where vigencia_mes between '$tres_meses' and '$cuatro_meses' and ($comple_sql)"));
		if($cuenta1[0]!=0){
		$inicio_tabla4='';
		$cuerpo_tabla4='';
		$cont=0;
		$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$tres_meses' and '$cuatro_meses' and ($comple_sql) order by vigencia_mes");
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
			$pos = strpos($nombres_en_footer, $nombre_generete.">?");
			if ($pos !== false) {//si exixte el id
			}else{				
				$nombres_en_footer.=$nombre_generete.">?";
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
			$id_jefe_area = busca_jefe_area_contrato($sql_con[0]); // la funcion esta en funciones_general_2015
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
				<td width="15%" align="center" class="font f12 border" style="'.$clase.'  ">'.$numero.'</td>
				<td width="18%" align="center" class="font f12 border" style="'.$clase.'  ">'.$sel_pro_q[0].'</td>
				<td width="25%" align="center" class="font f12 border" style="'.$clase.'  ">'.$objeto[0].'</td>
				<td width="10%" align="center" class="font f12 border" style="'.$clase.'  ">'.$tipo_contrato.'</td>
				<td width="10%" align="center" class="font f12 border custom-green2" style="'.$clase.' ">'.$finaliza.'</td>
				<td width="12%" align="center" class="font f12 border" style="'.$clase.'  ">'.$nombre_gestor.'</td>
<td width="12%" align="center" class="font f12 border" style="'.$clase.'  ">'.$nombre_generete.'</td>
			</tr>';
		}
			$mensaje_envio4.=$cuerpo_tabla4;
		}
		$nombres_en_footer=str_replace('>?', ',<br>', $nombres_en_footer);
		$footer=str_replace('<-profesional->', $nombres_en_footer, $footer);
		$correos_envia=str_replace('>?', ',<br>', $correos_envia);
		//echo $nombres_en_footer."<br><br>".$correos_envia;
		//echo $nombre_en_tabla.=$footer."<br> Se evnvair&aacute; a: ".$correos_envia;
		//echo $mensaje_envio=$nombre_en_tabla.$mensaje_envio1.$mensaje_envio2.$mensaje_envio3.$mensaje_envio4;
		//$total_tablas.=$nombre_en_tabla."<br><br>";
		//sent_mail_with_signature('jeison.rivera@enternova.net,,',$nombre.' - Iforme Vencimiento de Contratos',$nombre_en_tabla, $email_gestor, $nombre_gestor);

}//FIN SI ENCUENTRA ID'S
?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Roboto:100" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../librerias/materialize/css/materialize_custom.css">
<script type="text/javascript" src="../librerias/jquery/jquery2.js"></script>
<script type="text/javascript" src="../librerias/materialize/js/materialize.js"></script>
<style>
	.div-text {
		width: 90%;
		margin-left: 5%;
		height: auto;
	}
	.div-custom-red2{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #E0766B;
	}
	.div-custom-yellow2{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #FFBE5E;
	}
	.div-custom-green2{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #6AC46F;
	}
	.font{
		font-family: 'roboto';
	}
	.f14{
		font-size: 12pt;
	}
	.f12{
		font-size: 9pt;
		font-weight: 900 !important;
	}
	.f10{
		font-size: 8pt;
		color: #000;
	}
	.table-custom{
		width: 98%;
		margin-left: 1%;
		border-collapse:collapse;
	}
	.th-custom{
		/*-webkit-box-shadow: 0 9px 4px #777;
		-moz-box-shadow: 0 9px 4px #777;
		box-shadow: 0 9px 4px #777;*/
		background: transparent;
		color: #FFF;		
		font-weight: 900;
	}
	.td-title-red{
		background: #FE5151;
		color: #FFF;
	}
	.td-title-yellow{
		background: #FEC007;
		color: #FFF;
	}
	.td-title-green{
		background: #4BAE4F;
		color: #FFF;
	}
	.custom-red2{
		color: #FF3333;
	}
	.custom-yellow2{
		color: #E2B700;
	}
	.custom-green2{
		color: #009900;
	}
	.border{
		border: 2px solid #FFF;
	}
	.transparent{
		background: transparent;
	}
</style>
<div class="titulos_secciones font" style="font-size:18pt !important; font-weight: 900 !important;">Reporte de Vencimiento de Contratos</div>
<div class="" style="background: #005395;">
	<div class="s12 m12 l12"></div>
</div>
<br>
<br>
<div class="container">
	<div class="row">
		<div class="input-field col s12 m6 l6 right">
			<i class="material-icons prefix">&#xE7FD;</i>
		 	<input autocomplete="off" id="usuario_permiso3" onkeypress="selecciona_lista()" name="usuario_permiso3" type="text" class="validate" placeholder="Ingrese el Nombre para Realizar el Filtro" required="" autofocus="" value="<?=$nombre_administrador_value;?>">
		 	<label for="usuario_permiso3" class="active" style="font-weight: 900 !important; font-family: roboto !important; font-size: 12pt !important;">Gerente de Contrato</label>
		</div>
		<div class="input-field col s12 m6 l6 left">
			<i class="material-icons prefix">&#xE7FD;</i>
	 		<input autocomplete="off" id="gerente_confirma_asegu2" onkeypress="selecciona_lista()" name="gerente_confirma_asegu2" type="text" class="validate" placeholder="Ingrese el Nombre para Realizar el Filtro" required="" autofocus="" value="<?=$nombre_gestor_value;?>">
	 		<label for="gerente_confirma_asegu2" class="active" style="font-weight: 900 !important; font-family: roboto; font-size: 12pt !important;">Profesional / Comprador</label>
		</div>
            </div>
            <div class="row">
            		<div class="input-field col s12 m12 l12 center">
            			<a class="waves-effect waves-light btn" id="busca" style="background: #229BFF !important; background-color:  #229BFF; z-index: 0 !important;" onclick="busca_reporte_contrato()" ><i class="material-icons left">&#xE8B6;</i>Buscar Contratos</a>
            			&nbsp;&nbsp;
            <?if($mensaje_envio4!="" or $mensaje_envio3!="" or $mensaje_envio2!="" or $mensaje_envio1!=""){?>
            			<a class="waves-effect waves-light btn" id="reporte" style="background: #229BFF !important; background-color:  #229BFF; z-index: 0 !important;" onclick="document.location.assign('../aplicaciones/reportes/reporte_alertas_contratos.php?<?=$ruta?>')"><i class="material-icons left">&#xE0C3;</i>Exportar a Excel</a>
            		</div>
            <?}?>
            </div>
            
</div>
<?if($nombre_en_tabla!="" and $mensaje_envio4!="" or $mensaje_envio3!="" or $mensaje_envio2!="" or $mensaje_envio1!=""){
echo $nombre_en_tabla;
}?>
<?if($mensaje_envio1!=""){?>
<div class="div-custom-red2">
	<table class="table-custom">
		<tr class="">
			<td colspan="6" align="left" class="th-custom font f14"><h5 style="font-weight: 900;">Contratos que vencer&aacute;n en menos de 30 d&iacute;as</h5></td>
		</tr>
		<tr style="">
			<td width="15%" align="center" class="font f12 td-title-red border"><h6>Contrato</h6></td>
			<td width="18%" align="center" class="font f12 td-title-red border"><h6>Proveedor</h6></td>
			<td width="25%" align="center" class="font f12 td-title-red border"><h6>Objeto</h6></td>
			<td width="10%" align="center" class="font f12 td-title-red border"><h6>Tipo de Contrato</h6></td>
			<td width="10%" align="center" class="font f12 td-title-red border"><h6>Fecha Fin</h6></td>
			<td width="12%" align="center" class="font f12 td-title-red border"><h6>Encargado en Abastecimiento</h6></td>
			<td width="12%" align="center" class="font f12 td-title-red border"><h6>Gerente de Contrato</h6></td>
		</tr>
		<? echo $mensaje_envio1;?>
		<tr class="transparent">
			<td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
	</table>
</div>
<br>
<?}?>
<?if($mensaje_envio2!=""){?>
<div class="div-custom-yellow2">
	<table class="table-custom">
		<tr class="">
			<td colspan="6" align="left" class="th-custom font f14"><h5 style="font-weight: 900;">Contratos que vencer&aacute;n en menos de 2 meses</h5></td>
		</tr>
		<tr style="">
			<td width="15%" align="center" class="font f12 td-title-yellow border"><h6>Contrato</h6></td>
			<td width="18%" align="center" class="font f12 td-title-yellow border"><h6>Proveedor</h6></td>
			<td width="25%" align="center" class="font f12 td-title-yellow border"><h6>Objeto</h6></td>
			<td width="10%" align="center" class="font f12 td-title-yellow border"><h6>Tipo de Contrato</h6></td>
			<td width="10%" align="center" class="font f12 td-title-yellow border"><h6>Fecha Fin</h6></td>
			<td width="12%" align="center" class="font f12 td-title-yellow border"><h6>Encargado en Abastecimiento</h6></td>
			<td width="12%" align="center" class="font f12 td-title-yellow border"><h6>Gerente de Contrato</h6></td>
		</tr>
		<? echo $mensaje_envio2;?>
		<tr class="transparent">
			<td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
	</table>
</div>
<br>
<?}?>
<?if($mensaje_envio3!=""){?>
<div class="div-custom-green2">
	<table class="table-custom">
		<tr class="">
			<td colspan="6" align="left" class="th-custom font f14"><h5 style="font-weight: 900;">Contratos que vencer&aacute;n en menos de 3 meses</h5></td>
		</tr>
		<tr style="">
			<td width="15%" align="center" class="font f12 td-title-green border"><h6>Contrato</h6></td>
			<td width="18%" align="center" class="font f12 td-title-green border"><h6>Proveedor</h6></td>
			<td width="25%" align="center" class="font f12 td-title-green border"><h6>Objeto</h6></td>
			<td width="10%" align="center" class="font f12 td-title-green border"><h6>Tipo de Contrato</h6></td>
			<td width="10%" align="center" class="font f12 td-title-green border"><h6>Fecha Fin</h6></td>
			<td width="12%" align="center" class="font f12 td-title-green border"><h6>Encargado en Abastecimiento</h6></td>
			<td width="12%" align="center" class="font f12 td-title-green border"><h6>Gerente de Contrato</h6></td>
		</tr>
		<? echo $mensaje_envio3;?>
		<tr class="transparent">
			<td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
	</table>
</div>
<br>
<?}?>
<?if($mensaje_envio4!=""){?>
<div class="div-custom-green2">
	<table class="table-custom">
		<tr class="">
			<td colspan="6" align="left" class="th-custom font f14"><h5 style="font-weight: 900;">Contratos que vencer&aacute;n en menos de 4 meses</h5></td>
		</tr>
		<tr style="">
			<td width="15%" align="center" class="font f12 td-title-green border"><h6>Contrato</h6></td>
			<td width="18%" align="center" class="font f12 td-title-green border"><h6>Proveedor</h6></td>
			<td width="25%" align="center" class="font f12 td-title-green border"><h6>Objeto</h6></td>
			<td width="10%" align="center" class="font f12 td-title-green border"><h6>Tipo de Contrato</h6></td>
			<td width="10%" align="center" class="font f12 td-title-green border"><h6>Fecha Fin</h6></td>
			<td width="12%" align="center" class="font f12 td-title-green border"><h6>Encargado en Abastecimiento</h6></td>
			<td width="12%" align="center" class="font f12 td-title-green border"><h6>Gerente de Contrato</h6></td>
		</tr>
		<? echo $mensaje_envio4;?>
		<tr class="transparent">
			<td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
	</table>
</div>
<?}?>