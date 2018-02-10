<?php

/*##################################################

# Class Name 	: myFTP								#
# Author 		: HUSSON KEVIN						#
# Email 		: husson.kevin@gmail.com			#
# Version		: 1.0								#

###################################################*/

#####################
#					#
#	Classe Upload	#
#					#
#####################

class Uploader extends myFTP{

	protected $fichier;
	public $taille_max = 500000;

	public function __construct($fichierTEMP){
		$this->fichier = $fichierTEMP;
	}

	public function envoiFichierTMP(){
		if(!empty($this->fichier)){
			// Les informations concernant le fichier
			$fichierName = $this->fichier["uploadFichier"]["name"];
			$tempName = $this->fichier["uploadFichier"]["tmp_name"];
			$tailleFichier = $this->fichier["uploadFichier"]["size"];
			// Si l'extension et que la taille du fichier son bons
			if ($tailleFichier <= $this->taille_max && $tailleFichier != 0)
				return true;
			// Si il y a une erreur
			else{
				// taille trop grande
				if ($tailleFichier > $this->taille_max)
					throw new Exception('La taille du Fichier est trop importante.');
				// Erreur
				else
					throw new Exception('Il y a une erreur, veuillez recommencer.');
			}
		}
		else
			throw new Exception('Veuillez Selectionner un Fichier.');
	}

}
?>