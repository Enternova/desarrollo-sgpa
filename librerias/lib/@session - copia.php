<? session_start();
	ob_start();
	if($_SESSION["session_id"]==""){ ?>
		<script>window.parent.location.href="/sgpa/"</script>
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