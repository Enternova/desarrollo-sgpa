<?php
include ('lib/def.inc');

$page->header('Create database', $pageInfos);
?>

<form action="index.php" method="post">
 <input type="hidden" name="action" value="create_db">
 <table cellpadding="3" cellspacing="0" class="dataTable">
  <tr>
   <th>Database Name</th>
   <td colspan="3"><input type="text" name="database_name" value="<?=$_REQUEST['database_name']?>" size="40"></td>
  </tr>

<!--
  </table>
 <table cellpadding="3" cellspacing="0" class="dataTable"> 
-->
  <tr>
   <th>&nbsp;</th>
   <th>Logical name</th>
   <th>Physical name<br>(path to file, C:\...)</th>
   <th>Size<br>(in Mb)</th>
  </tr>
  <tr>
   <th>System file</th>
   <td><input type="text" name="sys[logical]" value="<?=$_REQUEST['database_name']?>_SYS" size="15"></td>
   <td><input type="text" name="sys[physical]" value="<?=$config['database']['default_path']?><?=$_REQUEST['database_name']?>_SYS.mdf" size="20"></td>
   <td><input type="text" name="sys[size]" value="1" size="5"></td>
  </tr>
  <tr>
   <th>Log file</th>
   <td><input type="text" name="log[logical]" value="<?=$_REQUEST['database_name']?>_LOG" size="15"></td>
   <td><input type="text" name="log[physical]" value="<?=$config['database']['default_path']?><?=$_REQUEST['database_name']?>_LOG.ldf" size="20"></td>
   <td><input type="text" name="log[size]" value="1" size="5"></td>
  </tr>
  <tr>
   <th>Data file 1</th>
   <td><input type="text" name="data[1][logical]" value="<?=$_REQUEST['database_name']?>_DATA" size="15"></td>
   <td><input type="text" name="data[1][physical]" value="<?=$config['database']['default_path']?><?=$_REQUEST['database_name']?>_DATA.ndf" size="20"></td>
   <td><input type="text" name="data[1][size]" value="1" size="5"></td>
  </tr>

<?php
	for ($i = 2; $i <= 5; $i++) {
?>
  <tr>
   <th>Data file <?=$i?></th>
   <td><input type="text" name="data[<?=$i?>][logical]" value="" size="15"></td>
   <td><input type="text" name="data[<?=$i?>][physical]" value="" size="20"></td>
   <td><input type="text" name="data[<?=$i?>][size]" value="1" size="5"></td>
  </tr>
<? } ?>
  <tr>
   <td colspan="4" align="right">
    <input type="submit" value="Create &gt;&gt;">
   </td>
  </tr>
 </table>

</form>




<?php
$page->footer();
?>