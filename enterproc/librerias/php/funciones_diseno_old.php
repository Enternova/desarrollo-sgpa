<?
	function banner(){ global $fecha,$hora; 
	if($_SESSION["tipo_usuario"]==1) $tipo_usuario="Administrador";
	if($_SESSION["tipo_usuario"]==2) $tipo_usuario="Proveedor";
	if($_SESSION["tipo_usuario"]==3) $tipo_usuario="Comprador";	
	if($_SESSION["tipo_usuario"]==4) $tipo_usuario="Auditor";		
	?>
	<div id="cargando" style="display:none">Cargando...</div>
    <div  class="fondo_cabecera">
    <table width="100%" border="0" cellspacing="2" cellpadding="2" >
      <tr>
        <td width="19%"><img src="<?=URL_SITIO;?>imagenes/coorporativo/logo-cliente-blanco.jpg" /></td>
        <td width="50%" valign="middle" align="left" class="titulo_menu_tarifas" id="titulo_modulo">Sistema de gesti&oacute;n y planeaci&oacute;n de abastecimiento SGPA<br />
MODULO: <span class='sub_titulos_modulos_2'>URNA VIRTUAL</span></td>
        <td width="31%" valign="top" align="right" class="titulo_menu_tarifas_2">Usuario conectado: <?=$_SESSION["us_nombre_session"];?><br />
          Perfil del usuario: <?=$tipo_usuario;?><br />
          <div id="reloj_general">Fecha y hora actual:<?=fecha_for_hora($fecha." ".$hora);?></div></td>
      </tr>
    </table>
    </div>
    
	
	

	
	<? }
	
function banner_afuera(){ global $fecha,$hora; 
	?>
    <div  class="fondo_cabecera">
    <table width="100%" border="0" cellspacing="2" cellpadding="2" >
      <tr>
        <td width="19%"><img src="<?=URL_SITIO;?>imagenes/imagen/logo_ebiding_blanco.png" /></td>
        <td width="50%" valign="middle" align="left" class="titulo_menu_tarifas">Portal de compras y contrataciones<br />&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;Grantierra Energy Colombia Limited</td>
        
      </tr>
    </table>
    </div>
    
	
	
	<? }
	

function fecha_for_hora($fecha_enviada)
	{
		global $fecha, $hora;
		
			$fecha_arr = explode(" ",$fecha_enviada);
			$fecha_arregla = explode("-",$fecha_arr[0]);
				if($fecha_arregla[1]=='01')
					$mes_arre = "Ene";
				if($fecha_arregla[1]=='02')
					$mes_arre = "Feb";
				if($fecha_arregla[1]=='03')
					$mes_arre = "Mar";
				if($fecha_arregla[1]=='04')
					$mes_arre = "Abr";
				if($fecha_arregla[1]=='05')
					$mes_arre = "May";
				if($fecha_arregla[1]=='06')
					$mes_arre = "Jun";
				if($fecha_arregla[1]=='07')
					$mes_arre = "Jul";
				if($fecha_arregla[1]=='08')
					$mes_arre = "Ago";
				if($fecha_arregla[1]=='09')
					$mes_arre = "Sep";
				if($fecha_arregla[1]=='10')
					$mes_arre = "Oct";
				if($fecha_arregla[1]=='11')
					$mes_arre = "Nov";
				if($fecha_arregla[1]=='12')
					$mes_arre = "Dic";
					
					return $fecha_arregla[2]." ".$mes_arre." ".$fecha_arregla[0]." ".$fecha_arr[1];
	
	}	
	
	

?>