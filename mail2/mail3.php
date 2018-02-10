<? 

	$subject = "p hocol";
	$headers = "MIME-Version: 1.0\n";
	$headers.= "Content-Type: text/html; charset=\"utf-8\"\n";
	$headers.= "From:abastecimiento@hocol.com.co\r\n";
	$headers.="X-Mailer: PHP/". phpversion()."\n";
	$headers.= "Reply-To: abastecimiento@hocol.com.co \r\n";
	$headers.= "Return-Path: <abastecimiento@hocol.com.co>\r\n";
		
	echo mail("rene.sterling@enternova.net", $subject, "hocol prueba", $headers);

	

?>