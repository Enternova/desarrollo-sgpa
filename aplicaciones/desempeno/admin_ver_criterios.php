<?
	include("../../librerias/lib/@session.php");
	include('../../librerias/php/funciones_html.php');
?>
<div class="row">
	<?
		
		$select = "Select * from t9_criterio";
		crear_tabla('Criterios', $select, 'left', 'MODIFICAR', "ver()", 'background: #229BFF;', 's12 m3 l3')
		
		
	?>
</div>



<div class="row">
	<?
		boton_sin_icono_accion('left', 'GUARDAR', "()", 'background: #229BFF;', 's12 m6 l3');
	?>
</div>