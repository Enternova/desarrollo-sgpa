<?php

/*##################################################

# Class Name 	: myFTP								#
# Author 		: HUSSON KEVIN						#
# Email 		: husson.kevin@gmail.com			#
# Version		: 1.0								#

###################################################*/

class myFTP{

	public $user;
	public $pass;
	public $server;
	public $port;
	public $modepassif;

	private $connect_id = false;
	private $login_id = false;
	private $connectionOK = false;


	#################################################
	#												#
	#					CONSTRUCT					#
	#												#
	#################################################
		public function __construct($host, $user, $pass = false, $port = 21, $mode = false){
			$this->user = $user;
			$this->pass = $pass;
			$this->server = $host;
			$this->port = $port;
			$this->modepassif = $mode;
			$this->login();
		}

	#################################################
	#												#
	#					CONNECT						#
	#												#
	#################################################
		public function login(){
			if(!$this->connect_id){
				$this->connect_id = ftp_connect($this->server, $this->port);
				if(!$this->connect_id)
					throw new Exception ("Can't connect to server");
			}
			if(!$this->login_id){
				if($this->login_id = ftp_login($this->connect_id, $this->user, $this->pass))
					$this->connectionOK = true;
				else
					throw new Exception ("Wrong 'Login' or 'Password'.");
			}
			/*
			if(!ftp_pasv($this->connect_id, $this->modepassif)){
				if(!ftp_pasv($this->connect_id, !$this->modepassif))
					throw new Exception("Wrong Mode.");
			}
			*/
		}


	#################################################
	#												#
	#					LIST SIMPLE					#
	#												#
	#################################################
		public function list_simple($dir){
			if($this->connectionOK)
				return ftp_nlist($this->connect_id, $dir);
			else
				throw new Exception("You must be connect.");
		}


	#################################################
	#												#
	#					LIST DETAIL					#
	#												#
	#################################################
		public function list_hard($dir){
			if($this->connectionOK)
				return array(ftp_rawlist($this->connect_id, $dir));
			else
				throw new Exception("You must be connect.");
		}


	#################################################
	#												#
	#					CURRENT FOLDER				#
	#												#
	#################################################
		public function pwd(){
			if($this->connectionOK){
				$this->dir = ftp_pwd($this->connect_id);
				return $this->dir;
			}
			else
				throw new Exception("You must be connect.");
		}


	#################################################
	#												#
	#					LISTING						#
	#												#
	#################################################
		public function cd($dir){
			if($this->connectionOK){
				// If it's a folder
				if(ftp_chdir($this->connect_id, $dir)){
					$this->dir = $dir;
					return ftp_chdir($this->connect_id, $dir);
				}
				// Else If it's a file
				else{
				// File name
					$ext = explode('/', $dir);
					$nomFichier = $ext[count($ext)-2];
				// Possible rename..
					$nomFichier = str_replace('[','',$nomFichier);
					$nomFichier = str_replace(']','',$nomFichier);
					$nomFichier = str_replace('(','',$nomFichier);
					$nomFichier = str_replace(')','',$nomFichier);
					$nomFichier = urlencode($nomFichier);
				// Download FTP -> Server HTTP
					if(!$this->download('download/'.$nomFichier, $dir))
						throw new Exception("Can't get the file.");
				// Send from 'US' server to HTTP
					if(!$this->telecharger($nomFichier))
						throw new Exception("Can't get the file.");
				}
			}
			else
				throw new Exception("You must be connect.");
		}


	#################################################
	#												#
	#					CREATE FOLDER				#
	#												#
	#################################################
		public function createFolder($folder){
			if($this->connectionOK)
				return ftp_mkdir($this->connect_id, $folder);
			else
				throw new Exception("You must be connect.");
		}


	#################################################
	#												#
	#					DELETE FILE					#
	#												#
	#################################################
		public function delFile($file){
			if($this->connectionOK)
				return @ftp_delete($this->connect_id, $file);
			else
				throw new Exception("You must be connect.");
			
		}


	#################################################
	#												#
	#					DELETE FOLDER				#
	#												#
	#################################################
		public function delFolder($folder){
			if($this->connectionOK)
				return ftp_rmdir($this->connect_id, $folder);
			else
				throw new Exception("You must be connect.");
		}


	#################################################
	#												#
	#					RENAMME						#
	#												#
	#################################################
		public function renameIt($ancien,$nouveau){
			if($this->connectionOK){
				if(is_dir($ancien)){
					if($extension = !strrchr($nouveau, '.'))
						return ftp_rename($this->connect_id, $ancien, $nouveau);
					else
						throw new Exception("Forbidden to rename a folder with an extention.");
				}
				elseif(!is_dir($this->ancien)){
					if($extension = strrchr($this->nouveau, '.'))
						return ftp_rename($this->connect_id, $ancien, $nouveau);
					else
						throw new Exception("Forbidden to rename a file without an extention.");
				}
			}
			else
				throw new Exception("You must be connect.");
		}

	#################################################
	#												#
	#					DOWNLOAD					#
	#												#
	#################################################
		private function telecharger($fichierdistant){
			switch(strrchr(basename($fichierdistant), '.')){
				case '.gz': $type = 'application/x-gzip'; break;
				case '.tgz': $type = 'application/x-gzip'; break;
				case '.zip': $type = 'application/zip'; break;
				case '.pdf': $type = 'application/pdf'; break;
				case '.png': $type = 'image/png'; break;
				case '.gif': $type = 'image/gif'; break;
				case '.jpg': $type = 'image/jpeg'; break;
				case '.txt': $type = 'text/plain'; break;
				case '.htm': $type = 'text/html'; break;
				case '.html': $type = 'text/html'; break;
				default: $type = 'application/octet-stream'; break;
			}
			header("Content-Type: application/force-download\n");
			header("Content-Transfer-Encoding: $type\n");
			header("Content-Length: ".filesize($fichierdistant)."\n");
			header("Content-Disposition: attachment; filename=$fichierdistant\n");
			readfile('download/'.$fichierdistant);
		}




	#################################################
	#												#
	#				GET THE FILE TO SERVER 			#
	#												#
	#################################################
		private function download($fichierlocal, $fichierdistant){
			if($this->connectionOK)
				return ftp_get($this->connect_id, $fichierlocal, $fichierdistant, FTP_BINARY);
			else
				throw new Exception("You must be connect.");
		}


	#################################################
	#												#
	#					UPLOAD	    				#
	#												#
	#################################################
		public function upload($fichierdistant, $fichierlocal){
			if($this->connectionOK)
				return ftp_put($this->connect_id, $fichierdistant, $fichierlocal, FTP_BINARY);
			else
				throw new Exception("You must be connect.");
		}


	#################################################
	#												#
	#					GET THE SIZE				#
	#												#
	#################################################
		public function taille($file){
			if($this->connectionOK)
				return ftp_size($this->connect_id, $file);
			else
				throw new Exception("You must be connect.");
		}

	#################################################
	#												#
	#					GET THE SIZE 2				#
	#												#
	#################################################
		public function taille2($taille){
			if($this->connectionOK){
				if ($taille >= 1073741824) // octets-> 1 Go
					$taille = round($taille / 1073741824 * 100) / 100 .' Go';
				elseif ($taille >= 1048576) // octets-> 1 Mo
					$taille = round($taille / 1048576 * 100) / 100 .' Mo';
				elseif ($taille >= 1024) // octets-> 1 ko
					$taille = round($taille / 1024 * 100) / 100 .' Ko';
				else
					$taille = $taille.' octets';
				if($taille == 0)
					$taille ='-';
				return $taille;
			}
			else
				throw new Exception("You must be connect.");
		}

	#################################################
	#												#
	#					QUIT/CLOSE					#
	#												#
	#################################################
		public function closit(){
			ftp_quit($this->connect_id);
			session_destroy();
		}


}
?>