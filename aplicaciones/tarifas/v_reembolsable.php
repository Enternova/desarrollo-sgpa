<? include("../../librerias/lib/@session.php"); 
//	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';		

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	$id_reembolsable_arr = elimina_comillas(arreglo_recibe_variables($id_reembolsable_factura_or));
	
	
	$busca_contrato = "select * from $v_t_1 where tarifas_contrato_id = $id_contrato_arr";
	$sql_con=traer_fila_row(query_db($busca_contrato));

	$busca_reembolsables = "select * from t6_tarifas_reembosables1_contrato where t6_tarifas_contratos_id = ".$sql_con[0]. " and estado = 1";
	$busca_ree = traer_fila_row(query_db($busca_reembolsables));
	
	   $busca_item = "select t6_tarifas_reembolables_datos_id, tarifas_contrato_id, fecha_creacion, estado, fecha_ini, fecha_fin, municipo, municipo ,porcentaje_administracion,consecutivo,tipo_contrato,orden_trabajo
	from $v_t_11  where t6_tarifas_reembolables_datos_id =  $id_reembolsable_arr ";	  
	$sql_ex = traer_fila_row(query_db($busca_item));
	
	
			$fecha_inicial = $sql_ex[4];
			$fecha_final = $sql_ex[5];

			$municipio_pre=$sql_ex[6];
			$proyecto_pre=$sql_ex[7];

$fecha_cre= explode("-",$sql_ex[2]);	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=ISO-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<table width="99%" border="0" cellspacing="0" cellpadding="0">
  <tr>
    <td width="92%" class="titulos_secciones">SECCION:&gt;&gt;  VISTA PREVIA DEL REEMBOLSABLE</td>
    <td width="8%" class="titulos_secciones">
<? 
if ($ruta_regreso==1){ ?>
    <input type="button" name="button5" class="boton_volver" id="button5" value="Volver al historico" onclick="ajax_carga('../aplicaciones/tarifas/h_reembolsables_contrato_reporte.php?id_contrato=<?=$id_contrato;?>','carga_acciones_permitidas')" />
<? } elseif ($ruta_regreso==2){ ?>
        <input type="button" name="button5" class="boton_volver" id="button5" value="Volver al historico" onclick="ajax_carga('../aplicaciones/tarifas/h_reembolsables_prove_reporte.php?b_contrato=<?=$_GET["b_contrato"]?>&b_tiquete=<?=$_GET["b_tiquete"]?>&b_proyect=<?=$_GET["b_proyect"]?>&fecha_inicial=<?=$_GET["fecha_inicial"]?>&fecha_final=<?=$_GET["fecha_final"]?>&gerentes=<?=$_GET["gerentes"]?>&b_provee=<?=$_GET["b_provee"]?>&pagina=<?=$_GET["pagina"]?>','contenidos')" />
</td>
<? } ?>
  </tr>
  <tr>
    <td colspan="2" ><? echo encabezado_contrato_tarifas($id_contrato_arr);?></td>
  </tr>
</table>


<br />

<br />
<table width="99%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td class="fondo_2_sub">Datos basicos del reembolsable</td>
  </tr>
  <tr>
    <td><div align="left"><strong>Consecutivo del reembolsable: R - <?=$sql_ex[9];?> - <?=$fecha_cre[0];?></strong></div></td>
  </tr>
  <tr>
    <td><div align="left"><strong>Contrato:</strong> <?=$sql_con[7];?></div></td>
  </tr>
   <tr>
    <td><div align="left"><strong>Rango del reembolsable:</strong><?=$sql_ex[4].' al '.$sql_ex[5];?></div></td>
  </tr>  
   <tr>
    <td><div align="left"><strong>El contrato es tipo:</strong>  <? if($sql_ex[10]==1){ echo 'Marco | orden de trabajo:'.$sql_ex[11]; } else echo 'Normal';  ?>
	</div></td>
  </tr>  


  <tr>
    <td><div align="left"><strong>Objeto del Contrato:</strong><?=$sql_con[9];?></div></td>
  </tr>
  <tr>
    <td><div align="left"><strong>Municipio:</strong><?=$municipio_pre;?></div></td>
  </tr>
</table>
<p>&nbsp;</p>
<?

 $busca_lista_ree_proyecto = "select distinct t6_tarifas_municipios_proyectos_id, proyecto  from v_tarifas_reemblosables_detalle where t6_tarifas_reembolables_datos_id = $id_reembolsable_arr";
	$sql_ree_poyecto = query_db($busca_lista_ree_proyecto);
	while($l_ree_proy=traer_fila_row($sql_ree_poyecto)){//lista reembola proyectos
$num_fila=0;
?>

<table width="99%" border="0" align="center" class="tabla_lista_resultados">
  <tr>
    <td colspan="7" class="columna_titulo_resultados">LISTA DE ITEMS REEMBOLSABLES PARA EL PROYECTO <?=$l_ree_proy[1];?></td>
  </tr>
  <tr class="columna_subtitulo_resultados">
    <td width="28%" align="center">Categor&iacute;a</td>
    <td width="13%" align="center"><?=TITULO_5;?></td>
    <td width="13%" align="center">Valor</td>
    <td width="11%" align="center">Moneda</td>
    <td width="34%" align="center">Detalle</td>
    <td width="10%" align="center">Factura No.</td>
    <td width="4%" align="center">Anexo</td>
  </tr>
  <?
  	 $busca_lista_ree = "select * from $ta25 where t6_tarifas_reembolables_datos_id = $id_reembolsable_arr and t6_tarifas_municipios_proyectos_id = $l_ree_proy[0]";
	$sql_ree = query_db($busca_lista_ree);
	$pos=0;
	while($l_ree=traer_fila_row($sql_ree)){//lista reembola
		$n5=$l_ree[2];
  		$n6=str_replace(" ", "_", $l_ree[9]);
			     if($num_fila%2==0)
                            $class="filas_resultados";
                        else
                            $class="";
							
						?>
  <tr class="<?=$class;?>">
    <td><?=listas_sin_select($ta24,$l_ree[2],1);?></td>
    <td align="right">&nbsp;</td>
    <td align="right"><?=decimales_estilo($l_ree[5],2);?></td>
    <td align="center"><?=listas_sin_select($g5,$l_ree[6],1);?></td>
    <td><?=$l_ree[7];?></td>
    <td><?=$l_ree[8];?></td>
    <td><img src="../imagenes/mime/<?=extencion_archivos($l_ree[9]);?>.gif" width="16" height="16" onClick="window.parent.location.href='../enterproc/librerias/php/descarga_documentos_tarifas_reem.php?n1=<?=$l_ree[0];?>&n2=<?=$l_ree[9];?>&n3=<?=$id_reembolsable_arr;?>&n4=<?=$l_ree_proy[0];?>&n5=<?=$n5;?>'"/></td>
  </tr>
  <? $num_fila++; $total+= ($l_ree[5]*1); } //lista reembola ?>
</table>
<br />
<? }//lista reembola proyectos ?>
<p><br />
  <br />
</p>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_secciones"><div align="right" class="columna_subtitulo_resultados_oscuro">SUB TOTAL DEL REEMBOLSABLE:$
      <?=decimales_estilo($total,0);?>
    </div></td>
  </tr>
  <?
  if($sql_ex[8]>0){//si aplica administra
  
  ?>
  <tr>
    <td class="titulos_secciones"><div align="right"> <span class="columna_subtitulo_resultados_mas_oscuro"> + ADMINISTRACION ( % <?=$sql_ex[8];?>) $ 
      <? $valor_admin = ($total*$sql_ex[8])/100;
	  	echo decimales_estilo($valor_admin,0);
	  
	   ?>
    </span></div></td>
  </tr>
  
    <?
  }//si aplica administra
  
  ?>
  
  <tr>
    <td class="titulos_secciones"><div align="right" class="columna_subtitulo_resultados_oscuro">TOTAL DEL REEMBOLSABLE:
      <?=decimales_estandar(($total+$valor_admin),0);?>
    </div></td>
  </tr>
  <tr>
    <td class="titulos_secciones">&nbsp;</td>
  </tr>
</table>
<p><br />
</p>
<p>
  
</p>
        <p>&nbsp;</p>
        <table width="100%" border="0" cellspacing="2" cellpadding="2">
          <tr>
<? 

if($sql_ex[3]==1){ ?>
            <td><div align="center">
              <p>
                <input name="button" type="button" class="boton_email" id="button" value="Exportar reembolsable en firme  con administraci&oacute;n a PDF" onclick="window.open('../enterproc/librerias/tcpdf/examples/exporta_reembolsable.php?id_contrato=<?=$id_contrato;?>&id_reembolsable_factura=<?=$id_reembolsable_arr;?>&adm=1')" />
                
                <!--
                &nbsp;&nbsp;<input name="button2" type="button" class="boton_email" id="button2" value="Exportar reembolsable en firme sin administraci&oacute;n a PDF" onclick="window.open('../enterproc/librerias/tcpdf/examples/exporta_reembolsable.php?id_contrato=<?=$id_contrato;?>&id_reembolsable_factura=<?=$id_reembolsable_arr;?>&adm=2')" />
                <input name="button4" type="button" class="boton_email" id="button4" value="Exportar reembolsable en firme solo administraci&oacute;n a PDF" onclick="window.open('../enterproc/librerias/tcpdf/examples/exporta_reembolsable.php?id_contrato=<?=$id_contrato;?>&id_reembolsable_factura=<?=$id_reembolsable_arr;?>&adm=3')" />-->
                <input name="button2" type="button" class="boton_email" id="button2" value="Exportar reembolsable en firme a excel" onclick="exporta_reembolsable_excel_administrador()" />
              </p>
              <p>&nbsp;</p>
            </div></td>
<? } elseif($sql_ex[3]==2){ ?>           
            <? } ?>            
          </tr>
        </table>
 <input type="hidden" name="pre_edita" />
 
  <input type="hidden" name="id_contrato"  value="<?=$id_contrato;?>" />
   <input type="hidden" name="id_reembolsable_factura_or" value="<?=$id_reembolsable_factura_or;?>" />



</body>
</html>
