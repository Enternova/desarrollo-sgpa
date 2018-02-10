<?php
include ('lib/def.inc');

$pageInfos['base'] = $db->base;
$page->header('List of tables', $pageInfos);


$menu[] = Array('url'   => 'db_tables.php?base='.$db->base,
				'image' => 'images/icons/table.gif',
				'title' => 'Table list');
$menu[] = Array('url'   => 'table_create.php?base='.$db->base,
				'image' => 'images/icons/new.gif',
				'title' => 'Create table');
$menu[] = Array('url'   => 'db_exec_sql.php?base='.$db->base,
				'image' => 'images/icons/sql.gif',
				'title' => 'SQL');

switch ($action) {
	//Pour détacher une base
	case 'detach_db':
		$act->detach_db($baseToDetach);
		break;
		
	//Pour supprimer une base
	case 'delete_db':
		$act->delete_db($baseToDelete);
		break;

	//Pour supprimer une base
	case 'empty_table':
		$act->empty_table($table);
		break;

	//Pour supprimer une base
	case 'drop_table':
		$act->drop_table($table);
		break;	
			
	case 'create_table':
		$act->create_table($_REQUEST['table_name'], $_REQUEST['field'], $_REQUEST['field_name'], $_REQUEST['field_type'], $_REQUEST['field_length'], $_REQUEST['field_scale'], $_REQUEST['field_null'], $_REQUEST['field_id'], $_REQUEST['field_id_start'], $_REQUEST['field_id_step'], $_REQUEST['field_default'], $_REQUEST['field_pkey']);
		break;
}



$result = $db->query("EXEC sp_tables @table_type = \"'TABLE'\"");
if ($db->num_rows($result) == 0) {
	echo 'Aucune table présente dans cette base<br>';
} else {
	echo '<table cellpadding="3" cellspacing="0" class="dataTable">
		<tr>
		 <th>&nbsp;</th>
		 <th>Table</th>
		 <th>Action</th>
		 <th>Records</th>
		 <th>Owner</th>
		</tr>
	';
	
	while ($row = $db->fetch_array($result)) {
		$nbRecord = $db->result($db->query("SELECT COUNT(*) as nb FROM " . $row['TABLE_NAME']), 0, 'nb');
		
		echo '<tr>
			<td>&nbsp;</td>
			<td><b>'.$row['TABLE_NAME'].'</b></td>
			<td>
				<a href="table_design.php?base='.$db->base.'&table=' . $row['TABLE_NAME'] . '"><img src="images/icons/propriete.gif" alt="Design"></a>
				<a href="table_view_data.php?base='.$db->base.'&table=' . $row['TABLE_NAME'] . '"><img src="images/icons/table.gif" alt="View data"></a>
				<a href="table_new_record.php?base='.$db->base.'&table=' . $row['TABLE_NAME'] . '"><img src="images/icons/new.gif" alt="Insert data"></a>
				<a href="javascript:confirmAction(\'DROP TABLE '.$row['TABLE_NAME'].'\', \'db_tables.php?base='.$db->base.'&table='.$row['TABLE_NAME'].'&action=drop_table\');"><img src="images/icons/delete.gif" alt="Drop"></a>
				<a href="javascript:confirmAction(\'DELETE all records FROM '.$row['TABLE_NAME'].'\', \'db_tables.php?base='.$db->base.'&table='.$row['TABLE_NAME'].'&action=empty_table\');"><img src="images/icons/empty.gif" alt="Empty"></a>
			</td>
			<td align="right">'.$nbRecord.'</td>
			<td>'.$row['TABLE_OWNER'].'</td>
			</tr>';
	}

	echo '</table>';	
}

$page->footer();
?>