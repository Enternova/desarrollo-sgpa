<? include("../librerias/lib/@session.php");

	$id_invitacion_limpio = $id_invitacion;
	$termino_limpio = $termino;
	$id_ds_id_limpio = $ds_id;		
	
	
	$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_invitacion));
	$termino = elimina_comillas($termino);
	$ds_id = elimina_comillas($ds_id);

$busca_fechas = traer_fila_row(query_db("select  tp6_id from $t5 where pro1_id = $id_invitacion"));

if($accion=="crea_grupo_evaluacion")
	{
		if($ds_id>=1)
			{
				$cambia = query_db("update $t89 set rel9_detalle  = '$valorgrupo' where rel9_id = $ds_id");
				?>
					<script>
						//alert("El grupo se modifico exito")
						window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El grupo se modifico éxito', 20, 10, 18);
						window.opener.location.href='tabla_criterios_sencilla.php?id_invitacion=<?=$id_invitacion;?>&termino=<?=$termino;?>';
					</script>

				<?
				
			}	
		
		else
			{
				$cambia = query_db("insert into $t89 (cl_id,  rel9_detalle,  rel9_estado,rel9_aspecto, tp6_id ) values (1,'$valorgrupo',1,$termino, $busca_fechas[0] )");
				?>
					<script>
						//alert("El grupo se creó exito")
						window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'El grupo se creó éxito', 20, 10, 18);
						window.opener.location.href='configuracion_criterios_<?=$id_invitacion_limpio;?>_<?=$termino;?>.php';
					</script>

				<?
				
			
			}	
	
	  
	}

?>
<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
<script language="JavaScript" type="text/javascript" src="../librerias/js/procesos.js"></script>


</head>
<body >
 <form name="formulario" method="post" action="configuracion_criterioscg.php" enctype="multipart/form-data" >

<table width="90%" border="0" cellpadding="0" cellspacing="5">
  <tr> 
      
      <td class="titulos_procesos"> CONFIGURACION DE GRUPOS DEL AYUDANTE DE CLASIFICACI&Oacute;N DE OFERTAS</td>
    </tr>
  </table>  
  
<table width="90%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td width="96%"><div align="right">
        <input name="Submit" type="button" class="guardar" value="Guardar Informaci&oacute;n" onClick="configura_grupo_evaluacion()">
      </div></td>
    <td width="4%"><div align="right">
        <input name="Submit2" type="button" class="cancelar" value="Cerrar Ventana" onClick="window.close()">
      </div></td>
  </tr>
</table>
  <table width="90%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
    <tr class="administrador_tabla_titulo">
      <td colspan="2" class="titulo_tabla_azul_sin_bordes">GRUPO DE CRITERIOS DE EVALUACION</td> 
    </tr>
    <?
	$lista_licitaciones = "select * from $t89 where cl_id = $us_cliente and rel9_estado=1 and rel9_id  = $ds_id";
	$linvi=traer_fila_row(query_db($lista_licitaciones));

?>
    <tr>
      <td width="46%" align="center"><div align="right"><strong>Detalle del Criterio:</strong></div></td> 
      <td width="46%" align="center"><div align="left"><strong> 
        <input name="valorgrupo" type="text" value="<?=$linvi[2];?>" size="50">
      </strong> </div></td>
    </tr>
  </table>
<br>
<input type="hidden" name="ds_id" value="<?=$id_ds_id_limpio;?>">
<input type="hidden" name="accion">
<input type="hidden" name="termino" value="<?=$termino_limpio;?>">

<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_limpio;?>">



</form>
<iframe name="grp" height="0" width="0"></iframe>

</body>
</html>
