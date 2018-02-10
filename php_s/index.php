<?php
include ('lib/def.inc');

$page->header('Home', $pageInfos);

switch ($action) {
	//Pour détacher une base
	case 'detach_db':
		$act->detach_db($_REQUEST['baseToDetach']);
		break;
		
	//Pour supprimer une base
	case 'delete_db':
		$act->delete_db($_REQUEST['baseToDelete']);
		break;

	//Attach DB
	case 'attach_db':
		$act->attach_db($_REQUEST['database_name'], $_REQUEST['file']);
		break;
		
	//Create DB
	case 'create_db':
		$act->create_db($_REQUEST['database_name'], $_REQUEST['sys'], $_REQUEST['log'], $_REQUEST['data']);
		break;
}

?>
<table width="100%">
 <tr>
  <td valign="top" width="50%">
<H2>Databases list</H2>
<?php

//Databases list
	$result = $db->query("EXEC sp_databases");
	if ($db->num_rows($result) == 0) {
		echo 'Aucune base présente<br>';
	} else {
		echo '<table cellpadding="3" cellspacing="0" class="dataTable">
			<tr>
			 <th>Base</th>
			 <th>Action</th>
			 <th>Taille</th>
			</tr>
		';

		while ($row = $db->fetch_array($result)) {
			//$nbRecord = $db->result($db->query("SELECT COUNT(*) as nb FROM " . $row['TABLE_NAME']), 0, 'nb');
			
			echo '<tr>
				<td><a href="db_detail.php?base='.$row['DATABASE_NAME'].'">'.$row['DATABASE_NAME'].'</a></td>
				<td>	<a href="index.php?baseToDelete='.$row['DATABASE_NAME'].'&action=delete_db">Delete</a> <a href="index.php?baseToDetach='.$row['DATABASE_NAME'].'&action=detach_db">Detach</a><br></td>
				<td align="right">'.$util->displaySize($row['DATABASE_SIZE'] * 1024).'</td>
				</tr>';
		}

		echo '</table>';		
	}

?>


<br>
<H2>Create new database</H2>

<form action="db_create.php" method="post">
 <input type="hidden" name="base" value="<?=$db->base?>">
 <input type="hidden" name="affichage" value="full_form">
 <table cellpadding="3" cellspacing="0" class="dataTable">
  <tr>
   <th>Database Name</th>
  </tr>
  <tr>
   <td><input type="text" name="database_name" value="" size="20"></td>
  </tr>
  <tr>
   <td align="right">
    <input type="submit" value="Next &gt;&gt;">
   </td>
  </tr>
 </table>
</form>

<br>
<H2>Attach database</H2>
<form action="index.php" method="post">
 <input type="hidden" name="action" value="attach_db">
 <table cellpadding="3" cellspacing="0" class="dataTable">
  <tr>
   <th>Database Name</th>
   <td><input type="text" name="database_name" value="" size="20"></td>
  </tr>
<?php
	for ($i = 1; $i < 5; $i++) {
?>
  <tr>
   <th>File <?=$i?></th>
   <td><input type="text" name="file[<?=$i?>]" value="" size="20"></td>
  </tr>
<? } ?>
  <tr>
   <td colspan="2" align="right">
    <input type="submit" value="Attach &gt;&gt;">
   </td>
  </tr>
 </table>

</form>
  </td>
  <td valign="top" width="50%">
   <a href="server_datatype.php">View Server data type</a><br>
   <a href="server_info.php">View Server info</a>


  </td>
 </tr>
</table>

<?php
$page->footer();
?>
