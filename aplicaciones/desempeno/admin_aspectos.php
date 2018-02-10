<?
	include("../../librerias/lib/@session.php");
	include('../../librerias/php/funciones_html.php');
	
?>
<div class="row">

	<?
		$select = "select nombre_criterio+'('+case when (tipo_contrato=1) then 'Servicio Menor' when (tipo_contrato=2) then 'Contrato Puntual' else 'Contrato Marco' end+')' as criterio, id_criterio from t9_criterio where estado=1 order by tipo_contrato";
		agrega_select_accion('s12 m2 l4', 'Criterios', '', $select, 'tipo_criterio_aspecto');
		
		
	?>
	<?
		
		
		agrega_select_fijo1('s12 m2 l4', 'Tipo de Servicio', '', '', 'tipo_servicio');
	?>
	
				
</div>

<div class="row">

	<?
		
		
		input('s12 m2 l3', '', 'nombre_aspectos', 'validate', '', 'Aspectos', 'text');
		input('s12 m2 l3', '', 'puntos_aspectos', 'validate', '', 'Puntos', 'number');
		input('s12 m2 l3', '', 'nombre_descripcion', 'validate', '', 'Descripcion', 'text');

		
		
	?>
	
	
				
</div>


<div class="row">
	<?

		boton_sin_icono_accion('left', 'GUARDAR', "guarda_aspecto_admin()", 'background: #229BFF;', 's12 m3 l3');
	?>
</div>




<div class="row">
	<table id="carga_datos_historico_aspectos_admin" class="responsive-table striped centered" cellspacing="0" width="100%">
  	<thead>
	  <tr>
		  <th width="20%" style="font-size:18pt !important; font-weight: 900 !important;">
			  Tipo Criterio
		  </th>
		  <th width="15%" style="font-size:18pt !important; font-weight: 900 !important;">
			  Tipo Servicio
		  </th>
		  <th width="20%" style="font-size:18pt !important; font-weight: 900 !important;">
			  Aspectos
		  </th>
		  <th width="10%" style="font-size:18pt !important; font-weight: 900 !important;">
			  Puntos
		  </th>
		  <th width="23%" style="font-size:18pt !important; font-weight: 900 !important;">
			  Descripci&oacute;n
		  </th>
		  <th width="12%" style="font-size:18pt !important; font-weight: 900 !important;">
			  Acci&oacute;n
		  </th>
	  </tr>
	</thead>
	<tfoot id="foot_historico_aspectos_admin"></tfoot>
	<tbody id="body_historico_aspectos_admin"></tbody>
</table>
	
</div>










