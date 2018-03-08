<? header("Content-type: application/octet-stream");//indicamos al navegador que se está devolviendo un archivo
header("Content-Disposition: attachment; filename=Reporte de Reemplazos.xls");//con esto evitamos que el navegador lo grabe en su caché
header("Pragma: no-cache");
header("Expires: 0");

/*include("../../librerias/lib/@include.php");*/
include("../../librerias/lib/@config.php");
   include(SUE_PATH."global.php");

   include("../../librerias/php/funciones_general.php");
   
   
   $explode = explode("----,",$_GET["usuario_permiso"]);
	$id_usuario_ausente = $explode[1];
	$explode2 = explode("----,",$_GET["usuario_permiso2"]);
	$id_usuario_reemplaza = $explode2[1];
	
	$fecha_inicial = $_GET["fecha1"];
	$fecha_final = $_GET["fecha2"];
	
	
	if($id_usuario_ausente > 0){
		$comple.= " and us_ausente_id = ".$id_usuario_ausente;
		}
	if($id_usuario_reemplaza > 0){
		$comple.= " and us_reemplaza_id = ".$id_usuario_reemplaza;
		}
	if($fecha_inicial != ""){
		$comple.= " and fecha_creacion >= '".$fecha_inicial."'";
		}
	if($fecha_final != ""){
		$comple.= " and fecha_creacion <= '".$fecha_final."'";
		}
	
	
	
   
   ?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<head>

<title>Documento sin t&iacute;tulo</title>

<style>
.fondo_3{ background:#005395; color:#FFFFFF;}
</style>
<body>
<table width="100%" border="1" class="tabla_lista_resultados">
  <tr class="fondo_3">
    <td align="center">Funcionario Ausente</td>
    <td align="center">Funcionario que lo Reemplaza</td>
    <td align="center">Desde Cuando</td>
    <td align="center">Hasta Cuando</td>
    <td align="center">Observacion</td>
    <td align="center">Usuario que creo el Reemplazo</td>
    <td align="center">Fecha Log de Creacion</td>
  </tr>
  <?

		
            $sel_remplazos = query_db("select us_ausente, us_reemplaza, desde_cuando, hasta_cuando, CAST(observacion as TEXT), usuario_creacion, fecha_creacion from v_reemplazos where us_ausente_id > 0 $comple order by id desc");
			while($sel_rem = traer_fila_db($sel_remplazos)){
				
				if($class == ""){
					$class = 'class="filas_resultados"';
					}else{
						$class = '';
						}
			?>
  <tr <?=$class?>>
    <td align="center"><?=$sel_rem[0]?></td>
    <td align="center"><?=$sel_rem[1]?></td>
    <td align="center"><?=$sel_rem[2]?></td>
    <td align="center"><?=$sel_rem[3]?></td>
    <td align="center"><?=$sel_rem[4]?></td>
    <td align="center"><?=$sel_rem[5]?></td>
    <td align="center"><?=$sel_rem[6]?></td>
  </tr>
  <?
			}
			?>
</table>
</body>
</html>
