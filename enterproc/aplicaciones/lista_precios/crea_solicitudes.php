<?   include("../../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	


if($session_compra==""){

$alfabeto = array("A","B","C","D","E","F", "G","H","I","J","K","L","M","N","P","Q","R","S","T","U","V", "W","X","Y","Z","1","2","3", "4","5","6","7","8","9");
for($i=0;$i<=15;$i++){
$generador = rand(0,34);
$fuente2.= $alfabeto[$generador];
$session_compra.= $alfabeto[$generador];

}

}
	
//paguinacion
 

$numero_pagi = 10;
if ($pag=="")
	$pag = 1;
else
	$pag = $pag;

$paginador = (($pag-1)*$numero_pagi);


	  $li_n_c=traer_fila_row(query_db("select count(distinct $l2.lista2_id) from $l2, $l3  where $l2.estado = 1  and $l3.lista1_id = $l2.lista1_id 
		 and $l3.us_id = ".$_SESSION["id_us_session"]));
		  $total_r = $li_n_c[0];
		  $pagina = ceil($total_r /$numero_pagi);

if($pag==($pagina))
	$proxima = $pag;
else
	$proxima = $pag +1;
	
if($pag==1)
	$anterior = $pag;
else
	$anterior = $pag -1;	
	
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
<br /><br />

<table width="98%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td width="62%">               
                <fieldset style="width:98%">
			<legend>Buscardor de articulos por listas</legend>
                
                <table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
                  <tr>
                    <td width="78%" class="columna_subtitulo_resultados_economico"><div align="left"></div></td>
                    <td width="7%" class="columna_subtitulo_resultados_economico"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/lista_precios/crea_solicitudes.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
                    <td width="1%" class="columna_subtitulo_resultados_economico"><label>
                      <select name="pagij" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/lista_precios/crea_solicitudes.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">
                        <? 
		  for($i=1;$i<=$pagina;$i++){
		   ?>
                        <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
                          <?=$i;?>
                        </option>
                        <? } ?>
                      </select>
                    </label></td>
                    <td width="6%" class="columna_subtitulo_resultados_economico"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/lista_precios/crea_solicitudes.php','contenidos', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
                  </tr>
                </table>
                  <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
                  <tr>
                    <td width="88" class="titulo_tabla_azul_sin_bordes"><div align="center">Detalle</div></td>
                    <td width="10%" class="titulo_tabla_azul_sin_bordes"><div align="center">Valor</div></td>
                    <td width="1%" class="titulo_tabla_azul_sin_bordes"><div align="center">Cantidad</div></td>
                    <td width="1%" class="titulo_tabla_azul_sin_bordes"><div align="center">Agregar</div></td>
                  </tr>
<?
 $lista_inci = "select  distinct $l2.lista2_id, $l2.detalle , $l2.codigo  from $l2, $l3  where $l2.estado = 1  and $l3.lista1_id = $l2.lista1_id 
		 and $l3.us_id = ".$_SESSION["id_us_session"]." 
		 order by $l2.detalle limit $paginador,$numero_pagi ";
		 $sql_ex=query_db($lista_inci);
		while ($lt=traer_fila_row($sql_ex)){ 
		$busca_mejor_articulo = traer_fila_row(query_db("select * from $l6 where lista2_id = $lt[0] and estado = 1  order by valor asc limit 0,1"));
		$nueva_cadena="";
		$nueva_cadena = ereg_replace("[^A-Za-z0-9]", " ",$lt[1]);
 

?>                  
                  <tr>
                    <td><?=RTESafe($nueva_cadena);?></td>
                    <td><?=$busca_mejor_articulo[3];?></td>
                    <td><input name="cantidad_so_<?=$busca_mejor_articulo[0];?>" type="text" id="cantidad_so_<?=$busca_mejor_articulo[0];?>" size="4" /></td>
                    <td><input name="button6" type="submit" class="guardar" id="button6" value="Agregar" onclick="crea_articulo_temp_uno(<?=$busca_mejor_articulo[0];?>)" /></td>
                  </tr>
<? } ?>                  
                
                </table>
                
                
                
                </fieldset>
                
                </td>
                <td width="38%" valign="top">
                
                         <fieldset style="width:98%">
			<legend>Buscardor de articulos por palabra</legend>
                
                <table width="100%" border="0" cellspacing="3" cellpadding="3">
                  <tr>
                    <td colspan="4"></td>
                  </tr>

                  <tr>
                    <td width="33%">Buscar Articulo:</td>
                    <td width="67%" colspan="3"><div align="left">
                        <label></label>
                        <input name="articulos" type="text" id="articulos" size="30" onkeypress="selecciona_lista()" />
                    </div></td>
                  </tr>
                  <tr>
                    <td >Cantidad solicitada:</td>
                    <td colspan="3"><div align="left">
                        <label>
                        <input type="text" name="cantidad" id="cantidad" />
                        </label>
                    </div></td>
                  </tr>
                </table>
                  <table width="95%" border="0" cellspacing="2" cellpadding="2">
                    <tr>
                      <td><div align="center">
                        <input name="button2" type="button" class="guardar" id="button2" value="Agregar articulo a la solicitud" onclick="crea_articulo_temp()" />
                        </div>
                          </label></td>
                    </tr>
                  </table>
                  
                     </fieldset>
                  
                  
                  </td>
              </tr>
            </table>


<br />
<fieldset style="width:98%">
			<legend>Lista de articulos seleccionados</legend>

            <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td width="5%" class="columna_titulo_resultados"><div align="center">Codigo</div></td>
                <td width="12%" class="columna_titulo_resultados"><div align="center">Categoria</div></td>
                <td width="30%" class="columna_titulo_resultados"><div align="center">Detalle</div></td>
                <td width="23%" class="columna_titulo_resultados"><div align="center">Proveedor</div></td>
                <td width="1%" class="columna_titulo_resultados"><div align="center">D&iacute;as</div></td>
                <td width="6%" class="columna_titulo_resultados"><div align="center">Valor</div></td>
                <td width="8%" class="columna_titulo_resultados"><div align="center">Cantidad </div></td>
                <td width="6%" class="columna_titulo_resultados"><div align="center">Total</div></td>
                <td width="1%" class="columna_titulo_resultados"><div align="center"></div></td>
              </tr>
              <?
			  	$busca_provee = "select $l5.lista5_id, $l2.codigo, $l2.detalle, $l5.valor, 
				$l5.dias_prometidos, $t8.razon_social, $l5.cantidad, $l2.lista1_id , $l1.nombre, $l2.lista2_id
				from $l2, $l5, $l6, $t8, $l1 where
				$l5.session_compra = '$session_compra' and
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
                <td><div align="left">
                  <?=$lp[8];?>
                </div></td>
                <td><div align="left">
                  <?=$lp[2];?>
                </div></td>
                <td><div align="left"><a href="javascript:void(0)" onclick="abre_proveedores('carga_otros_<?=$lp[0];?>', <?=$lp[9];?>, '<?=$lp[0];?>' )">
                  <?=$lp[5];?>
                </a></div></td>
                <td><div align="center">
                    <?=$lp[4];?>
                </div></td>
                <td><div align="right">
                    <?=number_format($lp[3],0);?>
                </div></td>
                <td><div align="center">
                    <input name="cantidad_<?=$lp[0];?>" type="text" id="cantidad_<?=$lp[0];?>" size="3" value="<?=$lp[6];?>" />
                    <input name="button" type="button" class="calcular" id="button" onclick="cambia_cantidad(<?=$lp[0];?>)" value="     " />
                </div></td>
                <?	$total_linea = ($lp[3]*$lp[6]);
					$total+=($total_linea);
					?>
                <td><div align="right">
                    <?=number_format($total_linea,0);?>
                </div></td>
                <td><div align="left"><a href="javascript:void(0)" onclick="elimina_articulo_lista(<?=$lp[0];?>)"><img src="../imagenes/botones/b_cancelar.gif" title="Eliminar Proveedor de la invitaci&oacute;n" /></a></div></td>
              </tr>
              <tr class="<?=$class;?>">
                <td colspan="9" id="carga_otros_<?=$lp[0];?>"></td>
              </tr>
              <? $num_fila++;} ?>
              <tr>
                <td colspan="7" class="columna_titulo_resultados Estilo1"><div align="right">Totales de la solicitud:</div>
                    <div align="right"></div></td>
                <td class="columna_titulo_resultados"><div align="right"><strong>
                    <?=number_format($total,0);?>
                </strong></div></td>
                <td class="columna_titulo_resultados"><div align="left"></div></td>
              </tr>
            </table>
<br />
      <fieldset style="width:98%">
			<legend>Balance general de saldos</legend>      
            <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
              <tr>
                <td class="titulo_tabla_azul_sin_bordes">Categoria</td>
                <td class="titulo_tabla_azul_sin_bordes">Valor asignado total</td>
                <td class="titulo_tabla_azul_sin_bordes">Periocidad de la compra</td>
                <td class="titulo_tabla_azul_sin_bordes">Disponible</td>
                <td class="titulo_tabla_azul_sin_bordes">Valor de la solicitud</td>
                <td class="titulo_tabla_azul_sin_bordes">Valor asignado - Solicitud actual</td>
              </tr>
           <?
		   
		   
		   	$busca_categorias = "select $l1.lista1_id, $l1.nombre, $l3.periocidad , $l3.monto_maximo  from $l1, $l3
			where $l1.lista1_id in (0 $categorias) and $l3.us_id = ".$_SESSION["id_us_session"]."
			and $l3.lista1_id  = $l1.lista1_id  and $l3.estado = 1 ";
			$busca_balance = query_db($busca_categorias);
			while($bb=traer_fila_row($busca_balance)){
		$valor_soli=0;
		$valor_disponible=0;
		$resta_total_disponible=0;	
		$resta_menos_esta_compra=0;	
		$class="";	

		$suma_valores = "select ($l5.valor*$l5.cantidad) from $l5,$l2, $l6 where 
		$l5.session_compra = '$session_compra'  and $l6.lista6_id = $l5.lista6_id  and
		$l2.lista2_id = $l6.lista2_id and $l2.lista1_id = $bb[0]";
		$sql_total = query_db($suma_valores);

		
		while($total =  traer_fila_row($sql_total)){
			$valor_soli+=$total[0];

			}

		$fecha_mes_hoy = date("m", strtotime($fecha));
		$fecha_ano_hoy = date("Y", strtotime($fecha));		

		if($bb[2]=="Diaria")
			$comple = " and $l4.fecha_creacion between '$fecha 00:00:00' and '$fecha 23:59:59' ";
		elseif($bb[2]=="Mensual")
			$comple = " and DATE_FORMAT($l4.fecha_creacion,'%m') = '$fecha_mes_hoy' ";
		elseif($bb[2]=="Anual")
			$comple = " and DATE_FORMAT($l4.fecha_creacion,'%y') = '$fecha_ano_hoy' ";
			

		 $suma_valores_total_disponible = "select ($l5.valor*$l5.cantidad) from $l5,$l2, $l6, $l4 where 
		$l4.us_id = ".$_SESSION["id_us_session"]." and 
		$l5.session_compra <> '$session_compra' and
		$l5.lista4_id  = $l4.lista4_id and $l6.lista6_id = $l5.lista6_id  and
		$l2.lista2_id = $l6.lista2_id and $l2.lista1_id = $bb[0]
		$comple	";
		$sql_disponible = query_db($suma_valores_total_disponible);
		while($l_valores_disponible = traer_fila_row($sql_disponible))
		$valor_disponible+=$l_valores_disponible[0];
			
		$resta_total_disponible = ($bb[3]-$valor_disponible);
		$resta_menos_esta_compra = ($resta_total_disponible-$valor_soli);
		
		if($resta_menos_esta_compra<0)
			{
				$class = "oferta_perdedora";
				$activa_botones = "no";
				$nota.="La categoria ".$bb[1]." No tiene saldo suficiente para esta compra <br>";
			
			}
		
		   ?>
              <tr>
                <td><?=$bb[1];?></td>
                <td><?=number_format($bb[3],0);?></td>
                <td><?=$bb[2];?></td>
                <td><?=number_format($resta_total_disponible,0);?></td>
                <td><?=number_format($valor_soli,0);?></td>
                <td class="<?=$class;?>"><div align="right"><?=number_format($resta_menos_esta_compra,0);?>
                </div></td>
              </tr>
             <? } ?> 
            </table>
            </fieldset>
<br />
<? if($activa_botones==""){ ?>
<table width="95%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td>
                
                
                <label>
                  
                <div align="center">
                  <input name="button3" type="button" class="buscar" id="button3" value="Grabar parcialmente" onclick="guardar_parcial()" />
                </div>
                </label></td>
                <td>
                  <div align="center"></div></td>
                <td><div align="center">
                  <input name="button5" type="button" class="cancelar" id="button5" value="Salir sin grabar cambios" onclick="ajax_carga('../aplicaciones/lista_precios/historico_solicitudes.php','contenidos')" />
                </div></td>
              </tr>
</table>
             <? } ?>
            <? if($activa_botones=="no"){ ?>
            <table width="98%" border="0" cellspacing="2" cellpadding="2">
              <tr>
                <td><div align="left" class="oferta_perdedora">
                  <div align="left">ATENCION: 
                    <?=$nota;?>
                  </div>
                </div>                </td>
              </tr>
            </table>
            <? } ?>
            <br />


<input type="hidden" name="id_elimina"/>
<input type="hidden" name="id_linea"/>
<input type="hidden" name="id_compra" value="<?=$id_compra;?>" />
<input type="hidden" name="session_compra" value="<?=$session_compra;?>" />

<label>
</label>
</body>
</html>
