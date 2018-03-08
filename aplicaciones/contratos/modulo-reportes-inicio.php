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
    <td class="titulos_secciones">SECCION: REPORTES</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="2"> 
  <tr>
    <td valign="top" id="carga_acciones_permitidas2"><table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
      <tr>
        <td colspan="5" class="fondo_2">Buscador de contratos</td>
      </tr>
      <tr>
        <td width="18%" ><p align="right"><strong>Por consecutivo contrato:</strong></p></td>
        <td width="32%" ><label>
          <input type="text" name="contrato_bu" id="contrato_bu" value="<?=$contrato_bu;?>"/>
        </label></td>
        <td width="12%" ><div align="right"><strong>Por proveedor/contratista</strong></div></td>
        <td colspan="2" ><input type="text" name="contratista_bu" id="contratista_bu" value="<?=$contratista_bu;?>" onkeypress="selecciona_lista_general_irre(this.name,'../librerias/php/proveedores_general.php')"/></td>
      </tr>
      <tr>
        <td ><div align="right"><strong>Por Especialista:</strong></div></td>
        <td ><input name="especialista_bu" type="text" id="especialista_bu" size="5" value="<?=$especialista_bu;?>" onkeypress="selecciona_lista_general_irre(this.name,'../librerias/php/usuarios_general.php')"/></td>
        <td ><div align="right"><strong>Por Objeto:</strong></div></td>
        <td colspan="2" ><input type="text" name="objeto_bu" id="objeto_bu" value="<?=$objeto_bu;?>"/></td>
      </tr>
      <tr>
        <td ><div align="right"><strong>Por Gerente:</strong></div></td>
        <td ><input name="gerente_bu" type="text" id="gerente_bu" size="5" value="<?=$gerente_bu;?>" onkeypress="selecciona_lista_general_irre(this.name,'../librerias/php/usuarios_general.php')"/></td>
        <td align="right" ><strong>Por Estado:</strong></td>
        <td colspan="2" ><select name="estado_bu" id="estado_bu" >
				<option value="0">Seleccione</option>
                <option value="1" <? if($estado_bu==1){ echo "selected='selected'";} ?> >Elaboracion de Contrato</option>
                <option value="15" <? if($estado_bu==15){ echo "selected='selected'";} ?>>En Legalizaci&oacute;n</option>
                <option value="25" <? if($estado_bu==25){ echo "selected='selected'";} ?> >Legalizado Pendiente Aseguramiento</option>
                <option value="48" <? if($estado_bu==48){ echo "selected='selected'";} ?>>Legalizado</option>
                <option value="49" <? if($estado_bu==49){ echo "selected='selected'";} ?>>Finalizado</option>
                <option value="50" <? if($estado_bu==50){ echo "selected='selected'";} ?>>Eliminado</option>
                
              

          
        	</select></td>
      </tr>
      <tr>
        <td align="right" ><strong>Por Tipo Contrato:</strong></td>
        <td ><select name="tipo_contrato_bu" id="tipo_contrato_bu" >
          <option value="0">Seleccione</option>
          <option value="1" <? if($tipo_contrato_bu==1){ echo "selected='selected'";} ?> >Normal</option>
          <option value="2" <? if($tipo_contrato_bu==2){ echo "selected='selected'";} ?> >Contrato Marco</option>
        </select></td>
        <td align="right" >Contratos:</td>
        <td width="3%" align="left" ><input type="checkbox" name="c_contrato" id="c_contrato" value="1" checked="checked"/></td>
        <td width="35%" align="left" >        </td>
      </tr>
      <tr>
        <td align="right" ><strong>Aplica portales</strong>:</td>
        <td ><select name="aplica_portales_bu" id="aplica_portales_bu">
          <option value="0" <? if($aplica_portales_bu==1){echo "selected='selected'";}?> >Seleccione</option>
          <option value="1" <? if($aplica_portales_bu==1){echo "selected='selected'";}?> >SI</option>
          <option value="2" <? if($aplica_portales_bu==2){echo "selected='selected'";}?> >NO</option>
        </select></td>
        <td align="right" >Orden de Trabajo:      </td>
        <td align="left" ><input type="checkbox" name="c_orden_trabajo" id="c_orden_trabajo" value="1" checked="checked"/>      </td>
        <td align="left" >        </td>
      </tr>
      <tr>
        <td align="right" ><strong>Destino</strong>:</td>
        <td ><select name="destino_bu" id="destino_bu">
          <?=listas($g25, " estado = 1 ",$destino_bu,'nombre', 1);?>
        </select></td>
        <td align="right" >OtroSi:       </td>
        <td align="left" ><input type="checkbox" name="c_otrosi" id="c_otrosi" value="1" checked="checked"/>    </td>    
        <td align="left" >        </td>
      </tr>
      <tr>
        <td align="right" ><strong>Vigencia:</strong></td>
        <td ><select name="vigencia_bu" id="vigencia_bu">
          <option value="0" <? if($vigencia_bu==0){echo "selected='selected'";}?> >Todos</option>
          <option value="1" <? if($vigencia_bu==1){echo "selected='selected'";}?> >Vigentes</option>
          <option value="2" <? if($vigencia_bu==2){echo "selected='selected'";}?> >Finalizados</option>
        </select></td>
        <td align="right" >&nbsp;</td>
        <td align="right" >&nbsp;</td>
        <td align="right" >&nbsp;</td>
      </tr>
      <tr>
        <td colspan="5" align="right" >
        <input name="button4" type="button" class="boton_grabar" id="button4" value="Generar Polizas" onclick="ajax_carga('../aplicaciones/contratos/reportes/historico_contrato_pol.php?paginas='+this.value+'&amp;      contrato_bu='+document.principal.contrato_bu.value+'&amp;     contratista_bu='+document.principal.contratista_bu.value+'&amp;     especialista_bu='+document.principal.especialista_bu.value+'&amp;     objeto_bu='+document.principal.objeto_bu.value+'&amp;     gerente_bu='+document.principal.gerente_bu.value+'&amp;     estado_bu='+document.principal.estado_bu.value+'&amp;c_contrato='+document.principal.c_contrato.checked+'&amp;c_otrosi='+document.principal.c_otrosi.checked+'&amp;c_orden_trabajo='+document.principal.c_orden_trabajo.checked+'&amp;tipo_contrato_bu='+document.principal.tipo_contrato_bu.value+'&amp;aplica_portales_bu='+document.principal.aplica_portales_bu.value+'&destino_bu='+document.principal.destino_bu.value+'&vigencia_bu='+document.principal.vigencia_bu.value,'reportes_div')"/>
        <input name="button4" type="button" class="boton_grabar" id="button4" value="Generar OT" onclick="ajax_carga('../aplicaciones/contratos/reportes/ot.php?paginas='+this.value+'&amp;      contrato_bu='+document.principal.contrato_bu.value+'&amp;     contratista_bu='+document.principal.contratista_bu.value+'&amp;     especialista_bu='+document.principal.especialista_bu.value+'&amp;     objeto_bu='+document.principal.objeto_bu.value+'&amp;     gerente_bu='+document.principal.gerente_bu.value+'&amp;     estado_bu='+document.principal.estado_bu.value+'&amp;c_contrato='+document.principal.c_contrato.checked+'&amp;c_otrosi='+document.principal.c_otrosi.checked+'&amp;c_orden_trabajo='+document.principal.c_orden_trabajo.checked+'&amp;tipo_contrato_bu='+document.principal.tipo_contrato_bu.value+'&amp;aplica_portales_bu='+document.principal.aplica_portales_bu.value+'&amp;destino_bu='+document.principal.destino_bu.value+'&vigencia_bu='+document.principal.vigencia_bu.value,'reportes_div')"/>
          
          <!--
          <input name="button3" type="button" class="boton_grabar" id="button3" value="Evaluaciones" onclick="ajax_carga('../aplicaciones/contratos/reportes/evaluacion.php?paginas='+this.value+'&contrato_bu='+document.principal.contrato_bu.value+'&  contratista_bu='+document.principal.contratista_bu.value+'&especialista_bu='+document.principal.especialista_bu.value+'&objeto_bu='+document.principal.objeto_bu.value+'&gerente_bu='+document.principal.gerente_bu.value+'&estado_bu='+document.principal.estado_bu.value+'&tipo_contrato_bu='+document.principal.tipo_contrato_bu.value+'&aplica_portales_bu='+document.principal.aplica_portales_bu.value+'&destino_bu='+document.principal.destino_bu.value,'reportes_div')"/>
       
        -->
        <input name="button" type="button" class="boton_grabar" id="button" value="Generar Legalizacion" onclick="ajax_carga('../aplicaciones/contratos/reportes/legalizacion.php?paginas='+this.value+'&      contrato_bu='+document.principal.contrato_bu.value+'&     contratista_bu='+document.principal.contratista_bu.value+'&     especialista_bu='+document.principal.especialista_bu.value+'&     objeto_bu='+document.principal.objeto_bu.value+'&     gerente_bu='+document.principal.gerente_bu.value+'&     estado_bu='+document.principal.estado_bu.value+'&c_contrato='+document.principal.c_contrato.checked+'&c_otrosi='+document.principal.c_otrosi.checked+'&c_orden_trabajo='+document.principal.c_orden_trabajo.checked+'&tipo_contrato_bu='+document.principal.tipo_contrato_bu.value+'&aplica_portales_bu='+document.principal.aplica_portales_bu.value+'&destino_bu='+document.principal.destino_bu.value+'&vigencia_bu='+document.principal.vigencia_bu.value,'reportes_div')"/>
        <input name="button2" type="button" class="boton_grabar" id="button2" value="Fechas Legalizacion" onclick="ajax_carga('../aplicaciones/contratos/reportes/fechas.php?paginas='+this.value+'&amp;      contrato_bu='+document.principal.contrato_bu.value+'&amp;     contratista_bu='+document.principal.contratista_bu.value+'&amp;     especialista_bu='+document.principal.especialista_bu.value+'&amp;     objeto_bu='+document.principal.objeto_bu.value+'&amp;     gerente_bu='+document.principal.gerente_bu.value+'&amp;     estado_bu='+document.principal.estado_bu.value+'&amp;c_contrato='+document.principal.c_contrato.checked+'&amp;c_otrosi='+document.principal.c_otrosi.checked+'&amp;c_orden_trabajo='+document.principal.c_orden_trabajo.checked+'&amp;tipo_contrato_bu='+document.principal.tipo_contrato_bu.value+'&aplica_portales_bu='+document.principal.aplica_portales_bu.value+'&destino_bu='+document.principal.destino_bu.value+'&vigencia_bu='+document.principal.vigencia_bu.value,'reportes_div')"/>
<input name="button" type="button" class="boton_grabar" id="button" value="Generar Marco" onclick="ajax_carga('../aplicaciones/contratos/reportes/marco.php?paginas='+this.value+'&      contrato_bu='+document.principal.contrato_bu.value+'&     contratista_bu='+document.principal.contratista_bu.value+'&     especialista_bu='+document.principal.especialista_bu.value+'&     objeto_bu='+document.principal.objeto_bu.value+'&     gerente_bu='+document.principal.gerente_bu.value+'&     estado_bu='+document.principal.estado_bu.value+'&tipo_contrato_bu='+document.principal.tipo_contrato_bu.value+'&aplica_portales_bu='+document.principal.aplica_portales_bu.value+'&destino_bu='+document.principal.destino_bu.value+'&vigencia_bu='+document.principal.vigencia_bu.value,'reportes_div')"/>
        
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
