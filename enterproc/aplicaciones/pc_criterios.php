<? include("../librerias/lib/@session.php");

	$id_invitacion_limpio = $id_invitacion;
	$termino_limpio = $termino;
	$id_ds_id_limpio = $ds_id;		
	
	
	echo $id_invitacion = elimina_comillas(arreglo_recibe_variables($id_invitacion));
	echo $termino = elimina_comillas($termino);
	echo $ds_id = elimina_comillas($ds_id);

if($accion=="crea_grupo_evaluacion")
	{
		if($ds_id1>=1)
			{
				$cambia = query_db("update $t90 set rel10_detalle  = '$valorgrupo' where rel10_id  = $ds_id1");
				?>
					<script>
						//alert("la condición se modifico exito")
						window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'la condición se modificó éxito', 20, 10, 18);
						window.opener.location.href='configuracion_criterios_<?=$id_invitacion_limpio;?>_<?=$termino;?>.php';
					</script>

				<?
				
			}	
		
		else
			{
				$cambia = query_db("insert into $t90 (rel9_id , rel10_detalle , rel10_estado ) values ($ds_id, '$valorgrupo',1 )");
				?>
					<script>
						//alert("La condición se creó exito")
						window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'la condición se modificó éxito', 20, 10, 18);
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
 <form name="formulario" method="post" action="configuracion_criterioscsug.php" enctype="multipart/form-data" >

<table width="90%" border="0" cellpadding="0" cellspacing="5">
  <tr> 
      
      <td class="titulos_procesos"> CONFIGURACION DE CRITERIOS DE EVALUACI&Oacute;N</td>
    </tr>
  </table>  
  
<table width="90%" border="0" cellpadding="1" cellspacing="1">
  <tr>
    <td width="96%"><div align="right">
        <input name="Submit" type="button" class="guardar" value="Guardar Informacion" onClick="configura_desempenon()">
      </div></td>
    <td width="4%"><div align="right">
        <input name="Submit2" type="button" class="cancelar" value="Cerrar Ventana" onClick="window.close()">
      </div></td>
  </tr>
</table>
  <table width="90%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
    <tr class="administrador_tabla_titulo"> 
      <td width="46%" class="titulo_tabla_azul_sin_bordes">CRITERIOS DE EVALUACION</td>
    </tr>
    <?
	$lista_licitaciones = "select * from $t90 where  rel10_id  = $ds_id1";
	$linvi=traer_fila_row(query_db($lista_licitaciones));

?>
    <tr> 
      <td align="center"><div align="center"><strong> 
        <input name="valorgrupo" type="text" value="<?=$linvi[2];?>" size="50">
      </strong> </div></td>
    </tr>
  </table>
<br>

<input type="hidden" name="ds_id1" value="<?=$ds_id1;?>">

<input type="hidden" name="ds_id" value="<?=$id_ds_id_limpio;?>">
<input type="hidden" name="termino" value="<?=$termino_limpio;?>">
<input type="hidden" name="id_invitacion" value="<?=$id_invitacion_limpio;?>">



<input type="hidden" name="accion">
</form>
<iframe name="grp" height="0" width="0"></iframe>

</body>
</html>
