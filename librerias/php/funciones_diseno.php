<?



	function banner(){ global $fecha,$hora, $texto_modulo_pruebas; 
	if($_SESSION["tipo_usuario"]==1) $tipo_usuario="Administrador";
	if($_SESSION["tipo_usuario"]==2) $tipo_usuario="Proveedor";
	if($_SESSION["tipo_usuario"]==3) $tipo_usuario="Comprador";	
	if($_SESSION["tipo_usuario"]==4) $tipo_usuario="Auditor";		

$instruccion_cuenta = "select count(*) from v_mesa_ayuda_princiapal  where us_id = ".$_SESSION["id_us_session"]." and estado = 2 and estado_firme = 1  ";
$cuenta_novedades = traer_fila_row(query_db($instruccion_cuenta));
	
	
	?>
	<div id="cargando" style="display:none">Cargando...</div>

    <table width="100%" border="0" cellspacing="2" cellpadding="2" class="fondo_cabecera">
      <tr>
        <td width="17%"><img src="<?=URL_SITIO;?>imagenes/coorporativo/logo-cliente.png" height="50" /></td>
        <td width="52%" align="left" valign="middle"  ><div id="titulo_modulo">ALERTAS GENERALES DEL SGPA </div>
        <div class="contenido_logo_texto"> 
                <div class="contenido_logo_texto_usu"> Usuario conectado:<?=$_SESSION["us_nombre_session"];?> &nbsp; </div> 
                <div class="numero_novedades" id="numero_novedades" onClick="evalua_click()"><span class="span-push" id="span-push" style="font-size: 10pt;"></span><a class="btn-floating-push indigo darken-2" id="muestra-notifiaciones" style="display: none; background-color: transparent !important;"></a></div><div id="load-hystory" class="load-hystory" style="background: #FFF;"><div class="alertas_notifiaciones" id="alertas_notifiaciones"></div></div>
                <!-- rosado: E81E63  amarillo: FEC007 naranja: FE5722  azul claro: 03A9F3 -->
        </div>
            </div>
            
         <br />	</td>
        <td width="31%" align="right" valign="top" class="letra_azul_pequena"><img src="<?=URL_SITIO;?>imagenes/coorporativo/logo-cliente-blanco.jpg" height="80" /></td>
      </tr>
      </table>
</div>
    
	
	
	<? }
	
function banner_afuera(){ global $fecha,$hora, $texto_modulo_pruebas; 
	?>
    <div  class="fondo_cabecera">
    <table width="100%" border="0" cellspacing="2" cellpadding="2" >
      <tr>
        <td width="17%"><img src="<?=URL_SITIO;?>imagenes/coorporativo/logo-cliente.png" height="50" /></td>
        <td width="52%" align="left" valign="middle"  ><div id="titulo_modulo">Sistema de gesti&oacute;n y planeaci&oacute;n de abastecimiento <strong>(SGPA)</strong> <?=$texto_modulo_pruebas?></td>
        <td width="31%" align="right" valign="top" class="letra_azul_pequena"><img src="<?=URL_SITIO;?>imagenes/coorporativo/logo-cliente-blanco.jpg" height="80" /></td>
      </tr>
      </table>
    </div>
    
	
	
	<? }
	


	

?>