<?   include("../../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	


 $busca_solicitud = traer_fila_row(query_db("select $l4.lista4_id, $t1.nombre_administrador , $l4.fecha_creacion , $tp10.nombre  from $l4, $t1, $tp10 where lista4_id = $id_compra and $t1.us_id = $l4.us_id and $tp10.tp10_id = $l4.estado"));

	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<title><?=TITULO;?></title>
<link href="../../css/principal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
</style>
</head>

<body>
<div id="popup2" align="center"><div id="pContent"></div></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">SOLICITUD DE ARTICULOS</td>
  </tr>
</table>



<table width="98%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="64%" height="24">Solicitud numero:</td>
    <td width="13%"><div align="left">
      <?=$busca_solicitud[0];?>
    </div></td>
    <td width="12%">Usuario solicitante:</td>
    <td width="11%"><div align="left">
      <?=$busca_solicitud[1];?>
    </div></td>
  </tr>
  <tr>
    <td>Fecha de creaci&oacute;n</td>
    <td><div align="left">
      <?=$busca_solicitud[2];?>
    </div></td>
    <td>Estado</td>
    <td><div align="left">
      <?=$busca_solicitud[3];?>
    </div></td>
  </tr>
</table>
<br />


            <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td colspan="8" class="columna_titulo_resultados">Seleccionar todos los items</td>
                <td class="columna_titulo_resultados"><div align="center">
                  <input type="checkbox" name="c_t" id="c_t" onclick="che_lista()" />
                </div></td>
                <td class="columna_titulo_resultados">&nbsp;</td>
              </tr>
              <tr>
                <td width="5%" class="columna_titulo_resultados"><div align="center">Codigo</div></td>
                <td width="12%" class="columna_titulo_resultados"><div align="center">Categoria</div></td>
                <td width="30%" class="columna_titulo_resultados"><div align="center">Detalle</div></td>
                <td width="23%" class="columna_titulo_resultados"><div align="center">Proveedor</div></td>
                <td width="1%" class="columna_titulo_resultados"><div align="center">D&iacute;as</div></td>
                <td width="6%" class="columna_titulo_resultados"><div align="center">Valor</div></td>
                <td width="8%" class="columna_titulo_resultados"><div align="center">Cantidad </div></td>

                <td width="6%" class="columna_titulo_resultados"><div align="center">Total</div></td>
                <td width="1%" class="columna_titulo_resultados"><div align="center">Completa</div></td>
                <td width="1%" class="columna_titulo_resultados">No entrega</td>
              </tr>
              
              <?
			  	$busca_provee = "select $l5.lista5_id, $l2.codigo, $l2.detalle, $l5.valor, 
				$l5.dias_prometidos, $t8.razon_social, $l5.cantidad, $l2.lista1_id , $l1.nombre, $l2.lista2_id
				from $l2, $l5, $l6, $t8, $l1 where
				$l5.lista4_id  = '$id_compra' and
				$l6.lista6_id  = $l5.lista6_id  and 
				$t8.pv_id = $l6.pv_id and
				$l2.lista2_id = $l6.lista2_id and 
				$l1.lista1_id = $l2.lista1_id order by $t8.razon_social, $l1.nombre ";
				
				$busca_lista = query_db($busca_provee);
				
				 
				while($lp = traer_fila_row($busca_lista)){
			  
	  	$categorias.=", ".$lp[7];
	  
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
  ?>
  <tr class="<?=$class;?>">
  
                <td><div align="left">
                  <?=$lp[1];?>
                </div></td>
                <td><div align="left"><?=$lp[8];?></div></td>
    <td><div align="left"><?=$lp[2];?>
    </div></td>
                <td><div align="left"><?=$lp[5];?></div></td>
                <td><div align="center">
                  <?=$lp[4];?>
                </div></td>
                <td>
                  <div align="right">
                    <?=number_format($lp[3],0);?>
                  </div></td>
			    <td>
			      <div align="center">
			        <?=$lp[6];?>
			      </div></td>
  				<?	$total_linea = ($lp[3]*$lp[6]);
					$total+=($total_linea);
					?>
                <td><div align="right">
                  <?=number_format($total_linea,0);?>
                </div></td>
                <td><div align="left">
                  <label>
                  <div align="center">
                    <input type="checkbox" name="checkbox" id="checkbox" />
                  </div>
                  </label>
                  <div align="center"></div>
                </div>
                  <div align="center"></div><div align="center"></div><div align="center"></div></td>
                <td><label>
                  <div align="center">
                    <input type="checkbox" name="checkbox2" id="checkbox2" />
                  </div>
                </label></td>
  </tr>
  <tr class="<?=$class;?>"><td colspan="10" id="carga_otros_<?=$lp[0];?>"></td></tr>

              <? $num_fila++;} ?>
  <tr>
    <td colspan="7" class="columna_titulo_resultados Estilo1">
      <div align="right">Totales de la solicitud:</div>
      <div align="right"></div></td>
    <td class="columna_titulo_resultados"><div align="right"><strong>
      <?=number_format($total,0);?>
    </strong></div></td>
    <td class="columna_titulo_resultados"><div align="left"></div></td>
    <td class="columna_titulo_resultados">&nbsp;</td>
  </tr>            
            </table>
           
           
            <table width="98%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td><label>
                  <div align="center">
                    <input name="button" type="submit" class="guardar" id="button" value="Grabar informaci&oacute;n" />
                    </div>
                </label></td>
                <td><label>
                  <div align="center">
                    <input name="button5" type="button" class="cancelar" id="button5" value="Salir sin grabar cambios" onclick="ajax_carga('../aplicaciones/lista_precios/historico_solicitudes.php','contenidos')" />
                  </div>
                </label></td>
              </tr>
            </table>
<fieldset style="width:98%">
			<legend><br />


            <input type="hidden" name="id_elimina"/>
            <input type="hidden" name="id_linea"/>
            <input type="hidden" name="id_compra" value="<?=$id_compra;?>" />
</legend>      
            </fieldset>
<label>
</label>
</body>
</html>
