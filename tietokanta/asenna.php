<?php declare(strict_types=1);
error_reporting(E_ERROR);
ini_set('display_errors', "1");
print("<pre>");

$config = parse_ini_file( "../cfg/config.ini.php", true);
require '../luokat/dbyhteys.class.php';

$db = new DByhteys( $config['Tietokanta'] );
$f = file('./tietokanta.sql', FILE_IGNORE_NEW_LINES); // Tietokannan taulut

// Poistetaan .sql-tiedoston kommentit
foreach ( $f as $k => $v ) {
	$f[$k] = strstr($v, '--', true) ?: $v;
}

// Muunnetaan jokainen query omaan indexiin
$db_file = explode( ";", implode("", $f) );
foreach ( $db_file as $sql ) {
	if ( !empty($sql) && strlen($sql) > 5 ) {
		$db->query( $sql );
	}
}

echo '<p>Tietokannan asennus on nyt suoritettu.</p>';
