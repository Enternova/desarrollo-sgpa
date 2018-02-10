<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');

	
if($categoria_bu!="")
	$complemento.=	" and categoria like '%$categoria_bu%'";	

if($grupo_bu!="")
	$complemento.=	" and grupo like '%$grupo_bu%'";		
	
if($detalle_bu!="")
	$complemento.=	" and detalle like '%$detalle_bu%'";
	
if($contratista_bu!="")
	$complemento.=	" and razon_social like '%$contratista_bu%'";

	
if($vigencia_bu==1)
	$complemento.=	"   and vigencia_mes >= '$fecha' ";		

if($vigencia_bu==2)
	$complemento.=	" and vigencia_mes <= '$fecha' ";	
	
if($vigencia_bu==3)
	$complemento.=	" and id >=1 ";	

if($vigencia_bu==0)
	$complemento_vigenc.=	"   and vigencia_mes >= '$fecha' ";		




	$complemento_final.=	" where t6_tarifas_estados_contratos_id not in (1,2) ";	

	$where_final = $complemento_final.$complemento.$complemento_vigenc;
	
/*ERREGLO PAGINADOR*/	
	
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr class="titulos_secciones">
    <td class="titulos_secciones">SECCION: HISTORICO DE CONTRATOS</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="3" valign="top">
      <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="4" class="fondo_2">Buscador de contratos</td>
        </tr>
        <tr>
          <td width="23%" ><p align="right"><strong>Categoria:</strong></p>          </td>
          <td width="31%" >
            <input type="text" name="categoria_bu" id="categoria_bu" value="<?=$categoria_bu;?>" />          </td>
          <td width="22%" ><div align="right"><strong>Grupo</strong></div></td>
          <td width="24%"><input type="text" name="grupo_bu" id="grupo_bu" value="<?=$grupo_bu;?>" /></td>
        </tr>
        <tr>
          <td ><div align="right"><strong>Nombre gen&eacute;rico:</strong></div></td>
          <td ><input type="text" name="detalle_bu" id="detalle_bu" value="<?=$detalle_bu;?>" /></td>
          <td ><div align="right"><strong>Contratista:</strong></div></td>
          <td><input type="text" name="contratista_bu" id="contratista_bu" value="<?=$contratista_bu;?>"/></td>
        </tr>
        <tr>
          <td ><div align="right"><strong>Por Estado del Contrato</strong></div></td>
          <td ><select name="vigencia_bu" id="vigencia_bu">
            <option value="0">Seleccione</option>
            <option value="1" <? if($vigencia_bu==1) echo "selected";   ?>>Contratos Vigentes en Firme</option>
            <option value="2" <? if($vigencia_bu==2) echo "selected";   ?>>Contratos Finalizado</option>
            <option value="3" <? if($vigencia_bu==3) echo "selected";   ?>>Todos</option>
          </select>          </td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
    </table>      </td>
  </tr>
  <tr>
    <td width="29%" valign="top">&nbsp;</td>
    <td width="29%" valign="top" ><input name="button" type="button" class="boton_buscar" id="button" value="Exportar resultado a excel"  onclick="javascript:exporta_tarifas_especificas()" /></td>
    <td width="29%" valign="top" id="carga_acciones_permitidas2">&nbsp;</td>
  </tr>
</table>
<br />
<?
	if($complemento!=""){ //is realizo alguna busqueda
	
?>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="14" class="columna_titulo_resultados">&nbsp;</td>
  </tr>
  <tr>
    <td width="1%" class="columna_subtitulo_resultados"><div align="center">Numero de contrato</div></td>
    <td width="9%" class="columna_subtitulo_resultados"><div align="center">Contratista</div></td>
    <td width="34%" class="columna_subtitulo_resultados"><div align="center">Fecha inicio del  contrato</div></td>
    <td width="33%" class="columna_subtitulo_resultados"><div align="center">Fecha fin del contrato</div></td>
    <td width="33%" class="columna_subtitulo_resultados">Consecutivo de la  tarifa</td>
    <td width="33%" class="columna_subtitulo_resultados">Categor&iacute;a</td>
    <td width="33%" class="columna_subtitulo_resultados">Grupo</td>
    <td width="33%" class="columna_subtitulo_resultados">Item de Oferta</td>
    <td width="33%" class="columna_subtitulo_resultados">Nombre Gen&eacute;rico</td>
    <td width="33%" class="columna_subtitulo_resultados">Unidad</td>
    <td width="33%" class="columna_subtitulo_resultados">Moneda</td>
    <td width="33%" class="columna_subtitulo_resultados">Valor de la tarifa</td>
    <td width="33%" class="columna_subtitulo_resultados">Fecha de Inicio vigencia  tarifa</td>
    <td width="33%" class="columna_subtitulo_resultados">Fecha fin de vigencia  tarifa</td>

  </tr>
  
<?
	

	echo  $busca_tarifa_espe = "select  * from v_tarifas_reporte_buscador_tarifas_globales $where_final";
	$sql_ex_tari = query_db($busca_tarifa_espe);
	
	while($lista_detalle_tarifa = traer_fila_row($sql_ex_tari )) {

?>
  <tr>
    <td width="1%" class="columna_subtitulo_resultados"><div align="center"><?=$lista_detalle_tarifa[5];?></div></td>
    <td width="9%" class="columna_subtitulo_resultados"><div align="center"><?=$lista_detalle_tarifa[6];?></div></td>
    <td width="34%" class="columna_subtitulo_resultados"><div align="center"><?=$lista_detalle_tarifa[7];?></div></td>
    <td width="33%" class="columna_subtitulo_resultados"><div align="center"><?=$lista_detalle_tarifa[8];?></div></td>
    <td width="33%" class="columna_subtitulo_resultados"><?=$lista_detalle_tarifa[9];?></td>
    <td width="33%" class="columna_subtitulo_resultados"><?=$lista_detalle_tarifa[10];?></td>
    <td width="33%" class="columna_subtitulo_resultados"><?=$lista_detalle_tarifa[11];?></td>
    <td width="33%" class="columna_subtitulo_resultados"><?=$lista_detalle_tarifa[12];?></td>
    <td width="33%" class="columna_subtitulo_resultados"><?=$lista_detalle_tarifa[13];?></td>
    <td width="33%" class="columna_subtitulo_resultados"><?=$lista_detalle_tarifa[14];?></td>
    <td width="33%" class="columna_subtitulo_resultados"><?=$lista_detalle_tarifa[15];?></td>
    <td width="33%" class="columna_subtitulo_resultados"><?=$lista_detalle_tarifa[16];?></td>
    <td width="33%" class="columna_subtitulo_resultados"><?=$lista_detalle_tarifa[17];?></td>
    <td width="33%" class="columna_subtitulo_resultados"><?=$lista_detalle_tarifa[18];?></td>

  </tr>

<? } 
	
?>

</table>

<?

	} //is realizo alguna busqueda
?>
</body>
</html>
