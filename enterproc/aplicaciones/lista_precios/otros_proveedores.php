<?   include("../../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	



	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<title><?=TITULO;?></title>
<link href="../../css/principal.css" rel="stylesheet" type="text/css" />
<style type="text/css">
<!--
.Estilo1 {font-weight: bold}
-->
</style>
</head>

<body>
<table width="69%" border="0" cellpadding="2" cellspacing="2" class="tabla_borde_azul_fondo_blanco">
<tr  class="titulo_tabla_azul_sin_bordes">
                <td width="49%" ><div align="center" class="titulo_tabla_azul_sin_bordes">Proveedor</div></td>
                <td width="15%" ><div align="center" class="titulo_tabla_azul_sin_bordes">D&iacute;as</div></td>
                <td width="16%" ><div align="center" class="titulo_tabla_azul_sin_bordes">Valor</div></td>
                <td width="20%" ><div align="center" class="titulo_tabla_azul_sin_bordes">Cambiar proveedor<div align="center"></div></td>
              </tr>
              
              <?
			  
		  
			  	 $busca_provee = "select $l6.lista6_id, $l6.valor, $l6.dias_entrega, $t8.razon_social
				from  $l6, $t8 where
				$l6.lista2_id  = '$id_articulo' and
				$t8.pv_id = $l6.pv_id 
				order by $t8.razon_social ";
				
				$busca_lista = query_db($busca_provee);
				
				 
				while($lp = traer_fila_row($busca_lista)){
			  
	  	
	  
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
  ?>
  <tr class="<?=$class;?>">
  
    <td><div align="left"><?=$lp[3];?></div></td>
                <td><div align="center"><?=$lp[2];?></div></td>
                <td><div align="right"><?=number_format($lp[1],0);?></div></td>
                <td><div align="center">
                  <input name="button2" type="button" class="guardar" id="button2" value="Cambiar proveedor"  onclick="cambia_proveedor_lista(<?=$lp[0];?>)"/>
                </div></td>
              </tr>
  <tr class="<?=$class;?>">
    <td colspan="4"></td>
    </tr>

              <? $num_fila++;} ?>            
            </table>
           
           
<table width="69%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><label>
      <div align="right">
        <input name="button" type="button" class="cancelar" id="button" value="Cerrar"  onclick="cerrar_proveedores_lista()"/>
        </div>
    </label></td>
  </tr>
</table>

<input type="text" name="id_articulo_cambia_proveedor" value="<?=$id_articulo;?>" />



</body>
</html>
