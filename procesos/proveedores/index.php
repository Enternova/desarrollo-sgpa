<? include("../../librerias/lib/@session.php"); 
 $numero_get = valida_get();
 $numer = numero_ingresos_get();
 
 $version_js = str_replace("-", "", elimina_comillas_2($fecha));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
 <meta http-equiv="X-UA-Compatible" content="IE=9">
 <meta http-equiv="X-UA-Compatible" content="IE=10">
 <meta http-equiv="X-UA-Compatible" content="IE=11">
<title><?=TITULO;?></title>

<script type="text/javascript" src="avanzar.js"></script>

<script type="text/javascript" src="../librerias/js/procesos_generales.js?version=<?=$version_js?>"></script>
<script type="text/javascript" src="../librerias/js/tarifas_proveedor_v7.js?version=<?=$version_js?>11"></script>
<script type="text/javascript" src="../librerias/jquery/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../librerias/jquery/jquery-ui-1.8.13.custom.min.js"></script>
<script>
	function exporta_tarifas_consulta()
{
	var forma = document.principal
	
					forma.action="../aplicaciones/tarifas/reporte_tarifas_excel.php";
					forma.target="grp"

					forma.submit()
					//window.parent.document.getElementById("cargando").style.display=""
					forma.action = "";
					forma.accion.value=""
	

	
	}
	function muestra_alerta_general_desde_select(nombre_funcion, titulo, cuerpo, id_select){
	var texto_select=$('#'+id_select+' option:selected').text();
	var tipo_modal = "select";
	texto_select=texto_select.replace('\n', '');
	texto_select=texto_select.replace(/^\s+|\s+$/g, '');
	cuerpo=cuerpo.replace('<campo>', texto_select);
	cuerpo=cuerpo.replace(' ', '32323232');
	//alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
	document.getElementById("div_carga_busca_sol").style.display="block";
	ajax_carga("../librerias/php/alerta_general.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion, "div_carga_busca_sol");
}
function muestra_alerta_general_solo_texto(nombre_funcion, titulo, cuerpo, alto_panel, alto_title, alto_footer){
	document.getElementById("div_carga_busca_sol").style.display="block";
	ajax_carga("../librerias/php/alerta_general.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion+"&alto_panel="+alto_panel+"&alto_title="+alto_title+"&alto_footer="+alto_footer, "div_carga_busca_sol");
}
function muestra_alerta_general_desde_ajax(ruta,div, titulo, cuerpo, id_select, tipo_modal){

	document.getElementById("div_carga_busca_sol").style.display="block";
	ajax_carga("../librerias/php/alerta_general.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+ruta+"&tipo_modal="+tipo_modal+"&div="+div, "div_carga_busca_sol");
}
function muestra_alerta_error(nombre_funcion, titulo, cuerpo, id_select){
    var texto_select=$('#'+id_select+' option:selected').text();
    var tipo_modal = "select";
    texto_select=texto_select.replace('\n', '');
    texto_select=texto_select.replace(/^\s+|\s+$/g, '');
    cuerpo=cuerpo.replace('<campo>', texto_select);
    cuerpo=cuerpo.replace(' ', '32323232');
    //alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
    document.getElementById("div_carga_busca_sol").style.display="block";
    ajax_carga("../librerias/php/alerta_error.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion, "div_carga_busca_sol");
}
function muestra_alerta_error_solo_texto(nombre_funcion, titulo, cuerpo, alto_panel, alto_title, alto_footer){
    //alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
    document.getElementById("div_carga_busca_sol").style.display="block";
    ajax_carga("../librerias/php/alerta_error.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion+"&alto_panel="+alto_panel+"&alto_title="+alto_title+"&alto_footer="+alto_footer, "div_carga_busca_sol");
}
function muestra_alerta_iformativa_solo_texto(nombre_funcion, titulo, cuerpo, alto_panel, alto_title, alto_footer){
    //alert(nombre_funcion+'-----'+titulo+'-----'+cuerpo)
    document.getElementById("div_carga_busca_sol").style.display="block";
    ajax_carga("../librerias/php/alerta_informativa.php?titulo_modal="+titulo+"&cuerpo_modal="+cuerpo+"&funcion="+nombre_funcion+"&alto_panel="+alto_panel+"&alto_title="+alto_title+"&alto_footer="+alto_footer, "div_carga_busca_sol");
}
</script>
<script type="text/javascript" src="../librerias/jquery/calendario/jquery-ui-timepicker-addon.js"></script>
<link rel="stylesheet" type="text/css" href="../librerias/jquery/calendario/jquery-ui-1.8.13.custom.css" />

<script>
	function calendario_sin_hora(obje){
			$(function(){
				$('#' + obje).datepicker({
					numberOfMonths: 1,
					dateFormat: 'yy-mm-dd'

				});
			});
			}
</script>
<link href="https://fonts.googleapis.com/css?family=Roboto:100" rel="stylesheet">
<link href="../css/estilo-principal.css?act=1" rel="stylesheet" type="text/css" />
<?
$nombre_ie_css = "chips-ms12";
?>
<?  $u_agent = $_SERVER['HTTP_USER_AGENT'];//detectar navegador para incluir los estilos correspondientes
   // echo $u_agent;
	
	
	
    if(preg_match('/MSIE/i',$u_agent) || preg_match('/\Trident\b/',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { ?>
        <link rel="stylesheet" type="text/css" href="../css/chips/<?=$nombre_ie_css?>.css?version=<?=$hora?>" />  
    <?}elseif(preg_match('/\bEdge\b/',$u_agent)) 
    { ?>
        <link rel="stylesheet" type="text/css" href="../css/chips/<?=$nombre_ie_css?>.css?version=<?=$hora?>" />  
    <?}elseif(preg_match('/Firefox/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../css/chips/chips-moz.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../css/chips/chips-webkit.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Safari/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../css/chips/chips-safari.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Opera/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../css/chips/chips-opera.css?version=<?=$hora?>" />  
    <? } 
    else  { 
		?>
         <link rel="stylesheet" type="text/css" href="../css/chips/chips-webkit.css?version=<?=$hora?>" /> 
    <?
    }
	
?>
</head>

<body>
<div id="div_carga_busca_sol"  style="display:none"></div>
<div id="cargando_pecc"  style="display:none"><table width="100%" height="1000" align="center" border="0"><tr><td align="center" valign="middle"><img src="../imagenes/botones/cargando2.gif" width="320" height="250" /></td></table></div>
<?=$texto_modulo_pruebas?>
<?=banner();?>
<form name="principal" method="post" enctype="multipart/form-data">
<table width="100%" border="0" cellspacing="2" cellpadding="2">

  <tr>
    <td width="158" valign="top" id="contenido_menu">
      <table width="187" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td width="17%" align="center" class="fondo_1">0</td>
          <td width="83%" class="fondo_2" onclick="window.parent.location.href='proveedores.html'">Inicio</td>
        </tr>
        <tr>
          <td class="fondo_1"><div align="center">1
            </div>
            <div align="center"></div></td>
          <td class="fondo_2" onClick="window.parent.location.href='../'">Salida Segura</td>
        </tr>
    </table></td>
    <td width="100%" valign="top" >
  <table width="100%" border="0" cellspacing="0" cellpadding="0">
<tr>
            <td width="2%" class="esquina_s_iz">&nbsp;</td>
            <td width="95%" class="linea_sup">&nbsp;</td>
            <td width="3%"  class="esquina_s_der">&nbsp;</td>
          </tr>
          <tr>
            <td class="linea_iz">&nbsp;</td>
            <td id="contenidos" align="left">
            
           	  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2">
              <tr>
                <td width="10%"><div align="center"></div></td>
                <td width="19%"><div align="center"></div></td>
                </tr>
              <tr>
<? 

$buscar_contarto = traer_fila_row(query_db("select * from v_tarifas_contratos  where estado_contrato in (3,6) and t1_proveedor_id = ".$_SESSION["id_proveedor"]));

if($buscar_contarto[0]>=1){ 
$sel_ultimo_manual = traer_fila_row(query_db("select id, adjunto, fecha, hora, id_us_carga from t6_tarifas_manual_usuario_prov where estado=1"));
?>

    <td align="center">
  
  
  
      <img src="../imagenes/botones/cuadro_contenido_menu_tarifas.png" alt="Modulo de tarifas" title="Modulo de tarifas" onClick="taer_menu('menu-tarifas-proveedor.html','contenido_menu')"/>
    
      <br />
      <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n1=<?=$sel_ultimo_manual[0]?>&n3=10&n2=<?=$sel_ultimo_manual[1]?>" target="grp">Descargue el  manual de uso del m&oacute;dulo de tarifas<br />
<?=$sel_ultimo_manual[1];?><img src="../imagenes/mime/<?=saca_extencion_archivo($sel_ultimo_manual[1])?>.gif" width="16" height="16" /></a>
      <!-- <a href="manual_tarifas.pdf" target="_blank">Descargue el  manual de uso del m&oacute;dulo de tarifas</a>-->
     </td>

<? } else { ?>                
<td height="168"><div align="center"><img src="../imagenes/botones/cuadro_contenido_menu_tarifas.png" alt="Modulo de tarifas" title="Modulo de tarifas"/></div></td>
<? } ?>                <td><div align="center"><a href="../enterproc/solicitudes-en-proceso/procesos.html"><img src="../imagenes/botones/cuadro_contenido_menu_procurement.png" alt=""/></a></div></td>
                </tr>
              <tr>
                <td height="104">&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
                </tr>
              <tr>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
                </tr>
              <tr>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
                </tr>
              <tr>
                <td><div align="center"></div></td>
                <td><div align="center"></div></td>
                </tr>
            </table></td>
            <td class="linea_der">&nbsp;</td>
          </tr>
          <tr>
            <td  class="esquina_i_iz">&nbsp;</td>
            <td  class="linea_infe">&nbsp;</td>
            <td   class="esquina_i_der">&nbsp;</td>
          </tr>
        </table>
  
    </td>
  </tr>
  <tr>
    <td colspan="2">
    



    
    </td>
  </tr>
</table>

<div  class="fondo_cabecera">
      <table width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td><img src="../imagenes/coorporativo/logo final-01.png" width="133" height="36" /></td>
          <td class="letra_azul_pequena">Si tiene problemas con la funcionabilidad del sistema por favor comun&iacute;quese al PBX (57 1) 381 6521 Opcion 1,
Dise&ntilde;ado y Desarrollado por Enterprise Technological Innovation S.A.S. Bogot&aacute; 2011.</td>
        </tr>
      </table>
</div>
<input type="hidden" name="accion" />
</form>

<?
$tam=0;

if($_SESSION["id_proveedor"]==817){
	$tam=800;
	}
?>

<iframe name="grp" frameborder="0" height="<?=$tam?>" width="<?=$tam?>"></iframe>

</body>
</html>
