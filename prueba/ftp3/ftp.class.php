<?php
class ftp {
	
	var $local_file;
	var $destination_file;
	var $ftp_server;
	var $ftp_user_name;
	var $ftp_user_pass;
	var $conn_id;
	
	function ftp($local_file, $destination_file, $ftp_server, $ftp_user_name, $ftp_user_pass) {
	set_time_limit(0);
	$this->local_file = $local_file;
    $this->destination_file = $destination_file;
    $this->ftp_server = $ftp_server;
    $this->ftp_user_name = $ftp_user_name;
    $this->ftp_user_pass = $ftp_user_pass;
    $this->upload();
	}
	function connect(){
		$this->conn_id = ftp_connect($this->ftp_server);
		$login_result = ftp_login($this->conn_id, $this->ftp_user_name, $this->ftp_user_pass);
		if ((!$this->conn_id) || (!$login_result)) {
        return false;
    } else {
      	return true;
    }
       
	}
	function upload(){
		$this->connect();
		$upload = ftp_put($this->conn_id, $this->destination_file, $this->local_file, FTP_BINARY);  // Upload the File
   
    // Verify Upload Status
    if (!$upload) {
        echo "<h2>FTP upload of ".$_FILES['txt_file']['name']." has failed!</h2><br /><br />";
    } else {
        echo "Success!<br />" . $_FILES['txt_file']['name'] . " has been uploaded to " . $this->ftp_server . $this->destination_file . "!<br /><br />";
    }
	}

}
?>
