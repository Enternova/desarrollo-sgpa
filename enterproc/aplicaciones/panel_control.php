<?   include("../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

//paguinacion

if($nombre!="")
	$com_p.=" and pv_nombre like '%$nombre%'";
if($email!="")
	$com_p.=" and pv_email like '%$email%'";
if($nit!="")
$com_p.=" and pv_nit like '%$nit%'";
  

$numero_pagi = 50;
if ($pag=="")
	$pag = 1;
else
	$pag = $pag;

$paginador = (($pag-1)*$numero_pagi);


	  $li_n_c=traer_fila_row(query_db("select count(*) 
	 from $v2 where 1 $com_p  "));
		  $total_r = $li_n_c[0];
		  $pagina = ceil($total_r /$numero_pagi);

if($pag==($pagina))
	$proxima = $pag;
else
	$proxima = $pag +1;
	
if($pag==1)
	$anterior = $pag;
else
	$anterior = $pag -1;
	
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<title><?=TITULO;?></title>
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="contenido_aux">
<table width="99%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">SECCION: PANEL DE CONTROL</td>
  </tr>
</table>

<br />

<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_evaluacion">Administraciones permitidas</td>
  </tr>
</table>
<table width="100%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td>
     <? if($_SESSION["id_us_session"]!=18122){ ?>
       * &nbsp; <a href="javascript:void(0)" onclick="ajax_carga('../aplicaciones/historico_usuario.php','contenidos')">Administrar usuarios</a><br />
       * &nbsp; <a href="javascript:void(0)" onclick="ajax_carga('../aplicaciones/admin_maestras.php?tabla=tp6_tipo_objetos&campo_id=tp6_id&titulo_maestra=OBJETO A CONTRATAR','contenidos')">Administrar objeto a contratar</a><br />
       * &nbsp; <a href="javascript:void(0)" onclick="ajax_carga('../aplicaciones/admin_maestras.php?tabla=tp2_tipo_proceso&campo_id=tp2_id&titulo_maestra=TIPO DE PROCESO','contenidos')">Administrar tipo de proceso</a><br />
       * &nbsp; <a href="javascript:void(0)" onclick="ajax_carga('../aplicaciones/admin_maestras.php?tabla=tp5_tipo_contrato&campo_id=tp5_id&titulo_maestra=TIPO DE CONTRATO','contenidos')">Administrar tipo de contrato</a><br />
       * &nbsp; <a href="javascript:void(0)" onclick="ajax_carga('../aplicaciones/admin_maestras.php?tabla=tp4_regimen_contratacion&campo_id=tp4_id&titulo_maestra=ORIEN DE LA SOLICITUD','contenidos')">Administrar origen de solicitud</a><br />
	<? } ?>
      * &nbsp; <a href="javascript:void(0)" onclick="ajax_carga('../aplicaciones/evaluacion/adjudicacion_admin_plantillas.php','contenidos')" >Administrar plantillas de contactos de adjudicaci&oacute;n</a><br />
    </td>
  </tr>
</table>
</div>
<div id="contenido_aux_sub"></div>

<input type="hidden" name="id_limpia" />

</body>
</html>
