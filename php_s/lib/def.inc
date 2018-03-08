<?php
	include_once (dirname(__FILE__) . '/config.inc');

/********************************************************************/
/**************     Gestion des erreurs      ****************/
/********************************************************************/

	//error_reporting('E_ALL & ~E_NOTICE');


 //Ecriture d'une petite fonction de gestion des erreurs ? cf man :  myErrorHandler()


/********************************************************************/
/**************     Récup de ce qui est passé en argument   *********/
/********************************************************************/

	if (empty($_REQUEST['affichage'])) {
		$affichage = ''; 
	} else {
		$affichage = $_REQUEST['affichage'];
	}
	
	if (empty($_REQUEST['action'])) {
		$action = ''; 
	} else {
		$action = $_REQUEST['action'];
	}	
	
	if (empty($_REQUEST['table'])) {
		$table = ''; 
	} else {
		$table = $_REQUEST['table'];
	}	

/********************************************************************/
/**************     Définission des classes        *****************/
/********************************************************************/

include_once (dirname(__FILE__) . '/page.class.inc');
include_once (dirname(__FILE__) . '/mssql.class.inc');
include_once (dirname(__FILE__) . '/session.class.inc');
include_once (dirname(__FILE__) . '/util.class.inc');
include_once (dirname(__FILE__) . '/user.class.inc');
include_once (dirname(__FILE__) . '/action.class.inc');

$util = new Util();
$page = new Page();
$pageInfos = Array();
$menu = Array();

$act = new Action();

/********************************************************************/
/**************     Gestion des sessions      ****************/
/********************************************************************/
session_name("PHPmsSQL");
@session_start();

if(!isset($_SESSION["session_saved"])) {
	$session = new session(session_id());
} else {
	$session = unserialize($_SESSION["session_saved"]);
}

if (isset($_POST['login'])) {
	//On ouvre la session
	
    //Récupération du serveur
    if (empty($config['userDb']['server'])) {
       	$host = $_POST['host'];
    } else if (is_array($config['userDb']['server'])) {
       	$host = $_POST['host'];
    } else {
    	$host = $config['userDb']['server'];	
    }

	
	
	
    $session->open($host, $_POST['login'], $_POST['password']);
} elseif (isset($_GET['logout'])) {
	//On délogue
	$session->close();
}

$session_saved = serialize($session);
$_SESSION["session_saved"]=$session_saved;

//verification de la session
//$session->verifIntrusion();
if (!$session->authOk) {
    $session->HTMLForm();
} 

/********************************************************************/
/**************     Ouverture du lien SQL Server     ****************/
/********************************************************************/
$db = new Mssql();
$db->connect($session->host, $session->login, $session->pass);


	$db->select_db('Hocol_sgpa');
?>
