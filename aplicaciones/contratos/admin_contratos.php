<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	
	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
</head>

<body>
    <?
echo imprime_cabeza_contrato($id_contrato)
?>
<br />
      
      
    <table width="100%" border="0" class="tabla_lista_resultados">
        <tr>
            <td width="25%" align="center" class="fondo_3">Detalle</td>
            <td width="25%" align="center" class="fondo_3">Adjunto</td>
            <td width="25%" align="center" class="fondo_3">Comentario</td>
            <td width="25%" align="center" class="fondo_3">Acci&oacute;n</td>
        </tr>
        <tr>
        <?php 
		$busca_contrato = "select top(1) * from t7_acciones_admin where id_contrato = $id_contrato_arr and detalle = '1. Eliminar contrato' order by id desc";
		$sql_con=traer_fila_db(query_db($busca_contrato));?>
            <td align="center" class="filas_resultados">1. Eliminar este contrato</td>
            <td align="center" class="filas_resultados"><input type="file" name="file_delete" id="file_delete"/>
          	<?
            if($sql_con['adjunto'] != ""){
			echo saca_nombre_anexo($sql_con['adjunto'])?>
            <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sql_con['adjunto']?>&n1=<?=$sql_con['id']?>&n3=7&n4=admin" target="grp">
            	<img src="../imagenes/mime/<?=saca_extencion_archivo($sql_con['adjunto'])?>.gif" width="16" height="16" />
            </a>
            <?php }?>
            </td>
            <td align="center" class="filas_resultados">
                <textarea name="ob1" id="ob1"></textarea><?=$sql_con['observacion']?>
            </td>
            <td align="center" class="filas_resultados">
                <select name="acci1" id="acci1">
                    <option value="0">Seleccione</option>
                    <option value="1">Si eliminar.</option>
                </select>
            </td>
        </tr>
        <tr>
            <td  colspan="4"align="center"><input onclick="acciones_admin_contratos()" id="button2" class="boton_grabar" type="button" value="Grabar Cambios Administrativos" name="button2" /></td>
        </tr>
    </table>

<input type="hidden" name="id_contrato_arr_envia" id="id_contrato_arr_envia" value="<?=arreglo_pasa_variables($id_contrato_arr)?>" />
</body>
</html>
