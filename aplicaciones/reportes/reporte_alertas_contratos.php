<?
//error_reporting(E_ALL);  // LÃ­neas para mostart errores
//ini_set('display_errors', '1');  // LÃ­neas para mostart errores
	header("Pragma: public");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Cache-Control: public"); 
    header("Content-Description: File Transfer");
  header("Content-type: application/force-download");
//  header("Content-type: $tipo");
  header("Content-Disposition: attachment; filename=Reporte de Contratros Próximos a Vencer.xls"); 
  header("Content-Transfer-Encoding: binary");
//include("../../librerias/lib/@include.php");
//include("../../librerias/lib/@config.php");
include("../../librerias/lib/@session.php");
   //include(SUE_PATH."global.php");
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
	if($_GET['id_gerente']!=0){
		$comple_sql.="gerente=".$_GET['id_gerente'];
	}
	if($_GET['id_profesional']!=0){
		if($comple_sql==""){
			$comple_sql.= "especialista= ".$_GET['id_profesional'];
		}else{
			$comple_sql.=" and especialista= ".$_GET['id_profesional'];
		}
	}
	//if($id_profesional!="" or $id_gerente!=""){REALIZA EL PROCESO DE BUSQUEDA SI TIENE ALGÚNO DE LOS DOS ID'S
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
		/*******PARA LOS CONTRATS QUE VENCEN EN UN MES **********/
		$cuenta1=traer_fila_row(query_db("select count(*) FROM t7_contratos_contrato where vigencia_mes between '$fecha_actual' and '$un_mes' and ($comple_sql)"));
		if($cuenta1[0]!=0){
		$inicio_tabla1='';
		$cuerpo_tabla1='';
		$cont=0;
		$query=query_db("select * FROM t7_contratos_contrato where vigencia_mes between '$fecha_actual' and '$un_mes' and ($comple_sql) order by vigencia_mes");
		$prefacio='<br> Los contratos relacionados a Continuaci&oacute;n vencer&aacute;n en <strong>1</strong> mes(es)</p>';
		while($sql_con = traer_fila_db($query)){
			//print_r($sql_con);
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
			
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sql_con[16]";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_gestor = $sql_sel_usuario[0];
			$email_gestor = $sql_sel_usuario[1];
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
			
			$objeto=traer_fila_row(query_db("select cast(objeto as varchar(max)) from $co1 where id=$sql_con[0]"));
			$sel_pro = "select razon_social from ".$g6." where t1_proveedor_id=".$sql_con[5];
			$sel_pro_q=traer_fila_row(query_db($sel_pro));
			//$otrosi='<td align="center" style="font-family: sans-serif;-family: arial; font-size: 10pt; border: 1px solid #000; overflow: hidden;">'.$otrosi.'</td>';
			$cuerpo_tabla1.='<tr style="background: transparent;">
				<td width="15%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$numero.'</td>
				<td width="17%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$sel_pro_q[0].'</td>
				<td width="20%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$objeto[0].'</td>
				<td width="10%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$tipo_contrato.'</td>
				<td width="8%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000; color: #FF3333;" style="'.$clase.' ">'.$inicia.'</td>
				<td width="8%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000; color: #FF3333;" style="'.$clase.' ">'.$finaliza.'</td>
				<td width="12%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$nombre_gestor.'</td>
				<td width="12%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$nombre_generete.'</td>
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
			
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sql_con[16]";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_gestor = $sql_sel_usuario[0];
			$email_gestor = $sql_sel_usuario[1];
			
			
			
			
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
			
			$objeto=traer_fila_row(query_db("select cast(objeto as varchar(max)) from $co1 where id=$sql_con[0]"));
			$sel_pro = "select razon_social from ".$g6." where t1_proveedor_id=".$sql_con[5];
			$sel_pro_q=traer_fila_row(query_db($sel_pro));
			//$otrosi='<td align="center" style="font-family: sans-serif;-family: arial; font-size: 10pt; border: 1px solid #000; overflow: hidden;">'.$otrosi.'</td>';
			$cuerpo_tabla2.='<tr style="background: transparent;">
				<td width="15%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$numero.'</td>
				<td width="17%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$sel_pro_q[0].'</td>
				<td width="20%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$objeto[0].'</td>
				<td width="10%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$tipo_contrato.'</td>
				<td width="8%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000; color: #E2B700;" style="'.$clase.' ">'.$inicia.'</td>
				<td width="8%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000; color: #E2B700;" style="'.$clase.' ">'.$finaliza.'</td>
				<td width="12%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$nombre_gestor.'</td>
				<td width="12%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$nombre_generete.'</td>
			</tr>';
		}
		$mensaje_envio2.=$cuerpo_tabla2;
		}	
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
			
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sql_con[16]";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_gestor = $sql_sel_usuario[0];
			$email_gestor = $sql_sel_usuario[1];
			
			
			
			/**/
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
			
			$objeto=traer_fila_row(query_db("select cast(objeto as varchar(max)) from $co1 where id=$sql_con[0]"));
			$sel_pro = "select razon_social from ".$g6." where t1_proveedor_id=".$sql_con[5];
			$sel_pro_q=traer_fila_row(query_db($sel_pro));
			$cuerpo_tabla3.='<tr style="background: transparent;">
				<td width="15%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$numero.'</td>
				<td width="17%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$sel_pro_q[0].'</td>
				<td width="20%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$objeto[0].'</td>
				<td width="10%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$tipo_contrato.'</td>
				<td width="8%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000; color: #009900;" style="'.$clase.' ">'.$inicia.'</td>
				<td width="8%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000; color: #009900;" style="'.$clase.' ">'.$finaliza.'</td>
				<td width="12%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$nombre_gestor.'</td>
				<td width="12%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$nombre_generete.'</td>
			</tr>';
		}
			$mensaje_envio3.=$cuerpo_tabla3;
		}

		$tres_meses = strtotime ( '+1 day' , strtotime ($tres_meses) );
		$tres_meses=date('Y-m-d',$tres_meses);
		/*******PARA LOS CONTRATS QUE VENCEN EN CUATRO MESES **********/
$comple_sql1="select count(*) FROM t7_contratos_contrato where vigencia_mes between '$tres_meses' and '$cuatro_meses' and ($comple_sql)";
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
			
			$sel_usuario = "select nombre_administrador, email from $g1 where us_id = $sql_con[16]";
			$sql_sel_usuario=traer_fila_row(query_db($sel_usuario));
			$nombre_gestor = $sql_sel_usuario[0];
			$email_gestor = $sql_sel_usuario[1];
			
			
			
			/**/
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
			
			$objeto=traer_fila_row(query_db("select cast(objeto as varchar(max)) from $co1 where id=$sql_con[0]"));
			$sel_pro = "select razon_social from ".$g6." where t1_proveedor_id=".$sql_con[5];
			$sel_pro_q=traer_fila_row(query_db($sel_pro));
			$cuerpo_tabla4.='<tr style="background: transparent;">
				<td width="15%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$numero.'</td>
				<td width="17%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$sel_pro_q[0].'</td>
				<td width="20%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$objeto[0].'</td>
				<td width="10%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$tipo_contrato.'</td>
				<td width="8%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000; color: #009900;" style="'.$clase.' ">'.$inicia.'</td>
				<td width="8%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000; color: #009900;" style="'.$clase.' ">'.$finaliza.'</td>
				<td width="12%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$nombre_gestor.'</td>
				<td width="12%" align="center" style="font-family: sans-serif;font-size: 10pt; border: 1px solid #000;" style="'.$clase.'  ">'.$nombre_generete.'</td>
			</tr>';
		}
			$mensaje_envio4.=$cuerpo_tabla4;
		}

//}FIN SI ENCUENTRA ID'S
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
  <html>
  <head>
  <meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
  <title>Documento sin t&iacute;tulo</title>
  <style>
  .div-color: #FF3333;{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #F34336;
	}
	.div-color: #E2B700;{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #FE9800;
	}
	.div-color: #009900;{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #388E3C;
	}
	.transparent{
		background: transparent;
	}
  </style>
  </head>

  <body>
	<?if($mensaje_envio1!=""){?>
	<table style="width: 98%; margin-left: 1%; border-collapse:collapse;">
		<tr style="">
			<td colspan="6" align="left" style="background: transparent; color: #000; font-weight: 900; font font-size: 12pt;"><h5 style="font-family: sans-serif;-weight: 900;">Contratos que vencer&aacute;n en menos de 30 d&iacute;as</h5></td>
		</tr>
		<tr style="">
			<td width="15%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #FE5151; color: #FFF; border: 1px solid #000;"><h6>Contrato</h6></td>
			<td width="17%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #FE5151; color: #FFF; border: 1px solid #000;"><h6>Proveedor</h6></td>
			<td width="20%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #FE5151; color: #FFF; border: 1px solid #000;"><h6>Objeto</h6></td>
			<td width="10%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #FE5151; color: #FFF; border: 1px solid #000;"><h6>Tipo de Contrato</h6></td>
			<td width="8%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #FE5151; color: #FFF; border: 1px solid #000;"><h6>Fecha Inicio</h6></td>
			<td width="8%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #FE5151; color: #FFF; border: 1px solid #000;"><h6>Fecha Fin</h6></td>
			<td width="12%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #FE5151; color: #FFF; border: 1px solid #000;"><h6>Profesional de Abastecimiento</h6></td>
			<td width="12%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #FE5151; color: #FFF; border: 1px solid #000;"><h6>Gerente de Contrato</h6></td>
		</tr>
		<?=$mensaje_envio1;?>
		<tr style="background: transparent;">
			<td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
	</table>
<br>
<?}?>
<?if($mensaje_envio2!=""){?>
	<table style="width: 98%; margin-left: 1%; border-collapse:collapse;">
		<tr style="">
			<td colspan="6" align="left" style="background: transparent; color: #000; font-weight: 900; font font-size: 12pt;"><h5 style="font-family: sans-serif;-weight: 900;">Contratos que vencer&aacute;n en menos de 2 meses</h5></td>
		</tr>
		<tr style="">
			<td width="15%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #FEC007; color: #FFF; border: 1px solid #000;"><h6>Contrato</h6></td>
			<td width="17%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #FEC007; color: #FFF; border: 1px solid #000;"><h6>Proveedor</h6></td>
			<td width="20%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #FEC007; color: #FFF; border: 1px solid #000;"><h6>Objeto</h6></td>
			<td width="10%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #FEC007; color: #FFF; border: 1px solid #000;"><h6>Tipo de Contrato</h6></td>
			<td width="8%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #FEC007; color: #FFF; border: 1px solid #000;"><h6>Fecha Inicio</h6></td>
			<td width="8%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #FEC007; color: #FFF; border: 1px solid #000;"><h6>Fecha Fin</h6></td>
			<td width="12%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #FEC007; color: #FFF; border: 1px solid #000;"><h6>Profesional de Abastecimiento</h6></td>
			<td width="12%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #FEC007; color: #FFF; border: 1px solid #000;"><h6>Gerente de Contrato</h6></td>
		</tr>
		<?=$mensaje_envio2;?>
		<tr style="background: transparent;">
			<td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
	</table>
<br>
<?}?>
<?if($mensaje_envio3!=""){?>
	<table style="width: 98%; margin-left: 1%; border-collapse:collapse;">
		<tr style="">
			<td colspan="6" align="left" style="background: transparent; color: #000; font-weight: 900; font font-size: 12pt;"><h5 style="font-family: sans-serif;-weight: 900;">Contratos que vencer&aacute;n en menos de 3 meses</h5></td>
		</tr>
		<tr style="">
			<td width="15%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #4BAE4F; color: #FFF; border: 1px solid #000;"><h6>Contrato</h6></td>
			<td width="17%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #4BAE4F; color: #FFF; border: 1px solid #000;"><h6>Proveedor</h6></td>
			<td width="20%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #4BAE4F; color: #FFF; border: 1px solid #000;"><h6>Objeto</h6></td>
			<td width="10%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #4BAE4F; color: #FFF; border: 1px solid #000;"><h6>Tipo de Contrato</h6></td>
			<td width="8%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #4BAE4F; color: #FFF; border: 1px solid #000;"><h6>Fecha Inicio</h6></td>
			<td width="8%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #4BAE4F; color: #FFF; border: 1px solid #000;"><h6>Fecha Fin</h6></td>
			<td width="12%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #4BAE4F; color: #FFF; border: 1px solid #000;"><h6>Profesional de Abastecimiento</h6></td>
			<td width="12%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #4BAE4F; color: #FFF; border: 1px solid #000;"><h6>Gerente de Contrato</h6></td>
		</tr>
		<?=$mensaje_envio3;?>
		<tr style="background: transparent;">
			<td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
	</table>
<br>
<?}?>
<?if($mensaje_envio4!=""){?>
	<table style="width: 98%; margin-left: 1%; border-collapse:collapse;">
		<tr style="">
			<td colspan="6" align="left" style="background: transparent; color: #000; font-weight: 900; font font-size: 12pt;"><h5 style="font-family: sans-serif;-weight: 900;">Contratos que vencer&aacute;n en menos de 4 meses</h5></td>
		</tr>
		<tr style="">
			<td width="15%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #4BAE4F; color: #FFF; border: 1px solid #000;"><h6>Contrato</h6></td>
			<td width="17%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #4BAE4F; color: #FFF; border: 1px solid #000;"><h6>Proveedor</h6></td>
			<td width="20%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #4BAE4F; color: #FFF; border: 1px solid #000;"><h6>Objeto</h6></td>
			<td width="10%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #4BAE4F; color: #FFF; border: 1px solid #000;"><h6>Tipo de Contrato</h6></td>
			<td width="8%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #4BAE4F; color: #FFF; border: 1px solid #000;"><h6>Fecha Inicio</h6></td>
			<td width="8%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #4BAE4F; color: #FFF; border: 1px solid #000;"><h6>Fecha Fin</h6></td>
			<td width="12%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #4BAE4F; color: #FFF; border: 1px solid #000;"><h6>Profesional de Abastecimiento</h6></td>
			<td width="12%" align="center" style="font-family: sans-serif;font-size: 10pt; background: #4BAE4F; color: #FFF; border: 1px solid #000;"><h6>Gerente de Contratos</h6></td>
		</tr>
		<?=$mensaje_envio4;?>
		<tr style="background: transparent;">
			<td colspan="6">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</td>
		</tr>
	</table>
<?}?>
</body>
</html>