<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_proveedor_arr = elimina_comillas(arreglo_recibe_variables($id));
	
	$sel_pro = "select * from ".$g6." where t1_proveedor_id=".$id_proveedor_arr;
	$sel_pro_q=traer_fila_row(query_db($sel_pro));
	
	$digito = "";
    if(trim($sel_pro_q[2])!=""){
		$digito = "-".$sel_pro_q[2];
	}

?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>


<table width="100%" border="0" cellpadding="2" cellspacing="2" >	
	<tr >
    	<td width="71%" valign="top" id="carga_acciones_permitidas">
        	<?
			imprime_cabeza_proveedor($id);
			?>
			<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
				<tr>					
					<td width="38%" align="right">NIT:</td>
					<td colspan="3"><?=$sel_pro_q[1].$digito;?></td>
				</tr>
				<tr>
					<td align="right">Contratista:</td>        
					<td colspan="3"><?=$sel_pro_q[3];?></td>
				</tr>
				<tr>
				  <td align="right">Plantilla:</td>
				  <td>
                  <select name="tipo_contrato_bu" id="tipo_contrato_bu" >
                    <option value="0">Seleccione</option>
                    <?
                    $lista_contrato = "select * from $evf3 where estado = 1";
					$sql_contrato=query_db($lista_contrato);
					while($lista_contrato=traer_fila_row($sql_contrato)){
					?>
                    <option value="<?=$lista_contrato[0];?>" ><?=$lista_contrato[1];?></option>
                    <?
					}
					?>
					</select>
                  </td>
				  <td colspan="2">&nbsp;</td>
		      </tr>
				<tr>
				  <td align="right">&nbsp;</td>
				  <td width="14%"><input type="submit" name="button" id="button" value="Grabar" /></td>
				  <td colspan="2">&nbsp;</td>
		      </tr>
				<tr>
				  <td align="right">&nbsp;</td>
				  <td>&nbsp;</td>
				  <td colspan="2">&nbsp;</td>
			  </tr>
				<tr>
				  <td colspan="4" align="center" class="fondo_3">Hist&oacute;rico Evaluaciones</td>
			  </tr>
				<tr class="columna_subtitulo_resultados_mas_oscuro">
				  <td align="center">Usuario Creador</td>
				  <td align="center"># Evaluaci&oacute;n</td>
				  <td width="24%" align="center">Puntaje</td>
				  <td width="24%" align="center">Estado</td>
		      </tr>
				<tr>
				  <td align="center">&nbsp;</td>
				  <td align="center">&nbsp;</td>
				  <td align="center">&nbsp;</td>
				  <td align="center">&nbsp;</td>
		      </tr>        
			</table>        
		</td>
	</tr>
</table>
<input type="hidden" name="id_proveedor_arr_envia" id="id_proveedor_arr_envia" value="<?=arreglo_pasa_variables($id_proveedor_arr)?>" />
</body>
</html>
