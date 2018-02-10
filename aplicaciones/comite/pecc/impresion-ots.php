<? include("../../../librerias/lib/@session.php"); 
	ob_end_clean();
	/* -------------- */
	ob_start();
	
    include('impresion-ots-html.php');
    $content = ob_get_clean();
	
	
//$content = '<page backcolor="#AACCFF" backleft="5mm" backright="5mm" backtop="10mm" backbottom="10mm" >fer</page>';
    // convert to PDF
    require_once('../../../librerias/js/PDF_HTML/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'CARTA', 'fr');
        $html2pdf->writeHTML($content, isset($_GET['vuehtml']));
        //$html2pdf->createIndex('Sommaire', 25, 12, false, true, 1);
        $html2pdf->Output('bookmark.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
	
	
?>