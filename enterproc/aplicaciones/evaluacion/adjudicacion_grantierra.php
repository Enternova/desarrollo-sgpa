<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    //verifica_menu("procesos.html");

//$id_invitacion = arreglo_recibe_variables($id_invitacion_pasa);
	
	
	$id_invitacion = $id_invitacion;
	$busca_procesos = "select * from $t5 where pro1_id = $id_invitacion";
	$sql_e=traer_fila_row(query_db($busca_procesos));

	$busca_confirmacion = traer_fila_row(query_db("select * from $t9 where  pro1_id = $id_invitacion and pv_id = ".$_SESSION["id_proveedor"]." order by fecha desc"));

?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/principal.css" rel="stylesheet" type="text/css">
</head>
<body >
  
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">ADJUDICACIO DEL PROCESO</td>
  </tr>
</table>

</p>
<fieldset style="width:98%">
			<legend>Proveedores </legend>

<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
              <tr>
                <td width="10%" class="titulo_tabla_azul_sin_bordes">Nit</td>
                <td width="19%" class="titulo_tabla_azul_sin_bordes">Nombre</td>
                <td width="15%" class="titulo_tabla_azul_sin_bordes">Fecha y hora de cierre</td>
                <td width="21%" class="titulo_tabla_azul_sin_bordes">Fecha y hora recibo de ofertas</td>
                <td width="21%" class="titulo_tabla_azul_sin_bordes">Valor</td>
                <td width="21%" class="titulo_tabla_azul_sin_bordes">Comentarios</td>
              </tr>
              
              <?
			  	$busca_provee = query_db("select $t8.pv_id, $t8.nit, $t8.razon_social, $t8.telefono, $t8.email, $t8.estado_rup from $t8, $t7 where
				$t7.pro1_id =  $id_invitacion and $t8.pv_id = $t7.pv_id");
				while($lp = traer_fila_row($busca_provee)){
			  
				$busca_confirmacion_participacion = traer_fila_row(query_db("select count(*) from $t9 where pv_id = $lp[0]  and estado = 1 and confirmacion  = 1 "));				
	  
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";

			$buscar_resultado =  traer_fila_row(query_db("select * from evaluador10_calificacion_obtenida  where pv_id = $lp[0] and proc1_id = $id_invitacion"));
				
  ?>
  <tr class="<?=$class;?>">
    <td><?=$lp[1];?></td>
                <td><?=$lp[2];?></td>
                <td><?=$lp[3];?></td>
                <td><?=$lp[4];?></td>
                <td>&nbsp;</td>
                <td>&nbsp;</td>
  </tr>
              <? $num_fila++;} ?>
            </table>
<br>
<br>
<table width="95%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td><div align="center">
      <input name="button" type="button" class="guardar" id="button" value="Grabar estado del proceso" onClick="adjudicacion()">
    </div></td>
  </tr>
</table>
<br />
</fieldset>

<fieldset style="width:98%">
<div id="carga_evaluacion"></div>
</fieldset>

<br>
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion;?>">
<input type="hidden" name="id_invitacion_pasa" value="<?=$id_invitacion;?>">

<input type="hidden" name="id_anexo">
</body>
</html>
