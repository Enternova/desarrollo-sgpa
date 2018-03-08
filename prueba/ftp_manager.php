<?php

$Ftp_Connect = new FileManagerTools ("192.168.127.31","sgpa","942ASvle*P");

$Ftp_Connect->FtpUpload("E:/sgpa_files/attfiles/pasar_ftp/","F:/sgpa_files/attfiles/paso/","");
echo $Ftp_Connect->FileState;		

	class FileManagerTools {

	//Configurations parameters

	protected $ftpurl;
	protected $ftpuser;
	protected $ftppass;
	public $FileState;
	protected $ftpconnection;
	protected $ftplogin;
	protected $ftp_ForD;

	//Counters
	protected $FilesCount;
	protected $DirCount;

	function __construct($ftpurl,$ftpuser,$ftppass){

		$this->ftpurl = $ftpurl;
		$this->ftpuser = $ftpuser;
		$this->ftppass = $ftppass;
		$this->FileState = "File operations state for <b>$ftpuser</b> on <b>$ftpurl</b> is: \n";	
	}
	
	function Ftp_Connect() {

		// connect to the destination FTP & enter appropriate directories both locally and remotely
		$this->ftpconnection = @ftp_connect($this->ftpurl) or die("ftpserver_connect_error");
		$this->ftplogin = @ftp_login($this->ftpconnection,$this->ftpuser,$this->ftppass) or die("ftpserver_auth_error");

	}

// --------------------------------------------------------------------
// Upload FUNCTIONS
// --------------------------------------------------------------------

	function FtpUpload($ftpsrcitems1,$ftpdstdir1,$ftpdstfilename) {
		//Uploads counter
		$this->FilesCount = 0;
		$this->DirCount = 0;

		//Connect to Ftp server
		$this->Ftp_Connect();
		$this->FileState .= "connection done, ";

		$this->FtpUpload_loop($ftpsrcitems1,$ftpdstdir1,$ftpdstfilename);

		$this->FileState .= "$ftpsrcitems1 is uploaded successfully to $ftpdstdir1 with ".$this->DirCount." directories and ".$this->FilesCount." files";
		ftp_close($this->ftpconnection);
		$this->FileState .= " , connection closed";	

	}

	function FtpUpload_loop($ftpsrcitems,$ftpdstdir,$ftpdstfilename) {

		//Check existance and the kind of uploads of either the file or dir
		if (file_exists($ftpsrcitems)) {
			if (is_dir($ftpsrcitems)) {
				$ftp_ForD = "D";
				if (@chdir($ftpsrcitems)) { 
				}else{ die("$ftpsrcitems ftpsource_dirpermission_error"); }
			}else{ $ftp_ForD = "F"; }
		}else{ die("$ftpsrcitems ftpsource_notexist_error"); }


		if ($ftp_ForD === "D") {

			// enter the local directory to be recursed through
			chdir($ftpsrcitems);

			// check if the directory exists & change to it on the destination
			if (@ftp_chdir($this->ftpconnection,$ftpdstdir))
			{
      
			ftp_chdir($this->ftpconnection,$ftpdstdir);

			} else {  
				// remote directory doesn't exist so create & enter it
				//ftp_mkdir($this->ftpconnection,$ftpdstdir);
				//ftp_chdir($this->ftpconnection,$ftpdstdir);
				}
			if ($ftp_handle = opendir($ftpsrcitems)) {

				while (false !== ($ftp_fil = readdir($ftp_handle))) {
					 if ($ftp_fil != "." && $ftp_fil != "..")  {
               
						// check if it's a file or directory
						if (!is_dir($ftp_fil)) {   
					 		// it's a file so upload it
							$this->FilesCount++;
							ftp_put($this->ftpconnection, $ftpdstdir.$ftp_fil, $ftp_fil, FTP_BINARY);
						}
						else {
                    					// it's a directory so recurse through it
							if ($ftp_fil == "templates_dir_something") {
								// I want the script to ignore any directories named "templates"
								// and therefore, not recurse through them and upload their contents
							}
							else {
								$this->DirCount++;

								$ftpsrcitems = $ftpsrcitems.$ftp_fil."/";
								$ftpdstdir = $ftpdstdir.$ftp_fil."/";
								$this->FtpUpload_loop($ftpsrcitems,$ftpdstdir,"dstfilename");
								chdir ("../");
							}
						}
					}
				}
				closedir($ftp_handle);
			}   
	
		}
		else {
			$this->FilesCount++;

			// it's a file so upload it
			ftp_put($this->ftpconnection, $ftpdstdir.$ftpdstfilename, $ftpsrcitems, FTP_BINARY);
		}

	}
}
?>
