<?php
/********************************************************************/
/**************     user configuration              *****************/
/********************************************************************/


//Server's Host name
//1rst way : open

//$config['userDb']['server'] = '';

//2nd way : only one
//$config['userDb']['server'] = 'localhost';

//3rd way : multiple server
$config['userDb']['server'][] = 'localhost';
$config['userDb']['server'][] = 'sqlsgpadb\sgpa';


//Used to display a default path (ex: to attach or create a DB)
$config['database']['default_path'] = 'Hocol_sgpa';

/********************************************************************/
/**************     end of user configuration       *****************/
/********************************************************************/

  //Gestion des erreurs
  $config['error']['ReportingLevel'] = E_ALL & ~E_NOTICE ;                     //Sélection des erreurs affichées
  $config['error']['View'] = true ;




  $config['SQLfunctions'] = Array(
  								'ASCII',
  								'AVG',
  								'COUNT',
  								'GETDATE',
  								'LEN',
  								'SOUNDEX',
  								'SUM',
  );
  $config['top_values'] = Array(25, 50, 100, 1000);
  $config['version'] = '0.0.2-pre';
  $config['required'] = Array(
  						'PHP_version' => '4..0',
  						'PHP_mssql_extension' => 'mssql',
  						);


?>
