<?
include("../../librerias/lib/@session.php");



/*------------------FiN Carga tabla temporal-----------------------------*/
	
	

	
//	$sql_comple.= " and us_id in (19945,21893) ";
	
	$delete_temporal = query_db("delete from temporal_reporte_usuarios where id_us_genera=".$_SESSION["id_us_session"]);
	
	$sql_consulta_usaurios = "select us_id, id_rol, estado, rol, nombre_administrador, email, fecha_cambio_contrasena, fecha_inactivacion, area, soporte_desc, gestor_abaste,profesional, comprador, jefe, gerente, vicepre, director, id_area from reporte_usuarios_completo where id_rol = 5 $sql_comple and id_us_profesional is not null  group by us_id, id_rol, estado, rol, nombre_administrador, email, fecha_cambio_contrasena, fecha_inactivacion, area, soporte_desc, gestor_abaste,profesional, comprador, jefe, gerente, vicepre, director, id_area  order by area, nombre_administrador";
	
	 $sel_usuarios = query_db($sql_consulta_usaurios);
	 
	 //gerent5es de IETM
	while($sel_usu = traer_fila_db($sel_usuarios)){
		$gestor_abas ="";
		//EN el momento que se solucione los reemplazos de gestores modificar almacenamiento en la temporal y mostara aca
	$sel_quien_es_gestor = traer_fila_row(query_db("select gestor_abastecimiento from v_relacion_gestion_abastecimiento_gerente where usuario_gerente =".$sel_usu[0]." AND id_area = ".$sel_usu[17]));
	if($sel_quien_es_gestor[0] >0){
		$gestor_abas =saca_nombre_lista($g1,$sel_quien_es_gestor[0],'nombre_administrador','us_id');
	
	}else{
		$gestor_abas ="";
		}
	//EN el momento que se solucione los reemplazos de gestores modificar almacenamiento en la temporal y mostara aca
	
 $sql_insert_rol_5 = "insert into temporal_reporte_usuarios (id_us, estado, rol, nombre, email, creacion, inactivacion, area, soporte_desc, gestor_abas, profesional_cyc, comprador, jefatura, gerente_area,vicepresidente, director, presidente, id_rol, id_us_genera) values ('".$sel_usu[0]."','".$sel_usu[2]."','".$sel_usu[3]."','".$sel_usu[4]."','".$sel_usu[5]."','".$sel_usu[6]."','".$sel_usu[7]."','".$sel_usu[8]."','".$sel_usu[9]."','".$gestor_abas."','".$sel_usu[11]."','".$sel_usu[12]."','".$sel_usu[13]."','".$sel_usu[14]."','".$sel_usu[15]."','".$sel_usu[16]."','".saca_nombre_lista($g1,$presidente,'nombre_administrador','us_id')."','".$sel_usu[1]."','".$_SESSION["id_us_session"]."')";

		$insert = query_db($sql_insert_rol_5);
	}
	//profesionales / compradores

	$sel_usuarios = query_db("select us_id, id_rol, estado, rol, nombre_administrador, email, fecha_cambio_contrasena, fecha_inactivacion from reporte_usuarios_completo where id_rol in (13, 17) $sql_comple  group by us_id, id_rol, estado, rol, nombre_administrador, email, fecha_cambio_contrasena, fecha_inactivacion  order by nombre_administrador");
	while($sel_usu = traer_fila_db($sel_usuarios)){
	
	$agrego_area = "NO";
	$areas = query_db("select area from reporte_usuarios_completo where (id_us_profesional = ".$sel_usu[0]." or id_us_prof_compras_corp = ".$sel_usu[0].")    group by area  order by area");
	while($sel_areas = traer_fila_db($areas)){
	$agrego_area = "SI";
$sql_insert_rol_prof = "insert into temporal_reporte_usuarios (id_us, estado, rol, nombre, email, creacion, inactivacion, area, soporte_desc, gestor_abas, profesional_cyc, comprador, jefatura, gerente_area,vicepresidente, director, presidente, id_rol, id_us_genera) values ('".$sel_usu[0]."','".$sel_usu[2]."','".$sel_usu[3]."','".$sel_usu[4]."','".$sel_usu[5]."','".$sel_usu[6]."','".$sel_usu[7]."','".$sel_areas[0]."','','','','','','','','','','".$sel_usu[1]."','".$_SESSION["id_us_session"]."')";

		$insert = query_db($sql_insert_rol_prof);
	}
	
	if($agrego_area == "NO"){
$sql_insert_rol_prof = "insert into temporal_reporte_usuarios (id_us, estado, rol, nombre, email, creacion, inactivacion, area, soporte_desc, gestor_abas, profesional_cyc, comprador, jefatura, gerente_area,vicepresidente, director, presidente, id_rol, id_us_genera) values ('".$sel_usu[0]."','".$sel_usu[2]."','".$sel_usu[3]."','".$sel_usu[4]."','".$sel_usu[5]."','".$sel_usu[6]."','".$sel_usu[7]."','','','','','','','','','','','".$sel_usu[1]."','".$_SESSION["id_us_session"]."')";
$insert = query_db($sql_insert_rol_prof);

		}
}

//roles solo de abastecimineto
$sel_usuarios = query_db("select us_id, id_rol, estado, rol, nombre_administrador, email, fecha_cambio_contrasena, fecha_inactivacion, area, id_area from reporte_usuarios_completo where id_rol in (1,2,6,7,19,21,24,25,26,29,30) $sql_comple and id_area = 44  group by us_id, id_rol, estado, rol, nombre_administrador, email, fecha_cambio_contrasena, fecha_inactivacion, area, id_area  order by nombre_administrador");
	while($sel_usu = traer_fila_db($sel_usuarios)){
		$sql_insert_rol_abastecimi = "insert into temporal_reporte_usuarios (id_us, estado, rol, nombre, email, creacion, inactivacion, area, soporte_desc, gestor_abas, profesional_cyc, comprador, jefatura, gerente_area,vicepresidente, director, presidente, id_rol, id_us_genera,emuladores ) values ('".$sel_usu[0]."','".$sel_usu[2]."','".$sel_usu[3]."','".$sel_usu[4]."','".$sel_usu[5]."','".$sel_usu[6]."','".$sel_usu[7]."','".$sel_usu[8]."','','','','','','','','','','".$sel_usu[1]."','".$_SESSION["id_us_session"]."', '')";;
$insert = query_db($sql_insert_rol_abastecimi);
	}

	
	//otros roles


	$sel_usuarios = query_db("select us_id, id_rol, estado, rol, nombre_administrador, email, fecha_cambio_contrasena, fecha_inactivacion, area, id_area from reporte_usuarios_completo where id_rol not in (1,2,6,7,19,21,24,25,26,29,30,5, 13, 17) $sql_comple group by us_id, id_rol, estado, rol, nombre_administrador, email, fecha_cambio_contrasena, fecha_inactivacion, area, id_area  order by area, nombre_administrador");
	while($sel_usu = traer_fila_db($sel_usuarios)){
		$emula_usuarios ="";
		//EMULACION DE USAURIO

		if($sel_usu[1]==15){
    	$sel_si_es_prof = traer_fila_row(query_db("select count(*) from reporte_usuarios_completo where id_rol in (13, 17) and us_id = ".$sel_usu[0]));
		
		if($sel_si_es_prof[0]>0){//si es un profesional o un comprador
			$sel_us_emula = query_db("select nombre_administrador from reporte_usuarios_completo where (id_us_profesional is not null or id_us_prof_compras_corp is not null) and email like '%@hocol%' and id_area = ".$sel_usu[9]." and estado =1 group by nombre_administrador");
			
			
			}else{
	$sel_us_emula = query_db("select t2.nombre_administrador from t2_relacion_usuarios_emulan as t1, t1_us_usuarios as t2 where t1.id_us = ".$sel_usu[0]." and t1.id_us_emula = t2.us_id and t2.estado =1 group by t2.nombre_administrador");
			}
		while($sel_emu = traer_fila_db($sel_us_emula)){
		$emula_usuarios.=" - ".$sel_emu[0];
	}
	}
	//EMULACION DE USAURIO
	
	//Presidente
	if($sel_usu[1]==12){$sel_usu[8]="Presidencia";}
	
		if($sel_usu[9]==44 and $sel_usu[1]==15 and $sel_si_es_prof[0]>0){//si es de abastecimineto y es soporte operaciones gerente. y si es profesional  de abastecimiento
			
			$sel_si_es_de_abastecimineto= traer_fila_row(query_db("select count(*) from reporte_usuarios_completo where (id_us_profesional = ".$sel_usu[0]." or id_us_prof_compras_corp = ".$sel_usu[0].") and email like '%@hocol%' and id_area = ".$sel_usu[9]." and estado =1"));//verifica si tiene algun usaurio asignado
			
			if($sel_si_es_de_abastecimineto[0]>0){//si si es un profesional de abastecimineto le argega los emuladores y la linea de soporte operaciones al profeisonal.
				$sql_insert_rol_5 = "insert into temporal_reporte_usuarios (id_us, estado, rol, nombre, email, creacion, inactivacion, area, soporte_desc, gestor_abas, profesional_cyc, comprador, jefatura, gerente_area,vicepresidente, director, presidente, id_rol, id_us_genera,emuladores ) values ('".$sel_usu[0]."','".$sel_usu[2]."','".$sel_usu[3]."','".$sel_usu[4]."','".$sel_usu[5]."','".$sel_usu[6]."','".$sel_usu[7]."','".$sel_usu[8]."','','','','','','','','','','".$sel_usu[1]."','".$_SESSION["id_us_session"]."', '".$emula_usuarios."')";
		$insert = query_db($sql_insert_rol_5);
			}
			
		}else{
			
$sql_insert_rol_5 = "insert into temporal_reporte_usuarios (id_us, estado, rol, nombre, email, creacion, inactivacion, area, soporte_desc, gestor_abas, profesional_cyc, comprador, jefatura, gerente_area,vicepresidente, director, presidente, id_rol, id_us_genera,emuladores ) values ('".$sel_usu[0]."','".$sel_usu[2]."','".$sel_usu[3]."','".$sel_usu[4]."','".$sel_usu[5]."','".$sel_usu[6]."','".$sel_usu[7]."','".$sel_usu[8]."','','','','','','','','','','".$sel_usu[1]."','".$_SESSION["id_us_session"]."', '".$emula_usuarios."')";
		$insert = query_db($sql_insert_rol_5);
			}
	}
	

//------------------FiN Carga tabla temporal-----------------------------*/

?>
<!DOCTYPE html>
<html lang="es">
<head>
	<meta charset="UTF-8">
	<title>Document</title>
	<meta http-equiv="Pragma" content="no-cache" />
	<meta http-equiv="X-UA-Compatible" content="IE=9">
	<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600|Roboto:100" rel="stylesheet">
	<?  $u_agent = $_SERVER['HTTP_USER_AGENT'];//detectar navegador para incluir los estilos correspondientes
   //echo $u_agent;

	$nombre_ie_css = "chips-ms12";

	
    if(preg_match('/MSIE/i',$u_agent) || preg_match('/\Trident\b/',$u_agent) && !preg_match('/Opera/i',$u_agent)) 
    { ?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/<?=$nombre_ie_css?>.css?version=<?=$hora?>" />  
    <?}elseif(preg_match('/\bEdge\b/',$u_agent)) 
    { ?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/<?=$nombre_ie_css?>.css?version=<?=$hora?>" />  
    <?}elseif(preg_match('/Firefox/i',$u_agent))
    {?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/chips-moz.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Chrome/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/chips-webkit.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Safari/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/chips-safari.css?version=<?=$hora?>" />  
    <?} 
    elseif(preg_match('/Opera/i',$u_agent)) 
    {?>
        <link rel="stylesheet" type="text/css" href="../../css/chips/chips-opera.css?version=<?=$hora?>" />  
    <? } 
    else  { 
		?>
         <link rel="stylesheet" type="text/css" href="../../css/chips/chips-webkit.css?version=<?=$hora?>" /> 
    <?
    }
	
?>	
	<link rel="stylesheet" type="text/css" href="../../librerias/materialize/css/materialize.css?version=<?=$hora?>">
	<style>
		body, input, label, table, tr, td, th {
		      font-family: 'Roboto' !important;
		      font-weight: 900;
		}
		.label_for{
		      font-family: 'Roboto' !important;
		      font-weight: 900;
		}
		th, input, label{
		      font-size: 14pt !important;
		      font-family: 'Roboto' !important;
		      font-weight: 900;
		}
		.po_tabla_principal{
			
			border-radius: 10px 10px 10px 10px !important;
		-moz-border-radius: 10px 10px 10px 10px !important;
		-webkit-border-radius: 10px 10px 10px 10px !important;
		border: 0px solid #cccccc !important;
			
			-webkit-box-shadow: 10px 10px 23px -13px rgba(0,0,0,0.75) !important;
		-moz-box-shadow: 10px 10px 23px -13px rgba(0,0,0,0.75) !important;
		box-shadow: 10px 10px 23px -13px rgba(0,0,0,0.75) !important;
			
			border: 1px solid #CCCCCC !important;
			
		}
		.container{
		    text-align:center
		}
		.izquierda{
			display:inline-block;
		    float: left;
		    background:blue
		}
		.derecha{
		    float: right;
		    background:red
		}
		.center{
		    background:green;
		}
	</style>
	
</head>
<body onload="muestra_roles_load();">
	<div class="titulos_secciones" style="font-size:18pt !important; font-weight: 400 !important;">Reporte de Usuarios</div>
	<nav class="nav-extended" style="background: #229BFF !important;">
			<ul class="tabs tabs-transparent">
				<li class="tab"><a onclick="muestra_roles();"><i class="material-icons left">&#xE898;</i>Roles&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;</a></li>
				<li class="tab"><a onclick="muestra_roles_usuarios();"><i class="material-icons left">&#xE898;&#xE7FD;</i>Roles por Usuario</a></li>
				<li class="tab"><a onclick="muestra_usuarios();"><i class="material-icons left">&#xE7FD;</i>Usuarios</a></li>
			</ul>
		</div>
	</nav>
	<div class="row"></div>
	<div id="log" class="col s12" style="display: none;">
		
	</div>
	<div id="carga_sap" style="width: 100% !important; height: height: 960px;">
		
	</div>
	<iframe id="iframe_usuario" src="tabla_usuario_reporte.php" frameborder="0" style="display: none; width: 100%; height: 2400px; border: none;"></iframe>
	<iframe id="iframe_roles_usuarios" src="tabla_roles_usuarios_reporte.php" frameborder="0" style="display: none; width: 100%; height: 2400px; border: none;"></iframe>
	<iframe id="iframe_roles" src="tabla_roles_reporte.php" frameborder="0" style="display: none; width: 100%; height: 2400px; border: none;"></iframe>
	<div id="cargando"></div>
	<input type="hidden" value="" id="function_hidden">
	<input type="hidden" value="" id="key_hidden">
	
	<script type="text/javascript" src="../../librerias/jquery/jquery2.js?version<?=$version_js?>=<?=$version_js?>"></script>
	<script type="text/javascript" src="../../librerias/ajax/ajax_01.js?version<?=$version_js?>=<?=$version_js?>"></script>
	<script type="text/javascript" src="../../librerias/materialize/js/materialize.min.js?version<?=$version_js?>=<?=$version_js?>"></script>
	<script type="text/javascript" src="../../librerias/materialize/js/pickdate_custom.js?version<?=$version_js?>=<?=$version_js?>"></script>
	<script type="text/javascript">
		$(document).ready(function() {
		    $('.modal').modal();
		    $('select').material_select();
		});

		/******
		Unidades de Medida YA
		Grupo de Compras YA
		Retenci&oacute;n de Garant&iacute;as YA
		Centro Log&iacute;stico YA
		Grupo de Articulos
		Indicador de Presupuesto
		Cat&aacute;logo de Servicios
		******/
        function muestra_usuarios(){
        	$('#iframe_usuario').css('display', 'block');


        	$('#iframe_roles_usuarios').css('display', 'none');
        	$('#iframe_roles').css('display', 'none');
        }
        function muestra_roles_usuarios(){
        	$('#iframe_roles_usuarios').css('display', 'block');
			
        	$('#iframe_usuario').css('display', 'none');
        	$('#iframe_roles').css('display', 'none');
        }
        function muestra_roles(){
        	$('#iframe_roles').css('display', 'block');
        	
        	$('#iframe_usuario').css('display', 'none');
        	$('#iframe_roles_usuarios').css('display', 'none');
        }
		function muestra_roles_load(){
        	$('#iframe_roles').css('display', 'block');
		       	
        	$('#iframe_usuario').css('display', 'none');
        	$('#iframe_roles_usuarios').css('display', 'none');
        }
        function muestra_tabla(id,url){
        	//console.log(url)
        	window.parent.document.getElementById('div_carga_busca_sol').style.display='block';
        	$('#div_carga_busca_sol').css('background-color', '#FFFFFF');
  	window.parent.ajax_carga(''+url, 'div_carga_busca_sol');
  	window.parent.document.getElementById('div_carga_busca_sol').innerHTML=''
        }
    </script>
</body>
</html>
  