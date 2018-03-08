<?  include("../lib/@session.php");

	$link = mysql_connect($host_mys,$usr_mys, $pwd_mys);
	mysql_select_db($dbbase_mys, $link);



//Cyrillic_General_CI_AI - Latin1_CI_AS  quita las tildes
		 $lista_inci = "select pro1_id, consecutivo from pro1_proceso where tp2_id = 30 and cd_id_entrega_documentos =0 and consecutivo like '%$q%' order by pro1_id desc ";
		 
		 $sql_ex=mysql_query($lista_inci);
		while ($lt=mysql_fetch_row($sql_ex)){ 
			
			$objeto = $lt[1]."----,".$lt[0]."----";
			?>
            <?=$objeto?>
            
		<? } 
		
		
		
		?>