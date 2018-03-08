<? 

	ob_end_clean();
	/* -------------- */
	ob_start();

    include('impresion-ots-html.php');
    $content = ob_get_clean();
	

    require_once('../../librerias/js/PDF_HTML/html2pdf.class.php');
	

    try
    {
        $html2pdf = new HTML2PDF('P', 'CARTA', 'fr');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //$html2pdf->createIndex('Sommaire', 25, 12, false, true, 1);
		//$html2pdf->Output('bookmark.pdf');
		$html2pdf->Output('../../librerias/ots_envio_email/'.$num_item_ot.'.pdf','F');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	
	
?>