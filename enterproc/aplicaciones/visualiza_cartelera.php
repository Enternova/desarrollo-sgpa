<? include("../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("principal.html");
	$id_invitacion = $id_invitacion_pasa;
	
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));


?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css">
</head>
<body >
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="88%" class="titulos_procesos">CARTELERA DE ACLARACIONES<br>
      <strong>Consecutivo del proceso:
        <?=$sql_e[22];?>
      </strong></td>
    <td width="12%"><input name="button6" type="button" class="cancelar" id="button6" value="Volver al proceso" onClick="ajax_carga('../aplicaciones/visualiza_proceso.php?id_p=<?=$id_invitacion_pasa;?>&ruta_ev=<?=$ruta_ev;?>','contenidos')"> <input name="button7" type="button" class="calcular" id="button7" value="     Exportar cartelera a excel" onClick="window.parent.location.href='../aplicaciones/exporta_cartelera.php?id_invitacion_pasa=<?=$id_invitacion;?>'"></td>
  </tr>
</table>
<br>
<fieldset style="width:98%">
			<legend>Historico de preguntas</legend>
            <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
              <tr>
                <td width="14%" class="titulo_tabla_azul_sin_bordes">Solicitante</td>
                <td width="18%" class="titulo_tabla_azul_sin_bordes">Fecha de pregunta</td>
                <td width="62%" class="titulo_tabla_azul_sin_bordes">Pregunta</td>
                <td width="6%" class="titulo_tabla_azul_sin_bordes">Anexo</td>
                <td width="6%" class="titulo_tabla_azul_sin_bordes">&nbsp;</td>
              </tr>
              
              <?
			  	$sele_car="select * from $t15 where pro1_id = $id_invitacion and tipo_aclaracion  = 1  order by fecha_pregunta desc";
				$sql_ex_c=query_db($sele_car);
				while($ls_c=traer_fila_row($sql_ex_c)){
		if($num_fila_gene%2==0)
				$class_g="campos_blancos_listas";
			else
				$class_g="campos_gris_listas";
				
				if($ls_c[7]==2) $solicitante = "GTEC";
				else{
					$pv_id_pr_p = explode("|",$ls_c[2]);
					$busca_proveedor = traer_fila_row(query_db("select pv_id, razon_social from $t8 where pv_id = $pv_id_pr_p[0]"));
					$solicitante= $busca_proveedor[1];
				}
				
				$ext="";
				$ext=extencion_archivos($ls_c[11]);

  ?>
      <tr class="<?=$class_g;?>">
        <td><?=$solicitante;?></td>
                <td><div align="center"><?=fecha_for_hora($ls_c[3]);?>
                </div></td>
                <td><div align="left"><?=$ls_c[4];?></td>
                <td><? if($ext!=""){ ?><img src="../imagenes/mime/<?=$ext;?>.gif" onClick="window.parent.location.href='../librerias/php/descarga_documentos_cartelera_pregunta.php?n1=<?=$ls_c[0];?>&n2=<?=$ls_c[11];?>'" ><? } ?></td>
                <td>
                  <input name="button" type="button" class="buscar" id="button" onClick="ver_respuestas('div_for_<?=$ls_c[0];?>')" value="Ver   ">
				</td>
              </tr>
			   
              <tr>
                <td colspan="5" id="div_for_<?=$ls_c[0];?>" style="display:none">
                <table width="95%" border="0" align="right" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
                  <tr class="<?=$class;?>">
                    <td class="columna_subtitulo_resultados">&nbsp;</td>
                    <td class="columna_subtitulo_resultados"><strong>Eviado por:</strong></td>
                    <td class="columna_subtitulo_resultados"><strong>Fecha de envio</strong></td>
                    <td class="columna_subtitulo_resultados"><strong>Detalle del comunicado / pregunta</strong></td>
                  </tr>
                   <?
			  	$sele_car_foro="select pro8_id ,pro7_id,tipo_preg_respuesta ,us_id ,pv_id ,fecha_foro ,foro ,publica from $t16 where pro7_id = $ls_c[0]  order by fecha_foro  desc";
				$sql_ex_c_foro=query_db($sele_car_foro);
				while($ls_c_f=traer_fila_row($sql_ex_c_foro)){
				
				
		
								
									
				if($ls_c_f[4]==0) { $imagen = "respuesta_f.png"; $solicitante_foro = "PCL"; }
				else  {$imagen =  "pregunta_f.png"; 
									
					$busca_proveedor = traer_fila_row(query_db("select pv_id, razon_social from $t8 where pv_id = $ls_c_f[4]"));
					$solicitante_foro= $busca_proveedor[1];

				 }
				
		if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";

  ?>
          
                  <tr class="<?=$class;?>">
                    <td width="4%"><div align="right"><img src="../imagenes/botones/<?=$imagen;?>" width="24" height="24"></div></td>
                    <td width="30%"><?=$solicitante_foro;?></td>
                    <td width="15%">
                      <div align="center">
                        <?=fecha_for_hora($ls_c_f[5]);?>
                      </div></td>
                    <td width="51%"><div align="left">
                      <?=$ls_c_f[6];?>
                    </div></td>
                  </tr>
                  <? $num_fila++;} ?>
                   
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                  </tr>
                 
                  <tr>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td>&nbsp;</td>
                    <td><div align="center">&nbsp;
                      <input name="button3" type="button" class="cancelar" id="button3" value="Cerrar respuestas" onClick="oculat_respuestas('div_for_<?=$ls_c[0];?>')">
                      
                    </div></td>
                  </tr>
                </table>                </td>
              </tr>
				  <? 
				  
				 $num_fila_gene++; } ?>           
            </table>
</fieldset>            

<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_pasa;?>">
<input type="hidden" name="id_elimina">
<input type="hidden" name="ocu_re">

</body>
</html>
