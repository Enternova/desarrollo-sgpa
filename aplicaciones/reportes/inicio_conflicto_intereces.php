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
    <td class="titulos_secciones">SECCION: Reportes - Conflicto de Intereces</td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2"> 
  <!--<tr>
    <td valign="top" id="carga_acciones_permitidas2"><table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
      <tr>
        <td colspan="4" class="fondo_3">Filtrar por:</td>
      </tr>
      <tr>
        <td width="24%" ><p align="right"><strong>Por consecutivo contrato:</strong></p></td>
        <td width="24%" ><label>
          <input type="text" name="contrato_bu" id="contrato_bu" value="<?=$contrato_bu;?>"/>
        </label></td>
        <td ><div align="right"><strong>Por proveedor/contratista</strong></div></td>
        <td ><input type="text" name="contratista_bu" id="contratista_bu" value="<?=$contratista_bu;?>" onkeypress="selecciona_lista_general_irre(this.name,'../librerias/php/proveedores_general.php')"/></td>
      </tr>
      <tr>
        <td ><div align="right"><strong>Por Especialista:</strong></div></td>
        <td ><input name="especialista_bu" type="text" id="especialista_bu" size="5" value="<?=$especialista_bu;?>" onkeypress="selecciona_lista_general_irre(this.name,'../librerias/php/usuarios_general.php')"/></td>
        <td ><div align="right"><strong>Por Objeto:</strong></div></td>
        <td ><input type="text" name="objeto_bu" id="objeto_bu" value="<?=$objeto_bu;?>"/></td>
      </tr>
      <tr>
        <td ><div align="right"><strong>Por Gerente:</strong></div></td>
        <td ><input name="gerente_bu" type="text" id="gerente_bu" size="5" value="<?=$gerente_bu;?>" onkeypress="selecciona_lista_general_irre(this.name,'../librerias/php/usuarios_general.php')"/></td>
        <td align="right" ><strong>Por Estado:</strong></td>
        <td ><select name="estado_bu" id="estado_bu" >
				<option value="0">Seleccione</option>
                <option value="1" <? if($estado_bu==1){ echo "selected='selected'";} ?> >Elaboracion de Contrato</option>
                <option value="2" <? if($estado_bu==2){ echo "selected='selected'";} ?> >Recibido Abastecimiento</option>
                <option value="3" <? if($estado_bu==3){ echo "selected='selected'";} ?>>SAP</option>
                <option value="4" <? if($estado_bu==4){ echo "selected='selected'";} ?>>Revision Legal</option>
                <option value="5" <? if($estado_bu==5){ echo "selected='selected'";} ?>>Firma Representante Legal Hocol</option>
                <option value="6" <? if($estado_bu==6){ echo "selected='selected'";} ?>>Firma Representante Legal Contratista</option>
                <option value="7" <? if($estado_bu==7){ echo "selected='selected'";} ?>>Revision Polizas</option>
                <option value="8" <? if($estado_bu==8){ echo "selected='selected'";} ?>>Gerente Contrato</option>
                <option value="9" <? if($estado_bu==9){ echo "selected='selected'";} ?>>Legalizacion Final Contrato</option>
               
                <option value="10" <? if($estado_bu==10){ echo "selected='selected'";} ?>>Legalizado</option>
              <option value="101" <? if($estado_bu==101){ echo "selected='selected'";} ?>>En Legalizaci&oacute;n</option>

          
        	</select></td>
      </tr>
      <tr>
        <td align="right" ><strong>Aplica portales</strong>:</td>
        <td ><select name="aplica_portales_bu" id="aplica_portales_bu">
          <option value="0" <? if($aplica_portales_bu==1){echo "selected='selected'";}?> >Seleccione</option>
          <option value="1" <? if($aplica_portales_bu==1){echo "selected='selected'";}?> >SI</option>
          <option value="2" <? if($aplica_portales_bu==2){echo "selected='selected'";}?> >NO</option>
        </select></td>
        <td align="right" ><strong>Destino</strong>:</td>
        <td ><select name="destino_bu" id="destino_bu">
          <?=listas($g25, " estado = 1 ",$destino_bu,'nombre', 1);?>
        </select></td>
      </tr>
      <tr>
        <td align="right" ><strong>Por Tipo Contrato:</strong></td>
        <td ><select name="tipo_contrato_bu" id="tipo_contrato_bu" >
          <option value="0">Seleccione</option>
          <option value="1" <? if($tipo_contrato_bu==1){ echo "selected='selected'";} ?> >Normal</option>
          <option value="2" <? if($tipo_contrato_bu==2){ echo "selected='selected'";} ?> >Contrato Marco</option>
        </select></td>
        <td align="right" ><strong>Visualizacion de Contratos:</strong></td>
        <td align="left" ><select name="visualiza_con" id="visualiza_con" >
          <? 

	  $sel_areas = query_db("SELECT id_usuario FROM " . $ts5 . " WHERE id_permiso = 8 AND id_usuario = '" . $_SESSION['id_us_session'] . "'");
	  if(!traer_fila_db($sel_areas)){		  ?>
          <option value="1" <? if($visualiza_con==1 or $visualiza_con=""){ echo "selected='selected'";} ?> >Mis Contratos</option>

		  <?
		  }
		  ?>
          <option value="2" <? if($visualiza_con==2){ echo "selected='selected'";} ?> >Todos los Contratos</option>         
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
      </tr>-->
      <tr>
        <td align="right" >&nbsp;</td>
        <td >&nbsp;</td>
        <td width="14%" >&nbsp;</td>
        <td width="38%" align="right" ><A href="javascript:document.location.target='_blank';document.location.href='../aplicaciones/reportes/conflicto_intereces.php'">Generar Reporte en EXCEL <img src="../imagenes/mime/xlsx.gif"  /></A>
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
