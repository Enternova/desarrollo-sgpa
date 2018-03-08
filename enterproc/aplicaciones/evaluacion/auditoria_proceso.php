<? include("../../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	//verifica_menu("procesos.html");

 $id_invitacion = elimina_comillas(arreglo_recibe_variables($pasa));
	

//filtros
if($filtro_ip!=0)
$complemnto_filtro.=" and sub_proceso = $filtro_ip ";
if($filtro_usuario!=0)
$complemnto_filtro.=" and us_id = $filtro_usuario ";
if($filtro_categoria!=0)
$complemnto_filtro.=" and auditor_categoria_id = $filtro_categoria ";	



//paguinacion
$numero_pagi = 30;
if ($pag=="")
	$pag = 1;
else
	$pag = $pag;

$paginador = (($pag-1)*$numero_pagi);


	  $li_n_c=traer_fila_row(query_db("select count(*) from $v5 where pro1_id =  $id_invitacion $complemnto_filtro	 "));
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
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >

<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td width="83%" class="titulos_evaluacion">Auditoria del proceso</td>
    <td width="17%">
      <div align="left">
        <input name="button" type="button" class="cancelar" id="button" value="Volver  al resumen" onClick="ajax_carga('../aplicaciones/evaluacion/detalle_invitacion.php?id_p=<?=$id_invitacion;?>','contenidos')">
        </div>        </td></tr>
</table>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td colspan="4" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
                  <tr>
                    <td width="77%"><div align="left"><img src="../imagenes/botones/help.gif" alt="Ayuda" width="18" height="18"> Se muestra en detalle cualquier acci&oacute;n realizada a este proceso.</div></td>
                    <td width="6%"><div align="center"><a href="javascript:busqueda_paginador_nuevo(<?=$anterior;?>,'../aplicaciones/evaluacion/auditoria_proceso.php','carga_resultados_principales', '<?=$tipo_ingreso_alerta;?>')">Anterior</a></div></td>
                    <td width="10%"><label>
                      <select name="pagij" onChange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/evaluacion/auditoria_proceso.php','carga_resultados_principales', '<?=$tipo_ingreso_alerta;?>')">
                        <? 
		  for($i=1;$i<=$pagina;$i++){
		   ?>
                        <option value="<?=$i;?>"  <? if($i==$pag) echo "selected"; ?>>Pagina
                          <?=$i;?>
                        </option>
                        <? } ?>
                      </select>
                    </label></td>
                    <td width="7%"><a href="javascript:busqueda_paginador_nuevo(<?=$proxima;?>,'../aplicaciones/evaluacion/auditoria_proceso.php','carga_resultados_principales', '<?=$tipo_ingreso_alerta;?>')">Siguiente</a></td>
                  </tr>
                </table></td>
              </tr>
              <tr>
                <td width="34%" class="columna_subtitulo_resultados">Accion</td>
                <td width="33%" class="columna_subtitulo_resultados">Nombre usuario</td>
                <td width="15%" class="columna_subtitulo_resultados">Fecha</td>
                <td width="18%" class="columna_subtitulo_resultados">IP de conexion</td>
              </tr>
              <tr>
                <td class="columna_subtitulo_resultados"><select name="filtro_categoria" id="filtro_categoria" onChange="busqueda_paginador_nuevo(1,'../aplicaciones/evaluacion/auditoria_proceso.php','carga_resultados_principales', '<?=$tipo_ingreso_alerta;?>')">
                    <option value="0">Filtro</option>
                    <?
			  	
			  	$busca_provee = query_db("select distinct auditor_categoria_id, nombre from $v5 where pro1_id =  $id_invitacion ");
				while($lp = traer_fila_row($busca_provee)){ 
				if($lp[0]==$filtro_categoria) $selecciona = "selected";
				else  $selecciona = "";		

													
				
				?>
                    <option value="<?=$lp[0];?>" <?=$selecciona;?>>
                      <?=$lp[1];?>
                  </option>
                    <?
					}
				?>
                  </select>                </td>
                <td class="columna_subtitulo_resultados"><select name="filtro_usuario" id="filtro_usuario" onChange="busqueda_paginador_nuevo(1,'../aplicaciones/evaluacion/auditoria_proceso.php','carga_resultados_principales', '<?=$tipo_ingreso_alerta;?>')">
                    <option value="0">Filtro</option>
                    <?
			  	
			  	$busca_provee = query_db("select distinct us_id, nombre_administrador from $v5 where pro1_id =  $id_invitacion ");
				while($lp = traer_fila_row($busca_provee)){ 
				if($lp[0]==$filtro_usuario) $selecciona = "selected";
				else  $selecciona = "";				
				

				
				?>
                    <option value="<?=$lp[0];?>" <?=$selecciona;?>>
                      <?=$lp[1];?>
                  </option>
                    <?
					}
				?>
                  </select>                </td>
                <td class="columna_subtitulo_resultados">&nbsp;</td>
                <td class="columna_subtitulo_resultados"><select name="filtro_ip" id="filtro_ip" onChange="busqueda_paginador_nuevo(1,'../aplicaciones/evaluacion/auditoria_proceso.php','carga_resultados_principales', '<?=$tipo_ingreso_alerta;?>')">
                    <option value="0">Filtro</option>
                    <?
			  	
			  	$busca_provee = query_db("select distinct sub_proceso from $v5 where pro1_id =  $id_invitacion ");
				while($lp = traer_fila_row($busca_provee)){ 
				if($lp[0]==$filtro_ip) $selecciona = "selected";
				else  $selecciona = "";		
				
		
				
				?>
                    <option value="<?=$lp[0];?>" <?=$selecciona;?>>
                      <?=$lp[0];?>
                  </option>
                    <?
					}
				?>
                </select></td>
              </tr>
              
              <?
			  	
			  	$busca_provee = query_db("select * from $v5 where pro1_id =  $id_invitacion $complemnto_filtro order by fecha_hora desc limit $paginador,$numero_pagi ");
				while($lp = traer_fila_row($busca_provee)){
				  
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";


				
  ?>
  <tr class="<?=$class;?>">
  
                <td><?=$lp[1];?> | <?=$lp[9];?></td>
                <td><?=$lp[5];?></td>
                <td><?=$lp[8];?></td>
                <td><?=$lp[10];?></td>
  </tr>
              <? $num_fila++;
			 
			  } ?>
  </table>
<input type="hidden" name="pasa" value="<?=arreglo_pasa_variables($id_invitacion);?>">

<div id="carga_evaluacion"></div>
</body>
</html>
