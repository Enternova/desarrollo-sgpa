<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    //verifica_menu("procesos.html");

//$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	
	$id_invitacion = $id_p;
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$busca_confirmacion = traer_fila_row(query_db("select * from $t9 where  pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." order by fecha desc"));

?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css">
</head>
<body >
<div id="detalle_item">





<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">SECCION: APERTURA Y EVALUACION DE PROCESOS DE CONTRATACION</td>
  </tr>
</table>
<BR>

<table width="800" border="0" align="left" cellpadding="4" cellspacing="4">
  <tr>
    <td width="30%" height="26"><div align="left"><strong>Consecutivo del proceso:<?=$sql_e[22];?></strong></div></td>
    <td width="22%"><strong>Tipo de proceso:</strong></td>
    <td width="22%"><div align="left"><?=listas_sin_select($tp2,$sql_e[2],1);?></div></td>
  </tr>
  <tr>
    <td height="26"><div align="left"><strong>Tipo de contrato:<?=listas_sin_select($tp5,$sql_e[5],1);?></strong></div></td>
    <td><strong>Objeto a contratar:</strong></td>
    <td><div align="left"><?=listas_sin_select($tp6,$sql_e[11],1);?></div>    </td>
  </tr>
  <tr>
    <td height="26" colspan="3"><div align="justify"><strong>Detalle y cantidad del objeto a contratar:<?=$sql_e[12];?></strong></div></td>
    </tr>
</table>

<br>
  
    <?
$busca_juridico = "select count($t89.rel9_aspecto) from $t89, $t90, $t91, $t5 where 
		$t91.in_id = $id_invitacion and 
		$t90.rel10_id = $t91.rel10_id and 
		$t89.rel9_id = $t90.rel9_id and
		$t89.rel9_aspecto = 1 and
		$t5.pro1_id = $t91.in_id ";
		$exs=traer_fila_row(query_db($busca_juridico));


		$busca_tecnico = "select count($t89.rel9_aspecto) from $t89, $t90, $t91, $t5 where 
		$t91.in_id = $id_invitacion and 
		$t90.rel10_id = $t91.rel10_id and 
		$t89.rel9_id = $t90.rel9_id and
		$t89.rel9_aspecto = 2 and
		$t5.pro1_id = $t91.in_id   ";
		$exs_te=traer_fila_row(query_db($busca_tecnico));
		
		
		 $busca_economico = "select count($t95.evaluador5_id ) from $t95, $t5 where 
		$t95.in_id = $id_invitacion and 
		$t5.pro1_id = $id_invitacion   ";
		$exs_eco=traer_fila_row(query_db($busca_economico));

	$total_eva = ($exs[0]+$exs_te[0]+$exs_eco[0]);
	$total_menos_econo = ($exs[0]+$exs_te[0]);

	if($total_menos_econo>=1){
?>
  
  
  
</p>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
              <tr>
                <td width="10%" class="titulo_tabla_azul_sin_bordes">Nit</td>
                <td width="19%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
                <td width="15%" class="titulo_tabla_azul_sin_bordes">Tel&eacute;fono</td>
                <td width="21%" class="titulo_tabla_azul_sin_bordes">E-mail</td>
                <td width="10%" class="titulo_tabla_azul_sin_bordes">participaci&oacute;n</td>
                <td width="6%" class="titulo_tabla_azul_sin_bordes">Resultado evaluaci&oacute;n juridica</td>
                <td width="6%" class="titulo_tabla_azul_sin_bordes">Resultado evaluaci&oacute;n t&eacute;cnica</td>
              </tr>
              
              <?
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id");
				while($lp = traer_fila_row($busca_provee)){
			  
				$busca_confirmacion_participacion = traer_fila_row(query_db("select count(*) from $t9 where pv_id = $lp[0]  and estado = 1 and confirmacion  = 1 "));				
	  
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";

			$buscar_resultado =  traer_fila_row(query_db("select * from evaluador10_calificacion_obtenida  where pv_id = $lp[0] and proc1_id = $id_invitacion"));
				
  ?>
  <tr class="<?=$class;?>">
  
                <td><?=$lp[1];?></td>
                <td><?=$lp[2];?></td>
                <td><?=$lp[3];?></td>
                <td><?=$lp[4];?></td>
                <td><?=$busca_confirmacion_participacion[0];?></td>
                <td><div align="center">
                 <? if($buscar_resultado[3]=="") echo "Sin evaluación"; else echo $buscar_resultado[3]; ?>
                  <input name="button3" type="button" class="buscar" id="button3" onClick="ajax_carga('../aplicaciones/evaluacion/evaluacion_juridica.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lp[0];?>','carga_evaluacion')" value="Evaluaci&oacute;n jur&iacute;dica" />
    </div></td>
                <td><div align="center">
                  <? if($buscar_resultado[5]=="") echo "Sin evaluación"; else echo $buscar_resultado[5]." %"; ?>
                  <input name="button5" type="button" class="buscar" id="button5" onClick="ajax_carga('../aplicaciones/evaluacion/evaluacion_tecnica.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lp[0];?>','carga_evaluacion')" value="Evaluaci&oacute;n t&eacute;cnica" />
    </div></td>
  </tr>
              <? $num_fila++;} ?>
  </table>
            <br />


<?	
	}
	if($total_eva==0){//si tiene evaluacion no solicita documentos
	
	?>
<br />

            
                 <?
  		$busca_respo_lista = query_db("select $t7.pro3_id , $t8.razon_social , $t8.nit , $t8.pv_id from $t7,$t8 where $t7.pro1_id  = $id_invitacion 
		and $t8.pv_id = $t7.pv_id ");
		while($lcproveedor=traer_fila_row($busca_respo_lista)){    
	?>
            <table width="100%" border="0" align="center" cellpadding="3" cellspacing="3" class="tabla_borde_azul_fondo_blanco" >
              <tr>
                <td class="titulosubsec2"><div align="left"><?=$lcproveedor[1];?>
                </div>                </td>
              </tr>
              <tr>
                <td width="82%" class="administrador_contenido_celdas"><table width="100%" border="0" align="center" cellpadding="3" cellspacing="3" class="administrador_tabla_generales">
                    <tr>
                      <td width="5%" class="administrador_contenido_celdas"><div align="center"><strong>Tipo</strong></div></td>
                      <td width="46%" class="administrador_contenido_celdas"><div align="left"><strong>Nombre del Documento</strong></div></td>
                      <td width="26%" class="administrador_contenido_celdas"><div align="left"><strong>Fecha del Documento </strong></div></td>
                      <td width="11%" class="administrador_contenido_celdas"><div align="center"><strong>Tama&ntilde;o</strong></div></td>
                      <td width="12%" class="administrador_contenido_celdas"><div align="center"><strong>Acciones</strong></div></td>
                    </tr>
                    <?
			$busca_respo = query_db("select * from $t60 where in_id = $id_invitacion  and pv_id = $lcproveedor[3]");
			while($lc=traer_fila_row($busca_respo)){
			$extencion = explode(".",$lc[3]);
		?>
                    <tr class="administrador_tabla_generales">
                      <td><img src="../../imagenes/mime/<?=$extencion[1];?>.gif"></td>
                      <td><?=$lc[3];?></td>
                      <td><?=$lc[6];?></td>
                      <td><?=number_format($lc[4]/1024,2);?>
                        KB</td>
                      <td><div align="center"><a href='../generales/complementos/baja_anexo_invita_proveedor_generales.php?n1=<?=$lc[0];?>&n2=<?=$lc[3];?>&us_cliente_pasa=<?=$linvi[1];?>'> <img src="../../imagenes/botones/nuevo_1.png"></a> </div></td>
                    </tr>
                    <? } ?>
                </table></td>
              </tr>
            </table>
            <br>
             <? } ?>

<? } ?>
<br>


            <table width="900px" height="44" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td></td>
  </tr>
  <tr >
    <td width="34%"  align="left">
      <div align="center">&nbsp;&nbsp;
<?
		 $campo_valos_sql = traer_fila_row(query_db("select * from $t94 where in_id = $id_invitacion and evaluador4_tipo  in ('Valor')"));
		 $campo_valos= $campo_valos_sql[0];

?>

        <input name="button4" type="button" class="buscar" id="button4" onClick="ajax_carga('../aplicaciones/evaluacion/c_economico.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&tipo_busq=min','carga_evaluacion')" value="Evaluacion econ&oacute;mica detallada "/> 
         &nbsp;&nbsp;&nbsp;
	  <input name="button7" type="button" class="buscar" id="button7" onClick="ajax_carga('../aplicaciones/evaluacion/c_economico5.php?id_invitacion=<?=$id_invitacion;?>&pv_id=<?=$lc[4];?>&campo_valos=<?=$campo_valos;?>&tipo_busq=min','carga_evaluacion')" value="Evaluacion econ&oacute;mica consolidada de las listas "/> 
      <input name="button6" type="button" class="buscar" id="button6" onClick="ajax_carga('../aplicaciones/evaluacion/adjudicacion.php?id_invitacion=<?=$id_invitacion;?>&campo_valos=<?=$campo_valos;?>','carga_evaluacion')" value="Adjudicaci&oacute;n "/>
      <input name="button8" type="button" class="buscar" id="button8" onClick="ajax_carga('../aplicaciones/evaluacion/detalle_acta_grantierra.php?id_invitacion=<?=$id_invitacion;?>&campo_valos=<?=$campo_valos;?>','carga_evaluacion');ingresar_listado('detalle_item')" value="Acta de apertura"/>
      <br>
      </div></td>
  </tr>
</table>

</div>
<div id="carga_evaluacion"></div>


<div id="detalle_item_2"></div>


<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_pasa;?>">
<input type="hidden" name="id_anexo">
</body>
</html>
