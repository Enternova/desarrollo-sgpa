<?  include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

    verifica_menu("procesos.html");
	
	$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	$us_cliente = $_SESSION["id_proveedor"];

 	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$busca_listas_creadas = "select count(*),pro11_id,requiere_aui from $t19 where pro1_id = $id_invitacion group by pro1_id";
	$sql_listas = traer_fila_row(query_db($busca_listas_creadas));
	if($sql_listas[0]>=2){
	$id_lista=$id_lista;
	$muestra_listas=1;
	}
	else{
	$id_lista=$sql_listas[1];
	$requiere_aui=$sql_listas[2];
	
	}
	
	




if($accion_crea=="crea_oferta")
	{
		$busca_valores_ing_oferta=traer_fila_row(query_db("select max(oferta) from $tabla_economica  where pv_id = $us_cliente"));
		$oferta = ($busca_valores_ing_oferta[0]+1);
	}


$numero_pagi = 25;
if ($pag=="")
	$pag = 1;
else
	$pag = $pag;

$paginador = (($pag-1)*$numero_pagi);

		  $li_n_c=traer_fila_row(query_db("select count(*) from $t95 where in_id = $id_invitacion and pro11_id = $id_lista "));
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



if($oferta<=0)
$oferta=1;
else
$oferta=$oferta;
?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<script language="JavaScript" type="text/javascript" src="../librerias/js/val_02.js"></script>

<script>





	

</script>
<link href="../css/principal.css" rel="stylesheet" type="text/css">

<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
<table width="98%" border="0" cellpadding="0" cellspacing="5">
  <tr> 
      
      <td class="titulos_procesos">  PROPUESTA ECON&Oacute;MICA<br>
      <span class="titulosec1"></span></td>
  </tr>
</table>  
  
  <table width="98%" border="0" align="center" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
    <tr>
      <td></td>
      <td></td>
    </tr>
    <tr>
      <td colspan="2" class="columna_titulo_resultados"><strong>Informaci&oacute;n General del Proceso  | Consecutivo del proceso
        <?=$sql_e[22];?>
      </strong></td>
    </tr>
    <tr>
      <td class="columna_subtitulo_resultados"><div align="right"><strong>Estado del proceso:</strong></div></td>
      <td class="texto_paginador_proveedor"><?=listas_sin_select($tp1,$sql_e[1],1);?></td>
    </tr>
    <tr>
      <td width="21%" class="columna_subtitulo_resultados"><div align="right"><strong> Tipo de proceso:</strong></div></td>
      <td width="79%" class="filas_resultados"><strong class="filas_resultados" >
        <?=listas_sin_select($tp2,$sql_e[2],1);?>
      </strong></td>
    </tr>
    <tr>
      <td class="columna_subtitulo_resultados"><div align="right"><strong>Tipo de solicitud:</strong></div></td>
      <td ><strong>
        <?=listas_sin_select($tp3, $sql_e[3], 1);?>
      </strong></td>
    </tr>
    <tr>
      <td class="columna_subtitulo_resultados"><div align="right"><strong>Persona de contacto:</strong></div></td>
      <td class="filas_resultados"><?=listas_sin_select($t1, $sql_e[15], 1);?></td>
    </tr>
    <tr>
      <td class="columna_subtitulo_resultados"><div align="right"><strong>
          <?=$lenguaje_0;?>
        :</strong></div></td>
      <td ><strong>
        <?=$sql_e[12];?>
      </strong></td>
    </tr>
  </table>
<table width="95%" border="0" cellspacing="2" cellpadding="2">
    <tr>
      <td width="84%">&nbsp;</td>
      <td width="16%">
        <input name="button6" type="button" class="cancelar" id="button6" value="Volver al proceso" onClick="ajax_carga('detalle_invitacion_<?=$id_invitacion_pasa;?>.php','contenidos')">
   </td>
  </tr>
</table>
  
  <? if ($muestra_listas==1){ //muestra cuadro de lista por que hay mas de una ?>
<table width="98%" border="0" cellpadding="2" cellspacing="2">
    <tr>
      <td width="81%"><div align="left">
        <p><img src="../imagenes/botones/help.gif" alt="" width="18" height="18"> AYUDA: Para ingresar a las listas de cotizaci&oacute;n , seleccione de las siguiente lista del proceso para cotizar y diligencie los campos solicitados.<br>
        </p>
        </div></td>
    </tr>
    <?
		if($id_lista>=1){
		$busca_listas_creadas = "select * from $t19 where pro11_id = $id_lista";
		$sql_listas = traer_fila_row(query_db($busca_listas_creadas));
		$titulo_lista="Usted esta en la lista: ".$sql_listas[2];
		$requiere_aui=$sql_listas[3];
		}
		else
			$titulo_lista="Por favor seleccione una lista para ofertar";
													
													?>
</table>
  <br>
  
  
<table width="98%" border="0" align="left" cellpadding="2" cellspacing="2">
<tr>
      <td width="58%" valign="top" class="titulo_tabla_azul_sin_bordes">Lista seleccionada para cotizar</td>
      <td width="42%" class="titulo_tabla_azul_sin_bordes">Listas del proceso para cotizar</td>
  </tr>
    <tr>
      <td valign="top"><div align="center" class="telefono_contacto">
        <?=$titulo_lista;?></div></td>
      <td><table width="95%" border="0" cellspacing="2" cellpadding="2">
          <tr>
            <td width="87%"><select name="listas" onChange="ajax_carga(this.value,'contenidos')">
                <option value="../aplicaciones/evaluacion/c_economico.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&tipo_busq=min&id_lista=<?=$ex_listas[0];?>">Seleccione una lista</option>
                <?
					$busca_listas_creadas = "select * from $t19 where pro1_id = $id_invitacion";
					$sql_listas = query_db($busca_listas_creadas);
					while($ex_listas = traer_fila_row($sql_listas)){ 
				?>
              <option value="../aplicaciones/proveedores/c_economico.php?id_invitacion_pasa=<?=$id_invitacion_pasa;?>&termino=2&oferta=1&id_lista=<?=$ex_listas[0];?>"><?=$ex_listas[2];?></option>
                <? } ?>
              </select>
            </td>
          </tr>
      </table></td>
    </tr>
</table>
<p>&nbsp;</p>
<?  }//muestra cuadro de lista por que hay mas de una ?>
 



   <? if($id_lista!=0){ //si tiene listas creadas
   
  	$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista");
	while($l_campo = traer_fila_row($busca_campos)){  
  	$titulo_campos.="<td width='10%' align='center' class='titulo_tabla_azul_sin_bordes'>".$l_campo[2]."</td>";
	$numero++;
  													} 
	if($campo_mejor_oferta!=""){													
	$titulo_campos.="<td width='15%' align='center' class='titulo_tabla_azul_sin_bordes'>Estado de su Oferta</td>";	$numero+=1;											
	}
	
	$concatena_titulo = ($numero+5);


?>
<div id="acualiza_consolidado_es">
<?=$tabla_semaforo_consolidado;?>
</div>

<?

$busca_campo_subasta = traer_fila_row(query_db("select evaluador3_valor from $t93 where in_id = $id_invitacion and evaluador3_termino=4 and peso_evaluacion = $id_lista"));
$campo_mejor_oferta=$busca_campo_subasta[0];
   
   
   ?>

<br>


<table width="98%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
     <tr>
       <td width="85%" class="tabla_paginador"><div align="right" class="texto_paginador_proveedor"><strong>Numero de p&aacute;ginas en esta lista: <?=$pagina;?></strong></div></td>
       <td width="3%" class="tabla_paginador"><div align="center"><a href="javascript:paginacion_lista_histo(<?=$anterior;?>)"> <img src="../imagenes/botones/arrow-left-16.gif" alt="P&aacute;gina anterior" width="14" height="13"></a></div></td>
       <td width="9%" class="tabla_paginador"><label>
       <select name="select" onChange="javascript:paginacion_lista_histo(this.value)">
         <? 
		  for($i=1;$i<=$pagina;$i++){
		   ?>
         <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>P&aacute;gina
           <?=$i;?>
         </option>
         <? } ?>
       </select>
       </label></td>
       <td width="3%" class="tabla_paginador"><a href="javascript:paginacion_lista_histo(<?=$proxima;?>)"> <img src="../imagenes/botones/arrow-right-16.gif" alt="P&aacute;gina Siguiente" width="14" height="13"></a></td>
     </tr>
</table>   
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco_oferente">
     <tr>
       <td colspan="<?=$concatena_titulo;?>"><div align="center" class="columna_titulo_resultados">LISTA DE BIENES O SERVICIOS SOLICITADOS</div></td>
     </tr>
     <tr>
       <td width="1%" class="titulo_tabla_azul_sin_bordes"><strong>Codigo</strong></td>
       <td width="43%" class="titulo_tabla_azul_sin_bordes"><strong>detalle</strong></td>
       <td width="1%" class="titulo_tabla_azul_sin_bordes"><strong>Medida</strong></td>
       <td width="1%" class="titulo_tabla_azul_sin_bordes"><strong>Cantidad</strong></td>
       <td width="1%" class="titulo_tabla_azul_sin_bordes"><strong>Moneda</strong></td>
	   <?=$titulo_campos;?>
     </tr>
     <?
  	$busca_campos = query_db("select * from $t95 where in_id = $id_invitacion and pro11_id = $id_lista  limit $paginador,$numero_pagi ");
	while($l_campo = traer_fila_row($busca_campos)){ 
	$campo_campos=""; 
	
	$campo_formateado=str_replace("id_articulo",$l_campo[0],$campo_campos);
	$valor_proveedor_buscado="";
	$busca_campos_1 = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista");
	while($l_campo_trae = traer_fila_row($busca_campos_1)){//busca_valor puestos por e proveedor
	$busca_valores_ing=traer_fila_row(query_db("select w_valor from $tabla_economica  where pv_id = $us_cliente and oferta = $oferta and evaluador5_id  = $l_campo[0] and evaluador4_id = $l_campo_trae[0]"));
		$campo_campos.="<td class='divicion_tablas_oferntes'>$busca_valores_ing[0]</td>";
	} //busca_valor puestos por e proveedor


		
	?>
     <tr onMouseOver=this.className="tabla_menu_relover"; onMouseOut=this.className="";>
       <td class="divicion_tablas_oferntes"><div align="left">
         <?=$l_campo[2];?>
       </div>       </td>
       <td class="divicion_tablas_oferntes"><div align="left"><?=$l_campo[3];?>
       </div>       </td>
       <td class="divicion_tablas_oferntes" align="center"><div align="left">
         <?=$l_campo[4];?>
       </div></td>
       <td  class="divicion_tablas_oferntes" align="center"><div align="left">
         <?=$l_campo[5];?>
       </div></td>
       <td  class="divicion_tablas_oferntes" align="center"><div align="left">
         <?=$l_campo[6];?>
       </div></td>
		<?=$campo_campos;?>
     </tr><? } ?>
     <tr >
       <td >&nbsp;</td>
       <td >&nbsp;</td>
       <td  align="center">&nbsp;</td>
       <td align="center">&nbsp;</td>
       <td align="center">&nbsp;</td>
     </tr>
     
     <?
	 $campo_campos="";
	 $busca_campos_1 = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista");
	while($l_campo_trae = traer_fila_row($busca_campos_1)){//busca_valor puestos por e proveedor
	if($l_campo_trae[3]=="Numerico")
		$campo_campos.="<td >&nbsp;</td>";
	if($l_campo_trae[3]=="Valor"){
//		echo "select * from v_relacion_lista_ofertas  where pro11_id = $id_lista and pv_id = $us_cliente and oferta = $oferta  and evaluador4_id = $l_campo_trae[0]";
		$busca_valores_ing=traer_fila_row(query_db("select sum(w_valor) from v_relacion_lista_ofertas  where pro11_id = $id_lista and pv_id = $us_cliente and oferta = $oferta  and evaluador4_id = $l_campo_trae[0]"));

		$campo_campos.="<td ><div  class='titulos_evaluacion'>$ ".number_format($busca_valores_ing[0],2)."</td>";
		
		}

	if($l_campo_trae[3]=="Texto Corto")
		$campo_campos.="<td>&nbsp;</td>";
	if($l_campo_trae[3]=="Texto Largo")
		$campo_campos.="<td>&nbsp;</td>";
	if($l_campo_trae[3]=="Moneda"){
		$campo_campos.="<td>&nbsp;</td>";
		}
		
		}//while
		?>
     
     <tr onMouseOver=this.className="tabla_menu_relover"; onMouseOut=this.className="";>
       <td colspan="5" ><div align="right" class="titulos_evaluacion">Valor total de la oferta (Solo de esta lista y de todas las p&aacute;ginas):</div></td>
       <?=$campo_campos;?>
     </tr>
</table>
<table width="98%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
     <tr>
       <td width="85%"><div align="right"><span class="texto_paginador_proveedor"><strong>Numero de p&aacute;ginas en esta lista:
               <?=$pagina;?>
       </strong></span></div></td>
       <td width="3%"><div align="center"><a href="javascript:paginacion_lista_histo(<?=$anterior;?>)"> <img src="../imagenes/botones/arrow-left-16.gif" alt="P&aacute;gina anterior" width="14" height="13"></a></div></td>
       <td width="9%"><label>
         <select name="select2" onChange="javascript:paginacion_lista_histo(this.value)">
           <? 
		  for($i=1;$i<=$pagina;$i++){
		   ?>
           <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>P&aacute;gina
             <?=$i;?>
           </option>
           <? } ?>
         </select>
       </label></td>
       <td width="3%"><a href="javascript:paginacion_lista_histo(<?=$proxima;?>)"> <img src="../imagenes/botones/arrow-right-16.gif" alt="P&aacute;gina Siguiente" width="14" height="13"></a></td>
     </tr>
</table>
   <br>
   
   <?
   
   if($requiere_aui==1){
 $busca_aiu="select * from $t24 where pro1_id = $id_invitacion and pv_id = $us_cliente and pro11_id = $id_lista ";
   $sql_aui=traer_fila_row(query_db($busca_aiu));
   ?>
   <table width="98%" border="0" cellspacing="2" cellpadding="2">
     <tr>
       <td colspan="3" class="titulos_procesos">Valores para el calculo del AIU</td>
     </tr>
     <tr>
       <td width="17%"><div align="right">% Administraci&oacute;n:</div></td>
       <td width="19%"><label>
         <input type="text" name="administracion" id="textfield" value="<?=$sql_aui[4];?>">
       </label></td>
       <td width="64%">&nbsp;</td>
     </tr>
     <tr>
       <td><div align="right">% Imprevistos:</div></td>
       <td><input type="text" name="imprevisto" id="textfield2" value="<?=$sql_aui[5];?>"></td>
       <td>&nbsp;</td>
     </tr>
     <tr>
       <td><div align="right">% Utilidad:</div></td>
       <td><input type="text" name="utilidad" id="textfield3" value="<?=$sql_aui[6];?>"></td>
       <td>&nbsp;</td>
     </tr>
   </table>
   <? } ?>
<br>
<br>
<input type="hidden" name="oferta" value="<?=$oferta;?>">
   <input type="hidden" name="pag" value="<?=$pag;?>">

   
<input type="hidden" name="id_invitacion_pasa" value="<?=$id_invitacion_pasa;?>">
<table width="98%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td>&nbsp;</td>
  </tr>
</table>
<table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco_oferente">
  <tr>
    <td width="71%" align="center">
      <input name="button4" type="button" class="calcular" id="button4" value="           Exportar reporte a excel" onClick="window.parent.location.href='exportaexcel_<?=$id_invitacion_pasa;?>_<?=$id_lista;?>.php'">
      
    </td>
  </tr>
  <?

  	$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista");
	while($l_campo = traer_fila_row($busca_campos)){  
  	$titulo_campos.="<td align='center' class='titulo_tabla_azul_sin_bordes'>".$l_campo[2]."</td>";
	$numero++;
  													} 
	$titulo_campos.="<td width='15%' align='center' class='titulo_tabla_azul_sin_bordes'>Estado de su Oferta</td>";	$numero+=1;											
	
	$concatena_titulo = ($numero+5);												
													?>
</table>
<br>
<? }// si selecciona lista ?>
<input type="hidden" name="id_lista" value="<?=$id_lista;?>">
   <input type="hidden" name="pa_requiere_aui" value="<?=$requiere_aui;?>">
   

</body>
</html>
