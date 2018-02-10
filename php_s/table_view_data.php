<?php
include ('lib/def.inc');

$pageInfos['base'] = $db->base;
$pageInfos['table'] = $table;

$page->header('View table data', $pageInfos);

$menu[] = Array('url'   => 'table_new_record.php?base='.$db->base.'&table='.$table,
				'image' => 'images/icons/new.gif',
				'title' => 'Add new record');


switch ($action) {
	//To delete a record
	case 'delete_record':
		$act->delete_record($table, urldecode($_REQUEST['where']));
		break;
		
}
$primarykeys = $db->getPrimaryKeys($table);

if (empty($_REQUEST['orderField'])) {
	$orderField = '';
} else {
	$orderField = $_REQUEST['orderField'];
}

if (empty($_REQUEST['top'])) {
	$top = $config['top_values'][0];
} else {
	$top = $_REQUEST['top'];
}

if (empty($_REQUEST['orderWay'])) {
	$orderWay = 'ASC';
} else {
	$orderWay = $_REQUEST['orderWay'];
}
if (!empty($orderField)) {
	$orderSQL = " ORDER BY $orderField $orderWay";
} else {
	$orderSQL = '';
}

?>
<form action="table_view_data.php" method="post" name="frm_top">
 <input type="hidden" name="base" value="<?=$db->base?>">
 <input type="hidden" name="table" value="<?=$table?>">
 <input type="hidden" name="orderWay" value="<?=$orderWay?>">
 <input type="hidden" name="orderField" value="<?=$orderField?>"> 
  Display only the
  <select name="top" onChange='document.frm_top.submit()'>
	<?php
	foreach ($config['top_values'] as $value) {
	   if ($value == $top) $selected = 'selected'; else $selected = '';
	   echo '<option value="'.$value.'" '.$selected.'>'.$value.'</option>';
   	} 
    ?>
  </select>
  first records
</form>
<?php

$query = "SELECT TOP $top * FROM $table $orderSQL";


$result = $db->query($query);
$db->displayQuery($query);

if ($db->num_rows($result) == 0) {
	echo 'No records in this table<br>';
} else {
	//Récupère les infos sur un champs
	$fields = $db->getColumnType($table);
		
	echo '<form action="" method="post">';	
	echo '<table cellspacing="0" cellpadding="3" class="dataTable">';
	echo '<tr>';
	echo '<th>&nbsp;</th>';
	
	foreach ($fields as $field => $fieldProp) {
		echo '<th>';
		echo '<a href="table_view_data.php?base='.$db->base.'&table='.$table.'&orderField='.$field.'&orderWay=ASC" title="Order ASC"><img src="images/icons/order_ASC.gif" alt="^"></a> ';
		echo $field;
		echo '<a href="table_view_data.php?base='.$db->base.'&table='.$table.'&orderField='.$field.'&orderWay=DESC" title="Order" DESC><img src="images/icons/order_DESC.gif" alt="v"></a> ';
		echo '</th>';	
	}
	
	echo '</tr>';
	
	while ($row = $db->fetch_array($result)) {
		$key = Array();
		foreach($primarykeys as $key_name) {
			$type_infos = $db->getTypeInfo($fields[$key_name]['TYPE_NAME']);
			$key[] = $key_name . '=' . $type_infos['LITERAL_PREFIX'] . $row[$key_name] . $type_infos['LITERAL_SUFFIX'];
		}
		$where = implode(" AND ", $key);
		unset ($key);
		
		echo '<tr>';
		//echo '<td><input type="checkbox" name="" value=""></td>';
		echo '<td><a href="javascript:confirmAction(\'DELETE this record\',\'table_view_data.php?base='.$db->base.'&table='.$table.'&action=delete_record&where='.urlencode(urlencode($where)).'\');"><img src="images/icons/delete.gif" alt="Delete"></a>
				  <a href="table_edit_data.php?base='.$db->base.'&table='.$table.'&where='.urlencode($where).'"><img src="images/icons/propriete.gif" alt="Edit"></a>
				 </td>';
		
		foreach ($fields as $field => $fieldProp) {
			echo '<td>';
			if (empty($row[$field])) {
				echo '&nbsp;';
			} else {
				echo $row[$field];
			}
			echo '</td>';	
		}
		
		echo '</tr>';
	}
	echo '</table></form>';
}




$page->footer();
?>