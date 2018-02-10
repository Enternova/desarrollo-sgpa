<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
header('Content-Type: text/xml; charset=ISO-8859-1');

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	$id_documento_arr = elimina_comillas(arreglo_recibe_variables($id_documento));
	
	if($id_documento_arr==""){
		$id_documento_arr=0;
	}
	
	$busca_contacto = "select * from $co7 where id = $id_documento_arr";
	$sql_com=traer_fila_row(query_db($busca_contacto));
	
	$busca_contrato_tipo = "select t1_tipo_documento_id from $co1 where id = $id_contrato_arr";
	$sql_tipo=traer_fila_row(query_db($busca_contrato_tipo));
	

	$busca_contrato = "select gerente from $co1 where id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));

	$edita = 0;
	$disabled = "";
	if($sql_con[0]==$_SESSION["id_us_session"]){
		$edita = 1;
	}
	
	if($edita==0){
		$disabled = " disabled='disabled' ";
	}
	//Quitar
	$edita = 1;
	//Quitar

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?
echo imprime_cabeza_contrato($id_contrato);
if($edita==1){
?>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
<tr>
	<td id="fila_evaluador1">
		<table width="100%" border="0" cellpadding="2" cellspacing="2">
			<tr >
				<td valign="top"><span onclick="javascript:document.getElementById('fila_evaluador1').style.display = 'none';ajax_carga('../aplicaciones/contratos/c_evaluacion.php','fila_evaluador2')" style="cursor:pointer">Crear Nueva Plantilla</span></td>
				<td valign="top">&nbsp;</td>
				<td valign="top">&nbsp;</td>
				<td valign="top">&nbsp;</td>
			</tr>
			<tr class="fondo_3">
				<td width="35%" valign="top">#PLantilla<BR /></td>
				<td width="36%" valign="top">Usuario Creador</td>
				<td width="71%" valign="top">Estado</td>
				<td width="71%" valign="top">Editar</td>
			</tr>
			<tr>
				<td valign="top" id="carga_plantilla_evaluador">&nbsp;</td>
				<td valign="top" id="carga_plantilla_evaluador">&nbsp;</td>
				<td valign="top" id="carga_plantilla_evaluador">&nbsp;</td>
				<td valign="top" id="carga_plantilla_evaluador">&nbsp;</td>
			</tr>
		</table>
	</td>
</tr>
<tr>
	<td id="fila_evaluador2">
    </td>
</tr>

</table>

<?
}
?>
<input name="id_documento" type="hidden" value="<?=$id_documento;?>" />

</body>
</html>
