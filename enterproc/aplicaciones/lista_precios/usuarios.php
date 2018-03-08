<?   include("../../librerias/lib/@session.php");
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	


if($session_compra==""){

$alfabeto = array("A","B","C","D","E","F", "G","H","I","J","K","L","M","N","P","Q","R","S","T","U","V", "W","X","Y","Z","1","2","3", "4","5","6","7","8","9");
for($i=0;$i<=15;$i++){
$generador = rand(0,34);
$fuente2.= $alfabeto[$generador];
$session_compra.= $alfabeto[$generador];

}

}
	
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html;  charset=iso-8859-1" />
<title><?=TITULO;?></title>
<link href="../../css/principal.css" rel="stylesheet" type="text/css" />
</head>

<body>
<div id="popup2" align="center"><div id="pContent"></div></div>
<table width="100%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td class="titulos_procesos">CONFIGURACION DE USUARIOS EN LA LISTA DE PRECIOS ACORDADAS</td>
  </tr>
</table>
<br /><br />
<fieldset style="width:98%">
			<legend>Crear usuario en las listas</legend>
<table width="95%" border="0" cellspacing="3" cellpadding="3">
  <tr>
    <td colspan="6"></td>
  </tr>
  
  <tr>
    <td width="17%"><strong>Buscar usuarios:</strong></td>
    <td colspan="3"><div align="left">
      <label></label>
      <input name="b_usuarios" type="text" id="b_usuarios" size="50" onkeypress="selecciona_lista()" />
    </div></td>
    <td width="16%"><strong>Periocidad:</strong></td>
    <td width="45%"><label>
      <div align="left">
        <select name="periocidad" id="periocidad">
          <option value="0">seleccione</option>
          <option value="Diaria">Diaria</option>
          <option value="Mensual">Mensual</option>
          <option value="Anual">Anual</option>
        </select>
      </div>
    </label></td>
  </tr>
  <tr>
    <td ><strong>Lista:</strong></td>
    <td colspan="3"><div align="left">
      <label>
      <select name="lista_c" id="lista_c">
        <?=listas($l1, 1,$sql_e[4],'nombre', 1);?>
      </select>
      </label>
    </div></td>
    <td><strong>Monto:</strong></td>
    <td><label>
      <div align="left">
        <input type="text" name="monto" id="monto" />
      </div>
    </label></td>
  </tr>
</table>
<br />
<table width="95%" border="0" cellspacing="2" cellpadding="2">
  <tr>
    <td><div align="center"><input name="button2" type="button" class="guardar" id="button2" value="Grabar informaci&oacute;n" onclick="crea_usuario_lista()" />
      </div>
    </label></td>
  </tr>
</table>
</fieldset>

<br />
<fieldset style="width:98%">
			<legend>Usuarios creados</legend>

            <table width="98%" border="0" cellpadding="2" cellspacing="2" class="tabla_lista_resultados">
              <tr>
                <td width="35%" class="columna_titulo_resultados"><div align="center">Usuario</div></td>
                <td width="32%" class="columna_titulo_resultados"><div align="center">Lista</div></td>
                <td width="15%" class="columna_titulo_resultados"><div align="center">Periocidad</div></td>
                <td width="18%" class="columna_titulo_resultados"><div align="center">Monto</div></td>
              </tr>
              <?
			  	$busca_provee = "select $l3.lista3_id, $t1.nombre_administrador, $l1.nombre, $l3.periocidad , $l3.monto_maximo  from $t1, $l1, $l3
				where $t1.us_id = $l3.us_id and $l1.lista1_id = $l3.lista1_id and $l3.estado = 1 ";
				
				$busca_lista = query_db($busca_provee);
				
				 
				while($lp = traer_fila_row($busca_lista)){
			  
	  	$categorias.=", ".$lp[7];
	  
		  	if($num_fila%2==0)
				$class="campos_blancos_listas";
			else
				$class="campos_gris_listas";
  ?>
              <tr class="<?=$class;?>">
                <td><div align="left">
                    <?=$lp[1];?>
                </div></td>
                <td><div align="left">
                  <?=$lp[2];?>
                </div></td>
                <td><div align="left">
                  <?=$lp[3];?>
                </div></td>
                <td>
                  <?=number_format($lp[4],0);?>
                </td>
                <?	$total_linea = ($lp[3]*$lp[6]);
					$total+=($total_linea);
					?>
              </tr>
            
              <? $num_fila++;} ?>
            </table>
</body>
</html>
