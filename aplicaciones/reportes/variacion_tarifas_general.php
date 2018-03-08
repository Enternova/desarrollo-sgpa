<?
include("../../librerias/lib/@include.php");

$_SESSION["comple_filtro"] = "";
$_SESSION["fecha_inicial_bus_rep"] = "";
$_SESSION["fecha_hasta_bus_rep"] ="";
$_SESSION["comple_filtro2"]="";
$_SESSION["id_area_bus_rep"] ="";
$_SESSION["area_usuaria_bus_rep"] ="";
$_SESSION["contrato_busca_rep"] ="";



if($_GET["genera"] == 1){//si se esta generando el reporte.

	if($_GET["gerente"]!=0 and $_GET["gerente"]!="" and $_GET["gerente"]!=" "){
	$gerente_get=traer_fila_row(query_db("SELECT us_id, nombre_administrador FROM t1_us_usuarios WHERE us_id=".$_GET["gerente"]));
	$gerente_get=$gerente_get[1]."----,".$gerente_get[0]."----,";
	//print_r( $gerente_get);
}else{
	$gerente_get="";
}
if($_GET["proveedor"]!=0 and $_GET["proveedor"]!="" and $_GET["proveedor"]!=" "){
	$proveedor_get=traer_fila_row(query_db("SELECT t1_proveedor_id, razon_social FROM t1_proveedor WHERE t1_proveedor_id=".$_GET["proveedor"]));
	$proveedor_get=$proveedor_get[1]."----,".$proveedor_get[0]."----,";
	//print_r( $gerente_get);
}else{
	$proveedor_get="";
}

$contrato_busca_rep="";
if($_GET["contrato"]!="0" and $_GET["contrato"]!="" and $_GET["contrato"]!=" "){
	$contrato_busca_rep=$_GET["contrato"];
	
}else{
	$contrato_busca_rep="";
}



	
/*area*/
	
	$area_usuaria_bus_rep = explode(",",$_GET["area_usuaria_bus_rep"]);
	$ids_areas_sel ="";
	for ($i=0;$i<count($area_usuaria_bus_rep);$i++){
		if($area_usuaria_bus_rep[$i] != "0" and $area_usuaria_bus_rep[$i] != ""){
		$ids_areas_sel.=",".$area_usuaria_bus_rep[$i];
		}
	}

	
/*FIN area*/
}
	?>
<!DOCTYPE html>
<html lang="en">
<head>

<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Roboto:100" rel="stylesheet">
<link rel="stylesheet" type="text/css" href="../librerias/materialize/css/materialize_custom.css">
<script type="text/javascript" src="../librerias/jquery/jquery2.js"></script>
<script type="text/javascript" src="../librerias/materialize/js/materialize.js"></script>
<style>
	.div-text {
		width: 90%;
		margin-left: 5%;
		height: auto;
	}
	.div-custom-red2{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #E0766B;
	}
	.div-custom-yellow2{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #FFBE5E;
	}
	.div-custom-green2{
		width: 90%;
		margin-left: 5%;
		height: auto;
		border-radius: 25px;
		background: #6AC46F;
	}
	.font{
		font-family: 'roboto';
	}
	.f14{
		font-size: 12pt;
	}
	.f12{
		font-size: 9pt;
		font-weight: 900 !important;
	}
	.f10{
		font-size: 8pt;
		color: #000;
	}
	.table-custom{
		width: 98%;
		margin-left: 1%;
		border-collapse:collapse;
	}
	.th-custom{
		/*-webkit-box-shadow: 0 9px 4px #777;
		-moz-box-shadow: 0 9px 4px #777;
		box-shadow: 0 9px 4px #777;*/
		background: transparent;
		color: #FFF;		
		font-weight: 900;
	}
	.td-title-red{
		background: #FE5151;
		color: #FFF;
	}
	.td-title-yellow{
		background: #FEC007;
		color: #FFF;
	}
	.td-title-green{
		background: #4BAE4F;
		color: #FFF;
	}
	.custom-red2{
		color: #FF3333;
	}
	.custom-yellow2{
		color: #E2B700;
	}
	.custom-green2{
		color: #009900;
	}
	.border{
		border: 2px solid #FFF;
	}
	.transparent{
		background: transparent;
	}
</style>

</head>
<body>
	

<div class="titulos_secciones font" style="font-size:18pt !important; font-weight: 900 !important;">Reporte de Variaci&oacute;n de Tarifas Global</div>
<br>


<table width="90%" border="0" align="center"  style="font-weight: 900 !important; font-family: roboto !important; font-size: 12pt !important;">
  <tr>
    <td colspan="2" align="right" style="font-weight: 900 !important; font-family: roboto !important; font-size: 12pt !important;"><table width="100%" border="0" align="center"  style="font-weight: 900 !important; font-family: roboto !important; font-size: 12pt !important;">
      <tr>
        <td width="43%" align="right" style="font-weight: 900 !important; font-family: roboto !important; font-size: 12pt !important;">Gerente de Contrato:</td>
        <td width="3%">&nbsp;</td>
        <td width="54%"><input name="usuario_permiso" type="text" id="usuario_permiso3" size="5" value="<?=$gerente_get;?>" onkeypress="selecciona_lista()"/></td>
      </tr>
      <tr>
        <td align="right"  style="font-weight: 900 !important; font-family: roboto !important; font-size: 12pt !important;">Proveedor</td>
        <td>&nbsp;</td>
        <td><input type="text" name="proveedores_busca" id="proveedores_busca3" value="<?=$proveedor_get;?>" onkeypress="selecciona_lista()"/></td>
      </tr>
      <tr>
        <td align="right"  style="font-weight: 900 !important; font-family: roboto !important; font-size: 12pt !important;">Contrato</td>
        <td>&nbsp;</td>
        <td><input name="contratos_normales" type="text" id="contratos_normales" size="25" value="<?=$contrato_busca_rep;?>">
      </tr>
      <tr>
        <td align="right"  style="font-weight: 900 !important; font-family: roboto !important; font-size: 12pt !important;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right"  style="font-weight: 900 !important; font-family: roboto !important; font-size: 12pt !important;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td colspan="3" align="left"  style="font-weight: 900 !important; font-family: roboto !important; font-size: 12pt !important;"><?=ayuda_alerta_pequena("A continuaci&oacute;n seleccione el periodo de tiempo en el que desea consultar las tarifas que est&aacute;n o estuvieron vigentes");?></td>
        </tr>
      <tr>
        <td align="right">Fecha Inicial del<br>rango de Tarifas Vigentes:</td>
        <td>&nbsp;</td>
        <td><input name="fecha_inicial" type="text" id="fecha_inicial" onmousedown="calendario_sin_hora('fecha_inicial')" size="5" readonly value="<?=$_GET["fecha_inicial"]?>"  /></td>
      </tr>
      <tr>
        <td align="right">Fecha Final del<br>rango de Tarifas Vigentes:</td>
        <td align="left">&nbsp;</td>
        <td align="left"><input name="fecha_hasta" type="text" id="fecha_hasta" onmousedown="calendario_sin_hora('fecha_hasta')" size="5" readonly value="<?=$_GET["fecha_hasta"]?>" /></td>
      </tr>
      <tr>
        <td align="right"  style="font-weight: 900 !important; font-family: roboto !important; font-size: 12pt !important;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
      <tr>
        <td align="right"  style="font-weight: 900 !important; font-family: roboto !important; font-size: 12pt !important;">&nbsp;</td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
      </tr>
    </table></td>
    <td width="16%" align="right">&Aacute;rea Usuaria:</td>
    <td width="25%" align="left"><select name="area_usuaria_bus_rep[]" id="area_usuaria_bus_rep" multiple="multiple" size="28">
      <option value="0" <? if($_GET["genera"] != 1){ echo "selected";}?>>Buscar Todas Las &Aacute;reas</option>
      <?
          $sel_profss = query_db("select t1_area_id, nombre from t1_area where estado=1 order by nombre_html asc");
		  while($se_area =traer_fila_db($sel_profss)){
			  
			  $sel_areas_seleccionadas = traer_fila_row(query_db("select count(*) from t1_area where t1_area_id in (0 ".$ids_areas_sel.") and t1_area_id = ".$se_area[0]))
		  ?>
      <option value="<?=$se_area[0]?>" <? if($sel_areas_seleccionadas[0] > 0) echo 'selected="selected"'?>  >
        <?=htmlentities($se_area[1])?>
        </option>
      <?
		  }
		  ?>
    </select></td>
    <td width="17%" align="right"><?=ayuda_alerta_pequena("Para seleccionar varias &aacute;reas usuarias mantega oprimida la tecla CTRL y de click izquierdo");?></td>
  </tr>
  <tr>
    <td colspan="5">
<div class="input-field col s12 m12 l12 center">
            			<a class="waves-effect waves-light btn" id="busca" style="background: #229BFF !important; background-color:  #229BFF; z-index: 0 !important;" onclick="busca_reporte_variacion_general()" ><i class="material-icons left">&#xE01D;</i>Generar Gr&aacute;ficas</a>
            			<?
if($_GET["genera"] == 1){/*//si se esta generando el reporte
?>
<a onclick="abrir_ventana('../aplicaciones/reportes/reporte_variaciones_global_excel.php?tipo_grafica=todo')" class="waves-effect waves-light btn" style="background-color: #229BFF; z-index: 0 !important;"><i class="material-icons left">&#xE2C0;</i>Exportar a Excel</a>
            <?
			*/
}
?>
            
	  </div></td>
  </tr>
</table>
<p>&nbsp;</p>
<?
if($_GET["genera"] == 1){//si se esta generando el reporte.

	
	
//$_SESSION["comple_filtro"] = " where fecha_inicio_vigencia <= '".$_SESSION["fecha_hasta_bus_rep"]."' and fecha_fin_vigencia <= '".$_SESSION["fecha_hasta_bus_rep"]."'";



?>
<script>
	function mestra_cargando(){
		document.getElementById("cargando_pecc").style.display = "block"
	}
	function oculta_cargando(){
		document.getElementById("cargando_pecc").style.display = "none"
		//alert('entro 0')
	}
</script>
<br />
<!--
<div id="cargando_pecc"  style="display:none"><table width="100%" height="1000" align="center" border="0"><tr><td align="center" valign="middle"><img src="../imagenes/botones/Cargando_new.gif" width="320" height="250" /></td></table></div>
-->
<table width="100%" border="0">
  <tr>
    <td colspan="2" align="center">
  
    <iframe src="../aplicaciones/reportes/variacion_tarifas_contratos_por_area.php?fecha_inicial=<?=$_GET["fecha_inicial"]?>&fecha_hasta=<?=$_GET["fecha_hasta"]?>&ids_areas_sel=<?=$ids_areas_sel?>&gerente=<?=$_GET["gerente"]?>&contratista=<?=$_GET["proveedor"]?>&contrato=<?=$contrato_busca_rep;?>" frameborder="0" style="display: block; width: 100%; height: 13000px; border: none;"></iframe>
    
    </td>
  </tr>
  <tr>
    <td width="50%">&nbsp;</td>
    <td width="50%">&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2"><div id="carga_lis_contratos"></div></td>
  </tr>
</table>
</body>
</html>

<?
	}	

?>