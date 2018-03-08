<? include("../../librerias/lib/@session.php");?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml"><head>
<link href="css/reloj.css" rel="stylesheet" type="text/css" />
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<title><?=TITULO;?></title>

<script type="text/javascript" src="../librerias/ajax/ajax_01.js"></script>
<script type="text/javascript" src="../librerias/jquery/menu1/milonic_src.js"></script>
<script type="text/javascript" src="../librerias/jquery/menu1/mmenudom.js"></script>
<script type="text/javascript" src="../librerias/js/procesos_proveedor.js"></script>
<? include("../../librerias/jquery/menu1/contenido_proveedor.php");?>

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




<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />

<script type="text/javascript">

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
					numberOfMonths: 3,
					dateFormat: 'yy-mm-dd',
					timeFormat: 'hh:mm:ss'


				});
			});
}

		</script>


<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<?=banner();?>


<form name="principal" method="post" enctype="multipart/form-data">
<br />
  <table width="100%" border="0" cellpadding="0" cellspacing="0" >
    <tr>
      <td width="200px" valign="top"><table width="190px" border="0" align="left" cellpadding="2" cellspacing="2">
          <tr>
            <td class="fondo_1" align="center">0</td>
            <td class="fondo_2" onclick="window.parent.location.href='../../sistema-sgpa/proveedores.html'">Menu principal</td>
          </tr>
          <tr>
            <td width="28" class="fondo_1" align="center"><div align="center">1</div></td>
            <td width="148" class="fondo_2" onclick="window.parent.location.href='procesos.html'"><div align="left">Invitaci&oacute;nes en curso</div></td>
          </tr>
          <tr>
            <td class="fondo_1"><div align="center">2</div></td>
            <td class="fondo_2"  onclick="ajax_carga('historico_invitaciones.html','contenidos')"><div align="left">Historico de invitaci&oacute;nes</div></td>
          </tr>
          <tr>
            <td class="fondo_1"><div align="center">3</div></td>
            <td class="fondo_2" <? if($_SESSION["pv_principal"]==0){?>onclick="ajax_carga('mi_perfil.html','contenidos')"<? } ?>><div align="left">Admin. usuario</div></td>
          </tr>

          <tr>
            <td align="center" class="fondo_1"><div align="center">4</div></td>
            <td class="fondo_2" onclick="ajax_carga('mi_soporte_tecnico.html','contenidos')">Soporte t&eacute;cnico</td>
          </tr>
          <tr>
            <td align="center" class="fondo_1"><div align="center">5</div></td>
            <td class="fondo_2" onclick="window.parent.location.href='../../index.php'"><div align="left">Salida segura</div></td>
          </tr>
      </table></td>
      <td width="1200px" ><table width="100%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="2%" class="esquina_s_iz">&nbsp;</td>
            <td width="95%" class="linea_sup">&nbsp;</td>
            <td width="3%"  class="esquina_s_der">&nbsp;</td>
          </tr>
          <tr>
            <td class="linea_iz">&nbsp;</td>
            <td id="contenidos2"><table width="100%" border="0" cellpadding="0" cellspacing="0">
              <tr>
                <td id="contenidos">
               
               <table width="99%" border="0" cellspacing="5" cellpadding="2">
  <tr>
                <td colspan="4" class="titulos_procesos">NOTIFICACIONES PENDIENTES DE LECTURA</td>
                </tr>
</table>
 
                <table width="99%" border="0" cellspacing="2" cellpadding="2"  class="tabla_borde_azul_fondo_blanco">
             
              <tr >
                <td width="14%" class="tabla_sin_borde_fondo_gris"><div align="center">Consecutivo</div></td>
                <td width="54%" class="tabla_sin_borde_fondo_gris"><div align="center">Asunto</div></td>
                <td width="17%" class="tabla_sin_borde_fondo_gris"><div align="center">Fecha de envio</div></td>
                <td width="15%" class="tabla_sin_borde_fondo_gris"><div align="center">Acciones</div></td>
                </tr>
                
                <?
					$busca_noti_adj = "select distinct pro30_id,pro27_id, consecutivo, fecha_envio, if(tipo_adj_no_adj=1,'Adjudicación del proceso', 'NO adjudicación del proceso'),pro1_id,estado,if(acepta_terminos IS NULL,1,acepta_terminos) as acp_termino, tipo_adj_no_adj from $vt15 where pv_id = ".$_SESSION["id_proveedor"]." and notificado = 1 and  ( estado = 1  or  estado IS NULL)  order by fecha_envio desc ";
					$sql_adju = query_db($busca_noti_adj);
					while($ls_adju=traer_fila_row($sql_adju)){//busca adjudicaciones o no
					
					$busca_visulaizacion = traer_fila_row(query_db("select count(*) from $t47 where pro30_id = $ls_adju[0]"));
					if( ($busca_visulaizacion[0]==0) || ($ls_adju[7]==0) ){//muestra alertas
					
					if($ls_adju[8]==1)
						$ruta_ingre = "adjudicacion_paso1";
					elseif($ls_adju[8]==2)
						$ruta_ingre = "adjudicacion_paso1_no";
					elseif($ls_adju[8]==4)
						$ruta_ingre = "adjudicacion_paso1_otros";

				if($ls_adju[8]==4) $estados_proceso = "Notificación del estado del proceso";
				else $estados_proceso= $ls_adju[4];

				?>
              <tr>
                <td><?=$ls_adju[2];?></td>
                <td><?=$estados_proceso;?></td>
                <td><?=fecha_for_hora($ls_adju[3]);?></td>
                <td><input type="button" name="button2" id="button2" value="Ver notificaci&oacute;n" class="buscar" onClick="ajax_carga('../aplicaciones/proveedores/<?=$ruta_ingre;?>.php?id_invitacion_pasa=<?=arreglo_pasa_variables($ls_adju[5]);?>&id_notificacion=<?=$ls_adju[0];?>&pro27_id=<?=$ls_adju[1];?>','contenidos')" /></td>
                </tr>
                <?
				}//muestra alertas
				 } ?>
            </table>
                
                <br />
                <table width="100%" border="0" align="center" cellpadding="0" cellspacing="5">
                    <tr>
                      <td class="titulos_procesos"> INVITACIONES EN PROCESO</td>
                    </tr>
                  </table>
                    <table width="100%" border="0" align="left" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
                      <tr>
                        <td colspan="6" class="titulo_tabla_azul_sin_bordes">Lista de invitaciones en proceso o por abrir</td>
                      </tr>
                      <tr>
                        <td width="12%" class="tabla_sin_borde_fondo_gris"><div align="center">Consecutivo</div></td>
                        <td width="18%" class="tabla_sin_borde_fondo_gris"><div align="center">Tipo de proceso</div></td>
                        <td width="15%" class="tabla_sin_borde_fondo_gris"><div align="center">Apertura</div></td>
                        <td width="19%" class="tabla_sin_borde_fondo_gris"><div align="center">Cierre</div></td>
                        <td width="15%" class="tabla_sin_borde_fondo_gris"><div align="center">Responsable</div></td>
                        <td width="21%" class="tabla_sin_borde_fondo_gris"><div align="center">Acciones</div></td>
                      </tr>
                      <?  
  	$busca_procesos = "select $t5.pro1_id, $tp2.nombre, $tp6.nombre, $tp5.nombre, $t5.fecha_apertura, $t5.fecha_cierre, $t1.nombre_administrador, $t5.consecutivo  
	 from $tp2, $tp6, $tp5, $t1, $t5, $t7 where 
	$tp2.tp2_id = $t5.tp2_id and
	$tp6.tp6_id = $t5.tp6_id and
	$tp5.tp5_id = $t5.tp5_id and
	$t1.us_id = $t5.us_id_contacto and
	$t7.pro1_id = $t5.pro1_id  and 
	$t5.notificacion = 1 and $t5.tp1_id in (2,4) and 
	$t7.pv_id = ".$_SESSION["id_proveedor"]." and $t7.estado = 1 order by $t5.fecha_cierre desc ";
	
	$sql_ex = query_db($busca_procesos);
	while($ls=traer_fila_row($sql_ex)){

		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";

  ?>
                      <tr class="<?=$class;?>">
                        <td><?=$ls[7];?></td>
                        <td><?=$ls[1];?></td>
                        <td><?=fecha_for_hora($ls[4]);?></td>
                        <td><?=fecha_for_hora($ls[5]);?></td>
                        <td><?=$ls[6];?></td>
                        <td><input name="button" type="button" class="buscar"  id="button" onClick="ajax_carga('detalle_invitacion_<?=arreglo_pasa_variables($ls[0]);?>.php','contenidos')" value="Ingresar a la Invitaci&oacute;n"></td>
                      </tr>
                      <? $num_fila++; } ?>
                  </table></td>
              </tr>
            </table></td>
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
  <p><br />
  </p>
  <p>&nbsp;</p>
  <input type="hidden" name="accion" />  

<script>
function cambia_fecha_srev(i)
		{
//
			if(i>=5)
				{
				//alert(i)
				ajax_carga_02('../administracion-general/muestra-reloj_ad.php','reloj_general');
					i=0;
				}
			i++;
			y=i	
			setTimeout("cambia_fecha_srev(y)",1000);		
		}
		
//cambia_fecha_srev(1)
</script>

</form>

<div  class="fondo_cabecera">
      <table width="100%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td><img src="../../imagenes/coorporativo/logo final-01.png" width="133" height="36" /></td>
          <td class="letra_azul_pequena">Si tiene problemas con la funcionabilidad del sistema por favor comun&iacute;quese al PBX (57 1 255 0916),
Dise&ntilde;ado y Desarrollado por Enterprise Technological Innovation S.A.S. Bogot&aacute; 2011.</td>
        </tr>
      </table>
</div>
<iframe name="grp" frameborder="0" width="0" height="0"></iframe>

</body>
</html>
