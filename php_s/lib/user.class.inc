<?php
  /******************* user.class ***************************************
     Tout ce qui touche à un utilisateur

     variables :
       - login
       - type
       - liste des catégories possibles

     methodes :
       - Array getPrefs()
       - boolean savePrefs(Array $infos)
       - Array getInfos()
       - boolean saveInfos(Array $infos)
       - boolean modifPossible()
       - boolean modifPass()
       - boolean modifPassPossible()
       - boolean sendPass (String $email) Envoie le nouveau mot de passe par mail

  **********************************************************************/

class User {
   	var $login = '';
   	var $id = '';

   function User ($login = '',$id = '') {
      $this->login = $login;
      $this->id    = $id;
   }


   //créé un enregistrement de prefs si inexistant
   function prefExists($idPref) {
      global $db;

      $result = $db->query("SELECT COUNT(*) AS nb FROM userPrefs WHERE id_pref = " . $idPref . " AND login='".$this->login."'");
      if ($db->result($result, 'nb') == 0) {
            $valeur = $db->result($db->query("SELECT defaut FROM prefsListe WHERE id = " . $idPref .""), 'defaut');
            $db->query("INSERT INTO userPrefs (login, id_pref, valeur) VALUES ('".$this->login."', " . $idPref . ", '" . $valeur . "')");
         }
   }

   //Retourne un tableau associatif avec les préférences
   function prefGet($pref) {
       global $db;
       
       $idPref = $db->result($db->query("SELECT id FROM prefsListe WHERE titre = '" . $pref ."'"), 'id');
       $this->prefExists($idPref);
       
       $valeur = $db->result($db->query("SELECT valeur FROM userPrefs WHERE id_pref = " . $idPref . " AND login='".$this->login."'"), 'valeur');
       
       return ($valeur);
   }

   //Enregistre les préférences utilisateurs
    function prefSave($key, $value) {
        global $db;

  	    $idPref = $db->result($db->query("SELECT id FROM prefsListe WHERE titre = '" . $key ."'"), 'id');
       	$this->prefExists($idPref);
  			
  		$db->query("UPDATE userPrefs SET valeur = '".$value."' WHERE id_pref = " . $idPref . " AND login='".$this->login."'");  	
  	    
   }

   //Retourne 'true' si l'utilisateur à rempli son trombi
   function trombiFill () {
       global $db;
       $result = $db->result($db->query("SELECT COUNT(*) AS nb FROM usersInfo WHERE login = '" . $this->login . "' AND (gsm != '' OR adr_p_rue != '' OR adr_p_ville != '' OR adr_p_cp != '' OR adr_3_rue != '' OR adr_3_ville != '' OR adr_3_cp != '' OR surnom != '' OR jadis != '' OR passions != '')"), 0);
       if ($result == 0) return false; else return true;
   }




   //Retourne un tableau associatif avec tous les champs utiles
   function getInfos() {
       global $db;
       $infos = array();

       $result = $db->query("SELECT * FROM usersInfo WHERE login='".$this->login."'");
       if ($db->numRows($result) == 1) {
          $infos = $db->fetchArray($result);
       
          foreach ($this->fields as $key => $value) {
       		if (!isset($infos[$key])) {
       			$infos[$key] = '';       			
       		}
	  }
	  return ($infos);
       } else {
          return false;
       }
   }

   //Retourne vrai si l'utilisateur peut modifier ses passions
   function canModify() {
      global $db;
      
      $result = $db->query("SELECT surnom, jadis, passions, surnom_pourri, jadis_pourri, passions_pourri FROM usersInfo WHERE login='".$this->login."'");
      $row = $db->fetchArray($result);
      if ($row['surnom'] == $row['surnom_pourri'] and $row['jadis'] == $row['jadis_pourri'] and $row['passions'] == $row['passions_pourri']) {
         return true;
      } else { 
         return false;
      }
   }
   


   //Enregistre les données utilisateur
   function saveInfos($infos) {
       global $db;


       if ($this->canModify()) {
           $db->query("UPDATE usersInfo
	   		  SET
				surnom =                        '$infos[surnom]',
                                jadis =                         '$infos[jadis]',
				passions =                      '$infos[passions]',
				surnom_pourri =                 '$infos[surnom]',
				jadis_pourri =                  '$infos[jadis]',
				passions_pourri =               '$infos[passions]'

			  WHERE login='".$this->login."'");
			  

       }
       $infos['passions'] = htmlspecialchars($infos['passions']);
       if ($db->query("UPDATE usersInfo 
       					SET 
						adr_p_rue = 		'$infos[adr_p_rue]',
						adr_p_ville = 		'$infos[adr_p_ville]',
						adr_p_cp = 		'$infos[adr_p_cp]',
						adr_p_pays = 		'$infos[adr_p_pays]',
						adr_p_tel = 		'".$this->prepareTelNumber($infos['adr_p_tel'])."',
						adr_3_rue = 		'$infos[adr_3_rue]',
						adr_3_ville = 		'$infos[adr_3_ville]',
						adr_3_cp = 		'$infos[adr_3_cp]',
						adr_3_pays = 		'$infos[adr_3_pays]',
						adr_3_tel = 		'".$this->prepareTelNumber($infos['adr_3_tel'])."',
						gsm = 			'".$this->prepareTelNumber($infos['gsm'])."',
						emailPerso =		'$infos[emailPerso]',
						pageWeb =			'$infos[pageWeb]'
       				   WHERE login='".$this->login."'")) {
          return true;
       } else {
          return false;
       }


   }

   function prepareTelNumber($num) {
      $num = ereg_replace("([^0-9])","", $num);
      
      return ($num);
   }




   //enregistre la photo d'un utilisateur
   function savePhoto($photo) {
      $url = 'photos/' . $this->login . '.jpg';
      if (move_uploaded_file ($photo, $url)) {
         return true;
      } else {
         return false;
      }
   }

   //Efface la photo d'un utilisateur
   function delPhoto() {
      $url = 'photos/' . $this->login . '.jpg';
      if (is_file($url)) {
         if (unlink($url)) {
            return true;
         } else {
            return false;
         }
      } else {
         return false;
      }
   }

   //Pour savoir si on peut modifier les données
   function modifPossible() {
       switch ($this->type) {
          case 'db':
             return true;
          break;

          case 'imap':
             return false;
          break;

          default:
             return false;
          break;
       }
   }

   //Modification d'un mot de passe
   function modifPass($pass) {
      global $db, $session;
      $authOk = false;

      switch ($this->type) {
         case 'db':
            if ($db->query("UPDATE users SET pass=PASSWORD('".$pass."') WHERE login='".$this->login."'")) {
               $authOk = true;
            } else {
               $authOk = false;
            }
         break;
          case 'imap':
            $authOk = false;
         break;
          default:
            $authOk = false;
         break;
      }

      if ($authOk) {$session->pass = $pass;}

      return ($authOk);
   }


   //Modification possible d'un mot de passe
   function modifPassPossible() {
       switch ($this->type) {
          case 'db':
             return true;
          break;

          case 'imap':
             return false;
          break;

          default:
             return false;
          break;
       }
   }

   //Envoi du mot de passe
   function sendPass ($email) {
      global $db;

      $result = $db->query("SELECT login FROM usersInfo WHERE email='".$email."'");
      if ($db->numRows($result) > 0) {
         while ($row = $db->fetchArray($result)) {
            $mdp = substr(md5($form['email'] . date("YmdHis")),8,5);

            $result2 = $db->query("UPDATE users SET pass=PASSWORD('" . $mdp . "') WHERE login='" . $row['login'] . "'");

            $util->loadClass('Mail') ;
        $mail = new Mail ();

        $msg = "Votre nouveau mot de passe est : <b>".$mdp."</b>.";
        $mail->send('asso', $email, $msg, 'oubli du mot de passe', 1) ;
        return true;
         }
      } else {
         return false;
      }
   }
}
?>
