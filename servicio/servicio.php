<? 
require_once('lib/nusoap.php');
$ns="http://localhost/sgpa/servicio/";
$server = new soap_server();
$server->configureWSDL('ws_evaluacion', $ns);
$server->wsdl->schemaTargetNamespace=$ns;

$server->register('f_evaluacion', // Nombre de la funcion
 array('S_CONTRATO' => 'xsd:string'), // Parametros de entrada
 array('return' => 'xsd:string'), // Parametros de salida
 $miURL);
 
 
function f_evaluacion($S_CONTRATO){
include("../librerias/lib/@include.php"); 
$busca_contrato= traer_fila_row(query_db("select * from t8_contratos_soap where contrato ='".$S_CONTRATO."'"));
 return new soapval('return', 'xsd:string',$busca_contrato[1]);
}

// Las siguientes 2 lineas las aporto Ariel Navarrete. Gracias Ariel
if ( !isset( $HTTP_RAW_POST_DATA ) )
    $HTTP_RAW_POST_DATA = file_get_contents( 'php://input' );

$server->service($HTTP_RAW_POST_DATA);

?>