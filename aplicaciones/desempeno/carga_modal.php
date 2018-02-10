<?
	include("../../librerias/lib/@session.php");
	include('../../librerias/php/funciones_html.php');
	
?>
<title>Edicion</title>
<link rel="stylesheet" type="text/css" href="../../librerias/materialize/css/materialize.css?version=<?=$hora?>">
	<link rel="stylesheet" type="text/css" href="../../css/desempeno/style_desempeno.css?version=2">
	<script type="text/javascript" src="../../librerias/jquery/jquery-3.2.1.min.js?version<?=$version_js?>=<?=$version_js?>"></script>
	<script type="text/javascript" src="../../librerias/js/desempeno/desempeno_admin.js?version<?=$version_js?>=<?=$version_js?>"></script>
	
	
<div class="row">
	
	
	
	<?
		
		
		input('s12 m2 l3', '', 'nombre_aspectos', 'validate', '', 'Aspectos', 'text');
		input('s12 m2 l3', '', 'puntos_aspectos', 'validate', '', 'Puntos', 'number');
		input('s12 m2 l3', '', 'nombre_descripcion', 'validate', '', 'Descripcion', 'text');

		
		
		
	
		
	?>
	
	
				
</div>