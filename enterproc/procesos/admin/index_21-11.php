<?   include("../../librerias/lib/@session.php");

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<title><?=TITULO;?></title>
<link href="css/reloj.css" rel="stylesheet" type="text/css" />
<script type="text/javascript" src="../librerias/ajax/ajax_01.js"></script>
<script type="text/javascript" src="../librerias/jquery/menu1/milonic_src.js"></script>
<script type="text/javascript" src="../librerias/jquery/menu1/mmenudom.js"></script>

<script type="text/javascript" src="../librerias/js/procesos.js?act=28"></script>
<? include("../../librerias/jquery/menu1/contenido_admin.php");?>

<script type="text/javascript" src="../librerias/jquery/jquery-1.5.1.min.js"></script>
<script type="text/javascript" src="../librerias/jquery/jquery-ui-1.8.13.custom.min.js"></script>
<script type="text/javascript" src="../librerias/js/popup.js"></script>
<script type='text/javascript' src='../librerias/jquery/autocomplete/lib/jquery.ajaxQueue.js' charset='iso-8859-1'></script>
<script type='text/javascript' src='../librerias/jquery/autocomplete/lib/thickbox-compressed.js' charset='iso-8859-1'></script>
<script type='text/javascript' src='../librerias/jquery/autocomplete/jquery.autocomplete.js' charset='iso-8859-1'></script>
<link rel="stylesheet" type="text/css" href="../librerias/jquery/autocomplete/jquery.autocomplete.css" />
<link rel="stylesheet" type="text/css" href="../librerias/jquery/autocomplete/lib/thickbox.css" />

<script type="text/javascript" src="../librerias/jquery/calendario/jquery-ui-timepicker-addon.js"></script>
<link rel="stylesheet" type="text/css" href="../librerias/jquery/calendario/jquery-ui-1.8.13.custom.css" />


<script type="text/javascript" src="../librerias/jquery/popup/jquery.bpopup-0.6.0.min.js"></script>

<script type="text/javascript" src="../librerias/jquery/tooltips/jquery.tipTip.js"></script>
<script type="text/javascript" src="../librerias/jquery/tooltips/jquery.tipTip.minified.js"></script>


<link href="../../css/principal.css" rel="stylesheet" type="text/css">
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />




<script type="text/javascript">


function close_va()
{
	$('#popup2').bPopup().close()
}

function msgbox(ruta)
	{
		
		
		 $(document).ready(function() {
	        
	        
	            $("#popup2").bPopup({  contentContainer: '#pContent', loadUrl: ruta });
	        
	    });

	}
	

    function selecciona_lista() {

        $().ready(function() {

            function log(event, data, formatted) {
                $("<li>").html(!data ? "No match!" : "Selected: " + formatted).appendTo("#result");
            }

            function formatItem(row) {
                return row[0] + " (<strong>id: " + row[1] + "</strong>)";
            }
            function formatResult(row) {
                return row[0].replace(/(<.+?>)/gi, '');
            }



            $("#proveedor").autocomplete("../librerias/php/autocompleta.php", {

                width: 660,
                selectFirst: true,
                max: 1000,
                scroll: true,
                scrollHeight: 300,
                autoFill: false,
                multiple: true,
                mustMatch: true,
                matchContains: true

            });


  $("#articulos").autocomplete("../librerias/php/autocompleta_articulos.php", {

                width: 660,
                selectFirst: true,
                max: 1000,
                scroll: true,
                scrollHeight: 300,
                autoFill: false,
                multiple: true,
                mustMatch: true,
                matchContains: true

            });

  $("#b_usuarios").autocomplete("../librerias/php/autocompleta_usuarios.php", {

                width: 660,
                selectFirst: true,
                max: 1000,
                scroll: true,
                scrollHeight: 300,
                autoFill: false,
                multiple: true,
                mustMatch: true,
                matchContains: true

            });

           




        });

        function changeOptions() {
            var max = parseInt(window.prompt('Please type number of items to display:', jQuery.Autocompleter.defaults.max));
            if (max > 0) {
                $("#suggest1").setOptions({
                    max: max
                });
            }
        }

        function changeScrollHeight() {
            var h = parseInt(window.prompt('Please type new scroll height (number in pixels):', jQuery.Autocompleter.defaults.scrollHeight));
            if (h > 0) {
                $("#suggest1").setOptions({
                    scrollHeight: h
                });
            }
        }
function changeToMonths(){
	$("#suggest1")
		// clear existing data
		.val("")
		// change the local data to months
		.setOptions({data: months})
		// get the label tag
		.prev()
		// update the label tag
		.text("Month (local):");
		alert(1)
}

}
</script>

<script type="text/javascript">

	function calendario_se(obje){
			$(function(){
				$('#' + obje).datetimepicker({
					numberOfMonths: 1,
					dateFormat: 'yy-mm-dd',
					timeFormat: 'hh:mm:ss'


				});
			});
}

	function calendario_sin_hora(obje){
			$(function(){
				$('#' + obje).datepicker({
					numberOfMonths: 1,
					dateFormat: 'yy-mm-dd'

				});
			});
}

		</script>

<script>

function act_tollti(){

$(function(){

$(".someClass").tipTip({maxWidth: "auto", edgeOffset: 10});

});

}


</script>
</head>

<?
	if($_POST["id_procurement_alerta"]!=""){
	
	$sql_b = traer_fila_row(query_db("select fecha_cierre, tp2_id, us_id_contacto from $t5 where pro1_id = ".$_POST["id_procurement_alerta"]));
	
	
	if ($sql_b[2]<> $_SESSION["id_us_session"]) 
	
		{
			 $busca_invitaciones = "select distinct pro1_id from v_vista_invitados_observadores where pro1_id = ".$_POST["id_procurement_alerta"]." and  us_id = ".$_SESSION["id_us_session"]." and estado = 1";	
				$sql_invitados = mysql_fetch_row(mysql_query($busca_invitaciones));
					
					if($sql_invitados[0]>=1)
						{
								$boton_ingreso="evaluacion/detalle_invitacion.php";		
							
							}
			
			
			
			}
	
	else{
		 if ( ($sql_b[0]<= $fecha." ".$hora) && ($sql_b[1]>=1) ) 
		    
			{//SI LICITACION
					$boton_ingreso="visualiza_proceso.php";
			}	
		else{
		 		    $boton_ingreso="crea_proceso.php";
					
					}
	}
?>
<body onLoad="ajax_carga('../aplicaciones/<?=$boton_ingreso;?>?id_p=<?=$_POST["id_procurement_alerta"];?>','contenidos')">

<?
	} else{
?>
<body onLoad="ajax_carga('../aplicaciones/historico_procesos.php?tipo_ingreso_alerta=1','contenidos')">
<? } 



/*------------------validador o gestion abastecimiento el rol ------------------*/

/*SI TUVIERA CONEXION CON SQL SERVER ESTE ES EL QUERY PARA SABER SI EL USUARIO TIENE PERMISO DE VALIDADOR ABASTECIMIENTO, PARA QUE PUEDA CREAR URNAS Y DEMAS PERMISOS QUE NO PUEDE HACER EL TIPO USUARIO 4
echo "select count(*) from tseg5_usuario_permisos where id_usuario = ".$_SESSION["id_us_session"]." and id_permiso = 44";
$sele_permiso_validador_abaste = traer_fila_row(query_db("select count(*) from tseg5_usuario_permisos234 where id_usuario = ".$_SESSION["id_us_session"]." and id_permiso = 44"));
if($sele_permiso_validador_abaste[0]>0){
$es_validador_abastecimiento = "SI";
}
*/

if($_SESSION["id_us_session"]==29){// COMO NO SE TIENE CONEXION CON SQL SERVER ENTONCES TOCA PONER LOS PERMISOS MANUALMENTE A LOS ID DE USUARIOS DE DELOITTE
$es_validador_abastecimiento = "SI";
}elseif($_SESSION["id_us_session"]==57){
$es_validador_abastecimiento = "SI";
}elseif($_SESSION["id_us_session"]==18194){
$es_validador_abastecimiento = "SI";
}elseif($_SESSION["id_us_session"]==18579){
$es_validador_abastecimiento = "SI";
}elseif($_SESSION["id_us_session"]==19791){
$es_validador_abastecimiento = "SI";
}elseif($_SESSION["id_us_session"]==20296){
$es_validador_abastecimiento = "SI";
}else{
$es_validador_abastecimiento = "NO";
}


/*------------------validador o gestion abastecimiento el rol ------------------*/

?>



<?=banner();?>
<form name="principal" method="post" enctype="multipart/form-data">
<br />
  <table width="100%" border="0" cellpadding="0" cellspacing="0" >
  <tr>
    <td width="200px" valign="top">
    <table width="218" border="0" align="left" cellpadding="2" cellspacing="2">
    <tr>
        <td width="28" class="fondo_1" align="center"><div align="center">0</div></td>
        <td colspan="2" align="center" class="fondo_2" onclick="window.parent.location.href='../../sistema-sgpa/administracion.html'"><div align="left">Menu SGPA</div></td>
        </tr>
  
  
    <? if(($_SESSION["tipo_usuario"]!=4) && ($_SESSION["tipo_usuario"]!=10) or ($es_validador_abastecimiento == "SI") ){?>
      <tr>
        <td width="28" class="fondo_1" align="center"><div align="center">1</div></td>
        <td width="176" class="fondo_2" onClick="ajax_carga('nuevo-proceso.html','contenidos')"><div align="left">Crear proceso.</div></td>
      </tr>
    <? } ?>
    
     <? if($_SESSION["id_us_session"]==19927){?>
      <tr>
        <td width="28" class="fondo_1" align="center"><div align="center">1</div></td>
        <td width="176" class="fondo_2" onClick="ajax_carga('nuevo-proceso.html','contenidos')"><div align="left">Crear proceso</div></td>
      </tr>
    <? } ?>

     <? if($_SESSION["id_us_session"]==18194){?>
      <tr>
        <td width="28" class="fondo_1" align="center"><div align="center">1</div></td>
        <td width="176" class="fondo_2" onClick="ajax_carga('nuevo-proceso.html','contenidos')"><div align="left">Crear proceso</div></td>
      </tr>
    <? } ?>
        
       <tr>
        <td class="fondo_1"><div align="center">2</div></td>
        <td class="fondo_2"  onclick="ajax_carga('historico-proceso_0.html','contenidos')"><div align="left">Historico de procesos</div></td>
      </tr>
<? if(($_SESSION["tipo_usuario"]!=4) && ($_SESSION["tipo_usuario"]!=10) or ($es_validador_abastecimiento == "SI") or $_SESSION["id_us_session"] ==17968){?>
      <tr>
        <td class="fondo_1"><div align="center">3</div></td>
        <td class="fondo_2" onClick="ajax_carga('historico-proveedores.html','contenidos')"><div align="left">Admin. proveedores</div></td>
      </tr>
      <tr>
        <td class="fondo_1"><div align="center">4</div></td>
        <td class="fondo_2" onClick="ajax_carga('alerta-bitacora.html','contenidos')"><div align="left">Alertas bitacora</div></td>
      </tr>
<? } if(($_SESSION["id_us_session"]==19927) || ($_SESSION["id_us_session"]==18194)){?>
      <tr>
        <td class="fondo_1"><div align="center">3</div></td>
        <td class="fondo_2" onClick="ajax_carga('historico-proveedores.html','contenidos')"><div align="left">Admin. proveedores</div></td>
      </tr>
 
 

<? } if ($_SESSION["tipo_usuario"]==1) {?>    
  
      <tr>
        <td align="center" class="fondo_1">5</td>
        <td class="fondo_2" onClick="ajax_carga('soporte-tecnico.html','contenidos')"><div align="left">Soporte t&eacute;cnico</div></td>
      </tr>
      
      <tr>
        <td class="fondo_1"><div align="center">6</div></td>
        <td class="fondo_2" onClick="ajax_carga('panel-control.html','contenidos')"><div align="left">Panel de control</div></td>
      </tr>
<? } 

if ( ($_SESSION["id_us_session"]==1) || ($_SESSION["id_us_session"]==18122)){?>      
      <tr>
        <td class="fondo_1"><div align="center">6</div></td>
        <td class="fondo_2" onClick="ajax_carga('panel-control.html','contenidos')"><div align="left">Panel de control</div></td>
      </tr>
      
<? }       

if ( ($_SESSION["id_us_session"]==30) || ($_SESSION["id_us_session"]==32)){?>
      
<? } ?>   

      <tr>
        <td class="fondo_1"><div align="center">8</div></td>
        <td class="fondo_2" onClick="ajax_carga('../aplicaciones/reportes/re1.php','contenidos')"><div align="left">Reportes estados procesos</div></td>
      </tr>

    </table></td>
    <td width="1200px" >
    <table width="100%" border="0" cellspacing="0" cellpadding="0">
      <tr>
        <td width="2%" class="esquina_s_iz">&nbsp;</td>
        <td width="95%" class="linea_sup">&nbsp;</td>
        <td width="3%"  class="esquina_s_der">&nbsp;</td>
      </tr>
      <tr>
        <td class="linea_iz">&nbsp;</td>
        <td id="contenidos" align="left">&nbsp;</td>
        <td class="linea_der">&nbsp;</td>
      </tr>
      <tr>
        <td  class="esquina_i_iz">&nbsp;</td>
        <td  class="linea_infe">&nbsp;</td>
        <td   class="esquina_i_der">&nbsp;</td>
      </tr>
    </table></td>
  </tr>
</table>


<input type="hidden" name="accion" />  

<script>
function cambia_fecha_srev(i)
		{
//
			if(i>=5)
				{
				//alert(i)
				ajax_carga_02('muestra-reloj_ad.php','reloj_general');
					i=0;
				}
			i++;
			y=i	
			setTimeout("cambia_fecha_srev(y)",1000);		
		}
		
//cambia_fecha_srev(1)
</script>


</form>
<?

$tam=0;
if($_SESSION["id_us_session"]==1){
	$tam=800;
	}
				

			
?>
<iframe name="grp" frameborder="0" height="<?=$tam?>" width="<?=$tam?>"></iframe>




</body>
</html>
