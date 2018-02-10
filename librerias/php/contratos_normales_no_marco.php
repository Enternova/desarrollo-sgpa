<? include("../lib/@session.php");

$fecha_hoy = date("Y-m-d");
//$q = $_GET["q"];

//Cyrillic_General_CI_AI - Latin1_CI_AS  quita las tildes
$lista_inci = "select distinct top 15 id , razon_social COLLATE Cyrillic_General_CI_AI, nit, numero_contrato, apellido, consecutivo,ano,vigencia_mes  from $v_contra1  "
        . "where id not in (259, 313, 71) and t1_tipo_documento_id = 1 and  (razon_social COLLATE Cyrillic_General_CI_AI  like '%$q%' "
        . "or nit  like '%$q%' "
        . "or numero_contrato  like '%$q%' "
        . "or REPLACE(numero_contrato, '-', '')  like '%$q%' "
        . "or apellido like '%$q%') "
        . "and vigencia_mes >= '$fecha_hoy' "
        . "order by numero_contrato  ";
		
		
		

$sql_ex = query_db($lista_inci);
while ($lt = traer_fila_row($sql_ex)) {
    $apellido_contra = $lt[4];
    $fecha_vence = date("Y-m-d", strtotime($fecha_hoy . " + 3 months"));
    $mensaje_alerta = "";
    if ($lt[7] <= $fecha_vence) {
        $mensaje_alerta = " * Este Contrato esta Proximo a Vencer " . $lt[7] . " * ";
    }

    if ($apellido_contra == "CO&M012011" or $apellido_contra == "CO&M062008" or $apellido_contra == "GAS0082012" or $apellido_contra == "GCI0012010" or $apellido_contra == "GCI0022010") {
        $numero_contrato = $apellido_contra;
    } else {
        $numero_contrato = numero_item_pecc_contrato("C", $lt[6], $lt[5], $apellido_contra, $lt[0]);
    }

    $objeto.=$numero_contrato . " Contratista:" . $lt[1] . "----," . $lt[0] . "----," . $mensaje_alerta. "----,<remplaza>";
    } 
        echo $objeto;
?>