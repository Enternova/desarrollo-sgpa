<? include("../../librerias/lib/@session.php");
	header('Content-Type: text/xml; charset=ISO-8859-1');
    echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

$sel = traer_fila_row(query_db("select * from  t1_campo where t1_campo_id = ".$_GET["id"]));

?>



<html>
<head>
<title>Datos Cliente</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
</head>
<body >
  
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_secciones">Editar Area / Proyecto</td>
  </tr>
</table>
<br>


<table width="100%" border="0">
  <tr>
    <td align="right">Nombre:</td>
    <td><input type="text" name="nombre" id="nombre" value="<?=$sel[2]?>" /></td>
  </tr>
  <tr>
    <td align="right">Naturaleza:</td>
    <td><select name="naturaleza" id="naturaleza">
    <option value="2" <? if($sel[1]==2) echo 'selected'?> >Corporativo</option>
    <option value="1" <? if($sel[1]==1) echo 'selected'?>>Socios</option>
    </select></td>
  </tr>
  <tr>
    <td align="right">Autonomia Socios en USD$:</td>
    <td>
    <?
	$monto_socios="";
    if($sel[4]<>"99999999999"){$monto_socios=number_format($sel[4],0);}
	?>
    <input name="valor_usd" type="text" id="valor_usd" size="5" value="<?=$monto_socios?>" onKeyUp="puntitos(this,this.value.charAt(this.value.length-1))"/></td>
  </tr>
  <tr>
    <td align="right">Estado:</td>
    <td><select name="estado" id="estado">
    <option value="1" <? if($sel[3]==1) echo 'selected'?> >Activo</option>
    <option value="2" <? if($sel[3]==2) echo 'selected'?>>Inactivo</option>
    </select></td>
  </tr>
  <tr>
    <td width="28%">&nbsp;</td>
    <td width="72%"><input type="button" name="s" value="Editar Area / Proyecto" class="boton_grabar" onClick="edita_area_proyecto()" style="cursor:pointer" /></td>
  </tr>
</table>
<br />
<input type="hidden" name="id" id="id" value="<?=$_GET["id"]?>"/>  
  

</p>
</body>
</html>
