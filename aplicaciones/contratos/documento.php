<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');

	$id_contrato_arr = elimina_comillas(arreglo_recibe_variables($id_contrato));
	$id_documento_arr = elimina_comillas(arreglo_recibe_variables($id_documento));
	
	if($id_documento_arr==""){
		$id_documento_arr=0;
	}
	
	$busca_contacto = "select * from $co7 where id = $id_documento_arr";
	$sql_com=traer_fila_row(query_db($busca_contacto));
	
	$busca_contrato = "select * from t7_contratos_contrato where id =". $id_contrato_arr."";
		$sql_cont=traer_fila_row(query_db($busca_contrato));
		$estado_contrato = $sql_cont[27];
	
	$edita = 0;
	$disabled = "";
	
	$sel_permisos = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$_SESSION["id_us_session"]." and id_permiso=26";
	$sql_sel_permisos=traer_fila_row(query_db($sel_permisos));
	
	/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	$sel_contratos_gestiona = traer_fila_row(query_db("select * from v_relacion_gestion_abastecimiento_gerente where gestor_abastecimiento = ".$_SESSION["id_us_session"]." and usuario_gerente =".$sql_cont[9]));
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/

	
	if(($sql_sel_permisos[0]>0 or $sel_contratos_gestiona[0] >0) and $estado_contrato != 33){
		$edita = 1;
	}
	if($edita==0){
		$disabled = " disabled='disabled' ";
	}
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
    <?
echo imprime_cabeza_contrato($id_contrato)
?>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td width="71%" valign="top">
    <?
    if($edita==1){
	?>
    <table width="100%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
      <tr >
        <td colspan="3" class="fondo_4">Documentos</td>
        </tr>
      <tr>
        <td width="15%" align="center" class="fondo_3"><div align="center">Tipo Documento</div></td>
        <td width="14%" align="center" class="fondo_3">ID</td>
        <td width="19%" align="center" class="fondo_3"><div align="center">Archivo</div></td>
        </tr>
      <tr>
        <td><select name="tipo_documento" id="tipo_documento">
           <?=listas($g19, " estado = 1 ",$sql_com[2],'nombre', 1);?>
          </select></td>
        <td><input name="id_p8" type="text" id="id_p8" size="5" value="<?=$sql_com[3];?>"/></td>
        <td><input type="file" name="archivo" id="archivo" />
        
        </td>
        </tr>
      
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="left">
        <?
              if($sql_com[4] != ""){
			  ?>
                <?=saca_nombre_anexo($sql_com[4])?>
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$sql_com[4]?>&n1=<?=$sql_com[0]?>&n3=7&n4=doc" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($sql_com[4])?>.gif" width="16" height="16" />
                  </a>
                  <?
			  }
				  ?>
        </td>
      </tr>
      <tr>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td align="right"><input name="button2" type="button" class="boton_grabar" id="button2" value="Grabar Documento" onclick="graba_informacion_documento(<?=$id_documento_arr;?>)"/></td>
        </tr>
      
      </table>
      <?
	}
	  ?>
      <BR />
      
      
      
    </td>
  </tr>
  <tr>
    <td valign="top"><table width="100%" border="0" cellpadding="4" cellspacing="3" class="tabla_lista_resultados">
      <tr >
        <td colspan="4" class="fondo_4">Documentos</td>
        </tr>
      <tr>
        <td align="center" class="fondo_3"><div align="center">Tipo Documento</div></td>
        <td align="center" class="fondo_3">ID</td>
        <td align="center" class="fondo_3"><div align="center">Archivo</div></td>
        <td align="center" class="fondo_3">&nbsp;</td>
        </tr>
         <?
         $lista_poliza_int = "select * from ".$co7." t7c left join ".$g19." t1t on t7c.tipo_documento = t1t.id where  id_contrato = $id_contrato_arr and t7c.estado = 1";
		$sql_poliza_int=query_db($lista_poliza_int);
		while($lista_poliza_int=traer_fila_row($sql_poliza_int)){
		?>
      <tr>
        <td width="15%"><?=$lista_poliza_int[7];?></td>
        <td width="14%"><?=$lista_poliza_int[3];?></td>
        <td width="19%">
          <?
              if($lista_poliza_int[4] != " "){
			  ?>
                <?=saca_nombre_anexo($lista_poliza_int[4])?>
                <a href="../enterproc/librerias/php/descarga_documentos_generales.php?n2=<?=$lista_poliza_int[4]?>&n1=<?=$lista_poliza_int[0]?>&n3=7&n4=doc" target="grp">
                  <img src="../imagenes/mime/<?=saca_extencion_archivo($lista_poliza_int[4])?>.gif" width="16" height="16" />
                  </a>
                  <?
			  }
				  ?>
                  
        </td>
       <td width="9%" align="right"><span class="titulos_resumen_alertas"> <?
    if($edita==1){
	?><img src="../imagenes/botones/editar.jpg" alt="Editar" title="Editar" width="14" height="15" onclick="ajax_carga('../aplicaciones/contratos/documento.php?id_contrato=<?=arreglo_pasa_variables($id_contrato_arr);?>&id_documento=<?=arreglo_pasa_variables($lista_poliza_int[0]);?>','carga_acciones_permitidas')"/>&nbsp; <img src="../imagenes/botones/b_cancelar.gif" alt="Eliminar" title="Eliminar" width="16" height="16" onclick="elimina_documento('<?=arreglo_pasa_variables($lista_poliza_int[0]);?>')"/>&nbsp;<? }?></span></td>
        </tr>
      <?
		}
	  ?>
    </table></td>
  </tr>
</table>
<input name="id_documento" type="hidden" value="<?=$id_documento;?>" />

</body>
</html>
