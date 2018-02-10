<? include("../lib/@session.php");

	ob_end_clean();
	/* -------------- */
	ob_start();
	
	$id_invitacion=1674;
	$campo_valos=3;

	include('exporta_adjudicacion.php');
    $content = ob_get_clean();
	

    require_once('../../../librerias/js/PDF_HTML/html2pdf.class.php');
	

    try
    {
        $html2pdf = new HTML2PDF('P', 'CARTA', 'fr');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //$html2pdf->createIndex('Sommaire', 25, 12, false, true, 1);
		//$html2pdf->Output('bookmark.pdf');
		$html2pdf->Output('../../librerias/actas_pdf/adjudicacion_1.pdf','F');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	
	
?>