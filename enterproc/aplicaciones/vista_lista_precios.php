<? include("../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	

	$id_vari=$id_invitacion;
	$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));
	$termino = elimina_comillas($termino);
	

		$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));


?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2">
  <tr>
       <td width="88%" class="titulos_procesos">LISTAS DE PRECIOS<br>
           <strong>Consecutivo del proceso:
             <?=$sql_e[22];?>
         </strong></td>
       <td width="12%"><input name="button6" type="button" class="cancelar" id="button6" value="Volver al proceso" onClick="ajax_carga('../aplicaciones/visualiza_proceso.php?id_p=<?=$id_invitacion;?>&ruta_ev=<?=$ruta_ev;?>','contenidos')"></td>
     </tr>
   </table>
<br>
   <table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
     <tr>
       <td width="42%" class="titulo_tabla_azul_sin_bordes">Listas creadas</td>
     </tr>
     <tr>
       <td>  <table width="95%" border="0" cellspacing="2" cellpadding="2">
     <tr>
       <td width="87%">
	   <select name="listas" onChange="ajax_carga(this.value,'carga_evaluacion')">
       <option value="configuracion_criteriosec_<?=$id_vari;?>_0.html">Seleccione una lista</option>
	   <?
		$busca_listas_creadas = "select * from $t19 where pro1_id = $id_invitacion";
		$sql_listas = query_db($busca_listas_creadas);
		while($ex_listas = traer_fila_row($sql_listas)){ ?>
         <option value="../aplicaciones/vista_lista_precios.php?id_invitacion=<?=$id_vari;?>&id_lista=<?=$ex_listas[0];?>"><?=$ex_listas[2];?></option>
		 <? } ?>
            </select>         </td>
     </tr>
   </table></td>
     </tr>
   </table>

   
 
   
<? if($id_lista!=0){ //si tiene listas creadas

	$busca_listas_creadas_1 = traer_fila_row(query_db("select * from $t19 where pro11_id = $id_lista"));

?>
   <br>
   <br>
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="left" class="oferta_perdedora"><strong><img src="../imagenes/botones/aviso_observaciones.png" width="16" height="16">
      USTED ESTA EN LA LISTA DE: </strong>
      <?=$busca_listas_creadas_1[2];?>
    </div>    </td>
  </tr>
</table>

   
<?

  	$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista");
	while($l_campo = traer_fila_row($busca_campos)){  
  	$titulo_campos.="<td align='center' width='100px'><div align='center'>".$l_campo[2]."	";
		   

		$titulo_campos.="</div></td>";
		   
	$titulo_campos_final.="<td width='100px'><div align='center'><input name='ooo' type='text' class='re_eco' readonly  ></div></td>";
	$numero++;
  													} 
	
	$concatena_titulo = ($numero);												
													?>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" style="overflow:scroll; overflow-y:hidden">
     <tr>
       <td colspan="5" class="columna_titulo_resultados"><div align="center">Lista de items para cotizar</div></td>
       <td width="11%"  class="columna_titulo_resultados"  ><div align="center">Requerimiento</div></td>
     </tr>
     <tr class="columna_subtitulo_resultados">
       <td width="14%"><div align="center"> C&oacute;digo</div></td>
       <td width="18%"><div align="center">Detalle</div></td>
       <td width="6%"><div align="center">Medida</div></td>
       <td width="7%"><div align="center">Cantidad</div></td>
       <td width="25%"><div align="center">Moneda</div></td>
       <?=$titulo_campos;?>  
     </tr>

 <tr class="<?=$class;?>">
    <td align="left">&nbsp;</td>
       <td align="left">&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
    </tr>     
     <?

$numero_pagi = 50;
if ($pag=="")
	$pag = 1;
else
	$pag = $pag;

$paginador = (($pag-1)*$numero_pagi);


	  $li_n_c=traer_fila_row(query_db("select count(*) from $t95 where in_id = $id_invitacion and pro11_id = $id_lista"));
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
	 
	 $TOTA = 0;
  	$busca_campos = query_db("select * from $t95 where in_id = $id_invitacion and pro11_id = $id_lista ");
	while($l_campo = traer_fila_row($busca_campos)){ 
	
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
  ?>
    
     <tr >
       <td><div align="center"><?=$l_campo[2];?></div></td>
       <td align="left"><div align="center"><?=$l_campo[3];?></div></td>
       <td><div align="center"><?=$l_campo[4];?></div></td>
       <td><div align="center"><?=$l_campo[5];?></div></td>
       <td><div align="center"><?=$l_campo[6];?></div></td>
       <?=$titulo_campos_final;?>
     </tr>
     <? $TOTA++; $num_fila++;} ?>
   </table>
   

<br>
<br>
<br>
<? } ?>
<br>
   <input type="hidden" name="id_lista" value="<?=$id_lista;?>">
   <input type="hidden" name="valor_campo">
   <input type="hidden" name="campo_id">
	<input type="hidden" name="id_invitacion" value="<?=$id_vari;?>">
    	<input type="hidden" name="tipo_formula" >
    


</body>
</html>
