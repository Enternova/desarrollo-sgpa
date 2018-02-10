<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
$proveedores_busca = elimina_comillas_2($_GET["proveedores_busca"]);	
$nit_busca = elimina_comillas_nit($_GET["nit_busca"]);	

	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<head>

<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>
<table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="7"  class="titulos_secciones">Selecci&oacute;n de Proveedores para el Servicio Menor</td>
        </tr>
      </table>
      <br />
      <table width="70%" border="0" align="center"  class="tabla_borde_griz">
      
        <tr>
          <td colspan="3" align="center"  class="fondo_3">Buscar para Agregar Proveedores al Servicio Menor</td>
        </tr>
        <tr>

          <td width="341" align="right">Buscar  por Raz&oacute;n Social </td>
          <td width="569"><input name="proveedores_busca" type="text" id="proveedores_busca" size="20" value="<?=$proveedores_busca?>"/></td>
          <td width="328" align="center">&nbsp;</td>
        </tr>
        <tr>
          <td align="right">NIT:</td>
          <td><input name="nit_busca" type="text" id="nit_busca" size="20" value="<?=$nit_busca?>"/></td>
          <td align="center"><input name="button_busca2" type="button" class="boton_buscar" id="button_busca2" value="Realizar B&uacute;squeda" onclick="ajax_carga('../aplicaciones/pecc/carga_proveedores_servicio_menor.php?id_pecc=1&id_tipo_proceso_pecc=1&proveedores_busca='+document.principal.proveedores_busca.value+'&nit_busca='+document.principal.nit_busca.value, 'contenidos')" /></td>
        </tr>
        <tr>
          <td colspan="3" align="right"></td>
        </tr>
    </table>
<br />
<?
if($proveedores_busca != "" or $nit_busca != ""){// solo si realizo busqueda
?>
      <table width="90%" border="0" align="center"  class="tabla_borde_griz">
        <tr>
          <td colspan="7" align="center"  class="fondo_3">Resultado de la B&uacute;squeda</td>
        </tr>
        <tr>
          <td width="23%" align="center" class="fondo_3">Estado Par Servicios</td>
          <td width="38%" align="center" class="fondo_3">Raz&oacute;n Social</td>
          <td width="9%" align="center"  class="fondo_3">Nit</td>
          <td width="11%" align="center"  class="fondo_3">Valor Disponible <strong>USD$</strong></td>
          <td width="7%" align="center"  class="fondo_3">Ver Reporte</td>
          <td width="7%" align="center"  class="fondo_3">Ver Calificaci&oacute;n</td>
          <td width="12%" align="center"  class="fondo_3">Agregar Este Proveedor a Este Servicio Menor</td>
        </tr>
        <?
					$comple_sql = "";
					
					if($nit_busca != ""){
						$comple_sql = " nit like '%".$nit_busca."%'";
						}
					if($proveedores_busca != ""){	
						if($nit_busca != ""){ $comple_sql.=" or ";}					
						$comple_sql.= " razon_social  like '%".$proveedores_busca."%'";
						}
					
	
           // $sel_proveedores = query_db("select * from t1_proveedor where $comple_sql  and estado = 1 and creado_actualizado_desde_par = 'SI' and estado_parservicios in ('Completo','En Aprobacion', 'Convenios y Pagos', 'En Espera')" );
	

		    $sel_proveedores = query_db("select * from t1_proveedor where $comple_sql  and estado = 1 and creado_actualizado_desde_par = 'SI' and (estado_parservicios not in  ('Sin Pago'))" );
			while($se_prove = traer_fila_db($sel_proveedores)){
				
			$valores_sm = explode("*",disponible_serv_menor_ano_atras($se_prove[0], 0));
//				[0]=total_comprometido --- [1]=comprometido_sap --- [2]=comprometido_no_sap --- [3]=valor_solicitud_Actual  --- [4]=valor_disponible

if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
				
				$sel_fecha_actualizacion_par = traer_fila_row(query_db("select fecha_creacion from Zlog_parservicios where nit = '".$se_prove[1]."'  order by id_ingreso desc"));
			
			?>
        <tr  class="<?=$clase?>">
          <td align="center"><?=$se_prove[6]?> <?if($sel_fecha_actualizacion_par[0]!="") {?><br />Actualizaci&oacute;n: <?=$sel_fecha_actualizacion_par[0]?><? }?></td>
          <td align="center"><?=$se_prove[3]?></td>
          <td align="center"><?=comprobar_nit_en_par($se_prove[1])?></td>
          <td align="center"><? echo number_format($valores_sm[4],0); if($valores_sm[4] < 0) echo "<strong class='letra-descuentos'> - Sin Disponible</strong> ";?></td>
          <td align="center"><img src="../imagenes/botones/busqueda.gif" width="16" height="16" onclick="abrir_ventana('../aplicaciones/pecc/reporte_ser_menor.php?id_proveedor=<?=$se_prove[0]?>')" /></td>
          <td align="center"><img src="../imagenes/botones/busqueda.gif" width="16" height="16" onclick="abrir_ventana('../aplicaciones/desempeno/reporte_general_proveedor.php?id_proveedor=<?=arreglo_pasa_variables($se_prove[0])?>')" /></td>
          <td align="center"><img src="../imagenes/botones/chulo_sin_fondo.gif" width="23" height="20"  onclick="<? if($valores_sm[4] <= 0) { echo 
              "muestra_alerta_error_solo_texto('', 'Error', 'El proveedor que intenta agregar al servicio menor supero el monto de USD $".number_format($_SESSION["valor_maximo_ser_menor"],0)." anuales, por favor consulte el reporte &oacute; comun&iacute;quese al &aacute;rea de abastecimiento para mayor detalle', 17, 5, 20)";} else { ?>   muestra_alerta_general_solo_texto('agrega_proveedor_ser_menor(-comillas-nuevo_solictante-comillas-, <?=$se_prove[0]?>,-comillas--comillas-,-comillas--comillas-)', 'Advertencia', 'En cumplimiento con el proceso de Abastecimiento, el usuario solo debe proponer proveedores y no solicitar ofertas ni realizar negociaci&oacute;n con ellos')  <? }?> "/></td>
        </tr>
       
        <?
            }
						
			?>
             <tr>
               <td colspan="6" align="left">&nbsp;</td>
             </tr>
             <tr>
          <td colspan="6" align="left">
          <?=ayuda_alerta("<strong>Ayuda:</strong> Si el proveedor no aparece en la lista del resultado, pruebe escribiendo<br />
* La raz&oacute;n social<br />
* Parte de la raz&oacute;n social<br />
* N&uacute;mero de nit sin digito de verificaci&oacute;n<br />
Si de todas formas a&uacute;n no encuentra el proveedor por favor de un <font color='#0000FF' style='cursor:pointer' onclick=\"ajax_carga('../aplicaciones/pecc/ajax.php?tipo_ajax=crea_proveedor_serv_menor_solicitante','carga_form_prove_crear')\">Click aqu&iacute; para sugerir otro(s) Proveedor(es). </font></font>")?>
          
          
          </td>
        </tr>
             <tr>
               <td colspan="6" align="left"><div  id="carga_form_prove_crear"></div></td>
             </tr>
      </table>
      <?
      }// solo si realizo busqueda
	  ?>
<p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p>&nbsp;</p>
      <p><br />
        
      </p>
      <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="7" align="right"  class="titulos_secciones"><input name="button2" type="button" class="boton_volver" id="button2" value="Click aqu&iacute;, si no va a agregar ning&uacute;n proveedor a este servicio menor" onclick="agrega_proveedor_ser_menor('sin_proveedor')"/></td>
        </tr>
</table>
<table width="100%" border="0">
        <tr>
          <td>&nbsp;</td>
        </tr>
</table>

<input type="hidden" name="id_proveedor_a_relacionar" id="id_proveedor_a_relacionar" />
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="0" />
<script>
 
 </script>
</body>
</html>
