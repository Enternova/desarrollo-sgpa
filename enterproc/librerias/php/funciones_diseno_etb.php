<?
	function banner(){?>
	
    <table width="95%" border="0" cellpadding="2" cellspacing="2">
      <tr>
        <td><img src="<?=URL_SITIO;?>imagenes/imagen/logo_etb.png" /></td>
      </tr>
    </table>

    
	
	
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