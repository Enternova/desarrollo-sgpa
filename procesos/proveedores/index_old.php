<? include("../../librerias/lib/@session.php"); 
 $numero_get = valida_get();
 $numer = numero_ingresos_get();
 
 $version_js = str_replace("-", "", elimina_comillas_2($fecha));
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?=TITULO;?></title>

<script type="text/javascript" src="avanzar.js"></script>

<script type="text/javascript" src="../librerias/js/procesos_generales.js?version=<?=$version_js?>"></script>
<script type="text/javascript" src="tablero.js"></script>
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
<link href="../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="cargando_pecc"  style="display:none"><table width="100%" height="1000" align="center" border="0"><tr><td align="center" valign="middle"><img src="../imagenes/botones/cargando2.gif" width="320" height="250" /></td></table></div>

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

$buscar_contarto = traer_fila_row(query_db("select * from v_tarifas_contratos  where estado_contrato = 3 and t1_proveedor_id = ".$_SESSION["id_proveedor"]));

if($buscar_contarto[0]>=1){ ?>

    <td><div align="center">
    <img src="../imagenes/botones/cuadro_contenido_menu_tarifas.png" alt="Modulo de tarifas" title="Modulo de tarifas" onclick="taer_menu('menu-tarifas-proveedor.html','contenido_menu')"/>
    <!--<img src="../imagenes/botones/cuadro_contenido_menu_tarifas.png" alt="Modulo de tarifas" title="Modulo de tarifas" onclick="alert('En este momento nos encontramos trabajando en este modulo. Para mejorar la velocidad. Este servicio se restaurara el dia 11 de marzo de 2015 a las 8 am.')"/>-->
     <br />
      <a href="manual_tarifas.pdf" target="_blank">Descargue el  manual de uso del m&oacute;dulo de tarifas</a>
    </div></td>

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

if($_SESSION["id_us_session"]==16516){
	$tam=800;
	}
?>

<iframe name="grp" frameborder="0" height="<?=$tam?>" width="<?=$tam?>"></iframe>

</body>
</html>
