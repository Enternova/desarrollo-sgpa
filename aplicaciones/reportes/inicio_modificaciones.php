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
                <td class="titulos_secciones">SECCION: Reporte Modificaciones de Contratos</td>
            </tr>
        </table>
        <table width="100%" border="0" cellpadding="2" cellspacing="2"> 
            <tr>
                <td valign="top" id="carga_acciones_permitidas2"><table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
                        <tr>
                            <td colspan="4" class="fondo_2">Buscador de contratos</td>
                        </tr>
                        <tr>
                            <td width="24%" ><p align="right"><strong>Por consecutivo contrato:</strong></p></td>
                            <td width="24%" ><label>
                                    <input type="text" name="contrato_bu" id="contrato_bu" value="<?= $contrato_bu; ?>"/>
                                </label></td>
                            <td width="14%" ><div align="right"><strong>Por proveedor/contratista</strong></div></td>
                            <td width="34%" ><input type="text" name="contratista_bu" id="contratista_bu" value="<?= $contratista_bu; ?>" onkeypress="selecciona_lista_general_irre(this.name, '../librerias/php/proveedores_general.php')"/></td>
                        </tr>
                        <tr>
                            <td ><div align="right"><strong>Por Especialista:</strong></div></td>
                            <td ><input name="especialista_bu" type="text" id="especialista_bu" size="5" value="<?= $especialista_bu; ?>" onkeypress="selecciona_lista_general_irre(this.name, '../librerias/php/usuarios_general.php')"/></td>
                            <td ><div align="right"><strong>Por Objeto:</strong></div></td>
                            <td ><input type="text" name="objeto_bu" id="objeto_bu" value="<?= $objeto_bu; ?>"/></td>
                        </tr>
                        <tr>
                            <td ><div align="right"><strong>Por Gerente:</strong></div></td>
                            <td ><input name="gerente_bu" type="text" id="gerente_bu" size="5" value="<?= $gerente_bu; ?>" onkeypress="selecciona_lista_general_irre(this.name, '../librerias/php/usuarios_general.php')"/></td>
                            <td ><div align="right"><strong>Por Area Usuaria:</strong></div></td>
                            <td><select name="area_bu" id="area_bu">
                                	<?=listas($g12, " estado = 1",$area_bu ,'nombre', 1);?>
                                </select>
                            </td>
                        </tr>

                        <tr>
                            <td align="right" ><strong>Por Tipo Contrato:</strong></td>
                            <td ><select name="tipo_contrato_bu" id="tipo_contrato_bu" >
                                    <option value="0">Seleccione</option>
                                    <option value="1" <?php if($tipo_contrato_bu==1){ echo "selected='selected'";} ?> >Normal</option>
                                    <option value="2" <?php if($tipo_contrato_bu==2){ echo "selected='selected'";} ?> >Contrato Marco</option>
                                </select></td>
                            <td >&nbsp;</td>
                            <td align="right" >&nbsp;</td>
                        </tr>
                        <tr>
                            <td >&nbsp;</td>
                            <td align="right"><input name="button" type="button" class="boton_grabar" id="button" value="Generar" onclick="ajax_carga('../aplicaciones/reportes/reporte_modificaciones.php?paginas=' + this.value + '&      contrato_bu=' + document.principal.contrato_bu.value + '&     contratista_bu=' + document.principal.contratista_bu.value + '&     especialista_bu=' + document.principal.especialista_bu.value+'&gerente_bu='+document.getElementById('gerente_bu').value + '&objeto_bu=' + document.principal.objeto_bu.value + '&tipo_contrato_bu=' + document.principal.tipo_contrato_bu.value + '&area_bu=' + document.principal.area_bu.value, 'reportes_div')"/></td>
                            <td>&nbsp;</td>
                            <td>&nbsp;</td>
                        </tr>
                    </table></td>
            </tr>
            <tr>
                <td valign="top" id="reportes_div">&nbsp;</td>
            </tr>
        </table>
    </body>
</html>
