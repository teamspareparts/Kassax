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

// Yritys
$db->query(
	"INSERT INTO yritys (y_tunnus, yritystunniste, nimi) VALUES (?,?,?)",
	[   $config['Admin']['y_tunnus'],
		$config['Admin']['y_yritystunniste'],
		$config['Admin']['y_nimi']
	]);

// Admin tunnukset
// TODO: Kesken
/*
$db->prepare_stmt( "INSERT INTO kayttaja (yritys_id, user, pass) VALUES (1, ?, ?)");
for ( $i=0; $i<count( $config['Admin']['kayttajatunnus']); $i++ ) {
	$db->run_prepared_stmt([
		$config['Admin']['kayttajatunnus'][$i],
		password_hash( $config['Admin']['salasana'][$i], PASSWORD_DEFAULT)
	]);
}
*/

echo '<p>Tietokannan asennus on nyt suoritettu.</p>';
