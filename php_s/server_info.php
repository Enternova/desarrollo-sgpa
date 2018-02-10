<?php
include ('lib/def.inc');

$page->header('Home', $pageInfos);

?>
<H2>Server data type</H2>
<?php

//Datatype list
$result= $db->query("EXEC sp_server_info ");

	echo '<table cellpadding="3" cellspacing="0" class="dataTable">
		<tr>
		 <th>Attribute name</th>
		 <th>Value</th>
		</tr>
	';
while ($row = $db->fetch_array($result)) {
	    echo '<tr>';
		echo '<th>'.$row['attribute_name'].'</th>';
		echo '<td>'.$row['attribute_value'].'</td>';
        echo '</tr>';
	}
	echo '</table>';

$page->footer();
?>
