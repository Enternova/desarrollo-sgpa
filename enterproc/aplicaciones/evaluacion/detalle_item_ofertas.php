<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
   

$busca_lista = traer_fila_row(query_db("select * from $t95 where evaluador5_id  = $evaluador5_id    "));
   
?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css">
</head>
<body >
</p>
<fieldset style="width:98%">
			<legend>Detalle de ofertas por item</legend>
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><label>
      <input name="button" type="button" class="cancelar" id="button" value="Volver a la evaluaci&oacute;n" onClick="volver_listado('detalle_item','detalle_item_2')">
    </label></td>
  </tr>
</table>
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="33%" valign="top"><table width="95%" border="0" align="left" cellpadding="2" cellspacing="2">
      <tr>
        <td width="25%" class="campos_blancos_listas_evaluador_titulos_campos"><strong>Codigo:</strong></td>
        <td width="75%" class="columna_subtitulo_resultados_economico"><div align="left">
          <?=$busca_lista[2];?>
        </div></td>
      </tr>

      <tr>
        <td class="campos_blancos_listas_evaluador_titulos_campos"><strong>Medida:</strong></td>
        <td class="columna_subtitulo_resultados_economico"><div align="left">
          <?=$busca_lista[4];?>
        </div></td>
      </tr>
      <tr>
        <td class="campos_blancos_listas_evaluador_titulos_campos"><strong>Cantidad:</strong></td>
        <td class="columna_subtitulo_resultados_economico"><div align="left">
          <?=$busca_lista[5];?>
        </div></td>
      </tr>
      <tr>
        <td class="campos_blancos_listas_evaluador_titulos_campos"><strong>Moneda:</strong></td>
        <td class="columna_subtitulo_resultados_economico"><div align="left">
          <?=$busca_lista[6];?>
        </div></td>
      </tr>
      <tr>
        <td class="campos_blancos_listas_evaluador_titulos_campos"><strong>Detalle:</strong></td>
        <td class="columna_subtitulo_resultados_economico"><div align="left">
          <?=$busca_lista[3];?>
        </div>          </td>
      </tr>
    </table>
      <br>
      <table width="95%" border="0" align="left" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
        <tr>
          <td width="19%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
          <td width="15%" class="titulo_tabla_azul_sin_bordes">Fecha</td>
          <td width="21%" class="titulo_tabla_azul_sin_bordes">Oferta</td>
        </tr>
        <?
			  $sql_detalle = "select distinct $t8.razon_social,  $t20.w_valor, $t20.pv_id from $t8, $t20 where $t20.evaluador5_id = $evaluador5_id and $t20.evaluador4_id = $evaluador4_id and $t8.pv_id = $t20.pv_id order by $t20.w_fecha_creacion ";
				$sql_exq = query_db($sql_detalle);				
				while($lp = traer_fila_row($sql_exq)){
	  				$busca_fecha = traer_fila_row(query_db("select w_fecha_creacion from $t20 where evaluador5_id = $evaluador5_id and evaluador4_id = $evaluador4_id and pv_id = $lp[2] and w_valor =  $lp[1] order by w_fecha_creacion desc"));
						if($num_fila%2==0)
							$class="campos_blancos_listas";
						else
							$class="campos_gris_listas";

  ?>
        <tr class="<?=$class;?>">
          <td><?=$lp[0];?></td>
          <td><?=$busca_fecha[0];?></td>
          <td><?=number_format($lp[1],2);?></td>
        </tr>
        <? $num_fila++;} ?>
      </table></td>
    <td width="67%"><div align="center">
      <iframe src="../aplicaciones/evaluacion/grafica_item_detalle.php?evaluador5_id=<?=$evaluador5_id;?>&evaluador4_id=<?=$evaluador4_id;?>" width="650" height="480" frameborder="0">
      <div align="right"></div>
      </iframe>
    </div>    </td>
  </tr>
</table>

</fieldset>

</body>
</html>
