<?
	include("../../librerias/lib/@session.php");
	include('../../librerias/php/funciones_html.php');
?>



<div class="row">

	<?
		
		
		agrega_select_fijo('s12 m2 l4', 'Tipo de Documento', '', '', 'tipo_contrato')
	?>
	
	
</div>		
<div class="row">
	<?
		input('s12 m6 l4', '', 'nombre_criterio', 'validate', '', 'Criterio', 'text');
		input('s12 m6 l4', '', 'puntos_criterio', 'validate', '', 'Puntos', 'number');
	?>
</div>
<div class="row">
	<?
		boton_sin_icono_accion('left', 'GUARDAR', "guarda_criterio_admin()", 'background: #229BFF;', 's12 m6 l3');
	?>
</div>
<div class="row">
	<table id="carga_datos_historico_criterios_admin" class="responsive-table striped centered" cellspacing="0" width="100%">
		<thead>
		  <tr>
			  <th width="35%" style="font-size:18pt !important; font-weight: 900 !important;">
				  Tipo de Documento
			  </th>
			  <th width="35%" style="font-size:18pt !important; font-weight: 900 !important;">
				  Criterio
			  </th>
			  <th width="10%" style="font-size:18pt !important; font-weight: 900 !important;">
				  Puntos
			  </th>
			  <th width="20%" style="font-size:18pt !important; font-weight: 900 !important;">
				  Acci&oacute;n
			  </th>
		  </tr>
		</thead>
		<tfoot id="foot_historico_criterios_admin"></tfoot>
		<tbody id="body_historico_criterios_admin"></tbody>
	</table>
</div>


	<?
		$cabecera='Tipo de Documento| | | | | | | |35?Criterio| | | | | | | |35?Puntos| | | | | | | | |30';
		
		
		$select_tabla="select case when (tipo_contrato=1) then 'Servicio Menor' when (tipo_contrato=2) then 'Contrato Puntual' else 'Contrato Marco' end as tipo_contrato, nombre_criterio, puntos_criterio, id_criterio from t9_criterio where estado=1 order by tipo_contrato";
		$funcion1='muestra_modal_editar_criterio_admin|&#xE254;| |color: #229BFF; cursor: pointer !important; background: trasparent;| |Editar';
		$funcion2='elimina_criterio_admin|&#xE92B;| |color: #FF0000; cursor: pointer !important; background: trasparent;|&apos;&apos;|Eliminar';
		//$select = "Select * from t9_criterio";
		//crear_tabla_criterio('Criterios', $select, 'left', 'MODIFICAR', 'abrir_modal', 'background: #229BFF;')
		
		//carga_tabla_hmtl($cabecera, $funcion1, $funcion2, '', $select_tabla);
	?>

<div class="modal"></div>
