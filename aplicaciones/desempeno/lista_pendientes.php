<?
	include("../../librerias/lib/@session.php");
	include('../../librerias/php/funciones_html.php');
?>
		<div class="titulos_secciones" ><h5 id="titlulo_historico" style="font-size:18pt !important; font-weight: 900 !important;">DESEMPE&Ntilde;O</h5></div>
		<div class="" style="background: #181818; height: 2px;"></div>
		

  <table id="carga_datos_historico" class="responsive-table striped centered" cellspacing="0" width="100%">
  	<thead>
	  <tr>
		  <th width="20%">
		  <?
			$select="SELECT estado_evaluacion, id_estado_criterio FROM dbo.historico_desempeno() WHERE (id_evaluador=".$_SESSION["id_us_session"]." or id_crea_aspectos= ".$_SESSION["id_us_session"]." or id_jefe=".$_SESSION["id_us_session"].") group by id_estado_criterio, estado_evaluacion";
			$accion='buscador_tabla_historico()';
			agrega_select_accion_texto_grande('s12 m6 l4', 'Estado Evaluaci&oacute;n', $accion, $select, 'estado_evaluacion', 'font-size:18pt !important; font-weight: 600 !important; color: #000000;');
		  ?>
		  </th>
		  <th width="30%">
		  <?
			$accion='buscador_tabla_historico()';
			input_con_accion_texto_grande('s12 m6 l4', $val_input, 'nombre_proveedor', 'validate', 'font-size:18pt !important; font-weight: 900 !important;', 'Proveedor / Contratista', 'text', 'onkeyup', $accion, 'font-size:18pt !important; font-weight: 900 !important; color: #000000;');
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
	<tfoot id="foot_historico_procesos"></tfoot>
	<tbody id="body_historico_procesos"></tbody>
</table>