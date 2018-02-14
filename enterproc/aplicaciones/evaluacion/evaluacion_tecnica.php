<? include("../../librerias/lib/@session.php");
include("../../librerias/lib/leng_esp.php");

header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';

//header('Content-Type: text/xml; charset=ISO-8859-1');

//echo $t32;

	//verifica_menu("procesos.html");
//echo $pv_id;
	$id_invitacion = elimina_comillas($id_invitacion);
	$termino = elimina_comillas($termino);
	
	$busca_procesos = "select peso_tecnico, minimo_tecnico_solicitado from $t5 where pro1_id = $id_invitacion";
	$sql_proceso=traer_fila_row(query_db($busca_procesos));
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));
	$tipo_cronograma=$sql_e_pro[44];
	
	$busca_tipo_evaluacion = "select tipo_evaluacion from pro34_relacion_tipo_evaluacion_tecnica where pro1_id = $id_invitacion";
	$sql_ex_tipo_evaluacion = traer_fila_row(query_db($busca_tipo_evaluacion));
	
	$porveedores_para_evaluar_tecnicamente = "select * from evaluador11_proveedores_con_oferta_tec where pro1_id = $id_invitacion";
	 $sql_cuenta_proveedores_tecnicos = traer_fila_row(query_db($porveedores_para_evaluar_tecnicamente));
	/** INICIO PARA EL INC025-18 DE REEMPLAZOS SE CAMBIA EL CONDICIONAL **/
	 $busca_encargado_tecnico = "select * from pro6_observadores_procesos where pro1_id = $id_invitacion and us_id in (".$_SESSION["id_us_session"].", ".a_quien_reemplaza($_SESSION["id_us_session"]).") and tipo = 2";
	/** FIN PARA EL INC025-18 DE REEMPLAZOS SE CAMBIA EL CONDICIONAL **/
	 $sql_busca_encargado_tecnico = traer_fila_row(query_db($busca_encargado_tecnico));
	 
?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
<table width="95%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="8%" class="titulos_evaluacion"><strong><?=LENG_312;?>:</strong></td>
    <td width="79%" class="titulos_evaluacion"><?=listas_sin_select($t8, $pv_id, 3);?></td>
    <td width="13%" class="titulos_evaluacion"><input name="button" type="button" class="cancelar" id="button" value="    Volver al lista" onClick="ajax_carga('../aplicaciones/evaluacion/apertura_evaluacion_tecnica.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','carga_resultados_principales')"></td>
  </tr>
</table>
<?
	$grupo_terminos = "select distinct $t89.rel9_id ,$t89.rel9_detalle  from $t89, $t90, $t91  where
	$t91.in_id = $id_invitacion and 
	$t91.termino = 2 and 
	$t90.rel10_id = $t91.rel10_id and 
	$t89.rel9_id  = $t90.rel9_id";
	
	$num_fila=0;
	$valor_categorias=0;

	$terminos=query_db($grupo_terminos);
	while($li=traer_fila_row($terminos)){
?>

    <?
	
  	$bus_his_categorias = traer_fila_row(query_db("select *  from $t12 where proc1_id = $id_invitacion and  rel9_id =$li[0]"));
	$valor_categorias = $bus_his_categorias[3];
	$suma_apa_categorias+=$valor_categorias;
?>
    <table width="95%" border="0" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
      <tr>
        <td colspan="4"></td>
      </tr>
      <tr>
        <td width="20%" ><div align="right"><strong>Consecutivo del proceso:</strong></div></td>
        <td width="29%"><?=$sql_e[22];?></td>
        <td width="17%"><div align="right"><strong>Tipo de soicitud:</strong></div></td>
        <td width="34%"><div align="left">
          <?=listas_sin_select($tp3,$sql_e[3],1);?>
        </div></td>
      </tr>
      <tr>
        <td valign="top" ><div align="right"><strong>
          <?=$lenguaje_0;?>
          :</strong></div></td>
        <td colspan="3"><div align="left">
          <?=$sql_e[12];?>
        </div></td>
      </tr>
    </table>
    

      <table width="95%" border="0" cellpadding="0" cellspacing="0" class="tabla_lista_resultados">
<tr >
            <td colspan="4" class="columna_titulo_resultados">
              <table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td width="41%"><div align="left"><strong><?=LENG_64;?> : <?=$li[1];?></strong></div></td>
                    <td width="56%" align="right"><? if($sql_ex_tipo_evaluacion[0]==27) echo LENG_303." : "; ?></td>
                    <td width="3%"><? if($sql_ex_tipo_evaluacion[0]==27) echo $valor_categorias; else "";?></td>
                </tr>
            </table>            </td>
        </tr>
          <tr > 
            <td   class="columna_subtitulo_resultados"><div align="left">&nbsp;
              <?=LENG_108;?>
            </div></td>
            <td   class="columna_subtitulo_resultados"><?=LENG_133;?></td>
            <td width="10"  class="columna_subtitulo_resultados"><?=LENG_156;?></td>
            <td width="10"  class="columna_subtitulo_resultados"><div align="center">
              <?=LENG_159;?>
            </div></td>
        </tr>
          <?
  	$suma_apa=0;
	$valor = 0;
	$lista_criterios = "select * from $t90, $t91 where $t91.in_id = $id_invitacion and  $t90.rel10_id  = $t91.rel10_id  and  $t90.rel9_id = $li[0] and $t90.rel10_estado=1";
	$linvi_cri=query_db($lista_criterios);
	$resulatdo_afectado=0;
$resulatdo_afectado_2=0;
$operacion_por_criterio=0;
	while($lcri=traer_fila_row($linvi_cri)){

  	$bus_his = traer_fila_row(query_db("select *  from $t91 where in_id = $id_invitacion and  rel10_id =$lcri[0]"));
	$valor = $bus_his[3];
	$suma_apa+=$valor;
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
?>
          <tr class="<?=$class;?>"> 
            <td> <div align="right"><strong>&nbsp;&nbsp;&nbsp;&nbsp;
              <?=$lcri[2];?>
            </strong>:</div></td>
            <td><table width="95%" border="0" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
              <tr>
                <td width="32" class="columna_titulo_resultados"><div align="center"><strong>
                  <?=LENG_37;?>
                </strong></div></td>
                <td width="143" class="columna_titulo_resultados"><div align="left"><strong>
                  <?=LENG_121;?>
                </strong></div></td>
                <td width="98" class="columna_titulo_resultados"><div align="left"><strong>
                  <?=LENG_172;?>
                </strong></div></td>
                <td width="349" class="columna_titulo_resultados"><div align="left"><strong>
                  <?=LENG_271;?>
                </strong></div></td>
              </tr>
              <?
			
			$resultado_evaluacion=0;

//echo "select * from ".$t96." where pv_id = ".$pv_id." and evaluador1_id = $bus_his[0]";
			$busca_respo = query_db("select * from ".$t96." where pv_id = ".$pv_id." and evaluador1_id = $bus_his[0]");
			$suma_archivo_ajuste_chimbo=0;
			$resulatdo_afectado_2=0;
			$resultado_afectado_2=0;
			while($lc=traer_fila_row($busca_respo)){
			$ext=extencion_archivos($lc[3]);
			
		?>
              <tr class="administrador_tabla_generales">
                <td><? if ($ext!=""){ ?><a href='../librerias/php/descarga_documentos_juridicos_tecnicos.php?n1=<?=$lc[0];?>&n2=<?=$lc[3];?>&us_cliente_pasa=<?=$us_cliente_pasa;?>'><img src="../imagenes/mime/<?=$ext;?>.gif" alt="Tipo Documento"></a><? } ?></td>
                <td><?=$lc[3];?></td>
                <td><?=fecha_for_hora($lc[7]).$suma_archivo_ajuste_chimbo;?></td>
                <td><?=$lc[6];?></td>
              </tr>
              <? 
			  $resultado_evaluacion = $lc[8]; 
			  //$resulatdo_afectado+= $lc[9];
			  $resultado_afectado_2+= $lc[9];
			  $suma_archivo_ajuste_chimbo++;
			   }
			  
			 // $resultado_evaluacion=($resultado_evaluacion/$suma_archivo_ajuste_chimbo);
			//echo $resulatdo_afectado." ".$suma_archivo_ajuste_chimbo."--".$resultado_afectado_2;
			 $operacion_por_criterio=($resultado_afectado_2/$suma_archivo_ajuste_chimbo);
//			  $resulatdo_afectado=($resulatdo_afectado/$suma_archivo_ajuste_chimbo);
			   $resulatdo_afectado+=$operacion_por_criterio;
			   
			  $busca_ob_evalu = traer_fila_row(query_db("select * from $t32 where evaluador1_id=$bus_his[0] and pv_id=$pv_id"));	
			   ?>
            </table></td>
            <td><div align="center"><?=$valor;?>
            </div></td>
 

            <td>
 <?
 	if($sql_ex_tipo_evaluacion[0]==25){ ?> <input type="hidden" name="evaluacion_juridica[<?=$bus_his[0];?>]"> <? } 
	
elseif($sql_ex_tipo_evaluacion[0]==26){ ?>
<select name="evaluacion_juridica[<?=$bus_his[0];?>]" >
                <option value="Sin">Sin evaluaci&oacute;n</option>
                <option value="1" <? if ($resultado_evaluacion==1) echo "selected"; ?> >Cumple</option>
                <option value="2"  <? if ($resultado_evaluacion==2) echo "selected"; ?> >No cumple</option>
              </select>
    <? } 	
	else { 
  if( ($sql_cuenta_proveedores_tecnicos[3]==1) && ($sql_busca_encargado_tecnico[0]>=1) ){

	
	?>
<select name="evaluacion_tecnica[<?=$bus_his[0]?>_<?=$valor_categorias;?>_<?=$valor;?>]">
           <option value="Sin"><?=LENG_352;?></option>
		   <?=listas_afuera_evaluacion($t14, ' estado = 1 ',$resultado_evaluacion,'valor desc', 2, 1);?>
         </select>    
    
    <? 


}//si no tiene evaluacion tecnica
	else echo listas_afuera_evaluacion_sin_select($t14, ' estado = 1 ',$resultado_evaluacion,'valor desc', 2, 1);
	} ?>                      
       </td>
          </tr>
          <tr class="<?=$class;?>">
            <td>&nbsp;</td>
            <td colspan="3"><div align="right"><strong>Observaciones de la evaluaci&oacute;n de este criterio:
              </strong>
              <?
			  	  if( ($sql_cuenta_proveedores_tecnicos[3]==1) && ($sql_busca_encargado_tecnico[0]>=1) ){//si no tiene evaluacion tecnica ?>
              <textarea name="observa_<?=$bus_his[0]?>" id="observa_<?=$bus_his[0]?>" cols="45" rows="2"><?=$busca_ob_evalu[3]?></textarea>
              <? } else echo "<br>".$busca_ob_evalu[3]; ?>
            </div></td>
          </tr>
          <? $num_fila++; 
		  
		  if($resultado_evaluacion=="Sin")  $estado_general++;
		  
		  
		  
		   }
		
		//echo $estado_general."----".$num_fila."aqui";
		
		if($estado_general==$num_fila)
			{
		  		$resultado_por_categoria_final = LENG_536;
				$resultado_criterios_por_categoria = LENG_536;
				$suma_porcentaje_afectado= LENG_536;

			
			}
		
		  elseif($resulatdo_afectado>=0){
		  		$resultado_por_categoria_final = ( ($valor_categorias * $resulatdo_afectado) /100 );
				$resultado_criterios_por_categoria = ( (100 * $resulatdo_afectado) /100 );
				$suma_porcentaje_afectado+= $resultado_por_categoria_final;
		  }
		  
		  
		  
		   ?>
         <? if($sql_ex_tipo_evaluacion[0]==27){ ?> 
        <tr >
            <td colspan="2" class="columna_titulo_resultados"><?=LENG_306;?>
            :</td>
            <td class="columna_titulo_resultados" ><div align="center"><?=$suma_apa;?>
            </div></td>
            <td class="columna_titulo_resultados" ><div align="center"><?=$resultado_criterios_por_categoria;?></div></td>
        </tr>
          <? } ?>
    </table>

<? } ?>
    <table width="95%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td><div align="center"><a href='../aplicaciones/evaluacion/descargas_uno/descarga_documentos_tecnicos_individual.php?evaluador1_id=<?=$id_invitacion;?>&pv_id=<?=$pv_id;?>&termino=2'><?=LENG_116;?></a></div></td>
      </tr>
    </table>
  <br>
<table width="95%" border="0" cellpadding="1" cellspacing="1" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td width="28%" height="25" valign="middle"><div align="right"><strong>
      <?=LENG_273;?>
    :</strong></div></td>
    <td width="48%" valign="top">
<?

	$busca_evaluacion_final = "select * from $t13 where proc1_id = $id_invitacion and pv_id = $pv_id";
	$busca_hist_evaluacion = traer_fila_row(query_db($busca_evaluacion_final));

if($calca==1){
$cambia_evaluacion = query_db("update $t13 set resultado_tecnico  = '$resultado_criterios_por_categoria' where evaluador10_id = $busca_hist_evaluacion[0]");
//echo "update $t13 set resultado_tecnico  = '$resultado_criterios_por_categoria' where evaluador10_id = $busca_hist_evaluacion[0]";
}
	
?>
      
        <div align="left">
          
             <?
			  	  if( ($sql_cuenta_proveedores_tecnicos[3]==1) && ($sql_busca_encargado_tecnico[0]>=1) ){//si no tiene evaluacion tecnica ?>
             <table border="0" width="100%">
        			
        			<td width="100%" align="left" style="font-weight: 900; font-size: 14px;">	
        				<i><img src="../../imagenes/botones/icono_ayuda.png" ></i><font face="roboto" color="#229BFF">&nbsp;Observaci&oacute;n y Soporte de la evaluaci&oacute;n para este proveedor
        			</td>
        		</table>
              <textarea name="obse_juridico" id="obse_juridico" cols="80" rows="3"><?=$busca_hist_evaluacion[6];?></textarea>
              <? } else echo "".$busca_hist_evaluacion[6]; ?>
        </div>
    </td>
  </tr>
  <?
	  if( ($sql_cuenta_proveedores_tecnicos[3]==1) && ($sql_busca_encargado_tecnico[0]>=1) ){//si no tiene evaluacion tecnica ?>
  <tr>
    <td height="25" align="right">Soporte:</td>
    <td><input type="file" name="soporte_avluacion" id="soporte_avluacion"></td>
  </tr>
    

 
  <?
	}
	
	?>
    <? if ($busca_hist_evaluacion[8]!=""){ ?>
     <tr>
    <td height="25" align="right"><a href='../librerias/php/descarga_documentos_evaluaciones.php?n1=<?=$busca_hist_evaluacion[0];?>_2&n2=<?=$busca_hist_evaluacion[8];?>'><img src="../imagenes/mime/<?=extencion_archivos($busca_hist_evaluacion[8]);?>.gif" alt="Tipo Documento"></a></td>
    <td><?=$busca_hist_evaluacion[8];?></td>
  </tr>
  <? } ?>
</table>
<?
			  	  if( ($sql_cuenta_proveedores_tecnicos[3]==1) && ($sql_busca_encargado_tecnico[0]>=1) ){//si no tiene evaluacion tecnica ?>
<table width="95%" border="0" cellpadding="1" cellspacing="1" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td width="36%" align="right">Seleccione la calificaci&oacute;n para este proveedor:</td>
    <td width="39%"> <?
		if($sql_ex_tipo_evaluacion[0]==25){  ?>
<select name="evaluacion_juridicacompleto"  >
                <option value="Sin">Sin evaluaci&oacute;n</option>
                <option value="1" <? if ($resultado_evaluacion==1) echo "selected"; ?> >Cumple</option>
                <option value="2"  <? if ($resultado_evaluacion==2) echo "selected"; ?> >No cumple</option>
              </select>
    <? }  ?>	
</td>
    <td width="25%">&nbsp;</td>
  </tr>
</table>
<? } ?>
<br>

 <?
 	if($sql_ex_tipo_evaluacion[0]!=27){ ?>
    
<? $campo_evaua1 = 5; ?>
<table width="95%" border="0" cellpadding="1" cellspacing="1" class="tabla_lista_resultados">
  <tr>
    <td height="25" colspan="3" class="columna_titulo_resultados"><div align="center"><?=LENG_332;?></div></td>
  </tr>
  <tr>
    <td width="49%" height="25"><div align="right"><strong><?=LENG_318;?>:</strong></div></td>
    <td width="2%"><div align="left">
      <? if($busca_hist_evaluacion[$campo_evaua1]=="No Cumple") echo '<img src="../imagenes/botones/SemaforoRojo.gif" width="44" height="19">';
		elseif($busca_hist_evaluacion[$campo_evaua1]=="Cumple")  echo '<img src="../imagenes/botones/SemaforoVerde.gif" width="44" height="19">';
			else echo '<img src="../imagenes/botones/SemaforoAmarilloAnimado.gif" width="44" height="19">';
		?>
    </div></td>
    <td width="49%"><?=$busca_hist_evaluacion[$campo_evaua1];?></td>
  </tr>
  <tr>
    <td height="25" colspan="3"><div align="center"></div></td>
  </tr>
</table>
<? } else { ?>
<table width="95%" border="0" cellpadding="1" cellspacing="1" class="tabla_lista_resultados">
  <tr>
    <td height="25" colspan="3" class="columna_titulo_resultados"><div align="center">
      <?=LENG_332;?>
    </div></td>
  </tr>
  <tr>
    <td width="43%" height="25" class="columna_subtitulo_resultados"><div align="right"><strong>
      <?=LENG_121;?>
    :</strong></div></td>
    <td width="28%" class="columna_subtitulo_resultados"><div align="center">
      <?=LENG_156;?>
    </div></td>
    <td width="29%" class="columna_subtitulo_resultados"><div align="center"><strong>
      <?=LENG_318;?>
    </strong></div></td>
  </tr>
  <tr class="campos_blancos_listas">
    <td height="25"><div align="right"><strong>
      <?=LENG_303;?>
    :</strong></div></td>
    <td><div align="center"><?=$sql_proceso[0];?> %</div></td>
    <td><div align="center"><? 				
	$participacion_evaluacion_general = ( ($sql_proceso[0]*$resultado_criterios_por_categoria) /100 );
	echo number_format($participacion_evaluacion_general,2);
			  ?> %</div></td>
  </tr>
  <tr>
    <td height="25"><div align="right"><strong>
      <?=LENG_304;?>
    :</strong></div></td>
    <td><div align="center"><?=$sql_proceso[1];?> %</div></td>
    <td><div align="center"><?=number_format($resultado_criterios_por_categoria,2);?> %</div></td>
  </tr>

  <tr>
  <td></td>
  <td></td>
    <td ><div align="center">
    <? 
		if($estado_general==$num_fila){	
			echo LENG_536;
		}
		elseif($estado_general>=1){
			 echo LENG_535;

		}
		elseif($resultado_criterios_por_categoria<$sql_proceso[1]) { 
			echo '<img src="../imagenes/botones/SemaforoRojo.gif" width="44" height="19">';
					
			
			}
		elseif($suma_porcentaje_afectado>=$sql_proceso[1])  echo '<img src="../imagenes/botones/SemaforoVerde.gif" width="44" height="19">';
			else echo '<img src="../imagenes/botones/SemaforoAmarilloAnimado.gif" width="44" height="19">';
		?>
    
    </div></td>
  </tr>  
</table>
<? } ?>
<?     if( ($sql_cuenta_proveedores_tecnicos[3]==1) && ($sql_busca_encargado_tecnico[0]>=1) ){//si no tiene evaluacion tecnica ?> 
<table width="95%" border="0" cellpadding="1" cellspacing="1" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td width="28%" height="25"><div align="right"></div></td>
    <td width="48%"> </td>
    <td width="15%">
    

 	<? if($sql_ex_tipo_evaluacion[0]!=27){ ?><input name="Submit2" type="button" class="guardar" value="<?=LENG_193;?>  " onClick="c_evaluacion_juridica()">
    <? } else { ?>
    <input name="Submit" type="button" class="guardar" value="<?=LENG_193;?> " onClick="c_evaluacion_tecnica()"><? } ?></td>
    <td width="9%"><span class="titulos_evaluacion"><input name="button2" type="button" class="cancelar" id="button2" value="   Volver al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/apertura_evaluacion_tecnica.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','carga_resultados_principales')"></span></td>
  </tr>
  
</table>
<? } ?>
  
  
<br>



<input type="hidden" name="termino" value="2">
<input type="hidden" name="id_vari" value="<?=$id_vari;?>">
<input type="hidden" name="valor_actual">

<input type="hidden" name="id_invitacion_juri" value="<?=$id_invitacion;?>">
<input type="hidden" name="pv_id" value="<?=$pv_id;?>">
<input type="hidden" name="termino_eva" value="2">

<input type="hidden" name="tipo_configuracion_tecnica" value="<?=$sql_ex_tipo_evaluacion[0];?>">



</body>
</html>
