<?php
include ('lib/def.inc');

$pageInfos['base'] = $db->base;
$pageInfos['table'] = $table;

$page->header('Edit table record', $pageInfos);

$where = urldecode($_REQUEST['where']);


	switch ($action) {
		case 'edit_record':
			$act->edit_record($table, $where, $_POST['column_name'], $_POST['type_name'], $_POST['is_null'], $_POST['value'], $_POST['data_type'], $_POST['data_function']);
			break;
			
	}
	
?>

<form action="table_edit_data.php" method="post">
 <input type="hidden" name="base" value="<?=$db->base?>">
 <input type="hidden" name="table" value="<?=$table?>">
 <input type="hidden" name="action" value="edit_record">
 <input type="hidden" name="where" value="<?=$where?>">
 <table cellpadding="3" cellspacing="0" class="dataTable">
  <tr>
   <th>Field</th>
   <th>Type</th>
   <th>Function</th>
   <th>NULL</th>
   <th>Value</th>
  </tr>
<?php

$result = $db->query("SELECT * FROM $table WHERE $where");
$record_data = $db->fetch_array($result);

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
		echo '<input type="checkbox" name="is_null['.$row['COLUMN_NAME'].']" '.$enableField.'>';
	} else {
		echo '&nbsp;';
	}	
	echo '</td>';
	
//Valeur
	
	echo '<td>';
	$type = $config['type'][$row['DATA_TYPE']];
	
	switch ($type) {
		case 'text':
			echo '<input type="text" name="value['.$row['COLUMN_NAME'].']" value="'.$record_data[$row['COLUMN_NAME']].'" size="40" maxlength="'.$row['CHAR_OCTET_LENGTH'].'" '.$enableField.'>';
			break;
			
		case 'number':
			echo '<input type="text" name="value['.$row['COLUMN_NAME'].']" value="'.$record_data[$row['COLUMN_NAME']].'" size="10" '.$enableField.'>';
			break;

		case 'bit':
			if ($record_data[$row['COLUMN_NAME']] == 1) {
				$chkOn = 'checked';
				$chkOff = '';
			} else {
				$chkOff = 'checked';
				$chkOn = '';
			}
			echo '<input type="radio" name="value['.$row['COLUMN_NAME'].']" value="1" '.$enableField.' '.$chkOn.'>On <input type="radio" name="value['.$row['COLUMN_NAME'].']" value="0" '.$enableField.' '.$chkOff.'>Off ';
			break;
			
		default:
			echo '<input type="text" name="value['.$row['COLUMN_NAME'].']" value="'.$record_data[$row['COLUMN_NAME']].'" size="40" '.$enableField.'>';
			break;
			
	}	
	
	echo '</td>';
	echo '</tr>';
}
?>
  <tr>
   <td colspan="5" align="center">
    <input type="submit" value="Update Row">
   </td>
  </tr>
 </table>
</form>
<?php
$page->footer();
?>






