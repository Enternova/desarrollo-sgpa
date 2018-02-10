<?php
  /******************* util.class ***************************************
     Plein de fonctions qui peuvent être utiles à tout le monde


  **********************************************************************/

class Util {
   var $jour = array ();
   var $mois = array ();

   function Util() {
   }

   //Charge une class (permet d'éviter de la charger deux fois)
   function loadClass($className) {
      global $curPage, $config;

      $file = dirname(__FILE__) . '/' . strtolower($className) . '.class.inc';
      if (is_file($file)) {
         if (!class_exists ( $className)) {
            include_once ($file);
         }
      }
   }

   function securedloadClass($className) {
      global $curPage, $session, $config;

        if( $session->verif_droits($className) ) {

             $file = $curPage['relativePath'] . $config['includeDir'] . '/' . strtolower($className) . '.class';
             if (is_file($file)) {
                if (!class_exists ( $className)) {
                   include_once ($file);
                }
             }
        }
   }

   //makeUrl on fournit une url relative à la racine, et fournit une url absolue
   function makeUrl ($relativePath) {
      global $config, $session;
      //Vérifie si le client accepete les cookies
         if (ereg("^/", $relativePath)) {
             $base = $config['url'];
         } else {
             $base = $config['url'] . '/';
         }
         
	 $url = $base . $relativePath;

         //Vérifie si l'utilisateur accepte les cookies
         //et si il a bien recu la variable de session en cookie
         if (!isset($_COOKIE['UTT'])) {
             if (eregi("https?://[^\?]\?.*",$url)) {
                 $url.="&UTT=".$session->sessionId;
             } else {
                 $url.="?UTT=".$session->sessionId;
             }

         }
         return($url);
   }

   //Affiche la définition et les valeurs d'un objet (type inconnu)
   function objetDescription ($objet) {
      echo '<table width="200" border="0" cellspacing="1" cellpadding="0" bgcolor="#000000" align="center">
        <tr>
         <td align="center">
          <font color="#FFFFFF"><b>Description ('.gettype($objet).')</b></font>
         </td>
        </tr>
        <tr>
         <td valign="middle" height="110" bgcolor="#FFFFFF">';

      if (is_array($objet)) {
         echo '<table border="1" cellspacing="0">
                <tr><th colspan="3">'.count($objet) . ' éléments</th></tr>
                <tr><th>Clé</th><th>Type</th><th>Valeur</th></tr>';
         foreach ($objet as $name => $value) {
            echo '<tr><td>' . $name . '</td><td>' . gettype ($objet[$name]) . '</td><td>' . $objet[$name] . '</td></tr>';
         }
         echo '</table>';
      } elseif (is_object($objet)) {
         echo '<table border="1" cellspacing="0">
                <tr><th>Clé</th><th>Type</th><th>Valeur</th></tr>';
         $class_vars = get_class_vars(get_class($objet));
         foreach ($class_vars as $name => $value) {
            echo '<tr><td>' . $name . '</td><td>' . gettype ($objet->$name) . '</td><td>' . $objet->$name . '</td></tr>';
         }
         echo '</table>';
      } else {
         echo 'type non-analysé';
      }
      echo '</td>
        </tr>
       </table>';
   }

   function mail ($email) {

         return $this->makeUrl('mail/imp/compose.php?popup=1&to='.$email.'&cc=&bcc=&msg=&subject=&thismailbox=INBOX');

   }

   function verifForm ($value, $fieldType) {
      switch ($fieldType) {

         //Email
         case 'email':
            $result = ereg("^[_a-z0-9-]+(\.[_a-z0-9-]+)*@[a-z0-9-]+(\.[a-z0-9-]+)+$",$value);
            return $result;
         break;

         //Texte restreint
         case 'login':
            $result = ereg("^[a-z0-9]{4,8}$",$value);
            return $result;
         break;

         //Texte mais sans balise
         case 'txtBrut':

         break;

         //Avec plein de trucs
         case 'txtRich':

         break;
      }
   }

   /**
    * Fonction show_object
    *
    * @param $serialized_object Object sous la forme sérialisée
    * @param $object_name Nom de l'objet
    * @return Variable à afficher
    */
   function show_object($serialized_obj,$object_name) {
      $ret="";
      //echo "<i>".$serialized_obj."</i><br>";
      //Tentative pour retrouver les valeurs d'un objet
      ereg("^.*{(.*)}\$",$serialized_obj, $serialized_obj_tab );
      $serialized_obj=$serialized_obj_tab[1];
      while (ereg("[^:]*:[^:]*:?\"([^;]*)\";([^:]*):([^:;]*):?([^;]*);(.*)",$serialized_obj,$serialized_obj_tab)) {
           $ret.="<b>\$".$object_name."->".$serialized_obj_tab[1]."</b>= ";
           if ($serialized_obj_tab[1]=="pass") {
               $serialized_obj_tab[4]="********";
           }
           if ($serialized_obj_tab[2]=='s') {
                $ret.=$serialized_obj_tab[4]."<br>\n";
           } elseif ($serialized_obj_tab[2]=='b') {
                $ret.="false<br>\n";
           } elseif ($serialized_obj_tab[2]=='i') {
                 $ret.="true<br>\n";
           }
           $serialized_obj=$serialized_obj_tab[5];
      }
      return $ret;
  }

  /**
   * Fonction show_table affiche le contenu d'un tableau
   *
   * @param $table tableau à afficher
   * @param $table_name Nom du tableau à afficher
   * @return variable à afficher
   */
  function show_table($table,$table_name) {
      //Affichage d'un tableau
      $ret="";
      foreach (array_keys($table) as $var_name) {
           $ret.="<b>\$".$table_name."[".$var_name."]</b>= ".$table[$var_name]."<br>\n";
      }
      return $ret;
  }

  /**
   * Fonction redirect
   * Redirige l'utilisateur vers une autre page
   *
   * @param $url Url relatif de la page
   */

   function redirect($url) {
           //ereg("^(.*)/[^/]*$",$_SERVER['PHP_SELF'],$res_ereg);
          //$absolute_url="http://".$_SERVER['HTTP_HOST'].$res_ereg[1]."/".$url;
           $abolute_url=$this->makeUrl($url);
           if (!headers_sent ()) {
                  header("HTTP/1.1 301 Moved Permanently");
                  header("Location: $absolute_url");
                  header("Connection: close");
                  exit();
          } else {
                  echo "\n<meta http-equiv=\"refresh\" content=\"0;URL=$absolute_url\">\n";
          }
   }

  /**
   * Fonction set_pref
   * Change les prÃ©fÃ©rences d'un utilisateur
   *
   * @param $login login de l'utilisateur
   * @param $pref_name Nom de la prÃ©fÃ©rence
   * @param $pref_value Valeur de la prÃ©fÃ©rence
   */
   function set_pref($login,$pref_name,$pref_value) {
          global $db;
          $pref_name=htmlentities($pref_name,ENT_QUOTES);
          $pref_value=htmlentities($pref_value,ENT_QUOTES);
          $login=htmlentities($login,ENT_QUOTES);
          $req1 = $db->query("SELECT COUNT(*) AS nb FROM usersprefs2 WHERE login='$login' AND pref_name='$pref_name'");
          // Si l'utilisateur n'a jamais modifiÃ© la prÃ©fÃ©rence et qu'il s'appuie sur le modele par dÃ©faut
          if ($db->result ($req1, 0) == 0 ) {
              $db->query("INSERT INTO usersprefs2 (login,pref_name,pref_value) VALUES ('$login','$pref_name','$pref_value')");
          } else {
              $db->query("UPDATE usersprefs2 SET pref_value='$pref_value' WHERE login='$login' AND pref_name='$pref_name' ");
          }
   }

  /**
   * Fonction get_pref
   * Extraire les prÃ©fÃ©rences d'un utlisisateur. Si elles ne sont pas dÃ©fini on prend les valeurs par dÃ©faut!
   *
   * @param $login login de l'utilisateur
   * @param $pref_name Nom de la prÃ©fÃ©rence
   * @return valeur de la prÃ©fÃ©rence
   */
   function get_pref($login,$pref_name) {
          global $db;
          $pref_name=htmlentities($pref_name,ENT_QUOTES);
          $login=htmlentities($login,ENT_QUOTES);

          $req1 = $db->query("SELECT pref_value FROM usersprefs2 WHERE login='$login' AND pref_name='$pref_name'");
          $result = $db->fetchArray($req1);
          if (!isset($result['pref_value'])) {
                 $req2 = $db->query("SELECT pref_value FROM prefs_liste WHERE pref_name='$pref_name'");
                 $result = $db->fetchArray($req2);
          }
          return html_entity_decode($result['pref_value'],ENT_QUOTES);
   }

  /**
   * Fonction new_pref
   * Insere une nouvelle prÃ©fÃ©rence dans la table des prÃ©fÃ©rences par dÃ©faut
   *
   * @param $pref_name Nom de la prÃ©fÃ©rence
   * @param $pref_value Valeur de la prÃ©fÃ©rence
   * @return valeur de la prÃ©fÃ©rence
   */
   function new_pref($pref_name,$pref_value) {
          global $db;
          $pref_name=htmlentities($pref_name,ENT_QUOTES);
          $pref_value=htmlentities($pref_value,ENT_QUOTES);
          $query="SELECT count(pref_name) FROM prefs_liste WHERE pref_name='$pref_name'";
          $result=mysql_query($query);
          if ($db->result($result,0)==0) {
                  $db->query("INSERT INTO prefs_liste (pref_name,pref_value) VALUES ('$pref_name','$pref_value')");
             } else {
                $db->query("UPDATE prefs_liste SET pref_value='$pref_value' WHERE pref_name='$pref_name'");
          }
   }

	function displaySize($value) {
		$txt = Array(0=> 'o', 1=>'Ko', 2=>'Mo', 3=>'Go', 4=>'To');
		$suffixe = 0;
		$niceValue = $value;
		$precision = 2;
		while ($niceValue > 1024) {
			$niceValue = $niceValue / 1024;
			$suffixe++;
		}
		
		return round($niceValue, $precision) . ' ' . $txt[$suffixe];
	}

}

?>
