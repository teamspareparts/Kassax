<?php declare(strict_types=1);

require '../luokat/dbyhteys.class.php';

$db = new DByhteys( [], '../cfg/config.ini.php');

$lang_strings = [
	'fin' , 'login' , 'HTML_TITLE'		, 'Kirjautuminen' ,

	'fin' , 'login' , 'LOGIN_FS_LEGEND'	, 'Sisäänkirjautuminen' ,
	'fin' , 'login' , 'LOGIN_YRIT'		, 'Yritystunnus' ,
	'fin' , 'login' , 'LOGIN_YRIT_PH'	, 'Yrityksen kirjautumistunnus' ,
	'fin' , 'login' , 'LOGIN_USER'		, 'Käyttäjätunnus' ,
	'fin' , 'login' , 'LOGIN_USER_PH'	, 'Käyttäjätunnus' ,
	'fin' , 'login' , 'LOGIN_PASS'		, 'Salasana' ,
	'fin' , 'login' , 'LOGIN_PASS_PH'	, 'Salasana' ,
	'fin' , 'login' , 'LOGIN_BUTTON'	, 'Kirjaudu sisään' ,
	'fin' , 'login' , 'LANG_FS_LEGEND'	, 'Kieli' ,

	'fin' , 'login' , 'ERR1_FS_HEAD'	, 'Väärät kirjautumistiedot' ,
	'fin' , 'login' , 'ERR1_FS_TEXT'	, 'Varmista, että kirjoitit tiedot oikein.' ,
	'fin' , 'login' , 'ERR2_FS_HEAD'	, 'Väärä yritystunnus' ,
	'fin' , 'login' , 'ERR2_FS_TEXT'	, 'Ditto' ,
	'fin' , 'login' , 'ERR3_FS_HEAD'	, 'Väärä käyttäjätunnus' ,
	'fin' , 'login' , 'ERR3_FS_TEXT'	, 'Ditto' ,
	'fin' , 'login' , 'ERR4_FS_HEAD'	, 'Väärä salasana' ,
	'fin' , 'login' , 'ERR4_FS_TEXT'	, 'Ditto' ,
	'fin' , 'login' , 'ERR5_FS_HEAD'	, 'Käyttäjätili de-aktivoitu' ,
	'fin' , 'login' , 'ERR5_FS_TEXT'	, 'Ditto' ,
	'fin' , 'login' , 'ERR10_FS_HEAD'	, 'Et ole kirjautunut sisään' ,
	'fin' , 'login' , 'ERR10_FS_TEXT'	, 'Sinun pitää kirjautua sisään ennen kuin voit käyttää sivustoa.' ,
	'fin' , 'login' , 'ERR20_FS_HEAD'	, 'Kirjaudutaan ulos' ,
	'fin' , 'login' , 'ERR20_FS_TEXT'	, 'Olet onnistuneesti kirjautunut ulos.' ,
	'fin' , 'login' , 'ERR99_FS_HEAD'	, 'Olet jo kirjautunut sisään.' ,
	'fin' , 'login' , 'ERR99_FS_TEXT1'	, 'Linkki etusivulle' ,
	'fin' , 'login' , 'ERR99_FS_TEXT2'	, 'Kirjaudu ulos' ,

	'fin' , 'login' , 'LOGIN_YRIT_PH'	, 'Yrityksen kirjautumistunnus' ,
	'fin' , 'login' , 'LOGIN_USER'		, 'Käyttäjätunnus' ,
	'fin' , 'login' , 'LOGIN_USER_PH'	, 'Käyttäjätunnus' ,
	'fin' , 'login' , 'LOGIN_PASS'		, 'Salasana' ,
	'fin' , 'login' , 'LOGIN_PASS_PH'	, 'Salasana' ,
	'fin' , 'login' , 'LOGIN_BUTTON'	, 'Kirjaudu sisään' ,
	'fin' , 'login' , 'LANG_FS_LEGEND'	, 'Kieli' ,

	'fin' , 'login' , 'HTML_TITLE'		, 'Kirjautuminen' ,

	'eng' , 'login' , 'LOGIN_FS_HEAD'	, 'Login' ,
	'eng' , 'login' , 'LOGIN_YRIT'		, 'Company' ,
	'eng' , 'login' , 'LOGIN_YRIT_PH'	, 'Company account' ,
	'eng' , 'login' , 'LOGIN_USER'		, 'User' ,
	'eng' , 'login' , 'LOGIN_USER_PH'	, 'User account' ,
	'eng' , 'login' , 'LOGIN_PASS'		, 'Password',
	'eng' , 'login' , 'LOGIN_PASS_PH'	, 'Password' ,
	'eng' , 'login' , 'LOGIN_BUTTON'	, 'Login' ,
	'eng' , 'login' , 'LANG_FS_LEGEND'	, 'Language' ,

	'eng' , 'login' , 'ERR1_FS_HEAD'	, 'Wrong login informationt' ,
	'eng' , 'login' , 'ERR1_FS_TEXT'	, 'Please check that you wrote the correct information.' ,
	'eng' , 'login' , 'ERR2_FS_HEAD'	, 'Wrong company account' ,
	'eng' , 'login' , 'ERR2_FS_TEXT'	, 'Ditto' ,
	'eng' , 'login' , 'ERR3_FS_HEAD'	, 'Wrong user account' ,
	'eng' , 'login' , 'ERR3_FS_TEXT'	, 'Ditto' ,
	'eng' , 'login' , 'ERR4_FS_HEAD'	, 'Wrong password' ,
	'eng' , 'login' , 'ERR4_FS_TEXT'	, 'Ditto' ,
	'eng' , 'login' , 'ERR5_FS_HEAD'	, 'User account de-activated' ,
	'eng' , 'login' , 'ERR5_FS_TEXT'	, 'Ditto' ,
	'eng' , 'login' , 'ERR10_FS_HEAD'	, 'You are not logged in' ,
	'eng' , 'login' , 'ERR10_FS_TEXT'	, 'You need to log in before using the site.' ,
	'eng' , 'login' , 'ERR20_FS_HEAD'	, 'Logging out' ,
	'eng' , 'login' , 'ERR20_FS_TEXT'	, 'You have succesfully logged out.' ,
	'eng' , 'login' , 'ERR99_FS_HEAD'	, 'You are already logged in' ,
	'eng' , 'login' , 'ERR99_FS_TEXT1'	, 'Link to front page' ,
	'eng' , 'login' , 'ERR99_FS_TEXT2'	, 'Log out' ,
];


$sql = "
	INSERT IGNORE INTO lang ( lang, sivu, tyyppi, teksti )
	VALUES ( ?,?,?,? )
";

$kysymysmerkit = str_repeat(',(?,?,?,?)', ((count($lang_strings)/4)-1));

$sql .= $kysymysmerkit;

$db->query( $sql, $lang_strings );
