<?php
/******************* page.class ***************************************
Définition d'une page



**********************************************************************/

class Media {
	var $mediaStatus = Array( 	0 => 'indispo', 
								1=>'disponible'
							);


    //constructeur pour instancier
    function Media() {
    }

/**********************************************************/

	function addMedia() {
		
		
	}
	
	function deleteMedia() {
		
		
	}

	//Retourne si un media est dispo, en pret, etc
	function status($idMedia) {
		global $db, $config;
		
		$nb = $db->result($db->query("SELECT COUNT(*) as nb FROM ".$config['db']['Tpret'] . " WHERE rendu = 'N' and id_film = $idMedia"), 'nb');
		return $nb;
	}


}

?>
