<?
	include("../../librerias/lib/@session.php");
	include('../../librerias/php/funciones_html.php');
?>
		<div class="titulos_secciones" ><h5 id="titlulo_resultado" style="font-size:18pt !important; font-weight: 900 !important;">RESULTADOS DE DESEMPE&Ntilde;O</h5></div>
		<div class="" style="background: #181818; height: 2px;"></div>
		

<table id="carga_datos_historico_resultado" class="responsive-table striped centered" cellspacing="0" width="100%">
  	<thead>
	  <tr>
		  <th width="30%">
		  <?
			$accion='buscador_tabla_historico_resultados()';
			input_con_accion_texto_grande('s12 m6 l4', $val_input, 'nombre_proveedor_resultado', 'validate', 'font-size:18pt !important; font-weight: 900 !important;', 'Proveedor / Contratista', 'text', 'onkeyup', $accion, 'font-size:18pt !important; font-weight: 900 !important; color: #000000;');
		  ?>
		  </th>
		  <th width="15%" style="font-size:18pt !important; font-weight: 900 !important;">
			Tipo Documento
		  </th>
		  <th width="15%" style="font-size:18pt !important; font-weight: 900 !important;">
			Evaluaci&oacute;n T&eacute;cnica
		  </th>
		  <th width="15%" style="font-size:18pt !important; font-weight: 900 !important;">
			Evaluaci&oacute;n HSSE
		  </th>
		  <th width="15%" style="font-size:18pt !important; font-weight: 900 !important;">
			Evaluaci&oacute;n Administrativa
		  </th>
		  <th width="10%" style="font-size:18pt !important; font-weight: 900 !important;">
			Total
		  </th>
		  <th width="10%" style="font-size:18pt !important; font-weight: 900 !important;">
			Clasificaci&oacute;n
		  </th>
		  <th width="5%" style="font-size:18pt !important; font-weight: 900 !important;">
			Ver
		  </th>
	  </tr>
	</thead>
	<tfoot id="foot_historico_resultados"></tfoot>
	<tbody id="body_historico_resultados"></tbody>
</table>