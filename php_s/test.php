<?php

session_name("PHPmsSQL");
@session_start();

if (isset($_SESSION["testvar"])) {
	$_SESSION["testvar"]++;
} else {
	$_SESSION["testvar"] = 0;
} 

include('lib/config.inc');
include('lib/page.class.inc');

$page = new Page();
$page->headerHTML();

?>
<table width="100%" border="0" cellpadding="0" cellspacing="0" bgcolor="#7B74DD" height="60">
 <tr>
  <td align="left"><a href="index.php"><img src="images/logo.jpg"><a></td>
  <td align="right" width="200"><font size="5" color="#FFFFFF">Test Page</font></td>
 </tr>
</table>

<p>
 <a href="test.php?view=global">Global</a> |
 <a href="test.php?view=phpinfo">PHP info</a> |
 <a href="test.php?view=mssql">SQL server test</a>
</p>


<?php

if (empty($_REQUEST['view']))   $view='';   else $view=$_REQUEST['view'];
if (empty($_REQUEST['action'])) $action=''; else $action=$_REQUEST['action'];

  switch ($view) {
	case 'mssql':
	
		if ($action=='testmssql') {
			if ($connexion = @mssql_connect($_REQUEST['test']['host'], $_REQUEST['test']['user'], $_REQUEST['test']['pass'])) {
				echo test(true) . 'Connexion successfull<br><br>Server info :';
				
				echo '<table cellspacing="0" cellpadding="3" class="dataTable">
				<tr>
				 <th>Option</th>
				 <th>Value</th>
				</tr>';
				$result = mssql_query("EXEC sp_server_info", $connexion);
				while ($row = mssql_fetch_array($result)) {
					/*
					foreach ($row as $key=>$val) {
					echo "$key = $val<br>";	
					}*/
					
					echo '<tr>
					  		<td>'.$row['attribute_name'].'</td>
					  		<td>'.$row['attribute_value'].'</td>
					  	  </tr>';
				}
				echo '</table>';				
			} else {
				echo test(false) . 'Connexion failed';
			}
		}
	
	
	?>
	<form action="" method="post">
	 <input type="hidden" name="view" value="mssql">
	 <input type="hidden" name="action" value="testmssql">
	 <table>
	  <tr>
	   <th>Server</th>
	   <th><input type="text" name="test[host]" size="20" value="<?php if(!empty($_REQUEST['test']['host'])) echo $_REQUEST['test']['host'];?>"></th>
	  </tr>
	  <tr>
	   <th>User</th>
	   <th><input type="text" name="test[user]" size="20" value="<?php if(!empty($_REQUEST['test']['user'])) echo $_REQUEST['test']['user'];?>"></th>
	  </tr>
	  <tr>
	   <th>Password</th>
	   <th><input type="password" name="test[pass]" size="20" value="<?php if(!empty($_REQUEST['test']['pass'])) echo $_REQUEST['test']['pass'];?>"></th>
	  </tr>
	  <tr>
	   <td colspan="2" align="center">
	    <input type="submit" value="Test it !">
	    <input type="reset" value="undo">
	   </td>
	  </tr>
	 </table>
	</form>

	<?php
		break;

	case 'phpinfo':
		phpinfo();
		break;

 	case 'global':
 	default:
 	?>
<table cellspacing="0" cellpadding="3" class="dataTable">
 <tr>
  <th><img src="images/icons/state_unknown.gif"></th>
  <th>Configuration</th>
  <th>Your config</th>
  <th>Required</th>
 </tr>
 <tr>
  <td><img src="images/icons/state_unknown.gif"></td>
  <td>Session</td>
  <td><?=$_SESSION["testvar"]?></td>
  <td><a href="test.php">Must increment when click here</a></td>
 </tr>
 <tr>
  <td><? test(version_compare(phpversion(), $config['required']['PHP_version'], ">")) ?></td>
  <td>PHP Version</td>
  <td><?=phpversion()?></td>
  <td><?=$config['required']['PHP_version']?></td>
 </tr>
 <tr>
  <td><? test(extension_loaded($config['required']['PHP_mssql_extension'])) ?></td>
  <td>SQL Server extension</td>
  <td><?php
  	if (extension_loaded($config['required']['PHP_mssql_extension'])) {
  		echo 'loaded';
  	} else {	
  		echo 'not loaded';
  	}?></td>
  <td>Must be loaded</td>
 </tr>
</table>
 	<?php
 	break;
  	
  }
?>




<?php
	function test($var) {
		if ($var) {
			$img = 'state_yes.gif';
		} else {
			$img = 'state_no.gif';
		}
		echo '<img src="images/icons/'.$img.'">';
	}

$page->footerHTML();
?>