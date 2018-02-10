<? session_start();
	ob_start();

$pr=1;

$_SESSION["id_us_session"] = $pr;
	
echo $_SESSION["id_us_session"];
?>