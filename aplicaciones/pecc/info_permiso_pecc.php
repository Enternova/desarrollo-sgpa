<? include("../../librerias/lib/@session.php"); 

$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));

	
	?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />

</head>

<body>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr class="<?=$colum_clase5?>">
    <td colspan="4" align="center" class="fondo_3">Informacion del Permiso en el PECC 2016</td>
  </tr>
  <tr class="<?=$colum_clase5?>">
    <td width="50%" align="right">PECC de origen de esta solicitud:</td>
    <td width="14%"> 2016</td>
    <td width="7%">&nbsp;</td>
    <td width="29%">&nbsp;</td>
  </tr>
  <tr>
    <td align="right">Tipo de Proceso:</td>
    <td colspan="3"> Licitaci&oacute;n</td>
  </tr>
  <tr>
    <td align="right">Area Usuaria:</td>
    <td colspan="3">DST- Perforaci&oacute;n y Completamiento<br /></td>
  </tr>
  <tr>
    <td align="right">Fecha en la que se Requiere el Servicio:</td>
    <td colspan="3"> 2016-06-30</td>
  </tr>
  <tr>
    <td align="right">Objeto del Contrato:</td>
    <td colspan="3"> Servicios de perforaci&oacute;n y completamiento pozos Dumbo y Pegaso</td>
  </tr>
  <tr>
    <td align="right">Alcance:</td>
    <td colspan="3"> Perforaci&oacute;n , completamiento y prueba de dos pozos en el CPO16 (Dumbo, Pegaso)</td>
  </tr>
  <tr>
    <td align="right">Proveedores Sugeridos:<strong></strong></td>
    <td colspan="3">Por Definir</td>
  </tr>
  <tr>
    <td align="right">Recomendaci&oacute;n</td>
    <td colspan="3"> Salir a licitar servicios de perforaci&oacute;n y completamiento Dumbo y Pegaso</td>
  </tr>
</table>
<table width="100%" border="0" align="center"  class="tabla_lista_resultados">
  <tr>
    <td colspan="4" align="center"  class="fondo_3">Valor Presupuestado</td>
  </tr>
  <tr>
    <td width="13%" align="center" class="fondo_3">A&ntilde;o</td>
    <td width="16%" align="center" class="fondo_3">&Aacute;rea/Proyecto</td>
    <td width="16%" align="center" class="fondo_3">Valor USD$</td>
    <td width="16%" align="center" class="fondo_3">Valor COP$</td>
  </tr>
  <tr class="<?=$clase?>">
    <td align="center">2016</td>
    <td align="center">CPO 16 - Sin Socios</td>
    <?
    
if($id_item_pecc==8348) $usd='240.000'; $cop='0';
if($id_item_pecc==8349) $usd='1.258.917'; $cop='2.897.250.000';
if($id_item_pecc==8350) $usd='384.000'; $cop='0';
if($id_item_pecc==8352) $usd='303.000'; $cop='0';
if($id_item_pecc==8353) $usd='0'; $cop='540.000.000';
if($id_item_pecc==8354) $usd='1.613.000'; $cop='0';
if($id_item_pecc==8355) $usd='80.000'; $cop='0';
if($id_item_pecc==8356) $usd='460.000'; $cop='0';
if($id_item_pecc==8357) $usd='70.000'; $cop='0';
if($id_item_pecc==8358) $usd='120.000'; $cop='0';
if($id_item_pecc==8359) $usd='298.000'; $cop='0';
if($id_item_pecc==8360) $usd='135.000'; $cop='0';
if($id_item_pecc==8361) $usd='102.000'; $cop='0';
if($id_item_pecc==8362) $usd='0'; $cop='117.000.000';
if($id_item_pecc==8363) $usd='0'; $cop='135.000.000';


	
	
	?>
    <td align="center" ><?=$usd?></td>
    <td align="center"><?=$cop?></td>
  </tr>
</table>


</body>
</html>
