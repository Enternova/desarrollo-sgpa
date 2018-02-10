<? include("../lib/@session.php");
	ob_end_clean();
	/* -------------- */
	ob_start();
	
    include('acta_apertura.php');
	
    $content = ob_get_clean();
	

    
$content2="<page  backtop='20mm' backbottom='7mm' backleft='1mm' backright='1mm'>
 <page_header>
   <b><div >".$encabezado_header."</div></b>
  </page_header>
			
			
  <page_footer>
    Pagina [[page_cu]]/[[page_nb]]
  </page_footer>
  
</page>";

    

//$content = '<page backcolor="#AACCFF" backleft="5mm" backright="5mm" backtop="10mm" backbottom="10mm" >fer</page>';
    // convert to PDF
    require_once('../../../librerias/js/PDF_HTML/html2pdf.class.php');
    try
    {
        $html2pdf = new HTML2PDF('P', 'CARTA', 'fr');
        $html2pdf->writeHTML($content2.$content, isset($_GET['vuehtml']));
        //$html2pdf->createIndex('Sommaire', 25, 12, false, true, 1);
        $html2pdf->Output("Acta_proceso_".$arregla_conse.'.pdf');
    }
    catch(HTML2PDF_exception $e) {
        echo $e;
        exit;
    }
?>