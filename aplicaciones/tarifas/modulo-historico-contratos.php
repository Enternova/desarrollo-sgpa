<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');


			$_SESSION['pagina_session'] = "";
			$_SESSION['tipo_actuali_b_session'] = "";
			$_SESSION['detalle_tarifa_session'] = "";
			$_SESSION['objeto_session'] = "";
			$_SESSION['nu_contrato_session'] = "";
			$_SESSION['proveedor_session'] = "";
			$_SESSION['roll_gerente_session'] = "";
			$_SESSION['vigencia_contrato_session'] = "";
			$_SESSION['codigo_tarifa_session'] = "";
			$_SESSION['busca_estado_aprobacion_session'] = "";
			
			
			$_SESSION['pagina_session'] = $_GET['pagina'];
			$_SESSION['tipo_actuali_b_session'] = $_GET['tipo_actuali_b'];
			$_SESSION['detalle_tarifa_session'] = $_GET['detalle_tarifa'];
			$_SESSION['objeto_session'] = $_GET['objeto'];
			$_SESSION['nu_contrato_session'] = $_GET['nu_contrato'];
			$_SESSION['proveedor_session'] = $_GET['proveedor'];
			$_SESSION['roll_gerente_session'] = $_GET['roll_gerente'];
			$_SESSION['vigencia_contrato_session'] = $_GET['vigencia_contrato'];
			$_SESSION['codigo_tarifa_session'] = $_GET['codigo_tarifa'];
			$_SESSION['busca_estado_aprobacion_session'] = $_GET['busca_estado_aprobacion'];
			$_SESSION['especialista_bu'] = $_GET['especialista_bu'];
?>

<?
	/*$trae_id_insrte = " select SCOPE_IDENTITY() AS [SCOPE_IDENTITY]"; // para optener elid del insert into SQL SERVER
					
					$sel_presu_1 = query_db("select creacion_sistema, consecutivo, apellido, contratista, objeto ,monto_usd, monto_cop from $co1 ");
					while($sel_presu=traer_fila_row($sel_presu_1)){//recoo					
					$numero_contrato1 = "C";// los campos de la tabla t7_contratos_contrato			
					$separa_fecha_crea = explode("-",$sel_presu[0]);//fecha_creacion
					$ano_contra = $separa_fecha_crea[0];					
					$numero_contrato2 = substr($ano_contra,2,2);
					$numero_contrato3 = $sel_presu[1];//consecutivo
					$numero_contrato4 = $sel_presu[2];//apellido
					$numero_contrato_final = numero_item_pecc_contrato($numero_contrato1,$numero_contrato2,$numero_contrato3, $numero_contrato4);	
					
					if($sel_presu[5]>=1){
						$tipo_moneda = 2;
						$valor=$sel_presu[5];
						}
					else
						{
						$tipo_moneda = 1;
						$valor=$sel_presu[6];
						}

					$busca_tarifas = "insert into t6_tarifas_contratos (t1_moneda_id, t1_proveedor_id, consecutivo,valor, objeto_contarto)
					values ($tipo_moneda,$sel_presu[3],'$numero_contrato_final',$valor,'$sel_presu[4]')  ";
					
					$sql_ex=query_db($busca_tarifas.$trae_id_insrte);
			
					$id_ingreso = id_insert($sql_ex);
					
					$insert_compl =query_db("insert into t6_tarifas_complemento_contrato (tarifas_contrato_id, t6_tarifas_estados_contratos_id) values ($id_ingreso , 1)");
					
					} ////recoo
					
					*/
	
/*ERREGLO PAGINADOR*/
	
	
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
	$complet_2 = " and id_contrato in (".$contratos_por_usario.")";
	}
	
	/*SACA LOS CONTRATOS QUE GESTIONA EL ROL GESTION DE ABASTECIMIENTO SEGUN EL AREA*/
	
	
if($nu_contrato!=""){
	
	$id_numero_contrato = str_replace("-", "", $nu_contrato );
	$id_numero_contrato = str_replace(" ", "", $id_numero_contrato);
	
	$complemento =	" and replace(consecutivo,'-','') like '%$id_numero_contrato%'";
	
			
	
}
	
	
if($proveedor!="")
	$complemento.=	" and razon_social like '%$proveedor%'";
if($objeto!="")
	$complemento.=	" and objeto_contarto like '%$objeto%'";		
	
if($especialista_bu!=""){
		$id_especialista = $especialista_bu;
		$complemento = $complemento." and especialista = ".$id_especialista;
	}

if($busca_estado_aprobacion>=1)
	{
	
  $busca_detalle = "	select distinct tarifas_contrato_id from $v_t_3 where creada_luego_firme =2 and t6_tarifas_estados_tarifas_id not in (8,9) and t6_tarifas_estados_tarifas_id = $busca_estado_aprobacion	";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//todas las tarifas	
		
			$busca_contratos_ta.=",".$lista_detalle[0];
		
		}//todas las tarifas	
	
		$complemento.= " and tarifas_contrato_id in (0 $busca_contratos_ta) ";
	}

if($tipo_actuali_b>=1)
	{
	
  $busca_detalle = "	select distinct tarifas_contrato_id from $v_t_3 where creada_luego_firme =2 and t6_tarifas_estados_tarifas_id not in (8,9) and tipo_creacion_modifica = $tipo_actuali_b	";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//todas las tarifas	
		
			$busca_contratos_ta.=",".$lista_detalle[0];
		
		}//todas las tarifas	
	
		$complemento.= " and tarifas_contrato_id in (0 $busca_contratos_ta) ";
	}


if($codigo_tarifa!="")
	{
	
  $busca_detalle = "	select distinct tarifas_contrato_id from $v_t_3 where codigo_proveedor like '%$codigo_tarifa%' and t6_tarifas_estados_tarifas_id not in (8,9) ";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//todas las tarifas	
		
			$busca_contratos_ta.=",".$lista_detalle[0];
		
		}//todas las tarifas	
	
		$complemento.= " and tarifas_contrato_id in (0 $busca_contratos_ta) ";
	}


if($detalle_tarifa!="")
	{
	
  $busca_detalle = "	select distinct tarifas_contrato_id from $v_t_3 where detalle like '%$detalle_tarifa%'  and t6_tarifas_estados_tarifas_id not in (8,9) 	";
		$sql_detalle=query_db($busca_detalle);
		while($lista_detalle=traer_fila_row($sql_detalle)){//todas las tarifas	
		
			$busca_contratos_ta.=",".$lista_detalle[0];
		
		}//todas las tarifas	
	
		$complemento.= " and tarifas_contrato_id in (0 $busca_contratos_ta) ";
	}
	
if($roll_gerente>=1)
	$complemento.=	" and gerente = $roll_gerente";		
	
if($vigencia_contrato==1)
	$complemento.=	"   and vigencia_mes >= '$fecha' ";		

if($vigencia_contrato==2)
	$complemento.=	" and vigencia_mes <= '$fecha' ";	
	
if($vigencia_contrato==4)
	$complemento.=	" and estado_contrato = 2 and vigencia_mes >= '$fecha'";
if($vigencia_contrato==5)
	$complemento.=	" and estado_contrato = 1 and vigencia_mes >= '$fecha'";

if($vigencia_contrato==3)
	$complemento.=	" and estado_contrato = 6";		
if($vigencia_contrato==6)
	$complemento.=	" and estado_contrato = 6 and vigencia_mes >= '$fecha'";	
if($vigencia_contrato==7)
	$complemento.=	" and estado_contrato = 6 and vigencia_mes < '$fecha'";		


if($vigencia_contrato==8)
	$complemento.=	" and estado_contrato = 6 and vigencia_mes >= '$fecha' 
	and (select count(*) from  t6_tarifas_lista as h where h.tarifas_contrato_id  = d.tarifas_contrato_id) >= 1";	

if($vigencia_contrato==9)
	$complemento.=	" and estado_contrato = 6 and vigencia_mes >= '$fecha' 
	and (select count(*) from  t6_tarifas_lista as h where h.tarifas_contrato_id  = d.tarifas_contrato_id) =0";	

if($vigencia_contrato==10)
	$complemento.=	" and estado_contrato = 6 and  vigencia_mes < '$fecha' 
	and (select count(*) from  t6_tarifas_lista as h where h.tarifas_contrato_id  = d.tarifas_contrato_id) >= 1";	

if($vigencia_contrato==11)
	$complemento.=	" and estado_contrato = 6 and vigencia_mes < '$fecha'
	and (select count(*) from  t6_tarifas_lista as h where h.tarifas_contrato_id  = d.tarifas_contrato_id) =0";	
	
	
	
	$factor_b_c = 50;
	$factor_b = 50;
	if($pagina<=1){//si no tiene pagina seleccionada
		$inicio = 0;
		
		}
	else{
		
		 $inicio= (($pagina-1)*$factor_b);
		$factor_b =( $factor_b * ($pagina-1)) + $factor_b;
		}

 	 $sql_cuenta2 = "select  count(*) from $v_t_1 as d where estado_contrato not in (4) and estado_contrato_general not in (50)  $complemento $complet_2 ";
	 $sql_cuenta=traer_fila_row(query_db($sql_cuenta2));
	 $lista_pagina = ceil( ( $sql_cuenta[0] / $factor_b_c ) );
	
/*ERREGLO PAGINADOR*/	
	
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
    <td class="titulos_secciones">SECCION: HISTORICO DE CONTRATOS</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="3" valign="top">
      <table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
        <tr>
          <td colspan="4" class="fondo_2">Buscador de contratos</td>
        </tr>
        <tr>
          <td width="23%" ><p align="right"><strong>Por contrato:</strong></p>          </td>
          <td width="31%" >
            <input type="text" name="nu_contrato" id="nu_contrato" value="<?=$nu_contrato;?>" />          </td>
          <td width="22%" ><div align="right"><strong>Por proveedor/contratista</strong></div></td>
          <td width="24%"><input type="text" name="proveedor" id="proveedor" value="<?=$proveedor;?>"/></td>
        </tr>
        <tr>
          <td ><div align="right"><strong>Por Profesional de C&amp;C:</strong></div></td>
          <td >
                       
            <select name="especialista_bu" id="especialista_bu">
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
            <option value="<?=$se_prof[0]?>" <? if( $especialista_bu ==$se_prof[0]) echo 'selected="selected"'?>  ><?=$se_prof[1]?></option>
            <?
		  }
		  ?>
            </select>
            
            </td>
          <td >&nbsp;</td>
          <td>&nbsp;</td>
        </tr>
        <tr>
          <td><div align="right"><strong>Por gerente del contrato:</strong></div></td>
          <td ><select name="roll_gerente" id="roll_gerente">
            <?=listas("v_relacion_roles_usuarios_tarifas", " id_rol = 5 ",$roll_gerente,'nombre_administrador', 5);?>
          </select></td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
        <tr>
          <td ><div align="right"><strong>Por Estado del Contrato</strong></div></td>
          <td ><select name="vigencia_contrato" id="vigencia_contrato">
            <option value="0">Seleccione</option>
            <option value="1" <? if($vigencia_contrato==1) echo "selected";   ?>>Contratos Vigentes en Firme</option>
            <option value="2" <? if($vigencia_contrato==2) echo "selected";   ?>>Contratos Finalizado</option>
            <option value="4" <? if($vigencia_contrato==4) echo "selected";   ?>>Contratos Vigentes en Parcial</option>
            <option value="5" <? if($vigencia_contrato==5) echo "selected";   ?>>Contratos Vigentes Sin Tarifas</option>
            <option value="3" <? if($vigencia_contrato==3) echo "selected";   ?>>Todas las Excepciones</option>
            <option value="6" <? if($vigencia_contrato==6) echo "selected";   ?>>Excepciones Vigentes</option>
            <option value="7" <? if($vigencia_contrato==7) echo "selected";   ?>>Excepciones Vencidas y Finalizadas</option>

            <option value="8" <? if($vigencia_contrato==8) echo "selected";   ?>>Excepciones Vigentes con tarifas</option>            
            <option value="9" <? if($vigencia_contrato==9) echo "selected";   ?>>Excepciones Vigentes sin tarifas</option>            
            <option value="10" <? if($vigencia_contrato==10) echo "selected";   ?>>Excepciones Vencidas y Finalizadas con tarifas</option>            
            <option value="11" <? if($vigencia_contrato==11) echo "selected";   ?>>Excepciones Vencidas y Finalizadas sin tarifas</option>            

          </select>          </td>
          <td >&nbsp;</td>
          <td >&nbsp;</td>
        </tr>
        <tr>
          <td><div align="right"><strong>Por objeto del contrato:</strong></div></td>
          <td colspan="3" >
            <div align="left"><input type="text" name="objeto" id="objeto" value="<?=$objeto;?>"/></div></td>
        </tr>
    </table>      </td>
  </tr>
  <tr>
    <td width="29%" valign="top">&nbsp;</td>
    <td width="29%" valign="top" >
      <input name="button" type="button" class="boton_buscar" id="button" value="Realizar busqueda de contratos" onclick="javascript:busqueda_paginador_nuevo(1,'../aplicaciones/tarifas/modulo-historico-contratos.php','contenidos')" />
    </td>
    <td width="29%" valign="top" id="carga_acciones_permitidas2">&nbsp;</td>
  </tr>
</table>
<br />
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td colspan="4" class="columna_titulo_resultados">Contratos encontrados: <?=number_format($sql_cuenta[0],0);?></td>
  </tr>
  <tr>
    <td width="1%" class="columna_subtitulo_resultados"><div align="center"></div></td>
    <td width="9%" class="columna_subtitulo_resultados"><div align="center">Contrato</div></td>
    <td width="34%" class="columna_subtitulo_resultados"><div align="center">Objeto</div></td>
    <td width="33%" class="columna_subtitulo_resultados"><div align="center">Proveedor</div></td>

  </tr>
  
<?

 $busca_item = "select * from (
select consecutivo,objeto_contarto,nombre,valor,tarifas_contrato_id,razon_social,monto_usd, monto_cop, ROW_NUMBER() OVER(ORDER BY id_contrato desc) AS rownum, id_contrato from $v_t_1 as d  where estado_contrato not in (4) and estado_contrato_general not in (50)  $complemento $complet_2   ) as sub
where rownum > $inicio and rownum <= $factor_b ";	

	$sql_ex = query_db($busca_item);
	while($ls_mr=traer_fila_row($sql_ex)){



	
		
?>  
  
  <tr class="filas_resultados">
    <td class="filas_resultados"><img src="../imagenes/botones/alerta.png" alt="Ingresar al contrato" title="Ingresar al contrato" width="16" height="16" onclick="taer_menu('../aplicaciones/tarifas/menu_admin_contratos.php?id_contrato=<?=arreglo_pasa_variables($ls_mr[4]);?>','contenido_menu');ajax_carga('../aplicaciones/tarifas/h_tarifasff.php?id_contrato=<?=$ls_mr[4];?>','carga_acciones_permitidas_inicio')"/></td>
    <td class="filas_resultados"><?=numero_cotnrato_tarifas($ls_mr[4]);?></td>
    <td class="filas_resultados"><?=$ls_mr[1];?></td>
    <td><div align="center"><?=$ls_mr[5];?></div></td>

  </tr>
  
  <? } ?>
  
  <tr>
    <td colspan="4" class="columna_titulo_resultados"><table width="100%" border="0" cellspacing="2" cellpadding="2" class="tabla_paginador">
      <tr>
        <td width="78%"><div align="left"></div></td>
        <td width="7%"><div align="center">P&aacute;gina</div></td>
        <td width="8%">
          <select name="pagina" onchange="javascript:busqueda_paginador_nuevo(this.value,'../aplicaciones/tarifas/modulo-historico-contratos.php','contenidos')">
            <? 
		  for($i=1;$i<=$lista_pagina;$i++){
		   ?>
            <option value="<?=$i;?>"  <? if($i==$pagina) echo "selected"; ?>>Pagina
              <?=$i;?>
              </option>
            <? } ?>
            </select>
          </td>
        <td width="7%">&nbsp;</td>
        </tr>
    </table></td>
  </tr>
</table>
<p>&nbsp;</p>
 <table width="100%" border="0">
		     <tr>
		       <td align="center"><input name="button3" type="button" class="boton_buscar" id="button3" value="Exportar resultado a excel"  onclick="javascript:exporta_hisotrico_contratos()" /></td>
	         </tr>
</table>
</body>
</html>
