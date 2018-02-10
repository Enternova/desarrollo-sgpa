<?php
include ('lib/def.inc');

$pageInfos['base'] = $db->base;

$page->header('Create table schema', $pageInfos);

switch ($affichage) {
	//Pour détacher une base
	case 'full_form':
		$nb_fields = intval($_REQUEST['table_size']);
		if ($nb_fields <= 0) {
			$nb_fields = 5;
		}
		
	?>
	<form action="db_tables.php" method="post">
	 <input type="hidden" name="base" value="<?=$db->base?>">
	 <input type="hidden" name="action" value="create_table">
	
	 <table cellpadding="3" cellspacing="0" class="dataTable">
	  <tr>
	   <th>Field</th>
	   <th>Type</th>
	   <th>Length / Scale</th>
	   <th>Null</th>
	   <th>Identity<br>Start / Step</th>
	   <th>Default</th>
	   <th>P. Key</th>
	  </tr>
		<?php
		for($i = 0; $i< $nb_fields; $i++) {
			echo '<tr>';
		//Nom
			echo '<td>
				<input type="hidden" name="field['.$i.']">
				<input type="text" name="field_name['.$i.']" value="" size="15"></td>';
		//Type
			echo '<td><select name="field_type['.$i.']">';
			foreach ($db->getTypeInfo() as $type => $var) {
				echo '<option value="' . $type . '">' . $type . '</option>';
			}
			echo '</select></td>';

		//Length
			echo '<td nowrap>';
			echo '<input type="text" name="field_length['.$i.']" value="" size="4">';
			echo '<input type="text" name="field_scale['.$i.']" value="" size="2">';
			echo '</td>';

		//Null
			echo '<td><input type="checkbox" name="field_null['.$i.']" checked></td>';

		//Identity
			echo '<td nowrap>
			        <input type="text" name="field_id_start['.$i.']" value="" size="2">
					<input type="text" name="field_id_step['.$i.']" value="" size="2">
				</td>';

		//Default
			echo '<td><input type="text" name="field_default['.$i.']" value="" size="15"></td>';

		//Primary key
			echo '<td><input type="checkbox" name="field_pkey['.$i.']"></td>';

			echo "</tr>\n";
		}
		?>
	</table>
	<br><br>
	 <table cellpadding="3" cellspacing="0" class="dataTable">
	  <tr>
	   <th>Table Name</th>
	  </tr>
	  <tr>
	   <td><input type="text" name="table_name" value="<?=$_REQUEST['table_name']?>" size="20"></td>
	  </tr>
	  <tr>
	   <td colspan="2" align="right">
	    <input type="submit" value="Save">
	   </td>
	  </tr>
	 </table>	
	</form>
	
	<?php
		break;
		
	default:
	//Recherche des  clés primaires	
	?>
	
	<form action="table_create.php" method="post">
	 <input type="hidden" name="base" value="<?=$db->base?>">
	 <input type="hidden" name="affichage" value="full_form">
	 <table cellpadding="3" cellspacing="0" class="dataTable">
	  <tr>
	   <th>Table Name</th>
	   <th>Number of fields</th>
	  </tr>
	  <tr>
	   <td><input type="text" name="table_name" value="" size="20"></td>
	   <td><input type="text" name="table_size" value="10" size="5"></td>
	  </tr>
	  <tr>
	   <td colspan="2" align="right">
	    <input type="submit" value="Next &gt;&gt;">
	   </td>
	  </tr>
	 </table>
	</form>
	<?php
	break;
}
$page->footer();
?>






