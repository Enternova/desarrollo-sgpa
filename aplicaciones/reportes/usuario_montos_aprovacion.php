<? 
include("../../librerias/lib/@session.php");	 
	
	
	?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>
<title>Documento sin t&iacute;tulo</title>

<?  if($_GET["consulta"] ==  "si"){

	 ?><link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /><?
 }
 ?>

</head>

<body>
<table width="100%" border="<? if($_GET["consulta"] ==  "si") echo "0"; else echo "1";?>" class="tabla_lista_resultados">
  <tr bgcolor="#005395">
    <td width="7%" align="center"><font color="#FFFFFF">Area de los Gerentes</font></td>
    <td width="13%" align="center"><font color="#FFFFFF">Norma de actos y transacciones 2017</font></td>
    <td width="14%" align="center"><font color="#FFFFFF">Tipo de Proceso para Bienes y Servicios</font></td>
    <td width="29%" align="center"><font color="#FFFFFF">Nivel de Aprobaci&oacute;n</font></td>
    <td width="37%" align="center"><font color="#FFFFFF">Responsable Aprobaci&oacute;n</font></td>
  </tr>
  <?
  $sel_areas = query_db("select t1_area_id, nombre_html from t1_area where estado = 1 order by nombre_html");
  while($s_a = traer_fila_db($sel_areas)){
	  
	  $nivel_1 = "";
	  $nivel_2 = "";
	  $nivel_3 = "";
	  $nivel_4 = "";
	  $nivel_1_us = "";
	  $nivel_2_us = "";
	  $nivel_3_us = "";
	  $nivel_4_us = "";
	  
if($s_a[0] != 44){// si es diferente a abastecimiento (no aplica ver desarrollo 57 nuevo contrato)
	  $sel_usuar_nivel_4 = query_db("select t2.us_id, t2.nombre_administrador from tseg3_usuario_areas as t1, t1_us_usuarios as t2, tseg12_relacion_usuario_rol as t3 where t1.id_area = ".$s_a[0]." and t1.id_usuario = t2.us_id and t2.us_id = t3.id_usuario and t3.id_rol_general = 23 and t2.estado = 1");
	  while ($sel_n_4 = traer_fila_db($sel_usuar_nivel_4)){
	 
	 if(cual_es_el_reemplazo($sel_n_4[0]) != $sel_n_4[0]){
		  $es_reemplazo_jefe =" <font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista($g1,$sel_n_4[0],'nombre_administrador','us_id')."</strong>";
		 $nivel_4_us = $nivel_4_us." IV. ". saca_nombre_lista($g1,cual_es_el_reemplazo($sel_n_4[0]),'nombre_administrador','us_id').$es_reemplazo_jefe." $separacion ";
	 }else{
		  			$nivel_4_us = $nivel_4_us." IV. ". $sel_n_4[1]." $separacion ";
	 }
				 
			$nivel_4 = " IV. Jefatura $separacion ";
			$id_rol_4 = "45";
			$id_us_rol_4 = $sel_n_4[0];
		  }
}
	$sel_usuar_nivel_3 = query_db("select t2.us_id, t2.nombre_administrador from tseg3_usuario_areas as t1, t1_us_usuarios as t2, tseg12_relacion_usuario_rol as t3 where t1.id_area = ".$s_a[0]." and t1.id_usuario = t2.us_id and t2.us_id = t3.id_usuario and t3.id_rol_general = 10 and t2.estado = 1");
	  while ($sel_n_3 = traer_fila_db($sel_usuar_nivel_3)){
		  
	if(cual_es_el_reemplazo($sel_n_3[0]) != $sel_n_3[0]){
		  $es_reemplazo_gerente =" <font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista($g1,$sel_n_3[0],'nombre_administrador','us_id')."</strong>";
		 $nivel_3_us = $nivel_3_us." III. ". saca_nombre_lista($g1,cual_es_el_reemplazo($sel_n_3[0]),'nombre_administrador','us_id').$es_reemplazo_gerente." $separacion ";
	 }else{
		  			$nivel_3_us = $nivel_3_us." III. ". $sel_n_3[1]." $separacion ";
	 }
	 
		  	//$nivel_3_us = $nivel_3_us." 3. ". $sel_n_3[1]." / ";
			$nivel_3 = " III. Gerente de Area $separacion ";
			$id_rol_3 = "9";
			$id_us_rol_3 = $sel_n_4[0];
		  }
	
	$sel_usuar_nivel_2 = query_db("select t2.us_id, t2.nombre_administrador from tseg3_usuario_areas as t1, t1_us_usuarios as t2, tseg12_relacion_usuario_rol as t3 where t1.id_area = ".$s_a[0]." and t1.id_usuario = t2.us_id and t2.us_id = t3.id_usuario and t3.id_rol_general = 22 and t2.estado = 1");
	  while ($sel_n_2 = traer_fila_db($sel_usuar_nivel_2)){
	if(cual_es_el_reemplazo($sel_n_2[0]) != $sel_n_2[0]){
		  $es_reemplazo_vice =" <font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista($g1,$sel_n_2[0],'nombre_administrador','us_id')."</strong>";
		$nivel_2_us = $nivel_2_us." II. ". saca_nombre_lista($g1,cual_es_el_reemplazo($sel_n_2[0]),'nombre_administrador','us_id').$es_reemplazo_vice." $separacion ";
	 }else{
		  			$nivel_2_us = $nivel_2_us." II. ". $sel_n_2[1]." $separacion ";
	 }
		  	//$nivel_2_us = $nivel_2_us." 2. ". $sel_n_2[1]." / ";
			$nivel_2 = " II. Vicepresidencia $separacion ";
			$id_rol_2 = "20";
			$id_us_rol_2 = $sel_n_4[0];
		  }
	$sel_usuar_nivel_2 = query_db("select t2.us_id, t2.nombre_administrador from tseg3_usuario_areas as t1, t1_us_usuarios as t2, tseg12_relacion_usuario_rol as t3 where t1.id_area = ".$s_a[0]." and t1.id_usuario = t2.us_id and t2.us_id = t3.id_usuario and t3.id_rol_general = 28 and t2.estado = 1");
	  while ($sel_n_2 = traer_fila_db($sel_usuar_nivel_2)){
		  if(cual_es_el_reemplazo($sel_n_2[0]) != $sel_n_2[0]){
		  $es_reemplazo_director =" <font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista($g1,$sel_n_2[0],'nombre_administrador','us_id')."</strong>";
		 $nivel_2_us = $nivel_2_us." II. ". saca_nombre_lista($g1,cual_es_el_reemplazo($sel_n_2[0]),'nombre_administrador','us_id').$es_reemplazo_director." $separacion ";
	 }else{
		  			$nivel_2_us = $nivel_2_us." II. ". $sel_n_2[1]." $separacion ";
	 }
		  //	$nivel_2_us = $nivel__us2." 2. ". $sel_n_2[1]." / ";
			$nivel_2 = " II. Director $separacion ";
			$id_rol_2 = "43";
			$id_us_rol_2 = $sel_n_4[0];
		  }
		  
	$sel_usuar_nivel_1 = query_db("select t2.us_id, t2.nombre_administrador from t1_us_usuarios as t2, tseg12_relacion_usuario_rol as t3 where t2.us_id = t3.id_usuario and t3.id_rol_general = 12 and  t2.estado = 1");
	  while ($sel_n_1 = traer_fila_db($sel_usuar_nivel_1)){
		  if(cual_es_el_reemplazo($sel_n_1[0]) != $sel_n_1[0]){
		  $es_reemplazo_presidente =" <font color='#0033FF'> Reemplazo de:</font> ".saca_nombre_lista($g1,$sel_n_1[0],'nombre_administrador','us_id')."</strong>";
		 $nivel_1_us = $nivel_1_us." I. ". saca_nombre_lista($g1,cual_es_el_reemplazo($sel_n_1[0]),'nombre_administrador','us_id').$es_reemplazo_presidente."  ";
	 }else{
		  			$nivel_1_us = $nivel_1_us." I. ". $sel_n_1[1]." ";
	 }
		//  	$nivel_1_us = $nivel_1_us." 1. ". $sel_n_1[1]."";
			$nivel_1 = " I. Presidente";
			$id_rol_1 = "48";
			$id_us_rol_1 = $sel_n_4[0];
		  }
	  
	  
	  
	  
	  
	  
	  
	  
	  if($color_principal == ""){
		  $bg_color_p = "#E8E8E8";
		  $color_principal = 1;
		  }else{
			  $bg_color_p = "";
			  $color_principal = "";
			  }
  ?>
  <tr bgcolor="<?=$bg_color_p?>">
    <td rowspan="9" align="center"><?=$s_a[1]?></td>
    <td>USD$ 0  &lt; 25.000</td>
    <td>Servicios Menores</td>
    <td><?=$nivel_4?> <?=$nivel_3?> <?=$nivel_2?> <?=$nivel_1?>  </td>
    <td><?=$nivel_4_us?> <?=$nivel_3_us?> <?=$nivel_2_us?> <?=$nivel_1_us?></td>
  </tr>
  <tr bgcolor="<?=$bg_color_p?>">
    <td>USD$ 0 &lt; USD$ 30.000</td>
    <td>Negociaciones Directas</td>
    <td><?=$nivel_4?> <?=$nivel_3?> <?=$nivel_2?> <?=$nivel_1?>  </td>
    <td><?=$nivel_4_us?> <?=$nivel_3_us?> <?=$nivel_2_us?> <?=$nivel_1_us?></td>
  </tr>
  <tr bgcolor="<?=$bg_color_p?>">
    <td>&gt;= USD$ 30.000 &lt; USD$ 40.000</td>
    <td>Negociaciones Directas</td>
    <td><?=$nivel_3?> <?=$nivel_2?> <?=$nivel_1?>  </td>
    <td><?=$nivel_3_us?> <?=$nivel_2_us?> <?=$nivel_1_us?></td>
  </tr>
  <tr bgcolor="<?=$bg_color_p?>">
    <td>&gt;= USD$ 40.000 &lt; USD$ 200.000</td>
    <td>Negociaciones Directas</td>
    <td> <?=$nivel_2?> <?=$nivel_1?>  </td>
    <td> <?=$nivel_2_us?> <?=$nivel_1_us?></td>
  </tr>
  <tr bgcolor="<?=$bg_color_p?>">
    <td>&gt;= USD$ 200.000</td>
    <td>Negociaciones Directas</td>
    <td>Comite</td>
    <td>COMITE DE CONTRATACION</td>
  </tr>
  <tr bgcolor="<?=$bg_color_p?>" style="display:none">
    <td>USD$ 0 &lt; USD$ 100.000 (oculto listo para pasar a productivo pilas con el rowspan)</td>
    <td>Licitaciones</td>
    <td><?=$nivel_4?>
      <?=$nivel_3?>
      <?=$nivel_2?>
      <?=$nivel_1?></td>
    <td><?=$nivel_4_us?>
      <?=$nivel_3_us?>
      <?=$nivel_2_us?>
      <?=$nivel_1_us?></td>
  </tr>
  <tr bgcolor="<?=$bg_color_p?>">
    <td>USD$ 0 &lt; USD$ 100.000</td>
    <td>Licitaciones</td>
    <td><?=$nivel_4?>
      <?=$nivel_3?>
      <?=$nivel_2?>
      <?=$nivel_1?></td>
    <td><?=$nivel_4_us?>
      <?=$nivel_3_us?>
      <?=$nivel_2_us?>
      <?=$nivel_1_us?></td>
  </tr>
  <tr bgcolor="<?=$bg_color_p?>">
    <td>&gt;=USD$ 100.000 &lt; USD$ 200.000</td>
    <td>Licitaciones</td>
    <td><?=$nivel_3?> <?=$nivel_2?> <?=$nivel_1?>  </td>
    <td><?=$nivel_3_us?> <?=$nivel_2_us?> <?=$nivel_1_us?></td>
  </tr>
  <tr bgcolor="<?=$bg_color_p?>">
    <td>&gt;=USD$ 200.000 &lt; USD$ 500.000</td>
    <td>Licitaciones</td>
    <td><?=$nivel_2?> <?=$nivel_1?>  </td>
    <td><?=$nivel_2_us?> <?=$nivel_1_us?></td>
  </tr>
  <tr bgcolor="<?=$bg_color_p?>">
    <td>&gt;= USD$ 500.000</td>
    <td>Licitaciones</td>
    <td>Comite</td>
    <td>COMITE DE CONTRATACION</td>
  </tr>
  <?
  }
  ?>
</table>
</body>
</html>
