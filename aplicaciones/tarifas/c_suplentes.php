<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		


	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));	
$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));	



$busca_sumpletes_responsable = "select tipo_suplencia, us_id from t6_tarifas_suplentes_aprobadores where tarifas_contrato_id = $id_contrato_arr and us_id = ".$_SESSION["id_us_session"]." and tipo_suplencia = 2 and   estado = 1 and fecha_suplencia >= '$fecha'";
$sql_suplente=traer_fila_row(query_db($busca_sumpletes_responsable));

	if($sql_suplente[0]==2){//si es gerente_item
			 $permiso_ver_admin = 1;		
		}		
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="91%" class="titulos_secciones_tarifas">SECCION:<span class="titulos_resaltado_procesos_tarifas"> ADMINISTRACION DE REEMPLAZOS DE APROBACION &gt;&gt; CONTRATO:
      <?=numero_cotnrato_tarifas($id_contrato_arr);?>
    </span></td>
    <td width="9%" ><input type="button" name="button" class="boton_volver"  id="button" value="Volver al contrato" onclick="ajax_carga('../aplicaciones/tarifas/v_contratos.php?id_contrato=<?=arreglo_pasa_variables($id_contrato);?>','carga_acciones_permitidas')" /></td>
  </tr>
  <tr>
    <td colspan="2" ><? echo encabezado_contrato_tarifas($id_contrato_arr);?></td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top">
            <?
   	$busca_permisos_roles = traer_fila_row(query_db("select id_rol from v_relacion_roles_usuarios where us_id = ".$_SESSION["id_us_session"]." and ( id_rol = 1 or id_rol = 1300) "));
     if( ($busca_permisos_roles[0]>=1) || ($permiso_ver_admin==1) ){
	 
	 ?>
    <table width="99%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
      <tr >
        <td colspan="3" class="fondo_4">Creaci&oacute;n de reemplazos de aprobaci&oacute;n</td>
      </tr>
      <tr>
        <td colspan="3" class="fondo_3"><div align="center">Detalle</div></td>
        </tr>
      <tr>
        <td width="21%"><div align="right"><strong>Usuario:</strong></div></td>
        <td width="21%"><select name="usuario_suplente">
        <option value="0">seleccione</option>
        <?=listas_sin_seleccione($g1, " estado = 1 and tipo_usuario <> 2 ",$seleccion,"nombre_administrador", 1);?>
        </select></td>
        <td width="21%">&nbsp;</td>
        </tr>
      <tr>
        <td align="right"><strong>Roll:</strong></td>
        <td><select name="roll_suplente">
         <option value="0">seleccione</option>
        	<?=listas_sin_seleccione("t6_tarifas_tipo_suplentes", " t6_tarifas_tipo_suplentes_id >=1 ",$seleccion,"nombre", 1);?>
        </select></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right"><strong>Fecha de vigencia:</strong></td>
        <td><input type="text" name="fecha_inicial" id="fecha_inicial" value="<?=$fecha_inicial;?>"  onmousedown="calendario_sin_hora('fecha_inicial')" /></td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3"><div align="right">
            <input name="button2" type="button" class="boton_grabar" id="button2" value="Crear nuevo reemplazo" onclick="crea_suplentes()" />
        </div></td>
      </tr>
    </table>
      <? } //si tiene descuentos ?>
      <br />
      <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr >
          <td colspan="4" class="fondo_4">Historico de  reemplazo para este contrato</td>
        </tr>
        <tr>
          <td width="14%" class="fondo_3"><div align="center">Fecha de vigencia</div></td>
          <td width="66%" class="fondo_3"><div align="center">Usuario</div></td>
          <td width="9%" class="fondo_3">Roll</td>
          <td width="4%" class="fondo_3">&nbsp;</td>
        </tr>
        
<?
	$busca_descuneto = query_db("select * from v_tarifas_suplentes where tarifas_contrato_id = $id_contrato_arr and estado = 1 order by t6_tarifas_tipo_suplentes_id ");
	while($traer_descvuentos = traer_fila_row($busca_descuneto)){

?>
        
        <tr class="filas_resultados">
          <td class="filas_resultados"><?=$traer_descvuentos[6];?></td>
          <td class="filas_resultados"><?=$traer_descvuentos[4];?></td>
          <td class="titulos_resumen_alertas"><?=$traer_descvuentos[9];?></td>
          <td class="titulos_resumen_alertas">
                     <?
		     if( ($busca_permisos_roles[0]>=1) || ($permiso_ver_admin==1) ){
	 	 		?>
          <img src="../imagenes/botones/b_cancelar.gif" alt="Eliminar descuento" title="Eliminar descuento" width="16" height="16" onclick="elimina_suplentes(<?=$traer_descvuentos[0];?>)" />
          <? } ?>
          </td>
        </tr>
        <? } ?>
      </table></td>
  </tr>
</table>
<input type="hidden" name="id_suplente" />

</body>
</html>
