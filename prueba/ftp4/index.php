<?php

/*##################################################

# Class Name 	: myFTP								#
# Author 		: HUSSON KEVIN						#
# Email 		: husson.kevin@gmail.com			#
# Version		: 1.0								#

###################################################*/

session_start();

require_once('FtpPti.class.php');

require_once('upload.class.php');

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="fr" lang="fr">
<head>
	<link rel="stylesheet" type="text/css" href="style.css" />
	<title>myFTP : husson.kevin@gmail.com</title>
</head>
<body>
	<div id="headerFTP">
		Client FTP en PHP Orienté Objet<br /> Codé par HUSSON Kévin - 2008
	</div>


<?php
#################################################################################
#																				#
#							Formulaire De connection							#
#																				#
#################################################################################
function secu($t, $num = false){
	return ($num) ? intVal($t) : htmlentities($t , ENT_QUOTES);
}

if(!$_SESSION['ftpConnect']){
	?>
	<div id="Login">
		<?php
		if(isset($_POST['connect']) && !empty($_POST['host']) && !empty($_POST['user'])){
		// DATA TEST
			$ftpU = secu($_POST['user']);
			$ftpP = secu($_POST['pass']);
			$ftpH = secu($_POST['host']);
			$ftpP2 = ($_POST['port'] != 0 && $_POST['port'] != 21 && is_numeric($_POST['port'])) ? secu($_POST['port']) : 21;
			$ftpM = ($_POST['mode'] == 'true') ? 'true' : 'false';
		// CONNECTION	
			try{
				$ftp = new myFTP($ftpH, $ftpU, $ftpP, $ftpP2, $ftpM);
				
				$_SESSION['ftpConnect']['host'] = $ftpH;
				$_SESSION['ftpConnect']['user'] = $ftpU;
				$_SESSION['ftpConnect']['pass'] = $ftpP;
				$_SESSION['ftpConnect']['port'] = $ftpP2;
				$_SESSION['ftpConnect']['mode'] = $ftpM;
				echo'<script>document.location.href="'.$_SERVER['PHP_SELF'].'"</script>';
			}
			catch(exception $e){
				echo 'Erreur: '.$e->getMessage;
				$ftp->closit();
			}
		}
		// FORM
		?>
		<form method="POST" enctype="multipart/form-data">
		<table>
			<tr><td>Addresse :</td><td><input type="text" name="host" size="25"></td></tr>
			<tr><td>Pseudo :</td><td><input type="text" name="user" size="25"></td></tr>
			<tr><td>Password :</td><td><input type="password" name="pass" size="25"></td></tr>
			<tr><td>Port :</td><td><input type="text" name="port" size="5"></td></tr>
			<tr><td><input type="checkbox" value="true" name="mode" /><span style="font-size: 12px;">Mode passif</span></td>
				<td>
					<input type="reset" name="annulation" value="Annuler">
					<input type="submit" name="connect" value="Connection">
				</td>
			</tr>
		</table>
		</form>
	</div>
	<?php
}
else{
	try{
		$ftp = new myFTP($_SESSION['ftpConnect']['host'],$_SESSION['ftpConnect']['user'],$_SESSION['ftpConnect']['pass'],$_SESSION['ftpConnect']['port'],$_SESSION['ftpConnect']['mode']);
	}
	catch(exception $e){
		echo 'Erreur: '.$e->getMessage;
	}


	// QUIT
		if(isset($_POST['seDeco'])){
			session_destroy();
			unset($ftp);
			echo '<meta http-equiv="Refresh" content="0;URL='.$_SERVER['PHP_SELF'].'">';
		}
	// MENU
	?>
<div id="menu">
	MENU<br /><br />
	<LEGEND>Creer un Dossier : </LEGEND>
		<table>
			<form method="POST" enctype="multipart/form-data">
				<tr><td><input type="text" name="CreerDossier" size="25" /></td></tr>
				<tr>
					<td>
						<input type="reset" name="annulation" value="Annuler" />
						<input type="submit" name="Creer" value="Creer le Dossier" />
					</td>
				</tr>
			</form>
		</table>
	<br />

	<LEGEND>Uploader : </LEGEND>
		<table>
			<form method="POST" enctype="multipart/form-data">
				<tr><td><input type="file" name="uploadFichier" size="20" /></td></tr>
				<tr>
					<td>
						<input type="hidden" name="MAX_FILE_SIZE" value="500" />
						<input type="reset" name="annulation" value="Annuler" />
						<input type="submit" name="EnvoyerFichier" value="Envoyer le Fichier" />
					</td>
				</tr>
			</form>
		</table>
	<br />

	<LEGEND>Se Deconnecter : </LEGEND>
		<table>
			<form method="POST" enctype="multipart/form-data">
				<tr>
					<td><input type="submit" name="seDeco" value="Quitter le FTP" /></td>
				</tr>
			</form>
		</table>
</div>

<div id="contenuFTP">
	<?php

	// GET THE ACTUAL FOLDER
		if(!$_SESSION['ftpConnect']['folder'])
			$dir = '/';
		else
			$dir = $_SESSION['ftpConnect']['folder'];
		$ftp->cd($dir); // --> Affecte le dossier !
		echo '<div class="dossierActuel">Dossier Actuel : '.$ftp->pwd().'</div>';


	// GET ACTION
		if(isset($_GET['ftp'])){
			switch ($_GET['ftp']){
				// DELETE : FOLDER / FILE
				case 'del':
					if($ftp->delfolder(secu($_GET['fichier'])))
						echo'<p>Dossier correctement supprimé.</p>';
					if($ftp->delfile(secu($_GET['fichier'])))
						echo'<p>Fichier correctement supprimé.</p>';
					echo'<meta http-equiv="Refresh" content="2;URL='.$_SERVER['PHP_SELF'].'">';
				break;

				// LIST DIR
				case 'parcourir':
					$ftp->cd($ftp->pwd().'/'.secu($_GET['dir']).'/');
					$_SESSION['ftpConnect']['folder'] = $ftp->pwd();
					echo'<meta http-equiv="Refresh" content="0;URL='.$_SERVER['PHP_SELF'].'">';
				break;

				//default: throw new Exception('<strong>Page introuvable.</strong><br />');break;
			}
		}


	// CREATE FOLDER
		if(isset($_POST['Creer']) && !empty($_POST['CreerDossier'])){
			$fichieraCreer = secu($_POST['CreerDossier']);
			if($userFTP->creer($fichieraCreer))
				echo'<p>Dossier correctement créé.</p>';
			//echo'<meta http-equiv="Refresh" content="2;URL='.htmlentities($_SERVER['PHP_SELF'],ENT_QUOTES).'">';
		}


	// UPLOAD DE FICHIER
		if(isset($_POST['EnvoyerFichier']) && !empty($_FILES)){
			try{
				// Instanciation
					$up = new Uploader($_FILES);
				// Envoi du Fichier en HTTP + Verification Si Envoi == true
					if($up->envoiFichierTMP()){
						// Upload en FTP
						if($ftp->upload($_FILES["uploadFichier"]["name"],$_FILES["uploadFichier"]["tmp_name"]))
							echo '<p>Fichier Correctement Envoyé.</p>';
						else
							throw new Exception('<strong>Impossible d\'envoyer le fichier sur le serveur FTP</strong>');
					}
			}
			catch(Exception $messageUp){
				echo $messageUp->getMessage();
				echo '<meta http-equiv="Refresh" content="2;URL='.$_SERVER['PHP_SELF'].'">';
			}
			// Sécurité - Evite de lancer un fichier temporaire sur le serveur HTTP d'upload !
			if(@file_exists($_FILES["uploadFichier"]["tmp_name"]))
				@unlink($_FILES["uploadFichier"]["tmp_name"]);
		}

		// LIST FILES/FOLDERS
		?>
		<table>
			<tr>
				<th> Nom du fichier </th>
				<th> Timestamp </th>
				<th align="center"> Taille </th>
				<th> Permissions </th>
				<th> Suppression </th>
			</tr>
			<tr>
				<td><a href="<?php echo $_SERVER['PHP_SELF'];?>?ftp=parcourir&dir=../">Parent</a></td>
				<td></td>
				<td></td>
				<td></td>
				<td></td>
			</tr>
		<?php
		foreach ($ftp->list_hard($ftp->pwd())  as $c => $v){
			$cc = count($v);
			for ($i=0; $i < $cc; $i++){
				$regex = "^([^ ]+) +[^ ]+ +([^ ]+) +([^ ]+) + ([^ ]+) +([^ ]+ +[^ ]+ +[^ ]+) +(.+)$";
				// Alternance de couleurs
					if ($i % 2 == 0)
						$bgcolor = "bgcolor=\"#CCC\"";
					else
						$bgcolor = "bgcolor=\"#FFF\"";
				// Jointure Expression réguliere
					ereg($regex, $v[$i], $file_info);
				// Affichage HTML
				echo '<tr><td '.$bgcolor.'><a href="'.$_SERVER['PHP_SELF'].'?ftp=parcourir&dir='.$file_info[6].'">'.$file_info[6].'</a></td>';
				echo "<td $bgcolor>$file_info[5]</td>";
				echo '<td align="center" '.$bgcolor.'>'.$ftp->taille2($file_info[4]).'</td>';
				echo "<td $bgcolor>$file_info[1]</td>";
				echo '<td '.$bgcolor.'><a href="'.$_SERVER['PHP_SELF'].'?ftp=del&fichier='.$file_info[6].'">Supprimer</a></td>';
			}
		}
		?>
		</table>
	</div>
	<?php
}
?>
</body>
</html>