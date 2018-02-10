<?php
/******************* page.class ***************************************
Définition d'une page



**********************************************************************/

class Page {
    var $titre = "SQL Server WA";


    //constructeur pour instancier
    function Page() {
    }

/**********************************************************/
    function header($titre = '', $infos = Array()) {
      global $util, $db, $config;

      $this->headerHTML($titre);
      ?>
<table width="100%" border="0" cellpadding="0" cellspacing="0">
 <tr bgcolor="#7B74DD">
  <td height="60" colspan="3">
   <table width="100%" border="0" cellpadding="0" cellspacing="0">
    <tr>
     <td align="left"><a href="index.php"><img src="images/logo.jpg" alt="MSSQL Web Access"><a></td>
     <td align="right" width="100">
     	<a href="index.php?logout=1" class="banner"><img src="images/icons/help.gif" alt="Help"></a>
     	<a href="index.php?logout=1" class="banner"><img src="images/icons/exit.gif" alt="Logout"></a><br><br>
	  <font color="#99FF30"><?=$db->user?>@<?=$db->host?></font>
     </td>
    </tr>
   </table>
  </td>
 </tr>
 <tr>
  <td bgcolor="#FFFFFF" width="200" valign="top">
   <table border="0" cellspacing="0" cellpadding="0" width="200">
    <tr>
     <form name="frm_db_list" action="db_detail.php">
     <td bgcolor="#000000" width="180" valign="middle" class="select_base"><select name="base" onChange="change_db()">
		   <option value="">--Select DB--</option>
		   <?php
			$result = $db->query("EXEC sp_databases");
			while ($row = $db->fetch_array($result)) {
				if ($row['DATABASE_NAME'] == $db->base) {
					$selected = 'selected';
				} else {
					$selected = '';
				}
				echo '<option value="'.$row['DATABASE_NAME'].'" '.$selected.'>'.$row['DATABASE_NAME'].'</option>';
			}
		   ?>
	  	</select><!--<input type="image" src="images/icons/ok.gif" height="16">--></td>
	   </form>
	 <td width="20"><img src="images/charte/curve.gif"></td>
	</tr>
	<tr>
	 <td height="150" valign="top">
	   <?php
		
		if (!empty($db->base)) {
			?>
			<a href="db_detail.php?base=<?=urlencode($db->base)?>"><img src="images/icons/database.gif"> <?=$db->base?></a><br>
	
			<!--<img src="images/icons/nav-tree-middle.gif" align="middle"><a href="db_view.php?base=<?=urlencode($db->base)?>"><img src="images/icons/view.gif" align="middle"> Views</a><br>-->
			<!--<img src="images/icons/nav-tree-middle.gif" align="middle"><a href="db_procedures.php?base=<?=urlencode($db->base)?>"><img src="images/icons/procedure.gif" align="middle"> Stored Procedures</a><br>-->
			<img src="images/icons/nav-tree-end.gif" align="middle"><a href="db_tables.php?base=<?=urlencode($db->base)?>"><img src="images/icons/table.gif" align="middle"> Tables</a><br>
			<?php
		}
	   
	   ?>
	 </td>
	 <td rowspan="2" background="images/charte/vert_line.gif" width="20">&nbsp;</td>
	</tr>
	<tr>
	 <td><img src="images/charte/black_dot.gif" height="1" width="180"></td>
	</tr>
	<tr>
	 <td><a href="http://mssql-wa.sourceforge.net" target="_blank">SQL Server Web Admin <?=$config['version']?></a></td>
	 <td>&nbsp;</td>
	</tr>
   </table>   
  </td>
  <td bgcolor="#FFFFFF" valign="top">
  <p class="pathTitle">
  <?php
	echo '<A href="index.php"><img src="images/icons/server.gif" align="middle">'.$db->host.'</A>';
	if (!empty($infos['base'])) {
		echo ' &gt; <A href="db_detail.php?base='.$infos['base'].'"><img src="images/icons/database.gif" align="middle">'.$infos['base'].'</A>';
	}
	if (!empty($infos['table'])) {
		echo ' &gt; <A href="table_view_data.php?base='.$infos['base'].'&table='.$infos['table'].'"><img src="images/icons/table.gif" align="middle">'.$infos['table'].'</A>';
	}

	?>
	</p>
<?php
   }

   /**********************************************************/
   function footer () {
      global $util, $menu;
      ?>
  </td>
  <td width="170" valign="top" align="center">
   
   <?php
    if (count($menu)> 0) {
   		$this->moduleHeader('Actions');
    
    	echo '<table border="0" cellspacing="0" cellpadding="2" align="center">';
    	foreach ($menu as $key => $val) {
    		echo '<tr><td width="16">';
    		echo '<a href="' . $val['url'] . '"><img src="' . $val['image'] . '" width="16" alt="' . $val['title'] .'"></a>';
    		echo '</td><td width="130">';
    		echo '<a href="' . $val['url'] . '">' . $val['title'] .'</a>';
    		echo '</td></tr>';
    	}
    	echo '</table>';
    
    	$this->moduleFooter();
    }
   
	?>
   <?=$this->moduleHeader('Quick SQL')?>
    <form action="db_exec_sql.php?base=<?=$db->base?>">
     <textarea cols="13" rows="5" name="sql_query_text"></textarea><br>
     <input type="submit" value="Executer">
    </form>
   <?=$this->moduleFooter()?>
  </td>
 </tr>
</table>
      <?php
      $this->footerHTML();
   }

   function headerHTML ($titre = '') {
      if ($titre != '') {
         $this->titre = '['.$this->titre.'] ' . $titre;
      }
      ?>
      <!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.0 Transitional//EN" "http://www.w3.org/TR/REC-html40/loose.dtd">
      <html>
       <head>
        <title><?=$this->titre?></title>
        <META HTTP-EQUIV="imagetoolbar" CONTENT="no">
        <meta content="text/html; charset=iso-8859-1" http-equiv="Content-Type">
        <script language="Javascript" src="javascript.js" type="text/javascript"></script>
        <LINK rel="stylesheet" type="text/css" href="style.css" >
       </head>
      <body>
      <?php
   }

   function footerHTML () {
     ?>
     </body>
   </html>
      <?php
   }

	function moduleHeader($title) {
		?>
		<br>
		<table width="150" cellpadding="0" cellspacing="0" border="0">
		 <tr>
		  <td background="images/charte/module_top.gif" colspan="3" width="150" height="28">&nbsp;&nbsp;<font color="#FFFFFF"><b><?=$title?></b></font></td>
		 </tr>
		 <tr>
		  <td background="images/charte/module_left.gif" width="3">&nbsp;</td>
		  <td valign="top" align="center">
		<?php
	}
	
	function moduleFooter() {
		?>
		 </td>
		  <td background="images/charte/module_left.gif" width="3">&nbsp;</td>
		 </tr>
		 <tr>
		  <td colspan="3" height="3"><img src="images/charte/module_bottom.gif" width="150" height="3"></td>
		 </tr>
		</table>		  
		
		<?php		
	}

   function msgInfo ($text) {
      echo '<table border="0" cellspacing="1" cellpadding="2" bgcolor="#0000DD" align="center" width="300">
             <tr class="titre">
              <td><font color="#FFFFFF"><b>Info</b></font></td>
             </tr>
             <tr class="contenu">
              <td bgcolor="#FFFFFF">'.$text.'</td>
             </tr>
           </table>';
   }

   function msgError ($text) {
      echo '<table border="0" cellspacing="1" cellpadding="2" bgcolor="#DD0000" align="center" width="300">
             <tr class="titre">
              <td><font color="#FFFFFF"><b>Erreur</b></font></td>
             </tr>
             <tr class="contenu">
              <td bgcolor="#FFFFFF">'.$text.'</td>
             </tr>
           </table>';
   }
   
}

?>
