<?php	
include ('lib/def.inc');

$pageInfos['base'] = $db->base;

$page->header('Execute SQL query', $pageInfos);

if (isset($_REQUEST['sql_query_text'])) {
	$query = trim(stripslashes($_REQUEST['sql_query_text']));
} else {
	$query='';
}

if (isset($_FILES['sql_query_file'])) {
	switch ($_FILES['sql_query_file']['error']) {
		//Le fichier est ok;
		case UPLOAD_ERR_OK:
			$query = file_get_contents ( $_FILES['sql_query_file']['tmp_name']);
			
			break;
			
		case UPLOAD_ERR_INI_SIZE:
			$page->msgInfo("File is too big");
			break;

		case UPLOAD_ERR_FORM_SIZE:
			$page->msgInfo("File is too big");
			break;

		case UPLOAD_ERR_PARTIAL:
			$page->msgInfo("Error getting file : partial content has been received");
			break;

		case UPLOAD_ERR_NO_FILE:
			break;
	}
}
?>

<form action="db_exec_sql.php" method="post" enctype="multipart/form-data">
<input type="hidden" name="base" value="<?=$db->base?>">
<textarea name="sql_query_text" rows="10" cols="70" wrap="off"><?=$query?></textarea><br>
Select file<br>
<input type="file" name="sql_query_file"><br>
<input type="submit" value="Execute">
		
</form>
<?php
if (!empty($query)) {
	$db->displayQuery($query);

	if ($result = $db->query($query)) {
		
		if (ereg("^SELECT", $query)) {
			if ($db->num_rows($result) == 0) {
				echo 'No records in this table<br>';
			} else {
				$fields = Array();
				while ($field = $db->fetch_field ($result)) {
					$fields[] = $field;
				}
							
				echo '<form action="" method="post">';	
				echo '<table cellspacing="0" cellpadding="3" class="dataTable">';
				echo '<tr>';
				
				foreach ($fields as $key => $field) {
					echo '<th>' . $field->name . '</th>';	
				}
				
				echo '</tr>';
				
				while ($row = $db->fetch_array($result)) {
					
					echo '<tr>';
					foreach ($fields as $key => $field) {
						echo '<td>';
						if (empty($row[$field->name])) {
							echo '&nbsp;';
						} else {
							echo $row[$field->name];
						}
						echo '</td>';	
					}
					
					echo '</tr>';
				}
				echo '</table></form>';
			}
		}
	}
}

$page->footer();
?>
