<?php
include ('lib/def.inc');

$pageInfos['base'] = $db->base;
$pageInfos['table'] = $table;

$page->header('Design table schema', $pageInfos);

$menu[] = Array('url'   => 'table_design.php?base='.$db->base.'&table='.$table.'&affichage=edit_field',
				'image' => 'images/icons/propriete.gif',
				'title' => 'Modify schema');


switch ($action) {
	case 'drop_field':
		$act->drop_field($table, $_REQUEST['field']);
		break;

	case 'alter_field':
		$act->alter_field($table, $_REQUEST['field_orig'], $_REQUEST['field_type'], $_REQUEST['field_length'], $_REQUEST['field_null']);
		break;
}


switch ($affichage) {
	//Pour détacher une base
	case 'edit_field':
		$primarykeys = $db->getPrimaryKeys($table);
	?>
	<form action="table_design.php" method="post">
	 <input type="hidden" name="base" value="<?=$db->base?>">
	 <input type="hidden" name="table" value="<?=$table?>">
	 <input type="hidden" name="action" value="alter_field">

	 <table cellpadding="3" cellspacing="0" class="dataTable">
	  <tr>
	   <th>Field</th>
	   <th>Type</th>
	   <th>Length / Scale</th>
	   <th>Null</th>
	   <th>P. Key</th>
	  </tr>
		<?php
		$result = $db->query("EXEC sp_columns @table_name='$table'");
		while ($row = $db->fetch_array($result)) {
			echo '<tr>';
		//Nom
			echo '<td>
				<input type="hidden" name="field_orig['.$row['COLUMN_NAME'].']">
				<b>'.$row['COLUMN_NAME'].'</b></td>';
		//Type
			echo '<td><select name="field_type['.$row['COLUMN_NAME'].']">';

			$result2 = $db->query("EXEC sp_datatype_info");
			while ($row2 = $db->fetch_array($result2)) {
				if ($row['TYPE_NAME'] == $row2['TYPE_NAME']) {
					$selected = 'selected';
				} else {
					$selected = '';
				}
				echo '<option value="' . $row2['TYPE_NAME'] . '" '.$selected.'>' . $row2['TYPE_NAME'] . '</option>';
			}
			echo '</select></td>';
			
		//Length
			echo '<td>';
			echo '<input type="text" name="field_length['.$row['COLUMN_NAME'].']" value="'.$row['LENGTH'].'" size="4">';
			echo '<input type="text" name="field_scale['.$row['COLUMN_NAME'].']" value="'.$row['SCALE'].'" size="4">';
			echo '</td>';
		
		//Null
			if ($row['IS_NULLABLE'] == 'YES') {
				$checked = 'checked';
			} else {
				$checked = '';
			}
			echo '<td><input type="checkbox" name="field_null['.$row['COLUMN_NAME'].']" '.$checked.'></td>'; 			

		//Primary key
			
			if (in_array($row['COLUMN_NAME'], $primarykeys)) {
				$checked = 'checked';
			} else {
				$checked = '';
			}
			echo '<td><input type="checkbox" name="field_pkey['.$row['COLUMN_NAME'].']" '.$checked.'></td>'; 			

			
			
			echo "</tr>\n";
		}
		?>
		<tr>
		 <td colspan="6" align="center">
		  <input type="submit" name="" value="Update table">
		 </td>
		</tr>
	</table>
	</form>
	<?php
		break;
		
	default:
	//Recherche des  clés primaires	
	
	$primarykeys = $db->getPrimaryKeys($table);
	?>
	 <table cellpadding="3" cellspacing="0" class="dataTable">
	  <tr>
	   <th>Key</th>
	   <th>Id</th>
	   <th>Field</th>
	   <th>Type</th>
	   <th>Null</th>
	   <th>Default</th>
	   <th>Action</th>
	  </tr>
	<?php
	$result = $db->query("EXEC sp_columns '$table'");
	while ($row = $db->fetch_array($result)) {
	
		echo '<tr>';
		
		if (in_array($row['COLUMN_NAME'], $primarykeys)) {
			echo '<td align="center"><img src="images/icons/key.gif"></td>';
		} else {
			echo '<td>&nbsp;</td>';
		}
		
		if (ereg("identity", $row['TYPE_NAME'])) {
			echo '<td align="center"><img src="images/icons/state_yes.gif"></td>';
		} else {
			echo '<td align="center"><img src="images/icons/state_unknown.gif"></td>';
		}
		
		echo '<td>'.$row['COLUMN_NAME'] . '</td>';
		
	//Type
		echo '<td>'.$row['TYPE_NAME'].'('.$row['PRECISION'].')</td>';
	//NULL ?
		echo '<td align="center">';
		if ($row['NULLABLE'] == 0) {
			echo '<img src="images/icons/state_unknown.gif">';
		} else {
			echo '<img src="images/icons/state_yes.gif">';
		}
		echo '</td>';
	
	//Valeur par default
		echo '<td>';
		if (empty($row['COLUMN_DEF'])) {
			echo '&nbsp;';
		} else {
			echo $row['COLUMN_DEF'];
		}
	 	echo '</td>';
	
	//Actions
		echo '<td align="center"><a href="javascript:confirmAction(\'DELETE the field '.$row['COLUMN_NAME'].'\',\'table_design.php?base='.$db->base.'&table='.$table.'&action=drop_field&field='.$row['COLUMN_NAME'].'\');"><img src="images/icons/delete.gif" alt="Drop"></a></td>';
		echo '</tr>';
	
	}
?>
 </table>
<?php
	break;
}
$page->footer();
?>






