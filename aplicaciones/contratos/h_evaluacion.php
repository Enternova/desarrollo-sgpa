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
	
      if($sql_tipo[0]==2){
	  $col = 2;
	  }else{
		$col = 1; 
		}

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
echo imprime_cabeza_contrato($id_contrato)
?>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
	<tr >
    	<td valign="top" id="fila_evaluacion_1">
        	<table width="100%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
                <tr >
                    <td class="fondo_4">Evaluaciones Cumplimiento tecnico</td>
                     <?
                    if($sql_tipo[0]==2){
                    ?>
                    <td width="27%" align="center" class="fondo_4"><select name="orden_trabajo" id="orden_trabajo">
                      <option value="0">Seleccione</option>
                      <?
	 $lista_poliza = "select t7c.id,t1t.nombre,t7c.numero_otrosi from $co4 t7c left join $g8 t1t on t7c.tipo_complemento = t1t.id where id_contrato = $id_contrato_arr and t7c.tipo_complemento = 2";
		$sql_poliza=query_db($lista_poliza);
		while($lista_poliza=traer_fila_row($sql_poliza)){			
		?>
                      <option value="<?=$lista_poliza[0];?>" <?=$sel;?>>
                      <?=$lista_poliza[1];?> <?="No ".$lista_poliza[2];?>
                      </option>
                      <?
		}
		?>
                  </select></td>
                   
                    <?
                    }
                    ?>
                     <td class="fondo_4"><span onclick="javascript:document.getElementById('fila_evaluacion_1').style.display = 'none';ajax_carga('../aplicaciones/contratos/c_evaluacion_grupo.php?id_grupo=1','fila_evaluacion_2')" style="cursor:pointer">Crear Evaluaci&oacute;n</span></td>
                    <td class="fondo_4">&nbsp;</td>
                </tr>
                <tr>
                    <td width="27%" align="center" class="fondo_3"><div align="center">#Evaluaci&oacute;n</div></td>
                    <?
                    if($sql_tipo[0]==2){
                    ?>
                    <td width="27%" align="center" class="fondo_3">Orden de Trabajo</td>
                    
                    <?
                    }
                    ?>
                    <td width="25%" align="center" class="fondo_3">Estado</td>
                    <td width="21%" align="center" class="fondo_3">Usuario Creador</td>
                </tr>
                <tr>
                  <td align="center"><span onclick="javascript:document.getElementById('fila_evaluacion_1').style.display = 'none';ajax_carga('../aplicaciones/contratos/c_evaluacion_grupo.php?id_grupo=1&id_evaluacion=1','fila_evaluacion_2')" style="cursor:pointer">1</span></td><?
                    if($sql_tipo[0]==2){
                    ?>
                  <td align="center">S13-0666</td>
                  <?
					}
				  ?>
                  <td align="center">Aprobado</td>
                  <td align="center">&nbsp;</td>
                </tr>
                <tr>
                  <td align="center"><span onclick="javascript:document.getElementById('fila_evaluacion_1').style.display = 'none';ajax_carga('../aplicaciones/contratos/c_evaluacion_grupo.php?id_grupo=1&id_evaluacion=2','fila_evaluacion_2')" style="cursor:pointer">2</span></td>
                  <?
                    if($sql_tipo[0]==2){
                    ?>
                  <td align="center">S13-1028</td>
                  <?
					}
				  ?>
                  <td align="center">Gerente Contrato</td>
                  <td align="center">&nbsp;</td>
                </tr>
            </table>
            <BR />
            <table width="100%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
              <tr >
                <td class="fondo_4">Evaluaciones Cumplimiento adiministrativo</td>
                <?
                    if($sql_tipo[0]==2){
                    ?>
                <td width="27%" align="center" class="fondo_4"><select name="orden_trabajo2" id="orden_trabajo2">
                  <option value="0">Seleccione</option>
                  <?
	 $lista_poliza = "select t7c.id,t1t.nombre,t7c.numero_otrosi from $co4 t7c left join $g8 t1t on t7c.tipo_complemento = t1t.id where id_contrato = $id_contrato_arr and t7c.tipo_complemento = 2";
		$sql_poliza=query_db($lista_poliza);
		while($lista_poliza=traer_fila_row($sql_poliza)){			
		?>
                  <option value="<?=$lista_poliza[0];?>" <?=$sel;?>>
                    <?=$lista_poliza[1];?>
                    <?="No ".$lista_poliza[2];?>
                  </option>
                  <?
		}
		?>
                </select></td>
                <?
                    }
                    ?>
                <td class="fondo_4"><span onclick="javascript:document.getElementById('fila_evaluacion_1').style.display = 'none';ajax_carga('../aplicaciones/contratos/c_evaluacion_grupo.php?id_grupo=1','fila_evaluacion_2')" style="cursor:pointer">Crear Evaluaci&oacute;n</span></td>
                <td class="fondo_4">&nbsp;</td>
              </tr>
              <tr>
                <td width="27%" align="center" class="fondo_3"><div align="center">#Evaluaci&oacute;n</div></td>
                <?
                    if($sql_tipo[0]==2){
                    ?>
                <td width="27%" align="center" class="fondo_3">Orden de Trabajo</td>
                <?
                    }
                    ?>
                <td width="25%" align="center" class="fondo_3">Estado</td>
                <td width="21%" align="center" class="fondo_3">Usuario Creador</td>
              </tr>
            </table>
            <BR />
            <table width="100%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
              <tr >
                <td class="fondo_4">Evaluaciones HSE</td>
                <?
                    if($sql_tipo[0]==2){
                    ?>
                <td width="27%" align="center" class="fondo_4">&nbsp;</td>
                <?
                    }
                    ?>
                <td class="fondo_4">&nbsp;</td>
                <td class="fondo_4">&nbsp;</td>
              </tr>
              <tr>
                <td width="27%" align="center" class="fondo_3"><div align="center">#Evaluaci&oacute;n</div></td>
                <?
                    if($sql_tipo[0]==2){
                    ?>
                <td width="27%" align="center" class="fondo_3">Orden de Trabajo</td>
                <?
                    }
                    ?>
                <td width="25%" align="center" class="fondo_3">Estado</td>
                <td width="21%" align="center" class="fondo_3">Usuario Creador</td>
              </tr>
            </table>            <BR />
        </td>
    </tr>
    <tr >
    	<td valign="top" id="fila_evaluacion_2">&nbsp;</td>
  	</tr>
</table>

<input name="id_documento" type="hidden" value="<?=$id_documento;?>" />

</body>
</html>
