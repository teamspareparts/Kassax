<?php declare(strict_types=1);
error_reporting(E_ERROR);ini_set('display_errors',"1");
set_include_path(get_include_path().PATH_SEPARATOR.'luokat/');spl_autoload_extensions('.class.php');spl_autoload_register();
if(!empty($_POST)){debug($_POST);}if(!empty($_GET)){debug($_GET);}
function debug($var,bool$var_dump=false){
	echo"<br>\r\n<pre>Print_r ::<br>\r\n";print_r($var);echo"</pre>";
	if($var_dump){echo"<br><pre>Var_dump ::<br>\r\n";var_dump($var);echo"</pre><br>\r\n";};
}
function debugC($var,bool$var_dump=false){
	echo"\r\nPrint_r ::\r\n";print_r($var);
	if($var_dump){echo"Var_dump ::\r\n";var_dump($var);echo"\r\n";};
}
print('<pre>');
//$db = new DByhteys($val=['localhost','test','root','']);
$db = new DByhteys();


