<? include("../../librerias/lib/@session.php"); 
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	global $host_mys,$usr_mys, $pwd_mys, $dbbase_mys;
	$link = mysql_connect($host_mys,$usr_mys, $pwd_mys);
	mysql_select_db($dbbase_mys, $link);
	$comple_mysql="";
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />

<body>


  <br />
  <br />
  <br />
  <br />
  <br />
  <br />
  <table width="100%" border="0" align="center" cellpadding="2" cellspacing="2" bgcolor="#FFFFFF">
<tr>
  <td width="93%" align="center">&nbsp;</td>
  <td width="7%" align="right"><input type="button" value="Cerrar" class="boton_grabar_cancelar windowPopupClose" onclick='window.parent.document.getElementById("div_carga_busca_sol").style.display="none"' /></td>
</tr>
<tr>
  <td colspan="2" align="center">&nbsp;</td>
</tr>
<tr>
  <td colspan="2" align="center"><table width="100%" border="1">


 <tr>
      <td width="3%" align="center" class="columna_subtitulo_resultados">N&uacute;mero</td>
      <td width="3%" align="center" class="columna_subtitulo_resultados">Es Carga Masiva</td>
      <td width="3%" align="center" class="columna_subtitulo_resultados">Origen PECC</td>
      <td width="4%" align="center" class="columna_subtitulo_resultados">Fecha para Cuando se Requiere</td>
      <td width="3%" align="center" class="columna_subtitulo_resultados">Tipo de Proceso</td>
      <td width="6%" align="center" class="columna_subtitulo_resultados">Profesional de Abastecimiento</td>
      <td width="4%" align="center" class="columna_subtitulo_resultados">Fecha de Creaci&oacute;n</td>
      <td width="5%" align="center" class="columna_subtitulo_resultados">Fecha en la que se Puso en Firme</td>
      <td width="5%" align="center" class="columna_subtitulo_resultados">Contratos Relacionados</td>
      <td width="5%" align="center" class="columna_subtitulo_resultados">Usuario Solicitante</td>
      <td width="4%" align="center" class="columna_subtitulo_resultados">Gerente de OT</td>
      <td width="21%" align="center" class="columna_subtitulo_resultados">Objeto</td>
      <td width="11%" align="center" class="columna_subtitulo_resultados">Area</td>
      <td width="11%" align="center" class="columna_subtitulo_resultados">Rol Encargado</td>      
      <td width="12%" align="center" class="columna_subtitulo_resultados">Estado</td>
      </tr>
    <?php
	if($_GET["tp_proceso"]!="sondeo"){//SI NO VIENE CON LA VARIABLE DE SONDEO
	if($_SESSION["ses_congelados"] == 2){
			$comple_sql.= " and (congelado is null or congelado = 2 or congelado = '')";
			}
				
	if($_SESSION["ses_area_usuaria"] != 'in ()' and $_SESSION["ses_area_usuaria"] != 'in (0)' and $_SESSION["ses_area_usuaria"] != '0'){
			$comple_sql.= " and t1_area_id ".$_SESSION["ses_area_usuaria"];		
			$comple_mysql.=" and t1_area_id ".$_SESSION["ses_area_usuaria"];
			}
			
			
	
	if($_GET["tp_contratacion"] != "0"){
		if($_GET["tp_contratacion"] == "B"){
			$comple_tp_contratacion = " and t1_tipo_contratacion_id <> 1";
			}else{
				$comple_tp_contratacion = " and t1_tipo_contratacion_id = 1";
				}
	}
	if($_GET["tp_proceso"] != 0){
		$comple_tp_proceso = " and t1_tipo_proceso_id = '".$_GET["tp_proceso"]."'";
		}		

	if($_GET["id_profesional"] != 0){
		$comple_tp_profesional = " and id_us_profesional_asignado = ".$_GET["id_profesional"]."";
		}	
	
	$comple_sql.=" and de_historico is null and (tiempos_estandar is null or tiempos_estandar =2)";
	
	$ano_req = $_SESSION["ses_ano"];
	
	if($_SESSION["mes_requiere"] <> "0"){
			$ano_req = $_SESSION["ses_ano"]."-".$_SESSION["mes_requiere"];
			$comple_sql_meses =" and fecha_en_firme like '%".$ano_req."%'";
			}else{
				$comple_sql_meses =" and fecha_en_firme like '%".$ano_req."%'";
				}
	
	
	if($_SESSION["mes_requiere2"] <> "0"){
			$ano_req = $_SESSION["ses_ano"]."-".$_SESSION["mes_requiere"]."-01";
			$ano_req2 = $_SESSION["ses_ano"]."-".$_SESSION["mes_requiere2"]."-31";
			
			$comple_sql_meses=" and fecha_en_firme >= '".$ano_req."' and fecha_en_firme  <= '".$ano_req2."'";
			}		
			
		$comple_sql.=$comple_sql_meses;
		
		if($_SESSION["ses_congelados"] == 2){
			$comple_sql.= " and (congelado is null or congelado = 2 or congelado = '')";
			}
		

	if($_SESSION["ses_area_usuaria"] != 'in ()' and $_SESSION["ses_area_usuaria"] != 'in (0)'){
			$comple_sql.= " and t1_area_id ".$_SESSION["ses_area_usuaria"];
			}
	
$sele_items_historico_codigo = "select id_item, num1, num2, num3, fecha_se_requiere, nombre, CAST(objeto_solicitud AS text), Expr1, t1_tipo_proceso_id, id_pecc, estado, id_us, id_us_profesional_asignado, t1_area_id, t1_tipo_contratacion_id, congelado,id_us_preparador,ROW_NUMBER()Over(order by id_item desc) As RowNum,solicitud_rechazada,solicitud_desierta,id_gerente_ot, de_historico, ob_solicitud_adjudica, fecha_creacion, origen_pecc, nombre_encargado, fecha_en_firme from v_peec_historico where (estado < 20 ) ".$comple_tp_profesional.$comple_sql." and fecha_en_firme like '%".$_GET["fecha_filtra"]."%' ".$comple_tp_proceso." ".$comple_tp_contratacion."  and t1_area_id > 0 $comple_sql group by id_item, num1, num2, num3, fecha_se_requiere, nombre, objeto_solicitud, Expr1, t1_tipo_proceso_id, id_pecc, estado, id_us, id_us_profesional_asignado, t1_area_id,t1_tipo_contratacion_id, congelado,id_us_preparador,solicitud_rechazada,solicitud_desierta,id_gerente_ot, de_historico, ob_solicitud_adjudica, fecha_creacion, origen_pecc, nombre_encargado, fecha_en_firme";

if($_SESSION["id_us_session"]==32){
	//echo $sele_items_historico_codigo;
	}




    	$sel_histo_sql = query_db( $sele_items_historico_codigo);

		
		while($sel_para_insert = traer_fila_db($sel_histo_sql)){//inicio while select normal
			
			
			
			$id_us_genera=$_SESSION["id_us_session"];
			$id_item=$sel_para_insert[0];
			$sel_item = traer_fila_row(query_db("select estado from $pi2 where id_item=".$id_item)); 	#Query de primera instancia para roles pendientes

			$id_tipo_proceso_pecc = 1;
			if($sel_para_insert[8] == 7){
					$id_tipo_proceso_pecc = 2;
				}
			if($sel_para_insert[8] == 8){
					$id_tipo_proceso_pecc = 3;
				}
				$_SESSION['id_tipo_proceso_peccs'] = $id_tipo_proceso_pecc;

			$id_us_solicitante=$sel_para_insert[11]+0;
			$id_us_gerente_ot=$sel_para_insert['id_gerente_ot'];
			$fecha_requiere=$sel_para_insert[4];
			$tipo_proceso=$sel_para_insert[8]+0;
			$contratos_relacionados=contratos_relacionados_solicitud_para_campos($sel_para_insert[0]);
			$usuario_solicitante=$sel_para_insert[11]+0;
			

			
			if($sel_para_insert[22] != ""){
			$objeto_solicitud=$sel_para_insert[22];
			}else{	
			$objeto_solicitud=$sel_para_insert[6];
			}
			
			
			$estado=$sel_para_insert[10];
			$area=$sel_para_insert[13]+0;
			$profecional=$sel_para_insert[12]+0;
			$preparador=$sel_para_insert[16]+0;
			$tipo_solicitud=$sel_para_insert[14]+0;
			$tp_proceso="0";
			if ($sel_para_insert[8] == 8 and $sel_para_insert[14] <> 1) { $nom_tipo_proceso = "Orden de Pedido Contrato Marco/Lista de Precios";}else{
      $nom_tipo_proceso = $sel_para_insert[7];
	  
	  }
	  
$comple_est="";
			$numero_proceso=numero_item_pecc($sel_para_insert[1],$sel_para_insert[2],$sel_para_insert[3]);
			$nom_us_solicitante=traer_nombre_muestra($sel_para_insert[11], $g1,"nombre_administrador","us_id");
			$nom_us_gerente_ot=traer_nombre_muestra($sel_para_insert['id_gerente_ot'], $g1,"nombre_administrador","us_id");
			if($sel_para_insert[10] > 20 and $sel_para_insert[10] < 32 and $sel_para_insert[10] <> 31){
			  $nom_estado = "En legalizaci&oacute;n";
			  }else{
				  if($sel_para_insert[10]==32 and $sel_para_insert[18]==1){
					  $comple_est=" - RECHAZADO";
					  }
				 if($sel_para_insert[10]==32 and $sel_para_insert[19]==1){
					  $comple_est=" - DECLARADO DESIERTO";
					  }
				  $nom_estado = $sel_para_insert[5].$comple_est;
				  
				  }
				  
				  
		if($sel_para_insert[15] == 1){
				
				$sel_ob_cnogelado = traer_fila_row(query_db("select observacion from t2_acciones_admin where id_item = $id_item and accion = 'Congelado' order by id_accion_admin desc"));
				$nom_estado = "Congelado - ".$sel_ob_cnogelado[0];
			}
			
			
		if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
		/*$select_minmima_gestion = traer_fila_row(query_db("select MIN(fecha_real) from t2_nivel_servicio_gestiones where id_item=".$sel_para_insert[0]." and estado = 1"));
		$fecha_puso_firme="";
if($select_minmima_gestion[0]!=""){$fecha_puso_firme = $select_minmima_gestion[0];}
    		*/		  
	?>
    <tr class="<?=$clase?>">
      
      <td><?=$numero_proceso?></td>
      <td align="center"><?
      
	  if($sel_para_insert[21] == "si" ) echo "SI"; else echo "NO";
	  ?></td>
      <td align="center"><? if($sel_para_insert[24]==0) echo "Ninguno"; else echo $sel_para_insert[24];?></td>
      <td align="center"><?=$fecha_requiere?></td>
      <td><?=$nom_tipo_proceso?></td>
      <td><? echo saca_nombre_lista($g1,$sel_para_insert[12],'nombre_administrador','us_id');?></td>
      <td><?=$sel_para_insert[23]?></td>
      <td><?=$sel_para_insert[26]?></td>
      <td><?=$contratos_relacionados?></td>
      <td><?=$nom_us_solicitante?></td>
      <td><?=$nom_us_gerente_ot?></td>
      <td><?=$objeto_solicitud?></td>
      <td>
        <?
	  
	  echo saca_nombre_lista($g12,$area,'nombre','t1_area_id');
	?>  
      </td>
      <td><?
      echo $sel_para_insert[25];
	  ?></td>
      <td><?=$nom_estado?></td>
      </tr>
    <?
		}//fin while select normal
		if($_GET['tp_contratacion']==0 and $_GET['tp_contratacion']==0){//si se cuple es porque totaliza y busca en la urna
		if($_GET['consulta_sondeo']==1){//si se consulta el sondeo
		$us_id=$_GET['id_profesional'];
		$pos = strpos($_GET["fecha_filtra"], "-");
		if ($pos !== false) {//si exixte en la cadena
			$fecha_filtra=explode('-',$_GET['fecha_filtra']);
			$ano=$fecha_filtra[0];
			$mes=$fecha_filtra[1];
			$comple_mysql.=" and year(t1.fecha_creacion)=$ano and  month(t1.fecha_creacion) = $mes";
		}else{
			$comple_mysql.=" and year(t1.fecha_creacion)=".$_GET['fecha_filtra'];
		}
		//$fecha_filtra=explode('-',$_GET['fecha_filtra']);
		//$ano=$fecha_filtra[0];
		//$mes=$fecha_filtra[1];
		$query='SELECT t1.detalle_objeto as objeto, t1.consecutivo, t1.fecha_creacion, t2.nombre_administrador, t3.nombre as estado, t4.nombre as area, t5.nombre as tipo_proceso, t2.us_id, t1.t1_area_id, t1.pro1_id, t1.tp1_id from pro1_proceso as t1, us_usuarios as t2, tp1_estado_proceso as t3, tp3_area_solicitante as t4, tp2_tipo_proceso t5 where t1.us_id_contacto=t2.us_id and t1.tp1_id=t3.tp1_id and t1.tp3_id=t4.tp3_id and t1.tp2_id=t5.tp2_id and t1.tp1_id in (4, 9, 11) and t1.tp2_id=30 and t1.us_id_contacto='.$us_id.$comple_mysql;
		if($_SESSION["id_us_session"]==32){
			//echo $query;
		}
		$query_tecnico = mysql_query($query);
		while($se_pro = mysql_fetch_row($query_tecnico)){//INICIO DEL WHILE
		  $nombre_rol=$sel_item = traer_fila_row(query_db("select t1.nombre from tseg11_roles_general as t1, tseg12_relacion_usuario_rol as t2 where t2.id_rol_general=t1.id_rol and t2.id_rol_general in (13, 17) and t2.id_usuario=".$se_pro[7]));
		  $busca_apertura=traer_fila_row(query_db("select * from pro12_apertura_proceso where pro1_id = $se_pro[9] and estado = 1"));
		  if($busca_apertura[0]>=1){
			  $nombre_rol[0]="Evaluador T&eacute;cnico";
			  $se_pro[4]="Evaluaci&oacute;n T&eacute;cnica";
		  }
		  $nombre_area=$sel_item = traer_fila_row(query_db("select nombre_html from t1_area where t1_area_id=".$se_pro[8]));
		  $recibe_solicitud=explode(' ',$se_pro[2]);
		  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
			?>
    <tr class="<?=$clase?>">
      
      <td><?=$se_pro[1]?></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
      <td><?=$se_pro[6]?></td>
      <td><?=$se_pro[3]?></td>
      <td><?=$recibe_solicitud[0]?></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td><?=$se_pro[0]?></td>
      <td><?=$nombre_area[0]?></td>
      <td><?=$nombre_rol[0]?></td>
      <td><?=$se_pro[4]?></td>
      </tr>
    <?
		}//FIN DEL WHILE
		}//fin si se consulta el sondeo
		}//fin si se cuple es porque totaliza y busca en la urna
		
	}else{//SI VIENE CON LA VARIABLE DE SONDEO
		$us_id=$_GET['id_profesional'];
		$pos = strpos($_GET["fecha_filtra"], "-");
		$comple_mysql="";
		if($_SESSION["ses_area_usuaria"] != 'in ()' and $_SESSION["ses_area_usuaria"] != 'in (0)' and $_SESSION["ses_area_usuaria"] != '0'){
			$comple_mysql.=" and t1_area_id ".$_SESSION["ses_area_usuaria"];
		}
		if ($pos !== false) {//si exixte en la cadena
			$fecha_filtra=explode('-',$_GET['fecha_filtra']);
			$ano=$fecha_filtra[0];
			$mes=$fecha_filtra[1];
			$comple_mysql.=" and year(t1.fecha_creacion)=$ano and  month(t1.fecha_creacion) = $mes";
		}else{
			$comple_mysql.=" and year(t1.fecha_creacion)=".$_GET['fecha_filtra'];
		}
		$query="SELECT t1.detalle_objeto as objeto, t1.consecutivo, t1.fecha_creacion, t2.nombre_administrador, t3.nombre as estado, t4.nombre as area, t5.nombre as tipo_proceso, t2.us_id, t1.t1_area_id, t1.pro1_id, t1.tp1_id from pro1_proceso as t1, us_usuarios as t2, tp1_estado_proceso as t3, tp3_area_solicitante as t4, tp2_tipo_proceso t5 where t1.us_id_contacto=t2.us_id and t1.tp1_id=t3.tp1_id and t1.tp3_id=t4.tp3_id and t1.tp2_id=t5.tp2_id and t1.tp1_id in (4, 9, 11) and t1.tp2_id=30 and t1.us_id_contacto=$us_id".$comple_mysql;
		if($_SESSION["id_us_session"]==32){
			//echo $query;
		}
		$query_tecnico = mysql_query($query);
		while($se_pro = mysql_fetch_row($query_tecnico)){//INICIO DEL WHILE
		  $nombre_rol=$sel_item = traer_fila_row(query_db("select t1.nombre from tseg11_roles_general as t1, tseg12_relacion_usuario_rol as t2 where t2.id_rol_general=t1.id_rol and t2.id_rol_general in (13, 17) and t2.id_usuario=".$se_pro[7]));
		  $busca_apertura=traer_fila_row(query_db("select * from pro12_apertura_proceso where pro1_id = $se_pro[9] and estado = 1"));
		  if($busca_apertura[0]>=1){
			  $nombre_rol[0]="Evaluador T&eacute;cnico";
			  $se_pro[4]="Evaluaci&oacute;n T&eacute;cnica";
		  }
		  $nombre_area=$sel_item = traer_fila_row(query_db("select nombre_html from t1_area where t1_area_id=".$se_pro[8]));
		  $recibe_solicitud=explode(' ',$se_pro[2]);
		  if($cont == 0){
		  	$clase= "filas_resultados";
			$cont = 1;
		  }else{
		  	$clase= "";
			$cont = 0;
		  }
			?>
    <tr class="<?=$clase?>">
      
      <td><?=$se_pro[1]?></td>
      <td align="center"></td>
      <td align="center"></td>
      <td align="center"></td>
      <td><?=$se_pro[6]?></td>
      <td><?=$se_pro[3]?></td>
      <td><?=$recibe_solicitud[0]?></td>
      <td></td>
      <td></td>
      <td></td>
      <td></td>
      <td><?=$se_pro[0]?></td>
      <td><?=$nombre_area[0]?></td>
      <td><?=$nombre_rol[0]?></td>
      <td><?=$se_pro[4]?></td>
      </tr>
    <?
		}//FIN DEL WHILE
	}
	?>
</table></td>
</tr>
<tr>
  <td colspan="2" align="center">&nbsp;</td>
</tr>
<tr>
  <td align="center">&nbsp;</td>
  <td align="right"><input type="button" value="Cerrar" class="boton_grabar_cancelar windowPopupClose" onclick='window.parent.document.getElementById(&quot;div_carga_busca_sol&quot;).style.display=&quot;none&quot;' /></td>
</tr>
<tr>
  <td colspan="2" align="center">&nbsp;</td>
</tr> 
</table>


</body>
</html>
