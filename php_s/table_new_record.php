<?php
include ('lib/def.inc');

$pageInfos['base'] = $db->base;
$pageInfos['table'] = $table;

$page->header('Insert new table record', $pageInfos);

	switch ($action) {
		//Pour détacher une base
		case 'add_record':
			$act->new_record($table, $_REQUEST['column_name'], $_REQUEST['type_name'], $_REQUEST['is_null'], $_REQUEST['value'], $_REQUEST['data_type'], $_REQUEST['data_function']);
			break;			
	}
	
?>

<form action="table_new_record.php" method="post">
 <input type="hidden" name="base" value="<?=$db->base?>">
 <input type="hidden" name="table" value="<?=$table?>">
 <input type="hidden" name="action" value="add_record">
 <table cellpadding="3" cellspacing="0" class="dataTable">
  <tr>
   <th>Field</th>
   <th>Type</th>
   <th>Function</th>
   <th>NULL</th>
   <th>Value</th>
  </tr>
<?php
$result = $db->query("EXEC sp_columns $table");
while ($row = $db->fetch_array($result)) {
	if (ereg("identity", $row['TYPE_NAME'])) {
		$enableField = 'disabled readonly';
	} else {
		$enableField = '';
	}
	
	
	echo '<tr>';
	
	echo '<td>'.$row['COLUMN_NAME'].'
		<input type="hidden" name="column_name['.$row['COLUMN_NAME'].']" value="'.$row['COLUMN_NAME'].'">
		</td>';
	
//Type
	echo '<td>'.$row['TYPE_NAME'].'('.$row['PRECISION'].')
			<input type="hidden" name="data_type['.$row['COLUMN_NAME'].']" value="'.$row['DATA_TYPE'].'">
			<input type="hidden" name="type_name['.$row['COLUMN_NAME'].']" value="'.$row['TYPE_NAME'].'">
			</td>';
	
//Fonctions
	echo '<td><select name="data_function['.$row['COLUMN_NAME'].']" '.$enableField.'>
			<option value="">---</option>';
	foreach($config['SQLfunctions'] as $key) {
		echo '<option value="'.$key.'">'.$key.'</option>';
	}
	echo '</select></td>';
	
//NULL ?
	echo '<td>';
	if ($row['IS_NULLABLE'] == 'YES') {
		echo '<input type="checkbox" name="is_null['.$row['COLUMN_NAME'].']" '.$enableField.' checked>';
	} else {
		echo '&nbsp;';
	}	
	echo '</td>';
	
//Valeur
	
	echo '<td>';
	
	switch ($row['TYPE_NAME']) {
		case 'varchar':
			echo '<input type="text" name="value['.$row['COLUMN_NAME'].']" value="" size="40" maxlength="'.$row['CHAR_OCTET_LENGTH'].'" '.$enableField.'>';
			break;
			
		case 'int':
			echo '<input type="text" name="value['.$row['COLUMN_NAME'].']" value="0" size="10" '.$enableField.'>';
			break;

		case 'bit':
			echo '<input type="radio" name="value['.$row['COLUMN_NAME'].']" value="1" '.$enableField.'>On <input type="radio" name="value['.$row['COLUMN_NAME'].']" value="0" '.$enableField.'>Off ';
			break;
			
		default:
			echo '<input type="text" name="value['.$row['COLUMN_NAME'].']" value="" size="40" '.$enableField.'>';
			break;
			
	}	
	
	echo '</td>';
	echo '</tr>';
}
?>
  <tr>
   <td colspan="5" align="center">
    <input type="submit" value="Insert row">
   </td>
  </tr>
 </table>
</form>
<?php
$page->footer();
?>






