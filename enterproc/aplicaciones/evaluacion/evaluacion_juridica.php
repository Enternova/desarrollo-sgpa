<? include("../../librerias/lib/@session.php");
include("../../librerias/lib/leng_esp.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	//verifica_menu("procesos.html");

	$id_invitacion = elimina_comillas($id_invitacion);
	$termino = elimina_comillas($termino);

	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));
//echo $termino_eva;
	 if($termino_eva==1){
	 $campo_evaua1=3;
	 $campo_evaua2=4;
	 }
	 elseif($termino_eva==3){
	 $campo_evaua1=13;
	 $campo_evaua2=14;
	 }
	 elseif($termino_eva==4){
	 $campo_evaua1=11;
	 $campo_evaua2=12;
	 }
	 
	 	 elseif($termino_eva==6){
	 $campo_evaua1=15;
	 $campo_evaua2=16;
	 }
	 
	 
	 	 elseif($termino_eva==7){
	 $campo_evaua1=17;
	 $campo_evaua2=18;
	 }	  	


?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >

<p>&nbsp;</p>
<table width="95%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="8%" class="titulos_evaluacion"><strong><?=LENG_312;?>:</strong></td>
    <td width="79%" class="titulos_evaluacion"><div align="left"><?=listas_sin_select($t8, $pv_id, 3);?></div></td>
    <td width="13%" class="titulos_evaluacion"><input name="Submit3" type="button" class="cancelar" value="Volver a la lista de proveedores" onClick="ajax_carga('../aplicaciones/evaluacion/apertura_evaluacion_juridica.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>&termino_eva=<?=$termino_eva;?>','carga_resultados_principales')"></td>
  </tr>
</table>  
  

<?
  
  if($termino==2)
  	$complemento.= " and tp6_id = $busca_fechas[8]";
	
	$grupo_terminos = "select distinct $t89.rel9_id ,$t89.rel9_detalle  from $t89, $t90, $t91  where
	$t91.in_id = $id_invitacion and 
	$t91.termino = $termino_eva and 
	$t90.rel10_id = $t91.rel10_id and 
	$t89.rel9_id  = $t90.rel9_id";

	$terminos=query_db($grupo_terminos);
	while($li=traer_fila_row($terminos)){

?>

 
      <table width="95%" border="0"  cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
<tr>
            <td colspan="3" class="columna_titulo_resultados">
              <table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td width="20%"><div align="left"><strong><?=LENG_64;?>:
                      <?=$li[1];?>
                    </strong></div></td>
                </tr>
              </table>           </td>
        </tr>
          <tr > 
            <td width="23%"  class="columna_subtitulo_resultados"><div align="center"><?=LENG_108;?></div></td>
            <td width="69%"  class="columna_subtitulo_resultados"><?=LENG_133;?></td>
            <td width="8%"  class="columna_subtitulo_resultados"><?=LENG_159;?></td>
        </tr>
          <?
  	$suma_apa=0;
	$lista_criterios = "select * from $t90, $t91 where $t91.in_id = $id_invitacion and  $t90.rel10_id  = $t91.rel10_id  and  $t90.rel9_id = $li[0] and $t90.rel10_estado=1";
	$linvi_cri=query_db($lista_criterios);
	$num_fila=0;
	while($lcri=traer_fila_row($linvi_cri)){

  	$bus_his = traer_fila_row(query_db("select *  from $t91 where in_id = $id_invitacion and  rel10_id =$lcri[0]"));
	
		
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
?>
          <tr class="<?=$class;?>"> 
            <td> <div align="right"><strong>
              <?=$lcri[2];?>
            </strong>:</div></td>
            <td><div align="left">
            

<table width="95%" border="0" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
  <tr>
    <td width="32" class="columna_titulo_resultados"><div align="center"><strong><?=LENG_37;?></strong></div></td>
    <td width="143" class="columna_titulo_resultados"><div align="left"><strong><?=LENG_121;?></strong></div></td>
    <td width="98" class="columna_titulo_resultados"><div align="left"><strong>

      <?=LENG_172;?>
    </strong></div></td>
    <td width="349" class="columna_titulo_resultados"><div align="left"><strong><?=LENG_271;?></strong></div></td>
    </tr>
  <?

			$resultado_evaluacion=0;
			
			$busca_respo = query_db("select * from ".$t96." where pv_id = ".$pv_id." and evaluador1_id = $bus_his[0]");
			while($lc=traer_fila_row($busca_respo)){
			$ext=extencion_archivos($lc[3]);
			$nombre_adjunto = nombre_archivo_adjunto($lc[3]).".".$ext;//esta fila se reemplaza por el $lc[3] que esta en el link de descarga
			
			  $busca_ob_evalu = traer_fila_row(query_db("select * from $t32 where evaluador1_id=$bus_his[0] and pv_id=$pv_id"));	

			
		?>
  <tr class="administrador_tabla_generales">
    <td><? if ($ext!=""){ ?><a href='../librerias/php/descarga_documentos_juridicos_tecnicos.php?n1=<?=$lc[0];?>&n2=<?=$nombre_adjunto;?>&us_cliente_pasa=<?=$us_cliente_pasa;?>'><img src="../imagenes/mime/<?=$ext;?>.gif" alt="Tipo Documento"></a><? } ?> </td>
    <td><?=$lc[3];?></td>
    <td><?=fecha_for_hora($lc[7]);?></td>
    <td><?=$lc[6];?></td>
    </tr>
  <? $resultado_evaluacion = $lc[8]; } ?>
</table>            
            
            
            </div></td>
            <td><label>
              <select name="evaluacion_juridica[<?=$bus_his[0];?>]" >
                <option value="Sin">Sin evaluaci&oacute;n</option>
                <option value="1" <? if ($resultado_evaluacion==1) echo "selected"; ?> >Cumple</option>
                <option value="2"  <? if ($resultado_evaluacion==2) echo "selected"; ?> >No cumple</option>
              </select>
            </label></td>
          </tr>
          <tr class="<?=$class;?>">
            <td>&nbsp;</td>
            <td colspan="2"><strong><?=LENG_272;?>: </strong>
              <textarea name="observa_<?=$bus_his[0]?>" id="observa_<?=$bus_his[0]?>" cols="45" rows="2"><?=$busca_ob_evalu[3]?></textarea></td>
          </tr>
          <? $num_fila++;
		 
		  }// while ?>
      </table>
  
<? } ?>
<br>

<?
	$busca_evaluacion_final = "select * from $t13 where proc1_id = $id_invitacion and pv_id = $pv_id";
	$busca_hist_evaluacion = traer_fila_row(query_db($busca_evaluacion_final));
	

?>

    <table width="95%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td><div align="center"><a href='../aplicaciones/evaluacion/descargas_uno/descarga_documentos_economicos_indivudales.php?evaluador1_id=<?=$id_invitacion;?>&pv_id=<?=$pv_id;?>&termino=<?=$termino_eva;?>'><?=LENG_116;?></a></div></td>
      </tr>
    </table>
  <br>

<table width="95%" border="0" cellpadding="1" cellspacing="1" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td width="28%" height="25"><div align="right"><strong><?=LENG_273;?>:</strong></div></td>
    <td width="48%"><label>
      <div align="left">
        <textarea name="obse_juridico" id="obse_juridico" cols="80" rows="3"><?=$busca_hist_evaluacion[$campo_evaua2];?></textarea>
        </div>
    </label></td>
  </tr>
</table>
<br>
<table width="95%" border="0" cellpadding="1" cellspacing="1" class="tabla_lista_resultados">
  <tr>
    <td height="25" colspan="2" class="columna_titulo_resultados"><div align="center"><?=LENG_332;?></div></td>
  </tr>
  <tr>
    <td width="28%" height="25"><div align="right"><strong><?=LENG_318;?>:</strong></div></td>
    <td width="48%"><div align="left"><?=$busca_hist_evaluacion[$campo_evaua1];?>
      <? if($busca_hist_evaluacion[$campo_evaua1]=="No Cumple") echo '<img src="../imagenes/botones/SemaforoRojo.gif" width="44" height="19">';
		elseif($busca_hist_evaluacion[$campo_evaua1]=="Cumple")  echo '<img src="../imagenes/botones/SemaforoVerde.gif" width="44" height="19">';
			else echo '<img src="../imagenes/botones/SemaforoAmarilloAnimado.gif" width="44" height="19">';
		?>
    </div></td>
  </tr>
  <tr>
    <td height="25" colspan="2"><div align="center"></div></td>
  </tr>
</table>
<br>

<?	if($sql_e[1]<=4){//si ya esta adjudicado	?>
<table width="95%" border="0" cellpadding="1" cellspacing="1" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td width="28%" height="25"><div align="right"></div></td>
    <td width="48%"><label></label></td>
    <td width="15%"><input name="Submit" type="button" class="guardar" value="<?=LENG_193;?>.." onClick="c_evaluacion_juridica()"></td>
    <td width="9%"><input name="Submit2" type="button" class="cancelar" value="<?=LENG_66;?>" onClick="ajax_carga('../aplicaciones/evaluacion/apertura_evaluacion_juridica.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>&termino_eva=<?=$termino_eva;?>','carga_resultados_principales')"></td>
  </tr>
</table>
<? } ?>
<input type="hidden" name="termino" value="<?=$termino;?>">
<input type="hidden" name="id_invitacion_juri" value="<?=$id_invitacion;?>">
<input type="hidden" name="pv_id" value="<?=$pv_id;?>">
<input type="hidden" name="termino_eva" value="<?=$termino_eva;?>">




</body>
</html>