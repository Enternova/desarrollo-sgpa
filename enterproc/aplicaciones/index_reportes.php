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
    <td class="titulos_procesos">SECCION: REPORTES</td>
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
    
       <p>* &nbsp; <a href="javascript:void(0)" onclick="ajax_carga('../aplicaciones/reporte_01.php','contenidos')">Pedido SIN VISUALIZACI&Oacute;N en la Urna Virtual por parte del proveedor</a><br />
         * &nbsp; <a href="javascript:void(0)" onclick="ajax_carga('../aplicaciones/reporte_02.php','contenidos')">Adjudicaci&oacute;n de Pedido SIN ACEPTACI&Oacute;N en la Urna Virtual por parte del proveedor.</a><br />
         * &nbsp; <a href="javascript:void(0)" >Ordenes de Compra SIN ADJUDICAR al Proveedor</a><br />
         * &nbsp; <a href="javascript:void(0)"  onclick="ajax_carga('../aplicaciones/reporte_04.php','contenidos')">Pedidos que presentan ENTRADA de TEXTO en el &quot;Blog&quot; de la adjudicaci&oacute;n.</a><br />
         * &nbsp; <a href="javascript:void(0)">Pedidos que PRESENTAN MORA en la entrega de los materiales adjudicados</a><br />
         * &nbsp; <a href="javascript:void(0)">Pedidos que estar&iacute;an POR VENCERSE en la entrega de los materiales adjudicados para un rango de fechas futuras</a><br />
        * &nbsp; <a href="javascript:void(0)">Pedidos que presentan ENTREGA PARCIAL de los materiales adjudicados</a>        <p>&nbsp;</p>
        * &nbsp; <a href="javascript:void(0)"  onclick="ajax_carga('../aplicaciones/reportes/re1.php','contenidos')">Estado de procesos</a>       </p>
       <p>&nbsp;</p>
       <p><br />
       </p>
    </td>
  </tr>
</table>
</div>
<div id="contenido_aux_sub"></div>

<input type="hidden" name="id_limpia" />

</body>
</html>
