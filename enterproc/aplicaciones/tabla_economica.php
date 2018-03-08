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
       <td  class="titulos_procesos">TABLA DE TERMINOS Y CONDICIONES
         <?=$titulo_evaluacion;?></td>
     </tr>
     <tr>
       <td><fieldset style="width:99%">
         <legend>Informaci&oacute;n General del Proceso</legend>
         <table width="98%" border="0" cellspacing="4" cellpadding="4">
           <tr>
             <td colspan="4"></td>
           </tr>
           <tr>
             <td width="30%" height="26"><strong>Consecutivo del proceso:</strong></td>
             <td width="26%"><div align="left">
               <?=$sql_e[22];?>
             </div></td>
             <td width="22%"><strong>Tipo de proceso:</strong></td>
             <td width="22%"><div align="left">
               <?=listas_sin_select($tp2,$sql_e[2],1);?>
             </div></td>
           </tr>
           <tr>
             <td height="26"><strong>Detalle y cantidad del objeto a contratar:</strong></td>
             <td colspan="3"><div align="left">
                 <?=$sql_e[12];?>
                 </textarea>
             </div></td>
           </tr>
           <tr>
             <td height="26" colspan="4"><div align="center">
               <input name="Submit2" type="button" class="cancelar" value="Volver al proceso" onClick="javascript:ajax_carga('../aplicaciones/crea_proceso.php?id_p=<?=$id_invitacion;?>','contenidos')">
             </div></td>
           </tr>
         </table>
       <br>
       </fieldset></td>
     </tr>
   </table>
   <br>
   <table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
     <tr>
       <td width="58%" valign="top" class="titulo_tabla_azul_sin_bordes">Crear nueva lista</td>
       <td width="42%" class="titulo_tabla_azul_sin_bordes">Listas creadas</td>
     </tr>
     <tr>
       <td valign="top"><table width="95%" border="0" cellpadding="2" cellspacing="2">
         <tr>
           <td width="27%">Crear nueva lista:</td>
           <td width="47%">             <div align="left">
                 <input type="text" name="nombre_lista" id="nombre_lista">
               </div>           </td>
           <td width="26%">
               <div align="left">
                 <input name="button" type="button" class="guardar" id="button" value="Crear lista" onClick="crear_nueva_lista()">
               </div></td>
         </tr>
       </table></td>
       <td>  <table width="95%" border="0" cellspacing="2" cellpadding="2">
     <tr>
       <td width="87%">
	   <select name="listas" onChange="ajax_carga(this.value,'contenidos')">
       <option value="configuracion_criteriosec_<?=$id_vari;?>_0.html">Seleccione una lista</option>
	   <?
		$busca_listas_creadas = "select * from $t19 where pro1_id = $id_invitacion";
		$sql_listas = query_db($busca_listas_creadas);
		while($ex_listas = traer_fila_row($sql_listas)){ ?>
         <option value="configuracion_criteriosec_<?=$id_vari;?>_<?=$ex_listas[0];?>.html"><?=$ex_listas[2];?></option>
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
  	$titulo_campos.="<td align='center' width='100px'><div align='center'><input name='n_e_campo_".$l_campo[0]."' class='re_eco4' type='text' value='".$l_campo[2]."' size='10'></br>
	 <select name='t_e_campo_".$l_campo[0]."' class='re_eco4'  >
          <option value='0'>Tipo</option>
          <option value='Numerico'";
		  if($l_campo[3]=="Numerico") $titulo_campos.="selected";
		   $titulo_campos.=">Numerico</option>
		   <option value='Moneda'";
		  if($l_campo[3]=="Moneda") $titulo_campos.="selected";
		   $titulo_campos.=">Moneda</option>
          <option value='Texto Corto'";
		  if($l_campo[3]=="Texto Corto") $titulo_campos.="selected";
		   $titulo_campos.=">Texto Corto</option>
          <option value='Texto Largo'";
		  if($l_campo[3]=="Texto Largo") $titulo_campos.="selected";
		   $titulo_campos.=">Texto Largo</option>
		   <option value='Valor'";
		  if($l_campo[3]=="Valor") $titulo_campos.="selected";
		   $titulo_campos.=">Valor</option>
		    </select></br>";
		   
     		$titulo_campos.="<img src='../imagenes/botones/editar_c.png' alt='Modificar Campo' onClick='edita_requerimiento(".$l_campo[0].",document.principal.n_e_campo_".$l_campo[0].",document.principal.t_e_campo_".$l_campo[0].")'>  &nbsp;
					         <img src='../imagenes/botones/eliminar_c.png' alt='Eliminar Campo' onClick='elimina_requerimiento(".$l_campo[0].")'> &nbsp;";
      if( ($l_campo[3]=="Numerico") || ($l_campo[3]=="Valor") ) 
      $titulo_campos.="<img src='../imagenes/botones/2.gif' alt='Este comando activara el campo sobre el cual se regir&aacute; la subasta' onClick='activar_subasta(".$l_campo[0].")'>";

		$titulo_campos.="</div></td>";
		   
	$titulo_campos_final.="<td width='100px'><div align='center'><input name='ooo' type='text' class='re_eco' readonly  ></div></td>";
	$numero++;
  													} 
	
	$concatena_titulo = ($numero);												
													?>   
   
   
   <table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
     <tr>
       <td><div align="left"><img src="../imagenes/botones/pregunta_f.png" alt="Eliminar lista completa" width="22" height="23"><a href="javascript:void(0)" onClick="elimina_toda_lista()"> Eliminar toda la lista</a></div></td>
     </tr>
   </table>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" style="overflow:scroll; overflow-y:hidden">
     <tr>
       <td colspan="6" class="columna_titulo_resultados"><div align="center">Lista de items para cotizar</div></td>
       <td  width="12%"  class="columna_titulo_resultados" colspan="<?=$concatena_titulo;?>" ><div align="center">Requerimientos</div></td>
       <td width="11%"  class="columna_titulo_resultados"  ><div align="center">Nuevo Requerimiento</div></td>
     </tr>
     <tr class="columna_subtitulo_resultados">
       <td width="14%"><div align="center"> C&oacute;digo</div></td>
       <td width="18%"><div align="center">Detalle</div></td>
       <td width="6%"><div align="center">Medida</div></td>
       <td width="7%"><div align="center">Cantidad</div></td>
       <td width="25%"><div align="center">Moneda</div></td>
       <td width="13%"><div align="center">Acciones</div></td>
	   <?=$titulo_campos;?>  
       <td width="12%"><div align="center"><input name="n_campo" type="text" id="n_campo" size="10"><select name="tipo_campo" id="tipo_campo">
                 <option value="0">Tipo</option>
                 <option value="Valor">Valor</option>
                 <option value="Numerico">Numerico</option>
				 <option value="Moneda">Moneda</option>
                 <option value="Texto Corto">Texto Corto</option>
                 <option value="Texto Largo">Texto Largo</option>
         </select>
        <input name="button4" type="button" class="guardar" id="button4" value="Grabar" onClick="crea_campo()">
       </div></td>
     </tr>

 <tr class="<?=$class;?>">
    <td align="left">
      <div align="center">
        <input name="a_economica" type="text" class="re_eco2" id="a_economica" size="1" maxlength="1">
        </div></td>
       <td align="left"><div align="center">
         <textarea name="b_economica" cols="20" rows="2" class="re_ecoseletet" id="b_economica"></textarea>
       </div></td>
       <td><div align="center">
         <input name="c_economica" type="text" class="re_eco2" id="c_economica" size="1">
       </div></td>
       <td><div align="center">
         <input name="d_economica" type="text" class="re_eco2" id="d_economica" size="1">
       </div></td>
       <td><div align="center">
         <select name="e_economica" class="re_ecosele2" id="e_economica">
           <?=listas_afuera($tp7, 1,$sql_e[13],'nombre', 1);?>
         </select>
    </div></td>
       <td><input name="button3" type="button" class="guardar" id="button3" onClick="crea_articulo()" value="Agregar"></td>
    <td>&nbsp; <input type="hidden" name="f" id="f" value="0">
    <input type="hidden" name="presupuesto" id="presupuesto"  value="0"></td>
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
       <td><div align="center">
         <input name="a2_<?=$l_campo[0];?>" type="text" class="re_eco2" id="a2"  value="<?=$l_campo[2];?>">
       </div></td>
       <td align="left"><div align="center">
         <textarea name="b2_<?=$l_campo[0];?>" cols="20" rows="2" class="re_ecoseletet" id="b2"><?=$l_campo[3];?></textarea>
       </div></td>
       <td><div align="center">
         <input name="c2_<?=$l_campo[0];?>" type="text" class="re_eco2" id="c2" value="<?=$l_campo[4];?>" size="1">
       </div></td>
       <td><div align="center">
         <input name="d2_<?=$l_campo[0];?>" type="text" class="re_eco2" id="d2" value="<?=$l_campo[5];?>" size="1">
       </div></td>
       <td><div align="center">
         <select name="e2_<?=$l_campo[0];?>" class="re_ecosele2" id="e2">
           <?=listas_selecc_diferente_id($tp7, 1,$l_campo[6],'nombre', 1);?>
         </select>
       </div></td>
       <td><div align="center">
       <img src="../imagenes/botones/editar_c.png" title="Modificar Campo" onClick="edita_articulos(<?=$l_campo[0];?>,document.principal.a2_<?=$l_campo[0];?>,document.principal.b2_<?=$l_campo[0];?>,document.principal.c2_<?=$l_campo[0];?>,document.principal.d2_<?=$l_campo[0];?>,document.principal.e2_<?=$l_campo[0];?> )">
        &nbsp; <img src="../imagenes/botones/eliminar_c.png" alt="Eliminar Campo" onClick="elimina_articulo(<?=$l_campo[0];?>)" ></div></td>
     <?=$titulo_campos_final;?>
     <td>&nbsp;</td>
     </tr>
     <? $TOTA++; $num_fila++;} ?>
   </table>
   

<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
     <tr>
       <td colspan="3"><p align="left"><strong><img src="../imagenes/botones/Advertencia.gif" alt="Control" width="10" height="10"> CONTROL: </strong>Si desea subir los articulos masivamente descargue la <a href="../attfiles/plantilla/plantilla_cargue.xls">plantilla aqu&iacute;</a>, recuerde:</p>
       </td>
     </tr>
     <tr>
       <td><div align="right"><strong>Busque el documento que anexara:</strong></div></td>
       <td>
         <div align="center">
           <input type="file" name="archivo_lista" id="archivo_lista">
         </div>       </td>
       <td><div align="center">
         <input name="button2" type="button" class="guardar" id="button2" value="Subir Archivo Excel" onClick="sube_archivo()">
       </div></td>
     </tr>
     <tr>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
   </table>
   
   <br>
   <table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">

     <tr>
       <td width="24%"><div align="right">Nombre de la lista actual:</div></td>
       <td width="18%"><div align="left">
           <input type="text" name="edita_lista" id="textfield4" value="<?=$busca_listas_creadas_1[2];?>">
       </div></td>
       <td width="15%"><div align="left">
           <input name="button7" type="button" class="guardar" id="button8" value="Editar lista" onClick="editar_nueva_lista()">
       </div></td>
       <td width="43%"><div align="left">
           <input name="button7" type="button" class="cancelar" id="button9" value="Eliminar lista" onClick="elimina_nueva_lista()">
       </div></td>
     </tr>
     <tr>
       <td><div align="right">La lista requiere AIU:</div></td>
       <td><label>
         <select name="requiere_aui" id="requiere_aui">
           <option value="1" <? if($busca_listas_creadas_1[3]==1) echo "selected"; ?> >Si</option>
           <option value="0" <? if($busca_listas_creadas_1[3]==0) echo "selected"; ?>>No</option>
                           </select>
       </label></td>
       <td>&nbsp;</td>
       <td>&nbsp;</td>
     </tr>
   </table>
<br>
   <table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
     <tr>
       <td width="62%" class="titulo_tabla_azul_sin_bordes"><div align="center">Requerimientos</div></td>
       <td width="38%" class="titulo_tabla_azul_sin_bordes"><div align="center">Formula</div></td>
     </tr>
     <tr>
       <td><table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados" >
           <?

  	$busca_campos = query_db("select * from $t94 where in_id = $id_invitacion and pro11_id = $id_lista");
	while($l_campo = traer_fila_row($busca_campos)){ 
		if( ($l_campo[3]=="Numerico") || ($l_campo[3]=="Valor") ){
	 ?>
           <tr>
             <td width="47%"><?=$l_campo[2];?>
             </td>
             <td width="29%"><label>
                 <div align="left">
                   <select name="envia_campo_formula_<?=$l_campo[0];?>" id="envia_campo_formula_<?=$l_campo[0];?>">
                     <option value="0">Seleccione el parametro</option>
                     <option value="1">Aplicar solo valor</option>
                     <option value="2">Aplicar minimo valor</option>
                     <option value="3">Aplicar maximo valor</option>
                   </select>
                 </div>
               </label></td>
             <td width="24%"><div align="left">
                 <input type='button' class="calcular" value='     Aplicar a la formula' onClick="envia_armar_formula(<?=$l_campo[0];?>, document.principal.envia_campo_formula_<?=$l_campo[0];?>.value,'<?=$l_campo[2];?>' )">
             </div></td>
           </tr>
           <? } ?>
           <? 
	$numero++;
	
	}
	
	$select_formula = traer_fila_row(query_db("select * from $t18 where pro1_id = $id_invitacion and pro11_id = $id_lista and tipo_formula=1"));
	$select_formula_con = traer_fila_row(query_db("select * from $t18 where pro1_id = $id_invitacion and pro11_id = $id_lista and tipo_formula=2"));

	
	?>
       </table></td>
       <td><div align="center">
            Nombre de la formula:
             <input name="nombre_formula" type="text" id="nombre_formula" size="50" value="<?=$select_formula[3];?>">
           <br>
             Formula:<br>
             <input name="formula_1" type="text" id="formula_1" size="50" value="<?=$select_formula[2];?>">
             <input name="formula_2" type="hidden" id="formula_2"  size="50"  value="<?=number_format($select_formula[4],0);?>">
             <input name="formula_3" type="hidden" id="formula_3"  size="50"  value="<?=number_format($select_formula[5],0);?>">
           
       </div></td>
     </tr>
     <tr>
       <td><label>
         <input name="button5" type="button" class="guardar" id="button5" value="Guardar formula" onClick="guardar_formula(1)">
       </label></td>
       <td><div align="left">
           <input name="button5" type="button" class="cancelar" id="button6" value="Eliminar Formula" onClick="elimina_guardar_formula(1)">
       </div></td>
     </tr>
   </table>
   <br>
   <table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
     <tr>
       <td width="38%" class="titulo_tabla_azul_sin_bordes"><div align="center">Formula consolidado</div></td>
     </tr>
     <tr>
       <td><div align="center">
           <label> Nombre de la formula:
             <input name="nombre_formula2" type="text" id="nombre_formula2" size="50" value="<?=$select_formula_con[3];?>">
           <br>
             Formula:<br>
             <input name="formula_4" type="text" id="formula_4" size="50" value="<?=$select_formula_con[2];?>">
           </label>
       </div></td>
     </tr>
     <tr>
       <td>
           <div align="center">
             <input name="button8" type="button" class="guardar" id="button10" value="Guardar formula" onClick="guardar_formula(2)"> 
             <input name="button6" type="button" class="cancelar" id="button11" value="Eliminar Formula" onClick="elimina_guardar_formula(2)">
       </div></td>
     </tr>
   </table>
   <? } ?>
<br>
   <input type="hidden" name="id_lista" value="<?=$id_lista;?>">
   <input type="hidden" name="valor_campo">
   <input type="hidden" name="campo_id">
	<input type="hidden" name="id_invitacion" value="<?=$id_vari;?>">
    	<input type="hidden" name="tipo_formula" >
    


</body>
</html>
