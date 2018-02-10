<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
    verifica_menu("procesos.html");

	$busca_proveedor = traer_fila_row(query_db("select * from $t8 where pv_id = ".$_SESSION["id_proveedor"]));

?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../css/principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
  
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">SOLICITUD DE SOPORTE TECNICO</td>
  </tr>
</table>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
  <tr>
    <td colspan="2" >Por favor complete el siguiente formulario y lo contactaremos en el menor tiempo posible.</br>
      <span class="texto_paginador_proveedor">
        <?=$error_soporte;?>
      </span></td>
  </tr>
  <tr>
    <td width="35%" align="right" >Persona de contacto:</td>
    <td width="65%" ><input type="text" name="nombre_solicita" id="nombre_solicita"  value="<?=$nombre_solicita;?>"/></td>
  </tr>
  <tr>
    <td align="right" >Tel&eacute;fono de contacto:</td>
    <td ><input type="text" name="telefono" id="telefono"  value="<?=$telefono;?>"/></td>
  </tr>
  <tr>
    <td align="right" >E-mail de contacto:</td>
    <td ><input type="text" name="email" id="email"  value="<?=$email;?>"/></td>
  </tr>
  <tr>
    <td align="right" >Detalle de la solicitud:</td>
    <td >&nbsp;</td>
  </tr>
  <tr>
    <td colspan="2" ><textarea name="mensaje" id="mensaje" cols="45" rows="5"><?=$mensaje;?></textarea></td>
  </tr>
  <tr>
    <td colspan="2" align="center" ><input name="button2" type="button" onClick="envia_soporte()"class="guardar" id="button2" value="Enviar solicitud de soporte" /></td>
  </tr>
</table>
<br>
<table width="95%" border="0" align="center" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
  <tr>
    <td><table width="100%" border="0" cellspacing="2" cellpadding="2">
      <tr>
        <td width="198" class="columna_subtitulo_resultados"><div align="center">Contacto</div></td>
        <td width="128" class="columna_subtitulo_resultados"><div align="center">Fecha</div></td>
        <td width="506" class="columna_subtitulo_resultados"><div align="center">Detalle</div></td>
        <td width="80" class="columna_subtitulo_resultados"><div align="center">Admin.</div></td>
      </tr>
      <?  
              	$link_sql = mssql_connect($host_sql,$usr_sql,$pwd_sql);
			$sel_sql = mssql_select_db($dbbase_sql,$link_sql);
			
                $busca_procesos = "select *
                 from help_solicitudes where pv_id = $busca_proveedor[0]	";
                $sql_ex = mssql_query($busca_procesos);
                while($ls=mssql_fetch_row($sql_ex)){
            
                      if($num_fila%2==0)
                            $class="campos_blancos_listas";
                        else
                            $class="campos_gris_listas";
            
              ?>
      <tr class="<?=$class;?>">
        <td><?=$ls[2];?></td>
        <td><?=fecha_for_hora($ls[8]);?></td>
        <td><?=$ls[6];?></td>
        <td><input name="button4" type="button" class="buscar" id="button4" value="Ingresar" onclick="ajax_carga('soporte_detallado_<?=$ls[0];?>.html','contenidos')" /></td>
      </tr>
      <tr class="<?=$class;?>">
        <td colspan="2"></td>
        <td colspan="2" id="contrase_<?=$ls[0];?>"></td>
      </tr>
      <? $num_fila++; $encontrados++; 
              }// while
              
               ?>
    </table></td>
  </tr>
</table>
     <p>
       <input type="hidden" name="tp17_id" value="5">
       <input type="hidden" name="razon_social" value="<?=$busca_proveedor[3];?>">
       <input type="hidden" name="ciuadad" value="<?=$busca_proveedor[1];?>">
        <input type="hidden" name="pv_id" value="<?=$busca_proveedor[0];?>">
</p>
</body>
</html>
