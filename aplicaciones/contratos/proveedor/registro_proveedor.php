<? include("../../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		
	$id = arreglo_pasa_variables(817);
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
					<td colspan="2"><?=$sel_pro_q[1].$digito;?></td>
				</tr>
				<tr>
					<td align="right">Contratista:</td>        
					<td colspan="2"><?=$sel_pro_q[3];?></td>
				</tr>
				<tr>
				  <td align="right">&nbsp;</td>
				  <td width="14%">&nbsp;</td>
				  <td>&nbsp;</td>
			  </tr>
				<tr>
				  <td colspan="3" align="center" class="fondo_3">Registro de Notificacion de evaluaciones</td>
			  </tr>
				<tr class="columna_subtitulo_resultados_mas_oscuro">
				  <td align="center">Fecha Notificacion</td>
				  <td align="center">Ingreso a Verificacion</td>
				  <td width="24%" align="center">&nbsp;</td>
			  </tr>
				<tr>
				  <td align="center">5/Mar/2014</td>
				  <td align="center">&nbsp;</td>
				  <td align="center"><input type="submit" name="button" id="button" value="Enviar Notificacion" /></td>
			  </tr>        
			</table>        
		</td>
	</tr>
</table>
<input type="hidden" name="id_proveedor_arr_envia" id="id_proveedor_arr_envia" value="<?=arreglo_pasa_variables($id_proveedor_arr)?>" />
</body>
</html>
