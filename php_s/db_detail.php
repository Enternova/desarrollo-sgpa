<?php
include ('lib/def.inc');

$pageInfos['base'] = $db->base;


$page->header('Database details', $pageInfos);



$menu[] = Array('url'   => 'index.php?baseToDelete='.$db->base.'&action=delete_db',
				'image' => 'images/icons/delete.gif',
				'title' => 'Delete database');
$menu[] = Array('url'   => 'index.php?baseToDetach='.$db->base.'&action=detach_db',
				'image' => 'images/icons/detach.gif',
				'title' => 'Detach database');
?>

<h2>Database informations</h2>
<?php
$result = $db->query("EXEC sp_helpdb @dbname='".$db->base."'");
$row = $db->fetch_array($result);
?>
<table cellpadding="3" cellspacing="0" class="dataTable">
 <tr>
  <th>Name</th>
  <td><?=$row['name']?></td>
 </tr>
 <tr>
  <th>Size</th>
  <td><?=$row['db_size']?></td>
 </tr>
 <tr>
  <th>Owner</th>
  <td><?=$row['owner']?></td>
 </tr>
 <tr>
  <th>Id</th>
  <td><?=$row['dbid']?></td>
 </tr>
 <tr>
  <th>Created</th>
  <td><?=$row['created']?></td>
 </tr>
 <tr>
  <th>Status</th>
  <td><?=$row['status']?></td>
 </tr>
</table>
<h2>File allocation</h2>
<?php

$db->next_result($result);
echo '<table cellpadding="3" cellspacing="0" class="dataTable">
	<tr>
	 <th>Id</th>
	 <th>Logical name</th>
	 <th>Physical name</th>
	 <th>File group</th>
	 <th nowrap>Size / Max size</th>
	 <th>Growth</th>
	 <th>Usage</th>
	</tr>
';
while ($row = $db->fetch_array($result)) {
	echo '<tr>';
	echo '<td>'.$row['fileid'].'</td>';
	echo '<td>'.$row['name'].'</td>';
	echo '<td>'.stripslashes($row['filename']).'</td>';
	echo '<td>'.$row['filegroup'].'</td>';
	echo '<td nowrap>'.$row['size'].'/'.$row['maxsize'].'</td>';
	echo '<td>'.$row['growth'].'</td>';	
	echo '<td>'.$row['usage'].'</td>';	
	echo '<tr>';
}
echo '</table>';
?>



	

<?php

$page->footer();
?>