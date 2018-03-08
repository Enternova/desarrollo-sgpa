<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr class="titulos_secciones">
    <td class="titulos_secciones">SECCION: Reportes - Contratos  </td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2"> 
  <tr>
    <td valign="top" id="carga_acciones_permitidas2"><table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
      <tr>
        <td colspan="4" class="fondo_3">Filtrar por:</td>
      </tr>
      <tr>
        <td width="24%" ><div align="right"><strong>Por Profesional de C&amp;C:</strong></div></td>
        <td width="24%" >
         <select name="especialista_bu" id="especialista_bu">
            <option value="0">Todos</option>
            <?
			
			$sel_profesionales = query_db("select DISTINCT(especialista) from  t7_contratos_contrato where especialista is not null and especialista <> 0");
			$profe_aplica=0;
			while($s_prof_sol = traer_fila_db($sel_profesionales)){
				$profe_aplica.=",".$s_prof_sol[0]; 
				}
			
          $sel_profss = query_db("select us_id, nombre_administrador from t1_us_usuarios where us_id in (".$profe_aplica.") order by nombre_administrador");
		  
		  
		  while($se_prof =traer_fila_db($sel_profss)){
		  ?>
            <option value="<?=$se_prof[0]?>" <? if( $especialista_bu ==$se_prof[0]) echo 'selected="selected"'?>  ><?=$se_prof[1]?></option>
            <?
		  }
		  ?>
            </select>
            </td>
        <td ><div align="right"><strong>Por proveedor/contratista</strong></div></td>
        <td ><input type="text" name="contratista_bu" id="contratista_bu" value="<?=$contratista_bu;?>" onkeypress="selecciona_lista_general_irre(this.name,'../librerias/php/proveedores_general.php')"/></td>
      </tr>
      <tr>
        <td align="right" ><strong>Por Gestor de Abastecimiento:</strong></td>
        <td ><select name="gestor_abste" id="gestor_abste" >
              <option value="0">Seleccione</option>
              
              <?
			  $sel_usuarios_gestores = query_db("select t1.us_id, t1.nombre_administrador from t1_us_usuarios t1, tseg12_relacion_usuario_rol t2 where t1.us_id = t2.id_usuario and t2.id_rol_general = 21 and t1.estado = 1");
			  while($sel_us_g = traer_fila_db($sel_usuarios_gestores)){
              ?>
              <option value="<?=$sel_us_g[0]?>" <? if($sel_us_g[0]==$gestor_abste){ echo "selected='selected'";} ?>><?=$sel_us_g[1]?></option>
              <?
			  }
			  ?>
              </select></td>
        <td >&nbsp;</td>
        <td >&nbsp;</td>
      </tr>
      <tr>
        <td ><div align="right"><strong>Por Gerente:</strong></div></td>
        <td ><input name="gerente_bu" type="text" id="gerente_bu" size="5" value="<?=$gerente_bu;?>" onkeypress="selecciona_lista_general_irre(this.name,'../librerias/php/usuarios_general.php')"/></td>
        <td ><div align="right"><strong>Por Objeto:</strong></div></td>
        <td ><input type="text" name="objeto_bu" id="objeto_bu" value="<?=$objeto_bu;?>"/></td>
        </tr>
      <tr>
        <td align="right" ><strong>Por Tipo Contrato:</strong></td>
        <td ><select name="tipo_contrato_bu" id="tipo_contrato_bu" >
          <option value="0">Seleccione</option>
          <option value="1" <? if($tipo_contrato_bu==1){ echo "selected='selected'";} ?> >Contrato Puntual</option>
          <option value="2" <? if($tipo_contrato_bu==2){ echo "selected='selected'";} ?> >Contrato Marco</option>
          <option value="3" <? if($tipo_contrato_bu==3){ echo "selected='selected'";} ?> >Oferta Mercantil</option>
        </select></td>
        <td align="right" ><strong>Por Estado:</strong></td>
        <td ><select name="estado_bu" id="estado_bu" >
          <?=listas("t7_contratos_estado", " estado = 1 ",15,'nombre', 1);?>
        </select></td>
        </tr>
      <tr>
        <td align="right" ><strong>Vigencia:</strong></td>
        <td ><select name="vigencia_bu" id="vigencia_bu">
          <option value="0" <? if($vigencia_bu==0){echo "selected='selected'";}?> >Todos</option>
          <option value="1" <? if($vigencia_bu==1){echo "selected='selected'";}?> >Vigentes</option>
          <option value="2" <? if($vigencia_bu==2){echo "selected='selected'";}?> >Finalizados</option>
        </select></td>
        <td >&nbsp;</td>
        <td align="right" >&nbsp;</td>
      </tr>
      <tr>
        <td align="right" >&nbsp;</td>
        <td >&nbsp;</td>
        <td width="14%" >&nbsp;</td>
        <td width="38%" align="right" >
        <strong onclick="abrir_ventana('../aplicaciones/reportes/reporte_contratos_excel.php?paginas='+this.value+'&contratista_bu='+document.getElementById('contratista_bu').value+'&especialista_bu='+document.getElementById('especialista_bu').value+'&objeto_bu='+document.getElementById('objeto_bu').value+'&gerente_bu='+document.getElementById('gerente_bu').value+'&estado_bu='+document.getElementById('estado_bu').value+'&tipo_contrato_bu='+document.getElementById('tipo_contrato_bu').value +'&gestor_abste='+document.getElementById('gestor_abste').value)" style="cursor:pointer">Generar Reporte en EXCEL <img src="../imagenes/mime/xlsx.gif"  /></strong>
        
        </td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td valign="top" id="reportes_div">&nbsp;</td>
  </tr>
</table>
</body>
</html>
