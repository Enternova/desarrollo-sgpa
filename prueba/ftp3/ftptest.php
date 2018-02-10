<?php
/*
 * Created on 22/07/2009
 *
 * To change the template for this generated file go to
 * Window - Preferences - PHPeclipse - PHP - Code Templates
 */
if(isset($_POST['start_upload']) && $_FILES['txt_file']['name'] != ""){
	include('ftp.class.php');
	new ftp($_FILES['txt_file']['tmp_name'], "/home/wdnet/novapasta/".basename($_FILES['txt_file']['name']), '200.165.139.3', 'wdnet', 'WDNET');
}
?>
<form action="" method="POST" enctype="multipart/form-data">
   Please choose a file: <input name="txt_file" type="file" size="35" />
<input type="submit" name="start_upload" value="Upload File"/>
</form>