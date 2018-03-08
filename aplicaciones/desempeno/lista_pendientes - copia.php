<?
	include("../../librerias/lib/@session.php");
	include('../../librerias/php/funciones_html.php');
?>
		<div class="titulos_secciones" ><h5 id="titlulo_historico" style="font-size:18pt !important; font-weight: 900 !important;">DESEMPE&Ntilde;O</h5></div>
		<div class="" style="background: #181818; height: 2px;"></div>
		

  <table class="responsive-table striped centered" cellspacing="0" width="100%">
  	<thead>
	  <tr>
		  <th width="20%">
		  <?
			$select="select t1.nombre_estado, t2.id_estado from t9_estado as t1, t9_criterios_evaluacion as t2 where t1.id_estado=t2.id_estado and t2.id_estado <9 and(t2.id_evaluador=".$_SESSION["id_us_session"]." or t2.id_crea_aspectos= ".$_SESSION["id_us_session"].") group by t1.nombre_estado, t2.id_estado";
			$accion='buscador_tabla_historico(&apos;body_historico_procesos&apos;,&apos;1&apos;,&apos;1&apos;)';
			agrega_select_accion_con_get('s12 m6 l4', 'Estado Evaluaci&oacute;n', $accion, $select, 'estado_evaluacion', $val_select);
		  ?>
		  </th>
		  <th width="30%">
		  <?
			$accion='buscador_tabla_historico(&apos;body_historico_procesos&apos;,&apos;1&apos;,&apos;1&apos;)';
			input_con_accion('s12 m6 l4', $val_input, 'nombre_proveedor', 'validate', '', 'Proveedor / Contratista', 'text', 'onkeyup', $accion);
		  ?>
		  </th>
		  <th width="25%">
			Documento Contractual
		  </th>
		  <th width="15%">
			Periodo
		  </th>
		  <th width="10%">
			Acci&oacute;n
		  </th>
	  </tr>
	</thead>
	<tfoot id="foot_historico_procesos"></tfoot>
	<tbody id="body_historico_procesos"></tbody>
</table>


	<?
	$sql_rows="SELECT id_evaluacion, id_estado_criterio, estado_evaluacion, nombre_proveedor, numero_documento, periodo_evaluacion, id_evaluador, id_crea_aspectos, tipo_documento FROM (SELECT ROW_NUMBER()Over(order by id_evaluacion desc) As RowNum, id_evaluacion, id_estado_criterio, estado_evaluacion, nombre_proveedor, numero_documento, periodo_evaluacion, id_evaluador, id_crea_aspectos, tipo_documento FROM dbo.historico_desempeno()) as resultado_paginado WHERE RowNum BETWEEN 1 AND 10";
		$cabecera='Estado Evaluaci&oacute;n| | | | | | | |20?Proveedor/Contratista| | | | | | | |25?Documento Contractual| | | | | | | |25?Periodo| | | | | | | | |10';
		
		$select_tabla="SELECT DISTINCT estado_evaluacion, nombre_proveedor, numero_documento, convert(varchar(10),fecha_periodo_evaluado)+' / '+convert(varchar(10),DATEADD (year , -1 , convert(date,fecha_periodo_evaluado) )), id_evaluacion FROM vista_t9_contrato_puntual
";
		
		$funcion1='muestra_historico_gestion|&#xE154;| |color: #229BFF; cursor: pointer !important; background: trasparent;| |Gestionar';
		//$select = "Select * from t9_criterio";
		//crear_tabla_criterio('Criterios', $select, 'left', 'MODIFICAR', 'abrir_modal', 'background: #229BFF;')
		
		carga_tabla_hmtl($cabecera, $funcion1, '', '', $select_tabla);
	?>

