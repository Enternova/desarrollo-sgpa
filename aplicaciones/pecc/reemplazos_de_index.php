<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	$sel_gerente = traer_fila_row(query_db("select * from $g1 where us_id =".$sel_item[3]));	
	
	$gerente_contrato = "-".$sel_gerente[1]."----,".$sel_gerente[0]."----, ";
	
/*
	$sel_secuencia = query_db("select * from t2_agl_secuencia_solicitud where id_item_pecc = ".$id_item_pecc." and estado = 1");
	while($sel_s = traer_fila_db($sel_secuencia)){
			$sel_usuario = traer_fila_row(query_db("select id_usuario_original from t2_agl_secuencia_solicitud_usuario where id_secuencia_solicitud = ".$sel_s[0]." and estado = 1"));
			if($sel_usuario[0] > 0 and $sel_usuario[0] != ""){
			$us_aplica.=",".$sel_usuario[0]; 
			}
		}
		
	*/
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td valign="top"><table width="100%" border="0" align="center" class="tabla_lista_resultados">
      
      <tr>
        <td width="54%" valign="top"><table width="100%" border="0" class="tabla_lista_resultados">
          <tr>
            <td colspan="2" class="letra-descuentos">Antes de agregar un reemplazo por favor revisar la cartelera de ausencias y reemplazos de HOCOL S.A. e incluir la informaci&oacute;n correctamente, teniendo en cuenta que esto afecta el flujo de aprobaciones del SGPA. <strong><font color="#0033FF"> HAGA CLICK AQUI PARA VER LA CARTELERA DE AUSENCIAS Y REEMPLAZOS</font></strong></td>
            </tr>
          <tr class="fondo_3">
            <td colspan="2" align="center">Nuevo Reemplazo</td>
            </tr>
          <tr>
            <td width="50%" align="right">Funcionario que se Ausentar&aacute; o Ast&aacute; Ausente:</td>
            <td width="50%"><input type="text" name="usuario_permiso" id="usuario_permiso" onkeypress="selecciona_lista()"/></td>
            </tr>
          <tr>
            <td align="right">Funcionario que lo Reemplaza:</td>
            <td><input type="text" name="usuario_permiso2" id="usuario_permiso2" onkeypress="selecciona_lista()"/></td>
          </tr>
          <tr>
            <td align="right">Desde Cu&aacute;ndo:</td>
            <td><input type="text" name="fecha_desde_cuando" id="fecha_desde_cuando"  onmousedown="calendario_sin_hora('fecha_desde_cuando')" /></td>
            </tr>
          <tr>
            <td align="right">Hasta Cu&aacute;ndo:</td>
            <td><input type="text" name="fecha_hasta_cuando" id="fecha_hasta_cuando"  onmousedown="calendario_sin_hora('fecha_hasta_cuando')"/></td>
            </tr>
          <tr>
            <td align="right">Observaci&oacute;n:</td>
            <td><textarea name="ob_reemplazo" id="ob_reemplazo"></textarea></td>
            </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td><span class="letra-descuentos">* Confirmo que he revisado la cartelera de ausencias y reemplazos  (soporte oficial para registrar reemplazos) publicado en la intranet de HOCOL  S.A.
                </p>
            </span></td>
          </tr>
          <tr>
            <td align="right">&nbsp;</td>
            <td><input type="button" value="Agregar Reemplazo" onclick="agrega_reemplazo('')" /></td>
            </tr>
          </table>
          <table width="100%" border="0" class="tabla_lista_resultados">
            <tr class="fondo_3">
              <td align="center">Funcionario Ausente</td>
              <td align="center">Funcionario que lo Reemplaza</td>
              <td align="center">Desde Cu&aacute;ndo</td>
              <td align="center">Hasta Cu&aacute;ndo</td>
              <td align="center">Observaci&oacute;n</td>
              <td align="center">Usuario que Cre&oacute; el Reemplazo</td>
              <td align="center">Fecha Log de Creaci&oacute;n</td>
              </tr>
            <?
		
            $sel_remplazos = query_db("select us_ausente, us_reemplaza, desde_cuando, hasta_cuando, CAST(observacion as TEXT), usuario_creacion, fecha_creacion from v_reemplazos where estado = 1  order by id desc");
			while($sel_rem = traer_fila_db($sel_remplazos)){
				
				if($class == ""){
					$class = 'class="filas_resultados"';
					}else{
						$class = '';
						}
			?>
            <tr <?=$class?>>
              <td><?=$sel_rem[0]?></td>
              <td><?=$sel_rem[1]?></td>
              <td><?=$sel_rem[2]?></td>
              <td><?=$sel_rem[3]?></td>
              <td><?=$sel_rem[4]?></td>
              <td><?=$sel_rem[5]?></td>
              <td><?=$sel_rem[6]?></td>
              </tr>
            <?
			}
			?>
            </table>
          <p>&nbsp;</p></td>
        </tr>
      
    </table></td>
  </tr>
</table>
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="nuevo_estdo_edita" id="nuevo_estdo_edita" value="" />
</body>
</html>
