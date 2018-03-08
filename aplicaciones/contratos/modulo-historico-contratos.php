<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	
	
	$_SESSION["comple_busqueda"] = $_GET["paginas"];
	// INicio Permisos para visualizar un contrato
  	//$permisos = valida_visualiza_contrato($_SESSION["id_us_session"]);
	// INicio Permisos para visualizar un contrato
	
	if($analista_deloitte==""){
		$analista_deloitte = 3;
	}else{
		$analista_deloitte = $analista_deloitte;
	}

	if($_GET["paginas"] > 0){
		$pagina = $_GET["paginas"];
		}else{
			$pagina = 1;
			}
		$registros_pagina=50;		
		$regis_final = $pagina * $registros_pagina;		
		$regis_inicial = ($pagina - 1) * $registros_pagina;
		
	$query_comple = "";
	if($contratista_bu!=""){
		$explode = explode("----,",$contratista_bu);
		$id_contratista = $explode[1];
		$query_comple = $query_comple." and contratista = ".$id_contratista;
	}
	
	if($especialista_bu2!=""){
		$id_especialista = $especialista_bu2;
		$query_comple = $query_comple." and especialista = ".$id_especialista;
	}
	
	if($objeto_bu!=""){
		$query_comple = $query_comple." and objeto like '%".$objeto_bu."%'";
	}
	
	if($tipo_contrato_bu!="0" and $tipo_contrato_bu!=""){
		if($tipo_contrato_bu==3){
			$query_comple = $query_comple." and t1_tipo_documento_id =1 and oferta_mercantil = 1";
			}else{
		$query_comple = $query_comple." and t1_tipo_documento_id =".$tipo_contrato_bu."";
			}
	}
	
	if($aplica_portales_bu!="0" and $aplica_portales_bu!=""){
		$query_comple = $query_comple." and aplica_garantia =".$aplica_portales_bu."";
	}
	
	if($destino_bu!="0" and $destino_bu!=""){
		$query_comple = $query_comple." and aseguramiento_admin =".$destino_bu."";
	}
	
	if($info_hse!="0" and $info_hse!=""){
		$query_comple = $query_comple." and informe_hse ='".$info_hse."'";
	}
	
	if($gestor_abste!="0" and $gestor_abste!=""){
		
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/

$sel_contratos_gestiona = query_db("select usuario_gerente from v_relacion_gestion_abastecimiento_gerente where gestor_abastecimiento = ".$gestor_abste);
$aplica_gerentes = "0";
while($aplica_gere = traer_fila_db($sel_contratos_gestiona)){
	$aplica_gerentes.=",".$aplica_gere[0];
	}
/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	$query_comple = $query_comple." and gerente in (".$aplica_gerentes.")";
	}
	
	
	
	if($analista_deloitte!=3){
		if($analista_deloitte==1){
			$query_comple = $query_comple." and analista_deloitte =1";
		}else{
			$query_comple = $query_comple." and (analista_deloitte =0 or analista_deloitte is null)";
		}
	}
	
	
	if($gerente_bu!=""){
		$explode = explode("----,",elimina_comillas_2($gerente_bu));
		$id_gerente = $explode[1];
		$query_comple = $query_comple." and gerente = ".$id_gerente;
	}
	
	if($estado_bu!="0" and $estado_bu!=""){
		if($estado_bu==$est_firma_hocol or $estado_bu==$est_firma_contratista){
			if($estado_bu==$est_firma_hocol){
				$query_comple = $query_comple." and (estado in (".$est_firma_hocol.") and sel_representante = 2 or estado in (".$est_firma_contratista.") and sel_representante = 1)";
			}
			if($estado_bu==$est_firma_contratista){
				$query_comple = $query_comple." and (estado in (".$est_firma_hocol.") and sel_representante = 1 or estado in (".$est_firma_contratista.") and sel_representante = 2)";
			}
			
			
		}else{
			if($estado_bu==101){
				$query_comple = $query_comple." and estado in (".$est_abastecimiento.",".$est_sap.",".$est_revision.",".$est_firma_hocol.",".$est_firma_contratista.",".$est_poliza.",".$est_gerente_contrato.",".$est_legalizacion.")";
			}else{
				$query_comple = $query_comple." and estado = ".$estado_bu;	
			}
		}
		
	}else{
		$query_comple = $query_comple." and estado not in (50)";
		}
	


/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA
	$contratos_por_usario="0";

		
	$sel_per = "select id_relacion,id_usuario,id_permiso from $ts5 where id_usuario=".$_SESSION["id_us_session"]." and id_permiso=44";
	$sql_sel_per=traer_fila_row(query_db($sel_per));
	if($sql_sel_per[0]>0){//si es el rol gestion de abastecimiento
	
	$sel_contratos_gestiona = query_db("select * from v_relacion_gestion_abastecimiento_contrato where id_usuario = ".$_SESSION["id_us_session"]);
	while($sel_con = traer_fila_db($sel_contratos_gestiona)){
		if($sel_con[3]== 1 or $sel_con[3]== 44){
				if($_SESSION["id_us_session"] == 20296){
				$contratos_por_usario.= ",".$sel_con[0];
				}
			}else{
				$contratos_por_usario.= ",".$sel_con[0];		
			}
		}
		
	$complet = " and id in (".$contratos_por_usario.")";
	}
	
	/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
		
			
	$query_comple_temp="";
	if($contrato_bu!=""){
		$contrato_bu2 = str_replace("-","",$contrato_bu);
		$contrato_bu2 = str_replace(" ","",$contrato_bu2);
		
		$query_comple_temp = $query_comple_temp." and (consecutivo like '%".$contrato_bu2."%')";
		
		$query_create = "CREATE TABLE #t7_contratos_contrato_temp (id int, consecutivo varchar(50))";
		$sql_contrato=query_db($query_create);
		
		
		
		
		
		$lista_contrato = "select * from $co1 where estado >= 1".$query_comple.$permisos." ".$complet;
		
		$sql_contrato=query_db($lista_contrato);
		while($rs_array=traer_fila_row($sql_contrato)){
			$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
			$separa_fecha_crea = explode("-",$rs_array[19]);//fecha_creacion
			$ano_contra = $separa_fecha_crea[0];					
			$numero_contrato2 = substr($ano_contra,2,2);
			$numero_contrato3 = $rs_array[2];//consecutivo
			$numero_contrato4 = $rs_array[43];//apellido
			$numero_contrato_fin = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $rs_array[0]);
			$numero_contrato_fin = str_replace("-","",$numero_contrato_fin);
			$numero_contrato_fin = str_replace(" ","",$numero_contrato_fin);
			
			//echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
			$query_create_int = "insert into #t7_contratos_contrato_temp values (".$rs_array[0].",'".$numero_contrato_fin."')";
			$sql_contrato_int=query_db($query_create_int);
		}
		
		$lista_contrato_temp = "select * from #t7_contratos_contrato_temp where id > 0 ".$query_comple_temp;
		$sql_contrato_temp=query_db($lista_contrato_temp);
		
		$array_id_bu = "0";
		while($rs_array_temp=traer_fila_row($sql_contrato_temp)){
			$array_id_bu =  $array_id_bu.",".$rs_array_temp[0];
		}
		
		$query_comple = $query_comple." and id in (".$array_id_bu.")";
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

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr class="titulos_secciones">
    <td class="titulos_secciones">SECCION: BUSCADOR DE CONTRATOS</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td valign="top">
      <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="4" class="fondo_2">Buscador de Contratos</td>
        </tr>
        <tr>
          <td width="21%" ><p align="right"><strong>Por Consecutivo Contrato:</strong></p>          </td>
          <td width="15%" ><label>
          <? $_SESSION['contrato_buh'] = $contrato_bu?>
            <input type="text" name="contrato_bu" id="contrato_bu" value="<?=$contrato_bu;?>"/>
          </label></td>
          <td width="16%" ><div align="right"><strong>Por Proveedor/Contratista</strong></div></td>
          <td width="48%" >
          <? $_SESSION['contratista_buh'] = $contratista_bu?>          
          <input type="text" name="proveedores_busca" id="proveedores_busca" value="<?=$contratista_bu;?>" onkeypress="selecciona_lista()"/></td>
        </tr>
        <tr>
          <td ><div align="right"><strong>Por Profesional de C&amp;C:</strong></div></td>
          <td >
          <? $_SESSION['especialista_bu2h'] = $especialista_bu2?>  
                   
          <select name="especialista_bu2" id="especialista_bu2">
            <option value="">Seleccione el Profesional de C&C Designado</option>
            <?
			
			$sel_profesionales = query_db("select DISTINCT(especialista) from  t7_contratos_contrato where especialista is not null and especialista <> 0");
			$profe_aplica=0;
			while($s_prof_sol = traer_fila_db($sel_profesionales)){
				$profe_aplica.=",".$s_prof_sol[0]; 
				}
			
          $sel_profss = query_db("select us_id, nombre_administrador from t1_us_usuarios where us_id in (".$profe_aplica.") order by nombre_administrador");
		  
		  
		  while($se_prof =traer_fila_db($sel_profss)){
		  ?>
            <option value="<?=$se_prof[0]?>" <? if( $especialista_bu2 ==$se_prof[0]) echo 'selected="selected"'?>  ><?=$se_prof[1]?></option>
            <?
		  }
		  ?>
            </select>
          
          </td>
          <td ><div align="right"><strong>Por Objeto:</strong></div></td>
          <td >
          <? $_SESSION['objeto_buh'] = $objeto_bu?>
          <input type="text" name="objeto_bu" id="objeto_bu" value="<?=$objeto_bu;?>"/></td>
        </tr>
        <tr>
          <td align="right" ><strong>Gestor de Abastecimiento:</strong></td>
          <td > <select name="gestor_abste" id="gestor_abste" >
              <option value="0">Seleccione</option>
              
              <?
			  $sel_usuarios_gestores = query_db("select t1.us_id, t1.nombre_administrador from t1_us_usuarios t1, tseg12_relacion_usuario_rol t2 where t1.us_id = t2.id_usuario and t2.id_rol_general = 21 and t1.estado = 1");
			  while($sel_us_g = traer_fila_db($sel_usuarios_gestores)){
              ?>
              <option value="<?=$sel_us_g[0]?>" <? if($sel_us_g[0]==$gestor_abste){ echo "selected='selected'";} ?>><?=$sel_us_g[1]?></option>
              <?
			  }
			  ?>
              </select></td>
          <td align="right" ><strong>Por Estado:</strong></td>
          <td ><? $_SESSION['estado_buh'] = $estado_bu?>
            <select name="estado_bu" id="estado_bu" >
              <option value="0">Seleccione</option>
              <option value="1" <? if($estado_bu==1){ echo "selected='selected'";} ?> >Elaboraci&oacute;n de Contrato</option>
              <option value="15" <? if($estado_bu==15){ echo "selected='selected'";} ?> >En Legalizaci&oacute;n</option>
              <option value="25" <? if($estado_bu==25){ echo "selected='selected'";} ?>>Legalizado Pendiente Aseguramiento</option>
              <option value="48" <? if($estado_bu==48){ echo "selected='selected'";} ?>>Legalizado</option>
              <option value="49" <? if($estado_bu==49){ echo "selected='selected'";} ?>>Finalizado</option>
              <option value="50" <? if($estado_bu==50){ echo "selected='selected'";} ?>>Eliminado</option>
            </select></td>
        </tr>
        <tr>
          <td ><div align="right"><strong>Por Gerente:</strong></div></td>
          <td >
                    <? $_SESSION['gerente_buh'] = $gerente_bu?>
          <input name="usuario_permiso" type="text" id="usuario_permiso" size="5" value="<?=$gerente_bu;?>" onkeypress="selecciona_lista()"/></td>
          <td align="right" ><strong>Congelado:</strong></td>
          <td ><? $_SESSION['analista_deloitteh'] = $analista_deloitte?>
            <select name="analista_deloitte" id="analista_deloitte">
              <option value="" <? if($analista_deloitte==3){echo "selected='selected'";}?> >Seleccione</option>
              <option value="1" <? if($analista_deloitte==1){echo "selected='selected'";}?> >SI</option>
              <option value="0" <? if($analista_deloitte!=1 && $analista_deloitte!=3){echo "selected='selected'";}?> >NO</option>
            </select></td>
        </tr>
        <tr>
          <td align="right" ><strong>Por Tipo Contrato:</strong></td>
          
          <td ><? $_SESSION['tipo_contrato_buh'] = $tipo_contrato_bu?>          
          <select name="tipo_contrato_bu" id="tipo_contrato_bu" >
            <option value="0">Seleccione</option>
            <option value="1" <? if($tipo_contrato_bu==1){ echo "selected='selected'";} ?> >Contrato Puntual</option>
            <option value="2" <? if($tipo_contrato_bu==2){ echo "selected='selected'";} ?> >Contrato Marco</option>
            <option value="3" <? if($tipo_contrato_bu==3){ echo "selected='selected'";} ?> >Oferta Mercantil</option>
          </select></td>
          <td align="right" ><strong>Informe HSE:</strong></td>
          <td ><select name="info_hse" id="info_hse">
                <option value="0">Seleccione</option>
                <option value="SI" <? if($info_hse == "SI") echo 'selected="selected"';?> >SI</option>
                <option value="NO" <? if($info_hse == "NO") echo 'selected="selected"';?>>NO</option>
                 </select></td>
        </tr>
        <tr>
          <td align="right" ><strong>Aplica Retenci&oacute;n en Garant&iacute;a</strong>:</td>
          <td >
          <? $_SESSION['aplica_portales_buh'] = $aplica_portales_bu?> 
          <select name="aplica_portales_bu" id="aplica_portales_bu">
            <option value="0" <? if($aplica_portales_bu==0){echo "selected='selected'";}?> >Seleccione</option>
            <option value="1" <? if($aplica_portales_bu==1){echo "selected='selected'";}?> >SI</option>
            <option value="2" <? if($aplica_portales_bu==2){echo "selected='selected'";}?> >NO</option>
          </select></td>
          <td align="right" ><strong>Aseguramiento Administrativo</strong>:</td>
          <td >
          <? $_SESSION['destino_buh'] = $destino_bu?>           
          <select name="destino_bu" id="destino_bu">
             <?=listas("t1_tipo_aseguramiento_admin", " estado = 1 ",$destino_bu,'nombre', 1);?>
          </select></td>
        </tr>
    </table>      </td>
  </tr>
  <tr>
    <td align="center" valign="top" id="carga_acciones_permitidas2"><label>
      <input name="button" type="button" class="boton_grabar" id="button" value="Realizar B&uacute;squeda de Contratos" onclick="ajax_carga('../aplicaciones/contratos/modulo-historico-contratos.php?paginas='+this.value+'&      contrato_bu='+document.principal.contrato_bu.value+'&     contratista_bu='+document.principal.proveedores_busca.value+'&     especialista_bu2='+document.principal.especialista_bu2.value+'&     objeto_bu='+document.principal.objeto_bu.value+'&     gerente_bu='+document.principal.usuario_permiso.value+'&     estado_bu='+document.principal.estado_bu.value+'&tipo_contrato_bu='+document.principal.tipo_contrato_bu.value+'&analista_deloitte='+document.principal.analista_deloitte.value+'&aplica_portales_bu='+document.principal.aplica_portales_bu.value+'&destino_bu='+document.principal.destino_bu.value+'&info_hse='+document.principal.info_hse.value+'&gestor_abste='+document.principal.gestor_abste.value,'contenidos')"/>
    </label></td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
<tr>
	<td colspan="6" align="right">
    	<A href="javascript:document.location.target='_blank';document.location.href='../aplicaciones/contratos/reporte-historico-contratos.php?query_comple=<?= $query_comple?>&permisos=<?= $permisos?>&complet=<?= $complet?>'">Generar Reporte en EXCEL <img src="../imagenes/mime/xlsx.gif"  /></A>
    </td>
</tr>
  <tr>
    <td colspan="6" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="86%" align="right"><strong>
          <?
      $cuantos_registros = traer_fila_row(query_db("select count(*) from $co1 where estado >= 1 ".$query_comple.$permisos.$complet));
	  $cunatas_paginas = ($cuantos_registros[0] / $registros_pagina) +1;
	  
	  ?>
          Paginas:</strong></td>
        <td width="6%"><select name="paginas" id="paginas" onchange="ajax_carga('../aplicaciones/contratos/modulo-historico-contratos.php?paginas='+this.value+'&      contrato_bu='+document.principal.contrato_bu.value+'&     contratista_bu='+document.principal.proveedores_busca.value+'&     especialista_bu2='+document.principal.especialista_bu2.value+'&     objeto_bu='+document.principal.objeto_bu.value+'&     gerente_bu='+document.principal.usuario_permiso.value+'&     estado_bu='+document.principal.estado_bu.value,'contenidos')">
        <?
      	for($i = 1; $i <= $cunatas_paginas ; $i++){
	  ?>
        <option value="<?=$i?>" <? if($pagina == $i) echo 'selected="selected"';?> >
          <?=$i?>
          </option>
        <? }?>
      </select></td>
        <td width="8%">de <?=intval($cunatas_paginas)?></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td width="3%" height="29" class="columna_subtitulo_resultados">&nbsp;</td>
    <td width="8%" class="columna_subtitulo_resultados"><div align="center">Contrato</div></td>
    <td width="9%" class="columna_subtitulo_resultados"><div align="center">Estado</div></td>
    <td width="43%" class="columna_subtitulo_resultados"><div align="center">Descripci&oacute;n</div></td>
    <td width="25%" class="columna_subtitulo_resultados"><div align="center">Proveedor / Contratista</div></td>
    <td width="12%" class="columna_subtitulo_resultados"><div align="center">Fecha Creaci&oacute;n</div></td>
  </tr>
  <?
	
	  

	 $lista_contrato = "select * from (select ROW_NUMBER()Over(Order by id desc) As RowNum, * from $co1 where estado >= 1".$query_comple.$permisos.$complet.") as resultado_paginado WHERE RowNum BETWEEN $regis_inicial AND $regis_final";

	$sql_contrato=query_db($lista_contrato);
	while($lista_contrato=traer_fila_row($sql_contrato)){
	
		$sel_pro = "select * from ".$g6." where t1_proveedor_id=".$lista_contrato[6];
		$sel_pro_q=traer_fila_row(query_db($sel_pro));
		
		$ob_elim = "";
	if($lista_contrato[28] == 50){
		$busca_contrato = "select top(1) * from t7_acciones_admin where id_contrato = ".$lista_contrato[1]." and detalle = '1. Eliminar contrato' order by id desc";
		$sql_con=traer_fila_db(query_db($busca_contrato));
		$ob_elim = " - ".$sql_con['observacion'];
		}

		
	?>
  <tr class="filas_resultados">
    <td ><a href="javascript:taer_menu('../aplicaciones/contratos/menu_contrato.php?id=<?=arreglo_pasa_variables($lista_contrato[1]);?>','contenido_menu')"><img src="../imagenes/botones/alerta.png" alt="Proceso pendiente, sin resolver o sin leer" width="16" height="16" /></a></td>
    <td>
    <?
    	$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
		$separa_fecha_crea = explode("-",$lista_contrato[20]);//fecha_creacion
		$ano_contra = $separa_fecha_crea[0];					
		$numero_contrato2 = substr($ano_contra,2,2);
		$numero_contrato3 = $lista_contrato[3];//consecutivo
		$numero_contrato4 = $lista_contrato[44];//apellido
		//echo $numero_contrato1." ".$numero_contrato2." ".$numero_contrato3." ".$numero_contrato4;
		$id_contrato_ajus = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4, $lista_contrato[1]);
		echo $id_contrato_ajus;
		
	?>
    </td>
    <td ><?=saca_nombre_lista("t7_contratos_estado",$lista_contrato[28],'nombre','id');?> <?=$ob_elim?></td>
    <td><?=$lista_contrato[4];?></td>
    <td><?=$sel_pro_q[3];?></td>
    <td><?=$lista_contrato[20];?></td>
  </tr>
  <?
	}
	?>
  <tr>
    <td colspan="6" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="86%" align="right"><strong>
        
          Paginas:</strong></td>
        <td width="6%"><select name="paginas2" id="paginas2" onchange="ajax_carga('../aplicaciones/contratos/modulo-historico-contratos.php?paginas='+this.value+'&      contrato_bu='+document.principal.contrato_bu.value+'&     contratista_bu='+document.principal.proveedores_busca.value+'&     especialista_bu2='+document.principal.especialista_bu2.value+'&     objeto_bu='+document.principal.objeto_bu.value+'&     gerente_bu='+document.principal.usuario_permiso.value+'&     estado_bu='+document.principal.estado_bu.value,'contenidos')">
          <?
      	for($i = 1; $i <= $cunatas_paginas ; $i++){
	  ?>
          <option value="<?=$i?>" <? if($pagina == $i) echo 'selected="selected"';?> >
            <?=$i?>
            </option>
          <? }?>
        </select></td>
        <td width="8%">de
          <?=intval($cunatas_paginas)?></td>
      </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p>&nbsp;</p>
<p><br />
  <br />
</p>
</body>
</html>
