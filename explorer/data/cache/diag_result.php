<?php $diagResults = array (
  'Client' => 'Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36',
  'Command Line Available' => 'Yes',
  'DOM Enabled' => 'Yes',
  'GD Enabled' => 'No',
  'Upload Max Size' => '800M',
  'Memory Limit' => '2740M',
  'Max execution time' => '60000',
  'Safe Mode' => '0',
  'Safe Mode GID' => '0',
  'Xml parser enabled' => '1',
  'MCrypt Enabled' => 'No',
  'Serveur OS' => 'WINNT',
  'Session Save Path' => '',
  'PHP Version' => '5.2.6',
  'PHP APC extension loaded' => 'Yes',
  'PHP Output Buffer disabled' => 'Yes',
  'Upload Tmp Dir Writeable' => true,
  'PHP Upload Max Size' => 838860800,
  'PHP Post Max Size' => 838860800,
  'Users enabled' => true,
  'Guest enabled' => false,
  'Writeable Folders' => '[<b>cache</b>:true,<br> <b>data</b>:true]',
  'Zlib Enabled' => 'Yes',
);$outputArray = array (
  0 => 
  array (
    'name' => 'AjaXplorer version',
    'result' => false,
    'level' => 'info',
    'info' => 'AJXP version : 5.0.0',
  ),
  1 => 
  array (
    'name' => 'Client Browser',
    'result' => false,
    'level' => 'info',
    'info' => 'Current client Mozilla/5.0 (Windows NT 6.1) AppleWebKit/537.36 (KHTML, like Gecko) Chrome/28.0.1500.71 Safari/537.36',
  ),
  2 => 
  array (
    'name' => 'PHP Command Line',
    'result' => true,
    'level' => 'warning',
    'info' => 'Php command line detected, but using the windows COM extension. Just make sure to <b>enable COM</b> in the AjaXplorer Core Options',
  ),
  3 => 
  array (
    'name' => 'DOM Xml enabled',
    'result' => true,
    'level' => 'error',
    'info' => 'Dom XML is required, you may have to install the php-xml extension.',
  ),
  4 => 
  array (
    'name' => 'PHP error level',
    'result' => false,
    'level' => 'info',
    'info' => 'E_ERROR | E_WARNING | E_PARSE | E_CORE_ERROR | E_CORE_WARNING | E_COMPILE_ERROR | E_COMPILE_WARNING | E_USER_ERROR | E_USER_WARNING | E_USER_NOTICE',
  ),
  5 => 
  array (
    'name' => 'PHP GD version',
    'result' => false,
    'level' => 'warning',
    'info' => 'GD is required for generating thumbnails',
  ),
  6 => 
  array (
    'name' => 'PHP Limits variables',
    'result' => false,
    'level' => 'info',
    'info' => '<b>Testing configs</b>
Upload Max Size=800M
Memory Limit=2740M
Max execution time=60000
Safe Mode=0
Safe Mode GID=0
Xml parser enabled=1',
  ),
  7 => 
  array (
    'name' => 'MCrypt enabled',
    'result' => false,
    'level' => 'warning',
    'info' => 'MCrypt is required for generating publiclets',
  ),
  8 => 
  array (
    'name' => 'PHP operating system',
    'result' => false,
    'level' => 'info',
    'info' => 'Current operating system WINNT',
  ),
  9 => 
  array (
    'name' => 'PHP Session',
    'result' => false,
    'level' => 'warning',
    'info' => 'Warning, it seems that your temporary folder used to save session data is not set. If you are encountering troubles with logging and sessions, please check session.save_path in your php.ini. Otherwise you can ignore this.',
  ),
  10 => 
  array (
    'name' => 'PHP version',
    'result' => false,
    'level' => 'error',
    'info' => 'Minimum required version is PHP 5.3.0',
  ),
  11 => 
  array (
    'name' => 'PHP APC extension',
    'result' => true,
    'level' => 'warning',
    'info' => 'PHP APC extension detected, this is good for better performances',
  ),
  12 => 
  array (
    'name' => 'PHP Output Buffer disabled',
    'result' => true,
    'level' => 'warning',
    'info' => 'PHP Output Buffering is disabled, this is good for better performances',
  ),
  13 => 
  array (
    'name' => 'SSL Encryption',
    'result' => false,
    'level' => 'warning',
    'info' => 'You are not using SSL encryption, or it was not detected by the server. Be aware that it is strongly recommended to secure all communication of data over the network.<p class=\'suggestion\'><b>Suggestion</b> : if your server supports HTTPS, set the AJXP_FORCE_REDIRECT_HTTPS parameter in the <i>conf/bootstrap_conf.php</i> file.</p>',
  ),
  14 => 
  array (
    'name' => 'Server charset encoding',
    'result' => true,
    'level' => 'error',
    'info' => 'You must set a correct charset encoding in your locale definition in the form: en_us.UTF-8. Please refer to setlocale man page. If your detected locale is C, please check the <a href="http://www.ajaxplorer.info/wordpress/documentation-3/chapter-faq/#toc-i-have-a-warning-concerning-the-character-encoding-when-i-first-start-ajaxplorer-what-should-i-do">F.A.Q.</a>. ',
  ),
  15 => 
  array (
    'name' => 'Upload particularities',
    'result' => false,
    'level' => 'info',
    'info' => '<b>Testing configs</b>
Upload Tmp Dir Writeable=1
PHP Upload Max Size=838860800
PHP Post Max Size=838860800',
  ),
  16 => 
  array (
    'name' => 'Users Configuration',
    'result' => false,
    'level' => 'info',
    'info' => 'Current config for users',
  ),
  17 => 
  array (
    'name' => 'Required writeable folder',
    'result' => false,
    'level' => 'info',
    'info' => '[<b>cache</b>:true,<br><b>data</b>:true]',
  ),
  18 => 
  array (
    'name' => 'Zlib extension (ZIP)',
    'result' => false,
    'level' => 'info',
    'info' => 'Extension enabled : 1',
  ),
  19 => 
  array (
    'name' => 'Filesystem Plugin
 Testing repository : Common Files',
    'result' => true,
    'level' => 'error',
    'info' => '',
  ),
  20 => 
  array (
    'name' => 'Filesystem Plugin
 Testing repository : My Files',
    'result' => true,
    'level' => 'error',
    'info' => '',
  ),
); ?>