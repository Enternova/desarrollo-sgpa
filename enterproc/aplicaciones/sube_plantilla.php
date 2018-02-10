<?
include("../librerias/lib/@session.php");
require_once '../librerias/php/Excel/reader.php';
$id_vari=$id_invitacion;
		$id_invitacion = elimina_comillas(arreglo_recibe_variables($id_vari));

$filename = $archivo_lista;



if($filename!= ''){// SI EL ARCHIVO EXISTE

$data = new Spreadsheet_Excel_Reader();
$data->setOutputEncoding('CP1251');
$data->read($filename);


$cuenta_archivo=0;
$cuenta_buenos=0;

for ($i = 2; $i <= $data->sheets[0]['numRows']; $i++) {

$lista_articulos = "insert into $t95 (in_id, evaluador5_codigo, evaluador5_detalle, evaluador5_unidad,
  evaluador5_cantidad,  evaluador5_moneda,  evaluador5_valor,  evaluador5_presupuesto, pro11_id ) values ($id_invitacion, '".$data->sheets[0]['cells'][$i][1]."','".$data->sheets[0]['cells'][$i][2]."','
  ".$data->sheets[0]['cells'][$i][3]."','".$data->sheets[0]['cells'][$i][4]."','".$data->sheets[0]['cells'][$i][5]."','".$data->sheets[0]['cells'][$i][6]."'
  ,'".$data->sheets[0]['cells'][$i][7]."',$id_lista)";

  		$graba_proveedor=query_db($lista_articulos);
		$id_graba = id_insert(); 
		if($id_graba>=1)
			$cuenta_buenos++;

	$cuenta_archivo++;  
  }
	?>
    	<script>
			var archivos_entregados = '<?=$cuenta_archivo;?>';
			var archivos_subidos = '<?=$cuenta_buenos;?>';
			if(archivos_subidos < archivos_entregados)
            window.parent.muestra_alerta_error_solo_texto('', 'Error', 'No se logro subir todos los registros *Total Registros Entregados:' + archivos_entregados + '* Total Archivos Subidos: ' + archivos_subidos, 40, 8, 12);
				//alert("ATENCIÓN:\n         No se logro subir todos los registros !\n         Total Registros Entregados:" + archivos_entregados + "\n         Total Archivos Subidos: " + archivos_subidos)
			if(archivos_subidos = archivos_entregados)
				window.parent.muestra_alerta_iformativa_solo_texto('', 'Mensaje', 'Los registros del archivo se subieron con éxito * Total Registros Entregados:' + archivos_entregados + '* Total Archivos Subidos: ' + archivos_subidos, 40, 8, 12);
				//alert("Los registros del archivo se subieron con éxito\n         Total Registros Entregados:" + archivos_entregados + "\n         Total Archivos Subidos: " + archivos_subidos)
			window.parent.ajax_carga('configuracion_criteriosec_<?=arreglo_pasa_variables($id_invitacion);?>_<?=$id_lista;?>.html','contenidos');

		</script>
    <?



 } // SI EL ARCHIVO EXISTE
	
	
								 
?>

