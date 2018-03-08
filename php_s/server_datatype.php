<?php
include ('lib/def.inc');

$page->header('Home', $pageInfos);

?>
<H2>Server data type</H2>
<?php

//Datatype list
	$row = $db->getTypeInfo();
	echo '<table cellpadding="3" cellspacing="0" class="dataTable">
		<tr>
		<th>TYPE_NAME</th>
		<th>PRECISION</th>
		<th>DATA_TYPE</th>
		<th>CREATE_PARAMS</th>
		<th>LITERAL_PREFIX</th>
		<th>LITERAL_SUFFIX</th>
		</tr>
	';
	foreach ($row as $type => $type_detail) {
        echo '<tr>';
		echo '<th>'.$type_detail['TYPE_NAME'].'</th>';
		echo '<td>'.$type_detail['PRECISION'].'</td>';
		echo '<td>'.$type_detail['DATA_TYPE'].'</td>';
        echo '<td>'.$type_detail['CREATE_PARAMS'].'</td>';
        echo '<td>'.$type_detail['LITERAL_PREFIX'].'</td>';
        echo '<td>'.$type_detail['LITERAL_SUFFIX'].'</td>';
        
        echo '</tr>';
	}
	echo '</table>';

$page->footer();
?>
