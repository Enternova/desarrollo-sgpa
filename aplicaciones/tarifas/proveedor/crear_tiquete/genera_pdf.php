<? 

	ob_end_clean();
	/* -------------- */
	ob_start();

    include('crear_tiquete/tiquetes_html.php');
    $content = ob_get_clean();
	

    require_once('../../../librerias/js/PDF_HTML/html2pdf.class.php');
	

    try
    {
             $html2pdf = new HTML2PDF('L', 'A4', 'fr');
        $html2pdf->pdf->SetDisplayMode('fullpage');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
		//$html2pdf->AddPage([string orientacion[,mixed formato]]);
        //$html2pdf->createIndex('Sommaire', 25, 12, false, true, 1);
		//$html2pdf->Output('bookmark.pdf');
		$html2pdf->Output('crear_tiquete/reporte.pdf');
    }
  
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	
	
?>