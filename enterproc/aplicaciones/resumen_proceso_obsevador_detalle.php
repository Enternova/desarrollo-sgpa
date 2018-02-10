<? include("../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

	//verifica_menu("procesos.html");
	$id_invitacion = elimina_comillas($id_invitacion);
	$termino = elimina_comillas($termino);
	
$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));	

			$busca_ingresos = traer_fila_row(query_db("select * from $t36 where pro1_id = $id_invitacion and pv_id = ".$pv_id));

?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
<table width="99%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="80%" class="titulos_evaluacion"><strong>PROVEEDOR:
      <?=listas_sin_select($t8, $pv_id, 3);?>
    </strong></td>
    <td width="20%" class="titulos_evaluacion"><input name="button3" type="button" class="buscar" id="button3" value="Ver resumen del proceso" onclick="ajax_carga('../aplicaciones/resumen_proceso_obsevador.php?pasa=<?=arreglo_pasa_variables($id_invitacion);?>','contenidos')"></td>
  </tr>
  <tr>
    <td><strong>Visualizaci&oacute;n inicial del proceso: </strong><?=$busca_ingresos[4];?></td>
    <td class="titulos_evaluacion">&nbsp;</td>
  </tr>
  <tr>
    <td><strong>Ultimo ingreso al proceso: </strong>
      <?=$busca_ingresos[7];?>
    </td>
    <td class="titulos_evaluacion">&nbsp;</td>
  </tr>
</table>

<table width="99%" border="0" cellpadding="4" cellspacing="4" class="tabla_lista_resultados">
  <tr>
    <td width="30%" height="26"><div align="left"><span class="titulos_tabla_detalle">Consecutivo del proceso:</span>
            <?=$sql_e[22];?>
    </div></td>
    <td width="22%"><span class="titulos_tabla_detalle">Tipo de proceso: </span>
        <?=listas_sin_select($tp2,$sql_e[2],1);?>    </td>
  </tr>
  <tr>
    <td height="26" colspan="2"><div align="justify"><span class="titulos_tabla_detalle">Detalle y cantidad del objeto a contratar:</span>
            <?=$sql_e[12];?>
    </div></td>
  </tr>
</table>
<br>
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">Informe de documentos del proceso descargados por el proveedor</td>
  </tr>
</table>
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td width="16%" class="columna_titulo_resultados">Tipo documento</td>
    <td width="5%" class="columna_titulo_resultados">Anexo</td>
    <td width="62%" class="columna_titulo_resultados">Nombre</td>
    <td width="17%" class="columna_titulo_resultados">Descargado</td>
  </tr>

  <?
			 
			  	$busca_provee = query_db("select $t6.pro2_id, $tp8.nombre, $t6.archivo,$t6.peso,$t6.fecha_carga,tipo_archivo,if(origen=1,'Urna','Solicitud'),origen,if(id_origen=0,$t6.pro2_id,id_origen) from $t6, $tp8 where
				$t6.pro1_id =  $id_invitacion and $tp8.tp8_id = $t6.tp8_id");
				while($lp = traer_fila_row($busca_provee)){
			    $ext=extencion_archivos($lp[2]);
				

				$busca_docuemntos_descagados=traer_fila_row(query_db("select detalle from $v5 where pro1_id = $id_invitacion and  pv_id = $pv_id and detalle= $lp[0]"));
				if($busca_docuemntos_descagados[0]!="")	$descargado="Si";
				else $descargado="No";
					
			  
					  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
  ?>
  <tr class="<?=$class;?>">
    <td><?=$lp[1];?></td>
    <td><img src="../imagenes/mime/<?=$ext;?>.gif"></td>
    <td><?=$lp[2];?></td>
    <td><div align="center"><?=$descargado;?></div></td>
  </tr>
  <? $num_fila++;} ?>
</table>
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">Resumen ofertas t&eacute;cnicas enviadas por le proveedor</td>
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
    

      <table width="99%" border="0" cellpadding="0" cellspacing="0" class="tabla_lista_resultados">
<tr >
            <td colspan="2" class="columna_titulo_resultados">
              <table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td width="41%"><div align="left"><strong>Categoria:
                      <?=$li[1];?>
                    </strong></div></td>
                    <td width="56%">&nbsp;</td>
                    <td width="3%">&nbsp;</td>
                </tr>
            </table>            </td>
          </tr>
          <tr > 
            <td width="32%"   class="columna_subtitulo_resultados"><div align="left">&nbsp;Criterios de evaluaci&oacute;n</div></td>
            <td width="68%"   class="columna_subtitulo_resultados">Documentos recibidos</td>
        </tr>
          <?
  	$suma_apa=0;
	$valor = 0;
	$lista_criterios = "select * from $t90, $t91 where $t91.in_id = $id_invitacion and  $t90.rel10_id  = $t91.rel10_id  and  $t90.rel9_id = $li[0] and $t90.rel10_estado=1";
	$linvi_cri=query_db($lista_criterios);
	$resulatdo_afectado=0;

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
            <td><table width="99%" border="0" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
              <tr>
                <td width="66" class="columna_titulo_resultados"><div align="center"><strong>Tipo</strong></div></td>
                <td width="242" class="columna_titulo_resultados"><div align="left"><strong>Nombre del Documento</strong></div></td>
                <td width="147" class="columna_titulo_resultados"><div align="left"><strong>Fecha</strong></div></td>
                <td width="117" class="columna_titulo_resultados"><div align="left"><strong>Observaciones</strong></div></td>
              </tr>
              <?
			
			$resultado_evaluacion=0;
			$busca_respo = query_db("select * from ".$t96." where pv_id = ".$pv_id." and evaluador1_id = $bus_his[0]");
			$suma_archivo_ajuste_chimbo=0;
			while($lc=traer_fila_row($busca_respo)){
			$ext=extencion_archivos($lc[3]);
			if($lc[6]!="") $observ_de = "Con observaciones";
			else $observ_de = " ";
			
		?>
              <tr class="administrador_tabla_generales">
                <td><? if ($ext!=""){ ?><img src="../imagenes/mime/<?=$ext;?>.gif" alt="Tipo Documento"><? } ?></td>
                <td><?=$lc[3];?></td>
                <td><?=fecha_for_hora($lc[7]);?></td>
                <td><?=$observ_de;?></td>
              </tr>
              <? 
			  $resultado_evaluacion = $lc[8]; 
			  $resulatdo_afectado+= $lc[9];
			  $suma_archivo_ajuste_chimbo++;
			   }
			  
			  //$resultado_evaluacion=($resultado_evaluacion/$suma_archivo_ajuste_chimbo);
			  $resulatdo_afectado=($resulatdo_afectado/$suma_archivo_ajuste_chimbo);
			   
			  
			   ?>
            </table></td>
          </tr>
          <? $num_fila++; }
		  
		  if($resulatdo_afectado>=1){
		  		$resultado_por_categoria_final = ( ($valor_categorias * $resulatdo_afectado) /100 );
				$resultado_criterios_por_categoria = ( (100 * $resulatdo_afectado) /100 );
				$suma_porcentaje_afectado+= $resultado_por_categoria_final;
				

		  
		  }
		  
		   ?>
      </table>

      <table width="99%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td class="titulos_procesos">Resumen ofertas comerciales enviadas por le proveedor</td>
        </tr>
      </table>
<? } ?>

<?
  
  if($termino==2)
  	$complemento.= " and tp6_id = $busca_fechas[8]";
	
	$grupo_terminos = "select distinct $t89.rel9_id ,$t89.rel9_detalle  from $t89, $t90, $t91  where
	$t91.in_id = $id_invitacion and 
	$t91.termino = 1 and 
	$t90.rel10_id = $t91.rel10_id and 
	$t89.rel9_id  = $t90.rel9_id";

	$terminos=query_db($grupo_terminos);
	while($li=traer_fila_row($terminos)){

?>

 
      <table width="99%" border="0"  cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
<tr>
            <td colspan="2" class="columna_titulo_resultados">
              <table width="100%" border="0" cellspacing="2" cellpadding="2">
                  <tr>
                    <td width="20%"><div align="left"><strong>Categoria:
                      <?=$li[1];?>
                    </strong></div></td>
                </tr>
              </table>           </td>
        </tr>
          <tr > 
            <td width="32%"  class="columna_subtitulo_resultados"><div align="center">Criterios de evaluaci&oacute;n</div></td>
            <td width="68%"  class="columna_subtitulo_resultados">Documentos recibidos</td>
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
            

<table width="99%" border="0" cellpadding="3" cellspacing="3" class="tabla_lista_resultados">
  <tr>
    <td width="66" class="columna_titulo_resultados"><div align="center"><strong>Tipo</strong></div></td>
    <td width="247" class="columna_titulo_resultados"><div align="left"><strong>Nombre del Documento</strong></div></td>
    <td width="142" class="columna_titulo_resultados"><div align="left"><strong>Fecha</strong></div></td>
    <td width="106" class="columna_titulo_resultados"><div align="left"><strong>Observaciones</strong></div></td>
    </tr>
  <?
$observ_de_j = " ";
			$resultado_evaluacion=0;
			$busca_respo = query_db("select * from ".$t96." where pv_id = ".$pv_id." and evaluador1_id = $bus_his[0]");
			while($lc=traer_fila_row($busca_respo)){
			$ext=extencion_archivos($lc[3]);
			
		if($lc[6]!="") $observ_de_j = "Con observaciones";
			else $observ_de_j = " ";			
			
		?>
  <tr class="administrador_tabla_generales">
    <td><? if ($ext!=""){ ?><img src="../imagenes/mime/<?=$ext;?>.gif" alt="Tipo Documento"><? } ?></td>
    <td><?=$lc[3];?></td>
    <td><?=fecha_for_hora($lc[7]);?></td>
    <td><?=$observ_de_j;?></td>
    </tr>
  <? $resultado_evaluacion = $lc[8]; } ?>
</table>            
            
            
            </div></td>
          </tr>
          <? $num_fila++;
		 
		  }// while ?>
      </table>
  
      <p>
        <? } ?>
</p>
      <table width="99%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td class="titulos_procesos">Informe de confirmaci&oacute;n de participaci&oacute;n en el proceso</td>
        </tr>
      </table>
      <table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td  colspan="3" class="columna_titulo_resultados"><strong>HISTORICO DE CONFIRMACION DE PARTICIPACION EN EL PROCESO</strong></td>
        </tr>
        <tr>
          <td width="85" class="columna_subtitulo_resultados">Confirmaci&oacute;n</td>
          <td width="132" class="columna_subtitulo_resultados">Fecha</td>
          <td width="330" class="columna_subtitulo_resultados">Justificaci&oacute;n</td>
        </tr>
        <?
 	$busca_confirmacion = query_db("select * from v_confirmacion where pro1_id = $id_invitacion and pv_id = $pv_id order by nit, fecha desc");
	while($b_c=traer_fila_row($busca_confirmacion)){
	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
 
 ?>
        <tr class="<?=$class;?>">
          <td><?=$b_c[2];?></td>
          <td><?=fecha_for_hora($b_c[3]);?></td>
          <td><?=$b_c[4];?></td>
        </tr>
        <? $num_fila++;  }  ?>
      </table>
      <table width="99%" border="0" cellspacing="2" cellpadding="2">
        <tr>
          <td class="titulos_procesos">Informe de bitacora y seguimiento de contacto con el proveedor</td>
        </tr>
      </table>
      <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="4" class="columna_titulo_resultados"><strong>HISTORICO DE BITACORA Y SEGUIMIENTO DEL PROVEEDOR</strong></td>
        </tr>
        <tr>
          <td width="13%" class="columna_subtitulo_resultados">Usuario</td>
          <td width="15%" class="columna_subtitulo_resultados">Fecha</td>
          <td width="54%" class="columna_subtitulo_resultados">Detalle gesti&oacute;n</td>
          <td width="18%" class="columna_subtitulo_resultados">Nueva llamada</td>
        </tr>
        <?
			  	$sele_car="select pro15_id, nombre_administrador, fecha_hora_gestion, detalle_gestion, proxima_llamada from $v6 where pro1_id = $id_invitacion and pv_id = $pv_id order by fecha_hora_gestion desc";
				$sql_ex_c=query_db($sele_car);
				while($ls_c=traer_fila_row($sql_ex_c)){
		if($num_fila_gene%2==0)
				$class_g="campos_blancos_listas";
			else
				$class_g="campos_gris_listas";
				

  ?>
        <tr class="<?=$class_g;?>">
          <td><?=$ls_c[1];?></td>
          <td align="center"><?=fecha_for_hora($ls_c[2]);?></td>
          <td align="center"><?=$ls_c[3];?></td>
          <td><?=fecha_for_hora($ls_c[4]);?></td>
        </tr>
        <? 
				  
				 $num_fila_gene++; } ?>
      </table>
      <p>&nbsp;      </p>
</body>
</html>
