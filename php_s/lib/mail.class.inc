<?php
  /******************* mail.class ***************************************
     Pour envoyer un mail






  **********************************************************************/

class Mail {
   var $mailWebmaster = '';
   var $mailAsso = '';
   var $to = '';
   var $from = '';
   var $message = '';
   var $subject = '';
   var $headers = '';
   var $includeDir = '';


   function Mail () {
      global $config, $curPage;
      $this->mailWebmaster = $config['mailWebmaster'];
      $this->mailAsso = $config['mailAsso'];
      $this->includeDir = $curPage['relativePath'] . $config['includeDir'];

   }

   function send($from, $to, $message, $sujet, $template = true) {
      //On ajoute les entetes du mail
      if ($from == 'admin') {$from = 'Webmaster<' .$this->mailWebmaster . '>';}
      if ($to == 'admin')   {$to = 'Webmaster<' .$this->mailWebmaster . '>';}

      if ($from == 'asso' OR $from == '') {$from = 'Utt Net Group<' .$this->mailAsso . '>';}
      if ($to == 'asso' or $to == '')   {$to = 'Utt Net Group<' .$this->mailAsso . '>';}

      $this->to = $to;
      $this->from = $from;

      //Gestion du sujet
         $this->subject = '[www-etu]' . $sujet;


      if ($template) {
         //On récupère le message type
         $fcontents = join( '', file( $this->includeDir . '/mailtype.htm' ) );

          //On parse le fichier et on remplace ce qu'il faut : message
             $this->message = str_replace("[MSG]", $message, $fcontents);
      } else {
         $this->message = $message;
      }

      //Création des entetes
         $this->headers  = "MIME-Version: 1.0\n";
         $this->headers .= "Content-type: text/html; charset=iso-8859-1\n";
         $this->headers .= "From: ".$this->from."\n";
         $this->headers .= "X-Sender: ".$this->from."\n";
         $this->headers .= "X-Mailer: PHP: ".phpversion()."\n";
         $this->headers .= "X-Priority: 3\n";
         $this->headers .= "Return-Path: ".$this->from."\n";  // Re-chemin de retour pour les erreurs

      // et hop, à la poste


      if ( mail($this->to, $this->subject, $this->message, $this->headers) ) {
      //if (true) {
      //    echo 'mail sent !';
          return true;
      } else {
      //    echo 'mail error ...';
          return false;
      }
   }



}

?>
