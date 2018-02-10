<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("administracion.html");
?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
</head>
<body >
<table width="100%" border="0">
  <tr>
    <td colspan="2">Seleccion de areas</td>
  </tr>
  <tr>
    <td width="14%"><select name="t1_area" id="t1_area">
      <option value="0"></option>
      <?php $sel_area = query_db("select t1_area_id, nombre from $g12 where estado = 1 order by nombre asc");
		while($rowArea =traer_fila_db($sel_area)){?>
      <option value="<?=$rowArea['t1_area_id']?>">
        <?=$rowArea['nombre']?>
        </option>
      <?php }?>
    </select></td>
    <td width="86%"><input type="button" value="Agregar Area" onClick="agrega_area_gestor()"></td>
  </tr>
</table>
<table width="100%" border="0">
  <tr>
    <td width="10%" bgcolor="#999999">Eliminar</td>
    <td width="90%" bgcolor="#999999">Area</td>
  </tr>
  <?

  $sel_areas_relacionadas = query_db("select t2.t1_area_id, t2.nombre from tseg19_relacion_usuario_area_gestor_ab as t1, t1_area as t2 where t1.id_area = t2.t1_area_id and t1.id_gestor_ab = ".$pv_id);
  
  while($s_area = traer_fila_db( $sel_areas_relacionadas)){
  ?>
  <tr>
    <td><strong onClick="eliminar_area_gestor(<?=$s_area[0]?>)">Eliminar</strong></td>
    <td><?=$s_area[1]?></td>
  </tr>
  <?
  }
  ?>
</table>
<input type="hidden" name="id_area_elimina" name="id_area_elimina" />
<p>&nbsp;</p>
</body>
</html>
