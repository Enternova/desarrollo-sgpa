<?
$funcion=$_GET["funcion"];
$funcion = str_replace("*", "&", $_GET["funcion"]);
$funcion = str_replace('-comillas-', '"', $_GET["funcion"]);

if($_GET["tipo_modal"]=="ajax"){
	$funcion = 'ajax_carga("'.$funcion.'","'.$_GET["div"].'")';
	$funcion= 'ajax_carga("../aplicaciones/pecc/carga_proveedores_servicio_menor.php?id_pecc=1&id_tipo_proceso_pecc=1&proveedores_busca=&nit_busca=90033","contenidos")';
	}
	
$cuerpo_modal=$_GET["cuerpo_modal"];
$alto_panel=$_GET["alto_panel"];
$alto_title=$_GET["alto_title"];
$alto_footer=$_GET["alto_footer"];

$cuerpo_modal = str_replace("*", "<br>&raquo;", $cuerpo_modal);

	
			  //echo $funcion.'<br />';




?>

<div class="jmgmodal visible" id="modal-alertas" >
	<div class="panel" style="max-height: <?=$alto_panel."%"?> !important">
		<div class="title" style="background-color: #F44336 !important; color: #FFFFFF !important; min-height: <?=$alto_title."%"?> !important">
			<!-- aqui va el titulo 
            	amarillo fuerte FFFF00
                amarillo suave FFFF6A<i class="material-icons">&#xE15D;</i>
            -->
			<span><?=utf8_encode($_GET["titulo_modal"]);?></span>
		</div>
		<div class="content alert-general">
        	<table>
            	<tr>
                	<td><i class="material-icons md-36 red-text prefix">&#xE15D;</i></td>
                	<td><label><?=utf8_encode($cuerpo_modal);?></label></td>
                </tr>
            </table>
			<!-- aqui va el contenido -->
			<!--span style='font-size: 18px;'>Recuerde que su número de solicitud para el seguimiento es el <strong style='font-size: 20px; color: #005395; z-index: 1;'></strong> y el Profesional/Comprador de abastecimiento que le apoyara en el proceso es <strong style='font-size: 20px; color: #005395;'></strong></span -->
		</div>
		<div class="footer" style="min-height: <?=$alto_footer."%"?> !important">
			<!-- aqui van los botones -->

			<button id="button-ok" class="action2 action-alert"  onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="none"' style="background: #F44336 !important;">
            <label style="color: #FFFFFF !important; font-weight: 900; font: bold !important;"><strong>OK</strong></label></button>
			
			<!-- button id="button-ok" class="action2 action-alert"  onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="none"; body.style.overflow = "visible"' style="background: #F44336 !important;"><label style="color: #212121 !important; font-weight: 900; font: bold !important;"><strong>CANCELAR</strong></label></button -->
		</div>
	</div>
</div>