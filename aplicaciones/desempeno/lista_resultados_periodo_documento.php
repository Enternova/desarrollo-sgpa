<?
	include("../../librerias/lib/@session.php");
	include('../../librerias/php/funciones_html.php');
	
	$periodo=$_GET["id_evaluacion"];
	$periodo2=str_replace("_", " ", $periodo);
	$periodo2=str_replace("*", "/", $periodo2);
	$id_proveedor=elimina_comillas(arreglo_recibe_variables($_GET['id_2']));
	$_SESSION["id_us_proveedor"]=$_GET['id_2'];
	$nombre_proveedor=traer_fila_row(query_db("select razon_social from t1_proveedor where t1_proveedor_id=".$id_proveedor));
	$periodo=str_replace("_", "", $periodo);
	$periodo=explode("*", $periodo);
	$_SESSION["sql_comple_periodo"]=$id_proveedor." AND fecha_periodo_evaluado BETWEEN '".$periodo[0]."' AND '".$periodo[1]."'";
	$id_proveedor=$id_proveedor." AND fecha_periodo_evaluado BETWEEN '".$periodo[0]."' AND '".$periodo[1]."'";
	$select="SELECT estado_evaluacion, id_estado_criterio FROM dbo.historico_desempeno() WHERE id_estado_criterio not in(0) AND id_proveedor=".$id_proveedor." group by id_estado_criterio, estado_evaluacion";
?>
		<div class="titulos_secciones" ><h5 id="titlulo_resultado" style="font-size:18pt !important; font-weight: 900 !important;">RESULTADOS DEL PERIODO <?=$periodo2;?> DEL PROVEEDOR:<br> <?=$nombre_proveedor[0];?></h5></div>
		<div class="" style="background: #181818; height: 2px;"></div>
		

<table id="carga_periodo_proveedor_documento" class="responsive-table striped centered" cellspacing="0" width="100%">
  	<thead>
	  <tr>
		  <th width="20%">
		  <?
			$select="SELECT estado_evaluacion, id_estado_criterio FROM dbo.historico_desempeno_resultados() WHERE id_estado_criterio not in(0) AND id_proveedor=".$id_proveedor." group by id_estado_criterio, estado_evaluacion";
			$accion='buscador_hitorico_proveedor_periodo()';
			agrega_select_accion_texto_grande('s12 m6 l4', 'Estado Evaluaci&oacute;n', $accion, $select, 'estado_evaluacion_documento_historico', 'font-size:18pt !important; font-weight: 600 !important; color: #000000;');
		  ?>
		  </th>
		  <th width="30%">
		  <?
			$accion='buscador_hitorico_proveedor_periodo()';
			input_con_accion_texto_grande('s12 m6 l4', $val_input, 'nombre_proveedor_documento_historico', 'validate', 'font-size:18pt !important; font-weight: 900 !important;', 'Proveedor / Contratista', 'text', 'onkeyup', $accion, 'font-size:18pt !important; font-weight: 900 !important; color: #000000;');
		  ?>
		  </th>
		  <th width="25%" style="font-size:18pt !important; font-weight: 900 !important;">
			Documento Contractual
		  </th>
		  <th width="15%" style="font-size:18pt !important; font-weight: 900 !important;">
			Periodo
		  </th>
		  <th width="10%" style="font-size:18pt !important; font-weight: 900 !important;">
			Acci&oacute;n
		  </th>
	  </tr>
	</thead>
	<tfoot id="foot_periodo_proveedor_documento"></tfoot>
	<tbody id="body_periodo_proveedor_documento"></tbody>
</table>