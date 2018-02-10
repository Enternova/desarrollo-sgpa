<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$id_item_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_item_pecc"]));
	$id_tipo_proceso_pecc = elimina_comillas(arreglo_recibe_variables($_GET["id_tipo_proceso_pecc"]));
	$sel_item = traer_fila_row(query_db("select * from $pi2 where id_item=".$id_item_pecc));
	
	
	
	
	
	?>

<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title>Documento sin t&iacute;tulo</title>
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" /></head>

<body>

<table width="100%" border="0" cellpadding="2" cellspacing="2">
  <tr>
    <td colspan="2" valign="top"><?=encabezado_item_pecc($id_item_pecc)?></td>
  </tr>
  <tr>
    <td width="77%" valign="top"><table width="100%" border="0" align="center" class="tabla_lista_resultados">
      <tr>
        <td width="54%" valign="top">
        
        </td>
      </tr>
      <tr>
        <td width="54%" valign="top"><div id="carga_anexos">
        
          
          <table width="100%" border="0" align="center"  class="tabla_lista_resultados">
            <tr>
              <td colspan="4" align="center"  class="fondo_3">Ordenes de Trabajo Relacionadas a esta Ampliaci&oacute;n</td>
            </tr>
            <tr>
              <td width="20%" align="center" class="fondo_3">Numero de Orden</td>
              <td width="30%" align="center" class="fondo_3">Gerente de la OT</td>
              <td width="23%" align="center" class="fondo_3">Profesional de C&amp;C</td>
              <td width="27%" align="center" class="fondo_3">Estado</td>
            </tr>
            <?
            $sel = query_db("select id_ot, id_item_ots_aplica, gerente_ot, profesional, num1, num2, num3, estado, id_estado from vista_ots_relacionadas where id_item_ots_aplica = ".$id_item_pecc." group by id_ot, id_item_ots_aplica, gerente_ot, profesional, num1, num2, num3, estado, id_estado");
			while($s = traer_fila_db($sel)){
			?>
            
            <tr>
              <td align="center" ><strong onClick="abrir_ventana('../aplicaciones/comite/pecc/impresion-ots.php?id_item_pecc=<?=$s[0]?>&id_presupuesto=0')" class="titulo_calendario_real_bien"><?=numero_item_pecc($s[4], $s[5], $s[6])?></strong></td>
              <td align="center" ><?=$s[2]?></td>
              <td align="center" ><?=$s[3]?></td>
              <td align="center" ><? if($s[8] == 16) {echo "En Aprobacion";} if($s[8] == 31) {echo "En Creacion";} if($s[8] == 6) {echo "En Completamiento";} if($s[8] > 19 and $s[8] < 30) {echo "En Legalizacion";} if($s[8] == 32) {echo "Legalizada";}?></td>
            </tr>
            <?
			}
			?>
          </table>
          <p>&nbsp;</p>
        </div></td>
      </tr>
      
    </table>
    
    
    </td>
    <td width="23%" valign="top"><?=carga_sub_menu_peec($id_item_pecc,$id_tipo_proceso_pecc)?></td>
  </tr>
</table>
<input type="hidden" name="id_item_pecc" id="id_item_pecc" value="<?=$id_item_pecc?>" />
<input type="hidden" name="id_tipo_proceso_pecc" id="id_tipo_proceso_pecc" value="<?=$id_tipo_proceso_pecc?>" />

</body>
</html>
