<? session_start();
	ob_start();
	if($_SESSION["session_id"]==""){ ?>
		<script>window.parent.location.href="../../../"</script>
        <?
	exit();
	}
	else
		{
			require(dirname(__FILE__)."/@include.php");
		
		}

?>