<? 
header('Content-Type: text/xml; charset=ISO-8859-1');
echo '<?xml version="1.0" encoding="ISO-8859-1"?>';	

readfile('http://www.parservicios.com/parservi/ficha_tecnica_gt.php?ref=principal.html&pv_nit='.$pv_nit);

?>
