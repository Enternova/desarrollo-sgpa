<? include("../../librerias/lib/@session.php"); 
	verifica_menu("administracion.html");
	header('Content-Type: text/xml; charset=ISO-8859-1');
	echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	
	
	$optin_comite = 'N/A <input name="comite_add" type="hidden" id="comite_add" value="2" />';
	$optin_sondeo = 'N/A <input name="sondeo" type="hidden" id="sondeo" value="2" />';
	$optin_socios = '<select name="socios" id="socios">
      <option value="2">NO</option>
	  <option value="1">SI</option></select>';
	  
	if($_GET["tipo_proceso"] == 1){
		$optin_valor = '<select name="montos" id="montos">
					      <option value="500000">0 a 500.000</option>
					      <option value="500001">500.001 a inf.</option>
					    </select>';
		}
	if($_GET["tipo_proceso"] == 2){
		$optin_valor = '<select name="montos" id="montos">
					      <option value="200000">0 a 200.000</option>
					      <option value="200001">200.001 a inf.</option>
					    </select>';
		$optin_sondeo='<select name="sondeo" id="sondeo">
      <option value="2">NO</option>
      <option value="1">SI</option>
      </select>';
		}
	
	if($_GET["tipo_proceso"] == 3 or $_GET["tipo_proceso"] == 4 or $_GET["tipo_proceso"] == 6){
		$optin_valor = '<select name="montos" id="montos">
					      <option value="200000">0 a 200.000</option>
					      <option value="200001">200.001 a inf.</option>
					    </select>';
		}
	if($_GET["tipo_proceso"] == 5){
		$optin_valor = '<select name="montos" id="montos">
					      <option value="200000">0 a 200.000</option>
					      <option value="200001">200.001 a inf.</option>
					    </select>';
		$optin_sondeo='<select name="sondeo" id="sondeo">
      <option value="2">NO</option>
      <option value="1">SI</option>
      </select>';
		}
	if($_GET["tipo_proceso"] == 7){
		$optin_valor = 'N/A <input name="montos" type="hidden" id="montos" value="1" />';
		$optin_sondeo='<select name="sondeo" id="sondeo">
      <option value="2">NO</option>
      <option value="1">SI</option>
      </select>';
		}
	
	if($_GET["tipo_proceso"] == 8){
		$optin_valor = 'N/A <input name="montos" type="hidden" id="montos" value="1" />';
		
		$optin_comite = '<select name="comite_add" id="comite_add">
      <option value="2">NO</option>
	  <option value="1">SI</option>      
    </select>';
		$optin_socios = 'N/A <input name="socios" type="hidden" id="socios" value="2" />';
		}
		
	if($_GET["tipo_proceso"] == 9 or $_GET["tipo_proceso"] == 10 or $_GET["tipo_proceso"] == 11){
		$optin_valor = 'N/A <input name="montos" type="hidden" id="montos" value="1" />';		
		}
	
	?>
    <link href="../../css/estilo-principal.css" rel="stylesheet" type="text/css" />
    <table width="100%" border="0" class="">
  <tr>
    <td width="49%" align="right">Aplica sondeo:</td>
    <td width="51%" align="left"><?=$optin_sondeo?></td>
  </tr>
  <tr>
    <td align="right">Aplica aprobaci&oacute; de comit&eacute; adicional:</td>
    <td align="left"><?=$optin_comite?></td>
  </tr>
  <tr>
    <td align="right">Montos en USD:</td>
    <td align="left"><?=$optin_valor;?></td>
  </tr>
 <tr>
    <td align="right">Procesos con aprobaci&oacute;n de socios:</td>
    <td align="left"><?=$optin_socios;?></td>
  </tr>
</table>
