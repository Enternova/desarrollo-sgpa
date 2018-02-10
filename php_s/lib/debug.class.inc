<?php
  /******************* debug.class ***************************************


  **********************************************************************/

class Debug {

   var $login;

   function Debug () {

   }

   function affiche () {
      global $page;
      $page->moduleheader('Debugage','droite',45,'EEEEEE');
      echo $this->show_variable();
      $page->modulefooter();

   }

   function resume () {
      echo $this->show_variable();

   }

   function show_variable() {
      global $util, $session;
      $ret="<div class=\"contenu\">";

      $ret.="<div class=\"titre\"><b>Variables de session :</b></div><br>\n";
      //Affichage des variables de session
      foreach (array_keys($_SESSION) as $var_name) {
           if (is_array($_SESSION[$var_name])) {
               if ($var_name!="imp") {
                  $ret.=$util->show_table($_SESSION[$var_name],$var_name);
               }
           } elseif (ereg("^.*{(.*)}\$",$_SESSION[$var_name])) {
               $ret.=$util->show_object($_SESSION[$var_name],$var_name);

           } else {
               if ($var_name=="pass") {
                  $ret.="<b>\$$var_name</b>= ********<br>\n";
               } else {
                  $ret.="<b>\$$var_name</b>= ".$_SESSION[$var_name]."<br>\n";
               }
           }

      }


      $ret.="<br><div class=\"titre\"><b>Paramètres :</b></div><br>\n";
      //Affichage des valeurs en paramètres
      foreach (array_keys($_REQUEST) as $var_name) {
           if (is_array($_REQUEST[$var_name])) {
              $ret.=$util->show_table($_REQUEST[$var_name],$var_name);
           } elseif (ereg("^.*{(.*)}\$",$_REQUEST[$var_name])) {
              $ret.=$util->show_object($_REQUEST[$var_name],$var_name);
           } else {
              if ($var_name=="pass") {
                  $_REQUEST[$var_name]="********";
              }
              $ret.="<b>\$$var_name</b>= ".$_REQUEST[$var_name]."<br>\n";
           }
      }


      $ret.="<br><div class=\"titre\"><b>Droits de ".$session->login." :</b></div>\n";
      $a = array (1, 2, 3, 17);

      foreach ($session->droits as $var_name) {
          $ret.= " &nbsp;&nbsp;- ".$var_name."<br>";
      }


      $ret.="</div>";
      return $ret;
   }
}
?>