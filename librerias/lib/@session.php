<? session_start();
	ob_start();
header('Content-Type: text/html; charset=ISO-8859-1');


	
if($_SESSION["session_id"]==""){ 


?>
		<script>window.parent.location.href="/sgpa_calidad_2018/"</script>
        <?
	exit();
	}
	else
		{
			require(dirname(__FILE__)."/@include.php");
		}
?>
<?
//header('Content-Type: text/xml; charset=ISO-8859-1');
?>